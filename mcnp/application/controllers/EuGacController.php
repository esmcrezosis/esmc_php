<?php

class EuGacController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'dg') {
            $menu = "<li><a href=\" /eu-gac/new \">Nouveau</a></li>" .
                    "<li><a id=\"demgene\" href=\"#\">Demandes smcipn</a></li>" .
                    "<li><a href=\"/eu-gac/allocgac \">Allouer investissement</a></li>" .
                    "<li><a href=\"/eu-gac/allocgacsal \">Allouer salaire</a></li>" .
                    "<li><a id=\"ress\" href=\"#\">Ressources allouées</a></li>" .
                    "<li><a id=\"demvalid\" href=\"#\">smcipn accordées</a></li>" .
                    "<li><a id=\"smcipnpgene\" href=\"#\">Demandes smcipnp</a></li>" .
                    "<li><a id=\"smcipnpvalid\" href=\"#\">smcipnp accordées</a></li>";
        } else {
            $menu = "<li><a href=\" /eu-gac/new \">Nouveau</a></li>";
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
            if ($group != 'cm' && $group != 'dg' && $group != 'gac' && $group != 'gacp' && $group != 'gacex' && $group != 'gacsu' && $group != 'gacse' && $group != 'gacr' && $group != 'gacs' && $group != 'gac_pbf' && $group != 'gacp_pbf' && $group != 'gacex_pbf' && $group != 'gacsu_pbf' && $group != 'gacse_pbf' && $group != 'gacr_pbf' && $group != 'gacs_pbf') {
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
        $sidx = $this->_request->getParam("sidx", 'code_gac');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_groupe = $user->code_groupe;
        $tabela = new Application_Model_DbTable_EuGac();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('g' => 'EU_gAC'), array('CODE_gAC', 'NOM_gAC', 'code_membre', 'date_creation', 'code_zone', "to_char((g.date_creation),'dd/mm/yyyy') date_creation"))
                ->joinLeft(array('m' => 'EU_mEmBRE'), 'g.CODE_mEmBRE_gESTIONNAIRE = m.CODE_mEmBRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE', 'PORTABLE_mEmBRE'))
				;
        if ($code_groupe != 'agregat') {
            $select->where('g.id_utilisateur = ?', $user->id_utilisateur);
        }
        $gacs = $tabela->fetchAll($select);
        $count = count($gacs);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $gacs = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($gacs as $row) {
            $responce['rows'][$i]['id'] = $row->code_gac;
            $responce['rows'][$i]['cell'] = array(
                $row->code_gac,
                $row->nom_gac,
                $row->code_membre,
                $row->code_zone,
                strtoupper($row->nom_membre) . ' ' . ucfirst($row->PREnom_membre),
                $row->portable_membre,
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
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('eu_operation.id_utilisateur = ?', $user->id_utilisateur)
                ->join('eu_gac', 'eu_gac.code_membre = eu_operation.code_membre')
                ->where('type_op = ?', 'arg')
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
            $responce['rows'][$i]['id'] = $row->code_membre . $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                ucfirst($row->nom_gac),
                $row->code_produit,
                $row->montant_op,
                $date_op->toString('dd/mm/yyyy'),
                $heure_op->toString('hh:mm')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $request = $this->getRequest();
        $form = new Application_Form_EuGac();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
           if ($form->isValid($request->getPost())) {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_creation = clone $date_id;
                $gm = new Application_Model_EuGacMapper();
                $gac = new Application_Model_EuGac($form->getValues());
                $gac->setId_utilisateur($users->id_utilisateur);
                //Formation du code de la gac à partir du code de la zone
                $code_type = $this->_request->getPost("code_type_gac");
                if ($code_type == 'gac_zone') {
                    $code_zone = $this->_request->getPost("code_zone");
                } else if ($code_type == 'gac_pays') {
                    $code_zon = $this->_request->getPost("code_zone");
                    $tabela = new Application_Model_DbTable_EuPays();
                    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                    $select->setIntegrityCheck(false)
                            ->where('eu_pays.id_pays = ?', $code_zon)
                            ->join('eu_zone', 'eu_zone.code_zone = eu_pays.code_zone');
                    $result = $tabela->fetchAll($select);
                    foreach ($result as $p) {
                        $data = $p->code_zone;
                    }
                    $code_zone = $data;
                } else if ($code_type == 'gac_section') {
                    $code_zon = $this->_request->getPost("code_zone");
                    $tabela = new Application_Model_DbTable_EuSection();
                    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                    $select->setIntegrityCheck(false)
                            ->where('eu_section.id_section = ?', $code_zon)
                            ->join('eu_pays', 'eu_pays.id_pays = eu_section.id_pays')
                            ->join('eu_zone', 'eu_zone.code_zone = eu_pays.code_zone');
                    $result = $tabela->fetchAll($select);
                    foreach ($result as $p) {
                        $data = $p->code_zone;
                    }
                    $code_zone = $data;
                } else if ($code_type == 'gac_region') {
                    $code_zon = $this->_request->getPost("code_zone");
                    $tabela = new Application_Model_DbTable_EuRegion();
                    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                    $select->setIntegrityCheck(false)
                            ->where('eu_region.id_region = ?', $code_zon)
                            ->join('eu_pays', 'eu_pays.id_pays = eu_region.id_pays')
                            ->join('eu_zone', 'eu_zone.code_zone = eu_pays.code_zone');
                    $result = $tabela->fetchAll($select);
                    foreach ($result as $p) {
                        $data = $p->code_zone;
                    }
                    $code_zone = $data;
                } else if ($code_type == 'gac_secteur') {
                    $code_zon = $this->_request->getPost("code_zone");
                    $msect = new Application_Model_EuSecteurMapper();
                    $sect = new Application_Model_EuSecteur();
                    $msect->find($code_zon, $sect);
                    $region = $sect->getId_region();
                    $pays = $sect->getId_pays();
                    $tabela = new Application_Model_DbTable_EuSecteur();
                    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                    if ($region != null) {
                        $select->setIntegrityCheck(false)
                                ->where('eu_secteur.code_secteur = ?', $code_zon)
                                ->join('eu_region', 'eu_region.id_region = eu_secteur.id_region')
                                ->join('eu_pays', 'eu_pays.id_pays = eu_region.id_pays')
                                ->join('eu_zone', 'eu_zone.code_zone = eu_pays.code_zone');
                    }
                    if ($pays != null) {
                        $select->setIntegrityCheck(false)
                                ->where('eu_secteur.code_secteur = ?', $code_zon)
                                ->join('eu_pays', 'eu_pays.id_pays = eu_secteur.id_pays')
                                ->join('eu_zone', 'eu_zone.code_zone = eu_pays.code_zone');
                    }
                    $result = $tabela->fetchAll($select);
                    foreach ($result as $p) {
                        $data = $p->code_zone;
                    }
                    $code_zone = $data;
                } else if ($code_type == 'gac_agence') {
                    $code_zon = $this->_request->getPost("code_zone");
                    $mag = new Application_Model_EuAgenceMapper();
                    $ag = new Application_Model_EuAgence();
                    $mag->find($code_zon, $ag);
                    $code_sect = $ag->getCode_secteur();
                    $msect = new Application_Model_EuSecteurMapper();
                    $sect = new Application_Model_EuSecteur();
                    $msect->find($code_sect, $sect);
                    $region = $sect->getId_region();
                    $pays = $sect->getId_pays();
                    $tabela = new Application_Model_DbTable_EuAgence();
                    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                    if ($region != null) {
                        $select->setIntegrityCheck(false)
                                ->where('eu_agence.code_agence = ?', $code_zon)
                                ->join('eu_secteur', 'eu_secteur.code_secteur = eu_agence.code_secteur')
                                ->join('eu_region', 'eu_region.id_region = eu_secteur.id_region')
                                ->join('eu_pays', 'eu_pays.id_pays = eu_region.id_pays')
                                ->join('eu_zone', 'eu_zone.code_zone = eu_pays.code_zone');
                    }
                    if ($pays != null) {
                        $select->setIntegrityCheck(false)
                                ->where('eu_agence.code_agence = ?', $code_zon)
                                ->join('eu_secteur', 'eu_secteur.code_secteur = eu_agence.code_secteur')
                                ->join('eu_pays', 'eu_pays.id_pays = eu_secteur.id_pays')
                                ->join('eu_zone', 'eu_zone.code_zone = eu_pays.code_zone');
                    }
                    $result = $tabela->fetchAll($select);
                    foreach ($result as $p) {
                        $data = $p->code_zone;
                    }
                    $code_zone = $data;
                } else if ($code_type == 'gac_source' || $code_type == 'gac_detentrice' || $code_type == 'gac_surveillance' || $code_type == 'gac_executante' || $code_type == 'gac_reglement' || $code_type == 'gac_controle' || $code_type == 'gac_protection') {
                    $code_zone = $users->code_zone;
                    $gac->setCode_zone($code_zone);
                }
                $code = $gm->getLastGacByZone($code_zone);
                if ($code == null) {
                    $code_gac = 'g' . $code_zone . '0001';
                } else {
                    $num_ordre = substr($code, -4);
                    $num_ordre++;
                    $code_gac = 'g' . $code_zone . str_pad($num_ordre, 4, 0, str_pad_left);
                }
                //$type = $this->_request->getPost("groupe");
                $type = 'gac';
                $gac->setCode_gac($code_gac);
                $gac->setZone($code_zone);
                $gac->setCode_gac_create($users->code_acteur);
                $gac->setCode_gac_chaine($users->code_acteur);
                $gac->setGroupe($type);
                $code = $code_gac;
                $zone = $code_zone;
                $num_membre = $this->_request->getPost("code_membre");
                $nom = $this->_request->getPost("nom_gestion");
                $prenom = $this->_request->getPost("prenom_gestion");
                $code_type = $this->_request->getPost("code_type_gac");
                //Vérification du type de contrat de la gac
                $mcontra = new Application_Model_EuContratMapper();
                $find_contra = $mcontra->findByMembre($num_membre);
                if ($find_contra != false) {
                    $id_type_contra = $find_contra->getId_type_contrat();
                    $mtypect = new Application_Model_EuTypeContratMapper();
                    $typect = new Application_Model_EuTypeContrat();
                    $mtypect->find($id_type_contra, $typect);
                    $type_contra = $typect->getLibelle_type_contrat();
                    if ($type_contra != 'centrale') {
                        $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat de gac centrale';
                        $this->view->form = $form;
                        return;
                    } else {
                        //Vérification du code membre de la gac centrale
                        $find_mb = $gm->findByMembre($num_membre);
                        if ($find_mb != false) {
                            $this->view->message = 'Ce membre ' . $num_membre . ' est déjà enregistré comme gac centrale';
                            $this->view->form = $form;
                        } else {
                            //Vérification de l'existence des gac pays surveillance et exploitante 
                            $find_gacdiv = $gm->findByGacAndDiv($users->code_acteur, $code_type);
                            if ($find_gacdiv != false) {
                                if ($code_type == 'gac_surveillance') {
                                    $this->view->message = 'La gac surveillance est déjà créée';
                                    $this->view->form = $form;
                                } else if ($code_type == 'gac_source') {
                                    $this->view->message = 'La gac source est déjà créée';
                                    $this->view->form = $form;
                                } else if ($code_type == 'gac_detentrice') {
                                    $this->view->message = 'La gac detentrice est déjà créée';
                                    $this->view->form = $form;
                                } else if ($code_type == 'gac_executante') {
                                    $this->view->message = 'La gac exécutante est déjà créée';
                                    $this->view->form = $form;
                                } else if ($code_type == 'gac_reglement') {//Vérification de l'existence des gac règlementation, contrôle et protection
                                    $this->view->message = 'La gac règlementation est déjà créée';
                                    $this->view->form = $form;
                                } else if ($code_type == 'gac_controle') {
                                    $this->view->message = 'La gac contrôle est déjà créée';
                                    $this->view->form = $form;
                                } else if ($code_type == 'gac_protection') {
                                    $this->view->message = 'La gac protection est déjà créée';
                                    $this->view->form = $form;
                                }
                            } else {
                                //Mise à jour de la table eu_agence
                                $code_agence = array();
                                $code_agence = $this->_request->getPost("code_agence");
                                foreach ($code_agence as $row) {
                                    $magence = new Application_Model_EuAgenceMapper();
                                    $agence = new Application_Model_EuAgence();
                                    $find_agence = $magence->find($row, $agence);
                                    if ($find_agence !== false) {
                                        $agence->setCode_gac_agence($code_gac);
                                        $magence->update($agence);
                                    }
                                }
                                //Création de la gac centrale
                                $gac->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                                $gm->save($gac);
                                //Enregistrement dans la table eu_acteur
                                $t_acteur = new Application_Model_DbTable_EuActeur();
                                $c_acteur = new Application_Model_EuActeur();
                                $count = $c_acteur->findConuter() + 1;
                                $c_acteur->setId_acteur($count)
                                        ->setCode_acteur($code)
                                        ->setCode_membre($num_membre)
                                        ->setType_acteur($code_type)
                                        ->setId_utilisateur($users->id_utilisateur)
                                        ->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                                if ($code_type == 'gac_zone' || $code_type == 'gac_section' || $code_type == 'gac_region' || $code_type == 'gac_secteur' || $code_type == 'gac_agence') {
                                    $c_acteur->setCode_activite('sur');
                                } elseif ($code_type == 'gac_pays') {
                                    $c_acteur->setCode_activite('dbms');
                                } elseif ($code_type == 'gac_executante') {
                                    $c_acteur->setCode_activite('exe');
                                } elseif ($code_type == 'gac_surveillance' || $code_type == 'gac_reglement' || $code_type == 'gac_controle' || $code_type == 'gac_protection') {
                                    $c_acteur->setCode_activite('sur');
                                }
                                $t_acteur->insert($c_acteur->toArray());
                                return $this->_helper->redirector('gacuser', 'eu-user', null, array('controller' => 'eu-user', 'action' => 'gacuser', 'membre' => $num_membre, 'type' => $type, 'zone' => $zone, 'num' => $code, 'nom' => $nom, 'prenom' => $prenom, 'code_type' => $code_type));
                            }
                        }
                    }
                } else {
                    $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose d\'aucun contrat';
                    $this->view->form = $form;
                    return;
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-gac',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function saveAction() {
        $g = new Application_Model_EuGac();
        $mg = new Application_Model_EuGacMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $mg->find($this->getRequest()->getPost("num_gac"), $g);
            $g->setNom_gac($this->_request->getPost("nom_gac"));
            $g->setZone($this->_request->getPost("zone"));
            $g->setMembre($this->_request->getPost("membre"));
            $g->setCree_par($user->login);
            $g->setDate_creation($date_id->toString('yyyy-mm-dd'));
            $mg->update($g);
        }
    }

    public function allocgacAction() {
        $form = new Application_Form_EuGacAlloc();
        $this->view->form = $form;
    }

    public function allocgacsalAction() {
        $form = new Application_Form_EuGacAllocSal();
        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuGac();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $gac = new Application_Model_EuGac($form->getValues());
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_creation = clone $date_id;
                $gac->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                $gac->setId_utilisateur($user->id_utilisateur);
                //Vérification du type de contrat de la gac
                $mcontra = new Application_Model_EuContratMapper();
                $num_membre = $this->getRequest()->code_membre;
                $code_type = $this->getRequest()->code_type_gac;
                $find_contra = $mcontra->findByMembre($num_membre);
                if ($find_contra != false) {
                    $id_type_contra = $find_contra->getId_type_contrat();
                    $mtypect = new Application_Model_EuTypeContratMapper();
                    $typect = new Application_Model_EuTypeContrat();
                    $mtypect->find($id_type_contra, $typect);
                    $type_contra = $typect->getLibelle_type_contrat();
                    if ($type_contra != 'centrale') {
                        $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat de gac centrale';
                        $this->view->form = $form;
                        return;
                    } else {
                        $code_gac = $this->getRequest()->code_gac;
                        $mapper = new Application_Model_EuGacMapper();
                        $gac1 = new Application_Model_EuGac();
                        $mapper->find($code_gac, $gac1);
                        $gac->setGroupe($gac1->getGroupe());
                        $gac->setCode_zone($gac1->getCode_zone());
                        $gac->setCode_gac_create($gac1->getCode_gac_create());
                        $gac->setCode_gac_chaine($gac1->getCode_gac_chaine());
                        //Vérification de l'existence des gac pays surveillance et exploitante 
                        $find_gacdiv = $mapper->findByGacAndDiv($user->code_acteur, $code_type);
                        if (count($find_gacdiv) > 1) {
                            if ($code_type == 'gac_surveillance') {
                                $this->view->message = 'La gac surveillance est déjà créée';
                                $this->view->form = $form;
                            } else if ($code_type == 'gac_source') {
                                $this->view->message = 'La gac source est déjà créée';
                                $this->view->form = $form;
                            } else if ($code_type == 'gac_detentrice') {
                                $this->view->message = 'La gac detentrice est déjà créée';
                                $this->view->form = $form;
                            } else if ($code_type == 'gac_executante') {
                                $this->view->message = 'La gac exécutante est déjà créée';
                                $this->view->form = $form;
                            } else if ($code_type == 'gac_reglement') {//Vérification de l'existence des gac règlementation, contrôle et protection
                                $this->view->message = 'La gac règlementation est déjà créée';
                                $this->view->form = $form;
                            } else if ($code_type == 'gac_controle') {
                                $this->view->message = 'La gac contrôle est déjà créée';
                                $this->view->form = $form;
                            } else if ($code_type == 'gac_protection') {
                                $this->view->message = 'La gac protection est déjà créée';
                                $this->view->form = $form;
                            }
                        } else {
                            //Mise à jour de la gac centrale
                            $mapper = new Application_Model_EuGacMapper();
                            $mapper->update($gac);
                            //Mise à jour de la table eu_agence
                            $magence = new Application_Model_EuAgenceMapper();
                            $agence = new Application_Model_EuAgence();
                            $find_gac = $magence->findByGac($code_gac);
                            if ($find_gac !== false) {
                                foreach ($find_gac as $row) {
                                    $find_agence = $magence->find($row->code_agence, $agence);
                                    if ($find_agence !== false) {
                                        $agence->setCode_gac_agence(null);
                                        $magence->update($agence);
                                    }
                                }
                            }
                            //Mise à jour des nouvelle agences
                            $code_agence = array();
                            $code_agence = $this->_request->getPost("code_agence");
                            foreach ($code_agence as $row) {
                                $find_agence = $magence->find($row, $agence);
                                if ($find_agence !== false) {
                                    $agence->setCode_gac_agence($code_gac);
                                    $magence->update($agence);
                                }
                            }
                            return $this->_helper->redirector('index');
                        }
                    }
                } else {
                    $this->view->message = 'Ce membre ' . $num_membre . ' ne dispose d\'aucun contrat';
                    $this->view->form = $form;
                    return;
                }
            }
        } else {
            $code_gac = $request->gac;
            $mapper = new Application_Model_EuGacMapper();
            $gac = new Application_Model_EuGac();
            $mapper->find($code_gac, $gac);
            if ($gac->getCode_gac() == $code_gac) {
                //Récupération des agences
                $magence = new Application_Model_EuAgenceMapper();
                $agence = new Application_Model_EuAgence();
                $find_agence = $magence->findByGac($code_gac);
                if ($find_agence !== false) {
                    $agence = array();
                    $i = 0;
                    foreach ($find_agence as $row) {
                        $agence[$i] = $row->code_agence;
                        $i++;
                    }
                }
                //Récupération des information du gestionnaire                    
                $mmember = new Application_Model_EuMembreMapper();
                $member = new Application_Model_EuMembre();
                $mmember->find($gac->getCode_membre_gestionnaire(), $member);
                $data = array(
                    'code_gac' => $code_gac,
                    'nom_gac' => $gac->getNom_gac(),
                    'code_membre' => $gac->getCode_membre(),
                    'code_type_gac' => $gac->getCode_type_gac(),
                    'code_zone' => $gac->getCode_zone(),
                    'code_agence' => $agence,
                    //'groupe' => $gac->getGroupe(),
                    'code_membre_gestionnaire' => $gac->getCode_membre_gestionnaire(),
                    'nom_gestion' => $member->getNom_membre(),
                    'prenom_gestion' => $member->getPrenom_membre(),
                    'tel_gestion' => $member->getPortable_membre(),
                    'zone' => $gac->getZone(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-gac',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function listgenesmcipnAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac', array('nom_gac'))
                ->where('eu_smcipn.etat_demande_inv = ?', 0)
                ->where('eu_smcipn.etat_demande_sal = ?', 0)
                ->where('eu_smcipn.valid_gac= ?', 1)
                ->order('eu_smcipn.date_demande', 'desc');
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
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::timestamp);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                $row->montant_investis,
                $row->nom_gac,
                $date_dem->toString('dd/mmm/yyyy hh:mm:ss'),
            );
            $i++;
        }
        $responce['userdata']['dvm_demand'] = 'Totaux:';
        $responce['userdata']['mt_SALAIRE'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $this->view->data = $responce;
    }

    public function demandegeneAction() {
        $this->_helper->layout->disableLayout();
    }

    public function demandeaccorderAction() {
        $this->_helper->layout->disableLayout();
    }

    public function listaccorderAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join(array('g' => 'eu_gac'), 'g.code_gac = eu_smcipn.code_gac', array('nom_gac'))
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.valid_gac= ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0);
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join(array('g' => 'eu_gac'), 'g.code_gac = eu_smcipn.code_gac', array('nom_gac'))
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.valid_gac= ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0);
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->union(array($select1, $select2))
                ->order('date_demande', 'desc');
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
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                $row->montant_investis,
                $row->nom_gac,
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $responce['userdata']['dvm_demand'] = 'Totaux:';
        $responce['userdata']['mt_SALAIRE'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $this->view->data = $responce;
    }

    public function listsmcipngacAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        if (isset($_GET['num_gac'])) {
            $num_gac = $_GET['num_gac'];
            $tabela = new Application_Model_DbTable_EuSmcipn();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = eu_smcipn.code_gac', array('nom_gac'))
                    ->where('eu_smcipn.valid_gac= ?', 1)
                    ->where('eu_smcipn.etat_demande_inv = ?', 0)
                    ->where('eu_smcipn.code_gac = ?', $num_gac)
                    ->where('eu_smcipn.montant_investis != ?', 0)
                    ->where('eu_smcipn.allouer_i != ?', 1)
                    ->order('eu_smcipn.date_demande', 'desc');
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
                    ucfirst($row->nom_gac),
                    $date_dem->toString('dd/mm/yyyy'),
                    $row->montant_salaire,
                    $row->montant_investis,
                    $total,
                );
                $i++;
            }
            $responce['userdata']['date_demand'] = 'Total:';
            $responce['userdata']['mt_SALAIRE'] = $totsal;
            $responce['userdata']['mt_investis'] = $totinves;
            $responce['userdata']['total'] = $tot;
            $this->view->data = $responce;
        }
    }

    public function listsmcipngacsalAction() {
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_jr = clone $date_id;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        if (isset($_GET['num_gac'])) {
            $num_gac = $_GET['num_gac'];

            $tabela = new Application_Model_DbTable_EuSmcipn();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join(array('g' => 'eu_gac'), 'g.code_gac = eu_smcipn.code_gac', array('nom_gac'))
                    ->where('eu_smcipn.valid_gac= ?', 1)
                    ->where('eu_smcipn.etat_demande_sal != ?', 1)
                    ->where('eu_smcipn.code_gac = ?', $num_gac)
                    ->where('eu_smcipn.montant_salaire != ?', 0)
                    ->where('eu_smcipn.allouer_s != ?', 1)
                    ->where('eu_smcipn.date_alloc <= ?', $date_jr->toString('yyyy-mm-dd'))
                    ->order('eu_smcipn.date_demande', 'desc');
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
                if ($row->type_objet == 'fixe') {
                    $cat = $row->code_smcipn;
                } else {
                    $cat = $row->type_objet;
                }
                $totsal+=$row->montant_salaire - $row->salaire_alloue;
                $totinves+=$row->montant_investis;
                $total = $row->montant_salaire + $row->montant_investis;
                $tot+=$total;
                $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_smcipn;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_smcipn,
                    ucfirst($row->lib_demande),
                    $row->code_membre,
                    ucfirst($row->nom_gac),
                    $cat,
                    $date_dem->toString('dd/mm/yyyy'),
                    $row->montant_salaire - $row->salaire_alloue,
                    $row->montant_investis,
                    $total,
                );
                $i++;
            }
            $responce['userdata']['date_demand'] = 'Total:';
            $responce['userdata']['mt_SALAIRE'] = $totsal;
            $responce['userdata']['mt_investis'] = $totinves;
            $responce['userdata']['total'] = $tot;
            $this->view->data = $responce;
        }
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
                ->join('eu_objet', 'eu_objet.id_objet = eu_budget_facture.id_objet')
                ->join('eu_investissement', 'eu_investissement.id_investissement = eu_budget_facture.id_investissement')
                ->where('eu_investissement.code_smcipn= ?', $code_dem);
        $invest = $tabel->fetchAll($sel);
        $binves = 0;
        foreach ($invest as $row) {
            $inv = $row->pu_objet * $row->qte_objet;
            $inves = $inv - ($inv * $row->remise_objet / 100);
            $binves+=$inves;
        }
        $this->view->investis = $binves;
    }

    public function listSALAIREAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_dem = $request->code_demand;

        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
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
                ucfirst($row->nom_membre),
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
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        if ($mt_inves > 0) {
            $tabela = new Application_Model_DbTable_EuBudgetFacture();
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->join('eu_objet', 'eu_objet.id_objet = eu_budget_facture.id_objet')
                    ->join('eu_investissement', 'eu_investissement.id_investissement = eu_budget_facture.id_investissement')
                    ->where('eu_investissement.code_smcipn = ?', $code_dem);
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
                $responce['rows'][$i]['id'] = $row->id_objet . $row->code_proformat;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_proformat,
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

    public function allouerAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $numero_gac = $_GET['num_gac'];
        //Recherche du numéro membre de la gac
        $mgac = new Application_Model_EuGacMapper();
        $gac = new Application_Model_EuGac();
        $mgac->find($numero_gac, $gac);
        $num_gac = $gac->getCode_membre();

        $smc = new Application_Model_EuSmcipnMapper();
        $sm = new Application_Model_EuSmcipn();
		
        //$rappro = new Application_Model_EuRapprochement();
        //$m_rappro = new Application_Model_EuRapprochementMapper();
		
        $gcsc = new Application_Model_EuGcsc();
        $m_gcsc = new Application_Model_EuGcscMapper();
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $fn_mapper = new Application_Model_EuFnMapper();
        if (count($selection) > 0) {
		
            //Contôle du montant des i disponibles à la source
            $ir = 0;
            foreach ($selection as $ctrl) {
                $smc->find($ctrl, $sm);
                $ir+=$sm->getMontant_investis();
            }
			
            //Récupération et contôle du montant du i disponible à la source fn
            $somme_fn = $fn_mapper->getSumFN();
            if ($somme_fn < $ir) {
                $this->view->data = 'inves';
                return;
            } else {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $mt_inves = 0;
                    $mt_smc = 0;
                    $mser = new Application_Model_EuServirMapper();
                    $ser = new Application_Model_EuServir();
                    $source = new Application_Model_EuFn();
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
                    foreach ($selection as $sel) {
					
                        $smc->find($sel, $sm);
                        $sm->setCode_smcipn($sm->getCode_smcipn());
                        $sm->setEtat_demande_inv(1);
                        $mt_inves+=$sm->getMontant_investis();
                        $mt_smc+=$sm->getMontant_investis() + $sm->getMontant_salaire();
						
                        //Mise à jour de la table smcipn
                        $smc->update($sm);
                        //#################Création des comptes de subvention tsci pour chaque smcipn#################
						
                        if ($sm->getCode_membre() == $num_gac) {
						
                            $code_smcipn = $sm->getCode_smcipn();
                            $compte_credit = new Application_Model_EuCompteCredit();
                            $cc_mapper = new Application_Model_EuCompteCreditMapper();
							
                            //Création du compte tsci du bénéficiaire de la smcipn
							
                            if ($sm->getMontant_investis() > 0) {
                                $cat_compte = 'tsci';
                                $compte_source = 'fn';
                                $num_comptes = 'nr-' . $cat_compte . '-' . $num_gac;
                                $result = $cm_mapper->find($num_comptes, $compte);
                                if ($result == false) {
                                    $compte->setCode_membre($num_gac)
                                            ->setCode_cat('tsci')
                                            ->setCode_type_compte('nr')
                                            ->setSolde($sm->getMontant_investis())
                                            ->setSource($compte_source)
                                            ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                            ->setCode_compte($num_comptes)
                                            ->setLib_compte($cat_compte)
                                            ->setDesactiver(0);
                                    $cm_mapper->save($compte);
                                } else {
                                    $compte->setSolde($compte->getSolde() + $sm->getMontant_investis());
                                    $cm_mapper->update($compte);
                                }
                                //Enregistrement des détails des subventions dans la table compte crédit
                                $date_fin->addDay(ceil($sm->getDvm_demande() * 30));
                                $compte_credit->setCode_membre($num_gac)
                                        ->setCode_produit('Ir')
                                        ->setMontant_place($sm->getMontant_investis())
                                        ->setDatedeb($date_deb->toString('yyyy-mm-dd'))
                                        ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                        ->setDate_octroi($date_deb->toString('yyyy-mm-dd'))
                                        ->setSource($num_gac . $date_deb->toString('yyyyMMddHHmmss'))
                                        ->setCode_compte($num_comptes)
                                        ->setMontant_credit($sm->getMontant_investis())
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
                                    $gcsc->setCode_membre($num_gac);
                                    $gcsc->setDebit($mt_rembourse);
                                    $gcsc->setCredit(0);
                                    $gcsc->setSolde($mt_rembourse);
                                    $gcsc->setCode_smcipn($code_smcipn);
                                    $gcsc->setCode_smcipnp(null);
                                    $m_gcsc->save($gcsc);
                                }
								
                                //Mise à jour de l'investissement alloué dans la table smcipn
                                $sm->setInvestis_alloue($sm->getInvestis_alloue() + $sm->getMontant_investis());
                                $sm->setAllouer_i(1);
                                $smc->update($sm);
                            }
                        }
						
                        //##########Fin de création des comptes du bénéficiaire de la subvention############
                        //
                        //
                        //####Récupération des comptes de la source fn et traitement####
						
                        $fn_mapper = new Application_Model_EuFnMapper();
                        $fn = $fn_mapper->find1();
                        if (!$fn) {
                            $this->view->data = 'inves1';
                            $db->rollback();
                            return;
                        } elseif (count($fn) == 1) {
                            $source = $fn[0];
                            $out = $source->getSortie() + $sm->getMontant_investis();
                            $source->setSortie($out);
                            $source->setSolde($out);
                            $reste_solde = $source->getMontant_solde() - $sm->getMontant_investis();
                            if ($reste_solde >= 0) {
                                $source->setMontant_solde($reste_solde);
                            } else {
                                $source->setMontant_solde(0);
                            }
                            $fn_mapper->update($source);
							
                            //Enregistrement dans la table eu_servir
                            $ser->setId_fn($source->getId_fn());
                            $ser->setCode_smcipn($sm->getCode_smcipn());
                            $ser->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                            $ser->setMontant_allouer($sm->getMontant_investis());
                            if ($sm->getMontant_investis() > 0) {
                                try {
                                    $mser->save($ser);
                                } catch (Exception $exc) {
                                    $this->view->data = 'alloci';
                                    $db->rollback();
                                    return;
                                }
                            }
                        } elseif (count($fn) > 1) {
                            $i = 0;
                            $source = $fn[$i];
                            $reste = ($sm->getMontant_investis() + $source->getSortie()) - $source->getMontant();
                            if ($reste <= 0) {
                                $investis = $source->getSortie() + $sm->getMontant_investis();
                                $source->setSortie($investis);
                                $source->setSolde($investis);
                                $reste_solde = $source->getMt_solde() - $sm->getMontant_investis();
                                if ($reste_solde >= 0) {
                                    $source->setMt_solde($reste_solde);
                                } else {
                                    $source->setMt_solde(0);
                                }
                                $fn_mapper->update($source);
								
                                //Enregistrement dans la table eu_servir
                                $ser->setId_fn($source->getId_fn());
                                $ser->setCode_smcipn($sm->getCode_smcipn());
                                $ser->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                $ser->setMontant_allouer($sm->getMontant_investis());
                                if ($sm->getMontant_investis() > 0) {
                                    try {
                                        $mser->save($ser);
                                    } catch (Exception $exc) {
                                        $this->view->data = 'alloci';
                                        $db->rollback();
                                        return;
                                    }
                                }
                            } else {
                                while ($reste > 0) {
                                    $source->setSortie($source->getMontant());
                                    $source->setSolde($source->getMontant());
                                    $reste_solde = $source->getMt_solde() - $sm->getMontant_investis();
                                    $tmp_sold = $source->getMt_solde();
                                    if ($reste_solde >= 0) {
                                        $source->setMt_solde($reste_solde);
                                    } else {
                                        $source->setMt_solde(0);
                                    }
                                    $fn_mapper->update($source);
									
                                    //Enregistrement dans la table eu_servir
                                    $ser->setId_fn($source->getId_fn());
                                    $ser->setCode_smcipn($sm->getCode_smcipn());
                                    $ser->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                    $ser->setMontant_allouer($tmp_sold);
                                    if ($tmp_sold > 0) {
                                        try {
                                            $mser->save($ser);
                                        } catch (Exception $exc) {
                                            $this->view->data = 'alloci';
                                            $db->rollback();
                                            return;
                                        }
                                    }

                                    $i = $i + 1;
                                    $source = $fn[$i];
                                    $reste = $reste - $source->getMontant();
                                    if ($reste <= 0) {
                                        $sortie = $source->getMontant() - abs($reste);
                                        $source->setSortie($sortie);
                                        $source->setSolde($sortie);
                                        $reste_solde = $source->getMt_solde() - $sortie;
                                        if ($reste_solde >= 0) {
                                            $source->setMt_solde($reste_solde);
                                        } else {
                                            $source->setMt_solde(0);
                                        }
                                        $fn_mapper->update($source);
                                        //Enregistrement dans la table eu_servir
                                        $ser->setId_fn($source->getId_fn());
                                        $ser->setCode_smcipn($sm->getCode_smcipn());
                                        $ser->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                        $ser->setMontant_allouer($sortie);
                                        if ($sortie > 0) {
                                            try {
                                                $mser->save($ser);
                                            } catch (Exception $exc) {
                                                $this->view->data = 'alloci';
                                                $db->rollback();
                                                return;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //###########Traitements généraux#############
                    //####Traitement de l'investissement de la smcipn####             
                    if ($mt_inves > 0) {
                        $code_cat = 'Ir';
                        if ($somme_fn >= $mt_inves) {
                            //Ajout dans la table opération
                            $alloc = new Application_Model_EuOperation();
                            $alloc->setDate_op($date_deb->toString('yyyy-mm-dd'));
                            $alloc->setHeure_op($date_deb->toString('hh:mm'));
                            $alloc->setMontant_op($mt_inves);
                            $alloc->setCode_membre($num_gac);
                            $alloc->setCode_produit($code_cat);
                            $alloc->setId_utilisateur($user->id_utilisateur);
                            $alloc->setLib_op('Allocation de ressources à la gac');
                            $alloc->setCode_cat('i');
                            $alloc->setType_op('arg');
                            $mapper = new Application_Model_EuOperationMapper();
                            $mapper->save($alloc);
                            //Ajout dans la table compte
                            if ($sm->getCode_membre() != $num_gac) {
                                $compte = new Application_Model_EuCompte();
                                $cm_mapper = new Application_Model_EuCompteMapper();
                                $num_compte = 'nr-' . $alloc->getCode_produit() . '-' . $alloc->getCode_membre();
                                $result = $cm_mapper->find($num_compte, $compte);
                                if ($result == false) {
                                    $compte->setCode_membre($alloc->getCode_membre())
                                            ->setCode_cat('i')
                                            ->setDesactiver(0)
                                            ->setCode_type_compte('nr')
                                            ->setSolde($alloc->getMontant_op())
                                            ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                            ->setCode_compte($num_compte)
                                            ->setLib_compte($alloc->getCode_produit());
                                    $cm_mapper->save($compte);
                                } else {
                                    $compte->setSolde($compte->getSolde() + $alloc->getMontant_op());
                                    $cm_mapper->update($compte);
                                }
                            }
                        } else {
                            $this->view->data = 'inves';
                            $db->rollback();
                            return;
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
                    $this->view->data = 'echec';
                }
            }
        }
    }

    public function allouersalAction() {
	
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $numero_gac = $_GET['num_gac'];
        //Recherche du numéro membre de la gac
        $mgac = new Application_Model_EuGacMapper();
        $gac = new Application_Model_EuGac();
        $mgac->find($numero_gac, $gac);
        $num_gac = $gac->getCode_membre();

        $type_alloc = $_GET['type_alloc'];
        $smc = new Application_Model_EuSmcipnMapper();
        $sm = new Application_Model_EuSmcipn();
        $rappro = new Application_Model_EuRapprochement();
        $m_rappro = new Application_Model_EuRapprochementMapper();
        $gcsc = new Application_Model_EuGcsc();
        $m_gcsc = new Application_Model_EuGcscMapper();
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $smc_mapper = new Application_Model_EuSmcMapper();
        if (count($selection) > 0) {
            //Contôle du montant du cncs disponible à la source smc
            $cncsr = 0;
            $mdv = 0;
            foreach ($selection as $ctrl) {
                $smc->find($ctrl, $sm);
                $cat_objet = $sm->getType_objet();
                //Traitement des smcipn
                if ($sm->getType_smcipn() == 'smcipn' and $sm->getType_objet() == 'fixe' and $type_alloc == 'periodique') {
                    $tot_mdv = 0;
                    $code = $sm->getCode_smcipn();
                    //Détermination de la moyenne des mdvbps des produits utilisés pr la demande smci
                    $select = "select i.id_investissement, i.montant_budget, i.cat_objet, i.code_smcipn, i.id_besoin, b.id_objet, b.code_proformat, mdv from eu_investissement i join eu_budget_facture b on i.id_investissement=b.id_investissement join eu_porter p on p.id_objet=b.id_objet where i.code_smcipn= '$code'";
                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->setFetchMode(Zend_Db::fetch_obj);
                    $produit = $db->fetchAll($select);
                    $count = count($produit);
                    foreach ($produit as $row) {
                        $tot_mdv += $row->mdv;
                    }
                    $mdv = $tot_mdv / $count;
                    //Détermination du salaire max
                    //Récupération de la prk et de la pck pour les nr
                    $prk = 0;
                    $pck = 0;
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
                    //Calcul du montant du salaire périodique à allouer
                    $inr = ($sm->getMontant_investis() * $prk) / $pck;
                    $sal = $inr - $sm->getMontant_investis();
                    $pcncsr = $sal / ($mdv * 12.175);
                    $cncsr+=ceil($pcncsr);
                    } else {
                      $cncsr+=$sm->getMontant_salaire() - $sm->getSalaire_alloue();
                    }
                    //Traitement des smcpn
                    if ($cat_objet != null and $type_alloc == 'periodique') {
                    //Récup du type d'investissement
                    $sm1 = new Application_Model_EuSmcipn();
                    $find_smci = $smc->find($cat_objet, $sm1);
                    if ($find_smci != false) {
                        $type_smci = $sm1->getType_objet();
                        if ($type_smci == 'fixe') {
                            $tot_mdv = 0;
                            //Détermination de la moyenne des mdvbps des produits utilisés pr la demande smci
                            $select = "select i.id_investissement, i.montant_budget, i.cat_objet, i.code_smcipn, i.id_besoin, b.id_objet, b.code_proformat, mdv from eu_investissement i join eu_budget_facture b on i.id_investissement=b.id_investissement join eu_porter p on p.id_objet=b.id_objet where i.code_smcipn= '$cat_objet'";
                            $db = Zend_Db_Table::getDefaultAdapter();
                            $db->setFetchMode(Zend_Db::fetch_obj);
                            $produit = $db->fetchAll($select);
                            $count = count($produit);
                            foreach ($produit as $row) {
                                $tot_mdv += $row->mdv;
                            }
                            $mdv = $tot_mdv / $count;
                            //Détermination du salaire max
                            //Récupération de la prk et de la pck pour les nr
                            $prk = 0;
                            $pck = 0;
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
                            //Calcul du montant du salaire périodique à allouer
                            $inr = ($sm1->getMontant_investis() * $prk) / $pck;
                            $sal = $inr - $sm1->getMontant_investis();
                            $pcncsr = $sal / ($mdv * 12.175);
                            $cncsr+=ceil($pcncsr);
                        } else {
                            $cncsr += $sm->getMontant_salaire() - $sm->getSalaire_alloue();
                        }
                    }
                } else {
                    $cncsr+=$sm->getMontant_salaire() - $sm->getSalaire_alloue();
                }
            }
            //Calcul de la somme des cncs disponibles à la source
            $somme_smc = $smc_mapper->getSumSMC();
            if ($somme_smc < $cncsr) {
                $this->view->data = 'sal';
                return;
            } else {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $mt_salaire = 0;
                    $sal_alloue = 0;
                    $reste = 0;
                    //$mt_smc = 0;
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
                    foreach ($selection as $sel) {
                        $smc->find($sel, $sm);
                        //***Détermination du salaire périodique ou global à allouer
                        $cat_objet = $sm->getType_objet();
                        if ($cat_objet != null and $type_alloc == 'periodique')  {
                            //Récup du type d'investissement
                            $sm1 = new Application_Model_EuSmcipn();
                            if ($sm->getType_objet() == 'fixe') {
                                $cat_objet = $sm->getCode_smcipn();
                            } else {
                                $cat_objet = $sm->getType_objet();
                            }
                            $find_smci = $smc->find($cat_objet, $sm1);
                            $type_smci = $sm1->getType_objet();
                            if ($type_smci == 'fixe') {
                                $tot_mdv = 0;
                                //Détermination de la moyenne des mdvbps des produits utilisés pr la demande smci
                                $select = "select i.id_investissement, i.montant_budget, i.cat_objet, i.code_smcipn, i.id_besoin, b.id_objet, b.code_proformat, mdv from eu_investissement i join eu_budget_facture b on i.id_investissement=b.id_investissement join eu_porter p on p.id_objet=b.id_objet where i.code_smcipn= '$cat_objet'";
                                $db = Zend_Db_Table::getDefaultAdapter();
                                $db->setFetchMode(Zend_Db::fetch_obj);
                                $produit = $db->fetchAll($select);
                                $count = count($produit);
                                foreach ($produit as $row) {
                                    $tot_mdv += $row->mdv;
                                }
                                $mdv = $tot_mdv / $count;
                                //Détermination du salaire max
                                //Récupération de la prk et de la pck pour les nr
                                $prk = 0;
                                $pck = 0;
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
                                //Calcul du montant du salaire périodique à allouer
                                $inr = ($sm1->getMontant_investis() * $prk) / $pck;
                                $sal = $inr - $sm1->getMontant_investis();
                                $pcncsr = ceil($sal / ($mdv * 12.175));
                                $mt_salaire+=$pcncsr;
                                $sal_alloue = $pcncsr;
                                $sm->setEtat_demande_sal(0);
                                $sm->setType_alloc('periodique');
                                $sm->setSal_transmis($sal_alloue);
                                $sm->setEtat_sal(1);
                                $mt_alloue = $sm->getSalaire_alloue() + $sal_alloue;
                                if ($mt_alloue <= $sm->getMontant_salaire()) {
                                    //Comparaison de la date d'allocation par rapport à la date du jour
                                    $date = new Zend_Date(Zend_Date::ISO_8601);
                                    $date_create = clone $date;
                                    if ($date_create->toString('yyyy-mm-dd') < $sm->getDate_alloc()) {
                                        $this->view->data = 'bad_date';
                                        return;
                                    } else {
                                        //Incrémentation de la date de 30 jrs
                                        $date_next = new Zend_Date($sm->getDate_alloc(), Zend_Date::ISO_8601);
                                        $date_next->addDay(30);
                                        $sm->setDate_alloc($date_next->toString('yyyy-mm-dd'));
                                    }
                                }
                            } else {
                                $mt_salaire += $sm->getMontant_salaire();
                                $sal_alloue = $sm->getMontant_salaire();
                                $sm->setEtat_demande_sal(1);
                            }
                        } else {
                            $mt_salaire+=$sm->getMontant_salaire();
                            $sal_alloue = $sm->getMontant_salaire();
                            $sm->setEtat_demande_sal(1);
                        }
                        //Mise à jour du salaire alloué dans la table smcipn
                        $sm->setSalaire_alloue($sm->getSalaire_alloue() + $sal_alloue);
                        $sm->setSal_transmis($sal_alloue);
                        $sm->setEtat_sal(1);
                        //Mise à jour de la table smcipn
                        //$smc->update($sm);
                        try {
                            $smc->update($sm);
                        } catch (Exception $exc) {
                            $db->rollback();
                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                            $this->view->data = $message;
                            return;
                        }
                        //###########Traitements généraux#############
                        //#################Création des comptes de subvention tpn pour chaque smcipn#################
                        if ($sm->getCode_membre() == $num_gac) {
                            if ($sm->getValid_fil() == 0 || $sm->getValid_creneau() == 0) {
                                $num_gac1 = $sm->getCode_membre();
                            }
                            $code_smcipn = $sm->getCode_smcipn();
                            $compte_credit = new Application_Model_EuCompteCredit();
                            $cc_mapper = new Application_Model_EuCompteCreditMapper();
                            //Création du compte tpn du bénéficiaire de la smcipn
                            if ($sal_alloue > 0) {
                                $cat_compte = 'tpn';
                                $compte_source = 'smc';
                                $num_comptes = 'nr-' . $cat_compte . '-' . $num_gac1;
                                $result = $cm_mapper->find($num_comptes, $compte);
                                if ($result == false) {
                                    $compte->setCode_membre($num_gac1)
                                            ->setCode_cat('tpn')
                                            ->setDesactiver(0)
                                            ->setCode_type_compte('nr')
                                            ->setSolde($sal_alloue)
                                            ->setSource($compte_source)
                                            ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                            ->setCode_compte($num_comptes)
                                            ->setLib_compte($cat_compte);
                                    //$cm_mapper->save($compte);
                                    try {
                                        $cm_mapper->save($compte);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
                                } else {
                                    $compte->setSolde($compte->getSolde() + $sal_alloue);
                                    //$cm_mapper->update($compte);
                                    try {
                                        $cm_mapper->update($compte);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
                                }
                                //Enregistrement des détails des subventions dans la table compte crédit
                                $date_fin->addDay(ceil($sm->getDvm_demande() * 30));
                                $rest = $cc_mapper->findBySMC($sel, $num_comptes);
                                if ($rest == false) {
                                    $compteur = 0;
                                    $mapper = new Application_Model_EuOperationMapper();
                                    $compteur = $mapper->findConuter();
                                    $compte_credit->setCode_membre($num_gac1)
                                            ->setCode_produit('CNCSr')
                                            ->setMontant_place($sal_alloue)
                                            ->setDatedeb($date_deb->toString('yyyy-mm-dd'))
                                            ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                            ->setDate_octroi($date_deb->toString('yyyy-mm-dd'))
                                            ->setSource($num_gac1 . $date_deb->toString('yyyyMMddHHmmss'))
                                            ->setCode_compte($num_comptes)
                                            ->setMontant_credit($sal_alloue)
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
                                    //$cc_mapper->save($compte_credit);
                                    try {
                                        $cc_mapper->save($compte_credit);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
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
                                    //$cc_mapper->update($compte_credit);
                                    try {
                                        $cc_mapper->update($compte_credit);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
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
                                    $gcsc->setDebit($find_gcsc->getDebit() + $sm->getMontant_salaire());
                                    $gcsc->setCredit($find_gcsc->getCredit());
                                    $gcsc->setSolde($find_gcsc->getSolde() - $sm->getMontant_salaire());
                                    $gcsc->setCode_smcipn($code_smcipn);
                                    $gcsc->setCode_smcipnp($find_gcsc->getCode_smcipnp());
                                    $gcsc->setCode_domicilier($find_gcsc->getCode_domicilier());
                                    //$m_gcsc->update($gcsc);
                                    try {
                                        $m_gcsc->update($gcsc);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
                                } else {
                                    $gcsc->setCode_membre($num_gac1);
                                    $gcsc->setDebit($sm->getMontant_salaire());
                                    $gcsc->setCredit(0);
                                    $gcsc->setSolde($sm->getMontant_salaire());
                                    $gcsc->setCode_smcipn($code_smcipn);
                                    $gcsc->setCode_smcipnp(null);
                                    $gcsc->setCode_domicilier(null);
                                    //$m_gcsc->save($gcsc);
                                    try {
                                        $m_gcsc->save($gcsc);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
                                }
                                //Enregistrement dans la table smcipn
                                if ($sal_alloue == $sm->getMontant_salaire()) {
                                    $sm->setAllouer_s(1);
                                    $sm->setSal_transmis(0);
                                    $sm->setEtat_sal(0);
                                } else {
                                    $sm->setAllouer_s(0);
                                    $sm->setSal_transmis(0);
                                    $sm->setEtat_sal(0);
                                }
                                //$smc->update($sm);
                                try {
                                    $smc->update($sm);
                                } catch (Exception $exc) {
                                    $db->rollback();
                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                    $this->view->data = $message;
                                    return;
                                }
                            }
                        } else {//Subvention n'appartenant pas à la gac centrale
                            if ($mt_salaire > 0) {
                               $code_cat = 'CNCSr';
                               if ($somme_smc >= $mt_salaire) {
                                    //Ajout dans la table opération
                                    $alloc = new Application_Model_EuOperation();
                                    $alloc->setDate_op($date_deb->toString('yyyy-mm-dd'));
                                    $alloc->setHeure_op($date_deb->toString('hh:mm'));
                                    $alloc->setMontant_op($mt_salaire);
                                    $alloc->setCode_membre($num_gac);
                                    $alloc->setCode_produit($code_cat);
                                    $alloc->setId_utilisateur($user->id_utilisateur);
                                    $alloc->setLib_op('Allocation de ressources à la gac');
                                    $alloc->setCode_cat('cncs');
                                    $alloc->setType_op('arg');
                                    $mapper = new Application_Model_EuOperationMapper();
                                    //$mapper->save($alloc);
                                    try {
                                        $mapper->save($alloc);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
                                    //Ajout dans la table compte
                                    if ($sm->getCode_membre() != $num_gac) {
                                        $compte = new Application_Model_EuCompte();
                                        $cm_mapper = new Application_Model_EuCompteMapper();
                                        $num_compte = 'nr-' . $alloc->getCode_produit() . '-' . $alloc->getCode_membre();
                                        $result = $cm_mapper->find($num_compte, $compte);
                                        if ($result == false) {
                                            $compte->setCode_membre($alloc->getCode_membre())
                                                    ->setCode_cat('cncs')
                                                    ->setDesactiver(0)
                                                    ->setCode_type_compte('nr')
                                                    ->setSolde($alloc->getMontant_op())
                                                    ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                    ->setCode_compte($num_compte)
                                                    ->setLib_compte($alloc->getCode_produit());
                                            //$cm_mapper->save($compte);
                                            try {
                                                $cm_mapper->save($compte);
                                            } catch (Exception $exc) {
                                                $db->rollback();
                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                $this->view->data = $message;
                                                return;
                                            }
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $alloc->getMontant_op());
                                            //$cm_mapper->update($compte);
                                            try {
                                                $cm_mapper->update($compte);
                                            } catch (Exception $exc) {
                                                $db->rollback();
                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                $this->view->data = $message;
                                                return;
                                            }
                                        }
                                    }
                                } else {
                                    $this->view->data = 'sal';
                                    $db->rollback();
                                    return;
                                }
                            }
                        }
                        //##########Fin de création des comptes du bénéficiaire de la subvention############
                        //
                        //
                        //####Récupération des comptes de la source smc et traitement####
                        $muti = new Application_Model_EuUtiliserMapper();
                        $uti = new Application_Model_EuUtiliser();
                        $sources = new Application_Model_EuSmc();
                        $smc_mapper = new Application_Model_EuSmcMapper();
                        //Récupération du code de la domiciliation
                        $mdom = new Application_Model_EuDomiciliationMapper();
                        $find_dom = $mdom->findBySmcipn($sm->getCode_smcipn());
                        $code_domi = '';
                        if ($find_dom != null) {
                            $code_domi = $find_dom->getCode_domicilier();
                        }
                        //Test du code_smcipn de la demande d'investissement utilisée
                        //##Cas du salaire non lié à aucun investissement
                        $cat_objet = $sm->getType_objet();
                        if ($cat_objet == '') {
                            $smc = $smc_mapper->find1();
                            if (!$smc) {
                                $this->view->data = 'sal1';
                                $db->rollback();
                                return;
                            } elseif (count($smc) == 1) {
                                $sources = $smc[0];
                                $out = $sources->getSortie() + $sm->getMontant_salaire();
                                $sources->setSortie($out);
                                $sources->setSolde($out);
                                $reste_solde = $sources->getMontant_solde() - $sm->getMontant_salaire();
                                if ($reste_solde >= 0) {
                                    $sources->setMontant_solde($reste_solde);
                                } else {
                                    $sources->setMontant_solde(0);
                                }
                                //$smc_mapper->update($sources);
                                try {
                                    $smc_mapper->update($sources);
                                } catch (Exception $exc) {
                                    $db->rollback();
                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                    $this->view->data = $message;
                                    return;
                                }
                                //Enregistrement dans la table eu_utiliser
                                $count = $muti->findConuter() + 1;
                                $uti->setId_utiliser($count);
                                $uti->setId_smc($sources->getId_smc());
                                $uti->setCode_smcipn($sm->getCode_smcipn());
                                $uti->setCode_smcipnp(null);
                                $uti->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                $uti->setMontant_allouer($sm->getMontant_salaire());
                                if ($sm->getMontant_salaire() > 0) {
                                    try {
                                        $muti->save($uti);
                                    } catch (Exception $exc) {
                                        //$this->view->data = 'allocs';
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
                                    //Recherche du code_credit dans la table rapprochement
                                    $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                    if ($res != null) {
                                        //Mise à jour dans la table de rapprochement
                                        $rappro->setId_rappro($res->getId_rappro());
                                        $rappro->setDebit_rappro($res->getDebit_rappro());
                                        $rappro->setCredit_rappro($res->getCredit_rappro() + $sm->getMontant_salaire());
                                        $rappro->setSolde_rappro($res->getSolde_rappro() - $sm->getMontant_salaire());
                                        $rappro->setSource($res->getSource());
                                        $rappro->setSource_credit($res->getSource_credit());
                                        $rappro->setCode_smcipn($res->getCode_smcipn());
                                        $rappro->setCode_smcipnp($res->getCode_smcipnp());
                                        $rappro->setCode_domicilier(null);
                                        $rappro->setId_credit($res->getId_credit());
                                        $rappro->setType_rappro($res->getType_rappro());
                                        //$m_rappro->update($rappro);
                                        try {
                                            $m_rappro->update($rappro);
                                        } catch (Exception $exc) {
                                            $db->rollback();
                                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                            $this->view->data = $message;
                                            return;
                                        }
                                    } else {
                                        //Enregistrement dans la table de rapprochement
                                        $rappro->setDebit_rappro($sm->getMontant_salaire());
                                        $rappro->setCredit_rappro(0);
                                        $rappro->setSolde_rappro($sm->getMontant_salaire());
                                        $rappro->setSource('smc');
                                        $rappro->setSource_credit($sources->getSource_credit());
                                        $rappro->setCode_smcipn($sm->getCode_smcipn());
                                        $rappro->setCode_smcipnp(null);
                                        $rappro->setCode_domicilier(null);
                                        $rappro->setId_credit($sources->getId_credit());
                                        $rappro->setType_rappro(null);
                                        //$m_rappro->save($rappro);
                                        try {
                                            $m_rappro->save($rappro);
                                        } catch (Exception $exc) {
                                            $db->rollback();
                                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                            $this->view->data = $message;
                                            return;
                                        }
                                    }
                                }
                            } elseif (count($smc) > 1) {////////////Ken à voir
                                $i = 0;
                                $sources = $smc[$i];
                                $reste = ($sm->getMontant_salaire() + $sources->getSortie()) - $sources->getMontant();
                                if ($reste <= 0) {
                                    $salaire = $sources->getSortie() + $sm->getMontant_salaire();
                                    $sources->setSortie($salaire);
                                    $sources->setSolde($salaire);
                                    $reste_solde = $sources->getMontant_solde() - $sm->getMontant_salaire();
                                    if ($reste_solde >= 0) {
                                        $sources->setMontant_solde($reste_solde);
                                    } else {
                                        $sources->setMontant_solde(0);
                                    }
                                    //$smc_mapper->update($sources);
                                    try {
                                        $smc_mapper->update($sources);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
                                    //Enregistrement dans la table eu_utiliser
                                    $count = $muti->findConuter() + 1;
                                    $uti->setId_utiliser($count);
                                    $uti->setId_smc($sources->getId_smc());
                                    $uti->setCode_smcipn($sm->getCode_smcipn());
                                    $uti->setCode_smcipnp(null);
                                    $uti->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                    $uti->setMontant_allouer($sm->getMontant_salaire());
                                    if ($sm->getMontant_salaire() > 0) {
                                        try {
                                            $muti->save($uti);
                                        } catch (Exception $exc) {
                                            $this->view->data = 'allocs';
                                            $db->rollback();
                                            return;
                                        }
                                        //Recherche du code_credit dans la table de rapprochement
                                        $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                        if ($res != null) {
                                            //Mise à jour dans la table de rapprochement
                                            $rappro->setId_rappro($res->getId_rappro());
                                            $rappro->setDebit_rappro($res->getDebit_rappro());
                                            $rappro->setCredit_rappro($res->getCredit_rappro() + $sm->getMontant_salaire());
                                            $rappro->setSolde_rappro($res->getSolde_rappro() - $sm->getMontant_salaire());
                                            $rappro->setSource($res->getSource());
                                            $rappro->setSource_credit($res->getSource_credit());
                                            $rappro->setCode_smcipn($res->getCode_smcipn());
                                            $rappro->setCode_smcipnp($res->getCode_smcipnp());
                                            $rappro->setCode_domicilier($res->getCode_domicilier());
                                            $rappro->setId_credit($res->getId_credit());
                                            $rappro->setType_rappro($res->getType_rappro());
                                            //$m_rappro->update($rappro);
                                            try {
                                                $m_rappro->update($rappro);
                                            } catch (Exception $exc) {
                                                $db->rollback();
                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                $this->view->data = $message;
                                                return;
                                            }
                                        } else {
                                            //Enregistrement dans la table de rapprochement
                                            $rappro->setDebit_rappro($sm->getMontant_salaire());
                                            $rappro->setCredit_rappro(0);
                                            $rappro->setSolde_rappro($sm->getMontant_salaire());
                                            $rappro->setSource('smc');
                                            $rappro->setSource_credit($sources->getSource_credit());
                                            $rappro->setCode_smcipn($sm->getCode_smcipn());
                                            $rappro->setCode_smcipnp(null);
                                            $rappro->setCode_domicilier(null);
                                            $rappro->setId_credit($sources->getId_credit());
                                            $rappro->setType_rappro(null);
                                            //$m_rappro->save($rappro);
                                            try {
                                                $m_rappro->save($rappro);
                                            } catch (Exception $exc) {
                                                $db->rollback();
                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                $this->view->data = $message;
                                                return;
                                            }
                                        }
                                    }
                                } else {
                                    while ($reste > 0) {
                                        $sources->setSortie($sources->getMontant());
                                        $sources->setSolde($sources->getMontant());
                                        $reste_solde = $sources->getMontant_solde() - $sm->getMontant_salaire();
                                        $tmp_sold = $sources->getMontant_solde();
                                        if ($reste_solde >= 0) {
                                            $sources->setMontant_solde($reste_solde);
                                        } else {
                                            $sources->setMontant_solde(0);
                                        }
                                        try {
                                            $smc_mapper->update($sources);
                                        } catch (Exception $exc) {
                                            $db->rollback();
                                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                            $this->view->data = $message;
                                            return;
                                        }
                                        //Enregistrement dans la table eu_utiliser
                                        $count = $muti->findConuter() + 1;
                                        $uti->setId_utiliser($count);
                                        $uti->setId_smc($sources->getId_smc());
                                        $uti->setCode_smcipn($sm->getCode_smcipn());
                                        $uti->setCode_smcipnp(null);
                                        $uti->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                        $uti->setMontant_allouer($tmp_sold);
                                        if ($tmp_sold > 0) {
                                            try {
                                                $muti->save($uti);
                                            } catch (Exception $exc) {
                                                $this->view->data = 'allocs';
                                                $db->rollback();
                                                return;
                                            }
                                            //Recherche du code_credit dans la table de rapprochement
                                            $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                            if ($res != null) {
                                                //Mise à jour dans la table de rapprochement
                                                $rappro->setId_rappro($res->getId_rappro());
                                                $rappro->setDebit_rappro($res->getDebit_rappro());
                                                $rappro->setCredit_rappro($res->getCredit_rappro() + $tmp_sold);
                                                $rappro->setSolde_rappro($res->getSolde_rappro() - $tmp_sold);
                                                $rappro->setSource($res->getSource());
                                                $rappro->setSource_credit($res->getSource_credit());
                                                $rappro->setCode_smcipn($res->getCode_smcipn());
                                                $rappro->setCode_smcipnp($res->getCode_smcipnp());
                                                $rappro->setCode_domicilier($res->getCode_domicilier());
                                                $rappro->setId_credit($res->getId_credit());
                                                $rappro->setType_rappro($res->getType_rappro());
                                                try {
                                                    $m_rappro->update($rappro);
                                                } catch (Exception $exc) {
                                                    $db->rollback();
                                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                    $this->view->data = $message;
                                                    return;
                                                }
                                            } else {
                                                //Enregistrement dans la table de rapprochement
                                                $rappro->setDebit_rappro($tmp_sold);
                                                $rappro->setCredit_rappro(0);
                                                $rappro->setSolde_rappro($tmp_sold);
                                                $rappro->setSource('smc');
                                                $rappro->setSource_credit($sources->getSource_credit());
                                                $rappro->setCode_smcipn($sm->getCode_smcipn());
                                                $rappro->setCode_smcipnp(null);
                                                $rappro->setCode_domicilier(null);
                                                $rappro->setId_credit($sources->getId_credit());
                                                $rappro->setType_rappro(null);
                                                try {
                                                    $m_rappro->save($rappro);
                                                } catch (Exception $exc) {
                                                    $db->rollback();
                                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                    $this->view->data = $message;
                                                    return;
                                                }
                                            }
                                        }

                                        $i = $i + 1;
                                        $sources = $smc[$i];
                                        $reste = $reste - $sources->getMontant();
                                        if ($reste <= 0) {
                                            $sortie = $sources->getMontant() - abs($reste);
                                            $sources->setSortie($sortie);
                                            $sources->setSolde($sortie);
                                            $reste_solde = $sources->getMontant_solde() - $sortie;
                                            if ($reste_solde >= 0) {
                                                $sources->setMontant_solde($reste_solde);
                                            } else {
                                                $sources->setMontant_solde(0);
                                            }
                                            try {
                                                $smc_mapper->update($sources);
                                            } catch (Exception $exc) {
                                                $db->rollback();
                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                $this->view->data = $message;
                                                return;
                                            }
                                            $count = $muti->findConuter() + 1;
                                            $uti->setId_utiliser($count);
                                            //Enregistrement dans la table eu_utiliser
                                            $uti->setId_smc($sources->getId_smc());
                                            $uti->setCode_smcipn($sm->getCode_smcipn());
                                            $uti->setCode_smcipnp(null);
                                            $uti->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                            $uti->setMontant_allouer($sortie);
                                            if ($sortie > 0) {
                                                try {
                                                    $muti->save($uti);
                                                } catch (Exception $exc) {
                                                    $this->view->data = 'allocs';
                                                    $db->rollback();
                                                    return;
                                                }
                                                //Recherche du code_credit dans la table de rapprochement
                                                $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                                if ($res != null) {
                                                    //Mise à jour dans la table de rapprochement
                                                    $rappro->setId_rappro($res->getId_rappro());
                                                    $rappro->setDebit_rappro($res->getDebit_rappro());
                                                    $rappro->setCredit_rappro($res->getCredit_rappro() + $sortie);
                                                    $rappro->setSolde_rappro($res->getSolde_rappro() - $sortie);
                                                    $rappro->setSource($res->getSource());
                                                    $rappro->setSource_credit($res->getSource_credit());
                                                    $rappro->setCode_smcipn($res->getCode_smcipn());
                                                    $rappro->setCode_smcipnp($res->getCode_smcipnp());
                                                    $rappro->setCode_domicilier($res->getCode_domicilier());
                                                    $rappro->setId_credit($res->getId_credit());
                                                    $rappro->setType_rappro($res->getType_rappro());
                                                    try {
                                                        $m_rappro->update($rappro);
                                                    } catch (Exception $exc) {
                                                        $db->rollback();
                                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                        $this->view->data = $message;
                                                        return;
                                                    }
                                                } else {
                                                    //Enregistrement dans la table de rapprochement
                                                    $rappro->setDebit_rappro($sortie);
                                                    $rappro->setCredit_rappro(0);
                                                    $rappro->setSolde_rappro($sortie);
                                                    $rappro->setSource('smc');
                                                    $rappro->setSource_credit($sources->getSource_credit());
                                                    $rappro->setCode_smcipn($sm->getCode_smcipn());
                                                    $rappro->setCode_smcipnp(null);
                                                    $rappro->setCode_domicilier(null);
                                                    $rappro->setId_credit($sources->getId_credit());
                                                    $rappro->setType_rappro(null);
                                                    try {
                                                        $m_rappro->save($rappro);
                                                    } catch (Exception $exc) {
                                                        $db->rollback();
                                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                        $this->view->data = $message;
                                                        return;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {//##Cas des SALAIREs liés à une demande d'investissement
                            if ($sm->getType_objet() == 'circulant' || $sm->getType_objet() == 'fixe') {
                                $find_smc = $smc_mapper->findBySmcipn($sm->getCode_smcipn());
                            } else {
                                $find_smc = $smc_mapper->findBySmcipn($sm->getType_objet());
                            }
                            if ($find_smc == false) {
                                $this->view->data = 'no_sal';
                                $db->rollback();
                                return;
                            } elseif (count($find_smc) == 1) {
                                $sources = $find_smc[0];
                                if ($sources->getMontant_solde() < $sal_alloue) {
                                    $this->view->data = 'no_sal1';
                                    $db->rollback();
                                    return;
                                } else {
                                    $out = $sources->getSortie() + $sal_alloue;
                                    $sources->setSortie($out);
                                    $sources->setSolde($out);
                                    $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                                    if ($reste_solde >= 0) {
                                        $sources->setMontant_solde($reste_solde);
                                    } else {
                                        $sources->setMontant_solde(0);
                                    }
                                    //$smc_mapper->update($sources);
                                    try {
                                        $smc_mapper->update($sources);
                                    } catch (Exception $exc) {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                        $this->view->data = $message;
                                        return;
                                    }
                                    //Enregistrement dans la table eu_utiliser
                                    $count = $muti->findConuter() + 1;
                                    $uti->setId_utiliser($count);
                                    $uti->setId_smc($sources->getId_smc());
                                    $uti->setCode_smcipn($sm->getCode_smcipn());
                                    $uti->setCode_smcipnp(null);
                                    $uti->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                    $uti->setMontant_allouer($sal_alloue);
                                    if ($sal_alloue > 0) {
                                        try {
                                            $muti->save($uti);
                                        } catch (Exception $exc) {
                                            $this->view->data = 'allocs';
                                            $db->rollback();
                                            return;
                                        }
                                        //Recherche du code_credit dans la table rapprochement
                                        $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                        if ($res != null) {
                                            //Mise à jour dans la table de rapprochement
                                            $rappro->setId_rappro($res->getId_rappro());
                                            $rappro->setDebit_rappro($res->getDebit_rappro());
                                            $rappro->setCredit_rappro($res->getCredit_rappro() + $sal_alloue);
                                            $rappro->setSolde_rappro($res->getSolde_rappro() - $sal_alloue);
                                            $rappro->setSource($res->getSource());
                                            $rappro->setSource_credit($res->getSource_credit());
                                            $rappro->setCode_smcipn($res->getCode_smcipn());
                                            $rappro->setCode_smcipnp($res->getCode_smcipnp());
                                            $rappro->setCode_domicilier($res->getCode_domicilier());
                                            $rappro->setId_credit($res->getId_credit());
                                            $rappro->setType_rappro($res->getType_rappro());
                                            //$m_rappro->update($rappro);
                                            try {
                                                $m_rappro->update($rappro);
                                            } catch (Exception $exc) {
                                                $db->rollback();
                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                $this->view->data = $message;
                                                return;
                                            }
                                        } else {
                                            //Cas de l'allocation périodique de salaire:Ligne de rappro déjà créée
                                            $f_rappro = $m_rappro->findBySmcipnSource($sm->getCode_smcipn(), $sources->getSource_credit(), $sources->getId_credit());
                                            if ($f_rappro == null) {
                                                //Enregistrement dans la table de rapprochement
                                                $rappro->setDebit_rappro($sal_alloue);
                                                $rappro->setCredit_rappro(0);
                                                $rappro->setSolde_rappro($sal_alloue);
                                                $rappro->setSource('smc');
                                                $rappro->setSource_credit($sources->getSource_credit());
                                                $rappro->setCode_smcipn($sm->getCode_smcipn());
                                                $rappro->setCode_smcipnp(null);
                                                $rappro->setCode_domicilier(null);
                                                $rappro->setId_credit($sources->getId_credit());
                                                $rappro->setType_rappro(null);
                                                //$m_rappro->save($rappro);
                                                try {
                                                    $m_rappro->save($rappro);
                                                } catch (Exception $exc) {
                                                    $db->rollback();
                                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                    $this->view->data = $message;
                                                    return;
                                                }
                                            } else {
                                                //Mise à jour dans la table de rapprochement
                                                $rappro->setId_rappro($f_rappro->getId_rappro());
                                                $rappro->setDebit_rappro($f_rappro->getDebit_rappro() + $sal_alloue);
                                                $rappro->setCredit_rappro($f_rappro->getCredit_rappro());
                                                $rappro->setSolde_rappro($f_rappro->getSolde_rappro() + $sal_alloue);
                                                $rappro->setSource($f_rappro->getSource());
                                                $rappro->setSource_credit($f_rappro->getSource_credit());
                                                $rappro->setCode_smcipn($f_rappro->getCode_smcipn());
                                                $rappro->setCode_smcipnp($f_rappro->getCode_smcipnp());
                                                $rappro->setCode_domicilier($f_rappro->getCode_domicilier());
                                                $rappro->setId_credit($f_rappro->getId_credit());
                                                $rappro->setType_rappro($f_rappro->getType_rappro());
                                                //$m_rappro->update($rappro);
                                                try {
                                                    $m_rappro->update($rappro);
                                                } catch (Exception $exc) {
                                                    $db->rollback();
                                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                    $this->view->data = $message;
                                                    return;
                                                }
                                            }
                                        }
                                    }
                                }
                            } elseif (count($find_smc) > 1) {
                                //Calcul du cumul des soldes du code de la subvention d'investissement
                                $tot_sal = 0;
                                for ($j = 0; $j < count($find_smc); $j++) {
                                    $tot_sal += $find_smc[$j]->getMontant_solde();
                                }
                                if ($tot_sal < $sal_alloue) {
                                    $this->view->data = 'no_sal1';
                                    $db->rollback();
                                    return;
                                } else {
                                    $i = 0;
                                    $sources = $find_smc[$i];
                                    $reste = ($sal_alloue + $sources->getSortie()) - $sources->getMontant();
                                    if ($reste <= 0) {
                                        $salaire = $sources->getSortie() + $sal_alloue;
                                        $sources->setSortie($salaire);
                                        $sources->setSolde($salaire);
                                        $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                                        if ($reste_solde >= 0) {
                                            $sources->setMontant_solde($reste_solde);
                                        } else {
                                            $sources->setMontant_solde(0);
                                        }
                                        //$smc_mapper->update($sources);
                                        try {
                                            $smc_mapper->update($sources);
                                        } catch (Exception $exc) {
                                            $db->rollback();
                                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                            $this->view->data = $message;
                                            return;
                                        }
                                        //Enregistrement dans la table eu_utiliser
                                        $count = $muti->findConuter() + 1;
                                        $uti->setId_utiliser($count);
                                        $uti->setId_smc($sources->getId_smc());
                                        $uti->setCode_smcipn($sm->getCode_smcipn());
                                        $uti->setCode_smcipnp(null);
                                        $uti->setDate_create($date_deb->toString('yyyy-mm-dd'));
                                        $uti->setMontant_allouer($sal_alloue);
                                        if ($sal_alloue > 0) {
                                            try {
                                                $muti->save($uti);
                                            } catch (Exception $exc) {
                                                $this->view->data = 'allocs';
                                                $db->rollback();
                                                return;
                                            }
                                            //Recherche du code_credit dans la table de rapprochement
                                            $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                            if ($res != null) {
                                                //Mise à jour dans la table de rapprochement
                                                $rappro->setId_rappro($res->getId_rappro());
                                                $rappro->setDebit_rappro($res->getDebit_rappro());
                                                $rappro->setCredit_rappro($res->getCredit_rappro() + $sal_alloue);
                                                $rappro->setSolde_rappro($res->getSolde_rappro() - $sal_alloue);
                                                $rappro->setSource($res->getSource());
                                                $rappro->setSource_credit($res->getSource_credit());
                                                $rappro->setCode_smcipn($res->getCode_smcipn());
                                                $rappro->setCode_smcipnp($res->getCode_smcipnp());
                                                $rappro->setCode_domicilier($res->getCode_domicilier());
                                                $rappro->setId_credit($res->getId_credit());
                                                $rappro->setType_rappro($res->getType_rappro());
                                                //$m_rappro->update($rappro);
                                                try {
                                                    $m_rappro->update($rappro);
                                                } catch (Exception $exc) {
                                                    $db->rollback();
                                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                    $this->view->data = $message;
                                                    return;
                                                }
                                            } else {
                                                //Cas de l'allocation périodique de salaire:Ligne de rappro déjà créée
                                                $f_rappro = $m_rappro->findBySmcipnSource($sm->getCode_smcipn(), $sources->getSource_credit(), $sources->getId_credit());
                                                if ($f_rappro == null) {
                                                    //Enregistrement dans la table de rapprochement
                                                    $rappro->setDebit_rappro($sal_alloue);
                                                    $rappro->setCredit_rappro(0);
                                                    $rappro->setSolde_rappro($sal_alloue);
                                                    $rappro->setSource('smc');
                                                    $rappro->setSource_credit($sources->getSource_credit());
                                                    $rappro->setCode_smcipn($sm->getCode_smcipn());
                                                    $rappro->setCode_smcipnp(null);
                                                    $rappro->setCode_domicilier(null);
                                                    $rappro->setId_credit($sources->getId_credit());
                                                    $rappro->setType_rappro(null);
                                                    //$m_rappro->save($rappro);
                                                    try {
                                                        $m_rappro->save($rappro);
                                                    } catch (Exception $exc) {
                                                        $db->rollback();
                                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                        $this->view->data = $message;
                                                        return;
                                                    }
                                                } else {
                                                    //Mise à jour dans la table de rapprochement
                                                    $rappro->setId_rappro($f_rappro->getId_rappro());
                                                    $rappro->setDebit_rappro($f_rappro->getDebit_rappro() + $sal_alloue);
                                                    $rappro->setCredit_rappro($f_rappro->getCredit_rappro());
                                                    $rappro->setSolde_rappro($f_rappro->getSolde_rappro() + $sal_alloue);
                                                    $rappro->setSource($f_rappro->getSource());
                                                    $rappro->setSource_credit($f_rappro->getSource_credit());
                                                    $rappro->setCode_smcipn($f_rappro->getCode_smcipn());
                                                    $rappro->setCode_smcipnp($f_rappro->getCode_smcipnp());
                                                    $rappro->setCode_domicilier($f_rappro->getCode_domicilier());
                                                    $rappro->setId_credit($f_rappro->getId_credit());
                                                    $rappro->setType_rappro($f_rappro->getType_rappro());
                                                    //$m_rappro->update($rappro);
                                                    try {
                                                        $m_rappro->update($rappro);
                                                    } catch (Exception $exc) {
                                                        $db->rollback();
                                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                        $this->view->data = $message;
                                                        return;
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        while ($reste > 0) {
                                            $sources->setSortie($sources->getMontant());
                                            $sources->setSolde($sources->getMontant());
                                            $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                                            $tmp_sold = $sources->getMontant_solde();
                                            if ($reste_solde >= 0) {
                                                $sources->setMontant_solde($reste_solde);
                                            } else {
                                                $sources->setMontant_solde(0);
                                            }
                                            //$smc_mapper->update($sources);
                                            try {
                                                $smc_mapper->update($sources);
                                            } catch (Exception $exc) {
                                                $db->rollback();
                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                $this->view->data = $message;
                                                return;
                                            }
                                            //Enregistrement dans la table eu_utiliser
                                            $count = $muti->findConuter() + 1;
                                            $uti->setId_utiliser($count);
                                            $uti->setId_smc($sources->getId_smc());
                                            $uti->setCode_smcipn($sm->getCode_smcipn());
                                            $uti->setCode_smcipnp(null);
                                            $uti->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                            $uti->setMontant_allouer($tmp_sold);
                                            if ($tmp_sold > 0) {
                                                try {
                                                    $muti->save($uti);
                                                } catch (Exception $exc) {
                                                    $this->view->data = 'allocs';
                                                    $db->rollback();
                                                    return;
                                                }
                                                //Recherche du code_credit dans la table de rapprochement
                                                $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                                if ($res != null) {
                                                    //Mise à jour dans la table de rapprochement
                                                    $rappro->setId_rappro($res->getId_rappro());
                                                    $rappro->setDebit_rappro($res->getDebit_rappro());
                                                    $rappro->setCredit_rappro($res->getCredit_rappro() + $tmp_sold);
                                                    $rappro->setSolde_rappro($res->getSolde_rappro() - $tmp_sold);
                                                    $rappro->setSource($res->getSource());
                                                    $rappro->setSource_credit($res->getSource_credit());
                                                    $rappro->setCode_smcipn($res->getCode_smcipn());
                                                    $rappro->setCode_smcipnp($res->getCode_smcipnp());
                                                    $rappro->setCode_domicilier($res->getCode_domicilier());
                                                    $rappro->setId_credit($res->getId_credit());
                                                    $rappro->setType_rappro($res->getType_rappro());
                                                    //$m_rappro->update($rappro);
                                                    try {
                                                        $m_rappro->update($rappro);
                                                    } catch (Exception $exc) {
                                                        $db->rollback();
                                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                        $this->view->data = $message;
                                                        return;
                                                    }
                                                } else {
                                                    //Cas de l'allocation périodique de salaire:Ligne de rappro déjà créée
                                                    $f_rappro = $m_rappro->findBySmcipnSource($sm->getCode_smcipn(), $sources->getSource_credit(), $sources->getId_credit());
                                                    if ($f_rappro == null) {
                                                        //Enregistrement dans la table de rapprochement
                                                        $rappro->setDebit_rappro($sal_alloue);
                                                        $rappro->setCredit_rappro(0);
                                                        $rappro->setSolde_rappro($sal_alloue);
                                                        $rappro->setSource('smc');
                                                        $rappro->setSource_credit($sources->getSource_credit());
                                                        $rappro->setCode_smcipn($sm->getCode_smcipn());
                                                        $rappro->setCode_smcipnp(null);
                                                        $rappro->setCode_domicilier(null);
                                                        $rappro->setId_credit($sources->getId_credit());
                                                        $rappro->setType_rappro(null);
                                                        //$m_rappro->save($rappro);
                                                        try {
                                                            $m_rappro->save($rappro);
                                                        } catch (Exception $exc) {
                                                            $db->rollback();
                                                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                            $this->view->data = $message;
                                                            return;
                                                        }
                                                    } else {
                                                        //Mise à jour dans la table de rapprochement
                                                        $rappro->setId_rappro($f_rappro->getId_rappro());
                                                        $rappro->setDebit_rappro($f_rappro->getDebit_rappro() + $sal_alloue);
                                                        $rappro->setCredit_rappro($f_rappro->getCredit_rappro());
                                                        $rappro->setSolde_rappro($f_rappro->getSolde_rappro() + $sal_alloue);
                                                        $rappro->setSource($f_rappro->getSource());
                                                        $rappro->setSource_credit($f_rappro->getSource_credit());
                                                        $rappro->setCode_smcipn($f_rappro->getCode_smcipn());
                                                        $rappro->setCode_smcipnp($f_rappro->getCode_smcipnp());
                                                        $rappro->setCode_domicilier($f_rappro->getCode_domicilier());
                                                        $rappro->setId_credit($f_rappro->getId_credit());
                                                        $rappro->setType_rappro($res->getType_rappro());
                                                        //$m_rappro->update($rappro);
                                                        try {
                                                            $m_rappro->update($rappro);
                                                        } catch (Exception $exc) {
                                                            $db->rollback();
                                                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                            $this->view->data = $message;
                                                            return;
                                                        }
                                                    }
                                                }
                                            }

                                            $i = $i + 1;
                                            $sources = $smc[$i];
                                            $reste = $reste - $sources->getMontant();
                                            if ($reste <= 0) {
                                                $sortie = $sources->getMontant() - abs($reste);
                                                $sources->setSortie($sortie);
                                                $sources->setSolde($sortie);
                                                $reste_solde = $sources->getMontant_solde() - $sortie;
                                                if ($reste_solde >= 0) {
                                                    $sources->setMontant_solde($reste_solde);
                                                } else {
                                                    $sources->setMontant_solde(0);
                                                }
                                                //$smc_mapper->update($sources);
                                                try {
                                                    $smc_mapper->update($sources);
                                                } catch (Exception $exc) {
                                                    $db->rollback();
                                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                    $this->view->data = $message;
                                                    return;
                                                }
                                                //Enregistrement dans la table eu_utiliser
                                                $count = $muti->findConuter() + 1;
                                                $uti->setId_utiliser($count);
                                                $uti->setId_smc($sources->getId_smc());
                                                $uti->setCode_smcipn($sm->getCode_smcipn());
                                                $uti->setCode_smcipnp(null);
                                                $uti->setDate_creation($date_deb->toString('yyyy-mm-dd'));
                                                $uti->setMontant_allouer($sortie);
                                                if ($sortie > 0) {
                                                    try {
                                                        $muti->save($uti);
                                                    } catch (Exception $exc) {
                                                        $this->view->data = 'allocs';
                                                        $db->rollback();
                                                        return;
                                                    }
                                                    //Recherche du code_credit dans la table de rapprochement
                                                    $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                                    if ($res != null) {
                                                        //Mise à jour dans la table de rapprochement
                                                        $rappro->setId_rappro($res->getId_rappro());
                                                        $rappro->setDebit_rappro($res->getDebit_rappro());
                                                        $rappro->setCredit_rappro($res->getCredit_rappro() + $sortie);
                                                        $rappro->setSolde_rappro($res->getSolde_rappro() - $sortie);
                                                        $rappro->setSource($res->getSource());
                                                        $rappro->setSource_credit($res->getSource_credit());
                                                        $rappro->setCode_smcipn($res->getCode_smcipn());
                                                        $rappro->setCode_smcipnp($res->getCode_smcipnp());
                                                        $rappro->setCode_domicilier($res->getCode_domicilier());
                                                        $rappro->setId_credit($res->getId_credit());
                                                        $rappro->setType_rappro($res->getType_rappro());
                                                        //$m_rappro->update($rappro);
                                                        try {
                                                            $m_rappro->update($rappro);
                                                        } catch (Exception $exc) {
                                                            $db->rollback();
                                                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                            $this->view->data = $message;
                                                            return;
                                                        }
                                                    } else {
                                                        //Cas de l'allocation périodique de salaire:Ligne de rappro déjà créée
                                                        $f_rappro = $m_rappro->findBySmcipnSource($sm->getCode_smcipn(), $sources->getSource_credit(), $sources->getId_credit());
                                                        if ($f_rappro == null) {
                                                            //Enregistrement dans la table de rapprochement
                                                            $rappro->setDebit_rappro($sal_alloue);
                                                            $rappro->setCredit_rappro(0);
                                                            $rappro->setSolde_rappro($sal_alloue);
                                                            $rappro->setSource('smc');
                                                            $rappro->setSource_credit($sources->getSource_credit());
                                                            $rappro->setCode_smcipn($sm->getCode_smcipn());
                                                            $rappro->setCode_smcipnp(null);
                                                            $rappro->setCode_domicilier(null);
                                                            $rappro->setId_credit($sources->getId_credit());
                                                            $rappro->setType_rappro(null);
                                                            //$m_rappro->save($rappro);
                                                            try {
                                                                $m_rappro->save($rappro);
                                                            } catch (Exception $exc) {
                                                                $db->rollback();
                                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                                $this->view->data = $message;
                                                                return;
                                                            }
                                                        } else {
                                                            //Mise à jour dans la table de rapprochement
                                                            $rappro->setId_rappro($f_rappro->getId_rappro());
                                                            $rappro->setDebit_rappro($f_rappro->getDebit_rappro() + $sal_alloue);
                                                            $rappro->setCredit_rappro($f_rappro->getCredit_rappro());
                                                            $rappro->setSolde_rappro($f_rappro->getSolde_rappro() + $sal_alloue);
                                                            $rappro->setSource($f_rappro->getSource());
                                                            $rappro->setSource_credit($f_rappro->getSource_credit());
                                                            $rappro->setCode_smcipn($f_rappro->getCode_smcipn());
                                                            $rappro->setCode_smcipnp($f_rappro->getCode_smcipnp());
                                                            $rappro->setCode_domicilier($f_rappro->getCode_domicilier());
                                                            $rappro->setId_credit($f_rappro->getId_credit());
                                                            $rappro->setType_rappro($f_rappro->getType_rappro());
                                                            //$m_rappro->update($rappro);
                                                            try {
                                                                $m_rappro->update($rappro);
                                                            } catch (Exception $exc) {
                                                                $db->rollback();
                                                                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                                                                $this->view->data = $message;
                                                                return;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
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
                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                    $this->view->message = $message;
                    $this->view->data = 'echec';
                }
            }
        }
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

    //####### Gestion smcipnp #########"
    public function smcipnpgeneAction() {
        $this->_helper->layout->disableLayout();
    }

    public function listgenesmcipnpAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_smcipnp');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipnp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->where('eu_smcipnp.etat_smcipnp = ?', 0)
                ->order('eu_smcipnp.date_smcipnp', 'desc');
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
        $totsmcipnp = 0;
        $nom_acteur = '';
        foreach ($smcipnp as $row) {
            $type_acteur = $row->source_smcipnp;
            $code_acteur = $row->code_acteur;
            $code_membre = $row->code_membre;
            if ($type_acteur == 'gac') {
                $acteur = 'gac centrale';
                $mgac = new Application_Model_EuGacMapper();
                $gac = new Application_Model_EuGac();
                $find_gac = $mgac->find($code_acteur, $gac);
                if ($find_gac) {
                    $nom_acteur = $gac->getNom_gac();
                }
            } elseif ($type_acteur == 'filiere') {
                $acteur = 'gac filière';
                $mfil = new Application_Model_EuGacFiliereMapper();
                $fil = new Application_Model_EuGacFiliere();
                $find_fil = $mfil->find($code_acteur, $fil);
                if ($find_fil) {
                    $nom_acteur = $fil->getNom_gac_filiere();
                }
            } elseif ($type_acteur == 'creneau') {
                $acteur = 'Créneau d\'activités';
                $mcre = new Application_Model_EuCreneauMapper();
                $cre = new Application_Model_EuCreneau();
                $find_cre = $mcre->find($code_acteur, $cre);
                if ($find_cre) {
                    $nom_acteur = $cre->getNom_creneau();
                }
            } elseif ($type_acteur == 'acteur') {
                $acteur = 'Acteur créneau';
                $mact = new Application_Model_EuActeurCreneauMapper();
                $act = new Application_Model_EuActeurCreneau();
                $find_act = $mact->find($code_acteur, $act);
                if ($find_act) {
                    $nom_acteur = $act->getNom_acteur();
                }
            } elseif ($type_acteur == 'acnev') {
                $acteur = 'Acteur créneau';
                $mmemb = new Application_Model_EuMembreMapper();
                $memb = new Application_Model_EuMembre();
                $find_memb = $mmemb->find($code_membre, $memb);
                if ($find_memb) {
                    $nom_acteur = $memb->getRaison_sociale();
                }
            }
            $totsmcipnp+=$row->montant_smcipnp;
            $date_dem = new Zend_Date($row->date_smcipnp, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipnp;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipnp,
                ucfirst($row->lib_smcipnp),
                $row->code_membre,
                $row->montant_smcipnp,
                $acteur,
                ucfirst($nom_acteur),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $responce['userdata']['code_membre'] = 'Totaux:';
        $responce['userdata']['mt_smcipnp'] = $totsmcipnp;
        $this->view->data = $responce;
    }

    public function detailsmcipnpAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_smcipnp = $request->code_smcipnp;
        //Informations sur la smcipnp
        $tabel = new Application_Model_DbTable_EuSmcipnp();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->where('eu_smcipnp.etat_smcipnp = ?', 0)
                ->where('eu_smcipnp.code_smcipnp = ?', $code_smcipnp)
                ->order('eu_smcipnp.date_smcipnp', 'desc');
        $smc = $tabel->fetchAll($sel);
        $this->view->smcipnp = $smc[0];
        //Informations sur la domiciliation
        $table = new Application_Model_DbTable_EuDomiciliation();
        $dom = $table->select();
        $dom->where('eu_domiciliation.code_smcipnp = ?', $code_smcipnp);
        $domi = $table->fetchAll($dom);
        if (count($domi) == 1) {
            $this->view->domici = $domi[0];
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
            $mapper->find($domi[0]->code_membre_beneficiaire, $membre);
            $this->view->benef = $membre;
            $membre1 = new Application_Model_EuMembre();
            $mapper->find($domi[0]->code_membre_assureur, $membre1);
            $this->view->ass = $membre1;
        }
    }

    public function detailoksmcipnpAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $code_smcipnp = $request->code_smcipnp;
        //Informations sur la smcipnp
        $tabel = new Application_Model_DbTable_EuSmcipnp();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->where('eu_smcipnp.etat_smcipnp = ?', 1)
                ->where('eu_smcipnp.code_smcipnp = ?', $code_smcipnp)
                ->order('eu_smcipnp.date_smcipnp', 'desc');
        $smc = $tabel->fetchAll($sel);
        $this->view->smcipnp = $smc[0];
        //Informations sur la domiciliation
        $table = new Application_Model_DbTable_EuDomiciliation();
        $dom = $table->select();
        $dom->where('eu_domiciliation.code_smcipnp = ?', $code_smcipnp);
        $domi = $table->fetchAll($dom);
        if (count($domi) == 1) {
            $this->view->domici = $domi[0];
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
            $mapper->find($domi[0]->code_membre_beneficiaire, $membre);
            $this->view->benef = $membre;
            $membre1 = new Application_Model_EuMembre();
            $mapper->find($domi[0]->code_membre_assureur, $membre1);
            $this->view->ass = $membre1;
        }
    }

    public function listcreditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 30);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $code_domici = $_GET['code_domici'];
        $tabela = new Application_Model_DbTable_EuDetailDomicilie();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('d' => 'eu_detail_domicilie'), array('code_membre', 'mont' => 'montANT_CREDIT'))
                ->join(array('c' => 'eu_compte_credit'), 'c.id_credit = d.id_credit', array('code_produit', 'montant_place', 'montant_credit', 'compte_source', 'date_octroi', 'id_credit'))
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
                $mt_credit = round($row->montant_place * $prk / $pck);
            } else {
                $mt_credit = $row->montant_credit + $row->mont;
            }
            $date_fin = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $row->code_produit,
                $row->montant_place,
                $mt_credit,
                $row->mont,
                $date_fin->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

//    public function allouersmcipnpAction() {
//        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
//        $code_smcipnp = $_GET['lignes'];
//        $msmcipnp = new Application_Model_EuSmcipnpMapper();
//        $smcipnp = new Application_Model_EuSmcipnp();
//        $rappro = new Application_Model_EuRapprochement();
//        $m_rappro = new Application_Model_EuRapprochementMapper();
//        $gcsc = new Application_Model_EuGcsc();
//        $m_gcsc = new Application_Model_EuGcscMapper();
//        $compte = new Application_Model_EuCompte();
//        $cm_mapper = new Application_Model_EuCompteMapper();
//        $muti = new Application_Model_EuUtiliserMapper();
//        $uti = new Application_Model_EuUtiliser();
//        $sources = new Application_Model_EuSmc();
//        $smc_mapper = new Application_Model_EuSmcMapper();
//
//        if ($code_smcipnp != '') {
//            //Récupération des informations de la smcipnp
//            $find_pnp = $msmcipnp->find($code_smcipnp, $smcipnp);
//            if ($find_pnp) {
//                $mt_smcipnp = $smcipnp->getMontant_smcipnp();
//            }
//            //Récupération et contôle du montant du cncs disponible à la source smc
//            $somme_smc = $smc_mapper->getSumSMC();
//            if ($somme_smc < $mt_smcipnp) {
//                $this->view->data = 'sal';
//                return;
//            } else {
//                $db = Zend_Db_Table::getDefaultAdapter();
//                $db->beginTransaction();
//                try {
//                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
//                    $date_alloc = clone $date_fin;
//                    //Récupération des informations de la smcipnp
//                    $find_pnp = $msmcipnp->find($code_smcipnp, $smcipnp);
//                    //Mise à jour de la table smcipnp
//                    $smcipnp->setDate_alloc($date_alloc->toString('yyyy-mm-dd'));
//                    $smcipnp->setEtat_smcipnp(1);
//                    try {
//                        $msmcipnp->update($smcipnp);
//                    } catch (Exception $exc) {
//                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
//                        $this->view->data = $message;
//                        return;
//                    }
//                    //Récupération du numéro membre de l'acnev
//                    $muser = new Application_Model_EuUtilisateurMapper();
//                    $utilisateur = new Application_Model_EuUtilisateur();
//                    $num_ass = '';
//                    $code_domi = '';
//                    $find_user = $muser->find($smcipnp->getId_utilisateur(), $utilisateur);
//                    if ($find_user == true) {
//                        $num_ass = $utilisateur->getCode_membre();
//                    }
//                    //Récupération du code de la domiciliation
//                    $mdomi = new Application_Model_EuDomiciliationMapper();
//                    $find_domi = $mdomi->findBySmcipnp($code_smcipnp);
//                    if ($find_domi != null) {
//                        $code_domi = $find_domi->getCode_domicilier();
//                    }
//                    //Création du compte de subvention tpa pour l'entrepôt d'achat
//                    $cat_compte = 'tpasmcp';
//                    $num_comptes = 'nr-' . $cat_compte . '-' . $num_ass;
//                    $sal_alloue = $smcipnp->getMontant_smcipnp();
//                    $result = $cm_mapper->find($num_comptes, $compte);
//                    if ($result == false) {
//                        $compte->setCode_membre($num_ass)
//                                ->setCode_cat($cat_compte)
//                                ->setDesactiver(0)
//                                ->setCode_type_compte('nr')
//                                ->setSolde($sal_alloue)
//                                ->setDate_alloc($date_alloc->toString('yyyy-mm-dd'))
//                                ->setCode_compte($num_comptes)
//                                ->setLib_compte($cat_compte);
//                        $cm_mapper->save($compte);
//                    } else {
//                        $compte->setSolde($compte->getSolde() + $sal_alloue);
//                        $cm_mapper->update($compte);
//                    }
//                    //Enregistrement de la smcipnp dans la table gcsc
//                    $find_gcsc = $m_gcsc->findByDomicilie($code_domi);
//                    if ($find_gcsc != null) {
//                        $m_gcsc->find($find_gcsc->getId_gcsc(), $gcsc);
//                        $gcsc->setDebit($sal_alloue);
//                        $gcsc->setCredit($find_gcsc->getCredit());
//                        $gcsc->setSolde($find_gcsc->getSolde() - $sal_alloue);
//                        $gcsc->setCode_smcipn($find_gcsc->getCode_smcipn());
//                        $gcsc->setCode_smcipnp($code_smcipnp);
//                        $m_gcsc->update($gcsc);
//                    } else {
//                        $gcsc->setCode_membre($smcipnp->getCode_membre());
//                        $gcsc->setDebit($sal_alloue);
//                        $gcsc->setCredit(0);
//                        $gcsc->setSolde($sal_alloue);
//                        $gcsc->setCode_smcipn(null);
//                        $gcsc->setCode_smcipnp($code_smcipnp);
//                        $m_gcsc->save($gcsc);
//                    }
//                    //####Récupération des comptes de la source smc et traitement####
//                    //Recherche du code de la domiciliation dans la table smc
//                    $find_smc = $smc_mapper->findByDomiciliation($code_domi);
//                    //##Cas des smcipnp sans domiciliation
//                    if ($find_smc == false) {
//                        $smc = $smc_mapper->findBySmcipnp($code_smcipnp);
//                        if ($smc == false) {
//                            $this->view->data = 'sal1';
//                            return;
//                        } elseif (count($smc) == 1) {
//                            $sources = $smc[0];
//                            $out = $sources->getSortie() + $sal_alloue;
//                            $sources->setSortie($out);
//                            $sources->setSolde($out);
//                            $reste_solde = $sources->getMontant_solde() - $sal_alloue;
//                            if ($reste_solde >= 0) {
//                                $sources->setMontant_solde($reste_solde);
//                            } else {
//                                $sources->setMontant_solde(0);
//                            }
//                            $smc_mapper->update($sources);
//                            //Enregistrement dans la table eu_utiliser
//                            $count = $muti->findConuter() + 1;
//                            $uti->setId_utiliser($count);
//                            $uti->setId_smc($sources->getId_smc());
//                            $uti->setCode_smcipn(null);
//                            $uti->setCode_smcipnp($code_smcipnp);
//                            $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
//                            $uti->setMontant_allouer($sal_alloue);
//                            if ($sal_alloue > 0) {
//                                try {
//                                    $muti->save($uti);
//                                } catch (Exception $exc) {
//                                    $this->view->data = 'allocs';
//                                    return;
//                                }
//                                if ($sources->getSource_credit() == null) {
//                                    $source_credit = '';
//                                }
//                                if ($sources->getId_credit() == null) {
//                                    $id_credit = '';
//                                }
//                                //Recherche du code_credit dans la table rapprochement
//                                //$res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
//                                try {
//                                    $res = $m_rappro->findBySmcipnSource2($code_domi, $source_credit, $id_credit);
//                                } catch (Exception $exc) {
//                                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
//                                    $this->view->data = $message;
//                                    return;
//                                }
//                                if ($res != null) {
//                                    //Mise à jour dans la table de rapprochement
//                                    $rappro->setId_rappro($res->getId_rappro());
//                                    $rappro->setDebit_rappro($res->getDebit_rappro() + $sal_alloue);
//                                    $rappro->setCredit_rappro($res->getCredit_rappro());
//                                    $rappro->setSolde_rappro($res->getSolde_rappro() - $sal_alloue);
//                                    $rappro->setSource($res->getSource());
//                                    $rappro->setSource_credit($res->getSource_credit());
//                                    $rappro->setCode_smcipn($res->getCode_smcipn());
//                                    $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                    $rappro->setCode_domicilier($res->getCode_domicilier());
//                                    $rappro->setId_credit($res->getId_credit());
//                                    $rappro->setType_rappro($res->getType_rappro());
//                                    //$m_rappro->update($rappro);
//                                    try {
//                                        $m_rappro->update($rappro);
//                                    } catch (Exception $exc) {
//                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
//                                        $this->view->data = $message;
//                                        return;
//                                    }
//                                } else {
//                                    //Enregistrement dans la table de rapprochement
//                                    $rappro->setDebit_rappro($sal_alloue);
//                                    $rappro->setCredit_rappro(0);
//                                    $rappro->setSolde_rappro($sal_alloue);
//                                    $rappro->setSource('smc');
//                                    $rappro->setSource_credit($sources->getSource_credit());
//                                    $rappro->setCode_smcipn(null);
//                                    $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                    $rappro->setCode_domicilier(null);
//                                    $rappro->setId_credit($sources->getId_credit());
//                                    $rappro->setType_rappro(null);
//                                    //$m_rappro->save($rappro);
//                                    try {
//                                        $m_rappro->save($rappro);
//                                    } catch (Exception $exc) {
//                                        $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
//                                        $this->view->data = $message;
//                                        return;
//                                    }
//                                }
//                            }
//                        }
//                    } else {//##Cas des demandes de la smcipnp avec domiciliation
//                        if (count($find_smc) == 1) {
//                            $sources = $find_smc[0];
//                            if ($sources->getMontant_solde() < $sal_alloue) {
//                                $this->view->data = 'no_sal1';
//                                return;
//                            } else {
//                                $out = $sources->getSortie() + $sal_alloue;
//                                $sources->setSortie($out);
//                                $sources->setSolde($out);
//                                $reste_solde = $sources->getMontant_solde() - $sal_alloue;
//                                if ($reste_solde >= 0) {
//                                    $sources->setMontant_solde($reste_solde);
//                                } else {
//                                    $sources->setMontant_solde(0);
//                                }
//                                $smc_mapper->update($sources);
//                                //Enregistrement dans la table eu_utiliser
//                                $count = $muti->findConuter() + 1;
//                                $uti->setId_utiliser($count);
//                                $uti->setId_smc($sources->getId_smc());
//                                $uti->setCode_smcipn(null);
//                                $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
//                                $uti->setMontant_allouer($sal_alloue);
//                                if ($sal_alloue > 0) {
//                                    try {
//                                        $muti->save($uti);
//                                    } catch (Exception $exc) {
//                                        $this->view->data = 'allocs';
//                                        return;
//                                    }
//                                    //Recherche du code_credit dans la table rapprochement
//                                    $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
//                                    if ($res != null) {
//                                        //Mise à jour dans la table de rapprochement
//                                        $rappro->setId_rappro($res->getId_rappro());
//                                        $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
//                                        $rappro->setCredit_rappro($res->getCredit_rappro());
//                                        $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
//                                        $rappro->setSource($res->getSource());
//                                        $rappro->setSource_credit($res->getSource_credit());
//                                        $rappro->setCode_smcipn($res->getCode_smcipn());
//                                        $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                        $rappro->setCode_domicilier($res->getCode_domicilier());
//                                        $rappro->setId_credit($res->getId_credit());
//                                        $rappro->setType_rappro($res->getType_rappro());
//                                        $m_rappro->update($rappro);
//                                    } else {
//                                        //Enregistrement dans la table de rapprochement
//                                        $rappro->setDebit_rappro($sources->getMontant());
//                                        $rappro->setCredit_rappro(0);
//                                        $rappro->setSolde_rappro($sources->getMontant());
//                                        $rappro->setSource('smc');
//                                        $rappro->setSource_credit($sources->getSource_credit());
//                                        $rappro->setCode_smcipn(null);
//                                        $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                        $rappro->setCode_domicilier(null);
//                                        $rappro->setId_credit($sources->getId_credit());
//                                        $rappro->setType_rappro(null);
//                                        $m_rappro->save($rappro);
//                                    }
//                                }
//                            }
//                        } elseif (count($find_smc) > 1) {
//                            //Calcul du cumul des soldes de la domiciliation
//                            $tot_sal = 0;
//                            for ($j = 0; $j < count($find_smc); $j++) {
//                                $tot_sal += $find_smc[$j]->getMontant_solde();
//                            }
//                            if ($tot_sal < $sal_alloue) {
//                                $this->view->data = $tot_sal;
//                                return;
//                            } else {
//                                $i = 0;
//                                $sources = $find_smc[$i];
//                                $reste = ($sal_alloue + $sources->getSortie()) - $sources->getMontant();
//                                if ($reste <= 0) {
//                                    $salaire = $sources->getSortie() + $sal_alloue;
//                                    $sources->setSortie($salaire);
//                                    $sources->setSolde($salaire);
//                                    $reste_solde = $sources->getMontant_solde() - $sal_alloue;
//                                    if ($reste_solde >= 0) {
//                                        $sources->setMontant_solde($reste_solde);
//                                    } else {
//                                        $sources->setMontant_solde(0);
//                                    }
//                                    $smc_mapper->update($sources);
//                                    //Enregistrement dans la table eu_utiliser
//                                    $count = $muti->findConuter() + 1;
//                                    $uti->setId_utiliser($count);
//                                    $uti->setId_smc($sources->getId_smc());
//                                    $uti->setCode_smcipn(null);
//                                    $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                    $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
//                                    $uti->setMontant_allouer($sal_alloue);
//                                    if ($sal_alloue > 0) {
//                                        try {
//                                            $muti->save($uti);
//                                        } catch (Exception $exc) {
//                                            $this->view->data = 'allocs';
//                                            return;
//                                        }
//                                        //Recherche du code_credit dans la table de rapprochement
//                                        $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
//                                        if ($res != null) {
//                                            //Mise à jour dans la table de rapprochement
//                                            $rappro->setId_rappro($res->getId_rappro());
//                                            $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
//                                            $rappro->setCredit_rappro($res->getCredit_rappro());
//                                            $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
//                                            $rappro->setSource($res->getSource());
//                                            $rappro->setSource_credit($res->getSource_credit());
//                                            $rappro->setCode_smcipn($res->getCode_smcipn());
//                                            $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                            $rappro->setCode_domicilier($res->getCode_domicilier());
//                                            $rappro->setId_credit($res->getId_credit());
//                                            $rappro->setType_rappro($res->getType_rappro());
//                                            $m_rappro->update($rappro);
//                                        } else {
//                                            //Enregistrement dans la table de rapprochement
//                                            $rappro->setDebit_rappro($sources->getMontant());
//                                            $rappro->setCredit_rappro(0);
//                                            $rappro->setSolde_rappro($sources->getMontant());
//                                            $rappro->setSource('smc');
//                                            $rappro->setSource_credit($sources->getSource_credit());
//                                            $rappro->setCode_smcipn(null);
//                                            $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                            $rappro->setCode_domicilier(null);
//                                            $rappro->setId_credit($sources->getId_credit());
//                                            $rappro->setType_rappro(null);
//                                            $m_rappro->save($rappro);
//                                        }
//                                    }
//                                } else {
//                                    while ($reste > 0) {
//                                        $sources->setSortie($sources->getMontant());
//                                        $sources->setSolde($sources->getMontant());
//                                        $reste_solde = $sources->getMontant_solde() - $sal_alloue;
//                                        $tmp_sold = $sources->getMontant_solde();
//                                        if ($reste_solde >= 0) {
//                                            $sources->setMontant_solde($reste_solde);
//                                        } else {
//                                            $sources->setMontant_solde(0);
//                                        }
//                                        $smc_mapper->update($sources);
//                                        //Enregistrement dans la table eu_utiliser
//                                        $count = $muti->findConuter() + 1;
//                                        $uti->setId_utiliser($count);
//                                        $uti->setId_smc($sources->getId_smc());
//                                        $uti->setCode_smcipn(null);
//                                        $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                        $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
//                                        $uti->setMontant_allouer($tmp_sold);
//                                        if ($tmp_sold > 0) {
//                                            try {
//                                                $muti->save($uti);
//                                            } catch (Exception $exc) {
//                                                $this->view->data = 'allocs';
//                                                return;
//                                            }
//                                            //Recherche du code_credit dans la table de rapprochement
//                                            $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
//                                            if ($res != null) {
//                                                //Mise à jour dans la table de rapprochement
//                                                $rappro->setId_rappro($res->getId_rappro());
//                                                $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
//                                                $rappro->setCredit_rappro($res->getCredit_rappro());
//                                                $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
//                                                $rappro->setSource($res->getSource());
//                                                $rappro->setSource_credit($res->getSource_credit());
//                                                $rappro->setCode_smcipn($res->getCode_smcipn());
//                                                $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                                $rappro->setCode_domicilier($res->getCode_domicilier());
//                                                $rappro->setId_credit($res->getId_credit());
//                                                $rappro->setType_rappro($res->getType_rappro());
//                                                $m_rappro->update($rappro);
//                                            } else {
//                                                //Enregistrement dans la table de rapprochement
//                                                $rappro->setDebit_rappro($sources->getMontant());
//                                                $rappro->setCredit_rappro(0);
//                                                $rappro->setSolde_rappro($sources->getMontant());
//                                                $rappro->setSource('smc');
//                                                $rappro->setSource_credit($sources->getSource_credit());
//                                                $rappro->setCode_smcipn(null);
//                                                $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                                $rappro->setCode_domicilier(null);
//                                                $rappro->setId_credit($sources->getId_credit());
//                                                $rappro->setType_rappro(null);
//                                                $m_rappro->save($rappro);
//                                            }
//                                        }
//
//                                        $i = $i + 1;
//                                        $sources = $find_smc[$i];
//                                        $reste = $reste - $sources->getMontant();
//                                        if ($reste <= 0) {
//                                            $sortie = $sources->getMontant() - abs($reste);
//                                            $sources->setSortie($sortie);
//                                            $sources->setSolde($sortie);
//                                            $reste_solde = $sources->getMontant_solde() - $sortie;
//                                            if ($reste_solde >= 0) {
//                                                $sources->setMontant_solde($reste_solde);
//                                            } else {
//                                                $sources->setMontant_solde(0);
//                                            }
//                                            $smc_mapper->update($sources);
//                                            //Enregistrement dans la table eu_utiliser
//                                            $count = $muti->findConuter() + 1;
//                                            $uti->setId_utiliser($count);
//                                            $uti->setId_smc($sources->getId_smc());
//                                            $uti->setCode_smcipn(null);
//                                            $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                            $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
//                                            $uti->setMontant_allouer($sortie);
//                                            if ($sortie > 0) {
//                                                try {
//                                                    $muti->save($uti);
//                                                } catch (Exception $exc) {
//                                                    $this->view->data = 'allocs';
//                                                    return;
//                                                }
//                                                //Recherche du code_credit dans la table de rapprochement
//                                                $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
//                                                if ($res != null) {
//                                                    //Mise à jour dans la table de rapprochement
//                                                    $rappro->setId_rappro($res->getId_rappro());
//                                                    $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
//                                                    $rappro->setCredit_rappro($res->getCredit_rappro());
//                                                    $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
//                                                    $rappro->setSource($res->getSource());
//                                                    $rappro->setSource_credit($res->getSource_credit());
//                                                    $rappro->setCode_smcipn($res->getCode_smcipn());
//                                                    $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                                    $rappro->setCode_domicilier($res->getCode_domicilier());
//                                                    $rappro->setId_credit($res->getId_credit());
//                                                    $rappro->setType_rappro($res->getType_rappro());
//                                                    $m_rappro->update($rappro);
//                                                } else {
//                                                    //Enregistrement dans la table de rapprochement
//                                                    $rappro->setDebit_rappro($sources->getMontant());
//                                                    $rappro->setCredit_rappro(0);
//                                                    $rappro->setSolde_rappro($sources->getMontant());
//                                                    $rappro->setSource('smc');
//                                                    $rappro->setSource_credit($sources->getSource_credit());
//                                                    $rappro->setCode_smcipn(null);
//                                                    $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
//                                                    $rappro->setCode_domicilier(null);
//                                                    $rappro->setId_credit($sources->getId_credit());
//                                                    $rappro->setType_rappro(null);
//                                                    $m_rappro->save($rappro);
//                                                }
//                                            }
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
//                    //###########Traitements généraux#############
//                    //####Traitement du salaire de la smcipnp#### 
//                    $code_cat = 'CNCSr';
//                    //Ajout dans la table opération
//                    $alloc = new Application_Model_EuOperation();
//                    $alloc->setDate_op($date_alloc->toString('yyyy-mm-dd'));
//                    $alloc->setHeure_op($date_alloc->toString('hh:mm'));
//                    $alloc->setMontant_op($sal_alloue);
//                    $alloc->setCode_membre($num_ass);
//                    $alloc->setCode_produit($code_cat);
//                    $alloc->setId_utilisateur($user->id_utilisateur);
//                    $alloc->setLib_op('Allocation de la smcipnp');
//                    $alloc->setCode_cat('tpasmcp');
//                    $alloc->setType_op('asmcipnp');
//                    $mapper = new Application_Model_EuOperationMapper();
//                    $mapper->save($alloc);
//
//                    $db->commit();
//                    $this->view->data = 'good';
//                    return;
//                } catch (Exception $exc) {
//                    $db->rollback();
//                    return;
//                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage();
//                    $this->view->message = $message;
//                    $this->view->data = 'echec';
//                }
//            }
//        }
//    }

    public function allouersmcipnpAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $code_smcipnp = $_GET['lignes'];
        $msmcipnp = new Application_Model_EuSmcipnpMapper();
        $smcipnp = new Application_Model_EuSmcipnp();
        $rappro = new Application_Model_EuRapprochement();
        $m_rappro = new Application_Model_EuRapprochementMapper();
        $gcsc = new Application_Model_EuGcsc();
        $m_gcsc = new Application_Model_EuGcscMapper();
        $compte = new Application_Model_EuCompte();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $muti = new Application_Model_EuUtiliserMapper();
        $uti = new Application_Model_EuUtiliser();
        $sources = new Application_Model_EuSmc();
        $smc_mapper = new Application_Model_EuSmcMapper();

        if ($code_smcipnp != '') {
            //Récupération des informations de la smcipnp
            $find_pnp = $msmcipnp->find($code_smcipnp, $smcipnp);
            if ($find_pnp) {
                $mt_smcipnp = $smcipnp->getMontant_smcipnp();
            }
            //Récupération et contôle du montant du cncs disponible à la source smc
            $somme_smc = $smc_mapper->getSumSMC();
            if ($somme_smc < $mt_smcipnp) {
                $this->view->data = 'sal';
                return;
            } else {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_alloc = clone $date_fin;
                    //Récupération des informations de la smcipnp
                    $find_pnp = $msmcipnp->find($code_smcipnp, $smcipnp);
                    //Mise à jour de la table smcipnp
                    $smcipnp->setDate_alloc($date_alloc->toString('yyyy-mm-dd'));
                    $smcipnp->setEtat_smcipnp(1);
                    $msmcipnp->update($smcipnp);
                    $mdomi = new Application_Model_EuDomiciliationMapper();
                    $num_ass = '';
                    $code_domi = '';
                    //Récupération du numéro membre de l'entrepôt d'achat
                    $muser = new Application_Model_EuUtilisateurMapper();
                    $utilisateur = new Application_Model_EuUtilisateur();
                    $find_user = $muser->find($smcipnp->getId_utilisateur(), $utilisateur);
                    if ($find_user == true) {
                        $num_ass = $utilisateur->getCode_membre();
                    }
                    $find_domi = $mdomi->findBySmcipnp($code_smcipnp);
                    if ($find_domi != null) {
                        $code_domi = $find_domi->getCode_domicilier();
                    }
                    //Création du compte de subvention tpa pour l'entrepôt d'achat
                    $cat_compte = 'tpasmcp';
                    $num_comptes = 'nr-' . $cat_compte . '-' . $num_ass;
                    $sal_alloue = $smcipnp->getMontant_smcipnp();
                    $result = $cm_mapper->find($num_comptes, $compte);
                    if ($result == false) {
                        $compte->setCode_membre($num_ass)
                                ->setCode_cat($cat_compte)
                                ->setDesactiver(0)
                                ->setCode_type_compte('nr')
                                ->setSolde($sal_alloue)
                                ->setDate_alloc($date_alloc->toString('yyyy-mm-dd'))
                                ->setCode_compte($num_comptes)
                                ->setLib_compte($cat_compte);
                        //$cm_mapper->save($compte);
                        try {
                            $cm_mapper->save($compte);
                        } catch (Exception $exc) {
                            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                            $this->view->data = $message;
                            return;
                        }
                    } else {
                        $compte->setSolde($compte->getSolde() + $sal_alloue);
                        $cm_mapper->update($compte);
                    }
                    //Enregistrement de la smcipnp dans la table gcsc
                    $find_gcsc = $m_gcsc->findByDomicilie($code_domi);
                    if ($find_gcsc != null) {
                        $m_gcsc->find($find_gcsc->getId_gcsc(), $gcsc);
                        $gcsc->setDebit($sal_alloue);
                        $gcsc->setCredit($find_gcsc->getCredit());
                        $gcsc->setSolde($find_gcsc->getSolde() - $sal_alloue);
                        $gcsc->setCode_smcipn($find_gcsc->getCode_smcipn());
                        $gcsc->setCode_smcipnp($code_smcipnp);
                        $m_gcsc->update($gcsc);
                    } else {
                        $gcsc->setCode_membre($num_ass);
                        $gcsc->setDebit($sal_alloue);
                        $gcsc->setCredit(0);
                        $gcsc->setSolde($sal_alloue);
                        $gcsc->setCode_smcipn(null);
                        $gcsc->setCode_smcipnp($code_smcipnp);
                        $m_gcsc->save($gcsc);
                    }
                    //####Récupération des comptes de la source smc et traitement####
                    //Recherche du code de la domiciliation dans la table smc
                    $find_smc = $smc_mapper->findByDomiciliation($code_domi);
                    //##Cas des smcipnp sans domiciliation
                    if ($find_smc == false) {
                        $smc = $smc_mapper->find1();
                        if (!$smc) {
                            $this->view->data = 'sal1';
                            return;
                        } elseif (count($smc) == 1) {
                            $sources = $smc[0];
                            $out = $sources->getSortie() + $sal_alloue;
                            $sources->setSortie($out);
                            $sources->setSolde($out);
                            $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                            if ($reste_solde >= 0) {
                                $sources->setMontant_solde($reste_solde);
                            } else {
                                $sources->setMontant_solde(0);
                            }
                            $smc_mapper->update($sources);
                            //Enregistrement dans la table eu_utiliser
                            $count = $muti->findConuter() + 1;
                            $uti->setId_utiliser($count);
                            $uti->setId_smc($sources->getId_smc());
                            $uti->setCode_smcipn($code_smcipnp);
                            $uti->setCode_smcipnp(null);
                            $uti->setDate_create($date_alloc->toString('yyyy-mm-dd'));
                            $uti->setMontant_allouer($sal_alloue);
                            if ($sal_alloue > 0) {
                                try {
                                    $muti->save($uti);
                                } catch (Exception $exc) {
                                    $this->view->data = 'allocs';
                                    return;
                                }
                                //Recherche du code_credit dans la table rapprochement
                                $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                if ($res != null) {
                                    //Mise à jour dans la table de rapprochement
                                    $rappro->setId_rappro($res->getId_rappro());
                                    $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
                                    $rappro->setCredit_rappro($res->getCredit_rappro());
                                    $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
                                    $rappro->setSource($res->getSource());
                                    $rappro->setSource_credit($res->getSource_credit());
                                    $rappro->setCode_smcipn($res->getCode_smcipn());
                                    $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                    $rappro->setCode_domicilier($res->getCode_domicilier());
                                    $rappro->setId_credit($res->getId_credit());
                                    $rappro->setType_rappro($res->getType_rappro());
                                    $m_rappro->update($rappro);
                                } else {
                                    //Enregistrement dans la table de rapprochement
                                    $rappro->setDebit_rappro($sources->getMontant());
                                    $rappro->setCredit_rappro(0);
                                    $rappro->setSolde_rappro($sources->getMontant());
                                    $rappro->setSource('smc');
                                    $rappro->setSource_credit($sources->getSource_credit());
                                    $rappro->setCode_smcipn(null);
                                    $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                    $rappro->setCode_domicilier(null);
                                    $rappro->setId_credit($sources->getId_credit());
                                    $rappro->setType_rappro(null);
                                    $m_rappro->save($rappro);
                                }
                            }
                        } elseif (count($smc) > 1) {
                            $i = 0;
                            $sources = $smc[$i];
                            $reste = ($sal_alloue + $sources->getSortie()) - $sources->getMontant();
                            if ($reste <= 0) {
                                $salaire = $sources->getSortie() + $sal_alloue;
                                $sources->setSortie($salaire);
                                $sources->setSolde($salaire);
                                $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                                if ($reste_solde >= 0) {
                                    $sources->getMontant_solde($reste_solde);
                                } else {
                                    $sources->getMontant_solde(0);
                                }
                                $smc_mapper->update($sources);
                                //Enregistrement dans la table eu_utiliser
                                $count = $muti->findConuter() + 1;
                                $uti->setId_utiliser($count);
                                $uti->setId_smc($sources->getId_smc());
                                $uti->setCode_smcipn(null);
                                $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
                                $uti->setMontant_allouer($sal_alloue);
                                if ($sal_alloue > 0) {
                                    try {
                                        $muti->save($uti);
                                    } catch (Exception $exc) {
                                        $this->view->data = 'allocs';
                                        return;
                                    }
                                    //Recherche du code_credit dans la table de rapprochement
                                    $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                    if ($res != null) {
                                        //Mise à jour dans la table de rapprochement
                                        $rappro->setId_rappro($res->getId_rappro());
                                        $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
                                        $rappro->setCredit_rappro($res->getCredit_rappro());
                                        $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
                                        $rappro->setSource($res->getSource());
                                        $rappro->setSource_credit($res->getSource_credit());
                                        $rappro->setCode_smcipn($res->getCode_smcipn());
                                        $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                        $rappro->setCode_domicilier($res->getCode_domicilier());
                                        $rappro->setId_credit($res->getId_credit());
                                        $rappro->setType_rappro($res->getType_rappro());
                                        $m_rappro->update($rappro);
                                    } else {
                                        //Enregistrement dans la table de rapprochement
                                        $rappro->setDebit_rappro($sources->getMontant());
                                        $rappro->setCredit_rappro(0);
                                        $rappro->setSolde_rappro($sources->getMontant());
                                        $rappro->setSource('smc');
                                        $rappro->setSource_credit($sources->getSource_credit());
                                        $rappro->setCode_smcipn(null);
                                        $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                        $rappro->setCode_domicilier(null);
                                        $rappro->setId_credit($sources->getId_credit());
                                        $rappro->setType_rappro(null);
                                        $m_rappro->save($rappro);
                                    }
                                }
                            } else {
                                while ($reste > 0) {
                                    $sources->setSortie($sources->getMontant());
                                    $sources->setSolde($sources->getMontant());
                                    $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                                    $tmp_sold = $sources->getMontant_solde();
                                    if ($reste_solde >= 0) {
                                        $sources->setMontant_solde($reste_solde);
                                    } else {
                                        $sources->setMontant_solde(0);
                                    }
                                    $smc_mapper->update($sources);
                                    //Enregistrement dans la table eu_utiliser
                                    $count = $muti->findConuter() + 1;
                                    $uti->setId_utiliser($count);
                                    $uti->setId_smc($sources->getId_smc());
                                    $uti->setCode_smcipn(null);
                                    $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                    $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
                                    $uti->setMontant_allouer($tmp_sold);
                                    if ($tmp_sold > 0) {
                                        try {
                                            $muti->save($uti);
                                        } catch (Exception $exc) {
                                            $this->view->data = 'allocs';
                                            return;
                                        }
                                        //Recherche du code_credit dans la table de rapprochement
                                        $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                        if ($res != null) {
                                            //Mise à jour dans la table de rapprochement
                                            $rappro->setId_rappro($res->getId_rappro());
                                            $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
                                            $rappro->setCredit_rappro($res->getCredit_rappro());
                                            $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
                                            $rappro->setSource($res->getSource());
                                            $rappro->setSource_credit($res->getSource_credit());
                                            $rappro->setCode_smcipn($res->getCode_smcipn());
                                            $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                            $rappro->setCode_domicilier($res->getCode_domicilier());
                                            $rappro->setId_credit($res->getId_credit());
                                            $rappro->setType_rappro($res->getType_rappro());
                                            $m_rappro->update($rappro);
                                        } else {
                                            //Enregistrement dans la table de rapprochement
                                            $rappro->setDebit_rappro($sources->getMontant());
                                            $rappro->setCredit_rappro(0);
                                            $rappro->setSolde_rappro($sources->getMontant());
                                            $rappro->setSource('smc');
                                            $rappro->setSource_credit($sources->getSource_credit());
                                            $rappro->setCode_smcipn(null);
                                            $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                            $rappro->setCode_domicilier(null);
                                            $rappro->setId_credit($sources->getId_credit());
                                            $rappro->setType_rappro(null);
                                            $m_rappro->save($rappro);
                                        }
                                    }

                                    $i = $i + 1;
                                    $sources = $smc[$i];
                                    $reste = $reste - $sources->getMontant();
                                    if ($reste <= 0) {
                                        $sortie = $sources->getMontant() - abs($reste);
                                        $sources->setSortie($sortie);
                                        $sources->setSolde($sortie);
                                        $reste_solde = $sources->getMontant_solde() - $sortie;
                                        if ($reste_solde >= 0) {
                                            $sources->setMontant_solde($reste_solde);
                                        } else {
                                            $sources->setMontant_solde(0);
                                        }
                                        $smc_mapper->update($sources);
                                        $count = $muti->findConuter() + 1;
                                        $uti->setId_utiliser($count);
                                        //Enregistrement dans la table eu_utiliser
                                        $uti->setId_smc($sources->getId_smc());
                                        $uti->setCode_smcipn(null);
                                        $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                        $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
                                        $uti->setMontant_allouer($sortie);
                                        if ($sortie > 0) {
                                            try {
                                                $muti->save($uti);
                                            } catch (Exception $exc) {
                                                $this->view->data = 'allocs';
                                                return;
                                            }
                                            //Recherche du code_credit dans la table de rapprochement
                                            $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                            if ($res != null) {
                                                //Mise à jour dans la table de rapprochement
                                                $rappro->setId_rappro($res->getId_rappro());
                                                $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
                                                $rappro->setCredit_rappro($res->getCredit_rappro());
                                                $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
                                                $rappro->setSource($res->getSource());
                                                $rappro->setSource_credit($res->getSource_credit());
                                                $rappro->setCode_smcipn($res->getCode_smcipn());
                                                $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                                $rappro->setCode_domicilier($res->getCode_domicilier());
                                                $rappro->setId_credit($res->getId_credit());
                                                $rappro->setType_rappro($res->getType_rappro());
                                                $m_rappro->update($rappro);
                                            } else {
                                                //Enregistrement dans la table de rapprochement
                                                $rappro->setDebit_rappro($sources->getMontant());
                                                $rappro->setCredit_rappro(0);
                                                $rappro->setSolde_rappro($sources->getMontant());
                                                $rappro->setSource('smc');
                                                $rappro->setSource_credit($sources->getSource_credit());
                                                $rappro->setCode_smcipn(null);
                                                $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                                $rappro->setCode_domicilier(null);
                                                $rappro->setId_credit($sources->getId_credit());
                                                $rappro->setType_rappro(null);
                                                $m_rappro->save($rappro);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {//##Cas des demandes de la smcipnp avec domiciliation
                        if (count($find_smc) == 1) {
                            $sources = $find_smc[0];
                            if ($sources->getMontant_solde() < $sal_alloue) {
                                $this->view->data = 'no_sal1';
                                return;
                            } else {
                                $out = $sources->getSortie() + $sal_alloue;
                                $sources->setSortie($out);
                                $sources->setSolde($out);
                                $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                                if ($reste_solde >= 0) {
                                    $sources->setMontant_solde($reste_solde);
                                } else {
                                    $sources->setMontant_solde(0);
                                }
                                $smc_mapper->update($sources);
                                //Enregistrement dans la table eu_utiliser
                                $count = $muti->findConuter() + 1;
                                $uti->setId_utiliser($count);
                                $uti->setId_smc($sources->getId_smc());
                                $uti->setCode_smcipn(null);
                                $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
                                $uti->setMontant_allouer($sal_alloue);
                                if ($sal_alloue > 0) {
                                    try {
                                        $muti->save($uti);
                                    } catch (Exception $exc) {
                                        $this->view->data = 'allocs';
                                        return;
                                    }
                                    //Recherche du code_credit dans la table rapprochement
                                    $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                    if ($res != null) {
                                        //Mise à jour dans la table de rapprochement
                                        $rappro->setId_rappro($res->getId_rappro());
                                        $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
                                        $rappro->setCredit_rappro($res->getCredit_rappro());
                                        $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
                                        $rappro->setSource($res->getSource());
                                        $rappro->setSource_credit($res->getSource_credit());
                                        $rappro->setCode_smcipn($res->getCode_smcipn());
                                        $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                        $rappro->setCode_domicilier($res->getCode_domicilier());
                                        $rappro->setId_credit($res->getId_credit());
                                        $rappro->setType_rappro($res->getType_rappro());
                                        $m_rappro->update($rappro);
                                    } else {
                                        //Enregistrement dans la table de rapprochement
                                        $rappro->setDebit_rappro($sources->getMontant());
                                        $rappro->setCredit_rappro(0);
                                        $rappro->setSolde_rappro($sources->getMontant());
                                        $rappro->setSource('smc');
                                        $rappro->setSource_credit($sources->getSource_credit());
                                        $rappro->setCode_smcipn(null);
                                        $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                        $rappro->setCode_domicilier(null);
                                        $rappro->setId_credit($sources->getId_credit());
                                        $rappro->setType_rappro(null);
                                        $m_rappro->save($rappro);
                                    }
                                }
                            }
                        } elseif (count($find_smc) > 1) {
                            //Calcul du cumul des soldes de la domiciliation
                            $tot_sal = 0;
                            for ($j = 0; $j < count($find_smc); $j++) {
                                $tot_sal += $find_smc[$j]->getMontant_solde();
                            }
                            if ($tot_sal < $sal_alloue) {
                                $this->view->data = $tot_sal;
                                return;
                            } else {
                                $i = 0;
                                $sources = $find_smc[$i];
                                $reste = ($sal_alloue + $sources->getSortie()) - $sources->getMontant();
                                if ($reste <= 0) {
                                    $salaire = $sources->getSortie() + $sal_alloue;
                                    $sources->setSortie($salaire);
                                    $sources->setSolde($salaire);
                                    $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                                    if ($reste_solde >= 0) {
                                        $sources->setMontant_solde($reste_solde);
                                    } else {
                                        $sources->setMontant_solde(0);
                                    }
                                    $smc_mapper->update($sources);
                                    //Enregistrement dans la table eu_utiliser
                                    $count = $muti->findConuter() + 1;
                                    $uti->setId_utiliser($count);
                                    $uti->setId_smc($sources->getId_smc());
                                    $uti->setCode_smcipn(null);
                                    $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                    $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
                                    $uti->setMontant_allouer($sal_alloue);
                                    if ($sal_alloue > 0) {
                                        try {
                                            $muti->save($uti);
                                        } catch (Exception $exc) {
                                            $this->view->data = 'allocs';
                                            return;
                                        }
                                        //Recherche du code_credit dans la table de rapprochement
                                        $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                        if ($res != null) {
                                            //Mise à jour dans la table de rapprochement
                                            $rappro->setId_rappro($res->getId_rappro());
                                            $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
                                            $rappro->setCredit_rappro($res->getCredit_rappro());
                                            $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
                                            $rappro->setSource($res->getSource());
                                            $rappro->setSource_credit($res->getSource_credit());
                                            $rappro->setCode_smcipn($res->getCode_smcipn());
                                            $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                            $rappro->setCode_domicilier($res->getCode_domicilier());
                                            $rappro->setId_credit($res->getId_credit());
                                            $rappro->setType_rappro($res->getType_rappro());
                                            $m_rappro->update($rappro);
                                        } else {
                                            //Enregistrement dans la table de rapprochement
                                            $rappro->setDebit_rappro($sources->getMontant());
                                            $rappro->setCredit_rappro(0);
                                            $rappro->setSolde_rappro($sources->getMontant());
                                            $rappro->setSource('smc');
                                            $rappro->setSource_credit($sources->getSource_credit());
                                            $rappro->setCode_smcipn(null);
                                            $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                            $rappro->setCode_domicilier(null);
                                            $rappro->setId_credit($sources->getId_credit());
                                            $rappro->setType_rappro(null);
                                            $m_rappro->save($rappro);
                                        }
                                    }
                                } else {
                                    while ($reste > 0) {
                                        $sources->setSortie($sources->getMontant());
                                        $sources->setSolde($sources->getMontant());
                                        $reste_solde = $sources->getMontant_solde() - $sal_alloue;
                                        $tmp_sold = $sources->getMontant_solde();
                                        if ($reste_solde >= 0) {
                                            $sources->setMontant_solde($reste_solde);
                                        } else {
                                            $sources->setMontant_solde(0);
                                        }
                                        $smc_mapper->update($sources);
                                        //Enregistrement dans la table eu_utiliser
                                        $count = $muti->findConuter() + 1;
                                        $uti->setId_utiliser($count);
                                        $uti->setId_smc($sources->getId_smc());
                                        $uti->setCode_smcipn(null);
                                        $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                        $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
                                        $uti->setMontant_allouer($tmp_sold);
                                        if ($tmp_sold > 0) {
                                            try {
                                                $muti->save($uti);
                                            } catch (Exception $exc) {
                                                $this->view->data = 'allocs';
                                                return;
                                            }
                                            //Recherche du code_credit dans la table de rapprochement
                                            $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                            if ($res != null) {
                                                //Mise à jour dans la table de rapprochement
                                                $rappro->setId_rappro($res->getId_rappro());
                                                $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
                                                $rappro->setCredit_rappro($res->getCredit_rappro());
                                                $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
                                                $rappro->setSource($res->getSource());
                                                $rappro->setSource_credit($res->getSource_credit());
                                                $rappro->setCode_smcipn($res->getCode_smcipn());
                                                $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                                $rappro->setCode_domicilier($res->getCode_domicilier());
                                                $rappro->setId_credit($res->getId_credit());
                                                $rappro->setType_rappro($res->getType_rappro());
                                                $m_rappro->update($rappro);
                                            } else {
                                                //Enregistrement dans la table de rapprochement
                                                $rappro->setDebit_rappro($sources->getMontant());
                                                $rappro->setCredit_rappro(0);
                                                $rappro->setSolde_rappro($sources->getMontant());
                                                $rappro->setSource('smc');
                                                $rappro->setSource_credit($sources->getSource_credit());
                                                $rappro->setCode_smcipn(null);
                                                $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                                $rappro->setCode_domicilier(null);
                                                $rappro->setId_credit($sources->getId_credit());
                                                $rappro->setType_rappro(null);
                                                $m_rappro->save($rappro);
                                            }
                                        }

                                        $i = $i + 1;
                                        $sources = $find_smc[$i];
                                        $reste = $reste - $sources->getMontant();
                                        if ($reste <= 0) {
                                            $sortie = $sources->getMontant() - abs($reste);
                                            $sources->setSortie($sortie);
                                            $sources->setSolde($sortie);
                                            $reste_solde = $sources->getMontant_solde() - $sortie;
                                            if ($reste_solde >= 0) {
                                                $sources->setMontant_solde($reste_solde);
                                            } else {
                                                $sources->setMontant_solde(0);
                                            }
                                            $smc_mapper->update($sources);
                                            //Enregistrement dans la table eu_utiliser
                                            $count = $muti->findConuter() + 1;
                                            $uti->setId_utiliser($count);
                                            $uti->setId_smc($sources->getId_smc());
                                            $uti->setCode_smcipn(null);
                                            $uti->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                            $uti->setDate_creation($date_alloc->toString('yyyy-mm-dd'));
                                            $uti->setMontant_allouer($sortie);
                                            if ($sortie > 0) {
                                                try {
                                                    $muti->save($uti);
                                                } catch (Exception $exc) {
                                                    $this->view->data = 'allocs';
                                                    return;
                                                }
                                                //Recherche du code_credit dans la table de rapprochement
                                                $res = $m_rappro->findBySmcipnSource2($code_domi, $sources->getSource_credit(), $sources->getId_credit());
                                                if ($res != null) {
                                                    //Mise à jour dans la table de rapprochement
                                                    $rappro->setId_rappro($res->getId_rappro());
                                                    $rappro->setDebit_rappro($res->getDebit_rappro() + $sources->getMontant());
                                                    $rappro->setCredit_rappro($res->getCredit_rappro());
                                                    $rappro->setSolde_rappro($res->getSolde_rappro() - $sources->getMontant());
                                                    $rappro->setSource($res->getSource());
                                                    $rappro->setSource_credit($res->getSource_credit());
                                                    $rappro->setCode_smcipn($res->getCode_smcipn());
                                                    $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                                    $rappro->setCode_domicilier($res->getCode_domicilier());
                                                    $rappro->setId_credit($res->getId_credit());
                                                    $rappro->setType_rappro($res->getType_rappro());
                                                    $m_rappro->update($rappro);
                                                } else {
                                                    //Enregistrement dans la table de rapprochement
                                                    $rappro->setDebit_rappro($sources->getMontant());
                                                    $rappro->setCredit_rappro(0);
                                                    $rappro->setSolde_rappro($sources->getMontant());
                                                    $rappro->setSource('smc');
                                                    $rappro->setSource_credit($sources->getSource_credit());
                                                    $rappro->setCode_smcipn(null);
                                                    $rappro->setCode_smcipnp($smcipnp->getCode_smcipnp());
                                                    $rappro->setCode_domicilier(null);
                                                    $rappro->setId_credit($sources->getId_credit());
                                                    $rappro->setType_rappro(null);
                                                    $m_rappro->save($rappro);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //###########Traitements généraux#############
                    //####Traitement du salaire de la smcipnp#### 
                    $code_cat = 'CNCSr';
                    //Ajout dans la table opération
                    $alloc = new Application_Model_EuOperation();
                    $alloc->setDate_op($date_alloc->toString('yyyy-mm-dd'));
                    $alloc->setHeure_op($date_alloc->toString('hh:mm'));
                    $alloc->setMontant_op($sal_alloue);
                    $alloc->setCode_membre($num_ass);
                    $alloc->setCode_produit($code_cat);
                    $alloc->setId_utilisateur($user->id_utilisateur);
                    $alloc->setLib_op('Allocation de la smcipnp');
                    $alloc->setCode_cat('tpasmcp');
                    $alloc->setType_op('asmcipnp');
                    $mapper = new Application_Model_EuOperationMapper();
                    $mapper->save($alloc);

                    $db->commit();
                    $this->view->data = 'good';
                    return;
                } catch (Exception $exc) {
                    $db->rollback();
                    return;
                    $message = 'Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                    $this->view->data = 'echec';
                }
            }
        }
    }

    public function smcipnpaccordeAction() {
        $this->_helper->layout->disableLayout();
    }

    public function listaccordsmcipnpAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_smcipnp');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipnp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->where('eu_smcipnp.etat_smcipnp = ?', 1)
                ->order('eu_smcipnp.date_smcipnp', 'desc');
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
        $totsmcipnp = 0;
        $nom_acteur = '';
        foreach ($smcipnp as $row) {
            $type_acteur = $row->source_smcipnp;
            $code_acteur = $row->code_acteur;
            $code_membre = $row->code_membre;
            if ($type_acteur == 'gac') {
                $acteur = 'gac centrale';
                $mgac = new Application_Model_EuGacMapper();
                $gac = new Application_Model_EuGac();
                $find_gac = $mgac->find($code_acteur, $gac);
                if ($find_gac) {
                    $nom_acteur = $gac->getNom_gac();
                }
            } elseif ($type_acteur == 'filiere') {
                $acteur = 'gac filière';
                $mfil = new Application_Model_EuGacFiliereMapper();
                $fil = new Application_Model_EuGacFiliere();
                $find_fil = $mfil->find($code_acteur, $fil);
                if ($find_fil) {
                    $nom_acteur = $fil->getNom_gac_filiere();
                }
            } elseif ($type_acteur == 'creneau') {
                $acteur = 'Créneau d\'activité';
                $mcre = new Application_Model_EuCreneauMapper();
                $cre = new Application_Model_EuCreneau();
                $find_cre = $mcre->find($code_acteur, $cre);
                if ($find_cre) {
                    $nom_acteur = $cre->getNom_creneau();
                }
            } elseif ($type_acteur == 'acteur') {
                $acteur = 'Acteur créneau';
                $mact = new Application_Model_EuActeurCreneauMapper();
                $act = new Application_Model_EuActeurCreneau();
                $find_act = $mact->find($code_acteur, $act);
                if ($find_act) {
                    $nom_acteur = $act->getNom_acteur();
                }
            } elseif ($type_acteur == 'acnev') {
                $acteur = 'Acteur créneau';
                $mmemb = new Application_Model_EuMembreMapper();
                $memb = new Application_Model_EuMembre();
                $find_memb = $mmemb->find($code_membre, $memb);
                if ($find_memb) {
                    $nom_acteur = $memb->getRaison_sociale();
                }
            }
            $totsmcipnp+=$row->montant_smcipnp;
            $date_dem = new Zend_Date($row->date_smcipnp, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipnp;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipnp,
                ucfirst($row->lib_smcipnp),
                $row->code_membre,
                $row->montant_smcipnp,
                $acteur,
                ucfirst($nom_acteur),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $responce['userdata']['code_membre'] = 'Totaux:';
        $responce['userdata']['mt_smcipnp'] = $totsmcipnp;
        $this->view->data = $responce;
    }

    public function findtypegacAction() {
        $code_type = $_GET['code_type_gac'];
        $decoup = array();
        if ($code_type == 'gac_source') {
            $tab = new Application_Model_DbTable_EuZone();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_zone.nom_zone asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->code_zone;
                $decoup[$i][2] = ucfirst($value->nom_zone);
                $i++;
            }
		} elseif ($code_type == 'gac_zone') {
            $tab = new Application_Model_DbTable_EuZone();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_zone.nom_zone asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->code_zone;
                $decoup[$i][2] = ucfirst($value->nom_zone);
                $i++;
            }
        } elseif ($code_type == 'gac_pays' || $code_type == 'gac_sur') {
            $tab = new Application_Model_DbTable_EuPays();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_pays.libelle_pays asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->id_pays;
                $decoup[$i][2] = ucfirst($value->libelle_pays);
                $i++;
            }
        } elseif ($code_type == 'gac_section') {
            $tab = new Application_Model_DbTable_EuSection();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_section.nom_section asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->id_section;
                $decoup[$i][2] = ucfirst($value->nom_section);
                $i++;
            }
        } elseif ($code_type == 'gac_region') {
            $tab = new Application_Model_DbTable_EuRegion();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_region.nom_region asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->id_region;
                $decoup[$i][2] = ucfirst($value->nom_region);
                $i++;
            }
        } elseif ($code_type == 'gac_secteur') {
            $tab = new Application_Model_DbTable_EuSecteur();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_secteur.nom_secteur asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->code_secteur;
                $decoup[$i][2] = ucfirst($value->nom_secteur);
                $i++;
            }
        } elseif ($code_type == 'gac_agence') {
            $tab = new Application_Model_DbTable_EuAgence();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_agence.libelle_agence asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->code_agence;
                $decoup[$i][2] = ucfirst($value->libelle_agence);
                $i++;
            }
        }
        $this->view->data = $decoup;
    }

    public function findagenceAction() {
        $code_type = $_GET['code_type_gac'];
        $decoup = array();
        if ($code_type == 'gac_source') {
            $tab = new Application_Model_DbTable_EuAgence();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_agence.libelle_agence asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->code_agence;
                $decoup[$i][2] = ucfirst($value->libelle_agence);
                $i++;
            }
        }elseif ($code_type == 'gac_agence') {
            $tab = new Application_Model_DbTable_EuAgence();
            $sel = $tab->select();
            $sel->setIntegrityCheck(false)
                    ->order('eu_agence.libelle_agence asc');
            $zone = $tab->fetchAll($sel);
            $i = 0;
            foreach ($zone as $value) {
                $decoup[$i][1] = $value->code_agence;
                $decoup[$i][2] = ucfirst($value->libelle_agence);
                $i++;
            }
        }
        $this->view->data = $decoup;
    }

    public function findgacdivAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $code_group = $user->code_groupe;
        $code_type = $_GET['code_type_gac'];
        $decoup = array();
        $tab = new Application_Model_DbTable_EuDivisionGac();
        $sel = $tab->select();
        $sel->setIntegrityCheck(false)
                ->where('eu_division_gac.code_type_gac=?', $code_type)
                ->order('eu_division_gac.nom_division asc');
        if ($code_group == 'gac' || $code_group == 'gac_pbf') {
            $sel->where('eu_division_gac.ordre_division=?', 1);
        } elseif ($code_group == 'gacp' || $code_group == 'gacp_pbf') {
            $sel->where('eu_division_gac.ordre_division=?', 2);
        } elseif ($code_group == 'gacsu' || $code_group == 'gacsu_pbf') {
            $sel->where('eu_division_gac.ordre_division=?', 3);
        }
        $div = $tab->fetchAll($sel);
        $i = 0;
        foreach ($div as $value) {
            $decoup[$i][1] = $value->id_division;
            $decoup[$i][2] = ucfirst($value->nom_division);
            $i++;
        }
        $this->view->data = $decoup;
    }

}

?>
