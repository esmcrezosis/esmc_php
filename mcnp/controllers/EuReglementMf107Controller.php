<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuReglementMf107Controller extends Zend_Controller_Action {

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"detail\" href=\"/eu-reglement-mf107/reglement\">Règlement</a></li>" .
                "<li><a id=\"detail\" href=\"/eu-reglement-mf107/listreglt\">Liste des règlements</a></li>";
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

    public function indexAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    public function listingregltAction() {

        $date_deb = $_GET["date_deb"];
        $date_fin = $_GET["date_fin"];
        $code_membre = $_GET["code_membre"];

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", '200000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuReglementMf();
        $select = $tabela->select();
        $select->where('eu_reglement_mf.id_utilisateur = ?', $user->id_utilisateur)
                ->where('eu_reglement_mf.type_mf = ?', 'MF107')
                //->where('eu_reglement_mf.date_reglt_mf = ?',$date_idd->toString('yyyy-mm-dd'))  
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
                $row->mont_reglt_mf,
                $row->date_reglt_mf,
                $row->code_membre
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", '200000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuReglementMf();
        $select = $tabela->select();
        $select->where('eu_reglement_mf.id_utilisateur = ?', $user->id_utilisateur)
                ->where('eu_reglement_mf.date_reglt_mf = ?', $date_idd->toString('yyyy-mm-dd'))
                ->order('eu_reglement_mf.id_reglt_mf  desc');

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
                $row->mont_reglt_mf,
                $row->date_reglt_mf,
                $row->code_membre
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function reglementAction() {
        
    }

    public function listregltAction() {
        
    }

    public function datadmfAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $membre = $this->getRequest()->membre;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_mf107');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuMembre();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_repartition_mf107', 'eu_repartition_mf107.code_membre = eu_membre.code_membre')
               ->where('eu_repartition_mf107.code_membre =?', $membre)
               ->where('eu_repartition_mf107.payer =?', 0);
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
        foreach ($agences as $row) {
            $responce['rows'][$i]['id'] = $row->id_rep;
            $responce['rows'][$i]['cell'] = array(
			    $row->nom_membre." ".$row->prenom_membre,
                $row->mont_rep,
				$row->mont_rep,
                $row->date_rep,
                $row->id_rep,
                $row->code_membre
            );
            $i++;
        }
        $this->view->data = $responce;
    }

	
    public function payerAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;
        $selection = array();
        $selection = $_GET['lignes'];
        $mt_transfert = $_GET['mt_transfert'];

        //$det_mf = new Application_Model_EuDetailMf107();
        // $det_mapper = new Application_Model_EuDetailMf107Mapper();

        $reglt_mf = new Application_Model_EuReglementMf();
        $reglt_mapper = new Application_Model_EuReglementMfMapper();

        $membre = new Application_Model_EuMembre;
        $membre_mapper = new Application_Model_EuMembreMapper();
        
		$compte = new Application_Model_EuCompte();
        $mcompte = new Application_Model_EuCompteMapper();
        $dsmsmoney = new Application_Model_EuDetailSmsmoney();
        $mdsmsmoney = new Application_Model_EuDetailSmsmoneyMapper();
		
		$rep = new Application_Model_EuRepartitionMf107();
        $repm = new Application_Model_EuRepartitionMf107Mapper();
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
                    if ($sel['mont_recu'] < $sel['mont_rachat']) {
                        $db->rollback();
                        $this->view->data = 'rachat';
                        return;
                    }
                    $code_membre = $sel['code_membre'];
                    $cumul_reglt+=$sel['mont_rachat'];
                }
				//Enregistrement dans la table eu_reglement_mf
                $reglt_mf->setMont_reglt_mf($cumul_reglt);
                $reglt_mf->setCode_membre($code_membre);
                $reglt_mf->setDate_reglt_mf($date_idd->toString('yyyy-mm-dd'));
                $reglt_mf->setId_utilisateur($user->id_utilisateur);
                $reglt_mf->setType_mf('MF107');
				$reglt_mf->setType_reglt_mf('Dépôt vente');
                $reglt_mapper->save($reglt_mf);

                $maxreglt = $reglt_mapper->findMaxReglt();
				
                foreach ($selection as $sel) {
				
                    //$id_rep = $sel['id_rep'];
                    //$query = "update eu_repartition_mf107  set  payer =(1),id_reglt_mf=$maxreglt  where id_rep='$id_rep'";
                    //$db->query($query);
					
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
					
					//Mise à jour des comptes de transfert des MF107
                    $code_compte_mf = 'nn-tr-' . $sel['code_membre'];
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
					$dsmsmoney
                            ->setNum_bon(null)
                            ->setCode_membre($code_membre)
                            ->setDate_allocation($date_idd->toString('yyyy-mm-dd'))
                            ->setId_utilisateur($user->id_utilisateur)
                            ->setCode_membre_dist($user->code_membre)
                            ->setCreditcode(null)
                            ->setMont_sms($sel['mont_reglt'])
                            ->setMont_vendu(0)
                            ->setSolde_sms($sel['mont_reglt'])
                            ->setOrigine_sms('MF107');
                    $mdsmsmoney->save($dsmsmoney);	
                }

                $resp = $membre_mapper->find($code_membre, $membre);
                if ($resp) {

                    Util_Utils::addSms($membre->getPortable_membre(), "Votre compte de transfert membre fondateur 107 a été débité d\'un montant de  " ." ".$mt_transfert);
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

    public function membreAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

}

?>
