<?php

class AssociationController extends Zend_Controller_Action
{

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
	if($rowseumembreasso->membreasso_association == "1" || $rowseumembreasso->local == 1){

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
    $this->_redirect('/association');
		
		}else{
			$sessionmembreasso->errorlogin = "Erreur de connexion N° 147 : Veuillez contacter le Service Technique ..."; 
    $this->_redirect('/association/login');
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
    $this->_redirect('/association');
		}
	} else { $sessionmembreasso->errorlogin = "Login ou Mot de Passe Erroné"; }
    $this->_redirect('/association/login');
	} else { $sessionmembreasso->errorlogin = "Saisir Login et Mot de Passe"; } 
    $this->_redirect('/association/login');
	}

    }

    public function passwordAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

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
            //$this->_redirect('/association/membreasso');
        }
    }

    function nocompteAction()
    {
	Zend_Session::destroy(true);
    $this->_redirect('/association/login');
    }




    public function indexAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}


    }



    public function addmembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}
		

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
			

		$this->_redirect('/association/listmembreasso');
	}
		} else {  $this->view->error = "Champs * obligatoire ..."; }
	}
	 
	}



    public function editmembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['membreasso_mobile']) && $_POST['membreasso_mobile']!="" && isset($_POST['membreasso_nom']) && $_POST['membreasso_nom']!="" && isset($_POST['membreasso_prenom']) && $_POST['membreasso_prenom']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find($_POST['membreasso_id'], $membreasso);
			
            $membreasso->setMembreasso_mobile($_POST['membreasso_mobile']);
            $membreasso->setMembreasso_nom($_POST['membreasso_nom']);
            $membreasso->setMembreasso_prenom($_POST['membreasso_prenom']);
            $membreasso->setMembreasso_email($_POST['membreasso_email']);
            //$membreasso->setMembreasso_login($_POST['membreasso_login']);
            $m_membreasso->update($membreasso);
			
		$this->_redirect('/association/listmembreasso');
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
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $membreasso = new Application_Model_EuMembreassoMapper();
        $this->view->entries = $membreasso->fetchAllByMembreasso($sessionmembreasso->membreasso_association);

        $this->view->tabletri = 1;

    }

    public function publiermembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($id, $membreasso);
		
        $membreasso->setPublier($this->_request->getParam('publier'));
		$membreassoM->update($membreasso);
        }

		$this->_redirect('/association/listmembreasso');
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
            $a->setIntegrateur_membreasso(0);/*$sessionmembreasso->membreasso_id*/
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
if($integrateur->integrateur_membreasso != 1 && $integrateur->integrateur_membreasso != 0){
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
			
			/*if($integrateur->integrateur_type == "1"){
			$partagea_montant = floor(($cumul_recubancaire / 100 * 10) / 2);
				}else{
			$partagea_montant = floor(($cumul_recubancaire / 100 * 5) / 2);
					}*/
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}else{
			
			/*if($integrateur->integrateur_type == "1"){
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
		
			}
				
			
        $membreasso_sous_m = new Application_Model_EuMembreassoMapper();
        $membreasso_sous = $membreasso_sous_m->fetchAllBySouscription($integrateur->integrateur_souscription);
			
			
			
///////////////////////////////////////////////////////////////			
if($integrateur->integrateur_type <= 8 && count($membreasso_sous) > 0){
	
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
$html .= "Connectez vous aussi : <a href='http://prod.esmcgacsource.com/association/login'>Connexion Agrément OSE/OE</a>";
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

	}


			

//////////////////////////////////////////////////////////

            $sessionmembreasso->error = "Opération bien effectuée ...";
			
			

		$this->_redirect('/association/addintegrateur/param/'.$_POST['integrateur_type']);
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
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $integrateur = new Application_Model_EuIntegrateurMapper();
        $this->view->entries = $integrateur->fetchAllByMembreasso($sessionmembreasso->membreasso_id);

    }




    public function listintegrateur1Action()
    {
        /* page association/listlivraison - Liste des livraisons */

		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $integrateur = new Application_Model_EuIntegrateurMapper();
        $this->view->entries = $integrateur->fetchAllByAssociation($sessionmembreasso->membreasso_association);

    }


	
	


    public function suppmembreassoAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $membreasso = new Application_Model_EuMembreasso();
        $membreassoM = new Application_Model_EuMembreassoMapper();
        $membreassoM->find($id, $membreasso);
		
        $membreassoM->delete($membreasso->membreasso_id);

        }

		$this->_redirect('/association/listmembreasso');
    }



    public function detailsmembreassoAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

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
		$param = (int)$this->_request->getParam('param');
	    $this->view->param = $param;
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
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
				&& isset($_POST['souscription_montant']) && $_POST['souscription_montant']!="") {
		
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
		                    $m_association->find(1, $association);
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
                                $html .= "Vignette : <a href='http://esmcgacsource.com/".$souscription_vignette."'>".$souscription_vignette."</a>";

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
                                        $html .= "Connectez vous aussi : <a href='http://prod.esmcgacsource.com/association/login'>Connexion Agrément OSE/OE</a>";
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
														$this->_redirect('/association/addsouscription/param/'.$param);
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
														$this->_redirect('/association/addsouscription/param/'.$param);
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
													$this->_redirect('/association/addsouscription/param/'.$param);
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
									$this->_redirect('/association/addsouscription/param/'.$param);
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
		                        $this->_redirect('/association/addsouscription/param/'.$param);/**/
								
		                    } else {
							    $db->commit();
                                $sessionmembreasso->error = "Opération bien effectuée, mais le montant est insuffisant. Veuillez compléter le montant par un autre dépôt à la banque.";
		                        $this->_redirect('/association/addsouscriptioncomplement');/**/
					                }
		                    }  else {
								$db->commit();
                                $sessionmembreasso->error = "Opération bien effectuée. Votre souscription n’est pas encore vérifiée, revenez plus tard.";
		                        $this->_redirect('/association/recherchesouscription');/**/
			                }
		
		
		                }
		
		            }  catch (Exception $exc) {
	                    $this->view->param = $param;
                        $sessionmembreasso->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();  
		                $this->_redirect('/association/addsouscription/param/'.$param);/**/
                        //return;
                    }
		
		
		
		
		
		    }   else {  $sessionmembreasso->error = "Champs * obligatoire ..."; }
		
		
		}	
		
	}

	 public function recherchesouscriptionAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

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
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}


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
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}
		

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
$html .= "Vignette : <a href='http://esmcgacsource.com/".$souscription_vignette."'>".$souscription_vignette."</a>";


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
$html .= "Connectez vous aussi : <a href='http://prod.esmcgacsource.com/association/login'>Connexion Agrément OSE/OE</a>";
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


		$this->_redirect('/association/listsouscription2');/**/
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
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

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
			
		$this->_redirect('/association/listsouscription2');
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
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAll3();

        $this->view->tabletri = 1;

    }

    public function listsouscription2Action() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllByMembreasso($sessionmembreasso->membreasso_id);

        $this->view->tabletri = 1;

    }
	
	
	
	
	
	
	
	
    public function listsouscription3Action()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllByAssociation($sessionmembreasso->membreasso_association);

        $this->view->tabletri = 1;

    }
	
    public function publiersouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		
        $souscription->setPublier($this->_request->getParam('publier'));
		$souscriptionM->update($souscription);
        }

		$this->_redirect('/association/listsouscription');
    }




    public function suppsouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		
        $souscriptionM->delete($souscription->souscription_id);

        }

		$this->_redirect('/association/listsouscription');
    }



    public function detailssouscriptionAction() {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

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
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}
		

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['ancien_recubancaire_type']) && $_POST['ancien_recubancaire_type']!="" && isset($_POST['ancien_recubancaire_numero']) && $_POST['ancien_recubancaire_numero']!="" && isset($_POST['ancien_recubancaire_date_numero']) && $_POST['ancien_recubancaire_date_numero']!="" && isset($_POST['recubancaire_type']) && $_POST['recubancaire_type']!="" && isset($_POST['recubancaire_numero']) && $_POST['recubancaire_numero']!="" && isset($_POST['recubancaire_date_numero']) && $_POST['recubancaire_date_numero']!="" && isset($_POST['recubancaire_montant']) && $_POST['recubancaire_montant']!="") {
		

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
            $a->setOffreur_projet_membreasso(0);/*$sessionmembreasso->membreasso_id*/
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
if($offreur_projet->offreur_projet_membreasso != 1 && $offreur_projet->offreur_projet_membreasso != 0){
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
			
			/*if($offreur_projet->offreur_projet_type == "1"){
			$partagea_montant = floor(($cumul_recubancaire / 100 * 10) / 2);
				}else{
			$partagea_montant = floor(($cumul_recubancaire / 100 * 5) / 2);
					}*/
			$partagea_montant = floor($cumul_recubancaire / 100 * 5);
			
		}else{
			
			/*if($offreur_projet->offreur_projet_type == "1"){
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
}

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
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $offreurprojet = new Application_Model_EuOffreurprojetMapper();
        $this->view->entries = $offreurprojet->fetchAllByMembreasso($sessionmembreasso->membreasso_id);

    }




    public function listoffreurprojet1Action()
    {
        /* page association/listlivraison - Liste des livraisons */

		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

        $offreurprojet = new Application_Model_EuOffreurprojetMapper();
        $this->view->entries = $offreurprojet->fetchAllByAssociation($sessionmembreasso->membreasso_association);

    }






    public function editmembreassosouscriptionAction()
    {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionmembreasso->login)) {$this->_redirect('/association/login');}

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




}



