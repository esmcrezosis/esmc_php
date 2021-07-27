<?php

class RepresentationController extends Zend_Controller_Action {

      public function init() {
	     $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
	     include("Url.php");
      }
	  
	  
	  public  function addrepresentantAction()  {
	     /* page administration/addrepresentant*/
		 $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		 
		 if(!isset($sessionutilisateur->login))         { $this->_redirect('/administration/login');}
         if($sessionutilisateur->confirmation != "")    { $this->_redirect('/administration/confirmation');}
		
		 $request = $this->getRequest();  
		 if($request->isPost())  {
			$db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
		    try {
				    $representation = new Application_Model_EuRepresentation();
	                $m_representation  = new Application_Model_EuRepresentationMapper();
					
					$date_id = Zend_Date::now();
					
					$principal = "inside"; 
					$secondaire = "outside";
					
					$code_membre_morale = $request->getParam("code_membre_morale");
					$code_membre_representant = $request->getParam("code_membre_representant");
					
					$membre = new Application_Model_EuMembre();
	                $m_membre  = new Application_Model_EuMembreMapper();
					$membremorale = new Application_Model_EuMembreMorale();
	                $m_membremorale = new Application_Model_EuMembreMoraleMapper();
					
					$findmorale = $m_membremorale->find($code_membre_morale,$membremorale);
					$findmembre = $m_membre->find($code_membre_representant,$membre);
					
					if($findmorale == false) {
					   $db->rollback();
		               $this->view->error = "Le code membre de la personne morale ".$code_membre_morale."  est introuvable ...";
					   return;	
					}
					
					if($membremorale->desactiver != 0) {
					   $db->rollback();
					   $this->view->error = "Le code membre de la personne morale  ".$code_membre_morale." est désactivé ...";
					   return;
				    }
					
					
					if($findmembre == false) {
					   $db->rollback();
		               $this->view->error = "Le code membre du représentant ".$code_membre_representant."  est introuvable ...";
					   return;	
					}
					
					if($membre->desactiver != 0) {
					   $db->rollback();
					   $this->view->error = "Le code membre du représentant  ".$code_membre_representant." est désactivé ...";
					   return;
				    }
					
					$eurepresentation = new Application_Model_DbTable_EuRepresentation();
					$select = $eurepresentation->select();
					$select->where('code_membre_morale like ?',$code_membre_morale);
				    $select->where('code_membre like ?',$code_membre_representant);
					$representants = $eurepresentation->fetchAll($select);
					
					if(count($representants) > 0) {
						$db->rollback();
					    $this->view->error = "Impossible d'exécuter cette opération car cette représentation existe déjà ...";
					    return;
					}
					
					$eurepresentation = new Application_Model_DbTable_EuRepresentation();
					$select = $eurepresentation->select();
					$select->where('code_membre_morale like ?',$code_membre_morale);
				    $select->where('etat like ?',"inside");
					$rowsrepresentant = $eurepresentation->fetchAll($select);
					
					if(count($rowsrepresentant) > 0) {
					   $rowrepresentant  = $rowsrepresentant[0];
					   $findrepresentant = $m_representation->find($rowrepresentant->code_membre,$rowrepresentant->code_membre_morale,$representation);
					   $representation->setEtat("outside");
					   $m_representation->update($representation);
					}
					
					$representation->setCode_membre($code_membre_representant);
					$representation->setCode_membre_morale($code_membre_morale);
					$representation->setTitre("Representant");
					$representation->setEtat("inside");
					$representation->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$representation->setId_utilisateur(NULL);
					$m_representation->save($representation);
					
					$db->commit();
			        $sessionutilisateur->error = "Operation bien effectuee ...";
			        $this->_redirect('/representation/listrepresentation');
					 
				
				} catch(Exception $exc) {
		            $db->rollback();
                    $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
                    return;
		        }
			}
		
		
	  }
	  
	  
	  
