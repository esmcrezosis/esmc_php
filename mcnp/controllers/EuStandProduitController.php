<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EuStandProduitController extends Zend_Controller_Action {
      
      //put your code here
      public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $menu = "<li><a id=\"new\" href=\"/eu-stand-produit/new\">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
      }
      
      function preDispatch() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'filiere' && $group != 'gac' && $group != 'creneau' && $group != 'acteur') {
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
       
       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $code_membre = $user->code_membre;
       $this->_helper->layout->disableLayout();
       
          $page = $this->_request->getParam("page", 1);
          $limit = $this->_request->getParam("rows", 100);
          $sidx = $this->_request->getParam("sidx", 'id_produit');
          $sord = $this->_request->getParam("sord", 'asc');
          $tabela = new Application_Model_DbTable_EuStandProduit();
          $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
          $select->setIntegrityCheck(false)
                 ->join('eu_stand', 'eu_stand.id_stand = eu_stand_PRODUIT.id_stand')
                 ->join('eu_filiere', 'eu_filiere.id_filiere = eu_stand_produit.id_filiere')  
                 ->where('eu_stand.code_membre = ?', $code_membre);
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
              $responce['rows'][$i]['id'] = $row->id_produit;
              $responce['rows'][$i]['cell'] = array(
                 $row->design_produit,
                 $row->design_stand,
                 $row->nom_filiere
            );
            $i++;
        }
        $this->view->data = $responce;
        
}
        public function newAction() {
           
           $request = $this->getRequest();
           $form = new Application_Form_EuStandProduit();
           if ($this->getRequest()->isPost()) {
               if ($form->isValid($request->getPost())) {
                    $standp= new Application_Model_EuStandProduit();
                    $standp->setId_produit($this->_request->getPost("id_produit"));
                    $standp->setDesign_produit($this->_request->getPost("design_produit"));
                    $standp->setId_stand($this->_request->getPost("id_stand"));
                    $standp->setId_filiere($this->_request->getPost("id_filiere")); 
                    $spm = new Application_Model_EuStandProduitMapper();
                    $spm->save($standp);
                    return $this->_helper->redirector('index');    
              } 
           } 
                    $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                    $this->view->url(array(
                    'controller' => 'eu-stand-produit',
                    'action' => 'index'
                        ), 'default', true) .
                    "','_self')");
                    $this->view->form = $form;
       }
    
       public function editAction() {
           
           // action body
           $this->_helper->layout->disableLayout();
           $request = $this->getRequest();
           $form = new Application_Form_EuStandProduit();
           if ($this->getRequest()->isPost()) {
              $this->_helper->layout->enableLayout();
              if ($form->isValid($request->getPost())) {
                  $standp = new Application_Model_EuStandProduit();
                  $spm = new Application_Model_EuStandProduitMapper();
                  $standp->setId_produit($this->_request->getPost("id_produit"));
                  $standp->setDesign_produit($this->_request->getPost("design_produit"));
                  $standp->setId_stand($this->_request->getPost("id_stand"));
                  $standp->setId_filiere($this->_request->getPost("id_filiere"));
                  $spm->update($standp);
                  return $this->_helper->redirector('index');
               } 
           }
           else 
           {
                   $id_produit = $request->id_produit;
                   $mapper = new Application_Model_EuStandProduitMapper();
                   $standp = new Application_Model_EuStandProduit();
                   $mapper->find($id_produit, $standp);
                   if ($standp->getId_produit() == $id_produit) {
                       $data = array(
                          'id_produit' => $standp->getId_produit(),
                          'design_produit' => $standp->getDesign_produit(),
                          'id_stand' =>$standp->getId_stand(),
                          'id_filiere' =>$standp->getId_filiere(), 
                );
                $form->populate($data);
               }   
           }    
           // Add the link to the cancel button
           $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                     $this->view->url(array(
                         'controller' => 'eu-stand-produit',
                         'action' => 'index'
                         ), 'default', true) .
                         "','_self')");

           $this->view->standp = $standp;
           $this->view->form = $form;
             
      }   
}

?>
