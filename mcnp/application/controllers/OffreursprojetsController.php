<?php

class OffreursprojetsController extends Zend_Controller_Action {

    public function init(){

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

    }

    public function addoffreprojetAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $created = Zend_Date::now();

        $date_created_op = $created->toString('yyyy-MM-dd HH:mm:ss');

        $request = $this->getRequest();

        $validationerrorsop = array();


        $opespace = new Application_Model_DbTable_EuOpEspace();

        $venteop = new Application_Model_DbTable_EuVenteOp();

        $opfileespace = new Application_Model_DbTable_EuOpFileEspace();

        $opoutils = new Application_Model_DbTable_EuOpOutils();

        $opdetailoutils = new Application_Model_DbTable_EuOpDetailOutils();

        $opmateriel = new Application_Model_DbTable_EuOpMateriel();

        $opdetailmateriel = new Application_Model_DbTable_EuOpDetailMateriel();

        $rh = new Application_Model_DbTable_EuOpRh();

        $detailrh = new Application_Model_DbTable_EuOpDetailsRh();



        $dbselecttypecentrale = "SELECT * FROM eu_type_centrales";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselecttypecentrale = $db->query($dbselecttypecentrale);

        $dblistdestypesdecentrales = $stmtselecttypecentrale->fetchAll();

