<?php
class EuConsommationController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            //if ($group != 'dist' && $group != 'boutique') {/*&& $group != 'detentrice_filiere' && $group != 'surveillance' && $group != 'surveillance_technopole' && $group != 'executante' && $group != 'executante_acnev' && $group != 'pbf_grossiste' && $group != 'pbf_semi_grossiste' && $group != 'pbf_detaillant' && $group != 'oe_grossiste' && $group != 'oe_semi_grossiste' && $group != 'oe_detaillant' && $group != 'ose_grossiste' && $group != 'ose_semi_grossiste' && $group != 'ose_detaillant'*/
            if (($group != 'cnp_tegcp') && ($group != 'cnp_tegcp_pbf') && ($group != 'cnp_tegcsc')){
			    $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        /*$menu = '<li><a id="new" href="/eu-consommation/new">TEGCp</a></li>
            <li><a id="new" href="/eu-consommation/newgcsc">TEGCsc</a></li>
            <li><a id="detail" href="/eu-consommation/index">Recettes</a></li>';*/
        $menu = '<li><a id="detail" href="/eu-consommation/index">Recettes</a></li>';
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 20000);
        $sidx = $this->_request->getParam("sidx", 'id_operation');
        $sord = $this->_request->getParam("sord", 'asc');
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select();
        $select->where('id_utilisateur like ?', $user->id_utilisateur)
               ->where('date_op = ?', $date->toString('yyyy-MM-dd'))
               ->order('id_operation desc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($achats as $row) {
            //$date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->id_operation,
                $row->date_op,
                $row->code_membre_morale,
                $row->code_produit,
                $row->lib_op,
                $row->montant_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function indexAction() {
        // action body
    }

    public function deviseAction() {
        $m_dev = new Application_Model_EuDeviseMapper();
        $results = $m_dev->fetchAll();
        $data = array();
        foreach ($results as $value) {
            $data[] = $value->getCode_dev();
        }
        $this->view->data = $data;
    }

    public function convertirAction() {
        $dev = $_GET['dev'];
        $dev1 = $_GET['dev1'];
        if ($dev != $dev1) {
            if ($dev != $dev1) {
                $code_cours = $dev . '-' . $dev1;
                $cours = new Application_Model_EuCours();
                $m_cours = new Application_Model_EuCoursMapper();
                $ret = $m_cours->find($code_cours, $cours);
                if ($ret) {
                    $mont_credit = $_GET['credit'];
                    if ($mont_credit != '') {
                        $data = $mont_credit * $cours->getVal_dev_fin();
                    }
                } else {
                    $data = false;
                }
            }
        }
        $this->view->data = $data;
    }

    public function membreAction() {
        $request = $this->getRequest();
        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAllByType($request->type);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $this->view->data = $membres;
    }

    public function compteAction() {
        $membre = $_GET['membre'];
        $compte = $_GET['compte'];
        $cat = $_GET['cat'];
        try {
            if ($membre != '' && $cat != '') {
                if ($compte != '') {
                    if ($compte != 'cnp') {
                        $produit = $cat . $compte;
                    } else {
                        $produit = $cat . '%';
                    }
                } else {
                    $produit = $cat;
                }
                $t_produit = new Application_Model_DbTable_EuCompteCredit();
                $select = $t_produit->select();
                $select->from($t_produit, array('sum(montant_credit) as somme'));
                $select->where('code_membre = ?', $membre)
                        ->where('code_compte like ?', 'nb%')
                        ->where('code_produit like ?', $produit);
                $result = $t_produit->fetchAll($select);
                if (count($result) > 0) {
                    $row = $result->current();
                    $this->view->data = $row->somme;
                } else {
                    $this->view->data = 0;
                }
            } else {
                $this->view->data = 0;
            }
        } catch (Exception $exc) {
            $this->view->data = $exc->getMessage();
        }
    }




    public function traiterAction() {
	
        //$this->view->message = "Cet interface n'est plus utilisé. Utilisez plutôt l'interface du client Marchand";
        //return;
        $request = $this->getRequest();
        //$form = new Application_Form_EuConsommation();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
            $membre = $request->acheteur;
            $vendeur = $request->vendeur;
            $montant = $request->montant;
            $prod = $request->compte;
            $type_compte = $request->type_compte;
            $dev = $request->dev_conso;

            $db = Zend_Db_Table::getDefaultAdapter();
            $date = new Zend_Date(Zend_Date::ISO_8601);
            $date_deb = $date;
            $db->beginTransaction();
            try {
                //vérification de l'existence du membre apporteur
                $m_membre = new Application_Model_EuMembreMapper();
                $membre_acheteur = new Application_Model_EuMembre();
                $membre_vendeur = new Application_Model_EuMembre();
                $retour = $m_membre->find($membre, $membre_acheteur);
                if (!$retour) {
                    $db->rollback();
                    $this->view->message = "l'acheteur n'existe pas";
                    return;
                }

                //vérification de l'existence du membre distributeur
                $retour1 = $m_membre->find($vendeur, $membre_vendeur);
                if (!$retour1) {
                    $db->rollback();
                    $this->view->message = "Le Vendeur n'existe pas";
                    return;
                }

                if ($vendeur == $membre) {
                    $db->rollback();
                    $this->view->message = "Vous ne pouvez pas vendre à vous même";
                    return;
                }

                //Vérification des comptes
                if ($prod == 'cnp') {
                    if (substr($membre, -1) == 'P') {
                        $produit = 'RPG%';
                        $code_cat = "TPAGCRPG";
                    } else {
                        $produit = 'I%';
                        $code_cat = "TPAGCI";
                    }
                } elseif ($prod == 'r') {
                    if (substr($membre, -1) == 'P') {
                        $produit = 'RPGr';
                        $code_cat = "TPAGCRPG";
                    } else {
                        $produit = 'Ir';
                        $code_cat = "TPAGCI";
                    }
                } else {
                    if (substr($membre, -1) == 'P') {
                        $produit = 'RPGnr';
                        $code_cat = "TPAGCRPG";
                    } else {
                        $produit = 'Inr';
                        $code_cat = "TPAGCI";
                    }
                }
				
                $t_produit = new Application_Model_DbTable_EuCompteCredit();
                $select = $t_produit->select();
                $select->from($t_produit, array('sum(montant_credit) as somme'));
                $select->where('code_membre = ?', $membre)
                        ->where('code_compte like ?', 'NB%')
                        ->where('code_produit like ?', $produit);
                $result = $t_produit->fetchAll($select);
                $row = $result->current();
                if ($row['somme'] < $montant) {
                    $db->rollback();
                    $this->view->message = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cet achat";
                    return;
                }

                $m_credit = new Application_Model_EuCompteCreditMapper();
                $m_ccredit = new Application_Model_EuCreditConsommerMapper();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $mapper = new Application_Model_EuOperationMapper();
                $compte = new Application_Model_EuCompte();
                $te_mapper = new Application_Model_EuTegcMapper();
                $te = new Application_Model_EuTegc();

                //Enregistrement dans le compte gcp
                try {

                    if ($dev != 'XOF') {
                        $code_cours = $dev . '-XOF';
                        $cours = new Application_Model_EuCours();
                        $m_cours = new Application_Model_EuCoursMapper();
                        $ret = $m_cours->find($code_cours, $cours);
                        if ($ret) {
                            if ($montant != '') {
                                $montant = $montant * $cours->getVal_dev_fin();
                            }
                        }
                    }
                    $filiere = $membre_vendeur->getCode_GAC_Filiere();
                    $tegc = 'TEGCP' . $filiere . $vendeur;
                    $ret_te = $te_mapper->find($tegc, $te);
                    if ($ret_te) {
                        $te->setMontant($te->getMontant() + $montant);
                        $te_mapper->update($te);
                    } else {
                        $this->view->message = "Votre te n'est pas bien configuré. s'adressez à l'administrateur de système : " . $tegc;
                        return;
                    }

                    $v_num_compte = 'NB-' . 'TPAGCP-' . $vendeur;
                    $ret = $cm_mapper->find($v_num_compte, $compte);
                    if ($ret) {
                        $compte->setSolde($compte->getSolde() + $montant);
                        $cm_mapper->update($compte);
                    } else {
                        $compte->setCode_membre($vendeur)
                                ->setCode_cat('TPAGCP')
                                ->setSolde($montant)
                                ->setDate_alloc($date_deb->toString('yyyy-mm-dd hh:mm:ss'))
                                ->setCode_compte($v_num_compte)
                                ->setLib_compte('GCP')
                                ->setDesactiver(0);
                        $cm_mapper->save($compte);
                    }

                    //Enregistrement de l'opération
                    $compteur = $mapper->findConuter() + 1;
                    $place = new Application_Model_EuOperation();
                    $place->setId_operation($compteur)
                            ->setDate_op($date_deb->toString('yyyy-mm-dd'))
                            ->setHeure_op($date_deb->toString('hh:mm:ss'))
                            ->setId_utilisateur($user->id_utilisateur)
                            ->setCode_membre($membre)
                            ->setMontant_op($montant)
                            ->setCode_produit($type_compte)
                            ->setLib_op('Consommation')
                            ->setType_op('Conso')
                            ->setCode_cat($code_cat);
                    $mapper->save($place);
                } catch (Exception $exc) {
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    $db->rollback();
                    return;
                }
                $credits = $m_credit->findCreditByCompte($membre_acheteur->getCode_membre(), $produit);
                if ($credits != null) {
                    $j = 0;
                    $reste = $montant;
                    $nbre_credit = count($credits);
                    while ($reste > 0 && $j < $nbre_credit) {
                        $credit = $credits[$j];
                        $id = $credit->getId_credit();
                        if ($reste > $credit->getMontant_credit()) {
                            //Mise à jour des credits consommés
                            $credit_conso = new Application_Model_EuCreditConsommer();
                            $credit_conso->setId_credit($credit->getId_credit())
                                    ->setId_operation($compteur)
                                    ->setCode_produit($credit->getCode_produit())
                                    ->setCode_compte($credit->getCode_compte())
                                    ->setCode_membre($membre)
                                    ->setCode_membre_dist($vendeur)
                                    ->setMont_consommation($credit->getMontant_credit())
                                    ->setDate_consommation($date_deb->toString('yyyy-mm-dd'))
                                    ->setHeure_consommation($date_deb->toString('hh:mm:ss'));
                            $m_ccredit->save($credit_conso);


                            //Mise à jour du compte marchand
                            $cm_mapper->find($credit->getCode_compte(), $compte);
                            $compte->setSolde($compte->getSolde() - $credit->getMontant_credit());
                            $cm_mapper->update($compte);

                            // Création du cncs correspondant au smc
                            $capa = Util_Utils::getCapaByCredit($credit->getId_credit());
                            $smc = new Application_Model_EuSmc();
                            $m_smc = new Application_Model_EuSmcMapper();
                            $smc->setId_credit($credit->getId_credit())
                                    ->setDate_smc($date_deb->toString('yyyy-mm-dd hh:mm:ss'))
                                    ->setMontant($credit->getMontant_credit())
                                    ->setEntree(0)
                                    ->setSortie(0)
                                    ->setSolde(0)
                                    ->setSource_credit($credit->getSource())
                                    ->setMontant_solde($credit->getMontant_credit())
                                    ->setOrigine_smc(0);
                            if (strpos($credit->getCode_produit(), 'nr') !== false) {
                                $smc->setType_smc('CNCSnr');
                            } else {
                                $smc->setType_smc('CNCSr');
                            }
                            if (strpos($credit->getCompte_source(), "nr-tsci") !== false) {
                                $smc->setCode_smcipn($credit->getId_operation());
                            }
                            if ($capa == null) {
                                $smc->setCode_capa(null);
                            } else {
                                $smc->setCode_capa($capa->code_capa);
                            }
                            $m_smc->save($smc);

                            // Enregistrement dans la table gcsc
                            $t_smcipn = new Application_Model_DbTable_EuSmcipn();
                            $query = $t_smcipn->select();
                            $query->where('code_membre = ?', $vendeur)
                                    ->where('rembourser = ?', 0)
                                    ->where('domicilier = ?', 0);
                            $results = $t_smcipn->fetchAll($query);
                            if (count($results) > 0) {
                                $row_smc = $results->current();
                                $m_gcsc = new Application_Model_EuGcscMapper();
                                $gcsc = $m_gcsc->findByMembreAndSmcipn($vendeur, $row_smc->code_smcipn);
                                if ($gcsc != null) {
                                    $gcsc->setCredit($gcsc->getCredit() + $credit->getMontant_credit())
                                         ->setSolde($gcsc->getSolde() - $credit->getMontant_credit());
                                    $m_gcsc->update($gcsc);
                                }
                            } else {
                                $gcp = new Application_Model_EuGcp();
                                $gcp_mapper = new Application_Model_EuGcpMapper();
                                $gcp->setCode_tegc($tegc)
                                        ->setId_credit($credit->getId_credit())
                                        ->setSource($credit->getSource())
                                        ->setDate_conso($date->toString('yyyy-mm-dd hh:mm:ss'))
                                        ->setCode_membre($vendeur)
                                        ->setCode_cat($code_cat)
                                        ->setMont_gcp($credit->getMontant_credit())
                                        ->setMont_preleve(0)
                                        ->setReste($credit->getMontant_credit());
                                $gcp_mapper->save($gcp);
                            }

                            //Mise à jour du compte crédit
                            $reste = $reste - $credit->getMontant_credit();
                            $credit->setMontant_credit(0);
                            $m_credit->update($credit);
                        } else {

                            //Mise à jour des credits consommés
                            $credit_conso = new Application_Model_EuCreditConsommer();
                            $credit_conso->setId_credit($credit->getId_credit())
                                    ->setId_operation($compteur)
                                    ->setCode_produit($credit->getCode_produit())
                                    ->setCode_compte($credit->getCode_compte())
                                    ->setCode_membre($membre)
                                    ->setCode_membre_dist($vendeur)
                                    ->setMont_consommation($reste)
                                    ->setDate_consommation($date_deb->toString('yyyy-mm-dd'))
                                    ->setHeure_consommation($date_id->toString('hh:mm:ss'));
                            $m_ccredit->save($credit_conso);

                            //Mise à jour du compte crédit
                            $credit->setMontant_credit($credit->getMontant_credit() - $reste);
                            $m_credit->update($credit);

                            //Mise à jour du compte marchand
                            $cm_mapper->find($credit->getCode_compte(), $compte);
                            $compte->setSolde($compte->getSolde() - $reste);
                            $cm_mapper->update($compte);

                            // Création du cncs correspondant au smc
                            $capa = Util_Utils::getCapaByCredit($credit->getId_credit());
                            $smc = new Application_Model_EuSmc();
                            $m_smc = new Application_Model_EuSmcMapper();
                            $smc->setId_credit($credit->getId_credit())
                                    ->setDate_smc($date_deb->toString('yyyy-mm-dd hh:mm:ss'))
                                    ->setMontant($reste)
                                    ->setEntree(0)
                                    ->setSortie(0)
                                    ->setSolde(0)
                                    ->setSource_credit($credit->getSource())
                                    ->setMontant_solde($reste)
                                    ->setOrigine_smc(0);
                            if (strpos($credit->getCode_produit(), 'nr') !== false) {
                                $smc->setType_smc('CNCSnr');
                            } else {
                                $smc->setType_smc('CNCSr');
                            }
                            if (strpos($credit->getCompte_source(), "NR-TSCI") !== false) {
                                $smc->setCode_smcipn($credit->getCode_bnp());
                            }
                            if ($capa == null) {
                                $smc->setCode_capa(null);
                            } else {
                                $smc->setCode_capa($capa->code_capa);
                            }
                            $m_smc->save($smc);

                            // Enregistrement dans la table gcp
                            $t_smcipn = new Application_Model_DbTable_EuSmcipn();
                            $query = $t_smcipn->select();
                            $query->where('code_membre = ?', $vendeur)
                                    ->where('rembourser = ?', 0)
                                    ->where('domicilier = ?', 0);
                            $results = $t_smcipn->fetchAll($query);
                            if (count($results) > 0) {
                                $row_smc = $results->current();
                                $m_gcsc = new Application_Model_EuGcscMapper();
                                $gcsc = $m_gcsc->findByMembreAndSmcipn($vendeur, $row_smc->code_smcipn);
                                if ($gcsc != null) {
                                    $gcsc->setCredit($gcsc->getCredit() + $reste)
                                            ->setSolde($gcsc->getSolde() - $reste);
                                    $m_gcsc->update($gcsc);
                                }
                            } else {
                                $gcp = new Application_Model_EuGcp();
                                $gcp_mapper = new Application_Model_EuGcpMapper();
                                $gcp->setCode_tegc($tegc)
                                        ->setId_credit($credit->getId_credit())
                                        ->setSource($credit->getSource())
                                        ->setDate_conso($date->toString('yyyy-mm-dd hh:mm:ss'))
                                        ->setCode_membre($vendeur)
                                        ->setCode_cat($code_cat)
                                        ->setMont_gcp($reste)
                                        ->setMont_preleve(0)
                                        ->setReste($reste);
                                $gcp_mapper->save($gcp);
                            }
                            $reste = 0;
                        }
                        $j++;
                    }
                } else {
                    $this->view->message = "Il n'y a pas de credit correspondant à ce compte " . $produit;
                    $db->rollback();
                    return;
                }
                $db->commit();
                $this->view->message = true;
                return;
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $id . $e->getMessage() . ' ' . $e->getTraceAsString();
                return $this->view->message = $message;
            }
        }
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[0] = strtoupper($result->nom_membre);
            $data[1] = ucfirst($result->prenom_membre);
            if ($result->type_membre == 'M') {
                $data[2] = $result->raison_sociale;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function newAction() {
        if (!$this->getRequest()->isPost()) {
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $this->view->dist = $user->code_membre;
            $membre = new Application_Model_EuMembre();
            $mem_map = new Application_Model_EuMembreMapper();
            $ret = $mem_map->find($user->code_membre, $membre);
            if ($ret) {
                $this->view->pl_raison = $membre->getRaison_sociale();
            }
        }
    }


    public function newgcscAction() {
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->view->dist = $user->code_membre;
        if ($request->isPost()) {
            $membre = $request->acheteur;
            $vendeur = $request->vendeur;
            $montant = $request->montant;
            $comptes = $request->compte;
            $db = Zend_Db_Table::getDefaultAdapter();
            $date = new Zend_Date(Zend_Date::ISO_8601);
            $date_deb = $date;
            $db->beginTransaction();
            try {
                if ($vendeur == $membre) {
                   $this->view->message = "Vous ne pouvez pas vendre à vous même";
                   return;
                }
                //vérification de l'existence du membre apporteur
                $m_membre = new Application_Model_EuMembreMapper();
                $o_membre = new Application_Model_EuMembre();
                $retour = $m_membre->find($membre,$o_membre);
                if (!$retour) {
                    $this->view->message = "l'acheteur " . $membre . " n'existe pas";
                    $this->view->membre = $membre;
                    $this->view->dist = $vendeur;
                    $this->view->montant = $montant;
                    $this->view->comptes = $comptes;
                    return;
                }

                //vérification de l'existence du membre bénéficiaire
                $retour1 = $m_membre->find($vendeur, $o_membre);
                if (!$retour1) {
                    $this->view->message = "Le Vendeur n'existe pas";
                    $this->view->membre = $membre;
                    $this->view->dist = $vendeur;
                    $this->view->montant = $montant;
                    $this->view->comptes = $comptes;
                    return;
                }

                $t_produit = new Application_Model_DbTable_EuCompteCredit();
                $select = $t_produit->select();
                $select->from($t_produit, array('sum(montant_credit) as somme'));
                $select->where('code_membre = ?', $membre)
                        ->where('code_compte like ?', 'NB%')
                        ->where('code_produit in (?)', $comptes);
                $result = $t_produit->fetchAll($select);
                $row = $result->current();

                if ($row['somme'] < $montant) {
                    $this->view->message = "Votre crédit total est insuffisant pour effectuer cet achat : " . $row['somme'];
                    $this->view->membre = $membre;
                    $this->view->dist = $vendeur;
                    $this->view->montant = $montant;
                    $this->view->comptes = $comptes;
                    return;
                }

                // Vérifier si le membre a obtenu de la subvention au gcsc
                $t_smcipn = new Application_Model_DbTable_EuSmcipn();
                $query = $t_smcipn->select();
                $query->where('code_membre = ?', $vendeur)
                        ->where('rembourser = ?', 0)
                        ->where('domicilier = ?', 0);
                $results = $t_smcipn->fetchAll($query);
                $row_smc = null;
                if (count($results) == 0) {
                    $db->rollback();
                    $this->view->message = "Vous n'avez pas de subventions, vendez plutôt sur votre tegcp ";
                    $this->view->membre = $membre;
                    $this->view->dist = $vendeur;
                    $this->view->montant = $montant;
                    $this->view->comptes = $comptes;
                    return;
                } else {
                    $row_smc = $results->current();
                }

                $m_credit = new Application_Model_EuCompteCreditMapper();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $mapper = new Application_Model_EuOperationMapper();
                $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                $compte = new Application_Model_EuCompte();
                $reste = $montant;

                $credits = $m_credit->fetchByProduits($comptes);
                if ($credits != null && count($credits) >= 1) {
                    $j = 0;
                    $nbre_credit = count($credits);
                    while ($reste > 0 && $j < $nbre_credit) {
                        $credit = $credits[$j];
                        if ($reste > $credit->getMontant_credit()) {

                            //Enregistrement de l'opération
                            $count = $mapper->findConuter() + 1;
                            $place = new Application_Model_EuOperation();
                            $place->setId_operation($count)
                                    ->setDate_op($date_deb->toString('yyyy-mm-dd'))
                                    ->setHeure_op($date_deb->toString('hh:mm:ss'))
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCode_membre($membre)
                                    ->setMontant_op($credit->getMontant_credit())
                                    ->setCode_produit($credit->getCode_produit())
                                    ->setLib_op('Consommation')
                                    ->setType_op('Conso')
                                    ->setCode_cat('GCSC');
                            $mapper->save($place);

                            //Mise à jour du compte marchand
                            $cm_mapper->find($credit->getNum_compte(), $compte);
                            $compte->setDebit($compte->getDebit() + $credit->getMontant_credit());
                            $compte->setSolde($compte->getSolde() - $credit->getMontant_credit());
                            $cm_mapper->update($compte);
							
                            // Création du cncs correspondant au smc
                            $smc = new Application_Model_EuSmc();
                            $m_smc = new Application_Model_EuSmcMapper();
                            $smc->setCode_capa($credit->getCode_capa())
                                ->setId_credit($credit->getId_credit())
                                ->setDate_smc($date_deb->toString('yyyy-mm-dd hh:mm:ss'))
                                ->setMontant($credit->getMontant_credit())
                                ->setEntree(0)
                                ->setSortie(0)
                                ->setSolde(0)
                                ->setSource_credit($credit->getSource())
                                ->setMontant_solde($credit->getMontant_credit());
                            if (strpos($credit->getProduit(), 'nr') !== false) {
                                $smc->setType_smc('CNCSnr');
                            } else {
                                $smc->setType_smc('CNCSr');
                            }
                            $m_smc->save($smc);

							
                            // Enregistrement dans la table gcsc
                            $row_smc = $results->current();
                            $m_gcsc = new Application_Model_EuGcscMapper();
                            $gcsc = $m_gcsc->findByMembreAndSmcipn($vendeur, $row_smc->code_smcipn);
                            if ($gcsc != null) {
                                $gcsc->setCredit($gcsc->getCredit() + $montant)
                                     ->setSolde($gcsc->getSolde() + $montant);
                                $m_gcsc->update($gcsc);
                            }

                            $reste = $reste - $credit->getMontant_credit();
                            $credit->setMontant_credit(0);
                            $m_credit->update($credit);
                        } else {
						
                            // Enregistrement de l'opération
                            $count = $mapper->findConuter() + 1;
                            $place = new Application_Model_EuOperation();
                            $place->setId_operation($count)
                                  ->setDate_op($date_deb->toString('yyyy-mm-dd'))
                                  ->setHeure_op($date_deb->toString('hh:mm:ss'))
                                  ->setId_utilisateur($user->id_utilisateur)
                                  ->setCode_membre($membre)
                                  ->setMontant_op($reste)
                                  ->setCode_produit($credit->getCode_produit())
                                  ->setLib_op('Consommation')
                                  ->setType_op('Conso')
                                  ->setCode_cat('GCSC');
                            $mapper->save($place);

                            $credit->setMontant_credit($credit->getMontant_credit() - $reste);
                            $m_credit->update($credit);
							
                            //Mise à jour du compte marchand
                            $cm_mapper->find($credit->getCode_compte(), $compte);
                            $compte->setSolde($compte->getSolde() - $reste);
                            $cm_mapper->update($compte);
							
                            // Création du cncs correspondant au smc
                            $smc = new Application_Model_EuSmc();
                            $m_smc = new Application_Model_EuSmcMapper();
                            $smc->setCode_capa($credit->getCode_capa())
                                    ->setId_credit($credit->getCodecredi())
                                    ->setDate_smc($date_deb->toString('yyyy-mm-dd hh:mm:ss'))
                                    ->setMontant($reste)
                                    ->setEntree(0)
                                    ->setSortie(0)
                                    ->setSolde(0)
                                    ->setSource_credit($credit->getSource())
                                    ->setMontant_solde($reste);
                            if (strpos($credit->getProduit(), 'nr') !== false) {
                                $smc->setType_smc('CNCSnr');
                            } else {
                                $smc->setType_smc('CNCSr');
                            }
                            $m_smc->save($smc);
							
                            // Enregistrement dans la table gcsc
                            $row_smc = $results->current();
                            $m_gcsc = new Application_Model_EuGcscMapper();
                            $gcsc = $m_gcsc->findByMembreAndSmcipn($vendeur, $row_smc->code_smcipn);
                            if ($gcsc != null) {
                                $gcsc->setCredit($gcsc->getCredit() + $reste);
                                $gcsc->setSolde($gcsc->getSolde() + $reste);
                                $m_gcsc->update($gcsc);
                            }
                            $reste = 0;
                        }
                        $j++;
                    }
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . ": " . $exc->getTraceAsString();
                $this->view->membre = $membre;
                $this->view->dist = $vendeur;
                $this->view->montant = $montant;
                $this->view->comptes = $comptes;
                return;
            }
        }
    }

    public function echangeAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_ech = $this->_request->getParam("date_conso");
        $tabela = new Application_Model_DbTable_EuEchange();
        $select = $tabela->select();
		$type_membre = Util_Utils::getMembreType($user->code_membre);
                            if ($type_membre == 'p') {
        $select->where('eu_echange.code_membre like ?', $user->code_membre);
                            } else {
        $select->where('eu_echange.code_membre_morale like ?', $user->code_membre);
                            }
        if ($date_ech != '') {
            $date_exp = explode('/', $date_ech);
            $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('date_echange = ?', $date);
        }
        $select->order('date_echange asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $tot_ech = 0;
        $tot_agio = 0;
        foreach ($achats as $row) {
            //$date_op = new Zend_Date($row->date_echange, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
                $row->date_echange,
                $row->type_echange,
                $row->cat_echange,
                $row->code_produit,
                $row->montant,
                $row->agio,
                $row->code_compte_obt
            );
            $tot_ech += $row->montant;
            $tot_agio += $row->agio;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_ech;
        $responce['userdata']['agio'] = $tot_agio;
        $responce['userdata']['code_produit'] = 'Totaux:';
        $this->view->data = $responce;
    }

    public function consultAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_gcp');
        $sord = $this->_request->getParam("sord", 'asc');
        $date = $this->_request->getParam("date_conso");
        //$objet = $this->_request->getParam("objet");
        $tabela = new Application_Model_DbTable_EuGcp();
        $select = $tabela->select()->setIntegrityCheck(false);
        $select->from($tabela, array('id_gcp','date_conso', 'mont_gcp', 'mont_preleve', 'reste', 'code_cat', 'id_credit'))
               ->join('eu_compte_credit', 'eu_compte_credit.id_credit = eu_gcp.id_credit', array('code_membre', 'code_produit'))
               ->where('eu_gcp.code_membre like ?',$user->code_membre);
			   
            /*if ($date != '' || $date != null) {
		    $date1 = explode('/', $date);
		    $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
		    $select->where("to_date(eu_gcp.date_conso, 'yyyy-mm-dd') <= ?", Util_Utils::toDate_bis($dated));
            }*/
		    //$select->where("eu_gcp.code_produit = ?", $objet);
		
        $select->order('eu_gcp.date_conso','desc')
                ->order('eu_gcp.reste', 'desc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
           $page = $total_pages;
           $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $tot_prel = 0;
        $tot_gcp = 0;
        $tot_reste = 0;
        foreach ($achats as $row) {
            //$date_op = new Zend_Date($row->date_conso, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_gcp;
            $responce['rows'][$i]['cell'] = array(
                //$date_op->toString('dd/mm/yyyy'),
				$row->date_conso,
                $row->code_membre,
                $row->code_cat,
                $row->id_credit,
                $row->code_produit,
                $row->mont_gcp,
                $row->mont_preleve,
                $row->reste
            );
            $tot_prel += $row->mont_preleve; 
            $tot_gcp += $row->mont_gcp; 
            $tot_reste += $row->reste;
            $i++;
        }
        $responce['userdata']['mont_preleve'] = $tot_prel; 
        $responce['userdata']['mont_gcp'] = $tot_gcp;
        $responce['userdata']['reste'] = $tot_reste; 
        $responce['userdata']['code_membre'] = 'Totaux:';
        $this->view->data = $responce ;//$select->__toString();
    }

    public function tpagcpAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_tpagcp');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select();
        $select->where('code_membre like ?', $user->code_membre);
        $select->order(array('date_deb asc', 'solde desc'));
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $tot_tranche = 0;
        $tot_gcp = 0;
        $tot_echu = 0;
        $tot_escompte = 0;
        $tot_echange = 0;
        $tot_solde = 0;
        foreach ($achats as $row) {
            //$datedeb = new Zend_Date($row->date_deb, Zend_Date::ISO_8601);
            //$datefin = new Zend_Date($row->date_fin, Zend_Date::ISO_8601);
            //$datedebt = new Zend_Date($row->date_deb_tranche, Zend_Date::ISO_8601);
            //$datefint = new Zend_Date($row->date_fin_tranche, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_tpagcp;
            $responce['rows'][$i]['cell'] = array(
                $row->id_tpagcp,
                $row->code_membre,
                $row->code_compte,
                $row->mont_gcp,
                $row->date_deb,
                $row->date_fin,
                $row->mont_tranche,
                $row->date_deb_tranche,
                $row->date_fin_tranche,
                $row->mont_echu,
                $row->mont_escompte,
                $row->mont_echange,
                $row->solde
            );
            $tot_tranche += $row->mont_tranche; 
            $tot_gcp += $row->mont_gcp;
            $tot_echange += $row->mont_echange;
            $tot_escompte += $row->mont_escompte; 
            $tot_solde += $row->solde;
            $tot_echu += $row->mont_echu;
            $i++;
        }
        $responce['userdata']['mont_tranche'] = $tot_tranche; 
        $responce['userdata']['mont_gcp'] = $tot_gcp;
        $responce['userdata']['mont_escompte'] = $tot_escompte;
        $responce['userdata']['mont_echange'] = $tot_echange;
        $responce['userdata']['mont_echu'] = $tot_echu;  
        $responce['userdata']['solde'] = $tot_solde; 
        $responce['userdata']['code_membre'] = 'Totaux:';
        $this->view->data = $responce;
    }

    public function escomptesAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_escompte');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuEscompte();
        $select = $tabela->select();
        $select->where('code_membre like ?', $user->code_membre);
        $select->order('date_deb', 'asc')
                ->order('solde', 'desc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        $tot_mont = 0;
        foreach ($achats as $row) {
            $responce['rows'][$i]['id'] = $row->id_escompte;
            $responce['rows'][$i]['cell'] = array(
                $row->id_escompte,
                $row->date_escompte,
                $row->code_membre,
                $row->montant,
                $row->code_membre_benef,
                $row->id_echange
            );
            $tot_mont += $row->montant;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_mont;
        $responce['userdata']['code_membre'] = 'Totaux:';
        $this->view->data = $responce;
    }

    public function gcpAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        //Enregistrement dans le compte gcp
        $v_num_compte = 'NB-'.'TPAGCP-'.$user->code_membre;
        $retour = $cm_mapper->find($v_num_compte, $compte);
        if ($retour) {
           $this->view->solde = $compte->getSolde();
        }
    }

    public function tegcAction() {
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->view->dist = $user->code_membre;
        if ($request->isPost()) {
            $dist = $request->te_distributeur;
            $gac_filiere = $request->te_gac_filiere;
            $mdv = $request->te_mdv;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $te_mapper = new Application_Model_EuTegcMapper();
                $te = new Application_Model_EuTegc();
                $te->setCode_tegc('TEGCP' . $gac_filiere . $dist)
                        ->setCode_gac_filiere($gac_filiere)
                        ->setMdv($mdv)
                        ->setCode_membre($dist)
                        ->setMontant(0);
                $te_mapper->save($te);
                $db->commit();
                $this->_helper->redirector('index', 'eu-consommation', null, array('controller' => 'eu-consommation', 'action' => 'index'));
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->dist = $dist;
                $this->view->gac = $gac_filiere;
                $this->view->mdv = $mdv;
                $this->view->message = "Erreur de configuration :" . $exc->getMessage() . '->' . $exc->getTraceAsString();
                return;
            }
        }
    }

    public function gacfiliereAction() {
        $gcfiliere = new Application_Model_EuGacFiliereMapper();
        $resultsets = $gcfiliere->fetchAll();
        $rows = array();
        $i = 0;
        foreach ($resultsets as $res) {
            $rows[$i][0] = $res->getCode_gac_filiere();
            $rows[$i][1] = $res->getNom_gac_filiere();
            $i++;
        }
        return $this->view->data = $rows;
    }

    public function mdvAction() {
        $request = $this->getRequest();
        $gac = $request->filiere;
        $tparam = new Application_Model_DbTable_EuParametres();
        $select_pck = $tparam->select();
        $select_pck->where('code_param = ?', 'pck')
                ->where('lib_param = ?', 'nr');
        $rows_pck = $tparam->fetchAll($select_pck);
        if (count($rows_pck) > 0) {
            $produit = $rows_pck->current();
            $pck = $produit->montant;
        }
        $tvbps = new Application_Model_DbTable_EuMdv();
        $select = $tvbps->select();
        $select->where('code_gac_filiere = ?', $gac);
        $resultSet = $tvbps->fetchAll($select);
        if (count($resultSet) == 0) {
            $this->view->data = $pck;
        } else {
            $mdv = $resultSet->current()->duree_vie;
            if ($mdv < $pck) {
                $this->view->data = $pck;
            } else {
                $this->view->data = $mdv;
            }
        }
    }



    public function preleverAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $montant = $_GET['montant'];
		$te_code = new Application_Model_EuTegc();
        $num_compte = 'NB-TPAGCP-' . $user->code_membre;
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $tpagcp = new Application_Model_EuTpagcp();
        $map_tpagcp = new Application_Model_EuTpagcpMapper();
        $te_mapper = new Application_Model_EuTegcMapper();
        $te = new Application_Model_EuTegc();
		$te_mapper->findByMembre($user->code_membre,$te_code);
		$tegcp = $te_code->getCode_tegc();
        $gcp_preleve_mapper = new Application_Model_EuGcpPreleverMapper();
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $m_acteur = new Application_Model_EuActeurCreneauMapper();
            $m_gac = new Application_Model_EuGacMapper();
            $acteur = $m_acteur->findActeurByMembre($user->code_membre);
            $gac = $m_gac->findGacByMembre($user->code_membre);
            if ($acteur == null && $gac == null) {
                $this->view->message = 'Ce membre ne possede pas de contrat de distributeurs!!!';
                $db->rollback();
                return;
            } else {
                $retour = $cm_mapper->find($num_compte, $compte);
                if ($retour && ($compte->getSolde() >= $montant)) {
                   $mapper = new Application_Model_EuOperationMapper();
                   $compteur = $mapper->findConuter() + 1;
                   $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                   $date_deb = clone $date_fin;
                   $place = new Application_Model_EuOperation();
                   $place->setId_operation($compteur)
                         ->setMontant_op($montant)
                         ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                         ->setHeure_op($date_deb->toString('HH:mm:ss'))
                         ->setId_utilisateur($user->id_utilisateur)
                         ->setLib_op('Prélevement du GCP')
                         ->setType_op('PGCP')
                         ->setCode_produit('GCP')
                         ->setCode_cat('TPAGCP');
							
							$type_membre = Util_Utils::getMembreType($user->code_membre);
                            if ($type_membre == 'P') {
                                $place->setCode_membre($user->code_membre);
                            } else {
                                $place->setCode_membre_morale($user->code_membre);
                            }
							
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
                        $te->setMontant($te->getMontant() - $montant);
                        $te_mapper->update($te);

                        $periode = Util_Utils::getParametre('periode', 'valeur');
                    	$date_fin->addDay($mdv * $periode);
						
						$date_fin_tranche->addDay($periode);
					
                        $tpagcp->setId_tpagcp($id_tpagcp)
							   ->setCode_tegc($tegcp)
                               ->setCode_compte($compte->getCode_compte())
                               ->setDate_deb($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
                               ->setCode_membre($user->code_membre)
                               ->setMont_gcp($montant)
                               ->setNtf(round($mdv))
                               ->setMont_tranche(round($tpagcp->getMont_gcp() / $tpagcp->getNtf()))
                               ->setDate_fin($date_fin->toString('yyyy-MM-dd HH:mm:ss'))
                               ->setMont_echu(0)
                               ->setDate_deb_tranche($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
                               ->setPeriode($periode)
                               ->setDate_fin_tranche($date_fin_tranche->toString('yyyy-MM-dd HH:mm:ss'))
                               ->setSolde($montant)
                               ->setMont_escompte(0)
							   ->setMont_echange(0)
                               ->setReste_ntf($tpagcp->getNtf());
                        $map_tpagcp->save($tpagcp);
                    }
                    $gcp_mapper = new Application_Model_EuGcpMapper();
                    try {
                        $gcps = $gcp_mapper->findGcpByTegcp($tegcp);
                        if (count($gcps) > 0) {
                            $j = 0;
                            while ($montant > 0 && $j < count($gcps)) {
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
                                                ->setCode_membre($user->code_membre)
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
                                                ->setCode_membre($user->code_membre)
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
                            $this->view->message = 'Ce membre ne possede pas de gcp !!!';
                            $db->rollback();
                            return;
                        }
                    } catch (Exception $exc) {
                        $db->rollback();
                        $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        return;
                    }
                    $db->commit();
                } else {
                       $this->view->message = 'Le solde de ce compte est insuffisant pour effectuer cette operation!!!';
                       $db->rollback();
                       return;
                }
                return true;
            }
        } catch (Exception $exc) {
            $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
            $db->rollback();
            return;
        }
    }

}