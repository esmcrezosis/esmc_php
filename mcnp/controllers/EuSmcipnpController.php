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
class EuSmcipnpController extends Zend_Controller_Action {

//put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'gac' || $group == 'gacp' || $group == 'gacse' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca' || $group == 'filiere' || $group == 'creneau' || $group == 'surveillance') {
            $menu = "<li><a href=\"/eu-smcipnp/domicilier\">Domiciliation prk</a></li>" .
                    "<li><a href=\"/eu-smcipnp/domicilierimm \">Domiciliation pre</a></li>" .
                    "<li><a id=\"dsmcipnp\" href=\"#\">Liste domiciliations</a></li>" .
                    "<li><a id=\"dvsmcipnp\" href=\"#\">Domiciliations validées</a></li>" .
                    "<li><a href=\"/eu-smcipnp/newsmcipnp \">Demande smcipnp</a></li>" .
                    "<li><a href=\"/eu-smcipnp/newsmcipnpsans \">Demande smcipnp sans domiciliation</a></li>" .
                    "<li><a id=\"smcipnpok\" href=\"#\">smcipnp accordées</a></li>" .
                    "<li><a id=\"smcipnpsend\" href=\"#\"> smcipnp transférées</a></li>" .
                    "<li><a href=\"/eu-smcipnp/smcipnpre\">smcipnp reçues</a></li>" .
                    "<li><a href=\"/eu-smcipnp/transfert\">Transfert ti / tpn</a></li>" .
                    "<li><a href=\"/eu-smcipnp/listing\">Liste des transferts</a></li>" .
                    "<li><a href=\"/eu-smcipnp/affectersalaire\">Affectation salaire</a></li>" .
                    "<li><a href=\"/eu-smcipnp/salaireaffecte\">Salaires affectés</a></li>";
        } 
        elseif ($group == 'acteur') {
            $menu = "<li><a href=\"/eu-smcipnp/smcipnpre\">smcipnp reçues</a></li>" .
                    "<li><a href=\"/eu-smcipnp/transfert\">Transfert ti / tpn</a></li>" .
                    "<li><a href=\"/eu-smcipnp/listing\">Liste des transferts</a></li>" .
                    "<li><a href=\"/eu-smcipnp/affectersalaire\">Affectation salaire</a></li>" .
                    "<li><a href=\"/eu-smcipnp/salaireaffecte\">Salaires affectés</a></li>";
        } 
        elseif ($group == 'acnev' || $group == 'gacex' || $group == 'surveillance') {
            $menu = "<li><a href=\"/eu-smcipnp/smcipnpsend\">Liste smcipnp</a></li>" .
                    "<li><a href=\"/eu-smcipnp/smcipnpre\">smcipnp reçues</a></li>" .
                    "<li><a href=\"/eu-smcipnp/transfert\">Transfert ti / tpn</a></li>" .
                    "<li><a href=\"/eu-smcipnp/listing\">Liste des transferts</a></li>" .
                    "<li><a href=\"/eu-smcipnp/affectersalaire\">Affectation salaire</a></li>" .
                    "<li><a href=\"/eu-smcipnp/salaireaffecte\">Salaires affectés</a></li>";
        }
        if ($group == 'gac_pbf' || $group == 'gacp_pbf' || $group == 'gacse_pbf' || $group == 'gacr_pbf' || $group == 'gacs_pbf' || $group == 'gaca_pbf' || $group == 'filiere_pbf' || $group == 'creneau_pbf') {
            $menu = "<li><a href=\"/eu-smcipnp/domicilier\">Domicilier</a></li>" .
                    "<li><a id=\"dsmcipnp\" href=\"#\">Liste domiciliations</a></li>" .
                    "<li><a id=\"dvsmcipnp\" href=\"#\">Domiciliations validées</a></li>" .
                    "<li><a href=\"/eu-smcipnp/newsmcipnp \">Demande smcipnp</a></li>" .
                    "<li><a id=\"smcipnpok\" href=\"#\">smcipnp accordées</a></li>" .
                    "<li><a id=\"smcipnpsend\" href=\"#\"> smcipnp transférées</a></li>" .
                    "<li><a href=\"/eu-smcipnp/smcipnpre\">smcipnp reçues</a></li>" .
                    "<li><a href=\"/eu-smcipnp/transfert\">Transfert ti / tpn</a></li>" .
                    "<li><a href=\"/eu-smcipnp/listing\">Liste des transferts</a></li>" .
                    "<li><a href=\"/eu-smcipnp/affectersalaire\">Affectation salaire</a></li>" .
                    "<li><a href=\"/eu-smcipnp/salaireaffecte\">Salaires affectés</a></li>";
        } elseif ($group == 'acteur_pbf') {
            $menu = "<li><a href=\"/eu-smcipnp/smcipnpre\">smcipnp reçues</a></li>" .
                    "<li><a href=\"/eu-smcipnp/transfert\">Transfert ti / tpn</a></li>" .
                    "<li><a href=\"/eu-smcipnp/listing\">Liste des transferts</a></li>" .
                    "<li><a href=\"/eu-smcipnp/affectersalaire\">Affectation salaire</a></li>" .
                    "<li><a href=\"/eu-smcipnp/salaireaffecte\">Salaires affectés</a></li>";
        } elseif ($group == 'ass_smcip' || $group == 'ass_smcpnp') {
            $menu = "<li><a href=\"/eu-smcipnp/domicilier \">Domiciliation prk</a></li>" .
                    "<li><a href=\"/eu-smcipnp/domicilierimm \">Domiciliation pre</a></li>" .
                    "<li><a id=\"dsmcipnp\" href=\"#\">Liste domiciliations</a></li>" .
                    "<li><a id=\"dvsmcipnp\" href=\"#\">Domiciliations validées</a></li>";
        } elseif ($group == 'smc_tesmcipnwi' || $group == 'smc_tesmcipnp') {
            $menu = "<li><a href=\"/eu-smcipnp/transfert\">Transfert ti</a></li>";
            $menu = "<li><a href=\"/eu-smcipnp/transfert\">Transfert tpn</a></li>";
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
            if ($group != 'gac' && $group != 'gacp' && $group != 'gacse' && $group != 'gacr' && $group != 'gacs' && $group != 'gaca' && $group != 'filiere' && $group != 'creneau' && $group != 'acteur' && $group != 'agregat' && $group != 'ass_smcip' && $group != 'ass_smcpnp' &&
                $group != 'filiere_pbf' && $group != 'gac_pbf' && $group != 'gacp_pbf' && $group != 'gacse_pbf' && $group != 'gacr_pbf' && $group != 'gacs_pbf' && $group != 'gaca_pbf' && $group != 'creneau_pbf' && $group != 'acteur_pbf' && $group != 'acnev' 
		        && $group != 'gacex' && $group != 'surveillance' && $group != 'smc_tesmcipnwi' && $group != 'smc_tesmcipnp') {
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
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_smcipnp');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipnp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        //$acteur = $user->code_acteur;
        $id_user = $user->id_utilisateur;

        $select->setIntegrityCheck(false)
                //->where('eu_smcipnp.code_membre = ?', $acteur)
                ->where('eu_smcipnp.id_utilisateur = ?', $id_user)
                ->where('eu_smcipnp.etat_smcipnp = ?', 0)
                ->order('eu_smcipnp.date_smcipnp', 'desc');
        $smcipnp = $tabela->fetchAll($select);
        $count = count($smcipnp);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipnp = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($smcipnp as $row) {
            $date_dem = new Zend_Date($row->date_smcipnp, Zend_Date::ISO_8601);
            $heure_dem = new Zend_Date($row->heure_smcipnp, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipnp;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipnp,
                ucfirst($row->lib_smcipnp),
                $row->code_membre,
                $row->montant_smcipnp,
                $date_dem->toString('dd/mm/yyyy'),
                $heure_dem->toString('hh:mm'),
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

    public function membremoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function membrephysAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function domicilierAction() {
        
    }

    public function creditsAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'asc');

        if ($_GET['lignes'] != '') {
            $client = $_GET['lignes'];
            $cat_ress = $_GET['ress'];
            //Reconstitution du tableau des numéros membres
            $tab_clt = array();
            $tab_clt = explode(",", $client);
            $tcredit = new Application_Model_DbTable_EuCompteCredit();
            $select = $tcredit->select();
            if ($cat_ress == 'r') {
                $produit = array('RPGr', 'Ir', 'Fs', 'PaNu', 'PaR');
            }
            if ($cat_ress == 'nr') {
                $produit = array('RPGnr', 'Inr');
                $select->where('montant_credit not like ?', 0);
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
                    ->where('domicilier like ?', 0);
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

    public function domicilierimmAction() {
        
    }

    public function creditsimmAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'asc');

        if ($_GET['lignes'] != '') {
            $client = $_GET['lignes'];
            //Reconstitution du tableau des numéros membres
            $tab_clt = array();
            $tab_clt = explode(",", $client);
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

    public function createAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $mt_domi = $_GET['mt_domi'];
        $ress = $_GET['ress'];
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
        if ($user->code_groupe == 'filiere') {
            //Récupération du code_membre de la gac centrale
            $code_gac_fil = $user->code_acteur;
            $tablegac = new Application_Model_DbTable_EuGacFiliere();
            $selectgac = $tablegac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selectgac->setIntegrityCheck(false)
                    ->from(array('f' => 'eu_gac_filiere'), array('f.code_gac', 'f.code_gac_FILIERE'))
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = f.code_gac', array('g.code_membre', 'g.code_gac'))
                    ->where('f.code_gac_filiere like ?', $code_gac_fil);
            $filiere = $tablegac->fetchAll($selectgac);
            $acteur = $filiere[0]->code_membre;
        } else {
            $acteur = $user->code_membre;
        }
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Cas du nr: récupération du montant total de la domiciliation
                $mt_credit = 0;
                $date_end = new Zend_Date(Zend_Date::ISO_8601);
                $dvm = 1;
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
                //###Contrôle du total des crédits domiciliés avec le montant de la domiciliation###
                if ($mt_credit < $mt_domi) {
                    $db->rollback();
                    $this->view->data = 'err_domici';
                    return;
                } else {
                    //Mise à jour des comptes crédits
                    $cumul_credit = 0;
                    $nb_per = 0;
                    $test = false;
                    foreach ($selection as $sel) {
                        //Contrôle de l'existence de la domiciliation du crédit
                        $id_credit = $sel['code_credit'];
                        $find_cred = $cm->findByCredDomi($id_credit, 1);
                        if ($find_cred != null) {
                            $test = true;
                            $db->rollback();
                            $this->view->data = 'bad_domi';
                            return;
                        } else {
                            $cumul_credit+=$sel['mt_utilise'];
                            $nb_per+=1;
                            $result = $cm->find($sel['code_credit'], $cr);
                            if ($result) {
                                $cr->setDomicilier(1);
                                $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_utilise']);
                                $cm->update($cr);
                            }
                        }
                    }
                    if ($test == false) {
                        //###Traitements généraux pour tous les types de domiciliation###
                        //Enregistrement dans la table de domiciliation
                        $do->setMontant_subvent($mt_domi);
                        $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                        $do->setCode_DOMICILIER($code_domici);
                        $do->setCode_membre_beneficiaire(null);
                        $do->setCode_membre_assureur($acteur);
                        $do->setCat_ressource($ress);
                        if ($ress == 'nr') {
                            $do->setMontant_DOMICILIER($mt_domi);
                            $do->setDomicilier('o');
                            $do->setDuree_renouvellement($dvm);
                            $do->setReste_duree(0);
                        } else if ($ress == 'r') {
                            $do->setMontant_DOMICILIER($cumul_credit);
                            $do->setDomicilier('n');
                            $do->setDuree_renouvellement($dvm);
                            $do->setReste_duree($dvm - $nb_per);
                        }
                        $do->setAccorder('n');
                        $do->setDate_domiciliation($date_domi->toString('yyyy-mm-dd'));
                        $groupe = $user->code_groupe;
                        if ($groupe == 'ass_smcip') {
                            $type_domi = 'tpasmcip';
                        } else if ($groupe == 'ass_smcpnp') {
                            $type_domi = 'tpasmcpnp';
                        } else {
                            $type_domi = 'tpasmcipnp';
                        }
                        $do->setType_domiciliation($type_domi);
                        $do->setCode_smcipn(null);
                        $do->setCode_smcipnp(null);
                        $do->setId_utilisateur($user->id_utilisateur);
                        $dom = new Application_Model_DbTable_EuDomiciliation();
                        $code_dom = $dom->find($code_domici);
                        if (count($code_dom) < 1) {
                            $mdo->save($do);
                        } else {
                            $db->rollback();
                            $this->view->data = 'cool';
                            return;
                        }
                        //Enregistrement dans la table detail_domicilie
                        $mtab = array();
                        foreach ($selection as $tab) {
                            $dod->setCode_DOMICILIER($code_domici);
                            $dod->setId_credit($tab['code_credit']);
                            $dod->setCode_membre($tab['num_membre']);
                            $dod->setMontant_credit($tab['mt_utilise']);
                            $dod->setUtiliser(1);
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
                                $cnp->setCode_DOMICILIER($code_domici);
                                $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                                $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                                $m_cnp->update($cnp);
                            }
                        }
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

    public function createimmAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $mt_domi = $_GET['mt_domi'];
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
        if ($user->code_groupe == 'filiere') {
            //Récupération du code_membre de la gac centrale
            $code_gac_fil = $user->code_acteur;
            $tablegac = new Application_Model_DbTable_EuGacFiliere();
            $selectgac = $tablegac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selectgac->setIntegrityCheck(false)
                    ->from(array('f' => 'eu_gac_filiere'), array('f.code_gac', 'f.code_gac_FILIERE'))
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = f.code_gac', array('g.code_membre', 'g.code_gac'))
                    ->where('f.code_gac_filiere like ?', $code_gac_fil);
            $filiere = $tablegac->fetchAll($selectgac);
            $acteur = $filiere[0]->code_membre;
        } else {
            $acteur = $user->code_membre;
        }
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
                //###Contrôle du total des crédits domiciliés avec le montant de la domiciliation###
                $cumul_credit = 0;
                if ($mt_credit < $mt_domi) {
                    $db->rollback();
                    $this->view->data = 'err_domici';
                    return;
                } else {
                    //Mise à jour des comptes crédits
                    $test = false;
                    foreach ($selection as $sel) {
                        //Contrôle de l'existence de la domiciliation du crédit
                        $id_credit = $sel['code_credit'];
                        $find_cred = $cm->findByCredDomi($id_credit, 1);
                        if ($find_cred != null) {
                            $test = true;
                            $db->rollback();
                            $this->view->data = 'bad_domi';
                            return;
                        } else {
                            $result = $cm->find($sel['code_credit'], $cr);
                            if ($result) {
                                $cumul_credit+=$sel['mt_credit'];
                                $cr->setDomicilier(1);
                                $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_utilise']);
                                $cm->update($cr);
                            }
                        }
                    }
                    if ($test == false) {
                        //###Traitements généraux pour tous les types de domiciliation###
                        //Enregistrement dans la table de domiciliation
                        $do->setMontant_subvent($mt_domi);
                        $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                        $do->setCode_DOMICILIER($code_domici);
                        $do->setCode_membre_beneficiaire(null);
                        $do->setCode_membre_assureur($acteur);
                        $do->setCat_ressource($ress);
                        $do->setMontant_DOMICILIER($cumul_credit);
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
                        $groupe = $user->code_groupe;
                        if ($groupe == 'ass_smcip') {
                            $type_domi = 'tpasmcip';
                        } else if ($groupe == 'ass_smcpnp') {
                            $type_domi = 'tpasmcpnp';
                        } else {
                            $type_domi = 'tpasmcipnp';
                        }
                        $do->setType_domiciliation($type_domi);
                        $do->setCode_smcipn(null);
                        $do->setCode_smcipnp(null);
                        $do->setId_utilisateur($user->id_utilisateur);
                        $dom = new Application_Model_DbTable_EuDomiciliation();
                        $code_dom = $dom->find($code_domici);
                        if (count($code_dom) < 1) {
                            $mdo->save($do);
                        } else {
                            $db->rollback();
                            $this->view->data = 'cool';
                            return;
                        }
                        //Enregistrement dans la table detail_domicilie
                        $mtab = array();
                        foreach ($selection as $tab) {
                            $dod->setCode_DOMICILIER($code_domici);
                            $dod->setId_credit($tab['code_credit']);
                            $dod->setCode_membre($tab['num_membre']);
                            $dod->setMontant_credit($tab['mt_credit']);
                            $mdod->save($dod);
                            $mtab = $tab['num_membre'];
                        }
                        foreach ($selection as $sel) {
                            $result = $cm->find($sel['code_credit'], $cr);
                            //Diminution du montant du compte
                            $ret = $mcompte->find($cr->getCode_compte(), $compte);
                            if ($ret) {
                                $compte->setSolde($compte->getSolde() - $sel['mt_credit']);
                                $mcompte->update($compte);
                            }
                            //Mise à jour du code_domicilier dans la table capa_AFFECTER
                            $find_capaa = $mcapaa->findByCredit($cr->getId_credit());
                            if ($find_capaa != false) {
                                $capaa->setId_AFFECTER($find_capaa->getId_AFFECTER());
                                $capaa->setDuree_renouvellement($find_capaa->getDuree_renouvellement());
                                $capaa->setReste_duree($find_capaa->getReste_duree());
                                $capaa->setType_credit($find_capaa->getType_credit());
                                $capaa->setId_credit($find_capaa->getId_credit());
                                $capaa->setCode_DOMICILIER($code_domici);
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
                                $cnp->setCode_DOMICILIER($code_domici);
                                $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                                $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                                $m_cnp->update($cnp);
                            }
                        }
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

    public function domiciliationassAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function domiciliationAction() {
        $this->_helper->layout->disableLayout();
    }

    public function domicilistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        $code_benef = $user->code_membre;
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        if ($group == 'ass_smcip') {
            $type_domi = 'tpasmcip';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $code_benef);
        } elseif ($group == 'ass_smcpnp') {
            $type_domi = 'tapsmcpnp';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $code_benef);
        } elseif ($group == 'filiere') {
            $type_domi = '%';
            //Récupération du code_membre de la gac centrale liée
            $code_gac_fil = $user->code_acteur;
            $tablegac = new Application_Model_DbTable_EuGacFiliere();
            $selectgac = $tablegac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selectgac->setIntegrityCheck(false)
                    ->from(array('f' => 'eu_gac_filiere'), array('f.code_gac', 'f.code_gac_FILIERE'))
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = f.code_gac', array('g.code_membre', 'g.code_gac'))
                    ->where('f.code_gac_filiere like ?', $code_gac_fil);
            $filiere = $tablegac->fetchAll($selectgac);
            $code_gac = $filiere[0]->code_membre;
            $select->where('eu_domiciliation.code_membre_assureur = ?', $code_gac);
        } else {
            $type_domi = '%';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $code_benef);
        }
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $select->where('eu_domiciliation.id_utilisateur = ?', $user->id_utilisateur)
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
                $row->code_membre_assureur,
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

    public function domiciliationvalAction() {
        $this->_helper->layout->disableLayout();
    }

    public function domicilistvalAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        if ($group == 'ass_smcip') {
            $type_domi = 'tpasmcip';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre);
        } elseif ($group == 'ass_smcpnp') {
            $type_domi = 'tapsmcpnp';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre);
        } elseif ($group == 'filiere') {
            $type_domi = '%';
            //Récupération du code_membre de la gac centrale liée
            $code_gac_fil = $user->code_acteur;
            $tablegac = new Application_Model_DbTable_EuGacFiliere();
            $selectgac = $tablegac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selectgac->setIntegrityCheck(false)
                    ->from(array('f' => 'eu_gac_filiere'), array('f.code_gac', 'f.code_gac_FILIERE'))
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = f.code_gac', array('g.code_membre', 'g.code_gac'))
                    ->where('f.code_gac_filiere like ?', $code_gac_fil);
            $filiere = $tablegac->fetchAll($selectgac);
            $code_gac = $filiere[0]->code_membre;
            $select->where('eu_domiciliation.code_membre_assureur = ?', $code_gac);
        } else {
            $type_domi = '%';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre);
        }
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $select->where('eu_domiciliation.id_utilisateur = ?', $user->id_utilisateur)
                ->where('eu_domiciliation.accorder = ?', 'o')
                ->where('eu_domiciliation.type_domiciliation like ?', $type_domi)
                ->where('eu_domiciliation.code_smcipnp is null')
                ->where('eu_domiciliation.code_membre_beneficiaire is null')
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
                $row->code_membre_assureur,
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

    public function domicivalAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        if ($group == 'ass_smcip') {
            $type_domi = 'tpasmcip';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre);
        } elseif ($group == 'ass_smcpnp') {
            $type_domi = 'tapsmcpnp';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre);
        } elseif ($group == 'filiere') {
            $type_domi = '%';
            //Récupération du code_membre de la gac centrale liée
            $code_gac_fil = $user->code_acteur;
            $tablegac = new Application_Model_DbTable_EuGacFiliere();
            $selectgac = $tablegac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selectgac->setIntegrityCheck(false)
                    ->from(array('f' => 'eu_gac_filiere'), array('f.code_gac', 'f.code_gac_FILIERE'))
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = f.code_gac', array('g.code_membre', 'g.code_gac'))
                    ->where('f.code_gac_filiere like ?', $code_gac_fil);
            $filiere = $tablegac->fetchAll($selectgac);
            $code_gac = $filiere[0]->code_membre;
            $select->where('eu_domiciliation.code_membre_assureur = ?', $code_gac);
        } else {
            $type_domi = '%';
            $select->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre);
        }
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $select->where('eu_domiciliation.id_utilisateur = ?', $user->id_utilisateur)
                //->where('eu_domiciliation.accorder = ?', 'o')
                ->where('eu_domiciliation.type_domiciliation like ?', $type_domi)
                ->where('eu_domiciliation.code_smcipnp is null')
                ->where('eu_domiciliation.code_membre_beneficiaire is null')
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
                $row->code_membre_assureur,
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

    public function accorderAction() {

        $mdomi = New Application_Model_EuDomiciliationMapper();
        $domi = new Application_Model_EuDomiciliation();
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
        $code_domi = $_GET['code_domi'];
        $mt_subvent = $_GET['mt_subvent'];
        $mt_domici = $_GET['mt_domici'];
        $cat_ress = $_GET['cat_ress'];
        $assureur = $_GET['assureur'];
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_smc = clone $date;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Contrôle de l'état de la domiciliation
            if ($mt_domici < $mt_subvent) {
                $this->view->data = 'echec_domi';
                return;
            } else {
                //Mise à jour du compte de domiciliation
                $result = $mdomi->find($code_domi, $domi);
                if ($result) {
                    $domi->setAccorder('o');
                    $mdomi->update($domi);
                }
                //Enregistrement de la domiciliation(GCnr bleue) dans la table gcsc
                $gcsc->setCode_membre($assureur);
                $gcsc->setDebit(0);
                $gcsc->setCredit($mt_subvent);
                $gcsc->setSolde($mt_subvent);
                $gcsc->setCode_smcipn(null);
                $gcsc->setCode_smcipnp(null);
                $gcsc->setCode_DOMICILIER($code_domi);
                $mgcsc->save($gcsc);

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
                                $find_ech = $mech->findEchangeByCredit($id_credit);
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
                            $rap->setCode_DOMICILIER($code_domi);
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
                            $rap->setCode_DOMICILIER($code_domi);
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
                                ->setCode_DOMICILIER($code_domi)
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
                        $cnp->setCode_DOMICILIER($source_cnp->getCode_DOMICILIER());
                        $cnp->setTransfert_gcp($source_cnp->getTransfert_gcp());
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

    public function newsmcipnpAction() {
        
    }

    public function validsmcipnpAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = $_GET['lignes'];
        if (count($selection) > 0) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_demand = clone $date_id;
            $mapper = new Application_Model_EuSmcipnpMapper();
            $smcipnp = new Application_Model_EuSmcipnp();
            $mdom = new Application_Model_EuDomiciliationMapper();
            $dom = new Application_Model_EuDomiciliation();
            $code_membre = $_GET['code_membre'];
            $lib_smcipnp = $_GET['lib'];
            $desc_smcipn = $_GET['desc'];
            $mt_smcipnp = $_GET['mt_smcipnp'];
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Enregistrement dans la table smcipnp
                $code_smcipnp = 'smcipnp' . $code_membre . $date_demand->toString('yyyyMMddHHmmss');
                $smcipnp->setCode_smcipnp($code_smcipnp);
                $smcipnp->setCode_membre($code_membre);
                $smcipnp->setLib_smcipnp($lib_smcipnp);
                $smcipnp->setDesc_smcipnp($desc_smcipn);
                $smcipnp->setDate_smcipnp($date_demand->toString('yyyy-mm-dd'));
                $smcipnp->setHeure_smcipnp($date_demand->toString('hh:mm'));
                $smcipnp->setMontant_smcipnp($mt_smcipnp);
                $group = $user->code_groupe;
                if ($group == 'gac') {
                    $smcipnp->setSource_smcipnp('gac');
                } elseif ($group == 'filiere') {
                    $smcipnp->setSource_smcipnp('filiere');
                } elseif ($group == 'creneau') {
                    $smcipnp->setSource_smcipnp('creneau');
                } elseif ($group == 'acteur') {
                    $smcipnp->setSource_smcipnp('acteur');
                } elseif ($group == 'acnev') {
                    $smcipnp->setSource_smcipnp('acnev');
                }
                $smcipnp->setCode_acteur($user->code_acteur);
                $smcipnp->setDate_alloc(null);
                $smcipnp->setEtat_smcipnp(0);
                $smcipnp->setTransferer(0);
                $smcipnp->setRembourser(1);
                $smcipnp->setId_utilisateur($user->id_utilisateur);
                $smcipnp->setDomicilier(1);
                $mapper->save($smcipnp);

                //Mise à jour de la table de domiciliation
                foreach ($selection as $sel) {
                    $result = $mdom->find($sel, $dom);
                    if ($result) {
                        $dom->setCode_membre_beneficiaire($code_membre);
                        $dom->setCode_smcipnp($code_smcipnp);
                        $mdom->update($dom);
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                //return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                $this->view->data = 'erreur';
                return;
            }
        }
    }

    public function newsmcipnpsansAction() {
        
    }

    public function validsmcipnpsansAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_demand = clone $date_id;
        $mapper = new Application_Model_EuSmcipnpMapper();
        $smcipnp = new Application_Model_EuSmcipnp();
        $code_membre = $_GET['code_membre'];
        $lib_smcipnp = $_GET['lib'];
        $desc_smcipn = $_GET['desc'];
        $mt_smcipnp = $_GET['mt_smcipnp'];
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Enregistrement dans la table smcipnp
            $code_smcipnp = 'smcipnp' . $code_membre . $date_demand->toString('yyyyMMddHHmmss');
            $smcipnp->setCode_smcipnp($code_smcipnp);
            $smcipnp->setCode_membre($code_membre);
            $smcipnp->setLib_smcipnp($lib_smcipnp);
            $smcipnp->setDesc_smcipnp($desc_smcipn);
            $smcipnp->setDate_smcipnp($date_demand->toString('yyyy-mm-dd'));
            $smcipnp->setHeure_smcipnp($date_demand->toString('hh:mm'));
            $smcipnp->setMontant_smcipnp($mt_smcipnp);
            $group = $user->code_groupe;
            if ($group == 'gac') {
                $smcipnp->setSource_smcipnp('gac');
            } elseif ($group == 'filiere') {
                $smcipnp->setSource_smcipnp('filiere');
            } elseif ($group == 'creneau') {
                $smcipnp->setSource_smcipnp('creneau');
            } elseif ($group == 'acteur') {
                $smcipnp->setSource_smcipnp('acteur');
            } elseif ($group == 'acnev') {
                $smcipnp->setSource_smcipnp('acnev');
            }
            $smcipnp->setCode_acteur($user->code_acteur);
            $smcipnp->setDate_alloc(null);
            $smcipnp->setEtat_smcipnp(0);
            $smcipnp->setTransferer(0);
            $smcipnp->setRembourser(0);
            $smcipnp->setId_utilisateur($user->id_utilisateur);
            $smcipnp->setDomicilier(0);
            $mapper->save($smcipnp);
            //Création du cncs à la source smc
//            $type_smc = 'CNCSr';
//            $smc = new Application_Model_EuSmc();
//            $m_smc = new Application_Model_EuSmcMapper();
//            $smc->setCode_capa(null)
//                    ->setId_credit(null)
//                    ->setDate_smc($date_demand->toString('yyyy-mm-dd'))
//                    ->setMontant($mt_smcipnp)
//                    ->setEntree(0)
//                    ->setSortie(0)
//                    ->setSolde(0)
//                    ->setSource_credit(null)
//                    ->setMontant_solde($mt_smcipnp)
//                    ->setType_smc($type_smc)
//                    ->setCode_smcipn(null)
//                    ->setCode_smcipnp($code_smcipnp)
//                    ->setCode_DOMICILIER(null)
//                    ->setOrigine_smc(2);
//            $m_smc->save($smc);

            $db->commit();
            $this->view->data = 'good';
            //return $this->_helper->redirector('index');
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            $this->view->message = $message;
            $this->view->data = 'erreur';
            return;
        }
    }

    public function smcipnpaccordeAction() {
        $this->_helper->layout->disableLayout();
    }

    public function listaccordsmcipnpAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_smcipnp');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSmcipnp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_smcipnp.code_membre')
                ->where('eu_smcipnp.etat_smcipnp = ?', 1)
                ->where('eu_smcipnp.transferer = ?', 0)
                ->order('eu_smcipnp.date_smcipnp', 'desc');
        $smcipnp = $tabela->fetchAll($select);
        $count = count($smcipnp);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipnp = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($smcipnp as $row) {
            $date_dem = new Zend_Date($row->date_smcipnp, Zend_Date::ISO_8601);
            $heure_dem = new Zend_Date($row->heure_smcipnp, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipnp;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipnp,
                ucfirst($row->lib_smcipnp),
                $row->code_membre,
                ucfirst($row->raison_sociale),
                $row->montant_smcipnp,
                $date_dem->toString('dd/mm/yyyy'),
                $heure_dem->toString('hh:mm'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function smcipnpsendAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function listsendsmcipnpAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_smcipn');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSmcipnpwi();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('s' => 'EU_sMCIPNPWI'), array('*', "to_char((s.DATE_sMCIPN),'dd/mm/yyyy') DATE_sMCIPN"))
                ->join(array('m' => 'EU_mEmBRE_mORALE'), 'm.CODE_mEmBRE_mORALE = s.CODE_mEmBRE', array('CODE_mEmBRE_mORALE', 'RAIsON_sOCIALE'))
                ->where('s.TYPE_sMCIPN = ?', 'sMCIPNP')
                ->order('s.DATE_sMCIPN', 'desc');
        $smcipnp = $tabela->fetchAll($select);
        $count = count($smcipnp);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipnp = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totsalaire = 0;
        $totinvestis = 0;
        foreach ($smcipnp as $row) {
            $totsalaire+=$row->mont_salaire;
            $totinvestis+=$row->mont_investis;
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                $row->code_membre,
                ucfirst($row->raison_sociale),
                $row->date_smcipn,
                $row->mont_salaire,
                $row->mont_investis,
            );
            $i++;
        }
        $responce['userdata']['code_membre'] = 'Totaux:';
        $responce['userdata']['mt_salaire'] = $totsalaire;
        $responce['userdata']['mt_investis'] = $totinvestis;
        $this->view->data = $responce;
    }

    public function transfererAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $smcipnp = new Application_Model_EuSmcipnp();
        $msmcipnp = new Application_Model_EuSmcipnpMapper();
        $oper = new Application_Model_EuOperation();
        $moper = new Application_Model_EuOperationMapper();
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        if (count($selection) > 0) {
            $compte_tpa = 'nr-tpasmcp-' . $user->code_membre;
            //Contôle du montant de la smcipnp et du montant disponible sur le compte tpasmcp
            $tot_smcipnp = 0;
            foreach ($selection as $ctrl) {
                $msmcipnp->find($ctrl, $smcipnp);
                $tot_smcipnp+=$smcipnp->getMontant_smcipnp();
            }
            $cm_mapper->find($compte_tpa, $compte);
            if ($compte->getSolde() < $tot_smcipnp) {
                $this->view->data = 'no_tpa';
                return;
            } else {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
                    //Création des comptes vbpsn des bénéficiaires de la smcipnp
                    $cat_compte = 'vbpsn';
                    foreach ($selection as $sel) {
                        $msmcipnp->find($sel, $smcipnp);
                        //Mise à jour de la smcipnp
                        $smcipnp->setTransferer(1);
                        $msmcipnp->update($smcipnp);
                        //Test de l'existence du compte vbpsn et enregistrement dans la table compte
                        $compte_benef = 'nr-' . $cat_compte . '-' . $smcipnp->getCode_membre();
                        $find_compte = $cm_mapper->find($compte_benef, $compte);
                        if ($find_compte == false) {
                            $compte->setCode_compte($compte_benef)
                                    ->setCode_membre($smcipnp->getCode_membre())
                                    ->setCode_cat($cat_compte)
                                    ->setCode_type_compte('nr')
                                    ->setSolde($smcipnp->getMontant_smcipnp())
                                    ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                    ->setLib_compte($cat_compte)
                                    ->setDesactiver(0);
                            $cm_mapper->save($compte);
                        } else {
                            $compte->setSolde($compte->getSolde() + $smcipnp->getMontant_smcipnp());
                            $cm_mapper->update($compte);
                        }
                    }
                    //###########Traitements généraux#############
                    //Ajout dans la table opération
                    $oper->setDate_op($date_deb->toString('yyyy-mm-dd'));
                    $oper->setHeure_op($date_deb->toString('hh:mm'));
                    $oper->setMontant_op($tot_smcipnp);
                    $oper->setCode_membre($user->code_membre);
                    $oper->setCode_produit('CNCSr');
                    $oper->setId_utilisateur($user->id_utilisateur);
                    $oper->setLib_op('Transmission de la smcipnp');
                    $oper->setCode_cat('vbpsn');
                    $oper->setType_op('tsmcipnp');
                    $moper->save($oper);
                    //Mise à jour du compte tpasmcp de l'entrepôt d'achat
                    $result = $cm_mapper->find($compte_tpa, $compte);
                    if ($result == true) {
                        $compte->setSolde($compte->getSolde() - $tot_smcipnp);
                        $cm_mapper->update($compte);
                    }
                    $db->commit();
                    $this->view->data = 'good';
                    return;
                } catch (Exception $exc) {
                    $db->rollback();
                    return;
                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                    $this->view->data = 'echec';
                }
            }
        }
    }

    public function smcipnpreAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function smcipnplistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_smcipn');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipnpwi();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('s' => 'EU_sMCIPNPWI'), array('*', "to_char((s.DATE_sMCIPN),'dd/mm/yyyy') DATE_sMCIPN"))
                ->join(array('m' => 'EU_mEmBRE_mORALE'), 'm.CODE_mEmBRE_mORALE = s.CODE_mEmBRE', array('CODE_mEmBRE_mORALE', 'RAIsON_sOCIALE'))
                ->where('s.TYPE_sMCIPN = ?', 'sMCIPNP')
                ->where('s.code_membre = ?', $user->code_membre)
                ->order('s.DATE_sMCIPN', 'desc');
        $smcipnp = $tabela->fetchAll($select);
        $count = count($smcipnp);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipnp = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($smcipnp as $row) {
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                $row->code_membre,
                ucfirst($row->raison_sociale),
                $row->date_smcipn,
                $row->mont_salaire,
                $row->mont_investis,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function affectersalaireAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $nb_employe = $request->nb_employe;
            if ($nb_employe == 0 || $nb_employe == '') {
                $this->view->message = 'Préciser le nombre de salariés';
            } else {
                $this->view->data = $nb_employe;
                $compte_source = 'nr-tpn-' . $user->code_membre;
                $sal_percu = 0;
                //Récupération du montant total du salaire perçu sur le compte tpn
                $mcompte = new Application_Model_EuCompteMapper();
                $compte = new Application_Model_EuCompte();
                $rest = $mcompte->find($compte_source, $compte);
                if ($rest == false) {
                    $sal_percu = 0;
                } else {
                    $sal_percu = $compte->getSolde();
                }
                $this->view->sal_percu = number_format($sal_percu, 0, ',', ' ');
            }
        }
    }

    public function salairedispoAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'filiere') {
            //Récupération du code_membre de la gac centrale liée
            $code_gac_fil = $user->code_acteur;
            $tablegac = new Application_Model_DbTable_EuGacFiliere();
            $selectgac = $tablegac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selectgac->setIntegrityCheck(false)
                    ->from(array('f' => 'eu_gac_filiere'), array('f.code_gac', 'f.code_gac_FILIERE'))
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = f.code_gac', array('g.code_membre', 'g.code_gac'))
                    ->where('f.code_gac_filiere like ?', $code_gac_fil);
            $filiere = $tablegac->fetchAll($selectgac);
            $membre = $filiere[0]->code_membre;
        } else {
            $membre = $user->code_membre;
        }
        $compte_source = 'nr-tpn-' . $membre;
        $sal_percu = 0;
        $cumul_cred = 0;
        //Récupération du montant total du salaire perçu sur le compte tpn
        $mcompte = new Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $rest = $mcompte->find($compte_source, $compte);
        //Récupération du cumul des montants des comptes crédits provenant des smcipn
        $mccredit = new Application_Model_EuCompteCreditMapper();
        $find_credit = $mccredit->findByCompte($compte_source);
        if ($find_credit != false) {
            foreach ($find_credit as $row) {
                $cumul_cred += $row->getMontant_credit();
            }
        }
        if ($rest == false) {
            $sal_percu = 0;
        } else {
            $sal_percu = $compte->getSolde() - $cumul_cred;
        }
        $this->view->data = number_format($sal_percu, 0, ',', ' ');
    }

    public function smcipnpdispoAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'filiere') {
            //Récupération du code_membre de la gac centrale liée
            $code_gac_fil = $user->code_acteur;
            $tablegac = new Application_Model_DbTable_EuGacFiliere();
            $selectgac = $tablegac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selectgac->setIntegrityCheck(false)
                    ->from(array('f' => 'eu_gac_filiere'), array('f.code_gac', 'f.code_gac_FILIERE'))
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = f.code_gac', array('g.code_membre', 'g.code_gac'))
                    ->where('f.code_gac_filiere like ?', $code_gac_fil);
            $filiere = $tablegac->fetchAll($selectgac);
            $code_membre = $filiere[0]->code_membre;
        } else {
            $code_membre = $user->code_membre;
        }
        $compte_source = 'nr-smcipnp-' . $code_membre;
        $smcipnp_percu = 0;
        //Récupération du montant total de la smcipnp perçu sur le compte smcipnp
        $mcompte = new Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $rest = $mcompte->find($compte_source, $compte);
        if ($rest == false) {
            $smcipnp_percu = 0;
        } else {
            $smcipnp_percu = $compte->getSolde();
        }
        $this->view->data = number_format($smcipnp_percu, 0, ',', ' ');
    }

    public function affecterAction() {
        $this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_boss = $user->code_membre;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            if ($this->getRequest()->isPost()) {
                $selection = $_POST['cpteur'];
                $compte = new Application_Model_EuCompte();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $compte_credit = new Application_Model_EuCompteCredit();
                $cc_mapper = new Application_Model_EuCompteCreditMapper();
                $compte_source = 'nr-tpn-' . $num_boss;
                $res = $cm_mapper->find($compte_source, $compte);
                //Récupération du cumul des montants des comptes crédits provenant des smcipn
                $cumul_cred = 0;
                $find_credit = $cc_mapper->findByCompte($compte_source);
                if ($find_credit != false) {
                    foreach ($find_credit as $row) {
                        $cumul_cred += $row->getMontant_credit();
                    }
                }
                //Récupération du montant total des salaires affectés
                $cumul_sal = 0;
                for ($j = 1; $j <= $selection; $j++) {
                    $cumul_sal+=$_POST["salaire$j"];
                }
                if ($cumul_sal == 0) {
                    $this->view->data = 'echec';
                    return;
                } else if ($cumul_sal > $compte->getSolde() - $cumul_cred) {
                    $this->view->data = 'alloc_sal';
                    return;
                } else if ($res == false) {
                    $this->view->data = 'compte_err';
                    return;
                } else {
                    $date_all = new Zend_Date(Zend_Date::ISO_8601);
                    $date_alloc = clone $date_all;
                    for ($i = 1; $i <= $selection; $i++) {
                        //vérification de l'existence du membre salarié
                        $m_membre = new Application_Model_EuMembreMapper();
                        $o_membre = new Application_Model_EuMembre();
                        $retour = $m_membre->find($_POST["num_membre$i"], $o_membre);
                        if (!$retour) {
                            $this->view->data = 'salarie';
                            return;
                        } else {
                            $num_membre = $_POST["num_membre$i"];
                        }
                        $salaire = $_POST["salaire$i"];
                        $date_deb = $_POST["date_deb$i"];
                        $date_fin = $_POST["date_fin$i"];
                        $date1 = explode("-", $date_deb);
                        $date2 = explode("-", $date_fin);
                        if ($salaire != '' and $date_deb != '' and $date_fin != '') {
                            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                            $datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                            //Insertion du cumul des salaires dans la table compte de l'employé
                            $cat_compte = 'tcncs';
                            $num_comptes = 'nr-' . $cat_compte . '-' . $num_membre;
                            $result = $cm_mapper->find($num_comptes, $compte);
                            if ($result == false) {
                                $compte->setCode_compte($num_comptes)
                                        ->setCode_membre($num_membre)
                                        ->setMifareCard(null)
                                        ->setLib_compte($cat_compte)
                                        ->setSolde($salaire)
                                        ->setDate_alloc($date_alloc->toString('yyyy-mm-dd hh:mm:ss'))
                                        ->setCode_type_compte('nr')
                                        ->setCode_cat($cat_compte)
                                        ->setDesactiver(0)
                                        ->setCardPrintedDate(null)
                                        ->setCardPrintedIDDate(0)
                                        ->setNumero_carte(null)
                                        ->setCode_membre_morale(null);
                                $cm_mapper->save($compte);
                            } else {
                                $compte->setSolde($compte->getSolde() + $salaire);
                                $cm_mapper->update($compte);
                            }
                            //Ajout dans la table opération
                            $mapper = new Application_Model_EuOperationMapper();
                            $alloc = new Application_Model_EuOperation();
                            $compteur = $mapper->findConuter() + 1;
                            $alloc->setId_operation($compteur);
                            $alloc->setDate_op($date_alloc->toString('yyyy-mm-dd hh:mm:ss'));
                            $alloc->setHeure_op($date_alloc->toString('yyyy-mm-dd hh:mm:ss'));
                            $alloc->setMontant_op($salaire);
                            $alloc->setCode_membre($num_membre);
                            $alloc->setCode_produit('CNCSr');
                            $alloc->setId_utilisateur($user->id_utilisateur);
                            $alloc->setLib_op('Affectation de salaire à l\'employé');
                            $alloc->setCode_cat('tcncs');
                            $alloc->setType_op('ase');
                            $mapper->save($alloc);
                            //Insertion des détails des salaires dans la table compte crédit
                            $id_credit = $cc_mapper->findConuter() + 1;
                            $source=$num_membre . $date_alloc->toString('yyyyMMddHHmmss');
                            $compte_credit->setId_credit($id_credit)
                                    ->setId_operation($compteur)
                                    ->setCode_membre($num_membre)
                                    ->setCode_produit('CNCSr')
                                    ->setCode_compte($num_comptes)
                                    ->setMontant_place($salaire)
                                    ->setMontant_credit($salaire)
                                    ->setDatedeb($dated)
                                    ->setDatefin($datef)
                                    ->setSource($source)
                                    ->setDate_octroi($date_alloc->toString('yyyy-mm-dd hh:mm:ss'))
                                    ->setCompte_source($compte_source)
                                    ->setKrr('n')
                                    ->setRenouveller('n')
                                    ->setBnp(0)
                                    ->setDomicilier(0)
                                    ->setCode_bnp(null)
                                    ->setAffecter(0)
                                    ->setCode_type_credit(null)
                                    ->setPrk(0);
                            $cc_mapper->save($compte_credit);
                        } else {
                            $this->view->data = 'echec';
                            return;
                        }
                    }
                    //Mise à jour du compte tpn de l'employeur
                    $cm_mapper->find($compte_source, $compte);
                    $compte->setSolde($compte->getSolde() - $cumul_sal);
                    $cm_mapper->update($compte);
                }
            }
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
            $this->view->data = $message;
            return;
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

    public function listingAction() {
        
    }

    public function transfertlistAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select1 = $tabela->select();
        $select1->from(array('o' => 'EU_oPERATIoN'), array('o.*', "To_CHAR((o.DATE_oP),'dd/mm/yyyy') DATE_oP", "To_CHAR((o.HEURE_oP),'hh:mm') HEURE_oP"))
                ->where('o.id_utilisateur like ?', $user->id_utilisateur)
                ->where('o.TYPE_oP like ?', 'ttpn');
        $select2 = $tabela->select();
        $select2->from(array('o' => 'EU_oPERATIoN'), array('o.*', "To_CHAR((o.DATE_oP),'dd/mm/yyyy') DATE_oP", "To_CHAR((o.HEURE_oP),'hh:mm') HEURE_oP"))
                ->where('o.id_utilisateur like ?', $user->id_utilisateur)
                ->where('o.TYPE_oP like ?', 'tti');
        $select = $tabela->select();
        $select->setIntegrityCheck(true)
                ->union(array($select1, $select2));
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
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $row->code_produit,
                $row->lib_op,
                $row->montant_op,
                $row->date_op,
                $row->heure_op,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function transfertAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $membre = $user->code_membre;
        $request = $this->getRequest();

        if ($this->getRequest()->isPost()) {
            $terminal = $request->type_terminal;
            $mt = $request->mt_transfert;
            $db = Zend_Db_Table::getDefaultAdapter();
            $date = new Zend_Date(Zend_Date::ISO_8601);
            $date_deb = $date;
            $db->beginTransaction();
            try {
                $compte = new Application_Model_EuCompte();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $code_compte = 'nr-smcipnp-' . $membre;
                $trouve_compte = $cm_mapper->find($code_compte, $compte);
                if ($trouve_compte) {
                    $compte_db = new Application_Model_DbTable_EuCompte();
                    $compte_find = $compte_db->find($code_compte);
                    $result = $compte_find->current();
                    $solde = $result->solde;
                    if ($solde >= $mt) {
                        //Mise à jour du  compte smcipnp
                        $compte->setSolde($compte->getSolde() - $mt);
                        $cm_mapper->update($compte);

                        if ($terminal == 'ti') {
                            $code_comptet = 'nr-' . 'tsci-' . $membre;
                        } else {
                            $code_comptet = 'nr-' . 'tpn-' . $membre;
                        }
                        $comptetrouve = $cm_mapper->find($code_comptet, $compte);
                        if ($comptetrouve) {
                            $compte->setSolde($compte->getSolde() + $mt);
                            $cm_mapper->update($compte);
                        } else {
                            $compte->setCode_compte($code_comptet);
                            $compte->setCode_membre(null);
                            if ($terminal == 'ti') {
                                $compte->setLib_compte('tsci');
                            } else {
                                $compte->setLib_compte('tpn');
                            }
                            $compte->setSolde($mt);
                            $compte->setDate_alloc($date->toString('yyyy-mm-dd hh:mm:ss'));
                            $compte->setCode_type_compte('nr');
                            if ($terminal == 'ti') {
                                $compte->setCode_cat('tsci');
                            } else {
                                $compte->setCode_cat('tpn');
                            }
                            $compte->setDesactiver(0);
                            $compte->setCardPrintedDate(null);
                            $compte->setCardPrintedIDDate(0);
                            $compte->setNumero_carte(null);
                            $compte->setCode_membre_morale($membre);
                            $cm_mapper->save($compte);
                        }
                        //Enregistrement dans la table opération
                        $place = new Application_Model_EuOperation();
                        $mapper = new Application_Model_EuOperationMapper;
                        $id_operation = $mapper->findConuter() + 1;
                        $place->setId_operation($id_operation);
                        $place->setDate_op($date->toString('yyyy-mm-dd hh:mm:ss'));
                        $place->setHeure_op($date->toString('yyyy-mm-dd hh:mm:ss'));
                        $place->setId_utilisateur($user->id_utilisateur);
                        $place->setCode_membre($membre);
                        $place->setMontant_op($mt);
                        $place->setCode_produit('CNCSr');
                        if ($terminal == 'ti') {
                            $place->setLib_op('Transfert sur ti');
                            $place->setType_op('tti');
                        } else {
                            $place->setLib_op('Transfert sur tpn');
                            $place->setType_op('ttpn');
                        }
                        $place->setCode_cat('cncs');
                        $mapper->save($place);
                    } else {
                        $this->view->message = "Le montant à transférer est supérieur au montant sur le compte : " . "solde compte vaut " . $solde;
                        $this->view->type_terminal = $terminal;
                        $this->view->mt_transfert = $mt;
                        return;
                    }
                } else {
                    $this->view->message = "Votre compte  " . $code_compte . "  est inexistant";
                    $this->view->type_terminal = $terminal;
                    $this->view->mt_transfert = $mt;
                    return;
                }
                $db->commit();
                return $this->_helper->redirector('listing', 'eu-smcipnp');
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $e->getMessage() . ' ' . $e->getTraceAsString();
                $this->view->type_terminal = $terminal;
                $this->view->mt_transfert = $mt;
                return $this->view->message = $message;
            }
        }
    }

    public function salaireaffecteAction() {
        
    }

    public function salaireafflistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 40);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('o' => 'EU_oPERATIoN'), array('o.*', "To_CHAR((o.DATE_oP),'dd/mm/yyyy') DATE_oP", "To_CHAR((o.HEURE_oP),'hh:mm') HEURE_oP"))
                ->where('o.id_utilisateur = ?', $user->id_utilisateur)
                ->join('eu_membre', 'eu_membre.code_membre = o.code_membre', array('NoM_MEMBRE', 'PRENoM_MEMBRE'))
                ->where('o.TYPE_oP = ?', 'ase')
                ->order('o.DATE_oP', 'asc');
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

        foreach ($alloc as $row) {
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                ucfirst($row->nom_membre) . ' ' . ucfirst($row->PREnom_membre),
                $row->code_produit,
                $row->montant_op,
                $row->date_op,
                $row->heure_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }

}

?>
