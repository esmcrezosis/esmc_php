<?php

class EuGammeProduitController extends Zend_Controller_Action
{
    function preDispatch() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        }else{
            $user = $auth->getIdentity();
            $group = $user->usergroup;
            if($group != 'dist' && $group != 'boutique'){
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
    
   public function init()
  {
       $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-gamme-produit/new \">Nouveau</a></li>".
                "<li><a href=\" /eu-gamme-produit/list \">Mes Gammes</a></li>";
        $this->view->placeholder("menu")->set($menu);
  }

  public function indexAction()
  {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        
  }
  
  public function listAction(){
        
  }
  
  public function listgammeAction(){
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $membre = $user->num_membre;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_gamme');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuGammeProduit();
        $select = $tabela->select();
        $select->from('eu_gamme_produit')
               ->where('eu_gamme_produit.membre = ?', $membre);
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
            $responce['rows'][$i]['id'] = $row->code_gamme;
            $responce['rows'][$i]['cell'] = array(
                $row->code_gamme,
                $row->design_gamme, 
            );
            $i++;
        }
        $this->view->data = $responce; 
  }
  
  public function changeAction() {
        if ($_GET["gamme"]!='') {
             $var = $_GET["gamme"];
             $gamme = new Application_Model_DbTable_EuGammeProduit();
             $result = $gamme->fetchAll($gamme->select()->where('code_gamme = ?', $var));
             $row = $result->current();
             $data= $row['design_gamme'];
             $this->view->data = $data;
        }
    }
    
    public function dataAction(){
        
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_gamme');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuGammeProduit(); 
        $alloc = $tabela->fetchAll();
        $count = count($alloc);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $alloc = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($alloc as $row) {
            $responce['rows'][$i]['id'] = $row->code_gamme;
            $responce['rows'][$i]['cell'] = array(
                $row->code_gamme,
                $row->design_gamme,
                $row->membre, 
            );
            $i++;
        }
        $this->view->data = $responce;
  }  
  
    public function saveAction() {     
    }
    
    public function newAction() {
        
        $request = $this->getRequest();
        $form = new Application_Form_EuGammeProduit();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $membre = $user->num_membre;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                  $gamme= new Application_Model_EuGammeProduit();
                  $gamme->setCode_gamme($this->_request->getPost("code_gamme"));
                  $gamme->setDesign_gamme($this->_request->getPost("design_gamme"));
                  $gamme->setMembre($membre);
             
                //Contrôle de l'existence des doublons dans la table eu_gamme_produit
                  $gamme_db = new Application_Model_DbTable_EuGammeProduit();
                  $gamme_find = $gamme_db->find($this->_request->getPost("code_gamme"));
                  if (count($gamme_find) == 1) {
                      
                       $message = 'Ce code gamme existe déjà';
                       $this->view->message = $message;
                       $this->view->form = $form;
                       return;
                    
                  }
                  
                else 
                {
                    $gm = new Application_Model_EuGammeProduitMapper();
                    $gm->save($gamme);
                    return $this->_helper->redirector('index');
                }
            }
        }
         else {
            //$mapper = new Application_Model_EuZoneMapper();
            //$zones = $mapper->fetchAll();
        }
        //if($num_membre!=''){
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-gamme-produit',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        //$this->view->zone = $zones;
        $this->view->form = $form;
      //}
 }
 
    public function editAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $membre = $user->num_membre;
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuGammeProduit();
        
        // action body
        if ($this->getRequest()->isPost()) {
            //$this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                
                    //Mise à jour de la gamme produit
                
                    $gamme = new Application_Model_EuGammeProduit();
                    $gamme->setCode_gamme($this->getRequest()->code_gamme);
                    $gamme->setDesign_gamme($this->getRequest()->design_gamme);
                    $gamme->setMembre($membre);
                    $mapper = new Application_Model_EuGammeProduitMapper();
                    $mapper->update($gamme); 
                    
                  }
                    return $this->_helper->redirector('list');  
        }
                       
        
        else 
            {
            $code_gamme=$request->gamme;
            $mapper = new Application_Model_EuGammeProduitMapper();
            $gamme = new Application_Model_EuGammeProduit();
            $mapper->find($code_gamme, $gamme);
            
            if ($gamme->getCode_gamme() == $code_gamme) {
                $data = array(
                    'code_gamme' => $gamme->getCode_gamme(),
                    'design_gamme' => $gamme->getDesign_gamme()
                );
                $form->populate($data);
            }
     
       }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-gamme-produit',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->gamme = $gamme;
        $this->view->form = $form;
    }
    
}

