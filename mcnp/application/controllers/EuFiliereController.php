<?php

class EuFiliereController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'gac' || $group == 'gacp' || $group == 'gacex' || $group == 'gacsu' || $group == 'gacse' 
                || $group == 'gacr' || $group == 'gacs' || $group == 'gaca' || $group == 'admin' || $group == 'gac_pbf' 
                || $group == 'gacp_pbf' || $group == 'gacex_pbf' || $group == 'gacsu_pbf' || $group == 'gacse_pbf'  || $group == 'mise_chaine'
                || $group == 'gacr_pbf' || $group == 'gacs_pbf' || $group == 'gaca_pbf' || $group == 'mise_chaine' || $group == 'creneau' || $group == 'filiere') {
            $menu = "<li><a href=\" /eu-filiere/new \" style=\"font-size:9px\">Nouveau</a></li>";
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
            if ($group != 'gac' && $group != 'gacp' && $group != 'gacex' && $group != 'gacsu' && $group != 'gacse' 
                    && $group != 'gacr' && $group != 'gacs' && $group != 'gaca' && $group != 'admin' && $group != 'gac_pbf' 
                    && $group != 'gacp_pbf' && $group != 'gacex_pbf' && $group != 'gacsu_pbf' && $group != 'gacse_pbf' and  $group != 'filiere' 
                    && $group != 'gacr_pbf' && $group != 'gacs_pbf' && $group != 'gaca_pbf' && $group != 'mise_chaine' && $group != 'creneau' and  $group != 'filiere') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function dataAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_filiere');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuFiliere();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
               ->from('eu_filiere');
        $fils = $tabela->fetchAll($select);
        $count = count($fils);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $fils = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($fils as $row) {
		    $datecreation = new Zend_Date($row->date_creation);
            $responce['rows'][$i]['id'] = $row->id_filiere;
            $responce['rows'][$i]['cell'] = array(
               $row->id_filiere,
               ucfirst($row->nom_filiere),
               ucfirst($row->descrip_filiere),
               $datecreation->toString('dd/MM/yyyy'),
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $f = new Application_Model_EuFiliere();
        $mf = new Application_Model_EuFiliereMapper();
        $oper = $this->_request->getPost("oper");
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($oper == "edit") {
            $mf->find($this->getRequest()->getPost("id_filiere"), $f);
            $f->setNom_filiere($this->_request->getPost("nom_filiere"));
            $f->setDescrip_filiere($this->_request->getPost("descrip_filiere"));
            $f->setId_utilisateur($user->id_utilisateur);
            $f->setDate_creation($date_id->toString('yyyy-mm-dd'));
            $mf->update($f);
        } elseif ($oper == "add") {
            $f->setNom_filiere($this->_request->getPost("nom_filiere"));
            $f->setDescrip_filiere($this->_request->getPost("descrip_filiere"));
            $f->setId_utilisateur($user->id_utilisateur);
            $f->setDate_creation($date_id->toString('yyyy-mm-dd'));
            $mf->save($f);
        }
    }

    public function newAction() {
         // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $form = new Application_Form_EuFiliere();
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
        if ($this->getRequest()->isPost()) {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                if ($form->isValid($request->getPost())) {
                    $mapper = new Application_Model_EuFiliereMapper();
				    $find_division = $mapper->findByDivision($this->_request->getPost("code_division"));
				    if($find_division != false) {
				        $db->rollback();
                        $message = 'Ce code division saisi existe deja';
                        //$message = 'Vérifiez votre saisie';
                        $this->view->message = $message;
					    $this->view->form = $form;
					    return;
				    }
                    $cat = new Application_Model_EuFiliere($form->getValues());
                    $count=$mapper->findConuter() + 1;
                    $cat->setId_filiere($count);
                    $cat->setDate_creation($date_fin->toString('yyyy-MM-dd'));
                    $cat->setId_utilisateur($user->id_utilisateur);
                    $mapper->save($cat);
					$db->commit();
                    return $this->_helper->redirector('index');
                }
			} catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    //$message = 'Vérifiez votre saisie';
                    $this->view->message = $message;
				    return;
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('".$this->view->url(array('controller' => 'eu-filiere','action' => 'index'), 'default', true) ."','_self')");
        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuFiliere();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $fil = new Application_Model_EuFiliere($form->getValues());
                    $fil->setDate_creation($date_creation->toString('yyyy-mm-dd'));
                    $fil->setId_filiere($this->_request->getPost("id_filiere"));
                    $fil->setNom_filiere($this->_request->getPost("nom_filiere"));
                    $fil->setDescrip_filiere($this->_request->getPost("descrip_filiere"));
                    $fil->setId_utilisateur($user->id_utilisateur);
                    $mapper = new Application_Model_EuFiliereMapper();
                    $mapper->update($fil);
                    $db->commit();
                    return $this->_helper->redirector('index');
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        } else {
            $id_filiere = $request->id_filiere;
            $mapper = new Application_Model_EuFiliereMapper();
            $fil = new Application_Model_EuFiliere();
            $mapper->find($id_filiere, $fil);
            if ($fil->getId_filiere() == $id_filiere) {
                $data = array(
                    'id_filiere' => $id_filiere,
                    'nom_filiere' => $fil->getNom_filiere(),
                    'descrip_filiere' => $fil->getDescrip_filiere(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-filiere',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

}

?>
