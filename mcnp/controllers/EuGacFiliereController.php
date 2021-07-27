<?php

class EuGacFiliereController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'gac' || $group == 'gacp' || $group == 'gacsu' || $group == 'gacse' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca' || $group == 'gacreg' || $group == 'gacco' || $group == 'gacpro') {
            $menu = "<li><a id=\"smcipngac\" href=\"#\">smcipn obtenues</a></li>" .
                    "<li><a href=\"/eu-gac-filiere/allocgacfil \">Allouer investissement</a></li>" .
                    "<li><a href=\"/eu-gac-filiere/allocgacfilsal \">Allouer salaire</a></li>" .
                    "<li><a id=\"ressf\" href=\"#\">Ressources allouées</a></li>" .
                    "<li><a id=\"alloc_gac\" href=\"#\">smcipn transmises</a></li>" .
                    "<li><a id=\"recu_gac\" href=\"#\">Mes smcipn reçues</a></li>";
        } elseif ($group == 'filiere' || $group == 'creneau' || $group == 'filiere_pbf' || $group == 'creneau_pbf') {
            $menu = "<li><a href=\" /eu-gac-filiere/new \">Nouveau</a></li>" .
                    "<li><a id=\"smcipngac\" href=\"#\">smcipn obtenues</a></li>" .
                    "<li><a href=\"/eu-gac-filiere/allocgacfil \">Allouer investissement</a></li>" .
                    "<li><a href=\"/eu-gac-filiere/allocgacfilsal \">Allouer salaire</a></li>" .
                    "<li><a id=\"ressf\" href=\"#\">Ressources allouées</a></li>" .
                    "<li><a id=\"alloc_gac\" href=\"#\">smcipn transmises</a></li>" .
                    "<li><a id=\"recu_gac\" href=\"#\">Mes smcipn reçues</a></li>";
        } elseif ($group == 'gac_pbf' || $group == 'gacsu_pbf' || $group == 'gacse_pbf' || $group == 'gacr_pbf' || $group == 'gacs_pbf' || $group == 'gaca_pbf') {
            $menu = "<li><a id=\"smcipngac\" href=\"#\">smcipn obtenues</a></li>" .
                    "<li><a href=\"/eu-gac-filiere/allocgacfil \">Allouer investissement</a></li>" .
                    "<li><a href=\"/eu-gac-filiere/allocgacfilsal \">Allouer salaire</a></li>" .
                    "<li><a id=\"ressf\" href=\"#\">Ressources allouées</a></li>" .
                    "<li><a id=\"alloc_gac\" href=\"#\">smcipn transmises</a></li>" .
                    "<li><a id=\"recu_gac\" href=\"#\">Mes smcipn reçues</a></li>";
        } elseif ($group == 'gacex' || $group == 'gacex_pbf' || $group == 'acnev') {
            $menu = "<li><a href=\"/eu-gac-filiere/new \">Nouveau</a></li>" .
                    "<li><a href=\"/eu-gac-filiere\">Liste gacs filières</a></li>";
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
            if ($group != 'gac' && $group != 'gacp' && $group != 'gacex' && $group != 'gacsu' && $group != 'gacse' && $group != 'gacr' && $group != 'gacs' && $group != 'gaca' && $group != 'gacreg' && $group != 'gac_pbf' && $group != 'gacco' && $group != 'gacpro' && $group != 'gacp_pbf' && $group != 'gacex_pbf' && $group != 'gacsu_pbf' && $group != 'gacse_pbf' && $group != 'gacr_pbf' && $group != 'gacs_pbf' && $group != 'gaca_pbf') {
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
        $sidx = $this->_request->getParam("sidx", 'code_gac_filiere');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuGacFiliere();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('f' => 'EU_GAC_fILIERE'), array('f.CODE_GAC_fILIERE', 'f.NOM_GAC_fILIERE', 'f.code_membre', "to_char((f.date_creation),'dd/mm/yyyy') date_creation"))
                ->join(array('g' => 'EU_gAC'), 'f.CODE_gAC = g.CODE_gAC', array('NOM_gAC'))
                ->join(array('m' => 'EU_mEmBRE'), 'm.CODE_mEmBRE = f.CODE_mEmBRE_GESTIONNAIRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE', 'PORTABLE_mEmBRE'))
                ->where('f.id_utilisateur = ?', $user->id_utilisateur);
        $gac_fil = $tabela->fetchAll($select);

        $count = count($gac_fil);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $gac_fil = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($gac_fil as $row) {
            $responce['rows'][$i]['id'] = $row->code_gac_filiere;
            $responce['rows'][$i]['cell'] = array(
                $row->code_gac_filiere,
                ucfirst($row->nom_gac_filiere),
                $row->code_membre,
                strtoupper($row->nom_membre) . ' ' . ucfirst($row->PREnom_membre),
                ucfirst($row->nom_gac),
                $row->date_creation
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function ressourceAction() {
        $this->_helper->layout->disableLayout();
    }

    public function listallocAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 500);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->from('eu_operation', array('*', "to_char((date_op),'dd/mm/yyyy') date_op", "to_char((heure_op),'hh:mm') heure_op"))
                ->where('eu_operation.id_utilisateur = ?', $user->id_utilisateur)
                ->join('eu_membre', 'eu_membre.code_membre = eu_operation.code_membre')
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
            $responce['rows'][$i]['id'] = $row->code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                ucfirst($row->raison_sociale),
                $row->code_produit,
                $row->montant_op,
                $row->date_op,
                $row->heure_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $request = $this->getRequest();
        $form = new Application_Form_EuGacFiliere();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $gm = new Application_Model_EuGacFiliereMapper();
                    $gac = new Application_Model_EuGacFiliere($form->getValues());
                    $gac->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $gac->setId_utilisateur($users->id_utilisateur);
                    $ugroupe = $users->code_groupe;
                    $type = '';
                    if ($ugroupe == 'gac_pbf' || $ugroupe == 'gacp_pbf' || $ugroupe == 'gacex_pbf' || $ugroupe == 'gacsu_pbf' || $ugroupe == 'gacse_pbf' || $ugroupe == 'gacr_pbf' || $ugroupe == 'gacs_pbf' || $ugroupe == 'gaca_pbf') {
                        $gac->setGroupe('pbf');
                        $type = 'pbf';
                    }
                    if ($ugroupe == 'gac' || $ugroupe == 'gacp' || $ugroupe == 'gacex' || $ugroupe == 'gacsu' || $ugroupe == 'gacse' || $ugroupe == 'gacr' || $ugroupe == 'gacs' || $ugroupe == 'gaca') {
                        $gac->setGroupe('gac');
                        $type = 'gac';
                    }
                    //Récup du code de la gac centrale
                    $code_gac = $users->code_acteur;
                    $gac->setCode_gac($code_gac);
                    //Formation du code de la gac filière à partir du code de la gac centrale
                    $code = $gm->getLastFiliereByGac($code_gac);
                    if ($code == null) {
                        $code_gacfil = $code_gac . 'gf' . '0001';
                    } else {
                        $num_ordre = substr($code, -4);
                        $num_ordre++;
                        $code_gacfil = $code_gac . 'gf' . str_pad($num_ordre, 4, 0, str_pad_left);
                    }
                    $gac->setCode_gac_filiere($code_gacfil);

                    $num = $code_gacfil;
                    $zone = $users->code_zone;
                    $nom = $this->_request->getPost("nom_gestion");
                    $prenom = $this->_request->getPost("prenom_gestion");
                    if ($this->_request->getPost("code_membre") == '') {
                        $num_membre = null;
                        $gac->setCode_membre($num_membre);
                        //Création de la gac filière
                        $gm->save($gac);
                        //Enregistrement dans la table eu_filiere_gac_filiere
                        $id_filiere = array();
                        $id_filiere = $this->_request->getPost("id_filiere");
                        $mfiliere = new Application_Model_EuFiliereGacFiliereMapper();
                        $filiere = new Application_Model_EuFiliereGacFiliere();
                        foreach ($id_filiere as $row) {
                            $filiere->setCode_gac_filiere($num);
                            $filiere->setId_filiere($row);
                            $mfiliere->save($filiere);
                        }
                        $db->commit();
                        return $this->_helper->redirector('newuser', 'eu-user', null, array('controller' => 'eu-user', 'action' => 'newuser', 'membre' => $num_membre, 'type' => $type, 'zone' => $zone, 'num' => $num, 'nom' => $nom, 'prenom' => $prenom));
                    } else {
                        $num_membre = $this->_request->getPost("code_membre");
                        $find_mb = $gm->findByMembre($num_membre);
                        if ($find_mb != false) {
                            $this->view->message = 'Ce membre ' . $num_membre . ' est déjà enregistré comme gac filière';
                            $this->view->form = $form;
                        } else {
                            $gac->setCode_membre($num_membre);
                            //Création de la gac filière
                            $gm->save($gac);
                            //Enregistrement dans la table eu_filiere_gac_filiere
                            $id_filiere = array();
                            $id_filiere = $this->_request->getPost("id_filiere");
                            $mfiliere = new Application_Model_EuFiliereGacFiliereMapper();
                            $filiere = new Application_Model_EuFiliereGacFiliere();
                            foreach ($id_filiere as $row) {
                                $filiere->setCode_gac_filiere($num);
                                $filiere->setId_filiere($row);
                                $mfiliere->save($filiere);
                            }
                            $db->commit();
                            return $this->_helper->redirector('newuser', 'eu-user', null, array('controller' => 'eu-user', 'action' => 'newuser', 'membre' => $num_membre, 'type' => $type, 'zone' => $zone, 'num' => $num, 'nom' => $nom, 'prenom' => $prenom));
                        }
                    }
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                    $this->view->message = $message;
                    $this->view->data = 'erreur';
                    $this->view->form = $form;
                    return;
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-gac-filiere',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function saveAction() {

        $fg = new Application_Model_EuGacFiliere();
        $mfg = new Application_Model_EuGacFiliereMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $mfg->find($this->getRequest()->getPost("num_gac_filiere"), $fg);
            $fg->setNom_gac_filiere($this->_request->getPost("nom_gac_filiere"));
            $fg->setFiliere($this->_request->getPost("filiere"));
            $fg->setMembre($this->_request->getPost("membre"));
            $fg->setNum_gestion1($this->_request->getPost("num_gestion"));
            $fg->setNom_gestion1($this->_request->getPost("nom_gestion"));
            $fg->setPrenom_gestion1($this->_request->getPost("prenom_gestion"));
            $fg->setTel_gestion1($this->_request->getPost("tel_gestion"));
            $fg->setCree_par($user->login);
            $fg->setDate_creation($date_id->toString('yyyy-mm-dd'));
            $mfg->update($fg);
        }
    }

    public function allocgacfilAction() {
        $form = new Application_Form_EuGacFiliereAlloc();
        $this->view->form = $form;
    }

    public function allocgacfilsalAction() {
        $form = new Application_Form_EuGacFiliereAllocSal();
        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuGacFiliere();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $code_gac_filiere = $this->getRequest()->code_gac_filiere;
                    //Mise à jour de la gac filière
                    $mapper = new Application_Model_EuGacFiliereMapper();
                    $gfil = new Application_Model_EuGacFiliere($form->getValues());
                    $gfil->setCode_gac_filiere($code_gac_filiere);
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $gfil->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $gfil->setId_utilisateur($user->id_utilisateur);
                    $ugroupe = $user->code_groupe;
                    if ($ugroupe == 'gac_pbf' || $ugroupe == 'gacp_pbf' || $ugroupe == 'gacse_pbf' || $ugroupe == 'gacr_pbf' || $ugroupe == 'gacs_pbf' || $ugroupe == 'gaca_pbf') {
                        $gfil->setGroupe('pbf');
                    }
                    if ($ugroupe == 'gac' || $ugroupe == 'gacp' || $ugroupe == 'gacse' || $ugroupe == 'gacr' || $ugroupe == 'gacs' || $ugroupe == 'gaca') {
                        $gfil->setGroupe('gac');
                    }
                    $gfil->setCode_gac($user->code_acteur);
                    if ($this->_request->getPost("code_membre") == '') {
                        $gfil->setCode_membre(null);
                        //Mise à jour de la gac filière
                        $mapper->update($gfil);
                        //Suppression des anciennes filières liées à la gac filière
                        $mfiliere = new Application_Model_EuFiliereGacFiliereMapper();
                        $filiere = new Application_Model_EuFiliereGacFiliere();
                        $find_filiere = $mfiliere->findByGacFiliere($code_gac_filiere);
                        if ($find_filiere !== false) {
                            foreach ($find_filiere as $row) {
                                $mfiliere->delete($code_gac_filiere, $row->id_filiere);
                            }
                        }
                        //Enregistrement des nouvelles filières
                        $id_filiere = array();
                        $id_filiere = $this->_request->getPost("id_filiere");
                        foreach ($id_filiere as $row) {
                            $filiere->setCode_gac_filiere($code_gac_filiere);
                            $filiere->setId_filiere($row);
                            $mfiliere->save($filiere);
                        }
                    } else {
                        $num_membre = $this->_request->getPost("code_membre");
                        $find_mb = $mapper->findByMembre($num_membre);
                        if ($find_mb != false) {
                            $this->view->message = 'Ce membre ' . $num_membre . ' est déjà enregistré comme gac filière';
                            $this->view->form = $form;
                            return;
                        } else {
                            $gfil->setCode_membre($num_membre);
                            //Mise à jour de la gac filière
                            $mapper->update($gfil);
                            //Suppression des anciennes filières liées à la gac filière
                            $mfiliere = new Application_Model_EuFiliereGacFiliereMapper();
                            $filiere = new Application_Model_EuFiliereGacFiliere();
                            $find_filiere = $mfiliere->findByGacFiliere($code_gac_filiere);
                            if ($find_filiere !== false) {
                                foreach ($find_filiere as $row) {
                                    $mfiliere->delete($code_gac_filiere, $row->id_filiere);
                                }
                            }
                            //Enregistrement des nouvelles filières
                            $id_filiere = array();
                            $id_filiere = $this->_request->getPost("id_filiere");
                            foreach ($id_filiere as $row) {
                                $filiere->setCode_gac_filiere($code_gac_filiere);
                                $filiere->setId_filiere($row);
                                $mfiliere->save($filiere);
                            }
                        }
                    }
                    $db->commit();
                    return $this->_helper->redirector('index');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        } else {
            $code_gac_fil = $request->gac_fil;
            $mapper = new Application_Model_EuGacFiliereMapper();
            $gfil = new Application_Model_EuGacFiliere();
            $mapper->find($code_gac_fil, $gfil);

            if ($gfil->getCode_gac_filiere() == $code_gac_fil) {
                //Récupération des filières liées à une gac filière
                $mfiliere = new Application_Model_EuFiliereGacFiliereMapper();
                //$filiere = new Application_Model_EuFiliereGacFiliere();
                $find_filiere = $mfiliere->findByGacFiliere($code_gac_fil);
                if ($find_filiere !== false) {
                    $id_filiere = array();
                    $i = 0;
                    foreach ($find_filiere as $row) {
                        $id_filiere[$i] = $row->id_filiere;
                        $i++;
                    }
                }
                //Récupération des informations du gestionnaire                    
                $mmember = new Application_Model_EuMembreMapper();
                $member = new Application_Model_EuMembre();
                $mmember->find($gfil->getCode_membre_gestionnaire(), $member);
                $data = array(
                    'code_gac_filiere' => $code_gac_fil,
                    'nom_gac_filiere' => $gfil->getNom_gac_filiere(),
                    'code_membre' => $gfil->getCode_membre(),
                    'id_filiere' => $id_filiere,
                    'code_membre_gestionnaire' => $gfil->getCode_membre_gestionnaire(),
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
                    'controller' => 'eu-gac-filiere',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
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
        $code_gac = $user->code_acteur;
        $select = $tabela->select();
        $select1 = $tabela->select();
        $select1->setIntegrityCheck(false)
                ->where('eu_smcipn.code_gac = ?', $code_gac)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.alloc_gac_inv = ?', 1);
        $select2 = $tabela->select();
        $select2->setIntegrityCheck(false)
                ->where('eu_smcipn.code_gac = ?', $code_gac)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.alloc_gac_sal = ?', 1)
                ->where('eu_smcipn.salaire_alloue != ?', 0);
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
                $row->salaire_alloue,
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

    public function smcipngacAction() {
        $this->_helper->layout->disableLayout();
    }

    public function smcipngac2Action() {
        //$this->_helper->layout->disableLayout();
    }

    public function smcipngaclistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();
        $group = $user->code_groupe;
        $num = $user->code_acteur;

        if ($group == 'gac' || $group == 'gacp' || $group == 'gacr' || $group == 'gacs' || $group == 'gaca') {
            //Affichage des demandes en attentes de validation et validées par les filières
            $select5 = $tabela->select();
            $select5->setIntegrityCheck(false)
                    ->where('eu_smcipn.etat_demande_inv = ?', 1)
                    ->where('eu_smcipn.valid_gac = ?', 1)
                    ->where('eu_smcipn.alloc_gac_inv = ?', 0)
                    ->where('eu_smcipn.code_gac = ?', $num);
            $select6 = $tabela->select();
            $select6->setIntegrityCheck(false)
                    ->where('eu_smcipn.etat_demande_sal = ?', 1)
                    ->where('eu_smcipn.valid_gac = ?', 1)
                    ->where('eu_smcipn.alloc_gac_sal = ?', 0)
                    ->where('eu_smcipn.etat_sal = ?', 1)
                    ->where('eu_smcipn.code_gac = ?', $num);
            $select->setIntegrityCheck(false)
                    ->union(array($select5, $select6));
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

    public function listsmcipnfilAction() {
        $code_membre = $_GET["code_membre"];
        $date_demande = $_GET["date_demande"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        //Affichage des demandes des acteurs créneaux
        $select = $tabela->select();
        if ($code_membre == '' and $date_demande == '') {
            
        } else if ($code_membre != '' and $date_demande == '') {
            $select->where('eu_smcipn.code_membre like ?', $code_membre);
        } else if ($code_membre == '' and $date_demande != '') {
            $date1 = explode("/", $date_demande);
            $datedem = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('eu_smcipn.date_demande like ?', $datedem);
        }
        $select->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.alloc_gac_inv = ?', 0)
                ->where('eu_smcipn.code_gac like ?', $user->code_acteur)
                ->where('eu_smcipn.montant_investis != ?', 0)
                ->where('eu_smcipn.allouer_i != ?', 1)
                ->order('eu_smcipn.date_demande', 'asc');
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
        $nom_fil = '';
        foreach ($smcipn as $row) {
            $mfil = new Application_Model_EuGacFiliereMapper();
            $fil = new Application_Model_EuGacFiliere();
            $mcre = new Application_Model_EuCreneauMapper();
            $cre = new Application_Model_EuCreneau();
            $mact = new Application_Model_EuActeurCreneauMapper();
            $find_act = $mact->findActeurByMembre($row->code_membre);
            if ($find_act != null) {
                $code_creneau = $find_act->getCode_creneau();
                $code_gac_filiere = $find_act->getCode_gac_filiere();
                if ($code_gac_filiere != '') {
                    //Récup libellé gac filière
                    $find_fil = $mfil->find($code_gac_filiere, $fil);
                    if ($find_fil != false) {
                        $nom_fil = $fil->getNom_gac_filiere();
                    }
                }
                if ($code_creneau != '') {
                    //Récup code gac filière
                    $find_cre = $mcre->find($code_creneau, $cre);
                    if ($find_cre != false) {
                        $code_gac_fil = $cre->getCode_gac_filiere();
                        //Récup libellé gac filière
                        $find_fil = $mfil->find($code_gac_fil, $fil);
                        if ($find_fil != false) {
                            $nom_fil = $fil->getNom_gac_filiere();
                        }
                    }
                }
            }
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
                ucfirst($nom_fil),
                $date_dem->toString('dd/mm/yyyy'),
                $row->montant_salaire,
                $row->montant_investis,
                $total,
            );
            $i++;
        }
        $responce['userdata']['date_demand'] = 'Totaux:';
        $responce['userdata']['mt_salaire'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $responce['userdata']['total'] = $tot;
        $this->view->data = $responce;
    }

    public function listsmcipnfilsalAction() {
        $code_membre = $_GET["code_membre"];
        $date_demande = $_GET["date_demande"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        //Affichage des demandes des acteurs créneaux
        $select = $tabela->select();
        if ($code_membre == '' and $date_demande == '') {
            
        } else if ($code_membre != '' and $date_demande == '') {
            $select->where('eu_smcipn.code_membre like ?', $code_membre);
        } else if ($code_membre == '' and $date_demande != '') {
            $date1 = explode("/", $date_demande);
            $datedem = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('eu_smcipn.date_demande like ?', $datedem);
        }
        $select->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.alloc_gac_sal = ?', 0)
                ->where('eu_smcipn.code_gac  like ?', $user->code_acteur)
                ->where('eu_smcipn.etat_sal != ?', 0)
                ->where('eu_smcipn.allouer_s != ?', 1)
                ->order('eu_smcipn.date_demande', 'asc');
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
        $nom_fil = '';
        foreach ($smcipn as $row) {
            $mfil = new Application_Model_EuGacFiliereMapper();
            $fil = new Application_Model_EuGacFiliere();
            $mcre = new Application_Model_EuCreneauMapper();
            $cre = new Application_Model_EuCreneau();
            $mact = new Application_Model_EuActeurCreneauMapper();
            $find_act = $mact->findActeurByMembre($row->code_membre);
            if ($find_act != null) {
                $code_creneau = $find_act->getCode_creneau();
                $code_gac_filiere = $find_act->getCode_gac_filiere();
                if ($code_gac_filiere != '') {
                    //Récup libellé gac filière
                    $find_fil = $mfil->find($code_gac_filiere, $fil);
                    if ($find_fil != false) {
                        $nom_fil = $fil->getNom_gac_filiere();
                    }
                }
                if ($code_creneau != '') {
                    //Récup code gac filière
                    $find_cre = $mcre->find($code_creneau, $cre);
                    if ($find_cre != false) {
                        $code_gac_fil = $cre->getCode_gac_filiere();
                        //Récup libellé gac filière
                        $find_fil = $mfil->find($code_gac_fil, $fil);
                        if ($find_fil != false) {
                            $nom_fil = $fil->getNom_gac_filiere();
                        }
                    }
                }
            }
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
                ucfirst($nom_fil),
                $date_dem->toString('dd/mm/yyyy'),
                $row->sal_transmis,
                $row->montant_investis,
                $total,
            );
            $i++;
        }
        $responce['userdata']['date_demand'] = 'Totaux:';
        $responce['userdata']['mt_salaire'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $responce['userdata']['total'] = $tot;
        $this->view->data = $responce;
    }

    public function allouerAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $smc = new Application_Model_EuSmcipnMapper();
        $sm = new Application_Model_EuSmcipn();
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $gcsc = new Application_Model_EuGcsc();
        $m_gcsc = new Application_Model_EuGcscMapper();
        $membre = new Application_Model_EuMembre();
        $membre_mapper = new Application_Model_EuMembreMapper();
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin;
                foreach ($selection as $sel) {
                    //Création du compte tsci du bénéficiaire de la smcipn
                    $cgm = New Application_Model_EuCompteMapper();
                    $cg = new Application_Model_EuCompte();
                    $num_gac = $user->code_membre;
                    $code_cat = 'Ir';
                    $num_compteg = 'nr-' . $code_cat . '-' . $num_gac;
                    $cgm->find($num_compteg, $cg);
                    if (count($cg) == 1) {
                        $mt_i = $cg->getSolde();
                        $smc->find($sel, $sm);
                        if ($mt_i >= $sm->getMontant_investis()) {
                            //Mise à jour de la table smcipn
                            $sm->setCode_smcipn($sm->getCode_smcipn());
                            $sm->setAlloc_gac_inv(1);
                            $sm->setAllouer_i(1);
                            $sm->setInvestis_alloue($sm->getInvestis_alloue() + $sm->getMontant_investis());
                            $smc->update($sm);
                            $code_smcipn = $sm->getCode_smcipn();
                            $compte_credit = new Application_Model_EuCompteCredit();
                            $cc_mapper = new Application_Model_EuCompteCreditMapper();
                            $code_membre = $sm->getCode_membre();
                            $cat_compte = 'tsci';
                            $compte_source = 'nr-Ir-' . $num_gac;
                            $num_comptes = 'nr-' . $cat_compte . '-' . $code_membre;
                            $result = $cm_mapper->find($num_comptes, $compte);
                            if ($result == false) {
                                $compte->setCode_membre($code_membre)
                                        ->setCode_cat($cat_compte)
                                        ->setDesactiver(0)
                                        ->setCode_type_compte('nr')
                                        ->setSolde($sm->getMontant_investis())
                                        ->setSource($compte_source)
                                        ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                        ->setCode_compte($num_comptes)
                                        ->setLib_compte($cat_compte);
                                $cm_mapper->save($compte);
                            } else {
                                $compte->setSolde($compte->getSolde() + $sm->getMontant_investis());
                                $cm_mapper->update($compte);
                            }
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
                                $mt_rembourse = ceil(($sm->getMontant_investis() * $prk) / $pck);
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
                                $gcsc->setCode_membre($code_membre);
                                $gcsc->setDebit($mt_rembourse);
                                $gcsc->setCredit(0);
                                $gcsc->setSolde($mt_rembourse);
                                $gcsc->setCode_smcipn($code_smcipn);
                                $gcsc->setCode_smcipnp(null);
                                $m_gcsc->save($gcsc);
                            }
                            //Ajout dans la table opération
                            $alloc = new Application_Model_EuOperation();
                            $alloc->setDate_op($date_deb->toString('yyyy-mm-dd'));
                            $alloc->setHeure_op($date_deb->toString('hh:mm'));
                            $alloc->setMontant_op($sm->getMontant_investis());
                            $alloc->setCode_membre($code_membre);
                            $alloc->setCode_produit($code_cat);
                            $alloc->setId_utilisateur($user->id_utilisateur);
                            $alloc->setLib_op('Allocation de ressources à un acteur d\'un créneau');
                            $alloc->setCode_cat('i');
                            $alloc->setType_op('ara');
                            $mapper = new Application_Model_EuOperationMapper();
                            $mapper->save($alloc);
                            $compteur = 0;
                            $mapper = new Application_Model_EuOperationMapper();
                            $compteur = $mapper->findConuter();
                            //Enregistrement des détails des subventions dans la table compte crédit
                            $date_fin->addDay(ceil($sm->getDvm_demande() * 30));
                            $compte_credit->setCode_membre($code_membre)
                                    ->setCode_produit('Ir')
                                    ->setMontant_place($sm->getMontant_investis())
                                    ->setDatedeb($date_deb->toString('yyyy-mm-dd'))
                                    ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                    ->setDate_octroi($date_deb->toString('yyyy-mm-dd'))
                                    ->setSource($code_membre . $date_deb->toString('yyyyMMddHHmmss'))
                                    ->setCode_compte($num_comptes)
                                    ->setMontant_credit($sm->getMontant_investis())
                                    ->setRenouveller('n')
                                    ->setCompte_source($code_smcipn)
                                    ->setId_operation($compteur)
                                    ->setKrr('n')
                                    ->setBnp(0)
                                    ->setDomicilier(0)
                                    ->setCode_bnp(null)
                                    ->setAffecter(0)
                                    ->setPrk(0)
                                    ->setCode_type_credit('');
                            $cc_mapper->save($compte_credit);
                            //Mise à jour du compte de la gac 
                            $res = $cm_mapper->find($num_compteg, $compte);
                            if ($res == false) {
                                $this->view->data = 'compte_gac';
                                return;
                            } else {
                                if ($sm->getMontant_investis() <= $compte->getSolde()) {
                                    $compte->setSolde($compte->getSolde() - $sm->getMontant_investis());
                                    $cm_mapper->update($compte);
                                } else {
                                    $this->view->data = 'alloc_i';
                                    return;
                                }
                            }
                            //Envoie de message au bénéficiaire de la subvention
                            $resp = $membre_mapper->find($code_membre, $membre);
                            if ($resp) {
                                Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'une subvention de " . $sm->getMontant_investis() . " sur votre compte " . $num_comptes);
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
                return;
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
    }

    public function allouersalAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $smc = new Application_Model_EuSmcipnMapper();
        $sm = new Application_Model_EuSmcipn();
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $gcsc = new Application_Model_EuGcsc();
        $m_gcsc = new Application_Model_EuGcscMapper();
        $membre = new Application_Model_EuMembre();
        $membre_mapper = new Application_Model_EuMembreMapper();
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $mt_salaire = 0;
                $sal_alloue = 0;
                $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin;
                foreach ($selection as $sel) {
                    //Création des comptes de subvention du béneficiaire de la smcipn
                    $cgm = New Application_Model_EuCompteMapper();
                    $cg = new Application_Model_EuCompte();
                    $num_gac = $user->code_membre;
                    $smc->find($sel, $sm);
                    $type_alloc = $sm->getType_alloc();
                    if ($type_alloc == 'periodique') {
                        $sm->setAlloc_gac_sal(0);
                    } else {
                        $sm->setAlloc_gac_sal(1);
                    }
                    $sal_alloue = $sm->getSal_transmis();
                    $mt_salaire = $sal_alloue;
                    $sm->setEtat_sal(2);
                    //Mise à jour de la table smcipn
                    $smc->update($sm);
                    //####Traitement du salaire de la smcipn####  
                    $code_membre = $sm->getCode_membre();
                    if ($mt_salaire > 0) {
                        $code_cat = 'CNCSr';
                        $num_compteg = 'nr-' . $code_cat . '-' . $num_gac;
                        $cgm->find($num_compteg, $cg);
                        if (count($cg) == 1) {
                            $mt_s = $cg->getSolde();
                            if ($mt_s >= $mt_salaire) {
                                //Ajout dans la table opération
                                $alloc = new Application_Model_EuOperation();
                                $alloc->setDate_op($date_deb->toString('yyyy-mm-dd'));
                                $alloc->setHeure_op($date_deb->toString('hh:mm'));
                                $alloc->setMontant_op($mt_salaire);
                                $alloc->setCode_membre($code_membre);
                                $alloc->setCode_produit($code_cat);
                                $alloc->setId_utilisateur($user->id_utilisateur);
                                $alloc->setLib_op('Allocation de ressources à un acteur d\'un créneau');
                                $alloc->setCode_cat('cncs');
                                $alloc->setType_op('ara');
                                $mapper = new Application_Model_EuOperationMapper();
                                $mapper->save($alloc);

                                //Mise à jour du compte de la gac 
                                $res = $cm_mapper->find($num_compteg, $compte);
                                if ($res == false) {
                                    $this->view->data = 'compte_gacs';
                                    return;
                                } else {
                                    if ($mt_salaire <= $compte->getSolde()) {
                                        $compte->setSolde($compte->getSolde() - $mt_salaire);
                                        $cm_mapper->update($compte);
                                    } else {
                                        $this->view->data = 'alloc_s';
                                        return;
                                    }
                                }
                                $code_smcipn = $sm->getCode_smcipn();
                                //$num_source = $user->code_membre;
                                $compte_credit = new Application_Model_EuCompteCredit();
                                $cc_mapper = new Application_Model_EuCompteCreditMapper();
                                //Création du compte tpn du bénéficiaire de la smcipn
                                $cat_compte = 'tpn';
                                //$compte_source = 'nr-CNCSr-' . $num_source;
                                $num_comptes = 'nr-' . $cat_compte . '-' . $code_membre;
                                $result = $cm_mapper->find($num_comptes, $compte);
                                if ($result == false) {
                                    $compte->setCode_membre($code_membre)
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
                                    $compte_credit->setCode_membre($code_membre)
                                            ->setCode_produit('CNCSr')
                                            ->setMontant_place($sal_alloue)
                                            ->setDatedeb($date_deb->toString('yyyy-mm-dd'))
                                            ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                            ->setDate_octroi($date_deb->toString('yyyy-mm-dd'))
                                            ->setSource($code_membre . $date_deb->toString('yyyyMMddHHmmss'))
                                            ->setCode_compte($num_comptes)
                                            ->setMontant_credit($sal_alloue)
                                            ->setRenouveller('n')
                                            ->setCompte_source($code_smcipn)
                                            ->setKrr('n')
                                            ->setBnp(0)
                                            ->setDomicilier(0)
                                            ->setCode_bnp(null)
                                            ->setAffecter(0)
                                            ->setPrk(0)
                                            ->setCode_type_credit('');
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
                                            ->setAffecter($result->getAffecter())
                                            ->setPrk($result->getPrk())
                                            ->setCode_type_credit($result->getCode_type_credit());
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
                                        $gcsc->setCode_membre($code_membre);
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
                                //Envoie de message au bénéficiaire de la subvention
                                $resp = $membre_mapper->find($code_membre, $membre);
                                if ($resp) {
                                    Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'une subvention de " . $sm->getMontant_investis() . " sur votre compte " . $num_comptes);
                                }
                            } else {
                                $this->view->data = 'sal';
                                return;
                            }
                        }
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                return;
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
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
        //Récupération des demandes de la gac filière qui sont accordées
        $select1 = $tabela->select();
        $select1->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.code_membre =?', $num);
        $select2 = $tabela->select();
        $select2->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
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
            $totsal+=$row->sal_transmis;
            $totinves+=$row->montant_investis;
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $heure_dem = new Zend_Date($row->heure_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->salaire_alloue,
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

    public function idfiliereAction() {
        $fil = array();
        $tab = new Application_Model_DbTable_EuFiliere();
        $sel = $tab->select();
        $idfil = $tab->fetchAll($sel);
        $i = 0;
        foreach ($idfil as $value) {
            $fil[$i][1] = $value->id_filiere;
            $fil[$i][2] = ucfirst($value->nom_filiere);
            $i++;
        }
        $this->view->data = $fil;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);

        $morale_db = new Application_Model_DbTable_EuMembreMorale();
        $morale_find = $morale_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->PREnom_membre);
        } elseif (count($morale_find) == 1) {
            $data = strtoupper($result->raison_sociale);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function changemoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

}

?>
