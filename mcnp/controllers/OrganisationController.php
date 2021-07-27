<?php

class OrganisationController extends Zend_Controller_Action {

    public function init () {

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

        if(!isset($sessionutilisateur->login)) { $this->_redirect('/administration/login');}

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    }

    public function indexAction() {
        
    }
/**
 * Gestion des roles
 */

    public function addcentreAction () {

        /**Cette function permet d'ajouter un centre cantonale */

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $created = Zend_Date::now();

        $date_created_centre = $created->toString('yyyy-MM-dd HH:mm:ss');

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $responsabilite_centre = $_SESSION['utilisateur']['responsabilite_centres'];

        if ($responsabilite_centre == 1){

            $id_centres = $_SESSION['utilisateur']['id_centres'];

        }

        $validationerrors = array();

        $idtypecentre = (int)$this->_request->getParam('typecentres');

        $dbcentre = new Application_Model_DbTable_EuCentres();

        $dbutilisateur = new Application_Model_DbTable_EuUtilisateur();

        $dbaffectionrolesutilisateur = new Application_Model_DbTable_EuUserrolespermissions();

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

        $this->view->idtypecentre = $idtypecentre;


        if ($idtypecentre == 1){

            $this->view->zones = $zones;

        }

        if ($idtypecentre == 2){

            $this->view->zones = $zones;

            $this->view->pays = $pays;

        }

        if ($idtypecentre == 3){

            $this->view->zones = $zones;

            $this->view->pays = $pays;

            $this->view->regions = $regions;
        }

        if ($idtypecentre == 4){

            $this->view->zones = $zones;

            $this->view->pays = $pays;

            $this->view->regions = $regions;

            $this->view->prefectures = $prefectures;
        }

        if ($idtypecentre == 5){

            $this->view->zones = $zones;

            $this->view->pays = $pays;

            $this->view->regions = $regions;

            $this->view->prefectures = $prefectures;

            $this->view->cantons = $cantons;
            
        }
    

        if ($request->isPost()) {

            $ref_centre = substr(md5(uniqid(rand(), true)), 0, 8);

            $real_ref_centre = strtoupper('CENT-'.$ref_centre);

            $real_ref_user_role = strtoupper('ORG-'.$ref_centre);

            $libelle_centre = trim(htmlspecialchars($_POST['organisateur_centre_nom']));

            $codemembremoralecentre = "0000000000000000003M";
    
            $surface_centre = trim(htmlspecialchars($_POST['organisateur_centre_surface']));
    
            $addresse_centre = trim(htmlspecialchars($_POST['organisateur_centre_address']));
    
            $description_centre = trim(htmlspecialchars($_POST['organisateur_centre_description']));
    
            $telephone_centre = trim(htmlspecialchars($_POST['organisateur_centre_phone']));

            $input_organisation_type_centre = $_POST['input_organisation_type_centre'];
    
            $bp_centre = trim(htmlspecialchars($_POST['organisateur_centre_bp']));  
            
            $code_membre = trim(htmlspecialchars($_POST['responsable_code_membre']));

            $login = trim(htmlspecialchars($_POST['responsable_membre_login']));

            $password = trim(md5(htmlspecialchars($_POST['responsable_membre_password'])));

            $passwordhash = password_hash(htmlspecialchars($_POST['responsable_membre_password']), PASSWORD_BCRYPT);

            $confirmation_password = trim(md5(htmlspecialchars($_POST['responsable_membre_confirmpassword'])));


            if($login == "" || empty($login)){

                $validationerrors['errors_empty_login'] = "Vous devez rendez renseigné le login";
            }

            if($password == "" || empty($password)){

                $validationerrors['errors_empty_password'] = "Vous devez rendez renseigné le mot de passe";
            }

            
            if($confirmation_password == "" || empty($confirmation_password)){

                $validationerrors['errors_empty_confirmpassword'] = "Vous devez confirmé le mot de passe";
            }

            if ($password != $confirmation_password){

                $validationerrors['errors_password_conform'] = "Votre mot de passe n'est pas correctement confirmé";
            }

           /***Utiliser dans la requête OR */

            $dbselect = "SELECT * 

                         FROM eu_centres 

                         WHERE eu_centres.libelle_centre ='$libelle_centre'

                         AND eu_centres.surface_centre='$surface_centre'

                         AND eu_centres.addresse_centre = '$addresse_centre'

                         AND eu_centres.telephone_centre = '$telephone_centre'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmt = $db->query($dbselect);

            $dbverifdoublonone = $stmt->fetchAll();

            if (count($dbverifdoublonone) != 0){

                $validationerrors['error_doublons'] = "Error 403: Cet centre a déja été enrégistré";

            }

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){

                if (isset($idtypecentre)){



                if ($idtypecentre == 1){

                    $zone = htmlspecialchars($_POST['code_zone']);

                    $type_centre = "zone monetaire";

                    $code_membre_morale_centre = "0000000000000000001M";

                    $querytabs = array(

                        'reference_centre'=>$real_ref_centre,
   
                        'libelle_centre'=>$libelle_centre,
   
                        'surface_centre'=>$surface_centre,
   
                        'code_membre_morale'=>$codemembremoralecentre,
   
                        'addresse_centre'=>$addresse_centre,

                        'description_centre'=>$description_centre,
   
                        'date_centres'=>$date_created_centre,
   
                        'id_utilisateur'=>$id_utilisateur,
   
                        'type_centre'=>$type_centre, 
   
                        'telephone_centre'=>$telephone_centre,
   
                        'bp_centre'=>$bp_centre,
   
                        'code_zone'=>$zone
                    );

                }

                if ($idtypecentre == 2){

                    $zone = htmlspecialchars($_POST['code_zone']);
            
                    $pays = htmlspecialchars($_POST['id_pays']);

                    $type_centre = "national";

                    $codemembremoralecentre = "0000000000000000002M";


                    $querytabs = array(

                        'reference_centre'=>$real_ref_centre,
   
                        'libelle_centre'=>$libelle_centre,
   
                        'surface_centre'=>$surface_centre,
   
                        'code_membre_morale'=>$codemembremoralecentre,

                        'id_centres_parent'=>$id_centres,

                        'description_centre'=>$description_centre,
   
                        'addresse_centre'=>$addresse_centre,
   
                        'date_centres'=>$date_created_centre,
   
                        'id_utilisateur'=>$id_utilisateur,
   
                        'type_centre'=>$type_centre, 
   
                        'telephone_centre'=>$telephone_centre,
   
                        'bp_centre'=>$bp_centre,
   
                        'code_zone'=>$zone,

                        'id_pays'=>$pays
                    
                      );

                    }
            
                    if ($idtypecentre == 3){
        
            
                        $zone = htmlspecialchars($_POST['code_zone']);
            
                        $pays = htmlspecialchars($_POST['id_pays']);
            
                        $region = htmlspecialchars($_POST['id_region']);

                        $type_centre = "regional";

                        $codemembremoralecentre = "0000000000000000003M";
            
                        $querytabs = array(

                            'reference_centre'=>$real_ref_centre,
   
                            'libelle_centre'=>$libelle_centre,
       
                            'surface_centre'=>$surface_centre,
       
                            'code_membre_morale'=>$codemembremoralecentre,

                            'id_centres_parent'=>$id_centres,

                            'description_centre'=>$description_centre,
                            
                            'addresse_centre'=>$addresse_centre,
       
                            'date_centres'=>$date_created_centre,
       
                            'id_utilisateur'=>$id_utilisateur,
       
                            'type_centre'=>$type_centre, 
       
                            'telephone_centre'=>$telephone_centre,
       
                            'bp_centre'=>$bp_centre,
            
                            'code_zone'=>$zone,
                            
                            'id_pays'=>$pays,
            
                            'id_region'=>$region
                        );
                    }
            
                    if ($idtypecentre == 4){
            
                        $zone = htmlspecialchars($_POST['code_zone']);
            
                        $pays = htmlspecialchars($_POST['id_pays']);
            
                        $region = htmlspecialchars($_POST['id_region']);
            
                        $prefecture = htmlspecialchars($_POST['id_prefecture']);

                        $type_centre = "prefectoral";

                        $codemembremoralecentre = "0000000000000000004M";

                        $querytabs = array(

                            'reference_centre'=>$real_ref_centre,
   
                            'libelle_centre'=>$libelle_centre,
       
                            'surface_centre'=>$surface_centre,
       
                            'code_membre_morale'=>$codemembremoralecentre,

                            'description_centre'=>$description_centre,

                            'id_centres_parent'=>$id_centres,
       
                            'addresse_centre'=>$addresse_centre,
       
                            'date_centres'=>$date_created_centre,
       
                            'id_utilisateur'=>$id_utilisateur,
       
                            'type_centre'=>$type_centre, 
       
                            'telephone_centre'=>$telephone_centre,
       
                            'bp_centre'=>$bp_centre,
            
                            'code_zone'=>$zone,
                            
                            'id_pays'=>$pays,
            
                            'id_region'=>$region,

                            'id_prefecture'=>$prefecture
                        );
            
                    }
            
                    if ($idtypecentre == 5){
                        
                        $zone = htmlspecialchars($_POST['code_zone']);

                        $pays = htmlspecialchars($_POST['id_pays']);

                        $prefecture = htmlspecialchars($_POST['id_prefecture']);

                        $region = htmlspecialchars($_POST['id_region']);

                        $canton = htmlspecialchars($_POST['id_canton']);

                        $type_centre = "cantonal";

                        $codemembremoralecentre = "0000000000000000005M";


                        $querytabs = array(

                            'reference_centre'=>$real_ref_centre,
   
                            'libelle_centre'=>$libelle_centre,
       
                            'surface_centre'=>$surface_centre,
       
                            'code_membre_morale'=>$codemembremoralecentre,

                            'description_centre'=>$description_centre,

                            'id_centres_parent'=>$id_centres,
       
                            'addresse_centre'=>$addresse_centre,
       
                            'date_centres'=>$date_created_centre,
       
                            'id_utilisateur'=>$id_utilisateur,
       
                            'type_centre'=>$type_centre, 
       
                            'telephone_centre'=>$telephone_centre,
       
                            'bp_centre'=>$bp_centre,
            
                            'code_zone'=>$zone,
                            
                            'id_pays'=>$pays,
            
                            'id_region'=>$region,

                            'id_prefecture'=>$prefecture,

                            'id_canton'=>$canton 
                        );
                        
                    }

                }
                                    

                    if ($dbcentre->insert($querytabs)){

                         $dbselect = "SELECT * 

                                      FROM eu_centres 

                                      WHERE eu_centres.reference_centre ='$real_ref_centre'";

                         $db->setFetchMode(Zend_Db::FETCH_OBJ);

                         $stmt = $db->query($dbselect);

                         $dbgetidcentre = $stmt->fetchAll();  

                         if (count($dbgetidcentre) > 0){

                             $id_real_cent = $dbgetidcentre[0]->id_centres;

                             $queryusertabs = array(

                                'login'=>$login,

                                'pwd'=>$password,

                                'password_hash'=>$passwordhash,

                                'code_membre'=>$code_membre,

                                'reference_user_role'=>$real_ref_user_role,

                                'responsabilite_centres'=>1,

                                'id_centres'=>$id_real_cent
                             );

                                $dbverifcreationutilisateur = "SELECT * 

                                                               FROM eu_utilisateur

                                                               WHERE eu_utilisateur.code_membre = '$code_membre'
                                              
                                                               AND eu_utilisateur.reference_user_role ='$real_ref_user_role'";

                                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                                $stmtverifcreationutilisateur = $db->query($dbverifcreationutilisateur);

                                $verifcreationutilisateur = $stmtverifcreationutilisateur->fetchAll();  

                                if (count($dbfetchgetidutilisateur) != 0){

                                    $verifidutilisateur = $verifcreationutilisateur[0]->id_utilisateur;

                                    $dbdeuxiemeverificationuser = "SELECT * 
                                    
                                                                   FROM eu_user_roles_permissions
                                                                   
                                                                   WHERE eu_user_roles_permissions.id_utilisateur = $verifidutilisateur
                                                                   
                                                                   AND eu_user_roles_permissions.id_roles = 2";
                                 
                                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                                    $stmtdeuxiemeverificationuser = $db->query($dbdeuxiemeverificationuser);

                                    $deuxiemeverificationuser = $stmtdeuxiemeverificationuser->fetchAll();  

                                    if (count($deuxiemeverificationuser) != 0)
                                    {

                                        $dbupdateusercentre = "UPDATE eu_utilisateur 
                                        
                                                               SET eu_utilisateur.id_centres = $id_real_cent,

                                                                   eu_utilisateur.responsabilite_centres = 1 
                                                      
                                                               WHERE eu_utilisateur.id_utilisateur = $verifidutilisateur";

                                        $db->setFetchMode(Zend_Db::FETCH_OBJ);
                    
                                        if ($db->query($dbupdateusercentre)){

                                                $dbupdateusercentre = "UPDATE eu_utilisateur 
                                        
                                                                       SET eu_utilisateur.id_centres = $id_real_cent 
                                                      
                                                                       WHERE eu_utilisateur.id_utilisateur = $verifidutilisateur";

                                                $db->setFetchMode(Zend_Db::FETCH_OBJ);
                                        }

                                    }
                                }


                             if ($dbutilisateur->insert($queryusertabs)){

                                 $dbselect = "SELECT * 

                                              FROM eu_utilisateur 

                                              WHERE eu_utilisateur.reference_user_role ='$real_ref_user_role'";

                                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                                 $stmt = $db->query($dbselect);

                                 $dbfetchgetidutilisateur = $stmt->fetchAll();  

                                 if (count($dbfetchgetidutilisateur) == 0){
     
                                       $this->_redirect("/organisation/listedetouslescentres");                    


                                 }

                                 if (count($dbfetchgetidutilisateur) > 0){

                                    /*
                                       $id_res_cent_utilisateur = $dbfetchgetidutilisateur[0]->id_utilisateur;

                                       $query_user_roles = array(

                                           'id_roles'=>2,

                                           'id_utilisateur'=>$id_res_cent_utilisateur,

                                           'responsabilite'=>1,

                                           'code_responsabilite'=>'PDG',

                                           'libelle_responsabilite'=>'President Directeur General',

                                           'date_affectation_roles'=>$date_created_centre
                                       );

                                       $dbaffectionrolesutilisateur->insert($query_user_roles);*/



                                       $this->_redirect("/organisation/listedetouslescentres");                    
                                       
                                 }
                             }
                         }

                }
            
            }

        }

    }
    

    public function addcentreprefectoraleAction () {

    }

    public function addagenceAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();


        $dbagence = new Application_Model_DbTable_EuAgences();

        $dbutilisateur = new Application_Model_DbTable_EuUtilisateur();

        $t_secteur = new Application_Model_DbTable_EuSecteur();

        $dbcentre = new Application_Model_DbTable_EuCentres();

        $dbaffectionrolesutilisateur = new Application_Model_DbTable_EuUserrolespermissions();

        $t_zone = new Application_Model_DbTable_EuZone();


        $t_canton = new Application_Model_DbTable_EuCanton();

        $t_secteur = new Application_Model_DbTable_EuSecteur();

        $created = Zend_Date::now();


        $cantons = $t_canton->fetchAll();

        $secteur = $t_secteur->fetchAll();


        $this->view->cantons = $cantons;

        $this->view->secteur = $secteur;



        $date_created_agence = $created->toString('yyyy-MM-dd HH:mm:ss');

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $id_centres = $_SESSION['utilisateur']['id_centres'];

        if ($id_centres == NULL) {

            $this->_redirect("/administration");

        }

        $dbrecuperationmembremorale = "SELECT eu_centres.code_membre_morale, 
        
                                              eu_centres.id_pays, 
                                              
                                              eu_centres.id_region, 
                                              
                                              eu_centres.id_prefecture, 
                                              
                                              eu_centres.id_canton 

                                       FROM eu_centres 

                                       WHERE eu_centres.id_centres = $id_centres";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $smtrecuperationmembremorale = $db->query($dbrecuperationmembremorale);

        $queryrecuperationmembremorale = $smtrecuperationmembremorale->fetchAll();


        $codemembremorale = $queryrecuperationmembremorale[0]->code_membre_morale;

        $dbverificationdelavaliditeacces = "SELECT eu_utilisateur.id_centres 

                                            FROM eu_utilisateur 

                                            WHERE eu_utilisateur.responsabilite_centres = 1 

                                            AND eu_utilisateur.id_utilisateur = $id_utilisateur 

                                            AND eu_utilisateur.id_centres IS NOT NULL";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $smtverificationdelavaliditeacces = $db->query($dbverificationdelavaliditeacces);

        $queryverificationdelavaliditeacces = $smtverificationdelavaliditeacces->fetchAll();


        $dbverifuseraccesspermission = "SELECT eu_user_roles_permissions.id_user_roles_permissions 

                                        FROM eu_user_roles_permissions

                                        WHERE eu_user_roles_permissions.id_roles = 2 

                                        AND eu_user_roles_permissions.responsabilite = 1
                                        
                                        AND eu_user_roles_permissions.id_utilisateur = $id_utilisateur";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $smtverifuseraccesspermission = $db->query($dbverifuseraccesspermission);

        $queryverifuseraccesspermission = $smtverifuseraccesspermission->fetchAll();



