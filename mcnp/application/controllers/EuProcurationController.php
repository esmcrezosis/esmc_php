<?php

class EuProcurationController extends Zend_Controller_Action {

     public function init() {
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
	   include("Url.php");
     }
	 
	 
	 public  function  addprocurationAction()  {
	    /* page administration/addprocuration - Ajout d'une procuration  */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}		
		 
		$request = $this->getRequest();  
		if($request->isPost()) {
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
               $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
			   
			   $membre = new Application_Model_EuMembre();
	           $m_membre  = new Application_Model_EuMembreMapper();
			   
			   $membremorale = new Application_Model_EuMembreMorale();
	           $m_membremorale  = new Application_Model_EuMembreMoraleMapper();
			   
			   $procuration = new Application_Model_EuProcuration();
	           $m_procuration = new Application_Model_EuProcurationMapper();
			   
			   $code_membre_mandat = $request->getParam("code_membre_mandat");
			   $code_membre_mandataire = $request->getParam("code_membre_mandataire");
			   
			   if(substr($code_membre_mandat,19,1) == 'P') {
			      $findmembre = $m_membre->find($code_membre_mandat,$membre);
			      if($findmembre == false) {
				    $db->rollback();
		            $this->view->error = "Le numéro membre du mandat saisi  ".$code_membre_mandat."  est introuvable ...";
					return;
			      }
						
				  if($membre->desactiver != 0) {
				    $db->rollback();
					$this->view->error = "Le code membre que voici  ".$code_membre_mandat."  n'est pas autorisé à effectuer cette opération ...";
					return;
				  }
			   
			   } else {
				  $findmembre = $m_membremorale->find($code_membre_mandat,$membremorale);
			      if($findmembre == false) {
				    $db->rollback();
		            $this->view->error = "Le numéro membre du mandataire saisi  ".$code_membre_mandat."  est introuvable ...";
					return;
			      }
						
				  if($membremorale->desactiver != 0) {
				    $db->rollback();
					$this->view->error = "Le code membre que voici  ".$code_membre_mandat."  n'est pas autorisé à effectuer cette opération ...";
					return;
				  }
			   }
			   
			   $findmembremandataire = $m_membre->find($code_membre_mandataire,$membre);
			   if($findmembremandataire == false) {
				  $db->rollback();
		          $this->view->error = "Le numéro membre du mandat saisi  ".$code_membre_mandataire."  est introuvable ...";
				  return;
			   }
						
			   if($membre->desactiver != 0) {
				 $db->rollback();
				 $this->view->error = "Le code membre que voici  ".$code_membre_mandataire."  n'est pas autorisé à effectuer cette opération ...";
				 return;
			   }
			   
			   $findprocuration = $m_procuration->fetchByProcuration($code_membre_mandat,$code_membre_mandataire);
			   if($findprocuration != NULL) {
				  $db->rollback();
		          $this->view->error = "Cette procuration  est dejà enrégistrée  ...";
				  return;   
			   }
			   $procuration->setCode_membre_mandant($code_membre_mandat);
               $procuration->setCode_membre_mandataire($code_membre_mandataire);
			   $procuration->setDate_procuration($date_idd->toString('yyyy-MM-dd HH:mm:ss'));
			   $procuration->setActiver(0);
               $m_procuration->save($procuration);
			   
			   $db->commit();
			   $sessionutilisateur->error = "Operation bien effectuee ...";
			   $this->_redirect('/eu-procuration/listprocuration');
			   
           } catch(Exception $exc) {
		      $db->rollback();
              $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
              return;
		   }		   

        }		
		 
	 }
	 
	 
	 public  function  listprocurationAction()  {
	    /* page administration/listprocuration */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		 
		$tabela = new Application_Model_DbTable_EuProcuration();
		$select = $tabela->select();  
		$entries = $tabela->fetchAll($select);   
		$this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	 }
	 

}


