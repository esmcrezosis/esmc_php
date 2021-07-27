<?php

class ProjetController extends Zend_Controller_Action{

    public function init() {
    /* Initialize action controller here */
        include("Url.php");
    }





  public function addprojetindexAction() {
    /* page projet/addprojet - Ajout d'une projet */
  $sessionmcnp = new Zend_Session_Namespace('mcnp');

  //$this->_helper->layout->disableLayout();
  $this->_helper->layout()->setLayout('layoutpublicesmc');


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
            $l_activites = new Application_Model_DbTable_EuActivite();

            $activites = $l_activites->fetchAll();
    
            $this->view->activites = $activites;


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['projet_code_membre']) && $_POST['projet_code_membre'] != "" && isset($_POST['projet_libelle']) && $_POST['projet_libelle'] != "" && isset($_POST['projet_description']) && $_POST['projet_description'] != "" && isset($_POST['projet_montant']) && $_POST['projet_montant'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {


/////////////////////////////////////controle code membre
if(isset($_POST['projet_code_membre']) && $_POST['projet_code_membre']!=""){
if(strlen($_POST['projet_code_membre']) != 20) {
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/projet/addprojetindex');
                  return;
}else{
if(substr($_POST['projet_code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['projet_code_membre'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/projet/addprojetindex');
                  return;
                }
  }else if(substr($_POST['projet_code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['projet_code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/projet/addprojetindex');
                  return;
                }
  }
}


                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $projet = new Application_Model_EuProjet();
                 $m_projet = new Application_Model_EuProjetMapper();

                 $projet_id = $m_projet->findConuter() + 1;

                 $projet->setProjet_id($projet_id);
                 $projet->setProjet_libelle($_POST['projet_libelle']);
                 //$projet->setProjet_type($_POST['projet_type']);
                 $projet->setProjet_code_membre($_POST['projet_code_membre']);
                 $projet->setProjet_description($_POST['projet_description']);
                 //$projet->setProjet_centrale($_POST['projet_centrale']);
                 $projet->setProjet_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $projet->setProjet_montant($_POST['projet_montant']);
                 $projet->setProjet_stockage($_POST['projet_stockage']);
                 //$projet->setProjet_montant_final($_POST['projet_montant_final']);
                 //$projet->setProjet_observation($_POST['projet_observation']);
                 //$projet->setProjet_utilisateur($_POST['projet_utilisateur']);
                 $projet->setCode_zone($_POST['code_zone']);
                 $projet->setId_pays($_POST['id_pays']);
                 $projet->setId_region($_POST['id_region']);
                 $projet->setId_prefecture($_POST['id_prefecture']);
                 $projet->setId_canton($_POST['id_canton']);
                 $projet->setPublier(1);
                 $m_projet->save($projet);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $detail_projet_fichier = array();

          for($i = 0; $i < count($_POST['detail_projet_libelle']); $i++){
        $detail_projet = new Application_Model_EuDetailProjet();
        $m_detail_projet = new Application_Model_EuDetailProjetMapper();
      
            $compteur_detail_projet = $m_detail_projet->findConuter() + 1;
            $detail_projet->setDetail_projet_id($compteur_detail_projet);
            $detail_projet->setProjet_id($projet_id);
            $detail_projet->setDetail_projet_libelle($_POST['detail_projet_libelle'][$i]);

           if(isset($_FILES["detail_projet_fichier".$i]["name"]) && $_FILES["detail_projet_fichier".$i]["name"] != "") {
                  $chemin  = "projets";
                  $file    = $_FILES["detail_projet_fichier".$i]["name"];
                  $file1   = "detail_projet_fichier".$i;
                  $detail_projet_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $detail_projet_fichier[$i] = ""; }

            $detail_projet->setDetail_projet_fichier($detail_projet_fichier[$i]);
            $detail_projet->setEtat(1);
            $m_detail_projet->save($detail_projet);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmcnp->error = "Operation bien effectuee ...";
                 $this->_redirect('/projet/addprojetindex');
}else{
           $db->rollback();
           $sessionmcnp->error = "Veuillez renseigner le Code Membre ...";

}        
        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionmcnp->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmcnp->error = "Champs * obligatoire";
      }
    }
  }



  public function addprojetintegrateurAction() {
    /* page projet/addprojetintegrateur - Ajout d'une projet */
    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');
      if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}


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


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['projet_code_membre']) && $_POST['projet_code_membre'] != "" && isset($_POST['projet_libelle']) && $_POST['projet_libelle'] != "" && isset($_POST['projet_description']) && $_POST['projet_description'] != "" && isset($_POST['projet_montant']) && $_POST['projet_montant'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {


/////////////////////////////////////controle code membre
if(isset($_POST['projet_code_membre']) && $_POST['projet_code_membre']!=""){
if(strlen($_POST['projet_code_membre']) != 20) {
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/projet/addprojetintegrateur');
                  return;
}else{
if(substr($_POST['projet_code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['projet_code_membre'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/projet/addprojetintegrateur');
                  return;
                }
  }else if(substr($_POST['projet_code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['projet_code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/projet/addprojetintegrateur');
                  return;
                }
  }
}


                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $projet = new Application_Model_EuProjet();
                 $m_projet = new Application_Model_EuProjetMapper();

                 $projet_id = $m_projet->findConuter() + 1;

                 $projet->setProjet_id($projet_id);
                 $projet->setProjet_libelle($_POST['projet_libelle']);
                 //$projet->setProjet_type($_POST['projet_type']);
                 $projet->setProjet_code_membre($_POST['projet_code_membre']);
                 $projet->setProjet_description($_POST['projet_description']);
                 //$projet->setProjet_centrale($_POST['projet_centrale']);
                 $projet->setProjet_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $projet->setProjet_montant($_POST['projet_montant']);
                 $projet->setProjet_stockage($_POST['projet_stockage']);
                 //$projet->setProjet_montant_final($_POST['projet_montant_final']);
                 //$projet->setProjet_observation($_POST['projet_observation']);
                 //$projet->setProjet_utilisateur($_POST['projet_utilisateur']);
                 $projet->setCode_zone($_POST['code_zone']);
                 $projet->setId_pays($_POST['id_pays']);
                 $projet->setId_region($_POST['id_region']);
                 $projet->setId_prefecture($_POST['id_prefecture']);
                 $projet->setId_canton($_POST['id_canton']);
                 $projet->setPublier(1);
                 $m_projet->save($projet);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $detail_projet_fichier = array();

          for($i = 0; $i < count($_POST['detail_projet_libelle']); $i++){
        $detail_projet = new Application_Model_EuDetailProjet();
        $m_detail_projet = new Application_Model_EuDetailProjetMapper();
      
            $compteur_detail_projet = $m_detail_projet->findConuter() + 1;
            $detail_projet->setDetail_projet_id($compteur_detail_projet);
            $detail_projet->setProjet_id($projet_id);
            $detail_projet->setDetail_projet_libelle($_POST['detail_projet_libelle'][$i]);

           if(isset($_FILES["detail_projet_fichier".$i]["name"]) && $_FILES["detail_projet_fichier".$i]["name"] != "") {
                  $chemin  = "projets";
                  $file    = $_FILES["detail_projet_fichier".$i]["name"];
                  $file1   = "detail_projet_fichier".$i;
                  $detail_projet_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $detail_projet_fichier[$i] = ""; }

            $detail_projet->setDetail_projet_fichier($detail_projet_fichier[$i]);
            $detail_projet->setEtat(1);
            $m_detail_projet->save($detail_projet);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembreasso->error = "Operation bien effectuee ...";
                 $this->_redirect('/projet/addprojetintegrateur');
}else{
           $db->rollback();
           $sessionmembreasso->error = "Veuillez renseigner le Code Membre ...";

}        
        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionmembreasso->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembreasso->error = "Champs * obligatoire";
      }
    }
  }




  public function addprojetAction() {
    /* page projet/addprojet - Ajout d'une projet */

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


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['projet_code_membre']) && $_POST['projet_code_membre'] != "" && isset($_POST['projet_libelle']) && $_POST['projet_libelle'] != "" && isset($_POST['projet_description']) && $_POST['projet_description'] != "" && isset($_POST['projet_montant']) && $_POST['projet_montant'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $projet = new Application_Model_EuProjet();
                 $m_projet = new Application_Model_EuProjetMapper();

                 $projet_id = $m_projet->findConuter() + 1;

                 $projet->setProjet_id($projet_id);
                 $projet->setProjet_libelle($_POST['projet_libelle']);
                 //$projet->setProjet_type($_POST['projet_type']);
                 $projet->setProjet_code_membre($_POST['projet_code_membre']);
                 $projet->setProjet_description($_POST['projet_description']);
                 //$projet->setProjet_centrale($_POST['projet_centrale']);
                 $projet->setProjet_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $projet->setProjet_montant($_POST['projet_montant']);
                 $projet->setProjet_stockage($_POST['projet_stockage']);
                 //$projet->setProjet_montant_final($_POST['projet_montant_final']);
                 //$projet->setProjet_observation($_POST['projet_observation']);
                 //$projet->setProjet_utilisateur($_POST['projet_utilisateur']);
                 $projet->setCode_zone($_POST['code_zone']);
                 $projet->setId_pays($_POST['id_pays']);
                 $projet->setId_region($_POST['id_region']);
                 $projet->setId_prefecture($_POST['id_prefecture']);
                 $projet->setId_canton($_POST['id_canton']);
                 $projet->setPublier(1);
                 $m_projet->save($projet);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $detail_projet_fichier = array();

          for($i = 0; $i < count($_POST['detail_projet_libelle']); $i++){
        $detail_projet = new Application_Model_EuDetailProjet();
        $m_detail_projet = new Application_Model_EuDetailProjetMapper();
      
            $compteur_detail_projet = $m_detail_projet->findConuter() + 1;
            $detail_projet->setDetail_projet_id($compteur_detail_projet);
            $detail_projet->setProjet_id($projet_id);
            $detail_projet->setDetail_projet_libelle($_POST['detail_projet_libelle'][$i]);

           if(isset($_FILES["detail_projet_fichier".$i]["name"]) && $_FILES["detail_projet_fichier".$i]["name"] != "") {
                  $chemin  = "projets";
                  $file    = $_FILES["detail_projet_fichier".$i]["name"];
                  $file1   = "detail_projet_fichier".$i;
                  $detail_projet_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $detail_projet_fichier[$i] = ""; }

            $detail_projet->setDetail_projet_fichier($detail_projet_fichier[$i]);
            $detail_projet->setEtat(1);
            $m_detail_projet->save($detail_projet);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/projet/listprojet');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }




  public function editprojetAction() {
    /* page projet/addprojet - Ajout d'une projet */

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

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['projet_libelle']) && $_POST['projet_libelle'] != "" && isset($_POST['projet_description']) && $_POST['projet_description'] != "" && isset($_POST['projet_montant']) && $_POST['projet_montant'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $projet = new Application_Model_EuProjet();
                 $m_projet = new Application_Model_EuProjetMapper();
                 $m_projet->find($_POST['projet_id'], $projet);

                 //$projet->setProjet_id($projet_id);
                 $projet->setProjet_libelle($_POST['projet_libelle']);
                 //$projet->setProjet_type($_POST['projet_type']);
                 //$projet->setProjet_code_membre($_POST['projet_code_membre']);
                 $projet->setProjet_description($_POST['projet_description']);
                 //$projet->setProjet_centrale($_POST['projet_centrale']);
                 //$projet->setProjet_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $projet->setProjet_montant($_POST['projet_montant']);
                 $projet->setProjet_stockage($_POST['projet_stockage']);
                 //$projet->setProjet_montant_final($_POST['projet_montant_final']);
                 //$projet->setProjet_observation($_POST['projet_observation']);
                 //$projet->setProjet_utilisateur($_POST['projet_utilisateur']);
                 $projet->setCode_zone($_POST['code_zone']);
                 $projet->setId_pays($_POST['id_pays']);
                 $projet->setId_region($_POST['id_region']);
                 $projet->setId_prefecture($_POST['id_prefecture']);
                 $projet->setId_canton($_POST['id_canton']);
                 //$projet->setPublier(0);
                 $m_projet->update($projet);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/projet/listprojet');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembre->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $projet = new Application_Model_EuProjet();
               $mprojet = new Application_Model_EuProjetMapper();
           $mprojet->find($id,$projet);
           $this->view->projet = $projet;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $projet = new Application_Model_EuProjet();
               $mprojet = new Application_Model_EuProjetMapper();
           $mprojet->find($id,$projet);
           $this->view->projet = $projet;
       }   
     }

  }


  




  public function listprojetAction() {
    /* page projet/listprojet - liste des projets */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $projet = new Application_Model_EuProjetMapper();
    $this->view->entries = $projet->fetchAllByMembre($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }
  
  


    public function publierprojetAction()
    {
        /* page projet/publierprojet - Publier une projet */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $projet = new Application_Model_EuProjet();
        $projetM = new Application_Model_EuProjetMapper();
        $projetM->find($id, $projet);
    
        $projet->setPublier($this->_request->getParam('publier'));
    $projetM->update($projet);
        }

    $this->_redirect('/projet/listprojet');
    }



  public function detailprojetAction()
  {
    /* page espacepersonnel/detailprojet - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuProjet();
    $ma = new Application_Model_EuProjetMapper();
    $ma->find($id, $a);
    $this->view->projet = $a;
      }

  }




  public function listdetailprojetAction() {
    /* page projet/listprojet - liste des projets */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

    $detail_projet = new Application_Model_EuDetailProjetMapper();
    $this->view->entries = $detail_projet->fetchAllByProjet($id);
    }

    $this->view->tabletri = 1;
  }
  
  
  

