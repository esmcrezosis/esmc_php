<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuFactureSmcipnwiController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
		$code_groupe = $user->code_groupe;
		
		if($code_groupe == "smc_tpn"){
        $menu = "<li><a href=\" /eu-facture-smcipnwi/salaire\">Salaire</a></li>" .
                "<li><a href=\" /eu-facture-smcipnwi \">Factures impayées</a></li>" .
                "<li><a href=\" /eu-facture-smcipnwi/facturepayer \">Factures payées</a></li>";
		}else if($code_groupe == "fn_ti"){		
        $menu = "<li><a href=\" /eu-facture-smcipnwi/new\">Investissement</a></li>" .
                "<li><a href=\" /eu-facture-smcipnwi \">Factures impayées</a></li>" .
                "<li><a href=\" /eu-facture-smcipnwi/facturepayer \">Factures payées</a></li>";
				}
				
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'acteur' && $group != 'acteur_pbf' && $group != 'smc_tpn' && $group != 'fn_ti') {
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
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100000);
        $sidx = $this->_request->getParam("sidx", 'date_facture');
        $sord = $this->_request->getParam("sord", 'asc');
        $table = new Application_Model_DbTable_EuFactureSmcipn();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->from(array('f' => 'EU_fACTURE_SMCIPN'), array('*', "to_char((f.DATE_fACTURE),'dd/mm/yyyy HH24:mi') DATE_fACTURE"))
                ->join(array('d' => 'EU_dOMICILIATION'), 'd.COdE_SMCIPN = f.COdE_SMCIPN', array('COdE_dOMICILIER', 'COdE_SMCIPN', 'Id_PROPOSITION'))
                ->join(array('p' => 'EU_pROpOSITION'), 'd.Id_pROpOSITION = p.Id_pROpOSITION', array('p.Id_pROpOSITION', 'p.Id_AppEL_OFFRE'))
                ->join(array('a' => 'EU_appEL_OFFRE'), 'a.ID_appEL_OFFRE = p.ID_appEL_OFFRE', array('ID_appEL_OFFRE', 'numero_offre', 'NOM_appEL_OFFRE'))
                ->where('p.CHOIX_pROpOSITION = ?', 1)
                ->where('f.ETAT_fACTURE = ?', 0);
        $fact = $table->fetchAll($select);
        $count = count($fact);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $fact = $table->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $tot_facture = 0;
        foreach ($fact as $row) {
            $tot_facture+=$row->mont_facture;
            $responce['rows'][$i]['id'] = $row->code_facture;
            $responce['rows'][$i]['cell'] = array(
                $row->code_facture,
                ucfirst($row->nom_appel_offre),
                $row->code_membre_morale,
                ucfirst($row->type_facture),
                $row->date_facture,
                $row->mont_facture,
            );
            $i++;
        }
        $responce['userdata']['code_facture'] = 'Total:';
        $responce['userdata']['mont_facture'] = $tot_facture;
        $this->view->data = $responce;
    }

    public function facturepayerAction() {
        
    }

    public function facturepayerlistAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100000);
        $sidx = $this->_request->getParam("sidx", 'date_facture');
        $sord = $this->_request->getParam("sord", 'asc');
        $table = new Application_Model_DbTable_EuFactureSmcipn();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->from(array('f' => 'EU_fACTURE_SMCIPN'), array('*', "to_char((f.DATE_fACTURE),'dd/mm/yyyy hh:mm') DATE_fACTURE"))
                ->join(array('d' => 'EU_dOMICILIATION'), 'd.COdE_SMCIPN = f.COdE_SMCIPN', array('COdE_dOMICILIER', 'COdE_SMCIPN', 'Id_PROPOSITION'))
                ->join(array('p' => 'EU_pROpOSITION'), 'd.Id_pROpOSITION = p.Id_pROpOSITION', array('p.Id_pROpOSITION', 'p.Id_AppEL_OFFRE'))
                ->join(array('a' => 'EU_appEL_OFFRE'), 'a.ID_appEL_OFFRE = p.ID_appEL_OFFRE', array('ID_appEL_OFFRE', 'numero_offre', 'NOM_appEL_OFFRE'))
                ->where('p.CHOIX_pROpOSITION = ?', 1)
                ->where('f.ETAT_fACTURE = ?', 1);
        $fact = $table->fetchAll($select);
        $count = count($fact);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $fact = $table->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $tot_facture = 0;
        foreach ($fact as $row) {
            $tot_facture+=$row->mont_facture;
            $responce['rows'][$i]['id'] = $row->code_facture;
            $responce['rows'][$i]['cell'] = array(
                $row->code_facture,
                ucfirst($row->nom_appel_offre),
                $row->code_membre_morale,
                ucfirst($row->type_facture),
                $row->date_facture,
                $row->mont_facture,
            );
            $i++;
        }
        $responce['userdata']['code_facture'] = 'Total:';
        $responce['userdata']['mont_facture'] = $tot_facture;
        $this->view->data = $responce;
    }

    public function newAction() {
        //$form = new Application_Form_EuBudgetInvestissement();
        //$this->view->form = $form;
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

    public function listprodAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_smcipn = $request->code_smcipn;
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'libelle_produit');
        $sord = $this->_request->getParam("sord", 'desc');
        //Récupération de l'id_proposition dans la table eu_domiciliation
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $find_propo = $mdo->findBySmcipn($code_smcipn);
        $id_propo = '';
        if ($find_propo != null) {
            $id_propo = $find_propo->getId_proposition();
        }
        //Récupération des produits lié à la proposition financière
        $tabela = new Application_Model_DbTable_EuDetailProposition();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('eu_detail_proposition.id_proposition = ?', $id_propo);
        $produit = $tabela->fetchAll($select);
        $count = count($produit);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $produit = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($produit as $row) {
            $responce['rows'][$i]['id'] = $row->id_detail_proposition;
            $responce['rows'][$i]['cell'] = array(
                $row->id_detail_proposition,
                $row->id_proposition,
                ucfirst($row->libelle_produit),
                $row->code_membre_morale,
                $row->type_produit,
                $row->mdv,
                ucfirst($row->unite_mesure),
                $row->prix_unitaire,
                $row->quantite,
                $row->prix_unitaire * $row->quantite
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function offrechangeAction() {
        $mfacture = new Application_Model_EuFactureSmcipnMapper();
        $data = array();
        $table = new Application_Model_DbTable_EuSmcipnpwi();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->from(array('s' => 'EU_sMCIPNPWI'), array('*'))
                ->join(array('d' => 'EU_dOMICILIATION'), 'd.COdE_sMCIPN = s.COdE_sMCIPN', array('COdE_dOMICILIER', 'COdE_sMCIPN', 'Id_PROPOsITION'))
                ->join(array('p' => 'EU_pROpOSITION'), 'd.Id_pROpOSITION = p.Id_pROpOSITION', array('p.Id_pROpOSITION', 'p.Id_AppEL_OFFRE'))
                ->join(array('a' => 'EU_appEL_OFFRE'), 'a.ID_appEL_OFFRE = p.ID_appEL_OFFRE', array('ID_appEL_OFFRE', 'numero_offre', 'NOM_appEL_OFFRE'))
                ->where('p.CHOIX_pROpOSITION = ?', 1);
        $bes = $table->fetchAll($select);
        $i = 0;
        foreach ($bes as $value) {
            $tot_smc = $value->mont_salaire + $value->mont_investis;
            $tot_facture = $mfacture->findtotalbysmcipn($value->code_smcipn);
            if ($tot_facture < $tot_smc) {
                $data[$i][1] = $value->code_smcipn;
                $data[$i][2] = ucfirst($value->nom_appel_offre);
            }
            $i++;
        }
        $this->view->data = $data;
    }

    public function changemoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre_morale;
        }
        $this->view->data = $data;
    }

    public function budgetinvestisAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_create = clone $date;
        $fact = new Application_Model_EuFactureSmcipn();
        $mfact = new Application_Model_EuFactureSmcipnMapper();
        $dfact = new Application_Model_EuFactureSmcipnDetail();
        $mdfact = new Application_Model_EuFactureSmcipnDetailMapper();
        $selection = array();
        $code_smcipn = $_GET['code_smcipn'];
        $selection = $_GET['lignes'];
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Calcul du total de la facturation
                $mt_facture = 0;
                foreach ($selection as $val) {
                    $mt_facture += $val['total'];
                }
                //Récupération du code membre du client bénéficiaire de la subvention
                $smc = new Application_Model_EuSmcipnpwi();
                $msmc = new Application_Model_EuSmcipnpwiMapper();
                $find_smc = $msmc->find($code_smcipn, $smc);
                if ($find_smc) {
                    $code_membre = $smc->getCode_membre();
                }
                //Enregistrement dans la table eu_facture_smcipn
                $code_facture = 'f' . $date->tostring('yyMMddHHmmss');
                $fact->setCode_facture($code_facture)
                        ->setCode_membre_morale($code_membre)
                        ->setDate_facture($date->toString('yyyy-mm-dd hh:mm:ss'))
                        ->setMont_facture($mt_facture)
                        ->setEtat_facture(0)
                        ->setType_facture('Investissement')
                        ->setCode_smcipn($code_smcipn)
                        ->setId_utilisateur($user->id_utilisateur);
                $mfact->save($fact);
                //Enregistrement et cumul du montant des produits par fournisseur
                foreach ($selection as $sel) {
                    //Vérifié l'existence de la facture
                    $find_factf = $mdfact->findByFactureFournis($code_facture, $sel['distributeur']);
                    if ($find_factf == false) {
                        $id_facture_detail = $mdfact->findConuter() + 1;
                        $dfact->setId_facture_detail($id_facture_detail)
                                ->setCode_facture($code_facture)
                                ->setCode_membre_fournisseur($sel['distributeur'])
                                ->setMont_investis($sel['total'])
                                ->setInvestis_alloue(0)
                                ->setSolde_investis($sel['total'])
                                ->setCode_membre_salarier(null)
                                ->setMont_salaire(0)
                                ->setSalaire_alloue(0)
                                ->setSolde_salaire(0);
                        $mdfact->save($dfact);
                    } else {
                        $dfact->setMont_investis($dfact->getMont_investis() + $sel['total'])
                                ->setSolde_investis($dfact->getSolde_investis() + $sel['total']);
                        $mdfact->update($dfact);
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
    }

    public function salaireAction() {
        
    }

    public function membrephysAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->PREnom_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function montantdispoAction() {
        //Récupération du montant total du projet
        $code_smcipn = $_GET["code_smcipn"];
        $fact = new Application_Model_EuFactureSmcipn();
        $mfact = new Application_Model_EuFactureSmcipnMapper();
        $smc = new Application_Model_EuSmcipnpwi();
        $msmc = new Application_Model_EuSmcipnpwiMapper();
        $find_smc = $msmc->find($code_smcipn, $smc);
        $mt_smcipn = $smc->getMont_investis() + $smc->getMont_salaire();
        $mt_percu = $mfact->findtotalbysmcipn($code_smcipn);
        $mt_dispo = $mt_smcipn - $mt_percu;
        $data = number_format($mt_dispo, 0, ',', '');
        $this->view->data = $data;
    }

    public function budgetsalaireAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $fact = new Application_Model_EuFactureSmcipn();
        $mfact = new Application_Model_EuFactureSmcipnMapper();
        $dfact = new Application_Model_EuFactureSmcipnDetail();
        $mdfact = new Application_Model_EuFactureSmcipnDetailMapper();
        if ($this->getRequest()->isPost()) {
            $code_smcipn = $_POST['id_proposition'];
            $selection = $_POST['cpteur'];
            $mt_dispo = $_POST['mt_dispo'];
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Calcul du total de la facturation
                $mt_facture = 0;
                for ($j = 1; $j <= $selection; $j++) {
                    $mt_facture+=$_POST["salaire$j"];
                }
                //Récupération du code membre du client bénéficiaire de la subvention
                $smc = new Application_Model_EuSmcipnpwi();
                $msmc = new Application_Model_EuSmcipnpwiMapper();
                $find_smc = $msmc->find($code_smcipn, $smc);
                if ($find_smc) {
                    $code_membre = $smc->getCode_membre();
                }
                if ($mt_facture > $mt_dispo) {
                    $this->view->data = 'sal_inf';
                    return;
                } else {
                    //Enregistrement dans la table eu_facture_smcipn
                    $code_facture = 'f' . $date->tostring('yyMMddHHmmss');
                    $fact->setCode_facture($code_facture)
                            ->setCode_membre_morale($code_membre)
                            ->setDate_facture($date->toString('yyyy-mm-dd hh:mm:ss'))
                            ->setMont_facture($mt_facture)
                            ->setEtat_facture(0)
                            ->setType_facture('Salaire')
                            ->setCode_smcipn($code_smcipn)
                            ->setId_utilisateur($user->id_utilisateur);
                    $mfact->save($fact);
                    //Enregistrement et cumul du montant des produits par fournisseur
                    for ($j = 1; $j <= $selection; $j++) {
                        //Vérifié l'existence du salarier sur cette facture
                        $find_factf = $mdfact->findByFactureSalaire($code_facture, $_POST["num_membre$j"]);
                        if ($find_factf == false) {
                            $id_facture_detail = $mdfact->findConuter() + 1;
                            $dfact->setId_facture_detail($id_facture_detail)
                                    ->setCode_facture($code_facture)
                                    ->setCode_membre_fournisseur(null)
                                    ->setMont_investis(0)
                                    ->setInvestis_alloue(0)
                                    ->setSolde_investis(0)
                                    ->setCode_membre_salarier($_POST["num_membre$j"])
                                    ->setMont_salaire($_POST["salaire$j"])
                                    ->setSalaire_alloue(0)
                                    ->setSolde_salaire($_POST["salaire$j"]);
                            $mdfact->save($dfact);
                        } else {
                            $dfact->setMont_salaire($dfact->getMont_salaire() + $_POST["salaire$j"])
                                    ->setSolde_salaire($dfact->getSolde_salaire() + $_POST["salaire$j"]);
                            $mdfact->update($dfact);
                        }
                    }
                    $db->commit();
                    $this->view->data = 'good';
                    return;
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->data = 'bad';
                return;
            }
        }
    }

    public function detailfactureAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 30);
        $sidx = $this->_request->getParam("sidx", 'id_facture_detail');
        $sord = $this->_request->getParam("sord", 'asc');
        $request = $this->getRequest();
        $code_facture = $request->code_facture;
        $type_facture = $request->type_facture;
        $tabela = new Application_Model_DbTable_EuFactureSmcipnDetail();
        $select = $tabela->select();
        if ($type_facture == 'Salaire') {
            $select->setIntegrityCheck(false)
                    ->from(array('d' => 'EU_FACTURE_SMCIPN_dETAIL'), '*')
                    ->join(array('m' => 'EU_mEmBRE'), 'm.COdE_mEmBRE = d.COdE_mEmBRE_SALARIER', array('COdE_mEmBRE', 'NOm_mEmBRE', 'PRENOm_mEmBRE'))
                    ->where('d.COdE_FACTURE = ?', $code_facture);
            $dfact = $tabela->fetchAll($select);
            $count = count($dfact);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }
            if ($page > $total_pages)
                $page = $total_pages;

            $dfact = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($dfact as $row) {
                $responce['rows'][$i]['id'] = $row->id_facture_detail;
                $responce['rows'][$i]['cell'] = array(
                    $row->id_facture_detail,
                    $row->code_membre,
                    strtoupper($row->nom_membre) . ' ' . ucfirst($row->PREnom_membre),
                    $row->mont_salaire
                );
                $i++;
            }
            $this->view->data = $responce;
        } else if ($type_facture == 'Investissement') {
            $select->setIntegrityCheck(false)
                    ->from(array('d' => 'EU_FACTURE_SMCIPN_dETAIL'), '*')
                    ->join(array('m' => 'EU_mEmBRE_mORALE'), 'm.COdE_mEmBRE_mORALE = d.COdE_mEmBRE_FOURNISSEUR', array('COdE_mEmBRE_mORALE', 'raison_sociale'))
                    ->where('d.COdE_FACTURE = ?', $code_facture);
            $dfact = $tabela->fetchAll($select);
            $count = count($dfact);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }
            if ($page > $total_pages)
                $page = $total_pages;

            $dfact = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($dfact as $row) {
                $responce['rows'][$i]['id'] = $row->id_facture_detail;
                $responce['rows'][$i]['cell'] = array(
                    $row->id_facture_detail,
                    $row->code_membre_morale,
                    ucfirst($row->raison_sociale),
                    $row->mont_investis
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

}

?>
