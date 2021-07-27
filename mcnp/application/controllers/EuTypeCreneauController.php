<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EuTypeCreneauController extends Zend_Controller_Action {
    
      
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
        $menu = "<li><a href=\" /eu-type-creneau/new \">Nouveau</a></li>";
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
        $sidx = $this->_request->getParam("sidx", 'id_type_creneau');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuTypeCreneau();
        $creneau = $tabela->fetchAll();
        $count = count($creneau);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $creneau = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($creneau as $row) {
            $responce['rows'][$i]['id'] = $row->id_type_creneau;
            $responce['rows'][$i]['cell'] = array(
                    $row->id_type_creneau,
                    $row->libelle_type_creneau
            );
            $i++;
        }
        $this->view->data = $responce;
    }
    
    
     public function newAction() {

        $request = $this->getRequest();
        $form = new Application_Form_EuTypeCreneau();
        if ($this->getRequest()->isPost()) {
           if ($form->isValid($request->getPost())) {
               
                  $typecreneau= new Application_Model_EuTypeCreneau();
                  $typecreneau->setLibelle_type_creneau($this->_request->getPost("libelle_type_creneau"));
                  $cm = new Application_Model_EuTypeCreneauMapper();
                  $cm->save($typecreneau);
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
        $form = new Application_Form_EuTypeCreneau();
        $typecreneau = new Application_Model_EuTypeCreneau();
		
        // action body
		
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                
                    //Mise à jour de la table type_creneau
					
                    $id_type_creneau=$this->_request->getPost("id_type_creneau");
                    $libelle_type_creneau=$this->_request->getPost("libelle_type_creneau");
                   
                    $typecreneau->setId_type_creneau($id_type_creneau);
                    $typecreneau->setLibelle_type_creneau($libelle_type_creneau);
                  
                    $mapper = new Application_Model_EuTypeCreneauMapper();
                    $mapper->update($typecreneau);
                    return $this->_helper->redirector('index');
                    
                 }
            }            
            else 
                {
                    $id_type_creneau = $request->id_type_creneau;
                    $mapper = new Application_Model_EuTypeCreneauMapper();
                    $mapper->find($id_type_creneau, $typecreneau);
                    if ($typecreneau->getId_type_creneau() == $id_type_creneau) {
                    $data = array(
                       'id_type_creneau' => $typecreneau->getId_type_creneau(),
                       'libelle_type_creneau' => $typecreneau->getLibelle_type_creneau()
                    );
                    $form->populate($data);
            }
       }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-type-creneau',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->typecreneau = $typecreneau;
        $this->view->form = $form;  
   }
    
    
    
    
}
?>

