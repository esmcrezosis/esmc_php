<?php

class FormsguichetController extends Zend_Controller_Action{


public function formulairedesuiviedesfournisseursAction () {
    /****Personne physique */
    $db = Zend_Db_Table::getDefaultAdapter();
    $nom_membre = "";
    $codemembrephysique = "0010010010010000009P";
    $code_membre_morale = "";
    $prenom_membre = "";
    $raison_sociale = "";
    $filiere = "";

    $dbtselect = "SELECT * FROM eu_membre WHERE code_membre = '$codemembrephysique'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbsearchpersonnephysique = $stmt->fetchAll();
    $countresultdbsearchpersonnephysique = count($dbsearchpersonnephysique);

    /** Personne morale  et En precisant le code type acteur(EI,PEI,POSE,OSE)*/

    $dbtselect = "SELECT * FROM eu_membre_morale WHERE code_membre_morale=$codemembremorale";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbsearchpersonnemorale = $stmt->fetchAll();
    $countresultdbsearchpersonnemorale = count($dbsearchpersonnemorale);

    /***Personne morale filiere */
    $dbtselect = "SELECT * FROM eu_filiere WHERE nom_filiere =$filiere";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbsearchfiliere = $stmt->fetchAll();
    $countresultdbsearchfiliere = count($dbsearchfiliere);

    /**Validation de la convention */

    $dbtselect = "SELECT * FROM  eu_convention WHERE code_membre = $code_membre_morale";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbsearchconvention = $stmt->fetchAll();
    $countresultdbsearchconvention = count($dbsearchconvention);

    /*** Validation de l'existence d'un compte marchand
     * Le code membre fournit doit commencer par 001 Dans le cas contraire code membre invalide
     * Le code membre fournit doit comporter et se terminer par la lettre P ou M en Majuscule Dans le cas contraire Afficher le message "le code membre est invalide" 
     * Le code membre doit faire strictement 20 caractères Dans le cas contraire Afficher le message "
    */

    if($_POST['integrateur_telephone_ticket_support'] !== ""){
        if(filter_var($_POST['integrateur_telephone_ticket_support'], FILTER_VALIDATE_REGEXP,
           array("options"=>array("regexp"=>"#[^0-9]#")))){
           $validationerrors['verif_integrateur_telephone_ticket_support'] = "Le Numero de telephone du demandeur doit être numérique";
        }
      }

    

}

public function searchbpsAction () {
    $this->_helper->layout->disableLayout();
    $db = Zend_Db_Table::getDefaultAdapter();
    $resultjson = array();
    
    $idbpsvenduavr = $_POST['idbpsvenduavr'];

    $dbtselect = "SELECT * FROM  eu_form_avr WHERE id_bps_vendu_achat_vente_reciproque=$idbpsvenduavr AND validationachatetventereciproque=0";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbbpsachatreciproqueselect_all = $stmt->fetchAll();

    
    foreach ($dbbpsachatreciproqueselect_all as $key => $value){
      $val = $value->id_bps_achete_achat_vente_reciproque;
      $validationachatetventereciproque= $value->validationachatetventereciproque;
      $dbtselect = "SELECT * FROM  eu_bps_achete_avr WHERE id_bps_achete_achat_vente_reciproque=$val";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbbpsavr = $stmt->fetchAll();
      $resultjson[] = array('resultvalue'=>array(
          'nom_bps_achete' => $dbbpsavr,
          'validationachatetventereciproque' =>$validationachatetventereciproque
      ));
  
    }

    header('Content-type:application/json');
    die(json_encode($resultjson));

}

/****Convention ELI */

public function engagementdelivraisonirrevocablebpsAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    $validationdemandeerrors = array();
    $validationsuccess = array();
    $created = Zend_Date::now();
    
    $date_signature_convention_eli = $created->toString('yyyy-MM-dd HH:mm:ss');

    if ($request->isPost()) {
        $civilite = $_POST['complete_name'];
        $code_membre = $_POST['code_membre_eli'];
        $demeure = $_POST['demeure_eli'];
        $quartier_eli = $_POST['quartier_eli'];
        $bp_eli = $_POST['bp_eli'];
        $tel_eli = $_POST['tel_eli'];
        $numero_carte = $_POST['numero_carte'];
        $description_structure = $_POST['description_structure'];
        $montant_eli = $_POST['montant_eli'];
        $description_bps = $_POST['description_bps'];
                


        if($civilite == ""){
            $validationdemandeerrors['empty_civilite'] = "Votre nom & prénoms ne doivent pas être vide";
        }

        if(!isset($civilite)){
            $validationdemandeerrors['exist_civilite'] = "Votre nom & prénoms n'existe pas";         
        }

        if ($montant_eli == "") {
            $validationdemandeerrors['empty_montant_eli'] = "Le montant total du paiement dont vous avez beneficié ne doit pas être vide";
        }

        if(!isset($montant_eli)){
            $validationdemandeerrors['exist_montant_eli'] = "Le montant total du paiement dont vous avez beneficié n'existe pas";         
        }

        if($montant_eli !== ""){
            if(filter_var($montant_eli, FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationdemandeerrors['verif_montant_eli'] = "Le montant total du paiement dont vous avez beneficié doit être ecrit en lettre et en chiffre";
             }
        }

        if($tel_eli !== ""){
            if(!filter_var($tel_eli, FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationdemandeerrors['verif_tel_eli'] = "Votre numéro de téléphone ne doit pas être";
             }
        }

        if($code_membre == ""){
            $validationdemandeerrors['empty_code_membre'] = "Echec d'enregistrement:Votre code membre est inexistant";
        }

        if(!isset($code_membre)){
            $validationdemandeerrors['exist_code_membre'] = "Echec d'enregistrement:Votre code membre est inexistant";
        }

        if ($code_membre != ""){
            if (!in_array(substr($code_membre,-1), array('M'))) {
                $validationdemandeerrors['valid_code_membre'] = "Echec d'enregistrement:Seul les personnes morales sont autorisés à signer l'ELI";

            }
 
            if(strlen($code_membre) != 20){
                $validationdemandeerrors['valid_code_membre'] = "Echec d'enregistrement:Le code membre que vous avez fournit est invalide";
            }
        }

        if(!empty($validationdemandeerrors)){
            $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
        }

        if (empty($validationdemandeerrors)){
            $dbtinsert = "INSERT INTO eu_convention_eli_opi(civilite,code_membre,demeure,quartier,bp,telephone,numero_registre,description_structure,montant,description_bps,date_signature) VALUES ('$civilite','$code_membre','$demeure','$quartier_eli','$bp_eli','$tel_eli','$numero_carte','$description_structure','$montant_eli','$description_bps','$date_signature_convention_eli')";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtinsert);
            $validationsuccess['success_message'] = "Signature de l'Engagement de Livraison Irrévocable  effectué avec succes";
            $_SESSION['validationsuccess'] = $validationsuccess;
        }


    }

    $this->view->datesignature = $date_signature_convention_eli;    
    
}

public function engagementdelivraisonirrevocablebpspourlesmembresdejainscritAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    $validationdemandeerrors = array();
    $validationsuccess = array();
    $created = Zend_Date::now();
	$sessionmembre = new Zend_Session_Namespace('membre');	
    
    $date_signature_convention_eli = $created->toString('yyyy-MM-dd HH:mm:ss');

    $code_membre = $sessionmembre->code_membre;

    $dbtselect = "SELECT * FROM eu_representation WHERE code_membre_morale ='$code_membre' AND titre='Representant'"; 
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbresultrepresentant = $stmt->fetchAll();

    if (count($dbresultrepresentant) > 0){
        $lecodemembredurepresentant = $dbresultrepresentant[0]->code_membre;
    }

    if(count($dbresultrepresentant) == 0){
        $validationerrors['search_representant'] = "Le representant de ce code membre est introuvable";        
    }

    $dbtselect = "SELECT nom_membre, prenom_membre,ville_membre,quartier_membre,bp_membre,portable_membre FROM eu_membre WHERE code_membre='$lecodemembredurepresentant'"; 
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbcodemembre = $stmt->fetchAll();

    $nom=  $dbcodemembre[0]->nom_membre;
    $prenoms = $dbcodemembre[0]->prenom_membre;
    $nometprenoms = $nom." ".$prenoms;
    $ville = $dbcodemembre[0]->ville_membre;
    $quartier = $dbcodemembre[0]->quartier_membre;
    $bp = $dbcodemembre[0]->bp_membre;
    $tel = $dbcodemembre[0]->portable_membre;

$this->view->completenommembre = $nometprenoms;
$this->view->ville = $nometprenoms;
$this->view->quartier = $ville;
$this->view->bp = $quartier;
$this->view->tel = $bp;

    if ($request->isPost()) {
        $civilite = $_POST['complete_name'];
        $code_membre = $sessionmembre->code_membre;		   
        $demeure = $_POST['demeure_eli'];
        $quartier_eli = $_POST['quartier_eli'];
        $bp_eli = $_POST['bp_eli'];
        $tel_eli = $_POST['tel_eli'];
        $numero_carte = $_POST['numero_carte'];
        $description_structure = $_POST['description_structure'];
        $montant_eli = $_POST['montant_eli'];
        $description_bps = $_POST['description_bps'];
                


        if($civilite == ""){
            $validationdemandeerrors['empty_civilite'] = "Votre nom & prénoms ne doivent pas être vide";
        }

        if(!isset($civilite)){
            $validationdemandeerrors['exist_civilite'] = "Votre nom & prénoms n'existe pas";         
        }
/*
        if ($montant_eli == "") {
            $validationdemandeerrors['empty_montant_eli'] = "Le montant total du paiement dont vous avez beneficié ne doit pas être vide";
        }

        if(!isset($montant_eli)){
            $validationdemandeerrors['exist_montant_eli'] = "Le montant total du paiement dont vous avez beneficié n'existe pas";         
        }

        if($montant_eli !== ""){
            if(filter_var($montant_eli, FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationdemandeerrors['verif_montant_eli'] = "Le montant total du paiement dont vous avez beneficié doit être ecrit en lettre et en chiffre";
             }
        }*/

        if($tel_eli !== ""){
            if(!filter_var($tel_eli, FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationdemandeerrors['verif_tel_eli'] = "Votre numéro de téléphone ne doit pas être";
             }
        }

        if($code_membre == ""){
            $validationdemandeerrors['empty_code_membre'] = "Echec d'enregistrement:Votre code membre est inexistant";
        }

        if(!isset($code_membre)){
            $validationdemandeerrors['exist_code_membre'] = "Echec d'enregistrement:Votre code membre est inexistant";
        }

        if ($code_membre != ""){
            if (!in_array(substr($code_membre,-1), array('M'))) {
                $validationdemandeerrors['valid_code_membre'] = "Echec d'enregistrement:Seul les personnes morales sont autorisés à signer l'ELI";

            }
 
            if(strlen($code_membre) != 20){
                $validationdemandeerrors['valid_code_membre'] = "Echec d'enregistrement:Le code membre que vous avez fournit est invalide";
            }
        }

        if(!empty($validationdemandeerrors)){
            $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
        }

        if (empty($validationdemandeerrors)){
            $dbtinsert = "INSERT INTO eu_convention_eli_opi(
                civilite,
                code_membre,
                demeure,
                quartier,
                bp,
                telephone,
                description_structure,
                description_bps,
                date_signature) VALUES (
                '$civilite',
                '$code_membre',
                '$demeure',
                '$quartier_eli',
                '$bp_eli',
                '$tel_eli',
                '$description_structure',
                '$description_bps',
                '$date_signature_convention_eli')";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtinsert);
            $validationsuccess['success_message'] = "Signature du contrat de l'Engagement de Livraison Irrévocable effectué avec succes";
            $_SESSION['validationsuccess'] = $validationsuccess;
            $this->_redirect('/espacepersonnel');		              
        
        }
    }

