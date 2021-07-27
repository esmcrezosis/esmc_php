<?php

class EuParametresController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'parametre') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        $menu = "<li><a href=\" /eu-parametres/new \">Nouveau</a></li>
                 <li><a href=\" /eu-parametres/addcredit \">Ajout Credit</a></li>
                 <li><a href=\" /eu-parametres/addprk \">Ajout prk</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_param');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuParametres();
        $select = $tabela->select();
		$param = $tabela->fetchAll($select);
        $count = count($param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $param = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($param as $row) {
            $responce['rows'][$i]['id'] = $row->code_param . $row->lib_param;
            $responce['rows'][$i]['cell'] = array(
                $row->code_param,
                $row->lib_param,
                $row->montant
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function prkAction() {
        
    }

    public function prksAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_prk');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuPrk();
        $select = $tabela->select();
		$param = $tabela->fetchAll($select);
        $count = count($param);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $param = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($param as $row) {
            $responce['rows'][$i]['id'] = $row->id_prk;
            $responce['rows'][$i]['cell'] = array(
                $row->id_prk,
                $row->code_type_credit,
                $row->id_type_acteur,
                $row->valeur
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
        $form = new Application_Form_EuParametres();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $param = new Application_Model_EuParametres($form->getValues());
                $mapper = new Application_Model_EuParametresMapper();
                //Contrôle de l'existence des doublons
                $param_db = new Application_Model_DbTable_EuParametres();
                $param_find = $param_db->find($this->_request->getPost("code_param"), $this->_request->getPost("lib_param"));
                if (count($param_find) == 1) {
                    $message = 'Ce paramètre existe déjà.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                } else {
                    $mapper->save($param);
                    return $this->_helper->redirector('index');
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-parametres',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function addprkAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuPrkForm();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $param = new Application_Model_EuPrk($form->getValues());
                //Contrôle de l'existence des doublons
                $param_db = new Application_Model_DbTable_EuPrk();
                try {
                    $param->setValeur(floatval(str_replace(',', '.', $param->getValeur())));
                    $param_db->insert($param->toArray());
                } catch (Exception $exc) {
                    $this->view->message = $exc->getMessage();
                    $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                            $this->view->url(array(
                                'controller' => 'eu-parametres',
                                'action' => 'index'
                                    ), 'default', true) .
                            "','_self')");

                    $this->view->form = $form;
                    return;
                }
                return $this->_helper->redirector('prk');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-parametres',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function addcreditAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuTypeCredit();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $mt_credit = new Application_Model_EuTypeCredit($form->getValues());
                $tb_credit = new Application_Model_DbTable_EuTypeCredit();
                //Contrôle de l'existence des doublons
                $param_find = $tb_credit->find($this->_request->getPost("code_type_credit"));
                if (count($param_find) == 1) {
                    $message = 'Ce paramètre existe déjà.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                } else {
                    $tb_credit->insert($mt_credit->toArray());
                    return $this->_helper->redirector('index');
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-parametres',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')"
        );

        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuParametres();
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $param = new Application_Model_EuParametres($form->getValues());
                $param->setCode_param($this->getRequest()->code_param);
                $param->setLib_param($this->getRequest()->lib_param);
                $param->setMontant($this->getRequest()->montant);
                $mapper = new Application_Model_EuParametresMapper();
                $mapper->update($param);
                //Mise à jour de la table produit
                $lib = $request->lib_param;
                $code = strtolower($request->code_param);
                $valeur = $request->montant;
                if ($lib == 'nr' || $lib == 'r') {
                    $mprod = new Application_Model_EuProduitMapper();
                    $prod = new Application_Model_EuProduit();
                    $find_prod = $mprod->fetchByType($lib);
                    if ($find_prod != false) {
                        //$res = $find_prod[0];
                        foreach ($find_prod as $res) {
                            $prod->setCode_produit($res->getCode_produit());
                            $prod->setCode_categorie($res->getCode_categorie());
                            $prod->setType_produit($res->getType_produit());
                            $prod->setLibelle_produit($res->getLibelle_produit());
                            $prod->setDescription_produit($res->getDescription_produit());
                            $prod->setPeriode($res->getPeriode());
                            if ($code == 'pck') {
                                $prod->setPck($valeur);
                                $prod->setPrk($res->getPrk());
                            }
                            if ($code == 'prk') {
                                $prod->setPck($res->getPck());
                                $prod->setPrk($valeur);
                            }
                            $mprod->update($prod);
                        }
                    }
                }
                return $this->_helper->redirector('index');
            }
        } else {
            $code_param = $this->getRequest()->code_param;
            $lib_param = $this->getRequest()->lib_param;
            $mapper = new Application_Model_EuParametresMapper();
            $param = new Application_Model_EuParametres();
            $mapper->find($code_param, $lib_param, $param);
            if ($param->getLib_param() == $lib_param) {
                $data = array(
                    'code_param' => $code_param,
                    'lib_param' => $lib_param,
                    'montant' => $param->getMontant(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-parametres',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function deleteAction() {
        // action body
        $form = new Application_Form_EuParametres();

        if ($this->getRequest()->isPost()) {
            $mapper = new Application_Model_EuParametresMapper();
            $mapper->delete($this->getRequest()->code_param);
            return $this->_helper->redirector('index');
        } else {
            // initial rendering of the form, get the employee id
            // from the parameters
            $code_param = $this->getRequest()->code_param;
            $mapper = new Application_Model_EuParametresMapper();
            $param = new Application_Model_EuParametres();
            $mapper->find($code_param, $param);
            if ($param->getCode_param() == $code_param) {
                $data = array(
                    'code_param' => $code_param,
                    'lib_param' => $lib_param,
                    'montant' => $param->getMontant()
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
                    'controller' => 'eu-parametres',
                    'action' => 'index'), 'default', true) . "','_self')");

        $this->view->form = $form;
    }

}