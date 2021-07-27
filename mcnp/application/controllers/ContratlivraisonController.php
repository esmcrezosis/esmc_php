<?php

class ContratlivraisonController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }
	
	
	public  function addproduitAction()  {
		/* page contratlivraison/addproduit - Ajout d'un produit */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if(!isset($sessionmembre->code_membre)) {
           $this->_redirect('/');
        }
		
		$t_tegc = new Application_Model_DbTable_EuTegc();
	    $selection = $t_tegc->select();
	    $selection->where('nom_tegc is not null');
		if(substr($sessionmembre->code_membre, -1) == "P") {
	       $selection->where('code_membre_physique like ?',$sessionmembre->code_membre);
		} else {
		   $selection->where('code_membre like ?',$sessionmembre->code_membre);
		}
		$selection->order('nom_tegc asc');
        $tes = $t_tegc->fetchAll($selection);
	    $this->view->tes = $tes;
		
		$request = $this->getRequest();
		if($request->isPost()) {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction(); 
            try  {
				 $date_id = Zend_Date::now();
                 $membremoral = new Application_Model_EuMembreMorale();
                 $m_mapmoral = new Application_Model_EuMembreMoraleMapper();
				 
				 $produit = new Application_Model_EuProduitFournisseur();
                 $m_produit = new Application_Model_EuProduitFournisseurMapper();
				 
				 $code_membre = $sessionmembre->code_membre;
				 $code_tegc = $request->getParam("code_tegc");
				 $libelle_produit = $request->getParam("libelle_produit");
				 $desc_produit = $request->getParam("desc_produit");
				 
				 $findmembre = $m_mapmoral->find($code_membre,$membremoral);
				 if($findmembre == false) {
				   $db->rollback();
                   $this->view->error = "Le code membre du fournisseur  ".$code_membre."  est introuvable ...";
                   return;
				 }
				  
				 if($membremoral->desactiver != 0) {
					$db->rollback();
					$this->view->error = "Ce fournisseur dont le code membre que voici  ".$code_membre."  n'est pas autorisé à effectuer cette opération ...";
					return;
				 }
				 
				 $produit->setLibelle_produit_fournisseur($libelle_produit);
				 $produit->setDesc_produit_fournisseur($desc_produit);
                 $produit->setCode_membre_fournisseur($code_membre);
				 $produit->setCode_tegc($code_tegc);
				 $produit->setActiver(0);
                 $produit->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));  
				 $m_produit->save($produit);

                 $db->commit();
				 $sessionmembre->error = "Operation bien effectuee ...";
				 $this->_redirect('/contratlivraison/listproduits');
				   
            } catch(Exception $exc) {				   
			   $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
			}			
			
		}
	}
	
	
	public  function listproduitsAction()    {
		 /* page contratlivraison/listproduits - liste des produits */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if(!isset($sessionmembre->code_membre)) {
          $this->_redirect('/');
        }
		$produit_mapper = new Application_Model_EuProduitFournisseurMapper();
		$entries = $produit_mapper->findByFournisseur($sessionmembre->code_membre);
		$this->view->entries = $entries;
		
		$this->view->tabletri = 1;
	}
	
	
	
	public  function editproduitAction() {
		/* page contratlivraison/listproduits - Ajout d'un produit */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if(!isset($sessionmembre->code_membre)) {
          $this->_redirect('/');
        }
		
		$request = $this->getRequest();
		if($request->isPost())  {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
               $produit   = new Application_Model_EuProduitFournisseur();
	           $m_produit = new Application_Model_EuProduitFournisseurMapper();
			   
			   $id_produit_fournisseur = $request->getParam("id_produit_fournisseur");
			   $libelle_produit = $request->getParam("libelle_produit");
			   $desc_produit = $request->getParam("desc_produit");
			   $code_tegc = $request->getParam("code_tegc");

			   $m_produit->find($id_produit_fournisseur,$produit);
			   
			   $produit->setLibelle_produit_fournisseur($libelle_produit);
			   $produit->setDesc_produit_fournisseur($desc_produit);
			   $produit->setCode_tegc($code_tegc);
			   $m_produit->update($produit);
			   
			   $db->commit();
			   $sessionmembre->error = "Modification bien effectuee ...";
			   $this->_redirect('/contratlivraison/listproduits');

           } catch (Exception $exc) {				   
	           $db->rollback();
			   $this->view->produit = $produit;
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
           }		   
		    
		} else {
		   $id = $this->_request->getParam('id');
	       $produit   = new Application_Model_EuProduitFournisseur();
	       $m_produit = new Application_Model_EuProduitFournisseurMapper();
	    
	       $m_produit->find($id,$produit);
	       $this->view->produit = $produit;
	    }
		
	}
	
	
	
	
	
	
	
	public  function addeliAction()  {
	    /* page contratlivraison/addcontrat - Ajout contrat */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if(!isset($sessionmembre->code_membre)) {
          $this->_redirect('/');
        }
        if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
        if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
		
		$t_tegc = new Application_Model_DbTable_EuTegc();
	    $selection = $t_tegc->select();
	    $selection->where('nom_tegc is not null');
		if(substr($sessionmembre->code_membre, -1) == "P") {
	       $selection->where('code_membre_physique like ?',$sessionmembre->code_membre);
		} else {
		   $selection->where('code_membre like ?',$sessionmembre->code_membre);
		}
		$selection->order('nom_tegc asc');
        $tes = $t_tegc->fetchAll($selection);
	    $this->view->tes = $tes;
		  
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
		if($request->isPost()) {
           if(isset($_POST['code_te']) && $_POST['code_te']!="")  {
			  
			  $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction(); 
              try {
				   $membremoral = new Application_Model_EuMembreMorale();
                   $m_mapmoral = new Application_Model_EuMembreMoraleMapper();

                   $eli = new Application_Model_EuEli();
                   $m_eli = new Application_Model_EuEliMapper();
				  
				   $detaileli = new Application_Model_EuDetailEli();
                   $m_detaileli = new Application_Model_EuDetailEliMapper();

                   $code_membre = $sessionmembre->code_membre;
				   $code_tegc = $request->getParam("code_te");
				   $libelle_eli = $request->getParam("libelle_eli");
				   //$id_canton = $request->getParam("id_canton");

                   $db_convention = new Application_Model_DbTable_EuConvention();
				   $db_franchise = new Application_Model_DbTable_EuFranchise();
				   $db_convention_eli = new Application_Model_DbTable_EuConventionEliOpi();
				   $db_avr = new Application_Model_DbTable_EuFormAvr();
				   
				   $bai = 0;
                   $ban = 0;
                   $opi = 0;	

                   $montant_bai = 0;
                   $montant_ban = 0;
                   $montant_opi = 0;
				   $montant_eli = 0;
				   
				   $findmembre = $m_mapmoral->find($code_membre,$membremoral);
				   if($findmembre == false) {
				      $db->rollback();
                      $this->view->error = "Le code membre du fournisseur  ".$code_membre."  est introuvable ...";
                      return;
				   }
				  
				   if($membremoral->desactiver == 1) {
					  $db->rollback();
					  $this->view->error = "Ce fournisseur dont le code membre que voici  ".$code_membre."  n'est pas autorisé à effectuer cette opération ...";
					  return;
				   }
				   
				   $select = $db_convention->select();
				   $select->where('code_membre like  ?', $code_membre);
				   $rowsconvention = $db_convention->fetchRow($select);
				  
				   if(count($rowsconvention) == 0) {
					  $db->rollback();
                      $this->view->error = "Veuillez impérativement lire et approuver la convention de collaboration ... ";
                      return;
				   }
				   
				   $select = $db_franchise->select();
				   $select->where('code_membre_franchise like  ?', $code_membre);
				   $rowsfranchise = $db_franchise->fetchRow($select);
				  
				   if(count($rowsfranchise) == 0) {
					  $db->rollback();
                      $this->view->error = "Veuillez impérativement lire et approuver notre document de franchise ... ";
                      return;
				   }
				   
				   $select = $db_convention_eli->select();
				   $select->where('code_membre like  ?', $code_membre);
				   $rowseli = $db_convention_eli->fetchRow($select);
				  
				   if(count($rowseli) == 0) {
					  $db->rollback();
                      $this->view->error = "Veuillez impérativement lire et approuver notre document d'Engagement de Livraison Irrévocable ... ";
                      return;
				   }
				   
				   $select = $db_avr->select();
				   $select->where('code_membre_avr like  ?', $code_membre);
				   $rowsavr = $db_avr->fetchRow($select);
				  
				   if(count($rowsavr) == 0) {
					  $db->rollback();
                      $this->view->error = "Veuillez impérativement valider notre formulaire d'Achat Vente Réciproque ... ";
                      return;
				   }
				   
				   
				   for($i = 0; $i < count($_POST['prix_unitaire']); $i++) {
					 if($_POST['prix_unitaire'][$i] > 0 && $_POST['quantite'][$i] > 0) {
					    $montant_eli = $montant_eli + ($_POST['prix_unitaire'][$i] * $_POST['quantite'][$i]);
					 } else {
						$db->rollback();
                        $this->view->error = "Veuillez revoir votre saisie ... ";
                        return;						
					 }
				   }
				   
				   if(isset($_POST['bai']) && $_POST['bai'] == 1)  {
                     $bai = 1;					  
					 $montant_bai = $request->getParam("montant_bai");
					 if($montant_bai <= 0) {
						$db->rollback();
                        $this->view->error = "Montant BAi mal saisi ... ".$montant_bai;
                        return; 
					 }
				   }
				   
				   if(isset($_POST['ban']) && $_POST['ban'] == 1)  {
                     $ban = 1;					  
					 $montant_ban = $request->getParam("montant_ban");
					 if($montant_ban <= 0) {
						$db->rollback();
                        $this->view->error = "Montant BAn mal saisi ... ".$montant_ban;
                        return; 
					 }
				   }
				   
				   if(isset($_POST['opi']) && $_POST['opi'] == 1)  {
                     $opi = 1;					  
					 $montant_opi = $request->getParam("montant_opi");
					 if($montant_opi <= 0) {
						$db->rollback();
                        $this->view->error = "Montant Opi mal saisi ... ".$montant_opi;
                        return; 
					 }
				   }
				   
				   if((isset($_POST['opi']) && $_POST['opi'] == 1) || (isset($_POST['ban']) && $_POST['ban'] == 1) || (isset($_POST['bai']) && $_POST['bai'] == 1))  {
				   
				   if(($montant_bai + $montant_ban + $montant_opi) != $montant_eli) {
					  $db->rollback();
                      $this->view->error = "Le montant du mode de règlement n'est pas conforme au montant total des produits ...";
                      return;					  
				   }
				   
				   }
				   
				   $date_id = Zend_Date::now();
				   $codeeli = "";
				   $numero_eli = "";
				   $codeeli = strtoupper(Util_Utils::genererCodeSMS(6));
				   $numero_eli = "ELI-".$codeeli;
				   
				   /*
				   do {
                      $codeeli = strtoupper(Util_Utils::genererCodeSMS(6));
					  $numero_eli = "ELI-".$codeeli;
                      $eli_mapper = new Application_Model_EuEliMapper();
                      $eli2 = $eli_mapper->findByNumero($numero_eli);
                   }while(count($eli2) > 0);
				   */
				   
				   $eli->setCode_membre($code_membre);
				   $eli->setNumero_eli($numero_eli);
                   $eli->setLibelle_eli($libelle_eli);
                   $eli->setDate_eli($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                   $eli->setBai($bai);
                   $eli->setMontant_bai($montant_bai);
		           $eli->setBan($ban);
		           $eli->setMontant_ban($montant_ban);
		           $eli->setOpi($opi);
		           $eli->setMontant_opi($montant_opi);
		           $eli->setMontant_eli($montant_eli);
				   $eli->setCode_tegc($code_tegc);
		           $eli->setValider(0);
				   $eli->setRejeter(0);
		           $eli->setPayer(0);
				  
			       $eli->setUtilisateur(NULL);
			       $eli->setId_canton($membremoral->id_canton);
				   $m_eli->save($eli);
				   
				   $id_eli = $db->lastInsertId();
				   
				   for($i = 0; $i < count($_POST['prix_unitaire']); $i++) {
				      $detaileli->setId_eli($id_eli);
					  $detaileli->setType_bps($_POST['type_bps'][$i]);
					  $detaileli->setLibelle_produit($_POST['libelle_produit'][$i]);
					  $detaileli->setMontant_produit($_POST['quantite'][$i] * $_POST['prix_unitaire'][$i]);
					  $detaileli->setQuantite($_POST['quantite'][$i]);
					  $detaileli->setPrix_unitaire($_POST['prix_unitaire'][$i]);
					  $detaileli->setStatut(1);
					  $m_detaileli->save($detaileli); 
				   }
				  
				   $db->commit();
				   $sessionmembre->error = "Opération bien effectuée ...";
				   $this->_redirect('/contratlivraison/listdemandeelicontracte');
				
			  } catch(Exception $exc) {				   
				  $db->rollback();
                  $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                  return;
			  }

            } else {
                $this->view->error = "Veuillez renseigner les champs obligatoires (*)";
				return;
			}

        }  
		  
	}
	
	public  function detaileliAction() {
		ini_set('memory_limit', '1024M');
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
		if(!isset($sessionmembre->code_membre)) {
           $this->_redirect('/');
        }
		
		$id = $this->_request->getParam('id');
		$eli = new Application_Model_EuEli();
		$m_eli = new Application_Model_EuEliMapper();
		
		$deli = new Application_Model_EuDetailEli();
		$m_deli = new Application_Model_EuDetailEliMapper();
		
		$m_eli->find($id,$eli);
		$entries = $m_deli->fetchAllByEli($id);
		  
		$this->view->eli = $eli;  
		$this->view->entries = $entries;
	}
	
	
	public  function  reglereliAction()  {
	    $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if(!isset($sessionmembre->code_membre)) {
           $this->_redirect('/');
        }

        $request = $this->getRequest();
		if($request->isPost()) {		
		     $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction(); 
             try {
				 $eli = new Application_Model_EuEli();
                 $m_eli = new Application_Model_EuEliMapper();
				 $id_eli = $request->getParam("id_eli");
				 $findeli = $m_eli->find($id_eli,$eli);
				 
				 $numero_eli = $eli->numero_eli;
				 $url = curl_init();
				 $resultjson = array();
				 
				 curl_setopt_array(
				   $url,
				   array(
				   CURLOPT_URL => "http://tom.gacsource.net/jmcnpApi/souscriptionOpi/eli",
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_MAXREDIRS => 10,
                   CURLOPT_TIMEOUT => 30000000,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "POST",
				   CURLOPT_POSTFIELDS => "{
				     \n\t\"numeroEli\":\"$numero_eli\"			
				   }",
				   CURLOPT_HTTPHEADER => array(
                    "authorization: Basic dXNlcndlYnNlcnZpY2U6VXNlckAwNiEyMDE3X1NlSTIqJcK1I2ljZQ==",
                    "content-type: application/json",
                   ),
				  )
				);
				
				$response = json_decode(curl_exec($url));
				$error = curl_error($url);
				
				if(($error === '') && ($response->resultat == 1)) {
					$db->commit();
					$sessionmembre->error = $response->message;
					$this->_redirect('/contratlivraison/listdemandeelicontracte');
				}  else {
					$db->rollback();
					$this->view->eli = $eli;
					$this->view->error = $response->message;
					return;
				}
				curl_close($url);
				  
			 } catch(Exception $exc) {				   
			   $db->rollback();
			   $this->view->eli = $eli;
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
			 }
			 
		} else  {
			$id = $this->_request->getParam('id');
		    $eli = new Application_Model_EuEli();
		    $m_eli = new Application_Model_EuEliMapper();
		    $m_eli->find($id,$eli);
		    $this->view->eli = $eli;
		}
		
	}
	
	
	public  function listdemandeelicontracteAction() {
		ini_set('memory_limit', '1024M');
		/* page contratlivraison/listdemandeelicontracte */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if(!isset($sessionmembre->code_membre)) {
          $this->_redirect('/');
        }
		
		$eli_mapper = new Application_Model_EuEliMapper();
		$entries = $eli_mapper->findByMembre($sessionmembre->code_membre);
		$this->view->entries = $entries;
		
		$this->view->tabletri = 1;
		
	}
	
	
    public function addcontratAction() {
        /* page contratlivraison/addcontrat - Ajout contrat */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['type_validateur']) && $_POST['type_validateur'] != "" && isset($_POST['libelle_produit']) && $_POST['libelle_produit'] != "" && isset($_POST['montant_produits']) && $_POST['montant_produits'] != "" && isset($_POST['periode_garde']) && $_POST['periode_garde'] != "" && isset($_POST['chargement_produit']) && $_POST['chargement_produit'] != "") {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);

                $contrat = new Application_Model_EuContratLivraisonIrrevocable();
                $m_contrat = new Application_Model_EuContratLivraisonIrrevocableMapper();

            
            $compteur_id_contrat = $m_contrat->findConuter() + 1;

                    $contrat->setId_contrat($compteur_id_contrat);
                    $contrat->setCode_membre($sessionmembre->code_membre);
                    $contrat->setType_validateur($_POST['type_validateur']);