        $this->view->listdestypesdecentrales = $dblistdestypesdecentrales;

        
        if ($request->isPost()) {

            $nom_projet = $_POST['op_libelle_projet'];

            $description_projet = $_POST['op_description_projet'];

            $type_centrale = $_POST['op_type_centrale'];

            $op_espace = $_POST['op_espace'];

            $op_outils = $_POST['op_outils'];

            $op_materiel = $_POST['op_materiel'];

            $opmontanttotalprojet = 0;

            $op_rh = $_POST['op_rh'];

            $sessionmembre = new Zend_Session_Namespace('membre');	
        
            $op_code_membre_projet = $sessionmembre->code_membre;

            $dbarrayventeop = array();


            $ref_op = substr(md5(uniqid(rand(), true)), 0, 8);

            $real_ref_op = strtoupper('OP-'.$ref_op); 

            $idoplastinsertespace = 0;

            $idoplastinsertmateriel = 0;

            $idoplastinsertoutils = 0;

            $idoplastinsertrh = 0;

            $idlastinsertvop = 0;


            if ($op_espace == 0 && $op_materiel == 0 && $op_outils == 0 && $op_rh == 0){

                $validationerrorsop['errors_selectatleastonecheck'] = "Vous devez selectionner au moins 1 aspect";

            }

            if (!empty($validationerrorsop)){

                $_SESSION['validationerrorsop'] = $validationerrorsop;
                
            }

            if (empty($validationerrorsop)){

            $dbarrayventeop = array(

                'reference_op'=>$real_ref_op,

                'libelle_vente_op'=>$nom_projet,

                'description_vente_op'=>$description_projet,

                'code_membre_apporteur'=>$op_code_membre_projet,

                'date_creation'=>$date_created_op,

                'id_type_centrale'=>$type_centrale,

                'date_creation'=> $date_created_op
            );

            if ($venteop->insert($dbarrayventeop)){

                
                 $dblastinsertselectvop = "SELECT eu_vente_op.id_vente_op FROM eu_vente_op WHERE eu_vente_op.reference_op = '$real_ref_op'";

                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                 $stmtlastinsertselectvop = $db->query($dblastinsertselectvop);

                 $searchlastinsertvop = $stmtlastinsertselectvop->fetchAll();

                 if (count($searchlastinsertvop) != 0){

                       $idlastinsertvop = $searchlastinsertvop[0]->id_vente_op;

                 }
            }


            

            if ($op_espace == 1){

                $op_libelle_espace = $_POST['op_libelle_espace'];

                $op_superficie_espace = $_POST['op_superficie_espace'];

                $op_description_espace = $_POST['op_description_espace'];

                $montant_espace = $_POST['op_montant_vente_espace'];

                $opmontanttotalprojet = $opmontanttotalprojet + $montant_espace;

                $countfileespace = count($_POST['espace_libelle_document_fichier']);

                $ref_espace_op = substr(md5(uniqid(rand(), true)), 0, 6);

                $real_ref_espace_op = strtoupper('OP-EP-'.$ref_espace_op); 

                if ($countfileespace == 0){

                        $dbarrayespace = array(

                              'reference_op_espace' => $real_ref_espace_op,

                              'libelle_op_espace' => $op_libelle_espace,

                              'superficie_op_espace' => $op_superficie_espace,

                              'description_op_espace' =>  $op_description_espace,

                              'montant_op_espace' => $montant_espace,

                              'date_creation' => $date_created_op,

                              'id_vente_op' => $idlastinsertvop
                        );

                        $op_espace->insert($dbarrayespace);

                }else {

                        $dbarrayespace = array(

                              'reference_op_espace' => $real_ref_espace_op,

                              'libelle_op_espace' => $op_libelle_espace,

                              'superficie_op_espace' => $op_superficie_espace,

                              'description_op_espace' =>  $op_description_espace,

                              'montant_op_espace' => $op_description_espace,
                              
                              'document_op_espace' => 1,

                              'id_vente_op' => $idlastinsertvop

                        );

                        if ($opespace->insert($dbarrayespace)){

                            $dblastinsertselect = "SELECT eu_op_espace.id_op_espace FROM eu_op_espace WHERE eu_op_espace.reference_op_espace = '$real_ref_espace_op'";

                            $db->setFetchMode(Zend_Db::FETCH_OBJ);
           
                            $stmtlastinsertselect = $db->query($dblastinsertselect);
           
                            $searchlastinsert = $stmtlastinsertselect->fetchAll();
           
                            if (count($searchlastinsert) != 0){
           
                               $idoplastinsertespace = $searchlastinsert[0]->id_op_espace;


                               for ($i = 0; $i< count($_POST['espace_libelle_document_fichier']); $i++){
                                 
                                     $nom_document = trim(addslashes($_POST['espace_libelle_document_fichier'][$i]));

                                     $tmpCvFilePath = $_FILES['detail_espace_fichier']['tmp_name'][$i];

                                     $type_file_espace = $_FILES['detail_espace_fichier']['type'][$i];


                                     
                                     if ($tmpCvFilePath  != ""){

                                        $dirfiles =  $idoplastinsertespace."_ESMC_FILES_".$op_code_membre_projet.'.pdf';

                                        $src_file = "../../fichiersweb/pdfopespace/$dirfiles";
                                        
                                        if (move_uploaded_file($tmpCvFilePath, $src_file)){

                                             $arrayfileop = array(

                                                 'name_file_espace' => $nom_document,

                                                 'file_espace' => $dirfiles,

                                                 'id_op_espace' => $idoplastinsertespace
                                             );

                                             $opfileespace->insert($arrayfileop);
                                        }

                                     }

                               }
                               
                            }
                        }
                }
                
            }

            if ($op_outils == 1){

                $ref_outil_op = substr(md5(uniqid(rand(), true)), 0, 6);

                $real_ref_outil_op = strtoupper('OP-O-'.$ref_outil_op); 

                $countfileoutils = count($_POST['outils_libelle_document_fichier']);

                $montant_op_outils = $_POST['op_montant_vent_outils'];

                $opmontanttotalprojet = $opmontanttotalprojet + $montant_op_outils;


                if ($countfileoutils != 0) {

    
                        $dbtinsertoutils = "INSERT INTO eu_op_outils(reference_op_outils, montant_op_outils, id_vente_op) VALUES (

                                              '$real_ref_outil_op', '$montant_op_outils', '$idlastinsertvop')";

                        $db->setFetchMode(Zend_Db::FETCH_OBJ);

                        if ($db->query($dbtinsertoutils)){

                            $dblastinsertoutils = "SELECT eu_op_outils.id_op_outils FROM eu_op_outils WHERE eu_op_outils.reference_op_outils = '$real_ref_outil_op'";

                            $db->setFetchMode(Zend_Db::FETCH_OBJ);
           
                            $stmtlastinsertselect = $db->query($dblastinsertoutils);
           
                            $searchlastinsertoutils = $stmtlastinsertselect->fetchAll();

                            if (count($searchlastinsertoutils) != 0) {

                               $idoplastinsertoutils = $searchlastinsertoutils[0]->id_op_outils;


                               for ($i = 0; $i< count($_POST['outils_libelle_document_fichier']); $i++){
                                 
                                     $nomdocumentoutils = trim($_POST['outils_libelle_document_fichier'][$i]);

                                     $tmpCvFilePath = $_FILES['detail_outils_fichier']['tmp_name'][$i];

                                     $type_file_espace = $_FILES['detail_outils_fichier']['type'][$i];


                                     
                                     if ($tmpCvFilePath  != ""){

                                        $dirfilesoutils =  $idoplastinsertoutils."_ESMC_FILES_".$op_code_membre_projet.'.pdf';

                                        $srcfileoutils = "../../fichiersweb/pdfopoutils/$dirfilesoutils";
                                        
                                        if (move_uploaded_file($tmpCvFilePath, $srcfileoutils)){

                                             $arrayfileopoutils = array(

                                                 'name_outils' => $nomdocumentoutils,

                                                 'file_outils' => $dirfilesoutils,

                                                 'id_op_outils' => $idoplastinsertoutils
                                             );

                                             $opdetailoutils->insert($arrayfileopoutils);

                                        }

                                     }

                               }

                            }
                        }

                }

            }

            if ($op_materiel == 1){

                $ref_materiel_op = substr(md5(uniqid(rand(), true)), 0, 6);

                $real_ref_materiel_op = strtoupper('OP-MAT-'.$ref_materiel_op);

                $montanttotalmaterielop = 0;


                $dbtinsertmateriel = "INSERT INTO eu_op_materiel(reference_op_materiel, id_vente_op) VALUES (

                                              '$real_ref_materiel_op', '$idlastinsertvop')";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                if ($db->query($dbtinsertmateriel)){

                     $dblastinsertmat = "SELECT * FROM eu_op_materiel WHERE eu_op_materiel.reference_op_materiel = '$real_ref_materiel_op'";

                     $db->setFetchMode(Zend_Db::FETCH_OBJ);

                     $stmtlastinsertmat = $db->query($dblastinsertmat);

                     $dbsearchlastinsertmat = $stmtlastinsertmat->fetchAll();

                if (count($dbsearchlastinsertmat) != 0){

                    $idoplastinsertmateriel = $dbsearchlastinsertmat[0]->id_op_materiel;

                    $tmpCvFilePathMaterielProforma = $_FILES['materiel_file']['tmp_name'];

                    $type_file_espace = $_FILES['materiel_file']['type'];
    
                    if ($tmpCvFilePathMaterielProforma != "") {
    
    
                        $dirfilesmateriel =  $idoplastinsertmateriel."_ESMC_FILES_".$op_code_membre_projet.'.pdf';
    
                        $srcfilemateriel = "../../fichiersweb/pdfopmateriel/$dirfilesmateriel";
                        
                        if (move_uploaded_file($tmpCvFilePathMaterielProforma, $srcfilemateriel)){

                            $dbfupdatemateriel = "UPDATE eu_op_materiel 
                            
                                                  SET eu_op_materiel.file_op_materiel = '$dirfilesmateriel' 
                                                  
                                                  WHERE eu_op_materiel.id_op_materiel = '$idoplastinsertmateriel'";
                            
                            $db->setFetchMode(Zend_Db::FETCH_OBJ);

                            $db->query($dbfupdatemateriel);
                                
                        }
                    }

                    for ($i = 0; $i< count($_POST['op_libelle_materiel_realisation']); $i++){

                        $op_libelle_materiel = trim(addslashes($_POST['op_libelle_materiel_realisation'][$i]));

                        $op_quantite_dispo_materiel = trim(addslashes($_POST['op_quantite_materiel_realisation'][$i]));

                        $op_prix_materiel_realisation = trim(addslashes($_POST['op_prix_materiel_realisation'][$i]));

                        $opmontanttotalprojet = $opmontanttotalprojet + $op_prix_materiel_realisation;

                        $montanttotalmaterielop = $montanttotalmaterielop + $op_prix_materiel_realisation;

                        $dbtinsertmateriel = "INSERT INTO eu_op_details_materiels(libelle_materiel_disponible, quantite_materiel_disponible, prix_materiel_disponible, id_op_materiel) VALUES (
                                              
                                              '$op_libelle_materiel',

                                              '$op_quantite_dispo_materiel',

                                              '$op_prix_materiel_realisation',

                                              '$idoplastinsertmateriel')";

                        $db->setFetchMode(Zend_Db::FETCH_OBJ);

                        $db->query($dbtinsertmateriel);

                    }

                    $opmateriel->update(array('montant_total_op_materiel'=>$montanttotalmaterielop), array('id_op_materiel = ?'=>$idoplastinsertmateriel));

                  }

                }
                   
            }


            if ($op_rh == 1){

                $ref_rh_op = substr(md5(uniqid(rand(), true)), 0, 6);

                $real_ref_rh_op = strtoupper('OP-RH-'.$ref_rh_op);

                $op_rh_total_employe = trim(addslashes($_POST['op_rh_total_employe']));

                $op_rh_montant_vente = $_POST['op_rh_montant_vente'];

                $opmontanttotalprojet = $opmontanttotalprojet + $op_rh_montant_vente;


                $dbtinsertoprh = "INSERT INTO eu_op_rh(reference_op_rh, montant_op_rh, nbre_total_employe, id_vente_op) VALUES (

                                              '$real_ref_rh_op',

                                              '$op_rh_montant_vente',

                                              '$op_rh_total_employe',
                                              
                                              '$idlastinsertvop')";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                if ($db->query($dbtinsertoprh)){

                $dblastinsertrh = "SELECT * FROM eu_op_rh WHERE eu_op_rh.reference_op_rh = '$real_ref_rh_op'";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $smtsearchlastinsertrh = $db->query($dblastinsertrh);

                $searchlastinsertrh =  $smtsearchlastinsertrh->fetchAll();


                if (count($searchlastinsertrh) != 0){

                    $idoplastinsertrh = $searchlastinsertrh[0]->id_op_rh;

                    for ($i = 0; $i< count($_POST['op_libelle_post']); $i++){

                         $libelle_post_rh = trim(addslashes($_POST['op_libelle_post'][$i]));

                         $description_post_rh = trim(addslashes($_POST['op_responsabilite_post'][$i]));

                         $op_salaire_dispo = trim(addslashes($_POST['op_salaire_dispo'][$i]));

                         $dbtinsertoprh = "INSERT INTO eu_op_details_rh(libelle_poste, responsabilite_poste, salaire_op_details_rh, id_op_rh) VALUES (

                                              '$libelle_post_rh',

                                              '$description_post_rh',

                                              '$op_salaire_dispo',

                                              '$idoplastinsertrh')";

                         $db->setFetchMode(Zend_Db::FETCH_OBJ);

                         $db->query($dbtinsertoprh);
                    }

                }

              }

            }


            if ($venteop->update(array('montant_total'=>$opmontanttotalprojet), array('id_vente_op = ?'=>$idlastinsertvop))){

                 $this->_redirect("/offreursprojets/listdetouslesprojetsavendreparcodemembre");

            }

          } 

        }

    }


    public function listdetouslesprojetsavendreAction () {

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');


        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();
        
        $dbselectop = "SELECT eu_vente_op.libelle_vente_op, 
        
                              eu_vente_op.code_membre_apporteur, 
                              
                              eu_membre.nom_membre, 

                              eu_vente_op.id_vente_op,
                              
                              eu_membre.prenom_membre, 

                              eu_vente_op.date_creation,

                              eu_type_centrales.libelle_type_centrales
        
                       FROM eu_vente_op, eu_membre, eu_type_centrales
                       
                       WHERE eu_membre.code_membre = eu_vente_op.code_membre_apporteur
                       
                       AND eu_vente_op.id_type_centrale = eu_type_centrales.id_type_centrales
                       
                       ORDER BY eu_vente_op.id_vente_op DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectop = $db->query($dbselectop);

        $dblistedesop = $stmtselectop->fetchAll();

        $countlisteop = count($dblistedesop);

        $this->view->listedesop = $dblistedesop;

        $this->view->countlistedesop = $countlisteop;

        $this->view->tabletri = 1; 

    }

    public function listdetouslesprojetsavendreparcodemembreAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $sessionmembre = new Zend_Session_Namespace('membre');	
        
        $code_membre_op = $sessionmembre->code_membre;

        $dbselectopbycodemembre = "SELECT eu_vente_op.libelle_vente_op, 
        
                                          eu_vente_op.code_membre_apporteur, 
                              
                                          eu_membre.nom_membre, 

                                          eu_vente_op.id_vente_op,
                              
                                          eu_membre.prenom_membre, 

                                          eu_vente_op.date_creation,

                                          eu_type_centrales.libelle_type_centrales
        
                                   FROM eu_vente_op, eu_membre, eu_type_centrales 
                                   
                                   WHERE  eu_membre.code_membre = eu_vente_op.code_membre_apporteur

                                   AND eu_vente_op.code_membre_apporteur = '$code_membre_op'
                       
                                   AND eu_vente_op.id_type_centrale = eu_type_centrales.id_type_centrales
                                   
                                   ORDER BY eu_vente_op.id_vente_op DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectopbycodemembre = $db->query($dbselectopbycodemembre);

        $dblistedesopbycodemembre = $stmtselectopbycodemembre->fetchAll();

        $countlisteopbycodemembre = count($dblistedesopbycodemembre);

        $this->view->listedesopbycodemembre = $dblistedesopbycodemembre;

        $this->view->countlistedesopbycodemembre = $countlisteopbycodemembre;

        $this->view->tabletri = 1; 

    }

    public function listedesaspectsbyagentsvalidationopAction () {

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        
    }

    public function listedesaspectsbytypecentraleAction () {

        /***
         * ACTION CONSULTABLE SEULEMENT PAR LES CENTRALES
         * 
         */

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');


        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $typecentrales = (int)$this->_request->getParam('typecentrales');

        $dbselectopbycentrale = "SELECT * 
        
                                   FROM eu_vente_op 
                                   
                                   WHERE eu_vente_op.id_type_centrale = '$typecentrales' 
                                   
                                   ORDER BY eu_vente_op.id_vente_op DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectopbycentrale = $db->query($dbselectopbycentrale);

        $dblistedesopbycentrale = $stmtselectopbycentrale->fetchAll();

        $countlisteopbycentrale = count($dblistedesopbycentrale);

        $this->view->listedesopbycentrale = $dblistedesopbycentrale;

        $this->view->countlistedesopbycentrale = $countlisteopbycentrale;

        $this->view->tabletri = 1; 
    }

    public function voirlesdetailsdesprojetsAction () {

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $idventeop = (int) $this->_request->getParam('idventeop');

        /***DETAIL DE LA VENTE */

        $dbselectopdetailvente= "SELECT * 
        
                                  FROM eu_vente_op, eu_type_centrales
                                  
                                  WHERE eu_vente_op.id_type_centrale = eu_type_centrales.id_type_centrales
                                  
                                  AND eu_vente_op.id_vente_op = '$idventeop'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectopdetailvente = $db->query($dbselectopdetailvente);

        $selectopdetailvente = $stmtselectopdetailvente->fetchAll();

        //DETAIL DE LA VENTE DE L'ASPECT ESPACE


        $dbselectopdetailespace= "SELECT *
        
                                  FROM eu_op_espace, eu_op_file_espace
                                  
                                  WHERE eu_op_espace.id_op_espace = eu_op_file_espace.id_op_espace
                                  
                                  AND eu_op_espace.id_vente_op = '$idventeop'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectopdetailespace = $db->query($dbselectopdetailespace);

        $selectopdetailespace = $stmtselectopdetailespace->fetchAll();


        //DETAIL DE LA VENTE DE L'ASPECT MATERIEL

        $dbselectopdetailmateriel= "SELECT * 
        
                                    FROM eu_op_materiel, eu_op_details_materiels
                                  
                                    WHERE eu_op_materiel.id_op_materiel = eu_op_details_materiels.id_op_materiel
                                  
                                    AND eu_op_materiel.id_vente_op = '$idventeop'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectopdetailmateriel = $db->query($dbselectopdetailmateriel);

        $selectopdetailmateriel = $stmtselectopdetailmateriel->fetchAll();

        //DETAIL DE LA VENTE DE L'ASPECT OUTILS

        $dbselectopdetailoutils= "SELECT * 
        
                                    FROM eu_op_outils, eu_op_details_outils
                                  
                                    WHERE eu_op_outils.id_op_outils = eu_op_details_outils.id_op_outils
                                  
                                    AND eu_op_outils.id_vente_op = '$idventeop'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectopdetailoutils = $db->query($dbselectopdetailoutils);

        $selectopdetailoutils = $stmtselectopdetailoutils->fetchAll();

        //DETAIL DE LA VENTE DE L'ASPECT RESSOURCES HUMAINES

        $dbselectopdetailrh= "SELECT * 
        
                              FROM eu_op_rh, eu_op_details_rh
                                  
                              WHERE eu_op_rh.id_op_rh = eu_op_rh.id_op_rh
                                  
                              AND eu_op_rh.id_vente_op = '$idventeop'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectopdetailrh = $db->query($dbselectopdetailrh);

        $selectopdetailrh = $stmtselectopdetailrh->fetchAll();

        $this->view->selectopdetailvente = $selectopdetailvente;

        $this->view->selectopdetailespace = $selectopdetailespace;

        $this->view->selectopdetailmateriel = $selectopdetailmateriel;

        $this->view->selectopdetailoutils = $selectopdetailoutils;

        $this->view->selectopdetailrh = $selectopdetailrh;
    }

    public function ajouteruneoffretechniqueetfinancier () {

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');


    }


    public function modifierlemontantaspectAction () {

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $opespace = new Application_Model_DbTable_EuOpEspace();

        $venteop = new Application_Model_DbTable_EuVenteOp();

        $opfileespace = new Application_Model_DbTable_EuOpFileEspace();

        $opoutils = new Application_Model_DbTable_EuOpOutils();

        $opdetailoutils = new Application_Model_DbTable_EuOpDetailOutils();

        $opmateriel = new Application_Model_DbTable_EuOpMateriel();

        $opdetailmateriel = new Application_Model_DbTable_EuOpDetailMateriel();

        $rh = new Application_Model_DbTable_EuOpRh();

        $detailrh = new Application_Model_DbTable_EuOpDetailsRh();
        
        $idventeaspectop = (int) $this->_request->getParam('idventeaspectop');

        $typeaspect = (string) $this->_request->getParam('typeaspect');

        $idventeop = (int)$this->_request->getParam('idventeop');

        $this->view->typeaspect = $typeaspect;


        $montantfinal = 0;

        $dbselectmontantfinal = "SELECT eu_op_espace.montant_total_finale
              
                                  FROM eu_vente_op 
                                        
                                  WHERE eu_vente_op.id_vente_op = $idventeop";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectmontantfinal = $db->query($dbselectmontantfinal);

        $selectmontantespace = $stmtselectmontantfinal->fetchAll();

        if ($typeaspect == "espace"){

              $dbselectmontantespace = "SELECT eu_op_espace.montant_op_espace
              
                                        FROM eu_op_espace 
                                        
                                        WHERE eu_op_espace.id_op_espace = $idventeaspectop";

              $db->setFetchMode(Zend_Db::FETCH_OBJ);

              $stmtselectmontantespace = $db->query($dbselectmontantespace);

              $selectmontantespace = $stmtselectmontantespace->fetchAll();
            
              $this->view->montantespace = $selectmontantespace;
              
        }

        if ($typeaspect == "materiels"){

              $dbselectmontantdetailmateriel = "SELECT eu_op_details_materiels.prix_materiel_disponible
              
                                                FROM eu_op_details_materiels 
                                        
                                                WHERE eu_op_details_materiels.id_op_details_materiels = $idventeaspectop";

              $db->setFetchMode(Zend_Db::FETCH_OBJ);

              $stmtselectmontantdetailmateriel = $db->query($dbselectmontantdetailmateriel);

              $selectmontantdetailmateriel = $stmtselectmontantdetailmateriel->fetchAll();
            
              $this->view->montantdetailmateriel = $selectmontantdetailmateriel;
              
        }

        if ($typeaspect == "outils") {

              $dbselectmontantoutils = "SELECT eu_op_outils.montant_op_outils
              
                                                FROM eu_op_outils 
                                        
                                                WHERE eu_op_outils.id_op_outils = $idventeaspectop";

              $db->setFetchMode(Zend_Db::FETCH_OBJ);

              $stmtselectmontantoutils = $db->query($dbselectmontantoutils);

              $selectmontantoutils = $stmtselectmontantoutils->fetchAll();
            
              $this->view->montantoutils = $selectmontantoutils;
        }

        if ($typeaspect == "rh"){

              $dbselectmontantrh = "SELECT eu_op_details_rh.salaire_op_details_rh
              
                                    FROM eu_op_details_rh
                                        
                                    WHERE eu_op_details_rh.id_op_details_rh = $idventeaspectop";

              $db->setFetchMode(Zend_Db::FETCH_OBJ);

              $stmtselectmontantrh = $db->query($dbselectmontantrh);

              $selectmontantrh = $stmtselectmontantrh->fetchAll();
            
              $this->view->montantrh = $selectmontantrh;
        }

        if ($request->isPost()){

            $newmontantventeaspect = $_POST['op_montant_projet'];

            if ($typeaspect == "espace"){

                $opespace->update(array('montant_espace_finale' => $newmontantventeaspect), array('id_op_espace = ?'=>$idventeaspectop));

                

                $this->_redirect("/offreursprojets/voirlesdetailsdesprojets/idventeop/$idventeop");

            }
    
    
            if ($typeaspect ==  "materiels"){
    
                $opdetailmateriel->update(array('prix_materiel_final' => $newmontantventeaspect), array('id_op_details_materiels = ?'=>$idventeaspectop));

                $this->_redirect("/offreursprojets/voirlesdetailsdesprojets/idventeop/$idventeop");
    
            }
    
            if ($typeaspect == "outils"){

                $opdetailmateriel->update(array('montant_op_outils' => $newmontantventeaspect), array('id_op_outils = ?'=>$idventeaspectop));

                $this->_redirect("/offreursprojets/voirlesdetailsdesprojets/idventeop/$idventeop");
    
            }
    
            if ($typeaspect == "rh"){
    
                $opdetailmateriel->update(array('salaire_op_details_rh' => $newmontantventeaspect), array('id_op_details_rh = ?'=>$idventeaspectop));

                $this->_redirect("/offreursprojets/voirlesdetailsdesprojets/idventeop/$idventeop");

            }
        }
    }


    public function confirmationexactitudeaspectAction () {

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        $this->_helper->layout->disableLayout();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $request = $this->getRequest();

        $resultjson = array();
        
        $id_opaspect= $_POST['id_aspect'];

        $typeaspect = $_POST['type_aspect'];

        $opespace = new Application_Model_DbTable_EuOpEspace();

        $venteop = new Application_Model_DbTable_EuVenteOp();

        $opfileespace = new Application_Model_DbTable_EuOpFileEspace();

        $opoutils = new Application_Model_DbTable_EuOpOutils();

        $opdetailoutils = new Application_Model_DbTable_EuOpDetailOutils();

        $opmateriel = new Application_Model_DbTable_EuOpMateriel();

        $opdetailmateriel = new Application_Model_DbTable_EuOpDetailMateriel();

        $rh = new Application_Model_DbTable_EuOpRh();

        $detailrh = new Application_Model_DbTable_EuOpDetailsRh();

        if ($typeaspect == "espace") {

            if ($opespace->update(array('exactitude_op_espace' => 1), array('id_op_espace = ?'=>$id_opaspect))){

                $resultjson[] = array(
                    'result'=>'La confirmation pour l\'exactitude de l\'aspect espace à été effectué avec succès'
               );

            }

        }

        if ($typeaspect == "materiel") {

            if ($opdetailmateriel->update(array('exactitude_details_materiel' => 1), array('id_op_details_materiels = ?'=>$id_opaspect))){

                $resultjson[] = array(

                    'result'=>'La confirmation pour l\'exactitude de l\'aspect matériel à été effectué avec succès'
               );
            }
        }


        if ($typeaspect == "outils") {

            if ($opoutils->update(array('exactitude_op_outils' => 1), array('id_op_outils = ?'=>$id_opaspect))) {

                $resultjson[] = array(
                    
                    'result'=>'La confirmation pour l\'exactitude de l\'aspect outils à été effectué avec succès'

               );
            }

        }


        if ($typeaspect == "rh"){

            if ($detailrh->update(array('salaire_op_details_rh' => 1), array('id_op_details_rh = ?'=>$id_opaspect))) {

                $resultjson[] = array(
                    'result'=>'La confirmation pour l\'exactitude de l\'aspect outils à été effectué avec succès'
               );
            }

        }

        header('Content-type:application/json');

        die(json_encode($resultjson));

    }


    public function validationaspecttoagentvalidationAction () {

        $this->_helper->layout->disableLayout();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $request = $this->getRequest();

        $resultjson = array();
        
        $idopprojetvente = $_POST['idopprojetvente'];

        $venteop = new Application_Model_DbTable_EuVenteOp();

        if ($venteop->update(array('valid_op' => 1), array('id_vente_op = ?' => $idopprojetvente))){

            $resultjson = array(

                'result'=>'Le projet est envoyé avec succès à l\'agent validation'
            );

        }


        header('Content-type:application/json');

        die(json_encode($resultjson));
    }


    public function validationaspecttoprocedureachatAction () {

        $this->_helper->layout->disableLayout();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $request = $this->getRequest();

        $resultjson = array();
        
        $idopprojetvente = $_POST['idopprojetvente'];

        $venteop = new Application_Model_DbTable_EuVenteOp();

        $dbselectinfoventeop = "SELECT eu_vente_op.reference_op
              
                                FROM eu_vente_op
                                        
                                WHERE eu_vente_op.id_vente_op = $idopprojetvente";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectinfoventeop = $db->query($dbselectinfoventeop);

        $selectinfoventeop = $stmtselectinfoventeop->fetchAll();

        if ($venteop->update(array('valid_op' => 2), array('id_vente_op = ?' => $idopprojetvente))){

            Util_Utils::sendexternalmailtoop();

            $resultjson = array(

                'result'=>'Le projet est envoyé avec succès à l\'agent achat'
                
            );

        }

        header('Content-type:application/json');

        die(json_encode($resultjson));
    }

}