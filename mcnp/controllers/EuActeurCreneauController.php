<?php

class EuActeurCreneauController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'gac') {
            $menu = "<li><a href=\" /eu-acteur-creneau/new \">Nouveau</a></li>" .
                    "<li><a id=\"smcipncre\" href=\"#\">smcipn obtenues</a></li>" .
                    "<li><a href=\"/eu-acteur-creneau/allocacteur \">Allouer investissement</a></li>" .
                    "<li><a href=\"/eu-acteur-creneau/allocacteursal \">Allouer salaire</a></li>" .
                    "<li><a id=\"ressa\" href=\"#\">Ressources allouées</a></li>" .
                    "<li><a id=\"alloc_cre\" href=\"#\">smcipn transmises</a></li>" .
                    "<li><a id=\"recu_cre\" href=\"#\">Mes smcipn reçues</a></li>";
        } elseif ($group == 'filiere' || $group == 'creneau') {
            $menu = "<li><a href=\" /eu-acteur-creneau/new \">Nouveau</a></li>";
        } elseif ($group == 'gac_pbf') {
            $menu = "<li><a href=\" /eu-acteur-creneau/new \">Nouveau</a></li>" .
                    "<li><a id=\"smcipncre\" href=\"#\">smcipn obtenues</a></li>" .
                    "<li><a href=\"/eu-acteur-creneau/allocacteur \">Allouer investissement</a></li>" .
                    "<li><a href=\"/eu-acteur-creneau/allocacteursal \">Allouer salaire</a></li>" .
                    "<li><a id=\"ressa\" href=\"#\">Ressources allouées</a></li>" .
                    "<li><a id=\"alloc_cre\" href=\"#\">smcipn transmises</a></li>" .
                    "<li><a id=\"recu_cre\" href=\"#\">Mes smcipn reçues</a></li>";
        } elseif ($group == 'filiere_pbf' || $group == 'creneau_pbf') {
            $menu = "<li><a href=\" /eu-acteur-creneau/new \">Nouveau</a></li>";
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
            if ($group != 'creneau' && $group != 'creneau_pbf' && $group != 'filiere' && $group != 'filiere_pbf') {
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
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_acteur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuActeurCreneau();
        $select = $tabela->select();
        $ugroupe = $user->code_groupe;

        if ($ugroupe == 'creneau') {
            $select->setIntegrityCheck(false)
                    ->from(array('a' => 'EU_aCTEURS_CRENEaUX'), array('a.CODE_aCTEUR', 'a.NOM_aCTEUR', 'a.code_membre', "TO_CHaR((a.DaTE_CREaTION),'dd/mm/yyyy') DaTE_CREaTION"))
                    ->join(array('c' => 'EU_cRENEaUX'), 'c.cODE_cRENEaU = a.cODE_cRENEaU', array('NOM_cRENEaU'))
                    ->join(array('t' => 'EU_tYPE_aCtEUR'), 't.ID_tYPE_aCtEUR = a.ID_tYPE_aCtEUR', array('LIB_tYPE_aCtEUR'))
                    ->join(array('m' => 'EU_mEmBRE'), 'm.CODE_mEmBRE = a.CODE_mEmBRE_GESTIONNaIRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE', 'PORTaBLE_mEmBRE'))
                    ->where('a.ID_UTILISaTEUR = ?', $user->ID_UTILISaTEUR);
        } elseif ($ugroupe == 'filiere') {
            $select->setIntegrityCheck(false)
                    ->from(array('a' => 'EU_aCTEURS_CRENEaUX'), array('a.CODE_aCTEUR', 'a.NOM_aCTEUR', 'a.code_membre', 'a.CODE_GaC_FILIERE', "TO_CHaR((a.DaTE_CREaTION),'dd/mm/yyyy') DaTE_CREaTION"))
                    ->join(array('f' => 'EU_GaC_fILIERE'), 'f.CODE_GaC_fILIERE = a.CODE_GaC_fILIERE', array('NOM_GaC_fILIERE'))
                    ->join(array('t' => 'EU_tYPE_aCtEUR'), 't.ID_tYPE_aCtEUR = a.ID_tYPE_aCtEUR', array('LIB_tYPE_aCtEUR'))
                    ->join(array('m' => 'EU_mEmBRE'), 'm.CODE_mEmBRE = a.CODE_mEmBRE_GESTIONNaIRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE', 'PORTaBLE_mEmBRE'))
                    ->where('a.ID_UTILISaTEUR = ?', $user->ID_UTILISaTEUR);
        } else {
            $select->setIntegrityCheck(false)
                    ->from(array('a' => 'EU_aCTEURS_CRENEaUX'), array('a.CODE_aCTEUR', 'a.NOM_aCTEUR', 'a.code_membre', 'a.CODE_GaC', "TO_CHaR((a.DaTE_CREaTION),'dd/mm/yyyy') DaTE_CREaTION"))
                    ->join(array('g' => 'EU_gaC'), 'g.CODE_gaC = a.CODE_gaC', array('NOM_gaC'))
                    ->join(array('t' => 'EU_tYPE_aCtEUR'), 't.ID_tYPE_aCtEUR = a.ID_tYPE_aCtEUR', array('LIB_tYPE_aCtEUR'))
                    ->join(array('m' => 'EU_mEmBRE'), 'm.CODE_mEmBRE = a.CODE_mEmBRE_GESTIONNaIRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE', 'PORTaBLE_mEmBRE'))
                    ->where('a.ID_UTILISaTEUR = ?', $user->ID_UTILISaTEUR);
        }
        $acteurs = $tabela->fetchAll($select);
        $count = count($acteurs);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $acteurs = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($acteurs as $row) {
            if ($ugroupe == 'creneau') {
                $nom_acteur = ucfirst($row->nom_creneau);
                $code_gac_fil = null;
            } elseif ($ugroupe == 'filiere') {
                $nom_acteur = ucfirst($row->nom_gac_filiere);
                $code_gac_fil = $row->code_gac_filiere;
            } else {
                $nom_acteur = ucfirst($row->nom_gac);
                $code_gac_fil = null;
            }
            $responce['rows'][$i]['id'] = $row->code_acteur;
            $responce['rows'][$i]['cell'] = array(
                $row->code_acteur,
                ucfirst($row->nom_acteur),
                $row->code_membre,
                ucfirst($row->lib_type_acteur),
                strtoupper($row->nom_membre) . ' ' . ucfirst($row->PREnom_membre),
                $nom_acteur,
                $row->date_creation,
                $code_gac_fil
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $request = $this->getRequest();
        $form = new Application_Form_EuActeurCreneau();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $cm = new Application_Model_EuActeurCreneauMapper();
                    $acren = new Application_Model_EuActeurCreneau($form->getValues());
                    $acren->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $acren->setId_utilisateur($users->id_utilisateur);
                    $ugroupe = $users->code_groupe;
                    $type = '';
                    if ($ugroupe == 'creneau_pbf' || $ugroupe == 'filiere_pbf' || $ugroupe == 'gacsu_pbf') {
                        $acren->setGroupe('pbf');
                        $type = 'pbf';
                    }
                    if ($ugroupe == 'creneau' || $ugroupe == 'filiere' || $ugroupe == 'gacsu') {
                        $acren->setGroupe('gac');
                        $type = 'gac';
                    }
                    $code_cre = $users->code_acteur;

                    if ($ugroupe == 'creneau') {
                        $acren->setCode_creneau($code_cre);
                        $acren->setCode_gac_filiere(null);
                        $acren->setCode_gac(null);
                    } elseif ($ugroupe == 'filiere') {
                        $acren->setCode_creneau(null);
                        $acren->setCode_gac_filiere($code_cre);
                        $acren->setCode_gac(null);
                        $code_filiere = $code_cre;
                    } else {
                        $acren->setCode_creneau(null);
                        $acren->setCode_gac_filiere(null);
                        $acren->setCode_gac($code_cre);
                    }
                    //Formation du code de l'acteur à partir du code du créneau ou code gac filiere ou gac
                    if ($ugroupe == 'creneau') {
                        $code = $cm->getLastActeurByCrenau($code_cre);
                    } elseif ($ugroupe == 'filiere') {
                        $code = $cm->getLastActeurByFiliere($code_cre);
                    } else {
                        $code = $cm->getLastActeurByGac($code_cre);
                    }
                    if ($code == null) {
                        $code_act = $code_cre . 'a' . '0001';
                    } else {
                        $num_ordre = substr($code, -4);
                        $num_ordre++;
                        $code_act = $code_cre . 'a' . str_pad($num_ordre, 4, 0, STR_PaD_LEFT);
                    }
                    $acren->setCode_acteur($code_act);
                    $num = $code_act;
                    $zone = $users->code_zone;
                    $num_membre = $this->_request->getPost("code_membre");
                    $nom = $this->_request->getPost("nom_gestion");
                    $prenom = $this->_request->getPost("prenom_gestion");
                    $acteur = $this->_request->getPost("id_type_acteur");
                    //Vérification du type de contrat de l'acteur du créneau d'activités
                    $mcontra = new Application_Model_EuContratMapper();
                    $find_contra = $mcontra->findByMembre($num_membre);
                    if ($find_contra != false) {
                        $id_type_acteur = $find_contra->getId_type_acteur();
                        $mtypeact = new Application_Model_EuTypeActeurMapper();
                        $typeact = new Application_Model_EuTypeActeur();
                        $mtypeact->find($id_type_acteur, $typeact);
                        $type_acteur = $typeact->getLib_type_acteur();
                        if ($type_acteur == 'grossiste' || $type_acteur == 'semi-grossiste' || $type_acteur == 'détaillant') {
                            if ($id_type_acteur != $acteur) {
                                //Récup du libellé du type d'acteur
                                $mtypeact->find($acteur, $typeact);
                                $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat d\'acteur ' . ucfirst($typeact->getLib_type_acteur());
                                $this->view->form = $form;
                                return;
                            } else {
                                //Vérification du code membre de l'acteur créneau
                                $find_mb = $cm->findByMembre($num_membre);
                                if ($find_mb != false) {
                                    $this->view->message = 'Ce membre ' . $num_membre . ' est déjà enregistré comme acteur créneau';
                                    $this->view->form = $form;
                                } else {
                                    $code_gac_fil = $users->code_gac_filiere;
                                    //Récupération du code_gac à partir du code_gac_filiere
                                    $mgacfil = new Application_Model_EuGacFiliereMapper();
                                    $gacfil = new Application_Model_EuGacFiliere();
                                    $mgacfil->find($code_gac_fil, $gacfil);
                                    $code_gac = $gacfil->getCode_gac();
                                    if ($ugroupe != 'creneau' || $ugroupe != 'filiere') {
                                        $code_gac_fil = $users->code_acteur;
                                        $code_gac = $users->code_acteur;
                                    }
                                    $membm = new Application_Model_EuMembreMoraleMapper();
                                    $membre = new Application_Model_EuMembreMorale();
                                    $membm->find($num_membre, $membre);
                                    //Récupération des agences créés et couvertes par la gac centrale
                                    $magence = new Application_Model_EuAgenceMapper();
                                    $agence = new Application_Model_EuAgence();
                                    $find_agence = $magence->findAllByGac($code_gac);
                                    if (($users->code_groupe == 'filiere' || $users->code_groupe == 'filiere_pbf' || $users->code_groupe == 'creneau' || $users->code_groupe == 'creneau_pbf') and $users->code_membre == '0010010010040000029M') {
                                        $code_agence = array('001001001004');
                                    } else {
                                        $code_agence = array();
                                    }
                                    if ($find_agence != false) {
                                        $i = 0;
                                        foreach ($find_agence as $row) {
                                            $code_agence[$i] = $row->code_agence;
                                            $i++;
                                        }
                                    }
                                    //Récupération de la filière liéé à l'activité
                                    $mapper = new Application_Model_DbTable_EuActivite();
                                    $code_activite = $request->code_activite;
                                    $rows = $mapper->find($code_activite);
                                    $row = $rows->current();
                                    $id_filiere = $row->id_filiere;
//                                    if (in_array($membre->getCode_agence(), $code_agence)) {
                                    //Mise à jour du id_filiere de la table membre
                                    $membre->setId_filiere($id_filiere);
                                    $membm->update($membre);
                                    //Création de l'acteur créneau
                                    $cm->save($acren);
                                    //Récupération de la mdv de la gac filière et de la pck nr
                                    $param = new Application_Model_EuParametresMapper();
                                    $par = new Application_Model_EuParametres();
                                    $prk = 0;
                                    $par_prk = $param->find('prk', 'nr', $par);
                                    if ($par_prk == true) {
                                        $prk = $par->getMontant();
                                    }
                                    $mdvm = new Application_Model_EuMdvMapper();
                                    $find_mdv = $mdvm->findMdvByFiliere($id_filiere);
                                    if ($find_mdv == null) {
                                        $mdv = ceil($prk);
                                    } else {
                                        $md = $find_mdv->getDuree_vie();
                                        if ($md < $prk) {
                                            $mdv = ceil($prk);
                                        } else {
                                            $mdv = $md;
                                        }
                                    }
                                    //Création du tegc du créneau d'activités
                                    $te_mapper = new Application_Model_EuTegcMapper();
                                    $te = new Application_Model_EuTegc();
                                    $code_te = 'tegcp' . $id_filiere . $num_membre;
                                    $find_te = $te_mapper->find($code_te, $te);
                                    if ($find_te == false) {
                                        $te->setCode_tegc($code_te)
                                                ->setId_filiere($id_filiere)
                                                ->setMdv($mdv)
                                                ->setCode_membre($num_membre)
                                                ->setMontant(0);
                                        $te_mapper->save($te);
                                    }
                                    //Initialisation du compte tegcp du créneau d'activités
                                    $date_alloc = new Zend_Date(Zend_Date::ISO_8601);
                                    $code_cat = 'tpagcp';
                                    $code_compte = 'nb-' . $code_cat . '-' . $num_membre;
                                    $compte_mapper = new Application_Model_EuCompteMapper();
                                    $compte = new Application_Model_EuCompte();
                                    $find_compte = $compte_mapper->find($code_compte, $compte);
                                    if ($find_compte == false) {
                                        $compte->setCode_compte($code_compte)
                                                ->setCode_membre(null)
                                                ->setLib_compte('gcp')
                                                ->setSolde(0)
                                                ->setDate_alloc($date_alloc->toString('yyyy-mm-dd'))
                                                ->setCode_type_compte('nb')
                                                ->setCode_cat($code_cat)
                                                ->setDesactiver(0)
                                                ->setMifareCard('')
                                                ->setCardPrintedDate('')
                                                ->setCardPrintedIDDate(0)
                                                ->setCode_membre_morale($num_membre)
                                                ->setNumero_carte(null);
                                        $compte_mapper->save($compte);
                                    }
                                    $db->commit();
                                    return $this->_helper->redirector('newuser', 'eu-user', null, array('controller' => 'eu-user', 'action' => 'newuser', 'membre' => $num_membre, 'type' => $type, 'zone' => $zone, 'num' => $num, 'nom' => $nom, 'prenom' => $prenom, 'code_filiere' => $code_filiere));
//                                    } else {
//                                        //Récup du libellé de l'agence
//                                        $magence->find($membre->getCode_agence(), $agence);
//                                        $this->view->message = 'l\'agence d\'enrôlement "' . $agence->getlibelle_agence() . '" dont le code est "' . $membre->getCode_agence() . '" du membre "' . $num_membre . '" n\'est pas sous votre gestion!!! Dirigez le membre vers son gestionnaire de gac.';
//                                        $this->view->form = $form;
//                                        return;
//                                    }
                                }
                            }
                        } else {
                            $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat d\'acteur créneau';
                            $this->view->form = $form;
                            return;
                        }
                    } else {
                        $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose d\'aucun contrat';
                        $this->view->form = $form;
                        return;
                    }
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = $code . ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                    $this->view->message = $message;
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-acteur-creneau',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $a = new Application_Model_EuActeurCreneau();
        $ma = new Application_Model_EuActeurCreneauMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $ma->find($this->getRequest()->getPost("code_acteur"), $a);
            $a->setNom_acteur($this->_request->getPost("nom_acteur"));
            $a->setType_acteur($this->_request->getPost("type_acteur"));
            $a->setNum_gestion1($this->_request->getPost("num_gestion1"));
            $a->setNom_gestion1($this->_request->getPost("nom_gestion1"));
            $a->setPrenom_gestion1($this->_request->getPost("prenom_gestion1"));
            $a->setTel_gestion1($this->_request->getPost("tel_gestion1"));
            $a->setDate_creation($date_id->toString('yyyy-mm-dd'));
            $a->setCree_par($user->login);
            $ma->update($a);
        }
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuActeurCreneau();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    //Mise à jour du créneau
                    $gcre = new Application_Model_EuActeurCreneau($form->getValues());
                    $gcre->setCode_acteur($this->getRequest()->code_acteur);
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $gcre->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $gcre->setId_utilisateur($user->id_utilisateur);
                    $type = $user->code_groupe;
                    if ($ugroupe == 'creneau_pbf' || $ugroupe == 'filiere_pbf' || $ugroupe == 'gacsu_pbf') {
                        $acren->setGroupe('pbf');
                        $type = 'pbf';
                    }
                    if ($ugroupe == 'creneau' || $ugroupe == 'filiere' || $ugroupe == 'gacsu') {
                        $acren->setGroupe('gac');
                        $type = 'gac';
                    }
                    if ($type == 'creneau') {
                        $gcre->setCode_creneau($user->code_acteur);
                        $gcre->setCode_gac_filiere(null);
                        $gcre->setCode_gac(null);
                    } elseif ($type == 'filiere') {
                        $gcre->setCode_creneau(null);
                        $gcre->setCode_gac_filiere($user->code_acteur);
                        $gcre->setCode_gac(null);
                    } else {
                        $gcre->setCode_creneau(null);
                        $gcre->setCode_gac_filiere(null);
                        $gcre->setCode_gac($user->code_acteur);
                    }
                    //Vérification du type de contrat de l'acteur du créneau d'activités
                    $mcontra = new Application_Model_EuContratMapper();
                    $num_membre = $this->getRequest()->code_membre;
                    $acteur = $this->getRequest()->id_type_acteur;
                    $find_contra = $mcontra->findByMembre($num_membre);
                    if ($find_contra != false) {
                        $id_type_acteur = $find_contra->getId_type_acteur();
                        $mtypeact = new Application_Model_EuTypeActeurMapper();
                        $typeact = new Application_Model_EuTypeActeur();
                        $mtypeact->find($id_type_acteur, $typeact);
                        $type_acteur = $typeact->getLib_type_acteur();
                        if ($type_acteur == 'grossiste' || $type_acteur == 'semi-grossiste' || $type_acteur == 'détaillant') {
                            if ($id_type_acteur != $acteur) {
                                //Récup du libellé du type d'acteur
                                $mtypeact->find($acteur, $typeact);
                                $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat d\'acteur ' . ucfirst($typeact->getLib_type_acteur());
                                $this->view->form = $form;
                                return;
                            } else {
                                $code_gac_fil = $user->code_gac_filiere;
                                $membm = new Application_Model_EuMembreMapper();
                                $membre = new Application_Model_EuMembre();
                                $membm->find($num_membre, $membre);
                                //Récupération du code_gac à partir du code_gac_filiere
                                $mgacfil = new Application_Model_EuGacFiliereMapper();
                                $gacfil = new Application_Model_EuGacFiliere();
                                $mgacfil->find($code_gac_fil, $gacfil);
                                $code_gac = $gacfil->getCode_gac();
                                //Récupération des agences créés et couvertes par la gac centrale
                                $magence = new Application_Model_EuAgenceMapper();
                                $agence = new Application_Model_EuAgence();
                                $find_agence = $magence->findAllByGac($code_gac);
                                if (($user->code_groupe == 'filiere' || $user->code_groupe == 'filiere_pbf' || $user->code_groupe == 'creneau' || $user->code_groupe == 'creneau_pbf') and $user->code_membre == '0010010010040000029M') {
                                    $code_agence = array('001001001004');
                                } else {
                                    $code_agence = array();
                                }
                                if ($find_agence != false) {
                                    $i = 0;
                                    foreach ($find_agence as $row) {
                                        $code_agence[$i] = $row->code_agence;
                                        $i++;
                                    }
                                }
                                if (in_array($membre->getCode_agence(), $code_agence)) {
                                    //Mise à jour de l'acteur créneau
                                    $mapper = new Application_Model_EuActeurCreneauMapper();
                                    $mapper->update($gcre);
                                    $db->commit();
                                    return $this->_helper->redirector('index');
                                } else {
                                    //Récup du libellé de l'agence
                                    $magence->find($membre->getCode_agence(), $agence);
                                    $this->view->message = 'l\'agence d\'enrôlement "' . $agence->getlibelle_agence() . '" dont le code est "' . $membre->getCode_agence() . '" du membre "' . $num_membre . '" n\'est pas sous votre gestion!!! Dirigez le membre vers son gestionnaire de gac.';
                                    $this->view->form = $form;
                                    return;
                                }
                            }
                        } else {
                            $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat d\'acteur créneau';
                            $this->view->form = $form;
                            return;
                        }
                    } else {
                        $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose d\'aucun contrat';
                        $this->view->form = $form;
                        return;
                    }
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                    $this->view->message = $message;
                }
            }
        } else {
            $code_act = $request->gac_act;
            $mapper = new Application_Model_EuActeurCreneauMapper();
            $gcre = new Application_Model_EuActeurCreneau();
            $mapper->find($code_act, $gcre);
            if ($gcre->getCode_acteur() == $code_act) {
                //Récupération des informations du gestionnaire                    
                $mmember = new Application_Model_EuMembreMapper();
                $member = new Application_Model_EuMembre();
                $mmember->find($gcre->getCode_membre_gestionnaire(), $member);
                $data = array(
                    'code_acteur' => $code_act,
                    'nom_acteur' => $gcre->getNom_acteur(),
                    'code_membre' => $gcre->getCode_membre(),
                    'id_filiere' => $gcre->getId_filiere(),
                    'id_type_acteur' => $gcre->getId_type_acteur(),
                    'code_membre_gestionnaire' => $gcre->getCode_membre_gestionnaire(),
                    'nom_gestion' => $member->getNom_membre(),
                    'prenom_gestion' => $member->getPrenom_membre(),
                    'tel_gestion' => $member->getPortable_membre(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-acteur-creneau',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function smcipncreAction() {
        $this->_helper->layout->disableLayout();
    }

    public function smcipncrelistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();
        $num = $user->code_membre;
        $code = $user->code_acteur;
        $code_groupe = $user->code_groupe;
        //Récupération des demandes du créneau d'activités
        if (($code_groupe == 'filiere' || $code_groupe == 'creneau') and $num != '') {
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                    ->where('eu_smcipn.alloc_fil_inv = ?', 1)
                    ->where('eu_smcipn.alloc_creneau_inv = ?', 0)
                    ->where('eu_smcipn.code_membre =?', $num);

            $select2 = $tabela->select();
            $select2->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_gac_sal = ?', 1)
                    ->where('eu_smcipn.alloc_fil_sal = ?', 1)
                    ->where('eu_smcipn.alloc_creneau_sal = ?', 0)
                    ->where('eu_smcipn.etat_sal = ?', 3)
                    ->where('eu_smcipn.code_membre =?', $num);
        }
        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuActeurCreneau();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->where('code_creneau = ?', $code);
        $listact = $tabel->fetchAll($sel);
        $mb = array();
        $i = 0;
        foreach ($listact as $row) {
            $mb[$i] = $row->code_membre;
            $i++;
        }
        if (count($mb) != 0) {
            $tab = $mb;
        } else {
            $tab = array('0');
        }
        //Récupération des demandes des acteurs des créneaux d'activités
        $select3 = $tabela->select();
        $select3->setIntegrityCheck(false)
                ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                ->where('eu_smcipn.alloc_fil_inv = ?', 1)
                ->where('eu_smcipn.alloc_creneau_inv = ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $tab);

        $select4 = $tabela->select();
        $select4->setIntegrityCheck(false)
                ->where('eu_smcipn.alloc_gac_sal = ?', 1)
                ->where('eu_smcipn.alloc_fil_sal = ?', 1)
                ->where('eu_smcipn.alloc_creneau_sal = ?', 0)
                ->where('eu_smcipn.etat_sal = ?', 3)
                ->where('eu_smcipn.code_membre in (?)', $tab);

        $select->setIntegrityCheck(false);
        if (($code_groupe == 'filiere' || $code_groupe == 'creneau') and $num != '') {
            $select->union(array($select1, $select2, $select3, $select4));
        } else {
            $select->union(array($select3, $select4));
        }
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

        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $heure_dem = new Zend_Date($row->heure_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->sal_transmis,
                $row->montant_investis,
                $date_dem->toString('dd/mm/yyyy'),
                $heure_dem->toString('hh:mm'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function allocacteurAction() {
        $form = new Application_Form_EuActeurCreneauAlloc();
        $this->view->form = $form;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            //$data[0] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->PREnom_membre);
            $data[1] = $result->raison_sociale;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function recupacteurAction() {

        $num_membre = $_GET['num_membre'];
        $acteur_db = new Application_Model_DbTable_EuActeurCreneau();
        $select = $acteur_db->select();
        $select->where('code_membre like ?', $num_membre);
        $acteur = $acteur_db->fetchAll($select);
        if (count($acteur) == 1) {
            $result = $acteur->current();
            $data[0] = strtoupper($result->nom_acteur);
            $data[1] = $result->code_membre;
            $data[2] = $result->id_type_acteur;
            $data[3] = $result->id_filiere;
            $data[4] = $result->code_membre_gestionnaire;
            $data[5] = $result->code_acteur;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function changeAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre_morale;
        }
        $this->view->data = $data;
    }

    public function typeacteurAction() {
        $t_type = new Application_Model_DbTable_EuTypeActeur();
        $types = $t_type->fetchAll();
        if (count($types) >= 1) {
            $data = array();
            for ($i = 0; $i < count($types); $i++) {
                $value = $types[$i];
                $data[$i][0] = $value->id_type_acteur;
                $data[$i][1] = $value->lib_type_acteur;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function filiereAction() {
        $filiere = new Application_Model_DbTable_EuFiliere();
        $filieres = $filiere->fetchAll();
        if (count($filieres) >= 1) {
            $data = array();
            for ($i = 0; $i < count($filieres); $i++) {
                $value = $filieres[$i];
                $data[$i][0] = $value->id_filiere;
                $data[$i][1] = $value->nom_filiere;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function activiteAction() {
        $filiere = new Application_Model_DbTable_EuActivite();
        $filieres = $filiere->fetchAll();
        if (count($filieres) >= 1) {
            $data = array();
            for ($i = 0; $i < count($filieres); $i++) {
                $value = $filieres[$i];
                $data[$i][0] = $value->code_activite;
                $data[$i][1] = $value->nom_activite;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function traiterAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();

        $code_acteur = $_POST['code_acteur'];
        $nom_acteur = $_POST['nom'];
        $num_membre = $_POST['num_membre'];
        $type_acteur = $_POST['id_type_acteur'];
        $id_filiere = $_POST['id_filiere'];
        $code_membre_gestion = $_POST['code_membre_gestionnaire'];

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //$select = "delete from eu_acteurs_creneaux  where code_acteur= '$code_acteur'";
            //$db->query($select);

            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_creation = clone $date_id;

            $cm = new Application_Model_EuActeurCreneauMapper();
            $acren = new Application_Model_EuActeurCreneau();
            $find_acren = $cm->find($code_acteur, $acren);

            $acren->setNom_acteur($nom_acteur);
            $acren->setCode_membre($num_membre);
            $acren->setId_type_acteur($type_acteur);
            $acren->setId_filiere($id_filiere);
            $acren->setCode_membre_gestionnaire($code_membre_gestion);
            $acren->setDate_creation($date_creation->toString('yyyy-mm-dd'));
            $acren->setId_utilisateur($users->id_utilisateur);
            $ugroupe = $users->code_groupe;
            $type = '';
            if ($ugroupe == 'creneau_pbf' || $ugroupe == 'filiere_pbf') {
                $acren->setGroupe('pbf');
                $type = 'pbf';
            }
            if ($ugroupe == 'creneau' || $ugroupe == 'filiere') {
                $acren->setGroupe('gac');
                $type = 'gac';
            }
            $if_filiere = $this->getRequest()->id_filiere;
            if ($if_filiere == '') {
                $filiere = null;
            } else {
                $filiere = $if_filiere;
            }

            $acren->setId_filiere($filiere);
            $code_cre = $users->code_acteur;
            if ($ugroupe == 'creneau') {
                $acren->setCode_creneau($code_cre);
                $acren->setCode_gac_filiere(null);
            } else {
                $acren->setCode_creneau(null);
                $acren->setCode_gac_filiere($code_cre);
            }

            //Formation du code de l'acteur à partir du code du créneau ou code gac filiere
            /*   if ($ugroupe == 'creneau') {
              $code = $cm->getLastActeurByCrenau($code_cre);
              }
              else {
              $code = $cm->getLastActeurByFiliere($code_cre);
              }
              if ($code == null) {
              $code_act = $code_cre . 'a' . '0001';
              } else {
              $num_ordre = substr($code, -4);
              $num_ordre++;
              $code_act = $code_cre . 'a' . str_pad($num_ordre, 4, 0, STR_PaD_LEFT);
              }
             */

            //$acren->setCode_acteur($code_act);
            $acteur = $this->_request->getPost("id_type_acteur");

            //Vérification du type de contrat de l'acteur du créneau d'activités
            $mcontra = new Application_Model_EuContratMapper();
            $find_contra = $mcontra->findByMembre($num_membre);
            if ($find_contra != false) {
                $id_type_acteur = $find_contra->getId_type_acteur();
                $mtypeact = new Application_Model_EuTypeActeurMapper();
                $typeact = new Application_Model_EuTypeActeur();
                $mtypeact->find($id_type_acteur, $typeact);
                $type_acteur = $typeact->getLib_type_acteur();
                if ($type_acteur == 'grossiste' || $type_acteur == 'semi-grossiste' || $type_acteur == 'détaillant') {
                    if ($id_type_acteur != $acteur) {
                        //Récup du libellé du type d'acteur
                        $mtypeact->find($acteur, $typeact);
                        $this->view->data = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat d\'acteur ' . ucfirst($typeact->getLib_type_acteur());
                        return;
                    } else {
                        // Vérification du code membre du créneau
                        //  $find_mb = $cm->findByMembre($num_membre);
                        //  if ($find_mb != false) {
                        // $this->view->data = 'Ce membre ' . $num_membre . ' est déjà enregistré comme acteur créneau';
                        // } else {
                        //Création de l'acteur créneau
                        $cm->update($acren);
                        //Récupération de la mdv de la gac filière
                        $code_gac_fil = $users->code_gac_filiere;
                        //Récupération de la pck nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prk = 0;
                        $par_prk = $param->find('prk', 'nr', $par);
                        if ($par_prk == true) {
                            $prk = $par->getMontant();
                        }
                        $mdvm = new Application_Model_EuMdvMapper();
                        $find_mdv = $mdvm->findMdvByFilMembre($code_gac_fil);
                        if ($find_mdv == null) {
                            $mdv = ceil($prk);
                        } else {
                            $md = $find_mdv->getDuree_vie();
                            if ($md < $prk) {
                                $mdv = ceil($prk);
                            } else {
                                $mdv = $md;
                            }
                        }

                        //Création du tegc du créneau d' activités
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'tegcp' . $code_gac_fil . $num_membre;
                        $find_te = $te_mapper->find($code_te, $te);
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
                                    ->setCode_Gac_Filiere($code_gac_fil)
                                    ->setMdv($mdv)
                                    ->setCode_membre($num_membre)
                                    ->setMontant(0);
                            $te_mapper->save($te);
                        } else {
                            $te->setCode_Gac_Filiere($code_gac_fil);
                            $te->setMdv($mdv);
                            $te_mapper->update($te);
                        }
                        //Initialisation du compte tegcp du créneau d'activités
                        $date_alloc = new Zend_Date(Zend_Date::ISO_8601);
                        $code_cat = 'tpagcp';
                        $code_compte = 'nb-' . $code_cat . '-' . $num_membre;
                        $compte_mapper = new Application_Model_EuCompteMapper();
                        $compte = new Application_Model_EuCompte();
                        $find_compte = $compte_mapper->find($code_compte, $compte);
                        if ($find_compte == false) {
                            $compte->setCode_compte($code_compte)
                                    ->setCode_membre($num_membre)
                                    ->setLib_compte('gcp')
                                    ->setSolde(0)
                                    ->setDate_alloc($date_alloc->toString('yyyy-mm-dd'))
                                    ->setCode_type_compte('nb')
                                    ->setCode_cat($code_cat)
                                    ->setDesactiver(0);
                            $compte_mapper->save($compte);
                        }
                        //Mise à jour du code_gac_filiere de la table membre
                        $membm = new Application_Model_EuMembreMapper();
                        $membre = new Application_Model_EuMembre();
                        $membm->find($num_membre, $membre);
                        $membre->setCode_Gac_Filiere($code_gac_fil);
                        $membm->update($membre);

                        //Mise à jour de la table eu_utilisateur
                        $select1 = "update eu_utilisateur  set  code_gac_filiere ='$code_gac_fil',code_acteur='$code_acteur' 
                                                 where code_membre= '$num_membre'";
                        $db->query($select1);

                        $db->commit();
                        $this->view->data = true;
                        return;
                        //}
                    }
                } else {
                    $this->view->data = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat d\'acteur créneau';
                    //$this->view->form = $form;
                    return;
                }
            } else {
                $this->view->data = 'Ce membre ' . $num_membre . ' ne dispose d\'aucun contrat';
                //$this->view->form = $form;
                return;
            }
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            //$this->view->message = $message;
            $this->view->data = $message;
            return;
        }
    }

    public function misesurchaineAction() {
        
    }

    public function allocacteursalAction() {
        $form = new Application_Form_EuActeurCreneauAllocSal();
        $this->view->form = $form;
    }

    public function listsmcipnactAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_smcipn');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        if ($_GET['num_act'] != '') {
            $numero_act = $_GET['num_act'];
            //Recherche du numéro membre du créneau d'activités
            $mact = new Application_Model_EuActeurCreneauMapper();
            $act = new Application_Model_EuActeurCreneau();
            $mact->find($numero_act, $act);
            $num_act = $act->getCode_membre();
            $nom_act = $act->getNom_acteur();
            //Récupération des demandes des acteurs des créneaux d'activités
            $select = $tabela->select();
            $select->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                    ->where('eu_smcipn.alloc_fil_inv = ?', 1)
                    ->where('eu_smcipn.alloc_creneau_inv = ?', 0)
                    ->where('eu_smcipn.code_membre =?', $num_act)
                    ->where('eu_smcipn.montant_investis != ?', 0)
                    ->where('eu_smcipn.allouer_i != ?', 1);
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
            $tot = 0;
            foreach ($smcipn as $row) {
                $totsal+=$row->montant_salaire;
                $totinves+=$row->montant_investis;
                $total = $row->montant_salaire + $row->montant_investis;
                $tot+=$total;
                $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_smcipn;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_smcipn,
                    ucfirst($row->lib_demande),
                    $row->code_membre,
                    ucfirst($nom_act),
                    $date_dem->toString('dd/mm/yyyy'),
                    $row->montant_salaire,
                    $row->montant_investis,
                    $total,
                );
                $i++;
            }
            $responce['userdata']['date_demand'] = 'Total:';
            $responce['userdata']['mt_salaire'] = $totsal;
            $responce['userdata']['mt_investis'] = $totinves;
            $responce['userdata']['total'] = $tot;
            $this->view->data = $responce;
        }
    }

    public function listsmcipnactsalAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_smcipn');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $num_act = null;
        if ($_GET['num_act'] != '') {
            $numero_act = $_GET['num_act'];
            //Recherche du numéro membre du créneau d'activités
            $mact = new Application_Model_EuActeurCreneauMapper();
            $act = new Application_Model_EuActeurCreneau();
            $mact->find($numero_act, $act);
            $num_act = $act->getCode_membre();
            $nom_act = $act->getNom_acteur();
            //Récupération des demandes des acteurs des créneaux d'activités
            $select = $tabela->select();
            $select->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_creneau_sal = ?', 0)
                    ->where('eu_smcipn.code_membre =?', $num_act)
                    ->where('eu_smcipn.etat_sal = ?', 3)
                    ->where('eu_smcipn.allouer_s != ?', 1)
                    ->where('eu_smcipn.sal_transmis != ?', 0);
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
            $tot = 0;
            foreach ($smcipn as $row) {
                $totsal+=$row->sal_transmis;
                $totinves+=$row->montant_investis;
                $total = $row->montant_salaire + $row->montant_investis;
                $tot+=$total;
                $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_smcipn;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_smcipn,
                    ucfirst($row->lib_demande),
                    $row->code_membre,
                    ucfirst($nom_act),
                    $date_dem->toString('dd/mm/yyyy'),
                    $row->sal_transmis,
                    $row->montant_investis,
                    $total,
                );
                $i++;
            }
            $responce['userdata']['date_demand'] = 'Total:';
            $responce['userdata']['mt_salaire'] = $totsal;
            $responce['userdata']['mt_investis'] = $totinves;
            $responce['userdata']['total'] = $tot;
            $this->view->data = $responce;
        }
    }

    public function allouerAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $numero_act = $_GET['num_act'];
        //Recherche du numéro membre de l'acteur du créneau d'activités
        $mact = new Application_Model_EuActeurCreneauMapper();
        $act = new Application_Model_EuActeurCreneau();
        $mact->find($numero_act, $act);
        $num_act = $act->getCode_membre();
        $smc = new Application_Model_EuSmcipnMapper();
        $sm = new Application_Model_EuSmcipn();
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $gcsc = new Application_Model_EuGcsc();
        $m_gcsc = new Application_Model_EuGcscMapper();
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $mt_inves = 0;
                $mt_smc = 0;
                $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin;
                foreach ($selection as $sel) {
                    //Mise à jour de la table smcipn
                    $smc->find($sel, $sm);
                    $sm->setCode_smcipn($sm->getCode_smcipn());
                    $sm->setAlloc_creneau_inv(1);
                    $mt_inves+=$sm->getMontant_investis();
                    $mt_smc+=$sm->getMontant_investis() + $sm->getMontant_salaire();
                    $smc->update($sm);
                    //Création des comptes de subvention pour chaque smcipn
                    if ($sm->getCode_membre() == $num_act) {
                        $code_smcipn = $sm->getCode_smcipn();
                        $compte_credit = new Application_Model_EuCompteCredit();
                        $cc_mapper = new Application_Model_EuCompteCreditMapper();
                        //Création du compte tsci du bénéficiaire de la smcipn
                        if ($sm->getMontant_investis() > 0) {
                            $cat_compte = 'tsci';
                            $num_comptes = 'nr-' . $cat_compte . '-' . $num_act;
                            $result = $cm_mapper->find($num_comptes, $compte);
                            if ($result == false) {
                                $compte->setCode_membre($num_act)
                                        ->setCode_cat($cat_compte)
                                        ->setDesactiver(0)
                                        ->setCode_type_compte('nr')
                                        ->setSolde($sm->getMontant_investis())
                                        ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                        ->setCode_compte($num_comptes)
                                        ->setLib_compte($cat_compte);
                                $cm_mapper->save($compte);
                            } else {
                                $compte->setSolde($compte->getSolde() + $sm->getMontant_investis());
                                $cm_mapper->update($compte);
                            }
                            //Enregistrement des détails des subventions dans la table compte crédit
                            $date_fin->addDay(ceil($sm->getDvm_demande() * 30));
                            $compte_credit->setCode_membre($num_act)
                                    ->setCode_produit('Ir')
                                    ->setMontant_place($sm->getMontant_investis())
                                    ->setDatedeb($date_deb->toString('yyyy-mm-dd'))
                                    ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                    ->setDate_octroi($date_deb->toString('yyyy-mm-dd'))
                                    ->setSource($num_act . $date_deb->toString('yyyyMMddHHmmss'))
                                    ->setCode_compte($num_comptes)
                                    ->setMontant_credit($sm->getMontant_investis())
                                    ->setRenouveller('n')
                                    ->setCompte_source($code_smcipn)
                                    ->setKrr('n')
                                    ->setBnp(0)
                                    ->setDomicilier(0)
                                    ->setCode_bnp(null)
                                    ->setAffecter(0);
                            $cc_mapper->save($compte_credit);
                            //Récupération de la prk et de la pck pour les nr
                            $param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $prk = 0;
                            $pck = 0;
                            $mt_rembourse = 0;
                            $par_prk = $param->find('prk', 'nr', $par);
                            if ($par_prk == true) {
                                $prk = $par->getMontant();
                            }
                            $par_pck = $param->find('pck', 'nr', $par);
                            if ($par_pck == true) {
                                $pck = $par->getMontant();
                            }
                            //Détermination du montant à rembourser
                            if ($sm->getType_smcipn() == 'smcipn' || $sm->getType_smcipn() == 'smci') {
                                $mt_rembourse = round(($sm->getMontant_investis() * $prk) / $pck);
                            }
                            //Récupération du code de la domiciliation
                            $mdom = new Application_Model_EuDomiciliationMapper();
                            $find_dom = $mdom->findBySmcipn($code_smcipn);
                            $code_domi = '';
                            if ($find_dom != null) {
                                $code_domi = $find_dom->getCode_domicilier();
                            }
                            //Enregistrement de la smcipn dans la table gcsc
                            $find_gcsc = $m_gcsc->findByDomicilie($code_domi);
                            if ($find_gcsc != null) {
                                $m_gcsc->find($find_gcsc->getId_gcsc(), $gcsc);
                                $gcsc->setDebit($find_gcsc->getDebit() + $mt_rembourse);
                                $gcsc->setCredit($find_gcsc->getCredit());
                                $gcsc->setSolde($find_gcsc->getSolde() - $mt_rembourse);
                                $gcsc->setCode_smcipn($code_smcipn);
                                $gcsc->setCode_smcipnp($find_gcsc->getCode_smcipnp());
                                $m_gcsc->update($gcsc);
                            } else {
                                $gcsc->setCode_membre($num_act);
                                $gcsc->setDebit($mt_rembourse);
                                $gcsc->setCredit(0);
                                $gcsc->setSolde($mt_rembourse);
                                $gcsc->setCode_smcipn($code_smcipn);
                                $gcsc->setCode_smcipnp(null);
                                $m_gcsc->save($gcsc);
                            }
                            //Mise à jour de l'investissement aloué dans la table smcipn
                            $sm->setInvestis_alloue($sm->getInvestis_alloue() + $sm->getMontant_investis());
                            $sm->setAllouer_i(1);
                            $smc->update($sm);
                        }
                    }
                }

                //####Traitement de l'investissement de la smcipn####
                $cgm = New Application_Model_EuCompteMapper();
                $cg = new Application_Model_EuCompte();
                $num_cre = $user->code_membre;
                if ($mt_inves > 0) {
                    $code_cat = 'Ir';
                    $num_compteg = 'nr-' . $code_cat . '-' . $num_cre;
                    $cgm->find($num_compteg, $cg);
                    if (count($cg) == 1) {
                        $mt_i = $cg->getSolde();
                        if ($mt_i >= $mt_inves) {
                            //Ajout dans la table opération
                            $alloc = new Application_Model_EuOperation();
                            $alloc->setDate_op($date_deb->toString('yyyy-mm-dd'));
                            $alloc->setHeure_op($date_deb->toString('hh:mm'));
                            $alloc->setMontant_op($mt_inves);
                            $alloc->setCode_membre($num_act);
                            $alloc->setCode_produit($code_cat);
                            $alloc->setId_utilisateur($user->id_utilisateur);
                            $alloc->setLib_op('Allocation de ressources à un acteur d\'un créneau');
                            $alloc->setCode_cat('i');
                            $alloc->setType_op('ara');
                            $mapper = new Application_Model_EuOperationMapper();
                            $mapper->save($alloc);

                            //Ajout dans la table compte
                            if ($sm->getCode_membre() != $num_act) {
                                $compte = new Application_Model_EuCompte();
                                $cm_mapper = new Application_Model_EuCompteMapper();
                                $num_comptef = 'nr-' . $code_cat . '-' . $num_act;
                                $result = $cm_mapper->find($num_comptef, $compte);
                                if ($result == false) {
                                    $compte->setCode_membre($num_act)
                                            ->setCode_cat('i')
                                            ->setDesactiver(0)
                                            ->setCode_type_compte('nr')
                                            ->setSolde($mt_inves)
                                            ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                            ->setCode_compte($num_comptef)
                                            ->setLib_compte($code_cat);
                                    $cm_mapper->save($compte);
                                } else {
                                    $compte->setSolde($compte->getSolde() + $mt_inves);
                                    $cm_mapper->update($compte);
                                }
                            }

                            //Mise à jour du compte Ir du créneau d'activités 
                            $res = $cm_mapper->find($num_compteg, $compte);
                            if ($res == false) {
                                $this->view->data = 'compte_fil';
                                return;
                            } else {
                                if ($mt_inves <= $compte->getSolde()) {
                                    $compte->setSolde($compte->getSolde() - $mt_inves);
                                    $cm_mapper->update($compte);
                                } else {
                                    $this->view->data = 'alloc_i';
                                    return;
                                }
                            }
                        } else {
                            $this->view->data = 'inves';
                            return;
                        }
                    }
                }

                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->data = $message;
                return;
            }
        }
    }

    public function allouersalAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $numero_act = $_GET['num_act'];
        //Recherche du numéro membre de l'acteur du créneau d'activités
        $mact = new Application_Model_EuActeurCreneauMapper();
        $act = new Application_Model_EuActeurCreneau();
        $mact->find($numero_act, $act);
        $num_act = $act->getCode_membre();
        $smc = new Application_Model_EuSmcipnMapper();
        $sm = new Application_Model_EuSmcipn();
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $gcsc = new Application_Model_EuGcsc();
        $m_gcsc = new Application_Model_EuGcscMapper();
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $mt_salaire = 0;
                $sal_alloue = 0;
                $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin;
                foreach ($selection as $sel) {
                    $smc->find($sel, $sm);
                    $type_alloc = $sm->getType_alloc();
                    //Détermination du montant du salaire à transférer
                    if ($type_alloc == 'periodique') {
                        $sm->setAlloc_creneau_sal(0);
                    } else {
                        $sm->setAlloc_creneau_sal(1);
                    }
                    $sal_alloue = $sm->getSal_transmis();
                    $mt_salaire+=$sal_alloue;
                    $sm->setEtat_sal(0);
                    //Mise à jour de la table smcipn
                    $smc->update($sm);
                    //Création des comptes de subvention du bénéficiaire pour chaque smcipn
                    if ($sm->getCode_membre() == $num_act) {
                        $code_smcipn = $sm->getCode_smcipn();
                        $compte_credit = new Application_Model_EuCompteCredit();
                        $cc_mapper = new Application_Model_EuCompteCreditMapper();
                        //Création du compte tpn du bénéficiaire de la smcipn
                        if ($sal_alloue > 0) {
                            $cat_compte = 'tpn';
                            $num_comptes = 'nr-' . $cat_compte . '-' . $num_act;
                            $result = $cm_mapper->find($num_comptes, $compte);
                            if ($result == false) {
                                $compte->setCode_membre($num_act)
                                        ->setCode_cat($cat_compte)
                                        ->setDesactiver(0)
                                        ->setCode_type_compte('nr')
                                        ->setSolde($sal_alloue)
                                        ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                        ->setCode_compte($num_comptes)
                                        ->setLib_compte($cat_compte);
                                $cm_mapper->save($compte);
                            } else {
                                $compte->setSolde($compte->getSolde() + $sal_alloue);
                                $cm_mapper->update($compte);
                            }
                            //Enregistrement des détails des subventions dans la table compte crédit
                            $date_fin->addDay(ceil($sm->getDvm_demande() * 30));
                            $rest = $cc_mapper->findBySMC($sel, $num_comptes);
                            if ($rest == false) {
                                $compte_credit->setCode_membre($num_act)
                                        ->setCode_produit('CNCSr')
                                        ->setMontant_place($sal_alloue)
                                        ->setDatedeb($date_deb->toString('yyyy-mm-dd'))
                                        ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                        ->setDate_octroi($date_deb->toString('yyyy-mm-dd'))
                                        ->setSource($num_act . $date_deb->toString('yyyyMMddHHmmss'))
                                        ->setCode_compte($num_comptes)
                                        ->setMontant_credit($sal_alloue)
                                        ->setRenouveller('n')
                                        ->setCompte_source($code_smcipn)
                                        ->setKrr('n')
                                        ->setBnp(0)
                                        ->setDomicilier(0)
                                        ->setCode_bnp(null)
                                        ->setAffecter(0);
                                $cc_mapper->save($compte_credit);
                            } else {
                                $result = $rest[0];
                                $compte_credit->setId_credit($result->getId_credit())
                                        ->setMontant_credit($result->getMontant_credit() + $sal_alloue)
                                        ->setCode_membre($result->getCode_membre())
                                        ->setCode_produit($result->getCode_produit())
                                        ->setMontant_place($result->getMontant_place() + $sal_alloue)
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
                                        ->setCode_bnp($result->getCode_bnp())
                                        ->setAffecter($result->getAffecter());
                                $cc_mapper->update($compte_credit);
                            }
                            $cat_objet = $sm->getType_objet();
                            if ($cat_objet == null) {
                                //Récupération du code de la domiciliation
                                $mdom = new Application_Model_EuDomiciliationMapper();
                                $find_dom = $mdom->findBySmcipn($code_smcipn);
                                $code_domi = '';
                                if ($find_dom != null) {
                                    $code_domi = $find_dom->getCode_domicilier();
                                }
                                //Enregistrement de la smcipn dans la table gcsc
                                $find_gcsc = $m_gcsc->findByDomicilie($code_domi);
                                if ($find_gcsc != null) {
                                    $m_gcsc->find($find_gcsc->getId_gcsc(), $gcsc);
                                    $gcsc->setDebit($find_gcsc->getDebit() + $sm->getMontant_salaire());
                                    $gcsc->setCredit($find_gcsc->getCredit());
                                    $gcsc->setSolde($find_gcsc->getSolde() - $sm->getMontant_salaire());
                                    $gcsc->setCode_smcipn($code_smcipn);
                                    $gcsc->setCode_smcipnp($find_gcsc->getCode_smcipnp());
                                    $m_gcsc->update($gcsc);
                                } else {
                                    $gcsc->setCode_membre($num_act);
                                    $gcsc->setDebit($sm->getMontant_salaire());
                                    $gcsc->setCredit(0);
                                    $gcsc->setSolde($sm->getMontant_salaire());
                                    $gcsc->setCode_smcipn($code_smcipn);
                                    $gcsc->setCode_smcipnp(null);
                                    $m_gcsc->save($gcsc);
                                }
                            }
                            $mt_alloue = $sm->getSalaire_alloue();
                            //Mise à jour du salaire aloué dans la table smcipn
                            if ($mt_alloue == $sm->getMontant_salaire()) {
                                $sm->setAllouer_s(1);
                                $sm->setSal_transmis(0);
                                $sm->setEtat_sal(0);
                            } else {
                                $sm->setAllouer_s(0);
                                $sm->setSal_transmis(0);
                                $sm->setEtat_sal(0);
                            }
                            $smc->update($sm);
                        }
                    }
                }

                $cgm = New Application_Model_EuCompteMapper();
                $cg = new Application_Model_EuCompte();
                $num_cre = $user->code_membre;
                //####Traitement du salaire de la smcipn####               
                if ($mt_salaire > 0) {
                    $code_cat = 'CNCSr';
                    $num_compteg = 'nr-' . $code_cat . '-' . $num_cre;
                    $cgm->find($num_compteg, $cg);
                    if (count($cg) == 1) {
                        $mt_s = ceil($cg->getSolde());
                        if ($mt_s >= $mt_salaire) {
                            //Ajout dans la table opération
                            $alloc = new Application_Model_EuOperation();
                            $alloc->setDate_op($date_deb->toString('yyyy-mm-dd'));
                            $alloc->setHeure_op($date_deb->toString('hh:mm'));
                            $alloc->setMontant_op($mt_salaire);
                            $alloc->setCode_membre($num_act);
                            $alloc->setCode_produit($code_cat);
                            $alloc->setId_utilisateur($user->id_utilisateur);
                            $alloc->setLib_op('Allocation de ressources à un acteur d\'un créneau');
                            $alloc->setCode_cat('cncs');
                            $alloc->setType_op('ara');
                            $mapper = new Application_Model_EuOperationMapper();
                            $mapper->save($alloc);
                            //Ajout dans la table compte
                            if ($sm->getCode_membre() != $num_act) {
                                $compte = new Application_Model_EuCompte();
                                $cm_mapper = new Application_Model_EuCompteMapper();
                                $num_comptef = 'nr-' . $code_cat . '-' . $num_act;
                                $result = $cm_mapper->find($num_comptef, $compte);
                                if ($result == false) {
                                    $compte->setCode_compte($num_act)
                                            ->setCode_cat('cncs')
                                            ->setDesactiver(0)
                                            ->setCode_type_compte('nr')
                                            ->setSolde($mt_salaire)
                                            ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                            ->setCode_compte($num_comptef)
                                            ->setLib_compte($code_cat);
                                    $cm_mapper->save($compte);
                                } else {
                                    $compte->setSolde($compte->getSolde() + $mt_salaire);
                                    $cm_mapper->update($compte);
                                }
                            }

                            //Mise à jour du compte CNCSr du créneau d'activités 
                            $res = $cm_mapper->find($num_compteg, $compte);
                            if ($res == false) {
                                $this->view->data = 'compte_fils';
                                return;
                            } else {
                                if ($mt_salaire <= ceil($compte->getSolde())) {
                                    $compte->setSolde($compte->getSolde() - $mt_salaire);
                                    $cm_mapper->update($compte);
                                } else {
                                    $this->view->data = 'alloc_s';
                                    return;
                                }
                            }
                        } else {
                            $this->view->data = 'sal';
                            return;
                        }
                    }
                }

                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->data = $message;
                return;
            }
        }
    }

    public function ressourceAction() {
        $this->_helper->layout->disableLayout();
    }

    public function listallocAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('eu_operation.id_utilisateur = ?', $user->id_utilisateur)
                ->join('eu_acteurs_creneaux', 'eu_acteurs_creneaux.code_membre = eu_operation.code_membre')
                ->join('eu_type_acteur', 'eu_type_acteur.id_type_acteur = eu_acteurs_creneaux.id_type_acteur')
                ->where('type_op = ?', 'ara')
                ->order('date_op', 'desc');
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
            $date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $heure_op = new Zend_Date($row->heure_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                ucfirst($row->nom_acteur),
                ucfirst($row->lib_type_acteur),
                $row->code_produit,
                $row->montant_op,
                $date_op->toString('dd/mm/yyyy'),
                $heure_op->toString('hh:mm')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function demandeaccorderAction() {
        $this->_helper->layout->disableLayout();
    }

    public function listaccorderAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $num = $user->code_acteur;

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuActeurCreneau();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->where('code_creneau = ?', $num);
        $listact = $tabel->fetchAll($sel);
        $mb = array();
        $i = 0;
        foreach ($listact as $row) {
            $mb[$i] = $row->code_membre;
            $i++;
        }
        if (count($mb) != 0) {
            $tab = $mb;
        } else {
            $tab = array('0');
        }
        //Récupération des demandes des acteurs créneaux d'activités
        $select1 = $tabela->select();
        $select1->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.alloc_fil_inv = ?', 1)
                ->where('eu_smcipn.alloc_creneau_inv = ?', 1)
                ->where('eu_smcipn.code_membre in (?)', $tab);

        $select2 = $tabela->select();
        $select2->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.alloc_fil_sal = ?', 1)
                ->where('eu_smcipn.alloc_creneau_sal = ?', 1)
                ->where('eu_smcipn.code_membre in (?)', $tab);
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->union(array($select1, $select2));
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

    public function mesrecuAction() {
        $this->_helper->layout->disableLayout();
    }

    public function mesreculistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $num = $user->code_membre;
        //Récupération des demandes du créneau d'activités qui sont accordées
        $select1 = $tabela->select();
        $select1->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.alloc_fil_inv = ?', 1)
                ->where('eu_smcipn.code_membre =?', $num);
        $select2 = $tabela->select();
        $select2->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.alloc_fil_sal = ?', 1)
                ->where('eu_smcipn.code_membre =?', $num);
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->union(array($select1, $select2));
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

    public function gestionchangeAction() {
        $num_gesttion = $_GET['gestion'];
        $data = array();
        $mb_db = new Application_Model_DbTable_EuMembre();
        $mb_find = $mb_db->find($num_gesttion);
        if (count($mb_find) == 1) {
            $result = $mb_find->current();
            $data[0] = $result->nom_membre;
            $data[1] = $result->prenom_membre;
            $data[2] = $result->portable_membre;
        } else {
            $data[0] = '';
            $data[1] = '';
            $data[2] = '';
        }
        $this->view->data = $data;
    }

    public function newdomaineAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $lib_domaine = $_GET['lib_domaine'];
        $desc_domaine = $_GET['desc_domaine'];
        $mdo = new Application_Model_EuFiliereMapper();
        $do = new Application_Model_EuFiliere();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_op = clone $date;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Enregistrement dans la table domaine d'activité
            $do->setNom_filiere($lib_domaine);
            $do->setDescrip_filiere($desc_domaine);
            $do->setDate_creation($date_op->toString('yyyy-mm-dd'));
            $do->setId_utilisateur($user->id_utilisateur);
            $count = $mdo->findConuter() + 1;
            $do->setId_filiere($count);
            $mdo->save($do);
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
            $this->view->message = $message;
            $this->view->data = $message;
            return;
        }
    }

    public function domainesAction() {
        $gac = array();
        $tab = new Application_Model_DbTable_EuFiliere();
        $sel = $tab->select();
        $sel->order('nom_filiere', 'asc');
        $ngac = $tab->fetchAll($sel);
        $i = 0;
        foreach ($ngac as $value) {
            $gac[$i][1] = $value->id_filiere;
            $gac[$i][2] = ucfirst($value->nom_filiere);
            $i++;
        }
        $this->view->data = $gac;
    }

}

?>