if($_POST['type_validateur'] == "personne_physique") {
                    $contrat->setCivilite($_POST['civilite']);
                    $contrat->setNom($_POST['nom']);
                    $contrat->setDemeure($_POST['demeure']);
                    $contrat->setLibelle_demeure($_POST['libelle_demeure']);
                    $contrat->setQuartier($_POST['quartier']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
}else if($_POST['type_validateur'] == "etablissement") {
                    $contrat->setNom($_POST['nom']);
                    $contrat->setSituation($_POST['situation']);
                    $contrat->setLibelle_situation($_POST['libelle_situation']);
                    $contrat->setRue($_POST['rue']);
                    $contrat->setCivilite_representant($_POST['civilite_representant']);
                    $contrat->setNom_representant($_POST['nom_representant']);
                    $contrat->setQuartier($_POST['quartier']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
                    $contrat->setCarte_operateur($_POST['carte_operateur']);
}else if($_POST['type_validateur'] == "maison") {
                    $contrat->setType_maison($_POST['type_maison']);
                    $contrat->setNom($_POST['nom']);
                    $contrat->setSituation($_POST['situation']);
                    $contrat->setLibelle_situation($_POST['libelle_situation']);
                    $contrat->setQuartier_maison($_POST['quartier_maison']);
                    $contrat->setRue($_POST['rue']);
                    $contrat->setCivilite_representant($_POST['civilite_representant']);
                    $contrat->setNom_representant($_POST['nom_representant']);
                    $contrat->setDemeure($_POST['demeure']);
                    $contrat->setLibelle_demeure($_POST['libelle_demeure']);
                    $contrat->setQuartier($_POST['quartier']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
}else if($_POST['type_validateur'] == "collectivite") {
                    $contrat->setNom($_POST['nom']);
                    $contrat->setCivilite_representant($_POST['civilite_representant']);
                    $contrat->setNom_representant($_POST['nom_representant']);
                    $contrat->setDemeure($_POST['demeure']);
                    $contrat->setLibelle_demeure($_POST['libelle_demeure']);
                    $contrat->setQuartier($_POST['quartier']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
}else if($_POST['type_validateur'] == "association") {
                    $contrat->setNom($_POST['nom']);
}else if($_POST['type_validateur'] == "ong") {
                    $contrat->setNom($_POST['nom']);
}else if($_POST['type_validateur'] == "groupement") {
                    $contrat->setNom($_POST['nom']);
}else if($_POST['type_validateur'] == "cooperative") {
                    $contrat->setNom($_POST['nom']);
}else if($_POST['type_validateur'] == "union") {
                    $contrat->setNom($_POST['nom']);
}else if($_POST['type_validateur'] == "federation") {
                    $contrat->setNom($_POST['nom']);
}else if($_POST['type_validateur'] == "confederation") {
                    $contrat->setNom($_POST['nom']);
}else if($_POST['type_validateur'] == "reseau") {
                    $contrat->setNom($_POST['nom']);
}else if($_POST['type_validateur'] == "faitiere") {
                    $contrat->setNom($_POST['nom']);
                    $contrat->setNumero_recipice($_POST['numero_recipice']);
                    $contrat->setSiege($_POST['siege']);
                    $contrat->setCivilite_representant($_POST['civilite_representant']);
                    $contrat->setNom_representant($_POST['nom_representant']);
}else if($_POST['type_validateur'] == "confession_religieuse") {
                    $contrat->setNom($_POST['nom']);
                    $contrat->setCivilite_representant($_POST['civilite_representant']);
                    $contrat->setNom_representant($_POST['nom_representant']);
                    $contrat->setDemeure($_POST['demeure']);
                    $contrat->setLibelle_demeure($_POST['libelle_demeure']);
                    $contrat->setQuartier($_POST['quartier']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
}else if($_POST['type_validateur'] == "ets_public_administratif") {
                    $contrat->setNom($_POST['nom']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
}else if($_POST['type_validateur'] == "ets_public_industriel_commercial") {
                    $contrat->setNom($_POST['nom']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
}else if($_POST['type_validateur'] == "organisation_internationale") {
                    $contrat->setNom($_POST['nom']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
}else if($_POST['type_validateur'] == "societe") {
                    $contrat->setNom($_POST['nom']);
                    $contrat->setMatricule_rccm($_POST['matricule_rccm']);
                    $contrat->setSiege($_POST['siege']);
                    $contrat->setCivilite_representant($_POST['civilite_representant']);
                    $contrat->setNom_representant($_POST['nom_representant']);
}
                    /*$contrat->setCivilite($_POST['civilite']);
                    $contrat->setType_maison($_POST['type_maison']);
                    $contrat->setNom($_POST['nom']);
                    $contrat->setSituation($_POST['situation']);
                    $contrat->setLibelle_situation($_POST['libelle_situation']);
                    $contrat->setQuartier_maison($_POST['quartier_maison']);
                    $contrat->setRue($_POST['rue']);
                    $contrat->setNumero_recipice($_POST['numero_recipice']);
                    $contrat->setMatricule_rccm($_POST['matricule_rccm']);
                    $contrat->setSiege($_POST['siege']);
                    $contrat->setCivilite_representant($_POST['civilite_representant']);
                    $contrat->setNom_representant($_POST['nom_representant']);
                    $contrat->setDemeure($_POST['demeure']);
                    $contrat->setLibelle_demeure($_POST['libelle_demeure']);
                    $contrat->setQuartier($_POST['quartier']);
                    $contrat->setBoite_postale($_POST['boite_postale']);
                    $contrat->setTelephone($_POST['telephone']);
                    $contrat->setCarte_operateur($_POST['carte_operateur']);*/

                    $contrat->setNumero_contrat(strtoupper(Util_Utils::genererCodeSMS(8)));
                    $contrat->setPeriode_garde($_POST['periode_garde']);
                    $contrat->setChargement_produit($_POST['chargement_produit']);
                    $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                    $contrat->setStatut(0);
                    $m_contrat->save($contrat);





                    for ($i = 0; $i < sizeof($_POST['libelle_produit']); $i++) {
                        $detail_contrat = new Application_Model_EuDetailContratLivraisonIrrevocable();
                        $m_detail_contrat = new Application_Model_EuDetailContratLivraisonIrrevocableMapper();

                        $compt_detail_contrat = $m_detail_contrat->findConuter() + 1;

                        $m_contrat = new Application_Model_EuContratLivraisonIrrevocableMapper();
                        $compt_contrat = $m_contrat->findConuter();

                        $detail_contrat->setId_detail_contrat($compt_detail_contrat);
                        $detail_contrat->setId_contrat($compt_contrat);
                        $detail_contrat->setLibelle_produit($_POST['libelle_produit'][$i]);
                        $detail_contrat->setMontant_produit($_POST['montant_produit'][$i]);
                        $detail_contrat->setPrix_unitaire($_POST['montant_produit'][$i]);
                        $detail_contrat->setQuantite(1);
                        $detail_contrat->setStatut(1);
                        $m_detail_contrat->save($detail_contrat);
                    }




                    $this->_redirect('/contratlivraison/listcontrat');
                    $this->view->error = "Contrat enregistré";
            } else {
                $this->view->error = "Champs * obligatoire";
            }
        }
    }



    public function editcontratAction()
    {
        /* page contratlivraison/editcontrat - editer contrat */

        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['type_registre']) && $_POST['type_registre'] != "" && isset($_POST['numero_registre']) && $_POST['numero_registre'] != "" && isset($_POST['libelle_produit']) && $_POST['libelle_produit'] != "" && isset($_POST['montant_produit']) && $_POST['montant_produit'] != "" && isset($_POST['periode_garde']) && $_POST['periode_garde'] != "" && isset($_POST['chargement_produit']) && $_POST['chargement_produit'] != "") {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);

                $contrat = new Application_Model_EuContratLivraisonIrrevocable();
                $m_contrat = new Application_Model_EuContratLivraisonIrrevocableMapper();
            $m_contrat->find($_POST['id_contrat'], $contrat);

            
            //$compteur_id_contrat = $m_contrat->findConuter() + 1;

                    //$contrat->setId_contrat($compteur_id_contrat);
                    $contrat->setCode_membre($_POST['code_membre']);
                    $contrat->setDesignation($_POST['designation']);
                    $contrat->setType_registre($_POST['type_registre']);
                    $contrat->setNumero_registre($_POST['numero_registre']);
                    $contrat->setLibelle_produit($_POST['libelle_produit']);
                    $contrat->setMontant_produit($_POST['montant_produit']);
                    $contrat->setPeriode_garde($_POST['periode_garde']);
                    $contrat->setChargement_produit($_POST['chargement_produit']);
                    $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                    $contrat->setStatut(0);
                    $m_contrat->update($contrat);

                    $this->_redirect('/contratlivraison/listcontrat');
                    $this->view->error = "Contrat enregistré";
            } else {
                $this->view->error = "Champs * obligatoire";

                $id = (string) $this->_request->getParam('id');
        if ($id > 0) {
            $contrat = new Application_Model_EuContratLivraisonIrrevocable();
            $m_contrat = new Application_Model_EuContratLivraisonIrrevocableMapper();
            $m_contrat->find($id, $contrat);
            $this->view->contrat = $contrat;
        }
            }

        } else {
                $id = (string) $this->_request->getParam('id');
        if ($id > 0) {
            $contrat = new Application_Model_EuContratLivraisonIrrevocable();
            $m_contrat = new Application_Model_EuContratLivraisonIrrevocableMapper();
            $m_contrat->find($id, $contrat);
            $this->view->contrat = $contrat;
        }
            }
    }



    public function listcontratAction()
    {
        /* page contratlivraison/listcontrat - Liste des contratlivraison */

        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        $contrat = new Application_Model_EuContratLivraisonIrrevocableMapper();
        $this->view->entries = $contrat->fetchAllByCodeMembre($sessionmembre->code_membre);

        $this->view->tabletri = 1;
    }




    public function statutcontratAction()
    {
        /* page contratlivraison/publiercontrat - Publier un contrat */

        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        $id = (string) $this->_request->getParam('id');
        if ($id > 0) {

            $contrat = new Application_Model_EuContratLivraisonIrrevocable();
            $m_contrat = new Application_Model_EuContratLivraisonIrrevocableMapper();
            $m_contrat->find($id, $contrat);

                $date_id = new Zend_Date(Zend_Date::ISO_8601);


$detail = new Application_Model_EuDetailContratLivraisonIrrevocableMapper();
$montant_produits = $detail->fetchAllByContratCumul($contrat->id_contrat);

$montant_commission = $montant_produits;
$code_membre_employeur = $contrat->code_membre;
$type_demande = "AVPC";
$code_membre_employe = $contrat->code_membre;


////////demande_paiement
$demande_paiement = new Application_Model_EuDemandePaiement();
$demande_paiement_mapper = new Application_Model_EuDemandePaiementMapper();

$compteur_demande_paiement = $demande_paiement_mapper->findConuter() + 1;
$demande_paiement->setId_demande_paiement($compteur_demande_paiement);
$demande_paiement->setMontant_demande_paiement($montant_commission);
$demande_paiement->setDate_demande_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$demande_paiement->setCode_membre_employeur($code_membre_employeur);
$demande_paiement->setPayer(0);
$demande_paiement->setDate_debut($date_id->toString('yyyy-MM-dd'));
$demande_paiement->setDate_fin($date_id->toString('yyyy-MM-dd'));
$demande_paiement->setType_demande($type_demande);
$demande_paiement->setNumero_demande_paiement(strtoupper(Util_Utils::genererCodeSMS(9)));
$demande_paiement->setLibelle_type_demande('Contrat de Livraison Irrevocable');
$demande_paiement_mapper->save($demande_paiement);


/////paiement
$paiement = new Application_Model_EuPaiement();
$paiement_mapper = new Application_Model_EuPaiementMapper();

$compteur_paiement = $paiement_mapper->findConuter() + 1;
$paiement->setId_paiement($compteur_paiement);
$paiement->setMontant_paiement($montant_commission);
$paiement->setDate_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$paiement->setCode_membre_employe($code_membre_employe);
$paiement->setId_demande_paiement($compteur_demande_paiement);
$paiement_mapper->save($paiement);


///////detail_paiement      
$detail_paiement = new Application_Model_EuDetailPaiement();
$detail_paiement_mapper = new Application_Model_EuDetailPaiementMapper();

$compteur_detail_paiement = $detail_paiement_mapper->findConuter() + 1;
$detail_paiement->setId_detail_paiement($compteur_detail_paiement);
$detail_paiement->setId_paiement($compteur_paiement);
$detail_paiement->setMontant_paiement($montant_commission);
$detail_paiement->setTable("contrat_livraison_irrevocable");
$detail_paiement->setId_table($contrat->id_contrat);
$detail_paiement_mapper->save($detail_paiement);



            $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $contrat->setStatut(1);
            $m_contrat->update($contrat);
        }

        $this->_redirect('/contratlivraison/listcontrat');
    }




    public function pdfcontratAction()
    {
        /* page contratlivraison/publiercontrat - Publier un contrat */

        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        $id = (string) $this->_request->getParam('id');
        if ($id > 0) {

            $contrat = new Application_Model_EuContratLivraisonIrrevocable();
            $m_contrat = new Application_Model_EuContratLivraisonIrrevocableMapper();
            $m_contrat->find($id, $contrat);

        //Util_Utils::genererPdfContratLivraisonIrrevocable($id);
$this->_redirect(Util_Utils::genererPdfContratLivraisonIrrevocable($id));

        }
    }




    public function suppcontratAction()
    {
        /* page contratlivraison/suppcontrat - Suppression d'un contrat */

        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        $id = (string) $this->_request->getParam('id');
        if ($id > 0) {

            $contratM = new Application_Model_EuContratLivraisonIrrevocableMapper();
            $contratM->delete($id);
        }

        $this->_redirect('/contratlivraison/listcontrat');
    }










    public function adddemandeAction()
    {
        /* page contratlivraison/publiercontrat - Publier un contrat */

        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['montant_demande_paiement']) && $_POST['montant_demande_paiement'] != "" && isset($_POST['libelle_type_demande']) && $_POST['libelle_type_demande'] != "") {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);

