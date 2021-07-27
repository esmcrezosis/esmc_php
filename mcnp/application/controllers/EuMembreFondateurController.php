<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EuMembreFondateurController extends Zend_Controller_Action {
    
      function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'apa') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
	
	
	
	
    public function init() {
        $menu = '<li><a id="listemf" href="/eu-membre-fondateur/index" style="font-size:11px">Liste domiciliation</a></li>
                <li><a id="new" href="/eu-membre-fondateur/new" style="font-size:11px">Nouveau</a></li>';
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();   
    }
	
	
	
	
	public function indexAction() {
	
	}
	
	
	
	public function newAction() {
	
	}
	
	public function deviseAction() {
        $m_dev = new Application_Model_EuDeviseMapper();
        $results = $m_dev->fetchAll();
        $data = array();
        foreach ($results as $value) {
            $data[] = $value->getCode_dev();
        }
        $this->view->data = $data;
    }
	
	public function typemfAction() {
	
	    $t_type = new Application_Model_DbTable_EuTypeMf();
        $types = $t_type->fetchAll();
        if (count($types) >= 1) {
            $data = array();
            for ($i = 0; $i < count($types); $i++) {
                $value = $types[$i];
                $data[$i][0] = $value->code_type_mf;
                $data[$i][1] = $value->lib_type_mf;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
	
	}
	
	public function uniteAction() {
	
	    $t_type = new Application_Model_DbTable_EuUnite();
        $types = $t_type->fetchAll();
        if (count($types) >= 1) {
            $data = array();
            for ($i = 0; $i < count($types); $i++) {
                $value = $types[$i];
                $data[$i][0] = $value->code_unite;
                $data[$i][1] = $value->lib_unite;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
	
	}
	
	
	
	public function membreapporteurAction(){
	       $data = array();
	       $type_membre = $_GET["type_membre"];
		   if($type_membre!='' && $type_membre=='p') {
		      $mb = new Application_Model_DbTable_EuMembre();
              $result = $mb->fetchAll();
              foreach ($result as $p) {
                  $data[] = $p->code_membre;
              }   
		   }
		   else if($type_membre!='' && $type_membre=='m') {
		       $mb = new Application_Model_DbTable_EuMembreMorale();
               $result = $mb->fetchAll();
               foreach ($result as $p) {
                  $data[] = $p->code_membre_morale;
               }
		    
		  }else {
            $data = '';
          }
	      $this->view->data = $data;
	}
	
	public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[1] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->PREnom_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	public function recupraisonAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[1] = strtoupper($result->raison_sociale) ;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	
	
	public function convertirAction() {

        $dev = $_GET['dev'];
        $dev1 = $_GET['dev1'];
        if ($dev != $dev1) {
            if ($dev != $dev1) {
                $code_cours = $dev . '-' . $dev1;
                $cours = new Application_Model_EuCours();
                $m_cours = new Application_Model_EuCoursMapper();
                $ret = $m_cours->find($code_cours, $cours);
                if ($ret) {
                    $mont_apport = $_GET['montant'];
                    if ($mont_apport != '') {
                        $montant = $mont_apport * $cours->getVal_dev_fin();
                        $data = $montant;						
                    }
                } else {
                       $data = false;
                }
            }
        }

        $this->view->data = $data;
    }
	
	
	public function codesmsAction() {
        $code = $_GET["code"];
        if ($code != '') {
            $data = array();
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('creditcode = ?', $code)
                    ->where('iddatetimeconsumed = ?', 0);
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $mont_capa = $results->current()->creditamount;
                $data = $mont_capa;
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
    }
	
	
	public function donew() {
	    $compte     = new Application_Model_EuCompte();
        $map_compte = new Application_Model_EuCompteMapper();
        $mf         = new Application_Model_EuMf();
		$map_mf     = new Application_Model_EuMfMapper();
		$mfu         = new Application_Model_EuMfUnite();
		$map_mfu     = new Application_Model_EuMfUniteMapper();
		$date = Zend_Date::now();
		$db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
		try { 
		    $membre   =  $_POST["code_membre"];
            $montant  =  $_POST["mont_sms"];
		    $type_mf  =  $_POST["type_mf"];
		    $unite    =  $_POST["unite"];
		    $code_dev = $_POST['dev_apport'];
            $code_sms = $_POST["code_sms"];			 
		  
		    if ($code_dev != 'xof') {
                $code_cours = $code_dev . '-xof';
                $cours = new Application_Model_EuCours();
                $m_cours = new Application_Model_EuCoursMapper();
                $ret = $m_cours->find($code_cours, $cours);
                if ($ret) {
                     if ($montant != '') {
                       $montant = $montant * $cours->getVal_dev_fin();
                     }
                }
            } 
            $sms_mapper = new Application_Model_EuSmsmoneyMapper();
            $sms = $sms_mapper->findByCreditCode($code_sms);  
			if ($sms != null) {
			        
					
					                            
            } else {
                   $db->rollBack();
                   $this->view->data = 'Le Code sms ' . $code_sms . ' a dejà été utilisé ou invalide!!!';
                   return;
            } 

				 
		    
		} catch (Exception $e) {
                $db->rollback();
                $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
        }
	
	
	}
	
	
	
	
	
	
   
}
?>