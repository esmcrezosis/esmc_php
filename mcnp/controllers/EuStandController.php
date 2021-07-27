<?php

class EuStandController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"new\" href=\"/eu-stand/new\">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'filiere' && $group != 'gac' && $group != 'creneau' && $group != 'acteur') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function foundAction() {

        $data = array();
        $besoin = new Application_Model_DbTable_EuBesoin();
        $select = $besoin->select();
        $select->from($besoin, array('objet_besoin'));
        $select->order('objet_besoin asc');
        $result = $besoin->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->objet_besoin;
        }
        $this->view->data = $data;
    }

    public function indexAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_stand');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuStand();
        $select = $tabela->select();
        $select->where('eu_stand.code_membre = ?', $code_membre);
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
            $responce['rows'][$i]['id'] = $row->id_stand;
            $responce['rows'][$i]['cell'] = array(
                $row->design_stand,
                $row->description
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {

        $request = $this->getRequest();
        $form = new Application_Form_EuStand();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $stand = new Application_Model_EuStand();
                $stand->setId_stand($this->_request->getPost("id_stand"));
                $stand->setDesign_stand($this->_request->getPost("design_stand"));
                $stand->setDescription($this->_request->getPost("description"));
                $stand->setCode_membre($code_membre);
                $sm = new Application_Model_EuStandMapper();
                $sm->save($stand);
                return $this->_helper->redirector('index');
            }
        }

        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-stand',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        //$this->view->zone = $zones;
        $this->view->form = $form;
    }

    public function editAction() {

        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuStand();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $stand = new Application_Model_EuStand();
                $sm = new Application_Model_EuStandMapper();
                $stand->setId_stand($this->_request->getPost("id_stand"));
                $stand->setDesign_stand($this->_request->getPost("design_stand"));
                $stand->setDescription($this->_request->getPost("description"));
                $stand->setCode_membre($code_membre);
                $sm->update($stand);
                return $this->_helper->redirector('index');
            }
        } else {
            $id_stand = $request->id_stand;
            $mapper = new Application_Model_EuStandMapper();
            $stand = new Application_Model_EuStand();
            $mapper->find($id_stand, $stand);
            if ($stand->getId_stand() == $id_stand) {
                $data = array(
                    'id_stand' => $stand->getId_stand(),
                    'design_stand' => $stand->getDesign_stand(),
                    'description' => $stand->getDescription(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-stand',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->stand = $stand;
        $this->view->form = $form;
    }

}
