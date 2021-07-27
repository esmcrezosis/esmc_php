<?php

class EuCreneauController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'gac') {
            $menu = "<li><a href=\" /eu-creneau/new \">Nouveau</a></li>" .
                    "<li><a id=\"smcipnfil\" href=\"#\">smcipn obtenues</a></li>" .
                    "<li><a href=\"/eu-creneau/alloccreneau \">Allouer investissement</a></li>" .
                    "<li><a href=\"/eu-creneau/alloccreneausal \">Allouer salaire</a></li>" .
                    "<li><a id=\"ressc\" href=\"#\">Ressources allouées</a></li>" .
                    "<li><a id=\"alloc_fil\" href=\"#\">smcipn transmises</a></li>" .
                    "<li><a id=\"recu_fil\" href=\"#\">Mes smcipn reçues</a></li>";
        } elseif ($group == 'filiere' || $group == 'creneau') {
            $menu = "<li><a href=\" /eu-creneau/new \">Nouveau</a></li>" .
                    "<li><a id=\"smcipnfil\" href=\"#\">smcipn obtenues</a></li>";
        } elseif ($group == 'gac_pbf') {
            $menu = "<li><a href=\" /eu-creneau/new \">Nouveau</a></li>" .
                    "<li><a id=\"smcipnfil\" href=\"#\">smcipn obtenues</a></li>" .
                    "<li><a href=\"/eu-creneau/alloccreneau \">Allouer investissement</a></li>" .
                    "<li><a href=\"/eu-creneau/alloccreneausal \">Allouer salaire</a></li>" .
                    "<li><a id=\"ressc\" href=\"#\">Ressources allouées</a></li>" .
                    "<li><a id=\"alloc_fil\" href=\"#\">smcipn transmises</a></li>" .
                    "<li><a id=\"recu_fil\" href=\"#\">Mes smcipn reçues</a></li>";
        } elseif ($group == 'filiere_pbf' || $group == 'creneau_pbf') {
            $menu = "<li><a href=\" /eu-creneau/new \">Nouveau</a></li>" .
                    "<li><a id=\"smcipnfil\" href=\"#\">smcipn obtenues</a></li>";
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
            if ($group != 'filiere' && $group != 'filiere_pbf') {
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
        $sidx = $this->_request->getParam("sidx", 'code_creneau');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCreneau();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('c' => 'eu_creneau'), array('c.code_creneau', 'c.nom_creneau', 'c.code_membre', "TO_cHAR((c.date_creation),'dd/mm/yyyy') date_creneau"))
                ->join(array('f' => 'eu_gac_filiere'), 'f.code_gac_filiere = c.code_gac_filiere', array('nom_gac_filiere'))
                ->join(array('t' => 'eu_type_creneau'), 't.id_type_creneau = c.id_type_creneau', array('libelle_type_creneau'))
                ->join(array('m' => 'eu_membre'), 'm.code_membre = c.code_membre_gestionnaire', array('nom_membre', 'prenom_membre', 'portable_membre'))
                ->where('c.id_utilisateur = ?', $user->id_utilisateur);
        $creneau = $tabela->fetchAll($select);
        $count = count($creneau);

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
            $responce['rows'][$i]['id'] = $row->code_creneau;
            $responce['rows'][$i]['cell'] = array(
                $row->code_creneau,
                ucfirst($row->nom_creneau),
                $row->code_membre,
                ucfirst($row->libelle_type_creneau),
                strtoupper($row->nom_membre) . ' ' . ucfirst($row->prenom_membre),
                ucfirst($row->nom_gac_filiere),
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
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->where('eu_operation.id_utilisateur = ?', $user->id_utilisateur)
                ->join('eu_creneaux', 'eu_creneaux.code_membre = eu_operation.code_membre')
                ->join('eu_type_creneau', 'eu_type_creneau.id_type_creneau = eu_creneaux.id_type_creneau')
                ->where('type_op = ?', 'arc')
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
                ucfirst($row->nom_creneau),
                ucfirst($row->libelle_type_creneau),
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
        $form = new Application_Form_EuCreneau();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $cm = new Application_Model_EuCreneauMapper();
                    $cren = new Application_Model_EuCreneau($form->getValues());
                    $cren->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $cren->setId_utilisateur($users->id_utilisateur);
                    $ugroupe = $users->code_groupe;
                    $type = '';
                    if ($ugroupe == 'filiere_pbf') {
                        $cren->setGroupe('PBF');
                        $type = 'PBF';
                    }
                    if ($ugroupe == 'filiere') {
                        $cren->setGroupe('GAC');
                        $type = 'GAC';
                    }
                    $code_gac_fil = $users->code_acteur;
                    $cren->setCode_gac_filiere($code_gac_fil);
                    //Formation du code du créneau à partir du code de la gac filière                  
                    $code = $cm->getLastCreneauByFil($code_gac_fil);
                    if ($code == null) {
                        $code_cren = $code_gac_fil . 'c' . '0001';
                    } else {
                        $num_ordre = substr($code, -4);
                        $num_ordre++;
                        $code_cren = $code_gac_fil . 'c' . str_pad($num_ordre, 4, 0, str_pad_left);
                    }
                    $cren->setCode_creneau($code_cren);

                    $num = $code_cren;
                    $zone = $users->code_zone;
                    $nom = $this->_request->getPost("nom_gestion");
                    $prenom = $this->_request->getPost("prenom_gestion");
                    //$creneau = $this->_request->getPost("id_type_creneau");
                    if ($this->_request->getPost("code_membre") == '') {
                        $num_membre = null;
                        $cren->setCode_membre($num_membre);
                        //Création de la gac créneau
                        $cm->save($cren);
                        $db->commit();
                        return $this->_helper->redirector('newuser', 'eu-user', null, array('controller' => 'eu-user', 'action' => 'newuser', 'membre' => $num_membre, 'type' => $type, 'zone' => $zone, 'num' => $num, 'nom' => $nom, 'prenom' => $prenom));
                    } else {
                        $num_membre = $this->_request->getPost("code_membre");
                        //Vérification du code membre du créneau
                        $find_mb = $cm->findByMembre($num_membre);
                        if ($find_mb != false) {
                            $this->view->message = 'Ce membre ' . $num_membre . ' est déjà enregistré comme créneau d\'activités';
                            $this->view->form = $form;
                        } else {
                            $cren->setCode_membre($num_membre);
                            //Création de la gac créneau
                            $cm->save($cren);
                            $db->commit();
                            return $this->_helper->redirector('newuser', 'eu-user', null, array('controller' => 'eu-user', 'action' => 'newuser', 'membre' => $num_membre, 'type' => $type, 'zone' => $zone, 'num' => $num, 'nom' => $nom, 'prenom' => $prenom));
                        }
                    }
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-creneau',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $c = new Application_Model_EuCreneau();
        $mc = new Application_Model_EuCreneauMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $mc->find($this->getRequest()->getPost("code_creneau"), $c);
            $c->setNom_creneau($this->_request->getPost("nom_creneau"));
            $c->setType_creneau($this->_request->getPost("type_creneau"));
            $c->setNum_gestion($this->_request->getPost("num_gestion"));
            $c->setNom_gestion($this->_request->getPost("nom_gestion"));
            $c->setPrenom_gestion($this->_request->getPost("prenom_gestion"));
            $c->setTel_gestion($this->_request->getPost("tel_gestion"));
            $c->setDate_creation($date_id->toString('yyyy-mm-dd'));
            $c->setCree_par($user->login);
            $mc->update($c);
        }
    }

    public function smcipnfilAction() {
        $this->_helper->layout->disableLayout();
    }

    public function smcipnfillistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();
        $code = $user->code_acteur;
        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuCreneau();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->where('code_gac_filiere = ?', $code);
        $listfil = $tabel->fetchAll($sel);
        $rep = array('');
        $i = 0;
        foreach ($listfil as $row) {
            $rep[$i] = $row->code_creneau;
            $i++;
        }
        //Récupération des numéros membre des acteurs liés aux créneaux
        $tabeld = new Application_Model_DbTable_EuActeurCreneau();
        $seld = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $seld->setIntegrityCheck(false)
                ->where('code_creneau in (?)', $rep);
        $listact = $tabeld->fetchAll($seld);
        $repc = array('');
        $i = 0;
        foreach ($listact as $row) {
            $repc[$i] = $row->code_membre;
            $i++;
        }
        if (count($repc) != 0) {
            $tabc = $repc;
        } else {
            $tabc = array('0');
        }
        //Affichage des demandes des acteurs des créneaux d'activités
        $select5 = $tabela->select();
        $select5->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                ->where('eu_smcipn.alloc_fil_inv = ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $tabc);
        $select6 = $tabela->select();
        $select6->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.alloc_gac_sal = ?', 1)
                ->where('eu_smcipn.alloc_fil_sal = ?', 0)
                ->where('eu_smcipn.salaire_alloue != ?', 0)
                //->where('eu_smcipn.etat_sal = ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $tabc);
        //Récupération des numéros membre des acteurs liés directement à la gac filière
        $sela = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sela->setIntegrityCheck(false)
                ->where('code_gac_filiere like ?', $code);
        $listactfil = $tabeld->fetchAll($sela);
        $repa = array('');
        $i = 0;
        foreach ($listactfil as $row) {
            $repa[$i] = $row->code_membre;
            $i++;
        }
        if (count($repa) != 0) {
            $taba = $repa;
        } else {
            $taba = array('0');
        }
        //Affichage des demandes des acteurs des créneaux d'activités
        $select3 = $tabela->select();
        $select3->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                ->where('eu_smcipn.alloc_fil_inv = ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $taba);
        $select4 = $tabela->select();
        $select4->setIntegrityCheck(false)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.alloc_gac_sal = ?', 1)
                ->where('eu_smcipn.alloc_fil_sal = ?', 0)
                ->where('eu_smcipn.salaire_alloue != ?', 0)
                //->where('eu_smcipn.etat_sal = ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $taba);
        
        $select->setIntegrityCheck(false);
        $select->union(array($select5, $select6, $select3, $select4));
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
                $row->salaire_alloue,
                $row->montant_investis,
                $date_dem->toString('dd/mm/yyyy'),
                $heure_dem->toString('hh:mm'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function alloccreneauAction() {
        $form = new Application_Form_EuCreneauAlloc();
        $this->view->form = $form;
    }

    public function alloccreneausalAction() {
        $form = new Application_Form_EuCreneauAllocSal();
        $this->view->form = $form;
    }

    public function listsmcipncreAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_smcipn');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();
        if ($_GET['num_cre'] != '') {
            $numero_cre = $_GET['num_cre'];
            //Recherche du numéro membre du créneau d'activités
            $mcre = new Application_Model_EuCreneauMapper();
            $cre = new Application_Model_EuCreneau();
            $mcre->find($numero_cre, $cre);
            $num_cre = $cre->getCode_membre();
            $nom_cre = $cre->getNom_creneau();
            //Récupération des demandes des créneaux d'activités
            if ($num_cre != '') {
                $select2 = $tabela->select();
                $select2->setIntegrityCheck(false)
                        ->where('eu_smcipn.etat_demande_inv = ?', 1)
                        ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                        ->where('eu_smcipn.alloc_fil_inv = ?', 0)
                        ->where('eu_smcipn.code_membre =?', $num_cre)
                        ->where('eu_smcipn.montant_investis != ?', 0)
                        ->where('eu_smcipn.allouer_i != ?', 1);
            }
            //Formation de la sous requête
            $tabel = new Application_Model_DbTable_EuActeurCreneau();
            $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('code_creneau = ?', $numero_cre);
            $listact = $tabel->fetchAll($sel);
            $rep = array();
            $mb = array();
            $i = 0;
            foreach ($listact as $row) {
                $rep[$i] = $row->code_acteur;
                $mb[$i] = $row->code_membre;
                $i++;
            }
            if (count($mb) > 0) {
                $tab = $mb;
            } else {
                $tab = array('0');
            }
            //Récupération des demandes des acteurs des créneaux d'activités
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_smcipn.etat_demande_inv = ?', 1)
                    ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                    ->where('eu_smcipn.alloc_fil_inv = ?', 0)
                    ->where('eu_smcipn.code_membre in (?)', $tab)
                    ->where('eu_smcipn.montant_investis != ?', 0)
                    ->where('eu_smcipn.allouer_i != ?', 1);

            $select->setIntegrityCheck(false);
            if ($num_cre != '') {
                $select->union(array($select2, $select1));
            } else {
                $select->union(array($select1));
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
                    ucfirst($nom_cre),
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
    }

    public function listsmcipncresalAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_smcipn');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();
        if ($_GET['num_cre'] != '') {
            $numero_cre = $_GET['num_cre'];
            //Recherche du numéro membre du créneau d'activités
            $mcre = new Application_Model_EuCreneauMapper();
            $cre = new Application_Model_EuCreneau();
            $mcre->find($numero_cre, $cre);
            $num_cre = $cre->getCode_membre();
            $nom_cre = $cre->getNom_creneau();
            //Récupération des demandes des créneaux d'activités
            if ($num_cre != '') {
                $select2 = $tabela->select();
                $select2->setIntegrityCheck(false)
                        ->where('eu_smcipn.alloc_fil_sal = ?', 0)
                        ->where('eu_smcipn.code_membre =?', $num_cre)
                        ->where('eu_smcipn.etat_sal = ?', 2)
                        ->where('eu_smcipn.allouer_s != ?', 1)
                        ->where('eu_smcipn.sal_transmis != ?', 0);
            }
            //Formation de la sous requête
            $tabel = new Application_Model_DbTable_EuActeurCreneau();
            $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('code_creneau = ?', $numero_cre);
            $listact = $tabel->fetchAll($sel);
            $rep = array();
            $mb = array();
            $i = 0;
            foreach ($listact as $row) {
                $rep[$i] = $row->code_acteur;
                $mb[$i] = $row->code_membre;
                $i++;
            }
            if (count($mb) > 0) {
                $tab = $mb;
            } else {
                $tab = array('0');
            }
            //Récupération des demandes des acteurs des créneaux d'activités
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_fil_sal = ?', 0)
                    ->where('eu_smcipn.code_membre in (?)', $tab)
                    ->where('eu_smcipn.etat_sal = ?', 2)
                    ->where('eu_smcipn.allouer_s != ?', 1)
                    ->where('eu_smcipn.sal_transmis != ?', 0);

            $select->setIntegrityCheck(false);
            if ($num_cre != '') {
                $select->union(array($select2, $select1));
            } else {
                $select->union(array($select1));
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
                    ucfirst($nom_cre),
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
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuCreneau();
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
                    $mapper = new Application_Model_EuCreneauMapper();
                    $gcre = new Application_Model_EuCreneau($form->getValues());
                    $gcre->setCode_creneau($this->getRequest()->code_creneau);
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $gcre->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $gcre->setId_utilisateur($user->id_utilisateur);
                    $type = $user->code_groupe;
                    if ($type == 'filiere_pbf') {
                        $gcre->setGroupe('PBF');
                    }
                    if ($type == 'filiere') {
                        $gcre->setGroupe('GAC');
                    }
                    $gcre->setCode_gac_filiere($user->code_acteur);
                    if ($this->_request->getPost("code_membre") == '') {
                        $gcre->setCode_membre(null);
                        //Mise à jour du Créneau d'activités
                        $mapper->update($gcre);
                    } else {
                        $num_membre = $this->_request->getPost("code_membre");
                        //Vérification du code membre du créneau
                        $find_mb = $mapper->findByMembre($num_membre);
                        if ($find_mb != false) {
                            $this->view->message = 'Ce membre ' . $num_membre . ' est déjà enregistré comme créneau d\'activités';
                            $this->view->form = $form;
                            return;
                        } else {
                            $gcre->setCode_membre($num_membre);
                            //Mise à jour du Créneau d'activités
                            $mapper->update($gcre);
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
            $code_cre = $request->gac_cre;
            $mapper = new Application_Model_EuCreneauMapper();
            $gcre = new Application_Model_EuCreneau();
            $mapper->find($code_cre, $gcre);

            if ($gcre->getCode_creneau() == $code_cre) {
                //Récupération des informations du gestionnaire                    
                $mmember = new Application_Model_EuMembreMapper();
                $member = new Application_Model_EuMembre();
                $mmember->find($gcre->getCode_membre_gestionnaire(), $member);
                $data = array(
                    'code_creneau' => $code_cre,
                    'nom_creneau' => $gcre->getNom_creneau(),
                    'code_membre' => $gcre->getCode_membre(),
                    'id_type_creneau' => $gcre->getId_type_creneau(),
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
                    'controller' => 'eu-creneau',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        //$this->view->gac = $gcre;
        $this->view->form = $form;
    }

    public function allouerAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $numero_cre = $_GET['num_cre'];
        //Recherche du numéro membre du créneau d'activités
        $mcre = new Application_Model_EuCreneauMapper();
        $cre = new Application_Model_EuCreneau();
        $mcre->find($numero_cre, $cre);
        $num_cre = $cre->getCode_membre();
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
                    $sm->setAlloc_fil_inv(1);
                    $mt_inves+=$sm->getMontant_investis();
                    $mt_smc+=$sm->getMontant_investis() + $sm->getMontant_salaire();
                    $smc->update($sm);
                    //Création des comptes de subvention pour chaque smcipn
                    if ($sm->getCode_membre() == $num_cre) {
                        $code_smcipn = $sm->getCode_smcipn();
                        $compte_credit = new Application_Model_EuCompteCredit();
                        $cc_mapper = new Application_Model_EuCompteCreditMapper();
                        //Création du compte tsci du bénéficiaire de la smcipn
                        if ($sm->getMontant_investis() > 0) {
                            $cat_compte = 'TSCI';
                            $num_comptes = 'NR-' . $cat_compte . '-' . $num_cre;
                            $result = $cm_mapper->find($num_comptes, $compte);
                            if ($result == false) {
                                $compte->setCode_membre($num_cre)
                                       ->setCode_cat($cat_compte)
                                       ->setDesactiver(0)
                                       ->setCode_type('nr')
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
                            $compte_credit->setCode_membre($num_cre)
                                    ->setCode_produit('Ir')
                                    ->setMontant_place($sm->getMontant_investis())
                                    ->setDatedeb($date_deb->toString('yyyy-mm-dd'))
                                    ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                    ->setDate_octroi($date_deb->toString('yyyy-mm-dd'))
                                    ->setSource($num_cre . $date_deb->toString('yyyyMMddHHmmss'))
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
                                $gcsc->setCode_membre($num_cre);
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
                $num_fil = $user->code_membre;
                if ($mt_inves > 0) {
                    $code_cat = 'Ir';
                    $num_compteg = 'nr-' . $code_cat . '-' . $num_fil;
                    $cgm->find($num_compteg, $cg);
                    if (count($cg) == 1) {
                        $mt_i = $cg->getSolde();
                        if ($mt_i >= $mt_inves) {
                            //Ajout dans la table opération
                            $alloc = new Application_Model_EuOperation();
                            $alloc->setDate_op($date_deb->toString('yyyy-mm-dd'));
                            $alloc->setHeure_op($date_deb->toString('hh:mm'));
                            $alloc->setMontant_op($mt_inves);
                            $alloc->setCode_membre($num_cre);
                            $alloc->setCode_produit($code_cat);
                            $alloc->setId_utilisateur($user->id_utilisateur);
                            $alloc->setLib_op('Allocation de ressources au créneau d\'activités');
                            $alloc->setCode_cat('I');
                            $alloc->setType_op('arc');
                            $mapper = new Application_Model_EuOperationMapper();
                            $mapper->save($alloc);

                            //Ajout dans la table compte
                            if ($sm->getCode_membre() != $num_cre) {
                                $compte = new Application_Model_EuCompte();
                                $cm_mapper = new Application_Model_EuCompteMapper();
                                $num_comptef = 'nr-' . $code_cat . '-' . $num_cre;
                                $result = $cm_mapper->find($num_comptef, $compte);
                                if ($result == false) {
                                    $compte->setCode_membre($num_cre)
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

                            //Mise à jour du compte de la gac filière 
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
        $numero_cre = $_GET['num_cre'];
        //Recherche du numéro membre du créneau d'activités
        $mcre = new Application_Model_EuCreneauMapper();
        $cre = new Application_Model_EuCreneau();
        $mcre->find($numero_cre, $cre);
        $num_cre = $cre->getCode_membre();
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
                        $sm->setAlloc_fil_sal(0);
                    } else {
                        $sm->setAlloc_fil_sal(1);
                    }
                    $sal_alloue = $sm->getSal_transmis();
                    $mt_salaire+=$sal_alloue;
                    $sm->setEtat_sal(3);
                    //Mise à jour de la table smcipn
                    $smc->update($sm);
                    //Création des comptes de subvention du bénéficiaire de la smcipn
                    if ($sm->getCode_membre() == $num_cre) {
                        $code_smcipn = $sm->getCode_smcipn();
                        $compte_credit = new Application_Model_EuCompteCredit();
                        $cc_mapper = new Application_Model_EuCompteCreditMapper();
                        //Création du compte tpn du bénéficiaire de la smcipn
                        if ($sal_alloue > 0) {
                            $cat_compte = 'TPN';
                            $num_comptes = 'NR-' . $cat_compte . '-' . $num_cre;
                            $result = $cm_mapper->find($num_comptes, $compte);
                            if ($result == false) {
                                $compte->setCode_membre($num_cre)
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
                                $compte_credit->setCode_membre($num_cre)
                                        ->setCode_produit('CNCSr')
                                        ->setMontant_place($sal_alloue)
                                        ->setDatedeb($date_deb->toString('yyyy-mm-dd'))
                                        ->setDatefin($date_fin->toString('yyyy-mm-dd'))
                                        ->setDate_octroi($date_deb->toString('yyyy-mm-dd'))
                                        ->setSource($num_cre . $date_deb->toString('yyyyMMddHHmmss'))
                                        ->setCode_compte($num_comptes)
                                        ->setMontant_credit($sal_alloue)
                                        ->setRenouveller('N')
                                        ->setCompte_source($code_smcipn)
                                        ->setKrr('N')
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
                                    $gcsc->setCode_membre($num_cre);
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
                $num_fil = $user->code_membre;
                //####Traitement du salaire de la smcipn####               
                if ($mt_salaire > 0) {
                    $code_cat = 'CNCSr';
                    $num_compteg = 'NR-' . $code_cat . '-' . $num_fil;
                    $cgm->find($num_compteg, $cg);
                    if (count($cg) == 1) {
                        $mt_s = $cg->getSolde();
                        if ($mt_s >= $mt_salaire) {
                            //Ajout dans la table opération
                            $alloc = new Application_Model_EuOperation();
                            $alloc->setDate_op($date_deb->toString('yyyy-mm-dd'));
                            $alloc->setHeure_op($date_deb->toString('hh:mm'));
                            $alloc->setMontant_op($mt_salaire);
                            $alloc->setCode_membre($num_cre);
                            $alloc->setCode_produit($code_cat);
                            $alloc->setId_utilisateur($user->id_utilisateur);
                            $alloc->setLib_op('Allocation de ressources au créneau d\'activités');
                            $alloc->setCode_cat('cncs');
                            $alloc->setType_op('arc');
                            $mapper = new Application_Model_EuOperationMapper();
                            $mapper->save($alloc);

                            //Ajout dans la table compte
                            if ($sm->getCode_membre() != $num_cre) {
                                $compte = new Application_Model_EuCompte();
                                $cm_mapper = new Application_Model_EuCompteMapper();
                                $num_comptef = 'nr-' . $code_cat . '-' . $num_cre;
                                $result = $cm_mapper->find($num_comptef, $compte);
                                if ($result == false) {
                                    $compte->setCode_membre($num_cre)
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

                            //Mise à jour du compte de la gac filière
                            $res = $cm_mapper->find($num_compteg, $compte);
                            if ($res == false) {
                                $this->view->data = 'compte_fils';
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
        $select = $tabela->select();
        $num = $user->code_membre;
        $code = $user->code_acteur;
        //Récupération des demandes de la gac filière
        if ($num != '') {
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                    ->where('eu_smcipn.alloc_fil_inv = ?', 1)
                    ->where('eu_smcipn.code_membre =?', $num);
            $select2 = $tabela->select();
            $select2->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_gac_sal = ?', 1)
                    ->where('eu_smcipn.alloc_fil_sal = ?', 1)
                    ->where('eu_smcipn.etat_sal = ?', 3)
                    ->where('eu_smcipn.code_membre =?', $num);
        }
        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuCreneau();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->where('code_gac_filiere = ?', $code);
        $listfil = $tabel->fetchAll($sel);
        $rep = array('');
        $mb = array('');
        $i = 0;
        foreach ($listfil as $row) {
            $rep[$i] = $row->code_creneau;
            $mb[$i] = $row->code_membre;
            $i++;
        }
        if (count($mb) != 0) {
            $tab = $mb;
        } else {
            $tab = array('');
        }
        //Récupération des demandes des créneaux d'activités
        if ($tab != '') {
            $select3 = $tabela->select();
            $select3->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                    ->where('eu_smcipn.alloc_fil_inv = ?', 1)
                    ->where('eu_smcipn.code_membre in (?)', $tab);
            $select4 = $tabela->select();
            $select4->setIntegrityCheck(false)
                    ->where('eu_smcipn.alloc_gac_sal = ?', 1)
                    ->where('eu_smcipn.alloc_fil_sal = ?', 1)
                    ->where('eu_smcipn.etat_sal = ?', 3)
                    ->where('eu_smcipn.code_membre in (?)', $tab);
        }
        //Récupération des numéros membre des acteurs liés aux créneaux
        $tabeld = new Application_Model_DbTable_EuActeurCreneau();
        $seld = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $seld->setIntegrityCheck(false)
                ->where('code_creneau in (?)', $rep);
        $listact = $tabeld->fetchAll($seld);
        $repc = array('');
        $i = 0;
        foreach ($listact as $row) {
            $repc[$i] = $row->code_membre;
            $i++;
        }
        if (count($repc) != 0) {
            $tabc = $repc;
        } else {
            $tabc = array('0');
        }
        //Affichage des demandes des acteurs des créneaux d'activités
        $select5 = $tabela->select();
        $select5->setIntegrityCheck(false)
                ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                ->where('eu_smcipn.alloc_fil_inv = ?', 1)
                ->where('eu_smcipn.code_membre in (?)', $tabc);
        $select6 = $tabela->select();
        $select6->setIntegrityCheck(false)
                ->where('eu_smcipn.alloc_gac_sal = ?', 1)
                ->where('eu_smcipn.alloc_fil_sal = ?', 1)
                ->where('eu_smcipn.etat_sal = ?', 3)
                ->where('eu_smcipn.code_membre in (?)', $tabc);
        $select->setIntegrityCheck(false);
        if ($num != '' and $tab != '') {
            $select->union(array($select1, $select2, $select3, $select4, $select5, $select6));
        } elseif ($num == '' and $tab != '') {
            $select->union(array($select3, $select4, $select5, $select6));
        } elseif ($num != '' and $tab == '') {
            $select->union(array($select1, $select2, $select5, $select6));
        } else {
            $select->union(array($select5, $select6));
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
                $row->sal_transmis,
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
        //Récupération des demandes de la gac filière qui sont accordées
        $select1 = $tabela->select();
        $select1->setIntegrityCheck(false)
                ->where('eu_smcipn.alloc_gac_inv = ?', 1)
                ->where('eu_smcipn.code_membre =?', $num);
        $select2 = $tabela->select();
        $select2->setIntegrityCheck(false)
                ->where('eu_smcipn.alloc_gac_sal = ?', 1)
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
                $row->sal_transmis,
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

}

?>
