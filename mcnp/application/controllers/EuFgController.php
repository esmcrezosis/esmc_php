<?php

class EuFgController extends Zend_Controller_Action {

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $menu = '';
        if ($user->code_groupe == 'fgi') {
            $menu = '<li><a href="/eu-fg/fgcompense?type=fgi">fgi Compensé</a></li>';
        } elseif ($user->code_groupe == 'fgrpg') {
            $menu = '<li><a href="/eu-fg/fgcompense?type=fgrpg">fgrpg Compensé</a></li>';
        } elseif ($user->code_groupe == 'fggcp') {
            $menu = '<li><a href="/eu-fg/fgcompense?type=fggcp">fggcp Compensé</a></li>';
        } elseif ($user->code_groupe == 'fgcncsr') {
            $menu = '<li><a href="/eu-fg/fgcompense?type=FGCNCSr">FGCNCSr Compensé</a></li>';
        } elseif ($user->code_groupe == 'fgcncsnr') {
            $menu = '<li><a href="/eu-fg/fgcompense?type=FGCNCSnr">FGCNCSnr Compensé</a></li>';
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
            if ($group != 'fgi' && $group != 'fgrpg' && $group != 'fggcp' && $group != 'fgcncsr' && $group != 'fgcncsnr') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function fgcompenseAction() {
        $request = $this->getRequest();
        $this->view->type = $request->type;
    }

    public function rapproAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_gcp_compense');
        $sord = $this->_request->getParam("sord", 'asc');
        $type = $this->_request->getParam("type");
        $date_deb = $this->_request->getParam("date_deb");
        $date_fin = $this->_request->getParam("date_fin");
        $tabela = new Application_Model_DbTable_EuGcpPbfCompense();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_compensation', 'eu_compensation.id_compens = eu_gcp_pbf_compense.id_compens', array('date_compens'));
        if ($date_deb != '' and $date_fin != '') {
            $datedeb = explode('/', $date_deb);
            $datefin = explode('/', $date_fin);
            $date1 = $datedeb[2] . "-" . $datedeb[1] . "-" . $datedeb[0];
            $date2 = $datefin[2] . "-" . $datefin[1] . "-" . $datefin[0];
            $select->where('eu_compensation.date_compens > ?', $date1)
                    ->where('eu_compensation.date_compens < ?', $date2);
        }
        $select->where('type_capa_gcp = ?', $type);
//                ->where('date_compens = ?', $date_deb->toString('yyyy-mm-dd'))
//                ->order('date_compens', 'asc');
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
            $responce['rows'][$i]['id'] = $row->id_gcp_compense;
            $responce['rows'][$i]['cell'] = array(
                $row->id_gcp_compense,
                $row->date_compens,
                $row->code_fgfn,
                $row->type_capa_fgfn,
                $row->mont_fgfn_sortie
            );
            $i++;
        }
        $this->view->data = $responce;
    }

}

