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
                  <li><a id="escompte" class="menuLink" href="#">rpg</a>
                      <ul style="width: 150px;z-index:1000000">
                          <li><a id="rpgr" href="/eu-placement/newr?type=rpg">Récurrent</a></li>
                          <li><a id="rpgnr" href="/eu-placement/newnr?type=rpg">Non Récurrent</a></li>
                      </ul>
                  </li>
                  <li><a href="/eu-placement/newnn?type=rpg" class="menuLink">rpg nn</a></li>
                 <li><a href="/eu-placement/newmf?type=rpg" class="menuLink">rpg MF11000</a></li>  
                </ul> 
              </li>
              <li><a class="menuLink">Investissement</a>
               <ul style="width: 180px;z-index:1000000">
                  <li><a id="escompte" class="menuLink" href="#">Investissement</a>
                      <ul style="width: 150px;z-index:1000000">
                          <li><a id="rpgr" href="/eu-placement/newr?type=i">Récurrent</a></li>
                          <li><a id="rpgnr" href="/eu-placement/newnr?type=i">Non Récurrent</a></li>
                      </ul>
                  </li>
                  <li><a href="/eu-placement/newnn?type=i" class="menuLink">investissement nn</a></li>
                 <li><a href="/eu-placement/newmf?type=i" class="menuLink">investissement mf</a></li>
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
                      <li><a id="credit" href="/eu-placement/recharger">Recharges de sms</a></li>
                  </ul>
              </li>
           </ul>';
            $this->view->placeholder("menu_accordeon")->set($menu);
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
            if ($user->code_groupe != 'apa' && $user->code_groupe != 'banque' && $user->code_groupe != 'aparpg' && $user->code_groupe != 'apai' && $user->code_groupe != 'apacncs' && $user->code_groupe != 'recharge') {
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
        $select->where('id_utilisateur like ?', $user->id_utilisateur)
                ->where('date_op = ?', $date_deb->toString('yyyy-mm-dd'))
                ->order('date_op', 'asc');
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
                $row->id_operation,
                $date_op->toString('dd/mm/yyyy'),
                $row->code_membre,
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

    public function rechargerAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $date = Zend_Date::now();
        if ($request->isPost()) {
            $num_membre = $request->code_membre;
            $montant = $request->mont_rec;
            $recu = $request->code_recu;
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
                $m_membre = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $retour = $m_membre->find($num_membre, $membre);
                if (!$retour) {
                    $this->view->message = "Ce membre n'existe pas";
                    $this->view->code_membre = $num_membre;
                    $this->view->code_recu = $recu;
                    $this->view->nom_membre = $membre->getNom_membre();
                    $this->view->prenom_membre = $membre->getPrenom_membre();
                    $this->view->raison_membre = $membre->getRaison_sociale();
                    $this->view->mont_capa = $montant;
                    $this->view->capa_dev = $code_dev;
                    $this->view->code_sms = $code_sms;
                    $db->rollback();
                    return;
                } else {
                    if ($membre->getType_membre() == 'p') {
                        $db->rollback();
                        $this->view->message = "Un membre physique ne peut utiliser ce compte !!!";
                        $this->view->code_membre = $num_membre;
                        $this->view->nom_membre = $membre->getNom_membre();
                        $this->view->prenom_membre = $membre->getPrenom_membre();
                        $this->view->raison_membre = $membre->getRaison_sociale();
                        $this->view->code_recu = $recu;
                        $this->view->mont_capa = $montant;
                        $this->view->capa_dev = $code_dev;
                        $this->view->code_sms = $code_sms;
                        return;
                    }
                }
                if ($code_sms != '') {
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $sms = $sms_mapper->findByCreditCode($code_sms);
                    if ($sms != null && $sms->getIDDateTimeConsumed() == 0 && $sms->getDestAccount_Consumed() == '') {
                        $compte_transfert = $sms->getFromAccount();
                        $transfert = explode('-', $compte_transfert);
                        $membre_transfert = $transfert[2];
                        $tab_acteur = new Application_Model_DbTable_EuActeur();
                        $select = $tab_acteur->select();
                        $select->where('code_membre like ?', $membre_transfert)
                                ->where('code_activite like ?', 'pbf');
                        $acteurs = $tab_acteur->fetchAll($select);
                        if (count($acteurs) == 0) {
                            $db->rollback();
                            $this->view->message = 'Le Code sms est invalide ou n\'est pas vendu par un pbf !!!';
                            $this->view->code_membre = $num_membre;
                            $this->view->nom_membre = $membre->getNom_membre();
                            $this->view->prenom_membre = $membre->getPrenom_membre();
                            $this->view->raison_membre = $membre->getRaison_sociale();
                            $this->view->code_recu = $recu;
                            $this->view->mont_capa = $montant;
                            $this->view->capa_dev = $code_dev;
                            $this->view->code_sms = $code_sms;
                            return;
                        }
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
                    } else {
                        $db->rollback();
                        $this->view->message = 'Le Code sms est invalide ou n\'est pas renseigné !!!';
                        $this->view->code_membre = $num_membre;
                        $this->view->nom_membre = $membre->getNom_membre();
                        $this->view->prenom_membre = $membre->getPrenom_membre();
                        $this->view->raison_membre = $membre->getRaison_sociale();
                        $this->view->code_recu = $recu;
                        $this->view->mont_capa = $montant;
                        $this->view->capa_dev = $code_dev;
                        $this->view->code_sms = $code_sms;
                        return;
                    }
                } else {
                    $tab_acteur = new Application_Model_DbTable_EuActeur();
                    $select = $tab_acteur->select();
                    $select->where('code_membre like ?', $user->code_membre)
                            ->where('code_activite like ?', 'pbf');
                    $acteurs = $tab_acteur->fetchAll($select);
                    if (count($acteurs) == 0) {
                        $db->rollback();
                        $this->view->message = 'Vous n\' etes pas un pbf. Vous ne pouvez pas recharger votre compte sans code sms !!!';
                        $this->view->code_membre = $num_membre;
                        $this->view->nom_membre = $membre->getNom_membre();
                        $this->view->prenom_membre = $membre->getPrenom_membre();
                        $this->view->raison_membre = $membre->getRaison_sociale();
                        $this->view->code_recu = $recu;
                        $this->view->mont_capa = $montant;
                        $this->view->capa_dev = $code_dev;
                        $this->view->code_sms = $code_sms;
                        return;
                    }
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
                }

                $compteur = $mapper->findConuter() + 1;
                $place = new Application_Model_EuOperation();
                $place->setId_operation($compteur)
                        ->setDate_op($date->toString('yyyy-mm-dd'))
                        ->setHeure_op($date->toString('hh:mm'))
                        ->setId_utilisateur($user->id_utilisateur)
                        ->setCode_produit(null)
                        ->setType_op('rec')
                        ->setMontant_op($montant)
                        ->setCode_membre($num_membre)->setLib_op('Recharge de compte')
                        ->setCode_cat('tr');
                $mapper->save($place);

                $compte = new Application_Model_EuCompte();
                $code_compte = 'nn-tr-' . $num_membre;
                $ret_req = $m_compte->find($code_compte, $compte);
                if ($ret_req == false) {
                    $compte->setCode_cat('tr')
                            ->setCode_membre($num_membre)
                            ->setCode_compte($code_compte)
                            ->setCode_type_compte('nn')
                            ->setDate_alloc($date->toString('yyyy-mm-dd'))
                            ->setDesactiver(0)
                            ->setLib_compte('Compte de recharge')
                            ->setSolde($montant);
                    $m_compte->save($compte);
                } else {
                    $compte->setSolde($compte->getSolde() + $montant);
                    $m_compte->update($compte);
                }

                if ($sms != null && $sms->getIDDateTimeConsumed() == 0 && $sms->getDestAccount_Consumed() == '') {
                    //Création du détail sms money
                    //Recherche de l'acteur
                    $code_activite = array("pbf", "dsms");
                    $tab_acteur = new Application_Model_DbTable_EuActeur();
                    $select = $tab_acteur->select();
                    $select->where('code_membre like ?', $num_membre)
                            ->where('code_activite in (?)', $code_activite);
                    $acteurs = $tab_acteur->fetchAll($select);
                    if (count($acteurs) > 0) {
                        $acteur = $acteurs->current();
                        if ($acteur->code_activite == 'dsms') {
                            $compte_transfert = $sms->getFromAccount();
                            $transfert = explode('-', $compte_transfert);
                            $membre_transfert = $transfert[2];
                            $tab_det_sms = new Application_Model_DbTable_EuDetailSmsmoney();
                            $det_sms = new Application_Model_EuDetailSmsmoney();
                            $det_sms->setCode_membre_dist($num_membre)
                                    ->setCode_membre($membre_transfert)
                                    ->setCreditcode($sms->getCreditCode())
                                    ->setMont_sms($sms->getCreditAmount())
                                    ->setDate_allocation($date->toString('yyyy-mm-dd'))
                                    ->setMont_vendu(0)
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setSolde_sms($sms->getCreditAmount())
									->setType_sms($sms->getMotif())
                                    ->setOrigine_sms('pbf');
                            $tab_det_sms->insert($det_sms->toArray());
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = "Ce membre n'est pas enregistré en tant qu'acteur pbf ou distributeur de Code sms";
                        $this->view->code_membre = $num_membre;
                        $this->view->nom_membre = $nom_membre;
                        $this->view->prenom_membre = $prenom_membre;
                        $this->view->raison_membre = $raison_membre;
                        $this->view->code_recu = $recu;
                        $this->view->mont_capa = $montant;
                        $this->view->capa_dev = $code_dev;
                        $this->view->code_sms = $code_sms;
                        return;
                    }
                    $sms->setDestAccount_Consumed($compte->getCode_compte())
                            ->setDateTimeconsumed($date->toString('dd/mm/yyyy hh:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')));
                    $sms_mapper->update($sms);
                    Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $montant . " " . $code_dev . " sur le compte " . $code_compte . ". Solde final: " . $compte->getSolde());
                }
                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . '=>' . $exc->getTraceAsString();
                $this->view->code_membre = $num_membre;
                $this->view->nom_membre = $nom_membre;
                $this->view->prenom_membre = $prenom_membre;
                $this->view->raison_membre = $raison_membre;
                $this->view->code_recu = $recu;
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
        $code = $_GET["code"];
        $prk = $_GET['prk'];
        $cat = $_GET['cat'];
        if ($code != '') {
            $data = array();
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('CreditCode = ?', $code)
                    ->where('IDDateTimeConsumed = ?', 0);
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $mont_capa = $results->current()->CreditAmount;
                $data[0] = $mont_capa;
                if ($prk != '') {
                    $pck = Util_Utils::getParametre('pck', $cat);
                    $credit = floor(($mont_capa * $prk) / $pck);
                    $data[1] = $credit;
                }
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
    }

    public function smsAction() {
        $code = $_GET["code"];
        if ($code != '') {
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('CreditCode like ?', $code)
                    ->where('DestAccount_Consumed = ?', '');
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $data[0] = $results->current()->CreditAmount;
                $data[1] = $results->current()->Motif;
            } else {
                $data[0] = 0;
                $data[1] = $code;
            }
        }
        $this->view->data = $data;
    }

    public function calculAction() {
        $cat = $_GET['cat'];
        $data = array();
        if ($cat != '') {
            $prk = 0;
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
            $select = $tparam->select();
            $select->where('code_param = ?', 'prk')
                    ->where('lib_param = ?', $cat);
            $rows = $tparam->fetchAll($select);
            if (count($rows) > 0) {
                $param = $rows->current();
                $prk = $param->montant;
            }
            $mont_capa = $_GET['montant'];
            $mont_credit = $_GET['credit'];
            if ($mont_capa != '') {
                $credit = floor(($mont_capa * $prk) / $pck);
                $data[0] = $credit;
            } elseif ($mont_credit != '') {
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

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[0] = strtoupper($result->nom_membre);
            $data[1] = ucfirst($result->prenom_membre);
            if ($result->type_membre == 'm') {
                $data[2] = $result->raison_sociale;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function recuptelAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembre();
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
        $pck = Util_Utils::getParametre('pck', 'r');
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
            $tbl_sms = new Application_Model_DbTable_EuSms();
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
                        $this->view->data = 'Erreur de traitement: Le cours de cette devise ' . $code_dev . ' n\'est pas encore défini';
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
                $this->view->data = 'Erreur de traitement: Il y a des champs qui n\'ont pas été renseignés';
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
            $code_sms = $request->code_sms;
            $prk = $request->prk;
            $type_credit = $request->type_credit;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $m_membre = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $retour = $m_membre->find($num_membre, $membre);
                if (!$retour) {
                    $db->rollback();
                    $this->view->message = "Ce membre n'existe pas";
                    return;
                } else {
                    if ($membre->getType_membre() == 'p' and $type !== 'RpG') {
                        $db->rollback();
                        $this->view->data = "Les membres Personnes Physiques ne peuvent acheter que le rpg !!!";
                        return;
                    } elseif ($membre->getType_membre() == 'm' and $type == 'rpg') {
                        $db->rollback();
                        $this->view->data = 'Les membres Personnes Morales ne peuvent acheter que le (i) investissement ou le (CNCSnr) Salaire !!!';
                        return;
                    } elseif ($membre->getType_membre() == 'm' && $type == 'cncs') {
                        if ($categorie == 'r') {
                            $db->rollback();
                            $this->view->data = 'Les personnes morales ne peuvent acheter que le (CNCSnr) Salaire non récurrent !!!';
                            return;
                        } elseif ($categorie == 'nr') {
                            $m_acteur = new Application_Model_EuActeurCreneauMapper();
                            $ret_act = $m_acteur->findActeurByMembre($membre->getCode_membre());
                            if ($ret_act == null) {
                                $db->rollback();
                                $this->view->data = 'Cette personne morale n\'est pas un acteur du réseau mcnp!!!';
                                return;
                            }
                        }
                    }

                    $prod = new Application_Model_EuProduit();
                    $code = $type . $categorie;
                    $p_mapper = new Application_Model_EuProduitMapper();
                    $p_result = $p_mapper->find($code, $prod);
                    if (!$p_result) {
                        $this->view->data = "Ce produit " . $code . " n'existe pas";
                        return;
                    }

                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $sms = $sms_mapper->findByCreditCode($code_sms);
                    if ($sms != null && $sms->getIDDateTimeConsumed() == 0 && $sms->getDestAccount_Consumed() == '' && $sms->getMotif() == 'capa') {
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
                            $num_compte = 'nb-' . $code_cat . '-' . $num_membre;
                        } else {
                            $code_cat = 't' . $type . 'ei';
                            $num_compte = 'nr-' . $code_cat . '-' . $num_membre;
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
                        Util_Utils::addOperation($compteur, $num_membre, $code_cat, $montant, $code, $lib_op, 'apa', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);

                        //vérification des quotas
                        $mont_place = $montant;
                        $m_sqmaxui = new Application_Model_EuBnpSqmaxMapper();
                        $sqmax = 0;
                        $somme = 0;
                        $cm_mapper = new Application_Model_EuCompteMapper();
                        $m_capa = new Application_Model_EuCapaMapper();
                        if ($type == 'rpg' && $categorie == 'r') {
                            $quota = Util_Utils::getParametre('quota', 'RPGr');
                            $somme = $m_capa->getSumQuotaRPG($num_membre, $type, $categorie . $type);
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
                            $pck = Util_Utils::getParametre('pck', $categorie);
                            $fs = 0;
                            $panu_fs = 0;
                            $credi = floor($mont_place * $prk / $pck);
                            if (($type == 'rpg' and $categorie == 'r') or ($type == 'i' and $categorie == 'r')) {
                                $bmap = new Application_Model_EuCapsMapper();
                                $bnp = new Application_Model_EuCaps();
                                if ($membre->getAuto_enroler() == 'n') {
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
                            Util_Utils::createCompteCredit($max_code, 0, $compteur, $num_membre, $code, $num_compte, $credi, $mont_place, $date_deb, $date_fin, $source, $compte_source, 'n', $renouveller, 0, 0, nULL, $prk, $type_credit);

                            // Mise à jour des capa
                            $capa = new Application_Model_EuCapa();
                            $code_capa = 'capa' . $type . $date_deb->toString('yyyyMMddHHmmss');
                            $capa->setCode_capa($code_capa)
                                    ->setCode_compte($num_compte)
                                    ->setDate_capa($date_deb->toString('yyyy-mm-dd'))
                                    ->setHeure_capa($date_deb->toString('hh:mm'))
                                    ->setCode_membre($num_membre)
                                    ->setMontant_capa($mont_place)
                                    ->setType_capa($type)
                                    ->setCode_produit($type . $categorie)
                                    ->setId_operation($compteur)
                                    ->setEtat_capa('Actif')
                                    ->setId_credit($max_code)
                                    ->setOrigine_capa('sms');
                            $m_capa->save($capa);

                            if ($fs > 0) {
                                $bnp->setId_credit($max_code)
                                        ->setMont_fs($bnp->getMont_fs() + $fs)
                                        ->setIndexer(1);
                                if ($panu_fs > 0) {
                                    $bnp->setMont_panu_fs($bnp->getMont_panu_fs() + $panu_fs);
                                }
                                $bmap->update($bnp);
                                //Mise à jour du fs
                                $cfs = 'nb-tfs-' . $bnp->getCode_membre_app();
                                $compte_fs = new Application_Model_EuCompte();
                                $ret_fs = $cm_mapper->find($cfs, $compte_fs);
                                if ($ret_fs) {
                                    $compte_fs->setSolde($compte_fs->getSolde() + $fs);
                                    $cm_mapper->update($compte_fs);
                                } else {
                                    Util_Utils::createCompte($cfs, 'tfs', 'tfs', $fs, $bnp->getCode_membre_app(), 'nb', $date_deb, 0);
                                }

                                //Mise à jour des comptes credits
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
                                //Mise à jour du cnp
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

                                //Mise à jour de la table fn
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
                                // Création du cncs correspondant au smc
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

                        //Mise à jour des comptes généraux
                        $compte_gene = new Application_Model_EuCompteGeneral();
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $result2 = false;
                        try {
                            if ($type == 'rpg') {
                                $result2 = $cg_mapper->find('fgrpg', 'nn', 'e', $compte_gene);
                            } elseif ($type == 'i') {
                                $result2 = $cg_mapper->find('fgi', 'nn', 'e', $compte_gene);
                            } else {
                                $result2 = $cg_mapper->find('FGCNCSnr', 'nn', 'e', $compte_gene);
                            }
                            if ($result2) {
                                $compte_gene->setSolde($compte_gene->getSolde() + $montant);
                                $cg_mapper->update($compte_gene);
                            } else {
                                if ($type == 'rpg') {
                                    $compte_gene->setNum_compte('fgrpg');
                                    $compte_gene->setIntitule('fgrpg');
                                } elseif ($type == 'i') {
                                    $compte_gene->setNum_compte('fgi');
                                    $compte_gene->setIntitule('fgi');
                                } else {
                                    $compte_gene->setNum_compte('FGCNCSnr');
                                    $compte_gene->setIntitule('FGCNCSnr');
                                }
                                $compte_gene->setCode_type('nn');
                                $compte_gene->setService('e');
                                $compte_gene->setSolde($montant);
                                $cg_mapper->save($compte_gene);
                            }

                            //Mise à jour du compte général fgfn
                            $fgfn = new Application_Model_EuCompteGeneral();
                            $result3 = $cg_mapper->find('fgfn', 'nn', 'e', $fgfn);
                            if ($result3) {
                                $fgfn->setSolde($fgfn->getSolde() + $montant);
                                $cg_mapper->update($fgfn);
                            } else {
                                $fgfn->setNum_compte('fgfn');
                                $fgfn->setIntitule('fgfn');
                                $fgfn->setService('e')->setCode_type('nn');
                                $fgfn->setSolde($montant);
                                $cg_mapper->save($fgfn);
                            }

                            //Mise à jour du compte général fn
                            $cgfn = new Application_Model_EuCompteGeneral();
                            $result_3 = $cg_mapper->find('fn', 'nr', 'e', $cgfn);
                            if ($result_3) {
                                $cgfn->setSolde($cgfn->getSolde() + $montant);
                                $cg_mapper->update($cgfn);
                            } else {
                                $cgfn->setNum_compte('fn');
                                $cgfn->setIntitule('fn');
                                $cgfn->setService('e')->setCode_type('nr');
                                $cgfn->setSolde($montant);
                                $cg_mapper->save($cgfn);
                            }
                        } catch (Exception $e) {
                            $db->rollback();
                            $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                            $this->view->data = $message;
                            return;
                        }

                        $td_fact = new Application_Model_DbTable_EuDetailFacturation();
                        $d_fact = new Application_Model_EuDetailFacturation();
                        $code_membre_fgfn = $user->code_membre;
                        //Vérification de l'origine du code sms et Mise à jour du détail 
                        $compte_transfert = $sms->getFromAccount();
                        $tx_prestation = Util_Utils::getParametre('cncs', 'capa');
                        $transfert = explode('-', $compte_transfert);
                        $membre_transfert = $transfert[2];
                        $t_acteur = new Application_Model_DbTable_EuActeur();
                        $select = $t_acteur->select();
                        $select->where('code_membre like ?', $membre_transfert)
                                ->where('code_activite in (?)', array('dsms', 'pbf'));
                        $results = $t_acteur->fetchAll($select);
                        if (count($results) > 0) {
                            $acteur = $results->current();
                            if ($acteur->code_activite == 'dsms') {
                                $t_detsms = new Application_Model_DbTable_EuDetailSmsmoney();
                                $sms_select = $db->select();
                                $sms_select->from('eu_detail_smsmoney', array('code_membre_dist', 'sum(solde_sms) as solde'));
                                $sms_select->where('code_membre_dist like ?', $acteur->code_membre)
                                        ->where('origine_sms like ?', 'pbf')
                                        ->having("solde >= $montant");
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
                                                $det_sms->exchangeArray($value);
                                                $code_membre_fgfn = $det_sms->getCode_membre();
                                                $det_vtesms = new Application_Model_EuDetailVentesms();
                                                $tdet_vtesms = new Application_Model_DbTable_EuDetailVentesms();
                                                $fgfn = new Application_Model_EuFgfn();
                                                $fgfn_map = new Application_Model_EuFgfnMapper();
                                                $det_fg = new Application_Model_EuDetailFgfn();
                                                $fg_mapper = new Application_Model_EuDetailFgfnMapper();
                                                if ($det_sms->getSolde_sms() >= $mont_deduire) {
                                                    //Mise à jour des fgfn
                                                    $code_fgfn = 'fgfn-' . $code_membre_fgfn;
                                                    $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                                                    if (!$ret_fg) {
                                                        $fgfn->setCode_fgfn($code_fgfn)
                                                                ->setCode_membre($code_membre_fgfn)
                                                                ->setSolde_fgfn($mont_deduire);
                                                        $fgfn_map->save($fgfn);
                                                    } else {
                                                        $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $mont_deduire);
                                                        $fgfn_map->update($fgfn);
                                                    }

                                                    $det_fg->setCode_capa($code_capa)
                                                            ->setCode_membre_pbf($code_membre_fgfn)
                                                            ->setMont_fgfn($mont_deduire)
                                                            ->setDate_fgfn($date_deb->toString('yyyy-mm-dd'))
                                                            ->setMont_preleve(0)
                                                            ->setSolde_fgfn($mont_deduire)
                                                            ->setCode_fgfn($code_fgfn)
                                                            ->setType_capa('capa' . $type)
                                                            ->setCreditcode($sms->getCreditCode())
                                                            ->setOrigine_fgfn('sms');
                                                    $fg_mapper->save($det_fg);

                                                    $det_vtesms->setId_detail_smsmoney($det_sms->getId_detail_smsmoney())
                                                            ->setCode_membre_dist($det_sms->getCode_membre_dist())
                                                            ->setCode_membre($membre->getCode_membre())
                                                            ->setType_tansfert($sms->getMotif())
                                                            ->setCreditcode($sms->getCreditcode())
                                                            ->setDate_vente($date_deb->toString('yyyy-mm-dd'))
                                                            ->setMont_vente($mont_deduire)
                                                            ->setId_utilisateur($user->id_utilisateur)
                                                            ->setCode_produit($code);
                                                    $tdet_vtesms->insert($det_vtesms->toArray());

                                                    $det_sms->setMont_vendu($det_sms->getMont_vendu() + $mont_deduire)
                                                            ->setSolde_sms($det_sms->getSolde_sms() - $mont_deduire);
                                                    $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));

                                                    $mont_deduire = 0;
                                                } else {
                                                    $mont_deduire -= $det_sms->getSolde_sms();
                                                    //Mise à jour des fgfn
                                                    $code_fgfn = 'fgfn-' . $code_membre_fgfn;
                                                    $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                                                    if (!$ret_fg) {
                                                        $fgfn->setCode_fgfn($code_fgfn)
                                                                ->setCode_membre($code_membre_fgfn)
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
                                                            ->setOrigine_fgfn('sms');
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
                                        $this->view->data = "Aucun enregistrement trouvé!!!";
                                        return;
                                    }
                                } else {
                                    $db->rollback();
                                    $message = 'Erreur d\'éxécution : Votre compte de transfert est insuffisant pour effectuer cet opération';
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
                                if ($code_membre_fgfn != $membre_transfert) {
                                    $code_membre_fgfn = $membre_transfert;
                                }
                                //Mise à jour des fgfn
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
                                        ->setOrigine_fgfn('sms');
                                $fg_mapper->save($det_fg);

                                $sms->setDestAccount_Consumed($num_compte)
                                        ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                $sms_mapper->update($sms);
                            }
                        } else {
                            $db->rollback();
                            $message = "Erreur d\'éxécution : Cet acteur " . $membre_transfert . " n'existe pas. Veuilez contacter le mcnp!";
                            $this->view->data = $message;
                            return;
                        }

                        //Factration à la source cnp
                        $select_act = $t_acteur->select();
                        $select_act->where('code_membre like ?', $user->code_membre)
                                ->where('code_activite like ?', 'dsms');
                        $results2 = $t_acteur->fetchAll($select_act);
                        if (count($results2) > 0) {
                            $mont_fact = $sms->getCreditAmount() * $tx_prestation / 100;
                            $cfact = 'nb-tpagci-' . $user->code_membre;
                            $compte_fact = new Application_Model_EuCompte();
                            $ret_fact = $cm_mapper->find($cfact, $compte_fact);
                            if ($ret_fact) {
                                $compte_fact->setSolde($compte_fact->getSolde() + $mont_fact);
                                $cm_mapper->update($compte_fact);
                            } else {
                                Util_Utils::createCompte($cfact, 'tpagci', 'tpagci', $mont_fact, $user->code_membre, 'nb', $date_deb, 0);
                            }

                            //Mise à jour des comptes credits
                            $source = $user->code_membre . $date_deb->toString('yyyyMMddHHmmss');
                            $max_code = $cc_mapper->findConuter() + 1;
                            Util_Utils::createCompteCredit($max_code, 0, $compteur, $user->code_membre, 'Inr', $cfact, $mont_fact, $mont_fact, $date_deb, $date_fin, $source, $num_compte, 'n', 'n', 0, 0, nULL, 1, 'CnPG');

                            $cnp = new Application_Model_EuCnp();
                            $m_cnp = new Application_Model_EuCnpMapper();
                            $cnp->setId_credit($max_code)
                                    ->setDate_cnp($date_deb->toString('yyyy-mm-dd'))
                                    ->setMont_debit($mont_fact)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($mont_fact)
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
                            $id_cnp = $db->lastInsertId();

                            $d_fact->setCode_compte($cfact)
                                    ->setCode_membre($membre->getCode_membre())
                                    ->setCreditcode($sms->getCreditcode())
                                    ->setDate_facturation($date_deb->toString('yyyy-mm-dd'))
                                    ->setMont_facturation($mont_fact)
                                    ->setId_operation($compteur)
                                    ->setId_cnp($id_cnp);
                            $td_fact->insert($d_fact->toArray());
                        }
                        Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $compte->getSolde());
                        $db->commit();
                        $this->view->data = true;
                        return;
                    } else {
                        $db->rollback();
                        $message = "Erreur d'éxécution : Ce code sms $code_sms est invalide ou le motif n'est pas capa!!!";
                        $this->view->data = $message;
                        return;
                    }
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . '=>' . $exc->getTraceAsString();
                $this->view->data = $message;
                return;
            }
        }
    }

    public function soldennAction() {
        $code_membre = $_GET["membre"];
        $type_compte = $_GET["compte"];
        if ($code_membre != '' && $type_compte) {
            $tsms = new Application_Model_DbTable_EuCompte();
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
        }
        $this->view->data = $data;
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
                    if (($membre_benef->getType_membre() == 'p' and $type !== 'RpG') && ($membre_benef->getType_membre() == 'p' and ($type_compte !== 'TpAGCRpG' || $type_compte !== 'tcncs'))) {
                        $db->rollback();
                        $this->view->data = "Les membres Personnes Physiques ne peuvent acheter que le rpg !!!";
                        return;
                    } elseif (($membre_benef->getType_membre() == 'm' and $type == 'rpg') || $membre_benef->getType_membre() == 'm' and ($type_compte == 'TPAGCrpg' || $type_compte == 'tcncs')) {
                        $db->rollback();
                        $this->view->data = 'Les membres Personnes Morales ne peuvent acheter que le (i) investissement ou le (CNCSnr) Salaire !!!';
                        return;
                    } elseif (($membre_benef->getType_membre() == 'm' && $type == 'cncs') && ($membre_benef->getType_membre() == 'm' && ($type_compte == 'tpagci' || $type_compte == 'tpagcp'))) {
                        if ($categorie == 'r') {
                            $db->rollback();
                            $this->view->data = 'Les personnes morales ne peuvent acheter que le (CNCSnr) Salaire non récurrent !!!';
                            return;
                        } elseif ($categorie == 'nr' && ($membre_benef->getCode_type_acteur() != 'ose' || $membre_benef->getCode_type_acteur() != 'Pose')) {
                            $m_acteur = new Application_Model_EuActeurCreneauMapper();
                            $ret_act = $m_acteur->findActeurByMembre($membre_benef->getCode_membre());
                            if ($ret_act == null) {
                                $db->rollback();
                                $this->view->data = 'Cette personne morale n\'est pas un acteur du réseau mcnp!!!';
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

                    //Vérification du solde du nn
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

                        //vérification des quotas
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
                            if (($type == 'rpg' and $categorie == 'r') or ($type == 'i' and $categorie == 'r')) {
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

                            //Mise à jour des comptes credits
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

                            // Mise à jour des capa
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

                                //Mise à jour du fs
                                $cfs = 'nb-tfs-' . $bnp->getCode_membre_app();
                                $compte_fs = new Application_Model_EuCompte();
                                $ret_fs = $cm_mapper->find($cfs, $compte_fs);
                                if ($ret_fs) {
                                    $compte_fs->setSolde($compte_fs->getSolde() + $fs);
                                    $cm_mapper->update($compte_fs);
                                } else {
                                    Util_Utils::createCompte($cfs, 'tfs', 'tfs', $fs, $bnp->getCode_membre_app(), 'nb', $date_deb, 0);
                                }
                                //Mise à jour des comptes credits
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
                                //Mise à jour du cnp
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

                                //Mise à jour de la table fn
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
                                // Création du cncs correspondant au smc
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
                            //Mise à jour des fgfn
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

                        //Mise à jour des comptes généraux
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
                                    $compte_gene->setCode_compte('fgnni');
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

                            //Mise à jour du compte général fgfn
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

                            //Mise à jour du compte général fn
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
                            $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                            $this->view->data = $message;
                            return;
                        }
                        //Mise du compte nn
                        $compte_nn->setSolde($compte_nn->getSolde() - $montant);
                        $cm_mapper->update($compte_nn);
                        //Envoie du sms au membre
                        Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $compte->getSolde());
                    } else {
                        $db->rollback();
                        $message = 'Erreur d\'éxécution : Le solde de votre compte ' . $compte_nn->getCode_compte() . ' est insuffisant pour effectuer cette opération!!!';
                        $this->view->data = $message;
                        return;
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
                    $this->view->message = "Ce membre n'existe pas";
                    return;
                }

                $retour = $m_membre->find($code_memb_benef, $membre_benef);
                if (!$retour) {
                    $db->rollback();
                    $this->view->message = "Ce membre n'existe pas";
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
                            $this->view->data = 'Les personnes morales ne peuvent acheter que le (CNCSnr) Salaire non récurrent !!!';
                            return;
                        } elseif ($categorie == 'nr' && ($membre_benef->getCode_type_acteur() != 'ose' || $membre_benef->getCode_type_acteur() != 'Pose')) {
                            $m_acteur = new Application_Model_EuActeurCreneauMapper();
                            $ret_act = $m_acteur->findActeurByMembre($membre_benef->getCode_membre());
                            if ($ret_act == null) {
                                $db->rollback();
                                $this->view->data = 'Cette personne morale n\'est pas un acteur du réseau mcnp!!!';
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
                        //Vérification du solde du mf
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

                            //vérification des quotas
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
                                if (($type == 'rpg' and $categorie == 'r') or ($type == 'i' and $categorie == 'r')) {
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

                                //Mise à jour des comptes credits
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

                                // Mise à jour des capa
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
                                    //Mise à jour du fs
                                    $cfs = 'nb-tfs-' . $bnp->getCode_membre_app();
                                    $compte_fs = new Application_Model_EuCompte();
                                    $ret_fs = $cm_mapper->find($cfs, $compte_fs);
                                    if ($ret_fs) {
                                        $compte_fs->setSolde($compte_fs->getSolde() + $fs);
                                        $cm_mapper->update($compte_fs);
                                    } else {
                                        Util_Utils::createCompte($cfs, 'tfs', 'tfs', $fs, $bnp->getCode_membre_app(), 'nb', $date_deb, 0);
                                    }

                                    //Mise à jour des comptes credits
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
                                    //Mise à jour du cnp
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

                                    //Mise à jour de la table fn
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
                                    // Création du cncs correspondant au smc
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

                            //Mise à jour des comptes généraux
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

                                //Mise à jour du compte général fgfn
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

                                //Mise à jour du compte général fn
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
                                $message = 'Erreur d\'éxécution : ' . $e->getMessage() . $e->getTraceAsString();
                                $this->view->data = $message;
                                return;
                            }

                            $td_fact = new Application_Model_DbTable_EuDetailFacturation();
                            $d_fact = new Application_Model_EuDetailFacturation();
                            $tx_prestation = Util_Utils::getParametre('cncs', 'capa');
                            $code_membre_fgfn = $user->code_membre;
                            //Vérification de l'origine du code sms et Mise à jour du détail 
                            $compte_transfert = $sms->getFromAccount();
                            $transfert = explode('-', $compte_transfert);
                            $membre_transfert = $transfert[2];
                            $t_acteur = new Application_Model_DbTable_EuActeur();
                            $select = $t_acteur->select();
                            $select->where('code_membre like ?', $membre_transfert)
                                    ->where('code_activite in (?)', array('dsms', 'pbf'));
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
                                                    $det_vtesms = new Application_Model_EuDetailVentesms();
                                                    $tdet_vtesms = new Application_Model_DbTable_EuDetailVentesms();
                                                    $fgfn = new Application_Model_EuFgfn();
                                                    $fgfn_map = new Application_Model_EuFgfnMapper();
                                                    $det_fg = new Application_Model_EuDetailFgfn();
                                                    $fg_mapper = new Application_Model_EuDetailFgfnMapper();
                                                    $det_sms->exchangeArray($value);
                                                    $code_membre_fgfn = $det_sms->getCode_membre();
                                                    if ($det_sms->getSolde_sms() >= $mont_deduire) {
                                                        //Mise à jour des fgfn
                                                        $code_fgfn = 'fgfn-' . $code_membre_fgfn;
                                                        $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                                                        if (!$ret_fg) {
                                                            $fgfn->setCode_fgfn($code_fgfn)
                                                                    ->setCode_membre($code_membre_fgfn)
                                                                    ->setSolde_fgfn($mont_deduire);
                                                            $fgfn_map->save($fgfn);
                                                        } else {
                                                            $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $mont_deduire);
                                                            $fgfn_map->update($fgfn);
                                                        };

                                                        $det_fg->setCode_capa($code_capa)
                                                                ->setCode_membre_pbf($code_membre_fgfn)
                                                                ->setMont_fgfn($mont_deduire)
                                                                ->setDate_fgfn($date_deb->toString('yyyy-mm-dd'))
                                                                ->setMont_preleve(0)
                                                                ->setSolde_fgfn($mont_deduire)
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
                                                                ->setMont_vente($mont_deduire)
                                                                ->setId_utilisateur($user->id_utilisateur)
                                                                ->setCode_produit($code);
                                                        $tdet_vtesms->insert($det_vtesms->toArray());

                                                        $det_sms->setMont_vendu($det_sms->getMont_vendu() + $mont_deduire)
                                                                ->setSolde_sms($det_sms->getSolde_sms() - $mont_deduire);
                                                        $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));

                                                        $mont_deduire = 0;
                                                    } else {
                                                        $mont_deduire -= $det_sms->getSolde_sms();
                                                        //Mise à jour des fgfn
                                                        $code_fgfn = 'fgfn-' . $code_membre_fgfn;
                                                        $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                                                        if (!$ret_fg) {
                                                            $fgfn->setCode_fgfn($code_fgfn)
                                                                    ->setCode_membre($code_membre_fgfn)
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
                                            $this->view->data = "Aucun enregistrement trouvé!!!";
                                            return;
                                        }
                                    } else {
                                        $db->rollback();
                                        $message = 'Erreur d\'éxécution : Votre compte de transfert est insuffisant pour effectuer cet opération';
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
                                    //Mise à jour des fgfn
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
                                $message = "Erreur d\'éxécution : Cet acteur " . $membre_transfert . " n'existe pas. Veuilez contacter le mcnp!";
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
								$id_reg_mf = $db->lastInsertId();

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
                                            $rep_reg->setId_reglt_mf($id_reg_mf)
                                                    ->setId_rep($value->getId_rep())
                                                    ->setMont_rep_reglt($mf_deduire);
                                            $rep_reg_map->save($rep_reg);
                                            break;
                                        } else {
                                            $rep_reg->setId_reglt_mf($id_reg_mf)
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
                                $message = 'Erreur d\'éxécution : Votre compte MF11000 est insuffisant pour effectuer cet opération : ' . $solde_mf;
                                $this->view->data = $message;
                                return;
                            }

                            //Envoie du sms au membre
                            Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $compte->getSolde());
                        } else {
                            $db->rollback();
                            $message = 'Erreur d\'éxécution : Le code sms ' . $code_sms . ' est invalide ou inconnu pour effectuer cette opération!!!';
                            $this->view->data = $message;
                            return;
                        }
                    } else {
                        $db->rollback();
                        $message = 'Erreur d\'éxécution : Le code sms n\'est pas rensiegné!!!';
                        $this->view->data = $message;
                        return;
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

    public function immcapaAction() {
        //action body
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        $type_capa = $request->type;
        $this->view->type = $type_capa;
        if ($this->getRequest()->isPost()) {
            $credi = $request->mont_credit;
            $num_membre = $request->code_membre;
            $type = $request->code_produit;
            $montant = $request->mont_capa;
            $code_dev = $request->dev_capa;
            $code_sms = $request->code_sms;
            $mont_sms = $request->mont_sms;
            $nom_membre = $request->nom_membre;
            $prenom_membre = $request->prenom_membre;
            $type_capa = $request->type;
            $mont_inv = $request->mont_inv;
            $duree_inv = $request->duree_inv;
            $pre = $request->pre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $m_membre = new Application_Model_EuMembreMapper();
                $membre = new Application_Model_EuMembre();
                $retour = $m_membre->find($num_membre, $membre);
                if (!$retour) {
                    $this->view->message = "Ce membre n'existe pas:" . $type_capa;
                    $this->view->code_membre = $num_membre;
                    $this->view->code_produit = $type;
                    $this->view->mont_capa = $montant;
                    $this->mont_credit = $credi;
                    $this->view->dev_capa = $code_dev;
                    $this->view->type = $type_capa;
                    $this->view->mont_inv = $mont_inv;
                    $this->view->pre = $pre;
                    $this->view->code_sms = $code_sms;
                    $this->view->mont_sms = $mont_sms;
                    $this->view->nom_membre = $nom_membre;
                    $this->view->prenom_membre = $prenom_membre;
                    return;
                } else {
                    if ($membre->getType_membre() == 'p' and $type !== 'RpG') {
                        $this->view->message = "Les membres Personnes Physiques ne peuvent acheter que le rpg !!!";
                        $this->view->code_membre = $num_membre;
                        $this->view->code_produit = $type;
                        $this->view->mont_capa = $montant;
                        $this->mont_credit = $credi;
                        $this->view->dev_capa = $code_dev;
                        $this->view->type = $type_capa;
                        $this->view->mont_inv = $mont_inv;
                        $this->view->pre = $pre;
                        $this->view->code_sms = $code_sms;
                        $this->view->mont_sms = $mont_sms;
                        $this->view->nom_membre = $nom_membre;
                        $this->view->prenom_membre = $prenom_membre;
                        return;
                    } elseif ($membre->getType_membre() == 'm' and $type == 'rpg') {
                        $this->view->message = 'Les membres Personnes Morales ne peuvent acheter que le (i) investissement ou le (CNCSnr) Salaire !!!';
                        $this->view->code_membre = $num_membre;
                        $this->view->code_produit = $type;
                        $this->view->mont_capa = $montant;
                        $this->mont_credit = $credi;
                        $this->view->dev_capa = $code_dev;
                        $this->view->type = $type_capa;
                        $this->view->mont_inv = $mont_inv;
                        $this->view->pre = $pre;
                        $this->view->code_sms = $code_sms;
                        $this->view->mont_sms = $mont_sms;
                        $this->view->nom_membre = $nom_membre;
                        $this->view->prenom_membre = $prenom_membre;
                        return;
                    }

                    $prod = new Application_Model_EuProduit();
                    $code = $type . 'nr';
                    $p_mapper = new Application_Model_EuProduitMapper();
                    $p_result = $p_mapper->find($code, $prod);
                    if (!$p_result) {
                        $this->view->message = "Ce produit n'existe pas";
                        $this->view->code_membre = $num_membre;
                        $this->view->code_produit = $type;
                        $this->view->mont_capa = $montant;
                        $this->mont_credit = $credi;
                        $this->view->dev_capa = $code_dev;
                        $this->view->type = $type_capa;
                        $this->view->mont_inv = $mont_inv;
                        $this->view->pre = $pre;
                        $this->view->code_sms = $code_sms;
                        $this->view->mont_sms = $mont_sms;
                        $this->view->nom_membre = $nom_membre;
                        $this->view->prenom_membre = $prenom_membre;
                        return;
                    }
                    $cm_mapper = new Application_Model_EuCompteMapper();
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $sms = $sms_mapper->findByCreditCode($code_sms);
                    if ($sms != null && $sms->getIDDateTimeConsumed() == 0 && $sms->getDestAccount_Consumed() == '') {
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
                                if ($mont_inv != '') {
                                    $mont_inv = $mont_inv * $cours->getVal_dev_fin();
                                }
                            }
                        }
                    }

                    //calcul de la pre et du crédit
                    $prk = Util_Utils::getParametre('prk', 'nr');
                    $pck = Util_Utils::getParametre('pck', 'nr');
                    if ($duree_inv > floor($pck)) {
                        $pre = $duree_inv + ($prk - floor($pck));
                        $credi = round($mont_inv / $pre);
                        $montant = round($credi * $pck);
                        $renouveller = 'o';
                    } else {
                        $credi = $mont_inv;
                        $montant = round(($credi * $pck) / $prk);
                        $renouveller = 'n';
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
                        $lib_op = 'Achat du rpg';
                    } elseif ($type == 'i') {
                        $lib_op = 'Achat d\'Investissement';
                    }
                    Util_Utils::addOperation($compteur, $num_membre, $code_cat, $montant, $code, $lib_op, 'apa', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);

                    //vérification des quotas
                    $mont_place = $montant;
                    if ($mont_place > 0) {
                        $compte = new Application_Model_EuCompte();
                        $result = $cm_mapper->find($num_compte, $compte);
                        if ($result == false) {
                            $type_compte = 'nb';
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
                        if ($type == 'rpg') {
                            $compte_source = 'caparpg';
                        } elseif ($type == 'i') {
                            $compte_source = 'capai';
                        }
                        Util_Utils::createCompteCredit($max_code, 1, $compteur, $num_membre, $code, $num_compte, $credi, $mont_place, $date_deb, $date_fin, $source, $compte_source, 'n', $renouveller, 0, 0, nULL);

                        // Mise à jour des capa
                        $m_capa = new Application_Model_EuCapaMapper();
                        $capa = new Application_Model_EuCapa();
                        $code_capa = 'capa' . $type . $date_deb->toString('yyyyMMddHHmmss');
                        $capa->setCode_capa($code_capa)
                                ->setCode_compte($num_compte)
                                ->setDate_capa($date_deb->toString('yyyy-mm-dd'))
                                ->setHeure_capa($date_deb->toString('hh:mm'))
                                ->setCode_membre($num_membre)
                                ->setMontant_capa($mont_place)
                                ->setType_capa($type)
                                ->setCode_produit($type . 'nr')
                                ->setId_operation($compteur)
                                ->setEtat_capa('Actif')
                                ->setId_credit($max_code);
                        $m_capa->save($capa);

                        $m_capa_affect = new Application_Model_EuCapaAffecterMapper();
                        $capa_affect = new Application_Model_EuCapaAffecter();
                        $capa_affect->setCode_capa($code_capa)
                                ->setDuree_renouvellement($pre)
                                ->setReste_duree($pre)
                                ->setMont_invest(round($mont_inv))
                                ->setId_credit($max_code)
                                ->setType_credit($type);
                        $m_capa_affect->save($capa_affect);

                        //Mise à jour des fgfn
                        $fgfn = new Application_Model_EuFgfn();
                        $fgfn_map = new Application_Model_EuFgfnMapper();
                        $code_fgfn = 'fgfn-' . $user->code_membre;
                        $ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
                        if (!$ret_fg) {
                            $fgfn->setCode_fgfn($code_fgfn)
                                    ->setCode_membre($user->code_membre)
                                    ->setSolde_fgfn($mont_place);
                            $fgfn_map->save($fgfn);
                        } else {
                            $fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $mont_place);
                            $fgfn_map->update($fgfn);
                        }

                        $det_fg = new Application_Model_EuDetailFgfn();
                        $fg_mapper = new Application_Model_EuDetailFgfnMapper();
                        $det_fg->setCode_capa($code_capa)
                                ->setCode_membre_pbf($user->code_membre)
                                ->setMont_fgfn($mont_place)
                                ->setDate_fgfn($date_deb->toString('yyyy-mm-dd'))
                                ->setMont_preleve(0)
                                ->setSolde_fgfn($mont_place)
                                ->setCode_fgfn($code_fgfn)
                                ->setType_capa('capa' . $type);
                        $fg_mapper->save($det_fg);

                        //Mise à jour du cnp
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

                        //Mise à jour de la table fn
                        $fn = new Application_Model_EuFn();
                        $m_fn = new Application_Model_EuFnMapper();
                        $fn->setCode_capa($code_capa)
                                ->setDate_fn($date_deb->toString('yyyy-mm-dd'))
                                ->setType_fn('Inr')
                                ->setMontant($mont_place)
                                ->setSortie(0)
                                ->setEntree(0)
                                ->setSolde(0)
                                ->setMt_solde($mont_place);
                        $m_fn->save($fn);
                    }
                    if ($sms) {
                        $sms->setDestAccount_Consumed($num_compte)
                                ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                        $sms_mapper->update($sms);
                    }
                    if ($result) {
                        Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $compte->getSolde());
                    } else {
                        Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $credi);
                    }
                    $db->commit();
                    $message = "Opération effectuée avec succès !!!";
                    $this->view->message = $message;
                    //return $this->_helper->redirector('index');
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
                $this->view->code_membre = $num_membre;
                $this->view->code_produit = $type;
                $this->view->mont_capa = $montant;
                $this->mont_credit = $credi;
                $this->view->dev_capa = $code_dev;
                $this->view->type = $type_capa;
                $this->view->mont_inv = $mont_inv;
                $this->view->pre = $pre;
                $this->view->code_sms = $code_sms;
                $this->view->mont_sms = $mont_sms;
                $this->view->nom_membre = $nom_membre;
                $this->view->prenom_membre = $prenom_membre;
                return;
            }
        }
    }

}

