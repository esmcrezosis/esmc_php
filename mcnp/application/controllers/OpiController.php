<?php

class OpiController extends Zend_Controller_Action   {

	  public function init() {
		/* Initialize action controller here */
        include("Url.php");
	  }


	  public function newopiAction()  {
	     $sessionmembre = new Zend_Session_Namespace('membre');
		 //$this->_helper->layout->disableLayout();
		 $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		 }

		 $cm_mapper = new Application_Model_EuCompteMapper();
         $compte = new Application_Model_EuCompte();

		 $v_num_compte = 'NB-'.'TPAGCP-'.$sessionmembre->code_membre;
         $retour = $cm_mapper->find($v_num_compte,$compte);
         if ($retour) {
             $this->view->solde = $compte->getSolde();
         }

		 $tabela = new Application_Model_DbTable_EuTpagcp();
         $select = $tabela->select();
         $select->where('code_membre like ?',$sessionmembre->code_membre);
         $select->order('id_tpagcp desc');
         $achats = $tabela->fetchAll($select);
		 $this->view->achats = $achats;

		 $this->view->tabletri = 1;

		 //include("Transfert.php");
		 $request = $this->getRequest();
		 if ($request->isPost ())  {
		     $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
		         $compte = new Application_Model_EuCompte();
                 $cm_mapper = new Application_Model_EuCompteMapper();
                 $tpagcp = new Application_Model_EuTpagcp();
                 $map_tpagcp = new Application_Model_EuTpagcpMapper();
                 $te_mapper = new Application_Model_EuTegcMapper();
                 $te = new Application_Model_EuTegc();
				 $gcp_preleve = new Application_Model_EuGcpPrelever();
				 $gcp_preleve_mapper = new Application_Model_EuGcpPreleverMapper();
                 $m_acteur = new Application_Model_EuActeurCreneauMapper();
				 $gcp_mapper = new Application_Model_EuGcpMapper();
				 $place = new Application_Model_EuOperation();
				 $mapper = new Application_Model_EuOperationMapper();
				 $num_compte = 'NB-'.'TPAGCP-'.$sessionmembre->code_membre;
				 $acteur = $m_acteur->findActeurByMembre($sessionmembre->code_membre);
				 $montant = $request->getParam("montant_prelever");
				 $te_mapper->findByMembre($sessionmembre->code_membre,$te);
		         $tegcp = $te->getCode_tegc();

				 if ($acteur == null) {
				     $this->view->montant_prelever = $montant;
                     $this->view->message = "Ce membre ne dispose pas de compte de vente !!! ";
                     $db->rollback();
                     return;
                 } else {
				     $retour = $cm_mapper->find($num_compte,$compte);
                     if ($retour && ($compte->getSolde() >= $montant)) {
                         $compteur = $mapper->findConuter() + 1;
						 $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                         $date_deb = clone $date_fin;

						 $place->setId_operation($compteur)
                               ->setMontant_op($montant)
                               ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                               ->setHeure_op($date_deb->toString('HH:mm:ss'))
                               ->setId_utilisateur(NULL)
                               ->setLib_op('Pr�levement du GCP')
                               ->setType_op('PGCP')
                               ->setCode_produit('GCP')
                               ->setCode_cat('TPAGCP')
							   ->setCode_membre(NULL)
							   ->setCode_membre_morale($sessionmembre->code_membre);
					      $mapper->save($place);


                          $compte->setSolde($compte->getSolde() - $montant);
                          $cm_mapper->update($compte);

						  $ret_te = $te_mapper->find($tegcp,$te);
                          $mdv = 0;
				          $id_tpagcp = $map_tpagcp->findConuter() + 1;
						  if ($ret_te) {
						      $mdv = $te->getMdv();
                              $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                              $date_deb = clone $date_fin;
                              $date_fin_tranche = clone $date_fin;
                              $te->setMontant($te->getSolde_tegc() - $montant);
							  $te->setMontant($te->getMontant_utilise() + $montant);
                              $te_mapper->update($te);

                              $periode = Util_Utils::getParametre('periode', 'valeur');
                    	      $date_fin->addDay($mdv * $periode);

						      $date_fin_tranche->addDay($periode);

                              $tpagcp->setId_tpagcp($id_tpagcp)
                                     ->setCode_tegc($tegcp)
                                     ->setCode_compte($compte->getCode_compte())
                                     ->setDate_deb($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
                                     ->setCode_membre($sessionmembre->code_membre)
                                     ->setMont_gcp($montant)
                                     ->setNtf(round($mdv))
                                     ->setMont_tranche(round($montant/$mdv))
                                     ->setDate_fin($date_fin->toString('yyyy-MM-dd HH:mm:ss'))
                                     ->setMont_echu(0)
                                     ->setDate_deb_tranche($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
                                     ->setPeriode($periode)
                                     ->setDate_fin_tranche($date_fin_tranche->toString('yyyy-MM-dd HH:mm:ss'))
                                     ->setSolde($montant)
                                     ->setMont_escompte(0)
							         ->setMont_echange(0)
                                     ->setReste_ntf($mdv);
                              $map_tpagcp->save($tpagcp);

                              $gcps = $gcp_mapper->findGcpByTegcp($tegcp);
                              if (count($gcps) > 0) {
							     $j = 0;
								 while($montant > 0 && $j < count($gcps)) {
							          $gcpresult = $gcps[$j];
								      $gcp = new Application_Model_EuGcp();
								      $gcp_mapper->find($gcpresult->getId_gcp(),$gcp);
                                      if ($gcp->getReste() < $montant) {
                                         $montant = $montant - $gcp->getReste();
										 $gcp_preleve = new Application_Model_EuGcpPrelever();
									     $id_prelevement = $gcp_preleve_mapper->findConuter() + 1;
                                         $gcp_preleve->setId_prelevement($id_prelevement)
											         ->setId_gcp($gcp->getId_gcp())
                                                     ->setId_operation($compteur)
                                                     ->setCode_tegc($gcp->getCode_tegc())
                                                     ->setCode_membre($sessionmembre->code_membre)
                                                     ->setMont_prelever($gcp->getReste())
												     ->setMont_rapprocher(0)
												     ->setRapprocher(0)
												     ->setSolde_prelevement($gcp->getReste())
                                                     ->setDate_prelevement($date_deb->toString('yyyy-MM-dd'))
                                                     ->setHeure_prelevement($date_deb->toString('HH:mm:ss'))
                                                     ->setId_tpagcp($id_tpagcp);
                                          $gcp_preleve_mapper->save($gcp_preleve);

                                          $gcp->setMont_preleve($gcp->getMont_preleve() + $gcp->getReste())
                                              ->setReste(0);
                                          $gcp_mapper->update($gcp);
                                          $j = $j + 1;
                                      } else {
                                          $gcp_preleve = new Application_Model_EuGcpPrelever();
                                          $id_prelevement = $gcp_preleve_mapper->findConuter() + 1;
                                          $gcp_preleve->setId_prelevement($id_prelevement)
											    ->setId_gcp($gcp->getId_gcp())
                                                ->setId_operation($compteur)
                                                ->setCode_tegc($gcp->getCode_tegc())
                                                ->setCode_membre($sessionmembre->code_membre)
                                                ->setMont_prelever($montant)
												->setMont_rapprocher(0)
												->setRapprocher(0)
												->setSolde_prelevement($montant)
                                                ->setDate_prelevement($date_deb->toString('yyyy-MM-dd'))
                                                ->setHeure_prelevement($date_deb->toString('HH:mm:ss'))
                                                ->setId_tpagcp($id_tpagcp);
                                           $gcp_preleve_mapper->save($gcp_preleve);

                                           $gcp->setMont_preleve($gcp->getMont_preleve() + $montant)
                                               ->setReste($gcp->getReste() - $montant);
                                           $gcp_mapper->update($gcp);
                                           $montant = 0;
                                           $j = $j + 1;
                                      }
							     }
							  } else {
							     $this->view->montant_prelever = $montant;
                                 $this->view->message = 'Ce membre ne possede pas de gcp !!!';
                                 $db->rollback();
                                 return;
                              }

						  } else {
						      $this->view->montant_prelever = $montant;
                              $this->view->message = "Ce membre ne dispose pas de compte de vente ...";
                              $db->rollback();
                              return;
						  }
                     } else {
					   $this->view->montant_prelever = $montant;
                       $this->view->message = "Le solde de ce compte est insuffisant pour effectuer cette operation !!!";
                       $db->rollback();
                       return;
                     }


					 $db->commit();
					 $sessionmembre->errorlogin = "Operation bien effectuee ...";
					 $this->_redirect('/opi/newopi');

				 }
		     } catch (Exception $exc) {
			     $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                 return;
		    }

		 }


	  }









