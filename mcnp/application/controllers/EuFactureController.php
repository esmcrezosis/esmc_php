<?php

class EuFactureController extends Zend_Controller_Action {

    //put your code here

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"new\" href=\"/eu-facture/new\">Liste commande</a></li>" .
                "<li><a id=\"new\" href=\"/eu-facture/list\">Liste des factures</a></li>";
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
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        if (isset($_POST["facture"])) {
            $code_facture = $_POST['facture'];
            $this->view->facture = $code_facture;
        }
    }

    public function listAction() {
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        if (isset($_POST["facture"])) {
            $code_facture = $_POST['facture'];
            $this->view->facture = $code_facture;
        }
    }

    public function listfactureAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $id_utilisateur = $user->id_utilisateur;
        if (isset($_GET["code_facture"]))
            $code_facture = $_GET["code_facture"];
        if ($code_membre != '') {
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'code_facture');
            $sord = $this->_request->getParam("sord", 'asc');
            $tabela = new Application_Model_DbTable_EuFacture();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            if ($code_facture != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_membre', 'eu_membre.code_membre = eu_facture.code_membre_client')
                        ->where('eu_facture.id_utilisateur = ?', $id_utilisateur)
                        ->where('eu_facture.code_facture = ?', $code_facture);
                $alloc = $tabela->fetchAll($select);
            } else {
                $select->setIntegrityCheck(false)
                        ->join('eu_membre', 'eu_membre.code_membre = eu_facture.code_membre_client')
                        ->where('eu_facture.id_utilisateur = ?', $id_utilisateur);
                $alloc = $tabela->fetchAll($select);
            }
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

                $date_facture = new Zend_Date($row->date_facture, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_facture;
                $responce['rows'][$i]['cell'] = array(
                    $date_facture->toString('dd/mm/yyyy'),
                    $row->code_facture,
                    $row->montant_ht,
                    $montant_net,
                    $row->code_membre_client
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function controleAction() {

        $request = $this->getRequest();
        $num_fact = $request->num_fact;
        $facture = new Application_Model_DbTable_EuFacture();
        $select = $facture->select();
        $select->from($facture, array('num_fact'));
        $select->where('num_fact = ?', $num_fact);
        $result = $facture->fetchAll($select);
        $row = $result->current();
        $this->view->data = $row['num_fact'];
    }

    public function facturecAction() {

        $request = $this->getRequest();
        $num_com = $request->num_com;
        $facture = new Application_Model_DbTable_EuFacture;
        $select = $facture->select();
        $select->from($facture, array('num_fact'));
        $select->where('num_com = ?', $num_com);
        $result = $facture->fetchAll($select);
        $row = $result->current();
        $this->view->data = $row['num_com'];
    }

    public function reglementAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_facture = $request->code_facture;

        $facture_m = new Application_Model_EuFactureMapper();
        $facture = new Application_Model_EuFacture();
        $total = $facture_m->findtotal($code_facture);
        $num_fournis = $facture_m->findnumfournis($code_facture);
        $num_client = $facture_m->findnumclt($code_facture);

        // $compte_db = new Application_Model_DbTable_EuCompte();
        // $compte_find = $compte_db->find($num_compteclt);
        // $result = $compte_find->current();
        // $compte_findf = $compte_db->find($num_comptefournis);
        // $resultf = $compte_findf->current();
        // $num_compteclt='nb-'.'tpagci-'.$num_client;
        // $num_comptefournis='nb-'.'tpagcp-'.$num_fournis;
        //if (isset($result->lib_compte) && isset($resultf->lib_compte)){
        //   $lib_compte = $result->lib_compte;
        //   $mt_recu =$result->mt_recu;
        //   $credit =$result->credit;
        //    $debit =$result->debit;
        //    $solde =$result->solde;
        //    $source =$result->source;
        //    $date =$result->date_alloc;
        //    $codetype =$result->code_type;
        //    $codecat =$result->code_cat;
        //    $desactiver =$result->desactiver;
        //    $lib_compte1 = $resultf->lib_compte;
        //    $mt_recu1 =$resultf->mt_recu;
        //    $credit1 =$resultf->credit;
        //    $debit1 =$resultf->debit;
        //    $solde1 =$resultf->solde;
        //    $source1 =$resultf->source;
        //    $date1 =$resultf->date_alloc;
        //    $codecat1 =$resultf->code_cat;
        //    $codetype1 =$resultf->code_type;
        //    $desactiver1 =$resultf->desactiver;
        //   $c= new  Application_Model_EuCompte;
        //   $compte_m = new Application_Model_EuCompteMapper();
        //   $solde = $compte_m->findsolde($num_compteclt);
        //$solde1 = $compte_m->findsolde($num_comptefournis);
        // $debit = $compte_m->finddebit($num_compteclt);
        // $credit = $compte_m->findcredit($num_comptefournis);

        $r = new Application_Model_EuReglement;
        $rm = new Application_Model_EuReglementMapper;
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;

        //  if ($solde >= $total_net) {

        $r->setDate_reglt($date_idd->toString('yyyy-mm-dd'));
        $r->setMontant_reglt($total);
        $r->setCode_facture($code_facture);
        $rm->save($r);

        // $c->setNum_compte($num_compteclt);
        // $c->setNum_membre($num_client);
        // $c->setLib_compte($lib_compte);
        // $c->setMt_recu($mt_recu);
        // $c->setCredit($credit);
        // $c->setDebit($debit + $total_net);
        // $c->setSolde($solde - $total_net);
        // $c->setSource($source);
        // $c->setDate_alloc($date);
        // $c->setCode_cat($codecat);
        // $c->setCode_type($codetype);
        // $c->setDesactiver($desactiver);
        // $compte_m->update($c);
        //$c->setNum_compte($num_comptefournis);
        //$c->setNum_membre($num_fournis);
        // $c->setLib_compte($lib_compte1);
        // $c->setMt_recu($mt_recu1);
        // $c->setCredit($credit1 + $total_net);
        // $c->setDebit($debit1);
        // $c->setSolde($solde1 + $total_net);
        // $c->setSource($source1);
        // $c->setDate_alloc($date1);
        // $c->setCode_cat($codecat1);
        // $c->setCode_type($codetype1);
        // $c->setDesactiver($desactiver1);
        // $compte_m->update($c);
        //Mise à jour de la table facture
        $facture_find = $facture_m->find($code_facture, $facture);
        $facture->setEtat_facture(1);
        $facture_m->update($facture);


        $maxreglt = $rm->findMaxReglt();
        $tabela = new Application_Model_DbTable_EuReglement();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_facture', 'eu_facture.code_facture = eu_reglement.code_facture')
                ->where('eu_reglement.id_reglt = ?', $maxreglt);
        $alloc = $tabela->fetchAll($select);
        $tab = array(array());
        $i = 0;
        foreach ($alloc as $row) {
            $date_reglt = new Zend_Date($row->date_reglt, Zend_Date::ISO_8601);
            $tab[$i][1] = $row->id_reglt;
            $tab[$i][2] = $row->code_facture;
            $tab[$i][3] = $row->montant_reglt;
            $tab[$i][4] = $date_reglt->toString('dd/mm/yyyy');
            $tab[$i][5] = $row->code_membre_client;
            $tab[$i][6] = $row->code_membre_fournisseur;
            $i++;
        }
        $this->view->data = $tab;
        // }
        // else
        // {
        // $message = 'Montant de la facture supérieur à la subvention.';
        // $this->view->message = $message;
        // }
        // }
        //else
        //{
        // $message = 'Le compte est introuvable.';
        // $this->view->message = $message;
        //}
    }

    public function changeAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $data = array();
        $facture = new Application_Model_DbTable_EuFacture();
        $select = $facture->select();
        $select->from($facture, array('code_facture', 'date_facture'));
        $select->where('eu_facture.code_membre_fournisseur = ?', $code_membre);
        $select->order('eu_facture.date_facture desc');
        $result = $facture->fetchAll($select);

        foreach ($result as $p) {
            $data[] = $p->code_facture;
        }
        $this->view->data = $data;
    }

    public function newAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $id_utilisateur = $user->id_utilisateur;
        if ($this->getRequest()->isPost()) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $facture = new Application_Model_EuFacture();
                $commande = new Application_Model_EuCommande();
                $commande_m = new Application_Model_EuCommandeMapper();
                $code_client = $commande_m->findclt($_POST["code_commande"]);
                $code_fournis = $commande_m->findfournis($_POST["code_commande"]);
                $taxe = $_POST["taxe"];
                $thtva = 0;
                $remise = 0;
                $code_facture = 'f' . $date_idd->tostring('yyMMddHHmmss');
                $facture->setCode_facture($code_facture);
                $facture->setCode_commande($_POST["code_commande"]);
                $facture->setCode_membre_client($code_client);
                $facture->setCode_membre_fournisseur($code_fournis);
                $facture->setDate_facture($date_idd->toString('yyyy-mm-dd'));
                $facture->setEtat_facture(0);
                $facture->setId_utilisateur($id_utilisateur);
                if ($taxe != '')
                    $facture->setId_taxe($taxe);
                else
                    $facture->setId_taxe(null);

                if (isset($_POST["compteur"])) {
                    $compteur = $_POST["compteur"];
                    for ($i = 0; $i < $compteur; $i++) {
                        $thtva = $thtva + ($_POST["qte_objet$i"] * $_POST["pu$i"]);
                        $remise = $remise + ($_POST["qte_objet$i"] * $_POST["pu$i"] * $_POST["remise$i"]) / 100;
                    }
                }
                $thtva = $thtva - $remise;

                $facture->setMontant_ht($thtva);
                $mapper = new Application_Model_EuFactureMapper();
                $mapper->save($facture);
                //Mise à jour de la table commande
                $commande_find = $commande_m->find($_POST["code_commande"], $commande);
                $commande->setEtat_commande('non disponible');
                $commande_m->update($commande);


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
        $id_utilisateur = $user->id_utilisateur;
        if (isset($_GET["code_facture"]))
            $code_facture = $_GET["code_facture"];
        if ($code_membre != '') {
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'code_facture');
            $sord = $this->_request->getParam("sord", 'asc');
            $tabela = new Application_Model_DbTable_EuFacture();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            if ($code_facture != "") {
                $select->setIntegrityCheck(false)
                        ->join('eu_membre', 'eu_membre.code_membre = eu_facture.code_membre_client')
                        ->where('eu_facture.id_utilisateur = ?', $id_utilisateur)
                        ->where('eu_facture.code_facture = ?', $code_facture)
                        ->where('eu_facture.etat_facture = ?', 0);
                $alloc = $tabela->fetchAll($select);
            } else {
                $select->setIntegrityCheck(false)
                        ->join('eu_membre', 'eu_membre.code_membre = eu_facture.code_membre_client')
                        ->where('eu_facture.id_utilisateur = ?', $id_utilisateur)
                        ->where('eu_facture.etat_facture = ?', 0);
                $alloc = $tabela->fetchAll($select);
            }
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

                $date_facture = new Zend_Date($row->date_facture, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_facture;
                $responce['rows'][$i]['cell'] = array(
                    $date_facture->toString('dd/mm/yyyy'),
                    $row->code_facture,
                    $row->montant_ht,
                    $montant_net,
                    $row->code_membre_client
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function mdetailAction() {

        $code_facture = $this->getRequest()->code_facture;
        if ($code_facture != '%') {
            //Récupération du numero commande
            $facture_m = new Application_Model_EuFactureMapper();
            $code_commande = $facture_m->findcom($code_facture);
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'design_objet');
            $sord = $this->_request->getParam("sord", 'asc');
            $tabela = new Application_Model_DbTable_EuDetailCommande();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join('eu_commande', 'eu_commande.code_commande = eu_detail_commande.code_commande')
                    ->join('eu_objet', 'eu_objet.id_objet = eu_detail_commande.id_objet')
                    ->where('eu_commande.code_commande = ?', $code_commande);
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
                $responce['rows'][$i]['id'] = $row->code_commande;
                $responce['rows'][$i]['cell'] = array(
                    $row->design_objet,
                    $row->qte_objet,
                    $row->pu_objet,
                    $row->remise
                );
                $i++;
            }

            $this->view->data = $responce;
        }
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

    public function commandeAction() {

        $this->_helper->layout->disableLayout();
        $code_commande = $this->getRequest()->code_commande;
        $tabela = new Application_Model_DbTable_EuDetailCommande();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_commande', 'eu_commande.code_commande = eu_detail_commande.code_commande')
                ->join('eu_objet', 'eu_objet.id_objet = eu_detail_commande.id_objet')
                ->where('eu_commande.code_commande = ?', $code_commande);
        $alloc = $tabela->fetchAll($select);
        $tab = array(array());
        $i = 0;
        foreach ($alloc as $row) {
            $tab[$i][1] = $row->id_objet;
            $tab[$i][2] = $row->design_objet;
            $tab[$i][3] = $row->qte_objet;
            $tab[$i][4] = $row->pu_objet;
            $tab[$i][5] = $row->remise;
            $tab[$i][6] = $row->code_commande;
            $i++;
        }
        $this->view->data = $tab;
    }

    public function listcomAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        //$num_membre = $user->num_membre;
        $id_utilisateur = $user->id_utilisateur;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_commande');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuProforma();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_commande', 'eu_commande.code_proforma = eu_proforma.code_proforma')
                ->where('eu_commande.etat_commande = ?', 'disponible')
                ->where('eu_proforma.id_utilisateur = ?', $id_utilisateur);
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
