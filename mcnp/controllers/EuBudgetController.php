<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuBudgetController extends Zend_Controller_Action {

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a href=\" /eu-budget/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'gac' && $group != 'gacp' && $group != 'gacse' && $group != 'gacr' && $group != 'gacs' && $group != 'gaca' && $group != 'filiere' && $group != 'creneau' && $group != 'acteur' &&
                    $group != 'filiere_pbf' && $group != 'gac_pbf' && $group != 'gacp_pbf' && $group != 'gacse_pbf' && $group != 'gacr_pbf' && $group != 'gacs_pbf' && $group != 'gaca_pbf' && $group != 'creneau_pbf' && $group != 'acteur_pbf') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $id_utilisateur = $user->id_utilisateur;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100000);
        $sidx = $this->_request->getParam("sidx", 'id_investissement');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuInvestissement();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_besoin', 'eu_besoin.id_besoin = eu_investissement.id_besoin')
                ->where('eu_investissement.id_utilisateur = ?', $id_utilisateur)
                ->order('eu_investissement.id_investissement desc');

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
            $date_investissement = new Zend_Date($row->date_investissement, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_investissement;
            $responce['rows'][$i]['cell'] = array(
                $row->id_investissement,
                ucfirst($row->objet_besoin),
                $row->code_smcipn,
                $row->montant_budget,
                ucfirst($row->cat_objet),
                $date_investissement->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $form = new Application_Form_EuBudgetInvestissement();
        $this->view->form = $form;
    }

    public function listprodbudAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $id_besoin = $request->id_besoin;
        $categorie = $request->categorie;
        $investissement = $request->investissement;

        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $select = "select id_porter, p.id_objet, p.code_proforma, pu_objet, qte_objet, remise, design_objet, mdv, f.code_membre_fournisseur, f.type_proforma from eu_porter p join eu_objet o on p.id_objet=o.id_objet join eu_proforma f on f.code_proforma=p.code_proforma where  p.code_proforma in (select code_proforma from eu_proforma where  id_besoin='$id_besoin' and  type_proforma='$categorie')";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::fetch_obj);
        $produit = $db->fetchAll($select);
        $count = count($produit);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $db->setFetchMode(Zend_Db::fetch_obj);
        $produit = $db->fetchAll($select);
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($produit as $row) {
            $tot = $row->pu_objet * $row->qte_objet;

            $responce['rows'][$i]['id'] = $row->id_porter;
            $responce['rows'][$i]['cell'] = array(
                $row->id_porter,
                $row->code_proforma,
                $row->id_objet,
                ucfirst($row->design_objet),
                $row->code_membre_fournisseur,
                ucfirst($row->type_proforma),
                $row->mdv,
                $row->pu_objet,
                $row->qte_objet,
                $row->remise,
                $tot - ($tot * $row->remise / 100),
                $id_besoin,
                $investissement,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function editAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $id_investissement = $request->id_investissement;
        $categorie = $request->categorie;
        //Récupération des factures proforma liés à l'id_besoin trouvé
        $tabel = new Application_Model_DbTable_EuInvestissement();
        $sel = $tabel->select();
        $sel->where('eu_investissement.id_investissement =?', $id_investissement);
        $investissement = $tabel->fetchAll($sel);
        foreach ($investissement as $row) {
            $besoin = $row->id_besoin;
        }
        $this->view->data = $besoin;
        $this->view->categorie = $categorie;
        $this->view->investissement = $id_investissement;

        //Récupération des données
        $tabela = new Application_Model_DbTable_EuAutreBudget();
        $select = $tabela->select();
        $select->where('eu_autre_budget.id_investissement =?', $id_investissement);
        $budget = $tabela->fetchAll($select);
        $tab = array(array());
        $i = 0;
        foreach ($budget as $row) {

            $tab[$i][1] = $row->id_budget;
            $tab[$i][2] = $row->libbesoin;
            $tab[$i][3] = $row->montant;
            $tab[$i][4] = $row->id_investissement;
            $tab[$i][5] = $row->type_budget;
            $i++;
        }
        $this->view->budget = $tab;
    }

    public function detailsmcipnAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $id_investissement = $request->id_investissement;
        $tabel = new Application_Model_DbTable_EuBudgetFacture();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->join('eu_investissement', 'eu_investissement.id_investissement = eu_budget_facture.id_investissement')
                ->join('eu_besoin', 'eu_besoin.id_besoin = eu_budget_facture.id_besoin')
                ->join('eu_porter', 'eu_porter.code_proforma = eu_budget_facture.code_proforma')
                ->join('eu_porter', 'eu_porter.id_objet = eu_budget_facture.id_objet')
                ->join('eu_objet', 'eu_objet.id_objet = eu_budget_facture.id_objet')
                ->where('eu_investissement.id_investissement = ?', $id_investissement);
        $investissement = $tabel->fetchAll($sel);
        $tab = array(array());
        $i = 0;
        foreach ($investissement as $row) {
            $date_investissement = new Zend_Date($row->date_investissement, Zend_Date::ISO_8601);
            $tab[$i][1] = $row->id_investissement;
            $tab[$i][2] = $row->montant_budget;
            $tab[$i][3] = $row->cat_objet;
            $tab[$i][4] = $date_investissement->toString('dd/mm/yyyy');
            $tab[$i][5] = $row->objet_besoin;
            $i++;
        }
        $this->view->data = $tab;

        $tabela = new Application_Model_DbTable_EuInvestissement();
        $selection = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selection->setIntegrityCheck(false)
                ->join('eu_autre_budget', 'eu_autre_budget.id_investissement = eu_investissement.id_investissement')
                ->where('eu_investissement.id_investissement = ?', $id_investissement);
        $budget = $tabela->fetchAll($selection);
        $tab1 = array(array());
        $i = 0;
        foreach ($budget as $row) {
            $tab1[$i][1] = $row->libbesoin;
            $tab1[$i][2] = $row->montant;
            $tab1[$i][3] = $row->id_investissement;
            $tab1[$i][4] = $row->type_budget;
            $i++;
        }
        $this->view->data1 = $tab1;
    }

    public function listinvestisAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $id_investissement = $request->id_investissement;
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_proforma');
        $sord = $this->_request->getParam("sord", 'asc');

        $tabela = new Application_Model_DbTable_EuBudgetFacture();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_objet', 'eu_objet.id_objet = eu_budget_facture.id_objet')
                ->join('eu_investissement', 'eu_investissement.id_investissement = eu_budget_facture.id_investissement')
                ->where('eu_investissement.id_investissement= ?', $id_investissement);
        $justif = $tabela->fetchAll($select);
        $count = count($justif);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $justif = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $binves = 0;
        $totpu = 0;
        $totqte = 0;
        $totremise = 0;
        foreach ($justif as $row) {
            $tot = $row->pu_objet * $row->qte_objet;
            $total = $tot - ($tot * $row->remise_objet / 100);
            $binves+=$total;
            $totpu+=$row->pu_objet;
            $totqte+=$row->qte_objet;
            $totremise+=$row->remise_objet;
            $responce['rows'][$i]['id'] = $row->id_objet . $row->code_proforma;
            $responce['rows'][$i]['cell'] = array(
                $row->code_proforma,
                $row->id_objet,
                ucfirst($row->design_objet),
                $row->pu_objet,
                $row->qte_objet,
                $row->remise_objet,
                $total
            );
            $i++;
        }
        $responce['userdata']['design_objet'] = 'Total:';
        $responce['userdata']['pu_objet'] = $totpu;
        $responce['userdata']['qte_objet'] = $totqte;
        $responce['userdata']['remise'] = $totremise;
        $responce['userdata']['total'] = $binves;
        $this->view->data = $responce;
    }

    public function modifbudgetAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_create = clone $date;
        $selection = array();
        $sel1 = array();
        $sel2 = array();
        $sel3 = array();

        if (isset($_GET['lignes']))
            $selection = $_GET['lignes'];
        if (isset($_GET['lignes1']))
            $sel1 = $_GET['lignes1'];
        if (isset($_GET['lignes2']))
            $sel2 = $_GET['lignes2'];
        if (isset($_GET['lignes3']))
            $sel3 = $_GET['lignes3'];
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {

            //initialisation des valeurs
            $mt_fixe = 0;
            $mt_circul = 0;
            $mtf = 0;
            $mtc = 0;
            $id_besoin = 0;
            if (isset($_GET['compteur'])) {

                $compteur = $_GET['compteur'];
                for ($i = 0; $i < $compteur; $i++) {
                    if ($sel3[$i] == 'circulant')
                        $mtc +=$sel2[$i];
                    else
                        $mtf +=$sel2[$i];
                }
            }

            //Calcul du total des i fixe et circulant
            foreach ($selection as $val) {

                if ($val['type'] == 'Fixe') {
                    $mt_fixe += $val['total'];
                } else if ($val['type'] == 'Circulant') {
                    $mt_circul += $val['total'];
                }
                $id_besoin = $val['besoin'];
                $id_investissement = $val['investissement'];
                $type = $val['type'];
            }

            //Insertion dans la table investissement
            if ($mt_fixe != 0 && $type == 'Fixe') {
                $query = "update eu_investissement set montant_budget = (0),date_investissement= now()  where id_investissement= '$id_investissement'";
                $db->query($query);
                $select = "select * from eu_budget_facture,eu_porter where eu_budget_facture.id_objet=eu_porter.id_objet  and  eu_budget_facture.code_proforma=eu_porter.code_proforma  and  eu_budget_facture.id_investissement='$id_investissement'";
                $db->setFetchMode(Zend_Db::fetch_obj);
                $donnees = $db->fetchAll($select);

                foreach ($donnees as $row) {
                    $id_porter = $row->id_porter;
                    $select1 = "update eu_porter set disponible = 0 where id_porter= '$id_porter' ";
                    $db->query($select1);
                    $select2 = "delete from eu_budget_facture  where id_objet= '$row->id_objet' and code_proforma= '$row->code_proforma'";
                    $db->query($select2);
                }

                $requete = "select * from eu_autre_budget where id_investissement='$id_investissement'";
                $db->setFetchMode(Zend_Db::fetch_obj);
                $enreg = $db->fetchAll($requete);
                $i = 0;
                foreach ($enreg as $row) {
                    $id_budget = $row->id_budget;
                    $select2 = "update eu_autre_budget set libbesoin='$sel1[$i]',montant='$sel2[$i]',type_budget='$sel3[$i]' where id_budget='$id_budget'";
                    $db->query($select2);
                    $i++;
                }

                $query = "update eu_investissement set montant_budget =($mt_fixe + $mtf),date_investissement= now()  where id_investissement=' $id_investissement'";
                $db->query($query);

                foreach ($selection as $sel) {

                    $id_objet = $sel['id_objet'];
                    $code_proforma = $sel['code_proforma'];
                    $pu_objet = $sel['pu_objet'];
                    $qte_objet = $sel['qte_objet'];
                    $remise = $sel['remise'];
                    $type = $sel['type'];
                    $id_porter = $sel['id_porter'];

                    $select = "insert into eu_budget_facture (id_objet,code_proforma,pu_objet,qte_objet,remise_objet,categorie_objet,id_besoin,id_investissement) values ($id_objet,'$code_proforma',$pu_objet,$qte_objet,$remise,'$type',$id_besoin,$id_investissement)";
                    $db->query($select);
                    $select1 = "update eu_porter set disponible = 1 where id_porter= '$id_porter' ";
                    $db->query($select1);
                }
            } else if ($mt_circul != 0 && $type == 'Circulant') {

                $query = "update eu_investissement set montant_budget = (0),date_investissement= now()  where id_investissement = '$id_investissement' ";
                $db->query($query);
                $select = "select * from eu_budget_facture,eu_porter where eu_budget_facture.id_objet=eu_porter.id_objet  and  eu_budget_facture.code_proforma=eu_porter.code_proforma  and  eu_budget_facture.id_investissement='$id_investissement'";
                $db->setFetchMode(Zend_Db::fetch_obj);
                $donnees = $db->fetchAll($select);
                foreach ($donnees as $row) {

                    $id_porter = $row->id_porter;
                    $select1 = "update eu_porter set disponible = 0 where id_porter= '$id_porter' ";
                    $db->query($select1);
                    $select2 = "delete from eu_budget_facture  where id_objet= '$row->id_objet' and code_proforma= '$row->code_proforma'";
                    $db->query($select2);
                }

                $requete = "select * from eu_autre_budget where id_investissement='$id_investissement'";
                $db->setFetchMode(Zend_Db::fetch_obj);
                $enreg = $db->fetchAll($requete);
                $i = 0;
                foreach ($enreg as $row) {
                    $id_budget = $row->id_budget;
                    $select2 = "update eu_autre_budget set libbesoin='$sel1[$i]',montant='$sel2[$i]',type_budget='$sel3[$i]' where id_budget='$id_budget'";
                    $db->query($select2);
                    $i++;
                }

                $query = "update eu_investissement set montant_budget =($mt_circul + $mtc),date_investissement= now()  where id_investissement=' $id_investissement'";
                $db->query($query);
                foreach ($selection as $sel) {

                    $id_objet = $sel['id_objet'];
                    $code_proforma = $sel['code_proforma'];
                    $pu_objet = $sel['pu_objet'];
                    $qte_objet = $sel['qte_objet'];
                    $remise = $sel['remise'];
                    $type = $sel['type'];
                    $id_porter = $sel['id_porter'];
                    $select = "insert into eu_budget_facture (id_objet,code_proforma,pu_objet,qte_objet,remise_objet,categorie_objet,id_besoin,id_investissement) values ($id_objet,'$code_proforma',$pu_objet,$qte_objet,$remise,'$type',$id_besoin,$id_investissement)";

                    $db->query($select);
                    $select1 = "update eu_porter set disponible = 1 where id_porter= '$id_porter' ";
                    $db->query($select1);
                }
            }
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            //$this->view->message = $message;
            $this->view->data = 'bad';
            return;
        }
    }

    public function demandeAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_create = clone $date;
        $selection = array();
        $sel1 = array();
        $sel2 = array();
        $sel3 = array();
        $compteur = $_GET['compteur'];
        $selection = $_GET['lignes'];
        $sel1 = $_GET['lignes1'];
        $sel2 = $_GET['lignes2'];
        $sel3 = $_GET['lignes3'];
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {

            //Récupération du total de l'investissement

            $mt_fixe = 0;
            $mt_circul = 0;
            $mtf = 0;
            $mtc = 0;
            $id_besoin = 0;

            //Calcul du total des i fixe et circulant
            foreach ($selection as $val) {
                if ($val['type'] == 'Fixe') {
                    $mt_fixe += $val['total'];
                } else if ($val['type'] == 'Circulant') {
                    $mt_circul += $val['total'];
                }
                $id_besoin = $val['besoin'];
            }

            $selectc = "select * from eu_investissement where id_besoin='$id_besoin' and cat_objet='circulant' ";
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_Db::fetch_obj);
            $donneesc = $db->fetchAll($selectc);
            $selectf = "select * from eu_investissement where id_besoin='$id_besoin' and cat_objet='fixe' ";
            $donneesf = $db->fetchAll($selectf);
            foreach ($donneesc as $row) {
                //$besoinc=$row->id_besoin;
                $id = $row->id_investissement;
            }

            foreach ($donneesf as $row) {
                // $besoinf=$row->id_besoin;
                $id_investissement = $row->id_investissement;
            }

            for ($i = 1; $i <= $compteur; $i++) {
                if ($sel3[$i] == 'circulant')
                    $mtc +=$sel2[$i];
                else
                    $mtf +=$sel2[$i];
            }

            if (isset($id_investissement)) {

                $query = "update eu_investissement set montant_budget = (montant_budget + $mt_fixe + $mtf)  where id_investissement= $id_investissement";
                $db->query($query);
                foreach ($selection as $sel) {
                    if ($sel['type'] == 'Fixe') {
                        $id_objet = $sel['id_objet'];
                        $code_proforma = $sel['code_proforma'];
                        $pu_objet = $sel['pu_objet'];
                        $qte_objet = $sel['qte_objet'];
                        $remise = $sel['remise'];
                        $type = $sel['type'];
                        $id_porter = $sel['id_porter'];
                        $select = "insert into eu_budget_facture (id_objet,code_proforma,pu_objet,qte_objet,remise_objet,categorie_objet,id_besoin,id_investissement) values ($id_objet,'$code_proforma',$pu_objet,$qte_objet,$remise,'$type',$id_besoin,$id_investissement)";
                        $db->query($select);
                        $select1 = "update eu_porter set disponible = 1 where id_porter= $id_porter ";
                        $db->query($select1);
                    }
                }
                for ($i = 1; $i <= $compteur; $i++) {
                    if ($sel1[$i] != '' && $sel2[$i] != '' && $sel3[$i] == 'fixe') {
                        $select2 = "insert into eu_autre_budget (id_budget,libbesoin,montant,id_investissement,type_budget) values (0,'$sel1[$i]',$sel2[$i],$id_investissement,'$sel3[$i]')";
                        $db->query($select2);
                    }
                }
            } else {
                //Insertion dans la table investissement
                if ($mt_fixe != 0) {

                    $bim = new Application_Model_EuInvestissementMapper();
                    $bi = new Application_Model_EuInvestissement();
                    $count = $bim->findConuter() + 1;
                    $bi->setId_investissement($count);
                    $bi->setMontant_budget($mt_fixe + $mtf);
                    $bi->setCat_objet('fixe');
                    $bi->setDate_investissement($date_create->toString('yyyy-mm-dd'));
                    $bi->setId_utilisateur($user->id_utilisateur);
                    $bi->setId_besoin($id_besoin);
                    $bi->setCode_smcipn(null);
                    $bim->save($bi);

                    foreach ($selection as $sel) {
                        if ($sel['type'] == 'Fixe') {
                            $id_objet = $sel['id_objet'];
                            $code_proforma = $sel['code_proforma'];
                            $pu_objet = $sel['pu_objet'];
                            $qte_objet = $sel['qte_objet'];
                            $remise = $sel['remise'];
                            $type = $sel['type'];
                            $id_porter = $sel['id_porter'];
                            $select = "insert into eu_budget_facture (id_objet,code_proforma,pu_objet,qte_objet,remise_objet,categorie_objet,id_besoin,id_investissement) values ($id_objet,'$code_proforma',$pu_objet,$qte_objet,$remise,'$type',$id_besoin,$count)";
                            $db->query($select);
                            $select1 = "update eu_porter set disponible = 1 where id_porter= $id_porter ";
                            $db->query($select1);
                        }
                    }
                    for ($i = 1; $i <= $compteur; $i++) {
                        if ($sel1[$i] != '' && $sel2[$i] != '' && $sel3[$i] == 'fixe') {
                            $select2 = "insert into eu_autre_budget (id_budget,libbesoin,montant,id_investissement,type_budget) values (0,'$sel1[$i]',$sel2[$i],$count,'$sel3[$i]')";
                            $db->query($select2);
                        }
                    }
                }
            }

            if (isset($id)) {

                $query = "update eu_investissement set montant_budget =(montant_budget + $mt_circul + $mtc)  where id_investissement= $id";
                $db->query($query);
                foreach ($selection as $sel) {
                    if ($sel['type'] == 'Circulant') {

                        $id_objet = $sel['id_objet'];
                        $code_proforma = $sel['code_proforma'];
                        $pu_objet = $sel['pu_objet'];
                        $qte_objet = $sel['qte_objet'];
                        $remise = $sel['remise'];
                        $type = $sel['type'];
                        $id_porter = $sel['id_porter'];
                        $select = "insert into eu_budget_facture (id_objet,code_proforma,pu_objet,qte_objet,remise_objet,categorie_objet,id_besoin,id_investissement) values ($id_objet,'$code_proforma',$pu_objet,$qte_objet,$remise,'$type',$id_besoin,$id)";
                        $db->query($select);
                        $select1 = "update eu_porter set disponible = 1 where id_porter= $id_porter ";
                        $db->query($select1);
                    }
                }
                for ($i = 1; $i <= $compteur; $i++) {
                    if ($sel1[$i] != '' && $sel2[$i] != '' && $sel3[$i] == 'circulant') {
                        $select2 = "insert into eu_autre_budget (id_budget,libbesoin,montant,id_investissement,type_budget) values (0,'$sel1[$i]',$sel2[$i],$id,'$sel3[$i]')";
                        $db->query($select2);
                    }
                }
            } else {
                if ($mt_circul != 0) {

                    $bim = new Application_Model_EuInvestissementMapper();
                    $bi = new Application_Model_EuInvestissement();
                    $count = $bim->findConuter() + 1;
                    $bi->setId_investissement($count);
                    $bi->setMontant_budget($mt_circul + $mtc);
                    $bi->setCat_objet('circulant');
                    $bi->setDate_investissement($date_create->toString('yyyy-mm-dd'));
                    $bi->setId_utilisateur($user->id_utilisateur);
                    $bi->setId_besoin($id_besoin);
                    $bi->setCode_smcipn(null);
                    $bim->save($bi);

                    foreach ($selection as $sel) {
                        if ($sel['type'] == 'Circulant') {

                            $id_objet = $sel['id_objet'];
                            $code_proforma = $sel['code_proforma'];
                            $pu_objet = $sel['pu_objet'];
                            $qte_objet = $sel['qte_objet'];
                            $remise = $sel['remise'];
                            $type = $sel['type'];
                            $id_porter = $sel['id_porter'];
                            $select = "insert into eu_budget_facture (id_objet,code_proforma,pu_objet,qte_objet,remise_objet,categorie_objet,id_besoin,id_investissement)  values ($id_objet,'$code_proforma',$pu_objet,$qte_objet,$remise,'$type',$id_besoin,$count)";
                            $db->query($select);
                            $select1 = "update eu_porter set disponible = 1 where id_porter= $id_porter ";
                            $db->query($select1);
                        }
                    }
                    for ($i = 1; $i <= $compteur; $i++) {
                        if ($sel1[$i] != '' && $sel2[$i] != '' && $sel3[$i] == 'circulant') {
                            $select2 = "insert into eu_autre_budget (id_budget,libbesoin,montant,id_investissement,type_budget) values (0,'$sel1[$i]',$sel2[$i],$count,'$sel3[$i]')";
                            $db->query($select2);
                        }
                    }
                }
            }
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            //     $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            //     $this->view->message = $message;
            $this->view->data = 'bad';
            return;
        }
    }

    public function listprodAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $besoin = $request->id_besoin;
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        //Récupération des factures proforma liés à l'id_besoin trouvé
        $tabel = new Application_Model_DbTable_EuProforma();
        $sel = $tabel->select();
        $sel->where('eu_proforma.id_besoin =?', $besoin);
        $proforma = $tabel->fetchAll($sel);
        $rep = array();
        $i = 0;
        foreach ($proforma as $row) {
            $rep[$i] = $row->code_proforma;
            $i++;
        }
        $select = "select id_porter, p.id_objet, p.code_proforma, pu_objet, qte_objet, remise, design_objet, mdv, f.code_membre_fournisseur, f.type_proforma from eu_porter p join eu_objet o on p.id_objet=o.id_objet join eu_proforma f on f.code_proforma=p.code_proforma where p.disponible <> 1 and p.code_proforma in (select code_proforma from eu_proforma where id_besoin='$besoin')";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::fetch_obj);
        $produit = $db->fetchAll($select);
        $count = count($produit);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $db->setFetchMode(Zend_Db::fetch_obj);
        $produit = $db->fetchAll($select);
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($produit as $row) {
            $tot = $row->pu_objet * $row->qte_objet;

            $responce['rows'][$i]['id'] = $row->id_porter;
            $responce['rows'][$i]['cell'] = array(
                $row->id_porter,
                $row->code_proforma,
                $row->id_objet,
                ucfirst($row->design_objet),
                $row->code_membre_fournisseur,
                ucfirst($row->type_proforma),
                $row->mdv,
                $row->pu_objet,
                $row->qte_objet,
                $row->remise,
                $tot - ($tot * $row->remise / 100),
                $besoin,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

}

?>
