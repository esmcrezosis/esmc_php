<?php

class EuProformaController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"new\" href=\"/eu-proforma/new\">Proforma circulant</a></li>" .
                "<li><a id=\"new\" href=\"/eu-proforma/newf\">Proforma fixe</a></li>" .
                "<li><a id=\"list\" href=\"/eu-proforma/list\">Consulter</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'filiere' && $group != 'gac' && $group != 'gacp' && $group != 'gacse' && $group != 'gacr' && $group != 'gacs' && $group != 'gaca' && $group != 'creneau' && $group != 'acteur' && 
                    $group != 'filiere_pbf' && $group != 'gac_pbf' && $group != 'gacp_pbf' && $group != 'gacse_pbf' && $group != 'gacr_pbf' && $group != 'gacs_pbf' && $group != 'gaca_pbf' && $group != 'creneau_pbf' && $group != 'acteur_pbf') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            } 
            $this->view->user = $user;
        }
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

    public function taxeAction() {
        $tab = array(array());
        $taxe = new Application_Model_DbTable_EuTaxe();
        $select = $taxe->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_pays', 'eu_pays.id_pays = eu_taxe.id_pays');
        $result = $taxe->fetchAll($select);
        $i = 0;
        foreach ($result as $value) {
            $tab[$i][1] = $value->id_taxe;
            $tab[$i][2] = ucfirst($value->libelle_taxe);
            $tab[$i][3] = ucfirst($value->libelle_pays);
            $i++;
        }
        $this->view->data = $tab;
    }

    public function controleAction() {

        $request = $this->getRequest();
        $num_pforma = $request->num_pforma;
        $proforma = new Application_Model_DbTable_EuProforma;
        $select = $proforma->select();
        $select->from($proforma, array('num_pforma'));
        $select->where('num_pforma = ?', $num_pforma);
        $result = $proforma->fetchAll($select);
        $row = $result->current();
        $this->view->data = $row['num_pforma'];
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

        if (isset($_POST["type_pro"])) {
            $type_pro = $_POST['type_pro'];
            $this->view->type_pro = $type_pro;
        }

        if (isset($_POST["date_proforma"]))
            if ($_POST["date_proforma"] != '') {
                $date_proforma = $_POST['date_proforma'];
                $date1 = explode("/", $date_proforma);
                $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $this->view->date_proforma = $dated;
            }
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $id_utilisateur = $user->id_utilisateur;
        if (isset($_GET["besoin"]))
            $besoin = $_GET["besoin"];
        if (isset($_GET["date_proforma"]))
            $date_proforma = $_GET["date_proforma"];
        if (isset($_GET["type_pro"]))
            $type_pro = $_GET["type_pro"];
        if ($code_membre != '') {
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'code_proforma');
            $sord = $this->_request->getParam("sord", 'asc');
            $tabela = new Application_Model_DbTable_EuProforma();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            if ($besoin != "" && $date_proforma != "" && $type_pro != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                        ->where('eu_proforma.date_proforma = ?', $date_proforma)
                        ->where('eu_proforma.type_proforma = ?', $type_pro)
                        ->where('eu_besoin.objet_besoin = ?', $besoin)
                        ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
            } elseif ($besoin != "" && $date_proforma != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                        ->where('eu_proforma.date_proforma = ?', $date_proforma)
                        ->where('eu_besoin.objet_besoin = ?', $besoin)
                        ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
            } elseif ($besoin != "" && $type_pro != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                        ->where('eu_proforma.type_proforma = ?', $type_pro)
                        ->where('eu_besoin.objet_besoin = ?', $besoin)
                        ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
            } elseif ($date_proforma != "" && $type_pro != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                        ->where('eu_proforma.date_proforma = ?', $date_proforma)
                        ->where('eu_proforma.type_proforma = ?', $type_pro)
                        ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
            } elseif ($besoin != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                        ->where('eu_besoin.objet_besoin = ?', $besoin)
                        ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
            } elseif ($date_proforma != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                        ->where('eu_proforma.date_proforma = ?', $date_proforma)
                        ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
            } elseif ($type_pro != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                        ->where('eu_proforma.type_proforma = ?', $type_pro)
                        ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
            } else {
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                        ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
            }
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
                if ($row->id_taxe != null) {
                    $taxe = new Application_Model_DbTable_EuTaxe();
                    $sel = $taxe->select();
                    $sel->from($taxe);
                    $sel->where('id_taxe = ?', $row->id_taxe);
                    $result = $taxe->fetchAll($sel);
                    $rep = $result->current();
                    $montant_net = (($rep['taux_taxe'] * $row->montant_ht) / 100) + $row->montant_ht;
                }
                else
                    $montant_net = $row->montant_ht;

                $date_proforma = new Zend_Date($row->date_proforma, Zend_Date::ISO_8601);
                $date_livre = new Zend_Date($row->date_livre, Zend_Date::ISO_8601);
                $date_paie = new Zend_Date($row->date_paie, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_proforma;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_proforma,
                    $row->objet_besoin,
                    $date_proforma->toString('dd/mm/yyyy'),
                    $date_livre->toString('dd/mm/yyyy'),
                    $date_paie->toString('dd/mm/yyyy'),
                    $row->montant_ht,
                    $montant_net,
                    $row->type_proforma
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function listAction() {
         $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
		if(isset($code_membre)){
        $form = new Application_Form_EuCommande();
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-proforma',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
		}
    }

    public function listpformaAction() {

        if (isset($_GET["id_besoin"])) {
            $id_besoin = $_GET["id_besoin"];
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'code_proforma');
            $sord = $this->_request->getParam("sord", 'asc');
            $tabela = new Application_Model_DbTable_EuProforma();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join('eu_besoin', 'eu_besoin.id_besoin = eu_proforma.id_besoin')
                    ->where('eu_besoin.id_besoin = ?', $id_besoin);
            ;
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


                if ($row->id_taxe != null) {
                    $taxe = new Application_Model_DbTable_EuTaxe();
                    $sel = $taxe->select();
                    $sel->from($taxe);
                    $sel->where('id_taxe = ?', $row->id_taxe);
                    $result = $taxe->fetchAll($sel);
                    $rep = $result->current();
                    $montant_net = (($rep['taux_taxe'] * $row->montant_ht) / 100) + $row->montant_ht;
                }
                else
                    $montant_net = $row->montant_ht;

                $date_proforma = new Zend_Date($row->date_proforma, Zend_Date::ISO_8601);
                $date_livre = new Zend_Date($row->date_livre, Zend_Date::ISO_8601);
                $date_paie = new Zend_Date($row->date_paie, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_proforma;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_proforma,
                    $row->code_membre_fournisseur,
                    $date_proforma->toString('dd/mm/yyyy'),
                    $date_livre->toString('dd/mm/yyyy'),
                    $date_paie->toString('dd/mm/yyyy'),
                    $row->montant_ht,
                    $montant_net,
                    $row->lieu_livre,
                    $row->type_proforma
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
        $sidx = $this->_request->getParam("sidx", 'id_porter');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_proforma = $this->getRequest()->code_proforma;
        $tabela = new Application_Model_DbTable_EuPorter();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_proforma', 'eu_proforma.code_proforma = eu_porter.code_proforma')
                ->join('eu_objet', 'eu_objet.id_objet = eu_porter.id_objet')
                ->where('eu_proforma.code_proforma = ?', $code_proforma);
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
            $responce['rows'][$i]['id'] = $row->id_porter;
            $responce['rows'][$i]['cell'] = array(
                $row->unite_mesure,
                $row->design_objet,
                $row->qte_objet,
                $row->pu_objet,
                $row->remise,
                $row->mdv
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function envoifixeAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $id_utilisateur = $user->id_utilisateur;
        if ($this->getRequest()->isPost()) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //$date = new Zend_Date();
                //$date_p = clone $date;
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $proforma = new Application_Model_EuProforma();
                $thtva = 0;
                $remise = 0;
                $date1 = explode("-", $_POST["delai_valid"]);
                $date2 = explode("-", $_POST["date_livre"]);
                $date3 = explode("-", $_POST["date_paie"]);
                $taxe = $_POST["taxe"];

                $date_valid = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $date_livre = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                $date_paie = $date3[2] . '-' . $date3[1] . '-' . $date3[0];

                $code_proforma = 'pf' . $date_idd->tostring('yyMMddHHmmss');

                $proforma->setCode_proforma($code_proforma);
                $proforma->setDate_proforma($date_idd->toString('yyyy-mm-dd'));
                $proforma->setDate_livre($date_livre);
                $proforma->setLieu_livre($_POST["lieu_livre"]);
                $proforma->setDelai_valid($date_valid);
                $proforma->setDate_paie($date_paie);
                $proforma->setId_besoin($_POST["id_besoin"]);
                $proforma->setCode_membre_fournisseur($code_membre);
                $proforma->setId_utilisateur($id_utilisateur);
                $proforma->setType_proforma("fixe");
                if ($taxe != '')
                    $proforma->setId_taxe($taxe);
                else
                    $proforma->setId_taxe(null);

                if (isset($_POST["compteur"])) {
                    $compteur = $_POST["compteur"];
                    $porter = new Application_Model_EuPorter();
                    $mp = new Application_Model_EuPorterMapper();
                    for ($i = 0; $i < $compteur; $i++) {
                        $thtva = $thtva + ($_POST["qte_objet$i"] * $_POST["pu$i"]);
                        $remise = $remise + ($_POST["qte_objet$i"] * $_POST["pu$i"] * $_POST["remise$i"]) / 100;
                    }
                    $thtva = $thtva - $remise;
                }
                $proforma->setMontant_ht($thtva);
                $mapper = new Application_Model_EuProformaMapper();
                $mapper->save($proforma);

                if (isset($_POST["compteur"])) {
                    $compteur = $_POST["compteur"];
                    $porter = new Application_Model_EuPorter();
                    $mp = new Application_Model_EuPorterMapper();
                    for ($i = 0; $i < $compteur; $i++) {
                        $porter->setCode_proforma($code_proforma);
                        $porter->setId_objet($_POST["id_objet$i"]);
                        $porter->setQte_objet($_POST["qte_objet$i"]);
                        $porter->setPu_objet($_POST["pu$i"]);
                        $porter->setRemise($_POST["remise$i"]);
                        $porter->setMdv($_POST["mdv$i"]);
                        $porter->setDisponible(0);
                        $mp->save($porter);
                    }
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Impossible d\'enrégistrer les données';
                //$message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
    }

    public function envoipformaAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $id_utilisateur = $user->id_utilisateur;
        if ($this->getRequest()->isPost()) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //$date = new Zend_Date();
                //$date_p = clone $date;
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $proforma = new Application_Model_EuProforma();
                $thtva = 0;
                $remise = 0;
                $date1 = explode("-", $_POST["delai_valid"]);
                $date2 = explode("-", $_POST["date_livre"]);
                $date3 = explode("-", $_POST["date_paie"]);
                $taxe = $_POST["taxe"];

                $date_valid = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $date_livre = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                $date_paie = $date3[2] . '-' . $date3[1] . '-' . $date3[0];

                $code_proforma = 'pf' . $date_idd->tostring('yyMMddHHmmss');

                $proforma->setCode_proforma($code_proforma);
                $proforma->setDate_proforma($date_idd->toString('yyyy-mm-dd'));
                $proforma->setDate_livre($date_livre);
                $proforma->setLieu_livre($_POST["lieu_livre"]);
                $proforma->setDelai_valid($date_valid);
                $proforma->setDate_paie($date_paie);
                $proforma->setId_besoin($_POST["id_besoin"]);
                $proforma->setCode_membre_fournisseur($code_membre);
                $proforma->setId_utilisateur($id_utilisateur);
                $proforma->setType_proforma("circulant");
                if ($taxe != '')
                    $proforma->setId_taxe($taxe);
                else
                    $proforma->setId_taxe(null);

                if (isset($_POST["compteur"])) {
                    $compteur = $_POST["compteur"];
                    $porter = new Application_Model_EuPorter();
                    $mp = new Application_Model_EuPorterMapper();
                    for ($i = 0; $i < $compteur; $i++) {
                        $thtva = $thtva + ($_POST["qte_objet$i"] * $_POST["pu$i"]);
                        $remise = $remise + ($_POST["qte_objet$i"] * $_POST["pu$i"] * $_POST["remise$i"]) / 100;
                    }
                    $thtva = $thtva - $remise;
                }
                $proforma->setMontant_ht($thtva);
                $mapper = new Application_Model_EuProformaMapper();
                $mapper->save($proforma);

                if (isset($_POST["compteur"])) {
                    $compteur = $_POST["compteur"];
                    $porter = new Application_Model_EuPorter();
                    $mp = new Application_Model_EuPorterMapper();
                    for ($i = 0; $i < $compteur; $i++) {
                        $porter->setCode_proforma($code_proforma);
                        $porter->setId_objet($_POST["id_objet$i"]);
                        $porter->setQte_objet($_POST["qte_objet$i"]);
                        $porter->setPu_objet($_POST["pu$i"]);
                        $porter->setRemise($_POST["remise$i"]);
                        $porter->setMdv(null);
                        $porter->setDisponible(0);
                        $mp->save($porter);
                    }
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Impossible d\'enrégistrer les données';
                //$message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
    }

    public function newfAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
		if(isset($code_membre)) {
        $form = new Application_Form_EuProforma();
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-proforma',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
           $this->view->form = $form;
           $request = $this->getRequest();
		}
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $id_besoin = $request->lib_besoin;
                $tabela = new Application_Model_DbTable_EuConcerner();
                $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_concerner.id_besoin')
                        ->join('eu_objet', 'eu_objet.id_objet = eu_concerner.id_objet')
                        ->where('eu_concerner.type = ?', 'fixe')
                        ->where('eu_besoin.id_besoin = ?', $id_besoin);

                $alloc = $tabela->fetchAll($select);
                $tab = array(array());
                $i = 0;
                foreach ($alloc as $row) {

                    $tab[$i][1] = $row->id_objet;
                    $tab[$i][2] = $row->design_objet;
                    $tab[$i][3] = $row->qte_objet;
                    $tab[$i][4] = $row->id_besoin;
                    $tab[$i][5] = $row->date_valide;
                    $tab[$i][6] = $row->unite_mesure;
                    $i++;
                }
                $this->view->data = $tab;
            }
        }
    }

    public function editAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $id_utilisateur = $user->id_utilisateur;
        $code_membre = $user->code_membre;
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $proforma = new Application_Model_EuProforma();
                $thtva = 0;
                $remise = 0;
                $date1 = explode("-", $_POST["delai_valid"]);
                $date2 = explode("-", $_POST["date_livre"]);
                $date3 = explode("-", $_POST["date_paie"]);
                $taxe = $_POST["taxe"];
                $type_proforma = $_POST["type_proforma"];

                $date_valid = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $date_livre = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                $date_paie = $date3[2] . '-' . $date3[1] . '-' . $date3[0];

                $code_proforma = $_POST["code_proforma"];
                $proforma->setCode_proforma($code_proforma);
                $proforma->setDate_proforma($date_idd->toString('yyyy-mm-dd'));
                $proforma->setDate_livre($date_livre);
                $proforma->setLieu_livre($_POST["lieu_livre"]);
                $proforma->setDelai_valid($date_valid);
                $proforma->setDate_paie($date_paie);
                $proforma->setId_besoin($_POST["id_besoin"]);
                $proforma->setCode_membre_fournisseur($code_membre);
                $proforma->setId_utilisateur($id_utilisateur);
                if ($type_proforma == 'fixe')
                    $proforma->setType_proforma("fixe");
                else
                    $proforma->setType_proforma("circulant");
                if ($taxe != '')
                    $proforma->setId_taxe($taxe);
                else
                    $proforma->setId_taxe(null);

                if (isset($_POST["compteur"])) {
                    $compteur = $_POST["compteur"];
                    $porter = new Application_Model_EuPorter();
                    $mp = new Application_Model_EuPorterMapper();
                    for ($i = 0; $i < $compteur; $i++) {
                        $thtva = $thtva + ($_POST["qte_objet$i"] * $_POST["pu$i"]);
                        $remise = $remise + ($_POST["qte_objet$i"] * $_POST["pu$i"] * $_POST["remise$i"]) / 100;
                    }
                    $thtva = $thtva - $remise;
                }
                $proforma->setMontant_ht($thtva);
                $mapper = new Application_Model_EuProformaMapper();
                $mapper->update($proforma);

                if (isset($_POST["compteur"])) {
                    $compteur = $_POST["compteur"];
                    $porter = new Application_Model_EuPorter();
                    $mp = new Application_Model_EuPorterMapper();
                    for ($i = 0; $i < $compteur; $i++) {

                        $porter->setId_porter($_POST["id_porter$i"]);
                        $porter->setCode_proforma($code_proforma);
                        $porter->setId_objet($_POST["id_objet$i"]);
                        $porter->setQte_objet($_POST["qte_objet$i"]);
                        $porter->setPu_objet($_POST["pu$i"]);
                        $porter->setRemise($_POST["remise$i"]);
                        if (isset($_POST["mdv$i"]))
                            $porter->setMdv($_POST["mdv$i"]);
                        else
                            $porter->setMdv(null);
                        $porter->setDisponible(0);
                        $mp->update($porter);
                    }
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {

                $db->rollback();
                $message = 'Impossible de faire la mise à jour';
                //$message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        } else {
            $code_proforma = $request->code_proforma;
            $tabela = new Application_Model_DbTable_EuPorter();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join('eu_proforma', 'eu_proforma.code_proforma = eu_porter.code_proforma')
                    ->join('eu_objet', 'eu_objet.id_objet = eu_porter.id_objet')
                    ->where('eu_proforma.code_proforma = ?', $code_proforma);
            $alloc = $tabela->fetchAll($select);
            $tab = array(array());
            $i = 0;
            foreach ($alloc as $row) {

                $tab[$i][0] = $row->code_proforma;
                $tab[$i][1] = $row->id_objet;
                $tab[$i][2] = $row->design_objet;
                $tab[$i][3] = $row->qte_objet;
                $tab[$i][4] = $row->pu_objet;
                $tab[$i][5] = $row->remise;
                $tab[$i][6] = $row->mdv;
                $tab[$i][7] = $row->type_proforma;
                $tab[$i][8] = $row->id_besoin;
                $tab[$i][9] = $row->date_livre;
                $tab[$i][10] = $row->lieu_livre;
                $tab[$i][11] = $row->delai_valid;
                $tab[$i][12] = $row->date_paie;
                $tab[$i][13] = $row->montant_ht;
                $tab[$i][14] = $row->id_taxe;
                $tab[$i][15] = $row->id_porter;
                $i++;
            }
            $this->view->data = $tab;
        }
    }

    public function newAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
		if(isset($code_membre)){
        $id_utilisateur = $user->id_utilisateur;
        $form = new Application_Form_EuProforma();
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-proforma',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;

        $request = $this->getRequest();
}
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {

                $id_besoin = $request->lib_besoin;
                $tabela = new Application_Model_DbTable_EuConcerner();
                $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                        ->join('eu_besoin', 'eu_besoin.id_besoin = eu_concerner.id_besoin')
                        ->join('eu_objet', 'eu_objet.id_objet = eu_concerner.id_objet')
                        ->where('eu_concerner.type = ?', 'circulant')
                        ->where('eu_besoin.id_besoin = ?', $id_besoin);

                $alloc = $tabela->fetchAll($select);
                $tab = array(array());
                $i = 0;
                foreach ($alloc as $row) {

                    $tab[$i][1] = $row->id_objet;
                    $tab[$i][2] = $row->design_objet;
                    $tab[$i][3] = $row->qte_objet;
                    $tab[$i][4] = $row->id_besoin;
                    $tab[$i][5] = $row->date_valide;
                    $tab[$i][6] = $row->unite_mesure;
                    $i++;
                }
                $this->view->data = $tab;
            }
        }
    }

}
