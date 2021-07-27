<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuActeurController
 *
 * @author user
 */
 
 
class EuActeurController extends Zend_Controller_Action {

    //put your code here
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' && $group != 'acteur') {
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
        if ($user->code_groupe == 'admin' || $user->code_groupe == 'acteur') {
            $menu = '<li><a id="new" href="/eu-acteur/new">Nouveau</a></li>
            <li><a id="detail" href="/eu-acteur/index">Listes des acteurs</a></li>';
        }
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_acteur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuActeur();
        $select = $tabela->select();
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
            if ($row->type_acteur == 'P') {
                $type_acteur = 'Physiques';
            } else {
                $type_acteur = 'Morales';
            }
            $t_activite = new Application_Model_DbTable_EuActivite();
            $act = $t_activite->find($row->code_activite);
            $activite = $act->current();
            $responce['rows'][$i]['id'] = $row->id_acteur;
            $responce['rows'][$i]['cell'] = array(
                $row->id_acteur,
                $row->code_membre,
                $row->code_acteur,
                $activite->nom_activite,
                $type_acteur
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function acteursAction() {
        $m_acteurs = new Application_Model_EuActeurCreneauMapper();
        $results = $m_acteurs->fetchAll();
        $data = array();
        $i = 0;
        foreach ($results as $value) {
            $data[$i][0] = $value->getCode_acteur();
            $data[$i][1] = $value->getNom_acteur();
            $i++;
        }
        $this->view->data = $data;
    }

    public function activitesAction() {
        $m_acteurs = new Application_Model_DbTable_EuActivite();
        $results = $m_acteurs->fetchAll();
        $data = array();
        $i = 0;
        for ($i = 0; $i < count($results); $i++) {
            $value = $results[$i];
            $data[$i][0] = $value->code_activite;
            $data[$i][1] = $value->nom_activite;
        }
        $this->view->data = $data;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[0] = strtoupper($result->nom_membre);
            $data[1] = ucfirst($result->prenom_membre);
            $data[2] = ucfirst($result->code_membre);
            if ($result->type_membre == 'M') {
                $data[3] = $result->raison_sociale;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function membresAction() {
        $type = $_GET["type"];
        $m_acteurs = new Application_Model_DbTable_EuMembre();
        $select = $m_acteurs->select();
        $select->where('type_membre like ?', $type);
        $results = $m_acteurs->fetchAll($select);
        $data = array();
        $i = 0;
        for ($i = 0; $i < count($results); $i++) {
            $value = $results[$i];
            $data[$i] = $value->code_membre;
        }
        $this->view->data = $data;
    }

    public function indexAction() {
        //action body
    }

    public function recupacteurAction() {
        $code_acteur = $_GET['code_acteur'];
        $acteur_map = new Application_Model_EuActeurCreneauMapper();
        $acteur = new Application_Model_EuActeurCreneau();
        $ret = $acteur_map->find1($code_acteur, $acteur);
        if ($ret) {
            $data[0] = strtoupper($acteur->getCode_membre());
            $data[1] = ucfirst($acteur->getNom_acteur());
            $data[2] = ucfirst($acteur->getCode_membre_gestionnaire());
            $membre_db = new Application_Model_DbTable_EuMembre();
            $membre_find = $membre_db->find($acteur->getCode_membre());
            if (count($membre_find) == 1) {
                $result = $membre_find->current();
                $data[3] = strtoupper($result->nom_membre);
                $data[4] = ucfirst($result->prenom_membre);
                if ($result->type_membre == 'M') {
                    $data[5] = $result->raison_sociale;
                }
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function newAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $code_acteur = $request->code_acteur;
            $code_membre = $request->membre_act;
            $code_activite = $request->code_activite;
            $type_acteur = $request->type_acteur;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $tab_acteur = new Application_Model_DbTable_EuActeur();
                $select = $tab_acteur->select();
                $select->where('code_membre like ?', $code_membre)
                        ->where('code_activite like ?', $code_activite);
                $acteurs = $tab_acteur->fetchAll($select);
                if (count($acteurs) > 0) {
                    $this->view->message = "Ce membre est déja ajouté dans ce domaine d'activité!!!";
                    return;
                } else {
                    $date_creation = Zend_Date::now();
                    $acteur = new Application_Model_EuActeur();
                    $id_acteur = $acteur->findConuter() + 1;
                    $acteur->setId_acteur($id_acteur)
                            ->setCode_activite($code_activite)
                            ->setCode_membre($code_membre)
                            ->setType_acteur($type_acteur)
                            ->setCode_acteur($code_acteur)
                            ->setDate_creation($date_creation->toString('yyyy-mm-dd'))
                            ->setId_utilisateur($user->id_utilisateur);
                    $tab_acteur->insert($acteur->toArray());
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
