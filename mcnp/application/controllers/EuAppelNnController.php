<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class  EuAppelNnController   extends  Zend_Controller_Action  {
        public function init() {
          
		  /* Initialize action controller here */
          $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
          $user = $auth->getIdentity();
          $group = $user->code_groupe;
          if ($group == 'alerte' || $group == 'gaca_protect' || $group == 'gacs_protect' || $group == 'gacr_protect' || $group == 'gacp_protect' || $group == 'domi_nrpre' || $group == 'collecte' || $group == 'domiciliation') {
             $menu = "<li><a href=\" /eu-appel-nn/new \" style=\"font-size:10px\">Nouveau</a></li>" .
                    "<li><a href=\"/eu-appel-nn\" style=\"font-size:10px\">Liste </a></li>";
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
                  if ($group != 'alerte' && $group != 'gaca_protect' && $group != 'gacs_protect' && $group != 'gacr_protect' && $group != 'gacp_protect'  &&  $group != 'collecte' &&  $group != 'domiciliation') {
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

	
    public function dataAction() {
		    $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
            $this->_helper->layout->disableLayout();
            $page = $this->_request->getParam("page", 1);
            $limit = $this->_request->getParam("rows", 10);
            $sidx = $this->_request->getParam("sidx", 'id_detail_appel_nn');
            $sord = $this->_request->getParam("sord", 'asc');
            $tabela = new Application_Model_DbTable_EuDetailAppelNn();
		    if(isset($_GET["numero_offre"])) {
		      $id = $_GET["numero_offre"];
		    } else{$id="";}	  
		     $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		    if ($id != '') {
              $select->setIntegrityCheck(false)
                     ->join('eu_appel_nn', 'eu_appel_nn.id_appel_nn = eu_detail_appel_nn.id_appel_nn')
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
			$date_apport   = new Zend_Date($row->date_apport,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_detail_appel_nn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_detail_appel_nn,
                $row->code_membre,
                $nom,
                $row->montant_apport,
                $date_apport->toString('dd/MM/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;	   
	  }	   
	}
	
	public function changemAction() {
        $data = array();
        $membre = new Application_Model_DbTable_EuMembreMorale();
        $select = $membre->select();
        $select->from($membre, array('code_membre_morale'))
                ->order('code_membre_morale asc');
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
                $data[] = $m->code_membre_morale;
        }
        $this->view->data = $data;
    }
	
	public function recupraisonAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[1] = strtoupper($result->raison_sociale) ;
        } else {
            $data = '';
        }
        $this->view->data = $data;
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
                $nom = $row->nom_membre." ".$row->prenom_membre;
            } else if (substr($row->code_membre,19,1) =='M') {
                $nom = $row->raison_sociale;
            }
			$date_apport   =   new Zend_Date($row->date_apport,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_detail_appel_nn;
            $responce['rows'][$i]['cell'] = array(
                  $row->id_detail_appel_nn,
                  $row->code_membre,
                  $nom,
                  $row->montant_apport,
                  $date_apport->toString('dd/MM/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
		   
		   
	   }	   
	
	}
	
	
    public function newAction() {
	     
	}
	
	
	public function donewAction() {
	       $compteur = $_POST['cpteur'];
		   $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		   if ($compteur >= 1) {
			  $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;
			  $proposition = new Application_Model_EuProposition();
			  $map_proposition = new Application_Model_EuPropositionMapper();
			  $membre = new Application_Model_EuMembre();
			  $map_membre = new Application_Model_EuMembreMapper();
			  $membremorale = new Application_Model_EuMembreMorale();
			  $map_membremorale = new Application_Model_EuMembreMoraleMapper();
			  $proposition = new Application_Model_EuProposition();
			  $map_proposition = new Application_Model_EuPropositionMapper();
              $appel = new Application_Model_EuAppelNn();
			  $map_appel = new Application_Model_EuAppelNnMapper();
              $t_appel = new Application_Model_DbTable_EuAppelNn();
              $compte = new Application_Model_EuCompte();
              $map_compte = new Application_Model_EuCompteMapper();
              $dappel = new Application_Model_EuDetailAppelNn();
			  $map_dappel = new Application_Model_EuDetailAppelNnMapper();
              $db = Zend_Db_Table::getDefaultAdapter();
			  $db->beginTransaction();
			  try {
			      $montant = 0;
			      $id_proposition = $_POST["numero_offre"];
				  $code_membreb = $user->code_membre;
                  $appel_nn = $_POST["appel_nn"];
				  $date_fin  = new Zend_Date($_POST["date_fin"]);
				  $total_nn = $_POST['total_nn'];
				  $total_apport = $_POST['total_apport'];
				  $montant_budget = $_POST['montant_budget'];
				  $nrpre = $_POST['nrpre'] * 30;
				  $marge = $montant_budget - $total_nn;
				  $code_compte='NN-CAPA-'.$code_membreb;
				  if($total_apport > $total_nn) {
					  $db->rollBack();
                      $this->view->data = 'Le total des nn collectés  '.$total_apport .'est supérieur au total des nn exigible !!!';
                      return;
				  } else {
					     for ($i = 1; $i <= $compteur; $i++) {
						     $montant = $montant + $_POST["apport" . $i];
						 }
					     $nn = $map_appel->findByAppel($id_proposition);
						 $compteur_appel = $map_appel->findConuter() + 1;
						 if ($nn == null) {
						    $appel->setId_appel_nn($compteur_appel)
								  ->setId_proposition($id_proposition)
						          ->setDesignation_appel($appel_nn)
                                  ->setDate_appel($date_idd->toString('yyyy-mm-dd'))
								  ->setDate_fin($date_fin->toString('yyyy-mm-dd'))
                                  ->setCode_compte($code_compte)
                                  ->setMontant_nn($montant)
                                  ->setDisponible(0)
                                  ->setCode_membre_morale($code_membreb)
                                  ->setId_utilisateur($user->id_utilisateur);			 
					            $map_appel->save($appel);
							    $count= $map_appel->findConuter();
							    for ($i = 1; $i <= $compteur; $i++) {
								
							        $compte_nn='NN-'.$_POST["type_nn" . $i].'-'.$_POST["code_membre" . $i];
									 
									if($_POST["type_nn" . $i] == 'tcncs') {
										  $compte_ts='NN-TSCNCS-'.$_POST["code_membre" . $i];
									 
									} else if($_POST["type_nn" . $i] == 'TPAGCP') {
									      $compte_ts='NN-TSGCP-'.$_POST["code_membre" . $i];
									 
									} else if($_POST["type_nn" . $i] == 'TPAGCI') {
									      $compte_ts='NN-TSGCI-'.$_POST["code_membre" . $i];
									 
									} else if($_POST["type_nn" . $i] == 'TPAGCRPG') {
									      $compte_ts='NN-TSRPG-'.$_POST["code_membre" . $i];
									 
									} else if($_POST["type_nn" . $i] == 'CAPA') { 
									      $compte_ts='NN-CAPA-'.$_POST["code_membre" . $i];
									 
									}
									$compteur_dappel = $map_dappel->findConuter() + 1;
							        $dappel->setId_detail_appel_nn($compteur_dappel)
									       ->setId_appel_nn($count)
						                   ->setCode_membre($_POST["code_membre" . $i])
                                           ->setDate_apport($date_idd->toString('yyyy-mm-dd'))
									       ->setHeure_apport($date_idd->toString('hh:mm:ss'))
                                           ->setMontant_apport($_POST["apport" . $i])
                                           ->setCode_compte($compte_nn)
                                           ->setId_utilisateur($user->id_utilisateur)
										   ->setPayer(0);			 
					                $map_dappel->save($dappel);
									 
									$type_membre = substr($_POST["code_membre".$i],19,1);
									if($type_membre == "P") {
									   $res = $map_membre->find($_POST["code_membre" . $i],$membre);
									   $montant_rep = floor($marge*($_POST["apport" . $i] / $total_nn)) ;
									   $compteur = Util_Utils::findConuter() + 1;
                                       Util_Utils::addSms($compteur,$membre->getPortable_membre,"Nous vous remercions d'avoir participer à la collecte nrPRE au montant de :" . $_POST["apport" . $i]. "La marge de répartition bénéfique " .$marge."  est dans  ".$nrpre. " jours");
									} else {
                                       $res = $map_membremorale->find($_POST["code_membre" . $i],$membremorale);
									   $montant_rep = floor($marge*($_POST["apport" . $i] / $total_nn)) ;
									   $compteur = Util_Utils::findConuter() + 1;
                                       Util_Utils::addSms($compteur,$membremorale->getPortable_membre,"Nous vous remercions d'avoir participer à la collecte nrPRE au montant de :" . $_POST["apport" . $i]. "La marge de répartition  est de : " .$marge."  est dans  ".$nrpre. " jours");
									 
                                    }									  
									 
						             $result = $map_compte->find($compte_ts,$compte);
						             if($result == true) {
								          if($compte->getSolde() >= $_POST["apport" . $i]) {
								              $compte->setSolde($compte->getSolde() - $_POST["apport" . $i]);
                                              $map_compte->update($compte);
								          } else {
									          $db->rollBack();
                                              $this->view->data = 'Le montant apporte est superieur au montant du solde ' .$_POST["apport" . $i]. ' > '.$compte->getSolde();
                                              return;      										   
                                          }									
						            } 
							} 
							$result = $map_compte->find($code_compte, $compte);
                            if ($result == false) {
                                Util_Utils::createCompte($code_compte,'Compte nrPRE',null,$montant,null,'nn',$date_idd->toString('yyyy-mm-dd'),0,$code_membreb);
                            } else {
                                $compte->setSolde($compte->getSolde() + $montant);
                                $map_compte->update($compte);
                            }	 
						} else {
						
						        $id_appel= $nn->getId_appel_nn();
								$result = $map_appel->find($id_appel, $appel);
								if ($result == true) {
								    $appel->setMontant_nn($appel->getMontant_nn() + $montant);
									$appel->setDesignation_appel($appel_nn);
									$appel->setDate_fin($date_fin->toString('yyyy-mm-dd'));
                                    $map_appel->update($appel);
								}
					            for ($i = 1; $i <= $compteur; $i++)   {
								
								    $compte_nn='NN-'.$_POST["type_nn" . $i].'-'.$_POST["code_membre" .$i];
									if($_POST["type_nn" . $i] == 'TCNCS') {
										  $compte_ts='NN-TSCNCS-'.$_POST["code_membre" . $i];
									 
									} else if($_POST["type_nn" . $i] == 'TPAGCP'){
									      $compte_ts='NN-TSGCP-'.$_POST["code_membre" . $i];
										  
									} else if($_POST["type_nn" . $i] == 'TPAGCI'){
									      $compte_ts='NN-TSGCI-'.$_POST["code_membre" . $i];
										  
									} else if($_POST["type_nn" . $i] == 'TPAGCRPG'){
									      $compte_ts='NN-TSRPG-'.$_POST["code_membre" . $i];
										  
									} else if($_POST["type_nn" . $i] == 'CAPA') {
									      $compte_ts='NN-TSCAPA-'.$_POST["code_membre" . $i];
									}
									 
									$compteur_dappel = $map_dappel->findConuter() + 1;
									$dappel->setId_detail_appel_nn($compteur_dappel)
									       ->setId_appel_nn($id_appel)
						                   ->setCode_membre($_POST["code_membre" . $i])
                                           ->setDate_apport($date_idd->toString('yyyy-mm-dd'))
										   ->setHeure_apport($date_idd->toString('hh:mm:ss'))
                                           ->setMontant_apport($_POST["apport" . $i])
                                           ->setCode_compte($compte_nn)
                                           ->setId_utilisateur($user->id_utilisateur)
										   ->setPayer(0);			 
					                 $map_dappel->save($dappel);
									 
									 $type_membre = substr($_POST["code_membre".$i],19,1);
									 if($type_membre == "P") {
									    $res = $map_membre->find($_POST["code_membre" . $i],$membre);
									    $montant_rep = floor($marge*($_POST["apport" . $i] / $total_nn)) ;
									    $compteur = Util_Utils::findConuter() + 1;
                                        Util_Utils::addSms($compteur,$membre->getPortable_membre,"Nous vous remercions d'avoir participer à la collecte nrPRE au montant de :" . $_POST["apport" . $i]. "La marge de répartition bénéfique " .$marge."  est dans  ".$nrpre. " jours");
									 } else {
                                        $res = $map_membremorale->find($_POST["code_membre" . $i],$membremorale);
									    $montant_rep = floor($marge*($_POST["apport" . $i] / $total_nn)) ;
									    $compteur = Util_Utils::findConuter() + 1;
                                        Util_Utils::addSms($compteur,$membremorale->getPortable_membre,"Nous vous remercions d'avoir participer à la collecte nrPRE au montant de :" . $_POST["apport" . $i]. "La marge de répartition  est de : " .$marge."  est dans  ".$nrpre. " jours");
                                     }
                   
                                     $result = $map_compte->find($compte_ts,$compte);
						             if($result == true) {
									    if($compte->getSolde() >= $_POST["apport" . $i]) {
								            $compte->setSolde($compte->getSolde() - $_POST["apport" . $i]);
                                            $map_compte->update($compte);
									    } else {
									          $db->rollBack();
                                              $this->view->data = 'Le montant apporte est superieur au montant du solde '.$_POST["apport" . $i].' > '.$compte->getSolde();
                                              return;      										   
                                        }
						            }									 
						        }
								$result = $map_compte->find($code_compte, $compte);
                                if  ($result == false) {
                                    Util_Utils::createCompte($code_compte,'Compte nrPRE',null,$montant, null,'nn',$date_idd->toString('yyyy-mm-dd'),0,$code_membreb);
                                } else {
                                    $compte->setSolde($compte->getSolde() + $montant);
                                    $map_compte->update($compte);
                                }
					  }   
					  $db->commit();
                      $this->view->data = true;
                      return;
					}	
			    } catch (Exception $e) {
                    $db->rollback();
                    $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
                }
			} 
	 }

	 
	 
	 public function offreAction() {
        $t_propo = new Application_Model_DbTable_EuProposition();
        $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre')
				->where('eu_proposition.disponible = ?',1); 
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
	
	
    public function codesmsAction() {
        $code = $_GET["code"];
		$type = $_GET["type_membre"];
        if ($code != '') {
            $data = array();
			$tdsms = new Application_Model_DbTable_EuDetailVentesms();
			$selection = $tdsms->select();
			if($type=='p') {
                $selection->where('origine_compte  like ?', 'TPAGCRPG')
			             ->orwhere('origine_compte  like ?', 'TCNCS');
			} else {		  
                $selection->where('origine_compte  like ?', 'TPAGCP')
					     ->orwhere('origine_compte  like ?', 'TPAGCI');
			}		  
			$resultat = $tdsms->fetchAll($selection);
			if (count($resultat) > 0) { 
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('creditcode = ?', $code)
			       ->where('motif like ?', 'CAPA')
                   ->where('iddatetimeconsumed = ?', 0);
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $mont_capa = $results->current()->creditamount;
                $data = $mont_capa;
            } else {
                $data = 0;
            }
		  }else {
                $data = 0;
         }	
        }
        $this->view->data = $data;
    }
     
  	
	
	public function montantapportnnAction() {
	       $id = $_GET["id_proposition"];
		   $tnn = new Application_Model_DbTable_EuAppelNn();
           $select = $tnn->select();
           $select->where('id_proposition = ?',$id);
		 			
           $results = $tnn->fetchAll($select);
           if (count($results) > 0) {
              $data = $results->current()->montant_nn;
           } else {
              $data = 0;
           }
		   $this->view->data = $data;       
	
	}
	
	public function datefinAction() {
	   $id = $_GET["id_proposition"];
	   $tnn = new Application_Model_DbTable_EuAppelNn();
	   $select = $tnn->select();
	   $select->from('eu_appel_nn');
	   $select->where('id_proposition = ?',$id);
	   $results = $tnn->fetchAll($select);
       if (count($results) > 0) {
	        $date_fin   =   new Zend_Date($results->current()->date_fin,Zend_Date::ISO_8601);
            $data = $date_fin->toString('dd/MM/yyyy');
       } else {
            $data = 0;
       }
	   $this->view->data = $data;
	}
	
	
	public function designationAction() {
	       $id = $_GET["id_proposition"];
		   $tnn = new Application_Model_DbTable_EuAppelNn();
           $select = $tnn->select();
           $select->where('id_proposition = ?',$id);
		 			
           $results = $tnn->fetchAll($select);
           if (count($results) > 0) {
              $data = $results->current()->designation_appel;
           } else {
              $data = 0;
           }
		   $this->view->data = $data;       
	}
	
	
	
	public function trouvemontantAction() {
	       $id = $_GET["id_proposition"];
	       $t_appel =  new Application_Model_DbTable_EuAppelNn();
	       $selection = $t_appel->select();
	       $selection->where('id_proposition = ?',$id);
	       $appel = $t_appel->fetchAll($selection);
		   
		   if (count($appel) > 0) {
                $prk = Util_Utils::getParametre('prk','nr');
                $pck = Util_Utils::getParametre('pck','nr');
	            $t_propo = new Application_Model_DbTable_EuProposition();
                $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                     ->join('eu_appel_offre','eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre',array('eu_appel_offre.*','eu_proposition.*'))
				     ->join('eu_appel_nn', 'eu_appel_nn.id_proposition = eu_proposition.id_proposition')
			         ->join('eu_frais', 'eu_frais.id_proposition = eu_proposition.id_proposition',array('eu_frais.*'))
			         ->where('eu_proposition.id_proposition = ?',$id); 
                $propo = $t_propo->fetchAll($select);
		        if (count($propo) > 0) {
                   $duree = $propo->current()->duree_projet;
		           $mont_projet = $propo->current()->mont_projet;
			       $mont_apport = $propo->current()->montant_nn;
			       $design_appel = $propo->current()->designation_appel;
				   $date_fin   =   new Zend_Date($propo->current()->date_fin,Zend_Date::ISO_8601);
			       $date_fin = $date_fin->toString('dd/MM/yyyy');
		            if($duree <= $prk) {
		              $mont_nn = ($mont_projet * $pck)/$prk;
		            } else {
		              $mont_nn = ($mont_projet * $pck)/$duree;
		            }
		            $data[0] = round($mont_nn);
			        $data[1] = round($mont_apport);
			        $data[2] = $design_appel;
			        $data[3] = $date_fin;
					$data[4] = round($mont_projet);
					$data[5] = $duree;
                }  else {
	               $data = 0;
	            }
                $this->view->data = $data;
	  } else {
	         $prk = Util_Utils::getParametre('prk','nr');
             $pck = Util_Utils::getParametre('pck','nr');
	         $t_propo = new Application_Model_DbTable_EuProposition();
             $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
             $select->setIntegrityCheck(false)
                    ->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre',array('eu_appel_offre.*','eu_proposition.*'))
				    ->join('eu_frais', 'eu_frais.id_proposition = eu_proposition.id_proposition',array('eu_frais.*'))
			        ->where('eu_proposition.id_proposition = ?',$id); 
             $propo = $t_propo->fetchAll($select);
		     if (count($propo) > 0) {
                $duree = $propo->current()->duree_projet;
		        $mont_projet = $propo->current()->mont_projet;
		        if($duree <= $prk) {
		           $mont_nn = ($mont_projet * $pck)/$prk;
		        } else {
		           $mont_nn = ($mont_projet * $pck)/$duree;
		        }
		            $data[0] = $mont_nn;
			        $data[1] = 0;
			        $data[2] = '';
			        $data[3] = '';
					$data[4] = $mont_projet;
					$data[5] = $duree;
               }  else {
	                $data = 0;
	           }
               $this->view->data = $data;  
	  
	  }
	}
	
	
	
	
	public function montantbudgetnnAction() {
	   $id = $_GET["id_proposition"];
	   //calcul de la pre et du crédit
       $prk = Util_Utils::getParametre('prk','nr');
       $pck = Util_Utils::getParametre('pck','nr');
	   $t_propo = new Application_Model_DbTable_EuProposition();
       $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
       $select->setIntegrityCheck(false)
            ->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre')
			->join('eu_frais', 'eu_frais.id_proposition = eu_proposition.id_proposition')
			->where('eu_proposition.id_proposition = ?',$id); 
       $propo = $t_propo->fetchAll($select);	   
	   if (count($propo) > 0) {
         $duree = $propo->current()->duree_projet;
		 $mont_projet = $propo->current()->mont_projet;
		 if($duree <= $prk) {
		    $mont_nn = ($mont_projet * $pck)/$prk;
		 } else {
		    $mont_nn = ($mont_projet * $pck)/$duree;
		 }
		    $data = $mont_nn;
     } else {
	    $data = 0;
	 }
      $this->view->data = $data;     
	}
	 
	public function soldennAction() {
       $code_membre = $_GET["membre"];
       $type_compte = $_GET["compte"];
	   $type_membre = $_GET["type_membre"];
       if ($code_membre != '' && $type_compte) {
          $tsms = new Application_Model_DbTable_EuCompte();
          $select = $tsms->select();
		  if($type_membre=='P' ) {
		      if($type_compte =='TPAGCRPG' || $type_compte =='TCNCS'){
                $select->where('code_compte like ?','NN-TS%')
			            ->where('code_membre like ?', $code_membre)
                        ->where('code_cat = ?', $type_compte)
                        ->where('code_type_compte like ?', 'NN');
			  } elseif($type_compte =='CAPA'){
                $select->where('code_compte like ?','NN-CAPA%')
			            ->where('code_membre like ?', $code_membre)
                        ->where('code_cat = ?', $type_compte)
                        ->where('code_type_compte like ?', 'NN');
               }			  
		  }else {
		      if($type_compte =='TPAGCI' || $type_compte =='TPAGCP') {
                $select->where('code_compte like ?','NN-TS%')
			           ->where('code_membre_morale like ?', $code_membre)
                       ->where('code_cat = ?', $type_compte)
                       ->where('code_type_compte like ?', 'NN');
			  } elseif($type_compte =='CAPA') {
                $select->where('code_compte like ?','NN-CAPA%')
			           ->where('code_membre like ?', $code_membre)
                       ->where('code_cat = ?', $type_compte)
                       ->where('code_type_compte like ?', 'NN');
                }		   
          }			
          $results = $tsms->fetchAll($select);
          if (count($results) > 0) {
                $data = $results->current()->solde;
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
    }
	 
	 
	public function recupnomAction() {
       $num_membre = $_GET['num_membre'];
	   $type_membre = $_GET['type_membre'];
		
	   if($type_membre=='P') {
       $membre_db = new Application_Model_DbTable_EuMembre();
       $membre_find = $membre_db->find($num_membre);
            if (count($membre_find) == 1) {
                 $result = $membre_find->current();
                 $data[1] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
            } else {
                   $data = '';
            }
		} else {
		  $membre_db = new Application_Model_DbTable_EuMembreMorale();
          $membre_find = $membre_db->find($num_membre);
             if (count($membre_find) == 1) {
                 $result = $membre_find->current();
                 $data[1] = strtoupper($result->raison_sociale) ;
             } else {
                   $data = '';
             }
		}
		
        $this->view->data = $data;
    }
	 
	 
     public function membreapporteurAction() {
	        $data = array();
	        $type_membre = $_GET["type_membre"];
		    if($type_membre!='' && $type_membre=='P') {
		      $mb = new Application_Model_DbTable_EuMembre();
              $result = $mb->fetchAll();
              foreach ($result as $p) {
                  $data[] = $p->code_membre;
              }   
		    }
		    else if($type_membre!='' && $type_membre=='M') {
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

}
