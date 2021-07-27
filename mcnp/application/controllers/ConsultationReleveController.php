<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConsultationController
 *
 * @author user
 */
 
//<li><a id="compte" href="/consultation/compte">Comptes</a></li>
//<li><a id="operation" href="/consultation/operations">Opérations</a></li>
//<li><a id="credit" href="/consultation/index">Consultation</a></li>
 
 
class ConsultationReleveController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        /* Initialize action controller here */
        $menu = '<li><a id="salaire" href="/consultation/salaire">Bons salaires</a></li>
		        <li><a id="credit" href="/consultation/credit">Bons consommations</a></li>
		        <li><a id="credit" href="/consultation/gcp">Recettes vendeurs</a></li>
				<li><a id="credit" href="/consultation/kacm">KACM</a></li>'
				;
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $this->view->user = $user;
        }
    }

    public function dataAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_operation');
        $sord = $this->_request->getParam("sord", 'asc');
        $compte = $this->_request->getParam('compte');
        $produit = $this->_request->getParam('produit');
        $membre = $this->_request->getParam('membre');
        $type = $this->_request->getParam('type');
        $datedeb = $this->_request->getParam('date_deb');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select();
        if ($compte != '') {
            $select->where('code_cat = ?', $compte);
        }
        if ($membre != '' or $membre != null) {
            $select->where('code_membre = ?', $membre);
        }
        if ($produit != '') {
            $select->where('code_produit = ?', $produit);
        }
        if ($type != '') {
            $select->where('type_op like ?', $type);
        }
        if ($datedeb != '') {
            $date1 = explode("/", $datedeb);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('date_op = ?', $dated);
        }
        $select->group('type_op');
        $select->group('code_membre');
        $select->group('date_op');
        $select->order('date_op', 'asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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
                $date_op->toString('dd/mm/yyyy'),
                $row->type_op,
                $row->code_membre,
                $row->lib_op,
                $row->code_cat,
                $row->code_produit,
                $row->montant_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function indexAction() {
        
    }

    public function creditAction() {
        
    }

    public function compteAction() {
        
    }

    public function operationsAction() {
        
    }
	
	
	
	
	public function kacmAction()  {
	        $request = $this->getRequest();
		    $code_membre  = '';
			$designation  = '';
			$fs           = 0;
			$fl           = 0;
			$fcps         = 0;
		    $kacm         = 0;
		   
		   
		    if ($this->getRequest()->isPost()) {
			    $code_membre = $request->code_membre_kacm;
				$designation = $request->design_membre_kacm;
				$db_fs = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fs = $db_fs->select();
				$select_fs->from($db_fs,array('SUM(CreditAmount) as somme_fs'));
                $select_fs->where('DestAccount_Consumed = ?','NB-TFS-'.$code_membre);
                $result_fs = $db_fs->fetchAll($select_fs);
		        $row_fs = $result_fs->current();
		        $fs = $row_fs['somme_fs'];
				
				$db_fl = new Application_Model_DbTable_EuAncienFl();
				$select_fl = $db_fl->select();
				$select_fl->from($db_fl,array('SUM(mont_fl) as somme_fl'));
                $select_fl->where('code_membre = ?', $code_membre);
                $result_fl = $db_fl->fetchAll($select_fl);
		        $row_fl = $result_fl->current();
		        $fl = $row_fl['somme_fl'];
				
				$db_cartes = new Application_Model_DbTable_EuAncienCartes();
				$select_cartes = $db_cartes->select();
				$select_cartes->from($db_cartes,array('SUM(mont_carte) as somme_carte'));
                $select_cartes->where('code_membre = ?', $code_membre);
                $result_cartes = $db_cartes->fetchAll($select_cartes);
		        $row_cartes = $result_cartes->current();
		        $fcps = $row_cartes['somme_carte'];
	       
	        }
			$this->view->code_membre    = $code_membre;
			$this->view->designation    = $designation;
		    $this->view->kacm           = ($fs + $fl + $fcps);
			
			
			
	}
	
	
	
	
	
	
	
	public function salaireAction()    {
	        $request = $this->getRequest();
		    $code_membre  = '';
			$designation  = '';
			$cncs         = 0;
			$escompte     = 0;
			$echange      = 0;
		    $soldenr      = 0;
		    $soldenn      = 0;
		    $code_membre = '';
		    if ($this->getRequest()->isPost()) {
	            $code_membre = $request->code_membre_recap;
				$designation = $request->design_membre_recap;
				
				$db_cccncs = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_cccncs = $db_cccncs->select();
				$select_cccncs->from($db_cccncs,array('SUM(montant_place) as somme_cccncs'));
                $select_cccncs->where('code_membre = ?', $code_membre);
				$select_cccncs->where('code_produit in (?)',array('CNCSr','CNCSnr'));
                $result_cccncs = $db_cccncs->fetchAll($select_cccncs);
		        $row_cccncs = $result_cccncs->current();
		        $cncs = $row_cccncs['somme_cccncs'];
				
				
				$db_escompte     = new Application_Model_DbTable_EuAncienEchange();
				$select_escompte = $db_escompte->select();
				$select_escompte->from($db_escompte,array('SUM(montant) as somme_escompte'));
                $select_escompte->where('code_membre = ?', $code_membre);
				$select_escompte->where('type_echange like ?','NR/NN');
                $result_escompte   = $db_escompte->fetchAll($select_escompte);
		        $row_escompte = $result_escompte->current();
		        $escompte = $row_escompte['somme_escompte'];
				
				
				$db_echange      = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_echange  = $db_echange->select();
				$select_echange->from($db_echange,array('SUM(montant_place) as somme_echange'));
                //$select_echange->where('code_membre = ?', $code_membre);
				$select_echange->where('compte_source like ?','NR-TCNCS-'.$code_membre);
				$select_echange->orwhere('compte_source like ?','NN-TCNCS-'.$code_membre);
                $result_echange   = $db_echange->fetchAll($select_echange);
		        $row_echange = $result_echange->current();
		        $echange = $row_echange['somme_echange'];
				
				
				/*
				$db_ccnr = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_ccnr = $db_ccnr->select();
				$select_ccnr->from($db_ccnr,array('SUM(montant_credit) as somme_ccnr'));
                $select_ccnr->where('code_membre = ?', $code_membre);
				$select_ccnr->where('code_produit in (?)',array('CNCSr','CNCSnr'));
                $result_ccnr = $db_ccnr->fetchAll($select_ccnr);
		        $row_ccnr = $result_ccnr->current();
		        $soldenr = $row_ccnr['somme_ccnr'];*/
				
				
				
                 
				if(substr($code_membre,19,1) == 'M')  {
				    $db_cnn = new Application_Model_DbTable_EuAncienCompte();
				    $select_cnn = $db_cnn->select();
				    $select_cnn->from($db_cnn,array('SUM(solde) as somme_cnn'));
                    $select_cnn->where('code_membre = ?', $code_membre);
				    $select_cnn->where('code_cat in (?)',array('TCNCSEI','TPN','TCNCS'));
                    $result_cnn = $db_cnn->fetchAll($select_cnn);
		            $row_cnn = $result_cnn->current();
		            $soldenn = $row_cnn['somme_cnn'];
				
				} else {
				    $soldenn = abs($cncs-$escompte-$echange);
				
				}


				
	        }
			$this->view->code_membre    = $code_membre;
			$this->view->designation    = $designation;
		    $this->view->cncs           = $cncs;
			$this->view->escompte       = $escompte;
			$this->view->echange        = $echange;
		    $this->view->soldenn        = $soldenn;
			   
	}
	
	
	
	public function gcpAction() {
        // action body
		$request = $this->getRequest();
		$code_membre  = '';
		$designation  = '';
		$gcp          = 0;
		$escompte     = 0;
		$echange      = 0;
		$reste        = 0;
		$echu         = 0;
		/*
		if ($this->getRequest()->isPost()) {
		   $code_membre = $request->code_membre_recap;
		   $designation = $request->design_membre_recap;
		   $db_gcp = new Application_Model_DbTable_EuAncienGcp();
		   $select_gcp = $db_gcp->select();
           $select_gcp->from($db_gcp,array('SUM(mont_gcp) as somme_gcp'));
           $select_gcp->where('code_membre = ?', $code_membre);
           $result_gcp = $db_gcp->fetchAll($select_gcp);
		   $row_gcp = $result_gcp->current();
		   $gcp = $row_gcp['somme_gcp'];
		   
		   
		   $db_escompte = new Application_Model_DbTable_EuAncienEscompte();
		   $select_escompte = $db_escompte->select();
		   $select_escompte->from($db_escompte,array('SUM(montant) as somme_escompte'));
		   $select_escompte->where('code_membre = ?', $code_membre);
		   $result_escompte = $db_escompte->fetchAll($select_escompte);
		   $row_escompte = $result_escompte->current();
		   $escompte = $row_escompte['somme_escompte'];
		   
		   
		   $db_echange = new Application_Model_DbTable_EuAncienEchange();
		   $select_echange = $db_echange->select();
		   $select_echange->from($db_echange,array('SUM(montant) as somme_echange'));
		   $select_echange->where('code_membre = ?', $code_membre);
		   $select_echange->where('type_echange = ?','NB/NB');
		   $result_echange = $db_echange->fetchAll($select_echange);
		   $row_echange = $result_echange->current();
		   $echange = $row_echange['somme_echange'];
		   $reste = floor($gcp - $escompte - $echange);
		   
		   
		   $db_tpagcp = new Application_Model_DbTable_EuAncienTpagcp();
		   $select_tpagcp = $db_tpagcp->select();
		   $select_tpagcp->from($db_tpagcp,array('SUM(mont_echu) as somme_echu'));
		   $select_tpagcp->where('code_membre = ?', $code_membre);
		   $result_tpagcp = $db_tpagcp->fetchAll($select_tpagcp);
		   $row_tpagcp = $result_tpagcp->current();
		   $echu = $row_tpagcp['somme_echu'];
		   
		   
		   
		   
		   
		   
		}*/
		
		$this->view->code_membre = $code_membre;
		$this->view->designation = $designation;
		$this->view->gcp         = $gcp;
		$this->view->escompte    = $escompte;
		$this->view->echange     = $echange;
		$this->view->reste       = $reste;
		$this->view->echue       = $echu;
		
		
    }
	
	

    public function comptesAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_compte');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCompte();
        $compte = $this->_request->getParam('numero');
        $membre = $this->_request->getParam('membre');
        $type = $this->_request->getParam('type');
        $select = $tabela->select();
        if ($compte != '') {
            $select->where('code_cat = ?', $compte);
        }
        if ($membre != '' or $membre != null) {
            $select->where('code_membre = ?', $membre);
        }
        if ($type != '' or $type != null) {
            $select->where('code_type_compte = ?', $type);
        }
        $select->order('code_type_compte', 'asc');
        $select->order('code_compte', 'asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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
            //$date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_compte;
            $responce['rows'][$i]['cell'] = array(
                $row->code_compte,
                $row->code_type_compte,
                $row->code_cat,
                $row->code_membre,
                $row->solde,
                $row->lib_compte,
                $row->date_alloc
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function creditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCompteCredit();
        $code = $this->_request->getParam('code');
        $select = $tabela->select();
        $select->from($tabela, array('id_credit', 'code_membre', 'code_produit', 'montant_place', 'montant_credit', 'code_compte'));
        if ($code != '' or $code != null) {
            $select->where('code_compte = ?', $code);
        }
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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
            //$date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->code_compte,
                $row->code_membre,
                $row->code_produit,
                $row->montant_place,
                $row->montant_credit
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function catAction() {
        $t_compte = new Application_Model_DbTable_EuProduit();
        $select = $t_compte->select();
        $results = $t_compte->fetchAll($select);
        $rows = array();
        for ($i = 0; $i < count($results); $i++) {
            $value = $results[$i];
            $rows[$i][0] = $value->code_produit;
            $rows[$i][1] = $value->libelle_produit;
        }
        $this->view->data = $rows;
    }

    public function catcompteAction() {
        $t_compte = new Application_Model_DbTable_EuCategorieCompte();
        $select = $t_compte->select();
        $select->where('code_cat like ?', 't%');
        $results = $t_compte->fetchAll($select);
        $rows = array();
        foreach ($results as $value) {
            $rows[] = $value->code_cat;
        }
        $this->view->data = $rows;
    }
	
	public function membremoraleAction() {
           $t_membre = new Application_Model_DbTable_EuAncienMembre();
           $select = $t_membre->select();
           $select->where('type_membre like ?', 'M');
           $results = $t_membre->fetchAll($select);
           $rows = array();
            foreach ($results as $value) {
              $rows[] = $value->ancien_code_membre;
            }
            $this->view->data = $rows;
    }
	
	

    public function membreAction() {
        $m_map = new Application_Model_EuAncienMembreMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->ancien_code_membre;
        }
        $this->view->data = $membres;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuAncienMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            if ($result->type_membre == 'M') {
                $data[0] = $result->raison_sociale;
            } else {
			    $data[0] = strtoupper($result->nom_membre).' '.ucfirst($result->prenom_membre);
			}
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

	
	
	public function consultAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_gcp');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->_request->getParam("code_membre");
        $tabela = new Application_Model_DbTable_EuAncienGcp();
		//if ($code_membre != '' || $code_membre != null) {
            $select = $tabela->select()->setIntegrityCheck(false);
            $select->from($tabela, array('id_gcp','date_conso', 'mont_gcp', 'mont_preleve', 'reste', 'code_cat', 'id_credit'))
		           ->join('eu_ancien_compte_credit', 'eu_ancien_compte_credit.id_credit = eu_ancien_gcp.id_credit', array('code_membre', 'code_produit'));
            $select->order('eu_ancien_gcp.date_conso asc');
			if ($code_membre != '' || $code_membre != null) {
			   $select->where('eu_ancien_gcp.code_membre like ?',$code_membre);
			}
            $achats = $tabela->fetchAll($select);
            $count = count($achats);

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
        $tot_prel = 0;
        $tot_gcp = 0;
        $tot_reste = 0;
        foreach ($achats as $row) {
            $date_op = new Zend_Date($row->date_conso,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_gcp;
            $responce['rows'][$i]['cell'] = array(
			    $row->id_gcp,
				$row->code_membre,
				$row->code_produit,
				$row->mont_gcp,
                $date_op->toString('dd/MM/yyyy'),
                
            );
            //$tot_prel += $row->mont_preleve; 
            $tot_gcp += $row->mont_gcp; 
            //$tot_reste += $row->reste;
            $i++;
        }
        //$responce['userdata']['mont_preleve'] = $tot_prel; 
        $responce['userdata']['mont_gcp'] = $tot_gcp;
        //$responce['userdata']['reste'] = $tot_reste; 
        $responce['userdata']['code_membre'] = 'Totaux:';
        $this->view->data = $responce ;//$select->__toString();
    }
	
	
	public function detailsalaireAction() {
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->_request->getParam("code_membre");
        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
		   
		if ($code_membre != '' || $code_membre != null) {
            $select->where('eu_ancien_compte_credit.code_membre = ?',$code_membre);
		} else {
            $code_membre = '%';
        }
		$select->where('eu_ancien_compte_credit.code_produit in (?)', array('CNCSnr','CNCSr'));
		$select->order('eu_ancien_compte_credit.date_octroi asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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
        $tot_ech = 0;
        foreach ($achats as $row) {
            $date_op = new Zend_Date($row->date_octroi,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
			  $row->id_credit,
              $row->compte_source,
			  $row->code_produit,
              $row->montant_place,
              $date_op->toString('dd/MM/yyyy')  
            );
            $tot_ech += $row->montant_place;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_ech;
        $responce['userdata']['code_produit'] = 'Totaux:';
        $this->view->data = $responce;
	
	
	}
	
	public function echangesalaireAction() {
	
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->_request->getParam("code_membre");
        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
	    if ($code_membre != '' || $code_membre != null) {
           //$select->where('eu_ancien_compte_credit.code_membre = ?',$code_membre);
		} else {
           $code_membre = '%';
        }		
		$select->where('eu_ancien_compte_credit.compte_source like ?','NR-TCNCS-'.$code_membre);
		$select->orwhere('eu_ancien_compte_credit.compte_source like ?','NN-TCNCS-'.$code_membre);
		$select->order('eu_ancien_compte_credit.date_octroi asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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
        $tot_ech = 0;
        //$tot_agio = 0;
        foreach ($achats as $row) {
            $date_op = new Zend_Date($row->date_octroi,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
			    $row->id_credit,
                $row->compte_source,
				$row->code_compte,
                $row->montant_place,
                $date_op->toString('dd/MM/yyyy')
                
            );
            $tot_ech += $row->montant_place;
            //$tot_agio += $row->agio;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_ech;
        //$responce['userdata']['agio'] = $tot_agio;
        $responce['userdata']['code_compte'] = 'Totaux:';
        $this->view->data = $responce;
	       
	
	
	
	}
	
	

	public function escomptesalaireAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->_request->getParam("code_membre");
        $tabela = new Application_Model_DbTable_EuAncienEchange();
        $select = $tabela->select();
		if ($code_membre != '' || $code_membre != null) {
           $select->where('eu_ancien_echange.code_membre = ?',$code_membre);
		}
		$select->where('eu_ancien_echange.type_echange like ?','NR/NN');
        $select->order('date_echange asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);
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
        $tot_ech = 0;
        foreach ($achats as $row) {
            $date_op = new Zend_Date($row->date_echange,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
			   $row->id_echange,
               $row->cat_echange,
			   $row->code_compte_obt,
               $row->montant,
               $date_op->toString('dd/MM/yyyy')  
            );
            $tot_ech += $row->montant;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_ech;
        $responce['userdata']['code_compte_obt'] = 'Totaux:';
        $this->view->data = $responce;
	}
	
	
	
	public function echangeAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_echange');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->_request->getParam("code_membre");
        $tabela = new Application_Model_DbTable_EuAncienEchange();
        $select = $tabela->select();
		
		if ($code_membre != '' || $code_membre != null) {
           $select->where('eu_ancien_echange.code_membre like ?', $code_membre);
		}   
		$select->where('eu_ancien_echange.type_echange like ?','NB/NB');
        $select->order('date_echange asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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
        $tot_ech = 0;
        //$tot_agio = 0;
        foreach ($achats as $row) {
            $date_op = new Zend_Date($row->date_echange,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_echange;
            $responce['rows'][$i]['cell'] = array(
			    $row->id_echange,
                $row->type_echange,
				$row->code_compte_obt,
                $row->montant,
                $date_op->toString('dd/MM/yyyy')
                
            );
            $tot_ech += $row->montant;
            //$tot_agio += $row->agio;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_ech;
        //$responce['userdata']['agio'] = $tot_agio;
        $responce['userdata']['code_compte_obt'] = 'Totaux:';
        $this->view->data = $responce;
    }
	
	
	
	public function escomptesAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_escompte');
        $sord = $this->_request->getParam("sord", 'asc');
		$code_membre = $this->_request->getParam("code_membre");
		
        $tabela = new Application_Model_DbTable_EuAncienEscompte();
        $select = $tabela->select()->setIntegrityCheck(false);
		$select->from($tabela,array('*'));
		$select->join('eu_ancien_membre','eu_ancien_membre.ancien_code_membre = eu_ancien_escompte.code_membre_benef');
		if ($code_membre != '' || $code_membre != null) {
            $select->where('eu_ancien_escompte.code_membre like ?',$code_membre);
		}
        $select->order('eu_ancien_escompte.date_escompte asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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

        $tot_mont = 0;
        foreach ($achats as $row) {
		    $date_op = new Zend_Date($row->date_escompte,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_escompte;
            $responce['rows'][$i]['cell'] = array(
                $row->id_escompte,
                $row->code_membre_benef,
                $row->raison_sociale,
                $row->montant,
				$date_op->toString('dd/MM/yyyy')    
            );
            $tot_mont += $row->montant;
            $i++;
        }
        $responce['userdata']['montant'] = $tot_mont;
        $responce['userdata']['raison_sociale'] = 'Totaux:';
        $this->view->data = $responce;
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function creditconsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_consommation');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCreditConsommer();
        $id_credit = $this->_request->getParam('id_credit');
        $membre = $this->_request->getParam('membre');
        $select = $tabela->select();
        $select->from($tabela);
        if ($id_credit != '') {
            $select->where('id_credit = ?', $id_credit);
        }
        if ($membre != '' or $membre != null) {
            $select->where('code_membre = ?', $membre);
        }
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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
            //$date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_consommation;
            $responce['rows'][$i]['cell'] = array(
                $row->id_consommation,
                $row->code_membre,
                $row->code_produit,
                $row->mont_consommation,
                $row->date_consommation,
                $row->code_membre_dist
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function datacreditAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'ASC');
        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $compte = $this->_request->getParam('produit');
        $membre = $this->_request->getParam('membre');
		$origine = $this->_request->getParam('origine');
		
		
		if($membre != '' && $compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else
		if($compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->order('date_octroi asc');
		} else
        if ($compte != '' or $compte != null) {
		    $select = $tabela->select();
            $select->where('code_produit = ?', $compte);
			$select->order('date_octroi asc');
        } else
		if ($origine != '' or $origine != null) {
		    $select = $tabela->select();
            $select->where('compte_source like ?',$origine.'%');
		    $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
            			
        } else
        if ($membre != '' or $membre != null) {
		    $select = $tabela->select();
            $select->where('code_membre = ?', $membre);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
			$select->order('date_octroi asc');
        } else {
		    $select = $tabela->select();
            $select->from($tabela);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
		}
        		
		
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

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
        $total_capa = 0;
        $total_credit = 0;
        foreach ($achats as $row) {
            $date_deb = new Zend_Date($row->datedeb);
            $date_fin = new Zend_Date($row->datefin);
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->id_credit,
                $row->code_membre,
                $row->code_produit,
                $row->montant_place,
                $row->montant_credit,
                $date_deb->toString('dd/MM/yyyy'),
                $date_fin->toString('dd/MM/yyyy'),
                $row->source,
                $row->date_octroi,
                $row->compte_source,
                $row->krr,
                $row->domicilier,
                $row->bnp,
                $row->id_operation,
                $row->code_compte
            );
			$total_capa   += $row->montant_place;
            $total_credit += $row->montant_credit;
            $i++;
			
        }
		$responce['userdata']['montant_place'] = $total_capa;
        $responce['userdata']['montant_credit'] = $total_credit;
        $responce['userdata']['code_produit'] = 'Totaux:';
        $this->view->data = $responce;
    }










    public function pdfconsultAction() {
    
	
        /* page consultation/pdfconsult - Génération de relevé en PDF */

		$this->_helper->layout->disableLayout();
		
		include("Transfert.php");
		

        $compte = $_POST['code_produit'];
        $membre = $_POST['rech_membre'];
		$origine = $_POST['origine_ressource'];

if($origine == "CAPA"){$origine_text = "KAPA Espèce";
}else if($origine == "NN"){$origine_text = "KAPA NN";
}else if($origine == "NB"){$origine_text = "KAPA GCP";
}else if($origine == "NR"){$origine_text = "KAPA CNCS";
}else{$origine_text = "";}




        if ($compte != "" || $membre != "" || $origine != "") {

$date_id = new Zend_Date(Zend_Date::ISO_8601);

$membree = new Application_Model_EuAncienMembre();
$mapper_membree = new Application_Model_EuAncienMembreMapper();
$mapper_membree->find($membre, $membree);
if (substr($membre, -1) == "P") {
$nom_membree = $membree->nom_membre.' '.$membree->prenom_membre;
} else if (substr($membre, -1) == "M") {
$nom_membree = $membree->raison_sociale;
}

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
        $select->from($tabela);
		
		if($membre != '' && $compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else
		if($compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->order('date_octroi asc');
		} else
        if ($compte != '' or $compte != null) {
		    $select = $tabela->select();
            $select->where('code_produit = ?', $compte);
			$select->order('date_octroi asc');
        } else
		if ($origine != '' or $origine != null) {
		    $select = $tabela->select();
            $select->where('compte_source like ?',$origine.'%');
		    $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
            			
        } else
        if ($membre != '' or $membre != null) {
		    $select = $tabela->select();
            $select->where('code_membre = ?', $membre);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
			$select->order('date_octroi asc');
        } else {
		    $select = $tabela->select();
            $select->from($tabela);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
		}
        		
		
        $achats = $tabela->fetchAll($select);



$html = "";

$html .= '
    <page_footer>
        <table>
      <tr>
        <td align="right">
		<barcode type="C128B" value="'.$membre.'" style="width:150mm; height:10mm;" label="none"></barcode>
		</td>
      </tr>
<tr>
	<td><hr></td>
</tr>
<tr>
    <td align="center">Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploration du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet<br />
RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425</td>
  </tr>
<tr>
	<td style="width: 34%; text-align: center">[[page_cu]]/[[page_nb]]</td>
</tr>
        </table>
    </page_footer>


<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="http://testing.gacsource.net/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>
<strong><u><h3>RELEVE ANCIEN BON DE CONSOMMATION</h3></u></strong>
Membre : '.$nom_membree.' <strong style="font-size:16px;">('.$membre.')</strong><br />
Date d&rsquo;émission  du relevé : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Critères de recherche<br />
	Produit : <strong>'.$compte.'.</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Origine : <strong>'.$origine_text.'.</strong>
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>';

if(count($achats)>0){	 
$total_montant_place = 0; 
$total_montant_credit = 0; 
$html .= '
  <tr>
    <td colspan="2" width="60%"><table border="0" cellpadding="0" cellspacing="0">
      <tr style="background-color:#CCC;">
        <th align="center" style="border:1px solid #CCC;">Produit</th>
        <th align="center" style="border:1px solid #CCC;">Montant Capa</th>
        <th align="center" style="border:1px solid #CCC;">Montant Bon</th>
        <th align="center" style="border:1px solid #CCC;">Date Début</th>
        <th align="center" style="border:1px solid #CCC;">Date Fin</th>
      </tr>';
	  $i = 1;
foreach ($achats as $entry):
            $date_deb = new Zend_Date($entry->datedeb);
            $date_fin = new Zend_Date($entry->datefin);
			
$total_montant_place += $entry->montant_place; 
$total_montant_credit += $entry->montant_credit; 

$html .= '
      <tr>
        <td align="center" style="border:1px solid #CCC;">'.$entry->code_produit.'</td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($entry->montant_place, 0, ',', ' ').'</td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($entry->montant_credit, 0, ',', ' ').'</td>
        <td align="center" style="border:1px solid #CCC;">'.$date_deb->toString('dd/MM/yyyy').'</td>
        <td align="center" style="border:1px solid #CCC;">'.$date_fin->toString('dd/MM/yyyy').'</td>
      </tr>';
	  if($i == 30){
$html .= '
      <tr>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table><br />
<br />
<br />
<br />
<br />
<br />
<br />

<table width="768" border="0">
  <tr>
    <td colspan="2" width="60%"><table border="0" cellpadding="0" cellspacing="0">
      <tr style="background-color:#CCC;">
        <th align="center" style="border:1px solid #CCC;">Produit</th>
        <th align="center" style="border:1px solid #CCC;">Montant Capa</th>
        <th align="center" style="border:1px solid #CCC;">Montant Bon</th>
        <th align="center" style="border:1px solid #CCC;">Date Début</th>
        <th align="center" style="border:1px solid #CCC;">Date Fin</th>
      </tr>
	  	  ';
	  $i = -18;
		  }
	  $i++;
endforeach;
$html .= '
      <tr>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td align="right" style="border:1px solid #CCC;">&nbsp; Totaux : &nbsp;</td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($total_montant_place, 0, ',', ' ').'</td>
        <td align="right" style="border:1px solid #CCC;">'.number_format($total_montant_credit, 0, ',', ' ').'</td>
        <td align="center" style="border:1px solid #CCC;">&nbsp;</td>
        <td align="center" style="border:1px solid #CCC;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>';
	}	  
$html .= '
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
</table>

';

		

////////////////////////////////////////////////////////////////////////////////
//$filename = '/html/mcnp/public/releve.html';
$filename = '/var/www/html/mcnp/public/releve.html';
$somecontent = $html;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("../../webfiles/pdf_releve/")) {
mkdir("../../webfiles/pdf_releve/", 0777);
}

$newfile = "../../webfiles/pdf_releve/RELEVE_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html"	;
$newnom = "RELEVE_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "../../webfiles/pdf_releve/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "FD");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';

unlink($newfile);

		
/*$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $zppe->zppe_portable, "Un mail vient d'être envoyé à l'adresse ".$zppe->zppe_email.". Ci-joint le bon émis.");        
///////////////////////////////

$esmc_email	 = "esmcsarlu@gmail.com";	
		
$fichier = $file;	
$filena	= $newnom.'.pdf';
	
$tr = new Zend_Mail_Transport_Smtp('10.10.60.50');
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Le bon &eacute;mis le '.$zppe->zppe_date_genere.'.');
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($zppe->zppe_email, $zppe->zppe_libelle);
$mail->setSubject('Un bon emis le '.$zppe->zppe_date_genere.'');


$monImage = file_get_contents($fichier);

$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype

$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $fichier);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 

$mail->send($tr);
		



////////////////////////////////////////////////////////////////////////////



if (substr($bon->bon_code_membre, -1) == "P") {
$membre = new Application_Model_EuMembre();
$mapper_membre = new Application_Model_EuMembreMapper();
$mapper_membre->find($bon->bon_code_membre, $membre);
$nom = $membre->nom_membre.' '.$membre->prenom_membre;
} else if (substr($bon->bon_code_membre, -1) == "M") {
$membre = new Application_Model_EuMembreMorale();
$mapper_membre = new Application_Model_EuMembreMoraleMapper();
$mapper_membre->find($bon->bon_code_membre, $membre);
$nom = $membre->raison_sociale;
}
		
		
		
		
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $membre->portable_membre, "Un mail vient d'être envoyé à l'adresse ".$membre->email_membre.". Ci-joint le bon émis.");        
///////////////////////////////


$esmc_email	 = "esmcsarlu@gmail.com";	
		
$fichier = $file;	
$filena	= $newnom.'.pdf';
	
$tr = new Zend_Mail_Transport_Smtp('10.10.60.50');
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml('Le bon &eacute;mis le '.$zppe->zppe_date_genere.'.');
$mail->setFrom($esmc_email, 'ESMC');
$mail->addTo($membre->email_membre, $nom);
$mail->setSubject('Un bon emis le '.$zppe->zppe_date_genere.'');


$monImage = file_get_contents($fichier);

$finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype

$at = new Zend_Mime_Part($monImage);
$at->type        = finfo_file($finfo, $fichier);
$at->disposition = Zend_Mime::DISPOSITION_INLINE;
$at->encoding    = Zend_Mime::ENCODING_BASE64;
$at->filename    = $filena;
$mail->addAttachment($at);
 

$mail->send($tr);

*/



		
        }

		//$this->_redirect('/administration/listbon');
	
	
	
	    
    }


















}

?>
