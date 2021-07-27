<?php

class EuCompteGeneralController extends Zend_Controller_Action {

    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-compte-general/new \">Nouveau</a></li>
             <li><a href=\" /eu-compte-general/transfert \">Virement</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'compta' && $group != 'dg') {
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

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_compte');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCompteGeneral();
        $compte_gene = $tabela->fetchAll();
        $count = count($compte_gene);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $compte_gene = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($compte_gene as $row) {
            if ($row->service == 's') {
                $serv = 'Sortie';
            } else if ($row->service == 'e') {
                $serv = 'Entrée';
            }
            $responce['rows'][$i]['id'] = $row->code_compte;
            $responce['rows'][$i]['cell'] = array(
                $row->code_compte,
                $row->code_type_compte,
                $serv,
                $row->intitule,
                $row->solde
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $z = new Application_Model_EuCompteGeneral();
        $mz = new Application_Model_EuCompteGeneralMapper();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit") {
            $z->setNum_compte($this->_request->getPost("num_compte"));
            $z->setService($this->_request->getPost("service"));
            $z->setIntitule($this->_request->getPost("intitule"));
            $z->setCredit($this->_request->getPost("credit"));
            $z->setDebit($this->_request->getPost("debit"));
            $z->setSolde($this->_request->getPost("solde"));
            $z->setCode_type($this->_request->getPost("code_type"));
            $mz->update($z);
        } elseif ($oper == "add") {
            $z->setNum_compte($this->_request->getPost("num_compte"));
            $z->setService($this->_request->getPost("service"));
            $z->setIntitule($this->_request->getPost("intitule"));
            $z->setCredit($this->_request->getPost("credit"));
            $z->setDebit($this->_request->getPost("debit"));
            $z->setSolde($this->_request->getPost("solde"));
            $z->setCode_type($this->_request->getPost("code_type"));
            $mz->save($z);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("num_compte");
            $mz->delete($id);
        }
    }

    public function transfertAction() {
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($request->isPost()) {
            $code_type = $request->type_compte;
            $compte_source = $request->compte_source;
            $compte_dest = $request->compte_dest;
            $recu = $request->code_recu;
            $montant = $request->mont_transfert;
            $cg = new Application_Model_EuCompteGeneral();
            $cg_mapper = new Application_Model_EuCompteGeneralMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $date = Zend_Date::now();
            $db->beginTransaction();
            try {
                $ret = $cg_mapper->find($compte_source, $code_type, 'e', $cg);
                if ($ret) {
                    if ($cg->getSolde() >= $montant) {
                        $cg_dest = new Application_Model_EuCompteGeneral();
                        $res1 = $cg_mapper->find($compte_dest, $code_type, 'e', $cg_dest);
                        if ($res1) {
                            $cg->setSolde($cg->getSolde() - $montant);
                            $cg_mapper->update($cg);
                            $cg_dest->setSolde($cg_dest->getSolde() + $montant);
                            $cg_mapper->update($cg_dest);
                            $op = new Application_Model_EuOperation();
                            $op_mapper = new Application_Model_EuOperationMapper();
                            $op->setCode_cat(null)
                                    ->setCode_membre($user->code_membre)
                                    ->setCode_produit(null)
                                    ->setDate_op($date->toString('yyyy-mm-dd'))
                                    ->setHeure_op($date->toString('hh:mm:ss'))
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setLib_op('Virement de fonds par reçu n° ' . $recu)
                                    ->setMontant_op($montant)
                                    ->setType_op('vf');
                            $op_mapper->save($op);
                        } else {
                            $db->rollback();
                            $this->view->message = 'Compte destination ' . $compte_dest . ' n\'existe pas!!!';
                            $this->view->compte_source = $compte_source;
                            $this->view->compte_dest = $compte_dest;
                            $this->view->type_compte = $code_type;
                            $this->view->mont_transfert = $montant;
                            $this->view->code_recu = $recu;
                            return;
                        }
                    } else {
                        $db->rollback();
                        $this->view->message = 'Le solde du Compte source ' . $compte_source . ' est insuffisant!!!';
                        $this->view->compte_source = $compte_source;
                        $this->view->compte_dest = $compte_dest;
                        $this->view->type_compte = $code_type;
                        $this->view->mont_transfert = $montant;
                        $this->view->code_recu = $recu;
                        return;
                    }
                } else {
                    $db->rollback();
                    $this->view->message = 'Compte source ' . $compte_source . ' n\'existe pas!!!';
                    $this->view->compte_source = $compte_source;
                    $this->view->compte_dest = $compte_dest;
                    $this->view->type_compte = $code_type;
                    $this->view->mont_transfert = $montant;
                    $this->view->code_recu = $recu;
                    return;
                }
                $db->commit();
                $this->view->message = 'Le virement de '.$montant.' du compte ' . $compte_source . ' au compte '.$compte_dest.' a été effectué avec succès!!!';
                return;
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . '->' . $exc->getTraceAsString();
                $this->view->compte_source = $compte_source;
                $this->view->compte_dest = $compte_dest;
                $this->view->type_compte = $code_type;
                $this->view->mont_transfert = $montant;
                $this->view->code_recu = $recu;
                return;
            }
        }
    }

    public function cgAction() {
        $cg_map = new Application_Model_EuCompteGeneralMapper();
        $rows = $cg_map->fetchAll();
        $cgs = array();
        foreach ($rows as $c) {
            $cgs[0][] = $c->getCode_compte();
            $cgs[1][] = $c->getIntitule();
        }
        $this->view->data = $cgs;
    }

    public function typeAction() {
        $cg_map = new Application_Model_EuTypeCompteMapper();
        $rows = $cg_map->fetchAll();
        $cgs = array();
        foreach ($rows as $c) {
            $cgs[0][] = $c->getCode_type_compte();
            $cgs[1][] = $c->getDesc_type();
        }
        $this->view->data = $cgs;
    }

    public function comptesAction() {
        $code_type = $_GET["code"];
        if ($code_type != '') {
            $db_compte_gene = new Application_Model_DbTable_EuCompteGeneral();
            $select = $db_compte_gene->select();
            $select->where('code_type_compte like ?', $code_type);
            $results = $db_compte_gene->fetchAll($select);
            if (count($results) > 0) {
                $types = array();
                foreach ($results as $value) {
                    $types[0][] = $value->code_compte;
                    $types[1][] = $value->intitule;
                }
                $this->view->data = $types;
            } else {
                $this->view->data = false;
            }
        }
    }

    public function newAction() {

        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuCompteGeneral();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $cat = new Application_Model_EuCompteGeneral($form->getValues());
                $mapper = new Application_Model_EuCompteGeneralMapper();
                $mapper->save($cat);
                return $this->_helper->redirector('index');
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-compte-general',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        // action body
    }

    public function deleteAction() {
        // action body
    }

}