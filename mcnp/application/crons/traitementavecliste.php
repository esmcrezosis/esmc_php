#!/usr/bin/php
<?php 
include 'BootstrapCron.php';
//include 'utils.php';

    $db = Zend_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try {
        ini_set('memory_limit', '512M');    
        $place = new Application_Model_EuOperation();
        $mapper = new Application_Model_EuOperationMapper();
        $membre  = new Application_Model_EuMembre();
        $m_map    = new Application_Model_EuMembreMapper();
        $membremoral = new Application_Model_EuMembreMorale();
        $m_mapmoral  = new Application_Model_EuMembreMoraleMapper();
     
        $m_caps = new Application_Model_EuCapsMapper();
        $caps   = new Application_Model_EuCaps();
     
        $mstiersliste = new Application_Model_EuMstiersListecm();
        $m_mstiersliste = new Application_Model_EuMstiersListecmMapper();
		
		$mstierslistebc = new Application_Model_EuMstiersListebc();
        $m_mstierslistebc = new Application_Model_EuMstiersListebcMapper();
     
        $mstiers   = new Application_Model_EuMstiers();
        $m_mstiers = new Application_Model_EuMstiersMapper();
     
        $mstiersutilise   = new Application_Model_EuMstiersUtilise();
        $m_mstiersutilise = new Application_Model_EuMstiersUtiliseMapper();
     
        $activation   = new Application_Model_EuActivation();
        $m_activation = new Application_Model_EuActivationMapper();
     
        $compte_map = new Application_Model_EuCompteMapper();
        $compte      = new Application_Model_EuCompte();
     
        $sms_money   = new Application_Model_EuSmsmoney();
        $money_map   = new Application_Model_EuSmsmoneyMapper();
     
        $det_sms   = new Application_Model_EuDetailSmsmoney();
        $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
      
        $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
        $det_vtesms  = new Application_Model_EuDetailVentesms();
               
        $telephone = new Application_Model_EuTelephone();
        $m_telephone = new Application_Model_EuTelephoneMapper();
     
        $fs = Util_Utils::getParametre('FS','valeur');
        $mont_fl = Util_Utils::getParametre('FL','valeur');
        $fkps = Util_Utils::getParametre('FKPS','valeur');
          
        $id_utilisateur_acnev = 1;
        $id_utilisateur_filiere = 2;
        $id_utilisateur_technopole = 3;
          
        $place = new Application_Model_EuOperation();
        $mapper = new Application_Model_EuOperationMapper();

        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
        $date_deb = clone $date_fin;
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;
     
        $type_bnp  = 'CAPS';
        $type_caps = 'CAPSFLFCPS';
        $apporteur = "";
        $i = 0;
        $mont_caps = floor(Util_Utils::getParametre('CAPS','valeur'));
        $code_caps = '';
        $lignesbeneficiaire = $m_mstiersliste->fetchAllBeneficiaireAvecListe();
     
        $membre_pbf = '0000000000000000001M';
        $code_compte_pbf = "NN-TR-".$membre_pbf;
        $ret = $compte_map->find($code_compte_pbf,$compte);
       
        if(($lignesbeneficiaire != NULL) && (count($lignesbeneficiaire) > 0)) {
            $nbre_lignesbeneficiaire = count($lignesbeneficiaire);
            while($i < $nbre_lignesbeneficiaire)  {
                $lignebeneficiaire = $lignesbeneficiaire[$i];
                $apporteur = $lignebeneficiaire->getCode_membre_apporteur();
                $code_caps = $type_bnp.$apporteur.$date_deb->toString('yyyyMMddHHmmss');
         
                $lignesmstiers = $m_mstiers->fetchAllMstiersAvecListe($apporteur);
                $cumulsolde = $m_mstiers->findcumulMstiersAvecListe($apporteur);
         
                $lignesdetfcaps = $det_sms_m->findSMSByCompte($membre_pbf,'CAPS');
                $cumulfcaps = $det_sms_m->getSumByProduit($membre_pbf,'CAPS');
      
                $reste = $mont_caps;
                $j = 0;
                if(($lignesmstiers != false) && ($cumulsolde >= $mont_caps) && ($lignesdetfcaps != null) && ($cumulfcaps >= $mont_caps))  {
                    $nbre_lignesmstiers = count($lignesmstiers);         
                    while($reste > 0 && $j < $nbre_lignesmstiers) {
                        $lignemstiers = $lignesmstiers[$i];
                        $id = $lignemstiers->getId_mstiers();
                        if($reste > $lignemstiers->getMontant_restant()) {
                            //Enregistrement dans la table eu_mstiers_utilise
                            $mstiers_u = new Application_Model_EuMstiersUtilise();
                            $count = $m_mstiersutilise->findConuter() + 1;

                            $mstiers_u->setId_mstiers_utilise($count);
                            $mstiers_u->setId_mstiers($id);
                            $mstiers_u->setCode_caps($code_caps);
                            $mstiers_u->setCode_bnp(null);
                            $mstiers_u->setMontant_utilise($lignemstiers->getMontant_restant());
                            $mstiers_u->setDate_mstiers_utilise($date->toString('yyyy-MM-dd HH:mm:ss'));
                            $m_mstiersutilise->save($mstiers_u);

                            // Mise à jour de la table eu_mstiers
                            $reste = $reste - $lignemstiers->getMontant_restant();
                            $lignemstiers->setMontant_utilise($lignemstiers->getMontant_utilise() + $lignemstiers->getMontant_restant());
                            $lignemstiers->setMontant_restant(0);
                            $m_mstiers->update($lignemstiers);
           
                        } else {
                            //Enregistrement dans la table eu_mstiers_utilise
                            $mstiers_u = new Application_Model_EuMstiersUtilise();
                            $count = $m_mstiersutilise->findConuter() + 1;
                
                            $mstiers_u->setId_mstiers_utilise($count);
                            $mstiers_u->setId_mstiers($id);
                            $mstiers_u->setCode_caps($code_caps);
                            $mstiers_u->setCode_bnp(null);
                            $mstiers_u->setMontant_utilise($reste);
                            $mstiers_u->setDate_mstiers_utilise($date->toString('yyyy-MM-dd HH:mm:ss'));
                            $m_mstiersutilise->save($mstiers_u);
                 
                            // Mise à jour de la table eu_mstiers
                            $lignemstiers->setMontant_utilise($lignemstiers->getMontant_utilise() + $reste);
                            $lignemstiers->setMontant_restant($lignemstiers->getMontant_restant() - $reste);
                            $m_mstiers->update($lignemstiers);
                            $reste = 0;
                        }
                        $j++;
                    }
           
                    $id_operation = $mapper->findConuter() + 1;  
                    $place->setId_operation($id_operation)
                           ->setDate_op($date->toString('yyyy-MM-dd'))
                           ->setHeure_op($date->toString('HH:mm:ss'))
                           ->setId_utilisateur(null);
               
                    if(substr($apporteur,19,1)=='P') {
                        $place->setCode_membre($apporteur)
                              ->setCode_membre_morale(null);
                    } elseif(substr($apporteur,19,1)=='M') {
                        $place->setCode_membre(null)
                              ->setCode_membre_morale($apporteur);
                    }     
                     
                    $place->setMontant_op($mont_caps)
                          ->setCode_produit('CAPS')
                          ->setLib_op('Enrolement')
                          ->setType_op($type_bnp)
                          ->setCode_cat('TCAPS');
                    $mapper->save($place);
         
                    $code_agence = $lignebeneficiaire->getCode_agence();
                    $code = $m_map->getLastCodeMembreByAgence($code_agence);
                    if($code == null) {
                        $code = $code_agence . '0000001' . 'P';
                    } else {
                        $num_ordre = substr($code, 12, 7);
                        $num_ordre++;
                        $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                        $code = $code_agence . $num_ordre_bis . 'P';
                    }
         
                    //////////////// Mise à jour de eu_mstiers_listecm ///////////////////////////////////////////
                    $lignebeneficiaire->setCode_membre_beneficiaire($code);
                    $lignebeneficiaire->setCode_caps($code_caps);
					$lignebeneficiaire->setStatut(1);
                    $m_mstiersliste->update($lignebeneficiaire);
					
					
					/////// Insertion dans la table eu_mstiers_listebc ///////////////////////////////////////////
					$mstierslistebc_mapper = new Application_Model_EuMstiersListebcMapper();
                    $compteur_mstiers = $mstierslistebc_mapper->findConuter() + 1;
					
			        $mstierslistebc->setId_mstiers_listebc($compteur_mstiers)
					               ->setCode_membre_apporteur($apporteur)
						           ->setCode_membre_beneficiaire($code)
						           ->setCode_bnp(null)
						           ->setDate_listebc($date_idd->toString('yyyy-MM-dd HH:mm:ss'))
							       ->setStatut(0);
			        $m_mstierslistebc->save($mstierslistebc);
           
           
                    /////////////////////////////// preinscription ///////////////////////////////////////////////
                    $preinsc_mapper = new Application_Model_EuPreinscriptionMapper();
                    $compteur_preinscription = $preinsc_mapper->findConuter() + 1;
         
                    $preinscription = new Application_Model_EuPreinscription();
                    $mapper_pre = new Application_Model_EuPreinscriptionMapper();

                    $preinscription->setId_preinscription($compteur_preinscription)
                                    ->setNom_membre($lignebeneficiaire->getNom_membre())
                                    ->setCode_agence($code_agence)
                                    ->setPrenom_membre($lignebeneficiaire->getPrenom_membre())
                                    ->setSexe_membre($lignebeneficiaire->getSexe_membre())
                                    ->setDate_nais_membre($lignebeneficiaire->getDate_nais_membre())
                                    ->setId_pays($lignebeneficiaire->getId_pays())
                                    ->setLieu_nais_membre($lignebeneficiaire->getLieu_nais_membre())
                                    ->setPere_membre($lignebeneficiaire->getPere_membre())
                                    ->setMere_membre($lignebeneficiaire->getMere_membre())
                                    ->setSitfam_membre($lignebeneficiaire->getSitfam_membre())
                                    ->setNbr_enf_membre($lignebeneficiaire->getNbr_enf_membre())
                                    ->setProfession_membre($lignebeneficiaire->getProfession_membre())
                                    ->setFormation($lignebeneficiaire->getFormation())
                                    ->setId_religion_membre($lignebeneficiaire->getId_religion_membre())
                                    ->setQuartier_membre($lignebeneficiaire->getQuartier_membre())
                                    ->setVille_membre($lignebeneficiaire->getVille_membre())
                                    ->setBp_membre($lignebeneficiaire->getBp_membre())
                                    ->setTel_membre(null)
                                    ->setEmail_membre($lignebeneficiaire->getEmail_membre())
                                    ->setPortable_membre($lignebeneficiaire->getPortable_membre())
                                    ->setHeure_inscription($date_idd->toString('HH:mm:ss'))
                                    ->setDate_inscription($date_id->toString('yyyy-MM-dd'))
                                    ->setCode_membre(null)
                                    ->setCode_fs(null)
                                    ->setCode_fl(null)
                                    ->setCode_fkps(null)
                                    ->setId_canton($lignebeneficiaire->getId_canton());
                    $preinscription->setPublier(1);

                    $mapper_pre->save($preinscription);
         
                    ////// validation acnev ////////////////////////////////////////////
                    $validation_quittance = new Application_Model_EuValidationQuittance();
                    $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();

                    $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                    $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
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

                    $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                    $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
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

                    $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                    $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
                    $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_technopole);
                    $validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
                    $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                    $validation_quittance->setPublier(1);
                    $validation_quittance_mapper->save($validation_quittance);
         
                    //insertion dans la table eu_membre
                    $membre->setCode_membre($code)
                          ->setNom_membre($lignebeneficiaire->getNom_membre())
                          ->setPrenom_membre($lignebeneficiaire->getPrenom_membre())
                          ->setSexe_membre($lignebeneficiaire->getSexe_membre())
                          ->setDate_nais_membre($lignebeneficiaire->getDate_nais_membre())
                          ->setId_pays($lignebeneficiaire->getId_pays())
                          ->setLieu_nais_membre($lignebeneficiaire->getLieu_nais_membre())
                          ->setPere_membre($lignebeneficiaire->getPere_membre())
                          ->setMere_membre($lignebeneficiaire->getMere_membre())
                          ->setSitfam_membre($lignebeneficiaire->getSitfam_membre())
                          ->setNbr_enf_membre($lignebeneficiaire->getNbr_enf_membre())
                          ->setProfession_membre($lignebeneficiaire->getProfession_membre())
                          ->setFormation($lignebeneficiaire->getFormation())
                          ->setId_religion_membre($lignebeneficiaire->getId_religion_membre())
                          ->setQuartier_membre($lignebeneficiaire->getQuartier_membre())
                          ->setVille_membre($lignebeneficiaire->getVille_membre())
                          ->setBp_membre($lignebeneficiaire->getBp_membre())
                          ->setTel_membre(null)
                          ->setEmail_membre($lignebeneficiaire->getEmail_membre())
                          ->setPortable_membre($lignebeneficiaire->getPortable_membre())
                          ->setId_utilisateur(null)
                          ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                          ->setDate_identification($date_idd->toString('yyyy-MM-dd'))
                          ->setCode_agence($code_agence)
                          ->setId_maison(null)
                          ->setCodesecret(md5($lignebeneficiaire->getCodesecret()))
                          ->setEtat_membre('N')
                          ->setCode_gac(NULL)
                          ->setAuto_enroler('N')
                          ->setId_canton($lignebeneficiaire->getId_canton());
                    $m_map->save($membre);
           
                ////////////////////////////////////////////////////////////////////////////////
                $preinscription = new Application_Model_EuPreinscription();
                $preinscriptionM = new Application_Model_EuPreinscriptionMapper();
                $preinscriptionM->find($compteur_preinscription, $preinscription);

                $preinscription->setCode_membre($code);
                $preinscriptionM->update($preinscription);
         
                //insertion dans la table eu_activation
                $code_activation = strtoupper(Util_Utils::genererCodeSMS(8));
              
                $id_activation = $m_activation->findConuter() + 1;
                $activation->setId_activation($id_activation)
                           ->setId_depot(null)
                           ->setDate_activation($date_idd->toString('yyyy-MM-dd HH:mm:ss'))
                           ->setCode_activation($code_activation)
                           ->setCode_membre($code)
                           ->setMembreasso_id($lignebeneficiaire->getUtilisateur());
                $m_activation->save($activation);
           
            // Mise à jour de la table eu_telephone
            $lignestelephone = $m_telephone->fetchAllByInscrit($lignebeneficiaire->getId_mstiers_listecm());
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

            // etape des transferts
            $nengfcaps = $money_map->findConuter() + 1;
            $sms_money->setNEng($nengfcaps)
                      ->setCode_Agence(null)
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
                      ->setDestAccount_Consumed('CAPS-'.$code)
                      ->setDatetimeConsumed($date->toString('yyyy-MM-dd HH:mm:ss'))
                      ->setNum_recu(null);
            $money_map->save($sms_money);
          
            // Mise à jour du compte de transfert
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
                    $id_detail_vtsms = $det_vtesms->findConuter() + 1; 
                    $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
                               ->setId_detail_smsmoney($id)
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
                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;  
                    $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
                               ->setId_detail_smsmoney($id)
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
          
            $userin = new Application_Model_EuUtilisateur();
            $mapper_user = new Application_Model_EuUtilisateurMapper();

            //insertion dans la table eu_utilisateur
                    $id_user = $mapper_user->findConuter() + 1;
                    $userin->setId_utilisateur($id_user)
                           ->setId_utilisateur_parent(null)
                           ->setPrenom_utilisateur($lignebeneficiaire->getPrenom_membre())
                           ->setNom_utilisateur($lignebeneficiaire->getNom_membre())
                           ->setLogin($code)
                           ->setPwd(md5($lignebeneficiaire->getCodesecret()))
                           ->setDescription(null)
                           ->setUlock(0)
                           ->setCh_pwd_flog(0)
                           ->setCode_groupe('personne_physique')
                           ->setCode_groupe_create('personne_physique')
                           ->setConnecte(0)
                           ->setCode_agence($code_agence)
                           ->setCode_secteur(null)
                           ->setCode_zone($lignebeneficiaire->getCode_zone())
                       ->setId_pays($lignebeneficiaire->getId_pays())
                           ->setId_canton($lignebeneficiaire->getId_canton())
                           ->setCode_acteur(null)
                   ->setCode_membre($code);
                     $mapper_user->save($userin);

            // Mise à jour de la table eu_contrat
            $contrat = new Application_Model_EuContrat();
            $mapper_contrat = new Application_Model_EuContratMapper();
            $id_contrat = $mapper_contrat->findConuter() + 1;
            $contrat->setId_contrat($id_contrat);
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

            // insertion dans eu_fs
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
            $compteur = $mapper_op->findConuter() + 1;
            $lib_op = 'Enrolement';
            $type_op = 'ERL';
            Util_Utils::addOperation($compteur,$code,null,'TFS',$fs,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'),null);

            $carte = new Application_Model_EuCartes();
            $t_carte = new Application_Model_DbTable_EuCartes();
            $compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
            
            $caps->setCode_caps($code_caps)
                 ->setCode_membre_benef($code)
                 ->setMont_caps($mont_caps)
                 ->setMont_fs(0)
                 ->setPeriode(0)
                 ->setId_operation($id_operation)
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
                 ->setDate_caps($date_idd->toString('yyyy-MM-dd'))
                 ->setId_utilisateur(null)
                 ->setNature(1);
               
            if(substr($apporteur,19,1)=='P') {
                $caps->setCode_membre_app($apporteur)
                     ->setCode_membre_morale_app(null);
            } elseif(substr($apporteur,19,1)=='M')  {
                $caps->setCode_membre_app(null)
                     ->setCode_membre_morale_app($apporteur);
            }
            $m_caps->save($caps);


            $tfl = new Application_Model_DbTable_EuFl();
            $fl = new Application_Model_EuFl();
            $mapper_op = new Application_Model_EuOperationMapper();
            $compteur = $mapper_op->findConuter() + 1;

            // insertion dans la table eu_operation
            Util_Utils::addOperation($compteur,$code,null,null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),null);

            // insertion dans la table eu_fl
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
                    // insertion dans la table eu_compte
                    $compte->setCode_cat($tcartes[$m])
                           ->setCode_compte($code_compte)
                           ->setCode_membre($code)
                           ->setCode_membre_morale(null)
                           ->setCode_type_compte($type_carte)
                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                           ->setDesactiver(0)
                           ->setLib_compte($tcartes[$m])
                           ->setSolde(0);
                    $map_compte->save($compte);

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
                    // insertion dans la table eu_compte
                    $compte->setCode_cat($tscartes[$n])
                           ->setCode_compte($code_comptets)
                           ->setCode_membre($code)
                           ->setCode_membre_morale(null)
                           ->setCode_type_compte($type_carte)
                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                           ->setDesactiver(0)
                           ->setLib_compte($tscartes[$n])
                           ->setSolde(0);
                    $map_compte->save($compte);

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

            // insertion dans la table eu_carte
            $id_demande = $carte->findConuter() + 1;
            $carte->setId_demande($id_demande)
                  ->setCode_cat(null)
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
            $countop = $mapper_op->findConuter() + 1;
            Util_Utils::addOperation($countop,$code,null,null,$fkps,null,'Frais de CPS','CPS',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),null);

            $compt1 = Util_Utils::findConuter() + 1;
            Util_Utils::addSms3Easys($compt1,$lignebeneficiaire->getPortable_membre(),"Bienvenue dans le reseau ESMC !!!  Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $lignebeneficiaire->getCodesecret());  
            $db->commit();
            //$sessionmembreasso->errorlogin = "Ouverture de compte marchand bien effectuée";            
           
            }
            $i++;
        }
       
    }
   
 } catch (Exception $e) {
    // Gestion de l'exception.
    print "Une erreur est survenue \n";
    flush();
 }