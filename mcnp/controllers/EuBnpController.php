<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuBnpController
 *
 * @author
 */
 
class EuBnpController extends Zend_Controller_Action    {

      protected $menu = '';

      //put your code here
      public function init() {
        /* Initialize action controller here */
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        $code_membre = $user->code_membre;
        $t_acteur = new Application_Model_DbTable_EuActeur();
        $t_membre = new Application_Model_DbTable_EuMembreMorale();
        if ($group == 'e_nn_achatpm_cacb') {
            $select = $t_acteur->select();
            $select->where('code_membre = ?', $code_membre)
                    ->where('type_acteur = ?', 'PBF');
            $results = $t_acteur->fetchAll($select);
        } elseif ($group == 'e_nn_achatpm_cscoe') {
            $select = $t_acteur->select();
            $select->where('code_membre = ?', $code_membre)
                    ->where('type_acteur = ?', 'PBF');
            $results = $t_acteur->fetchAll($select);
        }
        $menu = '';
        if ($group == 'bnp') {
            $menu = '<li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
                <li><a id="listes" href="/eu-bnp/listes">Vue des bnp</a></li>';
        } elseif ($group == 'banque') {
            $menu = '<li><a id="new" href="/eu-placement/new">capa</a></li>
                <li><a id="cncs" href="/eu-bnp/caps">caps</a></li>
                <li><a id="listes" href="/eu-bnp/listes">Vue des bnp</a></li>';
        } elseif ($group == 'caps') {
            $menu = '<li><a id="caps" href="/eu-bnp/capscmfh">CAPS</a></li>
			         <li><a id="caps" href="/eu-bnp/index?type=caps\">Listes des BNP</a></li>
                    ';
        } elseif ($group == 'caipc') {
            $this->menu = '<li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
                <a href="/eu-bnp/newtype?type=CAIPC\">Nouveau</a>
                    <li><a id="listes\" href="/eu-bnp/listes\">Vue des bnp</a></li>';
        } elseif ($group == 'capu') {
            $this->menu = '<li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
                <a href="/eu-bnp/newtype?type=CAPU\">Nouveau</a>
                    <li><a id="listes\" href="/eu-bnp/listes\">Vue des bnp</a></li>';
        } elseif ($group == 'cacb' && count($results) != 0) {
            $this->menu = '<li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
                <a href="/eu-bnp/cacb?type=cacb\">Nouveau</a>
                    <li><a id="listes\" href="/eu-bnp/listes\">Vue des bnp</a></li>';
        } elseif ($group == 'cscoe' && count($results) != 0) {
            $this->menu = '<li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
                <a href="/eu-bnp/cacb?type=cscoe\">Nouveau</a>
                    <li><a id="listes\" href="/eu-bnp/listes\">Vue des bnp</a></li>';
        } elseif ($group == 'cmit') {
            $menu = '<li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
                     <li><a href="/eu-bnp/newtype?type=CMIT">Nouveau</a></li>';
        } elseif ($group == 'e_nn_achatpp_caipc') {
            $menu = '<li><a href="/eu-bnp/newtype?type=CAIPC">Nouveau</a></li>
			         <li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			         <li><a id="listes" href="/eu-bnp/liste?type=CAIPC">Vue des BNP</a></li>
                    ';
        } elseif ($group == 'e_nn_achatpp_cacb' && count($results) != 0) {
            $menu = '<li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			        <li><a id="listes" href="/eu-bnp/liste?type=CACB">Vue des BNP</a></li>
                    <li><a href="/eu-bnp/cacb?type=cacb">Nouveau</a></li>';
        } elseif ($group == 'e_nn_achatpp_cmit') {
            $menu = '<li><a href="/eu-bnp/newtype?type=CMIT">Nouveau</a></li>
			         <li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			         <li><a id="listes" href="/eu-bnp/liste?type=CMIT">Vue des BNP</a></li>
                    ';
        } elseif ($group == 'e_nn_achatpp_cmitnr_pre_kit_tec') {
            $menu = '<li><a href="/eu-bnp/newtype?type=CMITNRPREKITTEC">Nouveau</a></li>
			         <li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			         <li><a id="listes" href="/eu-bnp/liste?type=CMITNRPREKITTEC" style=\"font-size:11px\">Vue des BNP</a></li>
                    ';
        } elseif ($group == 'e_nn_achatpp_capunr_pre_kit_tec') {
            $menu = '<li><a href="/eu-bnp/newtype?type=CAPUNRPREKITTEC">Nouveau</a></li>
			         <li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			         <li><a id="listes" href="/eu-bnp/liste?type=CAPUNRPREKITTEC">Vue des BNP</a></li>
                    ';
        } elseif ($group == 'e_nn_achatpp_caipcnr_pre_kit_tec') {
            $menu = '<li><a href="/eu-bnp/newtype?type=CAIPCNRPREKITTEC">Nouveau</a></li>
			         <li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			         <li><a id="listes" href="/eu-bnp/liste?type=CAIPCNRPREKITTEC">Vue des BNP</a></li>
                    ';
        } elseif ($group == 'e_nn_achatpp_capu') {
            $menu = '<li><a href="/eu-bnp/newtype?type=CAPU">Nouveau</a></li>
			         <li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			         <li><a id="listes" href="/eu-bnp/liste?type=CAPU">Vue des BNP</a></li>
                     ';
        } elseif ($group == 'e_nn_achatpm_cacb' && count($results) == 1) {
            $menu = '<li><a href="/eu-bnp/cacb?type=CACB">Nouveau</a></li>
			         <li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			         <li><a id="listes" href="/eu-bnp/liste?type=CACB">Vue des BNP</a></li>
                    ';
        } elseif ($group == 'e_nn_achatpm_cscoe' && count($results) == 1) {
            $menu = '<li><a href="/eu-bnp/cacb?type=CSCOE">Nouveau</a></li>
			         <li><a id="caps" href="/eu-bnp/index">Listes des bnp</a></li>
			         <li><a id="listes" href="/eu-bnp/liste?type=CSCOE">Vue des BNP</a></li>
                    ';
        }
        $this->view->placeholder("menu")->set($menu);
		
		//$liste = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $liste = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
        $codesecret = "";
        while(strlen($codesecret) != 8) {
          $codesecret .= $liste[rand(0,strlen($liste)-1)]; 
        }
        $this->view->codesecret = $codesecret;
		
		
    }



    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if  ($group != 'banque' and $group != 'bnp' and $group != 'caps' and $group != 'cscoe' and $group != 'cmit' and $group != 'cacb'
                and $group != 'capu' and $group != 'caipc' and $group != 'dg' and $group != 'e_nn_achatpp_caipc' and $group != 'e_nn_achatpp_cacb'
                and $group != 'e_nn_achatpp_cmit' and $group != 'e_nn_achatpp_capu' and $group != 'e_nn_achatpm_cscoe' and $group != 'e_nn_achatpm_cacb'
                and $group != 'e_nn_achatpp_cmitnr_pre_kit_tec' and $group != 'e_nn_achatpp_capunr_pre_kit_tec' and $group != 'e_nn_achatpp_caipcnr_pre_kit_tec') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
     
	 

    public function indexAction() {
           $request = $this->getRequest();
           $this->view->type = $request->type;
    }

     
	 
    public function datacmitAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page",1);
        $limit = $this->_request->getParam("rows",10);
        $sidx = $this->_request->getParam("sidx",'id_operation');
        $sord = $this->_request->getParam("sord", 'asc');
        $date = Zend_Date::now();
        
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select();
        $select->where('id_utilisateur = ?', $user->id_utilisateur);
        if ($user->code_groupe == 'e_nn_achatpp_cmit') {
            $select->where('type_op like ?', 'CMIT');
        } elseif ($user->code_groupe == 'e_nn_achatpp_capu') {
            $select->where('type_op like ?', 'CAPU');
        } elseif ($user->code_groupe == 'e_nn_achatpp_caipc') {
            $select->where('type_op like ?', 'CAIPC');
        } elseif ($user->code_groupe == 'e_nn_achatpm_cacb') {
            $select->where('type_op like ?', 'CACB');
        } elseif ($user->code_groupe == 'e_nn_achatpm_cscoe') {
            $select->where('type_op like ?', 'CSCOE');
        } elseif ($user->code_groupe == 'e_nn_achatpp_cmitnr_pre_kit_tec') {
            $select->where('type_op like ?', 'CMITNRPREKITTEC');
        } elseif ($user->code_groupe == 'e_nn_achatpp_capunr_pre_kit_tec') {
            $select->where('type_op like ?', 'CAPUNRPREKITTEC');
        } elseif ($user->code_groupe == 'e_nn_achatpp_caipcnr_pre_kit_tec') {
            $select->where('type_op like ?', 'CAIPCNRPREKITTEC');
        }

