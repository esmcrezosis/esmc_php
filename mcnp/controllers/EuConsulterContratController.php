<?php
     class EuConsulterContratController extends Zend_Controller_Action  {
         
         
     public function init() {
         $this->view->jQuery()->enable();
         $this->view->jQuery()->uiEnable();   
     }
      
     function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } 
        else 
        {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'contrat') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }  
    }
    
    public function indexAction() {
        
    }
 
    public function nloginAction() {
         
        $user = array();
        $tab = new Application_Model_DbTable_EuUtilisateur();
        $sel = $tab->select();
        $sel->where('code_groupe=?', 'cm');
        $sel->order('login', 'asc');
        $nuser = $tab->fetchAll($sel);
        $i = 0;
        foreach ($nuser as $value) {
            $user[$i][1] = $value->id_utilisateur;
            $user[$i][2] = ucfirst($value->login);
            $i++;
        }
        $this->view->data = $user;
       
    }
     
 
 
    public function dataAction() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 200000);
        $sidx = $this->_request->getParam("sidx", 'id_contrat');
        $sord = $this->_request->getParam("sord", 'desc');
        
        //if (isset($_GET["membre"])) $membre = $_GET["membre"];
        $request = $this->getRequest();
        $code_membre = $request->code_membre;
        $raison_sociale = $request->raison_sociale;
        $nom = $request->nom;
        $prenom = $request->prenom;
		$id_utilisateur = $request->id_utilisateur;
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $tabela = new Application_Model_DbTable_EuContrat();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        
        if($code_membre !="")
        {
            $select->setIntegrityCheck(false)
                   ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
                   ->where('eu_contrat.code_membre = ?',$code_membre);   
        }
		
        else if($raison_sociale !="") {
            $select->setIntegrityCheck(false)
                   ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
                   ->where('eu_membre.raison_sociale like ?',$raison_sociale.'%');
        }
        else if($nom !="") {
            $select->setIntegrityCheck(false)
                   ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
                   ->where('eu_membre.nom_membre like ?',$nom.'%');
        }
        else if($prenom !="") {
             $select->setIntegrityCheck(false)
                   ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
                   ->where('eu_membre.prenom_membre like ?',$prenom.'%');
        }
        else if($nom !="" && $prenom !="") {
             $select->setIntegrityCheck(false)
                    ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
                    ->where('eu_membre.nom_membre like ?',$nom.'%')  
                    ->where('eu_membre.prenom_membre like ?',$prenom.'%');
        }
				
		else  if ($date_deb != '' && $date_fin != '' && $id_utilisateur != '')  {
		      $date_debut = explode('/', $date_deb);
              $date1 = $date_debut[2] . "-" . $date_debut[1] . "-" . $date_debut[0];
              $date_end = explode('/', $date_fin);
              $date = $date_end[2] . "-" . $date_end[1] . "-" . $date_end[0];
			  if($date == $date1) {
			  
			  $select->setIntegrityCheck(false)
                         ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
                         ->where('eu_contrat.date_contrat = ?',$date)
						 ->where('eu_contrat.id_utilisateur = ?',$id_utilisateur)
						 ;
			  }
			  else
			  {
			  $select->setIntegrityCheck(false)
                     ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
				     ->where('eu_contrat.date_contrat >= ?',$date1)
                     ->where('eu_contrat.date_contrat <= ?',$date)
					 ->where('eu_contrat.id_utilisateur = ?',$id_utilisateur);    
			  }		      
        }
		
        
        $contrats = $tabela->fetchAll($select);
        $count = count($contrats);
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
            $datecontrat = new Zend_Date($row->date_contrat, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_contrat;
            $responce['rows'][$i]['cell'] = array(
                $row->id_contrat,
                $row->code_membre,
                $datecontrat->toString('dd/mm/yyyy'),
                $row->nature_contrat,
                $row->type_membre,
            ); 
            $i++;
        }      
        $this->view->data = $responce;
     }
  }
  
?>