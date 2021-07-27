<?php

class ImmobilisationController extends Zend_Controller_Action {

      public function init() {
	     $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
	     include("Url.php");
      }
	  
	  
	  // -- COMITE DE RECEPTION --- //
	  
	  public  function addpvacquisitionAction()  {
	    /* page administration/addpvacquisition - Ajout d'un pv recu  */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != "") { $this->_redirect('/administration/confirmation');}
		  
		  $request = $this->getRequest();  
		  if($request->isPost())  {
		      $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
		      try {
				  $pvacquisition = new Application_Model_EuPvacquisition();
	              $m_pvacquisition  = new Application_Model_EuPvacquisitionMapper();
				  
				  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $date_idd = clone $date_id;
				  
				  $designation_pv = $request->getParam("designation_pv");
				  
				  include("Transfert.php");
		          $chemin = "proces_verbal";
		          $file = $_FILES['document_pv']['name'];
		          $file1='document_pv';
		          $proces_verbal = $chemin."/".transfert($chemin,$file1);
				  
				  $pvacquisition->setDesignation_pvacquisition($designation_pv);
                  $pvacquisition->setDocument_pv($proces_verbal);
				  $pvacquisition->setDate_pvacquisition($date_idd->toString('yyyy-MM-dd HH:mm:ss'));
				  $pvacquisition->setValider(0);
				  $pvacquisition->setRejeter(0);
				  $pvacquisition->setClasser(0);
                  $m_pvacquisition->save($pvacquisition);
				  
				  $db->commit();
			      $sessionutilisateur->error = "Operation bien effectuee ...";
			      $this->_redirect('/immobilisation/listpvacquisition');
				  
			  } catch(Exception $exc) {
		          $db->rollback();
                  $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
                  return;
		      }
			
		  }
	}
	
	public  function  listpvacquisitionAction()  {
		/* page administration/listpvacquisition */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		$tabela = new Application_Model_DbTable_EuPvacquisition();
		$select = $tabela->select();
		//$select->where('valider = ?',0);   
		$entries = $tabela->fetchAll($select);   
		$this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	public  function validerpvAction() {
		/* page immobilisation/validerpv */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		$id = (int) $this->_request->getParam('id');
        if(isset($id) && $id != 0) {
            $pv = new Application_Model_EuPvacquisition();
            $pvM = new Application_Model_EuPvacquisitionMapper();
            $pvM->find($id,$pv);
		
            $pv->setValider($this->_request->getParam('publier'));
		    $pvM->update($pv);
        }

		$this->_redirect('/immobilisation/listpvacquisition');
		
	}
	
	//-- AGENT ACNEV  --//
	
	public function listpvacquisition1Action()   {
		/* page administration/listpvacquisition1  */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		$tabela = new Application_Model_DbTable_EuPvacquisition();
		$select = $tabela->select();
		$select->where('valider IN (?)',array(1,2));   
		$entries = $tabela->fetchAll($select);   
		$this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	
	public function addcodificationAction()  {
	   /* page administration/addcodification */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
	   
	   $request = $this->getRequest();  
	   if($request->isPost()) {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
			   $fiche = new Application_Model_EuFicheImmobilisation();
	           $m_fiche  = new Application_Model_EuFicheImmobilisationMapper();
			   $numero_ordre = $m_fiche->findConuter() + 1;
			   
			   $date_id = Zend_Date::now();
			   
			   $pvacquisition = new Application_Model_EuPvacquisition();
	           $m_pvacquisition = new Application_Model_EuPvacquisitionMapper();
			   
			   $id_pvacquisition = $request->getParam("id_pvacquisition");
			   $findpv = $m_pvacquisition->find($id_pvacquisition,$pvacquisition);
			   
			   for($i = 0; $i < count($_POST['code_rubrique']); $i++) {
				  $code_rubrique = $_POST['code_rubrique'][$i];
				  $code_nature = $_POST['code_nature'][$i];
				  $numero_ordre = $numero_ordre + $i;
				  $annee = $_POST['annee'][$i];
				  $code_esmc = "ESMC";
				  $code_localisation = $_POST['code_localisation'][$i];
				  $code_financement = $_POST['code_financement'][$i];
				  
				  $code_identification = $code_rubrique."/".$code_nature."/".$numero_ordre."/".$annee."/".$code_esmc."/".$code_localisation."/".$code_financement;
				  				  
				  $fiche->setCode_identification($code_identification);
				  $fiche->setDate_codification($date_id->toString('yyyy-MM-dd HH:mm:ss'));
				  $fiche->setTraiter(0);
                  $fiche->setId_pvacquisition($id_pvacquisition);				  
				  $m_fiche->save($fiche);   
			   }
			   
			   $pvacquisition->setValider(2);
			   $m_pvacquisition->update($pvacquisition);
			   
			   $db->commit();
			   $sessionutilisateur->error = "Operation bien effectuee ...";
			   $this->_redirect('/immobilisation/listpvacquisition1');
			   
		   } catch(Exception $exc) {
		       $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
               return;
		   }
		   
	   } else {
		  $id = $this->_request->getParam('id');
	      $pv = new Application_Model_EuPvacquisition();
	      $m_pv  = new Application_Model_EuPvacquisitionMapper();
		  $m_pv->find($id,$pv);
		  $this->view->pv = $pv;
	   }
	   
	}
	
	
	
	
	public  function listdetailpvcodifierAction()  {
	   /* page immobilisation/listdetailpvcodifier */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $pv = new Application_Model_EuPvacquisition();
	   $m_pv  = new Application_Model_EuPvacquisitionMapper();
	   $m_pv->find($id,$pv);
	   
		 
	   $tabela = new Application_Model_DbTable_EuFicheImmobilisation();
	   $select = $tabela->select();
	   $select->where('id_pvacquisition = ?',$id);   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;
       $this->view->pv = $pv;	   
       $this->view->tabletri = 1;
	}
	
	
	
    //-- AGENT  FILIERE --- //
	
	public function listpvacquisition2Action() {
		/* page administration/listpvacquisition2 -*/
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "") { $this->_redirect('/administration/confirmation');}
		
		$tabela = new Application_Model_DbTable_EuPvacquisition();
		$select = $tabela->select();
		$select->where('valider = ?',2);   
		$entries = $tabela->fetchAll($select);   
		$this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	
	
	public  function  listdetailficheAction()  {
	   /* page immobilisation/listdetailfiche */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $pv = new Application_Model_EuPvacquisition();
	   $m_pv  = new Application_Model_EuPvacquisitionMapper();
	   $m_pv->find($id,$pv);
	    
	   $tabela = new Application_Model_DbTable_EuFicheImmobilisation();
	   $select = $tabela->select();
	   $select->where('id_pvacquisition = ?',$id);   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;
       $this->view->pv = $pv;	   
       $this->view->tabletri = 1;
		
	}
	
	
	public  function addficheimmoAction()  {
	    /* page immobilisation/addficheimmo */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	    if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	    $request = $this->getRequest();  
	    if($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
			   $date_id = Zend_Date::now();
			   $fiche = new Application_Model_EuFicheImmobilisation();
	           $m_fiche  = new Application_Model_EuFicheImmobilisationMapper();
			   
			   $id_fiche_immo = $request->getParam("id_fiche_immobilisation");
			   
			   $code_immo = $request->getParam("code_immo");
			   $designation_immo = $request->getParam("designation_immo");
			   $nature_immo = $request->getParam("nature_immo");
			   $famille_immo = $request->getParam("famille_immo");
			   $lieu_affectation = $request->getParam("lieu_affectation");
			   $date_acquisition = $request->getParam("date_acquisition");
			   $date_acquisition = new Zend_Date($date_acquisition);
			   $valeur_acquisition = $request->getParam("valeur_acquisition");
			   $source_financement = $request->getParam("source_financement");
			   
			   $m_fiche->find($id_fiche_immo,$fiche);
			   $id_pvacquisition = $fiche->id_pvacquisition;
			   
			   $fiche->setDesignation_immobilisation($designation_immo);
			   $fiche->setNature_immobilisation($nature_immo);
			   $fiche->setFamille_immobilisation($famille_immo);
			   $fiche->setLieu_affectation($lieu_affectation);
			   $fiche->setDate_entree($date_acquisition->toString('yyyy-MM-dd'));
			   $fiche->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
			   $fiche->setValeur_acquisition($valeur_acquisition);
			   $fiche->setSource_financement($source_financement);
			   $fiche->setRestituer(0);
			   $fiche->setTraiter(1);
               $m_fiche->update($fiche);
			   
			   $db->commit();
			   $sessionutilisateur->error = "Operation bien effectuee ...";
			   $this->_redirect('/immobilisation/listdetailfiche/id/'.$id_pvacquisition);
			   
           } catch(Exception $exc) {				   
	           $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
           }		   
		     
		
	    } else {
		   $id = $this->_request->getParam('id');
	       $fiche = new Application_Model_EuFicheImmobilisation();
	       $m_fiche  = new Application_Model_EuFicheImmobilisationMapper();
		   $m_fiche->find($id,$fiche);
		   $this->view->fiche = $fiche;
		}
	}
	
	
	//--  AGENT TECHNOPOLE   --//
	public function listpvacquisition3Action()  {
	   /* page administration/listpvacquisition3 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	   $tabela = new Application_Model_DbTable_EuPvacquisition();
	   $select = $tabela->select();
	   $select->where('valider = ?',2);   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	public  function  listdetailfiche1Action()  {
	   /* page immobilisation/listdetailfiche1 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $pv = new Application_Model_EuPvacquisition();
	   $m_pv  = new Application_Model_EuPvacquisitionMapper();
	   $m_pv->find($id,$pv);
	    
	   $tabela = new Application_Model_DbTable_EuFicheImmobilisation();
	   $select = $tabela->select();
	   $select->where('id_pvacquisition = ?',$id); 
       $select->where('traiter = ?',1);	   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;
       $this->view->pv = $pv;	   
       $this->view->tabletri = 1;
	}
	
	
	public  function addlettreAction()  {
	   /* page immobilisation/addlettre */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	   $request = $this->getRequest();  
	   if($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
               $fiche = new Application_Model_EuFicheImmobilisation();
	           $m_fiche  = new Application_Model_EuFicheImmobilisationMapper();
			   $date_id = Zend_Date::now();
			   
			   $lettre = new Application_Model_EuLettreImmobilisation();
	           $m_lettre = new Application_Model_EuLettreImmobilisationMapper();
			   
			   $id_fiche_immo = $request->getParam("id_fiche_immobilisation"); 
               $fournisseur = $request->getParam("code_membre");
               $motif = $request->getParam("motif");
			   
			   $lettre->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
			   $lettre->setId_fiche_immobilisation($id_fiche_immo);
			   $lettre->setCode_membre_fournisseur($fournisseur);
			   $lettre->setMotif1($motif);
			   $lettre->setValider(0);
			   $lettre->setRejeter(0);
			   $lettre->setDate_restitution(NULL);
			   $lettre->setMotif2(NULL);
			   
               $m_lettre->save($lettre);
				  
			   $db->commit();
			   $sessionutilisateur->error = "Operation bien effectuee ...";
			   $this->_redirect('/immobilisation/listpvacquisition3');

           } catch(Exception $exc) {
		       $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
               return;
		   }		   
	   } else {
	      $id = $this->_request->getParam('id');
	      $fiche = new Application_Model_EuFicheImmobilisation();
	      $m_fiche  = new Application_Model_EuFicheImmobilisationMapper();
	      $m_fiche->find($id,$fiche);
	      $this->view->fiche = $fiche;
	   }
	   
	}
	
	
	public  function listlettreinitierAction()  {
	    /* page immobilisation/listlettreinitier */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	    if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		$tabela = new Application_Model_DbTable_EuLettreImmobilisation();
	    $select = $tabela->select();
	    $select->order('id_lettre desc'); 		
	    $entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;	   
        $this->view->tabletri = 1;
	}
	
	
	public  function  detailimmoAction()  {
		/* page immobilisation/detailimmo */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	    if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		$id = $this->_request->getParam('id');
		$tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$select->setIntegrityCheck(false);
		$select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		$select->where('eu_lettre_immobilisation.id_lettre = ?',$id);
		   
		$entry = $tabela->fetchAll($select);   
		$this->view->entry = $entry[0];		   
        $this->view->tabletri = 1;
	}
	
	
	
	// -- GERANT --  //
	public  function listlettreinitier1Action()  {
	   /* page immobilisation/listlettreinitier1 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	   $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
	   $select = $tabela->select();
	   $select->where('valider IN (?)',array(0,1,2));
	   $select->order('id_lettre desc'); 	   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;	   
       $this->view->tabletri = 1;
	}
	
	
	public  function addaccordgeranceAction()  {
	    /* page immobilisation/addaccordgerance */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	    if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		$request = $this->getRequest();  
	    if($request->isPost())  {
			 $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
		     try {
		         $lettre = new Application_Model_EuLettreImmobilisation();
	             $m_lettre = new Application_Model_EuLettreImmobilisationMapper();
 
                 $id_lettre = $request->getParam("id_lettre");
                 $m_lettre->find($id_lettre,$lettre);
                 $valider = 0;
			     $rejeter = 0;
			 
			     if(isset($_POST['valider'])) {
			       $valider =  $request->getParam("valider");
			     }
			 
			     if(isset($_POST['rejeter'])) {
			        $rejeter =  $request->getParam("rejeter");
			     }
			     $lettre->setValider($valider);
			     $lettre->setRejeter($rejeter);  
                 $m_lettre->update($lettre);
				  
			     $db->commit();
			     $sessionutilisateur->error = "Operation bien effectuee ...";
			     $this->_redirect('/immobilisation/listlettreinitier1');
			 
			 } catch(Exception $exc) {
		         $db->rollback();
                 $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
                 return;
		     }
		} else {	
		   $id = $this->_request->getParam('id');
		   $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		   $select->setIntegrityCheck(false);
		   $select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		   $select->where('eu_lettre_immobilisation.id_lettre = ?',$id);
		   $entry = $tabela->fetchAll($select);   
		   $this->view->entry = $entry[0];
		}
	}
	
	
	
	// FOURNISSEUR  PARTENAIRE
	public  function listlettreinitier2Action()   {
		/* page immobilisation/listlettreinitier2 */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if(!isset($sessionmembre->code_membre)) { $this->_redirect('/');}
		
		$tabela = new Application_Model_DbTable_EuLettreImmobilisation();
	    $select = $tabela->select();
	    $select->where('valider IN (?)',array(1,2));
		$select->where('code_membre_fournisseur like ?', $sessionmembre->code_membre);
	    $select->order('id_lettre desc');
		
		$entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;	   
        $this->view->tabletri = 1;
	}
	
	
	public  function  detailimmo1Action()  {
		/* page immobilisation/detailimmo1 */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	    if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
		
		$id = $this->_request->getParam('id');
		$tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$select->setIntegrityCheck(false);
		$select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		$select->where('eu_lettre_immobilisation.id_lettre = ?',$id);
		   
		$entry = $tabela->fetchAll($select);   
		$this->view->entry = $entry[0];		   
        $this->view->tabletri = 1;
	}
	
	
	 public  function addaccordpartenaireAction()  {
        /* page immobilisation/addaccordpartenaire */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	    if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
        $request = $this->getRequest();  
	    if($request->isPost())  {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
		    try {
		        $lettre = new Application_Model_EuLettreImmobilisation();
	            $m_lettre = new Application_Model_EuLettreImmobilisationMapper();
 
                $id_lettre = $request->getParam("id_lettre");
				$contenu = $request->getParam("contenu");
				$date_restitution = $request->getParam("date_restitution");
				$date_restitution = new Zend_Date($date_restitution);
                $m_lettre->find($id_lettre,$lettre);
                $valider = 1;
			    $rejeter = 0;
			 
			    if(isset($_POST['valider'])) {
			       $valider =  $request->getParam("valider");
			    }
			 
			    if(isset($_POST['rejeter'])) {
			       $rejeter =  $request->getParam("rejeter");
			    }
				
			    $lettre->setValider($valider);
			    $lettre->setRejeter($rejeter);
                $lettre->setMotif2($contenu);
                $lettre->setDate_restitution($date_restitution->toString('yyyy-MM-dd'));				
                $m_lettre->update($lettre);
				  
			    $db->commit();
			    $sessionutilisateur->error = "Operation bien effectuee ...";
			    $this->_redirect('/immobilisation/listlettreinitier2');
			 
			 } catch(Exception $exc) {
		         $db->rollback();
                 $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
                 return;
		     }
        } else {	
		   $id = $this->_request->getParam('id');
		   $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		   $select->setIntegrityCheck(false);
		   $select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		   $select->where('eu_lettre_immobilisation.id_lettre = ?',$id);
		   $entry = $tabela->fetchAll($select);   
		   $this->view->entry = $entry[0];
	    }

	}
	
	
	
	// -- AGENT  TECHNOPOLE -- //
	
	public  function listlettreinitier3Action()   {
	   /* page immobilisation/listlettreinitier3 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
          if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	   /*
	   $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
	   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	   $select->setIntegrityCheck(false);
	   $select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
	   $select->where('eu_lettre_immobilisation.valider = ?',2);
	   $select->where('eu_fiche_immobilisation.traiter = ?',1);   
	   $entries = $tabela->fetchAll($select);
	   */
		
	   $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
	   $select = $tabela->select();
	   $select->where('valider IN (?)',array(2,3));
	   $select->order('id_lettre desc');
		
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;	   
       $this->view->tabletri = 1;
	}
	
	
	public  function addpvrestitutionAction()  {
	   /* page immobilisation/addpvrestitution */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	   $request = $this->getRequest();  
	   if($request->isPost()) {
		  $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
		  try { 
              $pvrestitution = new Application_Model_EuPvrestitution();
	          $m_pvrestitution  = new Application_Model_EuPvrestitutionMapper();
				  
			  $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;

              $designation_pv = $request->getParam("designation_pv");
			  $id_lettre = $request->getParam("id_lettre");
			  $message = $request->getParam("contenu");
			   
			  $pvrestitution->setDesignation_pvrestitution($designation_pv);
			  $pvrestitution->setDate_pvrestitution($date_idd->toString('yyyy-MM-dd HH:mm:ss'));
			  $pvrestitution->setValider(0);
			  $pvrestitution->setRejeter(0);
			  $pvrestitution->setId_lettre($id_lettre);
			  $pvrestitution->setContenu($message);
			  $m_pvrestitution->save($pvrestitution);
				  
			  $db->commit();
			  $sessionutilisateur->error = "Operation bien effectuee ...";
			  $this->_redirect('/immobilisation/listpvrestitution');
		   
		   } catch(Exception $exc) {
		      $db->rollback();
              $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
              return;
		   }
		
	   } else {  
	      $id = $this->_request->getParam('id');
		  $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		  $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		  $select->setIntegrityCheck(false);
		  $select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		  $select->where('eu_lettre_immobilisation.id_lettre = ?',$id);
		  $entry = $tabela->fetchAll($select);   
		  $this->view->entry = $entry[0];
	   }
		
	}
	
	
	public  function  listpvrestitutionAction()  {
		/* page administration/listpvrestitution */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		$tabela = new Application_Model_DbTable_EuPvrestitution();
		$select = $tabela->select();
		//$select->where('valider = ?',0);   
		$entries = $tabela->fetchAll($select);   
		$this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	
	
	// -- GERANT --  //
	
	public function listpvrestitution1Action() {
	  /* page administration/listpvrestitution1 */
	  $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	  $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	  if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
      if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	  $tabela = new Application_Model_DbTable_EuPvrestitution();
	  $select = $tabela->select();
	  $select->where('valider IN (?)',array(0,1,2,3,4));   
	  $entries = $tabela->fetchAll($select);   
	  $this->view->entries = $entries;		   
      $this->view->tabletri = 1;
	}
	
	public function addaccordgerance1Action()  {
	    /* page administration/addaccordgerance1 */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		$request = $this->getRequest();  
	    if($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
			   $pvrestitution = new Application_Model_EuPvrestitution();
	           $m_pvrestitution = new Application_Model_EuPvrestitutionMapper();
 
               $id_pvrestitution = $request->getParam("id_pvrestitution");
               $m_pvrestitution->find($id_pvrestitution,$pvrestitution);
               $valider = 0;
			   $rejeter = 0;
			 
			   if(isset($_POST['valider'])) {
			      $valider =  $request->getParam("valider");
			   }
			 
			   if(isset($_POST['rejeter'])) {
			      $rejeter =  $request->getParam("rejeter");
			   }
			   $pvrestitution->setValider($valider);
			   $pvrestitution->setRejeter($rejeter);  
               $m_pvrestitution->update($pvrestitution);
			   
			   $db->commit();
			   $sessionutilisateur->error = "Operation bien effectuee ...";
			   $this->_redirect('/immobilisation/listpvrestitution1');
				  
		   } catch(Exception $exc) {
		      $db->rollback();
              $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
              return;
		   }
		   
		} else {
		   $id = $this->_request->getParam('id');
		   $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		   $select->setIntegrityCheck(false);
		   $select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		   $select->join('eu_pvrestitution','eu_pvrestitution.id_lettre = eu_lettre_immobilisation.id_lettre');
		   $select->where('eu_pvrestitution.id_pvrestitution = ?',$id);
		   $entry = $tabela->fetchAll($select);   
		   $this->view->entry = $entry[0];
		}
	}
	
	
	// -- FOURNISSEUR OU PARTENAIRE -- //
	public function listpvrestitution2Action()    {
	    /* page immobilisation/listpvrestitution2 */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	    if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
		
	    $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$select->setIntegrityCheck(false);
		$select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		$select->join('eu_pvrestitution','eu_pvrestitution.id_lettre = eu_lettre_immobilisation.id_lettre');
		$select->where('eu_lettre_immobilisation.code_membre_fournisseur = ?',$sessionmembre->code_membre);
		$select->where('eu_pvrestitution.valider IN (?)',array(1,2,3,4));
		   
	    $this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	
	public  function addaccordpartenaire1Action()  {
        /* page immobilisation/addaccordpartenaire */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	    if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
        $request = $this->getRequest();  
	    if($request->isPost())  {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
		    try {
		        $pvrestitution = new Application_Model_EuPvrestitution();
	            $m_pvrestitution = new Application_Model_EuPvrestitutionMapper();
 
                $id_pvrestitution = $request->getParam("id_pvrestitution");
			
                $m_pvrestitution->find($id_pvrestitution,$pvrestitution);
                $valider = 1;
			    $rejeter = 0;
			 
			    if(isset($_POST['valider'])) {
			       $valider =  $request->getParam("valider");
			    }
			 
			    if(isset($_POST['rejeter'])) {
			       $rejeter =  $request->getParam("rejeter");
			    }
				
			    $pvrestitution->setValider($valider);
			    $pvrestitution->setRejeter($rejeter);				
                $m_pvrestitution->update($pvrestitution);
				  
			    $db->commit();
			    $sessionutilisateur->error = "Operation bien effectuee ...";
			    $this->_redirect('/immobilisation/listpvrestitution2');
			 
			 } catch(Exception $exc) {
		         $db->rollback();
                 $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
                 return;
		     }
        }  else {	
		     $id = $this->_request->getParam('id');
		     $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		     $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		     $select->setIntegrityCheck(false);
		     $select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		     $select->join('eu_pvrestitution','eu_pvrestitution.id_lettre = eu_lettre_immobilisation.id_lettre');
		     $select->where('eu_pvrestitution.id_pvrestitution = ?',$id);
		     $entry = $tabela->fetchAll($select);   
		     $this->view->entry = $entry[0];
	    }
	}
	
	
	// -- AGENT FILIERE -- //
	public function listpvrestitution3Action() {
	   /* page administration/listpvrestitution3 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	   $tabela = new Application_Model_DbTable_EuPvrestitution();
	   $select = $tabela->select();
	   $select->where('valider IN (?)',array(2,3,4));   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	
	
	public  function  addaccordfiliereAction()  {
	   /* page administration/addaccordfiliere */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	   $request = $this->getRequest();  
	    if($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
			   $pvrestitution = new Application_Model_EuPvrestitution();
	           $m_pvrestitution = new Application_Model_EuPvrestitutionMapper();
 
               $id_pvrestitution = $request->getParam("id_pvrestitution");
               $m_pvrestitution->find($id_pvrestitution,$pvrestitution);
               $valider = 2;
			   $rejeter = 0;
			 
			   if(isset($_POST['valider'])) {
			      $valider =  $request->getParam("valider");
			   }
			 
			   if(isset($_POST['rejeter'])) {
			      $rejeter =  $request->getParam("rejeter");
			   }
			   $pvrestitution->setValider($valider);
			   $pvrestitution->setRejeter($rejeter);  
               $m_pvrestitution->update($pvrestitution);
			   
			   $db->commit();
			   $sessionutilisateur->error = "Operation bien effectuee ...";
			   $this->_redirect('/immobilisation/listpvrestitution3');
				  
		   } catch(Exception $exc) {
		      $db->rollback();
              $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
              return;
		   }
		   
		} else {
		   $id = $this->_request->getParam('id');
		   $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		   $select->setIntegrityCheck(false);
		   $select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		   $select->join('eu_pvrestitution','eu_pvrestitution.id_lettre = eu_lettre_immobilisation.id_lettre');
		   $select->where('eu_pvrestitution.id_pvrestitution = ?',$id);
		   $entry = $tabela->fetchAll($select);   
		   $this->view->entry = $entry[0];
		}
		
	}
	
	
	public function listpvrestitution4Action() {
	   /* page administration/listpvrestitution4 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	   $tabela = new Application_Model_DbTable_EuPvrestitution();
	   $select = $tabela->select();
	   $select->where('valider IN (?)',array(3,4));   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	
	public  function  addaccordacnevAction()  {
	   /* page administration/addaccordacnev */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
	   $request = $this->getRequest();  
	   if($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
			   $pvrestitution = new Application_Model_EuPvrestitution();
	           $m_pvrestitution = new Application_Model_EuPvrestitutionMapper();
			   
			   $lettre = new Application_Model_EuLettreImmobilisation();
               $m_lettre = new Application_Model_EuLettreImmobilisationMapper();
			   
			   $fiche = new Application_Model_EuFicheImmobilisation();
               $m_fiche  = new Application_Model_EuFicheImmobilisationMapper();
 
               $id_pvrestitution = $request->getParam("id_pvrestitution");
               $m_pvrestitution->find($id_pvrestitution,$pvrestitution);
			   $m_lettre->find($pvrestitution->id_lettre,$lettre);
			   $m_fiche->find($lettre->id_fiche_immobilisation,$fiche);
			   
               $valider = 3;
			   $rejeter = 0;
			 
			   if(isset($_POST['valider'])) {
			     $valider =  $request->getParam("valider");
			   }
			 
			   if(isset($_POST['rejeter'])) {
			     $rejeter =  $request->getParam("rejeter");
			   }
			   
			   $pvrestitution->setValider($valider);
			   $pvrestitution->setRejeter($rejeter);  
               $m_pvrestitution->update($pvrestitution);
			   
			   $fiche->setRestituer(1);
			   $fiche->setId_pvrestitution($id_pvrestitution);
			   $fiche->setDate_sortie($lettre->date_restitution);
			   $m_fiche->update($fiche);
			   
			   $db->commit();
			   $sessionutilisateur->error = "Operation bien effectuee ...";
			   $this->_redirect('/immobilisation/listpvrestitution4');
				  
		   } catch(Exception $exc) {
		      $db->rollback();
              $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
              return;
		   }
		   
		} else {
		   $id = $this->_request->getParam('id');
		   $tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		   $select->setIntegrityCheck(false);
		   $select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		   $select->join('eu_pvrestitution','eu_pvrestitution.id_lettre = eu_lettre_immobilisation.id_lettre');
		   $select->where('eu_pvrestitution.id_pvrestitution = ?',$id);
		   $entry = $tabela->fetchAll($select);   
		   $this->view->entry = $entry[0];
		}
	}
	
	
	// DEMANDEUR OU UTILISATEUR
	
	public  function addfichebesoinAction()  {
	  /* page immobilisation/addfichebesoin */
      $sessionmembre = new Zend_Session_Namespace('membre');
      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	  if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
      $request = $this->getRequest();
		
	  if($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
			   $date_id = Zend_Date::now();
				 
               $fiche = new Application_Model_EuFicheBesoin();
	           $m_fiche = new Application_Model_EuFicheBesoinMapper();
				 
			   $detailfiche   = new Application_Model_EuDetailFicheBesoin();
	           $m_detailfiche = new Application_Model_EuDetailFicheBesoinMapper();

               $debut_periode = $request->getParam("debut_periode");
			   $debut_periode = new Zend_Date($debut_periode);

               $fin_periode = $request->getParam("fin_periode");
			   $fin_periode = new Zend_Date($fin_periode);

               $libelle_besoin = $request->getParam("libelle_besoin");
				 
               $fiche->setDesignation_besoin($libelle_besoin);
			   $fiche->setDebut_periode_besoin($debut_periode->toString('yyyy-MM-dd'));
			   $fiche->setFin_periode_besoin($fin_periode->toString('yyyy-MM-dd'));
			   $fiche->setDate_besoin_exprime($date_id->toString('yyyy-MM-dd HH:mm:ss'));
			   $fiche->setCode_membre_demandeur($sessionmembre->code_membre);
				 
               $fiche->setDesignation_demande(NULL);
			   $fiche->setCode_membre_prestataire(NULL);
               $fiche->setDate_demande(NULL);
               $fiche->setValider(0);
               $fiche->setLivrer(0);
               $fiche->setRejeter(0);				 
               $m_fiche->save($fiche);
			   
			   $id_fiche_besoin = $db->lastInsertId();
			   
			   for($i = 0; $i < count($_POST['code_immo']); $i++) {
			       $code_immo = $_POST['code_immo'][$i];
				   $detailfiche->setCode_identification($code_immo);
				   $detailfiche->setId_fiche_besoin($id_fiche_besoin);
			       $m_detailfiche->save($detailfiche);
			   }
				  
			   $db->commit();
			   $sessionutilisateur->error = "Operation bien effectuee ...";
			   $this->_redirect('/immobilisation/listbesoinexprime'); 
			 } catch(Exception $exc) {
		         $db->rollback();
                 $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
                 return;
		     }
		
		}
	}
	
	
	public function listbesoinexprimeAction()  {
	   /* page immobilisation/listbesoinexprime */
       $sessionmembre = new Zend_Session_Namespace('membre');
       //$this->_helper->layout->disableLayout();
       $this->_helper->layout()->setLayout('layoutpublicesmcperso');
	   
	   $tabela = new Application_Model_DbTable_EuFicheBesoin();
	   $select = $tabela->select();   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	
////////////////////////////////////////////////	
	//--   AGENT ACNEV   --//
	public function listbesoinexprime1Action() {
	  /* page immobilisation/listbesoinexprime1 */
	  $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	  $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	  if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
      if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	  $tabela = new Application_Model_DbTable_EuFicheBesoin();
	  $select = $tabela->select();
      $select->where('valider IN (?)',array(0,1,2,3));		
	  $entries = $tabela->fetchAll($select);   
	  $this->view->entries = $entries;		   
      $this->view->tabletri = 1;
	}
	
	
	
	public  function  detaildemandeAction() {
	    /* page immobilisation/detaildemande */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	    if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	    $id = $this->_request->getParam('id');
	   
	    $fiche = new Application_Model_EuFicheBesoin();
	    $m_fiche  = new Application_Model_EuFicheBesoinMapper();
	    $m_fiche->find($id,$fiche);
	    $this->view->fiche = $fiche;
	   
	    $tabela = new Application_Model_DbTable_EuDetailFicheBesoin();
	    $select = $tabela->select();
        $select->where('id_fiche_besoin = ?',$id);	   
	    $entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	
	public function adddemandeAction()   {
		/* page immobilisation/adddemande */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	    if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
		
		$request = $this->getRequest();  
	    if($request->isPost())  {
		     $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
		     try {	
			     $fiche = new Application_Model_EuFicheBesoin();
	             $m_fiche = new Application_Model_EuFicheBesoinMapper();
				 $membre = new Application_Model_EuMembre();
                 $m_membre  = new Application_Model_EuMembreMapper();
                 $membremorale = new Application_Model_EuMembreMorale();
                 $m_membremorale = new Application_Model_EuMembreMoraleMapper();
 
                 $id_fiche_besoin = $request->getParam("id_fiche_besoin");
				 $code_membre = $request->getParam("code_membre");
				 $libelle_demande = $request->getParam("libelle_demande");
				 
				 if(substr($code_membre,19,1) == 'M')  {
				    $findmembre = $m_membremorale->find($code_membre,$membremorale);
				 } else {
					$findmembre = $m_membre->find($code_membre,$membre); 
				 }
				 
				 if($findmembre == false) {
				    $db->rollback();           
		            $this->view->error = "Le numéro membre du prestataire  ".$code_membre."  est introuvable ...";
					return;
			     }
				 
				 $m_fiche->find($id_fiche_besoin,$fiche);
				 $date_id = Zend_Date::now();
				 
				 $fiche->setDesignation_demande($libelle_demande);
				 $fiche->setCode_membre_prestataire($code_membre);
                 $fiche->setDate_demande($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $fiche->setValider(0);
                 $fiche->setLivrer(0);
                 $fiche->setRejeter(0);				 
                 $m_fiche->update($fiche);
				 
				 $db->commit();
			     $sessionutilisateur->error = "Operation bien effectuee ...";
			     $this->_redirect('/immobilisation/listbesoinexprime1');
				 
			 } catch(Exception $exc) {
		         $db->rollback();
                 $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
                 return;
		     }
			 
		}  else {
		    $id = $this->_request->getParam('id');
	        $fiche = new Application_Model_EuFicheBesoin();
	        $m_fiche  = new Application_Model_EuFicheBesoinMapper();
		    $m_fiche->find($id,$fiche);
		    $this->view->fiche = $fiche;
		}
		
	}
	
	
	public function addvisaAction()  {
	   /* page immobilisation/adddvisa */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $visa = $this->_request->getParam('publier');
	   $fiche = new Application_Model_EuFicheBesoin();
	   $m_fiche  = new Application_Model_EuFicheBesoinMapper();
	   $m_fiche->find($id,$fiche);
		
	   $fiche->setValider($visa);         				 
       $m_fiche->update($fiche);
		
	   $this->_redirect('/immobilisation/listbesoinexprime1');
	}
	
	
	
	// --   AGENT TECHNOPOLE    -- //
	
	public function listbesoinexprime2Action() {
	    /* page immobilisation/listbesoinexprime2 */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	    if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
		$tabela = new Application_Model_DbTable_EuFicheBesoin();
	    $select = $tabela->select();
        $select->where('valider IN (?)',array(1,2,3));		
	    $entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	
	public function addvisatechnoAction()  {
	   /* page immobilisation/adddvisatechno */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $visa = $this->_request->getParam('publier');
	   $fiche = new Application_Model_EuFicheBesoin();
	   $m_fiche  = new Application_Model_EuFicheBesoinMapper();
	   $m_fiche->find($id,$fiche);
		
	   $fiche->setValider($visa);         				 
       $m_fiche->update($fiche);
		
	   $this->_redirect('/immobilisation/listbesoinexprime2');
	}
	
	
	// -- PRESTATAIRE --//
	
	
	public function listbesoinexprime3Action()  {
	   /* page immobilisation/listbesoinexprime3 */
       $sessionmembre = new Zend_Session_Namespace('membre');
       $this->_helper->layout->disableLayout();
       $this->_helper->layout()->setLayout('layoutpublicesmcperso');
	   
	   $tabela = new Application_Model_DbTable_EuFicheBesoin();
	   $select = $tabela->select();
       $select->where('valider = ?',3);	   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	public  function adddevisAction()  {
	    /* page immobilisation/adddevis */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	    $request = $this->getRequest();  
	    if($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
			   $date_id = Zend_Date::now();
			   $fiche = new Application_Model_EuFicheBesoin();
	           $m_fiche  = new Application_Model_EuFicheBesoinMapper();
			   $devis = new Application_Model_EuDevisPrestation();
	           $m_devis  = new Application_Model_EuDevisPrestationMapper();
			   
			   $ddevis = new Application_Model_EuDetailDevisPrestation();
	           $m_ddevis = new Application_Model_EuDetailDevisPrestationMapper();
			   $montant_devis = 0;
			   
			   $id_fiche_besoin = $request->getParam("id_fiche_besoin");
			   $libelle_devis = $request->getParam("libelle_devis");
			   $m_fiche->find($id_fiche_besoin,$fiche);
			   $prestataire = $fiche->code_membre_prestataire;
			   
			   for($i = 0; $i < count($_POST['prix_unitaire']); $i++) {
			      if($_POST['prix_unitaire'][$i] > 0 && $_POST['qte_article'][$i] > 0) {
					 $montant_devis = $montant_devis + ($_POST['prix_unitaire'][$i] * $_POST['qte_article'][$i]);
				  } else {
				     $db->rollback();
					 $this->view->fiche = $fiche;
                     $this->view->error = "Veuillez revoir votre saisie ... ";
                     return;						
				  }
			   }
			   
			   if($request->getParam("prestation") == 1) {
				  $montant_devis = $montant_devis + $request->getParam("montant_prestation");
			   }
			   
			   $devis->setId_fiche_besoin($id_fiche_besoin);
			   $devis->setLibelle_devis_prestation($libelle_devis);
			   $devis->setMontant_devis_prestation($montant_devis);
               $devis->setDate_devis_prestation($date_id->toString('yyyy-MM-dd HH:mm:ss'));      
			   $devis->setCode_membre_fournisseur($prestataire);
			   $devis->setViser(0);
			   $m_devis->save($devis);
				   
			   $id_devis_prestation = $db->lastInsertId();
			   
			   for($i = 0; $i < count($_POST['prix_unitaire']); $i++) {
				  $ddevis->setId_devis_prestation($id_devis_prestation);
				  $ddevis->setDesignation_article($_POST['designation_article'][$i]);
				  $ddevis->setQuantite($_POST['qte_article'][$i]);
				  $ddevis->setPrix_unitaire($_POST['prix_unitaire'][$i]);
				  $ddevis->setMontant_total($_POST['qte_article'][$i] * $_POST['prix_unitaire'][$i]);
				  $ddevis->setDesignation_prestation(NULL);
				  $ddevis->setApprouver(1);
				  $m_ddevis->save($ddevis);
               }
			   
			   if($request->getParam("prestation") == 1)  {
				 $ddevis->setId_devis_prestation($id_devis_prestation);
				 $ddevis->setDesignation_article(NULL);
				 $ddevis->setQuantite(NULL);
				 $ddevis->setPrix_unitaire(NULL);
				 
				 $ddevis->setDesignation_prestation($request->getParam("designation_prestation"));
				 $ddevis->setMontant_total($request->getParam("montant_prestation"));
				 $ddevis->setApprouver(1);
				 $m_ddevis->save($ddevis);
			   }

               $db->commit();
			   $sessionmembre->error = "Opération bien effectuée ...";
			   $this->_redirect('/immobilisation/listdevisprestation');		   
				
           } catch(Exception $exc) {
		      $db->rollback();
			  $this->view->fiche = $fiche;
              $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
              return;
		   }		   
		   
	    } else {
		   $id = $this->_request->getParam('id');
	       $fiche = new Application_Model_EuFicheBesoin();
	       $m_fiche  = new Application_Model_EuFicheBesoinMapper();
		   $m_fiche->find($id,$fiche);
		   $this->view->fiche = $fiche;
	    }
	}
	
	
	public  function  detaildemandepersoAction() {
	    /* page immobilisation/detaildemandeperso */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
	    $id = $this->_request->getParam('id');
	    $fiche = new Application_Model_EuFicheBesoin();
	    $m_fiche  = new Application_Model_EuFicheBesoinMapper();
	    $m_fiche->find($id,$fiche);
	    $this->view->fiche = $fiche;
	   
	    $tabela = new Application_Model_DbTable_EuDetailFicheBesoin();
	    $select = $tabela->select();
        $select->where('id_fiche_besoin = ?',$id);	   
	    $entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	
	public function listdevisprestationAction()  {
	   /* page immobilisation/listdevisprestation */
       $sessionmembre = new Zend_Session_Namespace('membre');
       $this->_helper->layout->disableLayout();
       $this->_helper->layout()->setLayout('layoutpublicesmcperso');
	   
	   $tabela = new Application_Model_DbTable_EuDevisPrestation();
	   $select = $tabela->select();	   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	
	
	//-- AGENT  ACNEV   --//
	public function listdevisprestation1Action()  {
	   /* page immobilisation/listdevisprestation1 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	   if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
	   
	   $tabela = new Application_Model_DbTable_EuDevisPrestation();
	   $select = $tabela->select();
       $select->where('viser IN (?)',array(0,1,2,3));	   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	public  function  detaildevisAction() {
	   /* page immobilisation/detaildevis */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	   if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $tabela = new Application_Model_DbTable_EuDevisPrestation();
	   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	   $select->setIntegrityCheck(false);
	   $select->join('eu_detail_devis_prestation','eu_detail_devis_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	   $select->where('eu_detail_devis_prestation.id_devis_prestation = ?',$id);
	   $select->where('eu_detail_devis_prestation.approuver = ?',1);
	   
	   $devis = new Application_Model_EuDevisPrestation();
	   $m_devis  = new Application_Model_EuDevisPrestationMapper();
	   $m_devis->find($id,$devis);
	   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;	
       $this->view->devis = $devis;	   
       $this->view->tabletri = 1;
	}
	
	
	public function updatedevisAction()  {
	   /* page immobilisation/updatedevis */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	   if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		
	   $request = $this->getRequest();  
	   if($request->isPost()) {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
               $ddevis   = new Application_Model_EuDetailDevisPrestation();
			   $m_ddevis = new Application_Model_EuDetailDevisPrestationMapper(); 
			   
			   $devis   = new Application_Model_EuDevisPrestation();
			   $m_devis = new Application_Model_EuDevisPrestationMapper();
			   
               $compteur = $request->getParam("compteur");
			   $id_devis_prestation = $request->getParam("id_devis_prestation");
			   $finddevis = $m_devis->find($id_devis_prestation,$devis);
			   $x = 1;
			   $montant_devis = 0;
			   $montant_prestation = 0;

               while($x <= $compteur) {
                 if(isset($_POST["confirmer$x"])) {
				    $id_detail_devis_prestation = $_POST["devis$x"];
                    $findddevis = $m_ddevis->find($id_detail_devis_prestation,$ddevis);
                    if($ddevis->designation_article != NULL || $ddevis->designation_article != "") {
                       $confirmer = $_POST["confirmer$x"];
					   $qte = $_POST["quantite$x"];
					   $prix = $_POST["prix$x"];
					   
					   $montant_devis = $montant_devis + ($prix * $qte);
					   
					   $ddevis->setQuantite($qte);
                       $ddevis->setPrix_unitaire($prix);
                       $ddevis->setMontant_total($prix * $qte);					   
					   $ddevis->setApprouver($confirmer);
                       $m_ddevis->update($ddevis);
					   
					}  else {
					   $confirmer = $_POST["confirmer$x"];
					   $montant_prestation = $_POST["montant_prestation$x"];
					   $montant_devis = $montant_devis  + $montant_prestation;
					   $ddevis->setMontant_total($montant_prestation);
					   $ddevis->setApprouver($confirmer);
					   $m_ddevis->update($ddevis);
					}
					
					
					if(isset($_POST["rejeter$x"])) {
					   $rejeter = $_POST["rejeter$x"];
					   $id_detail_devis_prestation = $_POST["devis$x"];
                       $findddevis = $m_ddevis->find($id_detail_devis_prestation,$ddevis);   
					   $ddevis->setApprouver($rejeter);
                       $m_ddevis->update($ddevis);
                    }
                    					
				 } else {
					$id_detail_devis_prestation = $_POST["devis$x"];
                    $findddevis = $m_ddevis->find($id_detail_devis_prestation,$ddevis);   
					$ddevis->setApprouver(0);
                    $m_ddevis->update($ddevis);  
				 }
                 $x++;					   
			   }
               
               $devis->setMontant_devis_prestation($montant_devis);
			   $m_devis->update($devis);
			   
			   $db->commit();
			   $sessionutilisateur->error = "Opération effectuée avec succès ...";
			   $this->_redirect('/immobilisation/listdevisprestation1');
			   
				 
           } catch(Exception $exc) {
		       $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();				
               return;
		   }			
		   
	   } else {
		  $id = $this->_request->getParam('id');
		  $devis = new Application_Model_EuDevisPrestation();
		  $m_devis = new Application_Model_EuDevisPrestationMapper();
		  
		  $tabela = new Application_Model_DbTable_EuDetailDevisPrestation();
	      $select = $tabela->select();
          $select->where('id_devis_prestation = ?',$id);	   
	      $entries = $tabela->fetchAll($select);
		
		  $m_devis->find($id,$devis);
		  $this->view->devis = $devis;  
		  $this->view->entries = $entries; 
	   }
	   
	}
	
	public function addbonprestationAction()  {
	    /* page immobilisation/addbonprestation */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	    if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		
	    $id = $this->_request->getParam('id');
	    $date_id = Zend_Date::now();
	    $devis = new Application_Model_EuDevisPrestation();
	    $m_devis = new Application_Model_EuDevisPrestationMapper();
	    $m_devis->find($id,$devis);
		  
	    $bonprestation = new Application_Model_EuBonPrestation();
	    $m_bonprestation = new Application_Model_EuBonPrestationMapper();
		  
	    $bonprestation->setLibelle_bon_prestation($devis->libelle_devis_prestation);
        $bonprestation->setId_devis_prestation($devis->id_devis_prestation);
        $bonprestation->setMontant_bon_prestation($devis->montant_devis_prestation);
        $bonprestation->setDate_bon_prestation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
        $bonprestation->setVisa(0);		
        $m_bonprestation->save($bonprestation);
		
	    $this->_redirect('/immobilisation/listdevisprestation1');
	}
	
	public  function addvisabonacnevAction()    {
		/* page immobilisation/addvisabonacnev */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	    if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		
		
		$id = $this->_request->getParam('id');
	    $visa = $this->_request->getParam('publier');
	    $bon = new Application_Model_EuBonPrestation();
	    $m_bon  = new Application_Model_EuBonPrestationMapper();
	    $m_bon->find($id,$bon);
		
	    $bon->setVisa($visa);         				 
        $m_bon->update($bon);
		
	    $this->_redirect('/immobilisation/listdevisprestation1');
    }
	
	
	//--   AGENT TECHNOPOLE   --//
	public  function  listbonprestationAction()   {
	    /* page immobilisation/listbonprestation */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	    if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		  
	    $tabela = new Application_Model_DbTable_EuDevisPrestation();
	    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	    $select->setIntegrityCheck(false);
	    $select->join('eu_bon_prestation','eu_bon_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	    $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	    $select->where('eu_bon_prestation.visa IN (?)',array(1,2,3));
	   
	    $entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;		   
        $this->view->tabletri = 1; 
	}
	
	
	public  function addvisabontechnoAction()   {
	   /* page immobilisation/addvisabontechno */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	   if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $visa = $this->_request->getParam('publier');
	   $bon = new Application_Model_EuBonPrestation();
	   $m_bon  = new Application_Model_EuBonPrestationMapper();
	   $m_bon->find($id,$bon);
		
	   $bon->setVisa($visa);         				 
       $m_bon->update($bon);
		
	   $this->_redirect('/immobilisation/listbonprestation');
    }
	
	
	//-- GERANT --//
	public  function  listbonprestation1Action()   {
	    /* page immobilisation/listbonprestation1 */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	    if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		  
	    $tabela = new Application_Model_DbTable_EuDevisPrestation();
	    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	    $select->setIntegrityCheck(false);
	    $select->join('eu_bon_prestation','eu_bon_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	    $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	    $select->where('eu_bon_prestation.visa IN (?)',array(2,3));
	   
	    $entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;		   
        $this->view->tabletri = 1; 
	}
	
	
	public  function addvisabongerantAction()   {
	   /* page immobilisation/addvisabongerant */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	   if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $visa = $this->_request->getParam('publier');
	   $bon = new Application_Model_EuBonPrestation();
	   $m_bon  = new Application_Model_EuBonPrestationMapper();
	   $m_bon->find($id,$bon);
		
	   $bon->setVisa($visa);         				 
       $m_bon->update($bon);
		
	   $this->_redirect('/immobilisation/listbonprestation1');
    }
	
	
	
	//-- PRESTATAIRE  --//
	public  function  listbonprestationpersoAction() {
	   /* page immobilisation/listbonprestationperso */
       $sessionmembre = new Zend_Session_Namespace('membre');
       //$this->_helper->layout->disableLayout();
       $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		  
	   $tabela = new Application_Model_DbTable_EuDevisPrestation();
	   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	   $select->setIntegrityCheck(false);
	   $select->join('eu_bon_prestation','eu_bon_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	   $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	   $select->where('eu_fiche_besoin.code_membre_prestataire like ?',$sessionmembre->code_membre);
	   $select->where('eu_bon_prestation.visa = ?',3);
	   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1; 
	}
	
	
	public function addbonlivraisonAction()  {
	    /* page immobilisation/addbonlivraison */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	    $id = $this->_request->getParam('id');
	    $date_id = Zend_Date::now();
	    $devis = new Application_Model_EuDevisPrestation();
	    $m_devis = new Application_Model_EuDevisPrestationMapper();
	    $m_devis->find($id,$devis);
		  
	    $bonlivraison = new Application_Model_EuBonLivraisonPrestation();
	    $m_bonlivraison = new Application_Model_EuBonLivraisonPrestationMapper();
		  
	    $bonlivraison->setLibelle_bon_livraison_prestation($devis->libelle_devis_prestation);
        $bonlivraison->setId_devis_prestation($devis->id_devis_prestation);
        $bonlivraison->setMontant_bon_livraison($devis->montant_devis_prestation);
        $bonlivraison->setDate_bon_livraidon($date_id->toString('yyyy-MM-dd HH:mm:ss'));
        $bonlivraison->setVisa(0);		
        $m_bonlivraison->save($bonlivraison);
		
	    $this->_redirect('/immobilisation/listbonprestationperso');
	}
	
	//-- AGENT ACNEV  --//
	public  function  listbonlivraisonAction()   {
	  /* page immobilisation/listbonlivraison */
	  $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	  $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	  if(!isset($sessionutilisateur->login))         { $this->_redirect('/administration/login');}
      if($sessionutilisateur->confirmation != "")    { $this->_redirect('/administration/confirmation');}
		  
	  $tabela = new Application_Model_DbTable_EuDevisPrestation();
	  $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	  $select->setIntegrityCheck(false);
	  $select->join('eu_bon_livraison_prestation','eu_bon_livraison_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	  $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	  $select->where('eu_bon_livraison_prestation.visa IN (?)',array(0,1,2,3));
	   
	  $entries = $tabela->fetchAll($select);   
	  $this->view->entries = $entries;		   
      $this->view->tabletri = 1; 
	}
	
	public  function addvisalivraisonacnevAction()   {
	    /* page immobilisation/addvisalivraisonacnev */
	    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	    if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		
	    $id = $this->_request->getParam('id');
	    $visa = $this->_request->getParam('publier');
	    $bon = new Application_Model_EuBonLivraisonPrestation();
	    $m_bon  = new Application_Model_EuBonLivraisonPrestationMapper();
	    $m_bon->find($id,$bon);
		
	    $bon->setVisa($visa);         				 
        $m_bon->update($bon);
		
	    $this->_redirect('/immobilisation/listbonlivraison');
    }
	
	
	
	//--   DEMANDEUR --//
	
	public  function  listbonlivraison1Action()   {
	    /* page immobilisation/listbonlivraison1 */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		  
	    $tabela = new Application_Model_DbTable_EuDevisPrestation();
	    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	    $select->setIntegrityCheck(false);
	    $select->join('eu_bon_livraison_prestation','eu_bon_livraison_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	    $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	    $select->where('eu_bon_livraison_prestation.visa IN (?)',array(1,2,3));
		$select->where('eu_fiche_besoin.code_membre_demandeur like ?',$sessionmembre->code_membre);
	   
	    $entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;		   
        $this->view->tabletri = 1; 
	}
	
	public  function  detaildevispersoAction()   {
	   /* page immobilisation/detaildevisperso */
       $sessionmembre = new Zend_Session_Namespace('membre');
       //$this->_helper->layout->disableLayout();
       $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	   $id = $this->_request->getParam('id');
	   $tabela = new Application_Model_DbTable_EuDevisPrestation();
	   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	   $select->setIntegrityCheck(false);
	   $select->join('eu_detail_devis_prestation','eu_detail_devis_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	   $select->where('eu_detail_devis_prestation.id_devis_prestation = ?',$id);
	   $select->where('eu_detail_devis_prestation.approuver = ?',1);
	   
	   $devis = new Application_Model_EuDevisPrestation();
	   $m_devis  = new Application_Model_EuDevisPrestationMapper();
	   $m_devis->find($id,$devis);
	   
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;	
       $this->view->devis = $devis;	   
       $this->view->tabletri = 1;
	}
	
	
	public  function addvisalivraisondemandeurAction()   {
	    /* page immobilisation/addvisalivraisondemandeur */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	    $id = $this->_request->getParam('id');
	    $visa = $this->_request->getParam('publier');
	    $bon = new Application_Model_EuBonLivraisonPrestation();
	    $m_bon  = new Application_Model_EuBonLivraisonPrestationMapper();
	    $m_bon->find($id,$bon);
		
	    $bon->setVisa($visa);         				 
        $m_bon->update($bon);
		
	    $this->_redirect('/immobilisation/listbonlivraison1');
    }
	
	
	//-- AGENT  FILIERE  --//
	
	public  function  listbonlivraison2Action()   {
	  /* page immobilisation/listbonlivraison2 */
	  $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	  $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	  if(!isset($sessionutilisateur->login))         { $this->_redirect('/administration/login');}
      if($sessionutilisateur->confirmation != "")    { $this->_redirect('/administration/confirmation');}
		  
	  $tabela = new Application_Model_DbTable_EuDevisPrestation();
	  $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	  $select->setIntegrityCheck(false);
	  $select->join('eu_bon_livraison_prestation','eu_bon_livraison_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	  $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	  $select->where('eu_bon_livraison_prestation.visa IN (?)',array(2,3));
	   
	  $entries = $tabela->fetchAll($select);   
	  $this->view->entries = $entries;		   
      $this->view->tabletri = 1; 
	}
	
	public  function addvisalivraisonfiliereAction()   {
	   /* page immobilisation/addvisalivraisonfiliere */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   
	   if(!isset($sessionutilisateur->login))       { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")  { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $visa = $this->_request->getParam('publier');
	   $bon = new Application_Model_EuBonLivraisonPrestation();
	   $m_bon  = new Application_Model_EuBonLivraisonPrestationMapper();
	   $m_bon->find($id,$bon);
		
	   $bon->setVisa($visa);         				 
       $m_bon->update($bon);
		
	   $this->_redirect('/immobilisation/listbonlivraison2');
    }
	
	
	//-- PRESTATAIRE  --//
	
	public  function  listbonlivraison3Action()   {
	    /* page immobilisation/listbonlivraison3 */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		  
	    $tabela = new Application_Model_DbTable_EuDevisPrestation();
	    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	    $select->setIntegrityCheck(false);
	    $select->join('eu_bon_livraison_prestation','eu_bon_livraison_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	    $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	    $select->where('eu_bon_livraison_prestation.visa = ?',3);
		$select->where('eu_fiche_besoin.code_membre_prestataire like ?',$sessionmembre->code_membre);
	   
	    $entries = $tabela->fetchAll($select);   
	    $this->view->entries = $entries;		   
        $this->view->tabletri = 1; 
	}
	
	public  function  addfactureAction() {
	  /* page immobilisation/addfacture */
      $sessionmembre = new Zend_Session_Namespace('membre');
      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcperso');
	
	  $request = $this->getRequest();  
	  if($request->isPost())  {
		  $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try {
			  $date_id = Zend_Date::now();
			  $livraison = new Application_Model_EuBonLivraisonPrestation();
	          $m_livraison  = new Application_Model_EuBonLivraisonPrestationMapper();
			  
			  $facture = new Application_Model_EuFacturePrestation();
	          $m_facture  = new Application_Model_EuFacturePrestationMapper();
			   
			  $id_bon_livraison_prestation = $request->getParam("id_bon_livraison_prestation");
			   
			  $numero_facture = $request->getParam("numero_facture");
			  $libelle_facture = $request->getParam("libelle_facture");
			   
			  $m_livraison->find($id_bon_livraison_prestation,$livraison);
			  $id_devis_prestation = $livraison->id_devis_prestation;
			  $montant_facture = $livraison->montant_bon_livraison;
			   
			  $facture->setId_devis_prestation($id_devis_prestation);
			  $facture->setMontant_facture_prestation($montant_facture);
			  $facture->setLibelle_facture_prestation($libelle_facture);
			  $facture->setDate_facture_prestation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
			  $facture->setVisa(0);
			  $facture->setPayer(0);
              $m_facture->save($facture);
			   
			  $db->commit();
			  $sessionmembre->error = "Operation bien effectuee ...";
			  $this->_redirect('/immobilisation/listbonlivraison3');
		   
           } catch(Exception $exc) {			   
	          $db->rollback();
			  $this->view->livraison = $livraison;
              $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
              return;
           }
		   
	   } else {
		  $id = $this->_request->getParam('id');
	      $livraison = new Application_Model_EuBonLivraisonPrestation();
	      $m_livraison  = new Application_Model_EuBonLivraisonPrestationMapper();
		  $m_livraison->find($id,$livraison);
		  $this->view->livraison = $livraison;
	   }
	
	}
	
	
	
	//-- AGENT TECHNOPOLE --//
	
	public  function  listfactureAction()   {
	   /* page immobilisation/listfacture */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		  
	   $tabela = new Application_Model_DbTable_EuDevisPrestation();
	   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	   $select->setIntegrityCheck(false);
	   $select->join('eu_facture_prestation','eu_facture_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	   $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	   $select->where('eu_facture_prestation.visa IN (?)',array(0,1,2,3));
		
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1; 
	}
	
	
	public  function addvisafacturetechnoAction()  {
	   /* page immobilisation/addvisafacturetechno */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	   $id = $this->_request->getParam('id');
	   $visa = $this->_request->getParam('publier');
	   $facture = new Application_Model_EuFacturePrestation();
	   $m_facture  = new Application_Model_EuFacturePrestationMapper();
	   $m_facture->find($id,$facture);
		
	   $facture->setVisa($visa);         				 
       $m_facture->update($facture);
		
	   $this->_redirect('/immobilisation/listfacture');
	}
	
	
	
	//-- AGENT FILIERE --//
	public  function  listfacture1Action()  {
	   /* page immobilisation/listfacture1 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}	
		
	   $tabela = new Application_Model_DbTable_EuDevisPrestation();
	   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	   $select->setIntegrityCheck(false);
	   $select->join('eu_facture_prestation','eu_facture_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	   $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	   $select->where('eu_facture_prestation.visa IN (?)',array(1,2,3));
		
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	
	
	
	public  function  addfichesuiviAction()   {
	   /* page immobilisation/addfichesuivi */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		
	   $request = $this->getRequest();  
	   if($request->isPost()) {
		  $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try {
			  $date_id = Zend_Date::now();
			  $id_facture_prestation = $request->getParam("id_facture_prestation");
			  $id_fiche_besoin = $request->getParam("id_fiche_besoin");
			  $libelle_fiche = $request->getParam("libelle_fiche");
			  
              $fiche = new Application_Model_EuFicheBesoin();
	          $m_fiche = new Application_Model_EuFicheBesoinMapper();
			  
			  $fichesuivi = new Application_Model_EuFicheSuivi();
	          $m_fichesuivi = new Application_Model_EuFicheSuiviMapper();
			  
			  $facture = new Application_Model_EuFacturePrestation();
	          $m_facture = new Application_Model_EuFacturePrestationMapper();
			  
			  $devis = new Application_Model_EuDevisPrestation();
	          $m_devis  = new Application_Model_EuDevisPrestationMapper();
			  
			  $m_facture->find($id_facture_prestation,$facture);
			  
			  $id_devis_prestation = $facture->id_devis_prestation;
		      $m_devis->find($id_devis_prestation,$devis);
			  
			  $m_fiche->find($id_fiche_besoin,$fiche);
			  $fiche->setLivrer(1);
			  $m_fiche->update($fiche);
			  
			  $facture->setVisa(2);
			  $m_facture->update($facture);
			  
			  $tabela = new Application_Model_DbTable_EuDetailFicheBesoin();
	          $select = $tabela->select();
	          $select->where('id_fiche_besoin = ?',$devis->id_fiche_besoin);
	          $entries = $tabela->fetchAll($select);
			  
			  $fichesuivi->setId_fiche_besoin($id_fiche_besoin);
			  $fichesuivi->setId_facture_prestation($id_facture_prestation);
			  $fichesuivi->setLibelle_fiche_suivi($libelle_fiche);
			  $fichesuivi->setDate_fiche_suivi($date_id->toString('yyyy-MM-dd HH:mm:ss'));
              $m_fichesuivi->save($fichesuivi);
			  
			  $db->commit();
			  $sessionutilisateur->error = "Operation bien effectuee ...";
			  $this->_redirect('/immobilisation/listfacture1');
		 
		  } catch(Exception $exc) {			   
	         $db->rollback();
			 $this->view->facture = $facture;
             $this->view->devis = $devis;			 
	         $this->view->entries = $entries;
             $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
             return;
          }
		 
	   } else {
		   $id = $this->_request->getParam('id');
	       $facture = new Application_Model_EuFacturePrestation();
	       $m_facture  = new Application_Model_EuFacturePrestationMapper();
		   $m_facture->find($id,$facture);
			  
		   $id_devis_prestation = $facture->id_devis_prestation;
		   $devis = new Application_Model_EuDevisPrestation();
	       $m_devis  = new Application_Model_EuDevisPrestationMapper();
		   $m_devis->find($id_devis_prestation,$devis);
			  
		   $id_fiche_besoin = $devis->id_fiche_besoin;
			 
		   $tabela = new Application_Model_DbTable_EuDetailFicheBesoin();
	       $select = $tabela->select();
	       $select->where('id_fiche_besoin = ?',$id_fiche_besoin);
	       $entries = $tabela->fetchAll($select);

           $this->view->facture = $facture;
           $this->view->devis = $devis;			 
	       $this->view->entries = $entries;   
	    }
	}
	
	
	//-- AGENT ACNEV  --//
	public  function listfacture2Action()  {
	   /* page immobilisation/listfacture2 */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}	
		
	   $tabela = new Application_Model_DbTable_EuDevisPrestation();
	   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	   $select->setIntegrityCheck(false);
	   $select->join('eu_facture_prestation','eu_facture_prestation.id_devis_prestation = eu_devis_prestation.id_devis_prestation');
	   $select->join('eu_fiche_besoin','eu_fiche_besoin.id_fiche_besoin = eu_devis_prestation.id_fiche_besoin');
	   $select->where('eu_facture_prestation.visa IN (?)',array(2,3));
		
	   $entries = $tabela->fetchAll($select);   
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	
	public  function addpayeAction()  {
	  /* page immobilisation/addpaye */
	  $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	  $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	  if(!isset($sessionutilisateur->login))          { $this->_redirect('/administration/login');}
      if($sessionutilisateur->confirmation != "")     { $this->_redirect('/administration/confirmation');}
		 
	  $facture = new Application_Model_EuFacturePrestation();
	  $m_facture = new Application_Model_EuFacturePrestationMapper();
		 
	  $id = $this->_request->getParam('id');
	  $visa = $this->_request->getParam('publier');
		
	  $m_facture->find($id,$facture);
		 
	  $facture->setVisa($visa); 
      $facture->setPayer(1);		 
      $m_facture->update($facture);
			  	  
	  $this->_redirect('/immobilisation/listfacture2');
	}
	
	
	
	public function listimmoAction() {
	   /* page administration/listimmo */
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
	   if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
	  
	   $tabela = new Application_Model_DbTable_EuFicheImmobilisation();
	   $select = $tabela->select();
	   $select->where('traiter = ?',1);   
	   $entries = $tabela->fetchAll($select);
	   $this->view->entries = $entries;		   
       $this->view->tabletri = 1;
	}
	
	
	public  function listimmorestituerAction()   {
		/* page administration/listimmorestituer */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		$tabela = new Application_Model_DbTable_EuLettreImmobilisation();
		$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$select->setIntegrityCheck(false);
		$select->join('eu_fiche_immobilisation','eu_fiche_immobilisation.id_fiche_immobilisation = eu_lettre_immobilisation.id_fiche_immobilisation');
		$select->where('eu_fiche_immobilisation.traiter = ?',1);
		$select->where('eu_fiche_immobilisation.restituer = ?',1);
		$entries = $tabela->fetchAll($select);
		$this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	
	public function listimmoenstockAction()   {
		/* page administration/listimmoenstock */
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
		
		if(!isset($sessionutilisateur->login))        { $this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "")   { $this->_redirect('/administration/confirmation');}
		
		
		$tabela = new Application_Model_DbTable_EuFicheImmobilisation();
		$select = $tabela->select();
		$select->where('traiter = ?',1);
        $select->where('restituer = ?',0);		
		$entries = $tabela->fetchAll($select);
		
		$this->view->entries = $entries;		   
        $this->view->tabletri = 1;
	}
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

}


