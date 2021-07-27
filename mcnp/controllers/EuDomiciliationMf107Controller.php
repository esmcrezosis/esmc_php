<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuDomiciliationMf107Controller extends Zend_Controller_Action {

    public function init() {

        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"detail\" href=\"/eu-domiciliation-mf107/domicilier\">Domicilier</a></li>" .
                "<li><a id=\"detail\" href=\"/eu-domiciliation-mf107/index\"> Liste des domiciliations </a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'mf' && $group != 'mf_bank') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    public function domicilierAction() {
        
    }

    public function creditsAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'id_mf107');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->getRequest()->code_membre;


        $parametre = new Application_Model_EuParametres;
        $parametre_mapper = new Application_Model_EuParametresMapper();


        $dom = new Application_Model_EuDomicilieMf107;
        $dom_mapper = new Application_Model_EuDomicilieMf107Mapper;


        $ddom = new Application_Model_EuDetailDomicilieMf107;
        $ddom_mapper = new Application_Model_EuDetailDomicilieMf107Mapper;


        $membre = new Application_Model_EuMembreFondateur107;
        $mapper = new Application_Model_EuMembreFondateur107Mapper();


        $parametre_mapper->find('mf107', 'valeur', $parametre);
        $mf107 = $parametre->getMontant();


        $tabela = new Application_Model_DbTable_EuDetailMf107();


        if ($code_membre != '') {
            $select = $tabela->select();
            $select->where('code_membre = ?', $code_membre);
            $select->where('mont_apport > ?', 0);
        }


        $membres = $tabela->fetchAll($select);
        $count = count($membres);


        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $agences = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($agences as $row) {

            $date_apport = new Zend_Date($row->date_mf107, Zend_Date::ISO_8601);
            $mapper->find($row->numident, $membre);
            $nb = $membre->getNb_repartition();
            $code_membre = $membre->getCode_membre();
            $mf107 = $parametre->getMontant();
            $sum_dom = $dom_mapper->getSumDomicilie($row->id_mf107);

            if ($code_membre != $row->code_membre) {
                $montant = ($row->mont_apport - ($row->mont_apport * $row->pourcentage) / 100) - $sum_dom;
            } else {
                $montant = $row->mont_apport - $sum_dom;
            }

            if ($nb == 1) {
                $rep = $mf107;
            } else {
                $rep = $mf107 - $nb + 1;
            }
            $responce['rows'][$i]['id'] = $row->id_mf107;
            $responce['rows'][$i]['cell'] = array(
                $row->numident,
                $row->mont_apport,
                $montant,
                $montant,
                $rep,
                $date_apport->toString('dd/mm/yyyy'),
                $row->id_mf107
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_dom');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomicilieMf107();
        $select = $tabela->select();
        $select->where('eu_domicilie_mf107.id_utilisateur = ?', $user->id_utilisateur)
                ->order('eu_domicilie_mf107.date_dom', 'desc');
        $domici = $tabela->fetchAll($select);
        $count = count($domici);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;

        $domici = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($domici as $row) {
            $date_domi = new Zend_Date($row->date_dom, Zend_Date::ISO_8601);
            $heure_domi = new Zend_Date($row->heure_dom, Zend_Date::ISO_8601);
            if ($row->etat_domiciliation == 0) {
                $accord = 'En cours';
            } else {
                $accord = 'Terminer';
            }
            $responce['rows'][$i]['id'] = $row->id_dom;
            $responce['rows'][$i]['cell'] = array(
                $row->id_dom,
                $row->code_membre,
                $row->mt_domiciliation,
                $row->mt_domicilie,
                $date_domi->toString('dd/mm/yyyy'),
                $heure_domi->toString('hh:mm'),
                $accord,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function createAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;

        $selection = array();
        $selection = $_GET['lignes'];
        $mt_domi = $_GET['mt_domi'];
        $code_membre = $_GET['membre'];

        $parametre = new Application_Model_EuParametres;
        $parametre_mapper = new Application_Model_EuParametresMapper();

        $parametre_mapper->find('mf107', 'valeur', $parametre);
        $mf107 = $parametre->getMontant();

        $membre = new Application_Model_EuMembreFondateur107();
        $mapper = new Application_Model_EuMembreFondateur107Mapper();

        $dom = new Application_Model_EuDomicilieMf107();
        $dom_mapper = new Application_Model_EuDomicilieMf107Mapper();

        $ddom = new Application_Model_EuDetailDomicilieMf107();
        $ddom_mapper = new Application_Model_EuDetailDomicilieMf107Mapper();

        $somme = 0;
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                foreach ($selection as $val) {
                    $numident = $val['numident'];
                    $nb_repartition = $mapper->findnbrep($numident);
                    $nb_repartition = $mf107 - $nb_repartition;
                    if ($nb_repartition < $val['nb_repartition']) {
                        $this->view->data = 'cool';
                        return;
                    } else if ($val['mt_utilise'] > $val['mt_reel']) {
                        $this->view->data = 'erreur';
                        return;
                    } else {
                        $somme = $somme + ($val['mt_utilise'] * $val['nb_repartition']);
                    }
                }

                if ($somme < $mt_domi) {
                    $this->view->data = 'err_domi';
                    return;
                }

                $dom->setMt_domiciliation($mt_domi);
                $dom->setMt_domicilie(0);
                $dom->setEtat_domiciliation(0);
                $dom->setCode_membre($code_membre);
                $dom->setDate_dom($date_domi->toString('yyyy-mm-dd'));
                $dom->setHeure_dom($date_domi->toString('hh:mm'));
                $dom->setId_utilisateur($user->id_utilisateur);
                $dom_mapper->save($dom);

                $maxdom = $dom_mapper->findMaxDom();

                foreach ($selection as $val) {
                    $ddom->setId_dom($maxdom);
                    $ddom->setId_mf107($val['id_mf107']);
                    $ddom->setMt_domi_apport($val['mt_utilise']);
                    $ddom->setNb_rep($val['nb_repartition']);
                    $ddom->setNb_reste($val['nb_repartition']);
                    $ddom_mapper->save($ddom);
                }
                $db->commit();
                $this->view->data = 'good';
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
                $this->view->data = 'bad';
                return;
            }
        }
    }


    public function membreAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }
	
	
	public function recupnombenefAction() {
           $request = $this->getRequest();
           $num_membre = $request->num_membre;
           $membre = new Application_Model_DbTable_EuMembre;
           $select = $membre->select();
           $select->from($membre, array('nom_membre', 'prenom_membre'));
           $select->where('code_membre = ?', $num_membre);
           $result = $membre->fetchAll($select);
           if (count($result) > 0) {
              $row = $result->current();
              $data[0] = strtoupper($row->nom_membre);
              $data[1] = ucfirst($row->prenom_membre);
           }  else {
              $data = '';
           }
           $this->view->data = $data;  
    }
    
    
    
    public function recupnomAction() {
        
           $request = $this->getRequest();
           $num_membre = $request->num_membre;
           $membre = new Application_Model_DbTable_EuMembre;
           $select = $membre->select();
           $select->from($membre, array('type_membre','nom_membre', 'prenom_membre','raison_sociale'));
           $select->where('code_membre = ?', $num_membre);
           $result = $membre->fetchAll($select);
           if (count($result) > 0) {
              $row = $result->current();
			  if($row->type_membre=='p') {
                $data[0] = strtoupper($row->nom_membre)." ".ucfirst($row->prenom_membre);
			  }
			  else {
			    $data[0] = ucfirst($row->raison_sociale); 
			  }
           }  else {
              $data = '';
           }
           $this->view->data = $data;  
    }
	
	
	
	public function listcreditsAction() {
	
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 30);
        $sidx = $this->_request->getParam("sidx", 'code_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        $request = $this->getRequest();
        $id_domi = $request->id_domi;
        $tabela = new Application_Model_DbTable_EuDetailDomicilieMf107();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
               ->from(array('d'=>'eu_detail_domicilie_mf107'), array('id_mf107', 'mont' => 'mt_domi_apport', 'nb_rep', 'nb_reste'))
               ->join(array('c'=>'eu_detail_mf107'), 'c.id_mf107 = d.id_mf107', array('code_membre'))
               ->where('d.id_dom = ?', $id_domi);
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
            $responce['rows'][$i]['id'] = $row->id_mf107;
            $responce['rows'][$i]['cell'] = array(
                $row->id_mf107,
                $row->code_membre,
                $row->mont,
                $row->nb_rep,
                $row->nb_reste
            );
            $i++;
        }
        $this->view->data = $responce;
    }
	
	

}
?>
