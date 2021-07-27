<?php

class EuCompensationController extends  Zend_Controller_Action {

      //put your code here
      public function init() {
          $this->view->jQuery()->enable();
          $this->view->jQuery()->uiEnable();
          $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
          $user = $auth->getIdentity();
          $group = $user->code_groupe;
          if ($group == "compensation") {       
		     $menu = "<li><a href=\" /eu-compensation/new \"  style=\"font-size:9px\">Nouveau</a></li>".
			         "<li><a href=\" /eu-compensation/index\" style=\"font-size:9px\">Consultation</a></li>";   	   
          } 
          $this->view->placeholder("menu")->set($menu);
		
	   }
	
	
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } 
        else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'compensation') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

     public function indexAction(){
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        
     }
	 
	 public function changemoralAction() {
           $data = array();
           $mb = new Application_Model_DbTable_EuActeur();
           $select = $mb->select();
		   $select->where('type_acteur like ?','PBF');
           $result = $mb->fetchAll($select);
           foreach ($result as $p) {
              $data[] = $p->code_membre;
           }
           $this->view->data = $data;
       }
	   
	   
	   public function recupmoralAction() {
          $num_membre = $_GET['num_membre'];
          $membre_db = new Application_Model_DbTable_EuMembreMorale();
          $membre_find = $membre_db->find($num_membre);
          if (count($membre_find) == 1) {
             $result = $membre_find->current();
             $data[0] = strtoupper($result->raison_sociale);
          } else {
            $data = '';
          }
          $this->view->data = $data;
       }
	 
	 
	 
	   public function gcppbfAction() {
		      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
              $user = $auth->getIdentity();
		      if(isset($_GET['code_membre'])){
		         $code_membre = $_GET['code_membre'];
		      } else {
		        $code_membre = "";
		      }
			  
		
		
		
		
		
		}
	 
	 
	   
	   
	   
         public function newAction() {
         
           
         }
  
  
         public function dataAction() {
     
        
         }

    
   
}