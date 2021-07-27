<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuMembreFondateur11000Controller extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'cm' || $group == 'mf') {
            $menu = "<li><a id=\"new\" href=\"/eu-membre-fondateur11000/new\">Nouveau</a></li>";
            //.
            // "<li><a id=\"detail\" href=\"/eu-membre-fondateur11000/crediter\">Créditer un compte</a></li>" .
            // "<li><a id=\"detail\" href=\"/eu-membre-fondateur11000/detailmf11000\">Détail compte MF11000</a></li>";
        } elseif ($group == 'mf_rep') {
            $menu = "<li><a href=\"/eu-membre-fondateur11000/index\">Liste MF11000</a></li>" .
                    "<li><a href=\"/eu-membre-fondateur11000/repartition\">Répartition</a></li>" .
                    "<li><a href=\"/eu-membre-fondateur11000/detailrep\">Détail répartition</a></li>";
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

    public function dataAction() {

        $request = $this->getRequest();
        $numero = $request->numero;
        $nom = $request->nom;
        $prenom = $request->prenom;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 1000);
        $sidx = $this->_request->getParam("sidx", 'num_bon');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuMembreFondateur11000();
        $select = $tabela->select();
        if ($numero != "") {
            $select->where('num_bon like ?', '%' . $numero . '%');
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
        $tot_apport = 0;
        foreach ($agences as $row) {
            $tot_apport+= $row->solde;
            $responce['rows'][$i]['id'] = $row->nom_bon;
            $responce['rows'][$i]['cell'] = array(
                $row->num_bon,
                $row->nom,
                $row->prenom,
                $row->code_membre,
                $row->tel,
                $row->cel,
                $row->solde,
                $row->nb_repartition
            );
            $i++;
        }
        $responce['userdata']['numident'] = number_format($count, 0, ',', ' ');
        $responce['userdata']['cel'] = 'Total:';
        $responce['userdata']['mt_place'] = $tot_apport;
        $this->view->data = $responce;
    }


    public function totapportAction() {
        //Récupération du montant total des apports sur le compte MF11000
        $mcompte = new Application_Model_EuMembreFondateur11000Mapper();
        $rest = $mcompte->fetchAll();
        if ($rest == false) {
            $tot_apport = 0;
        } else {
            $tot_apport = 0;
            foreach ($rest as $p) {
                $tot_apport += $p->solde;
            }
        }
        $this->view->data = number_format($tot_apport, 0, ',', ' ');
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
        $mf = new Application_Model_DbTable_EuMembreFondateur11000();
        $select = $mf->select();
        $select->where('code_membre is not null');
        $result = $mf->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }


    public function recupmfAction() {

        $request = $this->getRequest();
        $num_membre = $request->num_membre;
        $membre = new Application_Model_DbTable_EuMembreFondateur11000;
        $select = $membre->select();
        $select->from($membre, array('num_bon', 'nom', 'PREnom'));
        $select->where('code_membre = ?', $num_membre);
        $result = $membre->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            $data[0] = $row->num_bon;
            $data[1] = ucfirst($row->nom) . "  " . $row->PREnom;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }


    public function verifierAction() {
        $request = $this->getRequest();
        $numero = $request->numero;
        $mf = new Application_Model_DbTable_EuMembreFondateur11000;
        $select = $mf->select();
        $select->from($mf, array('code_membre'));
        $select->where('num_bon = ?', $numero);
        $result = $mf->fetchAll($select);
        $row = $result->current();
        $this->view->data = $row['code_membre'];
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


    public function numbonAction() {
        $data = array();
        $mf = new Application_Model_DbTable_EuMembreFondateur11000();
        $result = $mf->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->num_bon;
        }
        $this->view->data = $data;
    }


    public function recupnomAction() {
        $request = $this->getRequest();
        $num_membre = $request->num_membre;
        $membre = new Application_Model_DbTable_EuMembre;
        $select = $membre->select();
        $select->from($membre, array('nom_membre', 'PREnom_membre', 'portable_membre'));
        $select->where('code_membre = ?', $num_membre);
        $result = $membre->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            $data[0] = strtoupper($row->nom_membre);
            $data[1] = ucfirst($row->prenom_membre);
            $data[2] = ucfirst($row->portable_membre);
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


    public function crediterAction() {
        //$this->_helper->layout->disableLayout();
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
                $cel = $_POST['cel'];
                $pp = $_POST['pp'];
                $num_compte = 'nn-MF11000-' . $membre;
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
                //Enregistrement de l'pport dans la table eu-detail-mf11000
                $detail_mf = new Application_Model_EuDetailMf11000();
                $detail_mapper = new Application_Model_EuDetailMf11000Mapper();
                $mem = new Application_Model_EuMembre();
                $membre_mapper = new Application_Model_EuMembreMapper();
                $detail_mf->setNum_bon($numero);
                $detail_mf->setCode_membre($code_membre);
                $detail_mf->setDate_mf11000($date_idd->toString('yyyy-mm-dd'));
                $detail_mf->setMont_apport($montant);
                $detail_mf->setId_utilisateur($user->id_utilisateur);
                $detail_mf->setPourcentage($pp);
                $detail_mf->setProprietaire(0);
                $detail_mf->setCel($cel);
                $detail_mapper->save($detail_mf);

                $max = $detail_mapper->findConuter();

                //Mise à jour du compte du membre fondateur
                $req = "update eu_membre_fondateur11000 set solde =(solde + $montant)  where num_bon='$numero'";
                $db->query($req);
                //Mise à jour du compte général
                $query = "update eu_compte_general  set solde =(solde + $montant)  where code_compte='MF11000' and code_type_compte='nn' and service='e'";
                $db->query($query);

                $sms->setDestAccount_Consumed($num_compte)
                        ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
                $sms_mapper->update($sms);

                $resp = $membre_mapper->find($membre, $mem);
                if ($resp) {
                    Util_Utils::addSms($mem->getPortable_membre(), "Le membre " . $code_membre . " vient de faire un placement de " . $montant . " fcfa sur votre compte MF11000 " . $membre);
                }

                $db->commit();
                //return $this->_helper->redirector('detailmf11000');

                return $this->_helper->redirector('crediter1', 'eu-pdf-reglt', null, array('controller' => 'eu-pdf-reglt', 'action' => 'crediter1', 'id_mf11000' => $max));
            } catch (Exception $e) {
                $db->rollback();
                $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
            }
        }
    }

    public function newAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //insertion dans la table membre_fondateur11000 des informations
            if (count($_POST)) {
                $montant = $_POST['mont_apport'];
                $code_dev = $_POST['dev_apport'];
                $num_bon = $_POST['numero'];
                $membre = new Application_Model_EuMembreFondateur11000();
                $mapper = new Application_Model_EuMembreFondateur11000Mapper();
                //Controle de l'existence du numero de bon dans la table
                $find_mf = $mapper->find($num_bon, $membre);
                if ($find_mf != false) {
                    $message = 'Ce numéro de bon existe déjà !';
                    $this->view->message = $message;
                    $this->view->numero = $num_bon;
                    $this->view->nom = $_POST["nom"];
                    $this->view->prenom = $_POST["prenom"];
                    $this->view->tel = $_POST["tel"];
                    $this->view->cel = $_POST["cel"];
                    $this->view->code_membre = $_POST["code_membre"];
                    $this->view->mont_apport = $montant;
                    $this->view->dev_apport = $code_dev;
                    return;
                } else {
                    $membre->setNum_bon($num_bon)
                            ->setNom($_POST["nom"])
                            ->setPrenom($_POST["prenom"])
                            ->setTel($_POST["tel"])
                            ->setCel($_POST["cel"])
                            ->setId_utilisateur($user->id_utilisateur);
                    if ($_POST["code_membre"] == '') {
                        $code_membre = null;
                    } else {
                        $code_membre = $_POST["code_membre"];
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
                    $membre->setCode_membre($code_membre);
                    $membre->setSolde($montant);
                    $membre->setNb_repartition(0);
                    $mapper->save($membre);
                    //Enregistrement dans la table detail_mf11000
                    $detail = new Application_Model_EuDetailMf11000();
                    $mdetail = new Application_Model_EuDetailMf11000Mapper();
                    $detail->setCode_membre($code_membre)
                            ->setNum_bon($num_bon)
                            ->setDate_mf11000($date_idd->toString('yyyy-mm-dd'))
                            ->setMont_apport($montant)
                            ->setPourcentage(0)
                            ->setId_utilisateur($user->id_utilisateur)
                            ->setCel($_POST["cel"])
                            ->setProprietaire(1);
                    $mdetail->save($detail);
                    //Mise à jour du compte générale MF11000
                    $gene = new Application_Model_EuCompteGeneral();
                    $mgene = new Application_Model_EuCompteGeneralMapper();
                    $find_gene = $mgene->find('MF11000', 'nn', 'e', $gene);
                    if ($find_gene == false) {
                        $query = "insert into eu_compte_general  set code_compte='MF11000', code_type_compte='nn', service='e', intitule='Membre Fondateur 11000', solde =$montant";
                    } else {
                        $query = "update eu_compte_general  set solde =(solde + $montant)  where code_compte='MF11000' and code_type_compte='nn' and service='e'";
                    }
                    $db->query($query);
                    $db->commit();
                    return $this->_helper->redirector('index');
                }
            }
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Impossible d\'enregistrer les données';
            //$message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
            $this->view->message = $message;
            return;
        }
    }

    public function editAction() {
        $this->_helper->layout->disableLayout();
        // action body
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        if ($this->getRequest()->isPost()) {
            try {
                $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
                $user = $auth->getIdentity();
                $membre = new Application_Model_EuMembreFondateur11000();
                $mapper = new Application_Model_EuMembreFondateur11000Mapper();
                $montant = $_POST['mont_apport'];
                $mont_init = $_POST['mont_init'];
                $code_dev = $_POST['dev_apport'];
                $num_bon = $_POST['numero'];
                if ($_POST["code_membre"] == '') {
                    $code_membre = null;
                } else {
                    $code_membre = $_POST["code_membre"];
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
                //Mise à jour de l'apport du propriétaire du compte MF11000
                $detail = new Application_Model_EuDetailMf11000();
                $mdetail = new Application_Model_EuDetailMf11000Mapper();
                $find_dmf = $mdetail->findByNumbon($num_bon);
                if ($find_dmf != null) {
                    $detail->setId_mf11000($find_dmf->getId_mf11000())
                            ->setCode_membre($code_membre)
                            ->setNum_bon($find_dmf->getNum_bon())
                            ->setDate_mf11000($find_dmf->getDate_mf11000())
                            ->setMont_apport($montant)
                            ->setPourcentage($find_dmf->getPourcentage())
                            ->setId_utilisateur($find_dmf->getId_utilisateur())
                            ->setCel($_POST["cel"])
                            ->setProprietaire($find_dmf->getProprietaire());
                    $mdetail->update($detail);
                }
                //Récupération du cumul des montant placés sur un compte mf11000
                $somme = $mdetail->getSumNumbon($num_bon);
                //Mise à jour de la table eu_membre_fondateur11000
                $membre->setNum_bon($num_bon);
                $membre->setNom($_POST["nom"]);
                $membre->setPrenom($_POST["prenom"]);
                $membre->setTel($_POST["tel"]);
                $membre->setCel($_POST["cel"]);
                $membre->setCode_membre($code_membre);
                $membre->setId_utilisateur($user->id_utilisateur);
                $membre->setSolde($somme);
                $membre->setNb_repartition($_POST["nb_repartition"]);
                $mapper->update($membre);
                //Mise à jour du compte générale MF11000
                $mont_new = $montant - $mont_init;
                $query = "update eu_compte_general  set solde =(solde + $mont_new)  where code_compte='MF11000' and code_type_compte='nn' and service='e'";
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
                $this->view->mont_apport = $montant;
                $this->view->nb_repartition = $_POST["nb_repartition"];
                $message = 'Impossible de modifier les données';
                //$message = $message . ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
            }
        } else {
            $num_bon = $this->getRequest()->numident;
            $tabela = new Application_Model_DbTable_EuMembreFondateur11000();
            $select = $tabela->select();
            $select->where('EU_MEMBRE_FONDATEUR11000.num_bon = ?', $num_bon);
            $alloc = $tabela->fetchAll($select);
            foreach ($alloc as $row) {
                $this->view->numero = $row->num_bon;
                $this->view->nom = $row->nom;
                $this->view->prenom = $row->prenom;
                $this->view->tel = $row->tel;
                $this->view->cel = $row->cel;
                $this->view->code_membre = $row->code_membre;
                $this->view->nb_repartition = $row->nb_repartition;
            }
            $tabelb = new Application_Model_DbTable_EuDetailMf11000();
            $selectb = $tabelb->select();
            $selectb->where('EU_DETAIL_MF11000.num_bon = ?', $num_bon)
                    ->where('EU_DETAIL_MF11000.proprietaire = ?', 1)
                    ->where('EU_DETAIL_MF11000.pourcentage = ?', 0);
            $allocb = $tabelb->fetchAll($selectb);
            foreach ($allocb as $rows) {
                $this->view->mont_apport = $rows->mont_apport;
                $this->view->mont_init = $rows->mont_apport;
            }
        }
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

    public function detailmf11000Action() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    public function mfdetailAction() {
        $date_deb = $_GET["date_deb"];
        $date_fin = $_GET["date_fin"];
        $code_membre = $_GET["code_membre"];
        $bon = $_GET["bon"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 1000);
        $sidx = $this->_request->getParam("sidx", 'num_bon');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuDetailMf11000();

        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                //->join('eu_membre', 'eu_membre.code_membre = eu_detail_mf11000.code_membre')
                //->where('eu_detail_mf11000.id_utilisateur = ?', $user->id_utilisateur)
                ->order('EU_DETAIL_MF11000.ID_MF11000 desc');
        if ($date_deb == '' and $date_fin == '') {
            $datedeb = '%';
            $select->where('EU_DETAIL_MF11000.DATE_MF11000 like ?', $datedeb);
        } else if ($date_deb == '') {
            $date2 = explode("/", $date_fin);
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('EU_DETAIL_MF11000.DATE_MF11000 <= ?', $datefin);
        } else if ($date_fin == '') {
            $date1 = explode("/", $date_deb);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('EU_DETAIL_MF11000.DATE_MF11000 >= ?', $datedeb);
        } else {
            $date1 = explode("/", $date_deb);
            $date2 = explode("/", $date_fin);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('EU_DETAIL_MF11000.DATE_MF11000 >= ?', $datedeb);
            $select->where('EU_DETAIL_MF11000.DATE_MF11000 <= ?', $datefin);
        }
        if ($code_membre == '') {
            $select->where('EU_DETAIL_MF11000.code_membre like ?', '%');
        } else {
            $select->where('EU_DETAIL_MF11000.code_membre like ?', $code_membre);
        }
        if ($bon == '') {
            $select->where('EU_DETAIL_MF11000.num_bon like ?', '%');
        } else {
            $select->where('EU_DETAIL_MF11000.num_bon  like ?', $bon . '%');
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
            $date_app = new Zend_Date($row->DATE_MF11000, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->ID_MF11000;
            $responce['rows'][$i]['cell'] = array(
                $row->num_bon,
                $row->code_membre,
                $row->cel,
                $date_app->toString('dd/mm/yyyy'),
                $row->mont_apport,
                $row->pourcentage
            );
            $i++;
        }

        $this->view->data = $responce;
    }

    public function repartitionAction() {
        
    }

    public function detailrepAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
    }

    
    public function mfdetailrepAction() {
        $date_deb = $_GET["date_deb"];
        $date_fin = $_GET["date_fin"];
        $code_membre = $_GET["code_membre"];
        $bon = $_GET["bon"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", '10000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuRepartitionMf11000();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                //->join('eu_membre_fondateur11000', 'eu_membre_fondateur11000.num_bon like eu_repartition_mf11000.code_mf11000')
               ->where('EU_REPARTITION_MF11000.id_utilisateur = ?', $user->id_utilisateur)
               ->where('EU_REPARTITION_MF11000.payer = ?', 0)
               ->order('EU_REPARTITION_MF11000.date_rep desc')
               ->order('EU_REPARTITION_MF11000.ID_MF11000 desc');
        if ($date_deb == '' and $date_fin == '') {
            $daterep = '%';
            $select->where('EU_REPARTITION_MF11000.date_rep like ?', $daterep);
        }if ($date_deb == '' and $date_fin != '') {
            $date2 = explode("/", $date_fin);
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('EU_REPARTITION_MF11000.date_rep <= ?', $datefin);
        }if ($date_fin == '' and $date_deb != '') {
            $date1 = explode("/", $date_deb);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('EU_REPARTITION_MF11000.date_rep >= ?', $datedeb);
        }if ($date_fin != '' and $date_deb != '') {
            $date1 = explode("/", $date_deb);
            $date2 = explode("/", $date_fin);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('EU_REPARTITION_MF11000.date_rep >= ?', $datedeb);
            $select->where('EU_REPARTITION_MF11000.date_rep <= ?', $datefin);
        }
        if ($code_membre != '' and $bon == '') {
            $select->where('EU_REPARTITION_MF11000.code_membre like ?', $code_membre);
        }
        if ($bon != '' and $code_membre == '') {
            $select->where('EU_REPARTITION_MF11000.CODE_MF11000  like ?', $bon . '%');
        }
        if ($code_membre == '' and $bon == '') {
            //$select->where('eu_repartition_mf11000.code_membre like ?', '%');
            $select->where('EU_REPARTITION_MF11000.CODE_MF11000 like ?', '%');
            //$select->orwhere('eu_repartition_mf11000.code_membre is null');
        }
        if ($code_membre != '' and $bon != '') {
            $select->where('EU_REPARTITION_MF11000.code_membre like ?', $code_membre);
            $select->orwhere('EU_REPARTITION_MF11000.CODE_MF11000 like ?', $bon . '%');
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
        $totmont = 0;
        foreach ($agences as $row) {
            $totmont+=$row->mont_rep;
            $date_rep = new Zend_Date($row->date_rep, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_rep;
            $responce['rows'][$i]['cell'] = array(
                $row->CODE_MF11000,
                $row->code_membre,
                $date_rep->toString('dd/mm/yyyy'),
                $row->mont_rep
            );
            $i++;
        }
        $responce['userdata']['date_rep'] = 'Total:';
        $responce['userdata']['mont_recu'] = $totmont;
        $this->view->data = $responce;
    }

    public function datarepartitionAction() {

        if ($this->getRequest()->tranche == '') {
            $tranche = 1;
        } else {
            $tranche = $this->getRequest()->tranche;
        }
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuMembreFondateur11000();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->where('EU_MEMBRE_FONDATEUR11000.nb_repartition = ?', $tranche - 1)
               ->order('EU_MEMBRE_FONDATEUR11000.num_bon asc')
               ->order('EU_MEMBRE_FONDATEUR11000.nb_repartition asc');
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
            $responce['rows'][$i]['id'] = $row->num_bon;
            $responce['rows'][$i]['cell'] = array(
                $row->num_bon,
                $row->code_membre,
                strtoupper($row->nom),
                ucfirst($row->prenom),
                $row->nb_repartition,
                $row->solde,
                $row->cel
            );
            $i++;
        }
        $this->view->data = $responce;
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
        $mdmf = new Application_Model_EuDetailMf11000Mapper();
        $dom = new Application_Model_EuDomicilieMf11000();
        $mdom = new Application_Model_EuDomicilieMf11000Mapper();
        //$dod = new Application_Model_EuDetailDomicilieMf11000();
        $mdod = new Application_Model_EuDetailDomicilieMf11000Mapper();
        $rep = new Application_Model_EuRepartitionMf11000();
        $mrep = new Application_Model_EuRepartitionMf11000Mapper();
        $membre = new Application_Model_EuMembre;
        $membre_mapper = new Application_Model_EuMembreMapper();
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                //Récupération du montant sur le compte général MF11000
                $solde = 0;
                $requete = "select * from eu_compte_general where  code_compte='MF11000' and code_type_compte='nn' and service='e'";
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
                    $query = "update eu_compte_general  set solde =(solde - $mt_transfert)  where code_compte='MF11000' and code_type_compte='nn' and service='e'";
                    $db->query($query);
                    foreach ($selection as $sel) {
                        //Récupération de tous les placements effectués sur un compte MF11000
                        $findmf = $mdmf->findByNumerobon($sel['num_bon']);
                        if ($findmf != null) {
                            $nb_ddomi = count($findmf);
                            for ($j = 0; $j <= $nb_ddomi - 1; $j++) {
                                $mont = 0;
                                $montant_recu = 0;
                                $res_mf = $findmf[$j];
                                $mont = ($res_mf->getMont_apport() * $res_mf->getPourcentage()) / 100;
                                $montant_recu = $res_mf->getMont_apport() - $mont;
                                //Recherche des placements qui ont servi à une domiciliation
                                $id_mf11000 = $res_mf->getId_mf11000();
                                $code_proprio = $sel['code_membre'];
                                $code_apporteur = $res_mf->getCode_membre();
                                $find_dod = $mdod->findDetailDomi($id_mf11000);
                                if ($find_dod == false) {//Cas des placements qui ne sont liés à aucune domiciliation
                                    if ($code_proprio != $code_apporteur) {//Placement apporteur
                                        //Création de la part de l'apporteur
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_membre($code_apporteur);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($montant_recu);
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setId_reglt_mf(null);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        $resp = $membre_mapper->find($code_apporteur, $membre);
                                        if ($resp) {
                                            Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $montant_recu . " fcfa sur le compte MF11000 " . $code_apporteur);
                                        }
                                        //Création de la part du propriétaire du compte MF11000
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($mont);
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setId_reglt_mf(null);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        $resp = $membre_mapper->find($code_proprio, $membre);
                                        if ($resp) {
                                            Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $mont . " fcfa sur le compte MF11000 " . $code_proprio);
                                        }
                                    } else {//Placement propriétaire
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($res_mf->getMont_apport());
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setId_reglt_mf(null);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        $resp = $membre_mapper->find($code_proprio, $membre);
                                        if ($resp) {
                                            Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $res_mf->getMont_apport() . " fcfa sur le compte MF11000 " . $code_proprio);
                                        }
                                    }
                                } else {//Cas des placements qui sont liés à aucune domiciliation
                                    $nb_dom = count($find_dod);
                                    $sum = 0;
                                    for ($i = 0; $i <= $nb_dom - 1; $i++) {
                                        $res_dod = $find_dod[$i];
                                        $ret_dom = $mdom->find($res_dod->getId_domi(), $dom);
                                        if ($ret_dom) {
                                            if ($dom->getEtat_domi() != 1) {
                                                $mt_adomi = $dom->getMt_domiciliation();
                                                $mt_domi = $dom->getMt_domicilie();
                                                $new_domi = $mt_domi + $res_dod->getMt_domi_apport();
                                                if ($new_domi < $mt_adomi) {
                                                    $sum += $res_dod->getMt_domi_apport();
                                                    //Création de la part du bénéficiaire de la domiciliation
                                                    $rep->setId_mf11000($id_mf11000);
                                                    $rep->setCode_membre($dom->getCode_membre());
                                                    $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                                    $rep->setMont_rep($res_dod->getMt_domi_apport());
                                                    $rep->setId_utilisateur($user->id_utilisateur);
                                                    $rep->setId_reglt_mf(null);
                                                    $rep->setPayer(0);
                                                    $mrep->save($rep);
                                                    $resp = $membre_mapper->find($dom->getCode_membre(), $membre);
                                                    if ($resp) {
                                                        Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $res_dod->getMt_domi_apport() . " fcfa sur le compte MF11000 " . $dom->getCode_membre());
                                                    }
                                                    //Mise à jour de la table de domiciliation
                                                    $dom->setMt_domicilie($mt_domi + $res_dod->getMt_domi_apport());
                                                    $mdom->update($dom);
                                                } else {
                                                    $reste_domi = $mt_adomi - $mt_domi;
                                                    $sum += $reste_domi;
                                                    //Création de la part du bénéficiaire de la domiciliation
                                                    $rep->setId_mf11000($id_mf11000);
                                                    $rep->setCode_membre($dom->getCode_membre());
                                                    $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                                    $rep->setMont_rep($reste_domi);
                                                    $rep->setId_utilisateur($user->id_utilisateur);
                                                    $rep->setId_reglt_mf(null);
                                                    $rep->setPayer(0);
                                                    $mrep->save($rep);
                                                    $resp = $membre_mapper->find($dom->getCode_membre(), $membre);
                                                    if ($resp) {
                                                        Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $reste_domi . " fcfa sur le compte MF11000 " . $dom->getCode_membre());
                                                    }
                                                    //Mise à jour de la table de domiciliation
                                                    $dom->setMt_domicilie($mt_domi + $reste_domi);
                                                    $dom->setEtat_domi(1);
                                                    $mdom->update($dom);
                                                }
                                            }
                                            if ($res_dod->getReste_repartition() > 0) {
                                                //Mise à jour de la table eu_detail_domicilie_mf11000
                                                $id_domi = $res_dod->getId_domi();
                                                $query = "update eu_detail_domicilie_mf11000 set reste_repartition =(reste_repartition -1)  where id_domi='$id_domi' and id_mf11000='$id_mf11000'";
                                                $db->query($query);
                                            }
                                        }
                                    }
                                    //Création de la part de l'apporteur ayant fait des domiciliations
                                    if ($code_proprio != $code_apporteur) {
                                        if ($sum < $montant_recu) {//Placement apporteur
                                            $rep->setId_mf11000($id_mf11000);
                                            $rep->setCode_membre($code_apporteur);
                                            $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                            $rep->setMont_rep($montant_recu - $sum);
                                            $rep->setId_utilisateur($user->id_utilisateur);
                                            $rep->setId_reglt_mf(null);
                                            $rep->setPayer(0);
                                            $mrep->save($rep);
                                            $resp = $membre_mapper->find($code_apporteur, $membre);
                                            if ($resp) {
                                                Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $montant_recu - $sum . " fcfa sur le compte MF11000 " . $code_apporteur);
                                            }
                                        }
                                        //Création de la part du propriétaire du compte MF11000
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($mont);
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setId_reglt_mf(null);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        $resp = $membre_mapper->find($code_proprio, $membre);
                                        if ($resp) {
                                            Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $mont . " fcfa sur le compte marchand " . $code_proprio);
                                        }
                                    } else {//Placement propriétaire
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($res_mf->getMont_apport() - $sum);
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setId_reglt_mf(null);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        $resp = $membre_mapper->find($code_proprio, $membre);
                                        if ($resp) {
                                            Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de bénéficier d'un transfert de " . $res_mf->getMont_apport() - $sum . " fcfa sur le compte MF11000 " . $code_proprio);
                                        }
                                    }
                                }
                            }
                        }
                        //Mise à jour de la table eu_membre_fondateur11000
                        $num_bon = $sel['num_bon'];
                        $query = "update eu_membre_fondateur11000 set nb_repartition =(nb_repartition + 1)  where num_bon='$num_bon'";
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

    public function payerAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $mt_transfert = $_GET['mt_transfert'];
        $mdmf = new Application_Model_EuDetailMf11000Mapper();
        $dom = new Application_Model_EuDomicilieMf11000();
        $mdom = new Application_Model_EuDomicilieMf11000Mapper();
        $mdod = new Application_Model_EuDetailDomicilieMf11000Mapper();
        $rep = new Application_Model_EuRepartitionMf11000();
        $mrep = new Application_Model_EuRepartitionMf11000Mapper();
        $mf = new Application_Model_EuMembreFondateur11000();
        $mfm = new Application_Model_EuMembreFondateur11000Mapper();
        //$membre = new Application_Model_EuMembre;
        //$membre_mapper = new Application_Model_EuMembreMapper();
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
                $requete = "select * from eu_compte_general where  code_compte='fs' and code_type_compte='nn' and service='e'";
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
                    $query = "update eu_compte_general  set solde =(solde - $mt_transfert)  where code_compte='fs' and code_type_compte='nn' and service='e'";
                    $db->query($query);
                    foreach ($selection as $sel) {
                        $nb_rep = 0;
                        //Récupération des informations du membre fondateur
                        $find_mf = $mfm->find($sel['num_bon'], $mf);
                        if ($find_mf != false) {
                            $nb_rep = $mf->getNb_repartition() + 1;
                        }
                        //Récupération de tous les placements effectués sur un compte MF11000
                        $findmf = $mdmf->findByNumerobon($sel['num_bon']);
                        if ($findmf != null) {
                            $nb_ddomi = count($findmf);
                            for ($j = 0; $j <= $nb_ddomi - 1; $j++) {
                                $mont = 0;
                                $montant_recu = 0;
                                $res_mf = $findmf[$j];
                                $mont = ($res_mf->getMont_apport() * $res_mf->getPourcentage()) / 100;
                                $montant_recu = $res_mf->getMont_apport() - $mont;
                                //Recherche des placements qui ont servi à une domiciliation
                                $id_mf11000 = $res_mf->getId_mf11000();
                                $proprio = $res_mf->getProprietaire();
                                $code_mf_app = $res_mf->getNum_bon() . '-' . $res_mf->getCode_membre();
                                $code_mf_pro = $res_mf->getNum_bon();
                                $code_proprio = '';
                                if ($sel['code_membre'] != '') {
                                    $code_proprio = $sel['code_membre'];
                                } else {
                                    $code_proprio = null;
                                }
                                $code_apporteur = $res_mf->getCode_membre();
                                $find_dod = $mdod->findDetailDomi($id_mf11000);
                                if ($find_dod == false) {
								    //Cas des placements qui ne sont liés à aucune domiciliation
                                    if ($proprio == 0) {
									    //Placement apporteur
                                        //Création de la part de l'apporteur
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_mf11000($code_mf_app);
                                        $rep->setCode_membre($code_apporteur);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($montant_recu);
                                        $rep->setMont_reglt(0);
                                        $rep->setSolde_rep($montant_recu);
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        Util_Utils::addSms($res_mf->getCel(), "Vous venez de bénéficier d'un transfert de " . $montant_recu . " fcfa sur votre compte MF11000 " . $code_mf_app . " pour la tranche n° " . $nb_rep . ". Adressez-vous au pbf ou à un point d'enrôlement le plus proche muni de votre bon de souscription!!! Merci ");
                                        //Création ou mise à jour du compte nn de transfert du MF11000
                                        $code_compte = 'nn-tr-' . $code_mf_app;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                    ->setCode_membre($code_apporteur)
                                                    ->setCode_compte($code_compte)
                                                    ->setCode_type_compte('nn')
                                                    ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                    ->setDesactiver(0)
                                                    ->setLib_compte('Compte de recharge MF11000')
                                                    ->setSolde($montant_recu);
                                            $m_compte->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $montant_recu);
                                            $m_compte->update($compte);
                                        }
                                        //Création de la part du propriétaire du compte MF11000
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_mf11000($code_mf_pro);
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($mont);
                                        $rep->setMont_reglt(0);
                                        $rep->setSolde_rep($mont);
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        Util_Utils::addSms($sel['cel'], "Vous venez de bénéficier d'un transfert de " . $mont . " fcfa sur votre compte MF11000 " . $code_mf_pro . " pour la tranche n° " . $nb_rep . ". Adressez-vous au pbf ou à un point d'enrôlement le plus proche muni de votre bon de souscription !!! Merci ");
                                        //Création ou mise à jour du compte nn de transfert du MF11000
                                        $code_compte = 'nn-tr-' . $code_mf_pro;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                    ->setCode_membre($code_proprio)
                                                    ->setCode_compte($code_compte)
                                                    ->setCode_type_compte('nn')
                                                    ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                    ->setDesactiver(0)
                                                    ->setLib_compte('Compte de recharge MF11000')
                                                    ->setSolde($mont);
                                            $m_compte->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $mont);
                                            $m_compte->update($compte);
                                        }
                                    } else {
									    //Placement propriétaire
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_mf11000($code_mf_pro);
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($res_mf->getMont_apport());
                                        $rep->setMont_reglt(0);
                                        $rep->setSolde_rep($res_mf->getMont_apport());
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        Util_Utils::addSms($sel['cel'], "Vous venez de bénéficier d'un transfert de " . $res_mf->getMont_apport() . " fcfa sur votre compte MF11000 " . $code_mf_pro . " pour la tranche n° " . $nb_rep . ". Adressez-vous au pbf ou à un point d'enrôlement le plus proche muni de votre bon de souscription !!! Merci ");
                                        //Création ou mise à jour du compte nn de transfert du MF11000
                                        $code_compte = 'nn-tr-' . $code_mf_pro;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                    ->setCode_membre($code_proprio)
                                                    ->setCode_compte($code_compte)
                                                    ->setCode_type_compte('nn')
                                                    ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                    ->setDesactiver(0)
                                                    ->setLib_compte('Compte de recharge MF11000')
                                                    ->setSolde($res_mf->getMont_apport());
                                            $m_compte->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $res_mf->getMont_apport());
                                            $m_compte->update($compte);
                                        }
                                    }
                                } else {
								    // Cas des placements qui sont liés à une domiciliation
                                    $nb_dom = count($find_dod);
                                    $sum = 0;
                                    for ($i = 0; $i <= $nb_dom - 1; $i++) {
                                        $res_dod = $find_dod[$i];
                                        $ret_dom = $mdom->find($res_dod->getId_domi(), $dom);
                                        if ($ret_dom) {
                                            if ($dom->getEtat_domi() != 1) {
                                                $mt_adomi = $dom->getMt_domiciliation();
                                                $mt_domi = $dom->getMt_domicilie();
                                                $new_domi = $mt_domi + $res_dod->getMt_domi_apport();
                                                if ($new_domi < $mt_adomi) {
                                                    $sum += $res_dod->getMt_domi_apport();
                                                    //Création de la part du bénéficiaire de la domiciliation
                                                    $rep->setId_mf11000($id_mf11000);
                                                    $rep->setCode_mf11000($dom->getCode_membre());
                                                    $rep->setCode_membre($dom->getCode_membre());
                                                    $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                                    $rep->setMont_rep($res_dod->getMt_domi_apport());
                                                    $rep->setMont_reglt(0);
                                                    $rep->setSolde_rep($res_dod->getMt_domi_apport());
                                                    $rep->setId_utilisateur($user->id_utilisateur);
                                                    $rep->setPayer(0);
                                                    $mrep->save($rep);
                                                    Util_Utils::addSms($dom->getCel(), "Vous venez de bénéficier d'un transfert de " . $res_dod->getMt_domi_apport() . " fcfa sur votre compte MF11000 " . $dom->getCode_membre() . " pour la tranche n° " . $nb_rep . ". Adressez-vous au pbf ou à un point d'enrôlement le plus proche muni de votre bon de souscription !!! Merci ");
                                                    //Mise à jour de la table de domiciliation
                                                    $dom->setMt_domicilie($mt_domi + $res_dod->getMt_domi_apport());
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
                                                                ->setLib_compte('Compte de recharge MF11000')
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
                                                    $rep->setId_mf11000($id_mf11000);
                                                    $rep->setCode_mf11000($dom->getCode_membre());
                                                    $rep->setCode_membre($dom->getCode_membre());
                                                    $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                                    $rep->setMont_rep($reste_domi);
                                                    $rep->setMont_reglt(0);
                                                    $rep->setSolde_rep($reste_domi);
                                                    $rep->setId_utilisateur($user->id_utilisateur);
                                                    $rep->setPayer(0);
                                                    $mrep->save($rep);
                                                    Util_Utils::addSms($dom->getCel(), "Vous venez de bénéficier d'un transfert de " . $reste_domi . " fcfa sur votre compte MF11000 " . $dom->getCode_membre() . " pour la tranche n° " . $nb_rep . ". Adressez-vous au pbf ou à un point d'enrôlement le plus proche muni de votre bon de souscription !!! Merci ");
                                                    //Mise à jour de la table de domiciliation
                                                    $dom->setMt_domicilie($mt_domi + $reste_domi);
                                                    $dom->setEtat_domi(1);
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
                                                                ->setLib_compte('Compte de recharge MF11000')
                                                                ->setSolde($reste_domi);
                                                        $m_compte->save($compte);
                                                    } else {
                                                        $compte->setSolde($compte->getSolde() + $reste_domi);
                                                        $m_compte->update($compte);
                                                    }
                                                }
                                            }
                                            if ($res_dod->getReste_repartition() > 0) {
                                                //Mise à jour de la table eu_detail_domicilie_mf11000
                                                $id_domi = $res_dod->getId_domi();
                                                $query = "update eu_detail_domicilie_mf11000 set reste_repartition =(reste_repartition -1)  where id_domi='$id_domi' and id_mf11000='$id_mf11000'";
                                                $db->query($query);
                                            }
                                        }
                                    }
                                    //Création de la part de l'apporteur ayant fait des domiciliations
                                    if ($proprio == 0) {
                                        if ($sum < $montant_recu) {//Placement apporteur
                                            $rep->setId_mf11000($id_mf11000);
                                            $rep->setCode_mf11000($code_mf_app);
                                            $rep->setCode_membre($code_apporteur);
                                            $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                            $rep->setMont_rep($montant_recu - $sum);
                                            $rep->setMont_reglt(0);
                                            $rep->setSolde_rep($montant_recu - $sum);
                                            $rep->setId_utilisateur($user->id_utilisateur);
                                            $rep->setPayer(0);
                                            $mrep->save($rep);
                                            Util_Utils::addSms($res_mf->getCel(), "Vous venez de bénéficier d'un transfert de " . $montant_recu - $sum . " fcfa sur votre compte MF11000 " . $code_mf_app . " pour la tranche n° " . $nb_rep . ". Adressez-vous au pbf ou à un point d'enrôlement le plus proche muni de votre bon de souscription !!! Merci ");
                                            //Création ou mise à jour du compte nn de transfert du MF11000
                                            $code_compte = 'nn-tr-' . $code_mf_app;
                                            $ret_req = $m_compte->find($code_compte, $compte);
                                            if ($ret_req == false) {
                                                $compte->setCode_cat('tr')
                                                        ->setCode_membre($code_apporteur)
                                                        ->setCode_compte($code_compte)
                                                        ->setCode_type_compte('nn')
                                                        ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                        ->setDesactiver(0)
                                                        ->setLib_compte('Compte de recharge MF11000')
                                                        ->setSolde($montant_recu - $sum);
                                                $m_compte->save($compte);
                                            } else {
                                                $compte->setSolde($compte->getSolde() + $montant_recu - $sum);
                                                $m_compte->update($compte);
                                            }
                                        }
                                        //Création de la part du propriétaire du compte MF11000
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_mf11000($code_mf_pro);
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($mont);
                                        $rep->setMont_reglt(0);
                                        $rep->setSolde_rep($mont);
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        Util_Utils::addSms($sel['cel'], "Vous venez de bénéficier d'un transfert de " . $mont . " fcfa sur votre compte MF11000 " . $code_mf_pro . " pour la tranche n° " . $nb_rep . ". Adressez-vous au pbf ou à un point d'enrôlement le plus proche muni de votre bon de souscription !!! Merci ");
                                        //Création ou mise à jour du compte nn de transfert du MF11000
                                        $code_compte = 'nn-tr-' . $code_mf_pro;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                    ->setCode_membre($code_proprio)
                                                    ->setCode_compte($code_compte)
                                                    ->setCode_type_compte('nn')
                                                    ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                    ->setDesactiver(0)
                                                    ->setLib_compte('Compte de recharge MF11000')
                                                    ->setSolde($mont);
                                            $m_compte->save($compte);
                                        } else {
                                            $compte->setSolde($compte->getSolde() + $mont);
                                            $m_compte->update($compte);
                                        }
                                    } else {
									    //Placement propriétaire
                                        $rep->setId_mf11000($id_mf11000);
                                        $rep->setCode_mf11000($code_mf_pro);
                                        $rep->setCode_membre($code_proprio);
                                        $rep->setDate_rep($date_idd->toString('yyyy-mm-dd'));
                                        $rep->setMont_rep($res_mf->getMont_apport() - $sum);
                                        $rep->setMont_reglt(0);
                                        $rep->setSolde_rep($res_mf->getMont_apport() - $sum);
                                        $rep->setId_utilisateur($user->id_utilisateur);
                                        $rep->setPayer(0);
                                        $mrep->save($rep);
                                        Util_Utils::addSms($sel['cel'], "Vous venez de bénéficier d'un transfert de " . $res_mf->getMont_apport() - $sum . " fcfa sur votre compte MF11000 " . $code_mf_pro . " pour la tranche n° " . $nb_rep . ". Adressez-vous au pbf ou à un point d'enrôlement le plus proche muni de votre bon de souscription !!! Merci ");
                                        //Création ou mise à jour du compte nn de transfert du MF11000
                                        $code_compte = 'nn-tr-' . $code_mf_pro;
                                        $ret_req = $m_compte->find($code_compte, $compte);
                                        if ($ret_req == false) {
                                            $compte->setCode_cat('tr')
                                                    ->setCode_membre($code_proprio)
                                                    ->setCode_compte($code_compte)
                                                    ->setCode_type_compte('nn')
                                                    ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                                                    ->setDesactiver(0)
                                                    ->setLib_compte('Compte de recharge MF11000')
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
                        //Mise à jour de la table eu_membre_fondateur11000
                        $num_bon = $sel['num_bon'];
                        $query = "update eu_membre_fondateur11000 set nb_repartition =(nb_repartition + 1)  where num_bon='$num_bon'";
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

}

?>