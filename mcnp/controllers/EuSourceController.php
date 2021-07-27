<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuSourceController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($user->code_groupe == 'agregat' || $user->code_groupe == 'dg') {
            $menu = '<li><a id="new" href="/eu-source/cnp">Source cnp</a></li>
                <li><a id="bq_consult" href="/eu-source/smc">Source smc</a></li>
                <li><a id="bnp" href="/eu-source/fn">Source fn</a></li>
                <li><a id="bnp" href="/eu-source/fgfn">fgfn</a></li>
                <li><a id="rappro" href="/eu-source/rappro">Table rapprochement</a></li>';
        }  elseif ($user->code_groupe == 'smc_entree_r' || $user->code_groupe == 'smc_entree_nr' || $user->code_groupe == 'smc_sortie_nr' || $user->code_groupe == 'smc_sortie_r' || $user->code_groupe == 'fn_entree_r' || $user->code_groupe == 'fn_entree_nr' || $user->code_groupe == 'fn_sortie_nr' || $user->code_groupe == 'fn_sortie_r') {
            $menu = '';
        } elseif ($user->code_groupe == 'rap_ir2irsc' || $user->code_groupe == 'rap_inr2inrsc' || $user->code_groupe == 'rap_ir4irsc' || $user->code_groupe == 'rap_inr4inrsc' || $user->code_groupe == 'rap_gcp11inrsc') {
            $menu = '';
        } elseif ($user->code_groupe == 'rap_gcp12rpgnr' || $user->code_groupe == 'rap_fgrpg1rpgr' || $user->code_groupe == 'rap_fgrpg1rpgnr' || $user->code_groupe == 'rap_cncsr6rpgnr' || $user->code_groupe == 'rap_cncsnr5rpgnr') {
            $menu = '';
        } elseif ($user->code_groupe == 'compta') {
            $menu = '<li><a id="new" href="/eu-source/transfert">Transfert effectués</a></li>
                <li><a id="bnp" href="/eu-source/fgfn">fgfn</a></li>
                <li><a id="bnp" href="/eu-source/pbf">pbf</a></li>';
        }

        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    function preDispatch() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'compta' and $group != 'agregat' and $group != 'dg' and $group != 'banque' and $group != 'apa' and $group != 'smc_entree_r' and $group != 'smc_entree_nr' and $group != 'smc_sortie_r' and $group != 'smc_sortie_nr' and $group != 'fn_entree_r' and $group != 'fn_entree_nr' and $group != 'fn_sortie_nr' and $group != 'fn_sortie_r' and $group != 'rap_ir2irsc' and $user->code_groupe != 'rap_inr2inrsc' and $user->code_groupe != 'rap_ir4irsc' and $user->code_groupe != 'rap_inr4inrsc' and $user->code_groupe != 'rap_gcp11inrsc' and $user->code_groupe != 'rap_gcp12rpgnr' and $user->code_groupe != 'rap_fgrpg1rpgr' and $user->code_groupe != 'rap_fgrpg1rpgnr' and $user->code_groupe != 'rap_cncsr6rpgnr' and $user->code_groupe != 'rap_cncsnr5rpgnr') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function fondsAction() {
        
    }

    public function pbfAction() {
        
    }

    public function cgcpAction() {
        $code_membre = $_GET["membre"];
        $cm_mapper = new Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $fg_mapper = new Application_Model_EuFgfnMapper();
        $fg = new Application_Model_EuFgfn();
        $data = array();
        //Enregistrement dans le compte gcp
        $v_num_compte = 'nb-' . 'tpagcp-' . $code_membre;
        $fgfn = 'fgfn-' . $code_membre;
        $retour = $cm_mapper->find($v_num_compte, $compte);
        if ($retour) {
            $data[0] = round($compte->getSolde());
        } else {
            $data[0] = 0;
        }
        $ret = $fg_mapper->find($fgfn, $fg);
        if ($ret) {
            $data[1] = round($fg->getSolde_fgfn());
        } else {
            $data[1] = 0;
        }
        $this->view->data = $data;
    }

    public function gcppbfAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_gcp_pbf');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->_request->getParam("membre");
        $tabela = new Application_Model_DbTable_EuGcpPbf();
        $select = $tabela->select();
        $select->where('code_membre like ?', $code_membre)
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
            $i++;
        }
        $this->view->data = $responce;
    }

    public function fgfnpbfAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_fgfn');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->_request->getParam("membre");
        $date_fg = $this->_request->getParam("date");
        $type = $this->_request->getParam("type");
        $tabela = new Application_Model_DbTable_EuDetailFgFn();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_capa', 'eu_detail_fgfn.code_capa = eu_capa.code_capa', array('montant_capa', 'code_produit', 'code_membre'));
        if ($date_fg != '') {
            $date_exp = explode('/', $date_fg);
            $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('date_fgfn = ?', $date);
        }
        if ($type != '') {
            $select->where('eu_detail_fgfn.type_capa = ?', 'capa' . $type);
        }
        $select->where('code_membre_pbf = ?', $code_membre);
        $select->order('code_membre_pbf');
        //$select->order('date', 'asc');
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
            $i++;
        }
        $this->view->data = $responce;
    }

    public function compAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_compens');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->_request->getParam("membre");
        $tabela = new Application_Model_DbTable_EuCompensation();
        $select = $tabela->select();
        $select->where('code_membre_pbf like ?', $code_membre)
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
            $i++;
        }
        $this->view->data = $responce;
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

    public function datasmcAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_smc');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_smc = $this->_request->getParam("date");
        $type_smc = $this->_request->getParam("type");
        $compte_smc = $this->_request->getParam("compte");
        $tabela = new Application_Model_DbTable_EuSmc();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_compte_credit', 'eu_smc.id_credit = eu_compte_credit.id_credit', array('code_compte', 'code_produit', 'code_capa', 'code_membre'));
        if ($compte_smc != '') {
            $select->where('eu_compte_credit.code_compte like ?', "%" . $compte_smc . "%");
        }
        if ($date_smc != '') {
            $date_exp = explode('/', $date_smc);
            $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('eu_smc.date_smc = ?', $date);
        }
        if ($type_smc != '') {
            $select->where('eu_smc.type_smc = ?', $type_smc);
        }
        $select->order('eu_smc.date_smc', 'asc');
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
            $date_op = new Zend_Date($row->date_smc, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_smc;
            $responce['rows'][$i]['cell'] = array(
                $row->id_smc,
                $date_op->toString('dd/mm/yyyy'),
                $row->type_smc,
                $row->montant,
                $row->sortie,
                $row->entree,
                $row->solde,
                $row->mt_solde
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function datafnAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_fn');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_fn = $this->_request->getParam("date");
        $type_fn = $this->_request->getParam("type");
        $compte_fn = $this->_request->getParam("produit");
        $tabela = new Application_Model_DbTable_EuFn();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_capa', 'eu_fn.code_capa = eu_capa.code_capa', array('montant_capa', 'code_produit', 'code_membre'));
        if ($compte_fn != '') {
            $select->where('eu_capa.code_produit like ?', "%" . $compte_fn . "%");
        }
        if ($date_fn != '') {
            $date_exp = explode('/', $date_fn);
            $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('eu_fn.date_fn = ?', $date);
        }
        if ($type_fn != '') {
            $select->where('eu_fn.type_fn = ?', $type_fn);
        }
        $select->order('eu_fn.date_fn', 'asc');
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
            $responce['rows'][$i]['id'] = $row->id_fn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_capa,
                $row->code_membre,
                $row->code_produit,
                $row->montant_capa,
                $row->code_fn,
                $row->type_fn,
                $row->montant,
                $row->sortie,
                $row->entree,
                $row->solde,
                $row->mt_solde,
                $row->date_fn
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function datafgfnAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_fgfn');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_fg = $this->_request->getParam("date");
        $membre = $this->_request->getParam("membre");
        $tabela = new Application_Model_DbTable_EuDetailFgFn();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_capa', 'eu_detail_fgfn.code_capa = eu_capa.code_capa', array('montant_capa', 'code_produit', 'code_membre'));
        if ($date_fg != '') {
            $date_exp = explode('/', $date_fg);
            $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('date_fgfn = ?', $date);
        }
        if ($membre != null) {
            $select->where('code_membre_pbf = ?', $membre);
        }
        $select->order('code_membre_pbf');
        //$select->order('date', 'asc');
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
            $i++;
        }
        $this->view->data = $responce;
    }

    public function datacnpAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_cnp');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_cnp = $this->_request->getParam("date");
        $type_cnp = $this->_request->getParam("type");
        $compte_cnp = $this->_request->getParam("compte");
        $membre_cnp = $this->_request->getParam("membre");
        $tabela = new Application_Model_DbTable_EuCnp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_compte_credit', 'eu_cnp.id_credit = eu_compte_credit.id_credit');
        if ($compte_cnp != '') {
            $select->where('eu_compte_credit.code_produit = ?', $compte_cnp);
        }
        if ($membre_cnp != '') {
            if ($compte_cnp != '') {
                $select->where('eu_compte_credit.code_membre like ?', "%" . $membre_cnp . "%");
            } else {
                $select->where('eu_compte_credit.code_membre like ?', "%" . $membre_cnp . "%");
            }
        }
        if ($date_cnp != '') {
            $date_exp = explode('/', $date_cnp);
            $date = $date_exp[2] . "-" . $date_exp[1] . "-" . $date_exp[0];
            $select->where('eu_cnp.date_cnp = ?', $date);
        }
        if ($type_cnp != '') {
            $select->where('eu_cnp.type_cnp = ?', $type_cnp);
        }
        $select->order('eu_cnp.date_cnp', 'asc');
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
            $date_op = new Zend_Date($row->date_cnp, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_cnp;
            $responce['rows'][$i]['cell'] = array(
                $row->id_cnp,
                $date_op->toString('dd/mm/yyyy'),
                $row->type_cnp,
                $row->mont_debit,
                $row->mont_credit,
                $row->solde_cnp,
                $row->id_credit
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function datarapproAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 1000);
        $sidx = $this->_request->getParam("sidx", 'id_rappro');
        $sord = $this->_request->getParam("sord", 'asc');
        $type_gcnr = $this->_request->getParam("type_gcnr");
        $rappro = $this->_request->getParam("rappro");
        $tabela = new Application_Model_DbTable_EuRapprochement();
        $select = $tabela->select();
        if ($type_gcnr == '') {
            $select->where('eu_rapprochement.source like ?', '%');
        }
        if ($type_gcnr != '') {
            $select->where('eu_rapprochement.source like ?', $type_gcnr);
        }
        if ($rappro == '') {
            $select->where('eu_rapprochement.solde_rappro like ?', '%');
        }
        if ($rappro == "oui") {
            $select->where('eu_rapprochement.solde_rappro = ?', 0);
        }
        if ($rappro == "non") {
            $select->where('eu_rapprochement.solde_rappro != ?', 0);
        }
        $select->order('eu_rapprochement.id_rappro', 'asc');
        $rap = $tabela->fetchAll($select);
        $count = count($rap);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $rap = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($rap as $row) {
            $responce['rows'][$i]['id'] = $row->id_rappro;
            $responce['rows'][$i]['cell'] = array(
                $row->id_credit,
                $row->source,
                $row->source_credit,
                $row->debit_rappro,
                $row->credit_rappro,
                abs($row->solde_rappro),
                $row->code_smcipn,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function datacncsAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_smc');
        $sord = $this->_request->getParam("sord", 'desc');
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $tabela = new Application_Model_DbTable_EuSmc();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        if ($date_deb != '') {
            $date_debut = explode('/', $date_deb);
            $date1 = $date_debut[2] . "-" . $date_debut[1] . "-" . $date_debut[0];
            $select->where('eu_smc.date_smc >= ?', $date1);
        }
        if ($date_fin != '') {
            $date_end = explode('/', $date_fin);
            $date = $date_end[2] . "-" . $date_end[1] . "-" . $date_end[0];
            $select->where('eu_smc.date_smc <= ?', $date);
        }
        if ($group == 'smc_entree_r') {
            $type_smc = 'CNCSr';
            $select->where('eu_smc.montant > ?', 0);
        } else if ($group == 'smc_sortie_r') {
            $type_smc = 'CNCSr';
            $select->where('eu_smc.sortie > ?', 0);
        } else if ($group == 'smc_entree_nr') {
            $type_smc = 'CNCSnr';
            $select->where('eu_smc.montant > ?', 0);
        } else if ($group == 'smc_sortie_nr') {
            $type_smc = 'CNCSnr';
            $select->where('eu_smc.sortie > ?', 0);
        }
        $select->where('eu_smc.type_smc like ?', $type_smc);
        $select->order('eu_smc.date_smc', 'asc');
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
        $totcncs = 0;
        foreach ($achats as $row) {
            if ($group == 'smc_entree_r' || $group == 'smc_entree_nr') {
                $mont = $row->montant;
                $totcncs+=$row->montant;
            } else if ($group == 'smc_sortie_r' || $group == 'smc_sortie_nr') {
                $mont = $row->sortie;
                $totcncs+=$row->sortie;
            }
            $date_op = new Zend_Date($row->date_smc, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_smc;
            $responce['rows'][$i]['cell'] = array(
                $row->id_smc,
                $row->code_capa,
                $row->source_credit,
                $row->type_smc,
                $mont,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_smc'] = 'Total:';
        $responce['userdata']['montant'] = $totcncs;
        $this->view->data = $responce;
    }

    public function dataiAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_fn');
        $sord = $this->_request->getParam("sord", 'desc');
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $tabela = new Application_Model_DbTable_EuFn();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        if ($date_deb != '') {
            $date_debut = explode('/', $date_deb);
            $date1 = $date_debut[2] . "-" . $date_debut[1] . "-" . $date_debut[0];
            $select->where('eu_fn.date_fn >= ?', $date1);
        }
        if ($date_fin != '') {
            $date_end = explode('/', $date_fin);
            $date = $date_end[2] . "-" . $date_end[1] . "-" . $date_end[0];
            $select->where('eu_fn.date_fn <= ?', $date);
        }
        if ($group == 'fn_entree_r') {
            $type_fn = 'Ir';
            $select->where('eu_fn.montant > ?', 0);
        } else if ($group == 'fn_sortie_r') {
            $type_fn = 'Ir';
            $select->where('eu_fn.sortie > ?', 0);
        } else if ($group == 'fn_entree_nr') {
            $type_fn = 'Inr';
            $select->where('eu_fn.montant > ?', 0);
        } else if ($group == 'fn_sortie_nr') {
            $type_fn = 'Inr';
            $select->where('eu_fn.sortie > ?', 0);
        }

        $select->where('eu_fn.type_fn like ?', $type_fn);
        $select->order('eu_fn.date_fn', 'asc');
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
        $toti = 0;
        foreach ($achats as $row) {
            if ($group == 'fn_entree_r' || $group == 'fn_entree_nr') {
                $mont = $row->montant;
                $toti+=$row->montant;
            } else if ($group == 'fn_sortie_r' || $group == 'fn_sortie_nr') {
                $mont = $row->sortie;
                $toti+=$row->sortie;
            }
            $date_op = new Zend_Date($row->date_fn, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_fn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_fn,
                $row->code_capa,
                $row->type_fn,
                $mont,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_fn'] = 'Total:';
        $responce['userdata']['montant'] = $toti;
        $this->view->data = $responce;
    }

    public function datarapAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'id_rappro');
        $sord = $this->_request->getParam("sord", 'asc');
        $type_gcnr = $this->_request->getParam("type_gcnr");
        $rappro = $this->_request->getParam("rappro");
        $tabela = new Application_Model_DbTable_EuRapprochement();
        $select = $tabela->select();

        if ($type_gcnr == '') {
            $select->where('eu_rapprochement.source like ?', '%');
        }
        if ($type_gcnr != '') {
            $select->where('eu_rapprochement.source like ?', $type_gcnr);
        }
        if ($rappro == '') {
            $select->where('eu_rapprochement.solde_rappro like ?', '%');
        }
        if ($rappro == "oui") {
            $select->where('eu_rapprochement.solde_rappro = ?', 0);
        }
        if ($rappro == "non") {
            $select->where('eu_rapprochement.solde_rappro != ?', 0);
        }
        if ($group == 'rap_ir2irsc') {
            $type_rappro = 'Ir2/IrSc';
        } else if ($group == 'rap_inr2inrsc') {
            $type_rappro = 'Inr2/InrSc';
        } else if ($group == 'rap_ir4irsc') {
            $type_rappro = 'Ir4/IrSc';
        } else if ($group == 'rap_inr4inrsc') {
            $type_rappro = 'Inr4/InrSc';
        } else if ($group == 'rap_gcp11inrsc') {
            $type_rappro = 'GCP11/InrSC';
        } else if ($group == 'rap_gcp12rpgnr') {
            $type_rappro = 'GCP12/RPGnr';
        } else if ($group == 'rap_fgrpg1rpgr') {
            $type_rappro = 'FGRPG1/RPGr';
        } else if ($group == 'rap_fgrpg1rpgnr') {
            $type_rappro = 'FGRPG1/RPGnr';
        } else if ($group == 'rap_cncsr6rpgnr') {
            $type_rappro = 'CNCSr6/RPGnr';
        } else if ($group == 'rap_cncsnr5rpgnr') {
            $type_rappro = 'CNCSnr5/RPGnr';
        }

        $select->where('eu_rapprochement.type_rappro like ?', $type_rappro);
        $select->order('eu_rapprochement.id_rappro', 'asc');
        $rap = $tabela->fetchAll($select);
        $count = count($rap);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $rap = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($rap as $row) {
            $responce['rows'][$i]['id'] = $row->id_rappro;
            $responce['rows'][$i]['cell'] = array(
                $row->source_credit,
                $row->source,
                $row->source_credit,
                $row->debit_rappro,
                $row->credit_rappro,
                abs($row->solde_rappro),
            );
            $i++;
        }
        $this->view->data = $responce;
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

    public function indexAction() {
        
    }

    public function fnAction() {
        
    }

    public function cnpAction() {
        
    }

    public function fgfnAction() {
        
    }

    public function smcAction() {
        
    }

    public function rapproAction() {
        
    }

    public function compensationAction() {
        
    }

    public function irentreeAction() {
        
    }

    public function irsortieAction() {
        
    }

    public function inrentreeAction() {
        
    }

    public function inrsortieAction() {
        
    }

    public function cncsrinAction() {
        
    }

    public function cncsnrinAction() {
        
    }

    public function cncsroutAction() {
        
    }

    public function cncsnroutAction() {
        
    }

    public function rapir2Action() {
        
    }

    public function rapinr2Action() {
        
    }

    public function rapir4Action() {
        
    }

    public function rapinr4Action() {
        
    }

    public function rapgcp11Action() {
        
    }

    public function rapgcp12Action() {
        
    }

    public function raprpgrAction() {
        
    }

    public function raprpgnrAction() {
        
    }

    public function rapcncsrAction() {
        
    }

    public function rapcncsnrAction() {
        
    }

}

?>