//Seul le responsable du conseil d'administration et le responsable de centre ont le droit de créer les agences odd liées à leurs centres
//Ils peuvent en créer que 17 aucun autre


        if (count($queryverificationdelavaliditeacces) == 0 && count($queryverifuseraccesspermission) == 0){

            $this->_redirect("/administration");
           
        }


        if (count($queryverificationdelavaliditeacces) != 0) {

            $idcentres = $queryverificationdelavaliditeacces[0]->id_centres;

        }

        if (count($queryverificationdelavaliditeacces) != 0 || count($queryverifuseraccesspermission) != 0) {
        


        /**Liste des 17 ODD */
        $dbselect = "SELECT eu_odd.id_odd, eu_odd.titre 
        
                     FROM eu_odd
                     
                     WHERE eu_odd.valid = 1";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedesodd = $stmt->fetchAll();

        $this->view->listedesodd = $dblistedesodd;



        if ($request->isPost()) {

            $ref_agence = substr(md5(uniqid(rand(), true)), 0, 8);

            $real_ref_agence = strtoupper('AGENCES-'.$ref_agence); 
            
            $libelle_agence = htmlspecialchars(addslashes($_POST['organisation_agence_libelle']));

            $id_odd = htmlspecialchars($_POST['organisation_agence_odd']);

            $organisation_agence_phone = htmlspecialchars($_POST['organisation_agence_phone']);

            $organisation_agence_bp = htmlspecialchars($_POST['organisation_agence_bp']);    
            
            $organisation_agence_address = trim(addslashes(htmlspecialchars($_POST['organisation_agence_address'])));

            $code_membre_morale_agence = $codemembremorale;

            $login_responsable_agences = addslashes(htmlspecialchars($_POST['responsable_membre_login_agence']));

            $password_responsable_agences = md5(addslashes(htmlspecialchars($_POST['responsable_membre_password_agence'])));

            $password_responsable_agences_hash = password_hash(addslashes(htmlspecialchars($_POST['responsable_membre_password_agence'])), PASSWORD_BCRYPT);

            $confirmation_password_responsable_agences = md5(addslashes(htmlspecialchars($_POST['responsable_membre_password_agence'])));

            $code_membre_responsable_agences = htmlspecialchars($_POST['responsable_code_membre_agence']);

            $ref_user_responsable_agence = substr(md5(uniqid(rand(), true)), 0, 8);

            $real_ref_user_responsable_agence  = strtoupper('ORG-'.$ref_user_responsable_agence );

            $id_cantonodd = $_POST['id_canton'];

            $code_secteur = $_POST['code_secteur'];

            $code_agence = "000";

            $dblastinsertidagencesodd = "SELECT eu_agences_odd.code_agences_odd 
            
                                         FROM eu_agences_odd 
                             
                                         ORDER BY eu_agences_odd.id_agences_odd DESC 
                             
                                         LIMIT 1 ";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtlastinsertidagencesodd = $db->query($dblastinsertidagencesodd);

            $lastinsertidagencesodd = $stmtlastinsertidagencesodd->fetchAll(); 

            $lastcodeagenceodd = $lastinsertidagencesodd[0]->code_agences_odd;
 

            if ($lastcodeagenceodd == null) {

                $code_agence = $code_secteur . '001';

             } else {

                $num_ordre = substr($lastcodeagenceodd, -3);

                $num_ordre++;

                $code_agence = $code_secteur . str_pad($num_ordre, 3, 0, STR_PAD_LEFT);

             }

            $dbrecupnomandprenomsagence = "SELECT eu_membre.nom_membre, eu_membre.prenom_membre 
            
                                           FROM eu_membre 
        
                                           WHERE eu_membre.code_membre = '$code_membre_responsable_agences'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtrecupnomandprenomsagence = $db->query($dbrecupnomandprenomsagence);

            $nomandprenomsagence = $stmtrecupnomandprenomsagence->fetchAll(); 

            if( count($nomandprenomsagence) == 0){

                $validationsuccess['error_size_code_membre'] = "Le code membre que vous avez saisit est incorrect";

            }

            if (count($dbgetnomandprenoms) != 0) {

                 $nom_responsable = $nomandprenomsagence[0]->nom_membre;

                 $prenoms_responsable = $nomandprenomsagence[0]->prenom_membre;           

            }

            if($login_responsable_agences == "" || empty($login_responsable_agences)){

                $validationerrors['errors_empty_login'] = "Vous devez rendez renseigné le login";
            }

            if($password_responsable_agences == "" || empty($password_responsable_agences)){

                $validationerrors['errors_empty_password'] = "Vous devez rendez renseigné le mot de passe";

            }
            
            if($confirmation_password_responsable_agences == "" || empty($confirmation_password_responsable_agences)){

                $validationerrors['errors_empty_confirmpassword'] = "Vous devez confirmé le mot de passe";
            }

            if ($password_responsable_agences != $confirmation_password_responsable_agences){

                $validationerrors['errors_password_conform'] = "Votre mot de passe n'est pas correctement confirmé";
            }

            $dbselectdoublonagence = "SELECT * 

                                      FROM eu_agences_odd

                                      WHERE eu_agences_odd.id_odd ='$id_odd'

                                      AND eu_agences_odd.id_centres='$idcentres'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtselectdoublonagence = $db->query($dbselectdoublonagence);

            $dbverifdoublonone = $stmtselectdoublonagence->fetchAll();

            $dbnombreagencesbycentre = "SELECT * 

                                        FROM eu_agences_odd

                                        WHERE eu_agences_odd.id_centres='$idcentres'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtnombreagencesbycentre = $db->query($dbnombreagencesbycentre);

            $nombreagencesbycentre = $stmtnombreagencesbycentre->fetchAll();

            if (count($dbverifdoublonone) != 0){

                $validationerrors['error_doublons'] = "Error 403: Cet agence a déja été enrégistré";

            }

            if (count($nombreagencesbycentre) == 17){

                $validationerrors['error_number_agencesodd'] = "Error 403: Il ne peut avoir que 17 agences odd dans votre centre";

            }

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){

            
                 $dbtinsert = "INSERT INTO eu_agences_odd(reference_agences_odd,

                                                     code_agences_odd,

                                                     libelle_agences_odd,

                                                     date_agences_odd,

                                                     addresse_agences_odd,

                                                     telephone_agences_odd, 

                                                     bp_agences_odd, 

                                                     code_membre_morale,

                                                     id_utilisateur,

                                                     id_canton,

                                                     id_odd,
                                                     
                                                     id_centres) VALUES (

                                                     '$real_ref_agence',

                                                     '$code_agence',

                                                     '$libelle_agence',

                                                     '$date_created_agence',

                                                     '$organisation_agence_address',

                                                     '$organisation_agence_phone',

                                                     '$organisation_agence_bp',

                                                     '$codemembremorale',

                                                     '$id_utilisateur',

                                                     '$id_cantonodd',

                                                     '$id_odd',

                                                     '$idcentres')";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmt = $db->query($dbtinsert);

            $dbtlastinsert = "SELECT eu_agences_odd.id_agences_odd 
            
                              FROM eu_agences_odd 
                              
                              WHERE eu_agences_odd.reference_agences_odd = '$real_ref_agence'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtlastinsert = $db->query($dbtlastinsert);

            $lastinsertuserverifquery = $stmtlastinsert->fetchAll();

            if (count($lastinsertuserverifquery) > 0 ){

                $id_agences_odd = $lastinsertuserverifquery[0]->id_agences_odd;

                //Chose rare: dans le cas ou le responsable de centre est le même que celui de l'agence, faire un update sur l'id utilisateur du responsable centre au niveau de l'id agence
                /*'code_membre'=>$code_membre_responsable_agences,*/
                $queryusertabs = array(

                    'login'=>$login_responsable_agences,

                    'pwd'=>$password_responsable_agences,

                    'reference_user_role'=>$real_ref_user_responsable_agence,

                    'id_utilisateur_parent'=>$id_utilisateur,

                    'password_hash'=>$password_responsable_agences_hash,

                    'code_membre'=>$code_membre_responsable_agences,

                    'responsabilite_agences_odd'=>1,

                    'id_agences_odd'=>$id_agences_odd,

                    'id_centres'=>$idcentres

                 );

                 $verifuserresponsableagence = "SELECT * 

                                                FROM eu_utilisateur 

                                                WHERE eu_utilisateur.login = '$login_responsable_agences'

                                                AND eu_utilisateur.pwd = '$password_responsable_agences'";

                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                 $stmt = $db->query($verifuserresponsableagence);

                 $userresponsableagenceverif = $stmt->fetchAll();

                 if (count($userresponsableagenceverif) == 0){

                    if ($dbutilisateur->insert($queryusertabs)){

                        $this->_redirect("/organisation/listedetouslesagences");
    
                    }

                 }else{

                     $queryupdateuser = array(
    
                        'responsabilite_agences_odd'=>1,
    
                        'id_agences_odd'=>$id_agences_odd
                     );

                     $dbutilisateur->update($queryupdateuser, array('id_utilisateur = ?'=> $id_utilisateur));

                     $this->_redirect("/organisation/listedetouslesagencesduncentre");

                 }
 
              }
           }
            
         }

      }

    }

    public function addcentralesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $dbutilisateur = new Application_Model_DbTable_EuUtilisateur();

        $request = $this->getRequest();

        $created = Zend_Date::now();

        $selectidagencefromuser = NULL;

        $selectidcentresfromuser = NULL;

        $date_created_centrales = $created->toString('yyyy-MM-dd HH:mm:ss');

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $idagenceodd =  $_SESSION['utilisateur']['id_agences_odd'];

        /***RECUPERER LA LISTE DES TYPES DE CENTRALES DISPONIBLE */

        $dbselecttypecentrale = "SELECT * FROM eu_type_centrales";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmttypecentrale = $db->query( $dbselecttypecentrale);

        $dblistdestypesdecentrales = $stmttypecentrale->fetchAll();

        // Recupérer l'id de l'agence odd à partir de l'id de l'utilisateur responsable connecté de l'agence

        $dbselectidagences = "SELECT eu_utilisateur.id_agences_odd
        
                              FROM eu_utilisateur 
                         
                              WHERE eu_utilisateur.id_utilisateur = $id_utilisateur 
                         
                              AND eu_utilisateur.responsabilite_agences_odd = 1 
                         
                              AND eu_utilisateur.id_agences_odd IS NOT NULL";
        
        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectidagences = $db->query($dbselectidagences);

        $dbselectidagencesoddfromuser = $stmtselectidagences->fetchAll();

        $countagencesodd = count($dbselectidagencesoddfromuser);


        //GET THE ID CENTER FROM THE RESPONSABLE CENTER

        $dbselectidcentre = "SELECT eu_utilisateur.id_centres
        
                              FROM eu_utilisateur 
                         
                              WHERE eu_utilisateur.id_utilisateur = $id_utilisateur 
                         
                              AND eu_utilisateur.responsabilite_centres = 1 
                         
                              AND eu_utilisateur.id_centres IS NOT NULL";
        
        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectidcentre = $db->query($dbselectidcentre);

        $dbselectidcentresoddfromuser = $stmtselectidcentre->fetchAll();

        $countcentre = count($dbselectidcentresoddfromuser);


