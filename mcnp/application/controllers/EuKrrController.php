<?php
class EuKrrController extends Zend_Controller_Action {
    
        //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        
        if ($group == 'e_nn_achatpp_nn_krr_rpgr') {       
		    $menu = '<li><a id="listekrr" href="/eu-krr/index" style="font-size:11px">Liste des KrR</a></li>
                    <li><a id="newkrr" href="/eu-krr/new" style="font-size:11px">Demande</a></li>
			        <li><a id="newkrrsqmax" href="/eu-krr/newsqmax" style="font-size:11px">Demande KrR sqmax</a></li>';   	   
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
           if ($group != 'banque' && $group != 'apa' && $group != 'e_nn_achatpp_nn_krr_rpgr') {
              $this->view->user = $user;
              return $this->_redirect('index2');
           }
           $this->view->user = $user;
        }
    }
	
	
	
	
    public function indexAction() {
        
    }

	
    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'asc');
        $reconst = $this->_request->getParam("rec");
        $payer = $this->_request->getParam("payer");
        //$membre = $this->_request->getParam("membre");
        $compte = $this->_request->getParam("compte");
        $date = $this->_request->getParam("date");
        $tabela = new Application_Model_DbTable_EuKrr();
        $select = $tabela->select();
        $select->where('code_membre = ?', $code_membre);
        if ($compte != '') {
            $select->where('code_produit = ?', $compte . 'r');
        }
        if ($date != '') {
            $date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('date_demande = ?', $dated);
        }
        if ($reconst != '') {
            $select->where('reconstituer = ?', $reconst);
        }
        if ($payer != '') {
           $select->where('payer = ?', $payer);
        }
        $krrs = $tabela->fetchAll($select);
        $count = count($krrs);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $krrs = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($krrs as $row) {
            $responce['rows'][$i]['id'] = $row->id_credit;
            $responce['rows'][$i]['cell'] = array(
               $row->id_credit,
               $row->code_membre,
               $row->code_produit,
               $row->mont_krr,
               $row->date_echue,
               $row->payer
            );
            $i++;
        }
        $this->view->data = $responce;
    }

	
	
    public function saveAction() {
        $code     = $_GET['code'];
        $k        = new Application_Model_EuKrr();
        $mk       = new Application_Model_EuKrrMapper();
        $m_capa   = new Application_Model_EuCapaMapper();
        $capa     = new Application_Model_EuCapa();
        $credit   = new Application_Model_EuCompteCredit();
        $m_credit = new Application_Model_EuCompteCreditMapper();
        $compte   = new Application_Model_EuCompte();
        $m_compte = new Application_Model_EuCompteMapper();
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $mk->find($code,$k);
            if ($k->getPayer() == 'N' /*             * && $k->getReconstituer() == 'o'* */) {
                $k->setPayer('O');
                $mk->update($k);
                $retour = $m_credit->find($k->getId_credit(), $credit);
                if ($retour) {
                    $m_capa->find($credit->getCode_capa(), $capa);
                    $capa->setEtat_capa('N');
                    $m_capa->update($capa);
                    if ($credit->getCode_produit() == 'Ir')  {
                       $num_compte = 'NN-TPAGCI' . '-' . $credit->getCode_membre();
                    } elseif ($credit->getCode_produit() == 'RPGr') {
                       $num_compte = 'NN-TPAGCRPG' . '-' . $credit->getCode_membre();
                    }
                    $ret = $m_compte->find($num_compte,$compte);
                    if ($ret) {
                        $compte->setSolde($compte->getSolde() + $k->getMont_capa());
                        $m_compte->update($compte);
                    } else {
                        $date_deb = Zend_Date::now();
                        $compte->setCode_membre($credit->getCode_membre())
                               ->setDate_alloc(Util_Utils::toDate($date_deb))
                               ->setCode_compte($num_compte)
                               ->setLib_compte($credit->getProduit())
                               ->setCode_cat('TPAGCRPG')
                               ->setCode_type('NN')
                               ->setCredit($k->getMont_capa())
                               ->setSolde($k->getMont_capa());
                        $m_compte->save($compte);
                    }
                }
                $db->commit();
                $this->view->data = true;
            } else {
                $this->view->data = 'Ce capa n\'est pas encore reconstitué ou est déjà payé';
                return;
            }
        } catch (Exception $e) {
            $db->rollback();
            $this->view->data = $e->getMessage();
        }
    }

    public function newAction() {
        $form = new Application_Form_EuKrr();
        $this->view->form = $form;
    }
	
	public function newsqmaxAction() {
        $form = new Application_Form_EuKrr();
        $this->view->form = $form;
    }

	
	public function createsqmaxAction() {
	       $selection = $_GET['lignes'];
		   $compte_m = New Application_Model_EuCompteMapper();
           $compte = new Application_Model_EuCompte();
           $cm = New Application_Model_EuCompteCreditMapper();
           $cr = new Application_Model_EuCompteCredit();
		   $comptets_m = New Application_Model_EuCompteCreditTsMapper();
           $comptets = new Application_Model_EuCompteCreditTs();
           $date = new Zend_Date(Zend_Date::ISO_8601);
           $date_dem = clone $date;
		   if (count($selection) > 0) {
		      foreach ($selection as $sel) {
			        $cm->find($sel['id_credit'],$cr);
                    $produit = new Application_Model_EuProduit();
                    $prod_mapper = new Application_Model_EuProduitMapper();
                    $prod_mapper->find($cr->getCode_produit(), $produit);
			        $tparam = new Application_Model_DbTable_EuParametres();
					$prk = 0;
                    $pck = 0;
                    $select_pck = $tparam->select();
					$select_pck->where('code_param = ?', 'pck')
                               ->where('lib_param = ?', 'r');
                    $rows_pck = $tparam->fetchAll($select_pck);
                    if (count($rows_pck) > 0) {
                       $produit = $rows_pck->current();
                       $pck = $produit->montant;
                    }
					$select_periode = $tparam->select();
					$select_periode->where('code_param = ?', 'periode')
                                   ->where('lib_param = ?', 'valeur');
                    $rows_periode = $tparam->fetchAll($select_periode);
                    if (count($rows_periode) > 0) {
                       $periode = $rows_periode->current();
                       $p = $periode->montant;
                    }
					
					$date_echue  = new Zend_Date($sel['datefin']);
					$date_echue->addDay(floor($p*$pck*4));
					$date_renouv = new Zend_Date($sel['datefin']);
				    $mont_capa = $cr->getMontant_place();
                    $cr->setKrr('o');
					
					if(substr($cr->getCode_membre(),19,1) == 'P') {
					   $compte_membre = 'NB-TPAGCRPG-'.$cr->getCode_membre();
					} else {
					   $compte_membre = 'NB-TPAGCI-'.$cr->getCode_membre();
					}
					
					$find_compte = $compte_m->find($compte_membre,$compte);
					if($cr->getMontant_credit() > 0) { 
					  $compte->setSolde($compte->getSolde() - $cr->getMontant_credit()); 
                      $compte_m->update($compte);					  
					}
					
					$find_comptets = $comptets_m->find($cr->getId_credit(),$comptets);
				
				    if($find_comptets == true) {
				       $comptets->setMontant(0);
				       $comptets_m->update($comptets);
				    }
					
                    $mkr = new Application_Model_EuKrrMapper();
                    $kr = new Application_Model_EuKrr();
                    $kr->setId_credit($cr->getId_credit())
                       ->setCode_membre($cr->getCode_membre())
                       ->setCode_produit($cr->getCode_produit())
                       ->setMont_capa($mont_capa)
                       ->setMont_krr($mont_capa)
                       ->setDate_echue(Util_Utils::toDate($date_echue))
                       ->setDate_renouveller(Util_Utils::toDate($date_renouv))
                       ->setPayer('N')
                       ->setReconstituer('N')
                       ->setDate_demande(Util_Utils::toDate($date_dem))
					   ->setType_krr('krR');
                    $mkr->save($kr);
					$cr->setMontant_credit(0);
                    $cm->update($cr);	
		        }
				$this->view->data = true;
		    } else {
              $this->view->data = false;
            }
	}
	

    public function createAction() {
        $selection = $_GET['lignes'];
		$compte_m = New Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();
		$comptets_m = New Application_Model_EuCompteCreditTsMapper();
        $comptets = new Application_Model_EuCompteCreditTs();
        $cm = New Application_Model_EuCompteCreditMapper();
        $cr = new Application_Model_EuCompteCredit();
		$cnnc = new Application_Model_EuCnnc();
		$cnnc_m = new Application_Model_EuCnncMapper();
        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_dem = clone $date;
        if (count($selection) > 0) {
            foreach ($selection as $sel) {
                $cm->find($sel['id_credit'],$cr);
                $produit = new Application_Model_EuProduit();
                $prod_mapper = new Application_Model_EuProduitMapper();
                $prod_mapper->find($cr->getCode_produit(), $produit);
                $prk = 0;
                $pck = 0;
                $tparam = new Application_Model_DbTable_EuParametres();
                $select_pck = $tparam->select();
                $select_pck->where('code_param = ?', 'pck')
                           ->where('lib_param = ?', 'r');
                $rows_pck = $tparam->fetchAll($select_pck);
                if (count($rows_pck) > 0) {
                   $produit = $rows_pck->current();
                   $pck = $produit->montant;
                }
                $select = $tparam->select();
                $select->where('code_param = ?','prk')
                       ->where('lib_param = ?','r');
                $rows = $tparam->fetchAll($select);
                if (count($rows) > 0) {
                   $produit = $rows->current();
                   $prk = $produit->montant;
                }
			   
			    $select_periode = $tparam->select();
			    $select_periode->where('code_param = ?', 'periode')
                               ->where('lib_param = ?', 'valeur');
                $rows_periode = $tparam->fetchAll($select_periode);
                if (count($rows_periode) > 0) {
                   $periode = $rows_periode->current();
                   $p = $periode->montant;
                }
			    $date_echue  = new Zend_Date($sel['datefin']);
				$date_echue->addDay(floor($p*$pck));
				
				$date_renouv = new Zend_Date($sel['datefin']);
			   
                $mont_capa = $cr->getMontant_place();
                //$mont_reconst = ($cr->getMontant_place() * $pck) / $prk;
                $date_renouv  = new Zend_Date($sel['datefin']);
				
                $cr->setKrr('O');
				
				if(substr($cr->getCode_membre(),19,1) == 'P') {
					$compte_membre = 'NB-TPAGCRPG-'.$cr->getCode_membre();
					//$comptets_membre = 'nb-tsrpg-'.$cr->getCode_membre();
				} else {
					$compte_membre = 'NB-TPAGCI-'.$cr->getCode_membre();
					//$comptets_membre = 'nb-tsgci-'.$cr->getCode_membre();
				}
				
				$find_compte = $compte_m->find($compte_membre,$compte);
				$find_comptets = $comptets_m->find($cr->getId_credit(),$comptets);
				
				if($find_comptets == true) {
				    $comptets->setMontant(0);
				    $comptets_m->update($comptets);
				}
				
				if($cr->getMontant_credit() > 0) { 
					$compte->setSolde($compte->getSolde() - $cr->getMontant_credit()); 
                    $compte_m->update($compte);
					
					$id_cnnc = $cnnc_m->findConuter() + 1;
					$cnnc->setId_cnnc($id_cnnc)
					     ->setCode_membre($cr->getCode_membre())
						 ->setDatefin(Util_Utils::toDate($date_renouv))
						 ->setLibelle($cr->getCode_produit())
						 ->setMont_credit($cr->getMontant_credit())
						 ->setSource_credit($cr->getSource())
						 ->setId_credit($cr->getId_credit())
						 ->setMont_utilise(0)
						 ->setSolde($cr->getMontant_credit());
					$cnnc_m->update($cnnc);	 
										  
				}
				
                $mkr = new Application_Model_EuKrrMapper();
                $kr = new Application_Model_EuKrr();
				
                $kr->setId_credit($cr->getId_credit())
                   ->setCode_membre($cr->getCode_membre())
                   ->setCode_produit($cr->getCode_produit())
                   ->setMont_capa($mont_capa)
                   ->setMont_krr($mont_capa)
                   ->setDate_echue(Util_Utils::toDate($date_echue))
                   ->setDate_renouveller(Util_Utils::toDate($date_renouv))
                   ->setPayer('N')
                   ->setReconstituer('N')
                   ->setDate_demande(Util_Utils::toDate($date_dem))
				   ->setType_krr('krR')
			;
                $mkr->save($kr);
				$cr->setMontant_credit(0);
                $cm->update($cr);
            }
              $this->view->data = true;
            } else {
              $this->view->data = false;
            }
    }

    public function membreAction() {
        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $this->view->data = $membres;
    }
    
	public  function demandesqmaxAction() {
	        $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'id_credit');
            $sord = $this->_request->getParam("sord", 'asc');
		    if ($_GET['membre'] != '') {
			    $membre = $_GET['membre'];
                $produit = $_GET['produit'];
                $tcredit = new Application_Model_DbTable_EuCompteCredit();
			    $select = $tcredit->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false);
			    $select->join('eu_bnp_sqmax','eu_bnp_sqmax.id_credit = eu_compte_credit.id_credit',array('eu_bnp_sqmax.*','eu_compte_credit.*',"to_char((eu_compte_credit.datefin),'dd/mm/yyyy') date_fin"));
			    if ($membre != '') {
				   $select->where('eu_compte_credit.code_membre like ?', $membre);
			    }
			    if ($produit != '') {
                   $select->where('eu_compte_credit.code_produit like ?', $produit.'r');
                }
				
                $select->where('eu_compte_credit.krr like ?','N');
				$select->where('eu_compte_credit.affecter = ?',0);
		        $select->where('eu_compte_credit.compte_source like ?','SQMAXUI');
				$select->where('eu_compte_credit.bnp = ?',1);
				
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
                    $row->montant_credit,
                    $row->date_fin
                );
                $i++;
            }
            $this->view->data = $responce;
			  
		    }
	
	}
	
	
    public function demandeAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_credit');
        $sord = $this->_request->getParam("sord", 'asc');
        if ($_GET['membre'] != '') {
           $membre = $_GET['membre'];
           $produit = $_GET['produit'];
           $tcredit = new Application_Model_DbTable_EuCompteCredit();
           $select = $tcredit->select();
		   $select->from($tcredit,array('*',"to_char((eu_compte_credit.datefin),'dd/mm/yyyy') date_fin")); 
           if ($membre != '') {
                $select->where('code_membre like ?', $membre);
           }
           if ($produit != '') {
                $select->where('code_produit like ?', $produit.'r');
           }
		   
           $select->where('affecter = ?',0);
		   $select->where('krr like ?', 'N');
		   $select->where('bnp = ?',0);
		   $select->where('compte_source <> ?', 'SQMAXUI');
           
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
                    $row->montant_credit,
                    $row->date_fin
                );
                $i++;
            }
            $this->view->data = $responce;
        }
    }
	
	
	
	
	
	
	
	
	





}
?>