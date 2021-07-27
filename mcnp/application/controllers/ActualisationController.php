<?php

class ActualisationController extends Zend_Controller_Action{

	  public function init() {
		/* Initialize action controller here */
        //include("Url.php");
	  }





  
  
  public function recherchermembreAction()   {
     $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
     if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
          ini_set('memory_limit','1024M');
    
       if(isset($_POST['ok']) && $_POST['ok']=="ok")   {
          $d_membre = new Application_Model_DbTable_EuMembre();
        $d_membremorale = new Application_Model_DbTable_EuMembreMorale();
      
        if (isset($_POST['nom_membre']) && ($_POST['nom_membre']!="") && isset($_POST['prenom_membre']) && ($_POST['prenom_membre']!=""))  {
               $nom_membre = $_POST['nom_membre'];
         $prenom_membre = $_POST['prenom_membre'];
         $select = $d_membre->select();
         $select->where('nom_membre like ?', '%'.$nom_membre.'%');
         $select->where('prenom_membre like ?', '%'.$prenom_membre.'%');
         $entries = $d_membre->fetchAll($select);
         $this->view->nom_membre = $nom_membre;
         $this->view->prenom_membre = $prenom_membre;
         $this->view->entries = $entries; 
         
          } elseif(isset($_POST['nom_membre']) && ($_POST['nom_membre']!="")) {
               $nom_membre = $_POST['nom_membre'];
         $select = $d_membre->select();
         $select->where('nom_membre like ?', '%'.$nom_membre.'%');
         $entries = $d_membre->fetchAll($select);
         $this->view->nom_membre = $nom_membre;
         $this->view->entries = $entries;
                
      } elseif(isset($_POST['prenom_membre']) && ($_POST['prenom_membre']!="")) {
               $prenom_membre = $_POST['prenom_membre'];
         $select = $d_membre->select();
         $select->where('prenom_membre like ?', '%'.$prenom_membre.'%');
         $entries = $d_membre->fetchAll($select);
         $this->view->prenom_membre = $prenom_membre;
         $this->view->entries = $entries;   
      }
      elseif(isset($_POST['raison_sociale']) && ($_POST['raison_sociale']!="")) {
         $raison_sociale = $_POST['raison_sociale'];
               $select = $d_membremorale->select();
         $select->where('raison_sociale like ?', '%'.$raison_sociale.'%');
               $results = $d_membremorale->fetchAll($select);
               $this->view->raison_sociale = $raison_sociale;
               $this->view->results = $results; 
         
      } elseif(isset($_POST['code_membre']) && ($_POST['code_membre']!="")) {
         $code_membre = $_POST['code_membre'];
               if(substr($code_membre,19,1) == 'P') {
           $select = $d_membre->select();
           $select->where('code_membre like ?', '%'.$code_membre.'%');
           $entries = $d_membre->fetchAll($select);
           $this->view->code_membre = $code_membre;
           $this->view->entries = $entries;
               } else {
                 $select = $d_membremorale->select();
           $select->where('code_membre_morale like ?', '%'.$code_membre.'%');
           $results = $d_membremorale->fetchAll($select);
           $this->view->code_membre = $code_membre;
           $this->view->results = $results;
               }        
      }
       }     
       $this->view->tabletri = 1;         
  }
  



    public function utilisebonneutreAction()
    {
     $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
     if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $bon_neutre_utilise = new Application_Model_EuBonNeutreUtiliseMapper();
        $this->view->entries = $bon_neutre_utilise->fetchAllByBonNeutre($id);

        }

