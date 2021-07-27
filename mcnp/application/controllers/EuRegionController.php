<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuRegionController
 *
 * @author user
 */
class EuRegionController extends Zend_Controller_Action {

    //put your code here
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' && $group != 'agregat' && $group != 'gac' && $group != 'gacp' && $group != 'gacse' and $group != 'paraenro') {
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
        $menu = "<li><a href=\" /eu-region/new \">Ajouter region</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    public function indexAction() {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 20);
        $sidx = $this->_request->getParam("sidx", 'id_region');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuRegion();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_pays', 'eu_pays.id_pays = eu_region.id_pays')
               ->order('eu_region.id_region', 'asc');
        $regions = $tabela->fetchAll($select);
        $count = count($regions);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $regions = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($regions as $row) {
            $responce['rows'][$i]['id'] = $row->id_region;
            $responce['rows'][$i]['cell'] = array(
                $row->id_region,
                $row->nom_region,
                $row->libelle_pays
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {
        
    }

    public function newAction() {
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
         $user = $auth->getIdentity();
        $form = new Application_Form_EuRegion();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $region = new Application_Model_EuRegion($form->getValues());
                //Contrôle de l'existence des doublons
                $t_region = new Application_Model_DbTable_EuRegion();
                $c_region=new Application_Model_EuRegion();
                $count = $c_region->findConuter()+1;
                $region->setId_region($count);
                $region->setId_utilisateur($user->id_utilisateur);
                $t_region->insert($region->toArray());
                return $this->_helper->redirector('index');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-rayon',
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
        $form = new Application_Form_EuRegion();
        $mapper = new Application_Model_DbTable_EuRegion();
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $region = new Application_Model_EuRegion($form->getValues());
                    $mapper->update($region->toArray(), array('id_region = ?' => $region->getId_region()));
                    $db->commit();
                    return $this->_helper->redirector('index');
                    $this->view->form = $form;
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        } else {
            $id_region = $request->id_region;
            $rows = $mapper->find($id_region);
            if(count($rows) > 0){
                $row = $rows->current();
                $data = array('id_region' => $row->id_region,'nom_region' => $row->nom_region,'id_pays' => $row->id_pays,'id_utilisateur' => $row->id_utilisateur);
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-region',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

}

?>
