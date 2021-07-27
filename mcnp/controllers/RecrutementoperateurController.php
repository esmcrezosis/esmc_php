<?php

class RecrutementOperateurController extends Zend_Controller_Action{
    
    public function indexAction(){
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
        $dbreop = new Application_Model_DbTable_EuRecrutementOperateur();
        $can = new Application_Model_EuCanton();
        $canm = new Application_Model_EuCantonMapper();
        $re = new Application_Model_EuRegion();
        $rem = new Application_Model_EuRegionMapper();
        $created = Zend_Date::now();
        $can_all = $canm->fetchAll();
        $re_all = $rem->fetchAll();
        
        $this->view->can_all_entry = $can_all;
        
        $this->view->re_all_entry = $re_all;
        
        $validationerrors = array();
        $validationemailerrors = array();
        $validationperteerrors = array();
        $validationpertesuccess = array();
        $request = $this->getRequest();
        $cv = "";
        $motivation = "";
        $dir_files = "";
        $src_motivation_file = "";
        if($request->isPost()){
            $cvuploadrecrutementoperateur = $_FILES['cv_upload_recrutement_operateur'];
            $ldmuploadrecrutementoperateur = $_FILES['motivation_upload_recrutement_operateur'];
            
              if(!array_key_exists('nom_recrutement_operateur', $_POST)){
                $validationerrors['error_nom_recrutement_operateur'] = "Erreur 404:Votre nom n'existe pas";
              }

              if($_POST['code_membre_recrutement'] != ""){
                if(!filter_var($_POST['code_membre_recrutement'], FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9{19}(P)$]#")))){

                     $validationerrors['verif_code_membre_recrutement'] = "Votre code membre n'est pas valide";

                }
              }

 
              if(empty($_POST['nom_recrutement_operateur']) || $_POST['nom_recrutement_operateur'] == ""){

                 $validationerrors['empty_nom_recrutement_operateur'] = "Votre nom ne doit pas être vide";

              }

              if(!array_key_exists('prenoms_recrutement_operateur', $_POST)){

                $validationerrors['error_prenoms_recrutement_operateur'] = "Erreur 404:Votre prenoms n'existe pas";

              }
 
              if(empty($_POST['prenoms_recrutement_operateur']) || $_POST['prenoms_recrutement_operateur'] === ""){

                 $validationerrors['empty_prenoms_recrutement_operateur'] = "Votre prénoms ne doit pas être vide";

              }

              if(!array_key_exists('date_naissance_recrutement_operateur', $_POST)){

                $validationerrors['error_date_naissance_recrutement_operateur'] = "Erreur 404:Votre date de naissance n'existe pas";

              }
 
              if(empty($_POST['date_naissance_recrutement_operateur']) || $_POST['date_naissance_recrutement_operateur'] === ""){

                 $validationerrors['empty_date_naissance_recrutement_operateur'] = "Votre date de naissance ne doit pas être vide";

              }             
              
              if(!array_key_exists('lieu_naissance_recrutement_operateur', $_POST)){

                $validationerrors['error_lieu_naissance_recrutement_operateur'] = "Erreur 404:Votre date de naissance n'existe pas";
                
              }
 
              if(empty($_POST['lieu_naissance_recrutement_operateur']) || $_POST['lieu_naissance_recrutement_operateur'] === ""){
                 $validationerrors['empty_lieu_naissance_recrutement_operateur'] = "Votre lieu de naissance ne doit pas être vide";
              }
 
              if(!array_key_exists('canton_recrutement_operateur', $_POST)){
                $validationerrors['error_canton_recrutement_operateur'] = "Erreur 404:Votre canton de recrutement n'existe pas";
              }
 
              if(empty($_POST['canton_recrutement_operateur']) || $_POST['canton_recrutement_operateur'] === ""){
                 $validationerrors['empty_canton_recrutement_operateur'] = "Votre Canton de recrutement est tres important à renseigner";
              }

              if(empty($_POST['email_recrutement_operateur']) || $_POST['email_recrutement_operateur'] === ""){
                $validationerrors['empty_email_recrutement_operateur'] = "Votre email ne doit pas être vide";
              
              }

              if($_POST['email_recrutement_operateur'] !== ""){
                if(!filter_var($_POST['email_recrutement_operateur'], FILTER_VALIDATE_EMAIL)){
                  $validationerrors['error_email_recrutement_operateur'] = "Votre email est Invalide";
                }
              }

            if(empty($_POST['canton_afectation_recrutement_operateur']) || $_POST['canton_afectation_recrutement_operateur'] === ""){
                $validationerrors['empty_canton_afectation_recrutement_operateur'] = "Votre canton d'affectation n'existe pas";
            }             
             
            if(empty($_POST['formation_informatique_recrutement_operateur']) || $_POST['formation_informatique_recrutement_operateur'] === ""){
                $validationerrors['empty_formation_informatique_recrutement_operateur'] = "Votre formation en informatique doit être";
            }
            if(empty($_POST['disponible_informatique_recrutement_operateur']) || $_POST['disponible_informatique_recrutement_operateur'] === ""){
                $validationerrors['empty_disponible_informatique_recrutement_operateur'] = "Votre disponibilité est tres important à rensegner";
            }

            if(!array_key_exists('name',$cvuploadrecrutementoperateur)){
                $validationerrors['errors_cv_file_name'] = "Le nom du curriculum vitae est invalide";
            }
            if(!array_key_exists('name', $ldmuploadrecrutementoperateur)){
                $validationerrors['errors_lm_file_name'] = "Le nom du la lettre de motivation est invalide";
            }

            if(!array_key_exists('type',$cvuploadrecrutementoperateur)){
                $validationerrors['errors_typecv_file_name'] = "Le type de fichier du curriculum vitae est invalide";
            }
            if(!array_key_exists('type', $ldmuploadrecrutementoperateur)){
                $validationerrors['errors_typelm_file_name'] = "Le type du fichier de la lettre de motivation est invalide";
            }

            if(!array_key_exists('tmp_name',$cvuploadrecrutementoperateur)){
                $validationerrors['errors_tmpcv_file_name'] = "Le fichier temporaire du curriculum vitae est invalide";
            }
            if(!array_key_exists('tmp_name', $ldmuploadrecrutementoperateur)){
                $validationerrors['errors_tmplm_file_name'] = "Le fichier temporaire de la lettre de motivation est invalide";
            }

            if(!array_key_exists('size',$cvuploadrecrutementoperateur)){
                $validationerrors['errors_sizecv_file_name'] = "La taille du curriculum vitae est invalide";
            }
            if(!array_key_exists('size', $ldmuploadrecrutementoperateur)){
                $validationerrors['errors_sizelm_file_name'] = "La taille de la lettre de motivation est invalide";
            }

            if($cvuploadrecrutementoperateur['name'] == "" || empty($cvuploadrecrutementoperateur['name'])){
                 $validationerrors['empty_cvfile_name'] = "Le nom du curriculum vitae ne doit pas être vide";
            }

            if($ldmuploadrecrutementoperateur['name'] == "" || empty($ldmuploadrecrutementoperateur['name'])){
                 $validationerrors['empty_cvfile_name'] = "Le nom de la lettre de motivation ne doit pas être vide";
            }

           if($cvuploadrecrutementoperateur['type'] == "" || empty($cvuploadrecrutementoperateur['type'])){
                 $validationerrors['empty_cvtypefile_name'] = "Le type du curriculum vitae ne doit pas être vide";
            }

            if($ldmuploadrecrutementoperateur['type'] == "" || empty($ldmuploadrecrutementoperateur['type'])){
                 $validationerrors['empty_ldmtypefile_name'] = "Le type de la lettre de motivation ne doit pas être vide";
            }
 
            if($cvuploadrecrutementoperateur['size'] == "" || empty($cvuploadrecrutementoperateur['size'])){
                 $validationerrors['empty_cvtypefile_name'] = "La taille du curriculum vitae ne doit pas être vide";
            }

            if($ldmuploadrecrutementoperateur['size'] == "" || empty($ldmuploadrecrutementoperateur['size'])){
                 $validationerrors['empty_ldmtypefile_name'] = "La taille de la lettre de motivation ne doit pas être vide";
            }

            $cvextension = strtolower(pathinfo($cvuploadrecrutementoperateur['name'],PATHINFO_EXTENSION));
            $ldextension = strtolower(pathinfo($ldmuploadrecrutementoperateur['name'],PATHINFO_EXTENSION));
            
            if(!in_array($cvextension,array('pdf','jpg','png','jpeg','doc','docx'))){
                    $validationerrors['cvextensions'] = "Le curriculum est sous un format non autorisé";
            }
            if(!in_array($ldextension,array('pdf','jpg','png','jpeg','doc','docx'))){
                    $validationerrors['ldmextensions'] = "La lettre de motivation n'est pas sous un format autorisé";
            }

            if(!array_key_exists('telephone_recrutement_operateur', $_POST)){
                $validationerrors['error_telephone_recrutement_operateur'] = "Erreur 404:Votre numéro portable n'existe pas";
            }
 
              if(empty($_POST['telephone_recrutement_operateur']) || $_POST['telephone_recrutement_operateur'] === ""){
                 $validationerrors['empty_telephone_recrutement_operateur'] = "Votre numéro portable ne doit pas être vide";
              }

             if(!array_key_exists('whatsapp_recrutement_operateur', $_POST)){
                $validationerrors['error_whatsapp_recrutement_operateur'] = "Erreur 404:Votre numéro whatsapp n'existe pas";
            }
 
              if(empty($_POST['whatsapp_recrutement_operateur']) || $_POST['whatsapp_recrutement_operateur'] === ""){
                 $validationerrors['empty_whatsapp_recrutement_operateur'] = "Votre numéro whatsapp ne doit pas être vide";
              }
             if($_POST['whatsapp_recrutement_operateur'] != ""){
                if(filter_var($_POST['whatsapp_recrutement_operateur'], FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[^0-9]#")))){
                $validationerrors['verif_whatsapp_recrutement_operateur'] = "Votre numéro whatapp doit être composé seulement de chiffre";
                }
             }

            if(!empty($validationerrors)){
                $_SESSION['validationerrors'] = $validationerrors;
            }

             
          if(empty($validationerrors)){
            $db_reop_select = $dbreop->select();
            $db_reop_select->from('eu_recrutement_operateur',array('MAX(id_recrutement_operateur) as count'));
            $reop_find = $dbreop->fetchAll($db_reop_select);
            $true_reop_find = $reop_find[0]['count'] + 1;
                        
            $tmpCvFilePath = $_FILES['cv_upload_recrutement_operateur']['tmp_name'];
            $tmpMotivationFilePath = $_FILES['motivation_upload_recrutement_operateur']['tmp_name'];
            $identitefile = $_POST["nom_recrutement_operateur"]."_".$_POST['prenoms_recrutement_operateur'];
            

            $newidentitefile =  str_replace(array(' ','/','_',',', '-','@', ':', ';', '?','|','()','(',')',' " ','&', '%','^','*','+','.'),'_',$identitefile);               


            if($tmpCvFilePath != ""){ 
               $true_file_cv_recrutement =strtolower(pathinfo($_FILES['cv_upload_recrutement_operateur']['name'],PATHINFO_EXTENSION));
               
               $dir_files = $true_reop_find."_ESMC_FILES_CV_".$newidentitefile.".".$true_file_cv_recrutement;
               $src_file = "../../webfiles/pdf_recrutement_operateur/$dir_files";
               move_uploaded_file($tmpCvFilePath, $src_file);
            }

            if($tmpMotivationFilePath != ""){
                $true_file_motivation_recrutement = strtolower(pathinfo($_FILES['motivation_upload_recrutement_operateur']['name'],PATHINFO_EXTENSION));
                
                $dir_motivation_files = $true_reop_find."_ESMC_FILES_LD_".$newidentitefile.".".$true_file_motivation_recrutement;
                $src_motivation_file = "../../webfiles/pdf_recrutement_operateur/$dir_motivation_files";
                move_uploaded_file($tmpMotivationFilePath, $src_motivation_file);
                
            }

              $tab_recrutement = array(
                  'id_recrutement_operateur'=>$true_reop_find,
                  'code_membre_recrutement'=>$_POST['code_membre_recrutement_operateur'],
                  'nom_recrutement_operateur'=>$_POST['nom_recrutement_operateur'],
                  'prenoms_recrutement_operateur'=>$_POST['prenoms_recrutement_operateur'],
                  'email_recrutement_operateur'=>$_POST['email_recrutement_operateur'],                  
                  'date_naissance_recrutement_operateur'=>$_POST['date_naissance_recrutement_operateur'],
                  'lieu_naissance_recrutement_operateur'=>$_POST['lieu_naissance_recrutement_operateur'],
                  'telephone_recrutement_operateur'=>$_POST['telephone_recrutement_operateur'],
                  'email_recrutement_operateur'=>$_POST['email_recrutement_operateur'],
                  'langue_parle_recrutement_operateur'=>$_POST['langue_local_recrutement_operateur'],
                  'whatsapp_recrutement_operateur'=>$_POST['whatsapp_recrutement_operateur'],
                  'last_diplome_recrutement_operateur'=>$_POST['last_diplome_recrutement_operateur'],
                  'canton_recrutement_operateur'=>$_POST['canton_recrutement_operateur'],
                  'canton_affectation_recrutement_operateur'=>$_POST['canton_afectation_recrutement_operateur'],                  
                  'cv_recrutement_operateur'=>$dir_files,
                  'motivation_recrutement_operateur'=>$dir_motivation_files,
                  'ordinateur_disponible_recrutement_operateur'=>$_POST['confirmation_ordinateur_recrutement_operateur'],
                  'formaton_integrateur_recrutement_operateur'=>$_POST['formation_informatique_recrutement_operateur'],
                  'disponible_imediate_recrutement_operateur'=>$_POST['disponible_informatique_recrutement_operateur'],
                  'created_informatique_recrutement_operateur'=>$created->toString('yyyy-MM-dd HH:mm:ss')
              );
                            
            if($tmpCvFilePath != "" && $tmpMotivationFilePath != ""){
                    $dbreop->insert($tab_recrutement);
                    $validationpertesuccess['success_request'] = "Le formulaire a été correctement soumis";
                    $_SESSION['validationpertesuccess'] = $validationpertesuccess;
                  
            }else{
                $_SESSION['validationfilesuploaderrors'] = "L'un des fichiers (Curriculum vitae et Lettre de motivation) n'est pas correctement soumis";                
            }              
          
          }
          
        }            
        
        
    }

    public function listdesoperateursdesaisiesAction(){
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        $dbcanton = Zend_Db_Table::getDefaultAdapter();

        $dblist = Zend_Db_Table::getDefaultAdapter();
        $dbreop = new Application_Model_DbTable_EuRecrutementOperateur();
        $dbmemb = new Application_Model_DbTable_EuMembre();
        
            
        $dblistselect = "SELECT * FROM  eu_recrutement_operateur GROUP BY eu_recrutement_operateur.nom_recrutement_operateur, eu_recrutement_operateur.prenoms_recrutement_operateur ORDER BY eu_recrutement_operateur.created_informatique_recrutement_operateur";
        $dblist ->setFetchMode(Zend_Db::FETCH_OBJ);
        $listope = $dblist->query($dblistselect);
        $dblistselect_all = $listope->fetchAll();
/*
        foreach($dblistselect_all as $key => $value){ 
            $nomrecrutement = $value->nom_recrutement_operateur;
            $prenomsrecrutement = $value->prenoms_recrutement_operateur;            

            $dblisttrie = "SELECT * 
            FROM eu_membre 
            WHERE eu_membre.nom_membre = '%$nomrecrutement%' 
            AND eu_membre.prenom_membre = '%$prenomsrecrutement%'";
            $dblist->setFetchMode(Zend_Db::FETCH_OBJ);
            $listopetrie = $dblist->query($dblisttrie);
            $dblisttrie_all = $listopetrie->fetchAll();

            var_dump($dblisttrie_all);
            
        }*/

        $dbcantonselect = "SELECT * FROM  eu_canton";
        $dbcanton->setFetchMode(Zend_Db::FETCH_OBJ);
        $cantonope = $dbcanton->query($dbcantonselect);
        $dbcantonselect_all = $cantonope->fetchAll();


        $this->view->listoperateurs = $dblistselect_all;
        $this->view->cantonoperateur = $dbcantonselect_all; 
        $this->view->tabletri = 1;
        
        
    }
    
    public function listphonedesoperateursdesaisiesAction(){
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        $dbcanton = Zend_Db_Table::getDefaultAdapter();

        $dblist = Zend_Db_Table::getDefaultAdapter();
        $dbreop = new Application_Model_DbTable_EuRecrutementOperateur();
        $dbmemb = new Application_Model_DbTable_EuMembre();
                
        $dblistselect = "SELECT * FROM  eu_recrutement_operateur GROUP BY eu_recrutement_operateur.nom_recrutement_operateur, eu_recrutement_operateur.prenoms_recrutement_operateur ORDER BY eu_recrutement_operateur.created_informatique_recrutement_operateur";
        $dblist ->setFetchMode(Zend_Db::FETCH_OBJ);
        $listope = $dblist->query($dblistselect);
        $dblistselect_all = $listope->fetchAll();
        $this->view->listoperateurs = $dblistselect_all;
        
    }

    public function detaildesoperateursdesaisieAction(){
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        $id = (int)$this->_request->getParam('id');

        $dbdetail = Zend_Db_Table::getDefaultAdapter();
        $dbcanton = Zend_Db_Table::getDefaultAdapter();
        $dbcantonaffectation = Zend_Db_Table::getDefaultAdapter();

        $dbdetailselect = "SELECT * FROM  eu_recrutement_operateur WHERE eu_recrutement_operateur.id_recrutement_operateur = $id";
        $dbdetail->setFetchMode(Zend_Db::FETCH_OBJ);
        $detailope = $dbdetail->query($dbdetailselect);
        $dbdetailselect_all = $detailope->fetchAll();

        $idcanton = $dbdetailselect_all[0]->canton_recrutement_operateur;
        $dbcantonselect = "SELECT * FROM  eu_canton WHERE eu_canton.id_canton = $idcanton";
        $dbcanton->setFetchMode(Zend_Db::FETCH_OBJ);
        $cantonope = $dbcanton->query($dbcantonselect);
        $dbcantonselect_all = $cantonope->fetchAll();

        $idcantonaffectation = $dbdetailselect_all[0]->canton_affectation_recrutement_operateur;
        $dbcantonaffectationselect = "SELECT * FROM  eu_canton WHERE eu_canton.id_canton = $idcantonaffectation";
        $dbcantonaffectation->setFetchMode(Zend_Db::FETCH_OBJ);
        $cantonaffectationope = $dbcantonaffectation->query($dbcantonaffectationselect);
        $dbcantonaffectationselect_all = $cantonaffectationope->fetchAll();

        $this->view->detailoperateurs = $dbdetailselect_all; 
        $this->view->cantonoperateur = $dbcantonselect_all; 
        $this->view->cantonaffectationoperateur = $dbcantonaffectationselect_all; 
        
        
    }


}