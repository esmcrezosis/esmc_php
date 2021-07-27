<?php

class EuCommandeController extends Zend_Controller_Action {

    //put your code here

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"new\" href=\"/eu-commande/new\">Nouveau</a></li>";
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

    public function indexAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    public function controleAction() {

        $request = $this->getRequest();
        $num_com = $request->num_com;
        $commande = new Application_Model_DbTable_EuCommande;
        $select = $commande->select();
        $select->from($commande, array('num_com'));
        $select->where('num_com = ?', $num_com);
        $result = $commande->fetchAll($select);
        $row = $result->current();
        $this->view->data = $row['num_com'];
    }

    public function commandepAction() {

        $request = $this->getRequest();
        $code_proforma = $request->code_proforma;
        $commande = new Application_Model_DbTable_EuCommande;
        $select = $commande->select();
        $select->from($commande, array('code_proforma'));
        $select->where('code_proforma = ?', $code_proforma);
        $result = $commande->fetchAll($select);
        $row = $result->current();
        $this->view->data = $row['code_proforma'];
    }

    public function newAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        if(isset($code_membre)) {
        $form = new Application_Form_EuCommande();
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-commande',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
       }
        $id_utilisateur = $user->id_utilisateur;
        if ($this->getRequest()->isPost()) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $commande = new Application_Model_EuCommande();
                $mapper = new Application_Model_EuCommandeMapper();
                $code_commande = 'com' . $date_idd->tostring('yyMMddHHmmss');
                $commande->setCode_commande($code_commande);
                $commande->setCode_membre($code_membre);
                $commande->setDate_commande($date_idd->toString('yyyy-mm-dd'));
                $commande->setCode_proforma($_POST["code_proforma"]);
                $commande->setAdresse_livre($_POST["adresse_livre"]);
                $commande->setEtat_commande('disponible');
                $mapper->save($commande);

                if (isset($_POST["compteur"])) {

                    $compteur = $_POST["compteur"];
                    $detail = new Application_Model_EuDetailCommande();
                    $dm = new Application_Model_EuDetailCommandeMapper();
                    for ($i = 0; $i < $compteur; $i++) {

                        $detail->setCode_commande($code_commande);
                        $detail->setId_objet($_POST["id_objet$i"]);
                        $detail->setQte_objet($_POST["qte_objet$i"]);
                        $detail->setPu_objet($_POST["pu$i"]);
                        $detail->setRemise($_POST["remise$i"]);
                        $dm->save($detail);
                    }
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {

                $db->rollback();
                $message = 'Echec enrégistrement';
                //$message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        if ($code_membre != '') {
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'code_commande');
            $sord = $this->_request->getParam("sord", 'asc');
            $tabela = new Application_Model_DbTable_EuCommande();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join('eu_proforma', 'eu_proforma.code_proforma = eu_commande.code_proforma')
                    ->where('eu_commande.code_membre = ?', $code_membre);
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
                $date_commande = new Zend_Date($row->date_commande, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_commande;
                $responce['rows'][$i]['cell'] = array(
                    $date_commande->toString('dd/mm/yyyy'),
                    $row->code_commande,
                    $row->code_proforma,
                    $row->adresse_livre
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
        $sidx = $this->_request->getParam("sidx", 'code_commande');
        $sord = $this->_request->getParam("sord", 'desc');
        $code_commande = $this->getRequest()->code_commande;
        $tabela = new Application_Model_DbTable_EuDetailCommande();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_commande', 'eu_commande.code_commande = eu_detail_commande.code_commande')
                ->join('eu_objet', 'eu_objet.id_objet = eu_detail_commande.id_objet')
                ->where('eu_commande.code_commande = ?', $code_commande)
                ->order('eu_detail_commande.code_commande desc');
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
            $responce['rows'][$i]['id'] = $row->code_commande . '-' . $row->id_objet;
            $responce['rows'][$i]['cell'] = array(
                $row->unite_mesure,
                $row->design_objet,
                $row->qte_objet,
                $row->pu_objet,
                $row->remise
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function demandeAction() {

        $this->_helper->layout->disableLayout();
        $code_proforma = $this->getRequest()->code_proforma;
        $tabela = new Application_Model_DbTable_EuBudgetFacture();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_objet', 'eu_objet.id_objet = eu_budget_facture.id_objet')
                ->where('eu_budget_facture.code_proforma = ?', $code_proforma);
        $alloc = $tabela->fetchAll($select);
        $tab = array(array());
        $i = 0;
        foreach ($alloc as $row) {
            $tab[$i][1] = $row->id_objet;
            $tab[$i][2] = $row->design_objet;
            $tab[$i][3] = $row->qte_objet;
            $tab[$i][4] = $row->pu_objet;
            $tab[$i][5] = $row->remise_objet;
            $tab[$i][6] = $row->code_proforma;
            $i++;
        }
        $this->view->data = $tab;
    }

    public function listpformaAction() {

        if ($_GET["id_besoin"]) {
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

}