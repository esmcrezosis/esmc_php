<?php
class EuObjetController extends Zend_Controller_Action
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
        $menu = "<li><a href=\" /eu-objet/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
    }
    
    public function indexAction() {
        // action body
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        
        if (isset($_POST["produit"])){
           $produit = $_POST['produit'];
           $this->view->produit = $produit;
        }
        
    }
    
   
     public function listAction() {
         
         if (isset($_POST["produit"])){
           $produit = $_POST['produit'];
           $this->view->produit = $produit;
        }    
    }
    
    public function produit1Action(){
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_membre = $user->num_membre;
        $data = array();
        $prix = new Application_Model_DbTable_EuPrix();
        $select = $prix->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_objet', 'eu_objet.code_objet = eu_prix.code_objet')
               ->join('eu_gamme_produit', 'eu_gamme_produit.code_gamme = eu_prix.num_gamme')
               ->join('eu_boutique', 'eu_boutique.code_bout = eu_prix.boutique')  
               ->where('eu_prix.creer_par = ?', $num_membre);
        $result = $prix->fetchAll($select);
          foreach ($result as $p) {
            $data[] = $p->design_objet;
        }
        $this->view->data = $data;
    }
     public function produitAction() {
        
          $data = array();
          $objet = new Application_Model_DbTable_EuObjet();
          $select=$objet->select();
          $select->from($objet, array('design_objet'));
          $select->order('design_objet asc');
          $result = $objet->fetchAll($select);
          foreach ($result as $p) {
            $data[] = $p->design_objet;
        }
        $this->view->data = $data;
 }
    
     public function listproduitAction() {
         
        $this->_helper->layout->disableLayout();
        if (isset($_GET["produit"])) $produit = $_GET["produit"];
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'code_objet');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuObjet();
        if($produit!=""){
                     $select = $tabela->select();
                     $select->from($tabela)        
                            ->where('eu_objet.design_objet = ?', $produit);
                     $objet = $tabela->fetchAll($select);
        }
        else{ 
               $objet = $tabela->fetchAll();
        }
        $count = count($objet);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        if($produit!=""){
        $objet = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        }
        else $objet = $tabela->fetchAll(null, "$sidx $sord", $limit, ($page * $limit - $limit));
        
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($objet as $row) {
            $responce['rows'][$i]['id'] =$row->code_objet;
            $responce['rows'][$i]['cell'] = array(
                $row->code_objet,
                $row->design_objet,    
            );
            $i++;
        }
        $this->view->data = $responce;    
  }
    
    public function changeAction() {
        //if ($_GET["objet"]!='') {
            
             $var = $_GET["objet"];
             $data=array();
             $objet = new Application_Model_DbTable_EuObjet();
             $select = $objet->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
             $select->setIntegrityCheck(false)
                    ->join('eu_gamme_produit', 'eu_gamme_produit.code_gamme = eu_objet.num_gamme')
                    ->where('eu_objet.design_objet = ?', $var);
             $result = $objet->fetchAll($select);
             $row = $result->current();
             $data[0]= $row['num_gamme'];
             $data[1]= $row['design_gamme'];
             $data[2]= $row['caract_objet'];
             $this->view->data = $data;  
        //}
    }
    
    public function prodchangeAction() {
        
            $data = array(array());
            $produit = new Application_Model_DbTable_EuGammeProduit();
            $result = $produit->fetchAll();
            $i=0;
            foreach ($result as $p) {
                $data[$i][1] = $p->code_gamme;
                $data[$i][2] = $p->design_gamme;
                $i++;
            }
            $this->view->data = $data;
    }
    
    public function dataAction() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_membre = $user->num_membre;
       
        $this->_helper->layout->disableLayout();
        if (isset($_GET["produit"])) $produit = $_GET["produit"];
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_value');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuPrix();
        if($produit!=""){
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_objet', 'eu_objet.code_objet = eu_prix.code_objet')
               ->join('eu_gamme_produit', 'eu_gamme_produit.code_gamme = eu_prix.num_gamme')
               ->join('eu_boutique', 'eu_boutique.code_bout = eu_prix.boutique')  
               ->where('eu_prix.creer_par = ?', $num_membre)
               ->where('eu_objet.design_objet = ?', $produit) ;
        }
        else {
         $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_objet', 'eu_objet.code_objet = eu_prix.code_objet')
               ->join('eu_gamme_produit', 'eu_gamme_produit.code_gamme = eu_prix.num_gamme')
               ->join('eu_boutique', 'eu_boutique.code_bout = eu_prix.boutique')  
               ->where('eu_prix.creer_par = ?', $num_membre);   
        }
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
            $responce['rows'][$i]['id'] =$row->id_value;
            $responce['rows'][$i]['cell'] = array(
                $row->code_objet,
                $row->design_objet,
                $row->prix_unitaire,
                $row->duree_vie.' '.'periodes',
                $row->design_bout,
                $row->code_demand,    
            );
            $i++;
        }
        $this->view->data = $responce;
 }
 
 public function envoiAction() {
      $form = new Application_Form_EuObjet();
      $request = $this->getRequest();
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $user = $auth->getIdentity();
      $num_membre = $user->num_membre;  
      if ($this->getRequest()->isPost()) {
              if ($form->isValid($request->getPost())){
                  $prix= new Application_Model_EuPrix();
                  $objet= new Application_Model_EuObjet();
                  $om = new Application_Model_EuObjetMapper();
                  $pm = new Application_Model_EuPrixMapper();
                  $objet_find = $om->findobjet($this->_request->getPost("design_objet"));
                  $sub = $pm->findsub($this->_request->getPost("code_demand"));
                  if (count($objet_find) < 1) {
                     if (count($sub) == 1) {
                        $message = 'Cette subvention est déjà utilisée.';
                        $this->view->message = $message;
                        $this->view->form = $form;
                        return;
                    }
                    else 
                    {
                    $count=$om->findConuter();
                    $nb=$count+1;
                    $code_objet=$nb.strtoupper(substr(htmlentities($this->_request->getPost("design_objet")),0,3)).'gp';
                    $objet->setCode_objet($code_objet);
                    $objet->setDesign_objet($this->_request->getPost("design_objet"));
                    $om->save($objet);
                    $boutique=$om->findbout($this->_request->getPost("code_rayon"));
                    $membre=$pm->findbout($this->_request->getPost("code_rayon"));
                    $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                    if ($this->_request->getPost("unite_mdv") == 'jour') {
                       $duree_vie = $this->_request->getPost("duree_vie") / 30;
                       } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                       $duree_vie = $this->_request->getPost("duree_vie");
                       } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                       $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                       }
                       $prix->setDuree_vie($duree_vie);
                       $prix->setCode_objet($code_objet);
                       $prix->setBoutique($boutique);
                       $prix->setRayon($this->_request->getPost("code_rayon"));
                       $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                       $prix->setCreer_par($num_membre);
                       $prix->setCode_demand($this->_request->getPost("code_demand"));
                       $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                       $prix->setMembre_rayon($membre);
                       $pm->save($prix);
                       return $this->_helper->redirector('index');        
                       }  
                    }   
                    else 
                    {
                     $row = $om->findobjet($this->_request->getPost("design_objet"));
                     $boutique=$om->findbout($this->_request->getPost("code_rayon"));
                     $rech=$pm->findcaract($row,$this->_request->getPost("code_rayon"));
                     $membre=$pm->findbout($this->_request->getPost("code_rayon"));
    
                     if (count($rech) == 1) {
                     $message = 'Ce produit existe déjà dans ce rayon ';
                     $this->view->message = $message;
                     $this->view->form = $form;
                     return;
                    }
                    else if (count($sub) == 1) {
                     $message = 'Cette subvention est déjà utilisée.';
                     $this->view->message = $message;
                     $this->view->form = $form;
                     return;
                     }
                     else 
                     {
                        $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                        if ($this->_request->getPost("unite_mdv") == 'jour') {
                        $duree_vie = $this->_request->getPost("duree_vie") / 30;
                        } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                        $duree_vie = $this->_request->getPost("duree_vie");
                        } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                          $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                        }
                        $prix->setDuree_vie($duree_vie);
                        $prix->setCode_objet($row);
                        $prix->setBoutique($boutique);
                        $prix->setRayon($this->_request->getPost("code_rayon"));
                        $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                        $prix->setCreer_par($num_membre);
                        $prix->setCode_demand($this->_request->getPost("code_demand"));
                        $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                        $prix->setMembre_rayon($membre);
                        $pm->save($prix);
                        return $this->_helper->redirector('index');   
                     }  
                }
              }
              else {
                  $message = 'Aucune donnée n\'a été envoyée dans la base.';
                  $this->view->message = $message;
                  $this->view->form = $form;
              }
          }      
    }
     
    public function envoi1Action() {
        
      $form = new Application_Form_EuObjetB();
      $request = $this->getRequest();
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $user = $auth->getIdentity();
      $num_membre = $user->num_membre;  
      if ($this->getRequest()->isPost()) {
          if ($form->isValid($request->getPost())){
                  $prix= new Application_Model_EuPrix();
                  $objet= new Application_Model_EuObjet();
                  $om = new Application_Model_EuObjetMapper();
                  $pm = new Application_Model_EuPrixMapper();
                  $objet_find = $om->findobjet($this->_request->getPost("design_objet"));
                  $sub = $pm->findsub($this->_request->getPost("code_demand"));
                  if (count($objet_find) < 1) {
                      if (count($sub) == 1) {
                        $message = 'Cette subvention est déjà utilisée.';
                        $this->view->message = $message;
                        $this->view->form = $form;
                        return;
                    }
                    else {
                    $count=$om->findConuter();
                    $nb=$count+1;
                    $code_objet=$nb.strtoupper(substr(htmlentities($this->_request->getPost("design_objet")),0,3)).'gp';
                    $objet->setCode_objet($code_objet);
                    $objet->setDesign_objet($this->_request->getPost("design_objet"));
                    $om->save($objet);
                    //$boutique=$om->findbout($this->_request->getPost("code_rayon"));
                    $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                    if ($this->_request->getPost("unite_mdv") == 'jour') {
                    $duree_vie = $this->_request->getPost("duree_vie") / 30;
                    } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                    $duree_vie = $this->_request->getPost("duree_vie");
                    } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                    $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                    }
                    $prix->setDuree_vie($duree_vie);
                    $prix->setCode_objet($code_objet);
                    $prix->setBoutique($this->_request->getPost("code_bout"));
                    $prix->setRayon(null);
                    $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                    $prix->setCreer_par($num_membre);
                    $prix->setCode_demand($this->_request->getPost("code_demand"));
                    $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                    $prix->setMembre_rayon('');
                    $pm->save($prix);
                    return $this->_helper->redirector('index');        
                    }  
                 }   
                    else 
                    {
                     $row = $om->findobjet($this->_request->getPost("design_objet"));
                     // $boutique=$om->findbout($this->_request->getPost("code_rayon"));
                     $rech=$pm->controle($row,$this->_request->getPost("code_bout"));
                     if (count($rech) == 1) {
                     $message = 'Ce produit existe déjà dans cette boutique';
                     $this->view->message = $message;
                     $this->view->form = $form;
                     return;
                    }
                    else if (count($sub) == 1) {
                     $message = 'Cette subvention est déjà utilisée.';
                     $this->view->message = $message;
                     $this->view->form = $form;
                     return;
                     }
                    else 
                    {
                     $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                     if ($this->_request->getPost("unite_mdv") == 'jour') {
                     $duree_vie = $this->_request->getPost("duree_vie") / 30;
                     } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                     $duree_vie = $this->_request->getPost("duree_vie");
                     } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                     $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                     }
                     $prix->setDuree_vie($duree_vie);
                     $prix->setCode_objet($row);
                     $prix->setBoutique($this->_request->getPost("code_bout"));
                     $prix->setRayon(null);
                     $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                     $prix->setCreer_par($num_membre);
                     $prix->setCode_demand($this->_request->getPost("code_demand"));
                     $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                     $prix->setMembre_rayon('');
                     $pm->save($prix);
                     return $this->_helper->redirector('index');   
                  }  
               }
           }
           else {
               $message = 'Aucune donnée n\'a été envoyée dans la base.';
               $this->view->message = $message;
           }
       }      
    }
    
    
    public function newAction() {
     
      $form = new Application_Form_EuObjetType();
      $request = $this->getRequest();
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $user = $auth->getIdentity();
      $num_membre = $user->num_membre;
      if ($this->getRequest()->isPost()) {
              if ($form->isValid($request->getPost())){
                  $type_boutique=$this->_request->getPost("type_boutique");
                  $this->view->type = $type_boutique;
                  if($type_boutique=='bc'){
                      $form1 = new Application_Form_EuObjet();
                      $this->view->form1 = $form1;
                  }
                  else if($type_boutique=='bs'){
                      $form2 = new Application_Form_EuObjetB();
                      $this->view->form2 = $form2;
                  }
           }            
     }        
         // Add the link to the cancel button
         $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-objet',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        //$this->view->zone = $zones;
        $this->view->form = $form; 
}
     
     public function detailAction(){
         
                $this->_helper->layout->disableLayout();
                $request = $this->getRequest();
                $id_value = $request->objet;
                $pm=new Application_Model_EuPrixMapper;
                $rayon=$pm->findrayon($id_value);
                if($rayon!='') {
                $tabela = new Application_Model_DbTable_EuPrix();
                $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                       ->join('eu_objet', 'eu_objet.code_objet = eu_prix.code_objet')
                       ->join('eu_boutique', 'eu_boutique.code_bout = eu_prix.boutique')
                       ->join('eu_rayon', 'eu_rayon.code_rayon = eu_prix.rayon')
                       ->join('eu_gamme_produit', 'eu_gamme_produit.code_gamme = eu_prix.num_gamme')  
                       ->where('eu_prix.id_value = ?', $id_value);
                $alloc = $tabela->fetchAll($select);
                $data=array(array());
                foreach ($alloc as $p) {
                   $data[1][1] = $p->code_objet;
                   $data[1][2] = $p->design_objet;
                   $data[1][3] = $p->prix_unitaire;
                   $data[1][4] = $p->duree_vie;
                   $data[1][5] = $p->code_gamme;
                   $data[1][6] = $p->design_gamme;
                   $data[1][7] = $p->code_rayon;
                   $data[1][8] = $p->design_rayon;
                   $data[1][9] = $p->code_bout;
                   $data[1][10] = $p->design_bout;
                   $data[1][11] = $p->caract_objet;
             }
             
                   $this->view->data = $data;
          }
          else    {
                   $tabela = new Application_Model_DbTable_EuPrix();
                   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                   $select->setIntegrityCheck(false)
                       ->join('eu_objet', 'eu_objet.code_objet = eu_prix.code_objet')
                       ->join('eu_boutique', 'eu_boutique.code_bout = eu_prix.boutique')
                       ->join('eu_gamme_produit', 'eu_gamme_produit.code_gamme = eu_prix.num_gamme')  
                       ->where('eu_prix.id_value = ?', $id_value);
                   $alloc = $tabela->fetchAll($select);
                   $data=array(array());
                   foreach ($alloc as $p) {
                     $data[1][1] = $p->code_objet;
                     $data[1][2] = $p->design_objet;
                     $data[1][3] = $p->prix_unitaire;
                     $data[1][4] = $p->duree_vie;
                     $data[1][5] = $p->code_gamme;
                     $data[1][6] = $p->design_gamme;
                     $data[1][7] = $p->code_bout;
                     $data[1][8] = $p->design_bout;
                     $data[1][9] = $p->caract_objet;       
          }
                     $this->view->data1 = $data;
       } 
          
                
    } 
    public function editAction() {
           $this->_helper->layout->disableLayout();
           $request = $this->getRequest();
           $form = new Application_Form_EuObjetM();
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $num_membre = $user->num_membre;
           if ($this->getRequest()->isPost()) {
                 $this->_helper->layout->enableLayout();
                 if ($form->isValid($request->getPost())) {
                      $mapper = new Application_Model_EuObjetMapper();
                      $mp = new Application_Model_EuPrixMapper();
                      //mise à jour de la table  prix
                      $prix = new Application_Model_EuPrix();
                      $prix_db = new Application_Model_DbTable_EuPrix();
                      $prix_find = $prix_db->find($this->getRequest()->id_value);
                      $result = $prix_find->current();
                      $rayon=$result->rayon;
                      $bout=$result->boutique;
                      $code_demand=$result->code_demand;
                      $memb=$result->membre_rayon;
                      
                      if($this->_request->getPost("code_rayon")) {                      
                      $boutique=$mapper->findbout($this->_request->getPost("code_rayon"));
                      $rech=$mp->findcaract($this->_request->getPost("code_objet"),$this->_request->getPost("code_rayon"));
                      $membre=$mp->findbout($this->_request->getPost("code_rayon"));
                      }
                      else
                      $rech=$mp->controle($this->_request->getPost("code_objet"),$this->_request->getPost("code_bout"));
                      $code=$mp->findsub($this->_request->getPost("code_demand"));
                      
                      if($this->_request->getPost("code_rayon")) {
                          
                         if (count($code)== 1 && count($rech) == 1) {
                               $prix->setId_value($this->getRequest()->id_value);
                               $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                               if ($this->_request->getPost("unite_mdv") == 'jour') {
                               $duree_vie = $this->_request->getPost("duree_vie") / 30;
                               } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                               $duree_vie = $this->_request->getPost("duree_vie");
                               } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                               $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                               }
                               $prix->setDuree_vie($duree_vie);
                               $prix->setCode_objet($this->_request->getPost("code_objet"));
                               $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                               $prix->setRayon($rayon);
                               $prix->setBoutique($bout);
                               $prix->setCreer_par($num_membre);
                               if(($this->_request->getPost("code_demand"))!='')
                               $prix->setCode_demand($code_demand);
                               else
                               $prix->setCode_demand('');    
                               $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                               $prix->setMembre_rayon($memb);
                               $mp->update($prix);
                               //$mp->delete($this->getRequest()->id_value);     
                      }
                      else if (count($code) == 1) {
                          $prix->setId_value($this->getRequest()->id_value);
                          $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                          if ($this->_request->getPost("unite_mdv") == 'jour') {
                          $duree_vie = $this->_request->getPost("duree_vie") / 30;
                          } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                          $duree_vie = $this->_request->getPost("duree_vie");
                          } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                            $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                          }
                          $prix->setDuree_vie($duree_vie);
                          $prix->setCode_objet($this->_request->getPost("code_objet"));
                          $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                          $prix->setRayon($this->_request->getPost("code_rayon"));
                          $prix->setBoutique($boutique);
                         // $prix->setType($bout);
                          $prix->setCreer_par($num_membre);
                          if(($this->_request->getPost("code_demand"))!='')
                          $prix->setCode_demand($code_demand);
                          else
                          $prix->setCode_demand('');    
                          $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                          $prix->setMembre_rayon($membre);
                          $mp->update($prix);
                          
                      }
                          else if (count($rech) == 1) {
                              
                          $prix->setId_value($this->getRequest()->id_value);
                          $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                          if ($this->_request->getPost("unite_mdv") == 'jour') {
                          $duree_vie = $this->_request->getPost("duree_vie") / 30;
                          } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                          $duree_vie = $this->_request->getPost("duree_vie");
                          } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                          $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                          }
                          $prix->setDuree_vie($duree_vie);
                          $prix->setCode_objet($this->_request->getPost("code_objet"));
                          $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                          $prix->setRayon($rayon);
                          $prix->setBoutique($bout);
                          $prix->setCreer_par($num_membre);
                          $prix->setCode_demand($this->_request->getPost("code_demand"));
                          $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                          $prix->setMembre_rayon($memb);
                          $mp->update($prix);
                          
                      }
                      else {
                          $prix->setId_value($this->getRequest()->id_value);
                          $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                          if ($this->_request->getPost("unite_mdv") == 'jour') {
                          $duree_vie = $this->_request->getPost("duree_vie") / 30;
                          } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                          $duree_vie = $this->_request->getPost("duree_vie");
                          } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                          $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                          }
                          $prix->setDuree_vie($duree_vie);
                          $prix->setCode_objet($this->_request->getPost("code_objet"));
                          $prix->setRayon($this->_request->getPost("code_rayon"));
                          $prix->setBoutique($boutique);
                          $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                          $prix->setCreer_par($num_membre);
                          $prix->setCode_demand($this->_request->getPost("code_demand"));
                          $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                          $prix->setMembre_rayon($membre);
                          $mp->update($prix);  
                      }      
                }
                else {
                          
                          if (count($code)== 1 && count($rech) == 1) {
                               $prix->setId_value($this->getRequest()->id_value);
                               $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                               if ($this->_request->getPost("unite_mdv") == 'jour') {
                               $duree_vie = $this->_request->getPost("duree_vie") / 30;
                               } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                               $duree_vie = $this->_request->getPost("duree_vie");
                               } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                                 $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                               }
                               $prix->setDuree_vie($duree_vie);
                               $prix->setCode_objet($this->_request->getPost("code_objet"));
                               $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                               $prix->setRayon(null);
                               $prix->setBoutique($bout);
                               $prix->setCreer_par($num_membre);
                               if(($this->_request->getPost("code_demand"))!='')
                               $prix->setCode_demand($code_demand);
                               else
                               $prix->setCode_demand('');    
                               $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                               $prix->setMembre_rayon('');
                               $mp->update($prix);
                               //$mp->delete($this->getRequest()->id_value);     
                      }
                      else if (count($code) == 1) {
                          
                          $prix->setId_value($this->getRequest()->id_value);
                          $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                          if ($this->_request->getPost("unite_mdv") == 'jour') {
                          $duree_vie = $this->_request->getPost("duree_vie") / 30;
                          } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                          $duree_vie = $this->_request->getPost("duree_vie");
                          } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                            $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                          }
                          $prix->setDuree_vie($duree_vie);
                          $prix->setCode_objet($this->_request->getPost("code_objet"));
                          $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                          $prix->setRayon(null);
                          $prix->setBoutique($this->_request->getPost("code_bout"));
                          $prix->setCreer_par($num_membre);
                          if(($this->_request->getPost("code_demand"))!='')
                          $prix->setCode_demand($code_demand);
                          else
                          $prix->setCode_demand('');    
                          $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                          $prix->setMembre_rayon('');
                          $mp->update($prix);
                          }
                          else if (count($rech) == 1) {
                              
                          $prix->setId_value($this->getRequest()->id_value);
                          $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                          if ($this->_request->getPost("unite_mdv") == 'jour') {
                          $duree_vie = $this->_request->getPost("duree_vie") / 30;
                          } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                            $duree_vie = $this->_request->getPost("duree_vie");
                          } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                            $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                          }
                          $prix->setDuree_vie($duree_vie);
                          $prix->setCode_objet($this->_request->getPost("code_objet"));
                          $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                          $prix->setRayon($rayon);
                          $prix->setBoutique($bout);
                          $prix->setCreer_par($num_membre);
                          $prix->setCode_demand($this->_request->getPost("code_demand"));
                          $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                          $prix->setMembre_rayon($memb);
                          $mp->update($prix);  
                      }
                      else {
                          
                          $prix->setId_value($this->getRequest()->id_value);
                          $prix->setPrix_unitaire($this->_request->getPost("prix_unitaire"));
                          if ($this->_request->getPost("unite_mdv") == 'jour') {
                          $duree_vie = $this->_request->getPost("duree_vie") / 30;
                          } else if ($this->_request->getPost("unite_mdv") == 'mois') {
                          $duree_vie = $this->_request->getPost("duree_vie");
                          } else if ($this->_request->getPost("unite_mdv") == 'annee') {
                          $duree_vie = (365.25 / 30) * $this->_request->getPost("duree_vie");
                          }
                          $prix->setDuree_vie($duree_vie);
                          $prix->setCode_objet($this->_request->getPost("code_objet"));
                          $prix->setRayon($rayon);
                          $prix->setBoutique($this->_request->getPost("code_bout"));
                          $prix->setNum_gamme($this->_request->getPost("num_gamme"));
                          $prix->setCreer_par($num_membre);
                          $prix->setCode_demand($this->_request->getPost("code_demand"));
                          $prix->setCaract_objet($this->_request->getPost("caract_objet"));
                          $prix->setMembre_rayon($memb);
                          $mp->update($prix);  
                      }
                   }
                          return $this->_helper->redirector('index');
                }    
          }
            else {
                
                 $id_value = $request->objet;
                 $mp = new Application_Model_EuPrixMapper();
                 $prix = new Application_Model_EuPrix();
                 $mp->find($id_value,$prix);
                 $code_objet=$mp->findobjet($id_value);
                 $mapper = new Application_Model_EuObjetMapper();
                 //$num_gamme=$mapper->findgamme($code_objet);
                 //$code_bout=$mapper->findbout($num_gamme);
                 $objet = new Application_Model_EuObjet();
                 $mapper->find($code_objet, $objet);
            
                 if ($prix->getId_value() == $id_value) {
                    $data = array(
                          'code_objet' => $objet->getCode_objet(),
                          'design_objet' => $objet->getDesign_objet(),
                          'num_gamme' => $prix->getNum_gamme(),
                          'id_value' => $prix->getId_value(),
                          'prix_unitaire' => $prix->getPrix_unitaire(),
                          'duree_vie' => $prix->getDuree_vie(),
                          'code_rayon' => $prix->getRayon(),
                          'code_bout' => $prix->getBoutique(),
                          'caract_objet' => $prix->getCaract_objet(),
                          'code_demand' => $prix->getCode_demand(), 
                          'unite_mdv' =>'mois',
                );
                $form->populate($data);
            }
            $this->view->objet = $objet;
            $this->view->form = $form;    
        }   
     }        
}