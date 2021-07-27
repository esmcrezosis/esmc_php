<?php

class EuFsMf11000Controller extends Zend_Controller_Action {

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-fs-mf11000/new \">Nouveau</a></li>
             <li><a href=\" /eu-fs-mf11000/index \">Ressources créées</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'dg' && $group != 'agregat') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {

        $date_deb = $_GET["date_deb"];
        $date_fin = $_GET["date_fin"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'date_op');
        $sord = $this->_request->getParam("sord", 'desc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $select = $tabela->select();
        $select->setIntegrityCheck(false);
        $select->where('eu_operation.id_utilisateur = ?', $user->id_utilisateur);
        //$select->where('eu_operation.code_membre = ?', $user->code_membre);
        if ($date_deb == '' and $date_fin == '') {
            $datedeb = '%';
            $select->where('eu_operation.date_op like ?', $datedeb);
        } else if ($date_deb == '') {
            $date2 = explode("/", $date_fin);
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('eu_operation.date_op <= ?', $datefin);
        } else if ($date_fin == '') {
            $date1 = explode("/", $date_deb);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->where('eu_operation.date_op >= ?', $datedeb);
        } else {
            $date1 = explode("/", $date_deb);
            $date2 = explode("/", $date_fin);
            $datedeb = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $datefin = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $select->where('eu_operation.date_op >= ?', $datedeb);
            $select->where('eu_operation.date_op <= ?', $datefin);
        }
        $select->where('type_op = ?', 'cfs');
        $select->order('id_operation', 'asc');
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
        $totmont = 0;
        foreach ($alloc as $row) {
            $totmont+=$row->montant_op;
            $date_op = new Zend_Date($row->date_op, Zend_Date::ISO_8601);
            $heure_op = new Zend_Date($row->heure_op, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->code_membre,
                'nn',
                $date_op->toString('dd/mm/yyyy'),
                $heure_op->toString('hh:mm'),
                $row->montant_op
            );
            $i++;
        }
        $responce['userdata']['heure_op'] = 'Total:';
        $responce['userdata']['mt_transfert'] = $totmont;
        $this->view->data = $responce;
    }

    public function newAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuFsMf11000();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    //Enregistrement dans la table eu_compte_general
                    $mapper = new Application_Model_EuCompteGeneralMapper();
                    $cat = new Application_Model_EuCompteGeneral($form->getValues());
                    $num_compte = 'fs';
                    $code_type = $this->_request->getPost("code_type_compte");
                    $service = 'e';
                    $find_fs = $mapper->find($num_compte, $code_type, $service, $cat);
                    if ($find_fs == false) {
                        $cat->setCode_compte('fs');
                        $cat->setService('e');
                        $cat->setIntitule('fs MF11000');
                        $mapper->save($cat);
                    } else {
                        //Mise à jour du compte fs
                        $cat->setSolde($cat->getSolde() + $this->_request->getPost("solde"));
                        $mapper->update($cat);
                    }
                    //Enregistrement dans la table opération
                    $mop = New Application_Model_EuOperationMapper();
                    $op = new Application_Model_EuOperation();
                    $date = new Zend_Date(Zend_Date::ISO_8601);
                    $date_op = clone $date;
                    $compteur = $mop->findConuter() + 1;
                    $op->setId_operation($compteur)
                            ->setDate_op($date_op->toString('yyyy-mm-dd'))
                            ->setHeure_op($date_op->toString('hh:mm'))
                            ->setId_utilisateur($user->id_utilisateur)
                            ->setCode_membre($user->code_membre)
                            ->setMontant_op($this->_request->getPost("solde"))
                            ->setCode_produit('fs')
                            ->setLib_op('Création de fs par la source')
                            ->setType_op('cfs')
                            ->setCode_cat('tfs');
                    $mop->save($op);
                    $db->commit();
                    return $this->_helper->redirector('index');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ' ' . $exc->getTraceAsString();
                    $this->view->message = $message;
                    $this->view->form = $form;
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-fs-mf11000',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

}