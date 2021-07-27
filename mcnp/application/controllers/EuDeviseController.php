<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDeviseController
 *
 * @author user
 */
 
 
class EuDeviseController extends Zend_Controller_Action {

    //put your code here
    public function init() {

        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($user->code_groupe == 'banque' || $user->code_groupe == 'agregat') {
            $menu = '<li><a id="dev_consult" href="/eu-devise/index">Devises</a></li>
                     <li><a id="newdev" href="/eu-devise/new">Ajout de devises</a></li>
                     <li><a id="new_cours" href="/eu-devise/cours">Cours</a></li>
                     <li><a id="cours_consult" href="/eu-devise/newcours">Définir un cours</a></li>';
        }
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
            if ($group != 'banque' and $group != 'agregat') {
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
        $sidx = $this->_request->getParam("sidx", 'code_dev');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuDevise();
        $achats = $tabela->fetchAll();
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $achats = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($achats as $row) {
            $responce['rows'][$i]['id'] = $row->code_dev;
            $responce['rows'][$i]['cell'] = array(
                $row->code_dev,
                $row->lib_dev,
                $row->symbole_dev
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $code = $request->code_dev;
            $lib = $request->lib_dev;
            $val_dev = $request->val_dev;
            $val_nat = $request->val_nat;
            $devise = new Application_Model_EuDevise();
            $m_devise = new Application_Model_EuDeviseMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $devise->setCode_dev($code)
                       ->setLib_dev($lib)
                       ->setSymbole_dev($val_dev)
                       ->setZone_dev($val_nat);
                $m_devise->save($devise);
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $e) {
                $db->rollback();
                $this->view->code_dev = $code;
                $this->view->lib_dev = $lib;
                $this->view->val_dev = $val_dev;
                $this->view->val_nat = $val_nat;
                $this->view->message = "Echec de la sauvegarde :" . $e->getMessage();
                return;
            }
        }
    }

    public function coursAction() {
        
    }

    public function cdataAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_cours');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCours();
        $achats = $tabela->fetchAll();
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $achats = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($achats as $row) {
            $responce['rows'][$i]['id'] = $row->code_cours;
            $responce['rows'][$i]['cell'] = array(
                $row->code_cours,
                $row->code_dev_init,
                $row->code_dev_fin,
                $row->val_dev_init,
                $row->val_dev_fin
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newcoursAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $code_dev_init = $request->code_dev_init;
            $code_dev_fin = $request->code_dev_fin;
            $val_dev_init = $request->val_dev_init;
            $val_dev_fin = $request->val_dev_fin;
            $cours = new Application_Model_EuCours();
            $m_cours = new Application_Model_EuCoursMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $cours->setCode_cours($code_dev_init . '-' . $code_dev_fin)
                      ->setCode_dev_init($code_dev_init)
                      ->setCode_dev_fin($code_dev_fin)
                      ->setVal_dev_init($val_dev_init)
                      ->setVal_dev_fin($val_dev_fin);
                $m_cours->save($cours);
                $db->commit();
                return $this->_helper->redirector('cours');
            } catch (Exception $e) {
                $db->rollback();
                $this->view->code_dev_init = $code_dev_init;
                $this->view->code_dev_fin = $code_dev_fin;
                $this->view->val_dev_init = $val_dev_init;
                $this->view->val_dev_fin = $val_dev_fin;
                $this->view->message = "Echec de la sauvegarde :" . $e->getMessage();
                return;
            }
        }
    }

    public function deviseAction() {
        $m_dev = new Application_Model_EuDeviseMapper();
        $results = $m_dev->fetchAll();
        $data = array();
        foreach ($results as $value) {
            $data[] = $value->getCode_dev();
        }
        $this->view->data = $data;
    }

    public function updateAction() {
        $request = $this->getRequest();
        $devise = new Application_Model_EuDevise();
        $m_devise = new Application_Model_EuDeviseMapper();
        $code = $request->code;
        $m_devise->find($code, $devise);
        $this->view->devise = $devise;
        if ($request->isPost()) {
            $code = $request->code_dev;
            $lib = $request->lib_dev;
            $val_dev = $request->val_dev_etr;
            $val_nat = $request->val_dev_nat;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $devise->setCode_dev($code)
                        ->setLib_dev($lib)
                        ->setSymbole_dev($val_dev)
                        ->setZone_dev($val_nat);
                $m_devise->update($devise);
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $e) {
                $db->rollback();
                $this->view->code_dev = $code;
                $this->view->lib_dev = $lib;
                $this->view->val_dev = $val_dev;
                $this->view->val_nat = $val_nat;
                $this->view->message = "Echec de la sauvegarde :" . $e->getMessage();
                return;
            }
        }
    }

    public function cupdateAction() {
        $request = $this->getRequest();
        $cours = new Application_Model_EuCours();
        $m_cours = new Application_Model_EuCoursMapper();
        $code_cours = $request->code;
        $m_cours->find($code_cours, $cours);
        $this->view->cours = $cours;
        if ($request->isPost()) {
            $code_dev_init = $request->code_dev_init;
            $code_dev_fin = $request->code_dev_fin;
            $val_dev_init = $request->val_dev_init;
            $val_dev_fin = $request->val_dev_fin;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $cours->setCode_cours($code_dev_init . '-' . $code_dev_fin)
                        ->setCode_dev_init($code_dev_init)
                        ->setCode_dev_fin($code_dev_fin)
                        ->setVal_dev_init($val_dev_init)
                        ->setVal_dev_fin($val_dev_fin);
                $m_cours->update($cours);
                $db->commit();
                //return $this->view->message = $code_dev_init . '-' . $code_dev_fin;
                return $this->_helper->redirector('cours');
            } catch (Exception $e) {
                $db->rollback();
                $this->view->code_dev_init = $code_dev_init;
                $this->view->code_dev_fin = $code_dev_fin;
                $this->view->val_dev_init = $val_dev_init;
                $this->view->val_dev_fin = $val_dev_fin;
                $this->view->message = "Echec de la sauvegarde : " . $e->getMessage();
                return;
            }
        }
    }

}

?>
