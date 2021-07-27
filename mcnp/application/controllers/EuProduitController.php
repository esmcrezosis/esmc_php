<?php

class EuProduitController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        }else{
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if($group != 'admin'){
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        $menu = "<li><a href=\" /eu-produit/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }
    
    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_produit');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuProduit();
        $select=$tabela->select();
        $produits = $tabela->fetchAll($select);
        $count = count($produits);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $produits = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($produits as $row) {
            $responce['rows'][$i]['id'] = $row->code_produit;
            $responce['rows'][$i]['cell'] = array(
                $row->code_produit,
                $row->libelle_produit,
                $row->description_produit,
                $row->type_produit,
                $row->code_categorie
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function indexAction() {
        // action body
        
    }

    public function newAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuProduit();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $cat = new Application_Model_EuProduit($form->getValues());
                $mapper = new Application_Model_EuProduitMapper();
                $mapper->save($cat);
                return $this->_helper->redirector('index');
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-produit',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        $request = $this->getRequest();
        $form = new Application_Form_EuProduit();
        // action body
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $produit =
                        new Application_Model_EuProduit($form->getValues());
                $produit->setCode_produit($this->getRequest()->code_produit);

                $mapper = new Application_Model_EuProduitMapper();
                $mapper->update($produit);
                return $this->_helper->redirector('index');
            }
            // invalid fields - need old employee to set the name back
            $code_produit = $this->getRequest()->code_produit;
            $mapper = new Application_Model_EuProduitMapper();
            $produit = new Application_Model_EuProduit();
        } else {
            $code_produit = $this->getRequest()->code_produit;
            $mapper = new Application_Model_EuProduitMapper();
            $produit = new Application_Model_EuProduit();
            $mapper->find($code_produit, $produit);
            if ($produit->getCode_produit() == $code_produit) {
                $data = array(
                    'code_produit' => $code_produit,
                    'libelle_produit' => $produit->getLibelle_produit(),
                    'type_produit' => $produit->getType_produit(),
                    'description_produit' => $produit->getDescription_produit(),
                    'code_categorie' => $produit->getCode_categorie()
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
                    'controller' => 'eu-produit',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->produit = $produit;
        $this->view->form = $form;
    }

    public function deleteAction() {
        // action body
        $form = new Application_Form_EuProduit();

        if ($this->getRequest()->isPost()) {
            $mapper = new Application_Model_EuProduitMapper();
            $mapper->delete($this->getRequest()->code_produit);
            return $this->_helper->redirector('index');
        } else {
            // initial rendering of the form, get the employee id
            // from the parameters
            $code_produit = $this->getRequest()->code_produit;
            $mapper = new Application_Model_EuProduitMapper();
            $produit = new Application_Model_EuProduit();
            $mapper->find($code_produit, $produit);
            if ($produit->getCode_produit() == $code_produit) {
                $data = array(
                    'code_produit' => $code_produit,
                    'libelle_produit' => $produit->getLibelle_produit(),
                    'description_produit' => $produit->getDescription_produit(),
                    'type_produit' => $produit->getType_produit(),
                    'code_categorie' => $produit->getCode_categorie()
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
                    'controller' => 'eu-produit',
                    'action' => 'index'), 'default', true) . "','_self')");

        $this->view->form = $form;
    }

}

