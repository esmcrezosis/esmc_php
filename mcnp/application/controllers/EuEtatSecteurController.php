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
class EuEtatSecteurController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"demsal1\" href=\"#\">Salaire en attente</a></li>" .
                "<li><a id=\"deminves1\" href=\"/# \">Investissement en attente</a></li>" .
                "<li><a id=\"salalloue1\" href=\"#\">Salaire alloué</a></li>" .
                "<li><a id=\"invesalloue1\" href=\"#\">Investissement alloué</a></li>" .
                "<li><a id=\"salremb1\" href=\"#\">Salaire remboursé</a></li>" .
                "<li><a id=\"invesremb1\" href=\"#\">Investissement remboursé</a></li>" .
                "<li><a id=\"salnremb1\" href=\"#\">Salaire non remboursé</a></li>" .
                "<li><a id=\"invesnremb1\" href=\"#\">Investissement non remboursé</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'secteur') {
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
//        $sidx = $this->_request->getParam("sidx", 'num_gac_filiere');
//        $sord = $this->_request->getParam("sord", 'asc');
//        $tabela = new Application_Model_DbTable_EuGacFiliere();
//        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
//        $select->setIntegrityCheck(false)
//                ->join('eu_filiere', 'eu_filiere.code_filiere = eu_gac_filiere.filiere')
//                ->join('eu_gac', 'eu_gac.num_gac = eu_gac_filiere.num_gac');
//        $gac_fil = $tabela->fetchAll($select);
        $select = "select f.code_gac_filiere, f.nom_gac_filiere, f.date_creation, f.code_membre, nom_gac, nom_filiere, nom_membre, prenom_membre from eu_gac_filiere f join eu_gac g on f.code_gac =g.code_gac join eu_filiere l on l.id_filiere=f.id_filiere join eu_membre m on m.code_membre=f.code_membre";
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::fetch_obj);
        $gac_fil = $db->fetchAll($select);

        $count = count($gac_fil);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $db->setFetchMode(Zend_Db::fetch_obj);
        $gac_fil = $db->fetchAll($select);
        //$gac_fil = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($gac_fil as $row) {
            $date_create = new Zend_Date($row->date_creation, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_gac_filiere;
            $responce['rows'][$i]['cell'] = array(
                $row->code_gac_filiere,
                ucfirst($row->nom_gac_filiere),
                $row->code_membre,
                ucfirst($row->nom_filiere),
                strtoupper($row->nom_membre) . ' ' . ucfirst($row->prenom_membre),
                ucfirst($row->nom_gac),
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

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.etat_demande_sal = ?', 0)
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.montant_salaire != ?', 0)
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
                ->union(array($select3, $select2, $select1))
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

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.salaire_alloue != ?', 0)
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
                ->union(array($select3, $select2, $select1))
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

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.allouer_s = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 1)
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
                ->union(array($select3, $select2, $select1))
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

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.allouer_s = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0)
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
                ->union(array($select3, $select2, $select1))
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

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.etat_demande_inv = ?', 0)
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.montant_investis != ?', 0)
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
                ->union(array($select3, $select2, $select1))
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

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.montant_investis != ?', 0)
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
                ->union(array($select3, $select2, $select1))
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

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.allouer_i = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 1)
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
                ->union(array($select3, $select2, $select1))
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

        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuGacFiliere();
        $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $sel->setIntegrityCheck(false)
                ->order('date_creation', 'asc');
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
        $select1 = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select1->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.allouer_i = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0)
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
                ->union(array($select3, $select2, $select1))
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
