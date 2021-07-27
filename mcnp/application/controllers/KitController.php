<?php

class KitController extends Zend_Controller_Action{

	  public function init() {
		/* Initialize action controller here */
        //include("Url.php");
	  }





  public function addkitadminAction() {
    /* page kit/addtdrintegrateur - Ajout d'une kit */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['materiel_kit']) && $_POST['materiel_kit'] != "" && isset($_POST['type_kit']) && $_POST['type_kit'] != "" && isset($_POST['membreasso_id']) && $_POST['membreasso_id'] != "" && isset($_POST['qte_kit']) && $_POST['qte_kit'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

          
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $kit = new Application_Model_EuKit();
                 $m_kit = new Application_Model_EuKitMapper();

                 $id_kit = $m_kit->findConuter() + 1;

                 $kit->setId_kit($id_kit);
                 //$kit->setCode_membre();
                 $kit->setMembreasso_id($_POST['membreasso_id']);
                 $kit->setAutomatique(0);
                 $kit->setDate_kit($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $kit->setMateriel_kit($_POST['materiel_kit']);
                 $kit->setLivrer(0);
                 $kit->setEtat(1);
                 $kit->setType_kit($_POST['type_kit']);
                 $kit->setLicence($_POST['licence']);
                 $kit->setObservation($_POST['observation']);
                 $kit->setQte_kit($_POST['qte_kit']);
                 $m_kit->save($kit);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/kit/addkitadmin');

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




  public function editkitadminAction() {
    /* page kit/addkit - Ajout d'une kit */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['materiel_kit']) && $_POST['materiel_kit'] != "" && isset($_POST['type_kit']) && $_POST['type_kit'] != "" && isset($_POST['membreasso_id']) && $_POST['membreasso_id'] != "" && isset($_POST['qte_kit']) && $_POST['qte_kit'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

            include("Transfert.php");

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $kit = new Application_Model_EuKit();
                 $m_kit = new Application_Model_EuKitMapper();
                 $m_kit->find($_POST['id_kit'], $kit);

                 //$kit->setId_kit($id_kit);
                 //$kit->setCode_membre();
                 $kit->setMembreasso_id($_POST['membreasso_id']);
                 //$kit->setAutomatique(0);
                 //$kit->setDate_kit($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $kit->setMateriel_kit($_POST['materiel_kit']);
                 //$kit->setLivrer(0);
                 //$kit->setEtat(1);
                 $kit->setType_kit($_POST['type_kit'])
                 $kit->setLicence($_POST['licence']);
                 $kit->setObservation($_POST['observation']);
                 $kit->setQte_kit($_POST['qte_kit']);
                 $m_kit->update($kit);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/kit/listkitadmin');
         
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
               $kit = new Application_Model_EuKit();
               $mkit = new Application_Model_EuKitMapper();
           $mkit->find($id,$kit);
           $this->view->kit = $kit;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $kit = new Application_Model_EuKit();
               $mkit = new Application_Model_EuKitMapper();
           $mkit->find($id,$kit);
           $this->view->kit = $kit;
       }   
     }

  }


  




  public function listkitadminAction() {
    /* page kit/listkit - liste des kits */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $kit = new Application_Model_EuKitMapper();
    //$this->view->entries = $kit->fetchAll();
    $this->view->entries = $kit->fetchAllByIntegrateurMembreassoTypeUtilisateurLivrerEtat(0, 0, 0, 0, 0, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etatkitadminAction()
    {
        /* page kit/etatkit - Etat une kit */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $kit = new Application_Model_EuKit();
        $kitM = new Application_Model_EuKitMapper();
        $kitM->find($id, $kit);
    
        $kit->setEtat($this->_request->getParam('etat'));
    $kitM->update($kit);
        }

    $this->_redirect('/kit/listkitadmin');
    }

  
    public function livrerkitadminAction()
    {
        /* page kit/livrerkit - Etat une kit */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $kit = new Application_Model_EuKit();
        $kitM = new Application_Model_EuKitMapper();
        $kitM->find($id, $kit);
    
        $kit->setLivrer($this->_request->getParam('livrer'));
    $kitM->update($kit);
        }

    $this->_redirect('/kit/listkitadmin');
    }


  





    






