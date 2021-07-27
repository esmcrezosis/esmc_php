<?php

Class EuMfController extends Zend_Controller_Action {
       public function init() {
          /* Initialize action controller here */
          $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
          $user = $auth->getIdentity();
          $group = $user->code_groupe;
          if ($group == 'banque' || $group == 'apa') {
             $menu = "<li><a href=\" /eu-mf/new \" style=\"font-size:10px\">Nouveau</a></li>" .
                     "<li><a href=\"/eu-mf\" style=\"font-size:10px\">Consultation </a></li>".
					 "<li><a href=\"/eu-mf/verifier\" style=\"font-size:10px\">Tableau de bord mf</a></li>"
					 ;
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
            if ($user->code_groupe != 'apa' && $user->code_groupe != 'banque') {
               $this->view->user = $user;
               return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
	
	
	public function indexAction(){
	
	}
	
    public function newAction() {
	
	}
	
	public function verifierAction() {
	
	}
	
	
	public function dataverifierAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'neng');
        $sord = $this->_request->getParam("sord", 'asc');
		$tabela = new Application_Model_DbTable_EuSmsmoney();
		$code = $this->_request->getParam("code");
		
        $select = $tabela->select();
		if ($code != '') {
		   $select->where('motif like ?','mf%')
		          ->order('neng desc')
				  ->where('creditcode like ?',$code);
		}else{
           $select->where('motif like ?','mf%')
		          ->order('neng desc');
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
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($achats as $row) {
		    if($row->destaccount_consumed == ' ') {
			    $sortie = 0;
				$solde  = $row->creditamount;
			}else {
			    $sortie = $row->creditamount;
				$solde  = 0;
			}
            $responce['rows'][$i]['id'] = $row->neng;
            $responce['rows'][$i]['cell'] = array(
              $row->neng,
              $row->fromaccount,
              $row->creditcode,
              $row->motif,
              $row->creditamount,
              $sortie,
              $solde
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
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_operation');
        $sord = $this->_request->getParam("sord", 'asc');
		
		$code_membre = $this->_request->getParam("membre");
        $type_mf = $this->_request->getParam("type_mf");
        $date = $this->_request->getParam("date");
		
        $tabela = new Application_Model_DbTable_EuOperation();
        $date_deb = Zend_Date::now();
        $select = $tabela->select();
		
		
		if ($date != '' && $type_mf != '' && $code_membre != '') {
	        $date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
			$select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		           ->where('id_utilisateur like ?', $user->id_utilisateur)
                   ->where('code_cat like ?','t'.$type_mf)
				   ->where('date_op like ?',$dated)
				   ->where('code_membre like ?',$code_membre)
                   ->order('date_op', 'asc');
			
		}elseif($date != '' && $type_mf != '') {
		    $date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
			$select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		           ->where('id_utilisateur like ?', $user->id_utilisateur)
                   ->where('code_cat like ?','t'.$type_mf)
				   ->where('date_op like ?',$dated)
                   ->order('date_op', 'asc');
		
		}elseif($date != '' && $code_membre != '') {
		    $date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
			$select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		           ->where('id_utilisateur like ?', $user->id_utilisateur)
                   ->where('code_cat like ?','tmf%')
				   ->where('date_op like ?',$dated)
                   ->order('date_op', 'asc');
		
		}elseif($type_mf != '' && $code_membre != '') {
		    $select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		           ->where('id_utilisateur like ?', $user->id_utilisateur)
                   ->where('code_cat like ?','t'.$type_mf)
				   ->where('code_membre like ?',$code_membre)
                   ->order('date_op', 'asc');
		
		}
		elseif($date != '') {
            
			$date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
			$select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		           ->where('id_utilisateur like ?', $user->id_utilisateur)
				   ->where('date_op like ?',$dated)
                   ->order('date_op', 'asc');
			
			
        }elseif($type_mf != '') {
			 $select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		            ->where('id_utilisateur like ?', $user->id_utilisateur)
                    ->where('code_cat like ?','t'.$type_mf)
                    ->order('date_op', 'asc'); 

        }elseif($code_membre != '') {
			$select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		           ->where('id_utilisateur like ?', $user->id_utilisateur)
				   ->where('code_membre like ?',$code_membre)
                   ->order('date_op', 'asc');

        }else{		
              $select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		             ->where('id_utilisateur like ?', $user->id_utilisateur)
                     ->where('code_cat like ?','tmf%')
                     ->order('date_op', 'asc');
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
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
              $row->id_operation,
              $row->dateop,
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
	
	
	
	
	
    public function donewAction() {
	       $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
           $request = $this->getRequest();
		   if ($this->getRequest()->isPost()) {
	           //$code_membre = $_POST["code_membre"];
			   //$type_capa   = $_POST["code_type_mf"];
			   //$code_sms    = $_POST["code_sms"];
			   //$mont_capa   = $_POST["mont_capa"];
			   //$dev_capa    = $_POST["dev_capa"];
			   
			   $code_membre = $request->code_membre;
               $type_capa = $request->type_mf;
               $code_sms = $request->code_sms;
               $mont_capa = $request->mont_capa;
               $dev_capa = $request->dev_capa;
			   $credi = 0;
			   $date_fin = new Zend_Date(Zend_Date::ISO_8601);
               $date_deb = clone $date_fin;
			   $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			   try {
			       $m_membre = new Application_Model_EuMembreMapper();
                   $membre = new Application_Model_EuMembre();
                   $retour = $m_membre->find($code_membre,$membre);
				   //Mise à jour des comptes credits
                   $cc_mapper = new Application_Model_EuCompteCreditMapper();
                   $source = $code_membre . $date_deb->toString('yyyyMMddHHmmss');
                   $max_code = $cc_mapper->findConuter() + 1;
                   $periode = Util_Utils::getParametre('periode','valeur');
                   $date_fin->addDay($periode);
                   $compte_source = '';
				   if (!$retour) {
				       $db->rollBack();
                       $this->view->data = " Ce membre n'existe pas: " .$code_membre;
                       $this->view->code_membre = $code_membre;
                       $this->view->type_capa = $type_capa;
                       $this->view->mont_capa = $mont_capa;
                       $this->view->dev_capa = $dev_capa;
                       return;
                   } else {
				          $cm_mapper = new Application_Model_EuCompteMapper();
                          $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                          $sms = $sms_mapper->findByCreditCode($code_sms); 
                          if ($sms != null && $sms->getIDDateTimeConsumed() == 0) {
                             $montant = $sms->getCreditAmount();
                             if ($dev_capa != 'xof') {
                                 $code_cours = $dev_capa . '-xof';
                                 $cours = new Application_Model_EuCours();
                                 $m_cours = new Application_Model_EuCoursMapper();
                                 $ret = $m_cours->find($code_cours, $cours);
                                 if ($ret) {
                                    if ($montant != '') {
                                       $montant = $montant * $cours->getVal_dev_fin();
                                    }
                                }
                            }
                        }
					   // Contrôle sur les type de capa
					   if($sms->getMotif() != $type_capa) {
					      $db->rollBack();
					      $this->view->data = " Le motif de ce type de capa n'est pas correspondant pour ce type d'operation";
                          $this->view->code_membre = $code_membre;
                          $this->view->type_capa = $type_capa;
                          $this->view->mont_capa = $mont_capa;
                          $this->view->dev_capa = $dev_capa;
                          return;    
					    }
					     // Contrôle sur le montant
					     $multiple = $montant/70000;
					     if(is_int($multiple) == false) {
					        $db->rollBack();
					        $this->view->data = " Le montant du capa mf n'est pas un multiple de 70000 ";
                            $this->view->code_membre = $code_membre;
                            $this->view->type_capa = $type_capa;
                            $this->view->mont_capa = $mont_capa;
                            $this->view->dev_capa = $dev_capa;
                            return;
					     }
						
					     if($type_capa == 'MF107') {
						   try {
					        $code_cat = 'TMF107';
					        $lib_op   = 'Achat de MF107';
					        $code_compte= 'nn-TMF107-'.$code_membre;
					        $emf = Util_Utils::getParametre('EMF107','valeur');
						    //Paramètre de renouvellement
                            $mf = Util_Utils::getParametre($type_capa,'valeur');
						    $quotamf = Util_Utils::getParametre('quotaMF','valeur');
					        $umf = Util_Utils::findquota($code_membre,$code_cat);
					        $umfp = Util_Utils::findquotabypays($user->id_pays,$code_cat);
						    if($umf >= $quotamf) {
					            $db->rollBack();
					            $this->view->data = "Le quota maximal d'unite  ".$type_capa."  est deja atteint pour le membre :  ".$code_membre;
                                $this->view->code_membre = $code_membre;
                                $this->view->type_capa = $type_capa;
                                $this->view->mont_capa = $mont_capa;
                                $this->view->dev_capa = $dev_capa;
                                return;    
					        }
						    $compte_source = 'CAPAMF107';
						    $mapper = new Application_Model_EuOperationMapper();
                            $compteur = $mapper->findConuter() + 1;
							
						    Util_Utils::addOperation($compteur,$code_membre,null,$code_cat,$montant,$type_capa,$lib_op,'apa',$date_deb,$date_deb,$user->id_utilisateur);
                       
                            $compte = new Application_Model_EuCompte();
                            $result = $cm_mapper->find($code_compte, $compte);
                            if ($result == false) {
                                $type_compte = 'nn';
                                Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,$code_membre,$type_compte,$date_deb,0,null);
                            } else {
                                $compte->setSolde($compte->getSolde() + $credi);
                                $cm_mapper->update($compte);
                            }
					   
					        Util_Utils::createCompteCredit($max_code,1,$compteur,$code_membre,$type_capa,$code_compte,$credi,$montant,$date_deb,$date_fin,$source,$compte_source,'n','o',0,0,nULL, '', nULL);	
					   
					        // Mise à jour des capa
                           $m_capa = new Application_Model_EuCapaMapper();
                           $capa = new Application_Model_EuCapa();
                           $code_capa = 'capa' . $type_capa . $date_deb->toString('yyyyMMddHHmmss');
                           $capa->setCode_capa($code_capa)
                                ->setCode_compte($code_compte)
                                ->setDate_capa($date_deb->toString('yyyy-mm-dd'))
                                ->setHeure_capa($date_deb->toString('hh:mm:ss'))
                                ->setCode_membre($code_membre)
                                ->setMontant_capa($montant)
                                ->setType_capa('mf')
                                ->setCode_produit($type_capa)
                                ->setId_operation($compteur)
                                ->setEtat_capa('Actif')
                                ->setId_credit($max_code)
							    ->setOrigine_capa('sms')
								->setMontant_utiliser($montant)
                                ->setMontant_solde(0);
                            $m_capa->save($capa);

                            $m_capa_affect = new Application_Model_EuCapaAffecterMapper();
                            $capa_affect   = new Application_Model_EuCapaAffecter();
                            $capa_affect->setCode_capa($code_capa)
                                        ->setDuree_renouvellement($mf)
                                        ->setReste_duree($mf)
                                        ->setMont_invest(round($montant*$mf))
                                        ->setId_credit($max_code)
                                        ->setType_credit($type_capa);
                            $m_capa_affect->save($capa_affect);
						    if ($sms) {
                                $sms->setDestAccount_Consumed($code_compte)
                                    ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                    ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                $sms_mapper->update($sms); 					   
						    }
							} catch (Exception $exc) {
                                    $db->rollback();
                                    $data = 'Erreur d\'execution : ' . $exc->getMessage();
                                    $this->view->data = $data;
                                    $this->view->code_membre = $code_membre;
                                    $this->view->type_capa = $type_capa;
                                    //$this->view->mont_capa = $mont_capa;
					                $this->view->mont_capa = $umf;
                                    $this->view->dev_capa = $dev_capa;
                                    return;
                            }
							
					     
					  }else {
                             $umfp = Util_Utils::findquotabypays($user->id_pays,'TMF107');
				             $emf = Util_Utils::getParametre('EMF107','valeur'); 
							 if($umfp >= $emf) {
							        if($type_capa == 'MF11000') {
									    try {
							            $code_cat = 'TMF11000';
					                    $code_compte= 'nn-TMF11000-'.$code_membre;
					                    $lib_op   = 'Achat de MF11000';
					                    $emf = Util_Utils::getParametre('EMF11000','valeur');									
                                        //Paramètre de renouvellement
                                        $mf = Util_Utils::getParametre($type_capa,'valeur');
						                $quotamf = Util_Utils::getParametre('quotaMF','valeur');
					                    $umf = Util_Utils::findquota($code_membre,$code_cat);
					                    $umfp = Util_Utils::findquotabypays($user->id_pays,$code_cat);
						                if($umf >= $quotamf) {
					                        $db->rollBack();
					                        $this->view->data = "Le quota maximal d'unite  ".$type_capa."  est deja atteint pour le membre :  ".$code_membre;
                                            $this->view->code_membre = $code_membre;
                                            $this->view->type_capa = $type_capa;
                                            $this->view->mont_capa = $mont_capa;
                                            $this->view->dev_capa = $dev_capa;
                                            return;    
					                    }
										$compte_source = 'CAPAMF11000';
						                $mapper = new Application_Model_EuOperationMapper();
                                        $compteur = $mapper->findConuter() + 1;
						                Util_Utils::addOperation($compteur,$code_membre,null,$code_cat,$montant,$type_capa,$lib_op,'apa',$date_deb,$date_deb,$user->id_utilisateur);
                                        
										 $compte = new Application_Model_EuCompte();
                                         $result = $cm_mapper->find($code_compte, $compte);
                                         if ($result == false) {
                                             $type_compte = 'nn';
                                             Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,$code_membre,$type_compte,$date_deb,0,null);
                                         } else {
                                             $compte->setSolde($compte->getSolde() + $credi);
                                             $cm_mapper->update($compte);
                                         }
										 Util_Utils::createCompteCredit($max_code,1,$compteur,$code_membre,$type_capa,$code_compte,$credi,$montant,$date_deb,$date_fin,$source,$compte_source,'n','o',0,0,nULL,'', nULL);	
					   
					                  // Mise à jour des capa
                                      $m_capa = new Application_Model_EuCapaMapper();
                                      $capa = new Application_Model_EuCapa();
                                      $code_capa = 'capa' . $type_capa . $date_deb->toString('yyyyMMddHHmmss');
                                      $capa->setCode_capa($code_capa)
                                           ->setCode_compte($code_compte)
                                           ->setDate_capa($date_deb->toString('yyyy-mm-dd'))
                                           ->setHeure_capa($date_deb->toString('hh:mm:ss'))
                                           ->setCode_membre($code_membre)
                                           ->setMontant_capa($montant)
                                           ->setType_capa('mf')
                                           ->setCode_produit($type_capa)
                                           ->setId_operation($compteur)
                                           ->setEtat_capa('Actif')
                                           ->setId_credit($max_code)
							               ->setOrigine_capa('sms')
										   ->setMontant_utiliser($montant)
                                           ->setMontant_solde(0);
                                       $m_capa->save($capa);

                                       $m_capa_affect = new Application_Model_EuCapaAffecterMapper();
                                       $capa_affect   = new Application_Model_EuCapaAffecter();
                                       $capa_affect->setCode_capa($code_capa)
                                                   ->setDuree_renouvellement($mf)
                                                   ->setReste_duree($mf)
                                                   ->setMont_invest($montant*$mf)
                                                   ->setId_credit($max_code)
                                                   ->setType_credit($type_capa);
                                       $m_capa_affect->save($capa_affect);
						               if ($sms) {
                                           $sms->setDestAccount_Consumed($code_compte)
                                               ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                           $sms_mapper->update($sms); 					   
						                }
										} catch (Exception $exc) {
                                            $db->rollback();
                                            $data = 'Erreur d\'execution : ' . $exc->getMessage();
                                            $this->view->data = $data;
                                            $this->view->code_membre = $code_membre;
                                            $this->view->type_capa = $type_capa;
                                            //$this->view->mont_capa = $mont_capa;
					                        $this->view->mont_capa = $umf;
                                            $this->view->dev_capa = $dev_capa;
                                            return;
                                        }
							        }else {
									      $umfp = Util_Utils::findquotabypays($user->id_pays,'TMF11000');
				                          $emf = Util_Utils::getParametre('EMF11000','valeur');
                                          if($umfp >= $emf) {
										    try {
										    $code_cat = 'tmfl';
					                        $lib_op   = 'Achat de mfl';
					                        $code_compte= 'nn-tmfl-'.$code_membre;
							                //Paramètre de renouvellement
                                            $mf = Util_Utils::getParametre($type_capa,'valeur');
						                    $quotamf = Util_Utils::getParametre('quotaMF','valeur');   
											if($umf >= $quotamf) {
					                           $db->rollBack();
					                           $this->view->data = "Le quota maximal d'unite  ".$type_capa."  est deja atteint pour le membre :  ".$code_membre;
                                               $this->view->code_membre = $code_membre;
                                               $this->view->type_capa = $type_capa;
                                               $this->view->mont_capa = $mont_capa;
                                               $this->view->dev_capa = $dev_capa;
                                               return;    
					                        }
                                             $compte_source = 'capamfl';
						                     $mapper = new Application_Model_EuOperationMapper();
                                             $compteur = $mapper->findConuter() + 1;
						                     Util_Utils::addOperation($compteur,$code_membre,null,$code_cat,$montant,$type_capa,$lib_op,'apa',$date_deb,$date_deb,$user->id_utilisateur);
                       
                                             $compte = new Application_Model_EuCompte();
                                             $result = $cm_mapper->find($code_compte, $compte);
                                             if ($result == false) {
                                                 $type_compte = 'nn';
                                                 Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,$code_membre,$type_compte,$date_deb,0,null);
                                             } else {
                                                  $compte->setSolde($compte->getSolde() + $credi);
                                                  $cm_mapper->update($compte);
                                             }
                                              Util_Utils::createCompteCredit($max_code,1,$compteur,$code_membre,$type_capa,$code_compte,$credi,$montant,$date_deb,$date_fin,$source,$compte_source,'n','o',0,0,nULL,'',nULL);	
					   
					                       // Mise à jour des capa
                            $m_capa = new Application_Model_EuCapaMapper();
                            $capa = new Application_Model_EuCapa();
                            $code_capa = 'capa' . $type_capa . $date_deb->toString('yyyyMMddHHmmss');
                            $capa->setCode_capa($code_capa)
                                 ->setCode_compte($code_compte)
                                 ->setDate_capa($date_deb->toString('yyyy-mm-dd'))
                                 ->setHeure_capa($date_deb->toString('hh:mm:ss'))
                                 ->setCode_membre($code_membre)
                                 ->setMontant_capa($montant)
                                 ->setType_capa('mf')
                                 ->setCode_produit($type_capa)
                                 ->setId_operation($compteur)
                                 ->setEtat_capa('Actif')
                                 ->setId_credit($max_code)
							     ->setOrigine_capa('sms')
								 ->setMontant_utiliser($montant)
                                 ->setMontant_solde(0);
                            $m_capa->save($capa);

                            $m_capa_affect = new Application_Model_EuCapaAffecterMapper();
                            $capa_affect   = new Application_Model_EuCapaAffecter();
                            $capa_affect->setCode_capa($code_capa)
                                        ->setDuree_renouvellement($mf)
                                        ->setReste_duree($mf)
                                        ->setMont_invest($montant*$mf)
                                        ->setId_credit($max_code)
                                        ->setType_credit($type_capa);
                            $m_capa_affect->save($capa_affect);
						
						    if ($sms) {
                                $sms->setDestAccount_Consumed($code_compte)
                                    ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                    ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                $sms_mapper->update($sms);       
							}
                            } catch (Exception $exc) {
                                    $db->rollback();
                                    $data = 'Erreur d\'execution : ' . $exc->getMessage();
                                    $this->view->data = $data;
                                    $this->view->code_membre = $code_membre;
                                    $this->view->type_capa = $type_capa;
                                    //$this->view->mont_capa = $mont_capa;
					                $this->view->mont_capa = $umf;
                                    $this->view->dev_capa = $dev_capa;
                                    return;
                            }							
										  
										  
										  
						}else {
												$db->rollBack();
					                            $this->view->data = "Le quota maximal d'unité MF11000 n'a pas encore atteint pour le pays ";
                                                $this->view->code_membre = $code_membre;
                                                $this->view->type_capa = $type_capa;
                                                $this->view->mont_capa = $mont_capa;
                                                $this->view->dev_capa = $dev_capa;
                                                return;
										  }
										  
									
									}
							 
							 }else {
							       $db->rollBack();
					               $this->view->data = "Le quota maximal d'unité MF107 n'a pas encore atteint pour le pays ";
                                   $this->view->code_membre = $code_membre;
                                   $this->view->type_capa = $type_capa;
                                   $this->view->mont_capa = $mont_capa;
                                   $this->view->dev_capa = $dev_capa;
                                   return;
							 }




					  }
				      $comp = Util_Utils::findConuter() + 1;
                      Util_Utils::addSms($comp,$membre->getPortable_membre(),"Vous venez de placer " . $montant . " " . $dev_capa . " sur le compte " . $code_compte . ". Solde final: " . $compte->getSolde());
                      $db->commit();
                      $this->view->data = true;
				      return;
                    }
					  
			   } catch (Exception $exc) {
                       $db->rollback();
                       $data = 'Erreur d\'execution : ' . $exc->getMessage();
                       $this->view->data = $data;
                       $this->view->code_membre = $code_membre;
                       $this->view->type_capa = $type_capa;
                       //$this->view->mont_capa = $mont_capa;
					   $this->view->mont_capa = $umf;
                       $this->view->dev_capa = $dev_capa;
                       return;
                }
	
	        }
	}
	
	 public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        if (substr($num_membre,19,1) == 'm') {
		    $membre_db = new Application_Model_DbTable_EuMembreMorale();
            $membre_find = $membre_db->find($num_membre);
		    if (count($membre_find) == 1) {
			    $result = $membre_find->current();
                $data[2] = $result->raison_sociale;
		   }
                 				 
        }else if (substr($num_membre,19,1) == 'p'){
			$membre_db = new Application_Model_DbTable_EuMembre();
            $membre_find = $membre_db->find($num_membre);
            if (count($membre_find) == 1) {
                $result = $membre_find->current();
                $data[0] = strtoupper($result->nom_membre);
                $data[1] = ucfirst($result->prenom_membre);
			} 	
        } else {
               $data = '';
        }
        $this->view->data = $data;
    }
	
	 public function codesmsAction() {
        $code = $_GET["code"];   
        if ($code != '') {
            $data = array();
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('creditcode = ?', $code)
                    ->where('iddatetimeconsumed = ?', 0);
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $mont_capa = $results->current()->creditamount;
                $data[0] = $mont_capa;
                
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
	
	
	public function membreAction() {
        $request = $this->getRequest();
        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAllByType($request->type);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $this->view->data = $membres;
    }
	
	
	public function typemfAction() {
         $t_mf = new Application_Model_DbTable_EuTypeMf();
         $select = $t_mf->select();        
         $mf = $t_mf->fetchAll($select);
         if (count($mf) >= 1) {
            $data = array();
            for ($i = 0; $i < count($mf); $i++) {
                $value = $mf[$i];
                $data[$i][0] = $value->code_type_mf;
                $data[$i][1] = $value->lib_type_mf;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
	}























}

 ?>