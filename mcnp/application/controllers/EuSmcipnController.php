<?php

class EuSmcipnController extends Zend_Controller_Action {

//put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'gac' || $group == 'gacp' || $group == 'gacse' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
            $menu = "<li><a id=\"recu_act\" href=\"#\">SMCIPNwi reçus</a></li>" .
                    "<li><a id=\"salaireaff\" href=\"/eu-smcipn/sallaireaff \">Salaires affectés</a></li>" .
                    "<li><a id=\"investaff\" href=\"/eu-smcipn/investaffecte \">Investissements payés</a></li>" .
                    "<li><a id=\"domi\" href=\"#\">Domiciliations</a></li>" .
                    "<li><a href=\"/eu-smcipn/myalerte\">Mes alertes</a></li>" .
                    "<li><a href=\"/eu-smcipn/alertes\">Alertes en attentes</a></li>";
        } elseif ($group == 'filiere' || $group == 'creneau') {
            $menu = "<li><a id=\"smcipn\" href=\"#\">Liste des SMCIPNwi</a></li>";
        } elseif ($group == 'acteur') {
            $menu = "<li><a href=\"/eu-smcipn/mesrecu\">SMCIPNwi reçus</a></li>" .
                    "<li><a id=\"salaireaff\" href=\"#\">Salaires affectés</a></li>" .
                    "<li><a id=\"investaff\" href=\"/eu-smcipn/investaffecte \">Investissements payés</a></li>" .
                    "<li><a id=\"domi\" href=\"#\">Domiciliations</a></li>" .
                    "<li><a href=\"/eu-smcipn/myalerte\">Mes alertes</a></li>";
        } elseif ($group == 'gac_pbf' || $group == 'gacp_pbf' || $group == 'gacse_pbf' || $group == 'gacr_pbf' || $group == 'gacs_pbf' || $group == 'gaca_pbf') {
            $menu = "<li><a id=\"recu_act\" href=\"#\">SMCIPNwi reçus</a></li>" .
                    "<li><a id=\"salaireaff\" href=\"/eu-smcipn/sallaireaff \">Salaires affectés</a></li>" .
                    "<li><a href=\"/eu-smcipn/investaffecte\">Investissements payés</a></li>" .
                    "<li><a id=\"domi\" href=\"#\">Domiciliations</a></li>" .
                    "<li><a href=\"/eu-smcipn/myalerte\">Mes alertes</a></li>" .
                    "<li><a href=\"/eu-smcipn/alertes\">Alertes en attentes</a></li>";
        } elseif ($group == 'filiere_pbf' || $group == 'creneau_pbf') {
            $menu = "<li><a href=\"/eu-smcipn/demande2\">Liste des SMCIPNwi</a></li>";
        } elseif ($group == 'acteur_pbf') {
            $menu = "<li><a id=\"recu_act\" href=\"#\">SMCIPNwi reçus</a></li>" .
                    "<li><a id=\"salaireaff\" href=\"#\">Salaires affectés</a></li>" .
                    "<li><a id=\"investaff\" href=\"/eu-smcipn/investaffecte \">Investissements payés</a></li>" .
                    "<li><a id=\"domi\" href=\"#\">Domiciliations</a></li>" .
                    "<li><a href=\"/eu-smcipn/myalerte\">Mes alertes</a></li>";
        } elseif ($group == 'gacex' || $group == 'acnev' || $group == 'surveillance' ||  $group == 'detentrice_filiere') {
            $menu = "<li><a href=\"/eu-smcipn/ajoutfrais\">Ajout frais</a></li>" .
                    "<li><a href=\"/eu-smcipn/frais\">Frais de surveillance</a></li>";
                    //"<li><a href=\"/eu-smcipn/factureimpaye\">Factures en attente</a></li>" .
                   // "<li><a href=\"/eu-smcipn/facturepayer\">Factures payées</a></li>" .
                   // "<li><a href=\"/eu-smcipn/mesrecu\">SMCIPNwi reçus</a></li>" .
                    //"<li><a id=\"salaireaff\" href=\"#\">Salaires affectés</a></li>" .
                   // "<li><a id=\"investaff\" href=\"/eu-smcipn/investaffecte \">Investissements payés</a></li>" .
                   // "<li><a id=\"domi\" href=\"#\">Domiciliations</a></li>" .
                   // "<li><a href=\"/eu-smcipn/myalerte\">Mes alertes</a></li>";
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
            if ($group != 'gac' && $group != 'gacp' && $group != 'gacse' && $group != 'gacr' && $group != 'gacs' && $group != 'gaca' && $group != 'filiere' && $group != 'creneau' && $group != 'acteur' &&
                    $group != 'filiere_pbf' && $group != 'gac_pbf' && $group != 'gacp_pbf' && $group != 'gacse_pbf' && $group != 'gacr_pbf' && $group != 'gacs_pbf' && $group != 'gaca_pbf' && $group != 'creneau_pbf' && $group != 'acteur_pbf' && $group != 'gacex' && $group != 'acnev' && $group != 'surveillance') {
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
        $limit = $this->_request->getParam("rows", 1000);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->where('eu_smcipn.id_utilisateur = ?', $user->id_utilisateur)
                ->where('eu_smcipn.rembourser = ?', 0);
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->where('eu_smcipn.code_membre like ?', $user->code_membre)
                ->where('eu_smcipn.rembourser = ?', 0);
        $select->union(array($select1, $select2))
                ->order('date_demande', 'desc');
        $smcipn1 = $tabela->fetchAll($select);
        $count = count($smcipn1);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;

        $smcipn = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $heure_dem = new Zend_Date($row->heure_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' (jours)',
                $row->montant_salaire,
                $row->montant_investis,
                $date_dem->toString('dd/mm/yyyy'),
                $heure_dem->toString('hh:mm'),
                $row->type_smcipn
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function demandeAction() {
        $this->_helper->layout->disableLayout();
    }

    public function demande2Action() {
        
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
        $pforma = $tabel->fetchAll($sel);
        $rep = array();
        $i = 0;
        foreach ($pforma as $row) {
            $rep[$i] = $row->code_pforma;
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

    public function listbudgetAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_dem = $request->dema;
        $mt_inves = $request->investis;

        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        if ($mt_inves > 0) {
            //Récupération de id_besoin
            $smcipn_db = new Application_Model_DbTable_EuSmcipn();
            $smcipn_find = $smcipn_db->find($code_dem);
            if (count($smcipn_find) == 1) {
                $result = $smcipn_find->current();
                $besoin = $result->id_besoin;
                if ($besoin != '' || $besoin != null) {
                    //Récupération des factures proforma liés à l'id_besoin trouvé
                    $tabel = new Application_Model_DbTable_EuProforma();
                    $sel = $tabel->select();
                    $sel->where('eu_proforma.id_besoin =?', $besoin);
                    $pforma = $tabel->fetchAll($sel);
                    $rep = array('');
                    $i = 0;
                    foreach ($pforma as $row) {
                        $rep[$i] = $row->code_proforma;
                        $i++;
                    }
                    $select = "select id_porter, p.id_objet, code_proforma, pu_objet, qte_objet, remise,boutique,rayon, design_objet from eu_porter p join eu_objet o on p.id_objet=o.id_objet where code_proforma in (select code_proforma from eu_proforma where id_besoin='$besoin')";
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

                        if ($row->rayon != '') {
                            $bout = $row->boutique . ' / ' . $row->rayon;
                        } else {
                            $bout = $row->boutique;
                        }
                        $responce['rows'][$i]['id'] = $row->id_porter;
                        $responce['rows'][$i]['cell'] = array(
                            $row->id_porter,
                            $row->code_proforma,
                            $row->id_objet,
                            ucfirst($row->design_objet),
                            $bout,
                            $row->pu_objet,
                            $row->qte_objet,
                            $row->remise,
                            $tot - ($tot * $row->remise / 100),
                            $code_dem,
                        );
                        $i++;
                    }
                    $this->view->data = $responce;
                }
            }
        } else {
            $this->view->data = 'no_besoin';
        }
    }

    public function traiterAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_create = clone $date;
        $selection = array();
        $selection = $_GET['lignes'];
        $bfm = New Application_Model_EuBudgetFactureMapper();
        $bf = new Application_Model_EuBudgetFacture();
        $bim = New Application_Model_EuInvestissementMapper();
        $bi = new Application_Model_EuInvestissement();
        $mpor = New Application_Model_EuPorterMapper();
        $por = new Application_Model_EuPorter();
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Récupération du total de l'investissement
            $mt_fixe = 0;
            $mt_circul = 0;
            $id_besoin = 0;
            //Calcul du total des i fixe et circulant
            //$val = array();
            foreach ($selection as $val) {
                if ($val['type'] == 'Fixe') {
                    $mt_fixe += $val['total'];
                } else if ($val['type'] == 'Circulant') {
                    $mt_circul += $val['total'];
                }
                $id_besoin = $val['besoin'];
            }
            $count = $bim->findConuter() + 1;
            //Insertion dans la table investissement
            if ($mt_fixe != 0) {
                $bi->setId_investissement($count);
                $bi->setMontant_budget($mt_fixe);
                $bi->setCat_objet('fixe');
                $bi->setDate_investissement($date_create->toString('yyyy-mm-dd'));
                $bi->setId_utilisateur($user->id_utilisateur);
                $bi->setId_besoin($id_besoin);
                $bi->setCode_smcipn('');
                $bim->save($bi);
            }
            if ($mt_circul != 0) {
                $bi->setId_investissement($count);
                $bi->setMontant_budget($mt_circul);
                $bi->setCat_objet('circulant');
                $bi->setDate_investissement($date_create->toString('yyyy-mm-dd'));
                $bi->setId_utilisateur($user->id_utilisateur);
                $bi->setId_besoin($id_besoin);
                $bi->setCode_smcipn('');
                $bim->save($bi);
            }
            //$sel = array();
            foreach ($selection as $sel) {
                //Tester l'existence du budget facture
                $find_bf = $bfm->find($sel['id_objet'], $sel['code_proforma'], $bf);
                if ($find_bf != false) {
                    $this->view->retour = 'erreur';
                    return;
                } else {
                    $bf->setId_objet($sel['id_objet']);
                    $bf->setCode_proforma($sel['code_proforma']);
                    $bf->setPu_objet($sel['pu_objet']);
                    $bf->setQte_objet($sel['qte_objet']);
                    $bf->setRemise_objet($sel['remise']);
                    $bf->setCat_objet($sel['type']);
                    $bf->setId_besoin($id_besoin);
                    $bf->setId_investissement($count);
                    $bfm->save($bf);
                }
                //Mise à jour de la table des produits
                $por_find = $mpor->find($sel['id_porter'], $por);
                if ($por_find == true) {
                    $por->setDisponible(1);
                    $mpor->update($por);
                }
            }
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            $this->view->data = $message;
            $this->view->data = 'bad';
            return;
        }
    }

    public function budgetAction() {

        $selection = array();
        $selection = $_GET['lignes'];
        $bfm = New Application_Model_EuBudgetFactureMapper();
        $bf = new Application_Model_EuBudgetFacture();
        //Récupération du total de l'investissement
        $mt_inves = 0;
        $code_demand = 0;
        foreach ($selection as $val) {
            $mt_inves+=$val['total'];
            $code_demand = $val['code_dem'];
        }
        //Vérification de l'investissement avec celui de la demande
        $smcipn_db = new Application_Model_DbTable_EuSmcipn();
        $smcipn_find = $smcipn_db->find($code_demand);
        $result = $smcipn_find->current();
        $inves_init = $result->mt_investis;
        if ($mt_inves != $inves_init) {
            $this->view->data = 'inves';
            return;
        } else {
            $sel = array();
            foreach ($selection as $sel) {
                $mt_inves+=$sel['total'];
                $bf->setId_objet($sel['id_objet']);
                $bf->setCode_proforma($sel['code_proforma']);
                $bf->setPu_objet($sel['pu_objet']);
                $bf->setQte_objet($sel['qte_objet']);
                $bf->setRemise_objet($sel['remise']);
                $bf->setCode_demand($code_demand);
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $bfm->save($bf);
                    $db->commit();
                    $this->view->data = 'good';
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                    $this->view->message = $message;
                    $this->view->data = 'erreur';
                    return;
                }
            }
        }
    }

    public function listdemandAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_smcipn');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();
        $group = $user->code_groupe;
        $num = $user->code_acteur;
        if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca' || $group == 'gac_pbf' || $group == 'gacp_pbf' || $group == 'gacr_pbf' || $group == 'gacs_pbf' || $group == 'gaca_pbf') {
            $condi1 = 'eu_smcipn.source_demande=?';
            $source = 'filiere';
            //Formation de la sous requête
            $tabel = new Application_Model_DbTable_EuGacFiliere();
            $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('code_gac = ?', $num);
            $listfil = $tabel->fetchAll($sel);
            $rep = array('');
            $mb = array('');
            $i = 0;
            foreach ($listfil as $row) {
                $rep[$i] = $row->code_gac_filiere;
                $mb[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des demandes de la smcipn des gac filières
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_smcipn.valid_gac = ?', 0)
                    ->where($condi1, $source)
                    ->where('eu_smcipn.code_membre in (?)', $mb);
            //Récupération du code des créneaux liés aux filières
            $tabelc = new Application_Model_DbTable_EuCreneau();
            $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selc->setIntegrityCheck(false)
                    ->where('code_gac_filiere in (?)', $rep);
            $listcre = $tabelc->fetchAll($selc);
            $ccre = array('');
            $cde = array('');
            $i = 0;
            foreach ($listcre as $row) {
                $ccre[$i] = $row->code_creneau;
                $cde[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des demandes des créneaux d'activités
            $select2 = $tabela->select();
            $select2->setIntegrityCheck(false)
                    ->where('eu_smcipn.valid_gac = ?', 0)
                    ->where('eu_smcipn.valid_fil = ?', 1)
                    ->where('eu_smcipn.code_membre in (?)', $cde);
            //Récupération des numéros membre des acteurs liés aux créneaux
            $tabeld = new Application_Model_DbTable_EuActeurCreneau();
            $seld = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $seld->setIntegrityCheck(false)
                    ->where('code_creneau in (?)', $ccre);
            $listact = $tabeld->fetchAll($seld);
            $repc = array('');
            $i = 0;
            foreach ($listact as $row) {
                $repc[$i] = $row->code_membre;
                $i++;
            }
            //Affichage des demandes en attentes de validation et validées par les filières
            $select3 = $tabela->select();
            $select3->setIntegrityCheck(false)
                    ->where('eu_smcipn.valid_gac = ?', 0)
                    ->where('eu_smcipn.valid_fil = ?', 1)
                    ->where('eu_smcipn.code_membre in (?)', $repc);
            //Récupération des demandes de subventions des acteurs non validées par la filière et le créneau
            $select4 = $tabela->select();
            $select4->setIntegrityCheck(false)
                    ->where('eu_smcipn.valid_gac = ?', 0)
                    ->where('eu_smcipn.valid_fil = ?', 0)
                    ->where('eu_smcipn.valid_creneau = ?', 0)
                    ->where('eu_smcipn.source_demande = ?', 'acteur')
                    ->where('eu_smcipn.code_membre in (?)', $repc);
            //Récupération des acteurs directement liés aux gac filières
            $tabact = new Application_Model_DbTable_EuActeurCreneau();
            $selact = $tabact->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selact->setIntegrityCheck(false)
                    ->where('code_gac_filiere in (?)', $rep);
            $listact = $tabact->fetchAll($selact);
            $mbact = array('');
            $i = 0;
            foreach ($listact as $row) {
                $mbact[$i] = $row->code_membre;
                $i++;
            }
            $select5 = $tabela->select();
            $select5->setIntegrityCheck(false)
                    ->where('eu_smcipn.valid_gac = ?', 0)
                    ->where('eu_smcipn.valid_fil = ?', 1)
                    ->where('eu_smcipn.valid_creneau = ?', 0)
                    ->where('eu_smcipn.source_demande = ?', 'acteur')
                    ->where('eu_smcipn.code_membre in (?)', $mbact);
            $select->setIntegrityCheck(false)
                    ->union(array($select5, $select4, $select3, $select2, $select1));
            $smcipn = $tabela->fetchAll($select);
        } elseif ($group == 'filiere' || $group == 'filiere_pbf') {
            $cond = 'eu_smcipn.valid_fil = ?';
            $condi = 'eu_smcipn.valid_creneau = ?';
            $condi1 = 'eu_smcipn.source_demande = ?';
            $source = 'creneau';
            //Formation de la sous requête
            $tabel = new Application_Model_DbTable_EuCreneau();
            $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('code_gac_filiere = ?', $num);
            $listcre = $tabel->fetchAll($sel);
            $rep = array('');
            $mb = array('');
            $i = 0;
            foreach ($listcre as $row) {
                $rep[$i] = $row->code_creneau;
                $mb[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des demandes des créneaux d'activités
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where($cond, 0)
                    ->where($condi1, $source)
                    ->where('eu_smcipn.code_membre in (?)', $mb);
            //Récupération des numéros membre des acteurs liés aux créneaux
            $tabelc = new Application_Model_DbTable_EuActeurCreneau();
            $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selc->setIntegrityCheck(false)
                    ->where('code_creneau in (?)', $rep);
            $listact = $tabelc->fetchAll($selc);
            $repc = array('');
            $i = 0;
            foreach ($listact as $row) {
                $repc[$i] = $row->code_membre;
                $i++;
            }
            //Affichage des demandes en attentes de validation et validées par les créneaux
            $select2 = $tabela->select();
            $select2->setIntegrityCheck(false)
                    ->where($cond, 0)
                    ->where($condi, 1)
                    ->where('eu_smcipn.code_membre in (?)', $repc);
            //Récupération des demandes de subventions des acteurs non validées par le créneau
            $select3 = $tabela->select();
            $select3->setIntegrityCheck(false)
                    ->where('eu_smcipn.valid_fil = ?', 0)
                    ->where('eu_smcipn.valid_creneau = ?', 0)
                    ->where('eu_smcipn.source_demande = ?', 'acteur')
                    ->where('eu_smcipn.code_membre in (?)', $repc);
            //Récupération des acteurs directement liés à la gac filière
            $tabact = new Application_Model_DbTable_EuActeurCreneau();
            $selact = $tabact->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selact->setIntegrityCheck(false)
                    ->where('code_gac_filiere = ?', $num);
            $listact = $tabact->fetchAll($selact);
            $mbact = array('');
            $i = 0;
            foreach ($listact as $row) {
                $mbact[$i] = $row->code_membre;
                $i++;
            }
            $select4 = $tabela->select();
            $select4->setIntegrityCheck(false)
                    ->where('eu_smcipn.valid_fil = ?', 0)
                    ->where('eu_smcipn.valid_creneau = ?', 0)
                    ->where('eu_smcipn.source_demande = ?', 'acteur')
                    ->where('eu_smcipn.code_membre in (?)', $mbact);
            $select->setIntegrityCheck(false)
                    ->union(array($select4, $select3, $select2, $select1));
            $smcipn = $tabela->fetchAll($select);
        } elseif ($group == 'creneau' || $group == 'creneau_pbf') {
            $cond = 'eu_smcipn.valid_creneau = ?';
            $condi1 = 'eu_smcipn.source_demande=?';
            $source = 'acteur';

            //Formation de la sous requête
            $tabel = new Application_Model_DbTable_EuActeurCreneau();
            $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('code_creneau = ?', $num);
            $listcre = $tabel->fetchAll($sel);
            $rep = array('');
            $i = 0;
            foreach ($listcre as $row) {
                $rep[$i] = $row->code_membre;
                $i++;
            }
            //Affichage des demandes en attentes de validation
            $select->setIntegrityCheck(false)
                    ->where($cond, 0)
                    ->where($condi1, $source)
                    ->where('eu_smcipn.code_membre in (?)', $rep)
                    ->order('eu_smcipn.code_smcipn', 'asc');
            $smcipn = $tabela->fetchAll($select);
        } elseif ($group == 'acteur' || $group == 'acteur_pbf') {
            $cond = 'eu_smcipn.valid_creneau = ?';
            //Affichage des demandes en attentes de validation
            $select->setIntegrityCheck(false)
                    ->where($cond, 0)
                    ->order('eu_smcipn.code_smcipn', 'asc');
            $smcipn = $tabela->fetchAll($select);
        }

        $count = count($smcipn);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipn = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($smcipn as $row) {
            if ($row->valid_fil == 0) {
                $valid = 'ko';
            } else {
                $valid = 'ok';
            }
            if ($row->valid_creneau == 0) {
                $valid1 = 'ko';
            } else {
                $valid1 = 'ok';
            }
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $heure_dem = new Zend_Date($row->heure_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                $row->montant_investis,
                $date_dem->toString('dd/mm/yyyy'),
                $heure_dem->toString('hh:mm'),
                $valid . ' - ' . $valid1,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {

        $request = $this->getRequest();
        $form = new Application_Form_EuSmcipn();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_demand = clone $date_id;
                $smcipn = new Application_Model_EuSmcipn($form->getValues());
                $smcipn->setDate_demande($date_demand->toString('yyyy-mm-dd'));
                $smcipn->setHeure_demande($date_demand->toString('hh:mm'));
                $smcipn->setCode_membre($user->code_membre);
                $smcipn->setEtat_demande_inv(0);
                $smcipn->setId_utilisateur($user->id_utilisateur);
                $smcipn->setValid_gac(0);
                $smcipn->setValid_fil(0);
                $smcipn->setValid_creneau(0);
                $smcipn->setAlloc_gac_inv(0);
                $smcipn->setAlloc_fil_inv(0);
                $smcipn->setAlloc_creneau_inv(0);
                $smcipn->setDomicilier(0);
                $smcipn->setRembourser(0);
                $smcipn->setAllouer_i(0);
                $smcipn->setAllouer_s(0);
                if ($this->_request->getPost("unite_mdv") == 'jour') {
                    $nb_periode = $this->_request->getPost("mdv") / 30;
                } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                    $nb_periode = $this->_request->getPost("mdv");
                } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                    $nb_periode = (365.25 / 30) * $this->_request->getPost("mdv");
                }
                $smcipn->setDvm_demande($nb_periode);

                $group = $user->code_groupe;
                if ($this->_request->getPost("montant_salaire") == '') {
                    $smcipn->setMontant_salaire(0);
                }
                if ($this->_request->getPost("montant_investis") == '') {
                    $smcipn->setMontant_salaire(0);
                }
                if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
                    $smcipn->setSource_demande('gac');
                } elseif ($group == 'filiere') {
                    $smcipn->setSource_demande('filiere');
                } elseif ($group == 'creneau') {
                    $smcipn->setSource_demande('creneau');
                } elseif ($group == 'acteur') {
                    $smcipn->setSource_demande('acteur');
                }
                //Contrôle de l'existence des doublons
                $smcipn_db = new Application_Model_DbTable_EuSmcipn();
                $smcipn_find = $smcipn_db->find($this->_request->getPost("code_demand"));
                if (count($smcipn_find) == 1) {
                    $message = 'Ce code existe déjà.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                } else {
                    $sm = new Application_Model_EuSmcipnMapper();
                    $sm->save($smcipn);
                    return $this->_helper->redirector('index');
                }
            }
        }
// Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-smcipn',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function numgacAction() {
        $gac = array();
        $tab = new Application_Model_DbTable_EuGac();
        $sel = $tab->select();
        $sel->where('groupe=?', 'gac');
        $sel->order('date_creation', 'desc');
        $ngac = $tab->fetchAll($sel);
        $i = 0;
        foreach ($ngac as $value) {
            $gac[$i][1] = $value->code_gac;
            $gac[$i][2] = ucfirst($value->nom_gac);
            $i++;
        }
        $this->view->data = $gac;
    }

    public function codesmciAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $prk = 0;
        $pck = 1;
        //Récupération de la prk et de la pck pour les nr
        $param = new Application_Model_EuParametresMapper();
        $par = new Application_Model_EuParametres();
        $par_prk = $param->find('prk', 'nr', $par);
        if ($par_prk == true) {
            $prk = $par->getMontant();
        }
        $par_pck = $param->find('pck', 'nr', $par);
        if ($par_pck == true) {
            $pck = $par->getMontant();
        }
        $coef = $prk / $pck;
        $smcipn = array();
        $tab = new Application_Model_DbTable_EuSmcipn();
        $sel1 = $tab->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel1->setIntegrityCheck(false)
                ->where('id_utilisateur = ?', $user->id_utilisateur)
                ->where('type_smcipn = ?', 'smcipn')
                ->where('montant_salaire < ?', 'montant_investis*' + $coef + '-montant_investis')
                ->where('code_membre = ?', $user->code_membre);
        $sel2 = $tab->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel2->setIntegrityCheck(false)
                ->where('id_utilisateur = ?', $user->id_utilisateur)
                ->where('type_smcipn = ?', 'smci')
                ->where('salaire_alloue < ?', 'montant_investis*' + $coef + '-montant_investis')
                ->where('code_membre = ?', $user->code_membre);
        $sel = $tab->select();
        $sel->setIntegrityCheck(false)
                ->union(array($sel1, $sel2))
                ->order('date_demande', 'desc');
        $nsmcipn = $tab->fetchAll($sel);
        $i = 0;
        foreach ($nsmcipn as $value) {
            $date_dem = new Zend_Date($value->date_demande, Zend_Date::ISO_8601);
            $smcipn[$i][1] = $value->code_smcipn;
            $smcipn[$i][2] = ucfirst($value->lib_demande) . '--' . $date_dem->toString('dd/mm/yyyy');
            $i++;
        }
        $this->view->data = $smcipn;
    }

    public function numbesoinAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $cat_besoin = $_GET['cat_objet'];
        $besoin = array();
        $tab = new Application_Model_DbTable_EuInvestissement();
        $sel = $tab->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->join('eu_besoin', 'eu_besoin.id_besoin = eu_investissement.id_besoin')
                ->where('eu_besoin.disponible != ?', 1)
                ->where('eu_investissement.cat_objet = ?', $cat_besoin)
                ->where('eu_investissement.id_utilisateur = ?', $user->id_utilisateur)
                ->where('eu_investissement.code_smcipn is null')
                ->order('eu_investissement.date_investissement desc');
        $besoins = $tab->fetchAll($sel);
        $i = 0;
        foreach ($besoins as $value) {
            $date_besoin = new Zend_Date($value->date_besoin, Zend_Date::ISO_8601);
            $besoin[$i][1] = $value->id_investissement;
            $besoin[$i][2] = ucfirst($value->objet_besoin) . '--' . $date_besoin->toString('dd/mm/yyyy');
            $i++;
        }
        $this->view->data = $besoin;
    }

    public function recupinvesAction() {
        $id_investis = $_GET['id_investis'];
        $data = array();

        $inv_db = new Application_Model_DbTable_EuInvestissement();
        $inv_find = $inv_db->find($id_investis);
        if (count($inv_find) == 1) {
            $result = $inv_find->current();
            $data[0] = $result->montant_budget;
            $snr = 0;
            $prk = 0;
            $pck = 1;
            //Récupération de la prk et de la pck pour les nr
            $param = new Application_Model_EuParametresMapper();
            $par = new Application_Model_EuParametres();
            $par_prk = $param->find('prk', 'nr', $par);
            if ($par_prk == true) {
                $prk = $par->getMontant();
            }
            $par_pck = $param->find('pck', 'nr', $par);
            if ($par_pck == true) {
                $pck = $par->getMontant();
            }
            //calcul de la marge salaire de i
            $inr = ($result->montant_budget * $prk) / $pck;
            $snr = floor($inr - $result->montant_budget);
            $data[1] = $snr;
        } else {
            $data[0] = '';
            $data[1] = '';
        }
        $this->view->data = $data;
    }

    public function recupsalAction() {
        $code_demand = $_GET['code_smci'];
        $data = array();
        $smci_db = new Application_Model_DbTable_EuSmcipn();
        $smci_find = $smci_db->find($code_demand);
        if (count($smci_find) == 1) {
            $result = $smci_find->current();
            $data[0] = $result->montant_investis;
            $snr = 0;
            $prk = 0;
            $pck = 1;
            //Récupération de la prk et de la pck pour les nr
            $param = new Application_Model_EuParametresMapper();
            $par = new Application_Model_EuParametres();
            $par_prk = $param->find('prk', 'nr', $par);
            if ($par_prk == true) {
                $prk = $par->getMontant();
            }
            $par_pck = $param->find('pck', 'nr', $par);
            if ($par_pck == true) {
                $pck = $par->getMontant();
            }
            //calcul de la marge salaire de i
            $inr = ($result->montant_investis * $prk) / $pck;
            $snr = $inr - $result->montant_investis;
            if ($result->type_smcipn == 'smcipn') {
                $snr = floor($snr - ($result->montant_salaire + $result->salaire_alloue));
                if ($snr < 0) {
                    $snr = 0;
                }
            }
            if ($result->type_smcipn == 'smci') {
                $snr = floor($snr - $result->salaire_alloue);
            }
            $data[1] = $snr;
        } else {
            $data[0] = '';
            $data[1] = '';
        }
        $this->view->data = $data;
    }

    public function newsmcipnAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        if ($this->getRequest()->isPost()) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_demand = clone $date_id;
            $mapper = new Application_Model_EuSmcipnMapper();
            $smcipn = new Application_Model_EuSmcipn();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Contrôle de l'existence des doublons
                $smcipn_db = new Application_Model_DbTable_EuSmcipn();
                $smcipn_find = $smcipn_db->find($this->_request->getPost("code_demand"));
                if (count($smcipn_find) == 1) {
                    $this->view->message = 'Ce code existe déjà.';
                    $this->view->code_demand = $_POST["code_demand"];
                    $this->view->lib_demand = $_POST["lib_demand"];
                    $this->view->num_gac = $_POST["num_gac"];
                    $this->view->cat_objet = $_POST["cat_objet"];
                    $this->view->id_besoin = $_POST["id_besoin"];
                    $this->view->date_deb = $_POST["date_deb"];
                    $this->view->date_fin = $_POST["date_fin"];
                    $this->view->mt_investis = $_POST["mt_investis"];
                    $this->view->mt_salaire = $_POST["mt_salaire"];
                    $this->view->desc_demand = $_POST["desc_demand"];
                    return;
                } else {
                    //Formation du code de la smcipn à partir du code du membre demandeur
                    $code_memb = $user->code_membre;
                    $mapper = new Application_Model_EuSmcipnMapper();
                    $code = $mapper->getLastCodeByMembre($code_memb);
                    if ($code == null) {
                        $code_smcipn = $code_memb . '0001';
                    } else {
                        $num_ordre = substr($code, -4);
                        $num_ordre++;
                        $num_ordre_bis = str_pad($num_ordre, 4, 0, str_pad_left);
                        $code_smcipn = $code_memb . $num_ordre_bis;
                    }

                    $diff = 0;
                    $dated = clone $date_id;
                    $datef = clone $date_id;
                    //Formatage de la date en anglais et calcul de la différence
                    $date_deb = $_POST["date_deb"];
                    $date_fin = $_POST["date_fin"];
                    $date1 = explode("/", $date_deb);
                    $date2 = explode("/", $date_fin);
                    if ($date_deb != '' and $date_fin != '') {
                        $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                        $datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                        $s = strtotime($datef) - strtotime($dated);
                        $diff = intval($s / 86400) + 1;
                    }
                    $mdv = $diff / 30;
                    //fin formatage et calcul
                    //Controle des dates
                    if ($diff >= 0) {
                        //Détermination du salaire max
                        //Récupération de la prk et de la pck pour les nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $par_prk = $param->find('prk', 'nr', $par);
                        if ($par_prk == true) {
                            $prk = $par->getMontant();
                        }
                        $par_pck = $param->find('pck', 'nr', $par);
                        if ($par_pck == true) {
                            $pck = $par->getMontant();
                        }
                        //calcul de la marge salaire de i
                        $inr = ($_POST["mt_investis"] * $prk) / $pck;
                        $snr = $inr - $_POST["mt_investis"];
                        if ($_POST["mt_salaire"] <= $snr) {
                            $smcipn->setDate_demande($date_demand->toString('yyyy-mm-dd'));
                            $smcipn->setHeure_demande($date_demand->toString('hh:mm'));
                            $smcipn->setCode_membre($user->code_membre);
                            $smcipn->setCode_smcipn($code_smcipn);
                            $smcipn->setLib_demande($_POST["lib_demand"]);
                            $smcipn->setType_smcipn('smcipn');
                            $smcipn->setDesc_demande($_POST["desc_demand"]);
                            $smcipn->setReq_demande('');
                            $smcipn->setMontant_salaire($_POST["mt_salaire"]);
                            $smcipn->setMontant_investis($_POST["mt_investis"]);
                            $smcipn->setInvestis_alloue(0);
                            $smcipn->setSalaire_alloue(0);
                            $smcipn->setSal_transmis(0);
                            $smcipn->setType_objet($_POST["cat_objet"]);
                            $smcipn->setCode_gac($_POST["num_gac"]);
                            $smcipn->setDate_deb($dated);
                            $smcipn->setDate_fin($datef);
                            $smcipn->setDate_alloc($date_demand->toString('yyyy-mm-dd'));
                            $smcipn->setDvm_demande($mdv);
                            if ($_POST["mt_salaire"] == '') {
                                $smcipn->setMontant_salaire(0);
                            }
                            if ($_POST["mt_investis"] == '') {
                                $smcipn->setMontant_investis(0);
                            }
                            $group = $user->code_groupe;
                            if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
                                $smcipn->setSource_demande('gac');
                                $smcipn->setValid_gac(1);
                            } elseif ($group == 'filiere') {
                                $smcipn->setSource_demande('filiere');
                                $smcipn->setValid_gac(0);
                            } elseif ($group == 'creneau') {
                                $smcipn->setSource_demande('creneau');
                                $smcipn->setValid_gac(0);
                            } elseif ($group == 'acteur') {
                                $smcipn->setSource_demande('acteur');
                                $smcipn->setValid_gac(0);
                            }
                            $smcipn->setEtat_demande_inv(0);
                            $smcipn->setId_utilisateur($user->id_utilisateur);
                            //$smcipn->setValid_gac(0);
                            $smcipn->setValid_fil(0);
                            $smcipn->setValid_creneau(0);
                            $smcipn->setAlloc_gac_inv(0);
                            $smcipn->setAlloc_fil_inv(0);
                            $smcipn->setAlloc_creneau_inv(0);
                            $smcipn->setDomicilier(0);
                            $smcipn->setRembourser(0);
                            $smcipn->setAllouer_i(0);
                            $smcipn->setAllouer_s(0);
                            $smcipn->setType_alloc('globale');
                            $smcipn->setEtat_demande_sal(0);
                            $smcipn->setAlloc_gac_sal(0);
                            $smcipn->setAlloc_fil_sal(0);
                            $smcipn->setAlloc_creneau_sal(0);
                            $smcipn->setEtat_sal(0);
                            //Enregistrement dans la table smcipn
                            $mapper->save($smcipn);

                            //Mise à jour de la table investissement
                            $minv = new Application_Model_EuInvestissementMapper();
                            $inv = new Application_Model_EuInvestissement();
                            $find_inv = $minv->find($_POST["id_besoin"], $inv);
                            if (count($find_inv) == 1) {
                                $inv->setCode_smcipn($code_smcipn);
                                $minv->update($inv);

                                //Mise à jour de la table besoin
                                $besoin = $inv->getId_besoin();
                                $mbes = new Application_Model_EuBesoinMapper();
                                $bes = new Application_Model_EuBesoin();
                                $find_bes = $mbes->find($besoin, $bes);
                                if (count($find_bes) == 1) {
                                    $bes->setDisponible(1);
                                    $mbes->update($bes);
                                }
                            }
                            $db->commit();
                            return $this->_helper->redirector('index');
                        } else {
                            $db->rollback();
                            $this->view->message = 'Votre salaire est supérieur au quota autorisé.';
                            $this->view->code_demand = $_POST["code_demand"];
                            $this->view->lib_demand = $_POST["lib_demand"];
                            $this->view->num_gac = $_POST["num_gac"];
                            $this->view->cat_objet = $_POST["cat_objet"];
                            $this->view->id_besoin = $_POST["id_besoin"];
                            $this->view->date_deb = $_POST["date_deb"];
                            $this->view->date_fin = $_POST["date_fin"];
                            $this->view->mt_investis = $_POST["mt_investis"];
                            $this->view->mt_salaire = $_POST["mt_salaire"];
                            $this->view->desc_demand = $_POST["desc_demand"];
                            return;
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = 'La date début est supérieur à la date de fin.';
                        $this->view->code_demand = $_POST["code_demand"];
                        $this->view->lib_demand = $_POST["lib_demand"];
                        $this->view->num_gac = $_POST["num_gac"];
                        $this->view->cat_objet = $_POST["cat_objet"];
                        $this->view->id_besoin = $_POST["id_besoin"];
                        $this->view->date_deb = $_POST["date_deb"];
                        $this->view->date_fin = $_POST["date_fin"];
                        $this->view->mt_investis = $_POST["mt_investis"];
                        $this->view->mt_salaire = $_POST["mt_salaire"];
                        $this->view->desc_demand = $_POST["desc_demand"];
                        return;
                    }
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->code_demand = $_POST["code_demand"];
                $this->view->lib_demand = $_POST["lib_demand"];
                $this->view->num_gac = $_POST["num_gac"];
                $this->view->cat_objet = $_POST["cat_objet"];
                $this->view->id_besoin = $_POST["id_besoin"];
                $this->view->date_deb = $_POST["date_deb"];
                $this->view->date_fin = $_POST["date_fin"];
                $this->view->mt_investis = $_POST["mt_investis"];
                $this->view->mt_salaire = $_POST["mt_salaire"];
                $this->view->desc_demand = $_POST["desc_demand"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
        }
    }

    public function newsmciAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        if ($this->getRequest()->isPost()) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_demand = clone $date_id;
            $mapper = new Application_Model_EuSmcipnMapper();
            $smcipn = new Application_Model_EuSmcipn();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Contrôle de l'existence des doublons
                $smcipn_db = new Application_Model_DbTable_EuSmcipn();
                $smcipn_find = $smcipn_db->find($this->_request->getPost("code_demand"));
                if (count($smcipn_find) == 1) {
                    $this->view->message = 'Ce code existe déjà.';
                    $this->view->code_demand = $_POST["code_demand"];
                    $this->view->lib_demand = $_POST["lib_demand"];
                    $this->view->num_gac = $_POST["num_gac"];
                    $this->view->cat_objet = $_POST["cat_objet"];
                    $this->view->id_besoin = $_POST["id_besoin"];
                    $this->view->date_deb = $_POST["date_deb"];
                    $this->view->date_fin = $_POST["date_fin"];
                    $this->view->mt_investis = $_POST["mt_investis"];
                    $this->view->desc_demand = $_POST["desc_demand"];
                    return;
                } else {
                    //Formation du code de la smcipn à partir du code du membre demandeur
                    $code_memb = $user->code_membre;
                    $mapper = new Application_Model_EuSmcipnMapper();
                    $code = $mapper->getLastCodeByMembre($code_memb);
                    if ($code == null) {
                        $code_smcipn = $code_memb . '0001';
                    } else {
                        $num_ordre = substr($code, -4);
                        $num_ordre++;
                        $num_ordre_bis = str_pad($num_ordre, 4, 0, str_pad_left);
                        $code_smcipn = $code_memb . $num_ordre_bis;
                    }
                    $diff = 0;
                    $dated = clone $date_id;
                    $datef = clone $date_id;
                    //Formatage de la date en anglais et calcul de la différence
                    $date_deb = $_POST["date_deb"];
                    $date_fin = $_POST["date_fin"];
                    $date1 = explode("/", $date_deb);
                    $date2 = explode("/", $date_fin);
                    if ($date_deb != '' and $date_fin != '') {
                        $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                        $datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                        $s = strtotime($datef) - strtotime($dated);
                        $diff = intval($s / 86400) + 1;
                    }
                    $mdv = $diff / 30;
                    //fin formatage et calcul
                    //Controle des dates
                    if ($diff >= 0) {
                        $smcipn->setDate_demande($date_demand->toString('yyyy-mm-dd'));
                        $smcipn->setHeure_demande($date_demand->toString('hh:mm'));
                        $smcipn->setCode_membre($user->code_membre);
                        $smcipn->setCode_smcipn($code_smcipn);
                        $smcipn->setLib_demande($_POST["lib_demand"]);
                        $smcipn->setType_smcipn('smci');
                        $smcipn->setDesc_demande($_POST["desc_demand"]);
                        $smcipn->setReq_demande('');
                        $smcipn->setMontant_salaire(0);
                        $smcipn->setMontant_investis($_POST["mt_investis"]);
                        $smcipn->setInvestis_alloue(0);
                        $smcipn->setSalaire_alloue(0);
                        $smcipn->setSal_transmis(0);
                        $smcipn->setType_objet($_POST["cat_objet"]);
                        $smcipn->setCode_gac($_POST["num_gac"]);
                        $smcipn->setDate_deb($dated);
                        $smcipn->setDate_fin($datef);
                        $smcipn->setDate_alloc($date_demand->toString('yyyy-mm-dd'));
                        $smcipn->setDvm_demande($mdv);
                        if ($_POST["mt_investis"] == '') {
                            $smcipn->setMontant_investis(0);
                        }
                        $group = $user->code_groupe;
                        if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
                            $smcipn->setSource_demande('gac');
                            $smcipn->setValid_gac(1);
                        } elseif ($group == 'filiere') {
                            $smcipn->setSource_demande('filiere');
                            $smcipn->setValid_gac(0);
                        } elseif ($group == 'creneau') {
                            $smcipn->setSource_demande('creneau');
                            $smcipn->setValid_gac(0);
                        } elseif ($group == 'acteur') {
                            $smcipn->setSource_demande('acteur');
                            $smcipn->setValid_gac(0);
                        }
                        $smcipn->setEtat_demande_inv(0);
                        $smcipn->setId_utilisateur($user->id_utilisateur);
                        //$smcipn->setValid_gac(0);
                        $smcipn->setValid_fil(0);
                        $smcipn->setValid_creneau(0);
                        $smcipn->setAlloc_gac_inv(0);
                        $smcipn->setAlloc_fil_inv(0);
                        $smcipn->setAlloc_creneau_inv(0);
                        $smcipn->setDomicilier(0);
                        $smcipn->setRembourser(0);
                        $smcipn->setAllouer_i(0);
                        $smcipn->setAllouer_s(0);
                        $smcipn->setType_alloc('globale');
                        $smcipn->setEtat_demande_sal(0);
                        $smcipn->setAlloc_gac_sal(0);
                        $smcipn->setAlloc_fil_sal(0);
                        $smcipn->setAlloc_creneau_sal(0);
                        $smcipn->setEtat_sal(0);
                        //Enregistrement dans la table smcipn
                        $mapper->save($smcipn);
                        //Mise à jour de la table investissement
                        $minv = new Application_Model_EuInvestissementMapper();
                        $inv = new Application_Model_EuInvestissement();
                        $find_inv = $minv->find($_POST["id_besoin"], $inv);
                        if (count($find_inv) == 1) {
                            $inv->setCode_smcipn($code_smcipn);
                            $minv->update($inv);
                            //Mise à jour de la table besoin
                            $besoin = $inv->getId_besoin();
                            $mbes = new Application_Model_EuBesoinMapper();
                            $bes = new Application_Model_EuBesoin();
                            $find_bes = $mbes->find($besoin, $bes);
                            if (count($find_bes) == 1) {
                                $bes->setDisponible(1);
                                $mbes->update($bes);
                            }
                        }

                        $db->commit();
                        return $this->_helper->redirector('index');
                    } else {
                        $db->rollback();
                        $this->view->message = 'La date début est supérieur à la date de fin.';
                        $this->view->code_demand = $_POST["code_demand"];
                        $this->view->lib_demand = $_POST["lib_demand"];
                        $this->view->num_gac = $_POST["num_gac"];
                        $this->view->cat_objet = $_POST["cat_objet"];
                        $this->view->id_besoin = $_POST["id_besoin"];
                        $this->view->date_deb = $_POST["date_deb"];
                        $this->view->date_fin = $_POST["date_fin"];
                        $this->view->mt_investis = $_POST["mt_investis"];
                        $this->view->desc_demand = $_POST["desc_demand"];
                        return;
                    }
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->code_demand = $_POST["code_demand"];
                $this->view->lib_demand = $_POST["lib_demand"];
                $this->view->num_gac = $_POST["num_gac"];
                $this->view->cat_objet = $_POST["cat_objet"];
                $this->view->id_besoin = $_POST["id_besoin"];
                $this->view->date_deb = $_POST["date_deb"];
                $this->view->date_fin = $_POST["date_fin"];
                $this->view->mt_investis = $_POST["mt_investis"];
                $this->view->desc_demand = $_POST["desc_demand"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
        }
    }

    public function newsmcisansAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        if ($this->getRequest()->isPost()) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_demand = clone $date_id;
            $mapper = new Application_Model_EuSmcipnMapper();
            $smcipn = new Application_Model_EuSmcipn();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Contrôle de l'existence des doublons
                $smcipn_db = new Application_Model_DbTable_EuSmcipn();
                $smcipn_find = $smcipn_db->find($this->_request->getPost("code_demand"));
                if (count($smcipn_find) == 1) {
                    $this->view->message = 'Ce code existe déjà.';
                    $this->view->code_demand = $_POST["code_demand"];
                    $this->view->lib_demand = $_POST["lib_demand"];
                    $this->view->num_gac = $_POST["num_gac"];
                    $this->view->code_benef = $_POST["code_benef"];
                    $this->view->nom_benef = $_POST["nom_benef"];
                    $this->view->date_deb = $_POST["date_deb"];
                    $this->view->date_fin = $_POST["date_fin"];
                    $this->view->mt_investis = $_POST["mt_investis"];
                    $this->view->desc_demand = $_POST["desc_demand"];
                    return;
                } else {
                    //Formation du code de la smcipn à partir du code du membre demandeur
                    $code_memb = $user->code_membre;
                    $mapper = new Application_Model_EuSmcipnMapper();
                    $code = $mapper->getLastCodeByMembre($code_memb);
                    if ($code == null) {
                        $code_smcipn = $code_memb . '0001';
                    } else {
                        $num_ordre = substr($code, -4);
                        $num_ordre++;
                        $num_ordre_bis = str_pad($num_ordre, 4, 0, str_pad_left);
                        $code_smcipn = $code_memb . $num_ordre_bis;
                    }
                    $diff = 0;
                    $dated = clone $date_id;
                    $datef = clone $date_id;
                    //Formatage de la date en anglais et calcul de la différence
                    $date_deb = $_POST["date_deb"];
                    $date_fin = $_POST["date_fin"];
                    $date1 = explode("/", $date_deb);
                    $date2 = explode("/", $date_fin);
                    if ($date_deb != '' and $date_fin != '') {
                        $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                        $datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                        $s = strtotime($datef) - strtotime($dated);
                        $diff = intval($s / 86400) + 1;
                    }
                    $mdv = $diff / 30;
                    //fin formatage et calcul
                    //Controle des dates
                    if ($diff >= 0) {
                        $smcipn->setDate_demande($date_demand->toString('yyyy-mm-dd'));
                        $smcipn->setHeure_demande($date_demand->toString('hh:mm'));
                        $smcipn->setCode_membre($_POST["code_benef"]);
                        $smcipn->setCode_smcipn($code_smcipn);
                        $smcipn->setLib_demande($_POST["lib_demand"]);
                        $smcipn->setType_smcipn('smci');
                        $smcipn->setDesc_demande($_POST["desc_demand"]);
                        $smcipn->setReq_demande('');
                        $smcipn->setMontant_salaire(0);
                        $smcipn->setMontant_investis($_POST["mt_investis"]);
                        $smcipn->setInvestis_alloue(0);
                        $smcipn->setSalaire_alloue(0);
                        $smcipn->setSal_transmis(0);
                        $smcipn->setType_objet('fixe');
                        $smcipn->setCode_gac($_POST["num_gac"]);
                        $smcipn->setDate_deb($dated);
                        $smcipn->setDate_fin($datef);
                        $smcipn->setDate_alloc($date_demand->toString('yyyy-mm-dd'));
                        $smcipn->setDvm_demande($mdv);
                        if ($_POST["mt_investis"] == '') {
                            $smcipn->setMontant_investis(0);
                        }
                        $group = $user->code_groupe;
                        if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
                            $smcipn->setSource_demande('gac');
                            $smcipn->setValid_gac(1);
                        } elseif ($group == 'filiere') {
                            $smcipn->setSource_demande('filiere');
                            $smcipn->setValid_gac(0);
                        } elseif ($group == 'creneau') {
                            $smcipn->setSource_demande('creneau');
                            $smcipn->setValid_gac(0);
                        } elseif ($group == 'acteur') {
                            $smcipn->setSource_demande('acteur');
                            $smcipn->setValid_gac(0);
                        }
                        $smcipn->setEtat_demande_inv(0);
                        $smcipn->setId_utilisateur($user->id_utilisateur);
                        $smcipn->setValid_fil(0);
                        $smcipn->setValid_creneau(0);
                        $smcipn->setAlloc_gac_inv(0);
                        $smcipn->setAlloc_fil_inv(0);
                        $smcipn->setAlloc_creneau_inv(0);
                        $smcipn->setDomicilier(0);
                        $smcipn->setRembourser(0);
                        $smcipn->setAllouer_i(0);
                        $smcipn->setAllouer_s(0);
                        $smcipn->setType_alloc('globale');
                        $smcipn->setEtat_demande_sal(0);
                        $smcipn->setAlloc_gac_sal(0);
                        $smcipn->setAlloc_fil_sal(0);
                        $smcipn->setAlloc_creneau_sal(0);
                        $smcipn->setEtat_sal(0);
                        //Enregistrement dans la table smcipn
                        $mapper->save($smcipn);
                        //Mise à jour de la table investissement
                        $minv = new Application_Model_EuInvestissementMapper();
                        $inv = new Application_Model_EuInvestissement();
                        $find_inv = $minv->find($_POST["id_besoin"], $inv);
                        if (count($find_inv) == 1) {
                            $inv->setCode_smcipn($code_smcipn);
                            $minv->update($inv);
                            //Mise à jour de la table besoin
                            $besoin = $inv->getId_besoin();
                            $mbes = new Application_Model_EuBesoinMapper();
                            $bes = new Application_Model_EuBesoin();
                            $find_bes = $mbes->find($besoin, $bes);
                            if (count($find_bes) == 1) {
                                $bes->setDisponible(1);
                                $mbes->update($bes);
                            }
                        }

                        $db->commit();
                        return $this->_helper->redirector('index');
                    } else {
                        $db->rollback();
                        $this->view->message = 'La date début est supérieure à la date de fin.';
                        $this->view->code_demand = $_POST["code_demand"];
                        $this->view->lib_demand = $_POST["lib_demand"];
                        $this->view->num_gac = $_POST["num_gac"];
                        $this->view->date_deb = $_POST["date_deb"];
                        $this->view->date_fin = $_POST["date_fin"];
                        $this->view->mt_investis = $_POST["mt_investis"];
                        $this->view->desc_demand = $_POST["desc_demand"];
                        return;
                    }
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->code_demand = $_POST["code_demand"];
                $this->view->lib_demand = $_POST["lib_demand"];
                $this->view->num_gac = $_POST["num_gac"];
                $this->view->date_deb = $_POST["date_deb"];
                $this->view->date_fin = $_POST["date_fin"];
                $this->view->mt_investis = $_POST["mt_investis"];
                $this->view->desc_demand = $_POST["desc_demand"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
        }
    }

    public function newsmcpnAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        if ($this->getRequest()->isPost()) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_demand = clone $date_id;
            $mapper = new Application_Model_EuSmcipnMapper();
            $smcipn = new Application_Model_EuSmcipn();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Contrôle de l'existence des doublons
                $smcipn_db = new Application_Model_DbTable_EuSmcipn();
                $smcipn_find = $smcipn_db->find($this->_request->getPost("code_demand"));
                if (count($smcipn_find) == 1) {
                    $this->view->message = 'Ce code existe déjà.';
                    $this->view->code_demand = $_POST["code_demand"];
                    $this->view->lib_demand = $_POST["lib_demand"];
                    $this->view->num_gac = $_POST["num_gac"];
                    $this->view->cat_objet = $_POST["cat_objet"];
                    $this->view->id_besoin = $_POST["id_besoin"];
                    $this->view->date_deb = $_POST["date_deb"];
                    $this->view->date_fin = $_POST["date_fin"];
                    $this->view->mt_salaire = $_POST["mt_salaire"];
                    $this->view->desc_demand = $_POST["desc_demand"];
                    return;
                } else {
                    //Formation du code de la smcipn à partir du code du membre demandeur
                    $code_memb = $user->code_membre;
                    $mapper = new Application_Model_EuSmcipnMapper();
                    $code = $mapper->getLastCodeByMembre($code_memb);
                    if ($code == null) {
                        $code_smcipn = $code_memb . '0001';
                    } else {
                        $num_ordre = substr($code, -4);
                        $num_ordre++;
                        $num_ordre_bis = str_pad($num_ordre, 4, 0, str_pad_left);
                        $code_smcipn = $code_memb . $num_ordre_bis;
                    }
                    $diff = 0;
                    $dated = clone $date_id;
                    $datef = clone $date_id;
                    //Formatage de la date en anglais et calcul de la différence
                    $date_deb = $_POST["date_deb"];
                    $date_fin = $_POST["date_fin"];
                    $date1 = explode("/", $date_deb);
                    $date2 = explode("/", $date_fin);
                    if ($date_deb != '' and $date_fin != '') {
                        $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                        $datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                        $s = strtotime($datef) - strtotime($dated);
                        $diff = intval($s / 86400) + 1;
                    }
                    $mdv = $diff / 30;
                    //fin formatage et calcul de la différence
                    //Controle des dates
                    if ($diff >= 0) {
                        $smcipn->setDate_demande($date_demand->toString('yyyy-mm-dd'));
                        $smcipn->setHeure_demande($date_demand->toString('hh:mm'));
                        $smcipn->setCode_membre($code_memb);
                        $smcipn->setCode_smcipn($code_smcipn);
                        $smcipn->setLib_demande($_POST["lib_demand"]);
                        $smcipn->setType_smcipn('smcpn');
                        $smcipn->setDesc_demande($_POST["desc_demand"]);
                        $smcipn->setReq_demande('');
                        $smcipn->setMontant_salaire($_POST["mt_salaire"]);
                        $smcipn->setMontant_investis(0);
                        $smcipn->setInvestis_alloue(0);
                        $smcipn->setSalaire_alloue(0);
                        $smcipn->setSal_transmis(0);
                        $smcipn->setType_objet('');
                        $smcipn->setCode_gac($_POST["num_gac"]);
                        $smcipn->setDate_deb($dated);
                        $smcipn->setDate_fin($datef);
                        $smcipn->setDate_alloc($date_demand->toString('yyyy-mm-dd'));
                        $smcipn->setDvm_demande($mdv);
                        if ($_POST["mt_salaire"] == '') {
                            $smcipn->setMontant_salaire(0);
                        }
                        $group = $user->code_groupe;
                        if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
                            $smcipn->setSource_demande('gac');
                            $smcipn->setValid_gac(1);
                        } elseif ($group == 'filiere') {
                            $smcipn->setSource_demande('filiere');
                            $smcipn->setValid_gac(0);
                        } elseif ($group == 'creneau') {
                            $smcipn->setSource_demande('creneau');
                            $smcipn->setValid_gac(0);
                        } elseif ($group == 'acteur') {
                            $smcipn->setSource_demande('acteur');
                            $smcipn->setValid_gac(0);
                        }
                        $smcipn->setEtat_demande_inv(0);
                        $smcipn->setId_utilisateur($user->id_utilisateur);
                        //$smcipn->setValid_gac(0);
                        $smcipn->setValid_fil(0);
                        $smcipn->setValid_creneau(0);
                        $smcipn->setAlloc_gac_inv(0);
                        $smcipn->setAlloc_fil_inv(0);
                        $smcipn->setAlloc_creneau_inv(0);
                        $smcipn->setDomicilier(0);
                        $smcipn->setRembourser(0);
                        $smcipn->setAllouer_i(0);
                        $smcipn->setAllouer_s(0);
                        $smcipn->setType_alloc('globale');
                        $smcipn->setEtat_demande_sal(0);
                        $smcipn->setAlloc_gac_sal(0);
                        $smcipn->setAlloc_fil_sal(0);
                        $smcipn->setAlloc_creneau_sal(0);
                        $smcipn->setEtat_sal(0);
                        if ($_POST["code_smci"] == '') {
                            //Enregistrement dans la table smcipn
                            $mapper->save($smcipn);
                            $db->commit();
                            return $this->_helper->redirector('index');
                        } else {
                            $prk = 0;
                            $pck = 1;
                            //Détermination du salaire max
                            //Récupération de la prk et de la pck pour les nr
                            $param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $par_prk = $param->find('prk', 'nr', $par);
                            if ($par_prk == true) {
                                $prk = $par->getMontant();
                            }
                            $par_pck = $param->find('pck', 'nr', $par);
                            if ($par_pck == true) {
                                $pck = $par->getMontant();
                            }
                            //Récupération du montant de l'investissement de la demande
                            $smci_db = new Application_Model_DbTable_EuSmcipn();
                            $smci_find = $smci_db->find($_POST["code_smci"]);
                            $result = $smci_find->current();
                            //calcul de la marge salaire de i
                            $inr = ($result->montant_investis * $prk) / $pck;
                            $snr = $inr - $result->montant_investis;
                            if ($result->type_smcipn == 'smcipn') {
                                $snr = $snr - ($result->montant_salaire + $result->salaire_alloue);
                            }
                            if ($result->type_smcipn == 'smci') {
                                $snr = $snr - $result->salaire_alloue;
                            }
                            //Contrôle du salaire posté par rapport au salaire max restant
                            if ($_POST["mt_salaire"] <= $snr) {
                                //Enregistrement dans la table smcipn
                                $smcipn->setType_objet($_POST["code_smci"]);
                                $mapper->save($smcipn);
                                //Mise à jour de la demande d'investissement
                                $msmci = new Application_Model_EuSmcipnMapper();
                                $smci = new Application_Model_EuSmcipn();
                                $smci_find = $msmci->find($_POST["code_smci"], $smci);
                                if (count($smci_find) == 1) {
                                    $smci->setSalaire_alloue($smci->getSalaire_alloue() + $_POST["mt_salaire"]);
                                    $msmci->update($smci);
                                }
                                $db->commit();
                                return $this->_helper->redirector('index');
                            } else {
                                $db->rollback();
                                $this->view->message = 'Votre salaire est supérieur au quota autorisé.';
                                $this->view->code_demand = $_POST["code_demand"];
                                $this->view->lib_demand = $_POST["lib_demand"];
                                $this->view->num_gac = $_POST["num_gac"];
                                $this->view->code_smci = $_POST["code_smci"];
                                $this->view->date_deb = $_POST["date_deb"];
                                $this->view->date_fin = $_POST["date_fin"];
                                $this->view->mt_investis = $_POST["mt_investis"];
                                $this->view->mt_salaire = $_POST["mt_salaire"];
                                $this->view->desc_demand = $_POST["desc_demand"];
                                return;
                            }
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = 'La date début est supérieur à la date de fin.';
                        $this->view->code_demand = $_POST["code_demand"];
                        $this->view->lib_demand = $_POST["lib_demand"];
                        $this->view->num_gac = $_POST["num_gac"];
                        $this->view->cat_objet = $_POST["cat_objet"];
                        $this->view->id_besoin = $_POST["id_besoin"];
                        $this->view->date_deb = $_POST["date_deb"];
                        $this->view->date_fin = $_POST["date_fin"];
                        $this->view->mt_salaire = $_POST["mt_salaire"];
                        $this->view->desc_demand = $_POST["desc_demand"];
                        return;
                    }
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->code_demand = $_POST["code_demand"];
                $this->view->lib_demand = $_POST["lib_demand"];
                $this->view->num_gac = $_POST["num_gac"];
                $this->view->cat_objet = $_POST["cat_objet"];
                $this->view->id_besoin = $_POST["id_besoin"];
                $this->view->date_deb = $_POST["date_deb"];
                $this->view->date_fin = $_POST["date_fin"];
                $this->view->mt_salaire = $_POST["mt_salaire"];
                $this->view->desc_demand = $_POST["desc_demand"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
        }
    }

    public function affectersalaireAction() {
        $form = new Application_Form_EuAffecterSalaire();
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-smcipn',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function listsalarieAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_demand = $request->code_demand;
        $msmcpn = new Application_Model_EuSmcipnMapper();
        $smcpn = new Application_Model_EuSmcipn();
        $smci_find = $msmcpn->find($code_demand, $smcpn);
        $num_membre = '';
        $mdv = 1;
        $div = 1;
        $period = '';
        if (count($smci_find) == 1) {
            $num_membre = $smcpn->getCode_membre();
            //Récup du code de la subvention
            $type = $smcpn->getType_smcipn();
            if ($type == 'smcipn') {
                $code_smci = $smcpn->getCode_smcipn();
            } else if ($type == 'smcpn') {
                $code_smci = $smcpn->getType_objet();
            }
            $period = $smcpn->getType_alloc();
            if ($period == 'periodique') {
                $tot_mdv = 0;
                //Détermination de la moyenne des mdvbps des produits utilisés pr la demande smci
                $select = "select i.id_investissement, i.montant_budget, i.type_objet, i.code_smcipn, i.id_besoin, b.id_objet, b.code_proforma, mdv from eu_investissement i join eu_budget_facture b on i.id_investissement=b.id_investissement join eu_porter p on p.id_objet=b.id_objet where i.code_smcipn= '$code_smci'";
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->setFetchMode(Zend_Db::fetch_obj);
                $produit = $db->fetchAll($select);
                $count = count($produit);
                foreach ($produit as $row) {
                    $tot_mdv += $row->mdv;
                }
                $mdv = $tot_mdv / $count;
                $div = $mdv * 12.175;
            } else {
                $div = 1;
            }
        }
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'nom_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        $t_bout = new Application_Model_DbTable_EuJustifier();
        $select = $t_bout->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_justifier.code_membre')
                ->where('code_smcipn like ?', $code_demand)
                ->where('solde != ?', 0);
        $justif = $t_bout->fetchAll($select);
        $count = count($justif);
        if ($count <= 0) {
            $this->view->message = 'Vous n\'avez pas justifier votre demande de salaire';
            $total_pages = 0;
        } else {
            $total_pages = ceil($count / $limit);

            if ($page > $total_pages)
                $page = $total_pages;

            $justif = $t_bout->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            $sal = 0;
            $totmont = 0;
            foreach ($justif as $row) {
                $totmont+=$row->solde;
                $date_deb = new Zend_Date($smcpn->getDate_deb(), Zend_Date::ISO_8601);
                $date_fin = new Zend_Date($smcpn->getDate_fin(), Zend_Date::ISO_8601);
                $sal = round($row->solde / ($div));
                if ($period == 'periodique') {
                    $tab = $sal;
                } else {
                    $tab = $row->solde;
                }
                $responce['rows'][$i]['id'] = $row->code_membre . $row->code_smcipn;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_membre,
                    strtoupper($row->nom_membre) . ' ' . ucfirst($row->prenom_membre),
                    $row->solde,
                    $tab,
                    $date_deb->toString('dd/mm/yyyy'),
                    $date_fin->toString('dd/mm/yyyy'),
                    $row->code_smcipn,
                    $row->solde
                );
                $i++;
            }
            $responce['userdata']['code_membre'] = 'Total:';
            $responce['userdata']['nom'] = $count;
            $responce['userdata']['salaire'] = $totmont;
            $this->view->data = $responce;

//            $compte_source = 'nr-tpn-' . $num_membre;
//            $sal_percu = 0;
//            //Calcul du montant total du salaire perçu dans la table compte crédit
//            $cc_mapper = new Application_Model_EuCompteCreditMapper();
//            $rest = $cc_mapper->findBySMC($code_demand, $compte_source);
//            if ($rest == false) {
//                $sal_percu = 0;
//            } else {
//                $sal_percu = $rest[0]->getMontant_credit();
//            }
//            $this->view->sal_percu = $sal_percu;
        }
    }

    public function justifiersalaireAction() {
        $form = new Application_Form_EuJustifierSalaire();
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-smcipn',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;

        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $code_demand = $request->code_demand;
                $msmcpn = new Application_Model_EuSmcipnMapper();
                $smcpn = new Application_Model_EuSmcipn();
                $smci_find = $msmcpn->find($code_demand, $smcpn);
                $num_membre = '';
                $mdv = 1;
                $div = 1;
                $period = '';
                if (count($smci_find) == 1) {
                    $num_membre = $smcpn->getCode_membre();
                    //Récup du code de la subvention
                    $type = $smcpn->getType_smcipn();
                    if ($type == 'smcipn') {
                        $code_smci = $smcpn->getCode_smcipn();
                    } else if ($type == 'smcpn') {
                        $code_smci = $smcpn->getType_objet();
                    }
                    $period = $smcpn->getType_alloc();
                    if ($period == 'periodique') {
                        $tot_mdv = 0;
                        //Détermination de la moyenne des mdvbps des produits utilisés pr la demande smci
                        $select = "select i.id_investissement, i.montant_budget, i.type_objet, i.code_smcipn, i.id_besoin, b.id_objet, b.code_proforma, mdv from eu_investissement i join eu_budget_facture b on i.id_investissement=b.id_investissement join eu_porter p on p.id_objet=b.id_objet where i.code_smcipn= '$code_smci'";
                        $db = Zend_Db_Table::getDefaultAdapter();
                        $db->setFetchMode(Zend_Db::fetch_obj);
                        $produit = $db->fetchAll($select);
                        $count = count($produit);
                        foreach ($produit as $row) {
                            $tot_mdv += $row->mdv;
                        }
                        $mdv = $tot_mdv / $count;
                        $div = $mdv * 12.175;
                    } else {
                        $div = 1;
                    }
                }
                $t_bout = new Application_Model_DbTable_EuJustifier();
                $select = $t_bout->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                        ->join('eu_membre', 'eu_membre.code_membre = eu_justifier.code_membre')
                        ->where('code_smcipn like ?', $code_demand);
                $alloc = $t_bout->fetchAll($select);
                if (count($alloc) == 0) {
                    $this->view->message = 'Vous n\'avez pas justifier votre demande de salaire';
                } else {
                    $tab = array(array());
                    $i = 0;
                    $sal = 0;
                    foreach ($alloc as $row) {
                        $sal = round($row->solde / ($div));
                        $tab[$i][1] = $row->code_membre;
                        $tab[$i][2] = ucfirst($row->nom_membre) . ' ' . ucfirst($row->prenom_membre);
                        $tab[$i][3] = $row->salaire;
                        $tab[$i][4] = $row->affecter;
                        $tab[$i][5] = $row->solde;
                        $tab[$i][6] = $code_demand;
                        if ($period == 'periodique') {
                            $tab[$i][7] = ' / ' . $sal;
                        } else {
                            $tab[$i][7] = '';
                        }
                        $i++;
                    }
                    $this->view->data = $tab;

                    $compte_source = 'nr-tpn-' . $num_membre;
                    $sal_percu = 0;
                    //Calcul du montant total du salaire perçu dans la table compte crédit
                    $cc_mapper = new Application_Model_EuCompteCreditMapper();
                    $rest = $cc_mapper->findBySMC($code_demand, $compte_source);
                    if ($rest == false) {
                        $sal_percu = 0;
                    } else {
                        $sal_percu = $rest[0]->getMontant_credit();
                    }
                    $this->view->sal_percu = $sal_percu;
                }
            }
        }
    }

    public function salaireAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_dem = $request->dema;
        $mt_sal = $request->sal;
        $code_membre = $request->dema1;
        $this->view->code = $code_dem;

        $t_bout = new Application_Model_DbTable_EuJustifier();
        $select = $t_bout->select();
        $select->setIntegrityCheck(false)
                ->where('code_smcipn like ?', $code_dem);
        $alloc = $t_bout->fetchAll($select);
        $sal_tot = 0;
        $j = 0;
        $tab_emp = array('');
        foreach ($alloc as $row) {
            $sal_tot+=$row->salaire;
            $tab_emp[$j] = $row->code_membre;
            $j++;
        }
        $mt_sal1 = $mt_sal - $sal_tot;
        $t_employe = new Application_Model_DbTable_EuEmploye();
        $select = $t_employe->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_employe.code_membre_employe')
                ->where('eu_employe.code_membre_employeur = ?', $code_membre)
                ->where('eu_employe.code_membre_employe not in (?)', $tab_emp)
                ->order('eu_membre.nom_membre', 'asc');
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        $tab = array(array());
        try {
            $emp = $t_employe->fetchAll($select);
            $count = count($emp);
            $i = 0;
            foreach ($emp as $row) {
                $tab[$i][1] = $row->code_membre_employe;
                $tab[$i][2] = ucfirst($row->nom_membre) . ' ' . ucfirst($row->prenom_membre);
                $tab[$i][3] = $row->mont_salaire;
                $i++;
            }
        } catch (Exception $exc) {
            
        }

        if ($count > 0) {
            $counta = $count;
        } else {
            $counta = 0;
        }
        $this->view->data = $tab;
        $this->view->cpteur = $counta;
        $this->view->salaire = number_format($mt_sal1, 0, ',', '');
    }

    public function salairevalidAction() {
        if ($this->getRequest()->isPost()) {
            $selection = $_POST['cpteur'];
            $code_demand = $_POST["code_demand"];
            $mt_salaire = $_POST['mt_salaire'];
            $mt_salaire1 = $_POST["mt_salaire1"];
            //Récupération du total des salaires
            $sal = 0;
            for ($j = 0; $j < $selection; $j++) {
                $sal+=$_POST["salaire$j"];
            }
            //Vérification du salaire avec celui de la demande
            $smcipn_db = new Application_Model_DbTable_EuSmcipn();
            $smcipn_find = $smcipn_db->find($_POST["code_demand"]);
            $result = $smcipn_find->current();
            $sal_init = $result->montant_salaire;
            if ($mt_salaire > $mt_salaire1) {
                $this->view->data = 4;
                return;
            } else if ($sal != $mt_salaire) {
                $this->view->data = 2;
                return;
            } else {
                $smc_db = new Application_Model_EuJustifierMapper();
                $justif = new Application_Model_EuJustifier;
                //Vérification du montant du budget existent par rapport à celui de la subvention
                $sal_budget = 0;
                $find_justif = $smc_db->findBySmcipn($code_demand);
                if ($find_justif != false) {
                    for ($i = 0; $i < count($find_justif); $i++) {
                        $justifier = $find_justif[$i];
                        $sal_budget+=$justifier->getSalaire();
                    }
                }
                if ($sal_budget >= $sal_init) {
                    $this->view->data = 3;
                    return;
                } else {
                    for ($i = 0; $i < $selection; $i++) {
                        $num_membre = $_POST["num_membre$i"];
                        $salaire = $_POST["salaire$i"];
                        //insertion dans la table eu_justifier
                        $justif->setCode_membre($num_membre);
                        $justif->setCode_smcipn($code_demand);
                        $justif->setSalaire($salaire);
                        $justif->setAffecter(0);
                        $justif->setSolde($salaire);
                        $db = Zend_Db_Table::getDefaultAdapter();
                        $db->beginTransaction();
                        try {
                            $smc_db->save($justif);
                            $db->commit();
                            $this->view->data = 1;
                        } catch (Exception $exc) {
                            $db->rollback();
                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                            $this->view->message = $message;
                            $this->view->data = 0;
                            return;
                        }
                    }
                }
            }
        }
    }

    public function changeAction() {

        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
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

    public function saveAction() {
        $s = new Application_Model_EuSmcipn();
        $ms = new Application_Model_EuSmcipnMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $ms->find($this->getRequest()->getPost("code_demand"), $s);
            $s->setLib_demande($this->_request->getPost("lib_demand"));
            $s->setCode_membre($user->code_membre);
            $s->setDesc_demande($this->_request->getPost("desc_demand"));
            $s->setReq_demande($this->_request->getPost("req_demand"));
            $s->setDate_demande($date_id->toString('yyyy-mm-dd'));
            $s->setHeure_demande($date_id->toString('hh:mm'));
            $s->setDvm_demande($this->_request->getPost("dvm_demand"));
            $s->setMontant_salaire($this->_request->getPost("mt_salaire"));
            $s->setMontant_investis($this->_request->getPost("mt_investis"));
            $s->setEtat_demande_inv($this->_request->getPost("etat_demand"));
            $s->setId_utilisateur($this->_request->getPost("cree_par"));
            $s->setSource_demande($this->_request->getPost("source_demand"));
            $s->setValid_gac($this->_request->getPost("valid_gac"));
            $s->setValid_fil($this->_request->getPost("valid_fil"));
            $s->setValid_creneau($this->_request->getPost("valid_creneau"));
            $s->setAlloc_gac_inv($this->_request->getPost("alloc_gac"));
            $s->setAlloc_fil_inv($this->_request->getPost("alloc_fil"));
            $s->setAlloc_creneau_inv($this->_request->getPost("alloc_creneau"));
            $s->setCode_gac($this->_request->getPost("num_gac"));
            $s->setDomicilier($this->_request->getPost("domicilier"));
            $s->setRembourser($this->_request->getPost("rembourser"));
            $ms->update($s);
        }
    }

    public function editAction() {
// action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuSmcipn();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
// action body
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $smc = new Application_Model_EuSmcipn($form->getValues());
                $smc->setCode_smcipn($this->getRequest()->code_demand);
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_demand = clone $date_id;
                $smc->setLib_demande($this->_request->getPost("lib_demand"));
                $smc->setCode_membre($user->code_membre);
                $smc->setDesc_demande($this->_request->getPost("desc_demand"));
                $smc->setDate_demande($date_demand->toString('yyyy-mm-dd'));
                $smc->setHeure_demande($date_demand->toString('hh:mm'));
                $smc->setDvm_demande($this->_request->getPost("dvm_demand"));
                $smc->setMontant_salaire($this->_request->getPost("mt_salaire"));
                $smc->setMontant_investis($this->_request->getPost("mt_investis"));
                $smc->setEtat_demande_inv(0);
                $smc->setId_utilisateur($user->id_utilisateur);
                $smc->setValid_gac(0);
                $smc->setValid_fil(0);
                $smc->setValid_creneau(0);
                $smc->setAlloc_gac_inv(0);
                $smc->setAlloc_fil_inv(0);
                $smc->setAlloc_creneau_inv(0);
                $smc->setDomicilier(0);
                $smc->setRembourser(0);
                $smc->setAllouer_i(0);
                $smc->setAllouer_s(0);
                $smc->setType_alloc('globale');
                if ($this->_request->getPost("unite_mdv") == 'jour') {
                    $nb_periode = $this->_request->getPost("mdv") / 30;
                } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                    $nb_periode = $this->_request->getPost("mdv");
                } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                    $nb_periode = (365.25 / 30) * $this->_request->getPost("mdv");
                }
                $smc->setDvm_demande($nb_periode);
                $group = $user->code_groupe;
                if ($this->_request->getPost("mt_salaire") == '') {
                    $smc->setMontant_salaire(0);
                }
                if ($this->_request->getPost("mt_investis") == '') {
                    $smc->setMontant_investis(0);
                }
                if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
                    $smc->setSource_demande('gac');
                } elseif ($group == 'filiere') {
                    $smc->setSource_demande('filiere');
                } elseif ($group == 'creneau') {
                    $smc->setSource_demande('creneau');
                } elseif ($group == 'acteur') {
                    $smc->setSource_demande('acteur');
                }
                $mapper = new Application_Model_EuSmcipnMapper();
                $mapper->update($smc);
                return $this->_helper->redirector('index');
            }
        } else {
            $code_dem = $request->dem;
            $mapper = new Application_Model_EuSmcipnMapper();
            $smc = new Application_Model_EuSmcipn();
            $mapper->find($code_dem, $smc);
            if ($smc->getCode_smcipn() == $code_dem) {
                $data = array(
                    'code_demand' => $code_dem,
                    'lib_demand' => $smc->getLib_demande(),
                    'num_membre' => $smc->getCode_membre(),
                    'desc_demand' => $smc->getDesc_demande(),
                    'date_demand' => $smc->getDate_demande(),
                    'heure_demand' => $smc->getHeure_demande(),
                    'dvm_demand' => $smc->getDvm_demande(),
                    'mt_salaire' => $smc->getMontant_salaire(),
                    'mt_investis' => $smc->getMontant_investis(),
                    'etat_demand' => $smc->getEtat_demande_inv(),
                    'cree_par' => $smc->getId_utilisateur(),
                    'source_demand' => $smc->getSource_demande(),
                    'valid_gac' => $smc->getValid_gac(),
                    'valid_fil' => $smc->getValid_fil(),
                    'valid_creneau' => $smc->getValid_creneau(),
                    'alloc_gac' => $smc->getAlloc_gac_inv(),
                    'alloc_fil' => $smc->getAlloc_fil_inv(),
                    'alloc_creneau' => $smc->getAlloc_creneau_inv(),
                    'num_gac' => $smc->getCode_gac(),
                );
                $form->populate($data);
            }
        }
// Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-smcipn',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function verifsmcipnAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_dem = $request->code_demand;

        //Informations sur la smcipn
        $tabel = new Application_Model_DbTable_EuSmcipn();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_smcipn.code_membre')
                ->where('eu_smcipn.code_smcipn = ?', $code_dem);
        $smc = $tabel->fetchAll($sel);
        $this->view->smcipn = $smc[0];
        //Informations sur la domiciliation
        $table = new Application_Model_DbTable_EuDomiciliation();
        $dom = $table->select();
        $dom->where('eu_domiciliation.code_smcipn = ?', $code_dem);
        $domi = $table->fetchAll($dom);
        if (count($domi) == 1) {
            $this->view->domici = $domi[0];
            $mapper = new Application_Model_EuMembreMapper();
            $membre1 = new Application_Model_EuMembre();
            $mapper->find($domi[0]->code_membre_beneficiaire, $membre1);
            $this->view->benef = $membre1;
            $membre2 = new Application_Model_EuMembre();
            $mapper->find($domi[0]->code_membre_assureur, $membre2);
            $this->view->ass = $membre2;
        }
        //Récupération du salaire du budget salaire
        $tabela = new Application_Model_DbTable_EuJustifier();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_justifier.code_membre')
                ->where('eu_justifier.code_smcipn = ?', $code_dem);
        $justif = $tabela->fetchAll($select);
        $bsal = 0;
        foreach ($justif as $row) {
            $bsal+=$row->salaire;
        }
        $this->view->sal = $bsal;
        //Récupération du total du budget investissement
        $tabel = new Application_Model_DbTable_EuBudgetFacture();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->join('eu_investissement', 'eu_investissement.id_investissement = eu_budget_facture.id_investissement')
                ->where('eu_investissement.code_smcipn = ?', $code_dem);
        $invest = $tabel->fetchAll($sel);
        $binves = 0;
        foreach ($invest as $row) {
            $inv = $row->pu_objet * $row->qte_objet;
            $inves = $inv - ($inv * $row->remise_objet / 100);
            $binves+=$inves;
        }
        $this->view->investis = $binves;
    }

    public function detailsmcipnAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_dem = $request->code_demand;

        //Informations sur la smcipn
        $tabel = new Application_Model_DbTable_EuSmcipn();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_smcipn.code_membre')
                ->where('eu_smcipn.code_smcipn = ?', $code_dem);
        $smc = $tabel->fetchAll($sel);
        $this->view->smcipn = $smc[0];
        //Informations sur la domiciliation
        $table = new Application_Model_DbTable_EuDomiciliation();
        $dom = $table->select();
        $dom->where('eu_domiciliation.code_smcipn = ?', $code_dem);
        $domi = $table->fetchAll($dom);
        if (count($domi) == 1) {
            $this->view->domici = $domi[0];
            $mapper = new Application_Model_EuMembreMapper();
            $membre1 = new Application_Model_EuMembre();
            $mapper->find($domi[0]->code_membre_beneficiaire, $membre1);
            $this->view->benef = $membre1;
            $membre2 = new Application_Model_EuMembre();
            $mapper->find($domi[0]->code_membre_assureur, $membre2);
            $this->view->ass = $membre2;
        }
        //Récupération du salaire du budget salaire
        $tabela = new Application_Model_DbTable_EuJustifier();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_justifier.code_membre')
                ->where('eu_justifier.code_smcipn = ?', $code_dem);
        $justif = $tabela->fetchAll($select);
        $bsal = 0;
        foreach ($justif as $row) {
            $bsal+=$row->salaire;
        }
        $this->view->sal = $bsal;
        //Récupération du total du budget investissement
        $tabel = new Application_Model_DbTable_EuBudgetFacture();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->join('eu_investissement', 'eu_investissement.id_investissement = eu_budget_facture.id_investissement')
                ->where('eu_investissement.code_smcipn = ?', $code_dem);
        $invest = $tabel->fetchAll($sel);
        $binves = 0;
        foreach ($invest as $row) {
            $inv = $row->pu_objet * $row->qte_objet;
            $inves = $inv - ($inv * $row->remise_objet / 100);
            $binves+=$inves;
        }
        $this->view->investis = $binves;
    }

    public function listsalaireAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_dem = $request->code_demand;
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuJustifier();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_justifier.code_membre')
                ->where('eu_justifier.code_smcipn = ?', $code_dem);
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
        $bsal = 0;
        foreach ($justif as $row) {
            $bsal+=$row->salaire;
            $responce['rows'][$i]['id'] = $row->code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                strtoupper($row->nom_membre),
                ucfirst($row->prenom_membre),
                $row->salaire,
            );
            $i++;
        }
        $responce['userdata']['salaire'] = $bsal;
        $responce['userdata']['prenom_membre'] = 'Total:';
        $this->view->data = $responce;
    }

    public function listinvestisAction() {

        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_dem = $request->dema;
        $mt_inves = $request->investis;

        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        if ($mt_inves > 0) {
            $tabela = new Application_Model_DbTable_EuBudgetFacture();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join('eu_objet', 'eu_objet.id_objet = eu_budget_facture.id_objet')
                    ->join('eu_investissement', 'eu_investissement.id_investissement = eu_budget_facture.id_investissement')
                    ->where('eu_investissement.code_smcipn= ?', $code_dem);
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
                    $total,
                    $code_dem,
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
    }

    public function validersmcipnAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_demand = $_GET['code'];
        $req = $_GET['req'];
        $group = $user->code_groupe;

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $mdo = new Application_Model_EuSmcipnMapper();
            $do = new Application_Model_EuSmcipn();
            $smc_db = new Application_Model_DbTable_EuSmcipn();
            $smc_find = $smc_db->find($code_demand);
            if (count($smc_find) == 1) {
                $result = $smc_find->current();
                $do->setLib_demande($result->lib_demande);
                $do->setCode_membre($result->code_membre);
                $do->setType_smcipn($result->type_smcipn);
                $do->setDesc_demande($result->desc_demande);
                $do->setReq_demande($result->req_demande);
                $do->setDate_demande($result->date_demande);
                $do->setHeure_demande($result->heure_demande);
                $do->setDate_deb($result->date_deb);
                $do->setDate_fin($result->date_fin);
                $do->setDate_alloc($result->date_alloc);
                $do->setDvm_demande($result->dvm_demande);
                $do->setMontant_salaire($result->montant_salaire);
                $do->setMontant_investis($result->montant_investis);
                $do->setSalaire_alloue($result->salaire_alloue);
                $do->setInvestis_alloue($result->investis_alloue);
                $do->setSal_transmis($result->sal_transmis);
                $do->setEtat_demande_inv($result->etat_demande_inv);
                $do->setId_utilisateur($result->id_utilisateur);
                $do->setSource_demande($result->source_demande);
                $do->setValid_gac($result->valid_gac);
                $do->setValid_fil($result->valid_fil);
                $do->setValid_creneau($result->valid_creneau);
                $do->setAlloc_gac_inv($result->alloc_gac_inv);
                $do->setAlloc_fil_inv($result->alloc_fil_inv);
                $do->setAlloc_creneau_inv($result->alloc_creneau_inv);
                $do->setType_objet($result->type_objet);
                $do->setCode_gac($result->code_gac);
                $do->setDomicilier($result->domicilier);
                $do->setRembourser($result->rembourser);
                $do->setAllouer_i($result->allouer_i);
                $do->setAllouer_s($result->allouer_s);
                $do->setType_alloc($result->type_alloc);
                $do->setEtat_demande_sal($result->etat_demande_sal);
                $do->setAlloc_gac_sal($result->alloc_gac_sal);
                $do->setAlloc_fil_sal($result->alloc_fil_sal);
                $do->setAlloc_creneau_sal($result->alloc_creneau_sal);
                $do->setEtat_sal($result->etat_sal);
            }
            $do->setCode_smcipn($code_demand);
            if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
                $do->setValid_gac(1);
                $req_gac = 'Gac:' . $req;
                $fil = $do->getReq_demande();
                if ($fil == '' or $fil == null) {
                    $msg = $req_gac;
                } else {
                    $msg = $fil . '--' . $req_gac;
                }
                $do->setReq_demande($msg);
            } else if ($group == 'filiere') {
                $do->setValid_fil(1);
                $req_fil = 'Filière:' . $req;
                $cre = $do->getReq_demande();
                if ($cre == '' or $cre == null) {
                    $msg = $req_fil;
                } else {
                    $msg = $cre . '--' . $req_fil;
                }
                $do->setReq_demande($msg);
            } else if ($group == 'creneau') {
                $do->setValid_creneau(1);
                $req_cre = 'Créneau:' . $req;
                $act = $do->getReq_demande();
                if ($act == '' or $act == null) {
                    $msg = $req_cre;
                } else {
                    $msg = $act . '--' . $req_cre;
                }
                $do->setReq_demande($msg);
            }
            $mdo->update($do);

            $db->commit();
            $this->view->data = true;
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
            $this->view->message = $message;
            $this->view->data = false;
            return;
        }
    }

    public function rejetersmcipnAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_demand = $_GET['code'];
        $req = $_GET['req'];
        $group = $user->code_groupe;

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {

            $mdo = new Application_Model_EuSmcipnMapper();
            $do = new Application_Model_EuSmcipn();
            $smc_db = new Application_Model_DbTable_EuSmcipn();
            $smc_find = $smc_db->find($code_demand);
            if (count($smc_find) == 1) {
                $result = $smc_find->current();
                $do->setLib_demande($result->lib_demande);
                $do->setCode_membre($result->code_membre);
                $do->setType_smcipn($result->type_smcipn);
                $do->setDesc_demande($result->desc_demande);
                $do->setReq_demande($result->req_demande);
                $do->setDate_demande($result->date_demande);
                $do->setHeure_demande($result->heure_demande);
                $do->setDate_deb($result->date_deb);
                $do->setDate_fin($result->date_fin);
                $do->setDate_alloc($result->date_alloc);
                $do->setDvm_demande($result->dvm_demande);
                $do->setMontant_salaire($result->montant_salaire);
                $do->setMontant_investis($result->montant_investis);
                $do->setSalaire_alloue($result->salaire_alloue);
                $do->setInvestis_alloue($result->investis_alloue);
                $do->setSal_transmis($result->sal_transmis);
                $do->setEtat_demande_inv($result->etat_demande_inv);
                $do->setId_utilisateur($result->id_utilisateur);
                $do->setSource_demande($result->source_demande);
                $do->setValid_gac($result->valid_gac);
                $do->setValid_fil($result->valid_fil);
                $do->setValid_creneau($result->valid_creneau);
                $do->setAlloc_gac_inv($result->alloc_gac_sal);
                $do->setAlloc_fil_inv($result->alloc_fil_sal);
                $do->setAlloc_creneau_inv($result->alloc_creneau_sal);
                $do->setType_objet($result->type_objet);
                $do->setCode_gac($result->code_gac);
                $do->setDomicilier($result->domicilier);
                $do->setRembourser($result->rembourser);
                $do->setAllouer_i($result->allouer_i);
                $do->setAllouer_s($result->allouer_s);
                $do->setType_alloc($result->type_alloc);
                $do->setEtat_demande_sal($result->etat_demande_sal);
                $do->setAlloc_gac_sal($result->alloc_gac_sal);
                $do->setAlloc_fil_sal($result->alloc_fil_sal);
                $do->setAlloc_creneau_sal($result->alloc_creneau_sal);
                $do->setEtat_sal($result->etat_sal);
            }
            $do->setCode_smcipn($code_demand);
            if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
                $do->setValid_gac(2);
                $req_gac = 'Gac:' . $req;
                $fil = $do->getReq_demande();
                if ($fil == '' or $fil == null) {
                    $msg = $req_gac;
                } else {
                    $msg = $fil . '--' . $req_gac;
                }
                $do->setReq_demande($msg);
            } else if ($group == 'filiere') {
                $do->setValid_fil(2);
                $req_fil = 'Filière:' . '--' . $req;
                $cre = $do->getReq_demande();
                if ($cre == '' or $cre == null) {
                    $msg = $req_fil;
                } else {
                    $msg = $cre . '--' . $req_fil;
                }
                $do->setReq_demande($msg);
            } else if ($group == 'creneau') {
                $do->setValid_creneau(2);
                $req_cre = 'Créneau:' . $req;
                $act = $do->getReq_demande();
                if ($act == '' or $act == null) {
                    $msg = $req_cre;
                } else {
                    $msg = $act . '--' . $req_cre;
                }
                $do->setReq_demande($msg);
            }
            $mdo->update($do);

            $db->commit();
            $this->view->data = true;
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
            $this->view->message = $message;
            $this->view->data = false;
            return;
        }
    }

    public function mesrecuAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function mesreculistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_smcipn');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipnpwi();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('s' => 'EU_sMCIPNPWI'), array('*', "to_char((s.DATE_sMCIPN),'dd/mm/yyyy') DATE_sMCIPN"))
                ->join(array('m' => 'EU_mEmBRE_mORALE'), 'm.CODE_mEmBRE_mORALE = s.CODE_mEmBRE', array('CODE_mEmBRE_mORALE', 'RAIsON_sOCIALE'))
                ->where('s.TYPE_sMCIPN = ?', 'sMCIPNWI')
                ->where('s.code_membre = ?', $user->code_membre)
                ->order('s.DATE_sMCIPN', 'desc');
        $smcipnp = $tabela->fetchAll($select);
        $count = count($smcipnp);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipnp = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totsal = 0;
        $totinves = 0;
        foreach ($smcipnp as $row) {
            $totsal+=$row->mont_salaire;
            $totinves+=$row->mont_investis;
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                $row->code_membre,
                ucfirst($row->raison_sociale),
                $row->date_smcipn,
                $row->mont_salaire,
                $row->mont_investis,
            );
            $i++;
        }
        $responce['userdata']['code_membre'] = 'Total:';
        $responce['userdata']['mt_salaire'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $this->view->data = $responce;
    }

    public function mesrecusalAction() {
        
    }

    public function mesreculistsalAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 40);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $num = $user->code_membre;
        //Récupération des demandes de l'acteur du créneau d'activités qui sont accordées
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.alloc_creneau_sal = ?', 1)
                ->where('eu_smcipn.code_membre =?', $num);

        $smcipn = $tabela->fetchAll($select);

        $count = count($smcipn);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipn = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totsal = 0;
        $totinves = 0;
        foreach ($smcipn as $row) {
            $totsal+=$row->montant_salaire;
            $totinves+=$row->montant_investis;
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $heure_dem = new Zend_Date($row->heure_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                $row->montant_investis,
                $date_dem->toString('dd/mm/yyyy'),
                $heure_dem->toString('hh:mm'),
            );
            $i++;
        }
        $responce['userdata']['dvm_demand'] = 'Total:';
        $responce['userdata']['mt_salaire'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $this->view->data = $responce;
    }

    public function affectersalAction() {
        $selection = array();
        $selection = $_GET['lignes'];
        //$tot_salaire = $_GET['tot_salaire'];
        $this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_boss = $user->code_membre;
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $compte = new Application_Model_EuCompte();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $compte_credit = new Application_Model_EuCompteCredit();
                $cc_mapper = new Application_Model_EuCompteCreditMapper();
                $compte_source = 'nr-tpn-' . $num_boss;
                $res = $cm_mapper->find($compte_source, $compte);
                //Récupération du montant total des salaires affectés
                $cumul_sal = 0;
                foreach ($selection as $sele) {
                    $cumul_sal+=$sele['mt_affecte'];
                }
                if ($cumul_sal == 0) {
                    $this->view->data = 'echec';
                    return;
                } else if ($cumul_sal > $compte->getSolde()) {
                    $this->view->data = 'alloc_sal';
                    return;
                } else if ($res == false) {
                    $this->view->data = 'compte_err';
                    return;
                } else {
                    $date_all = new Zend_Date(Zend_Date::ISO_8601);
                    $date_alloc = clone $date_all;
                    foreach ($selection as $sel) {
                        $code_demand = $sel["code_demande"];
                        $num_membre = $sel["code_membre"];
                        $salaire = $sel["salaires"];
                        $mt_affecte = $sel["mt_affecte"];
                        $date_deb = $sel["date_deb"];
                        $date_fin = $sel["date_fin"];
                        $date1 = explode("/", $date_deb);
                        $date2 = explode("/", $date_fin);
                        if ($mt_affecte != '' and $date_deb != '' and $date_fin != '') {
                            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                            $datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                            //Mise à jour de la table eu_justifier
                            $mc = new Application_Model_EuJustifierMapper();
                            $justif = new Application_Model_EuJustifier;
                            $mc->find($num_membre, $code_demand, $justif);
                            $justif->setCode_membre($num_membre);
                            $justif->setCode_smcipn($code_demand);
                            $justif->setAffecter($justif->getAffecter() + $mt_affecte);
                            $justif->setSolde($justif->getSolde() - $mt_affecte);
                            //Vérification du montant à affecter par rapport au montant du salaire dispo
                            if ($mt_affecte > $salaire) {
                                $this->view->data = 'erreur';
                                return;
                            } else {
                                $mc->update($justif);
                            }
                            //Insertion du cumul des salaires dans la table compte de l'employé
                            $cat_compte = 'tcncs';
                            $num_comptes = 'nr-' . $cat_compte . '-' . $num_membre;
                            $result = $cm_mapper->find($num_comptes, $compte);
                            if ($result == false) {
                                $compte->setCode_membre($num_membre)
                                        ->setCode_cat($cat_compte)
                                        ->setCode_type_compte('nr')
                                        ->setSolde($mt_affecte)
                                        ->setDate_alloc($date_alloc->toString('yyyy-mm-dd'))
                                        ->setCode_compte($num_comptes)
                                        ->setLib_compte($cat_compte)
                                        ->setDesactiver(0);
                                $cm_mapper->save($compte);
                            } else {
                                $compte->setSolde($compte->getSolde() + $mt_affecte);
                                $cm_mapper->update($compte);
                            }
                            //Ajout dans la table opération
                            $compteur = 0;
                            $mapper = new Application_Model_EuOperationMapper();
                            $compteur = $mapper->findConuter() + 1;
                            $alloc = new Application_Model_EuOperation();
                            $alloc->setId_operation($compteur)
                                    ->setDate_op($date_alloc->toString('yyyy-mm-dd'))
                                    ->setHeure_op($date_alloc->toString('hh:mm'))
                                    ->setMontant_op($mt_affecte)
                                    ->setCode_membre($num_membre)
                                    ->setCode_produit('CNCSr')
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setLib_op('Affectation de salaire à l\'employé')
                                    ->setCode_cat('tcncs')
                                    ->setType_op('ase');
                            $mapper->save($alloc);
                            //Insertion des détails des salaires dans la table compte crédit
                            $compte_credit->setCode_membre($num_membre)
                                    ->setCode_produit('CNCSr')
                                    ->setMontant_place($mt_affecte)
                                    ->setDatedeb($dated)
                                    ->setDatefin($datef)
                                    ->setDate_octroi($date_alloc->toString('yyyy-mm-dd'))
                                    ->setSource($num_membre . $date_alloc->toString('yyyyMMddHHmmss'))
                                    ->setCode_compte($num_comptes)
                                    ->setMontant_credit($mt_affecte)
                                    ->setRenouveller('n')
                                    ->setId_operation($compteur)
                                    ->setCompte_source($code_demand)
                                    ->setKrr('n')
                                    ->setBnp(0)
                                    ->setDomicilier(0)
                                    ->setAffecter(0)
                                    ->setCode_type_credit('')
                                    ->setPrk(0);
                            $cc_mapper->save($compte_credit);
                        } else {
                            $this->view->data = 'echec';
                            return;
                        }
                    }

                    //Mise à jour du compte tpn de l'employeur
                    $cm_mapper->find($compte_source, $compte);
                    $compte->setSolde($compte->getSolde() - $cumul_sal);
                    $cm_mapper->update($compte);
                    //Mise à jour des comptes crédits tpn de l'employeur
                    $rest = $cc_mapper->findBySMC($code_demand, $compte_source);
                    if ($rest == false) {
                        $this->view->data = 'credit_err';
                        return;
                    } else {
                        $result = $rest[0];
                        if ($cumul_sal <= $result->getMontant_credit()) {
                            $compte_credit->setId_credit($result->getId_credit())
                                    ->setMontant_credit($result->getMontant_credit() - $cumul_sal)
                                    ->setCode_membre($result->getCode_membre())
                                    ->setCode_produit($result->getCode_produit())
                                    ->setMontant_place($result->getMontant_place())
                                    ->setDatefin($result->getDatefin())
                                    ->setDatedeb($result->getDatedeb())
                                    ->setSource($result->getSource())
                                    ->setDate_octroi($result->getDate_octroi())
                                    ->setCompte_source($result->getCompte_source())
                                    ->setKrr($result->getKrr())
                                    ->setRenouveller($result->getRenouveller())
                                    ->setId_operation($result->getId_operation())
                                    ->setCode_compte($result->getCode_compte())
                                    ->setBnp($result->getBnp())
                                    ->setDomicilier($result->getDomicilier())
                                    ->setAffecter($result->getAffecter())
                                    ->setCode_type_credit($result->getCode_type_credit())
                                    ->setPrk($result->getPrk());
                            $cc_mapper->update($compte_credit);
                        } else {
                            $this->view->data = 'credit_sal';
                            return;
                        }
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                $this->view->message = $message;
                return;
            }
        }
    }

    public function salaireaffecteAction() {
        $this->_helper->layout->disableLayout();
    }

    public function salaireafflistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuCompteCredit();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('c' => 'EU_cOMPTE_cREDIT'), array('*', "TO_cHAR((c.DATE_OcTROI),'dd/mm/yyyy') date_op", "TO_cHAR((c.DATE_OcTROI),'hh:mm') heure_op"))
                ->join(array('m' => 'EU_mEmBRE'), 'c.cODE_mEmBRE = m.cODE_mEmBRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE'))
                ->join(array('s' => 'EU_sMcIPNPWI'), 's.cODE_sMcIPN = c.cOMPTE_sOURcE', array('cODE_sMcIPN'))
                ->where('s.TYPE_sMCIPN = ?', 'sMCIPNWI')
                ->where('s.code_membre = ?', $user->code_membre)
                ->where('c.cODE_PRODUIT = ?', 'cNcSr')
                ->order('c.DATE_OcTROI', 'asc');
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
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                ucfirst($row->nom_membre) . ' ' . ucfirst($row->PREnom_membre),
                $row->code_produit,
                $row->montant_op,
                $row->date_op,
                $row->heure_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function investaffecteAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function investafflistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuCompteCredit();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('c' => 'EU_cOMPTE_cREDIT'), array('*', "TO_cHAR((c.DATE_OcTROI),'dd/mm/yyyy') date_op", "TO_cHAR((c.DATE_OcTROI),'hh:mm') heure_op"))
                ->join(array('m' => 'EU_mEmBRE_mORALE'), 'c.cODE_mEmBRE = m.cODE_mEmBRE_mORALE', array('RAISON_SOcIALE'))
                ->join(array('s' => 'EU_sMcIPNPWI'), 's.cODE_sMcIPN = c.cOMPTE_sOURcE', array('cODE_sMcIPN'))
                ->where('s.TYPE_sMCIPN = ?', 'sMCIPNWI')
                ->where('s.code_membre = ?', $user->code_membre)
                ->where('c.cODE_PRODUIT = ?', 'Ir')
                ->order('c.DATE_OcTROI', 'asc');
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
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                ucfirst($row->nom_membre) . ' ' . ucfirst($row->PREnom_membre),
                $row->code_produit,
                $row->montant_op,
                $row->date_op,
                $row->heure_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function domiciliationAction() {
        $this->_helper->layout->disableLayout();
    }

    public function domicilistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        $select->from(array('d' => 'eu_domiciliation'))
                ->where('d.code_membre_beneficiaire = ?', $user->code_membre)
                ->where('d.type_domiciliation = ?', 'SMCIPNWI')
                ->order('d.date_domiciliation desc');
        $domici = $tabela->fetchAll($select);
        $count = count($domici);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $domici = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($domici as $row) {
            if ($row->domicilier == 'N') {
                $accord = 'En cours';
            } else {
                $accord = 'Terminer';
            }
			$date_dom   = new Zend_Date($row->date_domiciliation, Zend_Date::ISO_8601);
			$date_echue = new Zend_Date($row->date_echue, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_domicilier;
            $responce['rows'][$i]['cell'] = array(
               $row->code_domicilier,
               $row->code_membre_assurreur,
               $row->cat_ressource,
               $row->montant_subvent,
               $row->montant_domicilier,
               $date_dom->toString('dd/MM/yyyy'),
               $date_echue->toString('dd/MM/yyyy'),
               $accord,
               $row->type_domiciliation,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listcreditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 30);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $request = $this->getRequest();
        $code_domici = $request->code_domicil;
        $tabela = new Application_Model_DbTable_EuDetailDomicilie();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
               ->from(array('d' => 'eu_detail_domicilie'), array('code_membre', 'mont' => 'montant_credit'))
               ->join(array('c' => 'eu_compte_credit'), 'c.id_credit = d.id_credit', array('code_produit', 'montant_place', 'montant_credit', 'compte_source', 'id_credit'))
               ->where('d.code_domicilier = ?', $code_domici);
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

        //Récupération de la prk et de la pck pour les r
        $prk = 0;
        $pck = 1;
        $param = new Application_Model_EuParametresMapper();
        $par = new Application_Model_EuParametres();
        $par_prk = $param->find('prk', 'r', $par);
        if ($par_prk == true) {
            $prk = $par->getMontant();
        }
        $par_pck = $param->find('pck', 'r', $par);
        if ($par_pck == true) {
            $pck = $par->getMontant();
        }
        $type_bnp = array('cscoe', 'cmit', 'cacb', 'capu', 'caipc');
        foreach ($alloc as $row) {
            //Calcul du montant crédit pr les RPGr et Ir provenant d'un capa
            $prod = $row->code_produit;
            $compte_source = $row->compte_source;
            if (($prod == 'RPGr' || $prod == 'Ir') and !in_array($compte_source, $type_bnp)) {
                $mt_credit = floor($row->montant_place * $prk / $pck);
            } else {
                $mt_credit = $row->montant_credit + $row->mont;
            }
			$dateoctroi  = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $row->code_produit,
                $row->montant_place,
                $mt_credit,
                $row->mont,
                $dateoctroi->toString('dd/MM/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function budgetinvestisAction() {

        $form = new Application_Form_EuBudgetInvestissement();

        $this->view->form = $form;
    }

    public function alertesAction() {
        // action body
    }

    public function myalerteAction() {
        // action body
    }

    public function alerteslistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_alerte');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuAlerte();

        $code_membre_gac = $user->code_membre;
        $code_gac = $user->code_acteur;

        //Récupération des alertes concernant la gac centrale
        $select1 = $tabela->select();
        $select1->setIntegrityCheck(false)
                ->where('eu_alerte.code_membre_acteur =?', $code_membre_gac);

        //Récupération du code des filières liées à la gac centrale
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->where('code_gac = ?', $code_gac);
        $listfil = $tabel->fetchAll($sel);
        $rep = array('');
        $mb = array('');
        $i = 0;
        foreach ($listfil as $row) {
            $rep[$i] = $row->code_gac_filiere;
            $mb[$i] = $row->code_membre;
            $i++;
        }
        //Récupération des alertes concernant les gac filières
        $select2 = $tabela->select();
        $select2->setIntegrityCheck(false)
                ->where('eu_alerte.code_membre_acteur in (?)', $mb);

        //Récupération du code des créneaux liés aux filières
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->where('code_gac_filiere in (?)', $rep);
        $listcre = $tabelc->fetchAll($selc);
        $ccre = array('');
        $cde = array('');
        $i = 0;
        foreach ($listcre as $row) {
            $ccre[$i] = $row->code_creneau;
            $cde[$i] = $row->code_membre;
            $i++;
        }
        //Récupération des alertes concernant les créneaux d'activités
        $select3 = $tabela->select();
        $select3->setIntegrityCheck(false)
                ->where('eu_alerte.code_membre_acteur in (?)', $cde);

        //Récupération des numéros membre des acteurs liés aux créneaux
        $tabeld = new Application_Model_DbTable_EuActeurCreneau();
        $seld = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $seld->setIntegrityCheck(false)
                ->where('code_creneau in (?)', $ccre);
        $listact = $tabeld->fetchAll($seld);
        $repc = array('');
        $i = 0;
        foreach ($listact as $row) {
            $repc[$i] = $row->code_membre;
            $i++;
        }
        //Récupération des alertes concernant l'acteur créneau
        $select4 = $tabela->select();
        $select4->setIntegrityCheck(false)
                ->where('eu_alerte.code_membre_acteur in (?)', $repc);

        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->union(array($select4, $select3, $select2, $select1));
        $alerte = $tabela->fetchAll($select);

        $alerte = $tabela->fetchAll();
        $count = count($alerte);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $limit = 0;
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $alerte = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($alerte as $row) {
            $date_alerte = new Zend_Date($row->date_alerte, Zend_Date::ISO_8601);
            $heure_alerte = new Zend_Date($row->heure_alerte, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_alerte;
            $responce['rows'][$i]['cell'] = array(
                $row->id_alerte,
                $row->code_membre_client,
                $row->code_membre_assureur,
                $row->code_membre_acteur,
                $row->lib_alerte,
                $row->code_smcipn,
                $date_alerte->toString('dd/MM/yyyy'),
                $heure_alerte->toString('hh:mm:ss'),
                $row->motif_alerte,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function myalertelistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_alerte');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuAlerte();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('a' => 'eu_alerte'))
                ->where("code_membre_acteur = ?", $user->code_membre)
                ->order("date_alerte desc");
        $alerte = $tabela->fetchAll($select);
        $count = count($alerte);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $limit = 0;
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $alerte = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($alerte as $row) {
		    $datealerte = new Zend_Date($row->date_alerte, Zend_Date::ISO_8601);
            $heurealerte = new Zend_Date($row->heure_alerte, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_alerte;
            $responce['rows'][$i]['cell'] = array(
                $row->id_alerte,
                $row->code_membre_client,
                $row->CODE_MEMBREçassureur,
                $row->code_membre_acteur,
                $row->lib_alerte,
                $row->code_smcipn,
                $datealerte->toString('dd/MM/yyyy'),
                $heurealerte->toString('HH:mm:ss'),
                $row->motif_alerte,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function smcipnrejeterAction() {
        $this->_helper->layout->disableLayout();
    }

    public function smcipnrejeterlistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $num = $user->code_membre;
        //Récupération des demandes de l'acteur du créneau d'activités qui sont rejetées
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->where('eu_smcipn.valid_creneau = ?', 2)
                ->orWhere('eu_smcipn.valid_fil = ?', 2)
                ->orWhere('eu_smcipn.valid_gac = ?', 2)
                ->where('eu_smcipn.code_membre =?', $num);
        $smcipn = $tabela->fetchAll($select);

        $count = count($smcipn);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipn = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totsal = 0;
        $totinves = 0;
        foreach ($smcipn as $row) {
            $totsal+=$row->montant_salaire;
            $totinves+=$row->montant_investis;
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $heure_dem = new Zend_Date($row->heure_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                $row->montant_investis,
                $date_dem->toString('dd/MM/yyyy'),
                $heure_dem->toString('hh:mm:ss'),
            );
            $i++;
        }
        $responce['userdata']['dvm_demand'] = 'Total:';
        $responce['userdata']['mt_salaire'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $this->view->data = $responce;
    }

    public function relancersmcipnAction() {
        //$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        //$user = $auth->getIdentity();
        //$group = $user->code_groupe;
        $code_demand = $_GET['code'];
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $mdo = new Application_Model_EuSmcipnMapper();
            $do = new Application_Model_EuSmcipn();
            $smc_db = new Application_Model_DbTable_EuSmcipn();
            $smc_find = $smc_db->find($code_demand);
            if (count($smc_find) == 1) {
                $result = $smc_find->current();
                $do->setLib_demande($result->lib_demande);
                $do->setCode_membre($result->code_membre);
                $do->setType_smcipn($result->type_smcipn);
                $do->setDesc_demande($result->desc_demande);
                $do->setReq_demande($result->req_demande);
                $do->setDate_demande($result->date_demande);
                $do->setHeure_demande($result->heure_demande);
                $do->setDate_deb($result->date_deb);
                $do->setDate_fin($result->date_fin);
                $do->setDate_alloc($result->date_alloc);
                $do->setDvm_demande($result->dvm_demande);
                $do->setMontant_salaire($result->montant_salaire);
                $do->setMontant_investis($result->montant_investis);
                $do->setSalaire_alloue($result->salaire_alloue);
                $do->setInvestis_alloue($result->investis_alloue);
                $do->setSal_transmis($result->sal_transmis);
                $do->setEtat_demande_inv($result->etat_demande_inv);
                $do->setId_utilisateur($result->id_utilisateur);
                $do->setSource_demande($result->source_demande);
                $do->setValid_gac(0);
                $do->setValid_fil(0);
                $do->setValid_creneau(0);
                $do->setAlloc_gac_inv($result->alloc_gac_sal);
                $do->setAlloc_fil_inv($result->alloc_fil_sal);
                $do->setAlloc_creneau_inv($result->alloc_creneau_sal);
                $do->setType_objet($result->type_objet);
                $do->setCode_gac($result->code_gac);
                $do->setDomicilier($result->domicilier);
                $do->setRembourser($result->rembourser);
                $do->setAllouer_i($result->allouer_i);
                $do->setAllouer_s($result->allouer_s);
                $do->setType_alloc($result->type_alloc);
                $do->setEtat_demande_sal($result->etat_demande_sal);
                $do->setAlloc_gac_sal($result->alloc_gac_sal);
                $do->setAlloc_fil_sal($result->alloc_fil_sal);
                $do->setAlloc_creneau_sal($result->alloc_creneau_sal);
                $do->setEtat_sal($result->etat_sal);
            }
            $do->setCode_smcipn($code_demand);
            $mdo->update($do);

            $db->commit();
            $this->view->data = true;
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
            $this->view->message = $message;
            $this->view->data = false;
            return;
        }
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $type_membre = $_GET['type_membre'];
        if ($type_membre == 'P') {
            $membre_db = new Application_Model_DbTable_EuMembre();
            $membre_find = $membre_db->find($num_membre);
        } else if ($type_membre == 'M') {
            $membre_db = new Application_Model_DbTable_EuMembreMorale();
            $membre_find = $membre_db->find($num_membre);
        }
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            if ($type_membre == 'P') {
                $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
            } else {
                $data = strtoupper($result->raison_sociale);
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function employeAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        $code_membre = $user->code_membre;
        $membremap = new Application_Model_EuMembreMapper();
        $membre = new Application_Model_EuMembre();
        $raison_sociale = '';
        $find_memb = $membremap->find($code_membre, $membre);
        if ($find_memb != false) {
            $raison_sociale = $membre->getRaison_sociale();
        }
        $this->view->code_membre = $code_membre;
        $this->view->raison_soc = $raison_sociale;
        if ($request->isPost()) {
            $code_employeur = $request->code_membre;
            $code_employe = $request->code_membre_employe;
            $nom_employe = $request->nom_membre;
            $prenom_employe = $request->prenom_membre;
            $raison = $request->raison_soc;
            $cnss = $request->cnss;
            $mont_salaire = $request->mont_salaire;
            $date = Zend_Date::now();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $t_employe = new Application_Model_DbTable_EuEmploye();
                $emp_select = $t_employe->select();
                $emp_select->where('code_membre_employe like ?', $code_employe)
                        ->where('code_membre_employeur like ?', $code_employeur);
                $results = $t_employe->fetchAll($emp_select);
                if (count($results) > 0) {
                    $row = $results->current();
                    $db->rollback();
                    $this->view->message = 'Ce membre N°: ' . $code_employe . ' a été déjà enregistré chez l\'employeur N°: ' . $row->code_membre_employeur . ' !!!';
                    return;
                } else {
                    $employe = new Application_Model_EuEmploye();
                    $employe->setCnss(0)
                            ->setCode_membre_employe($code_employe)
                            ->setCode_membre_employeur($code_employeur)
                            ->setDate_declaration($date->toString('yyyy-mm-dd'))
                            ->setMont_salaire($mont_salaire)
                            ->setId_utilisateur($user->id_utilisateur);
                    if (isset($cnss)) {
                        $employe->setCnss(1);
                    } else {
                        $employe->setCnss(0);
                    }
                    $t_employe->insert($employe->toArray());
                    $db->commit();
                    $this->view->message = 'Employe ' . $code_employe . ' enregistré avec succès !!!';
                    return;
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . '<-> ' . $cnss . '<->' . $exc->getTraceAsString();
                $this->view->code_membre = $code_employeur;
                $this->view->code_membre_employe = $code_employe;
                $this->view->nom_membre = $nom_employe;
                $this->view->prenom_membre = $prenom_employe;
                $this->view->raison_soc = $raison;
                $this->view->cnss = $cnss;
                $this->view->setMont_salaire = $mont_salaire;
                return;
            }
        }
    }

    public function membrephysAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $select->where('type_membre=?', 'P');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function membremoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $select->where('type_membre=?', 'M');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function recupnom1Action() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[0] = strtoupper($result->nom_membre);
            $data[1] = ucfirst($result->prenom_membre);
            if ($result->type_membre == 'm') {
                $data[2] = $result->raison_sociale;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function myemployeAction() {
        
    }

    public function myemployelistAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $id_user = $user->id_utilisateur;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'id_employe');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuEmploye();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_employe.code_membre_employe')
                ->where('eu_employe.code_membre_employeur = ?', $code_membre)
                ->orwhere('eu_employe.id_utilisateur = ?', $id_user)
                ->order('eu_membre.nom_membre asc');
        $emp = $tabela->fetchAll($select);
        $count = count($emp);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $emp = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totsal = 0;
        foreach ($emp as $row) {
            if ($row->cnss == 1) {
                $cnss = 'Oui';
            } else {
                $cnss = 'Non';
            }
            $totsal+=$row->mont_salaire;
            $date_declare = new Zend_Date($row->date_declaration, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_employe;
            $responce['rows'][$i]['cell'] = array(
                $row->id_employe,
                $row->code_membre_employe,
                strtoupper($row->nom_membre) . ' ' . ucfirst($row->prenom_membre),
                $date_declare->toString('dd/mm/yyyy'),
                $cnss,
                $row->mont_salaire
            );
            $i++;
        }
        $responce['userdata']['cnss'] = 'Total:';
        $responce['userdata']['salaire'] = $totsal;
        $this->view->data = $responce;
    }

    public function editemployeAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $code_employeur = $request->code_membre;
            $code_employe = $request->code_membre_employe;
            $nom_employe = $request->nom_membre;
            $prenom_employe = $request->prenom_membre;
            $raison = $request->raison_soc;
            $cnss = $request->cnss;
            $mont_salaire = $request->mont_salaire;
            $id_employe = $request->id_employe;
            $date = Zend_Date::now();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $t_employe = new Application_Model_DbTable_EuEmploye();
                $emp_select = $t_employe->select();
                $emp_select->where('id_employe like ?', $id_employe);
                $results = $t_employe->fetchAll($emp_select);
                if (count($results) > 0) {
                    $employe = new Application_Model_EuEmploye();
                    $employe->setId_employe($id_employe)
                            ->setCnss(0)
                            ->setCode_membre_employe($code_employe)
                            ->setCode_membre_employeur($code_employeur)
                            ->setDate_declaration($date->toString('yyyy-mm-dd'))
                            ->setMont_salaire($mont_salaire)
                            ->setId_utilisateur($user->id_utilisateur);
                    if (isset($cnss)) {
                        $employe->setCnss(1);
                    } else {
                        $employe->setCnss(0);
                    }
                    $t_employe->update($employe->toArray(), array('id_employe = ?' => $employe->getId_employe()));
                    $db->commit();
                    $this->view->message = 'Employe ' . $code_employe . ' modifié avec succès !!!';
                    return $this->_helper->redirector('myemploye');
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . '<-> ' . $cnss . '<->' . $exc->getTraceAsString();
                $this->view->code_membre = $code_employeur;
                $this->view->code_membre_employe = $code_employe;
                $this->view->nom_membre = $nom_employe;
                $this->view->prenom_membre = $prenom_employe;
                $this->view->raison_soc = $raison;
                $this->view->cnss = $cnss;
                $this->view->mont_salaire = $mont_salaire;
                $this->view->id_employe = $id_employe;
                return;
            }
        } else {
            $this->_helper->layout->disableLayout();
            $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
            $request = $this->getRequest();
            $code_membre = $user->code_membre;
            $membremap = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
            $raison_sociale = '';
            $find_memb = $membremap->find($code_membre, $membre);
            if ($find_memb != false) {
                $raison_sociale = $membre->getRaison_sociale();
            }
            $this->view->code_membre = $code_membre;
            $this->view->raison_soc = $raison_sociale;
            $id_employe = $request->id_employe;
            $tabela = new Application_Model_DbTable_EuEmploye();
            $select = $tabela->select();
            $select->where('id_employe like ?', $id_employe);
            $employes = $tabela->fetchAll($select);
            $row = $employes->current();
            $find_memb = $membremap->find($row->code_membre_employe, $membre);
            $nom_membre = $membre->getNom_membre();
            $prenom_membre = $membre->getPrenom_membre();
            $this->view->code_membre_employe = $row->code_membre_employe;
            $this->view->nom_membre = $nom_membre;
            $this->view->prenom_membre = $prenom_membre;
            $this->view->cnss = $row->cnss;
            $this->view->mont_salaire = $row->mont_salaire;
            $this->view->id_employe = $id_employe;
        }
    }

    public function ajoutfraisAction() {
        
    }

    public function offrechangeAction() {
        $code_membre = $_GET['num_membre'];
        $data = array();
        $table = new Application_Model_DbTable_EuProposition();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->from(array('p' => 'eu_proposition'))
                ->join(array('a' => 'eu_appel_offre'), 'a.id_appel_offre = p.id_appel_offre')
                ->where('p.disponible = ?', 1)
                ->where('p.choix_proposition = ?', 1)
                ->where('p.code_membre_morale = ?', $code_membre);
        $bes = $table->fetchAll($select);
        $i = 0;
        foreach ($bes as $value) {
            $data[$i][1] = $value->id_proposition;
            $data[$i][2] = ucfirst($value->nom_appel_offre);
            $i++;
        }
        $this->view->data = $data;
    }

    public function offrechange2Action() {
        $id_propo = $_GET['id_propo'];
        $data = array();
        $table = new Application_Model_DbTable_EuProposition();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->from(array('p' => 'eu_proposition'))
                ->join(array('a' => 'eu_appel_offre'), 'a.id_appel_offre = p.id_appel_offre')
                ->where('p.disponible = ?', 1)
                ->where('p.choix_proposition = ?', 1)
                ->where('p.id_proposition = ?', $id_propo);
              
        $bes = $table->fetchAll($select);
        $i = 0;
        foreach ($bes as $value) {
            $data[$i][1] = $value->id_proposition;
            $data[$i][2] = ucfirst($value->nom_appel_offre);
            $i++;
        }
        $this->view->data = $data;
    }

    public function montantprojetAction() {
        $id = $_GET["id_proposition"];
        $t_propo = new Application_Model_DbTable_EuProposition();
        $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('eu_proposition.id_proposition = ?', $id);
        $propo = $t_propo->fetchAll($select);
        if (count($propo) > 0) {
           $mont_projet = $propo->current()->montant_proposition + $propo->current()->montant_salaire + $propo->current()->autre_budget;
           $data = number_format($mont_projet, 0, ',', '');
        } else {
            $data = 0;
        }
        $this->view->data = $data;
    }

    public function fraisAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function fraislistAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_frais');
        $sord = $this->_request->getParam("sord", 'desc');
        $disponible = $this->_request->getParam("disponible");
        $tabela = new Application_Model_DbTable_EuFrais();
        $request = $this->getRequest();
        $id_frais = $request->id_frais;
        $date = $request->date;
		
		if(isset($_GET["date"]) && ($date != '')) {
		   $date = explode("/",$date);
           $date = $date[2] . '-' . $date[1] . '-' . $date[0];
		}
		
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('f' => 'eu_frais'))
                ->join(array('p' => 'eu_proposition'), 'f.id_proposition = p.id_proposition')
                ->join(array('a' => 'eu_appel_offre'), 'a.id_appel_offre = p.id_appel_offre');
        if ($id_frais == '' && $date == '') {
            $select->where('f.id_frais like ?', '%');
            $select->where('f.date_frais like ?', '%');
        } elseif ($id_frais != '' && $date == '') {
            $select->where('f.id_frais like ?', $id_frais);
        } elseif ($id_frais == '' && $date != '') {
            $select->where("f.date_frais like ?", $date);
        } elseif ($id_frais != '' && $date != '') {
            $select->where('f.id_frais like ?', $id_frais);
            $select->where("f.date_frais like ?", $date);
        }
        $propo = $tabela->fetchAll($select);

        $count = count($propo);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $smcipn = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $tot_projet = 0;
        $tot_frais = 0;
        $tot_global = 0;
        foreach ($smcipn as $row) {
            if($row->disponible == 0){
               $disponible='Non';
            } else {
               $disponible='Oui';
            }
            $mt_projet = $row->montant_salaire + $row->montant_proposition + $row->autre_budget;
            $mt_frais = $row->mont_projet - $mt_projet;
            $tot_projet+=$mt_projet;
            $tot_frais+=$mt_frais;
            $tot_global+=$row->mont_projet;
			$date_frais   =   new Zend_Date($row->date_frais, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_frais;
            $responce['rows'][$i]['cell'] = array(
                $row->id_frais,
                $row->id_proposition,
                ucfirst($row->nom_appel_offre),
                $row->code_membre_morale,
                $date_frais->toString('dd/MM/yyyy'),
                $mt_projet,
                $mt_frais,
                $row->mont_projet,
                $disponible
            );
            $i++;
        }
        $responce['userdata']['nom_appel_offre'] = 'Total: (' + $count + ')';
        $responce['userdata']['mt_marche'] = $tot_projet;
        $responce['userdata']['fais'] = $tot_frais;
        $responce['userdata']['total'] = $tot_global;
        $this->view->data = $responce;
    }

    public function fraischangeAction() {
        $data = array();
        $table = new Application_Model_DbTable_EuFrais();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->from(array('f' => 'eu_frais'))
                ->join(array('p' => 'eu_proposition'), 'f.id_proposition = p.id_proposition')
                ->join(array('a' => 'eu_appel_offre'), 'a.id_appel_offre = p.id_appel_offre');
        $bes = $table->fetchAll($select);
        $this->view->select = $select;
        $i = 0;
        foreach ($bes as $value) {
            $data[$i][1] = $value->id_frais;
            $data[$i][2] = ucfirst($value->nom_appel_offre);
            $i++;
        }
        $this->view->data = $data;
    }

    public function validerfraisAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $frais = new Application_Model_EuFrais();
        $mfrais = new Application_Model_EuFraisMapper();
        if ($this->getRequest()->isPost()) {
            $id_proposition = $_POST['id_proposition'];
            $code_membre = $_POST['code_membre'];
            $mt_projet = $_POST['mt_projet'];
            $taux_frais = $_POST['taux_frais'];
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //vérification de l'existence des frais de surveillance
                $find_frais = $mfrais->findFraisByPropo($id_proposition, $frais);
                if ($find_frais) {
                    $this->view->data = 'no_frais';
                    return;
                } else {
                $proposition = new Application_Model_EuProposition();
                $mproposition = new Application_Model_EuPropositionMapper();
		        $mproposition->find($id_proposition, $proposition);
		
                $mont_frais = ($mt_projet * $taux_frais / 100);
			    $mont_projet = $mt_projet + $mont_frais;
                //Enregistrement dans la table eu_frais
                $id_frais = $mfrais->findConuter() + 1;
                $frais->setId_frais($id_frais)
                      ->setCode_gac($user->code_acteur)
                      ->setPourcent_frais($taux_frais)
                      ->setMont_projet($mont_projet)
                      ->setDate_frais($date->toString('yyyy-MM-dd HH:mm:ss'))
                      ->setId_proposition($id_proposition)
                      ->setMontant_proposition($proposition->getMontant_proposition())
                      ->setMontant_salaire($proposition->getMontant_salaire())
                      ->setMontant_frais($mont_frais)
                      ->setDisponible(0)
                      ->setId_utilisateur($user->id_utilisateur);
                $mfrais->save($frais);
                }
                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->data = 'bad';
                return;
            }
        }
    }

    public function editfraisAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $id_frais = $request->id_frais;
        $code_membre = $request->code_membre;
        $id_proposition = $request->id_proposition;
        $frais = new Application_Model_EuFrais();
        $mfrais = new Application_Model_EuFraisMapper();
        $find_frais = $mfrais->find($id_frais, $frais);
        if ($find_frais != false) {
            //Récupération du montant brut du marché
            $propo = new Application_Model_EuProposition();
            $mpropo = new Application_Model_EuPropositionMapper();
            $mpropo->find($id_proposition, $propo);
            $mt_projet = $propo->getMontant_proposition() + $propo->getMontant_salaire() + $propo->getAutre_budget();
            //Récupération de la raison sociale du bénéficiaire du marché                   
            $mmember = new Application_Model_EuMembreMoraleMapper();
            $member = new Application_Model_EuMembreMorale();
            $mmember->find($code_membre, $member);
            $this->view->code_membre = $code_membre;
            $this->view->raison_sociale = $member->getRaison_sociale();
            $this->view->id_proposition = $id_proposition;
            $this->view->mt_projet = $mt_projet;
            $this->view->taux_frais = $frais->getPourcent_frais();
            $this->view->id_frais = $id_frais;
        }
    }

    public function validereditAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $frais = new Application_Model_EuFrais();
        $mfrais = new Application_Model_EuFraisMapper();
        $domi = new Application_Model_EuDomiciliation();
        $mdomi = new Application_Model_EuDomiciliationMapper();
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $id_frais = $this->getRequest()->id_frais;
                $id_proposition = $this->getRequest()->id_proposition;
                $code_membre = $this->getRequest()->code_membre;
                $mt_projet = $this->getRequest()->mt_projet;
                $taux_frais = $this->getRequest()->taux_frais;
                //vérification de l'utilisation des frais pr la demande de la smcipnwi
                $find_domi = $mdomi->findByProposition($id_proposition);
                if (count($find_domi) >= 1) {
                    $this->view->data = 'impos';
                    return;
                } else {
        $proposition = new Application_Model_EuProposition();
        $mproposition = new Application_Model_EuPropositionMapper();
		$mproposition->find($id_proposition, $proposition);
		
                    $mont_frais = ($mt_projet * $taux_frais / 100);
					$mont_projet = $mt_projet + $mont_frais;
                    $mfrais->find($id_frais, $frais);
                    //Modification dans la table eu_frais
                    $frais->setId_frais($frais->getId_frais())
                            ->setCode_gac($frais->getCode_gac())
                            ->setPourcent_frais($taux_frais)
                            ->setMont_projet($mont_projet)
                            ->setDate_frais($frais->getDate_frais())
                            ->setId_proposition($id_proposition)
                            ->setMontant_proposition($proposition->getMontant_proposition())
                            ->setMontant_salaire($proposition->getMontant_salaire())
                            ->setMontant_frais($mont_frais)
                            ->setDisponible(0)
                            ->setId_utilisateur($frais->getId_utilisateur());
                    $mfrais->update($frais);
                }
                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->data = 'bad';
                return;
            }
        }
    }

    
    public function disponibleAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $selection = array();
      $selection = $_GET['lignes'];
      $frais_map = new Application_Model_EuFraisMapper();
      $frais = new Application_Model_EuFrais();
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          foreach ($selection as $sel) {
             $id_frais = $sel['id_frais'];
             $ret = $frais_map->findValider($id_frais, $frais);
             if ($ret) {
                $frais->setDisponible(1);
                $frais_map->update($frais);
             }
                 
          }    
          $db->commit();
          $this->view->data = 'good';
          return;
        } catch (Exception $exc) {
            $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                 $this->view->data = 'bad';
                 return;
        }    
    }
    
    public function indisponibleAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $selection = array();
      $selection = $_GET['lignes'];
      $frais_map = new Application_Model_EuFraisMapper();
      $frais = new Application_Model_EuFrais();
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          foreach ($selection as $sel) {
             $id_frais = $sel['id_frais'];
             $ret = $frais_map->findValider($id_frais, $frais);
             if ($ret) {
                $frais->setDisponible(0);
                $frais_map->update($frais);
             }
                 
          }    
          $db->commit();
          $this->view->data = 'good';
          return;
        } catch (Exception $exc) {
            $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                 $this->view->data = 'bad';
                 return;
        }    
    }
    


    public function factureimpayeAction() {
        
    }

    public function factureimpayelistAction() {

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
                ->from(array('f' => 'eu_facture_smcipn'))
                ->join(array('d' => 'eu_domiciliation'),'d.code_smcipn = f.code_smcipn', array('code_domicilier', 'code_smcipn', 'id_proposition'))
                ->join(array('p' => 'eu_proposition'),'d.id_proposition = p.id_proposition', array('p.Id_pROpOSITION', 'p.Id_AppEL_OFFRE'))
                ->join(array('a' => 'eu_appel_offre'),'a.id_appel_offre = p.id_appel_offre', array('id_appel_Offre', 'numero_offre', 'nom_appel_offre'))
                ->where('p.choix_proposition = ?', 1)
                ->where('f.etat_facture = ?', 0);
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
			$date_facture   =   new Zend_Date($row->date_facture, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_facture;
            $responce['rows'][$i]['cell'] = array(
                $row->code_facture,
                ucfirst($row->nom_appel_offre),
                $row->code_membre_morale,
                ucfirst($row->type_facture),
                $date_facture->toString('dd/MM/yyyy'),
                $row->mont_facture,
            );
            $i++;
        }
        $responce['userdata']['code_facture'] = 'Total:';
        $responce['userdata']['mont_facture'] = $tot_facture;
        $this->view->data = $responce;
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
                    ->from(array('d' => 'eu_facture_smcipn_detail'), '*')
                    ->join(array('m' => 'eu_membre'), 'm.code_membre = d.code_membre_salarier', array('code_membre', 'nom_membre', 'prenom_membre'))
                    ->where('d.code_facture = ?', $code_facture);
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
                    strtoupper($row->nom_membre) . ' ' . ucfirst($row->prenom_membre),
                    $row->mont_salaire
                );
                $i++;
            }
            $this->view->data = $responce;
        } else if ($type_facture == 'Investissement') {
            $select->setIntegrityCheck(false)
                    ->from(array('d' => 'eu_facture_smcipn_detail'), '*')
                    ->join(array('m' => 'eu_membre_morale'), 'm.code_membre_morale = d.code_membre_fournisseur', array('code_membre_morale', 'raison_sociale'))
                    ->where('d.code_facture = ?', $code_facture);
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
                ->from(array('f' => 'eu_facture_smcipn'))
                ->join(array('d' => 'eu_domiciliation'), 'd.code_smcipn = f.code_smcipn', array('code_domicilier', 'code_smcipn', 'id_proposition'))
                ->join(array('p' => 'eu_proposition'), 'd.id_proposition = p.id_proposition', array('p.id_proposition', 'p.id_appel_offre'))
                ->join(array('a' => 'eu_appel_offre'), 'a.id_appel_offre = p.id_appel_offre', array('id_appel_offre', 'numero_offre', 'nom_appel_offre'))
                ->where('p.choix_proposition = ?', 1)
                ->where('f.etat_facture = ?', 1);
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


    public function payerAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        //$selection = array();
        $selection = $_GET['lignes'];
        $fact = new Application_Model_EuFactureSmcipn();
        $mfact = new Application_Model_EuFactureSmcipnMapper();
        $dfact = new Application_Model_EuFactureSmcipnDetail();
        $mdfact = new Application_Model_EuFactureSmcipnDetailMapper();
        $compte = new Application_Model_EuCompte();
        $mcompte = new Application_Model_EuCompteMapper();
        $credit = new Application_Model_EuCompteCredit();
        $mcredit = new Application_Model_EuCompteCreditMapper();
        $oper = new Application_Model_EuOperation();
        $moper = new Application_Model_EuOperationMapper();
        $nn = new Application_Model_EuNn();
        $mnn = new Application_Model_DbTable_EuNn();
        $utilnn = new Application_Model_EuUtiliserNn();
        $mutilnn = new Application_Model_EuUtiliserNnMapper();
        $cnp = new Application_Model_EuCnp();
        $mcnp = new Application_Model_EuCnpMapper();
        $cconso = new Application_Model_EuCreditConsommer();
        $mcconso = new Application_Model_EuCreditConsommerMapper();
        $tegc = new Application_Model_EuTegc();
        $mtegc = new Application_Model_EuTegcMapper();
        $smc = new Application_Model_EuSmc();
        $msmc = new Application_Model_EuSmcMapper();
        $gcp = new Application_Model_EuGcp();
        $mgcp = new Application_Model_EuGcpMapper();
        $mmembre = new Application_Model_EuMembreMoraleMapper();
        $membre = new Application_Model_EuMembreMorale();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                foreach ($selection as $val) {
                    $code_facture = $val['code_facture'];
                    $code_client = $val['code_membre'];
                    $mont_fact = $val['mont_facture'];
                    $type_fact = $val['type_facture'];
                    //Vérification du montant à payer par rapport au montant du compte de smcipnwi
                    $code_compte = 'nr-smcipnwi-' . $code_client;
                    $find_compte = $mcompte->find($code_compte, $compte);
                    if ($find_compte != false) {
                        $mont_compte = $compte->getSolde();
                        if ($mont_compte < $mont_fact) {
                            $db->rollback();
                            $this->view->data = 'low_amount';
                            return;
                        } else {
                            //Mise à jour de l'état de la facture
                            $mfact->find($code_facture, $fact);
                            $fact->setEtat_facture(1);
                            $mfact->update($fact);
                            $code_smcipn = $fact->getCode_smcipn();
                            //Recherche des détails factures liées à la facture
                            $find_dfact = $mdfact->findByFacture($code_facture);
                            if (count($find_dfact) > 0) {
                                $date_echue = clone $date;
                                $date_echue->addDay(30);
                                if ($type_fact == 'Salaire') {
                                    for ($i = 0; $i < count($find_dfact); $i++) {
                                        $code_salarier = $find_dfact[$i]->getCode_membre_salarier();
                                        $mont_salaire = $find_dfact[$i]->getMont_salaire();
                                        $compte_nr = 'nr-tcncs-' . $code_salarier;
                                        //Recherche et création du compte tcncs
                                        $find_nr = $mcompte->find($compte_nr, $compte);
                                        if ($find_nr != false) {
                                            $compte->setCode_compte($compte->getCode_compte())
                                                    ->setSolde($mont_salaire);
                                            $mcompte->update($compte);
                                        } else {
                                            $compte->setCode_compte($compte_nr)
                                                    ->setCode_membre($code_salarier)
                                                    ->setMifareCard('')
                                                    ->setLib_compte('TCNCS')
                                                    ->setSolde($mont_salaire)
                                                    ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                    ->setCode_type_compte('nr')
                                                    ->setCode_cat('TCNCS')
                                                    ->setDesactiver(0)
                                                    ->setCardPrintedDate('')
                                                    ->setCardPrintedIDDate('')
                                                    ->setNumero_carte(null)
                                                    ->setCode_membre_morale(null);
                                            $mcompte->save($compte);
                                        }
                                        //Enregistrement dans la table eu_operation
                                        $id_operation = $moper->findConuter() + 1;
                                        $oper->setId_operation($id_operation)
                                                ->setDate_op($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setHeure_op($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setMontant_op($mont_salaire)
                                                ->setCode_membre($code_salarier)
                                                ->setCode_produit('CNCSr')
                                                ->setId_utilisateur($user->id_utilisateur)
                                                ->setLib_op('Affectation de salaire à l\'employé')
                                                ->setCode_cat('TCNCS')
                                                ->setType_op('ASE');
                                        $moper->save($oper);
                                        //Enregistrement dans la table eu_compte_credit
                                        $id_credit = $mcredit->findConuter() + 1;
                                        $source = $code_salarier . $date->toString('yyyyMMddHHmmss');
                                        $credit->setId_credit($id_credit)
                                                ->setId_operation($id_operation)
                                                ->setCode_membre($code_salarier)
                                                ->setCode_produit('CNCSr')
                                                ->setCode_compte($compte_nr)
                                                ->setMontant_place($mont_salaire)
                                                ->setMontant_credit($mont_salaire)
                                                ->setDatedeb($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setDatefin($date_echue->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setSource($source)
                                                ->setDate_octroi($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setCompte_source($code_smcipn)
                                                ->setKrr('N')
                                                ->setRenouveller('N')
                                                ->setBnp(0)
                                                ->setDomicilier(0)
                                                ->setCode_bnp(null)
                                                ->setAffecter(0)
                                                ->setCode_type_credit(null)
                                                ->setPrk(null);
                                        $mcredit->save($credit);
                                        //Mise à jour du compte de subvention nr-smcipnwi
                                        $mcompte->find($code_compte, $compte);
                                        $compte->setCode_compte($code_compte)
                                                ->setSolde($compte->getSolde() - $mont_salaire);
                                        $mcompte->update($compte);
                                        //Mise à jour de eu_facture_smcipn_detail
                                        $mdfact->find($find_dfact[$i]->getId_facture_detail(), $dfact);
                                        $dfact->setId_facture_detail($dfact->getId_facture_detail())
                                                ->setSalaire_alloue($dfact->getSalaire_alloue() + $mont_salaire)
                                                ->setSolde_salaire($dfact->getSolde_salaire() - $mont_salaire);
                                        $mdfact->update($dfact);
                                    }
                                } elseif ($type_fact == 'Investissement') {
                                    //Recherche et création du compte nr-tsci du bénéficiaire de la subvention
                                    $compte_nrtsci = 'nr-tsci-' . $code_client;
                                    $find_tsci = $mcompte->find($compte_nrtsci, $compte);
                                    if ($find_tsci == false) {
                                        $compte->setCode_compte($compte_nrtsci)
                                                ->setCode_membre(null)
                                                ->setMifareCard('')
                                                ->setLib_compte('tsci')
                                                ->setSolde(0)
                                                ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setCode_type_compte('nr')
                                                ->setCode_cat('TSCI')
                                                ->setDesactiver(0)
                                                ->setCardPrintedDate('')
                                                ->setCardPrintedIDDate('')
                                                ->setNumero_carte(null)
                                                ->setCode_membre_morale($code_client);
                                        $mcompte->save($compte);
                                    }
                                    //Enregistrement dans la table eu_operation
                                    $id_operation = $moper->findConuter() + 1;
                                    $oper->setId_operation($id_operation)
                                            ->setDate_op($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setHeure_op($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setMontant_op($mont_fact)
                                            ->setCode_membre($code_client)
                                            ->setCode_produit('Ir')
                                            ->setId_utilisateur($user->id_utilisateur)
                                            ->setLib_op('Allocation d\'investissement à un acteur')
                                            ->setCode_cat('I')
                                            ->setType_op('AIA');
                                    $moper->save($oper);
                                    //Enregistrement dans la table eu_compte_credit
                                    $id_credit = $mcredit->findConuter() + 1;
                                    $source = $code_client . $date->toString('yyyyMMddHHmmss');
                                    $credit->setId_credit($id_credit)
                                            ->setId_operation($id_operation)
                                            ->setCode_membre($code_client)
                                            ->setCode_produit('Ir')
                                            ->setCode_compte($compte_nrtsci)
                                            ->setMontant_place($mont_fact)
                                            ->setMontant_credit(0)
                                            ->setDatedeb($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setDatefin($date_echue->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setSource($source)
                                            ->setDate_octroi($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setCompte_source($code_smcipn)
                                            ->setKrr('N')
                                            ->setRenouveller('N')
                                            ->setBnp(0)
                                            ->setDomicilier(0)
                                            ->setCode_bnp(null)
                                            ->setAffecter(0)
                                            ->setCode_type_credit(null)
                                            ->setPrk(null);
                                    $mcredit->save($credit);
                                    //Recherche et création du compte nn-tsci du bénéficiaire de la subvention
                                    $compte_nntsci = 'NN-TSCI-' . $code_client;
                                    $find_nntsci = $mcompte->find($compte_nntsci, $compte);
                                    if ($find_nntsci == false) {
                                        $compte->setCode_compte($compte_nntsci)
                                                ->setCode_membre(null)
                                                ->setMifareCard('')
                                                ->setLib_compte('TSCI')
                                                ->setSolde(0)
                                                ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setCode_type_compte('NN')
                                                ->setCode_cat('TSCI')
                                                ->setDesactiver(0)
                                                ->setCardPrintedDate('')
                                                ->setCardPrintedIDDate('')
                                                ->setNumero_carte(null)
                                                ->setCode_membre_morale($code_client);
                                        $mcompte->save($compte);
                                    }
                                    //Création et utilisation du nn à la source eu_nn
                                    $id_nn = $nn->findConuter() + 1;
                                    $nn->setId_nn($id_nn)
                                            ->setDate_emission($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setType_emission('Automatique')
                                            ->setMontant_emis($mont_fact)
                                            ->setMontant_remb($mont_fact)
                                            ->setSolde_nn(0)
                                            ->setEmetteur_nn($code_client)
                                            ->setCode_type_nn('I')
                                            ->setId_utilisateur($user->id_utilisateur);
                                    $mnn->insert($nn->toArray());
                                    //Enregistrement dans la table eu_utiliser_nn
                                    $id_oper = $moper->findConuter() + 2;
                                    $id_utiliser_nn = $mutilnn->findConuter() + 1;
                                    $utilnn->setId_utiliser_nn($id_utiliser_nn)
                                            ->setCode_membre_nn($code_client)
                                            ->setCode_membre_nb($code_client)
                                            ->setMont_transfert($mont_fact)
                                            ->setCode_produit('i')
                                            ->setDate_transfert($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setId_utilisateur($user->id_utilisateur)
                                            ->setCode_sms('')
                                            ->setNum_bon('')
                                            ->setId_operation($id_oper)
                                            ->setCode_produit_nn('TSCI');
                                    $mutilnn->save($utilnn);
                                    //Enregistrement dans la table opération
                                    $oper->setId_operation($id_oper)
                                            ->setDate_op($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setHeure_op($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setMontant_op($mont_fact)
                                            ->setCode_membre($code_client)
                                            ->setCode_produit('Ir')
                                            ->setId_utilisateur($user->id_utilisateur)
                                            ->setLib_op('Echange du NN en I')
                                            ->setCode_cat('TPAGCI')
                                            ->setType_op('ENN');
                                    $moper->save($oper);
                                    //Création du compte nb-tpagci
                                    $compte_gci = 'NB-TPAGCI-' . $code_client;
                                    $find_gci = $mcompte->find($compte_gci, $compte);
                                    if ($find_gci == false) {
                                        $compte->setCode_compte($compte_gci)
                                                ->setCode_membre(null)
                                                ->setMifareCard('')
                                                ->setLib_compte('TPAGCI')
                                                ->setSolde(0)
                                                ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setCode_type_compte('NB')
                                                ->setCode_cat('TPAGCI')
                                                ->setDesactiver(0)
                                                ->setCardPrintedDate('')
                                                ->setCardPrintedIDDate('')
                                                ->setNumero_carte(null)
                                                ->setCode_membre_morale($code_client);
                                        $mcompte->save($compte);
                                    }
                                    //Enregistrement du détail du compte nb-tpagci dans la table eu_compte_credit
                                    $id_cred = $mcredit->findConuter() + 2;
                                    $source = $code_client . $date->toString('yyyyMMddHHmmss');
                                    $credit->setId_credit($id_cred)
                                            ->setId_operation($id_oper)
                                            ->setCode_membre($code_client)
                                            ->setCode_produit('Ir')
                                            ->setCode_compte($compte_gci)
                                            ->setMontant_place($mont_fact)
                                            ->setMontant_credit(0)
                                            ->setDatedeb($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setDatefin($date_echue->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setSource($source)
                                            ->setDate_octroi($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setCompte_source($compte_nntsci)
                                            ->setKrr('N')
                                            ->setRenouveller('N')
                                            ->setBnp(0)
                                            ->setDomicilier(0)
                                            ->setCode_bnp(null)
                                            ->setAffecter(0)
                                            ->setCode_type_credit(null)
                                            ->setPrk(null);
                                    $mcredit->save($credit);
                                    //Création du Ir à la source cnp
                                    $id_cnp = $mcnp->findConuter() + 1;
                                    $cnp->setId_cnp($id_cnp)
                                            ->setId_credit($id_cred)
                                            ->setDate_cnp($date->toString('yyyy-MM-dd HH:mm:ss'))
                                            ->setMont_debit($mont_fact)
                                            ->setMont_credit($mont_fact)
                                            ->setSolde_cnp(0)
                                            ->setType_cnp('Ir')
                                            ->setSource_credit($source)
                                            ->setCode_capa(null)
                                            ->setCode_domicilier(null)
                                            ->setOrigine_cnp('ENN-Ir')
                                            ->setTransfert_gcp(0);
                                    $mcnp->save($cnp);
                                    //Mise à jour du compte de subvention nr-smcipnwi
                                    $mcompte->find($code_compte, $compte);
                                    $compte->setCode_compte($code_compte)
                                            ->setSolde($compte->getSolde() - $mont_fact);
                                    $mcompte->update($compte);
                                    for ($i = 0; $i < count($find_dfact); $i++) {
                                        $code_fournis = $find_dfact[$i]->getCode_membre_fournisseur();
                                        $mont_invest = $find_dfact[$i]->getMont_investis();
                                        //Mise à jour de eu_facture_smcipn_detail
                                        $mdfact->find($find_dfact[$i]->getId_facture_detail(), $dfact);
                                        $dfact->setId_facture_detail($dfact->getId_facture_detail())
                                                ->setInvestis_alloue($dfact->getInvestis_alloue() + $mont_invest)
                                                ->setSolde_investis($dfact->getSolde_investis() - $mont_invest);
                                        $mdfact->update($dfact);
                                        //#####Traitement de la consommation####
                                        //vérification de l'existence du tegc du membre distributeur
                                        $mmembre->find($code_fournis, $membre);
                                        $id_filiere = $membre->getId_filiere();
                                        $code_tegc = 'TEGCP' . $id_filiere . $code_fournis;
                                        $ret_te = $mtegc->find($code_tegc, $tegc);
                                        if ($ret_te) {
                                            $tegc->setMontant($tegc->getMontant() + $mont_invest);
                                            $mtegc->update($tegc);
                                        } else {
                                            $db->rollback();
                                            $this->view->data = 'no_tegc';
                                            return;
                                        }
                                        //Enregistrement dans la table eu_compte
                                        $code_vendeur = 'nb-tpagcp-' . $code_fournis;
                                        $ret = $mcompte->find($code_vendeur, $compte);
                                        if ($ret) {
                                            $compte->setSolde($compte->getSolde() + $mont_invest);
                                            $mcompte->update($compte);
                                        } else {
                                            $compte->setCode_compte($code_vendeur)
                                                    ->setCode_membre(null)
                                                    ->setMifareCard('')
                                                    ->setLib_compte('GCP')
                                                    ->setSolde($mont_invest)
                                                    ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                    ->setCode_type_compte('NB')
                                                    ->setCode_cat('TPAGCP')
                                                    ->setDesactiver(0)
                                                    ->setCardPrintedDate('')
                                                    ->setCardPrintedIDDate('')
                                                    ->setNumero_carte(null)
                                                    ->setCode_membre_morale($code_fournis);
                                            $mcompte->save($compte);
                                        }
                                        //Enregistrement du détail de la consommation dans eu_gcp
                                        $id_gcp = $mgcp->findConuter() + 1;
                                        $gcp->setId_gcp($id_gcp)
                                                ->setCode_tegc($code_tegc)
                                                ->setCode_cat('TPAGCI')
                                                ->setCode_membre($code_client)
                                                ->setId_credit($id_cred)
                                                ->setSource($source)
                                                ->setDate_conso($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setMont_gcp($mont_invest)
                                                ->setMont_preleve(0)
                                                ->setReste($mont_invest);
                                        $mgcp->save($gcp);
                                        //Enregistrement de l'opération
                                        $id_operconso = $moper->findConuter() + 3;
                                        $oper->setId_operation($id_operconso)
                                                ->setDate_op($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setHeure_op($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setId_utilisateur($user->id_utilisateur)
                                                ->setCode_membre($code_client)
                                                ->setMontant_op($mont_invest)
                                                ->setCode_produit('Ir')
                                                ->setLib_op('Consommation')
                                                ->setType_op('Conso')
                                                ->setCode_cat('TPAGCI');
                                        $moper->save($oper);
                                        //Enregistrement dans la table eu_credit_consommer
                                        $id_conso = $mcconso->findConuter() + 1;
                                        $cconso->setId_consommation($id_conso)
                                                ->setId_operation($id_operconso)
                                                ->setId_credit($id_cred)
                                                ->setCode_membre($code_client)
                                                ->setCode_membre_dist($code_fournis)
                                                ->setCode_compte($compte_gci)
                                                ->setCode_produit('Ir')
                                                ->setMont_consommation($mont_invest)
                                                ->setDate_consommation($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setHeure_consommation($date->toString('yyyy-MM-dd HH:mm:ss'));
                                        $mcconso->save($cconso);
                                        // Création du cncs correspondant au smc
                                        $id_smc = $msmc->findConuter() + 1;
                                        $smc->setId_smc($id_smc)
                                                ->setType_smc('CNCSr')
                                                ->setCode_capa(null)
                                                ->setId_credit($id_cred)
                                                ->setSource_credit($source)
                                                ->setMontant($mont_invest)
                                                ->setEntree(0)
                                                ->setSortie(0)
                                                ->setSolde(0)
                                                ->setMontant_solde($mont_invest)
                                                ->setDate_smc($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setOrigine_smc(0)
                                                ->setCode_smcipn(null)
                                                ->setCode_smcipnp(null)
                                                ->setCode_domicilier(null);
                                        $msmc->save($smc);
                                    }
                                }
                            }
                        }
                    } else {
                        $db->rollback();
                        $this->view->data = 'no_subvent';
                        return;
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ': ' . $exc->getTraceAsString();
                //$this->view->data = $message;
                $this->view->data = 'bad';
                return;
            }
        }
    }

}

?>
