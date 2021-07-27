<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuRapprochementController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($user->code_groupe == 'dg' || $user->code_groupe == 'rappro') {
            $menu = '<li><a id="rapir2" href="/eu-rapprochement/rapir2">Ir2/IrSC</a></li>
                <li><a id="rapinr2" href="/eu-rapprochement/rapinr2">Inr2/InrSC</a></li>
                <li><a id="rapir4" href="/eu-rapprochement/rapir4">Ir4/IrSC</a></li>
                <li><a id="rapinr4" href="/eu-rapprochement/rapinr4">Inr4/InrSC</a></li>
                <li><a id="rapgcp11" href="/eu-rapprochement/rapgcp11">GCP11/InrSC</a></li>
                <li><a id="rapgcp12" href="/eu-rapprochement/rapgcp12">GCP12/RPGnr</a></li>
                <li><a id="raprpgr" href="/eu-rapprochement/raprpgr">FGRPG1/RPGr</a></li>
                <li><a id="raprpgnr" href="/eu-rapprochement/raprpgnr">FGRPG1/RPGnr</a></li>
                <li><a id="cncsr" href="/eu-rapprochement/rapcncsr">CNCSr6/RPGnr</a></li>
                <li><a id="cncsnr" href="/eu-rapprochement/rapcncsnr">CNCSnr5/RPGnr</a></li>';
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
            if ($group != 'dg' && $group != 'rappro') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function datarapir2Action() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'Ir2/IrSc');
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

    public function datarapinr2Action() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'Inr2/InrSc');
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

    public function datarapir4Action() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'Ir4/IrSc');
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

    public function datarapinr4Action() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'Inr4/InrSc');
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

    public function datarapgcp11Action() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'GCP11/InrSC');
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

    public function datarapgcp12Action() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'GCP12/RPGnr');
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

    public function dataraprpgrAction() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'FGRPG1/RPGr');
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
    
    public function dataraprpgnrAction() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'FGRPG1/RPGnr');
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
    
    public function datarapcncsrAction() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'CNCSr6/RPGnr');
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
    
    public function datarapcncsnrAction() {

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
        $select->where('eu_rapprochement.type_rappro like ?', 'CNCSnr5/RPGnr');
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
