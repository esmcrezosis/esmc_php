<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuActiviteController
 *
 * @author user
 */
class EuActiviteController extends Zend_Controller_Action {

    //put your code here
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' && $group != 'banque' && $group != 'mise_chaine'  &&  $group != 'filiere') {
               $this->view->user = $user;
               return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($user->code_groupe == 'admin' || $user->code_groupe == 'banque' || $user->code_groupe == 'mise_chaine' ||  $user->code_groupe == 'filiere') {
            $menu = '<li><a id="new" href="/eu-activite/new">Nouveau</a></li>
            <li><a id="detail" href="/eu-activite/index">Listes des activités</a></li>';
        }
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_activite');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuActivite();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from('eu_activite', array('*', "to_char((eu_activite.date_creation),'dd/mm/yyyy') date_creation"));
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($achats as $row) {
            if ($row->id_filiere != '') {
                $fil_map = new Application_Model_EuFiliereMapper();
                $fil = new Application_Model_EuFiliere();
                $ret = $fil_map->find($row->id_filiere, $fil);
                if ($ret) {
                    $nom_filiere = $fil->getNom_filiere();
                } else {
                    $nom_filiere = $row->id_filiere;
                }
            }
            $responce['rows'][$i]['id'] = $row->code_activite;
            $responce['rows'][$i]['cell'] = array(
                $row->code_activite,
                $row->nom_activite,
                $nom_filiere,
                $row->date_creation
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function indexAction() {
//         action body
    }

    public function filiereAction() {
        $m_fil = new Application_Model_EuFiliereMapper();
        $results = $m_fil->fetchAll();
        $data = array();
        $i = 0;
        foreach ($results as $value) {
            $data[$i][0] = $value->getId_filiere();
            $data[$i][1] = $value->getNom_filiere();
            $i++;
        }
        $this->view->data = $data;
    }

    public function newAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $code_activite = $request->code_activite;
            $nom_activite = $request->nom_activite;
            $id_filiere = $request->id_filiere;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $tab_actvite = new Application_Model_DbTable_EuActivite();
                $activite = $tab_actvite->find($code_activite);
                if (count($activite) > 0) {
                    $this->view->message = "Le code d'activité " . $code_activite . " existe déja!!!";
                    return;
                } else {
                    $date_creation = Zend_Date::now();
                    $act = new Application_Model_EuActivite();
                    $act->setCode_activite($code_activite)
                            ->setNom_activite($nom_activite)
                            ->setId_filiere($id_filiere)
                            ->setDate_creation($date_creation->toString('yyyy-mm-dd'))
                            ->setId_utilisateur($user->id_utilisateur);
                    $tab_actvite->insert($act->toArray());
                    $db->commit();
                    return $this->_helper->redirector('index');
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . " :" . $exc->getTraceAsString();
                return;
            }
        }
    }

}

?>
