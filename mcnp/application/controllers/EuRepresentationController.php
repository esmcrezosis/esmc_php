<?php
     
class  EuRepresentationController extends Zend_Controller_Action {

        public function init() {
		    /* Initialize action controller here */
			$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
			if ($group != "") {       
		        $menu = "<li><a href=\" /eu-representation/new \"  style=\"font-size:11px\">Ajout representant</a></li>".
			            "<li><a href=\" /eu-representation/index\" style=\"font-size:11px\">Liste des representants</a></li>";   	   
            } 
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
                $group = $user->code_groupe;
			    if($group != 'detentrice' and $group != 'detentrice_pays' and $group != 'detentrice_region' and $group != 'detentrice_secteur' 
				    and $group != 'detentrice_agence' and $group != 'surveillance' and $group != 'surveillance_pays'  and $group != 'surveillance_region'  
				    and $group != 'surveillance_secteur'  and $group != 'surveillance_agence'  and $group != 'executante' and $group != 'executante_pays'  
				    and $group != 'executante_region'  and $group != 'executante_secteur'  and  $group != 'executante_agence' and  $group != 'pbf_grossiste' 
				    and $group != 'pbf_semi_grossiste' and $group != 'pbf_detaillant' and $group != 'oe_grossiste' and  $group != 'oe_semi_grossiste' 
				    and $group != 'oe_detaillant' and $group != 'ose_grossiste' and $group != 'ose_semi_grossiste' and  $group != 'ose_detaillant')  {
				    $this->view->user = $user;
                    return $this->_redirect('index2');
			    }
			    $this->view->user = $user;
			}  
        }
		
		public function membrephysAction() {
                $data = array();
                $mb = new Application_Model_DbTable_EuMembre();
                $select = $mb->select();
		        $select->where('code_membre like ?','%P');
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
                  $data = strtoupper(ucfirst($result->nom_membre)) . ' ' . ucfirst($result->prenom_membre);
                } else {
                  $data = '';
                }
                $this->view->data = $data;
        }
		
		public function newAction() {
		
		
		}
		
		
		public function representerAction() {
		       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
			   
			    if ($this->getRequest()->isPost()) {
				
				$db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {  
				  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $date_idd = clone $date_id; 
				  $rep_mapper = new Application_Model_EuRepresentationMapper();
                  $rep = new Application_Model_EuRepresentation();
				  $rep_table = new Application_Model_DbTable_EuRepresentation();
				  $code = $user->code_membre;
				  $code_rep = $_POST["code_rep"];
				  $findrepresentation = $rep_mapper->findbyrep($code); 
				  $findtablerep = $rep_table->find($code_rep,$code); 
				    
				    //insertion dans la table eu_representation des membres personnes physiques  
				    if(count($findtablerep) != 0) {
					   $db->rollBack();
					   $this->view->data ="echec";                           
					   return;
					} 
					
					/*elseif (($findrepresentation != false)) {
					   $db->rollBack();
					   $this->view->data ="verifiertitre";                           
					   return;
					}*/ 
					
					elseif($code != '' && $code_rep != '') {
					    $rep->setCode_membre_morale($code)
                            ->setCode_membre($code_rep)
                            ->setTitre('Representant')
						    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						    ->setId_utilisateur($user->id_utilisateur)
						    ->setEtat('outside');
					    $rep_mapper->save($rep);
					 
					}
				    $db->commit();
                    $this->view->data = 'good';
                    return;   
				   
			    } catch (Exception $exc) {
                    $db->rollback();
				    $this->view->data = $exc->getMessage() . ': ' . $exc->getTraceAsString();
			        return;
			    }
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
		
		        }
		}
		
		
		public function indexAction() {
            // action body
            $request = $this->_request;
            if ($request->isXmlHttpRequest()) {
               $this->_helper->layout->disableLayout();
            }
        }
		
		
	
        public function dataAction() {
	           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 200000);
           $sidx = $this->_request->getParam("sidx", 'code_membre');
           $sord = $this->_request->getParam("sord", 'desc');
		   
		   $request = $this->getRequest();
           $membre = $user->code_membre;
		   $code_membre = $request->code_membre;
		   
		   
		   $tabela = new Application_Model_DbTable_EuRepresentation();
           $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           if ($membre != "" && $code_membre != "") {
           $select->setIntegrityCheck(false) 
                  ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre')
                  ->where('eu_representation.code_membre_morale = ?',$membre) 
				  ->where('eu_representation.code_membre = ?',$code_membre)
                  //->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur)
				  ;
            }  elseif($code_membre != "") {
		     $select->setIntegrityCheck(false) 
                    ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre')
                    ->where('eu_representation.code_membre = ?',$code_membre) 
                    //->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur)
					;
		    }
            else {
             $select->setIntegrityCheck(false) 
                    ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre') 
                    ->where('eu_representation.code_membre_morale = ?',$membre)
					->order('eu_representation.code_membre asc');    
            }
		   
		    $representations = $tabela->fetchAll($select);
            $count = count($representations);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } 
            else {
                $total_pages = 0;
            }
            if ($page > $total_pages)
               $page = $total_pages;
               $maisons = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
               $responce['page'] = $page;
               $responce['total'] = $total_pages;
               $responce['records'] = $count;
               $i = 0;
               foreach ($representations as $row) {
                $date_rep = new Zend_Date($row->date_creation, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_membre."-".$row->code_membre_morale;
                $responce['rows'][$i]['cell'] = array(
				    $row->code_membre."-".$row->code_membre_morale,
				    $row->code_membre_morale,
                    $row->code_membre,
                    $row->nom_membre,
			        $row->prenom_membre,
                    $date_rep->toString('dd-MM-yyyy')
            );
            $i++;
        }      
        $this->view->data = $responce;
	    }
		
	
 			
		
}
?>		