<?php

class EuRayonController extends Zend_Controller_Action
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
        $menu = "<li><a href=\" /eu-rayon/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
  }

  
    public function indexAction()
    {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }
    
    public function dataAction() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $login = $user->login;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_rayon');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuRayon();
        $select=$tabela->select();
        $select->from($tabela)
              ->where('creer_par = ?', $login);
        $rayon = $tabela->fetchAll($select);
        $count = count($rayon);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $rayon = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($rayon as $row) {
            $responce['rows'][$i]['id'] = $row->code_rayon;
            $responce['rows'][$i]['cell'] = array(
                $row->code_rayon,
                $row->design_rayon,
                $row->telephone,
                $row->adresse,
                $row->proprietaire_rayon,
                $row->code_bout,
            );
            $i++;
        }
        $this->view->data = $responce;
    
} 
  
    public function saveAction() {  
    }
     
    public function newAction() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $login = $user->login;
        $request = $this->getRequest();
        $form = new Application_Form_EuRayon();
        if ($this->getRequest()->isPost()) {
           if ($form->isValid($request->getPost())) {
               $rayon= new Application_Model_EuRayon();
               $rayon->setCode_rayon($this->_request->getPost("code_rayon"));
               $rayon->setCode_bout($this->_request->getPost("code_bout"));
               $rayon->setProprietaire_rayon($this->_request->getPost("proprietaire_rayon"));
               $rayon->setDesign_rayon($this->_request->getPost("design_rayon"));
               $rayon->setTelephone($this->_request->getPost("telephone"));
               $rayon->setAdresse($this->_request->getPost("adresse"));
               $rayon->setCreer_par($login);
               //Contrôle de l'existence des doublons
               $rayon_db = new Application_Model_DbTable_EuRayon();
               $rayon_find = $rayon_db->find($this->_request->getPost("code_rayon"));
               $membre_db = new Application_Model_DbTable_EuMembre();
               $membre_find = $membre_db->find($this->_request->getPost("proprietaire_rayon"));
               if (count($rayon_find) == 1) {
                    $message = 'Ce code rayon existe déjà.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                }
                else if((count($membre_find) < 1)) {
                    $message = 'Ce numero membre  n\'existe pas dans le système.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                    
                }
                else 
                {
                    $rm = new Application_Model_EuRayonMapper();
                    $rm->save($rayon);
                    return $this->_helper->redirector('index');
                }
            }
        } 
        else {
            //$mapper = new Application_Model_EuZoneMapper();
            //$zones = $mapper->fetchAll();
        }
        
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-rayon',
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
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuRayon();
        $rayon = new Application_Model_EuRayon();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                
                    //Mise à jour de la rayon
                    $code_bout=$this->_request->getPost("code_bout");
                    $proprietaire=$this->_request->getPost("proprietaire_rayon");
                    $design=$this->_request->getPost("design_rayon");
                    $tel=$this->_request->getPost("telephone");
                    $adr=$this->_request->getPost("adresse");
                    $code_rayon=$this->getRequest()->code_rayon;
                    $rayon->setCode_bout($code_bout);
                    $rayon->setProprietaire_rayon($proprietaire);
                    $rayon->setDesign_rayon($design);
                    $rayon->setTelephone($tel);
                    $rayon->setAdresse($adr);
                    $rayon->setCode_rayon($code_rayon);
                    $rayon->setCreer_par($login);
                    $mapper = new Application_Model_EuRayonMapper();
                    $mapper->update($rayon);
                    return $this->_helper->redirector('index');
                    
                 }
            }            
            else 
                {
                    $code_rayon = $request->rayon;
                    $mapper = new Application_Model_EuRayonMapper();
                    $mapper->find($code_rayon, $rayon);
                    if ($rayon->getCode_rayon() == $code_rayon) {
                    $data = array(
                         'code_rayon' => $rayon->getCode_rayon(),
                         'code_bout' => $rayon->getCode_bout(),
                         'proprietaire_rayon' => $rayon->getProprietaire_rayon(),
                         'design_rayon' => $rayon->getDesign_rayon(),
                         'telephone' => $rayon->getTelephone(),
                         'adresse' => $rayon->getAdresse()
                    );
                    $form->populate($data);
            }
       }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-rayon',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->rayon = $rayon;
        $this->view->form = $form;  
   } 
    
    
    
}