    public function newbcAction()  {
       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }

     $cm_mapper = new Application_Model_EuCompteMapper();
         $compte = new Application_Model_EuCompte();

     $morale = new Application_Model_EuMembreMorale();
       $m_morale  = new Application_Model_EuMembreMoraleMapper();
     $findmembre = $m_morale->find($sessionmembre->code_membre,$morale);
     $this->view->type_fournisseur = $morale->getType_fournisseur();

     $v_num_compte = 'NB-'.'TPAGCP-'.$sessionmembre->code_membre;
         $retour = $cm_mapper->find($v_num_compte,$compte);
         if ($retour) {
             $this->view->solde = $compte->getSolde();
         }

     $tabela = new Application_Model_DbTable_EuTpagcp();
         $select = $tabela->select();
         $select->where('code_membre like ?',$sessionmembre->code_membre);
         $select->order('id_tpagcp desc');
         $achats = $tabela->fetchAll($select);
     $this->view->achats = $achats;

     $this->view->tabletri = 1;

     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
           $id_utilisateur_acnev = 1;
                 $id_utilisateur_filiere = 2;
                 $id_utilisateur_technopole = 3;

             $compte = new Application_Model_EuCompte();
                 $cm_mapper = new Application_Model_EuCompteMapper();
                 $tpagcp = new Application_Model_EuTpagcp();
                 $map_tpagcp = new Application_Model_EuTpagcpMapper();

         $membremorale = new Application_Model_EuMembreMorale();
               $m_mapmorale  = new Application_Model_EuMembreMoraleMapper();

                 $te_mapper = new Application_Model_EuTegcMapper();
                 $te = new Application_Model_EuTegc();
         $gcp_preleve = new Application_Model_EuGcpPrelever();
         $gcp_preleve_mapper = new Application_Model_EuGcpPreleverMapper();
                 $m_acteur = new Application_Model_EuActeurCreneauMapper();
         $gcp_mapper = new Application_Model_EuGcpMapper();
         $place = new Application_Model_EuOperation();
         $mapper = new Application_Model_EuOperationMapper();

         $cc = new Application_Model_EuCompteCredit();
         $ccM = new Application_Model_EuCompteCreditMapper();

         $num_compte = 'NB-'.'TPAGCP-'.$sessionmembre->code_membre;
         $acteur = $m_acteur->findActeurByMembre($sessionmembre->code_membre);
         $montant = $request->getParam("montant_prelever");
         $findmembre = $m_mapmorale->find($sessionmembre->code_membre,$membremorale);

         if($membremorale->type_fournisseur == "specifique") {
            //$mode_reglement = "CHEQUE";
			$mode_reglement = "OPI";
         } elseif($membremorale->type_fournisseur == "externe") {
            $mode_reglement = "OPI";
         } elseif($membremorale->type_fournisseur == "utilisateur") {
            $mode_reglement = $request->getParam("mode_reglement");
         } else {
            $mode_reglement = $request->getParam("mode_reglement");
         }

         $te_mapper->findByMembre($sessionmembre->code_membre,$te);
         $tegcp = $te->getCode_tegc();

