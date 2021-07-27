<?php

class EuAlerteController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'alerte' && $group != 'gaca_protect' && $group != 'gacs_protect' && $group != 'gacr_protect' && $group != 'gacp_protect') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'alerte' || $group == 'gaca_protect' || $group == 'gacs_protect' || $group == 'gacr_protect' || $group == 'gacp_protect') {
            $menu = "<li><a href=\" /eu-alerte/new \">Nouveau</a></li>" .
                    "<li><a href=\"/eu-alerte\">Liste des alertes</a></li>";
        }
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function indexAction() {
        // action body
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_alerte');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuAlerte();
        $select = $tabela->select();
        $group_user = $user->code_groupe;
        //########## Cas de la gac protection pays ###########
        if ($group_user == 'gacp_protect') {
            //Récupération des infos de la gac pays
            $gac = new Application_Model_DbTable_EuGac();
            $selpays = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selpays->setIntegrityCheck(false)
                    ->where('code_membre = ?', $user->code_membre);
            $infopays = $gac->fetchAll($selpays);
            $codegacp = '';
            $mbgacp = '';
            $codegacp = $infopays[0]->code_gac;
            $mbgacp = $infopays[0]->code_membre;
            //Récupération de l'id_user de la gac pays
            $util = new Application_Model_DbTable_EuUtilisateur();
            $selutip = $util->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selutip->setIntegrityCheck(false)
                    ->where('code_acteur like ?', $codegacp)
                    ->where('code_membre like ?', $mbgacp);
            $infoutip = $gac->fetchAll($selutip);
            $id_userp = '';
            $id_userp = $infoutip[0]->id_utilisateur;
            //Récupération des gac régions liées à la gac pays
            $selone = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selone->setIntegrityCheck(false)
                    ->where('id_utilisateur = ?', $id_userp);
            $infogac = $gac->fetchAll($selone);
            $codegacr = array('');
            $mbgacr = array('');
            $i = 0;
            foreach ($infogac as $row) {
                $codegacr[$i] = $row->code_gac;
                $mbgacr[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des id_user liés aux gac régions
            $util = new Application_Model_DbTable_EuUtilisateur();
            $seluti = $util->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $seluti->setIntegrityCheck(false)
                    ->where('code_acteur in (?)', $codegacr)
                    ->where('code_membre in (?)', $mbgacr);
            $infouti = $gac->fetchAll($seluti);
            $id_user = array('');
            $i = 0;
            foreach ($infouti as $row) {
                $id_user[$i] = $row->id_utilisateur;
                $i++;
            }
            //Récupération des gac secteur liées à la gac région
            $sels = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sels->setIntegrityCheck(false)
                    ->where('id_utilisateur in (?)', $id_user);
            $listgac = $gac->fetchAll($sels);
            $codegacs = array('');
            $mbgacs = array('');
            $i = 0;
            foreach ($listgac as $row) {
                $codegacs[$i] = $row->code_gac;
                $mbgacs[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des id_user liés aux gac secteurs
            $selutis = $util->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selutis->setIntegrityCheck(false)
                    ->where('code_acteur in (?)', $codegacs)
                    ->where('code_membre in (?)', $mbgacs);
            $infoutis = $gac->fetchAll($selutis);
            $id_users = array('');
            $i = 0;
            foreach ($infoutis as $row) {
                $id_users[$i] = $row->id_utilisateur;
                $i++;
            }
            //Récupération des gac agences liées à la gac secteur
            $sel = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('id_utilisateur in (?)', $id_users);
            $listgac = $gac->fetchAll($sel);
            $codegac = array('');
            $mbgac = array('');
            $i = 0;
            foreach ($listgac as $row) {
                $codegac[$i] = $row->code_gac;
                $mbgac[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des gac filières liées à la gac centrale
            $tfil = new Application_Model_DbTable_EuGacFiliere();
            $selfil = $tfil->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selfil->setIntegrityCheck(false)
                    ->where('code_gac in (?)', $codegac);
            $listfil = $tfil->fetchAll($selfil);
            $codefil = array('');
            $mbfil = array('');
            $i = 0;
            foreach ($listfil as $row) {
                $codefil[$i] = $row->code_gac_filiere;
                $mbfil[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des gac créneaux liées aux gac filières
            $tabelc = new Application_Model_DbTable_EuCreneau();
            $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selc->setIntegrityCheck(false)
                 ->where('code_gac_filiere in (?)', $codefil);
            $listcre = $tabelc->fetchAll($selc);
            $codecre = array('');
            $mbcre = array('');
            $i = 0;
            foreach ($listcre as $row) {
                $codecre[$i] = $row->code_creneau;
                $mbcre[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des numéros membre des acteurs liés aux créneaux
            $tabeld = new Application_Model_DbTable_EuActeurCreneau();
            $seld = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $seld->setIntegrityCheck(false)
                    ->where('code_creneau in (?)', $codecre);
            $listact = $tabeld->fetchAll($seld);
            $mbact = array('');
            $i = 0;
            foreach ($listact as $row) {
                $mbact[$i] = $row->code_membre;
                $i++;
            }
            //Liste de alertes
            $select = $tabela->select();
            $select->setIntegrityCheck(false)
                    ->from('eu_alerte', array('*', "to_char((eu_alerte.date_alerte),'dd/mm/yyyy') date_alerte", "to_char((eu_alerte.heure_alerte),'hh:mm') heure_alerte"))
                    ->where('code_membre_acteur like ?', $mbgacp)
                    ->orwhere('code_membre_acteur in (?)', $mbgacr)
                    ->orwhere('code_membre_acteur in (?)', $mbgacs)
                    ->orwhere('code_membre_acteur in (?)', $mbgac)
                    ->orwhere('code_membre_acteur in (?)', $mbfil)
                    ->orwhere('code_membre_acteur in (?)', $mbcre)
                    ->orwhere('code_membre_acteur in (?)', $mbact);
        }
        //########## Cas de la gac protection région ###########
        if ($group_user == 'gacr_protect') {
            //Récupération des infos de la gac région
            $gac = new Application_Model_DbTable_EuGac();
            $selone = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selone->setIntegrityCheck(false)
                    ->where('code_membre = ?', $user->code_membre);
            $infogac = $gac->fetchAll($selone);
            $codegacr = '';
            $mbgacr = '';
            $codegacr = $infogac[0]->code_gac;
            $mbgacr = $infogac[0]->code_membre;
            //Récupération de l'id_user de la gac région
            $util = new Application_Model_DbTable_EuUtilisateur();
            $seluti = $util->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $seluti->setIntegrityCheck(false)
                    ->where('code_acteur like ?', $codegacr)
                    ->where('code_membre like ?', $mbgacr);
            $infouti = $gac->fetchAll($seluti);
            $id_user = '';
            $id_user = $infouti[0]->id_utilisateur;
            //Récupération des gac secteur liées à la gac région
            $sels = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sels->setIntegrityCheck(false)
                    ->where('id_utilisateur = ?', $id_user);
            $listgac = $gac->fetchAll($sels);
            $codegacs = array('');
            $mbgacs = array('');
            $i = 0;
            foreach ($listgac as $row) {
                $codegacs[$i] = $row->code_gac;
                $mbgacs[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des id_user liés aux gac secteurs
            $selutis = $util->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selutis->setIntegrityCheck(false)
                    ->where('code_acteur in (?)', $codegacs)
                    ->where('code_membre in (?)', $mbgacs);
            $infoutis = $gac->fetchAll($selutis);
            $id_users = array('');
            $i = 0;
            foreach ($infoutis as $row) {
                $id_users[$i] = $row->id_utilisateur;
                $i++;
            }
            //Récupération des gac agences liées à la gac secteur
            $sel = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('id_utilisateur in (?)', $id_users);
            $listgac = $gac->fetchAll($sel);
            $codegac = array('');
            $mbgac = array('');
            $i = 0;
            foreach ($listgac as $row) {
                $codegac[$i] = $row->code_gac;
                $mbgac[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des gac filières liées à la gac centrale
            $tfil = new Application_Model_DbTable_EuGacFiliere();
            $selfil = $tfil->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selfil->setIntegrityCheck(false)
                    ->where('code_gac in (?)', $codegac);
            $listfil = $tfil->fetchAll($selfil);
            $codefil = array('');
            $mbfil = array('');
            $i = 0;
            foreach ($listfil as $row) {
                $codefil[$i] = $row->code_gac_filiere;
                $mbfil[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des gac créneaux liées aux gac filières
            $tabelc = new Application_Model_DbTable_EuCreneau();
            $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selc->setIntegrityCheck(false)
                    ->where('code_gac_filiere in (?)', $codefil);
            $listcre = $tabelc->fetchAll($selc);
            $codecre = array('');
            $mbcre = array('');
            $i = 0;
            foreach ($listcre as $row) {
                $codecre[$i] = $row->code_creneau;
                $mbcre[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des numéros membre des acteurs liés aux créneaux
            $tabeld = new Application_Model_DbTable_EuActeurCreneau();
            $seld = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $seld->setIntegrityCheck(false)
                    ->where('code_creneau in (?)', $codecre);
            $listact = $tabeld->fetchAll($seld);
            $mbact = array('');
            $i = 0;
            foreach ($listact as $row) {
                $mbact[$i] = $row->code_membre;
                $i++;
            }
            //Liste de alertes
            $select = $tabela->select();
            $select->setIntegrityCheck(false)
                    ->from('eu_alerte', array('*', "to_char((eu_alerte.date_alerte),'dd/mm/yyyy') date_alerte", "to_char((eu_alerte.heure_alerte),'hh:mm') heure_alerte"))
                    ->where('code_membre_acteur like ?', $mbgacr)
                    ->orwhere('code_membre_acteur in (?)', $mbgacs)
                    ->orwhere('code_membre_acteur in (?)', $mbgac)
                    ->orwhere('code_membre_acteur in (?)', $mbfil)
                    ->orwhere('code_membre_acteur in (?)', $mbcre)
                    ->orwhere('code_membre_acteur in (?)', $mbact);
        }
        //########## Cas de la gac protection secteur ###########
        if ($group_user == 'gacs_protect') {
            //****Récupération des id_user des acteurs de la gac secteur****
            //Récuparation des infos de la gac secteur
            $gac = new Application_Model_DbTable_EuGac();
            $selone = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selone->setIntegrityCheck(false)
                   ->where('code_membre = ?', $user->code_membre);
            $infogac = $gac->fetchAll($selone);
            $codegacone = '';
            $mbgacone = '';
            $codegacone = $infogac[0]->code_gac;
            $mbgacone = $infogac[0]->code_membre;
            //Récupération de l'id_user de la gac secteur
            $util = new Application_Model_DbTable_EuUtilisateur();
            $seluti = $util->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $seluti->setIntegrityCheck(false)
                    ->where('code_acteur like ?', $codegacone)
                    ->where('code_membre like ?', $mbgacone);
            $infouti = $gac->fetchAll($seluti);
            $id_user = '';
            $id_user = $infouti[0]->id_utilisateur;
            //Récupération des gac agences liées à la gac secteur
            $sel = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('id_utilisateur = ?', $id_user);
            $listgac = $gac->fetchAll($sel);
            $codegac = array('');
            $mbgac = array('');
            $i = 0;
            foreach ($listgac as $row) {
                $codegac[$i] = $row->code_gac;
                $mbgac[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des gac filières liées à la gac centrale
            $tfil = new Application_Model_DbTable_EuGacFiliere();
            $selfil = $tfil->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selfil->setIntegrityCheck(false)
                    ->where('code_gac in (?)', $codegac);
            $listfil = $tfil->fetchAll($selfil);
            $codefil = array('');
            $mbfil = array('');
            $i = 0;
            foreach ($listfil as $row) {
                $codefil[$i] = $row->code_gac_filiere;
                $mbfil[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des gac créneaux liées aux gac filières
            $tabelc = new Application_Model_DbTable_EuCreneau();
            $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selc->setIntegrityCheck(false)
                    ->where('code_gac_filiere in (?)', $codefil);
            $listcre = $tabelc->fetchAll($selc);
            $codecre = array('');
            $mbcre = array('');
            $i = 0;
            foreach ($listcre as $row) {
                $codecre[$i] = $row->code_creneau;
                $mbcre[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des numéros membre des acteurs liés aux créneaux
            $tabeld = new Application_Model_DbTable_EuActeurCreneau();
            $seld = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $seld->setIntegrityCheck(false)
                 ->where('code_creneau in (?)', $codecre);
            $listact = $tabeld->fetchAll($seld);
            $mbact = array('');
            $i = 0;
            foreach ($listact as $row) {
                $mbact[$i] = $row->code_membre;
                $i++;
            }
            //Liste de alertes
            $select = $tabela->select();
            $select->setIntegrityCheck(false)
                    ->from('eu_alerte', array('*', "to_char((eu_alerte.date_alerte),'dd/mm/yyyy') date_alerte", "to_char((eu_alerte.heure_alerte),'hh:mm') heure_alerte"))
                    ->where('code_membre_acteur like ?', $mbgacone)
                    ->orwhere('code_membre_acteur in (?)', $mbgac)
                    ->orwhere('code_membre_acteur in (?)', $mbfil)
                    ->orwhere('code_membre_acteur in (?)', $mbcre)
                    ->orwhere('code_membre_acteur in (?)', $mbact);
        }
        //########## Cas de la gac protection agence ###########
        if ($group_user == 'gaca_protect') {
            //****Récupération des id_user des acteurs de la gac agence****
            //Formation de la sous requête
            $gac = new Application_Model_DbTable_EuGac();
            $sel = $gac->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                    ->where('code_membre = ?', $user->code_membre);
            $listgac = $gac->fetchAll($sel);
            $codegac = array('');
            $mbgac = array('');
            $i = 0;
            foreach ($listgac as $row) {
                $codegac[$i] = $row->code_gac;
                $mbgac[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des gac filières liées à la gac centrale
            $tfil = new Application_Model_DbTable_EuGacFiliere();
            $selfil = $tfil->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selfil->setIntegrityCheck(false)
                    ->where('code_gac in (?)', $codegac);
            $listfil = $tfil->fetchAll($selfil);
            $codefil = array('');
            $mbfil = array('');
            $i = 0;
            foreach ($listfil as $row) {
                $codefil[$i] = $row->code_gac_filiere;
                $mbfil[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des gac créneaux liées aux gac filières
            $tabelc = new Application_Model_DbTable_EuCreneau();
            $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $selc->setIntegrityCheck(false)
                    ->where('code_gac_filiere in (?)', $codefil);
            $listcre = $tabelc->fetchAll($selc);
            $codecre = array('');
            $mbcre = array('');
            $i = 0;
            foreach ($listcre as $row) {
                $codecre[$i] = $row->code_creneau;
                $mbcre[$i] = $row->code_membre;
                $i++;
            }
            //Récupération des numéros membre des acteurs liés aux créneaux
            $tabeld = new Application_Model_DbTable_EuActeurCreneau();
            $seld = $tabeld->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $seld->setIntegrityCheck(false)
                    ->where('code_creneau in (?)', $codecre);
            $listact = $tabeld->fetchAll($seld);
            $mbact = array('');
            $i = 0;
            foreach ($listact as $row) {
                $mbact[$i] = $row->code_membre;
                $i++;
            }
              //Liste de alertes
              $select = $tabela->select();
              $select->setIntegrityCheck(false)
                     ->from('eu_alerte', array('*', "to_char((eu_alerte.date_alerte),'dd/mm/yyyy') date_alerte", "to_char((eu_alerte.heure_alerte),'hh:mm') heure_alerte"))
                     ->where('code_membre_acteur in (?)', $mbgac)
                     ->orwhere('code_membre_acteur in (?)', $mbfil)
                     ->orwhere('code_membre_acteur in (?)', $mbcre)
                     ->orwhere('code_membre_acteur in (?)', $mbact);
        }

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
            $responce['rows'][$i]['id'] = $row->id_alerte;
            $responce['rows'][$i]['cell'] = array(
                $row->id_alerte,
                $row->code_membre_client,
                $row->code_membre_assureur,
                $row->code_membre_acteur,
                $row->lib_alerte,
                $row->code_smcipn,
                $row->date_alerte,
                $row->heure_alerte
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $z = new Application_Model_EuAlerte();
        $mz = new Application_Model_EuAlerteMapper();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit") {
            $z->setId_alerte($this->_request->getPost("id_alerte"));
            $z->setCode_membre_client($this->_request->getPost("code_membre_client"));
            $z->setCode_membre_assureur($this->_request->getPost("code_membre_assureur"));
            $z->setCode_membre_acteur($this->_request->getPost("code_membre_acteur"));
            $z->setLib_alerte($this->_request->getPost("lib_alerte"));
            $z->setMotif_alerte($this->_request->getPost("motif_alerte"));
            $z->setCode_smcipn($this->_request->getPost("code_smcipn"));
            $z->setDate_alerte($this->_request->getPost("date_alerte"));
            $z->setHeure_alerte($this->_request->getPost("heure_alerte"));
            $z->setId_utilisateur($this->_request->getPost("id_utilisateur"));
            $mz->update($z);
        } elseif ($oper == "add") {
            $z->setId_alerte($this->_request->getPost("id_alerte"));
            $z->setCode_membre_client($this->_request->getPost("code_membre_client"));
            $z->setCode_membre_assureur($this->_request->getPost("code_membre_assureur"));
            $z->setCode_membre_acteur($this->_request->getPost("code_membre_acteur"));
            $z->setLib_alerte($this->_request->getPost("lib_alerte"));
            $z->setMotif_alerte($this->_request->getPost("motif_alerte"));
            $z->setCode_smcipn($this->_request->getPost("code_smcipn"));
            $z->setDate_alerte($this->_request->getPost("date_alerte"));
            $z->setHeure_alerte($this->_request->getPost("heure_alerte"));
            $z->setId_utilisateur($this->_request->getPost("id_utilisateur"));
            $mz->save($z);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("id_alerte");
            $mz->delete($id);
        }
    }

    public function newAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuAlerte();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $date_aler = new Zend_Date(Zend_Date::ISO_8601);
                $date_alerte = clone $date_aler;
                $alert = new Application_Model_EuAlerte($form->getValues());
                $alert->setDate_alerte($date_alerte->toString('yyyy-mm-dd'));
                $alert->setHeure_alerte($date_alerte->toString('hh:mm:ss'));
                $alert->setCode_smcipn($this->_request->getPost("code_demand"));
                $alert->setCode_membre_client($this->_request->getPost("num_client"));
                $alert->setCode_membre_assureur($this->_request->getPost("num_assureur"));
                $alert->setCode_membre_acteur($this->_request->getPost("num_acteur"));
                $alert->setId_utilisateur($user->id_utilisateur);
                $mapper = new Application_Model_EuAlerteMapper();
                $id_alerte=$mapper->findConuter()+1;
                $alert->setId_alerte($id_alerte);
                $mapper->save($alert);
                return $this->_helper->redirector('index');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-alerte',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuAlerte();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        // action body
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $date_aler = new Zend_Date(Zend_Date::ISO_8601);
                $date_alerte = clone $date_aler;
                $alert = new Application_Model_EuAlerte($form->getValues());
                $alert->setId_alerte($this->getRequest()->id_alerte);
                $alert->setCode_membre_client($this->_request->getPost("num_client"));
                $alert->setCode_membre_assureur($this->_request->getPost("num_assureur"));
                $alert->setCode_membre_acteur($this->_request->getPost("num_acteur"));
                $alert->setLib_alerte($this->_request->getPost("lib_alerte"));
                $alert->setMotif_alerte($this->_request->getPost("motif_alerte"));
                $alert->setCode_smcipn($this->_request->getPost("code_demand"));
                $alert->setDate_alerte($date_alerte->toString('yyyy-mm-dd'));
                $alert->setHeure_alerte($date_alerte->toString('hh:mm:ss'));
                $alert->setId_utilisateur($user->id_utilisateur);
                $mapper = new Application_Model_EuAlerteMapper();
                $mapper->update($alert);
                return $this->_helper->redirector('index');
            }
        } else {
            $id_alerte = $request->id;
            $mapper = new Application_Model_EuAlerteMapper();
            $alert = new Application_Model_EuAlerte();
            $mapper->find($id_alerte, $alert);
            if ($alert->getId_alerte() == $id_alerte) {
                $data = array(
                    'id_alerte' => $id_alerte,
                    'num_client' => $alert->getCode_membre_client(),
                    'num_assureur' => $alert->getCode_membre_assureur(),
                    'num_acteur' => $alert->getCode_membre_acteur(),
                    'lib_alerte' => $alert->getLib_alerte(),
                    'motif_alerte' => $alert->getMotif_alerte(),
                    'code_demand' => $alert->getCode_smcipn(),
                    'id_alerte' => $alert->getId_alerte(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-alerte',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function acteurchangeAction() {
        $num_membre = $_GET['acteur'];

        $data = array();
        $table = new Application_Model_DbTable_EuSmcipn();
        $select1 = $table->select();
        $select1->setIntegrityCheck(false)
                ->where("code_membre = ?", $num_membre)
                ->where("etat_demande_inv = ?", 1)
                ->where("domicilier = ?", 1)
                ->where("rembourser = ?", 0);
        $select2 = $table->select();
        $select2->setIntegrityCheck(false)
                ->where("code_membre = ?", $num_membre)
                ->where("domicilier = ?", 1)
                ->where("salaire_alloue > ?", 0)
                ->where("rembourser = ?", 0);
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->union(array($select1, $select2));
        //->order('date_demande', 'desc');
        $bes = $table->fetchAll($select);
        $i = 0;
        foreach ($bes as $value) {
            $date_dem = new Zend_Date($value->date_demande, Zend_Date::ISO_8601);
            $data[$i][1] = $value->code_smcipn;
            $data[$i][2] = ucfirst($value->lib_demande) . '--' . $date_dem->toString('dd/mm/yyyy');
            $i++;
        }
        $this->view->data = $data;
    }

}

