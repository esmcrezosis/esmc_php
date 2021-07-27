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
 
 
class ConsultationController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        /* Initialize action controller here */
        $menu = '<li><a id="search" href="/consultation/recherche">Recherche</a></li>
		        <li><a id="salaire" href="/consultation/salaire"><font color="black">CNCS</font></a></li>
		        <li><a id="credit" href="/consultation/credit"><font color="blue">RPG</font> / <font color="blue"> I </font></a></li>
		        <li><a id="credit" href="/consultation/gcp"><font color="blue">GCP</font></a></li>
				<li><a id="credit" href="/consultation/kacm">FS , FL  et  FCPS</a></li>
				<li><a id="credit" href="/consultation/mf11000">MF11000</a></li>
				<li><a id="credit" href="/consultation/mf107">MF107</a></li>'
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

	
	public function rechercheAction() {
	

	}
	
	
	
	public function datasearchAction() {
	       
		   $this->_helper->layout->disableLayout();
	    if (isset($_GET["raison_sociale"])) $raison_sociale =  strtoupper($_GET["raison_sociale"]);
        if (isset($_GET["nom"])) $nom = strtoupper($_GET["nom"]);
        if (isset($_GET["prenom"])) $prenom = strtoupper($_GET["prenom"]);
	    $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'numidentp');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuAncienMembre();
		
		if($raison_sociale !="" && $nom !="" && $prenom !="") {
		    $select = $tabela->select();
            $select->from($tabela)
                   ->where('raison_sociale like ?', '%'.$raison_sociale.'%')
                   ->where('nom_membre like ?', '%'.$nom .'%')
                   ->where('prenom_membre like ?', '%'.$prenom .'%');	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

        if ($count > 0) {
           $total_pages = ceil($count / $limit);
        } else {
           $total_pages = 0;
        }

        if ($page > $total_pages) $page = $total_pages;

        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
              $row->ancien_code_membre,
              $row->nom_membre.' '.$row->prenom_membre,
			  $row->raison_sociale
            );
            $i++;
        }
        $this->view->data = $responce;      
	
	    } else if($raison_sociale !="" && $nom !="") {
		  $select = $tabela->select();
          $select->from($tabela,array('eu_ancien_membre'))
                 ->where('raison_sociale like ?', '%'.$raison_sociale.'%')
                 ->where('nom_membre like ?', '%'.$nom.'%');	 		  
	      $cats = $tabela->fetchAll($select);
          $count = count($cats);

        if ($count > 0) {
           $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cats as $row) {
		    $datenaismembre = new Zend_Date($row->date_nais_membre,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
              $row->ancien_code_membre,
              $row->nom_membre.' '.$row->prenom_membre,
			  $row->raison_sociale
            );
            $i++;
        }
        $this->view->data = $responce; 
		   
		} else if($raison_sociale !="" && $prenom !="") {
		  $select = $tabela->select();
          $select->from($tabela,array('eu_ancien_membre'))
                 ->where('raison_sociale like ?', '%'.$raison_sociale.'%')
                 ->where('prenom_membre like ?', '%'.$prenom.'%');	 		  
	      $cats = $tabela->fetchAll($select);
          $count = count($cats);

          if ($count > 0) {
            $total_pages = ceil($count / $limit);
          } else {
            $total_pages = 0;
          }

          if ($page > $total_pages)
             $page = $total_pages;

          $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
          $responce['page'] = $page;
          $responce['total'] = $total_pages;
          $responce['records'] = $count;
          $i = 0;
          foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
              $row->ancien_code_membre,
              $row->nom_membre.' '.$row->prenom_membre,
		      $row->raison_sociale
            );
            $i++;
        }
            $this->view->data = $responce;
		
		} else if($nom!="" && $prenom!="") {
		   
		    $select = $tabela->select();
            $select->from($tabela,array('eu_ancien_membre'))
                  ->where('nom_membre like ?', '%'.$nom . '%')
                  ->where('prenom_membre like ?', '%'.$prenom.'%');	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

            if ($count > 0) {
              $total_pages = ceil($count / $limit);
            } else {
              $total_pages = 0;
            }

            if ($page > $total_pages)
              $page = $total_pages;

            $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($cats as $row) {
              $responce['rows'][$i]['id'] = $row->ancien_code_membre;
              $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->nom_membre.' '.$row->prenom_membre,
				$row->raison_sociale
            );
            $i++;
            }
            $this->view->data = $responce;
		   
		} else if($raison_sociale!="") {
		       
		    $select = $tabela->select();
            $select->from($tabela)
                  ->where('raison_sociale like ?', '%'.$raison_sociale.'%');	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

            if ($count > 0) {
              $total_pages = ceil($count / $limit);
            } else {
              $total_pages = 0;
            }

            if ($page > $total_pages)
              $page = $total_pages;

           $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
           $responce['page'] = $page;
           $responce['total'] = $total_pages;
           $responce['records'] = $count;
           $i = 0;
           foreach ($cats as $row) {
		    $datenaismembre = new Zend_Date($row->date_nais_membre, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->nom_membre.' '.$row->prenom_membre,
				$row->raison_sociale
            );
            $i++;
        }
         $this->view->data = $responce;
		} else if($nom!="") {
		    
			$select = $tabela->select();
            $select->from($tabela)
                   ->where('nom_membre like ?', '%'.$nom .'%');	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

            if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }

            if ($page > $total_pages)
                $page = $total_pages;

            $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($cats as $row) {
                $responce['rows'][$i]['id'] = $row->ancien_code_membre;
                $responce['rows'][$i]['cell'] = array(
                   $row->ancien_code_membre,
                   $row->nom_membre.' '.$row->prenom_membre,
				   $row->raison_sociale
            );
            $i++;
        }
         $this->view->data = $responce;
		} else if($prenom!="") {
		  $select = $tabela->select();
          $select->from($tabela)
                 ->where('prenom_membre like ?', '%'.$prenom . '%');	 		  
	      $cats = $tabela->fetchAll($select);
          $count = count($cats);

          if ($count > 0) {
            $total_pages = ceil($count / $limit);
          } else {
            $total_pages = 0;
          }
          if ($page > $total_pages)
             $page = $total_pages;

          $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
          $responce['page'] = $page;
          $responce['total'] = $total_pages;
          $responce['records'] = $count;
          $i = 0;
          foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
              $row->ancien_code_membre,
              $row->nom_membre.' '.$row->prenom_membre,
		      $row->raison_sociale
            );
            $i++;
        }
        $this->view->data = $responce;
		
		}
			
			
			
			
	
	
	}
	
	
	
	
	
	
	public function numbonAction() {
	    $data = array();
        $num_bon = $_GET["num_bon"];
        if ($num_bon != '') {
            $tmf = new Application_Model_DbTable_EuMembreFondateur11000();
            $result = $tmf->find($num_bon);
            if (count($result) > 0) {
               $data[0] = $result->current()->nom.' '.$result->current()->prenom;
            }
        }
        $this->view->data = $data;
    }
	
	
	
	
    public function creditAction() {
        
    }

	
	
    public function compteAction() {
        
    }

	
	
    public function operationsAction() {
        
    }
	
	
	public function mf11000Action() {
	        $request = $this->getRequest();
			$num_bon          = '';
			$nom              = '';
            $code_membre      = '';
	        $designation      = '';
		    $mf11000_recu     = 0;
		    $mf11000_vendu    = 0;
		    $mf11000_restant  = 0;
		   
		    $entrees     = 0;
		    $sorties     = 0;
		    $solde       = 0;
		   
		    if ($this->getRequest()->isPost()) {
		        $code_membre = $request->code_membre_mf;
				$num_bon = $request->num_bon;
				$nom = $request->nom_membre;
			    $designation = $request->design_membre_mf;
			    $db_dsms = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsms = $db_dsms->select();
			    $select_dsms->from($db_dsms,array('SUM(mont_sms) as somme_mf'));
			    $select_dsms->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsms->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsms->where('code_membre_dist like ?','%');
                }
			    $result_dsms = $db_dsms->fetchAll($select_dsms);
		        $row_dsms = $result_dsms->current();
		        $mf11000_recu = $row_dsms['somme_mf'];
			   
			   
			    $db_dsmsv = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsmsv = $db_dsmsv->select();
			    $select_dsmsv->from($db_dsmsv,array('SUM(mont_vendu) as somme_vendu'));
			    $select_dsmsv->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsmsv->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsmsv->where('code_membre_dist like ?','%');
                }
			    $result_dsmsv = $db_dsmsv->fetchAll($select_dsmsv);
		        $row_dsmsv = $result_dsmsv->current();
		        $mf11000_vendu = $row_dsmsv['somme_vendu'];
			   
			    $db_dsmss = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsmss = $db_dsmss->select();
			    $select_dsmss->from($db_dsmss,array('SUM(solde_sms) as somme_sms'));
			    $select_dsmss->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsmss->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsmss->where('code_membre_dist like ?','%');
                }
			    $result_dsmss     = $db_dsmss->fetchAll($select_dsmss);
		        $row_dsmss        = $result_dsmss->current();
		        $mf11000_restant  = $row_dsmss['somme_sms'];
				
				
				if($num_bon != '') {
				    $db_entrees = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_entrees = $db_entrees->select();
			        $select_entrees->from($db_entrees,array('SUM(mont_rep) as somme_entrees'));
			        $select_entrees->where('code_mf11000 like ?',$num_bon);
			        $result_entrees     = $db_entrees->fetchAll($select_entrees);
		            $row_entrees        = $result_entrees->current();
		            $entrees  = $row_entrees['somme_entrees'];
					
					$db_sorties = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_sorties = $db_sorties->select();
			        $select_sorties->from($db_sorties,array('SUM(mont_reglt) as somme_sorties'));
			        $select_sorties->where('code_mf11000 like ?',$num_bon);
			        $result_sorties     = $db_sorties->fetchAll($select_sorties);
		            $row_sorties        = $result_sorties->current();
		            $sorties  = $row_sorties['somme_sorties'];
					
					
					$db_solde = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_solde = $db_solde->select();
			        $select_solde->from($db_solde,array('SUM(solde_rep) as solde'));
			        $select_solde->where('code_mf11000 like ?',$num_bon);
			        $result_solde     = $db_solde->fetchAll($select_solde);
		            $row_solde        = $result_solde->current();
		            $solde  = $row_solde['solde'];
				
				
				}  
	        }
			
			$this->view->code_membre     = $code_membre;
			$this->view->designation     = $designation;
			$this->view->num_bon         = $num_bon;
			$this->view->nom             = $nom;
		    $this->view->mf11000_recu    = $mf11000_recu;
			$this->view->mf11000_vendu   = $mf11000_vendu;
			$this->view->mf11000_restant = $mf11000_restant;
			
			$this->view->entrees    = $entrees;
			$this->view->sorties    = $sorties;
			$this->view->solde      = $solde;
			
			
			
	
	}
	
	
	public function mf107Action() {
	        $request = $this->getRequest();
		    $code_membre  = '';
		    $designation  = '';
		    $soldemf107   = 0;
		    if ($this->getRequest()->isPost()) {
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
				try {
		            $code_membre = $request->code_membre_recap;
			        $designation = $request->design_membre_recap;
			        $anciencompte_nn   = new Application_Model_EuAncienCompte();
		            $anciencm_map      = new Application_Model_EuAncienCompteMapper();
					$date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
			        $rep = new Application_Model_EuRepartitionMf107();
			        $m_rep = new Application_Model_EuRepartitionMf107Mapper();
			        $dmf = new Application_Model_EuDetailMf107();
			        $mdmf = new Application_Model_EuDetailMf107Mapper();
			        $mf107 = new Application_Model_EuMembreFondateur107();
			        $mmf107 = new Application_Model_EuMembreFondateur107Mapper();
			        $montant = 0;
			        $nb_dmf = 0;
			        $code_compteancien = 'NN-TR-'.$code_membre;
				
				    /* $db_rep = new Application_Model_DbTable_EuRepartitionMf107();
				       $select_rep = $db_rep->select();
				       $select_rep->from($db_rep,array('COUNT(id_rep) as nb'));
                       $select_rep->where('code_membre like ?',$code_membre);
					   $result_rep = $db_rep->fetchAll($select_rep);
		               $row_rep = $result_rep->current();
		               $nb = $row_rep['nb'];
				    
					if($nb == 0)  {
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
							//if((trim($code_membre) ==  trim($code_apporteur)) || (trim($code_membre) ==  trim($code_proprio)))  {
							    for ($i=1;$i<=32;$i++)  {
						            if ($montant_recu > 0) {
						                // insertion dans la table eu_repartition_mf107 
										$id_rep = $m_rep->findConuter() + 1;
									    $rep->setId_rep($id_rep);
                                        $rep->setId_mf107($res_mf->getId_mf107());
                                        $rep->setCode_membre($code_apporteur);
                                        $rep->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                        $rep->setMont_rep($montant_recu);
                                        $rep->setId_utilisateur(null);
                                        $rep->setMont_reglt(0);
					                    $rep->setSolde_rep($montant_recu);
                                        $rep->setPayer(0);
                                        $m_rep->save($rep);
										
										//Création ou mise à jour du compte nn de transfert de l'apporteur 
                                        $code_compte = 'NN-TR-'.$code_apporteur;
                                        $ret_req = $anciencm_map->find($code_compte,$anciencompte_nn);
									
									    if ($ret_req == false) {
                                            // insertion dans la table eu_ancien_compte													
                                            $anciencompte_nn->setCode_cat('TR')
                                                            ->setCode_membre($code_apporteur)
                                                            ->setCode_compte($code_compte)
                                                            ->setCode_type_compte('NN')
                                                            ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                            ->setDesactiver(0)
                                                            ->setLib_compte('Compte de recharge')
                                                            ->setSolde($montant_recu)
															->setCardPrintedIDDate(0)
															->setCardPrintedDate('');			   
                                            $anciencm_map->save($anciencompte_nn);
                                        } else  {
											// Mise à jour de la table eu_ancien_compte
                                            $anciencompte_nn->setSolde($anciencompte_nn->getSolde() + $montant_recu);
                                            $anciencm_map->update($anciencompte_nn);
                                        }
						            }
									
									if ($mont > 0) {
						                // insertion dans la table eu_repartition_mf107  
									    $id_rep = $m_rep->findConuter() + 1;
										$rep->setId_rep($id_rep);
                                        $rep->setId_mf107($res_mf->getId_mf107());
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_deb->toString('yyyy-MM-dd'));
                                        $rep->setMont_rep($mont);
                                        $rep->setId_utilisateur(null);
                                        $rep->setMont_reglt(0);
					                    $rep->setSolde_rep($mont);
                                        $rep->setPayer(0);
                                        $m_rep->save($rep);
						                
						                //Création ou mise à jour du compte nn de transfert du propriétaire du compte MF107
                                        $code_compte = 'NN-TR-' . $code_proprio;
                                        $ret_req = $anciencm_map->find($code_compte,$anciencompte_nn);
                                        if ($ret_req == false) {
								            // insertion dans la table eu_ancien_compte
                                            $anciencompte_nn->setCode_cat('TR')
                                                            ->setCode_membre($code_proprio)
                                                            ->setCode_compte($code_compte)
                                                            ->setCode_type_compte('NN')
                                                            ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                            ->setDesactiver(0)
                                                            ->setLib_compte('Compte de recharge')
                                                            ->setSolde($mont)
															->setCardPrintedIDDate(0)
															->setCardPrintedDate('');
                                            $anciencm_map->save($anciencompte_nn);
                                        } else {
											// Mise à jour de la table eu_ancien_compte
                                            $anciencompte_nn->setSolde($anciencompte_nn->getSolde() + $mont);
                                            $anciencm_map->update($anciencompte_nn);
                                        }
						            }
						        }
						    //}
					    }
						$db->commit();
						return;
					}*/
					
					$soldemf107 = $m_rep->findSum($code_membre);	
		        } catch (Exception $exc) {
                       $db->rollback();
                       $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                       $this->view->message = $message;
                       $this->view->data = $message;
                       return;
                }
		   
	        }
			$this->view->code_membre  = $code_membre;
			$this->view->designation  = $designation;
            $this->view->soldemf107  = $soldemf107;			
	}
	
	
	
	public function kacmAction()  {
	       $request = $this->getRequest();
		   $code_membre  = '';
		   $designation  = '';
		   $fs           = 0;
		   $fl           = 0;
		   $fcps         = 0;
		   
		   $fsu          = 0;
		   $flu          = 0;
		   $fcpsu        = 0;
		   
		   $fsnu         = 0;
		   $flnu         = 0;
		   $fcpsnu       = 0;
		   
		   $kacm         = 0;
		    if ($this->getRequest()->isPost()) {
			
			    $code_membre = $request->code_membre_kacm;
				$designation = $request->design_membre_kacm;
				$db_fs = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fs = $db_fs->select();
				$select_fs->from($db_fs,array('SUM(CreditAmount) as somme_fs'));
				
				if($code_membre != '') {
                  $select_fs->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fs->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fs->where('Motif like ?','FS');
                $result_fs = $db_fs->fetchAll($select_fs);
		        $row_fs = $result_fs->current();
		        $fs = $row_fs['somme_fs'];
				
				$db_fl = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fl = $db_fl->select();
				$select_fl->from($db_fl,array('SUM(CreditAmount) as somme_fl'));
				
				if($code_membre != '') {
                  $select_fl->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fl->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fl->where('Motif like ?','FL');
                $result_fl = $db_fl->fetchAll($select_fl);
		        $row_fl = $result_fl->current();
		        $fl = $row_fl['somme_fl'];
				
				
				$db_cps = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cps = $db_cps->select();
				$select_cps->from($db_cps,array('SUM(CreditAmount) as somme_cps'));
				
				if($code_membre != '') {
                  $select_cps->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cps->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cps->where('Motif like ?','FS');
                $result_cps = $db_cps->fetchAll($select_cps);
		        $row_cps = $result_cps->current();
		        $fcps = $row_cps['somme_cps'];
				
				
				$db_fsu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fsu = $db_fsu->select();
				$select_fsu->from($db_fsu,array('SUM(CreditAmount) as somme_fsu'));
				
				if($code_membre != '') {
                  $select_fsu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fsu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fsu->where('Motif like ?','FS');
				$select_fsu->where('IDDateTimeConsumed <> ?',0);
                $result_fsu = $db_fsu->fetchAll($select_fsu);
		        $row_fsu = $result_fsu->current();
		        $fsu = $row_fsu['somme_fsu'];
				
				
				$db_flu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_flu = $db_flu->select();
				$select_flu->from($db_flu,array('SUM(CreditAmount) as somme_flu'));
				
				if($code_membre != '') {
                  $select_flu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_flu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_flu->where('Motif like ?','FL');
				$select_flu->where('IDDateTimeConsumed <> ?',0);
                $result_flu = $db_flu->fetchAll($select_flu);
		        $row_flu = $result_flu->current();
		        $flu = $row_flu['somme_flu'];
				
				
				$db_cpsu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cpsu = $db_cpsu->select();
				$select_cpsu->from($db_cpsu,array('SUM(CreditAmount) as somme_cpsu'));
				
				if($code_membre != '') {
                  $select_cpsu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cpsu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cpsu->where('Motif like ?','CPS');
				$select_cpsu->where('IDDateTimeConsumed <> ?',0);
                $result_cpsu = $db_cpsu->fetchAll($select_cpsu);
		        $row_cpsu = $result_cpsu->current();
		        $fcpsu = $row_cpsu['somme_cpsu'];
				
				
				
				$db_fsnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fsnu = $db_fsnu->select();
				$select_fsnu->from($db_fsnu,array('SUM(CreditAmount) as somme_fsnu'));
				
				if($code_membre != '') {
                  $select_fsnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fsnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fsnu->where('Motif like ?','FS');
				$select_fsnu->where('IDDateTimeConsumed = ?',0);
                $result_fsnu = $db_fsnu->fetchAll($select_fsnu);
		        $row_fsnu = $result_fsnu->current();
		        $fsnu = $row_fsnu['somme_fsnu'];
				
				
				$db_flnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_flnu = $db_flnu->select();
				$select_flnu->from($db_flnu,array('SUM(CreditAmount) as somme_flnu'));
				
				if($code_membre != '') {
                  $select_flnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_flnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_flnu->where('Motif like ?','FL');
				$select_flnu->where('IDDateTimeConsumed = ?',0);
                $result_flnu = $db_flnu->fetchAll($select_flnu);
		        $row_flnu = $result_flnu->current();
		        $flnu = $row_flnu['somme_flnu'];
				
				
				$db_cpsnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cpsnu = $db_cpsnu->select();
				$select_cpsnu->from($db_cpsnu,array('SUM(CreditAmount) as somme_cpsnu'));
				
				if($code_membre != '') {
                  $select_cpsnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cpsnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cpsnu->where('Motif like ?','CPS');
				$select_cpsnu->where('IDDateTimeConsumed = ?',0);
                $result_cpsnu = $db_cpsnu->fetchAll($select_cpsnu);
		        $row_cpsnu = $result_cpsnu->current();
		        $fcpsnu = $row_cpsnu['somme_cpsnu'];
	        }
			
			$this->view->code_membre  = $code_membre;
			$this->view->designation  = $designation;
		    $this->view->fs           = $fs;
			$this->view->fl           = $fl;
			$this->view->fcps         = $fcps;
			
			$this->view->fsu           = $fsu;
			$this->view->flu           = $flu;
			$this->view->fcpsu         = $fcpsu;
			
			$this->view->fsnu           = $fsnu;
			$this->view->flnu           = $flnu;
			$this->view->fcpsnu         = $fcpsnu;
	
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
    <td align="center">Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet<br />
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
$filename = '/var/html/mcnp/public/releve.html';
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
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
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
		      
		}
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
               $data[0] = strtoupper($result->raison_sociale);
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
	
	
	public function detailmf11000Action() {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'neng');
            $sord = $this->_request->getParam("sord", 'asc');
		    $tabela = new Application_Model_DbTable_EuAncienDetailSmsmoney();
		    $code_membre = $this->_request->getParam("code_membre");
		    $select = $tabela->select();
		    if($code_membre != '') {
	           $select->where('code_membre_dist like ?',$code_membre);
	        } else {
			   $select->where('code_membre_dist like ?','%');
			}
			$select->where('origine_sms like ?','MF');
			$select->order('id_detail_smsmoney asc');
			
			$achats = $tabela->fetchAll($select);
            $count = count($achats);
			
			if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }
			
			if ($page > $total_pages) $page = $total_pages;
               $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));
               $responce['page'] = $page;
               $responce['total'] = $total_pages;
               $responce['records'] = $count;
               $i = 0;
			   $tot_entrees = 0;
			   $tot_sorties = 0;
			   $tot_solde = 0;
			   foreach ($achats as $row) {
		        if($row->num_bon == null) {
				  $numero = $row->code_membre;
			    } else {
			      $numero = $row->num_bon;
			    }
                $responce['rows'][$i]['id'] = $row->id_detail_smsmoney;
                $responce['rows'][$i]['cell'] = array(
                   $row->id_detail_smsmoney,
                   $numero,
                   $row->origine_sms.'11000',
                   $row->mont_sms,
			       $row->mont_vendu,
			       $row->solde_sms,
                );
			    $tot_entrees += $row->mont_sms;
			    $tot_sorties += $row->mont_vendu;
			    $tot_solde += $row->solde_sms;
                $i++;
            }
			$responce['userdata']['mont_sms'] = $tot_entrees;
			$responce['userdata']['mont_vendu'] = $tot_sorties;
			$responce['userdata']['solde_sms'] = $tot_solde;
            $responce['userdata']['origine_sms'] = 'Totaux:';
            $this->view->data = $responce;
	}
	
	public function detailmf107Action() {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'neng');
            $sord = $this->_request->getParam("sord", 'asc');
			$code_membre = $this->_request->getParam("code_membre");
			$mf107  = new Application_Model_EuMembreFondateur107();
			$mmf107 = new Application_Model_EuMembreFondateur107Mapper();
		    $tabela = new Application_Model_DbTable_EuRepartitionMf107();
		    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                   ->join('eu_detail_mf107', 'eu_detail_mf107.id_mf107 = eu_repartition_mf107.id_mf107',array('code_membre','id_mf107','mont_apport','pourcentage','numident'));
		    $select->where('eu_repartition_mf107.code_membre like ?',$code_membre);
			//$select->order('eu_repartition_mf107.id_rep asc');
			$select->order('eu_detail_mf107.code_membre asc');
		    //$select = $tabela->select();
	        
			$achats = $tabela->fetchAll($select);
            $count = count($achats);
			
			if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }
			
			if ($page > $total_pages) $page = $total_pages;
               $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));
               $responce['page'] = $page;
               $responce['total'] = $total_pages;
               $responce['records'] = $count;
               $i = 0;
			   $tot_apport = 0;
			   $tot_pourcentage = 0;
			   $tot_entrees = 0;
			   $tot_sorties = 0;
			   $tot_solde = 0;
			   foreach ($achats as $row) {
			    $findmf107 = $mmf107->find($row->numident,$mf107);
				$code_proprio = $mf107->getCode_membre();
				if(($code_proprio == $code_membre) && ($row->code_membre == $code_membre)) {
				  $pourcentage = 100;
				}
			    elseif($code_proprio == $code_membre) {
				  $pourcentage = $row->pourcentage;
				} elseif($row->code_membre == $code_membre) {
				  $pourcentage = 100 - $row->pourcentage;
				}
                $responce['rows'][$i]['id'] = $row->id_rep;
                $responce['rows'][$i]['cell'] = array(
                   $row->id_rep,
                   $row->code_membre,
                   'MF107',
				   $row->mont_apport,
				   $pourcentage,
                   $row->mont_rep,
			       $row->mont_reglt,
			       $row->solde_rep
                );
				$tot_apport += $row->mont_apport;
				//$tot_pourcentage += $row->pourcentage;
			    $tot_entrees += $row->mont_rep;
			    $tot_sorties += $row->mont_reglt;
			    $tot_solde += $row->solde_rep;
                $i++;
            }
			$responce['userdata']['mont_apport'] = $tot_apport;
			//$responce['userdata']['pourcentage'] = $tot_pourcentage;
			$responce['userdata']['mont_rep'] = $tot_entrees;
			$responce['userdata']['mont_reglt'] = $tot_sorties;
			$responce['userdata']['solde_rep'] = $tot_solde;
            $responce['userdata']['origine_sms'] = 'Totaux:';
            $this->view->data = $responce;
	}
	
	
	
	
	
	
	
	
	
	public function detailbonAction() {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'neng');
            $sord = $this->_request->getParam("sord", 'asc');
		    $tabela = new Application_Model_DbTable_EuRepartitionMf11000();
		    $num_bon = $this->_request->getParam("num_bon");
		    $select = $tabela->select();
	        $select->where('code_mf11000 like ?',$num_bon);
			$select->order('id_rep asc');
			
			$achats = $tabela->fetchAll($select);
            $count = count($achats);
			
			if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }
			
			if ($page > $total_pages) $page = $total_pages;
               $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));
               $responce['page'] = $page;
               $responce['total'] = $total_pages;
               $responce['records'] = $count;
               $i = 0;
			   $tot_entrees = 0;
			   $tot_sorties = 0;
			   $tot_solde = 0;
			   foreach ($achats as $row) {
                $responce['rows'][$i]['id'] = $row->id_rep;
                $responce['rows'][$i]['cell'] = array(
                  $row->id_rep,
                  $row->code_mf11000,
                  'MF11000',
                  $row->mont_rep,
			      $row->mont_reglt,
			      $row->solde_rep
                );
			    $tot_entrees += $row->mont_rep;
			    $tot_sorties += $row->mont_reglt;
			    $tot_solde += $row->solde_rep;
                $i++;
            }
			$responce['userdata']['mont_rep'] = $tot_entrees;
			$responce['userdata']['mont_reglt'] = $tot_sorties;
			$responce['userdata']['solde_rep'] = $tot_solde;
            $responce['userdata']['origine_sms'] = 'Totaux:';
            $this->view->data = $responce;
	}
	
	
	
	
	
	
	
	
	public function detailfsAction()   {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'neng');
           $sord = $this->_request->getParam("sord", 'asc');
		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','FS');
			$select->order('neng asc');
			
			$achats = $tabela->fetchAll($select);
            $count = count($achats);
			
			if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }
			
			if ($page > $total_pages) $page = $total_pages;
            $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
			$tot_entrees = 0;
			$tot_sorties = 0;
			$tot_solde = 0;
			foreach ($achats as $row) {
		      if($row->DestAccount_Consumed == null) {
			    $sortie = 0;
				$solde  = $row->CreditAmount;
			  } else {
			    $sortie = $row->CreditAmount;
				$solde  = 0;
			  }
              $responce['rows'][$i]['id'] = $row->NEng;
              $responce['rows'][$i]['cell'] = array(
                $row->NEng,
                $row->FromAccount,
                $row->CreditCode,
                $row->Motif,
			    $row->CreditAmount,
			    $sortie,
                $solde
               );
			   $tot_entrees += $row->CreditAmount;
			   $tot_sorties += $sortie;
			   $tot_solde += $solde;
               $i++;
            }
			$responce['userdata']['CreditAmount'] = $tot_entrees;
			$responce['userdata']['sorti'] = $tot_sorties;
			$responce['userdata']['solde'] = $tot_solde;
            $responce['userdata']['motif'] = 'Totaux:';
            $this->view->data = $responce;
	}
	
	public function detailflAction()   {
	
		   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'neng');
           $sord = $this->_request->getParam("sord", 'asc');
		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','FL');
			$select->order('NEng asc');
			
			$achats = $tabela->fetchAll($select);
            $count = count($achats);
			
			if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }
			
			if ($page > $total_pages) $page = $total_pages;
            $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
			$tot_entrees = 0;
			$tot_sorties = 0;
			$tot_solde = 0;
			foreach ($achats as $row) {
		      if($row->DestAccount_Consumed == null) {
			    $sortie = 0;
				$solde  = $row->CreditAmount;
			  } else {
			    $sortie = $row->CreditAmount;
				$solde  = 0;
			  }
              $responce['rows'][$i]['id'] = $row->NEng;
              $responce['rows'][$i]['cell'] = array(
                $row->NEng,
                $row->FromAccount,
                $row->CreditCode,
                $row->Motif,
			    $row->CreditAmount,
			    $sortie,
                $solde
               );
               $tot_entrees += $row->CreditAmount;
			   $tot_sorties += $sortie;
			   $tot_solde += $solde;
               $i++;
            }
			$responce['userdata']['CreditAmount'] = $tot_entrees;
			$responce['userdata']['sorti'] = $tot_sorties;
			$responce['userdata']['solde'] = $tot_solde;
            $responce['userdata']['motif'] = 'Totaux:';
            $this->view->data = $responce;
	}
	
	
	public function detailfcpsAction()   {
	       
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'neng');
           $sord = $this->_request->getParam("sord", 'asc');
		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','CPS');
			$select->order('neng asc');
			
			$achats = $tabela->fetchAll($select);
            $count = count($achats);
			
			if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }
			
			if ($page > $total_pages) $page = $total_pages;
            $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
			$tot_entrees = 0;
			$tot_sorties = 0;
			$tot_solde = 0;
			foreach ($achats as $row) {
		      if($row->DestAccount_Consumed == null) {
			    $sortie = 0;
				$solde  = $row->CreditAmount;
			  } else {
			    $sortie = $row->CreditAmount;
				$solde  = 0;
			  }
              $responce['rows'][$i]['id'] = $row->NEng;
              $responce['rows'][$i]['cell'] = array(
                $row->NEng,
                $row->FromAccount,
                $row->CreditCode,
                $row->Motif,
			    $row->CreditAmount,
			    $sortie,
                $solde
               );
               $tot_entrees += $row->CreditAmount;
			   $tot_sorties += $sortie;
			   $tot_solde += $solde;
               $i++;
            }
			$responce['userdata']['CreditAmount'] = $tot_entrees;
			$responce['userdata']['sorti'] = $tot_sorties;
			$responce['userdata']['solde'] = $tot_solde;
            $responce['userdata']['motif'] = 'Totaux:';
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

}

?>
