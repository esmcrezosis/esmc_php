<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCnpController
 *
 * @author user
 */
class EuCnpController extends Zend_Controller_Action {

    //put your code here
    public function init() {

        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($user->code_groupe == 'rpgr_sortie') {
            $menu = '<li><a id="rpgrs" href="/eu-cnp/rpgrsortie">RPGr</a></li>';
        }  elseif ($user->code_groupe == 'rpgnr_sortie') {
            $menu = '<li><a id="rpgnrs" href="/eu-cnp/rpgnrsortie">RPGnr</a></li>';
        } elseif ($user->code_groupe == 'inr_sortie') {
            $menu = '<li><a id="inrs" href="/eu-cnp/inrsortie">Inr</a></li>';
        }elseif ($user->code_groupe == 'ir_sortie') {
            $menu = '<li><a id="irs" href="/eu-cnp/irsortie">Ir</a></li>';
        } elseif ($user->code_groupe == 'ee_entree') {
            $menu = '<li><a id="new" href="/eu-cnp/eentre?type=e/e">e/e</a></li>';
        } elseif ($user->code_groupe == 'panu_entree') {
            $menu = '<li><a id="new" href="/eu-cnp/panu?type=PaNu">PaNu</a></li>';
        } elseif ($user->code_groupe == 'fs_entree') {
            $menu = '<li><a id="new" href="/eu-cnp/fs?type=fs">rpg</a></li>';
        } elseif ($user->code_groupe == 'par_entree') {
            $menu = '<li><a id="new" href="/eu-cnp/par?type=PaR">PaR</a></li>';
        } elseif ($user->code_groupe == 'gcp_entree') {
            $menu = '<li><a id="new" href="/eu-cnp/par?type=gcp">gcp</a></li>';
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
            if ($user->code_groupe != 'rpgr_sortie' && $user->code_groupe != 'ir_sortie' && $user->code_groupe != 'rpgnr_sortie' && $user->code_groupe != 'inr_sortie' && $user->code_groupe != 'gcp_entree' && $user->code_groupe != 'ee_entree' && $user->code_groupe != 'fs_entree' && $user->code_groupe != 'par_entree' && $user->code_groupe != 'panu_entree') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function rpgrsortieAction() {
        
    }

    public function rpgrAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_cnp');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $type_cnp = $this->_request->getParam("type");
        $tabela = new Application_Model_DbTable_EuCnp();
        $select = $tabela->select();
        if ($date_deb != '' and $date_fin != '') {
            $datedeb = explode('/', $date_deb);
            $datefin = explode('/', $date_fin);
            $date1 = $datedeb[2] . "-" . $datedeb[1] . "-" . $datedeb[0];
            $date2 = $datefin[2] . "-" . $datefin[1] . "-" . $datefin[0];
            $select->where('eu_cnp.date_cnp > ?', $date1)
                    ->where('eu_cnp.date_cnp < ?', $date2);
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
    
    public function rpgnrsortieAction() {
        
    }

    public function rpgnrAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_cnp');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $type_cnp = $this->_request->getParam("type");
        $tabela = new Application_Model_DbTable_EuCnp();
        $select = $tabela->select();
        if ($date_deb != '' and $date_fin != '') {
            $datedeb = explode('/', $date_deb);
            $datefin = explode('/', $date_fin);
            $date1 = $datedeb[2] . "-" . $datedeb[1] . "-" . $datedeb[0];
            $date2 = $datefin[2] . "-" . $datefin[1] . "-" . $datefin[0];
            $select->where('eu_cnp.date_cnp > ?', $date1)
                    ->where('eu_cnp.date_cnp < ?', $date2);
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

    public function irsortieAction() {
        
    }

    public function irAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_cnp');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $type_cnp = $this->_request->getParam("type");
        $tabela = new Application_Model_DbTable_EuCnp();
        $select = $tabela->select();
        if ($date_deb != '' and $date_fin != '') {
            $datedeb = explode('/', $date_deb);
            $datefin = explode('/', $date_fin);
            $date1 = $datedeb[2] . "-" . $datedeb[1] . "-" . $datedeb[0];
            $date2 = $datefin[2] . "-" . $datefin[1] . "-" . $datefin[0];
            $select->where('eu_cnp.date_cnp > ?', $date1)
                    ->where('eu_cnp.date_cnp < ?', $date2);
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
    
    public function inrsortieAction() {
        
    }

    public function inrAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_cnp');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $type_cnp = $this->_request->getParam("type");
        $tabela = new Application_Model_DbTable_EuCnp();
        $select = $tabela->select();
        if ($date_deb != '' and $date_fin != '') {
            $datedeb = explode('/', $date_deb);
            $datefin = explode('/', $date_fin);
            $date1 = $datedeb[2] . "-" . $datedeb[1] . "-" . $datedeb[0];
            $date2 = $datefin[2] . "-" . $datefin[1] . "-" . $datefin[0];
            $select->where('eu_cnp.date_cnp > ?', $date1)
                    ->where('eu_cnp.date_cnp < ?', $date2);
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
    
    public function eentreAction() {
        $request = $this->getRequest();
        $type = $request->type;
        $this->view->type = $type;
    }

    public function eeAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_cnp_entree');
        $sord = $this->_request->getParam("sord", 'asc');
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $type_cnp = $this->_request->getParam("type");
        $tabela = new Application_Model_DbTable_EuCnpEntree();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_cnp', 'eu_cnp_entree.id_cnp = eu_cnp.id_cnp', array('mont_debit', 'solde_cnp','type_cnp'));
        if ($date_deb != '' and $date_fin != '') {
            $datedeb = explode('/', $date_deb);
            $datefin = explode('/', $date_fin);
            $date1 = $datedeb[2] . "-" . $datedeb[1] . "-" . $datedeb[0];
            $date2 = $datefin[2] . "-" . $datefin[1] . "-" . $datefin[0];
            $select->where('eu_cnp_entree.date_entree > ?', $date1)
                    ->where('eu_cnp_entree.date_entree < ?', $date2);
        }
        if ($type_cnp != '') {
            $select->where('eu_cnp_entree.type_cnp_entree = ?', $type_cnp);
        }
        $select->order('eu_cnp_entree.date_entree', 'asc');
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
            $date_op = new Zend_Date($row->date_entree, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_cnp_entree;
            $responce['rows'][$i]['cell'] = array(
                $row->id_cnp_entree,
                $date_op->toString('dd/mm/yyyy'),
                $row->type_cnp_entree,
                $row->mont_debit,
                $row->mont_cnp_entree,
                $row->solde_cnp,
                $row->type_cnp
            );
            $i++;
        }
        $this->view->data = $responce;
    }
}

?>
