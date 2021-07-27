<?php

class ProcedureachatController extends Zend_Controller_Action{


    public function touslesmenudelaprocedureachatAction () {
        
    }

    public function lalistedesdemandeachatatransmetreaugerantparlatechnopoleapresvisadubondecommandeAction () {

    }

    public function lalistedesproformaatransmetreaugerantparlatechnopoleapresvisadubondecommandeAction () {

    }

    public function lalistedesprocesverbaleatransmetreaugerantparlatechnopoleapresvisadubondecommandeAction () {

    }

   

    public function lalistedesbonsdecommandesaviserparlatechnopolefiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();        
        
        $dbselect = "SELECT
                         eu_bon_commande.id_bon_commande, 
                         eu_bon_commande.reference_bon_commande,
                         eu_bon_commande.montant_bon_commande,
                         eu_bon_commande.date_bon_commande
                     FROM eu_bon_commande
                     WHERE visatechfiliere == ''";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeaviserparlatechnopole = $stmt->fetchAll();
        $this->view->searchbondecommandeaviserparlatechnopole = $dbsearchbondecommandeaviserparlatechnopole;
    }


    public function listedesbonsdecommandesalivrerAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $dbverifselect = "SELECT *
                          FROM eu_bon_commande
                          WHERE eu_bon_commande.visatechfiliere = 'ok'
                          AND eu_bon_commande.visagerant = 'ok'
                          AND eu_bon_commande.valider_down = 2
                          AND eu_bon_commande.valider_up = 2
                          AND eu_bon_commande.id_bon_livraison_procedure IS NULL";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbrecherchedesbondecommandequisontalivrer = $stmt->fetchAll();
        $this->view->recherchedesbondecommandequisontalivrer = $dbrecherchedesbondecommandequisontalivrer;
    }

    public function listedesbonsdecommandesdejalivrerAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $dbverifselect = "SELECT *
                          FROM eu_bon_commande
                          WHERE eu_bon_commande.visatechfiliere = 'ok'
                          AND eu_bon_commande.visagerant = 'ok'
                          AND eu_bon_commande.valider_down = 2
                          AND eu_bon_commande.valider_up = 2
                          AND eu_bon_commande.id_bon_livraison_procedure IS NOT NULL";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbrecherchedesbondecommandequisontalivrer = $stmt->fetchAll();
        $this->view->recherchedesbondecommandequisontalivrer = $dbrecherchedesbondecommandequisontalivrer;
    }


    public function listedesbonsdelivraisonsAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $dbverifselect = "SELECT *
                          FROM eu_bon_livraison_procedure";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistingdetouslesbonsdelivraisons = $stmt->fetchAll();
        $this->view->listingdetouslesbonsdelivraisons = $dblistingdetouslesbonsdelivraisons;
        
    }


    public function etablissementdubondelivraisonenfonctiondubondecommandeAction () {

        /***
         * Bon de commande ayant un visa du gérant et
         */
        $db = Zend_Db_Table::getDefaultAdapter();
        $request = $this->getRequest();
        
        $id = (int)$this->_request->getParam('id');


       if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    
            $dbverifselect = "SELECT *
                              FROM eu_bon_commande
                              WHERE eu_bon_commande.id_bon_commande = '$id'
                              AND eu_bon_commande.visatechfiliere = 'ok'
                              AND eu_bon_commande.visagerant = 'ok'
                              AND eu_bon_commande.valider_down = 2
                              AND eu_bon_commande.valider_up = 2";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifselect);
            $dbrecherchedubondecommandeenfonctiondeid = $stmt->fetchAll();
           if(count($dbrecherchedubondecommandeenfonctiondeid) == 0){
             http_response_code(403);
             die('Ce bon de commande n\'a pas encore été enrégistré');
           }

           if(count($dbrecherchedubondecommandeenfonctiondeid) != 0){
            $dbverifselect = "SELECT *
                              FROM eu_detail_bon_commande as dpp
                              WHERE dpp.id_bon_commande = '$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifselect);
            $dbdetaildubondecommande = $stmt->fetchAll();    
            $this->view->detaildubondecommande = $dbdetaildubondecommande;
            $this->view->recherchedubondecommandeenfonctiondeid = $dbrecherchedubondecommandeenfonctiondeid;    
           }

        }



        if($request->isPost()){
            $ref_bon_livraison = substr(md5(uniqid(rand(),true)),0,8);
            $real_ref_bon_livraison = strtoupper('LIVRAISON-'.$ref_bon_livraison);
            $created = Zend_Date::now();        
            $date_etablissement_bon_livraison = $created->toString('yyyy-MM-dd HH:mm:ss');
            $libelle_bon_livraison = $_POST['libelle_bon_livraison'];
            $montant_bon_livraison = $_POST['montant_bon_livraison'];
            
            if($libelle_bon_livraison == "") {
                $validationdemandeerrors['empty_libelle_bon_livraison'] = "Echec d'enregistrement:Le libellé du bon de livraison ne doit pas être vide";
            }
    
            if(!isset($libelle_bon_livraison)){
                $validationdemandeerrors['exist_libelle_bon_livraison'] = "Echec d'enregistrement:Le libellé du bon de livraison est inexistant";
            }
            
            if($montant_bon_livraison == "") {
                $validationdemandeerrors['empty_montant_bon_livraison'] = "Echec d'enregistrement:Le montant du bon de livraison ne doit pas être vide";
            }
    
            if(!isset($montant_bon_livraison)){
                $validationdemandeerrors['exist_montant_bon_livraison'] = "Echec d'enregistrement:Le montant du bon de livraison est inexistant";
            }

            for ($i = 0; $i< count($_POST['ref_article_bon_livraison']); $i++) {
                $ref_article_bon_livraison  = $_POST['ref_article_bon_livraison'][$i];
                $designation_article_bon_livraison = $_POST['designation_article_bon_livraison'][$i];
                $qte_commande_bon_livraison = $_POST['qte_commande_bon_livraison'][$i];
                $qte_livraison_bon_livraison = $_POST['qte_livraison_bon_livraison'][$i];
                $qte_restant_bon_livraison = $_POST['qte_restant_bon_livraison'][$i];
                $observation_bon_livraison = $_POST['observation_bon_livraison'][$i];

                if ($ref_article_bon_livraison == "") {
                    $validationdemandeerrors['empty_ref_article_bon_livraison'] = "Echec d'enregistrement:La référence de l'article du bon de livraison ne doit pas être vide";
                }
        
                if (!isset($ref_article_bon_livraison)) {
                    $validationdemandeerrors['exist_ref_article_bon_livraison'] = "Echec d'enregistrement:La référence de l'article du bon de livraison est inexistant";
                }

                if ($designation_article_bon_livraison == "") {
                    $validationdemandeerrors['empty_designation_article_bon_livraison'] = "Echec d'enregistrement:La désignation de l'article du bon de livraison ne doit pas être vide";
                }
        
                if (!isset($designation_article_bon_livraison)) {
                    $validationdemandeerrors['exist_designation_article_bon_livraison'] = "Echec d'enregistrement:La désignation de l'article du bon de livraison est inexistant";
                }

                if ($qte_commande_bon_livraison == "") {
                    $validationdemandeerrors['empty_qte_commande_bon_livraison'] = "Echec d'enregistrement:La quantité commandée du bon de livraison ne doit pas être vide";
                }
        
                if (!isset($qte_commande_bon_livraison)) {
                    $validationdemandeerrors['exist_qte_commande_bon_livraison'] = "Echec d'enregistrement:La quantité commandée du bon de livraison est inexistant";
                }

                if ($qte_livraison_bon_livraison == "") {
                    $validationdemandeerrors['empty_qte_livraison_bon_livraison'] = "Echec d'enregistrement:La quantité livrée du bon de livraison ne doit pas être vide";
                }
        
                if (!isset($qte_livraison_bon_livraison)) {
                    $validationdemandeerrors['exist_qte_livraison_bon_livraison'] = "Echec d'enregistrement:La quantité livrée du bon de livraison est inexistant";
                }

                if ($qte_restant_bon_livraison == "") {
                    $validationdemandeerrors['empty_qte_restant_bon_livraison'] = "Echec d'enregistrement:La quantité restant à livrer du bon de livraison ne doit pas être vide";
                }
        
                if (!isset($qte_restant_bon_livraison)) {
                    $validationdemandeerrors['exist_qte_restant_bon_livraison'] = "Echec d'enregistrement:La quantité restant à livrer du bon de livraison est inexistant";
                }

                if (!isset($observation_bon_livraison)) {
                    $validationdemandeerrors['exist_observation_bon_livraison'] = "Echec d'enregistrement:L'observation de l'article du bon de livraison est inexistant";
                }

                $parseintqte_commande_bon_livraison = intval($qte_commande_bon_livraison);
                $parseintqte_livraison_bon_livraison = intval($qte_livraison_bon_livraison);
                $check_qte_restant_bon_livraison = $parseintqte_commande_bon_livraison - $parseintqte_livraison_bon_livraison;
                $parseqte_restant_bon_livraison = intval($qte_restant_bon_livraison);

                if ($parseqte_restant_bon_livraison  !== $check_qte_restant_bon_livraison) {
                    $validationdemandeerrors['validite_qte_restant_bon_livraison'] = "La quantité restante à livrer n'est pas exacte.Veuillez réessayer svp! ";
                }
            }
            if(!empty($validationdemandeerrors)){
                $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
            }

            if (empty($validationdemandeerrors)) {
                $dbfinsert = "INSERT INTO 
                               eu_bon_livraison_procedure(
                                reference_bon_livraison,
                                libelle_bon_livraison,
                                montant_bon_livraison,
                                date_livraison) 
                                VALUES (
                                '$real_ref_bon_livraison',
                                '$libelle_bon_livraison',
                                '$montant_bon_livraison',
                                '$date_etablissement_bon_livraison'
                                )";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfinsert);
    
    
                $dbselect = "SELECT * FROM eu_bon_livraison_procedure WHERE reference_bon_livraison='$real_ref_bon_livraison'";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbselect);
                $dbsearchbonlivraison = $stmt->fetchAll();
                $dbcountsearchbonlivraison = count($dbsearchbonlivraison);
    
                if($dbcountsearchbonlivraison != 0){
                     $dbidsearchbonlivraison = $dbsearchbonlivraison[0]->id_bon_livraison_procedure;
    
                for ($i = 0; $i< count($_POST['ref_article_bon_livraison']); $i++) {
                    $ref_article_bon_livraison  = $_POST['ref_article_bon_livraison'][$i];
                    $designation_article_bon_livraison = $_POST['designation_article_bon_livraison'][$i];
                    $qte_commande_bon_livraison = $_POST['qte_commande_bon_livraison'][$i];
                    $qte_livraison_bon_livraison = $_POST['qte_livraison_bon_livraison'][$i];
                    $qte_restant_bon_livraison = $_POST['qte_restant_bon_livraison'][$i];
                    $observation_bon_livraison = $_POST['observation_bon_livraison'][$i];
    
                        $dbfinsert = "INSERT INTO 
                        eu_detail_bon_livraison_procedure(
                          reference_article,
                          designation,
                          quantite_commande,
                          quantite_livrer,
                          quantite_restant_livrer,
                          observations,
                          id_bon_livraison_procedure) 
                         VALUES (
                         '$ref_article_bon_livraison',
                         '$designation_article_bon_livraison',
                         '$qte_commande_bon_livraison',
                         '$qte_livraison_bon_livraison',
                         '$qte_restant_bon_livraison',
                         '$observation_bon_livraison',
                         '$dbidsearchbonlivraison'
                         )";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbfinsert);
    
                        $dbtselect = "UPDATE eu_bon_commande
                                      SET id_bon_livraison_procedure ='$dbidsearchbonlivraison'
                                      WHERE id_bon_commande = $id"; 
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbtselect); 
                        $this->_redirect("/procedureachat/listedesavisenvoyerauxfournisseurspouretablissementdelafactureproforma");
                  }            
                }
              }
        }
    }


    public function lalistedesbonsdecommandesviserparlatechnopolefiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();        
        
        $dbselect = "SELECT
                         eu_bon_commande.id_bon_commande, 
                         eu_bon_commande.reference_bon_commande,
                         eu_bon_commande.montant_bon_commande,
                         eu_bon_commande.date_bon_commande
                     FROM eu_bon_commande
                     WHERE visatechfiliere = 'ok'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeviserparlatechnopole = $stmt->fetchAll();
        $this->view->searchbondecommandeviserparlatechnopole = $dbsearchbondecommandeviserparlatechnopole;
    }

    public function lalistedesbonsdecommandesaviserparlegerantAction () {
        $dbselect = "SELECT
                         eu_bon_commande.id_bon_commande, 
                         eu_bon_commande.reference_bon_commande,
                         eu_bon_commande.montant_bon_commande,
                         eu_bon_commande.date_bon_commande
                     FROM eu_bon_commande
                     WHERE visatechfiliere = 'ok'
                     AND valider_down = 1
                     AND visagerant IS NULL";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeaviserparlegerant = $stmt->fetchAll();
        $this->view->searchbondecommandeaviserparlegerant = $dbsearchbondecommandeaviserparlegerant;
    }

    public function lalistedesbonsdecommandesviserparlegerantAction () {
        $dbselect = "SELECT
                         eu_bon_commande.id_bon_commande, 
                         eu_bon_commande.reference_bon_commande,
                         eu_bon_commande.montant_bon_commande,
                         eu_bon_commande.date_bon_commande
                     FROM eu_bon_commande
                     WHERE visatechfiliere = 'ok'
                     AND valider_down = 3
                     AND visagerant = 'ok'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeviserparlegerant = $stmt->fetchAll();
        $this->view->searchbondecommandeviserparlegerant = $dbsearchbondecommandeviserparlegerant;
    }

    public function lalistedetouslesbonsdecommandesquisontemisparlefournisseurAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
		$sessionmembre = new Zend_Session_Namespace('membre');	

        $code_membre_fournisseur = $sessionmembre->code_membre;
        
        
        $dbselect = "SELECT
                         eu_bon_commande.id_bon_commande,
                         eu_bon_commande.reference_bon_commande,
                         eu_bon_commande.montant_bon_commande,
                         eu_bon_commande.date_bon_commande
                     FROM eu_bon_commande
                     WHERE code_membre_fournisseur_bon_commande ='$code_membre_fournisseur'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeenfonctiondufournisseur = $stmt->fetchAll();
        $this->view->searchbondecommandeenfonctiondufournisseur = $dbsearchbondecommandeenfonctiondufournisseur;

    }

    public function lalistedetouslesbonsdecommandesAction () {
        $db = Zend_Db_Table::getDefaultAdapter();        
        
        $dbselect = "SELECT 
                        eu_bon_commande.id_bon_commande,
                        eu_bon_commande.reference_bon_commande,
                        eu_bon_commande.montant_bon_commande,
                        eu_bon_commande.date_bon_commande
                    FROM eu_bon_commande";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommande = $stmt->fetchAll();
        $this->view->searchbondecommande = $dbsearchbondecommande;

    }

    public function lalistedetouslesbonsdecommandeavaliderparlatechnopoleapreslafiliereAction () {
        $dbselect = "SELECT
                         eu_bon_commande.id_bon_commande, 
                         eu_bon_commande.reference_bon_commande,
                         eu_bon_commande.montant_bon_commande,
                         eu_bon_commande.date_bon_commande
                     FROM eu_bon_commande
                     WHERE visatechfiliere = 'ok'
                     AND valider_down = 2";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeaviserparlatechnopoleapreslafiliere = $stmt->fetchAll();
        $this->view->searchbondecommandeaviserparlatechnopoleapreslafiliere = $dbsearchbondecommandeaviserparlatechnopoleapreslafiliere;
    }


    public function lalistedetouslesbonsdecommandeavaliderparlatechnopoleapreslegerantAction () {
        $dbselect = "SELECT
                         eu_bon_commande.id_bon_commande, 
                         eu_bon_commande.reference_bon_commande,
                         eu_bon_commande.montant_bon_commande,
                         eu_bon_commande.date_bon_commande
                     FROM eu_bon_commande
                     WHERE visatechfiliere = 'ok'
                     AND visagerant = 'ok'
                     AND valider_down = 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeaviserparlatechnopoleapreslegerant = $stmt->fetchAll();
        $this->view->searchbondecommandeaviserparlatechnopoleapreslegerant = $dbsearchbondecommandeaviserparlatechnopoleapreslegerant;
    }


    public function editiondesdetailsdubondecommandeAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');
        $dbselect = "SELECT 
                      eu_bon_commande.id_bon_commande,
                      eu_bon_commande.reference_bon_commande,
                      eu_bon_commande.montant_bon_commande,
                      eu_bon_commande.date_bon_commande,
                      eu_bon_commande.date_livraison,
                      eu_bon_commande.code_membre_fournisseur_bon_commande
                     FROM eu_bon_commande
                     WHERE eu_bon_commande.id_bon_commande ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdunbondecommandeenfonctiondufournisseur = $stmt->fetchAll();


        $dbselect = "SELECT 
                        eu_detail_bon_commande.reference_article,
                        eu_detail_bon_commande.designation_article,
                        eu_detail_bon_commande.quantite,
                        eu_detail_bon_commande.date_bon_commande
                        eu_detail_bon_commande.prix_unitaire
                     FROM eu_detail_bon_commande
                     WHERE eu_detail_bon_commande.id_bon_commande ='$id'";
                     $db->setFetchMode(Zend_Db::FETCH_OBJ);
                     $stmt = $db->query($dbselect);
                     $dbsearchdetaildubondecommandeenfonctiondufournisseur = $stmt->fetchAll();

        $this->view->searchdetaildubondecommandeenfonctiondufournisseur = $dbsearchdetaildubondecommandeenfonctiondufournisseur;
        $this->view->searchdunbondecommandeenfonctiondufournisseur = $dbsearchdunbondecommandeenfonctiondufournisseur;


    }


    public function editviserlademandeachatparagenttechnopoleoufiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');
        $code_membre_budgetavr = $_SESSION['utilisateur']['code_membre'];
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT *
                         FROM eu_forms_budget_nature
                         WHERE eu_forms_budget_nature.type_budget ='DA'
                         AND eu_forms_budget_nature.reference_type_budget='$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedebudgetpourlademandeachat = $stmt->fetchAll();
            if (count($dbrecherchedebudgetpourlademandeachat) == 0) {
                http_response_code(403);
                die('le budget n\'a pas encore établit pour cette demande d\'achat');
            }   
        }

        $dbselect = "SELECT * FROM eu_demande_achat WHERE id_demande_achat ='$id' AND rejet = 1 AND valider_down = 3 valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandeachat = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_demande_achat WHERE id_demande_achat ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandedetailachat = $stmt->fetchAll();
        
        $dbselect = "SELECT
                eu_forms_budget_nature.montant_budget,
                eu_forms_budget_nature.id,
                eu_forms_budget_nature.payer,
                eu_forms_budget_nature.date_budget
                FROM eu_forms_budget_nature, eu_demande_achat
                WHERE eu_forms_budget_nature.reference_type_budget = eu_demande_achat.id_demande_achat
                AND eu_forms_budget_nature.code_membre_budget ='$code_membre_budgetavr'
                AND eu_forms_budget_nature.type_budget ='DA'
                AND eu_forms_budget_nature.reference_type_budget='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbbudgetselonlademandeachat = $stmt->fetchAll();

        $this->view->dbbudgetselonlademandeachat = $dbbudgetselonlademandeachat;
        $this->view->entries = $dbsearchdemandeachat;
        $this->view->detailachat = $dbsearchdemandedetailachat;
    }

    public function editvaliderlademandeachatparlatechnopoleapreslafiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

        $dbselect = "SELECT * FROM eu_demande_achat WHERE id_demande_achat ='$id' AND valid_down = 4 AND visatechfiliere ='ok' AND rejet = 1 AND visagerant IS NULL AND livrer = 0";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandeachattechnopoleapreslafiliere = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_demande_achat WHERE id_demande_achat ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandedetailachattechnopoleapreslafiliere = $stmt->fetchAll();

  
        $this->view->entriestechnopoleapreslafiliere = $dbsearchdemandeachattechnopoleapreslafiliere;
        $this->view->detailachattechnopoleapreslafiliere = $dbsearchdemandedetailachattechnopoleapreslafiliere;
    }
    public function editviserlebondecommandeparagenttechnopoleoufiliereAction () {
        
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

        $dbselect = "SELECT * FROM eu_bon_commande WHERE id_bon_commande ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommande = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_bon_commande WHERE id_bon_commande ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdetailbondecommande = $stmt->fetchAll();

        $iddemandeachatauniveaudubondecommande = $dbsearchbondecommande[0]->id_demande_achat;
  
        $this->view->entries = $dbsearchbondecommande;
        $this->view->detailbondecommande = $dbsearchdetailbondecommande;
    }

    public function viserlademandeachatparagenttechnopoleoufiliereAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }
        $current_id = $_POST['iddemandeachat'];
        $visatechfiliere = $_POST['visademandeachat'];
        $avistechfiliere = $_POST['avisdemandeachat'];
        $db = Zend_Db_Table::getDefaultAdapter();
        $created = Zend_Date::now();
       /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/
        $resultjson = array();
        $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
        $dbtselect = "UPDATE eu_demande_achat SET visatechfiliere ='$visatechfiliere', avistechfiliere ='$avistechfiliere', datevisatechfiliere ='$date_created',valider_down = 4 WHERE  id_demande_achat= $current_id"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $resultjson = array(
          'update'=>'Visa apposé avec success'
        );
        header('Content-type:application/json');
        die(json_encode($resultjson));
    }

