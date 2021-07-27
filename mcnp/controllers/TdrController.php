<?php

class TdrController extends Zend_Controller_Action{

	  public function init() {
		/* Initialize action controller here */
        //include("Url.php");
	  }


  public function addtdrAction() {
    /* page tdr/addtdr - Ajout d'une tdr */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

   /* if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }*/


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_filiere']) && $_POST['id_filiere'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

/////////////////////////////////////controle code membre
if(isset($_POST['code_membre']) && $_POST['code_membre']!=""){
if(isset($_POST['code_membre']) && strlen($_POST['code_membre']) != 20) {
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/tdr/addtdradmin');
                  return;
}else{
if(substr($_POST['code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/tdr/addtdrintegrateur');
                  return;
                }
  }else if(substr($_POST['code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/tdr/addtdrintegrateur');
                  return;
                }
  }
}
}       

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = ""; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $tdr = new Application_Model_EuTdr();
                 $m_tdr = new Application_Model_EuTdrMapper();

                 $id_tdr = $m_tdr->findConuter() + 1;

                 $tdr->setId_tdr($id_tdr);
                 $tdr->setId_filiere($_POST['id_filiere']);
                 $tdr->setLibelle($_POST['libelle']);
                 $tdr->setCode_membre($_POST['code_membre']);
                 $tdr->setDescription($_POST['description']);
                 $tdr->setFichier($fichier);
                 $tdr->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $tdr->setId_utilisateur($sessionmembre->id_utilisateur);
                 $tdr->setValid(0);
                 $tdr->setEtat(1);
                 $m_tdr->save($tdr);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/addtdr');

        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionmembre->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembre->error = "Champs * obligatoire";
      }
    }
  }



  public function edittdrAction() {
    /* page tdr/addtdr - Ajout d'une tdr */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_filiere']) && $_POST['id_filiere'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = $_POST['fichierold']; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $tdr = new Application_Model_EuTdr();
                 $m_tdr = new Application_Model_EuTdrMapper();
                 //$m_tdr->find($_POST['id_tdr'], $tdr);

                 //$tdr->setId_tdr($id_tdr);
                 $tdr->setId_filiere($_POST['id_filiere']);
                 $tdr->setLibelle($_POST['libelle']);
                 //$tdr->setCode_membre($_POST['code_membre']);
                 $tdr->setDescription($_POST['description']);
                 $tdr->setFichier($fichier);
                 //$tdr->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$tdr->setId_utilisateur($sessionmembre->id_utilisateur);
                 //$tdr->setValid(0);
                 //$tdr->setEtat(1);
                 $m_tdr->update($tdr);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/listtdr');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembre->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr = new Application_Model_EuTdr();
               $mtdr = new Application_Model_EuTdrMapper();
           $mtdr->find($id,$tdr);
           $this->view->tdr = $tdr;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr = new Application_Model_EuTdr();
               $mtdr = new Application_Model_EuTdrMapper();
           $mtdr->find($id,$tdr);
           $this->view->tdr = $tdr;
       }   
     }

  }


  




  public function listtdrAction() {
    /* page tdr/listtdr - liste des tdrs */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $tdr = new Application_Model_EuTdrMapper();
    $this->view->entries = $tdr->fetchAllByCodeMembreFiliereUtilisateurValidEtat($sessionmembre->code_membre, 0, 0, 0, 0);

    $this->view->tabletri = 1;
  }
  
  


    public function etattdrAction()
    {
        /* page tdr/etattdr - Etat une tdr */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr = new Application_Model_EuTdr();
        $tdrM = new Application_Model_EuTdrMapper();
        $tdrM->find($id, $tdr);
    
        $tdr->setEtat($this->_request->getParam('etat'));
    $tdrM->update($tdr);
        }

    $this->_redirect('/tdr/listtdr');
    }



  public function detailtdrAction()
  {
    /* page espacepersonnel/detailtdr - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTdr();
    $ma = new Application_Model_EuTdrMapper();
    $ma->find($id, $a);
    $this->view->tdr = $a;
      }

  }








  public function supptdrAction()
  {
    /* page tdr/supptdr - Suppression d'une tdr */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

      $tdrM = new Application_Model_EuTdrMapper();
      $tdrM->delete($id);
    }

    $this->_redirect('/tdr/listtdr');
  }






  public function addtdradminAction() {
    /* page tdr/addtdrintegrateur - Ajout d'une tdr */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
/*
      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}
*/
    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_filiere']) && $_POST['id_filiere'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

/////////////////////////////////////controle code membre
if(isset($_POST['code_membre']) && $_POST['code_membre']!=""){
if(isset($_POST['code_membre']) && strlen($_POST['code_membre']) != 20) {
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/tdr/addtdradmin');
                  return;
}else{
if(substr($_POST['code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/tdr/addtdrintegrateur');
                  return;
                }
  }else if(substr($_POST['code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/tdr/addtdrintegrateur');
                  return;
                }
  }
}
}       

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = ""; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $tdr = new Application_Model_EuTdr();
                 $m_tdr = new Application_Model_EuTdrMapper();

                 $id_tdr = $m_tdr->findConuter() + 1;

                 $tdr->setId_tdr($id_tdr);
                 $tdr->setId_filiere($_POST['id_filiere']);
                 $tdr->setLibelle($_POST['libelle']);
                 $tdr->setCode_membre($_POST['code_membre']);
                 $tdr->setDescription($_POST['description']);
                 $tdr->setFichier($fichier);
                 $tdr->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $tdr->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 $tdr->setValid(0);
                 $tdr->setEtat(1);
                 $m_tdr->save($tdr);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/addtdradmin');

        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionutilisateur->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
      }
    }
  }




  public function edittdradminAction() {
    /* page tdr/addtdr - Ajout d'une tdr */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_filiere']) && $_POST['id_filiere'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = $_POST['fichierold']; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $tdr = new Application_Model_EuTdr();
                 $m_tdr = new Application_Model_EuTdrMapper();
                 //$m_tdr->find($_POST['id_tdr'], $tdr);

                 //$tdr->setId_tdr($id_tdr);
                 $tdr->setId_filiere($_POST['id_filiere']);
                 $tdr->setLibelle($_POST['libelle']);
                 //$tdr->setCode_membre($_POST['code_membre']);
                 $tdr->setDescription($_POST['description']);
                 $tdr->setFichier($fichier);
                 //$tdr->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$tdr->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 //$tdr->setValid(0);
                 //$tdr->setEtat(1);
                 $m_tdr->update($tdr);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/listtdradmin');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr = new Application_Model_EuTdr();
               $mtdr = new Application_Model_EuTdrMapper();
           $mtdr->find($id,$tdr);
           $this->view->tdr = $tdr;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr = new Application_Model_EuTdr();
               $mtdr = new Application_Model_EuTdrMapper();
           $mtdr->find($id,$tdr);
           $this->view->tdr = $tdr;
       }   
     }

  }


  




  public function listtdradminAction() {
    /* page tdr/listtdr - liste des tdrs */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $tdr = new Application_Model_EuTdrMapper();
    $this->view->entries = $tdr->fetchAll();
    //$this->view->entries = $tdr->fetchAllByCodeMembreFiliereUtilisateurValidEtat("", 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  


    public function etattdradminAction()
    {
        /* page tdr/etattdr - Etat une tdr */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr = new Application_Model_EuTdr();
        $tdrM = new Application_Model_EuTdrMapper();
        $tdrM->find($id, $tdr);
    
        $tdr->setEtat($this->_request->getParam('etat'));
    $tdrM->update($tdr);
        }

    $this->_redirect('/tdr/listtdradmin');
    }



  public function detailtdradminAction()
  {
    /* page espacepersonnel/detailtdr - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTdr();
    $ma = new Application_Model_EuTdrMapper();
    $ma->find($id, $a);
    $this->view->tdr = $a;
      }

  }





    public function validtdradminAction()
    {
        /* page tdr/validtdr - Valid une tdr */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr = new Application_Model_EuTdr();
        $tdrM = new Application_Model_EuTdrMapper();
        $tdrM->find($id, $tdr);
    
        $tdr->setValid($this->_request->getParam('valid'));
    $tdrM->update($tdr);
        }

    $this->_redirect('/tdr/listtdradmin');
    }





    public function listacteurcreneauAction()
    {
        /* page attribution/listattributionutilisateur - Liste de attribution_utilisateur_formulaire */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {
        $acteurcreneau = new Application_Model_EuActeurCreneauMapper();
        $this->view->entries = $acteurcreneau->fetchAllByFiliere($id);
        }else{
    $this->_redirect('/tdr/listtdradmin');
        }

        $this->view->tabletri = 1;

    }







  public function addtdrddepropoadminAction() {
    /* page tdr/addtdrintegrateur - Ajout d'une tdr_dde_propo */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_tdr']) && $_POST['id_tdr'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['type_dde_propo']) && $_POST['type_dde_propo'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

      

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = ""; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $tdr_dde_propo = new Application_Model_EuTdrDdePropo();
                 $m_tdr_dde_propo = new Application_Model_EuTdrDdePropoMapper();

                 $id_tdr_dde_propo = $m_tdr_dde_propo->findConuter() + 1;

                 $tdr_dde_propo->setId_tdr_dde_propo($id_tdr_dde_propo);
                 $tdr_dde_propo->setId_tdr($_POST['id_tdr']);
                 $tdr_dde_propo->setLibelle($_POST['libelle']);
                 $tdr_dde_propo->setType_dde_propo($_POST['type_dde_propo']);
                 $tdr_dde_propo->setDescription($_POST['description']);
                 $tdr_dde_propo->setFichier($fichier);
                 $tdr_dde_propo->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $tdr_dde_propo->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 $tdr_dde_propo->setValid(0);
                 $tdr_dde_propo->setEtat(1);
                 $m_tdr_dde_propo->save($tdr_dde_propo);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/addtdrddepropoadmin');

        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionutilisateur->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
      }
    }
  }




  public function edittdrddepropoadminAction() {
    /* page tdr/addtdr_dde_propo - Ajout d'une tdr_dde_propo */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_tdr']) && $_POST['id_tdr'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['type_dde_propo']) && $_POST['type_dde_propo'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = $_POST['fichierold']; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $tdr_dde_propo = new Application_Model_EuTdrDdePropo();
                 $m_tdr_dde_propo = new Application_Model_EuTdrDdePropoMapper();
                 //$m_tdr_dde_propo->find($_POST['id_tdr_dde_propo'], $tdr_dde_propo);

                 //$tdr_dde_propo->setId_tdr_dde_propo($id_tdr_dde_propo);
                 $tdr_dde_propo->setId_tdr($_POST['id_tdr']);
                 $tdr_dde_propo->setLibelle($_POST['libelle']);
                 $tdr_dde_propo->setType_dde_propo($_POST['type_dde_propo']);
                 $tdr_dde_propo->setDescription($_POST['description']);
                 $tdr_dde_propo->setFichier($fichier);
                 //$tdr_dde_propo->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$tdr_dde_propo->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 //$tdr_dde_propo->setValid(0);
                 //$tdr_dde_propo->setEtat(1);
                 $m_tdr_dde_propo->update($tdr_dde_propo);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/listtdrddepropoadmin');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr_dde_propo = new Application_Model_EuTdrDdePropo();
               $mtdr_dde_propo = new Application_Model_EuTdrDdePropoMapper();
           $mtdr_dde_propo->find($id,$tdr_dde_propo);
           $this->view->tdr_dde_propo = $tdr_dde_propo;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr_dde_propo = new Application_Model_EuTdrDdePropo();
               $mtdr_dde_propo = new Application_Model_EuTdrDdePropoMapper();
           $mtdr_dde_propo->find($id,$tdr_dde_propo);
           $this->view->tdr_dde_propo = $tdr_dde_propo;
       }   
     }

  }


  




  public function listtdrddepropoadminAction() {
    /* page tdr/listtdr_dde_propo - liste des tdr_dde_propos */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $tdr_dde_propo = new Application_Model_EuTdrDdePropoMapper();
    $this->view->entries = $tdr_dde_propo->fetchAll();
    //$this->view->entries = $tdr_dde_propo->fetchAllByTypeDdePropoTdrUtilisateurValidEtat(0, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etattdrddepropoadminAction()
    {
        /* page tdr/etattdr_dde_propo - Etat une tdr_dde_propo */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr_dde_propo = new Application_Model_EuTdrDdePropo();
        $tdr_dde_propoM = new Application_Model_EuTdrDdePropoMapper();
        $tdr_dde_propoM->find($id, $tdr_dde_propo);
    
        $tdr_dde_propo->setEtat($this->_request->getParam('etat'));
    $tdr_dde_propoM->update($tdr_dde_propo);
        }

    $this->_redirect('/tdr/listtdrddepropoadmin');
    }



  public function detailtdrddepropoadminAction()
  {
    /* page espacepersonnel/detailtdr_dde_propo - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTdrDdePropo();
    $ma = new Application_Model_EuTdrDdePropoMapper();
    $ma->find($id, $a);
    $this->view->tdr_dde_propo = $a;
      }

  }





    public function validtdrddepropoadminAction()
    {
        /* page tdr/validtdr_dde_propo - Valid une tdr_dde_propo */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr_dde_propo = new Application_Model_EuTdrDdePropo();
        $tdr_dde_propoM = new Application_Model_EuTdrDdePropoMapper();
        $tdr_dde_propoM->find($id, $tdr_dde_propo);
    
        $tdr_dde_propo->setValid($this->_request->getParam('valid'));
    $tdr_dde_propoM->update($tdr_dde_propo);
        }

    $this->_redirect('/tdr/listtdrddepropoadmin');
    }





  public function listtdrddepropoAction() {
    /* page tdr/listtdr_dde_propo - liste des tdr_dde_propos */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    $tdr_dde_propo = new Application_Model_EuTdrDdePropoMapper();
    //$this->view->entries = $tdr_dde_propo->fetchAll();
    $this->view->entries = $tdr_dde_propo->fetchAllByFiliere($sessionmembre->id_filiere);

    $this->view->tabletri = 1;
  }
  
  


  public function detailtdrddepropoAction()
  {
    /* page espacepersonnel/detailtdr_dde_propo - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTdrDdePropo();
    $ma = new Application_Model_EuTdrDdePropoMapper();
    $ma->find($id, $a);
    $this->view->tdr_dde_propo = $a;
      }

  }










  public function addtdrpropoAction() {
    /* page tdr/addtdrintegrateur - Ajout d'une tdr_propo */
    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_tdr']) && $_POST['id_tdr'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['type_propo']) && $_POST['type_propo'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

      

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = ""; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $tdr_propo = new Application_Model_EuTdrPropo();
                 $m_tdr_propo = new Application_Model_EuTdrPropoMapper();

                 $id_tdr_propo = $m_tdr_propo->findConuter() + 1;

                 $tdr_propo->setId_tdr_propo($id_tdr_propo);
                 $tdr_propo->setId_tdr($_POST['id_tdr']);
                 $tdr_propo->setLibelle($_POST['libelle']);
                 $tdr_propo->setType_propo($_POST['type_propo']);
                 $tdr_propo->setDescription($_POST['description']);
                 $tdr_propo->setFichier($fichier);
                 $tdr_propo->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $tdr_propo->setCode_membre($sessionmembre->code_membre);
                 $tdr_propo->setId_utilisateur($sessionmembre->id_utilisateur);
                 $tdr_propo->setValid(0);
                 $tdr_propo->setEtat(1);
                 $m_tdr_propo->save($tdr_propo);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/addtdrpropo');

        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionmembre->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembre->error = "Champs * obligatoire";
      }
    }
  }




  public function edittdrpropoAction() {
    /* page tdr/addtdr_propo - Ajout d'une tdr_propo */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_tdr']) && $_POST['id_tdr'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['type_propo']) && $_POST['type_propo'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = $_POST['fichierold']; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $tdr_propo = new Application_Model_EuTdrPropo();
                 $m_tdr_propo = new Application_Model_EuTdrPropoMapper();
                 //$m_tdr_propo->find($_POST['id_tdr_propo'], $tdr_propo);

                 //$tdr_propo->setId_tdr_propo($id_tdr_propo);
                 $tdr_propo->setId_tdr($_POST['id_tdr']);
                 $tdr_propo->setLibelle($_POST['libelle']);
                 $tdr_propo->setType_propo($_POST['type_propo']);
                 $tdr_propo->setDescription($_POST['description']);
                 $tdr_propo->setFichier($fichier);
                 //$tdr_propo->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$tdr_propo->setCode_membre($sessionmembre->code_membre);
                 //$tdr_propo->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 //$tdr_propo->setValid(0);
                 //$tdr_propo->setEtat(1);
                 $m_tdr_propo->update($tdr_propo);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/listtdrpropo');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionmembre->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembre->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr_propo = new Application_Model_EuTdrPropo();
               $mtdr_propo = new Application_Model_EuTdrPropoMapper();
           $mtdr_propo->find($id,$tdr_propo);
           $this->view->tdr_propo = $tdr_propo;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr_propo = new Application_Model_EuTdrPropo();
               $mtdr_propo = new Application_Model_EuTdrPropoMapper();
           $mtdr_propo->find($id,$tdr_propo);
           $this->view->tdr_propo = $tdr_propo;
       }   
     }

  }


  




  public function listtdrpropoAction() {
    /* page tdr/listtdr_propo - liste des tdr_propos */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

    $tdr_propo = new Application_Model_EuTdrPropoMapper();
    $this->view->entries = $tdr_propo->fetchAll();
    //$this->view->entries = $tdr_propo->fetchAllByTypeDdePropoTdrUtilisateurValidEtat(0, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etattdrpropoAction()
    {
        /* page tdr/etattdr_propo - Etat une tdr_propo */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr_propo = new Application_Model_EuTdrPropo();
        $tdr_propoM = new Application_Model_EuTdrPropoMapper();
        $tdr_propoM->find($id, $tdr_propo);
    
        $tdr_propo->setEtat($this->_request->getParam('etat'));
    $tdr_propoM->update($tdr_propo);
        }

    $this->_redirect('/tdr/listtdrpropo');
    }



  public function detailtdrpropoAction()
  {
    /* page espacepersonnel/detailtdr_propo - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTdrPropo();
    $ma = new Application_Model_EuTdrPropoMapper();
    $ma->find($id, $a);
    $this->view->tdr_propo = $a;
      }

  }





    public function validtdrpropoadminAction()
    {
        /* page tdr/validtdr_propo - Valid une tdr_propo */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr_propo = new Application_Model_EuTdrPropo();
        $tdr_propoM = new Application_Model_EuTdrPropoMapper();
        $tdr_propoM->find($id, $tdr_propo);
    
        $tdr_propo->setValid($this->_request->getParam('valid'));
    $tdr_propoM->update($tdr_propo);
        }

    $this->_redirect('/tdr/listtdrpropoadmin');
    }





  public function listtdrpropoadminAction() {
    /* page tdr/listtdr_propo - liste des tdr_propos */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    $tdr_propo = new Application_Model_EuTdrPropoMapper();
    $this->view->entries = $tdr_propo->fetchAll();
    //$this->view->entries = $tdr_propo->fetchAllByFiliere($sessionmembre->id_filiere);

    $this->view->tabletri = 1;
  }
  


  public function detailtdrpropoadminAction()
  {
    /* page espacepersonnel/detailtdr_propo - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTdrPropo();
    $ma = new Application_Model_EuTdrPropoMapper();
    $ma->find($id, $a);
    $this->view->tdr_propo = $a;
      }

  }











  public function addtdrpvadminAction() {
    /* page tdr/addtdrintegrateur - Ajout d'une tdr_pv */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_tdr']) && $_POST['id_tdr'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['montant_retenu']) && $_POST['montant_retenu'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

      

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = ""; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $tdr_pv = new Application_Model_EuTdrPv();
                 $m_tdr_pv = new Application_Model_EuTdrPvMapper();

                 $id_tdr_pv = $m_tdr_pv->findConuter() + 1;

                 $tdr_pv->setId_tdr_pv($id_tdr_pv);
                 $tdr_pv->setId_tdr($_POST['id_tdr']);
                 $tdr_pv->setLibelle($_POST['libelle']);
                 $tdr_pv->setCode_membre($_POST['code_membre']);
                 $tdr_pv->setDescription($_POST['description']);
                 $tdr_pv->setFichier($fichier);
                 $tdr_pv->setMontant_retenu($_POST['montant_retenu']);
                 $tdr_pv->setMontant_revu($_POST['montant_revu']);
                 $tdr_pv->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $tdr_pv->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 $tdr_pv->setValid(0);
                 $tdr_pv->setEtat(1);
                 $m_tdr_pv->save($tdr_pv);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/addtdrpvadmin');

        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionutilisateur->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
      }
    }
  }




  public function edittdrpvadminAction() {
    /* page tdr/addtdr_pv - Ajout d'une tdr_pv */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_tdr']) && $_POST['id_tdr'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['montant_retenu']) && $_POST['montant_retenu'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

            include("Transfert.php");

           if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"] != "") {
                  $chemin  = "tdrs";
                  $file    = $_FILES["fichier"]["name"];
                  $file1   = "fichier";
                  $fichier = $chemin."/".transfert($chemin,$file1);
               } else { $fichier = $_POST['fichierold']; }

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $tdr_pv = new Application_Model_EuTdrPv();
                 $m_tdr_pv = new Application_Model_EuTdrPvMapper();
                 //$m_tdr_pv->find($_POST['id_tdr_pv'], $tdr_pv);

                 //$tdr_pv->setId_tdr_pv($id_tdr_pv);
                 $tdr_pv->setId_tdr($_POST['id_tdr']);
                 $tdr_pv->setLibelle($_POST['libelle']);
                 $tdr_pv->setCode_membre($_POST['code_membre']);
                 $tdr_pv->setDescription($_POST['description']);
                 $tdr_pv->setFichier($fichier);
                 $tdr_pv->setMontant_retenu($_POST['montant_retenu']);
                 $tdr_pv->setMontant_revu($_POST['montant_revu']);
                 //$tdr_pv->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$tdr_pv->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 //$tdr_pv->setValid(0);
                 //$tdr_pv->setEtat(1);
                 $m_tdr_pv->update($tdr_pv);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/tdr/listtdrpvadmin');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionutilisateur->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr_pv = new Application_Model_EuTdrPv();
               $mtdr_pv = new Application_Model_EuTdrPvMapper();
           $mtdr_pv->find($id,$tdr_pv);
           $this->view->tdr_pv = $tdr_pv;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $tdr_pv = new Application_Model_EuTdrPv();
               $mtdr_pv = new Application_Model_EuTdrPvMapper();
           $mtdr_pv->find($id,$tdr_pv);
           $this->view->tdr_pv = $tdr_pv;
       }   
     }

  }


  




  public function listtdrpvadminAction() {
    /* page tdr/listtdr_pv - liste des tdr_pvs */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $tdr_pv = new Application_Model_EuTdrPvMapper();
    $this->view->entries = $tdr_pv->fetchAll();
    //$this->view->entries = $tdr_pv->fetchAllByTypeDdePropoTdrUtilisateurValidEtat(0, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etattdrpvadminAction()
    {
        /* page tdr/etattdr_pv - Etat une tdr_pv */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr_pv = new Application_Model_EuTdrPv();
        $tdr_pvM = new Application_Model_EuTdrPvMapper();
        $tdr_pvM->find($id, $tdr_pv);
    
        $tdr_pv->setEtat($this->_request->getParam('etat'));
    $tdr_pvM->update($tdr_pv);
        }

    $this->_redirect('/tdr/listtdrpvadmin');
    }



  public function detailtdrpvadminAction()
  {
    /* page espacepersonnel/detailtdr_pv - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTdrPv();
    $ma = new Application_Model_EuTdrPvMapper();
    $ma->find($id, $a);
    $this->view->tdr_pv = $a;
      }

  }





    public function validtdrpvadminAction()
    {
        /* page tdr/validtdr_pv - Valid une tdr_pv */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr_pv = new Application_Model_EuTdrPv();
        $tdr_pvM = new Application_Model_EuTdrPvMapper();
        $tdr_pvM->find($id, $tdr_pv);
    
        $tdr_pv->setValid($this->_request->getParam('valid'));
    $tdr_pvM->update($tdr_pv);
        }

    $this->_redirect('/tdr/listtdrpvadmin');
    }





  public function listtdrpvAction() {
    /* page tdr/listtdr_pv - liste des tdr_pvs */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    $tdr_pv = new Application_Model_EuTdrPvMapper();
    //$this->view->entries = $tdr_pv->fetchAll();
    $this->view->entries = $tdr_pv->fetchAllByCodeMembreTdrUtilisateurValidEtat($sessionmembre->code_membre, 0, 0, 0, 0);

    $this->view->tabletri = 1;
  }
  
  


  public function detailtdrpvAction()
  {
    /* page espacepersonnel/detailtdr_pv - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTdrPv();
    $ma = new Application_Model_EuTdrPvMapper();
    $ma->find($id, $a);
    $this->view->tdr_pv = $a;
      }

  }







  
  public  function addeliadminAction()  {
      /* page contratlivraison/addcontrat - Ajout contrat */
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
      
    $request = $this->getRequest();
    if($request->isPost()) {
           if(isset($_POST['libelle_eli']) && $_POST['libelle_eli']!="" && isset($_POST['id_tdr']) && $_POST['id_tdr']!="")  {
        
        $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction(); 
              try {

                   $eli = new Application_Model_EuEli();
                   $m_eli = new Application_Model_EuEliMapper();
          
           $detaileli = new Application_Model_EuDetailEli();
                   $m_detaileli = new Application_Model_EuDetailEliMapper();

           $montant_eli = 0;
                                 
           for($i = 0; $i < count($_POST['prix_unitaire']); $i++) {
           if($_POST['prix_unitaire'][$i] > 0 && $_POST['quantite'][$i] > 0) {
              $montant_eli = $montant_eli + ($_POST['prix_unitaire'][$i] * $_POST['quantite'][$i]);
           } else {
            $db->rollback();
                        $this->view->error = "Veuillez revoir votre saisie ... ";
                        return;           
           }
           }
           
           
           
           $date_id = Zend_Date::now();
           $codeeli = "";
           $numero_eli = "";
           $codeeli = strtoupper(Util_Utils::genererCodeSMS(6));
           $numero_eli = "ELI-".$codeeli;
           
           /*
           do {
                      $codeeli = strtoupper(Util_Utils::genererCodeSMS(6));
            $numero_eli = "ELI-".$codeeli;
                      $eli_mapper = new Application_Model_EuEliMapper();
                      $eli2 = $eli_mapper->findByNumero($numero_eli);
                   }while(count($eli2) > 0);
           */
           
           //$eli->setCode_membre($code_membre);
           $eli->setNumero_eli($numero_eli);
                   $eli->setLibelle_eli($_POST['libelle_eli']);
                   $eli->setDate_eli($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                   //$eli->setBai($bai);
                   //$eli->setMontant_bai($montant_bai);
               //$eli->setBan($ban);
               //$eli->setMontant_ban($montant_ban);
               //$eli->setOpi($opi);
               //$eli->setMontant_opi($montant_opi);
               $eli->setMontant_eli($montant_eli);
           //$eli->setCode_tegc($code_tegc);
               $eli->setValider(NULL);
           $eli->setRejeter(NULL);
               $eli->setPayer(NULL);
          
             $eli->setUtilisateur($sessionutilisateur->id_utilisateur);
             //$eli->setId_canton($membremoral->id_canton);
               $eli->setId_tdr($_POST['id_tdr']);
           $eli->setPropose(1);
           $m_eli->save($eli);
           
           $id_eli = $db->lastInsertId();
           
           for($i = 0; $i < count($_POST['prix_unitaire']); $i++) {
              $detaileli->setId_eli($id_eli);
            $detaileli->setType_bps($_POST['type_bps'][$i]);
            $detaileli->setLibelle_produit($_POST['libelle_produit'][$i]);
            $detaileli->setMontant_produit($_POST['quantite'][$i] * $_POST['prix_unitaire'][$i]);
            $detaileli->setQuantite($_POST['quantite'][$i]);
            $detaileli->setPrix_unitaire($_POST['prix_unitaire'][$i]);
            $detaileli->setStatut(0);
            $m_detaileli->save($detaileli); 
           }
          
           $db->commit();
           $sessionutilisateur->error = "Opération bien effectuée ...";
           $this->_redirect('/tdr/listeliadmin');
        
        } catch(Exception $exc) {          
          $db->rollback();
                  $sessionutilisateur->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                  return;
        }

            } else {
                $sessionutilisateur->error = "Veuillez renseigner les champs obligatoires (*)";
        return;
      }

        }  
      
  }
  




  
  public  function editeliadminAction()  {
      /* page contratlivraison/addcontrat - Ajout contrat */
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
      
    $request = $this->getRequest();
    if($request->isPost()) {
           if(isset($_POST['libelle_eli']) && $_POST['libelle_eli']!="" && isset($_POST['id_tdr']) && $_POST['id_tdr']!="")  {
        
        $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction(); 
              try {
           $membremoral = new Application_Model_EuMembreMorale();
                   $m_mapmoral = new Application_Model_EuMembreMoraleMapper();

                   $eli = new Application_Model_EuEli();
                   $m_eli = new Application_Model_EuEliMapper();
          
           $detaileli = new Application_Model_EuDetailEli();
                   $m_detaileli = new Application_Model_EuDetailEliMapper();

                   $code_membre = $sessionmembre->code_membre;
           $libelle_eli = $request->getParam("libelle_eli");
           //$id_canton = $request->getParam("id_canton");

                   $db_convention = new Application_Model_DbTable_EuConvention();
           $db_franchise = new Application_Model_DbTable_EuFranchise();
           $db_convention_eli = new Application_Model_DbTable_EuConventionEliOpi();
           $db_avr = new Application_Model_DbTable_EuFormAvr();
           
           $bai = 0;
                   $ban = 0;
                   $opi = 0;  

                   $montant_bai = 0;
                   $montant_ban = 0;
                   $montant_opi = 0;
           $montant_eli = 0;
           
           $findmembre = $m_mapmoral->find($code_membre,$membremoral);
           if($findmembre == false) {
              $db->rollback();
                      $this->view->error = "Le code membre du fournisseur  ".$code_membre."  est introuvable ...";
                      return;
           }
          
           if($membremoral->desactiver == 1) {
            $db->rollback();
            $this->view->error = "Ce fournisseur dont le code membre que voici  ".$code_membre."  n'est pas autorisé à effectuer cette opération ...";
            return;
           }
           
           $select = $db_convention->select();
           $select->where('code_membre like  ?', $code_membre);
           $rowsconvention = $db_convention->fetchRow($select);
          
           if(count($rowsconvention) == 0) {
            $db->rollback();
                      $this->view->error = "Veuillez impérativement lire et approuver la convention de collaboration ... ";
                      return;
           }
           
           $select = $db_franchise->select();
           $select->where('code_membre_franchise like  ?', $code_membre);
           $rowsfranchise = $db_franchise->fetchRow($select);
          
           if(count($rowsfranchise) == 0) {
            $db->rollback();
                      $this->view->error = "Veuillez impérativement lire et approuver notre document de franchise ... ";
                      return;
           }
           
           $select = $db_convention_eli->select();
           $select->where('code_membre like  ?', $code_membre);
           $rowseli = $db_convention_eli->fetchRow($select);
          
           if(count($rowseli) == 0) {
            $db->rollback();
                      $this->view->error = "Veuillez impérativement lire et approuver notre document d'Engagement de Livraison Irrévocable ... ";
                      return;
           }
           
           $select = $db_avr->select();
           $select->where('code_membre_avr like  ?', $code_membre);
           $rowsavr = $db_avr->fetchRow($select);
          
           if(count($rowsavr) == 0) {
            $db->rollback();
                      $this->view->error = "Veuillez impérativement valider notre formulaire d'Achat Vente Réciproque ... ";
                      return;
           }
           
           
           for($i = 0; $i < count($_POST['prix_unitaire']); $i++) {
           if($_POST['prix_unitaire'][$i] > 0 && $_POST['quantite'][$i] > 0) {
              $montant_eli = $montant_eli + ($_POST['prix_unitaire'][$i] * $_POST['quantite'][$i]);
           } else {
            $db->rollback();
                        $this->view->error = "Veuillez revoir votre saisie ... ";
                        return;           
           }
           }
           
           if(isset($_POST['bai']) && $_POST['bai'] == 1)  {
                     $bai = 1;            
           $montant_bai = $request->getParam("montant_bai");
           if($montant_bai <= 0) {
            $db->rollback();
                        $this->view->error = "Montant BAi mal saisi ... ".$montant_bai;
                        return; 
           }
           }
           
           if(isset($_POST['ban']) && $_POST['ban'] == 1)  {
                     $ban = 1;            
           $montant_ban = $request->getParam("montant_ban");
           if($montant_ban <= 0) {
            $db->rollback();
                        $this->view->error = "Montant BAn mal saisi ... ".$montant_ban;
                        return; 
           }
           }
           
           if(isset($_POST['opi']) && $_POST['opi'] == 1)  {
                     $opi = 1;            
           $montant_opi = $request->getParam("montant_opi");
           if($montant_opi <= 0) {
            $db->rollback();
                        $this->view->error = "Montant Opi mal saisi ... ".$montant_opi;
                        return; 
           }
           }
           
           if((isset($_POST['opi']) && $_POST['opi'] == 1) || (isset($_POST['ban']) && $_POST['ban'] == 1) || (isset($_POST['bai']) && $_POST['bai'] == 1))  {
           
           if(($montant_bai + $montant_ban + $montant_opi) != $montant_eli) {
            $db->rollback();
                      $this->view->error = "Le montant du mode de règlement n'est pas conforme au montant total des produits ...";
                      return;           
           }
           
           }
           
           $date_id = Zend_Date::now();
           $codeeli = "";
           $numero_eli = "";
           $codeeli = strtoupper(Util_Utils::genererCodeSMS(6));
           $numero_eli = "ELI-".$codeeli;
           
           /*
           do {
                      $codeeli = strtoupper(Util_Utils::genererCodeSMS(6));
            $numero_eli = "ELI-".$codeeli;
                      $eli_mapper = new Application_Model_EuEliMapper();
                      $eli2 = $eli_mapper->findByNumero($numero_eli);
                   }while(count($eli2) > 0);
           */
           
           $eli->setCode_membre($code_membre);
           $eli->setNumero_eli($numero_eli);
                   $eli->setLibelle_eli($libelle_eli);
                   $eli->setDate_eli($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                   $eli->setBai($bai);
                   $eli->setMontant_bai($montant_bai);
               $eli->setBan($ban);
               $eli->setMontant_ban($montant_ban);
               $eli->setOpi($opi);
               $eli->setMontant_opi($montant_opi);
               $eli->setMontant_eli($montant_eli);
           $eli->setCode_tegc($code_tegc);
               $eli->setValider(0);
           $eli->setRejeter(0);
               $eli->setPayer(0);
          
             $eli->setUtilisateur(NULL);
             $eli->setId_canton($membremoral->id_canton);
           $m_eli->save($eli);
           
           $id_eli = $db->lastInsertId();
           
           for($i = 0; $i < count($_POST['prix_unitaire']); $i++) {
              $detaileli->setId_eli($id_eli);
            $detaileli->setType_bps($_POST['type_bps'][$i]);
            $detaileli->setLibelle_produit($_POST['libelle_produit'][$i]);
            $detaileli->setMontant_produit($_POST['quantite'][$i] * $_POST['prix_unitaire'][$i]);
            $detaileli->setQuantite($_POST['quantite'][$i]);
            $detaileli->setPrix_unitaire($_POST['prix_unitaire'][$i]);
            $detaileli->setStatut(1);
            $m_detaileli->save($detaileli); 
           }
          
           $db->commit();
           $sessionmembre->error = "Opération bien effectuée ...";
           $this->_redirect('/contratlivraison/listdemandeelicontracte');
        
        } catch(Exception $exc) {          
          $db->rollback();
                  $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                  return;
        }

            } else {
                $this->view->error = "Veuillez renseigner les champs obligatoires (*)";
        return;
      }

        }  
      
  }



  public  function detaileliadminAction() {
    ini_set('memory_limit', '1024M');
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
    if(!isset($sessionutilisateur->login)) { $this->_redirect('/administration/login'); }
        if($sessionutilisateur->confirmation != "") { $this->_redirect('/administration/confirmation'); }
    
    $id = $this->_request->getParam('id');
    $eli = new Application_Model_EuEli();
    $m_eli = new Application_Model_EuEliMapper();
    
    $deli = new Application_Model_EuDetailEli();
    $m_deli = new Application_Model_EuDetailEliMapper();
    
    $m_eli->find($id,$eli);
    $entries = $m_deli->fetchAllByEli($id);
      
    $this->view->eli = $eli;  
    $this->view->entries = $entries;
  }


  public  function detaileliAction() {
    ini_set('memory_limit', '1024M');
    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');
    
    if(!isset($sessionmembre->code_membre)) {
           $this->_redirect('/');
        }
    
    $id = $this->_request->getParam('id');
    $eli = new Application_Model_EuEli();
    $m_eli = new Application_Model_EuEliMapper();
    
    $deli = new Application_Model_EuDetailEli();
    $m_deli = new Application_Model_EuDetailEliMapper();
    
    $m_eli->find($id,$eli);
    $entries = $m_deli->fetchAllByEli($id);
      
    $this->view->eli = $eli;  
    $this->view->entries = $entries;
  }
  



  
  public  function listeliadminAction()  {
    ini_set('memory_limit', '1024M');
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
    if(!isset($sessionutilisateur->login)) { $this->_redirect('/administration/login'); }
        if($sessionutilisateur->confirmation != "") { $this->_redirect('/administration/confirmation'); }
      
      
    $eli_mapper = new Application_Model_EuEliMapper();
    $entries = $eli_mapper->findByPropose(1);
    $this->view->entries = $entries;
  }
  

  
  public  function listelitdrAction()  {
    ini_set('memory_limit', '1024M');
    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');
    
    if(!isset($sessionmembre->code_membre)) {
           $this->_redirect('/');
        }
      
    $eli_mapper = new Application_Model_EuEliMapper();
    $entries = $eli_mapper->findByMembrePropose($sessionmembre->code_membre);
    $this->view->entries = $entries;
  }
  



    public function valideliadminAction()
    {
        /* page tdr/validtdr_pv - Valid une tdr_pv */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $tdr_pv = new Application_Model_EuTdrPv();
        $tdr_pvM = new Application_Model_EuTdrPvMapper();
        $tdr_pvM->find($id, $tdr_pv);
    
        $tdr_pv->setValid($this->_request->getParam('valid'));
    $tdr_pvM->update($tdr_pv);
        }

    $this->_redirect('/tdr/listtdrpvadmin');
    }




}
