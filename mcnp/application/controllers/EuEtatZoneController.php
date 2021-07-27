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
class EuEtatZoneController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"demsal\" href=\"#\">Salaire en attente</a></li>" .
                "<li><a id=\"deminves\" href=\"/# \">Investissement en attente</a></li>" .
                "<li><a id=\"salalloue\" href=\"#\">Salaire alloué</a></li>" .
                "<li><a id=\"invesalloue\" href=\"#\">Investissement alloué</a></li>".
                "<li><a id=\"salremb\" href=\"#\">Salaire remboursé</a></li>" .
                "<li><a id=\"invesremb\" href=\"#\">Investissement remboursé</a></li>".
                "<li><a id=\"salnremb\" href=\"#\">Salaire non remboursé</a></li>" .
                "<li><a id=\"invesnremb\" href=\"#\">Investissement non remboursé</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'zone') {
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
        $sidx = $this->_request->getParam("sidx", 'code_gac');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuGac();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = eu_gac.code_membre_gestionnaire')
                ->join('eu_zone', 'eu_zone.code_zone = eu_gac.code_zone');
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
            if($row->groupe=='gac'){
                $type='gac simple';
            }else{
                $type='gac pbf';
            }
            $date_create = new Zend_Date($row->date_creation, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_gac;
            $responce['rows'][$i]['cell'] = array(
                $row->code_gac,
                $row->nom_gac,
                $row->code_membre,
                ucfirst($row->nom_zone),
                strtoupper($row->nom_membre) . ' ' . ucfirst($row->prenom_membre),
                $type,
                $row->portable_membre,
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
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.etat_demande_sal = ?', 0)
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.montant_salaire != ?', 0)
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
            $date_dem = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_smcipn;
            $responce['rows'][$i]['cell'] = array(
                $row->code_smcipn,
                ucfirst($row->lib_demande),
                $row->code_membre,
                ceil($row->dvm_demande * 30) . ' jours',
                $row->montant_salaire-$row->salaire_alloue,
                $row->montant_investis,
                ucfirst($row->nom_gac),
                $date_dem->toString('dd/mm/yyyy'),
            );
            $i++;
        }
        $responce['userdata']['dvm_demand'] = 'Totaux:';
        $responce['userdata']['mt_salaire'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $this->view->data = $responce;
    }
    
    public function listsalalloueAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.salaire_alloue != ?', 0)
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
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.allouer_s = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 1)
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
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_sal = ?', 1)
                ->where('eu_smcipn.allouer_s = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0)
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
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.etat_demande_inv = ?', 0)
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.montant_investis != ?', 0)
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
        $responce['userdata']['dvm_demand'] = 'Totaux:';
        $responce['userdata']['mt_salaire'] = $totsal;
        $responce['userdata']['mt_investis'] = $totinves;
        $this->view->data = $responce;
    }
    
    public function listinvesalloueAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.montant_investis != ?', 0)
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
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.allouer_i = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 1)
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
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);

        $select->setIntegrityCheck(false)
                ->join('eu_gac', 'eu_gac.code_gac = eu_smcipn.code_gac')
                ->where('eu_smcipn.valid_gac = ?', 1)
                ->where('eu_smcipn.etat_demande_inv = ?', 1)
                ->where('eu_smcipn.allouer_i = ?', 1)
                ->where('eu_smcipn.rembourser = ?', 0)
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
