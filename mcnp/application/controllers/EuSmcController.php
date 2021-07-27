<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuSmcController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($user->code_groupe == 'dg' || $user->code_groupe == 'tpn') {
            $menu = '<li><a id="cncsrin" href="/eu-smc/cncsrin">CNCSr entrée</a></li>
                <li><a id="cncsnrin" href="/eu-smc/cncsnrin">CNCSnr entrée</a></li>
                <li><a id="cncsrout" href="/eu-smc/cncsrout">CNCSr sortie</a></li>
                <li><a id="cncsnrout" href="/eu-smc/cncsnrout">CNCSnr sortie</a></li>';
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
            if ($group != 'dg' && $group != 'tpn') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function datacncsrinAction() {

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
        $select->where('eu_smc.type_smc like ?', 'CNCSr');
        $select->where('eu_smc.montant > ?', 0);
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
            $totcncs+=$row->montant;
            $date_op = new Zend_Date($row->date_smc, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_smc;
            $responce['rows'][$i]['cell'] = array(
                $row->id_smc,
                $row->code_capa,
                $row->source_credit,
                $row->type_smc,
                $row->montant,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_smc'] = 'Total:';
        $responce['userdata']['montant'] = $totcncs;
        $this->view->data = $responce;
    }

    public function datacncsnrinAction() {

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
        $select->where('eu_smc.type_smc like ?', 'CNCSnr');
        $select->where('eu_smc.montant > ?', 0);
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
            $totcncs+=$row->montant;
            $date_op = new Zend_Date($row->date_smc, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_smc;
            $responce['rows'][$i]['cell'] = array(
                $row->id_smc,
                $row->code_capa,
                $row->source_credit,
                $row->type_smc,
                $row->montant,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_smc'] = 'Total:';
        $responce['userdata']['montant'] = $totcncs;
        $this->view->data = $responce;
    }

    public function datacncsroutAction() {

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
        $select->where('eu_smc.type_smc like ?', 'CNCSr');
        $select->where('eu_smc.sortie > ?', 0);
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
            $totcncs+=$row->sortie;
            $date_op = new Zend_Date($row->date_smc, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_smc;
            $responce['rows'][$i]['cell'] = array(
                $row->id_smc,
                $row->code_capa,
                $row->source_credit,
                $row->type_smc,
                $row->sortie,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_smc'] = 'Total:';
        $responce['userdata']['montant'] = $totcncs;
        $this->view->data = $responce;
    }

    public function datacncsnroutAction() {

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
        $select->where('eu_smc.type_smc like ?', 'CNCSnr');
        $select->where('eu_smc.sortie > ?', 0);
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
            $totcncs+=$row->sortie;
            $date_op = new Zend_Date($row->date_smc, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_smc;
            $responce['rows'][$i]['cell'] = array(
                $row->id_smc,
                $row->code_capa,
                $row->source_credit,
                $row->type_smc,
                $row->sortie,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_smc'] = 'Total:';
        $responce['userdata']['montant'] = $totcncs;
        $this->view->data = $responce;
    }

    public function cncsrinAction() {
        
    }

    public function cncsnrinAction() {
        
    }

    public function cncsroutAction() {
        
    }

    public function cncsnroutAction() {
        
    }

}

?>