         if ($acteur == null) {
             $this->view->montant_prelever = $montant;
             $this->view->message = "Ce membre ne dispose pas de compte de vente !!! ";
             $db->rollback();
             return;
         } else {
             $retour = $cm_mapper->find($num_compte,$compte);
             if ($retour && ($compte->getSolde() >= $montant)) {
                 $compteur = $mapper->findConuter() + 1;
                 $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                 $date_deb = clone $date_fin;

                 $place->setId_operation($compteur)
                       ->setMontant_op($montant)
                       ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                       ->setHeure_op($date_deb->toString('HH:mm:ss'))
                       ->setId_utilisateur(NULL)
                       ->setLib_op('Pr�levement du GCP')
                       ->setType_op('PGCP')
                       ->setCode_produit('GCP')
                       ->setCode_cat('TPAGCP')
                       ->setCode_membre(NULL)
                       ->setCode_membre_morale($sessionmembre->code_membre);
                $mapper->save($place);

                $compte->setSolde($compte->getSolde() - $montant);
                $cm_mapper->update($compte);

                $ret_te = $te_mapper->find($tegcp,$te);
                $mdv = 0;
                $id_tpagcp = $map_tpagcp->findConuter() + 1;
                if ($ret_te) {
                    $mdv = $te->getMdv();
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
                    $date_fin_tranche = clone $date_fin;
                    $te->setMontant($te->getSolde_tegc() - $montant);
                    $te->setMontant($te->getMontant_utilise() + $montant);
                    $te_mapper->update($te);

                    $periode = Util_Utils::getParametre('periode', 'valeur');
                    $date_fin->addDay($mdv * $periode);

                    $date_fin_tranche->addDay($periode);

                    $tpagcp->setId_tpagcp($id_tpagcp)
                           ->setCode_tegc($tegcp)
                           ->setCode_compte($compte->getCode_compte())
                           ->setDate_deb($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
                           ->setCode_membre($sessionmembre->code_membre)
                           ->setMont_gcp($montant)
                           ->setNtf(round($mdv))
                           ->setMont_tranche(round($montant/$mdv))
                           ->setDate_fin($date_fin->toString('yyyy-MM-dd HH:mm:ss'))
                           ->setMont_echu(0)
                           ->setDate_deb_tranche($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
                           ->setPeriode($periode)
                           ->setDate_fin_tranche($date_fin_tranche->toString('yyyy-MM-dd HH:mm:ss'))
                           ->setSolde($montant)
                           ->setMont_escompte(0)
                           ->setMont_echange(0)
                           ->setReste_ntf($mdv)
                           ->setMode_reglement($mode_reglement)
                           ->setEscomptable(0);
                     $map_tpagcp->save($tpagcp);


                     /////////////////////////// validation acnev ////////////////////////////////////

                     $tpagcpmodel = new Application_Model_EuTpagcp();
                     $tpagcpM = new Application_Model_EuTpagcpMapper();
                     $tpagcpM->find($id_tpagcp,$tpagcpmodel);

                     $tpagcpmodel->setEscomptable(1);
                     $tpagcpM->update($tpagcpmodel);

                     $validation_quittance = new Application_Model_EuValidationQuittance();
                     $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();

                     $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                     $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
                     $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_acnev);
                     $validation_quittance->setValidation_bc($id_tpagcp);
                     $validation_quittance->setValidation_quittance_date($date_deb->toString('yyyy-MM-dd HH:mm:ss'));
                     $validation_quittance->setPublier(1);
                     $validation_quittance_mapper->save($validation_quittance);

                     /////////////////////////// validation filiere ////////////////////////////////////

                     $tpagcpmodel = new Application_Model_EuTpagcp();
                     $tpagcpM = new Application_Model_EuTpagcpMapper();
                     $tpagcpM->find($id_tpagcp,$tpagcpmodel);

                     $tpagcpmodel->setEscomptable(2);
                     $tpagcpM->update($tpagcpmodel);


                     $validation_quittance = new Application_Model_EuValidationQuittance();
                     $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();

                     $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                     $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
                     $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_filiere);
                     $validation_quittance->setValidation_bc($id_tpagcp);
                     $validation_quittance->setValidation_quittance_date($date_deb->toString('yyyy-MM-dd HH:mm:ss'));
                     $validation_quittance->setPublier(1);
                     $validation_quittance_mapper->save($validation_quittance);

                     /////////////////////////// validation technopole ////////////////////////////////////
                     $tpagcpmodel = new Application_Model_EuTpagcp();
                     $tpagcpM = new Application_Model_EuTpagcpMapper();
                     $tpagcpM->find($id_tpagcp,$tpagcpmodel);

                     $tpagcpmodel->setEscomptable(3);
                     $tpagcpM->update($tpagcpmodel);

                     $validation_quittance = new Application_Model_EuValidationQuittance();
                     $validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();

                     $compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
                     $validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
                     $validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_technopole);
                     $validation_quittance->setValidation_bc($id_tpagcp);
                     $validation_quittance->setValidation_quittance_date($date_deb->toString('yyyy-MM-dd HH:mm:ss'));
                     $validation_quittance->setPublier(1);
                     $validation_quittance_mapper->save($validation_quittance);

                     /////////////////////  Fin des validations des administrateurs  ///////////////////////////////////

                     $gcps = $gcp_mapper->findGcpByTegcp($tegcp);
                     if (count($gcps) > 0) {
                        $j = 0;
                        while($montant > 0 && $j < count($gcps)) {
                             $gcpresult = $gcps[$j];
                             $gcp = new Application_Model_EuGcp();
                             $gcp_mapper->find($gcpresult->getId_gcp(),$gcp);

                             $findcredit = $ccM->find($gcp->getId_credit(),$cc);

                             if($findcredit != false)  {
                                         if ($gcp->getReste() < $montant) {
                                             $montant = $montant - $gcp->getReste();
                         $gcp_preleve = new Application_Model_EuGcpPrelever();
                           $id_prelevement = $gcp_preleve_mapper->findConuter() + 1;
                                             $gcp_preleve->setId_prelevement($id_prelevement)
                               ->setId_gcp($gcp->getId_gcp())
                                                     ->setId_operation($compteur)
                                                     ->setCode_tegc($gcp->getCode_tegc())
                                                     ->setCode_membre($sessionmembre->code_membre)
                                                     ->setMont_prelever($gcp->getReste())
                             ->setMont_rapprocher(0)
                             ->setRapprocher(0)
                             ->setSolde_prelevement($gcp->getReste())
                                                     ->setDate_prelevement($date_deb->toString('yyyy-MM-dd'))
                                                     ->setHeure_prelevement($date_deb->toString('HH:mm:ss'))
                                                     ->setId_tpagcp($id_tpagcp);
                                          $gcp_preleve_mapper->save($gcp_preleve);

                                          $gcp->setMont_preleve($gcp->getMont_preleve() + $gcp->getReste())
                                              ->setReste(0);
                                          $gcp_mapper->update($gcp);
                                          $j = $j + 1;
                                      } else {
                                          $gcp_preleve = new Application_Model_EuGcpPrelever();
                                          $id_prelevement = $gcp_preleve_mapper->findConuter() + 1;
                                          $gcp_preleve->setId_prelevement($id_prelevement)
                          ->setId_gcp($gcp->getId_gcp())
                                                ->setId_operation($compteur)
                                                ->setCode_tegc($gcp->getCode_tegc())
                                                ->setCode_membre($sessionmembre->code_membre)
                                                ->setMont_prelever($montant)
                        ->setMont_rapprocher(0)
                        ->setRapprocher(0)
                        ->setSolde_prelevement($montant)
                                                ->setDate_prelevement($date_deb->toString('yyyy-MM-dd'))
                                                ->setHeure_prelevement($date_deb->toString('HH:mm:ss'))
                                                ->setId_tpagcp($id_tpagcp);
                                           $gcp_preleve_mapper->save($gcp_preleve);

                                           $gcp->setMont_preleve($gcp->getMont_preleve() + $montant)
                                               ->setReste($gcp->getReste() - $montant);
                                           $gcp_mapper->update($gcp);
                                           $montant = 0;
                                           $j = $j + 1;
                                      }

                                     } else {
                                        $this->view->montant_prelever = $montant;
                                        $this->view->message = 'Pas de bon de consommation correspond pour ce bon de livraison !!!';
                                        $db->rollback();
                                        return;
                   }

                   }

                } else {
                   $this->view->montant_prelever = $montant;
                                 $this->view->message = 'Ce membre ne possede pas de gcp !!!';
                                 $db->rollback();
                                 return;
                              }

              } else {
                  $this->view->montant_prelever = $montant;
                              $this->view->message = "Ce membre ne dispose pas de compte de vente ...";
                              $db->rollback();
                              return;
              }
                     } else {
             $this->view->montant_prelever = $montant;
                       $this->view->message = "Le solde de ce compte est insuffisant pour effectuer cette operation !!!";
                       $db->rollback();
                       return;
                     }

           $db->commit();
           $sessionmembre->errorlogin = "Operation bien effectuee ...";
           $this->_redirect('/opi/newbc');

         }
         } catch (Exception $exc) {
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                 return;
        }

     }


    }


      public function listsalaireAction() {
     /* page administration/listsalaire - Liste des salaires */
       $sessionmembre = new Zend_Session_Namespace('membre');
       //$this->_helper->layout->disableLayout();
       $this->_helper->layout()->setLayout('layoutpublicesmcperso');

       if (!isset($sessionmembre->code_membre)) {
           $this->_redirect('/');
       }
     $tabela = new Application_Model_DbTable_EuTpagcp();
     $select = $tabela->select();
     $select->where('eu_tpagcp.code_membre = ?',$sessionmembre->code_membre);
       $select->where("eu_tpagcp.mode_reglement LIKE 'SALAIRE'");
     $result = $tabela->fetchAll($select);
       $this->view->entries = $result;

       $this->view->tabletri = 1;
  }







    public function listtraiteAction() {
        /* page administration/listtraite - Liste des traites */

        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        //$select->joinRight('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
        $select->where('eu_tpagcp.escomptable = 3');
        $select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
        $select->where("eu_tpagcp.mode_reglement LIKE 'OPI'");
        //$select->where('eu_traite.traiter != 8');
        $select->order('eu_tpagcp.date_deb ASC');
        $traites = $tabela->fetchAll($select);

        $this->view->traites = $traites;

        $this->view->tabletri = 1;

    }


    public function listtraite2Action()
    {
        /* page administration/listtraite2 - Liste des traites trait�es */

       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }

