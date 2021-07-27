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
 
 
class EuReglementMfController extends Zend_Controller_Action {
    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'caps' || $group == 'mf_bank') {
            $menu = "<li><a href=\"/eu-reglement-mf/activer\">Activer ressources</a></li>".
			        "<li><a href=\"/eu-reglement-mf/new\">Rachat</a></li>".
					"<li><a href=\"/eu-reglement-mf/listactivation\">Liste des activations</a></li>".
                    "<li><a href=\"/eu-reglement-mf/listreglt\">Liste des dépôts</a></li>";
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
            if ($group != 'caps' && $group != 'mf_bank') {
               $this->view->user = $user;
               return $this->_redirect('index2');
            }
            $this->view->user = $user;
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

	
    public function newAction() {
        
    }
	
	
	public function activerAction() {
        
    }
	
	public function datadmfAction() {
        $bon = $_GET["bon"];
        $nom = $_GET["nom"];
        $prenom = $_GET["prenom"];
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 1000);
        $sidx = $this->_request->getParam("sidx", 'id_mf11000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuRepartitionMf11000();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_detail_mf11000', 'eu_detail_mf11000.id_mf11000 = eu_repartition_mf11000.id_mf11000')
                ->join('eu_membre_fondateur11000', 'eu_membre_fondateur11000.num_bon = eu_detail_mf11000.num_bon', array('nom', 'prenom'))
                ->where('eu_repartition_mf11000.payer like ?', 0)
                ->order('eu_repartition_mf11000.code_mf11000  asc');
        if ($bon != "") {
            $select->where('eu_repartition_mf11000.code_mf11000 like ?', $bon);
        }
        if ($nom != "") {
            $select->where('eu_membre_fondateur11000.nom like ?', '%' . $nom . '%');
        }
        if ($prenom != "") {
            $select->where('eu_membre_fondateur11000.prenom like ?', '%' . $prenom . '%');
        }
        if ($nom != "" && $prenom != "") {
            $select->where('eu_membre_fondateur11000.nom like ?', '%' . $nom . '%');
            $select->where('eu_membre_fondateur11000.prenom like ?', '%' . $prenom . '%');
        }
        if ($bon != "" && $nom != "") {
            $select->where('eu_membre_fondateur11000.nom like ?', '%' . $nom . '%');
            $select->where('eu_repartition_mf11000.code_mf11000 like ?', $bon);
        }
        if ($bon != "" && $prenom != "") {
            $select->where('eu_repartition_mf11000.code_mf11000 like ?', $bon);
            $select->where('eu_membre_fondateur11000.prenom like ?', '%' . $prenom . '%');
        }
        if ($bon != "" && $nom != "" && $prenom != "") {
            $select->where('eu_repartition_mf11000.code_mf11000 like ?', $bon);
            $select->where('eu_membre_fondateur11000.nom like ?', '%' . $nom . '%');
            $select->where('eu_membre_fondateur11000.prenom like ?', '%' . $prenom . '%');
        }
        $alloc = $tabela->fetchAll($select);
        $count = count($alloc);
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
        $totmont = 0;
        foreach ($agences as $row) {
            $totmont+=$row->mont_rep;
            $responce['rows'][$i]['id'] = $row->id_rep;
            $responce['rows'][$i]['cell'] = array(
                $row->code_mf11000,
                $row->code_membre,
                strtoupper($row->nom),
                ucfirst($row->prenom),
                $row->date_rep,
                $row->solde_rep,
                $row->solde_rep,
                $row->id_rep,
                $row->num_bon,
            );
            $i++;
        }
        $responce['userdata']['date_rep'] = 'Total:';
        $responce['userdata']['mont_recu'] = $totmont;
        $this->view->data = $responce;
    }
	
	
	public function ancienrecupAction() {
	        $num_membre = $_GET['num_membre'];
	        $membre_db = new Application_Model_DbTable_EuAncienMembre();
		    $membre_find = $membre_db->find($num_membre);
		    $result = $membre_find->current();
			if (count($membre_find) == 1) {
		        if (substr($num_membre,19,1) == "P") {
	                $data[0] = strtoupper($result->nom_membre).' '.ucfirst($result->prenom_membre);
	            } else {
			        $data[0] = strtoupper($result->raison_sociale);
			    }
			} else {
			   $data = '';
			}
	    $this->view->data = $data;
	}
	
	
    public function recupraisonAction() {
	    $num_membre = $_GET['num_membre'];
	    $membre_db = new Application_Model_DbTable_EuMembre();
		$mmembre_db = new Application_Model_DbTable_EuMembreMorale();
		if (substr($num_membre,19,1) == "P") {
	        $membre_find = $membre_db->find($num_membre);
            if (count($membre_find) == 1) {			
	           $result = $membre_find->current();
               $data[0] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
	        } else {
			   $data = '';
			}
	    } else {
		    $mmembre_find = $mmembre_db->find($num_membre);
			if (count($mmembre_find) == 1) {
               $result = $mmembre_find->current();
               $data[0] = strtoupper($result->raison_sociale);
            } else {
               $data = '';
            }
		
		
		}
		$this->view->data = $data;
	}

	
	public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
		$type_mf = $_GET['type_mf'];
		if ($type_mf != 'TSRE') {
		   $code_compte = 'NN-TS'.$type_mf.'-'.$num_membre;
		} else {
           $code_compte = 'NN-'.$type_mf.'-'.$num_membre;
        }		
		$compte_db = new Application_Model_DbTable_EuCompte();
        $membre_db = new Application_Model_DbTable_EuMembre();
		$mmembre_db = new Application_Model_DbTable_EuMembreMorale();
		
		if (substr($num_membre,19,1) == "P") {
            $membre_find = $membre_db->find($num_membre);
            $select = $compte_db->select();
            $select->where('code_compte like ?',$code_compte);
            $results = $compte_db->fetchAll($select);
			
            if (count($membre_find) == 1 && count($results) > 0) {
                $result = $membre_find->current();
                $data[0] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
				$data[1] = $results->current()->solde;
            } else {
               $data = '';
            }
		} else {
		    $mmembre_find = $mmembre_db->find($num_membre);
			$select = $compte_db->select();
            $select->where('code_compte like ?',$code_compte);
            $results = $compte_db->fetchAll($select);
            if (count($mmembre_find) == 1 && count($results) > 0) {
               $result = $mmembre_find->current();
               $data[0] = strtoupper($result->raison_sociale);
			   $data[1] = $results->current()->solde;
            } else {
               $data = '';
            }
		}
        $this->view->data = $data;
    }
	
	
	
    public function payerAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;
        $selection = array();
        $selection = $_GET['lignes'];
        //$mt_transfert = $_GET['mt_transfert'];
        $reglt_mf = new Application_Model_EuReglementMf();
        $reglt_mapper = new Application_Model_EuReglementMfMapper();
        $compte = new Application_Model_EuCompte();
        $mcompte = new Application_Model_EuCompteMapper();
        $dsmsmoney = new Application_Model_EuDetailSmsmoney();
        $mdsmsmoney = new Application_Model_EuDetailSmsmoneyMapper();
        $rep = new Application_Model_EuRepartitionMf11000();
        $repm = new Application_Model_EuRepartitionMf11000Mapper();
        $rreg = new Application_Model_EuRepReglement();
        $rregm = new Application_Model_EuRepReglementMapper();
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $code_membre = '';
                $cumul_reglt = 0;
                foreach ($selection as $sel) {
                    //Contrôle du montant racheté par rapport au montant reçu
                    if ($sel['mont_recu'] < $sel['mont_reglt']) {
                        $db->rollback();
                        $this->view->data = 'rachat';
                        return;
                    }
                    $code_membre = $sel['code_membre'];
                    $cumul_reglt+=$sel['mont_reglt'];
                }
                //Enregistrement dans la table eu_règlement
                $maxreglt = $reglt_mapper->findMaxReglt() + 1;
                $reglt_mf->setId_reglt_mf($maxreglt);
                $reglt_mf->setMont_reglt_mf($cumul_reglt);
                $reglt_mf->setCode_membre($code_membre);
                $reglt_mf->setDate_reglt_mf($date_idd->toString('yyyy-mm-dd'));
                $reglt_mf->setId_utilisateur($user->id_utilisateur);
                $reglt_mf->setType_mf('MF11000');
                $reglt_mf->setType_reglt_mf('Dépôt vente');
                $reglt_mapper->save($reglt_mf);

                foreach ($selection as $sel) {
                    $id_rep = $sel['id_rep'];
                    //Récupération des infos de la répartition et mise à jour du compte de répartition
                    $find_rep = $repm->find($id_rep, $rep);
                    if ($find_rep == true) {
                        $rep->setMont_reglt($rep->getMont_reglt() + $sel['mont_reglt']);
                        $rep->setSolde_rep($rep->getSolde_rep() - $sel['mont_reglt']);
                        if ($rep->getSolde_rep() == 0) {
                            $rep->setPayer(1);
                        }
                        $repm->update($rep);
                    }
                    //Enregistrement dans la table eu_rep_reglement
                    $find_rep_reg = $rregm->find($maxreglt, $id_rep, $rreg);
                    if ($find_rep_reg == false) {
                        $rreg->setId_reglt_mf($maxreglt);
                        $rreg->setId_rep($id_rep);
                        $rreg->setMont_rep_reglt($sel['mont_reglt']);
                        $rregm->save($rreg);
                    }
                    //Mise à jour des comptes de transfert des MF11000
                    $code_compte_mf = 'nn-tr-' . $sel['code_mf11000'];
                    $code_compte_dist = 'nn-tr-' . $user->code_membre;
                    $find_compte = $mcompte->find($code_compte_mf, $compte);
                    if ($find_compte != false) {
                        $compte->setSolde($compte->getSolde() - $sel['mont_reglt']);
                        $mcompte->update($compte);
                    } else {
                        $db->rollback();
                        $this->view->data = 'erreur';
                        return;
                    }
                    //Mise à jour du compte de transfert du distributeur
                    $find_compte_dist = $mcompte->find($code_compte_dist, $compte);
                    if ($find_compte_dist != false) {
                        $compte->setSolde($compte->getSolde() + $sel['mont_reglt']);
                        $mcompte->update($compte);
                    } else {
                        //Création du compte de transfert du distributeur
                        $compte->setCode_cat('tr')
                                ->setCode_membre($user->code_membre)
                                ->setCode_compte($code_compte_dist)
                                ->setCode_type_compte('nn')
                                ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                ->setDesactiver(0)
                                ->setLib_compte('Compte de recharge')
                                ->setSolde($sel['mont_reglt']);
                        $mcompte->save($compte);
                    }
                    //Création du détail des transferts des eu_smsmoney
                    if ($sel['code_membre'] != '') {
                        $code_membre = $sel['code_membre'];
                    } else {
                        $code_membre = null;
                    }
                    $dsmsmoney
                            ->setNum_bon($sel['num_bon'])
                            ->setCode_membre($code_membre)
                            ->setDate_allocation($date_idd->toString('yyyy-mm-dd'))
                            ->setId_utilisateur($user->id_utilisateur)
                            ->setCode_membre_dist($user->code_membre)
                            ->setCreditcode(null)
                            ->setMont_sms($sel['mont_reglt'])
                            ->setMont_vendu(0)
                            ->setSolde_sms($sel['mont_reglt'])
                            ->setOrigine_sms('mf');
                    $mdsmsmoney->save($dsmsmoney);
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

    public function listregltAction() {
        
    }

	
	
	public function dataAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", '200000');
           $sord = $this->_request->getParam("sord", 'asc');
		   
		   $tabela = new Application_Model_DbTable_EuOperation();
           $select = $tabela->select();
		   $select->where('id_utilisateur = ?',$user->id_utilisateur);
		   $select->where('lib_op like ?','Activation');
		   $select->order('id_operation  desc');
		   
		    $operations = $tabela->fetchAll($select);
            $count = count($operations);
            if ($count > 0) {
              $total_pages = ceil($count / $limit);
            } else {
              $total_pages = 0;
            }
            if ($page > $total_pages)
               $page = $total_pages;
               $op = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
               $responce['page'] = $page;
               $responce['total'] = $total_pages;
               $responce['records'] = $count;
               $i = 0;
               foreach ($op as $row) {
			      $date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
				  if($row->code_membre != null) { $code_membre = $row->code_membre;}
				  if($row->code_membre_morale != null) { $code_membre = $row->code_membre_morale;}
                  $responce['rows'][$i]['id'] = $row->id_operation;
                  $responce['rows'][$i]['cell'] = array(
                  $row->id_operation,
				  $date_op->toString('dd/MM/yyyy'),
                  $code_membre,
				  $row->code_produit,
                  $row->montant_op
               );
              $i++;
            }
            $this->view->data = $responce;
	
	}
	
	
	
    public function listingregltAction() {
        if (isset($_GET["code_membre_mf"])) { $code_membre_mf = $_GET["code_membre_mf"];} else{ $code_membre_mf ="";}
        if (isset($_GET["code_membre_dist"])) { $code_membre_dist = $_GET["code_membre_dist"];} else{ $code_membre_dist ="";}
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", '200000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuDetailSmsmoney();
        $select = $tabela->select();
		
		if($code_membre_mf !='') {
           $select->where('eu_detail_smsmoney.code_membre = ?',$code_membre_mf);
		} elseif($code_membre_dist !='') {
		   $select->where('eu_detail_smsmoney.code_membre_dist = ?',$code_membre_dist);
		} elseif($code_membre_mf !='' &&  $code_membre_dist !='') {
		   $select->where('eu_detail_smsmoney.code_membre = ?',$code_membre_mf);
		   $select->where('eu_detail_smsmoney.code_membre_dist = ?',$code_membre_dist);
		}
		
		$select->where('eu_detail_smsmoney.id_utilisateur = ?',$user->id_utilisateur);
        $select->order('eu_detail_smsmoney.id_detail_smsmoney  desc');
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
            $responce['rows'][$i]['id'] = $row->id_detail_smsmoney;
            $responce['rows'][$i]['cell'] = array(
                $row->id_detail_smsmoney,
                $row->code_membre,
                $row->code_membre_dist,
				$row->mont_sms,
                $row->mont_vendu,
				$row->solde_sms,
				$row->origine_sms
            );
            $i++;
        }
        $this->view->data = $responce;
    }
	
	public function numeroAction() {
        $data = array();
        $mf = new Application_Model_DbTable_EuMembreFondateur11000();
        $result = $mf->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->num_bon;
        }
        $this->view->data = $data;
    }

    public function detailAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $cm_mapper = new Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
        //Enregistrement dans le compte de distribution mf11000
        $v_num_compte = 'nn-' . 'tr-' . $user->code_membre;
        $retour = $cm_mapper->find($v_num_compte, $compte);
        if ($retour) {
            $this->view->solde = $compte->getSolde();
        }
    }

    public function consultAction() {


        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $compte = "nn-tr-" . $user->code_membre;

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'NEng');
        $sord = $this->_request->getParam("sord", 'asc');
        //$date = $this->_request->getParam("date_conso");
        $tabela = new Application_Model_DbTable_EuSmsmoney();

        $select = $tabela->select();
        $select->where('FromAccount = ?', $compte);

        $select->order('NEng', 'desc');
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
        //$tot_gcp = 0;
        //$tot_reste = 0;

        foreach ($achats as $row) {
            //$date_op = new Zend_Date($row->date_conso, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->NEng;
            $responce['rows'][$i]['cell'] = array(
                $row->DateTime,
                $row->FromAccount,
                $row->CreditAmount,
                $row->SentTo,
                $row->Motif
            );
            $tot_prel += $row->CreditAmount;
            // $tot_reste += $row->reste;
            $i++;
        }
        $responce['userdata']['creditamount'] = $tot_prel;
        $responce['userdata']['date'] = 'Total (' . $i . ')';
        //$responce['userdata']['reste'] = $tot_reste; 
        //$responce['userdata']['code_membre'] = 'Totaux:';

        $this->view->data = $responce;

        ////$select->__toString();
    }
	
	
	public function listactivationAction() {
	
	
	
	}
	
	
	
	
	public function doactiverAction() {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
		    if ($this->getRequest()->isPost()) {
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {
	                $montant = 0;
			        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
				    $anciencodemembre = $_POST['ancien_code_membre'];
				    $code_membre = $_POST['code_membre'];
		            $mode_fin = $_POST['mode_fin'];
		            $type_mf = $_POST['type_mf'];
			        $nn = new Application_Model_EuNn();
					$dmf = new Application_Model_EuDetailMf107();
					$mdmf = new Application_Model_EuDetailMf107Mapper();
					$mf107 = new Application_Model_EuMembreFondateur107();
					$mmf107 = new Application_Model_EuMembreFondateur107Mapper();
				    $t_nn = new Application_Model_DbTable_EuNn();
				    $comptecredit      = new Application_Model_EuAncienCompteCredit();
				    $comptecredit_map  = new Application_Model_EuAncienCompteCreditMapper();
			        $ancienmembre      = new Application_Model_EuAncienMembre();
		            $ancienmembre_map  = new Application_Model_EuAncienMembreMapper();
			        $anciencompte_nn   = new Application_Model_EuAncienCompte();
		            $anciencm_map      = new Application_Model_EuAncienCompteMapper();
			        $repmf11000        = new Application_Model_EuRepartitionMf11000();
			        $m_repmf11000      = new Application_Model_EuRepartitionMf11000Mapper();
				    $repmf107          = new Application_Model_EuRepartitionMf107();
			        $m_repmf107        = new Application_Model_EuRepartitionMf107Mapper();
				    $operation         = new Application_Model_EuOperation();
				    $mapper_op         = new Application_Model_EuOperationMapper();
				    $compte            = new Application_Model_EuCompte();
			        $cm_mapper         = new Application_Model_EuCompteMapper(); 
					$m_cnp = new Application_Model_EuCnpMapper();
					$compte_gene = new Application_Model_EuCompteGeneral();
                    $cg_mapper = new Application_Model_EuCompteGeneralMapper();
					
					$fgfn = new Application_Model_EuFgfn();
                    $fgfn_map = new Application_Model_EuFgfnMapper();
					$det_fg = new Application_Model_EuDetailFgfn();
                    $fg_mapper = new Application_Model_EuDetailFgfnMapper();
					
					$m_sqmaxui   = new Application_Model_EuBnpSqmaxMapper();
					$sqmaxui     = new Application_Model_EuBnpSqmax();
					$cc_mapper   = new Application_Model_EuCompteCreditMapper();
					
                    $cnp = new Application_Model_EuCnp();
					$fn = new Application_Model_EuFn();
                    $m_fn = new Application_Model_EuFnMapper();
                    $capa = new Application_Model_EuCapa();
                    $m_capa = new Application_Model_EuCapaMapper();
					$m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                    $credit_capa = new Application_Model_EuCompteCreditCapa();
					$membre      = new Application_Model_EuMembre();
					$membre_map  = new Application_Model_EuMembreMapper();
					$bmap = new Application_Model_EuCapsMapper();
                    $bnp = new Application_Model_EuCaps();
					$bnp = $bmap->fetchCapsByBeneficiaire($code_membre);
                    $fs_valeur = Util_Utils::getParametre('CAPS','valeur');
					
					 
					if ($mode_fin == 'bon')  { 
					    $num_bon = $_POST['num_bon'];
					    $mf = new Application_Model_EuMembreFondateur11000();
                        $mfm = new Application_Model_EuMembreFondateur11000Mapper();
						
                        //Récupération des informations du membre fondateur 11000
					    $find_mf = $mfm->find($num_bon,$mf);
					    $code_compte = 'NN-TR-'.$num_bon;
					    $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
					    $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
                        if ($result_nn && $find_mf != false) {						
					        $mfcredits = $m_repmf11000->fetchRepByNumBon($num_bon);    
							if($mf->getNb_repartition() < 32) {
						    for ($i = 1; $i <= 26; $i++)  { 
                                // insertion dans la table eu_repartition_mf11000
                                $id_rep = $m_repmf11000->findConuter() + 1;
								$repmf11000->setId_rep($id_rep);
								$repmf11000->setId_mf11000($num_bon);
                                $repmf11000->setCode_mf11000($num_bon);
                                $repmf11000->setCode_membre($mf->getCode_membre());
                                $repmf11000->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                $repmf11000->setMont_rep($mf->getSolde());
                                $repmf11000->setMont_reglt(0);
                                $repmf11000->setSolde_rep($mf->getSolde());
                                $repmf11000->setId_utilisateur($user->id_utilisateur);
                                $repmf11000->setPayer(0);
                                $m_repmf11000->save($repmf11000);
								//mise à jour du compte nn de transfert du MF11000
					            $anciencompte_nn->setSolde($anciencompte_nn->getSolde() + $mf->getSolde());
                                $anciencm_map->update($anciencompte_nn);
						    }
							    //Mise à jour de la table eu_membre_fondateur11000
                                $query = "update eu_membre_fondateur11000 set nb_repartition =(nb_repartition + 26) where num_bon ='$num_bon'";
                                $db->query($query);	
					        } else {
						        $db->rollback();
                                $this->view->data ="La ressource ".$type_mf." est deja active pour ce compte";
							    return;
						    }
							
							$mfcredits = $m_repmf11000->fetchRepByNumBon($num_bon);
						    $montant = $m_repmf11000->findsum();
				            if ($mfcredits != null && $montant > 0) {
					            $j = 0;
						        $reste = $m_repmf11000->findsum();
				                $nbre_credit = count($mfcredits);
					            while ($reste > 0 && $j < $nbre_credit) {
						            $mfcredit = $mfcredits[$j];
                                    $id = $mfcredit->getId_rep();
							        $findrep = $m_repmf11000->find($id,$repmf11000);
						            if ($reste >= $mfcredit->getSolde_rep()) {
						               //Mise à jour du compte crédit mf11000
                                       $reste = $reste - $mfcredit->getSolde_rep();
								       $mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
							           $mfcredit->setPayer(1);
								       $mfcredit->setSolde_rep(0);
                                       $m_repmf11000->update($mfcredit);			 							   
						            } else {
							           //Mise à jour du compte crédit mf11000
                                       $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
								       $mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                       $m_repmf11000->update($mfcredit);
						               $reste = 0;
						            }
							        $j++;
				                }
							
							    //Mise à jour du compte principal
					            $anciencompte_nn->setSolde(0);
                                $anciencm_map->update($anciencompte_nn);
							
							    // insertion dans la table eu_nn
					            $countnn = $nn->findConuter() + 1;
                                $nn->setId_nn($countnn);
						        $nn->setDate_emission($date_deb->toString('yyyy-MM-dd'));
                                $nn->setType_emission('Auto');
                                $nn->setMontant_emis($montant);
                                $nn->setMontant_remb($montant);
                                $nn->setSolde_nn(0);
                                $nn->setEmetteur_nn(null);
                                $nn->setCode_type_nn('CAPS');
                                $nn->setId_utilisateur($user->id_utilisateur);
						        $t_nn->insert($nn->toArray());
								
					            $tnn_mapper = new Application_Model_EuTypeNnMapper();
                                $tnn = new Application_Model_EuTypeNn();
                                $result_tnn = $tnn_mapper->find('CAPS',$tnn);
								
					            //Mise à jour du compte général fg
                                $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                                $cg_fgfn = new Application_Model_EuCompteGeneral();
                                $result3 = $cg_mapper->find('FGSCAPS','NN','E',$cg_fgfn);
							
							    if ($result3) {
                                   $cg_fgfn->setSolde($cg_fgfn->getSolde() + $montant);
                                   $cg_mapper->update($cg_fgfn);
                                } else {
                                    $cg_fgfn->setCode_compte('FGSCAPS')
                                            ->setIntitule('FG Source '.$tnn->getLib_type_nn())
                                            ->setService('E')
                                            ->setCode_type_compte('NN')
                                            ->setSolde($montant);
                                    $cg_mapper->save($cg_fgfn);
                                }
							
					            $cc = 'NN-TRE-'.$code_membre;
						        $ccts = 'NN-TSRE-'.$code_membre;
                                $result = $cm_mapper->find($cc,$compte);
                                if ($result == false) {
						            if (substr($code_membre,19,1) == "P") {
							           // insertion dans la table eu_compte
                                       Util_Utils::createCompte($cc,'TRE','TRE',$montant,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
                                       Util_Utils::createCompte($ccts,'TSRE','TSRE',0,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
					                } else {
							           // insertion dans la table eu_compte
						               Util_Utils::createCompte($cc,'TRE','TRE',$montant,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
                                       Util_Utils::createCompte($ccts,'TSRE','TSRE',0,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
						            }
						        } else {
						               // Mise à jour de la table eu_compte
                                    $compte->setSolde($compte->getSolde() + $montant);
                                    $cm_mapper->update($compte);
                                }
						
						        // insertion dans la table eu_operation
                                $countid = $mapper_op->findConuter() + 1;
                                $operation->setId_operation($countid)
                                          ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                          ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                           ->setId_utilisateur($user->id_utilisateur)
                                           ->setCode_membre($code_membre)
                                           ->setMontant_op($montant)
                                           ->setCode_produit($type_mf)
                                           ->setLib_op("Activation")
                                           ->setType_op("AR")
                                           ->setCode_cat("TRE");
                                $mapper_op->save($operation);
							
				            } else {
						        $db->rollback();
                                $this->view->data ="Le solde de votre compte  ".$type_mf."  est null";
				                return;
						    }	
	                    } else {
				            $db->rollback();
                            $this->view->data ="Votre compte ".$type_mf." est inexistante ";
				            return;
				        }
	
	                } else  {
					    if($type_mf == 'MF11000')  {
                            $code_compte = 'NN-TR-'.$anciencodemembre;
						    $dsmsmoney = new Application_Model_EuAncienDetailSmsmoney();
                            $mdsmsmoney = new Application_Model_EuAncienDetailSmsmoneyMapper();
						    $mfcredits = $mdsmsmoney->findSMSByMembre($anciencodemembre);
						    $montant = $mdsmsmoney->findSum($anciencodemembre);
						   
						    if($montant <= 0) {
							  $db->rollback();
                              $this->view->data ="Votre compte ".$type_mf." est null";
							  return;
							}
							$result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
							if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
							
							    //Mise à jour du compte principal
					            $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                $anciencm_map->update($anciencompte_nn);
							    $cc = 'NN-TRE-'.$code_membre;
						        $ccts = 'NN-TSRE-'.$code_membre;
                                $result = $cm_mapper->find($cc,$compte);
								
								if ($result == false) {
						            if (substr($code_membre,19,1) == "P") {
								        // insertion dans la table eu_compte
                                        Util_Utils::createCompte($cc,$type_mf,'TRE',$montant,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
                                        Util_Utils::createCompte($ccts,$type_mf,'TSRE',0,$code_membre,'nn',$date_deb->toString('yyyy-MM-dd'),0,null);
					                } else {
									    // insertion dans la table eu_compte
						                Util_Utils::createCompte($cc,$type_mf,'TRE',$montant,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
                                        Util_Utils::createCompte($ccts,$type_mf,'TSRE',0,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
						            }
						        } else {
								        // Mise à jour de la table eu_compte
                                        $compte->setSolde($compte->getSolde() + $montant);
                                        $cm_mapper->update($compte);
                                }
								
								
								    if ($mfcredits != null) {
					                    $j = 0;
                                        $reste = $montant;
                                        $nbre_credit = count($mfcredits);
					                    while ($reste > 0 && $j < $nbre_credit) {
					                        $mfcredit = $mfcredits[$j];
                                            $id = $mfcredit->getId_detail_smsmoney();
										    $finddsmsmoney = $mdsmsmoney->find($id,$dsmsmoney);
						                    if ($reste >= $mfcredit->getSolde_sms()) {
						                        //Mise à jour de la table eu_ancien_detail_smsmoney
                                                $reste = $reste - $mfcredit->getSolde_sms();
											    $mfcredit->setMont_vendu($mfcredit->getMont_vendu() + $mfcredit->getSolde_sms());
											    $mfcredit->setSolde_sms(0);
                                                $m_rep->update($mfcredit);			 							   
						                    } else {
							                    //Mise à jour du compte crédit mf11000
                                                $mfcredit->setSolde_sms($mfcredit->getSolde_sms() - $reste);
											    $mfcredit->setMont_vendu($mfcredit->getMont_vendu() + $reste);
                                                $mdsmsmoney->update($mfcredit);
						                        $reste = 0;
						                    }
							                $j++;
						                }
									
								        // insertion dans la table eu_nn
						                $countnn = $nn->findConuter() + 1;
						                $nn->setId_nn($countnn)
                                           ->setDate_emission($date_deb->toString('yyyy-MM-dd'))
                                           ->setType_emission('Auto')
                                           ->setMontant_emis($montant)
                                           ->setMontant_remb($montant)
                                           ->setSolde_nn(0)
                                           ->setEmetteur_nn(null)
                                           ->setCode_type_nn('CAPS')
                                           ->setId_utilisateur($user->id_utilisateur);
                                        $t_nn->insert($nn->toArray());
							
							            $tnn_mapper = new Application_Model_EuTypeNnMapper();
                                        $tnn = new Application_Model_EuTypeNn();
                                        $result_tnn = $tnn_mapper->find('CAPS',$tnn);
							
							            //Mise à jour du compte général fg
                                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                                        $cg_fgfn   = new Application_Model_EuCompteGeneral();
                                        $result3   = $cg_mapper->find('FGSCAPS','NN','E',$cg_fgfn);
							
							            if ($result3) {
                                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $montant);
                                            $cg_mapper->update($cg_fgfn);
                                        } else  {
                                            $cg_fgfn->setCode_compte('FGSCAPS')
                                                ->setIntitule('FG Source '.$tnn->getLib_type_nn())
                                                ->setService('E')
                                                ->setCode_type_compte('NN')
                                                ->setSolde($montant);
                                            $cg_mapper->save($cg_fgfn);
                                        }
								
							            // insertion dans la table eu_operation
                                        $countid = $mapper_op->findConuter() + 1;
                                        $operation->setId_operation($countid)
                                                  ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                                  ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                                  ->setId_utilisateur($user->id_utilisateur)
                                                  ->setCode_membre($code_membre)
                                                  ->setMontant_op($montant)
                                                  ->setCode_produit($type_mf)
                                                  ->setLib_op("Activation")
                                                  ->setType_op("AR")
                                                  ->setCode_cat("TRE");
                                        $mapper_op->save($operation);
										
				                }
						    } 
							else {
						        $db->rollback();
                                $this->view->data ="Votre compte ".$type_mf." est inexistante ou insuffisant";
							    return;
				            }
						
                        } elseif($type_mf == 'MF107')   {
						        $findmf = $mdmf->fetchAllByMf();
							    $nb_dmf = count($findmf);
                                for ($j = 0;$j < $nb_dmf;$j++) {
                                    $mont = 0;
                                    $montant_recu = 0;
                                    $res_mf = $findmf[$j];
									$mont = ($res_mf->getMont_apport() * $res_mf->getPourcentage()) / 100;
                                    $montant_recu = $res_mf->getMont_apport() - $mont;
								    $code_apporteur = $res_mf->getCode_membre();
								    $findmf107 = $mmf107->find($res_mf->getNumident(),$mf107);
								    $code_proprio = $mf107->getCode_membre();
									
									for ($i=1;$i<=32;$i++)  {
									    if ($montant_recu > 0) {
										    // insertion dans la table eu_repartition_mf107 
										    $id_rep = $m_repmf107->findConuter() + 1;
									        $repmf107->setId_rep($id_rep);
                                            $repmf107->setId_mf107($res_mf->getId_mf107());
                                            $repmf107->setCode_membre($code_apporteur);
                                            $repmf107->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                            $repmf107->setMont_rep($montant_recu);
                                            $repmf107->setId_utilisateur(null);
                                            $repmf107->setMont_reglt(0);
					                        $repmf107->setSolde_rep($montant_recu);
                                            $repmf107->setPayer(0);
                                            $m_repmf107->save($repmf107);
									    }
										
										if ($mont > 0) {
										
										    // insertion dans la table eu_repartition_mf107  
											$id_rep = $m_repmf107->findConuter() + 1;
											$repmf107->setId_rep($id_rep);
                                            $repmf107->setId_mf107($res_mf->getId_mf107());
                                            $repmf107->setCode_membre($code_proprio);
                                            $repmf107->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                            $repmf107->setMont_rep($mont);
                                            $repmf107->setId_utilisateur($user->id_utilisateur);
                                            $repmf107->setMont_reglt(0);
					                        $repmf107->setSolde_rep($mont);
                                            $repmf107->setPayer(0);
                                            $m_repmf107->save($repmf107);
										
										
									    }
									}
									
									

                              
                                }							  
						
                            /*						
					        $code_compteancien = 'NN-TR-'.$anciencodemembre;
					        $mfcredits = $m_repmf107->fetchRepByMembre($anciencodemembre);
						    $montant = $m_repmf107->findsum();
						    if ($mfcredits != null && $montant > 0)  {
						        $j = 0;
                                $reste = $montant;
                                $nbre_credit = count($mfcredits);
							    while ($reste > 0 && $j < $nbre_credit) {
						            $mfcredit = $mfcredits[$j];
                                    $id = $mfcredit->getId_rep();
								    $findrep = $m_repmf107->find($id,$repmf107);
								    if ($reste >= $mfcredit->getSolde_rep()) {
						              //Mise à jour du compte crédit mf107
                                      $reste = $reste - $mfcredit->getSolde_rep();
								      $mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
								      $mfcredit->setPayer(1);
								      $mfcredit->setSolde_rep(0);
                                      $m_repmf107->update($mfcredit);			 							   
						            } else {
							          //Mise à jour du compte crédit mf107
                                      $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
								      $mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                      $m_repmf107->update($mfcredit);
						              $reste = 0;
						           }
							       $j++;
						        }
							    //Mise à jour du compte principal
						        $ret_req = $anciencm_map->find($code_compteancien,$anciencompte_nn);           
                                $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                $anciencm_map->update($anciencompte_nn);
							
							    $cc = 'NN-TRE-'.$code_membre;
						        $ccts = 'NN-TSRE-'.$code_membre;
                                $result = $cm_mapper->find($cc,$compte);
						        if ($result == false) {
						            if (substr($code_membre,19,1) == "P") {
							          // insertion dans la table eu_compte
                                      Util_Utils::createCompte($cc,'TRE','TRE',$montant,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
                                      Util_Utils::createCompte($ccts,'TSRE','TSRE',0,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
					                } else {
							          // insertion dans la table eu_compte
						              Util_Utils::createCompte($cc,'TRE','TRE',$montant,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
                                      Util_Utils::createCompte($ccts,'TSRE','TSRE',0,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
						            }
						        } else {
							        // Mise à jour de la table eu_compte
                                    $compte->setSolde($compte->getSolde() + $montant);
                                    $cm_mapper->update($compte);
                                }
							
						        // insertion dans la table eu_nn
						        $countnn = $nn->findConuter() + 1;
						        $nn->setId_nn($countnn)
                                   ->setDate_emission($date_deb->toString('yyyy-MM-dd'))
                                   ->setType_emission('Auto')
                                   ->setMontant_emis($montant)
                                   ->setMontant_remb($montant)
                                   ->setSolde_nn(0)
                                   ->setEmetteur_nn(null)
                                   ->setCode_type_nn('CAPS')
                                   ->setId_utilisateur($user->id_utilisateur);
                                $t_nn->insert($nn->toArray());
							
							    $tnn_mapper = new Application_Model_EuTypeNnMapper();
                                $tnn = new Application_Model_EuTypeNn();
                                $result_tnn = $tnn_mapper->find('CAPS',$tnn);
							
							    //Mise à jour du compte général fg
                                $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                                $cg_fgfn   = new Application_Model_EuCompteGeneral();
                                $result3   = $cg_mapper->find('FGSCAPS','NN','E',$cg_fgfn);
							
							    if ($result3) {
                                   $cg_fgfn->setSolde($cg_fgfn->getSolde() + $montant);
                                   $cg_mapper->update($cg_fgfn);
                                } else  {
                                    $cg_fgfn->setCode_compte('FGSCAPS')
                                        ->setIntitule('FG Source '.$tnn->getLib_type_nn())
                                        ->setService('E')
                                        ->setCode_type_compte('NN')
                                        ->setSolde($montant);
                                    $cg_mapper->save($cg_fgfn);
                                }
								
							    // insertion dans la table eu_operation
                                $countid = $mapper_op->findConuter() + 1;
                                $operation->setId_operation($countid)
                                          ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                          ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                          ->setId_utilisateur($user->id_utilisateur)
                                          ->setCode_membre($code_membre)
                                          ->setMontant_op($montant)
                                          ->setCode_produit($type_mf)
                                          ->setLib_op("Activation")
                                          ->setType_op("AR")
                                          ->setCode_cat("TRE");
                                $mapper_op->save($operation);
								
					    } else {
						    $db->rollback();
                            $this->view->data ="Le solde de votre compte  ".$type_mf."  est null ";
				            return;
						}
						
					    */}   else  {  
							    if ( (substr($code_membre,19,1) === 'P' && $type_mf === 'Ir') ||  (substr($code_membre,19,1) === 'P' && $type_mf === 'Inr')
								   ||  (substr($code_membre,19,1) === 'M' && $type_mf === 'RPGnr') ||  (substr($code_membre,19,1) === 'M' && $type_mf === 'RPGr'))   {
                                   $db->rollback();
                                   $this->view->data = "Opération invalide: Vérifier le type de produit  avec le type de membre !!!";
                                   return;
                                }
								
								$credits = $comptecredit_map->findAll($anciencodemembre,$type_mf);
								if($type_mf == 'RPGr' || $type_mf == 'Ir') {
								  $prk = Util_Utils::getParametre('prk','r');
                                  $pck = Util_Utils::getParametre('pck','r');
								} elseif($type_mf == 'RPGnr' || $type_mf == 'Inr') {
								  $prk = Util_Utils::getParametre('prk','nr');
                                  $pck = Util_Utils::getParametre('pck','nr');
								}
								
								if ($credits  !=  false)  {
								    $j = 0;
								    $somme = 0;
								    $cumul = 0;
                                    $nbre_credit = count($credits);
								    while ($j < $nbre_credit)   {
								        $credit = $credits[$j];
                                        $id = $credit->getId_credit();
										$desactiver = $credit->getDesactiver();
									    $montant = $credit->getMontant_place();
									    
								        if($credit->getDesactiver() == "O")  {
										    $findcredit = $comptecredit_map->find($id,$comptecredit);
									        $mont_place = $credit->getMontant_place();
											if($type_mf == 'RPGr' or $type_mf == 'Ir') {
											   $cumul = $cumul + $credit->getMontant_place();
											} elseif(($type_mf == 'RPGnr' or $type_mf == 'Inr') && ($credit->getMontant_credit() > 0)) {
                                               $cumul = $cumul + $credit->getMontant_place();
                                            }
											
											// Mise à jour du credit 
										    //$credit->setDesactiver('N');
                                            //$comptecredit_map->update($credit);
											$sqmax  = 0;
                                            $sum    = 0;
											if ($type_mf == 'RPGr') {
											    $quota = Util_Utils::getParametre('quota','RPGr');
                                                $sum   = Util_Utils::getSumRPGr($code_membre);
												if ($sum < $quota) {
											        $reste = $quota - ($sum + $mont_place);
												    if ($reste < 0) {
													    $sqmax = abs($reste);
													    $creditsqmax = round(($sqmax * $prk) / $pck) / 4;
													    $mont_place = $mont_place - $sqmax;
													   
													    // insertion dans la table eu_operation
                                                        $countsqmax = $mapper->findConuter() + 1;
                                                        $operation = new Application_Model_EuOperation();
                                                        $operation->setId_operation($countsqmax)
                                                                  ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                                                  ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                                                  ->setId_utilisateur($user->id_utilisateur)
                                                                  ->setCode_membre($code_membre)
                                                                  ->setMontant_op($sqmax)
                                                                  ->setCode_produit($type_mf)
                                                                  ->setLib_op("Achat du pouvoir d'achat RPG")
                                                                  ->setType_op('APA')
                                                                  ->setCode_cat('TPAGCRPG');
                                                        $mapper->save($operation);
														
														
														$prows = $tparam->find('periode', 'valeur');
                                                        if (count($prows) > 0) {
                                                           $periode = $prows->current()->montant;
                                                        }
														
														$date_fin->addDay($periode);
                                                        $maxccsqmax = $cc_mapper->findConuter() + 1;
														
														// insertion dans la table eu_compte_credit
                                                        $source = $beneficiaire . $date_deb->toString('yyyyMMddHHmmss');
														$num_compte = 'NB-TPAGCRPG-'.$code_membre;
                                                        Util_Utils::createCompteCredit($maxccsqmax,0,$countsqmax,$code_membre,$type_mf,$num_compte,$creditsqmax,$sqmax,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,'SQMAXUI','N','O',0,1,null,'CNPG',$prk,-1);

														// insertion dans la table eu_bnp_sqmax
														$maxidsqmax = $m_sqmaxui->findConuter() + 1;
                                                        $sqmaxui->setId_sqmax($maxidsqmax);
													    $sqmaxui->setCode_cat('TPAGCRPG');
                                                        $sqmaxui->setCode_membre($code_membre);
                                                        $sqmaxui->setMontant($sqmax);
														$sqmaxui->setId_credit($maxccsqmax);
                                                        $m_sqmaxui->save($sqmaxui);
														
														//Enregistrement du capa et du crédit sqmax sur le compte marchand beneficiaire
                                                        $res_cm = $cm_mapper->find($num_compte,$compte);
											            //$res_cmts = $cm_mapper->find($num_comptets,$cm);
                                                        if ($res_cm == false) {
                                                            $compte->setCode_membre($code_membre)
                                                                   ->setCode_cat('TPAGCRPG')
                                                                   ->setSolde($creditsqmax)
                                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                                   ->setCode_compte($num_compte)
                                                                   ->setLib_compte($code_cat)
                                                                  //->setSource($code_bnp)
                                                                   ->setCode_type_compte('NB')
                                                                   ->setDesactiver(0);
                                                            $cm_mapper->save($compte);
                                                        } else {
                                                            $compte->setSolde($compte->getSolde() + $creditsqmax);
                                                            $cm_mapper->update($compte);
                                                        }
														
														// insertion dans la table eu_cnp
														$maxcnpsqmax = $m_cnp->findConuter() + 1;
                                                        $cnp->setId_cnp($maxcnpsqmax)
                                                            ->setId_credit($maxccsqmax)
                                                            ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                                            ->setMont_debit($credisqmax)
                                                            ->setMont_credit(0)
                                                            ->setSolde_cnp($creditsqmax)
                                                            ->setType_cnp($type_mf)
                                                            ->setSource_credit($source)
                                                            ->setOrigine_cnp('RPGr')
                                                            ->setTransfert_gcp(0);
                                                        $m_cnp->save($cnp);
														
                                                        // insertion dans la table eu_capa
														$code_capa = 'CAPA' .'RPG' . $date_deb->toString('yyyyMMddHHmmss');
                                                        $capa->setCode_capa($code_capa)
                                                             ->setCode_compte('NN-CAPA-'.$code_membre)
                                                             ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
                                                             ->setHeure_capa($date_deb->toString('HH:mm:ss'))
                                                             ->setCode_membre($code_membre)
                                                             ->setMontant_capa($sqmax)
                                                             ->setMontant_utiliser($sqmax)
                                                             ->setMontant_solde(0)
                                                             ->setId_operation($countsqmax)
                                                             ->setType_capa('RPG')
                                                             ->setEtat_capa('Actif')
												             ->setCode_produit($type_mf)
                                                             ->setOrigine_capa(null);
                                                        $m_capa->save($capa);
														
														// insertion dans la table eu_compte_credit_capa
                                                        $credit_capa->setCode_capa($code_capa)
                                                                    ->setCode_produit($type_mf)
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
											    } else {
												        
													    $sqmax = $mont_place;
													    $creditsqmax = round(($sqmax * $prk) / $pck) / 4;
													    $mont_place = 0;
													   
													    // insertion dans la table eu_operation
                                                        $countsqmax = $mapper->findConuter() + 1;
                                                        $operation = new Application_Model_EuOperation();
                                                        $operation->setId_operation($countsqmax)
                                                                  ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                                                  ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                                                  ->setId_utilisateur($user->id_utilisateur)
                                                                  ->setCode_membre($code_membre)
                                                                  ->setMontant_op($sqmax)
                                                                  ->setCode_produit($type_mf)
                                                                  ->setLib_op("Achat du pouvoir d'achat RPG")
                                                                  ->setType_op('APA')
                                                                  ->setCode_cat('TPAGCRPG');
                                                        $mapper->save($operation);
													   
													    $prows = $tparam->find('periode', 'valeur');
                                                        if (count($prows) > 0) {
                                                           $periode = $prows->current()->montant;
                                                        }
														
														$date_fin->addDay($periode);
                                                        $maxccsqmax = $cc_mapper->findConuter() + 1;
														
														// insertion dans la table eu_compte_credit
                                                        $source = $beneficiaire . $date_deb->toString('yyyyMMddHHmmss');
														$num_compte = 'NB-TPAGCRPG-'.$code_membre;
                                                        Util_Utils::createCompteCredit($maxccsqmax,0,$countsqmax,$code_membre,$type_mf,$num_compte,$creditsqmax,$sqmax,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,'SQMAXUI','N','O',0,1,null,'CNPG',$prk,-1);

													    // insertion dans la table eu_bnp_sqmax
														$maxidsqmax = $m_sqmaxui->findConuter() + 1;
                                                        $sqmaxui->setId_sqmax($maxidsqmax);
													    $sqmaxui->setCode_cat('TPAGCRPG');
                                                        $sqmaxui->setCode_membre($code_membre);
                                                        $sqmaxui->setMontant($sqmax);
														$sqmaxui->setId_credit($maxccsqmax);
                                                        $m_sqmaxui->save($sqmaxui);
														
														//Enregistrement du capa et du crédit sqmax sur le compte marchand beneficiaire
                                                        $cm = new Application_Model_EuCompte();
                                                        $res_cm = $cm_mapper->find($num_compte,$cm);
											            //$res_cmts = $cm_mapper->find($num_comptets,$cm);
                                                        if ($res_cm == false) {
                                                            $compte->setCode_membre($code_membre)
                                                                   ->setCode_cat('TPAGCRPG')
                                                                   ->setSolde($creditsqmax)
                                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                                   ->setCode_compte($num_compte)
                                                                   ->setLib_compte($code_cat)
                                                                  //->setSource($code_bnp)
                                                                   ->setCode_type_compte('NB')
                                                                   ->setDesactiver(0);
                                                            $cm_mapper->save($compte);
                                                        } else {
                                                            $compte->setSolde($compte->getSolde() + $creditsqmax);
                                                            $cm_mapper->update($compte);
                                                        }
														
														// insertion dans la table eu_cnp
														$maxcnpsqmax = $m_cnp->findConuter() + 1;
                                                        $cnp->setId_cnp($maxcnpsqmax)
                                                            ->setId_credit($maxccsqmax)
                                                            ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                                            ->setMont_debit($credisqmax)
                                                            ->setMont_credit(0)
                                                            ->setSolde_cnp($creditsqmax)
                                                            ->setType_cnp($type_mf)
                                                            ->setSource_credit($source)
                                                            ->setOrigine_cnp('RPGr')
                                                            ->setTransfert_gcp(0);
                                                        $m_cnp->save($cnp);
														
                                                        // insertion dans la table eu_capa
														$code_capa = 'CAPA' .'RPG' . $date_deb->toString('yyyyMMddHHmmss');
                                                        $capa->setCode_capa($code_capa)
                                                             ->setCode_compte('NN-CAPA-'.$code_membre)
                                                             ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
                                                             ->setHeure_capa($date_deb->toString('HH:mm:ss'))
                                                             ->setCode_membre($code_membre)
                                                             ->setMontant_capa($sqmax)
                                                             ->setMontant_utiliser($sqmax)
                                                             ->setMontant_solde(0)
                                                             ->setId_operation($countsqmax)
                                                             ->setType_capa('RPG')
                                                             ->setEtat_capa('Actif')
												             ->setCode_produit($type_mf)
                                                             ->setOrigine_capa(null);
                                                        $m_capa->save($capa);
														
														// insertion dans la table eu_compte_credit_capa
                                                        $credit_capa->setCode_capa($code_capa)
                                                                    ->setCode_produit($type_mf)
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
											
											
											if ($mont_place > 0)   {
											    $fs = 0;
                                                $panu_fs = 0;
												if($type_mf == 'RPGr' or $type_mf == 'Ir') {
                                                  $credi = floor($mont_place * $prk / $pck);   
												} else {
												  $credi = $credit->getMontant_credit();
												}
												
												if (($type_mf == 'RPGr')) {
													$findmembre = $membre_map->find($code_membre,$membre);
                                                    if ($membre->getAuto_enroler() == 'N') {
                                                        if ($bnp != null and $bnp->getId_credit() == null) {
                                                          $t_map = new Application_Model_EuTypeBnpMapper();
                                                          $tbnp = new Application_Model_EuTypeBnp();
                                                          $t_map->find($bnp->getCode_type_bnp(), $tbnp);
                                                          $fs = floor($credi * $tbnp->getTxfs() / 100);
                                                          if ($fs < ($fs_valeur / 22.4)) {
                                                             $fs = ($fs_valeur / 22.4);
                                                          }
                                                          $credi = $credi - $fs;
                                                        }
                                                    }
                                                }
												
												if($credi > 0)   {
												    $renouveller  = 'O';
												    //Enregistrement du capa et du crédit sur le compte marchand beneficiaire 
                                                    if($type_mf == 'RPGr' or $type_mf == 'RPGnr') {
                                                       $num_compte   = 'NB-TPAGCRPG-'.$code_membre;
												       $code_cat     = 'TPAGCRPG';
												  
												    } else {
												       $num_compte = 'NB-TPAGCI-'.$code_membre;
												       $code_cat = 'TPAGCI';
												    }
												
												    if($type_mf == 'Inr' or $type_mf == 'RPGnr') {
												        $renouveller  = 'N';
												    }
													
												    $res_cm = $cm_mapper->find($num_compte,$compte);
                                                    if ($res_cm == false) {
                                                        $compte->setCode_membre($code_membre)
                                                               ->setCode_cat($code_cat)
                                                               ->setSolde($credit)
                                                               ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                               ->setCode_compte($num_compte)
                                                               ->setLib_compte($code_cat)
                                                                  //->setSource($code_bnp)
                                                               ->setCode_type_compte('NB')
                                                               ->setDesactiver(0);
                                                        $cm_mapper->save($compte);
                                                    } else {
                                                        $compte->setSolde($compte->getSolde() + $credi);
                                                        $cm_mapper->update($compte);
                                                    }
													
													$count = $mapper_op->findConuter() + 1;
                                                    $operation->setId_operation($count)
                                                              ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                                              ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                                              ->setId_utilisateur($user->id_utilisateur)
                                                              ->setCode_membre($code_membre)
                                                              ->setMontant_op($mont_place)
                                                              ->setCode_produit($type_mf)
                                                              ->setType_op('APA')
                                                              ->setCode_cat($code_cat);
														  
												    if($type_mf == 'RPGr' or $type_mf == 'RPGnr') {
                                                        $operation->setLib_op("Achat du pouvoir d'achat RPG");
                                                    } else {
                                                        $operation->setLib_op("Achat du pouvoir d'achat I");
                                                    }												
														  
                                                    $mapper_op->save($operation);
													
													//Mise à jour des comptes credits
                                                    $source = $code_membre . $date_deb->toString('yyyyMMddHHmmss');
                                                    $max_code = $cc_mapper->findConuter() + 1;
                                                    $periode = Util_Utils::getParametre('periode', 'valeur');
                                                    $date_fin->addDay($periode);
                                                    $compte_source = '';
												
												    if($type_mf == 'RPGr' or $type_mf == 'Ir') {
												       Util_Utils::createCompteCredit($max_code,0,$count,$code_membre,$type_mf,$num_compte,$credi,$mont_place,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,$compte_source,'N',$renouveller,0,0,null,'CNPG',$prk,-1);
                                                    } else {
													   Util_Utils::createCompteCredit($max_code,0,$count,$code_membre,$type_mf,$num_compte,$credi,$mont_place,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,$compte_source,'N',$renouveller,0,0,null,'CNPG',$prk,1);
													}
													
													
													$maxcnp = $m_cnp->findConuter() + 1;
													$cnp->setId_cnp($maxcnp)
													    ->setId_credit($max_code)
                                                        ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                                        ->setMont_debit($credi)
                                                        ->setMont_credit(0)
                                                        ->setSolde_cnp($credi)
                                                        ->setType_cnp($type_mf)
                                                        ->setSource_credit($source)
                                                        ->setTransfert_gcp(0);
                                                    if ($type_mf == 'Inr') {
                                                       $cnp->setOrigine_cnp('FGInr');
                                                    } elseif ($type_mf == 'Ir') {
                                                       $cnp->setOrigine_cnp('FGIr');
                                                    } elseif ($type_mf == 'RPGr') {
                                                       $cnp->setOrigine_cnp('FGRPGr');
                                                    } elseif ($type_mf == 'RPGnr') {
                                                       $cnp->setOrigine_cnp('FGRPGnr');
                                                    }
                                                    $m_cnp->save($cnp);
													
													if ($fs > 0) {
													    $bnp->setId_credit($max_code)
                                                            ->setMont_fs($bnp->getMont_fs() + $fs)
                                                            ->setIndexer(1);
                                                        if ($panu_fs > 0) {
                                                            $bnp->setMont_panu_fs(0);
                                                        }
                                                        $bmap->update($bnp);
														
														//Mise à jour du fs
														if($bnp->getCode_membre_app() != null) {
                                                          $cfs = 'NB-TFS-'.$bnp->getCode_membre_app();
														  $membre_app = $bnp->getCode_membre_app();
														}
														
														if($bnp->getCode_membre_morale_app() != null) {
                                                          $cfs = 'NB-TFS-'.$bnp->getCode_membre_morale_app();
														  $membre_app = $bnp->getCode_membre_morale_app();
														}
														
                                                        $compte_fs = new Application_Model_EuCompte();
                                                        $ret_fs = $cm_mapper->find($cfs,$compte_fs);
														if ($ret_fs == false) {
                                                            $compte->setCode_membre($membre_app)
                                                                   ->setCode_cat('TFS')
                                                                   ->setSolde($fs)
                                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                                   ->setCode_compte($cfs)
                                                                   ->setLib_compte('TFS')
                                                                  //->setSource($code_bnp)
                                                                   ->setCode_type_compte('NB')
                                                                   ->setDesactiver(0);
                                                            $cm_mapper->save($compte);
                                                        } else {
                                                            $compte->setSolde($compte->getSolde() + $fs);
                                                            $cm_mapper->update($compte);
                                                        }
													   //Mise à jour des comptes credits
                                                       $source = $membre_app . $date_deb->toString('yyyyMMddHHmmss');
                                                       $max_code = $cc_mapper->findConuter() + 1;
													   $compte_source = '';
													   
													    Util_Utils::createCompteCredit($max_code,0,$count,$membre_app,'FS',$cfs,$fs,$bnp->getMont_caps(),$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,$compte_source,'N','N',0,0,null,'CNPG',$prk,-1);
                                                        $maxcnp = $m_cnp->findConuter() + 1;
													    $cnp->setId_cnp($maxcnp)
														   ->setId_credit($max_code)
                                                           ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                                           ->setMont_debit($fs)
                                                           ->setMont_credit(0)
                                                           ->setSolde_cnp($fs)
                                                           ->setType_cnp($type_mf)
                                                           ->setSource_credit($source)
                                                           ->setTransfert_gcp(0);
                                                        if ($type_mf == 'Inr') {
                                                           $cnp->setOrigine_cnp('FGInr');
                                                        } elseif ($type_mf == 'Ir') {
                                                           $cnp->setOrigine_cnp('FGIr');
                                                        } elseif ($type_mf == 'RPGr') {
                                                           $cnp->setOrigine_cnp('FGRPGr');
                                                        } elseif ($type_mf == 'RPGnr') {
                                                           $cnp->setOrigine_cnp('FGRPGnr');
                                                        }
                                                        $m_cnp->save($cnp);
													}
													
													
													
													
													if($type_mf == 'RPGr' or $type_mf == 'RPGnr') {
													   $code_capa = 'CAPARPG'. $date_deb->toString('yyyyMMddHHmmss');
													   $typecapa = 'RPG';
													} else {
													   $code_capa = 'CAPAI'. $date_deb->toString('yyyyMMddHHmmss');
													   $typecapa = 'I';
													}
													
													$capa->setCode_capa($code_capa)
                                                         ->setCode_compte('NN-CAPA-'.$code_membre)
                                                         ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
                                                         ->setHeure_capa($date_deb->toString('HH:mm:ss'))
                                                         ->setCode_membre($code_membre)
                                                         ->setMontant_capa($mont_place)
                                                         ->setMontant_utiliser($mont_place)
                                                         ->setMontant_solde(0)
                                                         ->setId_operation($count)
                                                         ->setType_capa($typecapa)
                                                         ->setEtat_capa('Actif')
												         ->setCode_produit($type_mf)
                                                         ->setOrigine_capa('SMS');
                                                    $m_capa->save($capa);
													
													$credit_capa->setCode_capa($code_capa)
                                                                ->setCode_produit($type_mf)
                                                                ->setId_credit($max_code)
                                                                ->setMontant($mont_place);
                                                    $m_credit_capa->save($credit_capa);
													
													//Mise à jour de la table fn
												    $maxfn = $m_fn->findConuter() + 1;	
                                                    $fn->setId_fn($maxfn)
												       ->setCode_capa($code_capa)
                                                       ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
                                                       ->setMontant($mont_place)
                                                       ->setSortie(0)
                                                       ->setEntree(0)
                                                       ->setSolde(0)
												       ->setOrigine_fn(0)
                                                       ->setMt_solde($mont_place);
												    if($type_mf == 'RPGr' or $type_mf == 'Ir') {
                                                      $fn->setType_fn('Ir');
                                                    } else {
                                                      $fn->setType_fn('Inr');
                                                    }												
                                                    $m_fn->save($fn);
													
													
													$result2 = false;  
												if ($type_mf == 'RPGr' or $type_mf == 'RPGnr') {
                                                    $result2 = $cg_mapper->find('FGRPG', 'NN', 'E', $compte_gene);
                                                } else {
                                                    $result2 = $cg_mapper->find('FGI', 'NN', 'E', $compte_gene);
                                                }
												
												if ($result2) {
                                                    $compte_gene->setSolde($compte_gene->getSolde() + $montant);
                                                    $cg_mapper->update($compte_gene);
                                                } else  {
                                                    if ($type_mf == 'RPGr' or $type_mf == 'RPGnr') {
                                                        $compte_gene->setCode_compte('FGRPG');
                                                        $compte_gene->setIntitule('FGRPG');
                                                    } else  {
                                                        $compte_gene->setCode_compte('FGI');
                                                        $compte_gene->setIntitule('FGI');
                                                    }
                                                    $compte_gene->setCode_type_compte('NN');
                                                    $compte_gene->setService('E');
                                                    $compte_gene->setSolde($montant);
                                                    $cg_mapper->save($compte_gene);
                                                }												

                                                      //Mise à jour du compte général fn
                                                    $cgfn = new Application_Model_EuCompteGeneral();
                                                    $result_3 = $cg_mapper->find('FN', 'NR', 'E', $cgfn);
                                                    if ($result_3) {
                                                       $cgfn->setSolde($cgfn->getSolde() + $montant);
                                                       $cg_mapper->update($cgfn);
                                                    } else {
                                                       $cgfn->setCode_compte('FN');
                                                       $cgfn->setIntitule('FN');
                                                       $cgfn->setService('FN')->setCode_type_compte('NR');
                                                       $cgfn->setSolde($montant);
                                                       $cg_mapper->save($cgfn);
												    }
													
													//Mise à jour des fgfn
													$gac_source = '0010010010010000002M';
													$code_fgfn = 'FGFN-' . $gac_source;
                                                    $ret_fg = $fgfn_map->find($code_fgfn,$fgfn);
													if (!$ret_fg) {
                                                        $fgfn->setCode_fgfn($code_fgfn)
                                                             ->setCode_membre($gac_source)
                                                             ->setSolde_fgfn($montant);
                                                        $fgfn_map->save($fgfn);
                                                    } else {
                                                        $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $montant);
                                                        $fgfn_map->update($fgfn);
                                                    }
													
													$maxfgfn = $fg_mapper->findConuter() + 1;
													$det_fg->setId_fgfn($maxfgfn)
													       ->setType_fgfn('FGFN')
                                                           ->setCode_membre_pbf($gac_source)
                                                           ->setMont_fgfn($montant)
                                                           ->setDate_fgfn($date_deb->toString('yyyy-MM-dd'))
                                                           ->setMont_preleve(0)
                                                           ->setSolde_fgfn($montant)
                                                           ->setCode_fgfn($code_fgfn)
                                                           ->setCreditcode('')
                                                           ->setOrigine_fgfn('SMS');	   
                                                    $fg_mapper->save($det_fg);
														
												}
											
											
											}
											
									    } else {
										        $db->rollback();
                                                $this->view->data = "Les ressources de type  ".$type_mf."  ont ete active" ;
				                                return;
										}
								        $j++;
								    }
									// insertion dans la table eu_operation
									if($cumul > 0) {
                                        $countid = $mapper_op->findConuter() + 1;
                                        $operation->setId_operation($countid)
                                                  ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                                  ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                                  ->setId_utilisateur($user->id_utilisateur)
                                                  ->setCode_membre($code_membre)
                                                  ->setMontant_op($cumul)
                                                  ->setCode_produit($type_mf)
                                                  ->setLib_op("Activation")
                                                  ->setType_op("AR")
                                                  ->setCode_cat($code_cat);
                                        $mapper_op->save($operation);
									}
								
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
                    $this->view->data = $message;
                    return;
                }
	        }
	}
	
	
	
	/*public function doactiveroldAction()   {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		if ($this->getRequest()->isPost()) {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try {
			    $montant = 0;
			    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin;
				$anciencodemembre = $_POST['ancien_code_membre'];
				$code_membre = $_POST['code_membre'];
		        $mode_fin = $_POST['mode_fin'];
		        $type_mf = $_POST['type_mf'];
			    $nn = new Application_Model_EuNn();
				$t_nn = new Application_Model_DbTable_EuNn();
				$comptecredit      = new Application_Model_EuAncienCompteCredit();
				$comptecredit_map  = new Application_Model_EuAncienCompteCreditMapper();
			    $ancienmembre      = new Application_Model_EuAncienMembre();
		        $ancienmembre_map  = new Application_Model_EuAncienMembreMapper();
			    $anciencompte_nn   = new Application_Model_EuAncienCompte();
		        $anciencm_map      = new Application_Model_EuAncienCompteMapper();
			    $repmf11000        = new Application_Model_EuRepartitionMf11000();
			    $m_repmf11000      = new Application_Model_EuRepartitionMf11000Mapper();
				$repmf107          = new Application_Model_EuRepartitionMf107();
			    $m_repmf107        = new Application_Model_EuRepartitionMf107Mapper();
				$operation         = new Application_Model_EuOperation();
				$mapper_op         = new Application_Model_EuOperationMapper();
				$compte            = new Application_Model_EuCompte();
			    $cm_mapper         = new Application_Model_EuCompteMapper();
				
				if ($mode_fin == 'bon') {
				    $num_bon = $_POST['num_bon'];
					$mf = new Application_Model_EuMembreFondateur11000();
                    $mfm = new Application_Model_EuMembreFondateur11000Mapper();
					
					//Récupération des informations du membre fondateur 11000
					$find_mf = $mfm->find($num_bon,$mf);
					$code_compte = 'NN-TR-'.$num_bon;
					$result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
					$result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
					if ($result_nn && $find_mf != false) {
					    $mfcredits = $m_repmf11000->fetchRepByNumBon($num_bon);
						if($mf->getNb_repartition() < 32) {
						    for ($i = 1; $i <= 26; $i++)  { 
                                // insertion dans la table eu_repartition_mf11000
                                $id_rep = $m_repmf11000->findConuter() + 1;
								$repmf11000->setId_rep($id_rep);
								$repmf11000->setId_mf11000($num_bon);
                                $repmf11000->setCode_mf11000($num_bon);
                                $repmf11000->setCode_membre($mf->getCode_membre());
                                $repmf11000->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                $repmf11000->setMont_rep($mf->getSolde());
                                $repmf11000->setMont_reglt(0);
                                $repmf11000->setSolde_rep($mf->getSolde());
                                $repmf11000->setId_utilisateur($user->id_utilisateur);
                                $repmf11000->setPayer(0);
                                $m_repmf11000->save($repmf11000);
								//mise à jour du compte nn de transfert du MF11000
					            $anciencompte_nn->setSolde($anciencompte_nn->getSolde() + $mf->getSolde());
                                $anciencm_map->update($anciencompte_nn)
						    }
							//Mise à jour de la table eu_membre_fondateur11000
                            $query = "update eu_membre_fondateur11000 set nb_repartition =(nb_repartition + 26) where num_bon ='$num_bon'";
                            $db->query($query);	
					    } else {
						    $db->rollback();
                            $this->view->data ="La ressource ".$type_mf." est deja active pour ce compte";
							return;
						}

                        $mfcredits = $m_repmf11000->fetchRepByNumBon($num_bon);
						$montant = $m_repmf11000->findsum();
				        if ($mfcredits != null && $montant > 0) {
					        $j = 0;
						    $reste = $m_repmf11000->findsum();
				            $nbre_credit = count($mfcredits);
					        while ($reste > 0 && $j < $nbre_credit) {
						      $mfcredit = $mfcredits[$j];
                              $id = $mfcredit->getId_rep();
							  $findrep = $m_repmf11000->find($id,$repmf11000);
						        if ($reste >= $mfcredit->getSolde_rep()) {
						           //Mise à jour du compte crédit mf11000
                                   $reste = $reste - $mfcredit->getSolde_rep();
								   $mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
							       $mfcredit->setPayer(1);
								   $mfcredit->setSolde_rep(0);
                                   $m_repmf11000->update($mfcredit);			 							   
						        } else {
							       //Mise à jour du compte crédit mf11000
                                   $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
								   $mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                   $m_repmf11000->update($mfcredit);
						           $reste = 0;
						        }
							    $j++;
				            }
							
							//Mise à jour du compte principal
					        $anciencompte_nn->setSolde(0);
                            $anciencm_map->update($anciencompte_nn);
							
							// insertion dans la table eu_nn
					        $countnn = $nn->findConuter() + 1;
                            $nn->setId_nn($countnn);
						    $nn->setDate_emission($date_deb->toString('yyyy-MM-dd'));
                            $nn->setType_emission('Auto');
                            $nn->setMontant_emis($montant);
                            $nn->setMontant_remb($montant);
                            $nn->setSolde_nn(0);
                            $nn->setEmetteur_nn(null);
                            $nn->setCode_type_nn('CAPS');
                            $nn->setId_utilisateur($user->id_utilisateur);
						    $t_nn->insert($nn->toArray());
								
					        $tnn_mapper = new Application_Model_EuTypeNnMapper();
                            $tnn = new Application_Model_EuTypeNn();
                            $result_tnn = $tnn_mapper->find('CAPS',$tnn);
								
					        //Mise à jour du compte général fg
                            $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                            $cg_fgfn = new Application_Model_EuCompteGeneral();
                            $result3 = $cg_mapper->find('FGSCAPS','NN','E',$cg_fgfn);
							
							if ($result3) {
                               $cg_fgfn->setSolde($cg_fgfn->getSolde() + $montant);
                               $cg_mapper->update($cg_fgfn);
                            } else {
                                $cg_fgfn->setCode_compte('FGSCAPS')
                                        ->setIntitule('FG Source '.$tnn->getLib_type_nn())
                                        ->setService('E')
                                        ->setCode_type_compte('NN')
                                        ->setSolde($montant);
                                $cg_mapper->save($cg_fgfn);
                            }
							
					    $cc = 'NN-TRE-'.$code_membre;
						$ccts = 'NN-TSRE-'.$code_membre;
                        $result = $cm_mapper->find($cc,$compte);
                        if ($result == false) {
						    if (substr($code_membre,19,1) == "P") {
							   // insertion dans la table eu_compte
                               Util_Utils::createCompte($cc,'TRE','TRE',$montant,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
                               Util_Utils::createCompte($ccts,'TSRE','TSRE',0,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
					        } else {
							   // insertion dans la table eu_compte
						       Util_Utils::createCompte($cc,'TRE','TRE',$montant,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
                               Util_Utils::createCompte($ccts,'TSRE','TSRE',0,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
						    }
						} else {
						       // Mise à jour de la table eu_compte
                               $compte->setSolde($compte->getSolde() + $montant);
                               $cm_mapper->update($compte);
                        }
						
						// insertion dans la table eu_operation
                        $countid = $mapper_op->findConuter() + 1;
                        $operation->setId_operation($countid)
                                  ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                  ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                  ->setId_utilisateur($user->id_utilisateur)
                                  ->setCode_membre($code_membre)
                                  ->setMontant_op($montant)
                                  ->setCode_produit($type_mf)
                                  ->setLib_op("Activation")
                                  ->setType_op("AR")
                                  ->setCode_cat("TRE");
                        $mapper_op->save($operation);
							
				        } else {
						    $db->rollback();
                            $this->view->data ="Le solde de votre compte  ".$type_mf."  est null ";
				            return;
						}	
					} else {
				        $db->rollback();
                        $this->view->data ="Votre compte ".$type_mf." est inexistante ";
				        return;
				    }   
				
				} else  {
				    if($type_mf == 'MF11000')  {
                       


                    } elseif($type_mf == 'MF107')   {
					    $code_compteancien = 'NN-TR-'.$anciencodemembre;
					    $mfcredits = $m_repmf107->fetchRepByMembre($anciencodemembre);
						$montant = $m_repmf107->findsum();
						if ($mfcredits != null && $montant > 0)  {
						    $j = 0;
                            $reste = $montant;
                            $nbre_credit = count($mfcredits);
							while ($reste > 0 && $j < $nbre_credit) {
						        $mfcredit = $mfcredits[$j];
                                $id = $mfcredit->getId_rep();
								$findrep = $m_repmf107->find($id,$repmf107);
								if ($reste >= $mfcredit->getSolde_rep()) {
						           //Mise à jour du compte crédit mf107
                                   $reste = $reste - $mfcredit->getSolde_rep();
								   $mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
								   $mfcredit->setPayer(1);
								   $mfcredit->setSolde_rep(0);
                                   $m_repmf107->update($mfcredit);			 							   
						        } else {
							       //Mise à jour du compte crédit mf107
                                   $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
								   $mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                   $m_repmf107->update($mfcredit);
						           $reste = 0;
						        }
							    $j++
						    }
							//Mise à jour du compte principal
						    $ret_req = $anciencm_map->find($code_compteancien,$anciencompte_nn);           
                            $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                            $anciencm_map->update($anciencompte_nn);
							
							$cc = 'NN-TRE-'.$code_membre;
						    $ccts = 'NN-TSRE-'.$code_membre;
                            $result = $cm_mapper->find($cc,$compte);
						    if ($result == false) {
						        if (substr($code_membre,19,1) == "P") {
							       // insertion dans la table eu_compte
                                   Util_Utils::createCompte($cc,'TRE','TRE',$montant,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
                                   Util_Utils::createCompte($ccts,'TSRE','TSRE',0,$code_membre,'NN',$date_deb->toString('yyyy-MM-dd'),0,null);
					            } else {
							      // insertion dans la table eu_compte
						          Util_Utils::createCompte($cc,'TRE','TRE',$montant,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
                                  Util_Utils::createCompte($ccts,'TSRE','TSRE',0,null,'NN',$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
						        }
						    } else {
							    // Mise à jour de la table eu_compte
                                $compte->setSolde($compte->getSolde() + $montant);
                                $cm_mapper->update($compte);
                            }
							
							
						    // insertion dans la table eu_nn
						    $countnn = $nn->findConuter() + 1;
						    $nn->setId_nn($countnn)
                               ->setDate_emission($date_deb->toString('yyyy-MM-dd'))
                               ->setType_emission('Auto')
                               ->setMontant_emis($montant)
                               ->setMontant_remb($montant)
                               ->setSolde_nn(0)
                               ->setEmetteur_nn(null)
                               ->setCode_type_nn('CAPS')
                               ->setId_utilisateur($user->id_utilisateur);
                            $t_nn->insert($nn->toArray());
							
							$tnn_mapper = new Application_Model_EuTypeNnMapper();
                            $tnn = new Application_Model_EuTypeNn();
                            $result_tnn = $tnn_mapper->find('CAPS',$tnn);
							
							//Mise à jour du compte général fg
                            $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                            $cg_fgfn   = new Application_Model_EuCompteGeneral();
                            $result3   = $cg_mapper->find('FGSCAPS','NN','E',$cg_fgfn);
							
							if ($result3) {
                                $cg_fgfn->setSolde($cg_fgfn->getSolde() + $montant);
                                $cg_mapper->update($cg_fgfn);
                            } else  {
                                $cg_fgfn->setCode_compte('FGSCAPS')
                                        ->setIntitule('FG Source '.$tnn->getLib_type_nn())
                                        ->setService('E')
                                        ->setCode_type_compte('NN')
                                        ->setSolde($montant);
                                $cg_mapper->save($cg_fgfn);
                            }
							
							// insertion dans la table eu_operation
                            $countid = $mapper_op->findConuter() + 1;
                            $operation->setId_operation($countid)
                                      ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                      ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                      ->setId_utilisateur($user->id_utilisateur)
                                      ->setCode_membre($code_membre)
                                      ->setMontant_op($montant)
                                      ->setCode_produit($type_mf)
                                      ->setLib_op("Activation")
                                      ->setType_op("AR")
                                      ->setCode_cat("TRE");
                            $mapper_op->save($operation);
								
					    } else {
						    $db->rollback();
                            $this->view->data ="Le solde de votre compte  ".$type_mf."  est null ";
				            return;
						}	
							
					} else {
					
					
					
					}

                }
				
			} catch (Exception $exc) {
              $db->rollback();
              $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
              $this->view->message = $message;
              $this->view->data = $message;
              return;
            }
	    }
	}*/

	
	
	public function donewrachatAction()  {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $date_id = new Zend_Date(Zend_Date::ISO_8601);
           $date_idd = clone $date_id;
		   $compte = new Application_Model_EuCompte();
           $mcompte = new Application_Model_EuCompteMapper();
		   $dsmsmoney = new Application_Model_EuDetailSmsmoney();
           $mdsmsmoney = new Application_Model_EuDetailSmsmoneyMapper();
		   $acteur = new Application_Model_EuActeur();
		   $request = $this->getRequest();
		   
		    if ($request->isPost())   {
	            $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
				try {
					$type_mf = $request->type_mf; 
				    //$cat_mf = $request->cat_mf; 
				    $code_membre_app = $request->code_membre_app; 
                    $montant = $request->montant;
                    $code_membre_dist = $request->code_membre_dist;
					$findacteur =  $acteur->findByActeur($code_membre_dist);
					
					//Mise à jour des comptes
					$code_compte_app = 'NN-'.$type_mf.'-'.$code_membre_app;
				    
				  
                    $code_compte_dist = 'NN-TR-'.$code_membre_dist; 
				    // verification de l'existence du compte
                    $find_compte = $mcompte->find($code_compte_app,$compte);
					
                    if ($find_compte != false  &&  $compte->getSolde() >= $montant) {
                      $compte->setSolde($compte->getSolde() - $montant);
                      $mcompte->update($compte);
                    } else {
                      $db->rollback();
                      $this->view->data = 'erreurapp';
                      return;
                    }
					
					
					// verification de l'existence du compte
                    $find_compte_dist = $mcompte->find($code_compte_dist,$compte);
				    //Mise à jour du compte de transfert du distributeur
                    if ($find_compte_dist != false) {
                       $compte->setSolde($compte->getSolde() + $montant);
                       $mcompte->update($compte);
                    } else {
                       $db->rollback();
                       $this->view->data = 'erreurdist';
                       return;
                    }
	                
					// verification de l'existence de l'acteur enroleur
					$table = new Application_Model_DbTable_EuActeur();
					$select = $table->select();
					$select->where('code_membre like ?',$code_membre_dist);
					$resultSet = $table->fetchAll($select);
					$ligneacteur = $resultSet->current();
					
					if($findacteur == false) {
					   $db->rollback();
                       $this->view->data = 'erreuracteur';
                       return;   
					} else if($ligneacteur->type_acteur != 'DSMS') {
					   $db->rollback();
                       $this->view->data = 'erreuracteur';
                       return;
					}
					
					// insertion dans la table eu_detail_smsmoney
				    $count = $mdsmsmoney->findConuter() + 1;
                    $dsmsmoney->setId_detail_smsmoney($count)
					          ->setNum_bon(null)
                              ->setCode_membre($code_membre_app)
                              ->setDate_allocation($date_idd->toString('yyyy-MM-dd'))
                              ->setId_utilisateur($user->id_utilisateur)
                              ->setCode_membre_dist($code_membre_dist)
                              ->setCreditcode(null)
                              ->setMont_sms($montant)
                              ->setMont_vendu(0)
                              ->setSolde_sms($montant)
                              ->setOrigine_sms($type_mf)
							  ->setType_sms('CAPS');
                    $mdsmsmoney->save($dsmsmoney);
					
					if (substr($code_membre_app,19,1) == "P") {
					   $membre_mapper = new Application_Model_EuMembreMapper();
                       $membrein = new Application_Model_EuMembre();
					   $find_membre = $membre_mapper->find($code_membre_app,$membrein);
					   $compteur = Util_Utils::findConuter() + 1;
					   //fonction d'envoi de message au membre
                       Util_Utils::addSms($compteur,$membrein->getPortable_membre(),$montant." "."ont ete retire de votre compte : ".$type_mf);
					
					} else {
					   $membre_mapper = new Application_Model_EuMembreMoraleMapper();
                       $membrein = new Application_Model_EuMembreMorale();
					   $find_membre = $membre_mapper->find($code_membre_app,$membrein);
					   
					   $compteur = Util_Utils::findConuter() + 1;
					   //fonction d'envoi de message au membre
                       Util_Utils::addSms($compteur,$membrein->getPortable_membre(),$montant." "."ont ete retire de votre compte : ".$type_mf);
					   
					}
				    $db->commit();
                    $this->view->data = true;
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
	
	
	
	
	
	
	
	




















}

?>