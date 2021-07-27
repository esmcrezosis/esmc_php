<?php

class EuContratController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;

        if ($group == 'cm' or $group == 'dg' or $group == 'dist') {
           $menu =  
		           "<li><a id=\"\" href=\"/eu-contrat/index\" style=\"font-size:11px\">Liste des contrats</a></li>";
            $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'cmm') {
            $menu = "<li><a id=\"new\" href=\"/eu-membre/newpm\" style=\"font-size:12px\">Ajout MM</a></li>" .
                    "<li><a id=\"morale\" href=\"#\" style=\"font-size:12px\">Personnes morales</a></li>";
            $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'cmp') {
            $menu = "<li><a id=\"new\" href=\"/eu-membre/new\" style=\"font-size:12px\">Ajout MP</a></li>" .
			        "<li><a id=\"new\" href=\"/eu-contrat/newpp\" style=\"font-size:11px\">Demande</a></li>".
                    "<li><a id=\"physique\" href=\"#\" style=\"font-size:12px\">Personnes physiques</a></li>";
            $this->view->placeholder("menu")->set($menu);
        } elseif ($group == 'caps' or $group == 'bnp') {
            $menu = '<li><a id="caps" href="/eu-bnp/caps" style=\"font-size:11px\">CAPS</a></li>
			        <li><a href="/eu-contrat/index" style="font-size:11px\">Liste des contrats</a></li>';
                //<li><a id="listes" href="/eu-bnp/listes" style=\"font-size:12px\">Vue des bnp</a></li>
                //<li><a id="new" href="/eu-contrat/new" style=\"font-size:12px\">Ajout de contrats</a></li>';
            $this->view->placeholder("menu")->set($menu);
        } elseif ($group == 'mise_chaine' or  $group == 'filiere'  or  $group == 'gacd'  or  $group == 'gacs' or  $group == 'gacex'
		      or $group == 'scmacnev' or  $group == 'technopole' or  $group == 'productiong' or  $group == 'productionsg' or  $group == 'productiond' or $group == 'transformationg' or  $group == 'transformationsg' or  $group == 'transformationd' or  $group == 'distributiong'
		      or $group == 'distributionsg' or  $group == 'distributiond' or  $group == 'gacdm'  or  $group == 'gacsm' or  $group == 'gacexm'
			  or  $group == 'gacdz'  or  $group == 'gacsz' or  $group == 'gacexz'
			  or  $group == 'gacdp'  or  $group == 'gacsp' or  $group == 'gacexp'
			  or  $group == 'scmdd' or  $group == 'scmsgd' or  $group == 'scmgd'
			   or  $group == 'scmds' or  $group == 'scmsgs' or  $group == 'scmgs'
			   or  $group == 'scmdex' or  $group == 'scmsgex' or  $group == 'scmgex'
			  or  $group == 'gacdregion' or  $group == 'gacdsecteur' or  $group == 'gacdagence'
			  or  $group == 'gacsregion' or  $group == 'gacssecteur' or  $group == 'gacsagence'
			  or  $group == 'gacexregion' or  $group == 'gacexsecteur' or  $group == 'gacexagence' 
			  or  $group == 'scmpmaoe' or  $group == 'scmpmaose' or  $group == 'scmpmam' or  $group == 'scmpmapbf') {
              $menu = '<li><a id="listes" href="/eu-contrat/consultation" style="font-size:11px">Consultation</a></li>';
            $this->view->placeholder("menu")->set($menu);
		} elseif ($group == 'scmd' or  $group == 'scmsg' or  $group == 'scmg' or  $group == 'scmgm' or  $group == 'scmsgm' or  $group == 'scmdm' or  $group == 'scmgpbf' or  $group == 'scmdpbf' or  $group == 'scmsgpbf'
		          ) {
            $menu = '<li><a id="listes" href="/eu-contrat/consultation" style="font-size:11px">Consultation</a></li>';
            $this->view->placeholder("menu")->set($menu);
		}
            $this->view->jQuery()->enable();
            $this->view->jQuery()->uiEnable();
		
 }

 
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } 
        else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'bnp' and $group != 'caps' and $group != 'cm' and $group != 'cmm' and $group != 'cmp' and $group != 'dg' and $group != 'dist' and $group != 'mise_chaine' and  $group != 'gacd' and  $group != 'gacs' and  $group != 'gacex'
			and  $group != 'filiere' and  $group != 'scmacnev' and  $group != 'technopole' and  $group != 'productiong' and  $group != 'productionsg' and  $group != 'productiond'
		    and  $group != 'transformationg' and  $group != 'transformationsg' and  $group != 'transformationd' and  $group != 'distributiong'
		    and  $group != 'distributionsg' and  $group != 'distributiond' and  $group != 'scmd' and  $group != 'scmsg' and  $group != 'scmg' and  $group != 'scmgm' and  $group != 'scmsgm' and  $group != 'scmdm' and  $group != 'scmdpbf' and  $group != 'scmsgpbf' and  $group != 'scmgpbf'
			and  $group != 'gacdm' and  $group != 'gacsm' and  $group != 'gacexm'
			and  $group != 'gacdz' and  $group != 'gacsz' and  $group != 'gacexz'
			and  $group != 'gacdp' and  $group != 'gacsp' and  $group != 'gacexp'
			and  $group != 'scmdd' and  $group != 'scmsgd' and  $group != 'scmgd'
			and  $group != 'scmds' and  $group != 'scmsgs' and  $group != 'scmgs'
			and  $group != 'scmdex' and  $group != 'scmsgex' and  $group != 'scmgex'
			and  $group != 'gacdregion' and  $group != 'gacdsecteur' and  $group != 'gacdagence'
			and  $group != 'gacsregion' and  $group != 'gacssecteur' and  $group != 'gacsagence'
			and  $group != 'gacexregion' and  $group != 'gacexsecteur' and  $group != 'gacexagence'
			and  $group != 'scmpmaoe'and  $group != 'scmpmaose' and  $group != 'scmpmam' and  $group != 'scmpmapbf') {
            $this->view->user = $user;
            return $this->_redirect('index2');
        }
            $this->view->user = $user;
        }
    }
    
    
	
    public function indexAction() {
        
    } 
  
  
    
    public function changeAction() {
        $data = array();
        $membre = new Application_Model_DbTable_EuMembre();
        $select=$membre->select();
        $select->from($membre, array('code_membre'));
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
            $data[] = $m->code_membre;
        }
        $this->view->data = $data;
    }
 
 
    public function dataAction() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $db = Zend_Db_Table::getDefaultAdapter();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 200000);
        $sidx = $this->_request->getParam("sidx",'id_contrat');
        $sord = $this->_request->getParam("sord", 'desc');
        
        //if (isset($_GET["membre"])) $membre = $_GET["membre"];
        $request = $this->getRequest();
        $code_membre = $request->code_membre;
        $tabela = new Application_Model_DbTable_EuContrat();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        if($code_membre !="") {  
            $select->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre',array('eu_contrat.id_contrat','eu_contrat.code_membre','eu_contrat.nature_contrat'))
                 ->where('eu_contrat.code_membre = ?',$code_membre)
                 ->where('eu_contrat.id_utilisateur = ?', $user->id_utilisateur);   
        }
        else {
            
            $select->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre',array('eu_contrat.id_contrat','eu_contrat.code_membre','eu_contrat.nature_contrat'))
                  ->order('eu_contrat.id_contrat desc')
                  ->where('eu_contrat.id_utilisateur = ?', $user->id_utilisateur)
	              //->where('eu_contrat.code_membre like ?','%p')
				  ;
           
        }
        $contrats = $tabela->fetchAll($select);
        $count = count($contrats);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } 
        else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
            $contrats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
            foreach ($contrats as $row) {  
            $datecontrat = new Zend_Date($row->date_contrat);
            $responce['rows'][$i]['id'] = $row->id_contrat;
            $responce['rows'][$i]['cell'] = array(
              $row->id_contrat,
              $row->code_membre,
              $datecontrat->toString('dd/MM/yyyy'),
              $row->nature_contrat
            );
          $i++;
        }      
        $this->view->data = $responce;
    }
   
   
    public function newoseAction() {
	
	}
   
    
    public function newcAction() {
          
    }
    
    
    public function typecontratAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;		
        $gac = array(array());
        $tab = new Application_Model_DbTable_EuTypeContrat();
        $sel = $tab->select();
		if($group == 'productiong' or  $group == 'productionsg' or  $group == 'productiond'
		  or $group == 'transformationg' or  $group == 'transformationsg' or  $group == 'transformationd' or  $group == 'distributiong'
		  or $group == 'distributionsg' or  $group == 'distributiond'){
		    $sel->where('id_type_contrat = ?',3);
		}elseif($group == 'filiere') {
		    $sel->where('id_type_contrat = ?',4);
		}elseif($group == 'scmacnev') {
		    $sel->where('id_type_contrat = ?',5);
		}elseif($group == 'technopole') {
		    $sel->where('id_type_contrat = ?',6);
		}	
        $tgac = $tab->fetchAll($sel);
        $i = 0;
        foreach ($tgac as $value) {
            $gac[$i][1] = $value->id_type_contrat;
            $gac[$i][2] = ucfirst($value->libelle_type_contrat);
            $i++;
        }
        $this->view->data = $gac;
        
    }
   
    
    public function typecreneauAction() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;		
        $creneau = array(array());
        $tab = new Application_Model_DbTable_EuTypeCreneau();
        $sel = $tab->select();
		if($group == 'distributiong' or $group == 'distributionsg' or  $group == 'distributiond') {
		    $sel->where('id_type_creneau = ?',3);
		}elseif($group == 'transformationg' or $group == 'transformationsg' or  $group == 'transformationd') {
		    $sel->where('id_type_creneau = ?',2);
		}elseif($group == 'productiong' or $group == 'productionsg' or  $group == 'productiond') {
		    $sel->where('id_type_creneau = ?',1);
		}
        $tcreneau = $tab->fetchAll($sel);
        $i = 0;
        foreach ($tcreneau as $value) {
             $creneau[$i][1] = $value->id_type_creneau;
             $creneau[$i][2] = ucfirst($value->libelle_type_creneau);
             $i++;
        }
        $this->view->data = $creneau; 
    }
    
    
    public function typeacteurAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        $acteur = array(array());
        $tab = new Application_Model_DbTable_EuTypeActeur();
        $sel = $tab->select();
		if($group == 'transformationd' or $group == 'productiond' or  $group == 'distributiond' or  $group == 'scmd' or  $group == 'scmdm') {
		    $sel->where('id_type_acteur = ?',3);
		} elseif($group == 'transformationsg' or $group == 'productionsg' or  $group == 'distributionsg' or  $group == 'scmsg' or  $group == 'scmsgm') {
		    $sel->where('id_type_acteur = ?',2);
		} elseif($group == 'transformationg' or $group == 'productiong' or  $group == 'distributiong' or  $group == 'scmg' or  $group == 'scmgm') {
		    $sel->where('id_type_acteur = ?',1);
		}
        $tacteur = $tab->fetchAll($sel);
        $i = 0;
        foreach ($tacteur as $value) {
            $acteur[$i][1] = $value->id_type_acteur;
            $acteur[$i][2] = ucfirst($value->lib_type_acteur);
            $i++;
        }
        $this->view->data = $acteur;  
    }
   
   
    
    public function paysAction() {
        
        $pays = array(array());
        $tab = new Application_Model_DbTable_EuPays();
        $sel = $tab->select();
        $tpays = $tab->fetchAll($sel);
        $i = 0;
        foreach ($tpays as $value) {
             $pays[$i][1] = $value->id_pays;
             $pays[$i][2] = ucfirst($value->libelle_pays);
             $i++;
        }
        $this->view->data = $pays;  
    }
   

   

    public function membremAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre_morale;
        }
        $this->view->data = $data;
    }
	
	
	public function membrepAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $result = $mb->fetchAll();
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
              $data[1] = strtoupper($result->nom_membre)."  ".strtoupper($result->prenom_membre) ;
           } else {
              $data = '';
           }
           $this->view->data = $data;    
    }
	
	
	
	
	public function recupraisonAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[1] = strtoupper($result->raison_sociale) ;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
    
	public function donewppAction() {
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
           
           if ($this->getRequest()->isPost()) {
	      $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
	      try {
                  $date_contrat = new Zend_Date(Zend_Date::ISO_8601);
                  $contrat = new Application_Model_EuContrat();
		          $mapper = new Application_Model_EuContratMapper();
		          $id_contrat = $mapper->findConuter() + 1;
                  $date_contrat = clone $date_contrat;
		  $result = $mapper->findByMembre($_POST['code_membre']);
                  
		  if($result != false) {
		     $db->rollBack();
                     $this->view->data = 'Ce membre personne morale ' . $_POST['code_membre'] . ' a deja un type de contrat!!!';
                     return;
		  }
                  
                  // verification de la licence
                  $tfl = new Application_Model_DbTable_EuFl();
                  $code_fl = 'fl-' . $_POST['code_membre'];
                  $find_fl = $tfl->find($code_fl);
		          if (count($find_fl) > 0) {
		             $contrat->setId_contrat($id_contrat);
                     $contrat->setCode_membre($_POST['code_membre']);
                     $contrat->setDate_contrat($date_contrat->toString('yyyy-mm-dd'));
                     $contrat->setNature_contrat($_POST['nature_contrat']);
                     $contrat->setId_type_contrat(null);
                     $contrat->setId_type_creneau(null);
                     $contrat->setId_type_acteur(null);
                     $contrat->setId_pays(null);
                     $contrat->setId_utilisateur($user->id_utilisateur);
                     $contrat->setFiliere(null);
                     $mapper->save($contrat);
                     $db->commit();
                     $this->view->data = true;
                     return;
                  } else {
                      $db->rollBack();
                      $this->view->data = 'Ce membre personne physique ' . $_POST['code_membre'] . ' doit souscrire au contrat de licence avant la demande de contrat !!!';
                      return;      
                  }
              } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->data = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                    return;
              }                          
         }                               
    }
	
	
	
	
	public function donewoseAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
	       if ($this->getRequest()->isPost()) {
		      $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
		      try {
			      $date_contrat = new Zend_Date(Zend_Date::ISO_8601);
                  $contrat = new Application_Model_EuContrat();
				  $mapper = new Application_Model_EuContratMapper();
				  $id_contrat = $mapper->findConuter() + 1;
                  $date_contrat = clone $date_contrat;
				  $result = $mapper->findByMembre($_POST['code_membre']);
				  if($result != false) {
					    $db->rollBack();
                        $this->view->data = 'Ce membre personne morale ' . $_POST['code_membre'] . ' a deja un type de contrat!!!';
                        return;
				  }
					
				  $contrat->setId_contrat($id_contrat);
                  $contrat->setCode_membre($_POST['code_membre']);
                  $contrat->setDate_contrat($date_contrat->toString('yyyy-mm-dd'));
                  $contrat->setNature_contrat(null);
				  $contrat->setId_type_contrat(null);
                  $contrat->setId_type_creneau(null);
                  $contrat->setId_type_acteur($_POST['type_acteur']);
                  $contrat->setId_pays($_POST['pays']);
                  $contrat->setId_utilisateur($user->id_utilisateur);
                  $contrat->setFiliere(''); 
                    
                  $mapper->save($contrat);
				  $db->commit();
                  $this->view->data = true;
                  return;
				  
			  } catch (Exception $exc) {
                      $db->rollback();
                      $this->view->data = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                      return;
                }
		   
		   
		   
		   }
	
	}
	
	
	public function donewAction(){
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
	       if ($this->getRequest()->isPost()) {
			   $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			   try {
                    $date_contrat = new Zend_Date(Zend_Date::ISO_8601);
                    $contrat = new Application_Model_EuContrat();
					$mapper = new Application_Model_EuContratMapper();
					$id_contrat = $mapper->findConuter() + 1;
                    $date_contrat = clone $date_contrat;
					$result = $mapper->findByMembre($_POST['code_membre']);
					if($result != false) {
					   $db->rollBack();
                       $this->view->data = 'Ce membre personne morale ' . $_POST['code_membre'] . ' a deja un type de contrat!!!';
                       return;
					}
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($_POST['code_membre']);
                    $contrat->setDate_contrat($date_contrat->toString('yyyy-mm-dd'));
                    $contrat->setNature_contrat(null);
                    $contrat->setId_type_contrat($_POST['type_contrat']);
                    if(isset($_POST['type_creneau'])){
                       $contrat->setId_type_creneau($_POST['type_creneau']);
					}else{
                        $contrat->setId_type_creneau(null);
                    }						
	                if(isset($_POST['type_acteur']) && $_POST['type_acteur']!='') {
                        $contrat->setId_type_acteur($_POST['type_acteur']);
			        } else {
                        $contrat->setId_type_acteur(null);
			        }
                    $contrat->setId_pays($_POST['pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper->save($contrat);
					$db->commit();
                    $this->view->data = true;
                    return;	
               } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->data = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                    return;
               }			   
	       }	   
	}
	
	public function consultationAction() {
	
	   
	}
	
	
	public function dataconsultAction() {
	       
		   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $db = Zend_Db_Table::getDefaultAdapter();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 200000);
        $sidx = $this->_request->getParam("sidx",'id_contrat');
        $sord = $this->_request->getParam("sord", 'desc');
        
        //if (isset($_GET["membre"])) $membre = $_GET["membre"];
        $request = $this->getRequest();
        $code_membre = $request->code_membre;
        $tabela = new Application_Model_DbTable_EuContrat();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        if($code_membre !="") {
            $select->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_contrat.code_membre')
                  ->where('eu_contrat.code_membre = ?',$code_membre)
                  ->where('eu_contrat.id_utilisateur = ?', $user->id_utilisateur);   
        }
        else { 
            $select->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_contrat.code_membre')
                  ->order('eu_contrat.id_contrat desc')
                  ->where('eu_contrat.id_utilisateur = ?', $user->id_utilisateur)
	              //->where('eu_contrat.code_membre like ?','%p')
				  ;
           
        }
        $contrats = $tabela->fetchAll($select);
        $count = count($contrats);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } 
        else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;
           $contrats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
           $responce['page'] = $page;
           $responce['total'] = $total_pages;
           $responce['records'] = $count;
           $i = 0;
           $date_id = new Zend_Date(Zend_Date::ISO_8601);
           $date_idd = clone $date_id;
           foreach ($contrats as $row) {  
           $datecontrat = new Zend_Date($row->date_contrat);
           $responce['rows'][$i]['id'] = $row->id_contrat;
           $responce['rows'][$i]['cell'] = array(
                $row->id_contrat,
                $row->code_membre,
			    $row->raison_sociale,
                $datecontrat->toString('dd/MM/yyyy'),
            );
            $i++;
        }      
        $this->view->data = $responce;
	
	   
	}
	
	
	
    
    public function newAction() {
        
       // action body 
       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $request = $this->getRequest();
       $code_membre = $request->membre;
       $this->view->code_membre = $code_membre;
             if ($this->getRequest()->isPost()) {
             // if ($form->isValid($request->getPost())) {
             $date_contrat = new Zend_Date(Zend_Date::ISO_8601);
             $contrat = new Application_Model_EuContrat();
			 $mapper = new Application_Model_EuContratMapper();
			 $id_contrat = $mapper->findConuter() + 1;
             $date_contrat = clone $date_contrat;
             
			 $contrat->setId_contrat($id_contrat);
             $contrat->setCode_membre($_POST['code_membre']);
             $contrat->setDate_contrat($date_contrat->toString('yyyy-mm-dd'));
             $contrat->setNature_contrat('');
             $contrat->setId_type_contrat($_POST['type_contrat']);
             if(isset($_POST['type_creneau']))
             $contrat->setId_type_creneau($_POST['type_creneau']);
             else
             $contrat->setId_type_creneau(null);    
             
	         if(isset($_POST['type_acteur']) && $_POST['type_acteur']!=''){
             $contrat->setId_type_acteur($_POST['type_acteur']);
			 }
             else{
             $contrat->setId_type_acteur(null);
			 }
             $contrat->setId_pays($_POST['pays']);
             $contrat->setId_utilisateur($user->id_utilisateur);
             $contrat->setFiliere(null); 
             
             $mapper->save($contrat);
             if ($user->code_groupe == 'cm') {
                return $this->_helper->redirector('index', 'eu-contrat', null, array('controller' => 'eu-contrat', 'action' => 'index'));
             } 
             elseif ($user->code_groupe == 'banque') {
                return $this->_helper->redirector('index', 'eu-placement', null, array('controller' => 'eu-placement', 'action' => 'index'));
             } 
             else {
                return $this->_helper->redirector('index', 'eu-bnp', null, array('controller' => 'eu-bnp', 'action' => 'index'));
             }
            // }
        }
    }
    
    
    public function newppAction() {
	
        // action body
        $request = $this->getRequest();
        $type = $request->type;
        $membre = $request->membre;
        if ($type == "p") 
        {
            $this->view->type_contrat = "Investisseurs physiques";
        } 
        $this->view->code_membre = $membre;
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
              $mapper = new Application_Model_EuContratMapper();
              $date_contrat = new Zend_Date(Zend_Date::ISO_8601);
              $contrat = new Application_Model_EuContrat();
			  $id_contrat = $mapper->findConuter() + 1;
              $date_contrat = clone $date_contrat;
			  $contrat->setId_contrat($id_contrat);
              $contrat->setCode_membre($_POST['code_membre']);
              $contrat->setDate_contrat($date_contrat->toString('yyyy-mm-dd'));
              $contrat->setNature_contrat($_POST['nature_contrat']);
              $contrat->setId_type_contrat(null);
              $contrat->setId_type_creneau(null);
              $contrat->setId_type_acteur(null);
              $contrat->setId_pays(null);
              $contrat->setId_utilisateur($user->id_utilisateur);
              if(isset($_POST['filiere'])) {
                 $contrat->setFiliere($_POST['filiere']);
			  }	 
              else {
                 $contrat->setFiliere(null);
			  } 
              $mapper->save($contrat);
              if ($user->code_groupe == 'cm') 
              {
                 return $this->_helper->redirector('index', 'eu-contrat', null, array('controller' => 'eu-contrat', 'action' => 'index'));
              } 
              elseif ($user->code_groupe == 'banque') 
              {
                 return $this->_helper->redirector('index', 'eu-placement', null, array('controller' => 'eu-placement', 'action' => 'index'));
              }
              else 
              {
                 return $this->_helper->redirector('index', 'eu-bnp', null, array('controller' => 'eu-bnp', 'action' => 'index'));
              }
        }
    }

    
    public function peditAction() {
        // action body
        $this->_helper->layout->disableLayout();
        if ($this->getRequest()->isPost()) {
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $mapper = new Application_Model_EuContratMapper();
            $datecontrat = new Zend_Date(Zend_Date::ISO_8601);
            $cat = new Application_Model_EuContrat();
            $date_contrat = clone $datecontrat;
            $cat->setNumcontrat($_POST['numcontrat']);
            $cat->setId_type($_POST['id_type']);
            $cat->setNatcontrat($_POST['natcontrat']);
            $cat->setUser($user->login);
            $cat->setMembre($_POST['num_membre']);
            $cat->setDatecontrat($date_contrat->toString('yyyy-mm-dd'));
            $cat->setGrossiste('');
            $cat->setDetaillant('');
            $cat->setSgrossiste('');
            $cat->setGac('');
            if(isset($_POST['filiere']))
            $cat->setFiliere($_POST['filiere']);
            else $cat->setFiliere ('');
            $cat->setPays('');
            $mapper->update($cat);
            return $this->_helper->redirector('index');  
        }
        else
       {    
        $id_contrat = $this->getRequest()->id_contrat;
        $tabela = new Application_Model_DbTable_EuContrat();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
               ->where('eu_contrat.id_contrat = ?',$id_contrat);
        $alloc = $tabela->fetchAll($select);
        $tab = array(array());
        $i = 0;
        foreach ($alloc as $row) 
        {
           $tab[$i][1] = $row->id_contrat;
           $tab[$i][2] = $row->code_membre;
           $tab[$i][3] = $row->nature_contrat;
           $tab[$i][4] = $row->filiere;
           $i++;
        }
        $this->view->data = $tab;
      }   
 }
    
 /* public function editAction() { 
      $this->_helper->layout->disableLayout();
      // action body
      if ($this->getRequest()->isPost()) {
          $this->_helper->layout->enableLayout();
          if ($form->isValid($this->getRequest()->getPost())) 
          { 
             if($_POST['idtype']==$_POST['type']){ 
             $tabela = new Application_Model_DbTable_EuContrat();
             $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
             
             $select->setIntegrityCheck(false)
                    ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
                    ->join('eu_type_contrat', 'eu_type_contrat.id_type = eu_contrat.id_type')
                    ->where('eu_contrat.id_contrat = ?',$_POST['numcontrat']);
             $alloc = $tabela->fetchAll($select);
             $tab = array(array());
             $i = 0;
             foreach ($alloc as $row) 
             {
                 $tab[$i][1] = $row->numcontrat;
                 $tab[$i][2] = $row->membre;
                 $tab[$i][3] = $row->id_type;
                 $tab[$i][4] = $row->grossiste;
                 $tab[$i][5] = $row->detaillant;
                 $tab[$i][6] = $row->sgrossiste;
                 $tab[$i][7] = $row->gac;
                 $tab[$i][8] = $row->pays;
                 $i++;
             }
                 $this->view->data = $tab;
            }
            else
            {
                $tab[0][1]= $_POST['numcontrat'];
                $tab[0][3]= $_POST['type'];
                $tab[0][2]= $_POST['membre'];
                $this->view->data = $tab;
            }
          }
        }
        else {
              $id_contrat = $this->getRequest()->id_contrat;
              $tabela = new Application_Model_DbTable_EuContrat();
              $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
              $select->setIntegrityCheck(false)
                     ->join('eu_membre', 'eu_membre.code_membre = eu_contrat.code_membre')
                     ->where('eu_contrat.id_contrat = ?',$id_contrat);
              $alloc = $tabela->fetchAll($select);
              $tab = array(array());
              $i = 0;
         foreach ($alloc as $row) 
         {
            $tab[$i][1] = $row->id_contrat;
            $tab[$i][2] = $row->id_type_contrat;
            $tab[$i][3] = $row->id_type_creneau;
            $tab[$i][4] = $row->id_pays;
            $i++;
         }
		 
         $this->view->data = $tab;
      }
        
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-contrat',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
				
}

    
      public function deleteAction() {
             // action body
      }
	  
	*/     

}

