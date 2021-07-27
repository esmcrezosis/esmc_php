<?php
class EuProprietaireController extends  Zend_Controller_Action {
    
      public function init() {
             
             $menu = "<li><a id=\"new\" href=\"/eu-proprietaire/new\">Nouveau</a></li>".
                     "<li><a id=\"new\" href=\"/eu-proprietaire/index\">Liste</a></li>";
          
             $this->view->placeholder("menu")->set($menu);
             $this->view->jQuery()->enable();
             $this->view->jQuery()->uiEnable(); 
      }
    
      function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            if ($user->code_groupe != 'ag_m') {
               $this->view->user = $user;
               return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }
   
    public function membreAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $select->where('type_membre like ?','p');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[0] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
    
    
    public function dataAction()  {
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 200000);
           $sidx = $this->_request->getParam("sidx", 'id_proprietaire');
           $sord = $this->_request->getParam("sord", 'desc');
           
           $request = $this->getRequest();
           $membre = $request->membre;
           
           $tabela = new Application_Model_DbTable_EuProprietaire();
           $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           if ($membre != "") {
           $select->setIntegrityCheck(false)
                  ->join('eu_membre', 'eu_membre.code_membre = eu_proprietaire.code_membre_pro')
                  ->order('eu_proprietaire.id_proprietaire desc')
                  ->where('eu_proprietaire.code_membre_pro = ?', $membre) 
                  ->where('eu_proprietaire.id_utilisateur = ?', $user->id_utilisateur);
           }
           else {
           $select->setIntegrityCheck(false)
                  ->join('eu_membre', 'eu_membre.code_membre = eu_proprietaire.code_membre_pro')
                  ->order('eu_proprietaire.id_proprietaire desc') 
                  ->where('eu_proprietaire.id_utilisateur = ?', $user->id_utilisateur);
           }
           $proprio = $tabela->fetchAll($select);
           $count = count($proprio);
           if ($count > 0) {
              $total_pages = ceil($count / $limit);
           } 
           else 
           {
             $total_pages = 0;
           }
           if ($page > $total_pages)
              $page = $total_pages;
              $contrats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
              $responce['page'] = $page;
              $responce['total'] = $total_pages;
              $responce['records'] = $count;
              $i = 0;
              foreach ($contrats as $row) {
                 $datedeclaration = new Zend_Date($row->date_declaration, Zend_Date::ISO_8601);
                 $responce['rows'][$i]['id'] = $row->id_proprietaire;
                 $responce['rows'][$i]['cell'] = array(
                     $row->code_membre_ag,
                     $row->code_membre_pro,
                     $row->nom_membre."    ".$row->prenom_membre,
                     $datedeclaration->toString('dd/mm/yyyy'),
                     $row->nbre_maison
            );
            $i++;
        }      
        $this->view->data = $responce;   
    }
    
    public function newAction() {
        
    }
   
    
    public function editAction()  { 
       $this->_helper->layout->disableLayout();
       $request = $this->getRequest();
       $num_membre = $request->membre;
       $tabela = new Application_Model_DbTable_EuProprietaire();
       $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           
       $select->setIntegrityCheck(false)
              ->join('eu_membre', 'eu_membre.code_membre = eu_proprietaire.code_membre_pro')
              ->where('eu_proprietaire.id_proprietaire = ?', $num_membre);
       $proprio = $tabela->fetchAll($select);
       foreach ($proprio as $row) {
               $this->view->id_proprio =  $row->id_proprietaire;
               $this->view->code_membre =  $row->code_membre_pro;
               $this->view->nom_membre  =  $row->nom_membre."    ".$row->prenom_membre;
               $this->view->nbre =  $row->nbre_maison;
       }      
        
    }
    
     public function modifierAction() {
         
            $request = $this->getRequest();
            $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
            $code_membre_ag = $user->code_membre;
            $date = new Zend_Date(Zend_Date::ISO_8601);
            
            if ($request->isPost()) {
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
               try {
                    $id = $request->id_proprio;
                    $code_membre = $request->code_membre;
                    $nbre = $request->nbre;
                    $pro = new Application_Model_EuProprietaire();
                    $mapper = new Application_Model_EuProprietaireMapper();
                    $pro->setId_proprietaire($id)
                        ->setCode_membre_pro($code_membre)
                        ->setCode_membre_ag($code_membre_ag)   
                        ->setDate_declaration($date->toString('yyyy-mm-dd'))
                        ->setNbre_maison($nbre)   
                        ->setId_utilisateur($user->id_utilisateur);
                  $mapper->update($pro);
                  $db->commit();
                  $this->view->data = true;
                  return;
                   
                   
               } 
               catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getTraceAsString();
                return;
              } 
                
                
                
            }
         
     }
    
    
     public function saveAction() {

       $request = $this->getRequest();
       $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
       $code_membre_ag = $user->code_membre;
       
       if ($request->isPost()) {
           
          $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try {
              $code_membre = $request->code_membre;
              $nbre = $request->nbre;
              //$tpro = new Application_Model_DbTable_EuProprietaire();
              $pro = new Application_Model_EuProprietaire();
              $mapper = new Application_Model_EuProprietaireMapper();
              $result = $mapper->findpro($code_membre,$code_membre_ag);
              $date = new Zend_Date(Zend_Date::ISO_8601);
               //$code_activite = array("ai");
              //$tab_acteur = new Application_Model_DbTable_EuActeur();
              //$select = $tab_acteur->select();
              //$select->where('code_membre like ?',$code_membre);
                     //->where('code_activite in (?)', $code_activite);
              //$acteurs = $tab_acteur->fetchAll($select);
              $date = new Zend_Date(Zend_Date::ISO_8601); 
              //if (count($acteurs) < 1) {
              //   $this->view->data = 'Cet acteur n\'a pas un profil d\'agence immobilière  !!! ';
              //   $db->rollback();
              //   return; 
              //}
              if ($result == null) {
                  $pro->setCode_membre_pro($code_membre)
                      ->setCode_membre_ag($code_membre_ag)   
                      ->setDate_declaration($date->toString('yyyy-mm-dd'))
                      ->setNbre_maison($nbre)   
                      ->setId_utilisateur($user->id_utilisateur);
                  $mapper->save($pro);
                  $db->commit();
                  $this->view->data = true;
                  return;  
               }
               else {
                    $this->view->data = 'Ce propriétaire est déjà lié à cette agence immobilière !!!';
                    $db->rollback();
                    return;
              }     
          }
          catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getTraceAsString();
		$this->view->data = false;
                return;
          }
             
       } 
            
    }
    
    
    
    
}
?>