    $this->view->datesignature = $date_signature_convention_eli;    
    
}


public function lecturedelengagementdelivraisonirrevocableAction () {

}


public function validationdelaconventionelipersonnephysiqueAction () {

}

public function validationdelaconventionelipersonnephysiquespacepersonnelAction () {
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    $dbcv = new Application_Model_DbTable_EuConventionEliOpi();
    $request = $this->getRequest();
    $validationerrors = array();
    $convention_eli_array = array();
    $created = Zend_Date::now();
    $date_signature =  $created->toString('yyyy-MM-dd HH:mm:ss');
	$sessionmembre = new Zend_Session_Namespace('membre');	
    
    $this->view->dateconvention = $date_convention;

    if ($request->isPost()) {
        if(!array_key_exists('eli_opi_select', $_POST)){
            $validationerrors['error_eli_opi_select'] = "Erreur 404:Vous tentez d'effectuer une action qui n'est pas autorisé";
          }
          if(empty($_POST['eli_opi_select'])){
            $validationerrors['empty_eli_opi_select'] = "Vous devez cochez la case correspondant a votre statut sur le contrat";
          }

          $convention_eli_array = array(
            'civilite'=>$_POST['eli_opi_select'],
            'code_membre'=>$sessionmembre->code_membre,
            'date_signature'=>$date_signature
        );
        if (!empty($validationerrors)) {
            $_SESSION['validationerrors'] = $validationerrors;
        }
        $dbselect = $dbcv->select();
        $dbselect->from('eu_convention_eli_opi');
        $dbselect->where("code_membre like '".$sessionmembre->code_membre."'");
        $dbselect_all = $dbcv->fetchAll($dbselect);
        $count = count($dbselect_all);

        if($count !== 0){
            $this->_redirect('/espacepersonnel');       
        }
       
        if (!empty($convention_eli_array) && empty($validationerrors) && $count == 0) {
            if ($dbcv->insert($convention_eli_array)) {
                $this->_redirect('/espacepersonnel');
            }
        }
    }

}

public function recherchedesinformationssurlemembrequisigneeliAction () {
    $code_membre = $_POST['codemembre'];
    $db = Zend_Db_Table::getDefaultAdapter();
    $created = Zend_Date::now();
    $resultjson = array();
    $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
    $erreurdanslarecherchedurepresentant = "";

    $dbtselect = "SELECT * FROM eu_representation WHERE code_membre_morale ='$code_membre' AND titre='Representant'"; 
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbresultrepresentant = $stmt->fetchAll();

    if (count($dbresultrepresentant) > 0){
        $lecodemembredurepresentant = $dbresultrepresentant[0]->code_membre;
    }

    if(count($dbresultrepresentant) == 0){
        $erreurdanslarecherchedurepresentant = "Le representant de ce code membre est introuvable";
        
    }

    $dbtselect = "SELECT nom_membre, prenom_membre,ville_membre,quartier_membre,bp_membre,portable_membre FROM eu_membre WHERE code_membre='$lecodemembredurepresentant'"; 
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbcodemembre = $stmt->fetchAll();

    $nom=  $dbcodemembre[0]->nom_membre;
    $prenoms = $dbcodemembre[0]->prenom_membre;
    $nometprenoms = $nom." ".$prenoms;
    $ville = $dbcodemembre[0]->ville_membre;
    $quartier = $dbcodemembre[0]->quartier_membre;
    $bp = $dbcodemembre[0]->bp_membre;
    $tel = $dbcodemembre[0]->portable_membre;

    $resultmembre = array(
      'nometprenoms' =>$nometprenoms,
      'ville'=>$ville,
      'quartier'=>$quartier,
      'bp'=>$bp,
      'telephone'=>$tel
    );
    
    $resultjson = array(
      'update'=>$resultmembre,
      'error'=>$erreurdanslarecherchedurepresentant
    );

    header('Content-type:application/json');
    die(json_encode($resultjson));
}


public function formsachatreciproquecentralachatAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();

    $dbtselect = "SELECT * FROM  eu_bps_achete_avr";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbbpsachatreciproqueselect_all = $stmt->fetchAll();

    $dbtselect = "SELECT * FROM  eu_bps_vendu_avr";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbbpsventereciproqueselect_all = $stmt->fetchAll();

    $this->view->bpsvendu = $dbbpsventereciproqueselect_all;
    $this->view->bpsacheter = $dbbpsachatreciproqueselect_all;

    
}



public function formulaireassociativedebpsvenduetdebpsacheterventereciproques2Action () {
        /* page espacepersonnel/profil - Modification du profil */

        $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
        $created = Zend_Date::now();
        $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');

        if (!isset($sessionmembre->code_membre)) {
            $this->_redirect('/');
        }
        if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}

           if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}


                $db = Zend_Db_Table::getDefaultAdapter();
                $request = $this->getRequest();

                $dbtselect = "SELECT * FROM  eu_bps_achete_avr";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $dbbpsachatreciproqueselect_all = $stmt->fetchAll();

                $dbtselect = "SELECT * FROM  eu_bps_vendu_avr";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $dbbpsventereciproqueselect_all = $stmt->fetchAll();
/*

    $dbtselect = "UPDATE eu_bps_achete_avr SET nom_bps_achete ='Electromécanicien' WHERE  id_bps_achete_achat_vente_reciproque=29";
    
    
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);

    */
                $this->view->bpsvendu = $dbbpsventereciproqueselect_all;
                $this->view->bpsacheter = $dbbpsachatreciproqueselect_all;
                $code_membre_avr = $sessionmembre->code_membre;
    /*if($code_membre_avr == "" ){
        $this->_redirect("/integrateur/editmembreasso2");
    }*/

                if ($request->isPost()) {
                    $bps_vendu = $_POST['bps_vendu'];
                    if ($bps_vendu == ""){
                        $validationerrors['empty_bps_vendu'] = "le bps vendu ne doit pas être vide";
                    }

                    if(!isset($bps_vendu)){
                        $validationerrors['exist_bps_vendu'] = "le bps vendu n'existe pas";
                    }

                    if(!empty($validationerrors)){
                        $_SESSION['validationerrors'] = $validationerrors;
                    }

                    if (empty($validationerrors)) {
                        $dbselect = "SELECT
                                        eu_bps_vendu_avr.nom_bps_vendu
                                      FROM eu_bps_vendu_avr
                                      WHERE eu_bps_vendu_avr.id_bps_vendu_achat_vente_reciproque='$bps_vendu'";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbselect);
                        $dbsearchbpsvendu = $stmt->fetchAll();
  
                        $nombpsvendu = $dbsearchbpsvendu[0]->nom_bps_vendu;
                        $ref_demande_achat = substr(md5(uniqid(rand(), true)), 0, 8);
                        $real_ref_demande_achat = strtoupper('AVR-'.$ref_demande_achat);
  
  
                        $dbfinsert = "INSERT INTO eu_demande_achat(
                          reference_demande_achat,
                          date_demande,
                          libelle_demande_achat,
                          code_membre) VALUES (
                          '$real_ref_demande_achat',
                          '$date_created',                          
                          '$nombpsvendu',
                          '$code_membre_avr')";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbfinsert);
  
  
                        $dbselect = "SELECT *
                                       FROM eu_demande_achat
                                       WHERE eu_demande_achat.reference_demande_achat ='$real_ref_demande_achat'
                                       AND eu_demande_achat.code_membre='$code_membre_avr'";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbselect);
                        $dbsearchdemandeachat = $stmt->fetchAll();
  
                    if (count($dbsearchdemandeachat) != 0) {
                        $dbidsearchdemandeachat = $dbsearchdemandeachat[0]->id_demande_achat;
                    for ($i = 0; $i< count($_POST['bps_achete_validation']); $i++){
                      $bps_achete = $_POST['bps_achete_validation'][$i];
                      $bps_valider = "1";

                 if ($_POST['bps_achete_validation'][$i] == ""){
                     $validationerrors['empty_bps_achete_validation'] = "Le BPS achete est invalide";
                 }
        
                if(!empty($validationerrors)){
                  $sessionmembre->validationerrors = $validationerrors;
                }

                if (empty($validationerrors)) {

                  $ref_detail_demande_achat = substr(md5(uniqid(rand(), true)), 0, 3);
                  $real_ref_detail_demande_achat = strtoupper('AVR-'.$ref_detail_demande_achat);
                    $dbselect = "SELECT
                                    eu_bps_achete_avr.nom_bps_achete
                                 FROM eu_bps_achete_avr
                                 WHERE eu_bps_achete_avr.id_bps_achete_achat_vente_reciproque = '$bps_achete'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbselect);
                    $dbsearchbpsachete = $stmt->fetchAll();

                    
                    $nombpsachete = $dbsearchbpsachete[0]->nom_bps_achete;

                    $dbfinsert = "INSERT INTO eu_detail_demande_achat(
                                  reference_article,
                                  designation_article,
                                  id_demande_achat) VALUES (
                                  '$real_ref_detail_demande_achat',
                                  '$nombpsachete',
                                  '$dbidsearchdemandeachat')";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfinsert);

                    $dbfinsert = "INSERT INTO eu_form_avr(
                        id_bps_vendu_achat_vente_reciproque,
                        id_bps_achete_achat_vente_reciproque,
                        validationachatetventereciproque,
                        date_avr,
                        code_membre_avr) VALUES (
                        '$bps_vendu',
                        '$bps_achete',
                        '$bps_valider',
                        '$date_created',
                        '$code_membre_avr')";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfinsert);
                    $validationsuccess['success_message'] = "Enregistrement effectué avec succes";
                    $sessionmembre->validationsuccess = $validationsuccess;

                }
            }
        }
    }  
  }
}

