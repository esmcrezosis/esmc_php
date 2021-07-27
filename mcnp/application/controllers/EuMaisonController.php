<?php

class EuMaisonController extends Zend_Controller_Action {
    
      public function init() {
          
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = trim($user->code_groupe);
        if ($group == 'scmdm' or  $group == 'scmsgm' or  $group == 'scmgm') {
            $menu = "<li><a id=\"new\" href=\"/eu-maison/new\" style=\"font-size:9px\">Mise sur chaine ose</a></li>".
			        "<li><a id=\"new\" href=\"/eu-maison/newei\" style=\"font-size:9px\">Mise sur chaine ei</a></li>".
				    "<li><a id=\"new\" href=\"/eu-maison/newrep\" style=\"font-size:9px\">Représentations</a></li>".
                    "<li><a id=\"liste\" href=\"/eu-maison/index\" style=\"font-size:9px\">Liste Maisons</a></li>" .
				    "<li><a id=\"liste\" href=\"/eu-maison/representation\" style=\"font-size:9px\">Liste Representation</a></li>" .
                    "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:9px\">Changer le mot de passe</a></li>";
            $this->view->placeholder("menu")->set($menu);
            $this->view->jQuery()->enable();
            $this->view->jQuery()->uiEnable();
          
        } if ($group == 'scmpmam') {
            $menu = "<li><a id=\"new\" href=\"/eu-maison/new\" style=\"font-size:9px\">Mise sur chaine ose</a></li>".
			        "<li><a id=\"new\" href=\"/eu-maison/newei\" style=\"font-size:9px\">Mise sur chaine ei</a></li>".
				    "<li><a id=\"new\" href=\"/eu-maison/newrep\" style=\"font-size:9px\">Représentations</a></li>".
                    "<li><a id=\"liste\" href=\"/eu-maison/index\" style=\"font-size:9px\">Liste Maisons</a></li>" .
				    "<li><a id=\"liste\" href=\"/eu-maison/representation\" style=\"font-size:9px\">Liste Representantion</a></li>" .
                    "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:9px\">Changer le mot de passe</a></li>";
            $this->view->placeholder("menu")->set($menu);
            $this->view->jQuery()->enable();
            $this->view->jQuery()->uiEnable();
          
        }
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
        } else {
            $user = $auth->getIdentity();
            $group = trim($user->code_groupe);
            if ($user->code_agence == null) {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            if ($group != 'scmgm' and  $group != 'scmsgm' and  $group != 'scmdm' and  $group != 'scmpmam') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }
    
    
    public function indexAction() {
            $request = $this->_request;
            if ($request->isXmlHttpRequest()) {
              $this->_helper->layout->disableLayout();
            }
    }
	
	public function representationAction() {
	        $request = $this->_request;
            if ($request->isXmlHttpRequest()) {
              $this->_helper->layout->disableLayout();
            }
	}
	
	
    
    public function membreAction() {
           $data = array();
           $membre = new Application_Model_DbTable_EuMaison();
           $select = $membre->select();
           $select->from($membre, array('code_membre'));
           $result = $membre->fetchAll($select);
           foreach ($result as $m) {
              $data[] = $m->code_membre;
           }
           $this->view->data = $data;
    }
    
    
    
    public function newquartierAction() {
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $lib_quartier = $_GET['lib_quartier'];
           $ville = $_GET['ville'];
           $date = new Zend_Date(Zend_Date::ISO_8601);
           $date_op = clone $date;
           $mquart = new Application_Model_EuQuartierMapper();
           $quart = new Application_Model_EuQuartier();
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
                 
                 //Enregistrement dans la table quartier
                 $quart->setLib_quartier($lib_quartier)
                       ->setDate_create($date_op->toString('yyyy-MM-dd'))
                       ->setId_ville($ville)
                       ->setId_utilisateur($user->id_utilisateur);
                 $mquart->save($quart);
                 $db->commit();
                 $this->view->data = 'good';
                 return;  
            }
            catch (Exception $exc) {
              $db->rollback();
              $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
              $this->view->message = $message;
              $this->view->data = 'bad';
              return;       
            }  
    }
    
	
	
	
	public function newrepAction() {
	
	
	
	
	} 
	
	
	
	
	
	
    public function newtypeAction() {
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $lib_type = $_GET['lib_type'];
            $date = new Zend_Date(Zend_Date::ISO_8601);
            $date_op = clone $date;
            $mmais = new Application_Model_EuTypeMaisonMapper();
            $mais = new Application_Model_EuTypeMaison();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Enregistrement dans la table type_maison
                $mais->setLib_type_maison($lib_type)
                     ->setId_utilisateur($user->id_utilisateur)
                     ->setDate_create($date_op->toString('yyyy-MM-dd'));
                $mmais->save($mais);
                $db->commit();
                $this->view->data = 'good';
                return;  
            }
            catch (Exception $exc) {
                $db->rollback();
                $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                $this->view->message = $message;
                $this->view->data = 'bad';
                return;       
           }
    }
    
   
    public function statutAction() {
        $type = $_GET["type"];
        if ($type == '') {
            $type = '%';
        }
        $t_stat = new Application_Model_DbTable_EuStatutJuridique();
        $select = $t_stat->select();
        $select->where('type_statut like ?',$type);
        $results = $t_stat->fetchAll($select);
        if (count($results) > 0) {
            $data = array();
            foreach ($results as $value) {
              $data[] = $value->code_statut;
            }
        }
        $this->view->data = $data;
    }
   
    
    public function typecontratAction() {
         
        $gac = array(array());
        $tab = new Application_Model_DbTable_EuTypeContrat();
        $sel = $tab->select();
        $tgac = $tab->fetchAll($sel);
        $i = 0;
        foreach ($tgac as $value) {
            $gac[$i][1] = $value->id_type_contrat;
            $gac[$i][2] = ucfirst($value->libelle_type_contrat);
            $i++;
        }
        $this->view->data = $gac;
        
    }
   
    public function typecreneauAction() {
         
        $creneau = array(array());
        $tab = new Application_Model_DbTable_EuTypeCreneau();
        $sel = $tab->select();
        $tcreneau = $tab->fetchAll($sel);
        $i = 0;
        foreach ($tcreneau as $value) {
             $creneau[$i][1] = $value->id_type_creneau;
             $creneau[$i][2] = ucfirst($value->libelle_type_creneau);
             $i++;
        }
        $this->view->data = $creneau; 
    }
    
    public function typeacteurAction() {
	 
        $acteur = array(array());
        $tab = new Application_Model_DbTable_EuTypeActeur();
        $sel = $tab->select();
        $tacteur = $tab->fetchAll($sel);
        $i = 0;
        foreach ($tacteur as $value) {
             $acteur[$i][1] = $value->id_type_acteur;
             $acteur[$i][2] = ucfirst($value->lib_type_acteur);
             $i++;
        }
        $this->view->data = $acteur;  
    }
    
    
    public function newvilleAction() {
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $lib_ville = $_GET['lib_ville'];
            $pays = $_GET['pays'];
            $date = new Zend_Date(Zend_Date::ISO_8601);
            $date_op = clone $date;
            $mvil = new Application_Model_EuVilleMapper();
            $vil = new Application_Model_EuVille();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //Enregistrement dans la table ville
                $vil->setLib_ville($lib_ville)
                    ->setDate_create($date_op->toString('yyyy-MM-dd'))
                    ->setId_pays($pays)
                    ->setId_utilisateur($user->id_utilisateur)
                    ;
                $mvil->save($vil);
                $db->commit();
                $this->view->data = 'good';
                return;  
            }
            catch (Exception $exc) {
              $db->rollback();
              $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
              $this->view->message = $message;
              $this->view->data = 'bad';
              return;       
            }
    }
    
    public function typemaisonAction() {
        $t_type = new Application_Model_DbTable_EuTypeMaison();
        $types = $t_type->fetchAll();
        if (count($types) >= 1) {
            $data = array();
            for ($i = 0; $i < count($types); $i++) {
                $value = $types[$i];
                $data[$i][0] = $value->id_type_maison;
                $data[$i][1] = $value->lib_type_maison;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
    
    public function villeAction() {
        $t_ville = new Application_Model_DbTable_EuVille();
        $select= $t_ville->select();
        $select->order('lib_ville', 'asc') ;
        $villes = $t_ville->fetchAll($select);
        if (count($villes) >= 1) {
            $data = array();
            for ($i = 0; $i < count($villes); $i++) {
                 $value = $villes[$i];
                 $data[$i][0] = $value->id_ville;
                 $data[$i][1] = $value->lib_ville;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
    
    public function paysAction() {
        $t_pays = new Application_Model_DbTable_EuPays();
        $pays = $t_pays->fetchAll();
        if (count($pays) >= 1) {
            $data = array();
            for ($i = 0; $i < count($pays); $i++) {
                 $value = $pays[$i];
                 $data[$i][0] = $value->id_pays;
                 $data[$i][1] = $value->libelle_pays;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
   
    
    public function proprioAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $t_proprio = new Application_Model_DbTable_EuProprietaire();
        $select = $t_proprio->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_membre', 'eu_membre.code_membre = eu_proprietaire.code_membre_pro')
               ->where('eu_proprietaire.id_utilisateur = ?', $user->id_utilisateur)
               ->order('nom_membre asc')
               ->order('prenom_membre asc') ; 
        
        $proprio = $t_proprio->fetchAll($select);
        if (count($proprio) >= 1) {
            $data = array();
            for ($i = 0; $i < count($proprio); $i++) {
                $value = $proprio[$i];
                $data[$i][0] = $value->id_proprietaire;
                $data[$i][1] = $value->nom_membre."  ".$value->prenom_membre;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
    
    
    public function quartierAction() {
        if(isset($_GET['id_ville'])){
        $t_quartier = new Application_Model_DbTable_EuQuartier();
        $select = $t_quartier->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->join('eu_ville', 'eu_ville.id_ville = eu_quartier.id_ville')
               ->where('eu_quartier.id_ville = ?',$_GET['id_ville'])
               ->order('lib_quartier asc') ;
        
        $quartier = $t_quartier->fetchAll($select);
        if (count($quartier) >= 1) {
            $data = array();
            for ($i = 0; $i < count($quartier); $i++) {
                $value = $quartier[$i];
                $data[$i][0] = $value->id_quartier;
                $data[$i][1] = $value->lib_quartier;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
        }
    }
    
	
	public function datarepAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 200000);
           $sidx = $this->_request->getParam("sidx", 'code_membre');
           $sord = $this->_request->getParam("sord", 'desc');
		   
		   $request = $this->getRequest();
           $membre = $request->membre;
		   $code_membre = $request->code_membre;
		   
		   
		   $tabela = new Application_Model_DbTable_EuRepresentation();
           $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           if ($membre != "" && $code_membre != "") {
           $select->setIntegrityCheck(false) 
                  ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre')
                  ->where('eu_representation.code_membre_morale = ?',$membre) 
				  ->where('eu_representation.code_membre = ?',$code_membre)
                  ->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur)
				 
				  ;
            } elseif($membre != "") {
		     $select->setIntegrityCheck(false) 
                    ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre')
                    ->where('eu_representation.code_membre_morale = ?',$membre) 
                    ->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur);
		    } elseif($code_membre != "") {
		     $select->setIntegrityCheck(false) 
                    ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre')
                    ->where('eu_representation.code_membre = ?',$code_membre) 
                    ->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur);
		    }
            else {
             $select->setIntegrityCheck(false) 
                    ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre') 
                    ->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur)
					->order('eu_representation.code_membre_morale')
					;    
            }
		   
		   $representations = $tabela->fetchAll($select);
           $count = count($representations);
           if ($count > 0) {
            $total_pages = ceil($count / $limit);
           } 
           else 
           {
            $total_pages = 0;
           }
           if ($page > $total_pages)
            $page = $total_pages;
            $maisons = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($representations as $row) {
               $datecreation = new Zend_Date($row->date_creation);
               $responce['rows'][$i]['id'] = $row->code_membre."-".$row->code_membre_morale;
               $responce['rows'][$i]['cell'] = array(
				   $row->code_membre."-".$row->code_membre_morale,
				   $row->code_membre_morale,
                   $row->code_membre,
                   $row->nom_membre,
			       $row->prenom_membre,
                   $datecreation->toString('dd/MM/yyyy'),
                   $row->titre,
				   $row->etat
            );
            $i++;
        }      
        $this->view->data = $responce;
		   	   
	}
	
	
	
	
	
    public function dataAction()  {
        
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 200000);
           $sidx = $this->_request->getParam("sidx", 'id_maison');
           $sord = $this->_request->getParam("sord", 'desc');
           
           $request = $this->getRequest();
           $membre = $request->membre;
           
           $tabela = new Application_Model_DbTable_EuMaison();
           $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           if ($membre != "") {
           $select->setIntegrityCheck(false) 
                  ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_maison.code_membre')
                  ->where('eu_maison.code_membre = ?',$membre) 
                  ->where('eu_maison.id_utilisateur = ?',$user->id_utilisateur);
           }
           else {
             $select->setIntegrityCheck(false) 
                    ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_maison.code_membre') 
                    ->where('eu_maison.id_utilisateur = ?',$user->id_utilisateur);    
           }
           $maisons = $tabela->fetchAll($select);
           $count = count($maisons);
           if ($count > 0) {
            $total_pages = ceil($count / $limit);
           } 
           else 
           {
            $total_pages = 0;
           }
           if ($page > $total_pages)
            $page = $total_pages;
            $maisons = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
            $responce['page'] = $page;
            $responce['total'] = $total_pages;
            $responce['records'] = $count;
            $i = 0;
            foreach ($maisons as $row) {
            //$date = new Zend_Date($row->date_contrat, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_maison;
            $responce['rows'][$i]['cell'] = array(
              $row->num_maison,
              $row->code_membre,
			  $row->code_type_acteur,
              $row->designation,
              $row->type_maison,
              $row->quartier
            );
            $i++;
        }      
        $this->view->data = $responce;
        
    } 
    
	public function membrephysAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
		$select->where('code_membre like ?','%P');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }
    
	public function recupnomAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	
	public function octroiAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
		   $user = $auth->getIdentity();
           $selection = array();
           $selection = $_GET['lignes'];
           $rep_map = new Application_Model_EuRepresentationMapper();
           $rep = new Application_Model_EuRepresentation();
		   $utilisateur_map = new Application_Model_EuUtilisateurMapper();
		   $utilisateur = new Application_Model_EuUtilisateur() ;
		   $membre = new Application_Model_EuMembre();
		   $membre_map = new Application_Model_EuMembreMapper();
		   $membremorale = new Application_Model_EuMembreMorale();
		   $membremorale_map = new Application_Model_EuMembreMoraleMapper(); 
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
		     foreach ($selection as $sel) {
			    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
			    $p_m = $sel['physique_morale'];
			    $p_m = explode("-",$p_m);
			    $p = $p_m[0];
			    $m = $p_m[1];
				$ret = $rep_map->find($p,$m,$rep);
				$findmembremorale = $membremorale_map->find($m,$membremorale);
				$code_type_acteur = $membremorale->getCode_type_acteur();
				$findrepresentation = $rep_map->findbyrep($m);
				$reponse = $rep_map->find($findrepresentation->getCode_membre(),$m,$rep);
				
				if($user->code_groupe == 'scmgm' && $code_type_acteur == 'EI') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'oe_grossiste');
				} elseif($user->code_groupe == 'scmsgm' && $code_type_acteur == 'EI') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'oe_semi_grossiste');
				} elseif($user->code_groupe == 'scmdm' && $code_type_acteur == 'EI') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'oe_detaillant');
				} elseif($user->code_groupe == 'scmsgm' && $code_type_acteur == 'OSE') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'ose_semi_grossiste');
				} elseif($user->code_groupe == 'scmdm' && $code_type_acteur == 'OSE') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'ose_detaillant');
				} elseif($user->code_groupe == 'scmgm' && $code_type_acteur == 'OSE') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'ose_grossiste');
				}	
				$resultat = $utilisateur_map->find($finduser->getId_utilisateur(),$utilisateur);
				$result   = $membre_map->find($p,$membre);
				
				if($resultat) {
				   $utilisateur->setNom_utilisateur($membre->getNom_membre());
				   $utilisateur->setPrenom_utilisateur($membre->getPrenom_membre());
				   $utilisateur_map->update($utilisateur);
				} 
				  
				  
				if ($reponse) {
				    $rep->setCode_membre($findrepresentation->getCode_membre());
				    $rep->setCode_membre_morale($findrepresentation->getCode_membre_morale());
				    $rep->setTitre($findrepresentation->getTitre());
				    $rep->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				    $rep->setId_utilisateur($findrepresentation->getId_utilisateur());
                    $rep->setEtat('outside');
                    $rep_map->update($rep);
                }
				if ($ret) {
				    $rep->setCode_membre($p);
				    $rep->setCode_membre_morale($m);
				    $rep->setTitre('Representant');
					$rep->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					$rep->setId_utilisateur($user->id_utilisateur);
                    $rep->setEtat('inside');
                    $rep_map->update($rep);
                }
		      }
			  
			$db->commit();
            $this->view->data = 'good';
            return;
			   
	        } catch (Exception $exc) {
               $db->rollback();
               $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
               $this->view->message = $message;
               $this->view->data = 'bad';
               return;
            }
	
	}
	
	
	
	public function inputAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $selection = array();
      $selection = $_GET['lignes'];
      $rep_map = new Application_Model_EuRepresentationMapper();
      $rep = new Application_Model_EuRepresentation();
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
            foreach ($selection as $sel) {
              $p_m = $sel['physique_morale'];
			  $p_m = explode("-",$p_m);
			  $p = $p_m[0];
			  $m = $p_m[1];
              $ret = $rep_map->find($p,$m,$rep);
			  $findrepresentation = $rep_map->findbyrep($m);
			  if (($findrepresentation != false)) {
			    $db->rollBack();
			    $this->view->data ="bad";                           
			    return;
		      } else if ($ret) {
                   $rep->setEtat('inside');
                   $rep_map->update($rep);
              }      
            }    
            $db->commit();
            $this->view->data = 'good';
            return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            $this->view->message = $message;
            $this->view->data = 'echec';
            return;
        }    
    }
	
	public function outputAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $selection = array();
      $selection = $_GET['lignes'];
      $rep_map = new Application_Model_EuRepresentationMapper();
      $rep = new Application_Model_EuRepresentation();
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          foreach ($selection as $sel) {
             $p_m = $sel['physique_morale'];
			 $p_m = explode("-", $p_m);
			 $p = $p_m[0];
			 $m = $p_m[1];
             $ret = $rep_map->find($p,$m,$rep);
             if ($ret) {
                $rep->setEtat('outside');
                $rep_map->update($rep);
             }
                 
          }    
          $db->commit();
          $this->view->data = 'good';
          return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            $this->view->message = $message;
            $this->view->data = 'bad';
            return;
        }    
    }
	
	
	
	public function representerAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
		   
		   if ($this->getRequest()->isPost()) {
		      $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
			  try {
			      $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $date_idd = clone $date_id; 
				  $rep_mapper = new Application_Model_EuRepresentationMapper();
                  $rep = new Application_Model_EuRepresentation();
				  $rep_table = new Application_Model_DbTable_EuRepresentation();
				  $code = $_POST["code_memb"];
				  $findrepresentation = $rep_mapper->findbyrep($code);
				       
				  //insertion dans la table eu_representation des membres personnes physiques résidents
                  $cpte = $_POST['cpteur'];
                  $i = 1;
				  $j = 2;
				  $code_ressnd = " ";
				  while ($i <= $cpte) {
				    $code_res = $_POST['code_res'.$i];
				    //$find_rep = $rep_mapper->find($code_res,$code,$rep);
					$findtablerep = $rep_table->find($code_res,$code);
					 $j = $i + 1;
					 if($cpte > 1)   {
					    while($j <= $cpte) {
						  $code_ressnd = $_POST['code_res'.$j];
						  if($code_res == $code_ressnd) {
							  $db->rollBack();
							  $this->view->data ="bad";                           
							  return;    
                          }
						  $j++;
						}
					 }
				     if(count($findtablerep) != 0) {
					   $db->rollBack();
					   $this->view->data ="echec";                           
					   return;
					 } elseif (($_POST['titre'.$i] == 'Representant') && ($findrepresentation != false)) {
					   $db->rollBack();
					   $this->view->data ="verifiertitre";                           
					   return;
					 } elseif($_POST['code_res' . $i] != '' && $_POST['nom_res' . $i] != '') {
					   $rep->setCode_membre_morale($code)
                           ->setCode_membre($_POST['code_res'.$i])
                           ->setTitre($_POST['titre'.$i])
						   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						   ->setId_utilisateur($user->id_utilisateur)
						   ->setEtat('inside')
						   ;
                       
					   $rep_mapper->save($rep);
					 
					 }
				     $i++;
				  } 
		          $db->commit();
                  $this->view->data = 'good';
                  return;
	            } catch (Exception $exc) {
                  $db->rollback();
				  $this->view->data = $exc->getMessage() . ': ' . $exc->getTraceAsString();
			      return;
			    }		
	        }
	
	}
	
	public function membremoralAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMaison();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }


    public function recupnom1Action() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[2] = $result->raison_sociale;  
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	
	public function neweiAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
		   $request = $this->getRequest();
		   $code_agence = $user->code_agence;
		   $fs = Util_Utils::getParametre('FS','valeur');
           $this->view->fs = $fs;
		   if ($this->getRequest()->isPost()) {
		        $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $code_sms = $_POST["code_sms"];
				$id_type_acteur = "";
				$id_type_creneau = "";
				$id_filiere = "";
				
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
				
				
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {
			        $frais_identification = trim($_POST["frais_identification"]);  
				    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
				    $agrement_mapper = new Application_Model_EuAgrementMapper();
			        $agrement        = new Application_Model_EuAgrement();
                    $sms = $sms_mapper->findByCreditCode($code_sms);
                    $agrement_filiere  =  $_POST["agrement_filiere"];
                    $agrement_acnev    =  $_POST["agrement_acnev"];
                    $agrement_technopole =  $_POST["agrement_technopole"]; 
					if($sms != null) {
					    $mont = $sms->getCreditAmount();
					    if ($mont == $frais_identification) {
                        if($sms->getMotif() != 'FS') {
					      $db->rollBack();
					      $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
						  $this->view->agrement_filiere = $_POST["agrement_filiere"];
                          $this->view->agrement_acnev = $_POST["agrement_acnev"];
					      $this->view->agrement_technopole = $_POST["agrement_technopole"];
					      $this->view->code_sms = $_POST["code_sms"];
					      $this->view->numero = $_POST["numero"];
					      $this->view->design = $_POST["design"];
					      $this->view->type_maison = $_POST["type_maison"];
					      $this->view->ville = $_POST["ville"];
					      $this->view->rue = $_POST["rue"];
					      $this->view->quartier = $_POST["quartier"];
					      $this->view->code_rep = $_POST["code_rep"];
                          $this->view->nom_rep = $_POST["nom_rep"];
                          $this->view->bp_membre = $_POST["bp_membre"];
                          $this->view->tel_membre = $_POST["tel_membre"];
                          $this->view->portable_membre = $_POST["portable_membre"];
                          $this->view->email_membre = $_POST["email_membre"];
                          $this->view->site_web = $_POST["site_web"];
                          return;    
					    }
				        
						//insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0,STR_PAD_LEFT);
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
							$id_type_acteur = $agrement->getId_type_acteur();
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_filiere = $agrement->getId_filiere();
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
							$resmembre = $mapper->find($agrement->getCode_membre_morale_agrement(),$membre);
							
							// insertion dans la table eu_membre
							$membre->setId_filiere($id_filiere);
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(htmlentities (addslashes (trim ($_POST["design"]))));
						    $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["numero"]);
                            $membre->setDomaine_activite(htmlentities (addslashes (trim ("Immobilière"))));
						    $membre->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))));
                            $membre->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))));
                            $membre->setQuartier_membre(htmlentities (addslashes (trim ($_POST["quartier"]))));
                            $membre->setVille_membre(htmlentities (addslashes (trim ($_POST["ville"]))));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($user->id_utilisateur);
                            $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('O');
						    $membre->setEtat_membre('N');
				            $mapper->save($membre);
							
							// insertion dans la table eu_acteurs_creneau
					        $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
							
							$acren->setNom_acteur(htmlentities (addslashes (trim ($_POST["design"]))));
                            $acren->setCode_membre($code);
							$acren->setId_type_acteur($id_type_acteur);

                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($user->id_utilisateur);
							$acren->setGroupe(trim($user->code_groupe));
							$acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
							
							
							$code_zone = $user->code_zone;
			                $code_acteur = $cm->getLastActeurByCrenau();
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
                           Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
						    
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
							
                        $maison = new Application_Model_EuMaison();
						$mapper_m = new Application_Model_EuMaisonMapper();
                        $compteur_maison = $mapper_m->findConuter() + 1;						   
						   
                          
						$maison->setId_maison($compteur_maison);
                        $maison->setDesignation($_POST["design"]);
                        $maison->setId_proprietaire(null);
                        $maison->setCode_membre($code);
                        $maison->setType_maison($_POST["type_maison"]);
                        if(isset($_POST['eau'])) {
                          $maison->setEau($_POST["eau"]);
						  $maison->setFrais_eau($_POST["frais_eau"]);
                        }
                        else {
                            $maison->setEau(0);
                            $maison->setFrais_eau(0);							
                        }
                        $maison->setDate_enregistrement($date_idd->toString('yyyy-MM-dd'));
                            if(isset($_POST['elect'])) {
                            $maison->setElectrifier($_POST['elect']);
							$maison->setFrais_electricite($_POST["frais_elect"]);
                        }
                        else {
                            $maison->setElectrifier(0);
                            $maison->setFrais_electricite(0);						
                        }
                        if(isset($_POST['wd'])) {
                           $maison->setWc_douche($_POST['wd']);
						   $maison->setFrais_vidange($_POST["frais_vidange"]);
                        }
                        else {
                            $maison->setWc_douche(0);
                            $maison->setFrais_vidange(0);							
                        }
						if(isset($_POST['tel'])) {
						  $maison->setTel($_POST["tel"]);
						  $maison->setFrais_tel($_POST["frais_tel"]);
                        }
                        else {
						    $maison->setTel(0);
                            $maison->setFrais_tel(0);							
                        }
						
						if(isset($_POST['loyer'])) {
						  $maison->setMontant_loyer($_POST["mt_loyer"]);
                        }
                        else {
                          $maison->setMontant_loyer(0);							
                        }
						  
						if(isset($_POST['autre_charge'])) {
						  $maison->setAutre_charge($_POST["frais_charge"]);
                        }
                        else {
                          $maison->setAutre_charge(0);							
                        } 
						 
						if(isset($_POST['radio_taxe'])) {
						  $maison->setTaxe($_POST["taxe"]);
                        }
                        else {
                          $maison->setTaxe(0);							
                        } 
		
                        if($_POST['numero'] != '') {
                             $maison->setNum_maison($_POST["numero"]);							
                        }
						else {
						     $maison->setNum_maison(null);
						}
						// insertion dans la table eu_maison
                        $maison->setStatut(0);
                        $maison->setDesc_maison($_POST["desc"]);
                        $maison->setRue($_POST["rue"]);
                        $maison->setNum_police_electricite($_POST["num_police"]);
                        $maison->setNum_compteur_eau($_POST["num_compteur"]);
                        $maison->setNum_ligne_tel($_POST["num_ligne"]);
                        $maison->setId_utilisateur($user->id_utilisateur);//$user->id_utilisateur
                        $maison->setQuartier($_POST["quartier"]);
                            
                        $mapper_m->save($maison);
                          
						} else {
				            $db->rollBack();
							$this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				            $this->view->agrement_filiere = $_POST["agrement_filiere"];
                            $this->view->agrement_acnev = $_POST["agrement_acnev"];
					        $this->view->agrement_technopole = $_POST["agrement_technopole"];
					        $this->view->code_sms = $_POST["code_sms"];
					        $this->view->numero = $_POST["numero"];
					        $this->view->design = $_POST["design"];
					        $this->view->type_maison = $_POST["type_maison"];
					        $this->view->ville = $_POST["ville"];
					        $this->view->rue = $_POST["rue"];
					        $this->view->quartier = $_POST["quartier"];
					        $this->view->code_rep = $_POST["code_rep"];
                            $this->view->nom_rep = $_POST["nom_rep"];
                            $this->view->bp_membre = $_POST["bp_membre"];
                            $this->view->tel_membre = $_POST["tel_membre"];
                            $this->view->portable_membre = $_POST["portable_membre"];
                            $this->view->email_membre = $_POST["email_membre"];
                            $this->view->site_web = $_POST["site_web"];
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
                            //$this->view->profession = $_POST["profession_membre"];
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
                               //$this->view->profession = $_POST["profession_membre"];
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
					    $select->where('code_acteur like ?', $user->code_acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $count = $c_acteur->findConuter() + 1;
						
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($user->id_utilisateur)
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
						
						//Récupération de la prk nr
                               $param = new Application_Model_EuParametresMapper();
                               $par = new Application_Model_EuParametres();
                               $prk = 0;
                               $par_prk = $param->find('prk', 'nr', $par);
                               if ($par_prk == true) {
                                   $prk = $par->getMontant();
                               }
					   
					           $te_mapper = new Application_Model_EuTegcMapper();
                               $te = new Application_Model_EuTegc();
                               $code_te = 'TEGCP' .$id_filiere. $code;
                               $find_te = $te_mapper->find($code_te,$te);
                               if ($find_te == false) {
                                  $te->setCode_tegc($code_te)
                                     ->setId_filiere($id_filiere)
                                     ->setMdv($prk)
                                     ->setCode_membre($code)
                                     ->setMontant(0)
									 ->setMontant_utilise(0)
							         ->setSolde_tegc(0);
                                 $te_mapper->save($te);
                                } else {
                                     $te->setId_filiere($id_filiere);
                                     $te->setMdv($prk);
                                     $te_mapper->update($te);
                                }
					
					//Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
				             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());
					
					$sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);
					
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
					
					
					
					// table eu_utilisateur
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();
                    $user_mapper = new Application_Model_EuUtilisateurMapper();
		            $userin = new Application_Model_EuUtilisateur();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
					
					if($_POST["type_acteur"] == 'EI' && $id_type_acteur == 3) {
                        $userin->setCode_groupe('oe_detaillant');
                        $userin->setCode_gac_filiere('oe_detaillant');
						$userin->setCode_groupe_create('oe_detaillant');
                    } elseif($_POST["type_acteur"] == 'EI' && $id_type_acteur == 2) {
                        $userin->setCode_groupe('oe_semi_grossiste');
                        $userin->setCode_gac_filiere(null);
						$userin->setCode_groupe_create('oe_semi_grossiste');
                    } elseif($_POST["type_acteur"] == 'EI' && $id_type_acteur == 1) {
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
						
						
			     } else {
				    $db->rollback();
					$this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
				    $this->view->agrement_filiere = $_POST["agrement_filiere"];
                    $this->view->agrement_acnev = $_POST["agrement_acnev"];
					$this->view->agrement_technopole = $_POST["agrement_technopole"];
					$this->view->code_sms = $_POST["code_sms"];
					$this->view->numero = $_POST["numero"];
					$this->view->design = $_POST["design"];
					$this->view->type_maison = $_POST["type_maison"];
					$this->view->ville = $_POST["ville"];
					$this->view->rue = $_POST["rue"];
					$this->view->quartier = $_POST["quartier"];
					$this->view->code_rep = $_POST["code_rep"];
                    $this->view->nom_rep = $_POST["nom_rep"];
                    $this->view->bp_membre = $_POST["bp_membre"];
                    $this->view->tel_membre = $_POST["tel_membre"];
                    $this->view->portable_membre = $_POST["portable_membre"];
                    $this->view->email_membre = $_POST["email_membre"];
                    $this->view->site_web = $_POST["site_web"];
                    return;
				}			
							
							
					} else {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier"];
                       $this->view->ville_membre = $_POST["ville"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       //$this->view->profession = $_POST["profession_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
                }  
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp!!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('index', 'eu-maison', null, array('controller' => 'eu-maison', 'action' => 'index'));   
			 	 
			    } catch (Exception $exc) {
                    $db->rollback();
					$this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
					$this->view->agrement_filiere = $_POST["agrement_filiere"];
                    $this->view->agrement_acnev = $_POST["agrement_acnev"];
					$this->view->agrement_technopole = $_POST["agrement_technopole"];
					$this->view->code_sms = $_POST["code_sms"];
					$this->view->numero = $_POST["numero"];
					$this->view->design = $_POST["design"];
					$this->view->type_maison = $_POST["type_maison"];
					$this->view->ville = $_POST["ville"];
					$this->view->rue = $_POST["rue"];
					$this->view->quartier = $_POST["quartier"];
					$this->view->code_rep = $_POST["code_rep"];
                    $this->view->nom_rep = $_POST["nom_rep"];
                    $this->view->bp_membre = $_POST["bp_membre"];
                    $this->view->tel_membre = $_POST["tel_membre"];
                    $this->view->portable_membre = $_POST["portable_membre"];
                    $this->view->email_membre = $_POST["email_membre"];
                    $this->view->site_web = $_POST["site_web"];
                    return;
				   
			    }
		   
		   
		    }
	}
	
	
    public function newAction() {  
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		$request = $this->getRequest();
		$code_agence = $user->code_agence;
		$fs = Util_Utils::getParametre('FS','valeur');
        $this->view->fs = $fs;
        if ($this->getRequest()->isPost()) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
            $code_sms = $_POST["code_sms"];
			$id_type_acteur = "";
			$id_type_creneau = "";
			$id_filiere = "";
			
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
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
		    try {
			    $frais_identification = trim($_POST["frais_identification"]);  
				$sms_mapper = new Application_Model_EuSmsmoneyMapper();
				$agrement_mapper = new Application_Model_EuAgrementMapper();
			    $agrement        = new Application_Model_EuAgrement();
                $sms = $sms_mapper->findByCreditCode($code_sms);
				   
                $agrement_filiere  =  $_POST["agrement_filiere"];
                $agrement_acnev    =  $_POST["agrement_acnev"];
                $agrement_technopole =  $_POST["agrement_technopole"];
			
			    if ($sms != null)  {
			        $mont = $sms->getCreditAmount();
					if ($mont == $frais_identification) {
                        if($sms->getMotif() != 'FS') {
					      $db->rollBack();
					      $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
						  $this->view->agrement_filiere = $_POST["agrement_filiere"];
                          $this->view->agrement_acnev = $_POST["agrement_acnev"];
					      $this->view->agrement_technopole = $_POST["agrement_technopole"];
					      $this->view->code_sms = $_POST["code_sms"];
					      $this->view->numero = $_POST["numero"];
					      $this->view->design = $_POST["design"];
					      $this->view->type_maison = $_POST["type_maison"];
					      $this->view->ville = $_POST["ville"];
					      $this->view->rue = $_POST["rue"];
					      $this->view->quartier = $_POST["quartier"];
					      $this->view->code_rep = $_POST["code_rep"];
                          $this->view->nom_rep = $_POST["nom_rep"];
                          $this->view->bp_membre = $_POST["bp_membre"];
                          $this->view->tel_membre = $_POST["tel_membre"];
                          $this->view->portable_membre = $_POST["portable_membre"];
                          $this->view->email_membre = $_POST["email_membre"];
                          $this->view->site_web = $_POST["site_web"];
                          return;    
					    }
				        
						//insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, str_pad_left);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
						
						
						
						//insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
						
						$trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
				        
						if($trouveagrementf != false) {
				            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
							$id_type_acteur = $agrement->getId_type_acteur();
						    $id_type_creneau = $agrement->getId_type_creneau();
							$id_filiere = $agrement->getId_filiere();
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
							$resmembre = $mapper->find($agrement->getCode_membre_morale_agrement(),$membre);
							
							$membre->setId_filiere($id_filiere);
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(htmlentities (addslashes (trim ($_POST["design"]))));
						    $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["numero"]);
                            $membre->setDomaine_activite(htmlentities (addslashes (trim ("Immobilière"))));
						    $membre->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))));
                            $membre->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))));
                            $membre->setQuartier_membre(htmlentities (addslashes (trim ($_POST["quartier"]))));
                            $membre->setVille_membre(htmlentities (addslashes (trim ($_POST["ville"]))));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($user->id_utilisateur);
                            $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('O');
						    $membre->setEtat_membre('N');
				            $mapper->save($membre);
							
							// eu_acteurs_creneau
					        $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
							
							$acren->setNom_acteur(htmlentities (addslashes (trim ($_POST["design"]))));
                            $acren->setCode_membre($code);
							$acren->setId_type_acteur($id_type_acteur);

                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($user->id_utilisateur);
							$acren->setGroupe(trim($user->code_groupe));
							$acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
							
							
							$code_zone = $user->code_zone;
			                $code_acteur = $cm->getLastActeurByCrenau();
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
							
						    // eu_operation
                            Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
						    
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
						   
						    // controle
						    //$cpte = $_POST['cpteur'];
                            //$i = 1;
							//$code_ressnd = " ";
							//while ($i <= $cpte) {
							
							//  $i++;
							//}
							/*
						    //insertion dans la table eu_representation des membres personnes physiques résidents
                            $cpte = $_POST['cpteur'];
                            $i = 1;
							$j = 2;
							$code_rep = $_POST['code_rep'];
							$code_ressnd = " ";
                            while ($i <= $cpte) {
							    $j = $i + 1;
							    $code_res = $_POST['code_res'.$i];
							    if($cpte > 1)   {
                                   	while($j <= $cpte) {							
								    $code_ressnd = $_POST['code_res'.$j];
                                    $find_res = $rep_mapper->find($code,$_POST['code_res'.$i],$rep);
								    if(($find_res == true) || ($code_res == $code_ressnd) || ($code_res == $code_rep)) {
								         $db->rollBack();
							             $this->view->message = "Le membre personne physique $code_res ne peut appartenir  plusieurs fois à une même maison !!!";
				                         $this->view->agrement_filiere = $_POST["agrement_filiere"];
                                         $this->view->agrement_acnev = $_POST["agrement_acnev"];
					                     $this->view->agrement_technopole = $_POST["agrement_technopole"];
					                     $this->view->code_sms = $_POST["code_sms"];
					                     $this->view->numero = $_POST["numero"];
					                     $this->view->design = $_POST["design"];
					                     $this->view->type_maison = $_POST["type_maison"];
					                     $this->view->ville = $_POST["ville"];
					                     $this->view->rue = $_POST["rue"];
					                     $this->view->quartier = $_POST["quartier"];
					                     $this->view->code_rep = $_POST["code_rep"];
                                         $this->view->nom_rep = $_POST["nom_rep"];
                                         $this->view->bp_membre = $_POST["bp_membre"];
                                         $this->view->tel_membre = $_POST["tel_membre"];
                                         $this->view->portable_membre = $_POST["portable_membre"];
                                         $this->view->email_membre = $_POST["email_membre"];
                                         $this->view->site_web = $_POST["site_web"];
                                         return;    
                                    }
									$j++;
								  }	
							    } else {
                                        if(($find_res == true) || ($code_res == $code_rep)) {
								           $db->rollBack();
							               $this->view->message = "Le membre personne physique $code_res ne peut appartenir  plusieurs fois à une même maison !!!";
				                           $this->view->agrement_filiere = $_POST["agrement_filiere"];
                                           $this->view->agrement_acnev = $_POST["agrement_acnev"];
					                       $this->view->agrement_technopole = $_POST["agrement_technopole"];
					                       $this->view->code_sms = $_POST["code_sms"];
					                       $this->view->numero = $_POST["numero"];
					                       $this->view->design = $_POST["design"];
					                       $this->view->type_maison = $_POST["type_maison"];
					                       $this->view->ville = $_POST["ville"];
					                       $this->view->rue = $_POST["rue"];
					                       $this->view->quartier = $_POST["quartier"];
					                       $this->view->code_rep = $_POST["code_rep"];
                                           $this->view->nom_rep = $_POST["nom_rep"];
                                           $this->view->bp_membre = $_POST["bp_membre"];
                                           $this->view->tel_membre = $_POST["tel_membre"];
                                           $this->view->portable_membre = $_POST["portable_membre"];
                                           $this->view->email_membre = $_POST["email_membre"];
                                           $this->view->site_web = $_POST["site_web"];
                                           return;    
                                        }
								}
								if ($_POST['code_res' . $i] != '' && $_POST['nom_res' . $i] != '')  {
                                    $rep->setCode_membre_morale($code)
                                       ->setCode_membre($_POST['code_res'.$i])
                                       ->setTitre(null);
                                    $rep_mapper->save($rep);
                                }								   
                              
							  $i++;
	                        }
                            */							
                           
						    // Enrégistrement du proprietaire dans la table  eu_proprietaire
						    $proprio_mapper = new Application_Model_EuProprietaireMapper();
                            $prop = new Application_Model_EuProprietaire();
						    $proprio = $proprio_mapper->findProprio($_POST['code_rep']);
                        	if(!$proprio) {
							    $compteur_proprietaire = $proprio_mapper->findConuter() + 1;
						        $prop->setId_proprietaire($compteur_proprietaire)
						   		     ->setCode_membre_pro($_POST['code_rep'])
                               	     ->setCode_membre_ag($code)
						   		     ->setDate_declaration($date_idd->toString('yyyy-MM-dd'))
                               	     ->setId_utilisateur($user->id_utilisateur)
                               	     ->setNbre_maison(1);
                                $proprio_mapper->save($prop);
						    } else {
						        $find_pro = $proprio_mapper->find($proprio->getId_proprietaire(),$prop);
							    $prop->setNbre_maison($prop->getNbre_maison() + 1);
                                $proprio_mapper->update($prop);
						    }
						   
                            $maison = new Application_Model_EuMaison();
						    $mapper_m = new Application_Model_EuMaisonMapper();
                            $compteur_maison = $mapper_m->findConuter() + 1;						   
						   
                          
						$maison->setId_maison($compteur_maison);
                        $maison->setDesignation($_POST["design"]);
                        $maison->setId_proprietaire(null);
                        $maison->setCode_membre($code);
                        $maison->setType_maison($_POST["type_maison"]);
						
                        if(isset($_POST['eau'])) {
                          $maison->setEau($_POST["eau"]);
						  $maison->setFrais_eau($_POST["frais_eau"]);
                        }
                        else {
                            $maison->setEau(0);
                            $maison->setFrais_eau(0);							
                        }
                        $maison->setDate_enregistrement($date_idd->toString('yyyy-MM-dd'));
                            if(isset($_POST['elect'])) {
                            $maison->setElectrifier($_POST['elect']);
							$maison->setFrais_electricite($_POST["frais_elect"]);
                        }
                        else {
                            $maison->setElectrifier(0);
                            $maison->setFrais_electricite(0);						
                        }
                        if(isset($_POST['wd'])) {
                           $maison->setWc_douche($_POST['wd']);
						   $maison->setFrais_vidange($_POST["frais_vidange"]);
                        }
                        else {
                            $maison->setWc_douche(0);
                            $maison->setFrais_vidange(0);							
                        }
						if(isset($_POST['tel'])) {
						  $maison->setTel($_POST["tel"]);
						  $maison->setFrais_tel($_POST["frais_tel"]);
                        }
                        else {
						    $maison->setTel(0);
                            $maison->setFrais_tel(0);							
                        }
						
						if(isset($_POST['loyer'])) {
						  $maison->setMontant_loyer($_POST["mt_loyer"]);
                        }
                        else {
                          $maison->setMontant_loyer(0);							
                        }
						  
						if(isset($_POST['autre_charge'])) {
						  $maison->setAutre_charge($_POST["frais_charge"]);
                        }
                        else {
                          $maison->setAutre_charge(0);							
                        } 
						 
						if(isset($_POST['radio_taxe'])) {
						  $maison->setTaxe($_POST["taxe"]);
                        }
                        else {
                          $maison->setTaxe(0);							
                        } 
		
                        if($_POST['numero'] != '') {
                             $maison->setNum_maison($_POST["numero"]);							
                        }
						else {
						     $maison->setNum_maison(null);
						}
                        $maison->setStatut(0);
                        $maison->setDesc_maison($_POST["desc"]);
                        $maison->setRue($_POST["rue"]);
                        $maison->setNum_police_electricite($_POST["num_police"]);
                        $maison->setNum_compteur_eau($_POST["num_compteur"]);
                        $maison->setNum_ligne_tel($_POST["num_ligne"]);
                        $maison->setId_utilisateur($user->id_utilisateur);//$user->id_utilisateur
                        $maison->setQuartier($_POST["quartier"]);
                            
                        $mapper_m->save($maison);
                          
						} else {
				            $db->rollBack();
							$this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				            $this->view->agrement_filiere = $_POST["agrement_filiere"];
                            $this->view->agrement_acnev = $_POST["agrement_acnev"];
					        $this->view->agrement_technopole = $_POST["agrement_technopole"];
					        $this->view->code_sms = $_POST["code_sms"];
					        $this->view->numero = $_POST["numero"];
					        $this->view->design = $_POST["design"];
					        $this->view->type_maison = $_POST["type_maison"];
					        $this->view->ville = $_POST["ville"];
					        $this->view->rue = $_POST["rue"];
					        $this->view->quartier = $_POST["quartier"];
					        $this->view->code_rep = $_POST["code_rep"];
                            $this->view->nom_rep = $_POST["nom_rep"];
                            $this->view->bp_membre = $_POST["bp_membre"];
                            $this->view->tel_membre = $_POST["tel_membre"];
                            $this->view->portable_membre = $_POST["portable_membre"];
                            $this->view->email_membre = $_POST["email_membre"];
                            $this->view->site_web = $_POST["site_web"];
                            return;
				        }
						
						if($trouveagrementacnev != false) {
				            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
								
						} else {
				            $db->rollBack();
				            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				            $this->view->agrement_filiere = $_POST["agrement_filiere"];
                            $this->view->agrement_acnev = $_POST["agrement_acnev"];
					        $this->view->agrement_technopole = $_POST["agrement_technopole"];
					        $this->view->code_sms = $_POST["code_sms"];
					        $this->view->numero = $_POST["numero"];
					        $this->view->design = $_POST["design"];
					        $this->view->type_maison = $_POST["type_maison"];
					        $this->view->ville = $_POST["ville"];
					        $this->view->rue = $_POST["rue"];
					        $this->view->quartier = $_POST["quartier"];
					        $this->view->code_rep = $_POST["code_rep"];
                            $this->view->nom_rep = $_POST["nom_rep"];
                            $this->view->bp_membre = $_POST["bp_membre"];
                            $this->view->tel_membre = $_POST["tel_membre"];
                            $this->view->portable_membre = $_POST["portable_membre"];
                            $this->view->email_membre = $_POST["email_membre"];
                            $this->view->site_web = $_POST["site_web"];
                            return;
				        }
						
						if($trouveagrementtechno != false) {
				            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
								
						} else {
				               $db->rollBack();
				               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				               $this->view->agrement_filiere = $_POST["agrement_filiere"];
                               $this->view->agrement_acnev = $_POST["agrement_acnev"];
					           $this->view->agrement_technopole = $_POST["agrement_technopole"];
					           $this->view->code_sms = $_POST["code_sms"];
					           $this->view->numero = $_POST["numero"];
					           $this->view->design = $_POST["design"];
					           $this->view->type_maison = $_POST["type_maison"];
					           $this->view->ville = $_POST["ville"];
					           $this->view->rue = $_POST["rue"];
					           $this->view->quartier = $_POST["quartier"];
					           $this->view->code_rep = $_POST["code_rep"];
                               $this->view->nom_rep = $_POST["nom_rep"];
                               $this->view->bp_membre = $_POST["bp_membre"];
                               $this->view->tel_membre = $_POST["tel_membre"];
                               $this->view->portable_membre = $_POST["portable_membre"];
                               $this->view->email_membre = $_POST["email_membre"];
                               $this->view->site_web = $_POST["site_web"];
                               return;
				        }
						
						$filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($id_filiere,$filiere);
						
						
						
						$t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $user->code_acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $count = $c_acteur->findConuter() + 1;
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($user->id_utilisateur)
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
						
						//Récupération de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prk = 0;
                        $par_prk = $param->find('prk', 'nr', $par);
                        if ($par_prk == true) {
                           $prk = $par->getMontant();
                        }
					   
					    $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'TEGCP' .$id_filiere. $code;
                        $find_te = $te_mapper->find($code_te,$te);
                        if ($find_te == false) {
                           $te->setCode_tegc($code_te)
                              ->setId_filiere($id_filiere)
                              ->setMdv($prk)
                              ->setCode_membre($code)
                              ->setMontant(0)
							  ->setMontant_utilise(0)
							  ->setSolde_tegc(0);
                           $te_mapper->save($te);
                        } else {
                           $te->setId_filiere($id_filiere);
                           $te->setMdv($prk);
                           $te_mapper->update($te);
                        }
					
					//Creation du FS
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
				             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());
					
					$sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);
					
					// table eu_utilisateur
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();
                    $user_mapper = new Application_Model_EuUtilisateurMapper();
		            $userin = new Application_Model_EuUtilisateur();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
					
					if($_POST["type_acteur"] == 'ose' && $id_type_acteur == 3) {
                          $userin->setCode_groupe('ose_detaillant');
                          $userin->setCode_gac_filiere('ose_detaillant');
						  $userin->setCode_groupe_create('oe_detaillant');
                    } elseif($_POST["type_acteur"] == 'ose' && $id_type_acteur == 2) {
                          $userin->setCode_groupe('ose_semi_grossiste');
                          $userin->setCode_gac_filiere(null);
						  $userin->setCode_groupe_create('ose_semi_grossiste');
                    } elseif($_POST["type_acteur"] == 'ose' && $id_type_acteur == 1) {
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
				    $contrat->setId_type_contrat(3);
                    $contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    $mapper_contrat->save($contrat);
					
							
			        } else {
				        $db->rollback();
					    $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
				        $this->view->agrement_filiere = $_POST["agrement_filiere"];
                        $this->view->agrement_acnev = $_POST["agrement_acnev"];
					    $this->view->agrement_technopole = $_POST["agrement_technopole"];
					    $this->view->code_sms = $_POST["code_sms"];
					    $this->view->numero = $_POST["numero"];
					    $this->view->design = $_POST["design"];
					    $this->view->type_maison = $_POST["type_maison"];
					    $this->view->ville = $_POST["ville"];
					    $this->view->rue = $_POST["rue"];
					    $this->view->quartier = $_POST["quartier"];
					    $this->view->code_rep = $_POST["code_rep"];
                        $this->view->nom_rep = $_POST["nom_rep"];
                        $this->view->bp_membre = $_POST["bp_membre"];
                        $this->view->tel_membre = $_POST["tel_membre"];
                        $this->view->portable_membre = $_POST["portable_membre"];
                        $this->view->email_membre = $_POST["email_membre"];
                        $this->view->site_web = $_POST["site_web"];
                        return;
				    }
			
			}   else  {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->agrement_filiere = $_POST["agrement_filiere"];
                       $this->view->agrement_acnev = $_POST["agrement_acnev"];
					   $this->view->agrement_technopole = $_POST["agrement_technopole"];
					   $this->view->code_sms = $_POST["code_sms"];
					   $this->view->numero = $_POST["numero"];
					   $this->view->design = $_POST["design"];
					   $this->view->type_maison = $_POST["type_maison"];
					   $this->view->ville = $_POST["ville"];
					   $this->view->rue = $_POST["rue"];
					   $this->view->quartier = $_POST["quartier"];
					   $this->view->code_rep = $_POST["code_rep"];
                       $this->view->nom_rep = $_POST["nom_rep"];
                       $this->view->bp_membre = $_POST["bp_membre"];
                       $this->view->tel_membre = $_POST["tel_membre"];
                       $this->view->portable_membre = $_POST["portable_membre"];
                       $this->view->email_membre = $_POST["email_membre"];
                       $this->view->site_web = $_POST["site_web"];
                       return;
                }
				
				$compteur = Util_Utils::findConuter() + 1;
                Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP !!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                $db->commit();
                return $this->_helper->redirector('index', 'eu-maison', null, array('controller' => 'eu-maison', 'action' => 'index'));   
			} catch (Exception $exc) {
                    $db->rollback();
					$this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
					$this->view->agrement_filiere = $_POST["agrement_filiere"];
                    $this->view->agrement_acnev = $_POST["agrement_acnev"];
					$this->view->agrement_technopole = $_POST["agrement_technopole"];
					$this->view->code_sms = $_POST["code_sms"];
					$this->view->numero = $_POST["numero"];
					$this->view->design = $_POST["design"];
					$this->view->type_maison = $_POST["type_maison"];
					$this->view->ville = $_POST["ville"];
					$this->view->rue = $_POST["rue"];
					$this->view->quartier = $_POST["quartier"];
					$this->view->code_rep = $_POST["code_rep"];
                    $this->view->nom_rep = $_POST["nom_rep"];
                    $this->view->bp_membre = $_POST["bp_membre"];
                    $this->view->tel_membre = $_POST["tel_membre"];
                    $this->view->portable_membre = $_POST["portable_membre"];
                    $this->view->email_membre = $_POST["email_membre"];
                    $this->view->site_web = $_POST["site_web"];
                    return;
				   
			}		
		    	   
	    }  
    }
    
    public function mdetailAction() {
       
       $this->_helper->layout->disableLayout();
       $maison = new Application_Model_EuMaison();
               
       //$mapper->find($num_membre, $maison);
       //$this->view->membre = $maison;
           
       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $this->_helper->layout->disableLayout();
       //$page = $this->_request->getParam("page", 1);
       //$limit = $this->_request->getParam("rows", 200000);
       //$sidx = $this->_request->getParam("sidx", 'id_maison');
       //$sord = $this->_request->getParam("sord", 'desc');
           
       $request = $this->getRequest();
       $membre = $request->membre;
       
       $tabela = new Application_Model_DbTable_EuMaison();
       $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
       $select->setIntegrityCheck(false)
              ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_maison.code_membre')  
              //->join('eu_proprietaire', 'eu_proprietaire.id_proprietaire = eu_maison.id_proprietaire') 
              ->where('eu_maison.id_maison = ?',$membre);
       
       $maison = $tabela->fetchAll($select);
       foreach ($maison as $row) {
          $this->view->numero = $row->num_maison;
          $this->view->design = $row->designation;
          $this->view->type_acteur = $row->code_type_acteur;
          $this->view->statut_juridique = $row->code_statut;
          $this->view->code_membre = $row->code_membre;
          //$this->view->nom_membre = $row->code_membre_pro;
          $this->view->type_maison = $row->type_maison;
          $this->view->desc = $row->desc_maison;
          $this->view->quartier = $row->quartier;
          $this->view->rue = $row->rue;
          $this->view->frais_eau = $row->frais_eau;
          $this->view->num_compteur = $row->num_compteur_eau;
          $this->view->frais_elect = $row->frais_electricite;
          $this->view->num_police = $row->num_police_electricite;
          $this->view->frais_tel = $row->frais_tel;
          $this->view->num_ligne_tel = $row->num_ligne_tel;
          $this->view->frais_vidange = $row->frais_vidange;
          $this->view->taxe = $row->taxe;
		  $this->view->loyer = $row->montant_loyer;
		  $this->view->autre_charge = $row->autre_charge;
          $this->view->bp = $row->bp_membre;
          $this->view->tel_membre = $row->tel_membre;
          $this->view->portable_membre = $row->portable_membre;
          $this->view->email_membre = $row->email_membre;
          $this->view->site_web = $row->site_web;   
      }             
   }
   
    
    public function editAction()  {
       $this->_helper->layout->disableLayout();
       $request = $this->getRequest();
       $membre = $request->membre;    
       $tabela = new Application_Model_DbTable_EuMaison();
       $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
       $select->setIntegrityCheck(false)
              ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_maison.code_membre')  
              //->join('eu_proprietaire', 'eu_proprietaire.id_proprietaire = eu_maison.id_proprietaire') 
              ->where('eu_maison.id_maison = ?',$membre);
       
       $maison = $tabela->fetchAll($select);
       foreach ($maison as $row) {
         $this->view->code_membre = $row->code_membre;
         $this->view->id_maison = $row->id_maison;
         $this->view->numero = $row->num_maison;
         $this->view->design = $row->designation;
         $this->view->type_acteur = $row->code_type_acteur;
         $this->view->code_statut = $row->code_statut;
         //$this->view->proprio = $row->id_proprietaire;
         $this->view->type_maison = $row->type_maison;
         $this->view->desc = $row->desc_maison;
         $this->view->ville = $row->ville_membre;
         $this->view->quartier = $row->quartier;
         $this->view->rue = $row->rue;
         $this->view->eau = $row->eau;
         $this->view->elect = $row->electrifier;
         $this->view->wc_douche = $row->wc_douche;
         $this->view->frais_eau = $row->frais_eau;
         $this->view->num_compteur = $row->num_compteur_eau;
         $this->view->frais_elect = $row->frais_electricite;
         $this->view->num_police = $row->num_police_electricite;
         $this->view->frais_tel = $row->frais_tel;
         $this->view->num_ligne_tel = $row->num_ligne_tel;
         $this->view->frais_vidange = $row->frais_vidange;
         $this->view->taxe = $row->taxe;
		 $this->view->loyer = $row->montant_loyer;
		 $this->view->autre_charge = $row->autre_charge;
         $this->view->bp = $row->bp_membre;
         $this->view->tel_membre = $row->tel_membre;
         $this->view->portable_membre = $row->portable_membre;
         $this->view->email_membre = $row->email_membre;
         $this->view->site_web = $row->site_web;   
       }      
    }
    
    public function updateAction() {
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $code_agence = $user->code_agence;
           if ($this->getRequest()->isPost()) { 
              $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;
              $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
              try {
				  $mapper_m = new Application_Model_EuMembreMoraleMapper(); 
				  $membre = new Application_Model_EuMembreMorale();
				  		  
                  $find_membre = $mapper_m->find($_POST["code_membre"],$membre);
                  
				  $membre->setCode_membre_morale($_POST["code_membre"]);
                  $membre->setCode_type_acteur($_POST["type_acteur"]);
                  $membre->setCode_statut($_POST["statut_juridique"]);
                  $membre->setRaison_sociale(htmlentities (addslashes (trim ($_POST["design"]))));
                  $membre->setNum_registre_membre($_POST["numero"]);
                  $membre->setDomaine_activite("Immobilière");
				  $membre->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))));
                  $membre->setQuartier_membre(htmlentities (addslashes (trim ($_POST["quartier"]))));
                  $membre->setVille_membre(htmlentities (addslashes (trim ($_POST["ville"]))));
                  $membre->setBp_membre($_POST["bp_membre"]);
                  $membre->setTel_membre($_POST["tel_membre"]);
                  $membre->setEmail_membre($_POST["email_membre"]);
                  $membre->setPortable_membre($_POST["portable_membre"]);
                  $membre->setId_utilisateur($user->id_utilisateur);
                  $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                  $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
				  $mapper_m->update($membre);
				        
                  $maison = new Application_Model_EuMaison();
                  $mapper = new Application_Model_EuMaisonMapper();
                  $find_maison = $mapper->find($_POST["id_maison"],$maison);      
                  $maison->setId_maison($_POST["id_maison"]);
                  $maison->setDesignation($_POST["design"]);
                  $maison->setCode_membre($_POST["code_membre"]);
                  $maison->setType_maison($_POST["type_maison"]);
                  if(isset($_POST['eau'])) {
                        $maison->setEau($_POST["eau"]); 
						$maison->setFrais_eau($_POST["frais_eau"]);   
                  }
                  else {
                       $maison->setEau(0);
					   $maison->setFrais_eau(0);    
                  }
                  $maison->setDate_enregistrement($date_idd->toString('yyyy-MM-dd'));
                  if(isset($_POST['elect'])) {
                   $maison->setElectrifier($_POST['elect']);
				   $maison->setFrais_electricite($_POST["frais_elect"]);
                  }
                  else {
                   $maison->setElectrifier(0); 
				   $maison->setFrais_electricite(0);   
                  }
                 if(isset($_POST['wd'])) {
                   $maison->setWc_douche($_POST['wd']);
				   $maison->setFrais_vidange($_POST["frais_vidange"]);
                 }
                 else {
                   $maison->setWc_douche(0);
				   $maison->setFrais_vidange(0);    
                 }
				
				if(isset($_POST['tel'])) {
                   $maison->setTel($_POST['tel']);
				   $maison->setFrais_tel($_POST["frais_tel"]);
                }
                else {
                   $maison->setTel(0);
				   $maison->setFrais_tel(0);    
                }
				
				if(isset($_POST['radio_taxe'])) {
				   $maison->setTaxe($_POST["taxe"]);
                }
                else {
				   $maison->setTaxe(0);    
                }
				
				if(isset($_POST['mt_loyer'])) {
				   $maison->setMontant_loyer($_POST["mt_loyer"]);
                }
                else {
				   $maison->setMontant_loyer(0);    
                }
				
				if(isset($_POST['autre_charge'])) {
				   $maison->setAutre_charge($_POST["frais_charge"]);
                }
                else {
				   $maison->setAutre_charge(0);    
                }
				
                $maison->setStatut(0);
                $maison->setDesc_maison($_POST["desc"]);
                $maison->setRue($_POST["rue"]);
                $maison->setNum_maison($_POST["numero"]);
                $maison->setNum_police_electricite($_POST["num_police"]);
                $maison->setNum_compteur_eau($_POST["num_compteur"]);
                $maison->setNum_ligne_tel($_POST["num_ligne"]);
                $maison->setId_utilisateur($user->id_utilisateur);
                $maison->setQuartier($_POST["quartier"]);    
                $mapper->update($maison);
                $db->commit();
                $this->view->data = true;
                return;  
              } 
              catch (Exception $exc) {
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();   
              }
       }
  }
    
  
   public function saveAction() {
      
         
    }
  
  
    public function save1Action()  {
      
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $user = $auth->getIdentity();
      $code_agence = $user->code_agence;  
           
      if ($this->getRequest()->isPost()) {
           $date_id = new Zend_Date(Zend_Date::ISO_8601);
           $date_idd = clone $date_id;
           $code_sms = $_POST["code_sms"];
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction(); 
           try {
               $frais_identification = trim($_POST["frais_identification"]);
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
               $sms = $sms_mapper->findByCreditCode($code_sms);
                  
               if ($sms != null) {
                     $mont = $sms->getCreditAmount();
                     if ($mont == $frais_identification)   {
                         
                        $mapper_m = new Application_Model_EuMembreMapper();
                        $code = $mapper_m->getLastCodeMembreByAgence($code_agence);
                        $mapper_p = new Application_Model_EuProprietaireMapper();
                        $mapper_q = new Application_Model_EuQuartierMapper();
                        
                        $nom= $mapper_p->findnom($_POST["proprio"]);
                        $prenom= $mapper_p->findprenom($_POST["proprio"]);
                        $fonction= $mapper_p->findfonction($_POST["proprio"]);
                        $ville = $mapper_q->findville($_POST["quartier"]);
                        $quartier = $mapper_q->findquartier($_POST["quartier"]);
                        
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
                        $membre = new Application_Model_EuMembre();
                        $membre->setType_membre("M")
                               ->setCode_membre($code)
                               ->setNom_membre($nom)
                               ->setPrenom_membre($prenom)
                               ->setCode_type_acteur($_POST["type_acteur"])
                               ->setCode_statut($_POST["statut_juridique"])
                               ->setRaison_sociale($_POST["design"])
                               ->setNum_registre_membre($_POST["numero"])
                               ->setDomaine_activite("Immobilière")
                               ->setProfession_membre($fonction)
                               ->setSite_web($_POST["site_web"])
                               ->setQuartier_membre($quartier)
                               ->setVille_membre($ville)
                               ->setBp_membre($_POST["bp_membre"])
                               ->setTel_membre($_POST["tel_membre"])
                               ->setEmail_membre($_POST["email_membre"])
                               ->setPortable_membre($_POST["portable_membre"])
                               ->setId_utilisateur($user->id_utilisateur)
                               ->setHeure_identification($date_idd->toString('hh:mm:ss'))
                               ->setDate_identification($date_idd->toString('yyyy-mm-dd'))
                               ->setCodesecret(md5($_POST["codesecret"]))
                               ->setCode_agence($code_agence)
                               ->setAuto_enroler('O');
                        $mapper_m->save($membre);
                        
                        $maison = new Application_Model_EuMaison();
                        $mapper = new Application_Model_EuMaisonMapper();
                        
                        $maison->setDesignation($_POST["design"]);
                        $maison->setId_proprietaire($_POST["proprio"]);
                        $maison->setCode_membre($code);
                        $maison->setType_maison($_POST["type_maison"]);
                        if(isset($_POST['eau'])) {
                          $maison->setEau($_POST["eau"]);    
                        }
                        else {
                            $maison->setEau(0);    
                        }
                        $maison->setDate_enregistrement($date_idd->toString('yyyy-mm-dd'));
                            if(isset($_POST['elect'])) {
                            $maison->setElectrifier($_POST['elect']);
                        }
                        else {
                        $maison->setElectrifier(0);    
                        }
                        if(isset($_POST['wd'])) {
                          $maison->setWc_douche($_POST['wd']);
                        }
                        else {
                            $maison->setWc_douche(0);    
                        }
                        $maison->setStatut(0);
                        $maison->setDesc_maison($_POST["desc"]);
                        $maison->setFrais_eau($_POST["frais_eau"]);
                        $maison->setFrais_electricite($_POST["frais_elect"]);
                        $maison->setFrais_vidange($_POST["frais_vidange"]);
                        $maison->setTaxe($_POST["taxe"]);
                        $maison->setFrais_tel($_POST["frais_tel"]);
                        $maison->setRue($_POST["rue"]);
                        $maison->setNum_maison($_POST["numero"]);
                        $maison->setNum_police_electricite($_POST["num_police"]);
                        $maison->setNum_compteur_eau($_POST["num_compteur"]);
                        $maison->setNum_ligne_tel($_POST["num_ligne"]);
                        $maison->setId_utilisateur($user->id_utilisateur);
                        $maison->setId_quartier($_POST["quartier"]);
                            
                        $mapper->save($maison);
                            
                        //insertion dans la table operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteur, $code, 'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_id->toString('yyyy-mm-dd'), $date_id->toString('hh:mm:ss'), $user->id_utilisateur);
                        //Util_Utils::createCompte('nb-tpagci-' . $code, 'tpagci', 'tpagci', 0, $code, 'nb', $date_id, 0);
                            
                            $contrat = new Application_Model_EuContrat();
                            $mapper_c = new Application_Model_EuContratMapper();
                            
                            $id_pays= $mapper_q->findpays($_POST["quartier"]);
                            
                            $contrat->setCode_membre($code);
                            $contrat->setDate_contrat($date_idd->toString('yyyy-mm-dd'));
                            $contrat->setNature_contrat('');
                            $contrat->setId_type_contrat($_POST['type_contrat']);
                            if(isset($_POST['type_creneau']))
                                $contrat->setId_type_creneau($_POST['type_creneau']);
                            else
                                $contrat->setId_type_creneau(null);    
             
	                    if(isset($_POST['typeacteur']) && $_POST['typeacteur']!=''){
                                $contrat->setId_type_acteur($_POST['typeacteur']);
			   }
                           else{
                                $contrat->setId_type_acteur(null);
			   }
                           $contrat->setId_pays($id_pays);
                           $contrat->setId_utilisateur($user->id_utilisateur);
                           $contrat->setFiliere(''); 
                           $mapper = new Application_Model_EuContratMapper();
                           $mapper_c->save($contrat); 
                            
                           
                        //return $this->_helper->redirector('index');
                     } 
                     else {
                         $this->view->data = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode(); 
                         //$db->rollback();
                         return;
                         $this->view->design = $_POST["design"];
                         $this->view->proprio = $_POST["proprio"];
                         $this->view->type_maison = $_POST["type_maison"];
                          //$this->view->eau = $_POST["eau"];
                          //$this->view->elect = $_POST["elect"];
                          //$this->view->wd = $_POST["wd"];
                         $this->view->desc = $_POST["desc"];
                         $this->view->frais_eau = $_POST["frais_eau"];
                         $this->view->frais_elect = $_POST["frais_elect"];
                         $this->view->frais_vidange = $_POST["frais_vidange"];
                         $this->view->taxe = $_POST["taxe"];
                         $this->view->frais_tel = $_POST["frais_tel"];
                         $this->view->rue = $_POST["rue"];
                         $this->view->num_maison = $_POST["numero"];
                         $this->view->num_police = $_POST["num_police"];
                         $this->view->num_compteur = $_POST["num_compteur"];
                         $this->view->num_ligne = $_POST["num_ligne"];
                         $this->view->bp_membre = $_POST["bp_membre"];
                         $this->view->tel_membre = $_POST["tel_membre"];
                         $this->view->portable_membre = $_POST["portable_membre"];
                         $this->view->email_membre = $_POST["email_membre"];
                         $this->view->site_web = $_POST["site_web"];  
                     }
                  }
                  else {  
                     //$this->view->message = 'Le code sms [' .$code_sms. '] est invalide !!!'; 
                     $this->view->data='Le code sms [' .$code_sms. '] est invalide !!!'; 
                     //$db->rollback();
                     return;
                     $this->view->design = $_POST["design"];
                     $this->view->proprio = $_POST["proprio"];
                     $this->view->type_maison = $_POST["type_maison"];
                     //$this->view->eau = $_POST["eau"];
                     //$this->view->elect = $_POST["elect"];
                     //$this->view->wd = $_POST["wd"];
                     $this->view->desc = $_POST["desc"];
                     $this->view->frais_eau = $_POST["frais_eau"];
                     $this->view->frais_elect = $_POST["frais_elect"];
                     $this->view->frais_vidange = $_POST["frais_vidange"];
                     $this->view->taxe = $_POST["taxe"];
                     $this->view->frais_tel = $_POST["frais_tel"];
                     $this->view->rue = $_POST["rue"];
                     $this->view->num_maison = $_POST["numero"];
                     $this->view->num_police = $_POST["num_police"];
                     $this->view->num_compteur = $_POST["num_compteur"];
                     $this->view->num_ligne = $_POST["num_ligne"];
                     $this->view->bp_membre = $_POST["bp_membre"];
                     $this->view->tel_membre = $_POST["tel_membre"];
                     $this->view->portable_membre = $_POST["portable_membre"];
                     $this->view->email_membre = $_POST["email_membre"];
                     $this->view->site_web = $_POST["site_web"];     
                  }
                  $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                      ->setDateTimeconsumed($date_id->toString('dd/mm/yyyy hh:mm:ss'))
                      ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/mm/yyyy')));
                  $sms_mapper->update($sms);
                  Util_Utils::addSms($_POST["portable_membre"], "Bienvenue dans le réseau mcnp! Votre numéro de membre est: " . $code);
                
                  $db->commit();
                  $this->view->data = true;
                  return;
                  
                } 
                catch (Exception $exc) {
                      $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();   
                }     
           }   
    }   
}
?>