$periodes = Util_Utils::getParametre('periode', 'valeur');


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
        $select->where('eu_tpagcp.escomptable = 3');
        //$select->where('eu_traite.traiter = ?', 12);
        $select->where('eu_tpagcp.reste_ntf = 0');
        $select->where("eu_tpagcp.mode_reglement LIKE 'OPI'");
        $select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
        $select->order('eu_tpagcp.date_deb ASC');
        $traites = $tabela->fetchAll($select);

    $this->view->traites = $traites;



        $this->view->tabletri = 1;

    }





public function listtraite11Action()
    {
        /* page administration/listtraite - Liste des traites */

       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        //$select->join('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
        $select->where('eu_tpagcp.escomptable = 3');
        //$select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
        $select->where("eu_tpagcp.mode_reglement LIKE 'OPI'");
        //$select->where("eu_traite.traite_code_banque IN (SELECT code_banque FROM eu_banque WHERE code_membre_morale LIKE '".$sessionmembre->code_membre."')");
        $select->order('eu_tpagcp.date_deb ASC');
        $traites = $tabela->fetchAll($select);

    $this->view->traites = $traites;



        $this->view->tabletri = 1;

    }


    public function listtraite12Action()
    {
        /* page administration/listtraite2 - Liste des traites trait�es */

       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
        //$select->setIntegrityCheck(false);
        //$select->join('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
        $select->where('escomptable = 3');
        //$select->where('eu_traite.traiter = 8');
        $select->where("mode_reglement LIKE 'OPI'");
        //$select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
        //$select->where("eu_traite.traite_code_banque IN (SELECT code_banque FROM eu_banque WHERE code_membre_morale LIKE '".$sessionmembre->code_membre."')");
        $select->order(array('date_deb DESC'));
        $traites = $tabela->fetchAll($select);

    $this->view->traites = $traites;



        $this->view->tabletri = 1;

    }


    public function detailstraiteAction() {
        $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $tpagcp = new Application_Model_EuTpagcp();
        $tpagcpM = new Application_Model_EuTpagcpMapper();
        $tpagcpM->find($id, $tpagcp);
        $this->view->tpagcp = $tpagcp;



        $traiteT = new Application_Model_DbTable_EuTraite();
        $select = $traiteT->select();
        $select->where('traite_tegcp = ?', $id);
        $select->order('traiter ASC');
        $traites = $traiteT->fetchAll($select);

        $this->view->traites = $traites;
            }

    }

public function detailstraite2Action() {
        $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $tpagcp = new Application_Model_EuTpagcp();
        $tpagcpM = new Application_Model_EuTpagcpMapper();
        $tpagcpM->find($id, $tpagcp);
        $this->view->tpagcp = $tpagcp;



        $traiteT = new Application_Model_DbTable_EuTraite();
        $select = $traiteT->select();
        $select->where('traite_tegcp = ?', $id);
        //$select->where("traite_code_banque IN (SELECT code_banque FROM eu_banque WHERE code_membre_morale LIKE '".$sessionmembre->code_membre."')");
        $select->order('traiter ASC');
        $traites = $traiteT->fetchAll($select);

        $this->view->traites = $traites;
            }

    }

    public function traitertraiteAction()
    {
        /* page administration/traitertraite - Traiter un traite */

       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

    $mapper_traite = new Application_Model_EuTraiteMapper();
    $traite2 = $mapper_traite->findTraiteTegcp($id);
    foreach ($traite2 as $row){
        $traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($row->traite_id, $traite);

        $traite->setTraiter(0);
    $traiteM->update($traite);
  }
        }

    $this->_redirect('/opi/listtraite');
    }






    public function pdftraiteAction()
    {
        /* page administration/pdftraite - G�n�ration de traite en PDF */

      $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    //include("Transfert.php");


if(isset($_POST['ok']) && $_POST['ok']=="ok"){

        $id = $_POST['traite_id'];
        $banque = "";
        $code_banque = $_POST['code_banque'];
        $num_compte_bancaire = $_POST['num_compte_bancaire'];

        if ($id > 0 && $code_banque != "WARI" && $num_compte_bancaire != "") {
/**/$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);

        $traite->setMode_paiement($code_banque);
        $traite->setReference_paiement($num_compte_bancaire);
        //$traite->setTraite_numero($numero_opi);
        //$traite->setTraite_imprimer(1);
    $traiteM->update($traite);
        //$pdf = Util_Utils::genererPdfOPI($id, $banque, $code_banque, $num_compte_bancaire);
//$this->_redirect($pdf);

        }else{
/**/$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);

        $traite->setMode_paiement($code_banque);
        $traite->setReference_paiement($num_compte_bancaire);
        //$traite->setTraite_numero($numero_opi);
        //$traite->setTraite_imprimer(1);
    $traiteM->update($traite);

/*$tpagcp = new Application_Model_EuTpagcp();
        $tpagcpM = new Application_Model_EuTpagcpMapper();
        $tpagcpM->find($traite->traite_tegcp, $tpagcp);

        $tpagcp->setReste_ntf($tpagcp->getReste_ntf() - 1);
        $tpagcp->setSolde($tpagcp->getSolde() - $tpagcp->getMont_tranche());
    $tpagcpM->update($tpagcp);*/
        }

}else{

        $id = (int) $this->_request->getParam('id');
        $banque = (int)$this->_request->getParam('banque');
        $code_banque = "";
        $num_compte_bancaire = "";

        if ($id > 0 && $banque > 0) {
        $comptebancaire = new Application_Model_EuCompteBancaire();
        $comptebancaireM = new Application_Model_EuCompteBancaireMapper();
        $comptebancaireM->find($banque, $comptebancaire);
        if($comptebancaire->code_banque != "WARI"){
/**/$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);

        $traite->setMode_paiement($comptebancaire->code_banque);
        $traite->setReference_paiement($comptebancaire->num_compte_bancaire);
        //$traite->setTraite_numero($numero_opi);
        //$traite->setTraite_imprimer(1);
    $traiteM->update($traite);

        //$pdf = Util_Utils::genererPdfOPI($id, $banque, $code_banque, $num_compte_bancaire);
//$this->_redirect($pdf);

        }else{
/**/$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);

        $traite->setMode_paiement($comptebancaire->code_banque);
        $traite->setReference_paiement($comptebancaire->num_compte_bancaire);
        //$traite->setTraite_numero($numero_opi);
        //$traite->setTraite_imprimer(1);
    $traiteM->update($traite);

/*$tpagcp = new Application_Model_EuTpagcp();
        $tpagcpM = new Application_Model_EuTpagcpMapper();
        $tpagcpM->find($traite->traite_tegcp, $tpagcp);

        $tpagcp->setReste_ntf($tpagcp->getReste_ntf() - 1);
        $tpagcp->setSolde($tpagcp->getSolde() - $tpagcp->getMont_tranche());
    $tpagcpM->update($tpagcp);*/
        }

        }else if($id > 0){
/**/$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);

        $pdf = Util_Utils::genererPdfOPI($id, $banque, $traite->mode_paiement, $traite->reference_paiement);
