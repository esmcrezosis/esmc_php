<?php

class AchatventereciproqueController extends Zend_Controller_Action {


    public function interfaceavrcentraleventeAction () {
        /***Liste de tous les ELI (code_membre, libelle_eli, date_eli, lien vers les détails, valider=4) */
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbtselect = "SELECT eu_article_stockes.code_membre_morale,
                             eu_article_stockes.designation,
                             eu_article_stockes.date_enregistrement,
                             eu_article_stockes.id_article_stockes,
                             eu_membre_morale.raison_sociale

                      FROM eu_article_stockes,eu_membre_morale
                      WHERE eu_article_stockes.code_membre_morale = eu_membre_morale.code_membre_morale
                      AND eu_article_stockes.id_eli is not null";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetousleseliquisontvalides = $stmt->fetchAll();
        $countlalistedetousleseliquisontvalides = count($dblalistedetousleseliquisontvalides);    
        
        $this->view->lalistedetousleseliquisontvalides = $dblalistedetousleseliquisontvalides;    
        $this->view->countlalistedetousleseliquisontvalides = $countlalistedetousleseliquisontvalides;     
        $this->view->tabletri = 1; 
           
               
    }    

    public function interfaceavrcentraleventedetailAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $representant_code_membre = "";
        $raison_sociale = "";
        $nomsetprenoms = "";
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT eu_article_stockes.id_article_stockes FROM eu_article_stockes WHERE eu_article_stockes.id_article_stockes ='$id' AND eu_article_stockes.id_eli is not null";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidarticlestockes = $stmt->fetchAll();
            if (count($dbrecherchedelidarticlestockes) == 0) {
                http_response_code(403);
                die('Désolé,mais ce produit n\'est pas encore disponible sur la plateforme ');
            }
        }        

        
            $dbtselect = "SELECT eu_article_stockes.*,
                             eu_membre_morale.raison_sociale

                      FROM eu_article_stockes,eu_membre_morale
                      WHERE eu_article_stockes.code_membre_morale = eu_membre_morale.code_membre_morale
                      AND eu_article_stockes.id_eli is not null
                      AND eu_article_stockes.id_article_stockes = $id";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtselect);
            $dbarticlestockesdejavalider = $stmt->fetchAll(); 
            $iddetailselidejavalider = $dbarticlestockesdejavalider[0]->id_article_stockes;
            $codemembredetailselidejavalider = $dbarticlestockesdejavalider[0]->code_membre_morale;
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

                $dbverifselect = "SELECT 
                                    eu_representation.code_membre
                                  FROM eu_representation
                                  WHERE eu_representation.code_membre_morale = '$codemembredetailselidejavalider'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbverifselect);
                $dbrepresentant = $stmt->fetchAll(); 
                $representant_code_membre = $dbrepresentant[0]->code_membre;

                $dbverifselect = "SELECT 
                                     eu_membre.nom_membre,
                                     eu_membre.prenom_membre
                                  FROM eu_membre
                                  WHERE eu_membre.code_membre = '$representant_code_membre'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbverifselect);
                $dbnometprenoms = $stmt->fetchAll(); 
                $noms = $dbnometprenoms[0]->nom_membre;
                $prenoms = $dbnometprenoms[0]->prenom_membre;
                $nomsetprenoms = $noms." ".$prenoms;
            }

          $this->view->articlestockesdejavalider  = $dbarticlestockesdejavalider;
          $this->view->nomsetprenoms  = $nomsetprenoms;

          
    }

    public function interaceavrcentreventelistedetouslesdemandeachatgrandpublicAction () {

    }

    public function interfaceavrcentraleventetouslesdetailsduproduitsAction () {
       /***Possibilité de modification des quantités et des prix sur cette interface */
    }

    public function listedetouslesavrparmembreAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sessionmembre = new Zend_Session_Namespace('membre');	
        $arraylistdesavr = array();
        $code_membre =  $sessionmembre->code_membre;
        
        $dbtselect = "SELECT eu_avr_achat.id,
                             eu_avr_achat.code_membre_acheteur,
                             eu_avr_achat.reference_avr,
                             eu_avr_achat.date_achat,
                             eu_avr_achat.mode_paiement,
                             eu_avr_achat.montant_total_avr_produit_achat
                      FROM eu_avr_achat
                      WHERE eu_avr_achat.code_membre_acheteur = '$code_membre'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesdemandeachatavr = $stmt->fetchAll();
        $countlalistedetouslesdemandeachatavr = count($dblalistedetouslesdemandeachatavr);
        $this->view->lalistedetouslesdemandeachatavr = $dblalistedetouslesdemandeachatavr;            
        
    }

    public function centraldachatlistedesavrAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $arraylistdesavr = array();

        $dbtselect = "SELECT eu_avr_achat.id,
                             eu_avr_achat.code_membre_acheteur,
                             eu_avr_achat.reference_avr,
                             eu_avr_achat.date_achat,
                             eu_avr_achat.mode_paiement,
                             eu_avr_achat.montant_total_avr_produit_achat
                      FROM eu_avr_achat";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesdemandeachatavr = $stmt->fetchAll();
        $countlalistedetouslesdemandeachatavr = count($dblalistedetouslesdemandeachatavr); 

        if ($countlalistedetouslesdemandeachatavr > 0) {
            
            foreach($dblalistedetouslesdemandeachatavr as $key => $value){
                $code_membre_acheteur = $value->code_membre_acheteur;
                $id_ar = $value->id;
                $reference_ar = $value->reference_avr;
                $date_achat_ar = $value->date_achat;
                $mode_paiement = $value->mode_paiement;
                $montant_total_avr = $value->montant_total_avr_produit_achat;                
                $nometprenomsar = "";
                $nom_membrear= "";
                $prenom_membrear  = "";
                $raison_socialear = "";

                if (substr($code_membre_acheteur,-1) == "P"){
                    $dbtselect = "SELECT eu_membre.nom_membre,
                                         eu_membre.prenom_membre
                                  FROM eu_avr_achat, eu_membre
                                  WHERE eu_avr_achat.code_membre_acheteur = eu_membre.code_membre
                                  AND eu_avr_achat.code_membre_acheteur = '$code_membre_acheteur'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbtselect);
                    $dbavrpp = $stmt->fetchAll();
                    $nom_membrear = $dbavrpp[0]->nom_membre;
                    $prenom_membrear = $dbavrpp[0]->prenom_membre;
                    $nometprenomsar = $nom_membrear.' '.$prenom_membrear;

                }

                if (substr($code_membre_acheteur,-1) == "M"){
                    $dbtselect = "SELECT eu_membre_morale.raison_sociale
                                  FROM eu_avr_achat, eu_membre_morale
                                  WHERE eu_avr_achat.code_membre_acheteur =  eu_membre_morale.code_membre_morale
                                  AND eu_avr_achat.code_membre_acheteur = '$code_membre_acheteur'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbtselect);
                    $dbavrpm = $stmt->fetchAll();
                    $raison_socialear = $dbavrpm[0]->raison_sociale;
                }

                $arraylistdesavr [] = array(
                    'code_membre_acheteur'=>$code_membre_acheteur,
                    'id_ar'=>$id_ar,
                    'reference_ar'=>$reference_ar,
                    'date_achat_ar'=>$date_achat_ar,
                    'mode_paiement'=>$mode_paiement,
                    'montant_total_avr'=>$montant_total_avr,
                    'nometprenomsar'=>$nometprenomsar,
                    'raison_socialear'=>$raison_socialear,
                );
               
            }
            
        }
    

        $this->view->arraylistdesavr = $arraylistdesavr;            
    }

    public function centraledachatlistedesdetailsdesavrAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $arrayavrdetail = array();           
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT eu_avr_achat.id FROM eu_avr_achat WHERE eu_avr_achat.id ='$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidarticlestockes = $stmt->fetchAll();
            if (count($dbrecherchedelidarticlestockes) == 0) {
                http_response_code(403);
                die('Désolé,mais ce produit n\'est pas encore disponible sur la plateforme ');
            }
        } 

        $dbtselect = "SELECT eu_avr_achat.code_membre_acheteur,
                             eu_avr_achat.reference_avr,
                             eu_avr_achat.date_achat,
                             eu_avr_achat.mode_paiement,
                             eu_avr_achat.montant_total_avr_produit_achat
                      FROM eu_avr_achat
                      WHERE eu_avr_achat.id = $id";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesdemandeachatavrdetails = $stmt->fetchAll();
        $countlalistedetouslesdemandeachatavrdetails = count($dblalistedetouslesdemandeachatavrdetails);


        
        if ($countlalistedetouslesdemandeachatavrdetails > 0) {
            
            foreach($dblalistedetouslesdemandeachatavrdetails as $key => $value){
                $code_membre_acheteur = $value->code_membre_acheteur;
                $reference_ar = $value->reference_avr;
                $date_achat_ar = $value->date_achat;
                $mode_paiement = $value->mode_paiement;
                $montant_total_avr = $value->montant_total_avr_produit_achat;     
                $nometprenomsar = "";
                $nom_membrear= "";
                $prenom_membrear  = "";
                $raison_socialear = "";

                if (substr($code_membre_acheteur,-1) == "P"){
                    $dbtselect = "SELECT eu_membre.nom_membre,
                                         eu_membre.prenom_membre
                                  FROM eu_avr_achat, eu_membre
                                  WHERE eu_avr_achat.code_membre_acheteur = eu_membre.code_membre
                                  AND eu_avr_achat.code_membre_acheteur = '$code_membre_acheteur'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbtselect);
                    $dbavrpp = $stmt->fetchAll();
                    $nom_membrear = $dbavrpp[0]->nom_membre;
                    $prenom_membrear = $dbavrpp[0]->prenom_membre;
                    $nometprenomsar = $nom_membrear.' '.$prenom_membrear;

                }

                if (substr($code_membre_acheteur,-1) == "M"){
                    $dbtselect = "SELECT eu_membre_morale.raison_sociale
                                  FROM eu_avr_achat, eu_membre_morale
                                  WHERE eu_avr_achat.code_membre_acheteur =  eu_membre_morale.code_membre_morale
                                  AND eu_avr_achat.code_membre_acheteur = '$code_membre_acheteur'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbtselect);
                    $dbavrpm = $stmt->fetchAll();
                    $raison_socialear = $dbavrpm[0]->raison_sociale;
                }

                $arrayavrdetail [] = array(
                    'code_membre_acheteur'=>$code_membre_acheteur,
                    'reference_ar'=>$reference_ar,
                    'date_achat_ar'=>$date_achat_ar,
                    'mode_paiement'=>$mode_paiement,
                    'montant_total_avr'=>$montant_total_avr,
                    'nometprenomsar'=>$nometprenomsar,
                    'raison_socialear'=>$raison_socialear,
                );
               
            }
        }

        $dbtselect = "SELECT eu_avr_detail_achat.*, eu_membre_morale.raison_sociale
                      FROM eu_avr_detail_achat, eu_membre_morale
                      WHERE eu_avr_detail_achat.code_membre_fournisseur = eu_membre_morale.code_membre_morale
                      AND eu_avr_detail_achat.id = $id";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesdetailsdemandeachatavr = $stmt->fetchAll();
        $countlalistedetouslesdetailsdemandeachatavr = count($dblalistedetouslesdetailsdemandeachatavr);         

        $this->view->lalistedetouslesdetailsdemandeachatavr = $dblalistedetouslesdetailsdemandeachatavr; 
        $this->view->arrayavrdetail =  $arrayavrdetail; 
        
        
        
    }

    public function interfaceavrgrandpublicAction () {

        /***
         * Interface unique qui recuperera la liste de tous les fournisseurs 
         * Pour chaque fournisseurs, la liste des produits (details est affichés)
         * Pour chaque produits, il y aura le boutton Acheter ou Se plaindre
         * 
         */
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbtselect = "SELECT DISTINCT(eu_article_stockes.code_membre_morale),
                             eu_membre_morale.raison_sociale
                      FROM eu_article_stockes,eu_membre_morale
                      WHERE eu_article_stockes.code_membre_morale = eu_membre_morale.code_membre_morale
                      AND eu_article_stockes.id_eli is not null";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesfournisseursetlesdetailsdeleurproduitsdevente = $stmt->fetchAll();

        $tab = [];

        foreach ($dblalistedetouslesfournisseursetlesdetailsdeleurproduitsdevente as $key => $value) {
            $code_membre = $value->code_membre_morale;
            $dbtselect = "SELECT DISTINCT(eu_article_stockes.designation),
                                          eu_article_stockes.reference,
                                          eu_article_stockes.code_membre_morale,
                                          eu_article_stockes.categorie,
                                          eu_article_stockes.type,
                                          eu_article_stockes.prix,
                                          eu_article_stockes.qte_solde
                          FROM eu_article_stockes
                          WHERE eu_article_stockes.code_membre_morale = '$code_membre'
                          AND eu_article_stockes.id_eli is not null
                          AND eu_article_stockes.qte_solde > 0";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtselect);
            $dbdesignationproduit = $stmt->fetchAll();


            $tab[$key]['list'] = array(
                'entreprise' =>$value,
                'articles'=>$dbdesignationproduit
            );

        }
        $count = 0;

        if (isset($_SESSION['panier_produit_avr'])){
           $count = count($_SESSION['panier_produit_avr']);
        }

        $this->view->lalistedetouslesfournisseursaveclesdetailsdeleurproduits = $tab;        
        $this->view->count = $count;        
        
        

        /*unset($_SESSION['panier_produit_avr']);*/

    }

    public function interfaceavrgrandpublicplainteAction () {

    }

    public function interfaceavrautresproduitsAction () {
        /***
         * 
         * 
         * 
         * 
         */


        $db = Zend_Db_Table::getDefaultAdapter();
        $created = Zend_Date::now();
        $date_demande = $created->toString('yyyy-MM-dd HH:mm:ss');
        $request = $this->getRequest();


        if ($request->isPost()) {
            $nomduproduitinexistantavr = $_POST['avr-produit-inexistant-name'];
            $caracteristiqueduproduit = $_POST['avr-produit-inexistant-caracteristique'];
            $quantiteduproduitinexistantdemande = $_POST['avr-produit-inexistant-quantite'];
            $sessionmembre = new Zend_Session_Namespace('membre');
            $codemembreacheteur = $sessionmembre->code_membre;
            /***Controle des données qui sont envoyé par la requête post */
            if($nomduproduitinexistantavr == "") {
                $validationdemandeerrors['empty_nomduproduitinexistantavr'] = "Echec d'enregistrement:Le nom du produit inexistant demandé ne doit pas être vide";
            }
    
            if(!isset($nomduproduitinexistantavr)){
                $validationdemandeerrors['exist_nomduproduitinexistantavr'] = "Echec d'enregistrement:Le nom du produit inexistant demandé est invalide";
            }

            if($nomduproduitinexistantavr == "") {
                $validationdemandeerrors['empty_caracteristiqueduproduit'] = "Echec d'enregistrement:La caractéristique du produit inexistant demandé ne doit pas être vide";
            }
    
            if(!isset($nomduproduitinexistantavr)){
                $validationdemandeerrors['exist_caracteristiqueduproduit'] = "Echec d'enregistrement:La caractéristique du produit inexistant demandé est invalide";
            }

            if($quantiteduproduitinexistantdemande == "") {
                $validationdemandeerrors['empty_quantiteduproduitinexistantdemande'] = "Echec d'enregistrement:La quantité du produit inexistant demandé ne doit pas être vide";
            }
    
            if(!isset($quantiteduproduitinexistantdemande)){
                $validationdemandeerrors['exist_quantiteduproduitinexistantdemande'] = "Echec d'enregistrement:La quantité du produit inexistant demandé est invalide";
            }

            if($quantiteduproduitinexistantdemande != ""){

                if(!filter_var($quantiteduproduitinexistantdemande, FILTER_VALIDATE_REGEXP,
                 array("options"=>array("regexp"=>"#[0-9]#")))){
                 $validationerrors['verif_quantiteduproduitinexistantdemande'] = "Erreur au niveau de la quantité du produit inexistant demandé:la quantité du produit demandé est invalide ";
                }

                if($quantiteduproduitinexistantdemande == 0){
                 $validationerrors['validite_quantiteduproduitinexistantdemande'] = "Erreur au niveau de la quantité du produit inexistant demandé:la quantité du produit demandé ne doit pas être égale à 0 ";       
                }
            }


            $dbtselect = "SELECT *
                          FROM  eu_avr_achat_autre
                          WHERE eu_avr_achat_autre.nom_produit ='$nomduproduitinexistantavr'
                          AND eu_avr_achat_autre.code_membre_acheteur = '$codemembreacheteur'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtselect);
            $dbrecherchededoublonavr = $stmt->fetchAll();

            if (count($dbrecherchededoublonavr) > 0){
                $validationerrors['count_avr_achat_autre'] = "Cette demande a été dejà enregistré";        
            }

            if (count($dbrecherchededoublonavr) == 0){
                $dbtselect = "SELECT *
                              FROM  eu_avr_achat_autre
                              WHERE eu_avr_achat_autre.nom_produit ='$nomduproduitinexistantavr'
                              AND eu_avr_achat_autre.code_membre_acheteur = '$codemembreacheteur'
                              AND eu_avr_achat_autre.qte_demande = '$quantiteduproduitinexistantdemande'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $dbrecherchededoublonavrsecondlevel = $stmt->fetchAll();

                if (count($dbrecherchededoublonavrsecondlevel) > 0){
                  $validationerrors['count_avr_achat_autre'] = "Cette demande a été dejà enregistré";                          
                }
            }
            if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
            } 

            if(empty($validationerrors)){

                /***Control de doublons */

                $dbfinsert = "INSERT INTO eu_avr_achat_autre(
                    nom_produit,
                    code_membre_acheteur,
                    date_demande,
                    qte_demande,
                    caracteristique_produit) VALUES (
                   '$nomduproduitinexistantavr',
                   '$codemembreacheteur',
                   '$date_demande',
                   '$quantiteduproduitinexistantdemande',
                   '$caracteristiqueduproduit'
                   )";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfinsert);
                $validationsuccess['success_message'] = "L'enregistrement de votre demande a été effectué avec succes";
                $_SESSION['validationsuccess'] = $validationsuccess;
            }
        }

    }

    public function interfacevalidationpanierAction () {
        $count = array();
        $uniquekeylist = array();
        $newtab = array();
        
        if (isset($_SESSION['panier_produit_avr'])){
            $listdetousleselementdupanier = $_SESSION['panier_produit_avr'];
            $count[] = array_count_values(array_map(function($val){return $val['designation_produit'];}, $listdetousleselementdupanier));
            $uniquekeylist = array_unique($listdetousleselementdupanier, SORT_REGULAR);
            $montant_total = 0;


        foreach($uniquekeylist as $key => $value){
             $code_membre_fournisseur = $value['code_membre_fournisseur'];
             $code_membre_fournisseur = trim($code_membre_fournisseur);
             $designation_produit = $value['designation_produit'];
             $reference_produit = $value['reference_produit'];
             $terminal_echange_produit = $value['terminal_echange_produit'];
             $quantite_produit = $value['quantite_produit'];
             $prix_produit = $value['prix_produit'];
             $type_produit = $value['type_produit'];
             $code_membre_acheteur = $value['code_membre_acheteur'];
             $count_designation = $count[0]["$designation_produit"];

             $parseintcount_designation = intval($count_designation);
             $parseintprix_produit = intval($prix_produit);

             $total = $parseintcount_designation *  $parseintprix_produit;
            $montant_total = $montant_total + $total;
             

             $newtab[] = array(
                 'code_membre_fournisseur'=>$code_membre_fournisseur,
                 'designation_produit'=>$designation_produit,
                 'reference_produit'=>$reference_produit,
                 'terminal_echange_produit'=>$terminal_echange_produit,
                 'quantite_disponible_produit'=>$quantite_produit,
                 'prix_produit'=>$prix_produit,
                 'type_produit'=>$type_produit,
                 'code_membre_acheteur'=>$code_membre_acheteur,
                 'quantite_article'=>$count_designation,
                 'total'=> $total
             );
        }

        $array_montant_total_avr = array(
            'montant_total_avr'=>$montant_total
        );
         $countvalue = count($newtab);

        
        $this->view->tableaupanier = $newtab;
        $this->view->montanttotal = $montant_total;

        $request = $this->getRequest();

        if ($request->isPost()) {
           $created = Zend_Date::now();
           $date_avr_produit = $created->toString('yyyy-MM-dd HH:mm:ss');
           $db = Zend_Db_Table::getDefaultAdapter();
         

           if ($_POST['produit_avr_achat_recap_designation_produit'] > 0) {
               $ref_avr_produit= substr(md5(uniqid(rand(), true)), 0, 8);
               $real_ref_avr_produit  = strtoupper('AR-'.$ref_avr_produit);
               $code_membre_acheteur = $_POST['produit_avr_achat_recap_code_membre_acheteur'];
               $moyen_paiement_ar_achat = $_POST['moyen_paiement_ar_achat'];
               $montant_total_avr_produit_achat = $_POST['montant_total_avr_produit_achat'];
               $verifmontant_total_avr_produit_achat = 0;
            
               for ($i = 0; $i< count($_POST['produit_avr_achat_recap_designation_produit']); $i++) {
                   $prix_total = $_POST['produit_avr_achat_recap_prix_total'][$i];
                   $verifmontant_total_avr_produit_achat = $verifmontant_total_avr_produit_achat + $prix_total;
               }
               if ($montant_total_avr_produit_achat != $verifmontant_total_avr_produit_achat) {
                   $validationerrors['verif_montant_total_avr_produit_achat'] = "Le montant total de votre avr est invalide car ne correspondant pas à la somme des prix totaux des produits de votre panier!";
               }
               if (!isset($code_membre_acheteur)){
                 $validationerrors['exist_code_membre_acheteur'] = "Echec d'enregistrement:Le code membre de l'acheteur est inexistant";

               }

               if (!isset($moyen_paiement_ar_achat)){
                 $validationerrors['exist_moyen_paiement_ar_achat'] = "Echec d'enregistrement:Le moyen de paiement est inexistant";
                }

               if ($code_membre_acheteur == "" || empty($code_membre_acheteur)){
                 $validationerrors['empty_code_membre_acheteur'] = "Echec d'enregistrement:Le code membre de l'acheteur ne doit pas être vide";
               }
    
               if ($moyen_paiement_ar_achat == "" || empty($moyen_paiement_ar_achat)){
                 $validationerrors['empty_moyen_paiement_ar_achat'] = "Echec d'enregistrement:Le moyen de paiement ne doit pas être vide";
               }

               if ($moyen_paiement_ar_achat != ""){
                   if(!in_array($moyen_paiement_ar_achat, array('BAn','BAi', 'OPi'))){
                    $validationerrors['valid_moyen_paiement_ar_achat'] = "Echec d'enregistrement:Le moyen de paiement choisit est invalide";
                   }
               }
               if ($code_membre_acheteur != ""){
                 if(!in_array(substr($code_membre_acheteur,-1), array('M', 'P') ) || strlen($code_membre_acheteur) != 20){
                    $validationerrors['valid_code_membre_acheteur'] = "Echec d'enregistrement:Le code membre de l'acheteur est invalide";
                 }
                } 
               
               for ($i = 0; $i< count($_POST['produit_avr_achat_recap_designation_produit']); $i++) {
                   $designation_produit = $_POST['produit_avr_achat_recap_designation_produit'][$i];
                   $quantite_achat = $_POST['produit_avr_achat_recap_quantite_achat'][$i];
                   $quantite_disponible_produit = $_POST['produit_avr_achat_recap_quantite_disponible_produit'][$i];
                   $prix_unitaire = $_POST['produit_avr_achat_recap_prix_unitaire'][$i];
                   $prix_total = $_POST['produit_avr_achat_recap_prix_total'][$i];
                   $code_membre_fournisseur = $_POST['produit_avr_achat_recap_code_membre_fournisseur'][$i];
                   $reference_produit = $_POST['produit_avr_achat_recap_reference_produit'][$i];
                   $terminal_echange_produit = $_POST['produit_avr_achat_recap_terminal_echange_produit'][$i];
                   $type_produit = $_POST['produit_avr_achat_recap_type_produit'][$i];
 
                   $parseqteachat = intval($quantite_achat);
                   $parsequantite_disponible_produit = intval($quantite_disponible_produit);
                   $parseprixunitaire = intval($prix_unitaire);
                   $parseoldprixtotal = $parseqteachat * $parseprixunitaire;
                   $parseprixtotal = intval($prix_total);

                   $dbtselect = "SELECT eu_article_stockes.id_article_stockes

                                 FROM eu_article_stockes
                                 WHERE eu_article_stockes.designation = '$designation_produit'
                                 AND eu_article_stockes.qte_solde = $quantite_disponible_produit
                                 AND eu_article_stockes.code_membre_morale = '$code_membre_fournisseur'
                                 AND eu_article_stockes.categorie = '$terminal_echange_produit'
                                 AND eu_article_stockes.type = '$type_produit'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbtselect);
                    $dbcheckarticlevalidation = $stmt->fetchAll(); 
                    $countdbcheckarticlevalidation = count($dbcheckarticlevalidation);

                   if (!isset($designation_produit) || $designation_produit == "" ){
                      $validationerrors['empty_designation_produit'] = "Echec d'enregistrement de la designation du produit:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }

                   if (!isset($quantite_achat) || $quantite_achat == "" ){
                    $validationerrors['empty_quantite_achat'] = "Echec d'enregistrement de la quantité d'achat:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }

                   
                   if (!isset($quantite_disponible_produit) || $quantite_disponible_produit == "" ){
                    $validationerrors['empty_quantite_disponible_produit'] = "Echec d'enregistrement de la quantité disponible du produit:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }

                   if (!isset($prix_unitaire) || $prix_unitaire == "" ){
                    $validationerrors['empty_prix_unitaire'] = "Echec d'enregistrement du prix unitaire du produit:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }

                   if (!isset($prix_total) || $prix_total == "" ){
                    $validationerrors['empty_prix_total'] = "Echec d'enregistrement du prix total du produit:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }

                   if (!isset($code_membre_fournisseur) || $code_membre_fournisseur == "" ){
                    $validationerrors['empty_code_membre_fournisseur'] = "Echec d'enregistrement du code membre du fournisseur:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }

                   if ($code_membre_fournisseur != ""){
                    if(!in_array(substr($code_membre_fournisseur,-1), array('M') ) || strlen($code_membre_fournisseur) != 20){
                       $validationerrors['valid_code_membre_fournisseur'] = "Echec d'enregistrement:Le code membre du fournisseur est invalide";
                    }
                   } 

                   if (!isset($reference_produit) || $reference_produit == "" ){
                    $validationerrors['empty_reference_produit'] = "Echec d'enregistrement de la référence du produit:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }

                   if (!isset($terminal_echange_produit) || $terminal_echange_produit == "" ){
                    $validationerrors['empty_terminal_echange_produit'] = "Echec d'enregistrement du TE:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }

                   if (!isset($type_produit) || $type_produit == "" ){
                    $validationerrors['empty_type_produit'] = "Echec d'enregistrement du type du produit:Vous tentez d'effectuer une action qui n'est pas autorisée";
                   }
 
                   if ($parseqteachat < 0) {
                       $validationerrors['validite_quantite_avr_acheteur'] = "La quantité d'achat du produit: $designation_produit est invalide";
                   }
 
                   if ($parseqteachat = 0) {
                       $validationerrors['empty_quantite_avr_acheteur'] = "Vous devez renseigner la quantité d'achat du produit: $designation_produit";
                   }
 
                   if ($parseqteachat > $parsequantite_disponible_produit) {
                       $validationerrors['comparaison_quantite_avr_acheteur'] = "la quantité du produit: $designation_produit demandée est supérieur à la quantité disponible ";
                   }
 
                   if ($parseoldprixtotal != $parseprixtotal) {
                       $validationerrors['comparaison_du_prix_total'] = "le prix total du produit: $designation_produit est invalide ";
                   }

                   if ($countdbcheckarticlevalidation == 0){
                      $validationerrors['valid_recording'] = "L'enregistrement de la demande d'achat pour le produit: $designation_produit est invalide";

                   }
               }
           }
           if(!empty($validationerrors)){
              $_SESSION['validationerrors'] = $validationerrors;
           }
           if (empty($validationerrors)){
                $dbfinsert = "INSERT INTO eu_avr_achat(
                                      reference_avr,
                                      code_membre_acheteur,
                                      date_achat,
                                      mode_paiement,
                                      montant_total_avr_produit_achat
                              ) VALUES (
                                '$real_ref_avr_produit',
                                '$code_membre_acheteur',
                                '$date_avr_produit',
                                '$moyen_paiement_ar_achat',
                                '$montant_total_avr_produit_achat')";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfinsert);

            $dbselect = "SELECT * FROM eu_avr_achat WHERE reference_avr='$real_ref_avr_produit'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbsearchlineavr = $stmt->fetchAll();
            $dbcountsearchlineavr = count($dbsearchlineavr);

            if($dbcountsearchlineavr != 0){
                $dbidsearchlineavrid = $dbsearchlineavr[0]->id;
              for ($i = 0; $i< count($_POST['produit_avr_achat_recap_designation_produit']); $i++){
                $designation_produit = $_POST['produit_avr_achat_recap_designation_produit'][$i];
                $quantite_achat = $_POST['produit_avr_achat_recap_quantite_achat'][$i];
                $quantite_disponible_produit = $_POST['produit_avr_achat_recap_quantite_disponible_produit'][$i];
                $prix_unitaire = $_POST['produit_avr_achat_recap_prix_unitaire'][$i];
                $prix_total = $_POST['produit_avr_achat_recap_prix_total'][$i];
                $code_membre_fournisseur = $_POST['produit_avr_achat_recap_code_membre_fournisseur'][$i];
                $reference_produit = $_POST['produit_avr_achat_recap_reference_produit'][$i];
                $terminal_echange_produit = $_POST['produit_avr_achat_recap_terminal_echange_produit'][$i];
                $type_produit = $_POST['produit_avr_achat_recap_type_produit'][$i];

                $parseqteachat = intval($quantite_achat);
                $parsequantite_disponible_produit = intval($quantite_disponible_produit);
                $parseprixunitaire = intval($prix_unitaire);
                $parseoldprixtotal = $parseqteachat * $parseprixunitaire;
                $parseprixtotal = intval($prix_total);

                $dbfinsert = "INSERT INTO eu_avr_detail_achat(
                                          code_membre_fournisseur,
                                          designation_produit,
                                          reference_produit,
                                          te_fournisseur,
                                          qte_achat,
                                          id,
                                          qte_disponible,
                                          prix_unitaire_vente,
                                          prix_total_achat) VALUES (
                                   '$code_membre_fournisseur',
                                   '$designation_produit',
                                   '$reference_produit',
                                   '$terminal_echange_produit',
                                   '$quantite_achat',
                                   '$dbidsearchlineavrid',
                                   '$quantite_disponible_produit',
                                   '$prix_unitaire',
                                   '$prix_total')";
                   $db->setFetchMode(Zend_Db::FETCH_OBJ);
                   $stmt = $db->query($dbfinsert);
                }
             } 
             unset($_SESSION['panier_produit_avr']);
             $this->_redirect("/achatventereciproque/interfaceavrgrandpublic");
            }
          }         
        }       
    }




    public function listedesautresproduitsavrAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbtselect = "SELECT eu_avr_achat_autre.nom_produit,
                             eu_avr_achat_autre.code_membre_acheteur,
                             eu_avr_achat_autre.date_demande,
                             eu_avr_achat_autre.qte_demande,
                             eu_avr_achat_autre.id

                      FROM eu_avr_achat_autre";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesautresproduitsavrnonlistes = $stmt->fetchAll();
        $countlalistedetouslesautresproduitsavrnonlistes = count($dblalistedetouslesautresproduitsavrnonlistes);    
        
        $this->view->lalistedetouslesautresproduitsavrnonlistes = $dblalistedetouslesautresproduitsavrnonlistes;    
        $this->view->countlalistedetouslesautresproduitsavrnonlistes = $countlalistedetouslesautresproduitsavrnonlistes;     
        $this->view->tabletri = 1;
    }

    public function interfacelistedesdetailsdesautresproduitsavrAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        

        $dbtselect = "SELECT eu_avr_achat_autre.nom_produit,
                             eu_avr_achat_autre.code_membre_acheteur,
                             eu_avr_achat_autre.date_demande,
                             eu_avr_achat_autre.qte_demande,
                             eu_avr_achat_autre.caracteristique_produit,
                             eu_membre.nom_membre,
                             eu_membre.prenom_membre

                      FROM eu_avr_achat_autre, eu_membre
                      WHERE eu_avr_achat_autre.code_membre_acheteur = eu_membre.code_membre
                      AND eu_avr_achat_autre.id = '$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedesdetailstouslesautresproduitsavrnonlistes = $stmt->fetchAll();
        $this->view->lalistedesdetailstouslesautresproduitsavrnonlistes = $dblalistedesdetailstouslesautresproduitsavrnonlistes;    

    }

    public function ajaxsessionpanierAction () {
        $created = Zend_Date::now();
        $db = Zend_Db_Table::getDefaultAdapter();

        session_start();

        $resultjson = array();
        $erreurjson = array();


        if($_SERVER['REQUEST_METHOD'] != 'POST'){
              http_response_code(403);
              die();
        }

        $codemembrefournisseur = $_POST['code_membre_fournisseur'];
        $designation_produit = $_POST['designation_produit'];
        $reference_produit = $_POST['reference_produit'];
        $terminal_echange_produit = $_POST['terminal_echange_produit'];
        $quantite_produit = $_POST['quantite_produit'];
        $prix_produit = $_POST['prix_produit'];
        $type_produit = $_POST['type_produit'];
        $code_membre_acheteur = $_POST['code_membre_acheteur'];
        

        $panier = array(
            'code_membre_fournisseur'=>$codemembrefournisseur,
            'designation_produit'=>$designation_produit,
            'reference_produit'=>$reference_produit,
            'terminal_echange_produit'=>$terminal_echange_produit,
            'quantite_produit'=>$quantite_produit,
            'prix_produit'=>$prix_produit,
            'type_produit'=>$type_produit,
            'code_membre_acheteur'=>$code_membre_acheteur,
        );

        
        $_SESSION['panier_produit_avr'][] = $panier;
        $count[] = array_count_values(array_map(function($val){return $val['designation_produit'];}, $_SESSION['panier_produit_avr']));
        $count = count($_SESSION['panier_produit_avr']);
        $resultjson = array(
            'update'=>'Le produit a été ajouter au panier avec succès',
            'panier'=>$_SESSION,
            'count'=>$count,
            'type_avr'=>'Grand Public'
        );
        header('Content-type:application/json');
        die(json_encode($resultjson));
        
    }


    public function interfaceavrgrandpublicdetaildesproduitsAction () {

        /****
         * Recuperation du parametre ELI
         * 
         */
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        
        $dbtselect = "SELECT 
                        eu_detail_eli.libelle_produit,
                        eu_detail_eli.id_eli,
                        eu_detail_eli.id_detail_eli,
                        eu_detail_eli.qte_vente,
                        eu_detail_eli.prix_vente,
                        eu_membre_morale.raison_sociale
                      FROM eu_eli,eu_detail_eli, eu_membre_morale
                      WHERE eu_eli.id_eli = eu_detail_eli.id_eli
                      AND eu_eli.code_membre = eu_membre_morale.code_membre_morale
                      AND eu_detail_eli.id_detail_eli = $id
                      AND eu_eli.valider >= 4
                      AND eu_eli.rejeter = 0";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedesdetailsdunproduit = $stmt->fetchAll();

        $this->view->lalistedesdetailsdunproduit = $dblalistedesdetailsdunproduit;
        

    }


    public function erasekeysessionpanierAction () {
        $this->_helper->layout->disableLayout();
        $resulterasekeysessionjson = array();
        session_start();
        
        
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        $keydeletesessionpanierproduit = $_POST['valkeydeletesession'];

        unset($_SESSION['panier_produit_avr'][$keydeletesessionpanierproduit]);
        header('Content-type:application/json');

        
        $resulterasekeysessionjson = array(
            'update'=>'Le produit a été retiré du panier avec succès',
        );
        die(json_encode($resulterasekeysessionjson));
        
    }



}