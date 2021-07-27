<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuRegionController
 *
 * @author user
 */
 
class EuNnController extends Zend_Controller_Action {

    //put your code here
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' && $group != 'agregat' && $group != 'nn') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-nn/new \" style=\"font-size:9px\">Nouveau</a></li>
                 <li><a href=\" /eu-nn/index \" style=\"font-size:9px\">Ressources créées</a></li>
			     <li><a href=\" /eu-nn/transfert \" style=\"font-size:9px\">Transfert NN</a></li>
			     <li><a id=\"\" href=\"/eu-nn/verifier\" style=\"font-size:9px\">Liste des codes SMS</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    public function indexAction() {
           // action body
           $this->view->jQuery()->enable();
           $this->view->jQuery()->uiEnable();
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
		    $select->where('motif like ?','F%')->order('neng desc')->where('creditcode like ?',$code)->where('fromaccount like ?','NN-TR');
		} else {
            $select->where('motif like ?','F%')->where('fromaccount like ?','NN-TR')->order('neng desc');
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
		    if($row->destaccount_consumed == null) {
			    $entree = 0;
				$solde  = $row->creditamount;
			}else {
			    $entree = $row->creditamount;
				$solde  = 0;
			}
            $responce['rows'][$i]['id'] = $row->neng;
            $responce['rows'][$i]['cell'] = array(
              $row->neng,
              $row->fromaccount,
              $row->creditcode,
              $row->motif,
			  $row->creditamount,
			  $entree,
              $solde
            );
            $i++;
         }
         $this->view->data = $responce;
	
	}
	
	
    public function dataAction() {
	    $date_deb = $_GET["date_deb"];
		$date_fin = $_GET["date_fin"];
		
		if(isset($_GET["date_deb"]) && ($date_deb != '')) {
		   $datedeb = explode("/",$date_deb);
           $date_deb = $datedeb[2] . '-' . $datedeb[1] . '-' . $datedeb[0];
		}   
		if(isset($_GET["date_fin"]) && ($date_fin != '')) {
		   $datefin = explode("/",$date_fin);
		   $date_fin = $datefin[2] . '-' . $datefin[1] . '-' . $datefin[0];
		}
		
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 200);
        $sidx = $this->_request->getParam("sidx", 'date_emission');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuNn();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
               ->from('eu_nn');
        if ($date_deb == '' and $date_fin == '') {
           $datedeb = '%';
           $select->where("eu_nn.date_emission like ?", $datedeb);
        } else if ($date_deb == '') {
           $select->where("eu_nn.date_emission <= ?", $date_fin);
        } else if ($date_fin == '') {
           $select->where("eu_nn.date_emission >= ?", $date_deb);
        } else {
           $select->where("eu_nn.date_emission >= ?", $date_deb);
           $select->where("eu_nn.date_emission <= ?", $date_fin);
        }     
		
        $select->order('eu_nn.date_emission desc');
        $regions = $tabela->fetchAll($select);
        $count = count($regions);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $regions = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $totemis = 0;
        $totremb = 0;
        $totsolde = 0;
        foreach ($regions as $row) {
		    $dateemission = new Zend_Date($row->date_emission, Zend_Date::ISO_8601);
            $totemis+=$row->montant_emis;
            $totremb+=$row->montant_remb;
            $totsolde = $totemis - $totremb;
            $responce['rows'][$i]['id'] = $row->id_nn;
            $responce['rows'][$i]['cell'] = array(
                $row->id_nn,
                $row->emetteur_nn,
                $dateemission->toString('dd/MM/yyyy'),
                $row->code_type_nn,
                $row->montant_emis,
                $row->montant_remb,
                $row->solde_nn,
            );
            $i++;
        }
        $responce['userdata']['type_nn'] = 'Total:';
        $responce['userdata']['montant_emis'] = $totemis;
        $responce['userdata']['montant_remb'] = $totremb;
        $responce['userdata']['solde'] = $totsolde;
        $this->view->data = $responce;
    }

	
    public function saveAction() {
        
    }

	
    public function newAction() {
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $form = new Application_Form_EuNn();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $date_emission = clone $date_id;
                
                 //Enregistrement dans la table eu_nn
                 $code_type_nn = $this->_request->getPost("code_type_nn");
                 $t_nn = new Application_Model_DbTable_EuNn();
                 $nn = new Application_Model_EuNn($form->getValues());
                 $count = $nn->findConuter() + 1;
                 $nn->setId_nn($count)
                    ->setDate_emission($date_emission->toString('yyyy-MM-dd'))
                    ->setType_emission('Manuelle')
                    ->setMontant_emis($this->_request->getPost("montant_emis"))
                    ->setMontant_remb(0)
                    ->setSolde_nn($this->_request->getPost("montant_emis"))
                    ->setEmetteur_nn(null)
                    ->setCode_type_nn($code_type_nn)
                    ->setId_utilisateur($user->id_utilisateur);
                 $t_nn->insert($nn->toArray());
				
				
				 $tnn_mapper = new Application_Model_EuTypeNnMapper();
                 $tnn = new Application_Model_EuTypeNn();
                 $result_tnn = $tnn_mapper->find($code_type_nn, $tnn);
				
				 //Mise à jour du compte général GFS
                 $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                 $cg_fgfn = new Application_Model_EuCompteGeneral();
                 $result3 = $cg_mapper->find('FGS'.$code_type_nn, 'NN', 'E', $cg_fgfn);
                 if ($result3) {
                    $cg_fgfn->setSolde($cg_fgfn->getSolde() + $this->_request->getPost("montant_emis"));
                    $cg_mapper->update($cg_fgfn);
                 } else {
                    $cg_fgfn->setCode_compte('FGS'.$code_type_nn)
                            ->setIntitule('FG Source '.$tnn->getLib_type_nn())
                            ->setService('E')
                            ->setCode_type_compte('NN')
                            ->setSolde($this->_request->getPost("montant_emis"));
                    $cg_mapper->save($cg_fgfn);
                 }
                 return $this->_helper->redirector('index');
            }
        }
		
            // Add the link to the cancel button
            $form->getElement('cancel')->setAttrib('onclick', "window.open('".$this->view->url(array('controller' => 'eu-nn','action' => 'index'), 'default', true)."','_self')");
            $this->view->form = $form;
    
	}

	
    public function editAction() {
      // action body
      $this->_helper->layout->disableLayout();
      $request = $this->getRequest();
      $form = new Application_Form_EuNn();
      $mapper = new Application_Model_DbTable_EuNn();
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_emission = clone $date_id;
                    $section = new Application_Model_EuNn($form->getValues());
                    $section->setDate_emission($date_emission->toString('yyyy-mm-dd'));
                    $mapper->update($section->toArray(), array('id_section = ?' => $section->getId_section()));
                    $db->commit();
                    return $this->_helper->redirector('index');
                    $this->view->form = $form;
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        } else {
            $id_nn = $request->id_nn;
            $rows = $mapper->find($id_nn);
            if (count($rows) > 0) {
                $row = $rows->current();
                $data = array('code_type_nn' => $row->code_type_nn, 'montant_emis' => $row->montant_emis);
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-nn',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }


	
    public function recupmontantAction() {
        $type_transfert = filter_input(input_get, 'type_transfert');

        $montant = Util_Utils::getParametre($type_transfert,'valeur');
		
        if ($montant > 0) {
            $data['montant'] = $montant;
        } else {
            $data = '';
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

	
    public function transfertAction() {
		
	}
	
	
    public function dotransfertAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        $this->_helper->layout->disableLayout();
        $type = $request->type_transfert;
        $tel = $request->tel_dest;
        $montant = $request->mont_transfert;
        
        $code_envoi = "NN-TR";
        $code_recu = $request->code_recu;
        $code_dev = $request->code_dev;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $date = new Zend_Date();
            $sms = new Application_Model_EuSms();
            $tbl_sms = new Application_Model_DbTable_EuSms();
            $sms_money = new Application_Model_EuSmsmoney();
            $money_map = new Application_Model_EuSmsmoneyMapper();
            if ($type != '' && $tel != '' && $montant != '') {
				if ($code_dev != 'XOF') {
                   $code_cours = $code_dev . '-XOF';
                   $cours = new Application_Model_EuCours();
                   $m_cours = new Application_Model_EuCoursMapper();
                   $ret = $m_cours->find($code_cours,$cours);
                   if ($ret) {
                      $montant = $montant * $cours->getVal_dev_fin();
                   } else {
                      $db->rollback();
                      $this->view->data = 'Erreur de traitement: Le cours de cette devise ' . $code_dev . ' n\'est pas encore défini';
                      return;
                   }
                }
                $sect = new Application_Model_DbTable_EuNn();
                $select = $sect->select();
                $select->where('solde_nn > ?',0);
                $select->where('code_type_nn = ?', $type);
                $select->limit(1);
                $rows = $sect->fetchRow($select);
                $cm_map = new Application_Model_EuCompteMapper();
                $cm = new Application_Model_EuCompte();
                $ret = $cm_map->find($code_envoi, $cm);
                if  (count($rows) > 0) {
				   /* if($type == "FS" || $type == "FL" || $type == "FKPS"){
				    $montant_type = Util_Utils::getParametre($type,'valeur');
					    $multiple = $montant / $montant_type;
					    if(is_int($multiple) == false) {
					      $db->rollBack();
					      $this->view->data = " Le montant n'est pas un multiple de ".$type."  : ".$montant_type." ";
                          return;
					    }
				}*/
				$montant_reste = $montant;

                $sect = new Application_Model_DbTable_EuNn();
                $select = $sect->select();
                $select->where('solde_nn > ?', 0);
                $select->where('code_type_nn = ?', $type);
                $select->order(array('id_nn asc'));
                $rows = $sect->fetchAll($select);
			    foreach ($rows as $row) {	
			        $nn = new Application_Model_EuNn();
			        $nn->exchangeArray($row);
				    if ($nn->getSolde_nn() >= $montant_reste) {
						$nn->setMontant_remb($nn->getMontant_remb() + $montant_reste)
                           ->setSolde_nn($nn->getSolde_nn() - $montant_reste);
                        $sect->update($nn->toArray(), array('id_nn = ?' => $nn->getId_nn()));
						break;
				    } else  {	
						$montant_reste -= $nn->getSolde_nn();				
                        $nn->setMontant_remb($nn->getMontant_remb() + $nn->getSolde_nn())
                           ->setSolde_nn($nn->getSolde_nn() - $nn->getSolde_nn());
                        $sect->update($nn->toArray(), array('id_nn = ?' => $nn->getId_nn()));
				 	}		
				}

                $code_transfert = strtoupper(Util_Utils::genererCodeSMS(8));
				// insertion dans la table eu_smsmoney
				$neng = $money_map->findConuter() + 1;
                $sms_money->setNEng($neng)
                		  ->setCode_Agence(null)
                          ->setCreditAmount($montant)
                          ->setSentTo($tel)
                          ->setMotif($type)
                          ->setId_Utilisateur($user->id_utilisateur)
                          ->setCurrencyCode('XOF')
                          ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                          ->setFromAccount($code_envoi)
                          ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                          ->setCreditCode($code_transfert)
                          ->setDestAccount(null)
                          ->setIDDatetimeConsumed(0)
                          ->setDestAccount_Consumed(null)
                          ->setDatetimeConsumed(null)
                          ->setNum_recu($code_recu);
                $money_map->save($sms_money);
            
				// insertion dans la table eu_sms	
				$sms = new Application_Model_EuSms();
				$compteursms = $sms->findConuter() + 1;
                $sms->setNEng($compteursms)
					->setRecipient($tel)
                    ->setSMSBody($montant . ' ont ete ajoute au Code: ' . $code_transfert)
                    ->setDateTime($date->toString('yyyy-mm-dd hh:mm:ss'))
                    ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                    ->setRetries(0)
                    ->setTypeDestinataire(null)
                    ->setDecodeString(null)
                    ->setNom(null)
                    ->setPrenom(null)
                    ->setSociete(null)
                    ->setHeureEnvoi(null)
                    ->setIDDateEnvoi(0)
                    ->setEnvoyeLe(null)
                    ->setEnvoyePar(null)
                    ->setDateEnvoi(null)
                    ->setEtat(0)
                    ->setIDHeureEnvoi(0);
                $tbl_sms->insert($sms->toArray());

                    //$cm->setSolde($cm->getSolde() - $montant);
                    //$cm_map->update($cm);
				
                // insertion dans la table eu_detailsmsmoney				
		        $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
		        $id_detail_smsmoney = $det_sms_m->findConuter() + 1;									
		        $det_sms = new Application_Model_EuDetailSmsmoney();									
		        $det_sms->setId_detail_smsmoney($id_detail_smsmoney)
                        ->setNum_bon(null)
                        ->setCode_membre(null)
                        ->setCode_membre_dist(null)
                        ->setDate_allocation($date->toString('yyyy-MM-dd hh:mm:ss'))
                        ->setId_utilisateur($user->id_utilisateur)
                        ->setCreditcode($code_transfert)
                        ->setMont_sms($montant)
                        ->setMont_vendu(0)
                        ->setMont_regle(0)
                        ->setSolde_sms($montant)
                        ->setType_sms($type)
                        ->setOrigine_sms('sms');
		        $det_sms_m->save($det_sms);
				
                $det_sms_m->find($id_detail_smsmoney, $det_sms);
                $det_sms->setMont_vendu($det_sms->getMont_vendu() + $montant)
		                ->setMont_regle($det_sms->getMont_regle() + $montant)
		                ->setSolde_sms($det_sms->getSolde_sms() - $montant);
                $det_sms_m->update($det_sms);
		
		         // insertion dans la table eu_detailventesms
			    $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			    $det_vtesms = new Application_Model_EuDetailVentesms();
				$id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				$det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						   ->setId_detail_smsmoney($id_detail_smsmoney)
                           ->setCode_membre_dist($det_sms->getCode_membre_dist())
                           ->setCode_membre($det_sms->getCode_membre())
                           ->setType_tansfert($type)
                           ->setCreditcode($code_transfert)
                           ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                           ->setMont_vente($montant)
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCode_produit($type);
                $det_vte_sms->insert($det_vtesms->toArray());

                $db->commit();
                $this->view->data = true;
                return;
				
                } else {
                       $db->rollback();
                       $this->view->data = 'Erreur de traitement: Le solde du transfert est insuffisant ou ce compte n\'existe pas';
                       return;
                }
            } else {
                   $db->rollback();
                   $this->view->data = 'Erreur de traitement: Il y a des champs qui n\'ont pas été renseignés';
                   return;
            }
        } catch (Exception $exc) {
                $db->rollback();
                $this->view->data = 'Erreur de traitement  ' . $exc->getMessage() . $exc->getTraceAsString();
                return;
        }
    }

}

?>
