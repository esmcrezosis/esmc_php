<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuGacController
 *
 * @author user
 */
class EuDomiciliationVbpspController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'acnev') {
            $menu = "<li><a href=\"/eu-domiciliation-vbpsp/domicilier \">Domiciliation prk</a></li>" .
                    "<li><a href=\"/eu-domiciliation-vbpsp/domicilierimm \">Domiciliation pre</a></li>" .
                    "<li><a href=\"/eu-domiciliation-vbpsp\">Liste domiciliations</a></li>" .
                    "<li><a href=\"/eu-domiciliation-vbpsp/rembourse \">Liste remboursements</a></li>";
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
            if ($group != 'acnev') {
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
        $group = $user->code_groupe;
        if ($group == 'ass_smcii') {
            $type_domi = 'tpasmcii';
        } elseif ($group == 'ass_smcpnw') {
            $type_domi = 'tapsmcpnw';
        } else {
            $type_domi = '%';
        }
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        $select->where('eu_domiciliation.id_utilisateur = ?', $user->id_utilisateur)
                ->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre)
                ->where('eu_domiciliation.accorder = ?', 'n')
                ->where('eu_domiciliation.domicilier = ?', 'n')
                ->where('eu_domiciliation.type_domiciliation like ?', $type_domi)
                ->where('eu_domiciliation.code_smcipnp is not Null')
                ->where('eu_domiciliation.code_membre_beneficiaire is not Null')
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
                $row->code_smcipnp,
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

