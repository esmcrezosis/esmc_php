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
class EuDomiciliationMfController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'mf') {
            $menu = "<li><a href=\"/eu-domiciliation-mf/domicilier \">Domiciliation</a></li>" .
                    "<li><a href=\"/eu-domiciliation-mf/index\">Liste domiciliations</a></li>".
                    "<li><a href=\"/eu-domiciliation-mf/reglement\">Règlement</a></li>" .
                    "<li><a href=\"/eu-domiciliation-mf/listreglt\">Liste des règlements</a></li>";
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
            if ($group != 'mf') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'date_domi');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuDomicilieMf11000();
        $select = $tabela->select();
        $select->where('eu_domicilie_mf11000.id_utilisateur = ?', $user->id_utilisateur)
                ->order('eu_domicilie_mf11000.date_domi', 'desc');
        $domici = $tabela->fetchAll($select);
        $count = count($domici);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $domici = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($domici as $row) {
            $date_domi = new Zend_Date($row->date_domi, Zend_Date::ISO_8601);
            $heure_domi = new Zend_Date($row->heure_domi, Zend_Date::ISO_8601);
            if ($row->etat_domi == 0) {
                $accord = 'En cours';
            } else {
                $accord = 'Terminer';
            }
            $responce['rows'][$i]['id'] = $row->id_domi;
            $responce['rows'][$i]['cell'] = array(
                $row->id_domi,
                $row->code_membre,
                $row->mt_domiciliation,
                $row->mt_domicilie,
                $date_domi->toString('dd/mm/yyyy'),
                $heure_domi->toString('hh:mm'),
                $accord,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function newAction() {
        $form = new Application_Form_EuDomiciliation();
        $this->view->form = $form;
    }

    public function domicilierAction() {
        
    }

    public function creditsAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'num_bon');
        $sord = $this->_request->getParam("sord", 'asc');
        //Récupération du nombre total de répartition pr les MF11000 dans la table paramètres
        $param = new Application_Model_EuParametresMapper();
        $para = new Application_Model_EuParametres();
        $nb_mf = 0;
        $find_para = $param->find('mf11000', 'valeur', $para);
        if ($find_para == true) {
            $nb_mf = $para->getMontant();
        }
        $tabela = new Application_Model_DbTable_EuDetailMf11000();
        $tab_clt = array('');
        if ($_GET['lignes'] != '') {
            $client = $_GET['lignes'];
            $tab_clt = explode(",", $client);
        }
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('d' => 'eu_detail_mf11000'), array('id_mf11000', 'num_bon', 'code_membre', 'mont_apport', 'pourcentage'))
                ->join(array('m' => 'eu_membre_fondateur11000'), 'm.num_bon = d.num_bon', array('nb_repartition'))
                ->where('d.id_utilisateur = ?', $user->id_utilisateur)
                ->where('d.code_membre in (?)', $tab_clt)
                ->order('d.num_bon asc')
                ->order('d.code_membre asc');
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
            //recupération du cumul des montant déjà domicilié sur un apport
            $cumul_domi = 0;
            $tdd = new Application_Model_DbTable_EuDetailDomicilieMf11000();
            $sdd = $tdd->select();
            $sdd->from($tdd, array('sum(mt_domi_apport) as total, reste_repartition as nb_rep'))
                    ->where('id_mf11000 = ?', $row->id_mf11000)
                    ->where('reste_repartition > ?', 0);
            $results = $tdd->fetchAll($sdd);
            if (count($results) > 0) {
                $ligne = $results->current();
                $cumul_domi = $ligne->total;
            }
            $mt_reste = $row->mont_apport - (($row->mont_apport * $row->pourcentage) / 100);

            $responce['rows'][$i]['id'] = $row->id_mf11000;
            $responce['rows'][$i]['cell'] = array(
                $row->id_mf11000,
                $row->num_bon,
                $row->code_membre,
                $row->mont_apport,
                $row->pourcentage,
                $mt_reste - $cumul_domi,
                $nb_mf - $row->nb_repartition,
                $nb_mf - $row->nb_repartition,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listcreditsAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 30);
        $sidx = $this->_request->getParam("sidx", 'code_membre');
        $sord = $this->_request->getParam("sord", 'asc');
        $request = $this->getRequest();
        $id_domi = $request->id_domi;
        $tabela = new Application_Model_DbTable_EuDetailDomicilieMf11000();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
                ->from(array('d' => 'eu_detail_domicilie_mf11000'), array('id_mf11000', 'mont' => 'mt_domi_apport', 'nb_repartition', 'reste_repartition'))
                ->join(array('c' => 'eu_detail_mf11000'), 'c.id_mf11000 = d.id_mf11000', array('code_membre'))
                ->where('d.id_domi = ?', $id_domi);
        $alloc = $tabela->fetchAll($select);
        $count = count($alloc);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $alloc = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($alloc as $row) {
            $responce['rows'][$i]['id'] = $row->id_mf11000;
            $responce['rows'][$i]['cell'] = array(
                $row->id_mf11000,
                $row->code_membre,
                $row->mont,
                $row->nb_repartition,
                $row->reste_repartition
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function createAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $selection = array();
        $selection = $_GET['lignes'];
        $mt_domici = $_GET['mt_domici'];
        $benef = $_GET['benef'];
        $mdomi = New Application_Model_EuDomicilieMf11000Mapper();
        $domi = new Application_Model_EuDomicilieMf11000();
        $mddomi = New Application_Model_EuDetailDomicilieMf11000Mapper();
        $ddomi = new Application_Model_EuDetailDomicilieMf11000();

        $date = new Zend_Date(Zend_Date::ISO_8601);
        $date_domi = clone $date;
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Calcul du montant total de la domiciliation
                $mt_totdomi = 0;
                $mt_reste = 0;
                $nb_periode = 0;
                foreach ($selection as $val) {
                    //recupération du cumul des montant déjà domicilié sur un apport
                    $cumul_domi = 0;
                    $tdd = new Application_Model_DbTable_EuDetailDomicilieMf11000();
                    $sdd = $tdd->select();
                    $sdd->from($tdd, array('sum(mt_domi_apport) as total, reste_repartition as nb_rep'))
                            ->where('id_mf11000 = ?', $val['id_mf'])
                            ->where('reste_repartition > ?', 0);
                    $results = $tdd->fetchAll($sdd);
                    if (count($results) > 0) {
                        $ligne = $results->current();
                        $cumul_domi = $ligne->total;
                    }
                    $mt_reste = ($val['mont_apport'] - (($val['mont_apport'] * $val['quota']) / 100)) - $cumul_domi;
                    $nb_periode = $val['nb_init'];
                    //Traitement des montants domicilié supérieur à celui de l'apport
                    if ($val['mont_domi'] <= $mt_reste) {
                        $mt_cred = $val['mont_domi'];
                    } else {
                        $mt_cred = $mt_reste;
                    }
                    //Traitement du nb restant de répartitions
                    if ($val['repartition'] <= $nb_periode) {
                        $nb_reparti = $val['repartition'];
                    } else {
                        $nb_reparti = $nb_periode;
                    }
                    $mt_credit = $mt_cred * $nb_reparti;
                    $mt_totdomi+=$mt_credit;
                }
                //Contrôle du montant total à domicilié par rapport au motant de la domiciliation
                if ($mt_domici > $mt_totdomi) {
                    $this->view->data = 'err_domici';
                    return;
                } else {
                    //Enregistrement dans la table de domiciliation_mf11000
                    $compteur = 0;
                    $compteur = $mdomi->findConuter() + 1;
                    $domi->setId_domi($compteur);
                    $domi->setCode_membre($benef);
                    $domi->setMt_domiciliation($mt_domici);
                    $domi->setMt_domicilie(0);
                    $domi->setEtat_domi(0);
                    $domi->setDate_domi($date_domi->toString('yyyy-mm-dd'));
                    $domi->setHeure_domi($date_domi->toString('hh:mm'));
                    $domi->setId_utilisateur($user->id_utilisateur);
                    $mdomi->save($domi);
                    //Enregistrement dans la table detail_domicilie_mf11000
                    foreach ($selection as $tab) {
                        $ddomi->setId_domi($compteur);
                        $ddomi->setId_mf11000($tab['id_mf']);
                        $ddomi->setMt_domi_apport($tab['mont_domi']);
                        $ddomi->setNb_repartition($tab['repartition']);
                        $ddomi->setReste_repartition($tab['repartition']);
                        $mddomi->save($ddomi);
                    }
                }
                $db->commit();
                $this->view->data = 'good';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                $this->view->data = 'bad';
                return;
            }
        }
    }

    public function changeAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuDetailMf11000();
        $select = $mb->select();
        $select->where('code_membre is not null');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function changemoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $select->where('type_membre=?', 'm');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function recupnom2Action() {
        $request = $this->getRequest();
        $num_membre = $request->code_membre;
        $membre = new Application_Model_DbTable_EuMembre;
        $select = $membre->select();
        $select->from($membre, array('nom_membre', 'prenom_membre'));
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

        $membre = $this->getRequest()->membre;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'id_mf11000');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuMembre();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join('eu_repartition_mf11000', 'eu_repartition_mf11000.code_membre = eu_membre.code_membre')
                ->where('eu_repartition_mf11000.code_membre =?', $membre)
                ->where('eu_repartition_mf11000.payer =?', 0);
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
                $row->code_membre,
                $row->date_rep,
                $row->mont_rep,
                $row->id_rep,
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
        $mt_transfert = $_GET['mt_transfert'];
        $reglt_mf = new Application_Model_EuReglementMf();
        $reglt_mapper = new Application_Model_EuReglementMfMapper();
        if (count($selection) > 0) {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $code_membre = '';
                foreach ($selection as $sel) {
                    $code_membre = $sel['code_membre'];
                }
                $reglt_mf->setMont_reglt_mf($mt_transfert);
                $reglt_mf->setCode_membre($code_membre);
                $reglt_mf->setDate_reglt_mf($date_idd->toString('yyyy-mm-dd'));
                $reglt_mf->setId_utilisateur($user->id_utilisateur);
                $reglt_mf->setType_mf('MF11000');
                $reglt_mapper->save($reglt_mf);

                $maxreglt = $reglt_mapper->findMaxReglt();
                foreach ($selection as $sel) {
                    $id_rep = $sel['id_rep'];
                    $query = "update eu_repartition_mf11000  set  payer =(1),id_reglt_mf=$maxreglt  where id_rep='$id_rep'";
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

    public function listregltAction() {
        
    }

    public function listingregltAction() {
        $date_deb = $_GET["date_deb"];
        $date_fin = $_GET["date_fin"];
        $code_membre = $_GET["code_membre"];
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

}

?>
