<?php 
    include 'BootstrapCron.php';
    //include 'utils.php';
    ini_set('memory_limit','10249999999999M');
	$db = Zend_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
	try {
	    $fs = Util_Utils::getParametre('FS','valeur');
        $mont_fl = Util_Utils::getParametre('FL','valeur');
        $fkps = Util_Utils::getParametre('FKPS','valeur');
			
	    $id_utilisateur_acnev = 1;
        $id_utilisateur_filiere = 2;
        $id_utilisateur_technopole = 3;
				
	    $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
        $date_deb = clone $date_fin;
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;
				
	    $type_bnp  = 'CAPS';
        $type_caps = 'CAPSFLFCPS';
        $i = 0;
	    //$j = 0;
        $mont_caps = floor(Util_Utils::getParametre('CAPS','valeur'));
        $code_caps = "";
			
		$membre_pbf = '0000000000000000001M';
        $code_compte_pbf = "NN-TR-".$membre_pbf;
            
        $reste = $mont_caps;
    
        $code_activation  = '';
        $id_membretiers  = '';
               
        $id_depot = '';
        $souscription_id = '';
        $apporteur = '';

        $m_mstiersliste = new Application_Model_EuMstiersListecmMapper();
        $lignesbeneficiaire = $m_mstiersliste->fetchAllBeneficiaireAvecListe();
		
		if(($lignesbeneficiaire != NULL) && (count($lignesbeneficiaire) > 0)) {
			$nbre_lignesbeneficiaire = count($lignesbeneficiaire);
			while($i < 110) {
			    $compte_map = new Application_Model_EuCompteMapper();
                $compte = new Application_Model_EuCompte();
                $ret = $compte_map->find($code_compte_pbf,$compte);
				    
			    $place = new Application_Model_EuOperation();
                $mapper = new Application_Model_EuOperationMapper();
                $membre  = new Application_Model_EuMembre();
                $m_map    = new Application_Model_EuMembreMapper();
                $membremoral = new Application_Model_EuMembreMorale();
                $m_mapmoral  = new Application_Model_EuMembreMoraleMapper();
				
				$dvente   = new Application_Model_EuDepotVente();
                $m_dvente = new Application_Model_EuDepotVenteMapper();
				
			    $allocation_cmfh    = new Application_Model_EuAllocationCmfh();
                $m_allocation_cmfh  = new Application_Model_EuAllocationCmfhMapper();
					
			    $m_caps = new Application_Model_EuCapsMapper();
                $caps   = new Application_Model_EuCaps();
     
                $mstiersliste = new Application_Model_EuMstiersListecm();
                $m_mstiersliste = new Application_Model_EuMstiersListecmMapper();

                $activation   = new Application_Model_EuActivation();
                $m_activation = new Application_Model_EuActivationMapper();
                $membretiers  = new Application_Model_EuMembretierscode();
                $m_membretiers = new Application_Model_EuMembretierscodeMapper();
    
                $souscription = new Application_Model_EuSouscription();
                $souscription_mapper = new Application_Model_EuSouscriptionMapper();
					
			    $map_compte = new Application_Model_EuCompteMapper();
                $compte     = new Application_Model_EuCompte();
     
                $sms_money   = new Application_Model_EuSmsmoney();
                $money_map   = new Application_Model_EuSmsmoneyMapper();
     
                $det_sms   = new Application_Model_EuDetailSmsmoney();
                $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
      
                $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
                $det_vtesms  = new Application_Model_EuDetailVentesms();
               
                $telephone = new Application_Model_EuTelephone();
                $m_telephone = new Application_Model_EuTelephoneMapper();
					
			    $lignebeneficiaire = $lignesbeneficiaire[$i];
                $lignesdetfcaps = $det_sms_m->findSMSByCompte($membre_pbf,'CAPS');
                $cumulfcaps = $det_sms_m->getSumByProduit($membre_pbf,'CAPS');
				
				if(($lignebeneficiaire->code_agence != NULL)) {
				
				///////////////// controle nom prenom dans eu_membre ////////////////////////////
				$prenom_benef = $lignebeneficiaire->prenom_membre;
				$prenom_benef = str_replace("'", " ", $prenom_benef);
				$tabprenom = explode(" ",$prenom_benef);
					
				$nom_benef = $lignebeneficiaire->nom_membre;
				$nom_benef = str_replace("'", " ", $nom_benef);
					
				$eumembre = new Application_Model_DbTable_EuMembre();
				$selection = $eumembre->select();
				$selection->where("LOWER(REPLACE(nom_membre, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "",$nom_benef)));
					
                foreach($tabprenom as $value) {
	                $selection->where("LOWER(REPLACE(prenom_membre, ' ', '')) LIKE '%".strtolower(str_replace(" ", "",$value))."%' ");
				}	
				$selection->where("LOWER(REPLACE(date_nais_membre, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "", $lignebeneficiaire->date_nais_membre)));
	            $selection->where("LOWER(REPLACE(lieu_nais_membre, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "", $lignebeneficiaire->lieu_nais_membre)));
	            $selection->limit(1);
	            $rowseumembre = $eumembre->fetchRow($selection);
				
				if(count($rowseumembre) > 0) {
					$lignebeneficiaire->setDoublon(1);
                    $m_mstiersliste->update($lignebeneficiaire);
				}
				
				$j = 0;
				$apporteur = $lignebeneficiaire->getCode_membre_apporteur();
				$lignesdvente = $m_dvente->fetchAllCmfhAvecListe($apporteur);
				
				if($lignesdvente == NULL) {
					$lignebeneficiaire->setStatut(2);
                    $m_mstiersliste->update($lignebeneficiaire);
				}
				
				if($lignesdvente != NULL) {
					$lignedvente = $lignesdvente[$j];
				    while(($j < count($lignesdvente)) && ($lignedvente->getSolde_depot() < $mont_caps)) {
					    $lignedvente = $lignesdvente[$j+1];
				        $j++;
				    }
				    $id_depot = $lignedvente->getId_depot();
                    $apporteur = $lignedvente->getCode_membre();
                    $souscription_id = $lignedvente->getSouscription_id();
                    $finddepotvente = $m_dvente->find($id_depot,$dvente);
                    $findCodesBySous = $m_membretiers->findBySouscription($souscription_id);
				
				    while(($findCodesBySous == NULL) && ($j < count($lignesdvente))) {
					    $lignedvente = $lignesdvente[$j+1];
					    $id_depot = $lignedvente->getId_depot();
                        $apporteur = $lignedvente->getCode_membre();
                        $souscription_id = $lignedvente->getSouscription_id();
                        $finddepotvente = $m_dvente->find($id_depot,$dvente);
                        $findCodesBySous = $m_membretiers->findBySouscription($souscription_id);
				        $j++;
				    }
				
				    if((count($rowseumembre) <= 0) && ($finddepotvente) && ($findCodesBySous != NULL) && ($lignesdetfcaps != null) && ($cumulfcaps >= $mont_caps) && ($lignedvente->getSolde_depot() >= $mont_caps) && ($lignebeneficiaire->code_agence != NULL)) {
				
				        $findCodeBySous = $findCodesBySous[0];
                        $id_membretiers = $findCodeBySous->getMembretierscode_id();
                        $code_activation = $findCodeBySous->getMembretierscode_code();
            
                        $lignedvente->setSolde_depot($lignedvente->getSolde_depot() - $reste);
                        $lignedvente->setMont_vendu($lignedvente->getMont_vendu() + $reste);
                        $m_dvente->update($lignedvente);
					
					    $place->setDate_op($date->toString('yyyy-MM-dd'))
                              ->setHeure_op($date->toString('HH:mm:ss'))
                              ->setId_utilisateur(null);

                        if(substr($apporteur,19,1)=='P') {
                            $place->setCode_membre($apporteur)
                                  ->setCode_membre_morale(null);
                        } else  {
                            $place->setCode_membre(null)
                                  ->setCode_membre_morale($apporteur);
                        }
                        $place->setMontant_op($mont_caps)
                              ->setCode_produit('CAPS')
                              ->setLib_op('Enrolement')
                              ->setType_op($type_bnp)
                              ->setCode_cat('TCAPS');
                        $mapper->save($place);
					    $count = $db->lastInsertId();
							
                        $code_agence = $lignebeneficiaire->code_agence;
					
					    $code = $m_map->getLastCodeMembreByAgence($code_agence);
                        if($code == null) {
                            $code = $code_agence . '0000001' . 'P';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'P';
                        }
					
					    $membrephysique    = new Application_Model_EuMembre();
	                    $m_membrephysique  = new Application_Model_EuMembreMapper();
					
					    $findmembrephysique = $m_membrephysique->find($code,$membrephysique);
					    while($findmembrephysique != false) {
					        $code = $m_map->getLastCodeMembreByAgence($code_agence);
                            if($code == null) {
                                $code = $code_agence . '0000001' . 'P';
                            } else {
                                $num_ordre = substr($code, 12, 7);
                                $num_ordre++;
                                $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                                $code = $code_agence . $num_ordre_bis . 'P';
                            }
						    $findmembrephysique = $m_membrephysique->find($code,$membrephysique);
					    }
					
					    /////////////////////////////// preinscription ///////////////////////////////////////////////
                        $preinsc_mapper = new Application_Model_EuPreinscriptionMapper();
                        //$compteur_preinscription = $preinsc_mapper->findConuter() + 1;
         
                        $preinscription = new Application_Model_EuPreinscription();
                        $mapper_pre = new Application_Model_EuPreinscriptionMapper();

                        //$preinscription->setId_preinscription($compteur_preinscription)
                        $preinscription->setNom_membre($lignebeneficiaire->nom_membre)
                                   ->setCode_agence($code_agence)
                                   ->setPrenom_membre($lignebeneficiaire->prenom_membre)
                                   ->setSexe_membre($lignebeneficiaire->sexe_membre)
                                   ->setDate_nais_membre($lignebeneficiaire->date_nais_membre)
                                   ->setId_pays($lignebeneficiaire->id_pays)
                                   ->setLieu_nais_membre($lignebeneficiaire->lieu_nais_membre)
                                   ->setPere_membre($lignebeneficiaire->pere_membre)
                                   ->setMere_membre($lignebeneficiaire->mere_membre)
                                   ->setSitfam_membre($lignebeneficiaire->sitfam_membre)
                                   ->setNbr_enf_membre($lignebeneficiaire->nbr_enf_membre)
                                   ->setProfession_membre($lignebeneficiaire->profession_membre)
                                   ->setFormation($lignebeneficiaire->formation)
                                   ->setId_religion_membre($lignebeneficiaire->id_religion_membre)
                                   ->setQuartier_membre($lignebeneficiaire->quartier_membre)
                                   ->setVille_membre($lignebeneficiaire->ville_membre)
                                   ->setBp_membre($lignebeneficiaire->bp_membre)
                                   ->setTel_membre(null)
                                   ->setEmail_membre($lignebeneficiaire->email_membre)
                                   ->setPortable_membre($lignebeneficiaire->portable_membre)
                                   ->setHeure_inscription($date_idd->toString('HH:mm:ss'))
                                   ->setDate_inscription($date_id->toString('yyyy-MM-dd'))
                                   ->setCode_membre(null)
                                   ->setCode_fs(null)
                                   ->setCode_fl(null)
                                   ->setCode_fkps(null)
                                   ->setId_canton($lignebeneficiaire->id_canton);
                        $preinscription->setPublier(0);

                        $mapper_pre->save($preinscription);
					    $compteur_preinscription = $db->lastInsertId();
						
				        ////// validation acnev ///////////////////////////////////////
                        $preinscription = new Application_Model_EuPreinscription();
                        $preinscriptionM = new Application_Model_EuPreinscriptionMapper();
                        $preinscriptionM->find($compteur_preinscription, $preinscription);

                        $preinscription->setPublier(1);
                        $preinscriptionM->update($preinscription); 
      
                        $validation_quittance = new Application_Model_EuValidationQuittance();
                        $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();

                        //$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                        //$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);

                        $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_acnev);
                        $validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
                        $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                        $validation_quittance->setPublier(1);
                        $validation_quittance_mapper->save($validation_quittance);
               
               
                        ////// validation filere ///////////////////////////////////
                        $preinscription = new Application_Model_EuPreinscription();
                        $preinscriptionM = new Application_Model_EuPreinscriptionMapper();
                        $preinscriptionM->find($compteur_preinscription, $preinscription);

                        $preinscription->setPublier(2);
                        $preinscriptionM->update($preinscription);


                        $validation_quittance = new Application_Model_EuValidationQuittance();
                        $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();

                        //$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                        //$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);

                        $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_filiere);
                        $validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
                        $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                        $validation_quittance->setPublier(1);
                        $validation_quittance_mapper->save($validation_quittance);
               
               
                        ////// validation technopole ////////////////////////////////////////////////////////////////////
                        $preinscription = new Application_Model_EuPreinscription();
                        $preinscriptionM = new Application_Model_EuPreinscriptionMapper();
                        $preinscriptionM->find($compteur_preinscription, $preinscription);

                        $preinscription->setPublier(3);
                        $preinscriptionM->update($preinscription);


                        $validation_quittance = new Application_Model_EuValidationQuittance();
                        $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();

                        //$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                        //$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);

                        $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_technopole);
                        $validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
                        $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                        $validation_quittance->setPublier(1);
                        $validation_quittance_mapper->save($validation_quittance);
					
					
					    //insertion dans la table eu_membre
                        $membre->setCode_membre($code)
                           ->setNom_membre($lignebeneficiaire->nom_membre)
                           ->setPrenom_membre($lignebeneficiaire->prenom_membre)
                           ->setSexe_membre($lignebeneficiaire->sexe_membre)
                           ->setDate_nais_membre($lignebeneficiaire->date_nais_membre)
                           ->setId_pays($lignebeneficiaire->id_pays)
                           ->setLieu_nais_membre($lignebeneficiaire->lieu_nais_membre)
                           ->setPere_membre($lignebeneficiaire->pere_membre)
                           ->setMere_membre($lignebeneficiaire->mere_membre)
                           ->setSitfam_membre($lignebeneficiaire->sitfam_membre)
                           ->setNbr_enf_membre($lignebeneficiaire->nbr_enf_membre)
                           ->setProfession_membre($lignebeneficiaire->profession_membre)
                           ->setFormation($lignebeneficiaire->formation)
                           ->setId_religion_membre($lignebeneficiaire->id_religion_membre)
                           ->setQuartier_membre($lignebeneficiaire->quartier_membre)
                           ->setVille_membre($lignebeneficiaire->ville_membre)
                           ->setBp_membre($lignebeneficiaire->bp_membre)
                           ->setTel_membre(null)
                           ->setEmail_membre($lignebeneficiaire->email_membre)
                           ->setPortable_membre($lignebeneficiaire->portable_membre)
                           ->setId_utilisateur(null)
                           ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                           ->setDate_identification($date_idd->toString('yyyy-MM-dd'))
                           ->setCode_agence($code_agence)
                           ->setId_maison(null)
                           ->setCodesecret(md5($lignebeneficiaire->codesecret))
                           ->setEtat_membre('N')
                           ->setCode_gac(NULL)
						   ->setDesactiver(2)
                           ->setAuto_enroler('N')
                           ->setId_canton($lignebeneficiaire->id_canton);
                        $m_map->save($membre);
					
					
					    ////////////////////////////////////////////////////////////////////////////////
                        $preinscription = new Application_Model_EuPreinscription();
                        $preinscriptionM = new Application_Model_EuPreinscriptionMapper();
                        $preinscriptionM->find($compteur_preinscription, $preinscription);

                        $preinscription->setCode_membre($code);
                        $preinscriptionM->update($preinscription);
            
            
                        //$id_activation = $m_activation->findConuter() + 1;
                        //$activation->setId_activation($id_activation)
					
                        $activation->setId_depot($id_depot)
                                   ->setDate_activation($date_idd->toString('yyyy-MM-dd HH:mm:ss'))
                                   ->setCode_activation($code_activation)
                                   ->setCode_membre($code)
                                   ->setMembreasso_id($lignebeneficiaire->utilisateur);
                        $m_activation->save($activation);
						
				        $findmembretiers = $m_membretiers->find($id_membretiers,$membretiers);
			            if($findmembretiers) {
			                $membretiers->setCode_membre($code)
							        ->setPublier(1)
									->setAllocation_cmfh_id(null);
				            $m_membretiers->update($membretiers);
		                }
					
					    $code_caps = $type_bnp . $code . $date_deb->toString('yyyyMMddHHmmss');
				        //////////////// Mise à jour de eu_mstiers_listecm ///////////////////////////////////////////
                        $lignebeneficiaire->setCode_membre_beneficiaire($code);
                        $lignebeneficiaire->setStatut(1);
                        $lignebeneficiaire->setCode_caps($code_caps);
                        $m_mstiersliste->update($lignebeneficiaire);
					
					
					    // Mise à jour de la table eu_telephone
                        $lignestelephone = $m_telephone->fetchAllByInscrit($lignebeneficiaire->id_mstiers_listecm);
                        $t = 0;
                        if($lignestelephone != false)  {
                            $nbre_lignestelephone = count($lignestelephone);
                            while($t < $nbre_lignestelephone) {            
                                $lignetelephone = $lignestelephone[$t];
                                $lignetelephone->setCode_membre($code);
                                $m_telephone->update($lignetelephone);
                                $t++;
                            }
                        }
            
                        $findsmsmoney = $money_map->findBySouscription($souscription_id);
                        $souscription_mapper->find($souscription_id,$souscription);
					
					    if($findsmsmoney == NULL && $souscription->souscription_type == 'BAn') {
				            //$nengfcaps = $money_map->findConuter() + 1;
                            //$sms_money->setNEng($nengfcaps)
                            $sms_money->setCode_Agence(null)
                                  ->setCreditAmount($mont_caps)
                                  ->setSentTo($lignebeneficiaire->getPortable_membre())
                                  ->setMotif('CAPS')
                                  ->setId_Utilisateur(null)
                                  ->setCurrencyCode('XOF')
                                  ->setDatetime($date->toString('yyyy-MM-dd HH:mm:ss'))
                                  ->setFromAccount($code_compte_pbf)
                                  ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                  ->setCreditCode($code_activation)
                                  ->setDestAccount(null)
                                  ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/MM/yyyy')))
                                  ->setDestAccount_Consumed($souscription_id)
                                  ->setDatetimeConsumed($date->toString('yyyy-MM-dd HH:mm:ss'))
                                  ->setNum_recu(null);
                            $money_map->save($sms_money);
						
						    //Mise à jour du compte de transfert
                            $compte->setSolde($compte->getSolde() - $mont_caps);
                            $compte_map->update($compte);
              
                            $l = 0;
                            $valeur_restant = $mont_caps;
                            $nbre_lignesdetfcaps = count($lignesdetfcaps);
                            while($valeur_restant > 0 && $l < $nbre_lignesdetfcaps) {
                                $lignedetfcaps = $lignesdetfcaps[$l];
                                $id = $lignedetfcaps->getId_detail_smsmoney();
                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
            
                                if($valeur_restant >= $lignedetfcaps->getSolde_sms()) {
                                    //Mise à jour  des lignes d'enrégistrement
                                    $valeur_restant = $valeur_restant - $lignedetfcaps->getSolde_sms();
                                    //insertion dans la table eu_detailventesms
                                    //$id_detail_vtsms = $det_vtesms->findConuter() + 1; 
                                    //$det_vtesms->setId_detail_vtsms($id_detail_vtsms)
								
                                    $det_vtesms->setId_detail_smsmoney($id)
                                           ->setCode_membre_dist($membre_pbf)
                                           ->setCode_membre(null)
                                           ->setType_tansfert('CAPS')
                                           ->setCreditcode($code_activation)
                                           ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                           ->setMont_vente($lignedetfcaps->getSolde_sms())
                                           ->setId_utilisateur(null)
                                           ->setCode_produit('CAPS');
                                    $det_vte_sms->insert($det_vtesms->toArray());
                              
                                    $lignedetfcaps->setMont_vendu($lignedetfcaps->getMont_vendu() + $lignedetfcaps->getSolde_sms())
                                              ->setMont_regle($lignedetfcaps->getMont_regle() + $lignedetfcaps->getSolde_sms())
                                              ->setSolde_sms(0);
                                    $det_sms_m->update($lignedetfcaps);
          
                                } else {
                                    //Mise à jour des lignes d'enrégistrement
                                    //insertion dans la table eu_detailventesms
                                    //$id_detail_vtsms = $det_vtesms->findConuter() + 1;  
                                    //$det_vtesms->setId_detail_vtsms($id_detail_vtsms)
								
                                    $det_vtesms->setId_detail_smsmoney($id)
                                               ->setCode_membre_dist($membre_pbf)
                                               ->setCode_membre(null)
                                               ->setType_tansfert('CAPS')
                                               ->setCreditcode($code_activation)
                                               ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                               ->setMont_vente($valeur_restant)
                                               ->setId_utilisateur(null)
                                               ->setCode_produit('CAPS');
                                    $det_vte_sms->insert($det_vtesms->toArray());
                              
                                    $lignedetfcaps->setSolde_sms($lignedetfcaps->getSolde_sms() - $valeur_restant);
                                    $lignedetfcaps->setMont_vendu($lignedetfcaps->getMont_vendu() + $valeur_restant);
                                    $lignedetfcaps->setMont_regle($lignedetfcaps->getMont_regle() + $valeur_restant);
                                    $det_sms_m->update($lignedetfcaps);
                                    $valeur_restant = 0;
                                }
                                $l++;
                            }
				
				        }
					
					    $userin = new Application_Model_EuUtilisateur();
                        $mapper_user = new Application_Model_EuUtilisateurMapper();
          
                        //insertion dans la table eu_utilisateur
                        //$id_user = $mapper_user->findConuter() + 1;
                        //$userin->setId_utilisateur($id_user)
					
                        $userin->setId_utilisateur_parent(null)
                           ->setPrenom_utilisateur($lignebeneficiaire->prenom_membre)
                           ->setNom_utilisateur($lignebeneficiaire->nom_membre)
                           ->setLogin($code)
                           ->setPwd(md5($lignebeneficiaire->codesecret))
                           ->setDescription(null)
                           ->setUlock(0)
                           ->setCh_pwd_flog(0)
                           ->setCode_groupe('personne_physique')
                           ->setCode_groupe_create('personne_physique')
                           ->setConnecte(0)
                           ->setCode_agence($code_agence)
                           ->setCode_secteur(null)
                           ->setCode_zone($lignebeneficiaire->code_zone)
                           ->setId_pays($lignebeneficiaire->id_pays)
                           ->setId_canton($lignebeneficiaire->id_canton)
                           ->setCode_acteur(null)
                           ->setCode_membre($code);
                        $mapper_user->save($userin);
					
					
					    // Mise à jour de la table eu_contrat
                        $contrat = new Application_Model_EuContrat();
                        $mapper_contrat = new Application_Model_EuContratMapper();
                        //$id_contrat = $mapper_contrat->findConuter() + 1;
                        //$contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                        $contrat->setNature_contrat('numeraire');
                        $contrat->setId_type_contrat(null);
                        $contrat->setId_type_creneau(null);
                        $contrat->setId_type_acteur(null);
                        $contrat->setId_pays(null);
                        $contrat->setId_utilisateur(null);
                        $contrat->setFiliere(null);
                        $mapper_contrat->save($contrat);
					
					    //insertion dans eu_fs
                        $tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre($code)
                             ->setCode_membre_morale(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($code_activation)
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur(null)
                             ->setMont_fs($fs)
                             ->setOrigine_fs('N');
                        $tab_fs->insert($fs_model->toArray());
            
            
                        //insertion des frais d'identification dans la table operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteurfs = $mapper_op->findConuter() + 1;
                        $lib_op = 'Enrolement';
                        $type_op = 'ERL';
					
                        //Util_Utils::addOperation($compteurfs,$code,null,'TFS',$fs,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'),null);

					    $place->setDate_op($date_idd->toString('yyyy-MM-dd'));
                        $place->setHeure_op($date_idd->toString('HH:mm:ss'));
                        $place->setId_utilisateur(null);
                        $place->setCode_membre($code);
                        $place->setCode_membre_morale(null);
                        $place->setMontant_op($fs);
                        $place->setCode_produit('FS');
                        $place->setLib_op($lib_op);
                        $place->setType_op($type_op);
                        $place->setCode_cat('TFS');
                        $mapper_op->save($place);
					
					
                        $carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
                        $newcompte = new Application_Model_EuCompte();
                        $map_compte = new Application_Model_EuCompteMapper();
            
                        $caps->setCode_caps($code_caps)
                         ->setCode_membre_benef($code)
                         ->setMont_caps($mont_caps)
                         ->setMont_fs(0)
                         ->setPeriode(0)
                         ->setId_operation($count)
                         ->setRembourser('N')
                         ->setId_credit(null)
                         ->setIndexer(1)
                         ->setType_caps($type_caps)
                         ->setCode_type_bnp($type_bnp)
                         ->setFs_utiliser(1)
                         ->setFl_utiliser(1)
                         ->setCps_utiliser(1)
                         ->setMont_panu_fs(0)
                         ->setReconst_fs(0)
                         ->setPanu(0)
                         ->setDate_caps($date_idd->toString('yyyy-MM-dd HH:mm:ss'))
                         ->setId_utilisateur(null);

                        if(substr($apporteur,19,1)=='P') {
                            $caps->setCode_membre_app($apporteur)
                             ->setCode_membre_morale_app(null);
                        } else  {
                            $caps->setCode_membre_app(null)
                             ->setCode_membre_morale_app($apporteur);
                        }
                        $m_caps->save($caps);
            
                        $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteurfl = $mapper_op->findConuter() + 1;

                        //insertion dans la table eu_operation
                        //Util_Utils::addOperation($compteurfl,$code,null,null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),null);

					    $place->setDate_op($date_idd->toString('yyyy-MM-dd'));
                        $place->setHeure_op($date_idd->toString('HH:mm:ss'));
                        $place->setId_utilisateur(null);
                        $place->setCode_membre($code);
                        $place->setCode_membre_morale(null);
                        $place->setMontant_op($mont_fl);
                        $place->setCode_produit('FL');
                        $place->setLib_op('Frais de licences');
                        $place->setType_op(null);
                        $place->setCode_cat(null);
                        $mapper_op->save($place);
					
					
                        //insertion dans la table eu_fl
                        $fl->setCode_fl("FL-".$code)
                           ->setCode_membre($code)
                           ->setCode_membre_morale(null)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur(null)
                           ->setCreditcode($code_activation)
                           ->setOrigine_fl('N');
                        $tfl->insert($fl->toArray());
              
                        $tcartes[0]="TPAGCRPG";
                        $tcartes[1]="TCNCS";
                        $tcartes[2]="TPaNu";
                        $tcartes[3]="TPaR";
                        $tcartes[4]="TR";
                        $tcartes[5]="CAPA";

                        $tscartes[0]="TSRPG";
                        $tscartes[1]="TSCNCS";
                        $tscartes[2]="TSPaNu";
                        $tscartes[3]="TSPaR";
                        $tscartes[4]="TSCAPA";
						
						
				        for($m = 0; $m < count($tcartes); $m++) {
                            if($tcartes[$m] == "TCNCS") {
                              $code_compte = 'NR' . '-' . $tcartes[$m] . '-' . $code;
                              $type_carte = 'NR';
                              $res = $map_compte->find($code_compte,$compte);
                            } elseif($tcartes[$m] == "TR" || $tcartes[$m] == "CAPA" || $tcartes[$m] == "TRE") {
                              $code_compte = 'NN' . '-' . $tcartes[$m] . '-' . $code;
                              $type_carte = 'NN';
                              $res = $map_compte->find($code_compte,$compte);
                            } else {
                              $code_compte = 'NB' . '-' . $tcartes[$m] . '-' . $code;
                              $type_carte = 'NB';
                              $res = $map_compte->find($code_compte,$compte);
                            }
                            if(!$res) {
                                //insertion dans la table eu_compte
                                $newcompte->setCode_cat($tcartes[$m])
                                      ->setCode_compte($code_compte)
                                      ->setCode_membre($code)
                                      ->setCode_membre_morale(null)
                                      ->setCode_type_compte($type_carte)
                                      ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                      ->setDesactiver(0)
                                      ->setLib_compte($tcartes[$m])
                                      ->setSolde(0);
                                $map_compte->save($newcompte);
                            }
                        }
						
						
				        for($n = 0; $n < count($tscartes); $n++) {
                            if($tscartes[$n] == "TSCNCS") {
                                $code_comptets = 'NR' . '-' . $tscartes[$n] . '-' . $code;
                                $type_carte = 'NR';
                                $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$n] == "TR" || $tscartes[$n] == "TSCAPA" || $tscartes[$n] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$n] . '-' . $code;
                                $type_carte = 'NN';
                                $res = $map_compte->find($code_comptets,$compte);
                            } else  {
                                $code_comptets = 'NB' . '-' . $tscartes[$n] . '-' . $code;
                                $type_carte = 'NB';
                                $res = $map_compte->find($code_comptets,$compte);
                            }

                            if(!$res) {
                                //insertion dans la table eu_compte
                                $newcompte->setCode_cat($tscartes[$n])
                                      ->setCode_compte($code_comptets)
                                      ->setCode_membre($code)
                                      ->setCode_membre_morale(null)
                                      ->setCode_type_compte($type_carte)
                                      ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                      ->setDesactiver(0)
                                      ->setLib_compte($tscartes[$n])
                                      ->setSolde(0);
                                $map_compte->save($newcompte);

                            }
                        }
            
                        //Mise e jour du compte general fgfn
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if($result3) {
                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                            $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                ->setIntitule('Frais de licence')
                                ->setService('E')
                                ->setCode_type_compte('NN')
                                ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }

                        //insertion dans la table eu_carte
                        //$id_demande = $carte->findConuter() + 1;
                        //$carte->setId_demande($id_demande)
					
                        $carte->setCode_cat(null)
                          ->setCode_membre($code)
                          ->setMont_carte($fkps)
                          ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                          ->setLivrer(0)
                          ->setCode_Compte(null)
                          ->setImprimer(0)
                          ->setCardPrintedDate('')
                          ->setCardPrintedIDDate(0)
                          ->setId_utilisateur(null);
                        $t_carte->insert($carte->toArray());

                        $mapper_op = new Application_Model_EuOperationMapper();
                        $countopcarte = $mapper_op->findConuter() + 1;
                    
					    //Util_Utils::addOperation($countopcarte,$code,null,null,$fkps,null,'Frais de CPS','CPS',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),null);

                        $place->setDate_op($date_idd->toString('yyyy-MM-dd'));
                        $place->setHeure_op($date_idd->toString('HH:mm:ss'));
                        $place->setId_utilisateur(null);
                        $place->setCode_membre($code);
                        $place->setCode_membre_morale(null);
                        $place->setMontant_op($fkps);
                        $place->setCode_produit('CPS');
                        $place->setLib_op('Frais de CPS');
                        $place->setType_op(null);
                        $place->setCode_cat(null);
                        $mapper_op->save($place);


                        //////////////////////////////////////////
                        if($lignebeneficiaire->code_agence != "001001001001") {
                            $souscription = new Application_Model_EuSouscription();
                            $m_souscription = new Application_Model_EuSouscriptionMapper();
                            $m_souscription->find($souscription_id, $souscription);
        
                            $membreasso = new Application_Model_EuMembreasso();
                            $m_membreasso = new Application_Model_EuMembreassoMapper();
                            $m_membreasso->find($lignebeneficiaire->getUtilisateur(), $membreasso);

                            $association = new Application_Model_EuAssociation();
                            $m_association = new Application_Model_EuAssociationMapper();
                            $m_association->find($membreasso->membreasso_association, $association);
                            $code_agence = $association->code_agence;

                            if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL) {
                                if($souscription->souscription_programme == "KACM") {
                                    $partagea_montant = floor(Util_Utils::getParamEsmc(16));
                                } else {
                                    $partagea_montant = floor(Util_Utils::getParamEsmc(16));
                                }

                            } else {
                                if($souscription->souscription_programme == "KACM") {
                                    $partagea_montant = floor(Util_Utils::getParamEsmc(16));
                                } else {
                                    $partagea_montant = floor(Util_Utils::getParamEsmc(16));
                                }
                            }

                            //////////////////////////////////////////

                            $partagea = new Application_Model_EuPartagea();
                            $partagea_mapper = new Application_Model_EuPartageaMapper();

                            //$compteur_partagea = $partagea_mapper->findConuter() + 1;
                            //$partagea->setPartagea_id($compteur_partagea);
		
                            $partagea->setPartagea_association($membreasso->membreasso_association);
                            $partagea->setPartagea_souscription($souscription->souscription_id);
                            $partagea->setPartagea_montant($partagea_montant * 0.75);
                            $partagea->setPartagea_montant_utilise(0);
                            $partagea->setPartagea_montant_solde($partagea_montant * 0.75);
                            $partagea->setPartagea_montant_impot(0);
	                        $partagea->setPartagea_date($date_idd->toString('yyyy-MM-dd HH:mm:ss'));
                            $partagea->setPartagea_activation($m_activation->findConuter());
                            $partagea_mapper->save($partagea);

                            //////////////////////////////////////////

                            $partagem = new Application_Model_EuPartagem();
                            $partagem_mapper = new Application_Model_EuPartagemMapper();

                            //$compteur_partagem = $partagem_mapper->findConuter() + 1;
                            //$partagem->setPartagem_id($compteur_partagem);
		
                            $partagem->setPartagem_membreasso($membreasso->membreasso_id);
                            $partagem->setPartagem_souscription($souscription->souscription_id);
                            $partagem->setPartagem_montant($partagea_montant * 0.25);
                            $partagem->setPartagem_montant_utilise(0);
                            $partagem->setPartagem_montant_solde($partagea_montant * 0.25);
                            $partagem->setPartagem_montant_impot(0);
	                        $partagem->setPartagem_date($date_idd->toString('yyyy-MM-dd HH:mm:ss'));
                            $partagem->setPartagem_activation($m_activation->findConuter());
                            $partagem_mapper->save($partagem);
                            //////////////////////////////////////////
                        }
                        //////////////////////////////////////////
                        $compt1 = Util_Utils::findConuter() + 1;
                        Util_Utils::addSms3Easys($compt1,$lignebeneficiaire->portable_membre,"Bienvenue dans le reseau ESMC !!!  Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $lignebeneficiaire->codesecret);  
				    }
				
				}
				
			    }
			    $i++;
			}
			
			$db->commit();
            return;
		}
		
	}  catch(Exception $exc) {
        // Gestion de l'exception.
        //print "Une erreur est survenue \n";
        //flush();
		$db->rollback();
		$message = "Erreur d'éxécution : " . $exc->getMessage() . $exc->getTraceAsString();
		//$message = "";
		print $message." ______ ".$apporteur;
		flush();
		return;
    }