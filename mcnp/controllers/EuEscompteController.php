<?php
class EuEscompteController extends Zend_Controller_Action { 

      function preDispatch() {
	      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
		  if (!$auth->hasIdentity()) {
            $this->_redirect('login');
          } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
			if (($group != 'escompte')) {
			    $this->view->user = $user;
                return $this->_redirect('index2');
            }
                $this->view->user = $user;	
	      }		
	  
	  }
	  
	  
	  //put your code here
      public function init() {
          $this->view->jQuery()->enable();
          $this->view->jQuery()->uiEnable();
          $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
          $user = $auth->getIdentity();
          $group = $user->code_groupe;
          if ($group == "escompte") {       
		     $menu = "<li><a href=\" /eu-escompte/new \"  style=\"font-size:9px\">Nouveau</a></li>".
			         "<li><a href=\" /eu-escompte/index\" style=\"font-size:9px\">Consultation</a></li>";   	   
          } 
          $this->view->placeholder("menu")->set($menu);
		
	   }
	   
	   
	   public function newAction() {
	   
	 
	   }
	   
	   
	   
	   public function indexAction() { 
	   
	   
	   
	   }
	   
	   
	   public function changemoralAction() {
           $data = array();
           $mb = new Application_Model_DbTable_EuMembreMorale();
           $select = $mb->select();
           $result = $mb->fetchAll($select);
           foreach ($result as $p) {
              $data[] = $p->code_membre_morale;
           }
           $this->view->data = $data;
       }
	   
	   public function recupmoralAction() {
          $num_membre = $_GET['num_membre'];
          $membre_db = new Application_Model_DbTable_EuMembreMorale();
          $membre_find = $membre_db->find($num_membre);
          if (count($membre_find) == 1) {
             $result = $membre_find->current();
             $data[0] = strtoupper($result->raison_sociale);
          } else {
            $data = '';
          }
          $this->view->data = $data;
       }
	   
	   public function dataAction(){
	     $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
         $user = $auth->getIdentity();
		 $request = $this->getRequest();
         $code_membre = $request->code_membre;
		 if(($user->code_groupe_create == 'detentrice') || ($user->code_groupe_create == 'surveillance') || ($user->code_groupe_create == 'executante')) {
		     $groupe_parent = $user->code_groupe_create;     
		   }
		   else {
		     $parent = explode("_",$user->code_groupe_create);
		     $groupe_parent = $parent[0];
		   }
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_tpagcp');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select();
		if($groupe_parent == 'executante') {
		  if($code_membre =="") {
              $select->where('escomptable in (?)',array(1,2,3));
		  }else {
              $select->where('escomptable in (?)',array(1,2,3));
			  $select->where('code_membre like ?', $code_membre);
          }	 
		} elseif($groupe_parent == 'surveillance') {
		  if($code_membre =="") {
             $select->where('escomptable in (?)',array(1,2,3));
		  } else {
              $select->where('escomptable in (?)',array(1,2,3));
			  $select->where('code_membre like ?', $code_membre);
          }	 
		  
		} elseif($groupe_parent == 'detentrice') {
		  if($code_membre =="") {
            $select->where('escomptable in (?)',array(1,2,3));
		  } else {
              $select->where('escomptable in (?)',array(1,2,3));
			  $select->where('code_membre like ?', $code_membre);
          }	
		}  
        $select->order('date_deb asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);
        if ($count > 0) {
           $total_pages = ceil($count / $limit);
        } else {
           $total_pages = 0;
        }
        if ($page > $total_pages)
        $page = $total_pages;
        $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $tot_tranche = 0;
        $tot_gcp = 0;
        $tot_echu = 0;
        $tot_solde = 0;
        foreach ($achats as $row) {
		    if($row->escomptable ==3) {
			  $escomptable = 'Oui';
			}elseif($row->escomptable ==2) {
			  $escomptable = 'En cours';
			}elseif($row->escomptable ==1) {
			  $escomptable = 'En cours';
			}
            $responce['rows'][$i]['id'] = $row->id_tpagcp;
            $responce['rows'][$i]['cell'] = array(
                $row->id_tpagcp,
                $row->code_membre,
                $row->code_compte,
				$row->date_deb,
                $row->date_fin,
                $row->mont_gcp,
				$row->mont_tranche,
                $row->mont_echu,
                $row->solde,
				$escomptable
            );
            $tot_tranche += $row->mont_tranche; 
            $tot_gcp += $row->mont_gcp; 
            $tot_solde += $row->solde;
            $tot_echu += $row->mont_echu;
            $i++;
        }
        $responce['userdata']['mont_tranche'] = $tot_tranche; 
        $responce['userdata']['mont_gcp'] = $tot_gcp;
        $responce['userdata']['mont_echu'] = $tot_echu;  
        $responce['userdata']['solde'] = $tot_solde; 
        $responce['userdata']['code_membre'] = 'Totaux:';
        $this->view->data = $responce; 
	   
	   }
	   
	   public function tpagcpAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		if(isset($_GET['code_membre'])){
		  $code_membre = $_GET['code_membre'];
		} else{
		  $code_membre = "";
		}  
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_tpagcp');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select();
        $select->where('code_membre like ?',$code_membre);
        $select->order('date_deb asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);
        if ($count > 0) {
           $total_pages = ceil($count / $limit);
        } else {
           $total_pages = 0;
        }
        if ($page > $total_pages)
        $page = $total_pages;
        $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        $tot_tranche = 0;
        $tot_gcp = 0;
        $tot_echu = 0;
        $tot_solde = 0;
        foreach ($achats as $row) {
            $responce['rows'][$i]['id'] = $row->id_tpagcp;
            $responce['rows'][$i]['cell'] = array(
                $row->id_tpagcp,
                $row->code_membre,
                $row->code_compte,
				$row->date_deb,
                $row->date_fin,
                $row->mont_gcp,
				$row->mont_tranche,
                $row->mont_echu,
                $row->solde,
				$row->escomptable
            );
            $tot_tranche += $row->mont_tranche; 
            $tot_gcp += $row->mont_gcp; 
            $tot_solde += $row->solde;
            $tot_echu += $row->mont_echu;
            $i++;
        }
        $responce['userdata']['mont_tranche'] = $tot_tranche; 
        $responce['userdata']['mont_gcp'] = $tot_gcp;
        $responce['userdata']['mont_echu'] = $tot_echu;  
        $responce['userdata']['solde'] = $tot_solde; 
        $responce['userdata']['code_membre'] = 'Totaux:';
        $this->view->data = $responce;
    }
	
	
	public function changeAction() {
        $data = array();
        $membre = new Application_Model_DbTable_EuMembreMorale();
        $select=$membre->select();
        $select->from($membre, array('code_membre_morale'));
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
            $data[] = $m->code_membre_morale;
        }
        $this->view->data = $data;
    }
	
	   
	public function createtpagcpAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           if(($user->code_groupe_create == 'detentrice') || ($user->code_groupe_create == 'surveillance') || ($user->code_groupe_create == 'executante')) {
		     $groupe_parent = $user->code_groupe_create;     
		   }
		   else {
		     $parent = explode("_",$user->code_groupe_create);
		     $groupe_parent = $parent[0];
		   }		
		   $tpagcp_mapper = new Application_Model_EuTpagcpMapper();
		   $tab_tpagcp = new Application_Model_DbTable_EuTpagcp();
           $tpagcp = new Application_Model_EuTpagcp();
	       $selection = array();
           $selection = $_GET['lignes'];
		   $id_tpagcp='';
		   if (count($selection) > 0) {
		      $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
              try {
			  
		            foreach ($selection as $tab) {
				    $id_tpagcp = $tab['id_tpagcp'];
				    $result = $tpagcp_mapper->find($id_tpagcp,$tpagcp);
					// Mise à jour des gcp prélévés
					if($result) {
				       if(($tpagcp->getEscomptable() == 0) || ($groupe_parent == 'executante' && $tpagcp->getEscomptable() == 0)) {
					      $tpagcp->setEscomptable($tpagcp->getEscomptable() + 1);
					      $tpagcp_mapper->update($tpagcp);
					   }
					   elseif(($tpagcp->getEscomptable() == 1) || ($groupe_parent == 'surveillance' && $tpagcp->getEscomptable() == 1)) {
					      $tpagcp->setEscomptable($tpagcp->getEscomptable() + 1);
					      $tpagcp_mapper->update($tpagcp);
					   }
					   elseif(($tpagcp->getEscomptable() == 2) || ($groupe_parent == 'detentrice' && $tpagcp->getEscomptable() == 2)) {
					      $tpagcp->setEscomptable($tpagcp->getEscomptable() + 1);
					      $tpagcp_mapper->update($tpagcp);
					   } else {
					      $db->rollback();
					      $this->view->data = 'alerte';
					      return;
					   }
					     
				   }       
				  
				  }
		          $db->commit();
                  $this->view->data = 'good';
                  return;
		      }   catch (Exception $exc) {
                  $db->rollback();
                  $message = ' Erreur d\'éxécution : '.$exc->getMessage() . ': ' . $exc->getTraceAsString();
                  //$this->view->message = $message;
                  $this->view->data = $message;
                  return;
              }

		   }
		    
	}  	   
	   
}	   