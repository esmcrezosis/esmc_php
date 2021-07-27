<?php
class EuObjetNsubController extends Zend_Controller_Action
{
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        }else{
            $user = $auth->getIdentity();
            $group = $user->usergroup;
            if($group != 'dist'){
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
        $menu = "<li><a href=\" /eu-objet-nsub/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }
    public function indexAction() {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_membre = $user->num_membre;
        if($num_membre!=''){
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_objet');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuObjetNsub();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_objet', 'eu_objet.code_objet = eu_objet_nsub.code_objet')
               ->where('eu_objet_nsub.num_pro = ?', $num_membre);
        $objetnsub = $tabela->fetchAll($select);
        $count = count($objetnsub);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $objetnsub = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($objetnsub as $row) {
            $responce['rows'][$i]['id'] = $row->code_objet;
            $responce['rows'][$i]['cell'] = array(
                $row->code_objet,
                $row->design_objet,
                $row->num_gamme,
                $row->pu_objet,
                $row->qte_stock,
                $row->duree_vie.' '.'jours',
            );
            $i++;
        }
        $this->view->data = $responce;
    }
 } 
    public function saveAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $o = new Application_Model_EuObjet();
        $mo = new Application_Model_EuObjetMapper();
        $oper = $this->_request->getPost("oper");
        if ($oper == "del") {
            $id = $this->_request->getPost("id");
            $mo->delete($id);
        }
    }
    public function newAction() {
        
        $form = new Application_Form_EuObjetNsub();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_membre = $user->num_membre;
        if ($this->getRequest()->isPost()){
            if ($form->isValid($this->_request->getPost())) {
                $objetnsub= new Application_Model_EuObjetNsub();
                $objet= new Application_Model_EuObjet();
                //Contrôle de l'existence des doublons
                $objet_db = new Application_Model_DbTable_EuObjet();
                $objet_find = $objet_db->find($this->_request->getPost("code_objet"));
                if (count($objet_find) == 1){
                    $message = 'Ce code produit existe déjà.';
                    $this->view->message = $message;
                    $this->view->form = $form;
                    return;
                } 
                else   
                {
                    $objet->setCode_objet($this->_request->getPost("code_objet"));
                    $objet->setDesign_objet($this->_request->getPost("design_objet"));
                    $objet->setNum_gamme($this->_request->getPost("num_gamme"));
                    $objet->setCaract_objet($this->_request->getPost("caract_objet"));
                    $objet->setDuree_vie($this->_request->getPost("duree_vie"));
                    $om = new Application_Model_EuObjetMapper();
                    $om->save($objet);
                    $objetnsub->setCode_objet($this->_request->getPost("code_objet"));
                    $objetnsub->setPu_objet($this->_request->getPost("pu_objet"));
                    $objetnsub->setQte_stock($this->_request->getPost("qte_stock"));
                    $objetnsub->setNum_pro($num_membre);
                    $onsm = new Application_Model_EuObjetNsubMapper();
                    $onsm->save($objetnsub);
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
                    'controller' => 'eu-objet-nsub',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        //$this->view->zone = $zones;
        $this->view->form = $form;
 }
 
    public function editAction() {
          
            $this->_helper->layout->disableLayout();
            $request = $this->getRequest();
            $form = new Application_Form_EuObjetNsub();
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
           // action body
            if ($this->getRequest()->isPost()) {
                 if ($form->isValid($request->getPost())) {
                     
                    //Mise à jour du produit non subventionné  
                    $objet = new Application_Model_EuObjet();
                    $objet->setCode_objet($this->getRequest()->code_objet);
                    $objet->setDesign_objet($this->getRequest()->design_objet);
                    $objet->setNum_gamme($this->getRequest()->num_gamme);
                    $objet->setCaract_objet($this->getRequest()->caract_objet);
                    $objet->setDuree_vie($this->getRequest()->duree_vie);
                    $mapper = new Application_Model_EuObjetMapper();
                    $mapper->update($objet);
                    $objetnsub = new Application_Model_EuObjetNsub();
                    $objetnsub->setCode_objet($this->getRequest()->code_objet);
                    $objetnsub->setPu_objet($this->getRequest()->pu_objet);
                    $objetnsub->setQte_stock($this->getRequest()->qte_stock); 
                    $m = new Application_Model_EuObjetNsubMapper();
                    $m->update($objetnsub);
        }
                    return $this->_helper->redirector('index');   
        } 
        else 
            {
            $code_objet = $request->objet;
            $mapper = new Application_Model_EuObjetMapper();
            $objet = new Application_Model_EuObjet();
            $mapper->find($code_objet, $objet);
            
            $mapper = new Application_Model_EuObjetMapper();
            $objet = new Application_Model_EuObjet();
            $mapper->find($code_objet, $objet);
            
            $m = new Application_Model_EuObjetNsubMapper();
            $objetnsub = new Application_Model_EuObjetNsub();
            $m->find($code_objet, $objetnsub);

            if ($objet->getCode_objet() == $code_objet) {
                $data = array(
                    'code_objet' => $objet->getCode_objet(),
                    'design_objet' => $objet->getDesign_objet(),
                    'num_gamme' => $objet->getNum_gamme(),
                    'pu_objet' => $objetnsub->getPu_objet(),
                    'qte_stock' => $objetnsub->getQte_stock(),
                    'caract_objet' => $objet->getCaract_objet(),
                    'duree_vie' => $objet->getDuree_vie()    
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-objet-nsub',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->objet = $objet;
        $this->view->form = $form;
 }   
        public function detailAction(){
                $this->_helper->layout->disableLayout();
                $request = $this->getRequest();
                $code_objet = $request->objet;
                $tabela = new Application_Model_DbTable_EuGammeProduit();
                $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                       ->join('eu_objet', 'eu_objet.num_gamme = eu_gamme_produit.code_gamme')
                       ->join('eu_rayon', 'eu_rayon.code_rayon = eu_gamme_produit.code_rayon')
                       ->where('eu_objet.code_objet = ?', $code_objet);
                $alloc = $tabela->fetchAll($select);
                $data=array(array());
                foreach ($alloc as $p) {
                $data[1][1] = $p->code_objet;
                $data[1][2] = $p->design_objet;
                $data[1][3] = $p->design_gamme;
                $data[1][4] = $p->design_rayon;
                $data[1][5] = $p->code_bout;
                $data[1][6] = $p->caract_objet;
             }
                $this->view->data = $data;
    }   
}



