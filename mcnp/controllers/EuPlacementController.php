<?php

class EuPlacementController extends Zend_Controller_Action {

    public function init() {

        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($user->code_groupe == 'banque' || $user->code_groupe == 'apa') {
            $menu = '<ul id="menu_acc">
              <li><a class="menuLink">rpg</a>
                    <ul style="width: 150px;z-index:1000000">
                        <li><a id="rpgr" href="/eu-placement/newr?type=rpg">Récurrent</a></li>
                        <li><a id="rpgnr" href="/eu-placement/newnr?type=rpg">Non Récurrent</a></li>
                        <li><a id="rpgnr" href="/eu-placement/nrpre?type=rpg">Non Récurrent pre</a></li>
                    </ul>
              </li>
              <li><a class="menuLink">Investissement</a>
                     <ul style="width: 150px;z-index:1000000">
                        <li><a id="rpgr" href="/eu-placement/newr?type=i">Récurrent</a></li>
                        <li><a id="rpgr" href="/eu-placement/newnr?type=i">Non Récurrent</a></li>
                        <li><a id="rpgnr" href="/eu-placement/nrpre?type=i">Non Récurrent pre</a></li>
                     </ul>
              </li>  
              <li><a class="menuLink">Consultations</a>
                  <ul style="width: 150px;z-index:1000000">
                      <li><a id="credit" href="/consultation/credit">Crédits</a></li>
                      <li><a id="compte" href="/consultation/compte">Comptes</a></li>
                      <li><a id="operation" href="/consultation/operations">Opérations</a></li>
                      <li><a id="credit" href="/consultation/index">Consultation</a></li>
                  </ul>
              </li>
              <li><a class="menuLink">Recharges</a>
                  <ul style="width: 150px;z-index:1000000">
                      <li><a id="credit" href="/eu-placement/rechargetr">Recharges de tr</a></li>
                      <li><a id="credit" href="/eu-placement/rechargenn">Recharges de capa</a></li>
                  </ul>
              </li>
           </ul>';
            $this->view->placeholder("menu_accordeon")->set($menu);
        } elseif($user->code_groupe == 'e_nn_achatpp_capa_rpgnr_pre_kit_tec') {
		        $menu = '<li><a id="rpgnr" href="/eu-placement/nrpre?type=rpg">Non Récurrent pre</a></li>
				         <li><a href="/eu-placement" style="font-size:10px">Consultation </a></li>';
				$this->view->placeholder("menu")->set($menu);
		} elseif($user->code_groupe == 'e_nn_achatpm_capa_inr_pre_kit_tec') {
		        $menu = '<li><a id="rpgnr" href="/eu-placement/nrpre?type=i">Non Récurrent pre</a></li>
				         <li><a href="/eu-placement" style="font-size:10px">Consultation </a></li>';
				$this->view->placeholder("menu")->set($menu);
		}
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            if ($user->code_groupe != 'apa' && $user->code_groupe != 'banque' && $user->code_groupe != 'aparpg' && $user->code_groupe != 'apai' && $user->code_groupe != 'apacncs' 
			&& $user->code_groupe != 'recharge' && $user->code_groupe != 'e_nn_achatpp_capa_rpgnr_pre_kit_tec' && $user->code_groupe != 'e_nn_achatpm_capa_inr_pre_kit_tec') {
               $this->view->user = $user;
               return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
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

    public function creditsAction() {
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

    public function sprkAction() {
        $code_produit = $_GET["code"];
        $acteur = $_GET["acteur"];
        $t_tab = new Application_Model_DbTable_EuPrk();
        $select = $t_tab->select();
        if ($code_produit != '') {
            $select->where('code_type_credit like ?', $code_produit);
        }
        if ($acteur != '') {
            $select->where('id_type_acteur like ?', $acteur);
        }
        $rows = $t_tab->fetchAll($select);
        $data = array();
        for ($i = 0; $i < count($rows); $i++) {
            $value = $rows[$i];
            $data[$i] = $value->valeur;
        }
        $this->view->data = $data;
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_operation');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $date_deb = Zend_Date::now();
        $select = $tabela->select();
        $select->from('eu_operation',array("to_char((eu_operation.date_op),'dd/mm/yyyy') dateop",'eu_operation.*'))
		        ->where('id_utilisateur like ?', $user->id_utilisateur)
                //->where('date_op = ?', Util_Utils::toDate($date_deb))
                ->order('date_op desc');
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
		    if ($row->code_produit == 'RPGnrPRE') {
			    $code_membre = $row->code_membre;
			} else {
			    $code_membre = $row->code_membre_morale;
			}
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->id_operation,
                $row->dateop,
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

    public function rechargennAction() {
        
    }

    public function dorecnnAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $date = Zend_Date::now();
        if ($request->isPost()) {
            $num_membre = $request->code_membre;
            $montant = $request->mont_rec;
            $motif = $request->code_recu;
            $code_dev = $request->capa_dev;
            $code_sms = $request->code_sms;
            $nom_membre = $request->nom_membre;
            $prenom_membre = $request->prenom_membre;
            $raison_membre = $request->raison_membre;
            $m_compte = new Application_Model_EuCompteMapper();
            $mapper = new Application_Model_EuOperationMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $code_compte = '';
                $type_membre = 'p';
                if (Util_Utils::verifierMembre($num_membre)) {
                    $code_compte = 'nn-t' . $motif . '-' . $num_membre;
                    $type_membre = Util_Utils::getMembreType($num_membre);
                }

                $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                $sms = new Application_Model_EuSmsmoney();
                $ret = $sms_mapper->findSMSMoneyByCodeSMS($code_sms, $sms);
                if ($ret) {
                    $montant = Util_Utils::verifierCodeSMS($sms);
                    if ($montant > 0) {
                        $compteur = $mapper->findConuter() + 1;
                        $place = new Application_Model_EuOperation ( );
                        $place->setId_operation($compteur)
                                ->setDate_op(Util_Utils::toDate($date))
                                ->setHeure_op(Util_Utils::toDate($date))
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setCode_produit(null)
                                ->setType_op('rec')
                                ->setMontant_op($montant)
                                ->setCode_membre($num_membre)
                                ->setLib_op('Recharge de compte')
                                ->setCode_cat('t' . $motif);
                        $mapper->save($place);

                        $compte = new Application_Model_EuCompte();
                        $ret_req = $m_compte->find($code_compte, $compte);
                        if ($ret_req == false) {
                            $compte->setCode_cat('t' . $motif)
                                    ->setCode_compte($code_compte)
                                    ->setCode_type_compte('nn')
                                    ->setDate_alloc(Util_Utils::toDate($date))
                                    ->setDesactiver(0)
                                    ->setLib_compte('Compte de recharge')
                                    ->setSolde($montant);
                            if ($type_membre == 'p') {
                                $compte->setCode_membre($num_membre);
                            } else {
                                $compte->setCode_membre_morale($num_membre);
                            }
                            $m_compte->save($compte);
                        } else {
                            $compte->setSolde($compte->getSolde() + $montant);
                            $m_compte->update($compte);
                        }

                        $capa = new Application_Model_EuCapa();
                        $m_capa = new Application_Model_EuCapaMapper();
                        $code_capa = 'capa-' . $date->toString('yyyyMMddHHmmss');
                        $capa->setCode_capa($code_capa)
                                ->setCode_compte($code_compte)
                                ->setCode_membre($num_membre)
                                ->setMontant_capa($montant)
                                ->setMontant_utiliser(0)
                                ->setMontant_solde($montant)
                                ->setDate_capa(Util_Utils::toDate($date))
                                ->setHeure_capa(Util_Utils::toDate($date))
                                ->setId_operation($compteur)
                                ->setEtat_capa("ea")
                                ->setOrigine_capa("sms");
                        $m_capa->save($capa);

                        $sms->setDestAccount_Consumed($compte->getCode_compte())->setDateTimeconsumed($date->toString('dd/mm/yyyy hh:mm:ss'))
                                ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms);
                        $id_sms = Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($id_sms, $sms->getSentTo(), "Vous venez de recharger " . $montant . " " . $code_dev . " sur le compte " . $code_compte . ". Solde final: " . $compte->getSolde());
                    } else {
                        $db->rollback();
                        $this->view->message = "Le code sms n'est pas valide !!!";
                        $this->view->code_membre = $num_membre;
                        $this->view->nom_membre = $nom_membre;
                        $this->view->prenom_membre = $prenom_membre;
                        $this->view->raison_membre = $raison_membre;
                        $this->view->code_recu = $motif;
                        $this->view->mont_capa = $montant;
                        $this->view->capa_dev = $code_dev;
                        $this->view->code_sms = $code_sms;
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->message = "Le code sms n'existe pas ou déjà utilisé !!!";
                    $this->view->code_membre = $num_membre;
                    $this->view->nom_membre = $nom_membre;
                    $this->view->prenom_membre = $prenom_membre;
                    $this->view->raison_membre = $raison_membre;
                    $this->view->code_recu = $motif;
                    $this->view->mont_capa = $montant;
                    $this->view->capa_dev = $code_dev;
                    $this->view->code_sms = $code_sms;
                    return;
                }
                $db->commit();
                $this->view->message = true;
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . '=>' . $exc->getTraceAsString();
                $this->view->code_membre = $num_membre;
                $this->view->nom_membre = $nom_membre;
                $this->view->prenom_membre = $prenom_membre;
                $this->view->raison_membre = $raison_membre;
                $this->view->code_recu = $motif;
                $this->view->mont_capa = $montant;
                $this->view->capa_dev = $code_dev;
                $this->view->code_sms = $code_sms;
                return;
            }
        }
    }

    public function rechargetrAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $date = Zend_Date::now();
        if ($request->isPost()) {
            $montant = $request->mont_rec;
            $motif = $request->code_recu;
            $code_dev = $request->capa_dev;
            $code_sms = $request->code_sms;
            $m_compte = new Application_Model_EuCompteMapper();
            $mapper = new Application_Model_EuOperationMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $type = Util_Utils::getMembreType($user->code_membre);
                if ($type != 'p') {
                    $code_compte = 'nn-tr-' . $user->code_membre;
                    $m_moral = new Application_Model_EuMembreMoraleMapper();
                    $moral = new Application_Model_EuMembreMorale();
                    $retour = $m_moral->find($user->code_membre, $moral);
                    if ($retour) {
                        $tab_acteur = new Application_Model_DbTable_EuActeur();
                        $select = $tab_acteur->select();
                        $select->where('code_membre like ?', $user->code_membre)
                                ->where('code_activite in (?)', array('pbf', 'dsms'));
                        $acteurs = $tab_acteur->fetchAll($select);
                        if (count($acteurs) == 0) {
                            $db->rollback();
                            $this->view->message = 'Opération Impossible: \nVous n\' etes pas un pbf ou Distributeur de code sms.!!!';
                            $this->view->code_recu = $motif;
                            $this->view->mont_capa = $montant;
                            $this->view->capa_dev = $code_dev;
                            $this->view->code_sms = $code_sms;
                            return;
                        }
                    } else {
                        $this->view->message = "Ce membre n'existe pas";
                        $this->view->code_recu = $motif;
                        $this->view->mont_capa = $montant;
                        $this->view->capa_dev = $code_dev;
                        $this->view->code_sms = $code_sms;
                        $db->rollback();
                        return;
                    }
                    if ($code_sms != '') {
                        $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                        $sms = $sms_mapper->findByCreditCode($code_sms);
                        if ($sms != null && $sms->getIDDateTimeConsumed() == 0) {
                            $compte_transfert = $sms->getFromAccount();
                            $transfert = explode('-', $compte_transfert);
                            $membre_transfert = $transfert[2];
                            if ($membre_transfert == $user->code_membre) {
                                $db->rollback();
                                $this->view->message = 'Vous ne pouvez pas faire un transfert pour vous-même !!!';
                                $this->view->code_recu = $motif;
                                $this->view->mont_capa = $montant;
                                $this->view->capa_dev = $code_dev;
                                $this->view->code_sms = $code_sms;
                                return;
                            }
                            $tab_acteur = new Application_Model_DbTable_EuActeur();
                            $select = $tab_acteur->select();
                            $select->where('code_membre like ?', $membre_transfert)
                                    ->where('code_activite in (?)', array('pbf', 'dsms'))
                                    ->where('type_acteur like ?', 'gac_surveillance');
                            $acteurs = $tab_acteur->fetchAll($select);
                            if (count($acteurs) == 0) {
                                $db->rollback();
                                $this->view->message = 'Ce Code sms n\'est pas vendu par un pbf ou Distributeur de Code sms !!!';
                                $this->view->code_recu = $motif;
                                $this->view->mont_capa = $montant;
                                $this->view->capa_dev = $code_dev;
                                $this->view->code_sms = $code_sms;
                                return;
                            }

                            //conversion de la devise
                            $montant = $sms->getCreditAmount();
                            $code_dev = $sms->getCurrencyCode();
                            if ($code_dev != 'xof') {
                                $code_cours = $code_dev . '-xof';
                                $cours = new Application_Model_EuCours();
                                $m_cours = new Application_Model_EuCoursMapper();
                                $ret = $m_cours->find($code_cours, $cours);
                                if ($ret) {
                                    if ($montant != '') {
                                        $montant = $montant * $cours->getVal_dev_fin();
                                    }
                                }
                            }
                            $compteur = $mapper->findConuter() + 1;
                            $place = new Application_Model_EuOperation();
                            $place->setId_operation($compteur)
                                    ->setDate_op(Util_Utils::toDate($date))
                                    ->setHeure_op(Util_Utils::toDate($date))
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCode_produit(null)
                                    ->setType_op('rec')
                                    ->setMontant_op($montant)
                                    ->setCode_membre($user->code_membre)
                                    ->setLib_op('Recharge de compte')
                                    ->setCode_cat('tr');
                            $mapper->save($place);

                            $compte = new Application_Model_EuCompte();
                            $code_compte = 'nn-tr-' . $user->code_membre;
                            $ret_req = $m_compte->find($code_compte, $compte);
                            if ($ret_req == false) {
                                $compte->setCode_cat('tr')
                                        ->setCode_compte($code_compte)
                                        ->setCode_type_compte('nn')
                                        ->setDate_alloc(Util_Utils::toDate($date))
                                        ->setDesactiver(0)
                                        ->setLib_compte('Compte de recharge')
                                        ->setSolde($montant)
                                        ->setCode_membre_morale($user->code_membre);
                                $m_compte->save($compte);
                            } else {
                                $compte->setSolde($compte->getSolde() + $montant);
                                $m_compte->update($compte);
                            }

                            $tab_det_sms = new Application_Model_DbTable_EuDetailSmsmoney();
                            $det_sms = new Application_Model_EuDetailSmsmoney();
                            $det_sms->setCode_membre_dist($user->code_membre)
                                    ->setCode_membre($membre_transfert)
                                    ->setCreditcode($sms->getCreditCode())
                                    ->setMont_sms($sms->getCreditAmount())
                                    ->setDate_allocation(Util_Utils::toDate($date))
                                    ->setMont_vendu(0)
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setSolde_sms($sms->getCreditAmount())
                                    ->setType_sms($sms->getMotif())
                                    ->setOrigine_sms('pbf');
                            $tab_det_sms->insert($det_sms->toArray());

                            $sms->setDestAccount_Consumed($compte->getCode_compte())
                                    ->setDateTimeconsumed($date->toString('dd/mm/yyyy hh:mm:ss'))
                                    ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms);
                            Util_Utils::addSms($moral->getTel_membre(), "Vous venez de recharger " . $montant . " " . $code_dev . " sur le compte " . $code_compte . ". Solde final: " . $compte->getSolde());
                        } else {
                            $db->rollback();
                            $this->view->message = 'Le Code sms est invalide!!!';
                            $this->view->code_recu = $motif;
                            $this->view->mont_capa = $montant;
                            $this->view->capa_dev = $code_dev;
                            $this->view->code_sms = $code_sms;
                            return;
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = 'Le Code sms est obligatoire!!!';
                        $this->view->code_recu = $motif;
                        $this->view->mont_capa = $montant;
                        $this->view->capa_dev = $code_dev;
                        $this->view->code_sms = $code_sms;
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->message = "Ce membre n'est pas personne morale";
                    $this->view->code_recu = $motif;
                    $this->view->mont_capa = $montant;
                    $this->view->capa_dev = $code_dev;
                    $this->view->code_sms = $code_sms;
                    return;
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . '=>' . $exc->getTraceAsString();
                $this->view->code_recu = $motif;
                $this->view->mont_capa = $montant;
                $this->view->capa_dev = $code_dev;
                $this->view->code_sms = $code_sms;
                return;
            }
        }
    }

    public function changeAction() {
        if ($_GET['cat'] != '') {
            $var = $_GET['cat'];
            $data = array();
            $produit = new Application_Model_DbTable_EuProduit();
            $result = $produit->fetchAll($produit->select()->where('code_categorie = ?', $var));
            foreach ($result as $p) {
                $data[] = $p->code_produit;
            }
            $this->view->data = $data;
        }
    }

    public function codesmsAction() {
        $code = filter_input(input_get, 'code');
        $prk = filter_input(input_get, 'prk');
        $cat = filter_input(input_get, 'cat');
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
                if ($prk != '') {
                    $pck = floatval(str_replace(',', '.', Util_Utils::getParametre('pck', $cat)));
                    $credit = floor(($mont_capa * $prk) / $pck);
                    $data[1] = $credit;
                }
                $data[2] = $results->current()->currencycode;
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
    }

    public function smsAction() {
        $code = filter_input(input_get, "code");
        if ($code != '') {
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('creditcode like ?', $code)
                    ->where('iddatetimeconsumed = ?', 0);
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $data[0] = $results->current()->creditamount;
                $data[1] = $results->current()->motif;
                $data[2] = $results->current()->currencycode;
            } else {
                $data[0] = 0;
                $data[1] = $code;
                $data[2] = 'xof';
            }
        }
        $this->view->data = $data;
    }

    public function calculAction() {
        $cat = filter_input(input_get, 'cat');
        $data = array();
        if ($cat != '') {
            $prk = Util_Utils::getParametre('prk', $cat);
            $pck = floatval(str_replace(',', '.', Util_Utils::getParametre('pck', 'r')));
            $mont_capa = filter_input(input_get, 'montant');
            $mont_credit = filter_input(input_get, 'credit');
            if (isset($mont_capa)) {
                $credit = floor(($mont_capa * $prk) / $pck);
                $data [0] = $credit;
                $data[1] = $pck;
                $data[2] = $prk;
                $data[3] = $mont_capa;
            } elseif (isset($mont_credit)) {
                $montant = ceil(($mont_credit * $pck) / $prk);
                $data[0] = $montant;
            }
        }
        $this->view->data = $data;
    }

    public function convertirAction() {
        $cat = $_GET['cat'];
        if ($cat != '') {
            $pck = 0;
            $tparam = new Application_Model_DbTable_EuParametres();
            $select_pck = $tparam->select();
            $select_pck->where('code_param = ?', 'pck')
                    ->where('lib_param = ?', $cat);
            $rows_pck = $tparam->fetchAll($select_pck);
            if (count($rows_pck) > 0) {
                $param = $rows_pck->current();
                $pck = $param->montant;
            }
            $prk = $_GET['prk'];
            $dev = $_GET['dev'];
            $dev1 = $_GET['dev1'];
            if
            ($dev != $dev1) {
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

    public function membreAction() {
        $request = $this->getRequest();
        $type_membre = $request->type;
        $membres = array();
        if ($type_membre == 'm') {
            $m_map = new Application_Model_EuMembreMoraleMapper ();
            $rows = $m_map->fetchAll();
            foreach ($rows as $c) {
                $membres[] = $c->code_membre_morale;
            }
        } else {
            $m_map = new Application_Model_EuMembreMapper ();
            $rows = $m_map->fetchAll();
            foreach ($rows as $c) {
                $membres[] = $c->code_membre;
            }
        }
        $this->view->data = $membres;
    }

    public function convertionAction() {
        $dev = filter_input(input_get, 'dev');
        $dev1 = filter_input(input_get, 'dev1');
        if ($dev != $dev1) {
            if ($dev != $dev1) {
                $code_cours = $dev . '-' . $dev1;
                $cours = new Application_Model_EuCours( );
                $m_cours = new Application_Model_EuCoursMapper();
                $ret = $m_cours->find($code_cours, $cours);
                if ($ret) {
                    $mont_capa = filter_input(input_get, 'montant');
                    if ($mont_capa != '') {
                        $montant = $mont_capa * $cours->getVal_dev_fin();
                        $data = $montant;
                    }
                } else {

                    $data = false;
                }
            }
        }

        $this->view->data = $data;
    }

    public function recupnomAction() {
        $num_membre = filter_input(input_get, 'num_membre');
        if (substr($num_membre, 19, 1) == 'm') {
            $membre_db = new Application_Model_DbTable_EuMembreMorale ();
            $membre_find = $membre_db->find($num_membre);
            if (count($membre_find) == 1) {
                $result = $membre_find->current();
                $data[0] = $result->raison_sociale;
            }
        } else if (substr($num_membre, 19, 1) == 'p') {
            $membre_db = new Application_Model_DbTable_EuMembre ();
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

    public function recuptelAction() {
        $num_membre = filter_input(input_get, 'num_membre');

        $membre_db = new Application_Model_DbTable_EuMembre ( );
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();

            $data['nom'] = strtoupper($result->nom_membre);
            $data['prenom'] = ucfirst($result->prenom_membre);
            if ($result->type_membre == 'm') {
                $data['raison'] = $result->raison_sociale;
            }
            $data['cel'] = ucfirst($result->portable_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function pckAction() {
        $prk = Util_Utils::getParametre('prk', 'nr');
        $pck = floatval(str_replace(',', '.', Util_Utils::getParametre('pck', 'r')));
        $data[0] = $prk;
        $data[1] = $pck;
        $this->view->data = $data;
    }

    public function transfertAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $cm_map = new Application_Model_EuCompteMapper();
        $cm = new Application_Model_EuCompte();
        $code_compte = 'nn-tr-' . $user->code_membre;
        $ret = $cm_map->find($code_compte, $cm);
        if ($ret) {
            $this->view->code_compte = $cm->getCode_compte();
            $this->view->solde = $cm->getSolde();
        }
    }

    public function dotransfertAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        $this->_helper->layout->disableLayout();
        $type = $request->type_transfert;
        $tel = $request->tel_dest;
        $code_envoi = $request->code_envoi;
        $code_recu = $request->code_recu;
        $montant = $request->mont_transfert;
        $code_dev = $request->code_dev;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $date = new Zend_Date();
            $sms = new Application_Model_EuSms();
            $tbl_sms = new

                    Application_Model_DbTable_EuSms();
            $sms_money = new Application_Model_EuSmsmoney();
            $money_map = new Application_Model_EuSmsmoneyMapper();
            if ($type != '' && $tel != '' && $montant != '') {
                if ($code_dev != 'xof') {
                    $code_cours = $code_dev . '-xof';
                    $cours = new Application_Model_EuCours();
                    $m_cours = new Application_Model_EuCoursMapper();
                    $ret = $m_cours->find($code_cours, $cours);
                    if ($ret) {
                        $montant = $montant * $cours->getVal_dev_fin();
                    } else {
                        $db->rollback();
                        $this->view->data = 'Erreur de traitement: Le cours de cette devise ' . $code_dev . ' n\'est pas encore d�fini';
                        return;
                    }
                }
                $cm_map = new Application_Model_EuCompteMapper();
                $cm = new Application_Model_EuCompte();
                $ret = $cm_map->find($code_envoi, $cm);
                if ($ret && $cm->getSolde() >= $montant) {
                    $code_transfert = strtoupper(Util_Utils::genererCodeSMS(8));
                    $sms_money->setCodeAgence($user->code_agence)
                            ->setCreditAmount($montant)
                            ->setSentTo($tel)
                            ->setMotif($type)
                            ->setUtilisateur($user->id_utilisateur)
                            ->setCurrencyCode('xof')
                            ->setDatetime($date->toString('dd/mm/yyyy hh:mm:ss'))
                            ->setFromAccount($code_envoi)
                            ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                            ->setCreditCode($code_transfert)
                            ->setDestAccount('')
                            ->setIDDatetimeConsumed(0)
                            ->setDestAccount_Consumed('')
                            ->setDatetimeConsumed('')
                            ->setNum_recu($code_recu);
                    $money_map->save($sms_money);

                    $sms->setRecipient($tel)
                            ->setSMSBody($montant . ' ont ete ajoute au Code: ' . $code_transfert)
                            ->setDateTime($date->toString('dd/mm/yyyy hh:mm:ss'))
                            ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                            ->setRetries(0)
                            ->setTypeDestinataire('')
                            ->setDecodeString('')
                            ->setNom('')
                            ->setPrenom('')
                            ->setSociete('')
                            ->setHeureEnvoi('')
                            ->setIDDateEnvoi(0)
                            ->setEnvoyeLe('')
                            ->setEnvoyePar('')
                            ->setDateEnvoi('')
                            ->setEtat(0)
                            ->setIDHeureEnvoi(0);
                    $tbl_sms->insert($sms->toArray());

                    $cm->setSolde($cm->getSolde() - $montant);
                    $cm_map->update($cm);

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
                $this->view->data = 'Erreur de traitement: Il y a des champs qui n\'ont pas �t� renseign�s';
                return;
            }
        } catch (Exception $exc) {
            $db->rollback();
            $this->view->data = 'Erreur de traitement ' . $exc->getMessage();
            return;
        }
    }

    public function newnrAction() {
        $request = $this->getRequest();
        $type_capa = $request->type;
        $this->view->type = $type_capa;
    }

    public function newrAction() {
        $request = $this->getRequest();
        $type_capa = $request->type;
        $this->view->type = $type_capa;
    }

    public function newcapamfAction() {
        $request = $this->getRequest();
        $type_mf = $request->type;
        $this->view->type = $type_mf;
    }

    public function donewAction() {
        // action body
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $fs = 0;
            $credi = $request->mont_credit;
            $num_membre = $request->code_membre;
            $type = $request->code_produit;
            $categorie = $request->cat_produit;
            $montant = $request->mont_capa;
            $code_dev = $request->dev_capa;
            $mode_finance = $request->mode_finance;
            $code_sms = '';
            if ($mode_finance === 'SMS') {
               $code_sms = $request->code_sms;
            }
            $prk = $request->prk;
            $type_credit = $request->type_credit;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $membre = new Application_Model_EuMembre();
                $moral = new Application_Model_EuMembreMorale();
                if (!Util_Utils::verifierMembre($num_membre)) {
                    $db->rollback();
                    $this->view->data = "Ce membre $num_membre n'existe pas";
                    return;
                } else {
                    $type_membre = Util_Utils::getMembreType($num_membre);
                    if (($type_membre === 'P' && $type === 'RPG') || ($type === 'I' && $type_membre === 'M')) {
                        if ($type_membre === 'P') {
                            Util_Utils::getMembre($num_membre, $membre);
                        } else {
                            Util_Utils::getMembreMorale($num_membre, $moral);
                        }
                    } else {
                        $db->rollback();
                        $this->view->data = "Opération invalide: Vérifier le type de produit  avec le type de membre!!!";
                        return;
                    }
                    $prod = new Application_Model_EuProduit();
                    $code = $type . $categorie;
                    $p_mapper = new Application_Model_EuProduitMapper();
                    $p_result = $p_mapper->find($code, $prod);
                    if (!$p_result) {
                        $db->rollback();
                        $this->view->data = "Ce produit " . $code . " n'existe pas";
                        return;
                    }

                    $cm_mapper = new Application_Model_EuCompteMapper();
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $sms = new Application_Model_EuSmsmoney();
                    $compte_capa = new Application_Model_EuCompte();
                    if ($mode_finance === 'SMS') {
                        $ret = $sms_mapper->findSMSMoneyByCodeSMS($code_sms, $sms);
                        if ($ret) {
                            $montant = Util_Utils::verifierCodeSMS($sms);
                            if ($montant == 0) {
                                $db->rollback();
                                $message = "Erreur d'éxécution : Ce code sms $code_sms est invalide ou le motif n'est pas capa!!!";
                                $this->view->data = $message;
                                return;
                            }
                        } else {
                            $db->rollback();
                            $message = "Erreur d'éxécution : Ce code sms $code_sms est invalide ou le motif n'est pas capa!!!";
                            $this->view->data = $message;
                            return;
                        }
                    } else {
                        $code_compte = 'NN-' . $mode_finance . '-' . $num_membre;
                        $capa_result = $cm_mapper->find($code_compte, $compte_capa);
                        if (!$capa_result || $compte_capa->getSolde() < $montant) {
                            $db->rollback();
                            $this->view->message = "Ce compte n'existe pas ou son solde est insuffisant!!!";
                            return;
                        }
                    }

                    $code_cat = 'TPAGC' . $type;
                    $num_compte = 'NB-' . $code_cat . '-' . $num_membre;
                    $mapper = new Application_Model_EuOperationMapper();
                    $compteur = $mapper->findConuter() + 1;
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
                    $lib_op = '';
                    if ($type == 'RPG') {
                        $lib_op = 'Achat du RPG';
                        Util_Utils::addOperation($compteur, $num_membre, null, $code_cat, $montant, $code, $lib_op, 'APA', $date_deb, $date_deb, $user->id_utilisateur);
                    } else {
                        $lib_op = 'Achat d\'Investissement';
                        Util_Utils::addOperation($compteur, null, $num_membre, $code_cat, $montant, $code, $lib_op, 'APA', $date_deb, $date_deb, $user->id_utilisateur);
                    }
					
                    //vérification des quotas
                    $mont_place = $montant;
                    $m_sqmaxui = new Application_Model_EuBnpSqmaxMapper();
                    $sqmax = 0;
                    $somme = 0;
                    $m_capa = new Application_Model_EuCapaMapper();
                    if ($type == 'RPG' && $categorie == 'r') {
                        $quota = Util_Utils::getParametre('quota', 'RPGr');
                        $somme = Util_Utils::getSumRPGr($num_membre);
                        if ($somme < $quota) {
                            $reste = $quota - ($somme + $mont_place);
                            if ($reste < 0) {
                                $sqmax = abs($reste);
                                $sqmaxui = new Application_Model_EuBnpSqmax();
                                $sqmaxui->setCode_cat($code_cat);
                                $sqmaxui->setCode_membre($num_membre);
                                $sqmaxui->setMontant($sqmax);
                                $m_sqmaxui->save($sqmaxui);
                                $mont_place = $mont_place - $sqmax;
                            }
                        } else {
                            $sqmax = $mont_place;
                            $sqmaxui = new Application_Model_EuBnpSqmax();
                            $sqmaxui->setCode_cat($code_cat);
                            $sqmaxui->setCode_membre($num_membre);
                            $sqmaxui->setMontant($sqmax);
                            $m_sqmaxui->save($sqmaxui);
                            $mont_place = 0;
                        }
                    }
                    if ($mont_place > 0) {
                        $pck = floatval(str_replace(',', '.', Util_Utils::getParametre('pck', $categorie)));
                        $fs = 0;
                        $panu_fs = 0;
                        $credi = floor($mont_place * $prk / $pck);
                        if (($type == 'RPG' and $categorie == 'r') or ( $type == 'I' and $categorie == 'r')) {
                            $bmap = new Application_Model_EuCapsMapper();
                            $bnp = new Application_Model_EuCaps();
                            if ($membre->getAuto_enroler() == 'N') {
                                $bnp = $bmap->fetchCapsByBeneficiaire($membre->getCode_membre());
                                $fs_valeur = Util_Utils::getParametre('fs', 'valeur');
                                if ($bnp != null and $bnp->getId_credit() == null) {
                                    $t_map = new Application_Model_EuTypeBnpMapper();
                                    $tbnp = new Application_Model_EuTypeBnp();
                                    $t_map->find($bnp->getType_bnp(), $tbnp);
                                    $fs = floor($credi * $tbnp->getTxfs() / 100);
                                    if ($bnp->getPanu() == 1) {
                                        $panu_fs = floor($credi * $tbnp->getTx_panu_fs());
                                    }
                                    if ($fs < ($fs_valeur / 22.4)) {
                                        $fs = ($fs_valeur / 22.4);
                                    }
                                    $credi = $credi - $fs;
                                }
                            }
                        }

                        $compte = new Application_Model_EuCompte();
                        $result = $cm_mapper->find($num_compte, $compte);
                        if ($result == false) {
                            $type_compte = 'NB';
                            Util_Utils::createCompte($num_compte, $type, $code_cat, $credi, $num_membre, $type_compte, $date_deb, 0);
                        } else {
                            $compte->setSolde($compte->getSolde() + $credi);
                            $cm_mapper->update($compte);
                        }

                        //Mise à jour des comptes credits
                        $cc_mapper = new Application_Model_EuCompteCreditMapper();
                        $source = $num_membre . $date_deb->toString('yyyyMMddHHmmss');
                        $max_code = $cc_mapper->findConuter() + 1;
                        $periode = Util_Utils::getParametre('periode', 'valeur');
                        $date_fin->addDay($periode);
                        $compte_source = '';
                        if ($type == 'RPG') {
                            $compte_source = 'CAPARPG';
                        } elseif ($type == 'I') {
                            $compte_source = 'CAPAI';
                        }
                        $renouveller = 'O';
                        if ($categorie == 'nr') {
                            $renouveller = 'N';
                        }
                        Util_Utils::createCompteCredit($max_code, 0, $compteur, $num_membre, $code, $num_compte, $credi, $mont_place, $date_deb, $date_fin, $source, $compte_source, 'n', $renouveller, 0, 0, nULL, $type_credit, $prk);

                        //Mise à jour du cnp
                        $cnp = new Application_Model_EuCnp();
                        $m_cnp = new Application_Model_EuCnpMapper();
                        $cnp->setId_credit($max_code)
                                ->setDate_cnp(Util_Utils::toDate($date_deb))
                                ->setMont_debit($credi)
                                ->setMont_credit(0)
                                ->setSolde_cnp($credi)
                                ->setType_cnp($code)
                                ->setSource_credit($source)
                                ->setTransfert_gcp(0);
                        if ($code == 'Inr') {
                            $cnp->setOrigine_cnp('FGInr');
                        } elseif ($code == 'Ir') {
                            $cnp->setOrigine_cnp('FGIr');
                        } elseif ($code == 'RPGr') {
                            $cnp->setOrigine_cnp('FGRPGr');
                        } elseif ($code == 'RPGnr') {
                            $cnp->setOrigine_cnp('FGRPGnr');
                        }
                        $m_cnp->save($cnp);

                        if ($fs > 0) {
                            $bnp->setId_credit($max_code)
                                ->setMont_fs($bnp->getMont_fs() + $fs)
                                ->setIndexer(1);
                            if ($panu_fs > 0) {
                                $bnp->setMont_panu_fs($bnp->getMont_panu_fs() + $panu_fs);
                            }
                            $bmap->update($bnp);
                            //Mise à jour du fs
                            $cfs = 'NB-TFS-' . $bnp->getCode_membre_app();
                            $compte_fs = new Application_Model_EuCompte();
                            $ret_fs = $cm_mapper->find($cfs, $compte_fs);
                            if ($ret_fs) {
                                $compte_fs->setSolde($compte_fs->getSolde() + $fs);
                                $cm_mapper->update($compte_fs);
                            } else {
                                Util_Utils::createCompte($cfs, 'TFS', 'TFS', $fs, $bnp->getCode_membre_app(), 'NB', $date_deb, 0);
                            }

                            //Mise à jour des comptes credits
                            $source = $bnp->getCode_membre_app() . $date_deb->toString('yyyyMMddHHmmss');
                            $max_code = $cc_mapper->findConuter() + 1;
                            Util_Utils::createCompteCredit($max_code, 0, $compteur, $bnp->getCode_membre_app(), 'fs', $cfs, $fs, $bnp->getMont_caps(), $date_deb, $date_fin, $source, $num_compte, 'n', 'n', 0, 0, nULL, 'CnPG', 1);

                            $cnp = new Application_Model_EuCnp();
                            $m_cnp = new Application_Model_EuCnpMapper();
                            $cnp->setId_credit($max_code)
                                    ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                    ->setMont_debit($fs)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($fs)
                                    ->setType_cnp($code)
                                    ->setSource_credit($source)
                                    ->setTransfert_gcp(0);
                            if ($code == 'Inr') {
                                $cnp->setOrigine_cnp('FGInr');
                            } elseif ($code == 'Ir') {
                                $cnp->setOrigine_cnp('FGIr');
                            } elseif ($code == 'RPGr') {
                                $cnp->setOrigine_cnp('FGRPGr');
                            } elseif ($code == 'RPGnr') {
                                $cnp->setOrigine_cnp('FGRPGnr');
                            }
                            $m_cnp->save($cnp);

                            //Mise à jour du Panu fs
                            if ($panu_fs > 0) {
                                $cpanu_fs = 'nb-TPaNu-' . $bnp->getCode_membre_app();
                                $compte_pfs = new Application_Model_EuCompte();
                                $ret_pfs = $cm_mapper->find($cpanu_fs, $compte_pfs);
                                if ($ret_pfs) {
                                    $compte_pfs->setSolde($compte_pfs->getSolde() + $panu_fs);
                                    $cm_mapper->update($compte_pfs);
                                } else {
                                    Util_Utils::createCompte($cpanu_fs, 'TPaNu', 'TPaNu', $panu_fs, $bnp->getCode_membre_app(), 'nb', $date_deb, 0);
                                }
                                //Mise à jour des comptes credits
                                $max_code = $cc_mapper->findConuter() + 1;
                                $source = $bnp->getCode_membre_app() . $date_deb->toString('yyyyMMddHHmmss');
                                Util_Utils::createCompteCredit($max_code, 0, $compteur, $bnp->getCode_membre_app(), 'Panu', $cpanu_fs, $panu_fs, $bnp->getMont_caps(), $date_deb, $date_fin, $source, $num_compte, 'n', 'n', 0, 0, nULL, 'CnPG', 1);

                                $cnp = new Application_Model_EuCnp();
                                $m_cnp = new Application_Model_EuCnpMapper();
                                $cnp->setId_credit($max_code)
                                        ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                        ->setMont_debit($panu_fs)
                                        ->setMont_credit(0)
                                        ->setSolde_cnp($panu_fs)
                                        ->setType_cnp($code)
                                        ->setSource_credit($source)
                                        ->setTransfert_gcp(0);
                                if ($code == 'Inr') {
                                    $cnp->setOrigine_cnp('FGInr');
                                } elseif ($code == 'Ir') {
                                    $cnp->setOrigine_cnp('FGIr');
                                } elseif ($code == 'RPGr') {
                                    $cnp->setOrigine_cnp('FGRPGr');
                                } elseif ($code == 'RPGnr') {
                                    $cnp->setOrigine_cnp('FGRPGnr');
                                }
                                $m_cnp->save($cnp);
                            }
                        }

                        //Mise à jour des CAPAs et FNs
                        $fn = new Application_Model_EuFn();
                        $m_fn = new Application_Model_EuFnMapper();
                        $capa = new Application_Model_EuCapa();
                        if ($mode_finance === "SMS") {
                            $code_capa = 'CAPA' . $type . $date_deb->toString('yyyyMMddHHmmss');
                            $capa->setCode_capa($code_capa)
                                    ->setCode_compte($num_compte)
                                    ->setDate_capa(Util_Utils::toDate($date_deb))
                                    ->setHeure_capa(Util_Utils::toDate($date_deb))
                                    ->setCode_membre($num_membre)
                                    ->setMontant_capa($mont_place)
                                    ->setId_operation($compteur)
                                    ->setEtat_capa('Actif')
                                    ->setMontant_utiliser($mont_place)
                                    ->setMontant_solde(0)
                                    ->setOrigine_capa('SMS');
                            $m_capa->save($capa);

                            $m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                            $credit_capa = new Application_Model_EuCompteCreditCapa();
                            $credit_capa->setCode_capa($code_capa)
                                        ->setCode_produit($code)
                                        ->setId_credit($max_code)
                                        ->setMontant($mont_place);
                            $m_credit_capa->save($credit_capa);

                            //Mise à jour de la table fn
                            $fn->setCode_capa($code_capa)
                                    ->setDate_fn(Util_Utils::toDate($date_deb))
                                    ->setType_fn('i' . $categorie)
                                    ->setMontant($mont_place)
                                    ->setSortie(0)
                                    ->setEntree(0)
                                    ->setSolde(0)
                                    ->setMt_solde($mont_place);
                            $m_fn->save($fn);

                            $sms->setDestAccount_Consumed($num_compte)
                                ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                            $sms_mapper->update($sms);
                        } else {
                            $capas = $m_capa->fetchAllByMembre($num_membre);
                            if (count($capas) > 0) {
                                $mont_deduit = 0;
                                $i = 0;
                                while ($mont_deduit < $mont_place) {
                                    $value = $capas[$i];
                                    if ($value->getMontant_solde() >= $mont_place) {
                                        $mont_deduit += $mont_place;
                                        //Mise à jour de la table fn
                                        $fn->setCode_capa($value->getCode_capa())
                                                ->setDate_fn(Util_Utils::toDate($date_deb))
                                                ->setType_fn('I' . $categorie)
                                                ->setMontant($mont_place)
                                                ->setSortie(0)
                                                ->setEntree(0)
                                                ->setSolde(0)
                                                ->setMt_solde($mont_place);
                                        $m_fn->save($fn);

                                        $m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                                        $credit_capa = new Application_Model_EuCompteCreditCapa();
                                        $credit_capa->setCode_capa($value->getCode_capa())
                                                ->setCode_produit($type . $categorie)
                                                ->setId_credit($max_code)
                                                ->setMontant($mont_place);
                                        $m_credit_capa->save($credit_capa);

                                        $value->setMontant_utiliser($value->getMontant_utiliser() + $mont_place)
                                                ->setMontant_solde($value->getMontant_solde() - $mont_place);
                                        $m_capa->update($value);
                                    } else {
                                        $mont_deduit += $value->getMontant_solde();
                                        //Mise à jour de la table fn
                                        $fn->setCode_capa($value->getCode_capa())
                                                ->setDate_fn(Util_Utils::toDate($date_deb))
                                                ->setType_fn('i' . $categorie)
                                                ->setMontant($value->getMontant_solde())
                                                ->setSortie(0)
                                                ->setEntree(0)
                                                ->setSolde(0)
                                                ->setMt_solde($value->getMontant_solde());
                                        $m_fn->save($fn);

                                        $m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                                        $credit_capa = new Application_Model_EuCompteCreditCapa();
                                        $credit_capa->setCode_capa($value->getCode_capa())
                                                ->setCode_produit($type . $categorie)
                                                ->setId_credit($max_code)
                                                ->setMontant($value->getMontant_solde());
                                        $m_credit_capa->save($credit_capa);

                                        $value->setMontant_utiliser($value->getMontant_utiliser() + $value->getMontant_solde())
                                                ->setMontant_solde(0);
                                        $m_capa->update($value);
                                    }
                                    $i++;
                                }
                                $compte_capa->setSolde($compte_capa->getSolde() - $mont_place);
                                $cm_mapper->update($compte_capa);
                            }
                        }
                    }

                    //Mise à jour des comptes généraux
                    $compte_gene = new Application_Model_EuCompteGeneral();
                    $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                    $result2 = false;
                    try {
                        if ($type == 'RPG') {
                            $result2 = $cg_mapper->find('FGRPG', 'NN', 'E', $compte_gene);
                        } else {
                            $result2 = $cg_mapper->find('FGI', 'NN', 'E', $compte_gene);
                        }
                        if ($result2) {
                            $compte_gene->setSolde($compte_gene->getSolde() + $montant);
                            $cg_mapper->update($compte_gene);
                        } else {
                            if ($type == 'RPG') {
                                $compte_gene->setCode_compte('FGRPG');
                                $compte_gene->setIntitule('FGRPG');
                            } else {
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
                        $result_3 = $cg_mapper->find('fn', 'nr', 'e', $cgfn);
                        if ($result_3) {
                            $cgfn->setSolde($cgfn->getSolde() + $montant);
                            $cg_mapper->update($cgfn);
                        } else {
                            $cgfn->setCode_compte('fn');
                            $cgfn->setIntitule('fn');
                            $cgfn->setService('e')->setCode_type_compte('nr');
                            $cgfn->setSolde($montant);
                            $cg_mapper->save($cgfn);
                        }
                    } catch (Exception $e) {
                        $db->rollback();
                        $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                        $this->view->data = $message;
                        return;
                    }

                    //Vérification de l'origine du code sms et Mise à jour du détail 
                    $td_fact = new Application_Model_DbTable_EuDetailFacturation();
                    $d_fact = new Application_Model_EuDetailFacturation();
                    $tx_prestation = Util_Utils::getParametre('cncs', 'capa');

                    //Factration à la source cnp
                    $s_acteurs = $db->select()
                            ->from(array('g' => 'eu_gac'), array('g.code_membre', 'g.code_type_gac'))
                            ->join(array('a' => 'eu_acteurs_creneaux'), 'g.code_gac = a.code_gac')
                            ->where('a.code_membre like ?', $user->code_membre);
                    $stmt = $db->query($s_acteurs);
                    $results2 = $stmt->fetchAll();
                    if (count($results2) > 0) {
                        $gac = $result2->current();
                        $mont_fact = $mont_place * $tx_prestation / 100;
                        $cfact = 'NN-TPAGCP-' . $gac->code_membre;
                        $compte_fact = new Application_Model_EuCompte();
                        $ret_fact = $cm_mapper->find($cfact, $compte_fact);
                        if ($ret_fact) {
                            $compte_fact->setSolde($compte_fact->getSolde() + $mont_fact);
                            $cm_mapper->update($compte_fact);
                        } else {
                            Util_Utils::createCompte($cfact, 'TPAGCI', 'TPAGCI', $mont_fact, $gac->code_membre, 'NB', $date_deb, 0);
                        }

                        $nn = new Application_Model_EuNn();
                        $t_nn = new Application_Model_DbTable_EuNn();
                        $lastNnId = Util_Utils::getLastInsertNnId() + 1;
                        $nn->setCode_type_nn('fact')
                                ->setDate_emission(Util_Utils::toDate($date_deb))
                                ->setEmetteur_nn($gac->code_membre)
                                ->setId_nn($lastNnId)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setMontant_emis($mont_fact)
                                ->setType_emission("Auto")
                                ->setMontant_remb($mont_fact)
                                ->setSolde_nn(0);
                        $t_nn->insert($nn->toArray());

                        $d_fact->setCode_compte($cfact)
                                ->setCode_membre($gac->code_membre)
                                ->setDate_facturation(Util_Utils::toDate($date_deb))
                                ->setMont_facturation($mont_fact)
                                ->setId_operation($compteur)
                                ->setId_cnp(0)
                                ->setId_nn($lastNnId);
                        $td_fact->insert($d_fact->toArray());
                    }

                    $sms_map = new Application_Model_EuSmsMapper();
                    $last_sms = $sms_map->findConuter();
                    if ($type_membre === 'P') {
                        Util_Utils::addSms($last_sms + 1, $membre->getPortable_membre(), "Vous venez de recharger $credi $code_dev sur le compte $num_compte");
                    } else {
                        Util_Utils::addSms($last_sms + 1, $moral->getPortable_membre(), "Vous venez de recharger $credi $code_dev sur le compte $num_compte");
                    }
                    $db->commit();
                    $this->view->data = true;
                    return;
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . '=>' . $exc->getTraceAsString();
                $this->view->data = $message;
                return;
            }
        }
    }

    public function typemfAction() {
        $t_mf = new Application_Model_DbTable_EuTypeMf();
        $select = $t_mf->select();
        $select->where('code_type_mf like ?', $_GET['type_mf']);
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

    public function soldennAction() {
        $code_membre = $_GET["membre"];
        $type_compte = $_GET["compte"];
        if ($code_membre != '' && $type_compte) {
            $tsms = new Application_Model_DbTable_EuCompte ( );
            $select = $tsms->select();
            $select->where('code_membre like ?', $code_membre)
                    ->where('code_cat = ?', $type_compte)
                    ->where('code_type_compte like ?', 'nn');
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $data = $results->current()->solde;
            } else {
                $data = 0;
            }
        } $this->view->data = $data;
    }

    public function soldemfAction() {
        $num_bon = $_GET["num_bon"];
        if ($num_bon) {
            $tsms = new Application_Model_DbTable_EuCompte();
            $select = $tsms->select();
            $select->where('code_compte like ?', 'nn-tr-' . $num_bon)
                    ->where('code_cat = ?', 'tr')
                    ->where('code_type_compte like ?', 'nn');
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $data = $results->current()->solde;
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
    }

    public function newnnAction() {
        $request = $this->getRequest();
        $type_capa = $request->type;
        $this->view->type = $type_capa;
    }

    public function donewnnAction() {
        // action body
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $fs = 0;
            $credi = $request->mont_credit;
            $num_membre = $request->code_membre;
            $code_memb_benef = $request->code_membre_dest;
            $type = $request->code_produit;
            $categorie = $request->cat_produit;
            $montant = $request->mont_capa;
            $code_dev = $request->dev_capa;
            $type_compte = $request->type_compte;
            $prk = $request->prk;
            $type_credit = $request->type_credit;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $m_membre = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membre_benef = new Application_Model_EuMembre();
                $retm = $m_membre->find($num_membre, $membre);
                if (!$retm) {
                    $db->rollback();
                    $this->view->message = "Ce membre n'existe pas";
                    return;
                }

                $retour = $m_membre->find($code_memb_benef, $membre_benef);
                if (!$retour) {
                    $db->rollback();
                    $this->view->message = "Ce membre n'existe pas";

                    return;
                } else {
                    if (($membre_benef->getType_membre() == 'p' and $type !== 'RpG') && ($membre_benef->getType_membre() == 'p' and ( $type_compte !== 'TpAGCRpG' || $type_compte !== 'tcncs'))) {
                        $db->rollback();
                        $this->view->data = "Les membres Personnes Physiques ne peuvent acheter que le rpg !!!";
                        return;
                    } elseif (( $membre_benef->getType_membre() == 'm' and $type == 'rpg') || $membre_benef->getType_membre() == 'm' and ( $type_compte == 'TPAGCrpg' ||
                            $type_compte == 'tcncs')) {
                        $db->rollback();
                        $this->view->data = 'Les membres Personnes Morales ne peuvent acheter que le (i) investissement ou le (CNCSnr) Salaire !!!';
                        return;
                    } elseif (($membre_benef->getType_membre() == 'm' && $type == 'cncs') && ($membre_benef->getType_membre() == 'm' && ($type_compte == 'tpagci' || $type_compte == 'tpagcp'))) {
                        if ($categorie == 'r') {
                            $db->rollback();
                            $this->view->data = 'Les personnes morales ne peuvent acheter que le (CNCSnr) Salaire non r�current !!!';
                            return;
                        } elseif ($categorie == 'nr' && ($membre_benef->getCode_type_acteur() != 'ose' || $membre_benef->getCode_type_acteur() != 'Pose')) {
                            $m_acteur = new Application_Model_EuActeurCreneauMapper();
                            $ret_act = $m_acteur->findActeurByMembre($membre_benef->getCode_membre());
                            if ($ret_act == null) {
                                $db->rollback();
                                $this->view->data = 'Cette personne morale n\'est pas un acteur du r�seau mcnp!!!';
                                return;
                            }
                        }
                    }

                    //Verfication du produit
                    $prod = new Application_Model_EuProduit();
                    $code = $type . $categorie;
                    $p_mapper = new Application_Model_EuProduitMapper();
                    $p_result = $p_mapper->find($code, $prod);
                    if (!$p_result) {
                        $this->view->data = "Ce produit " . $code . " n'existe pas";
                        return;
                    }

                    //V�rification du solde du nn
                    $code_compte = 'nn-' . $type_compte . '-' . $membre->getCode_membre();
                    $compte_nn = new Application_Model_EuCompte();
                    $cm_mapper = new Application_Model_EuCompteMapper();
                    $result_nn = $cm_mapper->find($code_compte, $compte_nn);
                    if ($result_nn && $compte_nn->getSolde() > 0 && $compte_nn->getSolde() >= $montant) {
                        if ($code_dev != 'xof') {
                            $code_cours = $code_dev . '-xof';
                            $cours = new Application_Model_EuCours();
                            $m_cours = new Application_Model_EuCoursMapper();
                            $ret = $m_cours->find($code_cours, $cours);
                            if ($ret) {
                                if ($montant != '') {
                                    $montant = $montant * $cours->getVal_dev_fin();
                                }
                            }
                        }

                        $num_compte = '';
                        $code_cat = '';
                        if ($type == 'rpg' or $type == 'i') {
                            $code_cat = 'tpagc' . $type;
                            $num_compte = 'nb-' . $code_cat . '-' . $code_memb_benef;
                        } else {
                            $code_cat = 't' . $type . 'ei';
                            $num_compte = 'nr-' . $code_cat . '-' . $code_memb_benef;
                        }
                        $mapper = new Application_Model_EuOperationMapper();
                        $compteur = $mapper->findConuter() + 1;
                        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                        $date_deb = clone $date_fin;
                        $lib_op = '';
                        if ($type == 'rpg') {
                            $lib_op = 'Achat du rpg';
                        } elseif ($type == 'i') {
                            $lib_op = 'Achat d\'Investissement';
                        } else {
                            $lib_op = 'Achat du cncs';
                        }
                        Util_Utils::addOperation($compteur, $code_memb_benef, $code_cat, $montant, $code, $lib_op, 'apa', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);

                        //v�rification des quotas
                        $mont_place = $montant;
                        $m_sqmaxui = new Application_Model_EuBnpSqmaxMapper();
                        $sqmax = 0;
                        $somme = 0;
                        $m_capa = new Application_Model_EuCapaMapper();
                        if ($type == 'rpg' && $categorie == 'r') {
                            $quota = Util_Utils::getParametre('quota', 'RPGr');
                            $somme = $m_capa->getSumQuotaRPG($code_memb_benef, $type, $categorie . $type);
                            if ($somme < $quota) {
                                $reste = $quota - ($somme + $mont_place);
                                if ($reste < 0) {
                                    $sqmax = abs($reste);
                                    $sqmaxui = new Application_Model_EuBnpSqmax();
                                    $sqmaxui->setCode_cat($code_cat);
                                    $sqmaxui->setCode_membre($code_memb_benef);
                                    $sqmaxui->setMontant($sqmax);
                                    $m_sqmaxui->save($sqmaxui);
                                    $mont_place = $mont_place - $sqmax;
                                }
                            } else {
                                $sqmax = $mont_place;
                                $sqmaxui = new Application_Model_EuBnpSqmax();
                                $sqmaxui->setCode_cat($code_cat);
                                $sqmaxui->setCode_membre($code_memb_benef);
                                $sqmaxui->setMontant($sqmax);
                                $m_sqmaxui->save($sqmaxui);
                                $mont_place = 0;
                            }
                        }
                        if ($mont_place > 0) {
                            $pck = Util_Utils::getParametre('pck', $categorie);
                            $fs = 0;
                            $panu_fs = 0;
                            $credi = floor($mont_place * $prk / $pck);
                            if (($type == 'rpg' and $categorie == 'r') or ( $type == 'i' and $categorie == 'r')) {
                                $bmap = new Application_Model_EuCapsMapper();
                                $bnp = new Application_Model_EuCaps();
                                if ($membre->getAuto_enroler() == 'n') {
                                    $bnp = $bmap->fetchCapsByBeneficiaire($membre_benef->getCode_membre());
                                    $fs_valeur = Util_Utils::getParametre('fs', 'valeur');
                                    if ($bnp != null and $bnp->getId_credit() == null) {
                                        $t_map = new Application_Model_EuTypeBnpMapper();
                                        $tbnp = new Application_Model_EuTypeBnp();
                                        $t_map->find($bnp->getType_bnp(), $tbnp);
                                        $fs = floor($credi * $tbnp->getTxfs() / 100);
                                        if ($bnp->getPanu() == 1) {
                                            $panu_fs = floor($credi * $tbnp->getTx_panu_fs());
                                        }
                                        if ($fs < ($fs_valeur / 23)) {
                                            $fs = ($fs_valeur / 23);
                                        }
                                        $credi = $credi - $fs;
                                    }
                                }
                            }

                            $compte = new Application_Model_EuCompte();
                            $result = $cm_mapper->find($num_compte, $compte);
                            if ($result == false) {
                                $type_compte = 'nb';
                                if ($code === 'CNCSnr') {
                                    $type_compte = 'nr';
                                }
                                Util_Utils::createCompte($num_compte, $type, $code_cat, $credi, $code_memb_benef, $type_compte, $date_deb, 0);
                            } else {
                                $compte->setSolde($compte->getSolde() + $credi);
                                $cm_mapper->update($compte);
                            }

                            //Mise � jour des comptes credits
                            $cc_mapper = new Application_Model_EuCompteCreditMapper();
                            $source = $code_memb_benef . $date_deb->toString('yyyyMMddHHmmss');
                            $max_code = $cc_mapper->findConuter() + 1;
                            $periode = Util_Utils::getParametre('periode', 'valeur');
                            $date_fin->addDay($periode);
                            $compte_source = '';
                            if ($type == 'rpg') {
                                $compte_source = 'caparpg';
                            } elseif ($type == 'i') {
                                $compte_source = 'capai';
                            } else {
                                $compte_source = 'capacncs';
                            }
                            $renouveller = 'o';
                            if ($categorie == 'nr') {
                                $renouveller = 'n';
                            }
                            Util_Utils::createCompteCredit($max_code, 0, $compteur, $code_memb_benef, $code, $num_compte, $credi, $mont_place, $date_deb, $date_fin, $source, $compte_source, 'n', $renouveller, 0, 0, nULL, $prk, $type_credit);

                            // Mise � jour des capa
                            $capa = new Application_Model_EuCapa();
                            $code_capa = 'capa' . $type . $date_deb->toString('yyyyMMddHHmmss');
                            $capa->setCode_capa($code_capa)
                                    ->setCode_compte($num_compte)
                                    ->setDate_capa($date_deb->toString('yyyy-mm-dd'))
                                    ->setHeure_capa($date_deb->toString('hh:mm'))
                                    ->setCode_membre($code_memb_benef)
                                    ->setMontant_capa($mont_place)
                                    ->setType_capa($type)
                                    ->setCode_produit($type . $categorie)
                                    ->setId_operation($compteur)
                                    ->setEtat_capa('Actif')
                                    ->setId_credit($max_code)
                                    ->setOrigine_capa('nn');
                            $m_capa->save($capa);

                            if ($fs > 0) {
                                $bnp->setId_credit($max_code)
                                        ->setMont_fs($bnp->getMont_fs() + $fs)
                                        ->setIndexer(1);
                                if ($panu_fs > 0) {
                                    $bnp->setMont_panu_fs($bnp->getMont_panu_fs() + $panu_fs);
                                }
                                $bmap->update($bnp);

                                //Mise � jour du fs
                                $cfs = 'nb-tfs-' . $bnp->getCode_membre_app();
                                $compte_fs = new Application_Model_EuCompte();
                                $ret_fs = $cm_mapper->find($cfs, $compte_fs);
                                if ($ret_fs) {
                                    $compte_fs->setSolde($compte_fs->getSolde() + $fs);
                                    $cm_mapper->update($compte_fs);
                                } else {
                                    Util_Utils::createCompte($cfs, 'tfs', 'tfs', $fs, $bnp->getCode_membre_app(), 'nb', $date_deb, 0);
                                }

                                //Mise � jour des comptes credits
                                $source = $bnp->getCode_membre_app() . $date_deb->toString('yyyyMMddHHmmss');
                                $max_code = $cc_mapper->findConuter() + 1;
                                Util_Utils::createCompteCredit($max_code, 0, $compteur, $bnp->getCode_membre_app(), 'fs', $cfs, $fs, $bnp->getMont_caps(), $date_deb, $date_fin, $source, $num_compte, 'n', 'n', 0, 0, nULL, 1, 'CnPG');

                                $cnp = new Application_Model_EuCnp();
                                $m_cnp = new Application_Model_EuCnpMapper();
                                $cnp->setId_credit($max_code)
                                        ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                        ->setMont_debit($fs)
                                        ->setMont_credit(0)
                                        ->setSolde_cnp($fs)
                                        ->setType_cnp($code)
                                        ->setSource_credit($source)
                                        ->setCode_capa($code_capa)
                                        ->setTransfert_gcp(0);
                                if ($code == 'Inr') {
                                    $cnp->setOrigine_cnp('FGInr');
                                } elseif ($code == 'Ir') {
                                    $cnp->setOrigine_cnp('FGIr');
                                } elseif ($code == 'RPGr') {
                                    $cnp->setOrigine_cnp('FGRPGr');
                                } elseif ($code == 'RPGnr') {
                                    $cnp->setOrigine_cnp('FGRPGnr');
                                }
                                $m_cnp->save($cnp);

                                //Mise � jour du Panu fs
                                if ($panu_fs > 0) {
                                    $cpanu_fs = 'nb-TPaNu-' . $bnp->getCode_membre_app();
                                    $compte_pfs = new Application_Model_EuCompte();
                                    $ret_pfs = $cm_mapper->find($cpanu_fs, $compte_pfs);
                                    if ($ret_pfs) {
                                        $compte_pfs->setSolde($compte_pfs->getSolde() + $panu_fs);
                                        $cm_mapper->update($compte_pfs);
                                    } else {
                                        Util_Utils::createCompte($cpanu_fs, 'TPaNu', 'TPaNu', $panu_fs, $bnp->getCode_membre_app(), 'nb', $date_deb, 0);
                                    }
                                    //Mise � jour des comptes credits
                                    $max_code = $cc_mapper->findConuter() + 1;
                                    $source = $bnp->getCode_membre_app() . $date_deb->toString('yyyyMMddHHmmss');
                                    Util_Utils::createCompteCredit($max_code, 0, $compteur, $bnp->getCode_membre_app(), 'Panu', $cpanu_fs, $panu_fs, $bnp->getMont_caps(), $date_deb, $date_fin, $source, $num_compte, 'n', 'n', 0, 0, nULL, 1, 'CnPG');

                                    $cnp = new Application_Model_EuCnp();
                                    $m_cnp = new Application_Model_EuCnpMapper();
                                    $cnp->setId_credit($max_code)
                                            ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                            ->setMont_debit($panu_fs)
                                            ->setMont_credit(0)
                                            ->setSolde_cnp($panu_fs)
                                            ->setType_cnp($code)
                                            ->setSource_credit($source)
                                            ->setCode_capa($code_capa)
                                            ->setTransfert_gcp(0);
                                    if ($code == 'Inr') {
                                        $cnp->setOrigine_cnp('FGInr');
                                    } elseif ($code == 'Ir') {
                                        $cnp->setOrigine_cnp('FGIr');
                                    } elseif ($code == 'RPGr') {
                                        $cnp->setOrigine_cnp('FGRPGr');
                                    } elseif ($code == 'RPGnr') {
                                        $cnp->setOrigine_cnp('FGRPGnr');
                                    }
                                    $m_cnp->save($cnp);
                                }
                            }

                            if ($type !== 'cncs') {
                                //Mise � jour du cnp
                                $cnp = new Application_Model_EuCnp();
                                $m_cnp = new Application_Model_EuCnpMapper();
                                $cnp->setId_credit($max_code)
                                        ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                        ->setMont_debit($credi)
                                        ->setMont_credit(0)
                                        ->setSolde_cnp($credi)
                                        ->setType_cnp($code)
                                        ->setSource_credit($source)
                                        ->setCode_capa($code_capa)
                                        ->setTransfert_gcp(0);
                                if ($code == 'Inr') {
                                    $cnp->setOrigine_cnp('FGInr');
                                } elseif ($code == 'Ir') {
                                    $cnp->setOrigine_cnp('FGIr');
                                } elseif ($code == 'RPGr') {
                                    $cnp->setOrigine_cnp('FGRPGr');
                                } elseif ($code == 'RPGnr') {
                                    $cnp->setOrigine_cnp('FGRPGnr');
                                }
                                $m_cnp->save($cnp);

                                //Mise � jour de la table fn
                                $fn = new Application_Model_EuFn();
                                $m_fn = new Application_Model_EuFnMapper();
                                $fn->setCode_capa($code_capa)
                                        ->setDate_fn($date_deb->toString('yyyy-mm-dd'));
                                if ($categorie == 'nr') {
                                    $fn->setType_fn('Inr');
                                } else {
                                    $fn->setType_fn('Ir');
                                }
                                $fn->setMontant($mont_place)
                                        ->setSortie(0)
                                        ->setEntree(0)
                                        ->setSolde(0)
                                        ->setMt_solde($mont_place);
                                $m_fn->save($fn);
                            } else {
                                // Cr�ation du cncs correspondant au smc
                                $smc = new Application_Model_EuSmc();
                                $m_smc = new Application_Model_EuSmcMapper();
                                $smc->setCode_capa($code_capa)
                                        ->setId_credit($max_code)
                                        ->setDate_smc($date_deb->toString('yyyy-mm-dd'))
                                        ->setMontant($credi)
                                        ->setEntree(0)
                                        ->setSortie(0)
                                        ->setSolde(0)
                                        ->setSource_credit($source)
                                        ->setMontant_solde($credi)
                                        ->setOrigine_smc(1);
                                $smc->setType_smc('CNCSnr');
                                $m_smc->save($smc);
                            }
                            //Mise � jour des fgfn
                            $gac_source = '0010010010040000029M';
                            $fgfn = new Application_Model_EuFgfn();
                            $fgfn_map = new Application_Model_EuFgfnMapper();
                            $code_fgfn = 'fgfn-' . $gac_source;
                            $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                            if (!$ret_fg) {
                                $fgfn->setCode_fgfn($code_fgfn)
                                        ->setCode_membre($gac_source)
                                        ->setSolde_fgfn($montant);
                                $fgfn_map->save($fgfn);
                            } else {
                                $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $montant);
                                $fgfn_map->update($fgfn);
                            }
                            $det_fg = new Application_Model_EuDetailFgfn();
                            $fg_mapper = new Application_Model_EuDetailFgfnMapper();
                            $det_fg->setCode_capa($code_capa)
                                    ->setCode_membre_pbf($gac_source)
                                    ->setMont_fgfn($montant)
                                    ->setDate_fgfn($date_deb->toString('yyyy-mm-dd'))
                                    ->setMont_preleve(0)
                                    ->setSolde_fgfn($montant)
                                    ->setCode_fgfn($code_fgfn)
                                    ->setType_capa('capa' . $type)
                                    ->setCreditcode('')
                                    ->setOrigine_fgfn('nn');
                            $fg_mapper->save($det_fg);
                        }

                        //Mise � jour des comptes g�n�raux
                        $compte_gene = new Application_Model_EuCompteGeneral();
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $result2 = false;
                        try {
                            if ($type == 'rpg') {
                                $result2 = $cg_mapper->find('fgnnrpg', 'nn', 'e', $compte_gene);
                            } elseif ($type == 'i') {
                                $result2 = $cg_mapper->find('fgnni', 'nn', 'e', $compte_gene);
                            } else {
                                $result2 = $cg_mapper->find('FGnnCNCSnr', 'nn', 'e', $compte_gene);
                            }
                            if ($result2) {
                                $compte_gene->setSolde($compte_gene->getSolde() + $montant);
                                $cg_mapper->update($compte_gene);
                            } else {
                                if ($type == 'rpg') {
                                    $compte_gene->setCode_compte('fgnnrpg');
                                    $compte_gene->setIntitule('fgrpg nn');
                                } elseif ($type == 'i') {
                                    $compte_gene->setCode_compte('fnngi');
                                    $compte_gene->setIntitule('fgi nn');
                                } else {
                                    $compte_gene->setCode_compte('FGNNCNCSnr');
                                    $compte_gene->setIntitule('FGCNCSnr nn');
                                }
                                $compte_gene->setCode_type_compte('nn');
                                $compte_gene->setService('e');
                                $compte_gene->setSolde($montant);
                                $cg_mapper->save($compte_gene);
                            }

                            //Mise � jour du compte g�n�ral fgfn
                            $fgfn = new Application_Model_EuCompteGeneral();
                            $result3 = $cg_mapper->find('fgnnfn', 'nn', 'e', $fgfn);
                            if ($result3) {
                                $fgfn->setSolde($fgfn->getSolde() + $montant);
                                $cg_mapper->update($fgfn);
                            } else {
                                $fgfn->setCode_compte('fgnnfn');
                                $fgfn->setIntitule('fgfn nn');
                                $fgfn->setService('e')->setCode_type_compte('nn');
                                $fgfn->setSolde($montant);
                                $cg_mapper->save($fgfn);
                            }

                            //Mise � jour du compte g�n�ral fn
                            $cgfn = new Application_Model_EuCompteGeneral();
                            $result_3 = $cg_mapper->find('fnnn', 'nr', 'e', $cgfn);
                            if ($result_3) {
                                $cgfn->setSolde($cgfn->getSolde() + $montant);
                                $cg_mapper->update($cgfn);
                            } else {
                                $cgfn->setCode_compte('fnnn');
                                $cgfn->setIntitule('fn nn');
                                $cgfn->setService('e')->setCode_type_compte('nr');
                                $cgfn->setSolde($montant);
                                $cg_mapper->save($cgfn);
                            }
                        } catch (Exception $e) {
                            $db->rollback();
                            $message = 'Erreur d\'�x�cution : ' . $e->getMessage() . $e->getTraceAsString();
                            $this->view->data = $message;
                            return;
                        }
                        //Mise du compte nn
                        $compte_nn->setSolde($compte_nn->getSolde() - $montant);
                        $cm_mapper->update($compte_nn);

                        $util_nn = new Application_Model_EuUtiliserNn();
                        $util_nn_map = new Application_Model_EuUtiliserNnMapper();
                        $util_nn->setCode_membre_nn($num_membre)
                                ->setCode_membre_nb($code_memb_benef)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setId_operation($compteur)
                                ->setCode_produit($type)
                                ->setCode_produit_nn($type_compte)
                                ->setMont_transfert($montant)
                                ->setDate_transfert($date_deb->toString('yyyy-mm-dd'))
                                ->setNum_bon('')
                                ->setCode_sms('');
                        $util_nn_map->save($util_nn);

                        //Envoie du sms au membre
                        Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $compte->getSolde());
                    } else {
                        $db->rollback();
                        $message = 'Erreur d\'�x�cution : Le solde de votre compte ' . $compte_nn->getCode_compte() . ' est insuffisant pour effectuer cette op�ration!!!';
                        $this->view->data = $message;
                        return;
                    }
                    $db->commit();
                    $this->view->data = true;
                    return;
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'�x�cution : ' . $exc->getMessage() . '=>' . $exc->getTraceAsString();
                $this->view->data = $message;
                return;
            }
        }
    }

    public function newmfAction() {
        $request = $this->getRequest();
        $type_capa = $request->type;
        $this->view->type = $type_capa;
    }

    public function donewmfAction() {
        // action body
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $fs = 0;
            $credi = $request->mont_credit;
            $num_bon = $request->num_bon;
            $code_sms = $request->code_sms;
            $num_membre = $request->code_membre;
            $code_memb_benef = $request->code_membre_dest;
            $type = $request->code_produit;
            $categorie = $request->cat_produit;
            $montant = $request->mont_capa;
            $prk = $request->prk;
            $type_credit = $request->type_credit;
            if ($prk == '' || $type_credit == '') {
                $this->view->message = "Le Type credit et la prk sont obligatoires!!!";
                return;
            }

            $code_dev = $request->dev_capa;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $m_membre = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $membre_benef = new Application_Model_EuMembre();
                $retm = $m_membre->find($num_membre, $membre);
                if (!$retm) {
                    $db->rollback();
                    $this->view->message = "Le membre $num_membre n'existe pas";
                    return;
                }

                $retour = $m_membre->find($code_memb_benef, $membre_benef);
                if (!$retour) {
                    $db->rollback();
                    $this->view->message = "Ce membre $code_memb_benef n'existe pas";
                    return;
                } else {
                    if (($membre_benef->getType_membre() == 'p' and $type !== 'RpG')) {
                        $db->rollback();
                        $this->view->data = "Les membres Personnes Physiques ne peuvent acheter que le rpg !!!";
                        return;
                    } elseif (($membre_benef->getType_membre() == 'm' and $type == 'rpg')) {
                        $db->rollback();
                        $this->view->data = 'Les membres Personnes Morales ne peuvent acheter que le (i) investissement ou le (CNCSnr) Salaire !!!';
                        return;
                    } elseif (($membre_benef->getType_membre() == 'm' && $type == 'cncs')) {
                        if ($categorie == 'r') {
                            $db->rollback();
                            $this->view->data = 'Les personnes morales ne peuvent acheter que le (CNCSnr) Salaire non r�current !!!';
                            return;
                        } elseif ($categorie == 'nr' && ($membre_benef->getCode_type_acteur() != 'ose' || $membre_benef->getCode_type_acteur() != 'Pose')) {
                            $m_acteur = new Application_Model_EuActeurCreneauMapper();
                            $ret_act = $m_acteur->findActeurByMembre($membre_benef->getCode_membre());
                            if ($ret_act == null) {
                                $db->rollback();
                                $this->view->data = 'Cette personne morale n\'est pas un acteur du r�seau mcnp!!!';
                                return;
                            }
                        }
                    }

                    //Verfication du produit
                    $prod = new Application_Model_EuProduit();
                    $code = $type . $categorie;
                    $p_mapper = new Application_Model_EuProduitMapper();
                    $p_result = $p_mapper->find($code, $prod);
                    if (!$p_result) {
                        $this->view->data = "Ce produit " . $code . " n'existe pas";
                        return;
                    }
                    if ($code_sms != '' && $num_bon != '' && $montant != '') {
                        //V�rification du solde du mf
                        $mont_prel = $montant + ($montant * 10 / 100);
                        $code_compte = 'nn-tr-' . $num_bon;
                        $compte_mf = new Application_Model_EuCompte();
                        $cm_mapper = new Application_Model_EuCompteMapper();
                        $mf_result = $cm_mapper->find($code_compte, $compte_mf);
                        $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                        $sms = $sms_mapper->findByCreditCode($code_sms);
                        if ($sms != null && $sms->getIDDateTimeConsumed() == 0 && $sms->getDestAccount_Consumed() == '' && $mf_result && $compte_mf->getSolde() >= $mont_prel && $sms->getCreditAmount() == $montant) {
                            $montant = $sms->getCreditAmount();
                            if ($code_dev != 'xof') {
                                $code_cours = $code_dev . '-xof';
                                $cours = new Application_Model_EuCours();
                                $m_cours = new Application_Model_EuCoursMapper();
                                $ret = $m_cours->find($code_cours, $cours);
                                if ($ret) {
                                    if ($montant != '') {
                                        $montant = $montant * $cours->getVal_dev_fin();
                                    }
                                }
                            }

                            $num_compte = '';
                            $code_cat = '';
                            if ($type == 'rpg' or $type == 'i') {
                                $code_cat = 'tpagc' . $type;
                                $num_compte = 'nb-' . $code_cat . '-' . $code_memb_benef;
                            } else {
                                $code_cat = 't' . $type . 'ei';
                                $num_compte = 'nr-' . $code_cat . '-' . $code_memb_benef;
                            }
                            $mapper = new Application_Model_EuOperationMapper();
                            $compteur = $mapper->findConuter() + 1;
                            $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                            $date_deb = clone $date_fin;
                            $lib_op = '';
                            if ($type == 'rpg') {
                                $lib_op = 'Achat du rpg';
                            } elseif ($type == 'i') {
                                $lib_op = 'Achat d\'Investissement';
                            } else {
                                $lib_op = 'Achat du cncs';
                            }
                            Util_Utils::addOperation($compteur, $code_memb_benef, $code_cat, $montant, $code, $lib_op, 'apa', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);

                            //v�rification des quotas
                            $mont_place = $montant;
                            $m_sqmaxui = new Application_Model_EuBnpSqmaxMapper();
                            $sqmax = 0;
                            $somme = 0;
                            $m_capa = new Application_Model_EuCapaMapper();
                            if ($type == 'rpg' && $categorie == 'r') {
                                $quota = Util_Utils::getParametre('quota', 'RPGr');
                                $somme = $m_capa->getSumQuotaRPG($code_memb_benef, $type, $categorie . $type);
                                if ($somme < $quota) {
                                    $reste = $quota - ($somme + $mont_place);
                                    if ($reste < 0) {
                                        $sqmax = abs($reste);
                                        $sqmaxui = new Application_Model_EuBnpSqmax();
                                        $sqmaxui->setCode_cat($code_cat);
                                        $sqmaxui->setCode_membre($code_memb_benef);
                                        $sqmaxui->setMontant($sqmax);
                                        $m_sqmaxui->save($sqmaxui);
                                        $mont_place = $mont_place - $sqmax;
                                    }
                                } else {
                                    $sqmax = $mont_place;
                                    $sqmaxui = new Application_Model_EuBnpSqmax();
                                    $sqmaxui->setCode_cat($code_cat);
                                    $sqmaxui->setCode_membre($code_memb_benef);
                                    $sqmaxui->setMontant($sqmax);
                                    $m_sqmaxui->save($sqmaxui);
                                    $mont_place = 0;
                                }
                            }
                            if ($mont_place > 0) {
                                $pck = Util_Utils::getParametre('pck', $categorie);
                                $fs = 0;
                                $panu_fs = 0;
                                $credi = floor($mont_place * $prk / $pck);
                                if (($type == 'rpg' and $categorie == 'r') or ( $type == 'i' and $categorie == 'r')) {
                                    $bmap = new Application_Model_EuCapsMapper();
                                    $bnp = new Application_Model_EuCaps();
                                    if ($membre->getAuto_enroler() == 'n') {
                                        $bnp = $bmap->fetchCapsByBeneficiaire($membre_benef->getCode_membre());
                                        $fs_valeur = Util_Utils::getParametre('fs', 'valeur');
                                        if ($bnp != null and $bnp->getId_credit() == null) {
                                            $t_map = new Application_Model_EuTypeBnpMapper();
                                            $tbnp = new Application_Model_EuTypeBnp();
                                            $t_map->find($bnp->getType_bnp(), $tbnp);
                                            $fs = floor($credi * $tbnp->getTxfs() / 100);
                                            if ($bnp->getPanu() == 1) {
                                                $panu_fs = floor($credi * $tbnp->getTx_panu_fs());
                                            }
                                            if ($fs < ($fs_valeur / 23)) {
                                                $fs = ($fs_valeur / 23);
                                            }
                                            $credi = $credi - $fs;
                                        }
                                    }
                                }

                                $compte = new Application_Model_EuCompte();
                                $result = $cm_mapper->find($num_compte, $compte);
                                if ($result == false) {
                                    $type_compte = 'nb';
                                    if ($code === 'CNCSnr') {
                                        $type_compte = 'nr';
                                    }
                                    Util_Utils::createCompte($num_compte, $type, $code_cat, $credi, $code_memb_benef, $type_compte, $date_deb, 0);
                                } else {
                                    $compte->setSolde($compte->getSolde() + $credi);
                                    $cm_mapper->update($compte);
                                }

                                //Mise � jour des comptes credits
                                $cc_mapper = new Application_Model_EuCompteCreditMapper();
                                $source = $code_memb_benef . $date_deb->toString('yyyyMMddHHmmss');
                                $max_code = $cc_mapper->findConuter() + 1;
                                $periode = Util_Utils::getParametre('periode', 'valeur');
                                $date_fin->addDay($periode);
                                $compte_source = '';
                                if ($type == 'rpg') {
                                    $compte_source = 'caparpg';
                                } elseif ($type == 'i') {
                                    $compte_source = 'capai';
                                } else {
                                    $compte_source = 'capacncs';
                                }
                                $renouveller = 'o';
                                if ($categorie == 'nr') {
                                    $renouveller = 'n';
                                }
                                Util_Utils::createCompteCredit($max_code, 0, $compteur, $code_memb_benef, $code, $num_compte, $credi, $mont_place, $date_deb, $date_fin, $source, $compte_source, 'n', $renouveller, 0, 0, nULL, $prk, $type_credit);

                                // Mise � jour des capa
                                $capa = new Application_Model_EuCapa();
                                $code_capa = 'capa' . $type . $date_deb->toString('yyyyMMddHHmmss');
                                $capa->setCode_capa($code_capa)
                                        ->setCode_compte($num_compte)
                                        ->setDate_capa($date_deb->toString('yyyy-mm-dd'))
                                        ->setHeure_capa($date_deb->toString('hh:mm'))
                                        ->setCode_membre($code_memb_benef)
                                        ->setMontant_capa($mont_place)
                                        ->setType_capa($type)
                                        ->setCode_produit($type . $categorie)
                                        ->setId_operation($compteur)
                                        ->setEtat_capa('Actif')
                                        ->setId_credit($max_code)
                                        ->setOrigine_capa('mf');
                                $m_capa->save($capa);

                                if ($fs > 0) {
                                    $bnp->setId_credit($max_code)
                                            ->setMont_fs($bnp->getMont_fs() + $fs)
                                            ->setIndexer(1);
                                    if ($panu_fs > 0) {
                                        $bnp->setMont_panu_fs($bnp->getMont_panu_fs() + $panu_fs);
                                    }
                                    $bmap->update($bnp);
                                    //Mise � jour du fs
                                    $cfs = 'nb-tfs-' . $bnp->getCode_membre_app();
                                    $compte_fs = new Application_Model_EuCompte();
                                    $ret_fs = $cm_mapper->find($cfs, $compte_fs);
                                    if ($ret_fs) {
                                        $compte_fs->setSolde($compte_fs->getSolde() + $fs);
                                        $cm_mapper->update($compte_fs);
                                    } else {
                                        Util_Utils::createCompte($cfs, 'tfs', 'tfs', $fs, $bnp->getCode_membre_app(), 'nb', $date_deb, 0);
                                    }

                                    //Mise � jour des comptes credits
                                    $source = $bnp->getCode_membre_app() . $date_deb->toString('yyyyMMddHHmmss');
                                    $max_code = $cc_mapper->findConuter() + 1;
                                    Util_Utils::createCompteCredit($max_code, 0, $compteur, $bnp->getCode_membre_app(), 'fs', $cfs, $fs, $bnp->getMont_caps(), $date_deb, $date_fin, $source, $num_compte, 'n', 'n', 0, 0, nULL, 1, 'CnPG');

                                    $cnp = new Application_Model_EuCnp();
                                    $m_cnp = new Application_Model_EuCnpMapper();
                                    $cnp->setId_credit($max_code)
                                            ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                            ->setMont_debit($fs)
                                            ->setMont_credit(0)
                                            ->setSolde_cnp($fs)
                                            ->setType_cnp($code)
                                            ->setSource_credit($source)
                                            ->setCode_capa($code_capa)
                                            ->setTransfert_gcp(0);
                                    if ($code == 'Inr') {
                                        $cnp->setOrigine_cnp('FGInr');
                                    } elseif ($code == 'Ir') {
                                        $cnp->setOrigine_cnp('FGIr');
                                    } elseif ($code == 'RPGr') {
                                        $cnp->setOrigine_cnp('FGRPGr');
                                    } elseif ($code == 'RPGnr') {
                                        $cnp->setOrigine_cnp('FGRPGnr');
                                    }
                                    $m_cnp->save($cnp);

                                    //Mise � jour du Panu fs
                                    if ($panu_fs > 0) {
                                        $cpanu_fs = 'nb-TPaNu-' . $bnp->getCode_membre_app();
                                        $compte_pfs = new Application_Model_EuCompte();
                                        $ret_pfs = $cm_mapper->find($cpanu_fs, $compte_pfs);
                                        if ($ret_pfs) {
                                            $compte_pfs->setSolde($compte_pfs->getSolde() + $panu_fs);
                                            $cm_mapper->update($compte_pfs);
                                        } else {
                                            Util_Utils::createCompte($cpanu_fs, 'TPaNu', 'TPaNu', $panu_fs, $bnp->getCode_membre_app(), 'nb', $date_deb, 0);
                                        }
                                        //Mise � jour des comptes credits
                                        $max_code = $cc_mapper->findConuter() + 1;
                                        $source = $bnp->getCode_membre_app() . $date_deb->toString('yyyyMMddHHmmss');
                                        Util_Utils::createCompteCredit($max_code, 0, $compteur, $bnp->getCode_membre_app(), 'Panu', $cpanu_fs, $panu_fs, $bnp->getMont_caps(), $date_deb, $date_fin, $source, $num_compte, 'n', 'n', 0, 0, nULL, 1, 'CnPG');

                                        $cnp = new Application_Model_EuCnp();
                                        $m_cnp = new Application_Model_EuCnpMapper();
                                        $cnp->setId_credit($max_code)
                                                ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                                ->setMont_debit($panu_fs)
                                                ->setMont_credit(0)
                                                ->setSolde_cnp($panu_fs)
                                                ->setType_cnp($code)
                                                ->setSource_credit($source)
                                                ->setCode_capa($code_capa)
                                                ->setTransfert_gcp(0);
                                        if ($code == 'Inr') {
                                            $cnp->setOrigine_cnp('FGInr');
                                        } elseif ($code == 'Ir') {
                                            $cnp->setOrigine_cnp('FGIr');
                                        } elseif ($code == 'RPGr') {
                                            $cnp->setOrigine_cnp('FGRPGr');
                                        } elseif ($code == 'RPGnr') {
                                            $cnp->setOrigine_cnp('FGRPGnr');
                                        }
                                        $m_cnp->save($cnp);
                                    }
                                }

                                if ($type !== 'cncs') {
                                    //Mise � jour du cnp
                                    $cnp = new Application_Model_EuCnp();
                                    $m_cnp = new Application_Model_EuCnpMapper();
                                    $cnp->setId_credit($max_code)
                                            ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                            ->setMont_debit($credi)
                                            ->setMont_credit(0)
                                            ->setSolde_cnp($credi)
                                            ->setType_cnp($code)
                                            ->setSource_credit($source)
                                            ->setCode_capa($code_capa)
                                            ->setTransfert_gcp(0);
                                    if ($code == 'Inr') {
                                        $cnp->setOrigine_cnp('FGInr');
                                    } elseif ($code == 'Ir') {
                                        $cnp->setOrigine_cnp('FGIr');
                                    } elseif ($code == 'RPGr') {
                                        $cnp->setOrigine_cnp('FGRPGr');
                                    } elseif ($code == 'RPGnr') {
                                        $cnp->setOrigine_cnp('FGRPGnr');
                                    }
                                    $m_cnp->save($cnp);

                                    //Mise � jour de la table fn
                                    $fn = new Application_Model_EuFn();
                                    $m_fn = new Application_Model_EuFnMapper();
                                    $fn->setCode_capa($code_capa)
                                            ->setDate_fn($date_deb->toString('yyyy-mm-dd'));
                                    if ($categorie == 'nr') {
                                        $fn->setType_fn('Inr');
                                    } else {
                                        $fn->setType_fn('Ir');
                                    }
                                    $fn->setMontant($mont_place)
                                            ->setSortie(0)
                                            ->setEntree(0)
                                            ->setSolde(0)
                                            ->setMt_solde($mont_place);
                                    $m_fn->save($fn);
                                } else {
                                    // Cr�ation du cncs correspondant au smc
                                    $smc = new Application_Model_EuSmc();
                                    $m_smc = new Application_Model_EuSmcMapper();
                                    $smc->setCode_capa($code_capa)
                                            ->setId_credit($max_code)
                                            ->setDate_smc($date_deb->toString('yyyy-mm-dd'))
                                            ->setMontant($credi)
                                            ->setEntree(0)
                                            ->setSortie(0)
                                            ->setSolde(0)
                                            ->setSource_credit($source)
                                            ->setMontant_solde($credi)
                                            ->setOrigine_smc(1);
                                    $smc->setType_smc('CNCSnr');
                                    $m_smc->save($smc);
                                }
                            }

                            //Mise � jour des comptes g�n�raux
                            $compte_gene = new Application_Model_EuCompteGeneral();
                            $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                            $result2 = false;
                            try {
                                if ($type == 'rpg') {
                                    $result2 = $cg_mapper->find('fgmfrpg', 'nn', 'e', $compte_gene);
                                } elseif ($type == 'i') {
                                    $result2 = $cg_mapper->find('fgmfi', 'nn', 'e', $compte_gene);
                                } else {
                                    $result2 = $cg_mapper->find('FGMFCNCSnr', 'nn', 'e', $compte_gene);
                                }
                                if ($result2) {
                                    $compte_gene->setSolde($compte_gene->getSolde() + $montant);
                                    $cg_mapper->update($compte_gene);
                                } else {
                                    if ($type == 'rpg') {
                                        $compte_gene->setCode_compte('fgmfrpg');
                                        $compte_gene->setIntitule('fgrpg MF11000');
                                    } elseif ($type == 'i') {
                                        $compte_gene->setCode_compte('fgmfi');
                                        $compte_gene->setIntitule('fgi MF11000');
                                    } else {
                                        $compte_gene->setCode_compte('FGMFCNCSnr');
                                        $compte_gene->setIntitule('FGCNCSnr MF11000');
                                    }
                                    $compte_gene->setCode_type_compte('nn');
                                    $compte_gene->setService('e');
                                    $compte_gene->setSolde($montant);
                                    $cg_mapper->save($compte_gene);
                                }

                                //Mise � jour du compte g�n�ral fgfn
                                $fgfn = new Application_Model_EuCompteGeneral();
                                $result3 = $cg_mapper->find('fgmffn', 'nn', 'e', $fgfn);
                                if ($result3) {
                                    $fgfn->setSolde($fgfn->getSolde() + $montant);
                                    $cg_mapper->update($fgfn);
                                } else {
                                    $fgfn->setCode_compte('fgmffn');
                                    $fgfn->setIntitule('fgfn MF11000');
                                    $fgfn->setService('e')->setCode_type_compte('nn');
                                    $fgfn->setSolde($montant);
                                    $cg_mapper->save($fgfn);
                                }

                                //Mise � jour du compte g�n�ral fn
                                $cgfn = new Application_Model_EuCompteGeneral();
                                $result_3 = $cg_mapper->find('fnmf', 'nr', 'e', $cgfn);
                                if ($result_3) {
                                    $cgfn->setSolde($cgfn->getSolde() + $montant);
                                    $cg_mapper->update($cgfn);
                                } else {
                                    $cgfn->setCode_compte('fnmf');
                                    $cgfn->setIntitule('fn MF11000');
                                    $cgfn->setService('e')->setCode_type_compte('nr');
                                    $cgfn->setSolde($montant);
                                    $cg_mapper->save($cgfn);
                                }
                            } catch (Exception $e) {
                                $db->rollback();
                                $message = 'Erreur d\'�x�cution : ' . $e->getMessage() . $e->getTraceAsString();
                                $this->view->data = $message;
                                return;
                            }

                            $td_fact = new Application_Model_DbTable_EuDetailFacturation();
                            $d_fact = new Application_Model_EuDetailFacturation();
                            $tx_prestation = Util_Utils::getParametre('cncs', 'capa');
                            $code_membre_fgfn = $user->code_membre;
                            //V�rification de l'origine du code sms et Mise � jour du d�tail 
                            $compte_transfert = $sms->getFromAccount();
                            $transfert = explode('-', $compte_transfert);
                            $membre_transfert = $transfert[2];
                            $t_acteur = new Application_Model_DbTable_EuActeur();
                            $select = $t_acteur->select()

                            ;
                            $select->where('code_membre like ?', $membre_transfert)->where('code_activite in (?)', array(
                                'dsms', 'pbf'));
                            $results = $t_acteur->fetchAll($select);

                            if (count($results) > 0) {
                                $acteur = $results->current();
                                if ($acteur->code_activite == 'dsms') {
                                    $t_detsms = new Application_Model_DbTable_EuDetailSmsmoney();
                                    $sms_select = $db->select();
                                    $sms_select->from('eu_detail_smsmoney', array('code_membre_dist', 'sum(solde_sms) as solde'));
                                    $sms_select->where('code_membre_dist like ?', $acteur->code_membre)
                                            ->where('origine_sms like ?', 'pbf')
                                            ->having("solde > $montant");
                                    $sms_results = $db->fetchAll($sms_select);
                                    if (count($sms_results) > 0) {
                                        $select_det_sms = $db->select();
                                        $select_det_sms->from('eu_detail_smsmoney')
                                                ->where('code_membre_dist like ?', $acteur->code_membre)
                                                ->where('origine_sms like ?', 'pbf');
                                        $details_sms = $db->fetchAll($select_det_sms);
                                        if (count($details_sms) > 0) {
                                            $mont_deduire = $montant;
                                            $det_sms = new Application_Model_EuDetailSmsmoney();
                                            try {
                                                foreach ($details_sms as $value) {
                                                    $det_vtesms = new Application_Model_EuDetailVentesms( );
                                                    $tdet_vtesms = new Application_Model_DbTable_EuDetailVentesms ( );
                                                    $fgfn = new Application_Model_EuFgfn ( );
                                                    $fgfn_map = new Application_Model_EuFgfnMapper();
                                                    $det_fg = new Application_Model_EuDetailFgfn();
                                                    $fg_mapper = new Application_Model_EuDetailFgfnMapper();
                                                    $det_sms->exchangeArray($value);
                                                    $code_membre_fgfn = $det_sms->getCode_membre();
                                                    if ($det_sms->getSolde_sms() >= $mont_deduire) {
                                                        //Mise � jour des fgfn
                                                        $code_fgfn = 'fgfn-' . $code_membre_fgfn;
                                                        $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                                                        if (!$ret_fg) {
                                                            $fgfn->setCode_fgfn($code_fgfn)
                                                                    ->setCode_membre($code_membre_fgfn)->setSolde_fgfn($mont_deduire);

                                                            $fgfn_map->save($fgfn);
                                                        } else {
                                                            $fgfn->setSolde_fgfn($fgfn->
                                                                            getSolde_fgfn() + $mont_deduire);
                                                            $fgfn_map->update($fgfn);
                                                        };

                                                        $det_fg->setCode_capa($code_capa)
                                                                ->setCode_membre_pbf($code_membre_fgfn)
                                                                ->setMont_fgfn($mont_deduire)
                                                                ->setDate_fgfn($date_deb->toString('yyyy-mm-dd'))->setMont_preleve(0)->setSolde_fgfn($mont_deduire)->setCode_fgfn($code_fgfn)
                                                                ->setType_capa('capa' . $type)->setCreditcode($sms->getCreditCode())
                                                                ->setOrigine_fgfn('mf');
                                                        $fg_mapper->save($det_fg);

                                                        $det_vtesms->setId_detail_smsmoney($det_sms->getId_detail_smsmoney())
                                                                ->setCode_membre_dist($det_sms->getCode_membre_dist())
                                                                ->setCode_membre($membre->getCode_membre())
                                                                ->setType_tansfert($sms->getMotif())
                                                                ->setCreditcode($sms->getCreditcode())
                                                                ->setDate_vente($date_deb->toString('yyyy-mm-dd'))->setMont_vente($mont_deduire)->setId_utilisateur($user->id_utilisateur)
                                                                ->setCode_produit($code);
                                                        $tdet_vtesms->insert($det_vtesms->toArray());

                                                        $det_sms->setMont_vendu($det_sms->getMont_vendu() + $mont_deduire)->setSolde_sms($det_sms->getSolde_sms() - $mont_deduire);
                                                        $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));

                                                        $mont_deduire = 0;
                                                    } else {
                                                        $mont_deduire -= $det_sms->getSolde_sms();
                                                        //Mise � jour des fgfn
                                                        $code_fgfn = 'fgfn-' . $code_membre_fgfn;
                                                        $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                                                        if (!$ret_fg) {
                                                            $fgfn->setCode_fgfn($code_fgfn)->setCode_membre($code_membre_fgfn)
                                                                    ->setSolde_fgfn($det_sms->getSolde_sms());
                                                            $fgfn_map->save($fgfn);
                                                        } else {
                                                            $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $det_sms->getSolde_sms());
                                                            $fgfn_map->update($fgfn);
                                                        }

                                                        $det_fg->setCode_capa($code_capa)
                                                                ->setCode_membre_pbf($code_membre_fgfn)
                                                                ->setMont_fgfn($det_sms->getSolde_sms())
                                                                ->setDate_fgfn($date_deb->toString('yyyy-mm-dd'))
                                                                ->setMont_preleve(0)
                                                                ->setSolde_fgfn($det_sms->getSolde_sms())
                                                                ->setCode_fgfn($code_fgfn)
                                                                ->setType_capa('capa' . $type)
                                                                ->setCreditcode($sms->getCreditCode())
                                                                ->setOrigine_fgfn('mf');
                                                        $fg_mapper->save($det_fg);

                                                        $det_vtesms->setId_detail_smsmoney($det_sms->getId_detail_smsmoney())
                                                                ->setCode_membre_dist($det_sms->getCode_membre_dist())
                                                                ->setCode_membre($membre->getCode_membre())
                                                                ->setType_tansfert($sms->getMotif())
                                                                ->setCreditcode($sms->getCreditcode())
                                                                ->setDate_vente($date_deb->toString('yyyy-mm-dd'))
                                                                ->setMont_vente($det_sms->getSolde_sms())
                                                                ->setId_utilisateur($user->id_utilisateur)
                                                                ->setCode_produit($code);
                                                        $tdet_vtesms->insert($det_vtesms->toArray());

                                                        $det_sms->setMont_vendu($det_sms->getMont_vendu() + $det_sms->getSolde_sms())
                                                                ->setSolde_sms(0);
                                                        $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));
                                                    }
                                                    if ($mont_deduire == 0) {
                                                        break;
                                                    }
                                                }
                                            } catch (Exception $exc) {
                                                $db->rollback();
                                                $this->view->data = "Nbre : " . count($details_sms) . " " . $exc->getMessage() . " => " . $exc->getTraceAsString();
                                                return;
                                            }
                                        } else {
                                            $db->rollback();
                                            $this->view->data = "Aucun enregistrement trouv�!!!";
                                            return;
                                        }
                                    } else {
                                        $db->rollback();
                                        $message = 'Erreur d\'�x�cution : Votre compte de transfert est insuffisant pour effectuer cet op�ration';
                                        $this->view->data = $message;
                                        return;
                                    }

                                    //Facturations de la prestation
                                    $mont_fact = $sms->getCreditAmount() * $tx_prestation / 100;
                                    $_compte = new Application_Model_EuCompte();
                                    $num_compte_fact = 'nn-' . 'tpagcp-' . $membre_transfert;
                                    $result = $cm_mapper->find($num_compte_fact, $_compte);
                                    if ($result == false) {
                                        $_compte->setCode_membre($membre_transfert)
                                                ->setCode_cat('tpagcp')
                                                ->setSolde($mont_fact)
                                                ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                ->setCode_compte($num_compte_fact)
                                                ->setLib_compte('gcp')
                                                ->setCode_type_compte('nn')
                                                ->setDesactiver(0);
                                        $cm_mapper->save($_compte);
                                    } else {
                                        $_compte->setSolde($_compte->getSolde() + $mont_fact);
                                        $cm_mapper->update($_compte);
                                    }

                                    $d_fact->setCode_compte($num_compte_fact)
                                            ->setCode_membre($membre->getCode_membre())
                                            ->setCreditcode($sms->getCreditcode())
                                            ->setDate_facturation($date_deb->toString('yyyy-mm-dd'))
                                            ->setMont_facturation($mont_fact)
                                            ->setId_operation($compteur)
                                            ->setId_cnp(0);
                                    $td_fact->insert($d_fact->toArray());

                                    $sms->setDestAccount_Consumed($num_compte)
                                            ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                    $sms_mapper->update($sms);
                                } else {
                                    //Mise � jour des fgfn
                                    $fgfn = new Application_Model_EuFgfn();
                                    $fgfn_map = new Application_Model_EuFgfnMapper();
                                    $code_fgfn = 'fgfn-' . $code_membre_fgfn;
                                    $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                                    if (!$ret_fg) {
                                        $fgfn->setCode_fgfn($code_fgfn)
                                                ->setCode_membre($code_membre_fgfn)
                                                ->setSolde_fgfn($montant);
                                        $fgfn_map->save($fgfn);
                                    } else {
                                        $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $montant);
                                        $fgfn_map->update($fgfn);
                                    }
                                    $det_fg = new Application_Model_EuDetailFgfn();
                                    $fg_mapper = new Application_Model_EuDetailFgfnMapper();
                                    $det_fg->setCode_capa($code_capa)
                                            ->setCode_membre_pbf($code_membre_fgfn)
                                            ->setMont_fgfn($montant)
                                            ->setDate_fgfn($date_deb->toString('yyyy-mm-dd'))
                                            ->setMont_preleve(0)
                                            ->setSolde_fgfn($montant)
                                            ->setCode_fgfn($code_fgfn)
                                            ->setType_capa('capa' . $type)
                                            ->setCreditcode($sms->getCreditCode())
                                            ->setOrigine_fgfn('mf');
                                    $fg_mapper->save($det_fg);
                                    $sms->setDestAccount_Consumed($num_compte)
                                            ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                    $sms_mapper->update($sms);
                                }
                            } else {
                                $db->rollback();
                                $message = "Erreur d\'�x�cution : Cet acteur " . $membre_transfert . " n'existe pas. Veuilez contacter le mcnp!";
                                $this->view->data = $message;
                                return;
                            }



                            //Mise du compte mf
                            $compte_mf->setSolde($compte_mf->getSolde() - $mont_prel);
                            $cm_mapper->update($compte_mf);

                            $tab_det_sms = new Application_Model_DbTable_EuDetailSmsmoney();
                            $det_sms = new Application_Model_EuDetailSmsmoney();
                            $det_sms->setCode_membre_dist($user->code_membre)
                                    ->setCode_membre($num_membre)
                                    ->setCreditcode('')
                                    ->setMont_sms($mont_prel)
                                    ->setDate_allocation($date_deb->toString('yyyy-mm-dd'))
                                    ->setMont_vendu(0)
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setSolde_sms($montant)
                                    ->setType_sms('fs')
                                    ->setOrigine_sms('mf');
                            $tab_det_sms->insert($det_sms->toArray());

                            $compte = new Application_Model_EuCompte();
                            $code_compte = 'nn-tr-' . $user->code_membre;
                            $ret_req = $cm_mapper->find($code_compte, $compte);
                            if ($ret_req == false) {
                                $compte->setCode_cat('tr')
                                        ->setCode_membre($user->code_membre)
                                        ->setCode_compte($code_compte)
                                        ->setCode_type_compte('nn')
                                        ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                        ->setDesactiver(0)
                                        ->setLib_compte('Compte de recharge')
                                        ->setSolde($mont_prel);
                                $cm_mapper->save($compte);
                            } else {
                                $compte->setSolde($compte->getSolde() + $mont_prel);
                                $cm_mapper->update($compte);
                            }

                            $rep_reg = new Application_Model_EuRepReglement();
                            $rep_reg_map = new Application_Model_EuRepReglementMapper();
                            $repmf_map = new Application_Model_EuRepartitionMf11000Mapper();
                            $reg_mf = new Application_Model_EuReglementMf();
                            $reg_mf_map = new Application_Model_EuReglementMfMapper();
                            $solde_mf = $repmf_map->getSoldeMf11000($num_bon);
                            if ($solde_mf >= $montant) {
                                $reg_mf->setCode_membre($num_membre)
                                        ->setDate_reglt_mf($date_deb->toString('yyyy-mm-dd'))
                                        ->setId_utilisateur($user->id_utilisateur)
                                        ->setType_mf('MF11000')
                                        ->setType_reglt_mf('capa')
                                        ->setMont_reglt_mf($mont_prel);
                                $reg_mf_map->save($reg_mf);

                                $reps_mf = $repmf_map->fetchRepByNumBon($num_bon);
                                if (count($reps_mf) > 0) {
                                    $mf_deduire = $mont_prel;
                                    foreach ($reps_mf as $value) {
                                        if ($value->getSolde_rep() >= $mf_deduire) {
                                            $value->setMont_reglt($value->getMont_reglt() + $mf_deduire)
                                                    ->setSolde_rep($value->getSolde_rep() - $mf_deduire);
                                            if ($value->getSolde_rep() == 0) {
                                                $value->setPayer(1);
                                            }
                                            $repmf_map->update($value);
                                            $rep_reg->setId_reglt_mf($reg_mf->getId_reglt_mf())
                                                    ->setId_rep($value->getId_rep())
                                                    ->setMont_rep_reglt($mf_deduire);
                                            $rep_reg_map->save($rep_reg);
                                            break;
                                        } else {
                                            $rep_reg->setId_reglt_mf($reg_mf->getId_reglt_mf())
                                                    ->setId_rep($value->getId_rep())
                                                    ->setMont_rep_reglt($mf_deduire);
                                            $rep_reg_map->save($rep_reg);
                                            $mf_deduire -= $value->getSolde_rep();
                                            $value->setMont_reglt($value->getMont_reglt() + $value->getSolde_rep())
                                                    ->setSolde_rep(0)
                                                    ->setPayer(1);
                                            $repmf_map->update($value);
                                            if ($mf_deduire == 0) {
                                                break;
                                            }
                                        }
                                    }
                                }
                            } else {
                                $db->rollback();
                                $message = 'Erreur d\'�x�cution : Votre compte MF11000 est insuffisant pour effectuer cet op�ration : ' . $solde_mf;
                                $this->view->data = $message;
                                return;
                            }

                            $util_nn = new Application_Model_EuUtiliserNn();
                            $util_nn_map = new Application_Model_EuUtiliserNnMapper();
                            $util_nn->setCode_membre_nn($num_membre)
                                    ->setCode_membre_nb($code_memb_benef)
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setId_operation($compteur)
                                    ->setCode_produit($type)
                                    ->setCode_produit_nn('MF11000')
                                    ->setMont_transfert($mont_prel)
                                    ->setDate_transfert($date_deb->toString('yyyy-mm-dd'))
                                    ->setNum_bon($num_bon)
                                    ->setCode_sms($code_sms);
                            $util_nn_map->save($util_nn);

                            //Envoie du sms au membre
                            Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $compte->getSolde());

                            $db->commit();
                            $this->view->data = true;
                            return;
                        } else {
                            $db->rollback();
                            $message = 'Erreur d\'�x�cution : Le code sms ' . $code_sms . ' est invalide ou inconnu pour effectuer cette op�ration!!!';
                            $this->view->data = $message;
                            return;
                        }
                    } else {
                        $db->rollback();
                        $message = 'Erreur d\'�x�cution : Le code sms n\'est pas rensiegn�!!!';
                        $this->view->data = $message;
                        return;
                    }
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'�x�cution : ' . $exc->getMessage() . '=>' . $exc->getTraceAsString();
                $this->view->data = $message;
                return;
            }
        }
    }

    public function donewcapamfAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            //$code_membre = $request->code_membre;
            //$type_capa = $request->type_mf;
            //$code_sms = $request->code_sms;
            //$mont_capa = $request->mont_capa;
            //$dev_capa = $request->dev_capa;

            $code_membre = $_POST["code_membre"];
            $type_capa = $_POST["code_type_mf"];
            $code_sms = $_POST["code_sms"];
            $mont_capa = $_POST ["mont_capa"];
            $dev_capa = $_POST ["dev_capa"];

            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $m_membre = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $retour = $m_membre->find($code_membre, $membre);
                if (!$retour) {
                    $this->view->data = " Ce membre n'existe pas: " . $code_membre;
                    $this->view->code_membre = $code_membre;
                    $this->view->type_capa = $type_capa;
                    $this->view->mont_capa = $mont_capa;
                    $this->view->dev_capa = $dev_capa;
                    return;
                } else {
                    $cm_mapper = new Application_Model_EuCompteMapper();
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $sms = $sms_mapper->findByCreditCode($code_sms);
                    if ($sms != null && $sms->getIDDateTimeConsumed() == 0 && $sms->getDestAccount_Consumed() == ' ') {
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
                    //Param�tre de renouvellement
                    $mf = Util_Utils::getParametre($type_capa, 'valeur');

                    if ($type_capa == 'MF107') {
                        $code_cat = 'TMF107';
                        $lib_op = 'Achat de MF107';
                        $code_compte = 'nn-TMF107-' . $code_membre;
                    } elseif ($type_capa == 'MF11000') {
                        $code_cat = 'TMF11000';
                        $code_compte = 'nn-TMF11000-' . $code_membre;
                        $lib_op = 'Achat de MF11000';
                    } else {
                        $code_cat = 'tmfl';
                        $lib_op = 'Achat de mfl';
                        $code_compte = 'nn-tmfl-' . $code_membre;
                    }
                    // Contr�le sur les type de capa
                    if ($sms->getMotif() != $type_capa) {
                        $this->view->data = " Le motif de ce type de capa n'est pas correspondant pour cette type d'operation";
                        $this->view->code_membre = $code_membre;
                        $this->view->type_capa = $type_capa;
                        $this->view->mont_capa = $mont_capa;
                        $this->view->dev_capa = $dev_capa;
                        return;
                    }
                    // Contr�le sur le montant
                    $multiple = $montant / 70000;
                    if (is_int($multiple) == false) {
                        $this->view->data = " Le montant du capa mf n'est pas un multiple de 70000 ";
                        $this->view->code_membre = $code_membre;
                        $this->view->type_capa = $type_capa;
                        $this->view->mont_capa = $mont_capa;
                        $this->view->dev_capa = $dev_capa;
                        return;
                    }
                    $mapper = new Application_Model_EuOperationMapper();
                    $compteur = $mapper->findConuter() + 1;
                    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
                    Util_Utils::addOperation($compteur, $code_membre, null, $code_cat, $montant, $type_capa, $lib_op, 'apa', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);




                    //$comp = Util_Utils::findConuter() + 1;
                    //Util_Utils::addSms($comp,$membre->getPortable_membre(),"Vous venez de placer " . $montant . " " . $dev_capa . " sur le compte " . $code_compte . ". Solde final: " . $compte->getSolde());
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
                $this->view->mont_capa = $mont_capa;
                $this->view->dev_capa = $dev_capa;
                return;
            }
        }
    }

    public function nrpreAction() {
        $request = $this->getRequest();
		$user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		$code_membre = $user->code_membre;
		$this->view->code_membre = $code_membre;
		
		
		
		
        $this->view->type = $request->type;
    }

	
	
	
	
    public function dopreAction() {
        //action body
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
		    $type_capa = $request->type;
            $credi = $request->mont_credit;
            $num_membre = $request->code_membre;
            $type = $request->code_produit;
            $montant = $request->mont_capa;
            $mode_finance = $request->mode_finance;
            $code_dev = "xof";
            if ($mode_finance === "sms") {
                $code_dev = $request->dev_capa;
                $code_sms = $request->code_sms;
                $mont_sms = $request->mont_sms;
            }
            if ($type === "rpg") {
                $nom_membre = $request->nom_membre;
                $prenom_membre = $request->prenom_membre;
            }
            $mont_inv = $request->mont_inv;
            $duree_inv = $request->duree_inv;
            $pre = $request->pre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try {
		        $membre = new Application_Model_EuMembre();
                $moral = new Application_Model_EuMembreMorale();
                if (Util_Utils::verifierMembre($num_membre)) {
                    $type_membre = Util_Utils::getMembreType($num_membre);
                    if (($type_membre === 'p' && $type === 'RpG') || ($type === 'i' && $type_membre === 'm')) {
                        if ($type_membre === 'p') {
                            Util_Utils::getMembre($num_membre, $membre);
                        } else {
                            Util_Utils::getMembreMorale($num_membre, $moral);
                        }
                    } else {
                        $this->view->message = "Opération invalide: Vérifier le type de produit  avec le type de membre!!!";
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->message = "Ce membre $num_membre n'existe pas";
                    return;
                }
				
                $prod = new Application_Model_EuProduit();
                $code = $type . 'nrPRE';
                $p_mapper = new Application_Model_EuProduitMapper();
                $p_result = $p_mapper->find($code, $prod);
                if (!$p_result) {
                    $db->rollback();
                    $this->view->message = "Ce produit n'existe pas";
                    return;
                }
				$cm_mapper = new Application_Model_EuCompteMapper();
				$compte = new Application_Model_EuCompte();
                $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                $sms = new Application_Model_EuSmsmoney();
				if ($mode_finance === 'sms') {
                    $ret = $sms_mapper->findSMSMoneyByCodeSMS($code_sms,$sms);
                    if ($ret) {
                        $montant = Util_Utils::verifierCodeSMS($sms);
                    }
                }
				
				if(($sms->getMotif() != "rpgnrprekit") && ($sms->getMotif() != "inrprekit")) {
				  $db->rollback();
                  $this->view->message = "Le motif pour lequel le code sms est émis ne correspond pas à cette opération";
                  return;
				}
				
				//calcul de la pre et du crédit
                $prk = Util_Utils::getParametre('prk', 'nr');
                $pck = Util_Utils::getParametre('pck', 'nr');
                if ($duree_inv > floor($prk)) {
                    $pre = $duree_inv;
                    $credi = round($mont_inv / $pre);
                    $montant = round($credi * $pck);
                    $renouveller = 'o';
                } else {
                    $db->rollback();
                    $this->view->message = "La durée pre doit être supérieure à la valeur prk   ".$prk;
                    return;
                }
                
				$num_compte = '';
                $code_cat = '';
                if ($type == 'rpg' or $type == 'i') {
                    $code_cat = 'tpagc' . $type;
                    $num_compte = 'nb-' . $code_cat . '-' . $num_membre;
                }
				
				$mapper = new Application_Model_EuOperationMapper();
                $compteur = $mapper->findConuter() + 1;
                $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                $date_deb = clone $date_fin;
                $lib_op = '';
				
                if ($type == 'rpg') {
                    $lib_op = 'capa rpg';
                } elseif ($type == 'i') {
                    $lib_op = 'capa i';
                }
				
				if (substr($num_membre, -1) == "p") {
				   Util_Utils::addOperation($compteur, $num_membre, null, $code_cat, $montant, $code, $lib_op, 'apa',$date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);
				} else {
				   Util_Utils::addOperation($compteur,null,$num_membre,$code_cat,$montant,$code,$lib_op,'apa',$date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);
				}
				
				//vérification des quotas
                $mont_place = $montant;
				if ($mont_place > 0) {
				   $result = $cm_mapper->find($num_compte,$compte);
				   if (!$result) {
                        $type_compte = 'nb';
						if (substr($num_membre, -1) == "p") {
                           Util_Utils::createCompte($num_compte, $type, $code_cat, $credi, $num_membre, $type_compte,$date_deb->toString('yyyy-mm-dd'),0,null);
                        } else {
						   Util_Utils::createCompte($num_compte, $type, $code_cat, $credi,null, $type_compte,$date_deb->toString('yyyy-mm-dd'),0,$num_membre);
						}
					} else {
                        $compte->setSolde($compte->getSolde() + $credi);
                        $cm_mapper->update($compte);
                    }
					
					//Mise à jour des comptes credits
                    $cc_mapper = new Application_Model_EuCompteCreditMapper();
					$cr = new Application_Model_EuCompteCredit();
                    $source = $num_membre . $date_deb->toString('yyyyMMddHHmmss');
                    $max_code = $cc_mapper->findConuter() + 1;
                    $periode = Util_Utils::getParametre('periode','valeur');
                    $date_fin->addDay($periode);
                    $compte_source = '';
                    if ($type == 'rpg') {
                        $compte_source = 'caparpg';
                    } elseif ($type == 'i') {
                        $compte_source = 'capai';
                    }
					
					//Util_Utils::createCompteCredit($max_code, 1, $compteur, $num_membre, $code, $num_compte, $credi, $mont_place, $date_deb, $date_fin, $source, $compte_source, 'n', $renouveller, 0, 0, nULL, '', $pre);
					$cr->setId_credit($max_code)
                       ->setCode_membre($num_membre)
                       ->setCode_produit($code)
                       ->setMontant_place($mont_place)
                       ->setDatedeb(Util_Utils::toDate($date_deb))
                       ->setDatefin(Util_Utils::toDate($date_fin))
                       ->setDate_octroi(Util_Utils::toDate($date_deb))
                       ->setSource($source)
                       ->setCode_compte($num_compte)
                       ->setId_operation($compteur)
                       ->setBnp(0)
                       ->setCode_bnp(null)
                       ->setCompte_source($compte_source)
                       ->setMontant_credit($credi)
                       ->setRenouveller($renouveller)
                       ->setKrr('n')
                       ->setPrk($pre)
                       ->setNbre_renouvel($pre)
                       ->setCode_type_credit('cnpg')
                       ->setDomicilier(0);
                    $cc_mapper->save($cr);
					
					
					// Mise à jour des capa
                    $m_capa = new Application_Model_EuCapaMapper();
					$capa = new Application_Model_EuCapa();
                    $code_capa = 'capa' . $type . $date_deb->toString('yyyyMMddHHmmss');
                    $capa->setCode_capa($code_capa)
                         ->setCode_compte($num_compte)
                         ->setDate_capa(Util_Utils::toDate($date_deb))
                         ->setHeure_capa(Util_Utils::toDate($date_deb))
						 ->setOrigine_capa('sms')
                         ->setCode_membre($num_membre)
                         ->setMontant_capa($mont_place)
                         ->setId_operation($compteur)
                         ->setEtat_capa('Actif')
                         ->setMontant_utiliser($mont_place)
                         ->setMontant_solde(0)
						 ->setType_capa($type)
					     ->setCode_produit($code);	 
                    $m_capa->save($capa);
					
					$m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
                    $credit_capa = new Application_Model_EuCompteCreditCapa();
                    $credit_capa->setCode_capa($code_capa)
                                ->setCode_produit($type . "nrPRE")
                                ->setId_credit($max_code)
                                ->setMontant($mont_place);
                    $m_credit_capa->save($credit_capa);
					
					//Mise à jour de la table fn
                    $fn = new Application_Model_EuFn();
                    $m_fn = new Application_Model_EuFnMapper();
					$maxfn = $m_fn->findConuter() + 1;
                    $fn->setId_fn($maxfn)
					   ->setCode_capa($code_capa)
                       ->setDate_fn(Util_Utils::toDate($date_deb));            
                    $fn->setType_fn('Inr');
                    $fn->setMontant($mont_place)
                       ->setSortie(0)
                       ->setEntree(0)
                       ->setSolde(0)
					   ->setOrigine_fn(0)
                       ->setMt_solde($mont_place);
                    $m_fn->save($fn);
					
					
					//Mise à jour du cnp
                    $cnp = new Application_Model_EuCnp();
                    $m_cnp = new Application_Model_EuCnpMapper();
					$maxcnp = $m_cnp->findConuter() + 1;
                    $cnp->setId_cnp($maxcnp) 
					    ->setId_credit($max_code)
                        ->setDate_cnp(Util_Utils::toDate($date_deb))
                        ->setMont_debit($credi)
                        ->setMont_credit(0)
                        ->setSolde_cnp($credi)
                        ->setType_cnp($code)
                        ->setSource_credit($source)
                        ->setTransfert_gcp(0);
                    if ($code == 'InrPRE') {
                        $cnp->setOrigine_cnp('FGInrPRE');
                    } elseif ($code == 'RPGnrPRE') {
                        $cnp->setOrigine_cnp('FGRPGnrPRE');
                    }
                    $m_cnp->save($cnp);
					
					
					
					
					//Mise à jour des comptes généraux
                    $compte_gene = new Application_Model_EuCompteGeneral();
                    $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                    $result2 = false;
                    if ($type == 'rpg') {
                        $res_cg = $cg_mapper->find('fgrpg', 'nn', 'e', $compte_gene);
                    } else {
                        $res_cg = $cg_mapper->find('fgi', 'nn', 'e', $compte_gene);
                    }
                    if ($res_cg) {
                        $compte_gene->setSolde($compte_gene->getSolde() + $montant);
                        $cg_mapper->update($compte_gene);
                    } else {
                        if ($type == 'rpg') {
                            $compte_gene->setCode_compte('fgrpg');
                            $compte_gene->setIntitule('fgrpg');
                        } else {
                            $compte_gene->setCode_compte('fgi');
                            $compte_gene->setIntitule('fgi');
                        }
                        $compte_gene->setCode_type_compte('nn');
                        $compte_gene->setService('e');
                        $compte_gene->setSolde($montant);
                        $cg_mapper->save($compte_gene);
                    }

                    //Mise à jour du compte général fn
                    $cgfn = new Application_Model_EuCompteGeneral();
                    $res_fn = $cg_mapper->find('fn', 'nr', 'e', $cgfn);
                    if ($res_fn) {
                        $cgfn->setSolde($cgfn->getSolde() + $montant);
                        $cg_mapper->update($cgfn);
                    } else {
                        $cgfn->setCode_compte('fn');
                        $cgfn->setIntitule('fn');
                        $cgfn->setService('e');
                        $cgfn->setCode_type_compte('nr');
                        $cgfn->setSolde($montant);
                        $cg_mapper->save($cgfn);
                    }
                }
                if (isset($sms)) {
                    $sms->setDestAccount_Consumed($num_compte)
                            ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                    $sms_mapper->update($sms);
                }
                $sms_map = new Application_Model_EuSmsMapper();
                $last_sms = Util_Utils::findConuter() + 1;
                if ($type_membre === 'p') {
                    Util_Utils::addSms($last_sms + 1, $membre->getPortable_membre(), "Vous venez de recharger $credi $code_dev sur le compte $num_compte Solde final: " . $credi);
                } else {
                    Util_Utils::addSms($last_sms + 1, $moral->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $credi);
                }
					
					
					
					
					
					
					
					
				
				
				
				
                				
				 
				 
				 
				  
		        $db->commit();
                $this->view->message = true;
                return;
		    } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . ' Stack Trace :' . $exc->getTraceAsString();
                $this->view->message = $message;
                return;
            }
		
		
		
		
		
		
		
		
		
		
		
		}
		
    }

}
