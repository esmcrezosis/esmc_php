<?php

class EuPaysController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' and $group != 'agregat' and $group != 'gac' and $group != 'acteur_pbf' and $group != 'paraenro') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-pays/newpays \">Ajouer pays</a></li>";
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
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'libelle_pays');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuPays();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_zone', 'eu_zone.code_zone = eu_pays.code_zone')
                ->order('eu_pays.libelle_pays', 'asc');
        $pays = $tabela->fetchAll($select);
        $count = count($pays);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $pays = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($pays as $row) {
            $responce['rows'][$i]['id'] = $row->id_pays;
            $responce['rows'][$i]['cell'] = array(
                $row->id_pays,
                strtoupper($row->code_pays),
                $row->libelle_pays,
                $row->nationalite,
                $row->code_telephonique,
                $row->nom_zone
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function zoneAction() {
        $dev = array();
        $tab = new Application_Model_DbTable_EuZone();
        $sel = $tab->select();
        $sel->order('nom_zone', 'asc');
        $ndev = $tab->fetchAll($sel);
        $i = 0;
        foreach ($ndev as $value) {
            $dev[$i][1] = strtoupper($value->code_zone);
            $dev[$i][2] = ucfirst($value->nom_zone);
            $i++;
        }
        $this->view->data = $dev;
    }

	
	
    public function newpaysAction() {
        if ($this->getRequest()->isPost()) {
            $mpays = new Application_Model_EuPaysMapper();
            $pays = new Application_Model_EuPays();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Contrôle de l'existence des doublons sur le code du pays
                $pays_find = $mpays->findByCodepays($this->_request->getPost("code_pays"));
                if ($pays_find != null) {
                    $this->view->message = 'Ce code pays existe déjà.';
                    $this->view->code_pays = $_POST["code_pays"];
                    $this->view->libelle_pays = $_POST["libelle_pays"];
                    $this->view->nationalite = $_POST["nationalite"];
                    $this->view->code_telephonique = $_POST["code_telephonique"];
                    $this->view->code_zone = $_POST["code_zone"];
                    return;
                } else {
                    //Enregistrement dans la table pays
                    $pays->setCode_pays(strtoupper($_POST["code_pays"]));
                    $pays->setLibelle_pays(ucfirst($_POST["libelle_pays"]));
                    $pays->setNationalite(ucfirst($_POST["nationalite"]));
                    $pays->setCode_telephonique($_POST["code_telephonique"]);
                    $pays->setCode_zone($_POST["code_zone"]);
                    $mpays->save($pays);

                    $db->commit();
                    return $this->_helper->redirector('index');
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->code_pays = $_POST["code_pays"];
                $this->view->libelle_pays = $_POST["libelle_pays"];
                $this->view->nationalite = $_POST["nationalite"];
                $this->view->code_telephonique = $_POST["code_telephonique"];
                $this->view->code_zone = $_POST["code_zone"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
        }
    }

    public function editAction() {
        // action body
        $request = $this->getRequest();
        $mpays = new Application_Model_EuPaysMapper();
        $pays = new Application_Model_EuPays();
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            $pays->setId_pays($_POST["id_pays"]);
            $pays->setCode_pays(strtoupper($_POST["code_pays"]));
            $pays->setLibelle_pays(ucfirst($_POST["libelle_pays"]));
            $pays->setNationalite(ucfirst($_POST["nationalite"]));
            $pays->setCode_telephonique($_POST["code_telephonique"]);
            $pays->setCode_zone($_POST["code_zone"]);
            $mpays->update($pays);
            return $this->_helper->redirector('index');
        } else {
            $this->_helper->layout->disableLayout();
            $id_pays = $request->id_pays;
            $mpays->find($id_pays, $pays);
            $this->view->id_pays = $id_pays;
            $this->view->code_pays = $pays->getCode_pays();
            $this->view->libelle_pays = $pays->getLibelle_pays();
            $this->view->nationalite = $pays->getNationalite();
            $this->view->code_telephonique = $pays->getCode_telephonique();
            $this->view->code_zone = $pays->getCode_zone();
        }
    }

}

