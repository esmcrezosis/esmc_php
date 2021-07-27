<?php 
class EuVbpsController extends Zend_Controller_Action
{
    function preDispatch() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        }else{
            $user = $auth->getIdentity();
            $group = $user->usergroup;
            if($group != 'acteurs_creneaux' && $group !='creneaux' && $group !='gac' && $group !='gac_filiere'){
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
        $menu = "<li><a href=\" /eu-vbps/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);   
}

public function indexAction()
{
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
}
  
 /*  public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $login = $user->login;
      
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_value');
        $sord = $this->_request->getParam("sord", 'asc');
        
        //Formation de la sous requête
        $tabel = new Application_Model_DbTable_EuLier3();
            $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)
                ->join('eu_acteurs_creneaux', 'eu_acteurs_creneaux.code_acteur = eu_lier3.code_acteur')    
                ->join('eu_creneaux', 'eu_creneaux.code_creneau = eu_lier3.code_creneau')    
                ->where('eu_creneaux.cree_par = ?', $login);
            $listc = $tabel->fetchAll($sel);
            $mb = array();
            $i = 0;
            foreach ($listc as $row) {
                $mb[$i] = $row->membre;
                $i++;
            }
            
            $tab = new Application_Model_DbTable_EuLier3();
            $sel = $tabel->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $sel->setIntegrityCheck(false)    
                ->join('eu_creneaux', 'eu_creneaux.code_creneau = eu_lier3.code_creneau')
                ->join('eu_acteurs_creneaux', 'eu_acteurs_creneaux.code_acteur = eu_lier3.code_acteur')    
                ->where('eu_creneaux.cree_par = ?', $login);
            $list = $tab->fetchAll($sel);
            $m = array();
            $i = 0;
            foreach ($list as $row) {
                $m[$i] = $row->membre;
                $i++;
            }   
        $tabela = new Application_Model_DbTable_EuPrix();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_objet', 'eu_objet.code_objet = eu_prix.code_objet')
               ->where('eu_prix.creer_par in (?)', $mb)
               ->orwhere('eu_prix.creer_par in (?)', $m) ;
        $objet = $tabela->fetchAll($select);
        $count = count($objet);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $objet = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($objet as $row) {
                     $responce['rows'][$i]['id'] = $row->id_value;
                     $responce['rows'][$i]['cell'] = array(
                     $row->code_objet,
                     $row->design_objet,
                     $row->duree_vie.' '.'mois',
                     $row->boutique,
                     $row->rayon,
            );
            $i++;
        }
        $this->view->data = $responce;                
  }
 */ 
        public function dataAction() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $membre = $user->num_membre;
        $gac_filiere = $user->num_gac_filiere;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_vbps');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuVbps();
        $select=$tabela->select();
        $select->from($tabela)
              ->where('membre = ?', $membre)
              ->where('num_gac_filiere = ?', $gac_filiere);
        $vbps = $tabela->fetchAll($select);
        $count = count($vbps);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $vbps = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($vbps as $row) {
            $responce['rows'][$i]['id'] = $row->id_vbps;
            $responce['rows'][$i]['cell'] = array(
               // $row->id_vbps,
                $row->duree_vie.' périodes de 30 jours',
                $row->membre,
                $row->num_gac_filiere,
            );
            $i++;
        }
        $this->view->data = $responce;
  }
  
   public function newAction() {
       
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $login = $user->login;
        $membre = $user->num_membre;
        $gac_filiere = $user->num_gac_filiere;
        $request = $this->getRequest();
        $form = new Application_Form_EuVbps();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())){
                
                 if ($this->_request->getPost("unite_mdv") == 'jour') {
                  $duree_vie = $this->_request->getPost("duree_vie") / 30;
                 } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                   $duree_vie = $this->_request->getPost("duree_vie");
                 } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                   $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                 }
                 
                   $vbps= new Application_Model_EuVbps();
                   $vbps->setDuree_vie($duree_vie);
                   $vbps->setNum_gac_filiere($gac_filiere);
                   $vbps->setMembre($membre);
                   $vm = new Application_Model_EuVbpsMapper();
                   $vm->save($vbps);
                   return $this->_helper->redirector('index');
            }
        
            
        } 
        else {
            //$mapper = new Application_Model_EuZoneMapper();
            //$zones = $mapper->fetchAll();
        }
        
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-vbps',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        //$this->view->zone = $zones;
        $this->view->form = $form;    
    }
  
  
  
  
  
  
  
public function editAction() {  
            
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuVbps();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $membre=$user->num_membre;
        $gac_filiere=$user->num_gac_filiere;
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                 $vbps = new Application_Model_EuVbps();
                 $mv = new Application_Model_EuVbpsMapper();
          
                 if ($this->_request->getPost("unite_mdv") == 'jour') {
                   $duree_vie = $this->_request->getPost("duree_vie") / 30;
                 } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                   $duree_vie = $this->_request->getPost("duree_vie");
                 } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                   $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                 }
                   $vbps->setId_vbps($this->_request->getPost("id_vbps"));
                   $vbps->setDuree_vie($duree_vie);
                   $vbps->setNum_gac_filiere($gac_filiere);
                   $vbps->setMembre($membre);
                   $mv->update($vbps);
                 return $this->_helper->redirector('index');
                 }   
            }
            else {
            $id_vbps = $request->id_vbps;
            $mapper = new Application_Model_EuVbpsMapper();
            $vbps = new Application_Model_EuVbps();
            $mapper->find($id_vbps, $vbps);
            
            if ($vbps->getId_vbps() == $id_vbps) {
                $data = array(
                    'id_vbps' => $vbps->getId_vbps(),
                    'duree_vie' => $vbps->getDuree_vie(),
                    'unite_mdv' =>'mois',
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-vbps',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->gac = $gac;
        $this->view->form = $form;         
    }
}
 ?> 