public function etablissementdubudgetAction (){

    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $id = (int)$this->_request->getParam('id');

    $dbtselect = "SELECT * FROM  eu_bps_vendu_avr";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbbpsventereciproqueselect_all = $stmt->fetchAll();
    $code_membre_budgetavr = $_SESSION['utilisateur']['code_membre'];
    $ref_demande_achat = substr(md5(uniqid(rand(),true)),0,8);
    $real_ref_demande_achat = strtoupper('BUDGET-'.$ref_demande_achat);

    if ($request->isPost()) {    
        $type_budget = $_POST['type_budget'];
        $bps_vendu = $_POST['bps_vendu'];   
        if ($_POST['bps_vendu'] == ""){
          $validationerrors['empty_bps_vendu'] = "le bps vendu ne doit pas être vide";
        }

        if(!isset($_POST['bps_vendu'])) {
            $validationerrors['exist_bps_vendu'] = "le bps vendu est inexistant";          
        }


        if($_POST['bps_vendu'] !== ""){
            if(!filter_var($_POST['bps_vendu'], FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
               $validationerrors['verif_bps_vendu'] = "Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";
             }
        }
     

        $dbtselect = "SELECT * FROM  eu_bps_vendu_avr WHERE eu_bps_vendu_avr.id_bps_vendu_achat_vente_reciproque='$bps_vendu'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbrecherchedubpsventereciproqueselect = $stmt->fetchAll();

        if ( count($dbrecherchedubpsventereciproqueselect) == 0){
            $validationerrors['search_bps_vendu'] = "le bps vendu que vous avez selectionné est invalide";
        }

        for ($i = 0; $i< count($_POST['bps_demande_avr']); $i++) {
            $bps_demande_avr = $_POST['bps_demande_avr'][$i];
            $qte_avr = $_POST['qte_avr'][$i];
            $prix_unitaire_avr = $_POST['prix_unitaire_avr'][$i];
            $total_avr = $_POST['total_avr'][$i];
            $disponible_avr = $_POST['disponible_avr'][$i];
    
            if ($_POST['bps_demande_avr'][$i] == "") {
                $validationerrors['empty_bps_demande_avr'] = "le bps demandé ne doit pas être vide";
            }

            if (isset($_POST['bps_demande_avr'][$i])) {
                $validationerrors['exist_bps_demande_avr'] = "le bps demandé est inexistant";
            }
    
            if ($_POST['qte_avr'][$i] == "") {
                $validationerrors['empty_qte_avr'] = "la quantité n'est pas saisie";
            }

            if (isset($_POST['qte_avr'][$i])) {
                $validationerrors['exist_qte_avr'] = "la quantité proposé est inexistant";
            }
    
            if ($_POST['qte_avr'] !== "") {
                if (!filter_var(
                    $_POST['qte_avr'][$i],
                    FILTER_VALIDATE_REGEXP,
                   array("options"=>array("regexp"=>"#[0-9]#"))
                )) {
                    $validationerrors['verif_qte_avr'] = "la quantité saisie est invalide";
                }
            }
        
    
            if ($_POST['prix_unitaire_avr'][$i] == "") {
                $validationerrors['empty_prix_unitaire_avr'] = "le prix unitaire du bps n'est pas saisie";
            }

            if (isset($_POST['prix_unitaire_avr'][$i])) {
                $validationerrors['exist_prix_unitaire_avr'] = "la prix unitaire du bps est inexistant";
            }

            if ($_POST['prix_unitaire_avr'][$i] !== "") {
                if (!filter_var(
                    $_POST['prix_unitaire_avr'][$i],
                    FILTER_VALIDATE_REGEXP,
                   array("options"=>array("regexp"=>"#[0-9]#"))
                )) {
                    $validationerrors['verif_prix_unitaire_avr'] = "le prix unitaire saisie est invalide";
                }
            }
    
            if ($_POST['total_avr'][$i] == "") {
                $validationerrors['empty_total_avr'] = "le total du bps n'est pas saisie";
            }

            
            if (isset($_POST['total_avr'][$i])) {
                $validationerrors['exist_total_avr'] = "le total du bps est inexistant";
            }
            if ($_POST['total_avr'][$i] !== "") {
                if (filter_var(
                    $_POST['total_avr'][$i],
                    FILTER_VALIDATE_REGEXP,
                   array("options"=>array("regexp"=>"#[^0-9]#"))
                )) {
                    $validationerrors['verif_total_avr'] = "le total calculé est invalide";
                }
            }
    
    
            if (!in_array($_POST['disponible_avr'][$i], array('0','1'))) {
                $validationerrors['verif_disponible_avr'] = "la disponibilité du produit est invalide";
            }
        }

        if(!empty($validationerrors)){
            $_SESSION['validationerrors'] = $validationerrors;
        } 
  
        if(empty($validationerrors)) {
            $dbfinsert = "INSERT INTO 
                              eu_demande_achat(
                                montant_demande_achat,
                                libelle_demande_achat,
                                reference_demande_achat,
                                code_membre,
                                date_demande) VALUES (
                             '$montant_demande_achat',
                             '$real_libelle_demandeur_achat',
                             '$real_ref_demande_achat',
                             '$code_membre_demandeur_achat',
                             '$date_emission_demande')";
$db->setFetchMode(Zend_Db::FETCH_OBJ);
$stmt = $db->query($dbfinsert);


$dbselect = "SELECT * FROM eu_demande_achat WHERE montant_demande_achat='$montant_demande_achat' AND reference_demande_achat ='$real_ref_demande_achat' AND code_membre='$code_membre_demandeur_achat'";
$db->setFetchMode(Zend_Db::FETCH_OBJ);
$stmt = $db->query($dbselect);
$dbsearchdemandeachat = $stmt->fetchAll();

            for ($i = 0; $i< count($_POST['bps_demande_avr']); $i++){
                $bps_demande_avr = $_POST['bps_demande_avr'][$i];
                $qte_avr = $_POST['qte_avr'][$i];
                $prix_unitaire_avr = $_POST['prix_unitaire_avr'][$i];
                $total_avr = $_POST['total_avr'][$i];
                $disponible_avr = $_POST['disponible_avr'][$i];
        
        
                $dbfselect = "SELECT * FROM eu_forms_budget_nature WHERE reference_type_budget='$id' AND type_budget='$type_budget'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfselect); 
                $dbsearchbudgetnature = $stmt->fetchAll();

                if (count($dbsearchbudgetnature) > 0) {
                    $validationerrors['count_budget_nature'] = "Ce budget a été deja établit sur cette demande d'achat";        
                }
                
                if(count($dbsearchbudgetnature) == 0){
                    $dbfinsert = "INSERT INTO eu_forms_budget_nature(
                                 id_bps_vendu_achat_vente_reciproque,
                                 type_budget,
                                 reference_type_budget,
                                 code_membre_budget) VALUES (
                                '$bps_vendu',
                                '$type_budget',
                                '$id',
                                '$code_membre_budgetavr')";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfinsert);
    
                    $dbfselect = "SELECT id_forms_budget_nature FROM eu_forms_budget_nature WHERE reference_type_budget='$id' AND type_budget='$type_budget' ";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfselect);
                    $recupidbudgetnature = $stmt->fetchAll();
                    
                    if (count($recupidbudgetnature) == 0) {
                        $validationerrors['count_search_budget_nature'] = "Ce budget n'a pas été correctement enregistré";        
                    }

                    if (count($recupidbudgetnature) > 0) {
                        $id_budget_nature = $recupidbudgetnature[0]->id_forms_budget_nature;
    
                        $dbfinsert = "INSERT INTO eu_forms_detail_budget_nature(
                            id_forms_budget_nature,
                            bps_demande,
                            qte_budget_nature,
                            prix_unitaire_budget_nature,
                            total_budget_nature,
                            disponible_budget_nature) VALUES (
                            '$id_budget_nature',
                            '$bps_demande_avr',
                            '$qte_avr',
                            '$prix_unitaire_avr',
                            '$total_avr',
                            '$disponible_avr')";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbfinsert);
        
                        $validationsuccess['success_message'] = "Etablissement du budget pour cette demande d'achat a été effectué avec succes";
                        $_SESSION['validationsuccess'] = $validationsuccess;
                        $this->_redirect("/procedureachat/listedesbudgetetablitenfonctiondelademandeachat");
                        
                    }
             }
          }
        }
    }    


}

public function etablissementdubudgetpourlademandeachatAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $id = (int)$this->_request->getParam('id');

    $dbtselect = "SELECT * FROM  eu_bps_vendu_avr";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbbpsventereciproqueselect_all = $stmt->fetchAll();

    $dbselect = "SELECT * FROM eu_demande_achat WHERE id_demande_achat ='$id'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbselect);
    $dbsearchdemandeachatbudget = $stmt->fetchAll();

    $dbselect = "SELECT * FROM eu_detail_demande_achat WHERE id_demande_achat ='$id'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbselect);
    $dbsearchdemandedetailachatbudget = $stmt->fetchAll();


    $this->view->demandeachatbudget = $dbsearchdemandeachatbudget;
    $this->view->detailachatbudget = $dbsearchdemandedetailachatbudget;
    $this->view->bpsvendu = $dbbpsventereciproqueselect_all;
    $code_membre_budgetavr = $_SESSION['utilisateur']['code_membre'];

    if ($request->isPost()) {    
        $type_budget = $_POST['type_budget'];
        $bps_vendu = $_POST['bps_vendu'];   
        if ($_POST['bps_vendu'] == ""){
          $validationerrors['empty_bps_vendu'] = "le bps vendu ne doit pas être vide";
        }

        if(!isset($_POST['bps_vendu'])) {
            $validationerrors['exist_bps_vendu'] = "le bps vendu est inexistant";          
        }


        if($_POST['bps_vendu'] !== ""){
            if(!filter_var($_POST['bps_vendu'], FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
               $validationerrors['verif_bps_vendu'] = "Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";
             }
        }


        if ($type_budget == ""){
            $validationerrors['empty_type_budget'] = "le type du budget ne doit pas être vide";
        }
  
        if(!isset($type_budget)) {
             $validationerrors['exist_type_budget'] = "le type du budget est inexistant";          
        }

        if ($type_budget == "DA"){
            $validationerrors['valide_type_budget'] = "le type du budget que vous avez selectionné doit être la demande d'achat";
        }

     

        $dbtselect = "SELECT * FROM  eu_bps_vendu_avr WHERE eu_bps_vendu_avr.id_bps_vendu_achat_vente_reciproque='$bps_vendu'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbrecherchedubpsventereciproqueselect = $stmt->fetchAll();

        if ( count($dbrecherchedubpsventereciproqueselect) == '0'){
            $validationerrors['search_bps_vendu'] = "le bps vendu que vous avez selectionné est invalide";
        }

        if(!empty($validationerrors)){
            $_SESSION['validationerrors'] = $validationerrors;
        } 
  
        if(empty($validationerrors)) {

            for ($i = 0; $i< count($_POST['bps_demande_avr']); $i++){
                $bps_demande_avr = $_POST['bps_demande_avr'][$i];
                $qte_avr = $_POST['qte_avr'][$i];
                $prix_unitaire_avr = $_POST['prix_unitaire_avr'][$i];
                $total_avr = $_POST['total_avr'][$i];
                $disponible_avr = $_POST['disponible_avr'][$i];
        
                if ($_POST['bps_demande_avr'][$i] == ""){
                    $validationerrors['empty_bps_demande_avr'] = "le bps demandé ne doit pas être vide";
                }  

                if (isset($_POST['bps_demande_avr'][$i])){
                    $validationerrors['exist_bps_demande_avr'] = "le bps demandé est inexistant";
                }  
        
                if ($_POST['qte_avr'][$i] == ""){
                    $validationerrors['empty_qte_avr'] = "la quantité n'est pas saisie";
                }

                if (isset($_POST['qte_avr'][$i])){
                    $validationerrors['exist_qte_avr'] = "la quantité proposé est inexistant";
                }  
        
                if($_POST['qte_avr'] !== ""){
                    if(!filter_var($_POST['qte_avr'][$i], FILTER_VALIDATE_REGEXP,
                       array("options"=>array("regexp"=>"#[0-9]#")))){
                       $validationerrors['verif_qte_avr'] = "la quantité saisie est invalide";
                     }
                }
            
        
                if ($_POST['prix_unitaire_avr'][$i] == ""){
                    $validationerrors['empty_prix_unitaire_avr'] = "le prix unitaire du bps n'est pas saisie";
                }

                if (isset($_POST['prix_unitaire_avr'][$i])){
                    $validationerrors['exist_prix_unitaire_avr'] = "la prix unitaire du bps est inexistant";
                }  

                if($_POST['prix_unitaire_avr'][$i] !== ""){
                    if(!filter_var($_POST['prix_unitaire_avr'][$i], FILTER_VALIDATE_REGEXP,
                       array("options"=>array("regexp"=>"#[0-9]#")))){
                       $validationerrors['verif_prix_unitaire_avr'] = "le prix unitaire saisie est invalide";
                     }
                } 
        
                if ($_POST['total_avr'][$i] == "") {
                    $validationerrors['empty_total_avr'] = "le total du bps n'est pas saisie";        
                }

                
                if (isset($_POST['total_avr'][$i])){
                    $validationerrors['exist_total_avr'] = "le total du bps est inexistant";
                }  
                if($_POST['total_avr'][$i] !== ""){
                    if(filter_var($_POST['total_avr'][$i], FILTER_VALIDATE_REGEXP,
                       array("options"=>array("regexp"=>"#[^0-9]#")))){
                       $validationerrors['verif_total_avr'] = "le total calculé est invalide";
                     }
                } 
        
        
              if (!in_array($_POST['disponible_avr'][$i], array('0','1'))) {
                $validationerrors['verif_disponible_avr'] = "la disponibilité du produit est invalide";
              }
        
        
        
            if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
            }
            if (empty($validationerrors)) {
                $dbfselect = "SELECT * FROM eu_forms_budget_nature WHERE reference_type_budget='$id' AND type_budget='$type_budget'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfselect); 
                $dbsearchbudgetnature = $stmt->fetchAll();

                if (count($dbsearchbudgetnature) > 0) {
                    $validationerrors['count_budget_nature'] = "Ce budget a été deja établit sur cette demande d'achat";        
                }
                
                if(count($dbsearchbudgetnature) == 0){
                    $dbfinsert = "INSERT INTO eu_forms_budget_nature(
                                 id_bps_vendu_achat_vente_reciproque,
                                 type_budget,
                                 reference_type_budget,
                                 code_membre_budget) VALUES (
                                '$bps_vendu',
                                '$type_budget',
                                '$id',
                                '$code_membre_budgetavr')";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfinsert);
    
                    $dbfselect = "SELECT id_forms_budget_nature FROM eu_forms_budget_nature WHERE reference_type_budget='$id' AND type_budget='$type_budget' ";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfselect);
                    $recupidbudgetnature = $stmt->fetchAll();
                    
                    if (count($recupidbudgetnature) == 0) {
                        $validationerrors['count_search_budget_nature'] = "Ce budget n'a pas été correctement enregistré";        
                    }

                    if (count($recupidbudgetnature) > 0) {
                        $id_budget_nature = $recupidbudgetnature[0]->id_forms_budget_nature;
    
                        $dbfinsert = "INSERT INTO eu_forms_detail_budget_nature(
                            id_forms_budget_nature,
                            bps_demande,
                            qte_budget_nature,
                            prix_unitaire_budget_nature,
                            total_budget_nature,
                            disponible_budget_nature) VALUES (
                            '$id_budget_nature',
                            '$bps_demande_avr',
                            '$qte_avr',
                            '$prix_unitaire_avr',
                            '$total_avr',
                            '$disponible_avr')";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbfinsert);
        
                        $validationsuccess['success_message'] = "Etablissement du budget pour cette demande d'achat a été effectué avec succes";
                        $_SESSION['validationsuccess'] = $validationsuccess;
                        $this->_redirect("/procedureachat/listedesbudgetetablitenfonctiondelademandeachat");
                        
                    }
                }
             }
          }
        }
    }    
}

public function listingdesavrdesmembresAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
    $dbverifselect = "SELECT 
                        eu_bps_vendu_avr.nom_bps_vendu,
                        eu_form_avr.date_avr,
                        eu_form_avr.code_membre_avr
                      FROM eu_form_avr,eu_bps_achete_avr,eu_bps_vendu_avr
                      WHERE eu_form_avr.id_bps_vendu_achat_vente_reciproque = eu_bps_vendu_avr.id_bps_vendu_achat_vente_reciproque
                      AND eu_form_avr.id_bps_achete_achat_vente_reciproque = eu_bps_achete_avr.id_bps_achete_achat_vente_reciproque
                      AND eu_form_avr.validationachatetventereciproque = 1
                      GROUP BY eu_form_avr.id_bps_vendu_achat_vente_reciproque";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbverifselect);
    $dblistedesavr = $stmt->fetchAll(); 
    $this->view->listedesavr  = $dblistedesavr;
    $this->view->tabletri = 1;
}


public function detaildeslistedunavrdesmembresAction () {
    $db = Zend_Db_Table::getDefaultAdapter();    
    $code_membre = (string)$this->_request->getParam('code_membre');
    $dbverifselect = "SELECT eu_form_avr.code_membre_avr,
                             eu_bps_achete_avr.nom_bps_achete
                      FROM eu_form_avr,eu_bps_achete_avr
                      WHERE eu_form_avr.id_bps_achete_achat_vente_reciproque = eu_bps_achete_avr.id_bps_achete_achat_vente_reciproque
                      AND eu_form_avr.validationachatetventereciproque = 1
                      AND eu_form_avr.code_membre_avr = '$code_membre'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbverifselect);
    $dbdetailslistedesavr = $stmt->fetchAll(); 

    foreach($dbdetailslistedesavr as $key => $value){
        $code_membre = $value->code_membre_avr;
        $subcodemembre = substr($code_membre,-1);
    
    }

    if ($subcodemembre == "M"){
        $dbverifselect = "SELECT eu_membre_morale.raison_sociale
                          FROM eu_form_avr,eu_bps_achete_avr, eu_membre_morale
                          WHERE eu_form_avr.code_membre_avr = eu_membre_morale.code_membre_morale
                          AND eu_form_avr.id_bps_achete_achat_vente_reciproque = eu_bps_achete_avr.id_bps_achete_achat_vente_reciproque
                          AND eu_form_avr.validationachatetventereciproque = 1
                          AND eu_form_avr.code_membre_avr = '$code_membre'
                          GROUP BY eu_form_avr.code_membre_avr";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesavrpm = $stmt->fetchAll(); 
        var_dump($dblistedesavrpm);
        $raison_sociale = $dblistedesavrpm[0]->raison_sociale;
        $this->view->raison_sociale  = $raison_sociale;
        
    }

    if ($subcodemembre == "P"){
        $dbverifselect = "SELECT eu_membre.nom_membre, eu_membre_morale.prenom_membre
                          FROM eu_form_avr,eu_bps_achete_avr, eu_membre
                          WHERE eu_form_avr.code_membre_avr = eu_membre.code_membre 
                          AND eu_form_avr.id_bps_achete_achat_vente_reciproque = eu_bps_achete_avr.id_bps_achete_achat_vente_reciproque
                          AND eu_form_avr.validationachatetventereciproque = 1
                          AND eu_form_avr.code_membre_avr = '$code_membre'
                          GROUP BY eu_form_avr.code_membre_avr";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesavrpp = $stmt->fetchAll(); 
        var_dump($dblistedesavrpp);
        $nom_membre = $dblistedesavrpm[0]->nom_membre;
        $prenom_membre = $dblistedesavrpm[0]->prenom_membre;
        $this->view->nom_membre  = $nom_membre;
        $this->view->prenom_membre  = $prenom_membre;
        
        
    }

    $this->view->detailslistedesavr  = $dbdetailslistedesavr;
    
    
}

public function eliencoursdevalidationAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
    $dbverifselect = "SELECT 
                       eu_eli.code_membre,
                       eu_eli.numero_eli,
                       eu_eli.libelle_eli,
                       eu_eli.date_eli,
                       eu_eli.id_eli
                      FROM eu_eli
                      WHERE eu_eli.valider < 4
                      AND eu_eli.rejeter = 0 ";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbverifselect);
    $dblistedeseliencours = $stmt->fetchAll(); 
    $this->view->listedeseliencours  = $dblistedeseliencours;
    $this->view->tabletri = 1;
}

