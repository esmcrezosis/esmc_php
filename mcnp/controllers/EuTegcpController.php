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
class EuTegcpController extends Zend_Controller_Action {

    //put your code here
    public function init()  {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'acteur' || $group == 'acteur_pbf' || $group == 'creneau' || $group == 'creneau_pbf') {
            $menu = 
            //"<li><a href=\"/eu-tegcp/domicilier \">Domiciliation prk</a></li>" .
//                    "<li><a href=\"/eu-tegcp/domicilierimm \">Domiciliation pre</a></li>" .
                    "<li><a href=\"/eu-tegcp \">Liste domiciliations</a></li>" .
                    "<li><a href=\"/eu-tegcp/rembourse\">Liste transferts</a></li>" .
                    "<li><a href=\"/eu-tegcp/arretdomi\">Arrêter la domiciliation</a></li>";
        }   else if ($group == 'ag_m') {
            $menu = "<li><a href=\"/eu-tegcp/domicilierloyer \">Domiciliation du loyer</a></li>".
                    "<li><a href=\"/eu-tegcp \">Liste domiciliations</a></li>".
                    "<li><a href=\"/eu-tegcp/rembourse\">Liste transferts</a></li>".
                    "<li><a href=\"/eu-tegcp/arretdomi\">Arrêter la domiciliation</a></li>";
        }   else if ($group == 'e_nn_achatpp_nn_krr_rpgr' || $group == 'e_nn_achatpm_nn_krr_ir') {
            $menu = "<li><a href=\"/eu-tegcp/domicilier \">Domiciliation</a></li>".
                    "<li><a href=\"/eu-tegcp \">Liste domiciliations</a></li>";
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
            if ($group != 'acteur'  &&  $group != 'acteur_pbf'  &&  $group != 'creneau'  &&  $group != 'creneau_pbf'  &&  $group != 'ag_m'  
			   &&  $group != 'e_nn_achatpp_nn_krr_rpgr' &&  $group != 'e_nn_achatpm_nn_krr_ir') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function dataAction() {
	
        $etat_domi = $_GET["etat_domi"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $type_domi = 'tegcp';
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domiciliation');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomiciliation();
        $select = $tabela->select();
		
		$select->from('eu_domiciliation');
        $select->orwhere('eu_domiciliation.code_membre_beneficiaire = ?', $user->code_membre)
		       ->orwhere('eu_domiciliation.id_utilisateur = ?', $user->id_utilisateur)
               ->where('eu_domiciliation.accorder = ?', 'N')
               ->where('eu_domiciliation.type_domiciliation like ?', $type_domi)
               ->order('eu_domiciliation.date_domiciliation desc');
        
        if ($etat_domi != '') {
            $select->where('eu_domiciliation.domicilier = ?', $etat_domi);
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
        $totsub = 0;
        $totdomi = 0;
        foreach ($domici as $row) {
            $totsub  +=$row->montant_subvent;
            $totdomi +=$row->montant_domicilier;
            if ($row->cat_ressource == 'r') {
                $ress = 'Récurrent';
            } else {
                $ress = 'Non récurrent';
            }
            if ($row->domicilier == 'N') {
                $accord = 'En cours';
            } else {
                $accord = 'Terminé';
            }
			$date_dom   =   new Zend_Date($row->date_domiciliation, Zend_Date::ISO_8601);
			$date_echue = new Zend_Date($row->date_echue, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_domicilier;
            $responce['rows'][$i]['cell'] = array(
               $row->code_domicilier,
               $row->code_membre_beneficiaire,
               $ress,
               $row->montant_subvent,
               $row->montant_domicilier,
               $date_dom->toString('dd/MM/yyyy'),
               $date_echue->toString('dd/MM/yyyy'),
               $accord,
               $row->cat_ressource,
               $row->type_domiciliation,
            );
            $i++;
        }
        $responce['userdata']['cat_ressource'] = 'Totaux:';
        $responce['userdata']['mt_subvent'] = $totsub;
        $responce['userdata']['mt_domici'] = $totdomi;
        $this->view->data = $responce;
    }

    public function newAction() {
        $form = new Application_Form_EuDomiciliation();
        $this->view->form = $form;
    }

	
    public function domicilierAction() {
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
	    }
		$this->view->code_membre = $membre;
	    $this->view->nom = $nom;
	   
        
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
			$type_credit = $_GET['type_credit'];
            //Reconstitution du tableau des numéros membres
            $tab_clt = array();
            $tab_clt = explode(",", $client);
            if ($cat_ress == 'r') {
                //$produit = array('RPGr', 'Ir', 'Fs', 'PaNu', 'PaR');
				$produit = array('RPGr','Ir');
            }
            if ($cat_ress == 'nr') {
                $produit = array('RPGnr', 'Inr');
            }
            if ($cat_ress == '') {
                $produit = array('');
            }
            $tcredit = new Application_Model_DbTable_EuCompteCredit();
            $select = $tcredit->select();
			$select->from('eu_compte_credit');
            $select->where('code_produit in(?)', $produit)
                   ->where('code_membre in(?)', $tab_clt)
                   ->where('krr like ?', 'n')
				   ->where('bnp like ?',0)
                   ->where('code_compte like ?', 'nb%')
                   ->where('domicilier like ?', 0)
                   ->where('affecter != ?', 1);
			if($type_credit == 'sqmaxui') {
                $select->where('compte_source like ?','sqmaxui');
            } else {
                $select->where('compte_source <> ?','sqmaxui');
				$select->where('compte_source <> ?','capunrprekittec');
				$select->where('compte_source <> ?','caipcnrprekittec');
				$select->where('compte_source <> ?','cmitnrprekittec');
            }			
					
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
            $type_bnp = array('cscoe', 'cmit', 'cacb', 'capu', 'caipc');
            foreach ($credit as $row) {
                //Calcul du montant crédit pr les RPGr et Ir provenant d'un capa
                $prod = $row->code_produit;
                $compte_source = $row->compte_source;
                if (($prod == 'RPGr' || $prod == 'Ir') && ($type_credit != 'SQMAXUI')) {
                    $mt_credit = floor($row->montant_place * $prk / $pck);
                } else {
                    $mt_credit = floor($row->montant_place * $prk / $pck)/4;
                }
				if($mt_credit == $row->montant_credit) {
                  $dateoctroi = new Zend_Date($row->date_octroi,Zend_Date::ISO_8601);
                  $responce['rows'][$i]['id'] = $row->id_credit;
                  $responce['rows'][$i]['cell'] = array(
                     $row->code_membre,
                     $prod,
                     $row->montant_place,
                     $mt_credit,
                     $dateoctroi->toString('dd/MM/yyyy'),
                     $row->id_credit,
					 $type_credit
                );
                  $i++;
				}
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
                $mt_credit = floor($row->montant_place * $prk / $pck);
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

	
	
    public function createAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $ress = $_GET['ress'];
        //$mt_domicilie = $_GET['mt_domi'];
        $mt_obtenu = $_GET['mt_obtenu'];
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $acteur = $_GET['code_membre_benef'];
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        $code_dom = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMdd');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //$mt_subvent = $mt_domicilie;
                //###Contrôle du total des crédits domiciliés avec le montant du remboursement###
                //if ($mt_obtenu < $mt_subvent) {
                //$this->view->data = 'err_domici';
                //$db->rollback();
                //return;
                //} else 
				//{
                //###Traitement généraux et standard pour tout les type de domiciliation###
                //Mise à jour des comptes crédits
                    $cumul_credit = 0;
                    $mont_util = 0;
                    $test = false;
					$tparam = new Application_Model_DbTable_EuParametres();
                    $select_pck = $tparam->select();
                    $select_pck->where('code_param = ?', 'pck')
                               ->where('lib_param = ?', 'r');
                    $rows_pck = $tparam->fetchAll($select_pck);
                    if (count($rows_pck) > 0) {
                        $produit = $rows_pck->current();
                        $pck = $produit->montant;
                    }
					$type_credit = "";
                    foreach ($selection as $sel) {
                        //Contr�le de l'existence de la domiciliation du cr�dit
                        $id_credit = $sel['code_credit'];
						$type_credit = $sel['type_credit'];
                        $find_cred = $cm->findByCredDomi($id_credit,2);
                        if ($find_cred != null) {
                            $test = true;
                            $db->rollback();
                            $this->view->data = 'bad_domi';
                            return;
                        } else {
                            $result = $cm->find($sel['code_credit'],$cr);
                            if ($result) {
                                //Valeur du champ domicilier pr les crédits affecter au tegcp(2) 
                                $cr->setDomicilier(2);
                                //Ne cumuler que les crédits non consommés
                                if ($cr->getMontant_credit() >= $sel['mt_credit']) {
                                    $mont_util = $sel['mt_credit'];
                                } else {
                                    $mont_util = $cr->getMontant_credit();
                                }
                                $cumul_credit += $mont_util;
                                $cr->setMontant_credit($cr->getMontant_credit() - $mont_util);
                                if ($acteur == $cr->getCode_membre()) {
                                    $this->view->data = 'vol';
                                    $db->rollback();
                                    return;
                                } else {
                                    $cm->update($cr);
                                }
                            }
							
                            //Mise à jour du compte
                            $ret = $mcompte->find($cr->getCode_compte(), $compte);
                            if ($ret) {
                                $compte->setSolde($compte->getSolde() - $mont_util);
                                $mcompte->update($compte);
                            }
                        }
                    }
					
                    if ($test == false) {
                        //Enregistrement dans la table de domiciliation
                        $do->setMontant_subvent($mt_obtenu); //Montant cumul des crédits initiaux
                        $do->setDate_echue(Util_Utils::toDate($date_echue));
                        $do->setCode_domicilier($code_domici);
                        $do->setCode_membre_beneficiaire($acteur);
                        $do->setCode_membre_assureur($acteur);
                        $do->setCat_ressource($ress);
                        $do->setMontant_domicilier($cumul_credit);
                        if ($ress == 'nr') {
                            $do->setDomicilier('O');
                            $do->setDuree_renouvellement(1);
                            $do->setReste_duree(0);
                        } else if ($ress == 'r') {
                            $do->setDomicilier('N');
							if($type_credit == 'SQMAXUI') {
                              $do->setDuree_renouvellement(round($pck)*4);
                              $do->setReste_duree((round($pck)*4) - 1);
							} else {
                              $do->setDuree_renouvellement($pck);
                              $do->setReste_duree($pck-1);
                            }							
                        }
						
						
                        $do->setAccorder('N');
                        $do->setDate_domiciliation(Util_Utils::toDate($date_domi));
                        $type_domi = 'TEGCP';
                        $do->setType_domiciliation($type_domi);
                        $do->setCode_smcipn(null);
                        $do->setCode_smcipnp(null);
                        $do->setId_utilisateur($user->id_utilisateur);
                        $dom = new Application_Model_DbTable_EuDomiciliation();
                        $code_dom = $dom->find($code_domici);
                        if (count($code_dom) < 1) {
                            $mdo->save($do);
                        } else {
                            $this->view->data = 'cool';
                            $db->rollback();
                            return;
                        }
						
						
                        //Enregistrement dans la table detail_domicilie
                        $mtab = array();
                        foreach ($selection as $tab) {
                            $dod->setCode_domicilier($code_domici);
                            $dod->setId_credit($tab['code_credit']);
                            $dod->setCode_membre($tab['num_membre']);
                            $dod->setMontant_credit($tab['mt_credit']);
							if($type_credit == 'SQMAXUI') {
                              $do->setDuree_renouvellement(round($pck) * 4);
                              $do->setReste_duree((round($pck) * 4) - 1);
							} else {
							   $dod->setDuree_renouvellement(round($pck));
							   $dod->setReste_duree(round($pck) - 1);
							}
                            $dod->setUtiliser(1);
                            $mdod->save($dod);
                            $mtab = $tab['num_membre'];
                        }
						
						
                        //Mise à jour de la table eu_cnp
                        foreach ($selection as $sel) {
                            $result = $cm->find($sel['code_credit'], $cr);
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
                //}
                $db->commit();
                $this->view->data = 'good';
                $this->view->mtab = $mtab;
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                $this->view->data = 'bad';
                return;
            }
        }
    }

    public function accorderAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $mt_transfert = $_GET['mt_transfert'];
        $mtegc = New Application_Model_EuTegcMapper();
        $tegc = new Application_Model_EuTegc();
		$te = new Application_Model_EuTegc();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mddo = new Application_Model_EuDetailDomicilieMapper();
        $ddo = new Application_Model_EuDetailDomicilie();
        $mop = New Application_Model_EuOperationMapper();
        $op = new Application_Model_EuOperation();
        $mcnp = New Application_Model_EuCnpMapper();
        $cnp = new Application_Model_EuCnp();
        $mgcp = New Application_Model_EuGcpMapper();
        $gcp = new Application_Model_EuGcp();
        $mcc = New Application_Model_EuCreditConsommerMapper();
        $cc = new Application_Model_EuCreditConsommer();
        $mcred = New Application_Model_EuCompteCreditMapper();
        $cred = new Application_Model_EuCompteCredit();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_op = clone $date;
        $acteur = $user->code_membre;
		$mtegc->findByMembre($acteur,$te);
        $code_tegc = $te->getCode_tegc();
		
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Mise à jour de la table opération
                $compteur = $mop->findConuter() + 1;
                $op->setId_operation($compteur)
                   ->setDate_op($date_op->toString('yyyy-MM-dd'))
                   ->setHeure_op($date_op->toString('HH:mm:ss'))
                   ->setId_utilisateur($user->id_utilisateur)
                   ->setCode_membre(null)
				   ->setCode_membre_morale($acteur)
                   ->setMontant_op($mt_transfert)
                   ->setCode_produit('gcp')
                   ->setLib_op('Transfert de la domiciliation sur le compte TEGCP')
                   ->setType_op('TGCP')
                   ->setCode_cat('TPAGCP');
                $mop->save($op);
				
                //Mise à jour de la table de domiciliation
                foreach ($selection as $sel) {
                    $result = $mdo->find($sel['code_domici'], $do);
                    if ($result) {
                        $do->setMontant_domicilier($do->getMontant_domicilier() - $sel['mt_domici']);
                        $mdo->update($do);
                        $find_cnpgcp = $mcnp->findCnpByDomiGcp($sel['code_domici']);
                        if ($find_cnpgcp != null) {
                            $nb_credit = count($find_cnpgcp);
                            for ($j = 0; $j <= $nb_credit - 1; $j++) {
                                $res_cnp = $find_cnpgcp[$j];
                                //Récupération du montant effectif de la domiciliation dans eu_detail_domicilie
                                $mont_domi = 0;
                                $find_ddo = $mddo->find($sel['code_domici'],$res_cnp->getId_credit(),$ddo);
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
                                $mcnp->update($cnp);
								
                                //Récupération des informations du crédit
                                $find_cred = $mcred->find($res_cnp->getId_credit(),$cred);
                                if ($find_cred != false) {
                                   $code_compte = $cred->getCode_compte();
                                   $code_produit = $cred->getCode_produit();
                                   $code_membre = $cred->getCode_membre();
                                   $compte_source = $cred->getCompte_source();
                                }
                                //Création du cncs r et nr à la source smc
                                $smc = new Application_Model_EuSmc();
                                $m_smc = new Application_Model_EuSmcMapper();
								$id_smc = $m_smc->findConuter() + 1;
                                $smc->setId_smc($id_smc)
								    ->setId_credit($res_cnp->getId_credit())
                                    ->setDate_smc($date_op->toString('yyyy-MM-dd'))
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
                                if (strpos($compte_source, "nr-ti") !== false) {
                                    $smc->setCode_smcipn($cred->getCode_bnp());
                                }
                                if (strpos($res_cnp->getType_cnp(), 'nr') !== false) {
                                    $smc->setType_smc('CNCSnr');
                                } else {
                                    $smc->setType_smc('CNCSr');
                                }
                                $m_smc->save($smc);
                                //Création de la domiciliation dans la table eu_gcp
                                $origine = $res_cnp->getOrigine_cnp();
                                $code_cat = '';
								
                                if ($origine = 'FGIr' or $origine = 'FGInr') {
                                    $code_cat = 'TPAGCI';
                                }
								
                                if ($origine = 'FGRPGr' or $origine = 'FGRPGnr') {
                                    $code_cat = 'TPAGCRPG';
                                }
								
								$id_gcp = $mgcp->findConuter() + 1;
                                $gcp->setId_gcp($id_gcp)
								    ->setCode_tegc($code_tegc)
                                    ->setCode_cat($code_cat)
                                    ->setCode_membre($acteur)
                                    ->setId_credit($res_cnp->getId_credit())
                                    ->setSource($res_cnp->getSource_credit())
                                    ->setDate_conso($date_op->toString('yyyy-MM-dd'))
                                    ->setMont_gcp($mont_domi)
                                    ->setMont_preleve(0)
                                    ->setReste($mont_domi);
                                $mgcp->save($gcp);
								
                                //Création du crédit consommer dans eu_credit_consommer
								$id_conso = $mcc->findConuter() + 1;
                                $cc->setId_consommation($id_conso)
								   ->setId_operation($compteur)
                                   ->setId_credit($res_cnp->getId_credit())
                                   ->setCode_membre($code_membre)
                                   ->setCode_membre_dist($acteur)
                                   ->setCode_compte($code_compte)
                                   ->setCode_produit($code_produit)
                                   ->setMont_consommation($mont_domi)
                                   ->setDate_consommation($date_op->toString('yyyy-MM-dd'))
                                   ->setHeure_consommation($date_op->toString('HH:mm:ss'));
                                $mcc->save($cc);
                            }
                        } else {
                            $this->view->data = 'no_code';
                            $db->rollback();
                            return;
                        }
                    }
                }
                $num_compte = 'NB-TPAGCP-' . $acteur;
                //Création ou mise à jour du compte tpagcp
                $find_compte = $mcompte->find($num_compte, $compte);
                if ($find_compte == true) {
                    $compte->setSolde($compte->getSolde() + $mt_transfert);
                    $mcompte->update($compte);
                } else {
                    $compte->setCode_membre(null)
					       ->setCode_membre_morale($acteur)
                            ->setCode_cat('tpagcp')
                            ->setSolde($mt_transfert)
                            ->setDate_alloc($date_op->toString('yyyy-MM-dd'))
                            ->setCode_compte($num_compte)
                            ->setLib_compte('tpagcp')
                            ->setDesactiver(0);
                    $mcompte->save($compte);
                }
                //Mise à jour de la table tegc
                $find_tegc = $mtegc->find($code_tegc, $tegc);
                if ($find_tegc) {
                    $tegc->setMontant($tegc->getMontant() + $mt_transfert);
					$tegc->setSolde_tegc($tegc->getSolde_tegc() + $mt_transfert);
                    $mtegc->update($tegc);
                } else {
                    $this->view->data = 'erreur_te';
                    $db->rollback();
                    return;
                }
                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                $this->view->message = $message;
                $this->view->data = $message;
                return;
            }
        }
    }

    public function rembourseAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function rembourselistAction() {
        $date_deb = $_GET["date_deb"];
        $date_fin = $_GET["date_fin"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select();
        $select->setIntegrityCheck(false);
        $select->where('eu_operation.id_utilisateur = ?', $user->id_utilisateur);
        $select->where('eu_operation.code_membre = ?', $user->code_membre);
        if ($date_deb == '' and $date_fin == '') {
            $datedeb = '%';
            $select->where('_operation.date_op like ?', $datedeb);
        } else if ($date_deb == '') {
            $date2 = explode("/", $date_fin);
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('eu_operation.date_op <= ?', $datefin);
        } else if ($date_fin == '') {
            $date1 = explode("/", $date_deb);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('eu_operation.date_op >= ?', $datedeb);
        } else {
            $date1 = explode("/", $date_deb);
            $date2 = explode("/", $date_fin);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('eu_operation.date_op >= ?', $datedeb);
            $select->where('eu_operation.date_op <= ?', $datefin);
        }
        $select->where('type_op = ?', 'TGCP');
        $select->order('date_op asc');
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
        $totmont = 0;
        foreach ($alloc as $row) {
            $totmont+=$row->montant_op;
            $date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $heure_op = new Zend_Date($row->heure_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $date_op->toString('dd/mm/yyyy'),
                $heure_op->toString('hh:mm:ss'),
                $row->montant_op
            );
            $i++;
        }
        $responce['userdata']['heure_op'] = 'Total:';
        $responce['userdata']['mt_transfert'] = $totmont;
        $this->view->data = $responce;
    }

    public function changeAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre_morale;
        }
        $this->view->data = $data;
    }