/*** Seul la possibilité de recevoir la demande préalablement viser
 * par la technopole puis ensuite appose son visa (valid_down = 4) pour ensuite
 * le remettre à la technopole valid_up = 4
 */
    public function viserlademandeachatparlegerantAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }
        $current_id = $_POST['iddemandeachatgerant'];
        $visatechfiliere = $_POST['visademandeachatgerant'];
        $avistechfiliere = $_POST['avisdemandeachatgerant'];
        $db = Zend_Db_Table::getDefaultAdapter();
        

        $created = Zend_Date::now();
       /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/
        $resultjson = array();
        $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');

        $dbtselect = "UPDATE eu_demande_achat 
                      SET eu_demande_achat.visatechfiliere ='$visatechfiliere',
                      eu_demande_achat.avistechfiliere ='$avistechfiliere',
                      eu_demande_achat.datevisatechfiliere ='$date_created',
                      eu_demande_achat.valider_down = 6                     
                      WHERE  id_demande_achat= $current_id"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $resultjson = array(
          'update'=>'Visa apposé avec succes'
        );
        header('Content-type:application/json');
        die(json_encode($resultjson));
    }

    public function ajaxvaliderlademandeachatparlatechnopoleapreslafiliereAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            try {
                $current_id = $_POST['iddemandeachattechnopoleapreslafiliere'];
                $db = Zend_Db_Table::getDefaultAdapter();
                $created = Zend_Date::now();

               /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/

                $resultjson = array();
                $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
                $dbtselect = "UPDATE eu_demande_achat 
                      SET valider_down = 5                     
                      WHERE  id_demande_achat= $current_id"; 
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $resultjson = array(
                  'update'=>'Validation avec succes'
                );
            } catch (Exception $e) {
                $errormessage = $e->getMessage();
                $resultjson = array(
                  'errorjson'=>$errormessage,
                );
            }
                header('Content-type:application/json');
                die(json_encode($resultjson));
      }
        
    }

    public function listedesdemandeachatemiseparunmembreAction ()
    {

        $db = Zend_Db_Table::getDefaultAdapter();
        $sessionmembre = new Zend_Session_Namespace('membre');
        $codemembre = $sessionmembre->code_membre;
        
   
        $dbverifselect = "SELECT 
                            eu_demande_achat.id_demande_achat,
                            eu_demande_achat.libelle_demande_achat,
                            eu_demande_achat.reference_demande_achat,
                            eu_demande_achat.code_membre
                           FROM eu_demande_achat
                           WHERE eu_demande_achat.code_membre = '$codemembre'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbcentraldesdemandeachat = $stmt->fetchAll();
   
        $this->view->centraldesdemandesachatparagentesmc = $dbcentraldesdemandeachat;

    } 

    
     public function listedesdemandeachatemiseparagentesmcAction () {
         /****Seul les fournisseurs ont accès a cette interface */
         $db = Zend_Db_Table::getDefaultAdapter();

         $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

         
         $id_utilisateur = $sessionutilisateur->id_utilisateur;
         
    
         $dbverifselect = "SELECT 
                             eu_demande_achat.id_demande_achat,
                             eu_demande_achat.libelle_demande_achat,
                             eu_demande_achat.reference_demande_achat,
                             eu_demande_achat.code_membre
                            FROM eu_demande_achat
                            WHERE eu_demande_achat.id_utilisateur = $id_utilisateur";

         $db->setFetchMode(Zend_Db::FETCH_OBJ);

         $stmt = $db->query($dbverifselect);

         $dbcentraldesdemandeachat = $stmt->fetchAll();
    
         $this->view->centraldesdemandesachatparagentesmc = $dbcentraldesdemandeachat;
     }


     public function listedetouslesdemandesachatAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sessionmembre = new Zend_Session_Namespace('membre');
        $codemembre = $sessionmembre->code_membre;
        
   
        $dbverifselect = "SELECT 
                            eu_demande_achat.id_demande_achat,
                            eu_demande_achat.libelle_demande_achat,
                            eu_demande_achat.reference_demande_achat,
                            eu_demande_achat.code_membre
                           FROM eu_demande_achat";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbcentraldesdemandeachat = $stmt->fetchAll();
   
        $this->view->centraldesdemandesachat = $dbcentraldesdemandeachat;
     }

     public function listedesdemandeachatemisepartouslesagentsesmcAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
   
        $dbverifselect = "SELECT 
                           eu_demande_achat.id_demande_achat,
                           eu_demande_achat.libelle_demande_achat,
                           eu_demande_achat.reference_demande_achat,
                           eu_demande_achat.code_membre
                           FROM eu_demande_achat";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbcentraldesdemandeachat = $stmt->fetchAll();
   
        $this->view->centraldesdemandesachat = $dbcentraldesdemandeachat;
    }


     public function listedesdemandeachatquionteterejeterAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
   
        $dbverifselect = "SELECT * FROM eu_demande_achat WHERE rejet = 2";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesdemandesachatquisontrejete = $stmt->fetchAll();
     }

     public function listedesdemandeachataviserparlatechnopolefiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
   
        $dbverifselect = "SELECT *
                          FROM eu_demande_achat
                          WHERE eu_demande_achat.rejet = 1
                          AND eu_demande_achat.valider_down = 3
                          AND eu_demande_achat.valider_up != 3
                          AND eu_demande_achat.livrer = 0
                          AND eu_demande_achat.id_demande_achat  IN (
                              SELECT eu_forms_budget_nature.reference_type_budget
                              FROM eu_forms_budget_nature
                              WHERE eu_forms_budget_nature.type_budget 
                          )";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesdemandesachatquisontrejete = $stmt->fetchAll();
   
        $this->view->listedesdemandesachatquisontrejete = $dblistedesdemandesachatquisontrejete;
    }


    public function listedesdemandeachatrejeterdontlebudgetnestpasetablitAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $resulttab = array();   

        $dbverifselect = "SELECT 
                            eu_demande_achat.code_membre,
                            eu_demande_achat.reference_demande_achat,
                            eu_demande_achat.libelle_demande_achat,
                            eu_demande_achat.id_demande_achat
                          FROM eu_demande_achat
                          WHERE eu_demande_achat.rejet = 1 
                          AND eu_demande_achat.valider_down = 3
                          AND eu_demande_achat.valider_up != 3
                          AND eu_demande_achat.livrer = 0 
                          AND eu_demande_achat.id_demande_achat NOT IN (
                            SELECT eu_forms_budget_nature.reference_type_budget
                            FROM eu_forms_budget_nature
                            WHERE eu_forms_budget_nature.type_budget='DA')";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesdemandesachatquisontrejetesansbudget = $stmt->fetchAll();
   
        $this->view->listedesdemandesachatquisontrejetesansbudget = $dblistedesdemandesachatquisontrejetesansbudget;
    }

    public function listedesdemandeachataviserparlegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
   
        $dbverifselect = "SELECT * FROM eu_demande_achat WHERE rejet = 1 AND valider_down = 5 AND visatechfiliere = 'ok' AND valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesviserparlegerant = $stmt->fetchAll();
   
        $this->view->listedesdemandeachatviserparlegerant = $dblistedesviserparlegerant;
    }

    public function listedesdemandeachatavaliderparlatechnopoleapreslafiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
   
        $dbverifselect = "SELECT * FROM eu_demande_achat WHERE rejet = 1 AND valider_down = 4 AND visatechfiliere = 'ok' AND valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesviserparlatechnopoleapreslafiliere = $stmt->fetchAll();
   
        $this->view->listedesdemandeachatviserparlatechnopoleapreslafiliere = $dblistedesviserparlatechnopoleapreslafiliere;
    }

    public function listedesdemandeachatsquisontviseesparlegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
   
        $dbverifselect = "SELECT * FROM eu_demande_achat WHERE rejet = 1 AND visa_gerant='ok' AND visatechfiliere ='ok' AND valider_down = 6 AND valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesdemandesachatquisontviseeparlegerant = $stmt->fetchAll();
   
        $this->view->listedesdemandesachatsquisontviseeparlegerant = $dblistedesviserparlatechnopoleoulafiliere;
    }



    public function listedesdemandeachatviseravaliderdugerantverslatechnopoleAction () {
        
        
        $db = Zend_Db_Table::getDefaultAdapter();
   
        $dbverifselect = "SELECT * FROM eu_demande_achat WHERE rejet = 1 AND visa_gerant='ok' AND visatechfiliere ='ok' AND valider_down = 6 AND valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesdemandesachatavaliderparlegerant = $stmt->fetchAll();
   
        $this->view->listedesdemandesachatavaliderparlegerant = $dblistedesdemandesachatavaliderparlegerant;
    }

    public function listedesdemandeachatviseravaliderparlatechnopoleapreslegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
   
        $dbverifselect = "SELECT * FROM eu_demande_achat WHERE rejet = 1 AND visa_gerant='ok' AND visatechfiliere ='ok' AND valider_down = 6 AND valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesdemandesachatavaliderparlatechnopoleapreslegerant = $stmt->fetchAll();
   
        $this->view->listedesdemandesachatavaliderparlatechnopoleapreslegerant = $dblistedesdemandesachatavaliderparlatechnopoleapreslegerant;
    }

    public function editdesdemandeachatviseeparlegerantetlatechnopoleAction () {

    }

    public function editdesdemandeachataviserparlegerantAction () {

    }


     public function editdetailsdelademandeachatAction () {
         $db = Zend_Db_Table::getDefaultAdapter();
        
         $id = (int)$this->_request->getParam('id');

         if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT * FROM eu_demande_achat WHERE id_demande_achat ='$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedeliddelademandeachat = $stmt->fetchAll();
            if (count($dbrecherchedeliddelademandeachat) == 0) {
                http_response_code(403);
                die('Désolé mais cette demande d\'achat n\'a pas encore été établit');
            }
        }

         $dbselect = "SELECT * FROM eu_demande_achat WHERE id_demande_achat ='$id'";
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
         $stmt = $db->query($dbselect);
         $dbsearchdemandeachat = $stmt->fetchAll();

         $dbselect = "SELECT * FROM eu_detail_demande_achat WHERE id_demande_achat ='$id'";
         $db->setFetchMode(Zend_Db::FETCH_OBJ);
         $stmt = $db->query($dbselect);
         $dbsearchdemandedetailachat = $stmt->fetchAll();


         $this->view->entries = $dbsearchdemandeachat;
         $this->view->detailachat = $dbsearchdemandedetailachat;
     }

     public function editdesdemandeachatavaliderparlatechnopoleapreslegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
           $dbselect = "SELECT * FROM eu_demande_achat WHERE id_demande_achat ='$id' AND rejet = 1 AND visa_gerant='ok' AND visatechfiliere ='ok' AND valider_down = 6 AND valider_up != 3";
           $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $stmt = $db->query($dbselect);
           $dbrecherchedeliddelademandeachat = $stmt->fetchAll();
           if (count($dbrecherchedeliddelademandeachat) == 0) {
               http_response_code(403);
               die('Désolé mais cette demande d\'achat n\'a pas encore été établit');
           }
       }

        $dbselect = "SELECT * FROM eu_demande_achat WHERE id_demande_achat ='$id' AND rejet = 1 AND visa_gerant='ok' AND visatechfiliere ='ok' AND valider_down = 6 AND valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandeachat = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_demande_achat WHERE id_demande_achat ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandedetailachat = $stmt->fetchAll();


        $this->view->entriesavaliderparlatechnopoleapreslegerant = $dbsearchdemandeachat;
        $this->view->detailachatavaliderparlatechnopoleapreslegerant = $dbsearchdemandedetailachat;
     }

     /****Demande d'achat avec la liste de tous les fournisseurs
      * 
      * liste de tous les fournisseurs avec le proces verbal(contenu du proces, fichier du proces) par la technopole/filiere
      * 
      * La liste des demandes d'achats avec upload de fichier du proforma

      */

     public function editavisauxfournisseursdisponibleAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $created = Zend_Date::now();
        $request = $this->getRequest();
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
        
        $validationerrors = array();
        $validationsuccess = array();
           
        $dbverifselect = "SELECT *
                          FROM eu_demande_achat
                          WHERE id_demande_achat ='$id'
                          AND rejet = 1
                          AND valider_down = 4
                          AND visatechfiliere = 'ok'
                          AND valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbresultatdemandeachat = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_demande_achat WHERE id_demande_achat ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandedetailachatfournisseur = $stmt->fetchAll();


        /***La liste de tous les fournisseurs disponibles sur la plateformes ESMC */
        $dbselect = "SELECT DISTINCT(offreur_projet_code_membre), offreur_projet_raison_sociale FROM eu_offreur_projet";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbresultatdetouslesfournisseursdisponibles = $stmt->fetchAll();
        $this->view->resultatdetouslesfournisseursdisponibles = $dbresultatdetouslesfournisseursdisponibles;
        $this->view->resultatdemandeachat = $dbresultatdemandeachat;
        $this->view->searchdemandedetailachatfournisseur = $dbsearchdemandedetailachatfournisseur;
        

        if($request->isPost()){


          for ($i = 0; $i< count($_POST['comite_fournisseur']); $i++){
      

               $code_membre_fournisseur = $_POST['comite_fournisseur'][$i];
               $libelle_comite_fournisseur = $_POST['libelle_comite_fournisseur'][$i];
               $id_demande_achat_fournisseur = $_POST['iddemandeachatfournisseur'];
               $code_membre_fournisseur_choisit = "";
               $raison_sociale_fournisseur_choisit = "";
               if($code_membre_fournisseur == "") {
                $validationdemandeerrors['empty_code_membre_fournisseur'] = "Echec d'enregistrement:Le code membre du fournisseur ne doit pas être vide";
               }
    
               if(!isset($code_membre_fournisseur)){
                 $validationdemandeerrors['exist_code_membre_fournisseur'] = "Echec d'enregistrement:Le code membre du fournisseur est inexistant";
               }

               if (count($_POST['comite_fournisseur']) < 3) {
                $validationdemandeerrors['count_comite_fournisseur'] = "Le nombre de fournisseur doit être supérieur ou égale à trois";
               }   

               if ($code_membre_fournisseur !== ""){
                if(!in_array(substr($code_membre_fournisseur,-1), array('M')) || strlen($code_membre_fournisseur) != 20){
                    $validationdemandeerrors['valid_code_membre_fournisseur'] = "Echec d'enregistrement:Le code membre du fournisseur est invalide";
                }

                if(in_array(substr($code_membre_fournisseur,-1), array('M')) || strlen($code_membre_fournisseur) === 20){
                    $dbverifselect = "SELECT DISTINCT(eu_offreur_projet.offreur_projet_code_membre), eu_offreur_projet.offreur_projet_raison_sociale
                                      FROM eu_offreur_projet
                                      WHERE eu_offreur_projet.offreur_projet_code_membre ='$code_membre_fournisseur'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbverifselect);
                    $dbverifournisseur = $stmt->fetchAll(); 
                    $countveriffournisseur = count($dbveriffournisseur);

                    $dbverifselect = "SELECT DISTINCT(eu_fournisseur_choisit.code_membre_fournisseur), eu_fournisseur_choisit.id_demande_achat
                                      FROM eu_fournisseur_choisit
                                      WHERE eu_fournisseur_choisit.code_membre_fournisseur ='$code_membre_fournisseur'
                                      AND eu_fournisseur_choisit.id_demande_achat = '$id_demande_achat_fournisseur'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbverifselect);
                    $dbverifdoublefournisseur = $stmt->fetchAll(); 
                    $countverifdoublefournisseur = count($dbverifdoublefournisseur);
                    
                    if($countveriffournisseur == 0){
                        $validationerrors['valeur_code_membre_fournisseur'] = "Vous n'êtes pas autorisé a éffectuer cet type d'operation";          
                    }

                    if($countverifdoublefournisseur !== 0){
                        $validationerrors['double_code_membre_fournisseur'] = "Le fournisseur ayant pour code membre : $code_membre_fournisseur a deja été aviser pour cette demande d'achat";          
                    }

                    if($countveriffournisseur == 1){
                       $code_membre_fournisseur_choisit = $dbverifournisseur[0]->offreur_projet_code_membre;
                       $raison_sociale_fournisseur_choisit = $dbverifournisseur[0]->offreur_projet_raison_sociale;
                       
                    }

                }
            }

            if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
            }
          }

          if (empty($validationerrors)) {
               for ($i = 0; $i< count($_POST['comite_fournisseur']); $i++) {
                  $dbfinsert = "INSERT INTO eu_fournisseur_choisit(code_membre_fournisseur,libelle_fournisseur,id_demande_achat,date_choix) VALUES ('$code_membre_fournisseur','$raison_sociale_fournisseur_choisit','$id_demande_achat_fournisseur','$date_choix')";
                  $db->setFetchMode(Zend_Db::FETCH_OBJ);
                  $stmt = $db->query($dbfinsert);   

               }
              $validationsuccess['success_message'] = "Enregistrement de la demande d'achat effectué avec succes";
              $_SESSION['validationsuccess'] = $validationsuccess;
              $this->_redirect("/procedureachat/listedesavisaenvoyeratroisfournisseursaumoins");
          }

        }
         
    }

    public function envoiedelapropositiondesfournisseursAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
    }

    
    public function listedesavisaenvoyeratroisfournisseursaumoinsAction () {
        $db = Zend_Db_Table::getDefaultAdapter();


        $dbverifselect = "SELECT * 
                          FROM 
                          eu_demande_achat
                          WHERE rejet = 1
                          AND valider_down = 4
                          AND visatechfiliere = 'ok'
                          AND valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesdemandesachatspourlestroisfournisseurs = $stmt->fetchAll();
        $this->view->listedesdemandesachatspourlestroisfournisseur = $dblistedesdemandesachatspourlestroisfournisseur;
   
    }

    public function listedesavisenvoyerauxfournisseurspouretablissementdelafactureproformaAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $dbverifselect = "SELECT * 
                          FROM 
                          eu_demande_achat,
                          eu_fournisseur_choisit
                          WHERE
                           eu_fournisseur_choisit.id_demande_achat = eu_demande_achat.id_demande_achat
                          AND eu_demande_achat.rejet = 1
                          AND eu_demande_achat.valider_down = 4
                          AND eu_demande_achat.visatechfiliere = 'ok'
                          AND eu_demande_achat.livrer = 0
                          AND eu_demande_achat.valider_up != 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesdemandesachatspourlestroisfournisseurs = $stmt->fetchAll();
        $this->view->listedesdemandesachatspourlestroisfournisseur = $dblistedesdemandesachatspourlestroisfournisseurs;
    }

    public function listedesavisenvoyerenfonctiondesfournisseurspouretablissementdelafactureproformaAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
     	$sessionmembre = new Zend_Session_Namespace('membre');	
        $code_membre_fournisseurs = $sessionmembre->code_membre;
        

        $dbverifselect = "SELECT * 
                          FROM 
                          eu_demande_achat,
                          eu_fournisseur_choisit
                          WHERE
                           eu_fournisseur_choisit.id_demande_achat = eu_demande_achat.id_demande_achat
                          AND eu_demande_achat.rejet = 1
                          AND eu_demande_achat.valider_down = 4
                          AND eu_demande_achat.visatechfiliere = 'ok'
                          AND eu_demande_achat.livrer = 0
                          AND eu_demande_achat.valider_up != 3
                          AND eu_fournisseur_choisit.code_membre_fournisseur = '$code_membre_fournisseurs'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedesavisparfournisseur = $stmt->fetchAll();
        $this->view->listedesavisparfournisseur = $dblistedesavisparfournisseur; 
    }




    public function editiondelafactureproformaenfonctiondelademandeachatAction () {
        /***Redirection vers la listedesavisenvoyerauxfournisseurspouretablissementdelafactureproforma */
        /*** */
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $created = Zend_Date::now();        
        $request = $this->getRequest();
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
        $sessionmembre = new Zend_Session_Namespace('membre');	
        $code_membre_fournisseurs = $sessionmembre->code_membre;
        
        $idfournisseurchoisitproforma = 0;
        


        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbverifid = " SELECT eu_demande_achat.id_demande_achat
            FROM eu_demande_achat
            WHERE eu_demande_achat.id_demande_achat = '$id'
            AND eu_demande_achat.rejet = 1
            AND eu_demande_achat.valider_down = 4
            AND eu_demande_achat.visatechfiliere = 'ok'
            AND eu_demande_achat.livrer = 0
            AND eu_demande_achat.valider_up != 3";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationdelavaliditedeid = $stmt->fetchAll();
            $countdbverificationdelavaliditedeid = count($dbverificationdelavaliditedeid);


            if($countdbverificationdelavaliditedeid !== 1){
                http_response_code(403);
                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
            }
        }


        $dbverifselect = "SELECT 
                        eu_demande_achat.libelle_demande_achat,
                        eu_demande_achat.reference_demande_achat,
                        eu_fournisseur_choisit.id_demande_achat,
                        eu_fournisseur_choisit.date_choix,
                        eu_demande_achat.date_demande,
                        eu_demande_achat.datevisatechfiliere,
                        eu_demande_achat.visatechfiliere,
                        eu_demande_achat.code_membre,
                        eu_fournisseur_choisit.code_membre_fournisseur
                        FROM eu_demande_achat,eu_fournisseur_choisit
                        WHERE eu_fournisseur_choisit.id_demande_achat = eu_demande_achat.id_demande_achat
                        AND eu_demande_achat.rejet = 1
                        AND eu_demande_achat.valider_down = 4
                        AND eu_fournisseur_choisit.id_demande_achat =$id
                        AND eu_demande_achat.visatechfiliere = 'ok'
                        AND eu_demande_achat.valider_up != 3
                        AND eu_demande_achat.livrer= 0
                        AND eu_fournisseur_choisit.code_membre_fournisseur = '$code_membre_fournisseurs'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbdetailsavisdedemandeachatenvoyeauxfournisseurs = $stmt->fetchAll();

        $dbverifselect = "SELECT reference_article,designation_article,quantite,prix_unitaire
        FROM eu_detail_demande_achat
        WHERE id_demande_achat ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbdetaildelademandeachatenvoyeauxfournisseurs = $stmt->fetchAll();

        $this->view->detailsavisdedemandeachatenvoyeauxfournisseurs = $dbdetailsavisdedemandeachatenvoyeauxfournisseurs;
        $this->view->detaildelademandeachatenvoyeauxfournisseurs = $dbdetaildelademandeachatenvoyeauxfournisseurs;
        
        if($request->isPost()){
            $montant_ht_proforma_procedure = $_POST["montant_ht_proforma_procedure"];
            $tva_proforma_procedure = $_POST["tva_proforma_procedure"];
            $montant_ttc_procedure = $_POST["montant_ttc_procedure"];
            $modalite_paiement_proforma = $_POST["modalite_paiement_proforma"];
            $address_livraison_proforma_procedure = $_POST["address_livraison_proforma_procedure"];
            $date_paiement_proforma_procedure = $_POST["date_paiement_proforma_procedure"];
            $date_livraison_proforma_procedure = $_POST["date_livraison_proforma_procedure"];
            $ref_facture_proforma_fournisseur = substr(md5(uniqid(rand(),true)),0,8);
            $real_ref_facture_proforma_fournisseur  = strtoupper('PROFORMA-'.$ref_facture_proforma_fournisseur);
            $code_membre_fournisseur = $sessionmembre->code_membre;
            //$code_membre_fournisseur = "0010010010020000003M";
            
            $created = Zend_Date::now();
            $date_etablissement_proforma = $created->toString('yyyy-MM-dd HH:mm:ss');
            
            
            
            /****Verification du code membre du fournisseur */
            if ($code_membre_fournisseur == ""){
                $validationerrors['empty_code_membre_fournisseur'] = "Impossible d'effectué l'enregistrement: Votre code membre ne doit pas être vide";
            }        

            if(!isset($code_membre_fournisseur)) {
                $validationerrors['exist_code_membre_fournisseur'] = "Erreur au niveau du montant HT :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
            }

            if ($code_membre_fournisseur !== ""){
                if(!in_array(substr($code_membre_fournisseur,-1), array('M')) || strlen($code_membre_fournisseur) != 20){
                    $validationdemandeerrors['valid_code_membre_fournisseur'] = "Echec d'enregistrement:Le code membre du fournisseur est invalide";
                }

                if(in_array(substr($code_membre_fournisseur,-1), array('M')) || strlen($code_membre_fournisseur) === 20){
                    $dbverifselect = "SELECT eu_fournisseur_choisit.id_fournisseur_choisit
                    FROM eu_fournisseur_choisit
                    WHERE eu_fournisseur_choisit.code_membre_fournisseur ='$code_membre_fournisseur'
                    AND eu_fournisseur_choisit.id_demande_achat = '$id'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbverifselect);
                    $dbveriffournisseurchoisit = $stmt->fetchAll(); 
                    $countveriffournisseurchoisit = count($dbveriffournisseurchoisit);
                    
                    if($countveriffournisseurchoisit === 0){
                        $validationerrors['valeur_code_membre_fournisseur'] = "Vous n'êtes pas autorisé a éffectuer cet type d'operation";          
                    }

                    if($countveriffournisseurchoisit === 1){
                       $idfournisseurchoisitproforma = $dbveriffournisseurchoisit[0]->id_fournisseur_choisit;
                    }
                }
            }
            /***Verification au niveau du montant hors taxe */

            if ($montant_ht_proforma_procedure == ""){
                $validationerrors['empty_montant_ht_proforma_procedure'] = "Impossible d'effectué l'enregistrement: le montant hors taxe ne doit pas être vide";
            }

            if(!isset($montant_ht_proforma_procedure)) {
                $validationerrors['exist_montant_ht_proforma_procedure'] = "Erreur au niveau du montant HT :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
            }

            if($montant_ht_proforma_procedure != ""){
               if(!filter_var($montant_ht_proforma_procedure, FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationerrors['verif_montant_ht_proforma_procedure'] = "Erreur au niveau du montant HT:le montant HT est invalide ";
               }

               if($montant_ht_proforma_procedure == 0){
                  $validationerrors['validite_montant_ht_proforma_procedure'] = "Erreur au niveau du montant HT:le montant HT ne doit pas être égale à 0 ";       
               }
            }

            /***Verification au niveau de la tva */
            if ($tva_proforma_procedure == ""){
                $validationerrors['empty_tva_proforma_procedure'] = "Impossible d'effectué l'enregistrement: la tva ne doit pas être vide";
            }

            if(!isset($tva_proforma_procedure)) {
                $validationerrors['exist_montant_ht_proforma_procedure'] = "Erreur au niveau de la TVA :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
            }

            if($tva_proforma_procedure !== ""){
               if(!filter_var($tva_proforma_procedure, FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationerrors['verif_tva_proforma_procedure'] = "Erreur au niveau de la TVA:la TVA est invalide ";
               }
               if($tva_proforma_procedure == 0){
                $validationerrors['validite_tva_proforma_procedure'] = "Erreur au niveau de la TVA:la TVA ne doit pas être égale à 0 ";       
             }
            }

            /***montant_ttc_procedure */

            if ($montant_ttc_procedure == ""){
                $validationerrors['empty_montant_ttc_procedure'] = "Impossible d'effectué l'enregistrement: le montant toute taxe comprise (TTC) ne doit pas être vide";
            }

            if(!isset($montant_ttc_procedure)) {
                $validationerrors['exist_montant_ttc_procedure'] = "Erreur au niveau du montant toute taxe comprise (TTC) :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
            }

            if($montant_ttc_procedure !== ""){
               if(!filter_var($montant_ttc_procedure, FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationerrors['verif_montant_ttc_procedure'] = "Erreur au niveau du montant toute taxe comprise (TTC):le montant tout taxe comprise (TTC) est invalide ";
               }
               if($montant_ttc_procedure == 0){
                $validationerrors['validite_montant_ttc_procedure'] = "Erreur au niveau du montant TTC:le montant TTC ne doit pas être égale à 0 ";       
               }
            }

            if ($montant_ttc_procedure !== "" && $montant_ht_proforma_procedure !== "") {
                if ($montant_ttc_procedure !== 0 && $montant_ht_proforma_procedure !== 0) {
                   
                    if($montant_ttc_procedure < $montant_ht_proforma_procedure){
                        $validationerrors['rapport_montant_ttc_procedure'] = "Erreur: le montant Toute Taxe Comprise (TTC) ne doit pas être inférieure au montant Hors Taxe (MHT)";       
                    }

                }
 
            }

            
            if ($modalite_paiement_proforma == ""){
                $validationerrors['empty_montant_ttc_procedure'] = "Impossible d'effectué l'enregistrement: le montant toute taxe comprise (TTC) ne doit pas être vide";
            }

            if(!isset($modalite_paiement_proforma)) {
                $validationerrors['exist_montant_ttc_procedure'] = "Erreur au niveau du montant toute taxe comprise (TTC) :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
            }

            if($modalite_paiement_proforma != ""){

                if(!in_array($modalite_paiement_proforma, array('Cheque','Espece','Virement Bancaire','Lettre de Change'))){
                    $validationerrors['select_modalite_paiement_proforma'] = "La modalité de paiement que vous avez selectionné est invalide";          
                }
               
            }

            if ($address_livraison_proforma_procedure == ""){
                $validationerrors['empty_address_livraison_proforma_procedure'] = "Impossible d'effectué l'enregistrement: L'adresse de livraison doit être renseigné";
            }

            if(!isset($address_livraison_proforma_procedure)) {
                $validationerrors['exist_address_livraison_proforma_procedure'] = "Erreur au niveau de l'adresse de livraison :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
            }

            if ($date_paiement_proforma_procedure == ""){
                $validationerrors['empty_date_paiement_proforma_procedure'] = "Impossible d'effectué l'enregistrement: La date de paiement de la facture doit être renseigné";
            }

            if(!isset($date_paiement_proforma_procedure)) {
                $validationerrors['exist_date_paiement_proforma_procedure'] = "Erreur au niveau de la date de paiement :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
            }

            if ($date_livraison_proforma_procedure == ""){
                $validationerrors['empty_date_livraison_proforma_procedure'] = "Impossible d'effectué l'enregistrement: La date de livraison doit être renseigné";
            }

            if(!isset($date_livraison_proforma_procedure)) {
                $validationerrors['exist_date_livraison_proforma_procedure'] = "Erreur au niveau de la date de livraison :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
            }
            
            if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
            }

            if(!isset($_SESSION['validationerrors'])) {
                if (empty($validationerrors)) {
                    $dbfselect = "SELECT *
                                  FROM eu_proforma_procedure
                                  WHERE eu_proforma_procedure.id_fournisseur_choisit='$idfournisseurchoisitproforma'
                                  AND eu_proforma_procedure.id_demande_achat='$id'
                                  AND eu_proforma_procedure.numero_proforma = '$real_ref_facture_proforma_fournisseur'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfselect); 
                    $dbsearchcheckproforma = $stmt->fetchAll();
                    $countsearchcheckproforma = count($dbsearchcheckproforma);
                    
                    if($countsearchcheckproforma !== 0){
                        $validationerrors['exist_proforma'] = "Ce proforma a été deja enregistré";         
                    }

                    if($countsearchcheckproforma == 0){
                        $dbfinsert = "INSERT INTO eu_proforma_procedure(
                            numero_proforma,
                            id_fournisseur_choisit,
                            id_demande_achat,
                            montant_ht,
                            montant_ttc,
                            tva,
                            date_proforma,
                            date_paie,
                            date_livraison,
                            valid_down,
                            addresse_livraison,
                            modalite_paiement) VALUES (
                            '$real_ref_facture_proforma_fournisseur',
                            '$idfournisseurchoisitproforma',
                            '$id',
                            '$montant_ht_proforma_procedure',
                            '$montant_ttc_procedure',
                            '$tva_proforma_procedure',
                            '$date_etablissement_proforma',
                            '$date_paiement_proforma_procedure',
                            '$date_livraison_proforma_procedure',
                            1,
                            '$address_livraison_proforma_procedure',
                            '$modalite_paiement_proforma')";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbfinsert);

                        $dbfselect = "SELECT *
                        FROM eu_proforma_procedure
                        WHERE eu_proforma_procedure.id_fournisseur_choisit='$idfournisseurchoisitproforma'
                        AND eu_proforma_procedure.id_demande_achat='$id'
                        AND eu_proforma_procedure.numero_proforma = '$real_ref_facture_proforma_fournisseur'";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbfselect); 
                        $dbsearchproforma = $stmt->fetchAll();
                        $countsearchproforma = count($dbsearchproforma);

                        if($countsearchproforma !== 0){
                            
                           $id_facture_proforma = $dbsearchproforma[0]->id_proforma;
                            
                            for($i = 0; $i< count($_POST['quantite_article_disponible_fournisseur_procedure']); $i++){
                               $quantite_article_disponible_fournisseur_procedure = $_POST['quantite_article_disponible_fournisseur_procedure'][$i];
                               $prix_unitaire_fournisseur_procedure = $_POST['prix_unitaire_fournisseur_procedure'][$i];
                               $total_article_fournisseur_procedure = $_POST['total_article_fournisseur_procedure'][$i];
                               $disponible_article_fournisseur = $_POST['disponible_article_fournisseur'][$i];
                               if ($quantite_article_disponible_fournisseur_procedure == ""){
                                $validationerrors['empty_quantite_article_disponible_fournisseur_procedure'] = "Impossible d'effectué l'enregistrement: La quantité disponible doit être renseigné";
                               }
                
                               if(!isset($quantite_article_disponible_fournisseur_procedure)) {
                                 $validationerrors['exist_quantite_article_disponible_fournisseur_procedure'] = "Erreur au niveau de la quantite disponible :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
                               }

                               if($quantite_article_disponible_fournisseur_procedure != ""){
                                  if(!filter_var($quantite_article_disponible_fournisseur_procedure, FILTER_VALIDATE_REGEXP,
                                   array("options"=>array("regexp"=>"#[0-9]#")))){
                                   $validationerrors['verif_quantite_article_disponible_fournisseur_procedure'] = "Erreur au niveau de la quantité disponible:la quantité disponible est invalide ";
                                  }
                                  if($quantite_article_disponible_fournisseur_procedure == 0){
                                   $validationerrors['validite_quantite_article_disponible_fournisseur_procedure'] = "Erreur au niveau de la quantité disponible:la quantité disponible ne doit pas être égale à 0 ";       
                                  }
                               }

                               if ($prix_unitaire_fournisseur_procedure == ""){
                                $validationerrors['empty_prix_unitaire_fournisseur_procedure'] = "Impossible d'effectué l'enregistrement: Le prix unitaire des articles doit être renseigné";
                               }
                
                               if(!isset($prix_unitaire_fournisseur_procedure)) {
                                 $validationerrors['exist_prix_unitaire_fournisseur_procedure'] = "Erreur au niveau du prix unitaire :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
                               }

                               if($prix_unitaire_fournisseur_procedure != ""){
                                  if(!filter_var($prix_unitaire_fournisseur_procedure, FILTER_VALIDATE_REGEXP,
                                   array("options"=>array("regexp"=>"#[0-9]#")))){
                                   $validationerrors['verif_prix_unitaire_fournisseur_procedure'] = "Erreur au niveau du prix unitaire:le prix unitaire est invalide ";
                                  }
                                  if($prix_unitaire_fournisseur_procedure == 0){
                                   $validationerrors['validite_prix_unitaire_fournisseur_procedure'] = "Erreur au niveau du prix unitaire:le prix unitaire ne doit pas être égale à 0 ";       
                                  }
                               }

                               if ($total_article_fournisseur_procedure == ""){
                                $validationerrors['empty_prix_unitaire_fournisseur_procedure'] = "Impossible d'effectué l'enregistrement: Le total des articles doit être renseigné";
                               }
                
                               if(!isset($total_article_fournisseur_procedure)) {
                                 $validationerrors['exist_total_article_fournisseur_procedure'] = "Erreur au niveau du total de l'article :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
                               }

                               if($total_article_fournisseur_procedure != ""){
                                  if(!filter_var($total_article_fournisseur_procedure, FILTER_VALIDATE_REGEXP,
                                   array("options"=>array("regexp"=>"#[0-9]#")))){
                                   $validationerrors['verif_total_article_fournisseur_procedure'] = "Erreur au niveau du total de l'article:le total de l'article est invalide ";
                                  }
                                  if($total_article_fournisseur_procedure == 0){
                                   $validationerrors['validite_total_article_fournisseur_procedure'] = "Erreur au niveau du total de l'article:le total de l'article ne doit pas être égale à 0 ";       
                                  }
                               }

                               if ($disponible_article_fournisseur == ""){
                                $validationerrors['empty_disponible_article_fournisseur'] = "Impossible d'effectué l'enregistrement: La disponibilité des articles doit être renseigné";
                               }
                
                               if(!isset($disponible_article_fournisseur)) {
                                 $validationerrors['exist_disponible_article_fournisseur'] = "Erreur au niveau de la disponibilité de l'article :Vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";          
                               }

                               if(!in_array($disponible_article_fournisseur, array('0','1'))){
                                 $validationerrors['validate_disponible_article_fournisseur'] = "Erreur au niveau de la disponibilité de l'article :Vous tentez de poster une valeur qui n'est pas valide";          

                               }

                               $parseintprix_unitaire_fournisseur_procedure = intval($prix_unitaire_fournisseur_procedure);
                               $parseintquantite_article_disponible_fournisseur_procedure = intval($quantite_article_disponible_fournisseur_procedure);
                               $check_total_article_fournisseur_procedure = $parseintprix_unitaire_fournisseur_procedure * $parseintquantite_article_disponible_fournisseur_procedure;
                               $parsetotal_article_fournisseur_procedure = intval($total_article_fournisseur_procedure);

                               if($parsetotal_article_fournisseur_procedure  !== $check_total_article_fournisseur_procedure){

                                 $validationerrors['validite_total_article'] = "Le total de l'article n'est pas exacte.Veuillez réessayer svp! ";       
                               }
                               $dbfselect = "SELECT *
                               FROM eu_detail_proforma_procedure
                               WHERE eu_detail_proforma_procedure.quantite_disponible_produit='$quantite_article_disponible_fournisseur_procedure'
                               AND eu_detail_proforma_procedure.id_proforma_procedure='$id_facture_proforma'
                               AND eu_detail_proforma_procedure.prix_unitaire_fournisseur = '$prix_unitaire_fournisseur_procedure'
                               AND eu_detail_proforma_procedure.disponibilite_demande= '$disponible_article_fournisseur'";
                               $db->setFetchMode(Zend_Db::FETCH_OBJ);
                               $stmt = $db->query($dbfselect); 
                               $dbsearchcheckdetailproforma = $stmt->fetchAll();
                               $countsearchcheckdetailproforma = count($dbsearchcheckdetailproforma); 
                               
                               if(!isset($_SESSION['validationerrors'])) {
                                if(!empty($validationerrors)){
                                    $_SESSION['validationerrors'] = $validationerrors;
                                }
                               }

                               if($countsearchcheckdetailproforma == 0 && empty($validationerrors)){
                                $dbfinsert = "INSERT INTO eu_detail_proforma_procedure(
                                    quantite_disponible_produit,
                                    prix_unitaire_fournisseur,
                                    total_article,
                                    disponibilite_demande,
                                    id_proforma_procedure) VALUES (
                                    '$quantite_article_disponible_fournisseur_procedure',
                                    '$prix_unitaire_fournisseur_procedure',
                                    '$total_article_fournisseur_procedure',
                                    '$disponible_article_fournisseur',
                                    '$id_facture_proforma')";
                                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                                $stmt = $db->query($dbfinsert);
                                $validationsuccess['success_message'] = "Enregistrement de la facture proforma effectué avec succes";
                                $_SESSION['validationsuccess'] = $validationsuccess;
                                $this->_redirect("/procedureachat/listedesavisenvoyerauxfournisseurspouretablissementdelafactureproforma");
                               }
                            }

                        }
                    }

                }
            }
        }
    }

    public function detaildelafactureproformaAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');

        $db = Zend_Db_Table::getDefaultAdapter();

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT * FROM eu_proforma_procedure WHERE id_proforma ='$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidduproforma = $stmt->fetchAll();
            if (count($dbrecherchedelidduproforma) == 0) {
                http_response_code(403);
                die('Désolé mais ce proforma n\'a pas encore été établit');
            }
        }

        $dbverifselect = "SELECT
                             eu_fournisseur_choisit.code_membre_fournisseur,
                             eu_proforma_procedure.numero_proforma,
                             eu_proforma_procedure.date_proforma,
                             eu_proforma_procedure.montant_ht,
                             eu_proforma_procedure.montant_ttc,
                             eu_proforma_procedure.date_paie,
                             eu_proforma_procedure.date_livraison,
                             eu_proforma_procedure.addresse_livraison,
                             eu_proforma_procedure.modalite_paiement,
                             eu_proforma_procedure.id_proforma,                   
                             eu_fournisseur_choisit.code_membre_fournisseur,
                             eu_fournisseur_choisit.libelle_fournisseur,
                             eu_demande_achat.libelle_demande_achat,
                             eu_demande_achat.reference_demande_achat
                   
                          FROM eu_proforma_procedure, eu_fournisseur_choisit, eu_demande_achat
                          WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                          AND eu_proforma_procedure.id_demande_achat = eu_demande_achat.id_demande_achat
                          AND eu_fournisseur_choisit.selection_fournisseur = 1
                          AND eu_proforma_procedure.id_proforma = $id";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbproforma = $stmt->fetchAll(); 

        $dbiddetailsproforma = $dbproformachoisit[0]->id_proforma;
        
        $dbverifselect = "SELECT
                            eu_detail_proforma_procedure.quantite_disponible_produit,
                            eu_detail_proforma_procedure.prix_unitaire_fournisseur,
                            eu_detail_proforma_procedure.total_article
                            eu_detail_proforma_procedure.disponibilite_demande
        
                         FROM eu_detail_proforma_procedure
                         WHERE eu_detail_proforma_procedure.id_proforma_procedure = $dbiddetailsproformachoisit";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbdetailsproforma = $stmt->fetchAll(); 
        $this->view->proforma = $dbproformachoisit;
        $this->view->detailsproforma = $dbdetailsproformachoisit;
    }

    public function listedesfactureproformaetablitparfournisseurAction () {
        $db = Zend_Db_Table::getDefaultAdapter();

        $sessionmembre = new Zend_Session_Namespace('membre');	
        $code_membre_fournisseurs = $sessionmembre->code_membre;

        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure, eu_fournisseur_choisit
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_fournisseur_choisit.code_membre_fournisseur = '$code_membre_fournisseurs'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondespropositionsparfournisseur = $stmt->fetchAll(); 
        $this->view->listedereceptiondespropositionsparfournisseur = $dblistedereceptiondespropositionsparfournisseur;
    }

    public function listedesreceptionsdespropositionsdesfournisseurschoisitsousformedeproformaAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure, eu_fournisseur_choisit
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondespropositions = $stmt->fetchAll(); 
        $this->view->listedereceptiondespropositions = $dblistedereceptiondespropositions;
    }



    public function listedesproformachoisitAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure, eu_fournisseur_choisit
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_fournisseur_choisit.selection_fournisseur = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondespropositionschoisit = $stmt->fetchAll(); 
        $this->view->listedereceptiondespropositionschoisit = $dblistedereceptiondespropositions;
    }

    public function listedesproformaquisontvalideparlatechnopoleAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_fournisseur_choisit.selection_fournisseur = 1
        AND eu_proforma_procedure.valid_down = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondesproformachoisitvaliderparlatechnopolefiliere = $stmt->fetchAll(); 
        $this->view->listedereceptiondesproformachoisitvaliderparlatechnopolefiliere = $dblistedereceptiondesproformachoisitvaliderparlatechnopolefiliere;

    }

    public function listedesproformaquisontvaliderparlegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_fournisseur_choisit.selection_fournisseur = 1
        AND eu_proforma_procedure.valid_down = 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondesproformachoisitvaliderparlegerant = $stmt->fetchAll(); 
        $this->view->listedereceptiondesproformachoisitvaliderparlegerant = $dblistedereceptiondesproformachoisitvaliderparlegerant;
    }

    public function listedesproformaquisontvaliderparlatechnopoleapreslafiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_fournisseur_choisit.selection_fournisseur = 1
        AND eu_proforma_procedure.valid_down = 2";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondesproformachoisitvaliderparlatechnopoleapreslafiliere = $stmt->fetchAll(); 
        $this->view->listedereceptiondesproformachoisitvaliderparlatechnopoleapreslafiliere  = $dblistedereceptiondesproformachoisitvaliderparlatechnopoleapreslafiliere;
    }

    public function listedesproformaavaliderparlatechnopoleapreslegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_fournisseur_choisit.selection_fournisseur = 1
        AND eu_proforma_procedure.valid_down = 4";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondesproformachoisitavaliderparlatechnopoleapreslegerant = $stmt->fetchAll(); 
        $this->view->listedereceptiondesproformachoisitavaliderparlatechnopoleapreslegerant  = $dblistedereceptiondesproformachoisitavaliderparlatechnopoleapreslegerant;
    }

    public function editvaliderlafactureproformachoisitparlatechnopoleapreslegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');

        $db = Zend_Db_Table::getDefaultAdapter();

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT *
                         FROM eu_proforma_procedure, eu_fournisseur_choisit
                         WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                         AND eu_proforma_procedure.id_proforma ='$id'
                         AND eu_fournisseur_choisit.selection_fournisseur = 1
                         AND eu_proforma_procedure.valid_down = 4";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidduproforma = $stmt->fetchAll();
            if (count($dbrecherchedelidduproforma) == 0) {
                http_response_code(403);
                die('Désolé mais ce proforma n\'a pas encore été établit');
            }
        }

        $dbverifselect = "SELECT
                             eu_fournisseur_choisit.code_membre_fournisseur,
                             eu_proforma_procedure.numero_proforma,
                             eu_proforma_procedure.date_proforma,
                             eu_proforma_procedure.montant_ht,
                             eu_proforma_procedure.montant_ttc,
                             eu_proforma_procedure.date_paie,
                             eu_proforma_procedure.date_livraison,
                             eu_proforma_procedure.addresse_livraison,
                             eu_proforma_procedure.modalite_paiement,
                             eu_proforma_procedure.id_proforma,                   
                             eu_fournisseur_choisit.code_membre_fournisseur,
                             eu_fournisseur_choisit.libelle_fournisseur,
                             eu_demande_achat.libelle_demande_achat,
                             eu_demande_achat.reference_demande_achat
                   
                          FROM eu_proforma_procedure, eu_fournisseur_choisit, eu_demande_achat
                          WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                          AND eu_proforma_procedure.id_demande_achat = eu_demande_achat.id_demande_achat
                          AND eu_fournisseur_choisit.selection_fournisseur = 1
                          AND eu_proforma_procedure.id_proforma = $id
                          AND eu_proforma_procedure.valid_down = 4";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbproformachoisit = $stmt->fetchAll(); 

        $dbiddetailsproformachoisit = $dbproformachoisit[0]->id_proforma;
        
        $dbverifselect = "SELECT
                            eu_detail_proforma_procedure.quantite_disponible_produit,
                            eu_detail_proforma_procedure.prix_unitaire_fournisseur,
                            eu_detail_proforma_procedure.total_article
                            eu_detail_proforma_procedure.disponibilite_demande
        
                         FROM eu_detail_proforma_procedure
                         WHERE eu_detail_proforma_procedure.id_proforma_procedure = $dbiddetailsproformachoisit";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbdetailsproformachoisit = $stmt->fetchAll(); 
        $this->view->proformachoisitavaliderparlatechopoleapreslegerant = $dbproformachoisit;
        $this->view->detailsproformachoisitavaliderparlatechopoleapreslegerant = $dbdetailsproformachoisit;
    }

    public function listedesproformaavaliderparlatechnopoleapreslafiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_fournisseur_choisit.selection_fournisseur = 1
        AND eu_proforma_procedure.valid_down = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondesproformachoisitavaliderparlatechnopoleapreslafiliere = $stmt->fetchAll(); 
        $this->view->listedereceptiondesproformachoisitavaliderparlatechnopoleapreslafiliere  = $dblistedereceptiondesproformachoisitavaliderparlatechnopoleapreslafiliere;
    }


    public function editvaliderlafactureproformachoisitparlatechnopoleapreslafiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');

        $db = Zend_Db_Table::getDefaultAdapter();

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT *
                         FROM eu_proforma_procedure, eu_fournisseur_choisit
                         WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                         AND eu_proforma_procedure.id_proforma ='$id'
                         AND eu_fournisseur_choisit.selection_fournisseur = 1
                         AND eu_proforma_procedure.valid_down = 1";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidduproforma = $stmt->fetchAll();
            if (count($dbrecherchedelidduproforma) == 0) {
                http_response_code(403);
                die('Désolé mais ce proforma n\'a pas encore été établit');
            }
        }

        $dbverifselect = "SELECT
                             eu_fournisseur_choisit.code_membre_fournisseur,
                             eu_proforma_procedure.numero_proforma,
                             eu_proforma_procedure.date_proforma,
                             eu_proforma_procedure.montant_ht,
                             eu_proforma_procedure.montant_ttc,
                             eu_proforma_procedure.date_paie,
                             eu_proforma_procedure.date_livraison,
                             eu_proforma_procedure.addresse_livraison,
                             eu_proforma_procedure.modalite_paiement,
                             eu_proforma_procedure.id_proforma,                   
                             eu_fournisseur_choisit.code_membre_fournisseur,
                             eu_fournisseur_choisit.libelle_fournisseur,
                             eu_demande_achat.libelle_demande_achat,
                             eu_demande_achat.reference_demande_achat
                   
                          FROM eu_proforma_procedure, eu_fournisseur_choisit, eu_demande_achat
                          WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                          AND eu_proforma_procedure.id_demande_achat = eu_demande_achat.id_demande_achat
                          AND eu_fournisseur_choisit.selection_fournisseur = 1
                          AND eu_proforma_procedure.id_proforma = $id
                          AND eu_proforma_procedure.valid_down = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbproformachoisit = $stmt->fetchAll(); 

        $dbiddetailsproformachoisit = $dbproformachoisit[0]->id_proforma;
        
        $dbverifselect = "SELECT
                            eu_detail_proforma_procedure.quantite_disponible_produit,
                            eu_detail_proforma_procedure.prix_unitaire_fournisseur,
                            eu_detail_proforma_procedure.total_article
                            eu_detail_proforma_procedure.disponibilite_demande
        
                         FROM eu_detail_proforma_procedure
                         WHERE eu_detail_proforma_procedure.id_proforma_procedure = $dbiddetailsproformachoisit";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbdetailsproformachoisit = $stmt->fetchAll(); 
        $this->view->proformachoisitavaliderparlatechopoleapreslafiliere = $dbproformachoisit;
        $this->view->detailsproformachoisitavaliderparlatechopoleapreslafiliere = $dbdetailsproformachoisit;
    }

    public function ajaxfactureproformatechnopoleapresfiliereAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            try {
                $current_id = $_POST['idproformatechnopoleapreslafiliere'];
                $db = Zend_Db_Table::getDefaultAdapter();
                $created = Zend_Date::now();

               /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/

                $resultjson = array();
                $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
                $dbtselect = "UPDATE eu_proforma
                      SET valid_down = 2                     
                      WHERE  id_proforma = $current_id"; 
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $resultjson = array(
                  'update'=>'Validation avec succes'
                );
            } catch (Exception $e) {
                $errormessage = $e->getMessage();
                $resultjson = array(
                  'errorjson'=>$errormessage,
                );
            }
                header('Content-type:application/json');
                die(json_encode($resultjson));
      }
    }


    public function ajaxfactureproformatechnopoleapreslegerantAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            try {
                $current_id = $_POST['idproformatechnopoleapreslegerant'];
                $db = Zend_Db_Table::getDefaultAdapter();
                $created = Zend_Date::now();

               /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/

                $resultjson = array();
                $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
                $dbtselect = "UPDATE eu_proforma
                      SET valid_down = 4                     
                      WHERE  id_proforma = $current_id"; 
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $resultjson = array(
                  'update'=>'Validation avec succes'
                );
            } catch (Exception $e) {
                $errormessage = $e->getMessage();
                $resultjson = array(
                  'errorjson'=>$errormessage,
                );
            }
                header('Content-type:application/json');
                die(json_encode($resultjson));
      }
    }


    public function ajaxprocesverbaletechnopoleapresfiliereAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            try {
                $current_id = $_POST['idprocesverbaletechnopoleapreslafiliere'];
                $db = Zend_Db_Table::getDefaultAdapter();
                $created = Zend_Date::now();

               /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/

                $resultjson = array();
                $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
                $dbtselect = "UPDATE eu_proces_verbale
                      SET valid_down = 2                     
                      WHERE  id_proces_verbale = $current_id"; 
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $resultjson = array(
                  'update'=>'Validation avec succes'
                );
            } catch (Exception $e) {
                $errormessage = $e->getMessage();
                $resultjson = array(
                  'errorjson'=>$errormessage,
                );
            }
                header('Content-type:application/json');
                die(json_encode($resultjson));
      }
    }

    public function ajaxprocesverbaletechnopoleapresgerantAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            try {
                $current_id = $_POST['idprocesverbaletechnopoleapreslegerant'];
                $db = Zend_Db_Table::getDefaultAdapter();
                $created = Zend_Date::now();

               /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/

                $resultjson = array();
                $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
                $dbtselect = "UPDATE eu_proces_verbale
                      SET valid_down = 4                    
                      WHERE  id_proces_verbale = $current_id"; 
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $resultjson = array(
                  'update'=>'Validation avec succes'
                );
            } catch (Exception $e) {
                $errormessage = $e->getMessage();
                $resultjson = array(
                  'errorjson'=>$errormessage,
                );
            }
                header('Content-type:application/json');
                die(json_encode($resultjson));
      }
    }

    public function ajaxcommandevisatechnopoleapresfiliereAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            try {
                $current_id = $_POST['idcommandevisatechnopoleapreslafiliere'];
                $db = Zend_Db_Table::getDefaultAdapter();
                $created = Zend_Date::now();

               /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/

                $resultjson = array();
                $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
                $dbtselect = "UPDATE eu_commande
                      SET valider_down = 2                     
                      WHERE  id_bon_commande = $current_id"; 
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $resultjson = array(
                  'update'=>'Validation avec succes'
                );
            } catch (Exception $e) {
                $errormessage = $e->getMessage();
                $resultjson = array(
                  'errorjson'=>$errormessage,
                );
            }
                header('Content-type:application/json');
                die(json_encode($resultjson));
      }
    }

    public function ajaxcommandevalidationtechnopoleapreslegerantAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            try {
                $current_id = $_POST['idcommandetechnopoleapreslegerant'];
                $db = Zend_Db_Table::getDefaultAdapter();
                $created = Zend_Date::now();

               /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/

                $resultjson = array();
                $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
                $dbtselect = "UPDATE eu_commande
                      SET valider_down = 4                    
                      WHERE  id_bon_commande = $current_id"; 
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $resultjson = array(
                  'update'=>'Validation avec succes'
                );
            } catch (Exception $e) {
                $errormessage = $e->getMessage();
                $resultjson = array(
                  'errorjson'=>$errormessage,
                );
            }
                header('Content-type:application/json');
                die(json_encode($resultjson));
      }
    }

    public function ajaxvaliderlademandeachatparlatechnopoleapreslegerantAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            try {
                $current_id = $_POST['iddemandeachattechnopoleapreslegerant'];
                $db = Zend_Db_Table::getDefaultAdapter();
                $created = Zend_Date::now();

               /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/

                $resultjson = array();
                $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');
                $dbtselect = "UPDATE eu_demande_achat
                      SET valider_down = 7                    
                      WHERE  id_demande_achat = $current_id"; 
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbtselect);
                $resultjson = array(
                  'update'=>'Validation avec succes'
                );
            } catch (Exception $e) {
                $errormessage = $e->getMessage();
                $resultjson = array(
                  'errorjson'=>$errormessage,
                );
            }
                header('Content-type:application/json');
                die(json_encode($resultjson));
      }        
    }

    public function detaildelafactureproformachoisitAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');

        $db = Zend_Db_Table::getDefaultAdapter();

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT * FROM eu_proforma_procedure WHERE id_proforma ='$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidduproforma = $stmt->fetchAll();
            if (count($dbrecherchedelidduproforma) == 0) {
                http_response_code(403);
                die('Désolé mais ce proforma n\'a pas encore été établit');
            }
        }

        $dbverifselect = "SELECT
                             eu_fournisseur_choisit.code_membre_fournisseur,
                             eu_proforma_procedure.numero_proforma,
                             eu_proforma_procedure.date_proforma,
                             eu_proforma_procedure.montant_ht,
                             eu_proforma_procedure.montant_ttc,
                             eu_proforma_procedure.date_paie,
                             eu_proforma_procedure.date_livraison,
                             eu_proforma_procedure.addresse_livraison,
                             eu_proforma_procedure.modalite_paiement,
                             eu_proforma_procedure.id_proforma,                   
                             eu_fournisseur_choisit.code_membre_fournisseur,
                             eu_fournisseur_choisit.libelle_fournisseur,
                             eu_demande_achat.libelle_demande_achat,
                             eu_demande_achat.reference_demande_achat
                   
                          FROM eu_proforma_procedure, eu_fournisseur_choisit, eu_demande_achat
                          WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                          AND eu_proforma_procedure.id_demande_achat = eu_demande_achat.id_demande_achat
                          AND eu_fournisseur_choisit.selection_fournisseur = 1
                          AND eu_proforma_procedure.id_proforma = $id";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbproformachoisit = $stmt->fetchAll(); 

        $dbiddetailsproformachoisit = $dbproformachoisit[0]->id_proforma;
        
        $dbverifselect = "SELECT
                            eu_detail_proforma_procedure.quantite_disponible_produit,
                            eu_detail_proforma_procedure.prix_unitaire_fournisseur,
                            eu_detail_proforma_procedure.total_article
                            eu_detail_proforma_procedure.disponibilite_demande
        
                         FROM eu_detail_proforma_procedure
                         WHERE eu_detail_proforma_procedure.id_proforma_procedure = $dbiddetailsproformachoisit";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dbdetailsproformachoisit = $stmt->fetchAll(); 
        $this->view->proformachoisit = $dbproformachoisit;
        $this->view->detailsproformachoisit = $dbdetailsproformachoisit;
        
    }

    
    public function editiondespropositionsdesfournisseurschoisitsousformedproformaAction () {
        /***Redirection vers la listedesreceptionsdespropositionsdesfournisseurschoisitsousformedeproforma */
        /****Informations sur le fournisseur et Informations sur le Demandeur
         * Informations sur le proforma
         * 
         * 
         */
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $created = Zend_Date::now();        
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
        $sessionmembre = new Zend_Session_Namespace('membre');
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbverifid = " SELECT eu_proforma_procedure.id_proforma
            FROM eu_proforma_procedure
            WHERE eu_proforma_procedure.id_proforma = '$id'
            AND eu_proforma_procedure.valid_down = 1";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationdelavaliditedeidproforma = $stmt->fetchAll();
            $countdbverificationdelavaliditedeidproforma = count($dbverificationdelavaliditedeidproforma);
    
            if($countdbverificationdelavaliditedeidproforma === 0){
                http_response_code(403);
                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
            }
        }
        $dbverifid = " SELECT 
                    eu_proforma_procedure.id_proforma,
                    eu_proforma_procedure.id_fournisseur_choisit,
                    eu_proforma_procedure.numero_proforma,
                    eu_proforma_procedure.id_demande_achat,
                    eu_proforma_procedure.montant_ht,
                    eu_proforma_procedure.montant_ttc,
                    eu_proforma_procedure.tva,
                    eu_proforma_procedure.date_proforma,
                    eu_proforma_procedure.date_paie,
                    eu_proforma_procedure.date_livraison,
                    eu_proforma_procedure.addresse_livraison,
                    eu_proforma_procedure.modalite_paiement,
                    eu_fournisseur_choisit.code_membre_fournisseur,
                    eu_fournisseur_choisit.id_fournisseur_choisit
                   FROM eu_proforma_procedure, eu_fournisseur_choisit
                   WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                   AND eu_proforma_procedure.id_proforma = '$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifid);
        $dbeditiondelafactureproforma = $stmt->fetchAll();
        if(count($dbeditiondelafactureproforma) === 1){
             $id_demande_achat_facture_proforma = $dbeditiondelafactureproforma[0]->id_demande_achat;
             $code_membre_fournisseur = $dbeditiondelafactureproforma[0]->code_membre_fournisseur;
             $id_proforma = $dbeditiondelafactureproforma[0]->id_proforma;
             /***Recupération des détails de la facture proforma */
            $dbverifid = " SELECT *
            FROM eu_detail_proforma_procedure as dpp
            WHERE dpp.id_proforma_procedure ='$id_proforma'";
            $db->setFetchMode(Zend_DbZend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbrecuperationdesdetailsdelafactureproforma = $stmt->fetchAll(); 
            
             /***Recuperation du code membre du representant */

            $dbverifid = " SELECT  eu_representation.code_membre
            FROM eu_representation
            WHERE eu_representation.code_membre_morale='$code_membre_fournisseur'
            AND eu_representation.etat='inside'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbrecuperationducodemembredurepresentant = $stmt->fetchAll(); 
            $code_membre_representant = $dbrecuperationducodemembredurepresentant[0]->code_membre;

            /***Recuperation des informations du representant */


            $dbverifid = " SELECT eu_membre.code_membre, eu_membre.nom_membre, eu_membre.prenom_membre
            FROM eu_membre
            WHERE eu_membre.code_membre='$code_membre_representant'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbrecuperationdesinformationsdurepresentant = $stmt->fetchAll(); 

            /***Recuperation des informations du membre morale */
            $dbverifid = " SELECT 
                          eu_membre_morale.code_membre_morale,
                          eu_membre_morale.domaine_activite,
                          eu_membre_morale.num_registre_membre,
                          eu_membre_morale.raison_sociale
            FROM eu_membre_morale
            WHERE eu_membre_morale.code_membre_morale='$code_membre_fournisseur'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbrecuperationdesinformations = $stmt->fetchAll(); 

             $dbverifid = " SELECT  eu_demande_achat.id_demande_achat,
             eu_demande_achat.montant_demande_achat,
             eu_demande_achat.libelle_demande_achat,
             eu_demande_achat.reference_demande_achat,
             eu_demande_achat.code_membre,
             eu_demande_achat.visatechfiliere,
             eu_demande_achat.date_demande,
             eu_demande_achat.datevisatechfiliere
             FROM eu_demande_achat
             WHERE eu_demande_achat.id_demande_achat = '$id_demande_achat_facture_proforma'";
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbverifid);
             $dbrecuperationdesinformationsdelademadeachatapartirdeid = $stmt->fetchAll(); 
             $code_membre_demandeur_achat =  $dbrecuperationdesinformationsdelademadeachatapartirdeid[0]->code_membre;


             $dbverifid = " SELECT eu_membre.code_membre, eu_membre.nom_membre, eu_membre.prenom_membre,eu_membre.portable_membre
             FROM eu_membre
             WHERE eu_membre.code_membre='$code_membre_demandeur_achat'";
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbverifid);
             $dbrecuperationdesinformationsdudemandeur = $stmt->fetchAll(); 


             $dbverifid = " SELECT 
                            eu_detail_demande_achat.reference_article,
                            eu_detail_demande_achat.designation_article,
                            eu_detail_demande_achat.quantite,
                            eu_detail_demande_achat.prix_unitaire
                            FROM eu_detail_demande_achat
                            WHERE eu_detail_demande_achat.id_demande_achat = '$id_demande_achat_facture_proforma'";
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbverifid);
             $dbrecuperationdesdetailsdelademadeachatapartirdeid = $stmt->fetchAll(); 
             $this->view->dbrecuperationdesdetailsdelademadeachatapartirdeid = $dbrecuperationdesdetailsdelademadeachatapartirdeid;
             $this->view->dbeditiondelafactureproforma = $dbeditiondelafactureproforma;
             $this->view->dbrecuperationducodemembredurepresentant = $dbrecuperationducodemembredurepresentant;
             $this->view->dbrecuperationdesinformationsdurepresentant = $dbrecuperationdesinformationsdurepresentant;
             $this->view->dbrecuperationdesinformations = $dbrecuperationdesinformations;
             $this->view->dbrecuperationdesinformationsdelademadeachatapartirdeid = $dbrecuperationdesinformationsdelademadeachatapartirdeid;
             $this->view->dbrecuperationdesinformationsdudemandeur = $dbrecuperationdesinformationsdudemandeur;
        
        }
    }

    public function etablissementdutableaucomparatifdespropositionsdechaquefournisseursAction () {
       /***Sur l'interface, Mettre en place la selection des fournisseurs
        * Mettre aussi le procès verbale
        Enregistre le fournisseur choisit et le proces verbal dans la table procesverbalfournisseurchoisit
        */
        
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $created = Zend_Date::now();        
        $date_proces_verbale =  $created->toString('yyyy-MM-dd HH:mm:ss');
        $sessionmembre = new Zend_Session_Namespace('membre');
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbverifid = " SELECT eu_demande_achat.id_demande_achat
            FROM eu_demande_achat
            WHERE eu_demande_achat.id_demande_achat = '$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationdelavaliditedeiddemandeachat = $stmt->fetchAll();
            $countdbverificationdelavaliditedeiddemandeachat = count($dbverificationdelavaliditedeiddemandeachat);
    
            if( $countdbverificationdelavaliditedeiddemandeachat === 0){
                http_response_code(403);
                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
            }
        }
        $dbverifid = " SELECT 
                    eu_proforma_procedure.numero_proforma,
                    eu_proforma_procedure.montant_ht,
                    eu_proforma_procedure.montant_ttc,
                    eu_proforma_procedure.tva,
                    eu_proforma_procedure.date_proforma,
                    eu_proforma_procedure.date_paie,
                    eu_proforma_procedure.date_livraison,
                    eu_proforma_procedure.addresse_livraison,
                    eu_proforma_procedure.modalite_paiement,
                    eu_fournisseur_choisit.id_fournisseur_choisit,
                    eu_membre_morale.raison_sociale,
                    eu_proforma_procedure.id_proforma
                   FROM 
                   eu_proforma_procedure,
                   eu_fournisseur_choisit,
                   eu_membre_morale
                   WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                   AND eu_membre_morale.code_membre_morale = eu_fournisseur_choisit.code_membre_fournisseur
                   AND eu_proforma_procedure.id_demande_achat = '$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifid);
        $dbeditiondelafactureproforma = $stmt->fetchAll();

        $dbverifid = " SELECT 
                    eu_detail_proforma_procedure.quantite_disponible_produit,
                    eu_detail_proforma_procedure.prix_unitaire_fournisseur,
                    eu_detail_proforma_procedure.total_article,
                    eu_detail_proforma_procedure.disponibilite_demande,
                    eu_detail_proforma_procedure.id_proforma_procedure
                    
                   FROM 
                   eu_proforma_procedure,
                   eu_detail_proforma_procedure
                   WHERE eu_proforma_procedure.id_proforma = eu_detail_proforma_procedure.id_proforma_procedure";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifid);
        $dbeditiondesdetailsdelafactureproforma = $stmt->fetchAll();


        if(count($dbeditiondelafactureproforma) !== 0){

             $dbverifid = " SELECT  eu_demande_achat.id_demande_achat,
             eu_demande_achat.montant_demande_achat,
             eu_demande_achat.libelle_demande_achat,
             eu_demande_achat.reference_demande_achat,
             eu_demande_achat.code_membre,
             eu_demande_achat.visatechfiliere,
             eu_demande_achat.date_demande,
             eu_demande_achat.datevisatechfiliere
             FROM eu_demande_achat
             WHERE eu_demande_achat.id_demande_achat = '$id'";
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbverifid);
             $dbrecuperationdesinformationsdelademadeachatapartirdeid = $stmt->fetchAll(); 
             $code_membre_demandeur_achat =  $dbrecuperationdesinformationsdelademadeachatapartirdeid[0]->code_membre;

             $dbverifid = " SELECT 
                            eu_detail_demande_achat.reference_article,
                            eu_detail_demande_achat.designation_article,
                            eu_detail_demande_achat.quantite,
                            eu_detail_demande_achat.prix_unitaire
                            FROM eu_detail_demande_achat
                            WHERE eu_detail_demande_achat.id_demande_achat = '$id'";
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbverifid);
             $dbrecuperationdesdetailsdelademadeachatapartirdeid = $stmt->fetchAll(); 
             $this->view->dbrecuperationdesdetailsdelademadeachatapartirdeid = $dbrecuperationdesdetailsdelademadeachatapartirdeid;
             $this->view->dbeditiondelafactureproforma = $dbeditiondelafactureproforma;
             $this->view->dbrecuperationdesinformationsdelademadeachatapartirdeid = $dbrecuperationdesinformationsdelademadeachatapartirdeid;
             $this->view->dbeditiondesdetailsdelafactureproforma = $dbeditiondesdetailsdelafactureproforma;
        }

        if ($request->isPost()) {
            $id_fournisseur_choisit = $_POST['id_fournisseur_choisit'];  
            $id_proforma = $_POST['id_proforma']; 
            $contenu_proces_verbale = $_POST['contenu_proces_verbale'];
            $proces_verbale_file_name = $_FILES['proces_verbale_files']['name'];
            $proces_verbale_file_type = $_FILES['proces_verbale_files']['type'];
            $proces_verbale_file_tmp_name = $_FILES['proces_verbale_files']['tmp_name'];
            $proces_verbale_file_error = $_FILES['proces_verbale_files']['error'];
            $proces_verbale_file_size = $_FILES['proces_verbale_files']['size'];            


            if ($id_fournisseur_choisit == ""){
                $validationerrors['empty_fournisseur_choisit'] = "le proces verbale ne doit pas être vide";
            }
      
            if(!isset($id_fournisseur_choisit)) {
                $validationerrors['exist_fournisseur_choisit'] = "le proces verbale est inexistant";          
            }

            
            if ($proces_verbale_file_name == ""){
                $validationerrors['empty_proces_verbale_file_name'] = "le nom du fichier proforma joint ne doit pas être vide";
            }

            if ($proces_verbale_file_type == ""){
                $validationerrors['empty_proces_verbale_file_type'] = "le type du fichier proforma joint ne doit pas être vide";
            }

            if ($proces_verbale_file_tmp_name == ""){
                $validationerrors['empty_proces_verbale_file_tmp_name'] = "le nom du fichier proforma joint ne doit pas être vide";
            }

            if ($proces_verbale_file_error > 0){
                $validationerrors['empty_proces_verbale_file_error'] = "Impossible d'envoyé le proces verbale:il y a erreur dans l'envoi du proces";
            }

            if ($proces_verbale_file_size == ""){
                $validationerrors['empty_proces_verbale_file_size'] = "Impossible d'envoyé le proces verbale:la taille du fichier ne doit pas être vide";
            }

            if(!in_array($proces_verbale_file_type,array('application/pdf'))){
                $validationerrors['error_proces_verbale_file_size'] = "Impossible d'envoyé le proces verbale:Ce type de fichier n'est pas autorisé";

            }

            if ($id_proforma == ""){
                $validationerrors['empty_proforma'] = "l'id du proforma du fournisseur choisit ne doit pas être vide";
            }
      
            if(!isset($id_proforma)) {
                $validationerrors['exist_proforma'] = "le proforma est inexistant";          
            }

            if($id_fournisseur_choisit !== ""){
                if(!filter_var($id_fournisseur_choisit, FILTER_VALIDATE_REGEXP,
                   array("options"=>array("regexp"=>"#[0-9]#")))){
                   $validationerrors['verif_fournisseur_choisit'] = "Erreur au niveau de l'id du fournisseur choisit:vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";
                 }
            }

            if ($contenu_proces_verbale == ""){
               $validationerrors['empty_contenu_proces_verbale'] = "le proces verbale ne doit pas être vide";
            }
      
            if(!isset($contenu_proces_verbale)) {
              $validationerrors['exist_contenu_proces_verbale'] = "le proces verbale est inexistant";          
            }

                
            if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
            } 


            if(empty($validationerrors)){

                    $dbfselect = "SELECT eu_proces_verbale.id_proces_verbale
                                  FROM eu_proces_verbale 
                                  WHERE eu_proces_verbale.id_fournisseur_choisit='$id_fournisseur_choisit'
                                  AND eu_proces_verbale.id_proforma = '$id_proforma'";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfselect); 
                    $dbsearchbudgetnature = $stmt->fetchAll();
                    if(count($dbsearchbudgetnature) == 0){
                        $ref_proces_verbale = substr(md5(uniqid(rand(),true)),0,8);
                        
                        $dbfinsert = "INSERT INTO eu_proces_verbale(
                            reference_proces_verbale,                            
                            contenu_proces_verbale,
                            id_fournisseur_choisit,
                            id_proforma,
                            date_proces_verbale) VALUES (
                           '$ref_proces_verbale',                                
                           '$contenu_proces_verbale',
                           '$id_fournisseur_choisit',
                           '$id_proforma',
                           '$date_proces_verbale')";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbfinsert);

                        $dbfselect = "SELECT eu_proces_verbale.id_proces_verbale
                                      FROM eu_proces_verbale 
                                      WHERE eu_proces_verbale.id_fournisseur_choisit='$id_fournisseur_choisit'
                                      AND eu_proces_verbale.id_proforma = '$id_proforma'
                                      AND eu_proces_verbale.contenu_proces_verbale = '$contenu_proces_verbale'";
                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                        $stmt = $db->query($dbfselect); 
                        $dbsearchprocesverbaleinserer = $stmt->fetchAll();

                        if(count($dbsearchprocesverbaleinserer) !== 0){
                             $idsearchprocesverbaleinserer = $dbsearchprocesverbaleinserer[0]->id_proces_verbale;
                    
                            $ref_proces_verbale = substr(md5(uniqid(rand(),true)),0,8);
                            $real_ref_proces_verbale= strtoupper($ref_proces_verbale.'-'.$idsearchprocesverbaleinserer);
                            $real_ref_proces_verbale= $real_ref_proces_verbale.'.pdf';
                            
                            
                            $newFilePath = "../../webfiles/proces_verbale_procedure_achat"."/".$real_ref_proces_verbale;


                            $dbtselect = "UPDATE eu_proces_verbale
                                        SET files_url ='$real_ref_proces_verbale', choix = 1, valid_down = 1
                                        WHERE id_proces_verbale= $idsearchprocesverbaleinserer"; 
                            $db->setFetchMode(Zend_Db::FETCH_OBJ);
                            $stmt = $db->query($dbtselect);   

                            $dbtselect = "UPDATE eu_fournisseur_choisit
                            SET selection_fournisseur = 1
                            WHERE id_fournisseur_choisit='$id_fournisseur_choisit'"; 
                            $db->setFetchMode(Zend_Db::FETCH_OBJ);
                            $stmt = $db->query($dbtselect); 
                            
                            move_uploaded_file($proces_verbale_file_tmp_name, $newFilePath);
                        }
        
                    }

                }
            }
    }


    public function lalistedetouslesprocesverbalesAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }

        $dbtselect = "SELECT 
                       eu_proces_verbale.id_proces_verbale,
                       eu_proces_verbale.reference_proces_verbale,
                       eu_proces_verbale.files_url,
                       eu_proces_verbale.date_proces_verbale
                       FROM eu_proces_verbale";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesprocesverbale = $stmt->fetchAll();
        $this->view->lalistedetouslesprocesverbale = $dblalistedetouslesprocesverbale;
        $this->view->domaine = $domaine;
        

    }

    public function lalistedetouslesprocesverbalesquisontvaliderparlatechnopolefiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }

        $dbtselect = "SELECT 
                       eu_proces_verbale.id_proces_verbale,
                       eu_proces_verbale.reference_proces_verbale,
                       eu_proces_verbale.files_url,
                       eu_proces_verbale.date_proces_verbale
                       FROM eu_proces_verbale
                       AND eu_proces_verbale.valid_down = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesprocesverbalevaliderparlatechnopolefiliere = $stmt->fetchAll();
        $this->view->lalistedetouslesprocesverbalevaliderparlatechnopolefiliere = $dblalistedetouslesprocesverbalevaliderparlatechnopolefiliere;
        $this->view->domaine = $domaine;
    
    }
    

    public function lalistedetouslesprocesverbalesquisontvaliderparlatechnopoleapreslafiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }

        $dbtselect = "SELECT 
                       eu_proces_verbale.id_proces_verbale,
                       eu_proces_verbale.reference_proces_verbale,
                       eu_proces_verbale.files_url,
                       eu_proces_verbale.date_proces_verbale
                       FROM eu_proces_verbale
                       AND eu_proces_verbale.valid_down = 2";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesprocesverbalevaliderparlatechnopoleapreslafiliere = $stmt->fetchAll();
        $this->view->lalistedetouslesprocesverbalevaliderparlatechnopoleapreslafiliere = $dblalistedetouslesprocesverbalevaliderparlatechnopoleapreslafiliere;
        $this->view->domaine = $domaine;
    
    }

    public function lalistedetouslesprocesverbalesavaliderparlatechnopoleapreslafiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }

        $dbtselect = "SELECT 
                       eu_proces_verbale.id_proces_verbale,
                       eu_proces_verbale.reference_proces_verbale,
                       eu_proces_verbale.files_url,
                       eu_proces_verbale.date_proces_verbale
                       FROM eu_proces_verbale
                       AND eu_proces_verbale.valid_down = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesprocesverbaleavaliderparlatechnopoleapreslafiliere = $stmt->fetchAll();
        $this->view->lalistedetouslesprocesverbaleavaliderparlatechnopoleapreslafiliere = $dblalistedetouslesprocesverbaleavaliderparlatechnopoleapreslafiliere;
        $this->view->domaine = $domaine;        
    }

    public function lalistedetouslesprocesverbalesquisontvaliderparlegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }

        $dbtselect = "SELECT 
                       eu_proces_verbale.id_proces_verbale,
                       eu_proces_verbale.reference_proces_verbale,
                       eu_proces_verbale.files_url,
                       eu_proces_verbale.date_proces_verbale
                       FROM eu_proces_verbale
                       AND eu_proces_verbale.valid_down = 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesprocesverbalevaliderparlegerant = $stmt->fetchAll();
        $this->view->lalistedetouslesprocesverbalevaliderparlegerant = $dblalistedetouslesprocesverbalevaliderparlegerant;
        $this->view->domaine = $domaine;
        

    }

    public function lalistedetouslesprocesverbalesavaliderparlatechnopoleapreslegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }

        $dbtselect = "SELECT 
                       eu_proces_verbale.id_proces_verbale,
                       eu_proces_verbale.reference_proces_verbale,
                       eu_proces_verbale.files_url,
                       eu_proces_verbale.date_proces_verbale
                       FROM eu_proces_verbale
                       AND eu_proces_verbale.valid_down = 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblalistedetouslesprocesverbalevaliderparlatechnopoleapreslegerant = $stmt->fetchAll();
        $this->view->lalistedetouslesprocesverbalevaliderparlatechnopoleapreslegerant = $dblalistedetouslesprocesverbalevaliderparlatechnopoleapreslegerant;
        $this->view->domaine = $domaine;
        

    }

    public function listedesproformaquisontvaliderparlegerantetreceptionnerparlatechnopoleAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $dbverifselect = "SELECT
                   eu_fournisseur_choisit.code_membre_fournisseur,
                   eu_proforma_procedure.id_proforma,
                   eu_proforma_procedure.numero_proforma,
                   eu_proforma_procedure.date_proforma
        FROM eu_proforma_procedure, eu_fournisseur_choisit
        WHERE eu_proforma_procedure.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_fournisseur_choisit.selection_fournisseur = 1
        AND eu_proforma_procedure.valid_down = 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifselect);
        $dblistedereceptiondesproformachoisitvaliderparlegerant = $stmt->fetchAll(); 
        $this->view->listedereceptiondesproformachoisitvaliderparlegerant = $dblistedereceptiondesproformachoisitvaliderparlegerant;
    }

    public function editvaliderleprocesverbaleparlatechnopoleapreslafiliereAction () {
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        
        $db = Zend_Db_Table::getDefaultAdapter();

        $id = (int)$this->_request->getParam('id');

        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }
        
          if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT * FROM eu_proces_verbale WHERE eu_proces_verbale.id_proces_verbale ='$id' AND eu_proces_verbale.valid_down = 1";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidduproforma = $stmt->fetchAll();
            if (count($dbrecherchedelidduproforma) == 0) {
                http_response_code(403);
                die('Désolé mais ce proforma n\'a pas encore été établit');
            }
        }

        $dbtselect = "SELECT 
                        eu_proces_verbale.id_proces_verbale,
                        eu_proces_verbale.reference_proces_verbale,
                        eu_proces_verbale.files_url,
                        eu_proces_verbale.contenu_proces_verbale,
                        eu_proces_verbale.date_proces_verbale,
                        eu_fournisseur_choisit.libelle_fournisseur,
                        eu_proforma_procedure.numero_proforma
                      FROM eu_proces_verbale,eu_fournisseur_choisit,eu_proforma_procedure
                      WHERE eu_proces_verbale.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                      AND eu_proces_verbale.id_proforma = eu_proforma_procedure.id_proforma
                      AND eu_proces_verbale.id_proces_verbale = '$id'
                      AND eu_proces_verbale.valid_down = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbdetaildunprocesverbalepourlatechnopoleapreslafiliere = $stmt->fetchAll();
        $this->view->detaildunprocesverbalepourlatechnopoleapreslafiliere = $dbdetaildunprocesverbalepourlatechnopoleapreslafiliere;
        $this->view->domaine = $domaine;

    }


    public function editvaliderleprocesverbaleparlatechnopoleunedeuxiemefoisAction () {
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        
        $db = Zend_Db_Table::getDefaultAdapter();

        $id = (int)$this->_request->getParam('id');

        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }
        
          if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT *
                         FROM eu_proces_verbale
                         WHERE eu_proces_verbale.id_proces_verbale ='$id'
                         AND eu_proces_verbale.valid_down = 3";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidduproforma = $stmt->fetchAll();
            if (count($dbrecherchedelidduproforma) == 0) {
                http_response_code(403);
                die('Désolé mais ce proforma n\'a pas encore été établit');
            }
        }

        $dbtselect = "SELECT 
                        eu_proces_verbale.id_proces_verbale,
                        eu_proces_verbale.reference_proces_verbale,
                        eu_proces_verbale.files_url,
                        eu_proces_verbale.contenu_proces_verbale,
                        eu_proces_verbale.date_proces_verbale,
                        eu_fournisseur_choisit.libelle_fournisseur,
                        eu_proforma_procedure.numero_proforma
                      FROM eu_proces_verbale,eu_fournisseur_choisit,eu_proforma_procedure
                      WHERE eu_proces_verbale.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
                      AND eu_proces_verbale.id_proforma = eu_proforma_procedure.id_proforma
                      AND eu_proces_verbale.id_proces_verbale = '$id'
                      AND eu_proces_verbale.valid_down = 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbdetaildunprocesverbalepourlatechnopoleapreslegerant = $stmt->fetchAll();
        $this->view->detaildunprocesverbalepourlatechnopoleapreslegerant = $dbdetaildunprocesverbalepourlatechnopoleapreslegerant;
        $this->view->domaine = $domaine;

    }


    public function editiondesprocesverbaleassocieauxfournisseurchoisitAction () {
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        
        $db = Zend_Db_Table::getDefaultAdapter();

        $id = (int)$this->_request->getParam('id');

        if($_SERVER['SERVER_ADDR'] == "172.16.20.6") {
            $domaine = "http://webfiles.gacsource.net/";
          }else{
            $domaine = "http://webfiles.esmcgacsource.com/";
          }
        
          if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbselect = "SELECT * FROM eu_proces_verbale WHERE id_proces_verbale ='$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbselect);
            $dbrecherchedelidduproforma = $stmt->fetchAll();
            if (count($dbrecherchedelidduproforma) == 0) {
                http_response_code(403);
                die('Désolé mais ce proforma n\'a pas encore été établit');
            }
        }

        $dbtselect = "SELECT 
            eu_proces_verbale.id_proces_verbale,
            eu_proces_verbale.reference_proces_verbale,
            eu_proces_verbale.files_url,
            eu_proces_verbale.contenu_proces_verbale,
            eu_proces_verbale.date_proces_verbale,
            eu_fournisseur_choisit.libelle_fournisseur,
            eu_proforma_procedure.numero_proforma
        FROM eu_proces_verbale,eu_fournisseur_choisit,eu_proforma_procedure
        WHERE eu_proces_verbale.id_fournisseur_choisit = eu_fournisseur_choisit.id_fournisseur_choisit
        AND eu_proces_verbale.id_proforma = eu_proforma_procedure.id_proforma
        AND eu_proces_verbale.id_proces_verbale = '$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbdetaildunprocesverbale = $stmt->fetchAll();
        $this->view->detaildunprocesverbale = $dbdetaildunprocesverbale;
        $this->view->domaine = $domaine;
        
    }

    
    public function etablissementdubudgetpourlademandeachatAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $request = $this->getRequest();
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $id = (int)$this->_request->getParam('id');
        $created = Zend_Date::now();        
        $date_budget =  $created->toString('yyyy-MM-dd HH:mm:ss');

        $dbtselect = "SELECT * FROM  eu_bps_vendu_avr";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbbpsventereciproqueselect_all = $stmt->fetchAll();
    
        $dbselect = "SELECT * 
                     FROM eu_demande_achat
                     WHERE eu_demande_achat.id_demande_achat ='$id' 
                     AND eu_demande_achat.rejet = 1
                     AND eu_demande_achat.valider_down = 4
                     AND eu_demande_achat.visatechfiliere = 'ok'
                     AND eu_demande_achat.valider_up != 3
                     AND eu_demande_achat.livrer= 0";
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
        $this->view->id = $id;
        
        $code_membre_budgetavr = $_SESSION['utilisateur']['code_membre'];
        //$code_membre_budgetavr = "0010010010010000009P";
        if ($request->isPost()) {    
            $bps_vendu = $_POST['bps_vendu'];   
            $montant_budget = $_POST['montant_total_budget'];
            $type_budget = "DA";
            
            
            if ($_POST['bps_vendu'] == ""){
              $validationerrors['empty_bps_vendu'] = "le bps vendu ne doit pas être vide";
            }
    
            if(!isset($_POST['bps_vendu'])) {
                $validationerrors['exist_bps_vendu'] = "le bps vendu est inexistant";          
            }
    
    
            if($_POST['bps_vendu'] !== ""){
                if(!filter_var($_POST['bps_vendu'], FILTER_VALIDATE_REGEXP,
                   array("options"=>array("regexp"=>"#[0-9]#")))){
                   $validationerrors['verif_bps_vendu'] = "Erreur au niveau du bps vendu:vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";
                 }
            }

            if ($montant_budget == ""){
                $validationerrors['empty_bps_vendu'] = "le montant total du budget ne doit pas être vide";
              }
      
              if(!isset($montant_budget)) {
                  $validationerrors['exist_bps_vendu'] = "le montant total du budget est inexistant";          
              }

            if($montant_budget !== ""){
                if(!filter_var($montant_budget, FILTER_VALIDATE_REGEXP,
                   array("options"=>array("regexp"=>"#[0-9]#")))){
                   $validationerrors['verif_montant_budget'] = "Erreur au niveau du montant total du budget:vous tentez d'effectuer une action qui n'est pas autorisé sur la plateforme";
                 }
            }


    /*
    
            if ($type_budget == ""){
                $validationerrors['empty_type_budget'] = "le type du budget ne doit pas être vide";
            }
      
            if(!isset($type_budget)) {
                 $validationerrors['exist_type_budget'] = "le type du budget est inexistant";          
            }
    
            if ($type_budget == "DA"){
                $validationerrors['valide_type_budget'] = "le type du budget que vous avez selectionné doit être la demande d'achat";
            }
    */
         
    
            $dbtselect = "SELECT * FROM  eu_bps_vendu_avr WHERE eu_bps_vendu_avr.id_bps_vendu_achat_vente_reciproque='$bps_vendu'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtselect);
            $dbrecherchedubpsventereciproqueselect = $stmt->fetchAll();

            $dbfselect = "SELECT * FROM eu_forms_budget_nature WHERE reference_type_budget='$id' AND type_budget='$type_budget'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbfselect); 
            $dbsearchbudgetnature = $stmt->fetchAll();

            if (count($dbsearchbudgetnature) > 0) {
                $validationerrors['count_budget_nature'] = "Ce budget a été deja établit sur cette demande d'achat";        
            }
    
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

                if (!isset($_POST['bps_demande_avr'][$i])) {
                    $validationerrors['exist_bps_demande_avr'] = "le bps demandé est inexistant";
                }
        
                if ($_POST['qte_avr'][$i] == "") {
                    $validationerrors['empty_qte_avr'] = "la quantité n'est pas saisie";
                }

                if (!isset($_POST['qte_avr'][$i])) {
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

                if (!isset($_POST['prix_unitaire_avr'][$i])) {
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

                
                if (!isset($_POST['total_avr'][$i])) {
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
                $id_budget_demande_achat = $_POST["id_budget_demande_achat"];
                $dbfinsert = "INSERT INTO eu_forms_budget_nature(
                             id_bps_vendu_achat_vente_reciproque,
                             type_budget,
                             montant_budget,
                             reference_type_budget,
                             code_membre_budget,
                             date_budget) VALUES (
                            '$bps_vendu',
                            '$type_budget',
                            '$montant_budget',
                            '$id_budget_demande_achat',
                            '$code_membre_budgetavr',
                            '$date_budget'
                            )";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfinsert);

                
                $dbfselect = "SELECT id FROM eu_forms_budget_nature WHERE reference_type_budget='$id_budget_demande_achat' AND type_budget='$type_budget' ";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfselect);
                $recupidbudgetnature = $stmt->fetchAll();
                if (count($recupidbudgetnature) > 0) {
                    $id_budget_nature = $recupidbudgetnature[0]->id;
                  for ($i = 0; $i< count($_POST['bps_demande_avr']); $i++){
                    $bps_demande_avr = $_POST['bps_demande_avr'][$i];
                    $qte_avr = $_POST['qte_avr'][$i];
                    $prix_unitaire_avr = $_POST['prix_unitaire_avr'][$i];
                    $total_avr = $_POST['total_avr'][$i];
                    $disponible_avr = $_POST['disponible_avr'][$i];
                
                    $dbfinsert = "INSERT INTO eu_forms_detail_budget_nature(
                        id_forms_budget_nature,
                        qte_budget_nature,
                        prix_unitaire_budget_nature,
                        total_budget_nature,
                        disponible_budget_nature) VALUES (
                        '$id_budget_nature',
                        '$qte_avr',
                        '$prix_unitaire_avr',
                        '$total_avr',
                        '$disponible_avr')";
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    $stmt = $db->query($dbfinsert);
                    $validationsuccess['success_message'] = "Etablissement du budget pour cette demande d'achat a été effectué avec succes";
                    $_SESSION['validationsuccess'] = $validationsuccess;
                            
                    $this->_redirect('/procedureachat/listedesbudgetetablitenfonctiondelademandeachat');
                        
                   }
                }
            }
        }    
    }

    public function listedesbudgetetablitenfonctiondelademandeachatAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $code_membre_budgetavr = $_SESSION['utilisateur']['code_membre'];
        

        $dbselect = "SELECT
                      eu_forms_budget_nature.montant_budget,
                      eu_forms_budget_nature.payer,
                      eu_forms_budget_nature.date_budget,
                      eu_forms_budget_nature.id,
                      eu_demande_achat.reference_demande_achat,
                      eu_demande_achat.libelle_demande_achat
                     FROM eu_forms_budget_nature, eu_demande_achat
                     WHERE eu_forms_budget_nature.reference_type_budget = eu_demande_achat.id_demande_achat
                     AND eu_forms_budget_nature.code_membre_budget ='$code_membre_budgetavr'
                     AND eu_forms_budget_nature.type_budget ='DA'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dblalistedetouslesbudgetselonlecodemembre = $stmt->fetchAll();
        $this->view->listedetouslesbudgetselonlecodemembre = $dblalistedetouslesbudgetselonlecodemembre;

    }

    public function editiondesbudgetetablitenfonctiondelademandeachatAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        //$code_membre_budgetavr = "0010010010010000009P";
        $code_membre_budgetavr = $_SESSION['utilisateur']['code_membre'];
        
        $dbselect = "SELECT
                eu_forms_budget_nature.montant_budget,
                eu_forms_budget_nature.id,
                eu_forms_budget_nature.payer,
                eu_forms_budget_nature.date_budget,
                eu_demande_achat.reference_demande_achat,
                eu_demande_achat.libelle_demande_achat
                FROM eu_forms_budget_nature, eu_demande_achat
                WHERE eu_forms_budget_nature.reference_type_budget = eu_demande_achat.id_demande_achat
                AND eu_forms_budget_nature.code_membre_budget ='$code_membre_budgetavr'
                AND eu_forms_budget_nature.type_budget ='DA'
                AND eu_forms_budget_nature.id='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbbudgetselonlecodemembre = $stmt->fetchAll();
        $idbudget = $dbbudgetselonlecodemembre[0]->id;

        $dbselect = "SELECT
                       eu_forms_detail_budget_nature.qte_budget_nature,
                       eu_forms_detail_budget_nature.prix_unitaire_budget_nature,
                       eu_forms_detail_budget_nature.total_budget_nature,
                       eu_forms_detail_budget_nature.disponible_budget_nature 
        FROM eu_forms_detail_budget_nature
        WHERE eu_forms_detail_budget_nature.id_forms_budget_nature ='$idbudget'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbdetaildubudget = $stmt->fetchAll();
        $this->view->detaildubudget = $dbdetaildubudget;
        $this->view->budgetselonlecodemembre = $dbbudgetselonlecodemembre;
        
    }

    public function editviserlademandeachatparlegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

        $dbselect = "SELECT *
                     FROM eu_demande_achat
                     WHERE eu_demande_achat.id_demande_achat ='$id'
                     AND eu_demande_achat.valid_down = 5
                     AND eu_demande_achat.visatechfiliere ='ok'
                     AND eu_demande_achat.rejet = 1
                     AND eu_demande_achat.visagerant IS NULL
                     AND eu_demande_achat.livrer = 0";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandeachatgerant = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_demande_achat WHERE id_demande_achat ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdemandedetailachatgerant = $stmt->fetchAll();

  
        $this->view->entriesgerant = $dbsearchdemandeachatgerant;
        $this->view->detailachatgerant = $dbsearchdemandedetailachatgerant;
    }

    public function editviserlebondecommandeparlegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

        $dbselect = "SELECT *
                     FROM eu_bon_commande
                     WHERE eu_bon_commande.id_bon_commande ='$id'
                     AND eu_bon_commande.valider_down = 2
                     AND eu_bon_commande.visatechfiliere = 'ok'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommande = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_bon_commande WHERE id_bon_commande ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdetailbondecommande = $stmt->fetchAll();

        $iddemandeachatauniveaudubondecommande = $dbsearchbondecommande[0]->id_demande_achat;
  
        $this->view->entries = $dbsearchbondecommande;
        $this->view->detailbondecommande = $dbsearchdetailbondecommande;
    }

    public function editvaliderlebondecommandeparlatechnopoleapreslafiliereAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

        $dbselect = "SELECT *
                     FROM eu_bon_commande
                     WHERE eu_bon_commande.id_bon_commande ='$id'
                     AND eu_bon_commande.valider_down = 2
                     AND eu_bon_commande.visatechfiliere = 'ok'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeparlatechnopoleapreslafiliere = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_bon_commande WHERE id_bon_commande ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdetailbondecommandeparlatechnopoleapreslafiliere = $stmt->fetchAll();

        $iddemandeachatauniveaudubondecommande = $dbsearchbondecommandeparlatechnopoleapreslafiliere[0]->id_demande_achat;
  
        $this->view->entriesparlatechnopoleapreslafiliere = $dbsearchbondecommandeparlatechnopoleapreslafiliere;
        $this->view->detailbondecommandeparlatechnopoleapreslafiliere = $dbsearchdetailbondecommandeparlatechnopoleapreslafiliere;
    }

    public function editvaliderlebondecommandeparlatechnopoleapreslegerantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

        $dbselect = "SELECT *
                     FROM eu_bon_commande
                     WHERE eu_bon_commande.id_bon_commande ='$id'
                     AND eu_bon_commande.valider_down = 3
                     AND eu_bon_commande.visatechfiliere = 'ok'
                     AND eu_bon_commande.visagerant = 'ok'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbondecommandeparlatechnopoleapreslegerant = $stmt->fetchAll();

        $dbselect = "SELECT * FROM eu_detail_bon_commande WHERE id_bon_commande ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchdetailbondecommandeparlatechnopoleapreslegerant = $stmt->fetchAll();

        $iddemandeachatauniveaudubondecommande = $dbsearchbondecommandeparlatechnopoleapreslafiliere[0]->id_demande_achat;
  
        $this->view->entriesparlatechnopoleapreslegerant = $dbsearchdetailbondecommandeparlatechnopoleapreslegerant;
        $this->view->detailbondecommandeparlatechnopoleapreslegerant = $dbsearchdetailbondecommandeparlatechnopoleapreslegerant;
    }

    public function viserlebondecommandeparlegerantAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }
        $created = Zend_Date::now();
        
        $current_idgerant = $_POST['idbondecommandegerant'];
        $visatechfilieregerant = $_POST['visadubondecommandegerant'];
        $avistechfilieregerant = $_POST['avisdubondecommandegerant'];
        $db = Zend_Db_Table::getDefaultAdapter();
       /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/
        $resultjson = array();
        $date_createdgerant = $created->toString('yyyy-MM-dd HH:mm:ss');

        $dbselect = "SELECT 
                        eu_bon_commande.id_demande_achat,
                        eu_bon_commande.id_proforma_procedure
                     FROM eu_bon_commande
                     WHERE eu_bon_commande.id_bon_commande ='$current_idgerant'
                     AND eu_bon_commande.valider_down = 2
                     AND eu_bon_commande.visatechfiliere = 'ok'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchidbondecommande = $stmt->fetchAll();
        $iddemandeachat = $dbsearchidbondecommande[0]->id_demande_achat;
        $idproforma = $dbsearchidbondecommande[0]->id_proforma_procedure;
        


        $dbtselect = "UPDATE eu_proforma_procedure 
                      SET valider_down = 3
                      WHERE id_proforma = $idproforma"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);

        $dbtselect = "UPDATE eu_proces_verbale
                      SET valider_down = 3
                      WHERE id_proforma = $idproforma"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);

        $dbtselect = "UPDATE eu_bon_commande 
                      SET visatechfiliere ='$visatechfilieregerant',
                      avistechfiliere ='$avistechfilieregerant',
                      datevisatechfiliere ='$date_createdgerant',
                      valider_down = 3
                      WHERE  id_bon_commande= $current_idgerant"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $resultjson = array(
          'update'=>'Visa apposé avec succes'
        );
        header('Content-type:application/json');
        die(json_encode($resultjson));
    }


    public function viserlebondecommandeparagenttechnopoleoufiliereAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }
        $created = Zend_Date::now();
        
        $current_id = $_POST['idbondecommande'];
        $visatechfiliere = $_POST['visadubondecommande'];
        $avistechfiliere = $_POST['avisdubondecommande'];
        $db = Zend_Db_Table::getDefaultAdapter();
       /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/
        $resultjson = array();
        $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');

        $dbselect = "SELECT eu_bon_commande.id_demande_achat, eu_bon_commande.id_proforma_procedure
                     FROM eu_bon_commande
                     WHERE id_bon_commande ='$current_idgerant'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchidbondecommande = $stmt->fetchAll();
        $iddemandeachat = $dbsearchidbondecommande[0]->id_demande_achat;
        $idproforma = $dbsearchidbondecommande[0]->id_proforma_procedure;


        $dbtselect = "UPDATE eu_proforma_procedure 
                      SET valider_down = 1
                      WHERE id_proforma = $idproforma"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);

        $dbtselect = "UPDATE eu_proces_verbale
                    SET valider_down = 1
                    WHERE id_proforma = $idproforma"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);

        $dbtselect = "UPDATE eu_bon_commande 
                      SET visatechfiliere ='$visatechfiliere',
                      avistechfiliere ='$avistechfiliere',
                      datevisatechfiliere ='$date_created',
                      valider_down = 1
                      WHERE  id_bon_commande= $current_id"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $resultjson = array(
          'update'=>'Visa effectué avec succes'
        );
        header('Content-type:application/json');
        die(json_encode($resultjson));
    }

    public function rejetdelademandeachatAction () {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }
        $created = Zend_Date::now();
        
        $current_id = $_POST['idrejetdelademandeachat'];
        $db = Zend_Db_Table::getDefaultAdapter();
       /* $sessionutilisateur = new Zend_Session_Namespace('utilisateur');*/
        $resultjson = array();
        $date_created = $created->toString('yyyy-MM-dd HH:mm:ss');

        $dbtselect = "UPDATE eu_demande_achat SET rejet = 2 WHERE  id_demande_achat = $current_id"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $resultjson = array(
        'update'=>'La demande d\'achat a été rejeté avec success'
        );
        header('Content-type:application/json');
        die(json_encode($resultjson));
    }


}