        //->where('date_op = ?', Util_Utils::toDate($date))
        $select->order('date_op desc');
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
            //$date_op = new Zend_Date($row->date_op, 'dd/mm/yy');
            if ($row->code_membre == null) {
                $code_membre = $row->code_membre_morale;
            } else {
                $code_membre = $row->code_membre;
            }
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->id_operation,
                //$date_op->toString('dd/mm/yyyy'),
                $code_membre,
                $row->lib_op,
                $row->code_cat,
                $row->code_produit,
                $row->montant_op,
                $row->type_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }
     
	 
    public function pbfAction() {
        $acteurs = array();
        $t_acteur = new Application_Model_DbTable_EuActeur();
        $act_select = $t_acteur->select();
        $act_select->where("code_activite like ?", "PBF");
        $results = $t_acteur->fetchAll($act_select);
        if (count($results) > 0) {
            foreach ($results as $acteur) {
                $acteurs[] = $acteur->code_membre;
            }
        }
        $this->view->data = $acteurs;
    }
     
	 
	 
    public function membreAction() {
        $request = $this->getrequest();
        $type = $request->type;
        $membres = array();
        if ($type == 'M') {
            $m_map = new Application_Model_EuMembreMoraleMapper();
            $rows = $m_map->fetchAll();
            foreach ($rows as $c) {
                $membres[] = $c->code_membre_morale;
            }
        } else {
            $m_map = new Application_Model_EuMembreMapper();
            $rows = $m_map->fetchAll();
            foreach ($rows as $c) {
                $membres[] = $c->code_membre;
            }
        }
        $this->view->data = $membres;
    }
     
	 
	 
    public function listesAction() {
        
    }
	
	
	public function listeAction() {
	       $request = $this->getRequest();
           $form = new Application_Form_EuBnp();
           $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		   $this->view->type = $request->type;
	}
	
	
	
      
	  
	// TABLEAU DES BNP  
    public function simulerAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $compte = $this->_request->getParam("compte");
        $type_bnp = $this->_request->getParam("type");
        $mont_capa = $this->_request->getParam("mont_capa");
        $mont_credit = $this->_request->getParam("mont_credit");
        $mont_bnp = $this->_request->getParam("montant");
        $credit_mapper = new Application_Model_EuCompteCreditMapper();
        $tbnp_mapper = new Application_Model_EuTypeBnpMapper();
        $credit = new Application_Model_EuCompteCredit();
        $rows = array();
        $comptes = explode(' ', $compte);
        // Calcul du credit
        $prk = Util_Utils::getParametre('prk', 'r');
        $pck = Util_Utils::getParametre('pck', 'r');
        $par_remb = $mont_bnp / ($pck * 4);
        if ($par_remb <= $mont_credit) {
            $taux_par = ($par_remb / $mont_credit) * 100;
            $tbnp = new Application_Model_EuTypeBnp();
            $ret_tbnp = $tbnp_mapper->find($type_bnp,$tbnp);
            if ($ret_tbnp) {
                foreach ($comptes as $cpte) {
                    $credit_mapper->find($cpte, $credit);
                    $capa = ($mont_bnp / $mont_capa) * $credit->getMontant_place();
                    $mt_credit = round(($credit->getMontant_place() * $prk) / $pck);
                    $par = $mt_credit * $taux_par / 100;
                    $panu = round(($mt_credit * ($tbnp->getTx_panu() + $tbnp->getTx_fs())) / 100);
                    if ($mt_credit > ($par + $panu)) {
                        $conus = $mt_credit - ($par + $panu);
                    } elseif (($mt_credit - $par) > 0) {
                        $panu = $mt_credit - $par;
                        $conus = 0;
                    }
                    $mont_reconst = 0;
                    $i = 1;
                    $cacb = $capa;
                    while ($mont_reconst < $cacb) {
                        $bnpdetail = new Application_Model_EuDetailBnp();
                        $bnpdetail->setCode_bnp('')
                                  ->setId_credit($credit->getId_credit())
                                  ->setMont_capa($capa)
                                  ->setMontant_credit($mont_credit)
                                  ->setMont_conus($conus)
                                  ->setMont_par($par)
                                  ->setMont_panu($panu)
                                  ->setMont_fs(0)
                                  ->setPeriode($i);
                        $rows[] = $bnpdetail;
                        $mont_reconst = $mont_reconst + $par;
                        $capa = $capa - $par;
                        $old_panu = $panu;
                        $panu = round(($mt_credit * $capa) / (4 * $cacb));
                        $conus = $conus + ($old_panu - $panu);
                        $i++;
                    }
                }
            }
        }
        $count = count($rows);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($rows as $row) {
            $responce['rows'][$i]['id'] = $row->id_detail;
            $responce['rows'][$i]['cell'] = array(
                $row->id_detail,
                $row->code_bnp,
                $row->id_credit,
                $row->periode,
                $row->mont_capa,
                $row->montant_credit,
                $row->mont_par,
                $row->mont_panu
            );
            $i++;
        }
        $this->view->data = $responce;
    }
      
	  
	  
    public function tcreditsAction() {
        $t_tab = new Application_Model_DbTable_EuTypeCredit();
        $rows = $t_tab->fetchAll();
        $data = array();
        for ($i = 0; $i < count($rows); $i++) {
            $value = $rows[$i];
            $data[$i][0] = $value->code_type_credit;
            $data[$i][1] = $value->lib_type_credit;
        }
        $this->view->data = $data;
    }
      
	


    public function capscmfhAction()  {
	    $form = new Application_Form_EuBnpCaps();
        $mont_caps = Util_Utils::getParametre('CAPS','valeur');
		$fs = Util_Utils::getParametre('FS','valeur');
		$mont_fl = Util_Utils::getParametre('FL','valeur');
		$fkps = Util_Utils::getParametre('FKPS','valeur');
		if ($this->getRequest()->isPost()) {
		    $place    = new Application_Model_EuOperation();
		    $mapper   = new Application_Model_EuOperationMapper();
			$membre   = new Application_Model_EuMembre();
			$m_map    = new Application_Model_EuMembreMapper();
			$m_caps   = new Application_Model_EuCapsMapper();
            $caps     = new Application_Model_EuCaps();
			$dvente   = new Application_Model_EuDepotVente();
			$m_dvente = new Application_Model_EuDepotVenteMapper();
			$membretiers = new Application_Model_EuMembretierscode();
			$m_membretiers = new Application_Model_EuMembretierscodeMapper();
			
			$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $code_agence = $user->code_agence;
            $code = '';
            
			$date = new Zend_Date(Zend_Date::ISO_8601);
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
		    try {
			    $j = 0;
				$i = 0;
				$type_bnp  = $_POST['type_bnp'];
				$categorie = $_POST['categorie'];
                $type_caps = $_POST['type_caps'];
				
				//$mont_caps  = $_POST['mont_caps'];
                if($categorie == 'AvecListe') { 
				    $apporteur = $_POST['apporteur'];
				    $lignedventes = $m_dvente->findbycmfh($apporteur);
					$reste = $mont_caps;
				    if ($lignedventes != null) {
					    $nbre_dvente = count($lignedventes);
					    while ($reste > 0 && $j < $nbre_dvente) {
						    $lignedvente = $lignedventes[$j];
                            $id_depot = $lignedvente->getId_depot();
							$finddvente = $m_dvente->find($id_depot,$dvente);
							
							if ($reste >= $lignedvente->getSolde_depot()) {
						        //Mise à jour de la table eu_depot_vente
                                $reste = $reste - $lignedvente->getSolde_depot();
								$lignedvente->setMont_vendu($lignedvente->getMont_vendu() + $lignedvente->getSolde_depot());
								$lignedvente->setSolde_depot(0);
                                $m_dvente->update($lignedvente);			 							   
						    } else {
							    //Mise à jour de la table eu_depot_vente
                                $lignedvente->setSolde_depot($lignedvente->getSolde_depot() - $reste);
								$lignedvente->setMont_vendu($lignedvente->getMont_vendu() + $reste);
                                $m_dvente->update($lignedvente);
						        $reste = 0;
						    }
							$j++;
				        }
				    } else {
					  $db->rollback();
                      $this->view->message = "Le membre apporteur ne dispose pas de ressources CAPS";
					  $this->view->nom_membre = $_POST["nom_membre"];
                      $this->view->prenom_membre = $_POST["prenom_membre"];
                      $this->view->sexe = $_POST["sexe_membre"];
                      $this->view->sitfam = $_POST["sitfam_membre"];
                      $this->view->datnais = $_POST["date_nais_membre"];
                      $this->view->nation = $_POST["nationalite_membre"];
                      $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                      $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                      $this->view->formation = $_POST["formation"];
                      $this->view->profession = $_POST["profession_membre"];
                      $this->view->religion = $_POST["religion_membre"];
                      $this->view->pere = $_POST["pere_membre"];
                      $this->view->mere = $_POST["mere_membre"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      return;
					}
				   
				} else {
				    $lignedventes = $m_dvente->findbycmfhsansliste();
				    $reste = $mont_caps;
				    if ($lignedventes != null) {
				        $lignedvente = $lignedventes[0];
					    $id_depot = $lignedvente->getId_depot();
					    $finddvente = $m_dvente->find($id_depot,$dvente);
						$apporteur = $lignedvente->getCode_membre();
						$lignedvente->setSolde_depot($lignedvente->getSolde_depot() - $reste);
						$lignedvente->setMont_vendu($lignedvente->getMont_vendu() + $reste);
                        $m_dvente->update($lignedvente);
				    } else {
					    $db->rollback();
                        $this->view->message = "Aucun membre apporteur ne dispose de ressources CAPS";
						$this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
					}
				}
				
				$count = $mapper->findConuter() + 1;
                $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin;
				
				$place->setId_operation($count)
                      ->setDate_op($date->toString('yyyy-MM-dd'))
                      ->setHeure_op($date->toString('HH:mm:ss'))
                      ->setId_utilisateur($user->id_utilisateur)
                      ->setCode_membre($apporteur)
                      ->setCode_membre_morale(null)
                      ->setMontant_op($mont_caps)
                      ->setCode_produit('CAPS')
                      ->setLib_op('Enrolement')
                      ->setType_op($type_bnp)
                      ->setCode_cat('TCAPS');
				$mapper->save($place);
				
				$id = $type_bnp . $apporteur . $date_deb->toString('yyyyMMddHHmmss');

                $code = $m_map->getLastCodeMembreByAgence($code_agence);
                if ($code == null) {
                    $code = $code_agence . '0000001' . 'P';
                } else {
                    $num_ordre = substr($code, 12, 7);
                    $num_ordre++;
                    $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                    $code = $code_agence . $num_ordre_bis . 'P';
                }
					
                $date_nais = new Zend_Date($_POST["date_nais_membre"]);	
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;	

                if ($date_nais >= $date_idd) {
                    $this->view->message = "Erreur d'execution: La date de naissance doit etre antérieure à la date actuelle !!!";
                    $db->rollback();
                    if ($code_caps != '') {
                        $this->view->code = $code_caps;
                    }
                    $this->view->nom_membre = $_POST["nom_membre"];
                    $this->view->prenom_membre = $_POST["prenom_membre"];
                    $this->view->sexe = $_POST["sexe_membre"];
                    $this->view->sitfam = $_POST["sitfam_membre"];
                    $this->view->datnais = $_POST["date_nais_membre"];
                    $this->view->nation = $_POST["nationalite_membre"];
                    $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                    $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                    $this->view->formation = $_POST["formation"];
                    $this->view->profession = $_POST["profession_membre"];
                    $this->view->religion = $_POST["religion_membre"];
                    $this->view->pere = $_POST["pere_membre"];
                    $this->view->mere = $_POST["mere_membre"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    return;
                }

                // insertion dans la table eu_membre
                    $membre->setCode_membre($code)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($_POST["nationalite_membre"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                           ->setDate_identification($date_idd->toString('yyyy-MM-dd'))
                           ->setCode_agence($user->code_agence)
                           ->setId_maison(null)
                           ->setCodesecret(md5($_POST["codesecret"]))
						   ->setEtat_membre('N')
						   ->setCode_gac($user->code_acteur)
                           ->setAuto_enroler('N');
                        $m_map->save($membre);

						if($categorie == 'AvecListe') {
						    $id_membretiers  = $_POST['id_membretiers'];
					        $findmembretiers = $m_membretiers->find($id_membretiers,$membretiers);
						    if($findmembretiers) {
							    $membretiers->setCode_membre($code)
							                ->setPublier(1);
							    $m_membretiers->update($membretiers);
							}
						}
						
						$acteur = $user->code_acteur;
                        $userin = new Application_Model_EuUtilisateur();
                        $mapper_user = new Application_Model_EuUtilisateurMapper();
					    // insertion dans la table eu_utilisateur
                        $id_user = $mapper_user->findConuter() + 1;
                        $userin->setId_utilisateur($id_user)
                               ->setId_utilisateur_parent($user->id_utilisateur)
                               ->setPrenom_utilisateur($_POST["prenom_membre"])
                               ->setNom_utilisateur($_POST["nom_membre"])
                               ->setLogin($code)
                               ->setPwd(md5($_POST["codesecret"]))
                               ->setDescription(null)
                               ->setUlock(0)
                               ->setCh_pwd_flog(0)
                               ->setCode_groupe('personne_physique')
					           ->setCode_groupe_create('personne_physique')
                               ->setConnecte(0)
                               ->setCode_agence($user->code_agence)
                               ->setCode_secteur(null)
                               ->setCode_zone($user->code_zone)
                              //->setCode_gac_filiere(null)
		                       ->setId_pays($user->id_pays)	    	
                               ->setCode_acteur($acteur)
					           ->setCode_membre($code);
                        $mapper_user->save($userin);							   
                    
					
				
				       // Mise à jour de la table eu_contrat
                       $contrat = new Application_Model_EuContrat();
		               $mapper_contrat = new Application_Model_EuContratMapper();
		               $id_contrat = $mapper->findConuter() + 1;
				       $contrat->setId_contrat($id_contrat);
                       $contrat->setCode_membre($code);
                       $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                       $contrat->setNature_contrat('numerique');
                       $contrat->setId_type_contrat(null);
                       $contrat->setId_type_creneau(null);
                       $contrat->setId_type_acteur(null);
                       $contrat->setId_pays(null);
                       $contrat->setId_utilisateur($user->id_utilisateur);
                       $contrat->setFiliere(null);
                       $mapper_contrat->save($contrat);	


                       // insertion dans la table eu_compte_bancaire
                       $cpte = $_POST['cpteur'];
                       $i = 1;
                       $cb_mapper = new Application_Model_EuCompteBancaireMapper();
			           $id_compte = $cb_mapper->findConuter() + 1;
                       $cb = new Application_Model_EuCompteBancaire();
                
				        while ($i <= $cpte) {
					        $id_compte = $cb_mapper->findConuter() + 1;
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                            $cb->setId_compte($id_compte)
						       ->setCode_banque($_POST['code_banque' . $i])
                               ->setCode_membre($code)
						       ->setCode_membre_morale(null)
                               ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                            $cb_mapper->save($cb);
                            }
                            $i++;
                        }

                        // insertion dans eu_fs
						$tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre($code)
						         ->setCode_membre_morale(null)
                                 ->setCode_fs('FS-' . $code)
                                 ->setCreditcode($id)
                                 ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                 ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                 ->setId_utilisateur($user->id_utilisateur)
                                 ->setMont_fs($fs);
                        $tab_fs->insert($fs_model->toArray()); 
						   
						   
						//insertion des frais d'identification dans la table operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
						$lib_op = 'Enrôlement';
                        $type_op = 'ERL';
						Util_Utils::addOperation($compteur,$code,null,'TFS',$fs,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                        						
					 
					    $carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
                        $compte = new Application_Model_EuCompte();
                        $map_compte = new Application_Model_EuCompteMapper();
					 
					    $id = $type_bnp . $apporteur . $date_deb->toString('yyyyMMddHHmmss');
				        $caps->setCode_caps($id)
                             ->setCode_membre_app($apporteur)
                             ->setCode_membre_morale_app(null)
                             ->setCode_membre_benef($code)
                             ->setMont_caps($mont_caps)
                             ->setMont_fs(0)
                             ->setPeriode(0)
                             ->setId_operation($count)
                             ->setRembourser('N')
                             ->setId_credit(null)
                             ->setIndexer(1)
                             ->setType_caps($type_caps)
                             ->setCode_type_bnp($type_bnp)
                             ->setFs_utiliser(1)
                             ->setFl_utiliser(1)
	                         ->setCps_utiliser(1)
                             ->setMont_panu_fs(0)
                             ->setReconst_fs(0)
                             ->setPanu(0)
                             ->setDate_caps($date_idd->toString('yyyy-MM-dd'))
                             ->setId_utilisateur($user->id_utilisateur)
					         ->setType_op('AUTO');
				        $m_caps->save($caps);
						
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
						$compteur = $mapper->findConuter() + 1;
						// insertion dans la table eu_operation
                        Util_Utils::addOperation($compteur,$code,null,null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),$user->id_utilisateur);
						
						
						// insertion dans la table eu_fl
						$fl->setCode_fl("FL-".$code)
                           ->setCode_membre($code)
						   ->setCode_membre_morale(null)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($id);
                        $tfl->insert($fl->toArray());
						
						
						$tcartes[0]="TPAGCRPG";
						$tcartes[1]="TCNCS";
						$tcartes[2]="TPaNu";
						$tcartes[3]="TPaR";
						$tcartes[4]="TR";
						$tcartes[5]="CAPA";
						$tcartes[5]="TRE";
									
						$tscartes[0]="TSRPG";
					    $tscartes[1]="TSCNCS";
					    $tscartes[2]="TSPaNu";
						$tscartes[3]="TSPaR";
						$tscartes[4]="TSCAPA";
						$tscartes[5]="TSRE";
						
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCS") {
                              $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
							  $type_carte = 'NR';
							  $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                              $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
							  $type_carte = 'NN';
							  $res = $map_compte->find($code_compte,$compte);
							} else {
							  $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
							  $type_carte = 'NB';
							  $res = $map_compte->find($code_compte,$compte);
							}		
								if(!$res) {
								    // insertion dans la table eu_compte
                                    $compte->setCode_cat($tcartes[$i])
                                           ->setCode_compte($code_compte)
                                           ->setCode_membre($code)
										   ->setCode_membre_morale(null)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tcartes[$i])
                                           ->setSolde(0);
									$map_compte->save($compte);
									
							    }
									
                        }
						
						for($j = 0; $j < count($tscartes); $j++) {
							if($tscartes[$j] == "TSCNCS") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
						    } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} else  {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							}
										
								if(!$res) {
								    // insertion dans la table eu_compte
                                    $compte->setCode_cat($tscartes[$j])
                                           ->setCode_compte($code_comptets)
                                           ->setCode_membre($code)
										   ->setCode_membre_morale(null)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tscartes[$j])
                                           ->setSolde(0);
									$map_compte->save($compte);
									
							    }
									
                        }
						
						//Mise e jour du compte general fgfn
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $fl);
                            $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($prix);
                            $cg_mapper->save($cg_fgfn);
                        }
						
						
						// insertion dans la table eu_carte
    					$id_demande = $carte->findConuter() + 1;
                        $carte->setId_demande($id_demande)
							  ->setCode_cat(null)
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte(null)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur($user->id_utilisateur);
                        $t_carte->insert($carte->toArray());
						
						$countop = $mapper->findConuter() + 1;		
                        Util_Utils::addOperation($countop,$code,null,null,$fkps,null,'Frais de CPS','CPS',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                        
						
						$findmembre = $m_map->find($apporteur,$membre);
						$compt = Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compt,$membre->getPortable_membre(),"Vous venez de faire l'enrolement du membre " . $code);   
                        
						
			            $compt1 = Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compt1,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP !!!  Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);   
                        
						$db->commit();
                        return $this->_helper->redirector('index','eu-membre',null,array('controller' =>'eu-membre','action' =>'index'));
                        			
			} catch (Exception $exc) {
                $db->rollback();
                $message = "Erreur d\'éxécution : " . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
            }
			    
		}
    }	
	
    public function nationAction() {
        $t_religion = new Application_Model_DbTable_EuPays();
        $results = $t_religion->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_pays;
                $data[$i][1] = ucfirst(utf8_encode($value->nationalite));
            }
        }
        $this->view->data = $data;
    }
	
	
	public function religionAction() {
        $t_religion = new Application_Model_DbTable_EuReligion();
        $results = $t_religion->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_religion_membre;
                $data[$i][1] = ucfirst(utf8_encode($value->libelle_religion));
            }
        }
        $this->view->data = $data;
    }
	
	public function compteAction() {
        $tbanque = new Application_Model_DbTable_EuBanque();
        $results = $tbanque->fetchAll();
        if (count($results) > 0) {
            $data = array();
            foreach ($results as $value) {
                $data[] = $value->code_banque;
            }
        }
        $this->view->data = $data;
    }
	
	public function nomcompteAction() {
        $code = $_GET["code"];
        if ($code != '') {
            $tbanque = new Application_Model_DbTable_EuBanque();
            $result = $tbanque->find($code);
            if (count($result) > 0) {
                $data = ucfirst(utf8_encode($result->current()->libelle_banque));
            }
        }
        $this->view->data = $data;
    }
	
	
	
	  
    public function sprkAction() {
        //$code_produit = filter_input(input_get, "code");
        //$acteur = filter_input(input_get, "acteur");
		$acteur = $_GET['acteur'];
		$code_produit = $_GET['code'];
		$data = array();
		$t_prk   = new Application_Model_DbTable_EuPrk();
		$select = $t_prk->select();
		$select->distinct();
		$select->from(array('eu_prk'),'valeur');
		$select->where('id_type_acteur = ?',$acteur);
        $prks = $t_prk->fetchAll($select);
		
        if (count($prks) > 0) {
            foreach ($prks as $value) {
              $data[] = $value->valeur;
            }
        }
		
		/*
	    $db = Zend_Db_Table::getDefaultAdapter();
        $requete = "select distinct eu_prk.valeur as value from eu_prk where  eu_prk.id_type_acteur like '$acteur'";
        $db->setFetchMode(Zend_Db::fetch_obj);
        $stmt = $db->query($requete);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
          $data[] = $row->value;
        }*/
		
        $this->view->data = $data;
    }
      
	  
	


    public function traiterbnpAction() {
	    $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		if ($this->getRequest()->isPost()) {
		    $date = new Zend_Date();
            $date_deb = clone $date;
			$date_fin = clone $date;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try {
				$m_membre = new Application_Model_EuMembreMapper();
				$m_moral = new Application_Model_EuMembreMoraleMapper();
				$membre = new Application_Model_EuMembre();
                $moral = new Application_Model_EuMembreMorale();
				$sms = new Application_Model_EuSmsmoney();
                $sms_mapper = new Application_Model_EuSmsmoneyMapper();
				$bnp = new Application_Model_EuBnp();
				$bnp_mapper = new Application_Model_EuBnpMapper();
				$oper = new Application_Model_EuOperation();
                $oper_mapper = new Application_Model_EuOperationMapper();
				$bnp_credit = new Application_Model_EuBnpCredit();
                $bnp_credit_mapper = new Application_Model_EuBnpCreditMapper();
				$cnp = new Application_Model_EuCnp();
                $cnp_mapper = new Application_Model_EuCnpMapper();
				$fn = new Application_Model_EuFn();
                $fn_mapper = new Application_Model_EuFnMapper();
				$cm = new Application_Model_EuCompte();
                $cm_mapper = new Application_Model_EuCompteMapper();
				$tbnp = new Application_Model_EuTypeBnp();
                $tbnp_mapper = new Application_Model_EuTypeBnpMapper();
				$capa = new Application_Model_EuCapa();
                $capa_mapper = new Application_Model_EuCapaMapper();
				$credit_capa_mapper = new Application_Model_EuCompteCreditCapaMapper();
                $credit_capa = new Application_Model_EuCompteCreditCapa();
				$krr = new Application_Model_EuKrr();
                $mkrr = new Application_Model_EuKrrMapper();
				$dkrr = new Application_Model_EuDetailKrr();
                $mdkrr = new Application_Model_EuDetailKrrMapper();
				$cc = new Application_Model_EuCompteCredit();
				$cc_mapper = new Application_Model_EuCompteCreditMapper();
				$tparam = new Application_Model_DbTable_EuParametres();
				
				$apporteur = $user->code_membre;
		        $mode_finance = $request->mode_finance;
				$type_bnp = $request->bnp_type;
				$beneficiaire = $request->code_membre_benef;
				$bnp_produit = $request->bnp_produit;
				$bnp_compte = $request->bnp_compte;
				$code_sms = $request->code_sms;
				$mont_capa = $request->mont_capa;
				$dev_capa = $request->dev_capa;
				$mont_credit = $request->mont_credit;
				$code_produit = $bnp_produit.$bnp_compte;
				$conus = $request->part_usu;
				
				
				$type_membre = Util_Utils::getMembreType($apporteur);
                $type_membre_benef = Util_Utils::getMembreType($beneficiaire);
				
				$ret_app = $m_moral->find($apporteur,$moral);
                if (!$ret_app) {
                   $this->view->data = "Le membre apporteur n'existe pas.";
                   $db->rollback();
                   return;
                }
				
				$t_acteur = new Application_Model_DbTable_EuActeur();
                $select = $t_acteur->select();
                $select->where('code_membre = ?', $moral->getCode_membre_morale())
                       ->where('type_acteur = ?', 'PBF');
                $results = $t_acteur->fetchAll($select);
                if (count($results) == 0) {
                   $this->view->data = "Le membre apporteur $moral->code_membre_morale doit être un PBF !!!";
                }
				
				//vérification de l'existence du membre bénéficiaire
                if (isset($beneficiaire)) {
                    if ($type_membre_benef == 'P') {
                        $ret_m = $m_membre->find($beneficiaire, $membre);
                        if (!$ret_m) {
                           $this->view->data = "Le bénéficiaire $beneficiaire n'existe pas!!!";
                           $db->rollback();
                           return;
                        }
                    } else {
                        $ret_app = $m_moral->find($beneficiaire, $moral);
                        if (!$ret_app) {
                           $db->rollback();
                           $this->view->data = "Le membre bénéficiaire $beneficiaire n'existe pas !!!";
                           return;
                        }
                    }
                }
				
				if ($type_bnp == 'CSCOE'  &&  $type_membre_benef == 'P') {
                    $this->view->data = "Les personnes physiques ne peuvent pas bénéficier du CSCOE!!!";
                    $db->rollback();
                    return;
                }

                if ($code_produit == 'Ir'  &&  $type_membre_benef == 'P') {
                    $this->view->data = "Les personnes physiques ne peuvent pas acheter du Ir !!!";
                    $db->rollback();
                    return;
                }
				
				if ($code_produit == 'RPGr'  &&  $type_membre_benef == 'M') {
                    $this->view->data = "Les personnes morales ne peuvent pas acheter du RPGr !!!";
                    $db->rollback();
                    return;
                }
				
				if($mode_finance == 'N')  {
				    $sms = $sms_mapper->findByCreditCode($code_sms);
					if($sms != NULL) {
					
					    if(($sms->getMotif() != $type_bnp)) {
					       $this->view->data = " Le motif pour lequel ce code est émis ne correspond pas pour cette operation";
						   $db->rollBack();
					       return;
				        }
						
						$montant = $sms->getCreditAmount();
                        if ($dev_capa != 'XOF') {
                            $code_cours = $dev_capa.'-XOF';
                            $cours = new Application_Model_EuCours();
                            $m_cours = new Application_Model_EuCoursMapper();
                            $ret = $m_cours->find($code_cours,$cours);
                                if ($ret) {
                                    if ($montant != '') {
                                       $montant = $montant * $cours->getVal_dev_fin();
                                    }
                                }
                        }
						
						$prk    = Util_Utils::getParametre('prk',$bnp_compte);
                        $pck    = Util_Utils::getParametre('pck',$bnp_compte);
						$tbcp   = Util_Utils::getParametre('TBCP','valeur');
						$trcapa = Util_Utils::getParametre('PRK','RCAPA');
						$tbnp_mapper->find($type_bnp,$tbnp);
						$credit = round($montant * $prk / $pck);
						$conus  = round(($credit * $tbnp->getTx_conus())/100);
						$par    = round(($credit * $tbnp->getTx_par())/100);
						$panu   = round(($credit * $tbnp->getTx_panu())/100);
						$mont_rcapa = round(($credit * $tbcp)/100);
						
						
						if($type_membre_benef == 'M') {
						   $num_compte = 'NB-TPAGCI-'.$beneficiaire;
						   $code_cat = "TPAGCI";
						} else {
						   $num_compte = 'NB-TPAGCRPG-'.$beneficiaire;
						   $code_cat = "TPAGCRPG";
						}
						
						$code_capa = 'CAPA'.$bnp_produit.$date_deb->toString('yyyyMMddHHmmss');
						$code_bnp = $type_bnp . $date_deb->toString('yyyyMMddHHmmss');
						
						
						// insertion dans la table eu_operation
                        $count = $oper_mapper->findConuter() + 1;
                        $oper->setId_operation($count)
                             ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                             ->setHeure_op($date_deb->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMontant_op($montant) 
                             ->setCode_produit($code_produit);
							 
							if($type_membre_benef == 'P') { 
						        $oper->setCode_membre($beneficiaire)	 
                                     ->setLib_op("Achat du pouvoir d'achat RPG")
                                     ->setType_op($type_bnp)
                                     ->setCode_cat($code_cat);
							} else {
                                $oper->setCode_membre_morale($beneficiaire)	 
                                     ->setLib_op("Achat du pouvoir d'achat I")
                                     ->setType_op($type_bnp)
                                     ->setCode_cat($code_cat);
                            }								 
                        $oper_mapper->save($oper);
						
						$res_cm = $cm_mapper->find($num_compte,$cm);
						if ($res_cm == false) {
						    // insertion dans la table eu_compte
                            $cm->setCode_membre($beneficiaire)
                               ->setCode_cat($code_cat)
                               ->setSolde($conus)
                               ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                               ->setCode_compte($num_compte)
                               ->setLib_compte($code_cat)
                               ->setCode_type_compte('NB')
                               ->setDesactiver(0);
                            $cm_mapper->save($cm);
                        } else {
                            $cm->setSolde($cm->getSolde() + $conus);
                            $cm_mapper->update($cm);
                        }
						
						// insertion dans la table eu_bnp
                        $bnp->setCode_bnp($code_bnp)
                            ->setCode_membre_app($apporteur)
                            ->setCode_membre_benef($beneficiaire)
                            ->setMontant_bnp($montant)
                            ->setCode_type_bnp($type_bnp)
                            ->setId_operation($count)
                            ->setRembourser('N')
                            ->setMont_conus($conus)
                            ->setMont_par($par)
                            ->setMont_panu($panu)
						    ->setConus($conus)
							->setPanu($panu)
                            ->setPeriode(1)
                            ->setMont_credit($credit);

                        if($_POST["cat_bnp"] == "bnps") {		
							$bnp->setNature_bnp("BNP");
                        } else {
                            $bnp->setNature_bnp("BNPP");
						}									
                        $bnp_mapper->save($bnp);
						
                        						
						// Envoi du conus sur le compte credit du beneficiaire
						$periode = 30;
                        $prows = $tparam->find('periode','valeur');
                        if (count($prows) > 0) {
                           $periode = $prows->current()->montant;
                        }
						
						//insertion dans la table eu_compte_credit
                        $date_fin->addDay($periode);
                        $maxcc = $cc_mapper->findConuter() + 1;
                        $source = $beneficiaire.$date_deb->toString('yyyyMMddHHmmss');
                        Util_Utils::createCompteCredit($maxcc,0,$count,$beneficiaire,$code_produit,$num_compte,$conus,$montant,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'), $source, $type_bnp, 'N', 'O', 0, 1,$code_bnp,'CNPG',$prk,0);
                            
						// insertion dans la table eu_cnp
                        $maxcnp = $cnp_mapper->findConuter() + 1;
                        $cnp->setId_cnp($maxcnp)
                            ->setId_credit($maxcc)
                            ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                            ->setMont_debit($conus)
                            ->setMont_credit(0)
                            ->setSolde_cnp($conus)
                            ->setType_cnp($code_produit)
                            ->setSource_credit($source)
                            ->setOrigine_cnp($code_produit)
                            ->setTransfert_gcp(0);
                        $cnp_mapper->save($cnp);
							
							
					    // insertion dans la table eu_capa
                        $capa->setCode_capa($code_capa)
                             ->setCode_compte('NN-CAPA-'.$beneficiaire)
                             ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
                             ->setHeure_capa($date_deb->toString('HH:mm:ss'))
                             ->setCode_membre($beneficiaire)
                             ->setMontant_capa($montant)
                             ->setMontant_utiliser($montant)
                             ->setMontant_solde(0)
                             ->setId_operation($count)
                             ->setType_capa($type_bnp)
                             ->setEtat_capa('Actif')
							 ->setCode_produit($code_produit)
                             ->setOrigine_capa('SMS');
                        $capa_mapper->save($capa);
							
							
					    // insertion dans la table eu_compte_credit_capa   
                        $credit_capa->setCode_capa($code_capa)
                                    ->setCode_produit($code_produit)
                                    ->setId_credit($maxcc)
                                    ->setMontant($montant);
                        $credit_capa_mapper->save($credit_capa);
							
						// insertion dans la table eu_fn
                        $maxfn = $fn_mapper->findConuter() + 1;
                        $fn->setId_fn($maxfn)
                           ->setCode_capa($code_capa)
                           ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
                           ->setType_fn('Ir')
                           ->setMontant($montant)
                           ->setSortie(0)
                           ->setEntree(0)
                           ->setSolde(0)
                           ->setOrigine_fn(0)
                           ->setMt_solde($montant);
                        $fn_mapper->save($fn);

						
						// Mise à jour de la table eu_smsmoney
                        $sms->setDestAccount_Consumed($num_compte)
                            ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms);
						
						// Reconstitution du CAPA
						
						$prows = $tparam->find('periode', 'valeur');
                        if (count($prows) > 0) {
                           $periode = $prows->current()->montant;
                        }
							
						$brows = $tparam->find('bnp','periode');
                        if (count($brows) > 0) {
                           $periodebnp = $brows->current()->montant;
                        }
							
					    $date_echue = new Zend_Date(Zend_Date::ISO_8601);
					    $date_echue->addDay(floor($periodebnp*$periode));
							
						$id_krr   = $mkrr->findConuter() + 1;
						$mont_krr = ($montant*$trcapa)/$pck;
						
						$krr->setId_krr($id_krr)
							->setId_credit($maxcc)
                            ->setCode_produit($code_produit)
                            ->setMont_capa($montant)
                            ->setMont_krr($mont_krr)
                            ->setDate_echue($date_echue->toString('yyyy-MM-dd'))
                            ->setDate_renouveller($date_deb->toString('yyyy-MM-dd'))
                            ->setPayer('N')
                            ->setReconstituer('N')
                            ->setDate_demande($date_deb->toString('yyyy-MM-dd'))
				            ->setType_krr('KBNP')
						    ->setMont_reconst($mont_rcapa);
								
							if (Util_Utils::getmembreType($beneficiaire) === 'M') {	
							   $krr->setCode_membre_morale($beneficiaire);	
							} else {
                               $krr->setCode_membre($beneficiaire);
                            }							
                        $mkrr->save($krr);
							
							
						$id_detail_krr = $mdkrr->findConuter() + 1;
						$dkrr->setId_detail_krr($id_detail_krr)
							 ->setId_krr($id_krr)
						     ->setId_credit($maxcc)
							 ->setSource_credit($source)
							 ->setMont_credit($mont_rcapa)
							 ->setAnnuler(0);
						$mdkrr->save($dkrr);
						
						//Enregistrement de la PaR sur le compte marchand de l'apporteur
						$compte_par = new Application_Model_EuCompte();
						$num_compte = 'NB-' . 'TPaR' . '-' . $apporteur;
						$result = $cm_mapper->find($num_compte, $compte_par);
						
						if($_POST["cat_bnp"] == "bnps") {
						
						    if ($result == false) {
						    // insertion dans la table eu_compte
                            $compte_par->setCode_cat('TPaR')
                                       ->setSolde($par)
                                       ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                       ->setCode_compte($num_compte)
                                       ->setLib_compte('TPaR')
                                       ->setCode_type_compte('NB')
                                       ->setDesactiver(0);
                                if (Util_Utils::getmembreType($apporteur) === 'M') {
                                    $compte_par->setCode_membre_morale($apporteur);
								    $compte_par->setCode_membre(null);
                                } else {
                                    $compte_par->setCode_membre($apporteur);
								    $compte_par->setCode_membre_morale(null);
                                }
                                $cm_mapper->save($compte_par);
                            } else {
						        // Mise à jour de la table eu_compte
                                $compte_par->setSolde($compte_par->getSolde() + $par);
                                $cm_mapper->update($compte_par);
                            }
						
						
					        // Envoi de la PaR sur le compte credit de l'apporteur
                            $source_par = $apporteur.$date_deb->toString('yyyyMMddHHmmss');
                            $max_par = $cc_mapper->findConuter() + 1;
                            Util_Utils::createCompteCredit($max_par,0,$count,$apporteur,'PaR',$num_compte,$par,$montant,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source_par,$maxcc,'N','N',0,1,$code_bnp,'CNPG',$prk,0);

						
						    // insertion dans la table eu_cnp
                            $cnp_par = new Application_Model_EuCnp();
                            $maxcnp = $cnp_mapper->findConuter() + 1;
                            $cnp_par->setId_cnp($maxcnp)
                                    ->setId_credit($max_par)
                                    ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                    ->setMont_debit($par)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($par)
                                    ->setType_cnp($code_produit)
                                    ->setSource_credit($source_par)
                                    ->setOrigine_cnp($code_produit)
                                    ->setTransfert_gcp(0);
                            $cnp_mapper->save($cnp_par);	
						}
						
						if($_POST["cat_bnp"] == "bnpp") {
						    // Envoi de la PaR sur le compte credit de l'apporteur
                            $source_par = $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                            $max_par = $cc_mapper->findConuter() + 1;
                            Util_Utils::createCompteCredit($max_par,0,$count,$apporteur,'PaR',$num_compte,0,$montant,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'), $source_par, $maxcc, 'O', 'N', 0, 1, $code_bnp, 'CNPG',$prk,0);
						    // insertion dans la table eu_cnp
                            $cnp_par = new Application_Model_EuCnp();
                            $maxcnp = $cnp_mapper->findConuter() + 1;
                            $cnp_par->setId_cnp($maxcnp)
                                    ->setId_credit($max_par)
                                    ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                    ->setMont_debit($par)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($par)
                                    ->setType_cnp($code_produit)
                                    ->setSource_credit($source_par)
                                    ->setOrigine_cnp($code_produit)
                                    ->setTransfert_gcp(0);
                            $cnp_mapper->save($cnp_par);
							
							$prows = $tparam->find('periode', 'valeur');
                            if (count($prows) > 0) {
                               $periode = $prows->current()->montant;
                            }
							
							$brows = $tparam->find('bnp','periode');
                            if (count($brows) > 0) {
                               $periodebnp = $brows->current()->montant;
                            }
							
							$date_echue = new Zend_Date(Zend_Date::ISO_8601);
							$date_echue->addDay(floor($periodebnp*$periode));
							
							$id_krr = $mkrr->findConuter() + 1;
							$krr->setId_krr($id_krr)
							    ->setId_credit($max_par)
                                ->setCode_produit('PaR')
                                ->setMont_capa($mont_place)
                                ->setMont_krr($mont_place)
                                ->setDate_echue($date_echue->toString('yyyy-MM-dd'))
                                ->setDate_renouveller($date_deb->toString('yyyy-MM-dd'))
                                ->setPayer('N')
                                ->setReconstituer('N')
                                ->setDate_demande($date_deb->toString('yyyy-MM-dd'))
				                ->setType_krr('krRBNPP')
								->setMont_reconst($par);
								
							if (Util_Utils::getmembreType($apporteur) === 'M') {	
							   $krr->setCode_membre_morale($apporteur);	
							} else {
                               $krr->setCode_membre($apporteur);
                            }							
                            $mkrr->save($krr);
							
							$id_detail_krr = $mdkrr->findConuter() + 1;
							$dkrr->setId_detail_krr($id_detail_krr)
							     ->setId_krr($id_krr)
								 ->setId_credit($max_par)
								 ->setSource_credit($source_par)
								 ->setMont_credit($par)
								 ->setAnnuler(0);
							$mdkrr->save($dkrr);	 
						}
						
						if ($panu > 0) {
							//Enregistrement de la  PaNu sur le compte TPaNu de l'apporteur
						    $compte_panu = new Application_Model_EuCompte();
							$num_compte = 'NB-' . 'TPaNu' . '-' . $apporteur;
							$result = $cm_mapper->find($num_compte,$compte_panu);
							
							if ($result == false) {
							    // insertion de la PaNu dans la table eu_compte
                                $compte_panu->setCode_cat('TPaNu')
                                            ->setSolde($panu)
                                            ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                            ->setCode_compte($num_compte)
                                            ->setLib_compte('TPaNu')
                                            ->setCode_type_compte('NB')
                                            ->setDesactiver(0);
                                if (Util_Utils::getmembreType($apporteur) === 'M') {
                                    $compte_panu->setCode_membre_morale($apporteur);
									$compte_panu->setCode_membre(null);
                                } else {
                                    $compte_panu->setCode_membre($apporteur);
									$compte_panu->setCode_membre_morale(null);
                                }
                                $cm_mapper->save($compte_panu);
							
							} else {
							    // Mise à jour dans la table eu_compte
                                $compte_panu->setSolde($compte_panu->getSolde() + $panu);
                                $cm_mapper->update($compte_panu);
                            }
							
							// Envoi de la PaNu sur le compte credit de l'apporteur
                            $cc_panu = new Application_Model_EuCompteCredit();
                            $maxpanu = $cc_mapper->findConuter() + 1;
                            $source_panu = $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                            Util_Utils::createCompteCredit($maxpanu,0,$count,$apporteur,'PaNu',$num_compte,$panu,$montant,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source_panu,$maxcc,'N','N',0,1,$code_bnp,'CNPG',$prk,0);

							// insertion dans la table eu_cnp
                            $cnp_panu = new Application_Model_EuCnp();
                            $maxcnp = $cnp_mapper->findConuter() + 1;
                            $cnp_panu->setId_cnp($maxcnp)
                                     ->setId_credit($maxpanu)
                                     ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                     ->setMont_debit($panu)
                                     ->setMont_credit(0)
                                     ->setSolde_cnp($panu)
                                     ->setType_cnp($code_produit)
                                     ->setSource_credit($source_panu)
                                     ->setOrigine_cnp($code_produit)
                                     ->setTransfert_gcp(0);
                            $cnp_mapper->save($cnp_panu);
							
							}
							
							// insertion dans la table eu_bnp_credit
                            $bnpcredit_mapper = new Application_Model_EuBnpCreditMapper();
                            $bnpcredit = new Application_Model_EuBnpCredit();
                            $bnpcredit->setCode_bnp($code_bnp)
                                      ->setId_credit($maxcc)
                                      ->setMont_credit($credit)
                                      ->setMont_conus($conus)
                                      ->setMont_fs(0)
                                      ->setMont_panu($panu)
                                      ->setMont_par($par)
                                      ->setMont_panu_fs(0)
                                      ->setPeriode_remb(1);
                            $bnpcredit_mapper->save($bnpcredit);
							
							// insertion dans la table eu_detail_bnp pour la creation du tableau bnp
							$bnpdetail = new Application_Model_EuDetailBnp();
                            $bnpdetail_mapper = new Application_Model_EuDetailBnpMapper();
                            $mont_capa = $montant;
                            $mont_reconst = 0;
                            $i = 1;
							
							
							while ($i <= (floor($periodebnp) + 1))  {
							    // insertion dans la table eu_bnp_detail
                                $maxbnp = $bnpdetail_mapper->findConuter() + 1;
                                $bnpdetail->setId_detail($maxbnp)
                                          ->setCode_bnp($code_bnp)
                                          ->setId_credit($maxcc)
                                          ->setMont_capa($mont_capa)
                                          ->setMontant_credit($credit)
                                          ->setMont_conus($conus)
                                          ->setMont_par($par)
                                          ->setMont_panu($panu)
                                          ->setMont_fs(0)
                                          ->setMont_panu_fs(0)
                                          ->setPeriode($i)
										  ->setRenouv_effectue($i)
										  ;
                                $bnpdetail_mapper->save($bnpdetail);
								$i++;
							}
							
							$compteur = Util_Utils::findConuter() + 1;
							if($type_membre_benef == 'P') {
					          $findmembre = $m_membre->find($beneficiaire,$membre);
							  Util_Utils::addSms($compteur,$membre->getPortable_membre(), "Vous venez de recharger  ".$conus . " " . $dev_capa . " sur votre compte TPAGCRPG");					
							} else {
                              $findmembre = $m_moral->find($beneficiaire,$moral);
							  Util_Utils::addSms($compteur,$moral->getPortable_membre(), "Vous venez de recharger  ".$conus . " " . $code_capa . " sur votre compte TPAGCI");					
                            }
				
				    } else {
                       $db->rollback();
                       $message = "Erreur d'execution : Le code sms  '. $code_sms .'  est invalide ou inconnu pour effectuer cette operation !!!";
                       $this->view->data = $message;
                       return; 
					}
				    $db->commit();
                    $this->view->data = true;
                    return;	
				}		
		           				
		    } catch (Exception $exc) {
                $db->rollback();
                $this->view->data = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }

        }
    }


	


    	 
    public function traiteroldbnpAction() {
        $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        if ($this->getRequest()->isPost()) {
            $date = new Zend_Date();
            $date_deb = clone $date;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $apporteur = $user->code_membre;
                $beneficiaire = $request->beneficiaire;
                $beneficiaires = $request->beneficiaires;
                $produit_dom = $request->produit_dom;
                $type_bnp = $request->type_bnp;
                $marge = $request->marge;
                $compte_bnp = $request->compte;
                $comptes = $request->comptes;
                $mont_bnp = $request->mont_bnp;
                $credit_bnp = $request->credit;
                $prk = $request->prk;
                $mont_capa = $request->mont_capa;
                $mont_credit = $request->mont_credit;
                $mode_finance = $request->mode_fin;

                $type_membre = Util_Utils::getMembreType($apporteur);
                $type_membre_benef = Util_Utils::getMembreType($beneficiaire);
                $statut_beneficiaire = 'O';

                //vérification de l'existence du membre apporteur
                $m_membre = new Application_Model_EuMembreMapper();
                $m_moral = new Application_Model_EuMembreMoraleMapper();
                $membre = new Application_Model_EuMembre();
                $moral = new Application_Model_EuMembreMorale();

                $ret_app = $m_moral->find($apporteur, $moral);
                if (!$ret_app) {
                    $this->view->data = "Le membre apporteur n'existe pas.";
                    $db->rollback();
                    return;
                }

                $t_acteur = new Application_Model_DbTable_EuActeur();
                $select = $t_acteur->select();
                $select->where('code_membre = ?', $moral->getCode_membre_morale())
                       ->where('type_acteur = ?', 'PBF');
                $results = $t_acteur->fetchAll($select);
                if (count($results) == 0) {
                    $this->view->data = "Le membre apporteur $moral->code_membre_morale doit être un PBF !!!";
                }
                //vérification de l'existence du membre bénéficiaire
                if (isset($beneficiaire)) {
                    if ($type_membre_benef == 'P') {
                        $ret_m = $m_membre->find($beneficiaire, $membre);
                        if (!$ret_m) {
                            $this->view->data = "Le bénéficiaire principal $beneficiaire n'existe pas!!!";
                            $db->rollback();
                            return;
                        } else {
                            $statut_beneficiaire = $membre->getAuto_enroler();
                        }
                    } else {
                        $ret_app = $m_moral->find($beneficiaire, $moral);
                        if (!$ret_app) {
                            $db->rollback();
                            $this->view->data = "Le membre bénéficiaire principal $beneficiaire n'existe pas !!!";
                            return;
                        }
                    }
                }

                foreach ($beneficiaires as $value) {
                    if (Util_Utils::getMembreType($value) == 'P') {
                        $retour = $m_membre->find($value, $membre);
                        if (!$retour) {
                            $this->view->data = "Ce bénéficiaire $value n'existe pas!!!";
                            $db->rollback();
                            return;
                        }
                    } else {
                        $ret_app = $m_moral->find($value, $moral);
                        if (!$ret_app) {
                            $this->view->data = "Le membre bénéficiaire $value  n'existe pas.";
                            $db->rollback();
                            return;
                        }
                    }
                }

                if ($type_bnp == 'CSCOE' && $type_membre == 'P') {
                    $this->view->data = "Les personnes physiques ne peuvent pas bénéficier du cscoe!!!";
                    $db->rollback();
                    return;
                }

                if ($produit_dom == 'I' && $type_membre == 'P') {
                    $this->view->data = "Les personnes physiques ne peuvent pas domicilier du Ir!!!";
                    $db->rollback();
                    return;
                }
                $code_bnp = $type_bnp . $date_deb->tostring('yyMMddHHmmss');
                $bnp_mapper = new Application_Model_EuBnpMapper();
                $oper_mapper = new Application_Model_EuOperationMapper();
                $bnp_credit_mapper = new Application_Model_EuBnpCreditMapper();
                $cnp_mapper = new Application_Model_EuCnpMapper();
                $fn_mapper = new Application_Model_EuFnMapper();
                $cm_mapper = new Application_Model_EuCompteMapper();
                $tbnp_mapper = new Application_Model_EuTypeBnpMapper();
                $categorie = 'TPAGC' . $produit_dom;
                $num_compte = 'NB-' . $categorie . '-' . $beneficiaire;
                $produit_bnp = $produit_dom . $compte_bnp;

                //Vérification du solde du Compte gcp si  le mode de financement est gcp pbf
                if ($mode_finance == 'GCP') {
                    $code_compte_gcp = 'NB-TPAGCP-' . $apporteur;
                    $compte_gcp = new Application_Model_EuCompte();
                    $ret_gcp = $cm_mapper->find($code_compte_gcp, $compte_gcp);
                    if (!$ret_gcp) {
                        $this->view->data = "Ce Compte gcp $code_compte_gcp n'existe pas!!!";
                        $db->rollback();
                        return;
                    } else {
                        if ($compte_gcp->getSolde() < $mont_bnp) {
                            $db->rollback();
                            $this->view->data = "Le solde de ce Compte gcp $code_compte_gcp est insuffisant " . $compte_gcp->getSolde();
                            return;
                        } else {
                            $ok = true;
                        }
                    }
                } else {
                    //calcul du bnp
                    $pck = floatval(str_replace(',', '.', Util_Utils::getParametre('pck', $compte_bnp)));
                    // Mise à jour du compte du pbf
                    $dsmsmoney = new Application_Model_EuDetailSmsmoney();
                    $m_dsmsmoney = new Application_Model_EuDetailSmsmoneyMapper();
                    $transfertnn = new Application_Model_EuTransfertNn();
                    $m_transfert = new Application_Model_EuTransfertNnMapper();
                    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $compte_tr = "NN-TR-" . $apporteur;
                    $compte = new Application_Model_EuCompte();
                    $req = $cm_mapper->find($compte_tr, $compte);
                    if ($req == false) {
                        $this->view->data = "Le compte $compte_tr du pbf  n'existe pas!!!";
                        $db->rollback();
                        return;
                    }
                    $select = $t_acteur->select();
                    $select->where('code_membre = ?', $apporteur)
                           ->where('code_activite like ?', 'detaillant');
                    $resultpbf = $t_acteur->fetchAll($select);
                    if (count($resultpbf) != 0) {
                        $cumul = $m_dsmsmoney->findcumul($apporteur, $type_bnp);
                        if (($cumul < $mont_capa) && ($compte->getSolde() < $mont_capa)) {
                            $this->view->data = "Le détail du compte  $compte_tr du PBF  est insuffisant pour effectuer cette opération!!!";
                            $db->rollback();
                            return;
                        }
                        $smsmoneys = $m_dsmsmoney->findSMSByCompte($apporteur, $type_bnp);
                        $j = 0;
                        $reste = $mont_capa;
                        $nbre_sms = count($smsmoneys);
                        while ($reste > 0 && $j < $nbre_sms) {
                            $smsmoney = $smsmoneys[$j];
                            $id = $smsmoney->getId_detail_smsmoney();
                            if ($reste > $smsmoney->getSolde_sms()) {
                                //Mise à jour du compte id_detail_smsmoney
                                $reste = $reste - $smsmoney->getSolde_sms();
                                $smsmoney->setSolde_sms(0);
                                $smsmoney->setMont_vendu($smsmoney->getMont_vendu() + $smsmoney->getSolde_sms());
                                $m_dsmsmoney->update($smsmoney);
                                $compte->setSolde($compte->getSolde() - $smsmoney->getSolde_sms());
                                $cm_mapper->update($compte);
                            } else {
                                //Mise à jour du compte crédit
                                $smsmoney->setSolde_sms($smsmoney->getSolde_sms() - $reste);
                                $smsmoney->setMont_vendu($smsmoney->getMont_vendu() + $reste);
                                $m_dsmsmoney->update($smsmoney);
                                $compte->setSolde($compte->getSolde() - $reste);
                                $cm_mapper->update($compte);
                                $reste = 0;
                            }
                            $j++;
                        }
                    } else {
                        $cumul = $m_transfert->findcumultransfert($compte_tr, $type_bnp);
                        if (($cumul < $mont_capa) || ($compte->getSolde < $mont_capa)) {
                           $this->view->data = "Le compte  $compte_tr du pbf de type $type_bnp  est insuffisant pour effectuer cette opération!!!";
                           $db->rollback();
                           return;
                        }
                        $transferts = $m_transfert->findTransfertByCompte($compte_tr, $type_bnp);
                        $j = 0;
                        $reste = $mont_capa;
                        $nbre_transfert = count($transferts);
                        while ($reste > 0 && $j < $nbre_transfert) {
                            $transfert = $transferts[$j];
                            $id = $transfert->getId_transfert_nn;
                            //$rep = $m_transfert->find($id,$transfertnn);
                            if ($reste > $transfert->getSolde_transfert()) {
                                //Mise à jour du compte eu_transfert_nn
                                $reste = $reste - $transfert->getSolde_transfert();
                                $transfert->setSolde_transfert(0);
                                $transfert->setMont_vendu($transfert->getMont_vendu() + $transfert->getSolde_transfert());
                                $m_transfert->update($transfert);
                                $compte->setSolde($compte->getSolde() - $transfert->getSolde_transfert());
                                $cm_mapper->update($compte);
                            } else {
                                //Mise à jour du compte crédit
                                $transfert->setSolde_transfert($transfert->getSolde_transfert() - $reste);
                                $transfert->setMont_vendu($transfert->getMont_vendu() + $reste);
                                $m_transfert->update($transfert);
                                $compte->setSolde($compte->getSolde() - $reste);
                                $cm_mapper->update($compte);
                                $reste = 0;
                            }
                            $j++;
                        }
                    }

                    // insertion dans la table eu_operation
                    $bnp = new Application_Model_EuBnp();
                    $oper = new Application_Model_EuOperation();
                    $count = $oper_mapper->findConuter() + 1;
                    $oper->setId_operation($count)
                            ->setCode_cat($categorie)
                            ->setDate_op(Util_Utils::toDate($date_deb))
                            ->setHeure_op(Util_Utils::toDate($date_deb))
                            ->setType_op($type_bnp)
                            ->setCode_membre_morale($apporteur)
                            ->setCode_membre(null)
                            ->setCode_produit($produit_bnp)
                            ->setMontant_op($mont_bnp)
                            ->setLib_op($type_bnp)
                            ->setId_utilisateur($user->id_utilisateur);
                    $oper_mapper->save($oper);

                    // insertion dans la table eu_bnp
                    $bnp->setCode_bnp($code_bnp)
                            ->setId_operation($count)
                            ->setCode_membre_app($apporteur)
                            ->setCode_membre_benef($beneficiaire)
                            ->setMontant_bnp($mont_bnp)
                            ->setMont_credit($credit_bnp)
                            ->setMont_conus(0)
                            ->setMont_par(0)
                            ->setMont_panu(0)
                            ->setReconst_panu('N')
                            ->setReconst_par('N')
                            ->setPeriode(0)
                            ->setRembourser('N')
                            ->setCode_type_bnp($type_bnp);
                    $bnp_mapper->save($bnp);

                    //Mise à jour des crédits domiciliés et création des tableaux bnp correspondants
                    $credit_mapper = new Application_Model_EuCompteCreditMapper();
                    $credit = new Application_Model_EuCompteCredit();
                    $panu = $mont_capa - $mont_bnp;
                    $taux_panu = ($panu / $mont_capa) * 100;
                    $taux_par = 100 - $taux_panu;
                    foreach ($comptes as $cpte) {
                        $credit_mapper->find($cpte, $credit);
                        if ($credit->getRenouveller() == 'O' && $credit->getBnp() == 0 && $credit->getDomicilier() == 0) {
                            $par = 0;
                            $panu = 0;
                            if ($credit->getMontant_credit() > 0) {
                                $mt_credit = $credit->getMontant_credit();
                                $capa = round(($mont_bnp / $mont_capa) * $credit->getMontant_place());
                                $par = round(($mt_credit * $taux_par) / 100);
                                $panu = round(($mt_credit * $taux_panu) / 100);
                            }

                            // insertion dans la table eu_bnp_credit
                            $bnpcredit = new Application_Model_EuBnpCredit();
                            $bnpcredit->setCode_bnp($code_bnp)
                                    ->setId_credit($credit->getId_credit())
                                    ->setMont_credit($mt_credit)
                                    ->setMont_conus(0)
                                    ->setMont_fs(0)
                                    ->setMont_panu($panu)
                                    ->setMont_par($par)
                                    ->setMont_panu_fs(0)
                                    ->setPeriode_remb(1);
                            $bnp_credit_mapper->save($bnpcredit);

                            //Mise à jour de la table eu_bnp
                            $bnp_mapper->find($code_bnp, $bnp);
                            $bnp->setMont_par($bnp->getMont_par() + $par)
                                ->setMont_panu($bnp->getMont_panu() + $panu)
                                ->setPeriode(1);
                            $bnp_mapper->update($bnp);

                            $compte_par = new Application_Model_EuCompte();
                            $num_par = 'NB-' . 'TPaR' . '-' . $apporteur;
                            $res_par = $cm_mapper->find($num_par, $compte_par);
                            if ($res_par == false) {
							    // Insertion dans la table eu_compte
                                $compte_par->setCode_membre($apporteur)
                                           ->setCode_cat('TPaR')
                                           ->setSolde($par)
                                           ->setDate_alloc(Util_Utils::toDate($date_deb))
                                           ->setCode_compte($num_par)
                                           ->setLib_compte('PaR')
                                           ->setCode_type_compte('NB')
                                           ->setDesactiver(0);
                                $cm_mapper->save($compte_par);
                            } else {
							    // Mise à jour de la table eu_compte
                                $compte_par->setSolde($compte_par->getSolde() + $par);
                                $cm_mapper->update($compte_par);
                            }


                            // Envoi du PaR sur le compte credit de l'apporteur
                            $compte_credit = new Application_Model_EuCompteCredit();
                            $maxcc1 = $credit_mapper->findConuter() + 1;
                            $compte_credit->setId_credit($maxcc1)
                                    ->setCode_membre($apporteur)
                                    ->setCode_produit('PaR')
                                    ->setMontant_place($mont_bnp)
                                    ->setDatedeb(Util_Utils::toDate($date_deb))
                                    ->setDatefin(Util_Utils::toDate($date))
                                    ->setDate_octroi(Util_Utils::toDate($date_deb))
                                    ->setSource($credit->getSource())
                                    ->setCode_compte($num_par)
                                    ->setId_operation($count)
                                    ->setBnp(1)
                                    ->setCode_bnp($code_bnp)
                                    ->setCompte_source($credit->getId_credit())
                                    ->setMontant_credit($par)
                                    ->setRenouveller('N')
                                    ->setKrr('N')
                                    ->setPrk(1)
									->setAffecter(0)
                                    ->setNbre_renouvel(0)
                                    ->setCode_type_credit(null)
                                    ->setDomicilier(0);
                            $credit_mapper->save($compte_credit);

                            //Creation du compte PaNu
                            $compte_panu = new Application_Model_EuCompte();
                            $num_panu = 'NB-' . 'TPaNu' . '-' . $apporteur;
                            $result = $cm_mapper->find($num_panu, $compte_panu);
                            if ($result == false) {
							    // insertion dans la table eu_compte
                                $compte_panu->setCode_membre($apporteur)
                                            ->setCode_cat('TPaNu')
                                            ->setSolde($panu)
                                            ->setDate_alloc(Util_Utils::toDate($date_deb))
                                            ->setCode_compte($num_panu)
                                            ->setLib_compte('PaNu')
                                            ->setCode_type_compte('NB')
                                            ->setDesactiver(0);
                                $cm_mapper->save($compte_panu);
                            } else {
							    // Mise à jour de la table eu_compte
                                $compte_panu->setSolde($compte_panu->getSolde() + $panu);
                                $cm_mapper->update($compte_panu);
                            }

                            // Envoi du PaNu sur le compte credit de l'apporteur
                            $ccredit_panu = new Application_Model_EuCompteCredit();
                            $maxcc2 = $credit_mapper->findConuter() + 1;
                            $ccredit_panu->setId_credit($maxcc2)
                                    ->setCode_membre($apporteur)
                                    ->setCode_produit('PaNu')
                                    ->setMontant_place($mont_bnp)
                                    ->setDatedeb(Util_Utils::toDate($date_deb))
                                    ->setDatefin(Util_Utils::toDate($date))
                                    ->setDate_octroi(Util_Utils::toDate($date_deb))
                                    ->setSource($credit->getSource())
                                    ->setCode_compte($num_panu)
                                    ->setId_operation($count)
                                    ->setBnp(1)
                                    ->setCode_bnp($code_bnp)
                                    ->setCompte_source($credit->getId_credit())
                                    ->setMontant_credit($panu)
                                    ->setRenouveller('N')
                                    ->setKrr('N')
                                    ->setPrk(1)
									->setAffecter(0)
                                    ->setNbre_renouvel(0)
                                    ->setCode_type_credit(null)
                                    ->setDomicilier(0);
                            $credit_mapper->save($ccredit_panu);


                            // creation du tableau d'amortissement du bnp
                            $mont_reconst = 0;
                            $i = 1;
                            $cacb = $capa;
                            $bnpdetail_mapper = new Application_Model_EuDetailBnpMapper();

                            while ($mont_credit > 0 && $mont_reconst < $mont_bnp) {
                                $bnpdetail = new Application_Model_EuDetailBnp();
								// insertion dans la table eu_detail_bnp
                                $countbnp = $bnpdetail_mapper->findConuter() + 1;
                                $bnpdetail->setId_detail($countbnp)
                                        ->setCode_bnp($code_bnp)
                                        ->setId_credit($credit->getId_credit())
                                        ->setMont_capa($capa)
                                        ->setMontant_credit($mont_credit)
                                        ->setMont_conus(0)
                                        ->setMont_par($par)
                                        ->setMont_panu($panu)
                                        ->setMont_fs(0)
                                        ->setPeriode($i)
                                        ->setMont_panu_fs(0);
                                $bnpdetail_mapper->save($bnpdetail);
                                $mont_reconst = $mont_reconst + $par;
                                $capa = $capa - $par;
                                $old_panu = $panu;
                                $i++;
                            }
                            $credit->setBnp(1)
                                   ->setCode_bnp($code_bnp)
                                   ->setMontant_credit(0)
								   ->setDomicilier(1);
                            $credit_mapper->update($credit);
                        } else {
                            $this->view->data = "Ce crédit est déja domicilié ou n\'est pas récurrent";
                            $db->rollback();
                            return;
                        }
                    }

                    //Creation ou mise à jour du compte du beneficiaire 
                    $compte = new Application_Model_EuCompte();
                    $res = $cm_mapper->find($num_compte, $compte);
                    if ($res == false) {
					    // insertion dans la table eu_compte
                        $compte->setCode_membre($beneficiaire)
                                ->setCode_cat($categorie)
                                ->setSolde($credit_bnp)
                                ->setDate_alloc(Util_Utils::toDate($date_deb))
                                ->setCode_compte($num_compte)
                                ->setLib_compte($categorie)
                                ->setCode_type_compte('NB')
                                ->setDesactiver(0);
                        $cm_mapper->save($compte);
                    } else {
                        $compte->setSolde($compte->getSolde() + $credit_bnp);
                        $cm_mapper->update($compte);
                    }

                    // Envoi du credit sur le compte credit du beneficiaire
                    $source = $beneficiaire . $date_deb->toString('yyyyMMddHHmmss');
                    $cpte_credit = new Application_Model_EuCompteCredit();
                    $date->addDay(30);
                    $maxcc = $credit_mapper->findConuter() + 1;
                    $cpte_credit->setId_credit($maxcc)
                            ->setCode_membre($beneficiaire)
                            ->setCode_produit($produit_bnp)
                            ->setMontant_place($mont_bnp)
                            ->setDatedeb(Util_Utils::toDate($date_deb))
                            ->setDatefin(Util_Utils::toDate($date))
                            ->setDate_octroi(Util_Utils::toDate($date_deb))
                            ->setSource($source)
                            ->setCode_compte($num_compte)
                            ->setId_operation($count)
							->setAffecter(0)
                            ->setBnp(1)
                            ->setPrk($prk)
                            ->setNbre_renouvel(0)
                            ->setCode_bnp($code_bnp)
                            ->setCode_type_credit(null)
                            ->setCompte_source($type_bnp)
                            ->setMontant_credit($credit_bnp);
                    if ($produit_bnp == 'Ir' || $produit_bnp == 'RPGr') {
                        $cpte_credit->setRenouveller('O');
                    } else {
                        $cpte_credit->setRenouveller('N');
                    }
                    $cpte_credit->setDomicilier(0)
                                ->setKrr('N');

                    $credit_mapper->save($cpte_credit);

                    // Mise à jour des capa
                    $capa = new Application_Model_EuCapa();
                    $m_capa = new Application_Model_EuCapaMapper();
                    $code_capa = 'CAPA' . $produit_dom . $beneficiaire . $date_deb->toString('yyyyMMddHHmmss');
					
					// insertion dans la table eu_capa
                    $capa->setCode_capa($code_capa)
                            ->setCode_compte('NN-CAPA-'.$beneficiaire)
                            ->setDate_capa(Util_Utils::toDate($date_deb))
                            ->setHeure_capa(Util_Utils::toDate($date_deb))
                            ->setCode_membre($beneficiaire)
                            ->setMontant_capa($mont_bnp)
                            ->setId_operation($count)
                            ->setEtat_capa('Actif')
                            ->setOrigine_capa('SMS')
                            ->setType_capa($type_bnp)
							->setCode_produit($produit_bnp)
                            ->setMontant_utiliser($mont_bnp)
                            ->setMontant_solde(0);
							
                    $m_capa->save($capa);

					// insertion dans la table eu_compte_credit_capa
                    $m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                    $credit_capa = new Application_Model_EuCompteCreditCapa();
                    $credit_capa->setCode_capa($code_capa)
                            ->setCode_produit($produit_bnp)
                            ->setId_credit($maxcc)
                            ->setMontant($mont_bnp);
                    $m_credit_capa->save($credit_capa);


                    // insertion dans la table eu_fn
                    $fn = new Application_Model_EuFn();
                    $maxfn = $fn_mapper->findConuter() + 1;
                    $fn->setId_fn($maxfn)
                            ->setCode_capa($code_capa)
                            ->setDate_fn(Util_Utils::toDate($date_deb))
                            ->setType_fn('Ir')
                            ->setMontant($mont_bnp)
                            ->setSortie(0)
                            ->setEntree(0)
                            ->setSolde(0)
                            ->setOrigine_fn(0)
                            ->setMt_solde($mont_bnp);
                    $fn_mapper->save($fn);

                    // insertion dans la table eu_cnp
                    $cnp = new Application_Model_EuCnp();
                    $maxcnp = $cnp_mapper->findConuter() + 1;
                    $cnp->setId_cnp($maxcnp)
                            ->setId_credit($maxcc)
                            ->setDate_cnp(Util_Utils::toDate($date_deb))
                            ->setMont_debit($credit_bnp)
                            ->setMont_credit(0)
                            ->setSolde_cnp($credit_bnp)
                            ->setType_cnp($produit_bnp)
                            ->setSource_credit($cpte_credit->getSource())
                            ->setCode_capa($code_capa)
                            ->setTransfert_gcp(0);
                    $cnp_mapper->save($cnp);

                    //Compte fg.... selon le produit 
                    $compte_gene = new Application_Model_EuCompteGeneral();
                    $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                    $result2 = false;
                    try {
                        if ($produit_dom == 'RPG') {
                            $result2 = $cg_mapper->find('FGRPG', 'NN', 'E', $compte_gene);
                        } else {
                            $result2 = $cg_mapper->find('FGI', 'NN', 'E', $compte_gene);
                        }
                        if ($result2) {
                            $compte_gene->setSolde($compte_gene->getSolde() + $mont_bnp);
                            $cg_mapper->update($compte_gene);
                        } else {
                            if ($produit_dom == 'RPG') {
                                $compte_gene->setCode_compte('FGRPG');
                                $compte_gene->setIntitule('FGRPG');
                            } else {
                                $compte_gene->setCode_compte('FGI');
                                $compte_gene->setIntitule('FGI');
                            }
                            $compte_gene->setCode_type_compte('NN');
                            $compte_gene->setService('E');
                            $compte_gene->setSolde($mont_bnp);
                            $cg_mapper->save($compte_gene);
                        }
                        //Mise à jour du compte général fn
                        $cgfn = new Application_Model_EuCompteGeneral();
                        $result_3 = $cg_mapper->find('FN', 'NR', 'E', $cgfn);
                        if ($result_3) {
                            $cgfn->setSolde($cgfn->getSolde() + $mont_bnp);
                            $cg_mapper->update($cgfn);
                        } else {
                            $cgfn->setCode_compte('FN');
                            $cgfn->setIntitule('FN');
                            $cgfn->setService('E')->setCode_type_compte('nr');
                            $cgfn->setSolde($mont_bnp);
                            $cg_mapper->save($cgfn);
                        }
                    } catch (Exception $e) {
                        $db->rollback();
                        $message = "Erreur d\'éxécution : " . $e->getMessage() . $e->getTraceAsString();
                        $this->view->data = $message;
                        return;
                    }

                    //Mise à jour du gcp pbf et ses détails
                    if ($mode_finance == 'GCP' && $ok) {

                        //Mise à jour des fgfn
                        $fgfn = new Application_Model_EuFgfn();
                        $fgfn_map = new Application_Model_EuFgfnMapper();
                        $code_fgfn = 'FGFN-' . $user->code_membre;
                        $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                        if (!$ret_fg) {
                            $fgfn->setCode_fgfn($code_fgfn)
                                 ->setCode_membre($user->code_membre)
                                 ->setSolde_fgfn($mont_bnp);
                            $fgfn_map->save($fgfn);
                        } else {
                            $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $mont_bnp);
                            $fgfn_map->update($fgfn);
                        }
                        $det_fg = new Application_Model_EuDetailFgfn();
                        $dfg_mapper = new Application_Model_EuDetailFgfnMapper();
                        $det_fg->setCode_capa($code_capa)
                               ->setCode_membre_pbf($user->code_membre)
                               ->setMont_fgfn($mont_bnp)
                               ->setDate_fgfn($date_deb->toString('yyyy-mm-dd'))
                               ->setMont_preleve(0)
                               ->setSolde_fgfn($mont_bnp)
                               ->setCode_fgfn($code_fgfn)
                               ->setType_capa('CAPA' . $produit_dom)
                               ->setOrigine_fgfn('FGNN')
                               ->setCreditcode(null);
                        $dfg_mapper->save($det_fg);

                        $mont_gcp_pbf = $mont_bnp;
                        $prk = ceil(Util_Utils::getParametre('prk', 'nr'));
                        $pck = Util_Utils::getParametre('pck', 'nr');
                        $agio_compens = $mont_bnp - round(($mont_bnp * $pck) / $prk);
                        $gcpr_compens = $mont_bnp - $agio_compens;
                        $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
                        $gcp_pbf = new Application_Model_EuGcpPbf();
                        $gcp_pbfs = $m_gcp_pbf->fetchAllByPbf($apporteur);
                        foreach ($gcp_pbfs as $gcp_pbf) {
                            //Mise à jour du gcp pbf
                            $mont_a_deduire = 0;
                            if ($gcp_pbf->getSolde_gcp() > $mont_bnp) {
                                $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $agio_compens)
                                        ->setSolde_agio($gcp_pbf->getSolde_agio() - $agio_compens)
                                        ->setGcp_compense($gcp_pbf->getGcp_compense() + $mont_bnp)
                                        ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() - $gcpr_compens)
                                        ->setSolde_gcp($gcp_pbf->getSolde_gcp() - $mont_bnp);
                                $m_gcp_pbf->update($gcp_pbf);
                                $mont_a_deduire = $mont_bnp;
                                $montant = 0;
                            } else {
                                $mont_a_deduire = $gcp_pbf->getSolde_gcp();
                                $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $gcp_pbf->getSolde_agio())
                                        ->setSolde_agio(0)
                                        ->setGcp_compense($gcp_pbf->getGcp_compense() + $gcp_pbf->getSolde_gcp())
                                        ->setSolde_gcp_reel(0)
                                        ->setSolde_gcp(0);
                                $m_gcp_pbf->update($gcp_pbf);
                                $montant = $montant - $gcp_pbf->getSolde_gcp();
                            }
                            //Mise à jour des détails gcp pbf
                            $detail = new Application_Model_EuDetailGcpPbf();
                            $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
                            $tcgcp = new Application_Model_DbTable_EuGcpPbfCompense();
                            $cgcp = new Application_Model_EuGcpPbfCompense();
                            $select = $t_detail->select();
                            $select->where('code_gcp_pbf = ?', $gcp_pbf->getCode_gcp_pbf())
                                    ->where('solde_gcp_pbf > 0');
                            $ce_results = $t_detail->fetchAll($select);
                            if (count($ce_results) > 0) {
                                foreach ($ce_results as $value) {
                                    $detail->exchangeArray($value);
                                    if ($detail->getSolde_gcp_pbf() < $mont_a_deduire) {
                                        $mont_a_deduire = $mont_a_deduire - $detail->getSolde_gcp_pbf();

                                        $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                             ->setCode_compte($num_compte)
                                             ->setMont_gcp_entree($detail->getSolde_gcp_pbf())
                                             ->setType_capa_gcp($detail->getType_capa())
                                             ->setSolde_compens($detail->getSolde_gcp_pbf())
                                             ->setId_compens(null);
                                        $tcgcp->insert($cgcp->toArray());

                                        $detail->setMont_preleve($detail->getMont_preleve() + $detail->getSolde_gcp_pbf())
                                               ->setSolde_gcp_pbf(0);
                                        $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));
                                    } else {
                                        $detail->setMont_preleve($detail->getMont_preleve() + $mont_a_deduire)
                                               ->setSolde_gcp_pbf(0);
                                        $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));

                                        $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                             ->setCode_compte($num_compte)
                                             ->setMont_gcp_entree($mont_a_deduire)
                                             ->setType_capa_gcp($detail->getType_capa())
                                             ->setSolde_compens($mont_a_deduire)
                                             ->setId_compens(null);
                                        $tcgcp->insert($cgcp->toArray());
                                        $mont_a_deduire = 0;
                                    }
                                    if ($mont_a_deduire == 0) {
                                        break;
                                    }
                                }
                            }
                            if ($montant == 0) {
                                //Mise à jour du gcp
                                $compte_gcp->setSolde($compte_gcp->getSolde() - $mont_gcp_pbf);
                                $cm_mapper->update($compte_gcp);
                                break;
                            }
                        }
                    }
                    $db->commit();
                    $this->view->data = true;
                    return;
                }
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->data = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
        }
    }


	
	
	
	
	
	
	
	
    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        //$type_membre = $_GET['type_membre'];
        if (substr($num_membre, 19, 1) == 'P') {
            $membre_db = new Application_Model_DbTable_EuMembre();
            $membre_find = $membre_db->find($num_membre);
            if (count($membre_find) == 1) {
                $result = $membre_find->current();
                //$data[0] = strtoupper($result->nom_membre);
                $data[1] = strtoupper($result->nom_membre)." ".ucfirst($result->prenom_membre);
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


	
	
	
	
	
	// fonction de recuperation des nom , prenom et raison sociale à partir du code membre
    public function recupnomraAction() {
        $num_membre = filter_input(input_get, "num_membre");
        if (isset($num_membre) && (substr($num_membre, -1, 1) === 'P')) {
            $membre_db = new Application_Model_DbTable_EuMembre();
            $membre_find = $membre_db->find($num_membre);
            if (count($membre_find) == 1) {
                $result = $membre_find->current();
                $data[0] = strtoupper($result->nom_membre);
                $data[1] = ucfirst($result->prenom_membre);
            } else {
                $data = '';
            }
        } else if (isset($num_membre)) {
            $moral_db = new Application_Model_DbTable_EuMembreMorale();
            $membre_find = $moral_db->find($num_membre);
            if (count($membre_find) == 1) {
                $result = $membre_find->current();
                $data[0] = $result->raison_sociale;
            } else {
                $data = '';
            }
        }

        $this->view->data = $data;
    }

	
	
	

    public function cacbAction() {
        $request = $this->getRequest();
        $type = $request->type;
        $this->view->type = $type;
    }


    public function cscoeAction() {
        $request = $this->getRequest();
        $type = $request->type;
        $this->view->type = $type;
        $this->view->produit = 'I';
    }

	
	
	
	
    // fonction permettant de faire ressortir le partage bnp
    public function bnpAction() {
		$this->_helper->layout->disableLayout();
		$user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_bnp');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuBnp();
        $apporteur = $this->_request->getParam('apporteur');
        $beneficiaire = $this->_request->getParam('benef');
        $type_bnp = $this->_request->getParam('type_bnp');
        $date = $this->_request->getParam('date');
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_operation', 'eu_bnp.id_operation = eu_operation.id_operation', array('date_op'));
		$select->where('eu_operation.id_utilisateur = ?',$user->id_utilisateur);
		
        if ($apporteur != '' or $apporteur != null) {
           $select->where('code_membre_app = ?', $apporteur);
        }
        if ($beneficiaire != '' or $beneficiaire != null) {
           $select->where('code_membre_benef = ?', $beneficiaire);
        }
        if ($date != '' or $date != null) {
		   $date1 = explode("/", $date);
           $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
           $select->where('date_op = ?', $dated);
        }
        if ($type_bnp != '' or $type_bnp != null) {
           $select->where('code_type_bnp = ?', $type_bnp);
        }
		
        $select->order('code_type_bnp', 'asc');
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
            $date_op = new Zend_Date($row->date_op, 'dd/mm:yy');
            $responce['rows'][$i]['id'] = $row->code_bnp;
            $responce['rows'][$i]['cell'] = array(
                $row->code_bnp,
                $row->code_type_bnp,
                $row->code_membre_app,
                $row->code_membre_benef,
                $row->montant_bnp,
                $row->mont_credit,
                $row->mont_conus,
                $row->mont_par,
                $row->mont_panu,
                $row->periode
            );
            $i++;
        }
        $this->view->data = $responce;
    }


	
    public function bnpcapsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_caps');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCaps();
        $apporteur = $this->_request->getParam('apporteur');
        $beneficiaire = $this->_request->getParam('benef');
        $date = $this->_request->getParam('date');
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_operation', 'eu_caps.id_operation = eu_operation.id_operation', array('date_op'));
        if ($apporteur != '' or $apporteur != null) {
		    $type_membre = substr($apporteur,19,1);
			if($type_membre == 'P') {
              $select->where('eu_caps.code_membre_app = ?', $apporteur);
			} else {
			  $select->where('eu_caps.code_membre_morale_app = ?', $apporteur);
			}  
        }
        if ($beneficiaire != '' or $beneficiaire != null) {
            $select->where('eu_caps.code_membre_benef = ?', $beneficiaire);
        }
        if ($date != '' or $date != null) {
            $date_op = Util_Utils::convertDated($date, '/');
            $select->where('eu_operation.date_op = ?', new Zend_Db_Expr("date '$date_op'"));
        }
        $select->where('eu_caps.code_type_bnp = ?', 'caps')
                ->order('eu_caps.code_type_bnp', 'asc')
                ->order('eu_operation.date_op', 'asc');
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
            $date_op = new Zend_Date($row->date_op, 'dd/mm/yy');
			$type_membre = substr($row->code_membre_app,19,1);
			if($type_membre == 'p') {
			   $apporteur = $row->code_membre_app;
			} else{
			   $apporteur = $row->code_membre_morale_app;
			}
            $responce['rows'][$i]['id'] = $row->code_caps;
            $responce['rows'][$i]['cell'] = array(
                $row->code_caps,
                $row->code_type_bnp,
                $apporteur,
                $row->code_membre_benef,
                $row->mont_caps,
                $row->mont_fs,
                $row->mont_panu_fs,
                $row->periode,
                $date_op->toString("dd/mm/yyyy")
            );
            $i++;
        }
        $this->view->data = $responce;
    }


    public function comptesAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCompteCredit();
        $code = $this->_request->getParam('code');
        $select = $tabela->select();
        $select->from($tabela, array('id_credit', 'code_membre', 'code_produit', 'montant_place', 'montant_credit', 'code_compte'));
        $select->where('code_bnp = ?', $code);
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

    public function changeAction() {
        if ($_GET['cat'] != '') {
            $var = $_GET['cat'];
            $data = array();
            $produit = new Application_Model_DbTable_EuProduit();
            $code = 'tpagc' . $var;
            $result = $produit->fetchAll($produit->select()->where('code_categorie = ?', $code));
            foreach ($result as $p) {
                $data[] = $p->code_produit;
            }
            $this->view->data = $data;
        }
    }

    public function bnpchangeAction() {
        $var = $_GET['bnp'];
        $data = array();
        $m = new Application_Model_EuMembreMapper();
        if ($var !== 'cscoe' and $var !== 'cacb') {
            $rows = $m->fetchAllByType('P');
            foreach ($rows as $c) {
                $data[] = $c->num_membre;
            }
        } elseif ($var === 'cscoe') {
            $rows = $m->fetchAllByType('M');
            foreach ($rows as $c) {
                $data[] = $c->num_membre;
            }
        } else {
            $rows = $m->fetchAll();
            foreach ($rows as $c) {
                $data[] = $c->num_membre;
            }
        }
        $this->view->data = $data;
    }

    public function typechangeAction() {
        $var = $_GET['bnp'];
        $data = array('');
        $m = new Application_Model_DbTable_Categorie();
        $select = $m->select();
        if ($var !== 'cscoe' and $var !== 'cacb') {
            $select->where('code_categorie = ?', 'RPG');
            $rows = $m->fetchAll($select);
            foreach ($rows as $c) {
                $data[] = $c->code_categorie;
            }
        } elseif ($var === 'cscoe') {
            $select->where('code_categorie = ?', 'i');
            $rows = $m->fetchAll($select);
            foreach ($rows as $c) {
                $data[] = $c->code_categorie;
            }
        } elseif ($var == 'cacb') {
            $select->where('code_categorie in (?)', array('I', 'RPG'));
            $rows = $m->fetchAll($select);
            foreach ($rows as $c) {
                $data[] = $c->code_categorie;
            }
        }
        $this->view->data = $data;
    }

    public function calculAction() {
        $cat = $_GET['cat'];
        if ($cat != '') {
            $compte = $_GET['compte'];
            $prk = Util_Utils::getParametre('prk', $compte);
            $pck = Util_Utils::getParametre('pck', $compte);
            $pre = $_GET['is_pre'];
            if ($compte == 'nr' && $pre) {
                $mont_invest = $_GET['mont_invest'];
                $duree = $_GET['duree'];
                $data = $mont_invest / $duree;
            } else {
                if ($_GET['montant'] != '') {
                    $mont = $_GET['montant'];
                    $data = ($mont * $prk) / $pck;
                } else {
                    $credit = $_GET['credit'];
                    $data = ($credit * $pck) / $prk;
                }
            }
        }
        $this->view->data = floor($data);
    }

    public function calcAction() {
        $cat = $_GET['cat'];
        if ($cat != '') {
            $prk = Util_Utils::getParametre('prk', $cat);
            $pck = Util_Utils::getParametre('pck', $cat);
            if ($_GET['montant'] != '') {
                $mont = $_GET['montant'];
                $data = ($mont * $prk) / $pck;
            } else {
                $credit = $_GET['credit'];
                $data = ($credit * $pck) / $prk;
            }
        }
        $this->view->data = floor($data);
    }

	
	public function souscriptionAction() {
	    $code = $_GET['code'];
		if ($code != '')  {
	        $data = array();
		    $tmtc = new Application_Model_DbTable_EuMembretierscode();
		    $select = $tmtc->select();
            $select->where('membretierscode_code = ?', $code)
			       ->where('publier = ?',0);
		    $results = $tmtc->fetchAll($select);
			if (count($results) > 0) {
			    $data[6] = $results->current()->membretierscode_id;
			    if(isset($results->current()->membretierscode_membretiers) &&
				(($results->current()->membretierscode_membretiers != NULL) || ($results->current()->membretierscode_membretiers != 0))) {
	                $id_mtiers = $results->current()->membretierscode_membretiers;
                    $tmt = new Application_Model_DbTable_EuMembretiers();
		            $selection = $tmt->select();
                    $selection->where('membretiers_id = ?',$id_mtiers);
			        $result = $tmt->fetchAll($selection);
				    if (count($result) > 0) {
				      $data[0] = $result->current()->membretiers_nom;
					  $data[1] = $result->current()->membretiers_prenom;
					  $data[2] = $result->current()->membretiers_mobile;
					  $data[3] = $result->current()->membretiers_email;
					  $data[4] = $result->current()->membretiers_quartier;
					  $data[5] = $result->current()->membretiers_ville;
				    } else {
                      $data = 0;
                    }
				}
	
	        } else {
                $data = 0;
            }
	    } 
		$this->view->data = $data;
	}
	
	
    public function codesmsAction() {
		$type_bnp = "";
		$code = $_GET['code'];
		$cat  = $_GET['cat'];
		if(isset($_GET['type_bnp'])) { 
		  $type_bnp = $_GET['type_bnp']; 
		}
		
        if ($code != '')  {
            $data = array();
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('creditcode = ?', $code)
                   ->where('iddatetimeconsumed = ?', 0);
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $mont_capa = $results->current()->creditamount;
                $data[0] = $mont_capa;
                if ($cat != '') {
                   $prk = Util_Utils::getParametre('prk', $cat);
                   $pck = floatval(str_replace(',', '.', Util_Utils::getParametre('pck', $cat)));
                   $credit = floor(($mont_capa * $prk) / $pck);
                   $data[1] = $credit;
                }
                $data[2] = $results->current()->currencycode;
				$t_map = new Application_Model_EuTypeBnpMapper();           
                $tbnp = new Application_Model_EuTypeBnp();
				
				if($type_bnp != '')  {
                   $t_map->find($type_bnp,$tbnp);
				   $conus = floor(($credit * $tbnp->getTx_conus())/100);
				   $data[3] = $conus; 
				}		
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
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

	
    public function smsAction() {
        //$code = filter_input(input_get, "code");
		$code = $_GET['code'];
        if ($code != '') {
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where("creditcode like ? ", $code)
                    //->where("destaccount_consumed is null")
					->where('iddatetimeconsumed = ?', 0);
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $data[0] = $results->current()->creditamount;
                $data[1] = $results->current()->currencycode;
            } else {
                $data[0] = "Ce code $code est invalide !!!";
            }
        }
        $this->view->data = $data;
        //$this->view->data = $select->__toString();
    }

	
    public function convertirAction() {
        $cat = $_GET['cat'];
        if ($cat != '') {
            $prk = Util_Utils::getParametre('prk', $cat);
            $pck = Util_Utils::getParametre('pck', $cat);
            $dev = $_GET['dev'];
            $dev1 = $_GET['dev1'];
            if ($dev != $dev1) {
                if ($dev != $dev1) {
                    $code_cours = $dev . '-' . $dev1;
                    $cours = new Application_Model_EuCours();
                    $m_cours = new Application_Model_EuCoursMapper();
                    $ret = $m_cours->find($code_cours, $cours);
                    if ($ret) {
                        $mont_capa = $_GET['montant'];
                        $mont_credit = $_GET['credit'];
                        if ($mont_capa != '') {
                            $montant = $mont_capa * $cours->getVal_dev_fin();
                            $data[0] = $montant;
                            $data[1] = ($montant * $prk) / $pck;
                        } elseif ($mont_credit != '') {
                            $credit = $mont_credit * $cours->getVal_dev_fin();
                            $montant = ($credit * $pck) / $prk;
                            $data[0] = $montant;
                            $data[1] = $credit;
                        }
                    } else {
                        $data = false;
                    }
                }
            }
        }
        $this->view->data = $data;
    }



    public function newtypeAction() {
        $request = $this->getRequest();
        $form = new Application_Form_EuBnp();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        try {
            if ($request->type != null) {
                $form->getElement('type_bnp')->setValue($request->type)->setAttrib('readonly', 'true');
                if ($request->type != 'CSCOE' && $request->type != 'CACB') {
                    $form->getElement('produit')->setMultiOptions(array('RPG' => 'RPG'));
                    $form->getElement('categorie')->setMultiOptions(array('r' => 'Recurrent'));
                    if ($request->type == 'CAPU') {
                        $form->getElement('type_nn')->setMultiOptions(array('CAPU' => 'CAPU'));
                    } else {
                        if ($request->type == 'CAIPC') {
                            $form->getElement('type_nn')->setMultiOptions(array('CAIPC' => 'CAIPC'));
                        } else {
                            $form->getElement('type_nn')->setMultiOptions(array('CMIT' => 'CMIT', 'GCP' => 'GCP'));
                        }
                    }
                }
                $this->view->type = $request->type;
				$this->view->code_membre_benef = $user->code_membre;
            }
        } catch (Exception $e) {
            $message = "Erreur d\'éxécution : " . $e->getMessage() . $e->getTraceAsString();
            $this->view->message = $message;
            $this->view->form = $form;
            return;
        }
		
        if ($this->getRequest()->isPost()) {
		    if ($form->isValid($request->getPost())) {
		        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
                $date = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = $date;
                $date_fin = clone $date;
                $categorie = $form->getValue('categorie');
                $type_bnp = $form->getValue('type_bnp');
                $produit = $form->getValue('produit');
                $code_bnp = $type_bnp . $date_deb->toString('yyyyMMddHHmmss');
                $code_sqmax = 'SQMAX' . $date_deb->toString('yyyyMMddHHmmss');
			    $krr = new Application_Model_EuKrr();
                $mkrr = new Application_Model_EuKrrMapper();
				
				$dkrr = new Application_Model_EuDetailKrr();
                $mdkrr = new Application_Model_EuDetailKrrMapper();
			
                $beneficiaire = $_POST['code_membre_benef'];
                $montant = $form->getValue('montant');
                $credit = $form->getValue('credit');
                $code_dev = $form->getValue('code_dev');
                $code_sms = $form->getValue('code_sms');
                $code_produit = $produit . $categorie;
                $code_cat = 'TPAGC' . $produit;
			    $code_catts = 'TS' . $produit;
                $apporteur = $_POST['code_membre_app'];
                $mode_finance = $form->getValue('mode_fin');
                $type_nn = '';
                if ($mode_finance == 'NN') {
                   $type_nn = $form->getValue('type_nn');
                }
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			
			try {
			    $statut_beneficiaire = 'O';
				
                //vérification de l'existence du membre apporteur
                $moral = new Application_Model_EuMembreMorale();
                $membre = new Application_Model_EuMembre();
                $ret = false;
                if (Util_Utils::getmembreType($apporteur) === 'M') {
                    $ret = Util_Utils::getMembreMorale($apporteur, $moral);
                } else {
                    $ret = Util_Utils::getMembre($apporteur, $membre);
                }
                if (!$ret) {
                    $this->view->message = "Le membre apporteur n'existe pas";
                    $this->view->code_membre_app = $apporteur;
                    $this->view->code_membre_benef = $beneficiaire;
                    $this->view->type_bnp = $type_bnp;
                    $form->getElement('cancel')->setAttrib('onclick', "window.open('".$this->view->url(array('controller' => 'eu-bnp','action' => 'index'), 'default', true)."','_self')");
                    $this->view->form = $form;
                    return;
                }
				
				// verification du membre apporteur pbf
				if (($type_bnp == 'CMIT') || ($type_bnp == 'CMITNRPREKITTEC')) {
                        if (Util_Utils::getmembreType($apporteur) === 'M') {
                            $t_acteur = new Application_Model_DbTable_EuActeur();
                            $select = $t_acteur->select();
                            $select->where('code_membre = ?', $moral->getCode_membre_morale())
                                   ->where('type_acteur = ?', 'PBF');
                            $results = $t_acteur->fetchAll($select);
                            if (count($results) == 0) {
                                $this->view->message = "Le membre apporteur $moral->code_membre_morale doit être un pbf !!!";
                                $this->view->code_membre_app = $apporteur;
                                $this->view->code_membre_benef = $beneficiaire;
                                $this->view->type_bnp = $type_bnp;
                                $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                                        $this->view->url(array(
                                            'controller' => 'eu-bnp',
                                            'action' => 'index'
                                                ), 'default', true) .
                                        "','_self')");
                                $this->view->form = $form;
                                return;
                            }
                        }
                }
				
				    //vérification de l'existence du membre bénéficiaire
                    $ret_b = Util_Utils::getMembre($beneficiaire, $membre);
                    if ($ret_b) {
                        $statut_beneficiaire = $membre->getAuto_enroler();
                    } else {
                        $this->view->message = "Le membre bénéficiaire n'existe pas";
                        $this->view->code_membre_app = $apporteur;
                        $this->view->code_membre_benef = $beneficiaire;
                        $this->view->type_bnp = $type_bnp;
                        $form->getElement('cancel')->setAttrib('onclick', "window.open('".$this->view->url(array('controller' => 'eu-bnp','action' => 'index'), 'default', true) ."','_self')");
                        $this->view->form = $form;
                        return;
                    }
					//Vérification du produit
                    $prod = new Application_Model_EuProduit();
                    $p_mapper = new Application_Model_EuProduitMapper();
                    $p_result = $p_mapper->find($code_produit,$prod);
                    if (!$p_result) {
                        $this->view->message = "Ce produit n'existe pas";
                        $this->view->code_membre_app = $apporteur;
                        $this->view->code_membre_benef = $beneficiaire;
                        $this->view->type_bnp = $type_bnp;
                        // Add the link to the cancel button
                        $form->getElement('cancel')->setAttrib('onclick', "window.open('".$this->view->url(array('controller' => 'eu-bnp','action' => 'index' ), 'default', true) ."','_self')");
                        $this->view->form = $form;
                        return;
                    }
					
					//Vérification du solde du Compte gcp si  le mode de financement est gcp pbf
                    $cm_mapper = new Application_Model_EuCompteMapper();
                    $sms = new Application_Model_EuSmsmoney();
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $ok = false;
                    $compte_gcp = new Application_Model_EuCompte();
					
					// traitement bnp si le mode de financement est de type numérique noir
					if ($mode_finance == 'NN') {
                        if ($type_nn === 'GCP') {
                            $code_compte_gcp = 'NN-TPAGCP-' . $apporteur;
                        } else {
                            $code_compte_gcp = 'NN-T' . $type_nn . '-' . $apporteur;
                        }
                        $ret_gcp = $cm_mapper->find($code_compte_gcp, $compte_gcp);
                        if (!$ret_gcp) {
                            $this->view->message = "Ce Compte gcp $code_compte_gcp n'existe pas!!!";
                            $this->view->code_membre_app = $apporteur;
                            $this->view->code_membre_benef = $beneficiaire;
                            $this->view->type_bnp = $type_bnp;
                            // Add the link to the cancel button
                            $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                                    $this->view->url(array(
                                        'controller' => 'eu-bnp',
                                        'action' => 'index'
                                            ), 'default', true) .
                                    "','_self')");
                            $this->view->form = $form;
                            return;
                        } else {
                            if ($compte_gcp->getSolde() < $montant) {
                                $this->view->message = "Le solde de ce Compte gcp $code_compte_gcp est insuffisant " . $compte_gcp->getSolde();
                                $this->view->code_membre_app = $apporteur;
                                $this->view->code_membre_benef = $beneficiaire;
                                $this->view->type_bnp = $type_bnp;
                                // Add the link to the cancel button
                                $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                                        $this->view->url(array(
                                            'controller' => 'eu-bnp',
                                            'action' => 'index'
                                                ), 'default', true) .
                                        "','_self')");
                                $this->view->form = $form;
                                return;
                            } else {
                                $ok = true;
                            }
                        }
                    }
					
					// traitement bnp si le mode de financement est de type sms c'est à dire numéraire
					elseif ($mode_finance == 'SMS') {
					    $sms = $sms_mapper->findByCreditCode($code_sms);
                        if ($sms != null) {
                            $montant = Util_Utils::verifierCodeSMS($sms);
                            if ($montant == 0) {
                                $db->rollback();
                                $this->view->message = "Erreur d'éxécution : Ce code sms $code_sms est invalide!!!";
                                $this->view->code_membre_app = $apporteur;
                                $this->view->code_membre_benef = $beneficiaire;
                                $this->view->type_bnp = $type_bnp;
                                $this->view->form = $form;
                                return;
                            } else
							if ($sms->getMotif() != $type_bnp) {
                                $db->rollback();
                                $this->view->message = "Erreur d'éxécution : Le motif pour lequel ce code est émis ne correspond pas à cette opération!!!";
                                $this->view->code_membre_app = $apporteur;
                                $this->view->code_membre_benef = $beneficiaire;
                                $this->view->type_bnp = $type_bnp;
                                $this->view->form = $form;
                                return;
                            } else {
                                $ok = true;
                            }
                        } else {
                            $db->rollback();
                            $this->view->message = "Erreur d'éxécution : Ce code sms $code_sms est invalide!!";
                            $this->view->code_membre_app = $apporteur;
                            $this->view->code_membre_benef = $beneficiaire;
                            $this->view->type_bnp = $type_bnp;
                            $this->view->form = $form;
                            return;
                        }
			
			        }
					if ($ok) {
					
					    // insertion dans la table eu_operation
                        $mapper = new Application_Model_EuOperationMapper();
                        $count = $mapper->findConuter() + 1;
                        $operation = new Application_Model_EuOperation();
                        $operation->setId_operation($count)
                                  ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                  ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                  ->setId_utilisateur($user->id_utilisateur)
                                  ->setCode_membre($beneficiaire)
                                  ->setMontant_op($montant)
                                  ->setCode_produit($code_produit)
                                  ->setLib_op("Achat du pouvoir d'achat RPG")
                                  ->setType_op($type_bnp)
                                  ->setCode_cat($code_cat);
                        $mapper->save($operation);
						
						//vérification des quotas
                        $tparam = new Application_Model_DbTable_EuParametres();
                        $m_sqmaxui = new Application_Model_EuBnpSqmaxMapper();
                        $sqmax = 0;
                        $somme = 0;
                        $mont_place = $montant;

                        $m_capa = new Application_Model_EuCapaMapper();
                        $m_credit = new Application_Model_EuCompteCreditMapper();
						
						if (($type_bnp != 'CMITNRPREKITTEC') && ($type_bnp != 'CAPUNRPREKITTEC') && ($type_bnp != 'CAIPCNRPREKITTEC')) {
						    
							if ($code_produit == 'RPGr') {
                                $rows_quota = $tparam->find('quota', 'RPGr');
                                if (count($rows_quota) > 0) {
                                    $param = $rows_quota->current();
                                    $quota = $param->montant;
                                    //$somme = $m_capa->getSumQuotaRPG($beneficiaire,$categorie,$produit);
                                    $somme = $m_credit->getSumQuotaRPG($beneficiaire, $code_produit);
                                    $reste = $quota - $somme;
                                    if ($reste <= 0) {
                                        $db->rollback();
                                        $this->view->message = "Erreur d'éxécution : Le quota sqmax pour ce membre beneficiaire $beneficiaire a dejà atteint !!";
                                        $this->view->code_membre_app = $apporteur;
                                        $this->view->code_membre_benef = $beneficiaire;
                                        $this->view->type_bnp = $type_bnp;
                                        $this->view->form = $form;
                                        return;	
                                    } elseif ($reste > 0) {
									
                                        if ($mont_place > $reste) {
										
                                            // Calcul du credit
                                            $prk = Util_Utils::getParametre('prk', $categorie);
                                            $pck = Util_Utils::getParametre('pck', $categorie);

                                            $num_compte = 'NB-' . $code_cat . '-' . $beneficiaire;
											//$num_comptets = 'NB-' . $code_catts . '-' . $beneficiaire;
                                            $code_capa = 'CAPA' . $produit . $date_deb->toString('yyyyMMddHHmmss');

                                            $sqmax = $mont_place - $reste;
                                            $creditsqmax = round(($sqmax * $prk) / $pck) / 4;
                                            $mont_place = $reste;

											// insertion dans la table eu_operation
                                            $countsqmax = $mapper->findConuter() + 1;
                                            $operation = new Application_Model_EuOperation();
                                            $operation->setId_operation($countsqmax)
                                                    ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                                    ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                                    ->setId_utilisateur($user->id_utilisateur)
                                                    ->setCode_membre($beneficiaire)
                                                    ->setMontant_op($sqmax)
                                                    ->setCode_produit($code_produit)
                                                    ->setLib_op("Achat du pouvoir d'achat RPG")
                                                    ->setType_op($type_bnp)
                                                    ->setCode_cat($code_cat);
                                            $mapper->save($operation);

                                            // Envoi du credit sqmax sur le compte credit du beneficiaire
                                            $cc_mapper = new Application_Model_EuCompteCreditMapper();
                                            $periode = 30;
                                            $prows = $tparam->find('periode', 'valeur');
                                            if (count($prows) > 0) {
                                               $periode = $prows->current()->montant;
                                            }
                                            $date_fin->addDay($periode);
                                            $maxccsqmax = $cc_mapper->findConuter() + 1;

											// insertion dans la table eu_compte_credit
                                            $source = $beneficiaire . $date_deb->toString('yyyyMMddHHmmss');
                                            Util_Utils::createCompteCredit($maxccsqmax, 0, $countsqmax, $beneficiaire, $code_produit, $num_compte, $creditsqmax, $sqmax,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,'SQMAXUI','N','O',0,1,$code_bnp,'CNPG',$prk,0);

                                            $sqmaxui = new Application_Model_EuBnpSqmax();

											// insertion dans la table eu_bnp_sqmax
                                            $maxidsqmax = $m_sqmaxui->findConuter() + 1;
                                            $sqmaxui->setId_sqmax($maxidsqmax);
                                            $sqmaxui->setCode_cat($code_cat);
                                            $sqmaxui->setCode_membre($beneficiaire);
                                            $sqmaxui->setMontant($sqmax);
                                            $sqmaxui->setId_credit($maxccsqmax);
                                            $m_sqmaxui->save($sqmaxui);

                                            //Enregistrement du capa et du crédit sqmax sur le compte marchand beneficiaire
                                            $cm = new Application_Model_EuCompte();
                                            $res_cm = $cm_mapper->find($num_compte,$cm);
											//$res_cmts = $cm_mapper->find($num_comptets,$cm);
                                            if ($res_cm == false) {
                                                $cm->setCode_membre($beneficiaire)
                                                   ->setCode_cat($code_cat)
                                                   ->setSolde($creditsqmax)
                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                   ->setCode_compte($num_compte)
                                                   ->setLib_compte($code_cat)
                                                        //->setSource($code_bnp)
                                                   ->setCode_type_compte('NB')
                                                   ->setDesactiver(0);
                                                $cm_mapper->save($cm);
                                            } else {
                                                $cm->setSolde($cm->getSolde() + $creditsqmax);
                                                $cm_mapper->update($cm);
                                            }
											
											/*
											if ($res_cmts == false) {
                                                $cm->setCode_membre($beneficiaire)
                                                   ->setCode_cat($code_catts)
                                                   ->setSolde(0)
                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                   ->setCode_compte($num_compte)
                                                   ->setLib_compte($code_catts)
                                                        //->setSource($code_bnp)
                                                   ->setCode_type_compte('NB')
                                                   ->setDesactiver(0);
                                                $cm_mapper->save($cm);
                                            }*/
											

                                            // insertion dans la table eu_cnp
                                            $m_cnp = new Application_Model_EuCnpMapper();
                                            $cnp = new Application_Model_EuCnp();
                                            $maxcnpsqmax = $m_cnp->findConuter() + 1;
                                            $cnp->setId_cnp($maxcnpsqmax)
                                                    ->setId_credit($maxccsqmax)
                                                    ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                                    ->setMont_debit($credisqmax)
                                                    ->setMont_credit(0)
                                                    ->setSolde_cnp($creditsqmax)
                                                    ->setType_cnp($code_produit)
                                                    ->setSource_credit($source)
                                                    ->setOrigine_cnp('RPGr')
                                                    ->setTransfert_gcp(0);
                                            $m_cnp->save($cnp);

                                            $fn = new Application_Model_EuFn();
                                            $m_fn = new Application_Model_EuFnMapper();
                                            $capa = new Application_Model_EuCapa();
                                            $m_capa = new Application_Model_EuCapaMapper();
                                             
											// insertion dans la table eu_capa
                                            $capa->setCode_capa($code_capa)
                                                 ->setCode_compte('NN-CAPA-'.$beneficiaire)
                                                 ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
                                                 ->setHeure_capa($date_deb->toString('HH:mm:ss'))
                                                 ->setCode_membre($beneficiaire)
                                                 ->setMontant_capa($sqmax)
                                                 ->setMontant_utiliser($sqmax)
                                                 ->setMontant_solde(0)
                                                 ->setId_operation($countsqmax)
                                                 ->setType_capa($type_bnp)
                                                 ->setEtat_capa('Actif')
												 ->setCode_produit($code_produit)
                                                 ->setOrigine_capa('SMS');
                                            $m_capa->save($capa);

											// insertion dans la table eu_compte_credit_capa
                                            $m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                                            $credit_capa = new Application_Model_EuCompteCreditCapa();
                                            $credit_capa->setCode_capa($code_capa)
                                                        ->setCode_produit($code_produit)
                                                        ->setId_credit($maxccsqmax)
                                                        ->setMontant($sqmax);
                                            $m_credit_capa->save($credit_capa);

                                            // insertion dans la table eu_fn
                                            $maxfnsqmax = $m_fn->findConuter() + 1;
                                            $fn->setId_fn($maxfnsqmax)
                                               ->setCode_capa($code_capa)
                                               ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
                                               ->setType_fn('Ir')
                                               ->setMontant($sqmax)
                                               ->setSortie(0)
                                               ->setEntree(0)
                                               ->setSolde(0)
                                               ->setOrigine_fn(0)
                                               ->setMt_solde($sqmax);
                                            $m_fn->save($fn);
                                        }
                                    }
                                }
                            }
						
						}
						
						if ($mont_place > 0)   {
						    // Calcul du credit
                            $prk = Util_Utils::getParametre('prk', $categorie);
                            $pck = Util_Utils::getParametre('pck', $categorie);
                            $credit = round($mont_place * $prk / $pck);
                            $par = 0;
                            $panu = 0;
                            $fs = 0;
                            $panu_fs = 0;
							
							// Partage du credit selon le type du bnp
							$valeurcaps = Util_Utils::getParametre('CAPS','valeur');
							//$proportion = $valeurcaps/22.4;
                            $t_map = new Application_Model_EuTypeBnpMapper();
                            $m_bnp = new Application_Model_EuBnpMapper();
                            $m_caps = new Application_Model_EuCapsMapper();
                            $tbnp = new Application_Model_EuTypeBnp();
                            $caps = new Application_Model_EuCaps();
                            $t_map->find($type_bnp, $tbnp);
                            $indexer = false;
                            //$conus = round($credit * $tbnp->getTx_conus() / 100);
                            if ($statut_beneficiaire == 'O') {
                                if (($type_bnp == 'CAIPC') || ($type_bnp == 'CAIPCNRPREKITTEC')) {
                                   $par = round($credit * ($tbnp->getTx_par()) / 100);
								   $conus = round($credit * ($tbnp->getTx_conus() + $tbnp->getTx_fs()) / 100);
                                } else {
                                   $par = round(($credit * $tbnp->getTx_par()) / 100);
                                   $panu = round(($credit * ($tbnp->getTx_panu() + $tbnp->getTx_fs())) / 100);
								   $conus = round($credit * $tbnp->getTx_conus() / 100);
                                }
                            } elseif ($statut_beneficiaire == 'N') {
                                $caps = $m_caps->fetchCapsByBeneficiaire($beneficiaire);
                                if ($caps != null && $caps->getIndexer() == 0) {
                                    $indexer = true;
                                    if (($type_bnp == 'CAIPC') || ($type_bnp == 'CAIPCNRPREKITTEC')) {
									    $conus = round($credit * $tbnp->getTx_conus() / 100);
                                        $par = round(($credit * $tbnp->getTx_par()) / 100);
                                        $fs = round(($credit * $tbnp->getTx_fs()) / 100);
                                        $panu_fs = round(($credit * $tbnp->getTx_panu_fs()) / 100);
                                    } else {
									    $conus = round($credit * $tbnp->getTx_conus() / 100);
                                        $par = round(($credit * $tbnp->getTx_par()) / 100);
                                        $panu = round(($credit * $tbnp->getTx_panu() ) / 100);
                                        $fs = round(($credit * $tbnp->getTx_fs()) / 100);
                                        $panu_fs = round(($credit * $tbnp->getTx_panu_fs()) / 100);
                                    }
                                } else {
                                    if (($type_bnp == 'CAIPC') || ($type_bnp == 'CAIPCNRPREKITTEC')) {
									   $conus = round($credit * ($tbnp->getTx_conus() + $tbnp->getTx_fs()) / 100);
                                       $par = round($credit * ($tbnp->getTx_par() + $tbnp->getTx_fs()) / 100);
                                    } else {
									   $conus = round($credit * $tbnp->getTx_conus() / 100);
                                       $par = round(($credit * $tbnp->getTx_par()) / 100);
                                       $panu = round(($credit * ($tbnp->getTx_panu() + $tbnp->getTx_fs())) / 100);
                                    }
                                }
                            }
							
							
							$num_compte = 'NB-' . $code_cat . '-' . $beneficiaire;
							//$num_comptets = 'NB-' . $code_catts . '-' . $beneficiaire;
                            $code_capa = 'CAPA' . $produit . $date_deb->toString('yyyyMMddHHmmss');
                            //Enregistrement du capa et du conus sur le compte marchand beneficiaire
                            $cm = new Application_Model_EuCompte();
                            $res_cm = $cm_mapper->find($num_compte,$cm);
							//$res_cmts = $cm_mapper->find($num_comptets,$cm);
                            if ($res_cm == false) {
							    // insertion dans la table eu_compte
                                $cm->setCode_membre($beneficiaire)
                                        ->setCode_cat($operation->getCode_cat())
                                        ->setSolde($conus)
                                        ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                        ->setCode_compte($num_compte)
                                        ->setLib_compte($code_cat)
                                        //->setSource($code_bnp)
                                        ->setCode_type_compte('NB')
                                        ->setDesactiver(0);
                                $cm_mapper->save($cm);
                            } else {
                                $cm->setSolde($cm->getSolde() + $conus);
                                $cm_mapper->update($cm);
                            }
							
							/*if ($res_cmts == false) {
							    // insertion dans la table eu_compte
                                $cm->setCode_membre($beneficiaire)
                                        ->setCode_cat($code_catts)
                                        ->setSolde(0)
                                        ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                        ->setCode_compte($num_comptets)
                                        ->setLib_compte($code_catts)
                                        //->setSource($code_bnp)
                                        ->setCode_type_compte('NB')
                                        ->setDesactiver(0);
                                $cm_mapper->save($cm);
                            }*/
							
							

                            // insertion dans la table eu_bnp
                            $bnp = new Application_Model_EuBnp();
                            $bnp->setCode_bnp($code_bnp)
                                ->setCode_membre_app($apporteur)
                                ->setCode_membre_benef($beneficiaire)
                                ->setMontant_bnp($montant)
                                ->setCode_type_bnp($type_bnp)
                                ->setId_operation($count)
                                ->setRembourser('N')
                                ->setMont_conus($conus)
                                ->setMont_par($par)
                                ->setMont_panu($panu)
								->setConus($conus)
								->setPanu($panu)
                                ->setPeriode(1)
                                ->setMont_credit($credit);
							if($_POST["cat_bnp"] == "bnps") {		
							  $bnp->setNature_bnp("BNP");
                            } else {
                              $bnp->setNature_bnp("BNPP");
							}		
                            $m_bnp->save($bnp);


                            // Envoi du ConuS sur le compte credit du beneficiaire
                            $cc_mapper = new Application_Model_EuCompteCreditMapper();
                            $periode = 30;
                            $prows = $tparam->find('periode', 'valeur');
                            if (count($prows) > 0) {
                               $periode = $prows->current()->montant;
                            }
							
							// insertion dans la table eu_compte_credit
                            $date_fin->addDay($periode);
                            $maxcc = $cc_mapper->findConuter() + 1;
                            $source = $beneficiaire . $date_deb->toString('yyyyMMddHHmmss');
                            Util_Utils::createCompteCredit($maxcc, 0, $count, $beneficiaire, $code_produit, $num_compte, $conus, $mont_place,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'), $source, $type_bnp, 'N', 'O', 0, 1,$code_bnp,'CNPG',$prk,0);
                            $credi = $conus;

                            // insertion dans la table eu_cnp
                            $m_cnp = new Application_Model_EuCnpMapper();
                            $cnp = new Application_Model_EuCnp();
                            $maxcnp = $m_cnp->findConuter() + 1;
                            $cnp->setId_cnp($maxcnp)
                                    ->setId_credit($maxcc)
                                    ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                    ->setMont_debit($conus)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($conus)
                                    ->setType_cnp($code_produit)
                                    ->setSource_credit($source)
                                    ->setOrigine_cnp('RPGr')
                                    ->setTransfert_gcp(0);
                            $m_cnp->save($cnp);

                            // Mise à jour des capa
                            $fn = new Application_Model_EuFn();
                            $m_fn = new Application_Model_EuFnMapper();
                            $capa = new Application_Model_EuCapa();
                            $m_capa = new Application_Model_EuCapaMapper();
							
							if ($mode_finance == 'SMS') {
							
							    // insertion dans la table eu_capa
                                $capa->setCode_capa($code_capa)
                                        ->setCode_compte('NN-CAPA-'.$beneficiaire)
                                        ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
                                        ->setHeure_capa($date_deb->toString('HH:mm:ss'))
                                        ->setCode_membre($beneficiaire)
                                        ->setMontant_capa($mont_place)
                                        ->setMontant_utiliser($mont_place)
                                        ->setMontant_solde(0)
                                        ->setId_operation($count)
                                        ->setType_capa($type_bnp)
                                        ->setEtat_capa('Actif')
										->setCode_produit($code_produit)
                                        ->setOrigine_capa('SMS');
                                $m_capa->save($capa);
								
								// insertion dans la table eu_compte_credit_capa
                                $m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                                $credit_capa = new Application_Model_EuCompteCreditCapa();
                                $credit_capa->setCode_capa($code_capa)
                                        ->setCode_produit($code_produit)
                                        ->setId_credit($maxcc)
                                        ->setMontant($mont_place);
                                $m_credit_capa->save($credit_capa);

                                // insertion dans la table eu_fn
                                $maxfn = $m_fn->findConuter() + 1;
                                $fn->setId_fn($maxfn)
                                        ->setCode_capa($code_capa)
                                        ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
                                        ->setType_fn('Ir')
                                        ->setMontant($mont_place)
                                        ->setSortie(0)
                                        ->setEntree(0)
                                        ->setSolde(0)
                                        ->setOrigine_fn(0)
                                        ->setMt_solde($mont_place);
                                $m_fn->save($fn);

								// Mise à jour de la table eu_smsmoney
                                $sms->setDestAccount_Consumed($num_compte)
                                    ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                    ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                $sms_mapper->update($sms);
								
							} else if ($mode_finance === 'NN' && $type_nn != 'GCP') {
                                $capas = $m_capa->fetchAllByMembre($apporteur);
                                if (count($capas) > 0) {
                                    $mont_deduit = 0;
                                    $i = 0;
                                    while ($mont_deduit < $mont_place) {
                                        $value = $capas[$i];
                                        if ($value->getMontant_solde() >= $mont_place) {
                                            $mont_deduit += $mont_place;

                                            // insertion dans la table eu_fn
                                            $fn->setCode_capa($value->getCode_capa())
                                                    ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
                                                    ->setType_fn('Ir')
                                                    ->setMontant($mont_place)
                                                    ->setSortie(0)
                                                    ->setEntree(0)
                                                    ->setSolde(0)
                                                    ->setOrigine_fn(0)
                                                    ->setMt_solde($mont_place);
                                            $m_fn->save($fn);

											// insertion dans la table eu_compte_credit_capa
                                            $m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                                            $credit_capa = new Application_Model_EuCompteCreditCapa();
                                            $credit_capa->setCode_capa($value->getCode_capa())
                                                    ->setCode_produit($operation->getCode_produit())
                                                    ->setId_credit($maxcc)
                                                    ->setMontant($mont_place);
                                            $m_credit_capa->save($credit_capa);

											
											// Mise à jour de la table eu_capa
                                            $value->setMontant_utiliser($value->getMontant_utiliser() + $mont_place)
                                                    ->setMontant_solde($value->getMontant_solde() - $mont_place);
                                            $m_capa->update($value);
                                        } else {
                                            $mont_deduit += $value->getMontant_solde();

                                            // insertion dans la table eu_fn
                                            $fn->setCode_capa($value->getCode_capa())
                                                    ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
                                                    ->setType_fn('Inr')
                                                    ->setMontant($value->getMontant_solde())
                                                    ->setSortie(0)
                                                    ->setEntree(0)
                                                    ->setSolde(0)
                                                    ->setOrigine_fn(0)
                                                    ->setMt_solde($value->getMontant_solde());
                                            $m_fn->save($fn);

											// insertion dans la table eu_compte_credit_capa
                                            $m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                                            $credit_capa = new Application_Model_EuCompteCreditCapa();
                                            $credit_capa->setCode_capa($value->getCode_capa())
                                                        ->setCode_produit($operation->getCode_produit())
                                                        ->setId_credit($maxcc)
                                                        ->setMontant($value->getMontant_solde());
                                            $m_credit_capa->save($credit_capa);

											// Mise à jour de la table eu_capa
                                            $value->setMontant_utiliser($value->getMontant_utiliser() + $value->getMontant_solde())
                                                    ->setMontant_solde(0);
                                            $m_capa->update($value);
                                        }
                                        $i++;
                                    }
                                    $compte_gcp->setSolde($compte_gcp->getSolde() - $mont_place);
                                    $cm_mapper->update($compte_gcp);
                                }
                            } else {
                                //Mise à jour du gcp pbf et ses détails
                                $mont_gcp_pbf = $montant;
                                $prk = ceil(Util_Utils::getParametre('prk', 'nr'));
                                $pck = Util_Utils::getParametre('pck', 'nr');
                                $agio_compens = $montant - round(($montant * $pck) / $prk);
                                $gcpr_compens = $montant - $agio_compens;
                                $m_gcp_pbf = new Application_Model_EuGcpPbfMapper();
                                $gcp_pbf = new Application_Model_EuGcpPbf();
                                $gcp_pbfs = $m_gcp_pbf->fetchAllByPbf($apporteur);
                                foreach ($gcp_pbfs as $gcp_pbf) {
                                    //Mise à jour du gcp pbf
                                    $mont_a_deduire = 0;
                                    if ($gcp_pbf->getSolde_gcp() > $montant) {
                                        $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $agio_compens)
                                                ->setSolde_agio($gcp_pbf->getSolde_agio() - $agio_compens)
                                                ->setGcp_compense($gcp_pbf->getGcp_compense() + $montant)
                                                ->setSolde_gcp_reel($gcp_pbf->getSolde_gcp_reel() - $gcpr_compens)
                                                ->setSolde_gcp($gcp_pbf->getSolde_gcp() - $montant);
                                        $m_gcp_pbf->update($gcp_pbf);
                                        $mont_a_deduire = $montant;
                                        $montant = 0;
                                    } else {
                                        $mont_a_deduire = $gcp_pbf->getSolde_gcp();
                                        $gcp_pbf->setAgio_consomme($gcp_pbf->getAgio_comsomme() + $gcp_pbf->getSolde_agio())
                                                ->setSolde_agio(0)
                                                ->setGcp_compense($gcp_pbf->getGcp_compense() + $gcp_pbf->getSolde_gcp())
                                                ->setSolde_gcp_reel(0)
                                                ->setSolde_gcp(0);
                                        $m_gcp_pbf->update($gcp_pbf);
                                        $montant = $montant - $gcp_pbf->getSolde_gcp();
                                    }
                                    //Mise à jour des détails gcp pbf
                                    $detail = new Application_Model_EuDetailGcpPbf();
                                    $t_detail = new Application_Model_DbTable_EuDetailGcpPbf();
                                    $tcgcp = new Application_Model_DbTable_EuGcpPbfCompense();
                                    $cgcp = new Application_Model_EuGcpPbfCompense();
                                    $select = $t_detail->select();
                                    $select->where('code_gcp_pbf = ?', $gcp_pbf->getCode_gcp_pbf())
                                            ->where('solde_gcp_pbf > 0');
                                    $ce_results = $t_detail->fetchAll($select);
                                    if (count($ce_results) > 0) {
                                        foreach ($ce_results as $value) {
                                            $detail->exchangeArray($value);
                                            if ($detail->getSolde_gcp_pbf() < $mont_a_deduire) {
                                                $mont_a_deduire = $mont_a_deduire - $detail->getSolde_gcp_pbf();

                                                $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                        ->setCode_compte($num_compte)
                                                        ->setMont_gcp_entree($detail->getSolde_gcp_pbf())
                                                        ->setType_capa_gcp($detail->getType_capa())
                                                        ->setSolde_compens($detail->getSolde_gcp_pbf())
                                                        ->setId_compens(null);
                                                $tcgcp->insert($cgcp->toArray());

                                                $detail->setMont_preleve($detail->getMont_preleve() + $detail->getSolde_gcp_pbf())
                                                        ->setSolde_gcp_pbf(0);
                                                $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));
                                            } else {
                                                $detail->setMont_preleve($detail->getMont_preleve() + $mont_a_deduire)
                                                        ->setSolde_gcp_pbf(0);
                                                $t_detail->update($detail->toArray(), array('id_gcp_pbf = ?' => $detail->getId_gcp_pbf()));

                                                $cgcp->setId_detail_gcppbf($detail->getId_gcp_pbf())
                                                        ->setCode_compte($num_compte)
                                                        ->setMont_gcp_entree($mont_a_deduire)
                                                        ->setType_capa_gcp($detail->getType_capa())
                                                        ->setSolde_compens($mont_a_deduire)
                                                        ->setId_compens(null);
                                                $tcgcp->insert($cgcp->toArray());
                                                $mont_a_deduire = 0;
                                            }
                                            if ($mont_a_deduire == 0) {
                                                break;
                                            }
                                        }
                                    }
                                    if ($montant == 0) {
                                        //Mise à jour du gcp
                                        $compte_gcp->setSolde($compte_gcp->getSolde() - $mont_gcp_pbf);
                                        $cm_mapper->update($compte_gcp);
                                        break;
                                    }
                                }
                            }
						}
						
						//Enregistrement du capa et de la PaR sur le compte marchand de l'apporteur
                        $compte_par = new Application_Model_EuCompte();
                        $num_compte = 'NB-' . 'TPaR' . '-' . $apporteur;
						//$num_comptets = 'NB-' . 'TSPaR' . '-' . $apporteur;
                        $result = $cm_mapper->find($num_compte, $compte_par);
						//$resultts = $cm_mapper->find($num_comptets, $compte_par);
						
						if($_POST["cat_bnp"] == "bnps") {
						
                                if ($result == false) {
						            // insertion dans la table eu_compte
                                    $compte_par->setCode_cat('TPaR')
                                               ->setSolde($par)
                                               ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                               ->setCode_compte($num_compte)
                                               ->setLib_compte('TPaR')
                                               ->setCode_type_compte('NB')
                                               ->setDesactiver(0);
                                    if (Util_Utils::getmembreType($apporteur) === 'M') {
                                        $compte_par->setCode_membre_morale($apporteur);
								        $compte_par->setCode_membre(null);
                                    } else {
                                        $compte_par->setCode_membre($apporteur);
								        $compte_par->setCode_membre_morale(null);
                                    }
                                    $cm_mapper->save($compte_par);
                                } else {
						            // Mise à jour de la table eu_compte
                                    $compte_par->setSolde($compte_par->getSolde() + $par);
                                    $cm_mapper->update($compte_par);
                                }
						
						        // Envoi de la PaR sur le compte credit de l'apporteur
                                $source_par = $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                                $max_par = $cc_mapper->findConuter() + 1;
                                Util_Utils::createCompteCredit($max_par, 0, $count, $apporteur, 'PaR', $num_compte, $par, $mont_place,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'), $source_par, $maxcc, 'N', 'N', 0, 1, $code_bnp, 'CNPG',$prk,0);

						        // insertion dans la table eu_cnp
                                $cnp_par = new Application_Model_EuCnp();
                                $maxcnp = $m_cnp->findConuter() + 1;
                                $cnp_par->setId_cnp($maxcnp)
                                        ->setId_credit($max_par)
                                        ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                        ->setMont_debit($par)
                                        ->setMont_credit(0)
                                        ->setSolde_cnp($par)
                                        ->setType_cnp($code_produit)
                                        ->setSource_credit($source_par)
                                        ->setOrigine_cnp('RPGr')
                                        ->setTransfert_gcp(0);
                                $m_cnp->save($cnp_par);
						}
						
						
						if($_POST["cat_bnp"] == "bnpp") {
						    // Envoi de la PaR sur le compte credit de l'apporteur
                            $source_par = $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                            $max_par = $cc_mapper->findConuter() + 1;
                            Util_Utils::createCompteCredit($max_par, 0, $count, $apporteur, 'PaR', $num_compte,0, $mont_place,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'), $source_par, $maxcc, 'O', 'N', 0, 1, $code_bnp, 'CNPG',$prk,0);
						    // insertion dans la table eu_cnp
                            $cnp_par = new Application_Model_EuCnp();
                            $maxcnp = $m_cnp->findConuter() + 1;
                            $cnp_par->setId_cnp($maxcnp)
                                    ->setId_credit($max_par)
                                    ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                    ->setMont_debit($par)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($par)
                                    ->setType_cnp($code_produit)
                                    ->setSource_credit($source_par)
                                    ->setOrigine_cnp('RPGr')
                                    ->setTransfert_gcp(0);
                            $m_cnp->save($cnp_par);
							
							$prows = $tparam->find('periode', 'valeur');
                            if (count($prows) > 0) {
                               $periode = $prows->current()->montant;
                            }
							
							$brows = $tparam->find('bnp','periode');
                            if (count($brows) > 0) {
                               $periodebnp = $brows->current()->montant;
                            }
							
							$date_echue = new Zend_Date(Zend_Date::ISO_8601);
							$date_echue->addDay(floor($periodebnp*$periode));
							
							$id_krr = $mkrr->findConuter() + 1;
							$krr->setId_krr($id_krr)
							    ->setId_credit($max_par)
                                ->setCode_produit('PaR')
                                ->setMont_capa($mont_place)
                                ->setMont_krr($mont_place)
                                ->setDate_echue($date_echue->toString('yyyy-MM-dd'))
                                ->setDate_renouveller($date_deb->toString('yyyy-MM-dd'))
                                ->setPayer('N')
                                ->setReconstituer('N')
                                ->setDate_demande($date_deb->toString('yyyy-MM-dd'))
				                ->setType_krr('krRBNPP')
								->setMont_reconst($par);
								
							if (Util_Utils::getmembreType($apporteur) === 'M') {	
							   $krr->setCode_membre_morale($apporteur);	
							} else {
                               $krr->setCode_membre($apporteur);
                            }							
                            $mkrr->save($krr);
							
							$id_detail_krr = $mdkrr->findConuter() + 1;
							$dkrr->setId_detail_krr($id_detail_krr)
							     ->setId_krr($id_krr)
								 ->setId_credit($max_par)
								 ->setSource_credit($source_par)
								 ->setMont_credit($par)
								 ->setAnnuler(0);
							$mdkrr->save($dkrr);	 
						}
						
						
						if ($caps != null && $indexer)     {
						    // Mise à jour de la table eu_caps
                            $caps->setMont_fs($caps->getMont_fs() + $fs)
                                    ->setMont_panu_fs($caps->getMont_panu_fs() + $panu_fs)
                                    ->setId_credit($maxcc)
                                    ->setIndexer(1);
                            $m_caps->update($caps);

                            //Enregistrement du capa et du fs sur le compte Tfs de l'apporteur
                            $compte_fs = new Application_Model_EuCompte();
                            if (Util_Utils::getmembreType($caps->getCode_membre_morale_app()) === 'M') {
                                $num_compte = 'NB-' . 'TFS' . '-' . $caps->getCode_membre_morale_app();
								$num_comptets = 'NB-' . 'TSFS' . '-' . $caps->getCode_membre_morale_app();
                            } elseif (Util_Utils::getMembreType($caps->getCode_membre_app()) === 'P') {
                                $num_compte = 'NB-' . 'TFS' . '-' . $caps->getCode_membre_app();
								$num_comptets = 'NB-' . 'TSFS' . '-' . $caps->getCode_membre_app();
                            }
                            $result = $cm_mapper->find($num_compte, $compte_fs);
							$resultts = $cm_mapper->find($num_comptets, $compte_fs);
                            if ($result == false) {
							    // insertion dans la table eu_compte
                                $compte_fs->setCode_cat('TFS')
                                        ->setSolde($fs)
                                        ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                        ->setCode_compte($num_compte)
                                        ->setLib_compte('TFS')
                                        ->setCode_type_compte('NB')
                                        ->setDesactiver(0);
                                if (Util_Utils::getmembreType($caps->getCode_membre_app()) === 'M') {
                                    $compte_fs->setCode_membre_morale($caps->getCode_membre_morale_app());
									$compte_fs->setCode_membre(null);
                                } else {
                                    $compte_fs->setCode_membre($caps->getCode_membre_app());
									$compte_fs->setCode_membre(null);
                                }
                                $cm_mapper->save($compte_fs);
                            } else {
							    // Mise à jour de la table eu_compte
                                $compte_fs->setSolde($compte_fs->getSolde() + $fs);
                                $cm_mapper->update($compte_fs);
                            }
							
							
							// creation du compte de transaction fs
							/*
							if ($resultts == false) {
                                $compte_fs->setCode_cat('TSFS')
                                          ->setSolde(0)
                                          ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                          ->setCode_compte($num_comptets)
                                          ->setLib_compte('TSFS')
                                          ->setCode_type_compte('NB')
                                          ->setDesactiver(0);
                                if (Util_Utils::getmembreType($caps->getCode_membre_app()) === 'M') {
                                    $compte_fs->setCode_membre_morale($caps->getCode_membre_morale_app());
									$compte_fs->setCode_membre(null);
                                } else {
                                    $compte_fs->setCode_membre($caps->getCode_membre_app());
									$compte_fs->setCode_membre(null);
                                }
                                $cm_mapper->save($compte_fs);
                            }*/

                            // Envoi du fs sur le compte credit de l'apporteur
                            $cc_fs = new Application_Model_EuCompteCredit();
                            $fs_source = $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                            $maxfs = $cc_mapper->findConuter() + 1;
                            Util_Utils::createCompteCredit($maxfs, 0, $count, $apporteur, 'FS', $num_compte, $fs, $mont_place,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'), $fs_source, $maxcc, 'N', 'N', 0, 1, $code_bnp, 'CNPG',$prk,0);

							// insertion dans la table eu_cnp
                            $cnp_fs = new Application_Model_EuCnp();
                            $maxcnp = $m_cnp->findConuter() + 1;
                            $cnp_fs->setId_cnp($maxcnp)
                                    ->setId_credit($maxfs)
                                    ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                    ->setMont_debit($fs)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($fs)
                                    ->setType_cnp($operation->getCode_produit())
                                    ->setSource_credit($cc_fs->getSource())
                                    ->setOrigine_cnp('RPGr')
                                    ->setTransfert_gcp(0);
                            $m_cnp->save($cnp_fs);
                        }
						
						if ($panu > 0) {
                            //Enregistrement du capa et du PaNu sur le compte TPaNu de l'apporteur
                            $compte_panu = new Application_Model_EuCompte();
                            $num_compte = 'NB-' . 'TPaNu' . '-' . $apporteur;
							//$num_comptets = 'NB-' . 'TSPaNu' . '-' . $apporteur;
                            $result = $cm_mapper->find($num_compte, $compte_panu);
							//$resultts = $cm_mapper->find($num_comptets, $compte_panu);
                            if ($result == false) {
							    // insertion de la PaNu dans la table eu_compte
                                $compte_panu->setCode_cat('TPaNu')
                                        ->setSolde($panu)
                                        ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                        ->setCode_compte($num_compte)
                                        ->setLib_compte('TPaNu')
                                        ->setCode_type_compte('NB')
                                        ->setDesactiver(0);
                                if (Util_Utils::getmembreType($apporteur) === 'M') {
                                    $compte_panu->setCode_membre_morale($apporteur);
									$compte_panu->setCode_membre(null);
                                } else {
                                    $compte_panu->setCode_membre($apporteur);
									$compte_panu->setCode_membre_morale(null);
                                }
                                $cm_mapper->save($compte_panu);
                            } else {
							    // Mise à jour dans la table eu_compte
                                $compte_panu->setSolde($compte_panu->getSolde() + $panu);
                                $cm_mapper->update($compte_panu);
                            }
							
							// Creation du compte de transaction dans la table eu_compte
							/*
							if ($resultts == false) {
                                $compte_panu->setCode_cat('TSPaNu')
                                        ->setSolde(0)
                                        ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                        ->setCode_compte($num_comptets)
                                        ->setLib_compte('TSPaNu')
                                        ->setCode_type_compte('NB')
                                        ->setDesactiver(0);
                                if (Util_Utils::getmembreType($apporteur) === 'M') {
                                    $compte_panu->setCode_membre_morale($apporteur);
									$compte_panu->setCode_membre(null);
                                } else {
                                    $compte_panu->setCode_membre($apporteur);
									$compte_panu->setCode_membre_morale(null);
                                }
                                $cm_mapper->save($compte_panu);
                            }*/
							

                            // Envoi du PaNu sur le compte credit de l'apporteur
                            $cc_panu = new Application_Model_EuCompteCredit();
                            $maxpanu = $cc_mapper->findConuter() + 1;
                            $source_panu = $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                            Util_Utils::createCompteCredit($maxpanu, 0, $count, $apporteur, 'PaNu', $num_compte, $panu, $mont_place,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'), $source_panu, $maxcc, 'N', 'N', 0, 1, $code_bnp, 'CNPG',$prk,0);

							// insertion dans la table eu_cnp
                            $cnp_panu = new Application_Model_EuCnp();
                            $maxcnp = $m_cnp->findConuter() + 1;
                            $cnp_panu->setId_cnp($maxcnp)
                                    ->setId_credit($maxpanu)
                                    ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                    ->setMont_debit($panu)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($panu)
                                    ->setType_cnp($operation->getCode_produit())
                                    ->setSource_credit($cc_panu->getSource())
                                    ->setOrigine_cnp('RPGr')
                                    ->setTransfert_gcp(0);
                            $m_cnp->save($cnp_panu);
                        }
						
						// insertion dans la table eu_bnp_credit
                        $bnpcredit_mapper = new Application_Model_EuBnpCreditMapper();
                        $bnpcredit = new Application_Model_EuBnpCredit();
                        $bnpcredit->setCode_bnp($code_bnp)
                                ->setId_credit($maxcc)
                                ->setMont_credit($credit)
                                ->setMont_conus($conus)
                                ->setMont_fs($fs)
                                ->setMont_panu($panu)
                                ->setMont_par($par)
                                ->setMont_panu_fs($panu_fs)
                                ->setPeriode_remb(1);
                        $bnpcredit_mapper->save($bnpcredit);
						
						// insertion dans la table eu_detail_bnp pour la creation du tableau bnp
                        $bnpdetail_mapper = new Application_Model_EuDetailBnpMapper();
                        $mont_capa = $mont_place;
                        $mont_reconst = 0;
                        $i = 1;
                        $bnpdetail = new Application_Model_EuDetailBnp();
						
						    if($_POST["cat_bnp"] == "bnps") {    
						        while ($mont_reconst < $mont_place) {
						            // insertion dans la table eu_bnp_detail
                                    $maxbnp = $bnpdetail_mapper->findConuter() + 1;
                                    $bnpdetail->setId_detail($maxbnp)
                                              ->setCode_bnp($code_bnp)
                                              ->setId_credit($maxcc)
                                              ->setMont_capa($mont_capa)
                                              ->setMontant_credit($credit)
                                              ->setMont_conus($conus)
                                              ->setMont_par($par)
                                              ->setMont_panu($panu)
                                              ->setMont_fs($fs)
                                              ->setMont_panu_fs($panu_fs)
                                              ->setPeriode($i);
                                    $bnpdetail_mapper->save($bnpdetail);
								
								    $mont_reconst = $mont_reconst + $par;
                                    $mont_capa    = $mont_capa - $par;
                                    $credit       = round(($mont_capa * $prk) / $pck);
                                    $old_panu     = $panu;
								
								    if ($statut_beneficiaire === 'O') {
                                        if ($type_bnp != 'CAIPC' || $type_bnp != 'CAIPCNRPREKITTEC') {
                                           $panu = round(($credit * ($tbnp->getTx_panu() + $tbnp->getTx_fs())) / 100);
                                        }
                                    } elseif ($statut_beneficiaire == 'N') {
                                        if ($indexer) {
                                            if ($type_bnp == 'CAIPC' || $type_bnp == 'CAIPCNRPREKITTEC') {
                                              //$fs = round(($credit * $tbnp->getTx_fs()) / 100);
                                            } else {
                                              $panu = round(($credit * $tbnp->getTx_panu()) / 100);
                                              //$fs = round(($credit * $tbnp->getTx_fs()) / 100);
                                            }
                                        } else {
                                            if ($type_bnp != 'CAIPC' || $type_bnp == 'CAIPCNRPREKITTEC') {
                                               $panu = round(($credit * ($tbnp->getTx_panu() + $tbnp->getTx_fs())) / 100);
                                            }
                                        }
                                    }
								    $panu_fs = $old_panu - $panu;
								    $conus = $conus + $panu_fs;
                                    $i++;
						        }
                            }
							
							if($_POST["cat_bnp"] == "bnpp") {    
						        while ($mont_reconst < $mont_place) {
						            // insertion dans la table eu_bnp_detail
                                    $maxbnp = $bnpdetail_mapper->findConuter() + 1;
                                    $bnpdetail->setId_detail($maxbnp)
                                              ->setCode_bnp($code_bnp)
                                              ->setId_credit($maxcc)
                                              ->setMont_capa($mont_capa)
                                              ->setMontant_credit($credit)
                                              ->setMont_conus($conus)
                                              ->setMont_par($par)
                                              ->setMont_panu($panu)
                                              ->setMont_fs($fs)
                                              ->setMont_panu_fs($panu_fs)
                                              ->setPeriode($i);
                                    $bnpdetail_mapper->save($bnpdetail);
								
								    $mont_reconst = $mont_reconst + $par;
                                    $mont_capa    = $mont_capa - $par;
                                    $credit       = round(($mont_capa * $prk) / $pck);
                                    $old_panu     = $panu;
								
								    if ($statut_beneficiaire === 'O') {
                                        if ($type_bnp != 'CAIPC' || $type_bnp != 'CAIPCNRPREKITTEC') {
                                           $panu = round(($credit * ($tbnp->getTx_panu() + $tbnp->getTx_fs())) / 100);
                                        }
                                    } elseif ($statut_beneficiaire == 'N') {
                                        if ($indexer) {
                                            if ($type_bnp == 'CAIPC' || $type_bnp == 'CAIPCNRPREKITTEC') {
                                              //$fs = round(($credit * $tbnp->getTx_fs()) / 100);
                                            } else {
                                              $panu = round(($credit * $tbnp->getTx_panu()) / 100);
                                              //$fs = round(($credit * $tbnp->getTx_fs()) / 100);
                                            }
                                        } else {
                                            if ($type_bnp != 'CAIPC' || $type_bnp == 'CAIPCNRPREKITTEC') {
                                               $panu = round(($credit * ($tbnp->getTx_panu() + $tbnp->getTx_fs())) / 100);
                                            }
                                        }
                                    }
								    $panu_fs = $old_panu - $panu;
								    //$conus = $conus + $panu_fs;
                                    $i++;
						        }
                            }
								
					    //$db->commit();
                        //return $this->_helper->redirector('index');
					}
					$membre_map = new Application_Model_EuMembreMapper();
					$findmembre = $membre_map->find($beneficiaire,$membre);
					$compteur = Util_Utils::findConuter() + 1;
					Util_Utils::addSms($compteur,$membre->getPortable_membre(), "Vous venez de recharger  ".$credi . " " . $code_dev . " sur votre compte TPAGCRPG Solde final: " . $cm->getSolde());					
					$db->commit();
                    return $this->_helper->redirector('index');
					//Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $cm->getSolde());
            } catch (Exception $exc) {
                    $db->rollback();
                    $message = "Erreur d\'éxécution : Message d'erreur:" . $exc->getMessage() . "\n Trace : " . $exc->getTraceAsString();
                    $this->view->message = $message;
                    $this->view->code_membre_app = $apporteur;
                    $this->view->code_membre_benef = $beneficiaire;
                    $this->view->type_bnp = $type_bnp;
                    $this->view->form = $form;
                    $this->view->form = $form;
                    return;
            }
		}	
        }		
        $form->getElement('cancel')->setAttrib('onclick', "window.open('".$this->view->url(array('controller' => 'eu-bnp','action' => 'index'),'default',true)."','_self')");
        $this->view->form = $form;
    }

	
    public function membremoralAction() {
        $membres_m = array();
        $type_bnp = $_GET['type_bnp'];
        if (($type_bnp == 'CMIT') || ($type_bnp == 'CMITNRPREKITTEC')) {
            $t_acteur = new Application_Model_DbTable_EuActeur();
            $act_select = $t_acteur->select();
            $act_select->where('type_acteur like ?', 'PBF');
            $rows_act = $t_acteur->fetchAll($act_select);
            foreach ($rows_act as $act) {
                $membres_m[] = $act->code_membre;
            }
        } elseif (($type_bnp == 'CAIPC') || ($type_bnp == 'CAIPCNRPREKITTEC')) {
            $t_membre = new Application_Model_DbTable_EuMembreMorale();
            $m_select = $t_membre->select();
            $m_select->where('code_type_acteur in(?)', array('OSE', 'POSE'));
            $rows_m = $t_membre->fetchAll($m_select);
            foreach ($rows_act as $m) {
                $membres_m[] = $m->code_membre_morale;
            }
        } elseif (($type_bnp == 'CAPU') || ($type_bnp == 'CAPUNRPREKITTEC')) {
            $t_membre = new Application_Model_DbTable_EuMembre();
            $rows_p = $t_membre->fetchAll();
            foreach ($rows_p as $p) {
                $membres_m[] = $p->code_membre;
            }
        }
        $this->view->data = $membres_m;
    }

    public function membrephysAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre;
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




    public function docapsAction() {
	        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
            $form = new Application_Form_EuBnpCaps();
			if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $date = new Zend_Date(Zend_Date::ISO_8601);
                $type_bnp = $form->getValue('type_bnp');
                $apporteur = $_POST['apport'];
				$mode_fin = $_POST['sel_mode_fin'];
                $mont_caps = $form->getValue('mont_caps');
               
                $type_caps = $form->getValue('type_caps');

                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
				
				    if ($mode_fin == 'SMS') {
					     $montant = $form->getValue('montant');
                         $code_sms = $form->getValue('code_sms');
                         if ($code_sms != '') {
                            $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                            $sms = $sms_mapper->findByCreditCode($code_sms);
                            if ($sms != null && $sms->getIDDateTimeConsumed() == 0) {
                                $montant = $sms->getCreditAmount();
                                $code_dev = $sms->getCurrencyCode();
                                if ($code_dev != 'XOF') {
                                    $code_cours = $code_dev . '-XOF';
                                    $cours = new Application_Model_EuCours();
                                    $m_cours = new Application_Model_EuCoursMapper();
                                    $ret = $m_cours->find($code_cours, $cours);
                                    if ($ret) {
                                       if ($montant != '') {
                                          $montant = $montant * $cours->getVal_dev_fin();
                                    }
                                }
                            }
                        } else {
                               $db->rollback();
                               $this->view->message = 'Le Code sms est invalide ou n\'est pas renseigné !!!';
                               $this->view->form = $form;
                               return;
                        }
                        if ($montant != $mont_caps) {
                               $db->rollback();
                               $this->view->message = 'Le montant du Code sms doit être égal au montant du caps !!!';
                               $this->view->form = $form;
                               return;
                        } else {
                               $mapper = new Application_Model_EuOperationMapper();
                               $count = $mapper->findConuter() + 1;
                               $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                               $date_deb = clone $date_fin;

                               //enregistrement de l'operation
                               $place = new Application_Model_EuOperation();
                               if (substr($apporteur, 19, 1) == 'P') {
                                  $place->setId_operation($count)
                                        ->setDate_op(Util_Utils::toDate($date_deb))
                                        ->setHeure_op(Util_Utils::toDate($date_deb))
                                        ->setId_utilisateur($user->id_utilisateur)
                                        ->setCode_membre($apporteur)
                                        ->setCode_membre_morale(null)
                                        ->setMontant_op($montant)
                                        ->setCode_produit('FS')
                                        ->setLib_op('Enrôlement')
                                        ->setType_op($type_bnp)
                                        ->setCode_cat('TFS');
                            } else {
                                   $place->setId_operation($count)
                                         ->setDate_op(Util_Utils::toDate($date_deb))
                                         ->setHeure_op(Util_Utils::toDate($date_deb))
                                         ->setId_utilisateur($user->id_utilisateur)
                                         ->setCode_membre(null)
                                         ->setCode_membre_morale($apporteur)
                                         ->setMontant_op($montant)
                                         ->setCode_produit('FS')
                                         ->setLib_op('Enrôlement')
                                         ->setType_op($type_bnp)
                                         ->setCode_cat('TFS');
                            }
                                    $mapper->save($place);

                                     //saisie du bnp :récupération du membre apporteur et 
                                     //vérification de son statut (Personne physique ou morales(pbf ou non))
                                     $panu = 0;
                                     $m_map = new Application_Model_EuMembreMapper();
                                     $membre = new Application_Model_EuMembre();
                                     $m_ret = $m_map->find($apporteur, $membre);
                                     if (!$m_ret) {
                                     $t_acteur = new Application_Model_DbTable_EuActeur();
                                     $select = $t_acteur->select();
                                     $select->where('code_membre like ?', $apporteur)
                                            ->where('code_activite like ?', 'PBF');
                                     $results = $t_acteur->fetchAll($select);
                                     if (count($results) > 0) {
                                        $panu = 1;
                                     }
                            }
                                     $m_caps = new Application_Model_EuCapsMapper();
                                     $caps = new Application_Model_EuCaps();
                                     $id = $type_bnp . $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                                     if (substr($apporteur, 19, 1) == 'P') {
                                     $caps->setCode_caps($id)
                                          ->setCode_membre_app($apporteur)
                                          ->setCode_membre_morale_app(null)
                                          ->setCode_membre_benef(null)
                                          ->setMont_caps($montant)
                                          ->setMont_fs(0)
                                          ->setPeriode(0)
                                          ->setId_operation($count)
                                          ->setRembourser('N')
                                          ->setId_credit(null)
                                          ->setIndexer(0)
                                          ->setType_caps($type_caps)
                                          ->setCode_type_bnp($type_bnp)
                                          ->setFs_utiliser(0)
                                          ->setFl_utiliser(0)
                                          ->setMont_panu_fs(0)
                                          ->setReconst_fs(0)
                                          ->setPanu($panu)
                                          ->setDate_caps(Util_Utils::toDate($date))
                                          ->setId_utilisateur($user->id_utilisateur);

                                if ($type_caps == 'CAPSFLFCPS') {
                                    $caps->setCps_utiliser(1);
                                } elseif ($type_caps == 'CAPSFL2FCPS') {
                                    $caps->setCps_utiliser(2);
                                } elseif ($type_caps == 'CAPSFL3FCPS') {
                                    $caps->setCps_utiliser(3);
                                }
                            } else {
                                $caps->setCode_caps($id)
                                     ->setCode_membre_app(null)
                                     ->setCode_membre_morale_app($apporteur)
                                     ->setCode_membre_benef(null)
                                     ->setMont_caps($montant)
                                     ->setMont_fs(0)
                                     ->setPeriode(0)
                                     ->setId_operation($count)
                                     ->setRembourser('N')
                                     ->setId_credit(null)
                                     ->setIndexer(0)
                                     ->setType_caps($type_caps)
                                     ->setCode_type_bnp($type_bnp)
                                     ->setFs_utiliser(0)
                                     ->setFl_utiliser(0)
                                     ->setMont_panu_fs(0)
                                     ->setReconst_fs(0)
                                     ->setPanu($panu)
                                     ->setDate_caps(Util_Utils::toDate($date))
                                     ->setId_utilisateur($user->id_utilisateur);

                                if ($type_caps == 'CAPSFLFCPS') {
                                    $caps->setCps_utiliser(1);
                                } elseif ($type_caps == 'CAPSFL2FCPS') {
                                    $caps->setCps_utiliser(2);
                                } elseif ($type_caps == 'CAPSFL3FCPS') {
                                    $caps->setCps_utiliser(3);
                                }
                            }
                            $m_caps->save($caps);
                            $sms->setDestAccount_Consumed('CAPS-' . $apporteur)
                                ->setDateTimeconsumed($date->toString('dd/mm/yyyy hh:mm:ss'))
                                ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms);
                            $db->commit();
                            return $this->_helper->redirector('new', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'new', 'fs' => $place->getMontant_op(), 'code' => $id, 'apporteur' => $apporteur));
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = 'Le Code sms est obligatoire !!!';
                        $this->view->form = $form;
                        return;
                    }
				  }	elseif ($mode_fin == 'NN') {
				           $type_comptenn = $_POST['type_mf'];
                           $code_compte = 'NN-' .'T'. $type_comptenn . '-' . $apporteur;
						   $compte_nn = new Application_Model_EuCompte();
						   $cm_map = new Application_Model_EuCompteMapper();
                           $result_nn = $cm_map->find($code_compte, $compte_nn);
						   if ($result_nn && $compte_nn->getSolde() >= $montant) {
						        //Mise à jour du compte principal
							    $compte_nn->setSolde($compte_nn->getSolde() - $montant);
                                $cm_map->update($compte_nn);
							   
							    // Mise à jour des comptes crédits
								
								
								$mapper = new Application_Model_EuOperationMapper();
                                $count = $mapper->findConuter() + 1;
                                $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                                $date_deb = clone $date_fin;

                                //enregistrement de l'operation
                                $place = new Application_Model_EuOperation();
                                if (substr($apporteur, 19, 1) == 'P') {
                                    $place->setId_operation($count)
                                          ->setDate_op(Util_Utils::toDate($date_deb))
                                          ->setHeure_op(Util_Utils::toDate($date_deb))
                                          ->setId_utilisateur($user->id_utilisateur)
                                          ->setCode_membre($apporteur)
                                          ->setCode_membre_morale(null)
                                          ->setMontant_op($montant)
                                          ->setCode_produit('FS')
                                          ->setLib_op('Enrôlement')
                                          ->setType_op($type_bnp)
                                          ->setCode_cat('TFS');
                                } else  {
                                        $place->setId_operation($count)
                                              ->setDate_op(Util_Utils::toDate($date_deb))
                                              ->setHeure_op(Util_Utils::toDate($date_deb))
                                              ->setId_utilisateur($user->id_utilisateur)
                                              ->setCode_membre(null)
                                              ->setCode_membre_morale($apporteur)
                                              ->setMontant_op($montant)
                                              ->setCode_produit('FS')
                                              ->setLib_op('Enrôlement')
                                              ->setType_op($type_bnp)
                                              ->setCode_cat('TFS');
                                }
                                        $mapper->save($place);

                                        //saisie du bnp :récupération du membre apporteur et 
                                        //vérification de son statut (Personne physique ou morales(pbf ou non))
                                         $panu = 0;
                                         $m_map = new Application_Model_EuMembreMapper();
                                         $membre = new Application_Model_EuMembre();
                                         $m_ret = $m_map->find($apporteur, $membre);
                                         if (!$m_ret) {
                                         $t_acteur = new Application_Model_DbTable_EuActeur();
                                         $select = $t_acteur->select();
                                         $select->where('code_membre like ?', $apporteur)
                                                ->where('code_activite like ?', 'PBF');
                                         $results = $t_acteur->fetchAll($select);
                                         if (count($results) > 0) {
                                            $panu = 1;
                                         }
                                     }
                                         $m_caps = new Application_Model_EuCapsMapper();
                                         $caps = new Application_Model_EuCaps();
                                         $id = $type_bnp . $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                                         if (substr($apporteur, 19, 1) == 'P') {
                                             $caps->setCode_caps($id)
                                                  ->setCode_membre_app($apporteur)
                                                  ->setCode_membre_morale_app(null)
                                                  ->setCode_membre_benef(null)
                                                  ->setMont_caps($montant)
                                                  ->setMont_fs(0)
                                                  ->setPeriode(0)
                                                  ->setId_operation($count)
                                                  ->setRembourser('N')
                                                  ->setId_credit(null)
                                                  ->setIndexer(0)
                                                  ->setType_caps($type_caps)
                                                  ->setCode_type_bnp($type_bnp)
                                                  ->setFs_utiliser(0)
                                                  ->setFl_utiliser(0)
                                                  ->setMont_panu_fs(0)
                                                  ->setReconst_fs(0)
                                                  ->setPanu($panu)
                                                  ->setDate_caps(Util_Utils::toDate($date))
                                                  ->setId_utilisateur($user->id_utilisateur);

                                                  if ($type_caps == 'CAPSFLFCPS') {
                                                      $caps->setCps_utiliser(1);
                                                  } elseif ($type_caps == 'CAPSFL2FCPS') {
                                                      $caps->setCps_utiliser(2);
                                                  } elseif ($type_caps == 'CAPSFL3FCPS') {
                                                      $caps->setCps_utiliser(3);
                                                  }
                                           } else {
                                                      $caps->setCode_caps($id)
                                                           ->setCode_membre_app(null)
                                                           ->setCode_membre_morale_app($apporteur)
                                                           ->setCode_membre_benef(null)
                                                           ->setMont_caps($montant)
                                                           ->setMont_fs(0)
                                                           ->setPeriode(0)
                                                           ->setId_operation($count)
                                                           ->setRembourser('N')
                                                           ->setId_credit(null)
                                                           ->setIndexer(0)
                                                           ->setType_caps($type_caps)
                                                           ->setCode_type_bnp($type_bnp)
                                                           ->setFs_utiliser(0)
                                                           ->setFl_utiliser(0)
                                                           ->setMont_panu_fs(0)
                                                           ->setReconst_fs(0)
                                                           ->setPanu($panu)
                                                           ->setDate_caps(Util_Utils::toDate($date))
                                                           ->setId_utilisateur($user->id_utilisateur);

                                                        if ($type_caps == 'CAPSFLFCPS') {
                                                            $caps->setCps_utiliser(1);
                                                        } elseif ($type_caps == 'CAPSFL2FCPS') {
                                                            $caps->setCps_utiliser(2);
                                                        } elseif ($type_caps == 'CAPSFL3FCPS') {
                                                            $caps->setCps_utiliser(3);
                                                        }
                            }
                                                        $m_caps->save($caps);
                                                        $db->commit();
                                                        return $this->_helper->redirector('new', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'new', 'fs' => $place->getMontant_op(), 'code' => $id, 'apporteur' => $apporteur));	
							   
						   }
				  }	
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = "Erreur d\'éxécution : " . $exc->getMessage() . $exc->getTraceAsString();
                    $this->view->message = $message;
                    $this->view->form = $form;
                }
            }
        }

        $this->view->form = $form;
			
			
			
			
	
	
	}
     
    
	public function capsAction() {
	    $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $form = new Application_Form_EuBnpCaps();
        $fs = Util_Utils::getParametre('CAPS', 'valeur');
        //if ($fs > 0) {
           //$form->getElement('mont_caps')->setValue($fs)->setAttrib('readOnly', 'true');
        //}
        $form->getElement('type_bnp')->setValue('CAPS')->setAttrib('readOnly', 'true');
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array (
                    'controller' => 'eu-bnp',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
				
				
		if ($this->getRequest()->isPost()) {
		    if ($form->isValid($this->getRequest()->getPost())) {
			    
				$date = new Zend_Date(Zend_Date::ISO_8601);
                $type_bnp = $form->getValue('type_bnp');
                $apporteur = $_POST['apport'];
				$mode_fin = $_POST['mode_fin'];
                $mont_caps = $form->getValue('mont_caps');               
                $type_caps = $form->getValue('type_caps');

                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
				
				try { 
					//if ($mode_fin == 'SMS') {
					     
						$montant = $form->getValue('montant');
                        $code_sms = $form->getValue('code_sms');
                        if ($code_sms != '') {
                            $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                            $sms = $sms_mapper->findByCreditCode($code_sms);
							
							if($sms->getMotif() != 'CAPS') {
							   $db->rollback();
                               $this->view->message = "Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                               $this->view->form = $form;
                               return; 
							}
                            if ($sms != null && $sms->getIDDateTimeConsumed() == 0) {
                                $montant = $sms->getCreditAmount();
                                $code_dev = $sms->getCurrencyCode();
                                if ($code_dev != 'XOF') {
                                    $code_cours = $code_dev . '-XOF';
                                    $cours = new Application_Model_EuCours();
                                    $m_cours = new Application_Model_EuCoursMapper();
                                    $ret = $m_cours->find($code_cours, $cours);
                                    if ($ret) {
                                        if ($montant != '') {
                                           $montant = $montant * $cours->getVal_dev_fin();
                                        }
                                    }
                            }
                        } else {
                               $db->rollback();
                               $this->view->message = 'Le Code sms est invalide ou n\'est pas renseigné !!!';
                               $this->view->form = $form;
                               return;
                        }
                        if ($montant != $mont_caps) {
                           $db->rollback();
                           $this->view->message = 'Le montant du Code sms doit être égal au montant du caps !!!';
                           $this->view->form = $form;
                           return;
                        } else {
                           $mapper = new Application_Model_EuOperationMapper();
                           $count = $mapper->findConuter() + 1;
                           $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                           $date_deb = clone $date_fin;

                           
                           $place = new Application_Model_EuOperation();
                           if (substr($apporteur, 19, 1) == 'P') {
						      // insertion dans la table eu_operation
                                $place->setId_operation($count)
                                    ->setDate_op($date->toString('yyyy-MM-dd'))
                                    ->setHeure_op($date->toString('HH:mm:ss'))
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCode_membre($apporteur)
                                    ->setCode_membre_morale(null)
                                    ->setMontant_op($montant)
                                    ->setCode_produit('FS')
                                    ->setLib_op('Enrolement')
                                    ->setType_op($type_bnp)
                                    ->setCode_cat('TFS');
                            } else {
							    // insertion dans la table eu_operation
                                $place->setId_operation($count)
                                     ->setDate_op($date->toString('yyyy-MM-dd'))
                                     ->setHeure_op($date->toString('HH:mm:ss'))
                                     ->setId_utilisateur($user->id_utilisateur)
                                     ->setCode_membre(null)
                                     ->setCode_membre_morale($apporteur)
                                     ->setMontant_op($montant)
                                     ->setCode_produit('FS')
                                     ->setLib_op('Enrolement')
                                     ->setType_op($type_bnp)
                                     ->setCode_cat('TFS');
                            }
                            $mapper->save($place);

                            $panu = 0;
                            $m_map = new Application_Model_EuMembreMapper();
                            $membre = new Application_Model_EuMembre();
                            $m_ret = $m_map->find($apporteur, $membre);
                            if (!$m_ret) {
                                $t_acteur = new Application_Model_DbTable_EuActeur();
                                $select = $t_acteur->select();
                                $select->where('code_membre like ?', $apporteur)
                                       ->where('code_activite like ?', 'PBF');
                                $results = $t_acteur->fetchAll($select);
                                if (count($results) > 0) {
                                    $panu = 1;
                                }
                            }
							
                            $m_caps = new Application_Model_EuCapsMapper();
                            $caps = new Application_Model_EuCaps();
                            $id = $type_bnp . $apporteur . $date_deb->toString('yyyyMMddHHmmss');
                            if (substr($apporteur, 19, 1) == 'P') {
							    // insertion dans la table eu_caps
                                $caps->setCode_caps($id)
                                     ->setCode_membre_app($apporteur)
                                     ->setCode_membre_morale_app(null)
                                     ->setCode_membre_benef(null)
                                     ->setMont_caps($montant)
                                     ->setMont_fs(0)
                                     ->setPeriode(0)
                                     ->setId_operation($count)
                                     ->setRembourser('N')
                                     ->setId_credit(null)
                                     ->setIndexer(0)
                                     ->setType_caps($type_caps)
                                     ->setCode_type_bnp($type_bnp)
                                     ->setFs_utiliser(0)
                                     ->setFl_utiliser(0)
                                     ->setMont_panu_fs(0)
                                     ->setReconst_fs(0)
                                     ->setPanu($panu)
                                     ->setDate_caps($date->toString('yyyy-MM-dd'))
                                     ->setId_utilisateur($user->id_utilisateur)
								     ->setType_op('SMS');

                                if ($type_caps == 'CAPSFLFCPS') {
                                    $caps->setCps_utiliser(1);
                                } elseif ($type_caps == 'CAPSFL2FCPS') {
                                    $caps->setCps_utiliser(2);
                                } elseif ($type_caps == 'CAPSFL3FCPS') {
                                    $caps->setCps_utiliser(3);
                                }
                            } else {
							    // insertion dans la table eu_caps
                                $caps->setCode_caps($id)
                                     ->setCode_membre_app(null)
                                     ->setCode_membre_morale_app($apporteur)
                                     ->setCode_membre_benef(null)
                                     ->setMont_caps($montant)
                                     ->setMont_fs(0)
                                     ->setPeriode(0)
                                     ->setId_operation($count)
                                     ->setRembourser('N')
                                     ->setId_credit(null)
                                     ->setIndexer(0)
                                     ->setType_caps($type_caps)
                                     ->setCode_type_bnp($type_bnp)
                                     ->setFs_utiliser(0)
                                     ->setFl_utiliser(0)
                                     ->setMont_panu_fs(0)
                                     ->setReconst_fs(0)
                                     ->setPanu($panu)
                                     ->setDate_caps($date->toString('yyyy-MM-dd'))
                                     ->setId_utilisateur($user->id_utilisateur)
									 ->setType_op('SMS');

                                if ($type_caps == 'CAPSFLFCPS') {
                                   $caps->setCps_utiliser(1);
                                } elseif ($type_caps == 'CAPSFL2FCPS') {
                                   $caps->setCps_utiliser(2);
                                } elseif ($type_caps == 'CAPSFL3FCPS') {
                                   $caps->setCps_utiliser(3);
                                }
                            }
                            $m_caps->save($caps);
							// Mise à jour de la table eu_smsmoney
                            $sms->setDestAccount_Consumed('CAPS-' . $apporteur)
                                ->setDateTimeconsumed($date->toString('dd/MM/yyyy HH:mm:ss'))
                                ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/MM/yyyy')));
                            $sms_mapper->update($sms);
							
                            $db->commit();
                            return $this->_helper->redirector('new', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'new', 'fs' => $place->getMontant_op(), 'code' => $id, 'apporteur' => $apporteur));
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = 'Le Code sms est obligatoire !!!';
                        $this->view->form = $form;
                        return;
                    }
				    //} 
				} catch (Exception $exc) {
                    $db->rollback();
                    $message = "Erreur d\'éxécution : " . $exc->getMessage() . $exc->getTraceAsString();
                    $this->view->message = $message;
                    $this->view->form = $form;
                }	 
			} 
		}
		$this->view->form = $form;	
	}

	// partage credit bnp
    public function bnpcreditAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_bnp');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_bnp = $this->_request->getParam("code");
        $tbnpcredit = new Application_Model_DbTable_EuBnpCredit();
        $select = $tbnpcredit->select();
        $select = $tbnpcredit->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_compte_credit', 'eu_bnp_credit.id_credit = eu_compte_credit.id_credit', array('code_produit', 'montant_place'));
        if ($code_bnp != '') {
            $select->where('eu_bnp_credit.code_bnp like ?', $code_bnp);
        }
        $credits = $tbnpcredit->fetchAll($select);
        $count = count($credits);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $credits = $tbnpcredit->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($credits as $row) {
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->code_bnp,
                $row->id_credit,
                $row->code_produit,
                $row->montant_place,
                $row->mont_credit,
                $row->mont_conus,
                $row->mont_par,
                $row->mont_panu,
                $row->mont_fs,
                $row->periode_remb
            );
            $i++;
        }
        $this->view->data = $responce;
    }

	// tableau bnp
    public function bnpdetailAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'periode');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_bnp = $this->_request->getParam("code");
        $code_credit = $this->_request->getParam("credit");
        $tbnpdetail = new Application_Model_DbTable_EuDetailBnp();
        $select = $tbnpdetail->select();
        if ($code_bnp != '') {
            $select->where('code_bnp like ?', $code_bnp);
        }
        if ($code_credit != '') {
            $select->where('id_credit like ?', $code_credit);
        }
        $credits = $tbnpdetail->fetchAll($select);
        $count = count($credits);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $credits = $tbnpdetail->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($credits as $row) {
            $responce['rows'][$i]['id'] = $row->id_detail;
            $responce['rows'][$i]['cell'] = array(
                $row->id_detail,
                $row->code_bnp,
                $row->id_credit,
                $row->periode,
                $row->mont_capa,
                $row->montant_credit,
                $row->mont_conus,
                $row->mont_par,
                $row->mont_panu,
                $row->mont_fs
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function pckAction() {
        $prk = intval(Util_Utils::getParametre('prk', 'nr'));
        $pck = floatval(str_replace(",", ".", Util_Utils::getParametre('pck', 'r')));
        $data[0] = $prk;
        $data[1] = $pck;
        $this->view->data = $data;
    }

    public function creditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'asc');
        $membre = $this->_request->getParam("membre");
        $categorie = $this->_request->getParam("categorie");
        $tcredit = new Application_Model_DbTable_EuCompteCredit();
        $select = $tcredit->select();
        if ($membre != '') {
            $membres = explode(' ', $membre);
            $select->where('code_membre in (?)', $membres);
        }
        if ($categorie != '') {
            $select->where('code_produit like ?', $categorie . 'r');
        }

        $select->where('code_bnp is null');
        $demande = $tcredit->fetchAll($select);
        $count = count($demande);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $demande = $tcredit->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($demande as $row) {
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->id_credit,
                $row->code_membre,
                $row->code_produit,
                $row->montant_place,
                $row->montant_credit
            );
            $i++;
        }
        $this->view->data = $responce;
        //$this->view->data = $select->__toString();
    }

    public function typesAction() {
        $request = $this->_request;
        $type_bnp = $request->getParam('type_bnp');
		$t_type   = new Application_Model_DbTable_EuTypeBnp();
		$select = $t_type->select();
		$select->where('code_type_bnp = ?',$type_bnp);
        $data = array();
        $types = $t_type->fetchAll($select);
            if (count($types) > 0) {
                foreach ($types as $value) {
                    $data[] = $value->code_type_bnp;
                }
            }
        $this->view->data = $data;
    }

    public function typemembreAction() {
        $request = $this->_request;
        $membre = $request->getParam('membre');
        if ($membre != '') {
            $m_mapper = new Application_Model_EuMembreMapper();
            $result = $m_mapper->getTypeMembre($membre);
            if ($result != null) {
                $this->view->data = $result;
            } else {
                $this->view->data = false;
            }
        }
    }

}
