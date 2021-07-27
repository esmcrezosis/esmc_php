<?php

class LettreRelanceController extends Zend_Controller_Action{

	  public function init() {
		/* Initialize action controller here */
        //include("Url.php");
	  }





  public function addlettrerelanceadminAction() {
    /* page lettrerelance/addtdrintegrateur - Ajout d'une lettre_relance */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_eli']) && $_POST['id_eli'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['code_membre']) && $_POST['code_membre'] != "") {
         
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
                 $lettre_relance = new Application_Model_EuLettreRelance();
                 $m_lettre_relance = new Application_Model_EuLettreRelanceMapper();

                 $id_lettre_relance = $m_lettre_relance->findConuter() + 1;

                 $lettre_relance->setId_lettre_relance($id_lettre_relance);
                 $lettre_relance->setId_eli($_POST['id_eli']);
                 $lettre_relance->setLibelle($_POST['libelle']);
                 $lettre_relance->setType_lettre(1);
                 $lettre_relance->setCode_membre($_POST['code_membre']);
                 $lettre_relance->setDescription($_POST['description']);
                 $lettre_relance->setFichier($fichier);
                 $lettre_relance->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $lettre_relance->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 $lettre_relance->setValid(0);
                 $lettre_relance->setEtat(1);
                 $m_lettre_relance->save($lettre_relance);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/lettrerelance/addlettrerelanceadmin');

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




  public function editlettrerelanceadminAction() {
    /* page lettrerelance/addlettre_relance - Ajout d'une lettre_relance */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_eli']) && $_POST['id_eli'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['code_membre']) && $_POST['code_membre'] != "") {
         
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

                 $lettre_relance = new Application_Model_EuLettreRelance();
                 $m_lettre_relance = new Application_Model_EuLettreRelanceMapper();
                 //$m_lettre_relance->find($_POST['id_lettre_relance'], $lettre_relance);

                 //$lettre_relance->setId_lettre_relance($id_lettre_relance);
                 $lettre_relance->setId_eli($_POST['id_eli']);
                 $lettre_relance->setLibelle($_POST['libelle']);
                 $lettre_relance->setCode_membre($_POST['code_membre']);
                 $lettre_relance->setType_lettre(1);
                 $lettre_relance->setDescription($_POST['description']);
                 $lettre_relance->setFichier($fichier);
                 //$lettre_relance->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$lettre_relance->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 //$lettre_relance->setValid(0);
                 //$lettre_relance->setEtat(1);
                 $m_lettre_relance->update($lettre_relance);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/lettrerelance/listlettrerelanceadmin');
         
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
               $lettre_relance = new Application_Model_EuLettreRelance();
               $mlettre_relance = new Application_Model_EuLettreRelanceMapper();
           $mlettre_relance->find($id,$lettre_relance);
           $this->view->lettre_relance = $lettre_relance;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $lettre_relance = new Application_Model_EuLettreRelance();
               $mlettre_relance = new Application_Model_EuLettreRelanceMapper();
           $mlettre_relance->find($id,$lettre_relance);
           $this->view->lettre_relance = $lettre_relance;
       }   
     }

  }


  




  public function listlettrerelanceadminAction() {
    /* page lettrerelance/listlettre_relance - liste des lettre_relances */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $lettre_relance = new Application_Model_EuLettreRelanceMapper();
    //$this->view->entries = $lettre_relance->fetchAll();
    $this->view->entries = $lettre_relance->fetchAllByCodeMembreTypeEliUtilisateurValidEtat("", 1, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etatlettrerelanceadminAction()
    {
        /* page lettrerelance/etatlettre_relance - Etat une lettre_relance */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $lettre_relance = new Application_Model_EuLettreRelance();
        $lettre_relanceM = new Application_Model_EuLettreRelanceMapper();
        $lettre_relanceM->find($id, $lettre_relance);
    
        $lettre_relance->setEtat($this->_request->getParam('etat'));
    $lettre_relanceM->update($lettre_relance);
        }

    $this->_redirect('/lettrerelance/listlettrerelanceadmin');
    }



  public function detaillettrerelanceadminAction()
  {
    /* page espacepersonnel/detaillettre_relance - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuLettreRelance();
    $ma = new Application_Model_EuLettreRelanceMapper();
    $ma->find($id, $a);
    $this->view->lettre_relance = $a;
      }

  }





    public function validlettrerelanceadminAction()
    {
        /* page lettrerelance/validlettre_relance - Valid une lettre_relance */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $lettre_relance = new Application_Model_EuLettreRelance();
        $lettre_relanceM = new Application_Model_EuLettreRelanceMapper();
        $lettre_relanceM->find($id, $lettre_relance);
    
        $lettre_relance->setValid($this->_request->getParam('valid'));
    $lettre_relanceM->update($lettre_relance);
        }

    $this->_redirect('/lettrerelance/listlettrerelanceadmin');
    }





  public function listlettrerelanceAction() {
    /* page lettrerelance/listlettre_relance - liste des lettre_relances */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    $lettre_relance = new Application_Model_EuLettreRelanceMapper();
    //$this->view->entries = $lettre_relance->fetchAll();
    $this->view->entries = $lettre_relance->fetchAllByCodeMembreTypeEliUtilisateurValidEtat($sessionmembre->code_membre, 1, 0, 0, 0, 0);

    $this->view->tabletri = 1;
  }
  
  


  public function detaillettrerelanceAction()
  {
    /* page espacepersonnel/detaillettre_relance - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuLettreRelance();
    $ma = new Application_Model_EuLettreRelanceMapper();
    $ma->find($id, $a);
    $this->view->lettre_relance = $a;
      }

  }











  public function addlettreannulationadminAction() {
    /* page lettreannulation/addtdrintegrateur - Ajout d'une lettre_annulation */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_eli']) && $_POST['id_eli'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['code_membre']) && $_POST['code_membre'] != "") {
         
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
                 $lettre_annulation = new Application_Model_EuLettreRelance();
                 $m_lettre_annulation = new Application_Model_EuLettreRelanceMapper();

                 $id_lettre_relance = $m_lettre_annulation->findConuter() + 1;

                 $lettre_annulation->setId_lettre_relance($id_lettre_relance);
                 $lettre_annulation->setId_eli($_POST['id_eli']);
                 $lettre_annulation->setLibelle($_POST['libelle']);
                 $lettre_annulation->setType_lettre(2);
                 $lettre_annulation->setCode_membre($_POST['code_membre']);
                 $lettre_annulation->setDescription($_POST['description']);
                 $lettre_annulation->setFichier($fichier);
                 $lettre_annulation->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $lettre_annulation->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 $lettre_annulation->setValid(0);
                 $lettre_annulation->setEtat(1);
                 $m_lettre_annulation->save($lettre_annulation);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/lettrerelance/addlettreannulationadmin');

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




  public function editlettreannulationadminAction() {
    /* page lettreannulation/addlettre_annulation - Ajout d'une lettre_annulation */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_eli']) && $_POST['id_eli'] != "" && isset($_POST['libelle']) && $_POST['libelle'] != "" && isset($_POST['description']) && $_POST['description'] != "" && isset($_POST['code_membre']) && $_POST['code_membre'] != "") {
         
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

                 $lettre_annulation = new Application_Model_EuLettreRelance();
                 $m_lettre_annulation = new Application_Model_EuLettreRelanceMapper();
                 //$m_lettre_annulation->find($_POST['id_lettre_relance'], $lettre_annulation);

                 //$lettre_annulation->setId_lettre_relance($id_lettre_relance);
                 $lettre_annulation->setId_eli($_POST['id_eli']);
                 $lettre_annulation->setLibelle($_POST['libelle']);
                 $lettre_annulation->setCode_membre($_POST['code_membre']);
                 $lettre_annulation->setType_lettre(2);
                 $lettre_annulation->setDescription($_POST['description']);
                 $lettre_annulation->setFichier($fichier);
                 //$lettre_annulation->setDatecreation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$lettre_annulation->setId_utilisateur($sessionutilisateur->id_utilisateur);
                 //$lettre_annulation->setValid(0);
                 //$lettre_annulation->setEtat(1);
                 $m_lettre_annulation->update($lettre_annulation);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/lettrerelance/listlettreannulationadmin');
         
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
               $lettre_annulation = new Application_Model_EuLettreRelance();
               $mlettre_annulation = new Application_Model_EuLettreRelanceMapper();
           $mlettre_annulation->find($id,$lettre_annulation);
           $this->view->lettre_annulation = $lettre_annulation;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $lettre_annulation = new Application_Model_EuLettreRelance();
               $mlettre_annulation = new Application_Model_EuLettreRelanceMapper();
           $mlettre_annulation->find($id,$lettre_annulation);
           $this->view->lettre_annulation = $lettre_annulation;
       }   
     }

  }


  




  public function listlettreannulationadminAction() {
    /* page lettreannulation/listlettre_annulation - liste des lettre_annulations */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $lettre_annulation = new Application_Model_EuLettreRelanceMapper();
    //$this->view->entries = $lettre_annulation->fetchAll();
    $this->view->entries = $lettre_annulation->fetchAllByCodeMembreTypeEliUtilisateurValidEtat("", 2, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etatlettreannulationadminAction()
    {
        /* page lettreannulation/etatlettre_annulation - Etat une lettre_annulation */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $lettre_annulation = new Application_Model_EuLettreRelance();
        $lettre_annulationM = new Application_Model_EuLettreRelanceMapper();
        $lettre_annulationM->find($id, $lettre_annulation);
    
        $lettre_annulation->setEtat($this->_request->getParam('etat'));
    $lettre_annulationM->update($lettre_annulation);
        }

    $this->_redirect('/lettrerelance/listlettreannulationadmin');
    }



  public function detaillettreannulationadminAction()
  {
    /* page espacepersonnel/detaillettre_annulation - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuLettreRelance();
    $ma = new Application_Model_EuLettreRelanceMapper();
    $ma->find($id, $a);
    $this->view->lettre_annulation = $a;
      }

  }





    public function validlettreannulationadminAction()
    {
        /* page lettreannulation/validlettre_annulation - Valid une lettre_annulation */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $lettre_annulation = new Application_Model_EuLettreRelance();
        $lettre_annulationM = new Application_Model_EuLettreRelanceMapper();
        $lettre_annulationM->find($id, $lettre_annulation);
    
        $lettre_annulation->setValid($this->_request->getParam('valid'));
    $lettre_annulationM->update($lettre_annulation);
        }

    $this->_redirect('/lettrerelance/listlettreannulationadmin');
    }





  public function listlettreannulationAction() {
    /* page lettreannulation/listlettre_annulation - liste des lettre_annulations */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    $lettre_annulation = new Application_Model_EuLettreRelanceMapper();
    //$this->view->entries = $lettre_annulation->fetchAll();
    $this->view->entries = $lettre_annulation->fetchAllByCodeMembreTypeEliUtilisateurValidEtat($sessionmembre->code_membre, 2, 0, 0, 0, 0);

    $this->view->tabletri = 1;
  }
  
  


  public function detaillettreannulationAction()
  {
    /* page espacepersonnel/detaillettre_annulation - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuLettreRelance();
    $ma = new Application_Model_EuLettreRelanceMapper();
    $ma->find($id, $a);
    $this->view->lettre_annulation = $a;
      }

  }










}
