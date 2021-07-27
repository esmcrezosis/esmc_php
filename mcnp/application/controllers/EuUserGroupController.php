<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuUserGroupController
 *
 * @author user
 */
class EuUserGroupController extends Zend_Controller_Action{
    //put your code here
    //put your code here
    public function init() {
        $menu = '<li><a id="newgroup" href="/eu-user-group/new">Nouveau</a></li>';
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
            if ($group != 'admin') {
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
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_groupe');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuUserGroup();
        $select=$tabela->select();
        $krrs = $tabela->fetchAll($select);
        $count = count($krrs);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $krrs = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($krrs as $row) {
            $responce['rows'][$i]['id'] = $row->code_groupe;
            $responce['rows'][$i]['cell'] = array(
                $row->code_groupe,
                $row->libelle_groupe
            );
            $i++;
        }
        $this->view->data = $responce;
    }
    
    public function newAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuUserGroup();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $groupe = new Application_Model_EuUserGroup($form->getValues());
                //Contrôle de l'existence des doublons
                $tgroupe = new Application_Model_DbTable_EuUserGroup();
                $c_find = $tgroupe->find($groupe->getCode_groupe());
                if (count($c_find) == 1) {
                    $message = 'Ce groupe existe déjà.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                } else {
                    $mapper = new Application_Model_EuUserGroupMapper();
                    $mapper->save($groupe);
                    return $this->_helper->redirector('index');
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-user-group',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuUserGroup();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $groupe = new Application_Model_EuUserGroup($form->getValues());
                    $mapper = new Application_Model_EuUserGroupMapper();
                    $mapper->update($groupe);
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
            $code_groupe = $request->code_groupe;
            $mapper = new Application_Model_EuUserGroupMapper();
            $groupe = new Application_Model_EuUserGroup();
            $mapper->find($code_groupe, $groupe);
            if ($groupe->getCode_groupe() == $code_groupe) {
                $data = array(
                    'code_groupe' => $groupe->getCode_groupe(),
                    'libelle_groupe' => $groupe->getLibelle_groupe()
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-user-group',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

}

?>
