<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class  EuMembreAncienController extends Zend_Controller_Action   {

        public function init() {
           
        /* Initialize action controller here */
		 
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
		 
        if ($group == 'cm' or  $group == 'caps') {
            $menu = "<li><a id=\"new\" href=\"/eu-membre-ancien/physique\" style=\"font-size:9px\">MPP GIE</a></li>".
			        "<li><a id=\"new\" href=\"/eu-membre-ancien/physiquemcnp\" style=\"font-size:9px\">MPP MCNP</a></li>".
			        "<li><a id=\"new\" href=\"/eu-membre-ancien/index\" style=\"font-size:11px\">Liste des CM réactivés</a></li>";
                     $this->view->placeholder("menu")->set($menu);
        } elseif($group == 'productiong' or  $group == 'productionsg'  or  $group == 'productiond'
		   or  $group == 'transformationg' or  $group == 'transformationsg' or  $group == 'transformationd' or  $group == 'distributiong' or  $group == 'distributionsg' 
		   or  $group == 'distributiond') {
		    $menu ="<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralegie\" style=\"font-size:9px\">MPM GIE</a></li>".
			       "<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralemcnp\" style=\"font-size:9px\">MPM MCNP</a></li>".
			       "<li><a id=\"new\" href=\"/eu-membre-ancien/morale\" style=\"font-size:11px\">Liste des CM réactivés</a></li>";
                    $this->view->placeholder("menu")->set($menu);  
		} elseif($group == 'scmg' or  $group == 'scmsg' or  $group == 'scmd') {
		    $menu ="<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralegieose\" style=\"font-size:9px\">MPM GIE</a></li>".
			       "<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralemcnpose\" style=\"font-size:9px\">MPM MCNP</a></li>".
			       "<li><a id=\"new\" href=\"/eu-membre-ancien/morale\" style=\"font-size:11px\">Liste des CM réactivés</a></li>";
                   $this->view->placeholder("menu")->set($menu);  
		}		  
		elseif ($group == 'caps') {
            $menu = '<li><a id="caps" href="/eu-bnp/caps" style=\"font-size:11px\">CAPS</a></li>
                    <li><a id="listes" href="/eu-bnp/listes" style=\"font-size:11px\">Vue des bnp</a></li>
                    <li><a id="new" href="/eu-contrat/new" style=\"font-size:11px\">Ajout de contrats</a></li>';
                    $this->view->placeholder("menu")->set($menu);   
        }
		elseif ($group == 'scmpmaoe') {
                $menu ="<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralegie\" style=\"font-size:9px\">MPM GIE</a></li>".
			           "<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralemcnp\" style=\"font-size:9px\">MPM MCNP</a></li>".
			           "<li><a id=\"new\" href=\"/eu-membre-ancien/morale\" style=\"font-size:11px\">Liste des CM réactivés</a></li>";
				    $this->view->placeholder("menu")->set($menu);
        }
		else if ($group == 'scmpmaose') {
		        $menu ="<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralegieose\" style=\"font-size:9px\">MPM GIE</a></li>".
			           "<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralemcnpose\" style=\"font-size:9px\">MPM MCNP</a></li>".
			           "<li><a id=\"new\" href=\"/eu-membre-ancien/morale\" style=\"font-size:11px\">Liste des CM réactivés</a></li>";
                    $this->view->placeholder("menu")->set($menu);
		}
		else if ($group == 'scmpmapbf') {
		        $menu ="<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralegiepbf\" style=\"font-size:9px\">MPM GIE</a></li>".
			           "<li><a id=\"new\" href=\"/eu-membre-ancien/newmoralemcnppbf\" style=\"font-size:9px\">MPM MCNP</a></li>".
			           "<li><a id=\"new\" href=\"/eu-membre-ancien/morale\" style=\"font-size:11px\">Liste des CM réactivés</a></li>";
				$this->view->placeholder("menu")->set($menu);
		}
		
		
		
		
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
		
		//$liste = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $liste = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
        $codesecret = "";
        while(strlen($codesecret) != 8) {
        $codesecret .= $liste[rand(0,strlen($liste)-1)]; 
       }
       $this->view->codesecret = $codesecret;
			
    }
	
	function preDispatch() {
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        
        if (!$auth->hasIdentity()) {
           $this->_redirect('login');
        } 
        else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
			if($user->code_agence == null) {
			    $this->view->user = $user;
                return $this->_redirect('index2'); 
            }
            if ($group != 'caps' and $group != 'cm' and $group != 'productiong'and $group != 'productionsg'and $group != 'productiond'
			    and $group != 'transformationg'and $group != 'transformationsg'and $group != 'transformationd' and $group != 'distributiong' 
				and $group != 'distributionsg' and $group != 'distributiond' and $group != 'scmg' and $group != 'scmsg' and $group != 'scmd'
				and  $group != 'scmpmaoe' and  $group != 'scmpmaose' and  $group != 'scmpmapbf') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
    
    public function indexAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
           $this->_helper->layout->disableLayout();
        }
    }
    
    public function moraleAction() {
        // action body
       // $this->_helper->layout->disableLayout();
        
        if (isset($_POST["code_membre"])) {
           $code_membre = $_POST['code_membre'];
           $this->view->code_membre = $code_membre;
        }
        if (isset($_POST["nomm"])) {
            $nomm = $_POST['nomm'];
            $this->view->nomm = $nomm;
        }         
    }


    public function physiqueAction() {
           // action body
           //$this->_helper->layout->disableLayout();    
    }
	
	
	public function physiquemcnpAction() {
           // action body
           //$this->_helper->layout->disableLayout();	       
    }
	
	public function changemmcnpAction() {
        
        $data = array();
        $membre = new Application_Model_DbTable_EuAncienMembre();
        $select = $membre->select();
		$select->where('type_membre = ?','M');
        $select->from($membre, array('ancien_code_membre'));
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
            $data[] = $m->ancien_code_membre;
        }
        $this->view->data = $data;
    }
	
	
	
    
    public function changemAction() {
        
        $data = array();
        $membre = new Application_Model_DbTable_Morale();
        $select = $membre->select();
        $select->from($membre, array('numidentm'));
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
            $data[] = $m->numidentm;
        }
        $this->view->data = $data;
    }
    
    public function changepAction() {
        $data = array();
		$membres = new Application_Model_DbTable_EuAncienMembre();
		$selectm = $membres->select();
        $selectm->from($membres,array('ancien_code_membre'));
		$selectm->where('type_membre like ?','P');
		$resultm = $membres->fetchAll($selectm);
        foreach ($resultm as $m) {
		  $data[] = $m->ancien_code_membre;	 
        }
        $this->view->data = $data;
    }
    
    public function cmmAction() {
        $numident = $this->getRequest()->numident;
        $morale = new Application_Model_DbTable_Morale();
        $select = $morale->select();
        $select->from($morale, array('etat_contrat'))
               ->where('numidentm = ?',$numident);
        $result = $morale->fetchAll($select);
        foreach ($result as $m) {
            $data = $m->etat_contrat;
        }
        $this->view->data = $data;
    }
    
	
    public function cmpAction() {
        $numident = $this->getRequest()->numident;
        $physique = new Application_Model_DbTable_Physique();
        $select = $physique->select();
        $select->from($physique, array('etat_contrat'))
               ->where('numidentp = ?',$numident);
        $result = $physique->fetchAll($select);
        foreach ($result as $p) {
            $data = $p->etat_contrat;
        }
        $this->view->data = $data;
    }
	
	
	
	public function cmpmcnpAction() {
         $code_membre = $this->getRequest()->code;
         $membres = new Application_Model_DbTable_EuAncienMembre();
         $select = $membres->select();
         $select->from($membres, array('etat_contrat'))
                ->where('ancien_code_membre = ?',$code_membre);
         $result = $physique->fetchAll($select);
         foreach ($result as $p) {
            $data = $p->etat_contrat;
         }
         $this->view->data = $data;
    }
	
	
	public function ncmmmcnposeAction() {
	
	    $request = $this->getRequest();
        $raison_sociale = $request->raison_sociale;
        $this->view->raison_sociale = $raison_sociale;
        if(isset($raison_sociale))
            $this->_helper->layout->disableLayout();
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $code_agence = $user->code_agence;
            $fs = Util_Utils::getParametre('FS', 'valeur');
            $this->view->fs = $fs;
            $request = $this->getRequest();
            $code_membre = $request->code_membre;
            $this->view->ancien_code_membre = $code_membre;
            $ville = $request->ville_membre;
            $this->view->ville = $ville;
            $tel = $request->tel_membre;
            $this->view->tel = $tel;
	        $qart = $request->quartier_membre;
            $this->view->quartier_membre = $qart;
	        $portable = $request->portable_membre;
            $this->view->portable = $portable;
	        $email = $request->email_membre;
            $this->view->email = $email;
	        $site = $request->site_web;
            $this->view->site_web = $site;
	        $bp = $request->bp_membre;
            $this->view->bp = $bp;
		   
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
		    $table = new Application_Model_DbTable_EuActeur();
			//$select = $table->select();
			//$select->where('code_acteur like ?',$user->code_acteur);
			//$result = $table->fetchAll($select);
			//$findacteur = $result->current();
			//$code_gac_chaine = $findacteur->code_gac_chaine;
			//$selection = $table->select();
			//$selection->where('code_gac_chaine like ?',$code_gac_chaine);
			//$selection->where('type_acteur like ?','gac_surveillance');
			//$resultat = $table->fetchAll($selection);
			//$trouvacteursur = $resultat->current();
			//$acteur = $trouvacteursur->code_acteur;
			$acteur = $user->code_acteur;
		   
		   
		    if ($this->getRequest()->isPost()) {
			    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
				
			    $id_type_acteur = "";
			    $id_type_creneau = "";
                $id_filiere = "";
				
				$sms_mapper = new Application_Model_EuSmsmoneyMapper();
			    $mont_fl = Util_Utils::getParametre('FL','valeur');
			    $compte = new Application_Model_EuCompte();
                $map_compte = new Application_Model_EuCompteMapper();
		        $tcartes = array();
			    $tscartes = array();
				
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {
			      $agrement_mapper = new Application_Model_EuAgrementMapper();
			      $agrement        = new Application_Model_EuAgrement();
				  $compte = new Application_Model_EuCompte();
                  $map_compte = new Application_Model_EuCompteMapper();
				   
				  $agrement_filiere  =  $_POST["agrement_filiere"];
                  $agrement_acnev    =  $_POST["agrement_acnev"];
                  $agrement_technopole =  $_POST["agrement_technopole"];
				  $code_fl =  $_POST["code_fl"];
				  $code_agence = $user->code_agence;
				  $fs = Util_Utils::getParametre('FS', 'valeur');
				   
				  //insertion dans la table membremorale des information du nouveau membre
                   $membre = new Application_Model_EuMembreMorale();
                   $mapper = new Application_Model_EuMembreMoraleMapper();
				   $membre1 = new Application_Model_EuMembreMorale();
                   $mapper1 = new Application_Model_EuMembreMoraleMapper();
                   $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                      $code = $code_agence . '0000001' . 'M';
                    } else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'M';
                    }
				   
				    //insertion dans la table eu_operation
                    $mapper_op = new Application_Model_EuOperationMapper();
                    $compteur = $mapper_op->findConuter() + 1;
						
				    $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				    $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				    $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
				   
				    // verification agrement filiere
				    if($trouveagrementf != false) {
				      $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
					  
					  $id_type_creneau = $agrement->getId_type_creneau();
					  $id_type_acteur =  $agrement->getId_type_acteur();
					  $id_filiere =  $agrement->getId_filiere();
				      
					  $agrement->setCode_membre_morale($code);
				      $agrement_mapper->update($agrement);
					  
					  //$resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
					  
					  // insertion dans la table eu_membre
					  $membre->setId_filiere($id_filiere);
					  $membre->setCode_membre_morale($code);
                      $membre->setCode_type_acteur($_POST["type_acteur"]);
                      $membre->setCode_statut($_POST["statut_juridique"]);
                      $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
					  $membre->setId_pays($_POST["id_pays"]);
                      $membre->setNum_registre_membre($_POST["num_registre"]);
                      $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                      $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                      $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                      $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                      $membre->setBp_membre($_POST["bp_membre"]);
                      $membre->setTel_membre($_POST["tel_membre"]);
                      $membre->setEmail_membre($_POST["email_membre"]);
                      $membre->setPortable_membre($_POST["portable_membre"]);
                      $membre->setId_utilisateur($utilisateur);
                      $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                      $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                      $membre->setCode_agence($code_agence);
                      $membre->setCodesecret(md5($_POST["codesecret"]));
                      $membre->setAuto_enroler('O');
					  $membre->setEtat_membre('A');
				      $mapper->save($membre);
					  
					  
					  // insertion dans la table eu_acteurs_creneau
					  $cm = new Application_Model_EuActeurCreneauMapper();
                      $acren = new Application_Model_EuActeurCreneau();
							
					  $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                      $acren->setCode_membre($code);
					  $acren->setId_type_acteur($id_type_acteur);
					  
					  //$acren->setCode_activite(null);
                      $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                      $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                      $acren->setId_utilisateur($utilisateur);
					  $acren->setGroupe($groupe);
					  $acren->setCode_creneau(null);
                      $acren->setCode_gac_filiere(null);
                      $acren->setCode_gac(null);
							
							
					  $code_zone = $user->code_zone;
			          $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                      if ($code_acteur == null) {
                        $code_acteur = 'A' . $code_zone . '0001';
                      } else {
                        $num_ordre = substr($code_acteur, -4);
                        $num_ordre++;
                        $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                      }
						
					  $acren->setCode_acteur($code_acteur);
					  $acren->setId_filiere($id_filiere);
					  $cm->save($acren);	
							
				      // insertion dans la table eu_operation
                      Util_Utils::addOperation($compteur,null,$code,'TFS',$fs,'FS','Auto-enrôlement','AERL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),$user->id_utilisateur);
					   
					  //insertion dans la table eu_representation
					    $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
					    $rep->setCode_membre_morale($code)
                          ->setCode_membre($_POST['code_rep'])
                          ->setTitre("Representant")
						  ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						  ->setId_utilisateur($user->id_utilisateur)
						  ->setEtat('inside');
                        $rep_mapper->save($rep);
						
				      //insertion dans la table eu_compte_bancaire
                      $cpte = $_POST['cpteur'];
                      $i = 1;
                      $cb_mapper = new Application_Model_EuCompteBancaireMapper();
					  $id_compte = $cb_mapper->findConuter() + 1;
                      $cb = new Application_Model_EuCompteBancaire();
                      while ($i <= $cpte) {
                        if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                           $cb->setId_compte($id_compte)
							  ->setCode_banque($_POST['code_banque' . $i])
                              ->setCode_membre_morale($code)
						      ->setCode_membre(null)
                              ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                           $cb_mapper->save($cb);
                         }
                           $i++;
                        }
				    } else {
				        $db->rollBack();
				        $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
				    }
				   
				   // verification agrement acnev
				    if($trouveagrementacnev != false) {
				       $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				       $agrement->setCode_membre_morale($code);
				       $agrement_mapper->update($agrement);			
				    } else {
				       $db->rollBack();
				       $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
				    }
					
					// verification agrement technopole
					if($trouveagrementtechno != false) {
				      $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
				      $agrement_mapper->update($agrement);			
				    } else {
				      $db->rollBack();
				      $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
				    } 
				   
				    $filiere =  new Application_Model_EuFiliere();
				    $map_filiere = new Application_Model_EuFiliereMapper();
				    $find_filiere = $map_filiere->find($id_filiere,$filiere);
				   
				    // insertion dans la table eu_acteur
				    $t_acteur = new Application_Model_DbTable_EuActeur();
				    $c_acteur = new Application_Model_EuActeur();
				    $table = new Application_Model_DbTable_EuActeur();
                    $select = $table->select();
				    $select->where('code_acteur like ?', $acteur);
				    $resultSet = $table->fetchAll($select);
				    $ligneacteur = $resultSet->current();
				    $count = $c_acteur->findConuter() + 1;
                    $c_acteur->setId_acteur($count)
                             ->setCode_acteur(null)
							 ->setCode_division($filiere->getCode_division())
                             ->setCode_membre($code)
                             ->setId_utilisateur($utilisateur)
                             ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					$c_acteur->setCode_source_create($ligneacteur->code_source_create);
					$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					$c_acteur->setId_pays($ligneacteur->id_pays);
					$c_acteur->setId_region($ligneacteur->id_region);
					$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					
                    if($id_type_acteur == 3) {
                        $c_acteur->setCode_activite('detaillant');	
                    } elseif($id_type_acteur == 2) {
                        $c_acteur->setCode_activite('semi-grossiste');  
                    } elseif($id_type_acteur == 1) {
                        $c_acteur->setCode_activite('grossiste'); 
                    }
                    $c_acteur->setType_acteur('DSMS');
                    $c_acteur->setCode_gac_chaine($acteur);
                    $t_acteur->insert($c_acteur->toArray());
					  
					//R?cup?ration de la prk nr
                    $param = new Application_Model_EuParametresMapper();
                    $par = new Application_Model_EuParametres();
                    $prc = 0;
                    $par_prc = $param->find('prc', 'nr', $par);
                    if ($par_prc == true) {
                       $prc = $par->getMontant();
                    }
					
                    // insertion dans la table eu_tegc					
					$te_mapper = new Application_Model_EuTegcMapper();
                    $te = new Application_Model_EuTegc();
                    $code_te = 'TEGCP' .$id_filiere. $code;
                    $find_te = $te_mapper->find($code_te,$te);
                        if ($find_te == false) {
                         $te->setCode_tegc($code_te)
                            ->setId_filiere($id_filiere)
                            ->setMdv($prc)
                            ->setCode_membre($code)
                            ->setMontant(0)
							->setMontant_utilise(0)
							->setSolde_tegc(0);
                          $te_mapper->save($te);
                        } else {
                          $te->setId_filiere($id_filiere);
                          $te->setMdv($prc);
                          $te_mapper->update($te);
                        }
					      
					// insertion dans la table eu_utilisateur
					$user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                    if($id_type_acteur == 3) {
                        $userin->setCode_groupe('ose_detaillant');
                        $userin->setCode_gac_filiere('ose_detaillant');
					    $userin->setCode_groupe_create('ose_detaillant');
                    } elseif($id_type_acteur == 2) {
                        $userin->setCode_groupe('ose_semi_grossiste');
					    $userin->setCode_groupe_create('ose_semi_grossiste');
                        $userin->setCode_gac_filiere(null);
                    } elseif($id_type_acteur == 1) {
                        $userin->setCode_groupe('ose_grossiste');
					    $userin->setCode_groupe_create('ose_grossiste');
                        $userin->setCode_gac_filiere(null);
                    }
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
                    
				    $userin->setCode_acteur($acteur);
					
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(3);
					$contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
					$tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
				    $tafl = new Application_Model_DbTable_EuAncienFl();
                    $afl = new Application_Model_EuAncienFl();
                    $code_fl = 'FL-'.$_POST["ancien_code_membre"];
                    $result = $tafl->find($code_fl);
					
					//$tcartes = array();
			        //$tscartes = array();
					
					if (count($result) > 0) {
					    $code_afl = 'FL-'.$code;
					    $mont_fl = Util_Utils::getParametre('FL','valeur'); 
					    $fl->setCode_fl($code_afl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode(null);
                        $tfl->insert($fl->toArray());
						
						
						// insertion dans la table eu_compte
						$tcartes[0]="TPAGCP";
						$tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
						$tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
						$tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";
						//$tcartes[15]="TMARGENB";
									
									for($i = 0; $i < count($tcartes); $i++) {
									    if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                            $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NR';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA"  || $tcartes[$i] == "TRE") {
                                            $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
										    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TIN") {
										    $tcartes[$i] = "TI"; 
										    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_compte,$compte);
										} 
										elseif($tcartes[$i] == "TMARGE") {
										    $tcartes[$i] = "TMARGE"; 
										    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_compte,$compte);
										} 
										/*elseif($tcartes[$i] == "TMARGENB") {
										    $tcartes[$i] = "TMARGE"; 
										    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_compte,$compte);
										}*/
										
										elseif($tcartes[$i] == "TIR") {
										    $tcartes[$i] = "TI"; 
										    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NR';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TIB") {
										    $tcartes[$i] = "TI";
										    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_compte,$compte);
										}
										
										if(!$res) {
                                          $compte->setCode_cat($tcartes[$i])
                                                 ->setCode_compte($code_compte)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                                 ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tcartes[$i])
                                                 ->setSolde(0);
										  $map_compte->save($compte);
									
									    }
									
                                    }
									
									$tscartes[0]="TSGCP";
									$tscartes[1]="TSCNCSEI";
									$tscartes[2]="TSGCI";
									$tscartes[3]="TSCAPA";
									$tscartes[4]="TSPaNu";
									$tscartes[5]="TSPaR";
									$tscartes[6]="TSFS";
									$tscartes[7]="TSPN";
									$tscartes[8]="TSIN";
									$tscartes[9]="TSIB";
									$tscartes[10]="TSIR";
									$tscartes[11]="TSMARGE";
									$tscartes[12]="TSRE";
									
									for($j = 0; $j < count($tscartes); $j++) {
									
									    if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                          $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'NR';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                          $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'NN';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
										  || $tscartes[$j] == "TSFS") {
										    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSIN") {
										    $tscartes[$j] = "TSI"; 
										    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSMARGE") {
										    $tscartes[$j] = "TSMARGE"; 
										    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_comptets,$compte);
										} 
										elseif($tscartes[$j] == "TSIR") {
										    $tscartes[$j] = "TSI"; 
										    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NR';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSIB") {
										    $tscartes[$j] = "TSI";
										    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_comptets,$compte);
										}
										
										if(!$res) {
                                            $compte->setCode_cat($tscartes[$j])
                                                 ->setCode_compte($code_comptets)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                                 ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tscartes[$j])
                                                 ->setSolde(0);
											$map_compte->save($compte);
									    }
									
                                    } 
					} elseif($code_fl != "") {
					    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
					    if ($sms_fl == null) {
                           $db->rollback();
                           $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
						   $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                        }
						
						if($sms_fl->getMotif() != 'FL') {
					      $db->rollBack();
						  $this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
						  $this->view->type_acteur = $_POST["type_acteur"];
                          $this->view->statut_juridique = $_POST["statut_juridique"];
                          $this->view->raison = $_POST["raison_sociale"];
                          $this->view->domaine_activite = $_POST["domaine_activite"];
                          $this->view->site_web = $_POST["site_web"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          $this->view->registre = $_POST["num_registre"];
                          return;    
					    }
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						$compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,null,$code, null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
												
						$sms_fl->setDestAccount_Consumed('FL-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
						
						$tcartes[0]="TPAGCP";
					    $tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
					    $tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
					    $tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";
									
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
						    } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA"  || $tcartes[$i] == "TRE") {
                                    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
								    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIN") {
									$tcartes[$i] = "TI"; 
									$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							}
                            elseif($tcartes[$i] == "TMARGE") {
									$tcartes[$i] = "TMARGE"; 
									$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							} 							
							elseif($tcartes[$i] == "TIR") {
									$tcartes[$i] = "TI"; 
								    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIB") {
								    $tcartes[$i] = "TI";
									$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
							}
										
								if(!$res) {
								// insertion dans la table eu_compte
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								$map_compte->save($compte);
									
								}
									
                        }
						
						$tscartes[0]="TSGCP";
						$tscartes[1]="TSCNCSEI";
						$tscartes[2]="TSGCI";
						$tscartes[3]="TSCAPA";
						$tscartes[4]="TSPaNu";
						$tscartes[5]="TSPaR";
						$tscartes[6]="TSFS";
						$tscartes[7]="TSPN";
						$tscartes[8]="TSIN";
						$tscartes[9]="TSIB";
						$tscartes[10]="TSIR";
						$tscartes[11]="TSMARGE";
						$tscartes[12]="TSRE";
									
						for($j = 0; $j < count($tscartes); $j++) {		
						    if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} 
							elseif($tscartes[$j] == "TSMARGE") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} 
							elseif($tscartes[$j] == "TSIR") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
								$tscartes[$j] = "TSI";
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							}
										
							if(!$res)   {
							// insertion dans la table eu_compte
                            $compte->setCode_cat($tscartes[$j])
                                   ->setCode_compte($code_comptets)
                                   ->setCode_membre(null)
								   ->setCode_membre_morale($code)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tscartes[$j])
                                   ->setSolde(0);
								$map_compte->save($compte);
							}			
                        }	
					}
					else  {
				           $db->rollBack();
				           $this->view->message = "Vous devez payer les frais de licence";
				           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
				    }
					
					//Mise à jour de la table morale
                    $m_mapper = new Application_Model_EuAncienMembreMapper();
                    $m = new Application_Model_EuAncienMembre();
                    $rep = $m_mapper->find($_POST["ancien_code_membre"],$m);
                    if ($rep == true) {
                        $m->setEtat_contrat(1)
				          ->setCode_membre($code);
                        $m_mapper->update($m);
                    }
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre-ancien', 'action' => 'morale'));
			    } catch (Exception $exc) {
			        $db->rollback();
				    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
				    $this->view->id_pays = $_POST["id_pays"];
                   $this->view->portable = $_POST["portable_membre"];
                   $this->view->registre = $_POST["num_registre"];
			       $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                   return;
                }
            }
	
	}
	
	public function ncmmmcnppbfAction() {
	
	       $request = $this->getRequest();
           $raison_sociale = $request->raison_sociale;
           $this->view->raison_sociale = $raison_sociale;
           if(isset($raison_sociale))
            $this->_helper->layout->disableLayout();
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $code_agence = $user->code_agence;
            $fs = Util_Utils::getParametre('FS', 'valeur');
            $this->view->fs = $fs;
            $request = $this->getRequest();
            $code_membre = $request->code_membre;
            $this->view->ancien_code_membre = $code_membre;
            $ville = $request->ville_membre;
            $this->view->ville = $ville;
            $tel = $request->tel_membre;
            $this->view->tel = $tel;
	        $qart = $request->quartier_membre;
            $this->view->quartier_membre = $qart;
	        $portable = $request->portable_membre;
            $this->view->portable = $portable;
	        $email = $request->email_membre;
            $this->view->email = $email;
	        $site = $request->site_web;
            $this->view->site_web = $site;
	        $bp = $request->bp_membre;
            $this->view->bp = $bp;
		   
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
		    $table = new Application_Model_DbTable_EuActeur();
			$select = $table->select();
			$select->where('code_acteur like ?',$user->code_acteur);
			$result = $table->fetchAll($select);
			$findacteur = $result->current();
			$code_gac_chaine = $findacteur->code_gac_chaine;
			$selection = $table->select();
			$selection->where('code_gac_chaine like ?',$code_gac_chaine);
			$selection->where('type_acteur like ?','gac_surveillance');
			$resultat = $table->fetchAll($selection);
			$trouvacteursur = $resultat->current();
			$acteur = $trouvacteursur->code_acteur;
			
			//$acteur = $user->code_acteur;
		   
		    if ($this->getRequest()->isPost()) {
			   $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
			
			$id_type_acteur = "";
			$id_type_creneau = "";
			$id_filiere = "";
			
			$sms_mapper = new Application_Model_EuSmsmoneyMapper();
			$mont_fl = Util_Utils::getParametre('FL','valeur');
			$compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
		    $tcartes = array();
			$tscartes = array();  
			$db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try {
			    $agrement_mapper = new Application_Model_EuAgrementMapper();
			    $agrement        = new Application_Model_EuAgrement();
				$compte = new Application_Model_EuCompte();
                $map_compte = new Application_Model_EuCompteMapper();
				   
				$agrement_filiere  =  $_POST["agrement_filiere"];
                $agrement_acnev    =  $_POST["agrement_acnev"];
                $agrement_technopole =  $_POST["agrement_technopole"];
				$code_fl =  $_POST["code_fl"];
				$code_agence = $user->code_agence;
				$fs = Util_Utils::getParametre('FS','valeur');
				   
				//insertion dans la table membremorale des information du nouveau membre
                    $membre = new Application_Model_EuMembreMorale();
                    $mapper = new Application_Model_EuMembreMoraleMapper();
				    $membre1 = new Application_Model_EuMembreMorale();
                    $mapper1 = new Application_Model_EuMembreMoraleMapper();
                    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                      $code = $code_agence . '0000001' . 'M';
                    } else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'M';
                    }
				   
				    //insertion dans la table eu_operation
                    $mapper_op = new Application_Model_EuOperationMapper();
                    $compteur = $mapper_op->findConuter() + 1;
						
				    $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				    $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				    $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
				   
				    // verification agrement filiere
				    if($trouveagrementf != false) {
				       $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
					   $id_type_creneau = $agrement->getId_type_creneau();
					   $id_type_acteur =  $agrement->getId_type_acteur();
					   $id_filiere =  $agrement->getId_filiere();
					  
				       $agrement->setCode_membre_morale($code);
				       $agrement_mapper->update($agrement);
					   //$resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
					  
					   $membre->setId_filiere($id_filiere);
					   $membre->setCode_membre_morale($code);
                       $membre->setCode_type_acteur($_POST["type_acteur"]);
                       $membre->setCode_statut($_POST["statut_juridique"]);
                       $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
					   $membre->setId_pays($_POST["id_pays"]);
                       $membre->setNum_registre_membre($_POST["num_registre"]);
                       $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                       $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                       $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                       $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                       $membre->setBp_membre($_POST["bp_membre"]);
                       $membre->setTel_membre($_POST["tel_membre"]);
                       $membre->setEmail_membre($_POST["email_membre"]);
                       $membre->setPortable_membre($_POST["portable_membre"]);
                       $membre->setId_utilisateur($utilisateur);
                       $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                       $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                       $membre->setCode_agence($code_agence);
                       $membre->setCodesecret(md5($_POST["codesecret"]));
                       $membre->setAuto_enroler('O');
					   $membre->setEtat_membre('A');
				       $mapper->save($membre);
					  
					  
					   // eu_acteurs_creneau
					   $cm = new Application_Model_EuActeurCreneauMapper();
                       $acren = new Application_Model_EuActeurCreneau();
							
					   $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                       $acren->setCode_membre($code);
					   $acren->setId_type_acteur($id_type_acteur);
					  
					   //$acren->setCode_activite(null);
                       $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                       $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                       $acren->setId_utilisateur($utilisateur);
					   $acren->setGroupe($groupe);
					   $acren->setCode_creneau(null);
                       $acren->setCode_gac_filiere(null);
                       $acren->setCode_gac(null);
							
							
					    $code_zone = $user->code_zone;
			            $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                        if ($code_acteur == null) {
                          $code_acteur = 'A' . $code_zone . '0001';
                        } else {
                          $num_ordre = substr($code_acteur, -4);
                          $num_ordre++;
                          $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                        }
						
					    $acren->setCode_acteur($code_acteur);
					    $acren->setId_filiere($id_filiere);
					    $cm->save($acren);	
							
				        // insertion dans la table eu_operation
                        Util_Utils::addOperation($compteur,null,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
					   
					    //insertion dans la table eu_representation
					    $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
					    $rep->setCode_membre_morale($code)
                            ->setCode_membre($_POST['code_rep'])
                            ->setTitre("Representant")
						    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						    ->setId_utilisateur($user->id_utilisateur)
						    ->setEtat('inside');
                        $rep_mapper->save($rep);
						
				        //insertion dans la table eu_compte_bancaire
                        $cpte = $_POST['cpteur'];
                        $i = 1;
                        $cb_mapper = new Application_Model_EuCompteBancaireMapper();
					    $id_compte = $cb_mapper->findConuter() + 1;
                        $cb = new Application_Model_EuCompteBancaire();
                        while ($i <= $cpte) {
                        if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                            $cb->setId_compte($id_compte)
							  ->setCode_banque($_POST['code_banque' . $i])
                              ->setCode_membre_morale($code)
						      ->setCode_membre(null)
                              ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                            $cb_mapper->save($cb);
                            }
                            $i++;
                        }
				    } else {
				      $db->rollBack();
				      $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
				    }
				    // verification agrement acnev
				    if($trouveagrementacnev != false) {
				       $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				       $agrement->setCode_membre_morale($code);
				       $agrement_mapper->update($agrement);			
				    } else {
				       $db->rollBack();
				       $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
				    }
					
					// verification agrement technopole
					if($trouveagrementtechno != false) {
				      $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
				      $agrement_mapper->update($agrement);			
				    } else {
				      $db->rollBack();
				      $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
				    } 
				   
				    $filiere =  new Application_Model_EuFiliere();
				    $map_filiere = new Application_Model_EuFiliereMapper();
				    $find_filiere = $map_filiere->find($id_filiere,$filiere);
				   
				    $t_acteur = new Application_Model_DbTable_EuActeur();
				    $c_acteur = new Application_Model_EuActeur();
				    $table = new Application_Model_DbTable_EuActeur();
                    $select = $table->select();
				    $select->where('code_acteur like ?', $acteur);
				    $resultSet = $table->fetchAll($select);
				    $ligneacteur = $resultSet->current();
					// insertion dans la table eu_acteur
				    $count = $c_acteur->findConuter() + 1;
                    $c_acteur->setId_acteur($count)
                            ->setCode_acteur(null)
							->setCode_division($filiere->getCode_division())
                            ->setCode_membre($code)
                            ->setId_utilisateur($utilisateur)
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
							
					$c_acteur->setCode_source_create($ligneacteur->code_source_create);
					$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					$c_acteur->setId_pays($ligneacteur->id_pays);
					$c_acteur->setId_region($ligneacteur->id_region);
					$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);

					
                    if($id_type_acteur == 3) {
                        $c_acteur->setCode_activite('detaillant');	
                    } elseif($id_type_acteur == 2) {
                        $c_acteur->setCode_activite('semi-grossiste');  
                    } elseif($id_type_acteur == 1) {
                        $c_acteur->setCode_activite('grossiste'); 
                    }
                    $c_acteur->setType_acteur('PBF');
                    $c_acteur->setCode_gac_chaine($acteur);
                    $t_acteur->insert($c_acteur->toArray());
					  
					//R?cup?ration de la prk nr
                    $param = new Application_Model_EuParametresMapper();
                    $par = new Application_Model_EuParametres();
                    $prc = 0;
                    $par_prc = $param->find('prc', 'nr', $par);
                    if ($par_prc == true) {
                        $prc = $par->getMontant();
                    }
					
                    // insertion dans la table eu_tegc					
					$te_mapper = new Application_Model_EuTegcMapper();
                    $te = new Application_Model_EuTegc();
                    $code_te = 'TEGCP' .$id_filiere. $code;
                    $find_te = $te_mapper->find($code_te,$te);
                        if ($find_te == false) {
                        $te->setCode_tegc($code_te)
                            ->setId_filiere($id_filiere)
                            ->setMdv($prc)
                            ->setCode_membre($code)
                            ->setMontant(0)
							->setMontant_utilise(0)
							->setSolde_tegc(0);
                        $te_mapper->save($te);
                        } else {
                        $te->setId_filiere($id_filiere);
                        $te->setMdv($prc);
                        $te_mapper->update($te);
                        }
					      
					// table eu_utilisateur
					$user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                    if($id_type_acteur == 3) {
                        $userin->setCode_groupe('pbf_detaillant');
                        $userin->setCode_gac_filiere('pbf_detaillant');
					    $userin->setCode_groupe_create('pbf_detaillant');
                    } elseif($id_type_acteur == 2) {
                        $userin->setCode_groupe('pbf_semi_grossiste');
					    $userin->setCode_groupe_create('pbf_semi_grossiste');
                        $userin->setCode_gac_filiere(null);
                    } elseif($id_type_acteur == 1) {
                        $userin->setCode_groupe('pbf_grossiste');
					    $userin->setCode_groupe_create('pbf_grossiste');
                        $userin->setCode_gac_filiere(null);
                    }
					
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
				    $userin->setCode_acteur($acteur);
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
					$contrat->setId_type_contrat(3);
                    $contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
					$tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
				    $tafl = new Application_Model_DbTable_EuAncienFl();
                    $afl = new Application_Model_EuAncienFl();
                    $code_fl = 'FL-'.$_POST["ancien_code_membre"];
                    $result = $tafl->find($code_fl);
					
					//$tcartes = array();
			        //$tscartes = array();
					
					if (count($result) > 0) {
					    $code_afl = 'FL-'.$code;
					    $mont_fl = Util_Utils::getParametre('FL','valeur'); 
					    $fl->setCode_fl($code_afl)
                          ->setCode_membre(null)
						  ->setCode_membre_morale($code)
                          ->setMont_fl($mont_fl)
                          ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                          ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                          ->setId_utilisateur($user->id_utilisateur)
                          ->setCreditcode(null);
                        $tfl->insert($fl->toArray());
						
						// insertion dans la table eu_compte
						$tcartes[0]="TPAGCP";
						$tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
						$tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
						$tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";
						$tcartes[15]="TPAGCPPBF";
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA"  || $tcartes[$i] == "TRE") {
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS" || $tcartes[$i] == "TPAGCPPBF") {
								$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIN") {
								$tcartes[$i] = "TI"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
							    $res = $map_compte->find($code_compte,$compte);
							} 
							elseif($tcartes[$i] == "TMARGE") {
								$tcartes[$i] = "TMARGE"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
							    $res = $map_compte->find($code_compte,$compte);
							}
							elseif($tcartes[$i] == "TIR") {
								$tcartes[$i] = "TI"; 
								$code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIB") {
								$tcartes[$i] = "TI";
								$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_compte,$compte);
							}
										
								if(!$res) {
                                    $compte->setCode_cat($tcartes[$i])
                                           ->setCode_compte($code_compte)
                                           ->setCode_membre(null)
										   ->setCode_membre_morale($code)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tcartes[$i])
                                           ->setSolde(0);
									$map_compte->save($compte);	
							    }			
                        }
									
						$tscartes[0]="TSGCP";
						$tscartes[1]="TSCNCSEI";
						$tscartes[2]="TSGCI";
						$tscartes[3]="TSCAPA";
						$tscartes[4]="TSPaNu";
						$tscartes[5]="TSPaR";
						$tscartes[6]="TSFS";
						$tscartes[7]="TSPN";
						$tscartes[8]="TSIN";
						$tscartes[9]="TSIB";
						$tscartes[10]="TSIR";
						$tscartes[11]="TSMARGE";
						$tscartes[12]="TSRE";
						$tscartes[13]="TSGCPPBF";
									
						for($j = 0; $j < count($tscartes); $j++) {
									
							if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
										  || $tscartes[$j] == "TSFS"  || $tscartes[$j] == "TSGCPPBF") {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} 
							elseif($tscartes[$j] == "TSMARGE") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							}
							elseif($tscartes[$j] == "TSIR") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
								$tscartes[$j] = "TSI";
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
						    }
										
								if(!$res) {
                                    $compte->setCode_cat($tscartes[$j])
                                           ->setCode_compte($code_comptets)
                                           ->setCode_membre(null)
										   ->setCode_membre_morale($code)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tscartes[$j])
                                           ->setSolde(0);
									$map_compte->save($compte);
							    }
									
                            }	
					
					} elseif($code_fl != "") {
					    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
					    if ($sms_fl == null) {
                           $db->rollback();
                           $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
						   $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                        }
						
						if($sms_fl->getMotif() != 'FL') {
					      $db->rollBack();
						  $this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
						  $this->view->type_acteur = $_POST["type_acteur"];
                          $this->view->statut_juridique = $_POST["statut_juridique"];
                          $this->view->raison = $_POST["raison_sociale"];
                          $this->view->domaine_activite = $_POST["domaine_activite"];
                          $this->view->site_web = $_POST["site_web"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          $this->view->registre = $_POST["num_registre"];
                          return;    
					    }
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						$compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,null,$code, null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),$user->id_utilisateur);
												
						$sms_fl->setDestAccount_Consumed('FL-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
						
						$tcartes[0]="TPAGCP";
					    $tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
					    $tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
					    $tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";
						$tcartes[15]="TPAGCPPBF";
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
						    } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS" || $tcartes[$i] == "TPAGCPPBF") {
								    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIN") {
									$tcartes[$i] = "TI"; 
									$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							} 
							elseif($tcartes[$i] == "TMARGE") {
									$tcartes[$i] = "TMARGE"; 
									$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							} 
							elseif($tcartes[$i] == "TIR") {
									$tcartes[$i] = "TI"; 
								    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIB") {
								    $tcartes[$i] = "TI";
									$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
							}
										
								if(!$res) {
								// insertion dans la table eu_compte
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								$map_compte->save($compte);
									
								}
									
                        }
						
						$tscartes[0]="TSGCP";
						$tscartes[1]="TSCNCSEI";
						$tscartes[2]="TSGCI";
						$tscartes[3]="TSCAPA";
						$tscartes[4]="TSPaNu";
						$tscartes[5]="TSPaR";
						$tscartes[6]="TSFS";
						$tscartes[7]="TSPN";
						$tscartes[8]="TSIN";
						$tscartes[9]="TSIB";
						$tscartes[10]="TSIR";
						$tscartes[11]="TSMARGE";
						$tscartes[12]="TSRE";
						$tscartes[13]="TSGCPPBF";
									
						for($j = 0; $j < count($tscartes); $j++) {		
						    if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS" || $tscartes[$j] == "TSGCPPBF") {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} 
							elseif($tscartes[$j] == "TSMARGE") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							}
							elseif($tscartes[$j] == "TSIR") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
								$tscartes[$j] = "TSI";
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							}
										
							if(!$res)   {
							// insertion dans la table eu_compte
                            $compte->setCode_cat($tscartes[$j])
                                   ->setCode_compte($code_comptets)
                                   ->setCode_membre(null)
								   ->setCode_membre_morale($code)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tscartes[$j])
                                   ->setSolde(0);
								$map_compte->save($compte);
							}			
                        }	
					} 
					else {
				        $db->rollBack();
				        $this->view->message = "Vous devez payer les frais de licence";
				        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
				    }
					
					//Mise à jour de la table morale
                    $m_mapper = new Application_Model_EuAncienMembreMapper();
                    $m = new Application_Model_EuAncienMembre();
                    $rep = $m_mapper->find($_POST["ancien_code_membre"],$m);
                    if ($rep == true) {
                        $m->setEtat_contrat(1)
				          ->setCode_membre($code);
                        $m_mapper->update($m);
                    }
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp!!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre-ancien', 'action' => 'morale'));
			    } catch (Exception $exc) {
			       $db->rollback();
				   $this->view->type_acteur = $_POST["type_acteur"];
                   $this->view->statut_juridique = $_POST["statut_juridique"];
                   $this->view->raison = $_POST["raison_sociale"];
                   $this->view->domaine_activite = $_POST["domaine_activite"];
                   $this->view->site_web = $_POST["site_web"];
                   $this->view->quartier_membre = $_POST["quartier_membre"];
                   $this->view->ville_membre = $_POST["ville_membre"];
                   $this->view->bp = $_POST["bp_membre"];
                   $this->view->tel = $_POST["tel_membre"];
                   $this->view->email = $_POST["email_membre"];
				   $this->view->id_pays = $_POST["id_pays"];
                   $this->view->portable = $_POST["portable_membre"];
                   $this->view->registre = $_POST["num_registre"];
			       $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                   return;
                }
            }
	
	}
	
	public function ncmmmcnpAction() {
	        $request = $this->getRequest();
            $raison_sociale = $request->raison_sociale;
            $this->view->raison_sociale = $raison_sociale;
            if(isset($raison_sociale))
             $this->_helper->layout->disableLayout();
             $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
             $user = $auth->getIdentity();
             $code_agence = $user->code_agence;
             $fs = Util_Utils::getParametre('FS', 'valeur');
             $this->view->fs = $fs;
             $request = $this->getRequest();
             $code_membre = $request->code_membre;
             $this->view->ancien_code_membre = $code_membre;
             $ville = $request->ville_membre;
             $this->view->ville = $ville;
             $tel = $request->tel_membre;
             $this->view->tel = $tel;
	         $qart = $request->quartier_membre;
             $this->view->quartier_membre = $qart;
	         $portable = $request->portable_membre;
             $this->view->portable = $portable;
	         $email = $request->email_membre;
             $this->view->email = $email;
	         $site = $request->site_web;
             $this->view->site_web = $site;
	         $bp = $request->bp_membre;
             $this->view->bp = $bp;
		   
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
		    $table = new Application_Model_DbTable_EuActeur();
			//$select = $table->select();
			//$select->where('code_acteur like ?',$user->code_acteur);
			//$result = $table->fetchAll($select);
			//$findacteur = $result->current();
			//$code_gac_chaine = $findacteur->code_gac_chaine;
			//$selection = $table->select();
			//$selection->where('code_gac_chaine like ?',$code_gac_chaine);
			//$selection->where('type_acteur like ?','gac_surveillance');
			//$resultat = $table->fetchAll($selection);
			//$trouvacteursur = $resultat->current();
			//$acteur = $trouvacteursur->code_acteur;
			
			$acteur = $user->code_acteur;
		   
		    if ($this->getRequest()->isPost()) {
		       
			$date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;  
			$id_type_acteur = "";
			$id_type_creneau = "";
			$id_filiere = "";
			
			$sms_mapper = new Application_Model_EuSmsmoneyMapper();
			$mont_fl = Util_Utils::getParametre('FL','valeur');
			$compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
		    $tcartes = array();
			$tscartes = array();  
			$db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try {
			    $agrement_mapper = new Application_Model_EuAgrementMapper();
			    $agrement        = new Application_Model_EuAgrement();
				$compte = new Application_Model_EuCompte();
                $map_compte = new Application_Model_EuCompteMapper();
				   
				$agrement_filiere  =  $_POST["agrement_filiere"];
                $agrement_acnev    =  $_POST["agrement_acnev"];
                $agrement_technopole =  $_POST["agrement_technopole"];
				$code_fl =  $_POST["code_fl"];
				$code_agence = $user->code_agence;
				$fs = Util_Utils::getParametre('FS', 'valeur');
				   
				    //insertion dans la table membremorale des information du nouveau membre
                    $membre = new Application_Model_EuMembreMorale();
                    $mapper = new Application_Model_EuMembreMoraleMapper();
				    $membre1 = new Application_Model_EuMembreMorale();
                    $mapper1 = new Application_Model_EuMembreMoraleMapper();
                    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                      $code = $code_agence . '0000001' . 'M';
                    } else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'M';
                    }
				   
				    //insertion dans la table eu_operation
                    $mapper_op = new Application_Model_EuOperationMapper();
                    $compteur = $mapper_op->findConuter() + 1;
						
				    $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				    $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				    $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
				   
				    // verification agrement filiere
				    if($trouveagrementf != false) {
				      $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
					  $id_type_creneau = $agrement->getId_type_creneau();
					  $id_type_acteur =  $agrement->getId_type_acteur();
					  $id_filiere =  $agrement->getId_filiere();
					  
				      $agrement->setCode_membre_morale($code);
				      $agrement_mapper->update($agrement);
					  //$resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
					  
					  $membre->setId_filiere($id_filiere);
					  $membre->setCode_membre_morale($code);
                      $membre->setCode_type_acteur($_POST["type_acteur"]);
                      $membre->setCode_statut($_POST["statut_juridique"]);
                      $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
					  $membre->setId_pays($_POST["id_pays"]);
                      $membre->setNum_registre_membre($_POST["num_registre"]);
                      $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                      $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                      $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                      $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                      $membre->setBp_membre($_POST["bp_membre"]);
                      $membre->setTel_membre($_POST["tel_membre"]);
                      $membre->setEmail_membre($_POST["email_membre"]);
                      $membre->setPortable_membre($_POST["portable_membre"]);
                      $membre->setId_utilisateur($utilisateur);
                      $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                      $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                      $membre->setCode_agence($code_agence);
                      $membre->setCodesecret(md5($_POST["codesecret"]));
                      $membre->setAuto_enroler('O');
					  $membre->setEtat_membre('A');
				      $mapper->save($membre);
					  
					  
					  // eu_acteurs_creneau
					  $cm = new Application_Model_EuActeurCreneauMapper();
                      $acren = new Application_Model_EuActeurCreneau();
							
					  $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                      $acren->setCode_membre($code);
					  $acren->setId_type_acteur($id_type_acteur);
					  
					  //$acren->setCode_activite(null);
                      $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                      $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                      $acren->setId_utilisateur($utilisateur);
					  $acren->setGroupe($groupe);
					  $acren->setCode_creneau(null);
                      $acren->setCode_gac_filiere(null);
                      $acren->setCode_gac(null);
							
							
					  $code_zone = $user->code_zone;
			          $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                      if ($code_acteur == null) {
                        $code_acteur = 'A' . $code_zone . '0001';
                      } else {
                        $num_ordre = substr($code_acteur, -4);
                        $num_ordre++;
                        $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                      }
						
					  $acren->setCode_acteur($code_acteur);
					  $acren->setId_filiere($id_filiere);
					  $cm->save($acren);	
							
				      // insertion dans la table eu_operation
                      Util_Utils::addOperation($compteur,null,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
					   
					  //insertion dans la table eu_representation
					    $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
					    $rep->setCode_membre_morale($code)
                            ->setCode_membre($_POST['code_rep'])
                            ->setTitre("Representant")
						    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						    ->setId_utilisateur($user->id_utilisateur)
						    ->setEtat('inside');
                        $rep_mapper->save($rep);
						
				      //insertion dans la table eu_compte_bancaire
                      $cpte = $_POST['cpteur'];
                      $i = 1;
                      $cb_mapper = new Application_Model_EuCompteBancaireMapper();
					  $id_compte = $cb_mapper->findConuter() + 1;
                      $cb = new Application_Model_EuCompteBancaire();
                      while ($i <= $cpte) {
                        if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                            $cb->setId_compte($id_compte)
							  ->setCode_banque($_POST['code_banque' . $i])
                              ->setCode_membre_morale($code)
						      ->setCode_membre(null)
                              ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                            $cb_mapper->save($cb);
                            }
                            $i++;
                        }
				    } else {
				      $db->rollBack();
				      $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
				    }
				    // verification agrement acnev
				    if($trouveagrementacnev != false) {
				     $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				     $agrement->setCode_membre_morale($code);
				     $agrement_mapper->update($agrement);			
				    } else {
				     $db->rollBack();
				     $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				     $this->view->type_acteur = $_POST["type_acteur"];
                     $this->view->statut_juridique = $_POST["statut_juridique"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre"];
                     return;
				    }
					
					// verification agrement technopole
					if($trouveagrementtechno != false) {
				      $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
				      $agrement_mapper->update($agrement);			
				    } else {
				      $db->rollBack();
				      $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
				   } 
				   
				    $filiere =  new Application_Model_EuFiliere();
				    $map_filiere = new Application_Model_EuFiliereMapper();
				    $find_filiere = $map_filiere->find($id_filiere,$filiere);
				   
				    $t_acteur = new Application_Model_DbTable_EuActeur();
				    $c_acteur = new Application_Model_EuActeur();
				    $table = new Application_Model_DbTable_EuActeur();
                    $select = $table->select();
				    $select->where('code_acteur like ?', $acteur);
				    $resultSet = $table->fetchAll($select);
				    $ligneacteur = $resultSet->current();
					// insertion dans la table eu_acteur
				    $count = $c_acteur->findConuter() + 1;
                    $c_acteur->setId_acteur($count)
                            ->setCode_acteur(null)
							->setCode_division($filiere->getCode_division())
                            ->setCode_membre($code)
                            ->setId_utilisateur($utilisateur)
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
							
					$c_acteur->setCode_source_create($ligneacteur->code_source_create);
					$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					$c_acteur->setId_pays($ligneacteur->id_pays);
					$c_acteur->setId_region($ligneacteur->id_region);
					$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);

					
                    if($id_type_acteur == 3) {
                        $c_acteur->setCode_activite('detaillant');	
                    } elseif($id_type_acteur == 2) {
                        $c_acteur->setCode_activite('semi-grossiste');  
                    } elseif($id_type_acteur == 1) {
                        $c_acteur->setCode_activite('grossiste'); 
                    }
                    $c_acteur->setType_acteur('DSMS');
                    $c_acteur->setCode_gac_chaine($acteur);
                    $t_acteur->insert($c_acteur->toArray());
					  
					//R?cup?ration de la prk nr
                    $param = new Application_Model_EuParametresMapper();
                    $par = new Application_Model_EuParametres();
                    $prc = 0;
                    $par_prc = $param->find('prc', 'nr', $par);
                    if ($par_prc == true) {
                        $prc = $par->getMontant();
                    }
					
                    // insertion dans la table eu_tegc					
					$te_mapper = new Application_Model_EuTegcMapper();
                    $te = new Application_Model_EuTegc();
                    $code_te = 'TEGCP' .$id_filiere. $code;
                    $find_te = $te_mapper->find($code_te,$te);
                        if ($find_te == false) {
                         $te->setCode_tegc($code_te)
                            ->setId_filiere($id_filiere)
                            ->setMdv($prc)
                            ->setCode_membre($code)
                            ->setMontant(0)
							->setMontant_utilise(0)
							->setSolde_tegc(0);
                          $te_mapper->save($te);
                        } else {
                          $te->setId_filiere($id_filiere);
                          $te->setMdv($prc);
                          $te_mapper->update($te);
                        }
					      
					// table eu_utilisateur
					$user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                    if($id_type_acteur == 3) {
                        $userin->setCode_groupe('ose_detaillant');
                        $userin->setCode_gac_filiere('ose_detaillant');
					    $userin->setCode_groupe_create('ose_detaillant');
                    } elseif($id_type_acteur == 2) {
                        $userin->setCode_groupe('ose_semi_grossiste');
					    $userin->setCode_groupe_create('ose_semi_grossiste');
                        $userin->setCode_gac_filiere(null);
                    } elseif($id_type_acteur == 1) {
                        $userin->setCode_groupe('ose_grossiste');
					    $userin->setCode_groupe_create('ose_grossiste');
                        $userin->setCode_gac_filiere(null);
                    }
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
				    $userin->setCode_acteur($acteur);
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
					$contrat->setId_type_contrat(3);
                    $contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
					$tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
				    $tafl = new Application_Model_DbTable_EuAncienFl();
                    $afl = new Application_Model_EuAncienFl();
                    $code_fl = 'FL-'.$_POST["ancien_code_membre"];
                    $result = $tafl->find($code_fl);
					
					//$tcartes = array();
			        //$tscartes = array();
					
					if (count($result) > 0) {
					    $code_afl = 'FL-'.$code;
					    $mont_fl = Util_Utils::getParametre('FL','valeur'); 
					    $fl->setCode_fl($code_afl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode(null);
                        $tfl->insert($fl->toArray());
						
						// insertion dans la table eu_compte
						$tcartes[0]="TPAGCP";
						$tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
						$tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
						$tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";			
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                          $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'NR';
									      $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA"  || $tcartes[$i] == "TRE") {
                                          $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
										  $type_carte = 'NN';
									      $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
										    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIN") {
										    $tcartes[$i] = "TI"; 
										    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_compte,$compte);
							} 
							elseif($tcartes[$i] == "TMARGE") {
								$tcartes[$i] = "TMARGE"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							}
							elseif($tcartes[$i] == "TIR") {
										    $tcartes[$i] = "TI"; 
										    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NR';
									        $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIB") {
										    $tcartes[$i] = "TI";
										    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_compte,$compte);
							}
										
							if(!$res) {
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								$map_compte->save($compte);		
							}
									
                        }
									
						$tscartes[0]="TSGCP";
						$tscartes[1]="TSCNCSEI";
						$tscartes[2]="TSGCI";
						$tscartes[3]="TSCAPA";
						$tscartes[4]="TSPaNu";
						$tscartes[5]="TSPaR";
						$tscartes[6]="TSFS";
						$tscartes[7]="TSPN";
						$tscartes[8]="TSIN";
						$tscartes[9]="TSIB";
					    $tscartes[10]="TSIR";
						$tscartes[11]="TSMARGE";
						$tscartes[12]="TSRE";
									
						for($j = 0; $j < count($tscartes); $j++) {		
							if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                          $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'NR';
									      $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
							              $tscartes[$j] = "TSMARGE";
                                          $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
										  $type_carte = 'NN';
									      $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
										  || $tscartes[$j] == "TSFS") {
										    $tscartes[$j] = "TSMARGE";
										    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
										    $tscartes[$j] = "TSI"; 
										    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_comptets,$compte);
							} 
							elseif($tscartes[$j] == "TSMARGE") {
										    $tscartes[$j] = "TSMARGE"; 
										    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_comptets,$compte);
							}
							elseif($tscartes[$j] == "TSIR") {
										    $tscartes[$j] = "TSI"; 
										    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NR';
									        $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
										    $tscartes[$j] = "TSI";
										    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_comptets,$compte);
							}
										
							if(!$res) {
                                $compte->setCode_cat($tscartes[$j])
                                       ->setCode_compte($code_comptets)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tscartes[$j])
                                       ->setSolde(0);
							    $map_compte->save($compte);
						    }
									
                        }	
					
					} elseif($code_fl != "") {
					    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
					    if ($sms_fl == null) {
                           $db->rollback();
                           $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
						   $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                        }
						
						if($sms_fl->getMotif() != 'FL') {
					      $db->rollBack();
						  $this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
						  $this->view->type_acteur = $_POST["type_acteur"];
                          $this->view->statut_juridique = $_POST["statut_juridique"];
                          $this->view->raison = $_POST["raison_sociale"];
                          $this->view->domaine_activite = $_POST["domaine_activite"];
                          $this->view->site_web = $_POST["site_web"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          $this->view->registre = $_POST["num_registre"];
                          return;    
					    }
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						$compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,null,$code, null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
												
						$sms_fl->setDestAccount_Consumed('FL-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
						
						$tcartes[0]="TPAGCP";
					    $tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
					    $tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
					    $tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
						    } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA"  || $tcartes[$i] == "TRE") {
                                    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
								    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIN") {
									$tcartes[$i] = "TI"; 
									$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							} 
							elseif($tcartes[$i] == "TMARGE") {
									$tcartes[$i] = "TMARGE"; 
									$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
							}
							elseif($tcartes[$i] == "TIR") {
									$tcartes[$i] = "TI"; 
								    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIB") {
								    $tcartes[$i] = "TI";
									$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
							}
										
								if(!$res) {
								// insertion dans la table eu_compte
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								$map_compte->save($compte);
									
								}
									
                        }
						
						$tscartes[0]="TSGCP";
						$tscartes[1]="TSCNCSEI";
						$tscartes[2]="TSGCI";
						$tscartes[3]="TSCAPA";
						$tscartes[4]="TSPaNu";
						$tscartes[5]="TSPaR";
						$tscartes[6]="TSFS";
						$tscartes[7]="TSPN";
						$tscartes[8]="TSIN";
						$tscartes[9]="TSIB";
						$tscartes[10]="TSIR";
						$tscartes[11]="TSMARGE";
						$tscartes[12]="TSRE";
									
						for($j = 0; $j < count($tscartes); $j++) {		
						    if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} 
							elseif($tscartes[$j] == "TSMARGE") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							}
							elseif($tscartes[$j] == "TSIR") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
								$tscartes[$j] = "TSI";
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							}
										
							if(!$res)   {
							// insertion dans la table eu_compte
                            $compte->setCode_cat($tscartes[$j])
                                   ->setCode_compte($code_comptets)
                                   ->setCode_membre(null)
								   ->setCode_membre_morale($code)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tscartes[$j])
                                   ->setSolde(0);
								$map_compte->save($compte);
							}			
                        }	
					}
					else  {
				        $db->rollBack();
				        $this->view->message = "Vous devez payer les frais de licence";
				        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
				    }
					
					
					
					
					//Mise à jour de la table morale
                    $m_mapper = new Application_Model_EuAncienMembreMapper();
                    $m = new Application_Model_EuAncienMembre();
                    $rep = $m_mapper->find($_POST["ancien_code_membre"],$m);
                    if ($rep == true) {
                        $m->setEtat_contrat(1)
				          ->setCode_membre($code);
                        $m_mapper->update($m);
                    }
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp!!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre-ancien', 'action' => 'morale'));
			  } catch (Exception $exc) {
			       $db->rollback();
				   $this->view->type_acteur = $_POST["type_acteur"];
                   $this->view->statut_juridique = $_POST["statut_juridique"];
                   $this->view->raison = $_POST["raison_sociale"];
                   $this->view->domaine_activite = $_POST["domaine_activite"];
                   $this->view->site_web = $_POST["site_web"];
                   $this->view->quartier_membre = $_POST["quartier_membre"];
                   $this->view->ville_membre = $_POST["ville_membre"];
                   $this->view->bp = $_POST["bp_membre"];
                   $this->view->tel = $_POST["tel_membre"];
                   $this->view->email = $_POST["email_membre"];
				   $this->view->id_pays = $_POST["id_pays"];
                   $this->view->portable = $_POST["portable_membre"];
                   $this->view->registre = $_POST["num_registre"];
			       $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                   return;
              }
           }	
	}
	
	
	public  function ncmmoseAction()  {
	
	       $request = $this->getRequest();
           $nomm = $request->nomm;
           $this->view->nomm = $nomm;
           if(isset($nomm))
           $this->_helper->layout->disableLayout();
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $code_agence = $user->code_agence;
           $fs = Util_Utils::getParametre('FS', 'valeur');
           $this->view->fs = $fs;
           $request = $this->getRequest();
           $numident = $request->numident;
           $this->view->numident = $numident;
           $ville = $request->ville;
           $this->view->ville = $ville;
           $tel = $request->tel;
           $this->view->tel = $tel;
	       $qart = $request->qart;
           $this->view->quartier_membre = $qart;
	       $portable = $request->portable;
           $this->view->portable = $portable;
	       $email = $request->email;
           $this->view->email = $email;
	       $site = $request->site;
           $this->view->site_web = $site;
	       $bp = $request->bp;
           $this->view->bp = $bp;
		   
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
		    $table = new Application_Model_DbTable_EuActeur();
			//$select = $table->select();
			//$select->where('code_acteur like ?',$user->code_acteur);
			//$result = $table->fetchAll($select);
			//$findacteur = $result->current();
			//$code_gac_chaine = $findacteur->code_gac_chaine;
			//$selection = $table->select();
			//$selection->where('code_gac_chaine like ?',$code_gac_chaine);
			//$selection->where('type_acteur like ?','gac_surveillance');
			//$resultat = $table->fetchAll($selection);
			//$trouvacteursur = $resultat->current();
			//$acteur = $trouvacteursur->code_acteur;
			   
			$acteur = $user->code_acteur;
		   
		    if ($this->getRequest()->isPost()) {  
			   $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
			  
			   $id_type_acteur = "";
			   $id_type_creneau = "";
			   $id_filiere = "";
			   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			   $mont_fl = Util_Utils::getParametre('FL','valeur');
			   $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
		       $tcartes = array();
			   $tscartes = array();
			   
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {
			       $agrement_mapper = new Application_Model_EuAgrementMapper();
			       $agrement        = new Application_Model_EuAgrement();
				   
				   $agrement_filiere  =  $_POST["agrement_filiere"];
                   $agrement_acnev    =  $_POST["agrement_acnev"];
                   $agrement_technopole =  $_POST["agrement_technopole"];
				   $code_fl =  $_POST["code_fl"];
				   
				   //insertion dans la table membremorale des information du nouveau membre
                    $membre = new Application_Model_EuMembreMorale();
                    $mapper = new Application_Model_EuMembreMoraleMapper();
				    $membre1 = new Application_Model_EuMembreMorale();
                    $mapper1 = new Application_Model_EuMembreMoraleMapper();
                    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                      $code = $code_agence . '0000001' . 'M';
                    } else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'M';
                    }
				   
				    //insertion dans la table eu_operation
                    $mapper_op = new Application_Model_EuOperationMapper();
                    $compteur = $mapper_op->findConuter() + 1;
						
				    $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				    $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				    $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
				   
				    // verification agrement filiere
				    if($trouveagrementf != false) {
				      $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
					  
					  $id_type_creneau = $agrement->getId_type_creneau();
					  $id_type_acteur = $agrement->getId_type_acteur();
					  $id_filiere = $agrement->getId_filiere();
					  
				      $agrement_mapper->update($agrement);
					  
					  //$resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
					  
					  // insertion dans la table eu_membre
					  $membre->setId_filiere($id_filiere);
					  $membre->setCode_membre_morale($code);
                      $membre->setCode_type_acteur($_POST["type_acteur"]);
                      $membre->setCode_statut($_POST["statut_juridique"]);
                      $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
					  $membre->setId_pays($_POST["id_pays"]);
                      $membre->setNum_registre_membre($_POST["num_registre"]);
                      $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                      $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                      $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                      $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                      $membre->setBp_membre($_POST["bp_membre"]);
                      $membre->setTel_membre($_POST["tel_membre"]);
                      $membre->setEmail_membre($_POST["email_membre"]);
                      $membre->setPortable_membre($_POST["portable_membre"]);
                      $membre->setId_utilisateur($utilisateur);
                      $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                      $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                      $membre->setCode_agence($code_agence);
                      $membre->setCodesecret(md5($_POST["codesecret"]));
                      $membre->setAuto_enroler('O');
					  $membre->setEtat_membre('A');
				      $mapper->save($membre);
					  
					  
					  // insertion dans la table  eu_acteurs_creneau
					  $cm = new Application_Model_EuActeurCreneauMapper();
                      $acren = new Application_Model_EuActeurCreneau();
							
					  $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                      $acren->setCode_membre($code);
					  $acren->setId_type_acteur($id_type_acteur);
					  
					  
					  //$acren->setCode_activite(null);
                      $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                      $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                      $acren->setId_utilisateur($utilisateur);
					  $acren->setGroupe($groupe);
					  $acren->setCode_creneau(null);
                      $acren->setCode_gac_filiere(null);
                      $acren->setCode_gac(null);
							
							
					  $code_zone = $user->code_zone;
			          $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                      if ($code_acteur == null) {
                        $code_acteur = 'A' . $code_zone . '0001';
                      } else {
                        $num_ordre = substr($code_acteur, -4);
                        $num_ordre++;
                        $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                      }
						
					  $acren->setCode_acteur($code_acteur);
					  $acren->setId_filiere($id_filiere);
					  $cm->save($acren);	
					  $fs = Util_Utils::getParametre('FS','valeur');	
				      // insertion dans la table eu_operation
                      Util_Utils::addOperation($compteur,null,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'),$user->id_utilisateur);
					   
					  //insertion dans la table eu_representation
					    $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
					    $rep->setCode_membre_morale($code)
                            ->setCode_membre($_POST['code_rep'])
                            ->setTitre("Representant")
						    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						    ->setId_utilisateur($user->id_utilisateur)
						    ->setEtat('inside');
                        $rep_mapper->save($rep);
						
				      //insertion dans la table eu_compte_bancaire
                      $cpte = $_POST['cpteur'];
                      $i = 1;
                      $cb_mapper = new Application_Model_EuCompteBancaireMapper();
					  $id_compte = $cb_mapper->findConuter() + 1;
                      $cb = new Application_Model_EuCompteBancaire();
                      while ($i <= $cpte) {
                        if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                           $cb->setId_compte($id_compte)
							  ->setCode_banque($_POST['code_banque' . $i])
                              ->setCode_membre_morale($code)
						      ->setCode_membre(null)
                              ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                           $cb_mapper->save($cb);
                         }
                           $i++;
                        }
				    } else {
				       $db->rollBack();
				       $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
				    }
				   
				   // verification agrement acnev
				    if($trouveagrementacnev != false) {
				     $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				     $agrement->setCode_membre_morale($code);
				     $agrement_mapper->update($agrement);			
				    } else {
				     $db->rollBack();
				     $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				     $this->view->type_acteur = $_POST["type_acteur"];
                     $this->view->statut_juridique = $_POST["statut_juridique"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre"];
                     return;
				    }
					
					// verification agrement technopole
					if($trouveagrementtechno != false) {
				      $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
				      $agrement_mapper->update($agrement);			
				    } else {
				      $db->rollBack();
				      $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
				    } 
				   
				    $filiere =  new Application_Model_EuFiliere();
				    $map_filiere = new Application_Model_EuFiliereMapper();
				    $find_filiere = $map_filiere->find($id_filiere,$filiere);
				    $t_acteur = new Application_Model_DbTable_EuActeur();
				    $c_acteur = new Application_Model_EuActeur();
				    $table = new Application_Model_DbTable_EuActeur();
                    $select = $table->select();
				    $select->where('code_acteur like ?', $acteur);
				    $resultSet = $table->fetchAll($select);
				    $ligneacteur = $resultSet->current();
					// insertion dans la table eu_acteur
				    $count = $c_acteur->findConuter() + 1;
                    $c_acteur->setId_acteur($count)
                             ->setCode_acteur(null)
							 ->setCode_division($filiere->getCode_division())
                             ->setCode_membre($code)
                             ->setId_utilisateur($utilisateur)
                             ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
							
                    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
					$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					$c_acteur->setId_pays($ligneacteur->id_pays);
					$c_acteur->setId_region($ligneacteur->id_region);
					$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					  					

					
                    if($id_type_acteur == 3) {
                      $c_acteur->setCode_activite('detaillant');  
                    } elseif($id_type_acteur == 2) {
                      $c_acteur->setCode_activite('semi-grossiste'); 
                    } elseif($id_type_acteur == 1){
                      $c_acteur->setCode_activite('grossiste');
                    }
                    $c_acteur->setType_acteur('DSMS');
                    $c_acteur->setCode_gac_chaine($acteur);
                    $t_acteur->insert($c_acteur->toArray());
					
					//R?cup?ration de la prk nr
                    $param = new Application_Model_EuParametresMapper();
                    $par = new Application_Model_EuParametres();
                    $prc = 0;
                    $par_prc = $param->find('prc', 'nr', $par);
                    if ($par_prc == true) {
                        $prc = $par->getMontant();
                    }
					
                     // insertion dans la table tegc					
					$te_mapper = new Application_Model_EuTegcMapper();
                    $te = new Application_Model_EuTegc();
                    $code_te = 'TEGCP' .$id_filiere. $code;
                    $find_te = $te_mapper->find($code_te,$te);
                    if ($find_te == false) {
                        $te->setCode_tegc($code_te)
                           ->setId_filiere($id_filiere)
                           ->setMdv($prc)
                           ->setCode_membre($code)
                           ->setMontant(0)
						   ->setMontant_utilise(0)
						   ->setSolde_tegc(0);
                        $te_mapper->save($te);
                    } else {
                        $te->setId_filiere($id_filiere);
                        $te->setMdv($prc);
                        $te_mapper->update($te);
                    }
					      
					// table eu_utilisateur
					$user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                    if($id_type_acteur == 3) {
                          $userin->setCode_groupe('ose_detaillant');
                          $userin->setCode_gac_filiere('ose_detaillant');
						  $userin->setCode_groupe_create('ose_detaillant');
                    } elseif($id_type_acteur == 2) {
                          $userin->setCode_groupe('ose_semi_grossiste');
                          $userin->setCode_gac_filiere(null);
						  $userin->setCode_groupe_create('ose_semi_grossiste');
                    } elseif($id_type_acteur == 1) {
                        $userin->setCode_groupe('ose_grossiste');
                        $userin->setCode_gac_filiere(null);
						$userin->setCode_groupe_create('ose_grossiste');
                    }
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
                    
				    $userin->setCode_acteur($acteur);
					
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
					$contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					  					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
					//Mise à jour de la table morale
                    $m_mapper = new Application_Model_MoraleMapper();
                    $m = new Application_Model_Morale();
                    $rep = $m_mapper->find($_POST["numident"],$m);
                    if ($rep == true) {
                        $m->setEtat_contrat(1)
				         ->setCode_membre($code);
                        $m_mapper->update($m);
                    }
					
					if($code_fl != "") {
					
					    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
					    if ($sms_fl == null) {
                           $db->rollback();
                           $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
						   $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                        }
						
						if($sms_fl->getMotif() != 'FL') {
					      $db->rollBack();
						  $this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
						  $this->view->type_acteur = $_POST["type_acteur"];
                          $this->view->statut_juridique = $_POST["statut_juridique"];
                          $this->view->raison = $_POST["raison_sociale"];
                          $this->view->domaine_activite = $_POST["domaine_activite"];
                          $this->view->site_web = $_POST["site_web"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          $this->view->registre = $_POST["num_registre"];
                          return;    
					    }
						
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
						
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						$compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,null,$code, null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
												
						$sms_fl->setDestAccount_Consumed('FL-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
						
						$tcartes[0]="TPAGCP";
					    $tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
					    $tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
					    $tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";
									
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_compte,$compte);
						    } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
							    $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
								$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIN") {
								$tcartes[$i] = "TI"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							} 
							elseif($tcartes[$i] == "TMARGE") {
								$tcartes[$i] = "TMARGE"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							}
							elseif($tcartes[$i] == "TIR") {
								$tcartes[$i] = "TI"; 
								$code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIB") {
								$tcartes[$i] = "TI";
								$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_compte,$compte);
							}
										
							if(!$res) {
								// insertion dans la table eu_compte
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								$map_compte->save($compte);		
							}
									
                        }
						
						$tscartes[0]="TSGCP";
						$tscartes[1]="TSCNCSEI";
						$tscartes[2]="TSGCI";
						$tscartes[3]="TSCAPA";
						$tscartes[4]="TSPaNu";
						$tscartes[5]="TSPaR";
						$tscartes[6]="TSFS";
						$tscartes[7]="TSPN";
						$tscartes[8]="TSIN";
						$tscartes[9]="TSIB";
						$tscartes[10]="TSIR";
						$tscartes[11]="TSMARGE";
						$tscartes[12]="TSRE";
									
						for($j = 0; $j < count($tscartes); $j++) {		
						    if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} 
							elseif($tscartes[$j] == "TSMARGE") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							}
							elseif($tscartes[$j] == "TSIR") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
								$tscartes[$j] = "TSI";
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							}
										
							if(!$res)   {
							// insertion dans la table eu_compte
                            $compte->setCode_cat($tscartes[$j])
                                   ->setCode_compte($code_comptets)
                                   ->setCode_membre(null)
								   ->setCode_membre_morale($code)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tscartes[$j])
                                   ->setSolde(0);
								$map_compte->save($compte);
							}			
                        }	
					}
					
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp!!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre-ancien', 'action' => 'morale'));
			    } catch (Exception $exc) {
			        $db->rollback();
				    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
				    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
			        $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }
            }
	}
	
	public function ncmmpbfAction() {
	       $request = $this->getRequest();
           $nomm = $request->nomm;
           $this->view->nomm = $nomm;
           if(isset($nomm))
           $this->_helper->layout->disableLayout();
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $code_agence = $user->code_agence;
           $fs = Util_Utils::getParametre('FS', 'valeur');
           $this->view->fs = $fs;
           $request = $this->getRequest();
           $numident = $request->numident;
           $this->view->numident = $numident;
           $ville = $request->ville;
           $this->view->ville = $ville;
           $tel = $request->tel;
           $this->view->tel = $tel;
	       $qart = $request->qart;
           $this->view->quartier_membre = $qart;
	       $portable = $request->portable;
           $this->view->portable = $portable;
	       $email = $request->email;
           $this->view->email = $email;
	       $site = $request->site;
           $this->view->site_web = $site;
	       $bp = $request->bp;
           $this->view->bp = $bp;
		   
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
		    $table = new Application_Model_DbTable_EuActeur();
			$select = $table->select();
			$select->where('code_acteur like ?',$user->code_acteur);
			$result = $table->fetchAll($select);
			$findacteur = $result->current();
			$code_gac_chaine = $findacteur->code_gac_chaine;
			$selection = $table->select();
			$selection->where('code_gac_chaine like ?',$code_gac_chaine);
			$selection->where('type_acteur like ?','gac_surveillance');
			$resultat = $table->fetchAll($selection);
			$trouvacteursur = $resultat->current();
			$acteur = $trouvacteursur->code_acteur;   
			//$acteur = $user->code_acteur;
			
			if ($this->getRequest()->isPost()) {
	           $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
			   $id_type_acteur = "";
			   $id_type_creneau = "";
			   $id_filiere = "";
			   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			   $mont_fl = Util_Utils::getParametre('FL','valeur');
			   $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
		       $tcartes = array();
			   $tscartes = array();
			   $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			    try {  
					$agrement_mapper = new Application_Model_EuAgrementMapper();
			        $agrement        = new Application_Model_EuAgrement();
				   
				    $agrement_filiere  =  $_POST["agrement_filiere"];
                    $agrement_acnev    =  $_POST["agrement_acnev"];
                    $agrement_technopole =  $_POST["agrement_technopole"];
					$code_fl = $_POST["code_fl"];
				   
				    //insertion dans la table membremorale des information du nouveau membre
                    $membre = new Application_Model_EuMembreMorale();
                    $mapper = new Application_Model_EuMembreMoraleMapper();
				    $membre1 = new Application_Model_EuMembreMorale();
                    $mapper1 = new Application_Model_EuMembreMoraleMapper();
                    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                      $code = $code_agence . '0000001' . 'M';
                    } else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'M';
                    }
				   
				    //insertion dans la table eu_operation
                    $mapper_op = new Application_Model_EuOperationMapper();
                    $compteur = $mapper_op->findConuter() + 1;
						
				    $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				    $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				    $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
				   
				    // verification agrement filiere
				    if($trouveagrementf != false) {
				      $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
					  
					  $id_type_creneau = $agrement->getId_type_creneau();
					  $id_type_acteur = $agrement->getId_type_acteur();
					  $id_filiere = $agrement->getId_filiere();
					  
				      $agrement_mapper->update($agrement);
					  //$resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
					  
					  // insertion dans la table eu_membre
					  $membre->setId_filiere($id_filiere);
					  $membre->setCode_membre_morale($code);
                      $membre->setCode_type_acteur($_POST["type_acteur"]);
                      $membre->setCode_statut($_POST["statut_juridique"]);
                      $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
					  $membre->setId_pays($_POST["id_pays"]);
                      $membre->setNum_registre_membre($_POST["num_registre"]);
                      $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                      $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                      $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                      $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                      $membre->setBp_membre($_POST["bp_membre"]);
                      $membre->setTel_membre($_POST["tel_membre"]);
                      $membre->setEmail_membre($_POST["email_membre"]);
                      $membre->setPortable_membre($_POST["portable_membre"]);
                      $membre->setId_utilisateur($utilisateur);
                      $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                      $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                      $membre->setCode_agence($code_agence);
                      $membre->setCodesecret(md5($_POST["codesecret"]));
                      $membre->setAuto_enroler('O');
					  $membre->setEtat_membre('A');
				      $mapper->save($membre);
					  
					  
					  // eu_acteurs_creneau
					  $cm = new Application_Model_EuActeurCreneauMapper();
                      $acren = new Application_Model_EuActeurCreneau();
							
					  $acren->setNom_acteur($_POST["raison_sociale"]);
                      $acren->setCode_membre($code);
					  $acren->setId_type_acteur($id_type_acteur);
					  
					  
					  //$acren->setCode_activite(null);
                      $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                      $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                      $acren->setId_utilisateur($utilisateur);
					  $acren->setGroupe($groupe);
					  $acren->setCode_creneau($id_type_creneau);
                      $acren->setCode_gac_filiere(null);
                      $acren->setCode_gac(null);
							
							
					  $code_zone = $user->code_zone;
			          $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                      if ($code_acteur == null) {
                        $code_acteur = 'A' . $code_zone . '0001';
                      } else {
                        $num_ordre = substr($code_acteur, -4);
                        $num_ordre++;
                        $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                      }
						
					  $acren->setCode_acteur($code_acteur);
					  $acren->setId_filiere($id_filiere);
					  $cm->save($acren);	
					  $fs = Util_Utils::getParametre('FS','valeur');	
				      // insertion dans la table eu_operation
                      Util_Utils::addOperation($compteur,null,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
					   
					  //insertion dans la table eu_representation
					    $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
					    $rep->setCode_membre_morale($code)
                            ->setCode_membre($_POST['code_rep'])
                            ->setTitre("Representant")
						    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						    ->setId_utilisateur($user->id_utilisateur)
						    ->setEtat('inside');
                        $rep_mapper->save($rep);
						
				      //insertion dans la table eu_compte_bancaire
                      $cpte = $_POST['cpteur'];
                      $i = 1;
                      $cb_mapper = new Application_Model_EuCompteBancaireMapper();
					  $id_compte = $cb_mapper->findConuter() + 1;
                      $cb = new Application_Model_EuCompteBancaire();
                      while ($i <= $cpte) {
                        if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                            $cb->setId_compte($id_compte)
							  ->setCode_banque($_POST['code_banque' . $i])
                              ->setCode_membre_morale($code)
						      ->setCode_membre(null)
                              ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                            $cb_mapper->save($cb);
                        }
                           $i++;
                      }
				    } else {
				     $db->rollBack();
				     $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				     $this->view->type_acteur = $_POST["type_acteur"];
                     $this->view->statut_juridique = $_POST["statut_juridique"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre"];
                     return;
				    }
				   
				   // verification agrement acnev
				    if($trouveagrementacnev != false) {
				     $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				     $agrement->setCode_membre_morale($code);
				     $agrement_mapper->update($agrement);			
				    } else {
				     $db->rollBack();
				     $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				     $this->view->type_acteur = $_POST["type_acteur"];
                     $this->view->statut_juridique = $_POST["statut_juridique"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre"];
                     return;
				    }
					
					// verification agrement technopole
					if($trouveagrementtechno != false) {
				      $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
				      $agrement_mapper->update($agrement);			
				    } else {
				      $db->rollBack();
				      $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
				    } 
				   
				   $filiere =  new Application_Model_EuFiliere();
				   $map_filiere = new Application_Model_EuFiliereMapper();
				   $find_filiere = $map_filiere->find($id_filiere,$filiere);
				   $t_acteur = new Application_Model_DbTable_EuActeur();
				   $c_acteur = new Application_Model_EuActeur();
				   $table = new Application_Model_DbTable_EuActeur();
                   $select = $table->select();
				   $select->where('code_acteur like ?', $acteur);
				   $resultSet = $table->fetchAll($select);
				   $ligneacteur = $resultSet->current();
				    // insertion dans la table eu_acteur
				    $count = $c_acteur->findConuter() + 1;
                    $c_acteur->setId_acteur($count)
                            ->setCode_acteur(null)
							->setCode_division($filiere->getCode_division())
                            ->setCode_membre($code)
                            ->setId_utilisateur($utilisateur)
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					$c_acteur->setCode_source_create($ligneacteur->code_source_create);
					$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					$c_acteur->setId_pays($ligneacteur->id_pays);
					$c_acteur->setId_region($ligneacteur->id_region);
					$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);		
                    
					if($id_type_acteur == 3) {
                      $c_acteur->setCode_activite('detaillant');  
                    } elseif($id_type_acteur == 2) {
                      $c_acteur->setCode_activite('semi-grossiste');
                    } elseif($id_type_acteur == 1){
                      $c_acteur->setCode_activite('grossiste');
                    }
                      
					$c_acteur->setType_acteur('PBF');
                    $c_acteur->setCode_gac_chaine($acteur);
                    $t_acteur->insert($c_acteur->toArray());
					  //R?cup?ration de la prk nr
                    $param = new Application_Model_EuParametresMapper();
                    $par = new Application_Model_EuParametres();
                    $prc = 0;
                    $par_prc = $param->find('prc', 'nr', $par);
                    if ($par_prc == true) {
                        $prc = $par->getMontant();
                    }
					
                    // insertion dans la table eu_tegc					
					$te_mapper = new Application_Model_EuTegcMapper();
                    $te = new Application_Model_EuTegc();
                    $code_te = 'TEGCP' .$id_filiere. $code;
                    $find_te = $te_mapper->find($code_te,$te);
                    if ($find_te == false) {
                        $te->setCode_tegc($code_te)
                            ->setId_filiere($id_filiere)
                            ->setMdv($prc)
                            ->setCode_membre($code)
                            ->setMontant(0)
							->setMontant_utilise(0)
							->setSolde_tegc(0);
                        $te_mapper->save($te);
                    } else {
                        $te->setId_filiere($id_filiere);
                        $te->setMdv($prc);
                        $te_mapper->update($te);
                    }
					      
					// table eu_utilisateur
					$user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                    if($id_type_acteur == 3) {
                        $userin->setCode_groupe('pbf_detaillant');
                        $userin->setCode_gac_filiere('pbf_detaillant');
						$userin->setCode_groupe_create('pbf_detaillant');
                    } elseif($id_type_acteur == 2) {
                        $userin->setCode_groupe('pbf_semi_grossiste');
                        $userin->setCode_gac_filiere(null);
						$userin->setCode_groupe_create('pbf_semi_grossiste');
                    } elseif($id_type_acteur == 1) {
                          $userin->setCode_groupe('pbf_grossiste');
                          $userin->setCode_gac_filiere(null);
						  $userin->setCode_groupe_create('pbf_grossiste');
                    }
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
                    
				    $userin->setCode_acteur($acteur);
					
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
					$contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					  					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
					//Mise à jour de la table morale
                    $m_mapper = new Application_Model_MoraleMapper();
                    $m = new Application_Model_Morale();
                    $rep = $m_mapper->find($_POST["numident"],$m);
                    if ($rep == true) {
                        $m->setEtat_contrat(1)
				         ->setCode_membre($code);
                        $m_mapper->update($m);
                    }
					
					if($code_fl != "") {
					    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
					    if ($sms_fl == null) {
                           $db->rollback();
                           $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
						   $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                        }
						
						if($sms_fl->getMotif() != 'FL') {
					      $db->rollBack();
						  $this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
						  $this->view->type_acteur = $_POST["type_acteur"];
                          $this->view->statut_juridique = $_POST["statut_juridique"];
                          $this->view->raison = $_POST["raison_sociale"];
                          $this->view->domaine_activite = $_POST["domaine_activite"];
                          $this->view->site_web = $_POST["site_web"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          $this->view->registre = $_POST["num_registre"];
                          return;    
					    }
						
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
						
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                            $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						$compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,null,$code, null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),$user->id_utilisateur);
												
						$sms_fl->setDestAccount_Consumed('FL-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
						
						$tcartes[0]="TPAGCP";
					    $tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
					    $tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
					    $tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";
						$tcartes[15]="TPAGCPPBF";
									
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_compte,$compte);
						    } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS" || $tcartes[$i] == "TPAGCPPBF") {
								$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIN") {
								$tcartes[$i] = "TI"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							} 
							elseif($tcartes[$i] == "TMARGE") {
								$tcartes[$i] = "TMARGE"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							}
							elseif($tcartes[$i] == "TIR") {
								$tcartes[$i] = "TI"; 
								$code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIB") {
								$tcartes[$i] = "TI";
							    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_compte,$compte);
							}
										
							if(!$res) {
								// insertion dans la table eu_compte
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								$map_compte->save($compte);		
							}
									
                        }
						
						$tscartes[0]="TSGCP";
						$tscartes[1]="TSCNCSEI";
						$tscartes[2]="TSGCI";
						$tscartes[3]="TSCAPA";
						$tscartes[4]="TSPaNu";
						$tscartes[5]="TSPaR";
						$tscartes[6]="TSFS";
						$tscartes[7]="TSPN";
						$tscartes[8]="TSIN";
						$tscartes[9]="TSIB";
						$tscartes[10]="TSIR";
						$tscartes[11]="TSMARGE";
						$tscartes[12]="TSRE";
						$tscartes[13]="TSGCPPBF";
									
						for($j = 0; $j < count($tscartes); $j++) {		
						    if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS" || $tscartes[$j] == "TSGCPPBF") {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} 
							elseif($tscartes[$j] == "TSMARGE") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							}
							/*elseif($tscartes[$j] == "TSMARGENB") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							}*/
							
							elseif($tscartes[$j] == "TSIR") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
								$tscartes[$j] = "TSI";
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							}
										
							if(!$res)   {
							// insertion dans la table eu_compte
                            $compte->setCode_cat($tscartes[$j])
                                   ->setCode_compte($code_comptets)
                                   ->setCode_membre(null)
								   ->setCode_membre_morale($code)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tscartes[$j])
                                   ->setSolde(0);
								$map_compte->save($compte);
							}			
                        }	
					}
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp!!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre-ancien', 'action' => 'morale'));
				} catch (Exception $exc) {
			       $db->rollback();
				   $this->view->type_acteur = $_POST["type_acteur"];
                   $this->view->statut_juridique = $_POST["statut_juridique"];
                   $this->view->raison = $_POST["raison_sociale"];
                   $this->view->domaine_activite = $_POST["domaine_activite"];
                   $this->view->site_web = $_POST["site_web"];
                   $this->view->quartier_membre = $_POST["quartier_membre"];
                   $this->view->ville_membre = $_POST["ville_membre"];
                   $this->view->bp = $_POST["bp_membre"];
                   $this->view->tel = $_POST["tel_membre"];
                   $this->view->email = $_POST["email_membre"];
				   $this->view->id_pays = $_POST["id_pays"];
                   $this->view->portable = $_POST["portable_membre"];
                   $this->view->registre = $_POST["num_registre"];
			       $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                   return;
                }
	        }
	}
	
	
    public function ncmmAction() {
           $request = $this->getRequest();
           $nomm = $request->nomm;
           $this->view->nomm = $nomm;
           if(isset($nomm))
           $this->_helper->layout->disableLayout();
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $code_agence = $user->code_agence;
           $fs = Util_Utils::getParametre('FS', 'valeur');
           $this->view->fs = $fs;
           $request = $this->getRequest();
           $numident = $request->numident;
           $this->view->numident = $numident;
           $ville = $request->ville;
           $this->view->ville = $ville;
           $tel = $request->tel;
           $this->view->tel = $tel;
	       $qart = $request->qart;
           $this->view->quartier_membre = $qart;
	       $portable = $request->portable;
           $this->view->portable = $portable;
	       $email = $request->email;
           $this->view->email = $email;
	       $site = $request->site;
           $this->view->site_web = $site;
	       $bp = $request->bp;
           $this->view->bp = $bp;
		   
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
		    $table = new Application_Model_DbTable_EuActeur();
			//$select = $table->select();
			//$select->where('code_acteur like ?',$user->code_acteur);
			//$result = $table->fetchAll($select);
			//$findacteur = $result->current();
			//$code_gac_chaine = $findacteur->code_gac_chaine;
			//$selection = $table->select();
			//$selection->where('code_gac_chaine like ?',$code_gac_chaine);
			//$selection->where('type_acteur like ?','gac_surveillance');
			//$resultat = $table->fetchAll($selection);
			//$trouvacteursur = $resultat->current();
			//$acteur = $trouvacteursur->code_acteur;
			   
			$acteur = $user->code_acteur;
		
		    if ($this->getRequest()->isPost()) {
			    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
				$sms_mapper = new Application_Model_EuSmsmoneyMapper();
			    $mont_fl = Util_Utils::getParametre('FL','valeur');
				$compte = new Application_Model_EuCompte();
                $map_compte = new Application_Model_EuCompteMapper();
		        $tcartes = array();
			    $tscartes = array();
			    $id_type_acteur = "";
			    $id_type_creneau = "";
				$id_filiere = "";
			    $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {
			        $agrement_mapper = new Application_Model_EuAgrementMapper();
			        $agrement        = new Application_Model_EuAgrement();
				   
				    $agrement_filiere  =  $_POST["agrement_filiere"];
                    $agrement_acnev    =  $_POST["agrement_acnev"];
                    $agrement_technopole =  $_POST["agrement_technopole"];
				    $code_fl = $_POST["code_fl"];
				   
				    //insertion dans la table membremorale des information du nouveau membre
                    $membre = new Application_Model_EuMembreMorale();
                    $mapper = new Application_Model_EuMembreMoraleMapper();
				    $membre1 = new Application_Model_EuMembreMorale();
                    $mapper1 = new Application_Model_EuMembreMoraleMapper();
                    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                      $code = $code_agence . '0000001' . 'M';
                    } else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'M';
                    }
				    //insertion dans la table eu_operation
                    $mapper_op = new Application_Model_EuOperationMapper();
                    $compteur = $mapper_op->findConuter() + 1;
						
				    $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				    $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				    $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
				   
				     // verification agrement filiere
				    if($trouveagrementf != false) {
				      $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
					  
					  $id_type_creneau = $agrement->getId_type_creneau();
					  $id_type_acteur = $agrement->getId_type_acteur();
					  $id_filiere = $agrement->getId_filiere();
					  
				      $agrement_mapper->update($agrement);
					  //$resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
					  
					  // insertion dans la table eu_membre
					  $membre->setId_filiere($id_filiere);
					  $membre->setCode_membre_morale($code);
                      $membre->setCode_type_acteur($_POST["type_acteur"]);
                      $membre->setCode_statut($_POST["statut_juridique"]);
                      $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
					  $membre->setId_pays($_POST["id_pays"]);
                      $membre->setNum_registre_membre($_POST["num_registre"]);
                      $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                      $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                      $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                      $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                      $membre->setBp_membre($_POST["bp_membre"]);
                      $membre->setTel_membre($_POST["tel_membre"]);
                      $membre->setEmail_membre($_POST["email_membre"]);
                      $membre->setPortable_membre($_POST["portable_membre"]);
                      $membre->setId_utilisateur($utilisateur);
                      $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                      $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                      $membre->setCode_agence($code_agence);
                      $membre->setCodesecret(md5($_POST["codesecret"]));
                      $membre->setAuto_enroler('O');
					  $membre->setEtat_membre('A');
				      $mapper->save($membre);
					  
					  
					  // eu_acteurs_creneau
					  $cm = new Application_Model_EuActeurCreneauMapper();
                      $acren = new Application_Model_EuActeurCreneau();
							
					  $acren->setNom_acteur($_POST["raison_sociale"]);
                      $acren->setCode_membre($code);
					  $acren->setId_type_acteur($id_type_acteur);
					  
					  
					  //$acren->setCode_activite(null);
                      $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                      $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                      $acren->setId_utilisateur($utilisateur);
					  $acren->setGroupe($groupe);
					  $acren->setCode_creneau($id_type_creneau);
                      $acren->setCode_gac_filiere(null);
                      $acren->setCode_gac(null);
							
							
					  $code_zone = $user->code_zone;
			          $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                      if ($code_acteur == null) {
                        $code_acteur = 'A' . $code_zone . '0001';
                      } else {
                        $num_ordre = substr($code_acteur, -4);
                        $num_ordre++;
                        $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                      }
						
					  $acren->setCode_acteur($code_acteur);
					  $acren->setId_filiere($id_filiere);
					  $cm->save($acren);	
					  $fs = Util_Utils::getParametre('FS','valeur');	
				      // insertion dans la table eu_operation
                      Util_Utils::addOperation($compteur,null,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
					   
					  //insertion dans la table eu_representation
					    $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
					    $rep->setCode_membre_morale($code)
                            ->setCode_membre($_POST['code_rep'])
                            ->setTitre("Representant")
						    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						    ->setId_utilisateur($user->id_utilisateur)
						    ->setEtat('inside');
                        $rep_mapper->save($rep);
						
				      //insertion dans la table eu_compte_bancaire
                      $cpte = $_POST['cpteur'];
                      $i = 1;
                      $cb_mapper = new Application_Model_EuCompteBancaireMapper();
					  $id_compte = $cb_mapper->findConuter() + 1;
                      $cb = new Application_Model_EuCompteBancaire();
                      while ($i <= $cpte) {
                        if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                            $cb->setId_compte($id_compte)
							  ->setCode_banque($_POST['code_banque' . $i])
                              ->setCode_membre_morale($code)
						      ->setCode_membre(null)
                              ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                            $cb_mapper->save($cb);
                        }
                        $i++;
                       }
				    } else {
				     $db->rollBack();
				     $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				     $this->view->type_acteur = $_POST["type_acteur"];
                     $this->view->statut_juridique = $_POST["statut_juridique"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre"];
                     return;
				    }
				   
				   // verification agrement acnev
				    if($trouveagrementacnev != false) {
				     $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				     $agrement->setCode_membre_morale($code);
				     $agrement_mapper->update($agrement);			
				    } else {
				     $db->rollBack();
				     $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				     $this->view->type_acteur = $_POST["type_acteur"];
                     $this->view->statut_juridique = $_POST["statut_juridique"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre"];
                     return;
				    }
					
					// verification agrement technopole
					if($trouveagrementtechno != false) {
				      $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				      $agrement->setCode_membre_morale($code);
				      $agrement_mapper->update($agrement);			
				    } else {
				      $db->rollBack();
				      $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
				    } 
				   
				   $filiere =  new Application_Model_EuFiliere();
				   $map_filiere = new Application_Model_EuFiliereMapper();
				   $find_filiere = $map_filiere->find($id_filiere,$filiere);
				   $t_acteur = new Application_Model_DbTable_EuActeur();
				   $c_acteur = new Application_Model_EuActeur();
				   $table = new Application_Model_DbTable_EuActeur();
                   $select = $table->select();
				   $select->where('code_acteur like ?', $acteur);
				   $resultSet = $table->fetchAll($select);
				   $ligneacteur = $resultSet->current();
				   // insertion dans la table eu_acteur
				   $count = $c_acteur->findConuter() + 1;
                   $c_acteur->setId_acteur($count)
                            ->setCode_acteur(null)
							->setCode_division($filiere->getCode_division())
                            ->setCode_membre($code)
                            ->setId_utilisateur($utilisateur)
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					$c_acteur->setCode_source_create($ligneacteur->code_source_create);
					$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					$c_acteur->setId_pays($ligneacteur->id_pays);
					$c_acteur->setId_region($ligneacteur->id_region);
					$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					//$c_acteur->setId_sub_secteur($ligneacteur->id_sub_secteur);		
                    
					if($id_type_acteur == 3) {
                      $c_acteur->setCode_activite('detaillant');  
                    } elseif($id_type_acteur == 2) {
                      $c_acteur->setCode_activite('semi-grossiste');
                    } elseif($id_type_acteur == 1){
                      $c_acteur->setCode_activite('grossiste');
                    }
                      
					$c_acteur->setType_acteur('DSMS');
                    $c_acteur->setCode_gac_chaine($acteur);
                    $t_acteur->insert($c_acteur->toArray());
					  //R?cup?ration de la prk nr
                    $param = new Application_Model_EuParametresMapper();
                    $par = new Application_Model_EuParametres();
                    $prc = 0;
                    $par_prc = $param->find('prc', 'nr', $par);
                    if ($par_prc == true) {
                        $prc = $par->getMontant();
                    }
					
                    // insertion dans la table eu_tegc					
					$te_mapper = new Application_Model_EuTegcMapper();
                    $te = new Application_Model_EuTegc();
                    $code_te = 'TEGCP' .$id_filiere. $code;
                    $find_te = $te_mapper->find($code_te,$te);
                    if ($find_te == false) {
                        $te->setCode_tegc($code_te)
                            ->setId_filiere($id_filiere)
                            ->setMdv($prc)
                            ->setCode_membre($code)
                            ->setMontant(0)
							->setMontant_utilise(0)
							->setSolde_tegc(0);
                        $te_mapper->save($te);
                    } else {
                        $te->setId_filiere($id_filiere);
                        $te->setMdv($prc);
                        $te_mapper->update($te);
                    }
					      
					// table eu_utilisateur
					$user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                    if($id_type_acteur == 3) {
                          $userin->setCode_groupe('oe_detaillant');
                          $userin->setCode_gac_filiere('oe_detaillant');
						  $userin->setCode_groupe_create('oe_detaillant');
                    } elseif($id_type_acteur == 2) {
                          $userin->setCode_groupe('oe_semi_grossiste');
                          $userin->setCode_gac_filiere(null);
						  $userin->setCode_groupe_create('oe_semi_grossiste');
                    } elseif($id_type_acteur == 1) {
                          $userin->setCode_groupe('oe_grossiste');
                          $userin->setCode_gac_filiere(null);
						  $userin->setCode_groupe_create('oe_grossiste');
                    }
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
                    
				    $userin->setCode_acteur($acteur);
					
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
					$contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					  					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
					//Mise à jour de la table morale
                    $m_mapper = new Application_Model_MoraleMapper();
                    $m = new Application_Model_Morale();
                    $rep = $m_mapper->find($_POST["numident"],$m);
                    if ($rep == true) {
                       $m->setEtat_contrat(1)
				         ->setCode_membre($code);
                       $m_mapper->update($m);
                    }
					
					if($code_fl != "") {
					
					    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
					    if ($sms_fl == null) {
                           $db->rollback();
                           $this->view->message = 'Le code fl [' . $code_fl . ']  est  invalide !!!';
						   $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                        }
						
						if($sms_fl->getMotif() != 'FL') {
					      $db->rollBack();
						  $this->view->message = 'Le motif pour lequel ce code Fl est emis ne correspond pas à cette operation !!!';
						  $this->view->type_acteur = $_POST["type_acteur"];
                          $this->view->statut_juridique = $_POST["statut_juridique"];
                          $this->view->raison = $_POST["raison_sociale"];
                          $this->view->domaine_activite = $_POST["domaine_activite"];
                          $this->view->site_web = $_POST["site_web"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          $this->view->registre = $_POST["num_registre"];
                          return;    
					    }
						
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
						
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(null)
						   ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('hh:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
						$compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,null,$code, null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
												
						$sms_fl->setDestAccount_Consumed('FL-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/mm/yyyy hh:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/mm/yyyy')));
						
						$tcartes[0]="TPAGCP";
					    $tcartes[1]="TCNCSEI";
						$tcartes[2]="TPAGCI";
						$tcartes[3]="TIR";
						$tcartes[4]="TR";
					    $tcartes[5]="TPaNu";
						$tcartes[6]="TPaR";
						$tcartes[7]="TFS";
						$tcartes[8]="TPN";
						$tcartes[9]="TIB";
						$tcartes[10]="TPaNu";
					    $tcartes[11]="TIN";
						$tcartes[12]="CAPA";
						$tcartes[13]="TMARGE";
						$tcartes[14]="TRE";
									
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_compte,$compte);
						    } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
							    $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
								$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIN") {
							    $tcartes[$i] = "TI"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							}
							elseif($tcartes[$i] == "TMARGE") {
							    $tcartes[$i] = "TMARGE"; 
								$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_compte,$compte);
							}
							elseif($tcartes[$i] == "TIR") {
								$tcartes[$i] = "TI"; 
								$code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TIB") {
								$tcartes[$i] = "TI";
								$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_compte,$compte);
							}
										
							if(!$res) {
								// insertion dans la table eu_compte
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								$map_compte->save($compte);
									
							}
									
                        }
						
						$tscartes[0]="TSGCP";
						$tscartes[1]="TSCNCSEI";
						$tscartes[2]="TSGCI";
						$tscartes[3]="TSCAPA";
						$tscartes[4]="TSPaNu";
						$tscartes[5]="TSPaR";
						$tscartes[6]="TSFS";
						$tscartes[7]="TSPN";
						$tscartes[8]="TSIN";
						$tscartes[9]="TSIB";
						$tscartes[10]="TSIR";
						$tscartes[11]="TSMARGE";
						$tscartes[12]="TSRE";
									
						for($j = 0; $j < count($tscartes); $j++) {		
						    if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							}
                            elseif($tscartes[$j] == "TSMARGE") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							}
							/*elseif($tscartes[$j] == "TSMARGENB") {
								$tscartes[$j] = "TSMARGE"; 
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							}*/

							elseif($tscartes[$j] == "TSIR") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
								$tscartes[$j] = "TSI";
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
							    $res = $map_compte->find($code_comptets,$compte);
							}
										
							if(!$res)   {
							// insertion dans la table eu_compte
                            $compte->setCode_cat($tscartes[$j])
                                   ->setCode_compte($code_comptets)
                                   ->setCode_membre(null)
								   ->setCode_membre_morale($code)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tscartes[$j])
                                   ->setSolde(0);
								$map_compte->save($compte);
							}			
                        }	
					}
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp!!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre-ancien', 'action' => 'morale'));
			} catch (Exception $exc) {
			        $db->rollback();
				    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
				    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
			        $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }
            }
    }
	
	public function datamesmcAction() {
	
	   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $this->_helper->layout->disableLayout();
       $page = $this->_request->getParam("page", 1);
       $limit = $this->_request->getParam("rows", 10);
       $sidx = $this->_request->getParam("sidx", 'code_membre_morale');
       $sord = $this->_request->getParam("sord", 'asc');
	   $membre = $this->_request->getParam("membre");
	   $tabela = new Application_Model_DbTable_EuMembreMorale();
		   
	   if($membre !=''){
	     $select = $tabela->select();
	     $select->where('code_membre_morale = ?',$membre);
		 $select->where('etat_membre like ?','A');
	     $select->where('id_utilisateur = ?', $user->id_utilisateur);
	  }
      else {
		 $select = $tabela->select();
	     $select->where('id_utilisateur = ?', $user->id_utilisateur);
	     $select->where('code_membre_morale like ?','%M');
		 $select->where('etat_membre like ?','A');
		 $select->order('code_membre_morale desc');
      }
		  
		   
	   $membres = $tabela->fetchAll($select);
       $count = count($membres);
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
             $row->code_membre_morale,
             $row->code_type_acteur,
			 $row->code_statut,
             stripslashes (html_entity_decode($row->raison_sociale)),
			 stripslashes (html_entity_decode($row->domaine_activite)),
			 stripslashes (html_entity_decode($row->ville_membre)),
             $row->tel_membre,
             $row->portable_membre
          );
          $i++;
        }	 
        $this->view->data = $responce;
	}
	
	
	
	public function dataAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'code_membre');
           $sord = $this->_request->getParam("sord", 'asc');
		   $membre = $this->_request->getParam("membre");
		   $tabela = new Application_Model_DbTable_EuMembre();
		   
		    if($membre !='') {
			      $select = $tabela->select();
	              $select->where('code_membre = ?',$membre);
				  $select->where('etat_membre like ?','A');
	              $select->where('id_utilisateur = ?', $user->id_utilisateur);
	        }
            else {
		          $select = $tabela->select();
	              $select->where('id_utilisateur = ?', $user->id_utilisateur);
				  $select->where('code_membre like ?','%P');
				   $select->where('etat_membre like ?','A');
		          $select->order('code_membre desc');
		    }
		  
		   
		   $membres = $tabela->fetchAll($select);
           $count = count($membres);
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
              $row->code_membre,
              stripslashes (html_entity_decode($row->nom_membre)),
              stripslashes (html_entity_decode($row->prenom_membre)),
              $row->sexe_membre,
              stripslashes (html_entity_decode($row->profession_membre)),
              $row->portable_membre,
              stripslashes(html_entity_decode($row->ville_membre))
          );
          $i++;
        }	 
        $this->view->data = $responce;
	}
	
	
	public function newmoralegieAction(){
	   
	 
	}
	 
	public function newmoralegiepbfAction(){
	   
	 
	}
	 
	 
	public function newmoralegieoseAction(){
	   
	 
	}
	 
	 
	 
	 
	public function newmoralemcnpAction() {
	 
	  
	} 
	
	public function newmoralemcnppbfAction() {
	 
	  
	}
	
	
	 
	 
	public function newmoralemcnposeAction() {
	 
	 
	}
	
	
	public function ncmpmcnpAction() {
	    // action body
        $request = $this->getRequest();
        $nom_membre = $request->nom_membre;
        if (isset($nom_membre)) $this->_helper->layout->disableLayout();
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		   
		$ancien_code_membre = $request->ancien_code_membre;
        $this->view->ancien_code_membre = $ancien_code_membre;
	   
       $code_agence = $user->code_agence;
       $request = $this->getRequest();
       $nom = $request->nom_membre;
       $this->view->nom = $nom;
       $prenom = $request->prenom_membre;
       $this->view->prenom = $prenom;
       $sexe = $request->sexe_membre;
       $this->view->sexe = $sexe;
       $datenais = $request->date_nais_membre;
       $this->view->datenais = $datenais;
       $sitmatr = $request->sitfam_membre;
       $this->view->sitmatr = $sitmatr;
       $prof = $request->profession_membre;
       $this->view->prof = $prof;
       $tel = $request->tel_membre;
       $this->view->tel = $tel;
       $ville = $request->ville_membre;
       $this->view->ville = $ville; 
       $pere = $request->pere_membre;
       $this->view->pere = $pere;
       $mere = $request->mere_membre;
       $this->view->mere = $mere;
	   $qartresid = $request->quartier_membre;
       $this->view->quartier_membre = $qartresid;
	   $bp = $request->bp_membre;
       $this->view->bp = $bp;
	   $nbrenf = $request->nbr_enf_membre;
       $this->view->nbre_enf = $nbrenf;
	   $email = $request->email_membre;
       $this->view->email = $email;
	   $portable = $request->portable_membre;
       $this->view->portable = $portable;
	   $formation = $request->formation;
       $this->view->formation = $formation;
	   $lieunais = $request->lieu_nais_membre;
       $this->view->lieu_nais = $lieunais;
	   $id_pays = $request->id_pays;
       $this->view->id_pays = $id_pays;
	   $id_religion = $request->id_religion;
       $this->view->id_religion = $id_religion;
	   
	    if ($this->getRequest()->isPost())  {
	        $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
		    $id_type_acteur = "";
		    $id_type_creneau = "";
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try {
			
			    //insertion dans la table membre des information du nouveau membre
                $membre = new Application_Model_EuMembre();
                $mapper = new Application_Model_EuMembreMapper();
			    $compte = new Application_Model_EuCompte();
                $map_compte = new Application_Model_EuCompteMapper();
		        $tcartes = array();
			    $tscartes = array();
				
                $code = $mapper->getLastCodeMembreByAgence($code_agence);
                if ($code == null) {
                    $code = $code_agence . '0000001' . 'P';
                } 
                else {
                    $num_ordre = substr($code, 12, 7);
                    $num_ordre++;
                    $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                    $code = $code_agence . $num_ordre_bis . 'P';
                }
				$date_nais = new Zend_Date($_POST["date_nais_membre"]);
				if ($date_nais >= $date_idd) {
                    $this->view->message = "Erreur d'éxecution: La date de naissance doit être antérieure à la date actuelle !!!";
                    $db->rollback();
                    if ($code_caps != '') {
                            $this->view->code = $code_caps;
                    }
                    $this->view->nom_membre = $_POST["nom_membre"];
                    $this->view->prenom_membre = $_POST["prenom_membre"];
                    $this->view->sexe = $_POST["sexe_membre"];
                    $this->view->sitfam = $_POST["sitfam_membre"];
                    $this->view->datnais = $_POST["date_nais_membre"];
                    $this->view->nation = $_POST["nationalite_membre"];
                    $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                    $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                    $this->view->formation = $_POST["formation"];
                    $this->view->profession = $_POST["profession_membre"];
                    $this->view->religion = $_POST["religion_membre"];
                    $this->view->pere = $_POST["pere_membre"];
                    $this->view->mere = $_POST["mere_membre"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    return;
                }
				
				
					// insertion dans la table eu_membre
                    $membre->setCode_membre($code)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($_POST["nationalite_membre"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                           ->setDate_identification($date_idd->toString('yyyy-MM-dd'))
                           ->setCode_agence($user->code_agence)
						   ->setCodesecret(md5($_POST["codesecret"]))
						   ->setEtat_membre('A')
						   ->setCode_gac($user->code_acteur);
                        $mapper->save($membre);
						
						// Mise à jour de la table eu_ancien_membre
                        $p_mapper = new Application_Model_EuAncienMembreMapper();
                        $p = new Application_Model_EuAncienMembre();
                        $rep = $p_mapper->find($_POST["ancien_code_membre"],$p);
                        if ($rep == true) {      
                            $p->setEtat_contrat(1)
							  ->setCode_membre($code);
                            $p_mapper->update($p);      
                        }
						
						// Mise à jour du compte général fgf
                        $cpte = $_POST['cpteur'];
                        $i = 1;
                        $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                        $cb = new Application_Model_EuCompteBancaire();
                        while ($i <= $cpte) {
						    if($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i]) {
                                $cb->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre($code)
							       ->setCode_membre_morale(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
					    }
                            $i++;
                        }
						
						$userin = new Application_Model_EuUtilisateur();
                        $mapper = new Application_Model_EuUtilisateurMapper();
                        $id_user = $mapper->findConuter() + 1;
                        $userin->setId_utilisateur($id_user)
                               ->setId_utilisateur_parent($user->id_utilisateur)
                               ->setPrenom_utilisateur($_POST["prenom_membre"])
                               ->setNom_utilisateur($_POST["nom_membre"])
                               ->setLogin($code)
                               ->setPwd(md5($_POST["codesecret"]))
                               ->setDescription(null)
                               ->setUlock(0)
                               ->setCh_pwd_flog(0)
                               ->setCode_groupe('personne_physique')
					           ->setCode_groupe_create('personne_physique')
                               ->setConnecte(0)
                               ->setCode_agence($user->code_agence)
                               ->setCode_secteur(null)
                               ->setCode_zone($user->code_zone)
                                 //->setCode_gac_filiere(null)
		                       ->setId_pays($user->id_pays)	    	
                               ->setCode_acteur($user->code_acteur)
					           ->setCode_membre($code);    
                        $mapper->save($userin);
						
						 // Mise à jour de la table eu_contrat
                        $contrat = new Application_Model_EuContrat();
		                $mapper_contrat = new Application_Model_EuContratMapper();
		                $id_contrat = $mapper->findConuter() + 1;
				        $contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd'));
                        $contrat->setNature_contrat('numerique');
                        $contrat->setId_type_contrat(null);
                        $contrat->setId_type_creneau(null);
                        $contrat->setId_type_acteur(null);
                        $contrat->setId_pays(null);
                        $contrat->setId_utilisateur($user->id_utilisateur);
                        $contrat->setFiliere(null);
                        $mapper_contrat->save($contrat);
					
					$acteur = $user->code_acteur;
					$t_cmfh = new Application_Model_DbTable_EuCmfh();
                    $c_cmfh = new Application_Model_EuCmfh();
				    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
                    $count = $c_acteur->findConuter() + 1;
					$countcmfh = $c_cmfh->findConuter() + 1;
					$table = new Application_Model_DbTable_EuActeur();
					// insertion dans la table eu_cmfh
					if(isset($_POST["actcmfh"])) {
                      $select = $table->select();
					  $select->where('code_acteur like ?', $acteur);
					  $resultSet = $table->fetchAll($select);
					  $ligneacteur = $resultSet->current();
                      $c_cmfh->setId_cmfh($countcmfh);
                      $c_cmfh->setCode_membre($code);
                      $c_cmfh->setId_utilisateur($user->id_utilisateur);
                      $c_cmfh->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				      $c_cmfh->setCode_activite(null);
				      $c_cmfh->setCode_source_create($ligneacteur->code_source_create);
				      $c_cmfh->setCode_monde_create($ligneacteur->code_monde_create);
					  $c_cmfh->setCode_zone_create($ligneacteur->code_zone_create);
					  $c_cmfh->setId_pays($ligneacteur->id_pays);
					  $c_cmfh->setId_region($ligneacteur->id_region);
					  $c_cmfh->setCode_secteur_create($ligneacteur->code_secteur_create);
					  $c_cmfh->setCode_agence_create($ligneacteur->code_agence_create);					  
                      $c_cmfh->setType_acteur('CMFH');
				        if(($acteur !='') || ($acteur != null)) {
				           $c_cmfh->setCode_gac_chaine($acteur);           
                        } else {
						   $c_cmfh->setCode_gac_chaine(null);
						}         
                        $t_cmfh->insert($c_cmfh->toArray());
					  
					} 
					
					else if(isset($_POST["actenro"])) { 
					    $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $c_acteur->setId_acteur($count);
                        $c_acteur->setCode_acteur(null);
                        $c_acteur->setCode_membre($code);
                        $c_acteur->setId_utilisateur($user->id_utilisateur);
                        $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				        $c_acteur->setCode_activite(null);
				        $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
					    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					    $c_acteur->setId_pays($ligneacteur->id_pays);
					    $c_acteur->setId_region($ligneacteur->id_region);
					    $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					    $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					    $c_acteur->setType_acteur('DSMS');
				        if(($acteur !='') || ($acteur != null)) {
				           $c_acteur->setCode_gac_chaine($acteur);           
                        } else {
						   $c_acteur->setCode_gac_chaine(null);
						}         
                        $t_acteur->insert($c_acteur->toArray());
					}
						  
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
						$tafl = new Application_Model_DbTable_EuAncienFl();
                        $afl = new Application_Model_EuAncienFl();
                        $code_fl = 'FL-'.$_POST["ancien_code_membre"];
                        $result = $tafl->find($code_fl);
						  
						    //if (count($result) > 0) {
						    $code_afl = 'FL-'.$code;
							$mont_fl = Util_Utils::getParametre('FL','valeur'); 
							$fl->setCode_fl($code_afl)
                                ->setCode_membre($code)
							    ->setCode_membre_morale(null)
                                ->setMont_fl($mont_fl)
                                ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                                ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setCreditcode(null);
                            $tfl->insert($fl->toArray());
							  
							$tcartes[0]="TPAGCRPG";
						    $tcartes[1]="TCNCS";
							$tcartes[2]="TPaNu";
							$tcartes[3]="TPaR";
						    $tcartes[4]="TR";
							$tcartes[5]="CAPA";
							$tcartes[6]="TRE";
							 
							$tscartes[0]="TSRPG";
							$tscartes[1]="TSCNCS";
							$tscartes[2]="TSPaNu";
							$tscartes[3]="TSPaR";
							$tscartes[4]="TSCAPA";
							$tscartes[5]="TSRE";
							 
							for($i = 0; $i < count($tcartes); $i++) {
								if($tcartes[$i] == "TCNCS") {
                                    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
								} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
								} else  {
								    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
							    }
										
								if(!$res) {
                                  $compte->setCode_cat($tcartes[$i])
                                         ->setCode_compte($code_compte)
                                         ->setCode_membre($code)
										 ->setCode_membre_morale(null)
                                         ->setCode_type_compte($type_carte)
                                         ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                         ->setDesactiver(0)
                                         ->setLib_compte($tcartes[$i])
                                         ->setSolde(0);
									$map_compte->save($compte);	
								}
									
                            }
							
							
							for($j = 0; $j < count($tscartes); $j++) {
							
							    if($tscartes[$j] == "TSCNCS") {
                                    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'NR';
								    $res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
									$type_carte = 'NN';
									$res = $map_compte->find($code_comptets,$compte);
								} else {
								    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
									$type_carte = 'NB';
								    $res = $map_compte->find($code_comptets,$compte);
								}
										
								if(!$res) {
                                    $compte->setCode_cat($tscartes[$j])
                                          ->setCode_compte($code_comptets)
                                          ->setCode_membre($code)
										  ->setCode_membre_morale(null)
                                          ->setCode_type_compte($type_carte)
                                          ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                          ->setDesactiver(0)
                                          ->setLib_compte($tscartes[$j])
                                          ->setSolde(0);
									$map_compte->save($compte);
									
							    }
							} 
					    $compteur=Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp!!! Votre numero de membre est: " . $code ."  Votre Code Secret est : " .$_POST["codesecret"]); 
                        $db->commit();
                        return $this->_helper->redirector('index');
	        }  catch (Exception $exc) {
                $db->rollback();
                $this->view->nom = $_POST["nom_membre"];
                $this->view->prenom = $_POST["prenom_membre"];
                $this->view->sexe = $_POST["sexe_membre"];
                $this->view->sitmatr = $_POST["sitfam_membre"];
                $this->view->datenais = $_POST["date_nais_membre"];
                $this->view->nation = $_POST["nationalite_membre"];
                $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                $this->view->formation = $_POST["formation"];
                $this->view->prof = $_POST["profession_membre"];
                $this->view->religion = $_POST["religion_membre"];
                $this->view->pere = $_POST["pere_membre"];
                $this->view->mere = $_POST["mere_membre"];
                $this->view->quartier_membre = $_POST["quartier_membre"];
                $this->view->ville_membre = $_POST["ville_membre"];
                $this->view->bp = $_POST["bp_membre"];
                $this->view->tel = $_POST["tel_membre"];
                $this->view->email = $_POST["email_membre"];
                $this->view->portable = $_POST["portable_membre"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
            }
	    }
	
	}
	
	
	public function peditAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_agence = $user->code_agence;
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuMembrep();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
			    $membre = new Application_Model_EuMembre($form->getValues());
			    $date_nais = new Zend_Date($this->getRequest()->date_nais_membre);
                $membre->setCode_membre($this->getRequest()->code_membre);
                $membre->setCode_agence($code_agence)
                       ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                       ->setHeure_identification($date_id->toString('HH:mm:ss'))
                       ->setId_utilisateur($user->id_utilisateur)
					   ->setNom_membre(trim($this->getRequest()->nom_membre))
					   ->setPrenom_membre(trim($this->getRequest()->prenom_membre))
					   ->setSexe_membre($this->getRequest()->sexe_membre)
					   ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
					   ->setLieu_nais_membre(trim($this->getRequest()->lieu_nais_membre))
					   ->setId_pays($this->getRequest()->id_pays)
					   ->setProfession_membre(trim ($this->getRequest()->profession_membre))
					   ->setFormation(trim ($this->getRequest()->formation))
					   ->setPere_membre(trim ($this->getRequest()->pere_membre))
					   ->setMere_membre(trim ($this->getRequest()->mere_membre))
					   ->setSitfam_membre(trim($this->getRequest()->sitfam_membre))
					   ->setNbr_enf_membre($this->getRequest()->nbr_enf_membre)
					   ->setQuartier_membre(trim ($this->getRequest()->quartier_membre))
					   ->setVille_membre(trim ($this->getRequest()->ville_membre))
					   ->setBp_membre($this->getRequest()->bp_membre)
					   ->setTel_membre($this->getRequest()->tel_membre)
					   ->setEmail_membre(trim ($this->getRequest()->email_membre))
					   ->setPortable_membre($this->getRequest()->portable_membre)
					   ->setId_religion_membre($this->getRequest()->id_religion_membre);
                $mapper = new Application_Model_EuMembreMapper();
                $mapper->update($membre);
                return $this->_helper->redirector('index');
            } else {
                
            }
            $num_membre = $this->getRequest()->code_membre;
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
        } else {
            $num_membre = $request->membre;
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
            $mapper->find($num_membre, $membre);
			$tabela = new Application_Model_DbTable_EuMembre();
			$select = $tabela->select();
			$select->from('eu_membre');
			$select->where('code_membre like ?',$membre->getCode_membre());
			$membres = $tabela->fetchAll($select);
			$row = $membres->current();
			$datenais = new Zend_Date($row->date_nais_membre, Zend_Date::ISO_8601);
            if ($membre->getCode_membre() == $num_membre) {
                $data = array(
                'code_membre' => $num_membre,
                'nom_membre' => $membre->getNom_membre(),
                'prenom_membre' => $membre->getPrenom_membre(),
                'sexe_membre' => $membre->getSexe_membre(),
                'date_nais_membre' => $datenais->toString('dd/MM/yyyy'),
                'lieu_nais_membre' => $membre->getLieu_nais_membre(),
                'id_pays' => $membre->getId_pays(),
                'profession_membre' => $membre->getProfession_membre(),
                'formation' => $membre->getFormation(),
                'pere_membre' => $membre->getPere_membre(),
                'mere_membre' => $membre->getMere_membre(),
                'sitfam_membre' => $membre->getSitfam_membre(),
                'nbr_enf_membre' => $membre->getNbr_enf_membre(),
                'quartier_membre' => $membre->getQuartier_membre(),
                'ville_membre' => $membre->getVille_membre(),
                'bp_membre' => $membre->getBp_membre(),
                'tel_membre' => $membre->getTel_membre(),
                'email_membre' => $membre->getEmail_membre(),
                'date_identification' => $membre->getDate_identification(),
                'portable_membre' => $membre->getPortable_membre(),
                'code_agence' => $membre->getCode_agence(),
                'heure_identification' => $membre->getHeure_identification(),
                'id_religion_membre' => $membre->getId_religion_membre(),
                'id_utilisateur' => $membre->getId_utilisateur(),
                'auto_enroler' => $membre->getAuto_enroler()
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick',"window.open('" .
        $this->view->url(array('controller' => 'eu-membre-ancien','action' =>'index'), 'default', true) ."','_self')");
        $this->view->membre = $membre;
        $this->view->form = $form;
    }
	
	
	public function detailAction() {
           $this->_helper->layout->disableLayout();
           $num_membre = $this->getRequest()->membre;
           $mapper = new Application_Model_EuMembreMapper();
           $membre = new Application_Model_EuMembre();
           //$mapper->find($num_membre, $membre);
		   $membre=$mapper->detail($num_membre);
           $this->view->membre = $membre;
    }
	
	
	
    public function ncmpAction() { 
        // action body
        $request = $this->getRequest();
        $nom = $request->nom;
        if (isset($nom))
        $this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $numident = $request->numident;
        $this->view->numident = $numident;
        $code_agence = $user->code_agence;
        $request = $this->getRequest();
        $nom = $request->nom;
        $this->view->nom = $nom;
        $prenom = $request->prenom;
        $this->view->prenom = $prenom;
        $sexe = $request->sexe;
        $this->view->sexe = $sexe;
        //$datenais = $request->datenais;
        //$this->view->datenais = $datenais;
        $sitmatr = $request->sitmatr;
        $this->view->sitmatr = $sitmatr;
        $prof = $request->prof;
        $this->view->prof = $prof;
        $tel = $request->tel;
        $this->view->tel = $tel;
        $ville = $request->ville;
        $this->view->ville = $ville; 
        $pere = $request->pere;
        $this->view->pere = $pere;
        $mere = $request->mere;
        $this->view->mere = $mere;
	    $qartresid = $request->qartresid;
        $this->view->quartier_membre = $qartresid;
	    $bp = $request->bp;
        $this->view->bp = $bp;
	    $nbrenf = $request->nbrenf;
        $this->view->nbre_enf = $nbrenf;
	    $email = $request->email;
        $this->view->email = $email;
	    $portable = $request->portable;
        $this->view->portable = $portable;
	    $formation = $request->formation;
        $this->view->formation = $formation;
	    $lieunais = $request->lieunais;
        $this->view->lieu_nais = $lieunais;
        
        if ($this->getRequest()->isPost())  {
            // if ($form->isValid($request->getPost())) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //insertion dans la table membre des information du nouveau membre
				  
                $membre = new Application_Model_EuMembre();
                $mapper = new Application_Model_EuMembreMapper();
				$compte = new Application_Model_EuCompte();
                $map_compte = new Application_Model_EuCompteMapper();
		        $tcartes = array();
			    $tscartes = array();
				  
                    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                       $code = $code_agence . '0000001' . 'P';
                    } 
                    else {
                        $num_ordre = substr($code, 12, 7);
                        $num_ordre++;
                        $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                        $code = $code_agence . $num_ordre_bis . 'P';
                    }
                      $date_nais = new Zend_Date($_POST["date_nais_membre"]);
                      if ($date_nais >= $date_idd) {
                        $this->view->message = "Erreur d'éxecution: La date de naissance doit être antérieure à la date actuelle !!!";
                        $db->rollback();
                        if ($code_caps != '') {
                            $this->view->code = $code_caps;
                        }
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
                    }
					
                    $membre->setCode_membre($code)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($_POST["nationalite_membre"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                           ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                           ->setCode_agence($user->code_agence)
						   ->setCodesecret(md5($_POST["codesecret"]))
						   ->setEtat_membre('A')
						   ->setCode_gac($user->code_acteur);
                    $mapper->save($membre);
                        
                      //Mise à jour de la table physique
                      $p_mapper = new Application_Model_PhysiqueMapper();
                      $p = new Application_Model_Physique();
                      $rep = $p_mapper->find($_POST["numident"],$p);
                        if ($rep == true) {      
                           $p->setEtat_contrat(1)
						     ->setCode_membre($code);
                           $p_mapper->update($p);      
                        }
							 
                    //Mise à jour du compte général fgf
                    $cpte = $_POST['cpteur'];
                    $i = 1;
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
                    while ($i <= $cpte) {
						    if($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i]) {
                            $cb->setCode_banque($_POST['code_banque' . $i])
                              ->setCode_membre($code)
							  ->setCode_membre_morale(null)
                              ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                            $cb_mapper->save($cb);
					    }
                            $i++;
                    }
					
                    //Util_Utils::createCompte('nb-tpagcrpg-' . $code, 'tpagcrpg', 'tpagcrpg', 0, $code, 'nb', $date_id, 0);
					// Mise à jour de la table eu_utilisateur	
					$userin = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user)
                           ->setId_utilisateur_parent($user->id_utilisateur)
                           ->setPrenom_utilisateur($_POST["prenom_membre"])
                           ->setNom_utilisateur($_POST["nom_membre"])
                           ->setLogin($code)
                           ->setPwd(md5($_POST["codesecret"]))
                           ->setDescription(null)
                           ->setUlock(0)
                           ->setCh_pwd_flog(0)
                           ->setCode_groupe('personne_physique')
					       ->setCode_groupe_create('personne_physique')
                           ->setConnecte(0)
                           ->setCode_agence($user->code_agence)
                           ->setCode_secteur(null)
                           ->setCode_zone($user->code_zone)
                                 //->setCode_gac_filiere(null)
		                   ->setId_pays($user->id_pays)	    	
                           ->setCode_acteur($user->code_acteur)
					       ->setCode_membre($code);    
                    $mapper->save($userin);
					
				
				    // Mise à jour de la table eu_contrat
                    $contrat = new Application_Model_EuContrat();
		            $mapper_contrat = new Application_Model_EuContratMapper();
		            $id_contrat = $mapper->findConuter() + 1;
				    $contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat('numerique');
                    $contrat->setId_type_contrat(null);
                    $contrat->setId_type_creneau(null);
                    $contrat->setId_type_acteur(null);
                    $contrat->setId_pays(null);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(null);
                    $mapper_contrat->save($contrat);
						  
						  
				    $acteur = $user->code_acteur;
					$t_cmfh = new Application_Model_DbTable_EuCmfh();
                    $c_cmfh = new Application_Model_EuCmfh();
				    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
                    $count = $c_acteur->findConuter() + 1;
					$countcmfh = $c_cmfh->findConuter() + 1;
					$table = new Application_Model_DbTable_EuActeur();
					
					if(isset($_POST["actcmfh"])) {
                      $select = $table->select();
					  $select->where('code_acteur like ?', $acteur);
					  $resultSet = $table->fetchAll($select);
					  $ligneacteur = $resultSet->current();
                      $c_cmfh->setId_cmfh($countcmfh);
                      $c_cmfh->setCode_membre($code);
                      $c_cmfh->setId_utilisateur($user->id_utilisateur);
                      $c_cmfh->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				      $c_cmfh->setCode_activite(null);
				      $c_cmfh->setCode_source_create($ligneacteur->code_source_create);
				      $c_cmfh->setCode_monde_create($ligneacteur->code_monde_create);
					  $c_cmfh->setCode_zone_create($ligneacteur->code_zone_create);
					  $c_cmfh->setId_pays($ligneacteur->id_pays);
					  $c_cmfh->setId_region($ligneacteur->id_region);
					  $c_cmfh->setCode_secteur_create($ligneacteur->code_secteur_create);
					  $c_cmfh->setCode_agence_create($ligneacteur->code_agence_create);					  
                      $c_cmfh->setType_acteur('CMFH');
				        if(($acteur !='') || ($acteur != null)) {
				           $c_cmfh->setCode_gac_chaine($acteur);           
                        } else {
						   $c_cmfh->setCode_gac_chaine(null);
						}         
                        $t_cmfh->insert($c_cmfh->toArray());
					  
					}  else if(isset($_POST["actenro"])) { 
					    $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $c_acteur->setId_acteur($count);
                        $c_acteur->setCode_acteur(null);
                        $c_acteur->setCode_membre($code);
                        $c_acteur->setId_utilisateur($user->id_utilisateur);
                        $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				        $c_acteur->setCode_activite(null);
				        $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
					    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					    $c_acteur->setId_pays($ligneacteur->id_pays);
					    $c_acteur->setId_region($ligneacteur->id_region);
					    $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					    $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
						//$c_acteur->setId_sub_secteur($ligneacteur->id_sub_secteur);
					    $c_acteur->setType_acteur('DSMS');
				        if(($acteur !='') || ($acteur != null)) {
				           $c_acteur->setCode_gac_chaine($acteur);           
                        } else {
						   $c_acteur->setCode_gac_chaine(null);
						}         
                        $t_acteur->insert($c_acteur->toArray());
					   
					}
					
					    $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
						$tafl = new Application_Model_DbTable_EuAncienFl();
                        $afl = new Application_Model_EuAncienFl();
                        $code_fl = 'FL-'.$code;
                        $result = $tafl->find($code_fl);
						  
						//if (count($result) > 0) {
						$code_afl = 'FL-'.$code;
						$mont_fl = Util_Utils::getParametre('FL','valeur'); 
						$fl->setCode_fl($code_afl)
                           ->setCode_membre($code)
						   ->setCode_membre_morale(null)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_id->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_id->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode(null);
                        $tfl->insert($fl->toArray());
							  
						$tcartes[0]="TPAGCRPG";
						$tcartes[1]="TCNCS";
						$tcartes[2]="TPaNu";
						$tcartes[3]="TPaR";
						$tcartes[4]="TR";
						$tcartes[5]="CAPA";
						$tcartes[5]="TRE";
							 
						$tscartes[0]="TSRPG";
						$tscartes[1]="TSCNCS";
						$tscartes[2]="TSPaNu";
						$tscartes[3]="TSPaR";
						$tscartes[4]="TSCAPA";
						$tscartes[5]="TSRE";
							 
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCS") {
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NN';
							    $res = $map_compte->find($code_compte,$compte);
							} else  {
								$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_compte,$compte);
							}
										
							if(!$res) {
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre($code)
									   ->setCode_membre_morale(null)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								 $map_compte->save($compte);	
							}
									
                        }
								
						for($j = 0; $j < count($tscartes); $j++) {
							if($tscartes[$j] == "TSCNCS") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
								$res = $map_compte->find($code_comptets,$compte);
						    } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NN';
							    $res = $map_compte->find($code_comptets,$compte);
							} else {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
							    $type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							}		
								if(!$res) {
                                    $compte->setCode_cat($tscartes[$j])
                                          ->setCode_compte($code_comptets)
                                          ->setCode_membre($code)
										  ->setCode_membre_morale(null)
                                          ->setCode_type_compte($type_carte)
                                          ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                          ->setDesactiver(0)
                                          ->setLib_compte($tscartes[$j])
                                          ->setSolde(0);
									$map_compte->save($compte);
									
							    }
							
						} 
				    $compteur=Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp!!! Votre numero de membre est: " . $code ."  Votre Code Secret est : " .$_POST["codesecret"]); 
                    $db->commit();
                    //Redirection sur le formulaire du contrat
                    //return $this->_helper->redirector('newpp', 'eu-contrat', null, array('controller' => 'eu-contrat', 'action' => 'newpp', 'membre' => $code, 'type' => 'p'));
				    return $this->_helper->redirector('index');
            } 
            catch (Exception $exc) {
                   $db->rollback();
                   $this->view->nom = $_POST["nom_membre"];
                   $this->view->prenom = $_POST["prenom_membre"];
                   $this->view->sexe = $_POST["sexe_membre"];
                   $this->view->sitmatr = $_POST["sitfam_membre"];
                   $this->view->datenais = $_POST["date_nais_membre"];
                   $this->view->nation = $_POST["nationalite_membre"];
                   $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                   $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                   $this->view->formation = $_POST["formation"];
                   $this->view->prof = $_POST["profession_membre"];
                   $this->view->religion = $_POST["religion_membre"];
                   $this->view->pere = $_POST["pere_membre"];
                   $this->view->mere = $_POST["mere_membre"];
                   $this->view->quartier_membre = $_POST["quartier_membre"];
                   $this->view->ville_membre = $_POST["ville_membre"];
                   $this->view->bp = $_POST["bp_membre"];
                   $this->view->tel = $_POST["tel_membre"];
                   $this->view->email = $_POST["email_membre"];
                   $this->view->portable = $_POST["portable_membre"];
                   $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
            }
             //return $this->_helper->redirector('eu-contrat')
             //}
        }
       
    }
    
    public function nommAction() {
        $data = array();
        $membre = new Application_Model_DbTable_Morale();
        $select = $membre->select();
        $select->from($membre, array('nomm'));
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
            $data[] = $m->nomm;
        }
        $this->view->data = $data;
    }
	
	
	public function nommmcnpAction() {
        $data = array();
        $membre = new Application_Model_DbTable_EuAncienMembre();
        $select = $membre->select();
		$select->where('type_membre = ?','m');
        $select->from($membre,array('raison_sociale'));
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
            $data[] = $m->raison_sociale;
        }
        $this->view->data = $data;
    }
	
	
	
	
	public function datamoseAction() { 
           $this->_helper->layout->disableLayout();
           if (isset($_GET["code_membre"])) $code_membre = $_GET["code_membre"];
           if (isset($_GET["nomm"])) $nomm = strtoupper($_GET["nomm"]);
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'numidentm');
           $sord = $this->_request->getParam("sord", 'asc');
           $tabela = new Application_Model_DbTable_Morale();
           if($code_membre!="" && $nomm!="") {
           $select=$tabela->select();
           $select->from($tabela)
                  ->where('numidentm like ?', '%'.$code_membre)
                  ->where('nomm like ?', '%'.$nomm .'%')
			      ->where('etat_contrat = ?', 0)
	              ->order('nomm asc');
           }
           else if($code_membre!="") {
           $select=$tabela->select();
           $select->from($tabela)
                  ->where('numidentm like ?', '%'.$code_membre.'%')
			      ->where('etat_contrat = ?', 0)
	              ->order('nomm asc');
           }
           else if($nomm!="") {
           $select=$tabela->select();
           $select->from($tabela)
                  ->where('nomm like ?', '%'.$nomm .'%')
			      ->where('etat_contrat = ?', 0)
	              ->order('nomm asc');
            }
			
           //else {
           //$select=$tabela->select();
           //$select->from($tabela);
           //}
        
           $cats = $tabela->fetchAll($select);
           $count = count($cats);

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
              $responce['rows'][$i]['id'] = $row->numidentm;
              $responce['rows'][$i]['cell'] = array(
                  $row->numidentm,
                  $row->nomm,
                  $row->representant,
                  $row->qart,
                  $row->ville,
                  $row->bp,
                  $row->tel,
                  $row->dateident,
		          $row->portable,
		          $row->email,
		          $row->site    
            );
            $i++;
        }
        $this->view->data = $responce;
    }
	
	
	
    
	
	
	
    public function datamAction() { 
           $this->_helper->layout->disableLayout();
           if (isset($_GET["code_membre"])) $code_membre = $_GET["code_membre"];
           if (isset($_GET["nomm"])) $nomm = strtoupper($_GET["nomm"]);
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'numidentm');
           $sord = $this->_request->getParam("sord", 'asc');
           $tabela = new Application_Model_DbTable_Morale();
           if($code_membre!="" && $nomm!="") {
           $select=$tabela->select();
           $select->from($tabela)
                  ->where('numidentm like ?', '%'.$code_membre)
                  ->where('nomm like ?', '%'.$nomm .'%')
			      ->where('etat_contrat = ?', 0)
	              ->order('nomm asc');
           }
           else if($code_membre!="") {
           $select=$tabela->select();
           $select->from($tabela)
                  ->where('numidentm like ?', '%'.$code_membre.'%')
			      ->where('etat_contrat = ?', 0)
	              ->order('nomm asc');
           }
           else if($nomm!="") {
           $select=$tabela->select();
           $select->from($tabela)
                  ->where('nomm like ?', '%'.$nomm .'%')
			      ->where('etat_contrat = ?', 0)
	              ->order('nomm asc');
            }
			
           //else {
           //$select=$tabela->select();
           //$select->from($tabela);
           //}
        
           $cats = $tabela->fetchAll($select);
           $count = count($cats);

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
              $responce['rows'][$i]['id'] = $row->numidentm;
              $responce['rows'][$i]['cell'] = array(
                  $row->numidentm,
                  $row->nomm,
                  $row->representant,
                  $row->qart,
                  $row->ville,
                  $row->bp,
                  $row->tel,
                  $row->dateident,
		          $row->portable,
		          $row->email,
		          $row->site    
            );
            $i++;
        }
        $this->view->data = $responce;
    }
    
	
	public function datammcnposeAction() {
	       $this->_helper->layout->disableLayout();
		   if (isset($_GET["code_membre"])) $code_membre = $_GET["code_membre"];
		   if (isset($_GET["raison_sociale"])) $raison_sociale = strtoupper($_GET["raison_sociale"]);
		   
		   $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'ancien_code_membre');
           $sord = $this->_request->getParam("sord", 'asc');
           $tabela = new Application_Model_DbTable_EuAncienMembre();
		   
		   if($code_membre !="" && $raison_sociale !="") {
		      $select = $tabela->select();
              $select->from($tabela)
                     ->where('ancien_code_membre like ?', '%'.$code_membre.'%')
                     ->where('raison_sociale like ?', '%'.$raison_sociale.'%')
					 ->where('code_type_acteur like ?','ose')
				     ->where('etat_contrat = ?', 0);	 		  
	          $cats = $tabela->fetchAll($select);
              $count = count($cats);

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
			    $dateidentif = new Zend_Date($row->date_identification);
                $responce['rows'][$i]['id'] = $row->ancien_code_membre;
                $responce['rows'][$i]['cell'] = array(
                     $row->ancien_code_membre,
                     $row->raison_sociale,
                     $row->nom_membre." ".$row->PREnom_membre,
                     $row->quartier_membre,
                     $row->ville_membre,
                     $row->bp_membre,
                     $row->tel_membre, 
                     $row->dateidentif->toString(dd/MM/yyyy),
                     $row->portable_membre,
		             $row->email_membre,
		             $row->site_web
              );
              $i++;
             }
             $this->view->data = $responce;     
	    } else if($code_membre!="") {
		       
		    $select = $tabela->select();
            $select->from($tabela)
                   ->where('ancien_code_membre like ?', '%'.$code_membre.'%')
				   ->where('code_type_acteur like ?','OSE')
				   ->where('etat_contrat = ?',0);	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

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
		    $dateidentif = new Zend_Date($row->date_identification);
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->raison_sociale,
                $row->nom_membre." ".$row->prenom_membre,
                $row->quartier_membre,
                $row->ville_membre,
                $row->bp_membre,
                $row->tel_membre, 
                $row->dateidentif->toString('dd/MM/yyyy'),
                $row->portable_membre,
		        $row->email_membre,
		        $row->site_web
            );
            $i++;
         }
         $this->view->data = $responce;
		}
		else if($raison_sociale !="") {   
		     $select = $tabela->select();
             $select->from($tabela)
                    ->where('raison_sociale like ?','%'.$raison_sociale.'%')
					->where('code_type_acteur like ?','OSE')
				    ->where('etat_contrat = ?',0);	 		  
	         $cats = $tabela->fetchAll($select);
             $count = count($cats);

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
			 $dateidentif = new Zend_Date($row->date_identification);
             $responce['rows'][$i]['id'] = $row->ancien_code_membre;
             $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->raison_sociale,
                $row->nom_membre." ".$row->PREnom_membre,
                $row->quartier_membre,
                $row->ville_membre,
                $row->bp_membre,
                $row->tel_membre, 
                $row->dateidentif->toString('dd/MM/yyyy'),
                $row->portable_membre,
		        $row->email_membre,
		        $row->site_web
             );
             $i++;
             }
             $this->view->data = $responce;
		     }
			 
	}
	
	
	
	
	
	public function datammcnpAction() {
	       $this->_helper->layout->disableLayout();
		   if (isset($_GET["code_membre"])) $code_membre = $_GET["code_membre"];
		   if (isset($_GET["raison_sociale"])) $raison_sociale = strtoupper($_GET["raison_sociale"]);
		   
		   $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'ancien_code_membre');
           $sord = $this->_request->getParam("sord", 'asc');
           $tabela = new Application_Model_DbTable_EuAncienMembre();
		   
		   if($code_membre !="" && $raison_sociale !="") {
		        $select = $tabela->select();
                $select->from($tabela)
                       ->where('ancien_code_membre like ?', '%'.$code_membre.'%')
                       ->where('raison_sociale like ?', '%'.$raison_sociale.'%')
				       ->where('etat_contrat = ?', 0);	 		  
	            $cats = $tabela->fetchAll($select);
                $count = count($cats);

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
			     $dateidentif = new Zend_Date($row->date_identification);
                 $responce['rows'][$i]['id'] = $row->ancien_code_membre;
                 $responce['rows'][$i]['cell'] = array(
                     $row->ancien_code_membre,
                     $row->raison_sociale,
                     $row->nom_membre." ".$row->PREnom_membre,
                     $row->quartier_membre,
                     $row->ville_membre,
                     $row->bp_membre,
                     $row->tel_membre, 
                     $row->dateidentif->toString('dd/MM/yyyy'),
                     $row->portable_membre,
		             $row->email_membre,
		             $row->site_web
              );
              $i++;
             }
             $this->view->data = $responce;     
	    } else if($code_membre!="") {
		       
		   $select = $tabela->select();
           $select->from($tabela)
                  ->where('ancien_code_membre like ?', '%'.$code_membre.'%')
				  ->where('etat_contrat = ?',0);	 		  
	       $cats = $tabela->fetchAll($select);
           $count = count($cats);

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
		     $dateidentif = new Zend_Date($row->date_identification);
             $responce['rows'][$i]['id'] = $row->ancien_code_membre;
             $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->raison_sociale,
                $row->nom_membre." ".$row->PREnom_membre,
                $row->quartier_membre,
                $row->ville_membre,
                $row->bp_membre,
                $row->tel_membre, 
                $row->dateidentif->toString('dd/MM/yyyy'),
                $row->portable_membre,
		        $row->email_membre,
		        $row->site_web
            );
            $i++;
         }
         $this->view->data = $responce;
		}
		else if($raison_sociale !="") {   
		     $select = $tabela->select();
             $select->from($tabela)
                    ->where('raison_sociale like ?','%'.$raison_sociale.'%')
				    ->where('etat_contrat = ?',0);	 		  
	         $cats = $tabela->fetchAll($select);
             $count = count($cats);

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
			 $dateidentif = new Zend_Date($row->date_identification);
             $responce['rows'][$i]['id'] = $row->ancien_code_membre;
             $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->raison_sociale,
                $row->nom_membre." ".$row->PREnom_membre,
                $row->quartier_membre,
                $row->ville_membre,
                $row->bp_membre,
                $row->tel_membre, 
                $row->dateidentif->toString('dd/MM/yyyy'),
                $row->portable_membre,
		        $row->email_membre,
		        $row->site_web
            );
            $i++;
            }
            $this->view->data = $responce;
		    }		 
	}
	
	
	
	public function datapmcnpAction() {
	    $this->_helper->layout->disableLayout();
	    if (isset($_GET["code_membre"])) $code_membre = $_GET["code_membre"];
        if (isset($_GET["nom"])) $nom = strtoupper($_GET["nom"]);
        if (isset($_GET["prenom"])) $prenom = strtoupper($_GET["prenom"]);
	    $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'numidentp');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuAncienMembre();
		
		if($code_membre !="" && $nom !="" && $prenom !="") {
		    $select = $tabela->select();
            $select->from($tabela)
                   ->where('ancien_code_membre like ?', '%'.$code_membre.'%')
                   ->where('nom_membre like ?', '%'.$nom .'%')
                   ->where('prenom_membre like ?', '%'.$prenom .'%')
				   ->where('etat_contrat = ?', 0);	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

        if ($count > 0) {
           $total_pages = ceil($count / $limit);
        } else {
           $total_pages = 0;
        }

        if ($page > $total_pages) $page = $total_pages;

        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cats as $row) {
		    $datenaismembre = new Zend_Date($row->date_nais_membre);
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
              $row->ancien_code_membre,
              $row->nom_membre,
              $row->prenom_membre,
              $row->sexe_membre,
              $row->profession_membre,
              $row->tel_membre,
              $row->ville_membre, 
              $row->pere_membre,
              $row->mere_membre,
		      $row->quartier_membre,
		      $row->bp_membre,
		      $row->nbr_enf_membre,
		      $row->email_membre,
		      $row->portable_membre,
		      $row->formation,
		      $row->lieu_nais_membre,
			  $row->datenaismembre->toString('dd/MM/yyyy'),
			  $row->sitfam_membre,
			  $row->id_pays,
			  $row->id_religion_membre
            );
            $i++;
        }
        $this->view->data = $responce;      
	
	    } else if($code_membre !="" && $nom !="") {
		  $select = $tabela->select();
          $select->from($tabela,array('eu_ancien_membre'))
                 ->where('ancien_code_membre like ?', '%'.$code_membre.'%')
                 ->where('nom_membre like ?', '%'.$nom.'%')
				 ->where('etat_contrat = ?', 0);	 		  
	      $cats = $tabela->fetchAll($select);
          $count = count($cats);

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
		    $datenaismembre = new Zend_Date($row->date_nais_membre,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
              $row->ancien_code_membre,
              $row->nom_membre,
              $row->prenom_membre,
              $row->sexe_membre,
              $row->profession_membre,
              $row->tel_membre,
              $row->ville_membre, 
              $row->pere_membre,
              $row->mere_membre,
		      $row->quartier_membre,
		      $row->bp_membre,
		      $row->nbr_enf_membre,
		      $row->email_membre,
		      $row->portable_membre,
		      $row->formation,
		      $row->lieu_nais_membre,
			  $datenaismembre->toString('dd/MM/yyyy'),
			  $row->sitfam_membre,
			  $row->id_pays,
			  $row->id_religion_membre
            );
            $i++;
        }
        $this->view->data = $responce; 
		   
		} else if($code_membre !="" && $prenom !="") {
		  $select = $tabela->select();
          $select->from($tabela,array('eu_ancien_membre'))
                 ->where('ancien_code_membre like ?', '%'.$code_membre.'%')
                 ->where('prenom_membre like ?', '%'.$prenom . '%')
				 ->where('etat_contrat = ?', 0);	 		  
	      $cats = $tabela->fetchAll($select);
          $count = count($cats);

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
		    $datenaismembre = new Zend_Date($row->date_nais_membre,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
              $row->ancien_code_membre,
              $row->nom_membre,
              $row->prenom_membre,
              $row->sexe_membre,
              $row->profession_membre,
              $row->tel_membre,
              $row->ville_membre, 
              $row->pere_membre,
              $row->mere_membre,
		      $row->quartier_membre,
		      $row->bp_membre,
		      $row->nbr_enf_membre,
		      $row->email_membre,
		      $row->portable_membre,
		      $row->formation,
		      $row->lieu_nais_membre,
			  $datenaismembre->toString('dd/MM/yyyy'),
			  $row->sitfam_membre,
			  $row->id_pays,
			  $row->id_religion_membre
            );
            $i++;
        }
            $this->view->data = $responce;
		
		} else if($nom!="" && $prenom!="") {
		   
		    $select = $tabela->select();
            $select->from($tabela,array('eu_ancien_membre'))
                  ->where('nom_membre like ?', '%'.$nom . '%')
                  ->where('prenom_membre like ?', '%'.$prenom.'%')
				  ->where('ancien_code_membre like ?', '%P')
				  ->where('etat_contrat = ?', 0);	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

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
		     $datenaismembre = new Zend_Date($row->date_nais_membre, Zend_Date::ISO_8601);
             $responce['rows'][$i]['id'] = $row->ancien_code_membre;
             $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->nom_membre,
                $row->prenom_membre,
                $row->sexe_membre,
                $row->profession_membre,
                $row->tel_membre,
                $row->ville_membre, 
                $row->pere_membre,
                $row->mere_membre,
		        $row->quartier_membre,
		        $row->bp_membre,
		        $row->nbr_enf_membre,
		        $row->email_membre,
		        $row->portable_membre,
		        $row->formation,
		        $row->lieu_nais_membre,
			    $datenaismembre->toString('dd/MM/yyyy'),
			    $row->sitfam_membre,
				$row->id_pays,
				$row->id_religion_membre
            );
            $i++;
        }
         $this->view->data = $responce;
		   
		} else if($code_membre!="") {
		       
		   $select = $tabela->select();
           $select->from($tabela)
                  ->where('ancien_code_membre like ?', '%'.$code_membre.'%')
				  ->where('etat_contrat = ?', 0);	 		  
	       $cats = $tabela->fetchAll($select);
           $count = count($cats);

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
		    $datenaismembre = new Zend_Date($row->date_nais_membre, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->nom_membre,
                $row->prenom_membre,
                $row->sexe_membre,
                $row->profession_membre,
                $row->tel_membre,
                $row->ville_membre, 
                $row->pere_membre,
                $row->mere_membre,
		        $row->quartier_membre,
		        $row->bp_membre,
		        $row->nbr_enf_membre,
		        $row->email_membre,
		        $row->portable_membre,
		        $row->formation,
		        $row->lieu_nais_membre,
			    $datenaismembre->toString('dd/MM/yyyy'),
			    $row->sitfam_membre,
				$row->id_pays,
				$row->id_religion_membre
            );
            $i++;
        }
         $this->view->data = $responce;
		} else if($nom!="") {
		    
			$select = $tabela->select();
            $select->from($tabela)
                   ->where('nom_membre like ?', '%'.$nom .'%')
				   ->where('ancien_code_membre like ?', '%P')
				   ->where('etat_contrat = ?', 0);	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

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
			    $datenaismembre = new Zend_Date($row->date_nais_membre,Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->ancien_code_membre;
                $responce['rows'][$i]['cell'] = array(
                   $row->ancien_code_membre,
                   $row->nom_membre,
                   $row->prenom_membre,
                   $row->sexe_membre,
                   $row->profession_membre,
                   $row->tel_membre,
                   $row->ville_membre, 
                   $row->pere_membre,
                   $row->mere_membre,
		           $row->quartier_membre,
		           $row->bp_membre,
		           $row->nbr_enf_membre,
		           $row->email_membre,
		           $row->portable_membre,
		           $row->formation,
		           $row->lieu_nais_membre,
			       $datenaismembre->toString('dd/MM/yyyy'),
			       $row->sitfam_membre,
				   $row->id_pays,
				   $row->id_religion_membre
            );
            $i++;
        }
         $this->view->data = $responce;
		} else if($prenom!="") {
		  $select = $tabela->select();
          $select->from($tabela)
                 ->where('prenom_membre like ?', '%'.$prenom . '%')
				 ->where('ancien_code_membre like ?', '%P')
				 ->where('etat_contrat = ?', 0);	 		  
	      $cats = $tabela->fetchAll($select);
          $count = count($cats);

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
		    $datenaismembre = new Zend_Date($row->date_nais_membre,Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->ancien_code_membre;
            $responce['rows'][$i]['cell'] = array(
                $row->ancien_code_membre,
                $row->nom_membre,
                $row->prenom_membre,
                $row->sexe_membre,
                $row->profession_membre,
                $row->tel_membre,
                $row->ville_membre, 
                $row->pere_membre,
                $row->mere_membre,
		        $row->quartier_membre,
		        $row->bp_membre,
		        $row->nbr_enf_membre,
		        $row->email_membre,
		        $row->portable_membre,
		        $row->formation,
		        $row->lieu_nais_membre,
			    $datenaismembre->toString('dd/MM/yyyy'),
			    $row->sitfam_membre,
				$row->id_pays,
				$row->id_religion_membre
            );
            $i++;
        }
        $this->view->data = $responce;
		
		}
	
	}
	
	
    public function datapAction() { 
        $this->_helper->layout->disableLayout();
           if (isset($_GET["code_membre"])) $code_membre = $_GET["code_membre"];
           if (isset($_GET["nom"])) $nom = strtoupper($_GET["nom"]);
           if (isset($_GET["prenom"])) $prenom = strtoupper($_GET["prenom"]);
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'numidentp');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_Physique();
		$membres = new Application_Model_DbTable_EuAncienMembre();
        if($code_membre!="" && $nom!="" && $prenom!="") {
            $select = $tabela->select();
            $select->from($tabela)
                   ->where('numidentp like ?', '%'.$code_membre.'%')
                   ->where('nom like ?', '%'.$nom.'%')
                   ->where('prenom like ?', '%'.$prenom.'%')
				   ->where('etat_contrat = ?',0);	 		  
	        $cats = $tabela->fetchAll($select);
            $count = count($cats);

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
            
            $responce['rows'][$i]['id'] = $row->numidentp;
            $responce['rows'][$i]['cell'] = array(
                $row->numidentp,
                $row->nom,
                $row->prenom,
                $row->sexe,
                $row->prof,
                $row->tel,
                $row->ville, 
                $row->pere,
                $row->mere,
		        $row->qartresid,
		        $row->bp,
		        $row->nbrenf,
		        $row->email,
		        $row->portable,
		        $row->formation,
		        $row->lieunais
            );
            $i++;
        }
		
          $this->view->data = $responce;
        
		} else if($code_membre!="" && $nom!="") {
          $select=$tabela->select();
          $select->from($tabela)
                 ->where('numidentp like ?', '%'.$code_membre.'%')
                 ->where('nom like ?', '%'.$nom . '%')
			     ->where('etat_contrat = ?', 0)
	             ->order('nom asc');
	      $cats = $tabela->fetchAll($select);
          $count = count($cats);

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
            $responce['rows'][$i]['id'] = $row->numidentp;
            $responce['rows'][$i]['cell'] = array(
                 $row->numidentp,
                 $row->nom,
                 $row->prenom,
                 $row->sexe,
                 $row->prof,
                 $row->tel,
                 $row->ville, 
                 $row->pere,
                 $row->mere,
		         $row->qartresid,
		         $row->bp,
		         $row->nbrenf,
		         $row->email,
		         $row->portable,
		         $row->formation,
		         $row->lieunais
            );
            $i++;
        } 
        $this->view->data = $responce;
        }
        else if($code_membre!="" && $prenom!="") {
        $select=$tabela->select();
        $select->from($tabela)
               ->where('physique.numidentp like ?', '%'.$code_membre.'%')
               ->where('prenom like ?', '%'.$prenom.'%')
			   ->where('etat_contrat = ?', 0)
	       ->order('prenom asc');
	$cats = $tabela->fetchAll($select);
        $count = count($cats);

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
            $responce['rows'][$i]['id'] = $row->numidentp;
            $responce['rows'][$i]['cell'] = array(
                 $row->numidentp,
                 $row->nom,
                 $row->prenom,
                 $row->sexe,
                 $row->prof,
                 $row->tel,
                 $row->ville, 
                 $row->pere,
                 $row->mere,
		         $row->qartresid,
		         $row->bp,
		         $row->nbrenf,
		         $row->email,
		         $row->portable,
		         $row->formation,
		         $row->lieunais
            );
            $i++;
        } 
        $this->view->data = $responce;
        }
        else if($nom!="" && $prenom!="") {
        $select=$tabela->select();
        $select->from($tabela)
               ->where('nom like ?', '%'.$nom.'%')
               ->where('prenom like ?', '%'.$prenom.'%')
			   ->where('numidentp like ?', '%P')
			   ->where('etat_contrat = ?', 0)
	        ->order('nom asc');
	$cats = $tabela->fetchAll($select);
        $count = count($cats);

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
            $responce['rows'][$i]['id'] = $row->numidentp;
            $responce['rows'][$i]['cell'] = array(
                 $row->numidentp,
                 $row->nom,
                 $row->prenom,
                 $row->sexe,
                 $row->prof,
                 $row->tel,
                 $row->ville, 
                 $row->pere,
                 $row->mere,
		         $row->qartresid,
		         $row->bp,
		         $row->nbrenf,
		         $row->email,
		         $row->portable,
		         $row->formation,
		         $row->lieunais
            );
            $i++;
        } 
        $this->view->data = $responce;
        }
        else if($code_membre!="") {
        $select=$tabela->select();
        $select->from($tabela)
               ->where('numidentp like ?', '%'.$code_membre.'%')
			   ->where('etat_contrat = ?', 0)
			   ;
	$cats = $tabela->fetchAll($select);
        $count = count($cats);

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
            $responce['rows'][$i]['id'] = $row->numidentp;
            $responce['rows'][$i]['cell'] = array(
                $row->numidentp,
                $row->nom,
                $row->prenom,
                $row->sexe,
                $row->prof,
                $row->tel,
                $row->ville, 
                $row->pere,
                $row->mere,
		        $row->qartresid,
		        $row->bp,
		        $row->nbrenf,
		        $row->email,
		        $row->portable,
		        $row->formation,
		        $row->lieunais
            );
            $i++;
        } 
        $this->view->data = $responce;
        }
        else if($nom!="") {
        $select=$tabela->select();
        $select->from($tabela)
               ->where('nom like ?', '%'.$nom.'%')
			   ->where('numidentp like ?', '%P')
			   ->where('etat_contrat = ?', 0)
	       ->order('nom asc');
	$cats = $tabela->fetchAll($select);
        $count = count($cats);

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
            $responce['rows'][$i]['id'] = $row->numidentp;
            $responce['rows'][$i]['cell'] = array(
            $row->numidentp,
            $row->nom,
            $row->prenom,
            $row->sexe,
            $row->prof,
            $row->tel,
            $row->ville, 
            $row->pere,
            $row->mere,
		    $row->qartresid,
		    $row->bp,
		    $row->nbrenf,
		    $row->email,
		    $row->portable,
		    $row->formation,
		    $row->lieunais
            );
            $i++;
        } 
        $this->view->data = $responce;
			   
			   
        }
        else if($prenom!="") {
        $select=$tabela->select();
        $select->from($tabela)
               ->where('prenom like ?', '%'.$prenom.'%')
			   ->where('numidentp like ?', '%P')
			   ->where('etat_contrat = ?', 0)
	       ->order('prenom asc');
	     $cats = $tabela->fetchAll($select);
        $count = count($cats);

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
            $responce['rows'][$i]['id'] = $row->numidentp;
            $responce['rows'][$i]['cell'] = array(
            $row->numidentp,
            $row->nom,
            $row->prenom,
            $row->sexe,
            $row->prof,
            $row->tel,
            $row->ville, 
            $row->pere,
            $row->mere,
		    $row->qartresid,
		    $row->bp,
		    $row->nbrenf,
		    $row->email,
		    $row->portable,
		    $row->formation,
		    $row->lieunais
            );
            $i++;
        } 
        $this->view->data = $responce;		   
        }   
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


}
?>