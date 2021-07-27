<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuEchangeController
 *
 * @author Emmanuel aklassou
 */
class EuEchangeController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $menu = '';
        if ($user->code_groupe == 'nn_tegcp_pbf') {
            $menu = '<li><a href="/eu-echange/escompte">Escompte</a></li>';
            $this->view->placeholder("menu")->set($menu);
        }
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($user->code_groupe != 'nn_tegcp_pbf') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function membreAction() {
        $request = $this->getRequest();
        $type = $request->type;
        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAllByType($type);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $this->view->data = $membres;
    }

    public function moralAction() {
        $m_map = new Application_Model_EuMembreMoraleMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre_morale;
        }
        $this->view->data = $membres;
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_operation');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuEchange();
        $select = $tabela->select();
        $date_deb = Zend_Date::now();
        $select->where('id_utilisateur like ?', $user->id_utilisateur)
                ->where('type_echange like ?', '%')
                ->where('date_echange = ?', $date_deb->toString('yyyy-mm-dd'))
                ->order('date_echange', 'asc');
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
            $date_op = new Zend_Date($row->date_echange, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
                $date_op->toString('dd/mm/yyyy'),
                $row->code_membre,
                $row->type_echange,
                $row->code_compte_ch,
                $row->montant_echange
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function soldeAction() {
        $code_membre = $_GET["code_membre"];
        $type_compte = $_GET["type_compte"];
        if ($code_membre != '') {
            if ($type_compte == "tcncs" or $type_compte == "tcncsEI") {
                $code_compte = "nr-" . $type_compte . "-" . $code_membre;
            } elseif ($type_compte == "rpg") {
                $code_compte = "nb-tpagcrpg-" . $code_membre;
            } elseif ($type_compte == "i") {
                $code_compte = "nb-tpagci-" . $code_membre;
            } elseif ($type_compte == "gcp") {
                $code_compte = "nb-tpagcp-" . $code_membre;
            }
            $cm = new Application_Model_EuCompteMapper();
            $compte = new Application_Model_EuCompte();
            $ret = $cm->find($code_compte, $compte);
            if ($ret) {
                $this->view->data = $compte->getSolde();
            } else {
                $this->view->data = 0;
            }
        } else {
            $this->view->data = 0;
        }
    }

    public function pechangeAction() {
        
    }

    public function pechAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $membre = $this->_request->getParam("membre");
        $compte = $this->_request->getParam("compte");
        $e_date = $this->_request->getParam("date");
        $tabela = new Application_Model_DbTable_EuEchange();
        $select = $tabela->select();
        $date = Zend_Date::now();
        if ($membre != '') {
            $select->where('code_membre = ?', $membre);
        }
        if ($compte != '') {
            if ($membre != '') {
                if ($compte == 'i' || $compte == 'rpg') {
                    $num_compte = 'nn-tpagc' . $compte . '-' . $membre;
                } elseif ($compte == 'gcp') {
                    $num_compte = 'nn-tpa' . $compte . '-' . $membre;
                } else {
                    $num_compte = 'nn-' . $compte . '-' . $membre;
                }
                $select->where('code_compte_obt = ?', $num_compte);
            } else {
                $select->where('code_compte_obt like ?', '%' . $compte . '%');
            }
        }
        if ($e_date != '') {
            $date_exp = explode('/', $e_date);
            $date_e = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('date_reglement = ?', $date_e);
        } else {
            $select->where('date_reglement = ?', $date->toString('yyyy-mm-dd'));
        }
        $select->where('type_echange like ?', '%nn')
                ->where('regler = ?', 1)
                ->where('id_utilisateur = ?', $user->id_utilisateur);
        $echanges = $tabela->fetchAll($select);
        $count = count($echanges);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $echanges = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($echanges as $row) {
            $date_op = new Zend_Date($row->date_echange, Zend_Date::ISO_8601);
            $date_reg = new Zend_Date($row->date_reglement, Zend_Date::ISO_8601);
            if ($row->regler == 1) {
                $regler = "oui";
            } else {
                $regler = "non";
            }
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
                $row->id_echange,
                $date_op->toString('dd-mm-yyyy'),
                $row->code_membre,
                $row->code_compte_obt,
                $row->montant,
                $regler,
                $date_reg->toString('dd-mm-yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function tpagcpAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_tpagcp');
        $sord = $this->_request->getParam("sord", 'asc');
        $membre = $this->_request->getParam("membre");
        $compte = 'nb-tpagcp-' . $membre;
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "select id_tpagcp,code_membre,code_compte,mont_gcp,mont_tranche,mont_echu,ntf,RESTE_ntf,to_char(date_deb,'dd-mm-yyyy') as deb,to_char(date_deb_TRANCHE,'dd-mm-yyyy') as deb_TRANCHE,to_char(date_fin,'dd-mm-yyyy') as fin,to_char(date_fin_TRANCHE,'dd-mm-yyyy') as fin_TRANCHE,solde  from eu_tpagcp where solde > 0 and code_compte = :compte";
        $stmt = $db->query($sql, array('compte' => $compte));
        $achats = $stmt->fetchAll();
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($achats as $row) {
            $responce['rows'][$i]['id'] = $row["id_tpagcp"];
            $responce['rows'][$i]['cell'] = array(
                $row["id_tpagcp"],
                $row["code_compte"],
                $row["code_membre"],
                $row["mont_gcp"],
                $row["reste_ntf"],
                $row["mont_tranche"],
                $row["mont_echu"],
                $row["solde"],
                $row["deb"], //$date_deb->toString('dd/mm/yyyy')
                $row["fin"], //$date_fin->toString('dd/mm/yyyy')
                $row["deb_tranche"], //$date_deb_tranche->toString('dd/mm/yyyy')
                $row["fin_tranche"]//$date_fin_tranche->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function creditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page");
        $limit = $this->_request->getParam("rows");
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'asc');
        $membre = $this->_request->getParam("membre");
        $produit = $this->_request->getParam("produit");
        $tabela = new Application_Model_DbTable_EuCompteCredit();
        $select = $tabela->select();
        $select->where('code_membre like ?', $membre)
                ->where('code_produit like ?', $produit)
                ->where('compte_source not in (?)', array('cacb', 'cscoe'))
                ->where('compte_source not like ?', 'nb-tpagcp%')
                ->where('MONTANT_credit > ?', 0)
                ->order('MONTANT_credit', 'desc');
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
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->id_credit,
                $row->code_membre,
                $row->code_compte,
                $row->code_produit,
                $row->MONTANT_credit,
                $row->compte_source
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function echgcpAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $membre = $request->membre;
            $type_compte = $request->compte;
            $montant = $request->montant;
            $tpagcps = $request->tpagcp;
            $compte = '';
            $cpte_map = new Application_Model_EuCompteMapper();
            $cpte_origine = new Application_Model_EuCompte();
            $compte = 'nb-tpa' . $type_compte . '-' . $membre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $res = $cpte_map->find($compte, $cpte_origine);
                if ($res) {
                    $tpamapper = new Application_Model_EuTpagcpMapper();
                    $som_echu = $tpamapper->findSommeTpaGcpEchu($cpte_origine->getCode_compte());
                    if ($som_echu > 0 && $som_echu >= $montant) {
                        $pck = Util_Utils::getParametre('pck', 'nr');
                        $prk = Util_Utils::getParametre('prk', 'nr');
                        $mont_recu = ($montant * $pck) / $prk;
                        $agio = $montant - $mont_recu;
                        $date = Zend_Date::now();
                        $newcompte = 'nn-tpa' . $type_compte . '-' . $membre;
                        $ccompte = new Application_Model_EuCompte();
                        $result = $cpte_map->find($newcompte, $ccompte);
                        if ($result == false) {
                            $ccompte->setCode_membre($membre)
                                    ->setCode_cat('tpa' . $type_compte)
                                    ->setSolde($montant)
                                    ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                    ->setCode_compte($newcompte)
                                    ->setLib_compte('gcp')
                                    ->setDesactiver(0);
                            $cpte_map->save($ccompte);
                        } else {
                            $ccompte->setSolde($ccompte->getSolde() + $montant);
                            $cpte_map->update($ccompte);
                        }

                        $echange = new Application_Model_EuEchange();
                        $echange_map = new Application_Model_EuEchangeMapper();
                        $echange->setCat_echange('egcp')
                                ->setType_echange('nb/nn')
                                ->setCode_compte_ech($compte)
                                ->setDate_echange($date->toString('yyyy-mm-dd'))
                                ->setCode_membre($membre)
                                ->setMontant_echange($montant)
                                ->setMontant($montant)
                                ->setAgio($agio)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setCode_compte_obt($newcompte)
                                ->setCode_produit($type_compte);
                        $echange_map->save($echange);
                        $num_echange = $db->lastInsertId();

                        $tpagcp = new Application_Model_EuTpagcp();
                        $cnp_mapper = new Application_Model_EuCnpMapper();
                        $tcnp = new Application_Model_DbTable_EuCnpEntree();
                        $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                        $cred_ech = new Application_Model_EuCreditEchange();
                        $rappro_mapper = new Application_Model_EuRapprochementMapper();
                        for ($i = 0; $i < count($tpagcps); $i++) {
                            $res = $tpamapper->find($tpagcps[$i], $tpagcp);
                            if ($res) {
                                $mont_deduire = $tpagcp->getMont_echu();
                                $select = $db->select()
                                        ->from(array('p' => 'eu_gcp_prelever'), array('id_tpagcp', 'id_gcp'))
                                        ->join(array('g' => 'eu_gcp'), 'p.id_gcp = g.id_gcp', array('id_credit', 'source'))
                                        ->where('p.id_tpagcp = ?', $tpagcp->getId_tpagcp());
                                $stmt = $db->query($select);
                                $results = $stmt->fetchAll();
                                if (count($results) > 0) {
                                    foreach ($results as $row) {
                                        $cnp = $cnp_mapper->findCnpByCreditSource($row['id_credit'], $row['source']);
                                        if ($cnp != null && $cnp->getSolde_cnp() >= $mont_deduire) {
                                            $cnp->setMont_credit($cnp->getMont_credit() + $mont_deduire)
                                                    ->setSolde_cnp($cnp->getSolde_cnp() - $mont_deduire);
                                            $cnp_mapper->update($cnp);
                                            $ecnp = new Application_Model_EuCnpEntree();
                                            $ecnp->setId_cnp($cnp->getId_cnp())
                                                    ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                    ->setMont_cnp_entree($mont_deduire)
                                                    ->setType_cnp_entree('gcp');
                                            $tcnp->insert($ecnp->toArray());

                                            $cred_ech->setId_credit($cnp->getId_credit())
                                                    ->setId_echange($num_echange)
                                                    ->setMont_echange($mont_deduire)
                                                    ->setSource_credit($row['source'])
                                                    ->setAgio($agio);
                                            $tcredit_ech->insert($cred_ech->toArray());

                                            $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                            $rappro = $rappro_mapper->findRapproByCreditSource($row['id_credit'], $row['source'], $type_rappro);
                                            if ($rappro != null) {
                                                $rappro->setCredit_rappro($rappro->getCredit_rappro() + $mont_deduire)
                                                        ->setSolde_rappro($rappro->getDebit_rappro() - $rappro->getCredit_rappro());
                                                $rappro_mapper->update($rappro);
                                            } else {
                                                $rappro = new Application_Model_EuRapprochement();
                                                $rappro->setDebit_rappro(0)
                                                        ->setCredit_rappro($mont_deduire)
                                                        ->setSolde_rappro($mont_deduire)
                                                        ->setSource('cnp')
                                                        ->setSource_credit($row['source'])
                                                        ->setCode_smcipn(null)
                                                        ->setId_credit($row['id_credit'])
                                                        ->setType_rappro($type_rappro);
                                                $rappro_mapper->save($rappro);
                                            }
                                            break;
                                        } else {
                                            $cnp->setMont_credit($cnp->getMont_credit() + $cnp->getSolde_cnp())
                                                    ->setSolde_cnp($cnp->getSolde_cnp() - $cnp->getSolde_cnp());
                                            $cnp_mapper->update($cnp);
                                            $ecnp = new Application_Model_EuCnpEntree();
                                            $ecnp->setId_cnp($cnp->getId_cnp())
                                                    ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                    ->setMont_cnp_entree($cnp->getSolde_cnp())
                                                    ->setType_cnp_entree('gcp');
                                            $tcnp->insert($ecnp->toArray());

                                            $cred_ech->setId_credit($cnp->getId_credit())
                                                    ->setId_echange($num_echange)
                                                    ->setMont_echange($cnp->getSolde_cnp())
                                                    ->setSource_credit($row['source'])
                                                    ->setAgio($agio);
                                            $tcredit_ech->insert($cred_ech->toArray());

                                            $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                            $rappro = $rappro_mapper->findRapproByCreditSource($row['id_credit'], $row['source'], $type_rappro);
                                            if ($rappro != null) {
                                                $rappro->setCredit_rappro($rappro->getCredit_rappro() + $cnp->getSolde_cnp())
                                                        ->setSolde_rappro($rappro->getDebit_rappro() - $rappro->getCredit_rappro());
                                                $rappro_mapper->update($rappro);
                                            } else {
                                                $rappro = new Application_Model_EuRapprochement();
                                                $rappro->setDebit_rappro(0)
                                                        ->setCredit_rappro($cnp->getSolde_cnp())
                                                        ->setSolde_rappro($cnp->getSolde_cnp())
                                                        ->setSource('cnp')
                                                        ->setSource_credit($row['source'])
                                                        ->setCode_smcipn(null)
                                                        ->setId_credit($row['id_credit'])
                                                        ->setType_rappro($type_rappro);
                                                $rappro_mapper->save($rappro);
                                            }
                                            $mont_deduire -= $cnp->getSolde_cnp();
                                        }
                                    }
                                }
                                $tpagcp->setMont_echu(0);
                                $tpamapper->update($tpagcp);
                            }
                        }
                        $db->commit();
                        $this->view->message = 'succes';
                        return;
                    } else {
                        $db->rollback();
                        $message = "Erreur d'éxécution : La somme des gcp echues n'est pas suffisant pour effectuer cette opération ";
                        $this->view->message = $message;
                        return;
                    }
                } else {
                    $db->rollback();
                    $message = "Erreur d'éxécution : Le compte " . $compte . " est invalide pour effectuer cette opération ";
                    $this->view->message = $message;
                    return;
                }
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . ' Trace ->' . $e->getMessage();
                $this->view->message = $message;
                return;
            }
        }
    }

    public function echangegcpAction() {
        
    }

    public function echangecncsAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $membre = $request->e_membre;
            $type_compte = $request->compte;
            $montant = $request->montant;
            $date_deb = Zend_Date::now();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $compte = 'nr-' . $type_compte . '-' . $membre;
                $cm_mapper = new Application_Model_EuCompteMapper();
                $m_smc = new Application_Model_EuSmcMapper();
                $cc_mapper = new Application_Model_EuCompteCreditMapper();
                $cpte_origine = new Application_Model_EuCompte();
                $result = $cm_mapper->find($compte, $cpte_origine);
                if ($result) {
                    if ($cpte_origine->getSolde() >= $montant) {
                        $pck = Util_Utils::getParametre('pck', 'nr');
                        $prk = Util_Utils::getParametre('prk', 'nr');
                        $mont_recu = ceil(($montant * $pck) / $prk);
                        $agio = $montant - $mont_recu;
                        $newcompte = 'nn-' . $type_compte . '-' . $membre;
                        $ccompte = new Application_Model_EuCompte();
                        $result = $cm_mapper->find($newcompte, $ccompte);
                        if ($result == false) {
                            $ccompte->setCode_membre($membre)
                                    ->setSolde($montant)
                                    ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                    ->setCode_compte($newcompte)
                                    ->setLib_compte($type_compte)
                                    ->setCode_cat($type_compte)
                                    ->setCode_type_compte("nn")
                                    ->setDesactiver(0);
                            $cm_mapper->save($ccompte);
                        } else {
                            $ccompte->setSolde($ccompte->getSolde() + $montant);
                            $cm_mapper->update($ccompte);
                        }

                        $echange = new Application_Model_EuEchange();
                        $echange_map = new Application_Model_EuEchangeMapper();
                        $echange->setCat_echange('cncs')
                                ->setType_echange('nr/nn')
                                ->setCode_compte_ech($compte)
                                ->setDate_echange($date_deb->toString('yyyy-mm-dd'))
                                ->setCode_membre($membre)
                                ->setMontant($montant)
                                ->setMontant_echange($montant)
                                ->setAgio($agio)
                                ->setCode_produit($type_compte)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setCode_compte_obt($newcompte);
                        $echange_map->save($echange);
                        $num_echange = $db->lastInsertId();

                        $cpte_origine->setSolde($cpte_origine->getSolde() - $montant);
                        $cm_mapper->update($cpte_origine);

                        //mise de la table de rapprochement 
                        $cc_mapper = new Application_Model_EuCompteCreditMapper();
                        $credits = $cc_mapper->findByCompte($compte);
                        $cred = new Application_Model_EuCompteCredit();
                        $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                        $cred_ech = new Application_Model_EuCreditEchange();
                        if ($credits != null) {
                            $i = 0;
                            $cred = $credits[$i];
                            $reste = $montant;
                            while ($reste > 0) {
                                $mont_deduit = 0;
                                if ($reste > $cred->getMontant_credit()) {
                                    $mont_deduit = $cred->getMontant_credit();
                                    $reste = $reste - $mont_deduit;
                                    $cred->setMontant_credit(0);
                                    $cc_mapper->update($cred);
                                } else {
                                    $mont_deduit = $reste;
                                    $reste = 0;
                                    $cred->setMontant_credit($cred->getMontant_credit() - $mont_deduit);
                                    $cc_mapper->update($cred);
                                }

                                $mont = ($mont_deduit * $pck) / $prk;
                                $agio_credit = $mont_deduit - $mont;
                                $cred_ech->setId_credit($cred->getId_credit())
                                        ->setId_echange($num_echange)
                                        ->setMont_echange($mont_deduit)
                                        ->setSource_credit($cred->getSource())
                                        ->setAgio($agio_credit);
                                $tcredit_ech->insert($cred_ech->toArray());

                                $smc = new Application_Model_EuSmc();
                                $m_smc = new Application_Model_EuSmcMapper();
                                if ($cred->getCode_produit() == 'CNCSr') {
                                    $tservir = new Application_Model_DbTable_EuUtiliser();
                                    $tselect = $tservir->select();
                                    $tselect->where('code_smcipn = ?', $cred->getCompte_Source());
                                    $tselect->order('MONTANT_allouer', 'desc');
                                    $resultSets = $tservir->fetchAll($tselect);
                                    if (count($resultSets) > 0) {
                                        $j = 0;
                                        while ($mont_deduit > 0 && $j < count($resultSets)) {
                                            $servir = $resultSets[$j];
                                            $ret = $m_smc->find($servir->id_smc, $smc);
                                            if ($ret) {
                                                if ($smc->getSortie() >= $mont_deduit) {
                                                    $smc->setEntree($smc->getEntree() + $mont_deduit);
                                                    $smc->setSolde($smc->getSolde() - $mont_deduit);
                                                    $mont_deduit = 0;
                                                    $m_smc->update($smc);
                                                } else {
                                                    $smc->setEntree($smc->getEntree() + $smc->getSortie());
                                                    $smc->setSolde($smc->getSolde() - $smc->getSortie());
                                                    $mont_deduit = $mont_deduit - $smc->getSortie();
                                                    $m_smc->update($smc);
                                                    $j++;
                                                }
                                            } else {
                                                $db->rollback();
                                                $this->view->message = 'Les smc sont inexistants ';
                                                $this->view->type = $request->type_echange;
                                                $this->view->e_membre = $membre;
                                                $this->view->montant = $montant;
                                                $this->view->compte = $type_compte;
                                                return;
                                            }
                                        }
                                    } else {
                                        $db->rollback();
                                        $this->view->message = "Cet Salaire n'est pas issu d'une subvention";
                                        $this->view->type = $request->type_echange;
                                        $this->view->e_membre = $membre;
                                        $this->view->montant = $montant;
                                        $this->view->compte = $type_compte;
                                        return;
                                    }
                                } else {
                                    $tsal = new Application_Model_DbTable_EuSalaireAffecter();
                                    $tselect = $tsal->select();
                                    $tselect->where('id_credit = ?', $cred->getId_credit());
                                    $tselect->order('mont_affecter', 'desc');
                                    $resultSets = $tsal->fetchAll($tselect);
                                    if (count($resultSets) > 0) {
                                        $j = 0;
                                        while ($mont_deduit > 0 && $j < count($resultSets)) {
                                            $servir = $resultSets[$j];
                                            $ret = $m_smc->find($servir->id_smc, $smc);
                                            if ($ret) {
                                                if ($smc->getSortie() >= $mont_deduit) {
                                                    $smc->setEntree($smc->getEntree() + $mont_deduit)
                                                            ->setSolde($smc->getSolde() - $mont_deduit);
                                                    $mont_deduit = 0;
                                                    $m_smc->update($smc);
                                                } else {
                                                    $smc->setEntree($smc->getEntree() + $smc->getSortie())
                                                            ->setSolde($smc->getSolde() - $smc->getSortie());
                                                    $mont_deduit = $mont_deduit - $smc->getSortie();
                                                    $m_smc->update($smc);
                                                    $j++;
                                                }
                                            } else {
                                                $db->rollback();
                                                $this->view->message = 'Les smc sont inexistants ';
                                                return;
                                            }
                                        }
                                    } else {
                                        $db->rollback();
                                        $this->view->message = "Cet Salaire n'est pas issu d'une affectation";
                                        return;
                                    }
                                }
                                $i = $i + 1;
                                $cred = $credits[$i];
                            }
                        } else {
                            $db->rollback();
                            $this->view->message = 'Pas de crédits correspondant à ce compte trouvés';
                            $this->view->type = $request->type_echange;
                            return;
                        }
                        $db->commit();
                        $this->view->message = 'Opération effectuée avec succès';
                        $this->view->type = $request->type_echange;
                        return;
                    } else {
                        $db->rollback();
                        $this->view->message = 'Le solde de ton compte ' . $compte . ' est insuffisant pour effectuer cet échange';
                        $this->view->type = $request->type_echange;
                        $this->view->e_membre = $membre;
                        $this->view->montant = $montant;
                        $this->view->compte = $type_compte;
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->message = "Ce membre n'a pas de compte " . $type_compte;
                    $this->view->type = $request->type_echange;
                    $this->view->e_membre = $membre;
                    $this->view->montant = $montant;
                    $this->view->compte = $type_compte;
                    return;
                }
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                $this->view->e_membre = $membre;
                $this->view->montant = $montant;
                $this->view->compte = $type_compte;
                $this->view->message = $message;
                return;
            }
        }
    }

    public function echangeAction() {
        $request = $this->getRequest();
        $cat = $request->cat;
        if ($cat == 'i' || $cat == 'rpg') {
            $compte = 'tpagc' . $cat;
        } else {
            $compte = 't' . $cat;
        }
        $this->view->type = $compte;
        $this->view->cat = $cat;
    }

    public function echAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $categorie = $request->cat_echange;
            $membre = $request->e_membre;
            $type_compte = $request->compte;
            $montant = $request->montant;
            $credits = $request->credits;
            $compte = '';
            $cpte_map = new Application_Model_EuCompteMapper();
            $cpte_origine = new Application_Model_EuCompte();
            $compte = 'nb-' . $categorie . '-' . $membre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $res = $cpte_map->find($compte, $cpte_origine);
                if ($res and ( $cpte_origine->getSolde() - $montant) >= 0) {
                    $tcc = new Application_Model_DbTable_EuCompteCredit();
                    $scc = $tcc->select();
                    $scc->from($tcc, array('sum(MONTANT_credit) as total'))
                            ->where('code_compte = ?', $compte)
                            ->where('code_produit = ?', $type_compte);
                    $results = $tcc->fetchAll($scc);
                    if (count($results) > 0) {
                        $row = $results->current();
                        if ($row->total >= $montant) {
                            $pck = Util_Utils::getParametre('pck', 'nr');
                            $prk = Util_Utils::getParametre('prk', 'nr');
                            if ($type_compte == 'Inr' || $type_compte == 'RPGnr' || $type_compte == 'PaNu') {
                                $mont_recu = round(($montant * $pck) / $prk);
                                $agio = $montant - $mont_recu;
                            } else {
                                $mont_recu = round(($montant * $prk) / $pck);
                                $agio = abs($montant - $mont_recu);
                            }
                            $date = Zend_Date::now();
                            $newcompte = 'nn-' . $categorie . '-' . $membre;
                            $ccompte = new Application_Model_EuCompte();
                            $result = $cpte_map->find($newcompte, $ccompte);
                            if ($result == false) {
                                $ccompte->setCode_membre($membre)
                                        ->setCode_cat($categorie)
                                        ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                        ->setCode_compte($newcompte)
                                        ->setLib_compte($categorie)
                                        ->setDesactiver(0);
                                if ($type_compte == 'Inr' || $type_compte == 'RPGnr' || $type_compte == 'PaNu') {
                                    $ccompte->setSolde($mont_recu);
                                } else {
                                    $ccompte->setSolde($montant);
                                }
                                $cpte_map->save($ccompte);
                            } else {
                                if ($type_compte == 'Inr' || $type_compte == 'RPGnr' || $type_compte == 'PaNu') {
                                    $ccompte->setSolde($ccompte->getSolde() + $mont_recu);
                                } else {
                                    $ccompte->setSolde($ccompte->getSolde() + $montant);
                                }
                                $cpte_map->update($ccompte);
                            }

                            //Enregistrement de l'opération
                            $op_mapper = new Application_Model_EuOperationMapper();
                            $count = $op_mapper->findConuter() + 1;
                            $op = new Application_Model_EuOperation();
                            $op->setId_operation($count)
                                    ->setDate_op($date->toString('yyyy-mm-dd'))
                                    ->setHeure_op($date->toString('hh:mm'))
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCode_membre($membre)
                                    ->setMontant_op($montant)
                                    ->setCode_produit('gcp')
                                    ->setLib_op('Escompte du gcp')
                                    ->setType_op($categorie)
                                    ->setCode_cat('tpagcp');
                            $op_mapper->save($op);

                            $echange = new Application_Model_EuEchange();
                            $echange_map = new Application_Model_EuEchangeMapper();
                            $echange->setCat_echange($categorie)
                                    ->setType_echange('nb/nn')
                                    ->setCode_compte_ech($compte)
                                    ->setDate_echange($date->toString('yyyy-mm-dd'))
                                    ->setCode_membre($membre)
                                    ->setMontant($mont_recu)
                                    ->setMontant_echange($montant)
                                    ->setAgio($agio)
                                    ->setCompenser(0)
                                    ->setCode_produit($type_compte)
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCode_compte_obt($newcompte);
                            if ($type_compte != 'Inr' && $type_compte != 'RPGnr' || $type_compte != 'PaNu') {
                                $echange->setMontant($montant);
                            }
                            $echange_map->save($echange);
                            $id_echange = $db->lastInsertId();

                            $cpte_origine->setSolde($cpte_origine->getSolde() - $montant);
                            $cpte_map->update($cpte_origine);

                            $cc_mapper = new Application_Model_EuCompteCreditMapper();
                            $cc = new Application_Model_EuCompteCredit();
                            $rap_mapper = new Application_Model_EuRapprochementMapper();
                            $cnp = new Application_Model_EuCnp();
                            $cnp_map = new Application_Model_EuCnpMapper();
                            $tcnp = new Application_Model_DbTable_EuCnpEntree();
                            $ecnp = new Application_Model_EuCnpEntree();
                            $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                            $cred_ech = new Application_Model_EuCreditEchange();
                            for ($i = 0; $i < count($credits); $i++) {
                                $cr = $credits[$i];
                                $cc_mapper->find($cr, $cc);
                                if (strpos($cc->getCompte_source(), 'nb-tpagcp') == false && strpos($cc->getCompte_source(), 'cacb') == false && strpos($cc->getCompte_source(), 'cscoe') == false) {
                                    $montant = $cc->getMontant_credit();
                                    $cnp = $cnp_map->findCnpByCreditSource($cc->getId_credit(), $cc->getSource());
                                    if ($cnp != null) {
                                        $cnp->setMont_credit($cnp->getMont_credit() + $montant)
                                                ->setSolde_cnp($cnp->getSolde_cnp() - $montant);
                                        $cnp_map->update($cnp);

                                        $ecnp->setId_cnp($cnp->getId_cnp())
                                                ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                ->setMont_cnp_entree($montant);
                                        if ($type_compte == 'Inr' || $type_compte == 'RPGnr') {
                                            $ecnp->setType_cnp_entree('e/e');
                                        } else {
                                            $ecnp->setType_cnp_entree($type_compte);
                                        }
                                        $tcnp->insert($ecnp->toArray());

                                        if ($cc->getCode_produit() == 'Inr' || $cc->getCode_produit() == 'RPGnr' || $cc->getCode_produit() == 'PaNu') {
                                            $mont = round(($cc->getMontant_credit() * $pck) / $prk);
                                            $agio_c = $cc->getMontant_credit() - $mont;
                                        } else {
                                            $mont = round(($montant * $prk) / $pck);
                                            $agio_c = abs($mont - $cc->getMontant_credit());
                                        }
                                        $cred_ech->setId_credit($cc->getId_credit())
                                                ->setId_echange($id_echange)
                                                ->setMont_echange($cc->getMontant_credit())
                                                ->setSource_credit($cc->getSource())
                                                ->setAgio($agio_c);
                                        $tcredit_ech->insert($cred_ech->toArray());

                                        $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                        $rap = $rap_mapper->findRapproByCreditSource($cc->getId_credit(), $cc->getSource(), $type_rappro);
                                        if ($rap != null) {
                                            $rap->setCredit_rappro($rap->getCredit_rappro() + $montant);
                                            $rap->setSolde_rappro($rap->getCredit_rappro() - $rap->getDebit_rappro());
                                            $rap_mapper->update($rap);
                                        } else {
                                            $rap = new Application_Model_EuRapprochement();
                                            $rap->setDebit_rappro(0)
                                                    ->setCredit_rappro($montant)
                                                    ->setSolde_rappro($montant)
                                                    ->setSource('cnp')
                                                    ->setSource_credit($cc->getSource())
                                                    ->setId_credit($cc->getId_credit())
                                                    ->setType_rappro($type_rappro)
                                                    ->setCode_smcipn(null)
                                                    ->setCode_domicilier(null)
                                                    ->setType_rappro($type_rappro);
                                            $rap_mapper->save($rap);
                                        }
                                    }
                                    $cc->setMontant_credit(0);
                                    $cc_mapper->update($cc);
                                } else {
                                    $db->rollback();
                                    $this->view->message = "Il y a des crédits qui ne sont pas susceptibles d' avoir de l'espèces";
                                    return;
                                }
                            }
                        } else {
                            $db->rollback();
                            $this->view->message = "Le credit de ce membre est insuffisant pour effectuer cet échange";
                            return;
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = "Le membre " . $membre . " ne dispose pas de compte " . $type_compte;
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->message = "Le membre " . $membre . " ne dispose pas de compte " . $categorie . " ou son crédit de " . $cpte_origine->getSolde() . " est insuffisant pour cet échange";
                    return;
                }
                $db->commit();
                $this->view->message = true;
                return;
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                $this->view->message = $message;
                return;
            }
        }
    }

    public function escompteAction() {
        $this->view->ntf = 1;
    }

    public function eacprAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $type_escompte = $request->type_escompte;
            $membre = $request->membre;
            $montant = $request->montant;
            $comptes = $request->comptes;
            $compte = 'nb-tpagcp-' . $membre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $m_acteur = new Application_Model_EuActeurCreneauMapper();
                $acteur = $m_acteur->findActeurByMembre($membre);
                if ($acteur != null) {
                    if ($acteur->getId_type_acteur() == 2 || $acteur->getId_type_acteur() == 3) {
                        $this->view->message = 'Pas d\'escomptes pour les détaillants et les semi-grossistes.'
                                . ' Les semi-grossistes et détaillants doivent echanger leur gcp au niveau des pbf'
                                . ' avec Inr/RPGnr pour payer leurs semi-grossistes ou leurs grossistes!!!';
                        $db->rollback();
                        return;
                    } elseif ($acteur->getId_type_acteur() == 1) {
                        $tpa_mapper = new Application_Model_EuTpagcpMapper();
                        $escpe_mapper = new Application_Model_EuEscompteMapper();
                        $cm_mapper = new Application_Model_EuCompteMapper();
                        $escpte = new Application_Model_EuEscompte();
                        $mont_dispo = $tpa_mapper->findSommeTpaGcp($comptes);
                        if ($mont_dispo >= $montant) {
                            $pck = Util_Utils::getParametre('pck', 'nr');
                            $prk = Util_Utils::getParametre('prk', 'nr');
                            $mont_recu = ($montant * $pck) / $prk;
                            $agio = $montant - $mont_recu;
                            $newcompte = 'nn-tpagcp-' . $membre;
                            $date = Zend_Date::now();

                            //Enregistrement de l'opération
                            $op_mapper = new Application_Model_EuOperationMapper();
                            $count = $op_mapper->findConuter() + 1;
                            $op = new Application_Model_EuOperation();
                            $op->setId_operation($count)
                                    ->setDate_op($date->toString('yyyy-mm-dd'))
                                    ->setHeure_op($date->toString('hh:mm'))
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCode_membre($membre)
                                    ->setMontant_op($montant)
                                    ->setCode_produit('gcp')
                                    ->setLib_op('Escompte du gcp')
                                    ->setType_op($type_escompte)
                                    ->setCode_cat('tpagcp');
                            $op_mapper->save($op);

                            $echange = new Application_Model_EuEchange();
                            $echange_map = new Application_Model_EuEchangeMapper();
                            $echange->setCat_echange($type_escompte)
                                    ->setType_echange('nb/nn')
                                    ->setCode_compte_ech($compte)
                                    ->setDate_echange($date->toString('yyyy-mm-dd'))
                                    ->setCode_membre($membre)
                                    ->setMontant_echange($montant)
                                    ->setAgio($agio)
                                    ->setCompenser(0)
                                    ->setCode_produit('gcp')
                                    ->setMontant($montant)
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCode_compte_obt($newcompte);
                            $echange_map->save($echange);
                            $num_echange = $db->lastInsertId();

                            $ccompte = new Application_Model_EuCompte();
                            $result = $cm_mapper->find($newcompte, $ccompte);
                            if ($result == false) {
                                Util_Utils::createCompte($newcompte, 'tpagcp', 'tpagcp', $montant, $membre, 'nn', $date, 0);
                            } else {
                                $ccompte->setSolde($ccompte->getSolde() + $montant);
                                $cm_mapper->update($ccompte);
                            }

                            $gcps = $tpa_mapper->findGcp($comptes);
                            $j = 0;
                            $nbre = count($gcps);
                            if ($nbre > 0) {
                                $rappro_mapper = new Application_Model_EuRapprochementMapper();
                                $tcnp = new Application_Model_DbTable_EuCnpEntree();
                                $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                                $cred_ech = new Application_Model_EuCreditEchange();
                                $cnp_mapper = new Application_Model_EuCnpMapper();
                                for ($j = 0; $j < count($gcps); $j++) {
                                    $tpagcp = $gcps[$j];
                                    $escpte->setCode_compte($tpagcp->getCode_compte())
                                            ->setDate_deb($tpagcp->getDate_deb())
                                            ->setDate_fin($tpagcp->getDate_fin())
                                            ->setCode_membre($tpagcp->getCode_membre())
                                            ->setCode_membre_benef($user->code_membre)
                                            ->setDate_escompte($date->toString('yyyy-mm-dd'))
                                            ->setMont_tranche($tpagcp->getMont_tranche())
                                            ->setMontant($tpagcp->getSolde())
                                            ->setMont_echu(0)
                                            ->setNtf($tpagcp->getReste_ntf())
                                            ->setPeriode($tpagcp->getPeriode())
                                            ->setDate_deb_tranche($tpagcp->getDate_deb_tranche())
                                            ->setDate_fin_tranche($tpagcp->getDate_fin_tranche())
                                            ->setReste_ntf($tpagcp->getReste_ntf())
                                            ->setSolde($tpagcp->getMont_gcp())
                                            ->setId_echange($num_echange)
                                            ->setMont_echu_transferer(0);
                                    $escpe_mapper->save($escpte);

                                    //Mise à jour du cnp 
                                    $mont_deduire = $tpagcp->getSolde();
                                    $select = $db->select()
                                            ->from(array('p' => 'eu_gcp_prelever'), array('id_tpagcp', 'id_gcp', 'mont_prelever'))
                                            ->join(array('g' => 'eu_gcp'), 'p.id_gcp = g.id_gcp', array('id_credit', 'source'))
                                            ->where('p.id_tpagcp = ?', $tpagcp->getId_tpagcp());
                                    $stmt = $db->query($select);
                                    $results = $stmt->fetchAll();
                                    if (count($results) > 0) {
                                        foreach ($results as $row) {
                                            $cnp = $cnp_mapper->findCnpByCreditSource($row['id_credit'], $row['source']);
                                            if ($mont_deduire > 0) {
                                                if ($cnp != null && $cnp->getSolde_cnp() >= $mont_deduire) {
                                                    $cnp->setMont_credit($cnp->getMont_credit() + $mont_deduire)
                                                            ->setSolde_cnp($cnp->getSolde_cnp() - $mont_deduire);
                                                    $cnp_mapper->update($cnp);
                                                    $ecnp = new Application_Model_EuCnpEntree();
                                                    $ecnp->setId_cnp($cnp->getId_cnp())
                                                            ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                            ->setMont_cnp_entree($mont_deduire)
                                                            ->setType_cnp_entree('gcp');
                                                    $tcnp->insert($ecnp->toArray());

                                                    $mont = ($mont_deduire * $pck) / $prk;
                                                    $agio_credit = $mont_deduire - $mont;
                                                    $cred_ech->setId_credit($row['id_credit'])
                                                            ->setId_echange($num_echange)
                                                            ->setMont_echange($mont_deduire)
                                                            ->setSource_credit($row['source'])
                                                            ->setAgio($agio_credit);
                                                    $tcredit_ech->insert($cred_ech->toArray());

                                                    $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                                    $rappro = $rappro_mapper->findRapproByCreditSource($row['id_credit'], $row['source'], $type_rappro);
                                                    if ($rappro != null) {
                                                        $rappro->setCredit_rappro($rappro->getCredit_rappro() + $mont_deduire)
                                                                ->setSolde_rappro($rappro->getCredit_rappro() - $rappro->getDebit_rappro());
                                                        $rappro_mapper->update($rappro);
                                                    } elseif ($cnp != null && $cnp->getSolde_cnp() > 0) {
                                                        $rappro = new Application_Model_EuRapprochement();
                                                        $rappro->setDebit_rappro(0)
                                                                ->setCredit_rappro($mont_deduire)
                                                                ->setSolde_rappro($mont_deduire)
                                                                ->setSource('cnp')
                                                                ->setSource_credit($row['source'])
                                                                ->setCode_smcipn(null)
                                                                ->setId_credit($row['id_credit'])
                                                                ->setType_rappro($type_rappro);
                                                        $rappro_mapper->save($rappro);
                                                    }
                                                    break;
                                                } else {
                                                    if ($cnp->getSolde_cnp() > 0) {
                                                        $ecnp = new Application_Model_EuCnpEntree();
                                                        $ecnp->setId_cnp($cnp->getId_cnp())
                                                                ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                                ->setMont_cnp_entree($cnp->getSolde_cnp())
                                                                ->setType_cnp_entree('gcp');
                                                        $tcnp->insert($ecnp->toArray());

                                                        $mont = ($cnp->getSolde_cnp() * $pck) / $prk;
                                                        $agio_credit = $cnp->getSolde_cnp() - $mont;
                                                        $cred_ech->setId_credit($row['id_credit'])
                                                                ->setId_echange($num_echange)
                                                                ->setMont_echange($cnp->getSolde_cnp())
                                                                ->setSource_credit($row['source'])
                                                                ->setAgio($agio_credit);
                                                        $tcredit_ech->insert($cred_ech->toArray());

                                                        $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                                        $rappro = $rappro_mapper->findRapproByCreditSource($row['id_credit'], $row['source'], $type_rappro);
                                                        if ($rappro != null) {
                                                            $rappro->setCredit_rappro($rappro->getCredit_rappro() + $cnp->getSolde_cnp())
                                                                    ->setSolde_rappro($rappro->getCredit_rappro() - $rappro->getDebit_rappro());
                                                            $rappro_mapper->update($rappro);
                                                        } else {
                                                            $rappro = new Application_Model_EuRapprochement();
                                                            $rappro->setDebit_rappro(0)
                                                                    ->setCredit_rappro($cnp->getSolde_cnp())
                                                                    ->setSolde_rappro($cnp->getSolde_cnp())
                                                                    ->setSource('cnp')
                                                                    ->setSource_credit($row['source'])
                                                                    ->setCode_smcipn(null)
                                                                    ->setId_credit($row['id_credit'])
                                                                    ->setType_rappro($type_rappro);
                                                            $rappro_mapper->save($rappro);
                                                        }
                                                        $cnp->setMont_credit($cnp->getMont_credit() + $cnp->getSolde_cnp())
                                                                ->setSolde_cnp($cnp->getSolde_cnp() - $cnp->getSolde_cnp());
                                                        $cnp_mapper->update($cnp);
                                                        $mont_deduire -= $cnp->getSolde_cnp();
                                                    } else {
                                                        $db->rollback();
                                                        $message = "Crédits déja utilisés ou non issu du cnp ou le solde des cnp est nul !!!";
                                                        $this->view->message = $message;
                                                        return;
                                                    }
                                                }
                                            } else {
                                                if ($cnp == null) {
                                                    $db->rollback();
                                                    $message = "Crédits déja utilisés ou non issu du cnp ou le solde des cnp est nul !!!";
                                                    $this->view->message = $message;
                                                    return;
                                                }
                                                break;
                                            }
                                        }
                                    }//fin mise à jour cnp

                                    $montant = $montant - $tpagcp->getSolde();
                                    $tpagcp->setMont_escompte($tpagcp->getMont_escompte() + $tpagcp->getSolde())
                                            ->setSolde(0)
                                            ->setReste_ntf(0);
                                    $tpa_mapper->update($tpagcp);
                                    //$j = $j + 1;
                                }
                            } else {
                                $this->view->message = 'Pas de gcp pour';
                                return;
                            }
                        } else {
                            $message = 'Le montant total disponible:' . $mont_dispo . ' est insuffisant pour effectuer cet escompte:' . $montant;
                            $this->view->message = $message;
                            return;
                        }
                        $db->commit();
                        $this->view->message = true;
                        return;
                    }
                }
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                $this->view->message = $message;
                return;
            }
        }
    }

    public function ecprAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $type_escompte = $request->type_escompte;
            $membre = $request->membre;
            $montant = $request->montant;
            $ntf = $request->ntf;
            $comptes = $request->comptes;
            $compte = 'nb-tpagcp-' . $membre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $tpa_mapper = new Application_Model_EuTpagcpMapper();
                $escpe_mapper = new Application_Model_EuEscompteMapper();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $cnp_mapper = new Application_Model_EuCnpMapper();
                $escpte = new Application_Model_EuEscompte();
                if ($type_escompte == 'ecpr') {
                    $mont_dispo = $tpa_mapper->findSommeTrancheGcpByComptes($comptes);
                    if (($mont_dispo * $ntf) >= $montant) {
                        $pck = Util_Utils::getParametre('pck', 'nr');
                        $prk = Util_Utils::getParametre('prk', 'nr');
                        $mont_recu = ($montant * $pck) / $prk;
                        $agio = $montant - $mont_recu;
                        $newcompte = 'nn-tpagcp-' . $membre;
                        $date = Zend_Date::now();

                        //Enregistrement de l'opération
                        $op_mapper = new Application_Model_EuOperationMapper();
                        $count = $op_mapper->findConuter() + 1;
                        $op = new Application_Model_EuOperation();
                        $op->setId_operation($count)
                                ->setDate_op(Util_Utils::toDate($date))
                                ->setHeure_op(Util_Utils::toDate($date))
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setCode_membre($membre)
                                ->setMontant_op($montant)
                                ->setCode_produit('gcp')
                                ->setLib_op('Escompte du gcp')
                                ->setType_op($type_escompte)
                                ->setCode_cat('tpagcp');
                        $op_mapper->save($op);

                        $echange = new Application_Model_EuEchange();
                        $echange_map = new Application_Model_EuEchangeMapper();
                        $id_echange = $echange_map->getLastInsertId();
                        $echange->setId_echange($id_echange)
                                ->setCat_echange($type_escompte)
                                ->setType_echange('nb/nn')
                                ->setCode_compte_ech($compte)
                                ->setDate_echange(Util_Utils::toDate($date))
                                ->setCode_membre($membre)
                                ->setAgio($agio)
                                ->setCompenser(0)
                                ->setMontant($montant)
                                ->setCode_produit('gcp')
                                ->setMontant_echange($montant)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setCode_compte_obt($newcompte);
                        $echange_map->save($echange);
                        $num_echange = $db->lastInsertId();

                        $ccompte = new Application_Model_EuCompte();
                        $result = $cm_mapper->find($newcompte, $ccompte);
                        if ($result == false) {
                            Util_Utils::createCompte($newcompte, 'tpagcp', 'tpagcp', $montant, $membre, 'nn', Util_Utils::toChar($date), 0);
                        } else {
                            $ccompte->setSolde($ccompte->getSolde() + $montant);
                            $cm_mapper->update($ccompte);
                        }

                        $rappro_mapper = new Application_Model_EuRapprochementMapper();
                        $tcnp = new Application_Model_DbTable_EuCnpEntree();
                        $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                        $cred_ech = new Application_Model_EuCreditEchange();
                        foreach ($comptes as $cpte) {
                            $tpagcp = new Application_Model_EuTpagcp();
                            $ret = $tpa_mapper->find($cpte, $tpagcp);
                            $periode = Util_Utils::getParametre('periode', 'valeur');
                            $duree = $periode * $ntf;
                            $datedeb = new Zend_Date($tpagcp->getDate_deb_tranche(), Zend_Date::ISO_8601);
                            $datefin = $datedeb->addDay($duree);
                            if ($ret) {
                                $mont_escompte = $ntf * $tpagcp->getMont_tranche();
                                if ($tpagcp->getReste_ntf() >= $ntf) {
                                    $escpte->setCode_compte($tpagcp->getCode_compte())
                                            ->setDate_deb($tpagcp->getDate_deb_tranche())
                                            ->setDate_fin($datefin->toString('yyyy-MM_dd'))
                                            ->setCode_membre($tpagcp->getCode_membre())
                                            ->setCode_membre_benef($user->code_membre)
                                            ->setMont_tranche($tpagcp->getMont_tranche())
                                            ->setMontant($mont_escompte)
                                            ->setMont_echu(0)
                                            ->setNtf($ntf)
                                            ->setPeriode($tpagcp->getPeriode())
                                            ->setDate_deb_tranche($tpagcp->getDate_deb_tranche())
                                            ->setDate_fin_tranche($tpagcp->getDate_fin_tranche())
                                            ->setReste_ntf($tpagcp->getReste_ntf())
                                            ->setSolde($mont_escompte)
                                            ->setDate_escompte($date->toString('yyyy_MM-dd'))
                                            ->setId_echange($num_echange)
                                            ->setMont_echu_transferer(0);
                                    $escpe_mapper->save($escpte);

                                    //Mise à jour du cnp 
                                    $mont_deduire = $mont_escompte;
                                    $select = $db->select()
                                            ->from(array('p' => 'eu_gcp_prelever'), array('id_tpagcp', 'id_gcp'))
                                            ->join(array('g' => 'eu_gcp'), 'p.id_gcp = g.id_gcp', array('id_credit', 'source'))
                                            ->where('p.id_tpagcp = ?', $tpagcp->getId_tpagcp());
                                    $stmt = $db->query($select);
                                    $results = $stmt->fetchAll();
                                    if (count($results) > 0) {
                                        foreach ($results as $row) {
                                            if ($mont_deduire > 0) {
                                                $cnp = $cnp_mapper->findCnpByCreditSource($row['id_credit'], $row['source']);
                                                if ($cnp != null && $cnp->getSolde_cnp() >= $mont_deduire) {
                                                    $cnp->setMont_credit($cnp->getMont_credit() + $mont_deduire)
                                                            ->setSolde_cnp($cnp->getSolde_cnp() - $mont_deduire);
                                                    $cnp_mapper->update($cnp);
                                                    $ecnp = new Application_Model_EuCnpEntree();
                                                    $ecnp->setId_cnp($cnp->getId_cnp())
                                                            ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                            ->setMont_cnp_entree($mont_deduire)
                                                            ->setType_cnp_entree('gcp');
                                                    $tcnp->insert($ecnp->toArray());

                                                    $mont = ($mont_deduire * $pck) / $prk;
                                                    $agio_credit = $mont_deduire - $mont;
                                                    $cred_ech->setId_credit($row['id_credit'])
                                                            ->setId_echange($num_echange)
                                                            ->setMont_echange($mont_deduire)
                                                            ->setSource_credit($row['source'])
                                                            ->setAgio($agio_credit);
                                                    $tcredit_ech->insert($cred_ech->toArray());

                                                    $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                                    $rappro = $rappro_mapper->findRapproByCreditSource($row['id_credit'], $row['source'], $type_rappro);
                                                    if ($rappro != null) {
                                                        $rappro->setCredit_rappro($rappro->getCredit_rappro() + $mont_deduire)
                                                                ->setSolde_rappro($rappro->getCredit_rappro() - $rappro->getDebit_rappro());
                                                        $rappro_mapper->update($rappro);
                                                    } else {
                                                        $rappro = new Application_Model_EuRapprochement();
                                                        $rappro->setDebit_rappro(0)
                                                                ->setCredit_rappro($mont_deduire)
                                                                ->setSolde_rappro($mont_deduire)
                                                                ->setSource('cnp')
                                                                ->setSource_credit($row['source'])
                                                                ->setCode_smcipn(null)
                                                                ->setId_credit($row['id_credit'])
                                                                ->setType_rappro($type_rappro);
                                                        $rappro_mapper->save($rappro);
                                                    }
                                                    break;
                                                } else {
                                                    if ($cnp->getSolde_cnp() > 0) {
                                                        $ecnp = new Application_Model_EuCnpEntree();
                                                        $ecnp->setId_cnp($cnp->getId_cnp())
                                                                ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                                ->setMont_cnp_entree($cnp->getSolde_cnp())
                                                                ->setType_cnp_entree('gcp');
                                                        $tcnp->insert($ecnp->toArray());

                                                        $mont = ($cnp->getSolde_cnp() * $pck) / $prk;
                                                        $agio_credit = $cnp->getSolde_cnp() - $mont;
                                                        $cred_ech->setId_credit($row['id_credit'])
                                                                ->setId_echange($num_echange)
                                                                ->setMont_echange($cnp->getSolde_cnp())
                                                                ->setSource_credit($row['source'])
                                                                ->setAgio($agio_credit);
                                                        $tcredit_ech->insert($cred_ech->toArray());

                                                        $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                                        $rappro = $rappro_mapper->findRapproByCreditSource($row['id_credit'], $row['source'], $type_rappro);
                                                        if ($rappro != null) {
                                                            $rappro->setCredit_rappro($rappro->getCredit_rappro() + $cnp->getSolde_cnp())
                                                                    ->setSolde_rappro($rappro->getCredit_rappro() - $rappro->getDebit_rappro());
                                                            $rappro_mapper->update($rappro);
                                                        } else {
                                                            $rappro = new Application_Model_EuRapprochement();
                                                            $rappro->setDebit_rappro(0)
                                                                    ->setCredit_rappro($cnp->getSolde_cnp())
                                                                    ->setSolde_rappro($cnp->getSolde_cnp())
                                                                    ->setSource('cnp')
                                                                    ->setSource_credit($row['source'])
                                                                    ->setCode_smcipn(null)
                                                                    ->setId_credit($row['id_credit'])
                                                                    ->setType_rappro($type_rappro);
                                                            $rappro_mapper->save($rappro);
                                                        }
                                                        $cnp->setMont_credit($cnp->getMont_credit() + $cnp->getSolde_cnp())
                                                                ->setSolde_cnp($cnp->getSolde_cnp() - $cnp->getSolde_cnp());
                                                        $cnp_mapper->update($cnp);
                                                        $mont_deduire = $mont_deduire - $cnp->getSolde_cnp();
                                                    } else {
                                                        $db->rollback();
                                                        $message = "Crédits déja utilisés ou non issu du cnp ou le solde des cnp est nul !!!";
                                                        $this->view->message = $message;
                                                        return;
                                                    }
                                                }
                                            } else {
                                                break;
                                            }
                                        }
                                    }//fin mise à jour cnp

                                    $date = new Zend_Date($tpagcp->getDate_deb_tranche(), Zend_Date::ISO_8601);
                                    $date->addDay($tpagcp->getPeriode() * $ntf);
                                    $date_deb = clone $date;
                                    $date->addDay($tpagcp->getPeriode());
                                    $tpagcp->setMont_escompte($tpagcp->getMont_escompte() + $mont_escompte)
                                            ->setSolde($tpagcp->getSolde() - $mont_escompte)
                                            ->setReste_ntf($tpagcp->getNtf() - $ntf)
                                            ->setDate_deb_tranche($date_deb->toString('yyyy-MM_dd'))
                                            ->setDate_fin_tranche($date->toString('yyyy-MM_dd'));
                                    $tpa_mapper->update($tpagcp);
                                } else {
                                    $message = 'Le nombre de traites restantes:' . $tpagcp->getReste_ntf() . ' est inférieur au nombre demandé: ' . $ntf;
                                    $this->view->message = $message;
                                    return;
                                }
                            } else {
                                $message = 'gcp inexistant';
                                $this->view->message = $message;
                                return;
                            }
                        }
                    } else {
                        $message = 'Le montant total disponible est insuffisant pour effectuer cet escompte';
                        $this->view->message = $message;
                        return;
                    }
                }
                //$db->rollback();
                $db->commit();
                $this->view->message = true;
                return;
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                $this->view->message = $message;
                return;
            }
        }
    }

    public function ecncsAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $membre = $request->e_membre;
            $type_compte = $request->compte;
            $montant = $request->montant;
            $num_compte = 'nr-tcncs-' . $membre;
            $compte = new Application_Model_EuCompte();
            $m_smc = new Application_Model_EuSmcMapper();
            $cc_mapper = new Application_Model_EuCompteCreditMapper();
            $cm_mapper = new Application_Model_EuCompteMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {

                $res = $cm_mapper->find($num_compte, $compte);
                if ($res && $compte->getSolde() >= $montant) {
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
                    $mapper = new Application_Model_EuOperationMapper();
                    $compteur = $mapper->findConuter() + 1;
                    Util_Utils::addOperation($compteur, $membre, 'tcncs', $montant, $type_compte, 'Escompte cncs', 'Ecncs', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);
                    $pck = Util_Utils::getParametre('pck', 'nr');
                    $prk = Util_Utils::getParametre('prk', 'nr');
                    $mont_recu = ($montant * $pck) / $prk;
                    $agio = $montant - $mont_recu;

                    $newcompte = 'nn-tcncs-' . $membre;
                    $date = Zend_Date::now();
                    $echange = new Application_Model_EuEchange();
                    $echange_map = new Application_Model_EuEchangeMapper();
                    $echange->setCat_echange('cncs')
                            ->setType_echange('ecncs')
                            ->setCode_compte_ech($compte->getCode_compte())
                            ->setDate_echange($date->toString('yyyy-mm-dd'))
                            ->setCode_membre($membre)
                            ->setMontant_echange($montant)
                            ->setAgio($agio)
                            ->setCompenser(0)
                            ->setCode_produit($type_compte)
                            ->setMontant($montant)
                            ->setId_utilisateur($user->id_utilisateur)
                            ->setCode_compte_obt($newcompte);
                    $echange_map->save($echange);
                    $num_echange = $db->lastInsertId();

                    $compte->setSolde($compte->getSolde() - $montant);
                    $cm_mapper->update($compte);

                    $ccompte = new Application_Model_EuCompte();
                    $result = $cm_mapper->find($newcompte, $ccompte);
                    if ($result == false) {
                        $ccompte->setCode_membre($membre)
                                ->setSolde($montant)
                                ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                ->setCode_compte($newcompte)
                                ->setLib_compte($type_compte)
                                ->setCode_cat('tcncs')
                                ->setCode_type_compte('nn')
                                ->setDesactiver(0);
                        $cm_mapper->save($ccompte);
                    } else {
                        $ccompte->setSolde($ccompte->getSolde() + $montant);
                        $cm_mapper->update($ccompte);
                    }

                    //mise de la table de rapprochement 
                    $cc_mapper = new Application_Model_EuCompteCreditMapper();
                    $credits = $cc_mapper->findByCompte($compte->getCode_compte());
                    $cred = new Application_Model_EuCompteCredit();
                    $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                    $cred_ech = new Application_Model_EuCreditEchange();
                    if ($credits != null) {
                        $i = 0;
                        $reste = $montant;
                        while ($reste > 0) {
                            $cred = $credits[$i];
                            $mont_deduit = 0;
                            if ($reste > $cred->getMontant_credit()) {
                                $mont_deduit = $cred->getMontant_credit();
                                $reste = $reste - $mont_deduit;
                                $cred->setMontant_credit(0);
                                $cc_mapper->update($cred);
                            } else {
                                $mont_deduit = $reste;
                                $reste = 0;
                                $cred->setMontant_credit($cred->getMontant_credit() - $mont_deduit);
                                $cc_mapper->update($cred);
                            }

                            $cred_ech->setId_credit($cred->getId_credit())
                                    ->setId_echange($num_echange)
                                    ->setMont_echange($mont_deduit)
                                    ->setSource_credit($cred->getSource())
                                    ->setAgio($agio);
                            $tcredit_ech->insert($cred_ech->toArray());

                            if ($cred->getCode_produit() == 'CNCSr') {
                                $tservir = new Application_Model_DbTable_EuUtiliser();
                                $tselect = $tservir->select();
                                $tselect->where('code_smcipn = ?', $cred->getCompte_Source());
                                $tselect->order('MONTANT_allouer', 'desc');
                                $resultSets = $tservir->fetchAll($tselect);
                                if (count($resultSets) > 0 && $j < count($resultSets)) {
                                    $j = 0;
                                    $smc = new Application_Model_EuSmc();
                                    $m_smc = new Application_Model_EuSmcMapper();
                                    while ($mont_deduit > 0) {
                                        $servir = $resultSets[$j];
                                        $ret = $m_smc->find($servir->id_smc, $smc);
                                        if ($ret) {
                                            if ($smc->getSortie() >= $mont_deduit) {
                                                $smc->setEntree($smc->getEntree() + $mont_deduit);
                                                $smc->setSolde($smc->getSolde() - $mont_deduit);
                                                $mont_deduit = 0;
                                                $m_smc->update($smc);
                                            } else {
                                                $smc->setEntree($smc->getEntree() + $smc->getSortie());
                                                $smc->setSolde($smc->getSolde() - $smc->getSortie());
                                                $mont_deduit = $mont_deduit - $smc->getSortie();
                                                $m_smc->update($smc);
                                                $j++;
                                            }
                                        } else {
                                            $db->rollback();
                                            $this->view->message = 'Les smc sont inexistants ';
                                            $this->view->compte = $type_compte;
                                            $this->view->e_membre = $membre;
                                            $this->view->montant = $montant;
                                            $this->view->message = $message;
                                            return;
                                        }
                                    }
                                } else {
                                    $db->rollback();
                                    $this->view->message = "Cet Salaire n'est pas issu d'une subvention";
                                    $this->view->compte = $type_compte;
                                    $this->view->e_membre = $membre;
                                    $this->view->montant = $montant;
                                    $this->view->message = $message;
                                    return;
                                }
                            } else {
                                $tsal = new Application_Model_DbTable_EuSalaireAffecter();
                                $tselect = $tsal->select();
                                $tselect->where('id_credit = ?', $cred->getId_credit());
                                $tselect->order('mont_affecter', 'desc');
                                $resultSets = $tsal->fetchAll($tselect);
                                if (count($resultSets) > 0) {
                                    $j = 0;
                                    $smc = new Application_Model_EuSmc();
                                    $m_smc = new Application_Model_EuSmcMapper();
                                    while ($mont_deduit > 0 && $j < count($resultSets)) {
                                        $servir = $resultSets[$j];
                                        $ret = $m_smc->find($servir->id_smc, $smc);
                                        if ($ret) {
                                            if ($smc->getSortie() >= $mont_deduit) {
                                                $smc->setEntree($smc->getEntree() + $mont_deduit)
                                                        ->setSolde($smc->getSolde() - $mont_deduit);
                                                $mont_deduit = 0;
                                                $m_smc->update($smc);
                                            } else {
                                                $smc->setEntree($smc->getEntree() + $smc->getSortie())
                                                        ->setSolde($smc->getSolde() - $smc->getSortie());
                                                $mont_deduit = $mont_deduit - $smc->getSortie();
                                                $m_smc->update($smc);
                                                $j++;
                                            }
                                        } else {
                                            $db->rollback();
                                            $this->view->message = 'Les smc sont inexistants ';
                                            return;
                                        }
                                    }
                                } else {
                                    $db->rollback();
                                    $this->view->message = "Cet Salaire n'est pas issu d'une affectation";
                                    return;
                                }
                            }
                            $i = $i + 1;
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = 'Pas de crédits correspondant à ce compte trouvés';
                        $this->view->compte = $type_compte;
                        $this->view->e_membre = $membre;
                        $this->view->montant = $montant;
                        $this->view->message = $message;
                        return;
                    }
                    $db->commit();
                } else {
                    $db->rollback();
                    $message = 'Le salaire disponible est insuffisant pour effectuer cet escompte par ce compte ' . $num_compte;
                    $this->view->compte = $type_compte;
                    $this->view->e_membre = $membre;
                    $this->view->montant = $montant;
                    $this->view->message = $message;
                    return;
                }
            } catch (PDOException $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                $this->view->compte = $type_compte;
                $this->view->e_membre = $membre;
                $this->view->montant = $montant;
                $this->view->message = $message;
                return;
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
            if ($result->type_membre == 'm') {
                $data[2] = $result->raison_sociale;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function raisonAction() {
        $request = $this->getRequest();
        $num_membre = $request->num_membre;

        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[0] = strtoupper($result->raison_sociale);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function egcpmatureAction() {
        
    }

    public function gcpmatAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $membre = $request->membre;
            $type_compte = $request->compte;
            $montant = $request->montant;
            $tpagcps = $request->tpagcp;
            $compte_dest = $request->compte_obt;
            $echu = $request->echu;
            $CODE_MEMBRE_phys = $request->membre_phys;

            $compte = '';
            $cpte_map = new Application_Model_EuCompteMapper();
            $cpte_origine = new Application_Model_EuCompte();
            $compte = 'nb-tpa' . $type_compte . '-' . $membre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $res = $cpte_map->find($compte, $cpte_origine);
                if ($res) {
                    $tpamapper = new Application_Model_EuTpagcpMapper();
                    if (isset($echu)) {
                        $som_echu = $tpamapper->findSommeTpaGcpEchu($cpte_origine->getCode_compte());
                    } else {
                        $som_echu = $tpamapper->findSommeTpaGcp($tpagcps);
                    }

                    if ($som_echu > 0 && $som_echu >= $montant) {
                        $pck = Util_Utils::getParametre('pck', 'nr');
                        $prk = Util_Utils::getParametre('prk', 'nr');
                        if (isset($echu)) {
                            $mont_recu = ($montant * $prk) / $pck;
                        } else {
                            $mont_recu = $montant;
                        }
                        if ($compte_dest == 'Inr') {
                            $newcompte = 'nb-tpagci-' . $membre;
                            $code_cat = 'tpagci';
                            $code_membre = $membre;
                        } else {
                            $newcompte = 'nb-tpagcrpg-' . $CODE_MEMBRE_phys;
                            $code_cat = 'tpagcrpg';
                            $code_membre = $code_membre_phys;
                        }

                        //Creation du compte de destination de l'échange
                        $date = Zend_Date::now();
                        $ccompte = new Application_Model_EuCompte();
                        $result = $cpte_map->find($newcompte, $ccompte);
                        if ($result == false) {
                            $ccompte->setCode_membre($code_membre)
                                    ->setCode_cat($code_cat)
                                    ->setSolde($mont_recu)
                                    ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                    ->setCode_compte($newcompte)
                                    ->setLib_compte($code_cat)
                                    ->setDesactiver(0);
                            $cpte_map->save($ccompte);
                        } else {
                            $ccompte->setSolde($ccompte->getSolde() + $mont_recu);
                            $cpte_map->update($ccompte);
                        }

                        $mapper = new Application_Model_EuOperationMapper();
                        $compteur = $mapper->findConuter() + 1;
                        $date_fin = clone $date;
                        Util_Utils::addOperation($compteur, $code_membre, $code_cat, $montant, $compte_dest, 'Echange du gcp en rpg ou i', 'Egcp', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->iD_UTiLiSATEUR);

                        //Mise à jour des comptes credits
                        $cc_mapper = new Application_Model_EuCompteCreditMapper();
                        $source = $code_membre . $date->toString('yyyyMMddHHmmss');
                        $max_code = $cc_mapper->findConuter() + 1;
                        $periode = Util_Utils::getParametre('periode', 'valeur');
                        $date_fin->addDay($periode);
                        $compte_source = '';
                        if ($compte_dest == 'RPGnr') {
                            $compte_source = 'caparpg';
                        } elseif ($compte_dest == 'Inr') {
                            $compte_source = 'capai';
                        }
                        Util_Utils::createCompteCredit($max_code, 0, $compteur, $code_membre, $compte_dest, $newcompte, $mont_recu, $montant, $date, $date_fin, $source, $compte_source, 'n', 'n', 0, 0, nULL, $prk, 'CnPG');

                        $echange = new Application_Model_EuEchange();
                        $echange_map = new Application_Model_EuEchangeMapper();
                        $echange->setCat_echange('egcp')
                                ->setType_echange('nb/nb')
                                ->setCode_compte_ech($compte)
                                ->setDate_echange($date->toString('yyyy-mm-dd'))
                                ->setCode_membre($membre)
                                ->setMontant_echange($montant)
                                ->setMontant($mont_recu)
                                ->setAgio(0)
                                ->setCompenser(0)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setCode_compte_obt($newcompte)
                                ->setCode_produit($type_compte)
                                ->setId_credit($max_code);
                        $echange_map->save($echange);
                        $num_echange = $db->lastInsertId();

                        $tpagcp = new Application_Model_EuTpagcp();
                        $cnp_mapper = new Application_Model_EuCnpMapper();
                        $tcnp = new Application_Model_DbTable_EuCnpEntree();
                        $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                        $cred_ech = new Application_Model_EuCreditEchange();
                        $rappro_mapper = new Application_Model_EuRapprochementMapper();
                        for ($i = 0; $i < count($tpagcps); $i++) {
                            $res = $tpamapper->find($tpagcps[$i], $tpagcp);
                            if ($res) {
                                if (isset($echu)) {
                                    $mont_deduire = $tpagcp->getMont_echu();
                                } else {
                                    $mont_deduire = $tpagcp->getSolde();
                                }
                                $select = $db->select()
                                        ->from(array('p' => 'eu_gcp_prelever'), array('id_tpagcp', 'id_gcp', 'mont_prelever'))
                                        ->join(array('g' => 'eu_gcp'), 'p.id_gcp = g.id_gcp', array('id_credit', 'source'))
                                        ->where('p.id_tpagcp = ?', $tpagcp->getId_tpagcp())
                                        ->where('mont_prelever > ?', 0);
                                $stmt = $db->query($select);
                                $results = $stmt->fetchAll();
                                if (count($results) > 0) {
                                    foreach ($results as $row) {
                                        $cnp = $cnp_mapper->findCnpByCreditSource($row['id_credit'], $row['source']);
                                        if ($cnp != null && $cnp->getSolde_cnp() >= $mont_deduire) {
                                            $cnp->setMont_credit($cnp->getMont_credit() + $mont_deduire)
                                                    ->setSolde_cnp($cnp->getSolde_cnp() - $mont_deduire);
                                            $cnp_mapper->update($cnp);
                                            $ecnp = new Application_Model_EuCnpEntree();
                                            $ecnp->setId_cnp($cnp->getId_cnp())
                                                    ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                    ->setMont_cnp_entree($mont_deduire)
                                                    ->setType_cnp_entree('gcp');
                                            $tcnp->insert($ecnp->toArray());

                                            $cred_ech->setId_credit($cnp->getId_credit())
                                                    ->setId_echange($num_echange)
                                                    ->setMont_echange($mont_deduire)
                                                    ->setSource_credit($row['source'])
                                                    ->setAgio(0);
                                            $tcredit_ech->insert($cred_ech->toArray());

                                            $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                            $rappro = $rappro_mapper->findRapproByCreditSource($row['id_credit'], $row['source'], $type_rappro);
                                            if ($rappro != null) {
                                                $rappro->setCredit_rappro($rappro->getCredit_rappro() + $mont_deduire)
                                                        ->setSolde_rappro($rappro->getDebit_rappro() - $rappro->getCredit_rappro());
                                                $rappro_mapper->update($rappro);
                                            } else {
                                                $rappro = new Application_Model_EuRapprochement();
                                                $rappro->setDebit_rappro(0)
                                                        ->setCredit_rappro($mont_deduire)
                                                        ->setSolde_rappro($mont_deduire)
                                                        ->setSource('cnp')
                                                        ->setSource_credit($row['source'])
                                                        ->setCode_smcipn(null)
                                                        ->setId_credit($row['id_credit'])
                                                        ->setType_rappro($type_rappro);
                                                $rappro_mapper->save($rappro);
                                            }
                                            break;
                                        } elseif ($cnp != null && $cnp->getSolde_cnp() > 0) {
                                            $ecnp = new Application_Model_EuCnpEntree();
                                            $ecnp->setId_cnp($cnp->getId_cnp())
                                                    ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                    ->setMont_cnp_entree($cnp->getSolde_cnp())
                                                    ->setType_cnp_entree('gcp');
                                            $tcnp->insert($ecnp->toArray());

                                            $cred_ech->setId_credit($cnp->getId_credit())
                                                    ->setId_echange($num_echange)
                                                    ->setMont_echange($cnp->getSolde_cnp())
                                                    ->setSource_credit($row['source'])
                                                    ->setAgio(0);
                                            $tcredit_ech->insert($cred_ech->toArray());

                                            $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                            $rappro = $rappro_mapper->findRapproByCreditSource($row['id_credit'], $row['source'], $type_rappro);
                                            if ($rappro != null) {
                                                $rappro->setCredit_rappro($rappro->getCredit_rappro() + $cnp->getSolde_cnp())
                                                        ->setSolde_rappro($rappro->getDebit_rappro() - $rappro->getCredit_rappro());
                                                $rappro_mapper->update($rappro);
                                            } else {
                                                $rappro = new Application_Model_EuRapprochement();
                                                $rappro->setDebit_rappro(0)
                                                        ->setCredit_rappro($cnp->getSolde_cnp())
                                                        ->setSolde_rappro($cnp->getSolde_cnp())
                                                        ->setSource('cnp')
                                                        ->setSource_credit($row['source'])
                                                        ->setCode_smcipn(null)
                                                        ->setId_credit($row['id_credit'])
                                                        ->setType_rappro($type_rappro);
                                                $rappro_mapper->save($rappro);
                                            }

                                            $mont_deduire -= $cnp->getSolde_cnp();
                                            $cnp->setMont_credit($cnp->getMont_credit() + $cnp->getSolde_cnp())
                                                    ->setSolde_cnp($cnp->getSolde_cnp() - $cnp->getSolde_cnp());
                                            $cnp_mapper->update($cnp);
                                        } else {
                                            $db->rollback();
                                            $message = "Crédits déja utilisés ou non issu du cnp ou le solde des cnp est nul !!!";
                                            $this->view->message = $message;
                                            return;
                                        }
                                    }
                                }
                                if (isset($echu)) {
                                    $tpagcp->setMont_echange($tpagcp->getMont_echange() + $tpagcp->getMont_echu());
                                    $tpagcp->setMont_echu(0);
                                } else {
                                    $tpagcp->setMont_echange($tpagcp->getMont_echange() + $tpagcp->getSolde());
                                    $tpagcp->setSolde(0);
                                }
                                $tpamapper->update($tpagcp);
                            }
                        }
                        $db->commit();
                        $this->view->message = 'succes';
                        return;
                    } else {
                        $db->rollback();
                        $message = "Erreur d'éxécution : La somme des gcp echues n'est pas suffisant pour effectuer cette opération ";
                        $this->view->message = $message;
                        return;
                    }
                } else {
                    $db->rollback();
                    $message = "Erreur d'éxécution : Le compte " . $compte . " est invalide pour effectuer cette opération ";
                    $this->view->message = $message;
                    return;
                }
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . ' Trace ->' . $e->getMessage();
                $this->view->message = $message;
                return;
            }
        }
    }

    public function donewgcpAction() {
        $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        if ($this->getRequest()->isPost()) {
            $echange = new Application_Model_EuEchange();
            $m_echange = new Application_Model_EuEchangeMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $membre = $request->membre;
                $membrep = $request->membrep;
                $cpte = $request->categorie;
                $montant = $request->montant;
                $credit = $request->compte;
                //$cat = $request->cat;
                $compte = 'nb-tpa' . $cpte . '-' . $membre;
                $cm_mapper = new Application_Model_EuCompteMapper();
                $cc_mapper = new Application_Model_EuCompteCreditMapper();
                $rappro_mapper = new Application_Model_EuRapprochementMapper();
                $gcp_preleve_mapper = new Application_Model_EuGcpPreleverMapper();
                $cnp_mapper = new Application_Model_EuCnpMapper();
                $cpte_origine = new Application_Model_EuCompte();
                $gcp_mapper = new Application_Model_EuGcpMapper();
                $op_mapper = new Application_Model_EuOperationMapper();
                $result = $cm_mapper->find($compte, $cpte_origine);
                $reste_gcp = $gcp_mapper->findSommeGcp($membre);
                if ($result && $reste_gcp > 0) {

                    if ($cpte_origine->getSolde() >= $montant && $reste_gcp >= $montant) {
                        if ($credit == 'Inr') {
                            $code_cat = 'tpagci';
                            $newcompte = 'nb-tpagci-' . $membrep;
                        } else {
                            $code_cat = 'tpagcrpg';
                            $newcompte = 'nb-tpagcrpg-' . $membrep;
                        }

                        //Enregistrement de l'opération
                        $count = $op_mapper->findConuter() + 1;
                        $op = new Application_Model_EuOperation();
                        $op->setId_operation($count)
                                ->setDate_op($date->toString('yyyy-mm-dd'))
                                ->setHeure_op($date->toString('hh:mm'))
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setCode_membre($membre)
                                ->setMontant_op($montant)
                                ->setCode_produit('gcp')
                                ->setLib_op('Echange du gcp')
                                ->setType_op('ee')
                                ->setCode_cat('tpagcp');
                        $op_mapper->save($op);

                        $echange->setCode_membre($membre)
                                ->setCode_compte_ech($compte)
                                ->setMontant($montant)
                                ->setDate_echange($date->toString('yyyy-mm-dd'))
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setType_echange('nb/nb')
                                ->setCat_echange($cpte)
                                ->setAgio(0)
                                ->setCompenser(0)
                                ->setCode_produit($cpte)
                                ->setMontant_echange($montant)
                                ->setCode_compte_obt($newcompte);
                        $m_echange->save($echange);
                        $num_echange = $db->lastInsertId();

                        $ccompte = new Application_Model_EuCompte();
                        $result = $cm_mapper->find($newcompte, $ccompte);
                        if ($result == false) {
                            $ccompte->setDesactiver(0)
                                    ->setSolde($montant)
                                    ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                    ->setCode_compte($newcompte)
                                    ->setLib_compte($credit)
                                    ->setSource($compte)
                                    ->setCode_cat($code_cat)
                                    ->setCode_type_compte('nb')
                                    ->setCode_membre($membrep);
                            $cm_mapper->save($ccompte);
                        } else {
                            $ccompte->setSolde($ccompte->getSolde() + $montant);
                            $cm_mapper->update($ccompte);
                        }

                        $cpte_credit = new Application_Model_EuCompteCredit();
                        $maxcc = $cc_mapper->findConuter() + 1;
                        $source = $membre . $date->toString('yyyyMMddHHmmss');
                        $cpte_credit->setId_credit($maxcc)
                                ->setCode_produit($credit)
                                ->setMontant_place($montant)
                                ->setDatedeb($date->toString('yyyy-mm-dd'))
                                ->setDatefin($date->toString('yyyy-mm-dd'))
                                ->setDate_octroi($date->toString('yyyy-mm-dd'))
                                ->setSource($source)
                                ->setCode_compte($newcompte)
                                ->setId_operation($count)
                                ->setBnp(0)
                                ->setCode_type_credit('cnpg')
                                ->setPrk(8)
                                ->setCompte_source($compte)
                                ->setMontant_credit($montant)
                                ->setRenouveller('n')
                                ->setDomicilier(0)
                                ->setAffecter(0)
                                ->setKrr('n')
                                ->setCode_membre($membrep);
                        $cc_mapper->save($cpte_credit);

                        $cnp = new Application_Model_EuCnp();
                        $m_cnp = new Application_Model_EuCnpMapper();
                        $cnp->setId_credit($maxcc)
                                ->setDate_cnp($date->toString('yyyy-mm-dd'))
                                ->setMont_debit($montant)
                                ->setMont_credit(0)
                                ->setSolde_cnp($montant)
                                ->setType_cnp($credit)
                                ->setSource_credit($source)
                                ->setCode_capa(null)
                                ->setTransfert_gcp(0);
                        if ($credit == 'Inr') {
                            $cnp->setOrigine_cnp('egcp-Inr');
                        } else {
                            $cnp->setOrigine_cnp('egcp-RPGnr');
                        }
                        $m_cnp->save($cnp);

                        $cpte_origine->setSolde($cpte_origine->getSolde() - $montant);
                        $cm_mapper->update($cpte_origine);

                        //Mise à jour du tegcp correspondant
                        $te = new Application_Model_EuTegc();
                        $te_mapper = new Application_Model_EuTegcMapper();
                        if ($te_mapper->findByMembre($membre, $te)) {
                            $te->setMontant($te->getMontant() - $montant);
                            $te_mapper->update($te);
                        } else {
                            $this->view->message = 'Le te du membre N°' . $membre . " n'existe pas";
                            $db->rollback();
                            return;
                        }

                        $gcps = $gcp_mapper->findGcp($membre);
                        $tcnp = new Application_Model_DbTable_EuCnpEntree();
                        $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                        $cred_ech = new Application_Model_EuCreditEchange();
                        if (count($gcps) > 0) {
                            $j = 0;
                            while ($montant > 0 && $j < count($gcps)) {
                                $gcp = $gcps[$j];
                                if ($gcp->getReste() < $montant) {
                                    $montant = $montant - $gcp->getReste();

                                    $gcp_preleve = new Application_Model_EuGcpPrelever();
                                    $gcp_preleve->setId_gcp($gcp->getId_gcp())
                                            ->setId_operation($count)
                                            ->setCode_tegc($gcp->getCode_tegc())
                                            ->setCode_membre($membre)
                                            ->setMont_prelever($gcp->getReste())
                                            ->setId_credit($gcp->getId_credit())
                                            ->setSource_credit($gcp->getSource())
                                            ->setMont_rapprocher($gcp->getReste())
                                            ->setSolde_prelevement(0)
                                            ->setRapprocher(1)
                                            ->setDate_prelevement($date->toString('yyyy-mm-dd'))
                                            ->setHeure_prelevement($date->toString('hh:mm'));
                                    $gcp_preleve_mapper->save($gcp_preleve);

                                    $cnp = $cnp_mapper->findCnpByCreditSource($gcp->getId_credit(), $gcp->getSource());
                                    if ($cnp != null) {
                                        //Mise à jour du cnp
                                        $cnp->setMont_credit($cnp->getMont_credit() + $gcp->getReste())
                                                ->setSolde_cnp($cnp->getSolde_cnp() - $gcp->getReste());
                                        $cnp_mapper->update($cnp);

                                        $ecnp = new Application_Model_EuCnpEntree();
                                        $ecnp->setId_cnp($cnp->getId_cnp())
                                                ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                ->setMont_cnp_entree($gcp->getReste())
                                                ->setType_cnp_entree('gcp');
                                        $tcnp->insert($ecnp->toArray());

                                        $cred_ech->setId_credit($cnp->getId_credit())
                                                ->setId_echange($num_echange)
                                                ->setMont_echange($gcp->getReste())
                                                ->setSource_credit($gcp->getSource())
                                                ->setAgio(0);
                                        $tcredit_ech->insert($cred_ech->toArray());

                                        //Décrémentation, annulation ou mise en attente dans la table de rapprochement
                                        $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                        $rappro = $rappro_mapper->findRapproByCreditSource($gcp->getId_credit(), $gcp->getSource(), $type_rappro);
                                        if ($rappro != null) {
                                            $rappro->setCredit_rappro($rappro->getCredit_rappro() + $gcp->getReste());
                                            $rappro->setSolde_rappro($rappro->getDebit_rappro() - $rappro->getCredit_rappro());
                                            $rappro_mapper->update($rappro);
                                        } else {
                                            $rappro = new Application_Model_EuRapprochement();
                                            $rappro->setDebit_rappro(0)
                                                    ->setCredit_rappro($gcp->getReste())
                                                    ->setSolde_rappro($gcp->getReste())
                                                    ->setSource('cnp')
                                                    ->setSource_credit($gcp->getSource())
                                                    ->setCode_smcipn(null)
                                                    ->setId_credit($gcp->getId_credit())
                                                    ->setType_rappro($type_rappro);
                                            $rappro_mapper->save($rappro);
                                        }
                                    } else {
                                        $this->view->message = 'Les cnp du credit N°' . $gcp->getId_credit() . " n'existent pas";
                                        $db->rollback();
                                        return;
                                    }

                                    //Mise à jour du gcp
                                    $gcp->setMont_preleve($gcp->getMont_preleve() + $gcp->getReste());
                                    $gcp->setReste(0);
                                    $gcp_mapper->update($gcp);
                                    $j = $j + 1;
                                } else {
                                    $gcp->setMont_preleve($gcp->getMont_preleve() + $montant);
                                    $gcp->setReste($gcp->getReste() - $montant);
                                    $gcp_mapper->update($gcp);

                                    $gcp_preleve = new Application_Model_EuGcpPrelever();
                                    $gcp_preleve->setId_gcp($gcp->getId_gcp())
                                            ->setId_operation($count)
                                            ->setCode_tegc($gcp->getCode_tegc())
                                            ->setCode_membre($membre)
                                            ->setMont_prelever($montant)
                                            ->setId_credit($gcp->getId_credit())
                                            ->setSource_credit($gcp->getSource())
                                            ->setMont_rapprocher($montant)
                                            ->setSolde_prelevement(0)
                                            ->setRapprocher(1)
                                            ->setDate_prelevement($date->toString('yyyy-mm-dd'))
                                            ->setHeure_prelevement($date->toString('hh:mm:ss'));
                                    $gcp_preleve_mapper->save($gcp_preleve);

                                    $cnp = $cnp_mapper->findCnpByCreditSource($gcp->getId_credit(), $gcp->getSource());
                                    if ($cnp != null) {
                                        $cnp->setMont_credit($cnp->getMont_credit() + $montant)
                                                ->setSolde_cnp($cnp->getSolde_cnp() - $montant);
                                        $cnp_mapper->update($cnp);
                                        $ecnp = new Application_Model_EuCnpEntree();
                                        $ecnp->setId_cnp($cnp->getId_cnp())
                                                ->setDate_entree($date->toString('yyyy-mm-dd'))
                                                ->setMont_cnp_entree($montant)
                                                ->setType_cnp_entree('gcp');
                                        $tcnp->insert($ecnp->toArray());

                                        $cred_ech->setId_credit($cnp->getId_credit())
                                                ->setId_echange($num_echange)
                                                ->setMont_echange($montant)
                                                ->setSource_credit($gcp->getSource())
                                                ->setAgio(0);
                                        $tcredit_ech->insert($cred_ech->toArray());

                                        $type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
                                        $rappro = $rappro_mapper->findRapproByCreditSource($gcp->getId_credit(), $gcp->getSource(), $type_rappro);
                                        if ($rappro == null) {
                                            $rappro = new Application_Model_EuRapprochement();
                                            $rappro->setDebit_rappro(0)
                                                    ->setCredit_rappro($montant)
                                                    ->setSolde_rappro($rappro->getCredit_rappro() - $rappro->getDebit_rappro())
                                                    ->setSource('cnp')
                                                    ->setSource_credit($gcp->getSource())
                                                    ->setCode_smcipn(null)
                                                    ->setId_credit($gcp->getId_credit())
                                                    ->setType_rappro($type_rappro);
                                            $rappro_mapper->save($rappro);
                                        } else {
                                            $rappro->setCredit_rappro($rappro->getCredit_rappro() + $montant);
                                            $rappro->setSolde_rappro($rappro->getCredit_rappro() - $rappro->getDebit_rappro());
                                            $rappro_mapper->update($rappro);
                                        }
                                    } else {
                                        $this->view->message = 'Les cnp du credit N°' . $gcp->getId_credit() . " code source :" . $gcp->getSource() . " n'existent pas";
                                        $db->rollback();
                                        return;
                                    }
                                    $montant = 0;
                                    $j = $j + 1;
                                }
                            }
                        }

                        $db->commit();
                        $this->view->message = true;
                        return;
                    } else {
                        $db->rollback();
                        $message = 'Le montant du compte gcp: Reste= ' . $reste_gcp . ' est insufisant pour cet échange';
                        $this->view->message = $message;
                        return;
                    }
                } else {
                    $db->rollback();
                    $message = "Le compte gcp de ce membre est null !!!";
                    $this->view->message = $message;
                    return;
                }
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                $this->view->message = $message;
                return;
            }
        }
    }

    public function newgcpAction() {
        $request = $this->getRequest();
        $form = new Application_Form_EuEchangeGcp();
        $cat = $request->cat;
        $m_map = new Application_Model_EuMembreMapper();
        $membres = array();
        if ($cat == 'i') {
            $form->getElement("compte")->addMultiOptions(array('Inr' => 'Inr'));
            $form->getElement("categorie")->setValue('gcp')->setattrib('readOnly', 'true');
            $rows = $m_map->fetchAllByType('m');
            foreach ($rows as $c) {
                $membres[] = $c->code_membre;
            }
            $form->getElement("membrep")->setJQueryParams(array('source' => $membres));
        } else {
            $form->getElement("membrep")->setattrib('required', 'true');
            $form->getElement("compte")->addMultiOptions(array('RPGnr' => 'RPGnr'));
            $form->getElement("categorie")->setValue('gcp')->setattrib('readOnly', 'true');
            $rows = $m_map->fetchAllByType('p');
            $membres = array();
            foreach ($rows as $c) {
                $membres[] = $c->code_membre;
            }
            $form->getElement("membrep")->setJQueryParams(array('source' => $membres));
        }
        $form->getElement("cat")->setValue($cat);
        $form->getElement("categorie")->setValue('gcp')->setattrib('readOnly', 'true');
        $this->view->form = $form;
    }

    public function newcncsAction() {
        $request = $this->getRequest();
        $type = $request->type;
        $form = new Application_Form_EuEchangeCncs();
        if ($type == 'nr') {
            $form->getElement("compte")->addMultiOptions(array('CNCSnr' => 'CNCSnr'));
            $form->getElement("categorie")->addMultiOptions(array('tcncs' => 'tcncs'));
        } else {
            $form->getElement("compte")->addMultiOptions(array('CNCSr' => 'CNCSr'));
            $form->getElement("categorie")->addMultiOptions(array('tcncs' => 'tcncs'));
        }
        $form->getElement("type")->setValue($type);
        $this->view->form = $form;
    }

    public function donewcncsAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        if ($this->getRequest()->isPost()) {
            $request = $this->getRequest();
            $membre = $request->membre;
            $categorie = $request->categorie;
            $cpte = $request->compte;
            $montant = $request->montant;
            //$type = $request->type;
            $membre_benef = $request->membre_benef;
            $credit = $request->compte;
            $echange = new Application_Model_EuEchange();
            $m_echange = new Application_Model_EuEchangeMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $compte = 'nr-' . $categorie . '-' . $membre;
                $cm_mapper = new Application_Model_EuCompteMapper();
                $cc_mapper = new Application_Model_EuCompteCreditMapper();
                $op_mapper = new Application_Model_EuOperationMapper();
                $cpte_origine = new Application_Model_EuCompte();
                $result = $cm_mapper->find($compte, $cpte_origine);
                if ($result) {
                    $somme = 0;
                    $credits = array();
                    if ($cpte_origine->getSolde() >= $montant) {
                        $credits = $cc_mapper->fetchByCompte($compte);
                        if (count($credits) > 0) {
                            foreach ($credits as $value) {
                                $datefin = new Zend_Date($value->getDatefin(), Zend_Date::ISO_8601);
                                if ($datefin->compare($date) <= 0) {
                                    $somme += $value->getMontant_credit();
                                }
                            }
                            if ($somme > 0 && $somme >= $montant) {
                                $pck = Util_Utils::getParametre('pck', 'nr');
                                $prk = Util_Utils::getParametre('prk', 'nr');
                                $mont_credit = $montant + ($montant * $prk / $pck);
                                $newcompte = 'nb-tpagcrpg-' . $membre_benef;
                                //Enregistrement de l'opération
                                $count = $op_mapper->findConuter() + 1;
                                $op = new Application_Model_EuOperation();
                                $op->setId_operation($count)
                                        ->setDate_op($date->toString('yyyy-mm-dd'))
                                        ->setHeure_op($date->toString('hh:mm'))
                                        ->setId_utilisateur($user->id_utilisateur)
                                        ->setCode_membre($membre)
                                        ->setMontant_op($montant)
                                        ->setCode_produit($cpte)
                                        ->setLib_op('Echange du cncs')
                                        ->setType_op('ee')
                                        ->setCode_cat($categorie);
                                $op_mapper->save($op);

                                $ccompte = new Application_Model_EuCompte();
                                $result = $cm_mapper->find($newcompte, $ccompte);
                                if ($result == false) {
                                    $ccompte->setCode_membre($membre_benef)
                                            ->setSolde($mont_credit)
                                            ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                            ->setCode_compte($newcompte)
                                            ->setLib_compte($credit)
                                            ->setCode_cat('tpagcrpg')
                                            ->setCode_type_compte('nb')
                                            ->setDesactiver(0);
                                    $cm_mapper->save($ccompte);
                                } else {
                                    $ccompte->setSolde($ccompte->getSolde() + $mont_credit);
                                    $cm_mapper->update($ccompte);
                                }

                                $cpte_credit = new Application_Model_EuCompteCredit();
                                $maxcc = $cc_mapper->findConuter() + 1;
                                $source = $membre . $date->toString('yyyyMMddHHmmss');
                                $cpte_credit->setId_credit($maxcc)
                                        ->setCode_membre($membre_benef)
                                        ->setCode_produit('RPGnr')
                                        ->setMontant_place($montant)
                                        ->setDatedeb($date->toString('yyyy-mm-dd'))
                                        ->setDatefin($date->toString('yyyy-mm-dd'))
                                        ->setDate_octroi($date->toString('yyyy-mm-dd'))
                                        ->setSource($source)
                                        ->setCode_compte($newcompte)
                                        ->setId_operation($count)
                                        ->setBnp(0)
                                        ->setCode_type_credit('cnpg')
                                        ->setPrk($prk)
                                        ->setCompte_source($compte)
                                        ->setMontant_credit($mont_credit)
                                        ->setRenouveller('n')
                                        ->setDomicilier(0)
                                        ->setKrr('n')
                                        ->setAffecter(0);
                                $cc_mapper->save($cpte_credit);

                                $echange->setCode_membre($membre)
                                        ->setCode_compte_ech($compte)
                                        ->setMontant($mont_credit)
                                        ->setDate_echange($date->toString('yyyy-mm-dd'))
                                        ->setId_utilisateur($user->id_utilisateur)
                                        ->setType_echange('nr/nb')
                                        ->setCat_echange('cncs')
                                        ->setAgio(0)
                                        ->setCompenser(0)
                                        ->setCode_produit($cpte)
                                        ->setId_credit($maxcc)
                                        ->setMontant_echange($montant)
                                        ->setCode_compte_obt($newcompte);
                                $m_echange->save($echange);
                                $num_echange = $db->lastInsertId();

                                $cnp = new Application_Model_EuCnp();
                                $m_cnp = new Application_Model_EuCnpMapper();
                                $cnp->setId_credit($maxcc)
                                        ->setDate_cnp($date->toString('yyyy-mm-dd'))
                                        ->setMont_debit($montant)
                                        ->setMont_credit(0)
                                        ->setSolde_cnp($mont_credit)
                                        ->setType_cnp($credit)
                                        ->setSource_credit($source)
                                        ->setCode_capa(null)
                                        ->setTransfert_gcp(0);
                                if ($cpte == 'CNCSr') {
                                    $cnp->setOrigine_cnp('ECNCSr');
                                } else {
                                    $cnp->setOrigine_cnp('ECNCSnr');
                                }
                                $m_cnp->save($cnp);

                                $cpte_origine->setSolde($cpte_origine->getSolde() - $montant);
                                $cm_mapper->update($cpte_origine);

                                //mise de la table de rapprochement 
                                $i = 0;
                                $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                                $cred_ech = new Application_Model_EuCreditEchange();
                                $reste = $montant;
                                while ($reste > 0 && $i < count($credits)) {
                                    $cred = $credits[$i];
                                    $mont_deduit = 0;
                                    if ($reste > $cred->getMontant_credit()) {
                                        $mont_deduit = $cred->getMontant_credit();
                                        $reste = $reste - $mont_deduit;
                                        $cred->setMontant_credit(0);
                                        $cc_mapper->update($cred);
                                    } else {
                                        $mont_deduit = $reste;
                                        $reste = 0;
                                        $cred->setMontant_credit($cred->getMontant_credit() - $mont_deduit);
                                        $cc_mapper->update($cred);
                                    }

                                    $cred_ech->setId_credit($cred->getId_credit())
                                            ->setId_echange($num_echange)
                                            ->setMont_echange($mont_deduit)
                                            ->setSource_credit($cred->getSource())
                                            ->setAgio(0);
                                    $tcredit_ech->insert($cred_ech->toArray());

                                    $m_smc = new Application_Model_EuSmcMapper();
                                    $smc = new Application_Model_EuSmc();
                                    if ($cred->getCode_produit() === 'CNCSr') {
                                        $tservir = new Application_Model_DbTable_EuUtiliser();
                                        $tselect = $tservir->select();
                                        $tselect->where('code_smcipn = ?', $cred->getCompte_Source());
                                        $tselect->order('MONTANT_allouer', 'desc');
                                        $resultSets = $tservir->fetchAll($tselect);
                                        if (count($resultSets) > 0) {
                                            $j = 0;
                                            while ($mont_deduit > 0 && $j < count($resultSets)) {
                                                $servir = $resultSets[$j];
                                                $ret = $m_smc->find($servir->id_smc, $smc);
                                                if ($ret) {
                                                    if ($smc->getSortie() >= $mont_deduit) {
                                                        $smc->setEntree($smc->getEntree() + $mont_deduit)
                                                                ->setSolde($smc->getSolde() - $mont_deduit);
                                                        $mont_deduit = 0;
                                                        $m_smc->update($smc);
                                                    } else {
                                                        $smc->setEntree($smc->getEntree() + $smc->getSortie())
                                                                ->setSolde($smc->getSolde() - $smc->getSortie());
                                                        $mont_deduit = $mont_deduit - $smc->getSortie();
                                                        $m_smc->update($smc);
                                                        $j++;
                                                    }
                                                } else {
                                                    $db->rollback();
                                                    $this->view->message = 'Les smc sont inexistants ';
                                                    return;
                                                }
                                            }
                                        } else {
                                            $db->rollback();
                                            $this->view->message = "Ce Salaire n'est pas issu d'une subvention";
                                            return;
                                        }
                                    } else {
                                        $tsal = new Application_Model_DbTable_EuSalaireAffecter();
                                        $tselect = $tsal->select();
                                        $tselect->where('id_credit = ?', $cred->getId_credit());
                                        $rowSet = $tsal->fetchAll($tselect);
                                        if (count($rowSet) > 0) {
                                            $j = 0;
                                            while ($mont_deduit > 0 && $j < count($rowSet)) {
                                                $servir = $rowSet[$j];
                                                $ret = $m_smc->find($servir->id_smc, $smc);
                                                if ($ret) {
                                                    if ($smc->getSortie() >= $mont_deduit) {
                                                        $smc->setEntree($smc->getEntree() + $mont_deduit)
                                                                ->setSolde($smc->getSolde() - $mont_deduit);
                                                        $m_smc->update($smc);
                                                        $mont_deduit = 0;
                                                    } else {
                                                        $smc->setEntree($smc->getEntree() + $smc->getSortie())
                                                                ->setSolde($smc->getSolde() - $smc->getSortie());
                                                        $mont_deduit = $mont_deduit - $smc->getSortie();
                                                        $m_smc->update($smc);
                                                        $j++;
                                                    }
                                                } else {
                                                    $db->rollback();
                                                    $this->view->message = 'Les smc sont inexistants.';
                                                    return;
                                                }
                                            }
                                        } else {
                                            $db->rollback();
                                            $this->view->message = "Cet Salaire n'est pas issu d'une affectation.";
                                            return;
                                        }
                                    }
                                    $i = $i + 1;
                                }
                                $db->commit();
                                $this->view->message = true;
                                return;
                            } else {
                                $db->rollback();
                                $this->view->message = "La somme des credits est insuffisant pour effectuer cet operation!!!";
                                return;
                            }
                        } else {
                            $db->rollback();
                            $this->view->message = "Les comptes crédits correspondant à ce compte sont introuvables!!!";
                            return;
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = "Le solde de votre compte est insuffisant pour effectuer cette operation!!!";
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->message = "Ce membre ne dispose pas de compte salaire ou ce compte est null !!!";
                    return;
                }
            } catch (Exception $e) {
                $db->rollback();
                $message = "Erreur d\'éxécution :" . $e->getMessage();
                $this->view->message = $message;
                return;
            }
        }
    }

    public function newAction() {
        $request = $this->getRequest();
        $cat = $request->cat;
        $form = new Application_Form_EuEchange();
        if ($cat == 'i') {
            $form->getElement("categorie")->setValue('tsci')->setattrib('readOnly', 'true');
            $form->getElement("cat_echange")->setValue($cat)->setattrib('readOnly', 'true');
            $form->getElement("compte")->setValue('Inr')->setattrib('readOnly', 'true');
        }
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $echange = new Application_Model_EuEchange();
                $m_echange = new Application_Model_EuEchangeMapper();
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $membre = $form->getValue('membre');
                    $categorie = $form->getValue('categorie');
                    $cpte = $form->getValue('compte');
                    $montant = $form->getValue('montant');
                    $compte = 'nr-' . $categorie . '-' . $membre;
                    $cm_mapper = new Application_Model_EuCompteMapper();
                    $cc_mapper = new Application_Model_EuCompteCreditMapper();
                    $cpte_origine = new Application_Model_EuCompte();
                    $result = $cm_mapper->find($compte, $cpte_origine);
                    if ($result) {
                        $somme = 0;
                        $credits = array();
                        if ($cpte_origine->getSolde() >= $montant) {
                            $credits = $cc_mapper->fetchByCompte($compte);
                            if (count($credits) > 0) {
                                foreach ($credits as $value) {
                                    $somme += $value->getMontant_credit();
                                }
                                if ($somme >= $montant) {

                                    $newcompte = 'nb-tpagci-' . $membre;
                                    $echange->setCode_membre($membre)
                                            ->setCode_compte_ech($compte)
                                            ->setMontant($montant)
                                            ->setMontant_echange($montant)
                                            ->setDate_echange($date->toString('yyyy-mm-dd'))
                                            ->setId_utilisateur($user->id_utilisateur)
                                            ->setType_echange($form->getValue('type_echange'))
                                            ->setCat_echange($form->getValue('cat_echange'))
                                            ->setAgio(0)
                                            ->setCompenser(0)
                                            ->setCode_compte_obt($newcompte);
                                    $m_echange->save($echange);
                                    //$num_echange = $db->lastInsertId();

                                    $ccompte = new Application_Model_EuCompte();
                                    $result = $cm_mapper->find($newcompte, $ccompte);
                                    if ($result == false) {
                                        $ccompte->setCode_membre($membre)
                                                ->setSolde($montant)
                                                ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                ->setCode_compte($newcompte)
                                                ->setLib_compte($cpte)
                                                ->setDesactiver(0)
                                                ->setCode_type_compte('nb');
                                        $cm_mapper->save($ccompte);
                                    } else {
                                        $ccompte->setSolde($ccompte->getSolde() + $montant);
                                        $cm_mapper->update($ccompte);
                                    }

                                    $cpte_origine->setSolde($cpte_origine->getSolde() - $montant);
                                    $cm_mapper->update($cpte_origine);

                                    //mise de la table de rapprochement
                                    $i = 0;
                                    $cred = $credits[$i];
                                    $reste = $montant;
                                    while ($reste > 0) {
                                        $mont_deduit = 0;
                                        if ($reste > $cred->getMontant_credit()) {
                                            $mont_deduit = $cred->getMontant_credit();
                                            $reste = $reste - $mont_deduit;
                                            $cred->setMontant_credit(0);
                                            $cc_mapper->update($cred);
                                        } else {
                                            $mont_deduit = $reste;
                                            $reste = 0;
                                            $cred->setMontant_credit($cred->getMontant_credit() - $mont_deduit);
                                            $cc_mapper->update($cred);
                                        }

                                        $mont_credit = $mont_deduit;
                                        $source = $membre . $date->toString('yyyyMMddHHmmss');
                                        $cpte_credit = new Application_Model_EuCompteCredit();
                                        $maxcc = $cc_mapper->findConuter() + 1;
                                        $cpte_credit->setId_credit($maxcc)
                                                ->setCode_membre($membre)
                                                ->setCode_produit($cpte)
                                                ->setMontant_place($mont_deduit)
                                                ->setDatedeb($date->toString('yyyy-mm-dd'))
                                                ->setDatefin($date->toString('yyyy-mm-dd'))
                                                ->setDate_octroi($date->toString('yyyy-mm-dd'))
                                                ->setSource($source)
                                                ->setCode_compte($newcompte)
                                                ->setId_operation(null)
                                                ->setCode_type_credit('cnpg')
                                                ->setPrk(8)
                                                ->setBnp(0)
                                                ->setCode_bnp($cred->getCompte_Source())
                                                ->setCompte_source($compte)
                                                ->setMontant_credit($mont_credit)
                                                ->setRenouveller('n')
                                                ->setDomicilier(0)
                                                ->setKrr('n');
                                        $cc_mapper->save($cpte_credit);

                                        $cnp = new Application_Model_EuCnp();
                                        $m_cnp = new Application_Model_EuCnpMapper();
                                        $cnp->setId_credit($maxcc)
                                                ->setDate_cnp($date->toString('yyyy-mm-dd'))
                                                ->setMont_debit($mont_credit)
                                                ->setMont_credit(0)
                                                ->setSolde_cnp($mont_credit)
                                                ->setType_cnp('Inr')
                                                ->setSource_credit($source)
                                                ->setCode_capa(null)
                                                ->setOrigine_cnp('FGInr')
                                                ->setTransfert_gcp(0);
                                        $m_cnp->save($cnp);

                                        $tservir = new Application_Model_DbTable_EuServir();
                                        $tselect = $tservir->select();
                                        $tselect->where('code_smcipn = ?', $cred->getCompte_Source());
                                        $tselect->order('MONTANT_allouer', 'desc');
                                        $resultSets = $tservir->fetchAll($tselect);
                                        if (count($resultSets) > 0) {
                                            $j = 0;
                                            $fn = new Application_Model_EuFn();
                                            $m_fn = new Application_Model_EuFnMapper();
                                            while ($mont_deduit > 0) {
                                                $servir = $resultSets[$j];
                                                $ret = $m_fn->find($servir->id_fn, $fn);
                                                if ($ret) {
                                                    if ($fn->getSortie() >= $mont_deduit) {
                                                        $fn->setEntree($fn->getEntree() + $mont_deduit);
                                                        $fn->setSolde($fn->getSolde() - $mont_deduit);
                                                        $mont_deduit = 0;
                                                        $m_fn->update($fn);
                                                    } else {
                                                        $fn->setEntree($fn->getEntree() + $fn->getSortie());
                                                        $fn->setSolde($fn->getSolde() - $fn->getSortie());
                                                        $mont_deduit = $mont_deduit - $fn->getSortie();
                                                        $m_fn->update($fn);
                                                        $j++;
                                                    }
                                                } else {
                                                    $db->rollback();
                                                    $this->view->message = 'Les fn sont inexistants ';
                                                    $this->view->form = $form;
                                                    return;
                                                }
                                            }
                                        } else {
                                            $db->rollback();
                                            $this->view->message = "Cet investissement n'est pas issu d'une subvention";
                                            $this->view->form = $form;
                                            return;
                                        }
                                        $i = $i + 1;
                                        $cred = $credits[$i];
                                    }
                                } else {
                                    $db->rollback();
                                    $this->view->message = "Le montant de vos crédits pour le compte " . $cpte_origine->getNum_compte() . " =" . $cpte_origine->getSolde() . ":" . $somme . " est insuffisant pour cet échange";
                                    $this->view->form = $form;
                                    return;
                                }
                            } else {
                                $db->rollback();
                                $this->view->message = 'Ce membre ne dispose pas de crédits correspondant au compte ' . $cpte;
                                $this->view->form = $form;
                                return;
                            }
                        } else {
                            $db->rollback();
                            $this->view->message = "Le montant de vos crédits pour le compte " . $cpte_origine->getCode_compte() . " =" . $cpte_origine->getSolde() . ":" . $somme . " est insuffisant pour cet échange";
                            $this->view->form = $form;
                            return;
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = 'Ce membre ne dispose pas de compte ' . $cpte;
                        $this->view->form = $form;
                        return;
                    }
                    $db->commit();
                    return $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $db->rollback();
                    $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                }
            }
        }
        $this->view->form = $form;
    }

    public function payementAction() {
        
    }

    public function edataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $membre = $this->_request->getParam("membre");
        $compte = $this->_request->getParam("compte");
        $e_date = $this->_request->getParam("date");
        $tabela = new Application_Model_DbTable_EuEchange();
        $select = $tabela->select();
        if ($membre != '') {
            $select->where('code_membre = ?', $membre);
        }
        if ($compte != '') {
            if ($membre != '') {
                if ($compte == 'i' || $compte == 'rpg') {
                    $num_compte = 'nn-tpagc' . $compte . '-' . $membre;
                } elseif ($compte == 'gcp') {
                    $num_compte = 'nn-tpa' . $compte . '-' . $membre;
                } else {
                    $num_compte = 'nn-' . $compte . '-' . $membre;
                }
                $select->where('code_compte_obt = ?', $num_compte);
            } else {
                $select->where('code_compte_obt like ?', '%' . $compte . '%');
            }
        }
        if ($e_date != '') {
            $date_exp = explode('/', $e_date);
            $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('date_echange = ?', $date);
        }
        $select->where('type_echange like ?', '%nn')
                ->where('regler is null');
        $echanges = $tabela->fetchAll($select);
        $count = count($echanges);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $echanges = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($echanges as $row) {
            $date_op = new Zend_Date($row->date_echange, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
                $row->id_echange,
                $date_op->toString('dd-mm-yyyy'),
                $row->code_membre,
                $row->code_compte_obt,
                $row->code_compte_ch,
                $row->montant,
                $row->montant_echange,
                $row->agio
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $id = $_GET['code'];
        $num_compte = $_GET['compte'];
        $e = new Application_Model_EuEchange();
        $me = new Application_Model_EuEchangeMapper();
        $compte = new Application_Model_EuCompte();
        $m_compte = new Application_Model_EuCompteMapper();
        $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
        $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
        $detail = new Application_Model_EuDetailGcpPbf();
        $cc = new Application_Model_EuCompteCredit();
        $cc_mapper = new Application_Model_EuCompteCreditMapper();
        $date_deb = new Zend_Date(Zend_Date::ISO_8601);
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $ret = $m_compte->find($num_compte, $compte);
            $ret_ech = $me->find($id, $e);
            if ($ret && $ret_ech) {
                if ($compte->getSolde() > $e->getMontant_echange()) {
                    $compte->setSolde($compte->getSolde() - $e->getMontant_echange());
                    $m_compte->update($compte);
                    $mont_gcp_pbf = $e->getMontant() + $e->getAgio();
                    if ($e->getCat_echange() != 'ecpr' && $e->getCat_echange() != 'eacpr') {
                        $num_cpte = 'nb-tpagcp-' . $user->code_membre;
                        $result = $m_compte->find($num_cpte, $compte);
                        if ($result == false) {
                            $compte->setCode_membre($user->code_membre)
                                    ->setDesactiver(0)
                                    ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                    ->setCode_compte($num_cpte)
                                    ->setLib_compte('gcp pbf')
                                    ->setCode_cat('tpagcp')
                                    ->setCode_type_compte("nb")
                                    ->setSolde($mont_gcp_pbf);
                            $m_compte->save($compte);
                        } else {
                            $compte->setSolde($compte->getSolde() + $mont_gcp_pbf);
                            $m_compte->update($compte);
                        }
                        $gcp_pbf = new Application_Model_EuGcpPbf();
                        if (strpos($e->getCode_produit(), 'i') !== false) {
                            $type_capa = 'capai';
                            $code_gcp_pbf = "gcp-i-" . $user->code_membre;
                        } elseif (strpos($e->getCode_produit(), 'rpg') !== false) {
                            $type_capa = 'caparpg';
                            $code_gcp_pbf = "gcp-rpg-" . $user->code_membre;
                        } elseif ($e->getCode_produit() == 'tcncs') {
                            $type_capa = 'capacncs';
                            $code_gcp_pbf = "gcp-cncs-" . $user->code_membre;
                        } else {
                            $type_capa = 'capagcp';
                            $code_gcp_pbf = "gcp-gcp-" . $user->code_membre;
                        }
                        $ret_pbf = $m_gcp_pbf->find($code_gcp_pbf, $gcp_pbf);
                        if (!$ret_pbf) {
                            $gcp_pbf->setCode_gcp_pbf($code_gcp_pbf)
                                    ->setAgio_consomme(0)
                                    ->setMont_agio($e->getAgio())
                                    ->setGcp_compense(0)
                                    ->setMont_gcp($mont_gcp_pbf)
                                    ->setMont_gcp_reel($e->getMontant())
                                    ->setCode_membre($user->code_membre)
                                    ->setCode_compte($num_cpte)
                                    ->setSolde_agio($e->getAgio())
                                    ->setSolde_gcp($mont_gcp_pbf)
                                    ->setSolde_gcp_reel($e->getMontant())
                                    ->setType_capa($type_capa);
                            $m_gcp_pbf->save($gcp_pbf);
                        } else {
                            $gcp_pbf->setSolde_agio($gcp_pbf->getSolde_agio() + $e->getAgio())
                                    ->setSolde_gcp($gcp_pbf->getSolde_gcp() + $mont_gcp_pbf)
                                    ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() + $e->getMontant())
                                    ->setMont_agio($gcp_pbf->getMont_agio() + $e->getAgio())
                                    ->setMont_gcp($gcp_pbf->getMont_gcp() + $mont_gcp_pbf)
                                    ->setMont_gcp_reel($gcp_pbf->getMont_gcp_reel() + $e->getMontant());
                            $m_gcp_pbf->update($gcp_pbf);
                        }

                        $detail = new Application_Model_EuDetailGcpPbf();
                        $tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
                        $select = $tcredit_ech->select();
                        $select->where('id_echange = ?', $e->getId_echange());
                        $ce_results = $tcredit_ech->fetchAll($select);
                        if (count($ce_results) > 0) {
                            foreach ($ce_results as $value) {
                                $ret_ce = $cc_mapper->find($value->id_credit, $cc);
                                if ($ret_ce) {
                                    $detail->setCode_gcp_pbf($code_gcp_pbf)
                                            ->setMont_gcp_pbf($value->mont_echange)
                                            ->setMont_preleve(0)
                                            ->setSolde_gcp_pbf($value->mont_echange)
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
                                    $this->view->data = "Cet echange est invalide!!!";
                                    return;
                                }
                            }
                        } else {
                            $db->rollback();
                            $this->view->data = "Cet echange est invalide!!!";
                            return;
                        }
                    }
                    $e->setRegler(1)
                            ->setDate_reglement($date_deb->toString('yyyy-mm-dd'));
                    $me->update($e);
                    //Enregistrement de l'opération
                    $op_mapper = new Application_Model_EuOperationMapper();
                    $count = $op_mapper->findConuter() + 1;
                    $op = new Application_Model_EuOperation();
                    $op->setId_operation($count)
                            ->setDate_op($date_deb->toString('yyyy-mm-dd'))
                            ->setHeure_op($date_deb->toString('hh:mm'))
                            ->setId_utilisateur($user->id_utilisateur)
                            ->setCode_membre($e->getCode_membre())
                            ->setMontant_op($e->getMontant_echange())
                            ->setCode_produit('gcp')
                            ->setLib_op("Reglement d'escompte du gcp")
                            ->setType_op('reg')
                            ->setCode_cat('tpagcp');
                    $op_mapper->save($op);
                    $db->commit();
                    $this->view->data = true;
                    return;
                }
            } else {
                $db->rollback();
                $this->view->data = "Ce compte n'existe pas";
                return;
            }
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur : ' . $exc->getTraceAsString();
            $this->view->data = $message;
            return;
        }
    }

}

?>
