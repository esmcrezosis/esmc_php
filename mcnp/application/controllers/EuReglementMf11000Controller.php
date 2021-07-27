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
class EuReglementMf11000Controller extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'mf' || $group == 'mf_bank') {
            $menu = "<li><a href=\"/eu-reglement-mf11000/reglement\">Règlement</a></li>" .
                    "<li><a href=\"/eu-reglement-mf11000/listreglt\">Liste des règlements</a></li>" .
                    "<li><a href=\"/eu-reglement-mf11000/detail\">Détails</a></li>";
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
            if ($group != 'mf' && $group != 'mf_bank') {
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

    public function reglementAction() {
        
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

    public function listingregltAction() {
        $date_deb = $_GET["date_deb"];
        $date_fin = $_GET["date_fin"];
        $code_membre = $_GET["code_membre"];
        $num_bon = $_GET["num_bon"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", '200000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuReglementMf();
        $select = $tabela->select();
        $select->where('eu_reglement_mf.id_utilisateur = ?', $user->id_utilisateur)
                ->where('eu_reglement_mf.type_mf = ?', 'MF11000')
                ->order('eu_reglement_mf.id_reglt_mf  desc');
        if ($date_deb == '' and $date_fin == '') {
            $datedeb = '%';
            $select->where('eu_reglement_mf.date_reglt_mf like ?', $datedeb);
        } else if ($date_deb == '') {
            $date2 = explode("/", $date_fin);
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('eu_reglement_mf.date_reglt_mf <= ?', $datefin);
        } else if ($date_fin == '') {
            $date1 = explode("/", $date_deb);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('eu_reglement_mf.date_reglt_mf >= ?', $datedeb);
        } else {
            $date1 = explode("/", $date_deb);
            $date2 = explode("/", $date_fin);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('eu_reglement_mf.date_reglt_mf >= ?', $datedeb);
            $select->where('eu_reglement_mf.date_reglt_mf <= ?', $datefin);
        }
        if ($code_membre == '') {
            $select->where('eu_reglement_mf.code_membre like ?', '%');
        } else {
            $select->where('eu_reglement_mf.code_membre like ?', $code_membre);
        }
        if ($num_bon == '') {
            $select->where('eu_reglement_mf.code_membre like ?', '%');
        } else {
            $select->where('eu_reglement_mf.code_membre  like ?', $num_bon . '%');
        }
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
            $responce['rows'][$i]['id'] = $row->id_reglt_mf;
            $responce['rows'][$i]['cell'] = array(
                $row->id_reglt_mf,
                $row->code_membre,
                $row->date_reglt_mf,
                $row->mont_reglt_mf
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

}

?>
