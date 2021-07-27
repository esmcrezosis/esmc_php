<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDomPfbController
 *
 * @author user
 */
class EuDomPbfController extends Zend_Controller_Action {

    //put your code here
    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'banque' || $group == 'compens') {
            $menu = "<li><a href=\"/eu-dom-pbf/domicilier \">Domiciliation prk</a></li>" .
                    "<li><a href=\"/eu-dom-pbf/domicilierimm \">Domiciliation pre</a></li>" .
                    "<li><a href=\"/eu-dom-pbf \">Liste domiciliations</a></li>" .
                    "<li><a href=\"/eu-dom-pbf/rembourse \">Liste transferts</a></li>";
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
            if ($group != 'banque' && $group != 'compens') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $type_domi = 'tegcp';
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        $select->where('eu_domiciliation.code_membre_beneficiaire = ?', $user->code_membre)
                ->where('eu_domiciliation.accorder = ?', 'n')
                ->where('eu_domiciliation.type_domiciliation like ?', $type_domi)
                ->order('eu_domiciliation.date_domiciliation', 'desc');
        $domici = $tabela->fetchAll($select);
        $count = count($domici);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $domici = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($domici as $row) {
            $date_dom = new Zend_Date($row->date_domiciliation, Zend_Date::ISO_8601);
            $date_echue = new Zend_Date($row->date_echue, Zend_Date::ISO_8601);
            if ($row->cat_ressource == 'r') {
                $ress = 'Récurrent';
            } else {
                $ress = 'Non récurrent';
            }
            if ($row->domicilier == 'n') {
                $accord = 'En cours';
            } else {
                $accord = 'Terminer';
            }
            $responce['rows'][$i]['id'] = $row->code_domicilier;
            $responce['rows'][$i]['cell'] = array(
                $row->code_domicilier,
                $row->code_membre_beneficiaire,
                $ress,
                $row->montant_subvent,
                $row->montant_domicilier,
                $date_dom->toString('dd/mm/yyyy'),
                $date_echue->toString('dd/mm/yyyy'),
                $accord,
                $row->cat_ressource,
                $row->type_domiciliation,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $form = new Application_Form_EuDomiciliation();
        $this->view->form = $form;
    }

    public function domicilierAction() {
        
    }

    public function saveAction() {
        $d = new Application_Model_EuDomiciliation();
        $md = new Application_Model_EuDomiciliationMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $code_domici = $this->_request->getPost("code_demand") . '-' . $this->_request->getPost("num_client");
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $md->find($code_domici, $d);
            $d->setNum_client($this->_request->getPost("num_client"));
            $d->setNum_benef($this->_request->getPost("num_benef"));
            $d->setCat_ressource($this->_request->getPost("cat_ressource"));
            $d->setMt_subvent($this->_request->getPost("mt_subvent"));
            $d->setMt_credits($this->_request->getPost("mt_credits"));
            $d->setMt_domici($this->_request->getPost("mt_domici"));
            $d->setDomicilier($this->_request->getPost("domicilier"));
            $d->setAccorder($this->_request->getPost("accorder"));
            $d->setDate_domici($this->_request->getPost("data_domici"));
            $d->setDate_echue($date_id->toString('yyyy-mm-dd'));
            $d->setCode_demand($this->_request->getPost("code_demand"));
            $d->setCree_par($user->login);
            $md->update($d);
        }
    }

    public function creditsAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_credi');
        $sord = $this->_request->getParam("sord", 'asc');

        if ($_GET['lignes'] != '') {
            $client = $_GET['lignes'];
            $cat_ress = $_GET['ress'];
            //Reconstitution du tableau des numéros membres
            $tab_clt = array();
            $tab_clt = explode(",", $client);
            if ($cat_ress == 'r') {
                $produit = array('RPGr', 'Ir', 'Fs', 'PaNu', 'PaR');
            }
            if ($cat_ress == 'nr') {
                $produit = array('RPGnr', 'Inr');
            }
            if ($cat_ress == '') {
                $produit = array('');
            }
            $tcredit = new Application_Model_DbTable_EuCompteCredit();
            $select = $tcredit->select();
            $select->where('code_produit in(?)', $produit)
                    ->where('code_membre in(?)', $tab_clt)
                    ->where('krr like ?', 'n')
                    ->where('code_compte like ?', 'nb%')
                    ->where('domicilier like ?', 0)
                    ->where('affecter = ?', 0);
            $credit = $tcredit->fetchAll($select);

            $prk = 0;
            $pck = 1;
            //Récupération de la prk et de la pck pour les r
            $param = new Application_Model_EuParametresMapper();
            $par = new Application_Model_EuParametres();
            $par_prk = $param->find('prk', 'r', $par);
            if ($par_prk == true) {
                $prk = $par->getMontant();
            }
            $par_pck = $param->find('pck', 'r', $par);
            if ($par_pck == true) {
                $pck = $par->getMontant();
            }
            $count = count($credit);

            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }

            if ($page > $total_pages)
                $page = $total_pages;

            $credit = $tcredit->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            $type_bnp = array('cscoe', 'cmit', 'cacb', 'capu', 'caipc');
            foreach ($credit as $row) {
                //Calcul du montant crédit pr les RPGr et Ir provenant d'un capa
                $prod = $row->code_produit;
                $compte_source = $row->compte_source;
                if (($prod == 'RPGr' || $prod == 'Ir') and !in_array($compte_source, $type_bnp)) {
                    $mt_credit = round($row->montant_place * $prk / $pck);
                } else {
                    $mt_credit = $row->montant_credit;
                }
                $date_fin = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->id_credit;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_membre,
                    $prod,
                    $row->montant_place,
                    $mt_credit,
                    $mt_credit,
                    $date_fin->toString('dd/mm/yyyy'),
                    $row->id_credit,
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function listcreditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 30);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $request = $this->getRequest();
        $code_domici = $request->code_domicil;
        $tabela = new Application_Model_DbTable_EuDetailDomicilie();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('d' => 'eu_detail_domicilie'), array('code_membre', 'mont' => 'montant_credit'))
                ->join(array('c' => 'eu_compte_credit'), 'c.id_credit = d.id_credit', array('code_produit', 'montant_place', 'montant_credit', 'compte_source', 'date_octroi', 'id_credit'))
                ->where('d.code_domicilier = ?', $code_domici);
        $alloc = $tabela->fetchAll($select);
        $count = count($alloc);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $alloc = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        //Récupération de la prk et de la pck pour les r
        $prk = 0;
        $pck = 1;
        $param = new Application_Model_EuParametresMapper();
        $par = new Application_Model_EuParametres();
        $par_prk = $param->find('prk', 'r', $par);
        if ($par_prk == true) {
            $prk = $par->getMontant();
        }
        $par_pck = $param->find('pck', 'r', $par);
        if ($par_pck == true) {
            $pck = $par->getMontant();
        }
        $type_bnp = array('cscoe', 'cmit', 'cacb', 'capu', 'caipc');
        foreach ($alloc as $row) {
            //Calcul du montant crédit pr les RPGr et Ir provenant d'un capa
            $prod = $row->code_produit;
            $compte_source = $row->compte_source;
            if (($prod == 'RPGr' || $prod == 'Ir') and !in_array($compte_source, $type_bnp)) {
                $mt_credit = round($row->montant_place * $prk / $pck);
            } else {
                $mt_credit = $row->montant_credit + $row->mont;
            }
            $date_fin = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $row->code_produit,
                $row->montant_place,
                $mt_credit,
                $row->mont,
                $date_fin->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function createAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $ress = $_GET['ress'];
        $mt_domicilie = $_GET['mt_domi'];
        $mt_obtenu = $_GET['mt_obtenu'];
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $acteur = $user->code_membre;
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $mt_subvent = $mt_domicilie;
                //###Contrôle du total des crédits domiciliés avec le montant du remboursement###
                if ($mt_obtenu < $mt_subvent) {
                    $this->view->data = 'err_domici';
                    return;
                } else {
                    //###Traitement généraux et standard pour tout les type de domiciliation###
                    //Mise à jour des comptes crédits
                    $cumul_credit = 0;
                    foreach ($selection as $sel) {
                        $result = $cm->find($sel['code_credit'], $cr);
                        if ($result) {
                            $cumul_credit+=$sel['mt_utilise'];
                            //Valeur du champ domicilier pr les crédits affecter au tegcp(2) 
                            $cr->setDomicilier(2);
                            $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_utilise']);
                            $cm->update($cr);
                        }
                        //Mise à jour du compte
                        $ret = $mcompte->find($cr->getCode_compte(), $compte);
                        if ($ret) {
                            $compte->setSolde($compte->getSolde() - $sel['mt_utilise']);
                            $mcompte->update($compte);
                        }
                    }
                    //Enregistrement dans la table de domiciliation
                    $do->setMontant_subvent($cumul_credit); //Montant cumul des crédits initiaux
                    $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                    $do->setCode_domicilier($code_domici);
                    $do->setCode_membre_beneficiaire($user->code_membre);
                    $do->setCode_membre_assureur($user->code_membre);
                    $do->setCat_ressource($ress);
                    $do->setMontant_domicilier($cumul_credit);
                    if ($ress == 'nr') {
                        $do->setDomicilier('o');
                        $do->setDuree_renouvellement(1);
                        $do->setReste_duree(0);
                    } else if ($ress == 'r') {
                        $do->setDomicilier('n');
                        $do->setDuree_renouvellement(0);
                        $do->setReste_duree(0);
                    }
                    $do->setAccorder('n');
                    $do->setDate_domiciliation($date_domi->toString('yyyy-mm-dd'));
                    $type_domi = 'tegcp';
                    $do->setType_domiciliation($type_domi);
                    $do->setCode_smcipn(null);
                    $do->setCode_smcipnp(null);
                    $do->setId_utilisateur($user->id_utilisateur);
                    $dom = new Application_Model_DbTable_EuDomiciliation();
                    $code_dom = $dom->find($code_domici);
                    if (count($code_dom) < 1) {
                        $mdo->save($do);
                    } else {
                        $this->view->data = 'cool';
                        return;
                    }
                    //Enregistrement dans la table detail_domicilie
                    $mtab = array();
                    foreach ($selection as $tab) {
                        $dod->setCode_domicilier($code_domici);
                        $dod->setId_credit($tab['code_credit']);
                        $dod->setCode_membre($tab['num_membre']);
                        $dod->setMontant_credit($tab['mt_utilise']);
                        $mdod->save($dod);
                        $mtab = $tab['num_membre'];
                    }
                    //Mise à jour de la table eu_cnp
                    foreach ($selection as $sel) {
                        $result = $cm->find($sel['code_credit'], $cr);
                        $cnp = new Application_Model_EuCnp();
                        $m_cnp = new Application_Model_EuCnpMapper();
                        $cnp_res = $m_cnp->findCnpByCreditSource($cr->getId_credit(), $cr->getSource());
                        if ($cnp_res != null) {
                            $cnp->setId_cnp($cnp_res->getId_cnp());
                            $cnp->setId_credit($cnp_res->getId_credit());
                            $cnp->setDate_cnp($cnp_res->getDate_cnp());
                            $cnp->setMont_debit($cnp_res->getMont_debit());
                            $cnp->setMont_credit($cnp_res->getMont_credit());
                            $cnp->setSolde_cnp($cnp_res->getSolde_cnp());
                            $cnp->setType_cnp($cnp_res->getType_cnp());
                            $cnp->setSource_credit($cnp_res->getSource_credit());
                            $cnp->setCode_capa($cnp_res->getCode_capa());
                            $cnp->setCode_domicilier($code_domici);
                            $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                            $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                            $m_cnp->update($cnp);
                        }
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                $this->view->mtab = $mtab;
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                $this->view->data = 'bad';
                return;
            }
        }
    }

    public function accorderAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = $_GET['lignes'];
        $mt_transfert = $_GET['mt_transfert'];
