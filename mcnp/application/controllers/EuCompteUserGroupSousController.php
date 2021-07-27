<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuCompteUserGroupSousController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        
				$table3 = new Application_Model_DbTable_EuUserGroup();
				$select3 = $table3->select();
				$select3->where("code_groupe = ? ", $group);
				$Rows3 = $table3->fetchAll($select3);
				
				
        if (count($Rows3) > 0 || $group == 'agregat' || $group == 'detentrice' || $group == 'surveillance' || $group == 'executante' || $group == 'nn' || $group == 'cnp' || $group == 'fn' || $group == 'd_fgcnp' || $group == 'fgnr' || $group == 'FGnn' || $group == 'd_achatpppm' || $group == 'v_rscaps' || $group == 'd_achatpp' || $group == 'd_achatpm' || $group == 'd_reapropm'  || $group == 'e_achatpp' || $group == 'e_achatpm' || $group == 'e_rscaps' || $group == 'e_reapropm' || $group == 'e_achatppPM'  || $group == 'd_consopp' || $group == 'd_consopm' || $group == 'd_reapropm' || $group == 'd_fgsmc' || $group == 'smcinr' || $group == 'dd' || $group == 'Rdd' || $group == 'rds' || $group == 'rdg' || $group == 'rfp' || $group == 'rfa' || $group == 'rdf' || $group == 'rda' || $group == 'rdp' || $group == 'enbrpg' || $group == 'enbi' || $group == 'enbrpgnr' || $group == 'EnnMF' || $group == 'EMNRCNCSnr' || $group == 'ENRnn' || $group == 'ENBnn' || $group == 'enbnb' || $group == 'fgnrFGnn' || $group == 'FGNBFGnn' || $group == 'fgnbfgnb' || 
				$group == 'efgnn'   || $group == 'fgnne'   || $group == 'fgnbe'   || $group == 'efgnb' || $group == 'e_fgnn'   || $group == 'e_fgcnp' || $group == 'e_fgsmc' || $group == 'e_fgfgfn'  || $group == 'e_consopp'  || $group == 'e_consopm'  || $group == 'e_reapro.pm' 
				
				 || $group == 'ep_fgnn'   || $group == 'ep_fgcnp' || $group == 'ep_fgsmc' || $group == 'ep_fgfgfn'  || $group == 'ep_consopp'  || $group == 'ep_consopm'  || $group == 'ep_reapro.pm' 
				
				  || $group == 'fgrpg' || $group == 'fgib' || $group == 'fgir' || $group == 'fgcncs' || $group == 'fgnnpp' || $group == 'controleaudit' || $group == 'ppp'
		   || $group == 'smc' || $group == 'reglementation' || $group == 'controlefn' || $group == 'protection' || $group == 'acnevtpstps' || $group == 'acnevtpsbps' || $group == 'acnevpbftpstps'
		   || $group == 'enrolement' || $group == 'mise_chaine' || $group == 'apa' || $group == 'smcipn' || $group == 'audit' || $group == 'alerte' || $group == 'assurance'
		   || $group == 'bnp' || $group == 'domiciliation' || $group == 'collecte' || $group == 'repartition' 
		   
		   || $group == 'ed_fgnn'   || $group == 'ed_fgcnp' || $group == 'ed_fgsmc' || $group == 'ed_fgfgfn'  || $group == 'ed_consopp'  || $group == 'ed_consopm'  || $group == 'ed_reapro.pm' 
		   
		   || $group == 'sg_fgnn'   || $group == 'sg_fgcnp' || $group == 'sg_fgsmc' || $group == 'sg_fgfgfn'  || $group == 'sg_consopp'  || $group == 'sg_consopm'  || $group == 'sg_reapro.pm' 
		   
		   || $group == 'g_fgnn'   || $group == 'g_fgcnp' || $group == 'g_fgsmc' || $group == 'g_fgfgfn'  || $group == 'g_consopp'  || $group == 'g_consopm'  || $group == 'g_reapro.pm' 
		   
		   || $group == 'Admin-terrain' || $group == 'at_fgnn'   || $group == 'at_fgcnp' || $group == 'at_fgsmc' || $group == 'at_fgfgfn'  || $group == 'at_consopp'  || $group == 'at_consopm'  || $group == 'at_reapro.pm' 
		   ) {
			   
			   
			   


                   $menu = "<li><a href=\" /eu-compte-user-group-sous/new \">Nouveau</a></li>".
			        "<li><a href=\" /eu-compte-user-group-sous/index\">Liste des sous comptes</a></li>";
  
        $table = new Application_Model_DbTable_EuUtilisateur();
        $select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select->where('eu_utilisateur.id_utilisateur_parent = ?',$user->id_utilisateur);
        $select->order('id_utilisateur asc');
        $Rows = $table->fetchAll($select);
			   


  
				/*$table = new Application_Model_DbTable_EuUserGroup();
				$select = $table->select();
				$select->where('code_groupe_parent = ?', $user->code_groupe);
				$Rows = $table->fetchAll($select);*/
			   if(count($Rows) > 0) { 

				   //$menu .="<li></li><li>";
					//$menu ="";<ul id="menu_acc">width: 100px;
				   $menu .= '
            <li><a href="#" class="menuLink">Tableau de bord</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				 
				   foreach ($Rows as $row) {
					   	/*$table2 = new Application_Model_DbTable_EuUserGroup();
				$select2 = $table2->select();
				$select2->where('code_groupe_parent = ?', $row->code_groupe);
				$Rows2 = $table2->fetchAll($select2);*/
        $table2 = new Application_Model_DbTable_EuUtilisateur();
        $select2 = $table2->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select2->setIntegrityCheck(false);
        $select2->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select2->where('eu_utilisateur.id_utilisateur_parent = ?',$row->id_utilisateur);
        $select2->order('id_utilisateur asc');
        $Rows2 = $table2->fetchAll($select2);
			   if(count($Rows2) > 0) {
				   $menu .= '
            <li><a href="#" class="menuLink">'.($row->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				   foreach ($Rows2 as $row2) {
					   	/*$table3 = new Application_Model_DbTable_EuUserGroup();
				$select3 = $table3->select();
				$select3->where('code_groupe_parent = ?', $row2->code_groupe);
				$Rows3 = $table3->fetchAll($select3);*/
        $table3 = new Application_Model_DbTable_EuUtilisateur();
        $select3 = $table3->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select3->setIntegrityCheck(false);
        $select3->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select3->where('eu_utilisateur.id_utilisateur_parent = ?',$row2->id_utilisateur);
        $select3->order('id_utilisateur asc');
        $Rows3 = $table3->fetchAll($select3);
			   if(count($Rows3) > 0) {
				   $menu .= '
            <li><a href="#" class="menuLink">'.($row2->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				   foreach ($Rows3 as $row3) {
					   	/*$table4 = new Application_Model_DbTable_EuUserGroup();
				$select4 = $table4->select();
				$select4->where('code_groupe_parent = ?', $row3->code_groupe);
				$Rows4 = $table4->fetchAll($select4);*/
        $table4 = new Application_Model_DbTable_EuUtilisateur();
        $select4 = $table4->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select4->setIntegrityCheck(false);
        $select4->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select4->where('eu_utilisateur.id_utilisateur_parent = ?',$row3->id_utilisateur);
        $select4->order('id_utilisateur asc');
        $Rows4 = $table4->fetchAll($select4);
			   if(count($Rows4) > 0) {
				   $menu .= '
            <li><a href="#" class="menuLink">'.($row3->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				   foreach ($Rows4 as $row4) {
					   	/*$table5 = new Application_Model_DbTable_EuUserGroup();
				$select5 = $table5->select();
				$select5->where('code_groupe_parent = ?', $row4->code_groupe);
				$Rows5 = $table5->fetchAll($select5);*/
        $table5 = new Application_Model_DbTable_EuUtilisateur();
        $select5 = $table5->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select5->setIntegrityCheck(false);
        $select5->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select5->where('eu_utilisateur.id_utilisateur_parent = ?',$row4->id_utilisateur);
        $select5->order('id_utilisateur asc');
        $Rows5 = $table5->fetchAll($select5);
			   if(count($Rows5) > 0) {
				   $menu .= '
            <li><a href="#" class="menuLink">'.($row4->libelle_groupe).'</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				   foreach ($Rows5 as $row5) {
				 
				 
				 
				   }
					$menu .= ' </ul>
              </li>
           ';
			   }else{
                   $menu .= "<li><a href=\" /eu-user/debitcredit/ssgrp/".$row4->code_groupe." \">".($row4->libelle_groupe)."</a></li>";
				   }
				   }
					$menu .= ' </ul>
              </li>
           ';
			   }else{
                   $menu .= "<li><a href=\" /eu-user/debitcredit/ssgrp/".$row3->code_groupe." \">".($row3->libelle_groupe)."</a></li>";
				   }
				   }
					$menu .= ' </ul>
              </li>
           ';
			   }else{
                   $menu .= "<li><a href=\" /eu-user/debitcredit/ssgrp/".$row2->code_groupe." \">".($row2->libelle_groupe)."</a></li>";
				   }
				   
				   }
					$menu .= ' </ul>
              </li>
           ';
			   }else{
                   $menu .= "<li><a href=\" /eu-user/debitcredit/ssgrp/".$row->code_groupe." \">".($row->libelle_groupe)."</a></li>";
				   }
				   }
					$menu .= ' </ul>
              </li>
           ';
				 } else  if($group == 'ppp'){
					 
				$table2 = new Application_Model_DbTable_EuUserGroup();
				$select2 = $table2->select();
				$select2->where("code_groupe_parent in (select code_groupe from eu_user_group where code_groupe_parent = 'pp')");
				$Rows2 = $table2->fetchAll($select2);
				if(count($Rows2) > 0) {	 
				   $menu .= '
            <li><a href="#" class="menuLink">Tableau de bord</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				 
					 foreach ($Rows2 as $row2) {	
                   $menu .= "<li><a href=\" /eu-user/debitcredit/ssgrp/".$row2->code_groupe." \">".($row2->libelle_groupe)."</a></li>";
				   }
					$menu .= ' </ul>
              </li>
           ';
					 } 

				 } else  if($group == 'pmoe' || $group == 'pmose' || $group == 'pmpoe' || $group == 'pmpose' || $group == 'pmm' || $group == 'scmgm' || $group == 'scmsgm' || $group == 'scmdm'
){
					 
				
				$table3 = new Application_Model_DbTable_EuActeur();
				$select3 = $table3->select();
				$select3->where("code_membre = ? ", $user->code_membre);
				$Rows3 = $table3->fetchAll($select3);
					 
				$table2 = new Application_Model_DbTable_EuUserGroup();
				$select2 = $table2->select();
				$select2->where("code_groupe_parent in (select code_groupe from eu_user_group where code_groupe_parent = '".$group."')");
				$Rows2 = $table2->fetchAll($select2);
				if(count($Rows2) > 0 && count($Rows3) > 0) {	 
				   $menu .= '
            <li><a href="#" class="menuLink">Tableau de bord</a>
                 <ul style="z-index:1000000;background-color:#d7ebf9;">';
				 
					 foreach ($Rows2 as $row2) {	
                   $menu .= "<li><a href=\" /eu-user/debitcredit/ssgrp/".$row2->code_groupe." \">".($row2->libelle_groupe)."</a></li>";
				   }
					$menu .= ' </ul>
              </li>
           ';
					 } 
        } /*else{
			$menu = "";
			}*/
					 }

				   
			   
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'agregat' && $group != 'detentrice' && $group != 'surveillance' && $group != 'executante' && $group != 'nn' && $group != 'cnp' && $group != 'fn' && $group != 'FGnn' && $group != 'd_fgcnp' && $group != 'fgnr'
		    && $group != 'smc' && $group != 'reglementation' && $group != 'controlefn' && $group != 'protection' && $group != 'acnevtpsvsbps' && $group != 'acnevtpsvstps' && $group != 'acnevpbfvstps'
		    && $group != 'enrolement' && $group != 'mise_chaine' && $group != 'apa' && $group != 'smcipn' && $group != 'audit' && $group != 'alerte' && $group != 'assurance'
		    && $group != 'bnp' && $group != 'domiciliation' && $group != 'collecte' && $group == 'repartition') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    
  


   

    public function indexAction() {
        //$this->_helper->layout->disableLayout(); 
    }

    public function enrolementAction() {
        
    }

    public function listecarteAction() {
        
    }

    public function listebnpAction() {
        
    }
	
	
	
	public function paysAction() {
	       $g = array();
	       $tab = new Application_Model_DbTable_EuPays();
           $sel = $tab->select();
           $sel->order('libelle_pays asc');
           $group = $tab->fetchAll($sel);
           $i = 0;
           foreach ($group as $value) {
              $g[$i][0] = $value->code_pays;
              $g[$i][1] = ucfirst($value->libelle_pays);
              $i++;       
          }          
	      $this->view->data = $g;   
    }
	
    /*public function agenceAction() {
	   $g = array();
	   $tab = new Application_Model_DbTable_EuAgence();
           $sel = $tab->select();
           $sel->order('libelle_agence asc');
           $group = $tab->fetchAll($sel);
           $i = 0;
           foreach ($group as $value) {
              $g[$i][0] = $value->code_agence;
              $g[$i][1] = ucfirst($value->libelle_agence);
              $i++;       
          }          
	    $this->view->data = $g;   
    }

	 public function groupeAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_group = $user->code_groupe;
        $g = array();
        $tab = new Application_Model_DbTable_EuUserGroup();
        $sel = $tab->select();
        $sel->order('libelle_groupe asc');
        $group = $tab->fetchAll($sel);
        $i = 0;
        foreach ($group as $value) {
            if ($code_group == 'agregat') {
                //$greg = array('detentrice','surveillance','executante','nn');
                //if (in_array($value->code_groupe, $greg)) {
                    $g[$i][0] = $value->code_groupe;
                    $g[$i][1] = ucfirst($value->libelle_groupe);
                    $i++;
                //}
            } else if ($code_group == 'detentrice') {
                     $greg = array('nn','cnp','smc','fn');
                     if (in_array($value->code_groupe, $greg)) {
                        $g[$i][0] = $value->code_groupe;
                        $g[$i][1] = ucfirst($value->libelle_groupe);
                        $i++;
                }
            }else if ($code_group == 'surveillance') {
                     $greg = array('reglementation','controlefn','protection');
                     if (in_array($value->code_groupe, $greg)) {
                        $g[$i][0] = $value->code_groupe;
                        $g[$i][1] = ucfirst($value->libelle_groupe);
                        $i++;
                }
            }else if ($code_group == 'executante') {
                     $greg = array('acnevtpsbps','acnevtpsvstps','acnevpdftpsvstps');
                     if (in_array($value->code_groupe, $greg)) {
                        $g[$i][0] = $value->code_groupe;
                        $g[$i][1] = ucfirst($value->libelle_groupe);
                        $i++;
                }
            }else if ($code_group == 'reglementation') {
                     $greg = array('enrolement','mise_chaine');
                     if (in_array($value->code_groupe, $greg)) {
                        $g[$i][0] = $value->code_groupe;
                        $g[$i][1] = ucfirst($value->libelle_groupe);
                        $i++;
                }
            }else if ($code_group == 'controlefn') {
                     $greg = array('audit','apa','smcipn');
                     if (in_array($value->code_groupe, $greg)) {
                        $g[$i][0] = $value->code_groupe;
                        $g[$i][1] = ucfirst($value->libelle_groupe);
                        $i++;
                }
            }else if ($code_group == 'protection') {
                     $greg = array('alerte','assurance','bnp','domiciliation');
                     if (in_array($value->code_groupe, $greg)) {
                        $g[$i][0] = $value->code_groupe;
                        $g[$i][1] = ucfirst($value->libelle_groupe);
                        $i++;
                }
            }else if ($code_group == 'bnp') {
                     $greg = array('cmit','cacb','cscoe','caipc','capu','annulationbnp','destructionbnp');
                     if (in_array($value->code_groupe, $greg)) {
                        $g[$i][0] = $value->code_groupe;
                        $g[$i][1] = ucfirst($value->libelle_groupe);
                        $i++;
                }
            } 
        }
        $this->view->data = $g;
    }*/
	
	public function newAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_acteur = $user->code_acteur;
        $code_group = $user->code_groupe;
		$this->view->groupeuser = $code_group;
        if ($this->getRequest()->isPost()) {
            $pwd = $this->_request->getPost("pwd");
            $pwd1 = $this->_request->getPost("pwd1");
            //$code_groupe = $this->_request->getPost("groupe");
			$id_pays = $this->_request->getPost("pays");
            $code_membre = $this->_request->getPost("code_membre");
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Mise à jour de la table eu_utilisateur
                $userin = new Application_Model_EuUtilisateur();
                $mapper = new Application_Model_EuUtilisateurMapper();
                $find_user = $mapper->findLogin($this->_request->getPost("login"));
                if ($find_user != false) {
                    $message = 'Ce login existe déjà.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
                } elseif ($pwd != $pwd1) {
                    $message = 'Erreur de confirmation du mot de passe.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
                } else {
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user)
                   		   ->setId_utilisateur_parent($user->id_utilisateur)
                           ->setPrenom_utilisateur($this->_request->getPost("prenom"))
                           ->setNom_utilisateur($this->_request->getPost("nom"))
                           ->setLogin(trim($this->_request->getPost("login")))
                           ->setPwd(md5($pwd))
                           ->setDescription($this->_request->getPost("desc"))
                           ->setUlock(0)
                           ->setCh_pwd_flog(0)
                           ->setCode_groupe($this->_request->getPost("code_groupe"))
                           ->setConnecte(0)
                           ->setCode_agence($user->code_agence)
                           ->setCode_secteur(null)
                           ->setCode_zone($user->code_zone)
                           //->setCode_gac_filiere(null)
		            		->setId_pays($user->id_pays)	    	
                           ->setCode_acteur($user->code_acteur)
						   ->setCode_membre(null);
                    $mapper->save($userin);
					
					
                    //Mise à jour du sous groupe
					
					/*$cb_mapper = new Application_Model_EuUtilisateurGroupSousMapper();
					$cb = new Application_Model_EuUtilisateurGroupSous();
                            $cb->setCode_groupe_sous($_POST['code_groupe_sous'])
								->setId_utilisateur($id_user);
                            $cb_mapper->save($cb);*/
							
                    /*$cb_mapper = new Application_Model_EuUtilisateurGroupSousMapper();
					for($i = 0; $i < count($_POST['code_groupe_sous']); $i++){
                    $cb = new Application_Model_EuUtilisateurGroupSous();
                            $cb->setCode_groupe_sous($_POST['code_groupe_sous'][$i])
								->setId_utilisateur($id_user);
                            $cb_mapper->save($cb);
                    }*/
										
					
					
                    $db->commit();
                    return $this->_helper->redirector('index');
                }
            } catch (Exception $exc) {
                $db->rollback();
                $message = 'Echec ' . $exc->getMessage();
                $this->view->message = $message;
            }
        }
    }
	
	
	
	
	
	
	


    public function agencesAction() {
        $tagences = new Application_Model_EuAgenceMapper();
        $agences = $tagences->fetchAll();
        if (count($agences) >= 1) {
            foreach ($agences as $value) {
                $data[0][] = $value->getCode_agence();
                $data[1][] = $value->getLibelle_agence();
            }
            $this->view->data = $data;
        } else {
            $this->view->data = false;
        }
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_acteur = $user->code_acteur;
		$code_groupe = $user->code_groupe;
        $id_utilisateur = $user->id_utilisateur;
		$this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_utilisateur');
        $sord = $this->_request->getParam("sord", 'asc');
		
		$code_groupe = $this->_request->getParam("code_groupe");
        $connecte = $this->_request->getParam("connecte");
        $ulock = $this->_request->getParam("ulock");

        $tabela = new Application_Model_DbTable_EuUtilisateur();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
				//$select->where('code_acteur like ?', $code_acteur);
				//$select->join('eu_utilisateur_group_sous', 'eu_utilisateur_group_sous.id_utilisateur = eu_utilisateur.id_utilisateur');
		//$select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
				//$select->where('eu_utilisateur.id_utilisateur in (select DISTinCT id_utilisateur from eu_utilisateur_GROUP_SOUS)');
		//$select->where('eu_utilisateur.code_groupe = ?', $code_groupe);
		//if($id_utilisateur > 0){
        //$select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);}
        //$select->order('eu_utilisateur.id_utilisateur desc');
        if($code_groupe != '' && $connecte != '' && $ulock != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.code_groupe like ?',$code_groupe);
           $select->where('eu_utilisateur.connecte like ?',$connecte);
           $select->where('eu_utilisateur.ulock like ?',$ulock);     
        }elseif($code_groupe != '' && $connecte != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.code_groupe like ?',$code_groupe);
           $select->where('eu_utilisateur.connecte like ?',$connecte); 
        }elseif($code_groupe != '' && $ulock != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.code_groupe like ?',$code_groupe);
           $select->where('eu_utilisateur.ulock like ?',$ulock); 
        }elseif($connecte != '' && $ulock != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.connecte like ?',$connecte);
           $select->where('eu_utilisateur.ulock like ?',$ulock); 
        }elseif($code_groupe != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.code_groupe like ?',$code_groupe); 
        }elseif($ulock != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.ulock like ?',$ulock); 
        }elseif($connecte != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.connecte like ?',$connecte); 
        }
        else {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
        }     
        $cat = $tabela->fetchAll($select);
        $count = count($cat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->id_utilisateur;
            $responce['rows'][$i]['cell'] = array(
            strtoupper($row->nom_utilisateur) . ' ' . ucfirst($row->PREnom_utilisateur),
                $row->login,
                ucfirst($row->libelle_groupe),
                $row->connecte,
                $row->code_membre,
                $row->code_agence
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    


}

?>
