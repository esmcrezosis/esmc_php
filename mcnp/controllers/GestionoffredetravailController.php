<?php

class GestionoffredetravailController extends Zend_Controller_Action{


    public function init(){

        /*

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');*/
    }

    public function obtenirleliendelaformationotAction ()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $validationerrors = array();

        $sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membreot = $sessionmembre->code_membre;

        $code_acces_salle = "";

        $idcandidature_membre = "";

        if ($request->isPost()){

            $id_candidature_membre = "";

            $code_bci =  htmlspecialchars($_POST['ot_code_bci']);

            $code_transfert_technologie =  htmlspecialchars($_POST['ot_code_transfert_technologie']);

            $code_acces_salle =  htmlspecialchars($_POST['ot_code_acces']);

            if(!isset($sessionmembre->code_membre)) {

			     $this->_redirect('/');
		    }


            if (!isset($code_transfert_technologie) || !isset($code_bci) || !isset($code_acces_salle)){
                
                $validationerrors['enexpected_request'] = "Vous tentez d'effectuer une opération qui n'est pas autorisé";

            } 

            if ($code_bci == ""){

                $validationerrors['empty_code_bci'] = "Vous devez renseigné votre code BCi que vous avez obtenu après votre achat du poste";

            }

            if ($code_transfert_technologie == ""){

                $validationerrors['empty_code_transfert'] = "Vous devez renseigné le code de transfert de technologie";

            }

            if ($code_acces_salle == ""){

                $validationerrors['empty_code_acces'] = "Vous devez renseigné le code d'accès à la salle de formation";

            }

            if ($code_transfert_technologie != "") {

                $dbverifiervalidcode = "SELECT eu_candidature_membre.code_acces_salle, eu_candidature_membre.id_candidature_membre
                
                                        FROM eu_candidature_membre 
                                   
                                        WHERE eu_candidature_membre.code_transfert_technologie = '$code_transfert_technologie'

                                        AND eu_candidature_membre.code_membre = '$code_membreot'
                                   
                                        AND eu_candidature_membre.code_acces_salle IS NOT NULL
                                   
                                        AND eu_candidature_membre.preselection = 1
                                        
                                        AND eu_candidature_membre.vu_codetransferttechnologie = 1";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifiervalidcode = $db->query($dbverifiervalidcode);
                
                $verifiervalidcode = $stmtverifiervalidcode->fetchAll(); 

                $countverifiervalidcode = count($verifiervalidcode);

                if ($countverifiervalidcode == 0) {

                     $validationerrors['empty_type_transfert'] = "Le code de transfert de technologie que vous avez renseigné n'est pas correcte";

                }
             
            }

            if ($code_bci != ""){

                $dbverifiervalidcodebci = "SELECT eu_formation.id
                
                                           FROM eu_formation
                                   
                                           WHERE eu_formation.code_bci = '$code_bci'
                                        
                                           AND eu_formation.code_membre = '$code_membreot'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifiervalidcodebci = $db->query($dbverifiervalidcodebci);
                
                $verifiervalidcodebci = $stmtverifiervalidcodebci->fetchAll();

                if (count($verifiervalidcodebci) == 0){

                    $validationerrors['empty_type_transfert'] = "Le code BCi que vous avez renseigné est incorrecte";

                }
            }

            if ($code_acces_salle == ""){

                $dbverifiervalidcodeacces = "SELECT eu_candidature_membre.id_candidature_membre
                
                                             FROM eu_candidature_membre
                                   
                                             WHERE eu_candidature_membre.code_acces_salle = '$code_acces_salle'
                                        
                                             AND eu_candidature_membre.code_membre = '$code_membre'
                                             
                                             AND eu_candidature_membre.vu_codeacces = 1";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifiervalidcodeacces = $db->query($dbverifiervalidcodeacces);
                
                $verifiervalidcodeacces = $stmtverifiervalidcodeacces->fetchAll();

                if (count($verifiervalidcode) == 0)
                {

                    $validationerrors['empty_type_transfert'] = "Le code d'accès à la salle de formation que vous avez renseigné est incorrecte";

                }


            }

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)) {

                
                $updatetpyedetransfert = "UPDATE eu_candidature_membre
                
                                          SET eu_candidature_membre.vu_linkformationot = 1 
                              
                                          WHERE eu_candidature_membre.code_transfert_technologie = '$code_transfert_technologie'
                                          
                                          AND eu_candidature_membre.code_acces_salle = '$code_acces_salle'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                if ($db->query($updatetpyedetransfert)){

                    $linkurlformation = "http://formation.esmcgie.com/wp-admin";

                    $textcodeacces = "Le lien vers votre site de formation est $linkurlformation";

                    $_SESSION['integritycodeacces'] = "";

                    $_SESSION['integritycodeacces'] = $textcodeacces;

                }

            }

        }
    }

    public function fichededemandedemodificationAction ()
    {
        /**
         * Les types de modification: Nom de poste, Détails du contrat de travail
         */

    }

    

    public function interfacedesuividelacandidaturedelotAction ()
    {

        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $validationerrors = array();

        $sessionmembre = new Zend_Session_Namespace('membre');	

        $code_membreot = $sessionmembre->code_membre;


        if (!isset($code_membreot))
        {
            $this->_redirect('/');
        }

        if (isset($code_membreot))
        {

            $dbselectmacandidature = "SELECT * 
            
                                      FROM eu_candidature_membre, eu_candidature_postes, eu_formation
                                      
                                      WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes
                                      
                                      AND eu_candidature_postes.id_candidature_postes = eu_formation.id_candidature_poste
                                      
                                      AND eu_candidature_membre.code_membre = '$code_membreot'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtselectmacandidature = $db->query($dbselectmacandidature);
                
            $selectmacandidature = $stmtselectmacandidature->fetchAll(); 

            $countselectmacandidature = count($selectmacandidature); 
            
            $this->view->countselectmacandidature = $countselectmacandidature;

            $this->view->selectmacandidature = $selectmacandidature;

        }

    }

    
    public function interfacedobtentiondesoncodepouvoirfaireAction ()
    {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $validationerrors = array();

        $sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membreot = $sessionmembre->code_membre;

        $code_acces_salle = "";

        $idcandidature_membre = "";

        if ($request->isPost()){

            $id_candidature_membre = "";

            $code_bci =  htmlspecialchars($_POST['ot_code_bci']);

            $code_transfert_technologie =  htmlspecialchars($_POST['ot_code_transfert_technologie']);

            $code_acces_salle =  htmlspecialchars($_POST['ot_code_acces']);


            if(!isset($sessionmembre->code_membre)) {

			     $this->_redirect('/');
		    }


            if (!isset($code_transfert_technologie) || !isset($code_bci) || !isset($code_acces_salle)){
                
                $validationerrors['enexpected_request'] = "Vous tentez d'effectuer une opération qui n'est pas autorisé";

            } 

            if ($code_bci == ""){

                $validationerrors['empty_code_bci'] = "Vous devez renseigné votre code BCi que vous avez obtenu après votre achat du poste";

            }

            if ($code_transfert_technologie == ""){

                $validationerrors['empty_code_transfert'] = "Vous devez renseigné le code de transfert de technologie";

            }

            if ($code_acces_salle == ""){

                $validationerrors['empty_code_acces'] = "Vous devez renseigné le code d'accès à la salle de formation";

            }

            if ($code_transfert_technologie != "") {

                $dbverifiervalidcode = "SELECT eu_candidature_membre.code_acces_salle, eu_candidature_membre.id_candidature_membre
                
                                        FROM eu_candidature_membre 
                                   
                                        WHERE eu_candidature_membre.code_transfert_technologie = '$code_transfert_technologie'

                                        AND eu_candidature_membre.code_membre = '$code_membreot'
                                   
                                        AND eu_candidature_membre.code_acces_salle IS NOT NULL
                                   
                                        AND eu_candidature_membre.preselection = 1";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifiervalidcode = $db->query($dbverifiervalidcode);
                
                $verifiervalidcode = $stmtverifiervalidcode->fetchAll(); 

                $countverifiervalidcode = count($verifiervalidcode);

                if ($countverifiervalidcode == 0) {

                     $validationerrors['empty_type_transfert'] = "Le code de transfert de technologie que vous avez renseigné n'est pas correcte";

                }
             
            }

            if ($code_bci != ""){

                $dbverifiervalidcodebci = "SELECT eu_formation.id
                
                                           FROM eu_formation
                                   
                                           WHERE eu_formation.code_bci = '$code_bci'
                                        
                                           AND eu_formation.code_membre = '$code_membreot'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifiervalidcodebci = $db->query($dbverifiervalidcodebci);
                
                $verifiervalidcodebci = $stmtverifiervalidcodebci->fetchAll();

                if (count($verifiervalidcodebci) == 0){

                    $validationerrors['empty_type_transfert'] = "Le code BCi que vous avez renseigné est incorrecte";

                }
            }

            if ($code_acces_salle == ""){

                $dbverifiervalidcodeacces = "SELECT eu_candidature_membre.id_candidature_membre
                
                                             FROM eu_candidature_membre
                                   
                                             WHERE eu_candidature_membre.code_acces_salle = '$code_acces_salle'
                                        
                                             AND eu_candidature_membre.code_membre = '$code_membre'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifiervalidcodeacces = $db->query($dbverifiervalidcodeacces);
                
                $verifiervalidcodeacces = $stmtverifiervalidcodeacces->fetchAll();

                if (count($verifiervalidcode) == 0)
                {

                    $validationerrors['empty_type_transfert'] = "Le code d'accès à la salle de formation que vous avez renseigné est incorrecte";

                }


            }

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)) {

                
                $updatetpyedetransfert = "UPDATE eu_candidature_membre
                
                                          SET eu_candidature_membre.vu_pouvoirfaire = 1 
                              
                                          WHERE eu_candidature_membre.code_transfert_technologie = '$code_transfert_technologie'
                                          
                                          AND eu_candidature_membre.code_acces_salle = '$code_acces_salle'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                if ($db->query($updatetpyedetransfert)){


                    $dbobtenirlecodedevalidationdepouvoirfaire = "SELECT eu_candidature_membre.code_pouvoirfaire
                    
                                                                  FROM eu_candidature_membre, eu_formation
                                                                  
                                                                  WHERE  eu_candidature_membre.id_candidature_postes = eu_formation.id_candidature_poste
                                                                  
                                                                  AND eu_formation.code_bci = '$code_bci'

                                                                  AND eu_candidature_membre.code_transfert_technologie = '$code_transfert_technologie'

                                                                  AND eu_candidature_membre.code_acces_salle = '$code_acces_salle'";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    $stmtobtenirlecodedevalidationdepouvoirfaire = $db->query($dbobtenirlecodedevalidationdepouvoirfaire);
                
                    $obtenirlecodedevalidationdepouvoirfaire = $stmtobtenirlecodedevalidationdepouvoirfaire->fetchAll();

                    if (count($obtenirlecodedevalidationdepouvoirfaire) != 0){

                        $codedevalidationdepouvoirfaire = $obtenirlecodedevalidationdepouvoirfaire[0]->code_pouvoirfaire;

                        $textcodeacces = "Votre code de validation de pouvoir-faire est $codedevalidationdepouvoirfaire";

                        $_SESSION['integritycodeacces'] = "";
    
                        $_SESSION['integritycodeacces'] = $textcodeacces;
                    }
                }

            }

        }
    }

    public function interfacedobtentiondesoncodedetransfertdetechnologieAction ()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $validationerrors = array();

        $sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membreot = $sessionmembre->code_membre;

        
        if ($request->isPost()){

            $code_bci =  htmlspecialchars($_POST['ot_code_bci']);

            if (!isset($code_bci)){
                
                $validationerrors['enexpected_request'] = "Vous tentez d'effectuer une opération qui n'est pas autorisé";

            } 

            if (isset($code_bci)){

                if ($code_bci == ""){

                     $validationerrors['enexpected_request'] = "Vous tentez d'effectuer une opération qui n'est pas autorisé";

                }

                if ($code_bci != ""){

                        $dbverifvaliditercodebci = "SELECT eu_formation.id, eu_formation.id_candidature, eu_formation.id_candidature_poste
                
                                                    FROM eu_formation
           
                                                    WHERE eu_formation.code_bci = '$code_bci'
                                                    
                                                    AND eu_formation.code_membre = '$code_membreot'";

                        $db->setFetchMode(Zend_Db::FETCH_OBJ);

                        $stmtverifvaliditercodebci = $db->query($dbverifvaliditercodebci);

                        $verifvaliditercodebci = $stmtverifvaliditercodebci->fetchAll(); 

                        $countverifvaliditercodebci = count($verifvaliditercodebci);

                        if ($countverifvaliditercodebci == 0){

                             $validationerrors['enexpected_request'] = "le code BCi que vous avez renseigné est incorrecte";

                        }

                        if ($countverifvaliditercodebci != 0){

                            $id_candidature_formation = $verifvaliditercodebci[0]->id_candidature;

                            $id_candidature_poste_formation = $verifvaliditercodebci[0]->id_candidature_poste;

                            $dbotenirlecodedetransfert = "SELECT eu_candidature_membre.code_transfert_technologie
                
                                                          FROM eu_candidature_membre, eu_candidature_postes
           
                                                          WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes

                                                          AND eu_candidature_membre.id_candidature_postes = $id_candidature_poste_formation
                                                    
                                                          AND eu_candidature_membre.code_membre = '$code_membreot'

                                                          AND eu_candidature_postes.id_candidature = $id_candidature_formation
                                                        
                                                          AND eu_candidature_membre.preselection = 1
                                                        
                                                          AND eu_candidature_membre.code_transfert_technologie IS NOT NULL
                                                        
                                                          AND eu_candidature_membre.code_acces_salle IS NOT NULL";

                            $db->setFetchMode(Zend_Db::FETCH_OBJ);

                            $stmtotenirlecodedetransfert = $db->query($dbotenirlecodedetransfert);

                            $otenirlecodedetransfert = $stmtotenirlecodedetransfert->fetchAll(); 

                            $countobtenirlecodetransfert = count($dbotenirlecodedetransfert);

                            if ($countobtenirlecodetransfert == 0)
                            {

                                 $validationerrors['enexpected_request'] = "Votre code de transfert de technologie n'est pas encore disponible";

                            }

                            if ($countobtenirlecodetransfert != 0){

                                $code_transfert_technologie = $otenirlecodedetransfert[0]->code_transfert_technologie;

                            }

                        }
                }


            }

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)) {

                $updatevucodedetransfert = "UPDATE eu_candidature_membre
                
                                            SET eu_candidature_membre.vu_codetransferttechnologie = 1 
                              
                                            WHERE eu_candidature_membre.code_transfert_technologie = '$code_transfert_technologie'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                if ($db->query( $updatevucodedetransfert)){

                    $textcodeacces = "Votre code de transfert de technologie est $code_transfert_technologie";

                    $_SESSION['integritycodeacces'] = "";
    
                    $_SESSION['integritycodeacces'] = $textcodeacces;
                }

            }

        }


    }

    public function interfacedobtentiondesoncodedaccesalasalleAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $validationerrors = array();

        $sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membreot = $sessionmembre->code_membre;

        $code_acces_salle = "";

        $idcandidature_membre = "";

        $dbalreadyseencode = "SELECT eu_candidature_membre.code_acces_salle, eu_candidature_membre.id_candidature_membre
                
                              FROM eu_candidature_membre 
                                   
                              WHERE eu_candidature_membre.code_transfert_technologie IS NOT NULL

                              AND eu_candidature_membre.vu_codeacces = 1
                                                                      
                              AND eu_candidature_membre.code_acces_salle IS NOT NULL
                                   
                              AND eu_candidature_membre.preselection = 1
                                        
                              AND eu_candidature_membre.code_membre = '$code_membreot'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtalreadyseencode = $db->query($dbalreadyseencode);
                
        $alreadyseencode = $stmtalreadyseencode->fetchAll(); 

        $countalreadyseencode = count($alreadyseencode);

        $this->view->countalreadyseencode = $countalreadyseencode;

        $this->view->alreadyseencode = $alreadyseencode;


        if ($request->isPost()){

            $id_candidature_membre = "";

            $code_transfert_technologie =  htmlspecialchars($_POST['ot_code_transfert_technologie']);

            if (!isset($code_transfert_technologie)){
                
                $validationerrors['enexpected_request'] = "Vous tentez d'effectuer une opération qui n'est pas autorisé";

            } 

            if ($code_transfert_technologie == ""){

                $validationerrors['empty_code_transfert'] = "Vous devez renseigné le code de transfert de technologie";

            }

            if ($code_transfert_technologie != "") {

                $dbverifiervalidcode = "SELECT eu_candidature_membre.code_acces_salle, eu_candidature_membre.id_candidature_membre
                
                                        FROM eu_candidature_membre 
                                   
                                        WHERE eu_candidature_membre.code_transfert_technologie = '$code_transfert_technologie'

                                        AND eu_candidature_membre.code_membre = '$code_membreot'
                                   
                                        AND eu_candidature_membre.code_acces_salle IS NOT NULL
                                   
                                        AND eu_candidature_membre.preselection = 1";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifiervalidcode = $db->query($dbverifiervalidcode);
                
                $verifiervalidcode = $stmtverifiervalidcode->fetchAll(); 

                $countverifiervalidcode = count($verifiervalidcode);

                if ($countverifiervalidcode == 0) {

                     $validationerrors['empty_type_transfert'] = "Le code de transfert de technologie que vous avez renseigné n'est pas correcte";

                }

                

                if ($countverifiervalidcode != 0) {

                    $code_acces_salle = $verifiervalidcode[0]->code_acces_salle;

                    $id_candidature_membre = $verifiervalidcode[0]->id_candidature_membre;
                }
             
            }


            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)) {

                
                $updatetpyedetransfert = "UPDATE eu_candidature_membre
                
                                          SET eu_candidature_membre.vu_codeacces = 1 
                              
                                          WHERE eu_candidature_membre.code_transfert_technologie = '$code_transfert_technologie'
                                          
                                          AND eu_candidature_membre.code_acces_salle = '$code_acces_salle'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                if ($db->query( $updatetpyedetransfert)){

                    $textcodeacces = "Votre code d'accès à la salle virtuelle/physique est $code_acces_salle";

                    $_SESSION['integritycodeacces'] = "";
    
                    $_SESSION['integritycodeacces'] = $textcodeacces;
                }

            }

        }
    }

    public function ajaxemissiondecodedevalidationdepouvoirfaireAction ()
    {

        $this->_helper->layout->disableLayout();

        $db = Zend_Db_Table::getDefaultAdapter();

        $resultjson = array();

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $created = Zend_Date::now();

            $codeMembreOt = $_POST['code_membre_ot'];

            $idCandidatureMembreOt = $_POST['idCandidatureMembreOt'];

            $idCandidaturePosteOt = $_POST['idCandidaturePosteOt'];

            $idUtilisateurOt = $_POST['id_utilisateur_ot'];

            $nomCompletDeLagent = $_POST['nom_complet_ot'];

            $dateGenerateKey = $created->toString('yyyy-MM-dd HH:mm:ss');


            if ($codeMembreOt != "" && $idCandidatureMembreOt != "" && $idCandidaturePosteOt != "")
            {
                $dbverifierlexistanceotpouvoir = "SELECT eu_candidature_membre.id_candidature_membre
                
                                                  FROM eu_candidature_membre
                                           
                                                  WHERE eu_candidature_membre.code_membre = '$codeMembreOt'
                                           
                                                  AND eu_candidature_membre.id_candidature_membre = $idCandidatureMembreOt
                                           
                                                  AND eu_candidature_membre.id_candidature_postes = $idCandidaturePosteOt
                                           
                                                  AND eu_candidature_membre.code_transfert_technologie IS NOT NULL
                                           
                                                  AND eu_candidature_membre.code_acces_salle IS NOT NULL
                                           
                                                  AND eu_candidature_membre.code_pouvoirfaire IS NULL
                                           
                                                  AND eu_candidature_membre.preselection = 1
                                           
                                                  AND eu_candidature_membre.type_transfert_technologie IS NOT NULL
                                           
                                                  AND eu_candidature_membre.vu_codeacces = 1
                                           
                                                  AND eu_candidature_membre.vu_codetransferttechnologie = 1"; 

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifierlexistanceotpouvoir = $db->query($dbverifierlexistanceotpouvoir);

                $verifierlexistanceotpouvoir = $stmtverifierlexistanceotpouvoir->fetchAll();   

                $countverifierlexistanceotpouvoir = count($verifierlexistanceotpouvoir);

                if ($countverifierlexistanceotpouvoir == 0) {

                    $resultjson = array(

                        'result'=>'Error 404: Vous tentez d\'effectuer une action qui n\'est pas autorisé'
                   );

                }

                if ($countverifierlexistanceotpouvoir != 0) {
                     
                    $code_pouvoirfaire = strtoupper(substr(sha1(password_hash(md5(uniqid(rand(), true)), PASSWORD_BCRYPT)), -12));
                                        
                    $dbgenerationdecodevalidationpouvoirfaire = "UPDATE eu_candidature_membre 
                    
                                                                 SET eu_candidature_membre.code_pouvoirfaire = '$code_pouvoirfaire'
                                  
                                                                 WHERE eu_candidature_membre.code_membre = '$codeMembreOt'";
                    
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    if ($db->query($dbgenerationdecodevalidationpouvoirfaire)) {

                         $dbhistoriqueinsert = "INSERT INTO eu_historiques_operations(nom_table, 
                         
                                                                                    id_utilisateur, 
                                                                                    
                                                                                    code_membre, 
                                                                                    
                                                                                    libelle_operation, 
                                                                                    
                                                                                    type_module, 
                                                                                    
                                                                                    date_operation) VALUES (

                                                                                    'eu_candidature_membre',

                                                                                    $idUtilisateurOt,

                                                                                    '$codeMembreOt',

                                                                                    'Génération de code de pouvoir-faire par Mr/Mme $nomCompletDeLagent',

                                                                                    'AGrOT',

                                                                                    '$dateGenerateKey'

                                                                                    )";                   

                     $db->setFetchMode(Zend_Db::FETCH_OBJ);

                     $stmthistoriqueinsert = $db->query($dbhistoriqueinsert);

                        if ($stmthistoriqueinsert){

                             $resultjson = array(

                                 'result'=>"La génération du code de pouvoir-faire à été faite avec succès"
                             );

                        }

                    }
    
               }
            }

            
        }

        
        header('Content-type:application/json');

        die(json_encode($resultjson));
    }


    public function ajaxemissionducodeaccesautransfertdetechnologieAction () {
        
        $this->_helper->layout->disableLayout();

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $resultjson = array();

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $level_validationot = 4;

            $codeMembreOt = $_POST['code_membre_ot'];

            $idCandidatureMembreOt = $_POST['idCandidatureMembreOt'];

            $idCandidaturePosteOt = $_POST['idCandidaturePosteOt'];

            if ($level_validationot == 4) {

                $dbverifierlexistanceot = "SELECT eu_candidature_membre.id_candidature_membre
                
                                           FROM eu_candidature_membre
                                           
                                           WHERE eu_candidature_membre.code_membre = '$codeMembreOt'
                                           
                                           AND eu_candidature_membre.id_candidature_membre = $idCandidatureMembreOt
                                           
                                           AND eu_candidature_membre.id_candidature_postes = $idCandidaturePosteOt
                                           
                                           AND eu_candidature_membre.code_transfert_technologie IS NULL
                                           
                                           AND eu_candidature_membre.code_acces_salle IS NULL
                                           
                                           AND eu_candidature_membre.code_pouvoirfaire IS NULL"; 

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifierlexistanceot = $db->query($dbverifierlexistanceot);

                $verifierlexistanceot = $stmtverifierlexistanceot->fetchAll();   

                $countverifierlexistanceot = count($verifierlexistanceot);

                if ($countverifierlexistanceot == 0) {

                    $resultjson = array(

                        'result'=>'Error 404: Vous tentez d\'effectuer une action qui n\'est pas autorisé'
                   );

                }

                if ($countverifierlexistanceot != 0) {
                     
                     $code_techno = strtoupper(substr(password_hash(md5(uniqid(rand(), true)), PASSWORD_BCRYPT), -15));

                     $code_acces_salle = strtoupper(substr(password_hash(sha1(md5(uniqid(rand(), true))), PASSWORD_BCRYPT), -18));

                                         
                     $dbgenerationdecodetransfertdetechno = "UPDATE eu_candidature_membre 
                     
                                                             SET eu_candidature_membre.code_transfert_technologie = '$code_techno',

                                                                 eu_candidature_membre.code_acces_salle = '$code_acces_salle' 
                                   
                                                             WHERE eu_candidature_membre.code_membre = '$codeMembreOt'
                                           
                                                             AND eu_candidature_membre.id_candidature_membre = $idCandidatureMembreOt
                                           
                                                             AND eu_candidature_membre.id_candidature_postes = $idCandidaturePosteOt
                                           
                                                             AND eu_candidature_membre.code_transfert_technologie IS NULL
                                           
                                                             AND eu_candidature_membre.code_acces_salle IS NULL
                                           
                                                             AND eu_candidature_membre.code_pouvoirfaire IS NULL";
                     
                     $db->setFetchMode(Zend_Db::FETCH_OBJ);

                     if ($db->query($dbgenerationdecodetransfertdetechno)) {

                        $resultjson = array(

                            'result'=>"La génération du code d'accès à la technologie à été faite avec succès"
                        );
                     }
     
                }
            }
        }

        header('Content-type:application/json');

        die(json_encode($resultjson));
    }

    public function ajaxagentvalidationsendtosendAction () {

        $this->_helper->layout->disableLayout();

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $resultjson = array();

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $level_validation = $_POST['level_validation_ot'];

            $idcandidaturemembreot = $_POST['id_candidaturemembre'];

            $codemembrecandidatureot = $_POST['code_membre_candidature'];

            $idcandidaturepostot = $_POST['id_candidature_post'];

            $idcandidatureot = $_POST['id_candidature'];

            $validation = 0;

            $updatevalidation = 0;

            if ($level_validation == "administrateur"){

                $validation = 0;

                $updatevalidation = 1;

            }

            /*
    
            if ($level_validation == "Presentiel"){

                 $validation = 0;

                 $updatevalidation = 1;
                
            }elseif ($level_validation == "Ponctualite"){

                $validation = 1;

                $updatevalidation = 2;

                
            }elseif ($level_validation == "Productivite"){

                $validation = 2;

                $updatevalidation = 3;
                
            }elseif($level_validation == "Salle-virtuel-physique"){

                $validation = 3;

                $updatevalidation = 4;

            }*/

            $dbvalidation = "SELECT eu_candidature_membre.id_candidature_membre
            
                             FROM eu_candidature_membre, eu_candidature_postes
                            
                             WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes
                             
                             AND eu_candidature_membre.id_candidature_membre = $idcandidaturemembreot
                             
                             AND eu_candidature_membre.id_candidature_postes = $idcandidaturepostot
                             
                             AND eu_candidature_membre.code_membre = '$codemembrecandidatureot'
                             
                             AND eu_candidature_postes.id_candidature = $idcandidatureot
                             
                             AND eu_candidature_membre.valid_ot = $validation

                             AND eu_candidature_membre.code_transfert_technologie IS NULL
                                           
                             AND eu_candidature_membre.code_acces_salle IS NULL
                         
                             AND eu_candidature_membre.code_pouvoirfaire IS NULL

                             AND eu_candidature_membre.preselection = 1

                             AND eu_candidature_membre.createcount = 0";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtvalidation = $db->query($dbvalidation);

            $validation = $stmtvalidation->fetchAll();

            $countdbverifvaliditer = count($validation);

            if ($countdbverifvaliditer == 0) {

                $resultjson = array(

                     'result'=>'Error 404: Vous tentez d\'effectuer une action qui n\'est pas autorisé'
                );

            }

            if ($countdbverifvaliditer != 0){

                $dbfupdate = "UPDATE eu_candidature_membre 
                
                              SET eu_candidature_membre.valid_ot = $updatevalidation 
                              
                              WHERE eu_candidature_membre.id_candidature_membre = $idcandidaturemembreot
                              
                              AND eu_candidature_membre.id_candidature_postes = $idcandidaturepostot
                             
                              AND eu_candidature_membre.code_membre = '$codemembrecandidatureot'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmt = $db->query($dbfupdate);

                $resultjson = array(

                    'result'=>"Affectation du dossier AOT à l'agent $level_validation éffectuée avec succès"
                );
            }
            
        }


        header('Content-type:application/json');

        die(json_encode($resultjson));
        
    }


    public function utfAction ()
    {

        $db = Zend_Db_Table::getDefaultAdapter();

        $dbselectticket = "SELECT * FROM eu_ticket_support";
    
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
    
        $stmtselectticket = $db->query($dbselectticket);
    
        $selectticket = $stmtselectticket->fetchAll();

        foreach ($selectticket as $key => $value) {

            $description = $value->description;

            var_dump(iconv("UTF-8", "CP1252", $description));
        }
    }

    public function interfacedemissiondecodedepouvoirfaireAction () {
        
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');	
        
        $login = $sessionutilisateur->login;

        if (!isset($login)){

            $this->_redirect('/administration/login');
        }

        if (isset($login)){

            $db = Zend_Db_Table::getDefaultAdapter();

            $level_validation = $sessionutilisateur->libelle_current_user;

            $id_utilisateur = $sessionutilisateur->id_utilisateur;

            $dbselectvalidationot = "SELECT eu_candidature_membre.id_candidature_membre, 
    
                                            eu_candidature_membre.id_candidature_postes,
    
                                            eu_candidature_membre.code_membre,
    
                                            eu_candidature_membre.date_postulat,
    
                                            eu_membre.nom_membre,
    
                                            eu_membre.prenom_membre,
    
                                            eu_roles.libelle_roles,
    
                                            eu_candidature_postes.id_candidature
            
                                     FROM eu_candidature_membre, eu_candidature_postes, eu_membre, eu_support_intrant_ot, eu_roles
                         
                                     WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes

                                     AND eu_candidature_membre.code_membre = eu_membre.code_membre

                                     AND eu_candidature_membre.id_candidature_membre = eu_support_intrant_ot.id_candidature_membre

                                     AND eu_candidature_postes.id_roles = eu_roles.id_roles
                         
                                     AND eu_candidature_membre.preselection = 1
    
                                     AND eu_candidature_membre.createcount = 0
                                     
                                     AND eu_candidature_membre.code_transfert_technologie  IS NOT NULL
                                     
                                     AND eu_candidature_membre.code_acces_salle IS NOT NULL
                                     
                                     AND eu_candidature_membre.code_pouvoirfaire IS NULL
                                     
                                     AND eu_candidature_membre.type_transfert_technologie IS NOT NULL
                                     
                                     AND eu_candidature_membre.vu_codeacces = 1
                                     
                                     AND eu_candidature_membre.vu_codetransferttechnologie = 1
                                     
                                     AND eu_candidature_membre.vu_pouvoirfaire = 0
                                     
                                     AND eu_candidature_membre.signature_contrat = 0";
    
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
    
            $stmtselectvalidationot = $db->query($dbselectvalidationot);
    
            $selectvalidationot = $stmtselectvalidationot->fetchAll();
    
            $countselectvalidationot = count($selectvalidationot);

            $this->view->id_utilisateur = $id_utilisateur;
            
            $this->view->selectvalidationot = $selectvalidationot;
    
            $this->view->level_validation = $level_validation;
    
            $this->view->countselectvalidationot = $countselectvalidationot;
        }

    }

    public function interfacedemissiondecodedetransfertdetechnologieAction () {

        /*$this->_helper->layout()->setLayout('layoutpublicesmcadmin');*/

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');	
        
        $login = $sessionutilisateur->login;

        $level_validation = $sessionutilisateur->libelle_current_user;

        if ($level_validation == "recrutement" || $login == "site"){

            $validation = 1;
        }

        /*
        if ($level_validation == "Presentiel"){

            $validation = 1;
        }

        if ($level_validation == "Ponctualite"){

            $validation = 2;

        }

        if ($level_validation == "Productivite"){

            $validation = 3;
        }

        if ($level_validation == "Salle-virtuelle-physique"){

            $validation = 4;
        }*/

        
        $dbselectvalidationot = "SELECT eu_candidature_membre.id_candidature_membre, 

                                        eu_candidature_membre.id_candidature_postes,

                                        eu_candidature_membre.code_membre,

                                        eu_candidature_membre.date_postulat,

                                        eu_membre.nom_membre,

                                        eu_membre.prenom_membre,

                                        eu_roles.libelle_roles,

                                        eu_candidature_postes.id_candidature
        
                                 FROM eu_candidature_membre, eu_candidature_postes, eu_candidature, eu_roles, eu_membre
                     
                                 WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes

                                 AND eu_candidature_membre.code_membre = eu_membre.code_membre
                                                      
                                 AND eu_candidature_postes.id_roles = eu_roles.id_roles
                     
                                 AND eu_candidature_membre.preselection = 1

                                 AND eu_candidature_membre.createcount = 0
                                 
                                 AND eu_candidature_membre.code_transfert_technologie IS NULL
                                 
                                 AND eu_candidature_membre.code_acces_salle IS NULL
                                 
                                 AND eu_candidature_membre.code_pouvoirfaire IS NULL
                                 
                                 AND eu_candidature_membre.id_utilisateur_create_count IS NULL
                                 
                                 AND eu_candidature_membre.vu_codeacces = 0
                                 
                                 AND eu_candidature_membre.vu_codetransferttechnologie = 0
                                 
                                 AND eu_candidature_membre.vu_pouvoirfaire = 0";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectvalidationot = $db->query($dbselectvalidationot);

        $selectvalidationot = $stmtselectvalidationot->fetchAll();

        $countselectvalidationot = count($selectvalidationot);
        
        $this->view->selectvalidationot = $selectvalidationot;

        $this->view->level_validation = $level_validation;

        $this->view->countselectvalidationot = $countselectvalidationot;

    }

    public function detailduprofilduncandidatAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $iddetailcandidat = (int)$this->_request->getParam('iddetailcandidat');

        $getcodemembre = (string)$this->_request->getParam('codemembre');

        $geidcandidature = (int)$this->_request->getParam('idcandidature');

        $getidcandidaturepost = (int)$this->_request->getParam('iddetailpost');

        $getidsupportintrantot = (int)$this->_request->getParam('idsupportintrantot');


        $validationerrors = array();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        
        $dbdetailcandidatmembre = "SELECT eu_candidature_membre.*,

                                       eu_roles.libelle_roles,

                                       eu_support_intrant_ot.folder_ref,

                                       eu_files_intrant_ot.type_files_intrant_ot,

                                       eu_files_intrant_ot.url_files_intrant_ot,

                                       eu_membre.nom_membre,
                                       
                                       eu_membre.prenom_membre
        
                                FROM eu_candidature_postes, 
                                
                                     eu_candidature_membre, 
                                     
                                     eu_candidature, 

                                     eu_roles,

                                     eu_support_intrant_ot,

                                     eu_files_intrant_ot,

                                     eu_membre
                                
                                WHERE eu_candidature_membre.code_membre = eu_membre.code_membre
                                
                                AND eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes
                                
                                AND eu_candidature_postes.id_roles = eu_roles.id_roles
                                
                                AND eu_candidature_postes.id_candidature = eu_candidature.id_candidature

                                AND eu_candidature_membre.id_candidature_membre = eu_support_intrant_ot.id_candidature_membre

                                AND eu_support_intrant_ot.id_support_intrant_ot = eu_files_intrant_ot.id_support_intrant_ot

                                AND eu_candidature_membre.code_membre = '$getcodemembre'

                                AND eu_support_intrant_ot.id_candidature_membre = $iddetailcandidat

                                AND eu_files_intrant_ot.id_support_intrant_ot = $getidsupportintrantot

                                AND eu_candidature_membre.id_candidature_postes = $getidcandidaturepost
                                
                                AND eu_candidature.id_candidature = $geidcandidature
                                
                                AND eu_candidature.id_utilisateur = $id_utilisateur";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtdetailcandidatmembre = $db->query($dbdetailcandidatmembre);
     
        $detailcandidatmembre = $stmtdetailcandidatmembre->fetchAll();

        $countcandidatdetail = count($detailcandidatmembre);

        $this->view->detailcandidat = $detailcandidatmembre;
        
        $this->view->countcandidatures = $countcandidatdetail;
    }
    
    public function soumissiondudossierotAction () {
        
        /**
         * LES INFORMATIONS DE LA SOUMISSION DE L'OFFRE DE TRAVAIL DU MEMBRE
         * AVR
         * LES INFORMATIONS SUR LA CONVERSION DES MONAIES EN BCI
         * CODE BCI
         */


    }



    public function listdesoumissiondudossierotAction () {


    }

    public function editiondudossierotAction () {

    }

    public function formsappeldoffreAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $date_created_candidature = $created->toString('yyyy-MM-dd HH:mm:ss');

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $validationerrors = array();


        $dbselectrolesfromauthor = "SELECT eu_user_roles_permissions.id_roles, eu_roles.parent_roles_id
        
                                    FROM eu_user_roles_permissions, eu_roles
                          
                                    WHERE eu_user_roles_permissions.id_roles = eu_roles.id_roles
                                    
                                    AND eu_user_roles_permissions.id_utilisateur = '$id_utilisateur'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtgetidroles = $db->query($dbselectrolesfromauthor);
     
        $id_roles_author = $stmtgetidroles->fetchAll();

        $this->view->idrolesauthor = $id_roles_author;

        if ($request->isPost()) {

            $date_expiration_ot = $_POST['date_expiration_ot'];

            $id_roles_author = htmlspecialchars($_POST['id_roles_author']);

            $collaborator_direct = htmlspecialchars($_POST['id_rolesauthordirectparent']);

            for ($i = 0; $i< count($_POST['id_poste_candidature']); $i++) {

                $id_poste_candidature = htmlspecialchars($_POST['id_poste_candidature'][$i]);

                if ($id_poste_candidature == "") {

                    $validationerrors['empty_libelle_poste_candidature'] = "Vous devez renseigner le libellé du poste";
 
                }

                if ($id_post_candidature != ""){

                    $dbsearchpost = "SELECT eu_roles.libelle_roles, eu_roles.id_roles

                                     FROM eu_roles, eu_roles_parents_distant

                                     WHERE eu_roles.id_roles = eu_roles_parents_distant.parents_roles

                                     AND eu_roles_parents_distant.id_roles = $id_roles_author

                                     AND eu_roles.id_roles = $id_poste_candidature

                                     UNION 

                                     SELECT eu_roles.libelle_roles, eu_roles.id_roles

                                     FROM eu_roles

                                     WHERE eu_roles.parent_roles_id = $collaborator_direct

                                     AND eu_roles.id_roles = $id_poste_candidature

                                     UNION

                                     SELECT eu_roles.libelle_roles, eu_roles.id_roles

                                     FROM eu_roles, eu_roles_parents_distant 

                                     WHERE eu_roles.id_roles = eu_roles_parents_distant.id_roles

                                     AND eu_roles_parents_distant.parents_roles = $id_roles_author

                                     AND eu_roles.parent_roles_id = $collaborator_direct
             
                                     AND eu_roles.id_roles = $id_poste_candidature ";

                        $db->setFetchMode(Zend_Db::FETCH_OBJ);

                        $stmtsearchpost = $db->query($dbsearchpost);

                        $listofallmyrubrik = $stmtsearchpost->fetchAll();

                if (count($listofallmyrubrik) == 0){

                    $validationerrors['empty_libelle_poste_candidature'] = "Vous n'avez pas les authorizations à ajouter ce poste";
                    
                }
                }

            }

        if(!empty($validationerrors)){

            $_SESSION['validationerrors'] = $validationerrors;

         }

         if(empty($validationerrors)){

             $ref_candidature_poste = substr(md5(uniqid(rand(), true)), 0, 8);

             $real_ref_candidature_poste = strtoupper('CANDIDATURE-'.$ref_candidature_poste);

             $dbcandidatureinsert = "INSERT INTO eu_candidature (id_utilisateur, candidature_key, date_candidature, date_expiration) 
             
                                     VALUES ( '$id_utilisateur', '$real_ref_candidature_poste', '$date_created_candidature', '$date_expiration_ot')";
                                     
             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             if ($db->query($dbcandidatureinsert)){

                 $searchidcandidaturebykey = "SELECT eu_candidature.id_candidature FROM eu_candidature WHERE eu_candidature.candidature_key = '$real_ref_candidature_poste'";

                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                 $stmtsearchidcandidaturebykey = $db->query($searchidcandidaturebykey);
     
                 $id_candidature_post = $stmtsearchidcandidaturebykey->fetchAll();

                 $real_idcandidaturepost = $id_candidature_post[0]->id_candidature;


                 for ($i = 0; $i< count($_POST['id_poste_candidature']); $i++) {

    
                         $id_poste_candidature = htmlspecialchars($_POST['id_poste_candidature'][$i]);
    
                         $dbcandidatureinsert = "INSERT INTO eu_candidature_postes (id_roles, id_candidature) 
             
                                            VALUES ( $id_poste_candidature, $real_idcandidaturepost )";

                         $db->setFetchMode(Zend_Db::FETCH_OBJ);

                         $db->query($dbcandidatureinsert);
                }

                $this->_redirect("/gestionoffredetravail/listdesappelacandidaturepourpreselection");

             }

         }

        }

    }
  
    public function listdesformsappeldoffreAction () {


    }

    public function detaildunappeldoffreAction () {

        $created = Zend_Date::now();

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $validationerrors = array();

        $iddetailcandidature = (int)$this->_request->getParam('iddetailcandidature');

        $dbselectdetailldunecandidature = "SELECT * 
        
                                           FROM eu_candidature 
                                
                                           WHERE eu_candidature.id_candidature = '$iddetailcandidature'
                                
                                           AND eu_candidature.id_utilisateur = '$id_utilisateur'";
                    
        $db->setFetchMode(Zend_Db::FETCH_OBJ);        
                                                
        $stmtdetailduncandidature = $db->query($dbselectdetailldunecandidature);
     
        $detaildunecandidature = $stmtdetailduncandidature->fetchAll();


        $dbselectdetaildunpostedecandidature = "SELECT eu_roles.libelle_roles, 
        
                                                       eu_candidature_postes.id_roles, 
                                                     
                                                       eu_candidature_postes.id_candidature, 
                                                     
                                                       eu_candidature_postes.id_candidature_postes

                                              FROM eu_candidature_postes, eu_roles 
                                
                                              WHERE eu_candidature_postes.id_roles = eu_roles.id_roles
                                              
                                              AND eu_candidature_postes.id_candidature = '$iddetailcandidature'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtdetaildunpostedecandidature = $db->query($dbselectdetaildunpostedecandidature);
     
        $selectdetaildunpostedecandidature = $stmtdetaildunpostedecandidature->fetchAll();

        $this->view->selectdetaildunpostedecandidature = $selectdetaildunpostedecandidature;

        $this->view->detaildunecandidature = $detaildunecandidature;
    }

    public function editionformsappeldoffreAction () {

        $created = Zend_Date::now();

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $validationerrors = array();

        $idmodificationcandidature = (int)$this->_request->getParam('idmodificationcandidature');

        $dbselectcandidatureamodifier = "SELECT * 
        
                                         FROM eu_candidature 
                                
                                         WHERE eu_candidature.id_candidature = '$idmodificationcandidature' 
                                
                                         AND eu_candidature.id_utilisateur = $id_utilisateur";
        
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtcandidatureamodifier = $db->query($dbselectcandidatureamodifier);
     
        $candidaturesamodifier = $stmtcandidatureamodifier->fetchAll();

        $dbselectrolesfromauthor = "SELECT eu_user_roles_permissions.id_roles, eu_roles.parent_roles_id
        
                                    FROM eu_user_roles_permissions, eu_roles

                                    WHERE eu_user_roles_permissions.id_roles = eu_roles.id_roles
        
                                    AND eu_user_roles_permissions.id_utilisateur = '$id_utilisateur'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtgetidroles = $db->query($dbselectrolesfromauthor);

        $id_roles_author = $stmtgetidroles->fetchAll();

        $dbselectcandidatureposteamodifier = "SELECT eu_roles.libelle_roles, 
        
                                                     eu_candidature_postes.id_roles, 
                                                     
                                                     eu_candidature_postes.id_candidature, 
                                                     
                                                     eu_candidature_postes.nbre_personnes,

                                                     eu_candidature_postes.id_candidature_postes

                                              FROM eu_candidature_postes, eu_roles 
                                
                                              WHERE eu_candidature_postes.id_roles = eu_roles.id_roles
                                              
                                              AND eu_candidature_postes.id_candidature = '$idmodificationcandidature'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtselectcandidatureposteamodifier = $db->query($dbselectcandidatureposteamodifier);
     
        $selectcandidatureposteamodifier = $stmtselectcandidatureposteamodifier->fetchAll();

        $this->view->selectcandidatureposteamodifier = $selectcandidatureposteamodifier;

        $this->view->candidaturesamodifier = $candidaturesamodifier;

        $this->view->ideditionrolesauthor = $id_roles_author;

        if ($request->isPost()){

            $idModificationCandidature = $_POST['id_modification_candidature'];

            $refCandidature = $_POST['reference_modification_candidature'];

            $dateExpiration= $_POST['date_expiration_ot'];

            if (count($_POST['id_poste_candidature_modification']) == 0){

                $validationerrors['error_poste_candidature_modification'] = "Vous devez ajouter au moins une poste à l'appel à candidature";

            }

            for ($i = 0; $i< count($_POST['id_poste_candidature_modification']); $i++) {

                for($j = 0; $j< count($_POST['label_nbre_personne_candidature_modification']); $j++){

                   $id_poste_candidature = htmlspecialchars($_POST['id_poste_candidature_modification'][$i]);

                   if ($id_poste_candidature == "") {

                        $validationerrors['empty_libelle_poste_candidature'] = "Vous devez renseigner le libellé du poste";
 
                   }

                }           

            }

        if(!empty($validationerrors)){

            $_SESSION['validationerrors'] = $validationerrors;

         }

         if(empty($validationerrors)){

             $dbcandidatureinsert = "UPDATE eu_candidature 
             
                                     SET eu_candidature.date_expiration = '$dateExpiration'
                                         
                                     WHERE eu_candidature.id_candidature = $idModificationCandidature";
                                     
             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             if ($db->query($dbcandidatureinsert)){

                 $searchidcandidaturebykey = "SELECT eu_candidature.id_candidature FROM eu_candidature WHERE eu_candidature.candidature_key = '$real_ref_candidature_poste'";

                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                 $stmtsearchidcandidaturebykey = $db->query($searchidcandidaturebykey);
     
                 $id_candidature_post_modification = $stmtsearchidcandidaturebykey->fetchAll();

                 $real_idcandidaturepost_modification = $id_candidature_post_modification[0]->id_candidature;


                 for ($i = 0; $i< count($_POST['id_poste_candidature_modification']); $i++) {

    
                         $id_poste_candidature_modification = $_POST['id_poste_candidature_modification'][$i];
    
                         $id_candidature_modification_poste = $_POST['id_candidature_modification_poste'][$i];

                         $dbcandidature_modification = "UPDATE eu_candidature_postes 
                         
                                                        SET eu_candidature_postes.id_roles = $id_poste_candidature_modification,  
                                                                                                                    
                                                        WHERE eu_candidature_postes.id_candidature_postes = $id_candidature_modification_poste
                                                       
                                                        AND eu_candidature_postes.id_candidature = $idmodificationcandidature";

                         $db->setFetchMode(Zend_Db::FETCH_OBJ);

                         $db->query($dbcandidature_modification);
                }

                $this->_redirect("/gestionoffredetravail/listdesappelacandidaturepourpreselection");

             }

         }

      }

    }

    // APPEL A CANDIDATURE

    public function supportintrantotAction () {


        /**
         * Est ce qu'il peut poster pour plusieurs poste d'un appel d'offre
         */

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $date_created_candidature = $created->toString('yyyy-MM-dd HH:mm:ss');

        $iddetailcandidaturepost = (int)$this->_request->getParam('idpostcandidature');

        $validationerrors = array();

        $sessionmembre = new Zend_Session_Namespace('membre');

        $code_membre_ot = $sessionmembre->code_membre;

        $tab_diplomes = array(
    
            '1'=>'CEPD', '2'=>'BEPC', '3'=>'BAC', '4'=>'BTS/DUT/BAC + 2', '5'=>'Licence', '6'=>'Maîtrise', '7'=>'Master', '8'=>'Docteur'
        );

        $tab_names_diplomes = array(
    
            '1'=>'ot_cepd', '2'=>'ot_bepc', '3'=>'ot_bac', '4'=>'ot_bts-dut-autre', '5'=>'ot_licence', '6'=>'ot_maitrise', '7'=>'ot_master', '8'=>'ot_docteur'
        );
                    

        
        $dbselectdate = "SELECT * FROM eu_candidature WHERE eu_candidature.id_candidature = '$iddetailcandidaturepost'"; 

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectdate = $db->query($dbselectdate);
     
        $selectcandidature = $stmtselectdate->fetchAll();


        $detaildunecandidaturepourpostuler = "SELECT eu_roles.libelle_roles, 
        
                                                     eu_candidature_postes.id_roles, 

                                                     eu_candidature_postes.id_candidature, 
                                                     
                                                     eu_candidature_postes.id_candidature_postes

                                              FROM eu_candidature_postes

                                              LEFT JOIN eu_roles ON  eu_candidature_postes.id_roles = eu_roles.id_roles

                                              LEFT JOIN eu_candidature_membre ON eu_candidature_postes.id_candidature_postes = eu_candidature_membre.id_candidature_postes 
                                
                                              WHERE eu_candidature_postes.id_candidature = $iddetailcandidaturepost";
        
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtdetaildunecandidaturepourpostuler = $db->query($detaildunecandidaturepourpostuler);
     
        $fetchdetaildunecandidaturepourpostuler = $stmtdetaildunecandidaturepourpostuler->fetchAll();

        $selectalreadycandidaturepost = "SELECT eu_roles.libelle_roles, 
        
                                                eu_candidature_postes.id_roles, 
                                                     
                                                eu_candidature_postes.id_candidature, 
                                                     
                                                eu_candidature_postes.nbre_personnes,

                                                eu_candidature_postes.id_candidature_postes

                                         FROM eu_candidature_postes

                                         LEFT JOIN eu_roles ON  eu_candidature_postes.id_roles = eu_roles.id_roles

                                         RIGHT JOIN eu_candidature_membre ON eu_candidature_postes.id_candidature_postes = eu_candidature_membre.id_candidature_postes 
                                
                                         WHERE eu_candidature_postes.id_candidature = $iddetailcandidaturepost
                                              
                                         AND eu_candidature_membre.id_candidature_postes IS NOT NULL
                                              
                                         AND eu_candidature_membre.code_membre = '$code_membre_ot'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtselectalreadycandidaturepost = $db->query($selectalreadycandidaturepost);
     
        $fetchalreadycandidatureposts = $stmtselectalreadycandidaturepost->fetchAll();

        $countalreadycandidatureposts = count($fetchalreadycandidatureposts);

        $this->view->selectallcandidature = $selectcandidature;

        $this->view->detaildunecandidaturepourpostuler = $fetchdetaildunecandidaturepourpostuler;

        $this->view->idcandidature = $iddetailcandidaturepost;

        $this->view->alreadypostcandidature = $fetchalreadycandidatureposts;
        
        $this->view->countalreadycandidatureposts = $countalreadycandidatureposts;

        $this->view->tab_diplomes = $tab_diplomes; 

        $this->view->id_candidature = $iddetailcandidaturepost;           

        if ($request->isPost()) {
            
            $id_offre_ot_post = htmlspecialchars($_POST['offre_post_ot']);

            $lettre_manifestation_name = $_FILES['ot_lettre_manifestation_interet']['name'];

            $lettre_manifestation_tmpname = $_FILES['ot_lettre_manifestation_interet']['tmp_name'];

            $lettre_manifestation_type = $_FILES['ot_lettre_manifestation_interet']['type'];

            $lettre_manifestation_size = $_FILES['ot_lettre_manifestation_interet']['size'];

            $ot_curriculum_vitae_name = $_FILES['ot_curriculum_vitae']['name'];

            $ot_curriculum_vitae_tmpname = $_FILES['ot_curriculum_vitae']['tmp_name'];


            $ot_curriculum_vitae_type = $_FILES['ot_curriculum_vitae']['type'];

            $ot_curriculum_vitae_size = $_FILES['ot_lettre_manifestation_interet']['size'];

            $select_diploma_name = htmlspecialchars($_POST['select_last_diploma_name']);

            $code_bci_ot = htmlspecialchars($_POST['code_bci_ot']);

            $id_candidature = htmlspecialchars($_POST['id_candidature_ot']);

            $type_transfert = htmlspecialchars($_POST['ot_type_transfert']);


            $tab_names_diplomes = array(
    
                '1'=>'ot_cepd', '2'=>'ot_bepc', '3'=>'ot_bac', '4'=>'ot_bts-dut-autre', '5'=>'ot_licence', '6'=>'ot_maitrise', '7'=>'ot_master', '8'=>'ot_docteur'
            );


             if (!isset($id_offre_ot_post)) 
             {

                $validationerrors['error_files'] = "Vous devez selectionné un poste dans cet appel d'offre";

             }

             if (!isset($code_bci_ot)) 
             {

                $validationerrors['error_code_bci'] = "Vous devez renseigné votre code BCI avant de postuler";
             }

             if (isset($code_bci_ot)){


                    $dbselectcheckcodebci = "SELECT * 
                
                                             FROM eu_formation
                             
                                             WHERE eu_formation.code_bci = '$code_bci_ot'
                                             
                                             AND eu_formation.id_candidature_poste = $id_offre_ot_post
                                             
                                             AND eu_formation.id_candidature = $id_candidature";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
                    $stmtselectcheckcodebci = $db->query($dbselectcheckcodebci);
     
                    $fetchselectcheckcodebci = $stmtselectcheckcodebci->fetchAll();

                    if (count($fetchselectcheckcodebci) == 0){

                        $validationerrors['error_files'] = "Vous devez acheté le poste, avant de soumettre votre dossier de candidature";

                    }



             }

             if ($type_transfert == ""){

                $validationerrors['empty_type_transfert'] = "Vous devez renseigné le type de transfert";

            }

            if ($type_transfert != ""){

                if (!in_array($type_transfert, array('présentielle', 'en ligne', 'automatisée'))){

                    $validationerrors['empty_type_transfert'] = "Cet type de transfert n'est pas autorisé";
    
                }

            }

             if (isset($id_offre_ot_post)) {

                $dbselectcheckidroles = "SELECT * 
                
                                         FROM eu_candidature_postes
                             
                                         WHERE eu_candidature_postes.id_candidature = $iddetailcandidaturepost
                             
                                         AND eu_candidature_postes.id_roles = $id_offre_ot_post";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
                $stmtselectcheckidroles = $db->query($dbselectcheckidroles);
     
                $fetchalselectcheckidroles = $stmtselectcheckidroles->fetchAll();

                $countselectcheckidroles = count($fetchalselectcheckidroles);


                if ($countselectcheckidroles > 0) {

                   $validationerrors['error_files'] = "Vous êtes entrain d'effectuer au niveau de la sélection des postes, une opération qui n'est pas autorisée";

                }


             }
            if (!isset($lettre_manifestation_name) && !isset($lettre_manifestation_size) && !isset($lettre_manifestation_type) &&
            
            !isset($lettre_manifestation_name) && !isset($lettre_manifestation_size) && !isset($lettre_manifestation_type) )
            {

                $validationerrors['error_files'] = "Vous devez renseigner les informations concernant les diplomes et compétences";


            }

            
            if (isset($lettre_manifestation_name) && isset($lettre_manifestation_size) && isset($lettre_manifestation_type) &&
            
            isset($lettre_manifestation_name) && isset($lettre_manifestation_size) && isset($lettre_manifestation_type) ) 
            
            {

                    if (!isset($_POST['select_last_diploma'])) 
                    {

                          $validationerrors['error_select_last_diploma'] = "Vous devez renseigner les informations concernant les diplomes et compétences";

                    }

                    if (isset($_POST['select_last_diploma'])) 
                    {

                        if ($_POST['select_last_diploma'] == "") 
                        {

                          $validationerrors['empty_last_diploma'] = "Vous devez selectionné votre dernier diplome";

                        }

                        if ($_POST['select_last_diploma'] != "") 
                        {

                            for ($i=$_POST['select_last_diploma']; $i>0;$i--)
                            {

                                $diploma_name = $_FILES["$tab_names_diplomes[$i]"]['name'];

                                $diploma_size = $_FILES["$tab_names_diplomes[$i]"]['size'];

                                $diploma_type = $_FILES["$tab_names_diplomes[$i]"]['type'];

                                $diplomaextension = strtolower(pathinfo($diploma_name,PATHINFO_EXTENSION));

                                if (!isset($diploma_name) && !isset($diploma_size) && !isset($diploma_type))
                                {

                                    $validationerrors['error_files_diploma'] = "Vous tentez d'éffectuer une action qui n'est pas autorisé ";

                                }

                                if (isset($diploma_name) || isset($diploma_size) || isset($diploma_type))
                                {


                                     if ($diploma_name == "" || $diploma_size == "" || $diploma_type == "") 
                                     {

                                        $validationerrors['empty_files_diploma'] = "Le diplome $diploma_name n'a pas été correctement envoyé ";

                                     }

                                     if(!in_array($diplomaextension,array('pdf','jpg','png','jpeg')))
                                     {

                                        $validationerrors['cvextensions'] = "Le diplome $diploma_name est sous un format non autorisé";

                                     }
                                }

                            }
                        }
                    }

            }

            if(!empty($validationerrors))
            {

                $_SESSION['validationerrors'] = $validationerrors;

            }

            if (empty($validationerrors))
            {
                    
                $lettre_manifestation_tmpname = $_FILES['ot_lettre_manifestation_interet']['tmp_name'];
    
                $ot_curriculum_vitae_tmpname = $_FILES['ot_curriculum_vitae']['tmp_name'];

                $uploadkey_ot = substr(md5(uniqid(rand(), true)), 0, 8);

                if ($lettre_manifestation_tmpname != "" || $ot_curriculum_vitae_tmpname != "") 
                {

                    $get_lettre_manifestation_extension =strtolower(pathinfo($lettre_manifestation_name,PATHINFO_EXTENSION));

                    $get_curriculum_vitae_extension = strtolower(pathinfo( $ot_curriculum_vitae_name,PATHINFO_EXTENSION));

                    if (!is_dir("../../webfiles/docot/$uploadkey_ot")) 
                    {

                        mkdir("../../webfiles/docot/$uploadkey_ot/", 0777);
                    
                    }

                        $dir_files_letter = $code_membre_ot."-ESMC-MANIF-LETTER".".".$get_lettre_manifestation_extension;

                        $dir_files_cv = $code_membre_ot."-ESMC-CV".".".$get_curriculum_vitae_extension;

                        $src_file_letter = "../../webfiles/docot/$uploadkey_ot/$dir_files_letter";

                        $src_file_cv = "../../webfiles/docot/$uploadkey_ot/$dir_files_cv";

                        
                        if (move_uploaded_file($lettre_manifestation_tmpname, $src_file_letter))
                        {

                            if (move_uploaded_file($ot_curriculum_vitae_tmpname, $src_file_cv)) 
                            {

                                if (isset($_POST['select_last_diploma'])) 
                                {

                                    if ($_POST['select_last_diploma'] != "") 
                                    {
                
                                        for ($i=$_POST['select_last_diploma']; $i>0;$i--)
                                        {
                
                                            $diploma_name = $_FILES["$tab_names_diplomes[$i]"]['name'];
                                
                                            $diploma_type = $_FILES["$tab_names_diplomes[$i]"]['type'];
                
                                            $diploma_tmp = $_FILES["$tab_names_diplomes[$i]"]['tmp_name'];
                
                                            $explodelastdiploma = explode('_',$tab_names_diplomes[$i]);


                                            $selectDiplomaName = strtoupper($explodelastdiploma[1]);

                                            $diplomaextension = strtolower(pathinfo($diploma_name,PATHINFO_EXTENSION));
                
                
                                            if ($diploma_tmp != "") 
                                            {
                                            
                                                    $dir_files_diploma = $code_membre_ot."-ESMC-$selectDiplomaName".".". $diplomaextension;
                            
                                                    $src_file_diploma = "../../webfiles/docot/$uploadkey_ot/$dir_files_diploma";
                                        
                                                    move_uploaded_file($diploma_tmp, $src_file_diploma);
                            
                                            }
                
                                        }

                                        $dbmembrecandidatureinsert = "INSERT INTO eu_candidature_membre (code_membre, id_candidature_postes, type_transfert_technologie, date_postulat) 
    
                                                                VALUES ( '$code_membre_ot', '$id_offre_ot_post', '$type_transfert','$date_created_candidature' )";
     
                                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
     
                                        if ($db->query($dbmembrecandidatureinsert)) {

                                            $dbselectidcandidat = "SELECT eu_candidature_membre.id_candidature_membre

                                                                   FROM eu_candidature_membre

                                                                   WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_membre.id_candidature_postes
                                                         
                                                                   AND eu_candidature_membre.code_membre = '$code_membre_ot'
                                                         
                                                                   AND eu_candidature_membre.id_candidature_postes = '$id_offre_ot_post'";

                                            $db->setFetchMode(Zend_Db::FETCH_OBJ);

                                            $stmtselectidcandidat = $db->query($dbselectidcandidat);

                                            $dbfetchgetidcandidat = $stmtselectidcandidat->fetchAll(); 

                                            $countfetchgetidcandidat = count($dbfetchgetidcandidat);

                                            if ($countfetchgetidcandidat != 0) {
 
                                                $fetchgetidcandidat = $dbfetchgetidcandidat[0]->id_candidature_membre; 

                                                if ($fetchgetidcandidat != 0) {

                                                    $dbinsertsupportintrant = "INSERT INTO eu_support_intrant_ot (folder_ref, id_candidature_membre, date_created) 
    
                                                                               VALUES ( '$uploadkey_ot', $fetchgetidcandidat, '$date_created_candidature')";
    
                                                    $db->setFetchMode(Zend_Db::FETCH_OBJ);  
                                                    
                                                    if ($db->query($dbinsertsupportintrant)){

                                                        $dbselectidsupport = "SELECT eu_support_intrant_ot.id_support_intrant_ot

                                                                               FROM eu_support_intrant_ot

                                                                               WHERE eu_support_intrant_ot.folder_ref = '$uploadkey_ot'";

                                                        $db->setFetchMode(Zend_Db::FETCH_OBJ);

                                                        $stmtselectidsupport = $db->query($dbselectidsupport);

                                                        $dbfetchgetidsupport = $stmtselectidsupport->fetchAll(); 

                                                        $countfetchgetidsupport = count($dbfetchgetidsupport);

                                                        if ($countfetchgetidsupport != 0) {

                                                            $id_supportintrantot = $dbfetchgetidsupport[0]->id_support_intrant_ot;

                                                            $dbinsertletter = "INSERT INTO eu_files_intrant_ot (type_files_intrant_ot, url_files_intrant_ot, id_support_intrant_ot) 
    
                                                                               VALUES ('LETTRE DE MANIFESTATION D\'INTERET', '$dir_files_letter', '$id_supportintrantot')";
            
                                                            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                                                            if ($db->query($dbinsertletter)){
            
                                                                $dbinsertcv = "INSERT INTO eu_files_intrant_ot (type_files_intrant_ot, url_files_intrant_ot, id_support_intrant_ot) 
                
                                                                               VALUES ('CURRICULUM VITAE', '$dir_files_cv', '$id_supportintrantot')";
            
                                                                $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                                                                if ($db->query($dbinsertcv)){
            
                                                                    for ($i=$_POST['select_last_diploma']; $i>0;$i--)
                                                                    {
                                                                        $diploma_name = $_FILES["$tab_names_diplomes[$i]"]['name'];
                                            
                                                                        $diploma_type = $_FILES["$tab_names_diplomes[$i]"]['type'];
                                            
                                                                        $diploma_tmp = $_FILES["$tab_names_diplomes[$i]"]['tmp_name'];
                                            
                                                                        $explodelastdiploma = explode('_',$tab_names_diplomes[$i]);


                                                                        $selectDiplomaName = strtoupper($explodelastdiploma[1]);
                                            
                                                                        $diplomaextension = strtolower(pathinfo($diploma_name,PATHINFO_EXTENSION));
                                            
                                            
                                                                        if ($diploma_tmp != "") 
                                                                        {
                                                                        
                                                                                $dir_files_diploma = $code_membre_ot."-ESMC-$selectDiplomaName".".". $diplomaextension;
                                                                                                                
                                                                                $dbinsertdiploma = "INSERT INTO eu_files_intrant_ot ( type_files_intrant_ot, url_files_intrant_ot, id_support_intrant_ot) 
                
                                                                                VALUES ( '$selectDiplomaName', '$dir_files_diploma', '$id_supportintrantot')";
                            
                                                                                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                                                                                $db->query($dbinsertdiploma);
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

                $this->_redirect("/gestionoffredetravail/interfacedesuividelacandidaturedelot");


            }
            
        }

    }

    public function testrechercherAction (){

        $this->_helper->layout->disableLayout();


/*

        $resultjson = array();

        $db = Zend_Db_Table::getDefaultAdapter();        

        $dbsearchpost = "SELECT eu_roles.libelle_roles, eu_roles.id_roles FROM eu_roles WHERE eu_roles.id_odd IS NULL";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtsearchpost = $db->query($dbsearchpost);

        $listofallmyrubrik = $stmtsearchpost->fetchAll();


/*
        foreach ($listofallmyrubrik as $key => $value) {
            
            $resultjson[] = array(

                'id_roles'=>$value->id_roles,

                'libelle_roles'=>$value->libelle_roles
            );
        }   */     
        
        
  /*      header('Content-type:application/json');
        
        die(json_encode($listofallmyrubrik, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE));*/

    }




    public function rechercherrolesforcandidatureAction () {

        $this->_helper->layout->disableLayout();

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $resultjson = array();

        
        $sessionadministrateur = new Zend_Session_Namespace('utilisateur');

        $id_utilisateur = $sessionadministrateur->id_utilisateur;

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();

        }else{

/*
            if ($id_utilisateur == 140){


                $dbsearchpost = "SELECT eu_roles.libelle_roles, eu_roles.id_roles FROM eu_roles";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtsearchpost = $db->query($dbsearchpost);
    
                $listofallmyrubrik = $stmtsearchpost->fetchAll();
                
                $resultjson = $listofallmyrubrik;

                var_dump($resultjson);
                
            }elseif ($id_utilisateur != 140) {*/

                $libelle_poste = htmlspecialchars($_POST['libelle_roles_ot']);

                $id_roles_author = htmlspecialchars($_POST['id_roles_author']);
    
                $id_roles_author_parent = htmlspecialchars($_POST['id_author_parent']);

                $dbsearchpost = " SELECT eu_roles.libelle_roles, eu_roles.id_roles

                FROM eu_roles, eu_roles_parents_distant

                WHERE eu_roles.id_roles = eu_roles_parents_distant.parents_roles

                AND eu_roles_parents_distant.id_roles = $id_roles_author

                AND eu_roles.libelle_roles like '%$libelle_poste%'

                UNION 

                SELECT eu_roles.libelle_roles, eu_roles.id_roles

                FROM eu_roles

                WHERE eu_roles.parent_roles_id = $id_roles_author_parent

                AND eu_roles.libelle_roles like '%$libelle_poste%'

                UNION

                SELECT eu_roles.libelle_roles, eu_roles.id_roles

                FROM eu_roles, eu_roles_parents_distant 

                WHERE eu_roles.id_roles = eu_roles_parents_distant.id_roles

                AND eu_roles_parents_distant.parents_roles = $id_roles_author
             
                AND eu_roles.libelle_roles like '%$libelle_poste%' ";

                
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtsearchpost = $db->query($dbsearchpost);

            $listofallmyrubrik = $stmtsearchpost->fetchAll();
            
            $resultjson = $listofallmyrubrik;


        }


        header('Content-type:application/json');
        
        die(json_encode($resultjson));

    }
    
    public function ajouterunappelacandidatureAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $date_created_candidature = $created->toString('yyyy-MM-dd HH:mm:ss');


        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $validationerrors = array();


        $dbselectrolesfromauthor = "SELECT eu_user_roles_permissions.id_roles, eu_roles.parent_roles_id
        
                                    FROM eu_user_roles_permissions, eu_roles
                          
                                    WHERE eu_user_roles_permissions.id_roles = eu_roles.id_roles
                                    
                                    AND eu_user_roles_permissions.id_utilisateur = '$id_utilisateur'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtgetidroles = $db->query($dbselectrolesfromauthor);
     
        $id_roles_author = $stmtgetidroles->fetchAll();

        $this->view->idrolesauthor = $id_roles_author;

        if ($request->isPost()) {

            $competences = htmlspecialchars($_POST['diplome_competence']);

            $nbre_annee_experience = htmlspecialchars($_POST['nbre_annee_experience']);

            if($competences == ""){

                $validationerrors['empty_id_travailleur'] = "Vous devez renseigner les informations concernant les diplomes et compétences";

            }

            if(!array_key_exists('diplome_competence', $_POST) ){

                $validationerrors['error_diplome_competence'] = "Erreur 404:Vous éssayez d'effectuer une action qui n'est pas autorisé";

            }

            if ($nbre_annee_experience == ""){
                
                $validationerrors['empty_id_travailleur'] = "Vous devez renseigner les informations concernant le nombre d'année d'expérience";

            }

            
            if(!array_key_exists('nbre_annee_experience', $_POST) ){

                $validationerrors['error_nbre_annee_experience'] = "Erreur 404:Vous éssayez d'effectuer une action qui n'est pas autorisé";

            }


            if (count($_POST['id_poste_candidature']) == 0){

                $validationerrors['error_nbre_annee_experience'] = "Vous devez ajouter au moins une poste à l'appel à candidature";

            }

            if (count($_POST['label_nbre_personne_candidature']) == 0){

                $validationerrors['error_nbre_annee_experience'] = "Vous devez ajouter au moins le nombre de personnes au poste";

            }

            for ($i = 0; $i< count($_POST['id_poste_candidature']); $i++) {

                for($j = 0; $j< count($_POST['label_nbre_personne_candidature']); $j++){

                   $id_poste_candidature = htmlspecialchars($_POST['id_poste_candidature'][$i]);

                   $label_nbre_personne_candidature = htmlspecialchars($_POST['label_nbre_personne_candidature'][$j]);

                   if ($id_poste_candidature == "") {

                    $validationerrors['empty_libelle_poste_candidature'] = "Vous devez renseigner le libellé du poste";
 
                   }

                   if ($label_nbre_personne_candidature == "") {

                         $validationerrors['empty_label_nbre_personne_candidature'] = "Vous devez renseigner le nombre de personne souhaité pour ce poste";
 
                    }

                }           

            }

        if(!empty($validationerrors)){

            $_SESSION['validationerrors'] = $validationerrors;

         }

         if(empty($validationerrors)){

             $ref_candidature_poste = substr(md5(uniqid(rand(), true)), 0, 8);

             $real_ref_candidature_poste = strtoupper('CANDIDATURE-'.$ref_candidature_poste);

             $dbcandidatureinsert = "INSERT INTO eu_candidature (id_utilisateur, competences, candidature_key, annee_experience, date_candidature) 
             
                                     VALUES ( '$id_utilisateur', '$competences', '$real_ref_candidature_poste', '$nbre_annee_experience', '$date_created_candidature' )";
                                     
             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             if ($db->query($dbcandidatureinsert)){

                 $searchidcandidaturebykey = "SELECT eu_candidature.id_candidature FROM eu_candidature WHERE eu_candidature.candidature_key = '$real_ref_candidature_poste'";

                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                 $stmtsearchidcandidaturebykey = $db->query($searchidcandidaturebykey);
     
                 $id_candidature_post = $stmtsearchidcandidaturebykey->fetchAll();

                 $real_idcandidaturepost = $id_candidature_post[0]->id_candidature;


                 for ($i = 0; $i< count($_POST['id_poste_candidature']); $i++) {

    
                         $id_poste_candidature = htmlspecialchars($_POST['id_poste_candidature'][$i]);
    
                         $label_nbre_personne_candidature = htmlspecialchars($_POST['label_nbre_personne_candidature'][$i]);

                         $dbcandidatureinsert = "INSERT INTO eu_candidature_postes (id_roles, id_candidature, nbre_personnes) 
             
                                            VALUES ( $id_poste_candidature, $real_idcandidaturepost,$label_nbre_personne_candidature )";

                         $db->setFetchMode(Zend_Db::FETCH_OBJ);

                         $db->query($dbcandidatureinsert);
                }

                $this->_redirect("/gestionoffredetravail/listdesappelacandidaturepourpreselection");

             }

         }

      }


    }

    public function closeappelacandidatureAction () {

        $this->_helper->layout->disableLayout();

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $resultjson = array();

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();
        }

    }

    public function listdesappelacandidaturepourpreselectionAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $sessionadministrateur = new Zend_Session_Namespace('utilisateur');

        $login = $sessionadministrateur->login;
        
        
        if ($login == ""){

            $this->_redirect('/administration/login');

        }else{

             $id_utilisateur = $sessionadministrateur->id_utilisateur;
    
             $listdetouslescandidatures = "SELECT * 
             
                                           FROM eu_candidature 
                                           
                                           WHERE eu_candidature.id_utilisateur = '$id_utilisateur'
                                           
                                           AND eu_candidature.dead_selection = 0";

             $db->setFetchMode(Zend_Db::FETCH_OBJ);
    
             $stmtlistdetouslescandidature = $db->query($listdetouslescandidatures);
         
             $listedemescandidatures = $stmtlistdetouslescandidature->fetchAll();
    
             $countlistedemescandidatures = count($listedemescandidatures);

             $tabslistdescandidats = array();

             foreach($listedemescandidatures as $key => $value){
 
                 $id_candidature = $value->id_candidature;

                 $reference_candidature = $value->candidature_key;

                 $date_postulat = $value->date_candidature;

                 $date_expiration = $value->date_expiration;

                 $selectcheckcandidat = "SELECT eu_candidature_membre.id_candidature_membre
             
                                         FROM eu_candidature_membre, eu_candidature, eu_candidature_postes
                                     
                                         WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes
                                     
                                         AND eu_candidature_postes.id_candidature = eu_candidature.id_candidature
                                     
                                         AND eu_candidature.id_candidature = $id_candidature
                                         
                                         AND eu_candidature.dead_selection = 0 ";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $smtselectcheckcandidat = $db->query($selectcheckcandidat);

                $checkcandidat = $smtselectcheckcandidat->fetchAll();

                $countcheckcandidat = count($checkcandidat);

                if ($countcheckcandidat == 0) {

                    $check = 0;

                }else {

                    $check = 1;
                }

                $tabslistdescandidats[] = array(

                     'id_candidature_candidat'=>$id_candidature,

                     'reference_candidature_candidat'=>$reference_candidature,

                     'count_candidat' => $check,

                     'date_postulat_candidat' => $date_postulat,

                     'date_expiration' => $date_expiration
                );

             }



             $this->view->checkcandidat = $checkcandidat;
    
             $this->view->listedemescandidatures = $tabslistdescandidats;
    
             $this->view->countlistedemescandidatures = $countlistedemescandidatures;
    
             $this->view->tabletri = 1; 

        }

    }



    public function detaildunappelacandidatureAction () {

        $created = Zend_Date::now();

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $validationerrors = array();

        $iddetailcandidature = (int)$this->_request->getParam('iddetailcandidature');

        $dbselectdetailldunecandidature = "SELECT * 
        
                                           FROM eu_candidature 
                                
                                           WHERE eu_candidature.id_candidature = '$iddetailcandidature'
                                
                                           AND eu_candidature.id_utilisateur = '$id_utilisateur'";
                    
        $db->setFetchMode(Zend_Db::FETCH_OBJ);        
                                                
        $stmtdetailduncandidature = $db->query($dbselectdetailldunecandidature);
     
        $detaildunecandidature = $stmtdetailduncandidature->fetchAll();




        $dbselectdetaildunpostedecandidature = "SELECT eu_roles.libelle_roles, 
        
                                                     eu_candidature_postes.id_roles, 
                                                     
                                                     eu_candidature_postes.id_candidature, 
                                                     
                                                     eu_candidature_postes.id_candidature_postes

                                              FROM eu_candidature_postes, eu_roles 
                                
                                              WHERE eu_candidature_postes.id_roles = eu_roles.id_roles
                                              
                                              AND eu_candidature_postes.id_candidature = '$iddetailcandidature'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtdetaildunpostedecandidature = $db->query($dbselectdetaildunpostedecandidature);
     
        $selectdetaildunpostedecandidature = $stmtdetaildunpostedecandidature->fetchAll();

        $this->view->selectdetaildunpostedecandidature = $selectdetaildunpostedecandidature;

        $this->view->detaildunecandidature = $detaildunecandidature;

    }

    public function suppressionpostfromcandidaturebycloseAction() {

    }

    public function detaildunappelacandidaturepourpreselectionAction () {

        $created = Zend_Date::now();

        $request = $this->getRequest();

        $db = Zend_Db_Table::getDefaultAdapter();

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');


        if (!isset($sessionutilisateur->login)){

            $this->_redirect('/administration/login');

        }

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
                
        $validationerrors = array();

        $idselectioncandidature = (int)$this->_request->getParam('idselectioncandidature');

        $dbdetailcandidatureforselection = "SELECT * FROM eu_candidature WHERE eu_candidature.id_candidature = '$idselectioncandidature'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);


        $stmtdetailcandidatureforselection = $db->query($dbdetailcandidatureforselection);
     
        $detailcandidatureforselection  = $stmtdetailcandidatureforselection->fetchAll();


        $dbselectallcandidat = "SELECT eu_candidature_postes.id_roles, 
                                       
                                       eu_candidature_postes.id_candidature,

                                       eu_candidature_postes.id_candidature_postes,

                                       eu_candidature_membre.*,

                                       eu_roles.id_roles,

                                       eu_roles.libelle_roles,

                                       eu_membre.nom_membre,

                                       eu_support_intrant_ot.id_support_intrant_ot,
                                       
                                       eu_membre.prenom_membre
        
                                FROM eu_candidature_postes, 
                                
                                     eu_candidature_membre, 
                                     
                                     eu_candidature, 

                                     eu_roles,

                                     eu_support_intrant_ot,

                                     eu_membre
                                
                                WHERE eu_candidature_membre.code_membre = eu_membre.code_membre
                                
                                AND eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes

                                AND eu_candidature_membre.id_candidature_membre = eu_support_intrant_ot.id_candidature_membre
                                
                                AND eu_candidature_postes.id_roles = eu_roles.id_roles
                                
                                AND eu_candidature_postes.id_candidature = eu_candidature.id_candidature
                                
                                AND eu_candidature.id_candidature = '$idselectioncandidature'
                                
                                AND eu_candidature.id_utilisateur = '$id_utilisateur'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectallcandidat = $db->query($dbselectallcandidat);
     
        $candidatureaselectionner = $stmtselectallcandidat->fetchAll();

        $countcandidatureselectionner = count($candidatureaselectionner);

        
        $dbselectdetaildunpostedecandidature = "SELECT eu_roles.libelle_roles, 
        
                                                     eu_candidature_postes.id_roles, 
                                                     
                                                     eu_candidature_postes.id_candidature, 
                                                     
                                                     eu_candidature_postes.id_candidature_postes

                                              FROM eu_candidature_postes, eu_roles 
                                
                                              WHERE eu_candidature_postes.id_roles = eu_roles.id_roles
                                              
                                              AND eu_candidature_postes.id_candidature = '$idselectioncandidature'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtdetaildunpostedecandidature = $db->query($dbselectdetaildunpostedecandidature);
     
        $selectdetaildunpostedecandidature = $stmtdetaildunpostedecandidature->fetchAll();

        $this->view->idselectioncandidature = $idselectioncandidature;

        $this->view->selectdetaildunpostedecandidature = $selectdetaildunpostedecandidature;
    
        $this->view->countcandidatureselectionner = $countcandidatureselectionner;

        $this->view->candidatureaselectionner = $candidatureaselectionner;

        $this->view->detailcandidatureforselection = $detailcandidatureforselection;

        $this->view->tabletri = 1; 


        if ($request->isPost()) {

            $countcheck = 0;
            

            for ($i=0; $i<count($_POST["id_candidature_membre"]); $i++){

                $id_candidature_membre = htmlspecialchars($_POST["id_candidature_membre"][$i]);

                if ($id_candidature_membre != ""){
            
                    $id_candidature = htmlspecialchars($_POST['id_candidature'][$i]);

                    $id_candidature_postes = htmlspecialchars($_POST['id_candidature_post'][$i]);

                    $code_membre = htmlspecialchars($_POST['code_membre'][$i]);

                    $id_roles_candidature = htmlspecialchars($_POST['id_roles_candidature'][$i]);

                    $id_candidature_membre = htmlspecialchars($_POST['id_candidature_membre'][$i]);
                

                    $_POST["check_select_candidat_$code_membre"] = isset($_POST["check_select_candidat_$code_membre"]) ? $_POST["check_select_candidat_$code_membre"] : 0;


                     $dbverifycheckselectidcandidat = "SELECT eu_candidature_membre.id_candidature_membre
        
                                                       FROM eu_candidature_postes, 
                                
                                                             eu_candidature_membre, 
                                     
                                                             eu_candidature, 

                                                             eu_roles,

                                                             eu_membre
                                
                                                         WHERE eu_candidature_membre.code_membre = eu_membre.code_membre
                                
                                                         AND eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes
                                
                                                         AND eu_candidature_postes.id_roles = eu_roles.id_roles
                                
                                                         AND eu_candidature_postes.id_candidature = eu_candidature.id_candidature
                                
                                                         AND eu_candidature.id_candidature = '$idselectioncandidature'

                                                         AND eu_candidature_membre.code_membre = '$code_membre'

                                                         AND eu_candidature_membre.id_candidature_membre = $id_candidature_membre

                                                         AND eu_candidature_membre.id_candidature_postes = $id_candidature_postes

                                                         AND eu_candidature_postes.id_roles = $id_roles_candidature
                                
                                                         AND eu_candidature.id_utilisateur = '$id_utilisateur'";

                     $db->setFetchMode(Zend_Db::FETCH_OBJ);

                     $stmtverifycheckselectidcandidat = $db->query($dbverifycheckselectidcandidat);
     
                     $verifycheckselectidcandidat = $stmtverifycheckselectidcandidat->fetchAll();

                     if (count($verifycheckselectidcandidat) == 0){

                         $validationerrors['validate_entry_candidat'] = "Vous tentez d'effectuer une action qui n'est pas autorisé";

                     }
                    if ($_POST["check_select_candidat_$code_membre"] == 0){

                        $countcheck = $countcheck + 1;

                    }
                    

               }

            }

            if (count($_POST["id_candidature_membre"]) >= 2){

                if ($countcheck >= count($_POST["id_candidature_membre"])){

                     $validationerrors['errors'] = "Erreur de validation: Vous devez selectionner au moins un candidat dans la liste";

                }


            }


        if(!empty($validationerrors)){

            $_SESSION['validationerrors'] = $validationerrors;

        }

        
        if(empty($validationerrors)) {

            for ($i = 0; $i< count($_POST["id_candidature_membre"]); $i++){

                $id_candidature_membre = htmlspecialchars($_POST['id_candidature_membre'][$i]);

                $_POST["check_select_candidat_$code_membre"] = isset($_POST["check_select_candidat_$code_membre"]) ? $_POST["check_select_candidat_$code_membre"] : 0;

                if ($_POST["check_select_candidat_$code_membre"] == 0){

                    $dbfupdate = "UPDATE eu_candidature_membre 
                
                                  SET eu_candidature_membre.preselection = 0
                    
                                  WHERE eu_candidature_membre.id_candidature_membre = $id_candidature_membre";

                }elseif($_POST["check_select_candidat_$code_membre"] != 0){

                    $dbfupdate = "UPDATE eu_candidature_membre 
                
                                  SET eu_candidature_membre.preselection = 1 
                    
                                  WHERE eu_candidature_membre.id_candidature_membre = $id_candidature_membre";
                }

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                if ($db->query($dbfupdate)){

                    $validationpertesuccess['success_request'] = "La pré-selection des candidats a été correctement éffectué";

                    $_SESSION['validationpertesuccess'] = $validationpertesuccess;  

                }

            }

            $this->_redirect("/gestionoffredetravail/listdesappelacandidaturepourpreselection");                    
            
        }
      }

    }

    public function modificationdunappelacandidatureAction () {

        $created = Zend_Date::now();

        $db = Zend_Db_Table::getDefaultAdapter();


        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $validationerrors = array();

        $idmodificationcandidature = (int)$this->_request->getParam('idmodificationcandidature');

        $dbselectcandidatureamodifier = "SELECT * 
        
                                         FROM eu_candidature 
                                
                                         WHERE eu_candidature.id_candidature = '$idmodificationcandidature' 
                                
                                         AND eu_candidature.id_utilisateur = $id_utilisateur";

        
        $stmtcandidatureamodifier = $db->query($dbselectcandidatureamodifier);
     
        $candidaturesamodifier = $stmtcandidatureamodifier->fetchAll();


        $dbselectcandidatureposteamodifier = "SELECT eu_roles.libelle_roles, 
        
                                                     eu_candidature_postes.id_roles, 
                                                     
                                                     eu_candidature_postes.id_candidature, 
                                                     
                                                     eu_candidature_postes.nbre_personnes,

                                                     eu_candidature_postes.id_candidature_postes

                                              FROM eu_candidature_postes, eu_roles 
                                
                                              WHERE eu_candidature_postes.id_roles = eu_roles.id_roles
                                              
                                              AND eu_candidature_postes.id_candidature = '$idmodificationcandidature'";

        
        $stmtselectcandidatureposteamodifier = $db->query($dbselectcandidatureposteamodifier);
     
        $selectcandidatureposteamodifier = $stmtselectcandidatureposteamodifier->fetchAll();

        $this->view->selectcandidatureposteamodifier = $selectcandidatureposteamodifier;

        $this->view->candidaturesamodifier = $candidaturesamodifier;



        if ($request->isPost()){

        

            $competences = trim(addslashes(htmlspecialchars($_POST['diplome_competence_modification'])));

            $nbre_annee_experience = trim(addslashes(htmlspecialchars($_POST['nbre_annee_experience_modification'])));

            if($competences == ""){

                $validationerrors['empty_id_travailleur'] = "Vous devez renseigner les informations concernant les diplomes et compétences";

            }

            if(!array_key_exists('diplome_competence_modification', $_POST) ){

                $validationerrors['error_diplome_competence'] = "Erreur 404:Vous éssayez d'effectuer une action qui n'est pas autorisé";

            }

            if ($nbre_annee_experience == ""){
                
                $validationerrors['empty_id_travailleur'] = "Vous devez renseigner les informations concernant le nombre d'année d'expérience";

            }

            
            if(!array_key_exists('nbre_annee_experience_modification', $_POST) ){

                $validationerrors['error_nbre_annee_experience'] = "Erreur 404:Vous éssayez d'effectuer une action qui n'est pas autorisé";

            }


            if (count($_POST['id_poste_candidature_modification']) == 0){

                $validationerrors['error_poste_candidature_modification'] = "Vous devez ajouter au moins une poste à l'appel à candidature";

            }

            if (count($_POST['label_nbre_personne_candidature_modification']) == 0){

                $validationerrors['error_nbre_personne_candidature_modification'] = "Vous devez ajouter au moins le nombre de personnes au poste";

            }

            for ($i = 0; $i< count($_POST['id_poste_candidature_modification']); $i++) {

                for($j = 0; $j< count($_POST['label_nbre_personne_candidature_modification']); $j++){

                   $id_poste_candidature = htmlspecialchars($_POST['id_poste_candidature_modification'][$i]);

                   $label_nbre_personne_candidature = htmlspecialchars($_POST['label_nbre_personne_candidature_modification'][$j]);

                   if ($id_poste_candidature == "") {

                    $validationerrors['empty_libelle_poste_candidature'] = "Vous devez renseigner le libellé du poste";
 
                   }

                   if ($label_nbre_personne_candidature == "") {

                         $validationerrors['empty_label_nbre_personne_candidature'] = "Vous devez renseigner le nombre de personne souhaité pour ce poste";
 
                    }

                }           

            }

        if(!empty($validationerrors)){

            $_SESSION['validationerrors'] = $validationerrors;

         }

         if(empty($validationerrors)){

             $ref_candidature_poste = substr(md5(uniqid(rand(), true)), 0, 8);

             $real_ref_candidature_poste = strtoupper('CANDIDATURE-'.$ref_candidature_poste);

             $dbfupdate = "UPDATE eu_travailleur SET publier = 2 WHERE travailleur_id = $id_travailleur";


             $dbcandidatureinsert = "UPDATE eu_candidature 
             
                                     SET eu_candidature.competences = '$competences', 
                                     
                                         eu_candidature.annee_experience = '$nbre_annee_experience' 
                                         
                                     WHERE eu_candidature.id_candidature = $idmodificationcandidature";
                                     
             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             if ($db->query($dbcandidatureinsert)){

                 $searchidcandidaturebykey = "SELECT eu_candidature.id_candidature FROM eu_candidature WHERE eu_candidature.candidature_key = '$real_ref_candidature_poste'";

                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                 $stmtsearchidcandidaturebykey = $db->query($searchidcandidaturebykey);
     
                 $id_candidature_post_modification = $stmtsearchidcandidaturebykey->fetchAll();

                 $real_idcandidaturepost_modification = $id_candidature_post_modification[0]->id_candidature;


                 for ($i = 0; $i< count($_POST['id_poste_candidature_modification']); $i++) {

    
                         $id_poste_candidature_modification = $_POST['id_poste_candidature_modification'][$i];
    
                         $label_nbre_personne_candidature = $_POST['label_nbre_personne_candidature_modification'][$i];

                         $id_candidature_modification_poste = $_POST['id_candidature_modification_poste'][$i];

                         $dbcandidature_modification = "UPDATE eu_candidature_postes 
                         
                                                        SET eu_candidature_postes.id_roles = $id_poste_candidature_modification, 
                                                        
                                                            eu_candidature_postes.id_candidature = $idmodificationcandidature, 
                                                        
                                                            eu_candidature_postes.nbre_personnes = $label_nbre_personne_candidature
                                                            
                                                       WHERE eu_candidature_postes.id_candidature_postes = $id_candidature_modification_poste";

                         $db->setFetchMode(Zend_Db::FETCH_OBJ);

                         $db->query($dbcandidature_modification);
                }

                $this->_redirect("/gestionoffredetravail/listdesappelacandidaturepourpreselection");

             }

         }

      }


    }

    public function annexebonasavoirAction () {

    }

    public function annexetdrAction () {

    }


    public function annexegrilleAction () {

        $sessionmembre = new Zend_Session_Namespace('membre');

        $db = Zend_Db_Table::getDefaultAdapter();

        $code_membre_ot = $sessionmembre->code_membre;

        $nom_membre_ot = $sessionmembre->nom_membre;

        $prenoms_membre_ot = $sessionmembre->prenom_membre;

        $nationality_ot = "";

        if ($sessionmembre->id_pays != NULL){

            $idpaysot = $sessionmembre->id_pays;
 
            $dbselectnationality = "SELECT eu_pays.nationalite
            
                                    FROM eu_membre, eu_pays
                                    
                                    WHERE eu_membre.id_pays = eu_pays.id_pays
                                    
                                    AND eu_membre.id_pays = $idpaysot";

            
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtselectnationality = $db->query($dbselectnationality);
     
            $selectnationality = $stmtselectnationality->fetchAll();

            $nationality_ot = $selectnationality[0]->nationalite;

        }else {

            $nationality_ot = "TOGOLAIS";            
        }

        $this->view->code_membre_ot = $code_membre_ot;
        
        $this->view->nom_membre_ot = $nom_membre_ot;

        $this->view->prenoms_membre_ot = $prenoms_membre_ot;

        $this->view->nationality_ot = $nationality_ot;

    }

    public function annexemodalitepayementAction () {

    }
    
    public function detailprofilcandidatotAction () {

    }

    public function listedesappelsacandidatureapostulerAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        //La liste de tous les candidatures

        $dbselectdate = "SELECT * 
        
                         FROM eu_candidature"; 

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectdate = $db->query($dbselectdate);
     
        $selectcandidature = $stmtselectdate->fetchAll();

        $countselectcandidature = count($selectcandidature);

        $this->view->selectallcandidature = $selectcandidature;

        $this->view->countselectcandidature = $countselectcandidature;

        //Le nombre de poste demandé par candidature

    }

    

    public function postulerappelacandidatureAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        $sessionmembre = new Zend_Session_Namespace('membre');

        $nom_membre = $sessionmembre->nom_membre;

        $code_membre = $sessionmembre->code_membre;

        $prenoms_membre = $sessionmembre->prenom_membre;

        $nometprenoms = $nom_membre." ".$prenoms_membre;

        $iddetailcandidaturepost = (int)$this->_request->getParam('idpostcandidature');

        $ref_candidature_ot = substr(md5(uniqid(rand(), true)), 0, 8);

        $motmagic = "CANDIDATURE DE L'ESMC OFFREUR DE TRAVAIL OT POUR LE MEMBRE $nometprenoms & $ref_candidature_ot";

        $md5motmagic = md5($motmagic);

        $strongtokenkey = password_hash($md5motmagic, PASSWORD_BCRYPT);


        // LISTE DE TOUS LES APPELS A CANDIDATURE QUI N'ONT PAS ENCORE ETE CLOTUREE

        $dbselectdate = "SELECT * FROM eu_candidature WHERE eu_candidature.id_candidature = '$iddetailcandidaturepost'"; 

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectdate = $db->query($dbselectdate);
     
        $selectcandidature = $stmtselectdate->fetchAll();


        $detaildunecandidaturepourpostuler = "SELECT eu_roles.libelle_roles, 
        
                                                     eu_candidature_postes.id_roles, 
                                                     
                                                     eu_candidature_postes.id_candidature, 
                                                     
                                                     eu_candidature_postes.nbre_personnes,

                                                     eu_candidature_postes.id_candidature_postes

                                              FROM eu_candidature_postes

                                              LEFT JOIN eu_roles ON  eu_candidature_postes.id_roles = eu_roles.id_roles

                                              LEFT JOIN eu_candidature_membre ON eu_candidature_postes.id_candidature_postes = eu_candidature_membre.id_candidature_postes 
                                
                                              WHERE eu_candidature_postes.id_candidature = $iddetailcandidaturepost
                                              
                                              AND eu_candidature_membre.id_candidature_postes IS NULL";
        
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtdetaildunecandidaturepourpostuler = $db->query($detaildunecandidaturepourpostuler);
     
        $fetchdetaildunecandidaturepourpostuler = $stmtdetaildunecandidaturepourpostuler->fetchAll();


        $selectalreadycandidaturepost = "SELECT eu_roles.libelle_roles, 
        
                                                     eu_candidature_postes.id_roles, 
                                                     
                                                     eu_candidature_postes.id_candidature, 
                                                     
                                                     eu_candidature_postes.nbre_personnes,

                                                     eu_candidature_postes.id_candidature_postes

                                         FROM eu_candidature_postes

                                         LEFT JOIN eu_roles ON  eu_candidature_postes.id_roles = eu_roles.id_roles

                                         RIGHT JOIN eu_candidature_membre ON eu_candidature_postes.id_candidature_postes = eu_candidature_membre.id_candidature_postes 
                                
                                         WHERE eu_candidature_postes.id_candidature = $iddetailcandidaturepost
                                              
                                         AND eu_candidature_membre.id_candidature_postes IS NOT NULL
                                              
                                         AND eu_candidature_membre.code_membre = '$code_membre'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtselectalreadycandidaturepost = $db->query($selectalreadycandidaturepost);
     
        $fetchalreadycandidatureposts = $stmtselectalreadycandidaturepost->fetchAll();

        $countalreadycandidatureposts = count($fetchalreadycandidatureposts);


        $this->view->selectallcandidature = $selectcandidature;

        $this->view->detaildunecandidaturepourpostuler = $fetchdetaildunecandidaturepourpostuler;

        $this->view->tokencsrf = $strongtokenkey;

        $this->view->idcandidature = $iddetailcandidaturepost;

        $this->view->alreadypostcandidature = $fetchalreadycandidatureposts;
        
        $this->view->countalreadycandidatureposts = $countalreadycandidatureposts;

    }

    public function listedesappelacandidaturedejaselectionnerAction () {


    }

    public function listedesappelacandidatureaselectionnerAction () {


    }

    public function interfacedenvoidecvactualiseAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        // RECUPERER LA LISTE DES TYPES DE FORMATION BAC

        $dbseletallformationsbac = "SELECT * FROM eu_type_formations_bac";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtallformationbac = $db->query($dbseletallformationsbac);

        $allformationbac = $stmtallformationbac->fetchAll();

        $this->view->allformationbac = $allformationbac;

        // RECUPERER LA LISTE DE TOUTES LES FORMATIONS UNIVERSITAIRES

    }

    public function ajaxuncandidatpostsacandidatureAction () {

        /***
         * RECUPERER LE CODE MEMBRE DU CANIDAT
         * RECUPERER L'IDENTIFIANT DE LA CANDIDATURE
         * RECUPERER L'IDENTIFIANT DU POST POSTULE
         * GENERER UN TOKEN CSRF POUR TOUTES LES FORMULAIRES
         */

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->_helper->layout->disableLayout();

            $db = Zend_Db_Table::getDefaultAdapter();
    
            $sessionmembre = new Zend_Session_Namespace('membre');
            
            $created = Zend_Date::now();

            $resultjson = array();
    
            $code_membre = $sessionmembre->code_membre;

            $date_postulat = $created->toString('yyyy-MM-dd HH:mm:ss');

            if ($code_membre == ""){

                http_response_code(403);

                die('Erreur 648:Cette action est soumis aux règles de l\'authentification');

            }

            if ($code_membre != "") {

                 $id_post_candidature = htmlspecialchars($_POST['id_candidat_candidature_post']);

                 $id_candidature = htmlspecialchars($_POST['id_candidature']);

                 $nbre_personne = htmlspecialchars($_POST['nbre_personne']);

                 $id_candidature_poste = htmlspecialchars($_POST['candidature_poste']);

                 $dbverificationidcandidature = "SELECT * FROM eu_candidature WHERE eu_candidature.id_candidature = '$id_candidature'";

                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                 $stmtverificationcandidature = $db->query($dbverificationidcandidature);

                 $verificationcandidature = $stmtverificationcandidature->fetchAll();

                 $countverificationcandidature = count($verificationcandidature);


                 if ($countverificationcandidature == 0){

                    http_response_code(403);

                    die('Erreur 698:Vous tentez d\'effectuer une action qui n\'est pas autorisé');

                 }                

                 if ($countverificationcandidature != 0) {

                     $dbverificationidpostcandidature = "SELECT eu_candidature_postes.id_candidature_postes, eu_roles.libelle_roles
                     
                                                         FROM eu_candidature_postes, eu_roles 
                                                     
                                                         WHERE eu_candidature_postes.id_roles = eu_roles.id_roles
                                                         
                                                         AND eu_candidature_postes.id_candidature = '$id_candidature'
                                                     
                                                         AND eu_candidature_postes.id_roles = '$id_post_candidature'
                                                     
                                                         AND eu_candidature_postes.nbre_personnes = '$nbre_personne'";

                     $db->setFetchMode(Zend_Db::FETCH_OBJ);
   
                     $stmtverificationidpostcandidature = $db->query($dbverificationidpostcandidature);
   
                     $verificationidpostcandidature = $stmtverificationidpostcandidature->fetchAll();

                     $countverficationidpostcandidature = count($verificationidpostcandidature);


                     if ($countverficationidpostcandidature == 0){

                          http_response_code(403);
                          
                          die('Erreur 728:Vous tentez d\'effectuer une action qui n\'est pas autorisé');

                     }

                     if ($countverficationidpostcandidature != 0) {


                        $id_candidature_poste = $verificationidpostcandidature[0]->id_candidature_postes;

                        if ($id_candidature_poste != $id_candidature_poste){
                            
                             http_response_code(403);
                          
                             die('Erreur 740:Vous tentez d\'effectuer une action qui n\'est pas autorisé');
                        }

                        if ($id_candidature_poste == $id_candidature_poste){

                             $libelle_post = $verificationidpostcandidature[0]->libelle_roles;

                             $dbcandidaturemembreinsert = "INSERT INTO eu_candidature_membre (code_membre, id_candidature_postes, date_postulat) 
             
                                                           VALUES ('$code_membre', $id_candidature_poste, '$date_postulat')";

                             $db->setFetchMode(Zend_Db::FETCH_OBJ);

                            if ($db->query($dbcandidaturemembreinsert)) {
           
                                 $resultjson = array(

                                     'result'=>"Votre candidature pour le poste $libelle_post a été envoyé avec succès"
                                 );

                            }
                        }

                     }

                 }

            }

        }

        
        header('Content-type:application/json');

        die(json_encode($resultjson));

    }

    public function signatureducontratdeprestationAction () {

 		$this->_helper->layout()->setLayout('layoutpublic');

        $ref_candidature_ot = substr(md5(uniqid(rand(), true)), 0, 8);

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $created = Zend_Date::now();

        /**layoutpublicesmcadmin */


    	$sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membre_ot = $sessionmembre->code_membre;

        $nom_membre_ot = $sessionmembre->nom_membre;

        $email_membre_ot = $sessionmembre->email_membre;

        $adresse_membre_ot = $sessionmembre->adresse_membre;

        $telephone_membre_ot = $sessionmembre->portable_membre;

        $prenoms_membre_ot = $sessionmembre->prenom_membre;

        $nometprenoms_ot = $nom_membre_ot." ".$prenoms_membre_ot;

        $date_naissanceot = $sessionmembre->date_nais_membre;

        
        $date_signature = $created->toString('yyyy-MM-dd HH:mm:ss');

        $validationsuccess = array();

        $validationerrors = array();

        $dbselectallunsignedcontrat = "SELECT * 
        
                                       FROM eu_candidature_membre, eu_candidature_postes, eu_roles
                     
                                       WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes

                                       AND eu_candidature_postes.id_roles = eu_roles.id_roles
                     
                                       AND eu_candidature_membre.code_membre = '$code_membre_ot'

                                       AND eu_candidature_membre.code_transfert_technologie IS NOT NULL

                                       AND eu_candidature_membre.code_acces_salle IS NOT NULL

                                       AND eu_candidature_membre.code_pouvoirfaire IS NOT NULL

                                       AND eu_candidature_membre.type_transfert_technologie IS NOT NULL
                     
                                       AND eu_candidature_membre.preselection = 1
                                       
                                       AND eu_candidature_membre.createcount = 0
                                       
                                       AND eu_candidature_membre.vu_codeacces = 1
                                       
                                       AND eu_candidature_membre.vu_codetransferttechnologie = 1
                                       
                                       AND eu_candidature_membre.vu_pouvoirfaire = 1
                                       
                                       AND eu_candidature_membre.signature_contrat = 0";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectallunsignedcontrat = $db->query($dbselectallunsignedcontrat);

        $selectallunsignedcontrat = $stmtselectallunsignedcontrat->fetchAll();

        $countselectallunsignedcontrat = count($selectallunsignedcontrat);

        $this->view->countselectallunsignedcontrat = $countselectallunsignedcontrat;


        if ($countselectallunsignedcontrat != 0){

            $id_parent = $selectallunsignedcontrat[0]->parent_roles_id;

            $id_candidature = $selectallunsignedcontrat[0]->id_candidature;

            $id_candidature_membre = $selectallunsignedcontrat[0]->id_candidature_membre;

            $id_candidature_post = $selectallunsignedcontrat[0]->id_candidature_postes;

            $dbgetlibellerolesbyparentid = "SELECT eu_roles.libelle_roles, eu_roles.id_roles, eu_roles.parent_roles_id

                                           FROM eu_roles
                                           
                                           WHERE eu_roles.id_roles = $id_parent";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtgetlibellerolesbyparentid = $db->query($dbgetlibellerolesbyparentid);

            $getlibellerolesbyparentid = $stmtgetlibellerolesbyparentid->fetchAll();

            $libellerolesbyparentid = $getlibellerolesbyparentid[0]->libelle_roles;         
            
            $id_roles = $getlibellerolesbyparentid[0]->id_roles;

            $parent_roles_id = $getlibellerolesbyparentid[0]->parent_roles_id;

            $motmagic = "SIGNATURE DU CONTRAT DE CANDIDATURE DE L'ESMC OFFREUR DE TRAVAIL OT POUR LE MEMBRE $nometprenoms_ot AYANT POUR CODE MEMBRE '$code_membre_ot' & $ref_candidature_ot";
    
            $md5motmagic = md5($motmagic);
    
            $strongtokenkey = password_hash($md5motmagic, PASSWORD_BCRYPT);

            $nationality_ot = "";

            $nom_poste_ot = $selectallunsignedcontrat[0]->libelle_roles;

            if ($sessionmembre->id_pays != NULL){

                $idpaysot = $sessionmembre->id_pays;
 
                $dbselectnationality = "SELECT eu_pays.nationalite
            
                                        FROM eu_membre, eu_pays
                                    
                                        WHERE eu_membre.id_pays = eu_pays.id_pays
                                    
                                        AND eu_membre.id_pays = $idpaysot";
            
                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtselectnationality = $db->query($dbselectnationality);
     
                $selectnationality = $stmtselectnationality->fetchAll();

                $nationality_ot = $selectnationality[0]->nationalite;

            }else {

                $nationality_ot = "TOGOLAIS";            
            }
        
            $this->view->nom_membre_ot = $nom_membre_ot;

            $this->view->prenoms_membre_ot = $prenoms_membre_ot;

            $this->view->nationality_ot = $nationality_ot;

            $this->view->tokenstrongkey = $strongtokenkey;

            $this->view->selectionsignedcontrat = $selectallunsignedcontrat;

            $this->view->nometprenoms = $nometprenoms_ot;

            $this->view->datedenaissance = $date_naissanceot;

            $this->view->datesignature = $date_signature;

            $this->view->adresse_membre = $adresse_membre_ot;

            $this->view->telephone_membre = $telephone_membre_ot;

            $this->view->email_membre = $email_membre_ot;

            $this->view->id_candidature = $id_candidature;

            $this->view->id_candidature_postes = $id_candidature_post;

            $this->view->id_candidature_membre = $id_candidature_membre;

            $this->view->id_roles = $id_roles;

            $this->view->id_roles_parent = $parent_roles_id;

            $this->view->libelle_postes = $nom_poste_ot;

            $this->view->libelleparentpostes = $libellerolesbyparentid;


            if ($request->isPost()) {

                $id_candidature_postes = $_POST['id_candidature_postes'];

                $id_candidature_membre = $_POST['id_candidature_membre'];

                $id_candy_contract_ot = $_POST['id_candy_contract_ot'];

                $code_pouvoirfaire = $_POST['ot_code_pouvoir-faire'];


            /*    if ($id_candy_contract_ot != $strongtokenkey) {

                    http_response_code(403);

                    die('Erreur 1187:Vous tentez d\'effectuer une action qui n\'est pas autorisé');
                    
                }*/

                if (!isset($id_candidature_postes)){

                    $validationerrors['empty_candidature_poste'] = "Erreur 1185:Vous tentez d'éffectuer une action qui n'est pas autorisé";

                }

                if (!isset($code_pouvoirfaire)){

                    $validationerrors['empty_codepouvoirfaire'] = "Erreur 3604:Code Pouvoir faire:vous tentez d'éffectuer une action qui n'est pas autorisée";

                }

                if ($code_pouvoirfaire == ""){

                    $validationerrors['empty_codepouvoirfaire'] = "Vous devez renseigner le code de pouvoir-faire";

                }

                if ($code_pouvoirfaire != "")
                {

                    $dbselect = "SELECT * 
                    
                                 FROM eu_candidature_membre
                                 
                                 WHERE eu_candidature_membre.id_candidature_membre = $id_candidature_membre
                                 
                                 AND eu_candidature_membre.id_candidature_postes = $id_candidature_postes
                                 
                                 AND eu_candidature_membre.code_pouvoirfaire = '$code_pouvoirfaire'";
                }

                
               if(!empty($validationerrors)){

                  $_SESSION['validationerrors'] = $validationerrors;

               }

               if(empty($validationerrors)){

                  $dbupdatesignature = "UPDATE eu_candidature_membre 
                  
                                        SET eu_candidature_membre.preselection = 2,

                                            eu_candidature_membre.signature_contrat = 1 
                                        
                                        WHERE eu_candidature_membre.id_candidature_membre = $id_candidature_membre";
                  
                  $db->setFetchMode(Zend_Db::FETCH_OBJ);

                  if ($db->query($dbupdatesignature)){

                        $dbhistoriqueinsert = "INSERT INTO eu_historiques_operations (nom_table, 
                    
                                                                                         id_table, 
                                                                                                                                                                                  
                                                                                         libelle_operation, 
                                                                                         
                                                                                         type_module, 
                                                                                         
                                                                                         date_operation) 
             
                                                  VALUES ('eu_candidature_membre', $id_candidature_membre, 'signature de contrat d\'appel à candidature', 'OT','$date_signature')";

                        $db->setFetchMode(Zend_Db::FETCH_OBJ);

                        if ($db->query($dbhistoriqueinsert)) {                       

                             $this->_redirect("espacepersonnel"); 
                         
                         }
                  }             
                            
              }

          }

       }

    }

    public function listedescandidatsayantsignelecontratAction () {

        /**
         * CETTE ACTION EST VU PAR L
         */

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        $dbselectcandidatsignedcontrat = "SELECT eu_membre.nom_membre, 
        
                                                 eu_candidature_membre.*, 
                                                     
                                                 eu_membre.prenom_membre, 
                                                     
                                                 eu_roles.libelle_roles, 
                                                     
                                                 eu_candidature_postes.id_roles,

                                                 eu_roles.parent_roles_id,

                                                 eu_candidature_postes.id_candidature_postes,

                                                 eu_candidature_postes.id_candidature                                                     
        
                                          FROM eu_candidature_membre, eu_membre, eu_roles, eu_candidature_postes, eu_candidature 
                                          
                                          WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes

                                          AND eu_candidature_postes.id_roles = eu_roles.id_roles

                                          AND eu_candidature_postes.id_candidature = eu_candidature.id_candidature
                                              
                                          AND eu_candidature_membre.code_membre = eu_membre.code_membre 
                                          
                                          AND eu_candidature_membre.preselection = 2";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtcandidatsignedcontrat = $db->query($dbselectcandidatsignedcontrat);

        $candidatsignedcontrat = $stmtcandidatsignedcontrat->fetchAll();

        $this->view->touslescandidatsayantsigneuncontrat = $candidatsignedcontrat;

        $counttouslescandidatsayantsigneuncontrat = count($candidatsignedcontrat);

        $this->view->counttouslescandidatsayantsigneuncontrat = $counttouslescandidatsayantsigneuncontrat;

    }

    public function listedescandidatsayantsigneruncontratmaisnayantpasdecompteAction () {
     
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $request = $this->getRequest();

        $dbselectcandidatnayantpasdecompte = "SELECT eu_membre.nom_membre, 
        
                                                     eu_candidature_membre.*, 
                                                     
                                                     eu_membre.prenom_membre, 
                                                     
                                                     eu_roles.libelle_roles, 
                                                     
                                                     eu_candidature_postes.id_roles,

                                                     eu_roles.parent_roles_id,

                                                     eu_candidature_postes.id_candidature_postes,

                                                     eu_candidature_postes.id_candidature                                                     
        
                                              FROM eu_candidature_membre, eu_membre, eu_roles, eu_candidature_postes, eu_candidature 
                                          
                                              WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes

                                              AND eu_candidature_postes.id_roles = eu_roles.id_roles

                                              AND eu_candidature_postes.id_candidature = eu_candidature.id_candidature
                                              
                                              AND eu_candidature_membre.code_membre = eu_membre.code_membre
                                              
                                              AND eu_candidature_membre.preselection = 2
                                              
                                              AND eu_candidature_membre.createcount = 0";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtcandidatnayantpasdecompte = $db->query($dbselectcandidatnayantpasdecompte);

        $candidatnayantpasdecompte = $stmtcandidatnayantpasdecompte->fetchAll();

        $countcandidatnayantpasdecompte = count($candidatnayantpasdecompte);

        $this->view->candidatnayantpasdecompte = $candidatnayantpasdecompte;

        $this->view->countcandidatnayantpasdecompte = $countcandidatnayantpasdecompte;

    }

    public function listedescandidatsayantsigneruncontratetquiontuncompteAction () {
     
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        $dbselectcandidatayantuncompte = "SELECT eu_membre.nom_membre, 
        
                                                 eu_candidature_membre.*, 
                                                     
                                                 eu_membre.prenom_membre, 
                                                     
                                                 eu_roles.libelle_roles, 
                                                     
                                                 eu_candidature_postes.id_roles,

                                                 eu_roles.parent_roles_id,

                                                 eu_candidature_postes.id_candidature_postes,

                                                 eu_candidature_postes.id_candidature                                                     
        
                                          FROM eu_candidature_membre, eu_membre, eu_roles, eu_candidature_postes, eu_candidature 
                                          
                                          WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes

                                          AND eu_candidature_postes.id_roles = eu_roles.id_roles

                                          AND eu_candidature_postes.id_candidature = eu_candidature.id_candidature
                                              
                                          AND eu_candidature_membre.code_membre = eu_membre.code_membre
                                          
                                          AND eu_candidature_membre.preselection = 3
                                          
                                          AND eu_candidature_membre.createcount = 1";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtcandidatayantuncompte = $db->query($dbselectcandidatayantuncompte);

        $candidatayantuncompte = $stmtcandidatayantuncompte->fetchAll();

        $this->view->candidatayantuncompte = $candidatayantuncompte;
    }

    public function ajaxcreationdecompteutilisateurotAction ()
    {

        $this->_helper->layout->disableLayout();

        $db = Zend_Db_Table::getDefaultAdapter();

        $resultjson = array();

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $idCandidature = $_POST['id_candidature'];

            $idCandidaturePost = $_POST['id_candidaturepost'];

            $idCandidatureMembre = $_POST['id_candidature_membre'];

            $idRoles = $_POST['id_roles'];

            $iddelutilisateurquicreelagentot = $_SESSION['utilisateur']['id_utilisateur'];


            $dbverifierlerespectdelaprocedureagrot = "SELECT eu_candidature_membre.id_candidature_membre, 
            
                                                             eu_candidature_membre.code_membre,

                                                             eu_candidature_membre.code_pouvoirfaire
        
                                                      FROM eu_candidature_membre, eu_candidature_postes
                             
                                                      WHERE eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes
                                                          
                                                      AND eu_candidature_membre.id_candidature_membre = $idCandidatureMembre
                             
                                                      AND eu_candidature_membre.id_candidature_postes = $idCandidaturePost
                             
                                                      AND eu_candidature_postes.id_candidature = $idCandidature
                                                      
                                                      AND eu_candidature_membre.creatcount = 0
                                                      
                                                      AND eu_candidature_membre.code_transfert_technologie IS NOT NULL
                                                      
                                                      AND eu_candidature_membre.code_acces_salle IS NOT NULL
                                                      
                                                      AND eu_candidature_membre.code_pouvoirfaire IS NOT NULL
                                                      
                                                      AND eu_candidature_membre.id_utilisateur_create_count IS NULL
                                                      
                                                      AND eu_candidature_membre.vu_codeacces = 1
                                                      
                                                      AND eu_candidature_membre.vu_codetransferttechnologie = 1
                                                      
                                                      AND eu_candidature_membre.vu_pouvoirfaire = 1
                                                      
                                                      AND eu_candidature_membre.signature_contrat = 1";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtverifierlerespectdelaprocedureagrot = $db->query($dbverifierlerespectdelaprocedureagrot);

            $verifierlerespectdelaprocedureagrot = $stmtverifierlerespectdelaprocedureagrot->fetchAll();

            $countverifierlerespectdelaprocedureagrot = count($verifierlerespectdelaprocedureagrot);

            if ($countverifierlerespectdelaprocedureagrot == 0 ){

                $resultjson = array(

                    'result'=>'Error 404: Vous tentez d\'effectuer une action qui n\'est pas autorisé'
               );
            }

            if ($countverifierlerespectdelaprocedureagrot != 0)
            {

                $code_membre = $verifierlerespectdelaprocedureagrot[0]->code_membre;

                $login_ot = $code_membre;

                $password_ot = MD5($verifierlerespectdelaprocedureagrot[0]->code_pouvoirfaire);

                $password_ot_hash = password_hash($password_ot, PASSWORD_BCRYPT);

                $id_centres = $_SESSION['utilisateur']['id_centre'];

                $id_agences_odd = $_SESSION['utilisateur']['id_agences_odd'];
    
                $id_centrales = $_SESSION['utilisateur']['id_centrales'];

                $dbverifiersilenouveaucomptenapasetedejacreer = "SELECT * 
        
                                                                 FROM eu_user_roles_permissions, eu_utilisateur
                                
                                                                 WHERE eu_user_roles_permissions.id_utilisateur = eu_utilisateur.id_utilisateur

                                                                 AND eu_utilisateur.code_membre = '$code_membre'

                                                                 AND eu_utilisateur.id_utilisateur_parent = $iddelutilisateurquicreelagentot
                                
                                                                 AND eu_user_roles_permissions.id_roles = $paramsrolesot";

        
                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifiersilenouveaucomptenapasetedejacreer = $db->query($dbverifiersilenouveaucomptenapasetedejacreer);

                $verifiersilenouveaucomptenapasetedejacreer = $stmtverifiersilenouveaucomptenapasetedejacreer->fetchAll();

                $countverifiersilenouveaucomptenapasetedejacreer = count($verifiersilenouveaucomptenapasetedejacreer);

                if ($countverifiersilenouveaucomptenapasetedejacreer != 0){

                    $resultjson = array(

                        'result'=>'Ce compte a été déja créer'
                   );
                }

                if ($countverifiersilenouveaucomptenapasetedejacreer == 0)
                {

                    $ref_user_ot = substr(md5(uniqid(rand(), true)), 0, 8);

                    $real_ref_user_ot  = strtoupper('OT-'.$ref_user_ot );

                    $createnewcomptebyroles = "INSERT INTO eu_utilisateur (eu_utilisateur.login, 
                    
                                                                           eu_utilisateur.pwd, 

                                                                           eu_utilisateur.code_membre,
                                                                           
                                                                           eu_utilisateur.id_utilisateur_parent,
                                                                           
                                                                           eu_utilisateur.password_hash, 
                                                                           
                                                                           eu_utilisateur.reference_user_role)
                                                VALUES ('$login_ot',
                                                
                                                        '$password_ot',

                                                        '$affectation_code_membreot',
                                                        
                                                        '$id_utilisateurot',
                                                        
                                                        '$password_ot_hash',
                                                        
                                                        '$real_ref_user_ot')";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    if ($db->query($createnewcomptebyroles)){

                        $dbselectlastcompteot = "SELECT eu_utilisateur.id_utilisateur 
                        
                                                 FROM eu_utilisateur 
                                                 
                                                 WHERE eu_utilisateur.reference_user_role = '$real_ref_user_ot'";

                        $db->setFetchMode(Zend_Db::FETCH_OBJ);

                        $stmtselectlastcompteot = $db->query($dbselectlastcompteot);
                
                        $selectlastcompteot = $stmtselectlastcompteot->fetchAll();

                        $countselectlastcompteot = count($selectlastcompteot);

                        if ($countselectlastcompteot != 0) {

                            $idutilisateurlastot = $selectlastcompteot[0]->id_utilisateur;


                            $createnewcomptebyroles = "INSERT INTO eu_user_roles_permissions (eu_user_roles_permissions.id_utilisateur, 
                    
                                                                    eu_user_roles_permissions.id_roles,
                                                                                      
                                                                    eu_user_roles_permissions.date_affectation_roles) 
                                                                                      
                                                       VALUES ('$idutilisateurlastot',
                                                       
                                                               '$paramsrolesot',
                                                               
                                                               '$datecreatecompteot') ";

                            $db->setFetchMode(Zend_Db::FETCH_OBJ);

                            if ($db->query($createnewcomptebyroles)){

                                $dbupdatecandidat = "UPDATE eu_candidature_membre 
                                
                                                     SET eu_candidature_membre.preselection = 3, 
                                                     
                                                         eu_candidature_membre.createcount = 1 
                                                         
                                                     WHERE eu_candidature_membre.id_candidature_membre = $paramscandidatot";

                                $db->setFetchMode(Zend_Db::FETCH_OBJ);
            
                                if ($db->query($dbupdatecandidat)){

                                    $resultjson = array(

                                        'result'=>'Le nouveau compte à été créer avec succès'
                                   );

                                }
                            }
                        
                        }

                    }

                }


            }
        }

        
        header('Content-type:application/json');
        
        die(json_encode($resultjson));
    }

    public function interfacedecreationdecompteutilisateurotAction () {

        /**
         * Je veux avoir la liste des achats de postes par sous-rubrique pour création de compte utilisateur
         * Je récupère l'id du role de l'utilisateur courant
         * Je récupère la liste de tous les roles des agents de sa sous rubrique qui sont en attente de création d'un compte utilisateur
         * Je récupère la liste des demandes de création de comptes utilisateurs dont l'id roles se trouve dans la liste
         * 
         */

        $db = Zend_Db_Table::getDefaultAdapter();

		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');

        $tab_user = array();


        $id_utilisateurot = $sessionutilisateur->id_utilisateur;

        $idduroledelutilisateurcourant = $sessionutilisateur->id_current_user;
        
        $createdot = Zend_Date::now();

        $request = $this->getRequest();

        $dblistedesenfantsdunparent = "SELECT eu_roles.id_roles

                                       FROM eu_roles, eu_roles_parents_distant
        
                                       WHERE eu_roles.id_roles = eu_roles_parents_distant.id_roles
        
                                       AND eu_roles_parents_distant.parents_roles = $idduroledelutilisateurcourant";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtlistedesenfantsdunparent = $db->query($dblistedesenfantsdunparent);

        $listedesenfantsdunparent = $stmtlistedesenfantsdunparent->fetchAll();


        foreach ($listedesenfantsdunparent as $key => $value) {

            $id_roles = $value->id_roles;

            $dbverifierlerespectdelaprocedureagrot = "SELECT eu_candidature_membre.id_candidature_membre, 
            
                                                         eu_candidature_membre.code_membre,

                                                         eu_candidature_membre.id_candidature_postes,

                                                         eu_candidature_postes.id_candidature,

                                                         eu_roles.libelle_roles,

                                                         eu_roles.id_roles,

                                                         eu_support_intrant_ot.id_support_intrant_ot
        
                                                      FROM eu_candidature_membre, eu_support_intrant_ot, eu_candidature_postes, eu_roles
                             
                                                      WHERE eu_candidature_membre.id_candidature_membre = eu_support_intrant_ot.id_candidature_membre
                                                      
                                                      AND eu_candidature_membre.id_candidature_postes = eu_candidature_postes.id_candidature_postes
                                                          
                                                      AND eu_candidature_postes.id_roles = eu_roles.id_roles

                                                      AND eu_candidature_postes.id_roles = $id_roles
                                                  
                                                      AND eu_candidature_membre.createcount = 0
                                                      
                                                      AND eu_candidature_membre.code_transfert_technologie IS NOT NULL
                                                      
                                                      AND eu_candidature_membre.code_acces_salle IS NOT NULL
                                                      
                                                      AND eu_candidature_membre.code_pouvoirfaire IS NOT NULL
                                                      
                                                      AND eu_candidature_membre.id_utilisateur_create_count IS NULL
                                                      
                                                      AND eu_candidature_membre.vu_codeacces = 1
                                                      
                                                      AND eu_candidature_membre.vu_codetransferttechnologie = 1
                                                      
                                                      AND eu_candidature_membre.vu_pouvoirfaire = 1
                                                      
                                                      AND eu_candidature_membre.signature_contrat = 1";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtverifierlerespectdelaprocedureagrot = $db->query($dbverifierlerespectdelaprocedureagrot);

            $verifierlerespectdelaprocedureagrot = $stmtverifierlerespectdelaprocedureagrot->fetchAll();

            if (count($verifierlerespectdelaprocedureagrot) != 0)
            {

                 $code_membre = $verifierlerespectdelaprocedureagrot[0]->code_membre;
                 
                 $id_candidature_membre = $verifierlerespectdelaprocedureagrot[0]->id_candidature_membre;

                 $id_candidature_postes = $verifierlerespectdelaprocedureagrot[0]->id_candidature_postes;

                 $id_candidature = $verifierlerespectdelaprocedureagrot[0]->id_candidature;

                 $nom_postes = $verifierlerespectdelaprocedureagrot[0]->libelle_roles;

                 $id_supportintrant = $verifierlerespectdelaprocedureagrot[0]->id_support_intrant_ot;


                 $tab_user[] = array(

                    'code_membre_ot'=>$code_membre,

                    'id_candidature_membre_ot'=>$id_candidature_membre,

                    'id_candidature_postes_ot'=>$id_candidature_postes,

                    'id_candidature_ot'=>$id_candidature,

                    'nom_postes_ot'=>$nom_postes,

                    'id_supportintrant_ot'=>$id_supportintrant

                 );

            }
            
        }

        $this->view->tableaudesfuturutilisateurs = $tab_user;

    }

    public function ajouterunetacheotAction () {

        //Nom des tables: eu_taches_ot
        /**
         * Ajouter plusieurs taches à la fois
         * Définir le nombre maximal de personnes pour executer la tâches,
         * Définir un responsable de tâche
         * Les utilisateurs qui seront ajouter à une tâche
         * 
         */

        $db = Zend_Db_Table::getDefaultAdapter();

        $dbtachesot = new Application_Model_DbTable_EuTachesOT();

        $dbdetailtachesot = new Application_Model_DbTable_EuDetailsTachesOT();

        $dbuserdetailtachesot = new Application_Model_DbTable_EuUserDetailsTachesOT();


        $id_utilisateurot = $_SESSION['utilisateur']['id_utilisateur'];
        
        $createdot = Zend_Date::now();

        $datecreatecompteot = $createdot->toString('yyyy-MM-dd HH:mm:ss');

        $request = $this->getRequest();

        $this->view->id_utilisateur = $id_utilisateurot;

        if ($request->isPost()) {

           $libelle_taches_ot = $_POST['libelle_taches_ot'];

           for ($i = 0; $i< count($libelle_taches_ot); $i++) {

                $true_libelle_taches_ot = htmlspecialchars($_POST['libelle_taches_ot'][$i]);    
                
                $utilisateur_taches_ot = htmlspecialchars($_POST['utilisateur_taches_ot_badges'][$i]);

                $user_parent_roles = htmlspecialchars($_POST['user_parent_roles'][$i]);

                $date_debut_tache_ot = htmlspecialchars($_POST['date_debut_tache_ot'][$i]);

                $date_fin_tache_ot = htmlspecialchars($_POST['date_fin_tache_ot'][$i]);

                $online_tache_ot = htmlspecialchars($_POST['online_tache_ot'][$i]);

                $queryverificationuser = "SELECT eu_utilisateur.id_utilisateur, eu_user_roles_permissions.id_roles

                                          FROM eu_utilisateur, eu_user_roles_permissions

                                          WHERE eu_utilisateur.id_utilisateur = eu_user_roles_permissions.id_utilisateur

                                          AND eu_utilisateur.id_utilisateur = '$utilisateur_taches_ot'

                                          AND eu_user_roles_permissions.id_utilisateur = '$utilisateur_taches_ot'

                                          AND eu_user_roles_permissions.id_roles = '$user_parent_roles'
                                                            
                                          AND eu_utilisateur.reference_user_role LIKE '%OT%'"; 

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverificationuser = $db->query($queryverificationuser);

                $verificationuser = $stmtverificationuser->fetchAll();

                if (count($verificationuser) == 0){

                    $validationerrors['empty_id_utilisateur'] = "L'utilisateur que vous essayez d'ajouter à la tâche $true_libelle_taches_ot n'a pas encore de compte professionel";
                  
                }


                if (count($verificationuser) != 0) {

                    $id_roles_user_ot = $verificationuser[0]->id_roles;

                    $newid_utilisateur = $verificationuser[0]->id_utilisateur;

                    $dballchildrenfromparentot = "SELECT * 
                    
                                                  FROM eu_roles_parents_distant
                                                  
                                                  WHERE eu_roles_parents_distant.id_roles = '$id_roles_user_ot'
                                                  
                                                  AND eu_roles_parents_distant.parents_roles = '$user_parent_roles'";

                    
                    $stmtallchildrenfromparentot = $db->query($dballchildrenfromparentot);

                    $allchildrenfromparentot = $stmtallchildrenfromparentot->fetchAll();

                    $countallchildrenfromparentot = count($allchildrenfromparentot);
                    
                    if ($countallchildrenfromparentot == 0) {

                        $validationerrors['empty_libelle_tache'] = "Erreur 1735:Vous n'êtes pas autorisé à effectuer cette action";

                    }
                }


                if ($true_libelle_taches_ot == ""){
                
                    $validationerrors['empty_libelle_tache'] = "Vous devez renseigner les informations concernant le libellé de la tache OT";
    
                }

                if ($utilisateur_taches_ot ==  ""){

                    $validationerrors['empty_utilisateur_taches'] = "Vous devez affecter un utilisateur à la tache $true_libelle_taches_ot";

                }
    
                if ($user_parent_roles ==  ""){

                    $validationerrors['empty_roles_parent'] = "Votre poste doit être renseigné dans l'enregistrement des informations";

                }

                if ($date_debut_tache_ot ==  ""){

                    $validationerrors['empty_roles_parent'] = "La date de debut de la tâche $true_libelle_taches_ot doit être renseignée";

                }
                
                if ($date_fin_tache_ot ==  ""){

                    $validationerrors['empty_roles_parent'] = "La date de fin de la tâche $true_libelle_taches_ot doit être renseignée";

                }

                if ($date_debut_tache_ot  >= $date_fin_tache_ot) {

                    $validationerrors['empty_roles_parent'] = "La date de début de la tâche $true_libelle_taches_ot ne doit pas être antérieure ou égale à sa date de fin";


                }
                
                
                if(!array_key_exists('libelle_taches_ot', $_POST) || !array_key_exists('utilisateur_taches_ot', $_POST) || 
                
                   !array_key_exists('date_debut_tache_ot', $_POST) || !array_key_exists('date_fin_tache_ot', $_POST) || !array_key_exists('online_tache_ot', $_POST)){
    
                    $validationerrors['error_libelle_taches_ot'] = "Erreur 404:Vous éssayez d'effectuer une action qui n'est pas autorisé";
    
                }


           }

           
           if (!empty($validationerrors)){

                 $_SESSION['validationerrors'] = $validationerrors;
            
           }

           if (empty($validationerrors)){

            
                    $ref_taches = substr(md5(uniqid(rand(), true)), 0, 8);
                
                    $real_ref_taches = strtoupper('TACHES-'.$ref_taches);

                     $dbinsertacheot = array(
                         
                        'id_parent_ot'=>$id_utilisateurot,

                        'reference_taches_ot'=>$real_ref_taches,

                        'date_taches_ot'=>$datecreatecompteot
                     );

                     if ($dbtachesot->insert($dbinsertacheot)){
                            
                           $querysearchlastidtaches = "SELECT eu_taches_ot.id_taches_ot FROM eu_taches_ot WHERE eu_taches_ot.reference_taches_ot = '$real_ref_taches'";

                           $stmtsearchlastidtaches = $db->query($querysearchlastidtaches);

                           $searchlastidtaches = $stmtsearchlastidtaches->fetchAll();
       
                           $countsearchlastidtaches = count($searchlastidtaches);

                           if ($countsearchlastidtaches != 0){

                                $idsearchtaches = $searchlastidtaches[0]->id_taches_ot;

                                for ($i = 0; $i< count($libelle_taches_ot); $i++) {

                                     $ref_detail_taches = substr(md5(uniqid(rand(), true)), 0, 9);
                
                                     $real_ref_detail_taches = strtoupper('DETAILTACHES-'.$ref_taches);
                
                                     $true_libelle_taches_ot = htmlspecialchars($_POST['libelle_taches_ot'][$i]);    
                                
                                     $utilisateur_taches_ot = $_POST['utilisateur_taches_ot_badges'][$i];
                    
                                     $user_parent_roles = $_POST['user_parent_roles'][$i];
                    
                                     $date_debut_tache_ot = $_POST['date_debut_tache_ot'][$i];
                    
                                     $date_fin_tache_ot = $_POST['date_fin_tache_ot'][$i];
                    
                                     $online_tache_ot = $_POST['online_tache_ot'][$i];
                                  
                                     $dbinserdetailtacheot = array(
                                        
                                       'references_detail_taches_ot'=>$real_ref_detail_taches,
                         
                                       'libelle_taches_ot'=>$true_libelle_taches_ot,
                        
                                       'date_debut_taches'=>$date_debut_tache_ot,

                                       'date_fin_taches'=>$date_fin_tache_ot,

                                       'id_taches_ot'=>$idsearchtaches

                                    );

                                    if ($dbdetailtachesot->insert($dbinserdetailtacheot)){

                                         $querysearchlastiddetailtaches = "SELECT eu_detail_taches_ot.id_detail_taches_ot 
                                         
                                                                            FROM eu_detail_taches_ot 
                                                                
                                                                            WHERE id_detail_taches_ot.references_detail_taches_ot = '$real_ref_detail_taches'";

                                         $stmtsearchlastiddetailtaches = $db->query($searchlastiddetailtaches);
             
                                         $searchlastiddetailtaches = $stmtsearchlastiddetailtaches->fetchAll();
                    
                                         $countsearchlastiddetailtaches = count($searchlastiddetailtaches);

                                         if ($countsearchlastiddetailtaches != 0){

                                             $idsearchdetailtaches = $searchlastiddetailtaches[0]->id_detail_taches_ot;

                                             $dbinsertuserdetailtacheot = array(

                                                'id_detail_taches_ot'=>$idsearchdetailtaches,
                                                 
                                                'id_utilisateur'=>$utilisateur_taches_ot

                                             );

                                             if ($dbuserdetailtachesot->insert($dbinsertuserdetailtacheot)){

                                                 $this->_redirect("/gestionoffredetravail/listedestachesotajouteparunot");

                                             }

                                         }

                                    }
                                  
                                }
                     
                            }
    
               }  
           }

        }

    }

    public function rechercherlesotenfantduparentAction () {

        /**
         * 
         * Le parent ne peut déléguer les taches qu'à ses enfants et à aucun autre
         * Est ce que les taches seront déléguées aux enfants d'une même agences centres centrales 
         * Est ce que c'est seulement la personne qui a crée cet utilisateur qui a le droit de l'ajouter à une tache
         * 
         */

        $db = Zend_Db_Table::getDefaultAdapter();

        $id_utilisateurot = $_SESSION['utilisateur']['id_utilisateur'];

        $code_membre_ot = htmlspecialchars($_POST['code_membre_ot']); 

        $id_utilisateur_parent = htmlspecialchars($_POST['id_utilisateur_parent']);
        
        $createdot = Zend_Date::now();

        $datecreatecompteot = $createdot->toString('yyyy-MM-dd HH:mm:ss');

        $resultjson = array();
        
    
        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();
        }

        if ($id_utilisateurot != $id_utilisateur_parent){

            $resultjson = array(

                'error'=> "Cette action est soumis aux règles d'authentification",
            );
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $dbtselectnameuser = "SELECT eu_utilisateur.id_utilisateur, 
            
                                         eu_membre.nom_membre, 
                                         
                                         eu_membre.prenom_membre,

                                         eu_user_roles_permissions.id_roles

                                  FROM eu_utilisateur, eu_user_roles_permissions, eu_membre

                                  WHERE eu_utilisateur.id_utilisateur = eu_user_roles_permissions.id_utilisateur
                                  
                                  AND eu_utilisateur.code_membre = eu_membre.code_membre

                                  AND eu_utilisateur.code_membre = '$code_membre_ot'
                          
                                  AND eu_utilisateur.id_utilisateur_parent = '$id_utilisateur_parent'
                                  
                                  AND eu_utilisateur.reference_user_role LIKE '%OT%'"; 

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtnameuser = $db->query($dbtselectnameuser);

            $nameuser = $stmtnameuser->fetchAll();

            if (count($nameuser) == 0) {

                $resultjson = array(

                    'success'=>0,

                    'message'=>'Aucun utilisateur n\'a été trouvé'
                );

            }

            if (count($nameuser) != 0){

                 $nom_membre = $nameuser[0]->nom_membre;

                 $prenom_membre = $nameuser[0]->prenom_membre;

                 $complete_name_user = $nom_membre." ".$prenom_membre;

                 $id_utilisateur = $nameuser[0]->id_utilisateur;

                 $id_roles_parent = $nameuser[0]->id_roles;
            
                 $resultjson = array(

                     'success'=>1,

                     'message'=>array(
                         
                     'nometprenoms'=> $complete_name_user,

                     'utilisateur'=>$id_utilisateur,

                     'postuserparent'=>$id_roles_parent
                     
                     )
                 );                
            }
        }

        header('Content-type:application/json');
        
        die(json_encode($resultjson));

    }

    public function removeuseraddtachebadgeAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $id_utilisateurot = $_SESSION['utilisateur']['id_utilisateur'];

        $code_membre_ot = htmlspecialchars($_POST['code_membre_ot']); 

        $id_utilisateur_parent = htmlspecialchars($_POST['id_utilisateur_parent']);
        
        $resultjson = array();
        
    
        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            http_response_code(403);

            die();
        }

        header('Content-type:application/json');
        
        die(json_encode($removejson));

    }

    public function editerunetacheotAction () {


        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $idsuivitaches = (int)$this->_request->getParam('suivitaches');

        $validationerrors = array();

        if($_SERVER['REQUEST_METHOD'] != 'GET'){

            if (!isset($id_utilisateur)){
      
                http_response_code(403);

                die('Vous devez vous connectez avant de consulter cette page');

            }

            if (isset($id_utilisateur)){

                if (!isset($id_utilisateur)){
      
                    http_response_code(403);
    
                    die('Vous n\'êtes pas autorisé a éffectuer cet type d\'opérartion');
    
                }                
            }

        }

        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            if (!isset($id_utilisateur)){
      
                http_response_code(403);

                die('Vous devez vous connectez avant de consulter cette page');

            }

            if (isset($id_utilisateur)){

                $dbuserselectroles = "SELECT eu_user_roles_permissions.id_roles
                
                                      FROM eu_user_roles_permissions
                           
                                      WHERE eu_user_roles_permissions.id_utilisateur = '$id_utilisateur'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtuserselectroles = $db->query($dbuserselectroles);
    
                $userselectroles =  $stmtuserselectroles->fetchAll();

                if (count($userselectroles) == 0) {

                    http_response_code(403);

                    die('Vous n\'avez pas suivit la procédure de création d\'utilisateur donc vous n\'êtes pas autorisé a éffectuer cette opération');
                }

                if (count($userselectroles) != 0) {

                    $id_roles = $userselectroles[0]->id_roles;

                    $dbselectallparentroles = "SELECT eu_roles_parents_distant.parents_roles, eu_roles.libelle_roles
                    
                                               FROM eu_roles_parents_distant, eu_roles
                                               
                                               WHERE eu_roles_parents_distant.id_roles = eu_roles_parents_distant.id_parents_roles
                                               
                                               AND eu_roles_parents_distant.id_roles = $id_roles";
 
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    
                    $stmtselectallparentroles = $db->query($dbselectallparentroles);
    
                    $selectallparentroles =  $stmtselectallparentroles->fetchAll();

                    if (count()){

                    }
                }

            }



        }

    }

    public function listedestachesotajouteparunotAction () {

        /***Les parents qui ont créé l'utilisateur courant sont les seuls à pouvoir consulter cette page
         * 
         * 
         */

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        if($_SERVER['REQUEST_METHOD'] != 'GET'){

            if (!isset($id_utilisateur)){
      
                http_response_code(403);

                die('Vous devez vous connectez avant de consulter cette page');

            }

            if (isset($id_utilisateur)){

                $dbuserselectroles = "SELECT eu_user_roles_permissions.id_roles
                
                                      FROM eu_user_roles_permissions
                           
                                      WHERE eu_user_roles_permissions.id_utilisateur = '$id_utilisateur'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtuserselectroles = $db->query($dbuserselectroles);
    
                $userselectroles =  $stmtuserselectroles->fetchAll();

                if (count($userselectroles) > 0) {

                    $id_roles = $userselectroles[0]->id_roles;

                    $dbselectallparentroles = "SELECT eu_roles_parents_distant.parents_roles, eu_roles.libelle_roles
                    
                                               FROM eu_roles_parents_distant, eu_roles
                                               
                                               WHERE eu_roles_parents_distant.id_roles = eu_roles_parents_distant.id_parents_roles
                                               
                                               AND eu_roles_parents_distant.id_roles = $id_roles";
 
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    
                    $stmtuserselectroles = $db->query($dbuserselectroles);
    
                    $userselectroles =  $stmtuserselectroles->fetchAll();
                }

           }
        }
        
        $dblistedetouslestravauxbyuser = "SELECT * 
        
                                          FROM eu_taches_ot
                                          
                                          WHERE eu_taches_ot.id_parent_ot = '$id_utilisateur'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    
        $stmtlistedetouslestravauxbyuser = $db->query($dblistedetouslestravauxbyuser);
    
        $listedetouslestravauxbyuser =  $stmtlistedetouslestravauxbyuser->fetchAll();

        $countlistedetouslestravauxbyuser = count($listedetouslestravauxbyuser);    

        $this->view->listedetouslestravauxbyuser = $listedetouslestravauxbyuser;

        $this->view->countlistedetouslestravauxbyuser = $countlistedetouslestravauxbyuser;

    }




    public function modificationdecompteotAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();


        
    }

    public function recuperationdelalistedesoffreursdetravailAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        $display_length = $_GET['example_length'];

        $idisplay_lenth = $_GET['iDisplayLength'];

        var_dump($display_length);

        var_dump($idisplay_lenth);

        /*session_start();$_SESSION['code_membre'] = "0010010010010002975P";*/
        
        $dbtselect = "SELECT eu_travailleur.travailleur_code_membre, eu_travailleur.travailleur_id, eu_travailleur.travailleur_libelle, eu_travailleur.travailleur_date FROM eu_travailleur"; 
        
        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbtselect);

        $dbprestataire = $stmt->fetchAll();

        $this->view->prestatairelist = $dbprestataire;
        

        if ($request->isPost()) {

            for ($i = 0; $i< count($_POST['check_one_selection_prestataire']); $i++) {

                 $id_travailleur = htmlspecialchars($_POST['check_one_selection_prestataire'][$i]);

                 if (!isset($id_travailleur) || $id_travailleur == "" ){

                    $validationerrors['empty_id_travailleur'] = "Echec d'enregistrement du travailleur sélectionné:Vous tentez d'effectuer une action qui n'est pas autorisée";
                 
                }

                 if(!empty($validationerrors)){

                    $_SESSION['validationerrors'] = $validationerrors;

                 }

                 if(empty($validationerrors)){

                    $dbfupdate = "UPDATE eu_travailleur SET publier = 2 WHERE travailleur_id = $id_travailleur";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    $stmt = $db->query($dbfupdate);

                    $validationpertesuccess['success_request'] = "La sélection des prestataires a été correctement effectué";

                    $_SESSION['validationpertesuccess'] = $validationpertesuccess;

              }


            }

        }
        $this->view->tabletri = 1; 

    }


    public function detaildesexperiencesdesprestatairesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $id = (int)$this->_request->getParam('id');
        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $dbtselect = "SELECT eu_travailleur.travailleur_libelle, eu_travailleur.travailleur_experience
                          FROM eu_travailleur
                          WHERE eu_travailleur.travailleur_id = $id"; 

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmt = $db->query($dbtselect);

            $dbverifprestataireexperience = $stmt->fetchAll(); 

            $countdbverifcontratprestataireexperience = count($dbverifprestataireexperience );
    
            if($countdbverifcontratprestataireexperience == 0){

                http_response_code(403);

                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');

            }else{

                $this->view->verifcontratprestataireexperience = $dbverifprestataireexperience ;

            }
            
        }
        
    }


    public function recuperationdelalistedesprestatairedejaselectionnerAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        $validationerrors = array();

        $dbtselect = "SELECT * FROM eu_travailleur, eu_roles WHERE eu_travailleur.id_roles = eu_roles.id_roles AND eu_travailleur.publier = 2";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbtselect);

        $dbprestataireselectionner = $stmt->fetchAll();

        $this->view->prestatairelistselectionner = $dbprestataireselectionner;

        if ($request->isPost()) {

            for ($i = 0; $i< count($_POST['check_one_selection_prestataire']); $i++) {

                 $id_travailleur = $_POST['check_one_selection_prestataire'][$i];

                 if (!isset($id_travailleur) || $id_travailleur == "" ){

                    $validationerrors['empty_id_travailleur'] = "Echec d'enregistrement du travailleur sélectionné:Vous tentez d'effectuer une action qui n'est pas autorisée";
                 
                }

                 if(!empty($validationerrors)){

                    $_SESSION['validationerrors'] = $validationerrors;

                 }

                 if(empty($validationerrors)){
                  
                   $dbfupdate = "UPDATE eu_travailleur SET publier = 1 WHERE travailleur_id = $id_travailleur";

                   $db->setFetchMode(Zend_Db::FETCH_OBJ);

                   $stmt = $db->query($dbfupdate);


                   $validationpertesuccess['success_request'] = "La re-sélection des prestataires a été correctement effectué";

                   $_SESSION['validationpertesuccess'] = $validationpertesuccess;

                 }

            }

        }
        
    }


    public function fixationdumontantdepayementdesprestatairesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();
        
        $created = Zend_Date::now();

        $request = $this->getRequest();

        $validationerrors = array();

        $code_membre = (string)$this->_request->getParam('codemembre');

        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $dbtselect = "SELECT eu_travailleur.travailleur_id, eu_travailleur.travailleur_libelle
                          FROM eu_travailleur, eu_contratprestataire
                          WHERE eu_travailleur.travailleur_id = eu_contratprestataire.id_travailleur
                          AND eu_travailleur.travailleur_code_membre = '$code_membre'
                          AND eu_travailleur.publier = 2"; 

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmt = $db->query($dbtselect);

            $dbverifcontratprestataire = $stmt->fetchAll(); 

            $countdbverifcontratprestataire = count($dbverifcontratprestataire);
    
            if($countdbverifcontratprestataire == 0){

                http_response_code(403);

                die('Vous tentez d\'effectuer une action qui n\'est pas autorisé');

            }



            $this->view->verifcontratprestataire = $dbverifcontratprestataire;
            
        }
        if ($request->isPost()) {        

            $fixationdumontantdelaprestation = $_POST['montant_prestation'];
            
            if (!isset($fixationdumontantdelaprestation)  || $fixationdumontantdelaprestation == "" || $fixationdumontantdelaprestation == 0){

                $validationerrors['empty_fixationdumontantdelaprestation'] = "Echec de la fixation du montant de la prestation pour le prestataire:Vous tentez d'effectuer une action qui n'est pas autorisée";
            }

            if(!filter_var($fixationdumontantdelaprestation, FILTER_VALIDATE_REGEXP,
            array("options"=>array("regexp"=>"#[0-9]#")))){
               $validationerrors['verif_fixation_montant'] = "le montant de la prestatation est invalide";
            }

            
           if(!empty($validationerrors)){
            $_SESSION['validationerrors'] = $validationerrors;
           }

           if (empty($validationerrors)){
               $dbfupdate = "UPDATE eu_travailleur SET montant_prestation = $fixationdumontantdelaprestation WHERE travailleur_code_membre = '$code_membre'";
               $db->setFetchMode(Zend_Db::FETCH_OBJ);
               $stmt = $db->query($dbfupdate);
               $this->_redirect("/gestionoffredetravail/listedesprestatairesafixerlemontant");

               $validationpertesuccess['success_request'] = "La fixation du montant de la prestation pour ce prestaire a été correctement effectué";
               $_SESSION['validationsuccess'] = $validationsuccess;
           }

        }

    }



    public function recupererlesdetailsdelalistedesprestairesAction () {
        $this->_helper->layout->disableLayout();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $request = $this->getRequest();
        $resultjson = array();
        
        $id_travailleur = $_POST['id_travailleur'];

        $dbtselect = "SELECT * FROM eu_travailleur, eu_roles WHERE eu_travailleur.id_roles = eu_roles.id_roles AND eu_travailleur.travailleur_id=$id_travailleur"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dblistdetailsbyprestataire = $stmt->fetchAll();

        $idtravailleur = $dblistdetailsbyprestataire[0]->travailleur_id;
        
        $nometprenoms = $dblistdetailsbyprestataire[0]->travailleur_libelle;
        $montantdelaprestation = $dblistdetailsbyprestataire[0]->montant_prestation;
        $numerodelacartedidentite = $dblistdetailsbyprestataire[0]->travailleur_numero_cin;
        $datedelivrancecartedidentite = $dblistdetailsbyprestataire[0]->travailleur_date_delivrance_cin;
        $datedexpirationcartedidentite = $dblistdetailsbyprestataire[0]->travailleur_date_expiration_cin;
        $typedetravaille = $dblistdetailsbyprestataire[0]->travailleur_type;
        $addressedutravailleur = $dblistdetailsbyprestataire[0]->travailleur_adresse;
        $experiencedutravailleur = $dblistdetailsbyprestataire[0]->travailleur_experience;
        $educationdutravailleur = $dblistdetailsbyprestataire[0]->travailleur_education;
        $niveaudutravailleur = $dblistdetailsbyprestataire[0]->travailleur_niveau;
        $formationdutravailleur = $dblistdetailsbyprestataire[0]->travailleur_formation;
        $nomdupostes = $dblistdetailsbyprestataire[0]->libelle_roles;

        if ($dblistdetailsbyprestataire[0]->publier == 2){
           $selectiondutravailleur = "Oui";

        }else{
           $selectiondutravailleur = "Non";
        }

        $resultjson = array(
            'nometprenoms'=> $nometprenoms,
            'montantdelaprestation'=> $montantdelaprestation,
            'numerodelacartedidentite'=> $numerodelacartedidentite,
            'datedelivrancecartedidentite'=> $datedelivrancecartedidentite,
            'datedexpirationcartedidentite'=> $datedexpirationcartedidentite,
            'typedetravaille'=> $typedetravaille,
            'montantdelaprestation'=> $montantdelaprestation,
            'addressedutravailleur'=> $addressedutravailleur,
            'experiencedutravailleur'=> $experiencedutravailleur,
            'educationdutravailleur'=> $educationdutravailleur,
            'niveaudutravailleur'=> $niveaudutravailleur,
            'formationdutravailleur'=> $formationdutravailleur,
            'selectiondutravailleur'=>$selectiondutravailleur,
            'nomdupostes'=> $nomdupostes, 
            'idtravailleur'=>$idtravailleur
         );

        header('Content-type:application/json');
        die(json_encode($resultjson));
        
    }

    public function _signatureducontratdeprestationAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        $request = $this->getRequest();
        $created = Zend_Date::now();
    	$sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membre = $sessionmembre->code_membre;
        
        $date_signature = $created->toString('yyyy-MM-dd HH:mm:ss');
        $validationsuccess = array();
        $validationerrors = array();
        
        $dbtselect = "SELECT eu_travailleur.travailleur_libelle,
                             eu_travailleur.travailleur_numero_cin,
                             eu_travailleur.travailleur_date_delivrance_cin,
                             eu_travailleur.travailleur_date_expiration_cin,
                             eu_travailleur.travailleur_id,
                             eu_membre.date_nais_membre,
                             eu_membre.portable_membre,
                             eu_membre.profession_membre,
                             eu_membre.lieu_nais_membre
                     FROM eu_travailleur, eu_membre
                     WHERE eu_travailleur.travailleur_code_membre = eu_membre.code_membre
                     AND eu_travailleur.travailleur_code_membre = '$code_membre'
                     AND eu_travailleur.publier = 2 "; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbsignatureprestataire = $stmt->fetchAll();   
        $this->view->prestatairesignature = $dbsignatureprestataire;


        if ($request->isPost()) {
           $idprestatairesignature = $_POST['id_contrat_prestataire'];

           if (!isset($idprestatairesignature)  || $idprestatairesignature == "" || $idprestatairesignature == 0){
              $validationerrors['empty_id_prestataire_signature'] = "Echec de la signature du contrat:Vous tentez d'effectuer une action qui n'est pas autorisée";
           }

           $dbtselect = "SELECT eu_travailleur.travailleur_id
                         FROM eu_travailleur
                         WHERE eu_travailleur.travailleur_code_membre = '$code_membre'
                         AND eu_travailleur.publier = 2 
                         AND eu_travailleur.travailleur_id = $idprestatairesignature"; 
           $db->setFetchMode(Zend_Db::FETCH_OBJ);
           $stmt = $db->query($dbtselect);
           $dbverifsignatureprestataireid = $stmt->fetchAll();  

           if (count($dbverifsignatureprestataireid) == 0){
              $validationerrors['exist_id_prestataire_signature'] = "Echec de signature du contrat:Vous tentez d'effectuer une action qui n'est pas autorisée";
           }

           if(!empty($validationerrors)){
            $_SESSION['validationerrors'] = $validationerrors;
           }

           if(empty($validationerrors) && count($dbverifsignatureprestataireid) > 0){
               $dbfinsert = "INSERT INTO 
                          eu_contratprestataire(
                           id_travailleur,
                           date_signature) 
                           VALUES (
                           '$idprestatairesignature',
                           '$date_signature'                               
                           )";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfinsert);
                $validationsuccess['success_message'] = "La signature a été effectué avec succes";
                $_SESSION['validationsuccess'] = $validationsuccess;
                $this->_redirect("/gestionoffredetravail/recuperationdelalistedesoffreursdetravail");

           }

        }
        
    }


    public function signatureducontratdeprestationsecondniveauAction () {
        
    }

    
    public function editiondecontratdeprestataireenadministrationAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

       if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $dbtselect = "SELECT eu_travailleur.travailleur_code_membre,
                             eu_travailleur.travailleur_id,
                             eu_travailleur.travailleur_libelle,
                             eu_membre.date_nais_membre, 
                             eu_travailleur.montant_prestation,
                             eu_membre.portable_membre,
                             eu_membre.profession_membre,
                             eu_membre.lieu_nais_membre,
                             eu_contratprestataire.date_signature
                    FROM eu_travailleur, eu_contratprestataire, eu_membre
                    WHERE eu_travailleur.travailleur_id = eu_contratprestataire.id_travailleur
                    AND eu_travailleur.travailleur_code_membre = eu_membre.code_membre
                    AND eu_travailleur.publier = 2
                    AND eu_contratprestataire.id_travailleur=$id"; 
            $stmt = $db->query($dbtselect);
            $dbrecherchesileprestataireasignerlecontrat = $stmt->fetchAll();
            if(count($dbrecherchesileprestataireasignerlecontrat) == 0){
                http_response_code(403);
                die('Ce prestaire n\'a pas encore signé le contrat de prestaire');
            }else{
             $this->view->recherchesileprestataireasignerlecontrat = $dbrecherchesileprestataireasignerlecontrat;
                
            }
       }

        
    }
    public function listedesprestatairesafixerlemontantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        

        $dbtselect = "SELECT eu_travailleur.travailleur_code_membre,
                             eu_travailleur.travailleur_id,
                             eu_travailleur.travailleur_libelle,
                             eu_travailleur.travailleur_date, 
                             eu_travailleur.montant_prestation
                      FROM eu_travailleur, eu_contratprestataire
                      WHERE eu_travailleur.travailleur_id = eu_contratprestataire.id_travailleur
                      AND eu_travailleur.publier = 2"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbprestatairecontratfixerlemontant = $stmt->fetchAll();

        $this->view->prestatairecontratfixerlemontant = $dbprestatairecontratfixerlemontant;
        

    }


    public function prestatairecontractantAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $level_validation = (string)$this->_request->getParam('niveaudevalidation');

        if ($level_validation == "secretaire"){
            $validation = 0;
        }
        
        if ($level_validation == "technopole"){
            $validation = 1;
        }

        if ($level_validation == "filiere"){
            $validation = 2;
        }

        if ($level_validation == "acnev"){
            $validation = 3;
        }

        if ($level_validation == "contractant"){
            $validation = 4;            
        }
        
        $dbtselect = "SELECT eu_travailleur.travailleur_code_membre,
                             eu_travailleur.travailleur_id,
                             eu_travailleur.travailleur_libelle,
                             eu_travailleur.travailleur_date
                     FROM eu_travailleur, eu_contratprestataire
                     WHERE eu_travailleur.travailleur_id = eu_contratprestataire.id_travailleur
                     AND eu_travailleur.publier = 2 
                     AND eu_contratprestataire.valid = $validation"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbprestatairecontratvalidation = $stmt->fetchAll();
        
        $this->view->prestatairecontratvalidation = $dbprestatairecontratvalidation;
        $this->view->level_validation = $level_validation;
        
    }


    public function editcontratprestataireAction () {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $idprestataire = (int)$this->_request->getParam('id');
        

        $request = $this->getRequest();

        $dbtselect = "SELECT eu_travailleur.travailleur_code_membre,
                             eu_travailleur.travailleur_id,
                             eu_travailleur.travailleur_libelle,
                             eu_travailleur.travailleur_date
                     FROM eu_travailleur, eu_contratprestataire
                     WHERE eu_travailleur.travailleur_id = eu_contratprestataire.id_travailleur
                     AND eu_travailleur.publier = 2 
                     AND eu_contratprestataire.valid = $validation"; 
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
        $dbprestatairelectureducontrat = $stmt->fetchAll();

        $this->view->prestatairelectureducontrat = $dbprestatairelectureducontrat;
    }

    public function recupererlemontantduprestataireAction () {
        $this->_helper->layout->disableLayout();
        $db = Zend_Db_Table::getDefaultAdapter();

        $resultjson = array();
        
    
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $id_travailleur_montant = $_POST['id_travailleurmontant']; 
            
            $dbtselect = "SELECT eu_travailleur.montant_prestataire
                          FROM eu_travailleur
                          WHERE eu_travailleur.travailleur_id=$id_travailleur_montant
                          AND eu_travailleur.publier = 2"; 
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtselect);
            $dblistdetailsbyprestataire = $stmt->fetchAll();

            $montant_prestataire = $dblistdetailsbyprestataire[0]->montant_prestataire;
            
            $resultjson = array(
                'montantdelaprestation'=> $montant_prestataire);

        }
        
        header('Content-type:application/json');
        die(json_encode($resultjson));

    }

    public function ajaxsendsecretariattotechnopoleAction () {
        $this->_helper->layout->disableLayout();
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $resultjson = array();

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            http_response_code(403);
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $level_validation = (string)$this->_request->getParam('niveaudevalidation');

            $validation = 0;
            $updatevalidation = 1;
            if ($level_validation == "technopole"){
                $validation = 0;
                $updatevalidation = 1;
                
            }
    
            if ($level_validation == "filiere"){
                $validation = 1;
                $updatevalidation = 2;
                
            }
    
            if ($level_validation == "acnev"){
                $validation = 2;
                $updatevalidation = 3;
                
            }

            if ($level_validation == "contractant"){
                $validation = 3;
                $updatevalidation = 4;
                
            }
            $idworkersecretariattotechnopole = $_POST['id_workersecretariattotechnopole'];
            $codemembreworkersecretariattotechnopole = $_POST['code_membreworkersecretariattotechnopole'];
            $nameworkersecretariattotechnopole = $_POST['nameworkersecretariattotechnopole'];
            $dbtselect = "SELECT eu_travailleur.travailleur_id
                          FROM eu_travailleur, eu_contratprestataire
                          WHERE eu_travailleur.travailleur_id = eu_contratprestataire.id_travailleur
                          AND eu_travailleur.publier = 2 
                          AND eu_contratprestataire.valid = $validation
                          AND eu_travailleur.travailleur_id = $idworkersecretariattotechnopole
                          AND eu_travailleur.travailleur_code_membre =  '$codemembreworkersecretariattotechnopole'
                          AND eu_travailleur.travailleur_libelle = '$nameworkersecretariattotechnopole'"; 
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbtselect);
            $dbverifvaliditer = $stmt->fetchAll();

            $countdbverifvaliditer = count($dbverifvaliditer);

            if ($countdbverifvaliditer == 0) {
                $resultjson = array(
                     'result'=>'Error 404: Vous tentez d\'effectuer une action qui n\'est pas autorisé'
                );
            }

            if ($countdbverifvaliditer > 0){
                $dbfupdate = "UPDATE eu_contratprestataire SET valid = $updatevalidation WHERE eu_contratprestataire.id_travailleur = $idworkersecretariattotechnopole";
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                $stmt = $db->query($dbfupdate);

                $resultjson = array(
                    'result'=>"Affectation du contrat à la $level_validation effectuée avec succès"
                );
            }
            
        }

        header('Content-type:application/json');
        die(json_encode($resultjson));
        
        
    }

    public function editfixationdumontantdelaprestationAction () {

    }


}