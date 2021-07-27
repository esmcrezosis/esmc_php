<?php
     
class  EuPreinscriptionController extends Zend_Controller_Action {
        public function init() {
		    /* Initialize action controller here */
			$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
			if ($group == 'cm') {
                $menu = "<li><a id=\"new\" href=\"/eu-preinscription/new\" style=\"font-size:9px\">Nouveau</a></li>".
			            "<li><a id=\"new\" href=\"/eu-preinscription/index\" style=\"font-size:11px\">Inscriptions activees</a></li>";
                $this->view->placeholder("menu")->set($menu);
            }  elseif($group == 'filiere' or  $group == 'scmacnev' or  $group == 'technopole') {
		        $menu = "<li><a id=\"new\" href=\"/eu-preinscription/newm\" style=\"font-size:9px\">Nouveau</a></li>".
			            "<li><a id=\"new\" href=\"/eu-preinscription/morale\" style=\"font-size:11px\">Inscriptions activees</a></li>";
                $this->view->placeholder("menu")->set($menu);  
		    } elseif($group == 'productiong' or  $group == 'productionsg'  or  $group == 'productiond' or  $group == 'transformationg' or  $group == 'transformationsg' or  $group == 'transformationd' or  $group == 'distributiong' or  $group == 'distributionsg' or  $group == 'distributiond') {
		        $menu = "<li><a id=\"new\" href=\"/eu-preinscription/newmcreneau\" style=\"font-size:9px\">Nouveau</a></li>".
			            "<li><a id=\"new\" href=\"/eu-preinscription/morale\" style=\"font-size:11px\">Inscriptions activees</a></li>";
                $this->view->placeholder("menu")->set($menu);  
		    } elseif($group == 'scmg' or  $group == 'scmsg' or  $group == 'scmd') {
		        $menu = "<li><a id=\"new\" href=\"/eu-preinscription/newmose\" style=\"font-size:9px\">Nouveau</a></li>".
			            "<li><a id=\"new\" href=\"/eu-preinscription/morale\" style=\"font-size:11px\">Inscriptions activees</a></li>";
                $this->view->placeholder("menu")->set($menu);  
		    } elseif($group == 'scmgpbf' or  $group == 'scmsgpbf' or  $group == 'scmdpbf') {
		        $menu = "<li><a id=\"new\" href=\"/eu-preinscription/newmpbf\" style=\"font-size:9px\">Nouveau</a></li>".
			            "<li><a id=\"new\" href=\"/eu-preinscription/morale\" style=\"font-size:11px\">Inscriptions activees</a></li>";
                $this->view->placeholder("menu")->set($menu);  
		    } elseif($group == 'scmgkr' or  $group == 'scmsgkr' or  $group == 'scmdkr') {
		        $menu = "<li><a id=\"new\" href=\"/eu-preinscription/newmkr\" style=\"font-size:9px\">Nouveau</a></li>".
			            "<li><a id=\"new\" href=\"/eu-preinscription/morale\" style=\"font-size:11px\">Inscriptions activees</a></li>";
                $this->view->placeholder("menu")->set($menu);  
		    }
			$this->view->jQuery()->enable();
            $this->view->jQuery()->uiEnable();
		
		    //$liste = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $liste = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
            $codesecret = "";
            while(strlen($codesecret) != 8) {
              $codesecret .= $liste[rand(0,strlen($liste)-1)];
			}
		    $this->view->codesecret = $codesecret;
		}
		
		
		function preDispatch() {
		    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            if (!$auth->hasIdentity()) {
               $this->_redirect('login');
            } 
            else {
                $user = $auth->getIdentity();
                $group = $user->code_groupe;
			    if($user->code_agence == null) {
			      $this->view->user = $user;
                  return $this->_redirect('index2'); 
                }
                if ($group != 'caps' and $group != 'cm' 
				   and $group != 'filiere'
				   and $group != 'scmacnev'
				   and $group != 'technopole'
				   and $group != 'scmg'
				   and $group != 'scmsg'
				   and $group != 'scmd'
				   and $group != 'scmgpbf'
				   and $group != 'scmsgpbf'
				   and $group != 'scmdpbf'
				   and $group != 'scmgkr'
				   and $group != 'scmsgkr'
				   and $group != 'scmdkr'
				   and $group != 'productiong'and $group != 'productionsg'and $group != 'productiond'and $group != 'transformationg'and $group != 'transformationsg'and $group != 'transformationd' and $group != 'distributiong' and $group != 'distributionsg' and $group != 'distributiond') {
                   $this->view->user = $user;
                   return $this->_redirect('index2');
                }
                $this->view->user = $user;
            }
        }
		
		
		public function moraleAction() {
		
		}
		
		
		public function indexAction() {
            // action body
            $request = $this->_request;
            if ($request->isXmlHttpRequest()) {
               $this->_helper->layout->disableLayout();
            }
        }
		
		
		public function nationAction() {
        $t_religion = new Application_Model_DbTable_EuPays();
        $results = $t_religion->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_pays;
                $data[$i][1] = $value->nationalite;
            }
        }
            $this->view->data = $data;
        }
		
		
		public function religionAction() {
        $t_religion = new Application_Model_DbTable_EuReligion();
        $results = $t_religion->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_religion_membre;
                $data[$i][1] = $value->libelle_religion;
            }
        }
            $this->view->data = $data;
        }
		
		
		
		public function ncmppAction() {
	        // action body
            $request = $this->getRequest();
            $nom_membre = $request->nom_membre;
            if (isset($nom_membre)) $this->_helper->layout->disableLayout();
	           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
	        $id_preinscription = $request->id_preinscription;
            $this->view->id_preinscription = $id_preinscription;
            $code_agence = $user->code_agence;
            $request = $this->getRequest();
            $nom = $request->nom_membre;
            $this->view->nom = $nom;
            $prenom = $request->prenom_membre;
            $this->view->prenom = $prenom;
            $sexe = $request->sexe_membre;
            $this->view->sexe = $sexe;
            $datenais = $request->date_nais_membre;
            $this->view->datenais = $datenais;
            $sitmatr = $request->sitfam_membre;
            $this->view->sitmatr = $sitmatr;
            $prof = $request->profession_membre;
            $this->view->prof = $prof;
            $tel = $request->tel_membre;
            $this->view->tel = $tel;
            $ville = $request->ville_membre;
            $this->view->ville = $ville; 
            $pere = $request->pere_membre;
            $this->view->pere = $pere;
            $mere = $request->mere_membre;
            $this->view->mere = $mere;
	        $qartresid = $request->quartier_membre;
            $this->view->quartier_membre = $qartresid;
	        $bp = $request->bp_membre;
            $this->view->bp = $bp;
	        $nbrenf = $request->nbr_enf_membre;
            $this->view->nbre_enf = $nbrenf;
	        $email = $request->email_membre;
            $this->view->email = $email;
	        $portable = $request->portable_membre;
            $this->view->portable = $portable;
	        $formation = $request->formation;
            $this->view->formation = $formation;
	        $lieunais = $request->lieu_nais_membre;
            $this->view->lieu_nais = $lieunais;
	        $id_pays = $request->id_pays;
            $this->view->id_pays = $id_pays;
	        $id_religion = $request->id_religion;
            $this->view->id_religion = $id_religion;
	        $code_fs = $request->code_fs;
            $this->view->code_fs = $code_fs;
	        $code_fl = $request->code_fl;
            $this->view->code_fl = $code_fl;
	        $code_fkps = $request->code_fkps;
            $this->view->code_fkps = $code_fkps;
			
		    if ($this->getRequest()->isPost())  {
			   $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               $membre = new Application_Model_EuMembre();
               $mapper = new Application_Model_EuMembreMapper();
			   $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
			   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			   $fs = Util_Utils::getParametre('fs','valeur');
			   $mont_fl = Util_Utils::getParametre('fl','valeur');
			   $mont_cps = Util_Utils::getParametre('fcps','valeur');
		       $tcartes = array();
			   $tscartes = array();
			   $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			   try {
				    $code_fs = $_POST["code_fs"];
				    $code_fl = $_POST["code_fl"];
				    $code_fkps = $_POST["code_fkps"];
					
					if($code_fs != "") {
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                           $code = $code_agence . '0000001' . 'p';
                        } 
                        else {
                           $num_ordre = substr($code, 12, 7);
                           $num_ordre++;
                           $num_ordre_bis = str_pad($num_ordre, 7, 0, str_pad_left);
                           $code = $code_agence . $num_ordre_bis . 'p';
                        }
						$sms_fs = $sms_mapper->findByCreditCode($code_fs);
						
						if ($sms_fs == null) {
                            $db->rollback();
                            $this->view->message = 'Le code fs [' . $code_fs . ']  est  invalide !!!';
                            $this->view->nom_membre = $_POST["nom_membre"];
                            $this->view->prenom_membre = $_POST["prenom_membre"];
                            $this->view->sexe = $_POST["sexe_membre"];
                            $this->view->sitfam = $_POST["sitfam_membre"];
                            $this->view->datnais = $_POST["date_nais_membre"];
                            $this->view->nation = $_POST["nationalite_membre"];
                            $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                            $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                            $this->view->formation = $_POST["formation"];
                            $this->view->profession = $_POST["profession_membre"];
                            $this->view->religion = $_POST["religion_membre"];
                            $this->view->pere = $_POST["pere_membre"];
                            $this->view->mere = $_POST["mere_membre"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            return;
                        }
						
						if($sms_fs->getMotif() != 'fs') {
					      $db->rollBack();
                          $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                          $this->view->nom_membre = $_POST["nom_membre"];
                          $this->view->prenom_membre = $_POST["prenom_membre"];
                          $this->view->sexe = $_POST["sexe_membre"];
                          $this->view->sitfam = $_POST["sitfam_membre"];
                          $this->view->datnais = $_POST["date_nais_membre"];
                          $this->view->nation = $_POST["nationalite_membre"];
                          $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                          $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                          $this->view->formation = $_POST["formation"];
                          $this->view->profession = $_POST["profession_membre"];
                          $this->view->religion = $_POST["religion_membre"];
                          $this->view->pere = $_POST["pere_membre"];
                          $this->view->mere = $_POST["mere_membre"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          return;    
					    }		
						
						$date_nais = new Zend_Date($_POST["date_nais_membre"]);
						if ($date_nais >= $date_idd) {
                            $this->view->message = "Erreur d'éxecution: La date de naissance doit être antérieure à la date actuelle !!!";
                            $db->rollback();
                            $this->view->nom_membre = $_POST["nom_membre"];
                            $this->view->prenom_membre = $_POST["prenom_membre"];
                            $this->view->sexe = $_POST["sexe_membre"];
                            $this->view->sitfam = $_POST["sitfam_membre"];
                            $this->view->datnais = $_POST["date_nais_membre"];
                            $this->view->nation = $_POST["nationalite_membre"];
                            $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                            $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                            $this->view->formation = $_POST["formation"];
                            $this->view->profession = $_POST["profession_membre"];
                            $this->view->religion = $_POST["religion_membre"];
                            $this->view->pere = $_POST["pere_membre"];
                            $this->view->mere = $_POST["mere_membre"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            return;
                        }
						$membre->setCode_membre($code)
                               ->setNom_membre($_POST["nom_membre"])
                               ->setPrenom_membre($_POST["prenom_membre"])
                               ->setSexe_membre($_POST["sexe_membre"])
                               ->setDate_nais_membre($date_nais->toString('yyyy-mm-dd'))
                               ->setId_pays($_POST["nationalite_membre"])
                               ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                               ->setPere_membre($_POST["pere_membre"])
                               ->setMere_membre($_POST["mere_membre"])
                               ->setSitfam_membre($_POST["sitfam_membre"])
                               ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                               ->setProfession_membre($_POST["profession_membre"])
                               ->setFormation($_POST["formation"])
                               ->setId_religion_membre($_POST["religion_membre"])
                               ->setQuartier_membre($_POST["quartier_membre"])
                               ->setVille_membre($_POST["ville_membre"])
                               ->setBp_membre($_POST["bp_membre"])
                               ->setTel_membre($_POST["tel_membre"])
                               ->setEmail_membre($_POST["email_membre"])
                               ->setPortable_membre($_POST["portable_membre"])
                               ->setId_utilisateur($user->id_utilisateur)
                               ->setHeure_identification($date_idd->toString('hh:mm:ss'))
                               ->setDate_identification($date_id->toString('yyyy-mm-dd'))
                               ->setCode_agence($user->code_agence)
						       ->setCodesecret(md5($_POST["codesecret"]))
						       ->setEtat_membre('n');
                        $mapper->save($membre);
						
						
						// Mise à jour de la table eu_ancien_membre
                        $p_mapper = new Application_Model_EuPreinscriptionMapper();
                        $p = new Application_Model_EuPreinscription();
                        $rep = $p_mapper->find($_POST["id_preinscription"],$p);
                        if ($rep == true) {      
                           $p->setCode_membre($code);
                           $p_mapper->update($p);      
                        }
						
						// Mise à jour des comptes bancaires
						$cb_mapper = new Application_Model_EuCompteBancaireMapper();
                        $cb = new Application_Model_EuCompteBancaire();
						$comptebancaires = $cb_mapper->findByPreinscri($_POST["id_preinscription"]);
						   
						if ($comptebancaires != false) {
							$j = 0;
                            $nbre_cb = count($comptebancaires);
						    while ($j < $nbre_cb) { 
							  $comptebancaire = $comptebancaires[$j];
                              $id_compte = $comptebancaire->getId_compte(); 
                              $cb_mapper->find($id_compte,$cb);
                              $cb->setCode_membre($code);
                              $cb_mapper->update($cb);
                              $j++;
         				    }
						}
						
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteurfs = $mapper_op->findConuter() + 1;
                        $lib_op = 'Auto-enrôlement';
                        $type_op = 'aerl';
                        Util_Utils::addOperation($compteurfs,$code,null,'tfs',$fs,'fs',$lib_op,$type_op,$date_idd->toString('yyyy-mm-dd'), $date_id->toString('hh:mm:ss'), $user->id_utilisateur);
                        
						$tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre($code)
						         ->setCode_membre_morale(null)
                                 ->setCode_fs('fs-' . $code)
                                 ->setCreditcode($sms_fs->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-mm-dd'))
                                 ->setHeure_fs($date_idd->toString('hh:mm:ss'))
                                 ->setId_utilisateur($user->id_utilisateur)
                                 ->setMont_fs($fs);
                        $tab_fs->insert($fs_model->toArray());
						
						$sms_fs->setDestAccount_Consumed('nb-tfs-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fs);
						 
						$userin = new Application_Model_EuUtilisateur();
                        $mapper = new Application_Model_EuUtilisateurMapper();
                        $id_user = $mapper->findConuter() + 1;
                        $userin->setId_utilisateur($id_user)
                               ->setId_utilisateur_parent($user->id_utilisateur)
                               ->setPrenom_utilisateur($_POST["prenom_membre"])
                               ->setNom_utilisateur($_POST["nom_membre"])
                               ->setLogin($code)
                               ->setPwd(md5($_POST["codesecret"]))
                               ->setDescription(null)
                               ->setUlock(0)
                               ->setCh_pwd_flog(0)
                               ->setCode_groupe('personne_physique')
					           ->setCode_groupe_create('personne_physique')
                               ->setConnecte(0)
                               ->setCode_agence($user->code_agence)
                               ->setCode_secteur(null)
                               ->setCode_zone($user->code_zone)
                                 //->setCode_gac_filiere(null)
		                       ->setId_pays($user->id_pays)	    	
                               ->setCode_acteur($user->code_acteur)
					           ->setCode_membre($code);    
                        $mapper->save($userin);
							
					    // Mise à jour de la table eu_contrat
                        $contrat = new Application_Model_EuContrat();
		                $mapper_contrat = new Application_Model_EuContratMapper();
		                $id_contrat = $mapper->findConuter() + 1;
				        $contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_id->toString('yyyy-mm-dd'));
                        $contrat->setNature_contrat('numerique');
                        $contrat->setId_type_contrat(null);
                        $contrat->setId_type_creneau(null);
                        $contrat->setId_type_acteur(null);
                        $contrat->setId_pays(null);
                        $contrat->setId_utilisateur($user->id_utilisateur);
                        $contrat->setFiliere(null);
                        $mapper_contrat->save($contrat);
							
					    $acteur = $user->code_acteur;
				        $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
                        $count = $c_acteur->findConuter() + 1;
					    $table = new Application_Model_DbTable_EuActeur();
					
					    if(isset($_POST["actcmfh"])) { 
                            $select = $table->select();
					        $select->where('code_acteur like ?', $acteur);
					        $resultSet = $table->fetchAll($select);
					        $ligneacteur = $resultSet->current();
                            $c_acteur->setId_acteur($count);
                            $c_acteur->setCode_acteur(null);
                            $c_acteur->setCode_membre($code);
                            $c_acteur->setId_utilisateur($user->id_utilisateur);
                            $c_acteur->setDate_creation($date_idd->toString('yyyy-mm-dd'));
				            $c_acteur->setCode_activite(null);
				            $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
					        $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					        $c_acteur->setId_pays($ligneacteur->id_pays);
					        $c_acteur->setId_region($ligneacteur->id_region);
					        $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					        $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);	
                            $c_acteur->setType_acteur('cmfh');
				            $c_acteur->setCode_gac_chaine($acteur);         
                            $t_acteur->insert($c_acteur->toArray());
					   
					}   else if(isset($_POST["actenro"])) { 
					        $select = $table->select();
					        $select->where('code_acteur like ?', $acteur);
					        $resultSet = $table->fetchAll($select);
					        $ligneacteur = $resultSet->current();
                            $c_acteur->setId_acteur($count);
                            $c_acteur->setCode_acteur(null);
                            $c_acteur->setCode_membre($code);
                            $c_acteur->setId_utilisateur($user->id_utilisateur);
                            $c_acteur->setDate_creation($date_idd->toString('yyyy-mm-dd'));
				            $c_acteur->setCode_activite(null);
				            $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
					        $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					        $c_acteur->setId_pays($ligneacteur->id_pays);
					        $c_acteur->setId_region($ligneacteur->id_region);
					        $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					        $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					        $c_acteur->setType_acteur('dsms');
				            $c_acteur->setCode_gac_chaine($acteur);         
                            $t_acteur->insert($c_acteur->toArray());
					}

                    } else {
                        $this->view->message = "Erreur d'éxecution: Le code fs est inexistant !!!";
                        $db->rollback();
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;  
                    }
					
					if($code_fl != "") {
					    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
						if ($sms_fl == null) {
                           $db->rollback();
                           $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
                           $this->view->nom_membre = $_POST["nom_membre"];
                           $this->view->prenom_membre = $_POST["prenom_membre"];
                           $this->view->sexe = $_POST["sexe_membre"];
                           $this->view->sitfam = $_POST["sitfam_membre"];
                           $this->view->datnais = $_POST["date_nais_membre"];
                           $this->view->nation = $_POST["nationalite_membre"];
                           $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                           $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                           $this->view->formation = $_POST["formation"];
                           $this->view->profession = $_POST["profession_membre"];
                           $this->view->religion = $_POST["religion_membre"];
                           $this->view->pere = $_POST["pere_membre"];
                           $this->view->mere = $_POST["mere_membre"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           return;
                        }
						
						if($sms_fl->getMotif() != 'fl') {
					      $db->rollBack();
                          $this->view->message = " Le motif pour lequel ce code fl est émis ne correspond pas pour ce type d'operation";
                          $this->view->nom_membre = $_POST["nom_membre"];
                          $this->view->prenom_membre = $_POST["prenom_membre"];
                          $this->view->sexe = $_POST["sexe_membre"];
                          $this->view->sitfam = $_POST["sitfam_membre"];
                          $this->view->datnais = $_POST["date_nais_membre"];
                          $this->view->nation = $_POST["nationalite_membre"];
                          $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                          $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                          $this->view->formation = $_POST["formation"];
                          $this->view->profession = $_POST["profession_membre"];
                          $this->view->religion = $_POST["religion_membre"];
                          $this->view->pere = $_POST["pere_membre"];
                          $this->view->mere = $_POST["mere_membre"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          return;    
					    }
						
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'fl-' . $code;
						
						$fl->setCode_fl($code_fl)
                           ->setCode_membre($code)
						   ->setCode_membre_morale(null)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-mm-dd'))
                           ->setHeure_fl($date_idd->toString('hh:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('fl', 'nn', 'e', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('fl')
                                    ->setIntitule('Frais de licence')
                                    ->setService('e')
                                    ->setCode_type_compte('nn')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						
						$compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,$code,null, null, $mont_fl, null, 'Frais de licences', 'fl',$date_idd->toString('yyyy-mm-dd'),$date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
						
						$sms_fl->setDestAccount_Consumed('fl-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fl);
						
						$tcartes[0]="tpagcrpg";
						$tcartes[1]="tcncs";
					    $tcartes[2]="TPaNu";
					    $tcartes[3]="TPaR";
						$tcartes[4]="tr";
						$tcartes[5]="capa";
							 
						$tscartes[0]="tsrpg";
					    $tscartes[1]="tscncs";
						$tscartes[2]="TSPaNu";
						$tscartes[3]="TSPaR";
						$tscartes[4]="tscapa";
						
						for($i = 0; $i < count($tcartes); $i++) {
						    if($tcartes[$i] == "tcncs") {
                                $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
							    $type_carte = 'nr';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tr" || $tcartes[$i] == "capa") {
                                $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'nn';
							    $res = $map_compte->find($code_compte,$compte);
							} else  {
								$code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'nb';
							    $res = $map_compte->find($code_compte,$compte);
							}
										
						    if(!$res) {
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre($code)
									   ->setCode_membre_morale(null)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
							    $map_compte->save($compte);
									
							}
									
                        }
						
						for($j = 0; $j < count($tscartes); $j++) {
							if($tscartes[$j] == "tscncs") {
                              $code_comptets = 'nr' . '-' . $tscartes[$j] . '-' . $code;
							  $type_carte = 'nr';
							  $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "tr" || $tscartes[$j] == "tscapa") {
                              $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
							  $type_carte = 'nn';
							  $res = $map_compte->find($code_comptets,$compte);
						    } else {
							  $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
							  $type_carte = 'nb';
							  $res = $map_compte->find($code_comptets,$compte);
							}			
							if(!$res) {
                                $compte->setCode_cat($tscartes[$j])
                                       ->setCode_compte($code_comptets)
                                       ->setCode_membre($code)
									   ->setCode_membre_morale(null)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tscartes[$j])
                                       ->setSolde(0);
							    $map_compte->save($compte);		
							}	
						}
						
					}
					
					if($code_fkps != "") {
                        $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
						if ($sms_fkps == null) {
                           $db->rollback();
                           $this->view->message = 'Le code fkps [' . $code_fkps . ']  est  invalide !!!';
                           $this->view->nom_membre = $_POST["nom_membre"];
                           $this->view->prenom_membre = $_POST["prenom_membre"];
                           $this->view->sexe = $_POST["sexe_membre"];
                           $this->view->sitfam = $_POST["sitfam_membre"];
                           $this->view->datnais = $_POST["date_nais_membre"];
                           $this->view->nation = $_POST["nationalite_membre"];
                           $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                           $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                           $this->view->formation = $_POST["formation"];
                           $this->view->profession = $_POST["profession_membre"];
                           $this->view->religion = $_POST["religion_membre"];
                           $this->view->pere = $_POST["pere_membre"];
                           $this->view->mere = $_POST["mere_membre"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           return;
                        }
						
						if($sms_fkps->getMotif() != 'fkps') {
					      $db->rollBack();
                          $this->view->message = " Le motif pour lequel ce code fkps est émis ne correspond pas pour ce type d'operation";
                          $this->view->nom_membre = $_POST["nom_membre"];
                          $this->view->prenom_membre = $_POST["prenom_membre"];
                          $this->view->sexe = $_POST["sexe_membre"];
                          $this->view->sitfam = $_POST["sitfam_membre"];
                          $this->view->datnais = $_POST["date_nais_membre"];
                          $this->view->nation = $_POST["nationalite_membre"];
                          $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                          $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                          $this->view->formation = $_POST["formation"];
                          $this->view->profession = $_POST["profession_membre"];
                          $this->view->religion = $_POST["religion_membre"];
                          $this->view->pere = $_POST["pere_membre"];
                          $this->view->mere = $_POST["mere_membre"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          return;    
					    } 
						
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
						$id_demande = $carte->findConuter() + 1;
						$carte->setId_demande($id_demande)
							  ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($mont_cps)
                              ->setDate_demande($date_idd->toString('yyyy-mm-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("nb-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur($user->id_utilisateur);
                        $t_carte->insert($carte->toArray()); 
						$compteurcps = $mapper_op->findConuter() + 1; 
						Util_Utils::addOperation($compteurcps, $code,null, null, $mont_cps, null, 'Frais de cps', 'cps', $date_idd->toString('yyyy-mm-dd'), $date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
                        $sms_fkps->setDestAccount_Consumed('cps-'.$code)
                            ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fkps);    
					}
					
                    $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code ."  Votre Code Secret est : " .$_POST["codesecret"]); 
                    $db->commit();
                    return $this->_helper->redirector('index');	
				} catch (Exception $exc) {
				    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
					$db->rollback();
                    $this->view->nom_membre = $_POST["nom_membre"];
                    $this->view->prenom_membre = $_POST["prenom_membre"];
                    $this->view->sexe = $_POST["sexe_membre"];
                    $this->view->sitfam = $_POST["sitfam_membre"];
                    $this->view->datnais = $_POST["date_nais_membre"];
                    $this->view->nation = $_POST["nationalite_membre"];
                    $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                    $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                    $this->view->formation = $_POST["formation"];
                    $this->view->profession = $_POST["profession_membre"];
                    $this->view->religion = $_POST["religion_membre"];
                    $this->view->pere = $_POST["pere_membre"];
                    $this->view->mere = $_POST["mere_membre"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    return;
                }
				
			}
	}
	

    public function datacreneauAction() {
	
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'id_preinscription_morale');
           $sord = $this->_request->getParam("sord", 'asc');
	       $membre = $this->_request->getParam("membre");
	       $tabela = new Application_Model_DbTable_EuPreinscriptionMorale();
			   
		   $select = $tabela->select();
           $select->from($tabela,array('eu_preinscription_morale.*',"to_char((eu_preinscription_morale.date_inscription),'dd/mm/yyyy') dateidentif"))
				  ->where('code_membre_morale is null');	 		  
	       $cats = $tabela->fetchAll($select);
           $count = count($cats);
				
				
		   if ($count > 0) {
               $total_pages = ceil($count / $limit);
           } else {
               $total_pages = 0;
           }
				
		   if ($page > $total_pages)
               $page = $total_pages;
           $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
           $responce['page'] = $page;
           $responce['total'] = $total_pages;
           $responce['records'] = $count;
           $i = 0;
           foreach ($cats as $row) {
              $responce['rows'][$i]['id'] = $row->id_preinscription_morale;
              $responce['rows'][$i]['cell'] = array(
              $row->id_preinscription_morale,
              $row->raison_sociale,
              $row->quartier_membre,
              $row->ville_membre,
              $row->bp_membre,
              $row->tel_membre, 
              $row->dateidentif,
              $row->portable_membre,
		      $row->email_membre,
		      $row->site_web,
		      $row->num_registre_membre,
			  $row->numero_agrement_filiere,
			  $row->numero_agrement_acnev,
			  $row->numero_agrement_technopole,
			  $row->code_fs,
			  $row->code_fl,
			  $row->code_rep,
			  $row->code_fkps,
			  $row->domaine_activite,
			  $row->code_type_acteur,
			  $row->code_statut,
			  $row->id_pays
            );
            $i++;
        }
        $this->view->data = $responce;
	
	}
	
	
	public function dataoseAction()  {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'id_preinscription_morale');
            $sord = $this->_request->getParam("sord", 'asc');
	        $membre = $this->_request->getParam("membre");
	        $tabela = new Application_Model_DbTable_EuPreinscriptionMorale();
			   
			$select = $tabela->select();
            $select->from($tabela,array('eu_preinscription_morale.*',"to_char((eu_preinscription_morale.date_inscription),'dd/mm/yyyy') dateidentif"))
				   ->where('code_membre_morale is null');	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);
				
				
		    if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }
				
			if ($page > $total_pages)
               $page = $total_pages;
            $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($cats as $row) {
                $responce['rows'][$i]['id'] = $row->id_preinscription_morale;
                $responce['rows'][$i]['cell'] = array(
                $row->id_preinscription_morale,
                $row->raison_sociale,
                $row->quartier_membre,
                $row->ville_membre,
                $row->bp_membre,
                $row->tel_membre, 
                $row->dateidentif,
                $row->portable_membre,
		        $row->email_membre,
		        $row->site_web,
				$row->num_registre_membre,
				$row->numero_agrement_filiere,
				$row->numero_agrement_acnev,
				$row->numero_agrement_technopole,
				$row->code_fs,
				$row->code_fl,
				$row->code_rep,
				$row->code_fkps,
				$row->domaine_activite,
				$row->code_type_acteur,
				$row->code_statut,
				$row->id_pays
            );
                $i++;
            }
            $this->view->data = $responce;
	}
	
	
	
	
    public function datafiliereAction() {
		    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'id_preinscription_morale');
            $sord = $this->_request->getParam("sord", 'asc');
	        $membre = $this->_request->getParam("membre");
	        $tabela = new Application_Model_DbTable_EuPreinscriptionMorale();
			   
			$select = $tabela->select();
            $select->from($tabela,array('eu_preinscription_morale.*',"to_char((eu_preinscription_morale.date_inscription),'dd/mm/yyyy') dateidentif"))
				   ->where('code_membre_morale is null');	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);
				
				
		    if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }
				
			if ($page > $total_pages)
               $page = $total_pages;
            $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($cats as $row) {
                $responce['rows'][$i]['id'] = $row->id_preinscription_morale;
                $responce['rows'][$i]['cell'] = array(
                $row->id_preinscription_morale,
                $row->raison_sociale,
                $row->quartier_membre,
                $row->ville_membre,
                $row->bp_membre,
                $row->tel_membre, 
                $row->dateidentif,
                $row->portable_membre,
		        $row->email_membre,
		        $row->site_web,
				$row->num_registre_membre,
				$row->numero_contrat,
				$row->code_fs,
				$row->code_fl,
				$row->code_rep,
				$row->code_fkps,
				$row->domaine_activite,
				$row->code_type_acteur,
				$row->code_statut,
				$row->id_pays
            );
                $i++;
            }
            $this->view->data = $responce;
	}

	
	
	
    public function newmAction() {
		
		        
    }
		
	
    public function newmoseAction() {
		
		        
    }

	
    public function newmcreneauAction() {
		
		        
    }

	
    public function newmpbfAction() {
		
		        
    }	
		
	
    public function newmkrAction() {
		
		        
    }	
	


	
    public function ncmmmkrAction() {
	    $request = $this->getRequest();
        $raison_sociale = $request->raison_sociale;
        $this->view->raison_sociale = $raison_sociale;
		
		if(isset($raison_sociale)) $this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_agence = $user->code_agence;
        $fs = Util_Utils::getParametre('fs', 'valeur');
        $this->view->fs = $fs;
        $request = $this->getRequest();
        $id_preinscription_morale = $request->id_preinscription_morale;
        $this->view->id_preinscription_morale = $id_preinscription_morale;
        $ville = $request->ville_membre;
        $this->view->ville = $ville;
        $tel = $request->tel_membre;
        $this->view->tel = $tel;
	    $qart = $request->quartier_membre;
        $this->view->quartier_membre = $qart;
	    $portable = $request->portable_membre;
        $this->view->portable = $portable;
	    $email = $request->email_membre;
        $this->view->email = $email;
	    $site = $request->site_web;
        $this->view->site_web = $site;
	    $bp = $request->bp_membre;
        $this->view->bp = $bp;
			  
	    $numero_agrement_filiere = $request->numero_agrement_filiere;
		$numero_agrement_acnev = $request->numero_agrement_acnev;
		$numero_agrement_technopole = $request->numero_agrement_technopole;
			  
        $this->view->agrement_filiere = $numero_agrement_filiere;
	    $this->view->agrement_acnev = $numero_agrement_acnev;
	    $this->view->agrement_technopole = $numero_agrement_technopole;
			  
		$num_registre = $request->num_registre;
        $this->view->num_registre = $num_registre;
		$code_rep = $request->code_rep;
        $this->view->code_rep = $code_rep;
	    $code_fs = $request->code_fs;
        $this->view->code_fs = $code_fs;
	    $code_fl = $request->code_fl;
        $this->view->code_fl = $code_fl;
	    $code_fkps = $request->code_fkps;
        $this->view->code_fkps = $code_fkps;
		$domaine_activite = $request->domaine_activite;
        $this->view->domaine_activite = $domaine_activite;
		$code_type_acteur = $request->code_type_acteur;
        $this->view->type_acteur = $code_type_acteur;
	    $code_statut = $request->code_statut;
        $this->view->statut_juridique = $code_statut;
		   
		$utilisateur = $user->id_utilisateur;
		$groupe = $user->code_groupe;
		$acteur = $user->code_acteur;
		
		if ($this->getRequest()->isPost()) {
		    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
		    $request = $this->getRequest();
		    $type_gac = $request->type_gac;
		    $this->view->type_gac = $type_gac;
            $code_agence = $user->code_agence;
		    $acteur      =  $user->code_acteur;
				   
            $fs = Util_Utils::getParametre('fs','valeur');
			$mont_fl = Util_Utils::getParametre('fl','valeur');
			$fcps = Util_Utils::getParametre('fcps','valeur');
				   
			$date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
            $code_fs = $_POST["code_fs"];
			$code_fl = $_POST["code_fl"];
			$code_fkps = $_POST["code_fkps"];
			$membre = new Application_Model_EuMembreMorale();
            $mapper = new Application_Model_EuMembreMoraleMapper();
            $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			$agrement_mapper = new Application_Model_EuAgrementMapper();
            $agrement        = new Application_Model_EuAgrement();
            $compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
			$tcartes = array();
			$tscartes = array();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			if ($this->getRequest()->isPost()) {
			
			    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
                $user = $auth->getIdentity();
		        $request = $this->getRequest();
		        $type_gac = $request->type_gac;
		        $this->view->type_gac = $type_gac;
                $code_agence = $user->code_agence;
		        $acteur      =  $user->code_acteur;
				   
                $fs = Util_Utils::getParametre('fs','valeur');
			    $mont_fl = Util_Utils::getParametre('fl','valeur');
			    $fcps = Util_Utils::getParametre('fcps','valeur');
				   
			    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $code_fs = $_POST["code_fs"];
			    $code_fl = $_POST["code_fl"];
			    $code_fkps = $_POST["code_fkps"];
			    $membre = new Application_Model_EuMembreMorale();
                $mapper = new Application_Model_EuMembreMoraleMapper();
                $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			    $agrement_mapper = new Application_Model_EuAgrementMapper();
                $agrement        = new Application_Model_EuAgrement();
                $compte = new Application_Model_EuCompte();
                $map_compte = new Application_Model_EuCompteMapper();
			    $tcartes = array();
			    $tscartes = array();
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
				
				try {
				    if($code_fs !="") {
					    $sms_fs = $sms_mapper->findByCreditCode($code_fs);
                        $agrement_filiere  =  $_POST["agrement_filiere"];
                        $agrement_acnev    =  $_POST["agrement_acnev"];
                        $agrement_technopole =  $_POST["agrement_technopole"];
						
					    if ($sms_fs != null)  {
                            if($sms_fs->getMotif() != 'fs') {
                              $db->rollBack();
                              $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                              $this->view->type_acteur = $_POST["type_acteur"];
                              $this->view->statut_juridique = $_POST["statut_juridique"];
                              $this->view->raison = $_POST["raison_sociale"];
                              $this->view->domaine_activite = $_POST["domaine_activite"];
                              $this->view->site_web = $_POST["site_web"];
                              $this->view->quartier_membre = $_POST["quartier_membre"];
                              $this->view->ville_membre = $_POST["ville_membre"];
                              $this->view->bp = $_POST["bp_membre"];
                              $this->view->tel = $_POST["tel_membre"];
                              $this->view->email = $_POST["email_membre"];
                              $this->view->portable = $_POST["portable_membre"];
                              //$this->view->profession = $_POST["profession_membre"];
                              $this->view->registre = $_POST["num_registre"];
                              return;    
                            }							
						
						//insertion dans la table membremorale des information du nouveau membre
                        //$membre = new Application_Model_EuMembreMorale();
                        //$mapper = new Application_Model_EuMembreMoraleMapper();
						$membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'm';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, str_pad_left);
                            $code = $code_agence . $num_ordre_bis . 'm';
                        }  

                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
						
						if($trouveagrementf != false) {
                            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
                            $membre->setId_filiere($membre1->getId_filiere());
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(htmlentities (addslashes (trim ($_POST["raison_sociale"]))));
                            $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(htmlentities (addslashes (trim ($_POST["domaine_activite"]))));
                            $membre->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))));
                            $membre->setQuartier_membre(htmlentities (addslashes (trim ($_POST["quartier_membre"]))));
                            $membre->setVille_membre(htmlentities (addslashes (trim ($_POST["ville_membre"]))));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($utilisateur);
                            $membre->setHeure_identification($date_idd->toString('hh:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-mm-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('o');
                            $membre->setEtat_membre('n');
                            $mapper->save($membre);
                            
                            // eu_acteurs_creneau
                            $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
                            
                            $acren->setNom_acteur(htmlentities (addslashes (trim ($_POST["raison_sociale"]))));
                            $acren->setCode_membre($code);
                            if($code_groupe == 'scmdkr'){
                               $acren->setId_type_acteur(3);
                            } elseif($code_groupe == 'scmsgkr' ){
                               $acren->setId_type_acteur(2);
                            } elseif($code_groupe == 'scmgkr') {
                               $acren->setId_type_acteur(1);
                            }
                            //$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                            $acren->setId_utilisateur($utilisateur);
                            $acren->setGroupe($code_groupe);
                            $acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
                            
                            
                            $code_zone = $user->code_zone;
                            $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'a' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'a' . $code_zone . str_pad($num_ordre, 4, 0, STR_PaD_LEFT);
                           }
                        
                           $acren->setCode_acteur($code_acteur);
                           $acren->setId_filiere($membre1->getId_filiere());
                           $cm->save($acren);   
                            
                           // eu_operation
                           Util_Utils::addOperation($compteur,null,$code,'tfs', $frais_identification, 'fs', 'Auto-enrôlement', 'aerl', $date_idd->toString('yyyy-mm-dd'), $date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
                            
                           //insertion dans la table eu_representation
                           $rep_mapper = new Application_Model_EuRepresentationMapper();
                           $rep = new Application_Model_EuRepresentation();
                           $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-mm-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                        
                            // Mise à jour des comptes bancaires
						    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $cb = new Application_Model_EuCompteBancaire();
						    $comptebancaires = $cb_mapper->findByPreinscrimorale($_POST["id_preinscription_morale"]);
						   
						    if ($comptebancaires != false) {
							    $j = 0;
                                $nbre_cb = count($comptebancaires);
						        while ($j < $nbre_cb) { 
							       $comptebancaire = $comptebancaires[$j];
                                   $id_compte = $comptebancaire->getId_compte(); 
                                   $cb_mapper->find($id_compte,$cb);
                                   $cb->setCode_membre_morale($code);
                                   $cb_mapper->update($cb);
                                   $j++;
         				        }
						    }                           
                        
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
						
						
                        if($trouveagrementacnev != false) {
                            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
						
                        if($trouveagrementtechno != false) {
                            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                               $db->rollBack();
                               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
                               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
                        }
						
					    $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $count = $c_acteur->findConuter() + 1;
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                               
                            if($code_groupe == 'scmdkr') {
                                  $c_acteur->setCode_activite('detaillant');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                            } elseif($code_groupe == 'scmsgkr' ){
                                  $c_acteur->setCode_activite('semi-grossiste');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                            } elseif($code_groupe == 'scmgkr') {
                                  $c_acteur->setCode_activite('grossiste');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                            }
                    
                            $c_acteur->setType_acteur('kr');
							$c_acteur->setCode_gac_chaine($acteur);
                                
                            $t_acteur->insert($c_acteur->toArray());
							
							//r?cup?ration de la PrK nr
                            $param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $prc = 0;
                            $par_prc = $param->find('prc', 'nr', $par);
                            if ($par_prc == true) {
                               $prc = $par->getMontant();
                            }
                       
                            $te_mapper = new Application_Model_EuTegcMapper();
                            $te = new Application_Model_EuTegc();
                            $code_te = 'tegcp' .$membre1->getId_filiere(). $code;
                            $find_te = $te_mapper->find($code_te,$te);
                            if ($find_te == false) {
                               $te->setCode_tegc($code_te)
                                  ->setId_filiere($membre1->getId_filiere())
                                  ->setMdv($prc)
                                  ->setCode_membre($code)
                                  ->setMontant(0)
							      ->setMontant_utilise(0)
							      ->setSolde_tegc(0);
                                 $te_mapper->save($te);
                            } else {
                                $te->setId_filiere($membre1->getId_filiere());
                                $te->setMdv($prc);
                                $te_mapper->update($te);
                            }
							
						    // table eu_utilisateur
                            $membre_mapper = new Application_Model_EuMembreMapper();
                            $membrein = new Application_Model_EuMembre();
					        $userin = new Application_Model_EuUtilisateur();
					        $user_mapper = new Application_Model_EuUtilisateurMapper();                   
                            $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                            $id_user = $user_mapper->findConuter() + 1;
                            $userin->setId_utilisateur($id_user);
                            $userin->setId_utilisateur_parent($utilisateur); 
                            $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                            $userin->setNom_utilisateur($membrein->getNom_membre());
                            $userin->setLogin($code);
                            $userin->setPwd(md5($_POST["codesecret"]));
                            $userin->setDescription(null);
                            $userin->setUlock(0);
                            $userin->setCh_pwd_flog(0);
                            if($code_groupe == 'scmdkr') {
                               $userin->setCode_groupe('oe_detaillant');
                               $userin->setCode_gac_filiere('oe_detaillant');
					           $userin->setCode_groupe_create('oe_detaillant');
                            } elseif($code_groupe == 'scmsgkr') {
                               $userin->setCode_groupe('oe_semi_grossiste');
					           $userin->setCode_groupe_create('oe_semi_grossiste');
                               $userin->setCode_gac_filiere(null);
                            } elseif($code_groupe == 'scmgkr') {
                               $userin->setCode_groupe('oe_grossiste');
					           $userin->setCode_groupe_create('oe_grossiste');
                               $userin->setCode_gac_filiere(null);
                            } 
                            $userin->setConnecte(0);
                            $userin->setCode_agence($code_agence);
                            $userin->setCode_secteur(null);
                            $userin->setCode_zone($code_zone);
                            $userin->setId_filiere($membre1->getId_filiere());
                    
                            $userin->setCode_acteur($acteur);
                    
                            $userin->setCode_membre($code);
                            $userin->setId_pays($user->id_pays);            
                            $user_mapper->save($userin);
						
						
					        // Mise à jour de la table eu_contrat
					        $contrat = new Application_Model_EuContrat();
				            $mapper_contrat = new Application_Model_EuContratMapper();
				            $id_contrat = $mapper_contrat->findConuter() + 1;
					
					        $contrat->setId_contrat($id_contrat);
                            $contrat->setCode_membre($code);
                            $contrat->setDate_contrat($date_idd->toString('yyyy-mm-dd'));
                            $contrat->setNature_contrat(null);
				            $contrat->setId_type_contrat(null);
                            $contrat->setId_type_creneau(null);
					        if($groupe == 'scmdkr') {
                               $contrat->setId_type_acteur(3);
					        } elseif($groupe == 'scmsgkr') {
                               $contrat->setId_type_acteur(2);
                            } elseif($groupe == 'scmgkr') {
                               $contrat->setId_type_acteur(1);
                            }					
                            $contrat->setId_pays($_POST['id_pays']);
                            $contrat->setId_utilisateur($user->id_utilisateur);
                            $contrat->setFiliere(''); 
                    
                            $mapper_contrat->save($contrat);
							
					    } else {
                           $this->view->message = 'Le code fs [' . $code_fs . '] est invalide !!!';
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                        }
						
						//Creation du fs
                        $tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre_morale($code)
                                 ->setCode_membre(null)
                                 ->setCode_fs('fs-' . $code)
                                 ->setCreditcode($sms_fs->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-mm-dd'))
                                 ->setHeure_fs($date_idd->toString('hh:mm:ss'))
                                 ->setId_utilisateur($utilisateur)
                                 ->setMont_fs($fs);
                        $tab_fs->insert($fs_model->toArray());
						
						$sms_fs->setDestAccount_Consumed('nb-tfs-' . $code)
                            ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fs);
						
						
						
						
					

                    }


                    if($code_fl !="") {
						$sms_fl = $sms_mapper->findByCreditCode($code_fl);
						if ($sms_fl == null) {
                            $db->rollback();
                            $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
                            return;
                        }
						
						if($sms_fl->getMotif() != 'fl') {
					        $db->rollBack();
							$this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
                            return;    
					    }
						
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'fl-' . $code;
						
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-mm-dd'))
                           ->setHeure_fl($date_idd->toString('hh:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('fl', 'nn', 'e', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('fl')
                                    ->setIntitule('Frais de licence')
                                    ->setService('e')
                                    ->setCode_type_compte('nn')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						    $compteurfl = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteurfl,null,$code, null, $mont_fl, null, 'Frais de licences', 'fl',$date_idd->toString('yyyy-mm-dd'),$date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
						
						    $sms_fl->setDestAccount_Consumed('fl-'.$code)
                                   ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                                   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms_fl);

                            $tcartes[0]="tpagcp";
									$tcartes[1]="tcncsei";
									$tcartes[2]="tpagci";
									$tcartes[3]="tir";
									$tcartes[4]="tr";
									$tcartes[5]="TPaNu";
									$tcartes[6]="TPaR";
									$tcartes[7]="tfs";
									$tcartes[8]="tpn";
									$tcartes[9]="tib";
									$tcartes[10]="TPaNu";
									$tcartes[11]="tin";
									$tcartes[12]="capa";
									$tcartes[13]="tmarge";
									
									for($i = 0; $i < count($tcartes); $i++) {
									    if($tcartes[$i] == "tcncsei" || $tcartes[$i] == "tpn") {
                                          $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nr';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tr" || $tcartes[$i] == "capa" || $tcartes[$i] == "tmarge") {
                                          $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nn';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tpagcp" || $tcartes[$i] == "tpagci" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "tfs") {
										    $code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tin") {
										    $tcartes[$i] = "ti"; 
										    $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nn';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tir") {
										    $tcartes[$i] = "ti"; 
										    $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nr';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tib") {
										    $tcartes[$i] = "ti";
										    $code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_compte,$compte);
										}
										
										if(!$res) {
                                          $compte->setCode_cat($tcartes[$i])
                                                 ->setCode_compte($code_compte)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tcartes[$i])
                                                 ->setSolde(0);
										  $map_compte->save($compte);
									
									    }
									
                                    }
									
									$tscartes[0]="tsgcp";
									$tscartes[1]="tscncsei";
									$tscartes[2]="tsgci";
									$tscartes[3]="tscapa";
									$tscartes[4]="TSPaNu";
									$tscartes[5]="TSPaR";
									$tscartes[6]="tsfs";
									$tscartes[7]="tspn";
									$tscartes[8]="tsin";
									$tscartes[9]="tsib";
									$tscartes[10]="tsir";
									$tscartes[11]="tsmarge";
									
									for($j = 0; $j < count($tscartes); $j++) {
									
									    if($tscartes[$j] == "tscncsei" || $tscartes[$j] == "tspn") {
                                          $code_comptets = 'nr' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'nr';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tscapa" || $tscartes[$j] == "tsmarge") {
                                          $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'nn';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsgcp" || $tscartes[$j] == "tsgci" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
										  || $tscartes[$j] == "tsfs") {
										    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsin") {
										    $tscartes[$j] = "tsi"; 
										    $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nn';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsir") {
										    $tscartes[$j] = "tsi"; 
										    $code_compte = 'nr' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nr';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsib") {
										    $tscartes[$j] = "tsi";
										    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_comptets,$compte);
										}
										
										if(!$res) {
                                          $compte->setCode_cat($tscartes[$j])
                                                 ->setCode_compte($code_comptets)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                                 ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tscartes[$j])
                                                 ->setSolde(0);
											$map_compte->save($compte);
									    }
									
                                    } 
                    }
                    if($code_fkps !="") {
					    $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
						if ($sms_fkps == null) {
                            $db->rollback();
                            $this->view->message = 'Le code fkps [' . $code_fkps . ']  est  invalide !!!';
                            return;
                        }
						
						if($sms_fkps->getMotif() != 'fkps') {
					        $db->rollBack();
                            $this->view->message = " Le motif pour lequel ce code fkps est émis ne correspond pas pour ce type d'operation";
                            return;    
					    } 
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
						$id_demande = $carte->findConuter() + 1;
						$carte->setId_demande($id_demande)
							  ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-mm-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("nb-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur($user->id_utilisateur);
                        $t_carte->insert($carte->toArray());
                             
					    $sms_fkps->setDestAccount_Consumed('cps-' . $code)
                                 ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                                 ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fkps); 
                    }					
					    $compteur = Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                        $db->commit();
                        return $this->_helper->redirector('morale','eu-preinscription',null,array('controller' => 'eu-preinscription','action'=>'morale')); 
				} catch (Exception $exc) {
                  $db->rollback();
                  $this->view->type_acteur = $_POST["type_acteur"];
                  $this->view->statut_juridique = $_POST["statut_juridique"];
                  $this->view->raison = $_POST["raison_sociale"];
                  $this->view->domaine_activite = $_POST["domaine_activite"];
                  $this->view->site_web = $_POST["site_web"];
                  $this->view->quartier_membre = $_POST["quartier_membre"];
                  $this->view->ville_membre = $_POST["ville_membre"];
                  $this->view->bp = $_POST["bp_membre"];
                  $this->view->tel = $_POST["tel_membre"];
                  $this->view->email = $_POST["email_membre"];
                  $this->view->id_pays = $_POST["id_pays"];
                  $this->view->portable = $_POST["portable_membre"];
                  $this->view->registre = $_POST["num_registre"];
                  $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                  return;
                }
		
		
		
		
	        }
	    }
	
	}
	
	
	
	
	public function ncmmmpbfAction() {
	
	    $request = $this->getRequest();
        $raison_sociale = $request->raison_sociale;
        $this->view->raison_sociale = $raison_sociale;
		
		if(isset($raison_sociale)) $this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_agence = $user->code_agence;
        $fs = Util_Utils::getParametre('fs', 'valeur');
        $this->view->fs = $fs;
        $request = $this->getRequest();
        $id_preinscription_morale = $request->id_preinscription_morale;
        $this->view->id_preinscription_morale = $id_preinscription_morale;
        $ville = $request->ville_membre;
        $this->view->ville = $ville;
        $tel = $request->tel_membre;
        $this->view->tel = $tel;
	    $qart = $request->quartier_membre;
        $this->view->quartier_membre = $qart;
	    $portable = $request->portable_membre;
        $this->view->portable = $portable;
	    $email = $request->email_membre;
        $this->view->email = $email;
	    $site = $request->site_web;
        $this->view->site_web = $site;
	    $bp = $request->bp_membre;
        $this->view->bp = $bp;
			  
	    $numero_agrement_filiere = $request->numero_agrement_filiere;
		$numero_agrement_acnev = $request->numero_agrement_acnev;
		$numero_agrement_technopole = $request->numero_agrement_technopole;
			  
        $this->view->agrement_filiere = $numero_agrement_filiere;
	    $this->view->agrement_acnev = $numero_agrement_acnev;
	    $this->view->agrement_technopole = $numero_agrement_technopole;
			  
		$num_registre = $request->num_registre;
        $this->view->num_registre = $num_registre;
		$code_rep = $request->code_rep;
        $this->view->code_rep = $code_rep;
	    $code_fs = $request->code_fs;
        $this->view->code_fs = $code_fs;
	    $code_fl = $request->code_fl;
        $this->view->code_fl = $code_fl;
	    $code_fkps = $request->code_fkps;
        $this->view->code_fkps = $code_fkps;
		$domaine_activite = $request->domaine_activite;
        $this->view->domaine_activite = $domaine_activite;
		$code_type_acteur = $request->code_type_acteur;
        $this->view->type_acteur = $code_type_acteur;
	    $code_statut = $request->code_statut;
        $this->view->statut_juridique = $code_statut;
		   
		$utilisateur = $user->id_utilisateur;
		$groupe = $user->code_groupe;
		$acteur = $user->code_acteur;
		
		if ($this->getRequest()->isPost()) {
		    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
		    $request = $this->getRequest();
		    $type_gac = $request->type_gac;
		    $this->view->type_gac = $type_gac;
            $code_agence = $user->code_agence;
		    $acteur      =  $user->code_acteur;
				   
            $fs = Util_Utils::getParametre('fs','valeur');
			$mont_fl = Util_Utils::getParametre('fl','valeur');
			$fcps = Util_Utils::getParametre('fcps','valeur');
				   
			$date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
            $code_fs = $_POST["code_fs"];
			$code_fl = $_POST["code_fl"];
			$code_fkps = $_POST["code_fkps"];
			$membre = new Application_Model_EuMembreMorale();
            $mapper = new Application_Model_EuMembreMoraleMapper();
            $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			$agrement_mapper = new Application_Model_EuAgrementMapper();
            $agrement        = new Application_Model_EuAgrement();
            $compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
			$tcartes = array();
			$tscartes = array();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try { 
                if($code_fs !="") {
                    $sms_fs = $sms_mapper->findByCreditCode($code_fs);
                    $agrement_filiere  =  $_POST["agrement_filiere"];
                    $agrement_acnev    =  $_POST["agrement_acnev"];
                    $agrement_technopole =  $_POST["agrement_technopole"];
                    
                    if ($sms_fs != null)  {					
                        
						if($sms->getMotif() != 'fs') {
                           $db->rollBack();
                           $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;    
                        }
                        
						//insertion dans la table membremorale des information du nouveau membre
						$membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'm';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, str_pad_left);
                            $code = $code_agence . $num_ordre_bis . 'm';
                        }
						
						//insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
						
						if($trouveagrementf != false) {
                            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
                            $membre->setId_filiere($membre1->getId_filiere());
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(htmlentities (addslashes (trim ($_POST["raison_sociale"]))));
                            $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(htmlentities (addslashes (trim ($_POST["domaine_activite"]))));
                            $membre->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))));
                            $membre->setQuartier_membre(htmlentities (addslashes (trim ($_POST["quartier_membre"]))));
                            $membre->setVille_membre(htmlentities (addslashes (trim ($_POST["ville_membre"]))));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($utilisateur);
                            $membre->setHeure_identification($date_idd->toString('hh:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-mm-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('o');
                            $membre->setEtat_membre('n');
                            $mapper->save($membre);
                            
                            // eu_acteurs_creneau
                            $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
                            
                            $acren->setNom_acteur(htmlentities (addslashes (trim ($_POST["raison_sociale"]))));
                            $acren->setCode_membre($code);
                            if($code_groupe == 'scmdpbf'){
                               $acren->setId_type_acteur(3);
                            } elseif($code_groupe == 'scmsgpbf' ){
                               $acren->setId_type_acteur(2);
                            } elseif($code_groupe == 'scmgpbf') {
                               $acren->setId_type_acteur(1);
                            }
                            //$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                            $acren->setId_utilisateur($utilisateur);
                            $acren->setGroupe($code_groupe);
                            $acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
                            
                            
                            $code_zone = $user->code_zone;
                            $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'a' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'a' . $code_zone . str_pad($num_ordre, 4, 0, STR_PaD_LEFT);
                           }
                        
                           $acren->setCode_acteur($code_acteur);
                           $acren->setId_filiere($membre1->getId_filiere());
                           $cm->save($acren);   
                            
                            // eu_operation
                            Util_Utils::addOperation($compteur,null,$code,'tfs', $frais_identification, 'fs', 'Auto-enrôlement', 'aerl', $date_idd->toString('yyyy-mm-dd'), $date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
                            
                            //insertion dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                                ->setCode_membre($_POST['code_rep'])
                                ->setTitre("Representant")
							    ->setDate_creation($date_idd->toString('yyyy-mm-dd'))
							    ->setId_utilisateur($user->id_utilisateur)
							    ->setEtat('inside');
                            $rep_mapper->save($rep);
						    
							// Mise à jour des comptes bancaires
						    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $cb = new Application_Model_EuCompteBancaire();
						    $comptebancaires = $cb_mapper->findByPreinscrimorale($_POST["id_preinscription_morale"]);
						   
						    if ($comptebancaires != false) {
							    $j = 0;
                                $nbre_cb = count($comptebancaires);
						        while ($j < $nbre_cb) { 
							       $comptebancaire = $comptebancaires[$j];
                                   $id_compte = $comptebancaire->getId_compte(); 
                                   $cb_mapper->find($id_compte,$cb);
                                   $cb->setCode_membre_morale($code);
                                   $cb_mapper->update($cb);
                                   $j++;
         				        }
						    }
							
					    } else {
                               $db->rollBack();
                               $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
                               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
                        }
						
						
						if($trouveagrementacnev != false) {
                            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
                        if($trouveagrementtechno != false) {
                            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                               $db->rollBack();
                               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
                               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
                        }
						
						$filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
						
						$t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $count = $c_acteur->findConuter() + 1;
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                               
                        if($code_groupe == 'scmdpbf') {
                            $c_acteur->setCode_activite('detaillant');
						    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						    $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						    $c_acteur->setId_pays($ligneacteur->id_pays);
						    $c_acteur->setId_region($ligneacteur->id_region);
						    $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						    $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                        } elseif($code_groupe == 'scmsgpbf' ) {
                            $c_acteur->setCode_activite('semi-grossiste');
						    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						    $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						    $c_acteur->setId_pays($ligneacteur->id_pays);
						    $c_acteur->setId_region($ligneacteur->id_region);
						    $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						    $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                        } elseif($code_groupe == 'scmgpbf') {
                            $c_acteur->setCode_activite('grossiste');
						    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						    $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						    $c_acteur->setId_pays($ligneacteur->id_pays);
						    $c_acteur->setId_region($ligneacteur->id_region);
						    $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						    $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                        }
                    
                            $c_acteur->setType_acteur('pbf');
							$c_acteur->setCode_gac_chaine($acteur);
                                
                            $t_acteur->insert($c_acteur->toArray());
                            //r?cup?ration de la PrK nr
                            $param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $prc = 0;
                            $par_prc = $param->find('prc', 'nr', $par);
                            if ($par_prc == true) {
                               $prc = $par->getMontant();
                            }
                       
                            $te_mapper = new Application_Model_EuTegcMapper();
                            $te = new Application_Model_EuTegc();
                            $code_te = 'tegcp' .$membre1->getId_filiere(). $code;
                            $find_te = $te_mapper->find($code_te,$te);
                            if ($find_te == false) {
                               $te->setCode_tegc($code_te)
                                  ->setId_filiere($membre1->getId_filiere())
                                  ->setMdv($prc)
                                  ->setCode_membre($code)
                                  ->setMontant(0)
							      ->setMontant_utilise(0)
							      ->setSolde_tegc(0);
                                 $te_mapper->save($te);
                            } else {
                                $te->setId_filiere($membre1->getId_filiere());
                                $te->setMdv($prc);
                                $te_mapper->update($te);
                            }
							
				    // table eu_utilisateur
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					$userin = new Application_Model_EuUtilisateur();
					$user_mapper = new Application_Model_EuUtilisateurMapper();                   
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                    $id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if($code_groupe == 'scmdpbf') {
                      $userin->setCode_groupe('pbf_detaillant');
                      $userin->setCode_gac_filiere('pbf_detaillant');
					  $userin->setCode_groupe_create('pbf_detaillant');
                    } elseif($code_groupe == 'scmsgpbf') {
                      $userin->setCode_groupe('pbf_semi_grossiste');
					  $userin->setCode_groupe_create('pbf_semi_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } elseif($code_groupe == 'scmgpbf') {
                      $userin->setCode_groupe('pbf_grossiste');
					  $userin->setCode_groupe_create('pbf_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($membre1->getId_filiere());
                    
                    $userin->setCode_acteur($acteur);
                    
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays);            
                    $user_mapper->save($userin);
					
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-mm-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
                    $contrat->setId_type_creneau(null);
					if($groupe == 'scmdpbf') {
                       $contrat->setId_type_acteur(3);
					} elseif($groupe == 'scmsgpbf') {
                       $contrat->setId_type_acteur(2);
                    } elseif($groupe == 'scmgpbf') {
                       $contrat->setId_type_acteur(1);
                    }					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);	
                   
                    } else {
                           $this->view->message = 'Le code fs [' . $code_fs . '] est invalide !!!';
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                    }

					//Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('fs-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-mm-dd'))
                             ->setHeure_fs($date_idd->toString('hh:mm:ss'))
                             ->setId_utilisateur($utilisateur)
                             ->setMont_fs($fs);
                    $tab_fs->insert($fs_model->toArray());
					
					$sms_fs->setDestAccount_Consumed('nb-tfs-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                    $sms_mapper->update($sms_fs);  
				}
				
				if($code_fl !="") {
						$sms_fl = $sms_mapper->findByCreditCode($code_fl);
						if ($sms_fl == null) {
                            $db->rollback();
                            $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
                            return;
                        }
						
						if($sms_fl->getMotif() != 'fl') {
					        $db->rollBack();
							$this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
                            return;    
					    }
						
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'fl-' . $code;
						
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-mm-dd'))
                           ->setHeure_fl($date_idd->toString('hh:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('fl', 'nn', 'e', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('fl')
                                    ->setIntitule('Frais de licence')
                                    ->setService('e')
                                    ->setCode_type_compte('nn')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						    $compteurfl = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteurfl,null,$code, null, $mont_fl, null, 'Frais de licences', 'fl',$date_idd->toString('yyyy-mm-dd'),$date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
						
						    $sms_fl->setDestAccount_Consumed('fl-'.$code)
                                   ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                                   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms_fl);

                            $tcartes[0]="tpagcp";
									$tcartes[1]="tcncsei";
									$tcartes[2]="tpagci";
									$tcartes[3]="tir";
									$tcartes[4]="tr";
									$tcartes[5]="TPaNu";
									$tcartes[6]="TPaR";
									$tcartes[7]="tfs";
									$tcartes[8]="tpn";
									$tcartes[9]="tib";
									$tcartes[10]="TPaNu";
									$tcartes[11]="tin";
									$tcartes[12]="capa";
									$tcartes[13]="tmarge";
									
									for($i = 0; $i < count($tcartes); $i++) {
									    if($tcartes[$i] == "tcncsei" || $tcartes[$i] == "tpn") {
                                          $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nr';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tr" || $tcartes[$i] == "capa" || $tcartes[$i] == "tmarge") {
                                          $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nn';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tpagcp" || $tcartes[$i] == "tpagci" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "tfs") {
										    $code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tin") {
										    $tcartes[$i] = "ti"; 
										    $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nn';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tir") {
										    $tcartes[$i] = "ti"; 
										    $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nr';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tib") {
										    $tcartes[$i] = "ti";
										    $code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_compte,$compte);
										}
										
										if(!$res) {
                                          $compte->setCode_cat($tcartes[$i])
                                                 ->setCode_compte($code_compte)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tcartes[$i])
                                                 ->setSolde(0);
										  $map_compte->save($compte);
									
									    }
									
                                    }
									
									$tscartes[0]="tsgcp";
									$tscartes[1]="tscncsei";
									$tscartes[2]="tsgci";
									$tscartes[3]="tscapa";
									$tscartes[4]="TSPaNu";
									$tscartes[5]="TSPaR";
									$tscartes[6]="tsfs";
									$tscartes[7]="tspn";
									$tscartes[8]="tsin";
									$tscartes[9]="tsib";
									$tscartes[10]="tsir";
									$tscartes[11]="tsmarge";
									
									for($j = 0; $j < count($tscartes); $j++) {
									
									    if($tscartes[$j] == "tscncsei" || $tscartes[$j] == "tspn") {
                                          $code_comptets = 'nr' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'nr';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tscapa" || $tscartes[$j] == "tsmarge") {
                                          $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'nn';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsgcp" || $tscartes[$j] == "tsgci" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
										  || $tscartes[$j] == "tsfs") {
										    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsin") {
										    $tscartes[$j] = "tsi"; 
										    $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nn';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsir") {
										    $tscartes[$j] = "tsi"; 
										    $code_compte = 'nr' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nr';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsib") {
										    $tscartes[$j] = "tsi";
										    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_comptets,$compte);
										}
										
										if(!$res) {
                                          $compte->setCode_cat($tscartes[$j])
                                                 ->setCode_compte($code_comptets)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                                 ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tscartes[$j])
                                                 ->setSolde(0);
											$map_compte->save($compte);
									    }
									
                                    } 
                    }

                    if($code_fkps !="") {
					    $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
						if ($sms_fkps == null) {
                            $db->rollback();
                            $this->view->message = 'Le code fkps [' . $code_fkps . ']  est  invalide !!!';
                            return;
                        }
						
						if($sms_fkps->getMotif() != 'fkps') {
					        $db->rollBack();
                            $this->view->message = " Le motif pour lequel ce code fkps est émis ne correspond pas pour ce type d'operation";
                            return;    
					    } 
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
						$id_demande = $carte->findConuter() + 1;
						$carte->setId_demande($id_demande)
							  ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-mm-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("nb-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur($user->id_utilisateur);
                        $t_carte->insert($carte->toArray());
                             
					    $sms_fkps->setDestAccount_Consumed('cps-' . $code)
                                 ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                                 ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fkps); 
                    }					
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le réseau mcnp! Votre numéro de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale','eu-preinscription',null,array('controller' => 'eu-preinscription','action'=>'morale')); 
      		} catch (Exception $exc) {
                $db->rollback();
                $this->view->type_acteur = $_POST["type_acteur"];
                $this->view->statut_juridique = $_POST["statut_juridique"];
                $this->view->raison = $_POST["raison_sociale"];
                $this->view->domaine_activite = $_POST["domaine_activite"];
                $this->view->site_web = $_POST["site_web"];
                $this->view->quartier_membre = $_POST["quartier_membre"];
                $this->view->ville_membre = $_POST["ville_membre"];
                $this->view->bp = $_POST["bp_membre"];
                $this->view->tel = $_POST["tel_membre"];
                $this->view->email = $_POST["email_membre"];
                $this->view->id_pays = $_POST["id_pays"];
                $this->view->portable = $_POST["portable_membre"];
                $this->view->registre = $_POST["num_registre"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
	    }
	
	}
	
	public function datamAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        $membre = $this->_request->getParam("membre");
        
	  
        $tabela = new Application_Model_DbTable_EuMembreMorale();
			    if($membre !='') {
			      $select = $tabela->select();
	              $select->where('code_membre_morale = ?',$membre);
	              $select->where('id_utilisateur = ?', $user->id_utilisateur);
	            }
                else {
			        $select = $tabela->select();
	                $select->where('id_utilisateur = ?', $user->id_utilisateur); 
                }			   
	  
       
        $membres = $tabela->fetchAll($select);
        $count = count($membres);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $membres = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($membres as $row) {
         $responce['rows'][$i]['id'] = $row->code_membre_morale;
         $responce['rows'][$i]['cell'] = array(
            $row->code_membre_morale,
            $row->code_type_acteur,
			$row->code_statut,
            $row->raison_sociale,
			$row->domaine_activite,
			$row->ville_membre,
            $row->tel_membre,
            $row->portable_membre
          );
          $i++;
        }
	    $this->view->data = $responce;
	
	}
	

    public function ncmmmcreneauAction() {
	    $request = $this->getRequest();
        $raison_sociale = $request->raison_sociale;
        $this->view->raison_sociale = $raison_sociale;
            if(isset($raison_sociale)) $this->_helper->layout->disableLayout();
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $code_agence = $user->code_agence;
            $fs = Util_Utils::getParametre('fs', 'valeur');
            $this->view->fs = $fs;
            $request = $this->getRequest();
            $id_preinscription_morale = $request->id_preinscription_morale;
            $this->view->id_preinscription_morale = $id_preinscription_morale;
            $ville = $request->ville_membre;
            $this->view->ville = $ville;
            $tel = $request->tel_membre;
            $this->view->tel = $tel;
	        $qart = $request->quartier_membre;
            $this->view->quartier_membre = $qart;
	        $portable = $request->portable_membre;
            $this->view->portable = $portable;
	        $email = $request->email_membre;
            $this->view->email = $email;
	        $site = $request->site_web;
            $this->view->site_web = $site;
	        $bp = $request->bp_membre;
            $this->view->bp = $bp;
			  
			$numero_agrement_filiere = $request->numero_agrement_filiere;
			$numero_agrement_acnev = $request->numero_agrement_acnev;
			$numero_agrement_technopole = $request->numero_agrement_technopole;
			  
            $this->view->agrement_filiere = $numero_agrement_filiere;
			$this->view->agrement_acnev = $numero_agrement_acnev;
			$this->view->agrement_technopole = $numero_agrement_technopole;
			  
		    $num_registre = $request->num_registre;
            $this->view->num_registre = $num_registre;
			$code_rep = $request->code_rep;
            $this->view->code_rep = $code_rep;
			$code_fs = $request->code_fs;
            $this->view->code_fs = $code_fs;
			$code_fl = $request->code_fl;
            $this->view->code_fl = $code_fl;
			$code_fkps = $request->code_fkps;
            $this->view->code_fkps = $code_fkps;
			$domaine_activite = $request->domaine_activite;
            $this->view->domaine_activite = $domaine_activite;
			$code_type_acteur = $request->code_type_acteur;
            $this->view->type_acteur = $code_type_acteur;
			$code_statut = $request->code_statut;
            $this->view->statut_juridique = $code_statut;
			$id_pays = $request->id_pays;
            $this->view->id_pays = $id_pays;
		   
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
		    $acteur = $user->code_acteur;
			
			
			if ($this->getRequest()->isPost()) {
			   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
		       $request = $this->getRequest();
		       $type_gac = $request->type_gac;
		       $this->view->type_gac = $type_gac;
               $utilisateur = $user->id_utilisateur;
		       $groupe = $user->code_groupe;
               $code_agence = $user->code_agence;
		       $acteur      =  $user->code_acteur;
				   
               $fs = Util_Utils::getParametre('fs','valeur');
			   $mont_fl = Util_Utils::getParametre('fl','valeur');
			   $fcps = Util_Utils::getParametre('fcps','valeur');
				   
			   $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               $code_fs = $_POST["code_fs"];
			   $code_fl = $_POST["code_fl"];
			   $code_fkps = $_POST["code_fkps"];
			   
			   $membre = new Application_Model_EuMembreMorale();
               $mapper = new Application_Model_EuMembreMoraleMapper();
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			   $agrement_mapper = new Application_Model_EuAgrementMapper();
               $agrement        = new Application_Model_EuAgrement();
               $mapper_op = new Application_Model_EuOperationMapper();
               $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
			   $tcartes = array();
			   $tscartes = array();
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			    try {
			        if($code_fs !="") {
                        $sms_fs = $sms_mapper->findByCreditCode($code_fs);
                       $agrement_filiere  =  $_POST["agrement_filiere"];
                       $agrement_acnev    =  $_POST["agrement_acnev"];
                       $agrement_technopole =  $_POST["agrement_technopole"];
					   
					    $membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                                $code = $code_agence . '0000001' . 'm';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, str_pad_left);
                            $code = $code_agence . $num_ordre_bis . 'm';
                        }
							
					    $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
						
						if($trouveagrementf != false) {
						  $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
				          $agrement->setCode_membre_morale($code);
				          $agrement_mapper->update($agrement);
						  $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
						}
						
						if($trouveagrementacnev != false) {
				            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);		
						}
						
						if($trouveagrementtechno != false) {
				           $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				           $agrement->setCode_membre_morale($code);
				           $agrement_mapper->update($agrement);	
						}
						
						$membre->setId_filiere($membre1->getId_filiere());
					    $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($_POST["type_acteur"]);
                        $membre->setCode_statut($_POST["statut_juridique"]);
                        $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
						$membre->setId_pays($_POST["id_pays"]);
                        $membre->setNum_registre_membre($_POST["num_registre"]);
                        $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                        $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                        $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                        $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                        $membre->setBp_membre($_POST["bp_membre"]);
                        $membre->setTel_membre($_POST["tel_membre"]);
                        $membre->setEmail_membre($_POST["email_membre"]);
                        $membre->setPortable_membre($_POST["portable_membre"]);
                        $membre->setId_utilisateur($user->id_utilisateur);
                        $membre->setHeure_identification($date_idd->toString('hh:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-mm-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('o');
						$membre->setEtat_membre('n');
				        $mapper->save($membre);
					   
					   
						
						// eu_acteurs_creneau
					        $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
							
							$acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
							if($groupe == 'distributiond' || $groupe == 'transformationd' || $groupe == 'productiond') {
							   $acren->setId_type_acteur(3);
							} elseif($groupe == 'distributionsg' || $groupe == 'transformationsg' || $groupe == 'productionsg') {
							   $acren->setId_type_acteur(2);
							} elseif($groupe == 'distributiong' || $groupe == 'transformationg' || $groupe == 'productiong') {
							   $acren->setId_type_acteur(1);
							}
							
							
							//$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                            $acren->setId_utilisateur($utilisateur);
							$acren->setGroupe($groupe);
							$acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
							
							$code_zone = $user->code_zone;
			                $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'a' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'a' . $code_zone . str_pad($num_ordre, 4, 0, STR_PaD_LEFT);
                            }
						
						    $acren->setCode_acteur($code_acteur);
						    $acren->setId_filiere($membre1->getId_filiere());
						    $cm->save($acren);
							
						
							// eu_operation
                            Util_Utils::addOperation($compteur,null,$code,'tfs', $fs, 'fs', 'Auto-enrôlement', 'aerl', $date_idd->toString('yyyy-mm-dd'), $date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
						   
							
						
							//insertion dans la table eu_representation
						    $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
						    $rep->setCode_membre_morale($code)
                                ->setCode_membre($_POST['code_rep'])
                                ->setTitre("Representant")
							    ->setDate_creation($date_idd->toString('yyyy-mm-dd'))
							    ->setId_utilisateur($user->id_utilisateur)
							    ->setEtat('inside');
                            $rep_mapper->save($rep);
							
					        
							// Mise à jour de la table eu_ancien_membre
                            $p_mapper = new Application_Model_EuPreinscriptionMoraleMapper();
                            $p = new Application_Model_EuPreinscriptionMorale();
                            $rep = $p_mapper->find($_POST["id_preinscription_morale"],$p);
                            if ($rep == true) {      
                               $p->setCode_membre_morale($code);
                               $p_mapper->update($p);      
                            }
							 
							// Mise à jour des comptes bancaires
						    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $cb = new Application_Model_EuCompteBancaire();
						    $comptebancaires = $cb_mapper->findByPreinscrimorale($_POST["id_preinscription_morale"]);
						   
						    if ($comptebancaires != false) {
							    $j = 0;
                                $nbre_cb = count($comptebancaires);
						        while ($j < $nbre_cb) { 
							       $comptebancaire = $comptebancaires[$j];
                                   $id_compte = $comptebancaire->getId_compte(); 
                                   $cb_mapper->find($id_compte,$cb);
                                   $cb->setCode_membre_morale($code);
                                   $cb_mapper->update($cb);
                                   $j++;
         				        }
						    }
                            
							$filiere =  new Application_Model_EuFiliere();
						    $map_filiere = new Application_Model_EuFiliereMapper();
						    $find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
                            $t_acteur = new Application_Model_DbTable_EuActeur();
						    $c_acteur = new Application_Model_EuActeur();
						    $table = new Application_Model_DbTable_EuActeur();
                            $select = $table->select();
					        $select->where('code_acteur like ?', $acteur);
					        $resultSet = $table->fetchAll($select);
					        $ligneacteur = $resultSet->current();
						    $count = $c_acteur->findConuter() + 1;
                            $c_acteur->setId_acteur($count)
                                     ->setCode_acteur(null)
									 ->setCode_division($filiere->getCode_division())
                                     ->setCode_membre($code)
                                     ->setId_utilisateur($utilisateur)
                                     ->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                                if($groupe == 'distributiond' || $groupe == 'transformationd' || $groupe == 'productiond') {
                                   $c_acteur->setCode_activite('detaillant');
								   $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						           $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						           $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						           $c_acteur->setId_pays($ligneacteur->id_pays);
						           $c_acteur->setId_region($ligneacteur->id_region);
						           $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						           $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($groupe == 'distributionsg' || $groupe == 'transformationsg' || $groupe == 'productionsg') {
                                   $c_acteur->setCode_activite('semi-grossiste');
								   $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						           $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						           $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						           $c_acteur->setId_pays($ligneacteur->id_pays);
						           $c_acteur->setId_region($ligneacteur->id_region);
						           $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						           $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($groupe == 'distributiong' || $groupe == 'transformationg' || $groupe == 'productiong'){
                                   $c_acteur->setCode_activite('grossiste');
								   $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						           $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						           $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						           $c_acteur->setId_pays($ligneacteur->id_pays);
						           $c_acteur->setId_region($ligneacteur->id_region);
						           $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						           $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                }
                                if(isset($_POST['actcmfh'])) {	
                                    $c_acteur->setType_acteur('cmfh');	
						        } else if(isset($_POST['actenro'])) {
						            $c_acteur->setType_acteur('dsms');	
						        } else {
						            $c_acteur->setType_acteur('dsms');
						        }
                                $c_acteur->setCode_gac_chaine($acteur);
                                $t_acteur->insert($c_acteur->toArray());
								
								
								
						    // Recuperation de la prk nr
							$param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $prc = 0;
                            $par_prc = $param->find('prc', 'nr', $par);
                            if ($par_prc == true) {
                               $prc = $par->getMontant();
                            } 
						
						    $te_mapper = new Application_Model_EuTegcMapper();
                            $te = new Application_Model_EuTegc();
                            $code_te = 'tegcp' .$membre1->getId_filiere(). $code;
                            $find_te = $te_mapper->find($code_te,$te);
                            if ($find_te == false) {
                                $te->setCode_tegc($code_te)
                                   ->setId_filiere($membre1->getId_filiere())
                                   ->setMdv($prc)
                                   ->setCode_membre($code)
                                   ->setMontant(0)
							       ->setMontant_utilise(0)
							       ->setSolde_tegc(0);
                                 $te_mapper->save($te);
                            } else {
                                $te->setId_filiere($membre1->getId_filiere());
                                $te->setMdv($prc);
                                $te_mapper->update($te);
                            }
							
							// table eu_utilisateur
					        $user_mapper = new Application_Model_EuUtilisateurMapper();
                            $userin = new Application_Model_EuUtilisateur();
                            $membre_mapper = new Application_Model_EuMembreMapper();
		                    $membrein = new Application_Model_EuMembre();					
					        $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					        $id_user = $user_mapper->findConuter() + 1;
					
                            $userin->setId_utilisateur($id_user);
                            $userin->setId_utilisateur_parent($utilisateur); 
                            $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                            $userin->setNom_utilisateur($membrein->getNom_membre());
                            $userin->setLogin($code);
                            $userin->setPwd(md5($_POST["codesecret"]));
                            $userin->setDescription(null);
                            $userin->setUlock(0);
                            $userin->setCh_pwd_flog(0);

                        if($groupe == 'distributiond' || $groupe == 'transformationd' || $groupe == 'productiond') {
                            $userin->setCode_groupe('oe_detaillant');
                            $userin->setCode_gac_filiere('oe_detaillant');
						    $userin->setCode_groupe_create('oe_detaillant');
                        } elseif($groupe == 'distributionsg' || $groupe == 'transformationsg' || $groupe == 'productionsg') {
                            $userin->setCode_groupe('oe_semi_grossiste');
                            $userin->setCode_gac_filiere(null);
						    $userin->setCode_groupe_create('oe_semi_grossiste');
                        } elseif($groupe == 'distributiong' || $groupe == 'transformationg' || $groupe == 'productiong') {
                            $userin->setCode_groupe('oe_grossiste');
                            $userin->setCode_gac_filiere(null);
						    $userin->setCode_groupe_create('oe_grossiste');
                        }
                        $userin->setConnecte(0);
                        $userin->setCode_agence($code_agence);
                        $userin->setCode_secteur(null);
                        $userin->setCode_zone($user->code_zone);
                        $userin->setId_filiere($membre1->getId_filiere());
                    
				        $userin->setCode_acteur($acteur);
					
					    $userin->setCode_membre($code);
		                $userin->setId_pays($user->id_pays);	    	
                        $user_mapper->save($userin);
						
						
						
						// Mise à jour de la table eu_contrat
					    $contrat = new Application_Model_EuContrat();
				        $mapper_contrat = new Application_Model_EuContratMapper();
				        $id_contrat = $mapper_contrat->findConuter() + 1;
					
					    $contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_idd->toString('yyyy-mm-dd'));
                        $contrat->setNature_contrat(null);
				        $contrat->setId_type_contrat(3);
					    if($groupe == 'distributiond' || $groupe == 'distributionsg' || $groupe == 'distributiong') {
                            $contrat->setId_type_creneau(3);
					    } elseif($groupe == 'transformationd' || $groupe == 'transformationsg' || $groupe == 'transformationg') {
                            $contrat->setId_type_creneau(2);
					    } elseif($groupe == 'productiond' || $groupe == 'productionsg' || $groupe == 'productiong') {
                            $contrat->setId_type_creneau(1);
					    }  
					    if($groupe == 'distributiond' || $groupe == 'transformationd' || $groupe == 'productiond') {
                            $contrat->setId_type_acteur(3);
					    } elseif($groupe == 'distributionsg' || $groupe == 'transformationsg' || $groupe == 'productionsg') {
                            $contrat->setId_type_acteur(2);
                        } elseif($groupe == 'distributiong' || $groupe == 'transformationg' || $groupe == 'productiong') {
                            $contrat->setId_type_acteur(1);
                        }					
                        $contrat->setId_pays($_POST['id_pays']);
                        $contrat->setId_utilisateur($user->id_utilisateur);
                        $contrat->setFiliere(''); 
                        $mapper_contrat->save($contrat);
						
						
						$tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre_morale($code)
				                 ->setCode_membre(null)
                                 ->setCode_fs('fs-' . $code)
                                 ->setCreditcode($sms_fs->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-mm-dd'))
                                 ->setHeure_fs($date_idd->toString('hh:mm:ss'))
                                 ->setId_utilisateur($utilisateur)
                                 ->setMont_fs($fs);
                        $tab_fs->insert($fs_model->toArray());
						
					
						$sms_fs->setDestAccount_Consumed('nb-tfs-' . $code)
                               ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fs);
						
					
                     
                    }
					
                    if($code_fl !="") {
						$sms_fl = $sms_mapper->findByCreditCode($code_fl);
					    $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'fl-' . $code;
					   
					    $fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-mm-dd'))
                           ->setHeure_fl($date_idd->toString('hh:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
                        
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('fl', 'nn', 'e', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('fl')
                                    ->setIntitule('Frais de licence')
                                    ->setService('e')
                                    ->setCode_type_compte('nn')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						    $compteurfl = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteurfl,null,$code, null, $mont_fl, null, 'Frais de licences', 'fl',$date_idd->toString('yyyy-mm-dd'),$date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
						
						    $sms_fl->setDestAccount_Consumed('fl-'.$code)
                                   ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                                   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms_fl);

                        
                        
						$tcartes[0]="tpagcp";
					    $tcartes[1]="tcncsei";
						$tcartes[2]="tpagci";
					    $tcartes[3]="tir";
					    $tcartes[4]="tr";
						$tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
					    $tcartes[7]="tfs";
					    $tcartes[8]="tpn";
						$tcartes[9]="tib";
						$tcartes[10]="TPaNu";
						$tcartes[11]="tin";
						$tcartes[12]="capa";
						$tcartes[13]="tmarge";
						
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "tcncsei" || $tcartes[$i] == "tpn") {
                                          $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nr';
									      $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tr" || $tcartes[$i] == "capa" || $tcartes[$i] == "tmarge") {
                                          $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nn';
									      $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tpagcp" || $tcartes[$i] == "tpagci" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "tfs") {
										    $code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tin") {
								$tcartes[$i] = "ti"; 
								$code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'nn';
							    $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tir") {
								$tcartes[$i] = "ti"; 
								$code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'nr';
							    $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tib") {
								$tcartes[$i] = "ti";
								$code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'nb';
							    $res = $map_compte->find($code_compte,$compte);
							}
										
								if(!$res) {
                                    $compte->setCode_cat($tcartes[$i])
                                          ->setCode_compte($code_compte)
                                          ->setCode_membre(null)
										  ->setCode_membre_morale($code)
                                          ->setCode_type_compte($type_carte)
                                          ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                          ->setDesactiver(0)
                                          ->setLib_compte($tcartes[$i])
                                         ->setSolde(0);
								    $map_compte->save($compte);	
							    }
									
                            }
							
							$tscartes[0]="tsgcp";
							$tscartes[1]="tscncsei";
							$tscartes[2]="tsgci";
							$tscartes[3]="tscapa";
							$tscartes[4]="TSPaNu";
							$tscartes[5]="TSPaR";
							$tscartes[6]="tsfs";
							$tscartes[7]="tspn";
							$tscartes[8]="tsin";
							$tscartes[9]="tsib";
							$tscartes[10]="tsir";
							$tscartes[11]="tsmarge";
							
                            for($j = 0; $j < count($tscartes); $j++) {	
							    if($tscartes[$j] == "tscncsei" || $tscartes[$j] == "tspn") {
                                    $code_comptets = 'nr' . '-' . $tscartes[$j] . '-' . $code;
									$type_carte = 'nr';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tscapa" || $tscartes[$j] == "tsmarge") {
                                    $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'nn';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tsgcp" || $tscartes[$j] == "tsgci" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
										  || $tscartes[$j] == "tsfs") {
								    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'nb';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tsin") {
									$tscartes[$j] = "tsi"; 
									$code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'nn';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tsir") {
								    $tscartes[$j] = "tsi"; 
									$code_comptets = 'nr' . '-' . $tscartes[$j] . '-' . $code;
									$type_carte = 'nr';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tsib") {
								    $tscartes[$j] = "tsi";
								    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'nb';
									$res = $map_compte->find($code_comptets,$compte);
								}
									if(!$res) {
                                        $compte->setCode_cat($tscartes[$j])
                                               ->setCode_compte($code_comptets)
                                               ->setCode_membre(null)
											   ->setCode_membre_morale($code)
                                               ->setCode_type_compte($type_carte)
                                               ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                               ->setDesactiver(0)
                                               ->setLib_compte($tscartes[$j])
                                               ->setSolde(0);
											$map_compte->save($compte);
									}
									
                                } 
                    }

                    if($code_fkps !="") {
					    $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
						 
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
						$id_demande = $carte->findConuter() + 1;
						$carte->setId_demande($id_demande)
							  ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-mm-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("nb-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur($user->id_utilisateur);
                        $t_carte->insert($carte->toArray());
                             
					    $sms_fkps->setDestAccount_Consumed('cps-' . $code)
                                 ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                                 ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fkps); 
                    }
									
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale','eu-preinscription',null,array('controller' => 'eu-preinscription','action'=>'morale')); 
			    } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }
			
			}
			
		   
	}
	
	
	public function ncmmmoseAction() {
	    $request = $this->getRequest();
        $raison_sociale = $request->raison_sociale;
        $this->view->raison_sociale = $raison_sociale;
            if(isset($raison_sociale)) $this->_helper->layout->disableLayout();
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $code_agence = $user->code_agence;
            $fs = Util_Utils::getParametre('fs', 'valeur');
            $this->view->fs = $fs;
            $request = $this->getRequest();
            $id_preinscription_morale = $request->id_preinscription_morale;
            $this->view->id_preinscription_morale = $id_preinscription_morale;
            $ville = $request->ville_membre;
            $this->view->ville = $ville;
            $tel = $request->tel_membre;
            $this->view->tel = $tel;
	        $qart = $request->quartier_membre;
            $this->view->quartier_membre = $qart;
	        $portable = $request->portable_membre;
            $this->view->portable = $portable;
	        $email = $request->email_membre;
            $this->view->email = $email;
	        $site = $request->site_web;
            $this->view->site_web = $site;
	        $bp = $request->bp_membre;
            $this->view->bp = $bp;
			  
			$numero_agrement_filiere = $request->numero_agrement_filiere;
			$numero_agrement_acnev = $request->numero_agrement_acnev;
			$numero_agrement_technopole = $request->numero_agrement_technopole;
			  
            $this->view->agrement_filiere = $numero_agrement_filiere;
			$this->view->agrement_acnev = $numero_agrement_acnev;
			$this->view->agrement_technopole = $numero_agrement_technopole;
			  
		    $num_registre = $request->num_registre;
            $this->view->num_registre = $num_registre;
			$code_rep = $request->code_rep;
            $this->view->code_rep = $code_rep;
			$code_fs = $request->code_fs;
            $this->view->code_fs = $code_fs;
			$code_fl = $request->code_fl;
            $this->view->code_fl = $code_fl;
			$code_fkps = $request->code_fkps;
            $this->view->code_fkps = $code_fkps;
			$domaine_activite = $request->domaine_activite;
            $this->view->domaine_activite = $domaine_activite;
			$code_type_acteur = $request->code_type_acteur;
            $this->view->type_acteur = $code_type_acteur;
			$code_statut = $request->code_statut;
            $this->view->statut_juridique = $code_statut;
			$id_pays = $request->id_pays;
            $this->view->id_pays = $id_pays;
		   
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
		    $acteur = $user->code_acteur;
			
			
			if ($this->getRequest()->isPost()) {
			   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
               $user = $auth->getIdentity();
		       $request = $this->getRequest();
		       $type_gac = $request->type_gac;
		       $this->view->type_gac = $type_gac;
               $utilisateur = $user->id_utilisateur;
		       $groupe = $user->code_groupe;
               $code_agence = $user->code_agence;
		       $acteur      =  $user->code_acteur;
				   
               $fs = Util_Utils::getParametre('fs','valeur');
			   $mont_fl = Util_Utils::getParametre('fl','valeur');
			   $fcps = Util_Utils::getParametre('fcps','valeur');
				   
			   $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               $code_fs = $_POST["code_fs"];
			   $code_fl = $_POST["code_fl"];
			   $code_fkps = $_POST["code_fkps"];
			   
			   $membre = new Application_Model_EuMembreMorale();
               $mapper = new Application_Model_EuMembreMoraleMapper();
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			   $agrement_mapper = new Application_Model_EuAgrementMapper();
               $agrement        = new Application_Model_EuAgrement();
               $mapper_op = new Application_Model_EuOperationMapper();
               $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
			   $tcartes = array();
			   $tscartes = array();
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			    try {
			        if($code_fs !="") {
                        $sms_fs = $sms_mapper->findByCreditCode($code_fs);
                       $agrement_filiere  =  $_POST["agrement_filiere"];
                       $agrement_acnev    =  $_POST["agrement_acnev"];
                       $agrement_technopole =  $_POST["agrement_technopole"];
					   
					    $membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                                $code = $code_agence . '0000001' . 'm';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, str_pad_left);
                            $code = $code_agence . $num_ordre_bis . 'm';
                        }
							
					    $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
						
						if($trouveagrementf != false) {
						  $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
				          $agrement->setCode_membre_morale($code);
				          $agrement_mapper->update($agrement);
						  $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
						}
						
						if($trouveagrementacnev != false) {
				            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);		
						}
						
						if($trouveagrementtechno != false) {
				           $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				           $agrement->setCode_membre_morale($code);
				           $agrement_mapper->update($agrement);	
						}
						
						$membre->setId_filiere($membre1->getId_filiere());
					    $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($_POST["type_acteur"]);
                        $membre->setCode_statut($_POST["statut_juridique"]);
                        $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
						$membre->setId_pays($_POST["id_pays"]);
                        $membre->setNum_registre_membre($_POST["num_registre"]);
                        $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                        $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                        $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                        $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                        $membre->setBp_membre($_POST["bp_membre"]);
                        $membre->setTel_membre($_POST["tel_membre"]);
                        $membre->setEmail_membre($_POST["email_membre"]);
                        $membre->setPortable_membre($_POST["portable_membre"]);
                        $membre->setId_utilisateur($user->id_utilisateur);
                        $membre->setHeure_identification($date_idd->toString('hh:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-mm-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('o');
						$membre->setEtat_membre('n');
				        $mapper->save($membre);
					   
					   
						
						// eu_acteurs_creneau
					        $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
							
							$acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
							if($groupe == 'scmd') {
							   $acren->setId_type_acteur(3);
							} elseif($groupe == 'scmsg') {
							   $acren->setId_type_acteur(2);
							} elseif($groupe == 'scmg') {
							   $acren->setId_type_acteur(1);
							}
							
							
							//$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                            $acren->setId_utilisateur($utilisateur);
							$acren->setGroupe($groupe);
							$acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
							
							$code_zone = $user->code_zone;
			                $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'a' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'a' . $code_zone . str_pad($num_ordre, 4, 0, STR_PaD_LEFT);
                            }
						
						    $acren->setCode_acteur($code_acteur);
						    $acren->setId_filiere($membre1->getId_filiere());
						    $cm->save($acren);
							
						
							// eu_operation
                            Util_Utils::addOperation($compteur,null,$code,'tfs', $fs, 'fs', 'Auto-enrôlement', 'aerl', $date_idd->toString('yyyy-mm-dd'), $date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
						   
							
						
							//insertion dans la table eu_representation
						    $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
						    $rep->setCode_membre_morale($code)
                                ->setCode_membre($_POST['code_rep'])
                                ->setTitre("Representant")
							    ->setDate_creation($date_idd->toString('yyyy-mm-dd'))
							    ->setId_utilisateur($user->id_utilisateur)
							    ->setEtat('inside');
                            $rep_mapper->save($rep);
							
					        
							// Mise à jour de la table eu_ancien_membre
                            $p_mapper = new Application_Model_EuPreinscriptionMoraleMapper();
                            $p = new Application_Model_EuPreinscriptionMorale();
                            $rep = $p_mapper->find($_POST["id_preinscription_morale"],$p);
                            if ($rep == true) {      
                               $p->setCode_membre_morale($code);
                               $p_mapper->update($p);      
                            }
							 
							// Mise à jour des comptes bancaires
						    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $cb = new Application_Model_EuCompteBancaire();
						    $comptebancaires = $cb_mapper->findByPreinscrimorale($_POST["id_preinscription_morale"]);
						   
						    if ($comptebancaires != false) {
							    $j = 0;
                                $nbre_cb = count($comptebancaires);
						        while ($j < $nbre_cb) { 
							       $comptebancaire = $comptebancaires[$j];
                                   $id_compte = $comptebancaire->getId_compte(); 
                                   $cb_mapper->find($id_compte,$cb);
                                   $cb->setCode_membre_morale($code);
                                   $cb_mapper->update($cb);
                                   $j++;
         				        }
						    }
                            
							$filiere =  new Application_Model_EuFiliere();
						    $map_filiere = new Application_Model_EuFiliereMapper();
						    $find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
                            $t_acteur = new Application_Model_DbTable_EuActeur();
						    $c_acteur = new Application_Model_EuActeur();
						    $table = new Application_Model_DbTable_EuActeur();
                            $select = $table->select();
					        $select->where('code_acteur like ?', $acteur);
					        $resultSet = $table->fetchAll($select);
					        $ligneacteur = $resultSet->current();
						    $count = $c_acteur->findConuter() + 1;
                            $c_acteur->setId_acteur($count)
                                     ->setCode_acteur(null)
									 ->setCode_division($filiere->getCode_division())
                                     ->setCode_membre($code)
                                     ->setId_utilisateur($utilisateur)
                                     ->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                                if($groupe == 'scmd') {
                                   $c_acteur->setCode_activite('detaillant');
								   $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						           $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						           $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						           $c_acteur->setId_pays($ligneacteur->id_pays);
						           $c_acteur->setId_region($ligneacteur->id_region);
						           $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						           $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($groupe == 'scmsg') {
                                   $c_acteur->setCode_activite('semi-grossiste');
								   $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						           $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						           $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						           $c_acteur->setId_pays($ligneacteur->id_pays);
						           $c_acteur->setId_region($ligneacteur->id_region);
						           $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						           $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($groupe == 'scmg'){
                                   $c_acteur->setCode_activite('grossiste');
								   $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						           $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						           $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						           $c_acteur->setId_pays($ligneacteur->id_pays);
						           $c_acteur->setId_region($ligneacteur->id_region);
						           $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						           $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                }
                                if(isset($_POST['actcmfh'])) {	
                                    $c_acteur->setType_acteur('cmfh');	
						        } else if(isset($_POST['actenro'])) {
						            $c_acteur->setType_acteur('dsms');	
						        } else {
						            $c_acteur->setType_acteur('dsms');
						        }
                                $c_acteur->setCode_gac_chaine($acteur);
                                $t_acteur->insert($c_acteur->toArray());
								
								
								
						    // Recuperation de la prk nr
							$param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $prc = 0;
                            $par_prc = $param->find('prc', 'nr', $par);
                            if ($par_prc == true) {
                               $prc = $par->getMontant();
                            } 
						
						    $te_mapper = new Application_Model_EuTegcMapper();
                            $te = new Application_Model_EuTegc();
                            $code_te = 'tegcp' .$membre1->getId_filiere(). $code;
                            $find_te = $te_mapper->find($code_te,$te);
                            if ($find_te == false) {
                                $te->setCode_tegc($code_te)
                                   ->setId_filiere($membre1->getId_filiere())
                                   ->setMdv($prc)
                                   ->setCode_membre($code)
                                   ->setMontant(0)
							       ->setMontant_utilise(0)
							       ->setSolde_tegc(0);
                                 $te_mapper->save($te);
                            } else {
                                $te->setId_filiere($membre1->getId_filiere());
                                $te->setMdv($prc);
                                $te_mapper->update($te);
                            }
							
							// table eu_utilisateur
					        $user_mapper = new Application_Model_EuUtilisateurMapper();
                            $userin = new Application_Model_EuUtilisateur();
                            $membre_mapper = new Application_Model_EuMembreMapper();
		                    $membrein = new Application_Model_EuMembre();					
					        $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					        $id_user = $user_mapper->findConuter() + 1;
					
                            $userin->setId_utilisateur($id_user);
                            $userin->setId_utilisateur_parent($utilisateur); 
                            $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                            $userin->setNom_utilisateur($membrein->getNom_membre());
                            $userin->setLogin($code);
                            $userin->setPwd(md5($_POST["codesecret"]));
                            $userin->setDescription(null);
                            $userin->setUlock(0);
                            $userin->setCh_pwd_flog(0);

                        if($groupe == 'scmd') {
                            $userin->setCode_groupe('ose_detaillant');
                            $userin->setCode_gac_filiere('oe_detaillant');
						    $userin->setCode_groupe_create('oe_detaillant');
                        } elseif($groupe == 'scmsg') {
                            $userin->setCode_groupe('ose_semi_grossiste');
                            $userin->setCode_gac_filiere(null);
						    $userin->setCode_groupe_create('ose_semi_grossiste');
                        } elseif($groupe == 'scmg') {
                            $userin->setCode_groupe('ose_grossiste');
                            $userin->setCode_gac_filiere(null);
						    $userin->setCode_groupe_create('ose_grossiste');
                        }
                        $userin->setConnecte(0);
                        $userin->setCode_agence($code_agence);
                        $userin->setCode_secteur(null);
                        $userin->setCode_zone($user->code_zone);
                        $userin->setId_filiere($membre1->getId_filiere());
                    
				        $userin->setCode_acteur($acteur);
					
					    $userin->setCode_membre($code);
		                $userin->setId_pays($user->id_pays);	    	
                        $user_mapper->save($userin);
						
						
						
						// Mise à jour de la table eu_contrat
					    $contrat = new Application_Model_EuContrat();
				        $mapper_contrat = new Application_Model_EuContratMapper();
				        $id_contrat = $mapper_contrat->findConuter() + 1;
					
					    $contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_idd->toString('yyyy-mm-dd'));
                        $contrat->setNature_contrat(null);
				        $contrat->setId_type_contrat(3);
					    $contrat->setId_type_creneau(null);  
					    if($groupe == 'scmd') {
                            $contrat->setId_type_acteur(3);
					    } elseif($groupe == 'scmsg') {
                            $contrat->setId_type_acteur(2);
                        } elseif($groupe == 'scmg') {
                            $contrat->setId_type_acteur(1);
                        }					
                        $contrat->setId_pays($_POST['id_pays']);
                        $contrat->setId_utilisateur($user->id_utilisateur);
                        $contrat->setFiliere(''); 
                        $mapper_contrat->save($contrat);
						
						
						$tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre_morale($code)
				                 ->setCode_membre(null)
                                 ->setCode_fs('fs-' . $code)
                                 ->setCreditcode($sms_fs->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-mm-dd'))
                                 ->setHeure_fs($date_idd->toString('hh:mm:ss'))
                                 ->setId_utilisateur($utilisateur)
                                 ->setMont_fs($fs);
                        $tab_fs->insert($fs_model->toArray());
						
					
						$sms_fs->setDestAccount_Consumed('nb-tfs-' . $code)
                               ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fs);
						
					
                     
                    }
					
                    if($code_fl !="") {
						$sms_fl = $sms_mapper->findByCreditCode($code_fl);
					    $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'fl-' . $code;
					   
					    $fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-mm-dd'))
                           ->setHeure_fl($date_idd->toString('hh:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
                        
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('fl', 'nn', 'e', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('fl')
                                    ->setIntitule('Frais de licence')
                                    ->setService('e')
                                    ->setCode_type_compte('nn')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						    $compteurfl = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteurfl,null,$code, null, $mont_fl, null, 'Frais de licences', 'fl',$date_idd->toString('yyyy-mm-dd'),$date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
						
						    $sms_fl->setDestAccount_Consumed('fl-'.$code)
                                   ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                                   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms_fl);

                        
                        
						$tcartes[0]="tpagcp";
					    $tcartes[1]="tcncsei";
						$tcartes[2]="tpagci";
					    $tcartes[3]="tir";
					    $tcartes[4]="tr";
						$tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
					    $tcartes[7]="tfs";
					    $tcartes[8]="tpn";
						$tcartes[9]="tib";
						$tcartes[10]="TPaNu";
						$tcartes[11]="tin";
						$tcartes[12]="capa";
						$tcartes[13]="tmarge";
						
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "tcncsei" || $tcartes[$i] == "tpn") {
                                          $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nr';
									      $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tr" || $tcartes[$i] == "capa" || $tcartes[$i] == "tmarge") {
                                          $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nn';
									      $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tpagcp" || $tcartes[$i] == "tpagci" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "tfs") {
										    $code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tin") {
								$tcartes[$i] = "ti"; 
								$code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'nn';
							    $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tir") {
								$tcartes[$i] = "ti"; 
								$code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'nr';
							    $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "tib") {
								$tcartes[$i] = "ti";
								$code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'nb';
							    $res = $map_compte->find($code_compte,$compte);
							}
										
								if(!$res) {
                                    $compte->setCode_cat($tcartes[$i])
                                          ->setCode_compte($code_compte)
                                          ->setCode_membre(null)
										  ->setCode_membre_morale($code)
                                          ->setCode_type_compte($type_carte)
                                          ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                          ->setDesactiver(0)
                                          ->setLib_compte($tcartes[$i])
                                         ->setSolde(0);
								    $map_compte->save($compte);	
							    }
									
                            }
							
							$tscartes[0]="tsgcp";
							$tscartes[1]="tscncsei";
							$tscartes[2]="tsgci";
							$tscartes[3]="tscapa";
							$tscartes[4]="TSPaNu";
							$tscartes[5]="TSPaR";
							$tscartes[6]="tsfs";
							$tscartes[7]="tspn";
							$tscartes[8]="tsin";
							$tscartes[9]="tsib";
							$tscartes[10]="tsir";
							$tscartes[11]="tsmarge";
							
                            for($j = 0; $j < count($tscartes); $j++) {	
							    if($tscartes[$j] == "tscncsei" || $tscartes[$j] == "tspn") {
                                    $code_comptets = 'nr' . '-' . $tscartes[$j] . '-' . $code;
									$type_carte = 'nr';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tscapa" || $tscartes[$j] == "tsmarge") {
                                    $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'nn';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tsgcp" || $tscartes[$j] == "tsgci" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
										  || $tscartes[$j] == "tsfs") {
								    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'nb';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tsin") {
									$tscartes[$j] = "tsi"; 
									$code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'nn';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tsir") {
								    $tscartes[$j] = "tsi"; 
									$code_comptets = 'nr' . '-' . $tscartes[$j] . '-' . $code;
									$type_carte = 'nr';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "tsib") {
								    $tscartes[$j] = "tsi";
								    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'nb';
									$res = $map_compte->find($code_comptets,$compte);
								}
									if(!$res) {
                                        $compte->setCode_cat($tscartes[$j])
                                               ->setCode_compte($code_comptets)
                                               ->setCode_membre(null)
											   ->setCode_membre_morale($code)
                                               ->setCode_type_compte($type_carte)
                                               ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                               ->setDesactiver(0)
                                               ->setLib_compte($tscartes[$j])
                                               ->setSolde(0);
											$map_compte->save($compte);
									}
									
                                } 
                    }

                    if($code_fkps !="") {
					    $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
						 
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
						$id_demande = $carte->findConuter() + 1;
						$carte->setId_demande($id_demande)
							  ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-mm-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("nb-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur($user->id_utilisateur);
                        $t_carte->insert($carte->toArray());
                             
					    $sms_fkps->setDestAccount_Consumed('cps-' . $code)
                                 ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                                 ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms_fkps); 
                    }
									
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale','eu-preinscription',null,array('controller' => 'eu-preinscription','action'=>'morale')); 
			    } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }
			
			}
	}
	
	

	public function ncmmmfiliereAction() {
		   $request = $this->getRequest();
           $raison_sociale = $request->raison_sociale;
           $this->view->raison_sociale = $raison_sociale;
            if(isset($raison_sociale))
              $this->_helper->layout->disableLayout();
              $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
              $user = $auth->getIdentity();
              $code_agence = $user->code_agence;
              $fs = Util_Utils::getParametre('fs', 'valeur');
              $this->view->fs = $fs;
              $request = $this->getRequest();
              $id_preinscription_morale = $request->id_preinscription_morale;
              $this->view->id_preinscription_morale = $id_preinscription_morale;
              $ville = $request->ville_membre;
              $this->view->ville = $ville;
              $tel = $request->tel_membre;
              $this->view->tel = $tel;
	          $qart = $request->quartier_membre;
              $this->view->quartier_membre = $qart;
	          $portable = $request->portable_membre;
              $this->view->portable = $portable;
	          $email = $request->email_membre;
              $this->view->email = $email;
	          $site = $request->site_web;
              $this->view->site_web = $site;
	          $bp = $request->bp_membre;
              $this->view->bp = $bp;
			  $numero_contrat = $request->numero_contrat;
              $this->view->numero_contrat = $numero_contrat;
			  $num_registre = $request->num_registre;
              $this->view->num_registre = $num_registre;
			  $code_rep = $request->code_rep;
              $this->view->code_rep = $code_rep;
			  $code_fs = $request->code_fs;
              $this->view->code_fs = $code_fs;
			  $code_fl = $request->code_fl;
              $this->view->code_fl = $code_fl;
			  $code_fkps = $request->code_fkps;
              $this->view->code_fkps = $code_fkps;
			  $domaine_activite = $request->domaine_activite;
              $this->view->domaine_activite = $domaine_activite;
			  $code_type_acteur = $request->code_type_acteur;
              $this->view->type_acteur = $code_type_acteur;
			  $code_statut = $request->code_statut;
              $this->view->statut_juridique = $code_statut;
		   
		   
		      $utilisateur = $user->id_utilisateur;
		      $groupe = $user->code_groupe;
		      $acteur = $user->code_acteur;
		      
			    if ($this->getRequest()->isPost()) { 
                   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
                   $user = $auth->getIdentity();
		           $request = $this->getRequest();
		           $type_gac = $request->type_gac;
		           $this->view->type_gac = $type_gac;
                   $code_agence = $user->code_agence;
		           $acteur      =  $user->code_acteur;
				   
                    $fs = Util_Utils::getParametre('fs','valeur');
				    $mont_fl = Util_Utils::getParametre('fl','valeur');
				    $fcps = Util_Utils::getParametre('fcps','valeur');
				   
				    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_idd = clone $date_id;
                    $code_fs = $_POST["code_fs"];
				    $code_fl = $_POST["code_fl"];
				    $code_fkps = $_POST["code_fkps"];
					$membre = new Application_Model_EuMembreMorale();
                    $mapper = new Application_Model_EuMembreMoraleMapper();
				    $offres_mapper = new Application_Model_EuAppeloffresMapper();
			        $offres = new Application_Model_EuAppeloffres();
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $compte = new Application_Model_EuCompte();
                    $map_compte = new Application_Model_EuCompteMapper();
					$tcartes = array();
			        $tscartes = array();
                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
				    try {
				        if($code_fs != "")  {
                            $sms_fs = $sms_mapper->findByCreditCode($code_fs);
                            //insertion dans la table membremorale des information du nouveau membre
                            $code = $mapper->getLastCodeMembreByAgence($code_agence);
                            if ($code == null) {
                              $code = $code_agence . '0000001' . 'm';
                            } else {
                              $num_ordre = substr($code, 12, 7);
                              $num_ordre++;
                              $num_ordre_bis = str_pad($num_ordre, 7, 0, str_pad_left);
                              $code = $code_agence . $num_ordre_bis . 'm';
                            }
							
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
						    $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                            $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                            $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                            $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($user->id_utilisateur);
                            $membre->setHeure_identification($date_idd->toString('hh:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-mm-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('o');
						    $membre->setEtat_membre('n');
							
							$membre->setId_filiere($user->id_filiere);
							$mapper->save($membre);
                            //insertion des frais d'identification dans la table placement
                            $mapper_op = new Application_Model_EuOperationMapper();
                            $compteur = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteur,null,$code,'tfs', $fs, 'fs', 'Auto-enrôlement', 'aerl', $date_idd->toString('yyyy-mm-dd'), $date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
                        
						    // Enr?gistrement du representant dans la table  eu_representation
						    $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
						    $rep->setCode_membre_morale($code)
                                ->setCode_membre($_POST['code_rep'])
                                ->setTitre("Representant")
							    ->setDate_creation($date_idd->toString('yyyy-mm-dd'))
							    ->setId_utilisateur($user->id_utilisateur)
							    ->setEtat('inside');
                            $rep_mapper->save($rep);
							
							// Mise à jour de la table eu_ancien_membre
                            $p_mapper = new Application_Model_EuPreinscriptionMoraleMapper();
                            $p = new Application_Model_EuPreinscriptionMorale();
                            $rep = $p_mapper->find($_POST["id_preinscription_morale"],$p);
                            if ($rep == true) {      
                               $p->setCode_membre_morale($code);
                               $p_mapper->update($p);      
                            }
						
						// Mise à jour des comptes bancaires
						$cb_mapper = new Application_Model_EuCompteBancaireMapper();
                        $cb = new Application_Model_EuCompteBancaire();
						$comptebancaires = $cb_mapper->findByPreinscrimorale($_POST["id_preinscription_morale"]);
						   
						if ($comptebancaires != false) {
							$j = 0;
                            $nbre_cb = count($comptebancaires);
						    while ($j < $nbre_cb) { 
							  $comptebancaire = $comptebancaires[$j];
                              $id_compte = $comptebancaire->getId_compte(); 
                              $cb_mapper->find($id_compte,$cb);
                              $cb->setCode_membre_morale($code);
                              $cb_mapper->update($cb);
                              $j++;
         				    }
						}
						
						$gac_mapper = new Application_Model_EuGacMapper();
		                $gac = new Application_Model_EuGac();
						$filiere =  new Application_Model_EuFiliere();
					    $map_filiere = new Application_Model_EuFiliereMapper();
					    $find_filiere = $map_filiere->find($user->id_filiere,$filiere);
					    $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
					    $table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
					    //$findgac  = $c_acteur->findByCodeActeur($acteur);
		                $userin = new Application_Model_EuUtilisateur();
					    $user_mapper = new Application_Model_EuUtilisateurMapper();
		                $userin = new Application_Model_EuUtilisateur();
					    $util = new Application_Model_DbTable_EuUtilisateur();
					    $membre_mapper = new Application_Model_EuMembreMapper();
		                $membrein = new Application_Model_EuMembre();
					    $select = $util->select();  
                        $select->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur_PARENT);
                        $data = $util->fetchAll($select);
					    $row = $data->current();
						
						if(trim($user->code_groupe) == 'filiere')  {
						
						  $trouveof = $offres_mapper->findoffres($_POST["numero_offre"]);
						  
						  if($trouveof != false) {
						    $num_offre = $_POST["numero_offre"];
				            $result = $offres_mapper->find($trouveof->getId_appeloffres(),$offres);
				            $offres->setCode_membre_morale($code);
				            $offres_mapper->update($offres);
						    $count = $c_acteur->findConuter() + 1;
                            $c_acteur->setId_acteur($count)
                                     ->setCode_acteur(null)
                                     ->setCode_membre($code)
									 ->setCode_division($filiere->getCode_division())
                                     ->setCode_activite('filiere')
                                     ->setId_utilisateur($user->id_utilisateur)
                                     ->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                            if($row->code_groupe == 'mise_chainepmpbf') {
							    $c_acteur->setType_acteur('pbf');
						        $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						        $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						        $c_acteur->setId_pays($ligneacteur->id_pays);
						        $c_acteur->setId_region($ligneacteur->id_region);
						        $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						        $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);    
						    } elseif($row->code_groupe == 'mise_chainepmkr') {
							    $c_acteur->setType_acteur('kr');
								$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						        $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						        $c_acteur->setId_pays($ligneacteur->id_pays);
						        $c_acteur->setId_region($ligneacteur->id_region);
						        $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						        $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
								  
                            } elseif($row->code_groupe == 'mise_chainepmd') {
							    $c_acteur->setType_acteur('detentrice');
								$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						        $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						        $c_acteur->setId_pays($ligneacteur->id_pays);
						        $c_acteur->setId_region($ligneacteur->id_region);
						        $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						        $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);  
                            } elseif($row->code_groupe == 'mise_chainepms') {
							    $c_acteur->setType_acteur('surveillance');
								$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						        $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						        $c_acteur->setId_pays($ligneacteur->id_pays);
						        $c_acteur->setId_region($ligneacteur->id_region);
						        $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						        $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);  
                            } elseif($row->code_groupe == 'mise_chainepmex') {
							    $c_acteur->setType_acteur('executante');
								$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						        $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						        $c_acteur->setId_pays($ligneacteur->id_pays);
						        $c_acteur->setId_region($ligneacteur->id_region);
						        $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						        $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                            } 
						    else {
                                $c_acteur->setType_acteur('dsms');
								$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						        $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						        $c_acteur->setId_pays($ligneacteur->id_pays);
						        $c_acteur->setId_region($ligneacteur->id_region);
						        $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						        $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                            }
                            $c_acteur->setCode_gac_chaine($acteur);							   
                            $t_acteur->insert($c_acteur->toArray());
						    
							//r?cup?ration de la PrK nr
                            $param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $prc = 0;
                            $par_prc = $param->find('prc', 'nr', $par);
                            if ($par_prc == true) {
                                $prc = $par->getMontant();
                            }
					   
					        $te_mapper = new Application_Model_EuTegcMapper();
                            $te = new Application_Model_EuTegc();
                            $code_te = 'tegcp' .$user->id_filiere. $code;
                            $find_te = $te_mapper->find($code_te,$te);
                            if ($find_te == false) {
                                $te->setCode_tegc($code_te)
                                   ->setId_filiere($user->id_filiere)
                                   ->setMdv($prc)
                                   ->setCode_membre($code)
                                   ->setMontant(0)
							       ->setMontant_utilise(0)
							       ->setSolde_tegc(0);
                                $te_mapper->save($te);
                            } else {
                                $te->setId_filiere($user->id_filiere);
                                $te->setMdv($prc);
                                $te_mapper->update($te);
                            }
							
						}   else {
				            $db->rollBack();
				            $this->view->message = " Le numéro du document d'appel d'offre est invalide ou est déjà utilisé";
                            return;
				        }	
						
						} elseif((trim($user->code_groupe) == 'scmacnev') || (trim($user->code_groupe) == 'technopole')) {
						        
						    $trouveof = $offres_mapper->findoffres($_POST["numero_offre"]);
							$num_offre = $_POST["numero_offre"];
				            $result = $offres_mapper->find($trouveof->getId_appeloffres(),$offres);
				            $offres->setCode_membre_morale($code);
				            $offres_mapper->update($offres);
						    $count = $c_acteur->findConuter() + 1;
                            $c_acteur->setId_acteur($count);
                            $c_acteur->setCode_acteur(null);
                            $c_acteur->setCode_membre($code);
						    if(trim($user->code_groupe) == 'scmacnev'){
                                $c_acteur->setCode_activite('acnev');
						    }  elseif(trim($user->code_groupe) == 'technopole') {
                                $c_acteur->setCode_activite('technopole');
						    }	 
                            $c_acteur->setId_utilisateur($user->id_utilisateur);
                            $c_acteur->setDate_creation($date_idd->toString('yyyy-mm-dd'));
                                  
						    if($row->code_groupe == 'mise_chainepmpbf') {
							        $c_acteur->setType_acteur('pbf');
									$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						            $c_acteur->setId_pays($ligneacteur->id_pays);
						            $c_acteur->setId_region($ligneacteur->id_region);
						            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($row->code_groupe == 'mise_chainepmkr') {
								  
							        $c_acteur->setType_acteur('kr');
									$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						            $c_acteur->setId_pays($ligneacteur->id_pays);
						            $c_acteur->setId_region($ligneacteur->id_region);
						            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
									
                                } elseif($row->code_groupe == 'mise_chainepmd') {
								  
							      $c_acteur->setType_acteur('detentrice');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
								  
                                } elseif($row->code_groupe == 'mise_chainepms') {
							      $c_acteur->setType_acteur('surveillance');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($row->code_groupe == 'mise_chainepmex') {
							      $c_acteur->setType_acteur('executante');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                }
								else {
                                    $c_acteur->setType_acteur('dsms');
								    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						            $c_acteur->setId_pays($ligneacteur->id_pays);
						            $c_acteur->setId_region($ligneacteur->id_region);
						            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                }
                                $c_acteur->setCode_gac_chaine($acteur);								  
                                $t_acteur->insert($c_acteur->toArray());
								
								
								//r?cup?ration de la PrK nr
                                $param = new Application_Model_EuParametresMapper();
                                $par = new Application_Model_EuParametres();
                                $prc = 0;
                                $par_prc = $param->find('prc', 'nr', $par);
                                if ($par_prc == true) {
                                    $prc = $par->getMontant();
                                }
					   
					            $te_mapper = new Application_Model_EuTegcMapper();
                                $te = new Application_Model_EuTegc();
                                $code_te = 'tegcp' .$user->id_filiere. $code;
                                $find_te = $te_mapper->find($code_te,$te);
                                if ($find_te == false) {
                                $te->setCode_tegc($code_te)
                                   ->setId_filiere($user->id_filiere)
                                   ->setMdv($prc)
                                   ->setCode_membre($code)
                                   ->setMontant(0)
							       ->setMontant_utilise(0)
							       ->setSolde_tegc(0);
                                $te_mapper->save($te);
                                } else {
                                  $te->setId_filiere($user->id_filiere);
                                  $te->setMdv($prc);
                                  $te_mapper->update($te);
                                }
								
								$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					            $id_user = $user_mapper->findConuter() + 1;
                                $userin->setId_utilisateur($id_user);
                                $userin->setId_utilisateur_parent($user->id_utilisateur); 
                                $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                                $userin->setNom_utilisateur($membrein->getNom_membre());
                                $userin->setLogin($code);
                                $userin->setPwd(md5($_POST["codesecret"]));
                                $userin->setDescription(null);
                                $userin->setUlock(0);
                                $userin->setCh_pwd_flog(0);
					            if(trim($user->code_groupe) == 'filiere') {
                                   $userin->setCode_groupe('detentrice_filiere');
					               $userin->setCode_groupe_create('detentrice_filiere');
					            } elseif(trim($user->code_groupe) == 'scmacnev') {
                                   $userin->setCode_groupe('executante_acnev');
					               $userin->setCode_groupe_create('executante_acnev');
					            } elseif(trim($user->code_groupe) == 'technopole') {
                                   $userin->setCode_groupe('surveillance_technopole');
					               $userin->setCode_groupe_create('surveillance_technopole');
					            } 
                                $userin->setConnecte(0);
                                $userin->setCode_agence($code_agence);
                                $userin->setCode_secteur(null);
                                $userin->setCode_zone($code_zone);
                                $userin->setId_filiere($user->id_filiere);
                                if(trim($user->code_groupe) == 'gacd' || trim($user->code_groupe) == 'gacs' || trim($user->code_groupe) == 'gacex') {
                                  $userin->setCode_acteur($code_gac);
                                } else {
				                  $userin->setCode_acteur($acteur);
					            }
					            $userin->setCode_membre($code);
		                        $userin->setId_pays($user->id_pays);	    	
                                $user_mapper->save($userin);
					
					            // Mise à jour de la table eu_contrat
					            $contrat = new Application_Model_EuContrat();
				                $mapper_contrat = new Application_Model_EuContratMapper();
				                $id_contrat = $mapper_contrat->findConuter() + 1;
                    
				                $contrat->setId_contrat($id_contrat);
                                $contrat->setCode_membre($code);
                                $contrat->setDate_contrat($date_idd->toString('yyyy-mm-dd'));
                                $contrat->setNature_contrat(null);
					            if(trim($user->code_groupe) == 'filiere') {
				                   $contrat->setId_type_contrat(4);
					            } elseif(trim($user->code_groupe) == 'scmacnev') {   
					               $contrat->setId_type_contrat(5);
					            } elseif(trim($user->code_groupe) == 'technopole') { 
					               $contrat->setId_type_contrat(6);
					            }   
                                $contrat->setId_type_creneau(null);
                                $contrat->setId_type_acteur(null);
                                $contrat->setId_pays($_POST['id_pays']);
                                $contrat->setId_utilisateur($user->id_utilisateur);
                                $contrat->setFiliere(''); 
                    
                                $mapper_contrat->save($contrat);
					
                                //Creation du fs
                                $tab_fs = new Application_Model_DbTable_EuFs();
                                $fs_model = new Application_Model_EuFs();
                                $fs_model->setCode_membre_morale($code)
				                         ->setCode_membre(null)
                                         ->setCode_fs('fs-' . $code)
                                         ->setCreditcode($sms->getCreditCode())
                                         ->setDate_fs($date_idd->toString('yyyy-mm-dd'))
                                         ->setHeure_fs($date_idd->toString('hh:mm:ss'))
                                         ->setId_utilisateur($user->id_utilisateur)
                                         ->setMont_fs($frais_identification);
                                $tab_fs->insert($fs_model->toArray());
					  
                                $sms->setDestAccount_Consumed('nb-tfs-' . $code)
                                    ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                                    ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                                $sms_mapper->update($sms);
						    }
							 
				        }
						if($code_fl != "")   {
						    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
						    if ($sms_fl == null) {
                                $db->rollback();
                                $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
                                return;
                            }
						
						    if($sms_fl->getMotif() != 'fl') {
					           $db->rollBack();
							   $this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
                               return;    
					        }
						
						
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'fl-' . $code;
						
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-mm-dd'))
                           ->setHeure_fl($date_idd->toString('hh:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('fl', 'nn', 'e', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('fl')
                                    ->setIntitule('Frais de licence')
                                    ->setService('e')
                                    ->setCode_type_compte('nn')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						    $compteurfl = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteurfl,null,$code, null, $mont_fl, null, 'Frais de licences', 'fl',$date_idd->toString('yyyy-mm-dd'),$date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
						
						    $sms_fl->setDestAccount_Consumed('fl-'.$code)
                                   ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                                   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms_fl);

                            $tcartes[0]="tpagcp";
									$tcartes[1]="tcncsei";
									$tcartes[2]="tpagci";
									$tcartes[3]="tir";
									$tcartes[4]="tr";
									$tcartes[5]="TPaNu";
									$tcartes[6]="TPaR";
									$tcartes[7]="tfs";
									$tcartes[8]="tpn";
									$tcartes[9]="tib";
									$tcartes[10]="TPaNu";
									$tcartes[11]="tin";
									$tcartes[12]="capa";
									$tcartes[13]="tmarge";
									
									for($i = 0; $i < count($tcartes); $i++) {
									    if($tcartes[$i] == "tcncsei" || $tcartes[$i] == "tpn") {
                                          $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nr';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tr" || $tcartes[$i] == "capa" || $tcartes[$i] == "tmarge") {
                                          $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'nn';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tpagcp" || $tcartes[$i] == "tpagci" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "tfs") {
										    $code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tin") {
										    $tcartes[$i] = "ti"; 
										    $code_compte = 'nn' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nn';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tir") {
										    $tcartes[$i] = "ti"; 
										    $code_compte = 'nr' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nr';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "tib") {
										    $tcartes[$i] = "ti";
										    $code_compte = 'nb' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_compte,$compte);
										}
										
										if(!$res) {
                                          $compte->setCode_cat($tcartes[$i])
                                                 ->setCode_compte($code_compte)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tcartes[$i])
                                                 ->setSolde(0);
										  $map_compte->save($compte);
									
									    }
									
                                    }
									
									$tscartes[0]="tsgcp";
									$tscartes[1]="tscncsei";
									$tscartes[2]="tsgci";
									$tscartes[3]="tscapa";
									$tscartes[4]="TSPaNu";
									$tscartes[5]="TSPaR";
									$tscartes[6]="tsfs";
									$tscartes[7]="tspn";
									$tscartes[8]="tsin";
									$tscartes[9]="tsib";
									$tscartes[10]="tsir";
									$tscartes[11]="tsmarge";
									
									for($j = 0; $j < count($tscartes); $j++) {
									
									    if($tscartes[$j] == "tscncsei" || $tscartes[$j] == "tspn") {
                                          $code_comptets = 'nr' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'nr';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tscapa" || $tscartes[$j] == "tsmarge") {
                                          $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'nn';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsgcp" || $tscartes[$j] == "tsgci" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
										  || $tscartes[$j] == "tsfs") {
										    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsin") {
										    $tscartes[$j] = "tsi"; 
										    $code_comptets = 'nn' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nn';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsir") {
										    $tscartes[$j] = "tsi"; 
										    $code_compte = 'nr' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nr';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "tsib") {
										    $tscartes[$j] = "tsi";
										    $code_comptets = 'nb' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'nb';
									        $res = $map_compte->find($code_comptets,$compte);
										}
										
										if(!$res) {
                                          $compte->setCode_cat($tscartes[$j])
                                                 ->setCode_compte($code_comptets)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                                 ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tscartes[$j])
                                                 ->setSolde(0);
											$map_compte->save($compte);
									    }
									
                                    }							
						}
						
						if($code_fkps != "") {
						
                            $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
						    if ($sms_fkps == null) {
                               $db->rollback();
                               $this->view->message = 'Le code fkps [' . $code_fkps . ']  est  invalide !!!';
                               return;
                            }
						
						    if($sms_fkps->getMotif() != 'fkps') {
					           $db->rollBack();
                               $this->view->message = " Le motif pour lequel ce code fkps est émis ne correspond pas pour ce type d'operation";
                               return;    
					        } 
						    $carte = new Application_Model_EuCartes();
                            $t_carte = new Application_Model_DbTable_EuCartes();
						    $id_demande = $carte->findConuter() + 1;
						    $carte->setId_demande($id_demande)
							      ->setCode_cat($tcartes[0])
                                  ->setCode_membre($code)
                                  ->setMont_carte($fkps)
                                  ->setDate_demande($date_idd->toString('yyyy-mm-dd'))
                                  ->setLivrer(0)
                                  ->setCode_Compte("nb-".$tcartes[0]."-".$code)
                                  ->setImprimer(0)
                                  ->setCardPrintedDate('')
                                  ->setCardPrintedIDDate(0)
                                  ->setId_utilisateur($user->id_utilisateur);
                            $t_carte->insert($carte->toArray());
                             
							$sms_fkps->setDestAccount_Consumed('cps-' . $code)
                                     ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                                     ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms_fkps); 

							
						}
						$compteur=Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                        $db->commit();
                        return $this->_helper->redirector('morale','eu-preinscription',null,array('controller' => 'eu-preinscription','action'=>'morale')); 
					} catch (Exception $exc) {
                        $db->rollback();
                        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
				        $this->view->id_pays = $_POST["id_pays"];
                        $this->view->portable = $_POST["portable_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        return;
                    }   
			    }
		}
		
		
		
		
		public function datapAction() {
		    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'code_membre');
            $sord = $this->_request->getParam("sord", 'asc');
		    $membre = $this->_request->getParam("membre");
		    $tabela = new Application_Model_DbTable_EuMembre();
			$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false);
			   
			if($membre !='') {
			    $select->join('eu_preinscription', 'eu_preinscription.code_membre = eu_membre.code_membre');
				$select->where('id_utilisateur = ?', $user->id_utilisateur);
				$select->where('code_membre = ?',$membre);
		    } else {
				$select->join('eu_preinscription', 'eu_preinscription.code_membre = eu_membre.code_membre');
				$select->where('id_utilisateur = ?', $user->id_utilisateur);
			}
            $membres = $tabela->fetchAll($select);
            $count = count($membres);
		    $membres = $tabela->fetchAll($select);
            $count = count($membres);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }
            if ($page > $total_pages)
               $page = $total_pages;
               $membres = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

               $responce['page'] = $page;
               $responce['total'] = $total_pages;
               $responce['records'] = $count;
               $i = 0;
		       foreach ($membres as $row) {
                   $responce['rows'][$i]['id'] = $row->code_membre;
                   $responce['rows'][$i]['cell'] = array(
                   $row->code_membre,
                   stripslashes (html_entity_decode($row->nom_membre)),
                   stripslashes (html_entity_decode($row->prenom_membre)),
                   $row->sexe_membre,
                   stripslashes (html_entity_decode($row->profession_membre)),
                   $row->portable_membre,
                   stripslashes(html_entity_decode($row->ville_membre))
                );
            $i++;
            }	 
            $this->view->data = $responce;
		}
		
		
		public function peditAction() {
	
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_agence = $user->code_agence;
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuMembrep();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
			   $membre = new Application_Model_EuMembre($form->getValues());
			   $date1 = explode("/",$this->getRequest()->date_nais_membre);
               $dated = $date1[0] . '.' . $date1[1] . '.' . $date1[2];
			   $date_nais = new Zend_Date($dated,Zend_Date::dates,'de');
               $membre->setCode_membre($this->getRequest()->code_membre);
               $membre->setCode_agence($code_agence)
                      ->setDate_identification($date_id->toString('yyyy-mm-dd'))
                      ->setHeure_identification($date_id->toString('hh:mm:ss'))
                      ->setId_utilisateur($user->id_utilisateur)
					  ->setNom_membre(addslashes(trim($this->getRequest()->nom_membre)))
					  ->setPrenom_membre(addslashes(trim($this->getRequest()->prenom_membre)))
					  ->setSexe_membre($this->getRequest()->sexe_membre)
					  ->setDate_nais_membre($date_nais->toString('yyyy-mm-dd'))
					  ->setLieu_nais_membre(addslashes(trim($this->getRequest()->lieu_nais_membre)))
					  ->setId_pays($this->getRequest()->id_pays)
					  ->setProfession_membre(addslashes (trim ($this->getRequest()->profession_membre)))
					  ->setFormation(addslashes (trim ($this->getRequest()->formation)))
					  ->setPere_membre(addslashes (trim ($this->getRequest()->pere_membre)))
					  ->setMere_membre(addslashes (trim ($this->getRequest()->mere_membre)))
					  ->setSitfam_membre(addslashes (trim ($this->getRequest()->sitfam_membre)))
					  ->setNbr_enf_membre($this->getRequest()->nbr_enf_membre)
					  ->setQuartier_membre(addslashes (trim ($this->getRequest()->quartier_membre)))
					  ->setVille_membre(addslashes (trim ($this->getRequest()->ville_membre)))
					  ->setBp_membre($this->getRequest()->bp_membre)
					  ->setTel_membre($this->getRequest()->tel_membre)
					  ->setEmail_membre(addslashes (trim ($this->getRequest()->email_membre)))
					  ->setPortable_membre($this->getRequest()->portable_membre)
					  ->setId_religion_membre($this->getRequest()->id_religion_membre);
                $mapper = new Application_Model_EuMembreMapper();
                $mapper->update($membre);
                return $this->_helper->redirector('index');
            } else {
                
            }
            $num_membre = $this->getRequest()->code_membre;
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
        } else {
            $num_membre = $request->membre;
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
            $mapper->find($num_membre, $membre);
			$tabela = new Application_Model_DbTable_EuMembre();
			$select = $tabela->select();
			$select->from('eu_membre',array('eu_membre.date_nais_membre',"to_char((eu_membre.date_nais_membre),'dd/mm/yyyy') datenais"));
			$select->where('code_membre like ?',$membre->getCode_membre());
			$membres = $tabela->fetchAll($select);
			$row = $membres->current();
            if ($membre->getCode_membre() == $num_membre) {
                $data = array(
                  'code_membre' => $num_membre,
                  'nom_membre' => stripslashes (html_entity_decode($membre->getNom_membre())),
                  'prenom_membre' => stripslashes (html_entity_decode($membre->getPrenom_membre())),
                  'sexe_membre' => $membre->getSexe_membre(),
                  'date_nais_membre' => $row->datenais,
                  'lieu_nais_membre' => stripslashes (html_entity_decode($membre->getLieu_nais_membre())),
                  'id_pays' => $membre->getId_pays(),
                  'profession_membre' => stripslashes (html_entity_decode($membre->getProfession_membre())),
                  'formation' => stripslashes (html_entity_decode($membre->getFormation())),
                  'pere_membre' => stripslashes (html_entity_decode($membre->getPere_membre())),
                  'mere_membre' => stripslashes (html_entity_decode($membre->getMere_membre())),
                  'sitfam_membre' => $membre->getSitfam_membre(),
                  'nbr_enf_membre' => $membre->getNbr_enf_membre(),
                  'quartier_membre' => stripslashes (html_entity_decode($membre->getQuartier_membre())),
                  'ville_membre' => stripslashes (html_entity_decode($membre->getVille_membre())),
                  'bp_membre' => $membre->getBp_membre(),
                  'tel_membre' => $membre->getTel_membre(),
                  'email_membre' => stripslashes (html_entity_decode($membre->getEmail_membre())),
                  'date_identification' => $membre->getDate_identification(),
                  'portable_membre' => $membre->getPortable_membre(),
                  'code_agence' => $membre->getCode_agence(),
                  'heure_identification' => $membre->getHeure_identification(),
                  'id_religion_membre' => $membre->getId_religion_membre(),
                  'id_utilisateur' => $membre->getId_utilisateur(),
                  'auto_enroler' => $membre->getAuto_enroler()
                );
                $form->populate($data);
            }
        }
		
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick',"window.open('" .
        $this->view->url(array('controller' => 'eu-membre-ancien','action' =>'index'), 'default', true) ."','_self')");

        $this->view->membre = $membre;
        $this->view->form = $form;
    }
	
    public function detailAction() {
        $this->_helper->layout->disableLayout();
        $num_membre = $this->getRequest()->membre;
        $mapper = new Application_Model_EuMembreMapper();
        $membre = new Application_Model_EuMembre();
        //$mapper->find($num_membre, $membre);
		$membre=$mapper->detail($num_membre);
        $this->view->membre = $membre;
    }



    public function datapbfAction() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_preinscription_morale');
        $sord = $this->_request->getParam("sord", 'asc');
	    $membre = $this->_request->getParam("membre");
	    $tabela = new Application_Model_DbTable_EuPreinscriptionMorale();
			   
	    $select = $tabela->select();
        $select->from($tabela,array('eu_preinscription_morale.*',"to_char((eu_preinscription_morale.date_inscription),'dd/mm/yyyy') dateidentif"))
			   ->where('code_membre_morale is null');	 		  
	    $cats = $tabela->fetchAll($select);
        $count = count($cats);
				
				
		if ($count > 0) {
               $total_pages = ceil($count / $limit);
        } else {
               $total_pages = 0;
        }
				
	    if ($page > $total_pages)
            $page = $total_pages;
            $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($cats as $row) {
                $responce['rows'][$i]['id'] = $row->id_preinscription_morale;
                $responce['rows'][$i]['cell'] = array(
                $row->id_preinscription_morale,
                $row->raison_sociale,
                $row->quartier_membre,
                $row->ville_membre,
                $row->bp_membre,
                $row->tel_membre, 
                $row->dateidentif,
                $row->portable_membre,
		        $row->email_membre,
		        $row->site_web,
				$row->num_registre_membre,
				$row->numero_agrement_filiere,
				$row->numero_agrement_acnev,
				$row->numero_agrement_technopole,
				$row->code_fs,
				$row->code_fl,
				$row->code_rep,
				$row->code_fkps,
				$row->domaine_activite,
				$row->code_type_acteur,
				$row->code_statut,
				$row->id_pays
            );
                $i++;
            }
            $this->view->data = $responce;
	}
	
	
	public function datakrAction() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_preinscription_morale');
        $sord = $this->_request->getParam("sord", 'asc');
	    $membre = $this->_request->getParam("membre");
	    $tabela = new Application_Model_DbTable_EuPreinscriptionMorale();
			   
	    $select = $tabela->select();
        $select->from($tabela,array('eu_preinscription_morale.*',"to_char((eu_preinscription_morale.date_inscription),'dd/mm/yyyy') dateidentif"))
			   ->where('code_membre_morale is null');	 		  
	    $cats = $tabela->fetchAll($select);
        $count = count($cats);
					
		if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
				
		if ($page > $total_pages)
            $page = $total_pages;
            $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($cats as $row) {
                $responce['rows'][$i]['id'] = $row->id_preinscription_morale;
                $responce['rows'][$i]['cell'] = array(
                $row->id_preinscription_morale,
                $row->raison_sociale,
                $row->quartier_membre,
                $row->ville_membre,
                $row->bp_membre,
                $row->tel_membre, 
                $row->dateidentif,
                $row->portable_membre,
		        $row->email_membre,
		        $row->site_web,
				$row->num_registre_membre,
				$row->numero_agrement_filiere,
				$row->numero_agrement_acnev,
				$row->numero_agrement_technopole,
				$row->code_fs,
				$row->code_fl,
				$row->code_rep,
				$row->code_fkps,
				$row->domaine_activite,
				$row->code_type_acteur,
				$row->code_statut,
				$row->id_pays
            );
                $i++;
            }
            $this->view->data = $responce;
	}
	 
	 
	 

	
		
	public function dataAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx",'id_preinscription');
           $sord = $this->_request->getParam("sord", 'asc');
		   $this->_helper->layout->disableLayout();
		   if (isset($_GET["date_ins"])) $date_ins = $_GET["date_ins"];
           if (isset($_GET["nom"])) $nom = strtoupper($_GET["nom"]);
           if (isset($_GET["prenom"])) $prenom = strtoupper($_GET["prenom"]);
		   $tabela = new Application_Model_DbTable_EuPreinscription();   
		   $select = $tabela->select();
		   
            $select->from($tabela,array('eu_preinscription.*',"to_char((eu_preinscription.date_nais_membre),'dd/mm/yyyy') datenaismembre"))
				   ->where('code_membre is null');	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);
			
			if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }
			
			if ($page > $total_pages) $page = $total_pages;

        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->id_preinscription;
            $responce['rows'][$i]['cell'] = array(
              $row->id_preinscription,
              $row->nom_membre,
              $row->prenom_membre,
              $row->sexe_membre,
              $row->profession_membre,
              $row->tel_membre,
              $row->ville_membre, 
              $row->pere_membre,
              $row->mere_membre,
		      $row->quartier_membre,
		      $row->bp_membre,
		      $row->nbr_enf_membre,
		      $row->email_membre,
		      $row->portable_membre,
		      $row->formation,
		      $row->lieu_nais_membre,
			  $row->datenaismembre,
			  $row->sitfam_membre,
			  $row->id_pays,
			  $row->id_religion_membre,
			  $row->code_fs,
			  $row->code_fl,
			  $row->code_fkps
			  
           );
           $i++;
        }
        $this->view->data = $responce;				
	}
		
		
		
    public function newAction() {
           	
    }
		
		
		
		
		
		
		
		
}


?>		