//Seul le responsable du conseil d'administration et le responsable de centre ont le droit de créer les 4 centrales liées à leurs centres
//Ils peuvent en créer que 17 aucun autre

    /*    if ($countagencesodd == 0 || $countcentre == 0){

            $this->_redirect("/administration");
           
        }*/


        if (count($dbselectidagencesoddfromuser ) != 0) {


            $selectidagencesfromuser = $dbselectidagencesoddfromuser[0]->id_agences_odd;

        }

        if (count($dbselectidcentresoddfromuser ) != 0) {


            $selectidcentresfromuser = $dbselectidcentresoddfromuser[0]->id_centres;

            $dblistedesagencesoddducentre = "SELECT eu_agences_odd.id_agences_odd, eu_agences_odd.libelle_agences_odd
        
                                             FROM eu_agences_odd
                         
                                             WHERE eu_agences_odd.id_centres = $selectidcentresfromuser";
        
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtlistedesagencesoddducentre = $db->query($dblistedesagencesoddducentre);

            $listedesagencesoddducentre = $stmtlistedesagencesoddducentre->fetchAll();

            $this->view->listedesagencesodd = $listedesagencesoddducentre;

        }


        $this->view->listdestypesdecentrales = $dblistdestypesdecentrales;

        $this->view->countcentre = $countcentre;


        if ($request->isPost()) {

            $ref_centrale = substr(md5(uniqid(rand(), true)), 0, 8);

            $real_ref_centrale = strtoupper('CENT-'.$ref_centrale);

            $libelle_centrale = trim(addslashes(htmlspecialchars($_POST['organisateur_libelle_centrale'])));

            $centrale_type_id = htmlspecialchars($_POST['organisation_type_centrale']);

            $responsable_code_membre_centrale = htmlspecialchars($_POST['responsable_code_membre_centrale']);

            $responsable_membre_login_centrale = htmlspecialchars($_POST['responsable_membre_login_centrale']);

            $responsable_membre_password_centrale = md5(htmlspecialchars($_POST['responsable_membre_password_centrale']));

            $responsable_membre_password_centrale_hash = password_hash(htmlspecialchars($_POST['responsable_membre_password_centrale']), PASSWORD_BCRYPT);

            $responsable_membre_confirmpassword_centrale = md5(htmlspecialchars($_POST['responsable_membre_confirmpassword_centrale']));

            if($responsable_membre_login_centrale == "" || empty($responsable_membre_login_centrale)){

                $validationerrors['errors_empty_login'] = "Vous devez renseigner le login";
            }

            if($responsable_membre_password_centrale == "" || empty($responsable_membre_password_centrale)){

                $validationerrors['errors_empty_password'] = "Vous devez renseigner le mot de passe";
            }

            
            if($responsable_membre_confirmpassword_centrale == "" || empty($responsable_membre_confirmpassword_centrale)){

                $validationerrors['errors_empty_confirmpassword'] = "Vous devez confirmer le mot de passe";
            }

            if ($responsable_membre_password_centrale != $responsable_membre_confirmpassword_centrale){

                $validationerrors['errors_password_conform'] = "Votre mot de passe n'est pas correctement confirmé";
            }

            $dbtinsert = "INSERT INTO eu_centrales(reference_centrale,

                                               libelle_centrale,
                                               
                                               id_agence_odd,
                                               
                                               id_type_centrales,
                                               
                                               id_utilisateur, 
                                               
                                               date_creation_centrales) VALUES (

                                              '$real_ref_centrale',

                                              '$libelle_centrale',

                                              '$idagenceodd',

                                              '$centrale_type_id',

                                              '$id_utilisateur',

                                              '$date_created_centrales')";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            if ($db->query($dbtinsert)){

                $dbtselectlastinsert = "SELECT eu_centrales.id_centrales FROM eu_centrales WHERE eu_centrales.reference_centrale = '$real_ref_centrale'";
               
                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtselectlastinsert = $db->query($dbtselectlastinsert);
        
                $dbselectlastinsertcentrale = $stmtselectlastinsert->fetchAll();

                 if (count($dbselectlastinsertcentrale) != 0 ){
                    
                     $selectlastinsertcentrale = $dbselectlastinsertcentrale[0]->id_centrales;


                $queryusertabs = array(

                    'login'=>$responsable_membre_login_centrale,

                    'pwd'=>$responsable_membre_password_centrale,

                    'password_hash'=>$responsable_membre_password_centrale_hash,

                    'code_membre'=>$responsable_code_membre_centrale,

                    'reference_user_role'=>$real_ref_user_responsable_agence,

                    'responsabilite_centrale'=>1,

                    'id_centrales'=>$selectlastinsertcentrale,

                    'id_agences_odd'=>$selectidagencesfromuser,

                    'id_centres'=>$selectidcentresfromuser,

                    'password_hash'=>$passwordhash

                 );

                 $verifuserresponsablecentrales = "SELECT * 

                                                FROM eu_utilisateur 

                                                WHERE eu_utilisateur.login = '$responsable_membre_login_centrale'

                                                AND eu_utilisateur.pwd = '$responsable_membre_password_centrale'";

                 $db->setFetchMode(Zend_Db::FETCH_OBJ);

                 $stmt = $db->query($verifuserresponsablecentrales);

                 $userresponsablecentralesverif = $stmt->fetchAll();

                 if (count($userresponsablecentralesverif) == 0){

                    if ($dbutilisateur->insert($queryusertabs)){

                        $this->_redirect("/organisation/listedetouslescentrales");
    
                    }

                 }else{

                     $queryupdateuser = array(
    
                        'responsabilite_centrale'=>1,
    
                        'id_centrales'=>$selectlastinsertcentrale
                     );

                     $dbutilisateur->update($queryupdateuser, array('id_utilisateur = ?'=> $id_utilisateur));

                     $this->_redirect("/organisation/listedetouslescentrales");                     

                 }
 
              }

            }

        }

    }

    


    public function addroleAction () {

        /** Cette function permet d'ajouter des roles au sein de la grande organisation */

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $created = Zend_Date::now();

        $date_created_roles = $created->toString('yyyy-MM-dd HH:mm:ss');

        $idgroupesroles = (int)$this->_request->getParam('idgroupesroles');



        /***RECUPERER LA LISTE DES GROUPES DE ROLES POUR GROUPER LES ROLES LORS DE LA CREATION DES UTILISATEURS */

        $dbselect = "SELECT * FROM eu_groupe_roles";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistdesgroupesderoles = $stmt->fetchAll();

        /***RECUPERER LA LISTE DES ROLES POUR AFECTER LES ROLES PARENTS AUX ROLES CREER */

        $dbselecttouslesroles = "SELECT * FROM eu_roles WHERE eu_roles.id_groupe_roles = '$idgroupesroles'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmttouslesroles = $db->query($dbselecttouslesroles);

        $dblistdesroles = $stmttouslesroles->fetchAll();

        $dbcountlistdesroles = count($dblistdesroles);

        /**ENVOIE DES LISTES A LA VUE */

        $this->view->listdesgroupesderoles = $dblistdesgroupesderoles;

        $this->view->listdesroles = $dblistdesroles;

        $this->view->countlistdesroles = $dbcountlistdesroles;

        /***AJOUTER UN ROLES */
        if ($request->isPost()) {
        
            
            $code_roles = trim(htmlspecialchars($_POST['organisateur_code_roles']));

            $libelleroles = trim(addslashes($_POST['organisateur_description_roles']));
            
            $groupe_roles = $_POST['roles_groupes'];

            for ($i = 0; $i< count($_POST['roles_parent']); $i++){

                $parent_roles = $_POST['roles_parent'][$i];

                $dbtinsertmultiplesroles = "INSERT INTO eu_roles(code_roles,libelle_roles,parent_roles_id,id_groupe_roles,date_roles) VALUES (

                                              '$code_roles',

                                              '$libelleroles',

                                              '$parent_roles',

                                              '$groupe_roles',

                                              '$date_created_roles')";

                    $db->setFetchMode(Zend_Db::FETCH_OBJ);

                    $db->query($dbtinsertmultiplesroles);
            
            }

            $validationsuccess['success_message'] = "Le role à été ajouté avec succès";

            $_SESSION['validationsuccess'] = $validationsuccess;


//            $this->_redirect("/organisation/listroles");


        }


    }

    public function editrolesAction () {


    }

    public function updaterolesAction () {


    }

    public function ajouterunecibleAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();

        
        $created = Zend_Date::now();

        $date_created_cible = $created->toString('yyyy-MM-dd HH:mm:ss');


        $dbselect = "SELECT eu_odd.id_odd, eu_odd.titre FROM eu_odd";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedesodd = $stmt->fetchAll();

        $this->view->listedesodd = $dblistedesodd;     

        if ($request->isPost()) {

            $agence_libelle_cible = trim(htmlspecialchars($_POST['agence_libelle_cible']));

            $cible_odd = trim(htmlspecialchars($_POST['cible_odd']));

            $agence_description_cible = trim(addslashes(htmlspecialchars($_POST['agence_description_cible'])));



            $dbcheckcibledoublons = "SELECT * 

                                     FROM eu_cibles
                                              
                                     WHERE eu_cibles.content_cibles= '$agence_description_cible'
                                     
                                     AND eu_cibles.id_odd = $cible_odd";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $smt = $db->query($dbcheckcibledoublons);

            $checkcibledoublons = $smt->fetchAll();

            if (count($checkcibledoublons) != 0){

                $validationerrors['error_doublons'] = "Error 403: Cette cible a déja été enrégistré";

             }

             if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){

                $dbtinsertcible = "INSERT INTO eu_cibles(libelle_cibles,content_cibles, id_odd, date_cibles) VALUES (

                    '$agence_libelle_cible',
    
                    '$agence_description_cible',
                    
                    '$cible_odd',
                    
                    '$date_created_cible')";
    
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
                if ($db->query($dbtinsertcible)){

                    $dbtinsertciblelikeroles = "INSERT INTO eu_roles(code_roles,libelle_roles, id_groupe_roles, id_odd, date_roles) VALUES (

                        '$agence_libelle_cible',
        
                        '$agence_description_cible',
                        
                        24,

                        $cible_odd,
                        
                        '$date_created_cible')";
        
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);


                    if ($db->query($dbtinsertciblelikeroles)){

                        $validationsuccess['success_message'] = "La cible odd à été ajouté avec succès";
    
                        $_SESSION['validationsuccess'] = $validationsuccess;

                    }

                }

    
            }

        }

    }


    

    public function ajouterunindicateurAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $validationerrors = array();

        
        $created = Zend_Date::now();

        $date_created_indicateur = $created->toString('yyyy-MM-dd HH:mm:ss');


        $dbselectciblebyodd = "SELECT eu_cibles.id_cibles, eu_cibles.libelle_cibles FROM eu_cibles WHERE eu_cibles.id_odd = 17";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtciblebyodd = $db->query($dbselectciblebyodd);

        $dblistedesciblebyodd = $stmtciblebyodd->fetchAll();

        $this->view->listedesciblebyodd = $dblistedesciblebyodd;


        if ($request->isPost()) {

            $agence_libelle_indicateur = trim(htmlspecialchars($_POST['agence_libelle_indicateur']));

            $cible_indicateur_odd = trim(htmlspecialchars($_POST['cible_indicateur_odd']));

            $agence_description_indicateur = trim(addslashes(htmlspecialchars($_POST['agence_description_indicateur'])));

             
            $dbcheckindicateurdoublons = "SELECT * 

                                          FROM eu_indicateurs
                                              
                                          WHERE eu_indicateurs.content_indicateurs like '%$agence_description_indicateur%'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $smt = $db->query($dbcheckindicateurdoublons);

            $checkindicateurdoublons = $smt->fetchAll();

            if (count($checkindicateurdoublons) != 0){

                $validationerrors['error_doublons'] = "Error 403: Cet indicateur a déja été enrégistré";

             }

             if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }


            if (empty($validationerrors)){

                $dbtinsertindicateur = "INSERT INTO eu_indicateurs(libelle_indicateurs,content_indicateurs, id_cibles, date_created) VALUES (

                    '$agence_libelle_indicateur',
    
                    '$agence_description_indicateur',
                    
                    '$cible_indicateur_odd',
                    
                    '$date_created_indicateur')";
    
                $db->setFetchMode(Zend_Db::FETCH_OBJ);
    
                if ($db->query($dbtinsertindicateur)){

                    $idciblesroles = $cible_indicateur_odd + 507;

                    $dbtinsertindicateurlikeroles = "INSERT INTO eu_roles(code_roles,libelle_roles, parent_roles_id, id_groupe_roles, id_odd, date_roles) VALUES (

                        '$agence_libelle_indicateur',
        
                        '$agence_description_indicateur',
                        
                        '$idciblesroles',

                        25,

                        17,
                        
                        '$date_created_indicateur')";
        
                    $db->setFetchMode(Zend_Db::FETCH_OBJ);


                    if ($db->query($dbtinsertindicateurlikeroles)){

                        $validationsuccess['success_message'] = "L'indicateur odd à été ajouté avec succès";
    
                        $_SESSION['validationsuccess'] = $validationsuccess;

                    }

                }
    
            }

        }

    }

    public function listrolesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $dbselect = "SELECT * FROM eu_roles, eu_groupe_roles WHERE eu_groupe_roles.id_groupe_roles = eu_roles.id_groupe_roles ORDER BY eu_roles.id_roles DESC";
        
        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedesroles = $stmt->fetchAll();

        $countlistedesroles = count($dblistedesroles);

        $this->view->listedesroles = $dblistedesroles;

        $this->view->countlistedesroles = $countlistedesroles;

        $this->view->tabletri = 1;
    }

    public function detailsrolesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $idrole = (int)$this->_request->getParam('id');

        $dbselect = "SELECT * 

                     FROM eu_roles, eu_groupe_roles 

                     WHERE eu_groupe_roles.id_groupe_roles = eu_roles.id_groupe_roles 

                     AND eu_roles.id_roles = $idrole

                     ORDER BY eu_roles.id_roles DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedesroles = $stmt->fetchAll();
    }

    public function hierarchierolesAction () {

    }

    public function affecterlesutilisateursauxrolesAction () {

        /** 
         * Seul l'administrateur 0 à le droit de créér le responsable du centre
         * Champ de recherche d'utilisateur. Si utilisateur afficher les informations le concernant. Sinon créer l'utilisateur
         * Affichage dans un select la liste de tous les types de roles à créer
         * Après selection du type de roles, afficher les listes des roles correspondant et si possible afficher également les parents
         * Afficher un checkbox si oui ou non il s'agit d'un responsable. Si oui afficher les types de responsabilité qu'il y a (selectionner autre responsable à ajouter).
         * Sinon ne rien faire
         */

         //TRAITEMENTS
         /**
          * 
          */
          $db = Zend_Db_Table::getDefaultAdapter();

          $request = $this->getRequest();

          $created = Zend_Date::now();

          $validationerrors = array();


          $dbutilisateur = new Application_Model_DbTable_EuUtilisateur();


          $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];
  
          $datecreateduserroles = $created->toString('yyyy-MM-dd HH:mm:ss');


          $dbuserroleselect = "SELECT eu_utilisateur.id_centres, eu_utilisateur.id_agences_odd, eu_utilisateur.responsabilite_agences_odd 

                               FROM eu_utilisateur 
                               
                               WHERE eu_utilisateur.id_utilisateur = $id_utilisateur";

          $db->setFetchMode(Zend_Db::FETCH_OBJ);

          $stmt = $db->query($dbuserroleselect);

          $dbgetidcentreouidagencefromuserid = $stmt->fetchAll();

          $idgouperoles = (int)$this->_request->getParam('idgrouperoles');

          $getresponsabilite_agences_odd = 0;

          
          if (count($dbgetidcentreouidagencefromuserid) > 0){

               $getidcentre = $dbgetidcentreouidagencefromuserid[0]->id_centres;

               $getresponsabilite_agences_odd = $dbgetidcentreouidagencefromuserid[0]->responsabilite_agences_odd;

               if ($getresponsabilite_agences_odd == 0) {

                        $parent_roles = (int)$this->_request->getParam('parentroles');

                        $dbgetallpostsadmin = "SELECT * 

                                               FROM eu_roles 
                            
                                               WHERE eu_roles.id_groupe_roles = $idgouperoles 
                            
                                               AND eu_roles.parent_roles_id = $parent_roles";

                        $db->setFetchMode(Zend_Db::FETCH_OBJ);

                        $stmtgetallpostsadmin = $db->query($dbgetallpostsadmin);

                        $dbgetallpostfromroles = $stmtgetallpostsadmin->fetchAll();         
                                                
               }else{
                      
                        $id_odd = (int)$this->_request->getParam('idodd');

                        $dbgetallpostsodd = "SELECT * 

                                      FROM eu_roles 
                        
                                      WHERE eu_roles.id_groupe_roles = $idgouperoles 
                        
                                      AND eu_roles.id_odd = $id_odd";

                         $db->setFetchMode(Zend_Db::FETCH_OBJ);

                         $stmtgetallpostsodd  = $db->query($dbgetallpostsodd );

                         $dbgetallpostfromroles = $stmtgetallpostsodd->fetchAll(); 
                        
               }
          } 
          

