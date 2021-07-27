<?php
class EuBesoinController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $menu = "<li><a id=\"new\" href=\"/eu-besoin/new\">Nouveau</a></li>" .
                "<li><a id=\"new\" href=\"/eu-besoin/listbesoin\">Mes besoins</a></li>";
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
            if ($group != 'filiere' && $group != 'gac' && $group != 'gacp' && $group != 'gacse' && $group != 'gacr' && $group != 'gacs' && $group != 'gaca' && $group != 'creneau' && $group != 'acteur' &&
                    $group != 'filiere_pbf' && $group != 'gac_pbf' && $group != 'gacp_pbf' && $group != 'gacse_pbf' && $group != 'gacr_pbf' && $group != 'gacs_pbf' && $group != 'gaca_pbf' && $group != 'creneau_pbf' && $group != 'acteur_pbf' && $group != 'acnev') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            } 
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        if (isset($_POST["besoin"])) {
            $besoin = $_POST['besoin'];
            $this->view->besoin = $besoin;
        }
        if (isset($_POST["date"]))
            if ($_POST["date"] != '') {
                $date_besoin = $_POST['date'];
                $date1 = explode("/", $date_besoin);
                $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $this->view->date_besoin = $dated;
            }
    }

	
    public function listbesoinAction() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        if (isset($_POST["besoin"])) {
            $besoin = $_POST['besoin'];
            $this->view->besoin = $besoin;
        }
        if (isset($_POST["date"]))
            if ($_POST["date"] != '') {
                $date_besoin = $_POST['date'];
                $date1 = explode("/", $date_besoin);
                $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $this->view->date_besoin = $dated;
            }
    }

	
    public function listbAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        if (isset($_GET["besoin"]))
            $besoin = $_GET["besoin"];
        if (isset($_GET["date_besoin"]))
            $date_besoin = $_GET["date_besoin"];
        if ($code_membre != '') {
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'id_besoin');
            $sord = $this->_request->getParam("sord", 'asc');
            $tabela = new Application_Model_DbTable_EuBesoin();
            if ($besoin != "" && $date_besoin != "") {
                $select = $tabela->select();
                $select->from($tabela)
                        ->where('eu_besoin.code_membre <> ?', $code_membre)
                        ->where('eu_besoin.objet_besoin = ?', $besoin)
                        ->where('eu_besoin.date_besoin = ?', $date_besoin);
            } else if ($besoin != "") {
                $select = $tabela->select();
                $select->from($tabela)
                        ->where('eu_besoin.code_membre = ?', $code_membre)
                        ->where('eu_besoin.objet_besoin = ?', $besoin);
            } else if ($date_besoin != "") {
                $select = $tabela->select();
                $select->from($tabela)
                        ->where('eu_besoin.code_membre = ?', $code_membre)
                        ->where('eu_besoin.date_besoin = ?', $date_besoin);
            } else {
                $select = $tabela->select();
                $select->from($tabela)
                        ->where('eu_besoin.code_membre = ?', $code_membre)
                        ->order('eu_besoin.id_besoin desc');
            }
            $besoin = $tabela->fetchAll($select);
            $count = count($besoin);

            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }

            if ($page > $total_pages)
                $page = $total_pages;

            $besoin = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;

            foreach ($besoin as $row) {
                $date_valide = new Zend_Date($row->date_valide, Zend_Date::ISO_8601);
                $date_besoin = new Zend_Date($row->date_besoin, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->id_besoin;
                $responce['rows'][$i]['cell'] = array(
                    $row->id_besoin,
                    $row->objet_besoin,
                    $date_valide->toString('dd/mm/yyyy'),
                    $date_besoin->toString('dd/mm/yyyy'),
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function mdetailAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_objet');
        $sord = $this->_request->getParam("sord", 'asc');
        $id_besoin = $this->getRequest()->besoin;
        $tabela = new Application_Model_DbTable_EuConcerner();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_besoin', 'eu_besoin.id_besoin = eu_concerner.id_besoin')
                ->join('eu_objet', 'eu_objet.id_objet = eu_concerner.id_objet')
                ->where('eu_besoin.id_besoin = ?', $id_besoin);
        $alloc = $tabela->fetchAll($select);
        $count = count($alloc);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $alloc = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($alloc as $row) {
            $responce['rows'][$i]['id'] = $row->id_objet;
            $responce['rows'][$i]['cell'] = array(
                $row->unite_mesure,
                $row->design_objet,
                $row->qte_objet,
                $row->type
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function mhdetailAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_objet_hors');
        $sord = $this->_request->getParam("sord", 'asc');
        $id_besoin = $this->getRequest()->besoin;

        $tabela = new Application_Model_DbTable_EuObjetHors();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_besoin', 'eu_besoin.id_besoin = eu_objet_hors.id_besoin')
                ->where('eu_besoin.id_besoin = ?', $id_besoin);
        $alloc = $tabela->fetchAll($select);
        $count = count($alloc);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $alloc = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($alloc as $row) {
            $responce['rows'][$i]['id'] = $row->id_objet_hors;
            $responce['rows'][$i]['cell'] = array(
                $row->design_objet_hors,
                $row->qte_objet_hors
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
		$date = new Zend_Date(Zend_Date::ISO_8601);
        if (isset($_GET["besoin"]))
            $besoin = $_GET["besoin"];
        if (isset($_GET["date_besoin"]))
            $date_besoin = $_GET["date_besoin"];
        if ($code_membre != '') {
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'id_besoin');
           $sord = $this->_request->getParam("sord", 'asc');
           $tabela = new Application_Model_DbTable_EuBesoin();
           if ($besoin != "" && $date_besoin != "") {
               $select = $tabela->select();
               $select->from($tabela)
                      ->where('eu_besoin.code_membre <> ?', $code_membre)
                      ->where('eu_besoin.objet_besoin = ?', $besoin)
                      ->where('eu_besoin.date_besoin = ?', $date_besoin)
		      ->where('eu_besoin.date_valide >= ?', $date->toString('yyyy/mm/dd'));
            } else if ($besoin != "") {
               $select = $tabela->select();
               $select->from($tabela)
                      ->where('eu_besoin.code_membre <> ?', $code_membre)
                      ->where('eu_besoin.objet_besoin = ?', $besoin)
		      ->where('eu_besoin.date_valide >= ?', $date->toString('yyyy/mm/dd'));
            } else if ($date_besoin != "") {
                $select = $tabela->select();
                $select->from($tabela)
                       ->where('eu_besoin.code_membre <> ?', $code_membre)
		       ->where('eu_besoin.date_valide >= ?', $date->toString('yyyy/mm/dd'))
                       ->where('eu_besoin.date_besoin = ?', $date_besoin);
            } 
			else {
                 $select = $tabela->select();
                 $select->from($tabela)
                        ->where('eu_besoin.code_membre <> ?', $code_membre)
			            ->where('eu_besoin.date_valide >= ?', $date->toString('yyyy/mm/dd'))
                        ->order('eu_besoin.id_besoin desc');
            }
            $besoin = $tabela->fetchAll($select);
            $count = count($besoin);

            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }
            if ($page > $total_pages)
                $page = $total_pages;

            $besoin = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;

            foreach ($besoin as $row) {
                $date_valide = new Zend_Date($row->date_valide, Zend_Date::ISO_8601);
                $date_besoin = new Zend_Date($row->DATE_besoin, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->id_besoin;
                $responce['rows'][$i]['cell'] = array(
                    $row->id_besoin,
                    $row->objet_besoin,
                    $date_valide->toString('dd/mm/yyyy'),
                    $row->code_membre,
                    $date_besoin->toString('dd/mm/yyyy'),
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function changeAction() {
        $data = array();
        $objet = new Application_Model_DbTable_EuObjet();
        $select = $objet->select();
        $result = $objet->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->design_objet;
        }
        $this->view->data = $data;
    }

    public function foundAction() {

        $data = array();
        $besoin = new Application_Model_DbTable_EuBesoin();
        $select = $besoin->select();
        $select->from($besoin, array('objet_besoin'));
        $select->order('objet_besoin asc');
        $result = $besoin->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->objet_besoin;
        }
        $this->view->data = $data;
    }

    public function modifobjethorsAction() {

        $this->_helper->layout->disableLayout();
        $id_objet = $this->getRequest()->objet;
        $form = new Application_Form_EuObjetHors();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_membre = $user->code_membre;
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($this->getRequest()->getPost())) {
                $prix = new Application_Model_EuPrix();
                $objet = new Application_Model_EuObjet();
                $om = new Application_Model_EuObjetMapper();
                $pm = new Application_Model_EuPrixMapper();
                $concerner = new Application_Model_EuConcerner();
                $mc = new Application_Model_EuConcernerMapper();
                // $objethors = new Application_Model_EuObjetHors();
                $ohm = new Application_Model_EuObjetHorsMapper();
                $objet_find = $om->findobjet($this->_request->getPost("design_objet_hors"));
                if (count($objet_find) < 1) {
                    $count = $om->findConuter();
                    $nb = $count + 1;
                    $code_objet = $nb . strtoupper(substr($this->_request->getPost("design_objet"), 0, 3)) . 'gp';
                    $objet->setCode_objet($code_objet);
                    $objet->setDesign_objet($this->_request->getPost("design_objet_hors"));
                    $om->save($objet);
                    $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                    $prix->setDuree_vie($this->_request->getPost("duree_vie"));
                    $prix->setCode_objet($code_objet);
                    if (($this->_request->getPost("code_rayon"))) {
                        $boutique = $om->findbout($this->_request->getPost("code_rayon"));
                        $membre = $pm->findbout($this->_request->getPost("code_rayon"));
                        $prix->setRayon($this->_request->getPost("code_rayon"));
                        $prix->setBoutique($boutique);
                        $prix->setMembre_rayon($membre);
                    } else if (($this->_request->getPost("code_bout"))) {
                        $prix->setRayon(null);
                        $prix->setBoutique($this->_request->getPost("code_bout"));
                        $prix->setMembre_rayon('');
                    }

                    $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                    $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                    $prix->setCreer_par($num_membre);
                    $pm->save($prix);
                    $concerner->setId_besoin($this->_request->getPost("id_besoin"));
                    $concerner->setCode_objet($code_objet);
                    $concerner->setQte_objet($this->_request->getPost("qte_objet_hors"));
                    $concerner->setType("nouveau");
                    $mc->save($concerner);
                    $ohm->delete($this->_request->getPost("id_objet_hors"));
                    return $this->_helper->redirector('index');
                } else {
                    $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                    $prix->setDuree_vie($this->_request->getPost("duree_vie"));
                    $prix->setCode_objet($objet_find);
                    if (($this->_request->getPost("code_rayon"))) {
                        $boutique = $om->findbout($this->_request->getPost("code_rayon"));
                        $membre = $pm->findbout($this->_request->getPost("code_rayon"));
                        $prix->setRayon($this->_request->getPost("code_rayon"));
                        $prix->setBoutique($boutique);
                        $prix->setMembre_rayon($membre);
                    } else if (($this->_request->getPost("code_bout"))) {
                        $prix->setRayon(null);
                        $prix->setBoutique($this->_request->getPost("code_bout"));
                        $prix->setMembre_rayon('');
                    }

                    $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                    $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                    $prix->setCreer_par($num_membre);
                    $pm->save($prix);
                    $concerner->setId_besoin($this->_request->getPost("id_besoin"));
                    $concerner->setCode_objet($objet_find);
                    $concerner->setQte_objet($this->_request->getPost("qte_objet_hors"));
                    $concerner->setType("nouveau");
                    $mc->save($concerner);
                    $ohm->delete($this->_request->getPost("id_objet_hors"));
                    return $this->_helper->redirector('index');
                }
            }
        } else {
            $objet = new Application_Model_EuObjetHors();
            $mapper = new Application_Model_EuObjetHorsMapper();
            $mapper->find($id_objet, $objet);
            if ($objet->getId_objet_hors() == $id_objet) {
                $data = array(
                    'id_objet_hors' => $objet->getId_objet_hors(),
                    'design_objet_hors' => $objet->getDesign_objet_hors(),
                    'qte_objet_hors' => $objet->getQte_objet_hors(),
                    'id_besoin' => $objet->getId_besoin()
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-besoin',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->objet = $objet;
        $this->view->form = $form;
    }

    public function newAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        if ($this->getRequest()->isPost()) {

            // if ($form->isValid($request->getPost()))
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $besoin = new Application_Model_EuBesoin();

                if (isset($_POST["compteur"])) {

                    $date1 = explode("-", $_POST["date_valide"]);
                    $date_valide = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                    $compteur = $_POST["compteur"];
                    $besoin->setObjet_besoin($_POST["lib_besoin"]);
                    $besoin->setDate_valide($date_valide);
                    $besoin->setDate_besoin($date_idd->toString('yyyy-mm-dd'));
                    $besoin->setCode_membre($code_membre);
                    $besoin->setDisponible(0);

                    //insertion dans la table besoin des informations 

                    $mapper = new Application_Model_EuBesoinMapper();
                    $mapper->save($besoin);
                    $objet = new Application_Model_EuObjet();
                    $mo = new Application_Model_EuObjetMapper();

                    $concerner = new Application_Model_EuConcerner();
                    $mc = new Application_Model_EuConcernerMapper();
                    for ($i = 0; $i < $compteur; $i++) {
                        $design_objet = $_POST["objet_besoin$i"];
                        $unite_mesure = $_POST["unite$i"];
                        $objet_find = $mo->findobjet($design_objet, $unite_mesure);
                        if (count($objet_find) < 1) {
                            //insertion dans la table objet
                            $objet->setDesign_objet($design_objet);
                            $objet->setUnite_mesure($unite_mesure);
                            $mo->save($objet);
                            //insertion dans la table concerner des informations 
                            $count = $mapper->findConuter();
                            $row = $mo->findMax();
                            // $concerner_db = new Application_Model_DbTable_EuConcerner();
                            // $concerner_find = $concerner_db->find($count,$row);
                            // if (count($concerner_find) == 1) {
                            //      $this->view->message = "Même designation du produit a été saisi plusieurs fois";
                            //     return;
                            // }
                            // else  
                            if (strlen($_POST["qte_objet$i"] != 0) && strlen($_POST["objet_besoin$i"]) != 0) {
                                $concerner->setId_objet($row);
                                $concerner->setId_besoin($count);
                                $concerner->setQte_objet($_POST["qte_objet$i"]);
                                $concerner->setType($_POST["cat_objet$i"]);
                                $mc->save($concerner);
                            }
                        } else {
                            $count = $mapper->findConuter();
                            if (strlen($_POST["qte_objet$i"] != 0) && strlen($_POST["objet_besoin$i"]) != 0) {
                                $concerner->setId_objet($objet_find);
                                $concerner->setId_besoin($count);
                                $concerner->setQte_objet($_POST["qte_objet$i"]);
                                $concerner->setType($_POST["cat_objet$i"]);
                                $mc->save($concerner);
                            }
                        }
                    }
                    $db->commit();
                    return $this->_helper->redirector('listbesoin');
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Impossible d\'enrégistrer les données';
                //$message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
    }

    public function editAction() {

        // action body

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $id_utilisateur = $user->id_utilisateur;
        $code_membre = $user->code_membre;
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        // action body

        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {

                $objet = new Application_Model_EuObjet();
                $mo = new Application_Model_EuObjetMapper();
                $concerner = new Application_Model_EuConcerner();
                $mc = new Application_Model_EuConcernerMapper();
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $besoin = new Application_Model_EuBesoin();

                $date1 = explode("-", $_POST["date_valide"]);
                $date_valide = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

                $besoin->setId_besoin($_POST["id_besoin"]);
                $besoin->setDate_valide($date_valide);
                $besoin->setObjet_besoin($_POST["lib_besoin"]);
                $besoin->setDate_besoin($date_idd->toString('yyyy-mm-dd'));
                $besoin->setCode_membre($code_membre);
                $besoin->setDisponible(0);

                //Mise à jour de la table besoin
                $mb = new Application_Model_EuBesoinMapper();
                $mb->update($besoin);
                if (isset($_POST["compteur"])) {
                    $compteur = $_POST['compteur'];
                    for ($i = 0; $i < $compteur; $i++) {
                        $design_objet = $_POST["designs$i"];
                        $unite_mesure = $_POST["unite$i"];
                        $code = $_POST["code$i"];
                        $qte = $_POST["qtes$i"];
                        $cat = $_POST["cat_objet$i"];

                        if (strlen($_POST["designs$i"]) != 0)
                            $objet_find = $mo->findobjet($design_objet, $unite_mesure);
                        if (count($objet_find) < 1) {
                            //insertion dans la table objet
                            $objet->setDesign_objet($design_objet);
                            $objet->setUnite_mesure($unite_mesure);
                            $mo->save($objet);
                            //insertion dans la table concerner des informations
                            $mapper = new Application_Model_EuBesoinMapper();
                            $count = $mapper->findConuter();
                            $row = $mo->findMax();
                            $concerner->setId_besoin($count);
                            $concerner->setId_objet($row);
                            $concerner->setQte_objet($_POST["qte_objet$i"]);
                            $concerner->setType($_POST["cat_objet$i"]);
                            $mc->delete($_POST['id_besoin'], $code);
                            $mc->save($concerner);
                        } else {
                            if (strlen($_POST["qtes$i"] != 0) && strlen($_POST["designs$i"]) != 0) {
                                $concerner->setId_besoin($_POST['id_besoin']);
                                $concerner->setId_objet($objet_find);
                                $concerner->setQte_objet($qte);
                                $concerner->setType($cat);
                                $mc->delete($_POST['id_besoin'], $code);
                                $mc->save($concerner);
                            }
                        }
                    }
                }
                $db->commit();
                return $this->_helper->redirector('listbesoin');
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Un produit a été exprimé plusieurs fois';
                // $message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        } else {
            $id_besoin = $request->besoin;
            $tabela = new Application_Model_DbTable_EuConcerner();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join('eu_besoin', 'eu_besoin.id_besoin = eu_concerner.id_besoin')
                    ->join('eu_objet', 'eu_objet.id_objet = eu_concerner.id_objet')
                    ->where('eu_besoin.id_besoin = ?', $id_besoin);
            $alloc = $tabela->fetchAll($select);
            $tab = array(array());
            $i = 0;
            foreach ($alloc as $row) {

                $date1 = explode("-", $row->date_valide);
                $date_valide = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $tab[$i][0] = $row->id_objet;
                $tab[$i][1] = $row->design_objet;
                $tab[$i][2] = $row->unite_mesure;
                $tab[$i][3] = $row->qte_objet;
                $tab[$i][4] = $row->id_besoin;
                $tab[$i][5] = $date_valide;
                $tab[$i][6] = $row->code_membre;
                $tab[$i][7] = $row->objet_besoin;
                $tab[$i][8] = $row->type;
                $i++;
            }
            $this->view->data = $tab;
        }
    }

}