public function detaildeseliencoursdevalidationAction () {

    $db = Zend_Db_Table::getDefaultAdapter();
        
    $id = (int)$this->_request->getParam('id');
    $raison_sociale = "";
    $nomprenoms = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $dbselect = "SELECT eu_eli.id_eli FROM eu_eli WHERE  eu_eli.id_eli ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbrecherchedeliddeleli = $stmt->fetchAll();
        if (count($dbrecherchedeliddeleli) == 0) {
            http_response_code(403);
            die('Désolé mais cet ELI n\'a pas encore été établit');
        }
    }

    $dbverifselect = "SELECT 
                        eu_eli.code_membre,
                        eu_eli.numero_eli,
                        eu_eli.libelle_eli,
                        eu_eli.date_eli,
                        eu_eli.bai,
                        eu_eli.montant_bai,
                        eu_eli.ban,
                        eu_eli.montant_ban,
                        eu_eli.opi,
                        eu_eli.montant_opi,
                        eu_eli.montant_eli,
                        eu_eli.id_eli
                     FROM eu_eli
                     WHERE eu_eli.valider < 4
                     AND eu_eli.rejeter = 0
                     AND eu_eli.id_eli ='$id'";
     $db->setFetchMode(Zend_Db::FETCH_OBJ);
     $stmt = $db->query($dbverifselect);
     $dbdetailseliencours = $stmt->fetchAll(); 
     $iddetailseliencours = $dbdetailseliencours[0]->id_eli;
     $codemembredetailseliencours = $dbdetailseliencours[0]->code_membre;
     $subcodemembre = substr($codemembredetailseliencours,-1);

     if($subcodemembre == "M"){
        $dbverifselect = "SELECT 
                            eu_membre_morale.raison_sociale
                          FROM eu_membre_morale
                          WHERE eu_membre_morale.code_membre_morale = '$codemembredetailseliencours'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbraisonsociale = $stmt->fetchAll(); 
        $raison_sociale = $dbraisonsociale[0]->raison_sociale;
     }

     if($subcodemembre == "P"){
        $dbverifselect = "SELECT 
                             eu_membre.nom_membre,
                             eu_membre.prenom_membre
                          FROM eu_membre
                          WHERE eu_membre.code_membre = '$codemembredetailseliencours'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbnometprenoms = $stmt->fetchAll(); 
        $noms = $dbnometprenoms[0]->nom_membre;
        $prenoms = $dbnometprenoms[0]->prenom_membre;
        $nomsetprenoms = $noms." ".$prenoms;
     }     
     

    $dbselect = "SELECT 
                   eu_detail_eli.libelle_produit,
                   eu_detail_eli.montant_produit,
                   eu_detail_eli.quantite,
                   eu_detail_eli.prix_unitaire,
                   eu_detail_eli.type_bps,
                   eu_detail_eli.qte_vente,
                   eu_detail_eli.prix_vente
                 FROM eu_detail_eli
                 WHERE eu_detail_eli.id_eli ='$iddetailseliencours'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbselect);
    $dbdetailseliencoursdetails = $stmt->fetchAll();

    $this->view->detailseliencours  = $dbdetailseliencours;
    $this->view->detailseliencoursdetails  = $dbdetailseliencoursdetails;
    $this->view->raison_sociale  = $raison_sociale;
    $this->view->nomsetprenoms  = $nomsetprenoms;
}


public function eliquisontdejavaliderAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
    $dbverifselect = "SELECT 
                       eu_eli.code_membre,
                       eu_eli.numero_eli,
                       eu_eli.libelle_eli,
                       eu_eli.date_eli,
                       eu_eli.payer,
                       eu_eli.id_eli
                      FROM eu_eli
                      WHERE eu_eli.valider >= 4
                      AND eu_eli.rejeter = 0 ";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbverifselect);
    $dblistedeselidejavalider = $stmt->fetchAll(); 
    $this->view->listedeselidejavalider  = $dblistedeselidejavalider;
    $this->view->tabletri = 1;
}

public function detaildeseliquisontdejavaliderAction () {

    $db = Zend_Db_Table::getDefaultAdapter();
        
    $id = (int)$this->_request->getParam('id');
    $raison_sociale = "";
    $nomprenoms = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $dbselect = "SELECT eu_eli.id_eli FROM eu_eli WHERE eu_eli.id_eli ='$id' AND eu_eli.valider >= 4";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbrecherchedeliddeleli = $stmt->fetchAll();
        if (count($dbrecherchedeliddeleli) == 0) {
            http_response_code(403);
            die('Désolé mais cet ELI n\'a pas encore été établit');
        }
    }

    $dbverifselect = "SELECT 
                        eu_eli.code_membre,
                        eu_eli.numero_eli,
                        eu_eli.libelle_eli,
                        eu_eli.date_eli,
                        eu_eli.bai,
                        eu_eli.montant_bai,
                        eu_eli.ban,
                        eu_eli.montant_ban,
                        eu_eli.opi,
                        eu_eli.montant_opi,
                        eu_eli.montant_eli,
                        eu_eli.id_eli
                     FROM eu_eli
                     WHERE eu_eli.valider >= 4
                     AND eu_eli.rejeter = 0
                     AND eu_eli.id_eli ='$id'";
     $db->setFetchMode(Zend_Db::FETCH_OBJ);
     $stmt = $db->query($dbverifselect);
     $dbdetailselidejavalider = $stmt->fetchAll(); 
     $iddetailselidejavalider = $dbdetailselidejavalider[0]->id_eli;
     $codemembredetailselidejavalider = $dbdetailselidejavalider[0]->code_membre;
     $subcodemembre = substr($codemembredetailselidejavalider,-1);

     if($subcodemembre == "M"){
        $dbverifselect = "SELECT 
                            eu_membre_morale.raison_sociale
                          FROM eu_membre_morale
                          WHERE eu_membre_morale.code_membre_morale = '$codemembredetailselidejavalider'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbraisonsociale = $stmt->fetchAll(); 
        $raison_sociale = $dbraisonsociale[0]->raison_sociale;
     }

     if($subcodemembre == "P"){
        $dbverifselect = "SELECT 
                             eu_membre.nom_membre,
                             eu_membre.prenom_membre
                          FROM eu_membre
                          WHERE eu_membre.code_membre = '$codemembredetailselidejavalider'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbnometprenoms = $stmt->fetchAll(); 
        $noms = $dbnometprenoms[0]->nom_membre;
        $prenoms = $dbnometprenoms[0]->prenom_membre;
        $nomsetprenoms = $noms." ".$prenoms;
     }     
     

    $dbselect = "SELECT 
                   eu_detail_eli.libelle_produit,
                   eu_detail_eli.montant_produit,
                   eu_detail_eli.quantite,
                   eu_detail_eli.prix_unitaire,
                   eu_detail_eli.type_bps,
                   eu_detail_eli.qte_vente,
                   eu_detail_eli.prix_vente
                 FROM eu_detail_eli
                 WHERE eu_detail_eli.id_eli ='$iddetailselidejavalider'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbselect);
    $dbdetailselidejavaliderdetails = $stmt->fetchAll();

    $this->view->detailselidejavalider  = $dbdetailselidejavalider;
    $this->view->detailselidejavaliderdetails  = $dbdetailselidejavaliderdetails;
    $this->view->raison_sociale  = $raison_sociale;
    $this->view->nomsetprenoms  = $nomsetprenoms;
}


public function eliquisontrejeterAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
    $dbverifselect = "SELECT 
                       eu_eli.code_membre,
                       eu_eli.numero_eli,
                       eu_eli.libelle_eli,
                       eu_eli.date_eli,
                       eu_eli.payer,
                       eu_eli.id_eli
                      FROM eu_eli
                      WHERE eu_eli.rejeter = 1";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbverifselect);
    $dblistedeselirejeter = $stmt->fetchAll(); 
    $this->view->listedeselirejeter = $dblistedeselirejeter;
    $this->view->tabletri = 1;
}


public function detaildeseliquisontrejeterAction () {
    
    $db = Zend_Db_Table::getDefaultAdapter();
        
    $id = (int)$this->_request->getParam('id');
    $raison_sociale = "";
    $nomprenoms = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $dbselect = "SELECT eu_eli.id_eli FROM eu_eli WHERE eu_eli.id_eli ='$id' AND eu_eli.valider >= 4";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbrecherchedeliddeleli = $stmt->fetchAll();
        if (count($dbrecherchedeliddeleli) == 0) {
            http_response_code(403);
            die('Désolé mais cet ELI n\'a pas encore été établit');
        }
    }

    $dbverifselect = "SELECT 
                        eu_eli.code_membre,
                        eu_eli.numero_eli,
                        eu_eli.libelle_eli,
                        eu_eli.date_eli,
                        eu_eli.bai,
                        eu_eli.montant_bai,
                        eu_eli.ban,
                        eu_eli.montant_ban,
                        eu_eli.opi,
                        eu_eli.montant_opi,
                        eu_eli.montant_eli,
                        eu_eli.id_eli
                     FROM eu_eli
                     WHERE eu_eli.valider >= 4
                     AND eu_eli.rejeter = 0
                     AND eu_eli.id_eli ='$id'";
     $db->setFetchMode(Zend_Db::FETCH_OBJ);
     $stmt = $db->query($dbverifselect);
     $dbdetailselidejavalider = $stmt->fetchAll(); 
     $iddetailselidejavalider = $dbdetailselidejavalider[0]->id_eli;
     $codemembredetailselidejavalider = $dbdetailselidejavalider[0]->code_membre;
     $subcodemembre = substr($codemembredetailselidejavalider,-1);

     if($subcodemembre == "M"){
        $dbverifselect = "SELECT 
                            eu_membre_morale.raison_sociale
                          FROM eu_membre_morale
                          WHERE eu_membre_morale.code_membre_morale = '$codemembredetailselidejavalider'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbraisonsociale = $stmt->fetchAll(); 
        $raison_sociale = $dbraisonsociale[0]->raison_sociale;
     }

     if($subcodemembre == "P"){
        $dbverifselect = "SELECT 
                             eu_membre.nom_membre,
                             eu_membre.prenom_membre
                          FROM eu_membre
                          WHERE eu_membre.code_membre = '$codemembredetailselidejavalider'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbnometprenoms = $stmt->fetchAll(); 
        $noms = $dbnometprenoms[0]->nom_membre;
        $prenoms = $dbnometprenoms[0]->prenom_membre;
        $nomsetprenoms = $noms." ".$prenoms;
     }     
     

    $dbselect = "SELECT 
                   eu_detail_eli.libelle_produit,
                   eu_detail_eli.montant_produit,
                   eu_detail_eli.quantite,
                   eu_detail_eli.prix_unitaire,
                   eu_detail_eli.type_bps,
                   eu_detail_eli.qte_vente,
                   eu_detail_eli.prix_vente
                 FROM eu_detail_eli
                 WHERE eu_detail_eli.id_eli ='$iddetailselidejavalider'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbselect);
    $dbdetailselidejarejeterdetails = $stmt->fetchAll();

    $this->view->detailselidejarejeter  = $dbdetailselidejarejeter;
    $this->view->detailselidejarejeterdetails  = $dbdetailselidejarejeterdetails;
    $this->view->raison_sociale  = $raison_sociale;
    $this->view->nomsetprenoms  = $nomsetprenoms;

}
public function formulairedebudgetennatureavrAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    
   /*$v = md5('proccentprodatidokpomawouli');
   var_dump($v);
   var_dump($_SESSION);
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
   
   var_dump($_SESSION['utilisateur']['code_membre']);
   */
   
   
    $dbtselect = "SELECT * FROM  eu_bps_vendu_avr";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbbpsventereciproqueselect_all = $stmt->fetchAll();
    
    $this->view->bpsvendu = $dbbpsventereciproqueselect_all;
    $code_membre_budgetavr = $_SESSION['utilisateur']['code_membre'];
      
