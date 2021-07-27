<?php

class EuPartenaireController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        }else{
            $user = $auth->getIdentity();
            $group = $user->usergroup;
            if($group != 'cm'){
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction()
    {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }
    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_partenaire');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuPartenaire();
        $partenaire = $tabela->fetchAll();
        $count = count($partenaire);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $partenaire = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($partenaire as $row) {
            $responce['rows'][$i]['id'] = $row->code_partenaire;
            $responce['rows'][$i]['cell'] = array(
                $row->code_partenaire,
                $row->type_partenaire,
                $row->nom_partenaire,
                $row->tel_partenaire,
                $row->bp_partenaire,
                $row->fax_partenaire,
                $row->email_partenaire,
                $row->interlocuteur,
            );
            $i++;
        }
        $this->view->data = $responce;
    }
 
       public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $z = new Application_Model_EuPartenaire();
        $mz = new Application_Model_EuPartenaireMapper();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit") {
            $z->setCode_partenaire($this->_request->getPost("code_partenaire"));
            $z->setNom_partenaire($this->_request->getPost("nom_partenaire"));
            $z->setType_partenaire($this->_request->getPost("type_partenaire"));
            $z->setTel_partenaire($this->_request->getPost("tel_partenaire"));
            $z->setBp_partenaire($this->_request->getPost("bp_partenaire"));
            $z->setFax_partenaire($this->_request->getPost("fax_partenaire"));
            $z->setEmail_partenaire($this->_request->getPost("email_partenaire"));
            $z->setInterlocuteur($this->_request->getPost("interlocuteur"));
            $mz->update($z);
        } elseif ($oper == "add") {
            $z->setCode_partenaire($this->_request->getPost("code_partenaire"));
            $z->setNom_partenaire($this->_request->getPost("nom_partenaire"));
            $z->setType_partenaire($this->_request->getPost("type_partenaire"));
            $z->setTel_partenaire($this->_request->getPost("tel_partenaire"));
            $z->setBp_partenaire($this->_request->getPost("bp_partenaire"));
            $z->setFax_partenaire($this->_request->getPost("fax_partenaire"));
            $z->setEmail_partenaire($this->_request->getPost("email_partenaire"));
            $z->setInterlocuteur($this->_request->getPost("interlocuteur"));
            $mz->save($z);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("code_partenaire");
            $mz->delete($id);
        }
    }   
    
    public function newAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuPartenaire();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $cat = new Application_Model_EuPartenaire($form->getValues());
                $mapper = new Application_Model_EuPartenaireMapper();
                $mapper->save($cat);
                return $this->_helper->redirector('index');
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-partenaire',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        $request = $this->getRequest();
        $form = new Application_Form_EuPartenaire();
        // action body
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $partenaire =
                        new Application_Model_EuPartenaire($form->getValues());
                $partenaire->setCode_partenaire($this->getRequest()->code_partenaire);

                $mapper = new Application_Model_EuPartenaireMapper();
                $mapper->update($partenaire);
                return $this->_helper->redirector('index');
            }
            // invalid fields - need old employee to set the name back
            $code_partenaire = $this->getRequest()->code_partenaire;
            $mapper = new Application_Model_EuPartenaireMapper();
            $partenaire = new Application_Model_EuPartenaire();
        } else {
            $code_partenaire = $this->getRequest()->code_partenaire;
            $mapper = new Application_Model_EuPartenaireMapper();
            $partenaire = new Application_Model_EuPartenaire();
            $mapper->find($code_partenaire, $partenaire);
            if ($partenaire->getCode_partenaire() == $code_partenaire) {
                $data = array(
                    'code_partenaire' => $code_partenaire,
                    'type_partenaire' => $partenaire->getType_partenaire(),
                    'nom_partenaire' => $partenaire->getNom_partenaire(),
                    'tel_partenaire' => $partenaire->getTel_partenaire(),
                    'bp_partenaire' => $partenaire->getBp_partenaire(),
                    'fax_partenaire' => $partenaire->getFax_partenaire(),
                    'email_partenaire' => $partenaire->getEmail_partenaire(),
                     'interlocuteur' => $partenaire->getInterlocuteur(),
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
                    'controller' => 'eu-partenaire',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->partenaire = $partenaire;
        $this->view->form = $form;
    }

    public

    function deleteAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuPartenaire();

        if ($this->getRequest()->isPost()) {
            $mapper = new Application_Model_EuPartenaireMapper();
            $mapper->delete($request->code_partenaire);
            return $this->_helper->redirector('index');
        } else {
            // initial rendering of the form, get the employee id
            // from the parameters
            $code_partenaire = $request->code_partenaire;
            $mapper = new Application_Model_EuPartenaireMapper();
            $partenaire = new Application_Model_EuPartenaire();
            $mapper->find($code_partenaire, $partenaire);
            if ($partenaire->getCode_partenaire() == $code_partenaire) {
                $data = array(
                    'code_partenaire' => $code_partenaire,
                    'type_partenaire' => $partenaire->getType_partenaire(),
                    'nom_partenaire' => $partenaire->getNom_partenaire(),
                    'tel_partenaire' => $partenaire->getTel_partenaire(),
                    'bp_partenaire' => $partenaire->getBp_partenaire(),
                    'fax_partenaire' => $partenaire->getFax_partenaire(),
                    'email_partenaire' => $partenaire->getEmail_partenaire(),
                     'interlocuteur' => $partenaire->getInterlocuteur()
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
                    'controller' => 'eu-partenaire',
                    'action' => 'index'), 'default', true) . "','_self')");

        $this->view->form = $form;
    }

}

