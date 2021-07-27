<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
class  EuRepartitionNnController extends Zend_Controller_Action   {
        public function init() {
          /* Initialize action controller here */
          $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
          $user = $auth->getIdentity();
          $group = $user->code_groupe;
          if ($group == 'alerte' || $group == 'gaca_protect' || $group == 'gacs_protect' || $group == 'gacr_protect' || $group == 'gacp_protect' || $group == 'domi_nrpre' || $group == 'repartition') {
            $menu = "<li><a href=\" /eu-repartition-nn/new \" style=\"font-size:10px\">Nouveau</a></li>" .
                    "<li><a href=\"/eu-repartition-nn\" style=\"font-size:10px\">Liste </a></li>";
          }
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
              $group = $user->code_groupe;
              if ($group != 'alerte'  &&   $group != 'gaca_protect'   &&   $group != 'gacs_protect'  &&   $group != 'gacr_protect' &&  $group != 'gacp_protect'  &&  $group != 'repartition') {
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
	
	public function membremoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre_morale;
        }
        $this->view->data = $data;
    }
	
	
	public function montantapportnnAction() {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $code_membre = $user->code_membre;
	        $id = $_GET["id_proposition"];
		    $tp = new Application_Model_DbTable_EuProposition();
		    $select = $tp->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                   ->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre',array('eu_appel_offre.*','eu_proposition.*'))
				   ->join('eu_appel_nn', 'eu_appel_nn.id_proposition = eu_proposition.id_proposition')
			       ->join('eu_frais', 'eu_frais.id_proposition = eu_proposition.id_proposition',array('eu_frais.*'))
			       ->where('eu_proposition.id_proposition = ?',$id);
		  			
            $results = $tp->fetchAll($select);
            if (count($results) > 0) {
                $data[0] = $results->current()->montant_nn;
		        $data[1] = $results->current()->mont_projet;
			    $data[4] = $code_membre;
			    //$data[4] = $results->current()->membre_morale_executante;
			    $code_compte = 'NN-'.'GCPREP-'.$data[4];
			    $compte_db = new Application_Model_DbTable_EuCompte();
                $compte_find = $compte_db->find($code_compte);
			    if (count($compte_find) == 1) {
                    $result = $compte_find->current();
                    $data[5] = $result->solde;
                } else {
                    $data[5] = 0;
                }
			    $duree = $results->current()->duree_projet;
			    $prk = Util_Utils::getParametre('prk','nr');
                $pck = Util_Utils::getParametre('pck','nr');
			    if($duree <= $prk) {
		           $data[3] = ($data[1] * $pck)/$prk;
				   $data[2] = $data[1] - $data[3];
		        } else {
		           $data[3] = ($data[1] * $pck)/$duree;
				   $data[2] = $data[1] - $data[3];
		        } 
            }   else {
                   $data = 0;
            }
		    $this->view->data = $data;       
	
	}
	
