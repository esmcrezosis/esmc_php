<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
class EuConsulterMController extends Zend_Controller_Action  {

        public function init() {
            $this->view->jQuery()->enable();
            $this->view->jQuery()->uiEnable();
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group == 'contrat' ||  $group == 'enrolement' ||  $group == 'mise_chaine') {
                $menu = '<li><a href="/eu-consulter-m/statistique" style="font-size:9px">Statistiques</a></li>
                      <li><a href="/eu-consulter-m/detail" style="font-size:9px">Détails</a></li>';
                }
                $this->view->placeholder("menu")->set($menu);
        }
      
        function preDispatch() {
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            if (!$auth->hasIdentity()) {
              $this->_redirect('login');
            } 
            else {
                 $user = $auth->getIdentity();
                 $group = $user->code_groupe;
                 if ($group != 'contrat' and $group != 'enrolement' and  $group != 'mise_chaine') {
                    $this->view->user = $user;
                    return $this->_redirect('index2');
                 }
                 $this->view->user = $user;
            }  
        }
    
    
    public function indexAction() {
        
    }

    
    public function statistiqueAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group_create = $user->code_groupe_create;
		$code_acteur = $user->code_acteur;
		   
		$tabela = new Application_Model_DbTable_EuActeur();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
		       ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			   ->where('eu_acteur.code_acteur like ?',$code_acteur);
			   
		$alloc = $tabela->fetchAll($select);
		$row = $alloc->current();
		   
        $t_membre = new Application_Model_DbTable_EuMembre();
		$t_membremorale = new Application_Model_DbTable_EuMembreMorale();
           
		// total des membres enrôlés
		if($group_create == 'surveillance')  {
		    $se = $t_membre->select();
            $re = $t_membre->fetchAll($se);
		    $se_m = $t_membremorale->select();
            $re_m = $t_membre->fetchAll($se_m);
			
        } else {
			$se = $t_membre->select();
			$se->where('code_agence like ?',$row->code_agence);
            $re = $t_membre->fetchAll($se);
		    $se_m = $t_membremorale->select();
			$se_m->where('code_agence like ?',$row->code_agence);
            $re_m = $t_membre->fetchAll($se_m);
		     
		}
		  
		  
        // total des nouveaux membres enrôlés 
		    if($group_create == 'surveillance')  {
               $select = $t_membre->select();
               $select->where('etat_membre like  ?','N');
               $result = $t_membre->fetchAll($select);
              
			   $select_m = $t_membremorale->select();
               $select_m->where('etat_membre like  ?','N');
               $result_m = $t_membremorale->fetchAll($select_m);
			   
			} else {
			   $select = $t_membre->select();
               $select->where('etat_membre like  ?','N');
			   $select->where('code_agence like ?',$row->code_agence);
               $result = $t_membre->fetchAll($select);
              
			   $select_m = $t_membremorale->select();
               $select_m->where('etat_membre like  ?','N');
			   $select_m->where('code_agence like ?',$row->code_agence);
               $result_m = $t_membremorale->fetchAll($select_m);
			}
           
            $this->view->totalm     =    count($re) + count($re_m);
            $this->view->totalnm    =    count($result) + count($result_m);
		    $this->view->totalmpp   =    count($re);
            $this->view->totalnmpp  =    count($result);
            $this->view->totalampp  =    count($re) - count($result);
            $this->view->totalmpm   =    count($re_m);
            $this->view->totalnmpm  =    count($result_m);
            $this->view->totalampm  =    count($re_m) - count($result_m);              
    }

    public function detailAction() {
        
    }

    public function agenceAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group_create = $user->code_groupe_create;
		$code_acteur = $user->code_acteur;   
		$tabela = new Application_Model_DbTable_EuActeur();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
		       ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			   ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
		$alloc = $tabela->fetchAll($select);
		$row = $alloc->current();
        $ag = array();
        $tab = new Application_Model_DbTable_EuAgence();
        $sel = $tab->select();
		
		if($group_create != 'surveillance') {
		   $sel->where('eu_agence.code_agence like ?',$row->code_agence);
		}
            
        $sel->order('libelle_agence asc');
        $agences = $tab->fetchAll($sel);
        $i = 0;
        foreach ($agences as $value) {   
          $ag[$i][0] = $value->code_agence;
          $ag[$i][1] = ucfirst($value->libelle_agence);
          $i++;
        } 
        $this->view->data = $ag;     
    }
    
    public function gacregionAction() {
       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin')); 
       $user = $auth->getIdentity();
       $ag = array();
       $tab = new Application_Model_DbTable_EuGac();
       $sel = $tab->select();
       $sel->where('code_type_gac like ?','gac_region');
       $sel->order('nom_gac asc');
       $gacs = $tab->fetchAll($sel);
       $i = 0;
       foreach ($gacs as $value) {   
         $ag[$i][0] = $value->code_gac;
         $ag[$i][1] = ucfirst($value->nom_gac);
         $i++;
       } 
       $this->view->data = $ag;     
    }
    
    public function gacsecteurAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin')); 
        $user = $auth->getIdentity();
        $ag = array();
        $tab = new Application_Model_DbTable_EuGac();
        $sel = $tab->select();
        $sel->where('code_type_gac like ?','gac_secteur');
        $sel->order('nom_gac asc');
        $gacs = $tab->fetchAll($sel);
        $i = 0;
        foreach ($gacs as $value) {   
         $ag[$i][0] = $value->code_gac;
         $ag[$i][1] = ucfirst($value->nom_gac);
         $i++;
        } 
        $this->view->data = $ag;     
    }
    
    
    public function gacagenceAction() {
       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin')); 
       $user = $auth->getIdentity();
       $ag = array();
       $tab = new Application_Model_DbTable_EuGac();
       $sel = $tab->select();
       $sel->where('code_type_gac like ?','gac_agence');
       $sel->order('nom_gac asc');
       $gacs = $tab->fetchAll($sel);
       $i = 0;
       foreach ($gacs as $value) {   
         $ag[$i][0] = $value->code_gac;
         $ag[$i][1] = ucfirst($value->nom_gac);
         $i++;
       } 
       $this->view->data = $ag;     
    }
    
    public function datamiseAction() {
	
      //$user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $user = $auth->getIdentity();
      $group_create = $user->code_groupe_create;
	  
	  $code_acteur = $user->code_acteur;   
	  $tabela = new Application_Model_DbTable_EuActeur();
      $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
      $select->setIntegrityCheck(false)
		     ->join('eu_membre_morale','eu_membre_morale.code_membre_morale = eu_acteur.code_membre')
			 ->where('eu_acteur.code_acteur like ?',$code_acteur);	   
	  $alloc = $tabela->fetchAll($select);
	  $row = $alloc->current();
	     
      $this->_helper->layout->disableLayout();
      $page = $this->_request->getParam("page", 1);
      $limit = $this->_request->getParam("rows", 10);
      $sidx = $this->_request->getParam("sidx", 'code_membre_morale');
      $sord = $this->_request->getParam("sord", 'asc');
        
      $code_agence = $this->_request->getParam("agence");
      $date = $this->_request->getParam("date");
      $tabela = new Application_Model_DbTable_EuMembreMorale();
      
	  
	  if($group_create == 'surveillance') {
	          
      if($date != '' && $code_agence != '') {
         $select = $tabela->select();  
         $date1 = explode("/", $date);
         $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
         $select->where('eu_membre_morale.code_agence like ?',$code_agence)
                ->where('eu_membre_morale.date_identification like ?',$dated)
			    ->order('eu_membre_morale.code_membre_morale');
    }
    elseif ($code_agence != '') {
       $select = $tabela->select();  
       $select->where('eu_membre_morale.code_agence like ?',$code_agence)
	          ->order('eu_membre_morale.code_membre_morale');
    }
    elseif($date != '') {
       $select = $tabela->select();
       $date1 = explode("/", $date);
       $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
       $select->where('eu_membre_morale.date_identification like ?',$dated)
	          ->order('eu_membre_morale.code_membre_morale');
    }
       else {
       $select = $tabela->select();  
    }
	
	} else {
	        
	    if($date != '' && $code_agence != '')  {
        $select = $tabela->select();  
        $date1 = explode("/", $date);
        $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $select->where('eu_membre_morale.code_agence like ?',$code_agence)
               ->where('eu_membre_morale.date_identification like ?',$dated)
			   ->order('eu_membre_morale.code_membre_morale');
        }
        elseif ($code_agence != '') {
            $select = $tabela->select();  
            $select->where('eu_membre_morale.code_agence like ?',$code_agence)
	               ->order('eu_membre_morale.code_membre_morale');
         }
         elseif($date != '') {
             $select = $tabela->select();
             $date1 = explode("/", $date);
             $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
             $select->where('eu_membre_morale.date_identification like ?',$dated)
	                ->order('eu_membre_morale.code_membre_morale')
					->where('eu_membre_morale.code_agence like ?',$row->code_agence);
         }
        else {
             $select = $tabela->select();
			 $select->where('eu_membre_morale.code_agence like ?',$row->code_agence);  
        }
	
	    }
           
        $membres = $tabela->fetchAll($select);
        $count = count($membres);
        if ($count > 0) {
               $total_pages = ceil($count / $limit);
        } else {
               $total_pages = 0;
        }
        if ($page > $total_pages)
           $page = $total_pages;

           $membres = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

           $responce['page'] = $page;
           $responce['total'] = $total_pages;
           $responce['records'] = $count;
           $i = 0;

            foreach ($membres as $row) {
              $responce['rows'][$i]['id'] = $row->code_membre_morale;
              $responce['rows'][$i]['cell'] = array( 
                $row->code_agence,
                //$row->libelle_agence, 
                $row->code_membre_morale,
                $row->raison_sociale,
                 //$row->profession_membre,
                $row->date_identification     
            );
                $i++;
            }
            $this->view->data = $responce;
                 
        }
	
	
    
    public function dataenroAction() {
      //$user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
         
      $this->_helper->layout->disableLayout();
      $page = $this->_request->getParam("page", 1);
      $limit = $this->_request->getParam("rows", 10);
      $sidx = $this->_request->getParam("sidx", 'code_membre');
      $sord = $this->_request->getParam("sord", 'asc');
        
      $code_agence = $this->_request->getParam("agence");
      $date = $this->_request->getParam("date");
      $tabela = new Application_Model_DbTable_EuMembre();
            
      if($date != '' && $code_agence != '') {
        $select = $tabela->select();  
        $date1 = explode("/", $date);
        $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $select->where('eu_membre.code_agence like ?',$code_agence)
               ->where('eu_membre.date_identification like ?',$dated)
			   ->order('eu_membre.code_membre');
     }
     elseif ($code_agence != '') {
       $select = $tabela->select();  
       $select->where('eu_membre.code_agence like ?',$code_agence)
	          ->order('eu_membre.code_membre');
     }
     elseif($date != '') {
       $select = $tabela->select();
       $date1 = explode("/", $date);
       $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
       $select->where('eu_membre.date_identification like ?',$dated)
	          ->order('eu_membre.code_membre');
     }
     else {
       $select = $tabela->select();  
     }
           
       $membres = $tabela->fetchAll($select);
       $count = count($membres);
       if ($count > 0) {
               $total_pages = ceil($count / $limit);
       } else {
               $total_pages = 0;
       }
       if ($page > $total_pages)
           $page = $total_pages;

           $membres = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;

            foreach ($membres as $row) {
              $responce['rows'][$i]['id'] = $row->code_membre;
              $responce['rows'][$i]['cell'] = array( 
                 $row->code_agence,
                 //$row->libelle_agence, 
                 $row->code_membre,
                 //$row->raison_sociale,
                 $row->nom_membre,
                 $row->prenom_membre,
                 //$row->profession_membre,
                 $row->date_identification     
            );
            $i++;
            }
            $this->view->data = $responce;
                 
       }

 }

?>
