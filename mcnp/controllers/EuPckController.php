<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EuPckController extends Zend_Controller_Action {
    
      function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'parametre') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    } 
    public function init() {
        $menu = "<li><a href=\" /eu-pck/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();   
    }

    public function dataAction() {
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_param');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuParametres();
        $select=$tabela->select();
        $select->where('code_param = ?','pck');
        $param = $tabela->fetchAll($select);
        $count = count($param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;

        $param = $tabela->fetchAll($select,"$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($param as $row) {
             
            $responce['rows'][$i]['id'] = $row->code_param . $row->lib_param;
            $responce['rows'][$i]['cell'] = array(
                strtoupper($row->code_param),
                $row->lib_param,
                $row->montant
            );
            $i++;
        }
        $this->view->data = $responce;
    }
     
    public function indexAction() {
        // action body
    }

     public function newAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuPck(); 
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $param = new Application_Model_EuParametres($form->getValues());
                $mapper = new Application_Model_EuParametresMapper();
                //Contrôle de l'existence des doublons
                $param_db = new Application_Model_DbTable_EuParametres();
                $param_find = $param_db->find($this->_request->getPost("code_param"), $this->_request->getPost("lib_param"));
                $count = $mapper->findConuterpck();
                if ($count > 1) {
                      $message = 'Le paramétrage du pck est déjà défini.';
                      $this->view->message = $message;
                      $this->view->form = $form;
                      return;
                }
                elseif (count($param_find) == 1) {
                      $message = 'Ce paramètre existe déjà.';
                      $this->view->message = $message;
                      $this->view->form = $form;
                      return;
                }
                else {
                      $mapper->save($param);
                      return $this->_helper->redirector('index');
                }   
            }  
        }    
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-pck',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;        
     }
     
     public function editAction() {
         
         // action body
         $this->_helper->layout->disableLayout();
         $request = $this->getRequest();
         $form = new Application_Form_EuPck();
         
         if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                 $param = new Application_Model_EuParametres($form->getValues());
                 $param->setCode_param($this->getRequest()->code_param);
                 $param->setLib_param($this->getRequest()->lib_param);
                 $param->setMontant($this->getRequest()->montant);
                 $mapper = new Application_Model_EuParametresMapper();
                 $mapper->update($param);
                 
                 return $this->_helper->redirector('index');
                
            }
            
         }
         else {
            $code_param = $this->getRequest()->code_param;
            $lib_param = $this->getRequest()->lib_param;
            $mapper = new Application_Model_EuParametresMapper();
            $param = new Application_Model_EuParametres();
            $mapper->find($code_param, $lib_param, $param);
            if ($param->getLib_param() == $lib_param) {
                $data = array(
                    'code_param' => $code_param,
                    'lib_param' => $lib_param,
                    'montant' => $param->getMontant(),
                );
                $form->populate($data);
            }
        }
        
         // Add the link to the cancel button
         $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-pck',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
          $this->view->form = $form;      
     }
     

}
?>