	  public  function editrepresentantAction()  {
		  /* page administration/editrepresentant */
		  $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		  $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		  
		  if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != "") { $this->_redirect('/administration/confirmation');}
		  
		  $code_membre_morale = $this->_request->getParam('code_membre_morale');
	      $code_membre = $this->_request->getParam('code_membre');
			
		  $representation = new Application_Model_EuRepresentation();
	      $m_representation  = new Application_Model_EuRepresentationMapper();
		  
		  $eurepresentation = new Application_Model_DbTable_EuRepresentation();
		  $select = $eurepresentation->select();
		  $select->where('code_membre_morale like ?',$code_membre_morale);
		  $select->where('etat like ?',"inside");
		  $rowsrepresentant = $eurepresentation->fetchAll($select);
					
		  if(count($rowsrepresentant) > 0) {
			$rowrepresentant  = $rowsrepresentant[0];
			$findrepresentant = $m_representation->find($rowrepresentant->code_membre,$rowrepresentant->code_membre_morale,$representation);
			$representation->setEtat("outside");
			$m_representation->update($representation);
		  }
		  
		  $m_representation->find($code_membre,$code_membre_morale,$representation);
	      $representation->setEtat("inside");
		  $m_representation->update($representation);
		  
		  $sessionutilisateur->error = "Operation bien effectuee ...";
		  $this->_redirect('/representation/listrepresentation');
	  }
	  
	  
	  
	  
	  public function listrepresentationAction()  {
		 /* page administration/listrepresentation */
		 $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

         if(!isset($sessionutilisateur->login))         { $this->_redirect('/administration/login');}
         if($sessionutilisateur->confirmation != "")    { $this->_redirect('/administration/confirmation');}		  
		  
		  
		 $request = $this->getRequest();
	     if($request->isPost())  {
			 $code_membre_morale = $request->getParam("code_membre_morale");
		     $code_membre = $request->getParam("code_membre");
			 
			 $db_representation = new Application_Model_DbTable_EuRepresentation();
	         $select = $db_representation->select();
			 if(!empty($code_membre_morale) && !empty($code_membre)) {
				 $select->where('code_membre_morale like ?', $code_membre_morale)
				        ->where('code_membre like ?',$code_membre);  
			 } else if(!empty($code_membre_morale)) {
				 $select->where('code_membre_morale like ?', $code_membre_morale);
             } else if(!empty($code_membre)) {
                 $select->where('code_membre like ?', $code_membre);
             }

             $entries = $db_representation->fetchAll($select);
             $this->view->entries = $entries;			 
		 }
		  
	  }
	  
	  
	  public function listappareilmobileAction()   {
		  /* page administration/listappareilmobile */
		  $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		  $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

          if(!isset($sessionutilisateur->login))         { $this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != "")    { $this->_redirect('/administration/confirmation');} 
		  
		  $db_appareil = new Application_Model_DbTable_EuAppareils();
          $select = $db_appareil->select();

          $entries = $db_appareil->fetchAll($select);
          $this->view->entries = $entries;		 
		  
      }
	  
	  
	  public  function editstatusAction()    {
		  /* page administration/editstatus */
		  $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		  $this->_helper->layout()->setLayout('layoutpublicesmcadmin'); 
		  
		  if(!isset($sessionutilisateur->login))         { $this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != "")    { $this->_redirect('/administration/confirmation');} 
		 
		  $id = $this->_request->getParam('id');
	      $publier = $this->_request->getParam('publier');
			
		  $appareils = new Application_Model_EuAppareils();
	      $m_appareils  = new Application_Model_EuAppareilsMapper();
		  $m_appareils->findAll($id,$appareils);
		  
		  $appareils->setLock_status($publier);
		  $m_appareils->updateone($appareils);
		  
		  $sessionutilisateur->error = "Operation bien effectuee ...";
		  $this->_redirect('/representation/listappareilmobile');
		  
	  }
	  
	  
	

}


