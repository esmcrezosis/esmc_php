<?php

class GuichetsController extends Zend_Controller_Action {


    public function init(){

    }

    public function inscriptionpersonnephysiqueAction ()
    {

        /**Récupérer le numéro de télephone de la personne 
         * Fournir le lien de redirection de paygate
         */
        
        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $date_created_op = $created->toString('yyyy-MM-dd HH:mm:ss');

        $request = $this->getRequest();

        $relbancaire = new Application_Model_EuRelevebancaire ();

        $m_releve = new Application_Model_EuRelevebancaireMapper ();

        $m_detReleve = new Application_Model_EuRelevebancairedetailMapper ();


        if ($request->isPost()) {

            $numero = htmlspecialchars($_POST['numero_telephone_ksu']);

            $montant = 70000;

            $token = "220c88e7-f6bf-4114-85e3-578d1176ff6e";

            $identifier = $lastDetId;
    
            $description = "Souscription au Compte personne physique";
    
            $url = "https://www.esmc.esmcgie.com/guichets/inscriptionpersonnephysique";//?message=".$message."
            
            $this->_redirect('https://paygateglobal.com/v1/page?token='.$token.'&amount='.$montant.'&description='.urlencode($description).'&identifier='.$identifier.'&url='.urlencode($url).'');
        
            
        }
    
    }


    public function listedestypesdefranchisesAction () {


    }

    public function achatksuAction() {
        
    }

    public function transfertbcicompteacompteAction () {
        

    }

