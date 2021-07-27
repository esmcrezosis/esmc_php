<?php
class EuTypeCompteController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-type-compte/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }
	
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'agregat'  && $group != 'dg') {
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
    
	
	public function newAction() {
	    
	  // action body
          $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
          $users = $auth->getIdentity();
          $request = $this->getRequest();
          $form = new Application_Form_EuTypeCompte();
		  // Add the link to the cancel button
          $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-type-compte',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

          $this->view->form = $form;
		  
	  if ($this->getRequest()->isPost()) {
		  
             if ($form->isValid($request->getPost())) {	  
	        $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
	          $compte = new Application_Model_EuTypeCompte($form->getValues());
                  //Contr�le de l'existence des doublons
                  $tcompte = new Application_Model_DbTable_EuTypeCompte();
                  $c_find = $tcompte->find($compte->getCode_type_compte());
                  if (count($c_find) == 1) {
				  
                    $message = 'Ce code type compte existe deja.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
					
                } 
                else {	
                    $mapper = new Application_Model_EuTypeCompteMapper();
                    $mapper->save($compte);
		    $db->commit();
                    return $this->_helper->redirector('index');   
	         }
	      }
	       catch (Exception $exc) {
               $db->rollback();
               $message = 'Echec enr�gistrement';
               $this->view->message = $message;
               return;
          }
	}
      } 
}
	
    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_type_compte');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuTypeCompte();
        $type_compte = $tabela->fetchAll();
        $count = count($type_compte);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;

        $type_compte = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($type_compte as $row) {
            $responce['rows'][$i]['id'] = $row->code_type_compte;
            $responce['rows'][$i]['cell'] = array(
                $row->code_type_compte,
                $row->lib_type,
                $row->desc_type,
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function editAction() {
	 
	// action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuTypeCompte();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
	// action body
        if ($this->getRequest()->isPost()) {
              $this->_helper->layout->enableLayout();
              if ($form->isValid($request->getPost())) {
	          $db = Zend_Db_Table::getDefaultAdapter();
                  $db->beginTransaction();
                  try {
		       $compte = new Application_Model_EuTypeCompte($form->getValues());
                       $compte->setCode_type_compte($this->_request->getPost("code_type_compte"));
                       $mapper = new Application_Model_EuTypeCompteMapper();
                       $mapper->update($compte);
		       $db->commit();
                       return $this->_helper->redirector('index');
                       $this->view->form = $form;  
		   }
		    catch (Exception $exc) {
                    $db->rollback();
                    $message = 'Echec enr�gistrement';
                    $this->view->message = $message;
                }
	    }
	}
	else {
            $code_type_compte = $request->code_type_compte;
            $mapper = new Application_Model_EuTypeCompteMapper();
            $compte = new Application_Model_EuTypeCompte();
            $mapper->find($code_type_compte, $compte);
            if ($compte->getCode_type_compte() == $code_type_compte) {
                $data = array(
                    'code_type_compte' => $code_type_compte,
                    'lib_type' => $compte->getLib_type(),
                    'desc_type' => $compte->getDesc_type()
                );
                $form->populate($data);
            }
			// Add the link to the cancel button
            $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-type-compte',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
            $this->view->form = $form;
			
	      }					 
	}
	
     public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $z = new Application_Model_EuTypeCompte();
        $mz = new Application_Model_EuTypeCompteMapper();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit") {
            $z->setId_type($this->_request->getPost("id"));
            $z->setLib_type($this->_request->getPost("lib_type"));
            $z->setDesc_type($this->_request->getPost("desc_type"));
            $mz->update($z);
        } elseif ($oper == "add") {
            $z->setId_type($this->_request->getPost("id_type"));
            $z->setLib_type($this->_request->getPost("lib_type"));
            $z->setDesc_type($this->_request->getPost("desc_type"));
            $mz->save($z);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("id");
            $mz->delete($id);
        }
    }
}
?>