$this->_redirect($pdf);

        }else{
/**/$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);

        $traite->setMode_paiement($code_banque);
        $traite->setReference_paiement($num_compte_bancaire);
        //$traite->setTraite_numero($numero_opi);
        //$traite->setTraite_imprimer(1);
    $traiteM->update($traite);

/*$tpagcp = new Application_Model_EuTpagcp();
        $tpagcpM = new Application_Model_EuTpagcpMapper();
        $tpagcpM->find($traite->traite_tegcp, $tpagcp);

        $tpagcp->setReste_ntf($tpagcp->getReste_ntf() - 1);
        $tpagcp->setSolde($tpagcp->getSolde() - $tpagcp->getMont_tranche());
    $tpagcpM->update($tpagcp);*/
        }

}
/**/$traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);

    $this->_redirect('/opi/detailstraite/id/'.$traite->traite_tegcp);

    }




    public function pdftraiteoldAction()
    {
        /* page administration/pdftraite - G�n�ration de traite en PDF */

      $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    //include("Transfert.php");

            
            $code_banque = $this->_request->getParam('code_banque');
            if ($code_banque != "") {
              # code...
            }else{
              $code_banque = "";
            }

            $num_compte_bancaire = $this->_request->getParam('num_compte_bancaire');
            if ($num_compte_bancaire != "") {
              # code...
            }else{
              $num_compte_bancaire = "";
            }

            $banque = (int)$this->_request->getParam('banque');
            if ($banque > 0) {
              # code...
            }else{
              $banque = 0;
            }

        $periode = (int) $this->_request->getParam('periode');

        $id = (int) $this->_request->getParam('id');
        $codeb = (string) $this->_request->getParam('codeb');
        if (isset($id) && $id != 0) {

      $id_tpagcp = $id;
    /*
        $mapper_traite = new Application_Model_EuTraiteMapper();
    $traite = $mapper_traite->findTraiteTegcpTraiter($id_tpagcp, $periode);
    if($traite === FALSE){
        $a = new Application_Model_EuTraite();
        $ma = new Application_Model_EuTraiteMapper();

            $compteur = $ma->findConuter() + 1;
            $a->setTraite_id($compteur);
            $a->setTraite_tegcp($id_tpagcp);
            $a->setTraite_code_banque($codeb);
            $a->setTraiter($periode);
            $ma->save($a);
      }else{
        $a = new Application_Model_EuTraite();
        $ma = new Application_Model_EuTraiteMapper();
    $ma->find($traite->traite_id, $a);

            $a->setTraite_code_banque($codeb);
            $a->setTraiter($periode);
            $ma->update($a);
        }
    */

        //Util_Utils::genererPdfOPI($id, $banque);
        $pdf = Util_Utils::genererPdfOPI($id, $banque, $code_banque, $num_compte_bancaire);
$this->_redirect($pdf);
    
        }

    }





    public function listchequeAction()
    {
        /* page administration/listcheque - Liste des traite cheques */

       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
                //$select->joinRight('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
            $select->where('eu_tpagcp.escomptable = 3');
            $select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
            $select->where("eu_tpagcp.mode_reglement LIKE 'CHEQUE'");
            //$select->where('eu_traite.traiter != 8');
        $select->order('eu_tpagcp.date_deb ASC');
        $traites = $tabela->fetchAll($select);

    $this->view->traites = $traites;



        $this->view->tabletri = 1;

    }


    public function listcheque2Action()
    {
        /* page administration/listcheque2 - Liste des traites cheque trait�es */

       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
                $select->join('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
            $select->where('eu_tpagcp.escomptable = 3');
            $select->where('eu_traite.traiter = 8');
            $select->where("eu_tpagcp.mode_reglement LIKE 'CHEQUE'");
            $select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
        $select->order('eu_tpagcp.date_deb ASC');
        $traites = $tabela->fetchAll($select);

    $this->view->traites = $traites;



        $this->view->tabletri = 1;

    }




    public function chequetraiterAction()
    {
        /* page administration/pdftraite - G�n�ration de traite en PDF */

      $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    include("Transfert.php");

        $periode = (int) $this->_request->getParam('periode');

        $id = (int) $this->_request->getParam('id');
        $codeb = (string) $this->_request->getParam('codeb');
        if (isset($id) && $id != 0) {

      $id_tpagcp = $id;

       /* $mapper_traite = new Application_Model_EuTraiteMapper();
    $traite = $mapper_traite->findTraiteTegcpTraiter($id_tpagcp, $periode);
    if($traite === FALSE){
        $a = new Application_Model_EuTraite();
        $ma = new Application_Model_EuTraiteMapper();

            $compteur = $ma->findConuter() + 1;
            $a->setTraite_id($compteur);
            $a->setTraite_tegcp($id_tpagcp);
            $a->setTraite_code_banque($codeb);
            $a->setTraiter($periode);
            $ma->save($a);
      }else{
        $a = new Application_Model_EuTraite();
        $ma = new Application_Model_EuTraiteMapper();
    $ma->find($traite->traite_id, $a);

            $a->setTraite_code_banque($codeb);
            $a->setTraiter($periode);
            $ma->update($a);
        }
    */

        }
    $this->_redirect('/opi/listcheque');

    }






    public function listreapprovisionnementAction()
    {
        /* page administration/listreapprovisionnement - Liste des traites */

       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
                //$select->joinRight('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
            $select->where('eu_tpagcp.escomptable = 3');
            $select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
            $select->where("eu_tpagcp.mode_reglement LIKE 'REAPPRO'");
            //$select->where('eu_traite.traiter != 8');
        $select->order('eu_tpagcp.date_deb ASC');
        $traites = $tabela->fetchAll($select);

    $this->view->traites = $traites;



        $this->view->tabletri = 1;

    }


    public function listreapprovisionnement2Action()
    {
        /* page administration/listreapprovisionnement2 - Liste des traites trait�es */

       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }


        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
                $select->join('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
            $select->where('eu_tpagcp.escomptable = 3');
            $select->where('eu_traite.traiter = 8');
            $select->where("eu_tpagcp.mode_reglement LIKE 'REAPPRO'");
            $select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
        $select->order('eu_tpagcp.date_deb ASC');
        $traites = $tabela->fetchAll($select);

    $this->view->traites = $traites;



        $this->view->tabletri = 1;

    }




    public function reapprovisionnementtraiterAction()
    {
        /* page administration/pdftraite - G�n�ration de traite en PDF */

      $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    include("Transfert.php");

        $periode = (int) $this->_request->getParam('periode');

        $id = (int) $this->_request->getParam('id');
        $codeb = (string) $this->_request->getParam('codeb');
        if (isset($id) && $id != 0) {

      $id_tpagcp = $id;
    /*
        $mapper_traite = new Application_Model_EuTraiteMapper();
    $traite = $mapper_traite->findTraiteTegcpTraiter($id_tpagcp, $periode);
    if($traite === FALSE){
        $a = new Application_Model_EuTraite();
        $ma = new Application_Model_EuTraiteMapper();

            $compteur = $ma->findConuter() + 1;
            $a->setTraite_id($compteur);
            $a->setTraite_tegcp($id_tpagcp);
            $a->setTraite_code_banque($codeb);
            $a->setTraiter($periode);
            $ma->save($a);
      }else{
        $a = new Application_Model_EuTraite();
        $ma = new Application_Model_EuTraiteMapper();
    $ma->find($traite->traite_id, $a);

            $a->setTraite_code_banque($codeb);
            $a->setTraiter($periode);
            $ma->update($a);
        }

      */

        }

    $this->_redirect('/opi/listreapprovisionnement');
    }










public function rechercheopibanqueAction()
    {
        
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
        if(isset($_POST['ok']) && $_POST['ok']=="ok" && isset($_POST['traite_numero']) && $_POST['traite_numero']!=""){
    $mapper_traite = new Application_Model_EuTraiteMapper();
    $traite = $mapper_traite->fetchAllByNumero($_POST['traite_numero']);
if ($traite != false) {
        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select();
        $select->where('id_tpagcp = ?', $traite->traite_tegcp);
        $tpagcp = $tabela->fetchRow($select);
        $this->view->tpagcp = $tpagcp;

    $mapper_traite2 = new Application_Model_EuTraiteMapper();
    $this->view->traite2 = $mapper_traite2->findTraiteTegcp($traite->traite_tegcp);
    

}else{
  $this->view->error = "Pas d'OPI trouvé à ce numero ...";
}

$this->view->traite_numero = $_POST['traite_numero'];
        }

$this->view->tabletri = 1;

            }





  
  public function opiban55Action() {
     /* page opi/opiban - opi en ban */
       $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
     }

     
   $request = $this->getRequest();
   $date_id = new Zend_Date(Zend_Date::ISO_8601);
     
   if ($request->isPost())  {
      $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
          



if(substr($sessionmembre->code_membre, -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($sessionmembre->code_membre, $membre);
                $canton = $membre->id_canton;
                $nom = $membre->nom_membre;
                $prenom = $membre->prenom_membre;
                $email = $membre->email_membre;
                $mobile = $membre->portable_membre;
                $raison = NULL;
  }else if(substr($sessionmembre->code_membre, -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($sessionmembre->code_membre, $membremorale);
                $canton = $membremorale->id_canton;
                $nom = NULL;
                $prenom = NULL;
                $email = $membremorale->email_membre;
                $mobile = $membremorale->portable_membre;
                $raison = $membremorale->raison_sociale;
  }



$traite = new Application_Model_EuTraite();
$mtraite = new Application_Model_EuTraiteMapper();
$mtraite->find($request->getParam("traite_id"), $traite);

$traite->setTraite_payer(1);
$traite->setTraite_statut("Transformer en BAn");
$mtraite->update($traite);




$tpagcp = new Application_Model_EuTpagcp();
$mtpagcp = new Application_Model_EuTpagcpMapper();
$mtpagcp->find($traite->traite_tegcp, $tpagcp);

$tpagcp->setMont_echange($tpagcp->getMont_echange() + $tpagcp->getMont_tranche());
$tpagcp->setSolde($tpagcp->getSolde() - $tpagcp->getMont_tranche());
$tpagcp->setReste_ntf($tpagcp->getReste_ntf() - 1);
$mtpagcp->update($tpagcp);



                $date_id = Zend_Date::now();

                //$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
                do{
                                    $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
                }while(count($bon_neutre_detail2) > 0);


                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($sessionmembre->code_membre);
          if(count($bon_neutre2) > 0){

                $bon_neutre = new Application_Model_EuBonNeutre();
                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                $bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant() + $tpagcp->getMont_tranche());
                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() + $tpagcp->getMont_tranche());
                $bon_neutreM->update($bon_neutre);

                $bon_neutre_id = $bon_neutre->bon_neutre_id;


                                $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                                $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                                $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                                $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                                $bon_neutre_detail->setBon_neutre_id($bon_neutre->bon_neutre_id);
                                $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                                $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_detail->setBon_neutre_detail_montant($tpagcp->getMont_tranche());
                                $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                                $bon_neutre_detail->setBon_neutre_detail_montant_solde($tpagcp->getMont_tranche());
                                $bon_neutre_detail->setBon_neutre_detail_banque("OPI");
                                $bon_neutre_detail->setBon_neutre_detail_numero($traite->traite_numero);
                                $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                                $bon_neutre_detail->setId_canton($canton);
                                $bon_neutre_detail->setBon_neutre_appro_id(NULL);
                                $bon_neutre_detail_mapper->save($bon_neutre_detail);




                  }else{

                                  $bon_neutre = new Application_Model_EuBonNeutre();
                                  $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                                  $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                                  $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                                  $bon_neutre->setBon_neutre_type("BAn");
                                  $bon_neutre->setBon_neutre_code($code_BAn);
                                  $bon_neutre->setBon_neutre_code_membre($sessionmembre->code_membre);
                                  $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                  $bon_neutre->setBon_neutre_montant($tpagcp->getMont_tranche());
                                  $bon_neutre->setBon_neutre_montant_utilise(0);
                                  $bon_neutre->setBon_neutre_montant_solde($tpagcp->getMont_tranche());
                                  $bon_neutre->setBon_neutre_nom($nom);
                                  $bon_neutre->setBon_neutre_prenom($prenom);
                                  $bon_neutre->setBon_neutre_raison($raison);
                                  $bon_neutre->setBon_neutre_email($email);
                                  $bon_neutre->setBon_neutre_mobile($mobile);
                                  $bon_neutre_mapper->save($bon_neutre);




                    $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                                  $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                                  $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                                  $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                                  $bon_neutre_detail->setBon_neutre_id($compteur_bon_neutre);
                                  $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                                  $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                  $bon_neutre_detail->setBon_neutre_detail_montant($tpagcp->getMont_tranche());
                                  $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                                  $bon_neutre_detail->setBon_neutre_detail_montant_solde($tpagcp->getMont_tranche());
                                  $bon_neutre_detail->setBon_neutre_detail_banque("OPI");
                                  $bon_neutre_detail->setBon_neutre_detail_numero($traite->traite_numero);
                                  $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                                  $bon_neutre_detail->setId_canton($canton);
                                  $bon_neutre_detail->setBon_neutre_appro_id(NULL);
                                  $bon_neutre_detail_mapper->save($bon_neutre_detail);


                    }





        $db->commit();
        $sessionmembre->error = "Operation bien effectuee ...";
        
        $this->_redirect('/opi/opiban');

     
        } catch (Exception $exc)  {
       $db->rollback();
             $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
             return;
      }
     
       }
  
  }

















    public function reinjecteropiAction()
    {
        /* page administration/reinjecteropi -  */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tpagcp = new Application_Model_EuTpagcp();
        $tpagcpM = new Application_Model_EuTpagcpMapper();
        $tpagcpM->find($id, $tpagcp);
    
        $tpagcp->setReinjecter($this->_request->getParam('reinjecter'));
    $tpagcpM->update($tpagcp);
        }

    $this->_redirect('/opi/listtraite');
    }


    public function nbreinjectionAction()
    {
        /* page administration/nbreinjection -  */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

if(isset($_POST['ok']) && $_POST['ok']=="ok"){

        $a = new Application_Model_EuTpagcp();
        $ma = new Application_Model_EuTpagcpMapper();
        $ma->find($_POST['id_tpagcp'], $a);

        $a->setNbre_injection($_POST['nbre_injection']);
        $ma->update($a);
 
}
    $this->_redirect('/opi/listtraite');

}







    public function opiechuoldAction()
    {


$date_id = new Zend_Date(Zend_Date::ISO_8601);



    $table1 = new Application_Model_DbTable_EuTraite();
    $select1 = $table1->select();
    $select1->where('bon_id > ?', 0);
    $select1->where('traite_disponible = ?', 1);
    $select1->where('traite_imprimer = ?', 0);
    $select2->where("traite_date_fin <= '".$date_id->toString('yyyy-MM-dd')."'");
    $select1->where('mode_paiement != ?', 'WARI');
    $entries1 = $table1->fetchAll($select1);
if(count($entries1) > 0){
        //$pdf1 = Util_Utils::genererPdfTraiteBanque($entries1);
//$this->_redirect(Util_Utils::genererPdfTraiteBanque($entries1));
}

    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where('bon_id > ?', 0);
    $select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 0);
    $select2->where("traite_date_fin <= '".$date_id->toString('yyyy-MM-dd')."'");
    $select2->where("mode_paiement LIKE 'WARI'");
    $entries2 = $table2->fetchAll($select2);