    public function apitransfertbcicompteacompteAction () {

        $this->_helper->layout->disableLayout();

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

		$curl = curl_init();

        
        $resultjson = array();

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();

        }else {

            $codeMembreApporteur = htmlspecialchars($_POST['codeMembreApporteur']);

            $codeMembreDest = htmlspecialchars($_POST['codeMembreDest']);

            $montantBCi = htmlspecialchars($_POST['montantBCi']);

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://tom.esmcgie.com/jmcnpApi/appro/bci",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\t\"codeMembre\":\"$codeMembreRevendeur\",\n\t\"codeMembreDest\":\"$codeMembreDest\",\n\t\"typeBc\":\"BCi\",\n\t\"bc\":\"$montantBCi\"n\n\n}",
                CURLOPT_HTTPHEADER => array(
                  "authorization: Basic dXNlcndlYnNlcnZpY2U6VXNlckAwNiEyMDE3X1NlSTIqJcK1I2ljZQ==",
                  "content-type: application/json"
                ),
             ));

            $response = json_decode(curl_exec($curl));

            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {

                 $resultjson = array('answer'=>$err);   

            } else {

                 $response_message = $response->message;

                 $resultjson = array('answer'=>$response_message); 

            }

        }

        header('Content-type:application/json');

        die(json_encode($resultjson));
    }

    public function demandedeservicesclientAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $date_activation = $created->toString('yyyy-MM-dd HH:mm:ss');

        $validationerrors = array();



        $keyfranchise = (string)$this->_request->getParam('keysecret_franchise');

        $franchise = (int)$this->_request->getParam('franchise_keyid');

        $type_operation = (string)$this->_request->getParam('type_operation');

        $this->view->type_operation = $type_operation;


        if ($this->_request->isPost()){

            $code_membre_demande = htmlspecialchars($_POST['code_membre_demande']);

            $libelle_demande = htmlspecialchars($_POST['libelle_demande']);

            $content_demande = htmlspecialchars($_POST['content_demande']);

            if ($code_membre_demande == "") {

                $validationerrors['errors_empty_code_membre'] = "Vous devez rendez renseigné votre code membre";

            }

            if ($libelle_demande == "") {

                $validationerrors['errors_empty_libelle_demande'] = "Vous devez rendez renseigné le libellé de la demande";

            }

            if ($content_demande == "") {

                $validationerrors['errors_empty_content_demande'] = "Vous devez rendez renseigné le contenu de la demande";

            }

            if (!isset($code_membre_demande) || !isset($libelle_demande) || !isset($content_demande)) {

                $validationerrors['errors_empty_content_demande'] = "Error 404: Vous tentez d'effectuer une opération qui n'est pas autorisée";

            }

            if (!in_array(substr($code_membre_demande,19,1), array('P', 'M'))){

                $validationerrors['errors_empty_content_demande'] = "Le code membre que vous avez renseigné est invalide";


            }

            if (substr($code_membre_demande,19,1) == "P") {

                $dbverifcodemembrephysique = "SELECT * FROM eu_membre WHERE eu_membre.code_membre = $code_membre_demande";

                
                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifcodemembrephysique = $db->query($dbverifcodemembrephysique);

                $verifcodemembrephysique = $stmtverifcodemembrephysique->fetchAll();

                if (count($verifcodemembrephysique) == 0){

                    $validationerrors['errors_verif_code_membre'] = "Le code membre que vous avez renseigné est introuvable";

                }

            }

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){

                  
                $dbinsert = "INSERT INTO eu_demande_membre (code_membre, libelle_demande, contenu_demande, date_demande_membre)
                 
                             VALUES ('$code_membre_demande', '$libelle_demande', '$content_demande', '$date_activation')";
                            
                
                if ($db->query($dbtinsert)) {


                }

            }

        }

    }

    public function prestationsacteursAction () {


    }

    public function tutorielsacteursAction () {


    }

    public function activationmoduleacteurAction () {

        
        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $date_activation = $created->toString('yyyy-MM-dd HH:mm:ss');

        
        $sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membre_activation = $sessionmembre->code_membre;

        $validmembre = substr($code_membre_activation, -1, 19);

        $this->view->validmembre = $validmembre;

        if ($request->isPost()) {

            for ($i = 0; $i< count($_POST['activation_acteur']); $i++){

                $value_acteur = $_POST['activation_acteur'][$i];

                $dbselectlastinsert = "SELECT eu_activation_acteur.id_activation_acteur 
                
                                       FROM eu_activation_acteur 
                                       
                                       WHERE eu_activation_acteur.code_membre = '$code_membre_activation'
                                       
                                       AND eu_activation_acteur.libelle_acteur = '$value_acteur'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                
                $db->query($dbselectlastinsert);

                $countactivation = count($db->query($dbselectlastinsert));


                if ($countactivation == 1) {

                         $validationerrors['errors_doublons'] = "Vous avez déjà activer l'acteur $value_acteur";

                }else {

                    
                       $dbinsertactivation = "INSERT INTO eu_activation_acteur(code_membre, libelle_acteur, activate, date_activation) VALUES (
  
                                               '$code_membre_activation', '$value_acteur', 1,  $date_activation)";

                       $db->setFetchMode(Zend_Db::FETCH_OBJ);
                
                       $db->query($dbinsertactivation);
                }

            }


        }


    }

    public function listedesmodulesacteuractiveAction () {

    }
    public function lecturedesconditionsdefranchiseAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $date_activation = $created->toString('yyyy-MM-dd HH:mm:ss');

        
        $sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membre_activation = $sessionmembre->code_membre;

    }

    public function listedesdecoupagesgeographiquesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();

        $libelle_franchise = "";

       if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $searchkeyfranchises = (string)$this->_request->getParam('searchkeyfranchises');


        if ($searchkeyfranchises == "franchise_implantation_locale") {

         $dbselectallfranchise = "SELECT * FROM eu_achat_franchises WHERE eu_achat_franchises.id_type_franchise = 1";

         $libelle_franchise = "Franchisé implantation locale";

        }elseif($searchkeyfranchises == "franchise_entite_membre"){

         $dbselectallfranchise = "SELECT * FROM eu_achat_franchises WHERE eu_achat_franchises.id_type_franchise = 3";

         $libelle_franchise = "Franchisé entité localité membre du GIE ESMC";


        }elseif($searchkeyfranchises == "franchise_locale"){

         $dbselectallfranchise = "SELECT * FROM eu_achat_franchises WHERE eu_achat_franchises.id_type_franchise = 2";


         $libelle_franchise = "Franchisé locale de base";

        }

        
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
        $stmtselectallfranchise = $db->query($dbselectallfranchise);

        $selectallfranchise = $stmtselectallfranchise->fetchAll();

        $countallfranchise = count($selectallfranchise);


        $this->view->keyfranchise = $searchkeyfranchises;

        $this->view->countallfranchise = $countallfranchise;

        $this->view->libelle_franchise = $libelle_franchise;
       }



    }

    public function listedesfranchiseszonesmonetairesAction () {

        /**
         * Est ce que le découpage géographique des franchises doit être la même chez tous les franchisés?
         */

        $searchkeyfranchises = (string)$this->_request->getParam('searchkeyfranchises');

        $t_zone = new Application_Model_DbTable_EuZone();

        $zones = $t_zone->fetchAll();

        $this->view->zones = $zones;

        $this->view->keyfranchises = $searchkeyfranchises;

        
        if ($searchkeyfranchises == "franchise_implantation_locale") {


                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises, eu_centres

                                         WHERE eu_achat_franchises.id_type_franchise = 1";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                $stmtrecherchefranchises = $db->query($dbrecherchefranchise);

                $recherchefranchises = $stmtrecherchefranchises->fetchAll();

                $countfranchises = count($recherchefranchises);

                $this->view->countfranchises = $countfranchises;

                $this->view->listedesresultatsdelarecherchedefranchise = $recherchefranchises;

                if ($countfranchises > 10) {

                    $searchkey = $_POST['search_box_guichet'];

                }

                

        }elseif($searchkeyfranchises == "franchise_entite_membre"){

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises

                                         WHERE eu_achat_franchises.id_type_franchise = 3";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                $stmtrecherchefranchises = $db->query($dbrecherchefranchise);

                $recherchefranchises = $stmtrecherchefranchises->fetchAll();

                $countfranchises = count($recherchefranchises);

                if ($countfranchises == 0) {

                    $validationerrors['empty_search'] = "";
                }


        }elseif($searchkeyfranchises == "franchise_locale"){

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises

                                         WHERE eu_achat_franchises.id_type_franchise = 2";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                $stmtrecherchefranchises = $db->query($dbrecherchefranchise);

                $recherchefranchises = $stmtrecherchefranchises->fetchAll();

                $countfranchises = count($recherchefranchises);

                if ($countfranchises == 0) {

                    $validationerrors['empty_search'] = "";
                }

        }


    }

    public function listedesfranchisescontinentAction () {


    }

    public function listedesfranchisespaysAction () {


    }

    public function listedesfranchisesregionouequivalentAction () {


    }

    public function listedesfranchisescommunesouequivalentAction () {


    }

    public function listedesfranchisesprefecturesouequivalentAction () {

    }

    public function listedesfranchisescantonsouequivalentAction () {

    }
    public function rechercherdefranchiseAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $date_franchise = $created->toString('yyyy-MM-dd HH:mm:ss');

        $searchkeyfranchises = (string)$this->_request->getParam('searchkeyfranchises');

        $dbassociation = new Application_Model_DbTable_EuAssociation();

        $dbachatfranchises = new Application_Model_DbTable_EuAchatFranchises();

        $dbmembreasso = new Application_Model_DbTable_EuMembreasso();

        $dbguichets = new Application_Model_DbTable_EuGuichets();
        
        $t_zone = new Application_Model_DbTable_EuZone();

        $t_pays = new Application_Model_DbTable_EuPays();

        $t_region = new Application_Model_DbTable_EuRegion();

        $t_prefecture = new Application_Model_DbTable_EuPrefecture();

        $t_canton = new Application_Model_DbTable_EuCanton();

        $t_secteur = new Application_Model_DbTable_EuSecteur();

        $zones = $t_zone->fetchAll();

        $pays = $t_pays->fetchAll();

        $regions = $t_region->fetchAll();

        $prefectures = $t_prefecture->fetchAll();

        $cantons = $t_canton->fetchAll();

        $this->view->zones = $zones;

        $this->view->pays = $pays;

        $this->view->regions = $regions;

        $this->view->prefectures = $prefectures;

        $this->view->cantons = $cantons;

        //Avant de lister les franchises zone monétaires


        if ($searchkeyfranchises == "franchise_implantation_locale") {


                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises

                                         WHERE eu_achat_franchises.id_type_franchise = 1";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                $stmtrecherchefranchises = $db->query($dbrecherchefranchise);

                $recherchefranchises = $stmtrecherchefranchises->fetchAll();

                $countfranchises = count($recherchefranchises);

                if ($countfranchises == 0) {

                    $validationerrors['empty_search'] = "";
                }


        }elseif($searchkeyfranchises == "franchise_entite_membre"){

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises

                                         WHERE eu_achat_franchises.id_type_franchise = 3";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                $stmtrecherchefranchises = $db->query($dbrecherchefranchise);

                $recherchefranchises = $stmtrecherchefranchises->fetchAll();

                $countfranchises = count($recherchefranchises);

                if ($countfranchises == 0) {

                    $validationerrors['empty_search'] = "";
                }


        }elseif($searchkeyfranchises == "franchise_locale"){

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises

                                         WHERE eu_achat_franchises.id_type_franchise = 2";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                $stmtrecherchefranchises = $db->query($dbrecherchefranchise);

                $recherchefranchises = $stmtrecherchefranchises->fetchAll();

                $countfranchises = count($recherchefranchises);

                if ($countfranchises == 0) {

                    $validationerrors['empty_search'] = "";
                }

        }

        if ($request->isPost()) {

            $code_zone = htmlspecialchars($_POST['code_zone']);

            $id_pays = htmlspecialchars($_POST['id_pays']);

            $id_region = htmlspecialchars($_POST['id_region']);

            $id_prefecture = htmlspecialchars($_POST['id_prefecture']);

            $id_canton = htmlspecialchars($_POST['id_canton']);

            if ($id_pays == "" && $id_region == "" && $id_prefecture == "" && $id_canton == "") {

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises
                
                                         WHERE eu_achat_franchises.code_zone = '$code_zone'";

            }elseif ($id_region == "" && $id_prefecture == "" && $id_canton == ""){

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises
                
                                         WHERE eu_achat_franchises.code_zone = '$code_zone'
                
                                         AND eu_achat_franchises.id_pays = $id_pays";

            }elseif ($id_prefecture == "" && $id_canton == ""){

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises
                
                                         WHERE eu_achat_franchises.code_zone = '$code_zone'
                
                                         AND eu_achat_franchises.id_pays = $id_pays
                
                                         AND eu_achat_franchises.id_regions = $id_region";

            }elseif ($id_canton == ""){

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises
                
                                         WHERE eu_achat_franchises.code_zone = '$code_zone'
                
                                         AND eu_achat_franchises.id_pays = $id_pays
                
                                         AND eu_achat_franchises.id_regions = $id_region

                                         AND eu_achat_franchises.id_prefectures = $id_prefecture";

            }else {

                $dbrecherchefranchise = "SELECT * 
            
                                         FROM eu_achat_franchises
                
                                         WHERE eu_achat_franchises.code_zone = '$code_zone'
                
                                         AND eu_achat_franchises.id_pays = $id_pays
                
                                         AND eu_achat_franchises.id_regions = $id_region

                                         AND eu_achat_franchises.id_prefectures = $id_prefecture
                
                                         AND eu_achat_franchises.id_canton = $id_canton";

            }


            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
            $stmtrecherchefranchises = $db->query($dbrecherchefranchise);

            $recherchefranchises = $stmtrecherchefranchises->fetchAll();

            $this->view->searchfranchises = $recherchefranchises;

        }

    }

    public function pagespecialfranchiseAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();
        
        $created = Zend_Date::now();

        $get_type_franchise = (string)$this->_request->getParam('get_franchise');

        $ref_franchise = substr(md5(uniqid(rand(), true)), 0, 10);

        $ref_franchise = strtoupper('FRAN-'.$ref_franchise);

        $this->view->get_type_franchise = $get_type_franchise;


        if ($get_type_franchise == "implantation_locale") {


        }elseif ($get_type_franchise == "entite_local_membre") {


        }elseif ($get_type_franchise == "local_base") {


        }

    }

    public function checkbanvalueAction () {

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die('Vous n\'êtes pas autorisé à effectuer cette opération');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->_helper->layout->disableLayout();

            $db = Zend_Db_Table::getDefaultAdapter();
    
            $request = $this->getRequest();
    
            $validationerrors = array();
            
            $created = Zend_Date::now();
    
            $bon_neutreM = new Application_Model_EuBonNeutreMapper();
    
            $bon_neutre_detailM = new Application_Model_EuBonNeutreDetailMapper();
    
            $check_ban = $_POST['check_ban_code'];
    


            if ($check_ban == "") {
                
                $resultjson = array(

                    'error'=>1,

                    'message'=>'Aucun résultat..Veuillez reprendre svp!'
                );
            }else {

                $bon_neutre = $bon_neutreM->fetchAllByCode($check_ban);

    
                if (count($bon_neutre) == 0) {
    
                    $resultjson = array(
    
                        'error'=>1,
    
                        'message'=>'Code erroné..Veuillez reprendre svp!'
                    );
    
                }
    
    
    
    
                if (count($bon_neutre) != 0) {
    
                    $bon_neutre_detail = $bon_neutre_detailM->fetchAllByCode($check_ban);
    
                    $montant_ban = $bon_neutre_detail->bon_neutre_detail_montant;
        
                    $solde_ban = $bon_neutre->bon_neutre_montant_solde;
    
                    $resultjson = array(
    
                        'error'=>0,
    
                        'message'=>'Trouvé!',
    
                        'montantban'=>$montant_ban,
    
                        'soldeban'=>$solde_ban
                    );
                }
    
            }
            /**
             * Franchisé d'implantation d'une localité à sous lui plusieurs franchisé de la localité
             * La Recherche de franchisé est triées par l'achat 
             * Mettre sur le formulaire de création de franchisé *
             * Possibilité de désangager le franchisé du contrat de franchise
             * Valider les demandes de création de franchise
             * 
             * 
             * 
             */
            header('Content-type:application/json');
    
            die(json_encode($resultjson));

        }



    }
    public function ajouteragenceoddciblesetindicateurAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();
        
        $created = Zend_Date::now();

        $dbfupdate = "UPDATE eu_odd
                
                      SET eu_odd.type_agence_odd = 'Agence d’intégration universelle GIE ESMC ODD n° 1 : 7 Cibles et 14 Indicateurs' 
                              
                      WHERE eu_odd.id_odd = 1";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $db->query($dbfupdate);

    }

    public function ajouterdestypesdefranchisesAction () {

        
        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();
        
        $created = Zend_Date::now();


        if ($request->isPost()) {

            $libelle_type_franchise = trim(htmlspecialchars($_POST['libelle_franchises']));

            if($libelle_type_franchise == "" || empty($libelle_type_franchise)){

                $validationerrors['errors_empty_type_franchise'] = "Vous devez rendez renseigné le type de franchise";
            }

            $dbselectfranchises = "SELECT * 

                                   FROM eu_franchises

                                   WHERE eu_franchises.libelle_franchises ='$libelle_type_franchise'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
            $stmtfranchises = $db->query($dbselectfranchises);

            $dbverifdoublonstypesfranchise = $stmtfranchises->fetchAll();

            if (count($dbverifdoublonstypesfranchise) != 0){

                $validationerrors['error_doublons'] = "Error 403: Ce type de franchise a déja été enrégistré";

            }

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }


            if (empty($validationerrors)) {

                $dbinsertypesfranchises = "INSERT INTO eu_franchises(libelle_franchises) VALUES ('$libelle_type_franchise')";
                
                $db->setFetchMode(Zend_Db::FETCH_OBJ);

               
                if ($db->query($dbinsertypesfranchises)){

                    $this->_redirect("/guichets/ajouterdestypesdefranchises");

                }

            }
        }

    }


    public function ajouterungroupedefranchiseAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();
        
        $created = Zend_Date::now();


        $dbinsertypesfranchises = "INSERT INTO eu_groupe_franchise(libelle_groupe_franchise) VALUES ('Partenaires Objectifs de Développement Durable (PODD)')";

                
        $db->setFetchMode(Zend_Db::FETCH_OBJ);

       
        $db->query($dbinsertypesfranchises);
    }

    public function ajouterunguichetAction () {

        /***
         * Cette action sera accessible aux centres
         * Ajouter la personne morale en tant que guichet dans la table association avec tous les informations y afférante
         * ajouter le representant du guichet et s'assurer que ce représentant soit véritablement le représentant du guichet et soit un intégrateur
         * Il faut vérifier que le nouveau guichet soit franchisé
         * 
         */  

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();
        
        $created = Zend_Date::now();

        $countallagencesbycentres = 0;

        $date_created_guichet = $created->toString('yyyy-MM-dd HH:mm:ss');

        $id_utilisateur_guichet = $_SESSION['utilisateur']['id_utilisateur'];

        $dbassociation = new Application_Model_DbTable_EuAssociation();

        $dbmembreasso = new Application_Model_DbTable_EuMembreasso();

        $dbguichets = new Application_Model_DbTable_EuGuichets();


        $dbverifuserisrespcentre = "SELECT eu_utilisateur.responsabilite_centres, eu_utilisateur.id_centres 
        
                                    FROM eu_utilisateur 
                                    
                                    WHERE eu_utilisateur.id_utilisateur = '$id_utilisateur_guichet' 
                                    
                                    AND eu_utilisateur.responsabilite_centres = 1";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $smtverifuserisrespcentre = $db->query($dbverifuserisrespcentre);

        $fetchverifuserisrespcentre = $smtverifuserisrespcentre->fetchAll();

        $dblistedestypescentres = "SELECT * 
    
                                 FROM eu_type_centres";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmttypescentres = $db->query($dblistedestypescentres);

        $listedestypescentres = $stmttypescentres->fetchAll();

        $dblistedesagencesbyodd = "SELECT eu_odd.type_agence_odd, 

                                          eu_odd.id_odd
    
                                   FROM eu_odd
                               
                                   WHERE eu_odd.valid = 1";

         $db->setFetchMode(Zend_Db::FETCH_OBJ);

         $stmtdesagencesbyodd = $db->query($dblistedesagencesbyodd);

         $listedesagencesbyodd = $stmtdesagencesbyodd->fetchAll(); 

         $this->view->listedestypescentres = $listedestypescentres;

         $this->view->listedesagencesbyodd = $listedesagencesbyodd;


        if (count($fetchverifuserisrespcentre) != 0){

            $centrecreateguichet = (int)$this->_request->getParam('centrecreateguichet');

            $idcentresguichet = $fetchverifuserisrespcentre[0]->id_centres;

            $dbgetallagencesbycentres = "SELECT eu_agences_odd.id_agences_odd, eu_agences_odd.libelle_agences_odd  
            
                                        FROM eu_agences_odd 
                                        
                                        WHERE eu_agences_odd.id_centres = '$idcentresguichet'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);
    
            $smtgetallagencesbycentres = $db->query($dbgetallagencesbycentres);
    
            $getallagencesbycentres = $smtgetallagencesbycentres->fetchAll();

            $countallagencesbycentres = count($getallagencesbycentres);

            if ( $countallagencesbycentres == 0){


                 $this->_redirect("/administration");

            }

            if ($countallagencesbycentres != 0){

                $presencecentre = 1;

                $this->view->getallagencesbycentres = $getallagencesbycentres;

                $this->view->presencecentre = $presencecentre;
            }

        }


        //RECUPERATION DE LA LISTE DES TYPES DE GUICHETS DANS UN SELECT

