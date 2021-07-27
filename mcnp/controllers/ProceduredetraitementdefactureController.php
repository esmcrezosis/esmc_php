<?php

class ProceduredetraitementdefactureController extends Zend_Controller_Action{
    


    public function etablissementdunefactureAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $request = $this->getRequest();
      $created = Zend_Date::now();

      $dbselect = "SELECT DISTINCT(eu_fournisseur_choisit.code_membre_fournisseur), eu_fournisseur_choisit.id_fournisseur_choisit, eu_membre_morale.raison_sociale
                   FROM eu_fournisseur_choisit, eu_membre_morale
                   WHERE eu_fournisseur_choisit.code_membre_fournisseur = eu_membre_morale.code_membre_morale";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbselect);
      $dblalistedesfournisseurschoisit = $stmt->fetchAll();
      $this->view->lalistedesfournisseurschoisit = $dblalistedesfournisseurschoisit;

      if ($request->isPost()) {
            $reference_facture_fournisseur = $_POST['reference_facture_fournisseur'];
            $libelle_facture_fournisseur = $_POST['libelle_facture_fournisseur'];
            $montant_paiement_facture_fournisseur = $_POST['montant_paiement_facture_fournisseur'];
            $date_paiement_facture_fournisseur = $_POST['date_paiement_facture_fournisseur'];
            $mode_paiement_facture_fournisseur = $_POST['mode_paiement_facture_fournisseur'];
            $num_interne = substr(md5(uniqid(rand(),true)),0,8);
            $real_num_interne = strtoupper('FACTURE-'.$num_interne);
            $created = Zend_Date::now();
            $date_arrivee =  $created->toString('yyyy-MM-dd HH:mm:ss');
            
            


            if($reference_facture_fournisseur == "") {
              $validationerrors['empty_reference_facture_fournisseur'] = "La référence de la facture fournisseur ne doit pas être vide";
            }

            if(!isset($reference_facture_fournisseur)) {
              $validationerrors['empty_reference_facture_fournisseur'] = "La référence de la facture fournisseur n'existe pas";
            }

            if($libelle_facture_fournisseur == "") {
              $validationerrors['empty_libelle_facture_fournisseur'] = "Le libellé de la facture fournisseur ne doit pas être vide";
            }

            if(!isset($libelle_facture_fournisseur)) {
              $validationerrors['empty_libelle_facture_fournisseur'] = "Le libellé de la facture fournisseur n'existe pas";
            }

            
            if($montant_paiement_facture_fournisseur == "") {
              $validationerrors['empty_montant_paiement_facture_fournisseur'] = "Le montant de paiement de la facture fournisseur ne doit pas être vide";
            }

            if(!isset($montant_paiement_facture_fournisseur)) {
              $validationerrors['empty_montant_paiement_facture_fournisseur'] = "Le montant de paiement de la facture fournisseur n'existe pas";
            }

            if($montant_paiement_facture_fournisseur !== ""){
              if(!filter_var($montant_paiement_facture_fournisseur, FILTER_VALIDATE_REGEXP,
                 array("options"=>array("regexp"=>"#[0-9]#")))){
                  $validationerrors['verif_montant_paiement_facture_fournisseur'] = "Le montant de paiement de la facture fournisseur est invalide";
               }
            }

            if($date_paiement_facture_fournisseur == "") {
              $validationerrors['empty_date_paiement_facture_fournisseur'] = "La date de paiement de la facture fournisseur ne doit pas être vide";
            }

            if(!isset($date_paiement_facture_fournisseur)) {
              $validationerrors['empty_date_paiement_facture_fournisseur'] = "Le date de paiement de la facture fournisseur n'existe pas";
            }

            if($fournisseur_facture == "") {
              $validationerrors['empty_fournisseur_facture'] = "Le nom du fournisseur ne doit pas être vide";
            }

            if(!isset($fournisseur_facture)) {
              $validationerrors['empty_fournisseur_facture'] = "Le nom du fournisseur n'existe pas";
            }

            if($mode_paiement_facture_fournisseur == "") {
              $validationerrors['empty_mode_paiement_facture_fournisseur'] = "Le mode de paiement ne doit pas être vide";
            }

            if(!isset($mode_paiement_facture_fournisseur)) {
              $validationerrors['empty_mode_paiement_facture_fournisseur'] = "Le mode de paiement n'existe pas";
            }

            if($mode_paiement_facture_fournisseur != ""){
              if(!in_array($mode_paiement_facture_fournisseur, array('espece','OPI') )){
                $validationerrors['valid_code_membre'] = "Le mode de paiement est invalide";
              }
            }


            if(!empty($validationerrors)){
              $_SESSION['validationerrors'] = $validationerrors;
            }

            if(empty($validationerrors)){
              var_dump($_POST);

              $dbfselect = "SELECT *
                            FROM eu_proforma_procedure
                            WHERE eu_proforma_procedure.numero_proforma='$reference_facture_fournisseur'
                            AND eu_proforma_procedure.date_paie ='$date_paiement_facture_fournisseur'";
              $db->setFetchMode(Zend_Db::FETCH_OBJ);
              $stmt = $db->query($dbfselect); 
              $dbsearchcheckfactureinproforma = $stmt->fetchAll();
              $countsearchcheckfactureinproforma = count($dbsearchcheckfactureinproforma);

              if ($countsearchcheckfactureinproforma == 0) {
                $validationerrors['valid_searchcheckreferencefacture'] = "La référence de la facture n'est pas correcte";                

              }

              if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
              }

              if ($countsearchcheckfactureinproforma !== 0) {
              $dbfselect = "SELECT *
                            FROM eu_factures_procedure
                            WHERE eu_factures_procedure.numero_facture='$reference_facture_fournisseur'";
              $db->setFetchMode(Zend_Db::FETCH_OBJ);
              $stmt = $db->query($dbfselect); 
              $dbsearchcheckfacture = $stmt->fetchAll();
              $countsearchcheckfacture = count($dbsearchcheckfacture);

              if($countsearchcheckfacture !== 0){
                $validationerrors['valid_searchcheckfacture'] = "Cette facture a deja été enrégistré";

              }
              
              if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
              }

              if($countsearchcheckfacture == 0){

                $dbfinsert = "INSERT INTO eu_factures_procedure(
                  numero_facture,
                  numero_interne,
                  libelle,
                  montant,                  
                  date_paiement,
                  date_arrivee,
                  copie_technopole,
                  modalite_paiement) VALUES (
                  '$reference_facture_fournisseur',
                  '$real_num_interne',
                  '$libelle_facture_fournisseur',
                  '$montant_paiement_facture_fournisseur',
                  '$date_paiement_facture_fournisseur',
                  '$date_arrivee',
                  'ok',
                  '$mode_paiement_facture_fournisseur')";
              $db->setFetchMode(Zend_Db::FETCH_OBJ);
              $stmt = $db->query($dbfinsert);
              $this->_redirect('/proceduredetraitementdefacture/registredesfactures');
              
            }

            }


            }



      }        

    }


    public function registredesfacturesAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $dbverifselect = "SELECT
                          eu_factures_procedure.numero_interne,
                          eu_factures_procedure.numero_facture,
                          eu_factures_procedure.libelle,
                          eu_factures_procedure.date_facture,
                          eu_factures_procedure.date_arrivee,
                          eu_factures_procedure.id_factures_procedure
                     FROM eu_factures_procedure ";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dbregistredesfacturesfournisseurs = $stmt->fetchAll(); 
      $this->view->registredesfacturesfournisseurs  = $dbregistredesfacturesfournisseurs ;  
      
    }

    public function listedetouslesfacturesAction () {
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

    public function detailsdunefactureAction () {
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
      $db = Zend_Db_Table::getDefaultAdapter();
      $id = (int)$this->_request->getParam('id');
      $created = Zend_Date::now();        
      $request = $this->getRequest();
      $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
      
      if($_SERVER['REQUEST_METHOD'] == 'GET'){
          $dbverifid = " SELECT eu_factures_procedure.id_factures_procedure
          FROM eu_factures_procedure
          WHERE eu_factures_procedure.id_factures_procedure = '$id'";
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $stmt = $db->query($dbverifid);
          $dbverificationdelavaliditedeidfacture = $stmt->fetchAll();
          $countdbverificationdelavaliditedeidfacture = count($dbverificationdelavaliditedeidfacture);
  
          if($countdbverificationdelavaliditedeidfacture === 0){
              http_response_code(403);
              die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
          }
      }
      $dbverifid = " SELECT 
                      eu_factures_procedure.numero_facture,
                      eu_factures_procedure.numero_interne,
                      eu_factures_procedure.libelle,
                      eu_factures_procedure.date_facture,
                      eu_factures_procedure.date_paiement,
                      eu_factures_procedure.date_arrivee,
                      eu_factures_procedure.montant,
                      eu_factures_procedure.modalite_paiement,
                      eu_factures_procedure.id_factures_procedure
                 FROM eu_factures_procedure
                 WHERE eu_factures_procedure.id_factures_procedure= '$id'";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifid);
      $dbdetailsdelafactureprocedure = $stmt->fetchAll();
      $this->view->dbdetailsdelafactureprocedure = $dbdetailsdelafactureprocedure; 
    }


    public function editiondelafacturefournisseurAction () {
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
        $request = $this->getRequest();
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbverifid = " SELECT eu_factures_procedure.id_factures_procedure
            FROM eu_factures_procedure
            WHERE eu_factures_procedure.id_factures_procedure = '$id'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationdelavaliditedeidfacture = $stmt->fetchAll();
            $countdbverificationdelavaliditedeidfacture = count($dbverificationdelavaliditedeidfacture);
    
            if($countdbverificationdelavaliditedeidfacture === 0){
                http_response_code(403);
                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
            }
        }
        $dbverifid = " SELECT 
                        eu_factures_procedure.numero_facture,
                        eu_factures_procedure.numero_interne,
                        eu_factures_procedure.libelle,
                        eu_factures_procedure.date_facture,
                        eu_factures_procedure.date_paiement,
                        eu_factures_procedure.date_arrivee,
                        eu_factures_procedure.montant,
                        eu_factures_procedure.modalite_paiement,
                        eu_factures_procedure.id_factures_procedure
                   FROM eu_factures_procedure
                   WHERE eu_factures_procedure.id_factures_procedure= '$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifid);
        $dbeditiondelafactureprocedure = $stmt->fetchAll();
        $this->view->dbeditiondelafactureprocedure = $dbeditiondelafactureprocedure;        
    }

    public function appositionducachetcourrierarriveparlatechnopoleAction () {

    }

    public function listedescopiedefacturesoriginaleseffectuerparlatechnopoleAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $dbverifselect = "SELECT
                          eu_factures_procedure.numero_interne,
                          eu_factures_procedure.numero_facture,
                          eu_factures_procedure.libelle,
                          eu_factures_procedure.date_facture,
                          eu_factures_procedure.date_arrivee,
                          eu_factures_procedure.copie_technopole,
                          eu_factures_procedure.id_factures_procedure
                     FROM eu_factures_procedure
                     WHERE eu_factures_procedure.valid_down = 1 ";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dblistedescopiesdefacturesparlatechnopole = $stmt->fetchAll(); 
      $this->view->listedescopiesdefacturesparlatechnopole  = $dblistedescopiesdefacturesparlatechnopole;  
    }

    public function detailscopiedunefacturefiliereAction () {
      
      $db = Zend_Db_Table::getDefaultAdapter();
      $id = (int)$this->_request->getParam('id');
      $created = Zend_Date::now();        
      $request = $this->getRequest();
      $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
      
      if($_SERVER['REQUEST_METHOD'] == 'GET'){
          $dbverifid = " SELECT eu_factures_procedure.id_factures_procedure
                         FROM eu_factures_procedure
                         WHERE eu_factures_procedure.id_factures_procedure = '$id'
                         AND eu_factures_procedure.copie_technopole = 'ok'
                         AND eu_factures_procedure.copie_filiere = 'ok'                                  
                         AND eu_factures_procedure.valid_down = 3";
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $stmt = $db->query($dbverifid);
          $dbverificationdelavaliditedeidfacture = $stmt->fetchAll();
          $countdbverificationdelavaliditedeidfacture = count($dbverificationdelavaliditedeidfacture);
  
          if($countdbverificationdelavaliditedeidfacture === 0){
              http_response_code(403);
              die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
          }
      }
      $dbverifid = " SELECT 
                      eu_factures_procedure.numero_facture,
                      eu_factures_procedure.numero_interne,
                      eu_factures_procedure.libelle,
                      eu_factures_procedure.date_facture,
                      eu_factures_procedure.date_paiement,
                      eu_factures_procedure.date_arrivee,
                      eu_factures_procedure.montant,
                      eu_factures_procedure.modalite_paiement,
                      eu_factures_procedure.id_factures_procedure
                 FROM eu_factures_procedure
                 WHERE eu_factures_procedure.id_factures_procedure= '$id'
                 AND eu_factures_procedure.copie_technopole = 'ok'
                 AND eu_factures_procedure.copie_filiere = 'ok'                 
                 AND eu_factures_procedure.valid_down = 3";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifid);
      $dbdetailsdelafactureprocedurefiliere = $stmt->fetchAll();
      $this->view->dbdetailsdelafactureprocedurefiliere = $dbdetailsdelafactureprocedurefiliere; 
    }

    public function detailscopiedunefacturetechnopoleAction () {
      
      $db = Zend_Db_Table::getDefaultAdapter();
      $id = (int)$this->_request->getParam('id');
      $created = Zend_Date::now();        
      $request = $this->getRequest();
      $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
      
      if($_SERVER['REQUEST_METHOD'] == 'GET'){
          $dbverifid = " SELECT eu_factures_procedure.id_factures_procedure
                         FROM eu_factures_procedure
                         WHERE eu_factures_procedure.id_factures_procedure = '$id'
                         AND eu_factures_procedure.copie_technopole = 'ok'
                         AND eu_factures_procedure.copie_filiere = 'ok'
                         AND eu_factures_procedure.valid_down = 1";
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $stmt = $db->query($dbverifid);
          $dbverificationdelavaliditedeidfacture = $stmt->fetchAll();
          $countdbverificationdelavaliditedeidfacture = count($dbverificationdelavaliditedeidfacture);
  
          if($countdbverificationdelavaliditedeidfacture === 0){
              http_response_code(403);
              die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
          }
      }
      $dbverifid = " SELECT 
                      eu_factures_procedure.numero_facture,
                      eu_factures_procedure.numero_interne,
                      eu_factures_procedure.libelle,
                      eu_factures_procedure.date_facture,
                      eu_factures_procedure.date_paiement,
                      eu_factures_procedure.date_arrivee,
                      eu_factures_procedure.montant,
                      eu_factures_procedure.modalite_paiement,
                      eu_factures_procedure.id_factures_procedure
                 FROM eu_factures_procedure
                 WHERE eu_factures_procedure.id_factures_procedure= '$id'
                 AND eu_factures_procedure.copie_technopole = 'ok'
                 AND eu_factures_procedure.valid_down = 1";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifid);
      $dbdetailsdelafactureprocedure = $stmt->fetchAll();
      $this->view->dbdetailsdelafactureprocedure = $dbdetailsdelafactureprocedure; 
    }

    public function listedescopiedefacturesoriginaleseffectuerparlafiliereAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $dbverifselect = "SELECT
                          eu_factures_procedure.numero_interne,
                          eu_factures_procedure.numero_facture,
                          eu_factures_procedure.libelle,
                          eu_factures_procedure.date_facture,
                          eu_factures_procedure.date_arrivee,
                          eu_factures_procedure.copie_technopole,
                          eu_factures_procedure.copie_gerant,
                          eu_factures_procedure.id_factures_procedure
                     FROM eu_factures_procedure
                     WHERE eu_factures_procedure.valid_down = 3 ";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dblistedescopiesdefacturesparlatechnopole = $stmt->fetchAll(); 
      $this->view->listedescopiesdefacturesparlatechnopole  = $dblistedescopiesdefacturesparlatechnopole;  
    }

    public function detailsdescopiedefacturesoriginaleseffectuerparlatechnopoleAction () {
              /***Validation de la facture du gerant vers l'agent filiere
         * 
         * 
         */
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $created = Zend_Date::now();        
        $request = $this->getRequest();
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbverifid = " SELECT eu_factures_procedure.id_factures_procedure
            FROM eu_factures_procedure
            WHERE eu_factures_procedure.id_factures_procedure = '$id'
            AND eu_factures_procedure.copie_technopole = 'ok'
            AND eu_factures_procedure.valid_down = 1";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationdelavaliditedeidfacture = $stmt->fetchAll();
            $countdbverificationdelavaliditedeidfacture = count($dbverificationdelavaliditedeidfacture);
    
            if($countdbverificationdelavaliditedeidfacture === 0){
                http_response_code(403);
                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
            }
        }
        $dbverifid = " SELECT 
                        eu_factures_procedure.numero_facture,
                        eu_factures_procedure.numero_interne,
                        eu_factures_procedure.libelle,
                        eu_factures_procedure.date_facture,
                        eu_factures_procedure.date_paiement,
                        eu_factures_procedure.date_arrivee,
                        eu_factures_procedure.montant,
                        eu_factures_procedure.modalite_paiement,
                        eu_factures_procedure.copie_technopole,
                        eu_factures_procedure.id_factures_procedure
                   FROM eu_factures_procedure
                   WHERE eu_factures_procedure.id_factures_procedure= '$id'
                   AND eu_factures_procedure.copie_technopole = 'ok'
                   AND eu_factures_procedure.valid_down = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifid);
        $dbdetailcopiedelafactureavaliderparlatechnopole = $stmt->fetchAll();
        $this->view->detailcopiedelafactureavaliderparlatechnopole = $dbdetailcopiedelafactureavaliderparlatechnopole; 
    }


     public function detailsdescopiedefacturesoriginaleseffectuerparlafiliereAction () {
              /***Validation de la facture du gerant vers l'agent filiere
         * 
         * 
         */
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $created = Zend_Date::now();        
        $request = $this->getRequest();
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbverifid = " SELECT eu_factures_procedure.id_factures_procedure
                       FROM eu_factures_procedure
                       WHERE eu_factures_procedure.id_factures_procedure = '$id'
                       AND eu_factures_procedure.copie_filiere = 'ok'   
                       AND eu_factures_procedure.copie_technopole = 'ok'              
                       AND eu_factures_procedure.valid_down = 3";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationdelavaliditedeidfacture = $stmt->fetchAll();
            $countdbverificationdelavaliditedeidfacture = count($dbverificationdelavaliditedeidfacture);
    
            if($countdbverificationdelavaliditedeidfacture === 0){
                http_response_code(403);
                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
            }
        }
        $dbverifid = " SELECT 
                        eu_factures_procedure.numero_facture,
                        eu_factures_procedure.numero_interne,
                        eu_factures_procedure.libelle,
                        eu_factures_procedure.date_facture,
                        eu_factures_procedure.date_paiement,
                        eu_factures_procedure.date_arrivee,
                        eu_factures_procedure.montant,
                        eu_factures_procedure.modalite_paiement,
                        eu_factures_procedure.copie_technopole,
                        eu_factures_procedure.copie_filiere
                        
                   FROM eu_factures_procedure
                   WHERE eu_factures_procedure.id_factures_procedure= '$id'
                   AND eu_factures_procedure.copie_technopole = 'ok'
                   AND eu_factures_procedure.copie_filiere = 'ok'                 
                   AND eu_factures_procedure.valid_down = 3";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifid);
        $dbdetailscopiedelafactureavaliderparlafiliere = $stmt->fetchAll();
        $this->view->detailscopiedelafactureavaliderparlafiliere = $dbdetailscopiedelafactureavaliderparlafiliere;
     }   




    public function listedesfacturesavaliderparlegerantAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $dbverifselect = "SELECT
                          eu_factures_procedure.numero_interne,
                          eu_factures_procedure.numero_facture,
                          eu_factures_procedure.libelle,
                          eu_factures_procedure.date_facture,
                          eu_factures_procedure.date_arrivee,
                          eu_factures_procedure.id_factures_procedure
                     FROM eu_factures_procedure
                     WHERE eu_factures_procedure.valid_down = 1 ";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dblistedesfacturesavaliderparlegerant = $stmt->fetchAll(); 
      $this->view->listedesfacturesavaliderparlegerant  = $dblistedesfacturesavaliderparlegerant;  
    }

    public function listedesfacturesavaliderparlafiliereAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $dbverifselect = "SELECT
                          eu_factures_procedure.numero_interne,
                          eu_factures_procedure.numero_facture,
                          eu_factures_procedure.libelle,
                          eu_factures_procedure.date_facture,
                          eu_factures_procedure.date_arrivee,
                          eu_factures_procedure.id_factures_procedure
                     FROM eu_factures_procedure
                     WHERE eu_factures_procedure.valid_down = 2 ";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dblistedesfacturesavaliderparlafiliere = $stmt->fetchAll(); 
      $this->view->listedesfacturesavaliderparlafiliere  = $dblistedesfacturesavaliderparlafiliere;  
    }

    public function listedesfacturesquisontvaliderparlafiliereAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $dbverifselect = "SELECT
                          eu_factures_procedure.numero_interne,
                          eu_factures_procedure.numero_facture,
                          eu_factures_procedure.libelle,
                          eu_factures_procedure.date_facture,
                          eu_factures_procedure.date_arrivee,
                          eu_factures_procedure.id_factures_procedure
                     FROM eu_factures_procedure
                     WHERE eu_factures_procedure.valid_down = 3 ";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dblistedesfacturesquisontvaliderparlafiliere = $stmt->fetchAll(); 
      $this->view->listedesfacturesquisontvaliderparlafiliere  = $dblistedesfacturesquisontvaliderparlafiliere;  
    }


    public function listedesfacturesquisontvaliderparlegerantAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $dbverifselect = "SELECT
                          eu_factures_procedure.numero_interne,
                          eu_factures_procedure.numero_facture,
                          eu_factures_procedure.libelle,
                          eu_factures_procedure.date_facture,
                          eu_factures_procedure.date_arrivee,
                          eu_factures_procedure.id_factures_procedure
                     FROM eu_factures_procedure
                     WHERE eu_factures_procedure.valid_down = 2";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dblistedesfacturesquisontvaliderparlegerant = $stmt->fetchAll(); 
      $this->view->listedesfacturesquisontvaliderparlegerant  = $dblistedesfacturesquisontvaliderparlegerant;  
    }

    public function validationdelafactureparlegerantAction () {
        /***Validation de la facture du gerant vers l'agent filiere
         * 
         * 
         */
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $created = Zend_Date::now();        
        $request = $this->getRequest();
        $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbverifid = " SELECT eu_factures_procedure.id_factures_procedure
            FROM eu_factures_procedure
            WHERE eu_factures_procedure.id_factures_procedure = '$id'
            AND eu_factures_procedure.valid_down = 1";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationdelavaliditedeidfacturevalideparlgerant = $stmt->fetchAll();
            $countdbverificationdelavaliditedeidfacturevalideparlgerant = count($dbverificationdelavaliditedeidfacturevalideparlgerant);
    
            if($countdbverificationdelavaliditedeidfacturevalideparlgerant  == 0){
                http_response_code(403);
                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
            }
        }
        $dbverifid = " SELECT 
                        eu_factures_procedure.numero_facture,
                        eu_factures_procedure.numero_interne,
                        eu_factures_procedure.libelle,
                        eu_factures_procedure.date_facture,
                        eu_factures_procedure.date_paiement,
                        eu_factures_procedure.date_arrivee,
                        eu_factures_procedure.montant,
                        eu_factures_procedure.modalite_paiement,
                        eu_factures_procedure.id_factures_procedure
                   FROM eu_factures_procedure
                   WHERE eu_factures_procedure.id_factures_procedure= '$id'
                   AND eu_factures_procedure.valid_down = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbverifid);
        $dbeditiondelafactureavaliderparlegerant = $stmt->fetchAll();
        $this->view->dbeditiondelafactureavaliderparlegerant = $dbeditiondelafactureavaliderparlegerant;   
    }

    public function validationdelafactureparlafiliereAction () {
      /***Validation de la facture du gerant vers l'agent filiere
       * 
       * 
       */
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');      
      $db = Zend_Db_Table::getDefaultAdapter();
      $id = (int)$this->_request->getParam('id');
      $created = Zend_Date::now();        
      $request = $this->getRequest();
      $date_choix =  $created->toString('yyyy-MM-dd HH:mm:ss');
      
      if($_SERVER['REQUEST_METHOD'] == 'GET'){
          $dbverifid = " SELECT eu_factures_procedure.id_factures_procedure
          FROM eu_factures_procedure
          WHERE eu_factures_procedure.id_factures_procedure = '$id'
          AND eu_factures_procedure.valid_down = 2";
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $stmt = $db->query($dbverifid);
          $dbverificationdelavaliditedeidfacture = $stmt->fetchAll();
          $countdbverificationdelavaliditedeidfacture = count($dbverificationdelavaliditedeidfacture);
  
          if($countdbverificationdelavaliditedeidfacture === 0){
              http_response_code(403);
              die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');
          }
      }
      $dbverifid = " SELECT 
                      eu_factures_procedure.numero_facture,
                      eu_factures_procedure.numero_interne,
                      eu_factures_procedure.libelle,
                      eu_factures_procedure.date_facture,
                      eu_factures_procedure.date_paiement,
                      eu_factures_procedure.date_arrivee,
                      eu_factures_procedure.montant,
                      eu_factures_procedure.modalite_paiement,
                      eu_factures_procedure.id_factures_procedure
                 FROM eu_factures_procedure
                 WHERE eu_factures_procedure.id_factures_procedure= '$id'
                 AND eu_factures_procedure.valid_down = 2";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifid);
      $dbeditiondelafactureavaliderparlafiliere = $stmt->fetchAll();
      $this->view->dbeditiondelafactureavaliderparlafiliere = $dbeditiondelafactureavaliderparlafiliere;   
  }

    public function listedesfacturesquisontaccessibleparlagentfiliereAction () {
      $db = Zend_Db_Table::getDefaultAdapter();
      $dbverifselect = "SELECT
                          eu_factures_procedure.numero_interne,
                          eu_factures_procedure.numero_facture,
                          eu_factures_procedure.libelle,
                          eu_factures_procedure.date_facture,
                          eu_factures_procedure.date_arrivee
                     FROM eu_factures_procedure
                     WHERE eu_factures_procedure.valid_down = 2";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbverifselect);
      $dblistedesfacturesquisontvaliderparlegerant = $stmt->fetchAll(); 
      $this->view->listedesfacturesquisontvaliderparlegerant  = $dblistedesfacturesquisontvaliderparlegerant;  
 
    }

    public function ajaxtransmitiondelafacturedugerantverslafiliereAction () {
      $this->_helper->layout()->disableLayout();
      
        
      if($_SERVER['REQUEST_METHOD'] != 'POST'){
        http_response_code(403);
        die();
      }
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $created = Zend_Date::now();


        $currentid = $_POST['idfactureproceduregerant'];
        $db = Zend_Db_Table::getDefaultAdapter();
        $resultjson = array();
  
        try {
             $dbtselect = "UPDATE eu_factures_procedure
                           SET eu_factures_procedure.valid_down = 2
                           WHERE eu_factures_procedure.id_factures_procedure = $currentid"; 
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbtselect);
             $resultjson = array(
                'update'=>'Transmition de la facture vers la filiere effectuee avec success'
             );
        } catch (Exception $e) {
              $errormessage = $e->getMessage();
              $resultjson = array(
                'errorjson'=>$errormessage
              );
        }

        header('Content-type:application/json');
        die(json_encode($resultjson));
      }
    }

    public function ajaxtransmissiondelafacturedelafiliereverslacnevAction () {
      $this->_helper->layout()->disableLayout();
      
      if($_SERVER['REQUEST_METHOD'] != 'POST'){
        http_response_code(403);
        die();
      }

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        try{
             $created = Zend_Date::now();
             $currentid = $_POST['idfactureprocedurefiliere'];
             $db = Zend_Db_Table::getDefaultAdapter();
             $resultjson = array();

             $dbtselect = "UPDATE eu_factures_procedure
                           SET eu_factures_procedure.valid_down = 3, eu_factures_procedure.copie_filiere = 'ok'
                           WHERE eu_factures_procedure.id_factures_procedure = $currentid"; 
             $db->setFetchMode(Zend_Db::FETCH_OBJ);
             $stmt = $db->query($dbtselect);
             $resultjson = array(
               'update'=>'Transmition de la facture vers l\'acnev effectuee avec success'
             );
        } catch (Exception $e) {
          $errormessage = $e->getMessage();
          $resultjson = array(
            'errorjson'=>$errormessage
          );

        }

        header('Content-type:application/json');
        die(json_encode($resultjson));
      }
    }
}