if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteWari($entries2);
//$this->_redirect(Util_Utils::genererExcelTraiteWari($entries2));
}

    $table3 = new Application_Model_DbTable_EuTraite();
    $select3 = $table3->select();
    $select3->where('bon_id > ?', 0);
    $select3->where('traite_disponible = ?', 1);
    $select3->where('traite_imprimer = ?', 0);
    $select2->where("traite_date_fin <= '".$date_id->toString('yyyy-MM-dd')."'");
    //$select3->where('mode_paiement != ?', 'WARI');
    $entries3 = $table3->fetchAll($select3);
if(count($entries3) > 0){
        //$excel3 = Util_Utils::genererExcelTraite($entries3);
//$this->_redirect(Util_Utils::genererExcelTraite($entries3));
}


    }





public function opiechuAction()
    {



           ini_set('memory_limit', '512M');    

$date_id = new Zend_Date(Zend_Date::ISO_8601);



    $tablee = new Application_Model_DbTable_EuTraite();
    $selecte = $tablee->select();
    $selecte->distinct();
    $selecte->from(array('eu_traite'), 'traite_code_banque');
    $selecte->where('mode_paiement != ?', 'WARI');
    $selecte->where('mode_paiement != ?', 'FAIP');
    $entriese = $tablee->fetchAll($selecte);
foreach ($entriese as $value) {

    $table1 = new Application_Model_DbTable_EuTraite();
    $select1 = $table1->select();
    $select1->where('bon_id > ?', 0);
    $select1->where('traite_disponible = ?', 1);
    $select1->where('traite_imprimer = ?', 0);
    $select1->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select1->where('traite_date_fin <= ?', '2017-05-13');
    $select1->where('traite_code_banque = ?', $value->traite_code_banque);
    $select1->where('mode_paiement = ?', $value->traite_code_banque);
    $entries1 = $table1->fetchAll($select1);

if(count($entries1) > 0){
        $pdf1 = Util_Utils::genererPdfTraiteBanque1($entries1, $value->traite_code_banque);
//$this->_redirect(Util_Utils::genererPdfTraiteBanque($entries1, $value->traite_code_banque));

$html = "Ci-joint l'etat des OPI à transférer sur nos comptes du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI à transférer sur nos comptes du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $pdf1;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, 1);
foreach ($banque_email as $banque_email_value) {
$mail->addTo($banque_email_value->email);
}
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, -1);
foreach ($banque_email as $banque_email_value) {
$mail->addCc($banque_email_value->email);
}
$mail->addBcc(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

$mail->send($tr);

}

}








    $tablee = new Application_Model_DbTable_EuTraite();
    $selecte = $tablee->select();
    $selecte->distinct();
    $selecte->from(array('eu_traite'), 'traite_code_banque');
    $selecte->where('mode_paiement != ?', 'WARI');
    $selecte->where('mode_paiement != ?', 'FAIP');
    $entriese = $tablee->fetchAll($selecte);
foreach ($entriese as $value) {

    $table1 = new Application_Model_DbTable_EuTraite();
    $select1 = $table1->select();
    $select1->where('bon_id > ?', 0);
    $select1->where('traite_disponible = ?', 1);
    $select1->where('traite_imprimer = ?', 0);
    $select1->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select1->where('traite_date_fin <= ?', '2017-05-13');
    $select1->where('traite_code_banque = ?', $value->traite_code_banque);
    $select1->where('((mode_paiement != ?', $value->traite_code_banque);
    $select1->where('mode_paiement != ?', 'WARI');
    $select1->where('mode_paiement != ?)', 'FAIP');
    $select1->orwhere("mode_paiement IS NULL");
    $select1->orwhere("mode_paiement = '')");
    $entries1 = $table1->fetchAll($select1);

if(count($entries1) > 0){
        $pdf1 = Util_Utils::genererPdfTraiteBanque2($entries1, $value->traite_code_banque);
//$this->_redirect(Util_Utils::genererPdfTraiteBanque($entries1, $value->traite_code_banque));

$html = "Ci-joint l'etat des OPI à transférer sur les comptes de nos confrères du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI à transférer sur les comptes de nos confrères du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $pdf1;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, 1);
foreach ($banque_email as $banque_email_value) {
$mail->addTo($banque_email_value->email);
}
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, -1);
foreach ($banque_email as $banque_email_value) {
$mail->addCc($banque_email_value->email);
}
$mail->addBcc(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

$mail->send($tr);

}

}






    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where('bon_id > ?', 0);
    $select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 0);
    $select2->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select2->where('traite_date_fin <= ?', '2017-05-13');
    $select2->where('mode_paiement = ?', 'WARI');
    $entries2 = $table2->fetchAll($select2);

