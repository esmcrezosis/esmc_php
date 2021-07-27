<?php

class BonachatController extends Zend_Controller_Action {

	public function init() 
	{
		/* Initialize action controller here */
		
include("Url.php");   
 
	}


    public function achatdebonAction() {
	       $sessionmembre = new Zend_Session_Namespace('membre');
		   //$this->_helper->layout->disableLayout();
		   $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		   if (!isset($sessionmembre->code_membre)) {
			  $this->_redirect('/index/mcnp');
		   }
           include("Transfert.php");
    
		   $request = $this->getRequest ();
			
		   if ($request->isPost ()) {
              if (isset($_POST['ok']) && $_POST['ok']=="ok") {
                  if (isset($_POST['acheteur_numero']) && $_POST['acheteur_numero']!=""
                     && isset($_POST['type_transfert']) && $_POST['type_transfert']!=""
                     && isset($_POST['acheteur_cel']) && $_POST['acheteur_cel']!=""
	                 && isset($_POST['acheteur_banque']) && $_POST['acheteur_banque']!=""
	                 && isset($_POST['mont_transfert']) && $_POST['mont_transfert']!=""
		             && isset($_FILES['acheteur_vignette']['name']) && $_FILES['acheteur_vignette']['name']!=""
		             && verif_img($_FILES['acheteur_vignette']['name']) == 1)   {
				   
				     $db = Zend_Db_Table::getDefaultAdapter();
                     $db->beginTransaction();
				     try   {
                           $acheteur_mapper = new Application_Model_EuAcheteurMapper();
                           $acheteur = $acheteur_mapper->fetchAllByNumero($_POST['acheteur_numero'], $_POST['acheteur_banque']); 
                           if(count($acheteur) > 0)  {
 								   $db->rollback();
                              	   $sessionmembre->error = "Numéro de reçu déjà utilisé ...";
								   $this->_redirect('/bonachat/achatdebon');
                                   return;	
                           } else {
						   
							   $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
		                       $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($_POST['acheteur_banque'], $_POST['acheteur_numero'], $_POST['acheteur_date_numero']);
                               if(count($relevebancairedetail) > 0 && $relevebancairedetail->relevebancairedetail_montant >= $_POST['mont_transfert']) {

                                  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                                  $acheteur = new Application_Model_EuAcheteur();
                                  $acheteur_mapper = new Application_Model_EuAcheteurMapper();
		
		                          //include("Transfert.php");
		                          if(isset($_FILES['acheteur_vignette']['name']) && $_FILES['acheteur_vignette']['name']!="") {
		                               $chemin	= "acheteurs";
		                               $file = $_FILES['acheteur_vignette']['name'];
		                               $file1='acheteur_vignette';
		                               $acheteur_vignette = $chemin."/".transfert($chemin,$file1);
		                           } else {$acheteur_vignette = "";}
								   
                                   $compteur_acheteur = $acheteur_mapper->findConuter() + 1;
                                   $acheteur->setAcheteur_id($compteur_acheteur);
                                   $acheteur->setAcheteur_nom($sessionmembre->nom_membre);
                                   $acheteur->setAcheteur_prenom($sessionmembre->prenom_membre);
                                   $acheteur->setAcheteur_raison_sociale($sessionmembre->raison_sociale);
                                   $acheteur->setAcheteur_numero($_POST['acheteur_numero']);
                                   $acheteur->setAcheteur_date_numero($_POST['acheteur_date_numero']);
                                   $acheteur->setAcheteur_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                   $acheteur->setType_transfert($_POST['type_transfert']);
                                   $acheteur->setAcheteur_banque($_POST['acheteur_banque']);
                                   $acheteur->setAcheteur_cel($_POST['acheteur_cel']);
                                   $acheteur->setAcheteur_email($_POST['acheteur_email']);
                                   $acheteur->setMont_transfert($_POST['mont_transfert']);
                                   $acheteur->setAcheteur_code_membre($sessionmembre->code_membre);
                                   $acheteur->setAcheteur_type("P".$sessionmembre->typepernonne);
                                   $acheteur->setCode_agence($sessionmembre->code_agence);
                                   $acheteur->setAcheteur_vignette($acheteur_vignette);
                                   $acheteur->setPublier(0);
			                       $acheteur->setErreur(0);
                                   $acheteur_mapper->save($acheteur);
			
                                   $id_acheteur = $compteur_acheteur;

                                   $id_utilisateur_acnev = 1;
                                   $id_utilisateur_filiere = 2;
                                   $id_utilisateur_technopole = 3;

								   $acheteur = new Application_Model_EuAcheteur();
								   $acheteurM = new Application_Model_EuAcheteurMapper();
								   $acheteurM->find($id_acheteur, $acheteur);

								   /*$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
								   if($relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($acheteur->acheteur_banque, $acheteur->acheteur_numero, $acheteur->acheteur_date_numero)){*/

                                   $date_id = new Zend_Date(Zend_Date::ISO_8601);

                                   //////validation acnev
								   $acheteur = new Application_Model_EuAcheteur();
								   $acheteurM = new Application_Model_EuAcheteurMapper();
								   $acheteurM->find($id_acheteur, $acheteur);
								
								   $acheteur->setPublier(1);
								   $acheteurM->update($acheteur);

								   $validation_quittance = new Application_Model_EuValidationQuittance();
								   $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
								   $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
								   $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
								   $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_acnev);
								   $validation_quittance->setValidation_quittance_acheteur($acheteur->acheteur_id);
								   $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
								   $validation_quittance->setPublier(1);
								   $validation_quittance_mapper->save($validation_quittance);


                                  //////validation filere
								  $acheteur = new Application_Model_EuAcheteur();
								  $acheteurM = new Application_Model_EuAcheteurMapper();
								  $acheteurM->find($id_acheteur, $acheteur);
								
								  $acheteur->setPublier(2);
								  $acheteurM->update($acheteur);


								  $validation_quittance = new Application_Model_EuValidationQuittance();
								  $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
								  $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
								  $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
								  $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_filiere);
								  $validation_quittance->setValidation_quittance_acheteur($acheteur->acheteur_id);
								  $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
								  $validation_quittance->setPublier(1);
								  $validation_quittance_mapper->save($validation_quittance);



                                  //////validation technopole
								  $acheteur = new Application_Model_EuAcheteur();
								  $acheteurM = new Application_Model_EuAcheteurMapper();
								  $acheteurM->find($id_acheteur, $acheteur);
								
								  $acheteur->setPublier(3);
								  $acheteurM->update($acheteur);


								  $validation_quittance = new Application_Model_EuValidationQuittance();
								  $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
								  $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
								  $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
								  $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_technopole);
								  $validation_quittance->setValidation_quittance_acheteur($acheteur->acheteur_id);
								  $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
								  $validation_quittance->setPublier(1);
								  $validation_quittance_mapper->save($validation_quittance);

                                  ////////////////////////mise a jour releve bancaire								
								  /*$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
								  if($relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($acheteur->acheteur_banque, $acheteur->acheteur_numero, $acheteur->acheteur_date_numero)){*/
		
								  $relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
								  $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
								  $relevebancairedetail2M->find($relevebancairedetail->relevebancairedetail_id, $relevebancairedetail2);
								
								  $relevebancairedetail2->setPublier(1);
								  $relevebancairedetail2M->update($relevebancairedetail2);
								//}
								
								
                                /////////////////////////creation bon
																
			                    $bon = new Application_Model_EuBon();
			                    $bon_mapper = new Application_Model_EuBonMapper();
															
			                    $compteur_bon = $bon_mapper->findConuter() + 1;
			                    $bon->setBon_id($compteur_bon);
			                    $bon->setBon_numero("BA".ajoutezero8($compteur_bon));
			                    $bon->setBon_type("BA");
			                    $bon->setBon_montant($acheteur->mont_transfert);
			                    $bon->setBon_montant_salaire(0);
			                    $bon->setBon_code_membre_emetteur($sessionmembre->code_membre);
			                    $bon->setBon_code_membre_distributeur(NULL);
			                    $bon->setBon_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
			                    $bon->setBon_code_barre("ESMC".strtoupper(Util_Utils::genererCodeSMS(5)));
			                    $bon->setBon_proposition(0);
			                    $bon_mapper->save($bon);
								
								///////////////////////////////////////TRANSFERT DU MONTANT CAPA//////////////////////////////////////////////
								$montant = $acheteur->mont_transfert;
                                $mobile = $_POST['acheteur_cel'];								
                                $codeproduit = 'CAPA';
			                    $date = Zend_Date::now();
								
								$map_compte_transfert = new Application_Model_EuCompteMapper();
                                $compte_transfert = new Application_Model_EuCompte();
			                    $sms_money   = new Application_Model_EuSmsmoney();
                                $money_map   = new Application_Model_EuSmsmoneyMapper();
			
			                    $det_sms   = new Application_Model_EuDetailSmsmoney();
			                    $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
			
			                    $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			                    $det_vtesms  = new Application_Model_EuDetailVentesms();
								
								$membre_pbf = '0000000000000000001M';
	                            $code_compte_pbf = "NN-TR-".$membre_pbf;
			                    $ret = $map_compte_transfert->find($code_compte_pbf,$compte_transfert);
								
								if($ret && ($compte_transfert->getSolde() >= ($montant))) {
			                       // Mise à jour du compte de transfert
				                   $compte_transfert->setSolde($compte_transfert->getSolde() - $montant);
                                   $map_compte_transfert->update($compte_transfert);    
	                            } else {
			                       $db->rollback();				
			                       $sessionmembre->error = 'Erreur de traitement : le solde du compte insuffisant';
								   $this->_redirect('/bonachat/achatdebon');
                                   return;			   
			                    }
								
								
								// Traitement des produits CAPA et insertion dans la table eu_smsmoney
				                $lignesdetcapa = $det_sms_m->findSMSByCompte($membre_pbf,'CAPA');
								if ($lignesdetcapa != null) {
								   $codecapa   = strtoupper(Util_Utils::genererCodeSMS(8));
					               $nengcapa = $money_map->findConuter() + 1;
								   
								   $sms_money->setNEng($nengcapa)
                	                         ->setCode_Agence(null)
                                             ->setCreditAmount($montant)
                                             ->setSentTo($mobile)
                                             ->setMotif('CAPA')
                                             ->setId_Utilisateur(null)
                                             ->setCurrencyCode('XOF')
                                             ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                             ->setFromAccount($code_compte_pbf)
                                             ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                             ->setCreditCode($codecapa)
                                             ->setDestAccount(null)
                                             ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/MM/yyyy')))
                                             ->setDestAccount_Consumed($compteur_bon)
                                             ->setDatetimeConsumed($date->toString('yyyy-MM-dd HH:mm:ss'))
                                             ->setNum_recu(null);
                                    $money_map->save($sms_money);
									
									$i = 0;
					                $reste = $montant;
					                $nbre_lignesdetcapa = count($lignesdetcapa);
									while ($reste > 0 && $i < $nbre_lignesdetcapa) {
									      $lignedetcapa = $lignesdetcapa[$i];
                                          $id = $lignedetcapa->getId_detail_smsmoney();
						                  $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
										  if ($reste >= $lignedetcapa->getSolde_sms()) {
						                     //Mise à jour  des lignes d'enrégistrement
						                     //insertion dans la table eu_detailventesms
						                     $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                             $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                ->setId_detail_smsmoney($id)
                                                        ->setCode_membre_dist($membre_pbf)
                                                        ->setCode_membre($sessionmembre->code_membre)
                                                        ->setType_tansfert('CAPA')
                                                        ->setCreditcode($codecapa)
                                                        ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                        ->setMont_vente($lignedetcapa->getSolde_sms())
                                                        ->setId_utilisateur(null)
                                                        ->setCode_produit('CAPA');
                                              $det_vte_sms->insert($det_vtesms->toArray());
                                              $reste = $reste - $lignedetcapa->getSolde_sms();
							                  $lignedetcapa->setMont_vendu($lignedetcapa->getMont_vendu() + $lignedetcapa->getSolde_sms())
		                                                   ->setMont_regle($lignedetcapa->getMont_regle() + $lignedetcapa->getSolde_sms())
		                                                   ->setSolde_sms(0);
                                              $det_sms_m->update($lignedetcapa);			 							   
						                    } else  {
							                  //Mise à jour  des lignes d'enrégistrement
							                  //insertion dans la table eu_detailventesms
						                      $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                              $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                 ->setId_detail_smsmoney($id)
                                                         ->setCode_membre_dist($membre_pbf)
                                                         ->setCode_membre($sessionmembre->code_membre)
                                                         ->setType_tansfert('CAPA')
                                                         ->setCreditcode($codecapa)
                                                         ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                         ->setMont_vente($reste)
                                                         ->setId_utilisateur(null)
                                                         ->setCode_produit('CAPA');
                                               $det_vte_sms->insert($det_vtesms->toArray());
                                               $lignedetcapa->setSolde_sms($lignedetcapa->getSolde_sms() - $reste);
						                       $lignedetcapa->setMont_vendu($lignedetcapa->getMont_vendu() + $reste);
							                   $lignedetcapa->setMont_regle($lignedetcapa->getMont_regle() + $reste);
                                               $det_sms_m->update($lignedetcapa);
						                       $reste = 0;
						                      }
						                      $i++;
									    }	
								
								
								} else {
								   $db->rollback();
			                       $sessionmembre->error = 'Erreur de traitement : le solde du compte est null';
								   $this->_redirect('/bonachat/achatdebon');
                                   return;	
								}
								
								
                                ////////////////////////////RECHARGE DU NN-CAPA////////////////////////////////////////////////////////////										
				                $mapper = new Application_Model_EuOperationMapper();
				                $place = new Application_Model_EuOperation();
				                $compteur = $mapper->findConuter() + 1;
				                $place->setId_operation($compteur)
						              ->setDate_op($date->toString('yyyy-MM-dd HH:mm:ss'))
						              ->setMontant_op($montant);
				                if (substr($sessionmembre->code_membre, -1) == "P") {
					               $place->setCode_membre($sessionmembre->code_membre);
					               $place->setCode_membre_morale(NULL);
				                } else if (substr($sessionmembre->code_membre, -1) == "M") {
					               $place->setCode_membre(NULL);
					               $place->setCode_membre_morale($sessionmembre->code_membre);
				                }
								
				                $place->setHeure_op($date->toString('HH:mm:ss'))
						              ->setCode_produit($codeproduit)
						              ->setId_utilisateur(NULL)
						              ->setLib_op('Recharge de compte')
						              ->setCode_cat('CAPA')
						              ->setType_op('REC');
				                 $mapper->save($place);

				                 $m_compte = new Application_Model_EuCompteMapper();
				                 $m_compte_ts = new Application_Model_EuCompteMapper();
				                 $compte = new Application_Model_EuCompte();
				                 $compte_ts = new Application_Model_EuCompte();
				                 $code_compte = 'NN-CAPA-' . $sessionmembre->code_membre;
				                 $code_compte_ts = 'NN-TSCAPA-' . $sessionmembre->code_membre;
				                 $ret_req = $m_compte->find($code_compte, $compte);
								 
				                 if ($ret_req == FALSE) {
					                 $compte->setCode_cat('CAPA');
					                 if (substr($sessionmembre->code_membre, -1) == "P") {
						                 $compte->setCode_membre($sessionmembre->code_membre);
					                 } else if (substr($sessionmembre->code_membre, -1) == "M") {
						                 $compte->setCode_membre_morale($sessionmembre->code_membre);
					                 }
									 
					                 $compte->setCode_compte($code_compte)
							                ->setCode_type_compte('NN')
							                ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
							                ->setDesactiver(0)
							                ->setLib_compte('CAPA')
							                ->setSolde($montant);
					                 $m_compte->save($compte);

				                     $ret_req_ts = $m_compte_ts->find($code_compte_ts, $compte_ts);
				                     if ($ret_req_ts == FALSE) {
					                    $compte_ts->setCode_cat('CAPA');
					                    if (substr($sessionmembre->code_membre, -1) == "P") {
						                   $compte_ts->setCode_membre($sessionmembre->code_membre);
					                    } else if (substr($sessionmembre->code_membre, -1) == "M") {
						                   $compte_ts->setCode_membre_morale($sessionmembre->code_membre);
					                    }
					                    $compte_ts->setCode_compte($code_compte_ts)
							                      ->setCode_type_compte('NN')
							                      ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
							                      ->setDesactiver(0)
							                      ->setLib_compte('TSCAPA')
							                      ->setSolde(0);
					                    $m_compte_ts->save($compte_ts);
                                      }
                             } else {
					              $compte->setSolde($compte->getSolde() + $montant);
					              $m_compte->update($compte);
                             }

				             // Mise à jour des CAPA
				             $date_deb = Zend_Date::now();

				             $type = $sessionmembre->type;

				             $m_capa = new Application_Model_EuCapaMapper();
				             $capa = new Application_Model_EuCapa();
				             $code_capa = 'CAPA' . $type . $date_deb->toString('yyyyMMddHHmmss');
				             $capa->setCode_capa($code_capa)
						          ->setId_operation($compteur)
						          ->setDate_capa($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						          ->setMontant_capa($montant)
						          ->setMontant_utiliser(0)
						          ->setMontant_solde($montant)
						          ->setCode_membre($sessionmembre->code_membre)
						          ->setHeure_capa($date_deb->toString('HH:mm:ss'))
						          ->setType_capa($type)
						          ->setCode_compte($code_compte)
						          ->setEtat_capa('Actif')
						          ->setCode_produit($codeproduit)
						          ->setOrigine_capa('BA');
				             $m_capa->save($capa);



				/*$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
				$smsmoney = new Application_Model_EuSmsmoney();
				$smsmoney = $smsmoneyM->findByCreditCode($_POST['creditcode']);
				$smsmoneyM->find($smsmoney->NEng, $smsmoney);

				$smsmoney->setDestAccount_Consumed($code_compte)
						->setDateTimeconsumed($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('yyyy-MM-dd HH:mm:ss')));
				$smsmoneyM->update($smsmoney);*/


								
								//}
								
								
//$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSms($compteur, $_POST["acheteur_cel"], "Vous venez de payer un code SMS. Vous allez recevoir une confirmation dans quelques minutes");
								
							    $db->commit();
                                $sessionmembre->error = "Opération bien effectuée. Passez à l'étape suivante ...";
		                        $this->_redirect('/bonachat/listacheteur3');
								
									} else {
										
      
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
      
        $acheteur = new Application_Model_EuAcheteur();
        $acheteur_mapper = new Application_Model_EuAcheteurMapper();
		
		                    //include("Transfert.php");
		                    if(isset($_FILES['acheteur_vignette']['name']) && $_FILES['acheteur_vignette']['name']!="") {
		                        $chemin	= "acheteurs";
		                        $file = $_FILES['acheteur_vignette']['name'];
		                        $file1='acheteur_vignette';
		                        $acheteur_vignette = $chemin."/".transfert($chemin,$file1);
		                    } else {$acheteur_vignette = "";}
							
            $compteur_acheteur = $acheteur_mapper->findConuter() + 1;
            $acheteur->setAcheteur_id($compteur_acheteur);
            $acheteur->setAcheteur_nom($sessionmembre->nom_membre);
            $acheteur->setAcheteur_prenom($sessionmembre->prenom_membre);
            $acheteur->setAcheteur_raison_sociale($sessionmembre->raison_sociale);
            $acheteur->setAcheteur_numero($_POST['acheteur_numero']);
            $acheteur->setAcheteur_date_numero($_POST['acheteur_date_numero']);
            $acheteur->setAcheteur_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $acheteur->setType_transfert($_POST['type_transfert']);
            $acheteur->setAcheteur_banque($_POST['acheteur_banque']);
            $acheteur->setAcheteur_cel($_POST['acheteur_cel']);
            $acheteur->setAcheteur_email($_POST['acheteur_email']);
            $acheteur->setMont_transfert($_POST['mont_transfert']);
            $acheteur->setAcheteur_code_membre($sessionmembre->code_membre);
            $acheteur->setAcheteur_type("P".$sessionmembre->typepernonne);
            $acheteur->setCode_agence($sessionmembre->code_agence);
            $acheteur->setAcheteur_vignette($acheteur_vignette);
            $acheteur->setPublier(0);
			$acheteur->setErreur(0);
            $acheteur_mapper->save($acheteur);
			
			
							    $db->commit();
										$sessionmembre->error = "Opération bien effectuée. Mais la validation automatique n'est pas effectif, revenez plus tard ...";
		                        $this->_redirect('/bonachat/listacheteur2');
									}
						   
	  }
				   } catch (Exception $exc) {
				        $db->rollback();
                        $sessionmembre->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
		                        //$this->_redirect('/bonachat/achatdebon');
                        return;
                   } 
				   
				 }   else {  $sessionmembre->error = "Champs * obligatoire ..."; } 
			}

	 }


}
      
    
    public function listacheteur2Action()
    {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/index/mcnp');
		}

        $acheteur = new Application_Model_EuAcheteurMapper();
        $this->view->entries = $acheteur->fetchAllByMembre2($sessionmembre->code_membre);
 
        $this->view->tabletri = 1;

}

    
    public function listacheteur3Action()
    {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/index/mcnp');
		}

        $acheteur = new Application_Model_EuAcheteurMapper();
        $this->view->entries = $acheteur->fetchAllByMembre3($sessionmembre->code_membre);
 
        $this->view->tabletri = 1;

}


    
    public function listbonachatAction()
    {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/index/mcnp');
		}

        $bon = new Application_Model_EuBonMapper();
        $this->view->entries = $bon->fetchAllByMembreBA($sessionmembre->code_membre);
 
        $this->view->tabletri = 1;

}


    public function pdfbonachatAction()
    {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/index/mcnp');
		}

		                    include("Transfert.php");


		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {



		$bon = new Application_Model_EuBon();
		$bonM = new Application_Model_EuBonMapper();
		$bonM->find($id, $bon);
		


$date_id = new Zend_Date(Zend_Date::ISO_8601);



$htmlpdf = "";
/*<page_footer>
        <table>
<tr>
    <td align="center">
	<hr>
	Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425
	</td>
  </tr>
        </table>
    </page_footer>*/
//backbottom="10mm" backimgw="100%" backimgh="100%"
$htmlpdf .= '
    <page  backimgx="center" backimgy="top"  backimg="'.Util_Utils::getParamEsmc(2).'images/BA3.gif">
    

<table width="768" border="0">
<tbody>
  <tr>
    <td colspan="4"><img src="'.Util_Utils::getParamEsmc(2).'images/entete.gif" width="738" height="156" /></td>
  </tr>';
	
$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><barcode type="C39" value="'.$bon->bon_code_barre.'" label="none"></barcode></td>
  </tr>';// style="width:150mm; height:10mm;"
$htmlpdf .= '
  <tr>
    <td colspan="4" align="center"><strong><em><u>N° Bon d\'Achat : '.$bon->bon_numero.'</u></em></strong></td>
  </tr>';
		  
					if (substr($bon->bon_code_membre_emetteur, -1) == "P") {

        $membre = new Application_Model_EuMembre();
        $membreM = new Application_Model_EuMembreMapper();
        $membreM->find($bon->bon_code_membre_emetteur, $membre);
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Nom & prénom(s) </u>: </em><strong><em>'.$membre->nom_membre.' '.$membre->prenom_membre.'</em></strong></p></td>
  </tr>';
					} else if (substr($bon->bon_code_membre_emetteur, -1) == "M") {

        $membre_morale = new Application_Model_EuMembreMorale();
        $membre_moraleM = new Application_Model_EuMembreMoraleMapper();
        $membre_moraleM->find($bon->bon_code_membre_emetteur, $membre_morale);
$htmlpdf .= '
  <tr>
    <td colspan="4" align="left"><p><em><u>Raison sociale </u>: </em><strong><em>'.$membre_morale->raison_sociale.'</em></strong></p></td>
  </tr>';
					}

$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center"><strong><em>Montant Bon d\'Achat : '.number_format(($bon->bon_montant), 0, ',', ' ').' FCFA</em></strong></td>
  </tr>
  <tr>
    <td align="left"><em><strong>Libellé</strong></em></td>
    <td align="center"><strong><em>Proposition</em></strong></td>
    <td align="center"><strong><em>Salaire</em></strong></td>
    <td align="center"><em><strong>Montant</strong></em></td>
  </tr>';
  
$htmlpdf .= '
  <tr style="background-color:#999;">
    <td align="left"><em><strong>Souscription au Bon d\'Achat </strong></em></td>
    <td align="center"><em>-</em></td>
    <td align="center"><em>-</em></td>
    <td align="center"><em>'.number_format(($bon->bon_montant), 0, ',', ' ').'</em></td>
  </tr>';

$htmlpdf .= '
  <tr>
    <td colspan="2" align="left"><em><u>Montant en  lettres </u>: '.lettre(($bon->bon_montant), 50).' CFA</em></td>
    <td colspan="2" align="left">Date : '.datefr($bon->bon_date).'</td>
  </tr>';	  
  
$htmlpdf .= '
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$htmlpdf .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/achats.html';
$somecontent = $htmlpdf;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("../../webfiles/pdf_achat/")) {
mkdir("../../webfiles/pdf_achat/", 0777);
}
/*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

$newfile = "../../webfiles/pdf_achat/BONACHAT_".str_replace("/", "_", mettreaccents($bon->bon_id))."_.html";
$newnom = "BONACHAT_".str_replace("/", "_", mettreaccents($bon->bon_id)."_");
$newchemin = "../../webfiles/pdf_achat/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';
$filena	= $newnom.'.pdf';

unlink($newfile);

	
		$this->_redirect(str_replace("../../webfiles/", "http://webfiles.gacsource.net/", $file));








		}

		//$this->_redirect('/bonachat/listbonachat');
	}


	public function testAction()
	{
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		




	}


	
}