	public function recupraisonAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
                $data[0] = $result->raison_sociale;
        } else {
            $data[0] = '';
        }
        $this->view->data = $data;
    }
	
	public function gcpdispoAction() {
        $num_membre = $_GET['num_membre'];
		$code_compte = 'NN-'.'GCPREP-'.$num_membre;
        $compte_db = new Application_Model_DbTable_EuCompte();
        $compte_find = $compte_db->find($code_compte);
        if (count($compte_find) == 1) {
            $result = $compte_find->current();
                $data[0] = $result->solde;
        } else {
            $data[0] = 0;
        }
        $this->view->data = $data;
    }
	
	
	
	public function offreAction() {
           $t_propo = new Application_Model_DbTable_EuProposition();
           $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
                  ->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre');		
		   $select->where('eu_proposition.choix_proposition = ?',1);
		   $select->where('eu_appel_offre.type_appel_offre like ?','inrpre');		 
           $propo = $t_propo->fetchAll($select);
           if (count($propo) >= 1) {
              $data = array();
              for ($i = 0; $i < count($propo); $i++) {
                  $value = $propo[$i];
                  $data[$i][0] = $value->id_proposition;
                  $data[$i][1] = $value->numero_offre;
              }
          } else {
            $data = '';
          }
          $this->view->data = $data;
	}
	
	
	
    public function dataAction() {
	       $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'id_detail_appel_nn');
           $sord = $this->_request->getParam("sord", 'asc');
           $tabela = new Application_Model_DbTable_EuDetailAppelNn();
		   if(isset($_GET["id"])) {
		      $id = $_GET["id"];
		   } else{$id="";}	  
		         $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		    if ($id != '') {
              $select->setIntegrityCheck(false)
                     ->join('eu_appel_nn', 'eu_appel_nn.id_appel_nn = eu_detail_appel_nn.id_appel_nn')
				     ->where('eu_appel_nn.id_proposition = ?',$id)
					 ->where('eu_detail_appel_nn.payer =?',0)
					 ;
		    $apporteurs = $tabela->fetchAll($select);
		    $count = count($apporteurs);
		    if ($count > 0) {
               $total_pages = ceil($count / $limit);
            } else {
               $total_pages = 0;
            }

        if ($page > $total_pages)
            $page = $total_pages;

        $apporteurs = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($apporteurs as $row) {
		    $dateapport = new Zend_Date($row->date_apport,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_detail_appel_nn;
            $responce['rows'][$i]['cell'] = array(
              $row->code_membre,
              $row->dateapport->toString('dd/MM/yyyy'),
              $row->montant_apport,
			  $row->id_detail_appel_nn,
			  $row->code_compte
            );
            $i++;
        }
        $this->view->data = $responce;	   	   	   
	}
}	
	
	
    public function newAction() {
	     
	}
	
	public function datamAction() {
		   $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'id_detail_appel_nn');
           $sord = $this->_request->getParam("sord", 'asc');
           $tabela = new Application_Model_DbTable_EuDetailAppelNn();
		   if(isset($_GET["numero_offre"])) {
		      $id = $_GET["numero_offre"];
		   }else{
		        $id="";
		   }	  
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		   if ($id != '') {
              $select->setIntegrityCheck(false)
                     ->join('eu_appel_nn', 'eu_appel_nn.id_appel_nn = eu_detail_appel_nn.id_appel_nn')
					 ->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn')
				     ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_detail_appel_nn.code_membre')
				     ->where('eu_appel_nn.id_proposition = ?',$id);
		   $apporteurs = $tabela->fetchAll($select);
		   $count = count($apporteurs);
		   if ($count > 0) {
               $total_pages = ceil($count / $limit);
          } else {
            $total_pages = 0;
          }

        if ($page > $total_pages)
            $page = $total_pages;

        $apporteurs = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($apporteurs as $row) {
            if (substr($row->code_membre,19,1) =='P') {
                $nom = $row->nom_membre." ".$row->prenom_membre;
            } else if (substr($row->code_membre,19,1) =='M') {
                $nom = $row->raison_sociale;
            }
			$daterep = new Zend_Date($row->date_rep,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_rep_nn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_rep_nn,
                $row->code_membre,
                $nom,
                $row->montant_apport,
				$row->mont_marge,
				$row->mont_rep,
                $row->daterep->toString('dd/MM/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;	   
	  }	   
	}
	
	
	
	public function datapAction() {
		   $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'id_detail_appel_nn');
           $sord = $this->_request->getParam("sord", 'asc');
           $tabela = new Application_Model_DbTable_EuDetailAppelNn();
		   if(isset($_GET["numero_offre"])) {
		      $id = $_GET["numero_offre"];
		   }else{$id="";}	  
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		   if ($id != '') {
              $select->setIntegrityCheck(false)
                     ->join('eu_appel_nn', 'eu_appel_nn.id_appel_nn = eu_detail_appel_nn.id_appel_nn')
					 ->join('eu_repartition_nn', 'eu_repartition_nn.id_detail_appel_nn = eu_detail_appel_nn.id_detail_appel_nn')
				     ->join('eu_membre', 'eu_membre.code_membre = eu_detail_appel_nn.code_membre')
				     ->where('eu_appel_nn.id_proposition = ?',$id);
		   $apporteurs = $tabela->fetchAll($select);
		   $count = count($apporteurs);
		   if ($count > 0) {
               $total_pages = ceil($count / $limit);
          } else {
            $total_pages = 0;
          }

        if ($page > $total_pages)
            $page = $total_pages;

        $apporteurs = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($apporteurs as $row) {
            if (substr($row->code_membre,19,1) =='P') {
                $nom = $row->nom_membre." ".$row->PREnom_membre;
            } else if (substr($row->code_membre,19,1) =='M') {
                $nom = $row->raison_sociale;
            }
			$daterep = new Zend_Date($row->date_rep,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_rep_nn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_rep_nn,
                $row->code_membre,
                $nom,
                $row->montant_apport,
				$row->mont_marge,
				$row->mont_rep,
                $row->daterep->toString('dd/MM/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
	  }	   
	}
	
	
	public function payerAction() {
	   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $date_id = new Zend_Date(Zend_Date::ISO_8601);
       $date_idd = clone $date_id;
	   //$selection = array();
       //$selection = $_GET['lignes'];
	   $id = $_GET['id'];
	   $marge = $_GET['marge'];
	   $montant_nn = $_GET['montant_nn'];
	   $code_membre = $_GET['code_membre'];
	   $montant_budget = $_GET['montant_budget'];
	   $code_compte_dem ='nn-gcprep-'.$code_membre;
	   $membre = new Application_Model_EuMembre();
	   $map_membre = new Application_Model_EuMembreMapper();
	   $membremorale = new Application_Model_EuMembreMorale();
	   $map_membremorale = new Application_Model_EuMembreMoraleMapper();
	   $frais      = new Application_Model_EuFrais();
       $frais_m    = new Application_Model_EuFraisMapper();
	   $rep      = new Application_Model_EuRepartitionNn();
       $rep_m    = new Application_Model_EuRepartitionNnMapper();
	   $compte   = new Application_Model_EuCompte();
       $compte_m = new Application_Model_EuCompteMapper();
	   $dappel   = new Application_Model_EuDetailAppelNn();
       $dappel_m = new Application_Model_EuDetailAppelNnMapper();
	   $appel   = new Application_Model_EuAppelNn();
       $appel_m = new Application_Model_EuAppelNnMapper();
	   $acteur  = new Application_Model_EuActeur();
	   
	    $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
	    try { 
		    $respfrais = $frais_m->findFraisByPropo($id,$frais);
			if($respfrais == false) {
			    $db->rollback();
				$this->view->data = 'erreurfrais';
				return; 
			}   else {
			        $margereel = $marge - $frais->getMontant_frais();
					$compteur_r = $rep_m->findConuter() + 1;
                    $rep->setId_rep_nn($compteur_r)
					    ->setId_detail_appel_nn(null)
                        ->setDate_rep($date_idd->toString('yyyy-MM-dd'))
                        ->setMont_rep($frais->getMontant_frais())
				        ->setMont_marge($frais->getMontant_frais())
                        ->setId_utilisateur($user->id_utilisateur)
						->setId_proposition($id);			 
			        $rep_m->save($rep);
						
				    $comptemarge = 'NN-TMARGE-'.$code_membre;
					$result = $compte_m->find($comptemarge,$compte);
			        if($result == true) {
				            $compte->setSolde($compte->getSolde() + $frais->getMontant_frais());
                            $compte_m->update($compte);
			        } else  {
                            $compte->setCode_membre_morale($code_membre)
							       ->setCode_membre(null)
                                   ->setCode_cat('tmarge')
                                   ->setSolde($frais->getMontant_frais())
                                   ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                   ->setCode_compte($comptemarge)
                                   ->setLib_compte('NN MARGE')
                                   ->setCode_type_compte('NN')
                                   ->setDesactiver(0);
                            $compte_m->save($compte);
					}
					$res = $map_membremorale->find($code_membre,$membremorale);
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$membremorale->getPortable_membre(),"Vous venez de beneficier un montant de : " .$frais->getMontant_frais().  "  sur votre compte  ".$comptemarge. "  apres votre participation a la collecte nrPRE");        
			    				
			    }
                 
				$collectes = $dappel_m->findrepbycompte($id);
			    $j = 0;
                $nbre_collectes = count($collectes);
                while ($j < $nbre_collectes) {			  
				        $collecte = $collectes[$j];
                        $id_detailnn = $collecte->getId_detail_appel_nn();
					    $montant_rep =floor($margereel*($collecte->getMontant_apport() / $montant_nn));
			            $detentrice = $acteur->findByActeurDetentrice($collecte->getCode_membre());
					    if($detentrice != false) {
					        $compteur_r = $rep_m->findConuter() + 1;
                            $rep->setId_rep_nn($compteur_r)
					           ->setId_detail_appel_nn($id_detailnn)
                               ->setDate_rep($date_idd->toString('yyyy-MM-dd'))
                               ->setMont_rep($collecte->getMontant_apport() + $montant_rep)
				               ->setMont_marge($montant_rep)
                               ->setId_utilisateur($user->id_utilisateur)
							   ->setId_proposition($id);			 
			                $rep_m->save($rep);
							
							$resultset = $compte_m->find($collecte->getCode_compte(),$compte);
			                if($resultset == true) {
				               $compte->setSolde($compte->getSolde() + $collecte->getMontant_apport());
                               $compte_m->update($compte);
			                } else {
						       $db->rollback();
						       $this->view->data = 'erreurdetentrice';
						       return;
						    }
							$res = $map_membremorale->find($collecte->getCode_membre(),$membremorale);
						    $compteur = Util_Utils::findConuter() + 1;
                            Util_Utils::addSms($compteur,$membremorale->getPortable_membre(),"Vous venez de beneficier un montant de : " .$montant_rep. "  sur votre compte  ".$collecte->getCode_compte(). "  apres votre participation a la collecte nrPRE");        
			        	
					    } else {
						        $compteur_r = $rep_m->findConuter() + 1;
                                $rep->setId_rep_nn($compteur_r)
						            ->setId_detail_appel_nn($id_detailnn)
                                    ->setDate_rep($date_idd->toString('yyyy-MM-dd'))
                                    ->setMont_rep($collecte->getMontant_apport() + $montant_rep)
				                    ->setMont_marge($montant_rep)
                                    ->setId_utilisateur($user->id_utilisateur)
								    ->setId_proposition($id);			 
			                    $rep_m->save($rep);
						
						        $resultset = $compte_m->find($collecte->getCode_compte(),$compte);
			                    if($resultset == true) {
				                   $compte->setSolde($compte->getSolde() + $collecte->getMontant_apport() + $montant_rep);
                                   $compte_m->update($compte);
			                    } else {
						           $db->rollback();
						           $this->view->data = 'erreur';
						           return;
						        }
								$type_membre = substr($collecte->getCode_membre(),19,1);
							    if($type_membre == "P") {
							       $res = $map_membre->find($collecte->getCode_membre(),$membre);
							       $compteur = Util_Utils::findConuter() + 1;
                                   Util_Utils::addSms($compteur,$membre->getPortable_membre(),"Vous venez de beneficier un montant de :  " .$montant_rep. "  sur votre compte  ".$collecte->getCode_compte(). "  apres votre participation a la collecte nrPRE");
							    } else {
							       $res = $map_membremorale->find($collecte->getCode_membre(),$membremorale);
							       $compteur = Util_Utils::findConuter() + 1;
                                   Util_Utils::addSms($compteur,$membremorale->getPortable_membre(),"Vous venez de beneficier un montant de :  "  .$montant_rep.  "  sur votre compte   ".$collecte->getCode_compte(). "  apres votre participation a la collecte nrPRE");
                                }
						}
						
						$find_id = $dappel_m->find($id_detailnn,$dappel);
			            if($find_id == true) {
				           $dappel->setPayer(1);
                           $dappel_m->update($dappel); 
			            }
					  
				    
					$j++;			
			}
			$nn = $appel_m->findByAppel($id);
			$id_appel = $nn->getId_appel_nn();
			$resultat = $appel_m->find($id_appel, $appel);
			if($resultat == true) {
			   $appel->setDisponible(1);
               $appel_m->update($appel);  
			}
			$find_cpte = $compte_m->find($code_compte_dem,$compte);
			if($find_cpte == true) {
			    //$compte->setSolde($compte->getSolde() - ($sel['montant_apport'] + $montant_rep));
			    $compte->setSolde($compte->getSolde() - $montant_budget);
                $compte_m->update($compte);
			} else {
				$db->rollback();
				$this->view->data = 'erreurdem';
				return;
			}  
            $db->commit();
            $this->view->data = 'good';
            return;
			  
	    } catch (Exception $exc) {
                $db->rollback();
                $message = ' : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
			    $this->view->data = $message;
                return;
        }
    }         

}
