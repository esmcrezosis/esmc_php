<?php

class RecurrentJournalierController extends Zend_Controller_Action {

	public function init()
	{
		/* Initialize action controller here */
      
      include("Url.php");

	}


    public function loadcantonAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $prefecture = $request->getParam("id_prefecture");
        $t_canton = new Application_Model_DbTable_EuCanton();
        if (!empty($prefecture)) {
            $select = $t_canton->select()->where('id_prefecture = ?', $prefecture);
            $this->view->cantons = $t_canton->fetchAll($select);
        } else {
            $this->view->cantons = $t_canton->fetchAll();
        }
    }

	
    public function prefectureAction() {
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $region = $request->getParam("id_region");
        $entries = array();
        $t_prefect = new Application_Model_DbTable_EuPrefecture();
        if (!empty($region)) {
            $select = $t_prefect->select()->where('id_region = ?', $region);
            $entries = $t_prefect->fetchAll($select);
            $this->view->prefectures = $entries;
        } else {
            $this->view->prefectures = $t_prefect->fetchAll();
        }
    }

	
	
    public function loadregionAction() {
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $pays = $request->getParam("id_pays");
        $t_region = new Application_Model_DbTable_EuRegion();
        if (!empty($pays)) {
            $select = $t_region->select()->where('id_pays = ?', $pays);
            $this->view->regions = $t_region->fetchAll($select);
        } else {
            $this->view->regions = $t_region->fetchAll();
        }
    }

    public function loadpaysAction() {
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $zone = $request->getParam("code_zone");
        $t_pays = new Application_Model_DbTable_EuPays();
        if (!empty($zone)) {
            $select = $t_pays->select()->where('code_zone = ?', $zone);
            $this->view->pays = $t_pays->fetchAll($select);
        } else {
            $this->view->pays = $t_pays->fetchAll();
        }
    }




	public function indexAction() {
		/* page espacepersonnel/index - Tableau de bord de Espace Personnel/Professionnel */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
	}




	public function addrecurrentjournalierAction()
	{
		/* page recurrentjournalier/recurrentjournalier - Ajout de recurrent journalier */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}


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

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['produit']) && $_POST['produit']!="" && 
		isset($_POST['montant_journalier']) && $_POST['montant_journalier']!="" && 
		isset($_POST['frequence_cumul']) && $_POST['frequence_cumul']!="" && 
		isset($_POST['id_canton']) && $_POST['id_canton']!="") {


		$date_id = new Zend_Date(Zend_Date::ISO_8601);
		$a = new Application_Model_EuRecurrentJournalier();
		$ma = new Application_Model_EuRecurrentJournalierMapper();

		$compteur = $ma->findConuter() + 1;
		$a->setId_recurrent_journalier($compteur);
		$a->setId_type_produit($_POST['produit']);
		$a->setMontant_journalier($_POST['montant_journalier']);
		$a->setMontant_total($_POST['montant_total']);
		$a->setFrequence_cumul($_POST['frequence_cumul']);
		$a->setId_canton($_POST['id_canton']);
		$a->setDate_debut(NULL);
		$a->setCode_membre($sessionmembre->code_membre);
		$a->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
		$ma->save($a);

		$this->_redirect('/recurrentjournalier/listrecurrentjournalier');
		
		}else {  $this->view->error = "Les champs * sont obligatoires ...";  }
		}

	}





	public function listrecurrentjournalierAction()
	{
		/* page recurrentjournalier/listrecurrentjournalier - Liste de recurrent journalier */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$recurrentjournalier = new Application_Model_EuRecurrentJournalierMapper();
		$this->view->entries = $recurrentjournalier->fetchAllByTypeProduitCantonCodeMembre(0, 0, $sessionmembre->code_membre);
		
		$this->view->tabletri = 1;

	}








	public function addrepasAction()
	{
		/* page recurrentjournalier/addrepas - Ajout de repas */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}



	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['libelle_repas']) && $_POST['libelle_repas']!="") {


		$date_id = new Zend_Date(Zend_Date::ISO_8601);
		$a = new Application_Model_EuRepas();
		$ma = new Application_Model_EuRepasMapper();

		$compteur = $ma->findConuter() + 1;
		$a->setId_repas($compteur);
		$a->setLibelle_repas($_POST['libelle_repas']);
		$a->setCode_membre($sessionmembre->code_membre);
		$ma->save($a);

		$this->_redirect('/recurrentjournalier/listrepas');
		
		}else {  $this->view->error = "Les champs * sont obligatoires ...";  }
		}

	}





	public function listrepasAction()
	{
		/* page recurrentjournalier/listrepas - Liste de repas */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$repas = new Application_Model_EuRepasMapper();
		$this->view->entries = $repas->fetchAllByCodeMembre($sessionmembre->code_membre);
		
		$this->view->tabletri = 1;

	}








	public function addrepasmenuAction()
	{
		/* page recurrentjournalier/addrepasmenu - Ajout de repas menu */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}



	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['jour_semaine']) && $_POST['jour_semaine']!="" && isset($_POST['id_repas']) && $_POST['id_repas']!="") {


		$date_id = new Zend_Date(Zend_Date::ISO_8601);
		$a = new Application_Model_EuRepasMenu();
		$ma = new Application_Model_EuRepasMenuMapper();


for ($i=0; $i < 7; $i++) { 
	# code...
if(isset($_POST['jour_semaine'][$i]) && $_POST['jour_semaine'][$i] > 0){

	for ($j=0; $j < count($_POST['id_repas'][$i]); $j++) { 
		# code...
	if(isset($_POST['id_repas'][$i][$j]) && $_POST['id_repas'][$i][$j] > 0){

		$compteur = $ma->findConuter() + 1;
		$a->setId_repas_menu($compteur);
		$a->setId_repas($_POST['id_repas'][$i][$j]);
		$a->setCode_membre($sessionmembre->code_membre);
		$a->setJour_semaine($_POST['jour_semaine'][$i]);
		$a->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
		$ma->save($a);

	}

	}
}

}


		$this->_redirect('/recurrentjournalier/listrepasmenu');
		
		}else {  $this->view->error = "Les champs * sont obligatoires ...";  }
		}

	}





	public function listrepasmenuAction()
	{
		/* page recurrentjournalier/listrepasmenu - Liste de repas menu*/

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$repas_menu = new Application_Model_EuRepasMenuMapper();
		$this->view->entries = $repas_menu->fetchAllByCodeMembre($sessionmembre->code_membre);
		
		$this->view->tabletri = 1;

	}



	public function listrepasmenusemaineAction()
	{
		/* page recurrentjournalier/listrepasmenusemaine - Liste de repas menu semaine*/

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$repas_menu = new Application_Model_EuRepasMenuMapper();
		$this->view->entries1 = $repas_menu->fetchAllByCodeMembreJourSemaine($sessionmembre->code_membre, 1);
		$this->view->entries2 = $repas_menu->fetchAllByCodeMembreJourSemaine($sessionmembre->code_membre, 2);
		$this->view->entries3 = $repas_menu->fetchAllByCodeMembreJourSemaine($sessionmembre->code_membre, 3);
		$this->view->entries4 = $repas_menu->fetchAllByCodeMembreJourSemaine($sessionmembre->code_membre, 4);
		$this->view->entries5 = $repas_menu->fetchAllByCodeMembreJourSemaine($sessionmembre->code_membre, 5);
		$this->view->entries6 = $repas_menu->fetchAllByCodeMembreJourSemaine($sessionmembre->code_membre, 6);
		$this->view->entries7 = $repas_menu->fetchAllByCodeMembreJourSemaine($sessionmembre->code_membre, 7);
		
		$this->view->tabletri = 1;

	}










	public function addrepasmenumembreAction()
	{
		/* page recurrentjournalier/addrepasmenumembre - Ajout de repas menu membre*/

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}



	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['jour_semaine']) && $_POST['jour_semaine']!="" && isset($_POST['id_repas']) && $_POST['id_repas']!="" && isset($_POST['code_membre_restaurant']) && $_POST['code_membre_restaurant']!="") {


		$date_id = new Zend_Date(Zend_Date::ISO_8601);
		$a = new Application_Model_EuRepasMenuMembre();
		$ma = new Application_Model_EuRepasMenuMembreMapper();


for ($i=0; $i < 7; $i++) { 
	# code...
if(isset($_POST['jour_semaine'][$i]) && $_POST['jour_semaine'][$i] > 0){

	for ($j=0; $j < count($_POST['id_repas'][$i]); $j++) { 
		# code...
	if(isset($_POST['id_repas'][$i][$j]) && $_POST['id_repas'][$i][$j] > 0){

		$compteur = $ma->findConuter() + 1;
		$a->setId_repas_menu_membre($compteur);
		$a->setId_repas($_POST['id_repas'][$i][$j]);
		$a->setCode_membre_client($sessionmembre->code_membre);
		$a->setJour_semaine($_POST['jour_semaine'][$i]);
		$a->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
		$a->setCode_membre_restaurant($_POST['code_membre_restaurant'][$i]);
		$ma->save($a);

	}

	}
}

}


		$this->_redirect('/recurrentjournalier/listrepasmenumembre');
		
		}else {  $this->view->error = "Les champs * sont obligatoires ...";  }
		}

	}





	public function listrepasmenumembreAction()
	{
		/* page recurrentjournalier/listrepasmenumembre - Liste de repas menu membre*/

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$repas_menu_membre = new Application_Model_EuRepasMenuMembreMapper();
		$this->view->entries = $repas_menu_membre->fetchAllByCodeMembreClient($sessionmembre->code_membre);
		
		$this->view->tabletri = 1;

	}



	public function listrepasmenumembresemaineAction()
	{
		/* page recurrentjournalier/listrepasmenumembresemaine - Liste de repas menu membre semaine*/

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$repas_menu_membre = new Application_Model_EuRepasMenuMembreMapper();
		$this->view->entries1 = $repas_menu_membre->fetchAllByCodeMembreClientJourSemaineCodeMembreRestaurant($sessionmembre->code_membre, 1, "");
		$this->view->entries2 = $repas_menu_membre->fetchAllByCodeMembreClientJourSemaineCodeMembreRestaurant($sessionmembre->code_membre, 2, "");
		$this->view->entries3 = $repas_menu_membre->fetchAllByCodeMembreClientJourSemaineCodeMembreRestaurant($sessionmembre->code_membre, 3, "");
		$this->view->entries4 = $repas_menu_membre->fetchAllByCodeMembreClientJourSemaineCodeMembreRestaurant($sessionmembre->code_membre, 4, "");
		$this->view->entries5 = $repas_menu_membre->fetchAllByCodeMembreClientJourSemaineCodeMembreRestaurant($sessionmembre->code_membre, 5, "");
		$this->view->entries6 = $repas_menu_membre->fetchAllByCodeMembreClientJourSemaineCodeMembreRestaurant($sessionmembre->code_membre, 6, "");
		$this->view->entries7 = $repas_menu_membre->fetchAllByCodeMembreClientJourSemaineCodeMembreRestaurant($sessionmembre->code_membre, 7, "");
		
		$this->view->tabletri = 1;

	}






	public function listrepasmenumembreparjourAction()
	{
		/* page recurrentjournalier/listrepasmenumembreparjour - Liste de repas menu membre semaine par jour*/

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['jour_semaine']) && $_POST['jour_semaine']!="") {

		$repas_menu_membre = new Application_Model_EuRepasMenuMembreMapper();
		$this->view->entries = $repas_menu_membre->fetchAllByJourSemaineCodeMembreRestaurant($_POST['jour_semaine'], $sessionmembre->code_membre);

		}else {  $this->view->error = "Les champs * sont obligatoires ...";  }
		}
		
		$this->view->tabletri = 1;

	}








	public function addcommandenrAction()
	{
		/* page recurrentjournalier/addcommandenr - Ajout de commande nr */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}


	$tauxescompte = Util_Utils::getParametre('taux','escompte');
	   $this->view->tauxescompte = $tauxescompte;
	   
	   $pck = Util_Utils::getParametre('pck','nr');
	   $this->view->pck = $pck;

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['produit']) && $_POST['produit']!="" && 
		isset($_POST['designation']) && $_POST['designation']!="" && 
		isset($_POST['prix_unitaire']) && $_POST['prix_unitaire']!="" && 
		isset($_POST['quantite']) && $_POST['quantite']!="" && 
		isset($_POST['total_bps']) && $_POST['total_bps']!="" && 
		isset($_POST['total_nr']) && $_POST['total_nr']!="") {


		$date_id = new Zend_Date(Zend_Date::ISO_8601);
		$date_id2 = new Zend_Date(Zend_Date::ISO_8601);
		$date_id2->addDay(30);
	         
		$a = new Application_Model_EuCommandeNr();
		$ma = new Application_Model_EuCommandeNrMapper();

		$compteur = $ma->findConuter() + 1;
		$a->setId_commande_nr($compteur);
		$a->setProduit($_POST['produit']);
		$a->setDesignation($_POST['designation']);
		$a->setPrix_unitaire($_POST['prix_unitaire']);
		$a->setQuantite($_POST['quantite']);
		$a->setTotal_bps($_POST['total_bps']);
		$a->setTotal_nr($_POST['total_nr']);
		$a->setActif(0);
		$a->setPrk($_POST['prk']);
		$a->setCode_membre($sessionmembre->code_membre);
		$a->setDate_commande_nr($date_id->toString('yyyy-MM-dd'));
		$a->setDate_livraison_estimer($date_id2->toString('yyyy-MM-dd'));
		$ma->save($a);

		$this->_redirect('/recurrentjournalier/listcommandenr');
		
		}else {  $this->view->error = "Les champs * sont obligatoires ...";  }
		}

	}





	public function listcommandenrAction()
	{
		/* page recurrentjournalier/listcommandenr - Liste de commande nr */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$commandenr = new Application_Model_EuCommandeNrMapper();
		$this->view->entries = $commandenr->fetchAllByCodeMembre($sessionmembre->code_membre);
		
		$this->view->tabletri = 1;

	}















}
