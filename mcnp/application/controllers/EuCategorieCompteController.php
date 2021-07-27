<?php

class EuCategorieCompteController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a href=\" /eu-categorie-compte/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'agregat' and $group != 'admin' and $group != 'dg') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_cat');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCategorieCompte();
        $select = $tabela->select();
        $cat_compte = $tabela->fetchAll($select);
        $count = count($cat_compte);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $cat_compte = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($cat_compte as $row) {
            $responce['rows'][$i]['id'] = $row->code_cat;
            $responce['rows'][$i]['cell'] = array(
                $row->code_cat,
                $row->lib_cat,
                $row->desc_cat,
                $row->code_type_compte
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $request = $this->getRequest();
        $form = new Application_Form_EuCategorieCompte();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $cat = new Application_Model_EuCategorieCompte($form->getValues());
                $cm = new Application_Model_EuCategorieCompteMapper();
                $cm->save($cat);

                return $this->_helper->redirector('index');
            }
        } else {
            //$mapper = new Application_Model_EuZoneMapper();
            //$zones = $mapper->fetchAll();
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-categorie-compte',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $z = new Application_Model_EuCategorieCompte();
        $mz = new Application_Model_EuCategorieCompteMapper();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit") {
            $z->setCode_cat($this->_request->getPost("code_cat"));
            $z->setLib_cat($this->_request->getPost("lib_cat"));
            $z->setDesc_cat($this->_request->getPost("desc_cat"));
            $z->setCode_type_compte($this->_request->getPost("code_type_compte"));
            $mz->update($z);
        } elseif ($oper == "add") {
            $z->setId_type($this->_request->getPost("code_cat"));
            $z->setLib_type($this->_request->getPost("lib_type"));
            $z->setDesc_cat($this->_request->getPost("desc_cat"));
            $z->setCode_type_compte($this->_request->getPost("code_type_compte"));
            $mz->save($z);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("code_cat");
            $mz->delete($id);
        }
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuCategorieCompte();
        // action body
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $cat = new Application_Model_EuCategorieCompte($form->getValues());
                $cat->setCode_cat($this->getRequest()->code_cat);
                $mapper = new Application_Model_EuCategorieCompteMapper();
                $mapper->update($cat);
                return $this->_helper->redirector('index');
            }
            $code_cat = $this->getRequest()->$code_cat;
            $mapper = new Application_Model_EuCategorieCompteMapper();
            $cat = new Application_Model_EuCategorieCompte();
        } else {
            $code_cat = $request->cat;
            $mapper = new Application_Model_EuCategorieCompteMapper();
            $cat = new Application_Model_EuCategorieCompte();
            $mapper->find($code_cat, $cat);
            if ($cat->getCode_cat() == $code_cat) {
                $data = array(
                    'code_cat' => $code_cat,
                    'lib_cat' => $cat->getLib_cat(),
                    'desc_cat' => $cat->getDesc_cat(),
                    'code_type_compte' => $cat->getCode_type_compte()
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-categorie-compte',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->cat = $cat;
        $this->view->form = $form;
    }

}

?>
