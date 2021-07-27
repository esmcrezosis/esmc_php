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
class EuDomiciliationController extends Zend_Controller_Action {

    //put your code here
    public function init() {
       $this->view->jQuery()->enable();
       $this->view->jQuery()->uiEnable();
       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $group = $user->code_groupe;
	   $t_acteur = new Application_Model_DbTable_EuActeur();
	   $select = $t_acteur->select();
       $select->where('code_membre like ?', $user->code_membre)
               ->where('type_acteur like ?', 'gac_surveillance');
       $results = $t_acteur->fetchAll($select);
		
        if ($group == 'assurance' || $group == 'ass_smcii' || $group == 'ass_smcpnw' || $group == 'gaca_protect'  ||  $group == 'gacs_protect'  ||  $group == 'gacr_protect'  ||  $group == 'gacp_protect') {
            $menu = "<li><a href=\"/eu-domiciliation/smcipn \">Consulter smcipn</a></li>".
                    "<li><a href=\"/eu-domiciliation/domicilier \">Domiciliation prk</a></li>" .
                    "<li><a href=\"/eu-domiciliation/domicilierimm \">Domiciliation pre</a></li>".
                    "<li><a href=\"/eu-domiciliation \">Liste domiciliations</a></li>".
                    "<li><a id=\"rembours\" href=\"#\">Liste remboursements</a></li>".
                    "<li><a href=\"/eu-domiciliation/myalerte\">Mes alertes</a></li>";
        } elseif ($group == 'domi_nrpre' || $group == 'domiciliation' && (count($results) != 0)) {
            $menu = "<li><a href=\"/eu-domiciliation/offre\">Offres financières</a></li>".
                    "<li><a href=\"/eu-domiciliation/domicilierassurance \">Domiciliation pre Kit Assurance</a></li>".
					"<li><a href=\"/eu-domiciliation \">Domiciliations en cours</a></li>".
                    "<li><a href=\"/eu-domiciliation/domiass\">Domiciliations assurance</a></li>";
        } elseif($group == 'domiciliation' && (count($results) == 0)) {
		    $menu ="<li><a href=\"/eu-domiciliation/domicilierpayement \">Domiciliation pre Kit Technopole</a></li>".
                   "<li><a href=\"/eu-domiciliation \">Domiciliations</a></li>";
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
            if ($group != 'assurance' && $group != 'ass_smcii' && $group != 'ass_smcpnw' && $group != 'gaca_protect' && $group != 'domi_nrpre' && $group != 'gacs_protect' && $group != 'gacr_protect' && $group != 'gacp_protect' && $group != 'domiciliation') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }
	
	public function domiassAction() {
        
    }
	
	public function datadomiassAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50000);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        //Liste des domiciliations pour la smcipnwi
        $select1 = $tabela->select();
        $select1->setIntegrityCheck(false)
                ->from(array('d' => 'eu_domiciliation'), array('*', "to_char((d.date_domiciliation),'dd/MM/YYYY') date_domiciliation", "to_char((d.date_echue),'dd/MM/YYYY') date_echue"))
                ->where('d.id_utilisateur like ?', $user->id_utilisateur)
                ->where('d.accorder = ?', 'N')
                ->where('d.domicilier = ?', 'N')
                ->where('d.type_domiciliation like ?', 'smcipnwi')
		;
        /*
		//Liste des domiciliations pour la smcipnp
        $select2 = $tabela->select();
        $select2->setIntegrityCheck(false)
                ->from(array('d' => 'EU_dOMICILIATION'), array('*', "to_char((d.dATE_dOMICILIATION),'dd/MM/YYYY') dATE_dOMICILIATION", "to_char((d.dATE_ECHUE),'dd/MM/YYYY') dATE_ECHUE"))
                ->where('d.Id_UTILISATEUR like ?', $user->Id_UTILISATEUR)
                ->where('d.ACCORdER = ?', 'n')
                ->where('d.dOMICILIER = ?', 'n')
                ->where('d.TYPE_dOMICILIATION like ?', 'smcipnp');
        $select->setIntegrityCheck(false)
                ->union(array($select1, $select2))
        //->order('d.dATE_dOMICILIATION', 'desc')
        ;*/
		
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
        $tot_subvent = 0;
        $tot_domici = 0;
        foreach ($domici as $row) {
            if ($row->id_proposition != '') {
               $tabelp = new Application_Model_DbTable_EuProposition();
               $sele = $tabelp->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
               $sele->setIntegrityCheck(false)
                    ->join('eu_appel_offre','eu_proposition.id_appel_offre = eu_appel_offre.id_appel_offre', array('eu_appel_offre.*','eu_proposition.*'))
                    ->where('eu_proposition.id_proposition like ?',$row->id_proposition)
					;		
                $propo = $tabelp->fetchAll($sele);
                $res = $propo->current();
                $nom_appel = $res->nom_appel_offre;
				$type_appel = $res->type_appel_offre;
            } else {
                $nom_appel = '';
				$type_appel = '';
            }
            if ($row->domicilier == 'N') {
                $etat = 'En cours';
            } else {
                $etat = 'Terminée';
            }
			
			if($type_appel == 'ass') {
               $tot_subvent+=$row->montant_subvent;
               $tot_domici+=$row->montant_domicilier;
               $responce['rows'][$i]['id'] = $row->code_domicilier;
               $responce['rows'][$i]['cell'] = array(
                   $row->code_domicilier,
                   $row->code_membre_beneficiaire,
                   $row->cat_ressource,
                   $row->montant_subvent,
                   $row->montant_domicilier,
                   $row->date_domiciliation,
                   $row->date_echue,
                   $nom_appel,
                   $row->type_domiciliation,
                   $row->id_proposition,
                   $etat,
            );
            $i++;
			}
        }
        $responce['userdata']['num_benef'] = 'Total:';
        $responce['userdata']['mt_subvent'] = $tot_subvent;
        $responce['userdata']['mt_domici'] = $tot_domici;
        $this->view->data = $responce;
        
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50000);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        //Liste des domiciliations pour la smcipnwi
        $select = $tabela->select();
        $select->from(array('d' => 'eu_domiciliation'))
                ->where('d.id_utilisateur like ?', $user->id_utilisateur)
                ->where('d.accorder = ?', 'O')
                ->where('d.domicilier = ?', 'O')
                ->where('d.type_domiciliation like ?', 'smcipnwi');
		
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
        $tot_subvent = 0;
        $tot_domici = 0;
        foreach ($domici as $row) {
		     $tot_subvent+=$row->montant_subvent;
             $tot_domici+=$row->montant_domicilier;
             $responce['rows'][$i]['id'] = $row->code_domicilier;
             $responce['rows'][$i]['cell'] = array(
                   $row->code_domicilier,
                   $row->code_membre_beneficiaire,
                   $row->cat_ressource,
                   $row->montant_subvent,
                   $row->montant_domicilier,
                   $row->date_domiciliation,
                   $row->type_domiciliation,
                   
            );
            $i++;
		}
		$responce['userdata']['num_benef'] = 'Total:';
        $responce['userdata']['mt_subvent'] = $tot_subvent;
        $responce['userdata']['mt_domici'] = $tot_domici;
        $this->view->data = $responce;		
    }

    public function deviseAction() {
        $m_dev = new Application_Model_EuDeviseMapper();
        $results = $m_dev->fetchAll();
        $data = array();
        foreach ($results as $value) {
            $data[] = $value->getCode_dev();
        }
        $this->view->data = $data;
    }

    public function newAction() {
        $form = new Application_Form_EuDomiciliation();
        $this->view->form = $form;
    }

    public function domicilierAction() {
        
    }

    public function benefchangeAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'ass_smcii') {
            $type_smcipn = array('smci', 'smciPN');
        } elseif ($group == 'ass_smcpnw') {
            $type_smcipn = array('smcpn', 'smcipn');
        } else {
            $type_smcipn = array('smci', 'smcpn', 'smciPN');
        }
        $num_membre = $_GET['benef'];
        $tab = array('fixe', 'circulant', '');
        $data = array();
        $table = new Application_Model_DbTable_EuSmcipn();
        $select1 = $table->select();
        $select1->setIntegrityCheck(false)
                ->where("code_membre = ?", $num_membre)
                ->where("domicilier = ?", 0)
                ->where("etat_demande_inv = ?", 0)
                ->where("type_objet in (?)", $tab)
                ->where("type_smcipn in (?)", $type_smcipn);
        $select2 = $table->select();
        $select2->setIntegrityCheck(false)
                ->where("code_membre = ?", $num_membre)
                ->where("domicilier = ?", 0)
                ->where("etat_demande_sal = ?", 0)
                ->where("type_objet in (?)", $tab)
                ->where("type_smcipn in (?)", $type_smcipn);
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->union(array($select1, $select2))
                ->order('date_demande', 'desc');
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

    public function saveAction() {
        $d = new Application_Model_EuDomiciliation();
        $md = new Application_Model_EuDomiciliationMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $code_domici = $this->_request->getPost("code_demand") . '-' . $this->_request->getPost("num_client");
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $md->find($code_domici, $d);
            $d->setNum_client($this->_request->getPost("num_client"));
            $d->setNum_benef($this->_request->getPost("num_benef"));
            $d->setCat_ressource($this->_request->getPost("cat_ressource"));
            $d->setMt_subvent($this->_request->getPost("mt_subvent"));
            $d->setMt_credits($this->_request->getPost("mt_credits"));
            $d->setMt_domici($this->_request->getPost("mt_domici"));
            $d->setDomicilier($this->_request->getPost("domicilier"));
            $d->setAccorder($this->_request->getPost("accorder"));
            $d->setDate_domici($this->_request->getPost("data_domici"));
            $d->setDate_echue($date_id->toString('yyyy-mm-dd'));
            $d->setCode_demand($this->_request->getPost("code_demand"));
            $d->setCree_par($user->login);
            $md->update($d);
        }
    }

    public function creditsAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_credi');
        $sord = $this->_request->getParam("sord", 'asc');

        if ($_GET['lignes'] != '') {
            $client = $_GET['lignes'];
            $cat_ress = $_GET['ress'];
            //Reconstitution du tableau des numéros membres
            $tab_clt = array();
            $tab_clt = explode(",", $client);
            if ($cat_ress == 'r') {
                $produit = array('RPGr', 'Ir', 'Fs', 'PaNu', 'PaR');
            }
            if ($cat_ress == 'nr') {
                $produit = array('RPGnr', 'Inr');
            }
            if ($cat_ress == '') {
                $produit = array('');
            }
            $tcredit = new Application_Model_DbTable_EuCompteCredit();
            $select = $tcredit->select();
            $select->where('code_produit in(?)', $produit)
                    ->where('code_membre in(?)', $tab_clt)
                    ->where('krr like ?', 'n')
                    ->where('code_compte like ?', 'NB%')
                    ->where('domicilier like ?', 0)
                    ->where('affecter = ?', 0);
            $credit = $tcredit->fetchAll($select);

            $prk = 0;
            $pck = 1;
            //Récupération de la prk et de la pck pour les r
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
            $count = count($credit);

            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }

            if ($page > $total_pages)
                $page = $total_pages;

            $credit = $tcredit->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            $type_bnp = array('CSCOE', 'CMIT', 'CACB', 'CAPU', 'CAIPC');
            foreach ($credit as $row) {
                //Calcul du montant crédit pr les RPGr et Ir provenant d'un capa
                $prod = $row->code_produit;
                $compte_source = $row->compte_source;
                if (($prod == 'RPGr' || $prod == 'Ir') and !in_array($compte_source, $type_bnp)) {
                    $mt_credit = floor($row->montant_place * $prk / $pck);
                } else {
                    $mt_credit = $row->montant_credit;
                }
                $date_fin = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->id_credit;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_membre,
                    $prod,
                    $row->montant_place,
                    $mt_credit,
                    $mt_credit,
                    $date_fin->toString('dd/mm/yyyy'),
                    $row->id_credit,
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function listcreditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 30);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $request = $this->getRequest();
        $code_domici = $request->code_domicil;
        $tabela = new Application_Model_DbTable_EuDetailDomicilie();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('d' => 'eu_detail_domicilie'), array('code_membre', 'mont' => 'montant_credit'))
                ->join(array('c' => 'eu_compte_credit'), 'c.id_credit = d.id_credit', array('code_produit', 'montant_place', 'montant_credit', 'compte_source', 'date_octroi', 'id_credit'))
                ->where('d.code_domicilier = ?', $code_domici)
				;
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
        $type_bnp = array('CSCOE', 'CMIT', 'CACB', 'CAPU', 'CAIPC');
        foreach ($alloc as $row) {
            //Calcul du montant crédit pr les RPGr et Ir provenant d'un capa
            $prod = $row->code_produit;
            $compte_source = $row->compte_source;
            if (($prod == 'RPGr' || $prod == 'Ir') and !in_array($compte_source, $type_bnp)) {
                $mt_credit = floor($row->montant_place * $prk / $pck);
            } else {
                $mt_credit = $row->montant_credit + $row->mont;
            }
			$date_octroi = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $row->code_produit,
                $row->montant_place,
                $mt_credit,
                $row->mont,
                $date_octroi->ToString('dd-MM-yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function createAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $benef = $_GET['benef'];
        $demand = $_GET['demand'];
        $ress = $_GET['ress'];
        $date_fin = $_GET['date_fin'];
        $dated = Zend_Date::now();
        $date2 = explode("/", $date_fin);
        $datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
        $s = strtotime($datef) - strtotime($dated->toString('yyyy-mm-dd'));
        $diff = intval($s / 86400) + 1;
        $mdv = $diff / 30;

        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $msmcipn = new Application_Model_EuSmcipnMapper();
        $smcipn = new Application_Model_EuSmcipn();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        //$code_domici = $demand . '-' . $client;
        $acteur = $user->code_membre;
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Recherche des infos sur la smcipn
                $smc = new Application_Model_DbTable_EuSmcipn();
                $fsmc = $smc->find($demand);
                if (count($fsmc) > 0) {
                    $result = $fsmc->current();
                    //Calcul du montant à rembourser
                    $cat_objet = $result->type_objet;
                    $mt_subvent = 0;
                    if ($cat_objet == 'fixe' || $cat_objet == 'circulant') {
                        //calcul de l'investissement Inr
                        $mt_subvent = $result->montant_investis + $result->montant_salaire;
                    } else {
                        $mt_subvent = $result->montant_salaire;
                    }
                    //$dvm = $result->dvm_demande;
                    $nb_jr = ceil($mdv * 30);
                    //Cas du nr: récupération du montant total de la domiciliation
                    $mt_credit = 0;
                    $date_end = new Zend_Date(Zend_Date::ISO_8601);
                    if ($ress == 'nr') {
                        foreach ($selection as $val) {
                            if ($val['mt_utilise'] <= $val['mt_credit']) {
                                $mt_cred = $val['mt_utilise'];
                            } else {
                                $mt_cred = $val['mt_credit'];
                            }
                            $mt_credit+=$mt_cred;
                        }
                        $date->addDay($nb_jr);
                        $date_echue = $date;
                    } else if ($ress == 'r') {
                        $type_bnp = array('CSCOE', 'CMIT', 'CACB', 'CAPU', 'CAIPC');
                        foreach ($selection as $val) {
                            $code_credit = $val['code_credit'];
                            $cm->find($code_credit, $cr);
                            $mt_place = $cr->getMontant_place();
                            $prod = $cr->getCode_produit();
                            $compte_source = $cr->getCompte_source();
                            //Récupération de la date de renouvellement la plus ancienne
                            $datefin = new Zend_Date($cr->getDatefin(), Zend_Date::ISO_8601);
                            if ($datefin > $date_end) {
                                $date_end = $datefin;
                            }
                            //Calcul du crédit généré par chaque capa
                            $tot_credit = 0;
                            $prk = 0;
                            $pck = 1;
                            //Récupération de la prk et de la pck pour les r
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
                            //Cas des RPGr et Ir provenant des capa
                            if (($prod == 'RPGr' or $prod == 'Ir') and !in_array($compte_source, $type_bnp)) {
                                $credit = $val['mt_utilise'];
                                $tot_credit = $credit * $mdv;
                            }
                            //Cas des RPGr et Ir provenant d'un bnp (conus)
                            if (($prod == 'RPGr' or $prod == 'Ir') and in_array($compte_source, $type_bnp)) {
                                //récup des infos du bnp
                                $tbnp = new Application_Model_EuBnpCreditMapper();
                                $bnp = new Application_Model_EuBnpCredit();
                                $mdbnp = new Application_Model_EuDetailBnpMapper();
                                $dbnp = new Application_Model_EuDetailBnp();
                                $tot_conus = 0;

                                $result1 = $tbnp->find($cr->getCode_bnp(), $cr->getId_credit(), $bnp);
                                if ($result1 == true) {
                                    $per_deb = $bnp->getPeriode_remb();
                                    $per_fin = 0;
                                    $periode1 = 23 - $bnp->getPeriode_remb();
                                    if ($mdv >= $periode1) {
                                        $per_fin = 23;
                                    } elseif ($mdv < $periode1) {
                                        $per_fin = $bnp->getPeriode_remb() + $mdv;
                                    }
                                    //recup des infos du détail bnp et calcul du montant total du conus
                                    $find_dbnp = $mdbnp->findDetailBnpByPeriode($bnp->getCode_bnp(), $bnp->getId_credit(), $per_deb, $per_fin);
                                    if ($find_dbnp != null) {
                                        for ($i = 0; $i < count($find_dbnp); $i++) {
                                            $res_dbnp = $find_dbnp[$i];
                                            $tot_conus+=$res_dbnp->getConus();
                                        }
                                    }
                                }
                                if ($mdv > 23) {
                                    $credit = ($mt_place * $prk) / $pck;
                                    $tot_credit = $tot_conus + $credit * ($mdv - 23);
                                } else {
                                    $tot_credit = $tot_conus;
                                }
                            }
                            //Cas des PaNu, PaR et fs issus d'un bnp
                            if ($prod == 'PaNu' or $prod == 'PaR' or $prod == 'FS') {
                                //récup des infos du bnp
                                $tbnp = new Application_Model_EuBnpCreditMapper();
                                $bnp = new Application_Model_EuBnpCredit();
                                $mdbnp = new Application_Model_EuDetailBnpMapper();
                                $dbnp = new Application_Model_EuDetailBnp();
                                $tot_par = 0;
                                $tot_panu = 0;
                                $tot_fs = 0;
                                $result1 = $tbnp->find($cr->getCode_bnp(), $cr->getCompte_source(), $bnp);
                                if ($result1 == true) {
                                    $per_deb = $bnp->getPeriode_remb();
                                    $per_fin = 0;
                                    $periode1 = 23 - $bnp->getPeriode_remb();
                                    if ($mdv >= $periode1) {
                                        $per_fin = 23;
                                    } elseif ($mdv < $periode1) {
                                        $per_fin = $bnp->getPeriode_remb() + $mdv;
                                    }
                                    //recup des infos du détail bnp et calcul du montant de la PaR, PaNu ou fs
                                    $find_dbnp = $mdbnp->findDetailBnpByPeriode($bnp->getCode_bnp(), $bnp->getId_credit(), $per_deb, $per_fin);
                                    if ($find_dbnp != null) {
                                        for ($i = 0; $i < count($find_dbnp); $i++) {
                                            $res_dbnp = $find_dbnp[$i];
                                            $tot_par+=$res_dbnp->getPar();
                                            $tot_panu+=$res_dbnp->getPanu();
                                            $tot_fs+=$res_dbnp->getFs();
                                        }
                                    }
                                }
                                if ($prod == 'PaNu') {
                                    $tot_credit = $tot_panu;
                                } else if ($prod == 'PaR') {
                                    //Ajout du cumul de la PaR non exprimée
                                    $tot_credit = $tot_par + $cr->getMontant_credit();
                                } else if ($prod == 'fs') {
                                    //Ajout du  cumul du fs non exprimé
                                    $tot_credit = $tot_fs + $cr->getMontant_credit();
                                }
                            }
                            //calcul du cumul total de tous les crédits sélectionnés
                            $mt_credit+=$tot_credit;
                        }
                        $date_end->addDay($nb_jr);
                        $date_echue = $date_end;
                    }
                    //###Contrôle du total des crédits domiciliés avec le montant du remboursement###
                    if ($mt_credit < $mt_subvent) {
                        $db->rollback();
                        $this->view->data = 'err_domici';
                        return;
                    } else {
                        //Mise à jour des comptes crédits
                        $cumul_credit = 0;
                        $nb_per = 0;
                        $test = false;
                        foreach ($selection as $sel) {
                            //Contrôle de l'existence de la domiciliation du crédit
                            $id_credit = $sel['code_credit'];
                            $find_cred = $cm->findByCredDomi($id_credit, 1);
                            if ($find_cred != null) {
                                $test = true;
                                $db->rollback();
                                $this->view->data = 'bad_domi';
                                return;
                            } else {
                                $cumul_credit+=$sel['mt_utilise'];
                                $nb_per+=1;
                                $result = $cm->find($sel['code_credit'], $cr);
                                if ($result) {
                                    $cr->setDomicilier(1);
                                    $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_utilise']);
                                    $cm->update($cr);
                                }
                            }
                        }
                        if ($test == false) {
                            //###Traitement généraux et standard pour tout les type de domiciliation###
                            //Mise à jour de la table smcipn
                            $resul = $msmcipn->find($demand, $smcipn);
                            if ($resul) {
                                $smcipn->setCode_smcipn($demand);
                                $smcipn->setDomicilier(1);
                                $msmcipn->update($smcipn);
                            }
                            //Enregistrement dans la table de domiciliation
                            $do->setMontant_subvent($mt_subvent);
                            $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                            $do->setCode_domicilier($code_domici);
                            $do->setCode_membre_beneficiaire($benef);
                            $do->setCode_membre_assureur($user->code_membre);
                            $do->setCat_ressource($ress);
                            if ($ress == 'nr') {
                                $do->setMontant_domicilier($mt_subvent);
                                $do->setDomicilier('o');
                                $do->setDuree_renouvellement($mdv);
                                $do->setReste_duree(0);
                            } else if ($ress == 'r') {
                                $rest_duree = $mdv - $nb_per;
                                if ($rest_duree < 0) {
                                    $rest = 0;
                                } else {
                                    $rest = $rest_duree;
                                }
                                $do->setMontant_domicilier($cumul_credit);
                                $do->setDomicilier('n');
                                $do->setDuree_renouvellement($mdv);
                                $do->setReste_duree($rest);
                            }
                            $do->setAccorder('n');
                            $do->setDate_domiciliation($date_domi->toString('yyyy-mm-dd'));
                            $groupe = $user->code_groupe;
                            if ($groupe == 'ass_smcii') {
                                $type_domi = 'tpasmcii';
                            } else if ($groupe == 'ass_smcpnw') {
                                $type_domi = 'tpasmcpnw';
                            } else {
                                $type_domi = 'tpasmcipn';
                            }
                            $do->setType_domiciliation($type_domi);
                            $do->setCode_smcipn($demand);
                            $do->setCode_smcipnp(null);
                            $do->setId_utilisateur($user->id_utilisateur);
                            $dom = new Application_Model_DbTable_EuDomiciliation();
                            $code_dom = $dom->find($code_domici);
                            if (count($code_dom) < 1) {
                                $mdo->save($do);
                            } else {
                                $db->rollback();
                                $this->view->data = 'cool';
                                return;
                            }
                            //Enregistrement dans la table detail_domicilie
                            $mtab = array();
                            foreach ($selection as $tab) {
                                $dod->setCode_domicilier($code_domici);
                                $dod->setId_credit($tab['code_credit']);
                                $dod->setCode_membre($tab['num_membre']);
                                $dod->setMontant_credit($tab['mt_utilise']);
                                $dod->setUtiliser(1);
                                $mdod->save($dod);
                                $mtab = $tab['num_membre'];
                            }
                            //Traitement spéciaux des r et nr
                            foreach ($selection as $sel) {
                                $result = $cm->find($sel['code_credit'], $cr);
                                //Diminution du montant du compte
                                $ret = $mcompte->find($cr->getCode_compte(), $compte);
                                if ($ret) {
                                    $compte->setSolde($compte->getSolde() - $sel['mt_utilise']);
                                    $mcompte->update($compte);
                                }
                                //Mise à jour de la table cnp
                                $cnp = new Application_Model_EuCnp();
                                $m_cnp = new Application_Model_EuCnpMapper();
                                $cnp_res = $m_cnp->findCnpByCreditSource($cr->getId_credit(), $cr->getSource());
                                if ($cnp_res != null) {
                                    $cnp->setId_cnp($cnp_res->getId_cnp());
                                    $cnp->setId_credit($cnp_res->getId_credit());
                                    $cnp->setDate_cnp($cnp_res->getDate_cnp());
                                    $cnp->setMont_debit($cnp_res->getMont_debit());
                                    $cnp->setMont_credit($cnp_res->getMont_credit());
                                    $cnp->setSolde_cnp($cnp_res->getSolde_cnp());
                                    $cnp->setType_cnp($cnp_res->getType_cnp());
                                    $cnp->setSource_credit($cnp_res->getSource_credit());
                                    $cnp->setCode_capa($cnp_res->getCode_capa());
                                    $cnp->setCode_domicilier($code_domici);
                                    $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                                    $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                                    $m_cnp->update($cnp);
                                }
                            }
                        }
                    }
                    $db->commit();
                    $this->view->data = 'good';
                    $this->view->mtab = $mtab;
                    return;
                } else {
                    $db->rollback();
                    $this->view->data = 'no_demand';
                    return;
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
                $this->view->data = 'bad';
                return;
            }
        }
    }

    public function subventionAction() {
        $code_demand = $_GET['code'];
        $data = array();
        $smc_db = new Application_Model_DbTable_EuSmcipn();
        $smc_find = $smc_db->find($code_demand);
        if (count($smc_find) == 1) {
            $mt_subvent = 0;
            $result = $smc_find->current();
            $cat = $result->type_objet;
            //Cas des i fixe et circulant   
            if ($cat == 'fixe' || $cat == 'circulant') {
                $mt_subvent = $result->montant_investis + $result->montant_salaire;
            } else {
                $mt_subvent = $result->montant_salaire;
            }
            $data[0] = $mt_subvent;
            $data[1] = round($result->dvm_demande * 30);
        } else {
            $data[0] = '';
            $data[1] = '';
        }
        $this->view->data = $data;
    }

    public function accorderAction() {

        $mdomi = New Application_Model_EuDomiciliationMapper();
        $domi = new Application_Model_EuDomiciliation();
        $ms = new Application_Model_EuSmcipnMapper();
        $s = new Application_Model_EuSmcipn();
        $mrap = new Application_Model_EuRapprochementMapper();
        $rap = new Application_Model_EuRapprochement();
        $mgcsc = new Application_Model_EuGcscMapper();
        $gcsc = new Application_Model_EuGcsc();
        $mcnp = new Application_Model_EuCnpMapper();
        $cnp = new Application_Model_EuCnp();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mech = New Application_Model_EuEchangeMapper();
        $code_domi = $_GET['code_domi'];
        $mt_smcipn = $_GET['mt_smcipn'];
        $mt_domici = $_GET['mt_domici'];
        $code_smcipn = $_GET['code_smcipn'];
        $num_benef = $_GET['benef'];
        $cat_ress = $_GET['cat_ress'];
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_smc = clone $date;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Contrôle de l'état de la domiciliation
            if ($mt_domici < $mt_smcipn) {
                $this->view->data = 'echec_domi';
                return;
            } else {
                //Mise à jour du compte de domiciliation
                $result = $mdomi->find($code_domi, $domi);
                if ($result) {
                    $domi->setAccorder('o');
                    $mdomi->update($domi);
                }
                //Mise à jour de la table de subvention
                $ms->find($code_smcipn, $s);
                $s->setRembourser(1);
                $ms->update($s);
                //Mise à jour de la table gcsc
                $tegcsc = $mgcsc->findByMembreAndSmcipn($num_benef, $code_smcipn);
                if ($tegcsc != null) {
                    $gcsc->setId_gcsc($tegcsc->getId_gcsc());
                    $gcsc->setCode_membre($num_benef);
                    $gcsc->setDebit($tegcsc->getDebit());
                    $gcsc->setCredit($tegcsc->getCredit() + $domi->getMontant_domicilier());
                    $gcsc->setSolde($tegcsc->getSolde() - $domi->getMontant_domicilier());
                    $gcsc->setCode_smcipn($tegcsc->getCode_smcipn());
                    $gcsc->setCode_smcipnp($tegcsc->getCode_smcipnp());
                    $gcsc->setCode_domicilier($tegcsc->getCode_domicilier());
                    $mgcsc->update($gcsc);
                } else {
                    //Enregistrement de la domiciliation(GCnr bleue) dans la table gcsc
                    $gcsc->setCode_membre($num_benef);
                    $gcsc->setDebit(0);
                    $gcsc->setCredit($domi->getMontant_domicilier());
                    $gcsc->setSolde($domi->getMontant_domicilier());
                    $gcsc->setCode_smcipn(null);
                    $gcsc->setCode_smcipnp(null);
                    $gcsc->setCode_domicilier($code_domi);
                    $mgcsc->save($gcsc);
                }
                //Recherche des crédits utilisés pour la domiciliation dans la table cnp
                $cnp_find = $mcnp->findCnpByDomicilie($code_domi);
                if ($cnp_find == null) {
                    $this->view->data = 'no_domi';
                    return;
                } elseif (count($cnp_find) > 0) {
                    for ($i = 0; $i < count($cnp_find); $i++) {
                        $source_cnp = $cnp_find[$i];
                        $source_credit = $source_cnp->getSource_credit();
                        $code_credit = $source_cnp->getId_credit();
                        //Récupération du montant domicilié sur le crédit
                        $credit_domi = 0;
                        $res = $mdod->find($code_domi, $code_credit, $dod);
                        if ($res) {
                            $credit_domi = $dod->getMontant_credit();
                        }
                        //Mise à jour du compte crédit après domiciliation
                        $type_rappro = '';
                        $find_credit = $cm->find($code_credit, $cr);
                        if ($find_credit) {
                            $cr->setDomicilier(0);
                            $cm->update($cr);
                            //Formation du code de rapprochement à partir du crédit domicilié et du crédit alloué
                            $code_produit = $cr->getCode_produit();
                            $compte_source = $cr->getCompte_source();
                            if ($compte_source == 'CAPAI') {
                                if ($code_produit == 'Ir') {
                                    $type_rappro = 'Ir2/IrSc';
                                } else if ($code_produit == 'Inr') {
                                    $type_rappro = 'Inr2/InrSc';
                                }
                            }
                            if ($compte_source == 'CAPARPG') {
                                if ($code_produit == 'RPGr') {
                                    $type_rappro = 'FGRPG1/RPGr';
                                } else if ($code_produit == 'RPGnr') {
                                    $type_rappro = 'FGRPG1/RPGnr';
                                }
                            }
                            if (strpos($compte_source, 'TPAGCP') != false) {
                                if ($code_produit == 'Inr') {
                                    $type_rappro = 'GCP11/InrSc';
                                } else if ($code_produit == 'RPGnr') {
                                    $type_rappro = 'GCP12/RPGnr';
                                }
                            }
                            if (strpos($compte_source, 'TSCI') != false) {
                                if ($code_produit == 'Ir') {
                                    $type_rappro = 'Ir4/IrSc';
                                } else if ($code_produit == 'Inr') {
                                    $type_rappro = 'Inr4/InrSc';
                                }
                            }
                            if (strpos($compte_source, 'TCNCS') != false) {
                                //Récupération de l'échange à partir de l'id_credit
                                $find_ech = $mech->findEchangeByCredit($code_credit);
                                if ($find_ech != null) {
                                    $code_produit = $find_ech->getCode_produit();
                                }
                                if ($code_produit == 'CNCSnr') {
                                    $type_rappro = 'CNCSnr5/RPGnr';
                                } else if ($code_produit == 'CNCSr') {
                                    $type_rappro = 'CNCSr6/RPGnr';
                                }
                            }
                        }
                        //Recherche du code_credit dans la table rapprochement
                        $res = $mrap->findBySmcipnSource($code_smcipn, $source_credit, $code_credit);
                        //Mise à jour de la table de rapprochement              
                        if ($res != null) {
                            $rap->setId_rappro($res->getId_rappro());
                            $rap->setDebit_rappro($res->getDebit_rappro());
                            $rap->setCredit_rappro($credit_domi);
                            $rap->setSolde_rappro($res->getSolde_rappro() - $credit_domi);
                            $rap->setSource($res->getSource());
                            $rap->setSource_credit($res->getSource_credit());
                            $rap->setCode_smcipn($res->getCode_smcipn());
                            $rap->setCode_smcipnp($res->getCode_smcipnp());
                            $rap->setCode_domicilier($code_domi);
                            $rap->setId_credit($res->getId_credit());
                            $rap->setType_rappro($type_rappro);
                            $mrap->update($rap);
                        } else {
                            $rap->setDebit_rappro($credit_domi);
                            $rap->setCredit_rappro(0);
                            $rap->setSolde_rappro($credit_domi);
                            $rap->setSource('CNP');
                            $rap->setSource_credit($source_credit);
                            $rap->setCode_smcipn($code_smcipn);
                            $rap->setCode_smcipnp(null);
                            $rap->setCode_domicilier($code_domi);
                            $rap->setId_credit($code_credit);
                            $rap->setType_rappro($type_rappro);
                            $mrap->save($rap);
                        }
                        //Création du cncs à la source smc
                        if ($cat_ress == 'r') {
                            $type_smc = 'CNCSr';
                        } else {
                            $type_smc = 'CNCSnr';
                        }
                        $smc = new Application_Model_EuSmc();
                        $m_smc = new Application_Model_EuSmcMapper();
                        $smc->setCode_capa($source_cnp->getCode_capa())
                                ->setId_credit($code_credit)
                                ->setDate_smc($date_smc->toString('yyyy-mm-dd'))
                                ->setMontant($credit_domi)
                                ->setEntree(0)
                                ->setSortie(0)
                                ->setSolde(0)
                                ->setSource_credit($source_credit)
                                ->setMontant_solde($credit_domi)
                                ->setType_smc($type_smc)
                                ->setCode_smcipn(null)
                                ->setCode_smcipnp(null)
                                ->setCode_domicilier($code_domi)
                                ->setOrigine_smc(0);
                        $m_smc->save($smc);
                        //Mise à jour du crédit à la source cnp
                        $cnp->setId_cnp($source_cnp->getId_cnp());
                        $cnp->setType_cnp($source_cnp->getType_cnp());
                        $cnp->setCode_capa($source_cnp->getCode_capa());
                        $cnp->setId_credit($source_cnp->getId_credit());
                        $cnp->setSource_credit($source_cnp->getSource_credit());
                        $cnp->setDate_cnp($source_cnp->getDate_cnp());
                        $cnp->setMont_debit($source_cnp->getMont_debit());
                        $cnp->setMont_credit($credit_domi);
                        $cnp->setSolde_cnp($source_cnp->getSolde_cnp() - $credit_domi);
                        $cnp->setCode_domicilier($source_cnp->getCode_domicilier());
                        $mcnp->update($cnp);
                        //Archivage du crédit dans la table eu_cnp_entree
                        $date_cnpe = Zend_Date::now();
                        $tcnp = new Application_Model_DbTable_EuCnpEntree();
                        $ecnp = new Application_Model_EuCnpEntree();
                        $ecnp->setId_cnp($cnp->getId_cnp())
                                ->setDate_entree($date_cnpe->toString('yyyy-mm-dd'))
                                ->setMont_cnp_entree($credit_domi)
                                ->setType_cnp_entree('gcsc');
                        $tcnp->insert($ecnp->toArray());
                    }
                }
            }
            $db->commit();
            $this->view->data = 'good';
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            $this->view->message = $message;
            $this->view->data = 'erreur';
            return;
        }
    }

    public function rembourseAction() {
        $this->_helper->layout->disableLayout();
    }

    public function rembourselistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50000);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        $group = $user->code_groupe;
        //########## Cas de la gac protection pays ###########
        if ($group == 'gacp_protect') {
            $type_domi = '%';
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
            //Liste des domiciliations non accordées
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgacp)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select2 = $tabela->select();
            $select2->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgacr)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select3 = $tabela->select();
            $select3->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgacs)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select4 = $tabela->select();
            $select4->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgac)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select5 = $tabela->select();
            $select5->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbfil)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select6 = $tabela->select();
            $select6->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbcre)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select7 = $tabela->select();
            $select7->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbact)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            //Récupération des demandes de subventions des acteurs non validées par le créneau
            $select->setIntegrityCheck(false)
                    ->union(array($select1, $select2, $select3, $select4, $select5, $select6, $select7))
                    ->order('eu_domiciliation.date_domiciliation', 'desc');
        }
        //########## Cas de la gac protection région ###########
        if ($group == 'gacr_protect') {
            $type_domi = '%';
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
            //Liste des domiciliations non accordées
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgacr)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select2 = $tabela->select();
            $select2->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgacs)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select3 = $tabela->select();
            $select3->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgac)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select4 = $tabela->select();
            $select4->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbfil)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select5 = $tabela->select();
            $select5->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbcre)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select6 = $tabela->select();
            $select6->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbact)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            //Récupération des demandes de subventions des acteurs non validées par le créneau
            $select->setIntegrityCheck(false)
                    ->union(array($select1, $select2, $select3, $select4, $select5, $select6))
                    ->order('eu_domiciliation.date_domiciliation', 'desc');
        }
        //########## Cas de la gac protection secteur ###########
        if ($group == 'gacs_protect') {
            $type_domi = '%';
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
            //Liste des domiciliations non accordées
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgacone)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select2 = $tabela->select();
            $select2->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgac)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select3 = $tabela->select();
            $select3->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbfil)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select4 = $tabela->select();
            $select4->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbcre)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select5 = $tabela->select();
            $select5->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbact)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            //Récupération des demandes de subventions des acteurs non validées par le créneau
            $select->setIntegrityCheck(false)
                    ->union(array($select1, $select2, $select3, $select4, $select5))
                    ->order('eu_domiciliation.date_domiciliation', 'desc');
        }
        //########## Cas de la gac protection agence ###########
        if ($group == 'gaca_protect') {
            $type_domi = '%';
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
            //Liste des domiciliations non accordées
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbgac)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select2 = $tabela->select();
            $select2->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbfil)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select3 = $tabela->select();
            $select3->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbcre)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select4 = $tabela->select();
            $select4->setIntegrityCheck(false)
                    ->where('eu_domiciliation.code_membre_beneficiaire in (?)', $mbact)
                    ->where('eu_domiciliation.accorder = ?', '0')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            //Récupération des demandes de subventions des acteurs non validées par le créneau
            $select->setIntegrityCheck(false)
                    ->union(array($select1, $select2, $select3, $select4));
        }
        //########## Cas des autres groupe d'utilisateurs ###########
        if ($group != 'gaca_protect' || $group != 'gacs_protect' || $group != 'gacr_protect' || $group != 'gacp_protect') {
            if ($group == 'ass_smcii') {
                $type_domi = 'tpasmcii';
            } elseif ($group == 'ass_smcpnw') {
                $type_domi = 'tapsmcpnw';
            } elseif ($group != 'ass_smcii' || $group != 'ass_smcpnw') {
                $type_domi = '%';
            }
            $select1 = $tabela->select();
            $select1->setIntegrityCheck(false)
                    ->where('eu_domiciliation.id_utilisateur = ?', $user->id_utilisateur)
                    ->where('eu_domiciliation.code_membre_assureur = ?', $user->code_membre)
                    ->where('eu_domiciliation.accorder = ?', 'o')
                    ->where('eu_domiciliation.type_domiciliation like ?', $type_domi);
            $select->setIntegrityCheck(false)
                    ->union(array($select1));
        }
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
            $date_dom = new Zend_Date($row->date_domiciliation, Zend_Date::ISO_8601);
            $date_echue = new Zend_Date($row->date_echue, Zend_Date::ISO_8601);
            if ($row->cat_ressource == 'r') {
                $ress = 'Réccurent';
            } else {
                $ress = 'Non réccurent';
            }
            if ($row->domicilier == 'N') {
                $accord = 'En cours';
            } else {
                $accord = 'Terminer';
            }
            $responce['rows'][$i]['id'] = $row->code_domicilier;
            $responce['rows'][$i]['cell'] = array(
                $row->code_domicilier,
                $row->code_membre_beneficiaire,
                $ress,
                $row->montant_subvent,
                $row->montant_domicilier,
                $date_dom->toString('dd/mm/yyyy'),
                $date_echue->toString('dd/mm/yyyy'),
                $row->code_smcipn,
                $accord,
                $row->cat_ressource,
                $row->type_domiciliation,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function changeAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function changemoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre_morale;
        }
        $this->view->data = $data;
    }

    public function myalerteAction() {
        // action body
    }

    public function myalertelistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_alerte');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuAlerte();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->where("code_membre_assureur= ?", $user->code_membre)
                ->order("date_alerte", 'desc');
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
            $date_alerte = new Zend_Date($row->date_alerte, Zend_Date::ISO_8601);
            $heure_alerte = new Zend_Date($row->heure_alerte, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_alerte;
            $responce['rows'][$i]['cell'] = array(
                $row->id_alerte,
                $row->CODE_MEMBRE_client,
                $row->code_membre_assureur,
                $row->CODE_MEMBRE_acteur,
                $row->lib_alerte,
                $row->code_smcipn,
                $date_alerte->toString('dd/mm/yyyy'),
                $heure_alerte->toString('hh:mm'),
                $row->motif_alerte,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    //####### Domiciliation des crédits issus d'un imm ########
    public function domicilierimmAction() {
        
    }

    public function creditsimmAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_credi');
        $sord = $this->_request->getParam("sord", 'asc');
        if ($_GET['lignes'] != '') {
            $client = $_GET['lignes'];
            //Reconstitution du tableau des numéros membres
            $tab_clt = array();
            $tab_clt = explode(",", $client);
            //Liste des types de credits récurrents
            $produit = array('RPGnr', 'Inr');
            $tcredit = new Application_Model_DbTable_EuCompteCredit();
            $select = $tcredit->select();
            $select->setIntegrityCheck(false)
                    ->from(array('d' => 'eu_compte_credit'), array('*', "to_char((d.date_octroi),'dd/MM/YYYY') date_octroi"))
                    ->join(array('c' => 'eu_capa_affecter'), 'd.id_credit = c.id_credit', array('duree_renouvellement', 'reste_duree', 'mont_invest'))
                    ->where('code_produit in(?)', $produit)
                    ->where('code_membre in(?)', $tab_clt)
                    ->where('krr like ?', 'N')
                    ->where('code_compte like ?', 'NB%')
                    ->where('domicilier like ?', 0)
                    ->where('affecter like ?', 1)
                    ->where('c.cODE_DOMIcILIER is null')
            ;
            $credit = $tcredit->fetchAll($select);

            $count = count($credit);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }

            if ($page > $total_pages)
                $page = $total_pages;

            $credit = $tcredit->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($credit as $row) {
                $mont_credit = $row->mont_invest / $row->duree_renouvellement;
                $total_credit = $mont_credit * $row->reste_duree;
                $responce['rows'][$i]['id'] = $row->id_credit;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_membre,
                    $row->code_produit,
                    $row->montant_place,
                    $mont_credit,
                    $row->reste_duree,
                    $total_credit,
                    $row->date_octroi,
                    $row->id_credit,
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }

    public function createimmAction() {
	
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $cm = new Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $msmcipn = new Application_Model_EuSmcipnpwiMapper();
        $smcipn = new Application_Model_EuSmcipnpwi();
        $mcapaa = new Application_Model_EuCapaAffecterMapper();
        $capaa = new Application_Model_EuCapaAffecter();
        $cnp = new Application_Model_EuCnp();
        $m_cnp = new Application_Model_EuCnpMapper();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $acteur = $user->code_membre;
        $ress = 'nrPRE';
        $code_domici = 'pre' . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $num_benef = $_GET['num_benef'];
                $type_domi = $_GET['type_domi'];
                $id_proposition = $_GET['id_proposition'];
				
				$mpropo = new Application_Model_EuPropositionMapper();
                $propo = new Application_Model_EuProposition();
                $mpropo->find($id_proposition, $propo);
				
				$id_appel_offre = $mpropo->id_appel_offre;
				
                //$mt_projet = $_GET['mt_domi'];
                //Calcul cumulé du total de chaque crédit domicilier en fonction de la période précisée
				
                $tot_credit = 0;
                $mt_domi = 0;
                $mt_adomi = 0;
                $mt_total = 0;
                $mont_inv = 0;
                $mont_smcipnp = 0;
                $som_cred = 0;
                foreach ($selection as $val) {
                    $id_credit = $val['code_credit'];
                    //Récupération du montant crédit déjà domicilié sur le compte
                    $find_per = $mcapaa->findByCredit($id_credit);
                    if ($find_per != false) {
                        $nb_duree = $find_per->getDuree_renouvellement() - $find_per->getReste_duree();
                        $mont_invest = $find_per->getMont_invest();
                        $mont_smcipnp += $mont_invest;
                    }
                    $mt_domici = $val['mt_credit'] * $nb_duree;
					
                    //Récupération du montant du crédit restant
                    $cm->find($id_credit, $cr);
                    $mcompte->find($cr->getCode_compte(), $compte);
                    $mont_credit = $cr->getMontant_credit();
                    $mt_cred_per = $mont_credit * $nb_duree;
                    $mt_compte = $compte->getSolde();
                    $mt_creddim = 0;
                    if ($mont_credit < $val['mt_credit']) {
                        $mt_domici = $mt_domici - $val['mt_credit'];
                        $mt_creddim = 0;
                    } else {
                        $mt_creddim = $val['mt_credit'];
                    }
                    $mt_credit = $val['total'] + $mt_domici;
                    $tot_credit+=$mt_credit;
                    $mt_domi+=$mt_domici;
                    $mt_adomi+=$val['total'];
                    $mt_total = $mt_domi + $mt_adomi;
					
                    //Mise à jour des comptes crédits
                    $result = $cm->find($id_credit, $cr);
                    if ($result) {
                        $cr->setDomicilier(1);
                        $cr->setMontant_credit($cr->getMontant_credit() - $mt_creddim);
                        $cm->update($cr);
                    }
					
                    //Calcul du montant de l'investissement de la smcipnpwi
                    $mont_inv+=$val['mt_credit'];
                    $som_cred+=$mt_creddim;
                }
				
                //Calcule du montant du projet
                if ($type_domi == 'smcipnwi') {
                    $mt_projet = $_GET['mt_domi'];
                    $pre = 'wi';
                } else if ($type_domi == 'smcipnp') {
                    $mt_projet = $mont_smcipnp - $som_cred;
                    $pre = 'p';
                }
                if ($mt_total >= $mt_projet) {
                    if ($mt_domi >= $mt_projet) {
                        $mont_subvent = $mt_projet;
                        $mont_domicilie = $mt_projet;
                        $domicilier = 'O';
                        $accorder = 'O';
                        $rembourser = 1;
                        $etat_propo = 0;
                    } else {
                        $mont_subvent = $mt_projet;
                        $mont_domicilie = $mt_domi;
                        $domicilier = 'N';
                        $accorder = 'N';
                        $rembourser = 0;
                        $etat_propo = 0;
                    }
                } else {
                    $mont_subvent = $mt_total;
                    $mont_domicilie = $mt_domi;
                    $domicilier = 'n';
                    $accorder = 'n';
                    $rembourser = 0;
                    $etat_propo = 1;
                }
				
                //###Traitement généraux et standard pour tous les types de domiciliation###
                $code = $msmcipn->getLastCodeByMembre($num_benef, $type_domi);
                //Formation du code de la smcipnpwi à partir du code du membre bénéficiaire
				
                /*if ($code == null) {
                    $code_smcipnpwi = $pre . $num_benef . '0001';
                } else {
                    $num_ordre = substr($code, -4);
                    $num_ordre++;
                    $num_ordre_bis = str_pad($num_ordre, 4, 0, str_pad_left);
                    $code_smcipnpwi = $pre . $num_benef . $num_ordre_bis;
                }*/
				
                //Enregistrement dans la table eu_smcipnpwi
                $mont_sal = $mont_subvent - $mont_inv;
                if ($mont_sal < 0) {
                    $mont_salaire = 0;
                    $mont_investis = $mont_subvent;
                } else {
                    $mont_salaire =  $mont_sal;
                    $mont_investis = $mont_inv;
                }
                /*$smcipn->setCode_smcipn($code_smcipnpwi)
                       ->setCode_membre($num_benef)
                       ->setDate_smcipn($date_domi->toString('yyyy-mm-dd hh:mm:ss'))
                       ->setMont_salaire($mont_salaire)
                       ->setMont_investis($mont_investis)
                       ->setSalaire_alloue(0)
                       ->setInvestis_alloue(0)
                       ->setType_smcipn($type_domi)
                       ->setEtat_alloc_salaire(0)
                       ->setEtat_alloc_investis(0)
                       ->setRembourser($rembourser)
                       ->setId_utilisateur($user->id_utilisateur);
                $msmcipn->save($smcipn);*/
$msmcipn->findByMembre($num_benef, $smcipn);
$code_smcipnpwi = $smcipn->getCode_smcipn();
				
                //Enregistrement dans la table de domiciliation
                $nb_jr = ceil($mont_subvent / $mont_inv * 30);
                $date->addDay($nb_jr);
                $date_echue = $date;
                $do->setCode_domicilier($code_domici);
                $do->setCode_membre_beneficiaire($num_benef);
                $do->setCode_membre_assureur($user->code_membre);
                $do->setCat_ressource($ress);
                $do->setMontant_subvent($mont_subvent);
                $do->setMontant_domicilier($mont_domicilie);
                $do->setDomicilier($domicilier);
                $do->setAccorder($accorder);
                $do->setDate_domiciliation($date_domi->toString('yyyy-mm-dd hh:mm:ss'));
                $do->setDate_echue($date_echue->toString('yyyy-mm-dd hh:mm:ss'));
                $do->setType_domiciliation($type_domi);
                $do->setCode_smcipn($code_smcipnpwi);
                $do->setCode_smcipnp(null);
                $do->setId_proposition($id_proposition);
                $do->setId_utilisateur($user->id_utilisateur);
                $mdo->save($do);
/*				
$mdo->findBySmcipn($code_smcipnpwi, $do);
$code_domici = $do->getCode_domicilier();
*/				
                //Mise à jour de la table eu_proposition afin de préciser l'état de la proposition
                $mpropo = new Application_Model_EuPropositionMapper();
                $propo = new Application_Model_EuProposition();
                $mpropo->find($id_proposition, $propo);
                $propo->setDisponible($etat_propo);
                $mpropo->update($propo);
                foreach ($selection as $tab) {
				
                    //Enregistrement dans la table detail_domicilie
                    $dod->setCode_domicilier($code_domici);
                    $dod->setId_credit($tab['code_credit']);
                    $dod->setCode_membre($tab['code_membre']);
                    $dod->setMontant_credit($tab['mt_credit']);
                    $dod->setUtiliser(1);
					
                    //Récupération des durées
                    $find_per = $mcapaa->findByCredit($tab['code_credit']);
                    $duree_renouvellement = 1;
                    $reste_duree = 0;
                    $nb_reste = 0;
                    if ($find_per != false) {
                        $duree_renouvellement = $find_per->getDuree_renouvellement();
                        $reste_duree = $find_per->getReste_duree();
                        $nb_reste = $duree_renouvellement - $reste_duree;
                    }
                    $dod->setDuree_renouvellement($duree_renouvellement);
                    $dod->setReste_duree($reste_duree);
                    $mdod->save($dod);
					
                    //Mise à jour des comptes de chaque apporteur de compte crédit
                    $result = $cm->find($tab['code_credit'], $cr);
                    $mtcompte = 0;
                    $mt_tot_cred = $tab['mt_credit'] * $nb_reste + $tab['total'];
                    $reste_mt_proj = $mt_tot_cred - $mt_projet;
                    while ($mt_projet > 0) {
                        if ($reste_mt_proj < 0) {
                            $mt_projet = $mt_projet - $reste_mt_proj;
                            $mtcompte = $tab['mt_credit'] * $nb_reste;
                            if ($cr->getMontant_credit() < $tab['mt_credit']) {
                                $mtcompte = $mtcompte - $tab['mt_credit'];
                            }
							
                            //Mise à jour du code_domicilier dans eu_cnp
                            $find_cred = $m_cnp->findCnpByCreditOld($cr->getId_credit(), $cr->getSource());
                            if (count($find_cred) >= 1) {
                                for ($i = 1; $i <= count($find_cred); $i++) {
                                    $cnp->setMont_credit($cnp->getMont_credit() + $tab['mt_credit']);
                                    $cnp->setSolde_cnp($cnp->getSolde_cnp() - $tab['mt_credit']);
                                    $m_cnp->update($cnp);
                                }
                            }
                        } else {
                            $diff_ddom = $tab['mt_credit'] * $nb_reste - $mt_projet;
                            if ($diff_ddom < 0) {
                                $mtcompte = $tab['mt_credit'] * $nb_reste;
                                if ($cr->getMontant_credit() < $tab['mt_credit']) {
                                    $mtcompte = $mtcompte - $tab['mt_credit'];
                                }
								
                                //Mise à jour du code_domicilier dans eu_cnp
                                $find_cred = $m_cnp->findCnpByCreditOld($cr->getId_credit(), $cr->getSource());
                                if (count($find_cred) >= 1) {
                                    for ($i = 1; $i <= count($find_cred); $i++) {
                                        $cnp->setMont_credit($cnp->getMont_credit() + $tab['mt_credit']);
                                        $cnp->setSolde_cnp($cnp->getSolde_cnp() - $tab['mt_credit']);
                                        $m_cnp->update($cnp);
                                    }
                                }
                            } else {
                                $mtcompte = $mt_projet;
                                if ($cr->getMontant_credit() < $tab['mt_credit']) {
                                    $mtcompte = $mtcompte - $tab['mt_credit'];
                                }
								
                                //Mise à jour du code_domicilier dans eu_cnp
                                $find_cred = $m_cnp->findCnpByCreditOld($cr->getId_credit(), $cr->getSource());
                                if (count($find_cred) >= 1) {
                                    $mt_comp = 0;
                                    for ($i = 1; $i <= count($find_cred); $i++) {
                                        $mt_comp = ($mt_comp + $tab['mt_credit']) - $mtcompte;
                                        if ($mt_comp < 0) {
                                            $cnp->setMont_credit($cnp->getMont_credit() + $tab['mt_credit']);
                                            $cnp->setSolde_cnp($cnp->getSolde_cnp() - $tab['mt_credit']);
                                            $m_cnp->update($cnp);
                                        } else {
                                            $cnp->setMont_credit($cnp->getMont_credit() + $mtcompte);
                                            $cnp->setSolde_cnp($cnp->getSolde_cnp() - $mtcompte);
                                            $m_cnp->update($cnp);
                                        }
                                        $mt_comp = $mtcompte - $tab['mt_credit'];
                                    }
                                }
                            }
                            $mt_projet = 0;
                        }
                    }
					
                    //Diminution du montant du compte
                    $ret = $mcompte->find($cr->getCode_compte(), $compte);
                    if ($ret) {
                       $compte->setSolde($compte->getSolde() - $mtcompte);
                       $mcompte->update($compte);
                    }
					
                    //Mise à jour du code_domicilier dans la table capa_AFFECTER
                    $find_capaa = $mcapaa->findByCredit($cr->getId_credit());
                    if ($find_capaa != false) {
                        $capaa->setId_affecter($find_capaa->getId_affecter());
                        $capaa->setDuree_renouvellement($find_capaa->getDuree_renouvellement());
                        $capaa->setReste_duree($find_capaa->getReste_duree());
                        $capaa->setType_credit($find_capaa->getType_credit());
                        $capaa->setId_credit($find_capaa->getId_credit());
                        $capaa->setCode_domicilier($code_domici);
                        $capaa->setMont_invest($find_capaa->getMont_invest());
                        $capaa->setCode_capa($find_capaa->getCode_capa());
                        $mcapaa->update($capaa);
                    }
					
                    //Mise à jour de la table cnp
                    $cnp_res = $m_cnp->findCnpByCreditSource($cr->getId_credit(), $cr->getSource());
                    if ($cnp_res != null) {
                        $cnp->setId_cnp($cnp_res->getId_cnp());
                        $cnp->setId_credit($cnp_res->getId_credit());
                        $cnp->setDate_cnp($cnp_res->getDate_cnp());
                        $cnp->setMont_debit($cnp_res->getMont_debit());
                        $cnp->setMont_credit($cnp_res->getMont_credit() + $tab['mt_credit']);
                        $cnp->setSolde_cnp($cnp_res->getSolde_cnp() - $tab['mt_credit']);
                        $cnp->setType_cnp($cnp_res->getType_cnp());
                        $cnp->setSource_credit($cnp_res->getSource_credit());
                        $cnp->setCode_capa($cnp_res->getCode_capa());
                        $cnp->setCode_domicilier($code_domici);
                        $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                        $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                        $m_cnp->update($cnp);
                    }
                }
				
                //##################Allocation de l'investissement et du salaire de la smcipnpwi ####################
				
                $gcsc = new Application_Model_EuGcsc();
                $m_gcsc = new Application_Model_EuGcscMapper();
                $compte = new Application_Model_EuCompte();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $mser = new Application_Model_EuServirMapper();
                $ser = new Application_Model_EuServir();
                $muti = new Application_Model_EuUtiliserMapper();
                $uti = new Application_Model_EuUtiliser();
                $rappro = new Application_Model_EuRapprochement();
                $m_rappro = new Application_Model_EuRapprochementMapper();
                $mont_diff = $mont_domicilie - $mont_investis;
                if ($mont_diff > 0) {
                    $entree_i = $mont_investis;
                    $entree_s = $mont_diff;
                } else {
                    $entree_i = $mont_investis;
                    $entree_s = 0;
                }
				
                //Création du cncs à la source smc
                $type_smc = 'CNCSr';
                $smc = new Application_Model_EuSmc();
                $m_smc = new Application_Model_EuSmcMapper();
                $id_smc = $m_smc->findConuter() + 1;
                $smc->setId_smc($id_smc)
                    ->setType_smc($type_smc)
                    ->setCode_capa(null)
                    ->setId_credit(null)
                    ->setSource_credit(null)
                    ->setMontant($mont_salaire)
                    ->setEntree($entree_s)
                    ->setSortie($mont_salaire)
                    ->setSolde($mont_salaire - $entree_s)
                    ->setMontant_solde(0)
                    ->setDate_smc($date_domi->toString('yyyy-mm-dd hh:mm:ss'))
                    ->setOrigine_smc(2)
                    ->setCode_smcipn($code_smcipnpwi)
                    ->setCode_smcipnp(null)
                    ->setCode_domicilier($code_domici);
                $m_smc->save($smc);
				
                //Enregistrement dans la table eu_utiliser
                $id_uti = $muti->findConuter() + 1;
                $uti->setId_utiliser($id_uti);
                $uti->setId_smc($id_smc);
                $uti->setCode_smcipn($code_smcipnpwi);
                $uti->setCode_smcipnp(null);
                $uti->setDate_creation($date_domi->toString('yyyy-mm-dd hh:mm:ss'));
                $uti->setMontant_allouer($mont_salaire);
                $muti->save($uti);
				
                //Création du i à la source fn
                $fn_mapper = new Application_Model_EuFnMapper();
                $fn = new Application_Model_EuFn();
                $id_fn = $fn_mapper->findConuter() + 1;
                $fn->setId_fn($id_fn)
                   ->setType_fn('Ir')
                   ->setCode_capa(null)
                   ->setMontant($mont_investis)
                   ->setEntree($entree_i)
                   ->setSortie($mont_investis)
                   ->setSolde($mont_investis - $entree_i)
                   ->setMt_solde(0)
                   ->setDate_fn($date_domi->toString('yyyy-mm-dd hh:mm:ss'))
                   ->setOrigine_fn(2)
                   ->setCode_smcipn($code_smcipnpwi)
                   ->setCode_domicilier($code_domici);
                $fn_mapper->save($fn);
				
                //Enregistrement dans la table eu_servir
                $ser->setId_fn($id_fn);
                $ser->setCode_smcipn($code_smcipnpwi);
                $ser->setDate_creation($date_domi->toString('yyyy-mm-dd hh:mm:ss'));
                $ser->setMontant_allouer($mont_investis);
                $mser->save($ser);
				
                //Mise à jour de la table eu_smcipnpwi
                $find_smcipnpwi = $msmcipn->find($code_smcipnpwi, $smcipn);
                if ($find_smcipnpwi) {
                    $smcipn->setSalaire_alloue($mont_salaire)
                           ->setInvestis_alloue($mont_investis)
                           ->setEtat_alloc_salaire(1)
                           ->setEtat_alloc_investis(1);
                    $msmcipn->update($smcipn);
                }
				
                //Création de la smcipn au tegcsc
                $find_gcsc = $m_gcsc->findByDomicilie($code_domici);
                if ($find_gcsc != null) {
                    $m_gcsc->find($find_gcsc->getId_gcsc(), $gcsc);
                    $gcsc->setCode_membre($find_gcsc->getCode_membre());
                    $gcsc->setDebit($find_gcsc->getDebit() + $mont_subvent);
                    $gcsc->setCredit($find_gcsc->getCredit() + $mont_domicilie);
                    $gcsc->setSolde($find_gcsc->getSolde() - ($mont_subvent - $mont_domicilie));
                    $gcsc->setCode_smcipn($code_smcipnpwi);
                    $gcsc->setCode_smcipnp($find_gcsc->getCode_smcipnp());
                    $gcsc->setCode_domicilier($find_gcsc->getCode_domicilier());
                    $m_gcsc->update($gcsc);
                } else {
                    $id_gcsc = $m_gcsc->findConuter() + 1;
                    $gcsc->setId_gcsc($id_gcsc);
                    $gcsc->setCode_membre($num_benef);
                    $gcsc->setDebit($mont_subvent);
                    $gcsc->setCredit($mont_domicilie);
                    $gcsc->setSolde($mont_subvent - $mont_domicilie);
                    $gcsc->setCode_smcipn($code_smcipnpwi);
                    $gcsc->setCode_smcipnp(null);
                    $gcsc->setCode_domicilier($code_domici);
                    $m_gcsc->save($gcsc);
                }
				
                //Mise à jour du compte du bénéficiaire de la smcipn pour le gestionnaire
                $cat_compte = $type_domi;
                $num_comptes = 'nr-' . $cat_compte . '-' . $num_benef;
                $result = $cm_mapper->find($num_comptes, $compte);
                if ($result == false) {
                   $compte->setCode_compte($num_comptes)
                          ->setCode_membre(null)
                          ->setCode_membre_morale($num_benef)
                          ->setMifareCard('')
                          ->setLib_compte($cat_compte)
                          ->setSolde($mont_subvent)
                          ->setDate_alloc($date_domi->toString('yyyy-mm-dd hh:mm:ss'))
                          ->setCode_type_compte('nr')
                          ->setCode_cat($cat_compte)
                          ->setDesactiver(0)
                          ->setCardPrintedDate('')
                          ->setCardPrintedIDDate(0)
                          ->setNumero_carte(null);
                    $cm_mapper->save($compte);
                } else {
                    $compte->setSolde($compte->getSolde() + $mont_subvent);
                    $cm_mapper->update($compte);
                }
				
                //Enregistrement dans la table de rapprochement
                $id_rappro = $m_rappro->findConuter() + 1;
                $rappro->setId_rappro($id_rappro);
                $rappro->setId_credit(null);
                $rappro->setSource_credit(null);
                $rappro->setSource('smc');
                $rappro->setDebit_rappro($mont_subvent);
                $rappro->setCredit_rappro($mont_domicilie);
                $rappro->setSolde_rappro($mont_subvent - $mont_domicilie);
                $rappro->setCode_smcipn($code_smcipnpwi);
                $rappro->setCode_smcipnp(null);
                $rappro->setCode_domicilier($code_domici);
                $rappro->setType_rappro($type_domi);
                $m_rappro->save($rappro);

                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ': ' . $exc->getTraceAsString();
                //$this->view->message = $message;
                $this->view->data = $message;
                return;
            }
        }
    }

    public function recupbenefAction() {
	       $numero_dao = $_GET['numero_dao'];
	       $mpropo = new Application_Model_EuPropositionMapper();
           $propo = new Application_Model_EuProposition();
		   $mao = new Application_Model_EuAppelOffreMapper();
           $ao = new Application_Model_EuAppelOffre();
		   $mdemande = new Application_Model_EuDemandeMapper();
           $demande  = new Application_Model_EuDemande();
		   $mmembre = new Application_Model_EuMembreMoraleMapper();
           $membre  = new Application_Model_EuMembreMorale();
		   $data = '';
		   $benef = '';
		   $raison_sociale = '';
	       $propo_res = $mpropo->findpropbydao($numero_dao);
		   if($propo_res != null){
		       $id_appel_offre = $propo_res->getId_appel_offre();		
		       $find_dao = $mao->find($id_appel_offre,$ao);
		       $find_demande = $mdemande->find($ao->getId_demande(),$demande);
		       $benef = $demande->getCode_membre_morale();
		       $find_membre = $mmembre->find($benef,$membre);
		       $raison_sociale = $membre->getRaison_sociale();
		       if($benef != '') {
		         $data[0] = $benef;
		         $data[1] = $raison_sociale;
		       }
		   }     
		   $this->view->data = $data;
		   
	
	}

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $type_membre = $_GET['type_membre'];
        if ($type_membre == 'P') {
            $membre_db = new Application_Model_DbTable_EuMembre();
            $membre_find = $membre_db->find($num_membre);
            if (count($membre_find) == 1) {
                $result = $membre_find->current();
                $data[1] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->PREnom_membre);
            } else {
                $data = '';
            }
        } else {
            $membre_db = new Application_Model_DbTable_EuMembreMorale();
            $membre_find = $membre_db->find($num_membre);
            if (count($membre_find) == 1) {
                $result = $membre_find->current();
                $data[1] = strtoupper($result->raison_sociale);
            } else {
                $data = '';
            }
        }
        $this->view->data = $data;
    }

    public function recupmoraleAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data = strtoupper($result->raison_sociale);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function smcipnAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function smcipnlistAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuSmcipn();
        $request = $this->getRequest();
        $code_membre = $request->code_membre;
        //Récupération des demandes de l'acteur du créneau d'activités qui sont rejetées
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->where('eu_smcipn.valid_gac = ?', 0);
        if ($code_membre == '') {
            $select->where('eu_smcipn.code_membre like ?', '');
        } else {
            $select->where('eu_smcipn.code_membre like ?', $code_membre);
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

    public function offreAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function offrelistAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_demande');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuProposition();
        $request = $this->getRequest();
        $id_propo = $request->id_proposition;
        $date = $request->date;
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('p' => 'eu_proposition'), array('p.id_proposition', 'p.id_appel_offre', "to_char((p.date_creation),'dd/mm/yyyy') date_creation", 'p.montant_proposition', 'p.montant_salaire', 'p.autre_budget', 'p.code_membre_morale'))
                ->join(array('a' => 'eu_appel_offre'), 'a.id_appel_offre = p.id_appel_offre', array('id_appel_offre', 'nom_appel_offre'))
                ->where('p.disponible = ?', 1)
                ->where('p.choix_proposition = ?', 1);
        if ($id_propo == '' && $date == '') {
            $select->where('p.id_proposition like ?', '%');
            $select->where('p.date_creation like ?', '%');
        } elseif ($id_propo != '' && $date == '') {
            $select->where('p.id_proposition like ?', $id_propo);
        } elseif ($id_propo == '' && $date != '') {
            $select->where("to_char((p.date_creation),'dd/mm/yyyy') like ?", $date);
        } elseif ($id_propo != '' && $date != '') {
            $select->where('p.id_proposition like ?', $id_propo);
            $select->where("to_char((p.date_creation),'dd/mm/yyyy') like ?", $date);
        }
        $propo = $tabela->fetchAll($select);

        $count = count($propo);
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
        $totautre = 0;
        foreach ($smcipn as $row) {
            $totsal+=$row->montant_salaire;
            $totinves+=$row->montant_proposition;
            $totautre+=$row->autre_budget;
            $responce['rows'][$i]['id'] = $row->id_proposition;
            $responce['rows'][$i]['cell'] = array(
                $row->id_proposition,
                $row->id_appel_offre,
                ucfirst($row->nom_appel_offre),
                $row->code_membre_morale,
                $row->montant_salaire,
                $row->montant_proposition,
                $row->autre_budget,
                $row->date_creation,
            );
            $i++;
        }
        $responce['userdata']['nom_appel_offre'] = 'Total:';
        $responce['userdata']['salaire'] = $totsal;
        $responce['userdata']['investis'] = $totinves;
        $responce['userdata']['autre'] = $totautre;
        $this->view->data = $responce;
    }

	public function offrechangeassAction() {
        $data = array();
        $table = new Application_Model_DbTable_EuProposition();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->from(array('p' => 'eu_proposition'), array('p.id_proposition', 'p.id_appel_offre', "to_char((p.date_creation),'dd/mm/yyyy') date_creation", 'p.MONTANT_pROpOSITION', 'p.montant_salaire', 'p.autre_budget', 'p.code_membre_morale'))
                ->join(array('a' => 'eu_appel_offre'), 'a.id_appel_offre = p.id_appel_offre', array('id_appel_offre', 'numero_offre', 'nom_appel_offre'))
                ->where('p.disponible = ?', 1)
				->where('a.type_appel_offre like ?', 'ass')
                ->where('p.choix_proposition = ?', 1);
        $bes = $table->fetchAll($select);
        $i = 0;
        foreach ($bes as $value) {
            $data[$i][1] = $value->id_proposition;
            $data[$i][2] = ucfirst($value->nom_appel_offre);
            $i++;
        }
        $this->view->data = $data;
    }
	
	
	
    public function offrechangeAction() {
        $data = array();
        $table = new Application_Model_DbTable_EuProposition();
        $select = $table->select();
        $select->setIntegrityCheck(false)
                ->from(array('p' => 'eu_proposition'), array('p.id_proposition', 'p.id_appel_offre', "to_char((p.date_creation),'dd/mm/yyyy') date_creation", 'p.MONTANT_pROpOSITION', 'p.montant_salaire', 'p.autre_budget', 'p.code_membre_morale'))
                ->join(array('a' => 'eu_appel_offre'), 'a.id_appel_offre = p.id_appel_offre', array('id_appel_offre', 'numero_offre', 'nom_appel_offre'))
                ->where('p.disponible = ?', 1)
				->where('a.type_appel_offre like ?', 'kit')
                ->where('p.choix_proposition = ?', 1);
        $bes = $table->fetchAll($select);
        $i = 0;
        foreach ($bes as $value) {
            $data[$i][1] = $value->id_proposition;
            $data[$i][2] = ucfirst($value->nom_appel_offre);
            $i++;
        }
        $this->view->data = $data;
    }

	
	
    public function domicilierpreAction() {
        
    }

	
	
    public function montantprojetAction() {
        $id = $_GET["id_proposition"];
        $t_propo = new Application_Model_DbTable_EuProposition();
        $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_frais', 'eu_frais.id_proposition = eu_proposition.id_proposition')
               ->where('eu_proposition.id_proposition = ?', $id);
        $propo = $t_propo->fetchAll($select);
        if (count($propo) > 0) {
            $mont_projet = $propo->current()->mont_projet;
            $data = $mont_projet;
        } else {
            $data = 0;
        }
        $this->view->data = $data;
    }

	
	
	
    public function montantdomiAction() {
        //Récupération du montant total du projet
        $id = $_GET["id_proposition"];
        $t_propo = new Application_Model_DbTable_EuProposition();
        $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_frais', 'eu_frais.id_proposition = eu_proposition.id_proposition')
                ->where('eu_proposition.id_proposition = ?', $id);
        $propo = $t_propo->fetchAll($select);
        if (count($propo) > 0) {
            $mont_projet = $propo->current()->mont_projet;
            $data = $mont_projet;
        } else {
            $mont_projet = 0;
        }
		
        //Récupération du montant déjà domicilier sur le projet
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        //$somme_domi = $mdo->getSumByProposition($id);
		$domi = $mdo->findByProposition($id);
		if($domi != null) {
           $reste_domi = ($mont_projet/$domi->getDuree_renouvellement()) - $domi->getMontant_domicilier();
           $data = number_format($reste_domi, 0, ',', '');
		} else {
           $data = $mont_projet/24;
        }
        $this->view->data = $data;		
    }

	
	
	
    public function membreapporteurAction() {
        $data = array();
        $type_membre = $_GET["type_membre"];
        if ($type_membre != '' && $type_membre == 'P') {
            $mb = new Application_Model_DbTable_EuMembre();
            $result = $mb->fetchAll();
            foreach ($result as $p) {
                $data[] = $p->code_membre;
            }
        } else if ($type_membre != '' && $type_membre == 'M') {
            $mb = new Application_Model_DbTable_EuMembreMorale();
            $result = $mb->fetchAll();
            foreach ($result as $p) {
                $data[] = $p->code_membre_morale;
            }
        } else {
            $data = '';
        }

        $this->view->data = $data;
    }

	
	
    public function domiechueAction() {
        //$this->_helper->layout->disableLayout();
    }

	
	
	
    public function domiechuelistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50000);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
        //Liste des domiciliations pour la smcipnwi
        $select1 = $tabela->select();
        $select1->setIntegrityCheck(false)
                ->from(array('d' => 'eu_domiciliation'), array('*', "to_char((d.date_domiciliation),'dd/MM/YYYY') date_domiciliation", "to_char((d.date_echue),'dd/MM/YYYY') date_echue"))
                ->where('d.id_utilisateur like ?', $user->id_utilisateur)
                ->where('d.accorder = ?', 'N')
                ->where('d.domicilier = ?', 'O')
                ->where('d.type_domiciliation like ?', 'smcipnwi');
        //Liste des domiciliations pour la smcipnp
        $select2 = $tabela->select();
        $select2->setIntegrityCheck(false)
                ->from(array('d' => 'eu_domiciliation'), array('*', "to_char((d.date_domiciliation),'dd/MM/YYYY') date_domiciliation", "to_char((d.date_echue),'dd/MM/YYYY') date_echue"))
                ->where('d.id_utilisateur like ?', $user->id_utilisateur)
                ->where('d.accorder = ?', 'N')
                ->where('d.domicilier = ?', 'O')
                ->where('d.type_domiciliation like ?', 'smcipnp');
        $select->setIntegrityCheck(false)
                ->union(array($select1, $select2))
        //->order('d.dATE_dOMICILIATION', 'desc')
        ;
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
        $tot_subvent = 0;
        $tot_domici = 0;
        foreach ($domici as $row) {
            if ($row->id_proposition != '') {
                $tabelp = new Application_Model_DbTable_EuProposition();
                $sele = $tabelp->select();
                $sele->setIntegrityCheck(false)
                     ->From(array('p' => 'eu_proposition'), array('id_proposition', 'id_appel_offre'))
                     ->join(array('a' => 'eu_appel_offre'), 'p.id_appel_offre = a.id_appel_offre', array('id_appel_offre', 'nom_appel_offre'))
                     ->where('p.id_proposition like ?', $row->id_proposition);
                $propo = $tabelp->fetchAll($sele);
                $res = $propo->current();
                $nom_appel = $res->nom_appel_offre;
            } else {
                $nom_appel = '';
            }
            if ($row->domicilier == 'N') {
                $etat = 'En cours';
            } else {
                $etat = 'Terminée';
            }
            $tot_subvent+=$row->montant_subvent;
            $tot_domici+=$row->montant_domicilier;
            $responce['rows'][$i]['id'] = $row->code_domicilier;
            $responce['rows'][$i]['cell'] = array(
                $row->code_domicilier,
                $row->code_membre_beneficiaire,
                $row->cat_ressource,
                $row->montant_subvent,
                $row->montant_domicilier,
                $row->date_domiciliation,
                $row->date_echue,
                $nom_appel,
                $row->type_domiciliation,
                $row->id_proposition,
                $etat,
            );
            $i++;
        }
        $responce['userdata']['num_benef'] = 'Total:';
        $responce['userdata']['mt_subvent'] = $tot_subvent;
        $responce['userdata']['mt_domici'] = $tot_domici;
        $this->view->data = $responce;
    }





    //####### Payement kit technopole ########
    public function domicilierpayementAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
	       $membre = $user->code_membre;
	       if (substr($membre,19,1) == 'P') {
	       $membre_db = new Application_Model_DbTable_EuMembre();
           $membre_find = $membre_db->find($membre);
		   if (count($membre_find) == 1) {
		      $result = $membre_find->current();
			  $nom = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
		   }
	       } else {
		   
		   }
		   $this->view->code_membre = $membre;
	       $this->view->nom = $nom;    
    }
  
  
  
	
    public function creditspayementAction()   {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_credi');
        $sord = $this->_request->getParam("sord", 'asc');
        if ($_GET['code_membre'] != '') {
           $membre = $_GET['code_membre'];
           //Reconstitution du tableau des numéros membres
           //$tab_clt = array();
           //$tab_clt = explode(",", $client);
           //Liste des types de credits récurrent
		   
           $produit = array('RPGr');
		   $compte_source = array('CAIPCNRPREKITTEC','CAPUNRPREKITTEC','CMITNRPREKITTEC');
           $tcredit = new Application_Model_DbTable_EuCompteCredit();
           $select = $tcredit->select();
           $select->from('eu_compte_credit', array('*'))
                  ->where('compte_source in (?)',$compte_source)
				  ->where('code_produit in (?)',$produit)
                  ->where('code_membre like ?',$membre)
                  ->where('krr like ?','N')
                  ->where('code_compte like ?','NB%')
				  ->where('montant_credit <> ?',0)
                  ->where('domicilier like ?',0);
			
			$produit1 = array('RPGnrPRE');
		    $compte_source1 = array('CAPARPG');
            $select1 = $tcredit->select();
            $select1->from('eu_compte_credit', array('*'))
                    ->where('compte_source in (?)',$compte_source1)
				    ->where('code_produit in (?)',$produit1)
                    ->where('code_membre like ?',$membre)
                    ->where('krr like ?','N')
                    ->where('code_compte like ?','NB%')
				    ->where('montant_credit <> ?',0)
                    ->where('domicilier like ?',0);	  
			
			 $selection = $tcredit->select();
             $selection->union(array($select,$select1));	  
             $credit = $tcredit->fetchAll($selection);

             $count = count($credit);
             if ($count > 0) {
                $total_pages = ceil($count / $limit);
             } else {
                $total_pages = 0;
             }

           if ($page > $total_pages)
              $page = $total_pages;

           $credit = $tcredit->fetchAll($selection, "$sidx $sord", $limit, ($page * $limit - $limit));

           $responce['page'] = $page;
           $responce['total'] = $total_pages;
           $responce['records'] = $count;
           $i = 0;
           foreach ($credit as $row) {
		      $date_octroi = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
              $responce['rows'][$i]['id'] = $row->id_credit;
              $responce['rows'][$i]['cell'] = array(
                 $row->code_membre,
                 $row->code_produit,
                 $row->montant_place,
                 $row->montant_credit,
                 $date_octroi->toString('dd-MM-yyyy'),
				 $row->compte_source,
                 $row->id_credit,
              );
              $i++;
            }
            $this->view->data = $responce;
        }
    }


    public function createpayementAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
	       $selection = array();
           $selection = $_GET['lignes'];
		   $cumul_credit = 0; 
		   $cm = new Application_Model_EuCompteCreditMapper();
           $cr = new Application_Model_EuCompteCredit();
           $mcompte = new Application_Model_EuCompteMapper();
           $compte = new Application_Model_EuCompte();
           $mdo = new Application_Model_EuDomiciliationMapper();
           $do = new Application_Model_EuDomiciliation();
           $mdod = new Application_Model_EuDetailDomicilieMapper();
           $dod = new Application_Model_EuDetailDomicilie();
           $msmcipn = new Application_Model_EuSmcipnpwiMapper();
           $smcipn = new Application_Model_EuSmcipnpwi();
		   $mpropo = new Application_Model_EuPropositionMapper();
           $propo = new Application_Model_EuProposition();
		   $mao = new Application_Model_EuAppelOffreMapper();
           $ao = new Application_Model_EuAppelOffre();
		   $mdemande = new Application_Model_EuDemandeMapper();
           $demande  = new Application_Model_EuDemande();
		   $te_mapper = new Application_Model_EuTegcMapper();
           $te = new Application_Model_EuTegc();
		   $mop = new Application_Model_EuOperationMapper();
           $op = new Application_Model_EuOperation();
		   $mgcp = New Application_Model_EuGcpMapper();
           $gcp = new Application_Model_EuGcp();
           $mcc = New Application_Model_EuCreditConsommerMapper();
           $cc = new Application_Model_EuCreditConsommer();
		   
		   $smc = new Application_Model_EuSmc();
           $smc_mapper = new Application_Model_EuSmcMapper();
		   $fn_mapper = new Application_Model_EuFnMapper();
           $fn = new Application_Model_EuFn();
		   $cnp = new Application_Model_EuCnp();
           $m_cnp = new Application_Model_EuCnpMapper();
		   $gcsc = new Application_Model_EuGcsc();
           $m_gcsc = new Application_Model_EuGcscMapper();
		   
		   $mdbnp = new Application_Model_EuDetailBnpMapper();
           $dbnp = new Application_Model_EuDetailBnp();
		   
		   $date = new Zend_Date(Zend_Date::ISO_8601);
           $date_domi = clone $date;
		    
		   if (count($selection) > 0) {
              $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
              try {
		          $ress = 'nrPRE';
		          $type_bnp = array('CAIPCNRPREKITTEC');
		          foreach ($selection as $val) {
		            $cumul_credit += $val['mt_credit'];  				  
		          }
		          $mont_domicilie = $cumul_credit;
		          $type_domi = $_GET['type_domi'];
		          $mt_payer = $_GET['mt_payer'];
				  $dev_capa = $_GET['dev_capa'];
				  $pck = Util_Utils::getParametre('pck','nr');
				  if ($dev_capa != 'XOF') {
                    $code_cours = $dev_capa .'-XOF';
                    $cours = new Application_Model_EuCours();
                    $m_cours = new Application_Model_EuCoursMapper();
                    $ret = $m_cours->find($code_cours, $cours);
                    if ($ret) {
                        if ($mt_payer != '') {
                           $mt_payer = round($mt_payer * $cours->getVal_dev_fin());
                        }
                    }
                  }
				  
		          if($type_domi == 'SMCIPNWI') {
		            $numero_dao = $_GET['numero_dao'];
					$tot_conus = 0;
					$tot_nrpre = 0;
					$cumul = 0;
					foreach ($selection as $tab) {
					   $id_credit = $tab['code_credit'];
				       $result = $cm->find($id_credit,$cr);
					   if($result) {
						 if($cr->getCompte_source() == 'CAIPCNRPREKITTEC' || $cr->getCompte_source() == 'CAPUNRPREKITTEC' || $cr->getCompte_source() == 'CMITNRPREKITTEC') {
						    $find_dbnp = $mdbnp->findDetailBnpByCredit($cr->getCode_bnp(),$id_credit);
						        if ($find_dbnp != null) {
                                    for($i = 0; $i < count($find_dbnp); $i++) {
                                       $res_dbnp = $find_dbnp[$i];
                                       $tot_conus+=$res_dbnp->getMontant_credit();
                                    }
                                }	   	
						    } else if($cr->getCode_produit() == 'RPGnrPRE' || $cr->getCode_produit() == 'InrPRE') {
						          $tot_nrpre += ($tab['mt_credit'] * $cr->getPrk());
						   
						    }
					   }   
					}
					
					// Voici le cumul des crédits domiciliés sur leur période
			        $cumul = $tot_conus + $tot_nrpre;
					
					if($cumul < $mt_payer) {
					  $db->rollback();
					  $this->view->data = 'insuff';
					  return;
					}
					
					$smcipn_res = $msmcipn->findByAO($numero_dao);
					$code_smcipnpwi = $smcipn_res->getCode_smcipn();
				    $propo_res = $mpropo->findpropbydao($numero_dao);
					$id_proposition = $propo_res->getId_proposition();
					$id_appel_offre = $propo_res->getId_appel_offre();
					
					$find_dao = $mao->find($id_appel_offre,$ao);
					$find_demande = $mdemande->find($ao->getId_demande(),$demande);
					
					$acteur = $demande->getCode_membre_morale();
					$code_domici = 'PRE' . $acteur . $date_domi->toString('yyyyMMddHHmmss');
					
					// Insertion dans la table eu_domiciliation
                    $do->setCode_domicilier($code_domici);
                    $do->setCode_membre_beneficiaire($acteur);
                    $do->setCode_membre_assureur($acteur);
                    $do->setCat_ressource($ress);
                    $do->setMontant_subvent($mt_payer);
                    $do->setMontant_domicilier($mont_domicilie);
                    $do->setDomicilier('O');
                    $do->setAccorder('O');
                    $do->setDate_domiciliation($date_domi->toString('yyyy-MM-dd HH:mm:ss'));
                    $do->setDate_echue($date_domi->toString('yyyy-MM-dd HH:mm:ss'));
                    $do->setType_domiciliation($type_domi);
                    $do->setCode_smcipn($code_smcipnpwi);
                    $do->setCode_smcipnp(null);
                    $do->setId_proposition($id_proposition);
                    $do->setId_utilisateur($user->id_utilisateur);
				    $do->setDuree_renouvellement(null);
                    $do->setReste_duree(null);
                    $mdo->save($do);
					
					
					foreach ($selection as $tab) {
					    //Enregistrement dans la table detail_domicilie
						$dod->setCode_domicilier($code_domici);
                        $dod->setId_credit($tab['code_credit']);
                        $dod->setCode_membre($tab['code_membre']);
                        $dod->setMontant_credit($tab['mt_credit']);
                        $dod->setUtiliser(1);
						$dod->setDuree_renouvellement(null);
                        $dod->setReste_duree(null);
                        $mdod->save($dod);
						
						//Mise à jour des comptes de chaque apporteur de compte crédit
                        $result = $cm->find($tab['code_credit'], $cr);
						if($result) {
						   $cr->setMontant_credit($cr->getMontant_credit() - $tab['mt_credit']);
						   $cm->update($cr);
						}
						
						//Diminution du montant du compte
                        $ret = $mcompte->find($cr->getCode_compte(), $compte);
                        if ($ret) {
                            $compte->setSolde($compte->getSolde() - $tab['mt_credit']);
							$cr->setDomicilier(1);
                            $mcompte->update($compte);
                        }
						
						//Mise à jour de la table cnp
                        $cnp_res = $m_cnp->findCnpByCreditSource($cr->getId_credit(),$cr->getSource());
                        if ($cnp_res != null) {
                            $cnp->setId_cnp($cnp_res->getId_cnp());
                            $cnp->setId_credit($cnp_res->getId_credit());
                            $cnp->setDate_cnp($cnp_res->getDate_cnp());
                            $cnp->setMont_debit($cnp_res->getMont_debit());
                            $cnp->setMont_credit($cnp_res->getMont_credit() + $tab['mt_credit']);
                            $cnp->setSolde_cnp($cnp_res->getSolde_cnp() - $tab['mt_credit']);
                            $cnp->setType_cnp($cnp_res->getType_cnp());
                            $cnp->setSource_credit($cnp_res->getSource_credit());
                            $cnp->setCode_capa($cnp_res->getCode_capa());
                            $cnp->setCode_domicilier($code_domici);
                            $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                            $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                            $m_cnp->update($cnp);
                        }
					}
					
				    //$id_gcsc = $m_gcsc->findConuter() + 1;
                    //$gcsc->setId_gcsc($id_gcsc);
                    //$gcsc->setCode_membre($acteur);
                    //$gcsc->setDebit($mt_payer);
                   // $gcsc->setCredit($mont_domicilie);
                   // $gcsc->setSolde($mont_domicilie - $mt_payer);
                   // $gcsc->setCode_smcipn($code_smcipnpwi);
                   // $gcsc->setCode_domicilier($code_domici);
                   // $m_gcsc->save($gcsc);
				  
				    $find_gcsc = $m_gcsc->findBySmcipnp($code_smcipnpwi);
                    if ($find_gcsc != null) {
                        $m_gcsc->find($find_gcsc->getId_gcsc(),$gcsc);
					    if(($find_gcsc->getDebit()) > ($find_gcsc->getCredit() + $mt_payer)) {
                          $gcsc->setCode_membre($find_gcsc->getCode_membre());
                          $gcsc->setDebit($find_gcsc->getDebit());
                          $gcsc->setCredit($find_gcsc->getCredit() + $mt_payer);
                          $gcsc->setSolde($find_gcsc->getSolde() + $mt_payer);
                          $gcsc->setCode_smcipn($code_smcipnpwi);
                          $gcsc->setCode_smcipnp($find_gcsc->getCode_smcipnp());
                          $gcsc->setCode_domicilier($find_gcsc->getCode_domicilier());
                          $m_gcsc->update($gcsc);
					    } 
						else  {
						      $gcsc->setCode_membre($find_gcsc->getCode_membre());
                              $gcsc->setDebit($find_gcsc->getDebit());
                              $gcsc->setCredit($find_gcsc->getDebit);
                              $gcsc->setSolde(0);
                              $gcsc->setCode_smcipn($code_smcipnpwi);
                              $gcsc->setCode_smcipnp($find_gcsc->getCode_smcipnp());
                              $gcsc->setCode_domicilier($find_gcsc->getCode_domicilier());
                              $m_gcsc->update($gcsc);
						  
						      $value_residuel = Util_Utils::getParametre('capitalresiduel','valeur');
							  $montant_residuel = ($mont_domicilie * $value_residuel)/100;
							  $mont_domicilie = $mont_domicilie - $montant_residuel;
							  $euacteur = new Application_Model_EuActeur();
							  $find_act = $euacteur->findByActeur($acteur);
							  $code_gac_create = $find_act->getCode_gac_create;
							  $find_cr  = $euacteur->findAcnevCapitalResi($code_gac_create);
							   
							  $find_gcsccr = $m_gcsc->findBySmcipnp($code_smcipnpwi);
							   
							  $id_gcsc = $m_gcsc->findConuter() + 1;
                              $gcsc->setId_gcsc($id_gcsc);
                              $gcsc->setCode_membre($find_cr->getCode_membre());
                              $gcsc->setDebit(0);
                              $gcsc->setCredit($montant_residuel);
                              $gcsc->setSolde($montant_residuel);
                              $gcsc->setCode_smcipn(null);
                              $gcsc->setCode_domicilier($code_domici);
                              $m_gcsc->save($gcsc);
							   
					          $te_mapper->findByMembre($acteur,$te);
		                      $code_tegc = $te->getCode_tegc();
							  //Mise à jour de la table opération
                              $compteur = $mop->findConuter() + 1;
                              $op->setId_operation($compteur)
                                  ->setDate_op($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                                  ->setHeure_op($date_domi->toString('hh:mm:ss'))
                                  ->setId_utilisateur($user->id_utilisateur)
                                  ->setCode_membre_morale($acteur)
								  ->setCode_membre(null)
                                  ->setMontant_op($mont_domicilie)
                                  ->setCode_produit('GCP')
                                  ->setLib_op('Transfert de la domiciliation sur le compte TEGCP')
                                  ->setType_op('TGCP')
                                  ->setCode_cat('TPAGCP');
                                $mop->save($op);
								
								
								//Mise à jour de la table de domiciliation
								$result = $mdo->find($code_domici,$do);
								if ($result) {
								
								    $do->setMontant_domicilier($do->getMontant_domicilier() - $mont_domicilie);
                                    $mdo->update($do);
								    $find_cnpgcp = $m_cnp->findCnpByDomiGcp($code_domici);
									if ($find_cnpgcp != null) {
									   $nb_credit = count($find_cnpgcp); 
									   for ($j = 0; $j <= $nb_credit - 1; $j++) {
									       $res_cnp = $find_cnpgcp[$j];
                                           //Récupération du montant effectif de la domiciliation dans eu_detail_domicilie
                                           $mont_domi = 0;
                                           $find_ddo = $mddo->find($code_domici,$res_cnp->getId_credit(),$ddo);
									       if ($find_ddo != false) {
                                               $mont_domi = $ddo->getMontant_credit();
                                           }
										   $cnp->setId_cnp($res_cnp->getId_cnp())
                                               ->setType_cnp($res_cnp->getType_cnp())
                                               ->setCode_capa($res_cnp->getCode_capa())
                                               ->setId_credit($res_cnp->getId_credit())
                                               ->setSource_credit($res_cnp->getSource_credit())
                                               ->setDate_cnp($res_cnp->getDate_cnp())
                                               ->setMont_debit($res_cnp->getMont_debit())
                                               ->setMont_credit($res_cnp->getMont_credit())
                                               ->setSolde_cnp($res_cnp->getSolde_cnp())
                                               ->setCode_domicilier($res_cnp->getCode_domicilier())
                                               ->setOrigine_cnp($res_cnp->getOrigine_cnp())
                                               ->setTransfert_gcp(1);
                                            $m_cnp->update($cnp);
											
											//Récupération des informations du crédit
                                            $find_cred = $cm->find($res_cnp->getId_credit(),$cr);
                                            if ($find_cred != false) {
                                               $code_compte = $cr->getCode_compte();
                                               $code_produit = $cr->getCode_produit();
                                               $code_membre = $cr->getCode_membre();
                                               $compte_source = $cr->getCompte_source();
                                            }
											
											//Création du cncs r et nr à la source smc
                                            $smc = new Application_Model_EuSmc();
                                            $m_smc = new Application_Model_EuSmcMapper();
                                            $smc->setId_credit($res_cnp->getId_credit())
                                                ->setDate_smc($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setMontant($mont_domi)
                                                ->setEntree(0)
                                                ->setSortie(0)
                                                ->setSolde(0)
                                                ->setSource_credit($res_cnp->getSource_credit())
                                                ->setMontant_solde($mont_domi)
                                                ->setOrigine_smc(0)
                                                ->setCode_capa($res_cnp->getCode_capa())
                                                ->setCode_smcipnp(null)
                                                ->setCode_domicilier($res_cnp->getCode_domicilier());
                                if (strpos($compte_source, "NR-TSI") !== false) {
                                    $smc->setCode_smcipn($cred->getCode_bnp());
                                }
                                if ($res_cnp->getType_cnp() == 'RPGnrPRE' ||  $res_cnp->getType_cnp() == 'InrPRE') {
                                    $smc->setType_smc('CNCSnrPRE');
                                } else if ($res_cnp->getType_cnp() == 'RPGr') {
                                    $smc->setType_smc('CNCSr');
                                }
                                $m_smc->save($smc);
								
								//Création de la domiciliation dans la table eu_gcp
                                $origine = $res_cnp->getOrigine_cnp();
                                $code_cat = '';
                                if ($origine = 'FGIr' or $origine = 'FGInrPRE') {
                                    $code_cat = 'TPAGCI';
                                }
                                if ($origine = 'FGRPGr' or $origine = 'FGRPGnrPRE') {
                                    $code_cat = 'TPAGCRPG';
                                }
                                $gcp->setCode_tegc($code_tegc)
                                        ->setCode_cat($code_cat)
                                        ->setCode_membre($acteur)
                                        ->setId_credit($res_cnp->getId_credit())
                                        ->setSource($res_cnp->getSource_credit())
                                        ->setDate_conso($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                                        ->setMont_gcp($mont_domi)
                                        ->setMont_preleve(0)
                                        ->setReste($mont_domi);
                                $mgcp->save($gcp);			
								
								
                                //Création du crédit consommer dans eu_credit_consommer
                                $cc->setId_operation($compteur)
                                        ->setId_credit($res_cnp->getId_credit())
                                        ->setCode_membre($code_membre)
                                        ->setCode_membre_dist($acteur)
                                        ->setCode_compte($code_compte)
                                        ->setCode_produit($code_produit)
                                        ->setMont_consommation($mont_domi)
                                        ->setDate_consommation($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                                        ->setHeure_consommation($date_domi->toString('HH:mm:ss'));
                                $mcc->save($cc);			 
									   }
									    
									}
									
								
								}
							$num_compte = 'NB-TPAGCP-' . $acteur;
                            //Création ou mise à jour du compte tpagcp
                            $find_compte = $mcompte->find($num_compte,$compte);
                            if ($find_compte == true) {
                                $compte->setSolde($compte->getSolde() + $mont_domicilie);
                                $mcompte->update($compte);
                            } else {
                                $compte->setCode_membre_morale($acteur)
                                      ->setCode_cat('TPAGCP')
                                      ->setSolde($mont_domicilie)
                                      ->setDate_alloc($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                                      ->setCode_compte($num_compte)
                                      ->setLib_compte('TPAGCP')
                                      ->setDesactiver(0);
                                $mcompte->save($compte);
                            }
							
                            //Mise à jour de la table tegc
                            $find_tegc = $te_mapper->find($code_tegc,$te);
                            if ($find_tegc) {
                               $te->setMontant($te->getMontant() + $mont_domicilie);
							   $te->setSolde_tegc($te->getSolde_tegc() + $mont_domicilie);
                               $te_mapper->update($te);
                            } else {
                               $this->view->data = 'erreur_te';
                               $db->rollback();
                               return;
                            }	
								
								
							        
					 	
					    }
					 
                    }
					      
		            } 
		            else if($type_domi == 'SMCIPNP') {
					
					    $num_benef = $_GET['num_benef'];
			            $acteur = $num_benef;
					    $tot_conus = 0;
					    $tot_nrpre = 0;
					    $cumul = 0;
						
						foreach ($selection as $tab) {
					    $id_credit = $tab['code_credit'];
				        $result = $cm->find($id_credit,$cr);
					    if($result) {
						 if($cr->getCompte_source() == 'CAIPCNRPREKITTEC' || $cr->getCompte_source() == 'CAPUNRPREKITTEC' || $cr->getCompte_source() == 'CMITNRPREKITTEC') {
						    $find_dbnp = $mdbnp->findDetailBnpByCredit($cr->getCode_bnp(),$id_credit);
						    if ($find_dbnp != null) {
                                for($i = 0; $i < count($find_dbnp); $i++) {
                                   $res_dbnp = $find_dbnp[$i];
                                   $tot_conus+=$res_dbnp->getMontant_credit();
                                }
                            }	   	
						    } else if($cr->getCode_produit == 'RPGnrPRE' || $cr->getCode_produit == 'InrPRE') {
						          $tot_nrpre += ($cr->getMontant_place() * $cr->getPrk())/$pck;
						   
						    }
					    }   
					    }
						
						// Voici le cumul des crédits domiciliés sur leur période
			            $cumul = $tot_conus + $tot_nrpre;
					
					    if($cumul < $mt_payer) {
					      $db->rollback();
					      $this->view->data = 'insuff';
					      return;
					    }
					
					    $code_domici = 'PRE' . $acteur . $date_domi->toString('yyyyMMddHHmmss');
						
						$do->setCode_domicilier($code_domici);
                        $do->setCode_membre_beneficiaire($acteur);
                        $do->setCode_membre_assureur($acteur);
                        $do->setCat_ressource($ress);
                        $do->setMontant_subvent($mt_payer);
                        $do->setMontant_domicilier($mont_domicilie);
                        $do->setDomicilier('O');
                        $do->setAccorder('O');
                        $do->setDate_domiciliation($date_domi->toString('yyyy-MM-dd HH:mm:ss'));
                        $do->setDate_echue($date_echue->toString('yyyy-MM-dd HH:mm:ss'));
                        $do->setType_domiciliation($type_domi);
                        $do->setCode_smcipn($code_smcipnpwi);
                        $do->setCode_smcipnp(null);
                        $do->setId_proposition($id_proposition);
                        $do->setId_utilisateur($user->id_utilisateur);
				        $do->setDuree_renouvellement(null);
                        $do->setReste_duree(null);
                        $mdo->save($do);
						
						
					foreach ($selection as $tab) {
					    //Enregistrement dans la table detail_domicilie
						$dod->setCode_domicilier($code_domici);
                        $dod->setId_credit($tab['code_credit']);
                        $dod->setCode_membre($tab['code_membre']);
                        $dod->setMontant_credit($tab['mt_credit']);
                        $dod->setUtiliser(1);
						$dod->setDuree_renouvellement(null);
                        $dod->setReste_duree(null);
                        $mdod->save($dod);
						
						//Mise à jour des comptes de chaque apporteur de compte crédit
                        $result = $cm->find($tab['code_credit'], $cr);
						if($result) {
						   $cr->setMontant_credit($cr->getMontant_credit() - $tab['mt_credit']);
						   $cr->setDomicilier(1);
						   $cm->update($cr);
						}
						
						//Diminution du montant du compte
                        $ret = $mcompte->find($cr->getCode_compte(), $compte);
                        if ($ret) {
                           $compte->setSolde($compte->getSolde() - $tab['mt_credit']);
                           $mcompte->update($compte);
                        }
						
						//Mise à jour de la table cnp
                        $cnp_res = $m_cnp->findCnpByCreditSource($cr->getId_credit(),$cr->getSource());
                        if ($cnp_res != null) {
                            $cnp->setId_cnp($cnp_res->getId_cnp());
                            $cnp->setId_credit($cnp_res->getId_credit());
                            $cnp->setDate_cnp($cnp_res->getDate_cnp());
                            $cnp->setMont_debit($cnp_res->getMont_debit());
                            $cnp->setMont_credit($cnp_res->getMont_credit() + $tab['mt_credit']);
                            $cnp->setSolde_cnp($cnp_res->getSolde_cnp() - $tab['mt_credit']);
                            $cnp->setType_cnp($cnp_res->getType_cnp());
                            $cnp->setSource_credit($cnp_res->getSource_credit());
                            $cnp->setCode_capa($cnp_res->getCode_capa());
                            $cnp->setCode_domicilier($code_domici);
                            $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                            $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                            $m_cnp->update($cnp);
                        }
					}
					
					$value_residuel = Util_Utils::getParametre('capitalresiduel','valeur');
					$montant_residuel = ($mont_domicilie * $value_residuel)/100;
					$mont_domicilie = $mont_domicilie - $montant_residuel;
					$euacteur = new Application_Model_EuActeur();
					$find_act = $euacteur->findByActeur($acteur);
					$code_gac_create = $find_act->getCode_gac_create();
					$find_cr  = $euacteur->findAcnevCapitalResi($code_gac_create);
							   
					$find_gcsccr = $m_gcsc->findBySmcipnp($code_smcipnpwi);
							   
					$id_gcsc = $m_gcsc->findConuter() + 1;
                    $gcsc->setId_gcsc($id_gcsc);
                    $gcsc->setCode_membre($find_cr->getCode_membre());
                    $gcsc->setDebit(0);
                    $gcsc->setCredit($montant_residuel);
                    $gcsc->setSolde($montant_residuel);
                    $gcsc->setCode_smcipn(null);
                    $gcsc->setCode_domicilier($code_domici);
                    $m_gcsc->save($gcsc);
					
					$te_mapper->findByMembre($acteur,$te);
		            $code_tegc = $te->getCode_tegc();
					
				    //Mise à jour de la table opération
                    $compteur = $mop->findConuter() + 1;
                    $op->setId_operation($compteur)
                       ->setDate_op($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                       ->setHeure_op($date_domi->toString('HH:mm:ss'))
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setCode_membre_morale($acteur)
					   ->setCode_membre(null)
                       ->setMontant_op($mont_domicilie)
                       ->setCode_produit('GCP')
                       ->setLib_op('Transfert de la domiciliation sur le compte TEGCP')
                       ->setType_op('TGCP')
                       ->setCode_cat('TPAGCP');
                    $mop->save($op);
					 
					//Mise à jour de la table de domiciliation
					$result = $mdo->find($code_domici,$do);
					if ($result) {  
					   $do->setMontant_domicilier($do->getMontant_domicilier() - $mont_domicilie);
                       $mdo->update($do);
					   $find_cnpgcp = $m_cnp->findCnpByDomiGcp($code_domici);
					   if ($find_cnpgcp != null) {
					        $nb_credit = count($find_cnpgcp); 
						    for ($j = 0; $j <= $nb_credit - 1; $j++) {
					            $res_cnp = $find_cnpgcp[$j];
                                //Récupération du montant effectif de la domiciliation dans eu_detail_domicilie
                                $mont_domi = 0;
                                $find_ddo = $mddo->find($code_domici,$res_cnp->getId_credit(),$ddo);
							    if ($find_ddo != false) {
                                   $mont_domi = $ddo->getMontant_credit();
                                }
								$cnp->setId_cnp($res_cnp->getId_cnp())
                                    ->setType_cnp($res_cnp->getType_cnp())
                                    ->setCode_capa($res_cnp->getCode_capa())
                                    ->setId_credit($res_cnp->getId_credit())
                                    ->setSource_credit($res_cnp->getSource_credit())
                                    ->setDate_cnp($res_cnp->getDate_cnp())
                                    ->setMont_debit($res_cnp->getMont_debit())
                                    ->setMont_credit($res_cnp->getMont_credit())
                                    ->setSolde_cnp($res_cnp->getSolde_cnp())
                                    ->setCode_domicilier($res_cnp->getCode_domicilier())
                                    ->setOrigine_cnp($res_cnp->getOrigine_cnp())
                                    ->setTransfert_gcp(1);
                                $m_cnp->update($cnp);
								 
								//Récupération des informations du crédit
                                $find_cred = $cm->find($res_cnp->getId_credit(),$cr);
                                if ($find_cred != false) {
                                    $code_compte = $cr->getCode_compte();
                                    $code_produit = $cr->getCode_produit();
                                    $code_membre = $cr->getCode_membre();
                                    $compte_source = $cr->getCompte_source();
                                }
											
								//Création du cncs r et nr à la source smc
                                $smc = new Application_Model_EuSmc();
                                $m_smc = new Application_Model_EuSmcMapper();
                                $smc->setId_credit($res_cnp->getId_credit())
                                    ->setDate_smc($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                                    ->setMontant($mont_domi)
                                    ->setEntree(0)
                                    ->setSortie(0)
                                    ->setSolde(0)
                                    ->setSource_credit($res_cnp->getSource_credit())
                                    ->setMontant_solde($mont_domi)
                                    ->setOrigine_smc(0)
                                    ->setCode_capa($res_cnp->getCode_capa())
                                    ->setCode_smcipnp(null)
                                    ->setCode_domicilier($res_cnp->getCode_domicilier());
                                if (strpos($compte_source, "NR-TSI") !== false) {
                                    $smc->setCode_smcipn($cred->getCode_bnp());
                                }
                                if ($res_cnp->getType_cnp() == 'RPGnrPRE') {
                                    $smc->setType_smc('CNCSnrPRE');
                                } else if ($res_cnp->getType_cnp() == 'RPGr') {
                                    $smc->setType_smc('CNCSr');
                                }
                                $m_smc->save($smc);
								
								//Création de la domiciliation dans la table eu_gcp
                                $origine = $res_cnp->getOrigine_cnp();
                                $code_cat = '';
                                if ($origine = 'FGIr' or $origine = 'FGInrPRE') {
                                    $code_cat = 'TPAGCI';
                                }
                                if ($origine = 'FGRPGr' or $origine = 'FGRPGnrPRE') {
                                    $code_cat = 'TPAGCRPG';
                                }
                                $gcp->setCode_tegc($code_tegc)
                                        ->setCode_cat($code_cat)
                                        ->setCode_membre($acteur)
                                        ->setId_credit($res_cnp->getId_credit())
                                        ->setSource($res_cnp->getSource_credit())
                                        ->setDate_conso($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                                        ->setMont_gcp($mont_domi)
                                        ->setMont_preleve(0)
                                        ->setReste($mont_domi);
                                $mgcp->save($gcp);			
								
								
                                //Création du crédit consommer dans eu_credit_consommer
                                $cc->setId_operation($compteur)
                                        ->setId_credit($res_cnp->getId_credit())
                                        ->setCode_membre($code_membre)
                                        ->setCode_membre_dist($acteur)
                                        ->setCode_compte($code_compte)
                                        ->setCode_produit($code_produit)
                                        ->setMont_consommation($mont_domi)
                                        ->setDate_consommation($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                                        ->setHeure_consommation($date_domi->toString('HH:mm:ss'));
                                $mcc->save($cc);
					       
					       }
					   }
					}
					
					$num_compte = 'NB-TPAGCP-' . $acteur;
                    //Création ou mise à jour du compte tpagcp
                    $find_compte = $mcompte->find($num_compte,$compte);
                    if ($find_compte == true) {
                        $compte->setSolde($compte->getSolde() + $mont_domicilie);
                        $mcompte->update($compte);
                    } else {
                        $compte->setCode_membre_morale($acteur)
                               ->setCode_cat('TPAGCP')
                               ->setSolde($mont_domicilie)
                               ->setDate_alloc($date_domi->toString('yyyy-MM-dd HH:mm:ss'))
                               ->setCode_compte($num_compte)
                               ->setLib_compte('TPAGCP')
                               ->setDesactiver(0);
                        $mcompte->save($compte);
                    }
							
                    //Mise à jour de la table tegc
                    $find_tegc = $te_mapper->find($code_tegc,$te);
                    if ($find_tegc) {
                        $te->setMontant($te->getMontant() + $mont_domicilie);
					    $te->setSolde_tegc($te->getSolde_tegc() + $mont_domicilie);
                        $te_mapper->update($te);
                    } else {
                        $this->view->data = 'erreur_te';
                        $db->rollback();
                        return;
                    }
					} 
		            $db->commit();
                    $this->view->data = 'good';
                    return;
		         } catch (Exception $exc) {
                      $db->rollback();
                      $message = ' Erreur d\'éxécution : '. $credit . $exc->getMessage() . ': ' . $exc->getTraceAsString();
                      //$this->view->message = $message;
                      $this->view->data = $message;
                      return;
                 }
		   
		   }
		      
    }





    //####### Payement Assurance ########
    public function domicilierassuranceAction() {
        
    }



    public function creditsassuranceAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_credi');
        $sord = $this->_request->getParam("sord", 'asc');
            //Reconstitution du tableau des credits de la detentrice
            $tutilisateur = new Application_Model_DbTable_EuUtilisateur();
            $select = $tutilisateur->select();
            $select->where('code_groupe = ?', "detentrice");
            $Rutilisateur = $tutilisateur->fetchRow($select);
			$code_membre_detentrice = $Rutilisateur->code_membre;
            //Liste des types de credits récurrents
            $produit = array('RPGnr', 'Inr');
            $tcredit = new Application_Model_DbTable_EuCompteCredit();
            $select = $tcredit->select();
            $select->setIntegrityCheck(false)
                    ->from(array('d' => 'eu_compte_credit'), array('*', "to_char((d.date_octroi),'dd/MM/YYYY') date_octroi"))
                    ->join(array('c' => 'EU_capa_affecter'), 'd.id_credit = c.id_credit', array('duree_renouvellement', 'reste_duree', 'mont_invest'))
                    ->where('code_produit in(?)', $produit)
                    //->where('code_membre in(?)', $tab_clt)
					->where('code_membre = ?', $code_membre_detentrice)
                    ->where('krr like ?', 'N')
                    ->where('code_compte like ?', 'NB%')
                    ->where('domicilier like ?', 0)
                    ->where('affecter like ?', 1)
                    ->where('c.code_domicilier is null')
            ;
            $credit = $tcredit->fetchAll($select);

            $count = count($credit);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } else {
                $total_pages = 0;
            }

            if ($page > $total_pages)
                $page = $total_pages;

            $credit = $tcredit->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($credit as $row) {
                $mont_credit = $row->mont_invest / $row->duree_renouvellement;
                $total_credit = $mont_credit * $row->reste_duree;
                $responce['rows'][$i]['id'] = $row->id_credit;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_membre,
                    $row->code_produit,
                    $row->montant_place,
                    $mont_credit,
                    $row->reste_duree,
                    $total_credit,
                    $row->date_octroi,
                    $row->id_credit,
                );
                $i++;
            }
            $this->view->data = $responce;
    }




    public function createassuranceAction() {
	
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $cm = new Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $msmcipn = new Application_Model_EuSmcipnpwiMapper();
        $smcipn = new Application_Model_EuSmcipnpwi();
        $mcapaa = new Application_Model_EuCapaAffecterMapper();
        $capaa = new Application_Model_EuCapaAffecter();
        $cnp = new Application_Model_EuCnp();
        $m_cnp = new Application_Model_EuCnpMapper();
		$cnnc = new Application_Model_EuCnnc();
        $m_cnnc = new Application_Model_EuCnncMapper();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $ress = 'nrPRE';
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
		
            $acteur = $_GET['num_benef'];
            $id_proposition = $_GET['id_proposition'];
            $montant = $_GET['mt_projet'];			
            $mpropo = new Application_Model_EuPropositionMapper();
            $propo = new Application_Model_EuProposition();
		    $mao = new Application_Model_EuAppelOffreMapper();
            $ao = new Application_Model_EuAppelOffre();
		    $gcsc = new Application_Model_EuGcsc();
            $m_gcsc = new Application_Model_EuGcscMapper();
            $mpropo->find($id_proposition, $propo);
            $id_appel_offre = $propo->getId_appel_offre();
		    $pck = Util_Utils::getParametre('pck', 'r');
			$mao->find($id_appel_offre,$ao);
			$duree = $ao->getDuree_projet();
			$somme = $m_cnnc->findsum();
			$credits = $m_cnnc->findCreditByCompte();
			$smcipn_res = $msmcipn->findByAO($ao->getNumero_offre());
            $code_smcipnpwi = $smcipn_res->getCode_smcipn();
			$code_domici = 'pre' . $acteur . $date_domi->toString('yyyyMMddHHmmss');
			if ($somme < $montant) {
               $db->rollback();
               $this->view->data = "insuffisant";
               return;
            }
			
			//Mise à jour de la table eu_proposition afin de préciser l'état de la proposition
            $mpropo->find($id_proposition, $propo);
            $propo->setDisponible(0);
            $mpropo->update($propo);
			
			$do->setCode_domicilier($code_domici);
            $do->setCode_membre_beneficiaire($acteur);
            $do->setCode_membre_assureur($user->code_membre);
            $do->setCat_ressource($ress);
            $do->setMontant_subvent($montant);
            $do->setMontant_domicilier($montant);
            $do->setDomicilier('O');
            $do->setAccorder('O');
            $do->setDate_domiciliation($date_domi->toString('yyyy-mm-dd hh:mm:ss'));
            $do->setDate_echue($date_domi->toString('yyyy-mm-dd hh:mm:ss'));
            $do->setType_domiciliation('smcipnwi');
            $do->setCode_smcipn($code_smcipnpwi);
            $do->setCode_smcipnp(null);
            $do->setId_proposition($id_proposition);
            $do->setId_utilisateur($user->id_utilisateur);
		    $do->setDuree_renouvellement($duree);
            $do->setReste_duree(0);
            $mdo->save($do);
			
			
			$id_gcsc = $m_gcsc->findConuter() + 1;
            $gcsc->setId_gcsc($id_gcsc);
            $gcsc->setCode_membre($user->code_membre);
            $gcsc->setDebit($montant);
            $gcsc->setCredit($montant);
            $gcsc->setSolde(0);
            $gcsc->setCode_smcipn($code_smcipnpwi);
            $gcsc->setCode_domicilier($code_domici);
            $m_gcsc->save($gcsc);
			if ($credits != null) {
			    $j = 0;
                $reste = $montant;
                $nbre_credit = count($credits);
				while ($reste > 0 && $j < $nbre_credit) {
				  $credit = $credits[$j];
                  $id_cnnc = $credit->getId_cnnc();
				  $id_credit = $credit->getId_credit();
				  if ($reste > $credit->getSolde()) {
					
                    //Enregistrement dans la table detail_domicilie
			        /*$dod->setCode_domicilier($code_domici);
                    $dod->setId_credit($credit->getId_credit());
					if(substr($credit->getCode_membre(),19,1) == 'p'){
                       $dod->setCode_membre($credit->getCode_membre());
					}else{
					   $dod->setCode_membre_morale($credit->getCode_membre());
					}
                    $dod->setMontant_credit($credit->getSolde());
                    $dod->setUtiliser(1);
		            $dod->setDuree_renouvellement($duree);
                    $dod->setReste_duree(0);
                    $mdod->save($dod);*/
					
					//Mise à jour de la table cnp
                    $cnp_res = $m_cnp->findCnpByCreditSource($credit->getId_credit(),$credit->getSource_credit());
                    if ($cnp_res != null) {
                        $cnp->setId_cnp($cnp_res->getId_cnp());
                        $cnp->setId_credit($cnp_res->getId_credit());
                        $cnp->setDate_cnp($cnp_res->getDate_cnp());
                        $cnp->setMont_debit($cnp_res->getMont_debit());
                        $cnp->setMont_credit($cnp_res->getMont_credit() + $credit->getSolde());
                        $cnp->setSolde_cnp($cnp_res->getSolde_cnp() - $credit->getSolde() );
                        $cnp->setType_cnp($cnp_res->getType_cnp());
                        $cnp->setSource_credit($cnp_res->getSource_credit());
                        $cnp->setCode_capa($cnp_res->getCode_capa());
                        $cnp->setCode_domicilier($code_domici);
                        $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                        $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                        $m_cnp->update($cnp);
                    }
					 
					// Mise à jour des crédits  cnnc 
                    $reste = $reste - $credit->getSolde();
					$credit->setMont_utilise($credit->getMont_utilise() + $credit->getSolde());
					$credit->setSolde(0);
                    $m_cnnc->update($credit);
					
					
				  } else {
				  
				    //Enregistrement dans la table detail_domicilie
			        /*$dod->setCode_domicilier($code_domici);
                    $dod->setId_credit($credit->getId_credit());
                    if(substr($credit->getCode_membre(),19,1) == 'p'){
                       $dod->setCode_membre($credit->getCode_membre());
					} else {
					   $dod->setCode_membre_morale($credit->getCode_membre());
					}
                    $dod->setMontant_credit($reste);
                    $dod->setUtiliser(1);
		            $dod->setDuree_renouvellement($duree);
                    $dod->setReste_duree(0);
                    $mdod->save($dod);*/
					
				    //Mise à jour de la table cnp
                    $cnp_res = $m_cnp->findCnpByCreditSource($credit->getId_credit(),$credit->getSource_credit());
                    if ($cnp_res != null) {
                       $cnp->setId_cnp($cnp_res->getId_cnp());
                       $cnp->setId_credit($cnp_res->getId_credit());
                       $cnp->setDate_cnp($cnp_res->getDate_cnp());
                       $cnp->setMont_debit($cnp_res->getMont_debit());
                       $cnp->setMont_credit($cnp_res->getMont_credit() + $reste);
                       $cnp->setSolde_cnp($cnp_res->getSolde_cnp() - $reste );
                       $cnp->setType_cnp($cnp_res->getType_cnp());
                       $cnp->setSource_credit($cnp_res->getSource_credit());
                       $cnp->setCode_capa($cnp_res->getCode_capa());
                       $cnp->setCode_domicilier($code_domici);
                       $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                       $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                       $m_cnp->update($cnp);
                    } 
					// Mise à jour des crédits  cnnc 
					$credit->setMont_utilise($credit->getMont_utilise() + $reste);
					$credit->setSolde($credit->getSolde() - $reste);
                    $m_cnnc->update($credit);
                    $reste = 0;					
				  }
				  $j++;
				
			    }
			} else {
               $this->view->data = "bad";
               $db->rollback();
               return;
            }
			
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ': ' . $exc->getTraceAsString();
            //$this->view->message = $message;
            $this->view->data = $message;
            return;
        }
        //}
    }
	
	
	    
	
	
	
	
	






}

?>
