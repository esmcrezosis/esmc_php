<?php
 class EuObjetHorsController extends Zend_Controller_Action
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
    }
    
    public function indexAction() {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }
     
     public function dataAction() {
         
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_objet');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuConcerner();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_objet', 'eu_objet.code_objet = eu_concerner.code_objet')
               ->join('eu_besoin', 'eu_besoin.id_besoin = eu_concerner.id_besoin') 
               ->where('eu_concerner.type = ?', 'nouveau');
        $objet = $tabela->fetchAll($select);
        $count = count($objet);
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
            $date_besoin = new Zend_Date($row->date_besoin, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] =$row->code_objet;
            $responce['rows'][$i]['cell'] = array(
                 $row->code_objet,
                 $row->design_objet,
                 $row->objet_besoin,
                 $date_besoin->toString('dd/mm/yyyy'),
                 $row->num_client 
            );
            $i++;
        }
        $this->view->data = $responce;
    }
    
    public function editAction() {
        
           $this->_helper->layout->disableLayout();
           $request = $this->getRequest();
           $form = new Application_Form_EuObjetH();
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $num_membre = $user->num_membre;
            if ($this->getRequest()->isPost()) {
                 //if ($form->isValid($request->getPost())){
                     $prix= new Application_Model_EuPrix();
                     $pm = new Application_Model_EuPrixMapper();
                     $objet= new Application_Model_EuObjet();
                     $om = new Application_Model_EuObjetMapper();
                     $pu=$this->_request->getPost("prix_unitaire");
                     $duree=$this->_request->getPost("duree_vie");
                     $gamme=$this->_request->getPost("num_gamme");
                     if(($this->_request->getPost("code_rayon"))) {
                       $rayon=$this->_request->getPost("code_rayon");
                       $rech=$pm->findcaract($this->_request->getPost("code_objet"),$rayon);
                     }
                     else if(($this->_request->getPost("code_bout"))) {
                       $code_bout=$this->_request->getPost("code_bout");
                       $rech=$pm->controle($this->_request->getPost("code_objet"),$code_bout);
                     }
                     if(($this->_request->getPost("code_rayon"))) {  
                         if (count($rech) < 1) {
                             if(isset($pu) && isset($duree) && isset($gamme) && isset($rayon)) {   
                             $boutique=$om->findbout($rayon);
                             $membre=$pm->findbout($this->_request->getPost("code_rayon"));
                             $prix->setPrix_unitaire($pu);
                             $prix->setDuree_vie($duree);
                             $prix->setCode_objet($this->_request->getPost("code_objet"));
                             $prix->setBoutique($boutique);
                             $prix->setRayon($rayon);
                             $prix->setNum_gamme($gamme);
                             $prix->setCreer_par($num_membre);
                             $prix->setCode_demand('');
                             $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                             $prix->setMembre_rayon($membre);
                             $pm->save($prix);
                             return $this->_helper->redirector('index');     
                         }
                             else return $this->_helper->redirector('index');
                       } 
                             return $this->_helper->redirector('index');
                   }
                   else {
                          if (count($rech) < 1) {
                          if(isset($pu) && isset($duree) && isset($gamme) && isset($code_bout)) {       
                          $prix->setPrix_unitaire($pu);
                          $prix->setDuree_vie($duree);
                          $prix->setCode_objet($this->_request->getPost("code_objet"));
                          $prix->setBoutique($code_bout);
                          $prix->setRayon(null);
                          $prix->setNum_gamme($gamme);
                          $prix->setCreer_par($num_membre);
                          $prix->setCode_demand('');
                          $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                          $prix->setMembre_rayon('');
                          $pm->save($prix);
                          return $this->_helper->redirector('index');     
                         }
                          else return $this->_helper->redirector('index');
                       } 
                          return $this->_helper->redirector('index');
                 }
                          
                 //}
            }
            else
            {    
            $code_objet = $request->objet;
            $mapper = new Application_Model_EuObjetMapper();
            //$num_gamme=$mapper->findgamme($code_objet);
            //$code_bout=$mapper->findbout($num_gamme);
            $objet = new Application_Model_EuObjet();
            $mapper->find($code_objet, $objet);
            if ($objet->getCode_objet() == $code_objet) {
               $data = array(
                    'code_objet' => $objet->getCode_objet(),
                    'design_objet' => $objet->getDesign_objet()    
               );
                $form->populate($data);
            }
        }
        $this->view->objet = $objet;
        $this->view->form = $form;
     }   
}