    public function changemoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $select->where('type_membre=?', 'M');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function changephysAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $select->where('type_membre=?', 'P');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
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
            $select = $tcredit->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                    ->where('code_produit in(?)', $produit)
                    ->where('code_membre in(?)', $tab_clt)
                    ->where('krr like ?', 'N')
                    ->where('code_compte like ?', 'NB%')
                    ->where('domicilier like ?', 0)
                    ->where('affecter like ?', 1)
                    ->join('eu_capa_affecter', 'eu_capa_affecter.id_credit = eu_compte_credit.id_credit');
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
                $prod = $row->code_produit;
                $date_fin = new Zend_Date($row->date_octroi, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->id_credit;
                $responce['rows'][$i]['cell'] = array(
                    $row->code_membre,
                    $prod,
                    $row->montant_place,
                    $row->montant_credit,
                    $row->montant_credit,
                    $date_fin->toString('dd/MM/yyyy'),
                    $row->id_credit,
                    $row->duree_renouvellement,
                    $row->mont_invest,
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
        $mt_domi = $_GET['mt_obtenu'];
        $nb_periode = $_GET['nb_periode'];
        $ress = 'nr';
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $mcapaa = new Application_Model_EuCapaAffecterMapper();
        $capaa = new Application_Model_EuCapaAffecter();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $acteur = $user->code_membre;
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $nb_jr = ceil($nb_periode * 30);
                $date->addDay($nb_jr);
                $date_echue = $date;
                //Mise à jour des comptes crédits
                $cumul_credit = 0;
                $test = false;
                foreach ($selection as $sel) {
                    //Contrôle de l'existence de la domiciliation du crédit
                    $find_cred = $cm->findByCredDomi($sel['code_credit'], 2);
                    if ($find_cred != null) {
                        $test = true;
                        $db->rollback();
                        $this->view->data = 'bad_domi';
                        return;
                    } else {
                        $result = $cm->find($sel['code_credit'], $cr);
                        if ($result) {
                            $cumul_credit+=$sel['mt_credit'];
                            $cr->setMontant_credit($cr->getMontant_credit() - $sel['mt_credit']);
                            $cr->setDomicilier(2);
                            if ($acteur == $cr->getCode_membre()) {
                                $this->view->data = 'vol';
                                return;
                            } else {
                                $cm->update($cr);
                            }
                        }
                    }
                }
                if ($test == false) {
                    //###Traitement généraux et standard pour tout les type de domiciliation###
                    //Enregistrement dans la table de domiciliation
                    $do->setMontant_subvent($mt_domi);
                    $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                    $do->setCode_domicilier($code_domici);
                    $do->setCode_membre_beneficiaire($user->code_membre);
                    $do->setCode_membre_assureur($user->code_membre);
                    $do->setCat_ressource($ress);
                    $do->setMontant_domicilier($cumul_credit);
                    if ($mt_domi <= $cumul_credit) {
                        $do->setDomicilier('o');
                        $do->setDuree_renouvellement($nb_periode);
                        $do->setReste_duree(0);
                    } else {
                        $do->setDomicilier('N');
                        $do->setDuree_renouvellement($nb_periode);
                        $do->setReste_duree($nb_periode);
                    }
                    $do->setAccorder('N');
                    $do->setDate_domiciliation($date_domi->toString('yyyy-MM-dd'));
                    $type_domi = 'TEGCP';
                    $do->setType_domiciliation($type_domi);
                    $do->setCode_smcipn(null);
                    $do->setCode_smcipnp(null);
                    $do->setId_utilisateur($user->id_utilisateur);
                    $dom = new Application_Model_DbTable_EuDomiciliation();
                    $code_dom = $dom->find($code_domici);
                    if (count($code_dom) < 1) {
                        $mdo->save($do);
                    } else {
                        $this->view->data = 'cool';
                        return;
                    }
                    //Enregistrement dans la table detail_domicilie
                    $mtab = array();
                    foreach ($selection as $tab) {
                        $dod->setCode_domicilier($code_domici);
                        $dod->setId_credit($tab['code_credit']);
                        $dod->setCode_membre($tab['num_membre']);
                        $dod->setMontant_credit($tab['mt_credit']);
                        $dod->setUtiliser(1);
                        $mdod->save($dod);
                        $mtab = $tab['num_membre'];
                    }
                    //Traitement spéciaux des nr et r
                    foreach ($selection as $sel) {
                        $result = $cm->find($sel['code_credit'], $cr);
                        //Diminution du montant du compte
                        $ret = $mcompte->find($cr->getCode_compte(), $compte);
                        if ($ret) {
                            $compte->setSolde($compte->getSolde() - $sel['mt_credit']);
                            $mcompte->update($compte);
                        }
                        //Mise à jour du code_domicilier dans la table capa_affecter
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
                        //Mise à jour de la table cnp cas du nr pck comme celui du nr pre
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
                            $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                            $cnp->setTransfert_gcp($cnp_res->getTransfert_gcp());
                            $cnp->setOrigine_cnp($cnp_res->getOrigine_cnp());
                            $m_cnp->update($cnp);
                        }
                    }
                    $db->commit();
                    $this->view->data = 'good';
                    $this->view->mtab = $mtab;
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

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            if (substr($num_membre,19,1) == 'P') {
                $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
            } else {
                $data = strtoupper($result->raison_sociale);
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function modifbenefAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $new_benf = $_GET['new_benef'];
        $code_domici = $_GET['code_domici'];
        $mt_domi = $_GET['mt_domi'];
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mop = New Application_Model_EuOperationMapper();
        $op = new Application_Model_EuOperation();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_op = clone $date;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Mise à jour du numéro de bénéficiaire dans la date 
            $find_domi = $mdo->find($code_domici, $do);
            if ($find_domi) {
                $do->setCode_membre_beneficiaire($new_benf);
                $mdo->update($do);
            }
            //Enregistrement dans la table opération
            $compteur = $mop->findConuter() + 1;
            $op->setId_operation($compteur)
                    ->setDate_op($date_op->toString('yyyy-MM-dd'))
                    ->setHeure_op($date_op->toString('hh:mm:ss'))
                    ->setId_utilisateur($user->id_utilisateur)
                    ->setCode_membre($new_benf)
                    ->setMontant_op($mt_domi)
                    ->setCode_produit('GCP')
                    ->setLib_op('Changement du bénéficiaire de la domiciliation')
                    ->setType_op('CBD')
                    ->setCode_cat('TPAGCP');
            $mop->save($op);
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
            $this->view->message = $message;
            $this->view->data = 'bad';
            return;
        }
    }

    public function arretdomiAction() {
        //$this->_helper->layout->disableLayout();
    }

    public function arretdomilistAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $_GET["code_membre"];
        $date_domi = $_GET["date_domi"];
        $type_domi = 'tegcp';
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDetailDomicilie();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_domiciliation', 'eu_domiciliation.code_domicilier = eu_detail_domicilie.code_domicilier')
                ->where('eu_domiciliation.accorder = ?', 'N')
                ->where('eu_domiciliation.type_domiciliation like ?', $type_domi)
                ->join(array('m' => 'eu_membre'), 'm.code_membre = eu_domiciliation.code_membre_beneficiaire', array('raison_sociale'))
                ->join(array('c' => 'eu_compte_credit'), 'c.id_credit = eu_detail_domicilie.id_credit', array('id_credit'))
                ->where('c.domicilier != ?', 0)
                ->where('eu_detail_domicilie.utiliser = ?', 1)
                ->where('eu_domiciliation.id_utilisateur like ?', $user->id_utilisateur);
        if ($code_membre == '') {
            $code_memb = '%';
            $select->where('eu_detail_domicilie.code_membre like ?', $code_memb);
        } else {
            $select->where('eu_detail_domicilie.code_membre like ?', $code_membre);
        }
        if ($date_domi == '') {
            $datedom = '%';
            $select->where('eu_domiciliation.date_domiciliation like ?', $datedom);
        } else {
            $date1 = explode("/", $date_domi);
            $datedom = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('eu_domiciliation.date_domiciliation = ?', $datedom);
        }
        $select->order('eu_domiciliation.date_domiciliation', 'desc');
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
            $date_dom = new Zend_Date($row->date_domiciliation, Zend_Date::ISO_8601);
            if ($row->domicilier == 'N') {
                $accord = 'En cours';
            } else {
                $accord = 'Terminer';
            }
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
                $row->id_credit,
                $row->code_domicilier,
                $row->code_membre,
                $row->montant_credit,
                $row->code_membre_beneficiaire,
                ucfirst($row->raison_sociale),
                $date_dom->toString('dd/MM/yyyy'),
                $accord,
                $row->type_domiciliation,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function arreterAction() {
        $selection = array();
        $selection = $_GET['lignes'];
        $mcr = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mddo = new Application_Model_EuDetailDomicilieMapper();
        $ddo = new Application_Model_EuDetailDomicilie();
        $mlouer = New Application_Model_EuLouerMapper();
        $mappart = New Application_Model_EuAppartementMapper();
        $appart = new Application_Model_EuAppartement();
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                foreach ($selection as $sel) {
                    $result = $mcr->find($sel['id_credit'], $cr);
                    if ($result) {
                        //Valeur du champ domicilier pr les crédits affecter au tegcp(2) 
                        $cr->setDomicilier(0);
                        $mcr->update($cr);
                    }
                    //Mise à jour du champ utiliser de eu_domiciliation
                    $find_ddomi = $mddo->findByCreditDomi($sel['code_domici'], $sel['id_credit']);
                    if ($find_ddomi != null) {
                        $ddo->setCode_domicilier($find_ddomi->getCode_domicilier());
                        $ddo->setId_credit($find_ddomi->getId_credit());
                        $ddo->setCode_membre($find_ddomi->getCode_membre());
                        $ddo->setMontant_credit($find_ddomi->getMontant_credit());
                        $ddo->setUtiliser(0);
                        $mddo->update($ddo);
                    }
                    //Récupération de l'id de l'appartement en cas de location
                    $find_louer = $mlouer->findByDomiciliation($sel['code_domici']);
                    $id_appart = '';
                    if ($find_louer != null) {
                        $id_appart = $find_louer->getId_appartement();
                        //Mise à jour du statut de l'appartement en cas d'arrêt de la domiciliation
                        $find_appart = $mappart->find($id_appart, $appart);
                        if ($find_appart) {
                            $appart->setStatut(0);
                            $mappart->update($appart);
                        }
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                $this->view->message = $message;
                $this->view->data = 'erreur';
                return;
            }
        }
    }

    public function csvexportAction() {
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=export.xls");
        header("Pragma: no-cache");
        $buffer = $_POST['csvBuffer'];
        try {
            echo $buffer;
        } catch (Exception $e) {
            
        }
    }

    public function domicilierloyerAction() {
        
    }

    public function recuproprioAction() {
        $num_membre = $_GET['num_membre'];
        $tabela = new Application_Model_DbTable_EuProprietaire();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join(array('m' => 'eu_membre'), 'm.code_membre = eu_proprietaire.code_membre_pro', array('nom_membre', 'prenom_membre'))
                ->join(array('b' => 'eu_membre'), 'b.code_membre = eu_proprietaire.code_membre_ag', array('raison_sociale'))
                ->where('eu_proprietaire.code_membre_pro = ?', $num_membre);
        $proprio = $tabela->fetchAll($select);
        $data = array();
        foreach ($proprio as $row) {
            $data[0] = $row->nom_membre . ' ' . $row->prenom_membre;
            $data[1] = $row->code_membre_ag;
            $data[2] = $row->raison_sociale;
        }
        $this->view->data = $data;
    }

    public function changemaisonAction() {
        $code_membre_pro = $_GET['code_membre_pro'];
        //Récupération de l'id du propriétaire
        $mpro = New Application_Model_EuProprietaireMapper();
        $findpro = $mpro->findProprio($code_membre_pro);
        $id_proprio = '';
        if ($findpro != null) {
            $id_proprio = $findpro->getId_proprietaire();
        }
        //Récupération des codes membres des maisons du propriétaire
        $data = array();
        $tab = new Application_Model_DbTable_EuMaison();
        $sel = $tab->select();
        $sel->setIntegrityCheck(false)
                ->where('id_proprietaire like ?', $id_proprio);
        $result = $tab->fetchAll($sel);
        foreach ($result as $value) {
            $data[] = $value->code_membre;
        }
        $this->view->data = $data;
    }

    public function recupmaisonAction() {
        $code_membre = $_GET['code_membre'];
        $tabela = new Application_Model_DbTable_EuMaison();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join(array('a' => 'eu_appartement'), 'a.id_maison = eu_maison.id_maison', array('type_appartement'))
                ->where('a.statut = 0')
                ->where('eu_maison.code_membre like ?', $code_membre);
        $maison = $tabela->fetchAll($select);
        $data = array();
        foreach ($maison as $row) {
            $data[0] = ucfirst($row->designation);
            $data[1] = ucfirst($row->type_maison);
            $data[2] = ucfirst($row->rue);
        }
        $this->view->data = $data;
    }

    public function recupappartAction() {
        $code_membre = $_GET['code_membre'];
        $tabela = new Application_Model_DbTable_EuMaison();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join(array('a' => 'eu_appartement'), 'a.id_maison = eu_maison.id_maison', array('id_appartement', 'type_appartement'))
                ->where('a.statut = 0')
                ->where('eu_maison.code_membre like ?', $code_membre);
        $maison = $tabela->fetchAll($select);
        $data = array();
        $i = 0;
        foreach ($maison as $value) {
            $data[$i][1] = $value->id_appartement;
            $data[$i][2] = ucfirst($value->type_appartement);
            $i++;
        }
        $this->view->data = $data;
    }

    public function changeappartAction() {
        $id_appart = $_GET['id_appart'];
        $data = array();
        $app_db = new Application_Model_DbTable_EuAppartement();
        $find_app = $app_db->find($id_appart);
        if (count($find_app) == 1) {
            $result = $find_app->current();
            $data[0] = $result->prix_location;
            $data[1] = $result->nb_piece;
            $data[2] = $result->wc_douche_interne;
            $data[3] = $result->terasse;
            $data[4] = $result->cuisine;
            $data[5] = $result->garage;
        } else {
            $data[0] = '';
            $data[1] = '';
            $data[2] = 0;
            $data[3] = 0;
            $data[4] = 0;
            $data[5] = 0;
        }
        $this->view->data = $data;
    }

    public function createloyerAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $ress = $_GET['ress'];
        $mont_loyer = $_GET['mont_loyer'];
        $mt_obtenu = $_GET['mt_obtenu'];
        $code_ag = $_GET['code_ag'];
        $code_maison = $_GET['code_maison'];
        $id_appart = $_GET['id_appart'];
        $code_proprio = $_GET['code_proprio'];
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
        $mcompte = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        $mdo = new Application_Model_EuDomiciliationMapper();
        $do = new Application_Model_EuDomiciliation();
        $mdod = new Application_Model_EuDetailDomicilieMapper();
        $dod = new Application_Model_EuDetailDomicilie();
        $mlouer = new Application_Model_EuLouerMapper();
        $louer = new Application_Model_EuLouer();
        $mappart = new Application_Model_EuAppartementMapper();
        $appart = new Application_Model_EuAppartement();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        $date_echue = new Zend_Date(Zend_Date::ISO_8601);
        $acteur = $user->code_membre;
        $code_domici = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMddHHmmss');
        $code_dom = strtoupper($ress) . $acteur . $date_domi->toString('yyyyMMdd');
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //###Contrôle du total des crédits domiciliés avec le montant du remboursement###
                if ($mt_obtenu < $mont_loyer) {
                    $this->view->data = 'err_domici';
                    $db->rollback();
                    return;
                } else {
                    //###Traitement généraux et standard pour tout les type de domiciliation###
                    //Mise à jour des comptes crédits
                    $cumul_credit = 0;
                    $mont_util = 0;
                    $test = false;
                    foreach ($selection as $sel) {
                        //Contrôle de l'existence de la domiciliation du crédit
                        $id_credit = $sel['code_credit'];
                        $find_cred = $cm->findByCredDomi($id_credit, 2);
                        if ($find_cred != null) {
                            $test = true;
                            $db->rollback();
                            $this->view->data = 'bad_domi';
                            return;
                        } else {
                            $result = $cm->find($sel['code_credit'], $cr);
                            if ($result) {
                                //Valeur du champ domicilier pr les crédits affecter au tegcp(2) 
                                $cr->setDomicilier(2);
                                //Ne cumuler que les crédits non consommés
                                if ($cr->getMontant_credit() >= $sel['mt_utilise']) {
                                    $mont_util = $sel['mt_utilise'];
                                } else {
                                    $mont_util = 0;
                                }
                                $cumul_credit+=$mont_util;
                                $cr->setMontant_credit($cr->getMontant_credit() - $mont_util);
                                if ($acteur == $cr->getCode_membre()) {
                                    $this->view->data = 'vol';
                                    $db->rollback();
                                    return;
                                } else {
                                    $cm->update($cr);
                                }
                            }
                            //Mise à jour du compte
                            $ret = $mcompte->find($cr->getCode_compte(), $compte);
                            if ($ret) {
                                $compte->setSolde($compte->getSolde() - $mont_util);
                                $mcompte->update($compte);
                            }
                        }
                    }
                    if ($test == false) {
                        //Enregistrement dans la table de domiciliation
                        $do->setMontant_subvent($mt_obtenu); //Montant cumul des crédits initiaux
                        $do->setDate_echue($date_echue->toString('yyyy-mm-dd'));
                        $do->setCode_domicilier($code_domici);
                        $do->setCode_membre_beneficiaire($user->code_membre);
                        $do->setCode_membre_assureur($user->code_membre);
                        $do->setCat_ressource($ress);
                        $do->setMontant_domicilier($cumul_credit);
                        if ($ress == 'nr') {
                            $do->setDomicilier('O');
                            $do->setDuree_renouvellement(1);
                            $do->setReste_duree(0);
                        } else if ($ress == 'r') {
                            $do->setDomicilier('n');
                            $do->setDuree_renouvellement(0);
                            $do->setReste_duree(0);
                        }
                        $do->setAccorder('N');
                        $do->setDate_domiciliation($date_domi->toString('yyyy-MM-dd'));
                        $type_domi = 'tegcp';
                        $do->setType_domiciliation($type_domi);
                        $do->setCode_smcipn(null);
                        $do->setCode_smcipnp(null);
                        $do->setId_utilisateur($user->id_utilisateur);
                        $dom = new Application_Model_DbTable_EuDomiciliation();
                        $code_dom = $dom->find($code_domici);
                        if (count($code_dom) < 1) {
                            $mdo->save($do);
                        } else {
                            $this->view->data = 'cool';
                            $db->rollback();
                            return;
                        }
                        //Enregistrement dans la table detail_domicilie
                        $mtab = array(array());
                        $i = 0;
                        foreach ($selection as $tab) {
                            $dod->setCode_domicilier($code_domici);
                            $dod->setId_credit($tab['code_credit']);
                            $dod->setCode_membre($tab['num_membre']);
                            $dod->setMontant_credit($tab['mt_utilise']);
                            $dod->setUtiliser(1);
                            $mdod->save($dod);
                            $mtab[$i] = $tab['num_membre'];
                            $i+=1;
                        }
                        //Mise à jour de la table eu_cnp
                        foreach ($selection as $sel) {
                            $result = $cm->find($sel['code_credit'], $cr);
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
                        //Récupération de l'id_maison à partir de code_membre_maison
                        $mhouse = new Application_Model_EuMaisonMapper();
                        //$house = new Application_Model_EuMaison();
                        $find_house = $mhouse->findByMembre($code_maison);
                        $id_maison = '';
                        if ($find_house != null) {
                            $id_maison = $find_house->getId_maison();
                        }
                        //Récupération de l'id_proprietaire à partir de code_membre_proprietaire
                        $mproprio = new Application_Model_EuProprietaireMapper();
                        //$proprio = new Application_Model_EuProprietaire();
                        $find_proprio = $mproprio->findProprio($code_proprio);
                        $id_proprio = '';
                        if ($find_proprio != null) {
                            $id_proprio = $find_proprio->getId_proprietaire();
                        }
                        //Enregistrement dans la table eu_louer
                        $louer->setDuree_location(null)
                                ->setDate_location($date_domi->toString('yyyy-MM-dd'))
                                ->setMont_loyer($mont_loyer)
                                ->setId_proprietaire($id_proprio)
                                ->setCode_domiciliation($code_domici)
                                ->setCode_membre_ag($code_ag)
                                ->setCode_membre_loc($mtab[0])
                                ->setId_maison($id_maison)
                                ->setId_appartement($id_appart)
                                ->setId_utilisateur($user->id_utilisateur);
                        $mlouer->save($louer);
                        //Mise à jour de la table eu_appartement
                        $find_appart = $mappart->find($id_appart, $appart);
                        if ($find_appart) {
                            $appart->setStatut(1);
                            $mappart->update($appart);
                        }
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                $this->view->mtab = $mtab;
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                $this->view->data = 'bad';
                return;
            }
        }
    }

}

?>
