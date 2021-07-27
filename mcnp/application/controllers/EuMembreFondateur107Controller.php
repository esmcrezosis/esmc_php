<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuMembreFondateur107Controller extends Zend_Controller_Action {

//put your code here
    public function init() {
      $this->view->jQuery()->enable();
      $this->view->jQuery()->uiEnable();
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $user = $auth->getIdentity();
      $group = $user->code_groupe;
      if ($group == 'cm' || $group == 'mf') {
            $menu = "<li><a id=\"detail\" href=\"/eu-membre-fondateur107/crediter\" style=\"font-size:11px\">Créditer un compte</a></li>" .
                    "<li><a id=\"detail\" href=\"/eu-membre-fondateur107/detailmf107\" style=\"font-size:11px\">Détail compte MF107</a></li>";
        } elseif ($group == 'mf_rep') {
            $menu = "<li><a id=\"detail\" href=\"/eu-membre-fondateur107/index\" style=\"font-size:11px\">Liste MF107</a></li>" .
            "<li><a id=\"detail\" href=\"/eu-membre-fondateur107/repartition\" style=\"font-size:11px\">Répartition</a></li>" .
                    "<li><a id=\"detail\" href=\"/eu-membre-fondateur107/detailrep\" style=\"font-size:11px\">Détail répartition</a></li>";
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
            if ($group != 'cm' && $group != 'mf' && $group != 'mf_rep') {
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

    public function detailmf107Action() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    public function listregltAction() {
        
    }

    public function domicilierAction() {
        
    }

	
    public function listingregltAction() {

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

    public function detailrepAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    public function detailAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    public function mfdetailAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;
		if(isset($this->getRequest()->code_membre)){
          $code_membre = $this->getRequest()->code_membre;
		}
		else {
		  $code_membre = '';
		}
		$date_placement = $this->getRequest()->date_placement;
		if($date_placement != '') {
          $date1 = explode("-",$this->getRequest()->date_placement);
          $date_placement = $date1[2] . '-' . $date1[1] . '-' . $date1[0]; 
		}
		else {
		  $date_placement = '';
		} 
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100000);
        $sidx = $this->_request->getParam("sidx", '200000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuDetailMf107();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		
		if($code_membre!=''  &&  $date_placement !='') {
        $select->setIntegrityCheck(false)
               ->join('eu_membre', 'eu_membre.code_membre = EU_DETAIL_MF107.code_membre')
               ->where('EU_DETAIL_MF107.id_utilisateur = ?', $user->id_utilisateur)
               // ->where('eu_detail_mf107.date_mf107 = ?', $date_idd->toString('yyyy-mm-dd'))
	           ->where('EU_DETAIL_MF107.code_membre = ?',$code_membre)
               ->where('EU_DETAIL_MF107.DATE_MF107 = ?',$date_placement)
               ->order('EU_DETAIL_MF107.ID_MF107 desc');
		}
	else if ($code_membre!=''){
	$select->setIntegrityCheck(false)
               ->join('eu_membre', 'eu_membre.code_membre = EU_DETAIL_MF107.code_membre')
               ->where('EU_DETAIL_MF107.id_utilisateur = ?', $user->id_utilisateur)
               // ->where('eu_detail_mf107.date_mf107 = ?', $date_idd->toString('yyyy-mm-dd'))
	           ->where('EU_DETAIL_MF107.code_membre = ?',$code_membre)
               ->order('EU_DETAIL_MF107.ID_MF107 desc');
	}
        else if ($date_placement!=''){
	$select->setIntegrityCheck(false)
               ->join('eu_membre', 'eu_membre.code_membre = EU_DETAIL_MF107.code_membre')
               ->where('EU_DETAIL_MF107.id_utilisateur = ?', $user->id_utilisateur)
               // ->where('eu_detail_mf107.date_mf107 = ?', $date_idd->toString('yyyy-mm-dd'))
	       ->where('EU_DETAIL_MF107.DATE_MF107 = ?',$date_placement)
               ->order('EU_DETAIL_MF107.ID_MF107 desc');
		}
	else {
        $select->setIntegrityCheck(false)
               ->join('eu_membre', 'eu_membre.code_membre = EU_DETAIL_MF107.code_membre')
               ->where('EU_DETAIL_MF107.id_utilisateur = ?', $user->id_utilisateur)
               // ->where('eu_detail_mf107.date_mf107 = ?', $date_idd->toString('yyyy-mm-dd'))
               ->order('EU_DETAIL_MF107.ID_MF107 desc');
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
            $responce['rows'][$i]['id'] = $row->ID_MF107;
            $responce['rows'][$i]['cell'] = array(
	        $row->ID_MF107,
               $row->code_membre,
               $row->nom_membre,
               $row->prenom_membre,
               $row->mont_apport,
               $row->numident,
               $row->pourcentage
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function mfdetailrepAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", '200000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuRepartitionMf107();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_membre', 'eu_membre.code_membre = EU_REPARTITION_MF107.code_membre')
//->join('eu_detail_mf107', 'eu_detail_mf107.id_mf107 = eu_repartition_mf107.id_mf107') 
                ->where('EU_REPARTITION_MF107.id_utilisateur = ?', $user->id_utilisateur)
                ->where('EU_REPARTITION_MF107.date_rep = ?', $date_idd->toString('yyyy-mm-dd'))
                ->order('EU_REPARTITION_MF107.id_rep desc');

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
            $responce['rows'][$i]['id'] = $row->ID_MF107;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $row->nom_membre,
                $row->prenom_membre,
                $row->mont_rep
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function datarepartitionAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        $tranche = $this->getRequest()->tranche;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", '200000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuMembreFondateur107();
        $select = $tabela->select();
        if ($tranche == 1) {
            $select->where('EU_MEMBRE_FONDATEUR107.nb_repartition <= ?', $tranche);
            $select->where('EU_MEMBRE_FONDATEUR107.solde > ?', 0);
        } else {
            $select->where('EU_MEMBRE_FONDATEUR107.nb_repartition = ?', $tranche);
            $select->where('EU_MEMBRE_FONDATEUR107.solde > ?', 0);
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
        foreach ($agences as $row) {
            $responce['rows'][$i]['id'] = $row->code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                $row->nom,
                $row->prenom,
                $row->sSOLDE,
                $row->numident
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    
    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $numero = $request->numero;
        $nom = $request->nom;
        $prenom = $request->prenom;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'numident');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuMembreFondateur107();
        $select = $tabela->select();
	    $select->order('nom asc');
	    $select->order('prenom asc');
        if ($numero != "") {
            $select->where('numident like ?', '%' . $numero . '%');
        } else if ($nom != "") {
            $select->where('nom like ?', '%' . $nom . '%');
        } else if ($prenom != "") {
            $select->where('prenom like ?', '%' . $prenom . '%');
        } else if ($nom != "" && $prenom != "") {
            $select->where('nom like ?', '%' . $nom . '%');
            $select->where('prenom like ?', '%' . $prenom . '%');
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
		$total=0;
        foreach ($agences as $row) {
	    $total+=$row->solde;
            $responce['rows'][$i]['id'] = $row->numident;
            $responce['rows'][$i]['cell'] = array(
              $row->numident,
              stripslashes (html_entity_decode($row->nom)),
              stripslashes (html_entity_decode($row->prenom)),
              $row->code_membre,
              $row->tel,
              $row->cel,
              $row->nb_repartition-1,
			  //$row->solde 
            );
            $i++;
        }
	$responce['userdata']['code_membre'] = 'Total:';
        $responce['userdata']['total'] = $total;
        $this->view->data = $responce;
    }

    public function newAction() {

        //$this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        //insertion dans la table membre_fondateur107 des informations
        if ($this->getRequest()->isPost()) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $membre = new Application_Model_EuMembreFondateur107();
                $mapper = new Application_Model_EuMembreFondateur107Mapper();

                $detail_mf = new Application_Model_EuDetailMf107();
                $detail_mapper = new Application_Model_EuDetailMf107Mapper();

                $numero = $_POST['numero'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $tel = $_POST['tel'];
                $cel = $_POST['cel'];
                $code_membre = $_POST['code_membre'];
                $code_dev = $_POST['dev_apport'];
                $montant = $_POST['mont_apport'];

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
                 //$ret_mf = $mapper->find($numero, $membre);
                $membre->setNumident($numero);
                $membre->setNom($nom);
                $membre->setPrenom($prenom);
                $membre->setTel($tel);
                $membre->setCel($cel);
                if ($_POST['code_membre'] != '')
                    $membre->setCode_membre($code_membre);
                else
                $membre->setCode_membre(null);
                $membre->setSolde($montant);
                $membre->setNb_repartition(1);
                $membre->setId_utilisateur($user->id_utilisateur);
                $mapper->save($membre);

                $detail_mf = new Application_Model_EuDetailMf107();
                $detail_mapper = new Application_Model_EuDetailMf107Mapper();

                $detail_mf->setNumident($numero);

                if ($_POST['code_membre'] != '')
                    $detail_mf->setCode_membre($code_membre);
                else
                    $detail_mf->setCode_membre(null);

                $detail_mf->setDate_mf107($date_idd->toString('yyyy-mm-dd'));
                $detail_mf->setMont_apport($montant);
                $detail_mf->setId_utilisateur($user->id_utilisateur);
                $detail_mf->setPourcentage(100);
                $detail_mf->setProprietaire(1);
                $detail_mapper->save($detail_mf);

                $query = "update eu_compte_general  set solde =(solde + $montant)  where code_compte='MF107' and code_type_compte='nn' and service='e'";
                $db->query($query);

                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->numero = $_POST["numero"];
                $this->view->nom = $_POST["nom"];
                $this->view->prenom = $_POST["prenom"];
                $this->view->tel = $_POST["tel"];
                $this->view->cel = $_POST["cel"];
                $this->view->code_membre = $_POST["code_membre"];
                $this->view->mont_apport = $_POST["mont_apport"];
                $this->view->dev_apport = $_POST["dev_apport"];
//$message = 'Impossible d\'enrégistrer les données';
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
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

        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                foreach ($selection as $sel) {
                    $code_membre = $sel['code_membre'];
                }
                $reglt_mf->setMont_reglt_mf($mt_transfert);
                $reglt_mf->setCode_membre($code_membre);
                $reglt_mf->setDate_reglt_mf($date_idd->toString('yyyy-mm-dd'));
                $reglt_mf->setId_utilisateur($user->id_utilisateur);
                $reglt_mf->setType_mf('MF107');
                $reglt_mapper->save($reglt_mf);

                $maxreglt = $reglt_mapper->findMaxReglt();
                foreach ($selection as $sel) {
                    $id_rep = $sel['id_rep'];
                    $query = "update eu_repartition_mf107  set  payer =(1),id_reglt_mf=$maxreglt  where id_rep='$id_rep'";
                    $db->query($query);
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






    public function accorderAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $mt_transfert = $_GET['mt_transfert'];
        //$mf = new Application_Model_EuMembreFondateur11000();
        //$mmf = new Application_Model_EuMembreFondateur11000Mapper();
        //$dmf = new Application_Model_EuDetailMf11000();

        $mdmf = new Application_Model_EuDetailMf107Mapper();
        $dom = new Application_Model_EuDomicilieMf107();
        $mdom = new Application_Model_EuDomicilieMf107Mapper();

        //$dod = new Application_Model_EuDetailDomicilieMf11000();
        $mdod = new Application_Model_EuDetailDomicilieMf107Mapper();
        $rep = new Application_Model_EuRepartitionMf107();
        $mrep = new Application_Model_EuRepartitionMf107Mapper();

        $membre = new Application_Model_EuMembre;
        $membre_mapper = new Application_Model_EuMembreMapper();
        
		$m_compte = new Application_Model_EuCompteMapper();
        $compte = new Application_Model_EuCompte();

        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                //Récupération du montant sur le compte général MF11000
                $solde = 0;
                $requete = "select * from eu_compte_general where  code_compte='MF107' and code_type_compte='nn' and service='e'";
                $db->setFetchMode(Zend_Db::fetch_obj);
                $enreg = $db->fetchAll($requete);
                foreach ($enreg as $resp) {
                    $solde = $resp->solde;
                }
                if ($solde < $mt_transfert) {
                    $this->view->data = 'soldevide';
                    return;
                } else {
                    //Mise à jour du compte général
                    $query = "update eu_compte_general  set solde =(solde - $mt_transfert)  where code_compte='MF107' and code_type_compte='nn' and service='e'";
                    $db->query($query);
                    foreach ($selection as $sel) {
                        //Récupération de tous les placements effectués sur un compte MF107
                        $findmf = $mdmf->fetchAllByMf($sel['numident']);
                        if ($findmf != null) {
                            $nb_ddomi = count($findmf);
                            for ($j = 0; $j <= $nb_ddomi - 1; $j++) {
                                $mont = 0;
                                $montant_recu = 0;
                                $res_mf = $findmf[$j];
                                $mont = ($res_mf->getMont_apport() * $res_mf->getPourcentage()) / 100;
                                $montant_recu = $res_mf->getMont_apport() - $mont;

                                //Recherche des placements qui ont servi à une domiciliation
                                $id_mf107 = $res_mf->getId_mf107();
                                $code_proprio = $sel['code_membre'];
                                $code_apporteur = $res_mf->getCode_membre();
                                $find_dod = $mdod->findById_mf107($id_mf107);
                                if ($find_dod == false) {
								        //Cas des placements qui ne sont liés à aucune domiciliation
                                    if ($code_proprio != $code_apporteur) {
									    //Placement apporteur
                                        //Création de la part de l'apporteur
                                        if ($montant_recu > 0) {
                                            $rep->setId_mf107($id_mf107);
                                            $rep->setCode_membre($code_apporteur);
                                            $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                            $rep->setMont_rep($montant_recu);
                                            $rep->setId_utilisateur($user->id_utilisateur);
                                            $rep->setMont_reglt(0);
					    $rep->setSolde_rep($montant_recu);
                                            $rep->setPayer(0);
                                            $mrep->save($rep);

                                            $resp = $membre_mapper->find($code_apporteur, $membre);
                                            if ($resp) {
                                                Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $montant_recu . " sur le compte marchand " . $code_apporteur);
                                            }
											
									//Création ou mise à jour du compte nn de transfert de l'apporteur 
                                        $code_compte = 'nn-tr-' . $code_apporteur;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                    ->setCode_membre($code_apporteur)
                                                    ->setCode_compte($code_compte)
                                                    ->setCode_type_compte('nn')
                                                    ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                    ->setDesactiver(0)
                                                    ->setLib_compte('Compte de recharge')
                                                    ->setSolde($montant_recu);
                                            $m_compte->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $montant_recu);
                                            $m_compte->update($compte);
                                        }
											
											
                                        }
//Création de la part du propriétaire du compte MF107
                                        if ($mont > 0) {
                                            $rep->setId_mf107($id_mf107);
                                            $rep->setCode_membre($code_proprio);
                                            $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                            $rep->setMont_rep($mont);
                                            $rep->setId_utilisateur($user->id_utilisateur);
                                            $rep->setMont_reglt(0);
					    $rep->setSolde_rep($mont);
                                            $rep->setPayer(0);
                                            $mrep->save($rep);

                                            $resp = $membre_mapper->find($code_proprio, $membre);
                                            if ($resp) {
                                                Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $mont . " sur le compte marchand " . $code_proprio);
                                            }
											
									//Création ou mise à jour du compte nn de transfert du propriétaire du compte MF107
                                        $code_compte = 'nn-tr-' . $code_proprio;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                   ->setCode_membre($code_proprio)
                                                   ->setCode_compte($code_compte)
                                                   ->setCode_type_compte('nn')
                                                   ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte('Compte de recharge')
                                                   ->setSolde($mont);
                                            $m_compte->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $mont);
                                            $m_compte->update($compte);
                                        }
											
											
											
                                        }
                                    } else {
//Placement propriétaire
                                        if ($res_mf->getMont_apport() > 0) {
                                            $rep->setId_mf107($id_mf107);
                                            $rep->setCode_membre($code_proprio);
                                            $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                            $rep->setMont_rep($res_mf->getMont_apport());
                                            $rep->setId_utilisateur($user->id_utilisateur);
                                            $rep->setMont_reglt(0);
					    $rep->setSolde_rep($res_mf->getMont_apport());
                                            $rep->setPayer(0);
                                            $mrep->save($rep);

                                            $resp = $membre_mapper->find($code_proprio, $membre);
                                            if ($resp) {
                                                Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $res_mf->getMont_apport() . " sur le compte marchand " . $code_proprio);
                                            }
											
										//Création ou mise à jour du compte nn du propriétaire du compte MF107
                                        $code_compte = 'nn-tr-' . $code_proprio;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                   ->setCode_membre($code_proprio)
                                                   ->setCode_compte($code_compte)
                                                   ->setCode_type_compte('nn')
                                                   ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte('Compte de recharge')
                                                   ->setSolde($res_mf->getMont_apport());
                                            $m_compte->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $res_mf->getMont_apport());
                                            $m_compte->update($compte);
                                        }
											
											
                                        }
                                    }
                                } else {
//Cas des placements qui sont liés à aucune domiciliation
                                    $nb_dom = count($find_dod);
                                    $sum = 0;
                                    for ($i = 0; $i <= $nb_dom - 1; $i++) {
                                        $res_dod = $find_dod[$i];
                                        $ret_dom = $mdom->find($res_dod->getId_dom(), $dom);
                                        if ($ret_dom) {
                                            if ($dom->getEtat_domiciliation() != 1) {
                                                $mt_adomi = $dom->getMt_domiciliation();
                                                $mt_domi = $dom->getMt_domicilie();
                                                $new_domi = $mt_domi + $res_dod->getMt_domi_apport();
                                                if ($new_domi < $mt_adomi) {

                                                    $sum += $res_dod->getMt_domi_apport();

//Création de la part du bénéficiaire de la domiciliation
                                                    $rep->setId_mf107($id_mf107);
                                                    $rep->setCode_membre($dom->getCode_membre());
                                                    $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                                    $rep->setMont_rep($res_dod->getMt_domi_apport());
                                                    $rep->setId_utilisateur($user->id_utilisateur);
                                                    $rep->setMont_reglt(0);
						    $rep->setSolde_rep($res_dod->getMt_domi_apport());
                                                    $rep->setPayer(0);
                                                    $mrep->save($rep);

                                                    $resp = $membre_mapper->find($dom->getCode_membre(), $membre);
                                                    if ($resp) {
                                                        Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $res_dod->getMt_domi_apport() . " sur le compte marchand " . $dom->getCode_membre());
                                                    }

//Mise à jour de la table de domiciliation
                                                    $dom->setMt_domicilie($mt_domi + $res_dod->getMt_domi_apport());
                                                    $mdom->update($dom);
													
//Création ou mise à jour du compte nn de transfert du MF107
                                                    $code_compte = 'nn-tr-' . $dom->getCode_membre();
                                                    $ret_req = $m_compte->find($code_compte, $compte);
                                                    if ($ret_req == false) {
                                                        $compte->setCode_cat('tr')
                                                                ->setCode_membre($dom->getCode_membre())
                                                                ->setCode_compte($code_compte)
                                                                ->setCode_type_compte('nn')
                                                                ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                                ->setDesactiver(0)
                                                                ->setLib_compte('Compte de recharge')
                                                                ->setSolde($res_dod->getMt_domi_apport());
                                                        $m_compte->save($compte);
                                                    } else {
                                                        $compte->setSolde($compte->getSolde() + $res_dod->getMt_domi_apport());
                                                        $m_compte->update($compte);
                                                    }
													
													
                                                } else {
                                                    $reste_domi = $mt_adomi - $mt_domi;
                                                    $sum += $reste_domi;
//Création de la part du bénéficiaire de la domiciliation
                                                    if ($reste_domi > 0) {
                                                       $rep->setId_mf107($id_mf107);
                                                       $rep->setCode_membre($dom->getCode_membre());
                                                       $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                                       $rep->setMont_rep($reste_domi);
                                                       $rep->setId_utilisateur($user->id_utilisateur);
                                                       $rep->setMont_reglt(0);
											           $rep->setSolde_rep($reste_domi);
                                                       $rep->setPayer(0);
                                                       $mrep->save($rep);

                                                       $resp = $membre_mapper->find($dom->getCode_membre(), $membre);
                                                       if ($resp) {
                                                            Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $reste_domi . " sur le compte marchand " . $dom->getCode_membre());
                                                       }
                                                    }
//Mise à jour de la table de domiciliation
                                                    $dom->setMt_domicilie($mt_domi + $reste_domi);
                                                    $dom->setEtat_domiciliation(1);
                                                    $mdom->update($dom);
													
													//Création ou mise à jour du compte nn de transfert du MF11000
                                                    $code_compte = 'nn-tr-' . $dom->getCode_membre();
                                                    $ret_req = $m_compte->find($code_compte, $compte);
                                                    if ($ret_req == false) {
                                                        $compte->setCode_cat('tr')
                                                                ->setCode_membre($dom->getCode_membre())
                                                                ->setCode_compte($code_compte)
                                                                ->setCode_type_compte('nn')
                                                                ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                                ->setDesactiver(0)
                                                                ->setLib_compte('Compte de recharge')
                                                                ->setSolde($reste_domi);
                                                        $m_compte->save($compte);
                                                    } else {
                                                        $compte->setSolde($compte->getSolde() + $reste_domi);
                                                        $m_compte->update($compte);
                                                    }
													
													
                                                }
                                            }
//Mise à jour de la table eu_detail_domicilie_mf11000
//                                            $find_dod1 = $mdod->find($res_dod->getId_domi(), $res_dod->getId_mf11000(), $dod);
//                                            if ($find_dod1 == true) {
//                                                $dod->setReste_repartition($dod->getReste_repartition() - 1);
//                                                $mdod->update($dod);
//                                            }
                                            if ($res_dod->getNb_reste() > 0) {
//Mise à jour de la table eu_detail_domicilie_mf107
                                                $id_dom = $res_dod->getId_dom();
                                                $query = "update eu_detail_domicilie_mf107 set nb_reste =(nb_reste -1)  where id_dom='$id_dom' and id_mf107='$id_mf107'";
                                                $db->query($query);
                                            }
                                        }
                                    }


//Création de la part de l'apporteur ayant fait des domiciliations
                                    if ($code_proprio != $code_apporteur) {
                                        if ($sum < $montant_recu) {//Placement apporteur
                                            $rep->setId_mf107($id_mf107);
                                            $rep->setCode_membre($code_apporteur);
                                            $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                            $rep->setMont_rep($montant_recu - $sum);
                                            $rep->setId_utilisateur($user->id_utilisateur);
                                            $rep->setMont_reglt(0);
					    $rep->setSolde_rep($montant_recu - $sum);
                                            $rep->setPayer(0);
                                            $mrep->save($rep);

                                            $resp = $membre_mapper->find($code_apporteur, $membre);
                                            if ($resp) {
                                                Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $montant_recu - $sum . " sur le compte marchand " . $code_apporteur);
                                            }
											
											//Création ou mise à jour du compte nn de transfert du MF107
                                            $code_compte = 'nn-tr-' . $code_apporteur;
                                            $ret_req = $m_compte->find($code_compte, $compte);
                                            if ($ret_req == false) {
                                                $compte->setCode_cat('tr')
                                                        ->setCode_membre($code_apporteur)
                                                        ->setCode_compte($code_compte)
                                                        ->setCode_type_compte('nn')
                                                        ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                        ->setDesactiver(0)
                                                        ->setLib_compte('Compte de recharge')
                                                        ->setSolde($montant_recu - $sum);
                                                $m_compte->save($compte);
                                            } else {
                                                $compte->setSolde($compte->getSolde() + $montant_recu - $sum);
                                                $m_compte->update($compte);
                                            }
											
											
                                        }

//Création de la part du propriétaire du compte MF107
                                        if ($mont > 0) {
                                            $rep->setId_mf107($id_mf107);
                                            $rep->setCode_membre($code_proprio);
                                            $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                            $rep->setMont_rep($mont);
                                            $rep->setId_utilisateur($user->id_utilisateur);
                                            $rep->setMont_reglt(0);
					    $rep->setSolde_rep($mont);
                                            $rep->setPayer(0);
                                            $mrep->save($rep);

                                            $resp = $membre_mapper->find($code_proprio, $membre);
                                            if ($resp) {
                                                Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $mont . " sur le compte marchand " . $code_proprio);
                                            }
											
											//Création ou mise à jour du compte nn de transfert du MF107
                                            $code_compte = 'nn-tr-' . $code_proprio;
                                            $ret_req = $m_compte->find($code_compte, $compte);
                                            if ($ret_req == false) {
                                                $compte->setCode_cat('tr')
                                                        ->setCode_membre($code_proprio)
                                                        ->setCode_compte($code_compte)
                                                        ->setCode_type_compte('nn')
                                                        ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                        ->setDesactiver(0)
                                                        ->setLib_compte('Compte de recharge')
                                                        ->setSolde($mont);
                                                $m_compte->save($compte);
                                            } else {
                                                $compte->setSolde($compte->getSolde() + $mont);
                                                $m_compte->update($compte);
                                            }
											
											
                                        }
                                    } else {//Placement propriétaire                                   
                                        if (($res_mf->getMont_apport() - $sum) > 0) {
                                            $rep->setId_mf107($id_mf107);
                                            $rep->setCode_membre($code_proprio);
                                            $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                            $rep->setMont_rep($res_mf->getMont_apport() - $sum);
                                            $rep->setId_utilisateur($user->id_utilisateur);
                                            $rep->setMont_reglt(0);
					    $rep->setSolde_rep($res_mf->getMont_apport() - $sum);
                                            $rep->setPayer(0);
                                            $mrep->save($rep);

                                            $resp = $membre_mapper->find($code_proprio, $membre);
                                            if ($resp) {
                                                Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $res_mf->getMont_apport() - $sum . " sur le compte marchand " . $code_proprio);
                                            }
											
//Création ou mise à jour du compte nn de transfert du MF11000
                                        $code_compte = 'nn-tr-' . $code_proprio;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                    ->setCode_membre($code_proprio)
                                                    ->setCode_compte($code_compte)
                                                    ->setCode_type_compte('nn')
                                                    ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                    ->setDesactiver(0)
                                                    ->setLib_compte('Compte de recharge')
                                                    ->setSolde($res_mf->getMont_apport() - $sum);
                                            $m_compte->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $res_mf->getMont_apport() - $sum);
                                            $m_compte->update($compte);
                                        }
											
                                        }
                                    }
                                }
                            }
                        }
