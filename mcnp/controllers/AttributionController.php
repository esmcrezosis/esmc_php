<?php

class AttributionController extends Zend_Controller_Action{


    public function init() {
		/* Initialize action controller here */
        //include("Url.php");
	  }
      




    public function addprocedureAction()
    {
        /* page attribution/addprocedure - Ajout d'une procedure */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['procedure_description']) && $_POST['procedure_description']!="" && isset($_POST['procedure_nom']) && $_POST['procedure_nom']!="" && isset($_POST['procedure_type']) && $_POST['procedure_type']!="" && isset($_POST['procedure_libelle']) && $_POST['procedure_libelle']!="") {
        
        include("Transfert.php");
        if(isset($_FILES['procedure_url']['name']) && $_FILES['procedure_url']['name']!=""){
        $chemin = "procedures";
        $file = $_FILES['procedure_url']['name'];
        $file1='procedure_url';
        $procedure = $chemin."/".transfert($chemin,$file1);
        } else {$procedure = "";}
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuProcedure();
        $ma = new Application_Model_EuProcedureMapper();
            
            $compteur = $ma->findConuter() + 1;
            $a->setProcedure_id($compteur);
            $a->setProcedure_description($_POST['procedure_description']);
            $a->setProcedure_nom($_POST['procedure_nom']);
            $a->setProcedure_libelle($_POST['procedure_libelle']);
            $a->setProcedure_url($procedure);
            $a->setProcedure_type($_POST['procedure_type']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
            
        //$this->_redirect('/attribution/listprocedure/id/'.$_POST['procedure_type']);
        $this->_redirect('/attribution/addprocedure');
        } else {  $this->view->error = "Champs * obligatoire ...";  } 
        }
        
    }


    public function editprocedureAction()
    {
        /* page attribution/editprocedure - Modification d'une procedure */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['procedure_description']) && $_POST['procedure_description']!="" && isset($_POST['procedure_nom']) && $_POST['procedure_nom']!="" && isset($_POST['procedure_type']) && $_POST['procedure_type']!="" && isset($_POST['procedure_libelle']) && $_POST['procedure_libelle']!="") {
        
        include("Transfert.php");
        if(isset($_FILES['procedure_url']['name']) && $_FILES['procedure_url']['name']!=""){
        $chemin = "procedures";
        $file = $_FILES['procedure_url']['name'];
        $file1='procedure_url';
        $procedure = $chemin."/".transfert($chemin,$file1);
        } else {$procedure = $_POST['procedure_url_old'];}
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuProcedure();
        $ma = new Application_Model_EuProcedureMapper();
        $ma->find($_POST['procedure_id'], $a);
            
            $a->setProcedure_description($_POST['procedure_description']);
            $a->setProcedure_nom($_POST['procedure_nom']);
            $a->setProcedure_libelle($_POST['procedure_libelle']);
            $a->setProcedure_type($_POST['procedure_type']);
            $a->setProcedure_url($procedure);
            $ma->update($a);
            
        $this->_redirect('/attribution/listprocedure/id/'.$_POST['procedure_type']);
        } else {  $this->view->error = "Champs * obligatoire ..."; 
         
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuProcedure();
        $ma = new Application_Model_EuProcedureMapper();
        $ma->find($id, $a);
        $this->view->procedure = $a;
            }
    }
           
    } else {


            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuProcedure();
        $ma = new Application_Model_EuProcedureMapper();
        $ma->find($id, $a);
        $this->view->procedure = $a;
            }
    }
    }




    public function listprocedureAction()
    {
        /* page attribution/listprocedure - Liste des procedures */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $procedure = new Application_Model_EuProcedureMapper();
        $this->view->entries = $procedure->fetchAllByType($id);

        $a = new Application_Model_EuProcedureType();
        $ma = new Application_Model_EuProcedureTypeMapper();
        $ma->find($id, $a);
        $this->view->procedure_type = $a;

}
        $this->view->tabletri = 1;

    }



    public function suppprocedureAction()
    {
        /* page attribution/suppprocedure - Suppression d'une procedure */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $procedure = new Application_Model_EuProcedure();
        $procedureM = new Application_Model_EuProcedureMapper();
        $procedureM->find($id, $procedure);
        
        $procedureM->delete($procedure->procedure_id);
        //unlink($procedure->procedure_url);    

        }

        $this->_redirect('/attribution/listprocedure');
    }


    public function detailsprocedureAction() 
    {
        /* page attribution/detailsprocedure - Detail d'une procedure */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $procedure = new Application_Model_EuProcedure();
        $procedureM = new Application_Model_EuProcedureMapper();
        $procedureM->find($id, $procedure);
        $this->view->procedure = $procedure;


        $a = new Application_Model_EuProcedureType();
        $ma = new Application_Model_EuProcedureTypeMapper();
        $ma->find($procedure->procedure_type, $a);
        $this->view->procedure_type = $a;

            }

    }


    public function publierprocedureAction()
    {
        /* page attribution/publierprocedure - Publier une procedure */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $procedure = new Application_Model_EuProcedure();
        $procedureM = new Application_Model_EuProcedureMapper();
        $procedureM->find($id, $procedure);
        
        $procedure->setPublier($this->_request->getParam('publier'));
        $procedureM->update($procedure);
        }

        $this->_redirect('/attribution/listprocedure/id/'.$procedure->procedure_type);
    }










    public function addformulaireAction()
    {
        /* page attribution/addformulaire - Ajout d'une formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['formulaire_description']) && $_POST['formulaire_description']!="" && isset($_POST['formulaire_nom']) && $_POST['formulaire_nom']!="" && isset($_POST['formulaire_procedure']) && $_POST['formulaire_procedure']!="" && isset($_POST['formulaire_libelle']) && $_POST['formulaire_libelle']!="") {
        
        include("Transfert.php");
        if(isset($_FILES['formulaire_url']['name']) && $_FILES['formulaire_url']['name']!=""){
        $chemin = "formulaires";
        $file = $_FILES['formulaire_url']['name'];
        $file1='formulaire_url';
        $formulaire = $chemin."/".transfert($chemin,$file1);
        } else {$formulaire = "";}
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFormulaire();
        $ma = new Application_Model_EuFormulaireMapper();
            
            $compteur = $ma->findConuter() + 1;
            $a->setFormulaire_id($compteur);
            $a->setFormulaire_description($_POST['formulaire_description']);
            $a->setFormulaire_nom($_POST['formulaire_nom']);
            $a->setFormulaire_libelle($_POST['formulaire_libelle']);
            $a->setFormulaire_url($formulaire);
            $a->setFormulaire_procedure($_POST['formulaire_procedure']);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
            
        $this->_redirect('/attribution/addformulaire');
        } else {  $this->view->error = "Champs * obligatoire ...";  } 
        }
        
    }


    public function editformulaireAction()
    {
        /* page attribution/editformulaire - Modification d'une formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['formulaire_description']) && $_POST['formulaire_description']!="" && isset($_POST['formulaire_nom']) && $_POST['formulaire_nom']!="" && isset($_POST['formulaire_procedure']) && $_POST['formulaire_procedure']!="" && isset($_POST['formulaire_libelle']) && $_POST['formulaire_libelle']!="") {
        
        include("Transfert.php");
        if(isset($_FILES['formulaire_url']['name']) && $_FILES['formulaire_url']['name']!=""){
        $chemin = "formulaires";
        $file = $_FILES['formulaire_url']['name'];
        $file1='formulaire_url';
        $formulaire = $chemin."/".transfert($chemin,$file1);
        } else {$formulaire = $_POST['formulaire_url_old'];}
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFormulaire();
        $ma = new Application_Model_EuFormulaireMapper();
        $ma->find($_POST['formulaire_id'], $a);
            
            $a->setFormulaire_description($_POST['formulaire_description']);
            $a->setFormulaire_nom($_POST['formulaire_nom']);
            $a->setFormulaire_libelle($_POST['formulaire_libelle']);
            $a->setFormulaire_procedure($_POST['formulaire_procedure']);
            $a->setFormulaire_url($formulaire);
            $ma->update($a);
            
        $this->_redirect('/attribution/listformulaire');
        } else {  $this->view->error = "Champs * obligatoire ..."; 
         
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFormulaire();
        $ma = new Application_Model_EuFormulaireMapper();
        $ma->find($id, $a);
        $this->view->formulaire = $a;
            }
    }
           
    } else {


            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFormulaire();
        $ma = new Application_Model_EuFormulaireMapper();
        $ma->find($id, $a);
        $this->view->formulaire = $a;
            }
    }
    }




    public function listformulaireAction()
    {
        /* page attribution/listformulaire - Liste des formulaires */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $formulaire = new Application_Model_EuFormulaireMapper();
        $this->view->entries = $formulaire->fetchAll();

        $this->view->tabletri = 1;

    }



    public function suppformulaireAction()
    {
        /* page attribution/suppformulaire - Suppression d'une formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $formulaire = new Application_Model_EuFormulaire();
        $formulaireM = new Application_Model_EuFormulaireMapper();
        $formulaireM->find($id, $formulaire);
        
        $formulaireM->delete($formulaire->formulaire_id);
        //unlink($formulaire->formulaire_url);    

        }

        $this->_redirect('/attribution/listformulaire');
    }


    public function detailsformulaireAction() 
    {
        /* page attribution/detailsformulaire - Detail d'une formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $formulaire = new Application_Model_EuFormulaire();
        $formulaireM = new Application_Model_EuFormulaireMapper();
        $formulaireM->find($id, $formulaire);
        $this->view->formulaire = $formulaire;

            }

    }


    public function publierformulaireAction()
    {
        /* page attribution/publierformulaire - Publier une formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $formulaire = new Application_Model_EuFormulaire();
        $formulaireM = new Application_Model_EuFormulaireMapper();
        $formulaireM->find($id, $formulaire);
        
        $formulaire->setPublier($this->_request->getParam('publier'));
        $formulaireM->update($formulaire);
        }

        $this->_redirect('/attribution/listformulaire');
    }












    public function addattributionAction()
    {
        /* page attribution/addattribution - Ajout de attribution */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['centrale_id']) && $_POST['centrale_id']!="" && isset($_POST['procedure_id']) && $_POST['procedure_id'] !="" && isset($_POST['formulaire_id']) && $_POST['formulaire_id'] !="" && isset($_POST['code_groupe']) && $_POST['code_groupe'] !="") {
        
                    $attribution_procedure_formulaire_mapper = new Application_Model_EuAttributionProcedureFormulaireMapper();
                    $attribution_procedure_formulaire = new Application_Model_EuAttributionProcedureFormulaire();
                    
                            $attribution_procedure_formulaire_compteur = $attribution_procedure_formulaire_mapper->findConuter() + 1;                 
                    
                            $attribution_procedure_formulaire->setAttribution_procedure_formulaire_id($attribution_procedure_formulaire_compteur)
                               ->setCentrale_id($_POST['centrale_id'])
                               ->setProcedure_id($_POST['procedure_id'])
                               ->setFormulaire_id($_POST['formulaire_id'])
                               ->setCode_groupe($_POST['code_groupe'])
                               ->setEtat(1)
                               ;
                            $attribution_procedure_formulaire_mapper->save($attribution_procedure_formulaire);
            

        $this->_redirect('/attribution/addattribution');
        } else {  $this->view->error = "Champs * obligatoire ...";  } 
        }
        
    }


    public function listattributionAction()
    {
        /* page attribution/listattribution - Liste de attribution_procedure_formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $attribution_procedure_formulaire = new Application_Model_EuAttributionProcedureFormulaireMapper();
        $this->view->entries = $attribution_procedure_formulaire->fetchAll();

        $this->view->tabletri = 1;

    }



    public function suppattributionAction()
    {
        /* page attribution/suppattribution - Suppression de attribution_procedure_formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $attribution_procedure_formulaire = new Application_Model_EuAttributionProcedureFormulaire();
        $attribution_procedure_formulaireM = new Application_Model_EuAttributionProcedureFormulaireMapper();
        $attribution_procedure_formulaireM->find($id, $attribution_procedure_formulaire);
        
        $attribution_procedure_formulaireM->delete($attribution_procedure_formulaire->attribution_procedure_formulaire_id);

        }

        $this->_redirect('/attribution/listattribution');
    }



    public function etatattributionAction()
    {
        /* page attribution/etatattribution - Publier une attribution */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $attribution = new Application_Model_EuAttributionProcedureFormulaire();
        $attributionM = new Application_Model_EuAttributionProcedureFormulaireMapper();
        $attributionM->find($id, $attribution);
        
        $attribution->setEtat($this->_request->getParam('etat'));
        $attributionM->update($attribution);
        }

        $this->_redirect('/attribution/listattribution');
    }




      
     public function newAction()  {
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
         
         $userin = new Application_Model_EuUtilisateur();
         $mapper = new Application_Model_EuUtilisateurMapper();
         
         $membre = new Application_Model_EuMembre();
         $m_membre = new Application_Model_EuMembreMapper();
         
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
         
         $t_section = new Application_Model_DbTable_EuSection();
         $section = $t_section->fetchAll();
         $this->view->section = $section;

         $t_groupe = new Application_Model_DbTable_EuUserGroup();
         $select = $t_groupe->select();
         $select->where('code_groupe_parent = ?',$sessionutilisateur->code_groupe);
         $select->order('libelle_groupe asc');
         $groupe = $t_groupe->fetchAll($select);
         $this->view->groupe = $groupe;


         
         $request = $this->getRequest();
         if($request->isPost())  {
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $find_user = $mapper->findLogin($request->getParam("login"));
                $utilisateur = new Application_Model_EuUtilisateur();
                $trouve_user = $mapper->find($sessionutilisateur->id_utilisateur,$utilisateur);
                $nom = $request->getParam("nom");
                $prenom = $request->getParam("prenom");
                $login = $request->getParam("login");
                $pwd = $request->getParam("pwd");
                $pwd1 = $request->getParam("pwd1");
                $code_membre = $request->getParam("code_membre");
                $id_pays = $request->getParam("id_pays");
                $id_canton = $request->getParam("id_canton");
                //$code_tegc = $request->getParam("code_tegc");
                $role = $request->getParam("role");
                $section = $request->getParam("section");
                $date_id = Zend_Date::now();
                
                $findmembre = $m_membre->find($code_membre,$membre);
                
                if($find_user != false) {
                    $db->rollback();
                    $error = 'Ce login existe déjà.';
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
                } elseif ($pwd != $pwd1) {
                    $db->rollback();
                    $error = 'Erreur de confirmation du mot de passe.';
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
                } elseif (stripos($login, " ") !== false) {
                    $db->rollback();
                    $error = "Le Login ne doit pas contenir d'espace";
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
                } elseif($findmembre == false) {
                    $db->rollback();
                    $error = "Le code membre de l'utilisateur  ".$code_membre."  est introuvable ...";
                    $this->view->error = $error;
                    $this->view->nom = $request->getParam("nom");
                    $this->view->prenom = $request->getParam("prenom");
                    $this->view->login = $request->getParam("login");
                    return;
                }
               
                //insertion dans la table eu_utilisateur
                $id_user = $mapper->findConuter() + 1;
                $userin->setId_utilisateur($id_user);
                $userin->setId_utilisateur_parent($sessionutilisateur->id_utilisateur); 
                $userin->setPrenom_utilisateur($prenom);
                $userin->setNom_utilisateur($nom);
                $userin->setLogin(trim($login));
                $userin->setPwd(md5($pwd));
                $userin->setDescription(null);
                $userin->setUlock(0);
                $userin->setCh_pwd_flog(0);
                $userin->setCode_groupe($request->getParam("code_groupe"));
                $userin->setConnecte(0);
                $userin->setCode_agence($sessionutilisateur->code_agence);
                             
                $userin->setCode_secteur($utilisateur->code_secteur);
                $userin->setCode_zone($utilisateur->code_zone);
                        
                $userin->setId_filiere($utilisateur->id_filiere);
               
                $userin->setCode_acteur($utilisateur->code_acteur);    
                $userin->setCode_gac_filiere(null);
                if($sessionutilisateur->code_groupe != "" || $sessionutilisateur->code_groupe != NULL) {
                  $userin->setCode_groupe_create($sessionutilisateur->code_groupe);
                } else {
                  $userin->setCode_groupe_create("personne_physique");
                }
               
                $userin->setCode_membre($code_membre);
               
                $userin->setId_pays($id_pays);
                $userin->setId_canton($id_canton);
                //$userin->setCode_tegc($code_tegc);             
                $userin->setSection($section);
                $userin->setRole($role);
                $mapper->save($userin);

                  
                $db->commit();
                $sessionutilisateur->errorlogin = "Operation bien effectuee ...";
                $this->_redirect('/attribution/listuser');
         
            } catch (Exception $exc) {                 
                 $db->rollback();
                 $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
            }
         
         }
      
      
      }
      




    public function editAction() {
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
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
         
         $t_section = new Application_Model_DbTable_EuSection();
         $section = $t_section->fetchAll();
         $this->view->section = $section;
       

         $t_groupe = new Application_Model_DbTable_EuUserGroup();
         $select = $t_groupe->select();
         $select->where('code_groupe_parent = ?',$sessionutilisateur->code_groupe);
         $select->order('libelle_groupe asc');
         $groupe = $t_groupe->fetchAll($select);
         $this->view->groupe = $groupe;


       $userin = new Application_Model_EuUtilisateur();
       $mapper = new Application_Model_EuUtilisateurMapper();
       
       $membre = new Application_Model_EuMembre();
       $m_membre = new Application_Model_EuMembreMapper();
       
       $request = $this->getRequest();
       if($request->isPost ())  {
          $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try {
              $find_user = $mapper->findNoLogin($request->getParam("login"),$request->getParam("id_utilisateur"));
              $utilisateur = new Application_Model_EuUtilisateur();
              //$trouve_user = $mapper->find($sessionutilisateur->id_utilisateur,$utilisateur);
              $nom = $request->getParam("nom");
              $prenom = $request->getParam("prenom");
              $login = $request->getParam("login");
              $pwdold = $request->getParam("pwdold");
              $pwd = $request->getParam("pwd");
              $pwd1 = $request->getParam("pwd1");
              $id_pays = $request->getParam("id_pays");
              $id_canton = $request->getParam("id_canton");
              $id_user = $request->getParam("id_utilisateur");
              //$code_tegc = $request->getParam("code_tegc");
              $code_membre = $request->getParam("code_membre");
              $role = $request->getParam("role");
              $section = $request->getParam("section");
              $findmembre = $m_membre->find($code_membre,$membre);
              
              $mapper->find($id_user,$utilisateur);
              
              if($find_user != false) {
                 $db->rollback();
                 $error = 'Ce login existe déjà.';
                 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
              } elseif($utilisateur->pwd != md5($pwdold)) {
                 $db->rollback();
                 $error = 'Ancien mot de passe non conforme.';
                 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;          
              }   
              elseif ($pwd != $pwd1) {
                 $db->rollback();
                 $error = 'Erreur de confirmation du mot de passe.';
                 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
              } 
              elseif (stripos($login, " ") !== false) {
                 $db->rollback();
                 $error = "Le Login ne doit pas contenir d'espace";
                 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
              } elseif($findmembre == false) {
                 $db->rollback();
                 $error = "Le code membre de l'utilisateur  ".$code_membre."  est introuvable ...";
                 $this->view->error = $error;
                 $this->view->user = $utilisateur;
                 return;
              }

              //insertion dans la table eu_utilisateur
              //$id_user = $mapper->findConuter() + 1;
               $mapper->find($id_user,$userin);
               $userin->setId_utilisateur_parent($sessionutilisateur->id_utilisateur); 
               $userin->setPrenom_utilisateur($prenom);
               $userin->setNom_utilisateur($nom);
               $userin->setLogin(trim($login));
               $userin->setPwd(md5($pwd));
               $userin->setDescription(null);
               $userin->setUlock(0);
               $userin->setCh_pwd_flog(1);
               $userin->setCode_groupe($request->getParam("code_groupe"));
               $userin->setConnecte(0);
               $userin->setCode_agence($sessionutilisateur->code_agence);             
               $userin->setCode_secteur($utilisateur->code_secteur);
               $userin->setCode_zone($utilisateur->code_zone);      
               $userin->setId_filiere($utilisateur->id_filiere);
               $userin->setCode_acteur($utilisateur->code_acteur);     
               $userin->setCode_gac_filiere(null);
               $userin->setCode_groupe_create($sessionutilisateur->code_groupe);
               $userin->setCode_membre($code_membre);
               $userin->setId_pays($id_pays);
               $userin->setId_canton($id_canton);
               //$userin->setCode_tegc($code_tegc);              
               $userin->setSection($section);
               $userin->setRole($role);
               $mapper->update($userin);                    
               $db->commit();
               
               $sessionutilisateur->errorlogin = "Modification bien effectuee ...";
               $this->_redirect('/attribution/listuser');
                  
          } catch (Exception $exc) {                   
               $db->rollback();
               $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
               return;
          }
       
       } else {
           $id = $this->_request->getParam('id');
           $user   = new Application_Model_EuUtilisateur();
           $m_user = new Application_Model_EuUtilisateurMapper();
       
           $m_user->find($id,$user);
           $this->view->user = $user;
       }
    
    
    }



      
      public function listuserAction()  {
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
           
           $tabela = new Application_Model_DbTable_EuUtilisateur();
           $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false);
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$sessionutilisateur->id_utilisateur);
           //$select->where('eu_utilisateur.code_membre = ?',$sessionutilisateur->code_membre);
           //$select->where('eu_user_group.code_groupe = ?','cnp_tegcp');
           $select->order('id_utilisateur desc');
           
           $users = $tabela->fetchAll($select);
           
           $this->view->entries = $users;
      
      
      
      }
      




























    public function addattributionutilisateurAction()
    {
        /* page attribution/addattributionutilisateur - Ajout de attribution utilisateur*/

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['centrale_id']) && $_POST['centrale_id']!="" && isset($_POST['procedure_id']) && $_POST['procedure_id'] !="" && isset($_POST['formulaire_id']) && $_POST['formulaire_id'] !="" && isset($_POST['id_utilisateur']) && $_POST['id_utilisateur'] !="") {
        
                    $attribution_utilisateur_formulaire_mapper = new Application_Model_EuAttributionUtilisateurFormulaireMapper();
                    $attribution_utilisateur_formulaire = new Application_Model_EuAttributionUtilisateurFormulaire();
                    
                            $attribution_utilisateur_formulaire_compteur = $attribution_utilisateur_formulaire_mapper->findConuter() + 1;                 
                    
                            $attribution_utilisateur_formulaire->setAttribution_utilisateur_formulaire_id($attribution_utilisateur_formulaire_compteur)
                               ->setCentrale_id($_POST['centrale_id'])
                               ->setProcedure_id($_POST['procedure_id'])
                               ->setFormulaire_id($_POST['formulaire_id'])
                               ->setId_utilisateur($_POST['id_utilisateur'])
                               ->setEtat(1)
                               ;
                            $attribution_utilisateur_formulaire_mapper->save($attribution_utilisateur_formulaire);
            

        $this->_redirect('/attribution/addattributionutilisateur');
        } else {  $this->view->error = "Champs * obligatoire ...";  } 
        }
        
    }


    public function editattributionutilisateurAction()
    {
        /* page attribution/addattributionutilisateur - Ajout de attribution utilisateur*/

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['centrale_id']) && $_POST['centrale_id']!="" && isset($_POST['procedure_id']) && $_POST['procedure_id'] !="" && isset($_POST['formulaire_id']) && $_POST['formulaire_id'] !="" && isset($_POST['id_utilisateur']) && $_POST['id_utilisateur'] !="") {
        
    $attribution_utilisateur_formulaire = new Application_Model_EuAttributionUtilisateurFormulaire();
    $attribution_utilisateur_formulaire_mapper = new Application_Model_EuAttributionUtilisateurFormulaireMapper();
    $attribution_utilisateur_formulaire_mapper->find($_POST['attribution_utilisateur_formulaire_id'], $attribution_utilisateur_formulaire);
                
    //$attribution_utilisateur_formulaire_compteur = $attribution_utilisateur_formulaire_mapper->findConuter() + 1;                 
                    
                            //$attribution_utilisateur_formulaire->setAttribution_utilisateur_formulaire_id($attribution_utilisateur_formulaire_compteur)
    $attribution_utilisateur_formulaire->setCentrale_id($_POST['centrale_id'])
                               ->setProcedure_id($_POST['procedure_id'])
                               ->setFormulaire_id($_POST['formulaire_id'])
                               ->setId_utilisateur($_POST['id_utilisateur'])
                               ->setEtat(1)
                               ;
                            $attribution_utilisateur_formulaire_mapper->update($attribution_utilisateur_formulaire);
            

        $this->_redirect('/attribution/listattributionutilisateur');
        } else {  $this->view->error = "Champs * obligatoire ...";     
         
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAttributionUtilisateurFormulaire();
        $ma = new Application_Model_EuAttributionUtilisateurFormulaireMapper();
        $ma->find($id, $a);
        $this->view->attribution_utilisateur_formulaire = $a;
            }
    }
           
    } else {


            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAttributionUtilisateurFormulaire();
        $ma = new Application_Model_EuAttributionUtilisateurFormulaireMapper();
        $ma->find($id, $a);
        $this->view->attribution_utilisateur_formulaire = $a;
            }
    }
    }


    public function listattributionutilisateurAction()
    {
        /* page attribution/listattributionutilisateur - Liste de attribution_utilisateur_formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $attribution_utilisateur_formulaire = new Application_Model_EuAttributionUtilisateurFormulaireMapper();
        $this->view->entries = $attribution_utilisateur_formulaire->fetchAll();

        $this->view->tabletri = 1;

    }



    public function suppattributionutilisateurAction()
    {
        /* page attribution/suppattributionutilisateur - Suppression de attribution_utilisateur_formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $attribution_utilisateur_formulaire = new Application_Model_EuAttributionUtilisateurFormulaire();
        $attribution_utilisateur_formulaireM = new Application_Model_EuAttributionUtilisateurFormulaireMapper();
        $attribution_utilisateur_formulaireM->find($id, $attribution_utilisateur_formulaire);
        
        $attribution_utilisateur_formulaireM->delete($attribution_utilisateur_formulaire->attribution_utilisateur_formulaire_id);

        }

        $this->_redirect('/attribution/listattributionutilisateur');
    }



    public function etatattributionutilisateurAction()
    {
        /* page attribution/etatattributionutilisateur - Publier une attribution utilisateur*/

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $attribution = new Application_Model_EuAttributionUtilisateurFormulaire();
        $attributionM = new Application_Model_EuAttributionUtilisateurFormulaireMapper();
        $attributionM->find($id, $attribution);
        
        $attribution->setEtat($this->_request->getParam('etat'));
        $attributionM->update($attribution);
        }

        $this->_redirect('/attribution/listattributionutilisateur');
    }






    

    public function addattributionusergroupAction()
    {
        /* page attribution/addattributionusergroup - Ajout de attributionusergroup */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['code_groupe_depart']) && $_POST['code_groupe_depart']!="" && isset($_POST['code_groupe_arrivee']) && $_POST['code_groupe_arrivee'] !="" && isset($_POST['formulaire_id']) && $_POST['formulaire_id'] !="") {
        
                    $attribution_user_group_formulaire_mapper = new Application_Model_EuAttributionUserGroupFormulaireMapper();
                    $attribution_user_group_formulaire = new Application_Model_EuAttributionUserGroupFormulaire();
                    
                            $attribution_user_group_formulaire_compteur = $attribution_user_group_formulaire_mapper->findConuter() + 1;                 
                    
                            $attribution_user_group_formulaire->setAttribution_user_group_formulaire_id($attribution_user_group_formulaire_compteur)
                               ->setCode_groupe_depart($_POST['code_groupe_depart'])
                               ->setCode_groupe_arrivee($_POST['code_groupe_arrivee'])
                               ->setFormulaire_id($_POST['formulaire_id'])
                               ->setCode_groupe_autre($_POST['code_groupe_autre'])
                               ->setEtat(1)
                               ;
                            $attribution_user_group_formulaire_mapper->save($attribution_user_group_formulaire);
            

        $this->_redirect('/attribution/addattributionusergroup');
        } else {  $this->view->error = "Champs * obligatoire ...";  } 
        }
        
    }


    public function editattributionusergroupAction()
    {
        /* page attribution/addattributionusergroup - Ajout de attributionusergroup */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['code_groupe_depart']) && $_POST['code_groupe_depart']!="" && isset($_POST['code_groupe_arrivee']) && $_POST['code_groupe_arrivee'] !="" && isset($_POST['formulaire_id']) && $_POST['formulaire_id'] !="") {
        
        $attribution_user_group_formulaire = new Application_Model_EuAttributionUserGroupFormulaire();
        $attribution_user_group_formulaire_mapper = new Application_Model_EuAttributionUserGroupFormulaireMapper();
        $attribution_user_group_formulaire_mapper->find($_POST['attribution_user_group_formulaire_id'], $attribution_user_group_formulaire);
                    
        //$attribution_user_group_formulaire_compteur = $attribution_user_group_formulaire_mapper->findConuter() + 1;                 
                    
                            //->setAttribution_user_group_formulaire_id($attribution_user_group_formulaire_compteur)
        $attribution_user_group_formulaire->setCode_groupe_depart($_POST['code_groupe_depart'])
                               ->setCode_groupe_arrivee($_POST['code_groupe_arrivee'])
                               ->setFormulaire_id($_POST['formulaire_id'])
                               ->setCode_groupe_autre($_POST['code_groupe_autre'])
                               //->setEtat(1)
                               ;
                            $attribution_user_group_formulaire_mapper->update($attribution_user_group_formulaire);
            

        $this->_redirect('/attribution/listattributionusergroup');
        } else {  $this->view->error = "Champs * obligatoire ...";   
         
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAttributionUserGroupFormulaire();
        $ma = new Application_Model_EuAttributionUserGroupFormulaireMapper();
        $ma->find($id, $a);
        $this->view->attribution_user_group_formulaire = $a;
            }
    }
           
    } else {


            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuAttributionUserGroupFormulaire();
        $ma = new Application_Model_EuAttributionUserGroupFormulaireMapper();
        $ma->find($id, $a);
        $this->view->attribution_user_group_formulaire = $a;
            }
    }
    }

    public function listattributionusergroupAction()
    {
        /* page attribution/listattributionusergroup - Liste de attribution_user_group_formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $attribution_user_group_formulaire = new Application_Model_EuAttributionUserGroupFormulaireMapper();
        $this->view->entries = $attribution_user_group_formulaire->fetchAll();

        $this->view->tabletri = 1;

    }



    public function suppattributionusergroupAction()
    {
        /* page attribution/suppattributionusergroup - Suppression de attribution_user_group_formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $attribution_user_group_formulaire = new Application_Model_EuAttributionUserGroupFormulaire();
        $attribution_user_group_formulaireM = new Application_Model_EuAttributionUserGroupFormulaireMapper();
        $attribution_user_group_formulaireM->find($id, $attribution_user_group_formulaire);
        
        $attribution_user_group_formulaireM->delete($attribution_user_group_formulaire->attribution_user_group_formulaire_id);

        }

        $this->_redirect('/attribution/listattributionusergroup');
    }



    public function etatattributionusergroupAction()
    {
        /* page attribution/etatattributionusergroup - Publier une attributionusergroup */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $attribution = new Application_Model_EuAttributionUserGroupFormulaire();
        $attributionM = new Application_Model_EuAttributionUserGroupFormulaireMapper();
        $attributionM->find($id, $attribution);
        
        $attribution->setEtat($this->_request->getParam('etat'));
        $attributionM->update($attribution);
        }

        $this->_redirect('/attribution/listattributionusergroup');
    }







    public function listvalidtdrAction()
    {
        /* page attribution/listvalidtdr - Liste de validtdr */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $valid_tdr = new Application_Model_EuValidTdrMapper();
        $this->view->entries = $valid_tdr->fetchAll();

        $this->view->tabletri = 1;

    }
























}
