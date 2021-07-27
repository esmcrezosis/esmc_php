<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuGacController
 *
 * @author user
 */
class EuEtatAgenceController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"demsal2\" href=\"#\">Salaire en attente</a></li>" .
                "<li><a id=\"deminves2\" href=\"/# \">Investissement en attente</a></li>" .
                "<li><a id=\"salalloue2\" href=\"#\">Salaire alloué</a></li>" .
                "<li><a id=\"invesalloue2\" href=\"#\">Investissement alloué</a></li>" .
                "<li><a id=\"salremb2\" href=\"#\">Salaire remboursé</a></li>" .
                "<li><a id=\"invesremb2\" href=\"#\">Investissement remboursé</a></li>" .
                "<li><a id=\"salnremb2\" href=\"#\">Salaire non remboursé</a></li>" .
                "<li><a id=\"invesnremb2\" href=\"#\">Investissement non remboursé</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'agence') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function dataAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $select = "select c.code_creneau, nom_creneau, libelle_type_creneau, nom_membre, prenom_membre, c.date_creation, c.code_membre, nom_gac_filiere from eu_creneaux c join eu_gac_filiere f on f.code_gac_filiere =c.code_gac_filiere join eu_type_creneau t on t.id_type_creneau=c.id_type_creneau join eu_membre m on m.code_membre=c.code_membre";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::fetch_obj);
        $creneau = $db->fetchAll($select);

        $count = count($creneau);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $db->setFetchMode(Zend_Db::fetch_obj);
        $creneau = $db->fetchAll($select);

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($creneau as $row) {
            $date_create = new Zend_Date($row->date_creation, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_creneau;
            $responce['rows'][$i]['cell'] = array(
                $row->code_creneau,
                ucfirst($row->nom_creneau),
                $row->code_membre,
                ucfirst($row->libelle_type_creneau),
                ucfirst($row->nom_membre) . ' ' . ucfirst($row->prenom_membre),
                ucfirst($row->nom_gac_filiere),
                $date_create->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function salairegeneAction() {
        $this->_helper->layout->disableLayout();
    }

    public function salairealloueAction() {
        $this->_helper->layout->disableLayout();
    }

    public function salaireremboursAction() {
        $this->_helper->layout->disableLayout();
    }

    public function salairenremboursAction() {
        $this->_helper->layout->disableLayout();
    }

    public function investisgeneAction() {
        $this->_helper->layout->disableLayout();
    }

    public function investisalloueAction() {
        $this->_helper->layout->disableLayout();
    }

    public function investisremboursAction() {
        $this->_helper->layout->disableLayout();
    }

    public function investisnremboursAction() {
        $this->_helper->layout->disableLayout();
    }

    public function listsalaireAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();

        //Récupération du code des créneaux
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.etat_demande_sal = ?', 0)
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.montant_salaire != ?', 0)
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
        $select3 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.etat_demande_sal = ?', 0)
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.montant_salaire != ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $repc);
        $select->setIntegrityCheck(false)
                ->union(array($select3, $select2))
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

        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire - $row->salaire_alloue,
                $row->montant_investis,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listsalalloueAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();

        
        //Récupération du code des créneaux
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.salaire_alloue != ?', 0)
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
        $select3 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.salaire_alloue != ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $repc);
        $select->setIntegrityCheck(false)
                ->union(array($select3, $select2))
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
        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                $row->salaire_alloue,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listsalremboursAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();

        //Récupération du code des créneaux
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.allouer_s = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 1)
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
        $select3 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.allouer_s = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 1)
                ->where('eu_smcipn.code_membre in (?)', $repc);
        $select->setIntegrityCheck(false)
                ->union(array($select3, $select2))
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
        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listsalnremboursAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();

        //Récupération du code des créneaux
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.allouer_s = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0)
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
        $select3 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.allouer_s = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $repc);
        $select->setIntegrityCheck(false)
                ->union(array($select3, $select2))
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
        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listinvestisAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();

        //Récupération du code des créneaux
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.etat_demande_inv = ?', 0)
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.montant_investis != ?', 0)
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
        $select3 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.etat_demande_inv = ?', 0)
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.montant_investis != ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $repc);
        $select->setIntegrityCheck(false)
                ->union(array($select3, $select2))
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

        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire,
                $row->montant_investis,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listinvesalloueAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();

        //Récupération du code des créneaux
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.montant_investis != ?', 0)
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
        $select3 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.montant_investis != ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $repc);
        $select->setIntegrityCheck(false)
                ->union(array($select3, $select2))
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

        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_investis,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listinvesremboursAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();

        //Récupération du code des créneaux
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.allouer_i = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 1)
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
        $select3 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.allouer_i = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 1)
                ->where('eu_smcipn.code_membre in (?)', $repc);
        $select->setIntegrityCheck(false)
                ->union(array($select3, $select2))
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
        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_investis,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listinvesnremboursAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select();

        //Récupération du code des créneaux
        $tabelc = new Application_Model_DbTable_EuCreneau();
        $selc = $tabelc->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $selc->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select2 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.allouer_i = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0)
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
        $select3 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.allouer_i = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0)
                ->where('eu_smcipn.code_membre in (?)', $repc);
        $select->setIntegrityCheck(false)
                ->union(array($select3, $select2))
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
        foreach ($smcipn as $row) {
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_investis,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

}

?>