//Mise à jour de la table eu_membre_fondateur107
                        $numident = $sel['numident'];
                        $query = "update eu_membre_fondateur107 set nb_repartition =(nb_repartition + 1)  where numident='$numident'";
                        $db->query($query);
                    }
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

    public function editAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        // action body
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        if ($this->getRequest()->isPost()) {
           try {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $membre = new Application_Model_EuMembreFondateur107();
                $mapper = new Application_Model_EuMembreFondateur107Mapper();

                $detail_mf = new Application_Model_EuDetailMf107();
                $detail_mapper = new Application_Model_EuDetailMf107Mapper();

                $numero = $_POST['numero'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $tel = $_POST['tel'];
                $cel = $_POST['cel'];
                $code_membre = $_POST['code_membre'];
                $code_dev = $_POST['dev_apport'];
                $montant = $_POST['mont_apport'];

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

                $mont_apport = $detail_mapper->findmontant($numero);
                $id_mf107 = $detail_mapper->findid($numero);

                $ret_mf = $mapper->find($numero, $membre);
                if ($ret_mf) {
                    $membre->setNom(htmlentities (addslashes (trim ($nom))));
                    $membre->setPrenom(htmlentities (addslashes (trim ($prenom))));
                    $membre->setTel($tel);
                    $membre->setCel($cel);
                    $membre->setCode_membre($code_membre);
                    $membre->setSolde($membre->getSolde() - $mont_apport);
                    $membre->setSolde($membre->getSolde() + $montant);
                    $membre->setId_utilisateur($user->id_utilisateur);
                    $mapper->update($membre);
                }

                $detail_mf->setId_mf107($id_mf107);
                $detail_mf->setNumident($numero);
                $detail_mf->setCode_membre($code_membre);
                $detail_mf->setDate_mf107($date_idd->toString('yyyy-mm-dd'));
                $detail_mf->setMont_apport($montant);
                $detail_mf->setId_utilisateur($user->id_utilisateur);
                $detail_mf->setPourcentage(100);
                $detail_mf->setProprietaire(1);
                $detail_mapper->update($detail_mf);

                $db->commit();
                return $this->_helper->redirector('index');
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->numero = $_POST["numero"];
                $this->view->nom = $_POST["nom"];
                $this->view->prenom = $_POST["prenom"];
                $this->view->tel = $_POST["tel"];
                $this->view->cel = $_POST["cel"];
                $this->view->code_membre = $_POST["code_membre"];
                $message = 'Impossible de modifier les données';
//$message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        } else {
            $numident = $this->getRequest()->numident;
            $tabela = new Application_Model_DbTable_EuMembreFondateur107();
            $tabela1 = new Application_Model_DbTable_EuDetailMf107();
            $select = $tabela->select();
            $select1 = $tabela1->select();
            $select->where('EU_MEMBRE_FONDATEUR107.numident = ?', $numident);

            $select1->where('numident = ?', $numident);
            $select1->where('proprietaire = ?', 1);

            $alloc = $tabela->fetchAll($select);
            $alloc1 = $tabela1->fetchAll($select1);
            $row1 = $alloc1->current();
            foreach ($alloc as $row) {
                $this->view->numero = $row->numident;
                $this->view->nom = $row->nom;
                $this->view->prenom = $row->prenom;
                $this->view->tel = $row->tel;
                $this->view->cel = $row->cel;
                $this->view->code_membre = $row->code_membre;
                $this->view->mont_apport = $row1->mont_apport;
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

    public function mfAction() {
        $data = array();
        $mf = new Application_Model_DbTable_EuMembreFondateur107();
        $select = $mf->select();
        $select->where('code_membre is not null');
        $result = $mf->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function recupnomAction() {

        $request = $this->getRequest();
        $num_membre = $request->num_membre;
        $membre = new Application_Model_DbTable_EuMembre;
        $select = $membre->select();
        $select->from($membre, array('nom_membre', 'PREnom_membre'));
        $select->where('code_membre = ?', $num_membre);
        $result = $membre->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            $data[0] = strtoupper($row->nom_membre);
            $data[1] = ucfirst($row->prenom_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function recupmfAction() {

        $request = $this->getRequest();
        $num_membre = $request->num_membre;
        $membre = new Application_Model_DbTable_EuMembreFondateur107;
        $select = $membre->select();
        $select->from($membre, array('numident', 'nom', 'PREnom'));
        $select->where('code_membre = ?', $num_membre);
        $result = $membre->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            $data[0] = $row->numident;
            $data[1] = ucfirst($row->nom) . "  " . $row->PREnom;
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
                $mont_apport = $results->current()->creditamount;
                $data = $mont_apport;
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

    public function convertirAction() {

        $dev = $_GET['dev'];
        $dev1 = $_GET['dev1'];
        if ($dev != $dev1) {
            if ($dev != $dev1) {
                $code_cours = $dev . '-' . $dev1;
                $cours = new Application_Model_EuCours();
                $m_cours = new Application_Model_EuCoursMapper();
                $ret = $m_cours->find($code_cours, $cours);
                if ($ret) {
                    $mont_apport = $_GET['montant'];
                    if ($mont_apport != '') {
                        $montant = $mont_apport * $cours->getVal_dev_fin();
                        $data = $montant;
                    }
                } else {
                    $data = false;
                }
            }
        }

        $this->view->data = $data;
    }

    public function repartitionAction() {
        
    }

    public function reglementAction() {
        
    }

    public function datadmfAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $membre = $this->getRequest()->membre;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'ID_MF107');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuMembre();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('EU_REPARTITION_MF107', 'EU_REPARTITION_MF107.code_membre = eu_membre.code_membre')
               ->where('EU_REPARTITION_MF107.code_membre =?', $membre)
               ->where('EU_REPARTITION_MF107.payer =?', 0);
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
                $row->mont_rep,
                $row->date_rep,
                $row->id_rep,
                $row->code_membre
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function verifierAction() {
        $request = $this->getRequest();
        $numident = $request->numident;
        $mf = new Application_Model_DbTable_EuMembreFondateur107;
        $select = $mf->select();
        $select->from($mf, array('code_membre'));
        $select->where('numident = ?', $numident);
        $result = $mf->fetchAll($select);
        $row = $result->current();
        $this->view->data = $row['code_membre'];
    }

    public function numidentAction() {
        $data = array();
        $mf = new Application_Model_DbTable_EuMembreFondateur107();
        $result = $mf->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->numident;
        }
        $this->view->data = $data;
    }
	
    public function identiteAction() {
        $request = $this->getRequest();
        $numero = $request->numero;
        $membre = new Application_Model_DbTable_EuMembreFondateur107;
        $select = $membre->select();
        $select->from($membre, array('nom', 'PREnom'));
        $select->where('code_membre = ?', $numero);
        $result = $membre->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            $data = $row->nom . '  ' . $row->PREnom;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function compteAction() {

        $request = $this->getRequest();
        $numero = $request->numero;

        $membre = new Application_Model_DbTable_EuMf107;
        $select = $membre->select();
        $select->from($membre, array('solde'));
        $select->where('code_membre = ?', $numero);
        $result = $membre->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            $data = $row->solde;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function saveAction() {

        if ($this->getRequest()->isPost()) {
            $compteur = $_POST['cpteur'];
            $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $mf = new Application_Model_EuMf107();
                $mf_mapper = new Application_Model_EuMf107Mapper();
                $det_mf = new Application_Model_EuDetailMf107();
                $det_mapper = new Application_Model_EuDetailMf107Mapper();

                $cg = new Application_Model_EuCompteGeneral();
                $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                $code_mf107 = 'mf-' . $_POST['code_membre'];
                for ($i = 1; $i <= $compteur; $i++) {
                    $ret_cg = $cg_mapper->find('MF107', 'nn', 'e', $cg);
                    $ret_mf = $mf_mapper->find($code_mf107, $mf);
                    if (!$ret_mf) {
                        $mf->setCode_mf107($code_mf107)
                                ->setSolde($_POST["montant$i"])
                                ->setCode_membre($_POST['code_membre']);
                        $mf_mapper->save($mf);
                    } else {
                        $mf->setSolde($mf->getSolde() + $_POST["montant$i"]);
                        $mf_mapper->update($mf);
                    }
                    $det_mf->setCode_mf107($code_mf107)
                            ->setNumident($_POST["numero$i"])
                            ->setDate_mf107($date_idd->toString('yyyy-mm-dd'))
                            ->setMont_apport($_POST["montant$i"])
                            ->setMont_preleve(0)
                            ->setMont_recu(0)
                            ->setCode_membre($_POST['code_membre']);
                    $det_mapper->save($det_mf);
                }
                $db->commit();
                $this->view->data = true;
            } catch (Exception $e) {
                $db->rollback();
                $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
            }
        }
    }

    public function createAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();

        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;

        $selection = array();
        $selection = $_GET['lignes'];
        $mt_domi = $_GET['mt_domi'];
        $code_membre = $_GET['membre'];

        $parametre = new Application_Model_EuParametres;
        $parametre_mapper = new Application_Model_EuParametresMapper();

        $parametre_mapper->find('mf107', 'valeur', $parametre);
        $mf107 = $parametre->getMontant();

        $membre = new Application_Model_EuMembreFondateur107();
        $mapper = new Application_Model_EuMembreFondateur107Mapper();

        $dom = new Application_Model_EuDomicilieMf107();
        $dom_mapper = new Application_Model_EuDomicilieMf107Mapper();

        $ddom = new Application_Model_EuDetailDomicilieMf107();
        $ddom_mapper = new Application_Model_EuDetailDomicilieMf107Mapper();

        $somme = 0;
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                foreach ($selection as $val) {
                    $numident = $val['numident'];
                    $nb_repartition = $mapper->findnbrep($numident);
                    $nb_repartition = $mf107 - $nb_repartition;
                    if ($nb_repartition < $val['nb_repartition']) {
                        $this->view->data = 'cool';
                        return;
                    } else if ($val['mt_utilise'] > $val['mt_reel']) {
                        $this->view->data = 'erreur';
                        return;
                    } else {
                        $somme = $somme + ($val['mt_utilise'] * $val['nb_repartition']);
                    }
                }

                if ($somme < $mt_domi) {
                    $this->view->data = 'err_domi';
                    return;
                }

                $dom->setMt_domiciliation($mt_domi);
                $dom->setMt_domicilie(0);
                $dom->setEtat_domiciliation(0);
                $dom->setCode_membre($code_membre);
                $dom->setDate_dom($date_domi->toString('yyyy-mm-dd'));
                $dom->setHeure_dom($date_domi->toString('hh:mm'));
                $dom_mapper->save($dom);

                $maxdom = $dom_mapper->findMaxDom();

                foreach ($selection as $val) {
                    $ddom->setId_dom($maxdom);
                    $ddom->setId_mf107($val['id_mf107']);
                    $ddom->setMt_domi_apport($val['mt_utilise']);
                    $ddom->setNb_rep($val['nb_repartition']);
                    $ddom->setNb_reste($val['nb_repartition']);
                    $ddom_mapper->save($ddom);
                }

                $db->commit();
                $this->view->data = 'good';
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
                $this->view->data = 'bad';
                return;
            }
        }
    }

    public function creditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'id_mf107');
        $sord = $this->_request->getParam("sord", 'asc');
        $code_membre = $this->getRequest()->code_membre;

        $parametre = new Application_Model_EuParametres;
        $parametre_mapper = new Application_Model_EuParametresMapper();

        $ddom = new Application_Model_EuDetailDomicilieMf107;
        $ddom_mapper = new Application_Model_EuDetailDomicilieMf107Mapper;


        $membre = new Application_Model_EuMembreFondateur107;
        $mapper = new Application_Model_EuMembreFondateur107Mapper();

        $parametre_mapper->find('mf107', 'valeur', $parametre);
        $mf107 = $parametre->getMontant();

        $tabela = new Application_Model_DbTable_EuDetailMf107();

        if ($code_membre != '') {
            $select = $tabela->select();
            $select->where('code_membre = ?', $code_membre);
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
            $date_apport = new Zend_Date($row->DATE_MF107);
            $mapper->find($row->numident, $membre);
            $nb = $membre->getNb_repartition();
            $code_membre = $membre->getCode_membre();
            $mf107 = $parametre->getMontant();

            $sum_dom = $ddom_mapper->getSumDomicilie($row->ID_MF107);

            if ($code_membre != $row->code_membre) {
                $montant = ($row->mont_apport - ($row->mont_apport * $row->pourcentage) / 100) - $sum_dom;
            } else {
                $montant = $row->mont_apport - $sum_dom;
            }
            $responce['rows'][$i]['id'] = $row->ID_MF107;
            $responce['rows'][$i]['cell'] = array(
                $row->numident,
                $row->mont_apport,
                $montant,
                $montant,
                $mf107 - $nb,
                $date_apport->toString('dd/mm/yyyy'),
                $row->ID_MF107
            );
            $i++;
        }
        $this->view->data = $responce;
    }



    public function crediterAction() {

        if ($this->getRequest()->isPost()) {
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $code_membre = $_POST['code_membre'];
                $code_sms = $_POST['code_sms'];
                $membre = $_POST['membre'];
                $numero = $_POST['numero'];
                $montant = $_POST['mont_apport'];
                $code_dev = $_POST['dev_apport'];
                $pp = $_POST['pp'];
                //$code_mf107 = 'MF107-' . $membre;
				
                $num_comptep = 'nn-MF107-' . $membre;
				$num_compteapp = 'nn-MF107-' . $code_membre;

                $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                $sms = $sms_mapper->findByCreditCode($code_sms);

                
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
						   $m_detsms = new Application_Model_EuDetailSmsmoneyMapper();
                           $solde=$m_detsms->findsumpbf($acteur->code_membre);
						   if($solde > $montant) {
                             $select_det_sms = $db->select();
                             $select_det_sms->from('eu_detail_smsmoney')
                                            ->where('code_membre_dist like ?', $acteur->code_membre)
                                            ->where('origine_sms like ?', 'pbf');
                                $details_sms = $db->fetchAll($select_det_sms);
                                if (count($details_sms) > 0) {
                                    $mont_deduire = $montant;
                                    $det_sms = new Application_Model_EuDetailSmsmoney();
                                    foreach ($details_sms as $value) {
                                       $det_sms->exchangeArray($value);
                                       if ($det_sms->getSolde_sms() >= $mont_deduire) {
                                           $det_sms->setMont_vendu($det_sms->getMont_vendu() + $mont_deduire)
                                                   ->setSolde_sms($det_sms->getSolde_sms() - $mont_deduire);        
                                           $mont_deduire = 0;
                                           $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));          
                                        }
                                        else { 
                                             $mont_deduire -= $det_sms->getSolde_sms();
                                             $det_sms->setMont_vendu($det_sms->getMont_vendu() + $det_sms->getSolde_sms())
                                                     ->setSolde_sms(0);
                                             $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));  
                                        }
                                        if ($mont_deduire == 0) {
                                            break;
                                        }
                                 }
                                        
                               }
                               
                            }
                            else {
                                 $this->view->message ='Votre compte de transfert est insuffisant pour effectuer cette opération';
                                 $this->view->code_membre = $code_membre;
                                 $this->view->code_sms = $code_sms;
                                 $this->view->membre = $membre;
                                 $this->view->numero = $numero;
                                 //$this->view->mont_apport = $mont_apport;
                                 $this->view->dev_apport = $code_dev;
                                 $this->view->pp = $pp;
                                 $this->view->nom_membre = $_POST['nom_membre'];
                                 $this->view->prenom_membre = $_POST['prenom_membre'];
                                 $this->view->nom = $_POST['nom'];
                                 return;   
                            }
                        }                   
                     }
					 
                     $detail_mf = new Application_Model_EuDetailMf107();
                     $detail_mapper = new Application_Model_EuDetailMf107Mapper();

                     $mem = new Application_Model_EuMembre();
                     $membre_mapper = new Application_Model_EuMembreMapper();

                     $detail_mf->setNumident($numero);
                     $detail_mf->setCode_membre($code_membre);
                     $detail_mf->setDate_mf107($date_idd->toString('yyyy-mm-dd'));
                     $detail_mf->setMont_apport($montant);
                     $detail_mf->setId_utilisateur($user->id_utilisateur);
                     $detail_mf->setPourcentage($pp);
                     $detail_mf->setProprietaire(null);
		             $detail_mf->setCreditcode($code_sms);
                     $detail_mapper->save($detail_mf);

                     $max = $detail_mapper->findConuter();
                      
					 $parametre = new Application_Model_EuParametres;
                     $parametre_mapper = new Application_Model_EuParametresMapper();

                     $parametre_mapper->find('mf107', 'valeur', $parametre);
                     $mf107 = $parametre->getMontant(); 
					  
					 $compte    = new Application_Model_EuCompte();
					 $cm_mapper = new Application_Model_EuCompteMapper();
					 $montantp  =($montant * $pp)/100;
					 $cumulp    = $montantp * $mf107;
                             $result = $cm_mapper->find($num_comptep, $compte);
                             if ($result == false) {
                                 Util_Utils::createCompte($num_comptep,'Compte de Membre Fondateur 107','MF107',$cumulp, $membre,'nn',$date_idd->toString('yyyy-mm-dd'),0);
                             } else {
                                $compte->setSolde($compte->getSolde() + $cumulp);
                                $cm_mapper->update($compte);
                             }
						
						
                     $detail_comptemf = new Application_Model_EuDetailCompteMf107();
                     $detail_comptemf_mapper = new Application_Model_EuDetailCompteMf107Mapper();
                      
                     $detail_comptemf->setCode_compte($num_comptep)
                                     ->setDate_detail($date_idd->toString('yyyy-mm-dd'))
                                     ->setMontant_rep($montantp)
                                     ->setCumul($cumulp)
                                     ->setNumident($numero)
                                     ->setPourcentage($pp)
                                     ->setId_utilisateur($user->id_utilisateur)
                                     ->setEtat_detail_compte(0)
                                     ->setCreditcode($code_sms);
									 
					  $detail_comptemf_mapper->save($detail_comptemf);
					  
					  
					  
					 $montantapp  = $montant - $montantp;
					 $cumulapp    = $montantapp * $mf107;
                             $result = $cm_mapper->find($num_compteapp, $compte);
                             if ($result == false) {
                                 Util_Utils::createCompte($num_compteapp,'Compte de Membre Fondateur 107','MF107',$cumulapp, $code_membre,'nn',$date_idd->toString('yyyy-mm-dd'),0);
                             } else {
                                $compte->setSolde($compte->getSolde() + $cumulapp);
                                $cm_mapper->update($compte);
                             }
						 
                     $detail_comptemf->setCode_compte($num_compteapp)
                                     ->setDate_detail($date_idd->toString('yyyy-mm-dd'))
                                     ->setMontant_rep($montantapp)
                                     ->setCumul($cumulapp)
                                     ->setNumident($numero)
                                     ->setPourcentage(100-$pp)
                                     ->setId_utilisateur($user->id_utilisateur)
                                     ->setEtat_detail_compte(0)
                                     ->setCreditcode($code_sms);			 
					  $detail_comptemf_mapper->save($detail_comptemf);
					    
                      $req = "update EU_MEMBRE_FONDATEUR107 set solde =(solde + $montant)  where numident='$numero'";
                      $db->query($req);

                      $query = "update eu_compte_general  set solde =(solde + $montant)  where code_compte='MF107' and code_type_compte='nn' and service='e'";
                      $db->query($query);

                      $sms->setDestAccount_Consumed($num_compteapp)
                          ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                          ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
					  $mapper_op = new Application_Model_EuOperationMapper();	 
                      $sms_mapper->update($sms);
				      $compteur = $mapper_op->findConuter() + 1;
                      Util_Utils::addOperation($compteur,$code_membre,null,'tfs', $montant, 'fs', 'Auto-enrôlement', 'aerl', $date_idd->toString('yyyy-mm-dd'), $date_idd->toString('hh:mm:ss'), $user->id_utilisateur);
                        
		              //Facturations de la prestation
		              $compte_transfert = $sms->getFromAccount();
                      $transfert = explode('-', $compte_transfert);
                      $membre_transfert = $transfert[2];
                      $td_fact = new Application_Model_DbTable_EuDetailFacturation();
                      $d_fact = new Application_Model_EuDetailFacturation();
                      $tx_prestation = Util_Utils::getParametre('cncs', 'capa');
                      $cm_map = new Application_Model_EuCompteMapper();
                      $mont_fact = $sms->getCreditAmount() * $tx_prestation / 100;
                      $_compte = new Application_Model_EuCompte();
                      $num_compte_fact = 'nn-' . 'tpagcp-' . $membre_transfert;
                      $result = $cm_map->find($num_compte_fact, $_compte);
                      if ($result == false) {
                         $_compte->setCode_membre($membre_transfert)
                                 ->setCode_cat('tpagcp')
                                 ->setSolde($mont_fact)
                                 ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                 ->setCode_compte($num_compte_fact)
                                 ->setLib_compte('gcp')
                                 ->setCode_type_compte('nn')
                                 ->setDesactiver(0);
                                $cm_map->save($_compte);
                      } else {
                                $_compte->setSolde($_compte->getSolde() + $mont_fact);
                                $cm_map->update($_compte);
                      }
                                $d_fact->setCode_compte($num_compte_fact)
                                       ->setCode_membre($membre_transfert)
                                       ->setCreditcode($sms->getCreditcode())
                                       ->setDate_facturation($date_idd->toString('yyyy-mm-dd'))
                                       ->setMont_facturation($mont_fact)
                                       ->setId_operation($compteur)
                                       ->setId_cnp(0);
                                $td_fact->insert($d_fact->toArray());
				
		             $resp = $membre_mapper->find($membre,$mem);
                     if ($resp) {
					     $compteur=Util_Utils::findConuter() + 1;
                         Util_Utils::addSms($compteur,$mem->getPortable_membre(),"Le membre  " . $code_membre . "  vient de faire un placement de  " . $montant . " fcfa sur votre compte MF107  " . $membre);
                     }
					 
                     $db->commit();
                     //return $this->_helper->redirector('detailmf107');
                     return $this->_helper->redirector('crediter', 'eu-pdf-reglt',null,array('controller' => 'eu-pdf-reglt','action'=>'crediter','id_mf107' => $max));
            
			} catch (Exception $e) {
                    $db->rollback();
                    $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
				    return;
            }
        }
    }

}
