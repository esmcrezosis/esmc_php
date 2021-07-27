<?php

class CoincidenceController extends Zend_Controller_Action{

	  public function init() {
		/* Initialize action controller here */
        include("Url.php");
	  }





  public function addcoincidenceindexAction() {
    /* page coincidence/addcoincidence - Ajout d'une coincidence */
  $sessionmcnp = new Zend_Session_Namespace('mcnp');

  //$this->_helper->layout->disableLayout();
  $this->_helper->layout()->setLayout('layoutpublicesmcperso');



    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['type_bon_apporteur']) && $_POST['type_bon_apporteur'] != "" && isset($_POST['code_membre_apporteur']) && $_POST['code_membre_apporteur'] != "" && isset($_POST['montant_apporteur']) && $_POST['montant_apporteur'] != "" && isset($_POST['type_bon_beneficiaire']) && $_POST['type_bon_beneficiaire'] != "" && isset($_POST['code_membre_beneficiaire']) && $_POST['code_membre_beneficiaire'] != "" && isset($_POST['montant_beneficiaire']) && $_POST['montant_beneficiaire'] != "") {
         
		 $request = $this->getRequest();
		 if ($request->isPost ())  {
		     $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {


  $membreappro = new Application_Model_EuMembre();
  $m_membre  = new Application_Model_EuMembreMapper();
    $membremoraleappro = new Application_Model_EuMembreMorale();
  $m_membremorale  = new Application_Model_EuMembreMoraleMapper();
  
  if(substr($_POST['code_membre_apporteur'],19,1) == 'P')  {
    $findappro = $m_membre->find($_POST['code_membre_apporteur'],$membreappro);
    if($membreappro->desactiver == 1)  {
      $db->rollback();
        $sessionmcnp->error = "Ce membre dont le code membre  ".$_POST['code_membre_apporteur']."  n'est pas autoriser à effectuer de cette opération  ...";
      return;
    }
  }  else {
      $findappro = $m_membremorale->find($_POST['code_membre_apporteur'],$membremoraleappro);
      if($membremoraleappro->desactiver == 1)  {
        $db->rollback();
            $sessionmcnp->error = "Ce membre dont le code membre  ".$_POST['code_membre_apporteur']."  n'est pas autoriser à effectuer de cette opération  ...";
          return;
      }   
  }
  
  
  if(substr($_POST['code_membre_beneficiaire'],19,1) == 'P')  {
    $findappro = $m_membre->find($_POST['code_membre_beneficiaire'],$membreappro);
    if($membreappro->desactiver == 1)  {
      $db->rollback();
        $sessionmcnp->error = "Ce membre dont le code membre  ".$_POST['code_membre_beneficiaire']."  n'est pas autoriser à effectuer de cette opération  ...";
      return;
    }
  }  else {
      $findappro = $m_membremorale->find($_POST['code_membre_beneficiaire'],$membremoraleappro);
      if($membremoraleappro->desactiver == 1)  {
        $db->rollback();
            $sessionmcnp->error = "Ce membre dont le code membre  ".$_POST['code_membre_beneficiaire']."  n'est pas autoriser à effectuer de cette opération  ...";
          return;
      }   
  }
  

if($_POST['code_membre_beneficiaire'] == $_POST['code_membre_apporteur']) {
                                    $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre du bénéficiaire doit etre different du Code Membre de l'apporteur. Merci...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
}
/////////////////////////////////////controle code membre
if(strlen($_POST['code_membre_apporteur']) != 20) {
                                    $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
}else{
if(substr($_POST['code_membre_apporteur'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                if($membre_mapper->find($_POST['code_membre_apporteur'], $membre)){
                                }else{
                                    $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
                                }
                
                if($membre->desactiver == 1)  {
                        $db->rollback();
                                $sessionmcnp->error = "Ce membre dont le code membre  ".$_POST['code_membre_apporteur']."  n'est pas autoriser à bénéficier de cette opération  ...";
                          return;
                      }
                
                
                $canton = $membre->id_canton;
                $nom = $membre->nom_membre;
                $prenom = $membre->prenom_membre;
                $email = $membre->email_membre;
                $mobile_apporteur = $membre->portable_membre;
                $raison = "";
    } else if(substr($_POST['code_membre_apporteur'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                if($membremorale_mapper->find($_POST['code_membre_apporteur'], $membremorale)){
                                }else{
                                  $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
                                }
                
                if($membremorale->desactiver == 1)  {
                        $db->rollback();
                                $sessionmcnp->error = "Ce membre dont le code membre  ".$_POST['code_membre_apporteur']."  n'est pas autoriser à bénéficier de cette opération  ...";
                          return;
                      }
                
                
                $canton = $membremorale->id_canton;
                $nom = "";
                $prenom = "";
                $email = $membremorale->email_membre;
                $mobile_apporteur = $membremorale->portable_membre;
                $raison = $membremorale->raison_sociale;
    }else{
      $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
    }
}

/////////////////////////////////////controle code membre
if(strlen($_POST['code_membre_beneficiaire']) != 20) {
                                    $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
}else{
if(substr($_POST['code_membre_beneficiaire'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                if($membre_mapper->find($_POST['code_membre_beneficiaire'], $membre)){
                                }else{
                                    $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
                                }
                
                if($membre->desactiver == 1)  {
                        $db->rollback();
                                $sessionmcnp->error = "Ce membre dont le code membre  ".$_POST['code_membre_beneficiaire']."  n'est pas autoriser à bénéficier de cette opération  ...";
                          return;
                      }
                
                
                $canton = $membre->id_canton;
                $nom = $membre->nom_membre;
                $prenom = $membre->prenom_membre;
                $email = $membre->email_membre;
                $mobile_beneficiaire = $membre->portable_membre;
                $raison = "";
    } else if(substr($_POST['code_membre_beneficiaire'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                if($membremorale_mapper->find($_POST['code_membre_beneficiaire'], $membremorale)){
                                }else{
                                  $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
                                }
                
                if($membremorale->desactiver == 1)  {
                        $db->rollback();
                                $sessionmcnp->error = "Ce membre dont le code membre  ".$_POST['code_membre_beneficiaire']."  n'est pas autoriser à bénéficier de cette opération  ...";
                          return;
                      }
                
                
                $canton = $membremorale->id_canton;
                $nom = "";
                $prenom = "";
                $email = $membremorale->email_membre;
                $mobile_beneficiaire = $membremorale->portable_membre;
                $raison = $membremorale->raison_sociale;
    }else{
      $db->rollback();
                                    $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre...";
                                    //$this->_redirect('/souscriptionbon/addbanappro');
                                    return;
    }
}


          if(isset($_POST['code_tegc_apporteur']) && isset($_POST['code_tegc_beneficiaire']) && $_POST['code_tegc_apporteur'] == $_POST['code_tegc_beneficiaire']) {
              $db->rollback();
                $sessionmcnp->error = "Impossible de faire l'approvisionnement à vous-même ...";
            return;
          }



                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($_POST['code_membre_apporteur']);
                    $bon_neutre3_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre3 = $bon_neutre3_mapper->fetchAllByMembre($_POST['code_membre_beneficiaire']);
                    if(count($bon_neutre2) > 0 && count($bon_neutre3) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

if($request->getParam("montant_apporteur") <= 0){
  $db->rollback();
                $sessionmcnp->error = "Le montant à allouer doit etre supérieur à 0...";
  //$this->_redirect('/souscriptionbon/addbanappro');
  return;

}

if($request->getParam("montant_apporteur") > $bon_neutre->getBon_neutre_montant_solde()){
  $db->rollback();
                $sessionmcnp->error = "Le montant à allouer est supérieur au solde de votre BAn...";
  //$this->_redirect('/souscriptionbon/addbanappro');
  return;

}

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre3->bon_neutre_id, $bon_neutre);

if($request->getParam("montant_beneficiaire") <= 0){
  $db->rollback();
                $sessionmcnp->error = "Le montant à allouer doit etre supérieur à 0...";
  //$this->_redirect('/souscriptionbon/addbanappro');
  return;

}

if($request->getParam("montant_beneficiaire") > $bon_neutre->getBon_neutre_montant_solde()){
  $db->rollback();
                $sessionmcnp->error = "Le montant à allouer est supérieur au solde de votre BAn...";
  //$this->_redirect('/souscriptionbon/addbanappro');
  return;

}

          //$code_envoi = strtoupper(Util_Utils::genererCodeSMS(9));/
          do{
                              $code_envoi = strtoupper(Util_Utils::genererCodeSMS(7));
                              $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
                              $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeEnvoi($code_envoi);
          }while(count($sms_connexion2) > 0);
          //$code_recu = strtoupper(Util_Utils::genererCodeSMS(9));/
          do{
                              $code_recu = strtoupper(Util_Utils::genererCodeSMS(7));
                              $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
                              $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeRecu($code_recu);
          }while(count($sms_connexion2) > 0);

          $date_id = new Zend_Date(Zend_Date::ISO_8601);
          $sms_connexion1 = new Application_Model_EuSmsConnexion();
          $sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();

          $compteur = $sms_connexion1_mapper->findConuter() + 1;
          $sms_connexion1->setSms_connexion_id($compteur);
          $sms_connexion1->setSms_connexion_code_envoi($code_envoi);
          $sms_connexion1->setSms_connexion_code_recu("Veuillez saisir ce code dans le formulaire de confirmation de la coincidence : ".$code_recu.". Merci. ESMC");
          $sms_connexion1->setSms_connexion_code_membre($_POST['code_membre_beneficiaire']);
          $sms_connexion1->setSms_connexion_utilise(0);
          $sms_connexion1->setSms_connexion_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
          $sms_connexion1_mapper->save($sms_connexion1);


$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms3Easys($compteur, $mobile_beneficiaire, "Veuillez saisir ce code dans le formulaire de confirmation de la coincidence : ".$code_recu.". Merci. ESMC");        




                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $coincidence = new Application_Model_EuCoincidence();
                 $m_coincidence = new Application_Model_EuCoincidenceMapper();

                 $coincidence_id = $m_coincidence->findConuter() + 1;

                 $coincidence->setId_coincidence($coincidence_id);
                 $coincidence->setDate_coincidence($date_id->toString('yyyy-MM-dd HH:mm:ss'));

                 $coincidence->setType_bon_apporteur($_POST['type_bon_apporteur']);
                 $coincidence->setType_bon_beneficiaire($_POST['type_bon_beneficiaire']);

                 $coincidence->setCode_membre_apporteur($_POST['code_membre_apporteur']);
                 $coincidence->setCode_membre_beneficiaire($_POST['code_membre_beneficiaire']);

                 $coincidence->setMontant_apporteur($_POST['montant_apporteur']);
                 $coincidence->setMontant_beneficiaire($_POST['montant_beneficiaire']);

          if(isset($_POST['cat_produit_apporteur']) && isset($_POST['cat_produit_beneficiaire']) && $_POST['cat_produit_apporteur'] == $_POST['cat_produit_beneficiaire']) {
                 $coincidence->setCat_produit_apporteur($_POST['cat_produit_apporteur']);
                 $coincidence->setCat_produit_beneficiaire($_POST['cat_produit_beneficiaire']);
               }

          if(isset($_POST['code_tegc_apporteur']) && isset($_POST['code_tegc_beneficiaire']) && $_POST['code_tegc_apporteur'] == $_POST['code_tegc_beneficiaire']) {
                 $coincidence->setCode_tegc_apporteur($_POST['code_tegc_apporteur']);
                 $coincidence->setCode_tegc_beneficiaire($_POST['code_tegc_beneficiaire']);
               }

                 $coincidence->setCode_apporteur($code_envoi);
                 $coincidence->setCode_beneficiaire($code_recu);

          if(isset($_POST['type_bon_apporteur']) && $_POST['type_bon_apporteur'] == "BS") {
                 $coincidence->setType_compte_apporteur($_POST['type_compte_apporteur1']);
               }
          if(isset($_POST['type_bon_beneficiaire']) && $_POST['type_bon_beneficiaire'] == "BS") {
                 $coincidence->setType_compte_beneficiaire($_POST['type_compte_beneficiaire1']);
               }

          if(isset($_POST['type_bon_apporteur']) && $_POST['type_bon_apporteur'] == "BAi") {
                 $coincidence->setType_compte_apporteur($_POST['type_compte_apporteur2']);
               }
          if(isset($_POST['type_bon_beneficiaire']) && $_POST['type_bon_beneficiaire'] == "BAi") {
                 $coincidence->setType_compte_beneficiaire($_POST['type_compte_beneficiaire2']);
               }

                 //$coincidence->setId_canton_apporteur($_POST['id_canton_apporteur']);
                 //$coincidence->setId_canton_beneficiaire($_POST['id_canton_beneficiaire']);

                 $coincidence->setPublier(0);
                 $m_coincidence->save($coincidence);

////////////////////////////////////////////////////////////////////////////////


				 $db->commit();
			     $sessionmcnp->error = "Operation bien effectuee ...";
                 $this->_redirect('/coincidence/addcoincidenceindex');
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



  public function addcoincidenceAction() {
    /* page coincidence/addcoincidence - Ajout d'une coincidence */

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
     $selection = $t_tegc->select();
     $selection->where('nom_tegc is not null');
     if(substr($sessionmembre->code_membre,19,1) == "M") {
        $selection->where('code_membre like ?',$sessionmembre->code_membre);
     } else {
          $selection->where('code_membre_physique like ?',$sessionmembre->code_membre);
       }
     
     $selection->order('nom_tegc asc');
       $tes = $t_tegc->fetchAll($selection);
     $this->view->tes = $tes;
     


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['coincidence_code_membre']) && $_POST['coincidence_code_membre'] != "" && isset($_POST['coincidence_libelle']) && $_POST['coincidence_libelle'] != "" && isset($_POST['coincidence_experience']) && $_POST['coincidence_experience'] != "" && isset($_POST['coincidence_education']) && $_POST['coincidence_education'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $coincidence = new Application_Model_EuCoincidence();
                 $m_coincidence = new Application_Model_EuCoincidenceMapper();

                 $coincidence_id = $m_coincidence->findConuter() + 1;

                 $coincidence->setCoincidence_id($coincidence_id);
                 $coincidence->setCoincidence_libelle($_POST['coincidence_libelle']);
                 $coincidence->setCoincidence_type($_POST['coincidence_type']);
                 $coincidence->setCoincidence_code_membre($_POST['coincidence_code_membre']);
                 $coincidence->setCoincidence_experience($_POST['coincidence_experience']);
                 $coincidence->setCoincidence_niveau($_POST['coincidence_niveau']);
                 $coincidence->setCoincidence_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $coincidence->setCoincidence_education($_POST['coincidence_education']);
                 $coincidence->setCoincidence_formation($_POST['coincidence_formation']);
                 $coincidence->setCoincidence_adresse($_POST['coincidence_adresse']);
                 //$coincidence->setCoincidence_observation($_POST['coincidence_observation']);
                 //$coincidence->setCoincidence_utilisateur($_POST['coincidence_utilisateur']);
                 $coincidence->setCode_zone($_POST['code_zone']);
                 $coincidence->setId_pays($_POST['id_pays']);
                 $coincidence->setId_region($_POST['id_region']);
                 $coincidence->setId_prefecture($_POST['id_prefecture']);
                 $coincidence->setId_canton($_POST['id_canton']);
                 $coincidence->setPublier(1);
                 $m_coincidence->save($coincidence);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $detail_coincidence_fichier = array();

          for($i = 0; $i < count($_POST['detail_coincidence_libelle']); $i++){
        $detail_coincidence = new Application_Model_EuDetailCoincidence();
        $m_detail_coincidence = new Application_Model_EuDetailCoincidenceMapper();
      
            $compteur_detail_coincidence = $m_detail_coincidence->findConuter() + 1;
            $detail_coincidence->setDetail_coincidence_id($compteur_detail_coincidence);
            $detail_coincidence->setCoincidence_id($coincidence_id);
            $detail_coincidence->setDetail_coincidence_libelle($_POST['detail_coincidence_libelle'][$i]);

           if(isset($_FILES["detail_coincidence_fichier".$i]["name"]) && $_FILES["detail_coincidence_fichier".$i]["name"] != "") {
                  $chemin  = "coincidences";
                  $file    = $_FILES["detail_coincidence_fichier".$i]["name"];
                  $file1   = "detail_coincidence_fichier".$i;
                  $detail_coincidence_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $detail_coincidence_fichier[$i] = ""; }

            $detail_coincidence->setDetail_coincidence_fichier($detail_coincidence_fichier[$i]);
            $detail_coincidence->setEtat(1);
            $m_detail_coincidence->save($detail_coincidence);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/coincidence/listcoincidence');
         
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




  public function editcoincidenceAction() {
    /* page coincidence/addcoincidence - Ajout d'une coincidence */

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
      if (isset($_POST['coincidence_libelle']) && $_POST['coincidence_libelle'] != "" && isset($_POST['coincidence_experience']) && $_POST['coincidence_experience'] != "" && isset($_POST['coincidence_education']) && $_POST['coincidence_education'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['id_canton']) && $_POST['id_canton'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $coincidence = new Application_Model_EuCoincidence();
                 $m_coincidence = new Application_Model_EuCoincidenceMapper();
                 $m_coincidence->find($_POST['coincidence_id'], $coincidence);

                 //$coincidence->setCoincidence_id($coincidence_id);
                 $coincidence->setCoincidence_libelle($_POST['coincidence_libelle']);
                 $coincidence->setCoincidence_type($_POST['coincidence_type']);
                 //$coincidence->setCoincidence_code_membre($_POST['coincidence_code_membre']);
                 $coincidence->setCoincidence_experience($_POST['coincidence_experience']);
                 $coincidence->setCoincidence_niveau($_POST['coincidence_niveau']);
                 //$coincidence->setCoincidence_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $coincidence->setCoincidence_education($_POST['coincidence_education']);
                 $coincidence->setCoincidence_formation($_POST['coincidence_formation']);
                 $coincidence->setCoincidence_adresse($_POST['coincidence_adresse']);
                 //$coincidence->setCoincidence_observation($_POST['coincidence_observation']);
                 //$coincidence->setCoincidence_utilisateur($_POST['coincidence_utilisateur']);
                 $coincidence->setCode_zone($_POST['code_zone']);
                 $coincidence->setId_pays($_POST['id_pays']);
                 $coincidence->setId_region($_POST['id_region']);
                 $coincidence->setId_prefecture($_POST['id_prefecture']);
                 $coincidence->setId_canton($_POST['id_canton']);
                 //$coincidence->setPublier(0);
                 $m_coincidence->update($coincidence);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/coincidence/listcoincidence');
         
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
               $coincidence = new Application_Model_EuCoincidence();
               $mcoincidence = new Application_Model_EuCoincidenceMapper();
           $mcoincidence->find($id,$coincidence);
           $this->view->coincidence = $coincidence;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $coincidence = new Application_Model_EuCoincidence();
               $mcoincidence = new Application_Model_EuCoincidenceMapper();
           $mcoincidence->find($id,$coincidence);
           $this->view->coincidence = $coincidence;
       }   
     }

  }


  




  public function listcoincidenceapporteurAction() {
    /* page coincidence/listcoincidence - liste des coincidences */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $coincidence = new Application_Model_EuCoincidenceMapper();
    $this->view->entries = $coincidence->fetchAllByApporteur($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }
  

  public function listcoincidencebeneficiaireAction() {
    /* page coincidence/listcoincidence - liste des coincidences */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $coincidence = new Application_Model_EuCoincidenceMapper();
    $this->view->entries = $coincidence->fetchAllByBeneficiaire($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }
  


    public function publiercoincidenceAction()
    {
        /* page coincidence/publiercoincidence - Publier une coincidence */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $coincidence = new Application_Model_EuCoincidence();
        $coincidenceM = new Application_Model_EuCoincidenceMapper();
        $coincidenceM->find($id, $coincidence);
    
        $coincidence->setPublier($this->_request->getParam('publier'));
    $coincidenceM->update($coincidence);
        }

    $this->_redirect('/coincidence/listcoincidence');
    }



  public function detailcoincidenceAction()
  {
    /* page espacepersonnel/detailcoincidence - Détail d'une demande */

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
    $a = new Application_Model_EuCoincidence();
    $ma = new Application_Model_EuCoincidenceMapper();
    $ma->find($id, $a);
    $this->view->coincidence = $a;
      }

  }




  public function listdetailcoincidenceAction() {
    /* page coincidence/listcoincidence - liste des coincidences */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

    $detail_coincidence = new Application_Model_EuDetailCoincidenceMapper();
    $this->view->entries = $detail_coincidence->fetchAllByCoincidence($id);
    }

    $this->view->tabletri = 1;
  }
  
  
  

    public function etatdetailcoincidenceAction()
    {
        /* page coincidence/publiercoincidence - Publier une coincidence */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_coincidence = new Application_Model_EuDetailCoincidence();
        $detail_coincidenceM = new Application_Model_EuDetailCoincidenceMapper();
        $detail_coincidenceM->find($id, $detail_coincidence);
    
        $detail_coincidence->setEtat($this->_request->getParam('etat'));
    $detail_coincidenceM->update($detail_coincidence);
        }

    $this->_redirect('/coincidence/listdetailcoincidence/id/'.$detail_coincidence->coincidence_id);
    }






  public function suppcoincidenceAction()
  {
    /* page coincidence/suppcoincidence - Suppression d'une coincidence */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

      $coincidenceM = new Application_Model_EuCoincidenceMapper();
      $coincidenceM->delete($id);
    }

    $this->_redirect('/coincidence/listcoincidence');
  }








  public function editcoincidenceadminAction() {
    /* page coincidence/addcoincidence - Ajout d'une coincidence */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
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
      if (isset($_POST['coincidence_libelle']) && $_POST['coincidence_libelle'] != "" && isset($_POST['coincidence_experience']) && $_POST['coincidence_experience'] != "" && isset($_POST['coincidence_adresse']) && $_POST['coincidence_adresse'] != "" && isset($_POST['coincidence_observation']) && $_POST['coincidence_observation'] != "" && isset($_POST['coincidence_type']) && $_POST['coincidence_type'] != "" && isset($_POST['coincidence_niveau']) && $_POST['coincidence_niveau'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $coincidence = new Application_Model_EuCoincidence();
                 $m_coincidence = new Application_Model_EuCoincidenceMapper();
                 $m_coincidence->find($_POST['coincidence_id'], $coincidence);

                 //$coincidence->setCoincidence_id($coincidence_id);
                 $coincidence->setCoincidence_libelle($_POST['coincidence_libelle']);
                 $coincidence->setCoincidence_type($_POST['coincidence_type']);
                 //$coincidence->setCoincidence_code_membre($_POST['coincidence_code_membre']);
                 $coincidence->setCoincidence_experience($_POST['coincidence_experience']);
                 $coincidence->setCoincidence_niveau($_POST['coincidence_niveau']);
                 //$coincidence->setCoincidence_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $coincidence->setCoincidence_education($_POST['coincidence_education']);
                 $coincidence->setCoincidence_formation($_POST['coincidence_formation']);
                 $coincidence->setCoincidence_adresse($_POST['coincidence_adresse']);
                 $coincidence->setCoincidence_observation($_POST['coincidence_observation']);
                 $coincidence->setCoincidence_utilisateur($sessionutilisateur->id_utilisateur);//$_POST['coincidence_utilisateur']
                 //$coincidence->setCode_zone($_POST['code_zone']);
                 //$coincidence->setId_pays($_POST['id_pays']);
                 //$coincidence->setId_region($_POST['id_region']);
                 //$coincidence->setId_prefecture($_POST['id_prefecture']);
                 //$coincidence->setId_canton($_POST['id_canton']);
                 //$coincidence->setPublier(0);
                 $m_coincidence->update($coincidence);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/coincidence/listcoincidenceadmin');
         
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
               $coincidence = new Application_Model_EuCoincidence();
               $mcoincidence = new Application_Model_EuCoincidenceMapper();
           $mcoincidence->find($id,$coincidence);
           $this->view->coincidence = $coincidence;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $coincidence = new Application_Model_EuCoincidence();
               $mcoincidence = new Application_Model_EuCoincidenceMapper();
           $mcoincidence->find($id,$coincidence);
           $this->view->coincidence = $coincidence;
       }   
     }

  }


  




  public function listcoincidenceadminAction() {
    /* page coincidence/listcoincidence - liste des coincidences */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $coincidence = new Application_Model_EuCoincidenceMapper();
    $this->view->entries = $coincidence->fetchAllByCanton($sessionutilisateur->id_canton);

    $this->view->tabletri = 1;
  }
  
  


    public function publiercoincidenceadminAction()
    {
        /* page coincidence/publiercoincidence - Publier une coincidence */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $coincidence = new Application_Model_EuCoincidence();
        $coincidenceM = new Application_Model_EuCoincidenceMapper();
        $coincidenceM->find($id, $coincidence);
    
        $coincidence->setPublier($this->_request->getParam('publier'));
    $coincidenceM->update($coincidence);
        }

    $this->_redirect('/coincidence/listcoincidenceadmin');
    }



  public function detailcoincidenceadminAction()
  {
    /* page espacepersonnel/detailcoincidence - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuCoincidence();
    $ma = new Application_Model_EuCoincidenceMapper();
    $ma->find($id, $a);
    $this->view->coincidence = $a;
      }

  }




  public function listdetailcoincidenceadminAction() {
    /* page coincidence/listcoincidence - liste des coincidences */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

    $detail_coincidence = new Application_Model_EuDetailCoincidenceMapper();
    $this->view->entries = $detail_coincidence->fetchAllByCoincidence($id);
    }

    $this->view->tabletri = 1;
  }
  
  
  

    public function etatdetailcoincidenceadminAction()
    {
        /* page coincidence/publiercoincidence - Publier une coincidence */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_coincidence = new Application_Model_EuDetailCoincidence();
        $detail_coincidenceM = new Application_Model_EuDetailCoincidenceMapper();
        $detail_coincidenceM->find($id, $detail_coincidence);
    
        $detail_coincidence->setEtat($this->_request->getParam('etat'));
    $detail_coincidenceM->update($detail_coincidence);
        }

    $this->_redirect('/coincidence/listdetailcoincidenceadmin/id/'.$detail_coincidence->coincidence_id);
    }





}
