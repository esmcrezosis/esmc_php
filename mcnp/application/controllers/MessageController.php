<?php

class MessageController extends Zend_Controller_Action{

	  public function init() {
		/* Initialize action controller here */
        include("Url.php");
	  }





  public function addmessageadminAction() {
    /* page message/addmessage - Ajout d'une message */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}





    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['titre_message']) && $_POST['titre_message'] != "" && isset($_POST['description_message']) && $_POST['description_message'] != "" && isset($_POST['code_membre_expediteur']) && $_POST['code_membre_expediteur'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////controle code membre
if(strlen($_POST['code_membre_expediteur']) != 20) {
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
}else{
if(substr($_POST['code_membre_expediteur'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre_expediteur'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }else if(substr($_POST['code_membre_expediteur'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre_expediteur'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }
}

////////////////////////////////////////////////////////////////////////////////
          for($i = 0; $i < count($_POST['code_membre_destinataire']); $i++){

/////////////////////////////////////controle code membre
if(strlen($_POST['code_membre_destinataire'][$i]) != 20) {
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
}else{
if(substr($_POST['code_membre_destinataire'][$i], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre_destinataire'][$i], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }else if(substr($_POST['code_membre_destinataire'][$i], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre_destinataire'][$i], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }
}

                    }
////////////////////////////////////////////////////////////////////////////////

                 $message = new Application_Model_EuMessage();
                 $m_message = new Application_Model_EuMessageMapper();

                 $id_message = $m_message->findConuter() + 1;

                 $message->setId_message($id_message);
                 $message->setTitre_message($_POST['titre_message']);
                 $message->setDescription_message($_POST['description_message']);
                 $message->setDate_message($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $message->setCode_membre_expediteur($_POST['code_membre_expediteur']);
                 $message->setId_message_envoi(0);
                 $message->setAlerte($_POST['alerte']);
                 $message->setAdmin(1);
                 $message->setEtat(1);
                 $m_message->save($message);

////////////////////////////////////////////////////////////////////////////////
          for($i = 0; $i < count($_POST['code_membre_destinataire']); $i++){
        $destinataire_message = new Application_Model_EuDestinataireMessage();
        $m_destinataire_message = new Application_Model_EuDestinataireMessageMapper();
      
            $compteur_destinataire_message = $m_destinataire_message->findConuter() + 1;
            $destinataire_message->setId_destinataire_message($compteur_destinataire_message);
            $destinataire_message->setId_message($id_message);
            $destinataire_message->setCode_membre_destinataire($_POST['code_membre_destinataire'][$i]);
            $destinataire_message->setEtat(1);
            $m_destinataire_message->save($destinataire_message);

if($_POST['alerte'] == 1){
$messagealerte = "Bonjour, vous venez d'avoir un message dans votre Espace Personnel ou Professionnel. ESMC";

$telephoneM = new Application_Model_EuTelephoneMapper();
$telephone = $telephoneM->fetchAllByCodeMembre($_POST['code_membre_destinataire'][$i]);
$portable_membre = "";
if(count($telephone) > 0){
foreach ($telephone as $telephonevalue) {
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms2($compteur, $telephonevalue->numero_telephone, $messagealerte);
//Util_Utils::addSms3Easys($compteur, $telephonevalue->numero_telephone, $messagealerte);
        $alerte_message = new Application_Model_EuAlerteMessage();
        $m_alerte_message = new Application_Model_EuAlerteMessageMapper();
            $compteur_alerte_message = $m_alerte_message->findConuter() + 1;
            $alerte_message->setId_alerte_message($compteur_alerte_message);
            $alerte_message->setId_message($id_message);
            $alerte_message->setId_sms_sent($compteur);
            $m_alerte_message->save($alerte_message);
}
}
}
                    }

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $fichier_message_fichier = array();

          for($i = 0; $i < $_POST['fichier_message_count']; $i++){
        $fichier_message = new Application_Model_EuFichierMessage();
        $m_fichier_message = new Application_Model_EuFichierMessageMapper();
      
            $compteur_fichier_message = $m_fichier_message->findConuter() + 1;
            $fichier_message->setId_fichier_message($compteur_fichier_message);
            $fichier_message->setId_message($id_message);

           if(isset($_FILES["fichier_message".$i]["name"]) && $_FILES["fichier_message".$i]["name"] != "") {
                  $chemin  = "messages";
                  $file    = $_FILES["fichier_message".$i]["name"];
                  $file1   = "fichier_message".$i;
                  $fichier_message_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $fichier_message_fichier[$i] = ""; }

            $fichier_message->setFichier_message($fichier_message_fichier[$i]);
            $fichier_message->setEtat(1);
            $m_fichier_message->save($fichier_message);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/message/listmessageadmin');
         
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



  public function addmessageAction() {
    /* page message/addmessage - Ajout d'une message */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }



    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['titre_message']) && $_POST['titre_message'] != "" && isset($_POST['description_message']) && $_POST['description_message'] != "" && isset($_POST['code_membre_expediteur']) && $_POST['code_membre_expediteur'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

////////////////////////////////////////////////////////////////////////////////
          for($i = 0; $i < count($_POST['code_membre_destinataire']); $i++){

/////////////////////////////////////controle code membre
if(strlen($_POST['code_membre_destinataire'][$i]) != 20) {
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
}else{
if(substr($_POST['code_membre_destinataire'][$i], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre_destinataire'][$i], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }else if(substr($_POST['code_membre_destinataire'][$i], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre_destinataire'][$i], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }
}

                    }

////////////////////////////////////////////////////////////////////////////////

                 $message = new Application_Model_EuMessage();
                 $m_message = new Application_Model_EuMessageMapper();

                 $id_message = $m_message->findConuter() + 1;

                 $message->setId_message($id_message);
                 $message->setTitre_message($_POST['titre_message']);
                 $message->setDescription_message($_POST['description_message']);
                 $message->setDate_message($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $message->setCode_membre_expediteur($sessionmembre->code_membre);
                 $message->setId_message_envoi(0);
                 $message->setAlerte(0);
                 $message->setAdmin(0);
                 $message->setEtat(1);
                 $m_message->save($message);

////////////////////////////////////////////////////////////////////////////////
          for($i = 0; $i < count($_POST['code_membre_destinataire']); $i++){
        $destinataire_message = new Application_Model_EuDestinataireMessage();
        $m_destinataire_message = new Application_Model_EuDestinataireMessageMapper();
      
            $compteur_destinataire_message = $m_destinataire_message->findConuter() + 1;
            $destinataire_message->setId_destinataire_message($compteur_destinataire_message);
            $destinataire_message->setId_message($id_message);
            $destinataire_message->setCode_membre_destinataire($_POST['code_membre_destinataire'][$i]);
            $destinataire_message->setEtat(1);
            $m_destinataire_message->save($destinataire_message);
                    }

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $fichier_message_fichier = array();

          for($i = 0; $i < $_POST['fichier_message_count']; $i++){
        $fichier_message = new Application_Model_EuFichierMessage();
        $m_fichier_message = new Application_Model_EuFichierMessageMapper();
      
            $compteur_fichier_message = $m_fichier_message->findConuter() + 1;
            $fichier_message->setId_fichier_message($compteur_fichier_message);
            $fichier_message->setId_message($id_message);

           if(isset($_FILES["fichier_message".$i]["name"]) && $_FILES["fichier_message".$i]["name"] != "") {
                  $chemin  = "messages";
                  $file    = $_FILES["fichier_message".$i]["name"];
                  $file1   = "fichier_message".$i;
                  $fichier_message_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $fichier_message_fichier[$i] = ""; }

            $fichier_message->setFichier_message($fichier_message_fichier[$i]);
            $fichier_message->setEtat(1);
            $m_fichier_message->save($fichier_message);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/message/listmessage');
         
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




  public function repondremessageAction() {
    /* page message/addmessage - Ajout d'une message */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }



    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['titre_message']) && $_POST['titre_message'] != "" && isset($_POST['description_message']) && $_POST['description_message'] != "" && isset($_POST['code_membre_expediteur']) && $_POST['code_membre_expediteur'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////controle code membre
if(strlen($_POST['code_membre_destinataire']) != 20) {
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
}else{
if(substr($_POST['code_membre_destinataire'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre_destinataire'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }else if(substr($_POST['code_membre_destinataire'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre_destinataire'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionmembre->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }
}

////////////////////////////////////////////////////////////////////////////////

                 $message = new Application_Model_EuMessage();
                 $m_message = new Application_Model_EuMessageMapper();

                 $id_message = $m_message->findConuter() + 1;

                 $message->setId_message($id_message);
                 $message->setTitre_message($_POST['titre_message']);
                 $message->setDescription_message($_POST['description_message']);
                 $message->setDate_message($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $message->setCode_membre_expediteur($sessionmembre->code_membre);
                 $message->setId_message_envoi($_POST['id_message_envoi']);
                 $message->setAlerte(0);
                 $message->setAdmin(0);
                 $message->setEtat(1);
                 $m_message->save($message);

////////////////////////////////////////////////////////////////////////////////
        $destinataire_message = new Application_Model_EuDestinataireMessage();
        $m_destinataire_message = new Application_Model_EuDestinataireMessageMapper();
      
            $compteur_destinataire_message = $m_destinataire_message->findConuter() + 1;
            $destinataire_message->setId_destinataire_message($compteur_destinataire_message);
            $destinataire_message->setId_message($id_message);
            $destinataire_message->setCode_membre_destinataire($_POST['code_membre_destinataire']);
            $destinataire_message->setEtat(1);
            $m_destinataire_message->save($destinataire_message);

////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
          $fichier_message_fichier = array();

          for($i = 0; $i < $_POST['fichier_message_count']; $i++){
        $fichier_message = new Application_Model_EuFichierMessage();
        $m_fichier_message = new Application_Model_EuFichierMessageMapper();
      
            $compteur_fichier_message = $m_fichier_message->findConuter() + 1;
            $fichier_message->setId_fichier_message($compteur_fichier_message);
            $fichier_message->setId_message($id_message);

           if(isset($_FILES["fichier_message".$i]["name"]) && $_FILES["fichier_message".$i]["name"] != "") {
                  $chemin  = "messages";
                  $file    = $_FILES["fichier_message".$i]["name"];
                  $file1   = "fichier_message".$i;
                  $fichier_message_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $fichier_message_fichier[$i] = ""; }

            $fichier_message->setFichier_message($fichier_message_fichier[$i]);
            $fichier_message->setEtat(1);
            $m_fichier_message->save($fichier_message);
                    }

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/message/listmessage');
         
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
               $message = new Application_Model_EuMessage();
               $mmessage = new Application_Model_EuMessageMapper();
           $mmessage->find($id,$message);
           $this->view->message = $message;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $message = new Application_Model_EuMessage();
               $mmessage = new Application_Model_EuMessageMapper();
           $mmessage->find($id,$message);
           $this->view->message = $message;
       }   
     }

  }




  




  public function listmessageAction() {
    /* page message/listmessage - liste des messages */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $message = new Application_Model_EuMessageMapper();
    $this->view->entries = $message->fetchAllExpediteur($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }
  

  public function listmessagerecuAction() {
    /* page message/listmessage - liste des messages */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $message = new Application_Model_EuMessageMapper();
    $this->view->entries = $message->fetchAllDestinataire($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }
  
  


    public function etatmessageAction()
    {
        /* page message/etatmessage - Etat une message */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $message = new Application_Model_EuMessage();
        $messageM = new Application_Model_EuMessageMapper();
        $messageM->find($id, $message);
    
        $message->setEtat($this->_request->getParam('etat'));
    $messageM->update($message);
        }

    $this->_redirect('/message/listmessage');
    }



  public function detailmessageAction()
  {
    /* page espacepersonnel/detailsmessage - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuMessage();
    $ma = new Application_Model_EuMessageMapper();
    $ma->find($id, $a);
    $this->view->message = $a;
      }

  }







  public function suppmessageAction()
  {
    /* page message/suppmessage - Suppression d'une message */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

      $messageM = new Application_Model_EuMessageMapper();
      $messageM->delete($id);
    }

    $this->_redirect('/message/listmessage');
  }








  




  public function listmessageadminAction() {
    /* page message/listmessage - liste des messages */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $message = new Application_Model_EuMessageMapper();
    $this->view->entries = $message->fetchAll2();

    $this->view->tabletri = 1;
  }
  
  


    public function etatmessageadminAction()
    {
        /* page message/etatmessage - Etat une message */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $message = new Application_Model_EuMessage();
        $messageM = new Application_Model_EuMessageMapper();
        $messageM->find($id, $message);
    
        $message->setEtat($this->_request->getParam('etat'));
    $messageM->update($message);
        }

    $this->_redirect('/message/listmessageadmin');
    }



  public function detailmessageadminAction()
  {
    /* page espacepersonnel/destinatairemessage - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuMessage();
    $ma = new Application_Model_EuMessageMapper();
    $ma->find($id, $a);
    $this->view->message = $a;
      }

  }



  
  

  public function addmessageadmincsvAction() {
    /* page message/addmessage - Ajout d'une message */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}





    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['titre_message']) && $_POST['titre_message'] != "" && isset($_POST['description_message']) && $_POST['description_message'] != "" && isset($_POST['code_membre_expediteur']) && $_POST['code_membre_expediteur'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

        //include("Transfert.php");

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////controle code membre
if(strlen($_POST['code_membre_expediteur']) != 20) {
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
}else{
if(substr($_POST['code_membre_expediteur'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['code_membre_expediteur'], $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }else if(substr($_POST['code_membre_expediteur'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['code_membre_expediteur'], $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/message/addmessageindex');
                  return;
                }
  }
}
////////////////////////////////////////////////////////////////////////////////
            include("Transfert.php");
            if(isset($_FILES['code_membre_destinataire_fichier']['name']) && $_FILES['code_membre_destinataire_fichier']['name']!="") {
////////////////////////////////////////////////////////////////////////////////

                 $message = new Application_Model_EuMessage();
                 $m_message = new Application_Model_EuMessageMapper();

                 $id_message = $m_message->findConuter() + 1;

                 $message->setId_message($id_message);
                 $message->setTitre_message($_POST['titre_message']);
                 $message->setDescription_message($_POST['description_message']);
                 $message->setDate_message($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $message->setCode_membre_expediteur($_POST['code_membre_expediteur']);
                 $message->setId_message_envoi(0);
                 $message->setAlerte($_POST['alerte']);
                 $message->setAdmin(1);
                 $message->setEtat(1);
                 $m_message->save($message);

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
        
                $chemin = "messages";
                $file = $_FILES['code_membre_destinataire_fichier']['name'];
                $file1='code_membre_destinataire_fichier';
                $message = $chemin."/".transfert($chemin,$file1);


             
            $fichier = $message;

            $_fichier = strtolower(substr($message, -4));
            if($_fichier == ".csv" || $_fichier == ".CSV") { // || $_fichier == ".xls" || $_fichier == "xlsx"

                    $fichier = Util_Utils::getParamEsmc(1)."/".$fichier;
                    $lines = file($fichier);
    
                    foreach ($lines as $line_num => $line) {


/////////////////////////////////////controle code membre
                      $line = trim($line);
if(strlen($line) != 20) {
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...".strlen($line)." ".($line);
                  //$this->_redirect('/message/addmessageindex');
                  continue;
}else{
if(substr($line, -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($line, $membre);
                                if(count($membre) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                  //$this->_redirect('/message/addmessageindex');
                  continue;
                }
  }else if(substr($line, -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($line, $membremorale);
                                if(count($membremorale) == 0){
                  $db->rollback();
                                $sessionutilisateur->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                  //$this->_redirect('/message/addmessageindex');
                  continue;
                }
  }
}





        $destinataire_message = new Application_Model_EuDestinataireMessage();
        $m_destinataire_message = new Application_Model_EuDestinataireMessageMapper();
      
            $compteur_destinataire_message = $m_destinataire_message->findConuter() + 1;
            $destinataire_message->setId_destinataire_message($compteur_destinataire_message);
            $destinataire_message->setId_message($id_message);
            $destinataire_message->setCode_membre_destinataire($line);
            $destinataire_message->setEtat(1);
            $m_destinataire_message->save($destinataire_message);

if($_POST['alerte'] == 1){
$messagealerte = "Bonjour, vous venez d'avoir un message dans votre Espace Personnel ou Professionnel. ESMC";

$telephoneM = new Application_Model_EuTelephoneMapper();
$telephone = $telephoneM->fetchAllByCodeMembre($line);
$portable_membre = "";
if(count($telephone) > 0){
foreach ($telephone as $telephonevalue) {
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms2($compteur, $telephonevalue->numero_telephone, $messagealerte);
//Util_Utils::addSms3Easys($compteur, $telephonevalue->numero_telephone, $messagealerte);
        $alerte_message = new Application_Model_EuAlerteMessage();
        $m_alerte_message = new Application_Model_EuAlerteMessageMapper();
            $compteur_alerte_message = $m_alerte_message->findConuter() + 1;
            $alerte_message->setId_alerte_message($compteur_alerte_message);
            $alerte_message->setId_message($id_message);
            $alerte_message->setId_sms_sent($compteur);
            $m_alerte_message->save($alerte_message);
}
}
}


}
            
}




////////////////////////////////////////////////////////////////////////////////
            //include("Transfert.php");
          $fichier_message_fichier = array();

          for($i = 0; $i < $_POST['fichier_message_count']; $i++){
        $fichier_message = new Application_Model_EuFichierMessage();
        $m_fichier_message = new Application_Model_EuFichierMessageMapper();
      
            $compteur_fichier_message = $m_fichier_message->findConuter() + 1;
            $fichier_message->setId_fichier_message($compteur_fichier_message);
            $fichier_message->setId_message($id_message);

           if(isset($_FILES["fichier_message".$i]["name"]) && $_FILES["fichier_message".$i]["name"] != "") {
                  $chemin  = "messages";
                  $file    = $_FILES["fichier_message".$i]["name"];
                  $file1   = "fichier_message".$i;
                  $fichier_message_fichier[$i] = $chemin."/".transfert($chemin,$file1);
               } else { $fichier_message_fichier[$i] = ""; }

            $fichier_message->setFichier_message($fichier_message_fichier[$i]);
            $fichier_message->setEtat(1);
            $m_fichier_message->save($fichier_message);
                    }

////////////////////////////////////////////////////////////////////////////////


         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/message/listmessageadmin');
            } else {
           $sessionutilisateur->error = "Fichier des destinataires non chargé ...";

            	$message = "";}
         
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







}
