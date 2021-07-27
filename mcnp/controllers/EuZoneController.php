<?php

class EuZoneController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' and $group != 'agregat' and $group != 'acteur_pbf' and $group != 'enrolement' and $group != 'paraenro') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-zone/new \">Ajouter zone</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function indexAction() {
        // action body
    }

    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 20);
        $sidx = $this->_request->getParam("sidx", 'code_zone');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuZone();
        $select = $tabela->select()
                ->from('eu_zone');
        $select->order('eu_zone.code_zone asc');
        $zones = $tabela->fetchAll($select);
        $count = count($zones);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $zones = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($zones as $row) {
		    $datecreation = new Zend_Date($row->date_creation);
            $responce['rows'][$i]['id'] = $row->code_zone;
            $responce['rows'][$i]['cell'] = array(
                $row->code_zone,
                ucfirst($row->nom_zone),
                $row->code_dev,
                $datecreation->toString('dd/MM/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $z = new Application_Model_EuZone();
        $mz = new Application_Model_EuZoneMapper();
        $oper = $this->_request->getPost("oper");
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);

        if ($oper == "edit") {
            $z->setCode_zone($this->_request->getPost("code_zone"));
            $z->setNom_zone($this->_request->getPost("nom_zone"));
            $z->setDate_creation($date_fin->toString('yyyy-mm-dd'));
            $z->setId_utilisateur($user->id_utilisateur);
            $mz->update($z);
        } elseif ($oper == "add") {
            $z->setCode_zone($this->_request->getPost("code_zone"));
            $z->setNom_zone($this->_request->getPost("nom_zone"));
            $z->setDate_creation($date_fin->toString('yyyy-mm-dd'));
            $z->setId_utilisateur($user->id_utilisateur);
            $mz->save($z);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("code_zone");
            $mz->delete($id);
        }
    }

    public function newAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $form = new Application_Form_EuZone();
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $mapper = new Application_Model_EuZoneMapper();
                $cat = new Application_Model_EuZone($form->getValues());
                $cat->setDate_creation($date_fin->toString('yyyy-MM-dd'));
                $cat->setId_utilisateur($user->id_utilisateur);
                //Formation du code de la zone à partir du code pays
                $code = $mapper->getLastCodeZone();
                if ($code == null) {
                    $code_zone = '001';
                } else {
                    $num_ordre = substr($code, -3);
                    $num_ordre++;
                    $code_zone = str_pad($num_ordre, 3, 0, STR_PAD_LEFT);
                }
                $cat->setCode_zone($code_zone);
                $mapper->save($cat);
                return $this->_helper->redirector('index');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-zone',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuZone();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $zone = new Application_Model_EuZone($form->getValues());
                    $zone->setDate_creation($date_creation->toString('yyyy-MM-dd'));
                    $zone->setCode_zone($this->_request->getPost("code_zone"));
                    $zone->setNom_zone($this->_request->getPost("nom_zone"));
                    $zone->setCode_dev($this->_request->getPost("code_dev"));
                    $zone->setId_utilisateur($user->id_utilisateur);
                    $mapper = new Application_Model_EuZoneMapper();
                    $mapper->update($zone);
                    $db->commit();
                    return $this->_helper->redirector('index');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        } else {
            $code_zone = $request->code_zone;
            $mapper = new Application_Model_EuZoneMapper();
            $zone = new Application_Model_EuZone();
            $mapper->find($code_zone, $zone);
            if ($zone->getCode_zone() == $code_zone) {
                $data = array(
                    'code_zone' => $code_zone,
                    'nom_zone' => $zone->getNom_zone(),
                    'date_creation' => $zone->getDate_creation(),
                    'code_dev' => $zone->getCode_dev(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-zone',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

}

