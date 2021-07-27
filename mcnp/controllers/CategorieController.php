<?php

class CategorieController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $menu = "<li><a href=\" /categorie/new \">Nouveau</a></li>";
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
            if ($group != 'agregat' && $group != 'dg') {
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

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_categorie');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_Categorie();
        $cats = $tabela->fetchAll();
        $count = count($cats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $cats = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->code_categorie;
            $responce['rows'][$i]['cell'] = array(
                $row->code_categorie,
                $row->libelle_categorie,
                $row->description_categorie,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $c = new Application_Model_Categorie();
        $mc = new Application_Model_CategorieMapper();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit") {
            $c->setCode_categorie($this->_request->getPost("code_categorie"));
            $c->setLibelle_categorie($this->_request->getPost("libelle_categorie"));
            $c->setDescription_categorie($this->_request->getPost("description_categorie"));
            $mc->update($c);
        } elseif ($oper == "add") {
            $c->setCode_categorie($this->_request->getPost("code_categorie"));
            $c->setLibelle_categorie($this->_request->getPost("libelle_categorie"));
            $c->setDescription_categorie($this->_request->getPost("description_categorie"));
            $mc->save($c);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("code_categorie");
            $mc->delete($id);
        }
    }

    public function newAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_Categorie();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $cat = new Application_Model_Categorie($form->getValues());
                $mapper = new Application_Model_CategorieMapper();
                $mapper->save($cat);
                return $this->_helper->redirector('index');
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'categorie',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        $request = $this->getRequest();
        $form = new Application_Form_Categorie();
        // action body
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $categorie =
                        new Application_Model_Categorie($form->getValues());
                $categorie->setCode_categorie($this->getRequest()->code_categorie);

                $mapper = new Application_Model_CategorieMapper();
                $mapper->update($categorie);
                return $this->_helper->redirector('index');
            }
            // invalid fields - need old employee to set the name back
            $code_categorie = $this->getRequest()->code_categorie;
            $mapper = new Application_Model_CategorieMapper();
            $categorie = new Application_Model_Categorie();
        } else {
            $code_categorie = $this->getRequest()->code_categorie;
            $mapper = new Application_Model_CategorieMapper();
            $categorie = new Application_Model_Categorie();
            $mapper->find($code_categorie, $categorie);
            if ($categorie->getCode_categorie() == $code_categorie) {
                $data = array(
                    'code_categorie' => $code_categorie,
                    'libelle_categorie' => $categorie->getLibelle_categorie(),
                    'description_categorie' => $categorie->getDescription_categorie()
                );
                $form->populate($data);
            } else {
                // redirect to new action if the employee id is invalid
                return $this->_helper->redirector('new');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'categorie',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->categorie = $categorie;
        $this->view->form = $form;
    }

    public function deleteAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_Categorie();

        if ($this->getRequest()->isPost()) {
            $mapper = new Application_Model_CategorieMapper();
            $mapper->delete($this->getRequest()->code_categorie);
            return $this->_helper->redirector('index');
        } else {
            // initial rendering of the form, get the employee id
            // from the parameters
            $code_categorie = $this->getRequest()->id;
            $mapper = new Application_Model_CategorieMapper();
            $categorie = new Application_Model_Categorie();
            $mapper->find($code_categorie, $categorie);
            if ($categorie->getCode_categorie() == $code_categorie) {
                $data = array(
                    'code_categorie' => $code_categorie,
                    'libelle_categorie' => $categorie->getLibelle_categorie(),
                    'description_categorie' => $categorie->getDescription_categorie()
                );
                $form->populate($data);
            } else {
                // redirect to new action if the employee id is invalid
                return $this->_helper->redirector('new');
            }
        }

        // make form read-only
        foreach ($form->getElements() as $formElement) {
            if ($formElement->getAttrib('id') != 'submit-label') {
                $formElement->setAttrib('readonly', 'true');
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'categorie',
                    'action' => 'index'), 'default', true) . "','_self')");

        $this->view->form = $form;
    }

}

