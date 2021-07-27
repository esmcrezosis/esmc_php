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
class EuSectionController extends Zend_Controller_Action {

    //put your code here
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' && $group != 'agregat' && $group != 'gac' && $group != 'gacp' and $group != 'enrolement') {
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
        $menu = "<li><a href=\" /eu-section/new \">Nouveau</a></li>";
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
        $limit = $this->_request->getParam("rows", 200);
        $sidx = $this->_request->getParam("sidx", 'id_section');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSection();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from('eu_section',array('*',"to_char((eu_section.date_creation),'dd/mm/yyyy') date_creation"))
                ->join('eu_pays', 'eu_pays.id_pays = eu_section.id_pays')
                ->order('eu_section.id_section', 'asc');
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
            //$date_creation = new Zend_Date($row->date_creation, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_section;
            $responce['rows'][$i]['cell'] = array(
                $row->id_section,
                $row->nom_section,
                $row->date_creation,
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
        $form = new Application_Form_EuSection();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_creation = clone $date_id;
                $section = new Application_Model_EuSection($form->getValues());
                //Contrôle de l'existence des doublons
                $t_section = new Application_Model_DbTable_EuSection();
                $c_section=new Application_Model_EuSection();
                $count=$c_section->findConuter()+1;
                $section->setId_section($count);
                $section->setId_utilisateur($user->id_utilisateur);
                $section->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                $t_section->insert($section->toArray());
                return $this->_helper->redirector('index');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-section',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuSection();
        $mapper = new Application_Model_DbTable_EuSection();
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $section = new Application_Model_EuSection($form->getValues());
                    $section->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $mapper->update($section->toArray(), array('id_section = ?' => $section->getId_section()));
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
            $id_section = $request->id_section;
            $rows = $mapper->find($id_section);
            if (count($rows) > 0) {
                $row = $rows->current();
                $data = array('id_section' => $row->id_section, 'nom_section' => $row->nom_section, 'id_pays' => $row->id_pays, 'id_utilisateur' => $row->id_utilisateur);
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-section',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

}

?>
