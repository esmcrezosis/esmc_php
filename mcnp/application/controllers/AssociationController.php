<?php

class AssociationController extends Zend_Controller_Action {

    public function init()
    {
        /* Initialize action controller here */	
        
    }

    public function loginAction()
    {
	$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
				include("Transfert.php");
				
        $date_id = new Zend_Date(Zend_Date::ISO_8601);

                           $this->_redirect('/integrateur/login');


include("automatisation.php"); 
//releve_relevedetail();
//transfert_code();
//codegenerer(93);
  //validation_automatique(93);
  //dotransfertAction(100);
  //transfertNumeroSouscription();


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!=""){

	$eumembreasso = new Application_Model_DbTable_EuMembreasso();
	$select = $eumembreasso->select()->where('membreasso_login = ?', $_POST['login'])
						  	  ->where('membreasso_passe = ?', $_POST['pwd'])
							  ->where('publier = ?', 1);
	if ($rowseumembreasso = $eumembreasso->fetchRow($select)){
	
if($_SERVER['SERVER_NAME'] == "prod.gacsource.net"){
//if($_SERVER['SERVER_NAME'] == "10.10.20.7"){
	if($rowseumembreasso->membreasso_association == "1" || $rowseumembreasso->local == 1) {

				 $sessionmembreasso->membreasso_id = $rowseumembreasso->membreasso_id;
				 $sessionmembreasso->membreasso_nom = $rowseumembreasso->membreasso_nom;
				 $sessionmembreasso->membreasso_prenom = $rowseumembreasso->membreasso_prenom;
				 $sessionmembreasso->membreasso_mobile = $rowseumembreasso->membreasso_mobile;
				 $sessionmembreasso->membreasso_association = $rowseumembreasso->membreasso_association;
				 $sessionmembreasso->membreasso_email = $rowseumembreasso->membreasso_email;
				 $sessionmembreasso->login = $rowseumembreasso->membreasso_login;
				 $sessionmembreasso->membreasso_passe = $rowseumembreasso->membreasso_passe;
				 $sessionmembreasso->membreasso_type = $rowseumembreasso->membreasso_type;
				 $sessionmembreasso->membreasso_date = $rowseumembreasso->membreasso_date;
				 $sessionmembreasso->publier = $rowseumembreasso->publier;
				 $sessionmembreasso->souscription_id = $rowseumembreasso->souscription_id;

				 $sessionmembreasso->errorlogin = "";
    $this->_redirect('/integrateur');
		
		}else{
			$sessionmembreasso->errorlogin = "Erreur de connexion N° 147 : Veuillez contacter le Service Technique ..."; 
    $this->_redirect('/integrateur/login');
			}
	
	}else{

				 $sessionmembreasso->membreasso_id = $rowseumembreasso->membreasso_id;
				 $sessionmembreasso->membreasso_nom = $rowseumembreasso->membreasso_nom;
				 $sessionmembreasso->membreasso_prenom = $rowseumembreasso->membreasso_prenom;
				 $sessionmembreasso->membreasso_mobile = $rowseumembreasso->membreasso_mobile;
				 $sessionmembreasso->membreasso_association = $rowseumembreasso->membreasso_association;
				 $sessionmembreasso->membreasso_email = $rowseumembreasso->membreasso_email;
				 $sessionmembreasso->login = $rowseumembreasso->membreasso_login;
				 $sessionmembreasso->membreasso_passe = $rowseumembreasso->membreasso_passe;
				 $sessionmembreasso->membreasso_type = $rowseumembreasso->membreasso_type;
				 $sessionmembreasso->membreasso_date = $rowseumembreasso->membreasso_date;
				 $sessionmembreasso->publier = $rowseumembreasso->publier;

				 $sessionmembreasso->errorlogin = "";
    $this->_redirect('/integrateur');
		}
	} else { $sessionmembreasso->errorlogin = "Login ou Mot de Passe Erroné"; }
    $this->_redirect('/integrateur/login');
	} else { $sessionmembreasso->errorlogin = "Saisir Login et Mot de Passe"; } 
    $this->_redirect('/integrateur/login');
	}

    }

    public function passwordAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['ancien']) && $_POST['ancien'] != "" && isset($_POST['nouveau']) && $_POST['nouveau'] != "" && isset($_POST['confirmer']) && $_POST['confirmer'] == $_POST['nouveau']) {

                    $eumembreasso = new Application_Model_DbTable_EuMembreasso();
                    $select = $eumembreasso->select()->where('membreasso_login = ?', $sessionmembreasso->login);
                    $select->where('membreasso_passe = ?', $_POST['ancien']);
                    if ($rowseumembreasso = $eumembreasso->fetchRow($select)) {
                        $mapper = new Application_Model_EuMembreassoMapper();
                        $membreasso = new Application_Model_EuMembreasso();
                        $mapper->find($sessionmembreasso->membreasso_id, $membreasso);
                        $membreasso->setMembreasso_passe($_POST['nouveau']);
                        $mapper->update($membreasso);
                        $this->view->error = "Modification effectuée";
                    }
            } else {
                $this->view->error = "Saisir tous les champs";
            }
            //$this->_redirect('/integrateur/membreasso');
        }
    }

    function nocompteAction()
    {
	Zend_Session::destroy(true);
    $this->_redirect('/integrateur/login');
    }




    public function indexAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}


    }



    public function addmembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}
		

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['membreasso_mobile']) && $_POST['membreasso_mobile']!="" && isset($_POST['membreasso_nom']) && $_POST['membreasso_nom']!="" && isset($_POST['membreasso_prenom']) && $_POST['membreasso_prenom']!="" && isset($_POST['membreasso_login']) && $_POST['membreasso_login']!="" && isset($_POST['membreasso_passe']) && $_POST['membreasso_passe']==$_POST['membreasso_passe2']) {
		
		
	$eumembreasso = new Application_Model_DbTable_EuMembreasso();
	$select = $eumembreasso->select()->where('membreasso_login = ?', $_POST['membreasso_login']);
	if ($rowseumembreasso = $eumembreasso->fetchRow($select)){
$this->view->error = "Login déjà existant ...";
	}else{
			
			
        $date_id = Zend_Date::now();

        $membreasso = new Application_Model_EuMembreasso();
        $membreasso_mapper = new Application_Model_EuMembreassoMapper();
			
            $compteur_membreasso = $membreasso_mapper->findConuter() + 1;
            $membreasso->setMembreasso_id($compteur_membreasso);
            $membreasso->setMembreasso_mobile($_POST['membreasso_mobile']);
            $membreasso->setMembreasso_nom($_POST['membreasso_nom']);
            $membreasso->setMembreasso_prenom($_POST['membreasso_prenom']);
            $membreasso->setMembreasso_association($sessionmembreasso->membreasso_association);
            $membreasso->setMembreasso_email($_POST['membreasso_email']);
            $membreasso->setMembreasso_login($_POST['membreasso_login']);
            $membreasso->setMembreasso_passe($_POST['membreasso_passe']);
            $membreasso->setMembreasso_type($_POST['membreasso_type']);
            $membreasso->setMembreasso_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $membreasso->setLocal(0);
            $membreasso->setPublier(0);
            $membreasso_mapper->save($membreasso);
			

		$this->_redirect('/integrateur/listmembreasso');
	}
		} else {  $this->view->error = "Champs * obligatoire ..."; }
	}
	 
	}



    public function editmembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['membreasso_mobile']) && $_POST['membreasso_mobile']!="" && isset($_POST['membreasso_nom']) && $_POST['membreasso_nom']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find($_POST['membreasso_id'], $membreasso);
			
            $membreasso->setMembreasso_mobile($_POST['membreasso_mobile']);
            $membreasso->setMembreasso_nom($_POST['membreasso_nom']);
            $membreasso->setMembreasso_prenom($_POST['membreasso_prenom']);
            $membreasso->setMembreasso_email($_POST['membreasso_email']);
            //$membreasso->setMembreasso_login($_POST['membreasso_login']);
            $membreasso->setCode_membre($_POST['code_membre']);
            $m_membreasso->update($membreasso);
			
		$this->_redirect('/integrateur/listmembreasso');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMembreasso();
        $ma = new Application_Model_EuMembreassoMapper();
		$ma->find($id, $a);
		$this->view->membreasso = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMembreasso();
        $ma = new Application_Model_EuMembreassoMapper();
		$ma->find($id, $a);
		$this->view->membreasso = $a;
            }
	}
	}



    public function listmembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $membreasso = new Application_Model_EuMembreassoMapper();
        $this->view->entries = $membreasso->fetchAllByMembreasso($sessionmembreasso->membreasso_association);

        $this->view->tabletri = 1;

    }

    public function publiermembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($id, $membreasso);
		
        $membreasso->setPublier($this->_request->getParam('publier'));
		$membreassoM->update($membreasso);
        }

		$this->_redirect('/integrateur/listmembreasso');
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



    public function addintegrateurAction() {
        /* page association/addintegrateur - Ajout d'une integrateur */

		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	    if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

		$t_canton = new Application_Model_DbTable_EuCanton();
        $m_ville = new Application_Model_EuVilleMapper ();
        $cantons = $t_canton->fetchAll();
        $villes = $m_ville->fetchAll();
        $this->view->cantons = $cantons;
        $this->view->villes = $villes;
	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['integrateur_souscription_ordre']) && $_POST['integrateur_souscription_ordre']!="" && isset($_POST['integrateur_type']) && $_POST['integrateur_type']!="" && isset($_POST['code_activite']) && $_POST['code_activite']!="" && isset($_POST['souscription_email']) && $_POST['souscription_email']!="" && isset($_POST['integrateur_attestation']) && $_POST['integrateur_attestation']==1) {

		            $param = (int)$this->_request->getParam('param');
	 //$this->view->param = $param;

        $m_souscription2 = new Application_Model_EuSouscriptionMapper();
		$souscription_id = $m_souscription2->findIdSouscription($_POST['integrateur_souscription_ordre']);
		
		if($souscription_id == NULL) {
		   $sessionmembreasso->error = "Numéro de quittance invalide ...";
		} else {
			
        $souscription3 = new Application_Model_EuSouscription();
        $m_souscription3 = new Application_Model_EuSouscriptionMapper();
		$m_souscription3->find($souscription_id, $souscription3);
		
		if(count($souscription3) > 0 && $souscription3->souscription_nombre >= 10){
		
        $m_integrateur2 = new Application_Model_EuIntegrateurMapper();
		$integrateur2 = $m_integrateur2->fetchAllBySouscription($souscription_id);
		
		if(count($integrateur2) > 0){
		   $sessionmembreasso->error = "Numéro de quittance déjà utilisé ...";
			}else{

            $souscription = new Application_Model_EuSouscription();
            $m_souscription = new Application_Model_EuSouscriptionMapper();
		    $m_souscription->find($souscription_id, $souscription);
			
            $souscription->setCode_activite($_POST["code_activite"]);
            $souscription->setId_metier($_POST["id_metier"]);
            $souscription->setSouscription_email($_POST["souscription_email"]);
            $m_souscription->update($souscription);
			
		
			
		
		include("Transfert.php");
		if(isset($_FILES['integrateur_diplome']['name']) && $_FILES['integrateur_diplome']['name']!=""){
		$chemin	= "integrateurs";
		$file = $_FILES['integrateur_diplome']['name'];
		$file1='integrateur_diplome';
		$integrateur_diplome = $chemin."/".transfert($chemin,$file1);
		} else {$integrateur_diplome = "";}
			

		if(isset($_FILES['integrateur_document']['name']) && $_FILES['integrateur_document']['name']!=""){
		$chemin	= "integrateurs";
		$file = $_FILES['integrateur_document']['name'];
		$file1='integrateur_document';
		$integrateur_document = $chemin."/".transfert($chemin,$file1);
		} else {$integrateur_document = "";}
			

            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $a = new Application_Model_EuIntegrateur();
            $ma = new Application_Model_EuIntegrateurMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setIntegrateur_id($compteur);
            $a->setIntegrateur_type($_POST['integrateur_type']);
            $a->setIntegrateur_souscription($souscription_id);
if($param == 1 || $param == 2 || $param == 3|| $param == 4 || $param == 5 || $param == 6|| $param == 7 || $param == 8){
            $a->setIntegrateur_critere1($_POST['integrateur_critere1']);
            $a->setIntegrateur_critere2($_POST['integrateur_critere2']);
            $a->setIntegrateur_critere3($_POST['integrateur_critere3']);
}
if($param == 15 || $param == 16 || $param == 17|| $param == 18 || $param == 19 || $param == 20){
if($param == 15 || $param == 16 || $param == 17|| $param == 18){
            $a->setIntegrateur_poste($_POST['integrateur_poste']);
}
            $a->setIntegrateur_education($_POST['integrateur_education']);
if($param == 15 || $param == 16 || $param == 17|| $param == 18){
            $a->setIntegrateur_affiliation($_POST['integrateur_affiliation']);
}
            $a->setIntegrateur_formation($_POST['integrateur_formation']);
            $a->setIntegrateur_langue($_POST['integrateur_langue']);
            $a->setIntegrateur_experience($_POST['integrateur_experience']);
            $a->setIntegrateur_document($integrateur_document);
            $a->setIntegrateur_diplome($integrateur_diplome);
}
            $a->setIntegrateur_attestation($_POST['integrateur_attestation']);
            $a->setIntegrateur_membreasso($sessionmembreasso->membreasso_id);/**/
            $a->setIntegrateur_date($date_id->toString('yyyy-MM-dd'));
			$a->setPublier($_POST['publier']);
            $a->setIntegrateurAdresse($_POST['integrateur_adresse']);
            $a->setIntegrateurCanton($_POST['integrateur_canton']);
            $a->setIntegrateurVille($_POST['integrateur_ville']);
            $ma->save($a);
			

//////////////////////////////////////////////////////////
		
        $integrateur = new Application_Model_EuIntegrateur();
        $integrateurM = new Application_Model_EuIntegrateurMapper();
        $integrateurM->find($compteur, $integrateur);
		
        $integrateur->setPublier(1);
		$integrateurM->update($integrateur);
		
		
		
$id_integrateur = $integrateur->integrateur_id;
//////////////////////////////////////////
/*if($integrateur->integrateur_membreasso != 1 && $integrateur->integrateur_membreasso != 0){
        $membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find($integrateur->integrateur_membreasso, $membreasso);
			
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find($membreasso->membreasso_association, $association);
		$code_agence = $association->code_agence;
		
        $recubancaire = new Application_Model_EuRecubancaire();
        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
        $cumul_recubancaire = $recubancaire_mapper->findCumul($integrateur->integrateur_souscription);
        //$cumul_recubancaire = 0;
		
		if($cumul_recubancaire > 0){
		
		if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}else{
			
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association($membreasso->membreasso_association);
            $partagea->setPartagea_integrateur($integrateur->integrateur_id);
            $partagea->setPartagea_montant($partagea_montant * 0.75);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////

        $partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso($membreasso->membreasso_id);
            $partagem->setPartagem_integrateur($integrateur->integrateur_id);
            $partagem->setPartagem_montant($partagea_montant * 0.25);
            $partagem_mapper->save($partagem);
			
//////////////////////////////////////////

}
		
			}*/
				
			
        $membreasso_sous_m = new Application_Model_EuMembreassoMapper();
        $membreasso_sous = $membreasso_sous_m->fetchAllBySouscription($integrateur->integrateur_souscription);
			
			
			
///////////////////////////////////////////////////////////////			
//if($integrateur->integrateur_type <= 8 && count($membreasso_sous) > 0){
	
        $souscription = new Application_Model_EuSouscription();
        $m_souscription = new Application_Model_EuSouscriptionMapper();
		$m_souscription->find($integrateur->integrateur_souscription, $souscription);

        $date_id = Zend_Date::now();

        $association = new Application_Model_EuAssociation();
        $association_mapper = new Application_Model_EuAssociationMapper();
			
            $compteur_association = $association_mapper->findConuter() + 1;
            $association->setAssociation_id($compteur_association);
            $association->setAssociation_mobile($souscription->souscription_mobile);
            $association->setAssociation_nom($souscription->souscription_nom." ".$souscription->souscription_prenom);
            $association->setAssociation_numero($compteur_association."INT");
            $association->setAssociation_date_agrement($date_id->toString('yyyy-MM-dd'));
            $association->setAssociation_email($souscription->souscription_email);
            $association->setAssociation_recepisse(NULL);
            $association->setAssociation_adresse($souscription->souscription_quartier." - ".$souscription->souscription_ville);
            $association->setAssociation_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $association->setId_filiere(NULL);
            $association->setCode_type_acteur(NULL);
            $association->setCode_statut(NULL);
            $association->setCode_agence($code_agence);
            $association->setPublier(1);
            $association_mapper->save($association);
			



			
        $date_id = Zend_Date::now();

        $membreasso = new Application_Model_EuMembreasso();
        $membreasso_mapper = new Application_Model_EuMembreassoMapper();
			
            $compteur_membreasso = $membreasso_mapper->findConuter() + 1;
            $membreasso->setMembreasso_id($compteur_membreasso);
            $membreasso->setMembreasso_mobile($souscription->souscription_mobile);
            $membreasso->setMembreasso_nom($souscription->souscription_nom);
            $membreasso->setMembreasso_prenom($souscription->souscription_prenom);
            $membreasso->setMembreasso_association($compteur_association);
            $membreasso->setMembreasso_email($souscription->souscription_email);
            $membreasso->setMembreasso_login($souscription->souscription_login);
            $membreasso->setMembreasso_passe($souscription->souscription_passe);
            $membreasso->setMembreasso_type(1);
            $membreasso->setMembreasso_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $membreasso->setPublier(1);
            $membreasso_mapper->save($membreasso);
			

$html = "Vous avez remplit le formulaire d'intégrateur, donc utilisez les mêmes Login et Mot de passe pour vous connecter à votre espace Agrément OSE/OE Personnel .";
$html .= "<br />";
$html .= "Connectez vous aussi : <a href='http://prod.esmcgacsource.com/integrateur/login'>Connexion Agrément OSE/OE</a>";
$html .= "<br />";
$html .= "Login : ".$souscription->souscription_login;
$html .= "<br />";
$html .= "Mot de passe : ".$souscription->souscription_passe;
$html .= "<br />";


$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC");
$mail->addTo($souscription->souscription_email, $souscription->souscription_nom." ".$souscription->souscription_prenom);
$mail->setSubject('Formulaire Intégrateur : '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->send($tr);

	//}


			

//////////////////////////////////////////////////////////

            $sessionmembreasso->error = "Opération bien effectuée ...";
			
			

		$this->_redirect('/integrateur/addintegrateur/param/'.$_POST['integrateur_type']);
								}
			
			}else{
		   $sessionmembreasso->error = "Numéro de quittance doit être celui d'un CMFH Offreur de projet ...";
				}
		}

		} else {  $sessionmembreasso->error = "Champs * obligatoire ...";  } 
		}
		
		
            $param = (int)$this->_request->getParam('param');
	 $this->view->param = $param;
		
		
    }

	
	
	
	public function listintegrateurAction()
    {
        /* page association/listlivraison - Liste des livraisons */

		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $integrateur = new Application_Model_EuIntegrateurMapper();
        $this->view->entries = $integrateur->fetchAllByMembreasso($sessionmembreasso->membreasso_id);

    }




    public function listintegrateur1Action()
    {
        /* page association/listlivraison - Liste des livraisons */

		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $integrateur = new Application_Model_EuIntegrateurMapper();
        $this->view->entries = $integrateur->fetchAllByAssociation($sessionmembreasso->membreasso_association);

    }


	
	


    public function suppmembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($id, $membreasso);
		
        $membreassoM->delete($membreasso->membreasso_id);

        }

		$this->_redirect('/integrateur/listmembreasso');
    }



    public function detailsmembreassoAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($id, $membreasso);
		$this->view->membreasso = $membreasso;

            }

	}



    public function addsouscriptionAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

		$param = (int)$this->_request->getParam('param');
	    $this->view->param = $param;

		$request = $this->getRequest ();
		if ($request->isPost ()) {
		
		    if (isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="" 
			    && isset($_POST['souscription_autonome']) && $_POST['souscription_autonome']!="" 
				&& isset($_POST['souscription_mobile']) && $_POST['souscription_mobile']!="" 
				&& isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="" 
				&& isset($_POST['code_activite']) && $_POST['code_activite']!="" 
				&& isset($_POST['souscription_type']) && $_POST['souscription_type']!="" 
				&& isset($_POST['souscription_numero']) && $_POST['souscription_numero']!="" 
				&& isset($_POST['souscription_date_numero']) && $_POST['souscription_date_numero']!="" 
				&& isset($_POST['souscription_nombre']) && $_POST['souscription_nombre']!="" 
				&& isset($_POST['souscription_montant']) && $_POST['souscription_montant']!=""
				&& isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!="" && verif_img($_FILES['souscription_vignette']['name']) == 1 
				) {
		
		            $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
					try {
					    $eusouscription = new Application_Model_DbTable_EuSouscription();
	                    $select = $eusouscription->select();
			            if($_POST['souscription_personne'] == "PP") {
	                        $select->where("LOWER(REPLACE(souscription_nom, ' ', '')) = ? ", strtolower(str_replace(" ", "",$request->getParam("souscription_nom"))));
	                        $select->where("LOWER(REPLACE(souscription_prenom, ' ', '')) = ? ", strtolower(str_replace(" ", "",$request->getParam("souscription_prenom"))));
			            } else {
	                        $select->where("LOWER(REPLACE(souscription_raison, ' ', '')) = ? ", strtolower(str_replace(" ", "",$request->getParam("souscription_raison"))));
			            }
	                    $select->order(array("souscription_id ASC"));
	                    $select->limit(1);
	                    $rowseusouscription = $eusouscription->fetchRow($select);
		                if(count($rowseusouscription) > 0) {
			              $souscription_ok = 1;
			              $souscription_first = $rowseusouscription->souscription_id;
			            } else {
			              $souscription_ok = 0;
			            }
						
						$eusouscription = new Application_Model_DbTable_EuSouscription();
	                    $select = $eusouscription->select()->where('souscription_login = ?',$request->getParam("souscription_login"));
	                    if ($rowseusouscription = $eusouscription->fetchRow($select) && $request->getParam("souscription_login") != "" && $souscription_ok == 0) {
                            $this->view->error = "Login déjà existant ...";
	                    }  else if($request->getParam("souscription_passe") != $request->getParam("confirme")) {
                            $this->view->error = "Mot de passe incorret ...";
	                    } else {
						    $date_id = Zend_Date::now();

                            $souscription = new Application_Model_EuSouscription();
                            $souscription_mapper = new Application_Model_EuSouscriptionMapper();
		
		                    include("Transfert.php");
		                    if(isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!="") {
		                        $chemin	= "souscriptions";
		                        $file = $_FILES['souscription_vignette']['name'];
		                        $file1='souscription_vignette';
		                        $souscription_vignette = $chemin."/".transfert($chemin,$file1);
		                    } else {$souscription_vignette = "";}
							
							$compteur_souscription = $souscription_mapper->findConuter() + 1;
                            $souscription->setSouscription_id($compteur_souscription);
                            $souscription->setSouscription_personne($request->getParam("souscription_personne"));
			                if($_POST['souscription_personne'] == "PP") {
                                $souscription->setSouscription_nom($request->getParam("souscription_nom"));
                                $souscription->setSouscription_prenom($request->getParam("souscription_prenom"));
			                } else {
                                $souscription->setSouscription_raison($request->getParam("souscription_raison"));
                                $souscription->setCode_type_acteur($request->getParam("type_acteur"));
                                $souscription->setCode_statut($request->getParam("statut_juridique"));
			                }
                            $souscription->setSouscription_email($request->getParam("souscription_email"));
                            $souscription->setSouscription_mobile($request->getParam("souscription_mobile"));
                            $souscription->setSouscription_membreasso($sessionmembreasso->membreasso_id);
                            $souscription->setSouscription_type($request->getParam("souscription_type"));
                            $souscription->setSouscription_numero($request->getParam("souscription_numero"));
                            $souscription->setSouscription_date_numero($request->getParam("souscription_date_numero"));
			                if($_POST['souscription_type'] == "Banque") {
                                $souscription->setSouscription_banque($request->getParam("souscription_banque"));
			                }
                            $souscription->setSouscription_montant($request->getParam("souscription_montant"));
                            $souscription->setSouscription_nombre($request->getParam("souscription_nombre"));
                            $souscription->setSouscription_programme($request->getParam("souscription_programme"));
                            $souscription->setSouscription_type_candidat($request->getParam("souscription_type_candidat"));
                            //$souscription->setSouscription_filiere($_POST['souscription_filiere']);
                            $souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $souscription->setSouscription_vignette($souscription_vignette);
                            $souscription->setCode_activite($request->getParam("code_activite"));
                            $souscription->setId_metier($request->getParam("id_metier"));
                            $souscription->setId_competence($request->getParam("id_competence"));
                            $souscription->setSouscription_ville($request->getParam("souscription_ville"));
                            $souscription->setSouscription_quartier($request->getParam("souscription_quartier"));
			                if($_POST['souscription_programme'] == "CMFH") {
                                $souscription->setSouscription_login($request->getParam("souscription_login"));
                                $souscription->setSouscription_passe($request->getParam("souscription_passe"));
			                }
			                if($souscription_ok == 1) {
                                $souscription->setSouscription_souscription($souscription_first);
				            } else {
                                $souscription->setSouscription_souscription($compteur_souscription);
					        }
            
                            $souscription->setSouscription_autonome($request->getParam("souscription_autonome"));
			                $souscription->setPublier(0);
							$souscription->setErreur(0);
							$souscription->setId_canton($request->getParam("id_canton"));
                            $souscription_mapper->save($souscription);
							
							
							///////////////////////////////////////////////////////////////////////////////////////
							
							$recubancaire = new Application_Model_EuRecubancaire();
                            $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
		
                            $compteur_recubancaire = $recubancaire_mapper->findConuter() + 1;
                            $recubancaire->setRecubancaire_id($compteur_recubancaire);
                            $recubancaire->setRecubancaire_type($request->getParam("souscription_type"));
                            $recubancaire->setRecubancaire_numero($request->getParam("souscription_numero"));
                            $recubancaire->setRecubancaire_date_numero($request->getParam("souscription_date_numero"));
			                if($_POST['souscription_type'] == "Banque") {
                                $recubancaire->setRecubancaire_banque($request->getParam("souscription_banque"));
			                }
                            $recubancaire->setRecubancaire_montant($request->getParam("souscription_montant"));
                            $recubancaire->setRecubancaire_vignette($souscription_vignette);
                            $recubancaire->setRecubancaire_souscription($compteur_souscription);
			                $recubancaire->setPublier(1);
                            $recubancaire_mapper->save($recubancaire);
							
							/////////////////////////////////////////////////////////////////////////////////////////////
							$association = new Application_Model_EuAssociation();
                            $m_association = new Application_Model_EuAssociationMapper();
		                    $m_association->find($sessionmembreasso->membreasso_association, $association);
		                    $code_agence = $association->code_agence;
							
							/*if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			                    if($_POST['souscription_programme'] == "KACM"){
			                        $partagea_montant = floor(($_POST['souscription_montant'] / 100 * 10) / 2);
				                } else {
			                        $partagea_montant = floor(($_POST['souscription_montant'] / 100 * 5) / 2);
					            }
			
		                    } else {
			                    if($_POST['souscription_programme'] == "KACM"){
			                       $partagea_montant = floor($_POST['souscription_montant'] / 100 * 10);
				                } else {
			                       $partagea_montant = floor($_POST['souscription_montant'] / 100 * 5);
					            }
		                    }*/
							
							//////////////////////////////////////////////////////////////////////////////////////////////
							    /*$partagea = new Application_Model_EuPartagea();
                                $partagea_mapper = new Application_Model_EuPartageaMapper();

                                $compteur_partagea = $partagea_mapper->findConuter() + 1;
                                $partagea->setPartagea_id($compteur_partagea);
                                $partagea->setPartagea_association(1);
                                $partagea->setPartagea_souscription($compteur_souscription);
                                $partagea->setPartagea_montant($partagea_montant * 0.75);
                                $partagea_mapper->save($partagea);*/
								
							////////////////////////////////////////////////////////////////////////////////////////////////
                                /*$partagem = new Application_Model_EuPartagem();
                                $partagem_mapper = new Application_Model_EuPartagemMapper();

                                $compteur_partagem = $partagem_mapper->findConuter() + 1;
                                $partagem->setPartagem_id($compteur_partagem);
                                $partagem->setPartagem_membreasso(1);
                                $partagem->setPartagem_souscription($compteur_souscription);
                                $partagem->setPartagem_montant($partagea_montant * 0.25);
                                $partagem_mapper->save($partagem);*/
								
                            //////////////////////////////////////////
                                /*$membreasso = new Application_Model_EuMembreasso();

                                $m_membreasso = new Application_Model_EuMembreassoMapper();
		                        $m_membreasso->find(1, $membreasso);*/

                                $html = "";
                                if($_POST['souscription_personne'] == "PP") {
                                    $html .= "Nom : ".$request->getParam("souscription_nom")."<br />";
                                    $html .= "Prenom : ".$request->getParam("souscription_prenom")."<br />";
			                    } else {
                                    $html .= "Raison sociale : ".$request->getParam("souscription_raison")."<br />";
                                    if($_POST["type_acteur"] == 'EI'){$html .= "Type Association : Entreprise Industrie<br />";}
                                    if($_POST["type_acteur"] == 'OE'){$html .= "Type Association : Opérateur Economique<br />";}
                                    if($_POST["type_acteur"] == 'OSE'){$html .= "Type Association : Opérateur Socio-Economique<br />";}
                                    if($_POST["type_acteur"] == 'PEI'){$html .= "Type Association : Partenaire Entreprise Industrie<br />";}
                                    if($_POST["type_acteur"] == 'POE'){$html .= "Type Association : Partenaire Opérateur Economique<br />";}
                                    if($_POST["type_acteur"] == 'POSE'){$html .= "Type Association : Partenaire Opérateur Socio-Economique<br />";}

                                    $statutjuridique = new Application_Model_EuStatutJuridique();
                                    $statutjuridiqueM = new Application_Model_EuStatutJuridiqueMapper();
                                    $statutjuridiqueM->find($request->getParam("statut_juridique"), $statutjuridique);
                                    $html .= "Statut juridique : ".$statutjuridique->libelle_statut."<br />";
			                    }
								
                                $html .= "E-mail : ".$request->getParam("souscription_email")."<br />";
                                $html .= "Mobile : ".$request->getParam("souscription_mobile")."<br />";
                                $html .= "Ville : ".$request->getParam("souscription_ville")."<br/>";
                                $html .= "Quartier : ".$request->getParam("souscription_quartier")."<br />";
                                $html .= "Programme : ".$request->getParam("souscription_programme")."<br />";	
                               
								if(isset($_POST['souscription_type_candidat']) && $_POST['souscription_type_candidat']!="") {
                                    $type_candidatM = new Application_Model_DbTable_EuTypeCandidat();
                                    $type_candidat = $type_candidatM->find($request->getParam("souscription_type_candidat"));
									$row = $type_candidat->current();
                                    $html .= "Type candidat : ".$row->libelle_type_candidat."<br />";	
								}

                                /*
                                $filiere = new Application_Model_EuFiliere();
                                $filiereM = new Application_Model_EuFiliereMapper();
                                $filiereM->find($_POST['souscription_filiere'], $filiere);
                                $html .= "Filiere : ".$filiere->nom_filiere."<br />";*/	
                                
								if(isset($_POST['code_activite']) && $_POST['code_activite']!="") {
                                $activiteM = new Application_Model_DbTable_EuActivite();
                                $activite = $activiteM->find($request->getParam("code_activite"));
								$row = $activite->current();
                                $html .= "Biens, Produits et Services : ".$row->nom_activite."<br />";
								}
								if(isset($_POST['id_metier']) && $_POST['id_metier']!="") {
								$metierM = new Application_Model_DbTable_EuMetier();
                                $metier = $metierM->find($request->getParam("id_metier"));
								$row = $metier->current();
                                $html .= "Métier : ".$row->libelle_metier."<br />";
                                }
								if(isset($_POST['id_competence']) && $_POST['id_competence']!="") {
                                $competenceM = new Application_Model_DbTable_EuCompetence();
                                $competence = $competenceM->find($request->getParam("id_competence"));
								$row = $competence->current();
                                $html .= "Compétence : ".$row->libelle_competence."<br />";
								}
								
								$html .= "Type : ".$request->getParam("souscription_type")."<br/>";

			                    if($_POST['souscription_type'] == "Banque") {
                                    $banque = new Application_Model_EuBanque();
                                    $banqueM = new Application_Model_EuBanqueMapper();
                                    $banqueM->find($request->getParam("souscription_banque"), $banque);
                                    $html .= "Banque : ".$banque->libelle_banque."<br/>";
			                    }
								
								$html .= "Numero Reçu Banque ou Numéro Transaction Flooz: ".$request->getParam("souscription_numero")."<br/>";
                                $html .= "Date Reçu Banque ou Transaction Flooz: ".$request->getParam("souscription_date_numero")."<br/>";
                                $html .= "Montant : ".$request->getParam("souscription_montant")."<br/>";
                                $html .= "Nombre : ".$request->getParam("souscription_nombre")."<br/>";

                                $html .= "Date : ".$date_id->toString('yyyy-MM-dd HH:mm:ss')."<br />";
                                $html .= "Vignette : <a href='http://prod.esmcgacsource.com/".$souscription_vignette."'>".$souscription_vignette."</a>";

                                $html .= "Agrément OSE/OE: ".$association->association_nom."<br />";
			
                                //$esmc_email	 = "achatcmmcnp@esmcgacsource.com";	
                                $esmc_email	 = Util_Utils::getParamEsmc(3);	
					
                                $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
                                Zend_Mail::setDefaultTransport($tr);		
                                $mail = new Zend_Mail();
                                //$mail->setBodyText('Mon texte de test');
                                $mail->setBodyHtml($html);
                                $mail->setFrom(Util_Utils::getParamEsmc(3), $association->association_nom);
                                $mail->addTo($esmc_email, "ESMC - SIF");
                                $mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm:ss'));

                                $mail->send();
								
								if(isset($_POST['souscription_mobilisateur']) && $_POST['souscription_mobilisateur'] == 1) {
								
								    $date_id = Zend_Date::now();
                                    $association = new Application_Model_EuAssociation();
                                    $association_mapper = new Application_Model_EuAssociationMapper();
			
                                    $compteur_association = $association_mapper->findConuter() + 1;
                                    $association->setAssociation_id($compteur_association);
                                    $association->setAssociation_mobile($request->getParam("souscription_mobile"));
                                    $association->setAssociation_nom($request->getParam("souscription_nom")." ".$request->getParam("souscription_prenom"));
                                    $association->setAssociation_numero($compteur_association."PP");
                                    $association->setAssociation_date_agrement($date_id->toString('yyyy-MM-dd'));
                                    $association->setAssociation_email($request->getParam("souscription_email"));
                                    $association->setAssociation_recepisse(NULL);
                                    $association->setAssociation_adresse($request->getParam("souscription_quartier")." - ".$request->getParam("souscription_ville"));
                                    $association->setAssociation_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                    $association->setId_filiere(NULL);
                                    $association->setCode_type_acteur(NULL);
                                    $association->setCode_statut(NULL);
                                    $association->setCode_agence($code_agence);
                                    $association->setPublier(1);
                                    $association_mapper->save($association);
			
                                    $date_id = Zend_Date::now();

                                    $membreasso = new Application_Model_EuMembreasso();
                                    $membreasso_mapper = new Application_Model_EuMembreassoMapper();
			
                                    $compteur_membreasso = $membreasso_mapper->findConuter() + 1;
                                    $membreasso->setMembreasso_id($compteur_membreasso);
                                    $membreasso->setMembreasso_mobile($request->getParam("souscription_mobile"));
                                    $membreasso->setMembreasso_nom($request->getParam("souscription_nom"));
                                    $membreasso->setMembreasso_prenom($request->getParam("souscription_prenom"));
                                    $membreasso->setMembreasso_association($compteur_association);
                                    $membreasso->setMembreasso_email($request->getParam("souscription_email"));
                                    $membreasso->setMembreasso_login($request->getParam("souscription_login"));
                                    $membreasso->setMembreasso_passe($request->getParam("souscription_passe"));
                                    $membreasso->setMembreasso_type(1);
                                    $membreasso->setMembreasso_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                    $membreasso->setPublier(1);
                                    $membreasso_mapper->save($membreasso);
							
							    }
								
								if($_POST['souscription_programme'] == "CMFH") {
                                    $html .= "<br />";
                                    $html .= "Voici votre Login et Mot de passe qui vous permettent de vous connecter et compléter les informations vous concernant pour être bien classifié dans votre domaine et ainsi être en bonne position pour l’ouverture prochaine du marché MCNP.";
                                    $html .= "<br />";
                                    $html .= "Connectez vous ici : <a href='http://prod.esmcgacsource.com/souscription/login'>Connexion Souscription</a>";
                                    $html .= "<br />";
                                    $html .= "Login : ".$request->getParam("souscription_login")."<br />";
                                    $html .= "<br />";
                                    $html .= "Mot de passe : ".$request->getParam("souscription_passe")."<br />";
                                    $html .= "<br />";

                                    if(isset($_POST['souscription_mobilisateur']) && $_POST['souscription_mobilisateur'] == 1) {
                                        $html .= "Vous avez sélectionner l'option Mobilisateur donc utilisez les mêmes Login et Mot de passe pour vous connecter à votre espace Agrément OSE/OE pour pouvoir souscrire d'autres personnes.";
                                        $html .= "<br />";
                                        $html .= "Connectez vous aussi : <a href='http://prod.esmcgacsource.com/integrateur/login'>Connexion Agrément OSE/OE</a>";
                                        $html .= "<br />";
                                    }


                                    $config = array('auth' => 'login','username' => Util_Utils::getParamEsmc(3),'password' => Util_Utils::getParamEsmc(4));
 
                                    $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
                                    Zend_Mail::setDefaultTransport($tr);		
                                    $mail = new Zend_Mail();
                                    //$mail->setBodyText('Mon texte de test');
                                    $mail->setBodyHtml($html);
                                    $mail->setFrom(Util_Utils::getParamEsmc(3), $association->association_nom);
                                    $mail->addTo($request->getParam("souscription_email"), $request->getParam("souscription_nom")." ".$request->getParam("souscription_prenom"));
                                    $mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
                                    $mail->send($tr);

			                    }
								
								$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
		                        $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($request->getParam("souscription_banque"),$request->getParam("souscription_numero"),$request->getParam("souscription_date_numero"));
                                if(count($relevebancairedetail) > 0) {
								    if($relevebancairedetail->relevebancairedetail_montant >= $_POST['souscription_montant']) {
								        include("automatisation.php");
								        validation_automatique($compteur_souscription);
								        // operation de transfert
										$souscription = new Application_Model_EuSouscription();
		                                $souscriptionM = new Application_Model_EuSouscriptionMapper();
                                        $souscriptionM->find($compteur_souscription, $souscription);
										$date = new Zend_Date();
		                                $compte_map = new Application_Model_EuCompteMapper();
                                        $compte      = new Application_Model_EuCompte();
			                            $sms_money   = new Application_Model_EuSmsmoney();
                                        $money_map   = new Application_Model_EuSmsmoneyMapper();
			
			                            $det_sms   = new Application_Model_EuDetailSmsmoney();
			                            $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
			
			                            $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			                            $det_vtesms  = new Application_Model_EuDetailVentesms();
			
			                            $mobile = $souscription->souscription_mobile;
			                            //$nbre_compte = $souscription->souscription_nombre;
			                            $fcaps = Util_Utils::getParametre('CAPS','valeur');
										
										$mont_fs = Util_Utils::getParametre('FS','valeur');
                                        $mont_fl = Util_Utils::getParametre('FL','valeur');
                                        $mont_kps = Util_Utils::getParametre('FKPS','valeur');
			
		                                //$montant = $nbre_compte * $fcaps;
		                                $membre_pbf = '0000000000000000001M';
	                                    $code_compte_pbf = "NN-TR-".$membre_pbf;
			                            $ret = $compte_map->find($code_compte_pbf,$compte);
										
										
										
										if(($souscription->souscription_programme == 'KACM') 
			                                || ($souscription->souscription_programme == 'CMFH') 
				                            && $souscription->souscription_autonome == 1) {
											        
													if($ret && ($compte->getSolde() >= ($mont_fs + $mont_fl + $mont_kps))) {
			                                            // Mise à jour du compte de transfert
				                                        $compte->setSolde($compte->getSolde() - ($mont_fs + $mont_fl + $mont_kps));
                                                        $compte_map->update($compte);    
	                                                } else {
			                                            $db->rollback();				
			                                            $sessionmembreasso->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';                                    $this->view->param = $param;
														$this->_redirect('/integrateur/addsouscription/param/'.$param);
														$this->view->param = $param;
														
                                                        return;			   
			                                        }
													
													$codefs   = '';
                                                    $codefl   = '';
                                                    $codefkps = '';
													
													// Traitement des produits FS
				                                    // insertion dans la table eu_smsmoney
				                                    $lignesdetfs = $det_sms_m->findSMSByCompte($membre_pbf,'FS');
												    // Traitement des produits FL
                                                    // insertion dans la table eu_smsmoney
				                                    $lignesdetfl = $det_sms_m->findSMSByCompte($membre_pbf,'FL');
												    // Traitement des produits FCPS
				                                    $lignesdetfkps = $det_sms_m->findSMSByCompte($membre_pbf,'FCPS');
													
													if ($lignesdetfs != null && $lignesdetfl !=  null && $lignesdetfkps != null) {
													
											            $codefs   = strtoupper(Util_Utils::genererCodeSMS(8));
					                                    $nengfs = $money_map->findConuter() + 1;
														$sms_money->setNEng($nengfs)
                	                                              ->setCode_Agence(null)
                                                                  ->setCreditAmount($mont_fs)
                                                                  ->setSentTo($mobile)
                                                                  ->setMotif('FS')
                                                                  ->setId_Utilisateur(null)
                                                                  ->setCurrencyCode('XOF')
                                                                  ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                  ->setFromAccount($code_compte_pbf)
                                                                  ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                                  ->setCreditCode($codefs)
                                                                 ->setDestAccount(null)
                                                                 ->setIDDatetimeConsumed(0)
                                                                 ->setDestAccount_Consumed(null)
                                                                 ->setDatetimeConsumed(null)
                                                                ->setNum_recu(null);
                                                        $money_map->save($sms_money);
														
														$i = 0;
					                                    $reste = $mont_fs;
					                                    $nbre_lignesdetfs = count($lignesdetfs);
														while ($reste > 0 && $i < $nbre_lignesdetfs) {
					                                        $lignedetfs = $lignesdetfs[$i];
                                                            $id = $lignedetfs->getId_detail_smsmoney();
						                                    $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                    if ($reste >= $lignedetfs->getSolde_sms()) {
						                                        //Mise à jour  des lignes d'enrégistrement
															    //insertion dans la table eu_detailventesms
						                                        $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                                $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                                   ->setId_detail_smsmoney($id)
                                                                           ->setCode_membre_dist($membre_pbf)
                                                                           ->setCode_membre(null)
                                                                           ->setType_tansfert('FS')
                                                                           ->setCreditcode($codefs)
                                                                           ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                           ->setMont_vente($lignedetfs->getSolde_sms())
                                                                           ->setId_utilisateur(null)
                                                                           ->setCode_produit('FS');
                                                                $det_vte_sms->insert($det_vtesms->toArray());
                                                                $reste = $reste - $lignedetfs->getSolde_sms();
							                                    $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $lignedetfs->getSolde_sms())
		                                                                   ->setMont_regle($lignedetfs->getMont_regle() + $lignedetfs->getSolde_sms())
		                                                                   ->setSolde_sms(0);
                                                                $det_sms_m->update($lignedetfs);			 							   
						                                    } else  {
							                                    //Mise à jour  des lignes d'enrégistrement
															    //insertion dans la table eu_detailventesms
						                                        $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                                $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                                   ->setId_detail_smsmoney($id)
                                                                           ->setCode_membre_dist($membre_pbf)
                                                                           ->setCode_membre(null)
                                                                           ->setType_tansfert('FS')
                                                                           ->setCreditcode($codefs)
                                                                           ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                           ->setMont_vente($reste)
                                                                           ->setId_utilisateur(null)
                                                                           ->setCode_produit('FS');
                                                                $det_vte_sms->insert($det_vtesms->toArray());
                                                                $lignedetfs->setSolde_sms($lignedetfs->getSolde_sms() - $reste);
						                                        $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $reste);
							                                    $lignedetfs->setMont_regle($lignedetfs->getMont_regle() + $reste);
                                                                $det_sms_m->update($lignedetfs);
						                                        $reste = 0;
						                                    }
						                                    $i++;
					                                    }
														
														$codefl   = strtoupper(Util_Utils::genererCodeSMS(8));
				                                        $nengfl = $money_map->findConuter() + 1;
                                                        $sms_money->setNEng($nengfl)
                	                                              ->setCode_Agence(null)
                                                                  ->setCreditAmount($mont_fl)
                                                                  ->setSentTo($mobile)
                                                                  ->setMotif('FL')
                                                                  ->setId_Utilisateur(null)
                                                                  ->setCurrencyCode('XOF')
                                                                  ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                  ->setFromAccount($code_compte_pbf)
                                                                  ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                                  ->setCreditCode($codefl)
                                                                  ->setDestAccount(null)
                                                                  ->setIDDatetimeConsumed(0)
                                                                  ->setDestAccount_Consumed(null)
                                                                  ->setDatetimeConsumed(null)
                                                                  ->setNum_recu(null);
                                                        $money_map->save($sms_money);
					                                    
													$j = 0;
					                                $reste = $mont_fl;
					                                $nbre_lignesdetfl = count($lignesdetfl);
					                                while ($reste > 0 && $j < $nbre_lignesdetfl) {
					                                    $lignedetfl = $lignesdetfl[$j];
                                                        $id = $lignedetfl->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfl->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
                                                            $reste = $reste - $lignedetfl->getSolde_sms();
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                               ->setId_detail_smsmoney($id)
                                                                       ->setCode_membre_dist($membre_pbf)
                                                                       ->setCode_membre(null)
                                                                       ->setType_tansfert('FL')
                                                                       ->setCreditcode($codefl)
                                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                       ->setMont_vente($lignedetfl->getSolde_sms())
                                                                       ->setId_utilisateur(null)
                                                                       ->setCode_produit('FL');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
							                                $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $lignedetfl->getSolde_sms())
		                                                               ->setMont_regle($lignedetfl->getMont_regle() + $lignedetfl->getSolde_sms())
		                                                               ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfl);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FL')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FL');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfl->setSolde_sms($lignedetfl->getSolde_sms() - $reste);
						                                    $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $reste);
							                                $lignedetfl->setMont_regle($lignedetfl->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfl);
						                                    $reste = 0;
						                                }
						                                $j++;
					                                }
													
													$codefkps = strtoupper(Util_Utils::genererCodeSMS(8));
				                                    $nengfkps = $money_map->findConuter() + 1;
                                                    $sms_money->setNEng($nengfkps)
                	                                          ->setCode_Agence(null)
                                                              ->setCreditAmount($mont_kps)
                                                              ->setSentTo($mobile)
                                                              ->setMotif('FCPS')
                                                              ->setId_Utilisateur(null)
                                                              ->setCurrencyCode('XOF')
                                                              ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                              ->setFromAccount($code_compte_pbf)
                                                              ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                              ->setCreditCode($codefkps)
                                                              ->setDestAccount(null)
                                                              ->setIDDatetimeConsumed(0)
                                                              ->setDestAccount_Consumed(null)
                                                              ->setDatetimeConsumed(null)
                                                              ->setNum_recu(null);
                                                    $money_map->save($sms_money);
													
													$k = 0;
					                                $reste = $mont_kps;
					                                $nbre_lignesdetfkps = count($lignesdetfkps);
					                                while ($reste > 0 && $k < $nbre_lignesdetfkps) {
					                                    $lignedetfkps = $lignesdetfkps[$k];
                                                        $id = $lignedetfkps->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfkps->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($lignedetfkps->getSolde_sms())
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $reste = $reste - $lignedetfkps->getSolde_sms();
							                                $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $lignedetfkps->getSolde_sms())
		                                                                 ->setMont_regle($lignedetfkps->getMont_regle() + $lignedetfkps->getSolde_sms())
		                                                                 ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfkps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfkps->setSolde_sms($lignedetfkps->getSolde_sms() - $reste);
						                                    $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $reste);
							                                $lignedetfkps->setMont_regle($lignedetfkps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfkps);
						                                    $reste = 0;
						                                }
						                                $k++;
					                                }
													
													// insertion dans la table eu_code_activation
				                                    $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				                                    $codeactivation = new Application_Model_EuCodeActivation();
			                                        $countcode = $m_codeactivation->findConuter() + 1;
				
				                                    $codeactivation->setId_code_activation($countcode)
					                                              ->setDate_generer($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                                    $codeactivation->setCode_membre(null);   
			                                        $codeactivation->setCode_fs($codefs);
				                                    $codeactivation->setCode_fl($codefl);
				                                    $codeactivation->setCode_fkps($codefkps);
				                                    $codeactivation->setSouscription_id($compteur_souscription);
				                                    $m_codeactivation->save($codeactivation);
				
				                                    $compteur = Util_Utils::findConuter() + 1;
				                                    Util_Utils::addSms($compteur,$mobile,'Voici vos codes d\'activation de compte marchand : '.' CODE FS : '.$codefs.' CODE FL : '.$codefl.' CODE FCPS : '.$codefkps);
												
										            }  else {
												        $db->rollback();
	                                                    $this->view->param = $param;
			                                            $sessionmembreasso->error = 'Erreur de traitement : le solde du compte est null';
														$this->_redirect('/integrateur/addsouscription/param/'.$param);
                                                        return;	
												    }
										
										}
										
										if($souscription->souscription_programme == 'CMFH')   {
			                                $codefcaps   = strtoupper(Util_Utils::genererCodeSMS(8));
			                                if($souscription->souscription_autonome == 1) {   
			                                    $nbre_compte = $souscription->souscription_nombre - 1; 
			                                } else {
				                                $nbre_compte = $souscription->souscription_nombre;
				                            }
				                            $montant = $nbre_compte * $fcaps;
				
				                            // Traitement des produits CAPS
				                            $lignesdetfcaps = $det_sms_m->findSMSByCompte($membre_pbf,'CAPS');
				                            if ($lignesdetfcaps != null) {
				                                $nengfcaps = $money_map->findConuter() + 1;
                                                $sms_money->setNEng($nengfcaps)
                	                                      ->setCode_Agence(null)
                                                          ->setCreditAmount($montant)
                                                          ->setSentTo($mobile)
                                                          ->setMotif('CAPS')
                                                          ->setId_Utilisateur(null)
                                                          ->setCurrencyCode('XOF')
                                                          ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                          ->setFromAccount($code_compte_pbf)
                                                          ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                          ->setCreditCode($codefcaps)
                                                          ->setDestAccount(null)
                                                          ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/MM/yyyy')))
                                                          ->setDestAccount_Consumed('CAPS-'.$compteur_souscription)
                                                          ->setDatetimeConsumed($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                          ->setNum_recu(null);
                                                $money_map->save($sms_money);
					
					                            // Mise à jour du compte de transfert
				                                if($ret) {
			                                        // Mise à jour du compte de transfert
				                                    $compte->setSolde($compte->getSolde() - $montant);
                                                    $compte_map->update($compte);    
	                                            } else {
			                                        $db->rollback();
	                                                $this->view->param = $param;
			                                        $sessionmembreasso->error = 'Erreur de traitement : le compte est introuvable';
													$this->_redirect('/integrateur/addsouscription/param/'.$param);
                                                    return;			   
			                                    }
					
				                                $l = 0;
					                            $reste = $montant;
					                            $nbre_lignesdetfcaps = count($lignesdetfcaps);
					                            while ($reste > 0 && $l < $nbre_lignesdetfcaps) {
					                                $lignedetfcaps = $lignesdetfcaps[$l];
                                                    $id = $lignedetfcaps->getId_detail_smsmoney();
						                            $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                            if ($reste >= $lignedetfcaps->getSolde_sms()) {
						                                //Mise à jour  des lignes d'enrégistrement
                                                        $reste = $reste - $lignedetfcaps->getSolde_sms();
													    //insertion dans la table eu_detailventesms
						                                $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                        $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                               ->setId_detail_smsmoney($id)
                                                                       ->setCode_membre_dist($membre_pbf)
                                                                       ->setCode_membre(null)
                                                                       ->setType_tansfert('CAPS')
                                                                       ->setCreditcode($codefcaps)
                                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                       ->setMont_vente($lignedetfcaps->getSolde_sms())
                                                                       ->setId_utilisateur(null)
                                                                       ->setCode_produit('CAPS');
                                                        $det_vte_sms->insert($det_vtesms->toArray());
															
							                            $lignedetfcaps->setMont_vendu($lignedetfcaps->getMont_vendu() + $lignedetfcaps->getSolde_sms())
		                                                              ->setMont_regle($lignedetfcaps->getMont_regle() + $lignedetfcaps->getSolde_sms())
		                                                              ->setSolde_sms(0);
                                                        $det_sms_m->update($lignedetfcaps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                         ->setId_detail_smsmoney($id)
                                                                 ->setCode_membre_dist($membre_pbf)
                                                                 ->setCode_membre(null)
                                                                 ->setType_tansfert('CAPS')
                                                                 ->setCreditcode($codefcaps)
                                                                 ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                 ->setMont_vente($reste)
                                                                 ->setId_utilisateur(null)
                                                                 ->setCode_produit('CAPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
															
                                                            $lignedetfcaps->setSolde_sms($lignedetfcaps->getSolde_sms() - $reste);
						                                    $lignedetfcaps->setMont_vendu($lignedetfcaps->getMont_vendu() + $reste);
							                                $lignedetfcaps->setMont_regle($lignedetfcaps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfcaps);
						                                    $reste = 0;
						                                }
						                        $l++;
					                        }
					
				                } else  {
				                    $db->rollback();
	                                $this->view->param = $param;
			                        $sessionmembreasso->error = 'Erreur de traitement : le solde du compte CAPS est null';
									$this->_redirect('/integrateur/addsouscription/param/'.$param);
                                    return;
				                }
				
				                // insertion dans la table eu_depot_vente
				                $m_dvente = new Application_Model_EuDepotVenteMapper();
				                $dvente = new Application_Model_EuDepotVente();
			                    $countdvente = $m_dvente->findConuter() + 1;
				                $dvente->setId_depot($countdvente)
					                   ->setDate_depot($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                $dvente->setCode_membre(null);   
			                    $dvente->setCode_produit('CAPS');
				                $dvente->setMont_depot($montant);
				                $dvente->setMont_vendu(0);
				                $dvente->setSolde_depot($montant);
				                $dvente->setId_utilisateur(null);
				                $dvente->setType_depot('AvecListe');
				                $dvente->setSouscription_id($compteur_souscription);
				                $m_dvente->save($dvente);
				
				                $compteur = Util_Utils::findConuter() + 1;
				                Util_Utils::addSms($compteur,$mobile,$nbre_compte.'  codes  ont ete ajoute a votre souscription');
								
								codegenerer($compteur_souscription);
			                }
								$db->commit();
								$this->view->param = $param;
                                $sessionmembreasso->error = "Opération bien effectuée. Votre souscription a été vérifiée.";
		                        $this->_redirect('/integrateur/addsouscription/param/'.$param);/**/
								
		                    } else {
							    $db->commit();
                                $sessionmembreasso->error = "Opération bien effectuée, mais le montant est insuffisant. Veuillez compléter le montant par un autre dépôt à la banque.";
		                        $this->_redirect('/integrateur/addsouscriptioncomplement');/**/
					                }
		                    }  else {
								$db->commit();
                                $sessionmembreasso->error = "Opération bien effectuée. Votre souscription n’est pas encore vérifiée, revenez plus tard.";
		                        $this->_redirect('/integrateur/recherchesouscription');/**/
			                }
		
		
		                }
		
		            }  catch (Exception $exc) {
	                    $this->view->param = $param;
                        $sessionmembreasso->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();  
		                $this->_redirect('/integrateur/addsouscription/param/'.$param);/**/
                        //return;
                    }
		
		
		
		
		
		    }   else {  $sessionmembreasso->error = "Champs * obligatoire ..."; }
		
		
		}	
		
	}

	 public function recherchesouscriptionAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $request = $this->getRequest ();
		if ($request->isPost ()) {
            if(isset($_POST['souscription_numero']) && $_POST['souscription_numero']!="") {
			     $db = Zend_Db_Table::getDefaultAdapter();
                 $db->beginTransaction();
			     try {
			         $souscription_mapper = new Application_Model_EuSouscriptionMapper();
			         $recubancaire = new Application_Model_EuRecubancaire();
			         $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
			         $result = $souscription_mapper->fectchByNumeroBanque($_POST['souscription_numero']);
			         $resultat = $recubancaire_mapper->fetchByNumero($_POST['souscription_numero']);
					 
			         if(($result != NULL) && ($resultat != FALSE)) {
			               $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
		                   $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($resultat->recubancaire_banque,
				           $resultat->recubancaire_numero,$resultat->recubancaire_date_numero);
				           if(count($relevebancairedetail) > 0) {
                                  if(($relevebancairedetail->relevebancairedetail_montant) >= ($result->souscription_montant)) { 
                                       include("automatisation.php");
								       validation_automatique($result->souscription_id);
								       // operation de transfert
								       $souscription = new Application_Model_EuSouscription();
		                               $souscriptionM = new Application_Model_EuSouscriptionMapper();
                                       $souscriptionM->find($result->souscription_id, $souscription);
								       $date = new Zend_Date();
		                               $compte_map = new Application_Model_EuCompteMapper();
                                       $compte      = new Application_Model_EuCompte();
			                           $sms_money   = new Application_Model_EuSmsmoney();
                                       $money_map   = new Application_Model_EuSmsmoneyMapper();
			
			                           $det_sms   = new Application_Model_EuDetailSmsmoney();
			                           $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
			
			                           $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			                           $det_vtesms  = new Application_Model_EuDetailVentesms();
			
			                           $mobile = $souscription->souscription_mobile;
			                           //$nbre_compte = $souscription->souscription_nombre;
			                           $fcaps = Util_Utils::getParametre('CAPS','valeur');
										
								       $mont_fs = Util_Utils::getParametre('FS','valeur');
                                       $mont_fl = Util_Utils::getParametre('FL','valeur');
                                       $mont_kps = Util_Utils::getParametre('FKPS','valeur');
								  
								       $membre_pbf = '0000000000000000001M';
	                                   $code_compte_pbf = "NN-TR-".$membre_pbf;
			                           $ret = $compte_map->find($code_compte_pbf,$compte);
									   
									   if(($souscription->souscription_programme == 'KACM') || ($souscription->souscription_programme == 'CMFH') && $souscription->souscription_autonome == 1) {
											        
											   if($ret && ($compte->getSolde() >= ($mont_fs + $mont_fl + $mont_kps))) {
			                                      // Mise à jour du compte de transfert
				                                  $compte->setSolde($compte->getSolde() - ($mont_fs + $mont_fl + $mont_kps));
                                                  $compte_map->update($compte);    
	                                           } else {
			                                      $db->rollback();				
			                                      $sessionmembreasso->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
                                                  return;			   
			                                   }
													
											   $codefs   = '';
                                               $codefl   = '';
                                               $codefkps = '';
													
													// Traitement des produits FS
				                                    // insertion dans la table eu_smsmoney
				                                    $lignesdetfs = $det_sms_m->findSMSByCompte($membre_pbf,'FS');
												    // Traitement des produits FL
                                                    // insertion dans la table eu_smsmoney
				                                    $lignesdetfl = $det_sms_m->findSMSByCompte($membre_pbf,'FL');
												    // Traitement des produits FCPS
				                                    $lignesdetfkps = $det_sms_m->findSMSByCompte($membre_pbf,'FCPS');
													
													if ($lignesdetfs != null && $lignesdetfl !=  null && $lignesdetfkps != null) {
													
											            $codefs   = strtoupper(Util_Utils::genererCodeSMS(8));
					                                    $nengfs = $money_map->findConuter() + 1;
														$sms_money->setNEng($nengfs)
                	                                              ->setCode_Agence(null)
                                                                  ->setCreditAmount($mont_fs)
                                                                  ->setSentTo($mobile)
                                                                  ->setMotif('FS')
                                                                  ->setId_Utilisateur(null)
                                                                  ->setCurrencyCode('XOF')
                                                                  ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                  ->setFromAccount($code_compte_pbf)
                                                                  ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                                  ->setCreditCode($codefs)
                                                                 ->setDestAccount(null)
                                                                 ->setIDDatetimeConsumed(0)
                                                                 ->setDestAccount_Consumed(null)
                                                                 ->setDatetimeConsumed(null)
                                                                ->setNum_recu(null);
                                                        $money_map->save($sms_money);
														
														$i = 0;
					                                    $reste = $mont_fs;
					                                    $nbre_lignesdetfs = count($lignesdetfs);
														while ($reste > 0 && $i < $nbre_lignesdetfs) {
					                                        $lignedetfs = $lignesdetfs[$i];
                                                            $id = $lignedetfs->getId_detail_smsmoney();
						                                    $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                    if ($reste >= $lignedetfs->getSolde_sms()) {
						                                        //Mise à jour  des lignes d'enrégistrement
															    //insertion dans la table eu_detailventesms
						                                        $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                                $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                                   ->setId_detail_smsmoney($id)
                                                                           ->setCode_membre_dist($membre_pbf)
                                                                           ->setCode_membre(null)
                                                                           ->setType_tansfert('FS')
                                                                           ->setCreditcode($codefs)
                                                                           ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                           ->setMont_vente($lignedetfs->getSolde_sms())
                                                                           ->setId_utilisateur(null)
                                                                           ->setCode_produit('FS');
                                                                $det_vte_sms->insert($det_vtesms->toArray());
                                                                $reste = $reste - $lignedetfs->getSolde_sms();
							                                    $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $lignedetfs->getSolde_sms())
		                                                                   ->setMont_regle($lignedetfs->getMont_regle() + $lignedetfs->getSolde_sms())
		                                                                   ->setSolde_sms(0);
                                                                $det_sms_m->update($lignedetfs);			 							   
						                                    } else  {
							                                    //Mise à jour  des lignes d'enrégistrement
															    //insertion dans la table eu_detailventesms
						                                        $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                                $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                                   ->setId_detail_smsmoney($id)
                                                                           ->setCode_membre_dist($membre_pbf)
                                                                           ->setCode_membre(null)
                                                                           ->setType_tansfert('FS')
                                                                           ->setCreditcode($codefs)
                                                                           ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                           ->setMont_vente($reste)
                                                                           ->setId_utilisateur(null)
                                                                           ->setCode_produit('FS');
                                                                $det_vte_sms->insert($det_vtesms->toArray());
                                                                $lignedetfs->setSolde_sms($lignedetfs->getSolde_sms() - $reste);
						                                        $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $reste);
							                                    $lignedetfs->setMont_regle($lignedetfs->getMont_regle() + $reste);
                                                                $det_sms_m->update($lignedetfs);
						                                        $reste = 0;
						                                    }
						                                    $i++;
					                                    }
														
														$codefl   = strtoupper(Util_Utils::genererCodeSMS(8));
				                                        $nengfl = $money_map->findConuter() + 1;
                                                        $sms_money->setNEng($nengfl)
                	                                              ->setCode_Agence(null)
                                                                  ->setCreditAmount($mont_fl)
                                                                  ->setSentTo($mobile)
                                                                  ->setMotif('FL')
                                                                  ->setId_Utilisateur(null)
                                                                  ->setCurrencyCode('XOF')
                                                                  ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                  ->setFromAccount($code_compte_pbf)
                                                                  ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                                  ->setCreditCode($codefl)
                                                                  ->setDestAccount(null)
                                                                  ->setIDDatetimeConsumed(0)
                                                                  ->setDestAccount_Consumed(null)
                                                                  ->setDatetimeConsumed(null)
                                                                  ->setNum_recu(null);
                                                        $money_map->save($sms_money);
					                                    
													$j = 0;
					                                $reste = $mont_fl;
					                                $nbre_lignesdetfl = count($lignesdetfl);
					                                while ($reste > 0 && $j < $nbre_lignesdetfl) {
					                                    $lignedetfl = $lignesdetfl[$j];
                                                        $id = $lignedetfl->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfl->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
                                                            $reste = $reste - $lignedetfl->getSolde_sms();
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                               ->setId_detail_smsmoney($id)
                                                                       ->setCode_membre_dist($membre_pbf)
                                                                       ->setCode_membre(null)
                                                                       ->setType_tansfert('FL')
                                                                       ->setCreditcode($codefl)
                                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                       ->setMont_vente($lignedetfl->getSolde_sms())
                                                                       ->setId_utilisateur(null)
                                                                       ->setCode_produit('FL');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
							                                $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $lignedetfl->getSolde_sms())
		                                                               ->setMont_regle($lignedetfl->getMont_regle() + $lignedetfl->getSolde_sms())
		                                                               ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfl);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FL')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FL');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfl->setSolde_sms($lignedetfl->getSolde_sms() - $reste);
						                                    $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $reste);
							                                $lignedetfl->setMont_regle($lignedetfl->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfl);
						                                    $reste = 0;
						                                }
						                                $j++;
					                                }
													
													$codefkps = strtoupper(Util_Utils::genererCodeSMS(8));
				                                    $nengfkps = $money_map->findConuter() + 1;
                                                    $sms_money->setNEng($nengfkps)
                	                                          ->setCode_Agence(null)
                                                              ->setCreditAmount($mont_kps)
                                                              ->setSentTo($mobile)
                                                              ->setMotif('FCPS')
                                                              ->setId_Utilisateur(null)
                                                              ->setCurrencyCode('XOF')
                                                              ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                              ->setFromAccount($code_compte_pbf)
                                                              ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                              ->setCreditCode($codefkps)
                                                              ->setDestAccount(null)
                                                              ->setIDDatetimeConsumed(0)
                                                              ->setDestAccount_Consumed(null)
                                                              ->setDatetimeConsumed(null)
                                                              ->setNum_recu(null);
                                                    $money_map->save($sms_money);
													
													$k = 0;
					                                $reste = $mont_kps;
					                                $nbre_lignesdetfkps = count($lignesdetfkps);
					                                while ($reste > 0 && $k < $nbre_lignesdetfkps) {
					                                    $lignedetfkps = $lignesdetfkps[$k];
                                                        $id = $lignedetfkps->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfkps->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($lignedetfkps->getSolde_sms())
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $reste = $reste - $lignedetfkps->getSolde_sms();
							                                $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $lignedetfkps->getSolde_sms())
		                                                                 ->setMont_regle($lignedetfkps->getMont_regle() + $lignedetfkps->getSolde_sms())
		                                                                 ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfkps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfkps->setSolde_sms($lignedetfkps->getSolde_sms() - $reste);
						                                    $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $reste);
							                                $lignedetfkps->setMont_regle($lignedetfkps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfkps);
						                                    $reste = 0;
						                                }
						                                $k++;
					                                }
													
													// insertion dans la table eu_code_activation
				                                    $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				                                    $codeactivation = new Application_Model_EuCodeActivation();
			                                        $countcode = $m_codeactivation->findConuter() + 1;
				
				                                    $codeactivation->setId_code_activation($countcode)
					                                               ->setDate_generer($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                                    $codeactivation->setCode_membre(null);   
			                                        $codeactivation->setCode_fs($codefs);
				                                    $codeactivation->setCode_fl($codefl);
				                                    $codeactivation->setCode_fkps($codefkps);
				                                    $codeactivation->setSouscription_id($souscription->souscription_id);
				                                    $m_codeactivation->save($codeactivation);
				
				                                    $compteur = Util_Utils::findConuter() + 1;
				                                    Util_Utils::addSms($compteur,$mobile,'Voici vos codes d\'activation de compte marchand : '.' CODE FS : '.$codefs.' CODE FL : '.$codefl.' CODE FCPS : '.$codefkps);
												
										            }  else {
												        $db->rollback();
			                                            $sessionmembreasso->error = 'Erreur de traitement : le solde du compte est null';
                                                        return;	
												    }
										}
										if($souscription->souscription_programme == 'CMFH')   {
			                                $codefcaps   = strtoupper(Util_Utils::genererCodeSMS(8));
			                                if($souscription->souscription_autonome == 1) {   
			                                    $nbre_compte = $souscription->souscription_nombre - 1; 
			                                } else {
				                                $nbre_compte = $souscription->souscription_nombre;
				                            }
				                            $montant = $nbre_compte * $fcaps;
				
				                            // Traitement des produits CAPS
				                            $lignesdetfcaps = $det_sms_m->findSMSByCompte($membre_pbf,'CAPS');
				                            if ($lignesdetfcaps != null) {
				                                $nengfcaps = $money_map->findConuter() + 1;
                                                $sms_money->setNEng($nengfcaps)
                	                                      ->setCode_Agence(null)
                                                          ->setCreditAmount($montant)
                                                          ->setSentTo($mobile)
                                                          ->setMotif('CAPS')
                                                          ->setId_Utilisateur(null)
                                                          ->setCurrencyCode('XOF')
                                                          ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                          ->setFromAccount($code_compte_pbf)
                                                          ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                          ->setCreditCode($codefcaps)
                                                          ->setDestAccount(null)
                                                          ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/MM/yyyy')))
                                                          ->setDestAccount_Consumed('CAPS-'.$compteur_souscription)
                                                          ->setDatetimeConsumed($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                          ->setNum_recu(null);
                                                $money_map->save($sms_money);
					
					                            // Mise à jour du compte de transfert
				                                if($ret) {
			                                        // Mise à jour du compte de transfert
				                                    $compte->setSolde($compte->getSolde() - $montant);
                                                    $compte_map->update($compte);    
	                                            } else {
			                                        $db->rollback();
			                                        $sessionmembreasso->error = 'Erreur de traitement : le compte est introuvable';
                                                    return;			   
			                                    }
					
				                                $l = 0;
					                            $reste = $montant;
					                            $nbre_lignesdetfcaps = count($lignesdetfcaps);
					                            while ($reste > 0 && $l < $nbre_lignesdetfcaps) {
					                                $lignedetfcaps = $lignesdetfcaps[$l];
                                                    $id = $lignedetfcaps->getId_detail_smsmoney();
						                            $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                            if ($reste >= $lignedetfcaps->getSolde_sms()) {
						                                //Mise à jour  des lignes d'enrégistrement
                                                        $reste = $reste - $lignedetfcaps->getSolde_sms();
													    //insertion dans la table eu_detailventesms
						                                $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                        $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                               ->setId_detail_smsmoney($id)
                                                                       ->setCode_membre_dist($membre_pbf)
                                                                       ->setCode_membre(null)
                                                                       ->setType_tansfert('CAPS')
                                                                       ->setCreditcode($codefcaps)
                                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                       ->setMont_vente($lignedetfcaps->getSolde_sms())
                                                                       ->setId_utilisateur(null)
                                                                       ->setCode_produit('CAPS');
                                                        $det_vte_sms->insert($det_vtesms->toArray());
															
							                            $lignedetfcaps->setMont_vendu($lignedetfcaps->getMont_vendu() + $lignedetfcaps->getSolde_sms())
		                                                              ->setMont_regle($lignedetfcaps->getMont_regle() + $lignedetfcaps->getSolde_sms())
		                                                              ->setSolde_sms(0);
                                                        $det_sms_m->update($lignedetfcaps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                         ->setId_detail_smsmoney($id)
                                                                 ->setCode_membre_dist($membre_pbf)
                                                                 ->setCode_membre(null)
                                                                 ->setType_tansfert('CAPS')
                                                                 ->setCreditcode($codefcaps)
                                                                 ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                 ->setMont_vente($reste)
                                                                 ->setId_utilisateur(null)
                                                                 ->setCode_produit('CAPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
															
                                                            $lignedetfcaps->setSolde_sms($lignedetfcaps->getSolde_sms() - $reste);
						                                    $lignedetfcaps->setMont_vendu($lignedetfcaps->getMont_vendu() + $reste);
							                                $lignedetfcaps->setMont_regle($lignedetfcaps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfcaps);
						                                    $reste = 0;
						                                }
						                        $l++;
					                        }
					
				                } else  {
				                    $db->rollback();
			                        $sessionmembreasso->error = 'Erreur de traitement : le solde du compte CAPS est null';
                                    return;
				                }
				
				                // insertion dans la table eu_depot_vente
				                $m_dvente = new Application_Model_EuDepotVenteMapper();
				                $dvente = new Application_Model_EuDepotVente();
			                    $countdvente = $m_dvente->findConuter() + 1;
				                $dvente->setId_depot($countdvente)
					                   ->setDate_depot($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                $dvente->setCode_membre(null);   
			                    $dvente->setCode_produit('CAPS');
				                $dvente->setMont_depot($montant);
				                $dvente->setMont_vendu(0);
				                $dvente->setSolde_depot($montant);
				                $dvente->setId_utilisateur(null);
				                $dvente->setType_depot('AvecListe');
				                $dvente->setSouscription_id($souscription->souscription_id);
				                $m_dvente->save($dvente);
				
				                $compteur = Util_Utils::findConuter() + 1;
				                Util_Utils::addSms($compteur,$mobile,$nbre_compte.'  codes  ont ete ajoute a votre souscription');
								
								codegenerer($souscription->souscription_id);
			                }
							   					   
			               }  
			          }
				}  
                $this->view->entries =  $souscription_mapper->fetchAllByPublierRecherche(0, "", $_POST['souscription_numero']);
				$db->commit();
				}  
				catch (Exception $exc) {
                    $sessionmembreasso->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    $db->rollback();  
                    return;
                }
				
		        }			
        }
        $this->view->tabletri = 1;

    }
	
	
	

    public function recherchesouscriptionoldAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}


    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if(isset($_POST['souscription_numero']) && $_POST['souscription_numero']!="") {
        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllByPublierRecherche(0, "", $_POST['souscription_numero']);
  }
  }
  
        $this->view->tabletri = 1;

    }
	
	
	


    public function addsouscription1Action()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}
		

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="" && isset($_POST['souscription_autonome']) && $_POST['souscription_autonome']!="" && isset($_POST['souscription_mobile']) && $_POST['souscription_mobile']!="" && isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="" && isset($_POST['code_activite']) && $_POST['code_activite']!="" && isset($_POST['souscription_type']) && $_POST['souscription_type']!="" && isset($_POST['souscription_numero']) && $_POST['souscription_numero']!="" && isset($_POST['souscription_date_numero']) && $_POST['souscription_date_numero']!="" && isset($_POST['souscription_nombre']) && $_POST['souscription_nombre']!="" && isset($_POST['souscription_montant']) && $_POST['souscription_montant']!="") {
		

	$eusouscription = new Application_Model_DbTable_EuSouscription();
	$select = $eusouscription->select();
			if($_POST['souscription_personne'] == "PP"){
	$select->where("LOWER(REPLACE(souscription_nom, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_nom'])));
	$select->where("LOWER(REPLACE(souscription_prenom, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_prenom'])));
			}else{
	$select->where("LOWER(REPLACE(souscription_raison, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_raison'])));
			}
	$select->order(array("souscription_id ASC"));
	$select->limit(1);
	$rowseusouscription = $eusouscription->fetchRow($select);
		if(count($rowseusouscription) > 0){
			$souscription_ok = 1;
			$souscription_first = $rowseusouscription->souscription_id;
			}else{
			$souscription_ok = 0;
			}



		
	$eusouscription = new Application_Model_DbTable_EuSouscription();
	$select = $eusouscription->select()->where('souscription_login = ?', $_POST['souscription_login']);
	if ($rowseusouscription = $eusouscription->fetchRow($select) && $_POST['souscription_login'] != "" && $souscription_ok == 0){
$this->view->error = "Login déjà existant ...";
	}else if($_POST['souscription_passe'] != $_POST['confirme']){
$this->view->error = "Mot de passe non conforme ...";
	}else{
			
			
        $date_id = Zend_Date::now();

        $souscription = new Application_Model_EuSouscription();
        $souscription_mapper = new Application_Model_EuSouscriptionMapper();
		
		include("Transfert.php");
		if(isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!=""){
		$chemin	= "souscriptions";
		$file = $_FILES['souscription_vignette']['name'];
		$file1='souscription_vignette';
		$souscription_vignette = $chemin."/".transfert($chemin,$file1);
		} else {$souscription_vignette = "";}
			
            $compteur_souscription = $souscription_mapper->findConuter() + 1;
            $souscription->setSouscription_id($compteur_souscription);
            $souscription->setSouscription_personne($_POST['souscription_personne']);
			if($_POST['souscription_personne'] == "PP"){
            $souscription->setSouscription_nom($_POST['souscription_nom']);
            $souscription->setSouscription_prenom($_POST['souscription_prenom']);
			}else{
            $souscription->setSouscription_raison($_POST['souscription_raison']);
			}
            $souscription->setSouscription_email($_POST['souscription_email']);
            $souscription->setSouscription_mobile($_POST['souscription_mobile']);
            $souscription->setSouscription_membreasso($sessionmembreasso->membreasso_id);
            $souscription->setSouscription_type($_POST['souscription_type']);
            $souscription->setSouscription_numero($_POST['souscription_numero']);
            $souscription->setSouscription_date_numero($_POST['souscription_date_numero']);
			if($_POST['souscription_type'] == "Banque"){
            $souscription->setSouscription_banque($_POST['souscription_banque']);
			}
            $souscription->setSouscription_montant($_POST['souscription_montant']);
            $souscription->setSouscription_nombre($_POST['souscription_nombre']);
            $souscription->setSouscription_programme($_POST['souscription_programme']);
            $souscription->setSouscription_type_candidat($_POST['souscription_type_candidat']);
            //$souscription->setSouscription_filiere($_POST['souscription_filiere']);
            $souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $souscription->setSouscription_vignette($souscription_vignette);
            $souscription->setCode_type_acteur($_POST["type_acteur"]);
            $souscription->setCode_statut($_POST["statut_juridique"]);
            $souscription->setCode_activite($_POST["code_activite"]);
            $souscription->setId_metier($_POST["id_metier"]);
            $souscription->setId_competence($_POST["id_competence"]);
            $souscription->setSouscription_ville($_POST['souscription_ville']);
            $souscription->setSouscription_quartier($_POST['souscription_quartier']);
			if($_POST['souscription_programme'] == "CMFH"){
            $souscription->setSouscription_login($_POST['souscription_login']);
            $souscription->setSouscription_passe($_POST['souscription_passe']);
			}
			if($souscription_ok == 1){
            $souscription->setSouscription_souscription($souscription_first);
				}else{
            $souscription->setSouscription_souscription($compteur_souscription);
					}
            
            $souscription->setSouscription_autonome($_POST['souscription_autonome']);
			$souscription->setPublier(0);
			$souscription->setErreur(0);
            $souscription_mapper->save($souscription);
			
			
			
//////////////////////////////////////////
			
        $recubancaire = new Application_Model_EuRecubancaire();
        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
		
            $compteur_recubancaire = $recubancaire_mapper->findConuter() + 1;
            $recubancaire->setRecubancaire_id($compteur_recubancaire);
            $recubancaire->setRecubancaire_type($_POST['souscription_type']);
            $recubancaire->setRecubancaire_numero($_POST['souscription_numero']);
            $recubancaire->setRecubancaire_date_numero($_POST['souscription_date_numero']);
			if($_POST['souscription_type'] == "Banque"){
            $recubancaire->setRecubancaire_banque($_POST['souscription_banque']);
			}
            $recubancaire->setRecubancaire_montant($_POST['souscription_montant']);
            $recubancaire->setRecubancaire_vignette($souscription_vignette);
            $recubancaire->setRecubancaire_souscription($compteur_souscription);
			$recubancaire->setPublier(1);
            $recubancaire_mapper->save($recubancaire);
			
			
			
			
			
			
			
			
			
			
/*//////////////////////////////////////////
			
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find($sessionmembreasso->membreasso_association, $association);
		$code_agence = $association->code_agence;
		
		if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			if($_POST['souscription_programme'] == "KACM"){
			$partagea_montant = floor(($_POST['souscription_montant'] / 100 * 10) / 2);
				}else{
			$partagea_montant = floor(($_POST['souscription_montant'] / 100 * 5) / 2);
					}
			
		}else{
			
			if($_POST['souscription_programme'] == "KACM"){
			$partagea_montant = floor($_POST['souscription_montant'] / 100 * 10);
				}else{
			$partagea_montant = floor($_POST['souscription_montant'] / 100 * 5);
					}
			
		}
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association($sessionmembreasso->membreasso_association);
            $partagea->setPartagea_souscription($compteur_souscription);
            $partagea->setPartagea_montant($partagea_montant * 0.75);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////

        $partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso($sessionmembreasso->membreasso_id);
            $partagem->setPartagem_souscription($compteur_souscription);
            $partagem->setPartagem_montant($partagea_montant * 0.25);
            $partagem_mapper->save($partagem);
			
//////////////////////////////////////////*/

$html = "";

			if($_POST['souscription_personne'] == "PP"){
$html .= "Nom : ".$_POST['souscription_nom']."<br />";
$html .= "Prenom : ".$_POST['souscription_prenom']."<br />";
			}else{
$html .= "Raison sociale : ".$_POST['souscription_raison']."<br />";
if($_POST["type_acteur"] == 'EI'){$html .= "Type Association : Entreprise Industrie<br />";}
if($_POST["type_acteur"] == 'OE'){$html .= "Type Association : Opérateur Economique<br />";}
if($_POST["type_acteur"] == 'OSE'){$html .= "Type Association : Opérateur Socio-Economique<br />";}
if($_POST["type_acteur"] == 'PEI'){$html .= "Type Association : Partenaire Entreprise Industrie<br />";}
if($_POST["type_acteur"] == 'POE'){$html .= "Type Association : Partenaire Opérateur Economique<br />";}
if($_POST["type_acteur"] == 'POSE'){$html .= "Type Association : Partenaire Opérateur Socio-Economique<br />";}

        $statutjuridique = new Application_Model_EuStatutJuridique();
        $statutjuridiqueM = new Application_Model_EuStatutJuridiqueMapper();
        $statutjuridiqueM->find($_POST["statut_juridique"], $statutjuridique);
$html .= "Statut juridique : ".$statutjuridique->libelle_statut."<br />";
			}
$html .= "E-mail : ".$_POST['souscription_email']."<br />";
$html .= "Mobile : ".$_POST['souscription_mobile']."<br />";
$html .= "Ville : ".$_POST['souscription_ville']."<br />";
$html .= "Quartier : ".$_POST['souscription_quartier']."<br />";
$html .= "Programme : ".$_POST['souscription_programme']."<br />";

        $type_candidatM = new Application_Model_DbTable_EuTypeCandidat();
        $type_candidat = $type_candidatM->find($_POST['souscription_type_candidat']);
		$row = $type_candidat->current();
$html .= "Type candidat : ".$row->libelle_type_candidat."<br />";

        /*$filiere = new Application_Model_EuFiliere();
        $filiereM = new Application_Model_EuFiliereMapper();
        $filiereM->find($_POST['souscription_filiere'], $filiere);
$html .= "Filiere : ".$filiere->nom_filiere."<br />";*/

        $activiteM = new Application_Model_DbTable_EuActivite();
        $activite = $activiteM->find($_POST['code_activite']);
		$row = $activite->current();
$html .= "Biens, Produits et Services : ".$row->nom_activite."<br />";

        $metierM = new Application_Model_DbTable_EuMetier();
        $metier = $metierM->find($_POST['id_metier']);
		$row = $metier->current();
$html .= "Métier : ".$row->libelle_metier."<br />";

        $competenceM = new Application_Model_DbTable_EuCompetence();
        $competence = $competenceM->find($_POST['id_competence']);
		$row = $competence->current();
$html .= "Compétence : ".$row->libelle_competence."<br />";

$html .= "Type : ".$_POST['souscription_type']."<br />";

			if($_POST['souscription_type'] == "Banque"){
        $banque = new Application_Model_EuBanque();
        $banqueM = new Application_Model_EuBanqueMapper();
        $banqueM->find($_POST['souscription_banque'], $banque);
$html .= "Banque : ".$banque->libelle_banque."<br />";
			}

$html .= "Numero Reçu Banque ou Numéro Transaction Flooz: ".$_POST['souscription_numero']."<br />";
$html .= "Date Reçu Banque ou Transaction Flooz: ".$_POST['souscription_date_numero']."<br />";
$html .= "Montant : ".$_POST['souscription_montant']."<br />";
$html .= "Nombre : ".$_POST['souscription_nombre']."<br />";

$html .= "Date : ".$date_id->toString('yyyy-MM-dd HH:mm:ss')."<br />";
$html .= "Vignette : <a href='http://prod.esmcgacsource.com/".$souscription_vignette."'>".$souscription_vignette."</a>";


$html .= "Utilisateur : ".$sessionmembreasso->membreasso_nom." ".$sessionmembreasso->membreasso_prenom."<br />";
        $association = new Application_Model_EuAssociation();
        $associationM = new Application_Model_EuAssociationMapper();
        $associationM->find($sessionmembreasso->membreasso_association, $association);
$html .= "Agrément OSE/OE : ".$association->association_nom."<br />";








if(isset($_POST['souscription_mobilisateur']) && $_POST['souscription_mobilisateur'] == 1){


			
        $date_id = Zend_Date::now();

        $association = new Application_Model_EuAssociation();
        $association_mapper = new Application_Model_EuAssociationMapper();
			
            $compteur_association = $association_mapper->findConuter() + 1;
            $association->setAssociation_id($compteur_association);
            $association->setAssociation_mobile($_POST['souscription_mobile']);
            $association->setAssociation_nom($_POST['souscription_nom']." ".$_POST['souscription_prenom']);
            $association->setAssociation_numero($compteur_association."PP");
            $association->setAssociation_date_agrement($date_id->toString('yyyy-MM-dd'));
            $association->setAssociation_email($_POST['souscription_email']);
            $association->setAssociation_recepisse(NULL);
            $association->setAssociation_adresse($_POST['souscription_quartier']." - ".$_POST['souscription_ville']);
            $association->setAssociation_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $association->setId_filiere(NULL);
            $association->setCode_type_acteur(NULL);
            $association->setCode_statut(NULL);
            $association->setCode_agence($code_agence);
            $association->setPublier(1);
            $association_mapper->save($association);
			



			
        $date_id = Zend_Date::now();

        $membreasso = new Application_Model_EuMembreasso();
        $membreasso_mapper = new Application_Model_EuMembreassoMapper();
			
            $compteur_membreasso = $membreasso_mapper->findConuter() + 1;
            $membreasso->setMembreasso_id($compteur_membreasso);
            $membreasso->setMembreasso_mobile($_POST['souscription_mobile']);
            $membreasso->setMembreasso_nom($_POST['souscription_nom']);
            $membreasso->setMembreasso_prenom($_POST['souscription_prenom']);
            $membreasso->setMembreasso_association($compteur_association);
            $membreasso->setMembreasso_email($_POST['souscription_email']);
            $membreasso->setMembreasso_login($_POST['souscription_login']);
            $membreasso->setMembreasso_passe($_POST['souscription_passe']);
            $membreasso->setMembreasso_type(1);
            $membreasso->setMembreasso_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $membreasso->setPublier(1);
            $membreasso_mapper->save($membreasso);
			


	}









			
//$esmc_email	 = "achatcmmcnp@esmcgacsource.com";	
//$esmc_email	 = "natacha@gacsource.com";	
$esmc_email	 = Util_Utils::getParamEsmc(3);	
			
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), $association->association_nom." : ".$sessionmembreasso->membreasso_nom." ".$sessionmembreasso->membreasso_prenom);
$mail->addTo($esmc_email, "ESMC - SIF");
$mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->send();
			


if($association->association_email != ""){
$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), $sessionmembreasso->membreasso_nom." ".$sessionmembreasso->membreasso_prenom);
$mail->addTo($association->association_email, $association->association_nom);
$mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->send($tr);
}


			if($_POST['souscription_programme'] == "CMFH"){
				
$html .= "<br />";
$html .= "Voici votre Login et Mot de passe qui vous permettent de vous connecter et compléter les informations vous concernant pour être bien classifié dans votre domaine et ainsi être en bonne position pour l’ouverture prochaine du marché MCNP.";
$html .= "<br />";
$html .= "Connectez vous ici : <a href='http://prod.esmcgacsource.com/souscription/login'>Connexion Souscription</a>";
$html .= "<br />";
$html .= "Login : ".$_POST['souscription_login']."<br />";
$html .= "<br />";
$html .= "Mot de passe : ".$_POST['souscription_passe']."<br />";
$html .= "<br />";

if(isset($_POST['souscription_mobilisateur']) && $_POST['souscription_mobilisateur'] == 1){
$html .= "Vous avez sélectionner l'option Mobilisateur donc utilisez les mêmes Login et Mot de passe pour vous connecter à votre espace Agrément OSE/OE pour pouvoir souscrire d'autres personnes.";
$html .= "<br />";
$html .= "Connectez vous aussi : <a href='http://prod.esmcgacsource.com/integrateur/login'>Connexion Agrément OSE/OE</a>";
$html .= "<br />";
}


if($_POST['souscription_email'] != ""){
$config = array('auth' => 'login',
                'username' => Util_Utils::getParamEsmc(3),
                'password' => Util_Utils::getParamEsmc(4));
 
$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom(Util_Utils::getParamEsmc(3), $association->association_nom." : ".$sessionmembreasso->membreasso_nom." ".$sessionmembreasso->membreasso_prenom);
$mail->addTo($_POST['souscription_email'], $_POST['souscription_nom']." ".$_POST['souscription_prenom']);
$mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->send($tr);
}
			}


        $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
		$relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($_POST['souscription_banque'], $_POST['souscription_numero'], $_POST['souscription_date_numero']);
        if(count($relevebancairedetail) > 0){
			if($relevebancairedetail->relevebancairedetail_montant >= $_POST['souscription_montant']){
				
include("automatisation.php"); 
  validation_automatique($compteur_souscription);
  dotransfertAction($compteur_souscription);
				
				
				
$sessionmembreasso->error = "Opération bien effectuée. Votre souscription a été vérifiée.";
				}else{
$sessionmembreasso->error = "Opération bien effectuée, mais le montant est insuffisant. Veuillez compléter le montant par un autre dépôt à la banque.";
					
					}			
		}else{
$sessionmembreasso->error = "Opération bien effectuée. Votre souscription n’est pas encore vérifiée, revenez plus tard.";
			}


		$this->_redirect('/integrateur/listsouscription2');/**/
	}
		} else {  $sessionmembreasso->error = "Champs * obligatoire ..."; }
	}
	 


            $param = (int)$this->_request->getParam('param');
	 $this->view->param = $param;


	}



    public function editsouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['souscription_mobile']) && $_POST['souscription_mobile']!="" && isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="" && isset($_POST['souscription_type']) && $_POST['souscription_type']!="" && isset($_POST['souscription_numero']) && $_POST['souscription_numero']!="" && isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $souscription = new Application_Model_EuSouscription();
        $m_souscription = new Application_Model_EuSouscriptionMapper();
		$m_souscription->find($_POST['souscription_id'], $souscription);
			
		include("Transfert.php");
		if(isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!=""){
		$chemin	= "souscriptions";
		$file = $_FILES['souscription_vignette']['name'];
		$file1='souscription_vignette';
		$souscription_vignette = $chemin."/".transfert($chemin,$file1);
		} else {$souscription_vignette = $_POST['souscription_vignetteold'];}
			
            $souscription->setSouscription_personne($_POST['souscription_personne']);
			if($_POST['souscription_personne'] == "PP"){
            $souscription->setSouscription_nom($_POST['souscription_nom']);
            $souscription->setSouscription_prenom($_POST['souscription_prenom']);
			}else{
            $souscription->setSouscription_raison($_POST['souscription_raison']);
			}
            $souscription->setSouscription_email($_POST['souscription_email']);
            $souscription->setSouscription_mobile($_POST['souscription_mobile']);
            $souscription->setSouscription_membreasso($sessionmembreasso->membreasso_id);
            //$souscription->setSouscription_type($_POST['souscription_type']);
            //$souscription->setSouscription_numero($_POST['souscription_numero']);
            //$souscription->setSouscription_date_numero($_POST['souscription_date_numero']);
			//if($_POST['souscription_type'] == "Banque"){
            //$souscription->setSouscription_banque($_POST['souscription_banque']);
			//}
            //$souscription->setSouscription_montant($_POST['souscription_montant']);
            $souscription->setSouscription_nombre($_POST['souscription_nombre']);
            $souscription->setSouscription_programme($_POST['souscription_programme']);
            $souscription->setSouscription_type_candidat($_POST['souscription_type_candidat']);
            //$souscription->setSouscription_filiere($_POST['souscription_filiere']);
            $souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            //$souscription->setSouscription_vignette($souscription_vignette);
            $souscription->setCode_type_acteur($_POST["type_acteur"]);
            $souscription->setCode_statut($_POST["statut_juridique"]);
            $souscription->setCode_activite($_POST["code_activite"]);
            $souscription->setId_metier($_POST["id_metier"]);
            $souscription->setId_competence($_POST["id_competence"]);
            $souscription->setSouscription_ville($_POST['souscription_ville']);
            $souscription->setSouscription_quartier($_POST['souscription_quartier']);
            $souscription->setSouscription_login($_POST['souscription_login']);
            $souscription->setSouscription_passe($_POST['souscription_passe']);
            //$souscription->setSouscription_souscription($compteur_souscription);
            $souscription->setSouscription_autonome($_POST['souscription_autonome']);
            $m_souscription->update($souscription);
			
		$this->_redirect('/integrateur/listsouscription2');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($id, $a);
		$this->view->souscription = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($id, $a);
		$this->view->souscription = $a;
            }
	}
	}



    public function listsouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAll3();

        $this->view->tabletri = 1;

    }

    public function listsouscription2Action() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllByMembreasso($sessionmembreasso->membreasso_id);

        $this->view->tabletri = 1;

    }
	
	
	
	
	
	
	
	
    public function listsouscription3Action()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllByAssociation($sessionmembreasso->membreasso_association);

        $this->view->tabletri = 1;

    }
	
    public function publiersouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		
        $souscription->setPublier($this->_request->getParam('publier'));
		$souscriptionM->update($souscription);
        }

		$this->_redirect('/integrateur/listsouscription');
    }




    public function suppsouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		
        $souscriptionM->delete($souscription->souscription_id);

        }

		$this->_redirect('/integrateur/listsouscription');
    }



    public function detailssouscriptionAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		$this->view->souscription = $souscription;

            }

	}





    public function addsouscriptioncomplementAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}
		

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['ancien_recubancaire_type']) && $_POST['ancien_recubancaire_type']!="" && isset($_POST['ancien_recubancaire_numero']) && $_POST['ancien_recubancaire_numero']!="" && isset($_POST['ancien_recubancaire_date_numero']) && $_POST['ancien_recubancaire_date_numero']!="" && isset($_POST['recubancaire_type']) && $_POST['recubancaire_type']!="" && isset($_POST['recubancaire_numero']) && $_POST['recubancaire_numero']!="" && isset($_POST['recubancaire_date_numero']) && $_POST['recubancaire_date_numero']!="" && isset($_POST['recubancaire_montant']) && $_POST['recubancaire_montant']!=""
					&& isset($_FILES['recubancaire_vignette']['name']) && $_FILES['recubancaire_vignette']['name']!="" && verif_img($_FILES['recubancaire_vignette']['name']) == 1 
) {
		

        $recubancaireM = new Application_Model_EuRecubancaireMapper();
        $recubancaire = $recubancaireM->fetchAllByTypeNumeroDate($_POST['ancien_recubancaire_type'], $_POST['ancien_recubancaire_numero'], $_POST['ancien_recubancaire_date_numero']);
		if(count($recubancaire) > 0){
			
			
			
        $date_id = Zend_Date::now();
		
		include("Transfert.php");
		if(isset($_FILES['recubancaire_vignette']['name']) && $_FILES['recubancaire_vignette']['name']!=""){
		$chemin	= "recubancaires";
		$file = $_FILES['recubancaire_vignette']['name'];
		$file1='recubancaire_vignette';
		$recubancaire_vignette = $chemin."/".transfert($chemin,$file1);
		} else {$recubancaire_vignette = "";}
			

			
        $recubancaire = new Application_Model_EuRecubancaire();
        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
		
            $compteur_recubancaire = $recubancaire_mapper->findConuter() + 1;
            $recubancaire->setRecubancaire_id($compteur_recubancaire);
            $recubancaire->setRecubancaire_type($_POST['recubancaire_type']);
            $recubancaire->setRecubancaire_numero($_POST['recubancaire_numero']);
            $recubancaire->setRecubancaire_date_numero($_POST['recubancaire_date_numero']);
			if($_POST['recubancaire_type'] == "Banque"){
            $recubancaire->setRecubancaire_banque($_POST['recubancaire_banque']);
			}
            $recubancaire->setRecubancaire_montant($_POST['recubancaire_montant']);
            $recubancaire->setRecubancaire_vignette($recubancaire_vignette);
            $recubancaire->setRecubancaire_souscription($recubancaire->recubancaire_souscription);
			$recubancaire->setPublier(1);
            $recubancaire_mapper->save($recubancaire);
			
			
			

$sessionmembreasso->error = "Opération bien effectuée";
		$this->_redirect('/association/listsouscription2');/**/
			
			}else{

$sessionmembreasso->error = "Erreur : Veuillez rependre";
				}



		
			
			
			
			
			
			
		} else {  $sessionmembreasso->error = "Champs * obligatoire ..."; }
	}
	 
	}





    
    public function addoffreurprojetAction() {
        /* page association/addoffreurprojet - Ajout d'une offreurprojet */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
 		$t_canton = new Application_Model_DbTable_EuCanton();
        $m_ville = new Application_Model_EuVilleMapper ();
        $cantons = $t_canton->fetchAll();
        $villes = $m_ville->fetchAll();
        $this->view->cantons = $cantons;
        $this->view->villes = $villes;
		
	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['offreur_projet_souscription_ordre']) && $_POST['offreur_projet_souscription_ordre']!="" && isset($_POST['souscription_email']) && $_POST['souscription_email']!="" && isset($_POST['offreur_projet_type']) && $_POST['offreur_projet_type']!="" && isset($_POST['offreur_projet_raison_sociale']) && $_POST['offreur_projet_raison_sociale']!="" && isset($_POST['offreur_projet_produit']) && $_POST['offreur_projet_produit']!="" && isset($_POST['offreur_projet_stock_disponible']) && $_POST['offreur_projet_stock_disponible']!="" && isset($_POST['offreur_projet_nom_entrepot']) && $_POST['offreur_projet_nom_entrepot']!="" && isset($_POST['offreur_projet_adresse_entrepot']) && $_POST['offreur_projet_adresse_entrepot']!="" && isset($_POST['offreur_projet_attestation']) && $_POST['offreur_projet_attestation']==1) {

		            $param = (int)$this->_request->getParam('param');
	 //$this->view->param = $param;

        $m_souscription2 = new Application_Model_EuSouscriptionMapper();
		$souscription_id = $m_souscription2->findIdSouscriptionOffreur($_POST['offreur_projet_souscription_ordre']);
		
		if($souscription_id == NULL) {
		   $sessionmembreasso->error = "Numéro de quittance invalide ...";
		} else {
			
        $souscription3 = new Application_Model_EuSouscription();
        $m_souscription3 = new Application_Model_EuSouscriptionMapper();
		$m_souscription3->find($souscription_id, $souscription3);
		
		if(count($souscription3) > 0 && $souscription3->souscription_nombre >= 100 && ($souscription3->souscription_type_candidat == 6 || $souscription3->souscription_type_candidat == 7)){
		
        $m_offreur_projet2 = new Application_Model_EuOffreurProjetMapper();
		$offreur_projet2 = $m_offreur_projet2->fetchAllBySouscription($souscription_id);
		
		if(count($offreur_projet2) > 0){
		   $sessionmembreasso->error = "Numéro de quittance déjà utilisé ...";
			}else{



            $souscription = new Application_Model_EuSouscription();
            $m_souscription = new Application_Model_EuSouscriptionMapper();
		    $m_souscription->find($souscription_id, $souscription);
			
            $souscription->setSouscription_email($_POST["souscription_email"]);
            $m_souscription->update($souscription);



            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $a = new Application_Model_EuOffreurProjet();
            $ma = new Application_Model_EuOffreurProjetMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setOffreur_projet_id($compteur);
            $a->setOffreur_projet_type($_POST['offreur_projet_type']);
            $a->setOffreur_projet_souscription($souscription_id);
            $a->setOffreur_projet_raison_sociale($_POST['offreur_projet_raison_sociale']);
            $a->setOffreur_projet_adresse($_POST['offreur_projet_adresse']);
            $a->setOffreur_projet_produit($_POST['offreur_projet_produit']);
            $a->setOffreur_projet_operationnel($_POST['offreur_projet_operationnel']);
if($param == 4 || $param == 5){
	        $a->setOffreur_projet_capacite_production($_POST['offreur_projet_capacite_production']);
}
            $a->setOffreur_projet_stock_disponible($_POST['offreur_projet_stock_disponible']);
            $a->setOffreur_projet_qte_max($_POST['offreur_projet_qte_max']);
            $a->setOffreur_projet_qte_moyen($_POST['offreur_projet_qte_moyen']);
            $a->setOffreur_projet_qte_min($_POST['offreur_projet_qte_min']);
            $a->setOffreur_projet_nom_entrepot($_POST['offreur_projet_nom_entrepot']);
            $a->setOffreur_projet_adresse_entrepot($_POST['offreur_projet_adresse_entrepot']);
            $a->setOffreur_projet_description_projet($_POST['offreur_projet_description_projet']);
            $a->setOffreur_projet_membreasso($sessionmembreasso->membreasso_id);/**/
            $a->setOffreur_projet_date($date_id->toString('yyyy-MM-dd'));
            $a->setOffreurProjetCanton($_POST['offreur_projet_canton']);
            $a->setOffreurProjetVille($_POST['offreur_projet_ville']);
			$a->setPublier($_POST['publier']);
            $ma->save($a);
			

////////////////////////////////////////////////////////////////////////////

        $offreur_projet = new Application_Model_EuOffreurProjet();
        $offreur_projetM = new Application_Model_EuOffreurProjetMapper();
        $offreur_projetM->find($compteur, $offreur_projet);
		
        $offreur_projet->setPublier($this->_request->getParam('publier'));
		$offreur_projetM->update($offreur_projet);
		
		
		
		
$id_offreur_projet = $offreur_projet->offreur_projet_id;
//////////////////////////////////////////
/*if($offreur_projet->offreur_projet_membreasso != 1 && $offreur_projet->offreur_projet_membreasso != 0){
        $membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find($offreur_projet->offreur_projet_membreasso, $membreasso);
			
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find($membreasso->membreasso_association, $association);
		$code_agence = $association->code_agence;
		
        $recubancaire = new Application_Model_EuRecubancaire();
        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
        $cumul_recubancaire = $recubancaire_mapper->findCumul($offreur_projet->offreur_projet_souscription);
        //$cumul_recubancaire = 0;
		
		if($cumul_recubancaire > 0){

		
		if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}else{
			
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association($membreasso->membreasso_association);
            $partagea->setPartagea_offreur_projet($id_offreur_projet);
            $partagea->setPartagea_montant($partagea_montant * 0.75);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////

        $partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso($membreasso->membreasso_id);
            $partagem->setPartagem_offreur_projet($id_offreur_projet);
            $partagem->setPartagem_montant($partagea_montant * 0.25);
            $partagem_mapper->save($partagem);
			
//////////////////////////////////////////

}
}*/

////////////////////////////////////////////////////////////////////////////

            $sessionmembreasso->error = "Opération bien effectuée ...";



		$this->_redirect('/association/addoffreurprojet/param/'.$_POST['offreur_projet_type']);
				}
			
			}else{
		   $sessionmembreasso->error = "Numéro de quittance doit être celui d'un CMFH Offreur de projet ...";
				}
		}
		} else {  $sessionmembreasso->error = "Champs * obligatoire ...";  } 
		}
		
		
            $param = (int)$this->_request->getParam('param');
	 $this->view->param = $param;
		
		
    }




	
	public function listoffreurprojetAction()
    {
        /* page association/listlivraison - Liste des livraisons */

		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $offreurprojet = new Application_Model_EuOffreurprojetMapper();
        $this->view->entries = $offreurprojet->fetchAllByMembreasso($sessionmembreasso->membreasso_id);

    }




    public function listoffreurprojet1Action()
    {
        /* page association/listlivraison - Liste des livraisons */

		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $offreurprojet = new Application_Model_EuOffreurprojetMapper();
        $this->view->entries = $offreurprojet->fetchAllByAssociation($sessionmembreasso->membreasso_association);

    }






    public function editmembreassosouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['souscription_ordre']) && $_POST['souscription_ordre']!="") {
		
			
         $m_souscription2 = new Application_Model_EuSouscriptionMapper();
		$souscription_id = $m_souscription2->findIdSouscription($_POST['souscription_ordre']);
		
		if($souscription_id == NULL) {
		   $sessionmembreasso->error = "Numéro de quittance invalide ...";
		} else {
			
       $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find($_POST['membreasso_id'], $membreasso);
			
            $membreasso->setSouscription_id($souscription_id);
            $m_membreasso->update($membreasso);
			
            $sessionmembreasso->error = "Opération bien effectuée ...";
		$this->_redirect('/association/editmembreassosouscription');
		}
		} else {  $sessionmembreasso->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMembreasso();
        $ma = new Application_Model_EuMembreassoMapper();
		$ma->find($id, $a);
		$this->view->membreasso = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMembreasso();
        $ma = new Application_Model_EuMembreassoMapper();
		$ma->find($id, $a);
		$this->view->membreasso = $a;
            }
	}
	}









    public function ancienppAction() {
        /* page association/ancienpp - Retrouve ancienne personne physique GIE/ReDeMaRe */
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        if (isset($_POST['ok']) && $_POST['ok']=="ok") {
            if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
                $tabela = new Application_Model_DbTable_Physique();
                $membres = new Application_Model_DbTable_EuAncienMembre();
                $select=$tabela->select();
                $select->from($tabela)
                       ->where('numidentp like ?', '%'.$_POST['code_membre'].'%')
                       ->where('(etat_contrat = 0')->orwhere('etat_contrat IS NULL)');
                $memb = $tabela->fetchAll($select);
                if(count($memb) > 0) {
				    $trouvmembre = $memb->current();
				    $souscription = new Application_Model_DbTable_EuSouscription();
					$selection = $souscription->select();
                    $selection->from($souscription)
                              ->where('souscription_ancien_membre like ?',$trouvmembre->numidentp);
				    $sous = $souscription->fetchAll($selection);
					if(count($sous) == 0) {     
                        $this->_redirect('/association/reactivationsouscriptiongiepp/id/'.$trouvmembre->numidentp);
					} else {  
					   $this->view->message = "Quittance de Réactivation déjà effectuée ...";
					}   
                } else {
     				$this->view->message = "Pas de resultat ... Déjà Activé";
				}
            } else {  
			    $this->view->message = "Champs * obligatoire ...";
		    }
       
        } 
    }


	
	
	
	
	
    public function reactivationsouscriptiongieppAction() {
		//$this->_helper->layout->disableLayout();
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

		
		if (isset($_POST['ok']) && $_POST['ok']=="ok")   {
		    if (isset($_POST['numident']) && $_POST['numident'] !="" 
			    && isset($_POST['souscription_personne']) && $_POST['souscription_personne'] !="" 
				&& isset($_POST['souscription_autonome']) && $_POST['souscription_autonome'] !="" 
				&& isset($_POST['souscription_mobile']) && $_POST['souscription_mobile'] !="" 
				&& isset($_POST['souscription_programme']) && $_POST['souscription_programme'] !="" 
				&& isset($_POST['code_activite']) && $_POST['code_activite'] !="" 
				&& isset($_POST['souscription_nom']) && $_POST['souscription_nom'] !="" 
				&& isset($_POST['souscription_prenom']) && $_POST['souscription_prenom'] !="") {
		
		        $db = Zend_Db_Table::getDefaultAdapter();
				$db->beginTransaction();
				try {
		            $eusouscription = new Application_Model_DbTable_EuSouscription();
	                $select = $eusouscription->select();
			        if($_POST['souscription_personne'] == "PP") {
	                   $select->where("LOWER(REPLACE(souscription_nom, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_nom'])));
	                   $select->where("LOWER(REPLACE(souscription_prenom, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_prenom'])));
			        } else {
	                   $select->where("LOWER(REPLACE(souscription_raison, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_raison'])));
			        }
	                $select->order(array("souscription_id ASC"));
	                $select->limit(1);
	                $rowseusouscription = $eusouscription->fetchRow($select);
		            if(count($rowseusouscription) > 0) {
			            $souscription_ok = 1;
			            $souscription_first = $rowseusouscription->souscription_id;
			        } else {
			            $souscription_ok = 0;
			        }
				
				    $date_id = Zend_Date::now();
                    $souscription = new Application_Model_EuSouscription();
                    $souscription_mapper = new Application_Model_EuSouscriptionMapper();
		            include("Transfert.php");
				
				    $compteur_souscription = $souscription_mapper->findConuter() + 1;
                    $souscription->setSouscription_id($compteur_souscription);
				    $souscription->setSouscription_personne($_POST['souscription_personne']);
				    $souscription->setSouscription_nom($_POST['souscription_nom']);
                    $souscription->setSouscription_prenom($_POST['souscription_prenom']);
				
				    $souscription->setSouscription_email($_POST['souscription_email']);
                    $souscription->setSouscription_mobile($_POST['souscription_mobile']);
                    $souscription->setSouscription_membreasso($sessionmembreasso->membreasso_id);
				
				    $souscription->setSouscription_nombre(1);
                    $souscription->setSouscription_programme($_POST['souscription_programme']);
				    $souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
				
				    $souscription->setCode_activite($_POST["code_activite"]);
                    $souscription->setId_metier($_POST["id_metier"]);
                    $souscription->setId_competence($_POST["id_competence"]);
                    $souscription->setSouscription_ville($_POST['souscription_ville']);
                    $souscription->setSouscription_quartier($_POST['souscription_quartier']);
				
				    if($souscription_ok == 1) {
                        $souscription->setSouscription_souscription($souscription_first);
				    } else {
                        $souscription->setSouscription_souscription($compteur_souscription);
			        }
				
				    $souscription->setSouscription_autonome($_POST['souscription_autonome']);
                    $souscription->setSouscription_ancien_membre($_POST['numident']);
			        $souscription->setPublier(3);
					$souscription->setErreur(0);
					$souscription->setId_canton($_POST['id_canton']);
                    $souscription_mapper->save($souscription);
		
		            $html = "";
					$html .= "Nom : ".$_POST['souscription_nom']."<br />";
                    $html .= "Prenom : ".$_POST['souscription_prenom']."<br />";
					
					$html .= "E-mail : ".$_POST['souscription_email']."<br />";
                    $html .= "Mobile : ".$_POST['souscription_mobile']."<br />";
                    $html .= "Ville : ".$_POST['souscription_ville']."<br />";
                    $html .= "Quartier : ".$_POST['souscription_quartier']."<br />";
                    $html .= "Programme : ".$_POST['souscription_programme']."<br />";
					
                        $activiteM = new Application_Model_DbTable_EuActivite();
                        $activite = $activiteM->find($_POST['code_activite']);
		                $row = $activite->current();
                        $html .= "Biens, Produits et Services : ".$row->nom_activite."<br />";

                        $metierM = new Application_Model_DbTable_EuMetier();
                        $metier = $metierM->find($_POST['id_metier']);
		                $row = $metier->current();
                        $html .= "Métier : ".$row->libelle_metier."<br />";

                        $competenceM = new Application_Model_DbTable_EuCompetence();
                        $competence = $competenceM->find($_POST['id_competence']);
		                $row = $competence->current();
                        $html .= "Compétence : ".$row->libelle_competence."<br />";

                    $html .= "Date : ".$date_id->toString('yyyy-MM-dd HH:mm:ss')."<br />";
					
					
					$htmlpdf = "";

                    $htmlpdf .= '
                        <page backbottom="15mm">
                        <page_footer>
                        <table>
                        <tr>
                           <td align="center">
	                       <hr>
	                       Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425</td>
                        </tr>
                        </table>
                        </page_footer>

                        <table width="768" border="0">
                        <tbody>
                        <tr>
                           <td colspan="4"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
                        </tr>';
						
						if($souscription->souscription_personne == "PP") {
                            $souscrip = new Application_Model_EuSouscription();
                            $souscrip_mapper = new Application_Model_EuSouscriptionMapper();
                            $compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, "");
		
	                        if($souscription->souscription_programme == "KACM") {
		                        //if($compteur_souscrip == 0) {$compteur_souscrip = 1029;}	
		                            $unite = 0;	
                                    $htmlpdf .= '
                                    <tr>
                                        <td colspan="4" align="center"><strong><em><u>N° Reçu Personne Physique : PP'.ajoutezero($compteur_souscrip + 1).'</u></em></strong></td>
                                    </tr>';
	                        }
                        }
						
						$souscription = new Application_Model_EuSouscription();
                        $souscriptionM = new Application_Model_EuSouscriptionMapper();
                        $souscriptionM->find($compteur_souscription, $souscription);
		
                        $souscription->setSouscription_ordre($compteur_souscrip + 1);
		                $souscriptionM->update($souscription);
						
						if($souscription->souscription_autonome == 1) {
	                        $souscription_nombre = $souscription->souscription_nombre;
			                if($souscription->souscription_personne == "PP") {
				                $autonome = 0;
			                }
						
						}
						
						if($souscription->souscription_personne == "PP") {
                            $htmlpdf .= '
                                <tr>
                                    <td colspan="4" align="left"><p><em><u>Nom  &amp; prénom(s) de l&rsquo;acheteur&nbsp;</u>: </em><strong><em>'.$souscription->souscription_nom.' '.$souscription->souscription_prenom.'</em></strong></p></td>
                                </tr>';
                        }
						
						if($souscription->souscription_nombre > 0) {
	                        $htmlpdf .= '
                                <tr>
                                    <td colspan="4" align="left"><em><u>Nombre de Comptes Marchands ré-activés: '.$souscription->souscription_nombre.'</u></em></td>
                                </tr>';
                        } else {
                            $htmlpdf .= '
                                <tr>
                                    <td colspan="4" align="left">&nbsp;</td>
                                </tr>';
	                    }
        
                        $htmlpdf .= '
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td colspan="2" align="center">&nbsp;</td>
                                </tr>';
                        $htmlpdf .= '
                                <tr>
                                    <td colspan="2" align="left"><em><strong>Libellé</strong></em></td>
                                    <td align="center"><em><strong>Nombre de compte ré-activé</strong></em></td>
                                    <td align="center"><strong><em>Montant ré-activation</em></strong></td>
                                </tr>';
  
                        $htmlpdf .= '
                                <tr style="background-color:#999;">
                                    <td colspan="2" align="left"><em><strong>Ré-activation de Comptes Marchands</strong></em></td>
                                    <td align="center"><em>'.$souscription_nombre.'</em></td>
                                    <td align="center"><em>'.$autonome.' FCFA</em></td>
                                </tr>';

                        $htmlpdf .= '
                                <tr>
                                    <td colspan="2" align="left"><em><u>Montant total en  lettres&nbsp;</u>: '.lettre(($autonome), 50).' CFA</em></td>
                                    <td colspan="2" rowspan="3" align="left"><img src="'.Util_Utils::getParamEsmc(2).'/images/cachet.jpg" /><br />
                                    Date : '.datefr($date_id->toString('yyyy-MM-dd')).'</td>
                                </tr>';	
  
	                    if($souscription->souscription_programme == "KACM") {
                            $htmlpdf .= '
                                <tr>
                                    <td colspan="2" align="left">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left">&nbsp;</td>
                                </tr>';
		                }
						
						$htmlpdf .= '
                                <tr>
                                    <td colspan="4" align="left">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="left">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center">';
	                                    if($souscription->souscription_vignette != "" && (substr($souscription->souscription_vignette, 0, 3) == "jpg" || substr($souscription->souscription_vignette, 0, 3) == "jpeg" || substr($souscription->souscription_vignette, 0, 3) == "JPG" || substr($souscription->souscription_vignette, 0, 3) == "JPEG")) {
                                            list($width, $height, $type, $attr) = getimagesize(Util_Utils::getParamEsmc(2).$souscription->souscription_vignette);
	                                        $pourcent = 700 * 100 / $width;
	                                        $width2 = 700;
	                                        $height2 = $pourcent * $height / 100;
                                            $htmlpdf .= '<img src="'.Util_Utils::getParamEsmc(2).'/'.$souscription->souscription_vignette.'" width="'.$width2.'" height="'.$height2.'" />

                                            ';
                                        }
                                $htmlpdf .= '  </td>
	                                    </tr>
                                        </tbody>
                                        </table>
                                        <br />
                                        <br />
                                        &nbsp;
                                       </page>';
                        $htmlpdf .= '';
						
						
				//////////////////////////////////////////////////////////////////////
				    $filename = ''.Util_Utils::getParamEsmc(1).'/souscriptions.html';
                    $somecontent = $htmlpdf;

                // Assurons nous que le fichier est accessible en écriture
                if (is_writable($filename)) {
                    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
                    // Le pointeur de fichier est placé à la fin du fichier
                    // c'est là que $somecontent sera placé
                    if (!$handle = fopen($filename, 'w+')) {
                        echo "Impossible d'ouvrir le fichier ($filename)";
                        exit;
                    }

                    // Ecrivons quelque chose dans notre fichier.
                    if (fwrite($handle, $somecontent) === FALSE) {
                        echo "Impossible d'écrire dans le fichier ($filename)";
                        exit;
                    }
                    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
                    fclose($handle);    
                } else {
                    echo "Le fichier $filename n'est pas accessible en écriture.";
                }

                ////////////////////////////////////////////////////////////////////////////	
                $file = $filename;
                if (!is_dir("../../webfiles/pdf_souscription/")) {
                    mkdir("../../webfiles/pdf_souscription/", 0777);
                }
                /*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

                $newfile = "../../webfiles/pdf_souscription/SOUSCRIPTION_".str_replace("/", "_", mettreaccents($souscription->souscription_id))."_.html";
                $newnom = "SOUSCRIPTION_".str_replace("/", "_", mettreaccents($souscription->souscription_id)."_");
                $newchemin = "../../webfiles/pdf_souscription/";

                copy($file, $newfile);

                ob_start();
                include(dirname(__FILE__).'/../'.$newfile);
                $content = ob_get_clean();
				
		
                // convert to PDF
                require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
                try {
                    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                    //$html2pdf->writeHTML($content);
                    $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
                }
                catch(HTML2PDF_exception $e) {
                    echo $e;
                    exit;
                }
                $file = $newchemin.$newnom.'.pdf';
                $filena	= $newnom.'.pdf';
                unlink($newfile);
						
				if($souscription->souscription_email != "") {
                    $config = array('auth' => 'login','username' => Util_Utils::getParamEsmc(3),'password' => Util_Utils::getParamEsmc(4));
                    $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
                    Zend_Mail::setDefaultTransport($tr);		
                    $mail = new Zend_Mail();
                    //$mail->setBodyText('Mon texte de test');
                    $mail->setBodyHtml($html);
                    $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - SIF");
                    $mail->addTo($souscription->souscription_email, $souscription->souscription_nom." ".$souscription->souscription_prenom);
					$mail->setSubject('Ré-activation Quittance Souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
					
					$monImage = file_get_contents($file);
                    $finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
                    $at = new Zend_Mime_Part($monImage);
                    $at->type        = finfo_file($finfo, $file);
                    $at->disposition = Zend_Mime::DISPOSITION_INLINE;
                    $at->encoding    = Zend_Mime::ENCODING_BASE64;
                    $at->filename    = $filena;
                    $mail->addAttachment($at);
                    $mail->send($tr);
		        }
				$esmc_email = Util_Utils::getParamEsmc(3);
                $config = array('auth' => 'login','username' => Util_Utils::getParamEsmc(3),'password' => Util_Utils::getParamEsmc(4));
				
				$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
                Zend_Mail::setDefaultTransport($tr);		
                $mail = new Zend_Mail();
                //$mail->setBodyText('Mon texte de test');
                $mail->setBodyHtml($html);
                $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - SIF");
                $mail->addTo($esmc_email, "ESMC - SIF");
                $mail->setSubject('Ré-activation Quittance Souscription : '.$date_id->toString('dd-MM-yyyy HH:mm:ss'));

                $monImage = file_get_contents($file);
                $finfo = finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
                $at = new Zend_Mime_Part($monImage);
                $at->type        = finfo_file($finfo, $file);
                $at->disposition = Zend_Mime::DISPOSITION_INLINE;
                $at->encoding    = Zend_Mime::ENCODING_BASE64;
                $at->filename    = $filena;
                $mail->addAttachment($at);
                $mail->send($tr);
				
				// operation de transfert des codes kacm
				$date = new Zend_Date();
		        $compte_map = new Application_Model_EuCompteMapper();
                $compte      = new Application_Model_EuCompte();
			    $sms_money   = new Application_Model_EuSmsmoney();
                $money_map   = new Application_Model_EuSmsmoneyMapper();
			
			    $det_sms   = new Application_Model_EuDetailSmsmoney();
			    $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
			
			    $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			    $det_vtesms  = new Application_Model_EuDetailVentesms();
			
			    $mobile = $souscription->souscription_mobile;
			    //$nbre_compte = $souscription->souscription_nombre;
			    $fcaps = Util_Utils::getParametre('CAPS','valeur');
										
				$mont_fs = Util_Utils::getParametre('FS','valeur');
                $mont_fl = Util_Utils::getParametre('FL','valeur');
                $mont_kps = Util_Utils::getParametre('FKPS','valeur');
			
		        //$montant = $nbre_compte * $fcaps;
		        $membre_pbf = '0000000000000000001M';
	            $code_compte_pbf = "NN-TR-".$membre_pbf;
			    $ret = $compte_map->find($code_compte_pbf,$compte);
				
				if($souscription->souscription_programme == 'KACM') {
				     if($ret && ($compte->getSolde() >= ($mont_fs + $mont_fl + $mont_kps))) {
			             // Mise à jour du compte de transfert
				         $compte->setSolde($compte->getSolde() - ($mont_fs + $mont_fl + $mont_kps));
                         $compte_map->update($compte);    
	                  } else {
			             $db->rollback();				
			             $this->view->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
						 $this->view->numident = $_POST['numident'];
                         $this->view->nom_membre = $_POST['souscription_nom'];
                         $this->view->prenom_membre = $_POST['souscription_prenom'];
                         $this->view->ville_membre = $_POST['souscription_ville']; 
                         $this->view->quartier_membre = $_POST['souscription_quartier'];
                         $this->view->email = $_POST['souscription_email'];
                         $this->view->portable = $_POST['souscription_mobile'];
					     $this->_redirect('/association/reactivationsouscriptiongiepp/id/'.$_POST['numident']);
                         return;			   
			          }
					  
					  $codefs   = '';
                      $codefl   = '';
                      $codefkps = '';
					  // Traitement des produits FS
				      // insertion dans la table eu_smsmoney
				      $lignesdetfs = $det_sms_m->findSMSByCompte($membre_pbf,'FS');
					  // Traitement des produits FL
                      // insertion dans la table eu_smsmoney
				      $lignesdetfl = $det_sms_m->findSMSByCompte($membre_pbf,'FL');
					  // Traitement des produits FCPS
				      $lignesdetfkps = $det_sms_m->findSMSByCompte($membre_pbf,'FCPS');
			          if ($lignesdetfs != null && $lignesdetfl !=  null && $lignesdetfkps != null) {						
							$codefs   = strtoupper(Util_Utils::genererCodeSMS(8));
					        $nengfs = $money_map->findConuter() + 1;
							$sms_money->setNEng($nengfs)
                	                  ->setCode_Agence(null)
                                      ->setCreditAmount($mont_fs)
                                      ->setSentTo($mobile)
                                      ->setMotif('FS')
                                      ->setId_Utilisateur(null)
                                      ->setCurrencyCode('XOF')
                                      ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                      ->setFromAccount($code_compte_pbf)
                                      ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                      ->setCreditCode($codefs)
                                      ->setDestAccount(null)
                                      ->setIDDatetimeConsumed(0)
                                      ->setDestAccount_Consumed(null)
                                      ->setDatetimeConsumed(null)
                                      ->setNum_recu(null);
                            $money_map->save($sms_money);                                   
														
							$i = 0;
					        $reste = $mont_fs;
					        $nbre_lignesdetfs = count($lignesdetfs);
				            while ($reste > 0 && $i < $nbre_lignesdetfs) {
					              $lignedetfs = $lignesdetfs[$i];
                                  $id = $lignedetfs->getId_detail_smsmoney();
						          $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						          if ($reste >= $lignedetfs->getSolde_sms()) {
						                 //Mise à jour  des lignes d'enrégistrement
					                     //insertion dans la table eu_detailventesms
						                 $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                         $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                            ->setId_detail_smsmoney($id)
                                                    ->setCode_membre_dist($membre_pbf)
                                                    ->setCode_membre(null)
                                                    ->setType_tansfert('FS')
                                                    ->setCreditcode($codefs)
                                                    ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                    ->setMont_vente($lignedetfs->getSolde_sms())
                                                    ->setId_utilisateur(null)
                                                    ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $reste = $reste - $lignedetfs->getSolde_sms();
							              $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $lignedetfs->getSolde_sms())
		                                             ->setMont_regle($lignedetfs->getMont_regle() + $lignedetfs->getSolde_sms())
		                                             ->setSolde_sms(0);
                                                                $det_sms_m->update($lignedetfs);			 							   
						            } else  {
							              //Mise à jour  des lignes d'enrégistrement
						                  //insertion dans la table eu_detailventesms
						                  $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                          $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                             ->setId_detail_smsmoney($id)
                                                     ->setCode_membre_dist($membre_pbf)
                                                     ->setCode_membre(null)
                                                     ->setType_tansfert('FS')
                                                     ->setCreditcode($codefs)
                                                     ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                     ->setMont_vente($reste)
                                                     ->setId_utilisateur(null)
                                                     ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $lignedetfs->setSolde_sms($lignedetfs->getSolde_sms() - $reste);
						                  $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $reste);
							              $lignedetfs->setMont_regle($lignedetfs->getMont_regle() + $reste);
                                          $det_sms_m->update($lignedetfs);
						                  $reste = 0;
						             }
						             $i++;
					              }
														
								  $codefl   = strtoupper(Util_Utils::genererCodeSMS(8));
				                  $nengfl = $money_map->findConuter() + 1;
                                  $sms_money->setNEng($nengfl)
                	                        ->setCode_Agence(null)
                                            ->setCreditAmount($mont_fl)
                                            ->setSentTo($mobile)
                                            ->setMotif('FL')
                                            ->setId_Utilisateur(null)
                                            ->setCurrencyCode('XOF')
                                            ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                            ->setFromAccount($code_compte_pbf)
                                            ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                            ->setCreditCode($codefl)
                                            ->setDestAccount(null)
                                            ->setIDDatetimeConsumed(0)
                                            ->setDestAccount_Consumed(null)
                                            ->setDatetimeConsumed(null)
                                            ->setNum_recu(null);
                                  $money_map->save($sms_money);
					                                    
								  $j = 0;
					              $reste = $mont_fl;
					              $nbre_lignesdetfl = count($lignesdetfl);
					              while ($reste > 0 && $j < $nbre_lignesdetfl) {
					                    $lignedetfl = $lignesdetfl[$j];
                                        $id = $lignedetfl->getId_detail_smsmoney();
						                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                if ($reste >= $lignedetfl->getSolde_sms()) {
						                   //Mise à jour  des lignes d'enrégistrement
                                           $reste = $reste - $lignedetfl->getSolde_sms();
									       //insertion dans la table eu_detailventesms
						                   $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                           $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                              ->setId_detail_smsmoney($id)
                                                      ->setCode_membre_dist($membre_pbf)
                                                      ->setCode_membre(null)
                                                      ->setType_tansfert('FL')
                                                      ->setCreditcode($codefl)
                                                      ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                      ->setMont_vente($lignedetfl->getSolde_sms())
                                                      ->setId_utilisateur(null)
                                                      ->setCode_produit('FL');
                                            $det_vte_sms->insert($det_vtesms->toArray());
							                $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $lignedetfl->getSolde_sms())
		                                               ->setMont_regle($lignedetfl->getMont_regle() + $lignedetfl->getSolde_sms())
		                                               ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfl);			 							   
						                  } else  {
							                 //Mise à jour  des lignes d'enrégistrement
											//insertion dans la table eu_detailventesms
						                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                               ->setId_detail_smsmoney($id)
                                                       ->setCode_membre_dist($membre_pbf)
                                                       ->setCode_membre(null)
                                                       ->setType_tansfert('FL')
                                                       ->setCreditcode($codefl)
                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                       ->setMont_vente($reste)
                                                       ->setId_utilisateur(null)
                                                       ->setCode_produit('FL');
                                              $det_vte_sms->insert($det_vtesms->toArray());
                                              $lignedetfl->setSolde_sms($lignedetfl->getSolde_sms() - $reste);
						                      $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $reste);
							                  $lignedetfl->setMont_regle($lignedetfl->getMont_regle() + $reste);
                                              $det_sms_m->update($lignedetfl);
						                      $reste = 0;
						                   }
						                                $j++;
					                   }
													
													$codefkps = strtoupper(Util_Utils::genererCodeSMS(8));
				                                    $nengfkps = $money_map->findConuter() + 1;
                                                    $sms_money->setNEng($nengfkps)
                	                                          ->setCode_Agence(null)
                                                              ->setCreditAmount($mont_kps)
                                                              ->setSentTo($mobile)
                                                              ->setMotif('FCPS')
                                                              ->setId_Utilisateur(null)
                                                              ->setCurrencyCode('XOF')
                                                              ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                              ->setFromAccount($code_compte_pbf)
                                                              ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                              ->setCreditCode($codefkps)
                                                              ->setDestAccount(null)
                                                              ->setIDDatetimeConsumed(0)
                                                              ->setDestAccount_Consumed(null)
                                                              ->setDatetimeConsumed(null)
                                                              ->setNum_recu(null);
                                                    $money_map->save($sms_money);
													
													$k = 0;
					                                $reste = $mont_kps;
					                                $nbre_lignesdetfkps = count($lignesdetfkps);
					                                while ($reste > 0 && $k < $nbre_lignesdetfkps) {
					                                    $lignedetfkps = $lignesdetfkps[$k];
                                                        $id = $lignedetfkps->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfkps->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($lignedetfkps->getSolde_sms())
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $reste = $reste - $lignedetfkps->getSolde_sms();
							                                $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $lignedetfkps->getSolde_sms())
		                                                                 ->setMont_regle($lignedetfkps->getMont_regle() + $lignedetfkps->getSolde_sms())
		                                                                 ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfkps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfkps->setSolde_sms($lignedetfkps->getSolde_sms() - $reste);
						                                    $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $reste);
							                                $lignedetfkps->setMont_regle($lignedetfkps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfkps);
						                                    $reste = 0;
						                                }
						                                $k++;
					                                }
													
													// insertion dans la table eu_code_activation
				                                    $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				                                    $codeactivation = new Application_Model_EuCodeActivation();
			                                        $countcode = $m_codeactivation->findConuter() + 1;
				
				                                    $codeactivation->setId_code_activation($countcode)
					                                              ->setDate_generer($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                                    $codeactivation->setCode_membre(null);   
			                                        $codeactivation->setCode_fs($codefs);
				                                    $codeactivation->setCode_fl($codefl);
				                                    $codeactivation->setCode_fkps($codefkps);
				                                    $codeactivation->setSouscription_id($souscription->souscription_id);
				                                    $m_codeactivation->save($codeactivation);
				
				                                    $compteur = Util_Utils::findConuter() + 1;
				                                    Util_Utils::addSms($compteur,$mobile,'Voici vos codes d\'activation de compte marchand : '.' CODE FS : '.$codefs.' CODE FL : '.$codefl.' CODE FCPS : '.$codefkps);
												
										            }  else {
												        $db->rollback();
	                                                    $this->view->error = 'Erreur de traitement : le solde est null';
						                                $this->view->numident = $_POST['numident'];
                                                        $this->view->nom_membre = $_POST['souscription_nom'];
                                                        $this->view->prenom_membre = $_POST['souscription_prenom'];
                                                        $this->view->ville_membre = $_POST['souscription_ville']; 
                                                        $this->view->quartier_membre = $_POST['souscription_quartier'];
                                                        $this->view->email = $_POST['souscription_email'];
                                                        $this->view->portable = $_POST['souscription_mobile'];
					                                    $this->_redirect('/association/reactivationsouscriptiongiepp/id/'.$_POST['numident']);	
												    }	
				
				
				
				}
				
				
				
		        $db->commit();
		        $sessionmembreasso->errorlogin = "Demande de Quittance de Ré-activation bien effectuée";
		        $this->_redirect('/association/ancienpp');
					
				} catch (Exception $exc) {
				    $db->rollback();
				    $this->view->error = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				    return;
			    }	
			
			}   else {  $this->view->error = "Champs * obligatoire ...";  }	
			
		} else {
            $id = (string)$this->_request->getParam('id');
            $tabela = new Application_Model_DbTable_Physique();
            $membres = new Application_Model_DbTable_EuAncienMembre();
            $select=$tabela->select();
            $select->from($tabela)
                   ->where('numidentp like ?', '%'.$id.'%')
                   ->where('(etat_contrat = 0')->orwhere('etat_contrat IS NULL)');
            $memb = $tabela->fetchAll($select);
            $trouvmembre = $memb->current();
      
            $this->view->numident = $trouvmembre->numidentp;
            $this->view->nom_membre = $trouvmembre->nom;
            $this->view->prenom_membre = $trouvmembre->prenom;
            //$this->view->sexe = $trouvmembre->sexe;
            //$this->view->profession = $trouvmembre->prof;
            //$this->view->tel = $trouvmembre->tel;
            $this->view->ville_membre = $trouvmembre->ville; 
            //$this->view->pere = $trouvmembre->pere;
            //$this->view->mere = $trouvmembre->mere;
            $this->view->quartier_membre = $trouvmembre->qartresid;
            //$this->view->bp = $trouvmembre->bp;
            //$this->view->nbre_enf = $trouvmembre->nbrenf;
            $this->view->email = $trouvmembre->email;
            $this->view->portable = $trouvmembre->portable;
            //$this->view->formation = $trouvmembre->formation;
            //$this->view->lieu_nais = $trouvmembre->lieunais;
        }
		
	}

	






    public function ancienpmAction() {
        /* page association/ancienpm - Retrouve ancienne personne morale GIE/ReDeMaRe */
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        if (isset($_POST['ok']) && $_POST['ok']=="ok") {
            if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
                $tabela = new Application_Model_DbTable_Morale();
                $select=$tabela->select();
                $select->from($tabela)
                       ->where('numidentm like ?', '%'.$_POST['code_membre'].'%')
                       ->where('(etat_contrat = 0')->orwhere('etat_contrat IS NULL)')
                       ->order('nomm ASC');
                $memb = $tabela->fetchAll($select);
                if(count($memb) > 0) {
                    $trouvmembre = $memb->current();
                    $souscription = new Application_Model_DbTable_EuSouscription();
					$selection = $souscription->select();
                    $selection->from($souscription)
                              ->where('souscription_ancien_membre like ?',$trouvmembre->numidentm);
				    $sous = $souscription->fetchAll($selection);
					if(count($sous) == 0) {     
                      $this->_redirect('/association/reactivationsouscriptiongiepm/id/'.$trouvmembre->numidentm);
					} else {  
					  $this->view->message = "Quittance de Réactivation déjà effectuée ...";
					}					 
                } else {  $this->view->message = "Pas de resultat ... Déjà Activé";}
            } else {  $this->view->message = "Champs * obligatoire ...";}
       
        } 
    }



    public function reactivationsouscriptiongiepmAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

		
		if (isset($_POST['ok']) && $_POST['ok']=="ok") {
		    if (isset($_POST['numidentm']) && $_POST['numidentm']!="" 
			    && isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="" 
				&& isset($_POST['souscription_autonome']) && $_POST['souscription_autonome']!="" 
				&& isset($_POST['souscription_mobile']) && $_POST['souscription_mobile']!="" 
				&& isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="" 
				&& isset($_POST['code_activite']) && $_POST['code_activite']!="" 
				&& isset($_POST['souscription_raison']) && $_POST['souscription_raison']!="" 
				&& isset($_POST['type_acteur']) && $_POST['type_acteur']!="" 
				&& isset($_POST['statut_juridique']) && $_POST['statut_juridique']!="" 
				&& isset($_POST['souscription_type']) && $_POST['souscription_type']!="" 
				&& isset($_POST['souscription_numero']) && $_POST['souscription_numero']!="" 
				&& isset($_POST['souscription_date_numero']) && $_POST['souscription_date_numero']!="" 
				&& isset($_POST['souscription_nombre']) && $_POST['souscription_nombre']!="" 
				&& isset($_POST['souscription_montant']) && $_POST['souscription_montant']!="") {
		        
				    $db = Zend_Db_Table::getDefaultAdapter();
				    $db->beginTransaction();
				    try {
		                $eusouscription = new Application_Model_DbTable_EuSouscription();
	                    $select = $eusouscription->select();
					    $select->where("LOWER(REPLACE(souscription_raison, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_raison'])));
						
						$select->order(array("souscription_id ASC"));
	                    $select->limit(1);
	                    $rowseusouscription = $eusouscription->fetchRow($select);
		                if(count($rowseusouscription) > 0) {
			                $souscription_ok = 1;
			                $souscription_first = $rowseusouscription->souscription_id;
			            } else {
			                $souscription_ok = 0;
			            }
						
						$date_id = Zend_Date::now();
                        $souscription = new Application_Model_EuSouscription();
                        $souscription_mapper = new Application_Model_EuSouscriptionMapper();
						
						include("Transfert.php");
		                if(isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!="") {
		                    $chemin	= "souscriptions";
		                    $file = $_FILES['souscription_vignette']['name'];
		                    $file1='souscription_vignette';
		                    $souscription_vignette = $chemin."/".transfert($chemin,$file1);
		                } else {$souscription_vignette = "";}
						
						$compteur_souscription = $souscription_mapper->findConuter() + 1;
                        $souscription->setSouscription_id($compteur_souscription);
                        $souscription->setSouscription_personne($_POST['souscription_personne']);
						
						$souscription->setSouscription_raison($_POST['souscription_raison']);
                        $souscription->setCode_type_acteur($_POST["type_acteur"]);
                        $souscription->setCode_statut($_POST["statut_juridique"]);
						
						$souscription->setSouscription_email($_POST['souscription_email']);
                        $souscription->setSouscription_mobile($_POST['souscription_mobile']);
                        $souscription->setSouscription_membreasso($sessionmembreasso->membreasso_id);
                        $souscription->setSouscription_type($_POST['souscription_type']);
                        $souscription->setSouscription_numero($_POST['souscription_numero']);
                        $souscription->setSouscription_date_numero($_POST['souscription_date_numero']);
			            if($_POST['souscription_type'] == "Banque") {
                            $souscription->setSouscription_banque($_POST['souscription_banque']);
			            }
						
                        $souscription->setSouscription_montant($_POST['souscription_montant']);
                        $souscription->setSouscription_nombre($_POST['souscription_nombre']);
                        $souscription->setSouscription_programme($_POST['souscription_programme']);
						$souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                        $souscription->setSouscription_vignette($souscription_vignette);
                        $souscription->setCode_activite($_POST["code_activite"]);
                        $souscription->setId_metier($_POST["id_metier"]);
                        $souscription->setId_competence($_POST["id_competence"]);
                        $souscription->setSouscription_ville($_POST['souscription_ville']);
                        $souscription->setSouscription_quartier($_POST['souscription_quartier']);
						
						if($souscription_ok == 1) {
                            $souscription->setSouscription_souscription($souscription_first);
				        } else {
                            $souscription->setSouscription_souscription($compteur_souscription);
			            }
            
                        $souscription->setSouscription_autonome($_POST['souscription_autonome']);
                        $souscription->setSouscription_ancien_membre($_POST['numidentm']);
			            $souscription->setPublier(0);
						$souscription->setErreur(0);
						$souscription->setId_canton($_POST['id_canton']);
                        $souscription_mapper->save($souscription);
						
						
						////////////////////////////////////////////////////////////////////////////////////////
						
						$recubancaire = new Application_Model_EuRecubancaire();
                        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
						
						$compteur_recubancaire = $recubancaire_mapper->findConuter() + 1;
						$recubancaire->setRecubancaire_id($compteur_recubancaire);
                        $recubancaire->setRecubancaire_type($request->getParam("souscription_type"));
                        $recubancaire->setRecubancaire_numero($request->getParam("souscription_numero"));
                        $recubancaire->setRecubancaire_date_numero($request->getParam("souscription_date_numero"));
			            if($_POST['souscription_type'] == "Banque") {
                          $recubancaire->setRecubancaire_banque($request->getParam("souscription_banque"));
			            }
                        $recubancaire->setRecubancaire_montant($request->getParam("souscription_montant"));
                        $recubancaire->setRecubancaire_vignette($souscription_vignette);
                        $recubancaire->setRecubancaire_souscription($compteur_souscription);
			            $recubancaire->setPublier(1);
                        $recubancaire_mapper->save($recubancaire);
						
						
						
						
						$html = "";
						$html .= "Raison sociale : ".$_POST['souscription_raison']."<br />";
                        if($_POST["type_acteur"] == 'EI')   { $html .= "Type Association : Entreprise Industrie<br />";}
                        if($_POST["type_acteur"] == 'OE')   {$html .= "Type Association : Opérateur Economique<br />";}
                        if($_POST["type_acteur"] == 'OSE')  {$html .= "Type Association : Opérateur Socio-Economique<br />";}
                        if($_POST["type_acteur"] == 'PEI')  {$html .= "Type Association : Partenaire Entreprise Industrie<br />";}
                        if($_POST["type_acteur"] == 'POE')  {$html .= "Type Association : Partenaire Opérateur Economique<br />";}
                        if($_POST["type_acteur"] == 'POSE') {$html .= "Type Association : Partenaire Opérateur Socio-Economique<br />";}

                        $statutjuridique = new Application_Model_EuStatutJuridique();
                        $statutjuridiqueM = new Application_Model_EuStatutJuridiqueMapper();
                        $statutjuridiqueM->find($_POST["statut_juridique"], $statutjuridique);
                        $html .= "Statut juridique : ".$statutjuridique->libelle_statut."<br />";
			
                        $html .= "E-mail : ".$_POST['souscription_email']."<br />";
                        $html .= "Mobile : ".$_POST['souscription_mobile']."<br />";
                        $html .= "Ville : ".$_POST['souscription_ville']."<br />";
                        $html .= "Quartier : ".$_POST['souscription_quartier']."<br />";
                        $html .= "Programme : ".$_POST['souscription_programme']."<br />";
						
                        $activiteM = new Application_Model_DbTable_EuActivite();
                        $activite = $activiteM->find($_POST['code_activite']);
		                $row = $activite->current();
                        $html .= "Biens, Produits et Services : ".$row->nom_activite."<br />";

                        $metierM = new Application_Model_DbTable_EuMetier();
                        $metier = $metierM->find($_POST['id_metier']);
		                $row = $metier->current();
                        $html .= "Métier : ".$row->libelle_metier."<br />";

                        $competenceM = new Application_Model_DbTable_EuCompetence();
                        $competence = $competenceM->find($_POST['id_competence']);
		                $row = $competence->current();
                        $html .= "Compétence : ".$row->libelle_competence."<br />";


                        $html .= "Type : ".$_POST['souscription_type']."<br />";

			            if($_POST['souscription_type'] == "Banque") {
                            $banque = new Application_Model_EuBanque();
                            $banqueM = new Application_Model_EuBanqueMapper();
                            $banqueM->find($_POST['souscription_banque'], $banque);
                            $html .= "Banque : ".$banque->libelle_banque."<br/>";
			            }
                        $html .= "Numero Reçu Banque ou Numéro Transaction Flooz: ".$_POST['souscription_numero']."<br />";
                        $html .= "Date Reçu Banque ou Transaction Flooz: ".$_POST['souscription_date_numero']."<br />";
                        $html .= "Montant : ".$_POST['souscription_montant']."<br />";
                        $html .= "Nombre : ".$_POST['souscription_nombre']."<br />";

                        $html .= "Date : ".$date_id->toString('yyyy-MM-dd HH:mm:ss')."<br />";
                        $html .= "Vignette : <a href='http://prod.esmcgacsource.com/".$souscription_vignette."'>".$souscription_vignette."</a>";
						
						$esmc_email	 = Util_Utils::getParamEsmc(3);
						$tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
                        Zend_Mail::setDefaultTransport($tr);		
                        $mail = new Zend_Mail();
                        //$mail->setBodyText('Mon texte de test');
                        $mail->setBodyHtml($html);
                        $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - SIF");
                        $mail->addTo($esmc_email, "ESMC - SIF");
                        $mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm:ss'));
                        $mail->send();
						
						if($_POST['souscription_email'] != "") {
                            $config = array('auth' => 'login','username' => Util_Utils::getParamEsmc(3),'password' => Util_Utils::getParamEsmc(4));
                            $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
                            Zend_Mail::setDefaultTransport($tr);		
                            $mail = new Zend_Mail();
                            //$mail->setBodyText('Mon texte de test');
                            $mail->setBodyHtml($html);
                            $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - SIF");
                            $mail->addTo($_POST['souscription_email'], $_POST['souscription_raison']);
                            $mail->setSubject('Ré-activation par souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
                            $mail->send($tr);
			            }

                        $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
		                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($request->getParam("souscription_banque"),$request->getParam("souscription_numero"),$request->getParam("souscription_date_numero"));
                        if(count($relevebancairedetail) > 0) {
                              if($relevebancairedetail->relevebancairedetail_montant >= $_POST['souscription_montant']) {
							       validation_automatique($compteur_souscription);
								   // operation de transfert
								   $souscription = new Application_Model_EuSouscription();
		                           $souscriptionM = new Application_Model_EuSouscriptionMapper();
                                   $souscriptionM->find($compteur_souscription, $souscription);
								   $date = new Zend_Date();
		                           $compte_map = new Application_Model_EuCompteMapper();
                                   $compte      = new Application_Model_EuCompte();
			                       $sms_money   = new Application_Model_EuSmsmoney();
                                   $money_map   = new Application_Model_EuSmsmoneyMapper();
			
			                       $det_sms   = new Application_Model_EuDetailSmsmoney();
			                       $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
			
			                       $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			                       $det_vtesms  = new Application_Model_EuDetailVentesms();
			
			                       $mobile = $souscription->souscription_mobile;
			                       //$nbre_compte = $souscription->souscription_nombre;
			                       $fcaps = Util_Utils::getParametre('CAPS','valeur');
										
								   $mont_fs = Util_Utils::getParametre('FS','valeur');
                                   $mont_fl = Util_Utils::getParametre('FL','valeur');
                                   $mont_kps = Util_Utils::getParametre('FKPS','valeur');
			
		                           //$montant = $nbre_compte * $fcaps;
		                           $membre_pbf = '0000000000000000001M';
	                               $code_compte_pbf = "NN-TR-".$membre_pbf;
			                       $ret = $compte_map->find($code_compte_pbf,$compte);
								   
								   if($souscription->souscription_programme == 'KACM') {
				     if($ret && ($compte->getSolde() >= ($mont_fs + $mont_fl + $mont_kps))) {
			             // Mise à jour du compte de transfert
				         $compte->setSolde($compte->getSolde() - ($mont_fs + $mont_fl + $mont_kps));
                         $compte_map->update($compte);    
	                  } else {
			             $db->rollback();				
			             $this->view->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
						 $this->view->numidentm = $_POST['numidentm'];
                         $this->view->raison = $_POST['souscription_raison'];
                         $this->view->ville_membre = $_POST['souscription_ville']; 
                         $this->view->quartier_membre = $_POST['souscription_quartier'];
                         $this->view->email = $_POST['souscription_email'];
                         $this->view->portable = $_POST['souscription_mobile'];
					     $this->_redirect('/association/reactivationsouscriptiongiepm/id/'.$_POST['numidentm']);
                         return;			   
			          }
					  
					  $codefs   = '';
                      $codefl   = '';
                      $codefkps = '';
					  // Traitement des produits FS
				      // insertion dans la table eu_smsmoney
				      $lignesdetfs = $det_sms_m->findSMSByCompte($membre_pbf,'FS');
					  // Traitement des produits FL
                      // insertion dans la table eu_smsmoney
				      $lignesdetfl = $det_sms_m->findSMSByCompte($membre_pbf,'FL');
					  // Traitement des produits FCPS
				      $lignesdetfkps = $det_sms_m->findSMSByCompte($membre_pbf,'FCPS');
			          if ($lignesdetfs != null && $lignesdetfl !=  null && $lignesdetfkps != null) {						
							$codefs   = strtoupper(Util_Utils::genererCodeSMS(8));
					        $nengfs = $money_map->findConuter() + 1;
							$sms_money->setNEng($nengfs)
                	                  ->setCode_Agence(null)
                                      ->setCreditAmount($mont_fs)
                                      ->setSentTo($mobile)
                                      ->setMotif('FS')
                                      ->setId_Utilisateur(null)
                                      ->setCurrencyCode('XOF')
                                      ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                      ->setFromAccount($code_compte_pbf)
                                      ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                      ->setCreditCode($codefs)
                                      ->setDestAccount(null)
                                      ->setIDDatetimeConsumed(0)
                                      ->setDestAccount_Consumed(null)
                                      ->setDatetimeConsumed(null)
                                      ->setNum_recu(null);
                            $money_map->save($sms_money);                                   
														
							$i = 0;
					        $reste = $mont_fs;
					        $nbre_lignesdetfs = count($lignesdetfs);
				            while ($reste > 0 && $i < $nbre_lignesdetfs) {
					              $lignedetfs = $lignesdetfs[$i];
                                  $id = $lignedetfs->getId_detail_smsmoney();
						          $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						          if ($reste >= $lignedetfs->getSolde_sms()) {
						                 //Mise à jour  des lignes d'enrégistrement
					                     //insertion dans la table eu_detailventesms
						                 $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                         $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                            ->setId_detail_smsmoney($id)
                                                    ->setCode_membre_dist($membre_pbf)
                                                    ->setCode_membre(null)
                                                    ->setType_tansfert('FS')
                                                    ->setCreditcode($codefs)
                                                    ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                    ->setMont_vente($lignedetfs->getSolde_sms())
                                                    ->setId_utilisateur(null)
                                                    ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $reste = $reste - $lignedetfs->getSolde_sms();
							              $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $lignedetfs->getSolde_sms())
		                                             ->setMont_regle($lignedetfs->getMont_regle() + $lignedetfs->getSolde_sms())
		                                             ->setSolde_sms(0);
                                                                $det_sms_m->update($lignedetfs);			 							   
						            } else  {
							              //Mise à jour  des lignes d'enrégistrement
						                  //insertion dans la table eu_detailventesms
						                  $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                          $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                             ->setId_detail_smsmoney($id)
                                                     ->setCode_membre_dist($membre_pbf)
                                                     ->setCode_membre(null)
                                                     ->setType_tansfert('FS')
                                                     ->setCreditcode($codefs)
                                                     ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                     ->setMont_vente($reste)
                                                     ->setId_utilisateur(null)
                                                     ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $lignedetfs->setSolde_sms($lignedetfs->getSolde_sms() - $reste);
						                  $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $reste);
							              $lignedetfs->setMont_regle($lignedetfs->getMont_regle() + $reste);
                                          $det_sms_m->update($lignedetfs);
						                  $reste = 0;
						             }
						             $i++;
					              }
														
								  $codefl   = strtoupper(Util_Utils::genererCodeSMS(8));
				                  $nengfl = $money_map->findConuter() + 1;
                                  $sms_money->setNEng($nengfl)
                	                        ->setCode_Agence(null)
                                            ->setCreditAmount($mont_fl)
                                            ->setSentTo($mobile)
                                            ->setMotif('FL')
                                            ->setId_Utilisateur(null)
                                            ->setCurrencyCode('XOF')
                                            ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                            ->setFromAccount($code_compte_pbf)
                                            ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                            ->setCreditCode($codefl)
                                            ->setDestAccount(null)
                                            ->setIDDatetimeConsumed(0)
                                            ->setDestAccount_Consumed(null)
                                            ->setDatetimeConsumed(null)
                                            ->setNum_recu(null);
                                  $money_map->save($sms_money);
					                                    
								  $j = 0;
					              $reste = $mont_fl;
					              $nbre_lignesdetfl = count($lignesdetfl);
					              while ($reste > 0 && $j < $nbre_lignesdetfl) {
					                    $lignedetfl = $lignesdetfl[$j];
                                        $id = $lignedetfl->getId_detail_smsmoney();
						                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                if ($reste >= $lignedetfl->getSolde_sms()) {
						                   //Mise à jour  des lignes d'enrégistrement
                                           $reste = $reste - $lignedetfl->getSolde_sms();
									       //insertion dans la table eu_detailventesms
						                   $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                           $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                              ->setId_detail_smsmoney($id)
                                                      ->setCode_membre_dist($membre_pbf)
                                                      ->setCode_membre(null)
                                                      ->setType_tansfert('FL')
                                                      ->setCreditcode($codefl)
                                                      ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                      ->setMont_vente($lignedetfl->getSolde_sms())
                                                      ->setId_utilisateur(null)
                                                      ->setCode_produit('FL');
                                            $det_vte_sms->insert($det_vtesms->toArray());
							                $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $lignedetfl->getSolde_sms())
		                                               ->setMont_regle($lignedetfl->getMont_regle() + $lignedetfl->getSolde_sms())
		                                               ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfl);			 							   
						                  } else  {
							                 //Mise à jour  des lignes d'enrégistrement
											//insertion dans la table eu_detailventesms
						                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                               ->setId_detail_smsmoney($id)
                                                       ->setCode_membre_dist($membre_pbf)
                                                       ->setCode_membre(null)
                                                       ->setType_tansfert('FL')
                                                       ->setCreditcode($codefl)
                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                       ->setMont_vente($reste)
                                                       ->setId_utilisateur(null)
                                                       ->setCode_produit('FL');
                                              $det_vte_sms->insert($det_vtesms->toArray());
                                              $lignedetfl->setSolde_sms($lignedetfl->getSolde_sms() - $reste);
						                      $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $reste);
							                  $lignedetfl->setMont_regle($lignedetfl->getMont_regle() + $reste);
                                              $det_sms_m->update($lignedetfl);
						                      $reste = 0;
						                   }
						                                $j++;
					                   }
													
													$codefkps = strtoupper(Util_Utils::genererCodeSMS(8));
				                                    $nengfkps = $money_map->findConuter() + 1;
                                                    $sms_money->setNEng($nengfkps)
                	                                          ->setCode_Agence(null)
                                                              ->setCreditAmount($mont_kps)
                                                              ->setSentTo($mobile)
                                                              ->setMotif('FCPS')
                                                              ->setId_Utilisateur(null)
                                                              ->setCurrencyCode('XOF')
                                                              ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                              ->setFromAccount($code_compte_pbf)
                                                              ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                              ->setCreditCode($codefkps)
                                                              ->setDestAccount(null)
                                                              ->setIDDatetimeConsumed(0)
                                                              ->setDestAccount_Consumed(null)
                                                              ->setDatetimeConsumed(null)
                                                              ->setNum_recu(null);
                                                    $money_map->save($sms_money);
													
													$k = 0;
					                                $reste = $mont_kps;
					                                $nbre_lignesdetfkps = count($lignesdetfkps);
					                                while ($reste > 0 && $k < $nbre_lignesdetfkps) {
					                                    $lignedetfkps = $lignesdetfkps[$k];
                                                        $id = $lignedetfkps->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfkps->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($lignedetfkps->getSolde_sms())
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $reste = $reste - $lignedetfkps->getSolde_sms();
							                                $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $lignedetfkps->getSolde_sms())
		                                                                 ->setMont_regle($lignedetfkps->getMont_regle() + $lignedetfkps->getSolde_sms())
		                                                                 ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfkps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfkps->setSolde_sms($lignedetfkps->getSolde_sms() - $reste);
						                                    $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $reste);
							                                $lignedetfkps->setMont_regle($lignedetfkps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfkps);
						                                    $reste = 0;
						                                }
						                                $k++;
					                                }
													
													// insertion dans la table eu_code_activation
				                                    $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				                                    $codeactivation = new Application_Model_EuCodeActivation();
			                                        $countcode = $m_codeactivation->findConuter() + 1;
				
				                                    $codeactivation->setId_code_activation($countcode)
					                                              ->setDate_generer($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                                    $codeactivation->setCode_membre(null);   
			                                        $codeactivation->setCode_fs($codefs);
				                                    $codeactivation->setCode_fl($codefl);
				                                    $codeactivation->setCode_fkps($codefkps);
				                                    $codeactivation->setSouscription_id($souscription->souscription_id);
				                                    $m_codeactivation->save($codeactivation);
				
				                                    $compteur = Util_Utils::findConuter() + 1;
				                                    Util_Utils::addSms($compteur,$mobile,'Voici vos codes d\'activation de compte marchand : '.' CODE FS : '.$codefs.' CODE FL : '.$codefl.' CODE FCPS : '.$codefkps);
												
										            }  else {
												        $db->rollback();
	                                                    $this->view->error = 'Erreur de traitement : le solde est null';
						                                $this->view->numidentm = $_POST['numidentm'];
                                                        $this->view->raison = $_POST['souscription_raison'];
                                                        $this->view->ville_membre = $_POST['souscription_ville']; 
                                                        $this->view->quartier_membre = $_POST['souscription_quartier'];
                                                        $this->view->email = $_POST['souscription_email'];
                                                        $this->view->portable = $_POST['souscription_mobile'];
					                                    $this->_redirect('/association/reactivationsouscriptiongiepm/id/'.$_POST['numidentm']);	
												    }	
				                             }
							  
							  } else {
							       $db->commit();
                                   $sessionmembreasso->errorlogin = "Demande de Quittance de Ré-activation bien effectuée, mais le montant est insuffisant. Veuillez compléter le montant par un autre dépôt à la banque.";
		                           $this->_redirect('/association/ancienpm');/**/
					          }   

                        }  else {
						      $db->commit();
                              $sessionmembreasso->errorlogin = "Demande de Quittance de Ré-activation bien effectuée. Votre demande n’est pas encore vérifiée, revenez plus tard.";
		                      $this->_redirect('/association/ancienpm');/**/
			            }


						
						$db->commit();
		                $sessionmembreasso->errorlogin = "Demande de Quittance de Ré-activation bien effectuée";
		                $this->_redirect('/association/ancienpm');
		
		            } catch (Exception $exc) {
				        $db->rollback();
				        $this->view->error = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				        return;
			        }
		
		    }   else {  
			    $this->view->error = "Champs * obligatoire ...";  
			}
		
		} else {
            $id = (string)$this->_request->getParam('id');
            $tabela = new Application_Model_DbTable_Morale();
            $select=$tabela->select();
            $select->from($tabela)
                   ->where('numidentm like ?', '%'.$id.'%')
                   ->where('(etat_contrat = 0')->orwhere('etat_contrat IS NULL)')
                   ->order('nomm ASC');
            $memb = $tabela->fetchAll($select);
            $trouvmembre = $memb->current();
            $this->view->numidentm = $trouvmembre->numidentm;
            $this->view->raison = $trouvmembre->nomm;
            //$this->view->code_rep = $trouvmembre->representant;
            $this->view->quartier_membre = $trouvmembre->qart;
            $this->view->ville_membre = $trouvmembre->ville;
            //$this->view->bp = $trouvmembre->bp;
            //$this->view->tel = $trouvmembre->tel;
            $this->view->portable = $trouvmembre->portable;
            $this->view->email = $trouvmembre->email;
            //$this->view->site_web = $trouvmembre->site;   
        }
		
	}

  
  





    public function ancienppmcnpAction() {
        /* page association/ancienppmcnp - Retrouve ancienne personne physique MCNP */

		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    

        if (isset($_POST['ok']) && $_POST['ok']=="ok") {
            if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
                $tabela = new Application_Model_DbTable_EuAncienMembre();
                $select = $tabela->select();
                $select->where('ancien_code_membre like ?', '%'.$_POST['code_membre'].'%')
                       ->where('(etat_contrat = 0')->orwhere('etat_contrat IS NULL)');       
                $memb = $tabela->fetchAll($select);
                if(count($memb) > 0) {
                    $trouvmembre = $memb->current();      
                    $souscription = new Application_Model_DbTable_EuSouscription();
					$selection = $souscription->select();
                    $selection->from($souscription)
                              ->where('souscription_ancien_membre like ?',$trouvmembre->ancien_code_membre);
				    $sous = $souscription->fetchAll($selection);
					if(count($sous) == 0) {     
                      $this->_redirect('/association/reactivationsouscriptionmcnppp/id/'.$trouvmembre->ancien_code_membre);
					} else {  
					   $this->view->message = "Quittance de Réactivation déjà effectuée ...";
					}				      
                } else {  $this->view->message = "Pas de resultat ... Déjà Activé";}
            } else {  $this->view->message = "Champs * obligatoire ...";}
       
        } 
    }


    public function reactivationsouscriptionmcnpppAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

		
	    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
		    if (isset($_POST['ancien_code_membre']) && $_POST['ancien_code_membre']!="" 
			    && isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="" 
				&& isset($_POST['souscription_autonome']) && $_POST['souscription_autonome']!="" 
				&& isset($_POST['souscription_mobile']) && $_POST['souscription_mobile']!="" 
				&& isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="" 
				&& isset($_POST['code_activite']) && $_POST['code_activite']!="" 
				&& isset($_POST['souscription_nom']) && $_POST['souscription_nom']!="" 
				&& isset($_POST['souscription_prenom']) && $_POST['souscription_prenom']!="") {
		            $db = Zend_Db_Table::getDefaultAdapter();
				    $db->beginTransaction();
				    try {
		                $eusouscription = new Application_Model_DbTable_EuSouscription();
	                    $select = $eusouscription->select();
						$select->where("LOWER(REPLACE(souscription_nom, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_nom'])));
	                    $select->where("LOWER(REPLACE(souscription_prenom, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_prenom'])));
						$select->order(array("souscription_id ASC"));
	                    $select->limit(1);
	                    $rowseusouscription = $eusouscription->fetchRow($select);
		                if(count($rowseusouscription) > 0) {
			                $souscription_ok = 1;
			                $souscription_first = $rowseusouscription->souscription_id;
			            } else {
			                $souscription_ok = 0;
			            }
						$date_id = Zend_Date::now();
                        $souscription = new Application_Model_EuSouscription();
                        $souscription_mapper = new Application_Model_EuSouscriptionMapper();
		                include("Transfert.php");
						
						$compteur_souscription = $souscription_mapper->findConuter() + 1;
                        $souscription->setSouscription_id($compteur_souscription);
                        $souscription->setSouscription_personne($_POST['souscription_personne']);
						$souscription->setSouscription_nom($_POST['souscription_nom']);
						$souscription->setSouscription_prenom($_POST['souscription_prenom']);
						
						$souscription->setSouscription_email($_POST['souscription_email']);
                        $souscription->setSouscription_mobile($_POST['souscription_mobile']);
                        $souscription->setSouscription_membreasso($sessionmembreasso->membreasso_id);
						$souscription->setSouscription_nombre(1);
                        $souscription->setSouscription_programme($_POST['souscription_programme']);
						$souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
						$souscription->setCode_activite($_POST["code_activite"]);
                        $souscription->setId_metier($_POST["id_metier"]);
                        $souscription->setId_competence($_POST["id_competence"]);
                        $souscription->setSouscription_ville($_POST['souscription_ville']);
                        $souscription->setSouscription_quartier($_POST['souscription_quartier']);
						
						if($souscription_ok == 1) {
                            $souscription->setSouscription_souscription($souscription_first);
				        } else {
                            $souscription->setSouscription_souscription($compteur_souscription);
					    }
            
                        $souscription->setSouscription_autonome($_POST['souscription_autonome']);
                        $souscription->setSouscription_ancien_membre($_POST['ancien_code_membre']);
			            $souscription->setPublier(3);
						$souscription->setErreur(0);
						$souscription->setId_canton($_POST['id_canton']);
                        $souscription_mapper->save($souscription);
						
						$html = "";
						
						$html .= "Nom : ".$_POST['souscription_nom']."<br />";
                        $html .= "Prenom : ".$_POST['souscription_prenom']."<br />";
						$html .= "E-mail : ".$_POST['souscription_email']."<br />";
                        $html .= "Mobile : ".$_POST['souscription_mobile']."<br />";
                        $html .= "Ville : ".$_POST['souscription_ville']."<br />";
                        $html .= "Quartier : ".$_POST['souscription_quartier']."<br />";
                        $html .= "Programme : ".$_POST['souscription_programme']."<br />";

                        $activiteM = new Application_Model_DbTable_EuActivite();
                        $activite = $activiteM->find($_POST['code_activite']);
		                $row = $activite->current();
                        $html .= "Biens, Produits et Services : ".$row->nom_activite."<br />";

                        $metierM = new Application_Model_DbTable_EuMetier();
                        $metier = $metierM->find($_POST['id_metier']);
		                $row = $metier->current();
                        $html .= "Métier : ".$row->libelle_metier."<br />";

                        $competenceM = new Application_Model_DbTable_EuCompetence();
                        $competence = $competenceM->find($_POST['id_competence']);
		                $row = $competence->current();
                        $html .= "Compétence : ".$row->libelle_competence."<br />";

                        $html .= "Date : ".$date_id->toString('yyyy-MM-dd HH:mm:ss')."<br />";
						
						$htmlpdf = "";
						$htmlpdf .='
                        <page backbottom="15mm">
                        <page_footer>
                        <table>
                        <tr>
                           <td align="center">
	                       <hr>
	                       Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425</td>
                        </tr>
                        </table>
                        </page_footer>

                        <table width="768" border="0">
                        <tbody>
                        <tr>
                        <td colspan="4"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
                        </tr>';
						
						$souscrip = new Application_Model_EuSouscription();
                        $souscrip_mapper = new Application_Model_EuSouscriptionMapper();
                        $compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, "");
		
	                    if($souscription->souscription_programme == "KACM") {
		                    if($compteur_souscrip == 0) {$compteur_souscrip = 1029;}	
		                        $unite = 0;	
                                $htmlpdf .= '
                                <tr>
                                    <td colspan="4" align="center"><strong><em><u>N° Reçu Personne Physique : PP'.ajoutezero($compteur_souscrip + 1).'</u></em></strong></td>
                                </tr>';
	                    }
						
						$souscription = new Application_Model_EuSouscription();
                        $souscriptionM = new Application_Model_EuSouscriptionMapper();
                        $souscriptionM->find($compteur_souscription, $souscription);
		
                        $souscription->setSouscription_ordre($compteur_souscrip + 1);
		                $souscriptionM->update($souscription);
						if($souscription->souscription_autonome == 1) {
						    $souscription_nombre = $souscription->souscription_nombre;
			                if($souscription->souscription_personne == "PP") {
				                $autonome = 0;
			                }
						}
						
						$souscription_nombre = $souscription->souscription_nombre;
			            if($souscription->souscription_personne == "PP") {
				           $autonome = 0;
			            }
						
						if($souscription->souscription_nombre > 0) {
	                        $htmlpdf .= '
                            <tr>
                                <td colspan="4" align="left"><em><u>Nombre de Comptes Marchands ré-activés: '.$souscription->souscription_nombre.'</u></em></td>
                            </tr>';
                        } else {
                            $htmlpdf .= '
                            <tr>
                                <td colspan="4" align="left">&nbsp;</td>
                            </tr>';
	                    }
        
                        $htmlpdf .= '
                            <tr>
                               <td colspan="2">&nbsp;</td>
                               <td colspan="2" align="center">&nbsp;</td>
                            </tr>';
                        $htmlpdf .= '
                        <tr>
                            <td colspan="2" align="left"><em><strong>Libellé</strong></em></td>
                            <td align="center"><em><strong>Nombre de compte ré-activé</strong></em></td>
                            <td align="center"><strong><em>Montant ré-activation</em></strong></td>
                        </tr>';
  
                        $htmlpdf .= '
                        <tr style="background-color:#999;">
                            <td colspan="2" align="left"><em><strong>Ré-activation de Comptes Marchands</strong></em></td>
                            <td align="center"><em>'.$souscription_nombre.'</em></td>
                            <td align="center"><em>'.$autonome.' FCFA</em></td>
                        </tr>';

                        $htmlpdf .= '
                        <tr>
                            <td colspan="2" align="left"><em><u>Montant total en  lettres&nbsp;</u>: '.lettre(($autonome), 50).' CFA</em></td>
                            <td colspan="2" rowspan="3" align="left"><img src="'.Util_Utils::getParamEsmc(2).'/images/cachet.jpg" /><br />
                            Date : '.datefr($date_id->toString('yyyy-MM-dd')).'</td>
                        </tr>';	
  
	                    if($souscription->souscription_programme == "KACM") {
                            $htmlpdf .= '
                            <tr>
                                <td colspan="2" align="left">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">&nbsp;</td>
                            </tr>';
		                }
  
  
                        $htmlpdf .= '
                        <tr>
                            <td colspan="4" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">';
	                        if($souscription->souscription_vignette != "" && (substr($souscription->souscription_vignette, 0, 3) == "jpg" || substr($souscription->souscription_vignette, 0, 3) == "jpeg" || substr($souscription->souscription_vignette, 0, 3) == "JPG" || substr($souscription->souscription_vignette, 0, 3) == "JPEG")){
                            list($width, $height, $type, $attr) = getimagesize(Util_Utils::getParamEsmc(2).$souscription->souscription_vignette);
	                        $pourcent = 700 * 100 / $width;
	                        $width2 = 700;
	                        $height2 = $pourcent * $height / 100;
                            $htmlpdf .= '<img src="'.Util_Utils::getParamEsmc(2).'/'.$souscription->souscription_vignette.'" width="'.$width2.'" height="'.$height2.'" />
                            ';
                            }
                        $htmlpdf .= '  </td>
	                    </tr>
  
                        </tbody>
                        </table>
                        <br />
                        <br />
                        &nbsp;
                        </page>';
                        $htmlpdf .= '';
						
						////////////////////////////////////////////////////////////////////////////////
                        $filename = ''.Util_Utils::getParamEsmc(1).'/souscriptions.html';
                        $somecontent = $htmlpdf;

                        // Assurons nous que le fichier est accessible en écriture
                        if (is_writable($filename)) {
                            // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
                            // Le pointeur de fichier est placé à la fin du fichier
                            // c'est là que $somecontent sera placé
                        if (!$handle = fopen($filename, 'w+')) {
                            echo "Impossible d'ouvrir le fichier ($filename)";
                            exit;
                        }

                        // Ecrivons quelque chose dans notre fichier.
                        if (fwrite($handle, $somecontent) === FALSE) {
                            echo "Impossible d'écrire dans le fichier ($filename)";
                            exit;
                        }
                            //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
                            fclose($handle);
                        } else {
                            echo "Le fichier $filename n'est pas accessible en écriture.";
                        }

                        ////////////////////////////////////////////////////////////////////////////	
                        $file = $filename;
                        if (!is_dir("../../webfiles/pdf_souscription/")) {
                            mkdir("../../webfiles/pdf_souscription/", 0777);
                        }
                        /*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

                        $newfile = "../../webfiles/pdf_souscription/SOUSCRIPTION_".str_replace("/", "_", mettreaccents($souscription->souscription_id))."_.html";
                        $newnom = "SOUSCRIPTION_".str_replace("/", "_", mettreaccents($souscription->souscription_id)."_");
                        $newchemin = "../../webfiles/pdf_souscription/";

                        copy($file, $newfile);

                        ob_start();
                        include(dirname(__FILE__).'/../'.$newfile);
                        $content = ob_get_clean();

                        // convert to PDF
                        require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
                        try {
                            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
                            $html2pdf->pdf->SetDisplayMode('fullpage');
                            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                            //$html2pdf->writeHTML($content);
                            $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
                        }
                        catch(HTML2PDF_exception $e) {
                            echo $e;
                            exit;
                        }
                        $file = $newchemin.$newnom.'.pdf';
                        $filena	= $newnom.'.pdf';
                        unlink($newfile);
						
						///////////////////////////////////////////////////////
						
						$esmc_email	 = Util_Utils::getParamEsmc(3);	
                        $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
                        Zend_Mail::setDefaultTransport($tr);		
                        $mail = new Zend_Mail();
                        $mail->setBodyHtml($html);
                        $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - SIF");
                        $mail->addTo($esmc_email, "ESMC - SIF");
                        $mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm:ss'));
                        $mail->send();
						
						if($_POST['souscription_email'] != "") {
                            $config = array('auth' => 'login','username' => Util_Utils::getParamEsmc(3),'password' => Util_Utils::getParamEsmc(4));
                            $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
                            Zend_Mail::setDefaultTransport($tr);		
                            $mail = new Zend_Mail();

                            $mail->setBodyHtml($html);
                            $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - SIF");
                            $mail->addTo($_POST['souscription_email'], $_POST['souscription_nom']." ".$_POST['souscription_prenom']);
                            $mail->setSubject('Ré-activation par souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
                            $mail->send($tr);

			            }
						
						// operation de transfert des codes kacm
				$date = new Zend_Date();
		        $compte_map = new Application_Model_EuCompteMapper();
                $compte      = new Application_Model_EuCompte();
			    $sms_money   = new Application_Model_EuSmsmoney();
                $money_map   = new Application_Model_EuSmsmoneyMapper();
			
			    $det_sms   = new Application_Model_EuDetailSmsmoney();
			    $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
			
			    $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			    $det_vtesms  = new Application_Model_EuDetailVentesms();
			
			    $mobile = $souscription->souscription_mobile;
			    //$nbre_compte = $souscription->souscription_nombre;
			    $fcaps = Util_Utils::getParametre('CAPS','valeur');
										
				$mont_fs = Util_Utils::getParametre('FS','valeur');
                $mont_fl = Util_Utils::getParametre('FL','valeur');
                $mont_kps = Util_Utils::getParametre('FKPS','valeur');
			
		        //$montant = $nbre_compte * $fcaps;
		        $membre_pbf = '0000000000000000001M';
	            $code_compte_pbf = "NN-TR-".$membre_pbf;
			    $ret = $compte_map->find($code_compte_pbf,$compte);
				if($souscription->souscription_programme == 'KACM') {
				     if($ret && ($compte->getSolde() >= ($mont_fs + $mont_fl + $mont_kps))) {
			             // Mise à jour du compte de transfert
				         $compte->setSolde($compte->getSolde() - ($mont_fs + $mont_fl + $mont_kps));
                         $compte_map->update($compte);    
	                  } else {
			             $db->rollback();				
			             $this->view->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
						 $this->view->ancien_code_membre = $_POST['ancien_code_membre'];
                         $this->view->nom_membre = $_POST['souscription_nom'];
                         $this->view->prenom_membre = $_POST['souscription_prenom'];
                         $this->view->ville_membre = $_POST['souscription_ville']; 
                         $this->view->quartier_membre = $_POST['souscription_quartier'];
                         $this->view->email = $_POST['souscription_email'];
                         $this->view->portable = $_POST['souscription_mobile'];
					     $this->_redirect('/association/reactivationsouscriptionmcnppp/id/'.$_POST['ancien_code_membre']);
                         return;			   
			          }
					  
					  $codefs   = '';
                      $codefl   = '';
                      $codefkps = '';
					  // Traitement des produits FS
				      // insertion dans la table eu_smsmoney
				      $lignesdetfs = $det_sms_m->findSMSByCompte($membre_pbf,'FS');
					  // Traitement des produits FL
                      // insertion dans la table eu_smsmoney
				      $lignesdetfl = $det_sms_m->findSMSByCompte($membre_pbf,'FL');
					  // Traitement des produits FCPS
				      $lignesdetfkps = $det_sms_m->findSMSByCompte($membre_pbf,'FCPS');
			          if ($lignesdetfs != null && $lignesdetfl !=  null && $lignesdetfkps != null) {						
							$codefs   = strtoupper(Util_Utils::genererCodeSMS(8));
					        $nengfs = $money_map->findConuter() + 1;
							$sms_money->setNEng($nengfs)
                	                  ->setCode_Agence(null)
                                      ->setCreditAmount($mont_fs)
                                      ->setSentTo($mobile)
                                      ->setMotif('FS')
                                      ->setId_Utilisateur(null)
                                      ->setCurrencyCode('XOF')
                                      ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                      ->setFromAccount($code_compte_pbf)
                                      ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                      ->setCreditCode($codefs)
                                      ->setDestAccount(null)
                                      ->setIDDatetimeConsumed(0)
                                      ->setDestAccount_Consumed(null)
                                      ->setDatetimeConsumed(null)
                                      ->setNum_recu(null);
                            $money_map->save($sms_money);                                   
														
							$i = 0;
					        $reste = $mont_fs;
					        $nbre_lignesdetfs = count($lignesdetfs);
				            while ($reste > 0 && $i < $nbre_lignesdetfs) {
					              $lignedetfs = $lignesdetfs[$i];
                                  $id = $lignedetfs->getId_detail_smsmoney();
						          $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						          if ($reste >= $lignedetfs->getSolde_sms()) {
						                 //Mise à jour  des lignes d'enrégistrement
					                     //insertion dans la table eu_detailventesms
						                 $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                         $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                            ->setId_detail_smsmoney($id)
                                                    ->setCode_membre_dist($membre_pbf)
                                                    ->setCode_membre(null)
                                                    ->setType_tansfert('FS')
                                                    ->setCreditcode($codefs)
                                                    ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                    ->setMont_vente($lignedetfs->getSolde_sms())
                                                    ->setId_utilisateur(null)
                                                    ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $reste = $reste - $lignedetfs->getSolde_sms();
							              $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $lignedetfs->getSolde_sms())
		                                             ->setMont_regle($lignedetfs->getMont_regle() + $lignedetfs->getSolde_sms())
		                                             ->setSolde_sms(0);
                                                                $det_sms_m->update($lignedetfs);			 							   
						            } else  {
							              //Mise à jour  des lignes d'enrégistrement
						                  //insertion dans la table eu_detailventesms
						                  $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                          $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                             ->setId_detail_smsmoney($id)
                                                     ->setCode_membre_dist($membre_pbf)
                                                     ->setCode_membre(null)
                                                     ->setType_tansfert('FS')
                                                     ->setCreditcode($codefs)
                                                     ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                     ->setMont_vente($reste)
                                                     ->setId_utilisateur(null)
                                                     ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $lignedetfs->setSolde_sms($lignedetfs->getSolde_sms() - $reste);
						                  $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $reste);
							              $lignedetfs->setMont_regle($lignedetfs->getMont_regle() + $reste);
                                          $det_sms_m->update($lignedetfs);
						                  $reste = 0;
						             }
						             $i++;
					              }
														
								  $codefl   = strtoupper(Util_Utils::genererCodeSMS(8));
				                  $nengfl = $money_map->findConuter() + 1;
                                  $sms_money->setNEng($nengfl)
                	                        ->setCode_Agence(null)
                                            ->setCreditAmount($mont_fl)
                                            ->setSentTo($mobile)
                                            ->setMotif('FL')
                                            ->setId_Utilisateur(null)
                                            ->setCurrencyCode('XOF')
                                            ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                            ->setFromAccount($code_compte_pbf)
                                            ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                            ->setCreditCode($codefl)
                                            ->setDestAccount(null)
                                            ->setIDDatetimeConsumed(0)
                                            ->setDestAccount_Consumed(null)
                                            ->setDatetimeConsumed(null)
                                            ->setNum_recu(null);
                                  $money_map->save($sms_money);
					                                    
								  $j = 0;
					              $reste = $mont_fl;
					              $nbre_lignesdetfl = count($lignesdetfl);
					              while ($reste > 0 && $j < $nbre_lignesdetfl) {
					                    $lignedetfl = $lignesdetfl[$j];
                                        $id = $lignedetfl->getId_detail_smsmoney();
						                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                if ($reste >= $lignedetfl->getSolde_sms()) {
						                   //Mise à jour  des lignes d'enrégistrement
                                           $reste = $reste - $lignedetfl->getSolde_sms();
									       //insertion dans la table eu_detailventesms
						                   $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                           $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                              ->setId_detail_smsmoney($id)
                                                      ->setCode_membre_dist($membre_pbf)
                                                      ->setCode_membre(null)
                                                      ->setType_tansfert('FL')
                                                      ->setCreditcode($codefl)
                                                      ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                      ->setMont_vente($lignedetfl->getSolde_sms())
                                                      ->setId_utilisateur(null)
                                                      ->setCode_produit('FL');
                                            $det_vte_sms->insert($det_vtesms->toArray());
							                $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $lignedetfl->getSolde_sms())
		                                               ->setMont_regle($lignedetfl->getMont_regle() + $lignedetfl->getSolde_sms())
		                                               ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfl);			 							   
						                  } else  {
							                 //Mise à jour  des lignes d'enrégistrement
											//insertion dans la table eu_detailventesms
						                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                               ->setId_detail_smsmoney($id)
                                                       ->setCode_membre_dist($membre_pbf)
                                                       ->setCode_membre(null)
                                                       ->setType_tansfert('FL')
                                                       ->setCreditcode($codefl)
                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                       ->setMont_vente($reste)
                                                       ->setId_utilisateur(null)
                                                       ->setCode_produit('FL');
                                              $det_vte_sms->insert($det_vtesms->toArray());
                                              $lignedetfl->setSolde_sms($lignedetfl->getSolde_sms() - $reste);
						                      $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $reste);
							                  $lignedetfl->setMont_regle($lignedetfl->getMont_regle() + $reste);
                                              $det_sms_m->update($lignedetfl);
						                      $reste = 0;
						                   }
						                                $j++;
					                   }
													
													$codefkps = strtoupper(Util_Utils::genererCodeSMS(8));
				                                    $nengfkps = $money_map->findConuter() + 1;
                                                    $sms_money->setNEng($nengfkps)
                	                                          ->setCode_Agence(null)
                                                              ->setCreditAmount($mont_kps)
                                                              ->setSentTo($mobile)
                                                              ->setMotif('FCPS')
                                                              ->setId_Utilisateur(null)
                                                              ->setCurrencyCode('XOF')
                                                              ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                              ->setFromAccount($code_compte_pbf)
                                                              ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                              ->setCreditCode($codefkps)
                                                              ->setDestAccount(null)
                                                              ->setIDDatetimeConsumed(0)
                                                              ->setDestAccount_Consumed(null)
                                                              ->setDatetimeConsumed(null)
                                                              ->setNum_recu(null);
                                                    $money_map->save($sms_money);
													
													$k = 0;
					                                $reste = $mont_kps;
					                                $nbre_lignesdetfkps = count($lignesdetfkps);
					                                while ($reste > 0 && $k < $nbre_lignesdetfkps) {
					                                    $lignedetfkps = $lignesdetfkps[$k];
                                                        $id = $lignedetfkps->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfkps->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($lignedetfkps->getSolde_sms())
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $reste = $reste - $lignedetfkps->getSolde_sms();
							                                $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $lignedetfkps->getSolde_sms())
		                                                                 ->setMont_regle($lignedetfkps->getMont_regle() + $lignedetfkps->getSolde_sms())
		                                                                 ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfkps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfkps->setSolde_sms($lignedetfkps->getSolde_sms() - $reste);
						                                    $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $reste);
							                                $lignedetfkps->setMont_regle($lignedetfkps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfkps);
						                                    $reste = 0;
						                                }
						                                $k++;
					                                }
													
													// insertion dans la table eu_code_activation
				                                    $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				                                    $codeactivation = new Application_Model_EuCodeActivation();
			                                        $countcode = $m_codeactivation->findConuter() + 1;
				
				                                    $codeactivation->setId_code_activation($countcode)
					                                              ->setDate_generer($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                                    $codeactivation->setCode_membre(null);   
			                                        $codeactivation->setCode_fs($codefs);
				                                    $codeactivation->setCode_fl($codefl);
				                                    $codeactivation->setCode_fkps($codefkps);
				                                    $codeactivation->setSouscription_id($souscription->souscription_id);
				                                    $m_codeactivation->save($codeactivation);
				
				                                    $compteur = Util_Utils::findConuter() + 1;
				                                    Util_Utils::addSms($compteur,$mobile,'Voici vos codes d\'activation de compte marchand : '.' CODE FS : '.$codefs.' CODE FL : '.$codefl.' CODE FCPS : '.$codefkps);
												
										            }  else {
												        $db->rollback();
	                                                    $this->view->error = 'Erreur de traitement : le solde est null';
						                                $this->view->ancien_code_membre = $_POST['ancien_code_membre'];
                                                        $this->view->nom_membre = $_POST['souscription_nom'];
                                                        $this->view->prenom_membre = $_POST['souscription_prenom'];
                                                        $this->view->ville_membre = $_POST['souscription_ville']; 
                                                        $this->view->quartier_membre = $_POST['souscription_quartier'];
                                                        $this->view->email = $_POST['souscription_email'];
                                                        $this->view->portable = $_POST['souscription_mobile'];
					                                    $this->_redirect('/association/reactivationsouscriptionmcnppp/id/'.$_POST['ancien_code_membre']);	
												    }	
				}
						
		                $db->commit();
		                $sessionmembreasso->errorlogin = "Demande de Quittance de Ré-activation bien effectuée";
		                $this->_redirect('/association/ancienppmcnp');
						
		            } catch (Exception $exc) {
				        $db->rollback();
				        $this->view->error = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				        return;
			        } 	
					
		        } else {  
			        $this->view->error = "Champs * obligatoire ...";  
			    }
		} else {
            $id = (string)$this->_request->getParam('id');
            $tabela = new Application_Model_DbTable_EuAncienMembre();
            $select = $tabela->select();
            $select->from($tabela,array('eu_ancien_membre.*',"date_nais_membre as datenaismembre"))
                   ->where('ancien_code_membre like ?', '%'.$id.'%')
                   ->where('(etat_contrat = 0')->orwhere('etat_contrat IS NULL)');       
            $memb = $tabela->fetchAll($select);
            $trouvmembre = $memb->current();
            $this->view->ancien_code_membre = $trouvmembre->ancien_code_membre;
            $this->view->nom_membre = $trouvmembre->nom_membre;
            $this->view->prenom_membre = $trouvmembre->prenom_membre;
            //$this->view->sexe = $trouvmembre->sexe_membre;
            //$this->view->profession = $trouvmembre->profession_membre;
            //$this->view->tel = $trouvmembre->tel_membre;
            $this->view->ville_membre = $trouvmembre->ville_membre; 
            //$this->view->pere = $trouvmembre->pere_membre;
            //$this->view->mere = $trouvmembre->mere_membre;
            $this->view->quartier_membre = $trouvmembre->quartier_membre;
            //$this->view->bp = $trouvmembre->bp_membre;
            //$this->view->nbre_enf = $trouvmembre->nbr_enf_membre;
            $this->view->email = $trouvmembre->email_membre;
            $this->view->portable = $trouvmembre->portable_membre;
            //$this->view->formation = $trouvmembre->formation;
            //$this->view->lieu_nais = $trouvmembre->lieu_nais_membre;
            //$this->view->datnais = $trouvmembre->datenaismembre;
            //$this->view->sitfam = $trouvmembre->sitfam_membre;
            //$this->view->nation = $trouvmembre->id_pays;
            //$this->view->religion = $trouvmembre->id_religion_membre;
        }
    
    }






    public function ancienpmmcnpAction() {
        /* page association/ancienpmmcnp - Retrouve ancienne personne morale MCNP */
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    
        if (isset($_POST['ok']) && $_POST['ok']=="ok") {
            if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
                $tabela = new Application_Model_DbTable_EuAncienMembre();
                $select = $tabela->select();
                $select->from($tabela,array('eu_ancien_membre.*',"date_identification as dateidentif"))
                       ->where('ancien_code_membre LIKE ?', '%'.$_POST['code_membre'].'%')
                       ->where('(etat_contrat = 0')->orwhere('etat_contrat IS NULL)');        
                $memb = $tabela->fetchAll($select);
                if(count($memb) > 0) {
                    $trouvmembre = $memb->current();
                    $table  = new Application_Model_DbTable_EuSouscription();
				    $selection = $table->select();
                    $selection->from($table)
                              ->where('souscription_ancien_membre like ?',$_POST['code_membre']);
					$sous = $table->fetchAll($selection);
                    if(count($sous) == 0) {      
                       $this->_redirect('/association/reactivationsouscriptionmcnppm/id/'.$trouvmembre->ancien_code_membre);
					} else {
                       $this->view->message = "Quittance de Réactivation déjà effectuée ...";
                    }   
                } else {  $this->view->message = "Pas de resultat ... Déjà Activé";}
                } else {  $this->view->message = "Champs * obligatoire ...";}
       
        } 
    }


  

    public function reactivationsouscriptionmcnppmAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

	    if (isset($_POST['ok']) && $_POST['ok']=="ok")  {
	        if (isset($_POST['ancien_code_membre']) && $_POST['ancien_code_membre']!="" 
			    && isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="" 
				&& isset($_POST['souscription_autonome']) && $_POST['souscription_autonome']!="" 
				&& isset($_POST['souscription_mobile']) && $_POST['souscription_mobile']!="" 
				&& isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="" 
				&& isset($_POST['code_activite']) && $_POST['code_activite']!="" 
				&& isset($_POST['souscription_raison']) && $_POST['souscription_raison']!="" 
				&& isset($_POST['type_acteur']) && $_POST['type_acteur']!="" 
				&& isset($_POST['statut_juridique']) && $_POST['statut_juridique']!=""
				&& isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!="" && verif_img($_FILES['souscription_vignette']['name']) == 1 
				)  {  
	            $db = Zend_Db_Table::getDefaultAdapter();
				$db->beginTransaction();
				try {
				    $eusouscription = new Application_Model_DbTable_EuSouscription();
	                $select = $eusouscription->select();
					$select->where("LOWER(REPLACE(souscription_raison, ' ', '')) = ? ", strtolower(str_replace(" ", "", $_POST['souscription_raison'])));  
                    $select->order(array("souscription_id ASC"));
	                $select->limit(1);
	                $rowseusouscription = $eusouscription->fetchRow($select);
		            if(count($rowseusouscription) > 0) {
			          $souscription_ok = 1;
			          $souscription_first = $rowseusouscription->souscription_id;
			        } else {
			          $souscription_ok = 0;
			        }
					
					$date_id = Zend_Date::now();
                    $souscription = new Application_Model_EuSouscription();
                    $souscription_mapper = new Application_Model_EuSouscriptionMapper();
		            include("Transfert.php");
					
					if(isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!="") {
		              $chemin	= "souscriptions";
		              $file = $_FILES['souscription_vignette']['name'];
		              $file1 = 'souscription_vignette';
		              $souscription_vignette = $chemin."/".transfert($chemin,$file1);
		            } else {
					  $souscription_vignette = "";
					}
					$compteur_souscription = $souscription_mapper->findConuter() + 1;
                    $souscription->setSouscription_id($compteur_souscription);
                    $souscription->setSouscription_personne($_POST['souscription_personne']);
					
					$souscription->setSouscription_raison($_POST['souscription_raison']);
                    $souscription->setCode_type_acteur($_POST["type_acteur"]);
                    $souscription->setCode_statut($_POST["statut_juridique"]);
					
					$souscription->setSouscription_email($_POST['souscription_email']);
                    $souscription->setSouscription_mobile($_POST['souscription_mobile']);
                    $souscription->setSouscription_membreasso($sessionmembreasso->membreasso_id);
					
					$tafl = new Application_Model_DbTable_EuAncienFl();
                    $afl = new Application_Model_EuAncienFl();
                    $code_fl = 'FL-'.$_POST['ancien_code_membre'];
                    $result = $tafl->find($code_fl);
					
					if(count($result) == 0)  {
                        $souscription->setSouscription_type($_POST['souscription_type']);
                        $souscription->setSouscription_numero($_POST['souscription_numero']);
                        $souscription->setSouscription_date_numero($_POST['souscription_date_numero']);
			            if($_POST['souscription_type'] == "Banque") {
                            $souscription->setSouscription_banque($_POST['souscription_banque']);
			            }
                        $souscription->setSouscription_montant($_POST['souscription_montant']);
                        $souscription->setSouscription_nombre($_POST['souscription_nombre']);
						$souscription->setPublier(0);
				    } else {
					    $souscription->setPublier(3);
					}
					$souscription->setSouscription_programme($_POST['souscription_programme']);
					$souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                    $souscription->setSouscription_vignette($souscription_vignette);
                    $souscription->setCode_activite($_POST["code_activite"]);
                    $souscription->setId_metier($_POST["id_metier"]);
                    $souscription->setId_competence($_POST["id_competence"]);
                    $souscription->setSouscription_ville($_POST['souscription_ville']);
                    $souscription->setSouscription_quartier($_POST['souscription_quartier']);
					
					if($souscription_ok == 1) {
                      $souscription->setSouscription_souscription($souscription_first);
				    } else {
                      $souscription->setSouscription_souscription($compteur_souscription);
				    }
            
                    $souscription->setSouscription_autonome($_POST['souscription_autonome']);
                    $souscription->setSouscription_ancien_membre($_POST['ancien_code_membre']);
					$souscription->setId_canton($_POST['id_canton']);
					$souscription->setErreur(0);
                    $souscription_mapper->save($souscription);
					
					$html = "";
                    $html .= "Raison sociale : ".$_POST['souscription_raison']."<br/>";
                    if($_POST["type_acteur"] == 'EI')   {$html .= "Type Association : Entreprise Industrie<br/>";}
                    if($_POST["type_acteur"] == 'OE')   {$html .= "Type Association : Opérateur Economique<br/>";}
                    if($_POST["type_acteur"] == 'OSE')  {$html .= "Type Association : Opérateur Socio-Economique<br/>";}
                    if($_POST["type_acteur"] == 'PEI')  {$html .= "Type Association : Partenaire Entreprise Industrie<br/>";}
                    if($_POST["type_acteur"] == 'POE')  {$html .= "Type Association : Partenaire Opérateur Economique<br/>";}
                    if($_POST["type_acteur"] == 'POSE') {$html .= "Type Association : Partenaire Opérateur Socio-Economique<br/>";}
					
					$statutjuridique = new Application_Model_EuStatutJuridique();
                    $statutjuridiqueM = new Application_Model_EuStatutJuridiqueMapper();
                    $statutjuridiqueM->find($_POST["statut_juridique"], $statutjuridique);
                    $html .= "Statut juridique : ".$statutjuridique->libelle_statut."<br />";
			
                    $html .= "E-mail : ".$_POST['souscription_email']."<br/>";
                    $html .= "Mobile : ".$_POST['souscription_mobile']."<br/>";
                    $html .= "Ville : ".$_POST['souscription_ville']."<br/>";
                    $html .= "Quartier : ".$_POST['souscription_quartier']."<br/>";
                    $html .= "Programme : ".$_POST['souscription_programme']."<br/>";
					
                        $activiteM = new Application_Model_DbTable_EuActivite();
                        $activite = $activiteM->find($_POST['code_activite']);
		                $row = $activite->current();
                        $html .= "Biens, Produits et Services : ".$row->nom_activite."<br />";

                        $metierM = new Application_Model_DbTable_EuMetier();
                        $metier = $metierM->find($_POST['id_metier']);
		                $row = $metier->current();
                        $html .= "Métier : ".$row->libelle_metier."<br />";

                        $competenceM = new Application_Model_DbTable_EuCompetence();
                        $competence = $competenceM->find($_POST['id_competence']);
		                $row = $competence->current();
                        $html .= "Compétence : ".$row->libelle_competence."<br />";

					
					$tafl = new Application_Model_DbTable_EuAncienFl();
                    $afl = new Application_Model_EuAncienFl();
                    $code_fl = 'FL-'.$_POST['ancien_code_membre'];
                    $result = $tafl->find($code_fl);
					
					if(count($result) == 0) {
                        $html .= "Type : ".$_POST['souscription_type']."<br/>";
			            if($_POST['souscription_type'] == "Banque") {
                            $banque = new Application_Model_EuBanque();
                            $banqueM = new Application_Model_EuBanqueMapper();
                            $banqueM->find($_POST['souscription_banque'], $banque);
                            $html .= "Banque : ".$banque->libelle_banque."<br/>";
			            }

                        $html .= "Numero Reçu Banque ou Numéro Transaction Flooz: ".$_POST['souscription_numero']."<br/>";
                        $html .= "Date Reçu Banque ou Transaction Flooz: ".$_POST['souscription_date_numero']."<br/>";
                        $html .= "Montant : ".$_POST['souscription_montant']."<br/>";
                        $html .= "Nombre : ".$_POST['souscription_nombre']."<br/>";
						
						///////////////////////////////////////////////////////////////////////////////////////
							
						$recubancaire = new Application_Model_EuRecubancaire();
                        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
		
                        $compteur_recubancaire = $recubancaire_mapper->findConuter() + 1;
                        $recubancaire->setRecubancaire_id($compteur_recubancaire);
                        $recubancaire->setRecubancaire_type($request->getParam("souscription_type"));
                        $recubancaire->setRecubancaire_numero($request->getParam("souscription_numero"));
                        $recubancaire->setRecubancaire_date_numero($request->getParam("souscription_date_numero"));
			            if($_POST['souscription_type'] == "Banque") {
                                $recubancaire->setRecubancaire_banque($request->getParam("souscription_banque"));
			            }
                        $recubancaire->setRecubancaire_montant($request->getParam("souscription_montant"));
                        $recubancaire->setRecubancaire_vignette($souscription_vignette);
                        $recubancaire->setRecubancaire_souscription($compteur_souscription);
			            $recubancaire->setPublier(1);
                        $recubancaire_mapper->save($recubancaire);
						
						$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
		                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate($request->getParam("souscription_banque"),$request->getParam("souscription_numero"),$request->getParam("souscription_date_numero"));
                        if(count($relevebancairedetail) > 0) { 
                              if($relevebancairedetail->relevebancairedetail_montant >= $_POST['souscription_montant']) {
							      include("automatisation.php");
								  validation_automatique($compteur_souscription);
								  // operation de transfert
								   $souscription = new Application_Model_EuSouscription();
		                           $souscriptionM = new Application_Model_EuSouscriptionMapper();
                                   $souscriptionM->find($compteur_souscription, $souscription);
								   $date = new Zend_Date();
		                           $compte_map = new Application_Model_EuCompteMapper();
                                   $compte      = new Application_Model_EuCompte();
			                       $sms_money   = new Application_Model_EuSmsmoney();
                                   $money_map   = new Application_Model_EuSmsmoneyMapper();
			
			                       $det_sms   = new Application_Model_EuDetailSmsmoney();
			                       $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
			
			                       $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			                       $det_vtesms  = new Application_Model_EuDetailVentesms();
			
			                       $mobile = $souscription->souscription_mobile;
			                       //$nbre_compte = $souscription->souscription_nombre;
			                       $fcaps = Util_Utils::getParametre('CAPS','valeur');
										
								   $mont_fs = Util_Utils::getParametre('FS','valeur');
                                   $mont_fl = Util_Utils::getParametre('FL','valeur');
                                   $mont_kps = Util_Utils::getParametre('FKPS','valeur');
			
		                           //$montant = $nbre_compte * $fcaps;
		                           $membre_pbf = '0000000000000000001M';
	                               $code_compte_pbf = "NN-TR-".$membre_pbf;
			                       $ret = $compte_map->find($code_compte_pbf,$compte);
								   
								   if($souscription->souscription_programme == 'KACM') {
				     if($ret && ($compte->getSolde() >= ($mont_fs + $mont_fl + $mont_kps))) {
			             // Mise à jour du compte de transfert
				         $compte->setSolde($compte->getSolde() - ($mont_fs + $mont_fl + $mont_kps));
                         $compte_map->update($compte);    
	                  } else {
			             $db->rollback();				
			             $this->view->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
						 $this->view->ancien_code_membre = $_POST['ancien_code_membre'];
                         $this->view->raison = $_POST['souscription_raison'];
                         $this->view->ville_membre = $_POST['souscription_ville']; 
                         $this->view->quartier_membre = $_POST['souscription_quartier'];
                         $this->view->email = $_POST['souscription_email'];
                         $this->view->portable = $_POST['souscription_mobile'];
						 $this->view->statut_juridique = $_POST['statut_juridique'];
                         $this->view->type_acteur = $_POST['type_acteur'];
					     $this->_redirect('/association/reactivationsouscriptionmcnppm/id/'.$_POST['ancien_code_membre']);
                         return;			   
			          }
					  
					  $codefs   = '';
                      $codefl   = '';
                      $codefkps = '';
					  // Traitement des produits FS
				      // insertion dans la table eu_smsmoney
				      $lignesdetfs = $det_sms_m->findSMSByCompte($membre_pbf,'FS');
					  // Traitement des produits FL
                      // insertion dans la table eu_smsmoney
				      $lignesdetfl = $det_sms_m->findSMSByCompte($membre_pbf,'FL');
					  // Traitement des produits FCPS
				      $lignesdetfkps = $det_sms_m->findSMSByCompte($membre_pbf,'FCPS');
			          if ($lignesdetfs != null && $lignesdetfl !=  null && $lignesdetfkps != null) {						
							$codefs   = strtoupper(Util_Utils::genererCodeSMS(8));
					        $nengfs = $money_map->findConuter() + 1;
							$sms_money->setNEng($nengfs)
                	                  ->setCode_Agence(null)
                                      ->setCreditAmount($mont_fs)
                                      ->setSentTo($mobile)
                                      ->setMotif('FS')
                                      ->setId_Utilisateur(null)
                                      ->setCurrencyCode('XOF')
                                      ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                      ->setFromAccount($code_compte_pbf)
                                      ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                      ->setCreditCode($codefs)
                                      ->setDestAccount(null)
                                      ->setIDDatetimeConsumed(0)
                                      ->setDestAccount_Consumed(null)
                                      ->setDatetimeConsumed(null)
                                      ->setNum_recu(null);
                            $money_map->save($sms_money);                                   
														
							$i = 0;
					        $reste = $mont_fs;
					        $nbre_lignesdetfs = count($lignesdetfs);
				            while ($reste > 0 && $i < $nbre_lignesdetfs) {
					              $lignedetfs = $lignesdetfs[$i];
                                  $id = $lignedetfs->getId_detail_smsmoney();
						          $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						          if ($reste >= $lignedetfs->getSolde_sms()) {
						                 //Mise à jour  des lignes d'enrégistrement
					                     //insertion dans la table eu_detailventesms
						                 $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                         $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                            ->setId_detail_smsmoney($id)
                                                    ->setCode_membre_dist($membre_pbf)
                                                    ->setCode_membre(null)
                                                    ->setType_tansfert('FS')
                                                    ->setCreditcode($codefs)
                                                    ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                    ->setMont_vente($lignedetfs->getSolde_sms())
                                                    ->setId_utilisateur(null)
                                                    ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $reste = $reste - $lignedetfs->getSolde_sms();
							              $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $lignedetfs->getSolde_sms())
		                                             ->setMont_regle($lignedetfs->getMont_regle() + $lignedetfs->getSolde_sms())
		                                             ->setSolde_sms(0);
                                                                $det_sms_m->update($lignedetfs);			 							   
						            } else  {
							              //Mise à jour  des lignes d'enrégistrement
						                  //insertion dans la table eu_detailventesms
						                  $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                          $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                             ->setId_detail_smsmoney($id)
                                                     ->setCode_membre_dist($membre_pbf)
                                                     ->setCode_membre(null)
                                                     ->setType_tansfert('FS')
                                                     ->setCreditcode($codefs)
                                                     ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                     ->setMont_vente($reste)
                                                     ->setId_utilisateur(null)
                                                     ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $lignedetfs->setSolde_sms($lignedetfs->getSolde_sms() - $reste);
						                  $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $reste);
							              $lignedetfs->setMont_regle($lignedetfs->getMont_regle() + $reste);
                                          $det_sms_m->update($lignedetfs);
						                  $reste = 0;
						             }
						             $i++;
					              }
														
								  $codefl   = strtoupper(Util_Utils::genererCodeSMS(8));
				                  $nengfl = $money_map->findConuter() + 1;
                                  $sms_money->setNEng($nengfl)
                	                        ->setCode_Agence(null)
                                            ->setCreditAmount($mont_fl)
                                            ->setSentTo($mobile)
                                            ->setMotif('FL')
                                            ->setId_Utilisateur(null)
                                            ->setCurrencyCode('XOF')
                                            ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                            ->setFromAccount($code_compte_pbf)
                                            ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                            ->setCreditCode($codefl)
                                            ->setDestAccount(null)
                                            ->setIDDatetimeConsumed(0)
                                            ->setDestAccount_Consumed(null)
                                            ->setDatetimeConsumed(null)
                                            ->setNum_recu(null);
                                  $money_map->save($sms_money);
					                                    
								  $j = 0;
					              $reste = $mont_fl;
					              $nbre_lignesdetfl = count($lignesdetfl);
					              while ($reste > 0 && $j < $nbre_lignesdetfl) {
					                    $lignedetfl = $lignesdetfl[$j];
                                        $id = $lignedetfl->getId_detail_smsmoney();
						                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                if ($reste >= $lignedetfl->getSolde_sms()) {
						                   //Mise à jour  des lignes d'enrégistrement
                                           $reste = $reste - $lignedetfl->getSolde_sms();
									       //insertion dans la table eu_detailventesms
						                   $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                           $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                              ->setId_detail_smsmoney($id)
                                                      ->setCode_membre_dist($membre_pbf)
                                                      ->setCode_membre(null)
                                                      ->setType_tansfert('FL')
                                                      ->setCreditcode($codefl)
                                                      ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                      ->setMont_vente($lignedetfl->getSolde_sms())
                                                      ->setId_utilisateur(null)
                                                      ->setCode_produit('FL');
                                            $det_vte_sms->insert($det_vtesms->toArray());
							                $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $lignedetfl->getSolde_sms())
		                                               ->setMont_regle($lignedetfl->getMont_regle() + $lignedetfl->getSolde_sms())
		                                               ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfl);			 							   
						                  } else  {
							                 //Mise à jour  des lignes d'enrégistrement
											//insertion dans la table eu_detailventesms
						                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                               ->setId_detail_smsmoney($id)
                                                       ->setCode_membre_dist($membre_pbf)
                                                       ->setCode_membre(null)
                                                       ->setType_tansfert('FL')
                                                       ->setCreditcode($codefl)
                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                       ->setMont_vente($reste)
                                                       ->setId_utilisateur(null)
                                                       ->setCode_produit('FL');
                                              $det_vte_sms->insert($det_vtesms->toArray());
                                              $lignedetfl->setSolde_sms($lignedetfl->getSolde_sms() - $reste);
						                      $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $reste);
							                  $lignedetfl->setMont_regle($lignedetfl->getMont_regle() + $reste);
                                              $det_sms_m->update($lignedetfl);
						                      $reste = 0;
						                   }
						                                $j++;
					                   }
													
													$codefkps = strtoupper(Util_Utils::genererCodeSMS(8));
				                                    $nengfkps = $money_map->findConuter() + 1;
                                                    $sms_money->setNEng($nengfkps)
                	                                          ->setCode_Agence(null)
                                                              ->setCreditAmount($mont_kps)
                                                              ->setSentTo($mobile)
                                                              ->setMotif('FCPS')
                                                              ->setId_Utilisateur(null)
                                                              ->setCurrencyCode('XOF')
                                                              ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                              ->setFromAccount($code_compte_pbf)
                                                              ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                              ->setCreditCode($codefkps)
                                                              ->setDestAccount(null)
                                                              ->setIDDatetimeConsumed(0)
                                                              ->setDestAccount_Consumed(null)
                                                              ->setDatetimeConsumed(null)
                                                              ->setNum_recu(null);
                                                    $money_map->save($sms_money);
													
													$k = 0;
					                                $reste = $mont_kps;
					                                $nbre_lignesdetfkps = count($lignesdetfkps);
					                                while ($reste > 0 && $k < $nbre_lignesdetfkps) {
					                                    $lignedetfkps = $lignesdetfkps[$k];
                                                        $id = $lignedetfkps->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfkps->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($lignedetfkps->getSolde_sms())
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $reste = $reste - $lignedetfkps->getSolde_sms();
							                                $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $lignedetfkps->getSolde_sms())
		                                                                 ->setMont_regle($lignedetfkps->getMont_regle() + $lignedetfkps->getSolde_sms())
		                                                                 ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfkps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfkps->setSolde_sms($lignedetfkps->getSolde_sms() - $reste);
						                                    $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $reste);
							                                $lignedetfkps->setMont_regle($lignedetfkps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfkps);
						                                    $reste = 0;
						                                }
						                                $k++;
					                                }
													
													// insertion dans la table eu_code_activation
				                                    $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				                                    $codeactivation = new Application_Model_EuCodeActivation();
			                                        $countcode = $m_codeactivation->findConuter() + 1;
				
				                                    $codeactivation->setId_code_activation($countcode)
					                                              ->setDate_generer($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                                    $codeactivation->setCode_membre(null);   
			                                        $codeactivation->setCode_fs($codefs);
				                                    $codeactivation->setCode_fl($codefl);
				                                    $codeactivation->setCode_fkps($codefkps);
				                                    $codeactivation->setSouscription_id($souscription->souscription_id);
				                                    $m_codeactivation->save($codeactivation);
				
				                                    $compteur = Util_Utils::findConuter() + 1;
				                                    Util_Utils::addSms($compteur,$mobile,'Voici vos codes d\'activation de compte marchand : '.' CODE FS : '.$codefs.' CODE FL : '.$codefl.' CODE FCPS : '.$codefkps);
												
										            }  else {
												        $db->rollback();
	                                                    $this->view->error = 'Erreur de traitement : le solde est null';
						                                $this->view->ancien_code_membre = $_POST['ancien_code_membre'];
                                                        $this->view->raison = $_POST['souscription_raison'];
                                                        $this->view->ville_membre = $_POST['souscription_ville']; 
                                                        $this->view->quartier_membre = $_POST['souscription_quartier'];
                                                        $this->view->email = $_POST['souscription_email'];
                                                        $this->view->portable = $_POST['souscription_mobile'];
														$this->view->statut_juridique = $_POST['statut_juridique'];
                                                        $this->view->type_acteur = $_POST['type_acteur'];
					                                    $this->_redirect('/association/reactivationsouscriptionmcnppm/id/'.$_POST['ancien_code_membre']);	
												    }	
				                             }
						      } else {
							       $db->commit();
                                   $sessionmembreasso->errorlogin = "Demande de Quittance de Ré-activation bien effectuée, mais le montant est insuffisant. Veuillez compléter le montant par un autre dépôt à la banque.";
		                           $this->_redirect('/association/ancienpmmcnp');
							  
							  }
						
						} else {
						      $db->commit();
                              $sessionmembreasso->errorlogin = "Demande de Quittance de Ré-activation bien effectuée. Votre demande n’est pas encore vérifiée, revenez plus tard.";
		                      $this->_redirect('/association/ancienpmmcnp');
						}	
						
				    }
					else {
					    $htmlpdf = "";
                        $htmlpdf .='
                        <page backbottom="15mm">
                        <page_footer>
                        <table>
                        <tr>
                           <td align="center">
	                       <hr>
	                       Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425</td>
                        </tr>
                        </table>
                        </page_footer>

                        <table width="768" border="0">
                        <tbody>
                        <tr>
                           <td colspan="4"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
                        </tr>';
						
						$souscrip = new Application_Model_EuSouscription();
                        $souscrip_mapper = new Application_Model_EuSouscriptionMapper();
                        $compteur_souscrip = $souscrip_mapper->findConuterOrdre($souscription->souscription_personne, $souscription->souscription_programme, $souscription->code_type_acteur);
		
		                if($compteur_souscrip == 0 && $souscription->code_type_acteur == "OSE"){$compteur_souscrip = 4;}		
		                if($compteur_souscrip == 0 && $souscription->code_type_acteur == "OE"){$compteur_souscrip = 5;}		
		                $unite = 0;	
                        $htmlpdf .= '
                        <tr>
                            <td colspan="4" align="center"><strong><em><u>N° Reçu '.$souscription->code_type_acteur.' : '.$souscription->code_type_acteur.''.ajoutezero($compteur_souscrip + 1).'</u></em></strong></td>
                        </tr>';
						$souscription = new Application_Model_EuSouscription();
                        $souscriptionM = new Application_Model_EuSouscriptionMapper();
                        $souscriptionM->find($compteur_souscription, $souscription);
                        $souscription->setSouscription_ordre($compteur_souscrip + 1);
		                $souscriptionM->update($souscription);
						$autonome = 0;
						
						$htmlpdf .= '
                        <tr>
                            <td colspan="4" align="left"><p><em><u>Raison sociale de l&rsquo;acheteur&nbsp;</u>: </em><strong><em>'.$souscription->souscription_raison.'</em></strong></p></td>
                        </tr>';
						
						if($souscription->souscription_nombre > 0) {
	                        $htmlpdf .= '
                            <tr>
                                <td colspan="4" align="left"><em><u>Nombre de Comptes Marchands ré-activés: '.$souscription->souscription_nombre.'</u></em></td>
                            </tr>';
                        } else {
                            $htmlpdf .= '
                            <tr>
                                <td colspan="4" align="left">&nbsp;</td>
                            </tr>';
	                    }
						
						$htmlpdf .= '
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td colspan="2" align="center">&nbsp;</td>
                        </tr>';
                        $htmlpdf .= '
                        <tr>
                            <td colspan="2" align="left"><em><strong>Libellé</strong></em></td>
                            <td align="center"><em><strong>Nombre de compte ré-activé</strong></em></td>
                            <td align="center"><strong><em>Montant ré-activation</em></strong></td>
                        </tr>';
  
                        $htmlpdf .= '
                        <tr style="background-color:#999;">
                            <td colspan="2" align="left"><em><strong>Ré-activation de Comptes Marchands</strong></em></td>
                            <td align="center"><em>'.$souscription_nombre.'</em></td>
                            <td align="center"><em>'.$autonome.' FCFA</em></td>
                        </tr>';

                        $htmlpdf .= '
                        <tr>
                            <td colspan="2" align="left"><em><u>Montant total en  lettres&nbsp;</u>: '.lettre(($autonome), 50).' CFA</em></td>
                            <td colspan="2" rowspan="3" align="left"><img src="'.Util_Utils::getParamEsmc(2).'/images/cachet.jpg" /><br />
                            Date : '.datefr($date_id->toString('yyyy-MM-dd')).'</td>
                        </tr>';	
  
	                    if($souscription->souscription_programme == "KACM") {
                            $htmlpdf .= '
                            <tr>
                                <td colspan="2" align="left">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">&nbsp;</td>
                            </tr>';
		                }
						
						$htmlpdf .= '
                        <tr>
                            <td colspan="4" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">';
	                        if($souscription->souscription_vignette != "" && (substr($souscription->souscription_vignette, 0, 3) == "jpg" || substr($souscription->souscription_vignette, 0, 3) == "jpeg" || substr($souscription->souscription_vignette, 0, 3) == "JPG" || substr($souscription->souscription_vignette, 0, 3) == "JPEG")){
                            list($width, $height, $type, $attr) = getimagesize(Util_Utils::getParamEsmc(2).$souscription->souscription_vignette);
	                        $pourcent = 700 * 100 / $width;
	                        $width2 = 700;
	                        $height2 = $pourcent * $height / 100;
                            $htmlpdf .= '<img src="'.Util_Utils::getParamEsmc(2).'/'.$souscription->souscription_vignette.'" width="'.$width2.'" height="'.$height2.'" />
                            ';
                            }
                        $htmlpdf .= '  </td>
	                    </tr>
                        </tbody>
                        </table>
                        <br />
                        <br />
                        &nbsp;
                        </page>';
                        $htmlpdf .= '';
						
						////////////////////////////////////////////////////////////////////////////////
                        $filename = ''.Util_Utils::getParamEsmc(1).'/souscriptions.html';
                        $somecontent = $htmlpdf;

                        // Assurons nous que le fichier est accessible en écriture
                        if (is_writable($filename)) {
                            // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
                            // Le pointeur de fichier est placé à la fin du fichier
                             // c'est là que $somecontent sera placé
                        if (!$handle = fopen($filename, 'w+')) {
                            echo "Impossible d'ouvrir le fichier ($filename)";
                            exit;
                        }

                        // Ecrivons quelque chose dans notre fichier.
                        if (fwrite($handle, $somecontent) === FALSE) {
                            echo "Impossible d'écrire dans le fichier ($filename)";
                            exit;
                        }
                        //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
                        fclose($handle);
                    
                        } else {
                           echo "Le fichier $filename n'est pas accessible en écriture.";
                        }

                        ////////////////////////////////////////////////////////////////////////////	
                        $file = $filename;
                        if (!is_dir("../../webfiles/pdf_souscription/")) {
                            mkdir("../../webfiles/pdf_souscription/", 0777);
                        }
                        /*".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))."*/

                        $newfile = "../../webfiles/pdf_souscription/SOUSCRIPTION_".str_replace("/", "_", mettreaccents($souscription->souscription_id))."_.html";
                        $newnom = "SOUSCRIPTION_".str_replace("/", "_", mettreaccents($souscription->souscription_id)."_");
                        $newchemin = "../../webfiles/pdf_souscription/";
                        copy($file, $newfile);
                        ob_start();
                        include(dirname(__FILE__).'/../'.$newfile);
                        $content = ob_get_clean();

                        // convert to PDF
                        require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
                        try {
                            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
                            $html2pdf->pdf->SetDisplayMode('fullpage');
                            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                            //$html2pdf->writeHTML($content);
                            $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
                        }
                        catch(HTML2PDF_exception $e) {
                            echo $e;
                            exit;
                        }

                        $file = $newchemin.$newnom.'.pdf';
                        $filena	= $newnom.'.pdf';

                        unlink($newfile);
						
						// operation de transfert
						$souscription = new Application_Model_EuSouscription();
		                $souscriptionM = new Application_Model_EuSouscriptionMapper();
                                   $souscriptionM->find($compteur_souscription, $souscription);
								   $date = new Zend_Date();
		                           $compte_map = new Application_Model_EuCompteMapper();
                                   $compte      = new Application_Model_EuCompte();
			                       $sms_money   = new Application_Model_EuSmsmoney();
                                   $money_map   = new Application_Model_EuSmsmoneyMapper();
			
			                       $det_sms   = new Application_Model_EuDetailSmsmoney();
			                       $det_sms_m = new Application_Model_EuDetailSmsmoneyMapper();
			
			                       $det_vte_sms = new Application_Model_DbTable_EuDetailVentesms();
			                       $det_vtesms  = new Application_Model_EuDetailVentesms();
			
			                       $mobile = $souscription->souscription_mobile;
			                       //$nbre_compte = $souscription->souscription_nombre;
			                       $fcaps = Util_Utils::getParametre('CAPS','valeur');
										
								   $mont_fs = Util_Utils::getParametre('FS','valeur');
                                   $mont_fl = Util_Utils::getParametre('FL','valeur');
                                   $mont_kps = Util_Utils::getParametre('FKPS','valeur');
			
		                           //$montant = $nbre_compte * $fcaps;
		                           $membre_pbf = '0000000000000000001M';
	                               $code_compte_pbf = "NN-TR-".$membre_pbf;
			                       $ret = $compte_map->find($code_compte_pbf,$compte);
								   
								   if($souscription->souscription_programme == 'KACM') {
				     if($ret && ($compte->getSolde() >= ($mont_fs + $mont_fl + $mont_kps))) {
			             // Mise à jour du compte de transfert
				         $compte->setSolde($compte->getSolde() - ($mont_fs + $mont_fl + $mont_kps));
                         $compte_map->update($compte);    
	                  } else {
			             $db->rollback();				
			             $this->view->error = 'Erreur de traitement : le compte est introuvable ou le solde du compte insuffisant';
						 $this->view->ancien_code_membre = $_POST['ancien_code_membre'];
                         $this->view->raison = $_POST['souscription_raison'];
                         $this->view->ville_membre = $_POST['souscription_ville']; 
                         $this->view->quartier_membre = $_POST['souscription_quartier'];
                         $this->view->email = $_POST['souscription_email'];
                         $this->view->portable = $_POST['souscription_mobile'];
						 $this->view->statut_juridique = $_POST['statut_juridique'];
                         $this->view->type_acteur = $_POST['type_acteur'];
					     $this->_redirect('/association/reactivationsouscriptionmcnppm/id/'.$_POST['ancien_code_membre']);
                         return;			   
			          }
					  
					  $codefs   = '';
                      $codefl   = '';
                      $codefkps = '';
					  // Traitement des produits FS
				      // insertion dans la table eu_smsmoney
				      $lignesdetfs = $det_sms_m->findSMSByCompte($membre_pbf,'FS');
					  // Traitement des produits FL
                      // insertion dans la table eu_smsmoney
				      $lignesdetfl = $det_sms_m->findSMSByCompte($membre_pbf,'FL');
					  // Traitement des produits FCPS
				      $lignesdetfkps = $det_sms_m->findSMSByCompte($membre_pbf,'FCPS');
			          if ($lignesdetfs != null && $lignesdetfl !=  null && $lignesdetfkps != null) {						
							$codefs   = strtoupper(Util_Utils::genererCodeSMS(8));
					        $nengfs = $money_map->findConuter() + 1;
							$sms_money->setNEng($nengfs)
                	                  ->setCode_Agence(null)
                                      ->setCreditAmount($mont_fs)
                                      ->setSentTo($mobile)
                                      ->setMotif('FS')
                                      ->setId_Utilisateur(null)
                                      ->setCurrencyCode('XOF')
                                      ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                      ->setFromAccount($code_compte_pbf)
                                      ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                      ->setCreditCode($codefs)
                                      ->setDestAccount(null)
                                      ->setIDDatetimeConsumed(0)
                                      ->setDestAccount_Consumed(null)
                                      ->setDatetimeConsumed(null)
                                      ->setNum_recu(null);
                            $money_map->save($sms_money);                                   
														
							$i = 0;
					        $reste = $mont_fs;
					        $nbre_lignesdetfs = count($lignesdetfs);
				            while ($reste > 0 && $i < $nbre_lignesdetfs) {
					              $lignedetfs = $lignesdetfs[$i];
                                  $id = $lignedetfs->getId_detail_smsmoney();
						          $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						          if ($reste >= $lignedetfs->getSolde_sms()) {
						                 //Mise à jour  des lignes d'enrégistrement
					                     //insertion dans la table eu_detailventesms
						                 $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                         $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                            ->setId_detail_smsmoney($id)
                                                    ->setCode_membre_dist($membre_pbf)
                                                    ->setCode_membre(null)
                                                    ->setType_tansfert('FS')
                                                    ->setCreditcode($codefs)
                                                    ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                    ->setMont_vente($lignedetfs->getSolde_sms())
                                                    ->setId_utilisateur(null)
                                                    ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $reste = $reste - $lignedetfs->getSolde_sms();
							              $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $lignedetfs->getSolde_sms())
		                                             ->setMont_regle($lignedetfs->getMont_regle() + $lignedetfs->getSolde_sms())
		                                             ->setSolde_sms(0);
                                                                $det_sms_m->update($lignedetfs);			 							   
						            } else  {
							              //Mise à jour  des lignes d'enrégistrement
						                  //insertion dans la table eu_detailventesms
						                  $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                          $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                             ->setId_detail_smsmoney($id)
                                                     ->setCode_membre_dist($membre_pbf)
                                                     ->setCode_membre(null)
                                                     ->setType_tansfert('FS')
                                                     ->setCreditcode($codefs)
                                                     ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                     ->setMont_vente($reste)
                                                     ->setId_utilisateur(null)
                                                     ->setCode_produit('FS');
                                          $det_vte_sms->insert($det_vtesms->toArray());
                                          $lignedetfs->setSolde_sms($lignedetfs->getSolde_sms() - $reste);
						                  $lignedetfs->setMont_vendu($lignedetfs->getMont_vendu() + $reste);
							              $lignedetfs->setMont_regle($lignedetfs->getMont_regle() + $reste);
                                          $det_sms_m->update($lignedetfs);
						                  $reste = 0;
						             }
						             $i++;
					              }
														
								  $codefl   = strtoupper(Util_Utils::genererCodeSMS(8));
				                  $nengfl = $money_map->findConuter() + 1;
                                  $sms_money->setNEng($nengfl)
                	                        ->setCode_Agence(null)
                                            ->setCreditAmount($mont_fl)
                                            ->setSentTo($mobile)
                                            ->setMotif('FL')
                                            ->setId_Utilisateur(null)
                                            ->setCurrencyCode('XOF')
                                            ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                            ->setFromAccount($code_compte_pbf)
                                            ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                            ->setCreditCode($codefl)
                                            ->setDestAccount(null)
                                            ->setIDDatetimeConsumed(0)
                                            ->setDestAccount_Consumed(null)
                                            ->setDatetimeConsumed(null)
                                            ->setNum_recu(null);
                                  $money_map->save($sms_money);
					                                    
								  $j = 0;
					              $reste = $mont_fl;
					              $nbre_lignesdetfl = count($lignesdetfl);
					              while ($reste > 0 && $j < $nbre_lignesdetfl) {
					                    $lignedetfl = $lignesdetfl[$j];
                                        $id = $lignedetfl->getId_detail_smsmoney();
						                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                if ($reste >= $lignedetfl->getSolde_sms()) {
						                   //Mise à jour  des lignes d'enrégistrement
                                           $reste = $reste - $lignedetfl->getSolde_sms();
									       //insertion dans la table eu_detailventesms
						                   $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                           $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                              ->setId_detail_smsmoney($id)
                                                      ->setCode_membre_dist($membre_pbf)
                                                      ->setCode_membre(null)
                                                      ->setType_tansfert('FL')
                                                      ->setCreditcode($codefl)
                                                      ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                      ->setMont_vente($lignedetfl->getSolde_sms())
                                                      ->setId_utilisateur(null)
                                                      ->setCode_produit('FL');
                                            $det_vte_sms->insert($det_vtesms->toArray());
							                $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $lignedetfl->getSolde_sms())
		                                               ->setMont_regle($lignedetfl->getMont_regle() + $lignedetfl->getSolde_sms())
		                                               ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfl);			 							   
						                  } else  {
							                 //Mise à jour  des lignes d'enrégistrement
											//insertion dans la table eu_detailventesms
						                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                               ->setId_detail_smsmoney($id)
                                                       ->setCode_membre_dist($membre_pbf)
                                                       ->setCode_membre(null)
                                                       ->setType_tansfert('FL')
                                                       ->setCreditcode($codefl)
                                                       ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                       ->setMont_vente($reste)
                                                       ->setId_utilisateur(null)
                                                       ->setCode_produit('FL');
                                              $det_vte_sms->insert($det_vtesms->toArray());
                                              $lignedetfl->setSolde_sms($lignedetfl->getSolde_sms() - $reste);
						                      $lignedetfl->setMont_vendu($lignedetfl->getMont_vendu() + $reste);
							                  $lignedetfl->setMont_regle($lignedetfl->getMont_regle() + $reste);
                                              $det_sms_m->update($lignedetfl);
						                      $reste = 0;
						                   }
						                                $j++;
					                   }
													
													$codefkps = strtoupper(Util_Utils::genererCodeSMS(8));
				                                    $nengfkps = $money_map->findConuter() + 1;
                                                    $sms_money->setNEng($nengfkps)
                	                                          ->setCode_Agence(null)
                                                              ->setCreditAmount($mont_kps)
                                                              ->setSentTo($mobile)
                                                              ->setMotif('FCPS')
                                                              ->setId_Utilisateur(null)
                                                              ->setCurrencyCode('XOF')
                                                              ->setDatetime($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                              ->setFromAccount($code_compte_pbf)
                                                              ->setIDDatetime(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')))
                                                              ->setCreditCode($codefkps)
                                                              ->setDestAccount(null)
                                                              ->setIDDatetimeConsumed(0)
                                                              ->setDestAccount_Consumed(null)
                                                              ->setDatetimeConsumed(null)
                                                              ->setNum_recu(null);
                                                    $money_map->save($sms_money);
													
													$k = 0;
					                                $reste = $mont_kps;
					                                $nbre_lignesdetfkps = count($lignesdetfkps);
					                                while ($reste > 0 && $k < $nbre_lignesdetfkps) {
					                                    $lignedetfkps = $lignesdetfkps[$k];
                                                        $id = $lignedetfkps->getId_detail_smsmoney();
						                                $finddetsmsmoney = $det_sms_m->find($id,$det_sms);
						                                if ($reste >= $lignedetfkps->getSolde_sms()) {
						                                    //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($lignedetfkps->getSolde_sms())
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $reste = $reste - $lignedetfkps->getSolde_sms();
							                                $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $lignedetfkps->getSolde_sms())
		                                                                 ->setMont_regle($lignedetfkps->getMont_regle() + $lignedetfkps->getSolde_sms())
		                                                                 ->setSolde_sms(0);
                                                            $det_sms_m->update($lignedetfkps);			 							   
						                                } else  {
							                                //Mise à jour  des lignes d'enrégistrement
															//insertion dans la table eu_detailventesms
						                                    $id_detail_vtsms = $det_vtesms->findConuter() + 1;	
				                                            $det_vtesms->setId_detail_vtsms($id_detail_vtsms)
						                                           ->setId_detail_smsmoney($id)
                                                                   ->setCode_membre_dist($membre_pbf)
                                                                   ->setCode_membre(null)
                                                                   ->setType_tansfert('FCPS')
                                                                   ->setCreditcode($codefl)
                                                                   ->setDate_vente($date->toString('yyyy-MM-dd hh:mm:ss'))
                                                                   ->setMont_vente($reste)
                                                                   ->setId_utilisateur(null)
                                                                   ->setCode_produit('FCPS');
                                                            $det_vte_sms->insert($det_vtesms->toArray());
                                                            $lignedetfkps->setSolde_sms($lignedetfkps->getSolde_sms() - $reste);
						                                    $lignedetfkps->setMont_vendu($lignedetfkps->getMont_vendu() + $reste);
							                                $lignedetfkps->setMont_regle($lignedetfkps->getMont_regle() + $reste);
                                                            $det_sms_m->update($lignedetfkps);
						                                    $reste = 0;
						                                }
						                                $k++;
					                                }
													
													// insertion dans la table eu_code_activation
				                                    $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				                                    $codeactivation = new Application_Model_EuCodeActivation();
			                                        $countcode = $m_codeactivation->findConuter() + 1;
				
				                                    $codeactivation->setId_code_activation($countcode)
					                                              ->setDate_generer($date->toString('yyyy-MM-dd HH:mm:ss'));		   
				                                    $codeactivation->setCode_membre(null);   
			                                        $codeactivation->setCode_fs($codefs);
				                                    $codeactivation->setCode_fl($codefl);
				                                    $codeactivation->setCode_fkps($codefkps);
				                                    $codeactivation->setSouscription_id($souscription->souscription_id);
				                                    $m_codeactivation->save($codeactivation);
				
				                                    $compteur = Util_Utils::findConuter() + 1;
				                                    Util_Utils::addSms($compteur,$mobile,'Voici vos codes d\'activation de compte marchand : '.' CODE FS : '.$codefs.' CODE FL : '.$codefl.' CODE FCPS : '.$codefkps);
												
										            }  else {
												        $db->rollback();
	                                                    $this->view->error = 'Erreur de traitement : le solde est null';
						                                $this->view->ancien_code_membre = $_POST['ancien_code_membre'];
                                                        $this->view->raison = $_POST['souscription_raison'];
                                                        $this->view->ville_membre = $_POST['souscription_ville']; 
                                                        $this->view->quartier_membre = $_POST['souscription_quartier'];
                                                        $this->view->email = $_POST['souscription_email'];
                                                        $this->view->portable = $_POST['souscription_mobile'];
														$this->view->statut_juridique = $_POST['statut_juridique'];
                                                        $this->view->type_acteur = $_POST['type_acteur'];
					                                    $this->_redirect('/association/reactivationsouscriptionmcnppm/id/'.$_POST['ancien_code_membre']);	
												    }	
				                             }
						
						
						
						
						
					
					}
					$html .= "Date : ".$date_id->toString('yyyy-MM-dd HH:mm:ss')."<br />";
                    $tafl = new Application_Model_DbTable_EuAncienFl();
                    $afl = new Application_Model_EuAncienFl();
                    $code_fl = 'FL-'.$_POST['ancien_code_membre'];
                    $result = $tafl->find($code_fl);
				    if(count($result) == 0) {
                       $html .= "Vignette : <a href='http://prod.esmcgacsource.com/".$souscription_vignette."'>".$souscription_vignette."</a>";
				    }
					
					$esmc_email	 = Util_Utils::getParamEsmc(3);			
                    $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5));
                    Zend_Mail::setDefaultTransport($tr);		
                    $mail = new Zend_Mail();
                    //$mail->setBodyText('Mon texte de test');
                    $mail->setBodyHtml($html);
                    $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - SIF");
                    $mail->addTo($esmc_email, "ESMC - SIF");
                    $mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm:ss'));
                    $mail->send();
					
					if($_POST['souscription_email'] != "") {
                        $config = array('auth' => 'login','username' => Util_Utils::getParamEsmc(3),'password' => Util_Utils::getParamEsmc(4));
                        $tr = new Zend_Mail_Transport_Smtp(Util_Utils::getParamEsmc(5), $config);
                        Zend_Mail::setDefaultTransport($tr);		
                        $mail = new Zend_Mail();
                        //$mail->setBodyText('Mon texte de test');
                        $mail->setBodyHtml($html);
                        $mail->setFrom(Util_Utils::getParamEsmc(3), "ESMC - SIF");
                        $mail->addTo($_POST['souscription_email'], $_POST['souscription_raison']);
                        $mail->setSubject('Ré-activation par souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
                        $mail->send($tr);
			        }
	                $db->commit();
		            $sessionmembreasso->errorlogin = "Demande de Quittance de Ré-activation bien effectuée";
		            $this->_redirect('/association/ancienpmmcnp');
					
				} catch (Exception $exc) {
				    $db->rollback();
				    $this->view->error = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				    return;
			    }
            }   else {  $this->view->error = "Champs * obligatoire ...";  }
			
        }   else {
            $id = (string)$this->_request->getParam('id');
            $tabela = new Application_Model_DbTable_EuAncienMembre();
            $select = $tabela->select();
            $select->from($tabela,array('eu_ancien_membre.*',"date_identification as dateidentif"))
                   ->where('ancien_code_membre like ?', '%'.$id.'%')
                   ->where('(etat_contrat = 0')->orwhere('etat_contrat IS NULL)');        
            $memb = $tabela->fetchAll($select);
            $trouvmembre = $memb->current();

            $this->view->ancien_code_membre = $trouvmembre->ancien_code_membre;
            $this->view->raison = $trouvmembre->raison_sociale;
            //$this->view->code_rep = $trouvmembre->nom_membre." ".$trouvmembre->prenom_membre;
            $this->view->quartier_membre = $trouvmembre->quartier_membre;
            $this->view->ville_membre = $trouvmembre->ville_membre;
             //$this->view->bp = $trouvmembre->bp_membre;
            //$this->view->tel = $trouvmembre->tel_membre; 
            $this->view->portable = $trouvmembre->portable_membre;
            $this->view->email = $trouvmembre->email_membre;
            $this->view->site_web = $trouvmembre->site_web;
            $this->view->statut_juridique = $trouvmembre->code_statut;
            $this->view->type_acteur = $trouvmembre->code_type_acteur;
        }   		
	                
    
    }
	
  


	

   public function enrolementsms2Action() {
	
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

		$request = $this->getRequest ();
		if ($request->isPost ()) {
		   if (isset($_POST['code_fs']) && $_POST['code_fs']!="" 
		      && isset($_POST['code_fl']) && $_POST['code_fl']!="" 
		      && isset($_POST['nom_membre']) && $_POST['nom_membre']!="" 
		      && isset($_POST['sexe_membre']) && $_POST['sexe_membre']!="" 
		      && isset($_POST['nationalite_membre']) && $_POST['nationalite_membre']!="" 
		      && isset($_POST['sitfam_membre']) && $_POST['sitfam_membre']!="" 
		      && isset($_POST['prenom_membre']) && $_POST['prenom_membre']!="" 
		      && isset($_POST['date_nais_membre']) && $_POST['date_nais_membre']!="" 
		      && isset($_POST['lieu_nais_membre']) && $_POST['lieu_nais_membre']!="" 
		      && isset($_POST['nbr_enf_membre']) && $_POST['nbr_enf_membre']!="" 
		      && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" 
		      && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" 
		      && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" 
		      && isset($_POST['profession_membre']) && $_POST['profession_membre']!="" 
		      && isset($_POST['religion_membre']) && $_POST['religion_membre']!="" 
		      && isset($_POST['id_pays']) && $_POST['id_pays']!="" 
		      && isset($_POST['code_agence']) && $_POST['code_agence']!="") {
					
					

                    $id_utilisateur_acnev = 1;
                    $id_utilisateur_filiere = 2;
                    $id_utilisateur_technopole = 3;

					
					
				    $smsmoneyM = new Application_Model_EuSmsmoneyMapper();
					$code_agence = $request->getParam("code_agence");
                    $code_zone = substr($_POST['code_agence'], 0, 3);
                    $id_pays = $_POST['id_pays'];
                    $table = new Application_Model_DbTable_EuActeur();
                    $selection = $table->select();
                    $selection->where('code_membre like ?',$code_agence.'%');
                    $selection->where('type_acteur like ?','gac_surveillance');
                    $resultat = $table->fetchAll($selection);
                    $trouvacteursur = $resultat->current();
                    $code_acteur = $trouvacteursur->code_acteur;
					
					$date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_idd = clone $date_id;
                    $membre = new Application_Model_EuMembre();
                    $mapper = new Application_Model_EuMembreMapper();
                    $compte = new Application_Model_EuCompte();
                    $map_compte = new Application_Model_EuCompteMapper();
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
					
					$souscription = new Application_Model_EuSouscription();
                    $souscription_mapper = new Application_Model_EuSouscriptionMapper();
					
                    $fs = Util_Utils::getParametre('FS','valeur');
                    $mont_fl = Util_Utils::getParametre('FL','valeur');
                    $mont_cps = Util_Utils::getParametre('FKPS','valeur');
					$ancien_code = '';
                    $tcartes = array();
                    $tscartes = array();
                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
				    try {
				        $code_fs = $request->getParam("code_fs");
                        $code_fl = $request->getParam("code_fl");
                        $code_fkps = $request->getParam("code_fkps");
						
						if($code_fs != "") {
						    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                            if ($code == NULL) {
                               $code = $code_agence . '0000001' . 'P';
                            } 
                            else {
                               $num_ordre = substr($code, 12, 7);
                               $num_ordre++;
                               $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                               $code = $code_agence . $num_ordre_bis . 'P';
                            }
                            $sms_fs = $sms_mapper->findByCreditCode($code_fs);
							if ($sms_fs == NULL) {
                                $db->rollback();
                                $this->view->message = 'Le code FS [' . $code_fs . ']  est  invalide !!!';
                                $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;
                            }
							
							if($sms_fs->getMotif() != 'FS') {
                                $db->rollBack();
                                $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                                $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;    
                            }
							
							$date_nais = new Zend_Date($_POST["date_nais_membre"]);
                            if ($date_nais >= $date_idd) {
                                $this->view->message = "Erreur d'éxecution: La date de naissance doit être antérieure à la date actuelle !!!";
                                $db->rollback();
                                $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;
                            }
							
							
///////////////////////////////preinscription						

            $preinsc_mapper = new Application_Model_EuPreinscriptionMapper();
            $compteur_preinscription = $preinsc_mapper->findConuter() + 1;         
          
            $preinscription = new Application_Model_EuPreinscription();
            //$mapper_preins = new Application_Model_EuPreinscriptionMapper();
            
            $preinscription->setId_preinscription($compteur_preinscription)
                           ->setNom_membre($request->getParam("nom_membre"))
                           ->setPrenom_membre($request->getParam("prenom_membre"))
                           ->setSexe_membre($request->getParam("sexe_membre"))
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($request->getParam("id_pays"))
                           ->setLieu_nais_membre($request->getParam("lieu_nais_membre"))
                           ->setPere_membre($request->getParam("pere_membre"))
                           ->setMere_membre($request->getParam("mere_membre"))
                           ->setSitfam_membre($request->getParam("sitfam_membre"))
                           ->setNbr_enf_membre($request->getParam("nbr_enf_membre"))
                           ->setProfession_membre($request->getParam("profession_membre"))
                           ->setFormation($request->getParam("formation"))
                           ->setId_religion_membre($request->getParam("religion_membre"))
                           ->setQuartier_membre($request->getParam("quartier_membre"))
                           ->setVille_membre($request->getParam("ville_membre"))
                           ->setBp_membre($request->getParam("bp_membre"))
                           ->setTel_membre($request->getParam("tel_membre"))
                           ->setEmail_membre($request->getParam("email_membre"))
                           ->setPortable_membre($request->getParam("portable_membre"))
                           ->setHeure_inscription($date_idd->toString('HH:mm:ss'))
                           ->setDate_inscription($date_id->toString('yyyy-MM-dd'))
                           ->setCode_membre(NULL)
						   ->setCode_agence($code_agence)
                           ->setCode_fs($request->getParam("code_fs"))
                           ->setCode_fl($request->getParam("code_fl"))
                		   ->setCode_fkps($request->getParam("code_fkps"));
                $preinscription->setPublier(1);

                $preinsc_mapper->save($preinscription);


///////////////////////////validation acnev
								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
												$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
												$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
												$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_acnev);
												$validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
												$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
												$validation_quittance->setPublier(1);
												$validation_quittance_mapper->save($validation_quittance);

          
//////validation filere
								$preinscription = new Application_Model_EuPreinscription();
								$preinscriptionM = new Application_Model_EuPreinscriptionMapper();
								$preinscriptionM->find($compteur_preinscription, $preinscription);
								
								$preinscription->setPublier(2);
								$preinscriptionM->update($preinscription);


								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
								$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
								$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
								$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_filiere);
							    $validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
								$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
								$validation_quittance->setPublier(1);
								$validation_quittance_mapper->save($validation_quittance);
							
                                //////validation technopole
								$preinscription = new Application_Model_EuPreinscription();
								$preinscriptionM = new Application_Model_EuPreinscriptionMapper();
								$preinscriptionM->find($compteur_preinscription, $preinscription);
								
								$preinscription->setPublier(3);
								$preinscriptionM->update($preinscription);


								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
												$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
												$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
												$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_technopole);
												$validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
												$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
												$validation_quittance->setPublier(1);
												$validation_quittance_mapper->save($validation_quittance);
							
							
////////////////////////////////////////////							
														
							
							$membre->setCode_membre($code)
                                   ->setNom_membre($request->getParam("nom_membre"))
                                   ->setPrenom_membre($request->getParam("prenom_membre"))
                                   ->setSexe_membre($request->getParam("sexe_membre"))
                                   ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                                   ->setId_pays($request->getParam("nationalite_membre"))
                                   ->setLieu_nais_membre($request->getParam("lieu_nais_membre"))
                                   ->setPere_membre($request->getParam("pere_membre"))
                                   ->setMere_membre($request->getParam("mere_membre"))
                                   ->setSitfam_membre($request->getParam("sitfam_membre"))
                                   ->setNbr_enf_membre($request->getParam("nbr_enf_membre"))
                                   ->setProfession_membre($request->getParam("profession_membre"))
                                   ->setFormation($request->getParam("formation"))
                                   ->setId_religion_membre($request->getParam("religion_membre"))
                                   ->setQuartier_membre($request->getParam("quartier_membre"))
                                   ->setVille_membre($request->getParam("ville_membre"))
                                   ->setBp_membre($request->getParam("bp_membre"))
                                   ->setTel_membre($request->getParam("tel_membre"))
                                   ->setEmail_membre($request->getParam("email_membre"))
                                   ->setPortable_membre($request->getParam("portable_membre"))
                                   ->setId_utilisateur(NULL)
                                   ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                                   ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                                   ->setCode_agence($code_agence)
                                   ->setCodesecret(md5($_POST["codesecret"]))
                                   ->setAuto_enroler('O')
                                   ->setEtat_membre(null);
                                $mapper->save($membre);
								
								
								/////////////
								$preinscription = new Application_Model_EuPreinscription();
								$preinscriptionM = new Application_Model_EuPreinscriptionMapper();
								$preinscriptionM->find($compteur_preinscription, $preinscription);
								
								$preinscription->setCode_membre($code);
								$preinscriptionM->update($preinscription);
								
								
								
								
								
								
						// insertion dans la table eu_code_activation
				        $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				        $codeactivation = new Application_Model_EuCodeActivation();
						
						$m_dvente = new Application_Model_EuDepotVenteMapper();
				        $dvente = new Application_Model_EuDepotVente();
						
								   
						$findcode = $m_codeactivation->findbycode($code_fs,$code_fl,$code_fkps);
						if($findcode != NULL)  {
						    $findcode = $findcode[0];
							//$id_souscription = $findcode->souscription_id;
							//$findsouscrip = $souscription_mapper->find($id_souscription,$souscription);
							//if($findsouscrip != FALSE) {
							//}
							$souscription_mapper->find($findcode->souscription_id,$souscription);
							$ancien_code = $souscription->souscription_ancien_membre;
							//$findsousdv = $m_dvente->findbysouscriptionmembre($id_souscription);
							//$id_depot = $findsousdv->id_depot;
							//$trouvedepot = $m_dvente->find($id_depot,$dvente);
							$trouvecode = $m_codeactivation->find($findcode->id_code_activation,$codeactivation);
							$codeactivation->setCode_membre($code);
							$m_codeactivation->update($codeactivation);
                            //$dvente->setCode_membre($code);
                            //$m_dvente->update($dvente);							
						} 
						else {
							$this->view->message = "Erreur d'éxecution: Les codes d\'activation ne sont liés à aucune quittance de souscription !!!";
                            $db->rollback();
                            $this->view->nom_membre = $_POST["nom_membre"];
                            $this->view->prenom_membre = $_POST["prenom_membre"];
                            $this->view->sexe = $_POST["sexe_membre"];
                            $this->view->sitfam = $_POST["sitfam_membre"];
                            $this->view->datnais = $_POST["date_nais_membre"];
                            $this->view->nation = $_POST["nationalite_membre"];
                            $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                            $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                            $this->view->formation = $_POST["formation"];
                            $this->view->profession = $_POST["profession_membre"];
                            $this->view->religion = $_POST["religion_membre"];
                            $this->view->pere = $_POST["pere_membre"];
                            $this->view->mere = $_POST["mere_membre"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            return;	
					    }
								
							$mem = new Application_Model_EuMembre();
                            $mem_mapper = new Application_Model_EuMembreMapper();
							$findmem = $mem_mapper->find($code,$mem);
							
							if(($ancien_code == '') || ($ancien_code == NULL)) {
							  $mem->setEtat_membre('N');
							} else {
							  if(substr($ancien_code,-1,1) == 'M') {
							     $this->view->message = "Erreur d'éxecution: Ce membre n\'est pas autorisé à effectuer cette opération !!!";
                                 $db->rollback();
                                 $this->view->nom_membre = $_POST["nom_membre"];
                                 $this->view->prenom_membre = $_POST["prenom_membre"];
                                 $this->view->sexe = $_POST["sexe_membre"];
                                 $this->view->sitfam = $_POST["sitfam_membre"];
                                 $this->view->datnais = $_POST["date_nais_membre"];
                                 $this->view->nation = $_POST["nationalite_membre"];
                                 $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                                 $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                                 $this->view->formation = $_POST["formation"];
                                 $this->view->profession = $_POST["profession_membre"];
                                 $this->view->religion = $_POST["religion_membre"];
                                 $this->view->pere = $_POST["pere_membre"];
                                 $this->view->mere = $_POST["mere_membre"];
                                 $this->view->quartier_membre = $_POST["quartier_membre"];
                                 $this->view->ville_membre = $_POST["ville_membre"];
                                 $this->view->bp = $_POST["bp_membre"];
                                 $this->view->tel = $_POST["tel_membre"];
                                 $this->view->email = $_POST["email_membre"];
                                 $this->view->portable = $_POST["portable_membre"];
                                 return;
							  }
							
                              $mem->setEtat_membre('A');
							  //Mise à jour de la table physique
                              $p_mapper = new Application_Model_PhysiqueMapper();
                              $p = new Application_Model_Physique();
                              $rep = $p_mapper->find($ancien_code,$p);
                              if ($rep == true) {      
                                 $p->setEtat_contrat(1)
                                   ->setCode_membre($code);
                                 $p_mapper->update($p);      
                              }
							  // Mise à jour de la table eu_ancien_membre
                              $pmcnp_mapper = new Application_Model_EuAncienMembreMapper();
                              $pmcnp = new Application_Model_EuAncienMembre();
                              $repmcnp = $pmcnp_mapper->find($ancien_code,$pmcnp);
                              if ($repmcnp == true) {      
                                 $pmcnp->setEtat_contrat(1)
                                       ->setCode_membre($code);
                                 $pmcnp_mapper->update($pmcnp);      
                              }  
                            }							
							$mem_mapper->update($mem);							
								
							$cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $cb = new Application_Model_EuCompteBancaire();
						    for($i = 0; $i < count($_POST['code_banque']); $i++) {
                                    $cb_compteur = $cb_mapper->findConuter() + 1;         
                                    $cb->setCode_banque($_POST['code_banque'][$i])
                                       ->setId_compte($cb_compteur)
                                       ->setCode_membre($code)
                                       ->setCode_membre_morale(NULL)
                                       ->setNum_compte_bancaire($_POST['num_compte'][$i]);
                                    $cb_mapper->save($cb);
                                }
								
								$mapper_op = new Application_Model_EuOperationMapper();
                                $compteurfs = $mapper_op->findConuter() + 1;
                                $lib_op = 'Auto-enrôlement';
                                $type_op = 'AERL';
                                Util_Utils::addOperation($compteurfs,$code,NULL,'TFS',$fs,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_id->toString('HH:mm:ss'), NULL);            
                                $tab_fs = new Application_Model_DbTable_EuFs();
                                $fs_model = new Application_Model_EuFs();
                                $fs_model->setCode_membre($code)
                                         ->setCode_membre_morale(NULL)
                                         ->setCode_fs('FS-' . $code)
                                         ->setCreditcode($sms_fs->getCreditCode())
                                         ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                         ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                         ->setId_utilisateur(NULL)
                                         ->setMont_fs($fs);
								if(($ancien_code =='') || ($ancien_code == NULL)) {		 
				                   $fs_model->setOrigine_fs('N');
								} else {
                                   $fs_model->setOrigine_fs('A');
                                }								
                                $tab_fs->insert($fs_model->toArray());
            
                                $sms_fs->setDestAccount_Consumed('NB-TFS-'.$code)
                                       ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                                       ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                                $sms_mapper->update($sms_fs);
								
								$userin = new Application_Model_EuUtilisateur();
                                $mapper = new Application_Model_EuUtilisateurMapper();
                                $id_user = $mapper->findConuter() + 1;
                                $userin->setId_utilisateur($id_user)
                                       ->setId_utilisateur_parent(NULL)
                                       ->setPrenom_utilisateur($request->getParam("prenom_membre"))
                                       ->setNom_utilisateur($request->getParam("nom_membre"))
                                       ->setLogin($code)
                                       ->setPwd(md5($_POST["codesecret"]))
                                       ->setDescription(NULL)
                                       ->setUlock(0)
                                       ->setCh_pwd_flog(0)
                                       ->setCode_groupe('personne_physique')
                                       ->setCode_groupe_create('personne_physique')
                                       ->setConnecte(0)
                                       ->setCode_agence($code_agence)
                                       ->setCode_secteur(NULL)
                                       ->setCode_zone($code_zone)
                                      //->setCode_gac_filiere(NULL)
                                       ->setId_pays($id_pays)       
                                       ->setCode_acteur($code_acteur)
                                       ->setCode_membre($code);    
                                $mapper->save($userin);
								
								// Mise à jour de la table eu_contrat
                                $contrat = new Application_Model_EuContrat();
                                $mapper_contrat = new Application_Model_EuContratMapper();
                                $id_contrat = $mapper->findConuter() + 1;
                                $contrat->setId_contrat($id_contrat);
                                $contrat->setCode_membre($code);
                                $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd'));
                                $contrat->setNature_contrat('numeraire');
                                $contrat->setId_type_contrat(NULL);
                                $contrat->setId_type_creneau(NULL);
                                $contrat->setId_type_acteur(NULL);
                                $contrat->setId_pays(NULL);
                                $contrat->setId_utilisateur(NULL);
                                $contrat->setFiliere(NULL);
                                $mapper_contrat->save($contrat);
						} else {   
                            $this->view->message = "Erreur d'éxecution: Le code FS est inexistant !!!";
                            $db->rollback();
                            $this->view->nom_membre = $request->getParam("nom_membre");
                            $this->view->prenom_membre = $request->getParam("prenom_membre");
                            $this->view->sexe = $request->getParam("sexe_membre");
                            $this->view->sitfam = $request->getParam("sitfam_membre");
                            $this->view->datnais = $request->getParam("date_nais_membre");
                            $this->view->nation = $request->getParam("nationalite_membre");
                            $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                            $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                            $this->view->formation = $request->getParam("formation");
                            $this->view->profession = $request->getParam("profession_membre");
                            $this->view->religion = $request->getParam("religion_membre");
                            $this->view->pere = $request->getParam("pere_membre");
                            $this->view->mere = $request->getParam("mere_membre");
                            $this->view->quartier_membre = $request->getParam("quartier_membre");
                            $this->view->ville_membre = $request->getParam("ville_membre");
                            $this->view->bp = $request->getParam("bp_membre");
                            $this->view->tel = $request->getParam("tel_membre");
                            $this->view->email = $request->getParam("email_membre");
                            $this->view->portable = $request->getParam("portable_membre");
                            return;  
					    }
						
						if($code_fl != "") {
						    $sms_fl = $sms_mapper->findByCreditCode($code_fl);
							if ($sms_fl == NULL) {
                                $db->rollback();
                                $this->view->message = 'Le code FL [' . $code_fl . ']  est  invalide !!!';
                                $this->view->nom_membre = $request->getParam("nom_membre");
                            $this->view->prenom_membre = $request->getParam("prenom_membre");
                            $this->view->sexe = $request->getParam("sexe_membre");
                            $this->view->sitfam = $request->getParam("sitfam_membre");
                            $this->view->datnais = $request->getParam("date_nais_membre");
                            $this->view->nation = $request->getParam("nationalite_membre");
                            $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                            $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                            $this->view->formation = $request->getParam("formation");
                            $this->view->profession = $request->getParam("profession_membre");
                            $this->view->religion = $request->getParam("religion_membre");
                            $this->view->pere = $request->getParam("pere_membre");
                            $this->view->mere = $request->getParam("mere_membre");
                            $this->view->quartier_membre = $request->getParam("quartier_membre");
                            $this->view->ville_membre = $request->getParam("ville_membre");
                            $this->view->bp = $request->getParam("bp_membre");
                            $this->view->tel = $request->getParam("tel_membre");
                            $this->view->email = $request->getParam("email_membre");
                            $this->view->portable = $request->getParam("portable_membre");
                                return;
                            }
							
							if($sms_fl->getMotif() != 'FL') {
                                $db->rollBack();
                                $this->view->message = " Le motif pour lequel ce code FL est émis ne correspond pas pour ce type d'operation";
                                $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                            $this->view->bp = $request->getParam("bp_membre");
                            $this->view->tel = $request->getParam("tel_membre");
                            $this->view->email = $request->getParam("email_membre");
                            $this->view->portable = $request->getParam("portable_membre");
                                return;    
                            }
							
							$tfl = new Application_Model_DbTable_EuFl();
                            $fl = new Application_Model_EuFl();
                            $code_fl = 'FL-' . $code;
            
                            $fl->setCode_fl($code_fl)
                               ->setCode_membre($code)
                               ->setCode_membre_morale(NULL)
                               ->setMont_fl($mont_fl)
                               ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                               ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                               ->setId_utilisateur(NULL)
                               ->setCreditcode($sms_fl->getCreditCode());
							   
							 if(($ancien_code =='') || ($ancien_code == NULL)) {		 
				                $fl->setOrigine_fl('N');
							 } else {
                                $fl->setOrigine_fl('A');
                             }  
                             $tfl->insert($fl->toArray());
							
							//Mise à jour du compte general FGFL
                            $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                            $cg_fgfn = new Application_Model_EuCompteGeneral();
                            $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                            if ($result3) {
                                $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                                $cg_mapper->update($cg_fgfn);
                            } else {
                                $cg_fgfn->setCode_compte('FL')
                                        ->setIntitule('Frais de licence')
                                        ->setService('E')
                                        ->setCode_type_compte('NN')
                                        ->setSolde($mont_fl);
                                $cg_mapper->save($cg_fgfn);
                            }
                            $compteurfl = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteurfl,$code,NULL, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
            
                            $sms_fl->setDestAccount_Consumed('FL-'.$code)
                                   ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                                   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                            $sms_mapper->update($sms_fl);
							
							$tcartes[0]="TPAGCRPG";
                            $tcartes[1]="TCNCS";
                            $tcartes[2]="TPaNu";
                            $tcartes[3]="TPaR";
                            $tcartes[4]="TR";
                            $tcartes[5]="CAPA";
               
                            $tscartes[0]="TSRPG";
                            $tscartes[1]="TSCNCS";
                            $tscartes[2]="TSPaNu";
                            $tscartes[3]="TSPaR";
                            $tscartes[4]="TSCAPA";
							
							for($i = 0; $i < count($tcartes); $i++) {
                                if($tcartes[$i] == "TCNCS") {
                                    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                                    $type_carte = 'NR';
                                    $res = $map_compte->find($code_compte,$compte);
                                } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA") {
                                    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                                    $type_carte = 'NN';
                                    $res = $map_compte->find($code_compte,$compte);
                                } else  {
                                    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                                    $type_carte = 'NB';
                                    $res = $map_compte->find($code_compte,$compte);
                                }
                    
                                if(!$res) {
                                    $compte->setCode_cat($tcartes[$i])
                                           ->setCode_compte($code_compte)
                                           ->setCode_membre($code)
                                           ->setCode_membre_morale(NULL)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tcartes[$i])
                                           ->setSolde(0);
                                    $map_compte->save($compte);
                                }
                            }
							
							for($j = 0; $j < count($tscartes); $j++) {
                                if($tscartes[$j] == "TSCNCS") {
                                    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                                    $type_carte = 'NR';
                                    $res = $map_compte->find($code_comptets,$compte);
                                } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA") {
                                    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                                    $type_carte = 'NN';
                                    $res = $map_compte->find($code_comptets,$compte);
                                } else {
                                    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                                    $type_carte = 'NB';
                                    $res = $map_compte->find($code_comptets,$compte);
                                }     
                                if(!$res) {
                                    $compte->setCode_cat($tscartes[$j])
                                           ->setCode_compte($code_comptets)
                                           ->setCode_membre($code)
                                           ->setCode_membre_morale(NULL)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tscartes[$j])
                                           ->setSolde(0);
                                    $map_compte->save($compte);   
                                } 
                            }
				        }  else {   
                            $this->view->message = "Erreur d'éxecution: Le code FL est inexistant !!!";
                            $db->rollback();
                            $this->view->nom_membre = $request->getParam("nom_membre");
                            $this->view->prenom_membre = $request->getParam("prenom_membre");
                            $this->view->sexe = $request->getParam("sexe_membre");
                            $this->view->sitfam = $request->getParam("sitfam_membre");
                            $this->view->datnais = $request->getParam("date_nais_membre");
                            $this->view->nation = $request->getParam("nationalite_membre");
                            $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                            $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                            $this->view->formation = $request->getParam("formation");
                            $this->view->profession = $request->getParam("profession_membre");
                            $this->view->religion = $request->getParam("religion_membre");
                            $this->view->pere = $request->getParam("pere_membre");
                            $this->view->mere = $request->getParam("mere_membre");
                            $this->view->quartier_membre = $request->getParam("quartier_membre");
                            $this->view->ville_membre = $request->getParam("ville_membre");
                            $this->view->bp = $request->getParam("bp_membre");
                            $this->view->tel = $request->getParam("tel_membre");
                            $this->view->email = $request->getParam("email_membre");
                            $this->view->portable = $request->getParam("portable_membre");
                            return;  
					    }
						
						
						if($code_fkps != "") {
						    $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
							if ($sms_fkps == NULL) {
                                $db->rollback();
                                $this->view->message = 'Le code FKPS [' . $code_fkps . ']  est  invalide !!!';
                                $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;
                            }
							
							if($sms_fkps->getMotif() != 'FCPS') {
                                $db->rollBack();
                                $this->view->message = " Le motif pour lequel ce code FKPS est émis ne correspond pas pour ce type d'operation";
                                $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;    
                            }
							
							$carte = new Application_Model_EuCartes();
                            $t_carte = new Application_Model_DbTable_EuCartes();
                            $id_demande = $carte->findConuter() + 1;
                            $carte->setId_demande($id_demande)
                                  ->setCode_cat($tcartes[0])
                                  ->setCode_membre($code)
                                  ->setMont_carte($mont_cps)
                                  ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                                  ->setLivrer(0)
                                  ->setCode_Compte("NB-".$tcartes[0]."-".$code)
                                  ->setImprimer(0)
                                  ->setCardPrintedDate('')
                                  ->setCardPrintedIDDate(0)
                                  ->setId_utilisateur(NULL);
							if(($ancien_code =='') || ($ancien_code == NULL)) {		 
				               $carte->setOrigine_fkps('N');
							} else {
                               $carte->setOrigine_fkps('A');
                            }	  
                            $t_carte->insert($carte->toArray()); 
                            $compteurcps = $mapper_op->findConuter() + 1; 
                            Util_Utils::addOperation($compteurcps, $code,NULL, NULL, $mont_cps, NULL, 'Frais de CPS', 'CPS', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), NULL);
                            $sms_fkps->setDestAccount_Consumed('CPS-'.$code)
                                     ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                                     ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                            $sms_mapper->update($sms_fkps);
						}  
						
/////////////////////////////////////////////////////////////						
						
			if(isset($souscription->souscription_id) && $souscription->souscription_id > 0){			
						
//////////////////////////////////////////////////////////
$id_souscription = $souscription->souscription_id;
		
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id_souscription, $souscription);
		
		
		
		
//////////////////////////////////////////
if($souscription->souscription_membreasso != 1 && $souscription->souscription_membreasso != 0){
        $membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find($souscription->souscription_membreasso, $membreasso);
			
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find($membreasso->membreasso_association, $association);
		$code_agence = $association->code_agence;
		
        $recubancaire = new Application_Model_EuRecubancaire();
        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
        $cumul_recubancaire = $recubancaire_mapper->findCumul($souscription->souscription_id);
        //$cumul_recubancaire = 0;
		
		if($cumul_recubancaire > 0){
		
		if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			/*if($souscription->souscription_type == "1"){
			$partagea_montant = floor(($cumul_recubancaire / 100 * 10) / 2);
				}else{
			$partagea_montant = floor(($cumul_recubancaire / 100 * 5) / 2);
					}*/
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}else{
			
			/*if($souscription->souscription_type == "1"){
			$partagea_montant = floor($cumul_recubancaire / 100 * 10);
				}else{
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
					}*/
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association($membreasso->membreasso_association);
            $partagea->setPartagea_souscription($souscription->souscription_id);
            $partagea->setPartagea_montant($partagea_montant * 0.75);
            $partagea->setPartagea_montant_utilise(0);
            $partagea->setPartagea_montant_solde($partagea_montant * 0.75);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////

        $partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso($membreasso->membreasso_id);
            $partagem->setPartagem_souscription($souscription->souscription_id);
            $partagem->setPartagem_montant($partagea_montant * 0.25);
            $partagem->setPartagem_montant_utilise(0);
            $partagem->setPartagem_montant_solde($partagea_montant * 0.25);
            $partagem_mapper->save($partagem);
			
//////////////////////////////////////////

}
		
			}
				
						
					}
						
						
/////////////////////////////////////////////////////////////						
						
						$compteur = Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP ! Votre numero de membre est: " . $code ."  Votre Code Secret est : " .$_POST["codesecret"]); 
                        $db->commit();
						$this->view->message = "Ouverture de compte marchand bien effectuée ...";
						
				    }  catch (Exception $exc) {
                        $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();
                        $this->view->nom_membre = $request->getParam("nom_membre");
                        $this->view->prenom_membre = $request->getParam("prenom_membre");
                        $this->view->sexe = $request->getParam("sexe_membre");
                        $this->view->sitfam = $request->getParam("sitfam_membre");
                        $this->view->datnais = $request->getParam("date_nais_membre");
                        $this->view->nation = $request->getParam("nationalite_membre");
                        $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                        $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                        $this->view->formation = $request->getParam("formation");
                        $this->view->profession = $request->getParam("profession_membre");
                        $this->view->religion = $request->getParam("religion_membre");
                        $this->view->pere = $request->getParam("pere_membre");
                        $this->view->mere = $request->getParam("mere_membre");
                        $this->view->quartier_membre = $request->getParam("quartier_membre");
                        $this->view->ville_membre = $request->getParam("ville_membre");
                        $this->view->bp = $request->getParam("bp_membre");
                        $this->view->tel = $request->getParam("tel_membre");
                        $this->view->email = $request->getParam("email_membre");
                        $this->view->portable = $request->getParam("portable_membre");
                        return;
                    }
		    } else {  
			    $this->view->message = "Champs * obligatoire ..."; 
                $this->view->nom_membre = $request->getParam("nom_membre");
                $this->view->prenom_membre = $request->getParam("prenom_membre");
                $this->view->sexe = $request->getParam("sexe_membre");
                $this->view->sitfam = $request->getParam("sitfam_membre");
                $this->view->datnais = $request->getParam("date_nais_membre");
                $this->view->nation = $request->getParam("nationalite_membre");
                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                $this->view->formation = $request->getParam("formation");
                $this->view->profession = $request->getParam("profession_membre");
                $this->view->religion = $request->getParam("religion_membre");
                $this->view->pere = $request->getParam("pere_membre");
                $this->view->mere = $request->getParam("mere_membre");
                $this->view->quartier_membre = $request->getParam("quartier_membre");
                $this->view->ville_membre = $request->getParam("ville_membre");
                $this->view->bp = $request->getParam("bp_membre");
                $this->view->tel = $request->getParam("tel_membre");
                $this->view->email = $request->getParam("email_membre");
                $this->view->portable = $request->getParam("portable_membre");				
			}
		}	
	}
	





	
	public function enrolementpmsms2Action() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

		$request = $this->getRequest ();
		if ($request->isPost ()) {
	        if (isset($_POST['code_fs']) && $_POST['code_fs']!="" 
			&& isset($_POST['code_fl']) && $_POST['code_fl']!="" 
			&& isset($_POST['code_type_acteur']) && $_POST['code_type_acteur']!="" 
			&& isset($_POST['raison_sociale']) && $_POST['raison_sociale']!="" 
			&& isset($_POST['num_registre_membre']) && $_POST['num_registre_membre']!="" 
			&& isset($_POST['code_statut']) && $_POST['code_statut']!="" 
			&& isset($_POST['code_rep']) && $_POST['code_rep']!="" 
			&& isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" 
			&& isset($_POST['ville_membre']) && $_POST['ville_membre']!="" 
			&& isset($_POST['portable_membre']) && $_POST['portable_membre']!="" 
			&& isset($_POST['id_pays']) && $_POST['id_pays']!="" 
			&& isset($_POST['code_agence']) && $_POST['code_agence']!="") {
						
                $id_utilisateur_acnev = 1;
                $id_utilisateur_filiere = 2;
                $id_utilisateur_technopole = 3;
	
			    $utilisateur = NULL;
                //$groupe = $user->code_groupe;
                $code_agence = $request->getParam("code_agence");
                $code_zone = substr($_POST['code_agence'], 0, 3);
                $id_pays = $_POST['id_pays'];
                $groupe = NULL;

                $table = new Application_Model_DbTable_EuActeur();
                $selection = $table->select();
                $selection->where('code_membre like ?',$code_agence.'%');
                $selection->where('type_acteur like ?','gac_surveillance');
                $resultat = $table->fetchAll($selection);
                $trouvacteursur = $resultat->current();
                $code_acteur = $trouvacteursur->code_acteur;
                $acteur      =  $code_acteur;
           
                $fs = Util_Utils::getParametre('FS','valeur');
                $mont_fl = Util_Utils::getParametre('FL','valeur');
                $fcps = Util_Utils::getParametre('FKPS','valeur');
           
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $code_fs = $request->getParam("code_fs");
                $code_fl = $request->getParam("code_fl");
                $code_fkps = $request->getParam("code_fkps");
				$ancien_code = '';
         
                $membre = new Application_Model_EuMembreMorale();
                $mapper = new Application_Model_EuMembreMoraleMapper();
                $sms_mapper = new Application_Model_EuSmsmoneyMapper();
		
                $mapper_op = new Application_Model_EuOperationMapper();
                $compte = new Application_Model_EuCompte();
                $map_compte = new Application_Model_EuCompteMapper();
				
				$souscription = new Application_Model_EuSouscription();
                $souscription_mapper = new Application_Model_EuSouscriptionMapper();
				
                $tcartes = array();
                $tscartes = array();
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
				try {
				    if($code_fs !="") {
					    $sms_fs = $sms_mapper->findByCreditCode($code_fs);
						$code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == NULL) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }							
							
///////////////////////////////preinscription morale						
$preinsc_mapper = new Application_Model_EuPreinscriptionMoraleMapper();
$compteur_preinscriptionmorale = $preinsc_mapper->findConuter() + 1;         
          
                        $preinscriptionmorale = new Application_Model_EuPreinscriptionMorale();
                        $mapper_preinscriptionmorale = new Application_Model_EuPreinscriptionMoraleMapper();
            
                        $preinscriptionmorale->setId_preinscription_morale($compteur_preinscriptionmorale)
                               ->setCode_type_acteur($request->getParam("code_type_acteur"))
                               ->setCode_statut($request->getParam("code_statut"))
                               ->setRaison_sociale($request->getParam("raison_sociale"))
                               ->setId_pays($request->getParam("id_pays"))
                               ->setNum_registre_membre($request->getParam("num_registre_membre"))
                               ->setDomaine_activite($request->getParam("domaine_activite"))
                               ->setSite_web($request->getParam("site_web"))
                               ->setQuartier_membre($request->getParam("quartier_membre"))
                               ->setVille_membre($request->getParam("ville_membre"))
                               ->setCategorie_membre($request->getParam("categorie_membre"))
                               ->setBp_membre($request->getParam("bp_membre"))
                               ->setTel_membre($request->getParam("tel_membre"))
                               ->setEmail_membre($request->getParam("email_membre"))
                               ->setPortable_membre($request->getParam("portable_membre"))
                               ->setHeure_inscription($date_idd->toString('HH:mm:ss'))
                               ->setDate_inscription($date_idd->toString('yyyy-MM-dd'))
                               ->setCode_rep($request->getParam("code_rep"))
                               ->setCode_membre_morale(NULL)
                               ->setNumero_contrat(null)
                               ->setNumero_agrement_filiere(null)
                               ->setNumero_agrement_acnev(null)
                               ->setNumero_agrement_technopole(null)
                               ->setCode_fs($request->getParam("code_fs"))
                               ->setCode_fl($request->getParam("code_fl"))
                               ->setCode_fkps($request->getParam("code_fkps"))
							   ->setCode_agence($code_agence)
				               ->setPublier(1)
                ;
                        $mapper_preinscriptionmorale->save($preinscriptionmorale);/**/


//////validation acnev
								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
												$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
												$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
												$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_acnev);
												$validation_quittance->setValidation_quittance_preinscription_morale($compteur_preinscriptionmorale);
												$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
												$validation_quittance->setPublier(1);
												$validation_quittance_mapper->save($validation_quittance);

          
//////validation filere
								$preinscriptionmorale = new Application_Model_EuPreinscriptionMorale();
								$preinscriptionmoraleM = new Application_Model_EuPreinscriptionMoraleMapper();
								$preinscriptionmoraleM->find($compteur_preinscriptionmorale, $preinscriptionmorale);
								
								$preinscriptionmorale->setPublier(2);
								$preinscriptionmoraleM->update($preinscriptionmorale);


								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
												$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
												$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
												$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_filiere);
												$validation_quittance->setValidation_quittance_preinscription_morale($compteur_preinscriptionmorale);
												$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
												$validation_quittance->setPublier(1);
												$validation_quittance_mapper->save($validation_quittance);
							
//////validation technopole
								$preinscriptionmorale = new Application_Model_EuPreinscriptionMorale();
								$preinscriptionmoraleM = new Application_Model_EuPreinscriptionMoraleMapper();
								$preinscriptionmoraleM->find($compteur_preinscriptionmorale, $preinscriptionmorale);
								
								$preinscriptionmorale->setPublier(3);
								$preinscriptionmoraleM->update($preinscriptionmorale);


								$validation_quittance = new Application_Model_EuValidationQuittance();
								$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
												$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
												$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
												$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_technopole);
												$validation_quittance->setValidation_quittance_preinscription_morale($compteur_preinscriptionmorale);
												$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
												$validation_quittance->setPublier(1);
												$validation_quittance_mapper->save($validation_quittance);
							
							
////////////////////////////////////////////							
														
							
						
                        $compteur = $mapper_op->findConuter() + 1;
						$membre->setId_filiere(null);
                        $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($request->getParam("code_type_acteur"));
                        $membre->setCode_statut($request->getParam("code_statut"));
                        $membre->setRaison_sociale($request->getParam("raison_sociale"));
                        $membre->setId_pays($request->getParam("id_pays"));
                        $membre->setNum_registre_membre($request->getParam("num_registre_membre"));
                        $membre->setDomaine_activite($request->getParam("domaine_activite"));
                        $membre->setSite_web($request->getParam("site_web"));
                        $membre->setQuartier_membre($request->getParam("quartier_membre"));
                        $membre->setVille_membre($request->getParam("ville_membre"));
                        $membre->setBp_membre($request->getParam("bp_membre"));
                        $membre->setTel_membre($request->getParam("tel_membre"));
                        $membre->setEmail_membre($request->getParam("email_membre"));
                        $membre->setPortable_membre($request->getParam("portable_membre"));
                        $membre->setId_utilisateur(NULL);
                        $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('O');
                        $membre->setEtat_membre(NULL);
                        $mapper->save($membre);
						
						
								
								
					    /////////////
						$preinscriptionmorale = new Application_Model_EuPreinscriptionMorale();
						$preinscriptionmoraleM = new Application_Model_EuPreinscriptionMoraleMapper();
						$preinscriptionmoraleM->find($compteur_preinscriptionmorale, $preinscriptionmorale);
								
						$preinscriptionmorale->setCode_membre_morale($code);
						$preinscriptionmoraleM->update($preinscriptionmorale);
								
								
						
						// insertion dans la table eu_code_activation
				        $m_codeactivation = new Application_Model_EuCodeActivationMapper();
				        $codeactivation = new Application_Model_EuCodeActivation();
						
						$m_dvente = new Application_Model_EuDepotVenteMapper();
				        $dvente = new Application_Model_EuDepotVente();
								   
						$findcode = $m_codeactivation->findbycode($code_fs,$code_fl,$code_fkps);
						if($findcode != NULL)  {
                            $findcode = $findcode[0];
							$id_souscription = $findcode->souscription_id;
							$findsouscription = $souscription_mapper->find($id_souscription,$souscription);
							$ancien_code = $souscription->souscription_ancien_membre;
							//$findsousdv = $m_dvente->findbysouscriptionmembre($id_souscription);
							//$id_depot = $findsousdv->id_depot;
							//$trouvedepot = $m_dvente->find($id_depot,$dvente);
							$trouvecode = $m_codeactivation->find($findcode->id_code_activation,$codeactivation);
							$codeactivation->setCode_membre($code);
							$m_codeactivation->update($codeactivation);
                            //$dvente->setCode_membre($code);
                            //$m_dvente->update($dvente);
							
						} else {
							$this->view->message = "Erreur d'éxecution: Les codes d\'activation ne sont liés à aucune quittance de souscription !!!";
                            $db->rollback();
                            $this->view->code_type_acteur = $request->getParam("code_type_acteur");
                            $this->view->code_statut = $request->getParam("code_statut");
                            $this->view->raison_sociale = $request->getParam("raison_sociale");
                            $this->view->domaine_activite = $request->getParam("domaine_activite");
                            $this->view->site_web = $request->getParam("site_web");
                            $this->view->quartier_membre = $request->getParam("quartier_membre");
                            $this->view->ville_membre = $request->getParam("ville_membre");
                            $this->view->bp = $request->getParam("bp_membre");
                            $this->view->tel = $request->getParam("tel_membre");
                            $this->view->email = $request->getParam("email_membre");
                            $this->view->id_pays = $request->getParam("id_pays");
                            $this->view->portable = $request->getParam("portable_membre");
                            $this->view->registre = $request->getParam("num_registre_membre");
                            return;	
					    }
						
						$mem = new Application_Model_EuMembreMorale();
                        $mem_mapper = new Application_Model_EuMembreMoraleMapper();
					    $findmem = $mem_mapper->find($code,$mem);
							
						if(($ancien_code =='') || ($ancien_code == NULL)) {
							  $mem->setEtat_membre('N');
						} else {
						      if(substr($ancien_code,-1,1) == 'P') {
							     $this->view->message = "Erreur d'éxecution: Ce membre n\'est pas autorisé à effectuer cette opération !!!";
                                 $db->rollback();
                                 $this->view->code_type_acteur = $request->getParam("code_type_acteur");
                                 $this->view->code_statut = $request->getParam("code_statut");
                                 $this->view->raison_sociale = $request->getParam("raison_sociale");
                                 $this->view->domaine_activite = $request->getParam("domaine_activite");
                                 $this->view->site_web = $request->getParam("site_web");
                                 $this->view->quartier_membre = $request->getParam("quartier_membre");
                                 $this->view->ville_membre = $request->getParam("ville_membre");
                                 $this->view->bp = $request->getParam("bp_membre");
                                 $this->view->tel = $request->getParam("tel_membre");
                                 $this->view->email = $request->getParam("email_membre");
                                 $this->view->id_pays = $request->getParam("id_pays");
                                 $this->view->portable = $request->getParam("portable_membre");
                                 $this->view->registre = $request->getParam("num_registre_membre");
                                 return;
							  }
                              $mem->setEtat_membre('A');
							  //Mise à jour de la table morale
                              $m_mapper = new Application_Model_MoraleMapper();
                              $m = new Application_Model_Morale();
                              $rep = $m_mapper->find($ancien_code,$m);
                              if ($rep == true) {      
                                $m->setEtat_contrat(1)
                                  ->setCode_membre($code);
                                $m_mapper->update($m);      
                              }
							  
							 // Mise à jour de la table eu_ancien_membre
                             $mmcnp_mapper = new Application_Model_EuAncienMembreMapper();
                             $mmcnp = new Application_Model_EuAncienMembre();
                             $repmcnp = $mmcnp_mapper->find($ancien_code,$mmcnp);
                             if ($repmcnp == true) {      
                                $mmcnp->setEtat_contrat(1)
                                      ->setCode_membre($code);
                                $mmcnp_mapper->update($mmcnp);      
                             }  
                         }							
						 $mem_mapper->update($mem);
						
						
						
						
						// eu_operation
                        Util_Utils::addOperation($compteur,NULL,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), NULL);
             
				        //insertion dans la table eu_representation
                        $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
                        $rep->setCode_membre_morale($code)
                            ->setCode_membre($_POST['code_rep'])
                            ->setTitre("Representant")
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
                            ->setId_utilisateur(NULL)
                            ->setEtat('inside');
                        $rep_mapper->save($rep);
						
						$cb_mapper = new Application_Model_EuCompteBancaireMapper();
                        $cb = new Application_Model_EuCompteBancaire();
						for($i = 0; $i < count($_POST['code_banque']); $i++) {
                            $cb_compteur = $cb_mapper->findConuter() + 1;         
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre(NULL)
                               ->setCode_membre_morale($code)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i]);
                            $cb_mapper->save($cb);
                        }
						
						
						//insertion dans la table eu_utilisateur
                        $user_mapper = new Application_Model_EuUtilisateurMapper();
                        $userin = new Application_Model_EuUtilisateur();
                        $membre_mapper = new Application_Model_EuMembreMapper();
                        $membrein = new Application_Model_EuMembre();         
                        $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                        $id_user = $user_mapper->findConuter() + 1;
          
                        $userin->setId_utilisateur($id_user);
                        $userin->setId_utilisateur_parent($utilisateur); 
                        $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                        $userin->setNom_utilisateur($membrein->getNom_membre());
                        $userin->setLogin($code);
                        $userin->setPwd(md5($_POST["codesecret"]));
                        $userin->setDescription(NULL);
                        $userin->setUlock(0);
                        $userin->setCh_pwd_flog(0);
                        $code_type_acteur = $_POST["code_type_acteur"];
                        $userin->setCode_groupe('personne_morale');
                        $userin->setCode_gac_filiere(null);
                        $userin->setCode_groupe_create('personne_morale');
                        $userin->setConnecte(0);
                        $userin->setCode_agence($code_agence);
                        $userin->setCode_secteur(NULL);
                        $userin->setCode_zone($code_zone);
                        $userin->setId_filiere(null);
                        $userin->setCode_acteur($acteur);
                        $userin->setCode_membre($code);
                        $userin->setId_pays($id_pays);        
                        $user_mapper->save($userin);
						
						// Mise à jour de la table eu_contrat
                        $contrat = new Application_Model_EuContrat();
                        $mapper_contrat = new Application_Model_EuContratMapper();
                        $id_contrat = $mapper_contrat->findConuter() + 1;
          
                        $contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                        $contrat->setNature_contrat('numeraire');
                        $contrat->setId_type_contrat(7);
                        $contrat->setId_type_creneau(null);
                        $contrat->setId_type_acteur(NULL);
                        $contrat->setId_pays($_POST['id_pays']);
                        $contrat->setId_utilisateur(NULL);
                        $contrat->setFiliere(''); 
                        $mapper_contrat->save($contrat);
						
						$tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre_morale($code)
                                 ->setCode_membre(NULL)
                                 ->setCode_fs('FS-' . $code)
                                 ->setCreditcode($sms_fs->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                 ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                 ->setId_utilisateur($utilisateur)
                                 ->setMont_fs($fs);
						if(($ancien_code =='') || ($ancien_code == NULL)) {		 
						   $fs_model->setOrigine_fs('N');
						} else {
                           $fs_model->setOrigine_fs('A');
                        }						
                        $tab_fs->insert($fs_model->toArray());
            
          
                        $sms_fs->setDestAccount_Consumed('NB-TFS-' . $code)
                               ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms_fs);
						
			        } else {   
                        $this->view->message = "Erreur d'éxecution: Le code FS est inexistant !!!";
                        $db->rollback();
						$this->view->code_type_acteur = $request->getParam("code_type_acteur");
                        $this->view->code_statut = $request->getParam("code_statut");
                        $this->view->raison_sociale = $request->getParam("raison_sociale");
                        $this->view->domaine_activite = $request->getParam("domaine_activite");
                        $this->view->site_web = $request->getParam("site_web");
                        $this->view->quartier_membre = $request->getParam("quartier_membre");
                        $this->view->ville_membre = $request->getParam("ville_membre");
                        $this->view->bp = $request->getParam("bp_membre");
                        $this->view->tel = $request->getParam("tel_membre");
                        $this->view->email = $request->getParam("email_membre");
                        $this->view->id_pays = $request->getParam("id_pays");
                        $this->view->portable = $request->getParam("portable_membre");
                        $this->view->registre = $request->getParam("num_registre_membre");
                        return;  
					}
					
					
					
					
					
					if($code_fl !="") {
					    
						$sms_fl = $sms_mapper->findByCreditCode($code_fl);
                        $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
						
						$fl->setCode_fl($code_fl)
                           ->setCode_membre(NULL)
                           ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur(NULL)
                           ->setCreditcode($sms_fl->getCreditCode());
						   
						if(($ancien_code =='') || ($ancien_code == NULL)) {		 
						   $fl->setOrigine_fl('N');
						} else {
                           $fl->setOrigine_fl('A');
                        }   
				  
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general FGFL
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                            $cg_mapper->update($cg_fgfn);
                        } else  {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
				
                        $compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,NULL,$code, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
            
                        $sms_fl->setDestAccount_Consumed('FL-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms_fl);
						
						//$tcartes[0]="TPAGCP";
                        $tcartes[1]="TCNCSEI";
                        $tcartes[2]="TPAGCI";
                        $tcartes[3]="TIR";
                        $tcartes[4]="TR";
                        $tcartes[5]="TPaNu";
                        $tcartes[6]="TPaR";
                        $tcartes[7]="TFS";
                        $tcartes[8]="TPN";
                        $tcartes[9]="TIB";
                        $tcartes[10]="TPaNu";
                        $tcartes[11]="TIN";
                        $tcartes[12]="CAPA";
                        $tcartes[13]="TMARGE";
                        //$tcartes[14]="TRE";
            
                        for($i = 1; $i < count($tcartes); $i++) {
                            if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                                $type_carte = 'NR';
                                $res = $map_compte->find($code_compte,$compte);
                            } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE" || $tcartes[$i] == "TMARGE") {
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                                $type_carte = 'NN';
                                $res = $map_compte->find($code_compte,$compte);
                            } elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
                                $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                                $type_carte = 'NB';
                                $res = $map_compte->find($code_compte,$compte);
                            } elseif($tcartes[$i] == "TIN") {
                                $tcartes[$i] = "TI"; 
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                                $type_carte = 'NN';
                                $res = $map_compte->find($code_compte,$compte);
                            } elseif($tcartes[$i] == "TIR") {
                                $tcartes[$i] = "TI"; 
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                                $type_carte = 'NR';
                                $res = $map_compte->find($code_compte,$compte);
                            } elseif($tcartes[$i] == "TIB") {
                                $tcartes[$i] = "TI";
                                $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                                $type_carte = 'NB';
                                $res = $map_compte->find($code_compte,$compte);
                            }
                            if(!$res) {
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(NULL)
                                       ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
                                $map_compte->save($compte); 
                            }
                  
                        }
						
						for($j = 1; $j < count($tscartes); $j++) {  
                            if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                                $type_carte = 'NR';
                                $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSMARGE" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                                $type_carte = 'NN';
                                $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
                                $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                                $type_carte = 'NB';
                                $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIN") {
                                $tscartes[$j] = "TSI"; 
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                                $type_carte = 'NN';
                                $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIR") {
                                $tscartes[$j] = "TSI"; 
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                                $type_carte = 'NR';
                                $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIB") {
                                $tscartes[$j] = "TSI";
                                $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                                $type_carte = 'NB';
                                $res = $map_compte->find($code_comptets,$compte);
                            }
                            if(!$res) {
                                $compte->setCode_cat($tscartes[$j])
                                       ->setCode_compte($code_comptets)
                                       ->setCode_membre(NULL)
                                       ->setCode_membre_morale($code)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tscartes[$j])
                                       ->setSolde(0);
                                $map_compte->save($compte);
                            }
                  
                        }
                    }  else {   
                        $this->view->message = "Erreur d'éxecution: Le code FL est inexistant !!!";
                        $db->rollback();
						$this->view->code_type_acteur = $request->getParam("code_type_acteur");
                        $this->view->code_statut = $request->getParam("code_statut");
                        $this->view->raison_sociale = $request->getParam("raison_sociale");
                        $this->view->domaine_activite = $request->getParam("domaine_activite");
                        $this->view->site_web = $request->getParam("site_web");
                        $this->view->quartier_membre = $request->getParam("quartier_membre");
                        $this->view->ville_membre = $request->getParam("ville_membre");
                        $this->view->bp = $request->getParam("bp_membre");
                        $this->view->tel = $request->getParam("tel_membre");
                        $this->view->email = $request->getParam("email_membre");
                        $this->view->id_pays = $request->getParam("id_pays");
                        $this->view->portable = $request->getParam("portable_membre");
                        $this->view->registre = $request->getParam("num_registre_membre");
                        return;  
					}
					
					if($code_fkps !="") {
					    $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
                        $carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
                        $id_demande = $carte->findConuter() + 1;
                        $carte->setId_demande($id_demande)
                              ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("NB-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur(NULL);
						if(($ancien_code =='') || ($ancien_code == NULL)) {		 
						   $carte->setOrigine_fkps('N');
						} else {
                           $carte->setOrigine_fkps('A');
                        }	  
                        $t_carte->insert($carte->toArray());
                             
                        $sms_fkps->setDestAccount_Consumed('CPS-' . $code)
                                 ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                                 ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms_fkps);
			        }
					
					
					
/////////////////////////////////////////////////////////////						
						
			if(isset($souscription->souscription_id) && $souscription->souscription_id > 0){			
//////////////////////////////////////////////////////////
$id_souscription = $souscription->souscription_id;
		
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id_souscription, $souscription);
		
		
		
		
//////////////////////////////////////////
if($souscription->souscription_membreasso != 1 && $souscription->souscription_membreasso != 0){
        $membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find($souscription->souscription_membreasso, $membreasso);
			
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find($membreasso->membreasso_association, $association);
		$code_agence = $association->code_agence;
		
        $recubancaire = new Application_Model_EuRecubancaire();
        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
        $cumul_recubancaire = $recubancaire_mapper->findCumul($souscription->souscription_id);
        //$cumul_recubancaire = 0;
		
		if($cumul_recubancaire > 0){
		
		if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			/*if($souscription->souscription_type == "1"){
			$partagea_montant = floor(($cumul_recubancaire / 100 * 10) / 2);
				}else{
			$partagea_montant = floor(($cumul_recubancaire / 100 * 5) / 2);
					}*/
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}else{
			
			/*if($souscription->souscription_type == "1"){
			$partagea_montant = floor($cumul_recubancaire / 100 * 10);
				}else{
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
					}*/
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association($membreasso->membreasso_association);
            $partagea->setPartagea_souscription($souscription->souscription_id);
            $partagea->setPartagea_montant($partagea_montant * 0.75);
            $partagea->setPartagea_montant_utilise(0);
            $partagea->setPartagea_montant_solde($partagea_montant * 0.75);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////

        $partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso($membreasso->membreasso_id);
            $partagem->setPartagem_souscription($souscription->souscription_id);
            $partagem->setPartagem_montant($partagea_montant * 0.25);
            $partagem->setPartagem_montant_utilise(0);
            $partagem->setPartagem_montant_solde($partagea_montant * 0.25);
            $partagem_mapper->save($partagem);
			
//////////////////////////////////////////

}
		
			}
				
						
						
						}
						
/////////////////////////////////////////////////////////////						
					
					
					
					$compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP ! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
			
			    } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->code_type_acteur = $request->getParam("code_type_acteur");
                    $this->view->code_statut = $request->getParam("code_statut");
                    $this->view->raison_sociale = $request->getParam("raison_sociale");
                    $this->view->domaine_activite = $request->getParam("domaine_activite");
                    $this->view->site_web = $request->getParam("site_web");
                    $this->view->quartier_membre = $request->getParam("quartier_membre");
                    $this->view->ville_membre = $request->getParam("ville_membre");
                    $this->view->bp = $request->getParam("bp_membre");
                    $this->view->tel = $request->getParam("tel_membre");
                    $this->view->email = $request->getParam("email_membre");
                    $this->view->id_pays = $request->getParam("id_pays");
                    $this->view->portable = $request->getParam("portable_membre");
                    $this->view->registre = $request->getParam("num_registre_membre");
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }
	
	        }  else {  
			    $this->view->message = "Champs * obligatoire ...";
                $this->view->code_type_acteur = $request->getParam("code_type_acteur");
                $this->view->code_statut = $request->getParam("code_statut");
                $this->view->raison_sociale = $request->getParam("raison_sociale");
                $this->view->domaine_activite = $request->getParam("domaine_activite");
                $this->view->site_web = $request->getParam("site_web");
                $this->view->quartier_membre = $request->getParam("quartier_membre");
                $this->view->ville_membre = $request->getParam("ville_membre");
                $this->view->bp = $request->getParam("bp_membre");
                $this->view->tel = $request->getParam("tel_membre");
                $this->view->email = $request->getParam("email_membre");
                $this->view->id_pays = $request->getParam("id_pays");
                $this->view->portable = $request->getParam("portable_membre");
                $this->view->registre = $request->getParam("num_registre_membre");				
			}
	    }
	
	}
	
	
	
	



	
	public function activationcapsAction()   {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

		$request = $this->getRequest ();
		if ($request->isPost ()) {
		
		    if (isset($_POST['nom_membre']) && $_POST['nom_membre']!="" 
		        && isset($_POST['sexe_membre']) && $_POST['sexe_membre']!="" 
		        && isset($_POST['nationalite_membre']) && $_POST['nationalite_membre']!="" 
		        && isset($_POST['sitfam_membre']) && $_POST['sitfam_membre']!="" 
		        && isset($_POST['prenom_membre']) && $_POST['prenom_membre']!="" 
		        && isset($_POST['date_nais_membre']) && $_POST['date_nais_membre']!="" 
		        && isset($_POST['lieu_nais_membre']) && $_POST['lieu_nais_membre']!="" 
		        && isset($_POST['nbr_enf_membre']) && $_POST['nbr_enf_membre']!="" 
		        && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" 
		        && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" 
		        && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" 
		        && isset($_POST['profession_membre']) && $_POST['profession_membre']!="" 
		        && isset($_POST['religion_membre']) && $_POST['religion_membre']!="" 
		        && isset($_POST['id_pays']) && $_POST['id_pays']!="" 
		        && isset($_POST['code_agence']) && $_POST['code_agence']!="") {
				
				    $mont_caps = Util_Utils::getParametre('CAPS','valeur');
		            $fs = Util_Utils::getParametre('FS','valeur');
		            $mont_fl = Util_Utils::getParametre('FL','valeur');
		            $fkps = Util_Utils::getParametre('FKPS','valeur');
					
					$place    = new Application_Model_EuOperation();
		            $mapper   = new Application_Model_EuOperationMapper();
	                $membre   = new Application_Model_EuMembre();
	                $m_map    = new Application_Model_EuMembreMapper();
					$membremoral = new Application_Model_EuMembreMorale();
	                $m_mapmoral  = new Application_Model_EuMembreMoraleMapper();
		            $m_caps   = new Application_Model_EuCapsMapper();
                    $caps     = new Application_Model_EuCaps();
		            $dvente   = new Application_Model_EuDepotVente();
		            $m_dvente = new Application_Model_EuDepotVenteMapper();
			
		            $activation   = new Application_Model_EuActivation();
		            $m_activation = new Application_Model_EuActivationMapper();
	                $membretiers = new Application_Model_EuMembretierscode();
		            $m_membretiers = new Application_Model_EuMembretierscodeMapper();
					$souscription = new Application_Model_EuSouscription();
                    $souscription_mapper = new Application_Model_EuSouscriptionMapper();
					
					$date = new Zend_Date(Zend_Date::ISO_8601);
		            $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
					try {
				        //$code_activation = null;
						$code_agence = $request->getParam("code_agence");
						//$categorie = $request->getParam("type_activation");
		                $type_bnp  = 'CAPS';
                        $type_caps = 'CAPSFLFCPS';
			            $id_membretiers  = '';
						$id_depot = '';
			            $souscription_id = '';
			            //$apporteur = '';
						$apporteur = $request->getParam("apporteur");
			            $table = new Application_Model_DbTable_EuActeur();
                        $selection = $table->select();
                        $selection->where('code_membre like ?',$code_agence.'%');
                        $selection->where('type_acteur like ?','gac_surveillance');
                        $resultat = $table->fetchAll($selection);
                        $trouvacteursur = $resultat->current();
                        $code_acteur = $trouvacteursur->code_acteur;
                        $acteur =  $code_acteur;
						
						
						//if($categorie == 'AvecListe') {
						    $code_activation = $request->getParam("code_activation");
						    $tmtc = new Application_Model_DbTable_EuMembretierscode();
		                    $select = $tmtc->select();
                            $select->where('membretierscode_code like ?',$code_activation)
			                       ->where('publier = ?',0);
		                    $result = $tmtc->fetchAll($select);
						
			                if (count($result) > 0) {
			                    $id_membretiers = $results->current()->membretierscode_id;
			                    $souscription_id = $results->current()->membretierscode_souscription;
								$trouvesou = $souscription_mapper->find($souscription_id,$souscription);
								$souscription_id = $souscription->getSouscription_souscription();
			                } else {
			                    $db->rollback();
                                $this->view->message = "Code activation errone";
			                    $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;
			                }
						
						    $lignedvente = $m_dvente->findbysouscriptionmembre($souscription_id);
						    $reste = $mont_caps;
						    if ($lignedvente != NULL) {
							    if($lignedvente->getSolde_depot() >= $reste) {
						            $id_depot = $lignedvente->getId_depot();
							        //$apporteur = $lignedvente->getCode_membre();
				                    $finddvente = $m_dvente->find($id_depot,$dvente);
							
							        //Mise à jour de la table eu_depot_vente
                                    $lignedvente->setSolde_depot($lignedvente->getSolde_depot() - $reste);
						            $lignedvente->setMont_vendu($lignedvente->getMont_vendu() + $reste);
                                    $m_dvente->update($lignedvente);
								
								} else {
								    $db->rollback();
                                    $this->view->message = "Le montant de la souscription est insuffisant ...";
			                        $this->view->nom_membre = $request->getParam("nom_membre");
                                    $this->view->prenom_membre = $request->getParam("prenom_membre");
                                    $this->view->sexe = $request->getParam("sexe_membre");
                                    $this->view->sitfam = $request->getParam("sitfam_membre");
                                    $this->view->datnais = $request->getParam("date_nais_membre");
                                    $this->view->nation = $request->getParam("nationalite_membre");
                                    $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                    $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                    $this->view->formation = $request->getParam("formation");
                                    $this->view->profession = $request->getParam("profession_membre");
                                    $this->view->religion = $request->getParam("religion_membre");
                                    $this->view->pere = $request->getParam("pere_membre");
                                    $this->view->mere = $request->getParam("mere_membre");
                                    $this->view->quartier_membre = $request->getParam("quartier_membre");
                                    $this->view->ville_membre = $request->getParam("ville_membre");
                                    $this->view->bp = $request->getParam("bp_membre");
                                    $this->view->tel = $request->getParam("tel_membre");
                                    $this->view->email = $request->getParam("email_membre");
                                    $this->view->portable = $request->getParam("portable_membre");
                                    return;
								}
						
				            } else {
			                    $db->rollback();
                                $this->view->message = "Ce code d'activation n'est lié à aucune souscription";
			                    $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;
			                }
							
							if(($apporteur == '') || ($apporteur == NULL)) {
							    $db->rollback();
                                $this->view->message = "Le CMFH de la souscription doit activer son compte marchand";
			                    $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;
							}
							
							
							if(substr($apporteur,19,1) == 'P') {
						     $findmembre = $m_map->find($apporteur,$membre);
							 if($findmembre == false) {
							     $db->rollback();
                                 $message = "Le compte marchand du CMFH est introuvable !!!";
                                 $this->view->message = $message;
						         $this->view->nom_membre = $request->getParam("nom_membre");
                                 $this->view->prenom_membre = $request->getParam("prenom_membre");
                                 $this->view->sexe = $request->getParam("sexe_membre");
                                 $this->view->sitfam = $request->getParam("sitfam_membre");
                                 $this->view->datnais = $request->getParam("date_nais_membre");
                                 $this->view->nation = $request->getParam("nationalite_membre");
                                 $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                 $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                 $this->view->formation = $request->getParam("formation");
                                 $this->view->profession = $request->getParam("profession_membre");
                                 $this->view->religion = $request->getParam("religion_membre");
                                 $this->view->pere = $request->getParam("pere_membre");
                                 $this->view->mere = $request->getParam("mere_membre");
                                 $this->view->quartier_membre = $request->getParam("quartier_membre");
                                 $this->view->ville_membre = $request->getParam("ville_membre");
                                 $this->view->bp = $request->getParam("bp_membre");
                                 $this->view->tel = $request->getParam("tel_membre");
                                 $this->view->email = $request->getParam("email_membre");
                                 $this->view->portable = $request->getParam("portable_membre");
				                 return;
							 }
						  }  else {
						     $findmembre = $m_mapmoral->find($apporteur,$membremoral);
							 if($findmembre == false) {
							    $db->rollback();
                                $message = "Le compte marchand du CMFH est introuvable !!!";
                                $this->view->message = $message;
						        $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
				                return;
						     }
						}
							
							
							
						
						//}  
						
						/*else  {
						    $lignedventes = $m_dvente->findbycmfhsansliste();
				            $reste = $mont_caps;
							if ($lignedventes != null) {
				                $lignedvente = $lignedventes[0];
					            $id_depot = $lignedvente->getId_depot();
					            $finddvente = $m_dvente->find($id_depot,$dvente);
						        $apporteur = $lignedvente->getCode_membre();
						        $lignedvente->setSolde_depot($lignedvente->getSolde_depot() - $reste);
						        $lignedvente->setMont_vendu($lignedvente->getMont_vendu() + $reste);
                                $m_dvente->update($lignedvente);
				            } else {
			                    $db->rollback();
                                $this->view->message = "Aucun  CMFH ne dispose de code d'activation";
			                    $this->view->nom_membre = $request->getParam("nom_membre");
                                $this->view->prenom_membre = $request->getParam("prenom_membre");
                                $this->view->sexe = $request->getParam("sexe_membre");
                                $this->view->sitfam = $request->getParam("sitfam_membre");
                                $this->view->datnais = $request->getParam("date_nais_membre");
                                $this->view->nation = $request->getParam("nationalite_membre");
                                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                                $this->view->formation = $request->getParam("formation");
                                $this->view->profession = $request->getParam("profession_membre");
                                $this->view->religion = $request->getParam("religion_membre");
                                $this->view->pere = $request->getParam("pere_membre");
                                $this->view->mere = $request->getParam("mere_membre");
                                $this->view->quartier_membre = $request->getParam("quartier_membre");
                                $this->view->ville_membre = $request->getParam("ville_membre");
                                $this->view->bp = $request->getParam("bp_membre");
                                $this->view->tel = $request->getParam("tel_membre");
                                $this->view->email = $request->getParam("email_membre");
                                $this->view->portable = $request->getParam("portable_membre");
                                return;
			                }
						
						}*/
						
						
						$count = $mapper->findConuter() + 1;
                        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                        $date_deb = clone $date_fin;
				
				        $place->setId_operation($count)
                              ->setDate_op($date->toString('yyyy-MM-dd'))
                              ->setHeure_op($date->toString('HH:mm:ss'))
                              ->setId_utilisateur(null);
						if(substr($apporteur,19,1) == 'P') {	  
                          $place->setCode_membre($apporteur)
						        ->setCode_membre_morale(NULL);
						} else {   
                          $place->setCode_membre_morale($apporteur)
						        ->setCode_membre(NULL);
						}   
						
                        $place->setMontant_op($mont_caps)
                              ->setCode_produit('CAPS')
                              ->setLib_op('Enrolement')
                              ->setType_op($type_bnp)
                              ->setCode_cat('TCAPS');
			            $mapper->save($place);
				
		                /*$place->setId_operation($count)
                              ->setDate_op($date->toString('yyyy-MM-dd'))
                              ->setHeure_op($date->toString('HH:mm:ss'))
                              ->setId_utilisateur(null)
                              ->setCode_membre($apporteur)
                              ->setCode_membre_morale(null)
                              ->setMontant_op($mont_caps)
                              ->setCode_produit('CAPS')
                              ->setLib_op('Enrolement')
                              ->setType_op($type_bnp)
                              ->setCode_cat('TCAPS');
			            $mapper->save($place);*/
				
			            $id = $type_bnp . $apporteur . $date_deb->toString('yyyyMMddHHmmss');
			            $code = $m_map->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'P';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'P';
                        }
			
			            $date_nais = new Zend_Date($request->getParam("date_nais_membre"));	
                        $date_id = new Zend_Date(Zend_Date::ISO_8601);
                        $date_idd = clone $date_id;
						
						if ($date_nais >= $date_idd) {
                            $this->view->message = "Erreur d'execution: La date de naissance doit etre antérieure à la date actuelle !!!";
                            $db->rollback();
                            $this->view->nom_membre = $request->getParam("nom_membre");
                            $this->view->prenom_membre = $request->getParam("prenom_membre");
                            $this->view->sexe = $request->getParam("sexe_membre");
                            $this->view->sitfam = $request->getParam("sitfam_membre");
                            $this->view->datnais = $request->getParam("date_nais_membre");
                            $this->view->nation = $request->getParam("nationalite_membre");
                            $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                            $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                            $this->view->formation = $request->getParam("formation");
                            $this->view->profession = $request->getParam("profession_membre");
                            $this->view->religion = $request->getParam("religion_membre");
                            $this->view->pere = $request->getParam("pere_membre");
                            $this->view->mere = $request->getParam("mere_membre");
                            $this->view->quartier_membre = $request->getParam("quartier_membre");
                            $this->view->ville_membre = $request->getParam("ville_membre");
                            $this->view->bp = $request->getParam("bp_membre");
                            $this->view->tel = $request->getParam("tel_membre");
                            $this->view->email = $request->getParam("email_membre");
                            $this->view->portable = $request->getParam("portable_membre");
                            return;
                        }
						
						/////////////////////////////// preinscription ///////////////////////////////////////////////						

                        $preinsc_mapper = new Application_Model_EuPreinscriptionMapper();
                        $compteur_preinscription = $preinsc_mapper->findConuter() + 1;         
          
                        $preinscription = new Application_Model_EuPreinscription();
                        $mapper = new Application_Model_EuPreinscriptionMapper();
            
                        $preinscription->setId_preinscription($compteur_preinscription)
                                       ->setNom_membre($request->getParam("nom_membre"))
						               ->setCode_agence($code_agence)
                                       ->setPrenom_membre($request->getParam("prenom_membre"))
                                       ->setSexe_membre($request->getParam("sexe_membre"))
                                       ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                                       ->setId_pays($request->getParam("id_pays"))
                                       ->setLieu_nais_membre($request->getParam("lieu_nais_membre"))
                                       ->setPere_membre($request->getParam("pere_membre"))
                                       ->setMere_membre($request->getParam("mere_membre"))
                                       ->setSitfam_membre($request->getParam("sitfam_membre"))
                                       ->setNbr_enf_membre($request->getParam("nbr_enf_membre"))
                                       ->setProfession_membre($request->getParam("profession_membre"))
                                       ->setFormation($request->getParam("formation"))
                                       ->setId_religion_membre($request->getParam("religion_membre"))
                                       ->setQuartier_membre($request->getParam("quartier_membre"))
                                       ->setVille_membre($request->getParam("ville_membre"))
                                       ->setBp_membre($request->getParam("bp_membre"))
                                       ->setTel_membre($request->getParam("tel_membre"))
                                       ->setEmail_membre($request->getParam("email_membre"))
                                       ->setPortable_membre($request->getParam("portable_membre"))
                                       ->setHeure_inscription($date_idd->toString('HH:mm:ss'))
                                       ->setDate_inscription($date_id->toString('yyyy-MM-dd'))
                                       ->setCode_membre(null)
                                       ->setCode_fs(null)
                                       ->setCode_fl(null)
                			           ->setCode_fkps(null);
                        $preinscription->setPublier(1);

                        $mapper->save($preinscription);
						
						////// validation acnev ///////////////////////////////////////
					    $validation_quittance = new Application_Model_EuValidationQuittance();
						$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
						$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
						$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
						$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_acnev);
						$validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
						$validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
						$validation_quittance->setPublier(1);
						$validation_quittance_mapper->save($validation_quittance);

          
                        ////// validation filere ///////////////////////////////////
						$preinscription = new Application_Model_EuPreinscription();
						$preinscriptionM = new Application_Model_EuPreinscriptionMapper();
					    $preinscriptionM->find($compteur_preinscription, $preinscription);
								
						$preinscription->setPublier(2);
						$preinscriptionM->update($preinscription);


						$validation_quittance = new Application_Model_EuValidationQuittance();
						$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
						$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
						$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
						$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_filiere);
						$validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
					    $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
						$validation_quittance->setPublier(1);
						$validation_quittance_mapper->save($validation_quittance);
							
                        ////// validation technopole ///////////////////////////////////////////////////////////////
						$preinscription = new Application_Model_EuPreinscription();
					    $preinscriptionM = new Application_Model_EuPreinscriptionMapper();
						$preinscriptionM->find($compteur_preinscription, $preinscription);
								
						$preinscription->setPublier(3);
						$preinscriptionM->update($preinscription);


						$validation_quittance = new Application_Model_EuValidationQuittance();
						$validation_quittance_mapper = new Application_Model_EuValidationQuittanceMapper();
												
						$compteur_validation_quittance = $validation_quittance_mapper->findConuter() + 1;
						$validation_quittance->setValidation_quittance_id($compteur_validation_quittance);
						$validation_quittance->setValidation_quittance_utilisateur($id_utilisateur_technopole);
						$validation_quittance->setValidation_quittance_preinscription($compteur_preinscription);
					    $validation_quittance->setValidation_quittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
						$validation_quittance->setPublier(1);
						$validation_quittance_mapper->save($validation_quittance);
							
							
                        ////////////////////////////////////////////
						// insertion dans la table eu_membre
                        $membre->setCode_membre($code)
                               ->setNom_membre($request->getParam("nom_membre"))
                               ->setPrenom_membre($request->getParam("prenom_membre"))
                               ->setSexe_membre($request->getParam("sexe_membre"))
                               ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                               ->setId_pays($request->getParam("nationalite_membre"))
                               ->setLieu_nais_membre($request->getParam("lieu_nais_membre"))
                               ->setPere_membre($request->getParam("pere_membre"))
                               ->setMere_membre($request->getParam("mere_membre"))

                               ->setSitfam_membre($request->getParam("sitfam_membre"))
                               ->setNbr_enf_membre($request->getParam("nbr_enf_membre"))
                               ->setProfession_membre($request->getParam("profession_membre"))
                               ->setFormation($request->getParam("formation"))
                               ->setId_religion_membre($request->getParam("religion_membre"))
                               ->setQuartier_membre($request->getParam("quartier_membre"))
                               ->setVille_membre($request->getParam("ville_membre"))
                               ->setBp_membre($request->getParam("bp_membre"))
                               ->setTel_membre($request->getParam("tel_membre"))
                               ->setEmail_membre($request->getParam("email_membre"))
                               ->setPortable_membre($request->getParam("portable_membre"))
                               ->setId_utilisateur(null)
                               ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                               ->setDate_identification($date_idd->toString('yyyy-MM-dd'))
                               ->setCode_agence($code_agence)
                               ->setId_maison(null)
                               ->setCodesecret(md5($request->getParam("codesecret")))
				               ->setEtat_membre('N')
				               ->setCode_gac($acteur)
                               ->setAuto_enroler('N');
                            $m_map->save($membre);
							
						////////////////////////////////////////////////////////////////////////////////
						$preinscription = new Application_Model_EuPreinscription();
						$preinscriptionM = new Application_Model_EuPreinscriptionMapper();
						$preinscriptionM->find($compteur_preinscription, $preinscription);
								
						$preinscription->setCode_membre($code);
						$preinscriptionM->update($preinscription);
				
				        // insertion dans la table eu_activation
						$id_activation = $m_activation->findConuter() + 1;
						$activation->setId_activation($id_activation)
						           ->setId_depot($id_depot)
								   ->setDate_activation($date_idd->toString('yyyy-MM-dd HH:mm:ss'))
								   ->setCode_activation($code_activation)
								   ->setCode_membre($code);
						$m_activation->save($activation);		   
				
				
				        $findmembretiers = $m_membretiers->find($id_membretiers,$membretiers);
			            if($findmembretiers) {
			                $membretiers->setCode_membre($code)
							            ->setPublier(1);
				            $m_membretiers->update($membretiers);
		                }
			
			            $userin = new Application_Model_EuUtilisateur();
                        $mapper_user = new Application_Model_EuUtilisateurMapper();
			
			            // insertion dans la table eu_utilisateur
                        $id_user = $mapper_user->findConuter() + 1;
                        $userin->setId_utilisateur($id_user)
                               ->setId_utilisateur_parent(null)
                               ->setPrenom_utilisateur($request->getParam("prenom_membre"))
                               ->setNom_utilisateur($request->getParam("nom_membre"))
                               ->setLogin($code)
                               ->setPwd(md5($request->getParam("codesecret")))
                               ->setDescription(null)
                               ->setUlock(0)
                               ->setCh_pwd_flog(0)
                               ->setCode_groupe('personne_physique')
				               ->setCode_groupe_create('personne_physique')
                               ->setConnecte(0)
                               ->setCode_agence($code_agence)
                               ->setCode_secteur(null)
                               ->setCode_zone($code_zone)
                               //->setCode_gac_filiere(null)
		                       ->setId_pays($request->getParam("id_pays"))	    	
                               ->setCode_acteur($acteur)
				               ->setCode_membre($code);
                        $mapper_user->save($userin);							   
                    
				        // Mise à jour de la table eu_contrat
                        $contrat = new Application_Model_EuContrat();
		                $mapper_contrat = new Application_Model_EuContratMapper();
		                $id_contrat = $mapper_contrat->findConuter() + 1;
				        $contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                        $contrat->setNature_contrat('numeraire');
                        $contrat->setId_type_contrat(null);
                        $contrat->setId_type_creneau(null);
                        $contrat->setId_type_acteur(null);
                        $contrat->setId_pays(null);
                        $contrat->setId_utilisateur(null);
                        $contrat->setFiliere(null);
                        $mapper_contrat->save($contrat);
				
				        // insertion dans la table eu_compte_bancaire
					    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                        $cb = new Application_Model_EuCompteBancaire();
					    for($i = 0; $i < count($_POST['code_banque']); $i++) {
                            $cb_compteur = $cb_mapper->findConuter() + 1;         
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre($code)
                               ->setCode_membre_morale(NULL)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i]);
                            $cb_mapper->save($cb);
                        }
					   
                        // insertion dans eu_fs
						$tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre($code)
						         ->setCode_membre_morale(null)
                                 ->setCode_fs('FS-' . $code)
                                 ->setCreditcode($code_activation)
                                 ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                 ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                 ->setId_utilisateur(null)
                                 ->setMont_fs($fs)
								 ->setOrigine_fs('N');
                        $tab_fs->insert($fs_model->toArray()); 
						      
						//insertion des frais d'identification dans la table operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
						$lib_op = 'Enrôlement';
                        $type_op = 'ERL';
						Util_Utils::addOperation($compteur,$code,null,'TFS',$fs,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'),null);
                        
				        $carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
                        $compte = new Application_Model_EuCompte();
                        $map_compte = new Application_Model_EuCompteMapper();
					 
					    $id = $type_bnp . $apporteur . $date_deb->toString('yyyyMMddHHmmss');
				        $caps->setCode_caps($id)
                             ->setCode_membre_benef($code)
                             ->setMont_caps($mont_caps)
                             ->setMont_fs(0)
                             ->setPeriode(0)
                             ->setId_operation($count)
                             ->setRembourser('N')
                             ->setId_credit(null)
                             ->setIndexer(1)
                             ->setType_caps($type_caps)
                             ->setCode_type_bnp($type_bnp)
                             ->setFs_utiliser(1)
                             ->setFl_utiliser(1)
	                         ->setCps_utiliser(1)
                             ->setMont_panu_fs(0)
                             ->setReconst_fs(0)
                             ->setPanu(0)
                             ->setDate_caps($date_idd->toString('yyyy-MM-dd'))
                             ->setId_utilisateur(null);
							 
					    if(substr($apporteur,19,1)=='P') {
                            $caps->setCode_membre_app($apporteur)
                                 ->setCode_membre_morale_app(null);
                        } else  {
                            $caps->setCode_membre_app(null)
                                 ->setCode_membre_morale_app($apporteur);
                        }							 
				        $m_caps->save($caps);
				        
						$tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
						$compteur = $mapper->findConuter() + 1;
						
						// insertion dans la table eu_operation 
                        Util_Utils::addOperation($compteur,$code,null,null,$mont_fl,null,'Frais de licences','FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),null);
						
						// insertion dans la table eu_fl
						$fl->setCode_fl("FL-".$code)
                           ->setCode_membre($code)
						   ->setCode_membre_morale(null)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur(null)
                           ->setCreditcode($code_activation)
						   ->setOrigine_fl('N');
                        $tfl->insert($fl->toArray());
						
						$tcartes[0]="TPAGCRPG";
						$tcartes[1]="TCNCS";
						$tcartes[2]="TPaNu";
						$tcartes[3]="TPaR";
						$tcartes[4]="TR";
						$tcartes[5]="CAPA";
									
						$tscartes[0]="TSRPG";
					    $tscartes[1]="TSCNCS";
					    $tscartes[2]="TSPaNu";
						$tscartes[3]="TSPaR";
						$tscartes[4]="TSCAPA";
	
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCS") {
                              $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
							  $type_carte = 'NR';
							  $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                              $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
							  $type_carte = 'NN';
							  $res = $map_compte->find($code_compte,$compte);
							} else {
							  $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
							  $type_carte = 'NB';
							  $res = $map_compte->find($code_compte,$compte);
							}		
								if(!$res) {
								    // insertion dans la table eu_compte
                                    $compte->setCode_cat($tcartes[$i])
                                           ->setCode_compte($code_compte)
                                           ->setCode_membre($code)
										   ->setCode_membre_morale(null)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tcartes[$i])
                                           ->setSolde(0);
									$map_compte->save($compte);
									
							    }
									
                        }
						
						for($j = 0; $j < count($tscartes); $j++) {
							if($tscartes[$j] == "TSCNCS") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
						    } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} else  {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
								$type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							}
										
								if(!$res) {
								    // insertion dans la table eu_compte
                                    $compte->setCode_cat($tscartes[$j])
                                           ->setCode_compte($code_comptets)
                                           ->setCode_membre($code)
										   ->setCode_membre_morale(null)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tscartes[$j])
                                           ->setSolde(0);
									$map_compte->save($compte);
									
							    }
									
                        }
						
						//Mise e jour du compte general fgfn
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $fl);
                            $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($prix);
                            $cg_mapper->save($cg_fgfn);
                        }
						
						// insertion dans la table eu_carte
    					$id_demande = $carte->findConuter() + 1;
                        $carte->setId_demande($id_demande)
							  ->setCode_cat(null)
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte(null)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur(null)
							  ->setOrigine_fkps('N');
                        $t_carte->insert($carte->toArray());
						


					
/////////////////////////////////////////////////////////////						
						
			if(isset($souscription->souscription_id) && $souscription->souscription_id > 0){			
//////////////////////////////////////////////////////////
$id_souscription = $souscription->souscription_id;
		
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id_souscription, $souscription);
		
		
		
		
//////////////////////////////////////////
if($souscription->souscription_membreasso != 1 && $souscription->souscription_membreasso != 0){
        $membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find($souscription->souscription_membreasso, $membreasso);
			
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find($membreasso->membreasso_association, $association);
		$code_agence = $association->code_agence;
		
        $recubancaire = new Application_Model_EuRecubancaire();
        $recubancaire_mapper = new Application_Model_EuRecubancaireMapper();
        $cumul_recubancaire = $recubancaire_mapper->findCumul($souscription->souscription_id);
        //$cumul_recubancaire = 0;
		
		if($cumul_recubancaire > 0){
		
		if($association->id_filiere == NULL && $association->code_type_acteur == NULL && $association->code_statut == NULL){
			
			/*if($souscription->souscription_type == "1"){
			$partagea_montant = floor(($cumul_recubancaire / 100 * 10) / 2);
				}else{
			$partagea_montant = floor(($cumul_recubancaire / 100 * 5) / 2);
					}*/
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}else{
			
			/*if($souscription->souscription_type == "1"){
			$partagea_montant = floor($cumul_recubancaire / 100 * 10);
				}else{
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
					}*/
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association($membreasso->membreasso_association);
            $partagea->setPartagea_souscription($souscription->souscription_id);
            $partagea->setPartagea_montant($partagea_montant * 0.75);
            $partagea->setPartagea_montant_utilise(0);
            $partagea->setPartagea_montant_solde($partagea_montant * 0.75);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////

        $partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso($membreasso->membreasso_id);
            $partagem->setPartagem_souscription($souscription->souscription_id);
            $partagem->setPartagem_montant($partagea_montant * 0.25);
            $partagem->setPartagem_montant_utilise(0);
            $partagem->setPartagem_montant_solde($partagea_montant * 0.25);
            $partagem_mapper->save($partagem);
			
//////////////////////////////////////////

}
		
			}
				
						
						
						}
						
/////////////////////////////////////////////////////////////						
					

						$countop = $mapper->findConuter() + 1;		
                        Util_Utils::addOperation($countop,$code,null,null,$fkps,null,'Frais de CPS','CPS',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),null);
                        
						if(substr($apporteur,19,1) == 'P') {
						   $findmembre = $m_map->find($apporteur,$membre);
						   $compt = Util_Utils::findConuter() + 1;
                           Util_Utils::addSms($compt,$membre->getPortable_membre(),"Vous venez de faire l'activation du compte du membre  ". $code);   
                        } else {
						   $findmembre = $m_mapmoral->find($apporteur,$membremoral);
						   $compt = Util_Utils::findConuter() + 1;
                           Util_Utils::addSms($compt,$membremoral->getPortable_membre(),"Vous venez de faire l'activation du compte du membre  ". $code);
						}
						
			            $compt1 = Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compt1,$request->getParam("portable_membre"),"Bienvenue dans le reseau MCNP !!!  Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);   
                        
						$db->commit();
						$this->view->message = "Ouverture de compte marchand bien effectuée ...";
	
	                } catch (Exception $exc) {
                        $db->rollback();
                        $message = "Erreur d\'éxécution : " . $exc->getMessage() . $exc->getTraceAsString();
                        $this->view->message = $message;
						$this->view->nom_membre = $request->getParam("nom_membre");
                        $this->view->prenom_membre = $request->getParam("prenom_membre");
                        $this->view->sexe = $request->getParam("sexe_membre");
                        $this->view->sitfam = $request->getParam("sitfam_membre");
                        $this->view->datnais = $request->getParam("date_nais_membre");
                        $this->view->nation = $request->getParam("nationalite_membre");
                        $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                        $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                        $this->view->formation = $request->getParam("formation");
                        $this->view->profession = $request->getParam("profession_membre");
                        $this->view->religion = $request->getParam("religion_membre");
                        $this->view->pere = $request->getParam("pere_membre");
                        $this->view->mere = $request->getParam("mere_membre");
                        $this->view->quartier_membre = $request->getParam("quartier_membre");
                        $this->view->ville_membre = $request->getParam("ville_membre");
                        $this->view->bp = $request->getParam("bp_membre");
                        $this->view->tel = $request->getParam("tel_membre");
                        $this->view->email = $request->getParam("email_membre");
                        $this->view->portable = $request->getParam("portable_membre");
				        return;
                    }
	
	        }  else {  
			    $this->view->message = "Champs * obligatoire ..."; 
                $this->view->nom_membre = $request->getParam("nom_membre");
                $this->view->prenom_membre = $request->getParam("prenom_membre");
                $this->view->sexe = $request->getParam("sexe_membre");
                $this->view->sitfam = $request->getParam("sitfam_membre");
                $this->view->datnais = $request->getParam("date_nais_membre");
                $this->view->nation = $request->getParam("nationalite_membre");
                $this->view->lieu_nais = $request->getParam("lieu_nais_membre");
                $this->view->nbre_enf = $request->getParam("nbr_enf_membre");
                $this->view->formation = $request->getParam("formation");
                $this->view->profession = $request->getParam("profession_membre");
                $this->view->religion = $request->getParam("religion_membre");
                $this->view->pere = $request->getParam("pere_membre");
                $this->view->mere = $request->getParam("mere_membre");
                $this->view->quartier_membre = $request->getParam("quartier_membre");
                $this->view->ville_membre = $request->getParam("ville_membre");
                $this->view->bp = $request->getParam("bp_membre");
                $this->view->tel = $request->getParam("tel_membre");
                $this->view->email = $request->getParam("email_membre");
                $this->view->portable = $request->getParam("portable_membre");			
			}
	
	    }
	
	}
	
	
	


    public function listsouscriptionetatAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->findMoisAnneeAssociation($sessionmembreasso->membreasso_association);

        $this->view->tabletri = 1;

    }


    public function listsouscriptionetat2Action()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['periode']) && $_POST['periode']!="") {

list($debut, $fin) = explode("/", $_POST['periode']);

        $partagea = new Application_Model_EuPartageaMapper();
        $this->view->entries = $partagea->fetchAllByCommissionSouscription($sessionmembreasso->membreasso_association, $debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
		
	}
	} /*else {

        $partagea = new Application_Model_EuPartageaMapper();
        $this->view->entries = $partagea->fetchAllByCommissionSouscription(0, "", "");

	}*/
        $this->view->tabletri = 1;


    }


    public function listsouscriptionetat22Action()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['periode']) && $_POST['periode']!="") {

list($debut, $fin) = explode("/", $_POST['periode']);

        $partagem = new Application_Model_EuPartagemMapper();
        $this->view->entries = $partagem->fetchAllByCommissionSouscription($sessionmembreasso->membreasso_id, $debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
		
	} /*else {

        $partagem = new Application_Model_EuPartagemMapper();
        $this->view->entries = $partagem->fetchAllByCommissionSouscription(0, "", "");

	}*/
	}
        $this->view->tabletri = 1;


    }



    public function etatsouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}


            $debut = (string)$this->_request->getParam('debut');
            $fin = (string)$this->_request->getParam('fin');
			
			if($debut != "" && $fin != ""){

        $partagea = new Application_Model_EuPartageaMapper();
        $this->view->entries = $partagea->findSomme($sessionmembreasso->membreasso_association, $debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
		
        $this->view->tabletri = 1;
		}else{
		$this->_redirect('/administration/listsouscriptionetat');
			}

    }






    public function addpayementcommissionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}
		
		
            $type = (int)$this->_request->getParam('type');

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['periode']) && $_POST['periode']!="" && isset($_POST['payement_commission_montant']) && $_POST['payement_commission_montant']!="" && isset($_POST['id_type_commission']) && $_POST['id_type_commission']!="" && isset($_POST['id_mode_payement']) && $_POST['id_mode_payement']!="") {
		
				
			list($date_debut, $date_fin) = explode("/", $_POST['periode']);
			
        $date_id = Zend_Date::now();
		
if($type == 1){
        $partagea_m = new Application_Model_EuPartageaMapper();
        $partage = $partagea_m->findSomme($sessionmembreasso->membreasso_association, $date_debut, $date_fin);
	}else{
        $partagem_m = new Application_Model_EuPartagemMapper();
        $partage = $partagem_m->findSomme($sessionmembreasso->membreasso_association, $sessionmembreasso->membreasso_id, $date_debut, $date_fin);
		}
		
		if($_POST['payement_commission_montant'] <= $partage[2]){
		
		
        $payement_commission = new Application_Model_EuPayementCommission();
        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
			
            $compteur_payement_commission = $payement_commission_mapper->findConuter() + 1;
            $payement_commission->setPayement_commission_id($compteur_payement_commission);
	        $payement_commission->setPayement_commission_montant($_POST['payement_commission_montant']);
            $payement_commission->setPayement_commission_date_demande($date_id->toString('yyyy-MM-dd'));
            $payement_commission->setPayement_commission_demande(1);
	        $payement_commission->setPayement_commission_payer(0);
			$payement_commission->setPayement_commission_date_payer(NULL);
			$payement_commission->setPayement_commission_date_debut($date_debut);
			$payement_commission->setPayement_commission_date_fin($date_fin);
			$payement_commission->setMembreasso_id($sessionmembreasso->membreasso_id);
			$payement_commission->setId_type_commission($_POST['id_type_commission']);
			$payement_commission->setId_mode_payement($_POST['id_mode_payement']);
			$payement_commission->setPayement_commission_type($type);
            $payement_commission_mapper->save($payement_commission);
			

		$this->_redirect('/association/listpayementcommission');

}else {  $sessionmembreasso->error = "Vous ne pouvez pas demander plus que votre commission."; }


		} else {  $sessionmembreasso->error = "Champs * obligatoire ..."; }
	}
	 
	}



    public function listpayementcommissionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['periode']) && $_POST['periode']!="") {

list($debut, $fin) = explode("/", $_POST['periode']);

        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
        $this->view->entries = $payement_commission_mapper->fetchAllByMembreasso($sessionmembreasso->membreasso_id, $debut, $fin);

        $this->view->debut = $debut;
        $this->view->fin = $fin;
	} else {
        $payement_commission_mapper = new Application_Model_EuPayementCommissionMapper();
        $this->view->entries = $payement_commission_mapper->fetchAllByMembreasso($sessionmembreasso->membreasso_id, "", "");
	}
	}

        $this->view->tabletri = 1;


    }






    public function supppayementcommissionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $payement_commission = new Application_Model_EuPayementCommission();
        $payement_commissionM = new Application_Model_EuPayementCommissionMapper();
        $payement_commissionM->find($id, $payement_commission);
		
        $payement_commissionM->delete($payement_commission->payement_commission_id);

        }

		$this->_redirect('/association/listpayementcommission');
    }



}