//        $mtegc = New Application_Model_EuTegcMapper();
//        $tegc = new Application_Model_EuTegc();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mop = New Application_Model_EuOperationMapper();
        $op = new Application_Model_EuOperation();
        $mcnp = New Application_Model_EuCnpMapper();
        $cnp = new Application_Model_EuCnp();
//        $cc = new Application_Model_EuCompteCredit();
//        $cc_mapper = new Application_Model_EuCompteCreditMapper();
        $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
        $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
        $detail = new Application_Model_EuDetailGcpPbf();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_op = clone $date;
        $acteur = $user->code_membre;
        $num_compte = 'nb-tpagcp-' . $acteur;
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //$nb_credit = 5;
                //Création de la domiciliation dans la table eu_gcp_pbf
                $gcp_pbf = new Application_Model_EuGcpPbf();
                $type_capa = 'capacnp';
                $code_gcp_pbf = "gcp-cnp-" . $acteur;
                $ret_pbf = $m_gcp_pbf->find($code_gcp_pbf, $gcp_pbf);
                if (!$ret_pbf) {
                    $gcp_pbf->setCode_gcp_pbf($code_gcp_pbf)
                            ->setAgio_consomme(0)
                            ->setMont_agio(0)
                            ->setGcp_compense(0)
                            ->setMont_gcp($mt_transfert)
                            ->setMont_gcp_reel($mt_transfert)
                            ->setCode_membre($acteur)
                            ->setCode_compte($num_compte)
                            ->setSolde_agio(0)
                            ->setSolde_gcp($mt_transfert)
                            ->setSolde_gcp_reel($mt_transfert)
                            ->setType_capa($type_capa);
                    $m_gcp_pbf->save($gcp_pbf);
                } else {
                    $gcp_pbf->setSolde_gcp($gcp_pbf->getSolde_gcp() + $mt_transfert)
                            ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() + $mt_transfert)
                            ->setMont_gcp($gcp_pbf->getMont_gcp() + $mt_transfert)
                            ->setMont_gcp_reel($gcp_pbf->getMont_gcp_reel() + $mt_transfert);
                    $m_gcp_pbf->update($gcp_pbf);
                }
                //Mise à jour de la table de domiciliation
                foreach ($selection as $sel) {
                    $result = $mdo->find($sel['code_domici'], $do);
                    if ($result) {
                        $do->setMontant_domicilier($do->getMontant_domicilier() - $sel['mt_domici']);
                        $mdo->update($do);
                        $find_cnpgcp = $mcnp->findCnpByDomiGcp($sel['code_domici']);
                        if ($find_cnpgcp != null) {
                            $nb_credit = count($find_cnpgcp);
                            //$this->view->data = $nb_credit;
                            //return;
                            for ($j = 0; $j <= $nb_credit - 1; $j++) {
                                $res_cnp = $find_cnpgcp[$j];
                                //Mise à jour du champ transfert_gcp de la table cnp
                                $cnp->setTransfert_gcp(1);
                                $mcnp->update($cnp);
                                //Création du cncs r et nr à la source smc
                                $smc = new Application_Model_EuSmc();
                                $m_smc = new Application_Model_EuSmcMapper();
                                $smc->setId_credit($res_cnp->getId_credit())
                                        ->setDate_smc($date_op->toString('yyyy-mm-dd'))
                                        ->setMontant($res_cnp->getMont_debit())
                                        ->setEntree(0)
                                        ->setSortie(0)
                                        ->setSolde(0)
                                        ->setSource_credit($res_cnp->getSource_credit())
                                        ->setMontant_solde($res_cnp->getMont_debit())
                                        ->setOrigine_smc(0)
                                        ->setCode_capa($res_cnp->getCode_capa())
                                        ->setCode_smcipn(null)
                                        ->setCode_smcipnp(null)
                                        ->setCode_domicilier($res_cnp->getCode_domicilier());
                                if (strpos($res_cnp->getType_cnp(), 'nr') !== false) {
                                    $smc->setType_smc('CNCSnr');
                                } else {
                                    $smc->setType_smc('CNCSr');
                                }
                                $m_smc->save($smc);

                                //Création détail gcp pbf
                                $detail = new Application_Model_EuDetailGcpPbf();
                                $detail->setCode_gcp_pbf($code_gcp_pbf)
                                        ->setMont_gcp_pbf($mt_transfert)
                                        ->setMont_preleve(0)
                                        ->setSolde_gcp_pbf($mt_transfert)
                                        ->setId_credit($cnp->getId_credit())
                                        ->setSource_credit($cnp->getSource_credit())
                                        ->setAgio(0);
                                if ($cnp->getType_cnp() == 'Inr' or $cnp->getType_cnp() == 'Ir') {
                                    $detail->setType_capa('fgi');
                                } elseif ($cnp->getType_cnp() == 'RPGnr' or $cnp->getType_cnp() == 'RPGr') {
                                    $detail->setType_capa('fgrpg');
                                }
                                $t_detail->insert($detail->toArray());
                            }
                        }
                    }
                }
                //Création ou mise à jour du compte tpagcp
                $find_compte = $mcompte->find($num_compte, $compte);
                if ($find_compte == true) {
                    $compte->setSolde($compte->getSolde() + $mt_transfert);
                    $mcompte->update($compte);
                } else {
                    $compte->setCode_membre($acteur)
                            ->setCode_cat('tpagcp')
                            ->setSolde($mt_transfert)
                            ->setDate_alloc($date_op->toString('yyyy-mm-dd'))
                            ->setCode_compte($num_compte)
                            ->setLib_compte('tpagcp')
                            ->setDesactiver(0);
                    $mcompte->save($compte);
                }

                //Mise à jour de la table opération
                $compteur = $mop->findConuter() + 1;
                $op->setId_operation($compteur)
                        ->setDate_op($date_op->toString('yyyy-mm-dd'))
                        ->setHeure_op($date_op->toString('hh:mm'))
                        ->setId_utilisateur($user->id_utilisateur)
                        ->setCode_membre($acteur)
                        ->setMontant_op($mt_transfert)
                        ->setCode_produit('gcp')
                        ->setLib_op('Transfert de la domiciliation sur le tegcp')
                        ->setType_op('tgcp')
                        ->setCode_cat('tpagcp');
                $mop->save($op);

                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                $this->view->message = $message;
                $this->view->data = 'erreur';
                return;
            }
        }
    }

    public function rembourseAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function rembourselistAction() {
        $date_deb = $_GET["date_deb"];
        $date_fin = $_GET["date_fin"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select();
        $select->setIntegrityCheck(false);
        $select->where('eu_operation.id_utilisateur = ?', $user->id_utilisateur);
        $select->where('eu_operation.code_membre = ?', $user->code_membre);
        if ($date_deb == '' and $date_fin == '') {
            $datedeb = '%';
            $select->where('eu_operation.date_op like ?', $datedeb);
        } else if ($date_deb == '') {
            $date2 = explode("/", $date_fin);
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('eu_operation.date_op <= ?', $datefin);
        } else if ($date_fin == '') {
            $date1 = explode("/", $date_deb);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('eu_operation.date_op >= ?', $datedeb);
        } else {
            $date1 = explode("/", $date_deb);
            $date2 = explode("/", $date_fin);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('eu_operation.date_op >= ?', $datedeb);
            $select->where('eu_operation.date_op <= ?', $datefin);
        }
        $select->where('type_op = ?', 'tgcp');
        $select->order('date_op', 'asc');
        $alloc = $tabela->fetchAll($select);
        $count = count($alloc);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $alloc = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totmont = 0;
        foreach ($alloc as $row) {
            $totmont+=$row->montant_op;
            $date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $heure_op = new Zend_Date($row->heure_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $date_op->toString('dd/mm/yyyy'),
                $heure_op->toString('hh:mm'),
                $row->montant_op
            );
            $i++;
        }
        $responce['userdata']['heure_op'] = 'Total:';
        $responce['userdata']['mt_transfert'] = $totmont;
        $this->view->data = $responce;
    }

    public function changeAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function changemoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $select->where('type_membre=?', 'm');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    //####### Domiciliation des crédits issus d'un imm ########
    public function domicilierimmAction() {
        
    }

    public function afficherdomAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $type_domi = 'tegcp';
        $code_membre = $this->_request->getParam('code_membre_dom');
        $code_membre_benef = $this->_request->getParam('code_membre_benef');
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                ->setIntegrityCheck(false);
        if ($code_membre_benef != '') {
            $select->where('eu_domiciliation.code_membre_beneficiaire = ?', $code_membre_benef);
        }
        if ($code_membre != '') {
            $select->join('eu_detail_domicilie', 'eu_detail_domicilie.code_domicilier = eu_domiciliation.code_domicilier')
                    ->where('eu_detail_domicilie.code_membre like ?', $code_membre);
        }
        $select->where('eu_domiciliation.accorder = ?', 'n')
                ->where('eu_domiciliation.type_domiciliation like ?', $type_domi)
                ->order('eu_domiciliation.date_domiciliation', 'desc');
        $select->distinct();
        $domici = $tabela->fetchAll($select);
        $count = count($domici);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $domici = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($domici as $row) {
            $date_dom = new Zend_Date($row->date_domiciliation, Zend_Date::ISO_8601);
            $date_echue = new Zend_Date($row->date_echue, Zend_Date::ISO_8601);
            if ($row->cat_ressource == 'r') {
                $ress = 'Récurrent';
            } else {
                $ress = 'Non récurrent';
            }
            if ($row->domicilier == 'n') {
                $accord = 'En cours';
            } else {
                $accord = 'Terminer';
            }
            $responce['rows'][$i]['id'] = $row->code_domicilier;
            $responce['rows'][$i]['cell'] = array(
                $row->code_domicilier,
                $row->code_membre_beneficiaire,
                $ress,
                $row->montant_subvent,
                $row->montant_domicilier,
                $date_dom->toString('dd/mm/yyyy'),
                $date_echue->toString('dd/mm/yyyy'),
                $accord,
                $row->cat_ressource,
                $row->type_domiciliation
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function creditsimmAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_credi');
        $sord = $this->_request->getParam("sord", 'asc');

        if ($_GET['lignes'] != '') {
            $client = $_GET['lignes'];
            //Reconstitution du tableau des numéros membres
            $tab_clt = array();
            $tab_clt = explode(",", $client);
            //Liste des types de credits récurrents
            $produit = array('RPGnr', 'Inr');
            $tcredit = new Application_Model_DbTable_EuCompteCredit();
            $select = $tcredit->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->where('code_produit in(?)', $produit)
                    ->where('code_membre in(?)', $tab_clt)
                    ->where('krr like ?', 'n')
                    ->where('code_compte like ?', 'nb%')
                    ->where('domicilier like ?', 0)
                    ->where('affecter like ?', 1)
                    ->join('eu_capa_affecter', 'eu_capa_affecter.id_credit = eu_compte_credit.id_credit');
            $credit = $tcredit->fetchAll($select);

            $count = count($credit);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }

            if ($page > $total_pages)
                $page = $total_pages;

            $credit = $tcredit->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($credit as $row) {
                $prod = $row->code_produit;
                $date_fin = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->id_credit;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_membre,
                    $prod,
                    $row->montant_place,
                    $row->montant_credit,
                    $row->montant_credit,
                    $date_fin->toString('dd/mm/yyyy'),
                    $row->id_credit,
                    $row->duree_renouvellement,
                    $row->mont_invest,
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function createimmAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $mt_domi = $_GET['mt_obtenu'];
        $nb_periode = $_GET['nb_periode'];
        $ress = 'nr';
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $mcapaa = new Application_Model_EuCapaAffecterMapper();
        $capaa = new Application_Model_EuCapaAffecter();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $acteur = $user->code_membre;
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $nb_jr = ceil($nb_periode * 30);
                $date->addDay($nb_jr);
                $date_echue = $date;
                //Mise à jour des comptes crédits
                $cumul_credit = 0;
                foreach ($selection as $sel) {
                    $result = $cm->find($sel['code_credit'], $cr);
                    if ($result) {
                        $cumul_credit+=$sel['mt_credit'];
                        $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_credit']);
                        $cr->setDomicilier(2);
                        $cm->update($cr);
                    }
                }
                //###Traitement généraux et standard pour tout les type de domiciliation###
                //Enregistrement dans la table de domiciliation
                $do->setMontant_subvent($mt_domi);
                $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                $do->setCode_domicilier($code_domici);
                $do->setCode_membre_beneficiaire($user->code_membre);
                $do->setCode_membre_assureur($user->code_membre);
                $do->setCat_ressource($ress);
                $do->setMontant_domicilier($cumul_credit);
                if ($mt_domi <= $cumul_credit) {
                    $do->setDomicilier('o');
                    $do->setDuree_renouvellement($nb_periode);
                    $do->setReste_duree(0);
                } else {
                    $do->setDomicilier('n');
                    $do->setDuree_renouvellement($nb_periode);
                    $do->setReste_duree($nb_periode);
                }
                $do->setAccorder('n');
                $do->setDate_domiciliation($date_domi->toString('yyyy-mm-dd'));
                $type_domi = 'tegcp';
                $do->setType_domiciliation($type_domi);
                $do->setCode_smcipn(null);
                $do->setCode_smcipnp(null);
                $do->setId_utilisateur($user->id_utilisateur);
                $dom = new Application_Model_DbTable_EuDomiciliation();
                $code_dom = $dom->find($code_domici);
                if (count($code_dom) < 1) {
                    $mdo->save($do);
                } else {
                    $this->view->data = 'cool';
                    return;
                }
                //Enregistrement dans la table detail_domicilie
                $mtab = array();
                foreach ($selection as $tab) {
                    $dod->setCode_domicilier($code_domici);
                    $dod->setId_credit($tab['code_credit']);
                    $dod->setCode_membre($tab['num_membre']);
                    $dod->setMontant_credit($tab['mt_credit']);
                    $mdod->save($dod);
                    $mtab = $tab['num_membre'];
                }
                //Traitement spéciaux des nr et r
                foreach ($selection as $sel) {
                    $result = $cm->find($sel['code_credit'], $cr);
                    //Diminution du montant du compte
                    $ret = $mcompte->find($cr->getCode_compte(), $compte);
                    if ($ret) {
                        $compte->setSolde($compte->getSolde() - $sel['mt_credit']);
                        $mcompte->update($compte);
                    }
                    //Mise à jour du code_domicilier dans la table capa_affecter
                    $find_capaa = $mcapaa->findByCredit($cr->getId_credit());
                    if ($find_capaa != false) {
                        $capaa->setId_affecter($find_capaa->getId_affecter());
                        $capaa->setDuree_renouvellement($find_capaa->getDuree_renouvellement());
                        $capaa->setReste_duree($find_capaa->getReste_duree());
                        $capaa->setType_credit($find_capaa->getType_credit());
                        $capaa->setId_credit($find_capaa->getId_credit());
                        $capaa->setCode_domicilier($code_domici);
                        $capaa->setMont_invest($find_capaa->getMont_invest());
                        $capaa->setCode_capa($find_capaa->getCode_capa());
                        $mcapaa->update($capaa);
                    }
                    //Mise à jour de la table cnp cas du nr pck comme celui du nr pre
                    $cnp = new Application_Model_EuCnp();
                    $m_cnp = new Application_Model_EuCnpMapper();
                    $cnp_res = $m_cnp->findCnpByCreditSource($cr->getId_credit(), $cr->getSource());
                    if ($cnp_res != null) {
                        $cnp->setId_cnp($cnp_res->getId_cnp());
                        $cnp->setId_credit($cnp_res->getId_credit());
                        $cnp->setDate_cnp($cnp_res->getDate_cnp());
                        $cnp->setMont_debit($cnp_res->getMont_debit());
                        $cnp->setMont_credit($cnp_res->getMont_credit());
                        $cnp->setSolde_cnp($cnp_res->getSolde_cnp());
                        $cnp->setType_cnp($cnp_res->getType_cnp());
                        $cnp->setSource_credit($cnp_res->getSource_credit());
                        $cnp->setCode_capa($cnp_res->getCode_capa());
                        $cnp->setCode_domicilier($code_domici);
                        $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                        $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                        $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                        $m_cnp->update($cnp);
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                $this->view->mtab = $mtab;
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
                $this->view->data = 'bad';
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
            if ($result->type_membre == 'p') {
                $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
            } else {
                $data = strtoupper($result->raison_sociale);
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function modifbenefAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $new_benf = $_GET['new_benef'];
        $code_domici = $_GET['code_domici'];
        $mt_domi = $_GET['mt_domi'];
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mop = New Application_Model_EuOperationMapper();
        $op = new Application_Model_EuOperation();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_op = clone $date;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Mise à jour du numéro de bénéficiaire dans la date 
            $find_domi = $mdo->find($code_domici, $do);
            if ($find_domi) {
                $do->setCode_membre_beneficiaire($new_benf);
                $mdo->update($do);
            }
            //Enregistrement dans la table opération
            $compteur = $mop->findConuter() + 1;
            $op->setId_operation($compteur)
                    ->setDate_op($date_op->toString('yyyy-mm-dd'))
                    ->setHeure_op($date_op->toString('hh:mm'))
                    ->setId_utilisateur($user->id_utilisateur)
                    ->setCode_membre($new_benf)
                    ->setMontant_op($mt_domi)
                    ->setCode_produit('gcp')
                    ->setLib_op('Changement du bénéficiaire de la domiciliation')
                    ->setType_op('cbd')
                    ->setCode_cat('tpagcp');
            $mop->save($op);
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
            $this->view->message = $message;
            $this->view->data = 'bad';
            return;
        }
    }

}

?>