/*
    if($code_membre_budgetavr == "" ){
        $this->_redirect("/integrateur/editmembreasso2");
    }

    if (!isset($sessionutilisateur->login)){
      $this->_redirect('/administration/login');
    }*/

    if ($request->isPost()) {
      $type_budget = $_POST['type_budget'];
      $bps_vendu = $_POST['bps_vendu'];   
      if ($_POST['bps_vendu'] == ""){
        $validationerrors['empty_bps_vendu'] = "le bps vendu ne doit pas être vide";
      }
      if(!empty($validationerrors)){
        $_SESSION['validationerrors'] = $validationerrors;
      }      
      

      for ($i = 0; $i< count($_POST['bps_demande_avr']); $i++){
        $bps_demande_avr = $_POST['bps_demande_avr'][$i];
        $qte_avr = $_POST['qte_avr'][$i];
        $prix_unitaire_avr = $_POST['prix_unitaire_avr'][$i];
        $total_avr = $_POST['total_avr'][$i];
        $disponible_avr = $_POST['disponible_avr'][$i];
        if ($_POST['bps_vendu'][$i] == ""){
            $validationerrors['empty_bps_vendu'] = "le bps vendu ne doit pas être vide";
        }
    /*    if($_POST['bps_vendu'][$i] !== ""){
            if(filter_var($_POST['bps_vendu'][$i], FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[a-zA-Z]#")))){
               $validationerrors['verif_bps_vendu'] = "le bps selectionné est invalide";
             }
        } */

        if ($_POST['bps_demande_avr'][$i] == ""){
            $validationerrors['empty_bps_demande_avr'] = "le bps vendu ne doit pas être vide";
        }  

        if ($_POST['qte_avr'][$i] == ""){
            $validationerrors['empty_qte_avr'] = "la quantité n'est pas saisie";
        }

        if($_POST['qte_avr'] !== ""){
            if(!filter_var($_POST['qte_avr'][$i], FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
               $validationerrors['verif_qte_avr'] = "la quantité saisie est invalide";
             }
        }
    

        if ($_POST['prix_unitaire_avr'][$i] == ""){
            $validationerrors['empty_prix_unitaire_avr'] = "le prix n'est pas saisie";
        }
        if($_POST['prix_unitaire_avr'][$i] !== ""){
            if(!filter_var($_POST['prix_unitaire_avr'][$i], FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
               $validationerrors['verif_prix_unitaire_avr'] = "le prix unitaire saisie est invalide";
             }
        } 

        if ($_POST['total_avr'][$i] == "") {
            $validationerrors['empty_total_avr'] = "le total n'est pas saisie";        
        }
        if($_POST['total_avr'][$i] !== ""){
            if(filter_var($_POST['total_avr'][$i], FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[^0-9]#")))){
               $validationerrors['verif_total_avr'] = "le total calculé est invalide";
             }
        } 


      if (!in_array($_POST['disponible_avr'][$i], array('0','1'))) {
        $validationerrors['verif_disponible_avr'] = "la disponibilité du produit est invalide";
      }



      if(!empty($validationerrors)){
        $_SESSION['validationerrors'] = $validationerrors;
      }

      if (empty($validationerrors)) {
         
         $dbfinsert = "INSERT INTO eu_forms_budget_nature(id_bps_vendu_achat_vente_reciproque,bps_demande,qte_budget_nature,prix_unitaire_budget_nature,total_budget_nature,disponible_budget_nature,co) VALUES ('$bps_vendu','$bps_demande_avr','$qte_avr','$prix_unitaire_avr','$total_avr','$disponible_avr',$code_membre_budgetavr)";
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
         $stmt = $db->query($dbfinsert);
         $validationsuccess['success_message'] = "Enregistrement du BPS effectué avec succes";
         $_SESSION['validationsuccess'] = $validationsuccess;
      }
    }
  }    

}




public function etablissementdelademandachatAction () {
    /***Generer le pdf
     * Generer aleatoirement une reference unique pour chaque demande
     * Mettre la validation à 0
     */
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

         
    $id_utilisateur = $sessionutilisateur->id_utilisateur;

    
    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    $created = Zend_Date::now();
    $validationdemandeerrors = array();
    $validationdetailerrors = array();
/*
    $dbselect = "SELECT * FROM eu_demande_achat WHERE id_demande_achat=$demandeid";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbselect);
    $dbsearchdemandeachat = $stmt->fetchAll();
    $d = "20000";*/
    if($request->isPost()){


        $code_membre_demandeur_achat = $_POST['code_membre_demandeur'];
        $montant_demande_achat = $_POST['montant_demande_achat'];
        $libelle_demandeur_achat = $_POST['libelle_demandeur_achat'];
        $type_demandeur_achat = $_POST['type_demandeur_achat'];
        
        

        $ref_demande_achat = substr(md5(uniqid(rand(),true)),0,8);
        $real_ref_demande_achat = strtoupper('DEMAND-'.$ref_demande_achat);
        $date_emission_demande = $created->toString('yyyy-MM-dd HH:mm:ss');

        
        if ($code_membre_demandeur_achat == ""){
            $validationdemandeerrors['empty_code_membre'] = "Vous devez remplir votre code membre";
        }

/***Verification du contenu des variables */
        if($montant_demande_achat == "") {
            $validationdemandeerrors['empty_montant_demande_achat'] = "Le montant total de la demande d'achat ne doit pas être vide";
        }

        if($libelle_demandeur_achat == "") {
            $validationlibelledemandeurachat['empty_libelle_demandeur_achat'] = "Le libelle de la demande d'achat ne doit pas être vide";
        }

        if($type_demandeur_achat == "") {
            $validationlibelledemandeurachat['empty_type_demandeur_achat'] = "Le type de la demande d'achat ne doit pas être vide";
        }

        /***Verification de l'existence des variable */
        if(isset($code_membre_demandeur_achat)){
            $validationdemandeerrors['exist_code_membre_demandeur_achat'] = "Le code membre du demandeur est inexistant";
        }

        if(isset($montant_demande_achat)){
            $validationdemandeerrors['exist_montant_demande_achat'] = "Le montant total de la demande d'achat est inexistant";
        }

        if(isset($libelle_demandeur_achat)){
            $validationdemandeerrors['exist_libelle_demandeur_achat'] = "Le libellé de la demande d'achat est inexistant";
        }

        if(isset($type_demandeur_achat)){
            $validationdemandeerrors['exist_type_demandeur_achat'] = "Le type de la demande d'achat est inexistant";
        }


/*** */
        if(!in_array(substr($code_membre_demandeur_achat,-1), array('P','M') ) || strlen($code_membre_demandeur_achat) != 20){
            $validationdemandeerrors['valid_code_membre'] = "Votre code membre est invalide";
        }

        if(!in_array(substr($type_demandeur_achat,-1), array('Biens','Produits', 'Services') )){
            $validationdemandeerrors['valid_type_demandeur_achat'] = "Le type de votre demande d'achat est invalide";
        }

        if(!empty($validationerrors)){
            $_SESSION['validationdemandeerrors'] = $validationerrors;
        }
      
      for ($i = 0; $i< count($_POST['ref_article_demande_achat']); $i++){
          /***Declaration des variables */
          $ref_article_demande_achat = $_POST['ref_article_demande_achat'][$i];
          $designation_article = $_POST['designation_des_Articles'][$i];
          $quantite_article_demande_achat = $_POST['quantite_article_demande_achat'][$i];
          $prix_unitaire_article_demande_achat = $_POST['prix_unitaire_article_demande_achat'][$i];
          //$total_article_demande_achat = $_POST['total_article_demande_achat'][$i];
                        
          if($quantite_article_demande_achat !== ""){
            if(!filter_var($quantite_article_demande_achat, FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationdemandeerrors['verif_quantite_article_demande_achat'] = "La quantité de la demande d'achat est invalide";
             }
          }

          if($prix_unitaire_article_demande_achat !== ""){
            if(!filter_var($prix_unitaire_article_demande_achat, FILTER_VALIDATE_REGEXP,
               array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationdemandeerrors['verif_prix_unitaire_article_demande_achat'] = "Le prix unitaire des articles est invalide";
             }
          }

          if(!empty($validationdetailerrors)){
            $_SESSION['validationerrors'] = $validationerrors;
          }

      }

    
      if (empty($validationdetailerrors) || empty($validationdemandeerrors)){
         $real_libelle_demandeur_achat = addslashes($libelle_demandeur_achat);
        $dbfinsert = "INSERT INTO 
                       eu_demande_achat(
                        montant_demande_achat,
                        libelle_demande_achat,
                        reference_demande_achat,
                        type_demande_achat,
                        code_membre,
                        date_demande,
                        id_utilisateur
                        ) VALUES (
                         $montant_demande_achat,
                        '$real_libelle_demandeur_achat',
                        '$real_ref_demande_achat',
                        '$type_demandeur_achat',
                        '$code_membre_demandeur_achat',
                        '$date_emission_demande',
                        $id_utilisateur)";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbfinsert);


        $dbselect = "SELECT * 
        
                     FROM eu_demande_achat
                     
                     WHERE montant_demande_achat='$montant_demande_achat' 
                     
                     AND reference_demande_achat ='$real_ref_demande_achat' 
                     
                     AND code_membre='$code_membre_demandeur_achat'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandeachat = $stmt->fetchAll();

        if (count($dbsearchdemandeachat) !== 0){
            for ($i = 0; $i< count($_POST['ref_article_demande_achat']); $i++){
                $ref_article_demande_achat = $_POST['ref_article_demande_achat'][$i];
                $designation_article = $_POST['designation_des_Articles'][$i];
                $quantite_article_demande_achat = $_POST['quantite_article_demande_achat'][$i];
                $prix_unitaire_article_demande_achat = $_POST['prix_unitaire_article_demande_achat'][$i];
                //$total_article_demande_achat = $_POST['total_article_demande_achat'][$i];
                
                $id_demande_achat = $dbsearchdemandeachat[0]->id_demande_achat;
                $realref_article_demande_achat = addslashes($ref_article_demande_achat);
                $realdesignation_article = addslashes($designation_article);
                
                $dbfinsert = "INSERT INTO eu_detail_demande_achat(
                                          reference_article,
                                          id_demande_achat,
                                          designation_article,
                                          quantite,prix_unitaire) VALUES (
                                         '$realref_article_demande_achat',
                                         '$id_demande_achat',
                                         '$realdesignation_article',
                                         '$quantite_article_demande_achat',
                                         '$prix_unitaire_article_demande_achat')";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfinsert);
            }
            $validationsuccess['success_message'] = "Enregistrement de la demande d'achat effectué avec succes";
            $_SESSION['validationsuccess'] = $validationsuccess;
            $this->_redirect("/procedureachat/listedesdemandeachatemiseparagentesmc");
            
        }else{
            $validationdemandeerrors['verif_montant_demande_achat'] = "Error:";
            $_SESSION['validationerrors'] = $validationerrors;
            
        }        

      }
        
    }

}


public function etablissementdubondecommandeAction () {
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    $created = Zend_Date::now();
    $id = (int)$this->_request->getParam('id');
    
    
    $dbverifselect = "SELECT
                         eu_proforma_procedure.numero_proforma,
                         eu_proforma_procedure.date_proforma,
                         eu_proforma_procedure.montant_ht,
                         eu_proforma_procedure.montant_ttc,
                         eu_proforma_procedure.tva,
                         eu_proforma_procedure.date_paie,
                         eu_proforma_procedure.date_livraison,
                         eu_proforma_procedure.modalite_paiement,
                         eu_proforma_procedure.addresse_livraison
                     FROM eu_proforma_procedure
                     WHERE eu_proforma_procedure.id_proforma = '$id'
                     AND eu_proforma_procedure.choix = 1";
   $db->setFetchMode(Zend_Db::FETCH_OBJ);
   $stmt = $db->query($dbverifselect);
   $dbproformachoisit = $stmt->fetchAll();


    $dbverifselect = "SELECT *
                     FROM eu_detail_proforma_procedure as dpp
                     WHERE dpp.id_proforma_procedure = '$id'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbverifselect);
    $dbdetailproformachoisit = $stmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(count($dbproformachoisit) == 0){
            http_response_code(403);
            die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
        }
    }
   
   $this->view->detailproformachoisit = $dbdetailproformachoisit;
   $this->view->proformachoisit = $dbproformachoisit;

    $validationdemandeerrors = array();
    $validationboncommandesuccess = array();



    
    
    if($request->isPost()){
        $code_membre_fournisseur = $_POST['code_membre_fournisseur'];
        $date_livraison_commande = $_POST['date_livraison_commande'];
        $libelle_bon_commande_procedure = $_POST['libelle_bon_commande_procedure'];
        $numero_demande_achat = $_POST['numero_demande_achat'];
        $date_demande_achat = $_POST['date_etablissement_demande_achat'];
        $montant_total_bon_commande = $_POST['montant_total_bon_commande'];            
        $ref_bon_command = substr(md5(uniqid(rand(),true)),0,8);
        $real_ref_bon_command= strtoupper('COMMAND-'.$ref_bon_command);
        $date_etablissement_bon_command = $created->toString('yyyy-MM-dd HH:mm:ss');
        $poscodenumerodemandachat = strpos($numero_demande_achat,'DEMAND-');
        if ($code_membre_fournisseur == ""){
            $validationdemandeerrors['empty_code_membre'] = "Echec d'enregistrement:Vous devez remplir votre code membre";
        }

/***Verification du contenu des variables */
        if($montant_total_bon_commande == "") {
            $validationdemandeerrors['empty_montant_total_bon_commande'] = "Echec d'enregistrement:Le montant total du bon de commande ne doit pas être vide";
        }

        if($libelle_bon_commande_procedure == "") {
            $validationdemandeerrors['empty_libelle_bon_commande_procedure'] = "Echec d'enregistrement:Le libellé du bon de commande ne doit pas être vide";
        }

        if($numero_demande_achat == "") {
            $validationdemandeerrors['empty_numero_demande_achat'] = "Echec d'enregistrement:Le numero de la demande d'achat ne doit pas être vide";
        }

        /***Verification de l'existence des variable */
        if(!isset($code_membre_fournisseur)){
            $validationdemandeerrors['exist_code_membre_fournisseur'] = "Echec d'enregistrement:Le code membre du fournisseur est inexistant";
        }

        if(!isset($montant_total_bon_commande)){
            $validationdemandeerrors['exist_montant_total_bon_commande'] = "Echec d'enregistrement:Le montant total de bon de commande est inexistant";
        }

        if(!isset($libelle_bon_commande_procedure)){
            $validationdemandeerrors['exist_libelle_bon_commande_procedure'] = "Echec d'enregistrement:Le libellé du bon de commande est inexistant";
        }

        if(!isset($numero_demande_achat)){
            $validationdemandeerrors['exist_numero_demande_achat'] = "Echec d'enregistrement:Le numéro de la demande d'achat est inexistant";
        }



/*** */

        if ($code_membre_fournisseur != ""){
            if(!in_array(substr($code_membre_fournisseur,-1), array('P','M') ) || strlen($code_membre_fournisseur) != 20){
                $validationdemandeerrors['valid_code_membre'] = "Echec d'enregistrement:Le code membre du fournisseur est invalide";
            }
        }

        if ($numero_demande_achat != ""){
            if ($poscodenumerodemandachat === false || strlen($numero_demande_achat) != 15) {
                $validationdemandeerrors['valid_numero_demande_achat'] = "Le numéro de la demande d'achat que vous avez renseigné est invalide";
            }    
        }



        /***Recherche le numero de la demande d'achat dans la table eu_demande_achat
         * S'il n'existe pas envoyé une erreur et invalide l'insertion des données
         * Dans le cas contraire, procédé à l'insertion des informations
         */

        $dbselect = "SELECT * FROM eu_demande_achat WHERE reference_demande_achat='$numero_demande_achat'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandeachat = $stmt->fetchAll();
        $dbcountsearchdemandeachat = count($dbsearchdemandeachat);

        if($dbcountsearchdemandeachat == 0) {
          $validationdemandeerrors['existance_demande_achat'] = "La reférence de la demande d'achat que vous avez renseigné n'a pas encore été enregistré";
        }

        if($dbcountsearchdemandeachat > 0) {
            $dbselect = "SELECT * FROM eu_demande_achat WHERE reference_demande_achat='$numero_demande_achat' AND date_demande like '%$date_demande_achat%'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbsearchdatedemandeachat = $stmt->fetchAll();
            $dbcountsearchdatedemandeachat = count($dbsearchdemandeachat);
            if($dbcountsearchdatedemandeachat == 0){
             $validationdemandeerrors['existance_demande_achat'] = "La date de la demande d'achat renseignée ne correspond pas à la reference de la demande d'achat fournie";
            }
        }
    

        if(!empty($validationdemandeerrors)){
            $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
        }

        if (empty($validationdemandeerrors)){
            $id_demande_achat = $dbsearchdemandeachat[0]->id_demande_achat;
           $dbfinsert = "INSERT INTO 
                          eu_bon_commande(
                           montant_bon_commande,
                           reference_bon_commande,
                           date_bon_commande,
                           id_demande_achat,
                           date_livraison,
                           id_proforma_procedure,
                           code_membre_fournisseur_bon_commande) 
                           VALUES (
                           '$montant_total_bon_commande',
                           '$real_ref_bon_command',
                           '$date_etablissement_bon_command',
                           '$id_demande_achat',
                           '$date_livraison_commande',
                           '$id',                           
                           '$code_membre_fournisseur'                               
                           )";
           $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $stmt = $db->query($dbfinsert);
   
   
           $dbselect = "SELECT * FROM eu_bon_commande WHERE montant_bon_commande='$montant_total_bon_commande' AND reference_bon_commande ='$real_ref_bon_command' AND code_membre_fournisseur_bon_commande='$code_membre_fournisseur'";
           $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $stmt = $db->query($dbselect);
           $dbsearchboncommande = $stmt->fetchAll();
   
           if (count($dbsearchboncommande) > 0){
               for ($i = 0; $i< count($_POST['ref_article_bon_commande']); $i++){
                   $ref_article_demande_achat = $_POST['ref_article_bon_commande'][$i];
                   $designation_article = $_POST['designation_article_bon_commande'][$i];
                   $quantite_article_bon_commande = $_POST['quantite_article_bon_commande'][$i];
                   $prix_unitaire_article_bon_commande = $_POST['prix_unitaire_article_bon_commande'][$i];
                   //$total_article_demande_achat = $_POST['total_article_demande_achat'][$i];
                   
                   $id_demande_bon_commande = $dbsearchboncommande[0]->id_bon_commande;
                   
                   $dbfinsert = "INSERT INTO eu_detail_bon_commande(
                       reference_article,
                       id_bon_commande,
                       designation_article,
                       quantite,
                       prix_unitaire) VALUES (
                       '$ref_article_demande_achat',
                       '$id_demande_bon_commande',
                       '$designation_article',
                       '$quantite_article_bon_commande',
                       '$prix_unitaire_article_bon_commande')";
                   $db->setFetchMode(Zend_Db::FETCH_OBJ);
                   $stmt = $db->query($dbfinsert);


               }
               $validationsuccess['success_message'] = "Enregistrement du bon de commande effectué avec succes";
               $_SESSION['validationsuccess'] = $validationsuccess;
               $this->_redirect('/procedureachat/lalistedetouslesbonsdecommandes');
            
           }else{
               $validationdemandeerrors['verif_montant_bon_commande'] = "Error:Echec d'enregistrement";
               $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
               
           }
   
         }

    }
    

}


