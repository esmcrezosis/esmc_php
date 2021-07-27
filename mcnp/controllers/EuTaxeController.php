<?php

class EuTaxeController extends Zend_Controller_Action
{
      function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        }else{
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if($group != 'admin' and $group!='agregat' and $group!='acteur_pbf'){
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
    
    public function init()
    {
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-taxe/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    
    public function indexAction() {
        // action body
    }
     
    public function newAction() {
        
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuTaxe();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $taxe = new Application_Model_EuTaxe($form->getValues());
                $mapper = new Application_Model_EuTaxeMapper();
                $count=$mapper->findConuter()+1;
                $taxe->setId_taxe($count);
                $mapper->save($taxe);
                return $this->_helper->redirector('index');
            }
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-taxe',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }
	
	public function editAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuTaxe();
        $taxe = new Application_Model_EuTaxe();
		
        // action body
		
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                
                    //Mise � jour de la table taxe
					
                    $id_taxe=$this->_request->getPost("id_taxe");
                    $libelle_taxe=$this->_request->getPost("libelle_taxe");
                    $taux_taxe=$this->_request->getPost("taux_taxe");
                    $id_pays=$this->_request->getPost("id_pays");
              
                    $taxe->setId_taxe($id_taxe);
                    $taxe->setLibelle_taxe($libelle_taxe);
                    $taxe->setTaux_taxe($taux_taxe);
                    $taxe->setId_pays($id_pays);
                  
                    $mapper = new Application_Model_EuTaxeMapper();
                    $mapper->update($taxe);
                    return $this->_helper->redirector('index');
                    
                 }
            }            
            else 
                {
                    $id_taxe = $request->id_taxe;
                    $mapper = new Application_Model_EuTaxeMapper();
                    $mapper->find($id_taxe, $taxe);
                    if ($taxe->getId_taxe() == $id_taxe) {
                    $data = array(
                         'id_taxe' => $taxe->getId_taxe(),
                         'libelle_taxe' => $taxe->getLibelle_taxe(),
                         'taux_taxe' => $taxe->getTaux_taxe(),
                         'id_pays' => $taxe->getId_pays()
                    );
                    $form->populate($data);
            }
       }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-taxe',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->taxe = $taxe;
        $this->view->form = $form;  
   }
	
    
    public function dataAction() {

        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_taxe');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuTaxe();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_pays', 'eu_pays.id_pays = eu_taxe.id_pays');
        $taxe = $tabela->fetchAll($select);
        $count = count($taxe);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $taxe = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($taxe as $row) {
            
            $responce['rows'][$i]['id'] = $row->id_taxe;
            $responce['rows'][$i]['cell'] = array(
                 $row->id_taxe,
                 $row->libelle_taxe,
                 $row->taux_taxe,
                 $row->libelle_pays
            );
            $i++;
        }
        $this->view->data = $responce;
        
   }      
}