    public function benefchangeAction() {

        $num_membre = $_GET['benef'];
        $data = array();
        $table = new Application_Model_DbTable_EuSmcipnp();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->where("code_membre = ?", $num_membre)
                ->where("domicilier = ?", 0);
        $bes = $table->fetchAll($select);
        $i = 0;
        foreach ($bes as $value) {
            $date_dem = new Zend_Date($value->date_smcipnp, Zend_Date::ISO_8601);
            $data[$i][1] = $value->code_smcipnp;
            $data[$i][2] = ucfirst($value->lib_smcipnp) . '--' . $date_dem->toString('dd/mm/yyyy');
            $i++;
        }
        $this->view->data = $data;
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
            $d->setMt_credits($this->_request->getPost("MT_CREDITs"));
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
                ->from(array('d' => 'eu_detail_domicilie'), array('code_membre', 'mont' => 'montANT_CREDIT'))
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
        $mt_domi = $_GET['mt_domi'];
        $ress = $_GET['ress'];
        $code_smcipnp = $_GET['demand'];
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $msmcipnp = new Application_Model_EuSmcipnpMapper();
        $smcipnp = new Application_Model_EuSmcipnp();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $acteur = $user->code_membre;
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Cas du nr: récupération du montant total de la domiciliation
                $mt_credit = 0;
                $date_end = new Zend_Date(Zend_Date::ISO_8601);
                if ($ress == 'nr') {
                    foreach ($selection as $val) {
                        if ($val['mt_utilise'] <= $val['mt_credit']) {
                            $mt_cred = $val['mt_utilise'];
                        } else {
                            $mt_cred = $val['mt_credit'];
                        }
                        $mt_credit+=$mt_cred;
                    }
                    $date_echue = $date_domi;
                } else if ($ress == 'r') {
                    //Récupération de la durée de domiciliation des r
                    $dvm = 1;
                    $param = new Application_Model_EuParametresMapper();
                    $par = new Application_Model_EuParametres();
                    $find_nb = $param->find('pck', 'r', $par);
                    if ($find_nb == true) {
                        $dvm = ceil($par->getMontant());
                    }
                    $type_bnp = array('cscoe', 'cmit', 'cacb', 'capu', 'caipc');
                    foreach ($selection as $val) {
                        $code_credit = $val['code_credit'];
                        $cm->find($code_credit, $cr);
                        $mt_place = $cr->getMontant_place();
                        $prod = $cr->getCode_produit();
                        $compte_source = $cr->getCompte_source();
                        //Récupération de la date de renouvellement la plus ancienne
                        $datefin = new Zend_Date($cr->getDatefin(), Zend_Date::ISO_8601);
                        if ($datefin > $date_end) {
                            $date_end = $datefin;
                        }
                        //Calcul du crédit généré par chaque capa
                        $tot_credit = 0;
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
                        //Cas des RPGr et Ir provenant des capa
                        if (($prod == 'RPGr' or $prod == 'Ir') and !in_array($compte_source, $type_bnp)) {
                            $credit = $val['mt_utilise'];
                            $tot_credit = $credit * $dvm;
                        }
                        //Cas des RPGr et Ir provenant d'un bnp (conus)
                        if (($prod == 'RPGr' or $prod == 'Ir') and in_array($compte_source, $type_bnp)) {
                            //récup des infos du bnp
                            $tbnp = new Application_Model_EuBnpCreditMapper();
                            $bnp = new Application_Model_EuBnpCredit();
                            $mdbnp = new Application_Model_EuDetailBnpMapper();
                            $dbnp = new Application_Model_EuDetailBnp();
                            $tot_conus = 0;

                            $result1 = $tbnp->find($cr->getCode_bnp(), $cr->getId_credit(), $bnp);
                            if ($result1 == true) {
                                $per_deb = $bnp->getPeriode_remb();
                                $per_fin = 0;
                                $periode1 = 23 - $bnp->getPeriode_remb();
                                if ($dvm >= $periode1) {
                                    $per_fin = 23;
                                } elseif ($dvm < $periode1) {
                                    $per_fin = $bnp->getPeriode_remb() + $dvm;
                                }
                                //recup des infos du détail bnp et calcul du montant total du conus
                                $find_dbnp = $mdbnp->findDetailBnpByPeriode($bnp->getCode_bnp(), $bnp->getId_credit(), $per_deb, $per_fin);
                                if ($find_dbnp != null) {
                                    for ($i = 0; $i < count($find_dbnp); $i++) {
                                        $res_dbnp = $find_dbnp[$i];
                                        $tot_conus+=$res_dbnp->getConus();
                                    }
                                }
                            }
                            if ($dvm > 23) {
                                $credit = ($mt_place * $prk) / $pck;
                                $tot_credit = $tot_conus + $credit * ($dvm - 23);
                            } else {
                                $tot_credit = $tot_conus;
                            }
                        }
                        //Cas des PaNu, PaR et fs issus d'un bnp
                        if ($prod == 'PaNu' or $prod == 'PaR' or $prod == 'fs') {
                            //récup des infos du bnp
                            $tbnp = new Application_Model_EuBnpCreditMapper();
                            $bnp = new Application_Model_EuBnpCredit();
                            $mdbnp = new Application_Model_EuDetailBnpMapper();
                            $dbnp = new Application_Model_EuDetailBnp();
                            $tot_par = 0;
                            $tot_panu = 0;
                            $tot_fs = 0;
                            $result1 = $tbnp->find($cr->getCode_bnp(), $cr->getCompte_source(), $bnp);
                            if ($result1 == true) {
                                $per_deb = $bnp->getPeriode_remb();
                                $per_fin = 0;
                                $periode1 = 23 - $bnp->getPeriode_remb();
                                if ($dvm >= $periode1) {
                                    $per_fin = 23;
                                } elseif ($dvm < $periode1) {
                                    $per_fin = $bnp->getPeriode_remb() + $dvm;
                                }
                                //recup des infos du détail bnp et calcul du montant de la PaR, PaNu ou fs
                                $find_dbnp = $mdbnp->findDetailBnpByPeriode($bnp->getCode_bnp(), $bnp->getId_credit(), $per_deb, $per_fin);
                                if ($find_dbnp != null) {
                                    for ($i = 0; $i < count($find_dbnp); $i++) {
                                        $res_dbnp = $find_dbnp[$i];
                                        $tot_par+=$res_dbnp->getPar();
                                        $tot_panu+=$res_dbnp->getPanu();
                                        $tot_fs+=$res_dbnp->getFs();
                                    }
                                }
                            }
                            if ($prod == 'PaNu') {
                                $tot_credit = $tot_panu;
                            } else if ($prod == 'PaR') {
                                //Ajout du cumul de la PaR non exprimée
                                $tot_credit = $tot_par + $cr->getMontant_credit();
                            } else if ($prod == 'fs') {
                                //Ajout du  cumul du fs non exprimé
                                $tot_credit = $tot_fs + $cr->getMontant_credit();
                            }
                        }
                        //calcul du cumul total de tous les crédits sélectionnés
                        $mt_credit+=$tot_credit;
                    }
                    $date_end->addDay($dvm * 30);
                    $date_echue = $date_end;
                }
                //Mise à jour des comptes crédits
                $cumul_credit = 0;
                $nb_per = 0;
                foreach ($selection as $sel) {
                    $cumul_credit+=$sel['mt_credit'];
                    $nb_per+=1;
                    $result = $cm->find($sel['code_credit'], $cr);
                    if ($result) {
                        $cr->setDomicilier(1);
                        $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_utilise']);
                        $cm->update($cr);
                    }
                }
                //###Traitements généraux pour tous les types de domiciliation###
                //Contrôle du cumul du montant domicilié pour le remboursement de la smcipnp
                $mt_domicilie = 0;
                $somme_domi = $mdo->getSumDomicilier($code_smcipnp);
                $mont_obtenu = $mt_credit + $somme_domi;
                if ($mont_obtenu <= $mt_domi) {
                    $mt_domicilie = $mt_credit;
                    $domicilier = 0;
                } else {
                    $mt_domicilie = $mt_domi - $somme_domi;
                    $domicilier = 1;
                }
                //Mise à jour de la table smcipnp
                $code_benef = '';
                $resul = $msmcipnp->find($code_smcipnp, $smcipnp);
                if ($resul) {
                    $smcipnp->setDomicilier($domicilier);
                    $msmcipnp->update($smcipnp);
                    $code_benef = $smcipnp->getCode_membre();
                }
                //Enregistrement dans la table de domiciliation
                $do->setMontant_subvent($mt_domicilie);
                $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                $do->setCode_domicilier($code_domici);
                $do->setCode_membre_beneficiaire($code_benef);
                $do->setCode_membre_assureur($user->code_membre);
                $do->setCat_ressource($ress);
                if ($ress == 'nr') {
                    $do->setMontant_domicilier($mt_domicilie);
                    $do->setDomicilier('o');
                    $do->setDuree_renouvellement($dvm);
                    $do->setReste_duree(0);
                } else if ($ress == 'r') {
                    $do->setMontant_domicilier($cumul_credit);
                    $do->setDomicilier('n');
                    $do->setDuree_renouvellement($dvm);
                    $do->setReste_duree($dvm - $nb_per);
                }
                $do->setAccorder('n');
                $do->setDate_domiciliation($date_domi->toString('yyyy-mm-dd'));
                $do->setType_domiciliation('tpasmcipnp');
                $do->setCode_smcipn(null);
                $do->setCode_smcipnp($code_smcipnp);
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
                //Traitement spéciaux des r et nr
                foreach ($selection as $sel) {
                    $result = $cm->find($sel['code_credit'], $cr);
                    //Diminution du montant du compte
                    $ret = $mcompte->find($cr->getCode_compte(), $compte);
                    if ($ret) {
                        $compte->setSolde($compte->getSolde() - $sel['mt_utilise']);
                        $mcompte->update($compte);
                    }
                    //Diminution du montant du compte crédit pour le cas des nr
                    if ($result) {
                        $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_utilise']);
                        $cm->update($cr);
                    }
                    //Mise à jour de la table cnp
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

    public function subventionAction() {
        $code_demand = $_GET['code'];
        $data = array();
        $smc_db = new Application_Model_DbTable_EuSmcipnp();
        $smc_find = $smc_db->find($code_demand);
        if (count($smc_find) == 1) {
            $mt_subvent = 0;
            $result = $smc_find->current();
            $mt_subvent = $result->montant_smcipnp;
            $date_alloc = new Zend_Date($result->date_alloc, Zend_Date::ISO_8601);
            $data[0] = $mt_subvent;
            $data[1] = $date_alloc->toString('dd/mm/yyyy');
        } else {
            $data[0] = '';
            $data[1] = '';
        }
        $this->view->data = $data;
    }

    public function accorderAction() {

        $mdomi = New Application_Model_EuDomiciliationMapper();
        $domi = new Application_Model_EuDomiciliation();
        //$msp = new Application_Model_EuSmcipnpMapper();
        //$sp = new Application_Model_EuSmcipnp();
        $mrap = new Application_Model_EuRapprochementMapper();
        $rap = new Application_Model_EuRapprochement();
        $mgcsc = new Application_Model_EuGcscMapper();
        $gcsc = new Application_Model_EuGcsc();
        $mcnp = new Application_Model_EuCnpMapper();
        $cnp = new Application_Model_EuCnp();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mech = New Application_Model_EuEchangeMapper();
        $code_domi = $_GET['code_domi'];
        $mt_smcipnp = $_GET['mt_smcipnp'];
        $mt_domici = $_GET['mt_domici'];
        $code_smcipnp = $_GET['code_smcipnp'];
        $num_benef = $_GET['benef'];
        $cat_ress = $_GET['cat_ress'];
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_smc = clone $date;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Contrôle de l'état de la domiciliation
            if ($mt_domici < $mt_smcipnp) {
                $this->view->data = 'echec_domi';
                return;
            } else {
                //Mise à jour du compte de domiciliation
                $result = $mdomi->find($code_domi, $domi);
                if ($result) {
                    $domi->setAccorder('o');
                    $mdomi->update($domi);
                }
//                //Mise à jour de la table de subvention préfinancées
//                $msp->find($code_smcipnp, $sp);
//                $sp->setRembourser(1);
//                $ms->update($s);
                //Mise à jour de la smcipnp dans la table gcsc
                $tegcsc = $mgcsc->findBySmcipnp($code_smcipnp);
                if ($tegcsc != null) {
                    $gcsc->setId_gcsc($tegcsc->getId_gcsc());
                    $gcsc->setCode_membre($num_benef);
                    $gcsc->setDebit($tegcsc->getDebit());
                    $gcsc->setCredit($tegcsc->getCredit() + $domi->getMontant_domicilier());
                    $gcsc->setSolde($tegcsc->getSolde() - $domi->getMontant_domicilier());
                    $gcsc->setCode_smcipn($tegcsc->getCode_smcipn());
                    $gcsc->setCode_smcipnp($tegcsc->getCode_smcipnp());
                    $gcsc->setCode_domicilier($tegcsc->getCode_domicilier());
                    $mgcsc->update($gcsc);
                } else {
                    //Enregistrement de la domiciliation(GCnr bleue) dans la table gcsc
                    $gcsc->setCode_membre($num_benef);
                    $gcsc->setDebit(0);
                    $gcsc->setCredit($domi->getMontant_domicilier());
                    $gcsc->setSolde($domi->getMontant_domicilier());
                    $gcsc->setCode_smcipn(null);
                    $gcsc->setCode_smcipnp(null);
                    $gcsc->setCode_domicilier($code_domi);
                    $mgcsc->save($gcsc);
                }
                //Recherche des crédits utilisés pour la domiciliation dans la table cnp
                $cnp_find = $mcnp->findCnpByDomicilie($code_domi);
                if ($cnp_find == null) {
                    $this->view->data = 'no_domi';
                    return;
                } elseif (count($cnp_find) > 0) {
                    for ($i = 0; $i < count($cnp_find); $i++) {
                        $source_cnp = $cnp_find[$i];
                        $source_credit = $source_cnp->getSource_credit();
                        $code_credit = $source_cnp->getId_credit();
                        //Récupération du montant domicilié sur le crédit
                        $credit_domi = 0;
                        $res = $mdod->find($code_domi, $code_credit, $dod);
                        if ($res) {
                            $credit_domi = $dod->getMontant_credit();
                        }
                        //Mise à jour du compte crédit après domiciliation
                        $type_rappro = '';
                        $find_credit = $cm->find($code_credit, $cr);
                        if ($find_credit) {
                            $cr->setDomicilier(0);
                            $cm->update($cr);
                            //Formation du code de rapprochement à partir du crédit domicilié et du crédit alloué
                            $code_produit = $cr->getCode_produit();
                            $compte_source = $cr->getCompte_source();
                            if ($compte_source == 'capai') {
                                if ($code_produit == 'Ir') {
                                    $type_rappro = 'Ir2/IrSc';
                                } else if ($code_produit == 'Inr') {
                                    $type_rappro = 'Inr2/InrSc';
                                }
                            }
                            if ($compte_source == 'caparpg') {
                                if ($code_produit == 'RPGr') {
                                    $type_rappro = 'FGRPG1/RPGr';
                                } else if ($code_produit == 'RPGnr') {
                                    $type_rappro = 'FGRPG1/RPGnr';
                                }
                            }
                            if (strpos($compte_source, 'tpagcp') != false) {
                                if ($code_produit == 'Inr') {
                                    $type_rappro = 'GCP11/InrSc';
                                } else if ($code_produit == 'RPGnr') {
                                    $type_rappro = 'GCP12/RPGnr';
                                }
                            }
                            if (strpos($compte_source, 'tsci') != false) {
                                if ($code_produit == 'Ir') {
                                    $type_rappro = 'Ir4/IrSc';
                                } else if ($code_produit == 'Inr') {
                                    $type_rappro = 'Inr4/InrSc';
                                }
                            }
                            if (strpos($compte_source, 'tcncs') != false) {
                                //Récupération de l'échange à partir de l'id_credit
                                $find_ech = $mech->findEchangeByCredit($code_credit);
                                if ($find_ech != null) {
                                    $code_produit = $find_ech->getCode_produit();
                                }
                                if ($code_produit == 'CNCSnr') {
                                    $type_rappro = 'CNCSnr5/RPGnr';
                                } else if ($code_produit == 'CNCSr') {
                                    $type_rappro = 'CNCSr6/RPGnr';
                                }
                            }
                        }
                        //Recherche du code_smcipnp dans la table rapprochement pr annulation
//                        $res = $mrap->findBySmcipnp($code_smcipnp);
//                        //Mise à jour de la table de rapprochement              
//                        if ($res != null) {
//                            $rap->setId_rappro($res->getId_rappro());
//                            $rap->setDebit_rappro($res->getDebit_rappro());
//                            $rap->setCredit_rappro($res->getCredit_rappro() + $domi->getMontant_domicilier());
//                            $rap->setSolde_rappro($res->getSolde_rappro() - $domi->getMontant_domicilier());
//                            $rap->setSource($res->getSource());
//                            $rap->setSource_credit($res->getSource_credit());
//                            $rap->setCode_smcipn($res->getCode_smcipn());
//                            $rap->setCode_smcipnp($res->getCode_smcipnp());
//                            $rap->setCode_domicilier($res->getCode_domicilier());
//                            $rap->setId_credit($res->getId_credit());
//                            $rap->setType_rappro($type_rappro);
//                            $mrap->update($rap);
//                            //Rapprochement immédiate des crédits utilisés pr le remboursement de la smcipnp
//                            $rap->setDebit_rappro($domi->getMontant_domicilier());
//                            $rap->setCredit_rappro($domi->getMontant_domicilier());
//                            $rap->setSolde_rappro($domi->getMontant_domicilier());
//                            $rap->setSource('cnp');
//                            $rap->setSource_credit($source_credit);
//                            $rap->setCode_smcipn(null);
//                            $rap->setCode_smcipnp($code_smcipnp);
//                            $rap->setCode_domicilier($code_domi);
//                            $rap->setId_credit($code_credit);
//                            $rap->setType_rappro($type_rappro);
//                            $mrap->save($rap);
//                        } else {
//                            $rap->setDebit_rappro($domi->getMontant_domicilier());
//                            $rap->setCredit_rappro(0);
//                            $rap->setSolde_rappro($domi->getMontant_domicilier());
//                            $rap->setSource('cnp');
//                            $rap->setSource_credit($source_credit);
//                            $rap->setCode_smcipn(null);
//                            $rap->setCode_smcipnp($code_smcipnp);
//                            $rap->setCode_domicilier($code_domi);
//                            $rap->setId_credit($code_credit);
//                            $rap->setType_rappro($type_rappro);
//                            $mrap->save($rap);
//                        }
                        //Recherche du code_credit dans la table de rapprochement
                        $res = $mrap->findRapproByCreditSource($code_credit, $source_credit, $type_rappro);
                        //Mise à jour de la table de rapprochement              
                        if ($res != null) {
                            $rap->setId_rappro($res->getId_rappro());
                            $rap->setDebit_rappro($res->getDebit_rappro());
                            $rap->setCredit_rappro($credit_domi);
                            $rap->setSolde_rappro($res->getSolde_rappro() - $credit_domi);
                            $rap->setSource($res->getSource());
                            $rap->setSource_credit($res->getSource_credit());
                            $rap->setCode_smcipn($res->getCode_smcipn());
                            $rap->setCode_smcipnp($res->getCode_smcipnp());
                            $rap->setCode_domicilier($code_domi);
                            $rap->setId_credit($res->getId_credit());
                            $rap->setType_rappro($type_rappro);
                            $mrap->update($rap);
                        } else {
                            $rap->setDebit_rappro(0);
                            $rap->setCredit_rappro($credit_domi);
                            $rap->setSolde_rappro($credit_domi);
                            $rap->setSource('cnp');
                            $rap->setSource_credit($source_credit);
                            $rap->setCode_smcipn(null);
                            $rap->setCode_smcipnp(null);
                            $rap->setCode_domicilier($code_domi);
                            $rap->setId_credit($code_credit);
                            $rap->setType_rappro($type_rappro);
                            $mrap->save($rap);
                        }
                        //Création du cncs à la source smc
                        if ($cat_ress == 'r') {
                            $type_smc = 'CNCSr';
                        } else {
                            $type_smc = 'CNCSnr';
                        }
                        $smc = new Application_Model_EuSmc();
                        $m_smc = new Application_Model_EuSmcMapper();
                        $smc->setCode_capa($source_cnp->getCode_capa())
                                ->setId_credit($code_credit)
                                ->setDate_smc($date_smc->toString('yyyy-mm-dd'))
                                ->setMontant($credit_domi)
                                ->setEntree(0)
                                ->setSortie(0)
                                ->setSolde(0)
                                ->setSource_credit($source_credit)
                                ->setMontant_solde($credit_domi)
                                ->setType_smc($type_smc)
                                ->setCode_smcipn(null)
                                ->setCode_smcipnp(null)
                                ->setCode_domicilier($code_domi)
                                ->setOrigine_smc(0);
                        $m_smc->save($smc);
                        //Mise à jour du crédit à la source cnp
                        $cnp->setId_cnp($source_cnp->getId_cnp());
                        $cnp->setType_cnp($source_cnp->getType_cnp());
                        $cnp->setCode_capa($source_cnp->getCode_capa());
                        $cnp->setId_credit($source_cnp->getId_credit());
                        $cnp->setSource_credit($source_cnp->getSource_credit());
                        $cnp->setDate_cnp($source_cnp->getDate_cnp());
                        $cnp->setMont_debit($source_cnp->getMont_debit());
                        $cnp->setMont_credit($credit_domi);
                        $cnp->setSolde_cnp($source_cnp->getSolde_cnp() - $credit_domi);
                        $cnp->setCode_domicilier($source_cnp->getCode_domicilier());
                        $mcnp->update($cnp);
                        //Archivage du crédit dans la table eu_cnp_entree
                        $date_cnpe = Zend_Date::now();
                        $tcnp = new Application_Model_DbTable_EuCnpEntree();
                        $ecnp = new Application_Model_EuCnpEntree();
                        $ecnp->setId_cnp($cnp->getId_cnp())
                                ->setDate_entree($date_cnpe->toString('yyyy-mm-dd'))
                                ->setMont_cnp_entree($credit_domi)
                                ->setType_cnp_entree('gcsc');
                        $tcnp->insert($ecnp->toArray());
                    }
                }
            }
            $db->commit();
            $this->view->data = 'good';
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            $this->view->message = $message;
            $this->view->data = 'erreur';
            return;
        }
    }

    public function rembourseAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function rembourselistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'ass_smcii') {
            $type_domi = 'tpasmcii';
        } elseif ($group == 'ass_smcpnw') {
            $type_domi = 'tapsmcpnw';
        } else {
            $type_domi = '%';
        }
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        $select->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre)
                ->where('eu_domiciliation.id_utilisateur = ?', $user->id_utilisateur)
                ->where('eu_domiciliation.accorder = ?', 'o')
                ->where('eu_domiciliation.type_domiciliation like ?', $type_domi)
                ->where('eu_domiciliation.code_smcipnp is not Null')
                ->where('eu_domiciliation.code_membre_beneficiaire is not Null')
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
                $ress = 'Réccurent';
            } else {
                $ress = 'Non réccurent';
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
                $row->code_smcipnp,
                $accord,
                $row->cat_ressource,
                $row->type_domiciliation,
            );
            $i++;
        }
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
            $select = $tcredit->select();
            $select->where('code_produit in(?)', $produit)
                    ->where('code_membre in(?)', $tab_clt)
                    ->where('krr like ?', 'n')
                    ->where('code_compte like ?', 'nb%')
                    ->where('domicilier like ?', 0)
                    ->where('affecter like ?', 1);
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
        $mt_domi = $_GET['mt_domi'];
        $ress = 'nr';
        $code_smcipnp = $_GET['demand'];
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
        $msmcipnp = new Application_Model_EuSmcipnpMapper();
        $smcipnp = new Application_Model_EuSmcipnp();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $acteur = $user->code_membre;
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Cas du nr: récupération du montant total de la domiciliation
                $mt_credit = 0;
                $big_mdv = 5;
                foreach ($selection as $val) {
                    //Récupération du capa affecter
                    $find_capaa = $mcapaa->findByCredit($val['code_credit']);
                    if ($find_capaa != false) {
                        if ($big_mdv < $find_capaa->getDuree_renouvellement()) {
                            $big_mdv = $find_capaa->getDuree_renouvellement();
                        }
                        $mt_credit+=$find_capaa->getMont_invest();
                    }
                }
                $nb_jr = ceil($big_mdv * 30);
                $date->addDay($nb_jr);
                $date_echue = $date;

                $cumul_credit = 0;
                //Mise à jour des comptes crédits
                foreach ($selection as $sel) {
                    $result = $cm->find($sel['code_credit'], $cr);
                    if ($result) {
                        $cumul_credit+=$sel['mt_credit'];
                        $cr->setDomicilier(1);
                        $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_credit']);
                        $cm->update($cr);
                    }
                }
                //###Traitements généraux pour tous les types de domiciliation###
                //Contrôle du cumul du montant domicilié pour le remboursement de la smcipnp
                $mt_domicilie = 0;
                $somme_domi = $mdo->getSumDomicilier($code_smcipnp);
                $mont_obtenu = $mt_credit + $somme_domi;
                if ($mont_obtenu <= $mt_domi) {
                    $mt_domicilie = $cumul_credit;
                    $domicilier = 0;
                } else {
                    $mt_domicilie = $mt_domi - $somme_domi;
                    $domicilier = 1;
                }
                //Mise à jour de la table smcipnp
                $code_benef = '';
                $resul = $msmcipnp->find($code_smcipnp, $smcipnp);
                if ($resul) {
                    $smcipnp->setDomicilier($domicilier);
                    $msmcipnp->update($smcipnp);
                    $code_benef = $smcipnp->getCode_membre();
                }
                //Enregistrement dans la table de domiciliation
                $do->setMontant_subvent($mt_domicilie);
                $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                $do->setCode_domicilier($code_domici);
                $do->setCode_membre_beneficiaire($code_benef);
                $do->setCode_membre_assureur($user->code_membre);
                $do->setCat_ressource($ress);
                $do->setMontant_domicilier($mt_domicilie);
                //Récupération de la prk pour les nr
                $prk = 0;
                $param = new Application_Model_EuParametresMapper();
                $par = new Application_Model_EuParametres();
                $par_prk = $param->find('prk', 'nr', $par);
                if ($par_prk == true) {
                    $prk = $par->getMontant();
                }
                if ($prk >= $big_mdv) {
                    $do->setDomicilier('o');
                    $do->setDuree_renouvellement($big_mdv);
                    $do->setReste_duree(0);
                } else {
                    $do->setDomicilier('n');
                    $do->setDuree_renouvellement($big_mdv);
                    $do->setReste_duree($big_mdv);
                }
                $do->setAccorder('n');
                $do->setDate_domiciliation($date_domi->toString('yyyy-mm-dd'));
                $do->setType_domiciliation('tpasmcipnp');
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
                //Traitement spéciaux des nr
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
            $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->PREnom_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

}

?>