public function formscontratengagementlivraisonirrevocablecontreopiAction () {
    $this->_helper->layout()->setLayout('layoutpublicesmc');

}


public function lecturedelafranchiseAction () {
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
}

public function recherchedesinformationsdufranchiseapartirdeleurcodemembreAction () {
    $code_membre = $_POST['codemembremoraledufranchise'];
    $db = Zend_Db_Table::getDefaultAdapter();
    $created = Zend_Date::now();
    $resultjson = array();
    $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
    $erreurdanslarecherchedurepresentant = "";
    $erreurdanslarecherchedelaraisonsocial = "";


    $dbtselect = "SELECT * FROM eu_membre_morale WHERE code_membre_morale ='$code_membre'"; 
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbresultraisonsocialdufranchise = $stmt->fetchAll();



    if(count($dbresultraisonsocialdufranchise) == 0){
        $erreurdanslarecherchedelaraisonsocial = "La raison sociale du franchisé est introuvable";
    }

    if (count($dbresultraisonsocialdufranchise) > 0){
      $laraisonsocialdurepresentant = $dbresultraisonsocialdufranchise[0]->raison_sociale;
      $dbtselect = "SELECT * FROM eu_representation WHERE code_membre_morale ='$code_membre' AND titre='Representant'"; 
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbresultrepresentant = $stmt->fetchAll();
      if(count($dbresultrepresentant) == 0){
        $erreurdanslarecherchedurepresentant = "Le representant de ce code membre est introuvable";
      }

    if (count($dbresultrepresentant) > 0){
        $lecodemembredurepresentant = $dbresultrepresentant[0]->code_membre;
        $dbtselect = "SELECT nom_membre, prenom_membre,ville_membre,quartier_membre,bp_membre,portable_membre FROM eu_membre WHERE code_membre='$lecodemembredurepresentant'"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbcodemembre = $stmt->fetchAll();
        $nom=  $dbcodemembre[0]->nom_membre;
        $prenoms = $dbcodemembre[0]->prenom_membre;
        $nometprenoms = $nom." ".$prenoms;
        $raisonsocialdurepresentant = $dbresultraisonsocialdufranchise[0]->raison_sociale;

    $resultmembre = array(
      'nometprenoms' =>$nometprenoms,
      'raisonsocialrepresentant'=>$raisonsocialdurepresentant,
      'ville'=>$ville,
      'quartier'=>$quartier,
      'bp'=>$bp,
      'telephone'=>$tel
    );
  }  
}
    
    
    $resultjson = array(
      'update'=>$resultmembre,
      'error'=>$erreurdanslarecherchedurepresentant
    );

    header('Content-type:application/json');
    die(json_encode($resultjson));
        
}