if(isset($_POST['numero_demande_paiement']) && $_POST['numero_demande_paiement'] != ""){
    $numero_demande_paiement = $_POST['numero_demande_paiement'];
}else{
    $numero_demande_paiement = strtoupper(Util_Utils::genererCodeSMS(9));    
}

    $table = new Application_Model_DbTable_EuDemandePaiement();
    $select = $table->select();
    $select->where('numero_demande_paiement = ?', $numero_demande_paiement);
    $resultSet = $table->fetchAll($select);
 if(count($resultSet) > 0){
$this->view->error = "Numero de demande de paiement déjà existant";
 }else{


$montant_commission = $_POST['montant_demande_paiement'];
$code_membre_employeur = $sessionmembre->code_membre;
$type_demande = "Prestataire";
$code_membre_employe = $sessionmembre->code_membre;


////////demande_paiement
$demande_paiement = new Application_Model_EuDemandePaiement();
$demande_paiement_mapper = new Application_Model_EuDemandePaiementMapper();

$compteur_demande_paiement = $demande_paiement_mapper->findConuter() + 1;
$demande_paiement->setId_demande_paiement($compteur_demande_paiement);
$demande_paiement->setMontant_demande_paiement($montant_commission);
$demande_paiement->setDate_demande_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$demande_paiement->setCode_membre_employeur($code_membre_employeur);
$demande_paiement->setPayer(0);
$demande_paiement->setDate_debut($date_id->toString('yyyy-MM-dd'));
$demande_paiement->setDate_fin($date_id->toString('yyyy-MM-dd'));
$demande_paiement->setType_demande($type_demande);
$demande_paiement->setNumero_demande_paiement($numero_demande_paiement);
$demande_paiement->setLibelle_type_demande($_POST['libelle_type_demande']);
$demande_paiement_mapper->save($demande_paiement);


/////paiement
$paiement = new Application_Model_EuPaiement();
$paiement_mapper = new Application_Model_EuPaiementMapper();

$compteur_paiement = $paiement_mapper->findConuter() + 1;
$paiement->setId_paiement($compteur_paiement);
$paiement->setMontant_paiement($montant_commission);
$paiement->setDate_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$paiement->setCode_membre_employe($code_membre_employe);
$paiement->setId_demande_paiement($compteur_demande_paiement);
$paiement_mapper->save($paiement);


///////detail_paiement      
$detail_paiement = new Application_Model_EuDetailPaiement();
$detail_paiement_mapper = new Application_Model_EuDetailPaiementMapper();

$compteur_detail_paiement = $detail_paiement_mapper->findConuter() + 1;
$detail_paiement->setId_detail_paiement($compteur_detail_paiement);
$detail_paiement->setId_paiement($compteur_paiement);
$detail_paiement->setMontant_paiement($montant_commission);
//$detail_paiement->setTable(NULL);
//$detail_paiement->setId_table(NULL);
$detail_paiement_mapper->save($detail_paiement);

        $this->_redirect('/contratlivraison/listdemande');
 }
            } else {
                $this->view->error = "Champs * obligatoire";
            }
}

    }





  
  public function listdemandeAction() {
     /* page pointage/listdemande - liste des demandes de paiement */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        
     $demande = new Application_Model_EuDemandePaiementMapper();
     $this->view->entries = $demande->fetchAllByEmploye($sessionmembre->code_membre);

     $this->view->tabletri = 1;
  }
  
  
  public function detaildemandeAction() {
     /* page pointage/listdemande - liste des demandes de paiement */
        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

   //$id = $this->_request->getParam('id');
     $m_paiement = new Application_Model_EuPaiementMapper();
     $this->view->entries = $m_paiement->fetchAllByEmploye($sessionmembre->code_membre);
     $this->view->tabletri = 1;
  }










}

