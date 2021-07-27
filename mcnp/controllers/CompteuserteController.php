<?php

class CompteuserteController extends Zend_Controller_Action   {
      
	  public function init() {
		/* Initialize action controller here */		
        include("Url.php");   
	  }
	  
	 public function loadcantonAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $prefecture = $request->getParam("id_prefecture");
        $t_canton = new Application_Model_DbTable_EuCanton();
        if (!empty($prefecture)) {
            $select = $t_canton->select()->where('id_prefecture = ?', $prefecture);
            $this->view->cantons = $t_canton->fetchAll($select);
        } else {
            $this->view->cantons = $t_canton->fetchAll();
        }
    }

    public function prefectureAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $region = $request->getParam("id_region");
        $entries = array();
        $t_prefect = new Application_Model_DbTable_EuPrefecture();
        if (!empty($region)) {
            $select = $t_prefect->select()->where('id_region = ?', $region);
            $entries = $t_prefect->fetchAll($select);
            $this->view->prefectures = $entries;
        } else {
            $this->view->prefectures = $t_prefect->fetchAll();
        }
    }

    public function loadregionAction() {
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $pays = $request->getParam("id_pays");
        $t_region = new Application_Model_DbTable_EuRegion();
        if (!empty($pays)) {
            $select = $t_region->select()->where('id_pays = ?', $pays);
            $this->view->regions = $t_region->fetchAll($select);
        } else {
            $this->view->regions = $t_region->fetchAll();
        }
    }

    public function loadpaysAction() {
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $zone = $request->getParam("code_zone");
        $t_pays = new Application_Model_DbTable_EuPays();
        if (!empty($zone)) {
            $select = $t_pays->select()->where('code_zone = ?', $zone);
            $this->view->pays = $t_pays->fetchAll($select);
        } else {
            $this->view->pays = $t_pays->fetchAll();
        }
    }
	


    public function newteAction() {
	    $sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
		   $this->_redirect('/');
		}
		$t_filiere = new Application_Model_DbTable_EuFiliere();
        $divisions = $t_filiere->fetchAll();
        $this->view->divisions = $divisions;
		
		$t_prk = new Application_Model_DbTable_EuTypePrk();
        $typeprks = $t_prk->fetchAll();
        $this->view->typeprks = $typeprks;
		
		$request = $this->getRequest();
		if ($request->isPost ())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
			   $te = new Application_Model_EuTegc();
		       $te_mapper = new Application_Model_EuTegcMapper();
                               
			   $prk = new Application_Model_EuPrk();
               $m_prk = new Application_Model_EuPrkMapper();
			   
			   $id_filiere = $request->getParam("id_filiere");
			   $raison_sociale = $request->getParam("nom");
			   $nom_produit = $request->getParam("nom_produit");
			   
			   $date_id = Zend_Date::now();
			   
			   // Recuperation de la PRK nr
               $params = new Application_Model_EuParametresMapper();
               $par = new Application_Model_EuParametres();
               $prc = 0;
               $par_prc = $params->find('prc','nr',$par);
               if ($par_prc == true) {
                  $prc = $par->getMontant();
               }
			   
			   $code_te = $te_mapper->getLastTegc();
			   
			   if ($code_te == NULL) {
			      $code_te = 'TEGCP'.$id_filiere.$sessionmembre->code_membre.'00001';         
			   } else {
			      $num_ordre = substr($code_te, -5);
                  $num_ordre++;
                  $code_te = 'TEGCP'.$id_filiere.$sessionmembre->code_membre.str_pad($num_ordre,5,0,STR_PAD_LEFT);    
			   }
			   
			   
			   $te->setCode_tegc($code_te);
			   $te->setId_filiere($id_filiere);
			   $te->setMdv($prc);
			   $te->setCode_membre($sessionmembre->code_membre);
			   $te->setMontant(0);
			   $te->setMontant_utilise(0);
			   $te->setSolde_tegc(0);
			   $te->setId_utilisateur($sessionmembre->id_utilisateur);
			   $te->setNom_tegc($raison_sociale);
			   $te->setNom_produit($nom_produit);
			   $te->setDate_tegc($date_id->toString('yyyy-MM-dd HH:mm:ss'));
			   
			   if(isset($_POST['produit1']) && $_POST['produit1'] == 'ri') {
			     $te->setRecurrent_illimite(1);
			   } else {
				 $te->setRecurrent_illimite(0);
			   }
			   
			   if(isset($_POST['produit2']) && $_POST['produit2'] == 'rl') {
				  $te->setRecurrent_limite(1);
			   } else {
				  $te->setRecurrent_limite(0);
			   }
					  
			   if(isset($_POST['produit3']) && $_POST['produit3'] == 'nr') {
				 $te->setNonrecurrent(1);
			   } else {
                 $te->setNonrecurrent(0);
               }					  
						
               if($_POST['periode1'] == '11.2') {						
				  $te->setPeriode1(1);
			   } else { 
				  $te->setPeriode1(0);
			   }
					  
			   if($_POST['periode2'] == '22.4') {						
				  $te->setPeriode2(1);
			   } else { 
				  $te->setPeriode2(0);
			   }
					  
			   if($_POST['categorie1'] == 'special') {
				 $te->setSpecial(1);
			   } else {
                 $te->setSpecial(0);
               }					  
					  
			   if($_POST['categorie2'] == 'ordinaire') {
				 $te->setOrdinaire(1);
			   } else {
                 $te->setOrdinaire(0);
               } 
			   $te_mapper->save($te);
			   
				
			   $compteur = $_POST['compteur'];
			   $x = 1;
			   while ($x <= $compteur) {
				  if(isset($_POST["prk$x"])) {
				    $valeur_prk = $_POST["prk$x"];
                    $findprk = $m_prk->findByTegc($code_te,$valeur_prk,$prk);
					if($findprk == false) {
					   $id_prk = $m_prk->findConuter() + 1;
					   $prk->setId_prk($id_prk);
					   $prk->setCode_tegc($code_te);
					   $prk->setValeur($valeur_prk);
					   $m_prk->save($prk);
                     }					
				  }
				  $x++;
			   }
			   $db->commit();
			   $sessionmembre->errorlogin = "Operation bien effectuee ...";
			   $this->_redirect('/compteuserte/listte');
		   
		   } catch (Exception $exc) {				   
			  $db->rollback();
              $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
              return;
		   }
		    
	    }  
	
	}
    
	
	public function editteAction() {
	     $sessionmembre = new Zend_Session_Namespace('membre');
		 //$this->_helper->layout->disableLayout();
		 $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		 }
		 
		 $t_filiere = new Application_Model_DbTable_EuFiliere();
         $divisions = $t_filiere->fetchAll();
         $this->view->divisions = $divisions;
		 
		 $t_prk = new Application_Model_DbTable_EuTypePrk();
         $typeprks = $t_prk->fetchAll();
         $this->view->typeprks = $typeprks;
		 
		 $tegc   = new Application_Model_EuTegc();
		 $m_tegc = new Application_Model_EuTegcMapper();
		 
		 $prk   = new Application_Model_EuPrk();
		 $m_prk = new Application_Model_EuPrkMapper();
		 
		 $request = $this->getRequest();
		 if ($request->isPost ())  {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
		        $code_tegc = $request->getParam("code_tegc");
				
				$nom_tegc = $request->getParam("nom_tegc");
				$nom_produit = $request->getParam("nom_produit");
				
                $m_tegc->find($code_tegc,$tegc);
                
                $tegc->setNom_tegc($nom_tegc);
                $tegc->setNom_produit($nom_produit);
                
				$m_tegc->update($tegc);				
		    
                if(isset($_POST['produit1']) && $_POST['produit1'] == 'ri') {
			      $tegc->setRecurrent_illimite(1);
			      $m_tegc->update($tegc);
			    } else {
                  $tegc->setRecurrent_illimite(0);
			      $m_tegc->update($tegc);
                }			
					  
			    if(isset($_POST['produit2']) && $_POST['produit2'] == 'rl') {
			       $tegc->setRecurrent_limite(1);
			       $m_tegc->update($tegc);
			    } else {
                   $tegc->setRecurrent_limite(0);
			       $m_tegc->update($tegc);
                }			
					  
			    if(isset($_POST['produit3']) && $_POST['produit3'] == 'nr') {
			       $tegc->setNonrecurrent(1);
			       $m_tegc->update($tegc);
			    } else {
                   $tegc->setNonrecurrent(0);
			       $m_tegc->update($tegc);
                }			
						
                if(isset($_POST['periode1'])  && ($_POST['periode1'] == '11.2')) {						
			       $tegc->setPeriode1(1);
			       $m_tegc->update($tegc);
		        } else {
                   $tegc->setPeriode1(0);
			       $m_tegc->update($tegc);
                }			
					  
			    if(isset($_POST['periode2']) && ($_POST['periode2'] == '22.4')) {						
			       $tegc->setPeriode2(1);
			       $m_tegc->update($tegc);
			    } else {
                   $tegc->setPeriode2(0);
			       $m_tegc->update($tegc);
                }			
					  
			    if(isset($_POST['categorie1']) && ($_POST['categorie1'] == 'special')) {
			       $tegc->setSpecial(1);
			       $m_tegc->update($tegc);
			    } else {
                   $tegc->setSpecial(0);
			       $m_tegc->update($tegc);
                }			
					  
			    if(isset($_POST['categorie2']) && ($_POST['categorie2'] == 'ordinaire')) {
			      $tegc->setOrdinaire(1);
			      $m_tegc->update($tegc);
			    } else {
			      $tegc->setOrdinaire(0);
			      $m_tegc->update($tegc);
			    }   
			   
			   $compteur = $_POST['compteur'];
			   $x = 1;
			   $tab_prk = $m_prk->fetchByTegc($code_tegc);
			   if($tab_prk != false) {
			      foreach ($tab_prk as $row) {
				    $m_prk->find($row->id_prk,$prk);
			        $m_prk->delete($prk->id_prk); 
			      }
			   }	 
			   while ($x <= $compteur) {
				  if(isset($_POST["prk$x"])) {
				    $valeur_prk = $_POST["prk$x"];
                    $findprk = $m_prk->findByTegc($code_tegc,$valeur_prk,$prk);
					if($findprk == false) {
					   $id_prk = $m_prk->findConuter() + 1;
					   $prk->setId_prk($id_prk);
					   $prk->setCode_tegc($code_tegc);
					   $prk->setValeur($valeur_prk);
					   $m_prk->save($prk);
                     }   					 
				  } 
				  $x++;
			  }	   

       $db->commit();
	   $sessionmembre->errorlogin = "Modification bien effectuee ...";
	   $this->_redirect('/compteuserte/listte');	   
	} catch (Exception $exc) {				   
	   $db->rollback();
       $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
       return;
    }
	
	} else {
	   $id = $this->_request->getParam('id');
	   $tegc   = new Application_Model_EuTegc();
	   $m_tegc = new Application_Model_EuTegcMapper();
	   $prk   = new Application_Model_EuPrk();
	   $m_prk = new Application_Model_EuPrkMapper();
	   $findprks = $m_prk->fetchByTegc($id);
	   $m_tegc->find($id,$tegc);
	   $this->view->tegc = $tegc;
	   $this->view->prks = $findprks;
	}
		 
}


    public function editAction() {
	   $sessionmembre = new Zend_Session_Namespace('membre');
	   //$this->_helper->layout->disableLayout();
	   $this->_helper->layout()->setLayout('layoutpublicesmcperso');
	   
	   if (!isset($sessionmembre->code_membre)) {
		  $this->_redirect('/');
	   }
	   
	   $t_zone = new Application_Model_DbTable_EuZone();
       $zones = $t_zone->fetchAll();
       $this->view->zones = $zones;
       $t_pays = new Application_Model_DbTable_EuPays();
       $pays = $t_pays->fetchAll();
       $this->view->pays = $pays;
       $t_region = new Application_Model_DbTable_EuRegion();
       $regions = $t_region->fetchAll();
       $this->view->regions = $regions;
       $t_prefecture = new Application_Model_DbTable_EuPrefecture();
       $prefectures = $t_prefecture->fetchAll();
       $this->view->prefectures = $prefectures;
       $t_canton = new Application_Model_DbTable_EuCanton();
       $cantons = $t_canton->fetchAll();
       $this->view->cantons = $cantons;
	   
	   $t_tegc = new Application_Model_DbTable_EuTegc();
	   $select = $t_tegc->select();
	   $select->where('code_membre = ?',$sessionmembre->code_membre);
	   $select->order('nom_tegc asc');
		   
       $tegc = $t_tegc->fetchAll($select);
		 
       $this->view->tegc = $tegc;
	   
	   $userin = new Application_Model_EuUtilisateur();
       $mapper = new Application_Model_EuUtilisateurMapper();
	   
	   $membre = new Application_Model_EuMembre();
	   $m_membre = new Application_Model_EuMembreMapper();
	   
	   $request = $this->getRequest();
	   if($request->isPost ())  {
		  $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
		  try {
		      $find_user = $mapper->findNoLogin($request->getParam("login"),$request->getParam("id_utilisateur"));
			  $utilisateur = new Application_Model_EuUtilisateur();
			  //$trouve_user = $mapper->find($sessionmembre->id_utilisateur,$utilisateur);
			  $nom = $request->getParam("nom");
			  $prenom = $request->getParam("prenom");
			  $login = $request->getParam("login");
			  $pwdold = $request->getParam("pwdold");
			  $pwd = $request->getParam("pwd");
			  $pwd1 = $request->getParam("pwd1");
			  $id_pays = $request->getParam("id_pays");
			  $id_canton = $request->getParam("id_canton");
			  $id_user = $request->getParam("id_utilisateur");
			  $code_tegc = $request->getParam("code_tegc");
			  $code_membre = $request->getParam("code_membre");
		      $findmembre = $m_membre->find($code_membre,$membre);
			  
			  $mapper->find($id_user,$utilisateur);
			  
			  if($find_user != false) {
				 $db->rollback();
                 $error = 'Ce login existe déjà.';
                 $this->view->error = $error;
	             $this->view->user = $utilisateur;
                 return;
              } elseif($utilisateur->pwd != md5($pwdold)) {
				 $db->rollback();
        	     $error = 'Ancien mot de passe non conforme.';
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;		  
		      }	  
			  elseif ($pwd != $pwd1) {
				 $db->rollback();
                 $error = 'Erreur de confirmation du mot de passe.';
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
              } 
			  elseif (stripos($login, " ") !== false) {
				 $db->rollback();
                 $error = "Le Login ne doit pas contenir d'espace";
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
              } elseif($findmembre == false) {
				 $db->rollback();
				 $error = "Le code membre de l'utilisateur  ".$code_membre."  est introuvable ...";
                 $this->view->error = $error;
                 $this->view->user = $utilisateur;
			     return;
			  }

              //insertion dans la table eu_utilisateur
			  //$id_user = $mapper->findConuter() + 1;
			   $mapper->find($id_user,$userin);
               $userin->setId_utilisateur_parent($sessionmembre->id_utilisateur); 
               $userin->setPrenom_utilisateur($prenom);
               $userin->setNom_utilisateur($nom);
               $userin->setLogin(trim($login));
               $userin->setPwd(md5($pwd));
               $userin->setDescription(null);
               $userin->setUlock(0);
               $userin->setCh_pwd_flog(1);
               $userin->setCode_groupe('cnp_tegcp');
               $userin->setConnecte(0);
               $userin->setCode_agence($sessionmembre->code_agence);    		 
               $userin->setCode_secteur($utilisateur->code_secteur);
               $userin->setCode_zone($utilisateur->code_zone);		
               $userin->setId_filiere($utilisateur->id_filiere);
			   $userin->setCode_acteur($utilisateur->code_acteur);	   
			   $userin->setCode_gac_filiere(null);
			   $userin->setCode_groupe_create($sessionmembre->code_groupe);
			   $userin->setCode_membre($code_membre);
			   $userin->setId_pays($id_pays);
               $userin->setId_canton($id_canton);
               $userin->setCode_tegc($code_tegc);			   
               $mapper->update($userin);					
               $db->commit();
			   
			   $sessionmembre->errorlogin = "Modification bien effectuee ...";
			   $this->_redirect('/compteuserte/listuser');
			      
		  } catch (Exception $exc) {				   
			   $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
		  }
	   
	   } else {
	       $id = $this->_request->getParam('id');
	       $user   = new Application_Model_EuUtilisateur();
	       $m_user = new Application_Model_EuUtilisateurMapper();
	   
	       $m_user->find($id,$user);
	       $this->view->user = $user;
	   }
	
	
	}


    public function editpbfAction() {
	   $sessionmembre = new Zend_Session_Namespace('membre');
	   //$this->_helper->layout->disableLayout();
	   $this->_helper->layout()->setLayout('layoutpublicesmcperso');
	   
	   $t_zone = new Application_Model_DbTable_EuZone();
       $zones = $t_zone->fetchAll();
       $this->view->zones = $zones;
       $t_pays = new Application_Model_DbTable_EuPays();
       $pays = $t_pays->fetchAll();
       $this->view->pays = $pays;
       $t_region = new Application_Model_DbTable_EuRegion();
       $regions = $t_region->fetchAll();
       $this->view->regions = $regions;
       $t_prefecture = new Application_Model_DbTable_EuPrefecture();
       $prefectures = $t_prefecture->fetchAll();
       $this->view->prefectures = $prefectures;
       $t_canton = new Application_Model_DbTable_EuCanton();
       $cantons = $t_canton->fetchAll();
       $this->view->cantons = $cantons;
	   
	   if (!isset($sessionmembre->code_membre)) {
		  $this->_redirect('/');
	   }
	   
	   $userin = new Application_Model_EuUtilisateur();
       $mapper = new Application_Model_EuUtilisateurMapper();
	   $request = $this->getRequest();
	   if ($request->isPost ())  {
		  $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
		  try {
		      $find_user = $mapper->findNoLogin($request->getParam("login"),$request->getParam("id_utilisateur"));
			  $utilisateur = new Application_Model_EuUtilisateur();
			  //$trouve_user = $mapper->find($sessionmembre->id_utilisateur,$utilisateur);
			  $nom = $request->getParam("nom");
			  $prenom = $request->getParam("prenom");
			  $login = $request->getParam("login");
			  $pwdold = $request->getParam("pwdold");
			  $pwd = $request->getParam("pwd");
			  $pwd1 = $request->getParam("pwd1");
			  $id_pays = $request->getParam("id_pays");
			  $id_canton = $request->getParam("id_canton");
			  $id_user = $request->getParam("id_utilisateur");
			  
			  $mapper->find($id_user,$utilisateur);
			  
			  if ($find_user != false) {
                 $error = 'Ce login existe déjà.';
                 $this->view->error = $error;
	             $this->view->user = $utilisateur;
                 return;
              } elseif($utilisateur->pwd != md5($pwdold)) {
        	     $error = 'Ancien mot de passe non conforme.';
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;		  
		      }	  
			  elseif ($pwd != $pwd1) {
                 $error = 'Erreur de confirmation du mot de passe.';
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
              } 
			  elseif (stripos($login, " ") !== false) {
                 $error = "Le Login ne doit pas contenir d'espace";
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
             }

             //insertion dans la table eu_utilisateur
			   //$id_user = $mapper->findConuter() + 1;
			   $mapper->find($id_user,$userin);
               $userin->setId_utilisateur_parent($sessionmembre->id_utilisateur); 
               $userin->setPrenom_utilisateur($prenom);
               $userin->setNom_utilisateur($nom);
               $userin->setLogin(trim($login));
               $userin->setPwd(md5($pwd));
               $userin->setDescription(null);
               $userin->setUlock(0);
               $userin->setCh_pwd_flog(1);
               $userin->setCode_groupe('cnp_tegcp_pbf');
               $userin->setConnecte(0);
               $userin->setCode_agence($sessionmembre->code_agence);
				    		 
               $userin->setCode_secteur($utilisateur->code_secteur);
               $userin->setCode_zone($utilisateur->code_zone);
						
               $userin->setId_filiere($utilisateur->id_filiere);
			   
			   $userin->setCode_acteur($utilisateur->code_acteur);	   
			   $userin->setCode_gac_filiere(null);
			   $userin->setCode_groupe_create($sessionmembre->code_groupe);
			   $userin->setCode_membre($sessionmembre->code_membre);
			   
			   $userin->setId_pays($id_pays);
               $userin->setId_canton($id_canton);
               $userin->setCode_tegc(null);			   
               $mapper->update($userin);					
               $db->commit();
			   
			   $sessionmembre->errorlogin = "Modification bien effectuee ...";
			   $this->_redirect('/compteuserte/listuserpbf');
			      
		  } catch (Exception $exc) {				   
			   $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
		  }
	   
	   } else {
	       $id = $this->_request->getParam('id');
	       $user   = new Application_Model_EuUtilisateur();
	       $m_user = new Application_Model_EuUtilisateurMapper();
	   
	       $m_user->find($id,$user);
	       $this->view->user = $user;
	   }

	   
	}

     public function detailteAction()  {
	    $id = $this->_request->getParam('id');
	    $tegc   = new Application_Model_EuTegc();
		$m_tegc = new Application_Model_EuTegcMapper();
		$prk   = new Application_Model_EuPrk();
		$m_prk = new Application_Model_EuPrkMapper();
		$findprks = $m_prk->fetchByTegc($id);
		$m_tegc->find($id,$tegc);
		
		$filiere   = new Application_Model_EuFiliere();
		$m_filiere = new Application_Model_EuFiliereMapper();
		$m_filiere->find($tegc->id_filiere,$filiere);
		
		$t_prk = new Application_Model_DbTable_EuTypePrk();
        $typeprks = $t_prk->fetchAll();
        $this->view->typeprks = $typeprks;
        
        $this->view->division = $filiere->nom_filiere;
		
		$this->view->tegc = $tegc;
		$this->view->prks = $findprks;
	 }
	
	
	
	
	 public function newpbfAction() {
	     $sessionmembre = new Zend_Session_Namespace('membre');
		 //$this->_helper->layout->disableLayout();
		 $this->_helper->layout()->setLayout('layoutpublicesmcperso');
		 if (!isset($sessionmembre->code_membre)) {
			 $this->_redirect('/');
		 }
		 
		 $userin = new Application_Model_EuUtilisateur();
         $mapper = new Application_Model_EuUtilisateurMapper();
		 
		 $t_zone = new Application_Model_DbTable_EuZone();
         $zones = $t_zone->fetchAll();
         $this->view->zones = $zones;
         $t_pays = new Application_Model_DbTable_EuPays();
         $pays = $t_pays->fetchAll();
         $this->view->pays = $pays;
         $t_region = new Application_Model_DbTable_EuRegion();
         $regions = $t_region->fetchAll();
         $this->view->regions = $regions;
         $t_prefecture = new Application_Model_DbTable_EuPrefecture();
         $prefectures = $t_prefecture->fetchAll();
         $this->view->prefectures = $prefectures;
         $t_canton = new Application_Model_DbTable_EuCanton();
         $cantons = $t_canton->fetchAll();
         $this->view->cantons = $cantons;
		 
		 $request = $this->getRequest();
		 if ($request->isPost ())  {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
			    $find_user = $mapper->findLogin($request->getParam("login"));
				$utilisateur = new Application_Model_EuUtilisateur();
				$trouve_user = $mapper->find($sessionmembre->id_utilisateur,$utilisateur);
				$nom = $request->getParam("nom");
				$prenom = $request->getParam("prenom");
				$login = $request->getParam("login");
				$pwd = $request->getParam("pwd");
				$pwd1 = $request->getParam("pwd1");
				$id_pays = $request->getParam("id_pays");
				$id_canton = $request->getParam("id_canton");
				
				if ($find_user != false) {
                    $error = 'Ce login existe déjà.';
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
                } elseif ($pwd != $pwd1) {
                    $error = 'Erreur de confirmation du mot de passe.';
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
               } 
			   elseif (stripos($login, " ") !== false) {
                    $error = "Le Login ne doit pas contenir d'espace";
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
               }
			   
			   //insertion dans la table eu_utilisateur
			   $id_user = $mapper->findConuter() + 1;
               $userin->setId_utilisateur($id_user);
               $userin->setId_utilisateur_parent($sessionmembre->id_utilisateur); 
               $userin->setPrenom_utilisateur($prenom);
               $userin->setNom_utilisateur($nom);
               $userin->setLogin(trim($login));
               $userin->setPwd(md5($pwd));
               $userin->setDescription(null);
               $userin->setUlock(0);
               $userin->setCh_pwd_flog(0);
               $userin->setCode_groupe('cnp_tegcp_pbf');
               $userin->setConnecte(0);
               $userin->setCode_agence($sessionmembre->code_agence);
				    		 
               $userin->setCode_secteur($utilisateur->code_secteur);
               $userin->setCode_zone($utilisateur->code_zone);
						
               $userin->setId_filiere($utilisateur->id_filiere);
			   
			   $userin->setCode_acteur($utilisateur->code_acteur);	   
			   $userin->setCode_gac_filiere(null);
			   if($sessionmembre->code_groupe != "" || $sessionmembre->code_groupe != NULL) {
			      $userin->setCode_groupe_create($sessionmembre->code_groupe);
			   } else {
			      $userin->setCode_groupe_create("personne_physique");
			   }
			   
			   $userin->setCode_membre($sessionmembre->code_membre);
			   
			   $userin->setId_pays($id_pays);
               $userin->setId_canton($id_canton);
               $userin->setCode_tegc(null);			   
               $mapper->save($userin);					
               $db->commit();
			   
			   $sessionmembre->errorlogin = "Operation bien effectuee ...";
			   $this->_redirect('/compteuserte/listuserpbf');
			
			
			
			} catch (Exception $exc) {				   
			     $db->rollback();
                 $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
		    }
	 
	 
	 
	     }
	 
	 }
	
	  
	 public function newAction()  {
	     $sessionmembre = new Zend_Session_Namespace('membre');
		 //$this->_helper->layout->disableLayout();
		 $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		 }
		 
		 $userin = new Application_Model_EuUtilisateur();
         $mapper = new Application_Model_EuUtilisateurMapper();
		 
		 $membre = new Application_Model_EuMembre();
	     $m_membre = new Application_Model_EuMembreMapper();
		 
		 $t_zone = new Application_Model_DbTable_EuZone();
         $zones = $t_zone->fetchAll();
         $this->view->zones = $zones;
         $t_pays = new Application_Model_DbTable_EuPays();
         $pays = $t_pays->fetchAll();
         $this->view->pays = $pays;
         $t_region = new Application_Model_DbTable_EuRegion();
         $regions = $t_region->fetchAll();
         $this->view->regions = $regions;
         $t_prefecture = new Application_Model_DbTable_EuPrefecture();
         $prefectures = $t_prefecture->fetchAll();
         $this->view->prefectures = $prefectures;
         $t_canton = new Application_Model_DbTable_EuCanton();
         $cantons = $t_canton->fetchAll();
         $this->view->cantons = $cantons;
		 
		 $t_tegc = new Application_Model_DbTable_EuTegc();
		 $select = $t_tegc->select();
		 if(substr($sessionmembre->code_membre,19,1) == 'M') {
		    $select->where('code_membre = ?',$sessionmembre->code_membre);
		 } else {
            $select->where('code_membre_physique = ?',$sessionmembre->code_membre);
         }		 
		 $select->order('nom_tegc asc');
		   
		 $tegc = $t_tegc->fetchAll($select);
		 
         $this->view->tegc = $tegc;
		 
		 $request = $this->getRequest();
		 if($request->isPost())  {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
		        $find_user = $mapper->findLogin($request->getParam("login"));
				$utilisateur = new Application_Model_EuUtilisateur();
				$trouve_user = $mapper->find($sessionmembre->id_utilisateur,$utilisateur);
				$nom = $request->getParam("nom");
				$prenom = $request->getParam("prenom");
				$login = $request->getParam("login");
				$pwd = $request->getParam("pwd");
				$pwd1 = $request->getParam("pwd1");
				$code_membre = $request->getParam("code_membre");
				$id_pays = $request->getParam("id_pays");
				$id_canton = $request->getParam("id_canton");
				$code_tegc = $request->getParam("code_tegc");
				$date_id = Zend_Date::now();
				
				$findmembre = $m_membre->find($code_membre,$membre);
				
				if($find_user != false) {
					$db->rollback();
                    $error = 'Ce login existe déjà.';
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
                } elseif ($pwd != $pwd1) {
					$db->rollback();
                    $error = 'Erreur de confirmation du mot de passe.';
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
                } elseif (stripos($login, " ") !== false) {
				    $db->rollback();
                    $error = "Le Login ne doit pas contenir d'espace";
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
                } elseif($findmembre == false) {
				    $db->rollback();
				    $error = "Le code membre de l'utilisateur  ".$code_membre."  est introuvable ...";
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
					return;
			    }
			   
			    //insertion dans la table eu_utilisateur
			    $id_user = $mapper->findConuter() + 1;
                $userin->setId_utilisateur($id_user);
                $userin->setId_utilisateur_parent($sessionmembre->id_utilisateur); 
                $userin->setPrenom_utilisateur($prenom);
                $userin->setNom_utilisateur($nom);
                $userin->setLogin(trim($login));
                $userin->setPwd(md5($pwd));
                $userin->setDescription(null);
                $userin->setUlock(0);
                $userin->setCh_pwd_flog(0);
                $userin->setCode_groupe('cnp_tegcp');
                $userin->setConnecte(0);
                $userin->setCode_agence($sessionmembre->code_agence);
				    		 
                $userin->setCode_secteur($utilisateur->code_secteur);
                $userin->setCode_zone($utilisateur->code_zone);
						
                $userin->setId_filiere($utilisateur->id_filiere);
			   
			    $userin->setCode_acteur($utilisateur->code_acteur);	   
			    $userin->setCode_gac_filiere(null);
			    if($sessionmembre->code_groupe != "" || $sessionmembre->code_groupe != NULL) {
			      $userin->setCode_groupe_create($sessionmembre->code_groupe);
			    } else {
			      $userin->setCode_groupe_create("personne_physique");
			    }
			   
			    $userin->setCode_membre($code_membre);
			   
			    $userin->setId_pays($id_pays);
                $userin->setId_canton($id_canton);
                $userin->setCode_tegc($code_tegc);			   
                $mapper->save($userin);

                $eucompte = new Application_Model_EuCompte();
			    $m_compte = new Application_Model_EuCompteMapper();
			   
			    $num_compte = 'NB-TPAGCP-'.$sessionmembre->code_membre;
			    $res = $m_compte->find($num_compte,$eucompte);
									
			    if(!$res) {
				  $eucompte->setCode_cat('TPAGCP')
                           ->setCode_compte($num_compte)
		                   ->setCode_type_compte('NB')
                           ->setDate_alloc($date_id->toString('yyyy-MM-dd'))
                           ->setDesactiver(0)
                           ->setLib_compte('TPAGCP')
                           ->setSolde(0);
												 
				  if(substr($sessionmembre->code_membre,19,1)=='P') {		 
                    $eucompte->setCode_membre($sessionmembre->code_membre)
                             ->setCode_membre_morale(NULL);
				  } else  {
                    $eucompte->setCode_membre(NULL)
                             ->setCode_membre_morale($sessionmembre->code_membre);
                  }										         
                  $m_compte->save($eucompte);
			   }
			   
			   $num_comptets = 'NB-TSGCP-'.$sessionmembre->code_membre;
			   $rests = $m_compte->find($num_comptets,$eucompte);
									
			   if(!$rests) {
				  $eucompte->setCode_cat('TSGCP')
                           ->setCode_compte($num_comptets)
						   ->setCode_type_compte('NB')
                           ->setDate_alloc($date_id->toString('yyyy-MM-dd'))
                           ->setDesactiver(0)
                           ->setLib_compte('TSGCP')
                           ->setSolde(0);
												 
				   if(substr($sessionmembre->code_membre,19,1)=='P') {		 
                        $eucompte->setCode_membre($sessionmembre->code_membre)
                                 ->setCode_membre_morale(NULL);
				   } else  {
                        $eucompte->setCode_membre(NULL)
                                 ->setCode_membre_morale($sessionmembre->code_membre);
                   }										         
                        $m_compte->save($eucompte);
									
                }  
				  
                $db->commit();
			    $sessionmembre->errorlogin = "Operation bien effectuee ...";
			    $this->_redirect('/compteuserte/listuser');
		 
		    } catch (Exception $exc) {				   
			     $db->rollback();
                 $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
		    }
		 
		 }
	  
	  
	  }
	  
	  
	  public function editsmcipnAction() {
	   $sessionmembre = new Zend_Session_Namespace('membre');
	   //$this->_helper->layout->disableLayout();
	   $this->_helper->layout()->setLayout('layoutpublicesmcperso');
	   
	   if (!isset($sessionmembre->code_membre)) {
		  $this->_redirect('/');
	   }
	   
	   $t_zone = new Application_Model_DbTable_EuZone();
       $zones = $t_zone->fetchAll();
       $this->view->zones = $zones;
       $t_pays = new Application_Model_DbTable_EuPays();
       $pays = $t_pays->fetchAll();
       $this->view->pays = $pays;
       $t_region = new Application_Model_DbTable_EuRegion();
       $regions = $t_region->fetchAll();
       $this->view->regions = $regions;
       $t_prefecture = new Application_Model_DbTable_EuPrefecture();
       $prefectures = $t_prefecture->fetchAll();
       $this->view->prefectures = $prefectures;
       $t_canton = new Application_Model_DbTable_EuCanton();
       $cantons = $t_canton->fetchAll();
       $this->view->cantons = $cantons;
	   
	   $userin = new Application_Model_EuUtilisateur();
       $mapper = new Application_Model_EuUtilisateurMapper();
	   $request = $this->getRequest();
	   if ($request->isPost ())  {
		  $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
		  try {
		      $find_user = $mapper->findNoLogin($request->getParam("login"),$request->getParam("id_utilisateur"));
			  $utilisateur = new Application_Model_EuUtilisateur();
			  //$trouve_user = $mapper->find($sessionmembre->id_utilisateur,$utilisateur);
			  $nom = $request->getParam("nom");
			  $prenom = $request->getParam("prenom");
			  $login = $request->getParam("login");
			  $pwdold = $request->getParam("pwdold");
			  $pwd = $request->getParam("pwd");
			  $pwd1 = $request->getParam("pwd1");
			  $id_pays = $request->getParam("id_pays");
			  $id_canton = $request->getParam("id_canton");
			  $id_user = $request->getParam("id_utilisateur");
			  $code_tegc = $request->getParam("code_tegc");
			  
			  $mapper->find($id_user,$utilisateur);
			  
			  if ($find_user != false) {
                 $error = 'Ce login existe déjà.';
                 $this->view->error = $error;
	             $this->view->user = $utilisateur;
                 return;
              } elseif($utilisateur->pwd != md5($pwdold)) {
        	     $error = 'Ancien mot de passe non conforme.';
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;		  
		      }	  
			  elseif ($pwd != $pwd1) {
                 $error = 'Erreur de confirmation du mot de passe.';
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
              } 
			  elseif (stripos($login, " ") !== false) {
                 $error = "Le Login ne doit pas contenir d'espace";
				 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
             }

             //insertion dans la table eu_utilisateur
			   //$id_user = $mapper->findConuter() + 1;
			   $mapper->find($id_user,$userin);
               $userin->setId_utilisateur_parent($sessionmembre->id_utilisateur); 
               $userin->setPrenom_utilisateur($prenom);
               $userin->setNom_utilisateur($nom);
               $userin->setLogin(trim($login));
               $userin->setPwd(md5($pwd));
               $userin->setDescription(null);
               $userin->setUlock(0);
               $userin->setCh_pwd_flog(1);
               $userin->setCode_groupe('smc_tesmcipnwi');
               $userin->setConnecte(0);
               $userin->setCode_agence($sessionmembre->code_agence);    		 
               $userin->setCode_secteur($utilisateur->code_secteur);
               $userin->setCode_zone($utilisateur->code_zone);		
               $userin->setId_filiere($utilisateur->id_filiere);
			   $userin->setCode_acteur($utilisateur->code_acteur);	   
			   $userin->setCode_gac_filiere(null);
			   $userin->setCode_groupe_create($sessionmembre->code_groupe);
			   $userin->setCode_membre($sessionmembre->code_membre);
			   $userin->setId_pays($id_pays);
               $userin->setId_canton($id_canton);
               $userin->setCode_tegc(null);			   
               $mapper->update($userin);					
               $db->commit();
			   
			   $sessionmembre->errorlogin = "Modification bien effectuee ...";
			   $this->_redirect('/compteuserte/listusersmcipn');
			      
		  } catch (Exception $exc) {				   
			   $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
		  }
	   
	   } else {
	       $id = $this->_request->getParam('id');
	       $user   = new Application_Model_EuUtilisateur();
	       $m_user = new Application_Model_EuUtilisateurMapper();
	   
	       $m_user->find($id,$user);
	       $this->view->user = $user;
	   }
	
	
	}
	
	public function newsmcipnAction() {
	     $sessionmembre = new Zend_Session_Namespace('membre');
		 //$this->_helper->layout->disableLayout();
		 $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		 }
		 
		 $userin = new Application_Model_EuUtilisateur();
         $mapper = new Application_Model_EuUtilisateurMapper();
		 
		 $t_zone = new Application_Model_DbTable_EuZone();
         $zones = $t_zone->fetchAll();
         $this->view->zones = $zones;
         $t_pays = new Application_Model_DbTable_EuPays();
         $pays = $t_pays->fetchAll();
         $this->view->pays = $pays;
         $t_region = new Application_Model_DbTable_EuRegion();
         $regions = $t_region->fetchAll();
         $this->view->regions = $regions;
         $t_prefecture = new Application_Model_DbTable_EuPrefecture();
         $prefectures = $t_prefecture->fetchAll();
         $this->view->prefectures = $prefectures;
         $t_canton = new Application_Model_DbTable_EuCanton();
         $cantons = $t_canton->fetchAll();
         $this->view->cantons = $cantons;
		 
		 $request = $this->getRequest();
		 if ($request->isPost ())  {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
			    $find_user = $mapper->findLogin($request->getParam("login"));
				$utilisateur = new Application_Model_EuUtilisateur();
				$trouve_user = $mapper->find($sessionmembre->id_utilisateur,$utilisateur);
				$nom = $request->getParam("nom");
				$prenom = $request->getParam("prenom");
				$login = $request->getParam("login");
				$pwd = $request->getParam("pwd");
				$pwd1 = $request->getParam("pwd1");
				$id_pays = $request->getParam("id_pays");
				$id_canton = $request->getParam("id_canton");
				
				if ($find_user != false) {
                   $error = 'Ce login existe déjà.';
                   $this->view->error = $error;
                   $this->view->nom = $request->getParam("nom");
                   $this->view->prenom = $request->getParam("prenom");
                   $this->view->login = $request->getParam("login");
                   return;
                } elseif ($pwd != $pwd1) {
                   $error = 'Erreur de confirmation du mot de passe.';
                   $this->view->error = $error;
                   $this->view->nom = $request->getParam("nom");
                   $this->view->prenom = $request->getParam("prenom");
                   $this->view->login = $request->getParam("login");
                   return;
               } 
			   elseif (stripos($login, " ") !== false) {
                   $error = "Le Login ne doit pas contenir d'espace";
                   $this->view->error = $error;
                   $this->view->nom = $request->getParam("nom");
                   $this->view->prenom = $request->getParam("prenom");
                   $this->view->login = $request->getParam("login");
                   return;
               }
			   
			   //insertion dans la table eu_utilisateur
			   $id_user = $mapper->findConuter() + 1;
               $userin->setId_utilisateur($id_user);
               $userin->setId_utilisateur_parent($sessionmembre->id_utilisateur); 
               $userin->setPrenom_utilisateur($prenom);
               $userin->setNom_utilisateur($nom);
               $userin->setLogin(trim($login));
               $userin->setPwd(md5($pwd));
               $userin->setDescription(null);
               $userin->setUlock(0);
               $userin->setCh_pwd_flog(0);
               $userin->setCode_groupe('smc_tesmcipnwi');
               $userin->setConnecte(0);
               $userin->setCode_agence($sessionmembre->code_agence);
				    		 
               $userin->setCode_secteur($utilisateur->code_secteur);
               $userin->setCode_zone($utilisateur->code_zone);
						
               $userin->setId_filiere($utilisateur->id_filiere);
			   
			   $userin->setCode_acteur($utilisateur->code_acteur);	   
			   $userin->setCode_gac_filiere(null);
			   $userin->setCode_groupe_create($sessionmembre->code_groupe);
			   $userin->setCode_membre($sessionmembre->code_membre);
			   
			   $userin->setId_pays($id_pays);
               $userin->setId_canton($id_canton);
               $userin->setCode_tegc(null);			   
               $mapper->save($userin);					
               $db->commit();
			   
			   $sessionmembre->errorlogin = "Operation bien effectuee ...";
			   $this->_redirect('/compteuserte/listusersmcipn');     
			
			} catch (Exception $exc) {				   
			   $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
		    }
		 
	     }
	
	 }
	 
	  public function listusersmcipnAction()   {
	    /* page administration/listtraite - Liste des traites */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
           $this->_redirect('/');
        }
		   
		$tabela = new Application_Model_DbTable_EuUtilisateur();
		$select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false);
		$select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        //$select->where('eu_utilisateur.id_utilisateur_parent = ?',$sessionmembre->id_utilisateur);
                
		$select->where('eu_utilisateur.code_membre = ?',$sessionmembre->code_membre);
		$select->where('eu_user_group.code_groupe = ?','smc_tesmcipnwi');
		$select->order('id_utilisateur desc');
		   
		$users = $tabela->fetchAll($select);
		   
		$this->view->entries = $users;
	  }
	 
	 
	 
	
	
	
	
	
	  
	  
	  
	  
	  public function listteAction()   {
	   /* page administration/listtraite - Liste des traites */
           $sessionmembre = new Zend_Session_Namespace('membre');
           //$this->_helper->layout->disableLayout();
           $this->_helper->layout()->setLayout('layoutpublicesmcperso');
           if (!isset($sessionmembre->code_membre)) {
              $this->_redirect('/');
           }
		   $tabela = new Application_Model_DbTable_EuTegc();
		   $select = $tabela->select();
		   //$select->where('id_utilisateur = ?',$sessionmembre->id_utilisateur);
                   //if(substr($sessionmembre->code_membre,19,1) == 'M') {
		      $select->where('code_membre = ?',$sessionmembre->code_membre);
                   //} 
		   $select->order('code_tegc desc');
		   
		   $tegc = $tabela->fetchAll($select);
		   
		   $this->view->entries = $tegc;
	  
	  
	  }
	  
	  
	  public function listuserAction()  {
           $sessionmembre = new Zend_Session_Namespace('membre');
           //$this->_helper->layout->disableLayout();
           $this->_helper->layout()->setLayout('layoutpublicesmcperso');

           if (!isset($sessionmembre->code_membre)) {
              $this->_redirect('/');
           }
		   
		   $tabela = new Application_Model_DbTable_EuUtilisateur();
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false);
		   $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
		   $select->join('eu_tegc', 'eu_tegc.code_tegc = eu_utilisateur.code_tegc');
           //$select->where('eu_utilisateur.id_utilisateur_parent = ?',$sessionmembre->id_utilisateur);
		   if(substr($sessionmembre->code_membre,19,1) == 'M') {
		      $select->where('eu_tegc.code_membre = ?',$sessionmembre->code_membre);
		   } else if(substr($sessionmembre->code_membre,19,1) == 'P') {
			  $select->where('eu_tegc.code_membre_physique = ?',$sessionmembre->code_membre); 
		   }
		   $select->where('eu_user_group.code_groupe = ?','cnp_tegcp');
		   //$select->order('id_utilisateur desc');
		   
		   $users = $tabela->fetchAll($select);
		   
		   $this->view->entries = $users;
	  
	  
	  
	  }
	  
	  
	  
	  public function listuserpbfAction()  {
	       /* page administration/listtraite - Liste des traites */
           $sessionmembre = new Zend_Session_Namespace('membre');
           //$this->_helper->layout->disableLayout();
           $this->_helper->layout()->setLayout('layoutpublicesmcperso');

           if (!isset($sessionmembre->code_membre)) {
              $this->_redirect('/');
           }
		   $tabela = new Application_Model_DbTable_EuUtilisateur();
		   $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false);
		   $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           //$select->where('eu_utilisateur.id_utilisateur_parent = ?',$sessionmembre->id_utilisateur);
		   $select->where('eu_utilisateur.code_membre = ?',$sessionmembre->code_membre);
		   $select->where('eu_user_group.code_groupe = ?','cnp_tegcp_pbf');
		   $select->order('id_utilisateur desc');
		   
		   $users = $tabela->fetchAll($select);
		   
		   $this->view->entries = $users;
	  }
	  
	  
	  





}