public function signaturedelafranchiseparlapersonnemoraleAction () {
    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    $validationerrors = array();
    $validationsuccess = array();
	$sessionmembre = new Zend_Session_Namespace('membre');	
    $code_membre_franchise = $sessionmembre->code_membre;
    $nometprenoms = "";    
  
    if($sessionmembre->code_membre == ""){
            $this->_redirect('/');
    }

    $dbtselect = "SELECT * FROM eu_membre_morale WHERE code_membre_morale ='$code_membre_franchise'"; 
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbresultraisonsocialdufranchise = $stmt->fetchAll();

    if(count($dbresultraisonsocialdufranchise) == 0){
        $validationerrors['search_raison_social'] = "La raison sociale du franchisé est introuvable";
    }

    if(!empty($validationerrors)){
        $_SESSION['validationerrors'] = $validationerrors;                              
    }

    if (count($dbresultraisonsocialdufranchise) > 0 && empty($validationerrors)) {
        $laraisonsocialdurepresentant = $dbresultraisonsocialdufranchise[0]->raison_sociale;
        $dbtselect = "SELECT * FROM eu_representation WHERE code_membre_morale ='$code_membre_franchise' AND titre='Representant'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbresultrepresentant = $stmt->fetchAll();
        if (count($dbresultrepresentant) == 0) {
            $validationerrors['search_representant'] = "Le representant de ce code membre est introuvable";
        }
        if(isset($_SESSION['validationerrors'])){
            $_SESSION['validationerrors']['search_representant'] = $validationerrors['search_representant'];
        }
        if(!isset($_SESSION['validationerrors'])){
            $_SESSION['validationerrors'] = $validationerrors;                              
        }


        if (count($dbresultrepresentant) > 0 && empty($validationerrors)) {
            $lecodemembredurepresentant = $dbresultrepresentant[0]->code_membre;
            $dbtselect = "SELECT nom_membre, prenom_membre,ville_membre,quartier_membre,bp_membre,portable_membre FROM eu_membre WHERE code_membre='$lecodemembredurepresentant'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtselect);
            $dbcodemembre = $stmt->fetchAll();
            $nom=  $dbcodemembre[0]->nom_membre;
            $prenoms = $dbcodemembre[0]->prenom_membre;
            $nometprenoms = $nom." ".$prenoms;
            $raisonsocialdurepresentant = $dbresultraisonsocialdufranchise[0]->raison_sociale;
        }
    }

    $this->view->nomrepresentant = $nometprenoms;
    $this->view->raisonsocialdurepresentant = $raisonsocialdurepresentant;
    
    
    if($request->isPost()){
        $raisonsociale = $_POST['raisonsocialguiucoeop'];
        $representant = $_POST['representantguiucoeop'];
        $typefranchise = $_POST['type_franchise_membre'];
        $created = Zend_Date::now();
        $real_created = $created->toString('yyyy-MM-dd HH:mm:ss');
        

        if(empty($_POST['raisonsocialguiucoeop'])){
            $validationerrors['empty_raison_social'] = "La raison sociale ne doit pas être vide";
         }
   
         if(!array_key_exists('raisonsocialguiucoeop', $_POST)){
           $validationerrors['error_raisonsocialguiucoeop'] = "Erreur 404:Vous tentez d'effectuer une action qui n'est pas autorisé";
         }

         if(empty($representant)){
            $validationerrors['empty_representant'] = "Le représentant du franchisé ne doit pas être vide";
         }
   
         if(!array_key_exists('representantguiucoeop', $_POST)){
           $validationerrors['error_representantguiucoeop'] = "Erreur 404:Vous tentez d'effectuer une action qui n'est pas autorisé";
         }
    
         if ($code_membre_franchise != ""){
            if(!in_array(substr($code_membre_franchise,-1), array('M') ) || strlen($code_membre_franchise) != 20){
                $validationerrors['valid_code_membre'] = "Echec d'enregistrement:Le code membre du franchisé est invalide";
            }
        }

        $real_representant = addslashes($representant);
  /*      
         $dbverifselect = "SELECT * FROM eu_franchise WHERE raison_sociale='$raisonsociale' AND representant = '$real_representant'";
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
         $stmt = $db->query($dbverifselect);
         $dbsearchdoublonstwo = $stmt->fetchAll();
*/
         $dbverifselect = "SELECT * FROM eu_franchise WHERE code_membre_franchise='$code_membre_franchise'";
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
         $stmt = $db->query($dbverifselect);
         $dbsearchdoublonsone = $stmt->fetchAll();

    
         if (/*count($dbsearchdoublonstwo) == 0  || */count($dbsearchdoublonsone) == 0) {
             $dbfinsert = "INSERT INTO eu_franchise(representant,code_membre_franchise,type_franchise,create_date) VALUES ('$real_representant','$code_membre_franchise','$typefranchise','$real_created')";
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbfinsert);
             $validationsuccess['success_message'] = "Signature du contrat de franchise effectué avec success";
             $_SESSION['validationsuccess'] = $validationsuccess;
             $this->_redirect('/formsguichet/engagementdelivraisonirrevocablebpspourlesmembresdejainscrit');		              
        
         }else {
             /*
            if (count($dbsearchdoublonstwo) != 0) {
               $validationerrors['errors_doublons'] = "Ce membre à deja signé ce contrat";
            }*/
            
            if (count($dbsearchdoublonsone) != 0) {
                $validationerrors['errors_doublons'] = "Ce membre morale à deja signé ce contrat";
            }
            
            if(isset($_SESSION['validationerrors'])){
                $_SESSION['validationerrors']['errors_doublons'] = $validationerrors['errors_doublons'];
            }
            if(!isset($_SESSION['validationerrors'])){
                $_SESSION['validationerrors'] = $validationerrors;                              
            }     
        }                                       
    }
}


public function franchiseguiucoeopAction () {

        
    $db = Zend_Db_Table::getDefaultAdapter();
    $request = $this->getRequest();
    $validationerrors = array();
    $validationsuccess = array();
    $id = (int)$this->_request->getParam('id');
    $typefranchise = "";



    if ($id == "1") {
        $typefranchise = "GUIUC/OE/OP";
    }elseif ($id == "2") {
        $typefranchise = "GUIUC/OE/PPP";
    }elseif ($id == "3") {
        $typefranchise = "GUIUC/OSE";
    }elseif ($id == "4") {
        $typefranchise = "GUIUU/BPS/B";
    }elseif ($id == "5") {
        $typefranchise = "GUIUU/BPS/P";
    }elseif ($id == "6") {
        $typefranchise = "GUIUU/BPS/S";
        
    }elseif ($id == "7") {
        $typefranchise = "GUIUU/PBF/A-OPI";
        
    }elseif ($id == "8") {
        $typefranchise = "GUIUU/PBF/AP-OPI";
        
    }elseif ($id == "9") {
        $typefranchise = "GUIUU/PBF/B";
        
    }elseif ($id == "10") {
        $typefranchise = "GUIUU/PBF/PS-OPI";
        
    }elseif ($id == "11") {
        $typefranchise = "GUIUU/PBF/SFD";            
    }elseif ($id == "12") {
        $typefranchise = "GUIUU/PODD/POE/FE";            
    }elseif ($id == "13") {
        $typefranchise = "GUIUU/PODD/POE/FS";                        
    }elseif ($id == "14") {
        $typefranchise = "GUIUU/PODD/POSE";                        
    }


    if($request->isPost()){
        $raisonsociale = $_POST['raisonsocialguiucoeop'];
        $representant = $_POST['representantguiucoeop'];
        $code_membre_franchise = $_POST['codemembreguiucoeop'];
        $created = Zend_Date::now();


        if(empty($_POST['raisonsocialguiucoeop'])){
            $validationerrors['empty_raison_social'] = "La raison sociale ne doit pas être vide";
         }
   
         if(!array_key_exists('raisonsocialguiucoeop', $_POST)){
           $validationerrors['error_raisonsocialguiucoeop'] = "Erreur 404:Vous tentez d'effectuer une action qui n'est pas autorisé";
         }

         if(empty($representant)){
            $validationerrors['empty_representant'] = "Le représentant du franchisé ne doit pas être vide";
         }
   
         if(!array_key_exists('representantguiucoeop', $_POST)){
           $validationerrors['error_representantguiucoeop'] = "Erreur 404:Vous tentez d'effectuer une action qui n'est pas autorisé";
         }

         if(empty($_POST['codemembreguiucoeop'])){
            $validationerrors['empty_codemembreguiucoeop'] = "La raison sociale ne doit pas être vide";
         }
   
         if(!array_key_exists('codemembreguiucoeop', $_POST)){
           $validationerrors['error_codemembreguiucoeop'] = "Erreur 404:Vous tentez d'effectuer une action qui n'est pas autorisé";
         }
    
         if ($code_membre_franchise != ""){
            if(!in_array(substr($code_membre_franchise,-1), array('M') ) || strlen($code_membre_franchise) != 20){
                $validationerrors['valid_code_membre'] = "Echec d'enregistrement:Le code membre du franchisé est invalide";
            }
        }

         $dbverifselect = "SELECT * FROM eu_franchise WHERE raison_sociale='$raisonsociale' AND representant = '$representant'";
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
         $stmt = $db->query($dbverifselect);
         $dbsearchdoublonstwo = $stmt->fetchAll();

         $dbverifselect = "SELECT * FROM eu_franchise WHERE raison_sociale='$raisonsociale'";
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
         $stmt = $db->query($dbverifselect);
         $dbsearchdoublonsone = $stmt->fetchAll();

    
         if (count($dbsearchdoublonstwo) <= 0  || count($dbsearchdoublonsone) <= 0) {
             $dbfinsert = "INSERT INTO eu_franchise(raison_sociale,representant,code_membre_franchise,type_franchise,created) VALUES ('$raisonsociale','$representant','$code_membre_franchise','$typefranchise','$created')";
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbfinsert);
             $validationsuccess['success_message'] = "Signature du contrat de franchise effectué avec succes";
             $_SESSION['validationsuccess'] = $validationsuccess;
        
         }else {
            if (count($dbsearchdoublonstwo) >= 0) {
               $validationerrors['errors_doublons'] = "Ce membre à deja signé ce contrat";
            }
            
            if (count($dbsearchdoublonsone) >= 0) {
                $validationerrors['errors_doublons'] = "Ce membre morale à deja signé ce contrat";
            }
            $_SESSION['validationerrors'] = $validationerrors;      
        }                                        
    }
    $this->view->id = $id;

}





}