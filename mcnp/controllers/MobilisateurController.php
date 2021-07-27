<?php

class MobilisateurController extends Zend_Controller_Action{

    public function init() {
    /* Initialize action controller here */
        include("Url.php");
    }





  public function addmobilisateurindexAction() {
    /* page mobilisateur/addmobilisateur - Ajout d'une mobilisateur */
  $sessionmcnp = new Zend_Session_Namespace('mcnp');

  //$this->_helper->layout->disableLayout();
  $this->_helper->layout()->setLayout('layoutpublicesmc');




    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_membre']) && $_POST['code_membre'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {


/////////////////////////////////////controle code membre
if(isset($_POST['code_membre']) && $_POST['code_membre']!=""){
if(strlen($_POST['code_membre']) != 20) {
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/mobilisateur/addmobilisateurindex');
                  return;
}else{
if(substr($_POST['code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/mobilisateur/addmobilisateurindex');
                  return;
                }
  }else if(substr($_POST['code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmcnp->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/mobilisateur/addmobilisateurindex');
                  return;
                }
  }
}


                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $mobilisateur = new Application_Model_EuMobilisateur();
                 $m_mobilisateur = new Application_Model_EuMobilisateurMapper();

                 $id_mobilisateur = $m_mobilisateur->findConuter() + 1;

                 $mobilisateur->setId_mobilisateur($id_mobilisateur);
                 $mobilisateur->setCode_membre($_POST['code_membre']);
                 $mobilisateur->setDatecreat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $mobilisateur->setId_utilisateur(0);
                 $mobilisateur->setEtat(1);
                 $m_mobilisateur->save($mobilisateur);


////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmcnp->error = "Operation bien effectuee ...";
                 $this->_redirect('/mobilisateur/addmobilisateurindex');
}else{
           $db->rollback();
           $sessionmcnp->error = "Veuillez renseigner le Code Membre ...";

}        
        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionmcnp->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmcnp->error = "Champs * obligatoire";
      }
    }
  }



  public function addmobilisateurintegrateurAction() {
    /* page mobilisateur/addmobilisateurintegrateur - Ajout d'une mobilisateur */
    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');
      if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}



    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['id_utilisateur']) && $_POST['id_utilisateur'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {


/////////////////////////////////////controle code membre
if(isset($_POST['code_membre']) && $_POST['code_membre']!=""){
if(strlen($_POST['code_membre']) != 20) {
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/mobilisateur/addmobilisateurintegrateur');
                  return;
}else{
if(substr($_POST['code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/mobilisateur/addmobilisateurintegrateur');
                  return;
                }
  }else if(substr($_POST['code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmembreasso->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/mobilisateur/addmobilisateurintegrateur');
                  return;
                }
  }
}


                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $mobilisateur = new Application_Model_EuMobilisateur();
                 $m_mobilisateur = new Application_Model_EuMobilisateurMapper();

                 $id_mobilisateur = $m_mobilisateur->findConuter() + 1;

                 $mobilisateur->setId_mobilisateur($id_mobilisateur);
                 $mobilisateur->setCode_membre($_POST['code_membre']);
                 $mobilisateur->setDatecreat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $mobilisateur->setId_utilisateur($_POST['id_utilisateur']);
                 $mobilisateur->setEtat(1);
                 $m_mobilisateur->save($mobilisateur);

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembreasso->error = "Operation bien effectuee ...";
                 $this->_redirect('/mobilisateur/addmobilisateurintegrateur');
}else{
           $db->rollback();
           $sessionmembreasso->error = "Veuillez renseigner le Code Membre ...";

}        
        } catch (Exception $exc) {           
           $db->rollback();
                 $sessionmembreasso->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembreasso->error = "Champs * obligatoire";
      }
    }
  }




  public function addmobilisateurAction() {
    /* page mobilisateur/addmobilisateur - Ajout d'une mobilisateur */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['id_utilisateur']) && $_POST['id_utilisateur'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $mobilisateur = new Application_Model_EuMobilisateur();
                 $m_mobilisateur = new Application_Model_EuMobilisateurMapper();

                 $id_mobilisateur = $m_mobilisateur->findConuter() + 1;

                 $mobilisateur->setId_mobilisateur($id_mobilisateur);
                 $mobilisateur->setCode_membre($_POST['code_membre']);
                 $mobilisateur->setDatecreat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $mobilisateur->setId_utilisateur($_POST['id_utilisateur']);
                 $mobilisateur->setEtat(1);
                 $m_mobilisateur->save($mobilisateur);


////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/mobilisateur/listmobilisateur');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }




  public function editmobilisateurAction() {
    /* page mobilisateur/addmobilisateur - Ajout d'une mobilisateur */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['id_utilisateur']) && $_POST['id_utilisateur'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $mobilisateur = new Application_Model_EuMobilisateur();
                 $m_mobilisateur = new Application_Model_EuMobilisateurMapper();
                 $m_mobilisateur->find($_POST['id_mobilisateur'], $mobilisateur);

                 //$mobilisateur->setId_mobilisateur($id_mobilisateur);
                 $mobilisateur->setCode_membre($_POST['code_membre']);
                 //$mobilisateur->setDatecreat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $$mobilisateur->setId_utilisateur($_POST['id_utilisateur']);
                 //$mobilisateur->setEtat(0);
                 $m_mobilisateur->update($mobilisateur);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/mobilisateur/listmobilisateur');
         
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
               $mobilisateur = new Application_Model_EuMobilisateur();
               $mmobilisateur = new Application_Model_EuMobilisateurMapper();
           $mmobilisateur->find($id,$mobilisateur);
           $this->view->mobilisateur = $mobilisateur;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $mobilisateur = new Application_Model_EuMobilisateur();
               $mmobilisateur = new Application_Model_EuMobilisateurMapper();
           $mmobilisateur->find($id,$mobilisateur);
           $this->view->mobilisateur = $mobilisateur;
       }   
     }

  }


  




  public function listmobilisateurAction() {
    /* page mobilisateur/listmobilisateur - liste des mobilisateurs */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $mobilisateur = new Application_Model_EuMobilisateurMapper();
    $this->view->entries = $mobilisateur->fetchAllByMembre($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }
  
  


    public function etatmobilisateurAction()
    {
        /* page mobilisateur/etatmobilisateur - Etat une mobilisateur */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $mobilisateur = new Application_Model_EuMobilisateur();
        $mobilisateurM = new Application_Model_EuMobilisateurMapper();
        $mobilisateurM->find($id, $mobilisateur);
    
        $mobilisateur->setEtat($this->_request->getParam('etat'));
    $mobilisateurM->update($mobilisateur);
        }

    $this->_redirect('/mobilisateur/listmobilisateur');
    }



  public function detailmobilisateurAction()
  {
    /* page espacepersonnel/detailmobilisateur - Détail d'une demande */

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
    $a = new Application_Model_EuMobilisateur();
    $ma = new Application_Model_EuMobilisateurMapper();
    $ma->find($id, $a);
    $this->view->mobilisateur = $a;
      }

  }






  public function suppmobilisateurAction()
  {
    /* page mobilisateur/suppmobilisateur - Suppression d'une mobilisateur */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

      $mobilisateurM = new Application_Model_EuMobilisateurMapper();
      $mobilisateurM->delete($id);
    }

    $this->_redirect('/mobilisateur/listmobilisateur');
  }



  
  
   public function addmobilisateuradminAction() {
     /* page mobilisateur/addmobilisateuradmin - Ajout d'une mobilisateur */
     $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
     if(!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != "") {$this->_redirect('/administration/confirmation');}



     if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
        if(isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['id_utilisateur']) && $_POST['id_utilisateur'] != "") {
         
        $request = $this->getRequest();
        if($request->isPost())  {
             $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 /////////////////////////////////////controle code membre
                 if(isset($_POST['code_membre']) && $_POST['code_membre']!=""){
                 if(strlen($_POST['code_membre']) != 20) {
                      $db->rollback();
                      $sessionutilisateur->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                      //$this->_redirect('/mobilisateur/addmobilisateurintegrateur');
                      return;
                 } else {
                      if(substr($_POST['code_membre'], -1, 1) == 'P') {
                           $membre = new Application_Model_EuMembre();
                           $membre_mapper = new Application_Model_EuMembreMapper();
                           $membre_mapper->find($_POST['code_membre'], $membre);
                           if(count($membre) == 0) {
                               $db->rollback();
                               $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                               //$this->_redirect('/mobilisateur/addmobilisateurintegrateur');
                               return;
                           }
                      } else if(substr($_POST['code_membre'], -1, 1) == 'M') {
                               $membremorale = new Application_Model_EuMembreMorale();
                               $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                               $membremorale_mapper->find($_POST['code_membre'], $membremorale);
                               if(count($membremorale) == 0) {
                                   $db->rollback();
                                   $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                   //$this->_redirect('/mobilisateur/addmobilisateurintegrateur');
                                   return;
                               }
                      }
                  }


                  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $mobilisateur = new Application_Model_EuMobilisateur();
                  $m_mobilisateur = new Application_Model_EuMobilisateurMapper();

                  $id_mobilisateur = $m_mobilisateur->findConuter() + 1;

                  $mobilisateur->setId_mobilisateur($id_mobilisateur);
                  $mobilisateur->setCode_membre($_POST['code_membre']);
                  $mobilisateur->setDatecreat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                  $mobilisateur->setId_utilisateur($_POST['id_utilisateur']);
                  $mobilisateur->setEtat(1);
                  $m_mobilisateur->save($mobilisateur);

                  ////////////////////////////////////////////////////////////////////////////////

                  $db->commit();
                  $sessionutilisateur->error = "Operation bien effectuee ...";
                  $this->_redirect('/mobilisateur/addmobilisateuradmin');
            } else {
                 $db->rollback();
                 $sessionutilisateur->error = "Veuillez renseigner le Code Membre ...";
            }        
        } catch(Exception $exc) {           
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





  public function editmobilisateuradminAction() {
    /* page mobilisateur/addmobilisateur - Ajout d'une mobilisateur */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_membre']) && $_POST['code_membre'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $mobilisateur = new Application_Model_EuMobilisateur();
                 $m_mobilisateur = new Application_Model_EuMobilisateurMapper();
                 $m_mobilisateur->find($_POST['id_mobilisateur'], $mobilisateur);

                 //$mobilisateur->setId_mobilisateur($id_mobilisateur);
                 $mobilisateur->setCode_membre($_POST['code_membre']);
                 //$mobilisateur->setDatecreat($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 //$mobilisateur->setId_utilisateur($_POST['id_utilisateur']);
                 //$mobilisateur->setEtat(0);
                 $m_mobilisateur->update($mobilisateur);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/mobilisateur/listmobilisateuradmin');
         
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
               $mobilisateur = new Application_Model_EuMobilisateur();
               $mmobilisateur = new Application_Model_EuMobilisateurMapper();
           $mmobilisateur->find($id,$mobilisateur);
           $this->view->mobilisateur = $mobilisateur;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $mobilisateur = new Application_Model_EuMobilisateur();
               $mmobilisateur = new Application_Model_EuMobilisateurMapper();
           $mmobilisateur->find($id,$mobilisateur);
           $this->view->mobilisateur = $mobilisateur;
       }   
     }

  }


  




  public function listmobilisateuradminAction() {
    /* page mobilisateur/listmobilisateur - liste des mobilisateurs */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $mobilisateur = new Application_Model_EuMobilisateurMapper();
    //$this->view->entries = $mobilisateur->fetchAllByCanton($sessionutilisateur->id_utilisateur);
    $this->view->entries = $mobilisateur->fetchAll();

    $this->view->tabletri = 1;
  }
  
  


    public function etatmobilisateuradminAction()
    {
        /* page mobilisateur/etatmobilisateur - Etat une mobilisateur */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $mobilisateur = new Application_Model_EuMobilisateur();
        $mobilisateurM = new Application_Model_EuMobilisateurMapper();
        $mobilisateurM->find($id, $mobilisateur);
    
        $mobilisateur->setEtat($this->_request->getParam('etat'));
    $mobilisateurM->update($mobilisateur);
        }

    $this->_redirect('/mobilisateur/listmobilisateuradmin');
    }



  public function detailmobilisateuradminAction()
  {
    /* page espacepersonnel/detailmobilisateur - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuMobilisateur();
    $ma = new Application_Model_EuMobilisateurMapper();
    $ma->find($id, $a);
    $this->view->mobilisateur = $a;
      }

  }




  




}
