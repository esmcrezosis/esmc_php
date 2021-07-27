<?php
class EuBoutiqueController extends Zend_Controller_Action
{
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        }else{
            $user = $auth->getIdentity();
            $group = $user->usergroup;
            if($group != 'acteurs_creneaux' && $group !='creneaux' && $group !='gac' && $group !='gac_filiere' && $group !='dist'){
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
    
  public function init()
  {
       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $group = $user->usergroup;
       $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        /* Initialize action controller here */
        if($group != 'acteurs_creneaux' or $group != 'dist'){
        $menu = "<li><a href=\" /eu-boutique/new \">Nouveau</a></li>";
               // "<li><a href=\"/eu-boutique/listbout \">Mes boutiques</a></li>";
        
        $this->view->placeholder("menu")->set($menu);
     }
     else {
         
        $menu="<li><a href=\"/eu-boutique/listbout \">Mes boutiques</a></li>";
        $this->view->placeholder("menu")->set($menu);
        
     }   
 }

  public function indexAction()
  {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
  }
  
  
  public function  listboutAction(){
      
      $this->view->jQuery()->enable();
      $this->view->jQuery()->uiEnable(); 
      
  }
  
  
  public function listboutiqueAction(){
      
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_membre = $user->num_membre;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_bout');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuBoutique();
        $select=$tabela->select();
        $select->from($tabela)
              ->where('proprietaire = ?', $num_membre);
        $boutique = $tabela->fetchAll($select);
        $count = count($boutique);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $boutique = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($boutique as $row) {
            $responce['rows'][$i]['id'] = $row->code_bout;
            $responce['rows'][$i]['cell'] = array(
                $row->code_bout,
                $row->design_bout,
                $row->telephone,
                $row->adresse,
                $row->nom_responsable.'  '.$row->prenom_responsable
            );
            $i++;
        }
        $this->view->data = $responce;
      
  }
  
  public function dataAction(){
       
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $login = $user->login;
        
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_bout');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuBoutique();
        $select=$tabela->select();
        $select->from($tabela)
              ->where('creer_par = ?', $login);
        $boutique = $tabela->fetchAll($select);
        $count = count($boutique);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $boutique = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($boutique as $row) {
            $responce['rows'][$i]['id'] = $row->code_bout;
            $responce['rows'][$i]['cell'] = array(
                $row->code_bout,
                $row->design_bout,
                $row->proprietaire,
                $row->telephone,
                $row->adresse,
                $row->nom_responsable.'  '.$row->prenom_responsable
            );
            $i++;
        }
        $this->view->data = $responce;   
} 
   public function saveAction() {
            
    }
    
   public function newAction() {
       
        $request = $this->getRequest();
        
        $form = new Application_Form_EuBoutique();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $login = $user->login;
        $num_membre = $user->num_membre;
        if ($this->getRequest()->isPost()) {
            
            if ($form->isValid($request->getPost())) {
                
                $bout= new Application_Model_EuBoutique();
                $bm = new Application_Model_EuBoutiqueMapper();
                
                //Contrôle de l'existence des doublons
                
                $bout_db = new Application_Model_DbTable_EuBoutique();
                $bout_find = $bout_db->find($this->_request->getPost("code_bout"));
                $membre_db = new Application_Model_DbTable_EuMembre();
               // $membre_find = $membre_db->find($this->_request->getPost("proprietaire"));
                if (count($bout_find) == 1) {
                    $message = 'Ce code boutique existe déjà.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                }
               // else if ((count($membre_find) < 1)) {
               //      $message = 'Ce numero membre  est erroné.';
               //      $this->view->message = $message;
               //      $this->view->form = $form;
               //      return;
               // }
               // else if (($num_membre==$this->_request->getPost("proprietaire"))) {
               //      $message = 'Vous ne pouvez pas créer votre propre boutique .';
               //      $this->view->message = $message;
               //      $this->view->form = $form;
               ///      return;
                //}
                else 
                {
                    $bout->setCode_bout($this->_request->getPost("code_bout"));
                    //$bout->setProprietaire($this->_request->getPost("proprietaire"));
                    $bout->setProprietaire($num_membre);
                    $bout->setDesign_bout($this->_request->getPost("design_bout"));
                    $bout->setTelephone($this->_request->getPost("telephone"));
                    $bout->setAdresse($this->_request->getPost("adresse"));
                    $bout->setMail($this->_request->getPost("mail"));
                    $bout->setSiteweb($this->_request->getPost("siteweb"));
                    $bout->setCreer_par($login);
                    $bout->setCodesect($this->_request->getPost("codesect"));
                    $bout->setNom_responsable($this->_request->getPost("nom_responsable"));
                    $bout->setPrenom_responsable($this->_request->getPost("prenom_responsable"));
                    $bm->save($bout);
                    return $this->_helper->redirector('index');
                }
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
                    'controller' => 'eu-boutique',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        //$this->view->zone = $zones;
        $this->view->form = $form;
    }
    
    public function editAction() {
        
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $login = $user->login;
        $num_membre = $user->num_membre;
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuBoutique();
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        // action body
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) { 
                
                   // $membre_db = new Application_Model_DbTable_EuMembre();
                    $mapper = new Application_Model_EuBoutiqueMapper();
                   // $membre_find = $membre_db->find($this->_request->getPost("proprietaire"));
                    //Mise à jour de la boutique
                   // if (count($membre_find) == 1 && ($num_membre!=$this->_request->getPost("proprietaire"))) {
                        
                    $bout = new Application_Model_EuBoutique();
                    $bout->setProprietaire($num_membre);
                    $bout->setCreer_par($login);
                    $bout->setDesign_bout($this->_request->getPost("design_bout"));
                    $bout->setTelephone($this->_request->getPost("telephone"));
                    $bout->setAdresse($this->_request->getPost("adresse"));
                    $bout->setMail($this->_request->getPost("mail"));
                    $bout->setSiteweb($this->_request->getPost("siteweb"));
                    $bout->setCodesect($this->_request->getPost("codesect"));
                    $bout->setNom_responsable($this->_request->getPost("nom_responsable"));
                    $bout->setPrenom_responsable($this->_request->getPost("prenom_responsable"));
                    $bout->setCode_bout($this->getRequest()->code_bout);
                    $mapper->update($bout);
                  //}
        
        }
                    return $this->_helper->redirector('index');   
        } 
        else 
            {
            
            $code_bout = $request->bout;
            $mapper = new Application_Model_EuBoutiqueMapper();
            $bout = new Application_Model_EuBoutique();
            $mapper->find($code_bout, $bout);

            if ($bout->getCode_bout() == $code_bout) {
                $data = array(
                    'code_bout' => $bout->getCode_bout(),
                    'proprietaire' => $bout->getProprietaire(),
                    'design_bout' => $bout->getDesign_bout(),
                    'telephone' => $bout->getTelephone(),
                    'adresse' => $bout->getAdresse(),
                    'mail' => $bout->getMail(),
                    'siteweb' => $bout->getSiteweb(),
                    'codesect' => $bout->getCodesect(),
                    'nom_responsable' => $bout->getNom_responsable(),
                    'prenom_responsable' => $bout->getPrenom_responsable()    
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-boutique',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->bout = $bout;
        $this->view->form = $form;
    }
    public function detailAction() {
        
        
        $this->_helper->layout->disableLayout();
        $code_bout = $this->getRequest()->bout;
        $mapper = new Application_Model_EuBoutiqueMapper();
        $boutique = new Application_Model_EuBoutique();
        $mapper->find($code_bout, $boutique);
        $this->view->boutique = $boutique;  
        
        
    }
}