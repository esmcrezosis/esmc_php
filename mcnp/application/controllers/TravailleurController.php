<?php

class TravailleurController extends Zend_Controller_Action{

	  public function init() {
		/* Initialize action controller here */
        include("Url.php");
	  }





  public function addtravailleurindexAction() {
    /* page travailleur/addtravailleur - Ajout d'une travailleur */

  $sessionmembre = new Zend_Session_Namespace('membre');	

  $code_membre =  $sessionmembre->code_membre;



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


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($code_membre) && $code_membre != "" && isset($_POST['travailleur_libelle']) && $_POST['travailleur_libelle'] != "" && isset($_POST['travailleur_experience']) && $_POST['travailleur_experience'] != "" && isset($_POST['travailleur_education']) && $_POST['travailleur_education'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "") {
         
		 $request = $this->getRequest();
		 if ($request->isPost ())  {
		     $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {


/////////////////////////////////////controle code membre
if(isset($code_membre) && $code_membre !=""){
if(strlen($_POST['travailleur_code_membre']) != 20) {
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/travailleur/addtravailleurindex');
                  return;
}else{
if(substr($code_membre, -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($code_membre, $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/travailleur/addtravailleurindex');
                  return;
                }
  }else if(substr($code_membre, -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($code_membre, $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/travailleur/addtravailleurindex');
                  return;
                }
  }
}


                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $travailleur = new Application_Model_EuTravailleur();
                 $m_travailleur = new Application_Model_EuTravailleurMapper();

                 $travailleur_id = $m_travailleur->findConuter() + 1;

                 $travailleur->setTravailleur_id($travailleur_id);
                 $travailleur->setTravailleur_libelle($_POST['travailleur_libelle']);
                 $travailleur->setTravailleur_type($_POST['travailleur_type']);
                 $travailleur->setTravailleur_code_membre($code_membre);
                 $travailleur->setTravailleur_experience($_POST['travailleur_experience']);
                 $travailleur->setTravailleur_niveau($_POST['travailleur_niveau']);
                 $travailleur->setTravailleur_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $travailleur->setTravailleur_education($_POST['travailleur_education']);
                 $travailleur->setTravailleur_formation($_POST['travailleur_formation']);
                 $travailleur->setTravailleur_adresse($_POST['travailleur_adresse']);
                 //$travailleur->setTravailleur_observation($_POST['travailleur_observation']);
                 //$travailleur->setTravailleur_utilisateur($_POST['travailleur_utilisateur']);
                 $travailleur->setCode_zone($_POST['code_zone']);
                 $travailleur->setId_pays($_POST['id_pays']);
                 $travailleur->setId_region($_POST['id_region']);
                 $travailleur->setId_prefecture($_POST['id_prefecture']);
                 $travailleur->setId_canton($_POST['id_canton']);
                 $travailleur->setPublier(1);
                 //$travailleur->setMontant_prestation($_POST['montant_prestation']);
                 $travailleur->setTravailleur_numero_cin($_POST['travailleur_numero_cin']);
                 $travailleur->setTravailleur_date_delivrance_cin($_POST['travailleur_date_delivrance_cin']);
                 $travailleur->setTravailleur_date_expiration_cin($_POST['travailleur_date_expiration_cin']);
              $m_travailleur->save($travailleur);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $detail_travailleur_fichier = array();

          for($i = 0; $i < count($_POST['detail_travailleur_libelle']); $i++){
        $detail_travailleur = new Application_Model_EuDetailTravailleur();
        $m_detail_travailleur = new Application_Model_EuDetailTravailleurMapper();
      
            $compteur_detail_travailleur = $m_detail_travailleur->findConuter() + 1;
            $detail_travailleur->setDetail_travailleur_id($compteur_detail_travailleur);
            $detail_travailleur->setTravailleur_id($travailleur_id);
            $detail_travailleur->setDetail_travailleur_libelle($_POST['detail_travailleur_libelle'][$i]);

           if(isset($_FILES["detail_travailleur_fichier".$i]["name"]) && $_FILES["detail_travailleur_fichier".$i]["name"] != "") {
                  $chemin  = "travailleurs";
                  $file    = $_FILES["detail_travailleur_fichier".$i]["name"];
                  $file1   = "detail_travailleur_fichier".$i;
                  $detail_travailleur_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $detail_travailleur_fichier[$i] = ""; }

            $detail_travailleur->setDetail_travailleur_fichier($detail_travailleur_fichier[$i]);
            $detail_travailleur->setEtat(1);
            $m_detail_travailleur->save($detail_travailleur);
                    }

////////////////////////////////////////////////////////////////////////////////

				 $db->commit();
			     $sessionmcnp->error = "Operation bien effectuee ...";
                 $this->_redirect('/travailleur/addtravailleurindex');
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


  public function addtravailleurintegrateurAction() {
    /* page travailleur/addtravailleurintegrateur - Ajout d'une travailleur */
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
      if (isset($_POST['travailleur_code_membre']) && $_POST['travailleur_code_membre'] != "" && isset($_POST['travailleur_libelle']) && $_POST['travailleur_libelle'] != "" && isset($_POST['travailleur_experience']) && $_POST['travailleur_experience'] != "" && isset($_POST['travailleur_education']) && $_POST['travailleur_education'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "" && isset($_POST['id_postes']) && $_POST['id_postes'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {


/////////////////////////////////////controle code membre
if(isset($_POST['travailleur_code_membre']) && $_POST['travailleur_code_membre']!=""){
if(strlen($_POST['travailleur_code_membre']) != 20) {
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/travailleur/addtravailleurintegrateur');
                  return;
}else{
if(substr($_POST['travailleur_code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['travailleur_code_membre'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/travailleur/addtravailleurintegrateur');
                  return;
                }
  }else if(substr($_POST['travailleur_code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['travailleur_code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/travailleur/addtravailleurintegrateur');
                  return;
                }
  }
}


                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $travailleur = new Application_Model_EuTravailleur();
                 $m_travailleur = new Application_Model_EuTravailleurMapper();

                 $travailleur_id = $m_travailleur->findConuter() + 1;

                 $travailleur->setTravailleur_id($travailleur_id);
                 $travailleur->setTravailleur_libelle($_POST['travailleur_libelle']);
                 $travailleur->setTravailleur_type($_POST['travailleur_type']);
                 $travailleur->setTravailleur_code_membre($_POST['travailleur_code_membre']);
                 $travailleur->setTravailleur_experience($_POST['travailleur_experience']);
                 $travailleur->setTravailleur_niveau($_POST['travailleur_niveau']);
                 $travailleur->setTravailleur_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $travailleur->setTravailleur_education($_POST['travailleur_education']);
                 $travailleur->setTravailleur_formation($_POST['travailleur_formation']);
                 $travailleur->setTravailleur_adresse($_POST['travailleur_adresse']);
                 //$travailleur->setTravailleur_observation($_POST['travailleur_observation']);
                 //$travailleur->setTravailleur_utilisateur($_POST['travailleur_utilisateur']);
                 $travailleur->setCode_zone($_POST['code_zone']);
                 $travailleur->setId_pays($_POST['id_pays']);
                 $travailleur->setId_region($_POST['id_region']);
                 $travailleur->setId_prefecture($_POST['id_prefecture']);
                 $travailleur->setId_canton($_POST['id_canton']);
                 $travailleur->setPublier(1);
                 $travailleur->setId_postes($_POST['id_postes']);
                 //$travailleur->setMontant_prestation($_POST['montant_prestation']);
                 $travailleur->setTravailleur_numero_cin($_POST['travailleur_numero_cin']);
                 $travailleur->setTravailleur_date_delivrance_cin($_POST['travailleur_date_delivrance_cin']);
                 $travailleur->setTravailleur_date_expiration_cin($_POST['travailleur_date_expiration_cin']);
                 $m_travailleur->save($travailleur);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $detail_travailleur_fichier = array();

          for($i = 0; $i < count($_POST['detail_travailleur_libelle']); $i++){
        $detail_travailleur = new Application_Model_EuDetailTravailleur();
        $m_detail_travailleur = new Application_Model_EuDetailTravailleurMapper();
      
            $compteur_detail_travailleur = $m_detail_travailleur->findConuter() + 1;
            $detail_travailleur->setDetail_travailleur_id($compteur_detail_travailleur);
            $detail_travailleur->setTravailleur_id($travailleur_id);
            $detail_travailleur->setDetail_travailleur_libelle($_POST['detail_travailleur_libelle'][$i]);

           if(isset($_FILES["detail_travailleur_fichier".$i]["name"]) && $_FILES["detail_travailleur_fichier".$i]["name"] != "") {
                  $chemin  = "travailleurs";
                  $file    = $_FILES["detail_travailleur_fichier".$i]["name"];
                  $file1   = "detail_travailleur_fichier".$i;
                  $detail_travailleur_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $detail_travailleur_fichier[$i] = ""; }

            $detail_travailleur->setDetail_travailleur_fichier($detail_travailleur_fichier[$i]);
            $detail_travailleur->setEtat(1);
            $m_detail_travailleur->save($detail_travailleur);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembreasso->error = "Operation bien effectuee ...";
                 $this->_redirect('/travailleur/addtravailleurintegrateur');
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


  public function addtravailleurAction() {
    /* page travailleur/addtravailleur - Ajout d'une travailleur */

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
      if (isset($_POST['travailleur_code_membre']) && $_POST['travailleur_code_membre'] != "" && isset($_POST['travailleur_libelle']) && $_POST['travailleur_libelle'] != "" && isset($_POST['travailleur_experience']) && $_POST['travailleur_experience'] != "" && isset($_POST['travailleur_education']) && $_POST['travailleur_education'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "" && isset($_POST['id_postes']) && $_POST['id_postes'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $travailleur = new Application_Model_EuTravailleur();
                 $m_travailleur = new Application_Model_EuTravailleurMapper();

                 $travailleur_id = $m_travailleur->findConuter() + 1;

                 $travailleur->setTravailleur_id($travailleur_id);
                 $travailleur->setTravailleur_libelle($_POST['travailleur_libelle']);
                 $travailleur->setTravailleur_type($_POST['travailleur_type']);
                 $travailleur->setTravailleur_code_membre($_POST['travailleur_code_membre']);
                 $travailleur->setTravailleur_experience($_POST['travailleur_experience']);
                 $travailleur->setTravailleur_niveau($_POST['travailleur_niveau']);
                 $travailleur->setTravailleur_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $travailleur->setTravailleur_education($_POST['travailleur_education']);
                 $travailleur->setTravailleur_formation($_POST['travailleur_formation']);
                 $travailleur->setTravailleur_adresse($_POST['travailleur_adresse']);
                 //$travailleur->setTravailleur_observation($_POST['travailleur_observation']);
                 //$travailleur->setTravailleur_utilisateur($_POST['travailleur_utilisateur']);
                 $travailleur->setCode_zone($_POST['code_zone']);
                 $travailleur->setId_pays($_POST['id_pays']);
                 $travailleur->setId_region($_POST['id_region']);
                 $travailleur->setId_prefecture($_POST['id_prefecture']);
                 $travailleur->setId_canton($_POST['id_canton']);
                 $travailleur->setPublier(1);
                 $travailleur->setId_postes($_POST['id_postes']);
                 //$travailleur->setMontant_prestation($_POST['montant_prestation']);
                 $travailleur->setTravailleur_numero_cin($_POST['travailleur_numero_cin']);
                 $travailleur->setTravailleur_date_delivrance_cin($_POST['travailleur_date_delivrance_cin']);
                 $travailleur->setTravailleur_date_expiration_cin($_POST['travailleur_date_expiration_cin']);
                 $m_travailleur->save($travailleur);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $detail_travailleur_fichier = array();

          for($i = 0; $i < count($_POST['detail_travailleur_libelle']); $i++){
        $detail_travailleur = new Application_Model_EuDetailTravailleur();
        $m_detail_travailleur = new Application_Model_EuDetailTravailleurMapper();
      
            $compteur_detail_travailleur = $m_detail_travailleur->findConuter() + 1;
            $detail_travailleur->setDetail_travailleur_id($compteur_detail_travailleur);
            $detail_travailleur->setTravailleur_id($travailleur_id);
            $detail_travailleur->setDetail_travailleur_libelle($_POST['detail_travailleur_libelle'][$i]);

           if(isset($_FILES["detail_travailleur_fichier".$i]["name"]) && $_FILES["detail_travailleur_fichier".$i]["name"] != "") {
                  $chemin  = "travailleurs";
                  $file    = $_FILES["detail_travailleur_fichier".$i]["name"];
                  $file1   = "detail_travailleur_fichier".$i;
                  $detail_travailleur_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $detail_travailleur_fichier[$i] = ""; }

            $detail_travailleur->setDetail_travailleur_fichier($detail_travailleur_fichier[$i]);
            $detail_travailleur->setEtat(1);
            $m_detail_travailleur->save($detail_travailleur);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/travailleur/listtravailleur');
         
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




  public function edittravailleurAction() {
    /* page travailleur/addtravailleur - Ajout d'une travailleur */

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
      if (isset($_POST['travailleur_libelle']) && $_POST['travailleur_libelle'] != "" && isset($_POST['travailleur_experience']) && $_POST['travailleur_experience'] != "" && isset($_POST['travailleur_education']) && $_POST['travailleur_education'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "" && isset($_POST['id_postes']) && $_POST['id_postes'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $travailleur = new Application_Model_EuTravailleur();
                 $m_travailleur = new Application_Model_EuTravailleurMapper();
                 $m_travailleur->find($_POST['travailleur_id'], $travailleur);

                 //$travailleur->setTravailleur_id($travailleur_id);
                 $travailleur->setTravailleur_libelle($_POST['travailleur_libelle']);
                 $travailleur->setTravailleur_type($_POST['travailleur_type']);
                 //$travailleur->setTravailleur_code_membre($_POST['travailleur_code_membre']);
                 $travailleur->setTravailleur_experience($_POST['travailleur_experience']);
                 $travailleur->setTravailleur_niveau($_POST['travailleur_niveau']);
                 //$travailleur->setTravailleur_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $travailleur->setTravailleur_education($_POST['travailleur_education']);
                 $travailleur->setTravailleur_formation($_POST['travailleur_formation']);
                 $travailleur->setTravailleur_adresse($_POST['travailleur_adresse']);
                 //$travailleur->setTravailleur_observation($_POST['travailleur_observation']);
                 //$travailleur->setTravailleur_utilisateur($_POST['travailleur_utilisateur']);
                 $travailleur->setCode_zone($_POST['code_zone']);
                 $travailleur->setId_pays($_POST['id_pays']);
                 $travailleur->setId_region($_POST['id_region']);
                 $travailleur->setId_prefecture($_POST['id_prefecture']);
                 $travailleur->setId_canton($_POST['id_canton']);
                 //$travailleur->setPublier(0);
                 $travailleur->setId_postes($_POST['id_postes']);
                 //$travailleur->setMontant_prestation($_POST['montant_prestation']);
                 $travailleur->setTravailleur_numero_cin($_POST['travailleur_numero_cin']);
                 $travailleur->setTravailleur_date_delivrance_cin($_POST['travailleur_date_delivrance_cin']);
                 $travailleur->setTravailleur_date_expiration_cin($_POST['travailleur_date_expiration_cin']);
                 $m_travailleur->update($travailleur);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/travailleur/listtravailleur');
         
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
               $travailleur = new Application_Model_EuTravailleur();
               $mtravailleur = new Application_Model_EuTravailleurMapper();
           $mtravailleur->find($id,$travailleur);
           $this->view->travailleur = $travailleur;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $travailleur = new Application_Model_EuTravailleur();
               $mtravailleur = new Application_Model_EuTravailleurMapper();
           $mtravailleur->find($id,$travailleur);
           $this->view->travailleur = $travailleur;
       }   
     }

  }


  




  public function listtravailleurAction() {
    /* page travailleur/listtravailleur - liste des travailleurs */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $travailleur = new Application_Model_EuTravailleurMapper();
    $this->view->entries = $travailleur->fetchAllByMembre($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }
  
  


    public function publiertravailleurAction()
    {
        /* page travailleur/publiertravailleur - Publier une travailleur */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $travailleur = new Application_Model_EuTravailleur();
        $travailleurM = new Application_Model_EuTravailleurMapper();
        $travailleurM->find($id, $travailleur);
    
        $travailleur->setPublier($this->_request->getParam('publier'));
    $travailleurM->update($travailleur);
        }

    $this->_redirect('/travailleur/listtravailleur');
    }



  public function detailtravailleurAction()
  {
    /* page espacepersonnel/detailtravailleur - Détail d'une demande */

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
    $a = new Application_Model_EuTravailleur();
    $ma = new Application_Model_EuTravailleurMapper();
    $ma->find($id, $a);
    $this->view->travailleur = $a;
      }

  }




  public function listdetailtravailleurAction() {
    /* page travailleur/listtravailleur - liste des travailleurs */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

    $detail_travailleur = new Application_Model_EuDetailTravailleurMapper();
    $this->view->entries = $detail_travailleur->fetchAllByTravailleur($id);
    }

    $this->view->tabletri = 1;
  }
  
  
  

    public function etatdetailtravailleurAction()
    {
        /* page travailleur/publiertravailleur - Publier une travailleur */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_travailleur = new Application_Model_EuDetailTravailleur();
        $detail_travailleurM = new Application_Model_EuDetailTravailleurMapper();
        $detail_travailleurM->find($id, $detail_travailleur);
    
        $detail_travailleur->setEtat($this->_request->getParam('etat'));
    $detail_travailleurM->update($detail_travailleur);
        }

    $this->_redirect('/travailleur/listdetailtravailleur/id/'.$detail_travailleur->travailleur_id);
    }






  public function supptravailleurAction()
  {
    /* page travailleur/supptravailleur - Suppression d'une travailleur */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

      $travailleurM = new Application_Model_EuTravailleurMapper();
      $travailleurM->delete($id);
    }

    $this->_redirect('/travailleur/listtravailleur');
  }








  public function edittravailleuradminAction() {
    /* page travailleur/addtravailleur - Ajout d'une travailleur */

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
      if (isset($_POST['travailleur_libelle']) && $_POST['travailleur_libelle'] != "" && isset($_POST['travailleur_experience']) && $_POST['travailleur_experience'] != "" && isset($_POST['travailleur_adresse']) && $_POST['travailleur_adresse'] != "" && isset($_POST['travailleur_observation']) && $_POST['travailleur_observation'] != "" && isset($_POST['travailleur_type']) && $_POST['travailleur_type'] != "" && isset($_POST['travailleur_niveau']) && $_POST['travailleur_niveau'] != "" && isset($_POST['id_postes']) && $_POST['id_postes'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $travailleur = new Application_Model_EuTravailleur();
                 $m_travailleur = new Application_Model_EuTravailleurMapper();
                 $m_travailleur->find($_POST['travailleur_id'], $travailleur);

                 //$travailleur->setTravailleur_id($travailleur_id);
                 $travailleur->setTravailleur_libelle($_POST['travailleur_libelle']);
                 $travailleur->setTravailleur_type($_POST['travailleur_type']);
                 //$travailleur->setTravailleur_code_membre($_POST['travailleur_code_membre']);
                 $travailleur->setTravailleur_experience($_POST['travailleur_experience']);
                 $travailleur->setTravailleur_niveau($_POST['travailleur_niveau']);
                 //$travailleur->setTravailleur_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $travailleur->setTravailleur_education($_POST['travailleur_education']);
                 $travailleur->setTravailleur_formation($_POST['travailleur_formation']);
                 $travailleur->setTravailleur_adresse($_POST['travailleur_adresse']);
                 $travailleur->setTravailleur_observation($_POST['travailleur_observation']);
                 $travailleur->setTravailleur_utilisateur($sessionutilisateur->id_utilisateur);//$_POST['travailleur_utilisateur']
                 //$travailleur->setCode_zone($_POST['code_zone']);
                 //$travailleur->setId_pays($_POST['id_pays']);
                 //$travailleur->setId_region($_POST['id_region']);
                 //$travailleur->setId_prefecture($_POST['id_prefecture']);
                 //$travailleur->setId_canton($_POST['id_canton']);
                 //$travailleur->setPublier(0);
                 $travailleur->setId_postes($_POST['id_postes']);
                 $travailleur->setMontant_prestation($_POST['montant_prestation']);
                 $travailleur->setTravailleur_numero_cin($_POST['travailleur_numero_cin']);
                 $travailleur->setTravailleur_date_delivrance_cin($_POST['travailleur_date_delivrance_cin']);
                 $travailleur->setTravailleur_date_expiration_cin($_POST['travailleur_date_expiration_cin']);
                 $m_travailleur->update($travailleur);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/travailleur/listtravailleuradmin');
         
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
               $travailleur = new Application_Model_EuTravailleur();
               $mtravailleur = new Application_Model_EuTravailleurMapper();
           $mtravailleur->find($id,$travailleur);
           $this->view->travailleur = $travailleur;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $travailleur = new Application_Model_EuTravailleur();
               $mtravailleur = new Application_Model_EuTravailleurMapper();
           $mtravailleur->find($id,$travailleur);
           $this->view->travailleur = $travailleur;
       }   
     }

  }


  




  public function listtravailleuradminAction() {
    /* page travailleur/listtravailleur - liste des travailleurs */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $travailleur = new Application_Model_EuTravailleurMapper();
    //$this->view->entries = $travailleur->fetchAllByCanton($sessionutilisateur->id_canton);
    $this->view->entries = $travailleur->fetchAll2();

    $this->view->tabletri = 1;
  }
  
  


    public function publiertravailleuradminAction()
    {
        /* page travailleur/publiertravailleur - Publier une travailleur */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $travailleur = new Application_Model_EuTravailleur();
        $travailleurM = new Application_Model_EuTravailleurMapper();
        $travailleurM->find($id, $travailleur);
    
        $travailleur->setPublier($this->_request->getParam('publier'));
    $travailleurM->update($travailleur);
        }

    $this->_redirect('/travailleur/listtravailleuradmin');
    }



  public function detailtravailleuradminAction()
  {
    /* page espacepersonnel/detailtravailleur - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTravailleur();
    $ma = new Application_Model_EuTravailleurMapper();
    $ma->find($id, $a);
    $this->view->travailleur = $a;
      }

  }




  public function listdetailtravailleuradminAction() {
    /* page travailleur/listtravailleur - liste des travailleurs */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

    $detail_travailleur = new Application_Model_EuDetailTravailleurMapper();
    $this->view->entries = $detail_travailleur->fetchAllByTravailleur($id);
    }

    $this->view->tabletri = 1;
  }
  
  
  

    public function etatdetailtravailleuradminAction()
    {
        /* page travailleur/publiertravailleur - Publier une travailleur */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_travailleur = new Application_Model_EuDetailTravailleur();
        $detail_travailleurM = new Application_Model_EuDetailTravailleurMapper();
        $detail_travailleurM->find($id, $detail_travailleur);
    
        $detail_travailleur->setEtat($this->_request->getParam('etat'));
    $detail_travailleurM->update($detail_travailleur);
        }

    $this->_redirect('/travailleur/listdetailtravailleuradmin/id/'.$detail_travailleur->travailleur_id);
    }










  public function listtravailleurpbfAction() {
    /* page travailleur/listtravailleurpbf - liste des travailleurs pbf */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

    $travailleur = new Application_Model_EuTravailleurMapper();
    $this->view->entries = $travailleur->fetchAll2();

    $this->view->tabletri = 1;
  }
  
  







}
