<?php

class EuCodebarreController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $menu = "";
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
            if ($group != 'surveillance_technopole') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        // action body
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $id_utilisateur = $user->id_utilisateur;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'date_generer');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuCodebarre();
        $select = $tabela->select();
        $select->from(array('eu_codebarre'), array('codebarre', 'type_codebar', 'date_generer', 'codemembre_four', 'raisonsociale_four', 'date_four', 'idutilisateur', 'codemembre_dem', "to_char((date_generer),'dd/mm/yyyy HH24:mi:ss') as date_generer2", "to_char((date_four),'dd/mm/yyyy HH24:mi:ss') as date_four2"));
		$select->where('idutilisateur = ?', $id_utilisateur);
		$select->order('date_generer desc');
		$cats = $tabela->fetchAll($select);
        $count = count($cats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($cats as $row) {
			if($row->type_codebar == 'g'){$type_codebar = 'g';}
			elseif($row->type_codebar == 'sg'){$type_codebar = 's-g';}
			elseif($row->type_codebar == 'dt'){$type_codebar = 'd';}
			
            $responce['rows'][$i]['id'] = $row->codebarre;
            $responce['rows'][$i]['cell'] = array(
                $row->codebarre,
                $type_codebar,
                $row->DATE_GENERER2,
                $row->codemembre_four,
                $row->raisonsociale_four,
                $row->DATE_FOUR2,
                $row->codemembre_dem,
            );
            $i++;
        }
        $this->view->data = $responce;
    }


}

