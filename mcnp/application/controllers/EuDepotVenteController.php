<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDepotVenteController
 *
 * @author user
 */
class EuDepotVenteController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $menu = '';
        if ($user->code_groupe == 'agregat' || $user->code_groupe == 'apa' || $user->code_groupe == 'banque') {
            $menu = '<li><a href="/eu-depot-vente/gcp">Achat de GCp</a></li>
                <li><a href="/eu-depot-vente/depot">Dépot vente de GCp</a></li>
                <li><a href="/eu-depot-vente/regdepot">Règlement Dépot vente</a></li>';
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
            if ($group != 'agregat' && $group != 'apa' && $group != 'banque') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function membreAction() {
        $request = $this->getRequest();
        $type = $request->type;
        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAllByType($type);
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

    public function tpagcpAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_tpagcp');
        $sord = $this->_request->getParam("sord", 'asc');
        $membre = $this->_request->getParam("membre");
        $compte = 'nb-tpagcp-' . $membre;
        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select();
        $select->where('code_compte like ?', $compte)
                ->where('solde > ?', 0)
                ->order('solde', 'asc');
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
            $date_deb = new Zend_Date($row->date_deb, Zend_Date::ISO_8601);
            $date_fin = new Zend_Date($row->date_fin, Zend_Date::ISO_8601);
            $date_deb_tranche = new Zend_Date($row->date_deb_tranche, Zend_Date::ISO_8601);
            $date_fin_tranche = new Zend_Date($row->date_fin_tranche, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_tpagcp;
            $responce['rows'][$i]['cell'] = array(
                $row->id_tpagcp,
                $row->code_compte,
                $row->code_membre,
                $row->mont_gcp,
                $row->reste_ntf,
                $row->mont_tranche,
                $row->mont_echu,
                $row->solde,
                $date_deb->toString('dd/mm/yyyy'),
                $date_fin->toString('dd/mm/yyyy'),
                $date_deb_tranche->toString('dd/mm/yyyy'),
                $date_fin_tranche->toString('dd/mm/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }
    
    public function smsAction() {
        $code = $_GET["code"];
        if ($code != '') {
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('creditcode like ?', $code)
                    ->where('destaccount_consumed = ?', '');
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $data[0] = $results->current()->CreditAmount;
                $data[1] = $results->current()->CurrencyCode;
            } else {
                $data[0] = 0;
                $data[1] = $code;
            }
        }
        $this->view->data = $data;
    }
    
    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_achat');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuAchatCredit();
        $date_deb = Zend_Date::now();
        $select = $tabela->select();
        $select->where('id_utilisateur like ?', $user->id_utilisateur)
                ->where('date_achat = ?', $date_deb->toString('yyyy-mm-dd'))
                ->order('date_achat', 'asc');
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
            $date_achat = new Zend_Date($row->date_achat, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_achat;
            $responce['rows'][$i]['cell'] = array(
                $row->id_achat,
                $date_achat->toString('dd/mm/yyyy'),
                $row->code_membre_acheteur,
                $row->code_membre_vendeur,
                $row->mont_achat,
                $row->id_tpagcp,
                $row->credit_obt
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function gcpAction() {
        
    }

    public function gcpmatAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            $membre = $request->membre;
            $type_compte = $request->compte;
            $montant = $request->montant;
            $tpagcps = $request->tpagcp;
            $compte_dest = $request->compte_obt;
            $code_sms = $request->code_sms;
            $type_sms = $request->type_sms;

            $compte = '';
            $cpte_map = new Application_Model_EuCompteMapper();
            $cpte_origine = new Application_Model_EuCompte();
            $compte = 'NB-TPA' . $type_compte . '-' . $membre;
            $compte_ach = 'NB-TPA' . $type_compte . '-' . $user->code_membre;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $res = $cpte_map->find($compte, $cpte_origine);
                if ($res) {
                    $tpamapper = new Application_Model_EuTpagcpMapper();
                    $som_echu = $tpamapper->findSommeTpaGcp($tpagcps);
                    if ($som_echu > 0 && $som_echu >= $montant) {
                        $code_membre = $membre;
                        if ($compte_dest == 'SMS') {
                            $newcompte = 'NN-TR-' . $code_membre;
                            $code_cat = 'TR';
                        } else {
                            $newcompte = 'NN-TPA' . $type_compte . '-' . $code_membre;
                            $code_cat = 'TPA' . $type_compte;
                        }

                        //Creation du compte de destination de l'échange
                        $date = Zend_Date::now();
                        $ccompte = new Application_Model_EuCompte();
                        $result = $cpte_map->find($newcompte, $ccompte);
                        if ($result == false) {
                            $ccompte->setCode_membre($code_membre)
                                    ->setCode_cat($code_cat)
                                    ->setSolde($montant)
                                    ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                    ->setCode_compte($newcompte)
                                    ->setLib_compte($code_cat)
                                    ->setDesactiver(0);
                            $cpte_map->save($ccompte);
                        } else {
                            $ccompte->setSolde($ccompte->getSolde() + $montant);
                            $cpte_map->update($ccompte);
                        }
                        
                        //Mise à jour du compte de l'acheteur 
                        $cpte = new Application_Model_EuCompte();
                        $res_d = $cpte_map->find($compte_ach, $cpte);
                        if ($res_d == false) {
                            $cpte->setCode_membre($code_membre)
                                 ->setCode_cat($code_cat)
                                 ->setSolde($montant)
                                 ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                 ->setCode_compte($compte_ach)
                                 ->setLib_compte($code_cat)
                                 ->setDesactiver(0);
                            $cpte_map->save($cpte);
                        } else {
                            $ccompte->setSolde($cpte->getSolde() + $montant);
                            $cpte_map->update($cpte);
                        }

                        $mapper = new Application_Model_EuOperationMapper();
                        $compteur = $mapper->findConuter() + 1;
                        Util_Utils::addOperation($compteur, $code_membre, $code_cat, $montant, $compte_dest, 'Achat du gcp contre ' . $compte_dest, 'Agcp', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);

                        if ($compte_dest == 'SMS') {
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
                                           ->where('code_activite like ?', 'PBF');
                                    $acteurs = $tab_acteur->fetchAll($select);
                                    if (count($acteurs) == 0) {
                                        $db->rollback();
                                        $this->view->message = 'Le Code sms est invalide ou n\'est pas vendu par un pbf !!!';
                                        return;
                                    }
                                    $montant = $sms->getCreditAmount();
                                    $code_dev = $sms->getCurrencyCode();
                                    if ($code_dev != 'XOF') {
                                        $code_cours = $code_dev . '-XOF';
                                        $cours = new Application_Model_EuCours();
                                        $m_cours = new Application_Model_EuCoursMapper();
                                        $ret = $m_cours->find($code_cours, $cours);
                                        if ($ret) {
                                            if ($montant != '') {
                                                $montant = $montant * $cours->getVal_dev_fin();
                                            }
                                        }
                                    }
                                    //Recherche de l'acteur et Création du détail sms money
                                    $code_activite = array("pbf", "dsms");
                                    $act_select = $tab_acteur->select();
                                    $act_select->where('code_membre like ?', $code_membre)
                                            ->where('code_activite in (?)', $code_activite);
                                    $acteur = $tab_acteur->fetchAll($act_select);
                                    if (count($acteur) > 0) {
                                        $acteur = $acteur->current();
                                        if ($acteur->code_activite == 'DSMS') {
                                            $compte_transfert = $sms->getFromAccount();
                                            $transfert = explode('-', $compte_transfert);
                                            $membre_transfert = $transfert[2];
                                            $tab_det_sms = new Application_Model_DbTable_EuDetailSmsmoney();
                                            $det_sms = new Application_Model_EuDetailSmsmoney();
                                            $det_sms->setCode_membre_dist($code_membre)
                                                    ->setCode_membre($membre_transfert)
                                                    ->setCreditcode($sms->getCreditCode())
                                                    ->setMont_sms($sms->getCreditAmount())
                                                    ->setDate_allocation($date->toString('yyyy-mm-dd'))
                                                    ->setMont_vendu(0)
                                                    ->setId_utilisateur($user->id_utilisateur)
                                                    ->setSolde_sms($sms->getCreditAmount())
                                                    ->setOrigine_sms($type_sms);
                                            $tab_det_sms->insert($det_sms->toArray());
                                        }
                                    }
                                } else {
                                    $db->rollback();
                                    $this->view->message = 'Le Code sms est invalide ou n\'est pas renseigné !!!';
                                    return;
                                }
                            }
                        }
                        
                        $tpagcp = new Application_Model_EuTpagcp();
                        $achat_cred = new Application_Model_EuAchatCredit();
                        $t_achat_cred = new Application_Model_DbTable_EuAchatCredit();
                        for ($i = 0; $i < count($tpagcps); $i++) {
                            $res = $tpamapper->find($tpagcps[$i], $tpagcp);
                            if ($res) {
                                $mont_deduire = $tpagcp->getSolde();
                                $achat_cred->setCode_membre_acheteur($user->code_membre)
                                        ->setCode_membre_vendeur($code_membre)
                                        ->setDate_achat($date->toString('yyyy-mm-dd'))
                                        ->setCredit_obt($compte_dest)
                                        ->setId_tpagcp($tpagcp->getId_tpagcp())
                                        ->setCode_sms($code_sms)
                                        ->setId_utilisateur($user->id_utilisateur)
                                        ->setMont_achat($mont_deduire);
                                $t_achat_cred->insert($achat_cred->toArray());
                                
                                $tpagcp->setCode_membre($user->code_membre)
                                        ->setCode_compte($compte_ach);
                                $tpamapper->update($tpagcp);
                            }
                        }
                        $db->commit();
                        $this->view->message = 'succes';
                        return;
                    } else {
                        $db->rollback();
                        $message = "Erreur d'éxécution : La somme des gcp echues n'est pas suffisant pour effectuer cette opération ";
                        $this->view->message = $message;
                        return;
                    }
                } else {
                    $db->rollback();
                    $message = "Erreur d'éxécution : Le compte " . $compte . " est invalide pour effectuer cette opération ";
                    $this->view->message = $message;
                    return;
                }
            } catch (Exception $e) {
                $db->rollback();
                $message = 'Erreur d\'éxécution : ' . ' Trace -> :' . $e->getMessage();
                $this->view->message = $message;
                return;
            }
        }
    }

}

?>