if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteWari($entries2);
//$this->_redirect(Util_Utils::genererExcelTraiteWari($entries2));


$html = "Ci-joint l'etat des OPI de WARI à charger sur l'interface administration de WARI du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI de WARI du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $excel2;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

$mail->send($tr);

}




    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where('bon_id > ?', 0);
    $select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 0);
    $select2->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select2->where('traite_date_fin <= ?', '2017-05-13');
    $select2->where('mode_paiement = ?', 'FAIP');
    $entries2 = $table2->fetchAll($select2);

if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteFAIP($entries2);
//$this->_redirect(Util_Utils::genererExcelTraiteFAIP($entries2));


$html = "Ci-joint l'etat des OPI de FAIP à envoyer à FAIP-TOGO du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI de FAIP du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $excel2;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

$mail->send($tr);

}






    $table3 = new Application_Model_DbTable_EuTraite();
    $select3 = $table3->select();
    $select3->where('bon_id > ?', 0);
    $select3->where('traite_disponible = ?', 1);
    $select3->where('traite_imprimer = ?', 2);
    $select3->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
    //$select3->where('traite_date_fin <= ?', '2017-05-13');
    //$select3->where('mode_paiement != ?', 'WARI');
    //$select3->where('mode_paiement != ?', 'FAIP');
    $entries3 = $table3->fetchAll($select3);

if(count($entries3) > 0){
        $excel3 = Util_Utils::genererExcelTraite($entries3);
//$this->_redirect(Util_Utils::genererExcelTraite($entries3));


$html = "Ci-joint l'etat de tous les OPI du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat de tous les OPI du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $excel3;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

$mail->send($tr);

}


                $db->commit();







}