  public function addkitintAction() {
    /* page kit/addtdrintegrateur - Ajout d'une kit */
    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');

  if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['materiel_kit']) && $_POST['materiel_kit'] != "" && isset($_POST['type_kit']) && $_POST['type_kit'] != "" && isset($_POST['qte_kit']) && $_POST['qte_kit'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

          
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $kit = new Application_Model_EuKit();
                 $m_kit = new Application_Model_EuKitMapper();

                 $id_kit = $m_kit->findConuter() + 1;

                 $kit->setId_kit($id_kit);
                 $kit->setCode_membre($sessionmembreasso->association_code_membre)
                 $kit->setMembreasso_id($sessionmembreasso->membreasso_id)
                 $kit->setAutomatique(0)
                 $kit->setDate_kit($date_id->toString('yyyy-MM-dd HH:mm:ss'))
                 $kit->setMateriel_kit($_POST['materiel_kit'])
                 $kit->setLivrer(0)
                 $kit->setEtat(1)
                 $kit->setLicence($_POST['licence']);
                 $kit->setObservation($_POST['observation']);
                 $kit->setType_kit($_POST['type_kit'])
                 $kit->setQte_kit($_POST['qte_kit'])
                 $m_kit->save($kit);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembreasso->error = "Operation bien effectuee ...";
                 $this->_redirect('/kit/addkitint');

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




  public function editkitintAction() {
    /* page kit/addkit - Ajout d'une kit */

    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');

  if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}



    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['materiel_kit']) && $_POST['materiel_kit'] != "" && isset($_POST['type_kit']) && $_POST['type_kit'] != "" && isset($_POST['qte_kit']) && $_POST['qte_kit'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

            include("Transfert.php");

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $kit = new Application_Model_EuKit();
                 $m_kit = new Application_Model_EuKitMapper();
                 $m_kit->find($_POST['id_kit'], $kit);

                 //$kit->setId_kit($id_kit);
                 //$kit->setCode_membre($sessionmembreasso->association_code_membre)
                 //$kit->setMembreasso_id($sessionmembreasso->membreasso_id)
                 //$kit->setAutomatique(0)
                 //$kit->setDate_kit($date_id->toString('yyyy-MM-dd HH:mm:ss'))
                 $kit->setMateriel_kit($_POST['materiel_kit'])
                 //$kit->setLivrer(0)
                 //$kit->setEtat(1)
                 $kit->setLicence($_POST['licence']);
                 $kit->setObservation($_POST['observation']);
                 $kit->setType_kit($_POST['type_kit'])
                 $kit->setQte_kit($_POST['qte_kit'])
                 $m_kit->update($kit);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionmembreasso->error = "Operation bien effectuee ...";
                 $this->_redirect('/kit/listkitint');
         
        } catch (Exception $exc) {           
           $db->rollback();
                 $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                 return;
          }  
         
      }   
         
      } else {
        $sessionmembreasso->error = "Champs * obligatoire";
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $kit = new Application_Model_EuKit();
               $mkit = new Application_Model_EuKitMapper();
           $mkit->find($id,$kit);
           $this->view->kit = $kit;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $kit = new Application_Model_EuKit();
               $mkit = new Application_Model_EuKitMapper();
           $mkit->find($id,$kit);
           $this->view->kit = $kit;
       }   
     }

  }


  




  public function listkitintAction() {
    /* page kit/listkit - liste des kits */

    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');

  if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}


    $kit = new Application_Model_EuKitMapper();
    //$this->view->entries = $kit->fetchAll();
    $this->view->entries = $kit->fetchAllByCodeMembreMembreassoTypeMaterielLivrerEtat($sessionmembreasso->association_code_membre, 0, 0, 0, 0, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
  
    public function etatkitintAction()
    {
        /* page kit/etatkit - Etat une kit */

    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');

  if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $kit = new Application_Model_EuKit();
        $kitM = new Application_Model_EuKitMapper();
        $kitM->find($id, $kit);
    
        $kit->setEtat($this->_request->getParam('etat'));
    $kitM->update($kit);
        }

    $this->_redirect('/kit/listkitint');
    }
    


  









}
