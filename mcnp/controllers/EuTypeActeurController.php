<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EuTypeActeurController extends Zend_Controller_Action {
    
      public function preDispatch() {
          
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } 
        else 
        {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
    
    public function init() {
        
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-type-acteur/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();      
    }
    
    public function indexAction() {
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        // action body
    }
    
    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_type_acteur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuTypeActeur();
        $acteur = $tabela->fetchAll();
        $count = count($acteur);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $acteur = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($acteur as $row) {
            $responce['rows'][$i]['id'] = $row->id_type_acteur;
            $responce['rows'][$i]['cell'] = array(
                    $row->id_type_acteur,
                    $row->lib_type_acteur
            );
            $i++;
        }
        $this->view->data = $responce;
    }
    
    
     public function newAction() {

        $request = $this->getRequest();
        $form = new Application_Form_EuTypeActeur();
        if ($this->getRequest()->isPost()) {
           if ($form->isValid($request->getPost())) {
               
                  $typeacteur= new Application_Model_EuTypeActeur();
                  $typeacteur->setLib_type_acteur($this->_request->getPost("lib_type_acteur"));
                  $cm = new Application_Model_EuTypeActeurMapper();
                  $cm->save($typeacteur);
                  return $this->_helper->redirector('index'); 
                  
            }
        } 
        else 
        {
            //$mapper = new Application_Model_EuZoneMapper();
            //$zones = $mapper->fetchAll();
        }
        
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-type-creneau',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        
        //$this->view->zone = $zones;
        $this->view->form = $form;   
    }
    
    public function editAction() {
        
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuTypeActeur();
        $typeacteur = new Application_Model_EuTypeActeur();
		
        // action body
		
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                
                    //Mise à jour de la table type_creneau
					
                    $id_type_acteur=$this->_request->getPost("id_type_acteur");
                    $lib_type_acteur=$this->_request->getPost("lib_type_acteur");
                   
                    $typeacteur->setId_type_acteur($id_type_acteur);
                    $typeacteur->setLib_type_acteur($lib_type_acteur);
                  
                    $mapper = new Application_Model_EuTypeActeurMapper();
                    $mapper->update($typeacteur);
                    return $this->_helper->redirector('index');
                    
                 }
            }            
            else 
                {
                    $id_type_acteur = $request->id_type_acteur;
                    $mapper = new Application_Model_EuTypeActeurMapper();
                    $mapper->find($id_type_acteur, $typeacteur);
                    if ($typeacteur->getId_type_acteur() == $id_type_acteur) {
                    $data = array(
                       'id_type_acteur' => $typeacteur->getId_type_acteur(),
                       'lib_type_acteur' => $typeacteur->getLib_type_acteur()
                    );
                    $form->populate($data);
            }
       }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-type-acteur',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->typecreneau = $typecreneau;
        $this->view->form = $form;  
   }  
}
?>