public function opiechuparjourAction()
    {

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');


           ini_set('memory_limit', '512M');    

$date_id = new Zend_Date(Zend_Date::ISO_8601);

$datejour = "2018-04-18";

    $tablee = new Application_Model_DbTable_EuTraite();
    $selecte = $tablee->select();
    $selecte->distinct();
    $selecte->from(array('eu_traite'), 'traite_code_banque');
    $selecte->where('mode_paiement != ?', 'WARI');
    $selecte->where('mode_paiement != ?', 'FAIP');
    $selecte->where('traite_date_fin = ?', $datejour);
    $entriese = $tablee->fetchAll($selecte);
foreach ($entriese as $value) {

    $table1 = new Application_Model_DbTable_EuTraite();
    $select1 = $table1->select();
    $select1->where('bon_id > ?', 0);
    $select1->where('traite_disponible = ?', 1);
    $select1->where('traite_imprimer = ?', 1);
    $select1->where('traite_date_fin = ?', $datejour);
    //$select1->where('traite_date_fin <= ?', '2017-05-13');
    $select1->where('traite_code_banque = ?', $value->traite_code_banque);
    $select1->where('mode_paiement = ?', $value->traite_code_banque);
    $entries1 = $table1->fetchAll($select1);

if(count($entries1) > 0){
        $pdf1 = Util_Utils::genererPdfTraiteBanque1_jour($entries1, $value->traite_code_banque, $datejour);
//$this->_redirect(Util_Utils::genererPdfTraiteBanque($entries1, $value->traite_code_banque));
/*
$html = "Ci-joint l'etat des OPI à transférer sur nos comptes du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI à transférer sur nos comptes du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $pdf1;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, 1);
foreach ($banque_email as $banque_email_value) {
$mail->addTo($banque_email_value->email);
}
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, -1);
foreach ($banque_email as $banque_email_value) {
$mail->addCc($banque_email_value->email);
}
$mail->addBcc(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

$mail->send($tr);
*/
}

}








    $tablee = new Application_Model_DbTable_EuTraite();
    $selecte = $tablee->select();
    $selecte->distinct();
    $selecte->from(array('eu_traite'), 'traite_code_banque');
    $selecte->where('mode_paiement != ?', 'WARI');
    $selecte->where('mode_paiement != ?', 'FAIP');
    $selecte->where('traite_date_fin = ?', $datejour);
    $entriese = $tablee->fetchAll($selecte);
foreach ($entriese as $value) {

    $table1 = new Application_Model_DbTable_EuTraite();
    $select1 = $table1->select();
    $select1->where('bon_id > ?', 0);
    $select1->where('traite_disponible = ?', 1);
    $select1->where('traite_imprimer = ?', 1);
    $select1->where('traite_date_fin = ?', $datejour);
    //$select1->where('traite_date_fin <= ?', '2017-05-13');
    $select1->where('traite_code_banque = ?', $value->traite_code_banque);
    $select1->where('((mode_paiement != ?', $value->traite_code_banque);
    $select1->where('mode_paiement != ?', 'WARI');
    $select1->where('mode_paiement != ?)', 'FAIP');
    $select1->orwhere("mode_paiement IS NULL");
    $select1->orwhere("mode_paiement = '')");
    $entries1 = $table1->fetchAll($select1);

if(count($entries1) > 0){
        $pdf1 = Util_Utils::genererPdfTraiteBanque2_jour($entries1, $value->traite_code_banque, $datejour);
//$this->_redirect(Util_Utils::genererPdfTraiteBanque($entries1, $value->traite_code_banque));
/*
$html = "Ci-joint l'etat des OPI à transférer sur les comptes de nos confrères du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));
$objet = "L'Etat des OPI à transférer sur les comptes de nos confrères du ".datefr($date_id->toString('yyyy-MM-dd HH:mm'));

$file = $pdf1;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, 1);
foreach ($banque_email as $banque_email_value) {
$mail->addTo($banque_email_value->email);
}
$banque_emailM = new Application_Model_EuBanqueEmailMapper();
$banque_email = $banque_emailM->fetchAllByCodeBanque($value->traite_code_banque, -1);
foreach ($banque_email as $banque_email_value) {
$mail->addCc($banque_email_value->email);
}
$mail->addBcc(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

$mail->send($tr);
*/
}

}






    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where('bon_id > ?', 0);
    $select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 1);
    $select2->where('traite_date_fin = ?', $datejour);
    //$select2->where('traite_date_fin <= ?', '2017-05-13');
    $select2->where('mode_paiement = ?', 'WARI');
    $entries2 = $table2->fetchAll($select2);

if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteWari_jour($entries2, $datejour);
//$this->_redirect(Util_Utils::genererExcelTraiteWari($entries2));


$html = "Ci-joint l'etat des OPI de WARI à charger sur l'interface administration de WARI du ".datefr($datejour);
$objet = "L'Etat des OPI de WARI du ".datefr($datejour);

$file = $excel2;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

//$mail->send($tr);

}




    $table2 = new Application_Model_DbTable_EuTraite();
    $select2 = $table2->select();
    $select2->where('bon_id > ?', 0);
    $select2->where('traite_disponible = ?', 1);
    $select2->where('traite_imprimer = ?', 1);
    $select2->where('traite_date_fin = ?', $datejour);
    //$select2->where('traite_date_fin <= ?', '2017-05-13');
    $select2->where('mode_paiement = ?', 'FAIP');
    $entries2 = $table2->fetchAll($select2);

if(count($entries2) > 0){
        $excel2 = Util_Utils::genererExcelTraiteFAIP_jour($entries2, $datejour);
//$this->_redirect(Util_Utils::genererExcelTraiteFAIP($entries2));

$html = "Ci-joint l'etat des OPI de FAIP à envoyer à FAIP-TOGO du ".datefr($datejour);
$objet = "L'Etat des OPI de FAIP du ".datefr($datejour);

$file = $excel2;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

//$mail->send($tr);

}






    $table3 = new Application_Model_DbTable_EuTraite();
    $select3 = $table3->select();
    $select3->where('bon_id > ?', 0);
    $select3->where('traite_disponible = ?', 1);
    $select3->where('traite_imprimer = ?', 2);
    $select3->where('traite_date_fin = ?', $datejour);
    //$select3->where('traite_date_fin <= ?', '2017-05-13');
    //$select3->where('mode_paiement != ?', 'WARI');
    //$select3->where('mode_paiement != ?', 'FAIP');
    $entries3 = $table3->fetchAll($select3);

if(count($entries3) > 0){
        $excel3 = Util_Utils::genererExcelTraite_jour($entries3, $datejour);
//$this->_redirect(Util_Utils::genererExcelTraite($entries3));


$html = "Ci-joint l'etat de tous les OPI du ".datefr($datejour);
$objet = "L'Etat de tous les OPI du ".datefr($datejour);

$file = $excel3;
$path_parts = pathinfo($file);
$filena = $path_parts['basename'];

$config = array('auth' => 'login',
            'username' => Util_Utils::getParamEsmc(3),
            'password' => Util_Utils::getParamEsmc(4));

$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - Entreprise Sociale de Marché Commun");
$mail->addTo(Util_Utils::getParamEsmc(13));
$mail->addBcc("looky@gacsource.com");
$mail->addBcc("fiakofi@gacsource.com");
$mail->setSubject($objet);

$monImage = file_get_contents($file);
$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $file);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);

//$mail->send($tr);

}


                $db->commit();









    }









}
