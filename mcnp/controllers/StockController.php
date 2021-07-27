<?php

class StockController extends Zend_Controller_Action{

	  public function init() {
		/* Initialize action controller here */
        //include("Url.php");
	  }





  public function addfichestockadminAction() {
    /* page stock/addtdrintegrateur - Ajout d'une fiche_stock */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['nom_article']) && $_POST['nom_article'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $fiche_stock = new Application_Model_EuFicheStock();
                 $m_fiche_stock = new Application_Model_EuFicheStockMapper();

                 $id_fiche_stock = $m_fiche_stock->findConuter() + 1;

                 $fiche_stock->setId_fiche_stock($id_fiche_stock);
                 $fiche_stock->setNom_article($_POST['nom_article']);
                 $fiche_stock->setValidation_ggsm($_POST['validation_ggsm']);
                 $fiche_stock->setValidation_agent_comptable($_POST['validation_agent_comptable'])
                 $fiche_stock->setValidation_rsf($_POST['validation_rsf'])
                 $fiche_stock->setValid(0);
                 $fiche_stock->setEtat(1);
                 $m_fiche_stock->save($fiche_stock);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/addfichestockadmin');

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




  public function editfichestockadminAction() {
    /* page stock/addfiche_stock - Ajout d'une fiche_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['nom_article']) && $_POST['nom_article'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $fiche_stock = new Application_Model_EuFicheStock();
                 $m_fiche_stock = new Application_Model_EuFicheStockMapper();
                 //$m_fiche_stock->find($_POST['id_fiche_stock'], $fiche_stock);

                 //$fiche_stock->setId_fiche_stock($id_fiche_stock);
                 $fiche_stock->setNom_article($_POST['nom_article']);
                 //$fiche_stock->setValidation_ggsm($_POST['validation_ggsm']);
                 //$fiche_stock->setValidation_agent_comptable($_POST['validation_agent_comptable'])
                 //$fiche_stock->setValidation_rsf($_POST['validation_rsf'])
                 //$fiche_stock->setValid(0);
                 //$fiche_stock->setEtat(1);
                 $m_fiche_stock->update($fiche_stock);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/listfichestockadmin');
         
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
               $fiche_stock = new Application_Model_EuFicheStock();
               $mfiche_stock = new Application_Model_EuFicheStockMapper();
           $mfiche_stock->find($id,$fiche_stock);
           $this->view->fiche_stock = $fiche_stock;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $fiche_stock = new Application_Model_EuFicheStock();
               $mfiche_stock = new Application_Model_EuFicheStockMapper();
           $mfiche_stock->find($id,$fiche_stock);
           $this->view->fiche_stock = $fiche_stock;
       }   
     }

  }


  




  public function listfichestockadminAction() {
    /* page stock/listfiche_stock - liste des fiche_stocks */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $fiche_stock = new Application_Model_EuFicheStockMapper();
    $this->view->entries = $fiche_stock->fetchAll();
    //$this->view->entries = $fiche_stock->fetchAllByCodeMembreEliUtilisateurValidEtat(0, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etatfichestockadminAction()
    {
        /* page stock/etatfiche_stock - Etat une fiche_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $fiche_stock = new Application_Model_EuFicheStock();
        $fiche_stockM = new Application_Model_EuFicheStockMapper();
        $fiche_stockM->find($id, $fiche_stock);
    
        $fiche_stock->setEtat($this->_request->getParam('etat'));
    $fiche_stockM->update($fiche_stock);
        }

    $this->_redirect('/stock/listfichestockadmin');
    }



  public function detailfichestockadminAction()
  {
    /* page espacepersonnel/detailfiche_stock - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuFicheStock();
    $ma = new Application_Model_EuFicheStockMapper();
    $ma->find($id, $a);
    $this->view->fiche_stock = $a;
      }

  }





    public function validfichestockadminAction()
    {
        /* page stock/validfiche_stock - Valid une fiche_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $fiche_stock = new Application_Model_EuFicheStock();
        $fiche_stockM = new Application_Model_EuFicheStockMapper();
        $fiche_stockM->find($id, $fiche_stock);
    
        $fiche_stock->setValid($this->_request->getParam('valid'));
    $fiche_stockM->update($fiche_stock);
        }

    $this->_redirect('/stock/listfichestockadmin');
    }










  public function adddetailfichestockadminAction() {
    /* page stock/addtdrintegrateur - Ajout d'une detail_fiche_stock */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_fiche_stock']) && $_POST['id_fiche_stock'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $detail_fiche_stock = new Application_Model_EuDetailFicheStock();
                 $m_detail_fiche_stock = new Application_Model_EuDetailFicheStockMapper();

                 $id_detail_fiche_stock = $m_detail_fiche_stock->findConuter() + 1;

                 $detail_fiche_stock->setId_detail_fiche_stock($id_detail_fiche_stock);
                 $detail_fiche_stock->setDate_article($_POST['date_article']);
                 $detail_fiche_stock->setReference_article_fiche_stock($_POST['reference_article_fiche_stock']);
                 $detail_fiche_stock->setEntree_qte_article($_POST['entree_qte_article']);
                 $detail_fiche_stock->setId_fiche_stock($_POST['id_fiche_stock']);
                 $detail_fiche_stock->setEntree_prix_unitaire($_POST['entree_prix_unitaire']);
                 $detail_fiche_stock->setEntree_valeur($_POST['entree_valeur']);
                 $detail_fiche_stock->setSortie_qte_article($_POST['sortie_qte_article']);
                 $detail_fiche_stock->setSortie_prix_unitaire($_POST['sortie_prix_unitaire']);
                 $detail_fiche_stock->setSortie_valeur($_POST['sortie_valeur']);
                 $detail_fiche_stock->setStocks_qte_article($_POST['stocks_qte_article']);
                 $detail_fiche_stock->setStocks_prix_unitaire($_POST['stocks_prix_unitaire']);
                 $detail_fiche_stock->setStocks_valeur($_POST['stocks_valeur']);
                 $detail_fiche_stock->setEtat(1);
                 $m_detail_fiche_stock->save($detail_fiche_stock);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/adddetailfichestockadmin');

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




  public function editdetailfichestockadminAction() {
    /* page stock/adddetail_fiche_stock - Ajout d'une detail_fiche_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_fiche_stock']) && $_POST['id_fiche_stock'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $detail_fiche_stock = new Application_Model_EuDetailFicheStock();
                 $m_detail_fiche_stock = new Application_Model_EuDetailFicheStockMapper();
                 //$m_detail_fiche_stock->find($_POST['id_detail_fiche_stock'], $detail_fiche_stock);

                 //$detail_fiche_stock->setId_detail_fiche_stock($id_detail_fiche_stock);
                 $detail_fiche_stock->setDate_article($_POST['date_article']);
                 $detail_fiche_stock->setReference_article_fiche_stock($_POST['reference_article_fiche_stock']);
                 $detail_fiche_stock->setEntree_qte_article($_POST['entree_qte_article']);
                 $detail_fiche_stock->setId_fiche_stock($_POST['id_fiche_stock']);
                 $detail_fiche_stock->setEntree_prix_unitaire($_POST['entree_prix_unitaire']);
                 $detail_fiche_stock->setEntree_valeur($_POST['entree_valeur']);
                 $detail_fiche_stock->setSortie_qte_article($_POST['sortie_qte_article']);
                 $detail_fiche_stock->setSortie_prix_unitaire($_POST['sortie_prix_unitaire']);
                 $detail_fiche_stock->setSortie_valeur($_POST['sortie_valeur']);
                 $detail_fiche_stock->setStocks_qte_article($_POST['stocks_qte_article']);
                 $detail_fiche_stock->setStocks_prix_unitaire($_POST['stocks_prix_unitaire']);
                 $detail_fiche_stock->setStocks_valeur($_POST['stocks_valeur']);
                 //$detail_fiche_stock->setEtat(1);
                 $m_detail_fiche_stock->update($detail_fiche_stock);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/listdetailfichestockadmin');
         
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
               $detail_fiche_stock = new Application_Model_EuDetailFicheStock();
               $mdetail_fiche_stock = new Application_Model_EuDetailFicheStockMapper();
           $mdetail_fiche_stock->find($id,$detail_fiche_stock);
           $this->view->detail_fiche_stock = $detail_fiche_stock;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $detail_fiche_stock = new Application_Model_EuDetailFicheStock();
               $mdetail_fiche_stock = new Application_Model_EuDetailFicheStockMapper();
           $mdetail_fiche_stock->find($id,$detail_fiche_stock);
           $this->view->detail_fiche_stock = $detail_fiche_stock;
       }   
     }

  }


  




  public function listdetailfichestockadminAction() {
    /* page stock/listdetail_fiche_stock - liste des detail_fiche_stocks */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $detail_fiche_stock = new Application_Model_EuDetailFicheStockMapper();
    $this->view->entries = $detail_fiche_stock->fetchAll();
    //$this->view->entries = $detail_fiche_stock->fetchAllByCodeMembreEliUtilisateurValidEtat(0, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etatdetailfichestockadminAction()
    {
        /* page stock/etatdetail_fiche_stock - Etat une detail_fiche_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_fiche_stock = new Application_Model_EuDetailFicheStock();
        $detail_fiche_stockM = new Application_Model_EuDetailFicheStockMapper();
        $detail_fiche_stockM->find($id, $detail_fiche_stock);
    
        $detail_fiche_stock->setEtat($this->_request->getParam('etat'));
    $detail_fiche_stockM->update($detail_fiche_stock);
        }

    $this->_redirect('/stock/listdetailfichestockadmin');
    }



  public function detaildetailfichestockadminAction()
  {
    /* page espacepersonnel/detaildetail_fiche_stock - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuDetailFicheStock();
    $ma = new Application_Model_EuDetailFicheStockMapper();
    $ma->find($id, $a);
    $this->view->detail_fiche_stock = $a;
      }

  }

///////////////////////////////////////////////////////////////////////////////////////////////////














///////////////////////////////////////////////////////////////////////////////////////////////////

  public function addbonentreestockadminAction() {
    /* page stock/addtdrintegrateur - Ajout d'une bon_entree_stock */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['reference_bon_entree_stock']) && $_POST['reference_bon_entree_stock'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $bon_entree_stock = new Application_Model_EuBonEntreeStock();
                 $m_bon_entree_stock = new Application_Model_EuBonEntreeStockMapper();

                 $id_bon_entree_stock = $m_bon_entree_stock->findConuter() + 1;

                 $bon_entree_stock->setId_bon_entree_stock($id_bon_entree_stock);
                 $bon_entree_stock->setReference_bon_entree_stock($_POST['reference_bon_entree_stock']);
                 $bon_entree_stock->setLibelle_bon_entree_stock($_POST['libelle_bon_entree_stock']);
                 $bon_entree_stock->setDate_bon_entree_stock($_POST['date_bon_entree_stock']);
                 $bon_entree_stock->setRejet($_POST['rejet']);
                 $bon_entree_stock->setValider_up($_POST['valider_up']);
                 $bon_entree_stock->setvalider_down($_POST['valider_down']);
                 $bon_entree_stock->setValid(0);
                 $bon_entree_stock->setEtat(1);
                 $m_bon_entree_stock->save($bon_entree_stock);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/addbonentreestockadmin');

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




  public function editbonentreestockadminAction() {
    /* page stock/addbon_entree_stock - Ajout d'une bon_entree_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['reference_bon_entree_stock']) && $_POST['reference_bon_entree_stock'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $bon_entree_stock = new Application_Model_EuBonEntreeStock();
                 $m_bon_entree_stock = new Application_Model_EuBonEntreeStockMapper();
                 //$m_bon_entree_stock->find($_POST['id_bon_entree_stock'], $bon_entree_stock);

                 //$bon_entree_stock->setId_bon_entree_stock($id_bon_entree_stock);
                 $bon_entree_stock->setReference_bon_entree_stock($_POST['reference_bon_entree_stock']);
                 $bon_entree_stock->setDate_bon_entree_stock($_POST['date_bon_entree_stock']);
                 $bon_entree_stock->setRejet($_POST['rejet']);
                 //$bon_entree_stock->setValider_up($_POST['valider_up']);
                 //$bon_entree_stock->setvalider_down($_POST['valider_down']);
                 //$bon_entree_stock->setValid(0);
                 //$bon_entree_stock->setEtat(1);
                 $m_bon_entree_stock->update($bon_entree_stock);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/listbonentreestockadmin');
         
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
               $bon_entree_stock = new Application_Model_EuBonEntreeStock();
               $mbon_entree_stock = new Application_Model_EuBonEntreeStockMapper();
           $mbon_entree_stock->find($id,$bon_entree_stock);
           $this->view->bon_entree_stock = $bon_entree_stock;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $bon_entree_stock = new Application_Model_EuBonEntreeStock();
               $mbon_entree_stock = new Application_Model_EuBonEntreeStockMapper();
           $mbon_entree_stock->find($id,$bon_entree_stock);
           $this->view->bon_entree_stock = $bon_entree_stock;
       }   
     }

  }


  




  public function listbonentreestockadminAction() {
    /* page stock/listbon_entree_stock - liste des bon_entree_stocks */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $bon_entree_stock = new Application_Model_EuBonEntreeStockMapper();
    $this->view->entries = $bon_entree_stock->fetchAll();
    //$this->view->entries = $bon_entree_stock->fetchAllByCodeMembreEliUtilisateurValidEtat(0, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etatbonentreestockadminAction()
    {
        /* page stock/etatbon_entree_stock - Etat une bon_entree_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $bon_entree_stock = new Application_Model_EuBonEntreeStock();
        $bon_entree_stockM = new Application_Model_EuBonEntreeStockMapper();
        $bon_entree_stockM->find($id, $bon_entree_stock);
    
        $bon_entree_stock->setEtat($this->_request->getParam('etat'));
    $bon_entree_stockM->update($bon_entree_stock);
        }

    $this->_redirect('/stock/listbonentreestockadmin');
    }



  public function detailbonentreestockadminAction()
  {
    /* page espacepersonnel/detailbon_entree_stock - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuBonEntreeStock();
    $ma = new Application_Model_EuBonEntreeStockMapper();
    $ma->find($id, $a);
    $this->view->bon_entree_stock = $a;
      }

  }





    public function validbonentreestockadminAction()
    {
        /* page stock/validbon_entree_stock - Valid une bon_entree_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $bon_entree_stock = new Application_Model_EuBonEntreeStock();
        $bon_entree_stockM = new Application_Model_EuBonEntreeStockMapper();
        $bon_entree_stockM->find($id, $bon_entree_stock);
    
        $bon_entree_stock->setValid($this->_request->getParam('valid'));
    $bon_entree_stockM->update($bon_entree_stock);
        }

    $this->_redirect('/stock/listbonentreestockadmin');
    }










  public function adddetailbonentreestockadminAction() {
    /* page stock/addtdrintegrateur - Ajout d'une detail_bon_entree_stock */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_bon_entree_stock']) && $_POST['id_bon_entree_stock'] != "" && isset($_POST['designation_articles']) && $_POST['designation_articles'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $detail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStock();
                 $m_detail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStockMapper();

                 $id_detail_bon_entree_stock = $m_detail_bon_entree_stock->findConuter() + 1;

                 $detail_bon_entree_stock->setId_detail_bon_entree_stock($id_detail_bon_entree_stock);
                 $detail_bon_entree_stock->setId_bon_entree_stock($_POST['id_bon_entree_stock']);
                 $detail_bon_entree_stock->setDesignation_articles($_POST['designation_articles']);
                 $detail_bon_entree_stock->setUnite_comptage($_POST['unite_comptage']);
                 $detail_bon_entree_stock->setQuantite($_POST['quantite']);
                 $detail_bon_entree_stock->setPrix_unitaire($_POST['prix_unitaire']);
                 $detail_bon_entree_stock->setMontant($_POST['montant']);
                 $detail_bon_entree_stock->setObservations($_POST['observations']);
                 $detail_bon_entree_stock->setEtat(1);
                 $m_detail_bon_entree_stock->save($detail_bon_entree_stock);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/adddetailbonentreestockadmin');

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




  public function editdetailbonentreestockadminAction() {
    /* page stock/adddetail_bon_entree_stock - Ajout d'une detail_bon_entree_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['id_bon_entree_stock']) && $_POST['id_bon_entree_stock'] != "" && isset($_POST['designation_articles']) && $_POST['designation_articles'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $detail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStock();
                 $m_detail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStockMapper();
                 //$m_detail_bon_entree_stock->find($_POST['id_detail_bon_entree_stock'], $detail_bon_entree_stock);

                 //$detail_bon_entree_stock->setId_detail_bon_entree_stock($id_detail_bon_entree_stock);
                 $detail_bon_entree_stock->setId_bon_entree_stock($_POST['id_bon_entree_stock']);
                 $detail_bon_entree_stock->setDesignation_articles($_POST['designation_articles']);
                 $detail_bon_entree_stock->setUnite_comptage($_POST['unite_comptage']);
                 $detail_bon_entree_stock->setQuantite($_POST['quantite']);
                 $detail_bon_entree_stock->setPrix_unitaire($_POST['prix_unitaire']);
                 $detail_bon_entree_stock->setMontant($_POST['montant']);
                 $detail_bon_entree_stock->setObservations($_POST['observations']);
                 //$detail_bon_entree_stock->setEtat(1);
                 $m_detail_bon_entree_stock->update($detail_bon_entree_stock);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/listdetailbonentreestockadmin');
         
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
               $detail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStock();
               $mdetail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStockMapper();
           $mdetail_bon_entree_stock->find($id,$detail_bon_entree_stock);
           $this->view->detail_bon_entree_stock = $detail_bon_entree_stock;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $detail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStock();
               $mdetail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStockMapper();
           $mdetail_bon_entree_stock->find($id,$detail_bon_entree_stock);
           $this->view->detail_bon_entree_stock = $detail_bon_entree_stock;
       }   
     }

  }


  




  public function listdetailbonentreestockadminAction() {
    /* page stock/listdetail_bon_entree_stock - liste des detail_bon_entree_stocks */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $detail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStockMapper();
    $this->view->entries = $detail_bon_entree_stock->fetchAll();
    //$this->view->entries = $detail_bon_entree_stock->fetchAllByCodeMembreEliUtilisateurValidEtat(0, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etatdetailbonentreestockadminAction()
    {
        /* page stock/etatdetail_bon_entree_stock - Etat une detail_bon_entree_stock */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $detail_bon_entree_stock = new Application_Model_EuDetailBonEntreeStock();
        $detail_bon_entree_stockM = new Application_Model_EuDetailBonEntreeStockMapper();
        $detail_bon_entree_stockM->find($id, $detail_bon_entree_stock);
    
        $detail_bon_entree_stock->setEtat($this->_request->getParam('etat'));
    $detail_bon_entree_stockM->update($detail_bon_entree_stock);
        }

    $this->_redirect('/stock/listdetailbonentreestockadmin');
    }



  public function detaildetailbonentreestockadminAction()
  {
    /* page espacepersonnel/detaildetail_bon_entree_stock - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuDetailBonEntreeStock();
    $ma = new Application_Model_EuDetailBonEntreeStockMapper();
    $ma->find($id, $a);
    $this->view->detail_bon_entree_stock = $a;
      }

  }














  public function addficheexpressionbesoinadminAction() {
    /* page ficheexpressionbesoin/addtdrintegrateur - Ajout d'une fiche_expression_besoin */
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
        if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['designation_article']) && $_POST['designation_article'] != "" && isset($_POST['description_bien']) && $_POST['description_bien'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {

      


                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoin();
                 $m_fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoinMapper();

                 $id_fiche_expression_besoin = $m_fiche_expression_besoin->findConuter() + 1;

                 $fiche_expression_besoin->setId_fiche_expression_besoin($id_fiche_expression_besoin);
                 $fiche_expression_besoin->setDesignation_article($_POST['designation_article']);
                 $fiche_expression_besoin->setDescription_bien($_POST['description_bien']);
                 $fiche_expression_besoin->setQuantite_article($_POST['quantite_article']);
                 $fiche_expression_besoin->setPrix_unitaire($_POST['prix_unitaire']);
                 $fiche_expression_besoin->setVisa_gerant($_POST['visa_gerant']);
                 $fiche_expression_besoin->setAvis_gerant($_POST['avis_gerant']);                
                 $fiche_expression_besoin->setValid_up($_POST['valid_up']);
                 $fiche_expression_besoin->setValid_up($_POST['valid_up']);
                 $fiche_expression_besoin->setDate_demande($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $fiche_expression_besoin->setAppreciation($_POST['appreciation']);
                 $fiche_expression_besoin->setValid(0);
                 $fiche_expression_besoin->setEtat(1);
                 $m_fiche_expression_besoin->save($fiche_expression_besoin);

////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/addficheexpressionbesoinadmin');

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




  public function editficheexpressionbesoinadminAction() {
    /* page ficheexpressionbesoin/addfiche_expression_besoin - Ajout d'une fiche_expression_besoin */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['designation_article']) && $_POST['designation_article'] != "" && isset($_POST['description_bien']) && $_POST['description_bien'] != "") {
         
     $request = $this->getRequest();
     if ($request->isPost ())  {
         $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {


                 $date_id = new Zend_Date(Zend_Date::ISO_8601);

                 $fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoin();
                 $m_fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoinMapper();
                 //$m_fiche_expression_besoin->find($_POST['id_fiche_expression_besoin'], $fiche_expression_besoin);

                 //$fiche_expression_besoin->setId_fiche_expression_besoin($id_fiche_expression_besoin);
                 $fiche_expression_besoin->setDesignation_article($_POST['designation_article']);
                 $fiche_expression_besoin->setDescription_bien($_POST['description_bien']);
                 $fiche_expression_besoin->setQuantite_article($_POST['quantite_article']);
                 $fiche_expression_besoin->setPrix_unitaire($_POST['prix_unitaire']);
                 //$fiche_expression_besoin->setVisa_gerant($_POST['visa_gerant']);
                 //$fiche_expression_besoin->setAvis_gerant($_POST['avis_gerant']);                
                 //$fiche_expression_besoin->setValid_up($_POST['valid_up']);
                 //$fiche_expression_besoin->setValid_up($_POST['valid_up']);
                 $fiche_expression_besoin->setDate_demande($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $fiche_expression_besoin->setAppreciation($_POST['appreciation']);
                 //$fiche_expression_besoin->setValid(0);
                 //$fiche_expression_besoin->setEtat(1);
                 $m_fiche_expression_besoin->update($fiche_expression_besoin);

////////////////////////////////////////////////////////////////////////////////
          

////////////////////////////////////////////////////////////////////////////////

         $db->commit();
           $sessionutilisateur->error = "Operation bien effectuee ...";
                 $this->_redirect('/stock/listficheexpressionbesoinadmin');
         
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
               $fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoin();
               $mfiche_expression_besoin = new Application_Model_EuFicheExpressionBesoinMapper();
           $mfiche_expression_besoin->find($id,$fiche_expression_besoin);
           $this->view->fiche_expression_besoin = $fiche_expression_besoin;
       }   
      }
      }  else {
         $id = (int)$this->_request->getParam('id');
             if($id != 0) {
               $fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoin();
               $mfiche_expression_besoin = new Application_Model_EuFicheExpressionBesoinMapper();
           $mfiche_expression_besoin->find($id,$fiche_expression_besoin);
           $this->view->fiche_expression_besoin = $fiche_expression_besoin;
       }   
     }

  }


  




  public function listficheexpressionbesoinadminAction() {
    /* page ficheexpressionbesoin/listfiche_expression_besoin - liste des fiche_expression_besoins */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoinMapper();
    $this->view->entries = $fiche_expression_besoin->fetchAll();
    //$this->view->entries = $fiche_expression_besoin->fetchAllByCodeMembreEliUtilisateurValidEtat(0, 0, $sessionutilisateur->id_utilisateur, 0, 0);

    $this->view->tabletri = 1;
  }
  
  
    public function etatficheexpressionbesoinadminAction()
    {
        /* page ficheexpressionbesoin/etatfiche_expression_besoin - Etat une fiche_expression_besoin */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoin();
        $fiche_expression_besoinM = new Application_Model_EuFicheExpressionBesoinMapper();
        $fiche_expression_besoinM->find($id, $fiche_expression_besoin);
    
        $fiche_expression_besoin->setEtat($this->_request->getParam('etat'));
    $fiche_expression_besoinM->update($fiche_expression_besoin);
        }

    $this->_redirect('/stock/listficheexpressionbesoinadmin');
    }



  public function detailficheexpressionbesoinadminAction()
  {
    /* page espacepersonnel/detailfiche_expression_besoin - Détail d'une demande */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuFicheExpressionBesoin();
    $ma = new Application_Model_EuFicheExpressionBesoinMapper();
    $ma->find($id, $a);
    $this->view->fiche_expression_besoin = $a;
      }

  }





    public function validficheexpressionbesoinadminAction()
    {
        /* page ficheexpressionbesoin/validfiche_expression_besoin - Valid une fiche_expression_besoin */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoin();
        $fiche_expression_besoinM = new Application_Model_EuFicheExpressionBesoinMapper();
        $fiche_expression_besoinM->find($id, $fiche_expression_besoin);
    
        $fiche_expression_besoin->setValid($this->_request->getParam('valid'));
    $fiche_expression_besoinM->update($fiche_expression_besoin);
        }

    $this->_redirect('/stock/listficheexpressionbesoinadmin');
    }





  public function listficheexpressionbesoinAction() {
    /* page ficheexpressionbesoin/listfiche_expression_besoin - liste des fiche_expression_besoins */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }


    $fiche_expression_besoin = new Application_Model_EuFicheExpressionBesoinMapper();
    //$this->view->entries = $fiche_expression_besoin->fetchAll();
    $this->view->entries = $fiche_expression_besoin->fetchAllByCodeMembreEliUtilisateurValidEtat($sessionmembre->code_membre, 0, 0, 0, 0);

    $this->view->tabletri = 1;
  }
  
  


  public function detailficheexpressionbesoinAction()
  {
    /* page espacepersonnel/detailfiche_expression_besoin - Détail d'une demande */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuFicheExpressionBesoin();
    $ma = new Application_Model_EuFicheExpressionBesoinMapper();
    $ma->find($id, $a);
    $this->view->fiche_expression_besoin = $a;
      }

  }










    public function addbonsortieinterneAction () {

         $db = Zend_Db_Table::getDefaultAdapter();

        $request = $this->getRequest();
        $created = Zend_Date::now();
        $validationdemandeerrors = array();
        $validationbonsortieinternesuccess = array();
      

        if($request->isPost()){
            //$code_membre = $_POST['code_membre'];
            $date_livraison = $_POST['date_livraison'];
            $date_bon_sortie_interne = $_POST['date_bon_sortie_interne'];
            $quantite_article = $_POST['quantite_article'];
            $prix_unitaire = $_POST['prix_unitaire'];
            $imputation = $_POST['imputation'];
            $nature_article = $_POST['nature_article'];
            $objet_bon_sortie = $_POST['objet_bon_sortie'];
            $nom_beneficiaire = $_POST['nom_beneficiaire'];
            $no_vehicule = $_POST['no_vehicule'];
            $montant_total_bon_sortie_interne = $_POST['montant_total_bon_sortie_interne'];            

    
    /***Verification du contenu des variables */

            if($date_bon_sortie_interne == "") {
                $validationdemandeerrors['empty_date_bon_sortie_interne'] = "Echec d'enregistrement:La date du bon de sortie ne doit pas être vide";
            }
            if($nature_article == "") {
                $validationdemandeerrors['empty_nature_article'] = "Echec d'enregistrement:La nature de l'article du bon de sortie ne doit pas être vide";
            }

            if($quantite_article == "") {
                $validationdemandeerrors['empty_quantite_article'] = "Echec d'enregistrement:La quantité du bon de sortie ne doit pas être vide";
            }

            if($objet_bon_sortie == "") {
                $validationdemandeerrors['empty_objet_bon_sortie'] = "Echec d'enregistrement:L'objet/motif du bon de sortie ne doit pas être vide";
            }
            
            if($prix_unitaire == "") {
                $validationdemandeerrors['empty_prix_unitaire'] = "Echec d'enregistrement:Le prix unitaire ne doit pas être vide";
            }

            if($montant_total_bon_sortie_interne == "") {
                $validationdemandeerrors['empty_montant_total_bon_sortie_interne'] = "Echec d'enregistrement:Le montant total du bon de sortie ne doit pas être vide";
            }

            if($imputation == "") {
                $validationdemandeerrors['empty_imputation'] = "Echec d'enregistrement:L'imputation ne doit pas être vide";
            }

            if($nom_beneficiaire == "") {
                $validationdemandeerrors['empty_nom_beneficiaire'] = "Echec d'enregistrement:Le nom du beneficiaire ne doit pas être vide";
            }

            if($no_vehicule == "") {
                $validationdemandeerrors['empty_no_vehicule'] = "Echec d'enregistrement:Le numero du vehicule ne doit pas être vide";
            }

            if($date_livraison == "") {
                $validationdemandeerrors['empty_date_livraison'] = "Echec d'enregistrement:La date de livraison ne doit pas être vide";
            }

    
            /***Verification de l'existence des variable */
    
            if(!isset($date_bon_sortie_interne)){
                $validationdemandeerrors['exist_date_bon_sortie_interne'] = "Echec d'enregistrement:La date du bon de sortie est inexistant";
            }

            if(!isset($nature_article)){
                $validationdemandeerrors['exist_nature_article'] = "Echec d'enregistrement:La nature de l'article est inexistant";
            }

            if(!isset($quantite_article)){
                $validationdemandeerrors['exist_quantite_article'] = "Echec d'enregistrement:La quantite de l'article est inexistant";
            }

            if(!isset($objet_bon_sortie)){
                $validationdemandeerrors['exist_objet_bon_sortie_interne'] = "Echec d'enregistrement:L'objet du bon de sortie est inexistant";
            }

            if(!isset($prix_unitaire)){
                $validationdemandeerrors['exist_prix_unitaire'] = "Echec d'enregistrement:Le prix unitaire de l'article est inexistant";
            }

            if(!isset($montant_total_bon_sortie_interne)){
                $validationdemandeerrors['exist_montant_total_bon_sortie_interne'] = "Echec d'enregistrement:Le montant total du bon de sortie est inexistant";
            }

            if(!isset($imputation)){
                $validationdemandeerrors['exist_imputation'] = "Echec d'enregistrement:L'imputation du bon de sortie est inexistant";
            }

            if(!isset($nom_beneficiaire)){
                $validationdemandeerrors['exist_nom_beneficiaire'] = "Echec d'enregistrement:Le nom du beneficiaire est inexistant";
            }

            if(!isset($no_vehicule)){
                $validationdemandeerrors['exist_no_vehicule'] = "Echec d'enregistrement:Le numero du vehicule du bon de sortie est inexistant";
            }

            if(!isset($date_livraison)){
                $validationdemandeerrors['exist_date_livraison'] = "Echec d'enregistrement:La date de livraison de l'article est inexistant";
            }

            if(!empty($validationdemandeerrors)){
                $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
            }

            if (empty($validationdemandeerrors)){


               $dbfinsert = "INSERT INTO 
                              eu_bon_sortie_interne(
                               date_bon_sortie_interne,
                               nature_article,
                               objet_bon_sortie,
                               quantite_article,
                               prix_unitaire,
                               montant_total_bon_sortie_interne,
                               imputation,
                               nom_beneficiaire,
                               no_vehicule,
                               date_livraison) 
                               VALUES (
                               '$date_bon_sortie_interne',
                               '$nature_article',
                               '$objet_bon_sortie',
                               '$quantite_article',
                               '$prix_unitaire',
                               '$montant_total_bon_sortie_interne',
                               '$imputation',
                               '$nom_beneficiaire',
                               '$no_vehicule',
                               '$date_livraison'
                               )";
                       $db->setFetchMode(Zend_Db::FETCH_OBJ);
                       $stmt = $db->query($dbfinsert);

                   $validationsuccess['success_message'] = "Enregistrement du bon de sortie effectué avec succes";
                   $_SESSION['validationsuccess'] = $validationsuccess;
               }else{
                   $validationdemandeerrors['verif_montant_total_bon_sortie'] = "Error:Echec d'enregistrement";
                   $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
                   
               }
       
             }
        

    }


    public function detailbonsortieinterneAction()
        {
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $id = (int)$this->_request->getParam('id');

        $dbselect = "SELECT * FROM eu_bon_sortie_interne WHERE id_bon_sortie_interne ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbonsortie = $stmt->fetchAll();
        $this->view->detailbonsortie = $dbsearchbonsortie;
        
        }

public function editbonsortieinterneAction()
        {
        $db = Zend_Db_Table::getDefaultAdapter();
        $id = (int)$this->_request->getParam('id');
        $request = $this->getRequest();

        $dbselect = "SELECT * FROM eu_bon_sortie_interne WHERE id_bon_sortie_interne ='$id'";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbsearchbonsortie = $stmt->fetchAll();
        $this->view->detailbonsortie = $dbsearchbonsortie;

        if($request->isPost()){
            $id_bon_sortie_interne = $_POST['id_bon_sortie_interne'];
            $date_livraison = $_POST['date_livraison'];
            $date_bon_sortie_interne = $_POST['date_bon_sortie_interne'];
            $quantite_article = $_POST['quantite_article'];
            $prix_unitaire = $_POST['prix_unitaire'];
            $imputation = $_POST['imputation'];
            $nature_article = $_POST['nature_article'];
            $objet_bon_sortie = $_POST['objet_bon_sortie'];
            $nom_beneficiaire = $_POST['nom_beneficiaire'];
            $no_vehicule = $_POST['no_vehicule'];
            $montant_total_bon_sortie_interne = $_POST['montant_total_bon_sortie_interne'];            

    
    /***Verification du contenu des variables */

            if($date_bon_sortie_interne == "") {
                $validationdemandeerrors['empty_date_bon_sortie_interne'] = "Echec d'enregistrement:La date du bon de sortie ne doit pas être vide";
            }
            if($nature_article == "") {
                $validationdemandeerrors['empty_nature_article'] = "Echec d'enregistrement:La nature de l'article du bon de sortie ne doit pas être vide";
            }

            if($quantite_article == "") {
                $validationdemandeerrors['empty_quantite_article'] = "Echec d'enregistrement:La quantité du bon de sortie ne doit pas être vide";
            }

            if($objet_bon_sortie == "") {
                $validationdemandeerrors['empty_objet_bon_sortie'] = "Echec d'enregistrement:L'objet/motif du bon de sortie ne doit pas être vide";
            }
            
            if($prix_unitaire == "") {
                $validationdemandeerrors['empty_prix_unitaire'] = "Echec d'enregistrement:Le prix unitaire ne doit pas être vide";
            }

            if($montant_total_bon_sortie_interne == "") {
                $validationdemandeerrors['empty_montant_total_bon_sortie_interne'] = "Echec d'enregistrement:Le montant total du bon de sortie ne doit pas être vide";
            }

            if($imputation == "") {
                $validationdemandeerrors['empty_imputation'] = "Echec d'enregistrement:L'imputation ne doit pas être vide";
            }

            if($nom_beneficiaire == "") {
                $validationdemandeerrors['empty_nom_beneficiaire'] = "Echec d'enregistrement:Le nom du beneficiaire ne doit pas être vide";
            }

            if($no_vehicule == "") {
                $validationdemandeerrors['empty_no_vehicule'] = "Echec d'enregistrement:Le numero du vehicule ne doit pas être vide";
            }

            if($date_livraison == "") {
                $validationdemandeerrors['empty_date_livraison'] = "Echec d'enregistrement:La date de livraison ne doit pas être vide";
            }

    
            /***Verification de l'existence des variable */
    
            if(!isset($date_bon_sortie_interne)){
                $validationdemandeerrors['exist_date_bon_sortie_interne'] = "Echec d'enregistrement:La date du bon de sortie est inexistant";
            }

            if(!isset($nature_article)){
                $validationdemandeerrors['exist_nature_article'] = "Echec d'enregistrement:La nature de l'article est inexistant";
            }

            if(!isset($quantite_article)){
                $validationdemandeerrors['exist_quantite_article'] = "Echec d'enregistrement:La quantite de l'article est inexistant";
            }

            if(!isset($objet_bon_sortie)){
                $validationdemandeerrors['exist_objet_bon_sortie_interne'] = "Echec d'enregistrement:L'objet du bon de sortie est inexistant";
            }

            if(!isset($prix_unitaire)){
                $validationdemandeerrors['exist_prix_unitaire'] = "Echec d'enregistrement:Le prix unitaire de l'article est inexistant";
            }

            if(!isset($montant_total_bon_sortie_interne)){
                $validationdemandeerrors['exist_montant_total_bon_sortie_interne'] = "Echec d'enregistrement:Le montant total du bon de sortie est inexistant";
            }

            if(!isset($imputation)){
                $validationdemandeerrors['exist_imputation'] = "Echec d'enregistrement:L'imputation du bon de sortie est inexistant";
            }

            if(!isset($nom_beneficiaire)){
                $validationdemandeerrors['exist_nom_beneficiaire'] = "Echec d'enregistrement:Le nom du beneficiaire est inexistant";
            }

            if(!isset($no_vehicule)){
                $validationdemandeerrors['exist_no_vehicule'] = "Echec d'enregistrement:Le numero du vehicule du bon de sortie est inexistant";
            }

            if(!isset($date_livraison)){
                $validationdemandeerrors['exist_date_livraison'] = "Echec d'enregistrement:La date de livraison de l'article est inexistant";
            }

            if(!empty($validationdemandeerrors)){
                $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
            }

            if (empty($validationdemandeerrors)){

               $dbfupdate = "UPDATE eu_bon_sortie_interne SET 
                               date_bon_sortie_interne='$date_bon_sortie_interne',
                               nature_article='$nature_article',
                               quantite_article='$quantite_article',
                               objet_bon_sortie='$objet_bon_sortie',
                               prix_unitaire='$prix_unitaire',
                               montant_total_bon_sortie_interne='$montant_total_bon_sortie_interne',
                               imputation='$imputation',
                               no_vehicule='$no_vehicule',
                               date_livraison='$date_livraison',
                               nom_beneficiaire='$nom_beneficiaire'
                               WHERE id_bon_sortie_interne='$id_bon_sortie_interne' 
                              ";
                       $db->setFetchMode(Zend_Db::FETCH_OBJ);
                       $stmt = $db->query($dbfupdate);
                   $validationsuccess['success_message'] = "Modification de la fiche effectuee avec succes";
                   $_SESSION['validationsuccess'] = $validationsuccess;
                   $this->redirect('/stock/listbonsortieinterne');
               }else{
                   /*$validationdemandeerrors['verif_montant_total_bon_sortie'] = "Error:Echec d'enregistrement";
                   $_SESSION['validationdemandeerrors'] = $validationdemandeerrors;
                   */
               }
        }
       
             }


    public function listbonsortieinterneAction(){

        $db = Zend_Db_Table::getDefaultAdapter();

        $dbselect = "SELECT * FROM eu_bon_sortie_interne";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbselect);
        $dbrecupallbonsortie = $stmt->fetchAll();
        $this->view->bonsortie = $dbrecupallbonsortie;

    }





}
