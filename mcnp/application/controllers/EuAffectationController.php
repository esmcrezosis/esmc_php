<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AffectationController
 *
 * @author user
 */
class EuAffectationController extends Zend_Controller_Action {

    //put your code here
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'sal_affect' && $group != 'compta') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-affectation/index \">Situation salariale</a></li>
            <li><a href=\" /eu-affectation/affectersalaire \">Affectation du salaire</a></li>
            <li><a href=\" /eu-affectation/employe \">Déclaration Employés</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function indexAction() {
        // action body
    }

    public function dataAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_employe');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuEmploye();
        $code_membre = $this->_request->getParam('membre');
        $select = $tabela->select();
        if ($code_membre != '') {
            $select->where('code_membre_employeur like ?', $code_membre);
        } else {
            $select->where('id_utilisateur = ?', $user->id_utilisateur);
        }
        $employes = $tabela->fetchAll($select);
        $count = count($employes);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $employes = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($employes as $row) {
            if ($row->cnss == 1) {
                $cnss = 'Oui';
            } else if ($row->cnss == 0) {
                $cnss = 'Non';
            }
            $responce['rows'][$i]['id'] = $row->id_employe;
            $responce['rows'][$i]['cell'] = array(
                $row->id_employe,
                $row->code_membre_employe,
                $cnss,
                $row->mont_salaire,
                $row->date_declaration
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function affectationsAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'date_affectation');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSalaireAffecter();
        $code_membre = $this->_request->getParam('membre');
        $date_deb = $this->_request->getParam('datedeb');
        $date_fin = $this->_request->getParam('datefin');
        $select = $tabela->select();
        if ($code_membre != '') {
            $select->where('code_membre_emp like ?', $code_membre);
        }
        if ($date_deb != '' && $date_fin != '') {
            $deb = Util_Utils::convertDate($date_deb);
            $fin = Util_Utils::convertDate($date_fin);
            $select->where("date_affectation between '$deb' and '$fin'");
        } else {
            if ($date_deb != '') {
                $deb = Util_Utils::convertDate($date_deb);
                $select->where('date_affectation = ?', $deb);
            }
            if ($date_fin != '') {
                $fin = Util_Utils::convertDate($date_fin);
                $select->where('date_affectation = ?', $fin);
            }
        }
        $select->where('id_utilisateur = ?', $user->id_utilisateur);
        $employes = $tabela->fetchAll($select);
        $count = count($employes);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $employes = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($employes as $row) {
            $responce['rows'][$i]['id'] = $row->id_affectation;
            $responce['rows'][$i]['cell'] = array(
                $row->id_affectation,
                $row->date_affectation,
                $row->code_membre,
                $row->mont_affecter,
                $row->date_deb,
                $row->date_fin
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function csalaireAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", "id_credit");
        $sord = $this->_request->getParam("sord", "asc");
        $code_membre = $this->_request->getParam("membre");
        if ($code_membre != '') {
            $tabela = new Application_Model_DbTable_EuCompteCredit();
            $select = $tabela->select();
            $select->where('code_membre like ?', $code_membre)
                    ->where('code_produit like ?', 'cncs%');
            $credits = $tabela->fetchAll($select);
            $count = count($credits);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }

            if ($page > $total_pages)
                $page = $total_pages;

            $credits = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;

            foreach ($credits as $row) {
                $responce['rows'][$i]['id'] = $row->id_credit;
                $responce['rows'][$i]['cell'] = array(
                    $row->id_credit,
                    $row->code_produit,
                    $row->code_membre,
                    $row->montant_place,
                    $row->montant_credit,
                    $row->datefin
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function salaireAction() {
        $code_membre = $_GET["membre"];
        if ($code_membre != '') {
            $db = Zend_Db_Table::getDefaultAdapter();
            $select = $db->select()
                    ->from(array('m' => 'eu_membre'), array('nom_membre', 'prenom_membre', 'raison_sociale'))
                    ->join(array('c' => 'eu_compte'), 'm.code_membre = c.code_membre', array('solde'))
                    ->where('c.code_cat like ?', 'tcncsei')
                    ->where('c.code_membre like ?', $code_membre);
            $result = $db->fetchAll($select);
            if (count($result) > 0) {
                $row = $result[0];
                $data = array();
                $data[0] = $row["raison_sociale"];
                $data[1] = $row["nom_membre"];
                $data[2] = $row["prenom_membre"];
                $data[3] = $row["solde"];
            }
            $this->view->data = $data;
        }
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $z = new Application_Model_EuCompteGeneral();
        $mz = new Application_Model_EuCompteGeneralMapper();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit") {
            $z->setNum_compte($this->_request->getPost("num_compte"));
            $z->setService($this->_request->getPost("service"));
            $z->setIntitule($this->_request->getPost("intitule"));
            $z->setCredit($this->_request->getPost("credit"));
            $z->setDebit($this->_request->getPost("debit"));
            $z->setSolde($this->_request->getPost("solde"));
            $z->setCode_type($this->_request->getPost("code_type"));
            $mz->update($z);
        } elseif ($oper == "add") {
            $z->setNum_compte($this->_request->getPost("num_compte"));
            $z->setService($this->_request->getPost("service"));
            $z->setIntitule($this->_request->getPost("intitule"));
            $z->setCredit($this->_request->getPost("credit"));
            $z->setDebit($this->_request->getPost("debit"));
            $z->setSolde($this->_request->getPost("solde"));
            $z->setCode_type($this->_request->getPost("code_type"));
            $mz->save($z);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("num_compte");
            $mz->delete($id);
        }
    }

    public function employeAction() {
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
                    $this->view->message = 'Cet membre N°: ' . $code_employe . ' a été déjà enregistré chez l\'employeur N°: ' . $row->code_membre_employeur . ' !!!';
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
        $select->where('type_membre=?', 'p');
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
        $select->where('type_membre=?', 'm');
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
            $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
        } else {
            $data = '';
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

    public function salairedispoAction() {
        $cat = $_GET["cat_compte"];
        $membre = $_GET["membre"];
        $compte_source = 'nr-' . $cat . '-' . $membre;
        $sal_percu = 0;
        //Récupération du montant total du salaire perçu sur le compte tpn
        $mcompte = new Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $rest = $mcompte->find($compte_source, $compte);
        if ($rest == false) {
            $sal_percu = 0;
        } else {
            $sal_percu = $compte->getSolde();
        }
        $this->view->data = $sal_percu;
    }

    public function affectersalaireAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $nb_employe = $request->nb_employe;
            $code_membre = $request->code_memb;
            $code_cat = $request->cat_compte;

            if ($nb_employe == 0 || $nb_employe == '') {
                $this->view->message = 'Préciser le nombre de salariés';
            } else {
                $this->view->data = $nb_employe;
                $compte_source = 'nr-' . $code_cat . '-' . $code_membre;
                $sal_percu = 0;
                //Récupération du montant total du salaire perçu sur le compte tpn
                $mcompte = new Application_Model_EuCompteMapper();
                $compte = new Application_Model_EuCompte();
                $rest = $mcompte->find($compte_source, $compte);
                if ($rest == false) {
                    $sal_percu = 0;
                } else {
                    $sal_percu = $compte->getSolde();
                }
                $this->view->sal_percu = $sal_percu;
            }
        }
    }

    public function affecterAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $this->_helper->layout->disableLayout();
        if ($this->getRequest()->isPost()) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $selection = $_POST['cpteur'];
                $cat = $_POST["cat_compte"];
                $membre = $_POST["code_memb"];
                //Récupération du montant total des salaires affectés
                $cumul_sal = 0;
                for ($j = 1; $j <= $selection; $j++) {
                    $cumul_sal += $_POST["salaire$j"];
                }
                $credit = new Application_Model_EuCompteCredit();
                $compte = new Application_Model_EuCompte();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $cc_mapper = new Application_Model_EuCompteCreditMapper();
                $smc_mapper = new Application_Model_EuSmcMapper();
                $sal_affecter = new Application_Model_EuSalaireAffecter();
                $tsal = new Application_Model_DbTable_EuSalaireAffecter();
                $t_employe = new Application_Model_DbTable_EuEmploye();
                $emp_select = $t_employe->select();
                $emp_select->where('code_membre_employeur like ?', $membre);
                $emp_result = $t_employe->fetchAll($emp_select);
                if (count($emp_result) >= 1) {
                    $compte_source = 'nr-' . $cat . '-' . $membre;
                    $res = $cm_mapper->find($compte_source, $compte);
                    if ($res && $compte->getSolde() > 0 && $cumul_sal > 0 && $cumul_sal <= $compte->getSolde()) {
                        $date_all = new Zend_Date(Zend_Date::ISO_8601);
                        $date_alloc = clone $date_all;
                        for ($i = 1; $i <= $selection; $i++) {
                            $sel_emp = $t_employe->select();
                            $sel_emp->where('code_membre_employe like ?', $_POST["num_membre$i"])
                                    ->where('code_membre_employeur like ?', $membre);
                            $emp_ret = $t_employe->fetchAll($sel_emp);
                            if (count($emp_ret) > 0 && count($emp_ret) < 2) {
                                $employe = $emp_ret->current();
                                $salaire = $_POST["salaire$i"];
                                if ($salaire <= $employe->mont_salaire) {
                                    $num_membre = $_POST["num_membre$i"];
                                    $date_deb = $_POST["date_deb$i"];
                                    $date_fin = $_POST["date_fin$i"];
                                    if ($date_deb != '' and $date_fin != '') {
                                        $dated = new Zend_Date(Util_Utils::convertDated($date_deb, "-"), Zend_Date::ISO_8601);
                                        $datef = new Zend_Date(Util_Utils::convertDated($date_fin, "-"), Zend_Date::ISO_8601);
                                        $sal_select = $db->select()
                                                ->from(array('eu_salaire_affecter'), array('max(date_fin) as fin'))
                                                ->where('code_membre like ?', $num_membre)
                                                ->where('code_membre_emp like ?', $membre);
                                        $res = $db->fetchAll($sal_select);
                                        if (count($res) > 0) {
                                            if ($res[0]['fin'] != '' && $res[0]['fin'] != null) {
                                                $fin = new Zend_Date($res[0]['fin'], Zend_Date::ISO_8601);
                                                if ($dated < $fin) {
                                                    $db->rollback();
                                                    $message = 'Vous ne pouvez pas affecter du salaire plusieurs fois dans la même période';
                                                    $this->view->data = $message;
                                                    return;
                                                }
                                            }
                                        }
                                    }

                                    $credis = $cc_mapper->findSalByCompte($compte_source);
                                    if ($credis != null && count($credis) > 0) {
                                        //Insertion du cumul des salaires dans la table compte de l'employé
                                        $cat_compte = 'tcncs';
                                        $num_comptes = 'nr-' . $cat_compte . '-' . $num_membre;
                                        $result = $cm_mapper->find($num_comptes, $compte);
                                        if ($result == false) {
                                            $compte->setCode_membre($num_membre)
                                                    ->setCode_cat($cat_compte)
                                                    ->setCode_type_compte('nr')
                                                    ->setSolde($salaire)
                                                    ->setDate_alloc($date_alloc->toString('yyyy-mm-dd'))
                                                    ->setCode_compte($num_comptes)
                                                    ->setLib_compte($cat_compte)
                                                    ->setDesactiver(0);
                                            $cm_mapper->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $salaire);
                                            $cm_mapper->update($compte);
                                        }

                                        //Ajout dans la table opération
                                        $mapper = new Application_Model_EuOperationMapper();
                                        $alloc = new Application_Model_EuOperation();
                                        $compteur = $mapper->findConuter() + 1;
                                        $alloc->setId_operation($compteur)
                                                ->setDate_op($date_alloc->toString('yyyy-mm-dd'))
                                                ->setHeure_op($date_alloc->toString('hh:mm'))
                                                ->setMontant_op($salaire)
                                                ->setCode_membre($num_membre)
                                                ->setCode_produit('CNCSnr')
                                                ->setId_utilisateur($user->id_utilisateur)
                                                ->setLib_op('Affectation de salaire à l\'employé')
                                                ->setCode_cat($cat_compte)
                                                ->setType_op('ase');
                                        $mapper->save($alloc);

                                        //Création du compte credit correspondant à l'affectation
                                        $maxcc = $cc_mapper->findConuter() + 1;
                                        $credit->setId_credit($maxcc)
                                                ->setCode_membre($num_membre)
                                                ->setCode_produit('CNCSnr')
                                                ->setMontant_place($salaire)
                                                ->setDatedeb($dated->toString('yyyy-mm-dd'))
                                                ->setDatefin($datef->toString('yyyy-mm-dd'))
                                                ->setDate_octroi($date_alloc->toString('yyyy-mm-dd'))
                                                ->setSource($num_membre . $date_alloc->toString('yyyyMMddHHmmss'))
                                                ->setCode_compte($num_comptes)
                                                ->setMontant_credit($salaire)
                                                ->setRenouveller('n')
                                                ->setId_operation($compteur)
                                                ->setCompte_source($compte_source)
                                                ->setKrr('n')
                                                ->setBnp(0)
                                                ->setCode_bnp(null)
                                                ->setDomicilier(0);
                                        $cc_mapper->save($credit);
                                        $j = 0;
                                        while ($salaire > 0 && $j < count($credis)) {
                                            $value = $credis[$j];
                                            if ($value->getMontant_credit() < $salaire) {
                                                $mont_credit = $value->getMontant_credit();
                                                $salaire = $salaire - $value->getMontant_credit();
                                            } else {
                                                $mont_credit = $salaire;
                                                $salaire = 0;
                                            }
                                            $smc = $smc_mapper->findBySource($value->getSource(), $value->getId_credit());
                                            if ($smc != null) {
                                                $sal_affecter->setDate_affectation($date_alloc->toString('yyyy-mm-dd'))
                                                        ->setId_credit($maxcc)
                                                        ->setId_credit_affecter($value->getId_credit())
                                                        ->setId_smc($smc->getId_smc())
                                                        ->setMont_affecter($mont_credit)
                                                        ->setCode_membre($num_membre)
                                                        ->setId_operation($compteur)
                                                        ->setId_utilisateur($user->id_utilisateur)
                                                        ->setDate_deb($dated->toString('yyyy-mm-dd'))
                                                        ->setDate_fin($datef->toString('yyyy-mm-dd'))
                                                        ->setHeure_affectation($date_alloc->toString('hh:mm:ss'))
                                                        ->setCode_membre_emp($membre);
                                                if ($cat == 'tcncsei') {
                                                    $sal_affecter->setType_cncs('CNCSnr');
                                                } else {
                                                    $sal_affecter->setType_cncs('CNCSr');
                                                }
                                                $tsal->insert($sal_affecter->toArray());

                                                $value->setMontant_credit($value->getMontant_credit() - $mont_credit);
                                                $cc_mapper->update($value);

                                                $smc->setSortie($smc->getSortie() + $mont_credit);
                                                $smc->setSolde($smc->getSolde() + $mont_credit);
                                                $smc->setMontant_solde($smc->getMontant_solde() - $mont_credit);
                                                $smc_mapper->update($smc);
                                            }
                                            $j++;
                                        }
                                    } else {
                                        $db->rollback();
                                        $message = 'Pas de crédits salaires matures (Les crédits cncs doivent faire 30 jours avant affectation) !!!';
                                        $this->view->data = $message;
                                        return;
                                    }
                                } else {
                                    $db->rollback();
                                    $this->view->data = 'Attention : Le montant alloué est supérieur au montant déclaré pour l\'employé ' . $_POST["num_membre$i"] . '!!!';
                                    return;
                                }
                            } else {
                                $db->rollback();
                                $this->view->data = 'Cet employé ' . $_POST["num_membre$i"] . ' n\'est pas déclaré!!!';
                                return;
                            }
                        }
                        //Mise à jour du compte tpn de l'employeur
                        $cm_mapper->find($compte_source, $compte);
                        $compte->setSolde($compte->getSolde() - $cumul_sal);
                        $cm_mapper->update($compte);
                        $db->commit();
                        $this->view->data = 'good';
                        return;
                    } else {
                        $db->rollback();
                        $message = ' Le solde de ce compte est insuffisant pour effectuer cette affectation de salaire!!!';
                        $this->view->data = $message;
                        return;
                    }
                } else {
                    $db->rollback();
                    $message = 'Veuillez déclarer vos employés avec leur salaire avant toute affectation!!!';
                    $this->view->data = $message;
                    return;
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' -> ' . $exc->getTraceAsString();
                $this->view->data = $message;
                return;
            }
        }
    }

}

?>
