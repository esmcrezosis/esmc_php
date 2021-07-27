<?php

class SmcipnController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
        include("Url.php");   
	}


	public function testAction() {
	   $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
	   //$this->_helper->layout->disableLayout();
	   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	}


	public function addfraisprojetAction()   {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
		   $this->_redirect('/');
		}
		
		$request = $this->getRequest();
	    if ($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction(); 
           try {
		        if(isset($_POST['objet_demande']) && $_POST['objet_demande'] != ""
				   && isset($_POST['code_membre_morale_demandeur']) && $_POST['code_membre_morale_demandeur'] != ""
				   && isset($_POST['type_appel_offre']) && $_POST['type_appel_offre'] != "" 
				   && isset($_POST['duree_projet']) && $_POST['duree_projet'] != "" 
				   )  {
                      $date_id = new Zend_Date(Zend_Date::ISO_8601);
                      /////////////////controle sur le code membre du demandeur
                      if(isset($_POST['code_membre_morale_demandeur']) && $_POST['code_membre_morale_demandeur'] != "") {
                        $membre = new Application_Model_EuMembre();
                        $membre_mapper = new Application_Model_EuMembreMapper();
                        $membre_mapper->find($_POST['code_membre_morale_demandeur'],$membre);
								
                        $membremorale = new Application_Model_EuMembreMorale();
                        $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                        $membremorale_mapper->find($_POST['code_membre_morale_demandeur'],$membremorale);
								
                        if(count($membre) == 0 && count($membremorale) == 0) {
                           $sessionmcnp->error = "Le Code Membre est erroné ...";
					       $this->_redirect('/smcipn/addfraisprojet');
                           return;
                        }
						 
                       }
					   
					   $utilisateur = new Application_Model_EuUtilisateurMapper();
                       $utilisateurRow = $utilisateur->findCodeGroupe("executante");
						
                       $acteur3 = new Application_Model_EuActeur();
                       $acteur3Row = $acteur3->findByCodeActeur3($utilisateurRow->code_membre);
					   
					   $demande = new Application_Model_EuDemande();
				       $m_demande = new Application_Model_EuDemandeMapper();
					   
					   $id_demande = $m_demande->findConuter() + 1;

					   $demande->setId_demande($id_demande);
					   $demande->setObjet_demande($_POST['objet_demande']);
					   $demande->setDescription_demande($_POST['description_demande']);
					   $demande->setDate_demande($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					   $demande->setCode_membre_morale($_POST['code_membre_morale_demandeur']);
					   $demande->setPublier(1);
					   $m_demande->save($demande);
					   
					   ///////////////////////////////////////////////////////////////////
                       $appeloffre = new Application_Model_EuAppelOffre();
                       $m_appeloffre = new Application_Model_EuAppelOffreMapper();
			
                       $id_appeloffre = $m_appeloffre->findConuter() + 1;
			
                       $numero_offre = strtoupper(Util_Utils::genererCodeSMS(9));
					   
					   $appeloffre->setId_appel_offre($id_appeloffre);
                       $appeloffre->setNumero_offre($numero_offre);
                       $appeloffre->setNom_appel_offre("Appel d'offre : ".$_POST['objet_demande']);
                       $appeloffre->setDescrip_appel_offre(NULL);
	                   $appeloffre->setType_appel_offre($_POST['type_appel_offre']);
					   $appeloffre->setType_smcipn($_POST['type_smcipn']);
                       $appeloffre->setId_utilisateur(1);
                       $appeloffre->setDuree_projet($_POST['duree_projet']);
                       $appeloffre->setPublier(1);
                       $appeloffre->setId_demande($id_demande);
                       $appeloffre->setCode_membre_morale($utilisateurRow->code_membre);
                       $appeloffre->setMembre_morale_executante($utilisateurRow->code_membre);
                       $appeloffre->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                       $m_appeloffre->save($appeloffre);

                       ///////////////////////////////////////////////////////////////////
					
					   $pck = Util_Utils::getParametre('pck', 'nr');
					   $pre = $_POST['duree_projet'];
					   
					   if($_POST["type_smcipn"] == 'smcipn') {
					     $investissement = $_POST['montant_proposition'] + $_POST['autre_budget'];
					     $salaire = ceil($investissement * (($pre / $pck) - 1));	
                       } elseif($_POST["type_smcipn"] == 'smci') {
					     $investissement = $_POST['montant_proposition'] + $_POST['autre_budget'];
                         $salaire = 0;
                       } elseif($_POST["type_smcipn"] == 'smcpn') {
					     $investissement = 0;
					     $salaire = $_POST['montant_salaire'];
					   }

                       $date_id = new Zend_Date(Zend_Date::ISO_8601);

					   $proposition = new Application_Model_EuProposition();
					   $m_proposition = new Application_Model_EuPropositionMapper();

					   $compt_proposition = $m_proposition->findConuter() + 1;
                       $proposition->setId_proposition($compt_proposition);
					   $proposition->setId_appel_offre($id_appeloffre);
					   $proposition->setId_utilisateur(1);
					   $proposition->setCode_membre_morale($sessionmembre->code_membre);
					   $proposition->setDisponible(0);
					   $proposition->setMontant_proposition($_POST['montant_proposition']);
					   $proposition->setMontant_salaire($salaire);
					   $proposition->setAutre_budget($_POST['autre_budget']);
					   $proposition->setChoix_proposition(1);
					   $proposition->setPreselection(1);
					   $proposition->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					   $m_proposition->save($proposition);

                       ///////////////////////////////////////////////////////////////////
		               $taux_frais = Util_Utils::getParametre('taux', 'frais');
					
                       $mont_frais = ceil((($investissement + $salaire) * $taux_frais / 100));
			           $mont_projet = ceil($investissement + $mont_frais + $salaire);
                       //Enregistrement dans la table eu_frais
					   $frais = new Application_Model_EuFrais();
					   $mfrais = new Application_Model_EuFraisMapper();	

                       $id_frais = $mfrais->findConuter() + 1;
                       $frais->setId_frais($id_frais)
                             ->setCode_gac($acteur3Row->code_acteur)
                             ->setPourcent_frais($taux_frais)
                             ->setMont_projet($mont_projet)
                             ->setDate_frais($date_id->toString('yyyy-MM-dd HH:mm:ss'))
                             ->setId_proposition($compt_proposition)
                             ->setMontant_proposition($_POST['montant_proposition'] + $_POST['autre_budget'])
                             ->setMontant_salaire($salaire)
                             ->setMontant_frais($mont_frais)
                             ->setDisponible(1)
                             ->setValider(0)
                             ->setId_utilisateur(1);
                        $mfrais->save($frais);
                        $db->commit();
                       ///////////////////////////////////////////////////////////////////
					   $sessionmembre->error = "Opération bien effectuée ...";
					   $this->_redirect('/smcipn/listdemandefrais');					    

                } else {
				    $sessionmembre->error = "Champs * obligatoire";
				}
		   
		   
		   } catch (Exception $exc) {				   
			  $db->rollback();
			  $sessionmcnp->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
              return;
		   }	   
		
		}
		
	}
	
	
	
	public function livrerdemandeAction() {
	       /* page espacepersonnel/livrerdemande - Livrer une demande */
		   $sessionmembre = new Zend_Session_Namespace('membre');
		   //$this->_helper->layout->disableLayout();
		   $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		   if (!isset($sessionmembre->code_membre)) {
			   $this->_redirect('/');
		   }
		   $id = (int) $this->_request->getParam('id');
		   
		   $demande = new Application_Model_EuDemande();
		   $m_demande = new Application_Model_EuDemandeMapper();
		   $m_demande->find($id, $demande);

		   $demande->setLivrer($this->_request->getParam('livrer'));
		   $m_demande->update($demande);
		   
		   $sessionmembre->errorlogin = "Validation de la livraison réussie ...";
		   $this->_redirect('/smcipn/listmesdemandefrais');   
	
	}
	
	
	public function listmesdemandefraisAction()   {
		/* page espacepersonnel/listdemandefrais - Liste des demandes facturés */
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
		   $this->_redirect('/');
		}
		
	    $frais = new Application_Model_DbTable_EuFrais();
		
		$select = $frais->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_proposition', 'eu_proposition.id_proposition = eu_frais.id_proposition');
		$select->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre');
		$select->join('eu_demande', 'eu_demande.id_demande = eu_appel_offre.id_demande');
		$select->where('eu_demande.code_membre_morale = ? ',$sessionmembre->code_membre);
        $resultSet = $frais->fetchAll($select);
		
		$this->view->entries = $resultSet;
	    $this->view->tabletri = 1;
	}
	
	
	
	public function listdemandefraisAction() {
		/* page espacepersonnel/listdemandefrais - Liste des demandes facturés */
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
		   $this->_redirect('/');
		}

	   //$frais = new Application_Model_EuFraisMapper();
       //if($sessionmembre->code_groupe == "executante" || $sessionmembre->code_groupe == "executante_pays" || $sessionmembre->code_groupe == "executante_region" || $sessionmembre->code_groupe == "executante_secteur" || $sessionmembre->code_groupe == "executante_agence") {
	   //$this->view->entries = $frais->fetchAll4($sessionmembre->code_source_create, $sessionmembre->code_monde_create, $sessionmembre->code_zone_create, $sessionmembre->id_pays, $sessionmembre->id_region, $sessionmembre->code_secteur_create, $sessionmembre->code_agence_create);
       //}else{
	   //$this->view->entries = $frais->fetchAllpropo($sessionmembre->code_membre);
       //}
	   
	   $frais = new Application_Model_DbTable_EuFrais();
		
	   $select = $frais->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
       $select->setIntegrityCheck(false);
	   $select->join('eu_proposition', 'eu_proposition.id_proposition = eu_frais.id_proposition');
	   $select->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre');
	   $select->join('eu_demande', 'eu_demande.id_demande = eu_appel_offre.id_demande');
	   $select->where('eu_proposition.code_membre_morale = ? ', $sessionmembre->code_membre);
       $resultSet = $frais->fetchAll($select);
		
	   $this->view->entries = $resultSet;
	   $this->view->tabletri = 1;
	   
	}
	
	
	public function listpropositionAction() {
		/* page espacepersonnel/listproposition - Liste des propositions */
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}

		$proposition = new Application_Model_EuPropositionMapper();
		$this->view->entries = $proposition->fetchAll2($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}
	
	
	
	
	public function listdemandeAction() {
		/* page espacepersonnel/listdemande - liste des demandes */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}

		$demande = new Application_Model_EuDemandeMapper();
		$this->view->entries = $demande->fetchAll2($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}
	
	
	
	


	
}