        $this->view->tabletri = 1;

}


    public function certificatpdfqrcodeAction() {
     $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
     if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfCertificatPPQRCODE($membre);

$this->_redirect(Util_Utils::genererPdfCertificatPPQRCODE($membre));

    }



  
    public function editcmAction() {
       $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
       //$this->_helper->layout->disableLayout();
       $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
       if (!isset($sessionutilisateur->login))     {$this->_redirect('/administration/login');}
       if($sessionutilisateur->confirmation != "") {$this->_redirect('/administration/confirmation');}
       
       $request = $this->getRequest ();
       if($request->isPost())  {
         $db = Zend_Db_Table::getDefaultAdapter();
         $db->beginTransaction();
         try {
              $mapper = new Application_Model_EuMembreMapper();
              $membre = new Application_Model_EuMembre();
              
              $mappermorale = new Application_Model_EuMembreMoraleMapper();
              $membremorale = new Application_Model_EuMembreMorale();
              
              $mapper_op = new Application_Model_EuOperationMapper();
              
              $code_membre = $request->getParam("code_membre");
              
              if (substr($code_membre,-1) == "P") {
                  $mapper->find($code_membre,$membre);
                  $date_nais = new Zend_Date($_POST["date_nais_membre"]);

                  //$membre->setNom_membre($_POST['nom_membre']);
                  //$membre->setPrenom_membre($_POST['prenom_membre']);
                  $membre->setSexe_membre($_POST['sexe_membre']);
                  $membre->setId_pays($_POST['nationalite_membre']);
                  $membre->setPere_membre($_POST['pere_membre']);
                  $membre->setMere_membre($_POST['mere_membre']);
                  $membre->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'));
                  $membre->setLieu_nais_membre($_POST['lieu_nais_membre']);
                  $membre->setPortable_membre($_POST['portable_membre']);
                  $membre->setBp_membre($_POST['bp_membre']);
                  $membre->setEmail_membre($_POST['email_membre']);
                  $membre->setFormation($_POST['formation']);
                  $membre->setNbr_enf_membre($_POST['nbr_enf_membre']);
                  $membre->setProfession_membre($_POST['profession_membre']);
                  $membre->setQuartier_membre($_POST['quartier_membre']);
                  $membre->setSitfam_membre($_POST['sitfam_membre']);
                  $membre->setTel_membre($_POST['tel_membre']);
                  $membre->setVille_membre($_POST['ville_membre']);
                  $mapper->update($membre);
                  
                  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $date_idd = clone $date_id;
                  
                  //$compteur = $mapper_op->findConuter() + 1;
                  //Util_Utils::addOperation($compteur,$code_membre,null,null,null, 'Modification de Compte marchand', 'MCM', 'MCM', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $sessionutilisateur->id_utilisateur);
                  
                  $place = new Application_Model_EuOperation();
      $mapper_op = new Application_Model_EuOperationMapper();

                  $place->setDate_op($date_idd->toString('yyyy-MM-dd'));
                  $place->setHeure_op($date_idd->toString('HH:mm:ss'));
                  $place->setId_utilisateur($sessionutilisateur->id_utilisateur);
                  $place->setCode_membre($code_membre);
                  $place->setCode_membre_morale(null);
                  $place->setMontant_op(null);
                  $place->setCode_produit('MCM');
                  $place->setLib_op('Modification de Compte marchand');
                  $place->setType_op('MCM');
                  $place->setCode_cat(null);
                  $mapper_op->save($place);                   

         
                  $db->commit();
                  $sessionutilisateur->error = "Modification effectuée avec succès ...";
                  $this->_redirect('/actualisation/recherchermembre');
                 
              } else {
                  $mappermorale->find($code_membre,$membremorale);
                  $membremorale->setCode_type_acteur($_POST['code_type_acteur']);
                  $membremorale->setNum_registre_membre($_POST['num_registre_membre']);
                  //$membremorale->setRaison_sociale($_POST['raison_sociale']);
                  $membremorale->setCode_statut($_POST['code_statut']);
                  $membremorale->setPortable_membre($_POST['portable_membre']);
                  $membremorale->setBp_membre($_POST['bp_membre']);
                  $membremorale->setEmail_membre($_POST['email_membre']);
                  $membremorale->setDomaine_activite($_POST['domaine_activite']);
                  $membremorale->setQuartier_membre($_POST['quartier_membre']);
                  $membremorale->setTel_membre($_POST['tel_membre']);
                  $membremorale->setVille_membre($_POST['ville_membre']);
                  $membremorale->setSite_web($_POST['site_web']);
                  $mappermorale->update($membremorale);
                  
                  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $date_idd = clone $date_id;
                  
                  //$compteur = $mapper_op->findConuter() + 1;
                  //Util_Utils::addOperation($compteur,null,$code_membre,null,null, 'Modification de Compte marchand', 'MCM', 'MCM', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $sessionutilisateur->id_utilisateur);
                  
                  $place = new Application_Model_EuOperation();
      $mapper_op = new Application_Model_EuOperationMapper();

                  $place->setDate_op($date_idd->toString('yyyy-MM-dd'));
                  $place->setHeure_op($date_idd->toString('HH:mm:ss'));
                  $place->setId_utilisateur($sessionutilisateur->id_utilisateur);
                  $place->setCode_membre(null);
                  $place->setCode_membre_morale($code_membre);
                  $place->setMontant_op(null);
                  $place->setCode_produit('MCM');
                  $place->setLib_op('Modification de Compte marchand');
                  $place->setType_op('MCM');
                  $place->setCode_cat(null);
                  $mapper_op->save($place);
 
                  $db->commit();
                  $sessionutilisateur->error = "Modification effectuée avec succès ...";
                  $this->_redirect('/actualisation/recherchermembre');
              }

         } catch(Exception $exc) {
             $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
             $db->rollback();
             $this->view->code_membre = $code_membre; 
             if (substr($code_membre,-1) == "P") {           
                $this->view->membre = $membre;
             } else {
                $this->view->membre = $membremorale;
             }           
             return;
         }       
       
       } else {
          $id = $this->_request->getParam('id');
          $code_membre = $id;
          if (substr($code_membre, -1) == "P") {
             $mapper = new Application_Model_EuMembreMapper();
             $membre = new Application_Model_EuMembre();
             $mapper->find($code_membre,$membre);
          } else {
             $mapper = new Application_Model_EuMembreMoraleMapper();
             $membre = new Application_Model_EuMembreMorale();
             $mapper->find($code_membre, $membre);
          }
          $this->view->code_membre = $code_membre; 
          $this->view->membre = $membre;
       }
    }
    
    




  
  
  public function recherchermembreintAction()   {
    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');

      if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

          ini_set('memory_limit','1024M');
    
       if(isset($_POST['ok']) && $_POST['ok']=="ok")   {
          $d_membre = new Application_Model_DbTable_EuMembre();
        $d_membremorale = new Application_Model_DbTable_EuMembreMorale();
      
        if (isset($_POST['nom_membre']) && ($_POST['nom_membre']!="") && isset($_POST['prenom_membre']) && ($_POST['prenom_membre']!=""))  {
               $nom_membre = $_POST['nom_membre'];
         $prenom_membre = $_POST['prenom_membre'];
         $select = $d_membre->select();
         $select->where('nom_membre like ?', '%'.$nom_membre.'%');
         $select->where('prenom_membre like ?', '%'.$prenom_membre.'%');
         $entries = $d_membre->fetchAll($select);
         $this->view->nom_membre = $nom_membre;
         $this->view->prenom_membre = $prenom_membre;
         $this->view->entries = $entries; 
         
          } elseif(isset($_POST['nom_membre']) && ($_POST['nom_membre']!="")) {
               $nom_membre = $_POST['nom_membre'];
         $select = $d_membre->select();
         $select->where('nom_membre like ?', '%'.$nom_membre.'%');
         $entries = $d_membre->fetchAll($select);
         $this->view->nom_membre = $nom_membre;
         $this->view->entries = $entries;
                
      } elseif(isset($_POST['prenom_membre']) && ($_POST['prenom_membre']!="")) {
               $prenom_membre = $_POST['prenom_membre'];
         $select = $d_membre->select();
         $select->where('prenom_membre like ?', '%'.$prenom_membre.'%');
         $entries = $d_membre->fetchAll($select);
         $this->view->prenom_membre = $prenom_membre;
         $this->view->entries = $entries;   
      }
      elseif(isset($_POST['raison_sociale']) && ($_POST['raison_sociale']!="")) {
         $raison_sociale = $_POST['raison_sociale'];
               $select = $d_membremorale->select();
         $select->where('raison_sociale like ?', '%'.$raison_sociale.'%');
               $results = $d_membremorale->fetchAll($select);
               $this->view->raison_sociale = $raison_sociale;
               $this->view->results = $results; 
         
      } elseif(isset($_POST['code_membre']) && ($_POST['code_membre']!="")) {
         $code_membre = $_POST['code_membre'];
               if(substr($code_membre,19,1) == 'P') {
           $select = $d_membre->select();
           $select->where('code_membre like ?', '%'.$code_membre.'%');
           $entries = $d_membre->fetchAll($select);
           $this->view->code_membre = $code_membre;
           $this->view->entries = $entries;
               } else {
                 $select = $d_membremorale->select();
           $select->where('code_membre_morale like ?', '%'.$code_membre.'%');
           $results = $d_membremorale->fetchAll($select);
           $this->view->code_membre = $code_membre;
           $this->view->results = $results;
               }        
      }
       }     
       $this->view->tabletri = 1;         
  }
  




    public function certificatpdfqrcodeintAction() {
    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');

      if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfCertificatPPQRCODE($membre);

$this->_redirect(Util_Utils::genererPdfCertificatPPQRCODE($membre));

    }



  
    public function editcmintAction() {
    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');

      if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}
       
       $request = $this->getRequest ();
       if($request->isPost())  {
         $db = Zend_Db_Table::getDefaultAdapter();
         $db->beginTransaction();
         try {
              $mapper = new Application_Model_EuMembreMapper();
              $membre = new Application_Model_EuMembre();
              
              $mappermorale = new Application_Model_EuMembreMoraleMapper();
              $membremorale = new Application_Model_EuMembreMorale();
              
              $mapper_op = new Application_Model_EuOperationMapper();
              
              $code_membre = $request->getParam("code_membre");
              
              if (substr($code_membre,-1) == "P") {
                  $mapper->find($code_membre,$membre);
                  $date_nais = new Zend_Date($_POST["date_nais_membre"]);

                  //$membre->setNom_membre($_POST['nom_membre']);
                  //$membre->setPrenom_membre($_POST['prenom_membre']);
                  $membre->setSexe_membre($_POST['sexe_membre']);
                  $membre->setId_pays($_POST['nationalite_membre']);
                  $membre->setPere_membre($_POST['pere_membre']);
                  $membre->setMere_membre($_POST['mere_membre']);
                  $membre->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'));
                  $membre->setLieu_nais_membre($_POST['lieu_nais_membre']);
                  $membre->setPortable_membre($_POST['portable_membre']);
                  $membre->setBp_membre($_POST['bp_membre']);
                  $membre->setEmail_membre($_POST['email_membre']);
                  $membre->setFormation($_POST['formation']);
                  $membre->setNbr_enf_membre($_POST['nbr_enf_membre']);
                  $membre->setProfession_membre($_POST['profession_membre']);
                  $membre->setQuartier_membre($_POST['quartier_membre']);
                  $membre->setSitfam_membre($_POST['sitfam_membre']);
                  $membre->setTel_membre($_POST['tel_membre']);
                  $membre->setVille_membre($_POST['ville_membre']);
                  $mapper->update($membre);
                  
                  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $date_idd = clone $date_id;
                  
                  //$compteur = $mapper_op->findConuter() + 1;
                  //Util_Utils::addOperation($compteur,$code_membre,null,null,null, 'Modification de Compte marchand', 'MCM', 'MCM', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $sessionmembreasso->id_utilisateur);
                  
                  $place = new Application_Model_EuOperation();
      $mapper_op = new Application_Model_EuOperationMapper();

                  $place->setDate_op($date_idd->toString('yyyy-MM-dd'));
                  $place->setHeure_op($date_idd->toString('HH:mm:ss'));
                  $place->setId_utilisateur($sessionmembreasso->id_utilisateur);
                  $place->setCode_membre($code_membre);
                  $place->setCode_membre_morale(null);
                  $place->setMontant_op(null);
                  $place->setCode_produit('MCM');
                  $place->setLib_op('Modification de Compte marchand');
                  $place->setType_op('MCM');
                  $place->setCode_cat(null);
                  $mapper_op->save($place);                   

         
                  $db->commit();
                  $sessionmembreasso->error = "Modification effectuée avec succès ...";
                  $this->_redirect('/actualisation/recherchermembreint');
                 
              } else {
                  $mappermorale->find($code_membre,$membremorale);
                  $membremorale->setCode_type_acteur($_POST['code_type_acteur']);
                  $membremorale->setNum_registre_membre($_POST['num_registre_membre']);
                  //$membremorale->setRaison_sociale($_POST['raison_sociale']);
                  $membremorale->setCode_statut($_POST['code_statut']);
                  $membremorale->setPortable_membre($_POST['portable_membre']);
                  $membremorale->setBp_membre($_POST['bp_membre']);
                  $membremorale->setEmail_membre($_POST['email_membre']);
                  $membremorale->setDomaine_activite($_POST['domaine_activite']);
                  $membremorale->setQuartier_membre($_POST['quartier_membre']);
                  $membremorale->setTel_membre($_POST['tel_membre']);
                  $membremorale->setVille_membre($_POST['ville_membre']);
                  $membremorale->setSite_web($_POST['site_web']);
                  $mappermorale->update($membremorale);
                  
                  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $date_idd = clone $date_id;
                  
                  //$compteur = $mapper_op->findConuter() + 1;
                  //Util_Utils::addOperation($compteur,null,$code_membre,null,null, 'Modification de Compte marchand', 'MCM', 'MCM', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $sessionmembreasso->id_utilisateur);
                  
                  $place = new Application_Model_EuOperation();
      $mapper_op = new Application_Model_EuOperationMapper();

                  $place->setDate_op($date_idd->toString('yyyy-MM-dd'));
                  $place->setHeure_op($date_idd->toString('HH:mm:ss'));
                  $place->setId_utilisateur($sessionmembreasso->id_utilisateur);
                  $place->setCode_membre(null);
                  $place->setCode_membre_morale($code_membre);
                  $place->setMontant_op(null);
                  $place->setCode_produit('MCM');
                  $place->setLib_op('Modification de Compte marchand');
                  $place->setType_op('MCM');
                  $place->setCode_cat(null);
                  $mapper_op->save($place);
 
                  $db->commit();
                  $sessionmembreasso->error = "Modification effectuée avec succès ...";
                  $this->_redirect('/actualisation/recherchermembreint');
              }

         } catch(Exception $exc) {
             $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
             $db->rollback();
             $this->view->code_membre = $code_membre; 
             if (substr($code_membre,-1) == "P") {           
                $this->view->membre = $membre;
             } else {
                $this->view->membre = $membremorale;
             }           
             return;
         }       
       
       } else {
          $id = $this->_request->getParam('id');
          $code_membre = $id;
          if (substr($code_membre, -1) == "P") {
             $mapper = new Application_Model_EuMembreMapper();
             $membre = new Application_Model_EuMembre();
             $mapper->find($code_membre,$membre);
          } else {
             $mapper = new Application_Model_EuMembreMoraleMapper();
             $membre = new Application_Model_EuMembreMorale();
             $mapper->find($code_membre, $membre);
          }
          $this->view->code_membre = $code_membre; 
          $this->view->membre = $membre;
       }
    }
    
    






}