    public function etatdetailprojetAction()
    {
        /* page projet/publierprojet - Publier une projet */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_projet = new Application_Model_EuDetailProjet();
        $detail_projetM = new Application_Model_EuDetailProjetMapper();
        $detail_projetM->find($id, $detail_projet);
    
        $detail_projet->setEtat($this->_request->getParam('etat'));
    $detail_projetM->update($detail_projet);
        }

    $this->_redirect('/projet/listdetailprojet/id/'.$detail_projet->projet_id);
    }






  public function suppprojetAction()
  {
    /* page projet/suppprojet - Suppression d'une projet */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

      $projetM = new Application_Model_EuProjetMapper();
      $projetM->delete($id);
    }

    $this->_redirect('/projet/listprojet');
  }








  public function editprojetadminAction() {
    /* page projet/addprojet - Ajout d'une projet */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

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

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['projet_libelle']) && $_POST['projet_libelle'] != "" && isset($_POST['projet_description']) && $_POST['projet_description'] != "" && isset($_POST['projet_montant_final']) && $_POST['projet_montant_final'] != "" && isset($_POST['projet_observation']) && $_POST['projet_observation'] != "" && isset($_POST['projet_type']) && $_POST['projet_type'] != "" && isset($_POST['projet_centrale']) && $_POST['projet_centrale'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $projet = new Application_Model_EuProjet();
                 $m_projet = new Application_Model_EuProjetMapper();
                 $m_projet->find($_POST['projet_id'], $projet);

                 //$projet->setProjet_id($projet_id);
                 $projet->setProjet_libelle($_POST['projet_libelle']);
                 $projet->setProjet_type($_POST['projet_type']);
                 //$projet->setProjet_code_membre($_POST['projet_code_membre']);
                 $projet->setProjet_description($_POST['projet_description']);
                 $projet->setProjet_centrale($_POST['projet_centrale']);
                 //$projet->setProjet_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$projet->setProjet_montant($_POST['projet_montant']);
                 $projet->setProjet_stockage($_POST['projet_stockage']);
                 $projet->setProjet_montant_final($_POST['projet_montant_final']);
                 $projet->setProjet_observation($_POST['projet_observation']);
                 $projet->setProjet_utilisateur($sessionutilisateur->id_utilisateur);//$_POST['projet_utilisateur']
                 //$projet->setCode_zone($_POST['code_zone']);
                 //$projet->setId_pays($_POST['id_pays']);
                 //$projet->setId_region($_POST['id_region']);
                 //$projet->setId_prefecture($_POST['id_prefecture']);
                 //$projet->setId_canton($_POST['id_canton']);
                 //$projet->setPublier(0);
                 $m_projet->update($projet);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/projet/listprojetadmin');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $projet = new Application_Model_EuProjet();
               $mprojet = new Application_Model_EuProjetMapper();
           $mprojet->find($id,$projet);
           $this->view->projet = $projet;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $projet = new Application_Model_EuProjet();
               $mprojet = new Application_Model_EuProjetMapper();
           $mprojet->find($id,$projet);
           $this->view->projet = $projet;
       }   
     }

  }


  




  public function listprojetadminAction() {
    /* page projet/listprojet - liste des projets */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $projet = new Application_Model_EuProjetMapper();
    //$this->view->entries = $projet->fetchAllByCanton($sessionutilisateur->id_canton);
    $this->view->entries = $projet->fetchAll2();

    $this->view->tabletri = 1;
  }
  
  


    public function publierprojetadminAction()
    {
        /* page projet/publierprojet - Publier une projet */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $projet = new Application_Model_EuProjet();
        $projetM = new Application_Model_EuProjetMapper();
        $projetM->find($id, $projet);
    
        $projet->setPublier($this->_request->getParam('publier'));
    $projetM->update($projet);
        }

    $this->_redirect('/projet/listprojetadmin');
    }



  public function detailprojetadminAction()
  {
    /* page espacepersonnel/detailprojet - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuProjet();
    $ma = new Application_Model_EuProjetMapper();
    $ma->find($id, $a);
    $this->view->projet = $a;
      }

  }




  public function listdetailprojetadminAction() {
    /* page projet/listprojet - liste des projets */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

    $detail_projet = new Application_Model_EuDetailProjetMapper();
    $this->view->entries = $detail_projet->fetchAllByProjet($id);
    }

    $this->view->tabletri = 1;
  }
  
  
  

    public function etatdetailprojetadminAction()
    {
        /* page projet/publierprojet - Publier une projet */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_projet = new Application_Model_EuDetailProjet();
        $detail_projetM = new Application_Model_EuDetailProjetMapper();
        $detail_projetM->find($id, $detail_projet);
    
        $detail_projet->setEtat($this->_request->getParam('etat'));
    $detail_projetM->update($detail_projet);
        }

    $this->_redirect('/projet/listdetailprojetadmin/id/'.$detail_projet->projet_id);
    }









  public function addbudgetprojetAction() {
    /* page projet/addbudgetprojet - Ajout d'une projet budget */

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


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_membre_budget']) && $_POST['code_membre_budget'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $forms_budget_nature = new Application_Model_EuFormsBudgetNature();
                 $m_forms_budget_nature = new Application_Model_EuFormsBudgetNatureMapper();

                 $forms_budget_nature_id = $m_forms_budget_nature->findConuter() + 1;

                 $forms_budget_nature->setId_forms_budget_nature($forms_budget_nature_id);
                 //$forms_budget_nature->setId_bps_vendu_achat_vente_reciproque($_POST['id_bps_vendu_achat_vente_reciproque']);
                 $forms_budget_nature->setCode_membre_budget($sessionmembre->code_membre);
                 $forms_budget_nature->setType_budget("OP");
                 $forms_budget_nature->setReference_type_budget($_POST['projet_id']);
                 $m_forms_budget_nature->save($forms_budget_nature);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");

          for($i = 0; $i < count($_POST['bps_demande']); $i++){
        $detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNature();
        $m_detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNatureMapper();
      
            $compteur_detail_forms_budget_nature = $m_detail_forms_budget_nature->findConuter() + 1;
            $detail_forms_budget_nature->setId_forms_detail_budget_nature($compteur_detail_forms_budget_nature);
            $detail_forms_budget_nature->setId_forms_budget_nature($forms_budget_nature_id);
            $detail_forms_budget_nature->setBps_demande($_POST['bps_demande'][$i]);
            $detail_forms_budget_nature->setQte_budget_nature($_POST['qte_budget_nature'][$i]);
            $detail_forms_budget_nature->setPrix_unitaire_budget_nature($_POST['prix_unitaire_budget_nature'][$i]);
            $detail_forms_budget_nature->setTotal_budget_nature($_POST['qte_budget_nature'][$i] * $_POST['prix_unitaire_budget_nature'][$i]);
            $detail_forms_budget_nature->setDisponible_budget_nature(1);
            $m_detail_forms_budget_nature->save($detail_forms_budget_nature);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/projet/listbudgetnature');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionmembre->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $projet = new Application_Model_EuProjet();
               $mprojet = new Application_Model_EuProjetMapper();
           $mprojet->find($id,$projet);
           $this->view->projet = $projet;

          $mdetailprojet = new Application_Model_EuDetailProjetMapper();
           $detailprojet = $mdetailprojet->fetchAllByProjetEtat($id,1);
           $this->view->detailprojet = $detailprojet;

       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $projet = new Application_Model_EuProjet();
               $mprojet = new Application_Model_EuProjetMapper();
           $mprojet->find($id,$projet);
           $this->view->projet = $projet;

          $mdetailprojet = new Application_Model_EuDetailProjetMapper();
           $detailprojet = $mdetailprojet->fetchAllByProjetEtat($id,1);
           $this->view->detailprojet = $detailprojet;

       }   
     }

  }


  




  public function listbudgetnatureAction() {
    /* page projet/listbudgetnature - liste des budgetnatures */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $budgetnature = new Application_Model_EuFormsBudgetNatureMapper();
    $this->view->entries = $budgetnature->fetchAllByCodeMembreTypeBudgetReference($sessionmembre->code_membre, "", 0);

    $this->view->tabletri = 1;
  }
  
  




  public function listdetailbudgetnatureAction() {
    /* page projet/listbudgetnature - liste des budgetnatures */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

    $detail_budgetnature = new Application_Model_EuFormsDetailBudgetNatureMapper();
    $this->view->entries = $detail_budgetnature->fetchAllByTypeBudgetReference($id, 0);
    }

    $this->view->tabletri = 1;
  }
  
  

    public function etatdetailbudgetAction()
    {
        /* page projet/publierprojet - Publier une projet */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_budgetnature = new Application_Model_EuFormsDetailBudgetNature();
        $detail_budgetnatureM = new Application_Model_EuFormsDetailBudgetNatureMapper();
        $detail_budgetnatureM->find($id, $detail_budgetnature);
    
        $detail_budgetnature->setDisponible_budget_nature($this->_request->getParam('etat'));
    $detail_budgetnatureM->update($detail_budgetnature);
        }

    $this->_redirect('/projet/listdetailbudgetnature/id/'.$detail_budgetnature->id_forms_budget_nature);
    }




  public function listformavrAction() {
    /* page projet/listformavr - liste des listformavr */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

       $t_formavr =  new Application_Model_DbTable_EuFormAvr();
       $select = $t_formavr->select();
       $select->where('code_membre_avr = ?', $sessionmembre->code_membre);
       $this->view->entries = $t_formavr->fetchAll($select);

    $this->view->tabletri = 1;
  }
  




  public function editdetailbudgetAction() {
    /* page projet/addprojet - Ajout d'une projet */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['bps_demande']) && $_POST['bps_demande'] != "" && isset($_POST['qte_budget_nature']) && $_POST['qte_budget_nature'] != "" && isset($_POST['prix_unitaire_budget_nature']) && $_POST['prix_unitaire_budget_nature'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

            $detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNature();
            $m_detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNatureMapper();
            $m_detail_forms_budget_nature->find($_POST['id_forms_detail_budget_nature'], $detail_forms_budget_nature);
      
            //$detail_forms_budget_nature->setId_forms_detail_budget_nature($compteur_detail_forms_budget_nature);
            //$detail_forms_budget_nature->setId_forms_budget_nature($forms_budget_nature_id);
            $detail_forms_budget_nature->setBps_demande($_POST['bps_demande']);
            $detail_forms_budget_nature->setQte_budget_nature($_POST['qte_budget_nature']);
            $detail_forms_budget_nature->setPrix_unitaire_budget_nature($_POST['prix_unitaire_budget_nature']);
            $detail_forms_budget_nature->setTotal_budget_nature($_POST['qte_budget_nature'] * $_POST['prix_unitaire_budget_nature']);
            $detail_forms_budget_nature->setDisponible_budget_nature($_POST['disponible_budget_nature']);
            $m_detail_forms_budget_nature->update($detail_forms_budget_nature);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
    $this->_redirect('/projet/listdetailbudgetnature/id/'.$detail_forms_budget_nature->id_forms_budget_nature);
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembre->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
            $detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNature();
            $m_detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNatureMapper();
            $m_detail_forms_budget_nature->find($id, $detail_forms_budget_nature);
           $this->view->detail_forms_budget_nature = $detail_forms_budget_nature;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
            $detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNature();
            $m_detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNatureMapper();
            $m_detail_forms_budget_nature->find($id, $detail_forms_budget_nature);
           $this->view->detail_forms_budget_nature = $detail_forms_budget_nature;
       }   
     }

  }


  







  public function addbudgetprojetadminAction() {
    /* page projet/addbudgetprojet - Ajout d'une projet budget */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

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


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_membre_budget']) && $_POST['code_membre_budget'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $forms_budget_nature = new Application_Model_EuFormsBudgetNature();
                 $m_forms_budget_nature = new Application_Model_EuFormsBudgetNatureMapper();

                 $forms_budget_nature_id = $m_forms_budget_nature->findConuter() + 1;

                 $forms_budget_nature->setId_forms_budget_nature($forms_budget_nature_id);
                 //$forms_budget_nature->setId_bps_vendu_achat_vente_reciproque($_POST['id_bps_vendu_achat_vente_reciproque']);
                 $forms_budget_nature->setCode_membre_budget($_POST['code_membre_budget']);
                 $forms_budget_nature->setType_budget("OP");
                 $forms_budget_nature->setReference_type_budget($_POST['projet_id']);
                 $m_forms_budget_nature->save($forms_budget_nature);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");

          for($i = 0; $i < count($_POST['bps_demande']); $i++){
        $detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNature();
        $m_detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNatureMapper();
      
            $compteur_detail_forms_budget_nature = $m_detail_forms_budget_nature->findConuter() + 1;
            $detail_forms_budget_nature->setId_forms_detail_budget_nature($compteur_detail_forms_budget_nature);
            $detail_forms_budget_nature->setId_forms_budget_nature($forms_budget_nature_id);
            $detail_forms_budget_nature->setBps_demande($_POST['bps_demande'][$i]);
            $detail_forms_budget_nature->setQte_budget_nature($_POST['qte_budget_nature'][$i]);
            $detail_forms_budget_nature->setPrix_unitaire_budget_nature($_POST['prix_unitaire_budget_nature'][$i]);
            $detail_forms_budget_nature->setTotal_budget_nature($_POST['qte_budget_nature'][$i] * $_POST['prix_unitaire_budget_nature'][$i]);
            $detail_forms_budget_nature->setDisponible_budget_nature(1);
            $m_detail_forms_budget_nature->save($detail_forms_budget_nature);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/projet/listbudgetnatureadmin');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $projet = new Application_Model_EuProjet();
               $mprojet = new Application_Model_EuProjetMapper();
           $mprojet->find($id,$projet);
           $this->view->projet = $projet;

          $mdetailprojet = new Application_Model_EuDetailProjetMapper();
           $detailprojet = $mdetailprojet->fetchAllByProjetEtat($id,1);
           $this->view->detailprojet = $detailprojet;

       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $projet = new Application_Model_EuProjet();
               $mprojet = new Application_Model_EuProjetMapper();
           $mprojet->find($id,$projet);
           $this->view->projet = $projet;

          $mdetailprojet = new Application_Model_EuDetailProjetMapper();
           $detailprojet = $mdetailprojet->fetchAllByProjetEtat($id,1);
           $this->view->detailprojet = $detailprojet;

       }   
     }

  }


  




  public function listbudgetnatureadminAction() {
    /* page projet/listbudgetnature - liste des budgetnatures */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $budgetnature = new Application_Model_EuFormsBudgetNatureMapper();
    $this->view->entries = $budgetnature->fetchAllByCodeMembreTypeBudgetReference("", "", 0);

    $this->view->tabletri = 1;
  }
  
  




  public function listdetailbudgetnatureadminAction() {
    /* page projet/listbudgetnature - liste des budgetnatures */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

    $detail_budgetnature = new Application_Model_EuFormsDetailBudgetNatureMapper();
    $this->view->entries = $detail_budgetnature->fetchAllByTypeBudgetReference($id, 0);
    }

    $this->view->tabletri = 1;
  }
  
  

    public function etatdetailbudgetadminAction()
    {
        /* page projet/publierprojet - Publier une projet */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_budgetnature = new Application_Model_EuFormsDetailBudgetNature();
        $detail_budgetnatureM = new Application_Model_EuFormsDetailBudgetNatureMapper();
        $detail_budgetnatureM->find($id, $detail_budgetnature);
    
        $detail_budgetnature->setDisponible_budget_nature($this->_request->getParam('etat'));
    $detail_budgetnatureM->update($detail_budgetnature);
        }

    $this->_redirect('/projet/listdetailbudgetnatureadmin/id/'.$detail_budgetnature->id_forms_budget_nature);
    }






  public function editdetailbudgetadminAction() {
    /* page projet/addprojet - Ajout d'une projet */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['bps_demande']) && $_POST['bps_demande'] != "" && isset($_POST['qte_budget_nature']) && $_POST['qte_budget_nature'] != "" && isset($_POST['prix_unitaire_budget_nature']) && $_POST['prix_unitaire_budget_nature'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

            $detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNature();
            $m_detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNatureMapper();
            $m_detail_forms_budget_nature->find($_POST['id_forms_detail_budget_nature'], $detail_forms_budget_nature);
      
            //$detail_forms_budget_nature->setId_forms_detail_budget_nature($compteur_detail_forms_budget_nature);
            //$detail_forms_budget_nature->setId_forms_budget_nature($forms_budget_nature_id);
            $detail_forms_budget_nature->setBps_demande($_POST['bps_demande']);
            $detail_forms_budget_nature->setQte_budget_nature($_POST['qte_budget_nature']);
            $detail_forms_budget_nature->setPrix_unitaire_budget_nature($_POST['prix_unitaire_budget_nature']);
            $detail_forms_budget_nature->setTotal_budget_nature($_POST['qte_budget_nature'] * $_POST['prix_unitaire_budget_nature']);
            $detail_forms_budget_nature->setDisponible_budget_nature($_POST['disponible_budget_nature']);
            $m_detail_forms_budget_nature->update($detail_forms_budget_nature);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
    $this->_redirect('/projet/listdetailbudgetnatureadmin/id/'.$detail_forms_budget_nature->id_forms_budget_nature);
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionutilisateur->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
            $detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNature();
            $m_detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNatureMapper();
            $m_detail_forms_budget_nature->find($id, $detail_forms_budget_nature);
           $this->view->detail_forms_budget_nature = $detail_forms_budget_nature;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
            $detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNature();
            $m_detail_forms_budget_nature = new Application_Model_EuFormsDetailBudgetNatureMapper();
            $m_detail_forms_budget_nature->find($id, $detail_forms_budget_nature);
           $this->view->detail_forms_budget_nature = $detail_forms_budget_nature;
       }   
     }

  }


  





    public function validbudgetadminAction()
    {
        /* page projet/publierprojet - Publier une projet */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $budgetnature = new Application_Model_EuFormsBudgetNature();
        $budgetnatureM = new Application_Model_EuFormsBudgetNatureMapper();
        $budgetnatureM->find($id, $budgetnature);
    
        $budgetnature->setValid_budget($this->_request->getParam('valid'));
    $budgetnatureM->update($budgetnature);
        }

    $this->_redirect('/projet/listbudgetnatureadmin/id/'.$budgetnature->id_forms_budget_nature);
    }






}
