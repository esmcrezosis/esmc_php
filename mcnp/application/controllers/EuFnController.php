<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuFnController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($user->code_groupe == 'dg' || $user->code_groupe == 'ti') {
            $menu = '<li><a id="irentree" href="/eu-fn/irentree">Ir entrée</a></li>
                <li><a id="inrentree" href="/eu-fn/inrentree">Inr entrée</a></li>
                <li><a id="irsortie" href="/eu-fn/irsortie">Ir sortie</a></li>
                <li><a id="inrsortie" href="/eu-fn/inrsortie">Inr sortie</a></li>';
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
            if ($group != 'dg' && $group != 'ti') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function datairentreeAction() {

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

        $select->where('eu_fn.type_fn like ?', 'Ir');
        $select->where('eu_fn.montant > ?', 0);
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
            $toti+=$row->montant;
            $date_op = new Zend_Date($row->date_fn, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_fn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_fn,
                $row->code_capa,
                $row->type_fn,
                $row->montant,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_fn'] = 'Total:';
        $responce['userdata']['montant'] = $toti;
        $this->view->data = $responce;
    }

    public function datainrentreeAction() {

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

        $select->where('eu_fn.type_fn like ?', 'Inr');
        $select->where('eu_fn.montant > ?', 0);
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
            $toti+=$row->montant;
            $date_op = new Zend_Date($row->date_fn, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_fn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_fn,
                $row->code_capa,
                $row->type_fn,
                $row->montant,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_fn'] = 'Total:';
        $responce['userdata']['montant'] = $toti;
        $this->view->data = $responce;
    }

    public function datairsortieAction() {

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

        $select->where('eu_fn.type_fn like ?', 'Ir');
        $select->where('eu_fn.sortie > ?', 0);
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
            $toti+=$row->sortie;
            $date_op = new Zend_Date($row->date_fn, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_fn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_fn,
                $row->code_capa,
                $row->type_fn,
                $row->sortie,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_fn'] = 'Total:';
        $responce['userdata']['montant'] = $toti;
        $this->view->data = $responce;
    }

    public function datainrsortieAction() {

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

        $select->where('eu_fn.type_fn like ?', 'Inr');
        $select->where('eu_fn.sortie > ?', 0);
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
            $toti+=$row->sortie;
            $date_op = new Zend_Date($row->date_fn, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_fn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_fn,
                $row->code_capa,
                $row->type_fn,
                $row->sortie,
                $date_op->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $responce['userdata']['type_fn'] = 'Total:';
        $responce['userdata']['montant'] = $toti;
        $this->view->data = $responce;
    }

    public function irentreeAction() {
        
    }

    public function irsortieAction() {
        
    }

    public function inrentreeAction() {
        
    }

    public function inrsortieAction() {
        
    }

}

?>
