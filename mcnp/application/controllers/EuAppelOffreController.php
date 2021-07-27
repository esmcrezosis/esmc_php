<?php

class EuAppelOffreController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'gac' || $group == 'gacp' || $group == 'gacex' || $group == 'gacsu' || $group == 'gacse' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca' || $group == 'admin' || $group == 'gac_pbf' || $group == 'gacp_pbf' || $group == 'gacex_pbf' || $group == 'gacsu_pbf' || $group == 'gacse_pbf' || $group == 'gacr_pbf' || $group == 'gacs_pbf' || $group == 'gaca_pbf') {
            $menu = "<li><a href=\" /eu-appel-offre/new \">Nouveau</a></li>";
        }
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'gac' && $group != 'gacp' && $group != 'gacex' && $group != 'gacsu' && $group != 'gacse' && $group != 'gacr' && $group != 'gacs' && $group != 'gaca' && $group != 'admin' && $group != 'gac_pbf' && $group != 'gacp_pbf' && $group != 'gacex_pbf' && $group != 'gacsu_pbf' && $group != 'gacse_pbf' && $group != 'gacr_pbf' && $group != 'gacs_pbf' && $group != 'gaca_pbf') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function dataAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_appel_offre');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuAppelOffre();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from('eu_appel_offre', array('*', "to_char((date_creation),'dd/mm/yyyy') date_creation"));
        $fils = $tabela->fetchAll($select);
        $count = count($fils);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $fils = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($fils as $row) {
            $responce['rows'][$i]['id'] = $row->id_appel_offre;
            $responce['rows'][$i]['cell'] = array(
                $row->id_appel_offre,
                ucfirst($row->nom_appel_offre),
                ucfirst($row->descrip_appel_offre),
                $row->date_creation,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $f = new Application_Model_EuAppelOffre();
        $mf = new Application_Model_EuAppelOffreMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $mf->find($this->getRequest()->getPost("id_appel_offre"), $f);
            $f->setNom_appel_offre($this->_request->getPost("nom_appel_offre"));
            $f->setDescrip_appel_offre($this->_request->getPost("descrip_appel_offre"));
            $f->setId_utilisateur($user->id_utilisateur);
            $f->setDate_creation($date_id->toString('yyyy-mm-dd'));
            $mf->update($f);
        } elseif ($oper == "add") {
            $f->setNom_appel_offre($this->_request->getPost("nom_appel_offre"));
            $f->setDescrip_appel_offre($this->_request->getPost("descrip_appel_offre"));
            $f->setId_utilisateur($user->id_utilisateur);
            $f->setDate_creation($date_id->toString('yyyy-mm-dd'));
            $mf->save($f);
        }
    }

    public function newAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $form = new Application_Form_EuAppelOffre();
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $mapper = new Application_Model_EuAppelOffreMapper();
                $cat = new Application_Model_EuAppelOffre($form->getValues());
                $cat->setDate_creation($date_fin->toString('yyyy-mm-dd'));
                $cat->setId_utilisateur($user->id_utilisateur);
                $mapper->save($cat);
                return $this->_helper->redirector('index');
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-appel-offre',
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
        $form = new Application_Form_EuAppelOffre();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $fil = new Application_Model_EuAppelOffre($form->getValues());
                    $fil->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $fil->setId_appel_offre($this->_request->getPost("id_appel_offre"));
                    $fil->setNom_appel_offre($this->_request->getPost("nom_appel_offre"));
                    $fil->setDescrip_appel_offre($this->_request->getPost("descrip_appel_offre"));
                    $fil->setId_utilisateur($user->id_utilisateur);
                    $mapper = new Application_Model_EuAppelOffreMapper();
                    $mapper->update($fil);
                    $db->commit();
                    return $this->_helper->redirector('index');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        } else {
            $id_appel_offre = $request->id_appel_offre;
            $mapper = new Application_Model_EuAppelOffreMapper();
            $fil = new Application_Model_EuAppelOffre();
            $mapper->find($id_appel_offre, $fil);
            if ($fil->getId_appel_offre() == $id_appel_offre) {
                $data = array(
                    'id_appel_offre' => $id_appel_offre,
                    'nom_appel_offre' => $fil->getNom_appel_offre(),
                    'descrip_appel_offre' => $fil->getDescrip_appel_offre(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-appel-offre',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

}

?>
