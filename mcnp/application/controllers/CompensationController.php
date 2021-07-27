<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompensationController
 *
 * @author user
 */
class CompensationController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $menu = '';
        if ($user->code_groupe == 'nn_tegcp_pbf') {
            $menu = '<li><a href="/compensation/cgcp">Compte GCp</a></li>
                <li><a href="/compensation/gcpechu">Payement GCp echu</a></li>
                <li><a href="/compensation/affecter">Affectaction du GCp</a></li>';
        }
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'nn_tegcp_pbf') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    //public function dataAction(){}

    public function membreAction() {
        //$request = $this->getRequest();
        $m_map = new Application_Model_EuMembreMoraleMapper();
        $rows = $m_map->fetchAllByType('M');
        $membres = array();
        foreach ($rows as $c) {
          $membres[] = $c->code_membre_morale;
        }
        $this->view->data = $membres;
    }

    public function gcppbfAction() {
        $membre = $_GET["membre"];
        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($membre);
        if (count($membre_find) == 1) {
            $data = array();
            $result = $membre_find->current();
            $data[0] = strtoupper($result->nom_membre);
            $data[1] = ucfirst($result->prenom_membre);
            if ($result->type_membre == 'm') {
                $data[2] = $result->raison_sociale;
            }
            $t_gcp_pbf = new Application_Model_DbTable_EuGcpPbf();
            $select = $t_gcp_pbf->select();
            $select->from($t_gcp_pbf, array('code_membre', 'sum(mont_gcp) as gcp', 'sum(solde_gcp) as solde', 'sum(solde_gcp_REEL) as soldeR', 'sum(solde_agio) as agio'));
            $select->where('code_membre = ?', $membre)
                    ->group('code_membre');
            $results = $t_gcp_pbf->fetchAll($select);
            if (count($results) > 0) {
                $gcp_pbf = $results->current();
                $data[3] = $gcp_pbf->solde;
                $data[4] = $gcp_pbf->solder;
                $data[5] = $gcp_pbf->agio;
            }
            $this->view->data = $data;
        } else {
            $this->view->data = false;
        }
    }

    public function detsmsAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_detail_smsmoney');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuDetailSmsmoney();
        $select = $tabela->select();
        $select->where('code_membre like ?', $user->code_membre)
                ->where('solde_sms > 0');
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
        $tot_vendu = 0;
        $tot_solde = 0;
        foreach ($achats as $row) {
            $datealloc = new Zend_Date($row->date_allocation, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_detail_smsmoney;
            $responce['rows'][$i]['cell'] = array(
                $row->id_detail_smsmoney,
                $datealloc->toString('dd/mm/yyyy'),
                $row->code_membre,
                $row->code_membre_dist,
                $row->mont_sms,
                $row->mont_vendu,
                $row->solde_sms,
                $row->creditcode
            );
            $tot_mont += $row->mont_sms;
            $tot_vendu += $row->mont_vendu;
            $tot_solde += $row->solde_sms;
            $i++;
        }
        $responce['userdata']['mont_sms'] = $tot_mont;
        $responce['userdata']['mont_vendu'] = $tot_vendu;
        $responce['userdata']['solde_sms'] = $tot_solde;
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
        $select->where('code_membre_benef like ?', $user->code_membre)
                ->where('solde > 0');
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
        $tot_tranche = 0;
        $tot_echu = 0;
        $tot_solde = 0;
        foreach ($achats as $row) {
		    $date_escompte = new Zend_Date($row->date_escompte, Zend_Date::ISO_8601);
            $datedeb = new Zend_Date($row->date_deb, Zend_Date::ISO_8601);
            $datefin = new Zend_Date($row->date_fin, Zend_Date::ISO_8601);
            $datedebt = new Zend_Date($row->date_deb_tranche, Zend_Date::ISO_8601);
            $datefint = new Zend_Date($row->date_fin_tranche, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_escompte;
            $responce['rows'][$i]['cell'] = array(
                $row->id_escompte,
                $row->code_compte,
				$date_escompte->toString('dd/mm/yyyy'),
                $datedeb->toString('dd/mm/yyyy'),
                $row->montant,
                $row->reste_ntf,
                $datefin->toString('dd/mm/yyyy'),
                $row->mont_tranche,
                $datedebt->toString('dd/mm/yyyy'),
                $datefint->toString('dd/mm/yyyy'),
                $row->mont_echu,
                $row->solde
            );
            $tot_mont += $row->montant;
            $tot_tranche += $row->mont_tranche;
            $tot_echu += $row->mont_echu;
            $tot_solde += $row->solde;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_mont;
        $responce['userdata']['mont_tranche'] = $tot_tranche;
        $responce['userdata']['mont_echu'] = $tot_echu;
        $responce['userdata']['solde'] = $tot_solde;
        //$responce['userdata']['code_membre'] = 'Totaux:';
        $this->view->data = $responce;
    }

    public function transfertAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $escompte = new Application_Model_EuEscompte();
        $esc_mapper = new Application_Model_EuEscompteMapper();
        $e = new Application_Model_EuEchange();
        $me = new Application_Model_EuEchangeMapper();
        $compte = new Application_Model_EuCompte();
        $cm_map = new Application_Model_EuCompteMapper();
        $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
        $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
        $detail = new Application_Model_EuDetailGcpPbf();
        $cc = new Application_Model_EuCompteCredit();
        $cc_mapper = new Application_Model_EuCompteCreditMapper();
        $escomptes = $_GET["escptes"];
        if (count($escomptes) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $date_deb = new Zend_Date(Zend_Date::ISO_8601);
            $db->beginTransaction();
            try {
                $pck = Util_Utils::getParametre('pck', 'nr');
                $prk = Util_Utils::getParametre('prk', 'nr');
                $periode = Util_Utils::getParametre('periode', 'valeur');
                for ($i = 0; $i < count($escomptes); $i++) {
                    $ret = $esc_mapper->find($escomptes[$i], $escompte);
                    if ($ret && $escompte->getMont_echu() > 0) {
                        $agio = $escompte->getMont_echu() - (($escompte->getMont_echu() * $pck / $prk));
                        $mont_gcp = $escompte->getMont_echu() + $agio;
                        $num_cpte = 'NB-TPAGCP-' . $user->code_membre;
                        $result = $cm_map->find($num_cpte, $compte);
                        if (!$result) {
                            $compte->setCode_membre($user->code_membre)
                                    ->setDesactiver(0)
                                    ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                    ->setCode_compte($num_cpte)
                                    ->setLib_compte('GCP PBF')
                                    ->setCode_cat('tpagcp')
                                    ->setCode_type_compte("NB")
                                    ->setSolde($mont_gcp);
                            $cm_map->save($compte);
                        } else {
                            $compte->setSolde($compte->getSolde() + $mont_gcp);
                            $cm_map->update($compte);
                        }
                        // Création du gcp pbf selon le type d'echange
                        if ($escompte->getId_echange() != null && $escompte->getId_echange() != '') {
                            $ret_e = $me->find($escompte->getId_echange(), $e);
                            if ($ret_e) {
                                $gcp_pbf = new Application_Model_EuGcpPbf();
                                $type_capa = 'capagcp';
                                $code_gcp_pbf = "gcp-gcp-" . $user->code_membre;
                                $ret_pbf = $m_gcp_pbf->find($code_gcp_pbf, $gcp_pbf);
                                if (!$ret_pbf) {
                                    $gcp_pbf->setCode_gcp_pbf($code_gcp_pbf)
                                            ->setAgio_consomme(0)
                                            ->setMont_agio($agio)
                                            ->setGcp_compense(0)
                                            ->setMont_gcp($escompte->getMont_echu() + $agio)
                                            ->setMont_gcp_reel($escompte->getMont_echu())
                                            ->setCode_membre($user->code_membre)
                                            ->setCode_compte($num_cpte)
                                            ->setSolde_agio($agio)
                                            ->setSolde_gcp($escompte->getMont_echu() + $agio)
                                            ->setSolde_gcp_reel($escompte->getMont_echu())->setType_capa($type_capa);
                                    $m_gcp_pbf->save($gcp_pbf);
                                } else {
                                    $gcp_pbf->setSolde_agio($gcp_pbf->getSolde_agio() + $agio)
                                            ->setSolde_gcp($gcp_pbf->getSolde_gcp() + $escompte->getMont_echu() + $agio)
                                            ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() + $escompte->getMont_echu())
                                            ->setMont_agio($gcp_pbf->getMont_agio() + $agio)
                                            ->setMont_gcp($gcp_pbf->getMont_gcp() + $escompte->getMont_echu() + $agio)
                                            ->setMont_gcp_reel($gcp_pbf->getMont_gcp_reel() + $escompte->getMont_echu());
                                    $m_gcp_pbf->update($gcp_pbf);
                                }
                                $detail = new Application_Model_EuDetailGcpPbf();
                                $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                                $select = $tcredit_ech->select();
                                $select->where('id_echange = ?', $e->getId_echange());
                                $ce_results = $tcredit_ech->fetchAll($select);
                                if (count($ce_results) > 0) {
                                    $deduction = $escompte->getMont_echu();
                                    $mont_deduit = 0;
                                    foreach ($ce_results as $value) {
                                        if ($value->mont_echange < $deduction) {
                                            $mont_deduit = $value->mont_echange;
                                        } else {
                                            $mont_deduit = $deduction;
                                        }
                                        $ret_ce = $cc_mapper->find($value->id_credit, $cc);
                                        if ($ret_ce) {
                                            $detail->setCode_gcp_pbf($code_gcp_pbf)
                                                    ->setMont_gcp_pbf($mont_deduit)
                                                    ->setMont_preleve(0)
                                                    ->setSolde_gcp_pbf($mont_deduit)
                                                    ->setId_credit($cc->getId_credit())
                                                    ->setSource_credit($value->source_credit)
                                                    ->setAgio($value->agio);
                                            if ($cc->getCode_produit() == 'Inr' or $cc->getCode_produit() == 'Ir') {
                                                $detail->setType_capa('fgi');
                                            } elseif ($cc->getCode_produit() == 'RPGnr' or $cc->getCode_produit() == 'RPGr') {
                                                $detail->setType_capa('fgrpg');
                                            } elseif ($cc->getCode_produit() == 'CNCSnr') {
                                                $detail->setType_capa('FGCNCSnr');
                                            } elseif ($cc->getCode_produit() == 'CNCSr') {
                                                $detail->setType_capa('FGCNCSr');
                                            }
                                            $t_detail->insert($detail->toArray());
                                        } else {
                                            $db->rollback();
                                            $this->view->data = "Pas de crédits associés à cet echange !!!";
                                            return;
                                        }
                                        $deduction = $deduction - $mont_deduit;
                                        if ($deduction <= 0) {
                                            break;
                                        }
                                    }
                                } else {
                                    $db->rollback();
                                    $this->view->data = "Il n'y a pas de listes de crédits associés à cet echange !!!";
                                    return;
                                }

                                //Compensation
                                $nbre_compens = $escompte->getMont_echu() / $escompte->getMont_tranche();
                                for ($j = 0; $j < $nbre_compens; $j++) {
                                    $date = Zend_Date::now();
                                    $compens_map = new Application_Model_EuCompensationMapper();
                                    $compens = new Application_Model_EuCompensation();
                                    $date_escompte = new Zend_Date($escompte->getDate_deb(), Zend_Date::ISO_8601);
                                    $date_deb_compens = $date_escompte->addDay($periode * ($j + 1));
                                    $date_fin_compens = clone $date_deb_compens;
                                    $date_fin_tranche = clone $date_deb_compens;
                                    $date_echu = $date->sub($date_deb_compens);
                                    $nbre_echu = floor(($date_echu->get() / (60 * 60 * 24)) / 30);
                                    $mont_tranche = floor($escompte->getMont_tranche() / $escompte->getNtf());
                                    $mont_echu = $mont_tranche * $nbre_echu;
                                    $compens->setCode_membre_benef($user->code_membre)
                                            ->setCode_membre_pbf($user->code_membre)
                                            ->setCode_compte($num_cpte)
                                            ->setDate_deb($date_deb_compens->toString('yyyy-mm-dd'))
                                            ->setDate_deb_tranche($date_deb_compens->toString('yyyy-mm-dd'))
                                            ->setMont_compens($escompte->getMont_tranche())
                                            ->setNtf($escompte->getNtf())
                                            ->setMont_tranche($mont_tranche)
                                            ->setMont_echu($mont_echu)
                                            ->setMont_tranche($mont_tranche)
                                            ->setHeure_compens($date->toString('hh:mm:ss'))
                                            ->setDate_compens($date->toString('yyyy-mm-dd'))
                                            ->setId_operation($escompte->getId_escompte())
                                            ->setSolde_compensation($compens->getMont_compens() - $compens->getMont_echu())->setDate_fin_tranche($date_fin_tranche->addDay(30 * ($nbre_echu + 1))->toString('yyyy-mm-dd'))->setDate_fin($date_fin_compens->addDay(30 * $escompte->getNtf())->toString('yyyy-mm-dd'))
                                            ->setPeriode($periode)->setReste_ntf($escompte->getNtf() - $nbre_echu);
                                    $compens_map->save($compens);
                                    $id_compens = $db->lastInsertId();

                                    //Mise à jour des gcp pbf et ses détails 
                                    $agio_tranche = $escompte->getMont_tranche() - (($escompte->getMont_tranche() * $pck / $prk));
                                    $mont_gcp_tranche = $escompte->getMont_tranche() + $agio_tranche;
                                    $gcpbf = new Application_Model_EuGcpPbf();
                                    $ret_gcp = $m_gcp_pbf->find($code_gcp_pbf, $gcpbf);
                                    if ($ret_gcp) {
                                        //Mise à jour du gcp pbf
                                        $gcpbf->setAgio_consomme($gcpbf->getAgio_comsomme() + $agio_tranche)
                                                ->setSolde_agio($gcpbf->getSolde_agio() - $agio_tranche)->setGcp_compense($gcpbf->getGcp_compense() + $mont_gcp_tranche)
                                                ->setSolde_gcp_reel($gcpbf->getSolde_gcp_reel() - $escompte->getMont_tranche())->setSolde_gcp($gcpbf->getSolde_gcp() - $mont_gcp_tranche);
                                        $m_gcp_pbf->update($gcpbf);

                                        $mont_a_deduire = $mont_gcp_tranche;
                                        //Mise à jour des détails gcp pbf
                                        $tcgcp = new Application_Model_DbTable_EuGcpPbfCompense();
                                        $cgcp = new Application_Model_EuGcpPbfCompense();
                                        $select = $t_detail->select();
                                        $select->where('code_gcp_pbf = ?', $gcpbf->getCode_gcp_pbf())
                                                ->where('solde_gcp_pbf > 0');
                                        $ce_results = $t_detail->fetchAll($select);
                                        if (count($ce_results) > 0) {
                                            foreach ($ce_results as $value) {
                                                $detail->exchangeArray($value);
                                                if ($detail->getSolde_gcp_pbf() < $mont_a_deduire) {
                                                    $mont_a_deduire = $mont_a_deduire - $detail->getSolde_gcp_pbf();

                                                    $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                            ->setCode_compte($num_cpte)
                                                            ->setMont_gcp_entree($detail->getSolde_gcp_pbf())
                                                            ->setType_capa_gcp($detail->getType_capa())->setSolde_compens($detail->getSolde_gcp_pbf())->setId_compens($id_compens);
                                                    $tcgcp->insert($cgcp->toArray());

                                                    $detail->setMont_preleve($detail->getMont_preleve() + $detail->getSolde_gcp_pbf())->setSolde_gcp_pbf(0);
                                                    $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));
                                                } else {
                                                    $detail->setMont_preleve($detail->getMont_preleve() + $mont_a_deduire)->setSolde_gcp_pbf(0);
                                                    $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));

                                                    $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                            ->setCode_compte($num_cpte)
                                                            ->setMont_gcp_entree($mont_a_deduire)
                                                            ->setType_capa_gcp($detail->getType_capa())
                                                            ->setSolde_compens($mont_a_deduire)->setId_compens($id_compens);
                                                    $tcgcp->insert($cgcp->toArray());
                                                    $mont_a_deduire = 0;
                                                }
                                                if ($mont_a_deduire == 0) {
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        $db->rollback();
                                        $this->view->data = 'Ce membre ne possède pas de gcp pbf';
                                        return;
                                    }
                                }

                                $e->setCompenser(1);
                                $me->update($e);
                            } else {
                                $db->rollback();
                                $this->view->data = "Cet escompte n'est pas issu d'un echange valide!!!";
                                return;
                            }
                        }
                        $escompte->setMont_echu_transferer($escompte->getMont_echu_transferer() + $escompte->getMont_echu())
                                ->setMont_echu(0);
                        $esc_mapper->update($escompte);
                        $this->view->data = true;
                        $db->commit();
                        return;
                    } else {
                        $this->view->data = "Cet escompte n° $escomptes[$i] est invalide !!!";
                        $db->rollback();
                        return;
                    }
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->data = $exc->getMessage() . ' -> ' . $exc->getTraceAsString();
                return;
            }
        } else {
            $db->rollback();
            $this->view->data = "Pas de sélections d\'escomptes!!!";
            return;
        }
    }

    public function cgcpAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $fg_mapper = new Application_Model_EuFgfnMapper();
        $fg = new Application_Model_EuFgfn ( );
        //Enregistrement dans le compte gcp
        $v_num_compte = 'NB-' . 'TPAGCP-' . $user->code_membre;
        $fgfn = 'FGFN-' . $user->code_membre;
        $retour = $cm_mapper->find($v_num_compte, $compte);
        if ($retour) {
            $this->view->solde = $compte->getSolde();
        }
        $ret = $fg_mapper->find($fgfn, $fg);

        if ($ret) {
            $this->view->solde_fgfn = $fg->getSolde_fgfn();
        }
    }

    public function smsmoneyAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'NEng');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_ech = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $type_ech = $this->_request->getParam("type");
        $type_capa = $this->_request->getParam("capa");
        $tabela = new Application_Model_DbTable_EuSmsmoney ( );
        $select = $tabela->select();
        $select->where('FromAccount like ?', 'nn-tr-' . $user->code_membre);
        if ($date_ech != '' && $date_fin == '') {
            $date = Util_Utils:: convertDated($date_ech, '/');
            $select->where('str_to_date(DateTimeConsumed,"%d/%m/%y") >= ?', $date);
        } elseif ($date_ech == '' && $date_fin != '') {
            $date = Util_Utils:: convertDated($date_fin, '/');
            $select->where('str_to_date(DateTimeConsumed,"%d/%m/%y") <= ?', $date);
        } elseif ($date_ech != '' && $date_fin != '') {
            $dated = Util_Utils::convertDated($date_ech, '/');
            $datef = Util_Utils:: convertDated($date_fin, '/');
            $select->where('str_to_date(DateTimeConsumed,"%d/%m/%y") >= ?', $dated)
                    ->where('str_to_date(DateTimeConsumed,"%d/%m/%y") <= ?', $datef);
        }
        if ($type_ech != '') {
            $select->where('Motif like ?', $type_ech);
        }
        if ($type_capa != '') {
            $select->where('DestAccount_Consumed like ?', '%' . $type_capa . '%');
        }
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
            $responce['rows'][$i]['id'] = $row->NEng;
            $responce['rows'][$i]['cell'] = array(
                $row->NEng,
                $row->DateTime,
                $row->FromAccount,
                $row->SentTo,
                $row->CreditAmount,
                $row->Motif,
                $row->DateTimeConsumed,
                $row->DestAccount_Consumed,
                $row->CodeAgence,
                $row->
                Utilisateur
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function pbfAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_gcp_pbf');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuGcpPbf ();
        $select = $tabela->select();
        $select->where('code_membre like ?', $user->code_membre)
                ->where('solde_gcp > 0');
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
        $tot_gcp = 0;
        $tot_gcp_reel = 0;
        $tot_agio = 0;
        $tot_gcp_comp = 0;
        $tot_agio_cons = 0;
        $tot_solde_reel = 0;
        $tot_solde_agio = 0;
        $tot_solde = 0;
        foreach ($achats as $row) {
            if ($row->type_capa == 'capacncs') {
                $type = 'cncs';
            } elseif ($row->type_capa == 'capagcp') {
                $type = 'gcp';
            } else {
                $type = 'rpg/i';
            }
            $responce['rows'][$i]['id'] = $row->code_gcp_pbf;
            $responce['rows'][$i]['cell'] = array(
                $row->code_gcp_pbf,
                $row->code_membre,
                $type,
                $row->mont_gcp,
                $row->mont_gcp_reel,
                $row->mont_agio,
                $row->gcp_compense,
                $row->agio_consomme,
                $row->solde_gcp_reel,
                $row->solde_agio,
                $row->solde_gcp
            );
            $tot_gcp += $row->mont_gcp;
            $tot_gcp_reel += $row->mont_gcp_reel;
            $tot_agio += $row->mont_agio;
            $tot_gcp_comp += $row->gcp_compense;
            $tot_agio_cons += $row->agio_consomme;
            $tot_solde_reel += $row->solde_gcp_reel;
            $tot_solde_agio += $row->solde_agio;
            $tot_solde += $row->solde_gcp;
            $i++;
        }
        $responce['userdata']['mont_gcp'] = $tot_gcp;
        $responce['userdata']['mont_gcp_reel'] = $tot_gcp_reel;
        $responce['userdata']['gcp_compense'] = $tot_gcp_comp;
        $responce['userdata']['solde_gcp'] = $tot_solde;
        $responce['userdata']['mont_agio'] = $tot_agio;
        $responce['userdata']['agio_consomme'] = $tot_agio_cons;
        $responce['userdata']['solde_agio'] = $tot_solde_agio;
        $responce[
                'userdata']['solde_gcp_reel'] = $tot_solde_reel;
        $this->view->data = $responce;
    }

    public function consultAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_ech = $this->_request->getParam("date_conso");
        $reg = $this->_request->getParam("regler");
        $t_user = new Application_Model_DbTable_EuUtilisateur ();
        $u_select = $t_user->select();
        $u_select->where('code_membre like ?', $user->code_membre)
                ->where('code_groupe in (?)', array('banque', 'echange_nn'));
        $results = $t_user->fetchAll($u_select);
        if (count($results) > 0) {
            $ids = array();
            foreach ($results as $value) {
                $ids[] = $value->id_utilisateur;
            }
            $tabela = new Application_Model_DbTable_EuEchange();
            $select = $tabela->select();
            $select->where('eu_echange.id_utilisateur in (?)', $ids);
            if ($date_ech != '') {
                $date_exp = explode('/', $date_ech);
                $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
                $select->where('date_echange = ?', $date);
            }
            if ($reg != '' && $reg == 1) {
                $select->where('regler = ?', $reg);
            } elseif ($reg != '' && $reg == 0) {
                $select->where('regler is null');
            }
            $select->order('date_echange', 'asc');
            $achats = $tabela->fetchAll($select);
        }
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
        $tot_echange = 0;
        $tot_agio = 0;
        foreach ($achats as $row) {
            $date_op = new Zend_Date($row->date_echange, Zend_Date::ISO_8601);
            if ($row->date_reglement != null) {
                $date1 = new Zend_Date($row->date_reglement, Zend_Date::ISO_8601);
                $date_reg = $date1->toString('dd/mm/yyyy');
            } else {
                $date_reg = '';
            }
            if ($row->regler == 1) {
                $regler = 'oui';
            } else {
                $regler = 'non';
            }
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
                $date_op->toString('dd/mm/yyyy'),
                $row->cat_echange,
                $row->code_produit,
                $row->montant,
                $row->agio,
                $regler,
                $date_reg
            );
            $tot_echange += $row->montant;
            $tot_agio += $row->agio;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_echange;

        $responce['userdata']['agio'] = $tot_agio;
        $this->view->data = $responce;
    }

    public function echangesAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_ech = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $type_ech = $this->_request->getParam("type");
        $t_user = new Application_Model_DbTable_EuUtilisateur ();
        $u_select = $t_user->select();
        $u_select->where('code_membre like ?', $user->code_membre)
                ->where('code_groupe in (?)', array('banque', 'echange_nn'));
        $results = $t_user->fetchAll($u_select);
        if (count($results) > 0) {
            $ids = array();
            foreach ($results as $value) {
                $ids[] = $value->id_utilisateur;
            }
            $tabela = new Application_Model_DbTable_EuEchange();
            $select = $tabela->select();
            $select->where('eu_echange.id_utilisateur in (?)', $ids)->where('compenser like ?', 0)
                    ->where('type_echange in (?)', array('nr/nn', 'nb/nn'))
                    ->where('regler is not null');
            if ($date_ech != '' && $date_fin == '') {
                $date = Util_Utils::convertDated($date_ech, '/');
                $select->where('date_echange >= ?', $date);
            } elseif ($date_ech == '' && $date_fin != '') {
                $date = Util_Utils::convertDated($date_fin, '/');
                $select->where('date_echange <= ?', $date);
            } elseif ($date_ech != '' && $date_fin != '') {
                $dated = Util_Utils::convertDated($date_ech, '/');
                $datef = Util_Utils::convertDated($date_fin, '/');
                $select->where('date_echange >= ?', $dated)
                        ->where('date_echange <= ?', $datef);
            }
            if ($type_ech != '') {
                $select->where('cat_echange = ?', $type_ech);
            } else {
                $select->where('cat_echange in (?)', array('cncs', 'Inr', 'RPGnr'));
            }
            $select->order('date_echange', 'asc');
            $achats = $tabela->fetchAll($select);
        }
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
        $tot_echange = 0;
        $tot_agio = 0;
        foreach ($achats as $row) {
            $date_op = new Zend_Date($row->date_echange, Zend_Date::ISO_8601);
            if ($row->date_reglement != null) {
                $date1 = new Zend_Date($row->date_reglement, Zend_Date::ISO_8601);
                $date_reg = $date1->toString('dd/mm/yyyy');
            } else {
                $date_reg = '';
            }
            if ($row->regler == 1) {
                $regler = 'oui';
            } else {
                $regler = 'non';
            }
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
                $date_op->toString('dd/mm/yyyy'),
                $row->cat_echange,
                $row->code_produit,
                $row->montant,
                $row->agio,
                $regler,
                $date_reg
            );
            $tot_echange += $row->montant;
            $tot_agio += $row->agio;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_echange;
        $responce['userdata']['agio'] = $tot_agio;

        $this->view->data = $responce;
        //$this->view->data = $select->__toString();
    }

    public function datafgfnAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_fgfn');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_fg = $this->_request->getParam("date");
        $datef = $this->_request->getParam("datef");
        $type = $this->_request->getParam("type");
        $typep = $this->_request->getParam("typep");
        $tabela = new Application_Model_DbTable_EuDetailFgfn();
        $select = $tabela->select(Zend_Db_Table:: SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_capa', 'eu_detail_fgfn.code_capa = eu_capa.code_capa', array('montant_capa', 'code_produit', 'code_membre'));
        if ($date_fg != '' && $datef == '') {
            $date_exp = explode('/', $date_fg);
            $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('date_fgfn = ?', $date);
        }
        if ($datef != '') {
            $date_fin = Util_Utils::convertDated($datef, '/');
            if ($date_fg != '') {
                $date_deb = Util_Utils::convertDated($date_fg, '/');
                $select->where('date_fgfn > ?', $date_deb)
                        ->where('date_fgfn <= ?', $date_fin);
            } else {
                $date_fin = Util_Utils::convertDated($datef, '/');
                $select->where("date_fgfn < ?", $date_fin);
            }
        }
        if ($type != '') {
            $select->where('eu_detail_fgfn.type_capa = ?', 'capa' . $type);
        }
        if ($typep != '') {
            if ($type != '') {
                $select->where('eu_capa.code_produit like ?', $type . $typep);
            } else {
                $select->where('eu_capa.code_produit like ?', '%' . $typep);
            }
        }
        $select->where('code_membre_pbf = ?', $user->code_membre);
        //$select->order('code_membre_pbf');
        //$select->group('eu_capa.code_produit');
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
        $tot_capa = 0;
        $tot_fgfn = 0;
        $tot_preleve = 0;
        $tot_solde = 0;
        foreach ($achats as $row) {
            $responce['rows'][$i]['id'] = $row->id_fgfn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre_pbf,
                $row->code_capa,
                $row->code_membre,
                $row->code_produit,
                $row->montant_capa,
                $row->id_fgfn,
                $row->date_fgfn,
                $row->mont_fgfn,
                $row->mont_preleve,
                $row->solde_fgfn
            );
            $tot_capa += $row->montant_capa;
            $tot_fgfn += $row->mont_fgfn;
            $tot_preleve += $row->mont_preleve;
            $tot_solde += $row->solde_fgfn;
            $i++;
        }
        $responce['userdata']['code_membre'] = 'Totaux';
        $responce['userdata']['mont_capa'] = $tot_capa;
        $responce['userdata']['mont_fgfn'] = $tot_fgfn;
        $responce['userdata']['mont_preleve'] = $tot_preleve;

        $responce['userdata']['solde_fgfn'] = $tot_solde;
        $this->
                view->data = $responce;
    }

    public function detAction() {
        
    }

    public function detailpbfAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_compens');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCompensation ();
        $select = $tabela->select();
        $select->where('code_membre_pbf like ?', $user->code_membre)
                ->where('solde_compensation > 0');
        $select->order('date_deb', 'asc')
                ->order('solde_compensation', 'desc');
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
        $tot_compens = 0;
        $tot_tranche = 0;
        $tot_echu = 0;
        $tot_solde = 0;
        foreach ($achats as $row) {
            $datedeb = new Zend_Date($row->date_deb, Zend_Date::ISO_8601);
            $datefin = new Zend_Date($row->date_fin, Zend_Date::ISO_8601);
            $datedebt = new Zend_Date($row->date_deb_tranche, Zend_Date::ISO_8601);
            $datefint = new Zend_Date($row->date_fin_tranche, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_compens;
            $responce['rows'][$i]['cell'] = array(
                $row->id_compens,
                $row->date_compens,
                $row->code_compte,
                $row->mont_compens,
                $datedeb->toString('dd/mm/yyyy'),
                $datefin->toString('dd/mm/yyyy'),
                $row->mont_tranche,
                $datedebt->toString('dd/mm/yyyy'),
                $datefint->toString('dd/mm/yyyy'),
                $row->mont_echu,
                $row->solde_compensation
            );
            $tot_compens += $row->mont_compens;
            $tot_echu += $row->mont_echu;
            $tot_tranche += $row->mont_tranche;
            $tot_solde += $row->solde_compensation;
            $i++;
        }
        $responce['userdata']['mont_compens'] = $tot_compens;
        $responce['userdata']['mont_tranche'] = $tot_tranche;
        $responce['userdata']['mont_echu'] = $tot_echu;
        $responce[
                'userdata']['solde_compensation'] = $tot_solde;
        $this->
                view->data = $responce;
    }

    public function domicilierAction() {
        
    }

    public function compensationAction() {
        $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        if ($request->isPost()) {
            $membre_pbf = $request->membre_pbf;
            $montant_gcp = $request->montant_gcp;
            $mont_agio = $request->bonus_pbf;
            $mont_gcpr = $request->mont_gcpr;
            $montant = $request->mont_compens;
            $num_compte = "NB-TPAGCP-" . $membre_pbf;
            $cm_map = new Application_Model_EuCompteMapper();
            $op_mapper = new Application_Model_EuOperationMapper();
            $m_gcp_comp = new Application_Model_EuCompensationMapper();
            $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
            $compte = new Application_Model_EuCompte();
            $date = new Zend_Date(Zend_Date::ISO_8601);
            $date_deb = clone $date;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $ret = $cm_map->find($num_compte, $compte);
                if ($ret) {
                    if ($compte->getSolde() >= $montant) {
                        $solde_reel = 0;
                        $t_gcp_pbf = new Application_Model_DbTable_EuGcpPbf();
                        $select = $t_gcp_pbf->select();
                        $select->from($t_gcp_pbf, array('code_membre', 'sum(mont_gcp) as gcp', 'sum(solde_gcp) as solde', 'sum(solde_gcp_reel) as solder', 'sum(solde_agio) as agio'));
                        $select->where('code_membre = ?', $membre_pbf)
                                ->group('code_membre');
                        $results = $t_gcp_pbf->fetchAll($select);
                        if (count($results) > 0) {
                            $gcp_pbf = $results->current();
                            $solde_reel = $gcp_pbf->solde;
                        }
                        if ($solde_reel >= $montant) {
                            $gcp_pbf = new Application_Model_EuGcpPbf();
                            $gcp_pbfs = $m_gcp_pbf->fetchAllByPbf($membre_pbf);
                            if (count($gcp_pbfs) > 0) {
                                //Enregistrement de l'opération
                                $count = $op_mapper->findConuter() + 1;
                                $place = new Application_Model_EuOperation();
                                $place->setId_operation($count)
                                        ->setDate_op($date_deb->toString('yyyy-mm-dd'))
                                        ->setHeure_op($date_deb->toString('hh:mm'))
                                        ->setId_utilisateur($user->id_utilisateur)
                                        ->setCode_membre($membre_pbf)
                                        ->setMontant_op($montant)
                                        ->setCode_produit('GCP')
                                        ->setLib_op('Conpensation du gcp pbf')
                                        ->setType_op('cpgcp')->setCode_cat('TPAGCP');
                                $op_mapper->save($place);
                            }
                            //Enregistrement de la compensation
                            $compens = new Application_Model_EuCompensation();
                            $compens->setCode_compte($num_compte)
                                    ->setMont_compens($montant)
                                    ->setCode_membre_pbf($membre_pbf)
                                    ->setDate_compens($date_deb->toString('yyyy-mm-dd'))
                                    ->setHeure_compens($date_deb->toString('hh:mm:ss'))
                                    ->setId_operation($count)
                                    ->setNtf(1)
                                    ->setPeriode(0)
                                    ->setDate_deb($date_deb->toString('yyyy-MM_dd'))
                                    ->setDate_fin($date_deb->toString('yyyy-mm-dd'))
                                    ->setMont_tranche($montant)
                                    ->setDate_deb_tranche($date_deb->toString('yyyy-MM_dd'))
                                    ->setDate_fin_tranche($date_deb->toString('yyyy-MM_dd'))
                                    ->setMont_echu($montant)
                                    ->setReste_ntf(0)
                                    ->setCode_membre_benef($user->code_membre)
                                    ->setSolde_compensation(0);
                            $m_gcp_comp->save($compens);
                            $id_compens = $db->lastInsertId();
                            //Mise à jour du gcp
                            $pck = Util_Utils ::getParametre('pck', 'nr');
                            $prk = Util_Utils::getParametre('prk', 'nr');
                            $agio = $montant - round(($montant * $pck) / $prk);
                            $gcp_compens = $montant + $agio;
                            $compte->setSolde($compte->getSolde() - $gcp_compens);
                            $cm_map->update($compte);

                            foreach ($gcp_pbfs as $gcp_pbf) {
                                //Mise à jour du gcp pbf
                                $mont_a_deduire = 0;
                                if ($gcp_pbf->getSolde_gcp() > $gcp_compens) {
                                    $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $agio)->setSolde_agio($gcp_pbf->getSolde_agio() - $agio)
                                            ->setGcp_compense($gcp_pbf->getGcp_compense() + $gcp_compens)
                                            ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() - $montant)
                                            ->setSolde_gcp($gcp_pbf->getSolde_gcp() - $gcp_compens);
                                    $m_gcp_pbf->update($gcp_pbf);
                                    $mont_a_deduire = $gcp_compens;
                                    $gcp_compens = 0;
                                    $agio = 0;
                                } else {
                                    $mont_a_deduire = $gcp_pbf->getSolde_gcp();
                                    $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $gcp_pbf->getSolde_agio())
                                            ->setSolde_agio(0)
                                            ->setGcp_compense($gcp_pbf->getGcp_compense() + $gcp_pbf->getSolde_gcp())
                                            ->setSolde_gcp_reel(0)->setSolde_gcp(0);
                                    $m_gcp_pbf->update($gcp_pbf);
                                    $gcp_compens = $gcp_compens - $gcp_pbf->getSolde_gcp();
                                    $agio = $agio - $gcp_pbf->getSolde_agio();
                                }

                                //Mise à jour des détails gcp pbf
                                $detail = new Application_Model_EuDetailGcpPbf();
                                $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
                                $tcgcp = new Application_Model_DbTable_EuGcpPbfCompense();
                                $cgcp = new Application_Model_EuGcpPbfCompense();
                                $select = $t_detail->select();
                                $select->where('code_gcp_pbf = ?', $gcp_pbf->getCode_gcp_pbf())->where('solde_gcp_pbf > 0');
                                $ce_results = $t_detail->fetchAll($select);
                                if (count($ce_results) > 0) {
                                    foreach ($ce_results as $value) {
                                        $detail->exchangeArray($value);
                                        if ($detail->getSolde_gcp_pbf() < $mont_a_deduire) {
                                            $mont_a_deduire = $mont_a_deduire - $detail->getSolde_gcp_pbf();

                                            $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                    ->setCode_compte($num_compte)
                                                    ->setMont_gcp_entree($detail->getSolde_gcp_pbf())->setType_capa_gcp($detail->getType_capa())
                                                    ->setSolde_compens($detail->getSolde_gcp_pbf())->setId_compens($id_compens);
                                            $tcgcp->insert($cgcp->toArray());

                                            $detail->setMont_preleve($detail->getMont_preleve() + $detail->getSolde_gcp_pbf())->setSolde_gcp_pbf(0);
                                            $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));
                                        } else {
                                            $detail->setMont_preleve($detail->getMont_preleve() + $mont_a_deduire)->setSolde_gcp_pbf(0);
                                            $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));

                                            $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                    ->setCode_compte($num_compte)
                                                    ->setMont_gcp_entree($mont_a_deduire)->setType_capa_gcp($detail->getType_capa())
                                                    ->setSolde_compens($mont_a_deduire)->setId_compens($id_compens);
                                            $tcgcp->insert($cgcp->toArray());
                                            $mont_a_deduire = 0;
                                        }
                                        if ($mont_a_deduire == 0) {
                                            break;
                                        }
                                    }
                                }
                                if ($gcp_compens == 0) {
                                    break;
                                }
                            }
                        } else {
                            $db->rollback();
                            $this->view->membre_pbf = $membre_pbf;
                            $this->view->montant_gcp = $montant_gcp;
                            $this->view->bonus_pbf = $mont_agio;
                            $this->view->mont_gcpr = $mont_gcpr;
                            $this->view->mont_compens = $montant;
                            $this->view->message = 'Ce membre ne possède pas de gcp pbf';
                            return;
                        }
                    } else {
                        $db->rollback();
                        $this->view->membre_pbf = $membre_pbf;
                        $this->view->montant_gcp = $montant_gcp;
                        $this->view->bonus_pbf = $mont_agio;
                        $this->view->mont_gcpr = $mont_gcpr;
                        $this->view->mont_compens = $montant;

                        $this->view->message = 'Ce membre ne possède pas de gcp pbf';
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->membre_pbf = $membre_pbf;
                    $this->view->montant_gcp = $montant_gcp;
                    $this->view->bonus_pbf = $mont_agio;
                    $this->view->mont_gcpr = $mont_gcpr;
                    $this->view->mont_compens = $montant;
                    $this->view->message = 'Le solde de son compte est insuffisant  pour  cet opération';
                    return;
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message =
                        'Erreur :' . $exc->getMessage() . '->' . $exc->getTraceAsString();
            }
        }
    }

    public function calcAction() {
        $gcpr_compens = $_GET["gcpr_compens"];
        if ($gcpr_compens != '') {
            $data = array();
            $prk = ceil(Util_Utils::getParametre('prk', 'nr'));
            $pck = Util_Utils::getParametre('pck', 'nr');
            $marge = $gcpr_compens - round(($gcpr_compens * $pck) / $prk);
            $data[0] = $gcpr_compens + $marge;
            $data[1] = $marge;
            $this->view->data = $data;
        }
    }

    public function compenserAction() {
        $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        if ($request->isPost()) {
            $membre_pbf = $request->membre_pbf;
            $montant_gcp = $request->montant_gcp;
            $mont_agio = $request->bonus_pbf;
            $mont_gcpr = $request->mont_gcpr;
            $montant = $request->mont_compens;
            $gcpr_compens = $request->gcpr_compens;
            $agio_compens = $request->agio_compens;
            if ($agio_compens == '' || $agio_compens == null) {
                $agio_compens = $mont_agio;
            }
            if ($gcpr_compens == '' || $gcpr_compens == null) {
                $gcpr_compens = $mont_gcpr;
            }
            $num_compte = "NB-TPAGCP-" . $membre_pbf;
            $cm_map = new Application_Model_EuCompteMapper();
            $op_mapper = new Application_Model_EuOperationMapper();
            $m_gcp_comp = new Application_Model_EuCompensationMapper();
            $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
            $compte = new Application_Model_EuCompte();
            $date = new Zend_Date(Zend_Date::ISO_8601);
            $date_deb = clone $date;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                if ($mont_gcpr != '') {
                    $prk = ceil(Util_Utils::getParametre('prk', 'nr'));
                    $pck = Util_Utils::getParametre('pck', 'nr');
                    $agio_compens = $gcpr_compens - round(($gcpr_compens * $pck) / $prk);
                    $montant = $gcpr_compens + $agio_compens;
                }
                $ret = $cm_map->find($num_compte, $compte);
                if ($ret) {
                    if ($compte->getSolde() >= $montant) {
                        $gcp_pbf = new Application_Model_EuGcpPbf();
                        $gcp_pbfs = $m_gcp_pbf->fetchAllByPbf($membre_pbf);
                        if (count($gcp_pbfs) > 0) {
                            //Enregistrement de l'opération
                            $count = $op_mapper->findConuter() + 1;
                            $place = new Application_Model_EuOperation();
                            $place->setId_operation($count)
                                    ->setDate_op($date_deb->toString('yyyy-mm-dd'))
                                    ->setHeure_op($date_deb->toString('hh:mm'))
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCode_membre($membre_pbf)
                                    ->setMontant_op($montant)
                                    ->setCode_produit('gcp')
                                    ->setLib_op('Conpensation du gcp pbf')
                                    ->setType_op('CPGCP')
                                    ->setCode_cat('TPAGCP');
                            $op_mapper->save($place);

                            $periode = Util_Utils::getParametre('periode', 'valeur');
                            $datefin_tranche = clone $date;
                            foreach ($gcp_pbfs as $gcp_pbf) {
                                //Mise à jour du gcp pbf
                                $mont_a_deduire = 0;
                                if ($gcp_pbf->getSolde_gcp() > $montant) {
                                    $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $agio_compens)
                                            ->setSolde_agio($gcp_pbf->getSolde_agio() - $agio_compens)
                                            ->setGcp_compense($gcp_pbf->getGcp_compense() + $montant)
                                            ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() - $gcpr_compens)
                                            ->setSolde_gcp($gcp_pbf->getSolde_gcp() - $montant);
                                    $m_gcp_pbf->update($gcp_pbf);
                                    $mont_a_deduire = $montant;
                                    $montant = 0;
                                } else {
                                    $mont_a_deduire = $gcp_pbf->getSolde_gcp();
                                    $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $gcp_pbf->getSolde_agio())
                                            ->setSolde_agio(0)
                                            ->setGcp_compense($gcp_pbf->getGcp_compense() + $gcp_pbf->getSolde_gcp())
                                            ->setSolde_gcp_reel(0)->setSolde_gcp(0);
                                    $m_gcp_pbf->update($gcp_pbf);
                                    $montant = $montant - $gcp_pbf->getSolde_gcp();
                                }

                                //Enregistrement de la compensation
                                if ($gcp_pbf->getType_capa() == 'capacncs') {
                                    $ntf = ceil($prk * $pck);
                                } else {
                                    $ntf = $prk;
                                }
                                $compens = new Application_Model_EuCompensation();
                                $compens->setCode_compte($num_compte)
                                        ->setMont_compens($mont_a_deduire)
                                        ->setCode_membre_pbf($membre_pbf)
                                        ->setDate_compens($date_deb->toString('yyyy-mm-dd'))
                                        ->setHeure_compens($date_deb->toString('hh:mm:ss'))
                                        ->setId_operation($count)
                                        ->setNtf($ntf)
                                        ->setPeriode($periode)
                                        ->setDate_deb($date_deb->toString('yyyy-MM_dd'))
                                        ->setDate_fin($date->addDay($ntf * $periode)->toString('yyyy-mm-dd'))
                                        ->setMont_tranche($mont_a_deduire / $ntf)
                                        ->setDate_deb_tranche($date_deb->toString('yyyy-MM_dd'))
                                        ->setDate_fin_tranche($datefin_tranche->addDay($periode)->toString('yyyy-MM_dd'))
                                        ->setMont_echu(0)
                                        ->setReste_ntf($ntf)
                                        ->setCode_membre_benef($user->code_membre)->setSolde_compensation($montant);
                                $m_gcp_comp->save($compens);
                                $id_compens = $db->lastInsertId();

                                //Mise à jour des détails gcp pbf
                                $detail = new Application_Model_EuDetailGcpPbf();
                                $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
                                $tcgcp = new Application_Model_DbTable_EuGcpPbfCompense();
                                $cgcp = new Application_Model_EuGcpPbfCompense();
                                $select = $t_detail->select();
                                $select->where('code_gcp_pbf = ?', $gcp_pbf->getCode_gcp_pbf())->where('solde_gcp_pbf > 0');
                                $ce_results = $t_detail->fetchAll($select);
                                if (count($ce_results) > 0) {
                                    foreach ($ce_results as $value) {
                                        $detail->exchangeArray($value);
                                        if ($detail->getSolde_gcp_pbf() < $mont_a_deduire) {
                                            $mont_a_deduire = $mont_a_deduire - $detail->getSolde_gcp_pbf();

                                            $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                    ->setCode_compte($num_compte)
                                                    ->setMont_gcp_entree($detail->getSolde_gcp_pbf())->setType_capa_gcp($detail->getType_capa())
                                                    ->setSolde_compens($detail->getSolde_gcp_pbf())->setId_compens($id_compens);
                                            $tcgcp->insert($cgcp->toArray());

                                            $detail->setMont_preleve($detail->getMont_preleve() + $detail->getSolde_gcp_pbf())->setSolde_gcp_pbf(0);
                                            $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));
                                        } else {
                                            $detail->setMont_preleve($detail->getMont_preleve() + $mont_a_deduire)->setSolde_gcp_pbf(0);
                                            $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));

                                            $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                    ->setCode_compte($num_compte)
                                                    ->setMont_gcp_entree($mont_a_deduire)->setType_capa_gcp($detail->getType_capa())
                                                    ->setSolde_compens($mont_a_deduire)->setId_compens($id_compens);
                                            $tcgcp->insert($cgcp->toArray());
                                            $mont_a_deduire = 0;
                                        }
                                        if ($mont_a_deduire == 0) {
                                            break;
                                        }
                                    }
                                }
                                if ($montant == 0) {
                                    break;
                                }
                            }
                            //Mise à jour du gcp
                            $compte->setSolde($compte->getSolde() - $montant);
                            $cm_map->update($compte);
                        } else {
                            $db->rollback();
                            $this->view->membre_pbf = $membre_pbf;
                            $this->view->montant_gcp = $montant_gcp;
                            $this->view->bonus_pbf = $mont_agio;
                            $this->view->mont_gcpr = $mont_gcpr;
                            $this->view->mont_compens = $montant;
                            $this->view->message = 'Ce membre ne possède pas de gcp pbf';
                            return;
                        }
                    } else {
                        $db->rollback();
                        $this->view->membre_pbf = $membre_pbf;
                        $this->view->montant_gcp = $montant_gcp;
                        $this->view->bonus_pbf = $mont_agio;
                        $this->view->mont_gcpr = $mont_gcpr;
                        $this->view->mont_compens = $montant;

                        $this->view->message = 'Ce membre ne possède pas de gcp pbf';
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->membre_pbf = $membre_pbf;
                    $this->view->montant_gcp = $montant_gcp;
                    $this->view->bonus_pbf = $mont_agio;
                    $this->view->mont_gcpr = $mont_gcpr;
                    $this->view->mont_compens = $montant;
                    $this->view->message = 'Le solde de son compte est insuffisant  pour  cet opération';
                    return;
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message =
                        'Erreur :' . $exc->getMessage() . '->' . $exc->getTraceAsString();
            }
        }
    }

    public function compensAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $echange = new Application_Model_EuEchange();
        $ech_mapper = new Application_Model_EuEchangeMapper();
        $compte = new Application_Model_EuCompte();
        $compens_map = new Application_Model_EuCompensationMapper();
        $cm_map = new Application_Model_EuCompteMapper();
        $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
        $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
        $detail = new Application_Model_EuDetailGcpPbf ( );
        $echanges = $_GET["echanges"];
        if (count($echanges) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $prk = ceil(Util_Utils::getParametre('prk', 'nr'));
                $pck = Util_Utils::getParametre('pck', 'nr');
                $periode = Util_Utils::getParametre('periode', 'valeur');
                $i = 0;
                for ($i = 0; $i < count($echanges); $i++) {
                    $ret = $ech_mapper->find($echanges[$i], $echange);
                    if ($ret) {
                        $agio = $echange->getAgio();
                        $mont_gcp = $echange->getMontant_echange() + $agio;
                        $num_cpte = 'NB-TPAGCP-' . $user->code_membre;
                        $result = $cm_map->find($num_cpte, $compte);
                        if ($result) {
                            $compte->setSolde($compte->getSolde() - $mont_gcp);
                            $cm_map->update($compte);
                        } else {
                            $db->rollback();

                            $this->view->data = "Ce compte $num_cpte est invalide!!!";
                            return;
                        }
                        //Enregistrement de la compensation
                        $nbre_tranche = $prk;

                        $date = Zend_Date::now();
                        $compens = new Application_Model_EuCompensation();
                        $date_echange = new Zend_Date($echange->getDate_reglement(), Zend_Date::ISO_8601);
                        $date_fin = new Zend_Date($echange->getDate_reglement(), Zend_Date:: ISO_8601);
                        $date_deb_tranche = new Zend_Date($echange->getDate_reglement(), Zend_Date:: ISO_8601);
                        $date_fin_tranche = new Zend_Date($echange->getDate_reglement(), Zend_Date::ISO_8601);
                        $date_echu = $date->sub($date_echange);
                        $nbre_echu = floor(($date_echu->get() / (60 * 60 * 24)) / 30);
                        $mont_tranche = floor($echange->getMontant_echange() / $nbre_tranche);
                        $mont_echu = $mont_tranche * $nbre_echu;
                        $compens->setCode_membre_benef($user->code_membre)
                                ->setCode_membre_pbf($user->code_membre)
                                ->setCode_compte($num_cpte)
                                ->setDate_deb($echange->getDate_reglement())
                                ->setDate_deb_tranche($date_deb_tranche->addDay(30 * $nbre_echu)->toString('yyyy-mm-dd'))
                                ->setMont_compens($mont_gcp)
                                ->setNtf($nbre_tranche)
                                ->setMont_tranche($mont_tranche)
                                ->setMont_echu($compens->getMont_echu() + $mont_echu)
                                ->setMont_tranche($mont_tranche)
                                ->setHeure_compens($date->toString('hh:mm:ss'))
                                ->setDate_compens($date->toString('yyyy-mm-dd'))
                                ->setId_operation($echange->getId_echange())
                                ->setSolde_compensation($compens->getMont_compens() - $compens->getMont_echu())->setDate_fin_tranche($date_fin_tranche->addDay(30 * ($nbre_echu + 1))->toString('yyyy-mm-dd'))
                                ->setDate_fin($date_fin->addDay(30 * $nbre_tranche)->toString('yyyy-mm-dd'))
                                ->setPeriode($periode)->setReste_ntf($nbre_tranche - $nbre_echu);
                        $compens_map->save($compens);
                        $id_compens = $db->lastInsertId();

                        $gcp_pbf = new Application_Model_EuGcpPbf();
                        if ($echange->getCat_echange() == 'CNCS') {
                            $code_gcp_pbf = 'gcp-cncs-' . $user->code_membre;
                        } elseif ($echange->getCat_echange() == 'RPG') {
                            $code_gcp_pbf = 'gcp-rpg-' . $user->code_membre;
                        } elseif ($echange->getCat_echange() == 'I') {
                            $code_gcp_pbf = 'GCP-I-' . $user->code_membre;
                        } else {
                            $code_gcp_pbf = 'GCP-GCP-' . $user->code_membre;
                        }
                        $ret_gcp = $m_gcp_pbf->find($code_gcp_pbf, $gcp_pbf);
                        if ($ret_gcp) {
                            //Mise à jour du gcp pbf
                            $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $agio)
                                    ->setSolde_agio($gcp_pbf->getSolde_agio() - $agio)->setGcp_compense($gcp_pbf->getGcp_compense() + $mont_gcp)
                                    ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() - $echange->getMontant_echange())->setSolde_gcp($gcp_pbf->getSolde_gcp() - $mont_gcp);
                            $m_gcp_pbf->update($gcp_pbf);

                            $mont_a_deduire = $mont_gcp;
                            //Mise à jour des détails gcp pbf
                            $tcgcp = new Application_Model_DbTable_EuGcpPbfCompense();
                            $cgcp = new Application_Model_EuGcpPbfCompense();
                            $select = $t_detail->select();
                            $select->where('code_gcp_pbf = ?', $gcp_pbf->getCode_gcp_pbf())
                                    ->where('solde_gcp_pbf > 0');
                            $ce_results = $t_detail->fetchAll($select);
                            if (count($ce_results) > 0) {
                                foreach ($ce_results as $value) {
                                    $detail->exchangeArray($value);
                                    if ($detail->getSolde_gcp_pbf() < $mont_a_deduire) {
                                        $mont_a_deduire = $mont_a_deduire - $detail->getSolde_gcp_pbf();

                                        $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                ->setCode_compte($num_cpte)
                                                ->setMont_gcp_entree($detail->getSolde_gcp_pbf())
                                                ->setType_capa_gcp($detail->getType_capa())->setSolde_compens($detail->getSolde_gcp_pbf())->setId_compens($id_compens);
                                        $tcgcp->insert($cgcp->toArray());

                                        $detail->setMont_preleve($detail->getMont_preleve() + $detail->getSolde_gcp_pbf())->setSolde_gcp_pbf(0);
                                        $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));
                                    } else {
                                        $detail->setMont_preleve($detail->getMont_preleve() + $mont_a_deduire)->setSolde_gcp_pbf(0);
                                        $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));

                                        $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                ->setCode_compte($num_cpte)
                                                ->setMont_gcp_entree($mont_a_deduire)
                                                ->setType_capa_gcp($detail->getType_capa())
                                                ->setSolde_compens($mont_a_deduire)->setId_compens($id_compens);
                                        $tcgcp->insert($cgcp->toArray());
                                        $mont_a_deduire = 0;
                                    }
                                    if ($mont_a_deduire == 0) {
                                        break;
                                    }
                                }
                            }
                        } else {
                            $db->rollback();

                            $this->view->data = 'Ce membre ne possède pas de gcp pbf';
                            return;
                        }
                        $echange->setCompenser(1);
                        $ech_mapper->update($echange);
                    } else {
                        $this->view->data = "Cet echange est invalide !!! " . $echanges[$i];
                        $db->rollback();
                        return;
                    }
                }
                $this->view->data = true;
                $db->commit();
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->data = $exc->getMessage();
                return;
            }
        } else {
            $db->rollback();

            $this->view->data = "Pas de sélections d\'escomptes!!!";
            return;
        }
    }

    public function escompteeAction() {
        $escompte = new Application_Model_EuEscompte();
        $esc_mapper = new Application_Model_EuEscompteMapper ( );
        $escomptes = $_GET["escomptes"];
        if (count($escomptes) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $i = 0;
                for ($i = 0; $i < count($escomptes); $i++) {
                    $ret = $esc_mapper->find($escomptes[$i], $escompte);
                    if ($ret) {
                        $date = Zend_Date::now();
                        $date_deb = new Zend_Date($escompte->getDate_deb_tranche(), Zend_Date::ISO_8601);
                        $date_fin = new Zend_Date($escompte->getDate_fin_tranche(), Zend_Date::ISO_8601);
                        $date_echu = $date->sub($date_deb);
                        $nbre_echu = floor(($date_echu->get() / (60 * 60 * 24)) / 30);
                        if ($nbre_echu >= 1) {
                            $mont_echu = $escompte->getMont_tranche() * $nbre_echu;
                            $escompte->setMont_echu($escompte->getMont_echu() + $mont_echu)
                                    ->setDate_deb_tranche($date_deb->addDay(30 * $nbre_echu)->toString('yyyy-mm-dd'))
                                    ->setDate_fin_tranche($date_fin->addDay(30 * $nbre_echu)->toString('yyyy-mm-dd'))
                                    ->setReste_ntf($escompte->getNtf() - $nbre_echu)
                                    ->setSolde($escompte->getSolde() - $escompte->getMont_echu());
                            $esc_mapper->update($escompte);
                        }
                    } else {
                        $db->rollback();
                        $this->view->data = "Escompte invalide ou n'existe pas!!!";
                        return;
                    }
                }
                $this->view->data = true;
                $db->commit();
                return;
            } catch (Exception $ex) {
                $db->rollback();
                $this->view->data = $ex->getMesssage();
                return;
            }
        } else {
            $db->rollback();
            $this->view->data = "Pas de sélections d\'escomptes!!!";
            return;
        }
    }

    public function affecterAction() {
        $request = $this->getRequest();
        $date = Zend_Date::now();
        if ($request->isPost()) {
            $membre = $request->pbf;
            $compte_gcp = $request->compte_gcp;
            $mont_compte = $request->mont_compte;
            $solde_gcpr = $request->solde_gcpr;
            $num_compte = "nb-tpagcp-" . $membre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $cm_map = new Application_Model_EuCompteMapper();
                $compte = new Application_Model_EuCompte();
                $ret = $cm_map->find($num_compte, $compte);
                $prk = Util_Utils::getParametre('prk', 'nr');
                $pck = Util_Utils::getParametre('pck', 'nr');
                $agio_consomme = $mont_compte - ($mont_compte * $pck) / $prk;
                $mont_gcp = $mont_compte + $agio_consomme;
                if ($ret) {
                    if ($compte->getSolde() >= $mont_gcp) {
                        if ($compte_gcp == 'CNCS') {
                            $num_new_compte = 'NR-TCNCSEI-' . $membre;
                            $code_cat = 'TCNCSEI';
                        } else {
                            $num_new_compte = 'NR-TSCI-' . $membre;
                            $code_cat = 'TSCI';
                        }
                        $ccompte = new Application_Model_EuCompte();
                        $ret_cncs = $cm_map->find($num_new_compte, $ccompte);
                        if (!$ret_cncs) {
                            $ccompte->setCode_cat($code_cat)
                                    ->setCode_type_compte('NR')
                                    ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                    ->setDesactiver(0)
                                    ->setLib_compte($code_cat)
                                    ->setCode_compte($num_new_compte)
                                    ->setCode_membre($membre)
                                    ->setSolde($mont_gcp);
                            $cm_map->save($ccompte);
                        } else {
                            $ccompte->setSolde($ccompte->getSolde() + $mont_gcp);
                            $cm_map->update($ccompte);
                        }

                        $compte_credit = new Application_Model_EuCompteCredit();
                        $cc_mapper = new Application_Model_EuCompteCreditMapper();
                        $source = $membre . $date->toString('yyyyMMddHHmmss');
                        $max_code = $cc_mapper->findConuter() + 1;
                        $date_fin = clone $date;
                        $date_fin->addDay(30);
                        $compte_credit->setId_credit($max_code)
                                ->setCode_membre($membre)
                                ->setCode_produit($compte_gcp . 'r')
                                ->setMontant_place($mont_gcp)
                                ->setDatedeb($date->toString('yyyy-mm-dd'))
                                ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                ->setDate_octroi($date->toString('yyyy-mm-dd'))
                                ->setSource($source)
                                ->setCode_compte($num_new_compte)
                                ->setId_operation($max_code)
                                ->setCompte_source($num_compte)
                                ->setRenouveller('N')
                                ->setKrr('N')->setBnp(0)
                                ->setDomicilier(0)
                                ->setMontant_credit($mont_gcp)
                                ->setAffecter(0);
                        $cc_mapper->save($compte_credit);
                        if ($compte_gcp == 'cncs') {
                            // Création du cncs correspondant au smc
                            $smc = new Application_Model_EuSmc();
                            $m_smc = new Application_Model_EuSmcMapper();
                            $smc->setCode_capa(null)
                                    ->setId_credit($max_code)
                                    ->setDate_smc($date->toString('yyyy-mm-dd'))
                                    ->setMontant($mont_gcp)
                                    ->setEntree(0)
                                    ->setSortie(0)
                                    ->setSolde(0)
                                    ->setSource_credit($source)
                                    ->setMontant_solde($mont_compte)
                                    ->setType_smc('CNCSr')
                                    ->setCode_smcipn(null)
                                    ->setOrigine_smc(1);
                            $m_smc->save($smc);
                        } else {
                            $fn = new Application_Model_EuFn();
                            $m_fn = new Application_Model_EuFnMapper();
                            $fn->setCode_capa(null)
                                    ->setDate_fn($date->toString('yyyy-mm-dd'))
                                    ->setType_fn('Inr')
                                    ->setMontant($mont_compte)
                                    ->setSortie($mont_compte)
                                    ->setEntree(0)
                                    ->setSolde(0)
                                    ->setMt_solde(0);
                            $m_fn->save($fn);
                        }
                        //mise à jour du compte gcp escompte du pbf
                        $compte->setSolde($compte->getSolde() - $mont_gcp);
                        $cm_map->update($compte);
                        //Mise à jour des gcp pbf
                        $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
                        $gcp_pbf = new Application_Model_EuGcpPbf();
                        $gcp_pbfs = $m_gcp_pbf->fetchAllByPbf($membre);
                        foreach ($gcp_pbfs as $gcp_pbf) {
                            //Mise à jour du gcp pbf
                            $mont_a_deduire = 0;
                            if ($gcp_pbf->getSolde_gcp() > $mont_compte) {
                                $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $agio_consomme)
                                        ->setSolde_agio($gcp_pbf->getSolde_agio() - $agio_consomme)
                                        ->setGcp_compense($gcp_pbf->getGcp_compense() + $mont_gcp)
                                        ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() - $mont_compte)->setSolde_gcp($gcp_pbf->getSolde_gcp() - $mont_gcp);
                                $m_gcp_pbf->update($gcp_pbf);
                                $mont_a_deduire = $mont_gcp;
                                $mont_compte = 0;
                            } else {
                                $mont_a_deduire = $gcp_pbf->getSolde_gcp();
                                $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $gcp_pbf->getSolde_agio())
                                        ->setSolde_agio(0)
                                        ->setGcp_compense($gcp_pbf->getGcp_compense() + $gcp_pbf->getSolde_gcp())
                                        ->setSolde_gcp_reel(0)
                                        ->setSolde_gcp(0);
                                $m_gcp_pbf->update($gcp_pbf);
                                $mont_gcp = $mont_gcp - $gcp_pbf->getSolde_gcp();
                            }

                            //Mise à jour des détails gcp pbf
                            $detail = new Application_Model_EuDetailGcpPbf();
                            $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
                            $tcgcp = new Application_Model_DbTable_EuGcpPbfCompense();
                            $cgcp = new Application_Model_EuGcpPbfCompense();
                            $select = $t_detail->select();
                            $select->where('code_gcp_pbf = ?', $gcp_pbf->getCode_gcp_pbf())
                                    ->where('solde_gcp_pbf > 0');
                            $ce_results = $t_detail->fetchAll($select);
                            if (count($ce_results) > 0) {
                                foreach ($ce_results as $value) {
                                    $detail->exchangeArray($value);
                                    if ($detail->getSolde_gcp_pbf() < $mont_a_deduire) {
                                        $mont_a_deduire = $mont_a_deduire - $detail->getSolde_gcp_pbf();

                                        $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                ->setCode_compte($num_compte)
                                                ->setMont_gcp_entree($detail->getSolde_gcp_pbf())
                                                ->setType_capa_gcp($detail->getType_capa())->setSolde_compens($detail->getSolde_gcp_pbf())->setId_compens(null);
                                        $tcgcp->insert($cgcp->toArray());

                                        $detail->setMont_preleve($detail->getMont_preleve() + $detail->getSolde_gcp_pbf())->setSolde_gcp_pbf(0);
                                        $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));
                                    } else {
                                        $detail->setMont_preleve($detail->getMont_preleve() + $mont_a_deduire)->setSolde_gcp_pbf(0);
                                        $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));

                                        $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                ->setCode_compte($num_compte)
                                                ->setMont_gcp_entree($mont_a_deduire)
                                                ->setType_capa_gcp($detail->getType_capa())
                                                ->setSolde_compens($mont_a_deduire)->setId_compens(null);
                                        $tcgcp->insert($cgcp->toArray());
                                        $mont_a_deduire = 0;
                                    }
                                    if ($mont_a_deduire == 0) {
                                        break;
                                    }
                                }
                            }
                            if ($mont_gcp == 0) {
                                break;
                            }
                        }
                    } else {
                        $db->rollback();
                        $this->view->pbf = $membre;
                        $this->view->compte_gcp = $compte_gcp;
                        $this->view->mont_compte = $mont_compte;
                        $this->view->solde_gcpr = $solde_gcpr;
                        $this->view->message = 'Le solde du compte gcp du membre est insuffisant pour effectuer cette opération !!!';
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->pbf = $membre;
                    $this->view->compte_gcp = $compte_gcp;
                    $this->view->mont_compte = $mont_compte;
                    $this->view->solde_gcpr = $solde_gcpr;
                    $this->view->message = 'Ce membre ne possède pas un compte gcp Escompte : ' . $num_compte;
                    return;
                }
                $db->commit();
                $this->_helper->redirect('index');
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->pbf = $membre;
                $this->view->compte_gcp = $compte_gcp;
                $this->view->mont_compte = $mont_compte;
                $this->view->solde_gcpr = $solde_gcpr;
                $this->view->message = $exc->getMessage
                        () . ': ' . $exc->getTraceAsString();
                return;
            }
        }
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_compens');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCompensation();
        $select = $tabela->select();
        $date_deb = Zend_Date::now();
        $select->where('date_compens = ?', $date_deb->toString('yyyy-mm-dd'))
                ->order('date_compens', 'asc');
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
            $responce['rows'][$i]['id'] = $row->id_compens;
            $responce['rows'][$i]['cell'] = array(
                $row->date_compens,
                $row->code_membre_pbf,
                $row->mont_compens,
                $row->
                mont_tranche
            );
            $i++;
        }
        $this->
                view->data = $responce;
    }

    public function gcpechuAction() {
        
    }

    public function echgcpAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $membre = $request->membre;
            $type_compte = $request->compte;
            $montant = $request->montant;
            $gcps = $request->gcp;
            $compte = '';
            $cpte_map = new Application_Model_EuCompensationMapper();
            $compens = new Application_Model_EuCompensation();
            $fgfn_map = new Application_Model_EuFgfnMapper( );
            $fgfn = new Application_Model_EuFgfn();
            $compte = 'NB-TPA' . $type_compte . '-' . $membre;
            $code_fgfn = 'FGFN-' . $user->code_membre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $solde = $cpte_map->getMontCompensationEchu($gcps);
                $res = $fgfn_map->find($code_fgfn, $fgfn);
                if ($res && $solde >= $montant && $fgfn->getSolde_fgfn() >= $montant) {
                    $dfgfn_map = new Application_Model_EuDetailFgfnMapper();
                    $tcgcp = new Application_Model_DbTable_EuGcpPbfCompense ();
                    $cgcp = new Application_Model_EuGcpPbfCompense();
                    for ($i = 0; $i < count($gcps); $i++) {
                        $ret = $cpte_map->find($gcps[$i], $compens);
                        if ($ret) {
                            $mont_compens = $compens->getMont_echu();
                            $fgfns = $dfgfn_map->fetchAllByFgfn($fgfn->getCode_fgfn());
                            if ($fgfns != null) {
                                foreach ($fgfns as $value) {
                                    if ($value->getSolde_fgfn() < $mont_compens) {
                                        $deduire = $value->getSolde_fgfn();
                                        $value->setMont_preleve($value->getMont_preleve() + $value->getSolde_fgfn())->setSolde_fgfn(0);
                                        $dfgfn_map->update($value);
                                        $mont_compens = $mont_compens - $deduire;
                                    } else {
                                        $value->setMont_preleve($value->getMont_preleve() + $mont_compens)
                                                ->setSolde_fgfn($value->getSolde_fgfn() - $mont_compens);
                                        $dfgfn_map->update($value);
                                        $deduire = $mont_compens;
                                        $mont_compens = 0;
                                    }
                                    $select = $tcgcp->select();
                                    $select->where('id_compens = ?', $compens->getId_compens())->where('solde_compens > ?', 0);
                                    $results = $tcgcp->fetchAll($select);
                                    if (count($results) > 0) {
                                        foreach ($results as $gcpfgfn) {
                                            $cgcp->exchangeArray($gcpfgfn);
                                            if ($cgcp->getSolde_compens() > $deduire) {
                                                $cgcp->setMont_fgfn_sortie($cgcp->getMont_fgfn_sortie() + $deduire)
                                                        ->setId_detail_fgfn($value->getId_fgfn())
                                                        ->setType_capa_fgfn($value->getType_capa())
                                                        ->setSolde_compens($cgcp->getSolde_compens() - $deduire);
                                                $tcgcp->update($cgcp->toArray(), array('id_gcp_compense = ?' => $cgcp->getId_gcp_compense()));
                                                $deduire = 0;
                                                break;
                                            } else {
                                                $deduire = $deduire - $cgcp->getSolde_compens();
                                                $cgcp->setMont_fgfn_sortie($cgcp->getMont_fgfn_sortie() + $cgcp->getSolde_compens())
                                                        ->setId_detail_fgfn($value->getId_fgfn())
                                                        ->setType_capa_fgfn($value->getType_capa())->setSolde_compens(0);
                                                $tcgcp->update($cgcp->toArray(), array('id_gcp_compense = ?' => $cgcp->getId_gcp_compense()));
                                            }
                                        }
                                    }
                                    if ($mont_compens == 0) {
                                        break;
                                    }
                                }

                                //Mise à jour du compte de compensation du pbf
                                $compens->setMont_echu(0);
                                $cpte_map->update($compens);
                            }
                        } else {
                            $db->rollback();
                            $message = "Erreur d'éxécution: Pas de Compensation pour " . $gcps[$i];
                            $this->view->message = $message;
                            return;
                        }
                    }
                    //Mise à jour du fgfn du pbf
                    $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() - $montant);
                    $fgfn_map->update($fgfn);
                } else {
                    $db->rollback();
                    $message = "Erreur d'éxécution : Le compte " . $compte . ' -> solde gcp:' . $solde . ' Montant:' . $montant . ' fgfn du ' . $code_fgfn . ': ' . $fgfn->getSolde_fgfn() . " est invalide pour effectuer cette opération ";
                    $this->view->message = $message;
                    return;
                }
                $db->commit();
                $this->view->message = true;
                return;
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . ' Trace ->' . $e->getMessage();

                $this->view->message = $message;
                return;
            }
        }
    }

    public function gcpAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_compens');
        $sord = $this->_request->getParam("sord", 'asc');
        $membre = $this->_request->getParam("membre");
        $compte = 'NB-TPAGCP-' . $membre;
        $tabela = new Application_Model_DbTable_EuCompensation ();
        $select = $tabela->select();
        $select->where('code_compte like ?', $compte)
                ->where('mont_echu > ?', 0);
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
            $date_deb = new Zend_Date($row->date_deb, Zend_Date::ISO_8601);
            $date_fin = new Zend_Date($row->date_fin, Zend_Date::ISO_8601);
            $date_deb_tranche = new Zend_Date($row->date_deb_tranche, Zend_Date::ISO_8601);
            $date_fin_tranche = new Zend_Date($row->date_fin_tranche, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_compens;
            $responce['rows'][$i]['cell'] = array(
                $row->id_compens,
                $row->code_compte,
                $row->code_membre_pbf,
                $row->mont_compens,
                $row->ntf,
                $row->mont_tranche,
                $row->mont_echu,
                $date_deb->toString('dd/mm/yyyy'),
                $date_fin->toString('dd/mm/yyyy'),
                $date_deb_tranche->toString('dd/mm/yyyy'),
                $date_fin_tranche->toString(
                        'dd/mm/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembre ( );
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[0] = strtoupper($result->nom_membre);
            $data[1] = ucfirst($result->prenom_membre);
            if ($result->type_membre == 'm') {
                $data[2] = $result->raison_sociale;
            }
            $code_compte = 'NB-TPAGCP-' . $num_membre;
            $m_compte = new Application_Model_EuCompteMapper();
            $compte = new Application_Model_EuCompte();
            $ret = $m_compte->find($code_compte, $compte);
            if ($ret) {
                $data[3] = $compte->getSolde();
            } else {
                $data[3] = 0;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function smcipnAction() {
        $request = $this->getRequest();
        $membre = $request->membre;
        if ($membre != '') {
            $code_compte = 'NB-TPAGCP-' . $membre;
            $m_compte = new Application_Model_EuCompteMapper();
            $compte = new Application_Model_EuCompte();
            $ret = $m_compte->find($code_compte, $compte);
            if ($ret) {
                $this->view->data = $compte->getSolde();
            } else {
                $this->view->data = false;
            }
        }
    }

}

?>
