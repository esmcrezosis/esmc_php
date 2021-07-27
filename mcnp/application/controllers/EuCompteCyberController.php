<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuCompteCyberController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'gacex' || $group == 'acnev') {
            $menu = "<li><a href=\" /eu-compte-cyber/newacteur\">Création acteur</a></li>" .
                    "<li><a href=\" /eu-compte-cyber/new \">Création compte user</a></li>".
                    "<li><a href=\" /eu-compte-cyber/listeacteurs\">Liste des acteurs</a></li>".
                    "<li><a href=\" /eu-compte-cyber/index\">Liste des comptes</a></li>" .
                    "<li><a href=\" /eu-compte-cyber/enrolement\">Vue des enrôlements effectués</a></li>" .
                    "<li><a href=\" /eu-compte-cyber/listecarte\">Vue des demandes de cartes effectuées</a></li>" .
                    "<li><a href=\" /eu-compte-cyber/listebnp\">Vue des bnp effectués</a></li>";
        } elseif ($group == 'gacreg' || $group == 'gacco' || $group == 'gacpro' || $group == 'gacreg_pbf' || $group == 'gacco_pbf' || $group == 'gacpro_pbf') {
            $menu = "<li><a href=\" /eu-compte-cyber/new \">Création compte user</a></li>" .
                    "<li><a href=\" /eu-compte-cyber/index\">Liste des comptes</a></li>";
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
            if ($group != 'gacsu' && $group != 'gacex' && $group == 'acnev' && $group != 'gacreg' && $group != 'gacco' && $group != 'gacpro' && $group != 'gacreg_pbf' && $group != 'gacco_pbf' && $group != 'gacpro_pbf') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function membresAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuActeurCreneau();
        //$select= $mb->select();
        // $select->where('type_membre like ?','m');
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function recupnomAction() {
        $request = $this->getRequest();
        $num_membre = $request->num_membre;
        $membre = new Application_Model_DbTable_EuMembreMorale();
        $select = $membre->select();
        $select->setIntegrityCheck(false);
        $select->from(array('m' => 'eu_membre_morale'), array('code_membre_morale', 'raison_sociale'));
        $select->where('m.code_membre_morale = ?', $num_membre);
        $select->join(array('r' => 'eu_representation'), 'r.code_membre_morale = m.code_membre_morale', array('titre'));
        $select->join(array('n' => 'eu_membre'), 'n.code_membre = r.code_membre', array('nom_membre', 'prenom_membre'));
        $select->where('r.titre = ?', 'representant');
        $result = $membre->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            $data[0] = ucfirst($row->raison_sociale);
            $data[1] = strtoupper($row->nom_membre) . " " . ucfirst($row->prenom_membre);
        } else {
            $select = $membre->select();
            $select->setIntegrityCheck(false);
            $select->from('eu_membre_morale', array('code_membre_morale', 'raison_sociale'));
            $select->where('code_membre_morale = ?', $num_membre);
            $result = $membre->fetchAll($select);
            $row = $result->current();
            $data[0] = ucfirst($row->raison_sociale);
        }
        $this->view->data = $data;
    }

    public function groupeAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_group = $user->code_groupe;
        $g = array();
        $tab = new Application_Model_DbTable_EuUserGroup();
        $sel = $tab->select();
        $sel->order('libelle_groupe asc');
        $group = $tab->fetchAll($sel);
        $i = 0;
        foreach ($group as $value) {
            if ($code_group == 'gacreg') {
                $greg = array('cm', 'mise_chaine', 'bnp', 'banque');
                if (in_array($value->code_groupe, $greg)) {
                    $g[$i][0] = $value->code_groupe;
                    $g[$i][1] = ucfirst($value->libelle_groupe);
                    $i++;
                }
            } elseif ($code_group == 'gacpro') {
                $greg = array('alerte', 'assurance', 'domi_nrpre');
                if (in_array($value->code_groupe, $greg)) {
                    $g[$i][0] = $value->code_groupe;
                    $g[$i][1] = ucfirst($value->libelle_groupe);
                    $i++;
                }
            } elseif ($code_group == 'gacex' || $code_group == 'acnev') {
                $greg = array('banque', 'dist', 'gcsc', 'ti', 'tpn', 'smcipnp', 'smcipnwi');
                if (in_array($value->code_groupe, $greg)) {
                    $g[$i][0] = $value->code_groupe;
                    $g[$i][1] = ucfirst($value->libelle_groupe);
                    $i++;
                }
            } else {
                if (($value->code_groupe == 'apa') ||
                        ($value->code_groupe == 'mf_bank') ||
                        ($value->code_groupe == 'cmit') ||
                        ($value->code_groupe == 'cscoe') ||
                        ($value->code_groupe == 'cacb') ||
                        ($value->code_groupe == 'caps') ||
                        ($value->code_groupe == 'capu') ||
                        ($value->code_groupe == 'caipc')
                ) {
                    $g[$i][0] = $value->code_groupe;
                    $g[$i][1] = ucfirst($value->libelle_groupe);
                    $i++;
                }
            }
        }
        $this->view->data = $g;
    }

    public function agenceAction() {
        //$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        //$user = $auth->getIdentity();
        //$code_acteur = $user->code_acteur;
        $ag = array();
        $tab = new Application_Model_DbTable_EuAgence();
        $sel = $tab->select();
        //$sel->where('code_gac like ?', $code_acteur);
        $sel->order('libelle_agence asc');
        $agences = $tab->fetchAll($sel);
        $i = 0;
        foreach ($agences as $value) {
            $ag[$i][0] = $value->code_agence;
            $ag[$i][1] = ucfirst($value->libelle_agence);
            $i++;
        }
        $this->view->data = $ag;
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

    public function membreAction() {
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

    public function recupacteurAction() {
        $code_membre = $_GET['code_membre'];
        $acteur = new Application_Model_DbTable_EuActeurCreneau();
        $select = $acteur->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_membre', 'eu_membre.code_membre = eu_acteurs_creneaux.code_membre')
                //->join('eu_membre', 'eu_membre.code_membre = eu_acteurs_creneaux.code_membre_GESTIONNAIRE')
                ->where('eu_acteurs_creneaux.code_membre like ?', $code_membre);

        $select1 = $acteur->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false);
        $select1->join('eu_membre', 'eu_membre.code_membre = eu_acteurs_creneaux.code_membre_GESTIONNAIRE')
                ->where('eu_acteurs_creneaux.code_membre like ?', $code_membre);

        $data = array();
        $results = $acteur->fetchAll($select);
        $results1 = $acteur->fetchAll($select1);

        if (count($results) == 1) {
            $row = $results->current();
            $row1 = $results1->current();
            $data[0] = ucfirst($row->nom_acteur);
            $data[1] = ucfirst($row->raison_sociale);
            $data[2] = $row->code_membre_gestionnaire;
            $data[3] = ucfirst($row1->nom_membre);
            $data[4] = ucfirst($row1->prenom_membre);
            $data[5] = ucfirst($row->code_acteur);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function indexAction() {
        //$this->_helper->layout->disableLayout(); 
    }

    public function enrolementAction() {
        
    }

    public function listecarteAction() {
        
    }

    public function listebnpAction() {
        
    }

    public function databnpAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_operation');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select();
        $select->where('type_op not in(?)', array('apa', 'Enr', 'Conso', 'Echange', 'Escompte'))
                ->where('id_utilisateur like ?', $user->id_utilisateur)
                ->order('date_op', 'asc');
        $achat = $tabela->fetchAll($select);
        $count = count($achat);

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
            $date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->id_operation,
                $date_op->toString('dd/mm/yyyy'),
                $row->code_membre,
                $row->lib_op,
                $row->code_cat,
                $row->code_produit,
                $row->montant_op,
                $row->type_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function datacartesAction() {
        //$user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_demande');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_agence = $this->_request->getParam("agence");
        $date = $this->_request->getParam("date");

        $tabela = new Application_Model_DbTable_EuCartes();
        $select = $tabela->select();
        $select->setIntegrityCheck(false);
        $select->from('eu_cartes', array('*', "to_char((date_demande),'dd/mm/yyyy') date_demande"));
        $select->join('eu_membre', 'eu_membre.code_membre = eu_cartes.code_membre');
        if ($date != '' && $code_agence != '') {
            $select->where('eu_membre.code_agence like ?', $code_agence)
                    ->where("to_char((eu_cartes.date_demande),'dd/mm/yyyy') like ?", $date);
            $cartes = $tabela->fetchAll($select);
        } elseif ($code_agence != '') {
            $select->where('eu_membre.code_agence like ?', $code_agence);
            $cartes = $tabela->fetchAll($select);
        } elseif ($date != '') {
            $select->where("to_char((eu_cartes.date_demande),'dd/mm/yyyy') like ?", $date);
            $cartes = $tabela->fetchAll($select);
        }

        $count = count($cartes);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $cartes = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cartes as $row) {
            $responce['rows'][$i]['id'] = $row->id_demande;
            $responce['rows'][$i]['cell'] = array(
                $row->id_demande,
                $row->code_agence,
                $row->date_demande,
                $row->code_membre,
                $row->raison_sociale,
                $row->nom_membre,
                $row->prenom_membre,
                $row->code_cat,
                $row->mont_carte
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function dataenroAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_agence = $this->_request->getParam("agence");
        $date = $this->_request->getParam("date");
        $tabela = new Application_Model_DbTable_EuMembre();
        if ($date != '' && $code_agence != '') {
            $select = $tabela->select();
            $select->where('eu_membre.code_agence like ?', $code_agence)
                    ->where("to_char((eu_membre.date_identification),'dd/mm/yyyy') like ?", $date);
        } elseif ($code_agence != '') {
            $select = $tabela->select();
            $select->where('eu_membre.code_agence like ?', $code_agence);
        } elseif ($date != '') {
            $select = $tabela->select();
            $select->where("to_char((eu_membre.date_identification),'dd/mm/yyyy') like ?", $date);
        } elseif ($date == '' && $code_agence == '') {
            $select = $tabela->select()
                    ->where("to_char((eu_membre.date_identification),'dd/mm/yyyy') like ?", 0)
                    ->where('eu_membre.code_agence like ?', 0);
        }
        $membre = $tabela->fetchAll($select);
        $count = count($membre);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;

        $membres = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($membres as $row) {
            $responce['rows'][$i]['id'] = $row->code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->code_agence,
                $row->code_membre,
                $row->raison_sociale,
                $row->nom_membre,
                $row->prenom_membre,
                $row->profession_membre
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function agencesAction() {
        $tagences = new Application_Model_EuAgenceMapper();
        $agences = $tagences->fetchAll();
        if (count($agences) >= 1) {
            foreach ($agences as $value) {
                $data[0][] = $value->getCode_agence();
                $data[1][] = $value->getLibelle_agence();
            }
            $this->view->data = $data;
        } else {
            $this->view->data = false;
        }
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_acteur = $user->code_acteur;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_utilisateur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuUtilisateur();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->where('code_acteur like ?', $code_acteur);
        $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select->order('id_utilisateur desc');
        $cat = $tabela->fetchAll($select);
        $count = count($cat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->id_utilisateur;
            $responce['rows'][$i]['cell'] = array(
            strtoupper($row->nom_utilisateur) . ' ' . ucfirst($row->PREnom_utilisateur),
                $row->login,
                ucfirst($row->libelle_groupe),
                $row->connecte,
                $row->code_membre,
                $row->code_agence
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listeacteursAction() {
        
    }

    public function datalisteactAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_acteur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuActeur();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_activite', 'eu_activite.code_activite = eu_acteur.code_activite')
                ->where('eu_acteur.id_utilisateur like ?', $user->id_utilisateur);
        $achat = $tabela->fetchAll($select);
        $count = count($achat);

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
            $responce['rows'][$i]['id'] = $row->id_acteur;
            $responce['rows'][$i]['cell'] = array(
                $row->id_acteur,
                $row->code_membre,
                $row->code_acteur,
                $row->nom_activite,
                $type_acteur
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newacteurAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $code_acteur = $request->code_acteur;
            $code_membre = $request->code_membre;
            $code_activite = $request->code_activite;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $tab_acteur = new Application_Model_DbTable_EuActeur();
                $select = $tab_acteur->select();
                $select->where('code_membre like ?', $code_membre)
                        ->where('code_activite like ?', $code_activite);
                $acteurs = $tab_acteur->fetchAll($select);
                if (count($acteurs) > 0) {
                    $db->rollback();
                    $this->view->message = "Ce membre est déja ajouté dans ce domaine d'activité!!!";
                    $this->view->code_membre = $code_membre;
                    $this->view->nom_act = $this->_request->getPost("nom_act");
                    $this->view->code_acteur = $code_acteur;
                    $this->view->act_raison = $this->_request->getPost("act_raison");
                    $this->view->gest_act = $this->_request->getPost("gest_act");
                    $this->view->nom_membre_act = $this->_request->getPost("nom_membre_act");
                    $this->view->prenom_membre_act = $this->_request->getPost("prenom_membre_act");
                    $this->view->code_activite = $this->_request->getPost("code_activite");
                    return;
                } else {
                    $date_creation = Zend_Date::now();
                    $acteur = new Application_Model_EuActeur();
                    $count = $acteur->findConuter() + 1;
                    $acteur->setId_acteur($count)
                            ->setCode_activite($code_activite)
                            ->setCode_membre($code_membre)
                            ->setType_acteur("m")
                            ->setCode_acteur($code_acteur)
                            ->setDate_creation($date_creation->toString('yyyy-mm-dd'))
                            ->setId_utilisateur($user->id_utilisateur);
                    $tab_acteur->insert($acteur->toArray());
                    $db->commit();
                    return $this->_helper->redirector('listeacteurs', 'eu-compte-cyber', null, array('controller' => 'eu-compte-cyber', 'action' => 'listeacteurs'));
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . " :" . $exc->getTraceAsString();
                return;
            }
        }
    }

    public function newAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_acteur = $user->code_acteur;
        if ($this->getRequest()->isPost()) {
            $pwd = $this->_request->getPost("pwd");
            $pwd1 = $this->_request->getPost("pwd1");
            $code_groupe = $this->_request->getPost("groupe");
            $code_agence = $this->_request->getPost("agence");
            $code_membre = $this->_request->getPost("code_membre");
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Mise à jour de la table eu_utilisateur
                $userin = new Application_Model_EuUtilisateur();
                $mapper = new Application_Model_EuUtilisateurMapper();
                $find_user = $mapper->findLogin($this->_request->getPost("login"));
                if ($find_user != false) {
                    $message = 'Ce login existe déjà.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    $this->view->code_membre = $this->_request->getPost("code_membre");
                    $this->view->raison_sociale = $this->_request->getPost("raison_sociale");
                    $this->view->nom_prenom = $this->_request->getPost("nom_prenom");
                    return;
                } elseif ($pwd != $pwd1) {
                    $message = 'Erreur de confirmation du mot de passe.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    $this->view->code_membre = $this->_request->getPost("code_membre");
                    $this->view->raison_sociale = $this->_request->getPost("raison_sociale");
                    $this->view->nom_prenom = $this->_request->getPost("nom_prenom");
                    return;
                } elseif ($code_groupe == 'cm' && $code_agence == '') {
                    $db->rollback();
                    $message = 'l\'agence est obligatoire pour ce type de compte.';
                    $this->view->message = $message;
                    $this->view->nom = $_POST["nom"];
                    $this->view->prenom = $_POST["prenom"];
                    $this->view->login = $this->_request->getPost("login");
                    $this->view->code_membre = $this->_request->getPost("code_membre");
                    $this->view->raison_sociale = $this->_request->getPost("raison_sociale");
                    $this->view->nom_prenom = $this->_request->getPost("nom_prenom");
                    return;
                } elseif (($code_groupe == 'domi_nrpre' || $code_groupe == 'acnev') && $code_membre == '') {
                    $db->rollback();
                    $message = 'Le code membre est obligatoire pour ce type de compte.';
                    $this->view->message = $message;
                    $this->view->nom = $_POST["nom"];
                    $this->view->prenom = $_POST["prenom"];
                    $this->view->login = $this->_request->getPost("login");
                    $this->view->code_membre = $this->_request->getPost("code_membre");
                    $this->view->raison_sociale = $this->_request->getPost("raison_sociale");
                    $this->view->nom_prenom = $this->_request->getPost("nom_prenom");
                    return;
                } else {
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user)
                            ->setPrenom_utilisateur($this->_request->getPost("prenom"))
                            ->setNom_utilisateur($this->_request->getPost("nom"))
                            ->setLogin(trim($this->_request->getPost("login")))
                            ->setPwd(md5($pwd))
                            ->setDescription($this->_request->getPost("desc"))
                            ->setUlock(0)
                            ->setCh_pwd_flog(0)
                            ->setCode_groupe($code_groupe)
                            ->setConnecte(0)
                            ->setCode_agence($code_agence)
                            ->setCode_secteur($user->code_secteur)
                            ->setCode_zone($user->code_zone)
                            ->setCode_gac_filiere(null)
                            ->setCode_acteur($code_acteur);
                    if ($this->_request->getPost("code_membre") == '') {
                        $userin->setCode_membre($user->code_membre);
                    } else {
                        $userin->setCode_membre($this->_request->getPost("code_membre"));
                    }
                    $mapper->save($userin);
                    $db->commit();
                    return $this->_helper->redirector('index');
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Echec ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
    }

}

?>