/*
        $dbselectallguichet = "SELECT * FROM eu_type_guichet";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $smt = $db->query($dbselectallguichet);

        $queryselectallguichet = $smt->fetchAll();

        $this->view->listdetouslesguichets = $queryselectallguichet;
*/

        //TRAITEMENTS

        if ($request->isPost()) {
            
            $code_membre_responsable_guichet = $_POST['guichet_code_membre_responsable_guichet'];

            $code_membre_morale = $_POST['guichet_code_membre_morale'];

            $loginintegrateur = $_POST['guichet_login_integrateur'];

            $passwordintegrateur = $_POST['guichet_password_integrateur'];

            $countfetchintegrateur = 0;


            $dbsearchintegrateur = "SELECT eu_membreasso.membreasso_id
            
                                    FROM eu_membreasso 
                                    
                                    WHERE eu_membreasso.membreasso_login = '$loginintegrateur' 
                                    
                                    AND eu_membreasso.membreasso_passe = '$passwordintegrateur'";


            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $smtsearchintegrateur = $db->query($dbsearchintegrateur);
    
            $fetchsearchintegrateur = $smtsearchintegrateur->fetchAll();

            $countfetchintegrateur = count($fetchsearchintegrateur);


            $dbsearchmembremorale = "SELECT * FROM eu_membre_morale WHERE eu_membre_morale.code_membre_morale = '$code_membre_morale'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $smtsearchmembremorale = $db->query($dbsearchmembremorale);
    
            $fetchsearchmembremorale = $smtsearchmembremorale->fetchAll();

            
            $dbtselect = "SELECT eu_bon_neutre.bon_neutre_nom, eu_bon_neutre.bon_neutre_prenom

                          FROM eu_bon_neutre, eu_bon_neutre_utilise

                          WHERE eu_bon_neutre.bon_neutre_id = eu_bon_neutre_utilise.bon_neutre_id

                          AND eu_bon_neutre_utilise.bon_neutre_utilise_libelle = 'CMFH'

                          AND eu_bon_neutre_utilise.bon_neutre_utilise_montant >= 218750

                          AND eu_bon_neutre.bon_neutre_code_membre = '$code_membre_responsable_guichet'"; 

             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             $stmttencompte = $db->query($dbtselect);

             $verifcmfh = $stmttencompte->fetchAll();

             $dbveriffranchiseguichet = "SELECT eu_franchise.id_franchise 
             
                                         FROM eu_franchise 
                                         
                                         WHERE eu_franchise.code_membre_franchise = '$code_membre_morale'";

             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             $stmtfranchiseguichet = $db->query($dbveriffranchiseguichet);

             $veriffranchiseguichet = $stmtfranchiseguichet->fetchAll();



             $dbverifyguichetbyrepresentant = "SELECT *

                                               FROM eu_representation 
                                               
                                               WHERE eu_representation.code_membre = '$code_membre_responsable_guichet' 
                                               
                                               AND eu_representation.code_membre_morale = '$code_membre_morale'";

             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             $stmtguichetbyrepresentant = $db->query($dbverifyguichetbyrepresentant);

             $verifyguichetbyrepresentant = $stmtguichetbyrepresentant->fetchAll();


             $dbverifyactivationcompteintegrateur = "SELECT eu_membreasso.membreasso_id 
             
                                                     FROM eu_membreasso 
                                                     
                                                     WHERE eu_membreasso.code_membre = '$code_membre_responsable_guichet'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtverifyactivationcompteintegrateur = $db->query($dbverifyactivationcompteintegrateur);

            $verifyactivationcompteintegrateur = $stmtverifyactivationcompteintegrateur->fetchAll();


            $dbverifselectdble = "SELECT eu_association.association_id
                
                                  FROM eu_association 
                                                                                             
                                  WHERE eu_association.code_membre = '$code_membre_morale'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $smtverifselectdoublonassoc = $db->query($dbverifselectdble);

            $verifselectdoublonassoc = $smtverifselectdoublonassoc->fetchAll();

             
            if (count($verifselectdoublonassoc) != 0){

                $validationerrors['error_doublons_guichet'] = "Ce guichet a été déja créée";

            }

            if ($countfetchintegrateur == 0){
                
                $validationerrors['error_integrateur_guichet'] = "Votre login ou mot de passe intégrateur est incorrect";

            }
             
/*
             if (count($veriffranchiseguichet) == 0){

                $validationerrors['error_signature_contrat'] = "Vous devez d'abord signez le contrat de franchise";

             }
*/
             
             if (count($verifyguichetbyrepresentant) == 0){

                $validationerrors['error_signature_contrat'] = "Vous n'êtes pas le représentant du guichet que vous voulez créer!";

             }

            if (count($verifcmfh) == 0 ){

                $validationerrors['error_verify_cmfh'] = " Vous devez d'abord vous inscrire sur la plateforme en tant qu'intégrateur";
            }

            if (count($fetchsearchmembremorale) == 0){

                $validationerrors['error_search_membre_morale'] = "Vous devez d'abord vous inscrire sur la plateforme en tant que membre morale";

            }

            if (count($verifyactivationcompteintegrateur) == 0){

                $validationerrors['error_activation_integrateur'] = "Vous devez d'abord activé votre compte intégrateur";

             }


            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){

                $raison_social_guichet = $fetchsearchmembremorale[0]->raison_sociale;

                $guichet = 1;

                $email_guichet = $fetchsearchmembremorale[0]->email_membre;


                $telephone_guichet = $fetchsearchmembremorale[0]->portable_membre;

                $recipice_guichet = $fetchsearchmembremorale[0]->num_registre_membre;

                $id_integrateur = $verifyactivationcompteintegrateur[0]->integrateur_id;

                if ($countallagencesbycentres != 0){

                    $id_agencesodd = $_POST['organisation_agence_odd_guichet'];


                }


                $queryguichet = array(

                    'association_nom' =>$raison_social_guichet,

                    'association_mobile'=>$telephone_guichet,

                    'association_email' => $email_guichet,

                    'association_recepisse' => $recipice_guichet,

                    'association_date' => $date_created_guichet,

                    'code_membre' => $code_membre_morale,

                    'guichet' => $guichet,

                    'id_agences_odd' => $id_agencesodd,

                    'id_utilisateur' => $id_utilisateur_guichet

                );


                if ($dbassociation->insert($queryguichet)){

                    
                     $dbselectlastinsertassoc = "SELECT eu_association.association_id 
                
                                                 FROM eu_association 
                                                                                             
                                                 WHERE eu_association.code_membre = '$code_membre_morale'";

                     $db->setFetchMode(Zend_Db::FETCH_OBJ);

                     $stmtlastinsertassoc = $db->query($dbselectlastinsertassoc);

                     $selectlastinsertassoc = $stmtlastinsertassoc->fetchAll();

                     if (count($selectlastinsertassoc) != 0) {

                         $association_id = $selectlastinsertassoc[0]->association_id;

                         
                         $arrayqueryguichet = array(

                            'id_association' => $association_id,
                            
                            'date_creation_guichet' => $date_created_guichet

                        );   

                        if ($countfetchintegrateur != 0){

                            $id_integrateurguichet = $fetchsearchintegrateur[0]->membreasso_id;

                            $dbmembreasso->update(array('membreasso_association'=>$association_id), array('membreasso_id = ?'=>$id_integrateurguichet));

                        }
                        
                        if ($dbguichets->insert($arrayqueryguichet)){

                             $this->_redirect("/guichets/listedesguichetsbyagences");

                        }
/*
                         for ($i = 0; $i< count($_POST['type_guichet']); $i++){

                             $id_type_guichet = $_POST['type_guichet'][$i];

                             $arrayqueryguichet = array(

                                 'id_association' => $association_id,
                                 
                                 'id_type_guichet' => $id_type_guichet,

                                 'date_creation_guichet' => $date_created_guichet
 
                             );   
                             
                             $dbguichets->insert($arrayqueryguichet);
                         }
*/

                    }

                }


            }


        }

    }

    public function interfaceachatdefranchiseAction () {

        /**
         * 
         * Est ce que le bon neutre doit se fair
        * var_dump('Current PHP version: '. Phpversion());
         * 
         */

        $sessionmembre = new Zend_Session_Namespace('membre');	

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();
        
        $created = Zend_Date::now();

        $countallagencesbycentres = 0;

        $date_created_franchise = $created->toString('yyyy-MM-dd HH:mm:ss');

        $dbcentre = new Application_Model_DbTable_EuCentres();

        $dbagence = new Application_Model_DbTable_EuAgences();

        $dbassociation = new Application_Model_DbTable_EuAssociation();

        $dbachatfranchises = new Application_Model_DbTable_EuAchatFranchises();

        $dbmembreasso = new Application_Model_DbTable_EuMembreasso();

        $dbguichets = new Application_Model_DbTable_EuGuichets();
        
        $t_zone = new Application_Model_DbTable_EuZone();

        $t_pays = new Application_Model_DbTable_EuPays();

        $t_region = new Application_Model_DbTable_EuRegion();

        $t_prefecture = new Application_Model_DbTable_EuPrefecture();

        $t_canton = new Application_Model_DbTable_EuCanton();

        $t_secteur = new Application_Model_DbTable_EuSecteur();

        $dbdocumentfranchise = new Application_Model_DbTable_EuDocumentsFranchises();

        $zones = $t_zone->fetchAll();

        $pays = $t_pays->fetchAll();

        $regions = $t_region->fetchAll();

        $prefectures = $t_prefecture->fetchAll();

        $cantons = $t_canton->fetchAll();

        $get_type_franchise = (string)$this->_request->getParam('getfranchise');

        
        $dblistedestypescentres = "SELECT * 
    
                                   FROM eu_type_centres";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmttypescentres = $db->query($dblistedestypescentres);

        $listedestypescentres = $stmttypescentres->fetchAll();

        $dblistedesagencesbyodd = "SELECT eu_odd.type_agence_odd, 

                                          eu_odd.id_odd
    
                                   FROM eu_odd
                               
                                   WHERE eu_odd.valid = 1";

         $db->setFetchMode(Zend_Db::FETCH_OBJ);

         $stmtdesagencesbyodd = $db->query($dblistedesagencesbyodd);

         $listedesagencesbyodd = $stmtdesagencesbyodd->fetchAll(); 


         $dblistedesgroupesdefranchise = "SELECT * FROM eu_groupe_franchise";
    
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
     
         $stmtlistedesgroupesdefranchise = $db->query($dblistedesgroupesdefranchise);
     
         $listedesgroupesdefranchise = $stmtlistedesgroupesdefranchise->fetchAll();


         $dblistedesbanques = "SELECT eu_banque.code_banque, eu_banque.libelle_banque FROM eu_banque";
    
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
     
         $stmtlistedesbanques = $db->query($dblistedesbanques);
     
         $listedesbanques = $stmtlistedesbanques->fetchAll();


         $dblistdestypesdefranchise = "SELECT * FROM eu_type_franchises";
             
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
     
         $stmtlistedestypesdefranchise = $db->query($dblistdestypesdefranchise);
     
         $listedestypesdefranchise = $stmtlistedestypesdefranchise->fetchAll();


         $this->view->listedestypescentres = $listedestypescentres;

         $this->view->type_franchise = $get_type_franchise;

         $this->view->listedesagencesbyodd = $listedesagencesbyodd;

         $this->view->listedesgroupesdefranchise = $listedesgroupesdefranchise;

         $this->view->listedesbanques = $listedesbanques;

         $this->view->listedestypesdefranchise = $listedestypesdefranchise;

         $this->view->zones = $zones;

         $this->view->pays = $pays;

         $this->view->regions = $regions;

         $this->view->prefectures = $prefectures;

         $this->view->cantons = $cantons;

        if ($request->isPost()) {

            var_dump($_POST);

            var_dump($_FILES);

            $ref_franchise = substr(md5(uniqid(rand(), true)), 0, 10);

            $ref_franchise = strtoupper('FRAN-'.$ref_franchise);

            $code_ban_franchise = htmlspecialchars($_POST['code_BAn']);

            $type_centre_franchise = htmlspecialchars($_POST['type_centre_franchise']);

            $agences_odd_franchise = htmlspecialchars($_POST['agence_odd_franchise']);

            $responsable_franchise = htmlspecialchars($_POST['guichet_code_membre_responsable_guichet']);

            $code_membre_morale_franchise = $sessionmembre->code_membre;

            $login_compte_integrateur = htmlspecialchars($_POST['guichet_login_integrateur']);

            $pasword_compte_integrateur = htmlspecialchars($_POST['guichet_password_integrateur']);

            $type_franchise = htmlspecialchars($_POST['type_franchise']);

            $interface_franchise = htmlspecialchars($_POST['interface_franchise']);

            $franchise_banque_operateur = htmlspecialchars($_POST['franchise_compte_banque']);

            $adresse_franchise = htmlspecialchars($_POST['adresse_franchise']);            

            $numero_banque_franchise_operateur = htmlspecialchars($_POST['numero_franchise_comptebanque']);

            $code_zone = htmlspecialchars($_POST['code_zone']);

            $id_pays = htmlspecialchars($_POST['id_pays']);

            $id_region = htmlspecialchars($_POST['id_region']);

            $id_prefecture = htmlspecialchars($_POST['id_prefecture']);

            $id_canton = htmlspecialchars($_POST['id_canton']);

            $logo_name = htmlspecialchars($_POST['franchise_logo_file']);

            $franchise_logo_file = htmlspecialchars($_POST['franchise_logo_file']);

            $tmpCvFilePathlogo = $_FILES['franchise_logo_file']['tmp_name'];

            $type_logo_franchise = $_FILES['franchise_logo_file']['type'];

            $size_logo_franchise = $_FILES['franchise_logo_file']['size'];

            $logoextension = strtolower(pathinfo($_FILES['franchise_logo_file']['name'][$i],PATHINFO_EXTENSION));

                                    
/**
 * Vérification de la validité du compte intégrateur auquel sera lié le futur agence
 * 
 *  
 */


            $dbverifyactivationcompteintegrateur = "SELECT eu_membreasso.membreasso_id 
             
                                                     FROM eu_membreasso 
                                                     
                                                     WHERE eu_membreasso.code_membre = '$code_membre_responsable_guichet'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtverifyactivationcompteintegrateur = $db->query($dbverifyactivationcompteintegrateur);

            $verifyactivationcompteintegrateur = $stmtverifyactivationcompteintegrateur->fetchAll();

            if (count($verifyactivationcompteintegrateur) == 0) {

                $validationerrors['error_integrateur_guichet'] = "Votre login ou mot de passe intégrateur est incorrect";

            } else {

                    $dbsearchintegrateur = "SELECT eu_membreasso.membreasso_id
            
                                    FROM eu_membreasso 
                                    
                                    WHERE eu_membreasso.membreasso_login = '$login_compte_integrateur' 
                                    
                                    AND eu_membreasso.membreasso_passe = '$pasword_compte_integrateur'";


                     $db->setFetchMode(Zend_Db::FETCH_OBJ);

                     $smtsearchintegrateur = $db->query($dbsearchintegrateur);
    
                     $fetchsearchintegrateur = $smtsearchintegrateur->fetchAll();

                     $countfetchintegrateur = count($fetchsearchintegrateur);

            
                     if ($countfetchintegrateur == 0){
                
                         $validationerrors['error_integrateur_guichet'] = "Votre login ou mot de passe intégrateur est incorrect";

                     }          
            }

    /**
     * VERIFIER QUE LE COMPTE PERSONNE MORALE EXISTE BEL ET BIEN
     */

            $dbsearchmembremorale = "SELECT * FROM eu_membre_morale WHERE eu_membre_morale.code_membre_morale = '$code_membre_morale_franchise'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $smtsearchmembremorale = $db->query($dbsearchmembremorale);
    
            $fetchsearchmembremorale = $smtsearchmembremorale->fetchAll();

            if (count($fetchsearchmembremorale) == 0){

                $validationerrors['error_search_membre_morale'] = "Vous devez d'abord vous inscrire sur la plateforme en tant que membre morale";

            }

            $dbtselect = "SELECT eu_bon_neutre.bon_neutre_nom, eu_bon_neutre.bon_neutre_prenom

                          FROM eu_bon_neutre, eu_bon_neutre_utilise

                          WHERE eu_bon_neutre.bon_neutre_id = eu_bon_neutre_utilise.bon_neutre_id

                          AND eu_bon_neutre_utilise.bon_neutre_utilise_libelle = 'CMFH'

                          AND eu_bon_neutre_utilise.bon_neutre_utilise_montant >= 1800000 

                          AND eu_bon_neutre.bon_neutre_code_membre = '$code_membre_morale_franchise'
                          
                          AND eu_bon_neutre.bon_neutre_utilise_type = 'PM'

                          AND eu_bon_neutre.bon_neutre_code = $code_ban_franchise"; 

             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             $stmttencompte = $db->query($dbtselect);

             $verifcmfh = $stmttencompte->fetchAll();

             if (count($verifcmfh) == 0 ){

                $validationerrors['error_verify_cmfh'] = "Vous devez d'abord vous inscrire sur la plateforme en tant qu'intégrateur";
            }

             $dbveriffranchiseguichet = "SELECT contrat_franchise.id_contrat_franchise 
             
                                         FROM contrat_franchise 
                                         
                                         WHERE contrat_franchise.code_membre_morale = '$code_membre_morale_franchise'";

             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             $stmtfranchiseguichet = $db->query($dbveriffranchiseguichet);

             $veriffranchiseguichet = $stmtfranchiseguichet->fetchAll();

             if (count($veriffranchiseguichet) == 0){

                $validationerrors['error_signature_contrat'] = "Vous devez d'abord signez le contrat de franchise";

             }

            $dbverifyguichetbyrepresentant = "SELECT *

                                               FROM eu_representation 
                                               
                                               WHERE eu_representation.code_membre = '$code_membre_morale_franchise' 
                                               
                                               AND eu_representation.code_membre_morale = '$code_membre_morale'";

             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             $stmtguichetbyrepresentant = $db->query($dbverifyguichetbyrepresentant);

             $verifyguichetbyrepresentant = $stmtguichetbyrepresentant->fetchAll();


             if (count($verifyguichetbyrepresentant) == 0){

                $validationerrors['error_signature_contrat'] = "Vous n'êtes pas le représentant du guichet que vous voulez créer!";

             }

             
            $dbverifselectdble = "SELECT eu_association.association_id
                
                                  FROM eu_association 
                                                                                             
                                  WHERE eu_association.code_membre = '$code_membre_morale_franchise'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $smtverifselectdoublonassoc = $db->query($dbverifselectdble);

            $verifselectdoublonassoc = $smtverifselectdoublonassoc->fetchAll();

            if (count($verifselectdoublonassoc) == 0) {


            }

            if (count($verifselectdoublonassoc) != 0) {

                $get_association_id = $verifselectdoublonassoc[0]->association_id;

                $dbfranchisedoublons = "SELECT eu_achat_franchises.id_achat_franchises
            
                                        FROM eu_achat_franchises
                
                                        WHERE eu_achat_franchises.id_association = $get_association_id";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $smtverifselectdoublonassoc = $db->query($dbverifselectdble);

                $verifselectdoublonassoc = $smtverifselectdoublonassoc->fetchAll();
            }

            $dbactivationobpsd = "SELECT eu_activation_acteur.id_activation_acteur
            
                                 FROM eu_activation_acteur
                                 
                                 WHERE eu_activation_acteur.code_membre = '$code_membre_morale_franchise'
                                 
                                 AND eu_activation_acteur.libelle_membre = 'OBPSD'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $smtactivationobpsd = $db->query($dbactivationobpsd);

            $activationobpsd = $smtactivationobpsd->fetchAll();

            $countactivationobpsd = count($activationobpsd);

            if ($countactivationobpsd == 0) {

                $validationerrors['error_signature_contrat'] = "Vous devez activer votre compte OBPSD pour aller plus loin";

            }

            if( $franchise_logo_file == "" || empty($franchise_logo_file)){

                $validationerrors['empty_logo_name'] = "Le nom du logo doit être renseigné";
            }

            if($type_logo_franchise == "" || empty($type_logo_franchise)){

                $validationerrors['empty_typefile_name'] = "Document invalide:Le type du document de franchise est inexistant";
            }


           if($size_logo_franchise == "" || empty($size_logo_franchise)){

                $validationerrors['empty_cvtypefile_name'] = "Document invalide: la taille du document de franchise est inexistant";

           }


           
           if(!in_array($logoextension,array('jpg','png','jpeg','gif'))){

                   $validationerrors['docextensions'] = "Le logo du franchisé est sous un format non autorisé";

           }


            for ($i = 0; $i< count($_POST['document_franchise_name']); $i++){
                                 
                $nom_document = trim(addslashes($_POST['document_franchise_name'][$i]));

                $tmpCvFilePath = $_FILES['document_franchise']['tmp_name'][$i];

                $type_document_franchise = $_FILES['document_franchise']['type'][$i];

                $size_document_franchise = $_FILES['document_franchise']['size'][$i];

                $docextension = strtolower(pathinfo($_FILES['document_franchise']['name'][$i],PATHINFO_EXTENSION));


                if($nom_document == "" || empty($nom_document)){

                    $validationerrors['empty_file_name'] = "Le nom du document doit être renseigné";
                }
   
                if($type_document_franchise == "" || empty($type_document_franchise)){

                    $validationerrors['empty_typefile_name'] = "Document invalide:Le type du document de franchise est inexistant";
                }

    
               if($size_document_franchise == "" || empty($size_document_franchise)){

                    $validationerrors['empty_cvtypefile_name'] = "Document invalide: la taille du document de franchise est inexistant";

               }

   
               
               if(!in_array($docextension,array('pdf','jpg','png','jpeg','doc','docx'))){

                       $validationerrors['docextensions'] = "Le document de franchise est sous un format non autorisé";

               }


            }

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)) {

                $reference_centre = substr(md5(uniqid(rand(), true)), 0, 8);

                $real_reference_centre = strtoupper('CENT-'.$reference_centre);

                $real_agence_odd = strtoupper('AGENCES-'.$reference_centre);


                if ($type_centre_franchise == 1) {

                    $type_centre = "zone monetaire";

                    $dbselectzone = "SELECT eu_zone.nom_zone
                                     
                                     FROM eu_zone

                                     WHERE eu_zone.code_zone = '$code_zone'";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    $stmtselectzone = $db->query($dbselectzone);
                    
                    $gettype_centre = $stmtselectzone->fetchAll();


                    $nom_zone = $gettype_centre->nom_zone;

                    $libelle_centre_franchise = "Franchisé de la $nom_zone";



                    $querycentresfranchise = array(

                        'reference_centre'=>$real_reference_centre,

                        'libelle_centre'=>$libelle_centre_franchise,

                        'code_membre_morale'=>$code_membre_morale_franchise,

                        'addresse_centre'=>$adresse_franchise,

                        'date_centres'=>$date_created_franchise,

                        'type_centre'=>$type_centre, 

                        'code_zone'=>$code_zone,

                        'franchise'=>1
                    );

                }elseif ($type_centre_franchise == 2) {

                    $type_centre = "national";
                    
                    $dbselectpays = "SELECT eu_pays.libelle_pays
                                     
                                     FROM eu_pays

                                     WHERE eu_pays.id_pays = '$id_pays'";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    $stmtselectpays = $db->query($dbselectpays);
                    
                    $getpays = $stmtselectpays->fetchAll();

                    $nom_zone = $gettype_centre->nom_zone;

                    $nom_pays = $getpays->libelle_pays;


                    $libelle_centre_franchise = "Franchisé du centre national $nom_pays";



                    $querycentresfranchise = array(

                        'reference_centre'=>$real_reference_centre,

                        'libelle_centre'=>$libelle_centre_franchise,

                        'code_membre_morale'=>$code_membre_morale_franchise,

                        'addresse_centre'=>$adresse_franchise,

                        'date_centres'=>$date_created_franchise,

                        'type_centre'=>$type_centre, 

                        'code_zone'=>$code_zone,

                        'id_pays'=>$id_pays,

                        'franchise'=>1
                    );

                }elseif ($type_centre_franchise == 3) {

                    $type_centre = "regional";

                    $dbselectregion = "SELECT eu_region.nom_region
                                     
                                     FROM eu_region

                                     WHERE eu_region.id_region = '$id_region'";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    $stmtselectregion = $db->query($dbselectregion);
                    
                    $getregion = $stmtselectregion->fetchAll();

                    $nom_region = $getregion->libelle_region;

                    $libelle_centre_franchise = "Franchisé du centre regional $nom_region";


                    $querycentresfranchise = array(

                        'reference_centre'=>$real_reference_centre,

                        'libelle_centre'=>$libelle_centre_franchise,

                        'code_membre_morale'=>$code_membre_morale_franchise,

                        'addresse_centre'=>$adresse_franchise,

                        'date_centres'=>$date_created_franchise,

                        'type_centre'=>$type_centre, 

                        'code_zone'=>$code_zone,

                        'id_pays'=>$id_pays,

                        'id_region'=>$id_region,

                        'franchise'=>1
                    );

                }elseif ($type_centre_franchise == 4) {

                    $type_centre = "prefectoral";

                    $dbselectprefecture = "SELECT eu_prefecture.nom_prefecture
                                     
                                           FROM eu_prefecture

                                           WHERE eu_prefecture.id_prefecture = '$id_prefecture'";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    $stmtselectprefecture = $db->query($dbselectprefecture);
                    
                    $getprefecture = $stmtselectprefecture->fetchAll();

                    $nom_prefecture = $getprefecture->libelle_prefecture;

                    $libelle_centre_franchise = "Franchisé du centre prefectoral de la $nom_prefecture";


                    $querycentresfranchise = array(

                        'reference_centre'=>$real_reference_centre,

                        'libelle_centre'=>$libelle_centre_franchise,

                        'code_membre_morale'=>$code_membre_morale_franchise,

                        'addresse_centre'=>$adresse_franchise,

                        'date_centres'=>$date_created_franchise,

                        'type_centre'=>$type_centre, 

                        'code_zone'=>$code_zone,

                        'id_pays'=>$id_pays,

                        'id_region'=>$id_region,

                        'id_prefecture'=>$id_prefecture,

                        'franchise'=>1
                    );

                }elseif($type_centre_franchise == 5) {

                    
                    $dbselectcanton = "SELECT eu_canton.nom_canton
                                     
                                           FROM eu_canton

                                           WHERE eu_canton.id_canton = '$id_canton'";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    $stmtselectcanton = $db->query($dbselectcanton);
                    
                    $getcanton = $stmtselectcanton->fetchAll();

                    $nom_canton = $getcanton->nom_canton;

                    if ($type_centre_franchise == 5){

                        $type_centre = "communal";

                        $libelle_centre_franchise = "Franchisé du centre communal du $nom_canton";


                    }

                    if ($type_centre_franchise == 6) {

                        $type_centre = "cantonnal";

                        $libelle_centre_franchise = "Franchisé du centre cantonnal du $nom_canton";

                    }



                    $querycentresfranchise = array(

                        'reference_centre'=>$real_reference_centre,

                        'libelle_centre'=>$libelle_centre_franchise,

                        'code_membre_morale'=>$code_membre_morale_franchise,

                        'addresse_centre'=>$adresse_franchise,

                        'date_centres'=>$date_created_franchise,

                        'type_centre'=>$type_centre, 

                        'code_zone'=>$code_zone,

                        'id_pays'=>$id_pays,

                        'id_region'=>$id_region,

                        'id_prefecture'=>$id_prefecture,

                        'id_canton'=>$id_canton,

                        'franchise'=>1
                    );

                }elseif ($type_centre_franchise == 7) {

                    $type_centre = "monde";

                    $libelle_centre_franchise = "Franchisé monde du $nom_canton";

                    $querycentresfranchise = array(

                        'reference_centre'=>$real_reference_centre,

                        'libelle_centre'=>$libelle_centre_franchise,

                        'code_membre_morale'=>$code_membre_morale_franchise,

                        'addresse_centre'=>$adresse_franchise,

                        'date_centres'=>$date_created_franchise,

                        'type_centre'=>$type_centre, 

                        'franchise'=>1
                    );
                } 

                if ($dbcentre->insert($querycentresfranchise)){

                         $dbselectlastfranchisecentre = "SELECT * 

                                                         FROM eu_centres 

                                                         WHERE eu_centres.reference_centre ='$real_reference_centre'
                                      
                                                         AND eu_centres.franchise = 1";

                         $db->setFetchMode(Zend_Db::FETCH_OBJ);

                         $stmtlastfranchisecentre = $db->query($dbselectlastfranchisecentre);

                         $dbgetidcentre = $stmtlastfranchisecentre->fetchAll(); 
                         
                         if (count($dbgetidcentre) > 0){
                         
                            $id_franchise_centre = $dbgetidcentre[0]->id_centres;

                            $queryagencesfranchise = array(

                                'reference_agences_odd'=>$real_agence_odd,

                                'libelle_agences_odd'=>'Agences ODD de ',

                                'addresse_agences_odd'=>$adresse_franchise,

                                'date_agences_odd'=>$date_created_franchise,

                                'id_odd'=>$agences_odd_franchise,

                                'id_canton'=>$id_canton,

                                'id_centres'=>$id_franchise_centre,

                                'code_membre_morale'=>$code_membre_morale_franchise
                            );

                         }

                       if($dbagence->insert($queryagencesfranchise)){


                             if (count($verifyactivationcompteintegrateur != 0)){

                                 $id_integrateur = $verifyactivationcompteintegrateur[0]->integrateur_id;

                            }

                            if (count($fetchsearchmembremorale != 0)) {

                                $raison_social_franchise = $fetchsearchmembremorale[0]->raison_sociale;

                                $guichet = 1;
   
                                $email_franchise = $fetchsearchmembremorale[0]->email_membre;
   
                                $telephone_franchise = $fetchsearchmembremorale[0]->portable_membre;
   
                                $recipice_franchise = $fetchsearchmembremorale[0]->num_registre_membre;
                            }

               
                            $queryfranchise = array(

                                'association_nom' =>$raison_social_franchise,

                                'association_mobile'=>$telephone_franchise,

                                'association_email' => $email_guichet,

                                'association_recepisse' => $recipice_franchise,

                                'association_date' => $date_created_franchise,

                                'code_membre' => $code_membre_morale,

                                'guichet' => $guichet,

                                'id_agences_odd' => $id_agencesodd,

                                'id_utilisateur' => $id_utilisateur_franchise

                            );

                            if ($dbassociation->insert($queryfranchise)){
                    
                                $dbselectlastinsertassoc = "SELECT eu_association.association_id 
                           
                                                            FROM eu_association 
                                                                                                        
                                                            WHERE eu_association.code_membre = '$code_membre_morale_franchise'";
           
                                $db->setFetchMode(Zend_Db::FETCH_OBJ);
           
                                $stmtlastinsertassoc = $db->query($dbselectlastinsertassoc);
           
                                $selectlastinsertassoc = $stmtlastinsertassoc->fetchAll();
           
                                if (count($selectlastinsertassoc) != 0) {
           
                                    $association_id = $selectlastinsertassoc[0]->association_id;
           
                                    $arrayqueryguichet = array(
           
                                       'reference_franchise' => $ref_franchise,
                       
                                       'id_groupe_franchise' => $type_franchise,
                       
                                       'id_type_franchise' => $interface_franchise,
                       
                                       'id_association' => $association_id,
                       
                                       'id_type_centres'=>$type_centre_franchise,
                       
                                       'id_odd'=>$agences_odd_franchise,
                       
                                       'id_banque'=>$franchise_banque_operateur,
                       
                                       'numero_banque'=>$numero_banque_franchise_operateur,
                                       
                                       'date_achat_franchise' => $date_created_franchise,
           
                                       'code_zone' => $code_zone,
           
                                       'id_pays'=>$id_pays,
           
                                       'id_regions' => $id_region,
           
                                       'id_prefectures' => $id_prefecture,
           
                                       'id_canton' => $id_canton
                                   );   
           
                                   if ($dbachatfranchises->insert($arrayqueryguichet)) {
           
                                       $dbselectlastinsertfranchise = "SELECT reference_franchise.id_achat_franchise
                           
                                                                       FROM eu_achat_franchises 
                                                                                                        
                                                                       WHERE eu_achat_franchises.reference_franchise = '$ref_franchise'";
           
                                       $db->setFetchMode(Zend_Db::FETCH_OBJ);
           
                                       $stmtlastinsertfranchise = $db->query($dbselectlastinsertfranchise);
           
                                       $selectlastinsertfranchise = $stmtlastinsertfranchise->fetchAll();
           
                                       if (count($selectlastinsertfranchise) != 0) {
           
                                              $franchise_id = $selectlastinsertfranchise[0]->id_achat_franchise;
           
                                              for ($i = 0; $i< count($_POST['document_franchise_name']); $i++){
                                            
                                                    $nom_document = trim(addslashes($_POST['document_franchise_name'][$i]));
                               
                                                    $tmpCvFilePath = $_FILES['document_franchise']['tmp_name'][$i];
                               
                                                    $type_file_espace = $_FILES['document_franchise']['type'][$i];
           
                                                    $docextension = strtolower(pathinfo($_FILES['document_franchise']['name'][$i],PATHINFO_EXTENSION));
           
           
                                                    if ($tmpCvFilePath != "") {
           
                                                        $dirfiles =  $franchise_id."_ESMC_FILES_".$code_membre_morale_franchise.$ref_franchise.$docextension;
           
                                                        $src_file = "../../fichiersweb/pdfachatfranchise/$dirfiles";
           
           
           
                                                        if (move_uploaded_file($tmpCvFilePath, $src_file)){
           
           
                                                           $arrayfileachatfranchise = array(
           
                                                               'libelle_document_franchise' => $nom_document,
              
                                                               'content_document_franchise' => $dirfiles,
              
                                                               'id_achat_franchise' => $franchise_id
                                                           );
           
                                                           if ($dbdocumentfranchise->insert($arrayfileachatfranchise)) {
     
                                                                     $dirfileslogo =  $franchise_id."_ESMC_LOGO_".$code_membre_morale_franchise.$ref_franchise.$logoextension;
           
                                                                     $src_file = "../../fichiersweb/logofranchise/$dirfileslogo";

                                                                     if (move_uploaded_file($tmpCvFilePathlogo, $src_file)){

                                                                        $dbfupdatefranchise = "UPDATE eu_achat_franchises
                            
                                                                                              SET eu_achat_franchises.logo_franchise = '$dirfileslogo' 
                                                                        
                                                                                              WHERE eu_achat_franchises.id_achat_franchise = '$franchise_id'";
                                                  
                                                                         $db->setFetchMode(Zend_Db::FETCH_OBJ);
                      
                                                                         $db->query($dbfupdatefranchise);
                                                                     }                                                               

                                                           }
           
                                                        }
           
                                                    }
                               
                                               }
           
                                       }
           
                                   }
           
                               }
           
                           }

                       }

                }
            
            }

        }
    }
    public function verifiersiresponsabledeguichetestintegrateurAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $code_membre_responsable_guichet = $_POST['guichet_code_membre_responsable_guichet'];


        $dbtselect = "SELECT eu_bon_neutre.bon_neutre_nom, eu_bon_neutre_prenoms

                      FROM eu_bon_neutre, eu_bon_neutre_utilise

                      WHERE eu_bon_neutre.bon_neutre_id = eu_bon_neutre_utilise.bon_neutre_id

                      AND eu_bon_neutre_utilise.bon_neutre_utilise_libelle = 'CMFH'

                      AND eu_bon_neutre_utilise.bon_neutre_utilise_montant >= 21875

                      AND eu_bon_neutre.bon_neutre_code_membre = '$code_membre_responsable_guichet'"; 

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbtselect);

        $verifcmfh = $smt->fetchAll();

        if (count($verifcmfh) == 0){

               

        }else{

            
        }


    }

    public function listedetouslesguichetsAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();

        $dbselectionguichets = "SELECT *

                                FROM eu_guichets, eu_association, eu_type_guichet
                                
                                WHERE eu_guichets.id_association = eu_association.association_id 
                                
                                AND eu_association.guichet = 1";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtallguichets = $db->query($dbselectionguichets);

        $selectionnertouslesguichets = $stmtallguichets->fetchAll();
            
        $this->view->listedesguichets = $selectionnertouslesguichets;

    }

    public function listedesguichetsbyagencesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();

        $id_agences = $_SESSION['utilisateur']['id_agences_odd'];

        $dbselectionguichetsbycentre = "SELECT *

                                        FROM eu_association
                                
                                        WHERE eu_association.guichet = 1
                                
                                        AND eu_association.id_agences_odd = $id_agences";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtallguichetsbycentre = $db->query($dbselectionguichetsbycentre);

        $selectionnertouslesguichets = $stmtallguichetsbycentre->fetchAll();

        $countdetouslesguichets = count($selectionnertouslesguichets);
            
        $this->view->listedesguichetsbycentres = $selectionnertouslesguichets;

        $this->view->countdetouslesguichets = $countdetouslesguichets;


    }

    

    public function ledetaildunguichetAction () {


    }

    public function modificationdunguichetAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $idguichet = (int)$this->_request->getParam('guichet');

        $id_centres = $_SESSION['utilisateur']['id_centres'];


        $dbselectupdateguichet = "SELECT *

                                  FROM eu_guichets, eu_association
                                
                                  WHERE eu_guichets.id_association = eu_association.association_id 
                                
                                  AND eu_association.guichet = 1
                                
                                  AND eu_association.id_centres = $id_centres";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectupdateguichet = $db->query($dbselectupdateguichet);

        $selectupdateguichet = $stmtselectupdateguichet->fetchAll();

    }

    public function ajouteruntypedeguichetAction(){

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();

        if ($request->isPost()) {

            $code_type_guichet = trim(addslashes($_POST['guichet_code_type']));

            $guichet_type_description = trim(addslashes($_POST['guichet_type_description']));



            $dbtselectlastinsertypeguichet = "SELECT * 

                                              FROM eu_type_guichet
                                              
                                              WHERE eu_type_guichet.code_type_guichet = '$code_type_guichet'
                                              
                                              AND eu_type_guichet.description_type_guichet = '$guichet_type_description'";

             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             $smt = $db->query($dbtselectlastinsertypeguichet);

             $queryveriflastinsertypeguichet = $smt->fetchAll();

             if (count($queryveriflastinsertypeguichet) != 0){

                $validationerrors['error_doublons'] = "Error 403: Cet type de guichet a déja été enrégistré";

             }

             if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){

                $dbtinsertguichet = "INSERT INTO eu_type_guichet(code_type_guichet,description_type_guichet) VALUES (

                    '$code_type_guichet',
    
                    '$guichet_type_description')";
    
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
    
                $db->query($dbtinsertguichet);
    
                $validationsuccess['success_message'] = "Le type du guichet à été ajouté avec succès";
    
                $_SESSION['validationsuccess'] = $validationsuccess;
    
                $this->_redirect("/guichets/listedetouslestypesdeguichets");

            }

        }

    }

    public function modifieruntypedeguichetAction () {


    }

    public function listedetouslestypesdeguichetsAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $dbselectallguichet = "SELECT * FROM eu_type_guichet";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $smt = $db->query($dbselectallguichet);

        $queryselectallguichet = $smt->fetchAll();

        $countqueryselectallguichet = count($queryselectallguichet);

        $this->view->listdetouslesguichets = $queryselectallguichet;

        $this->view->countallguichets = $countqueryselectallguichet;

    }

    public function validationguichetbytetedivisioncentreAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

    }

}