/*
          $dbuserroleselect = "SELECT eu_user_roles_permission.id_roles 

                               FROM eu_user_roles_permission 
                               
                               WHERE eu_user_roles_permission.id_utilisateur = $id_utilisateur";

          $db->setFetchMode(Zend_Db::FETCH_OBJ);

          $stmt = $db->query($dbuserroleselect);

          $dblistdesuserroles = $stmt->fetchAll();

          if (count($dblistdesuserroles) == 0 || count($dbgetidcentreouidagencefromuserid) == 0){

            $this->_redirect("/administration");

          }*/

          $this->view->listdesroles = $dbgetallpostfromroles;

          $this->view->idgrouperoles = $idgouperoles;


          if ($request->isPost()) {

            $login_affectation_user = htmlspecialchars($_POST['affectation_membre_login_ot']);

            $nom_agent = "";

            $prenoms_agent = "";

            $password_affectation_user = htmlspecialchars($_POST['affectation_membre_password']);

            $password_affectation_user = md5($password_affectation_user);

            $password_affectation_user_hash = password_hash($password_affectation_user, PASSWORD_BCRYPT);

            $confirmation_password_affectation_user = htmlspecialchars($_POST['affectation_membre_confirmpassword_ot']);

            $confirmation_password_affectation_user = md5($confirmation_password_affectation_user);

            $affectationcodemembre = htmlspecialchars($_POST['affectation_code_membre_ot']);


            $dbrecupnomandprenoms = "SELECT eu_membre.nom_membre, eu_membre.prenom_membre 
            
                                     FROM eu_membre 
                                     
                                     WHERE eu_membre.code_membre = '$affectationcodemembre'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtrecupnomandprenoms = $db->query($dbrecupnomandprenoms);
  
            $dbgetnomandprenoms = $stmtrecupnomandprenoms->fetchAll(); 

            if( count($dbgetnomandprenoms) == 0){

                $validationsuccess['error_size_code_membre'] = "votre code membre dépasse 20 caractères";

            }

            if (count($dbgetnomandprenoms) != 0) {

                $nom_agent = $dbgetnomandprenoms[0]->nom_membre;

                $prenoms_agent = $dbgetnomandprenoms[0]->prenom_membre;           

            }


           $id_roles = $_POST['id_user_roles'];

      /*       $og_resp_roles = $_POST['og_resp_roles'];*/

            $ref_user_role = substr(md5(uniqid(rand(), true)), 0, 8);

            $real_ref_user_role = strtoupper('ORG-'.$ref_user_role);

            $responsabilite = 0;

      /*      if ($og_resp_roles == 1 ) {

                $responsabilite = 1;

                $organisation_responsable_code = trim(htmlspecialchars($_POST['organisation_responsable_code']));

                $organisation_libelle_responsable = trim(addslashes(htmlspecialchars($_POST['organisation_libelle_responsable'])));

            }*/

            if ($affectationcodemembre != ""){

                $verifsubcodemembre = substr($affectationcodemembre, 19, 1);

                $verifsizecodemembre = strlen($affectationcodemembre);

                if ($verifsizecodemembre != 20){
           
                    $validationsuccess['error_size_code_membre'] = "votre code membre dépasse 20 caractères";

                }

                if ($verifsubcodemembre != "P"){

                    $validationsuccess['error_type_code_membre'] = "Votre code membre doit être celui d'un membre physique";

                }


                if(!filter_var($affectationcodemembre, FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9{19}(P)$]#")))){

                     $validationerrors['verif_valid_code_membre'] = "Votre code membre n'est pas valide";

                }

            }

            if($login_affectation_user == "" || empty($login_affectation_user)){

                $validationerrors['errors_empty_login'] = "Vous devez renseigner le login";

            }

            if($password_affectation_user == "" || empty($password_affectation_user)){

                $validationerrors['errors_empty_password'] = "Vous devez renseigner le mot de passe";

            }

            
            if($confirmation_password_affectation_user == "" || empty($confirmation_password_affectation_user)){

                $validationerrors['errors_empty_confirmpassword'] = "Vous devez confirmer le mot de passe";

            }

            if ($password_affectation_user != $confirmation_password_affectation_user){

                $validationerrors['errors_password_conform'] = "Votre mot de passe n'est pas correctement confirmé";

            }


            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){
            

            $dbverifyuserinsert = "SELECT * 

                                   FROM eu_utilisateur 

                                   WHERE eu_utilisateur.login = '$login_affectation_user'

                                   AND eu_utilisateur.pwd = '$password_affectation_user'";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
            $stmtverifyuserinsert = $db->query($dbverifyuserinsert);

            $verifyuserinsert = $stmtverifyuserinsert->fetchAll();

/*
 * 
 * eu_utilisateur.code_membre='$affectation_code_membre' AND 
 * 'code_membre'=>$affectation_code_membre, */
            if (count($verifyuserinsert) == 0) {

                  $queryinsertuser = array(

                       'login'=>$login_affectation_user,

                       'pwd'=>$password_affectation_user,

                       'password_hash'=>$password_affectation_user_hash,

                       'id_centres'=>$getidcentre,

                       'code_membre'=>$affectationcodemembre,

                       'id_utilisateur_parent'=>$id_utilisateur,

                       'reference_user_role'=>$real_ref_user_role,

                       'nom_utilisateur'=>$nom_agent,

                       'prenom_utilisateur'=>$prenoms_agent
                  );

                  if ($id_utilisateur == 140){

                     $queryinsertuser = array(

                        'login'=>$login_affectation_user,
 
                        'pwd'=>$password_affectation_user,

                       'password_hash'=>$password_affectation_user_hash,
  
                        'reference_user_role'=>$real_ref_user_role,

                       'code_membre'=>$affectationcodemembre,

                        'id_utilisateur_parent'=>$id_utilisateur,
 
                        'nom_utilisateur'=>$nom_agent,
 
                        'prenom_utilisateur'=>$prenoms_agent
                     );
                  }
                

                if ($dbutilisateur->insert($queryinsertuser)){

                         $dbselectuser = "SELECT eu_utilisateur.id_utilisateur

                                          FROM eu_utilisateur 

                                          WHERE eu_utilisateur.reference_user_role ='$real_ref_user_role'

                                          AND eu_utilisateur.login = '$login_affectation_user'

                                          AND eu_utilisateur.pwd = '$password_affectation_user'";

                          $db->setFetchMode(Zend_Db::FETCH_OBJ);

                          $stmtselectuser = $db->query($dbselectuser);

                          $searchlastinsertuser = $stmtselectuser->fetchAll();


            if (count($searchlastinsertuser) != 0) {

                $dbidsearchlastinsertuser = $searchlastinsertuser[0]->id_utilisateur;

                $dbverifyinsertuser = "SELECT * 

                                       FROM eu_user_roles_permissions 
                             
                                       WHERE eu_user_roles_permissions.id_roles = $id_roles 
                             
                                       AND eu_user_roles_permissions.id_utilisateur = $dbidsearchlastinsertuser";

                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifyinsertuser = $db->query($dbverifyinsertuser);

                $selectsmtverifyinsertuser = $stmtverifyinsertuser->fetchAll();
        
                $countverifyinsertuser = count($selectsmtverifyinsertuser);

                if ($countverifyinsertuser == 0){

                    if ($responsabilite == 0){

                          $dbtinsert = "INSERT INTO eu_user_roles_permissions(id_roles,id_utilisateur,date_affectation_roles) VALUES (

                                              '$id_roles',

                                              '$dbidsearchlastinsertuser',

                                              '$datecreateduserroles')";

                          $db->setFetchMode(Zend_Db::FETCH_OBJ);

                          $db->query($dbtinsert);

                          $this->_redirect("/organisation/listdesgroupsderoles/idgrouperoles/$idgouperoles");

                    }else{


                            $dbtinsert = "INSERT INTO eu_user_roles_permissions(id_roles,id_utilisateur, responsabilite, code_responsabilite, libelle_responsabilite, date_affectation_roles) VALUES (

                                '$id_roles',

                                '$dbidsearchlastinsertuser',

                                1,

                                '$organisation_responsable_code',

                                '$organisation_libelle_responsable',

                                '$datecreateduserroles')";

                            $db->setFetchMode(Zend_Db::FETCH_OBJ);

                            $db->query($dbtinsert);

                            $this->_redirect("/organisation/listdesgroupsderoles/idgrouperoles/$idgouperoles");

                    }



                } else {

                    $validationerrors['errors_doublon_user_roles'] = "Cet utilisateur est déjà affecté aux posts selectionnés";

                }

              }

            }

          }

        }

       }

    }

    public function ajoutderolesparentdistantAction() {

        
        $db = Zend_Db_Table::getDefaultAdapter();

        $dbrolesdistants = new Application_Model_DbTable_EuRoleParentsDistant();

        $validationsuccess = array();

        $validationerrors = array();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $dbselectallroles = "SELECT * FROM eu_roles";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectallroles = $db->query($dbselectallroles);

        $dbselectallroles = $stmtselectallroles->fetchAll();

        $this->view->selectallroles = $dbselectallroles;


        if ($request->isPost()){

            $selectrolescible = $_POST['roles_cibles'];

            for ($i = 0; $i< count($_POST['roles_parent_distant']); $i++){

                $roles_parent_distant = htmlspecialchars($_POST['roles_parent_distant'][$i]);

                $dbverifdoublonroles = "SELECT * FROM eu_roles_parents_distant WHERE id_roles = $selectrolescible AND parents_roles = $roles_parent_distant";

                
                $db->setFetchMode(Zend_Db::FETCH_OBJ);

                $stmtverifdoublonroles = $db->query($dbverifdoublonroles);

                $verifdoublonroles = $stmtverifdoublonroles->fetchAll();

                if (count($verifdoublonroles) != 0) {

                    $validationerrors['errors_roles_doublons'] = "Ce enrégistrement a été déjà ajouté";

                    $_SESSION['validationerrors'] = $validationerrors;

                }else{

                    $arrayqueryparentrolesdistant = array(

                        'id_roles' => $selectrolescible,
                        
                        'parents_roles' => $roles_parent_distant
                    );   
                    
                    if ($dbrolesdistants->insert($arrayqueryparentrolesdistant)){

                        $validationsuccess['succes_add_roles'] = "Votre enrégistrement a été ajouté avec succes!";

                        $_SESSION['validationsuccess'] = $validationsuccess;
                        
                    }
                }
            }


        }

    }

    public function listdesgroupsderolesciblesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $idgrouperoles = (int)$this->_request->getParam('idgrouperoles');

        $idparentcibles = (int)$this->_request->getParam('idparentcibles');


        $dbselectgrouperolescible = "SELECT eu_groupe_roles.libelle_groupe_roles
        
                                FROM eu_groupe_roles 
                                
                                WHERE eu_groupe_roles.id_groupe_roles = $idgrouperoles";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtnomdugroupederolescible = $db->query($dbselectgrouperolescible);

        $dbnomdungroupederolescible = $stmtnomdugroupederolescible->fetchAll();


        $dbselectuserrolescible = "SELECT eu_utilisateur.nom_utilisateur, 

                                     eu_utilisateur.prenom_utilisateur, 

                                     eu_utilisateur.login,
                                     
                                     eu_user_roles_permissions.responsabilite,

                                     eu_user_roles_permissions.libelle_responsabilite,
                                     
                                     eu_roles.libelle_roles, 

                                     eu_roles.code_roles
        
                              FROM eu_roles, eu_user_roles_permissions, eu_utilisateur
                         
                              WHERE eu_roles.id_roles = eu_user_roles_permissions.id_roles
                         
                              AND eu_user_roles_permissions.id_utilisateur = eu_utilisateur.id_utilisateur
                         
                              AND eu_roles.id_groupe_roles = $idgrouperoles

                              AND eu_roles.parent_roles_id = $idparentcibles
                              
                              AND eu_utilisateur.id_utilisateur_parent = $id_utilisateur";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtlistedesuserdungroupederolescible = $db->query($dbselectuserrolescible);

        $dblistedesuserdungroupederolescible = $stmtlistedesuserdungroupederolescible->fetchAll();

        $this->view->listedesuserdungroupederolescible = $dblistedesuserdungroupederolescible;

        $countitemsusersdungroupederolescible = count($dblistedesuserdungroupederolescible);

        $this->view->countitemsusersdungroupederolescible = $countitemsusersdungroupederolescible;

        $this->view->nomdugroupederolecible = $dbnomdungroupederolescible;

        $this->view->tabletri = 1;
    }

    public function listdesgroupsderolesAction () {

        /**
         * Seul le responsable de centre le president du conseil d'administration ont le droit de consulter cette page
         * 
         * L'utilisateur a le droit de voir seulement les utilisateurs et les postes qu'il a créér pour chaque groupe
         * 
         * 
         */

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $idgrouperoles = (int)$this->_request->getParam('idgrouperoles');


        $dbselectgrouperoles = "SELECT eu_groupe_roles.libelle_groupe_roles
        
                                FROM eu_groupe_roles 
                                
                                WHERE eu_groupe_roles.id_groupe_roles = $idgrouperoles";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtnomdugroupederoles = $db->query($dbselectgrouperoles);

        $dbnomdungroupederoles = $stmtnomdugroupederoles->fetchAll();


        $dbselectuserroles = "SELECT eu_utilisateur.nom_utilisateur, 

                                     eu_utilisateur.prenom_utilisateur, 

                                     eu_utilisateur.login,
                                     
                                     eu_user_roles_permissions.responsabilite,

                                     eu_user_roles_permissions.libelle_responsabilite,
                                     
                                     eu_roles.libelle_roles, 

                                     eu_roles.code_roles
        
                              FROM eu_roles, eu_user_roles_permissions, eu_utilisateur
                         
                              WHERE eu_roles.id_roles = eu_user_roles_permissions.id_roles
                         
                              AND eu_user_roles_permissions.id_utilisateur = eu_utilisateur.id_utilisateur
                         
                              AND eu_roles.id_groupe_roles = $idgrouperoles
                              
                              AND eu_utilisateur.id_utilisateur_parent = $id_utilisateur";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtlistedesuserdungroupederoles = $db->query($dbselectuserroles);

        $dblistedesuserdungroupederoles = $stmtlistedesuserdungroupederoles->fetchAll();

        $this->view->listedesuserdungroupederoles = $dblistedesuserdungroupederoles;

        $countitemsusersdungroupederoles = count($dblistedesuserdungroupederoles);

        $this->view->countitemsusersdungroupederoles = $countitemsusersdungroupederoles;

        $this->view->nomdugroupederole = $dbnomdungroupederoles;

        $this->view->tabletri = 1;

    }

    public function listedesgroupesrolesducaAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $idgrouperoles = (int)$this->_request->getParam('idgrouperoles');


        


        $dbselectgrouperoles = "SELECT eu_groupe_roles.libelle_groupe_roles
        
                                FROM eu_groupe_roles 
                                
                                WHERE eu_groupe_roles.id_groupe_roles = $idgrouperoles";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $stmtnomdugroupederoles = $db->query($dbselectgrouperoles);

        $dbnomdungroupederoles = $stmtnomdugroupederoles->fetchAll();


        $dbselectuserroles = "SELECT eu_utilisateur.nom_utilisateur, 

                                     eu_utilisateur.prenom_utilisateur, 
                                     
                                     eu_user_roles_permissions.responsabilite,

                                     eu_user_roles_permissions.libelle_responsabilite,
                                     
                                     eu_roles.libelle_roles, 

                                     eu_roles.code_roles
        
                              FROM eu_roles, eu_user_roles_permissions, eu_utilisateur
                         
                              WHERE eu_roles.id_roles = eu_user_roles_permissions.id_roles
                         
                              AND eu_user_roles_permissions.id_utilisateur = eu_utilisateur.id_utilisateur
                         
                              AND eu_roles.id_groupe_roles = $idgrouperoles
                              
                              AND eu_utilisateur.id_utilisateur_parent = $id_utilisateur";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtlistedesuserdungroupederoles = $db->query($dbselectuserroles);

        $dblistedesuserdungroupederoles = $stmtlistedesuserdungroupederoles->fetchAll();

        $this->view->listedesuserdungroupederoles = $dblistedesuserdungroupederoles;

        $countitemsusersdungroupederoles = count($dblistedesuserdungroupederoles);

        $this->view->countitemsusersdungroupederoles = $countitemsusersdungroupederoles;

        $this->view->nomdugroupederole = $dbnomdungroupederoles;

        $this->view->tabletri = 1;
    }

    public function listedesagentsderolesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $id_utilisateur = $_SESSION['utilisateur']['id_utilisateur'];

        $agentsroles = (int)$this->_request->getParam('agentsroles');


        $dbselectnomrole = "SELECT eu_roles.libelle_roles

                             FROM eu_roles

                             WHERE eu_roles.id_roles = $agentsroles";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtnomrole = $db->query($dbselectnomrole);

        $nomrole = $stmtnomrole->fetchAll();


        $dbselectagentroles = "SELECT eu_utilisateur.nom_utilisateur, 

                                     eu_utilisateur.prenom_utilisateur, 
                                     
                                     eu_user_roles_permissions.responsabilite,

                                     eu_user_roles_permissions.libelle_responsabilite,
                                     
                                     eu_roles.libelle_roles, 

                                     eu_roles.code_roles
        
                              FROM eu_roles, eu_user_roles_permissions, eu_utilisateur
                         
                              WHERE eu_roles.id_roles = eu_user_roles_permissions.id_roles
                         
                              AND eu_user_roles_permissions.id_utilisateur = eu_utilisateur.id_utilisateur
                         
                              AND eu_roles.id_roles = $agentsroles";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtlistedesagentsdunrole = $db->query($dbselectagentroles);

        $dblistedesagentsdunrole = $stmtlistedesagentsdunrole->fetchAll();

        $this->view->listedesagentsdunrole = $dblistedesagentsdunrole;
        
        $countitemsagentsdunrole = count($dblistedesagentsdunrole);

        $this->view->countitemsagentsdunrole = $countitemsagentsdunrole;

        $this->view->nomrole = $nomrole;

        $this->view->tabletri = 1;

    }

        
    public function listdetouslestypesderolesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $created = Zend_Date::now();

        $date_created_roles = $created->toString('yyyy-MM-dd HH:mm:ss');

        $dbselect = "SELECT * FROM eu_groupe_roles";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistdesgroupesderoles = $stmt->fetchAll();

        $this->view->listdesgroupesderoles = $dblistdesgroupesderoles;

        
        $resultjson = array(

            'search_result'=>$resultcontent

        );
        
        header('Content-type:application/json');

        die(json_encode($resultjson));
    }

    public function listdesrolesenfonctionduntypederolesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $created = Zend_Date::now();

        $date_created_roles = $created->toString('yyyy-MM-dd HH:mm:ss');

        $id_groupe_roles = $_POST['id_groupe_roles'];

        $dbselect = "SELECT * FROM eu_roles WHERE eu_roles.id_groupe_roles = '$id_groupe_roles'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistdesgroupesderoles = $stmt->fetchAll();

        $this->view->listdesgroupesderoles = $dblistdesgroupesderoles;

        
        $resultjson = array(

            'search_result'=>$resultcontent
        );
        
        header('Content-type:application/json');

        die(json_encode($resultjson));
    }

    public function listdetouslestypesderesponsabiliteAction () {


    }

    public function listedetouslescentresAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $dbselect = "SELECT * FROM eu_centres ORDER BY eu_centres.id_centres DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedescentres = $stmt->fetchAll();

        $countlistedescentres = count($dblistedescentres);

        $this->view->listedescentres = $dblistedescentres;

        $this->view->countlistedescentres = $countlistedescentres;

        $this->view->tabletri = 1; 

        
    }

    public function listedetouslesagencesAction () {

        /**La liste des agences étant lié à un centre */

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $dbselect = "SELECT eu_agences_odd.reference_agences_odd, 
        
                            eu_agences_odd.libelle_agences_odd,
                            
                            eu_agences_odd.date_agences_odd,

                            eu_agences_odd.id_agences_odd
        
                     FROM eu_agences_odd 
                     
                     ORDER BY eu_agences_odd.id_agences_odd DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedesagences = $stmt->fetchAll();

        $countlistedesagences = count($dblistedesagences);

        $this->view->listedesagences = $dblistedesagences;

        $this->view->countlistedesagences = $countlistedesagences;

        $this->view->tabletri = 1; 
    }


    public function listedetouslesagencesduncentreAction () {

                /**La liste des agences étant lié à un centre */

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $idcentres = $_SESSION['utilisateur']['id_centres'];

        $dbselect = "SELECT eu_agences_odd.reference_agences_odd, 
        
                            eu_agences_odd.libelle_agences_odd,
                            
                            eu_agences_odd.date_agences_odd,

                            eu_agences_odd.id_agences_odd
        
                     FROM eu_agences_odd
                     
                     WHERE eu_agences_odd.id_centres = '$idcentres'
                     
                     ORDER BY eu_agences_odd.id_agences_odd DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedesagences = $stmt->fetchAll();

        $countlistedesagences = count($dblistedesagences);

        $this->view->listedesagences = $dblistedesagences;

        $this->view->countlistedesagences = $countlistedesagences;

        $this->view->tabletri = 1;
    }

    public function listedetouslescentralesbyagencesAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $idagenceodd = $_SESSION['utilisateur']['id_agences_odd'];

        $dbselectcentralesbyagences = "SELECT * 
        
                                       FROM eu_centrales
                     
                                       WHERE eu_centrales.id_agence_odd = $idagenceodd
                     
                                       ORDER BY eu_centrales.id_centrales DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectcentralesbyagences = $db->query($dbselectcentralesbyagences);

        $dblistedescentralesbyagences = $stmtselectcentralesbyagences->fetchAll();

        $countlistedescentralesbyagences = count($dblistedescentralesbyagences);

        $this->view->listedescentralesbyagences = $dblistedescentralesbyagences;

        $this->view->countlistedescentralesbyagences = $countlistedescentralesbyagences;

        $this->view->tabletri = 1; 
    }

    public function listedetouslescentralesbycentresAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $idcentres = $_SESSION['utilisateur']['id_centres'];

        $dbselectcentralesbycentres = "SELECT eu_centrales.*, eu_agences_odd.libelle_agences_odd 

                                       FROM eu_centrales, eu_agences_odd, eu_centres

                                       WHERE eu_agences_odd.id_agences_odd = eu_centrales.id_agence_odd

                                       AND eu_agences_odd.id_centres = eu_centres.id_centres
                                       
                                       AND eu_centres.id_centres = $idcentres
                     
                                       ORDER BY eu_centrales.id_centrales DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectcentralesbycentres = $db->query($dbselectcentralesbycentres);

        $dblistedescentralesbycentres = $stmtselectcentralesbycentress->fetchAll();

        $countlistedescentralesbycentres = count($dblistedescentralesbycentres);

        $this->view->listedescentralesbycentres = $dblistedescentralesbycentres;

        $this->view->countlistedescentralesbycentres =  $countlistedescentralesbycentres;

        $this->view->tabletri = 1; 
    }

    public function listedetouslescentralesAction () {

      /***La liste des centrales est liés à la liste des agences */

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $dbselect = "SELECT * 
        
                     FROM eu_centrales, eu_type_centrales 
                     
                     WHERE eu_centrales.id_centrales = eu_type_centrales.id_type_centrales 
                     
                     ORDER BY eu_centrales.id_type_centrales DESC";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedetouslescentrales = $stmt->fetchAll();

        $countlistedetouslescentrales = count($dblistedetouslescentrales);

        $this->view->listedetouslescentrales = $dblistedetouslescentrales;

        $this->view->countlistedetouslescentrales = $countlistedetouslescentraless;

        $this->view->tabletri = 1; 
    }

    public function updatecentreAction() {

        $db = Zend_Db_Table::getDefaultAdapter();

        $idcentre = (int)$this->_request->getParam('idcentres');

        $dbselectdetail = "SELECT * FROM eu_centres";



    }

    public function updateagenceAction () {

    }

    public function updatecentraleAction () {

    }

    public function editionduncentreAction () {

        /**
         * Seul le responsable du centre le pca peuvent être en mesure de 
         */
        $db = Zend_Db_Table::getDefaultAdapter();

        $dbcentreedition = new Application_Model_DbTable_EuCentres();

        $dbaffectionrolesutilisateur = new Application_Model_DbTable_EuUserrolespermissions();

        $t_zone = new Application_Model_DbTable_EuZone();

        $t_pays = new Application_Model_DbTable_EuPays();

        $t_region = new Application_Model_DbTable_EuRegion();

        $t_prefecture = new Application_Model_DbTable_EuPrefecture();

        $t_canton = new Application_Model_DbTable_EuCanton();

        $request = $this->getRequest();

        $created = Zend_Date::now();

        $idcentreedit = (int)$this->_request->getParam('idcentresedit');



         if($_SERVER['REQUEST_METHOD'] == 'GET'){

             $dbselecteditioncentre = "SELECT * 
        
                                       FROM eu_centres 
    
                                       WHERE eu_centres.id_centres = $idcentreedit";

             $db->setFetchMode(Zend_Db::FETCH_OBJ);

             $stmteditioncentre = $db->query($dbselecteditioncentre);

             $urleditioncentre = $stmteditioncentre ->fetchAll();

             if (count($urleditioncentre) == 0) {

                 http_response_code(403);

                 die('Les informations concernant le centre que vous voulez modifié n\'est pas encore disponible');

             }   
         }


        $dbselecteditcentres = "SELECT eu_centres.* , 
        
                                       eu_utilisateur.nom_utilisateur,
                                                   
                                       eu_utilisateur.prenom_utilisateur,

                                       eu_utilisateur.code_membre,

                                       eu_zone.nom_zone,

                                       eu_pays.libelle_pays,
                                        
                                       eu_region.nom_region,

                                       eu_prefecture.nom_prefecture,

                                       eu_canton.nom_canton

                                FROM eu_centres, eu_utilisateur, eu_zone, eu_pays, eu_region, eu_prefecture, eu_canton
                     
                                WHERE eu_centres.id_utilisateur = eu_utilisateur.id_utilisateur 

                                AND eu_centres.code_zone = eu_zone.code_zone

                                AND eu_centres.id_pays = eu_pays.id_pays

                                AND eu_centres.id_region = eu_region.id_region

                                AND eu_centres.id_prefecture = eu_prefecture.id_prefecture

                                AND eu_centres.id_canton = eu_canton.id_canton
                                  
                                AND eu_centres.id_centres = $idcentreedit";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselecteditcentres = $db->query($dbselecteditcentres);

        $dbeditduncentre = $stmtselecteditcentres->fetchAll();

        $this->view->editduncentre = $dbeditduncentre;

        $this->view->idcentreedition = $idcentreedit;

        $type_centre = $dbeditduncentre[0]->type_centre;
        

        /***eu_historiques_operations */

        if ($request->isPost()) {

            $idtypecentreedition = $_POST['idcentreedition'];

            $libelle_centre_edition = trim(htmlspecialchars($_POST['organisateur_modif_centre_nom_edition']));

            $surface_centre_edition = trim(htmlspecialchars($_POST['organisateur_modif_centre_surface_edition']));
    
            $addresse_centre_edition = trim(htmlspecialchars($_POST['organisateur_modif_centre_address_edition']));
    
            $description_centre_edition = trim(htmlspecialchars($_POST['organisateur_modif_centre_description_edition']));
    
            $telephone_centre_edition = trim(htmlspecialchars($_POST['organisateur_modif_centre_phone_edition']));
    
            $bp_centre_edition = trim(htmlspecialchars($_POST['organisateur_modif_centre_bp_edition']));  


           /***Utiliser dans la requête OR **/

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){

                $querytabs = array(

                    'libelle_centre'=>$libelle_centre_edition,

                    'surface_centre'=>$surface_centre_edition,

                    'addresse_centre'=>$addresse_centre_edition,

                    'description_centre'=>$description_centre_edition,

                    'telephone_centre'=>$telephone_centre_edition,

                    'bp_centre'=>$bp_centre_edition
                );                  

                    if ($dbcentreedition->update($querytabs, array('id_centres = ?'=> $idtypecentreedition))){

                          $this->_redirect('/organisation/listedetouslescentres');

                    }
            
            }

        }
        
    }

    public function editionduneagenceAction () {


        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $t_canton = new Application_Model_DbTable_EuCanton();

        $t_secteur = new Application_Model_DbTable_EuSecteur();

        $t_agences = new Application_Model_DbTable_EuAgencesodd;

        $created = Zend_Date::now();

        $ideditionagencesodd = (int)$this->_request->getParam('ideditonagence'); 


        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $dburleditionagenceodd = "SELECT *

                                      FROM eu_agences_odd

                                      WHERE eu_agences_odd.id_agences_odd = $ideditionagencesodd";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmteditionagenceodd = $db->query($dburleditionagenceodd);

            $urleditionagenceodd = $stmteditionagenceodd ->fetchAll();

            if (count($urleditionagenceodd) == 0) {

                http_response_code(403);

                die('Les informations concernant l\'agences odd que vous voulez modifié n\'est pas encore disponible ');

            }   
        }

        $dbselectediteruneagence = "SELECT eu_agences_odd.*, 
        
                                           eu_canton.*, 
                                           
                                           eu_utilisateur.id_utilisateur, 
                                           
                                           eu_utilisateur.login,

                                           eu_utilisateur.nom_utilisateur,

                                           eu_odd.titre,

                                           eu_utilisateur.prenom_utilisateur
        
                                    FROM eu_agences_odd, eu_canton, eu_utilisateur, eu_odd
                                    
                                    WHERE eu_agences_odd.id_canton = eu_canton.id_canton
                                    
                                    AND eu_agences_odd.id_utilisateur = eu_utilisateur.id_utilisateur

                                    AND eu_agences_odd.id_odd = eu_odd.id_odd
                                    
                                    AND eu_agences_odd.id_agences_odd = $ideditionagencesodd";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectagencesforedition = $db->query($dbselectediteruneagence);

        $selectagencesforedition = $stmtselectagencesforedition->fetchAll();

        $this->view->selectagencesforedition = $selectagencesforedition;

        
        /**Liste des 17 ODD */
        $dbselect = "SELECT eu_odd.id_odd, eu_odd.titre 
        
                     FROM eu_odd
                     
                     WHERE eu_odd.valid = 1";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmt = $db->query($dbselect);

        $dblistedesoddedition = $stmt->fetchAll();

        $this->view->listedesodd = $dblistedesoddedition;

        $this->view->ideditionagencesodd = $ideditionagencesodd;


        $cantons = $t_canton->fetchAll();

        $secteur = $t_secteur->fetchAll();


        $this->view->cantonsedition = $cantons;

        $this->view->secteuredition = $secteur;


        if ($request->isPost()) {

            $id_editionagenceodd = $_POST['ideditionagencesodd'];

            $id_centreagenceodd = $_POST['idcentreeditionagencesodd'];
            
            $libelle_agence_edition = htmlspecialchars($_POST['organisation_agence_libelle_edition']);

            $id_odd_edition = htmlspecialchars($_POST['organisation_agence_odd_edition']);

            $organisation_agence_phone_edition = htmlspecialchars($_POST['organisation_agence_phone_edition']);

            $organisation_agence_bp_edition = htmlspecialchars($_POST['organisation_agence_bp_edition']);    
            
            $organisation_agence_address_edition = trim(addslashes(htmlspecialchars($_POST['organisation_agence_address_edition'])));

            $id_cantonodd = $_POST['id_canton_edition'];

            if (!empty($validationerrors)){

                $_SESSION['validationerrors'] = $validationerrors;
                
            }

            if (empty($validationerrors)){


             $updateagencesarray = array(

                  'libelle_agences_odd'=>$libelle_agence_edition,

                  'telephone_agences_odd'=>$organisation_agence_phone_edition,

                  'addresse_agences_odd'=>$organisation_agence_address_edition,

                  'bp_agences_odd'=>$organisation_agence_bp_edition,

                  'id_canton'=>$id_cantonodd,

                  'id_odd'=>$id_odd_edition
             );

             
               if ($t_agences->update($updateagencesarray, array('id_agences_odd = ?'=>$id_editionagenceodd))){

                   $redirecentreurl = "/organisation/detailduncentre/idcentre/".$id_centreagenceodd;

                   $this->_redirect($redirecentreurl);
               }
           
           }
            
         }


    }

    public function editiondunecentraleAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();

        $created = Zend_Date::now();

        $idcentrale = (int)$this->_request->getParam('idcentrale');    
        
        $dbselectcentraleforedition = "SELECT * 
        
                                       FROM eu_centrales, eu_type_centrales, eu_utilisateur
                             
                                       WHERE eu_centrale.id_type_centrales = eu_type_centrales.id_type_centrales
                                       
                                       AND eu_centrales.id_centrales = eu_utilisateur.id_centrales
                                       
                                       AND eu_centrales.id_centrales = '$idcentrale'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectcentraleforedition = $db->query($dbselectcentraleforedition);

        $selectcentraleforedition = $stmtselectcentraleforedition->fetchAll();

        $this->view->selectcentraleforedition = $selectcentraleforedition;
    }

    public function detailduncentreAction () {
        
        $db = Zend_Db_Table::getDefaultAdapter();

        $idcentre = (int)$this->_request->getParam('idcentre');

        /***
         * Tous les informations du centres y compris le responsable
         * Liste de tous les agences
         * La liste de tous les membres utilisateurs
         */

        $dbselectdetailcentres = "SELECT eu_centres.* , 
        
                                         eu_utilisateur.nom_utilisateur,
                                                   
                                         eu_utilisateur.prenom_utilisateur,

                                         eu_utilisateur.code_membre

                                  FROM eu_centres, eu_utilisateur
                     
                                  WHERE eu_centres.id_utilisateur = eu_utilisateur.id_utilisateur 
                                  
                                  AND eu_centres.id_centres = $idcentre";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectdetailcentres = $db->query($dbselectdetailcentres);

        $dbdetailduncentre = $stmtselectdetailcentres->fetchAll();

        $dbselectionguichetsbycentre = "SELECT *

                                        FROM eu_association, eu_centres, eu_agences_odd
                                
                                        WHERE eu_association.id_agences_odd = eu_agences_odd.id_agences_odd

                                        AND eu_centres.id_centres = eu_agences_odd.id_centres
                                        
                                        AND eu_agences_odd.id_centres = $idcentre
                                        
                                        AND eu_association.guichet = 1";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtallguichetsbycentre = $db->query($dbselectionguichetsbycentre);

        $selectionnertouslesguichets = $stmtallguichetsbycentre->fetchAll();

        $countlistedetouslesguichets = count($selectionnertouslesguichets);
            

        $dbselectlistedesagencesbycentre = "SELECT eu_agences_odd.* 

                                            FROM eu_agences_odd, eu_centres
                     
                                            WHERE eu_centres.id_centres = eu_agences_odd.id_centres
                                            
                                            AND eu_agences_odd.id_centres = $idcentre";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectlistedesagencesbycentre = $db->query($dbselectlistedesagencesbycentre);

        $selectlistedesagencesbycentre = $stmtselectlistedesagencesbycentre->fetchAll();


        $countagencesbycentres = count($selectlistedesagencesbycentre);

        $this->view->detailduncentre = $dbdetailduncentre;

        $this->view->countagencesbycentres = $countagencesbycentres;

        $this->view->countlistdesguichetsbycentre = $countlistedetouslesguichets;

        $this->view->listedesagencesbycentre =  $selectlistedesagencesbycentre;

        $this->view->listedesguichetsbycentres = $selectionnertouslesguichets;

    }

    public function detailduneagenceAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $idagences = (int)$this->_request->getParam('idagences');

        /***DETAIL D'UNE AGENCE */

        $dbselectagence = "SELECT eu_agences_odd.*, 
        
                                  eu_canton.nom_canton, 
                                  
                                  eu_odd.titre, 
                                  
                                  eu_odd.resume, 

                                  eu_utilisateur.nom_utilisateur,

                                  eu_utilisateur.prenom_utilisateur 

                           FROM eu_agences_odd, eu_odd, eu_canton, eu_utilisateur

                           WHERE eu_agences_odd.id_odd = eu_odd.id_odd

                           AND eu_agences_odd.id_canton = eu_canton.id_canton

                           AND eu_agences_odd.id_utilisateur = eu_utilisateur.id_utilisateur

                           AND eu_agences_odd.id_agences_odd = $idagences";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectagence = $db->query($dbselectagence);

        $dbdetailduneagenceodd = $stmtselectagence->fetchAll();


        /****LISTE DES CENTRALES D'UNE AGENCE */

        $dbselectcentralesbyagences = "SELECT *
        
                                       FROM eu_centrales, eu_type_centrales
                                     
                                       WHERE eu_centrales.id_type_centrales = eu_type_centrales.id_type_centrales
                                     
                                       AND eu_centrales.id_agence_odd = $idagences";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectcentralesbyagences = $db->query($dbselectcentralesbyagences);

        $listedescentralesbyagence = $stmtselectcentralesbyagences->fetchAll();

        $countlistedescentralesbyagence = count($listedescentralesbyagence);

        $this->view->countlistedescentralesbyagence = $countlistedescentralesbyagence;

        $this->view->listedescentralesbyagence = $listedescentralesbyagence;

        $this->view->detailduneagence = $dbdetailduneagenceodd;        
    }

    public function detaildunecentraleAction () {

        $db = Zend_Db_Table::getDefaultAdapter();

        $idcentrales = (int)$this->_request->getParam('idcentrales');

        $dbselectcentralesbyagences = "SELECT *
        
                                       FROM eu_centrales 
                                     
                                       LEFT JOIN  eu_type_centrales 
                                       
                                       ON eu_centrales.id_type_centrales = eu_type_centrales.id_type_centrales
                                     
                                       WHERE eu_centrales.id_type_centrales = $idcentrales";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselectcentralesbyagences = $db->query($dbselectcentralesbyagences);

        $detaildelacentralebyagence = $stmtselectcentralesbyagences->fetchAll();

        $this->view->detaildelacentralebyagence = $detaildelacentralebyagence;

        var_dump($detaildelacentralebyagence);

    }
}
