<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuTypeContratController extends Zend_Controller_Action {

    public function preDispatch() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {

        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-type-contrat/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function indexAction() {
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        // action body
    }

    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_type_contrat');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuTypeContrat();
        $select = $tabela->select();
        $contrat = $tabela->fetchAll($select);
        $count = count($contrat);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $contrat = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($contrat as $row) {
            $responce['rows'][$i]['id'] = $row->id_type_contrat;
            $responce['rows'][$i]['cell'] = array(
                $row->id_type_contrat,
                $row->libelle_type_contrat
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {

        $request = $this->getRequest();
        $form = new Application_Form_EuTypeContrat();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $typecontrat = new Application_Model_EuTypeContrat();
                $typecontrat->setLibelle_type_contrat($this->_request->getPost("libelle_type_contrat"));
                $cm = new Application_Model_EuTypeContratMapper();
                $id_type_contrat=$cm->findConuter()+1;
                $typecontrat->setId_type_contrat($id_type_contrat);
                $cm->save($typecontrat);
                return $this->_helper->redirector('index');
            }
        } else {
            //$mapper = new Application_Model_EuZoneMapper();
            //$zones = $mapper->fetchAll();
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-type-contrat',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        //$this->view->zone = $zones;
        $this->view->form = $form;
    }

    public function editAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuTypeContrat();
        $typecontrat = new Application_Model_EuTypeContrat();

        // action body

        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {

                //Mise à jour de la table type_contrat

                $id_type_contrat = $this->_request->getPost("id_type_contrat");
                $libelle_type_contrat = $this->_request->getPost("libelle_type_contrat");

                $typecontrat->setId_type_contrat($id_type_contrat);
                $typecontrat->setLibelle_type_contrat($libelle_type_contrat);

                $mapper = new Application_Model_EuTypeContratMapper();
                $mapper->update($typecontrat);
                return $this->_helper->redirector('index');
            }
        } else {
            $id_type_contrat = $request->id_type_contrat;
            $mapper = new Application_Model_EuTypeContratMapper();
            $mapper->find($id_type_contrat, $typecontrat);
            if ($typecontrat->getId_type_contrat() == $id_type_contrat) {
                $data = array(
                    'id_type_contrat' => $typecontrat->getId_type_contrat(),
                    'libelle_type_contrat' => $typecontrat->getLibelle_type_contrat()
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-type-contrat',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->taxe = $typecontrat;
        $this->view->form = $form;
    }

}

?>
