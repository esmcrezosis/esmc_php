<?php

class EuMdvController extends Zend_Controller_Action {

    function preDispatch() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'acteur' && $group != 'creneau' && $group != 'gac' && $group != 'filiere') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-mdv/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    public function indexAction() {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        //$code_membre = $user->code_membre;
        $gac_filiere = $user->code_gac_filiere;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 1);
        $sidx = $this->_request->getParam("sidx", 'id_mdv');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuMdv();
        $select = $tabela->select();
        $select->from($tabela)
                //->where('code_membre = ?', $code_membre)
                ->where('code_gac_filiere = ?', $gac_filiere);
        $mdv = $tabela->fetchAll($select);
        $count = count($mdv);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $vbps = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($vbps as $row) {
            $responce['rows'][$i]['id'] = $row->id_mdv;
            $responce['rows'][$i]['cell'] = array(
                // $row->id_vbps,
                $row->duree_vie . ' périodes de 30 jours',
                $row->code_membre,
                $row->code_gac_filiere,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $mdv = new Application_Model_EuMdv();
        $mm = new Application_Model_EuMdvMapper();
        $id_utilisateur = $user->id_utilisateur;
        $code_membre = $user->code_membre;
        $gac_filiere = $user->code_gac_filiere;
        $request = $this->getRequest();
        $form = new Application_Form_EuMdv();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $count = $mm->findConuter();
                if ($count == 1) {
                    $message = 'La moyenne des durées de vie pour cette filière est déjà définie.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                } else {
                    if ($this->_request->getPost("unite_mdv") == 'jour') {
                        $duree_vie = $this->_request->getPost("duree_vie") / 30;
                    } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                        $duree_vie = $this->_request->getPost("duree_vie");
                    } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                        $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                    }
                    $mdv->setDuree_vie($duree_vie);
                    $mdv->setCode_gac_filiere($gac_filiere);
                    $mdv->setCode_membre($code_membre);
                    $mm->save($mdv);
                    return $this->_helper->redirector('index');
                }
            }
            // Add the link to the cancel button
            $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                    $this->view->url(array(
                        'controller' => 'eu-mdv',
                        'action' => 'index'
                            ), 'default', true) .
                    "','_self')");
            //$this->view->zone = $zones;
            $this->view->form = $form;
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-mdv',
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
        $form = new Application_Form_EuMdv();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $gac_filiere = $user->code_gac_filiere;
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $mdv = new Application_Model_EuMdv();
                $mm = new Application_Model_EuMdvMapper();

                if ($this->_request->getPost("unite_mdv") == 'jour') {
                    $duree_vie = $this->_request->getPost("duree_vie") / 30;
                } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                    $duree_vie = $this->_request->getPost("duree_vie");
                } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                    $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                }
                $mdv->setId_mdv($this->_request->getPost("id_mdv"));
                $mdv->setDuree_vie($duree_vie);
                $mdv->setCode_gac_filiere($gac_filiere);
                $mdv->setCode_membre($code_membre);
                $mm->update($mdv);
                return $this->_helper->redirector('index');
            }
        } else {
            $id_mdv = $request->id_mdv;
            $mapper = new Application_Model_EuMdvMapper();
            $mdv = new Application_Model_EuMdv();
            $mapper->find($id_mdv, $mdv);
            if ($mdv->getId_mdv() == $id_mdv) {
                $data = array(
                    'id_mdv' => $mdv->getId_mdv(),
                    'duree_vie' => $mdv->getDuree_vie(),
                    'unite_mdv' => 'mois',
                );
                $form->populate($data);
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-mdv',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->gac = $gac;
        $this->view->form = $form;
    }

}

?> 