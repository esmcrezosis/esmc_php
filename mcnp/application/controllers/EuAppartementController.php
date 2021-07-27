<?php

class EuAppartementController extends Zend_Controller_Action {

      public function init() {
          
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'ag_m') {
           $menu = "<li><a id=\"new\" href=\"/eu-appartement/new\">Nouveau</a></li>".
                   "<li><a id=\"liste\" href=\"/eu-appartement/index\">Listes</a></li>" .
                   "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
           $this->view->placeholder("menu")->set($menu);
           $this->view->jQuery()->enable();
           $this->view->jQuery()->uiEnable();
          
        }   
      }

      function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($user->code_agence == null) {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            if ($group != 'ag_m') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
    
    
    public function indexAction() {
        
    }
 
    
    public function newAction() {
        
    }

    
    public function maisonAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMaison();
        //$select = $mb->select();
        //$select->where('type_membre like ?','p');
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    
    public function recupnomAction() {
           $num_membre = $_GET['num_membre'];
           $maison_db = new Application_Model_DbTable_EuMaison();
           $select = $maison_db->select();
           $select->where('code_membre like ?',$num_membre);
           $result = $maison_db->fetchAll($select);
           foreach ($result as $p) {
              $data[0] = strtoupper($p->designation);
          }
           $this->view->data = $data;
    }
    
    public function dataAction() {
        
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 200000);
           $sidx = $this->_request->getParam("sidx", 'id_appartement');
           $sord = $this->_request->getParam("sord", 'desc');
           
           $tabela = new Application_Model_DbTable_EuAppartement();
           $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
                  ->join('eu_maison', 'eu_maison.id_maison = eu_appartement.id_maison')
                  ->where('eu_appartement.id_utilisateur = ?',$user->id_utilisateur);
        
           $appart = $tabela->fetchAll($select);
           $count = count($appart);
           if ($count > 0) {
            $total_pages = ceil($count / $limit);
           } 
           else 
           {
            $total_pages = 0;
           }
           if ($page > $total_pages)
            $page = $total_pages;
            $appart = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($appart as $row) {
            //$date = new Zend_Date($row->date_contrat, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_appartement;
            $responce['rows'][$i]['cell'] = array(
                //$row->code_appartement,
                $row->code_membre,
                //$datecontrat->toString('dd/mm/yyyy'),
                $row->type_appartement,
                $row->prix_location,
                $row->nb_piece
            );
            $i++;
        }      
        $this->view->data = $responce;
        
        
    }
    
    public function saveAction() {
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           if ($this->getRequest()->isPost()) { 
              $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;    
              $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
              try {
                   $appart = new Application_Model_EuAppartement();
                   $mapper = new Application_Model_EuAppartementMapper();
                   $id_maison= $mapper->findid_maison($_POST["code_membre"]);
               
                   $appart->setId_maison($id_maison);
                   $appart->setType_appartement($_POST["type_appart"]);
                   if(isset($_POST['wd'])) {
                           $appart->setWc_douche_interne($_POST['wd']);
                   }
                   else {
                           $appart->setWc_douche_interne(0);    
                   }
                   if(isset($_POST['terasse'])) {
                           $appart->setTerasse($_POST['terasse']);
                   }
                   else {
                           $appart->setTerasse(0);    
                   }
                   if(isset($_POST['cuisine'])) {
                           $appart->setCuisine($_POST['cuisine']);
                   }
                   else {
                           $appart->setCuisine(0);    
                   }
                   if(isset($_POST['garage'])) {
                           $appart->setGarage($_POST['garage']);
                   }
                   else {
                           $appart->setGarage(0);    
                   }
                   
                   //$appart->setCode_appartement($_POST["code_appart"]);
                   $appart->setPrix_location($_POST["prix_location"]);
                   $appart->setStatut(0);
                   $appart->setNb_piece($_POST["nbre"]);
                   $appart->setDesc_appart($_POST["desc_appart"]);
                   $appart->setId_utilisateur($user->id_utilisateur);
                   $appart->setHeure_enregistrement($date_idd->toString('hh:mm:ss'));
                   $appart->setDate_enregistrement($date_idd->toString('yyyy-mm-dd'));    
                   $mapper->save($appart);
                   
                   
                   $db->commit();
                   $this->view->data = true;
                   return;
           }
           catch (Exception $exc) {
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();   
           } 
       }
     
   }
}
?>