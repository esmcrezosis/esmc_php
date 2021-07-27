<?php

class PointageController extends Zend_Controller_Action{

  public function init() {
    /* Initialize action controller here */
    include("Url.php");
  }


  public function addpostepointageAction() {
    /* page pointage/addpostepointage - Ajout d'une postepointage */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['libelle_poste_pointage']) && $_POST['libelle_poste_pointage'] != "" && isset($_POST['taux_horaire']) && $_POST['taux_horaire'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $postepointage = new Application_Model_EuPostePointage();
        $m_postepointage = new Application_Model_EuPostePointageMapper();

        $id_poste_pointage = $m_postepointage->findConuter() + 1;

          $postepointage->setId_poste_pointage($id_poste_pointage);
          $postepointage->setLibelle_poste_pointage($_POST['libelle_poste_pointage']);
          $postepointage->setTaux_horaire($_POST['taux_horaire']);
          $postepointage->setCode_membre_employeur($sessionmembre->code_membre);
          $m_postepointage->save($postepointage);

          //$this->_redirect('/pointage/listpostepointage');
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function editpostepointageAction() {
    /* page pointage/editpostepointage - Modification d'une postepointage */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['libelle_poste_pointage']) && $_POST['libelle_poste_pointage'] != "" && isset($_POST['taux_horaire']) && $_POST['taux_horaire'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $postepointage = new Application_Model_EuPostePointage();
        $m_postepointage = new Application_Model_EuPostePointageMapper();

        $m_postepointage->find($_POST['id_poste_pointage'], $postepointage);

          $postepointage->setLibelle_poste_pointage($_POST['libelle_poste_pointage']);
          $postepointage->setTaux_horaire($_POST['taux_horaire']);
          $m_postepointage->update($postepointage);

          $this->_redirect('/pointage/listpostepointage');
  }  else { $this->view->error = "Les champs * sont obligatoires ...";

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuPostePointage();
    $ma = new Application_Model_EuPostePointageMapper();
    $ma->find($id, $a);
    $this->view->postepointage = $a;
      }
  }

  } else {

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuPostePointage();
    $ma = new Application_Model_EuPostePointageMapper();
    $ma->find($id, $a);
    $this->view->postepointage = $a;
      }
  }
  }




  public function listpostepointageAction() {
    /* page pointage/listpostepointage - liste des postepointages */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $postepointage = new Application_Model_EuPostePointageMapper();
    $this->view->entries = $postepointage->fetchAllByEmployeur($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }




  public function supppostepointageAction()
  {
    /* page pointage/supppostepointage - Suppression d'une postepointage */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {
       $postepointageM = new Application_Model_EuPostePointageMapper();
       $postepointageM->delete($id);
    }
    $this->_redirect('/pointage/listpostepointage');
  }

  
  
  public function adddemandeAction() {
     /* page pointage/addpointage - Ajout d'une pointage */
     $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre))  {
        $this->_redirect('/');
     }
	   
	 $request = $this->getRequest();
	 $date_id = new Zend_Date(Zend_Date::ISO_8601);
	   
	 if($request->isPost())  {
	   $db = Zend_Db_Table::getDefaultAdapter();
       $db->beginTransaction();
       try {
	        $periode = $request->getParam("periode");
			list($debut, $fin) = explode("/",$periode);
			  
			$debut = new Zend_Date($debut);
			$fin = new Zend_Date($fin);
			
			$date_debut = new Zend_Date($debut);
			$date_fin   = new Zend_Date($fin);
			
			$fin->addDay(1);
			  
			$debut = $debut->toString('yyyy-MM-dd');
			$fin   = $fin->toString('yyyy-MM-dd');
			  
			$date_debut = $date_debut->toString('yyyy-MM-dd');
			$date_fin   = $date_fin->toString('yyyy-MM-dd');
			  
			$this->view->debut = $debut;
            $this->view->fin = $fin;
			  
			$montanttotal = 0;
			$montantemploye = 0;
			$nombre_heure = 0;
			  
			$date1 = "";
			$date2 = "";
			$time1 = "";
			$time2 = "";

			$postepointage_mapper = new Application_Model_EuPostePointageMapper();
            $postepointage = new Application_Model_EuPostePointage();
			  
            $pointage_mapper = new Application_Model_EuPointageMapper();
            $pointage = new Application_Model_EuPointage();
			  
			$demande_mapper = new Application_Model_EuDemandePaiementMapper();
            $demande = new Application_Model_EuDemandePaiement();
			  
			$paiement_mapper = new Application_Model_EuPaiementMapper();
            $paiement = new Application_Model_EuPaiement();
			  
			$detailpaie_mapper = new Application_Model_EuDetailPaiementMapper();
            $detailpaie = new Application_Model_EuDetailPaiement();
			
			$type_demande = "Pointage";
			
			$findpp = $demande_mapper->fetchAllByQuizaine($sessionmembre->code_membre,$date_debut,$date_fin,$type_demande);
			
			if($findpp != NULL) {
			   $db->rollback();
               $this->view->error = "La demande de paiement des pointages a ete deja emise pour cette date ...!!!";
               return;
			}

            $tab_pointages = $pointage_mapper->fetchAllEmployeurByDate($debut,$fin,$sessionmembre->code_membre);
			  
			if ($tab_pointages != NULL)  {
			   $j = 0;
			   while($j < count($tab_pointages))  { 
				    $tab_pointage = $tab_pointages[$j];
				    $pointage_model = new Application_Model_EuPointage();
				    $pointage_mapper->find($tab_pointage->getId_pointage(),$pointage_model);
				    $findpostepointage = $postepointage_mapper->find($tab_pointage->getId_poste_pointage(),$postepointage);
					$date1 = new Zend_Date($tab_pointage->date_heure_fin);
                    $date2 = new Zend_Date($tab_pointage->date_heure_debut);
                    $time1 = $date1->getTimestamp();
                    $time2 = $date2->getTimestamp();
                    if($time1 > $time2) {
                      $time = $time1 - $time2;
                    } else {
                      $time = $time2 - $time1;
                    }
                    $time = $time / 3600;
					$nombre_heure = $time;
					$montanttotal = $montanttotal + ($nombre_heure * $postepointage->taux_horaire);    
				    $j = $j + 1;
					$nombre_heure = 0;
                  }				  
			  } else {
				  $db->rollback();
                  $this->view->error = "Il n'y a aucun pointage correspondant &agrave; cette date ...!!! ";
                  return;   
              }
			  
			  $id_demande_paiement = $demande_mapper->findConuter() + 1;
			  $demande->setId_demande_paiement($id_demande_paiement)
                      ->setMontant_demande_paiement($montanttotal)
                      ->setDate_demande_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'))
					  ->setCode_membre_employeur($sessionmembre->code_membre)
					  ->setDate_debut($date_debut)
					  ->setDate_fin($date_fin)
					  ->setPayer(0)
					  ->setType_demande("Pointage");
			  $demande_mapper->save($demande);
			  
			  $tab_employes = $pointage_mapper->fetchAllEmployer($debut,$fin);
			  
			  if(count($tab_employes) > 0) {
			    foreach ($tab_employes as $tab_employe)  {
			      $code_membre_employe = $tab_employe['employe'];
				  $tabeau_pointages = $pointage_mapper->fetchAllEmployeByDate($code_membre_employe,$debut,$fin);
				  $j = 0;
				  while($j < count($tabeau_pointages))  { 
				     $tabeau_pointage = $tabeau_pointages[$j];
				     $pointage_model = new Application_Model_EuPointage();
				     $pointage_mapper->find($tabeau_pointage->getId_pointage(),$pointage_model);
				     $findpostepointage = $postepointage_mapper->find($tabeau_pointage->getId_poste_pointage(),$postepointage);
					 $date1 = new Zend_Date($tabeau_pointage->date_heure_fin);
                     $date2 = new Zend_Date($tabeau_pointage->date_heure_debut);
                     $time1 = $date1->getTimestamp();
                     $time2 = $date2->getTimestamp();
                     if($time1 > $time2) {
                       $time = $time1 - $time2;
                     } else {
                       $time = $time2 - $time1;
                     }
                     $time = $time / 3600;
					 $nombre_heure = $time;
					 $montantemploye = $montantemploye + ($nombre_heure * $postepointage->taux_horaire);    
				     $j = $j + 1;
					 $nombre_heure = 0;
                  }
				  $id_paiement = $paiement_mapper->findConuter() + 1;
			      $paiement->setId_paiement($id_paiement)
                           ->setMontant_paiement($montantemploye)
                           ->setDate_paiement($date_id->toString('yyyy-MM-dd HH:mm:ss'))
					       ->setCode_membre_employe($code_membre_employe)
					       ->setId_demande_paiement($id_demande_paiement);
			      $paiement_mapper->save($paiement);
				  
				  $tableau_pointages = $pointage_mapper->fetchAllEmployeByDate($code_membre_employe,$debut,$fin);
				  $j = 0;
				  while($j < count($tableau_pointages))  { 
				     $tableau_pointage = $tableau_pointages[$j];
				     $pointage_model = new Application_Model_EuPointage();
				     $pointage_mapper->find($tableau_pointage->getId_pointage(),$pointage_model);
				     $findpostepointage = $postepointage_mapper->find($tableau_pointage->getId_poste_pointage(),$postepointage);
					 $date1 = new Zend_Date($tableau_pointage->date_heure_fin);
                     $date2 = new Zend_Date($tableau_pointage->date_heure_debut);
                     $time1 = $date1->getTimestamp();
                     $time2 = $date2->getTimestamp();
                     if($time1 > $time2) {
                       $time = $time1 - $time2;
                     } else {
                       $time = $time2 - $time1;
                     }
                     $time = $time / 3600;
					 $nombre_heure = $time;
                     
					 $id_detail_paiement = $detailpaie_mapper->findConuter() + 1;
			         $detailpaie->setId_detail_paiement($id_detail_paiement)
                                ->setMontant_paiement($nombre_heure * $postepointage->taux_horaire)
                                ->setId_pointage($tableau_pointage->id_pointage)
					            ->setId_paiement($id_paiement);
			         $detailpaie_mapper->save($detailpaie);
					 
					 $tableau_pointage->setTraiter(1);
					 $pointage_mapper->update($tableau_pointage);
					 
				     $j = $j + 1;
					 $nombre_heure = 0;
					 $montantemploye = 0;
                  }				  
				 } 
			  }			  
			  $db->commit();
			  $sessionmembre->error = "Operation bien effectuee ...";
			  $this->view->montanttotal = $montanttotal;
			  $this->_redirect('/pointage/listdemande');
	   
	      } catch (Exception $exc)  {
			 $db->rollback();
             $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
             return;
		  }
	   
       }
  
  }




  public function addpointageAction() {
    /* page pointage/addpointage - Ajout d'une pointage */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_membre_employe']) && $_POST['code_membre_employe'] != "" && isset($_POST['date_debut']) && $_POST['date_debut'] != "" && isset($_POST['heure_debut']) && $_POST['heure_debut'] != "" && isset($_POST['date_fin']) && $_POST['date_fin'] != "" && isset($_POST['heure_fin']) && $_POST['heure_fin'] != "" && isset($_POST['id_poste_pointage']) && $_POST['id_poste_pointage'] != "") {
         
		 $request = $this->getRequest();
		 if ($request->isPost ())  {
		     $db = Zend_Db_Table::getDefaultAdapter();
             $db->beginTransaction();
             try {
                 $date_id = new Zend_Date(Zend_Date::ISO_8601);
                 $pointage = new Application_Model_EuPointage();
                 $m_pointage = new Application_Model_EuPointageMapper();

                 $id_pointage = $m_pointage->findConuter() + 1;

                 $pointage->setId_pointage($id_pointage);
                 $pointage->setCode_membre_employe($_POST['code_membre_employe']);
                 $pointage->setDate_heure_debut($_POST['date_debut']." ".$_POST['heure_debut']);
                 $pointage->setDate_heure_fin($_POST['date_fin']." ".$_POST['heure_fin']);
                 $pointage->setId_poste_pointage($_POST['id_poste_pointage']);
				 $pointage->setTraiter(0);
				 $pointage->setDate_pointage($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                 $m_pointage->save($pointage);

				 $db->commit();
			     $sessionmembre->error = "Operation bien effectuee ...";
                 $this->_redirect('/pointage/listpointage');
				 
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



  




  public function listpointageAction() {
    /* page pointage/listpointage - liste des pointages */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $pointage = new Application_Model_EuPointageMapper();
    $this->view->entries = $pointage->fetchAllByEmployeur($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }
  
  
  
  
  public function listdemandeAction() {
     /* page pointage/listdemande - liste des demandes de paiement */
     $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if(!isset($sessionmembre->code_membre)) {
        $this->_redirect('/');
     }

     $demande = new Application_Model_EuDemandePaiementMapper();
     $this->view->entries = $demande->fetchAllByEmployeur($sessionmembre->code_membre);

     $this->view->tabletri = 1;
  }
  
  
  public function detaildemandeAction() {
     /* page pointage/listdemande - liste des demandes de paiement */
     $sessionmembre = new Zend_Session_Namespace('membre');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if(!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
     }
	 $id = $this->_request->getParam('id');
     $m_paiement = new Application_Model_EuPaiementMapper();
     $this->view->entries = $m_paiement->fetchAllByDemande($id);
     $this->view->tabletri = 1;
  }







  public function listpointageemployeAction() {
    /* page pointage/listpointage - liste des pointages */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $pointage = new Application_Model_EuPointageMapper();
    $this->view->entries = $pointage->fetchAllByEmploye($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }





  public function supppointageAction()
  {
    /* page pointage/supppointage - Suppression d'une pointage */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {

      $pointageM = new Application_Model_EuPointageMapper();
      $pointageM->delete($id);
    }

    $this->_redirect('/pointage/listpointage');
  }








}
