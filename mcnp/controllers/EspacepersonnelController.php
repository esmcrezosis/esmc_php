<?php

class EspacepersonnelController extends Zend_Controller_Action {

	public function init() 
	{

		/* Initialize action controller here */
      //$liste = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $liste = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
        
      $codesecret = "";
      while(strlen($codesecret) != 8) {
        $codesecret .= $liste[rand(0,strlen($liste)-1)]; 
      }
      $this->view->codesecret = $codesecret;
		
         include("Url.php");   
 
	}



	public function logoutAction() {
		Zend_Session::destroy(true);
		$this->_redirect('/index/securelogin');
	}


	public function login2Action() 
	{
		/* page espacepersonnel/login - Authentification Espace Personnel/Professionnel */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		/*if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
*/


		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['codesecret']) && $_POST['codesecret'] != "") {


				if (substr($_POST['code_membre'], -1) == "P") {

					$eumembre = new Application_Model_DbTable_EuMembre();
					$select = $eumembre->select()->where('code_membre = ?', $_POST['code_membre'])
							->where('codesecret = ?', md5($_POST['codesecret']))
							->where('desactiver = ?', 0);
					if  ($rowseumembre = $eumembre->fetchRow($select)) {
						$sessionmembre->code_membre = $rowseumembre->code_membre;
						$sessionmembre->nom_membre = $rowseumembre->nom_membre;
						$sessionmembre->prenom_membre = $rowseumembre->prenom_membre;
						$sessionmembre->sexe_membre = $rowseumembre->sexe_membre;
						$sessionmembre->date_nais_membre = $rowseumembre->date_nais_membre;
						$sessionmembre->lieu_nais_membre = $rowseumembre->lieu_nais_membre;
						$sessionmembre->pays = $rowseumembre->id_pays;
						$sessionmembre->profession_membre = $rowseumembre->profession_membre;
						$sessionmembre->formation = $rowseumembre->formation;
						$sessionmembre->pere_membre = $rowseumembre->pere_membre;
						$sessionmembre->mere_membre = $rowseumembre->mere_membre;
						$sessionmembre->sitfam_membre = $rowseumembre->sitfam_membre;
						$sessionmembre->nbr_enf_membre = $rowseumembre->nbr_enf_membre;
						$sessionmembre->quartier_membre = $rowseumembre->quartier_membre;
						$sessionmembre->ville_membre = $rowseumembre->ville_membre;
						$sessionmembre->bp_membre = $rowseumembre->bp_membre;
						$sessionmembre->tel_membre = $rowseumembre->tel_membre;
						$sessionmembre->email_membre = $rowseumembre->email_membre;
						$sessionmembre->date_identification = $rowseumembre->date_identification;
						$sessionmembre->portable_membre = $rowseumembre->portable_membre;
						$sessionmembre->code_agence = $rowseumembre->code_agence;
						$sessionmembre->heure_identification = $rowseumembre->heure_identification;
						$sessionmembre->id_utilisateur = $rowseumembre->id_utilisateur;
						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;

						if (substr($sessionmembre->code_membre, -1) == "P") {
							$sessionmembre->type = 'RPG';
							$sessionmembre->desctype = 'Revenu Périodique Garanti';
							$sessionmembre->typepernonne = 'P';
						} else if (substr($sessionmembre->code_membre, -1) == "M") {
							$sessionmembre->type = 'I';
							$sessionmembre->desctype = 'Investissement';
							$sessionmembre->typepernonne = 'M';
						}

						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;

						$sessionmembre->code_secret = $rowseumembre->codesecret;
						
						$code_groupe = array('personne_physique');
$utilisateur_m = new Application_Model_EuUtilisateurMapper();
$utilisateur_rows = $utilisateur_m->findByMembre($sessionmembre->code_membre, $code_groupe);

						$sessionmembre->code_groupe = $utilisateur_rows->code_groupe;
						
						$sessionmembre->errorlogin = "";
						$this->_redirect('/espacepersonnel');
					} else {
						$sessionmembre->errorlogin = "Code Membre ou Code Secret Erroné";
					}
				} else if (substr($_POST['code_membre'], -1) == "M") {

					$eumembre = new Application_Model_DbTable_EuMembreMorale();
					$select = $eumembre->select()->where('code_membre_morale = ?', $_POST['code_membre'])
							->where('codesecret = ?', md5($_POST['codesecret']))
							->where('desactiver = ?', 0);
					if ($rowseumembre = $eumembre->fetchRow($select)) {


						$sessionmembre->code_membre = $rowseumembre->code_membre_morale;
						$sessionmembre->code_type_acteur = $rowseumembre->code_type_acteur;
						$sessionmembre->code_statut = $rowseumembre->code_statut;
						$sessionmembre->raison_sociale = $rowseumembre->raison_sociale;
						$sessionmembre->pays = $rowseumembre->id_pays;
						$sessionmembre->quartier_membre = $rowseumembre->quartier_membre;
						$sessionmembre->ville_membre = $rowseumembre->ville_membre;
						$sessionmembre->tel_membre = $rowseumembre->tel_membre;
						$sessionmembre->portable_membre = $rowseumembre->portable_membre;
						$sessionmembre->email_membre = $rowseumembre->email_membre;
						$sessionmembre->bp_membre = $rowseumembre->bp_membre;
						$sessionmembre->site_web = $rowseumembre->site_web;
						$sessionmembre->domaine_activite = $rowseumembre->domaine_activite;
						$sessionmembre->num_registre_membre = $rowseumembre->num_registre_membre;
						$sessionmembre->date_identification = $rowseumembre->date_identification;
						$sessionmembre->heure_identification = $rowseumembre->heure_identification;
						$sessionmembre->code_agence = $rowseumembre->code_agence;
						$sessionmembre->id_utilisateur = $rowseumembre->id_utilisateur;
						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;
						$sessionmembre->etat_membre = $rowseumembre->etat_membre;
						$sessionmembre->id_filiere = $rowseumembre->id_filiere;

						if (substr($sessionmembre->code_membre, -1) == "P") {
							$sessionmembre->type = 'RPG';
							$sessionmembre->desctype = 'Revenu Périodique Garanti';
							$sessionmembre->typepernonne = 'P';
						} else if (substr($sessionmembre->code_membre, -1) == "M") {
							$sessionmembre->type = 'I';
							$sessionmembre->desctype = 'Investissement';
							$sessionmembre->typepernonne = 'M';
						}

						$sessionmembre->code_secret = $rowseumembre->codesecret;
						
						$code_groupe = array('pbf_grossiste', 'oe_grossiste', 'ose_grossiste', 'detentrice', 'detentrice_filiere', 'agrement_filiere', 'detentrice_pays', 'detentrice_region', 'detentrice_secteur', 'detentrice_agence', 'surveillance', 'surveillance_technopole', 'agrement_technopole', 'surveillance_pays', 'surveillance_region', 'surveillance_secteur', 'surveillance_agence', 'executante', 'executante_acnev', 'agrement_acnev', 'executante_pays', 'executante_region', 'executante_secteur', 'executante_agence');
$utilisateur_m = new Application_Model_EuUtilisateurMapper();
//$utilisateur_rows = $utilisateur_m->findByMembre($sessionmembre->code_membre, $code_groupe);
$utilisateur_rows = $utilisateur_m->findByMembre2($sessionmembre->code_membre);

						$sessionmembre->code_groupe = $utilisateur_rows->code_groupe;
						
$acteur3 = new Application_Model_EuActeur();
$acteur3Row = $acteur3->findByCodeActeur3($sessionmembre->code_membre);

				 $sessionmembre->code_acteur = $acteur3Row->code_acteur;
				 
$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($sessionmembre->code_acteur);
				 $sessionmembre->code_source_create = $acteurRow->code_source_create;
				 $sessionmembre->code_monde_create = $acteurRow->code_monde_create;
				 $sessionmembre->code_zone_create = $acteurRow->code_zone_create;
				 $sessionmembre->id_pays = $acteurRow->id_pays;
				 $sessionmembre->id_region = $acteurRow->id_region;
				 $sessionmembre->code_secteur_create = $acteurRow->code_secteur_create;
				 $sessionmembre->code_agence_create = $acteurRow->code_agence_create;



						$sessionmembre->type_fournisseur = $rowseumembre->type_fournisseur;


						$sessionmembre->errorlogin = "";
						$this->_redirect('/espacepersonnel');
					} else {
						$sessionmembre->errorlogin = "Code Membre ou Code Secret Erroné";
					}
				}





				$this->_redirect('/');
			} else {
				$sessionmembre->errorlogin = "Saisir Code Membre et Code Secret";
			}
			$this->_redirect('/');
		}
	}


public function login4Action()
	{
		/* page espacepersonnel/login - Authentification Espace Personnel/Professionnel */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');


$this->view->index = "esmc";



		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['codesecret']) && $_POST['codesecret'] != "") {


				if (substr($_POST['code_membre'], -1) == "P") {
					if($_POST['codesecret'] != Util_Utils::getParamEsmc(11)){
					$eumembre = new Application_Model_DbTable_EuMembre();
					$select = $eumembre->select()->where('code_membre = ?', $_POST['code_membre'])
							->where('codesecret = ?', md5($_POST['codesecret']))
							->where('desactiver = ?', 0);
					}else{
					$eumembre = new Application_Model_DbTable_EuMembre();
					$select = $eumembre->select()->where('code_membre = ?', $_POST['code_membre'])
							->where('desactiver = ?', 0);
					}

					if  ($rowseumembre = $eumembre->fetchRow($select)) {

						$sessionmembre->code_membre = $rowseumembre->code_membre;
						$sessionmembre->nom_membre = $rowseumembre->nom_membre;
						$sessionmembre->prenom_membre = $rowseumembre->prenom_membre;
						$sessionmembre->sexe_membre = $rowseumembre->sexe_membre;
						$sessionmembre->date_nais_membre = $rowseumembre->date_nais_membre;
						$sessionmembre->lieu_nais_membre = $rowseumembre->lieu_nais_membre;
						$sessionmembre->pays = $rowseumembre->id_pays;
						$sessionmembre->profession_membre = $rowseumembre->profession_membre;
						$sessionmembre->formation = $rowseumembre->formation;
						$sessionmembre->pere_membre = $rowseumembre->pere_membre;
						$sessionmembre->mere_membre = $rowseumembre->mere_membre;
						$sessionmembre->sitfam_membre = $rowseumembre->sitfam_membre;
						$sessionmembre->nbr_enf_membre = $rowseumembre->nbr_enf_membre;
						$sessionmembre->quartier_membre = $rowseumembre->quartier_membre;
						$sessionmembre->ville_membre = $rowseumembre->ville_membre;
						$sessionmembre->bp_membre = $rowseumembre->bp_membre;
						$sessionmembre->tel_membre = $rowseumembre->tel_membre;
						$sessionmembre->email_membre = $rowseumembre->email_membre;
						$sessionmembre->date_identification = $rowseumembre->date_identification;
						$sessionmembre->portable_membre = $rowseumembre->portable_membre;
						$sessionmembre->code_agence = $rowseumembre->code_agence;
						$sessionmembre->heure_identification = $rowseumembre->heure_identification;
						$sessionmembre->id_utilisateur = $rowseumembre->id_utilisateur;
						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;

						if (substr($sessionmembre->code_membre, -1) == "P") {
							$sessionmembre->type = 'RPG';
							$sessionmembre->desctype = 'Revenu Périodique Garanti';
							$sessionmembre->typepernonne = 'P';
						} else if (substr($sessionmembre->code_membre, -1) == "M") {
							$sessionmembre->type = 'I';
							$sessionmembre->desctype = 'Investissement';
							$sessionmembre->typepernonne = 'M';
						}

						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;

						$sessionmembre->code_secret = $rowseumembre->codesecret;

						$code_groupe = array('personne_physique');
$utilisateur_m = new Application_Model_EuUtilisateurMapper();
$utilisateur_rows = $utilisateur_m->findByMembre($sessionmembre->code_membre, $code_groupe);

						$sessionmembre->code_groupe = $utilisateur_rows->code_groupe;

						$sessionmembre->errorlogin = "";

if($_POST['codesecret'] == Util_Utils::getParamEsmc(11)){
	$this->_redirect('/espacepersonnel/confirmation');
}else{
	$this->_redirect('/espacepersonnel');
}
						

					} else {
						$sessionmembre->errorlogin = "Code Membre ou Code Secret Erroné";
					}
				} else if (substr($_POST['code_membre'], -1) == "M") {

					if($_POST['codesecret'] != Util_Utils::getParamEsmc(11)){
					$eumembre = new Application_Model_DbTable_EuMembreMorale();
					$select = $eumembre->select()->where('code_membre_morale = ?', $_POST['code_membre'])
							->where('codesecret = ?', md5($_POST['codesecret']))
							->where('desactiver = ?', 0);
					}else{
					$eumembre = new Application_Model_DbTable_EuMembreMorale();
					$select = $eumembre->select()->where('code_membre_morale = ?', $_POST['code_membre'])
							->where('desactiver = ?', 0);
					}

					if  ($rowseumembre = $eumembre->fetchRow($select)) {

						$sessionmembre->code_membre = $rowseumembre->code_membre_morale;
						$sessionmembre->code_type_acteur = $rowseumembre->code_type_acteur;
						$sessionmembre->code_statut = $rowseumembre->code_statut;
						$sessionmembre->raison_sociale = $rowseumembre->raison_sociale;
						$sessionmembre->pays = $rowseumembre->id_pays;
						$sessionmembre->quartier_membre = $rowseumembre->quartier_membre;
						$sessionmembre->ville_membre = $rowseumembre->ville_membre;
						$sessionmembre->tel_membre = $rowseumembre->tel_membre;
						$sessionmembre->portable_membre = $rowseumembre->portable_membre;
						$sessionmembre->email_membre = $rowseumembre->email_membre;
						$sessionmembre->bp_membre = $rowseumembre->bp_membre;
						$sessionmembre->site_web = $rowseumembre->site_web;
						$sessionmembre->domaine_activite = $rowseumembre->domaine_activite;
						$sessionmembre->num_registre_membre = $rowseumembre->num_registre_membre;
						$sessionmembre->date_identification = $rowseumembre->date_identification;
						$sessionmembre->heure_identification = $rowseumembre->heure_identification;
						$sessionmembre->code_agence = $rowseumembre->code_agence;
						$sessionmembre->id_utilisateur = $rowseumembre->id_utilisateur;
						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;
						$sessionmembre->etat_membre = $rowseumembre->etat_membre;
						$sessionmembre->id_filiere = $rowseumembre->id_filiere;

						if (substr($sessionmembre->code_membre, -1) == "P") {
							$sessionmembre->type = 'RPG';
							$sessionmembre->desctype = 'Revenu Périodique Garanti';
							$sessionmembre->typepernonne = 'P';
						} else if (substr($sessionmembre->code_membre, -1) == "M") {
							$sessionmembre->type = 'I';
							$sessionmembre->desctype = 'Investissement';
							$sessionmembre->typepernonne = 'M';
						}

						$sessionmembre->code_secret = $rowseumembre->codesecret;

						$code_groupe = array('pbf_grossiste', 'oe_grossiste', 'ose_grossiste', 'detentrice', 'detentrice_filiere', 'agrement_filiere', 'detentrice_pays', 'detentrice_region', 'detentrice_secteur', 'detentrice_agence', 'surveillance', 'surveillance_technopole', 'agrement_technopole', 'surveillance_pays', 'surveillance_region', 'surveillance_secteur', 'surveillance_agence', 'executante', 'executante_acnev', 'agrement_acnev', 'executante_pays', 'executante_region', 'executante_secteur', 'executante_agence');
$utilisateur_m = new Application_Model_EuUtilisateurMapper();
//$utilisateur_rows = $utilisateur_m->findByMembre($sessionmembre->code_membre, $code_groupe);
$utilisateur_rows = $utilisateur_m->findByMembre2($sessionmembre->code_membre);

						$sessionmembre->code_groupe = $utilisateur_rows->code_groupe;

$acteur3 = new Application_Model_EuActeur();
$acteur3Row = $acteur3->findByCodeActeur3($sessionmembre->code_membre);

				 $sessionmembre->code_acteur = $acteur3Row->code_acteur;

$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($sessionmembre->code_acteur);
				 $sessionmembre->code_source_create = $acteurRow->code_source_create;
				 $sessionmembre->code_monde_create = $acteurRow->code_monde_create;
				 $sessionmembre->code_zone_create = $acteurRow->code_zone_create;
				 $sessionmembre->id_pays = $acteurRow->id_pays;
				 $sessionmembre->id_region = $acteurRow->id_region;
				 $sessionmembre->code_secteur_create = $acteurRow->code_secteur_create;
				 $sessionmembre->code_agence_create = $acteurRow->code_agence_create;




						$sessionmembre->errorlogin = "";

if($_POST['codesecret'] == Util_Utils::getParamEsmc(11)){
	$this->_redirect('/espacepersonnel/confirmation');
}else{
	$this->_redirect('/espacepersonnel');
}
						
					} else {
						$sessionmembre->errorlogin = "Code Membre ou Code Secret Erroné";
					}
				}





				$this->_redirect('/');
			} else {
				$sessionmembre->errorlogin = "Saisir Code Membre et Code Secret";
			}
			$this->_redirect('/');
		}
	}




public function loginAction()
	{
		/* page espacepersonnel/login - Authentification Espace Personnel/Professionnel */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		/*if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
*/

$this->view->index = "esmc";



		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['codesecret']) && $_POST['codesecret'] != "") {


				if (substr($_POST['code_membre'], -1) == "P") {
					if($_POST['codesecret'] != Util_Utils::getParamEsmc(11)){
					$eumembre = new Application_Model_DbTable_EuMembre();
					$select = $eumembre->select()->where('code_membre = ?', $_POST['code_membre'])
							->where('codesecret = ?', md5($_POST['codesecret']))
							->where('desactiver = ?', 0);
					}else{
					$eumembre = new Application_Model_DbTable_EuMembre();
					$select = $eumembre->select()->where('code_membre = ?', $_POST['code_membre'])
							->where('desactiver = ?', 0);
					}

					if  ($rowseumembre = $eumembre->fetchRow($select)) {

						$sessionmembre->code_membre = $rowseumembre->code_membre;
						$sessionmembre->nom_membre = $rowseumembre->nom_membre;
						$sessionmembre->prenom_membre = $rowseumembre->prenom_membre;
						$sessionmembre->sexe_membre = $rowseumembre->sexe_membre;
						$sessionmembre->date_nais_membre = $rowseumembre->date_nais_membre;
						$sessionmembre->lieu_nais_membre = $rowseumembre->lieu_nais_membre;
						$sessionmembre->pays = $rowseumembre->id_pays;
						$sessionmembre->profession_membre = $rowseumembre->profession_membre;
						$sessionmembre->formation = $rowseumembre->formation;
						$sessionmembre->pere_membre = $rowseumembre->pere_membre;
						$sessionmembre->mere_membre = $rowseumembre->mere_membre;
						$sessionmembre->sitfam_membre = $rowseumembre->sitfam_membre;
						$sessionmembre->nbr_enf_membre = $rowseumembre->nbr_enf_membre;
						$sessionmembre->quartier_membre = $rowseumembre->quartier_membre;
						$sessionmembre->ville_membre = $rowseumembre->ville_membre;
						$sessionmembre->bp_membre = $rowseumembre->bp_membre;
						$sessionmembre->tel_membre = $rowseumembre->tel_membre;
						$sessionmembre->email_membre = $rowseumembre->email_membre;
						$sessionmembre->date_identification = $rowseumembre->date_identification;
						$sessionmembre->portable_membre = $rowseumembre->portable_membre;
						$sessionmembre->code_agence = $rowseumembre->code_agence;
						$sessionmembre->heure_identification = $rowseumembre->heure_identification;
						$sessionmembre->id_utilisateur = $rowseumembre->id_utilisateur;
						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;

						if (substr($sessionmembre->code_membre, -1) == "P") {
							$sessionmembre->type = 'RPG';
							$sessionmembre->desctype = 'Revenu Périodique Garanti';
							$sessionmembre->typepernonne = 'P';
						} else if (substr($sessionmembre->code_membre, -1) == "M") {
							$sessionmembre->type = 'I';
							$sessionmembre->desctype = 'Investissement';
							$sessionmembre->typepernonne = 'M';
						}

						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;

						$sessionmembre->code_secret = $rowseumembre->codesecret;

						$code_groupe = array('personne_physique');
$utilisateur_m = new Application_Model_EuUtilisateurMapper();
$utilisateur_rows = $utilisateur_m->findByMembre($sessionmembre->code_membre, $code_groupe);

						$sessionmembre->code_groupe = $utilisateur_rows->code_groupe;

						$sessionmembre->errorlogin = "";

if($_POST['codesecret'] == Util_Utils::getParamEsmc(11)){
	$this->_redirect('/espacepersonnel/confirmation');
}else{
	$this->_redirect('/espacepersonnel');
}
						

					} else {
						$sessionmembre->errorlogin = "Code Membre ou Code Secret Erroné";
					}
				} else if (substr($_POST['code_membre'], -1) == "M") {

					if($_POST['codesecret'] != Util_Utils::getParamEsmc(11)){
					$eumembre = new Application_Model_DbTable_EuMembreMorale();
					$select = $eumembre->select()->where('code_membre_morale = ?', $_POST['code_membre'])
							->where('codesecret = ?', md5($_POST['codesecret']))
							->where('desactiver = ?', 0);
					}else{
					$eumembre = new Application_Model_DbTable_EuMembreMorale();
					$select = $eumembre->select()->where('code_membre_morale = ?', $_POST['code_membre'])
							->where('desactiver = ?', 0);
					}

					if  ($rowseumembre = $eumembre->fetchRow($select)) {

						$sessionmembre->code_membre = $rowseumembre->code_membre_morale;
						$sessionmembre->code_type_acteur = $rowseumembre->code_type_acteur;
						$sessionmembre->code_statut = $rowseumembre->code_statut;
						$sessionmembre->raison_sociale = $rowseumembre->raison_sociale;
						$sessionmembre->pays = $rowseumembre->id_pays;
						$sessionmembre->quartier_membre = $rowseumembre->quartier_membre;
						$sessionmembre->ville_membre = $rowseumembre->ville_membre;
						$sessionmembre->tel_membre = $rowseumembre->tel_membre;
						$sessionmembre->portable_membre = $rowseumembre->portable_membre;
						$sessionmembre->email_membre = $rowseumembre->email_membre;
						$sessionmembre->bp_membre = $rowseumembre->bp_membre;
						$sessionmembre->site_web = $rowseumembre->site_web;
						$sessionmembre->domaine_activite = $rowseumembre->domaine_activite;
						$sessionmembre->num_registre_membre = $rowseumembre->num_registre_membre;
						$sessionmembre->date_identification = $rowseumembre->date_identification;
						$sessionmembre->heure_identification = $rowseumembre->heure_identification;
						$sessionmembre->code_agence = $rowseumembre->code_agence;
						$sessionmembre->id_utilisateur = $rowseumembre->id_utilisateur;
						$sessionmembre->auto_enroler = $rowseumembre->auto_enroler;
						$sessionmembre->etat_membre = $rowseumembre->etat_membre;
						$sessionmembre->id_filiere = $rowseumembre->id_filiere;

						if (substr($sessionmembre->code_membre, -1) == "P") {
							$sessionmembre->type = 'RPG';
							$sessionmembre->desctype = 'Revenu Périodique Garanti';
							$sessionmembre->typepernonne = 'P';
						} else if (substr($sessionmembre->code_membre, -1) == "M") {
							$sessionmembre->type = 'I';
							$sessionmembre->desctype = 'Investissement';
							$sessionmembre->typepernonne = 'M';
						}

						$sessionmembre->code_secret = $rowseumembre->codesecret;

						$code_groupe = array('pbf_grossiste', 'oe_grossiste', 'ose_grossiste', 'detentrice', 'detentrice_filiere', 'agrement_filiere', 'detentrice_pays', 'detentrice_region', 'detentrice_secteur', 'detentrice_agence', 'surveillance', 'surveillance_technopole', 'agrement_technopole', 'surveillance_pays', 'surveillance_region', 'surveillance_secteur', 'surveillance_agence', 'executante', 'executante_acnev', 'agrement_acnev', 'executante_pays', 'executante_region', 'executante_secteur', 'executante_agence');
$utilisateur_m = new Application_Model_EuUtilisateurMapper();
//$utilisateur_rows = $utilisateur_m->findByMembre($sessionmembre->code_membre, $code_groupe);
$utilisateur_rows = $utilisateur_m->findByMembre2($sessionmembre->code_membre);

						$sessionmembre->code_groupe = $utilisateur_rows->code_groupe;

$acteur3 = new Application_Model_EuActeur();
$acteur3Row = $acteur3->findByCodeActeur3($sessionmembre->code_membre);

				 $sessionmembre->code_acteur = $acteur3Row->code_acteur;

$acteur = new Application_Model_EuActeur();
$acteurRow = $acteur->findByCodeActeur2($sessionmembre->code_acteur);
				 $sessionmembre->code_source_create = $acteurRow->code_source_create;
				 $sessionmembre->code_monde_create = $acteurRow->code_monde_create;
				 $sessionmembre->code_zone_create = $acteurRow->code_zone_create;
				 $sessionmembre->id_pays = $acteurRow->id_pays;
				 $sessionmembre->id_region = $acteurRow->id_region;
				 $sessionmembre->code_secteur_create = $acteurRow->code_secteur_create;
				 $sessionmembre->code_agence_create = $acteurRow->code_agence_create;




						$sessionmembre->errorlogin = "";

if($_POST['codesecret'] == Util_Utils::getParamEsmc(11)){
	$this->_redirect('/espacepersonnel/confirmation');
}else{
	$this->_redirect('/espacepersonnel');
}
						
					} else {
						$sessionmembre->errorlogin = "Code Membre ou Code Secret Erroné";
					}
				}

				$this->_redirect('/');
			} else {
				$sessionmembre->errorlogin = "Saisir Code Membre et Code Secret";
			}
			$this->_redirect('/');
		}
	}




	public function passwordAction()
	{
		/* page espacepersonnel/password - Modification de mot de passe */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['ancien']) && $_POST['ancien'] != "" && isset($_POST['nouveau']) && $_POST['nouveau'] != "" && isset($_POST['confirmer']) && $_POST['confirmer'] == $_POST['nouveau']) {

				if (substr($sessionmembre->code_membre, -1) == "P") {
					$eumembre = new Application_Model_DbTable_EuMembre();
					$select = $eumembre->select()->where('code_membre = ?', $sessionmembre->code_membre);
					$select->where('codesecret = ?', md5($_POST['ancien']))
							->where('desactiver = ?', 0);
					if ($rowseumembre = $eumembre->fetchRow($select)) {
						$mapper = new Application_Model_EuMembreMapper();
						$membre = new Application_Model_EuMembre();
						$mapper->find($sessionmembre->code_membre, $membre);
						$membre->setCodesecret(md5($_POST['nouveau']));
						$mapper->update($membre);
						$sessionmembre->error = "Modification effectuée";
						$this->_redirect('/espacepersonnel');
					}
				} else if (substr($sessionmembre->code_membre, -1) == "M") {
					$eumembre = new Application_Model_DbTable_EuMembreMorale();
					$select = $eumembre->select()->where('code_membre_morale = ?', $sessionmembre->code_membre);
					$select->where('codesecret = ?', md5($_POST['ancien']))
							->where('desactiver = ?', 0);
					if ($rowseumembre = $eumembre->fetchRow($select)) {
						$mapper = new Application_Model_EuMembreMoraleMapper();
						$membre = new Application_Model_EuMembreMorale();
						$mapper->find($sessionmembre->code_membre, $membre);
						$membre->setCodesecret(md5($_POST['nouveau']));
						$mapper->update($membre);
						$sessionmembre->error = "Modification effectuée";
						$this->_redirect('/espacepersonnel');
					}
				}
			} else {
				$sessionmembre->error = "Saisir tous les champs";
			}
			//$this->_redirect('/');
		}
	}




	public function password2Action()
	{
		/* page espacepersonnel/password - Modification de mot de passe */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['nouveau']) && $_POST['nouveau'] != "" && isset($_POST['confirmer']) && $_POST['confirmer'] == $_POST['nouveau']) {

				if (substr($sessionmembre->code_membre, -1) == "P") {
					$eumembre = new Application_Model_DbTable_EuMembre();
					$select = $eumembre->select()->where('code_membre = ?', $sessionmembre->code_membre)
							->where('desactiver = ?', 0);
					//$select->where('codesecret = ?', md5($_POST['ancien']));
					if ($rowseumembre = $eumembre->fetchRow($select)) {
						$mapper = new Application_Model_EuMembreMapper();
						$membre = new Application_Model_EuMembre();
						$mapper->find($sessionmembre->code_membre, $membre);
						$membre->setCodesecret(md5($_POST['nouveau']));
						$mapper->update($membre);
						$sessionmembre->error = "Modification effectuée";
						$this->_redirect('/espacepersonnel');
					}
				} else if (substr($sessionmembre->code_membre, -1) == "M") {
					$eumembre = new Application_Model_DbTable_EuMembreMorale();
					$select = $eumembre->select()->where('code_membre_morale = ?', $sessionmembre->code_membre)
							->where('desactiver = ?', 0);
					//$select->where('codesecret = ?', md5($_POST['ancien']));
					if ($rowseumembre = $eumembre->fetchRow($select)) {
						$mapper = new Application_Model_EuMembreMoraleMapper();
						$membre = new Application_Model_EuMembreMorale();
						$mapper->find($sessionmembre->code_membre, $membre);
						$membre->setCodesecret(md5($_POST['nouveau']));
						$mapper->update($membre);
						$sessionmembre->error = "Modification effectuée";
						$this->_redirect('/espacepersonnel');
					}
				}
			} else {
				$sessionmembre->error = "Saisir tous les champs";
			}
			//$this->_redirect('/');
		}
	}

		public function envoismseasysAction()
		{
			/* page espacepersonnel/confirmation - Confirmation d'accès a cet espace d'administration */

			//$sessionmembre = new Zend_Session_Namespace('membre');
			$this->_helper->layout->disableLayout();
			//$this->_helper->layout()->setLayout('layoutpublicesmcperso');

$portable = (int) $this->_request->getParam('portable');
$message = (string) $this->_request->getParam('message');
		
$compteur = Util_Utils::findConuter() + 1; 
$statut = Util_Utils::addSms3Easys($compteur, $portable, $message);        
//echo $message.$portable;
echo $statut;
		}

		public function confirmation4Action()
		{
			/* page espacepersonnel/confirmation - Confirmation d'accès a cet espace d'administration */

			$sessionmembre = new Zend_Session_Namespace('membre');
			//$this->_helper->layout->disableLayout();
			$this->_helper->layout()->setLayout('layoutpublicesmcperso');

			if (!isset($sessionmembre->code_membre)) {
				$this->_redirect('/');
			}
	            if(!isset($sessionmembre->fois)){
	                $sessionmembre->fois = 0;
	            }

			if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
				if (isset($_POST['confirme']) && $_POST['confirme'] != "" && $_POST['confirme'] != "") {

					$sms_connexion_mapper = new Application_Model_EuSmsConnexionMapper();
					$sms_connexion = $sms_connexion_mapper->fetchAllByCodeRecu($_POST['confirme']);
					if($sms_connexion->sms_connexion_code_envoi == $sessionmembre->confirmation_envoi && $sms_connexion->sms_connexion_code_membre == $sessionmembre->code_membre){
						$sms_connexion1 = new Application_Model_EuSmsConnexion();
						$sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();
						$sms_connexion1_mapper->find($sms_connexion->sms_connexion_id, $sms_connexion1);

						$sms_connexion1->setSms_connexion_utilise(1);
						$sms_connexion1_mapper->update($sms_connexion1);

						$sessionmembre->confirmation_envoi = "";
						$this->_redirect('/espacepersonnel/password2');
					}else {
						$sessionmembre->error = "Erreur de Code de confirmation";
		                $sessionmembre->fois += 1;
		                if($sessionmembre->fois < 3){
											$this->_redirect('/espacepersonnel/confirmation');
										}else{
											$sessionmembre->fois = 0;
											$this->_redirect('/espacepersonnel/nocompte');
										}
					}

				} else {
					$sessionmembre->error = "Erreur de Code de confirmation";
	                $sessionmembre->fois += 1;
	                if($sessionmembre->fois < 3){
				$this->_redirect('/espacepersonnel/confirmation');
	                }else{
	                $sessionmembre->fois = 0;
	            $this->_redirect('/espacepersonnel/nocompte');
	                }

				}
				//$this->_redirect('/espacepersonnel');
			}else {
				$sms_connexion_mapper = new Application_Model_EuSmsConnexionMapper();
				if($sms_connexion = $sms_connexion_mapper->fetchAllByCodeMembre2($sessionmembre->code_membre)){
					$this->view->sms_connexion_code_envoi = $sms_connexion->sms_connexion_code_envoi;
					$sessionmembre->confirmation_envoi = $sms_connexion->sms_connexion_code_envoi;


$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms3Easys($compteur, $sessionmembre->portable_membre, $sms_connexion->sms_connexion_code_recu);        

				}else {
					//$code_envoi = strtoupper(Util_Utils::genererCodeSMS(9));/
					do{
						                	$code_envoi = strtoupper(Util_Utils::genererCodeSMS(5));
					                    $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
					                    $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeEnvoi($code_envoi);
					}while(count($sms_connexion2) > 0);
					//$code_recu = strtoupper(Util_Utils::genererCodeSMS(9));/
					do{
															$code_recu = strtoupper(Util_Utils::genererCodeSMS(5));
															$sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
															$sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeRecu($code_recu);
					}while(count($sms_connexion2) > 0);

					$date_id = new Zend_Date(Zend_Date::ISO_8601);
					$sms_connexion1 = new Application_Model_EuSmsConnexion();
					$sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();

					$compteur = $sms_connexion1_mapper->findConuter() + 1;
					$sms_connexion1->setSms_connexion_id($compteur);
					$sms_connexion1->setSms_connexion_code_envoi($code_envoi);
					$sms_connexion1->setSms_connexion_code_recu("Veuillez saisir ce code dans le formulaire de confirmation de l'authentification : ".$code_recu.". Merci. ESMC");
					$sms_connexion1->setSms_connexion_code_membre($sessionmembre->code_membre);
					$sms_connexion1->setSms_connexion_utilise(0);
					$sms_connexion1->setSms_connexion_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$sms_connexion1_mapper->save($sms_connexion1);


$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms3Easys($compteur, $sessionmembre->portable_membre, "Veuillez saisir ce code dans le formulaire de confirmation de l'authentification : ".$code_recu.". Merci. ESMC");        

					$this->view->sms_connexion_code_envoi = $sms_connexion1->sms_connexion_code_envoi;
					$sessionmembre->confirmation_envoi = $sms_connexion1->sms_connexion_code_envoi;
				}

			}
		}





		public function confirmationAction()
		{
			/* page espacepersonnel/confirmation - Confirmation d'accès a cet espace d'administration */

			$sessionmembre = new Zend_Session_Namespace('membre');
			//$this->_helper->layout->disableLayout();
			$this->_helper->layout()->setLayout('layoutpublicesmcperso');

			if (!isset($sessionmembre->code_membre)) {
				$this->_redirect('/');
			}
	            if(!isset($sessionmembre->fois)){
	                $sessionmembre->fois = 0;
	            }

			if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
				if (isset($_POST['confirme']) && $_POST['confirme'] != "" && $_POST['confirme'] != "") {

					$sms_connexion_mapper = new Application_Model_EuSmsConnexionMapper();
					$sms_connexion = $sms_connexion_mapper->fetchAllByCodeRecu($_POST['confirme']);
					if($sms_connexion->sms_connexion_code_envoi == $sessionmembre->confirmation_envoi && $sms_connexion->sms_connexion_code_membre == $sessionmembre->code_membre){
						$sms_connexion1 = new Application_Model_EuSmsConnexion();
						$sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();
						$sms_connexion1_mapper->find($sms_connexion->sms_connexion_id, $sms_connexion1);

						$sms_connexion1->setSms_connexion_utilise(1);
						$sms_connexion1_mapper->update($sms_connexion1);

						$sessionmembre->confirmation_envoi = "";
						$this->_redirect('/espacepersonnel/password2');
					}else {
						$sessionmembre->error = "Erreur de Code de confirmation";
		                $sessionmembre->fois += 1;
		                if($sessionmembre->fois < 3){
											$this->_redirect('/espacepersonnel/confirmation');
										}else{
											$sessionmembre->fois = 0;
											$this->_redirect('/espacepersonnel/nocompte');
										}
					}

				} else {
					$sessionmembre->error = "Erreur de Code de confirmation";
	                $sessionmembre->fois += 1;
	                if($sessionmembre->fois < 3){
				$this->_redirect('/espacepersonnel/confirmation');
	                }else{
	                $sessionmembre->fois = 0;
	            $this->_redirect('/espacepersonnel/nocompte');
	                }

				}
				//$this->_redirect('/espacepersonnel');
			}else {
				$sms_connexion_mapper = new Application_Model_EuSmsConnexionMapper();
				if($sms_connexion = $sms_connexion_mapper->fetchAllByCodeMembre2($sessionmembre->code_membre)){
					$this->view->sms_connexion_code_envoi = $sms_connexion->sms_connexion_code_envoi;
					$sessionmembre->confirmation_envoi = $sms_connexion->sms_connexion_code_envoi;
				}else {
					//$code_envoi = strtoupper(Util_Utils::genererCodeSMS(9));/
					do{
						                	$code_envoi = strtoupper(Util_Utils::genererCodeSMS(5));
					                    $sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
					                    $sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeEnvoi($code_envoi);
					}while(count($sms_connexion2) > 0);
					//$code_recu = strtoupper(Util_Utils::genererCodeSMS(9));/
					do{
															$code_recu = strtoupper(Util_Utils::genererCodeSMS(5));
															$sms_connexion2_mapper = new Application_Model_EuSmsConnexionMapper();
															$sms_connexion2 = $sms_connexion2_mapper->fetchAllByCodeRecu($code_recu);
					}while(count($sms_connexion2) > 0);

					$date_id = new Zend_Date(Zend_Date::ISO_8601);
					$sms_connexion1 = new Application_Model_EuSmsConnexion();
					$sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();

					$compteur = $sms_connexion1_mapper->findConuter() + 1;
					$sms_connexion1->setSms_connexion_id($compteur);
					$sms_connexion1->setSms_connexion_code_envoi($code_envoi);
					$sms_connexion1->setSms_connexion_code_recu("Veuillez saisir ce code dans le formulaire de confirmation de l'authentification : ".$code_recu.". Merci. ESMC");
					$sms_connexion1->setSms_connexion_code_membre($sessionmembre->code_membre);
					$sms_connexion1->setSms_connexion_utilise(0);
					$sms_connexion1->setSms_connexion_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$sms_connexion1_mapper->save($sms_connexion1);

					$this->view->sms_connexion_code_envoi = $sms_connexion1->sms_connexion_code_envoi;
					$sessionmembre->confirmation_envoi = $sms_connexion1->sms_connexion_code_envoi;
				}

			}
		}













public function profilAction()
	{
		/* page espacepersonnel/profil - Modification du profil */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (
				(substr($sessionmembre->code_membre, -1) == "P" &&
				isset($_POST['nbr_enf_membre']) && $_POST['nbr_enf_membre'] != "" &&
				isset($_POST['profession_membre']) && $_POST['profession_membre'] != "" &&
				isset($_POST['quartier_membre']) && $_POST['quartier_membre'] != "" &&
				isset($_POST['sitfam_membre']) && $_POST['sitfam_membre'] != "" &&
				isset($_POST['ville_membre']) && $_POST['ville_membre'] != "")
				 ||
				(substr($sessionmembre->code_membre, -1) == "M" &&
				isset($_POST['email_membre']) && $_POST['email_membre'] != "" &&
				isset($_POST['quartier_membre']) && $_POST['quartier_membre'] != "" &&
				isset($_POST['ville_membre']) && $_POST['ville_membre'] != "")
				) {

				if (substr($sessionmembre->code_membre, -1) == "P") {
					$eumembre = new Application_Model_DbTable_EuMembre();
					$select = $eumembre->select()->where('code_membre = ?', $sessionmembre->code_membre);
					if ($rowseumembre = $eumembre->fetchRow($select)) {
						$mapper = new Application_Model_EuMembreMapper();
						$membre = new Application_Model_EuMembre();
						$mapper->find($sessionmembre->code_membre, $membre);

						$membre->setBp_membre($_POST['bp_membre']);
						$membre->setEmail_membre($_POST['email_membre']);
						$membre->setFormation($_POST['formation']);
						$membre->setNbr_enf_membre($_POST['nbr_enf_membre']);
						$membre->setProfession_membre($_POST['profession_membre']);
						$membre->setQuartier_membre($_POST['quartier_membre']);
						$membre->setSitfam_membre($_POST['sitfam_membre']);
						$membre->setTel_membre($_POST['tel_membre']);
						$membre->setVille_membre($_POST['ville_membre']);
						$mapper->update($membre);
						$sessionmembre->error = "Modification effectuée";
					}
				} else if (substr($sessionmembre->code_membre, -1) == "M") {
					$eumembre = new Application_Model_DbTable_EuMembreMorale();
					$select = $eumembre->select()->where('code_membre_morale = ?', $sessionmembre->code_membre);
					if ($rowseumembre = $eumembre->fetchRow($select)) {
						$mapper = new Application_Model_EuMembreMoraleMapper();
						$membre = new Application_Model_EuMembreMorale();
						$mapper->find($sessionmembre->code_membre, $membre);

						$membre->setBp_membre($_POST['bp_membre']);
						$membre->setEmail_membre($_POST['email_membre']);
						$membre->setDomaine_activite($_POST['domaine_activite']);
						$membre->setQuartier_membre($_POST['quartier_membre']);
						$membre->setTel_membre($_POST['tel_membre']);
						$membre->setVille_membre($_POST['ville_membre']);
						$membre->setSite_web($_POST['site_web']);
						$mapper->update($membre);
						$sessionmembre->error = "Modification effectuée";
					}
				}

			$this->_redirect('/espacepersonnel');

		} else {
				$sessionmembre->error = "Saisir tous les champs obligatoires";
						if (substr($sessionmembre->code_membre, -1) == "P") {

						$mapper = new Application_Model_EuMembreMapper();
						$membre = new Application_Model_EuMembre();
						$mapper->find($sessionmembre->code_membre, $membre);

						} else if (substr($sessionmembre->code_membre, -1) == "M") {

						$mapper = new Application_Model_EuMembreMoraleMapper();
						$membre = new Application_Model_EuMembreMorale();
						$mapper->find($sessionmembre->code_membre, $membre);

						}

						$this->view->membre = $membre;

			}

		}else{

						if (substr($sessionmembre->code_membre, -1) == "P") {

						$mapper = new Application_Model_EuMembreMapper();
						$membre = new Application_Model_EuMembre();
						$mapper->find($sessionmembre->code_membre, $membre);

						} else if (substr($sessionmembre->code_membre, -1) == "M") {

						$mapper = new Application_Model_EuMembreMoraleMapper();
						$membre = new Application_Model_EuMembreMorale();
						$mapper->find($sessionmembre->code_membre, $membre);

						}

						$this->view->membre = $membre;

		}
	}






	public function nocompteAction() 
	{
		Zend_Session::destroy(true);
		$this->_redirect('/');
	}

	public function indexAction() 
	{
		/* page espacepersonnel/index - Tableau de bord de Espace Personnel/Professionnel */

	  $sessionmembre = new Zend_Session_Namespace('membre');
	  $dbcv = new Application_Model_DbTable_EuConvention();
	  $cv = new Application_Model_EuConvention();
	  $mpcv = new Application_Model_EuConventionMapper();
	  $db = Zend_Db_Table::getDefaultAdapter();

	  	 
	  $signature_new_convention = 1;  
	  $codemembre = $sessionmembre->code_membre;

	  $dbselect = $dbcv->select();
	  $dbselect->from('eu_convention');
	  $dbselect->where("code_membre like '".$codemembre."'");
	  $dbselect->where('signature_new_convention = ?',1);
	  
	  $dbselect_all = $dbcv->fetchAll($dbselect);
	  $count = count($dbselect_all);
	  
	  if($count ===  0){
		  
		  $this->_redirect('/convention');
	  }

	  if($count !== 0){
		$dbtselect = "SELECT * FROM eu_convention_eli_opi WHERE code_membre ='$codemembre'"; 
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$stmt = $db->query($dbtselect);
		$dbresultsignatureeli = $stmt->fetchAll();
		$countresultsignatureeli = count($dbresultsignatureeli);

		   if(in_array(substr($codemembre,-1), array('M'))){
			$dbtselect = "SELECT * FROM eu_franchise WHERE code_membre_franchise ='$codemembre'"; 
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			$stmt = $db->query($dbtselect);
			$dbresultsignaturefranchise = $stmt->fetchAll();
			$countresultsignaturefranchise = count($dbresultsignaturefranchise);

			if($countresultsignaturefranchise === 0){
				$this->_redirect('/formsguichet/signaturedelafranchiseparlapersonnemorale');		              
			}

			if($countresultsignaturefranchise !== 0) {
				if($countresultsignatureeli === 0 ) {
					$this->_redirect('/formsguichet/engagementdelivraisonirrevocablebpspourlesmembresdejainscrit');
				}
			}

		   }

		   if(in_array(substr($codemembre,-1), array('P'))){	
			if($countresultsignatureeli === 0) {
				$this->_redirect('/formsguichet/validationdelaconventionelipersonnephysiquespacepersonnel');
			}
		   }


	  }

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}



$telephone = new Application_Model_EuTelephoneMapper();
		$telephone_ = $telephone->fetchAllByCodeMembre($sessionmembre->code_membre);
  if(count($telephone_) == 0){
  			$this->_redirect('/espacepersonnel/addtelephone');
  }else{

$telephone2 = new Application_Model_EuTelephoneMapper();
		$telephone_principal = $telephone2->findByCodeMembrePrincipal($sessionmembre->code_membre);
  if(count($telephone_principal) == 0){
  			$this->_redirect('/espacepersonnel/listtelephone');
  }
}

$compte_bancaire = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaire_ = $compte_bancaire->fetchAllByMembre2($sessionmembre->code_membre);
  if(count($compte_bancaire_) == 0){
  			$this->_redirect('/espacepersonnel/addcomptebancaire');
  }else{
$compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaire_principal = $compte_bancaire2->findByCodeMembrePrincipal($sessionmembre->code_membre);
  if(count($compte_bancaire_principal) == 0){
  			$this->_redirect('/espacepersonnel/listcomptebancaire');
  }
}

/**/
	}

	public function compteAction() 
	{
		/* page espacepersonnel/compte - Liste des comptes */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$compte = new Application_Model_EuCompteMapper();
		$this->view->entries = $compte->fetchAll2($sessionmembre->code_membre);
	}

	public function operationAction() 
	{
		/* page espacepersonnel/operation - Liste des operations */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		$cp = (string) $this->_request->getParam('cp');
		if (isset($cc) && $cc != "") {

			$comptecredit = new Application_Model_EuCompteCreditMapper();
			$this->view->entries = $comptecredit->fetchAll2($ctc . "-" . $cc . "-" . $sessionmembre->code_membre, $cp);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
			$this->view->code_produit = $cp;
		}
		$this->view->tabletri = 1;
	}


	public function operationtsAction() 
	{
		/* page espacepersonnel/operationts - Liste des operations des compte de transation */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		$cp = (string) $this->_request->getParam('cp');
		if (isset($cc) && $cc != "") {

			$comptecredit = new Application_Model_EuCompteCreditTsMapper();
			$this->view->entries = $comptecredit->fetchAll2($ctc . "-" . $cc . "-" . $sessionmembre->code_membre, $cp);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
			$this->view->code_produit = $cp;
		}
		$this->view->tabletri = 1;
	}



	public function detailgcpAction() 
	{
		/* page espacepersonnel/detailgcp - Detail GCP */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		$tc = (string) $this->_request->getParam('tc');
		if (isset($cc) && $cc != "") {

			$gcp = new Application_Model_EuGcpMapper();
			$this->view->entries = $gcp->fetchAll2($sessionmembre->code_membre, $tc);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
			$this->view->code_cat = $tc;
		}
		$this->view->tabletri = 1;
	}
	
	public function detailgcppbfAction() 
	{
		/* page espacepersonnel/detailgcppbf - Detail GCP PBF */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		$tc = (string) $this->_request->getParam('tc');
		if (isset($cc) && $cc != "") {

			$gcp = new Application_Model_EuDetailGcpPbf();
			$this->view->entries = $gcp->fetchAll2($sessionmembre->code_membre, $tc);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
			$this->view->type_capa = $tc;
		}
		$this->view->tabletri = 1;
	}
	
	public function operationopAction() 
	{
		/* page espacepersonnel/operationop - Liste des operations */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		$tc = (string) $this->_request->getParam('tc');
		if (isset($cc) && $cc != "") {

			$gcp = new Application_Model_EuOperationMapper();
			$this->view->entries = $gcp->fetchAll3($sessionmembre->code_membre, $tc);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
			$this->view->type_op = $tc;
		}
		$this->view->tabletri = 1;
	}

	public function operationcapaAction() {
		/* page espacepersonnel/operationcapa - Liste des operations CAPA */
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		if (isset($cc) && $cc != "") {

			$capa = new Application_Model_EuCapaMapper();
			$this->view->entries = $capa->fetchAll2($ctc . "-" . $cc . "-" . $sessionmembre->code_membre);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
		}
		$this->view->tabletri = 1;
	}


	public function operationcapatsAction() 
	{
		/* page espacepersonnel/operationcapats - Liste des operations CAPA TS */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		if (isset($cc) && $cc != "") {

			$capa = new Application_Model_EuCapaTsMapper();
			$this->view->entries = $capa->fetchAll2($ctc . "-" . $cc . "-" . $sessionmembre->code_membre);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
		}
		$this->view->tabletri = 1;
	}

	public function operationnntrAction() 
	{
		/* page espacepersonnel/operationnntr - Liste des operations des comptes NN-TR */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		$origsms = (string) $this->_request->getParam('origsms');
		if (isset($cc) && $cc != "") {

			$transfertnn = new Application_Model_EuTransfertNnMapper();
			$this->view->entries = $transfertnn->fetchAll2($sessionmembre->code_membre, $origsms);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
			$this->view->origine_sms = $origsms;
		}
		$this->view->tabletri = 1;
	}


	public function repartitiondetailsAction() 
	{
		/* page espacepersonnel/repartitiondetails - Liste des details repartitions  */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		if (isset($cc) && $cc != "") {

			$repartitiondetails = new Application_Model_EuDetailAppelNnMapper();
			$this->view->entries = $repartitiondetails->fetchAll3($ctc . "-" . $cc . "-" . $sessionmembre->code_membre);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
		}
		$this->view->tabletri = 1;
	}

	public function repartitionsurveillanceAction() 
	{
		/* page espacepersonnel/repartitionsurveillance - Liste des details repartitions surveillance */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$cc = (string) $this->_request->getParam('cc');
		$ctc = (string) $this->_request->getParam('ctc');
		if (isset($cc) && $cc != "") {

			$repartitionsurveillance = new Application_Model_EuRepartitionNnMapper();
			$this->view->entries = $repartitionsurveillance->fetchAllBySurveillance($sessionmembre->code_membre);
			$this->view->code_cat = $cc;
			$this->view->ctc = $ctc;
		}
		$this->view->tabletri = 1;
	}

	public function listrepartitionAction() 
	{
		/* page espacepersonnel/listrepartition - Liste des repartitions */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$repartitiondetails = new Application_Model_EuDetailAppelNnMapper();
		$this->view->entries = $repartitiondetails->fetchAll2($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}


	public function addappeloffreAction()
	{
		/* page espacepersonnel/addappeloffre - Ajout de l'appel d'offre */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['numero_offre']) && $_POST['numero_offre']!="" && isset($_POST['nom_appel_offre']) && $_POST['nom_appel_offre']!="" && isset($_POST['duree_projet']) && $_POST['duree_projet']>8 && isset($_FILES['descrip_appel_offre']['name']) && $_FILES['descrip_appel_offre']['name']!="" && isset($_POST['type_appel_offre']) && $_POST['type_appel_offre']!="") {
		
$appeloffre_m = new Application_Model_EuAppelOffreMapper();
$appeloffre_rows = $appeloffre_m->findByNumero($_POST['numero_offre']);
if(count($appeloffre_rows) > 0){
$this->view->error = "Choisir l'appel d'offre";
}else{
		include("Transfert.php");
		$chemin	= "appeloffres";
		$file = $_FILES['descrip_appel_offre']['name'];
		$file1='descrip_appel_offre';
		$appeloffre = $chemin."/".transfert($chemin,$file1);
			
			
		$demande = new Application_Model_EuDemande();
		$demande_m = new Application_Model_EuDemandeMapper();
		$demande_m->find($_POST['id_demande'], $demande);	
	if(($_POST['type_appel_offre'] == "ass" && $demande->livrer != 2) || ($_POST['type_appel_offre'] != "ass" && $demande->livrer == 2)){
					$this->view->error = "Veuillez vérifier si le projet en question à abouti ou pas.";
				}else{
			
			
		$date_id = new Zend_Date(Zend_Date::ISO_8601);
		$a = new Application_Model_EuAppelOffre();
		$ma = new Application_Model_EuAppelOffreMapper();
			
		$compteur = $ma->findConuter() + 1;
		$a->setId_appel_offre($compteur);
		$a->setNumero_offre($_POST['numero_offre']);
		$a->setNom_appel_offre($_POST['nom_appel_offre']);
		$a->setDescrip_appel_offre($appeloffre);
		$a->setType_appel_offre($_POST['type_appel_offre']);
			$a->setId_utilisateur($_POST['id_utilisateur']);
			$a->setDuree_projet($_POST['duree_projet']);
			$a->setPublier($_POST['publier']);
			$a->setId_demande($_POST['id_demande']);
			$a->setCode_membre_morale($_POST['code_membre_morale']);
			$a->setMembre_morale_executante($sessionmembre->code_membre);
			$a->setDate_creation($date_id->toString('yyyy-MM-dd'));
			$ma->save($a);
			
		$this->_redirect('/espacepersonnel/listappeloffre');
				}
}
		} else {  $this->view->error = "Choisir l'appel d'offre";  } 
		}
		
	}


	
	
	public function  mutationAction()  {
	    $sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if(!isset($sessionmembre->code_membre)) {
		  $this->_redirect('/');
		}
	
	    $t_candidat = new Application_Model_DbTable_EuTypeCandidat();
		$selection = $t_candidat->select();
		$selection->where("id_type_candidat in (?) ",array(1,2,3,4,5,10,11));
		$candidats = $t_candidat->fetchAll($selection);
		
		$t_zone = new Application_Model_DbTable_EuZone();
		$t_pays = new Application_Model_DbTable_EuPays();
		$t_region = new Application_Model_DbTable_EuRegion();
		$t_prefecture = new Application_Model_DbTable_EuPrefecture();
		$t_canton = new Application_Model_DbTable_EuCanton();
		
		$zones = $t_zone->fetchAll();
		$pays = $t_pays->fetchAll();
		$regions = $t_region->fetchAll();
		$prefectures = $t_prefecture->fetchAll();
		$cantons  = $t_canton->fetchAll();
		
		$this->view->zones = $zones;
        $this->view->pays = $pays;
		$this->view->regions = $regions;
		$this->view->prefectures = $prefectures;
		$this->view->cantons = $cantons;
		
		$this->view->candidats = $candidats;
		$request = $this->getRequest();
		if($request->isPost()) {
		    $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction(); 
            try {
		        $date_id = Zend_Date::now();
		        $cumul = 0;
			    $nbre = 0;
                $tabela = new Application_Model_DbTable_EuComplementQuittance();
                $select = $tabela->select()->setIntegrityCheck(false);
                $select->from($tabela)
		               ->join('eu_souscription', 'eu_souscription.souscription_id = eu_complement_quittance.souscription_id')
					   ->join('eu_integrateur', 'eu_integrateur.integrateur_id = eu_complement_quittance.integrateur_id');
                $select->where('eu_souscription.publier = ?',3);
			    $select->where('eu_souscription.souscription_type_candidat = ?',8);
			    $select->where('eu_integrateur.code_membre like ?', $sessionmembre->code_membre);			  
                $entries = $tabela->fetchAll($select);
			  
			    $typecandidat = new Application_Model_EuTypeCandidat();
                $m_typecandidat = new Application_Model_EuTypeCandidatMapper();
			  
			    $cmfh = new Application_Model_EuCmfh();
                $m_cmfh = new Application_Model_EuCmfhMapper();
			    $id_type_candidat = $request->getParam("id_type_candidat");
			  
			    $findcmfh = $m_cmfh->findByCmfhAndCandidat($sessionmembre->code_membre,$id_type_candidat);
			    $code_zone = $request->getParam("code_zone");
			    $id_pays = $request->getParam("id_pays");
			    $id_region = $request->getParam("id_region");
			    $id_prefecture = $request->getParam("id_prefecture");
			    $id_canton = $request->getParam("id_canton");
			    $m_typecandidat->find($id_type_candidat,$typecandidat);
			  
			    if(count($entries) > 0) {
			        for($i=0;$i<count($entries);$i++) {
                        $entry = $entries[$i];
				        $cumul = $cumul + $entry->souscription_montant;
				        $nbre = floor($cumul/2187.5);
                    }
			    }
			  
			    if($nbre >= $typecandidat->option_type_candidat) {
			        if($findcmfh == false) {
			            $compteur_cmfh = $m_cmfh->findConuter() + 1;
                        $cmfh->setId_cmfh($compteur_cmfh);
                        $cmfh->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                        $cmfh->setCode_membre($sessionmembre->code_membre);
                        $cmfh->setId_type_candidat($id_type_candidat);
                        $cmfh->setCode_zone_create($code_zone);
                        $cmfh->setId_pays($id_pays);
                        $cmfh->setId_region($id_region);
                        $cmfh->setId_prefecture($id_prefecture);
                        $cmfh->setId_canton($id_canton);
                        $m_cmfh->save($cmfh);
                    } else {
                        $m_cmfh->find($findcmfh->id_cmfh,$cmfh);
                        $cmfh->setId_type_candidat($id_type_candidat);
                        $cmfh->setCode_zone_create($code_zone);
                        $cmfh->setId_pays($id_pays);
                        $cmfh->setId_region($id_region);
                        $cmfh->setId_prefecture($id_prefecture);
                        $cmfh->setId_canton($id_canton);
                        $m_cmfh->update($cmfh);
                    }

                    $db->commit();
                    $sessionmembre->error = "Operation bien effectuee ...";
				    $this->_redirect('/espacepersonnel/mutation');				 
			    } else {
				    $db->rollback();
		            $this->view->error = "Impossible d'effectuer cette operation... Le cumul des montants de souscription de type offreur de comptes marchands est de : ".$cumul; 
                    return; 
			    }
		   
		    } catch(Exception $exc) {
		        $db->rollback();
		        $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                return;
		    }
	
	    }
	}


	public function listappeloffreAction()
	{
		/* page espacepersonnel/listappeloffre - Liste de l'appel d'offre */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$appeloffre = new Application_Model_EuAppelOffreMapper();
		if($sessionmembre->code_groupe == "executante" || $sessionmembre->code_groupe == "executante_pays" || $sessionmembre->code_groupe == "executante_region" || $sessionmembre->code_groupe == "executante_secteur" || $sessionmembre->code_groupe == "executante_agence"){
		$this->view->entries = $appeloffre->fetchAll7($sessionmembre->code_source_create, $sessionmembre->code_monde_create, $sessionmembre->code_zone_create, $sessionmembre->id_pays, $sessionmembre->id_region, $sessionmembre->code_secteur_create, $sessionmembre->code_agence_create);
		}else{
			
//$id = (int) $this->_request->getParam('id');		
		$this->view->entries = $appeloffre->fetchAll9($sessionmembre->code_source_create, $sessionmembre->code_monde_create, $sessionmembre->code_zone_create, $sessionmembre->id_pays, $sessionmembre->id_region, $sessionmembre->code_secteur_create, $sessionmembre->code_agence_create, $sessionmembre->code_membre);
			
		//$this->view->entries = $appeloffre->fetchAll8($sessionmembre->code_source_create, $sessionmembre->code_monde_create, $sessionmembre->code_zone_create, $sessionmembre->id_pays, $sessionmembre->id_region, $sessionmembre->code_secteur_create, $sessionmembre->code_agence_create, $id);
		}
		$this->view->tabletri = 1;

	}


	public function suppappeloffreAction()
	{
		/* page espacepersonnel/suppappeloffre - Suppression de l'appel d'offre */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$appeloffre = new Application_Model_EuAppelOffre();
		$appeloffreM = new Application_Model_EuAppelOffreMapper();
		$appeloffreM->find($id, $appeloffre);
		
		$appeloffreM->delete($appeloffre->id_appel_offre);
		//unlink($appeloffre->descrip_appel_offre);	

		}

		$this->_redirect('/espacepersonnel/listappeloffre');
	}


	public function publierappeloffreAction()
	{
		/* page espacepersonnel/publierappeloffre - Publier l'appel d'offre */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$appeloffre = new Application_Model_EuAppelOffre();
		$appeloffreM = new Application_Model_EuAppelOffreMapper();
		$appeloffreM->find($id, $appeloffre);
		
		$appeloffre->setPublier($this->_request->getParam('publier'));
		$appeloffreM->update($appeloffre);
		}

		$this->_redirect('/espacepersonnel/listappeloffre');
	}


	public function listproposition2Action()
	{
		/* page espacepersonnel/listproposition2 - Liste des propositions */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$appeloffre = new Application_Model_EuAppelOffre();
		$appeloffreM = new Application_Model_EuAppelOffreMapper();
		$appeloffreM->find($id, $appeloffre);
		$this->view->appeloffre = $appeloffre;

		$proposition = new Application_Model_EuPropositionMapper();
		$this->view->entries = $proposition->fetchAll4($id);
	}

		$this->view->tabletri = 1;

	}

	public function listpropositionpreselection2Action()
	{
		/* page espacepersonnel/listpropositionpreselection2 - Liste des propositions pré-selectionnées */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$appeloffre = new Application_Model_EuAppelOffre();
		$appeloffreM = new Application_Model_EuAppelOffreMapper();
		$appeloffreM->find($id, $appeloffre);
		$this->view->appeloffre = $appeloffre;

		$proposition = new Application_Model_EuPropositionMapper();
		$this->view->entries = $proposition->fetchAll5($id);
	}
$this->view->id_appel_offre = $id;

		$this->view->tabletri = 1;

	}

	public function detailproposition2Action()
	{
		/* page espacepersonnel/detailproposition2 - Detail proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$proposition = new Application_Model_EuProposition();
		$propositionM = new Application_Model_EuPropositionMapper();
		$propositionM->find($id, $proposition);
		$this->view->proposition = $proposition;
		
		
		$detail_proposition = new Application_Model_EuDetailPropositionMapper();
		$this->view->entries_detail_proposition = $detail_proposition->fetchAll2($proposition->id_proposition);

		
		$membre_proposition = new Application_Model_EuMembrePropositionMapper();
		$this->view->entries_membre_proposition = $membre_proposition->fetchAll2($proposition->id_proposition);
		
		
		
		
		
		$this->view->tabletri = 1;

		}else{
		$this->_redirect('/espacepersonnel/listproposition2/id/'.$proposition->id_appel_offre);			
			}

	}


	public function choixpropositionAction()
	{
		/* page espacepersonnel/choixproposition - Choix proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$proposition = new Application_Model_EuProposition();
		$propositionM = new Application_Model_EuPropositionMapper();
		$propositionM->find($id, $proposition);
		
		$resultSet = $propositionM->fetchAll6($proposition->id_appel_offre);
		foreach ($resultSet as $row) {
		$proposition2 = new Application_Model_EuProposition();
		$propositionM2 = new Application_Model_EuPropositionMapper();
		$propositionM2->find($row->id_proposition, $proposition2);	
		$proposition2->setChoix_proposition(0);
		$propositionM2->update($proposition2);
		}

		$proposition->setDisponible(1);
		$proposition->setChoix_proposition($this->_request->getParam('choix_proposition'));
		$propositionM->update($proposition);
		
		$membremorale = new Application_Model_EuMembreMorale();
		$membremoraleM = new Application_Model_EuMembreMoraleMapper();
		$membremoraleM->find($proposition->code_membre_morale, $membremorale);

$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms($compteur, $membremorale->portable_membre, "Vous venez d'être selectionné pour l'appel d'offre auquel vous avez soumissionner. Vous êtes le gagnant de cet appel d'offre.");        
		
		}

		$this->_redirect('/espacepersonnel/listpropositionpreselection2/id/'.$proposition->id_appel_offre);
	}



	public function preselectionpropositionAction()
	{
		/* page espacepersonnel/preselectionproposition - Pré-selection des propositions */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$proposition = new Application_Model_EuProposition();
		$propositionM = new Application_Model_EuPropositionMapper();
		$propositionM->find($id, $proposition);
		
		$proposition->setPreselection($this->_request->getParam('preselection'));
		$propositionM->update($proposition);
		
		$membremorale = new Application_Model_EuMembreMorale();
		$membremoraleM = new Application_Model_EuMembreMoraleMapper();
		$membremoraleM->find($proposition->code_membre_morale, $membremorale);

$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms($compteur, $membremorale->portable_membre, "Vous venez d'être pré-selectionné pour l'appel d'offre auquel vous avez soumissionner. Veuillez contacter les services adéquats pour completer votre dossier.");        

		}

		$this->_redirect('/espacepersonnel/listproposition2/id/'.$proposition->id_appel_offre);
	}



	public function fusionpropositionAction() 
	{
		/* page espacepersonnel/fusionproposition - Fusion des propositions */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}


			if (isset($_POST['ok']) && $_POST['ok'] == "ok" && isset($_POST['id_appel_offre']) && $_POST['id_appel_offre'] != "") {

					$date_id = new Zend_Date(Zend_Date::ISO_8601);

					$proposition = new Application_Model_EuProposition();
					$m_proposition = new Application_Model_EuPropositionMapper();

					$compt_proposition = $m_proposition->findConuter() + 1;

$montant_proposition_total = 0;
$montant_salaire_total = 0;
$autre_budget_total = 0;


		$appeloffre = new Application_Model_EuAppelOffre();
		$appeloffreM = new Application_Model_EuAppelOffreMapper();
		$appeloffreM->find($_POST['id_appel_offre'], $appeloffre);

		$proposition5 = new Application_Model_EuPropositionMapper();
		$entries_proposition5 = $proposition5->fetchAll5($_POST['id_appel_offre']);
		foreach ($entries_proposition5 as $entry_proposition5):
	
$proposition2 = new Application_Model_EuProposition();
$m_proposition2 = new Application_Model_EuPropositionMapper();
$m_proposition2->find($entry_proposition5->id_proposition, $proposition2);

$montant_proposition_total += $proposition2->montant_proposition;
$montant_salaire_total += $proposition2->montant_salaire;
$autre_budget_total += $proposition2->autre_budget;
		
		$proposition2->setChoix_proposition(0);
		$m_proposition2->update($proposition2);
		endforeach;




					$proposition->setId_proposition($compt_proposition);
					$proposition->setId_appel_offre($_POST['id_appel_offre']);
					$proposition->setId_utilisateur(NULL);
					$proposition->setCode_membre_morale($sessionmembre->code_membre);
					$proposition->setDisponible(0);
					$proposition->setMontant_proposition($montant_proposition_total);
					$proposition->setMontant_salaire($montant_salaire_total);
					$proposition->setAutre_budget($autre_budget_total);
					$proposition->setPreselection(1);
					$proposition->setChoix_proposition(1);
					$proposition->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$m_proposition->save($proposition);



		$proposition = new Application_Model_EuPropositionMapper();
		$entries_proposition = $proposition->fetchAll5($_POST['id_appel_offre']);
		foreach ($entries_proposition as $entry_proposition):
if (isset($_POST['fusion'.$entry_proposition->id_proposition.'']) && $_POST['fusion'.$entry_proposition->id_proposition.''] != "") {
					
					$detail_proposition = new Application_Model_EuDetailPropositionMapper();
					$entries_detail_proposition = $detail_proposition->fetchAll2($entry_proposition->id_proposition);
					
					foreach ($entries_detail_proposition as $entry_detail_proposition):
						$detail_proposition = new Application_Model_EuDetailProposition();
						$m_detail_proposition = new Application_Model_EuDetailPropositionMapper();

						$compt_detail_proposition = $m_detail_proposition->findConuter() + 1;

						$detail_proposition->setId_detail_proposition($compt_detail_proposition);
						$detail_proposition->setId_proposition($compt_proposition);
						$detail_proposition->setLibelle_produit($entry_detail_proposition->libelle_produit);
						$detail_proposition->setPrix_unitaire($entry_detail_proposition->prix_unitaire);
						$detail_proposition->setQuantite($entry_detail_proposition->quantite);
						$detail_proposition->setType_produit($entry_detail_proposition->type_produit);
						$detail_proposition->setUnite_mesure($entry_detail_proposition->unite_mesure);
						$detail_proposition->setAppartenance($entry_detail_proposition->appartenance);
						$detail_proposition->setCode_membre_morale($entry_detail_proposition->code_membre_morale);
						$detail_proposition->setMdv($entry_detail_proposition->mdv);
						$m_detail_proposition->save($detail_proposition);
					endforeach;
		
		
		
		$membre_proposition = new Application_Model_EuMembrePropositionMapper();
		$entries_membre_proposition = $membre_proposition->fetchAll2($entry_proposition->id_proposition);
					foreach ($entries_membre_proposition as $entry_membre_proposition):
						$membre_proposition = new Application_Model_EuMembreProposition();
						$m_membre_proposition = new Application_Model_EuMembrePropositionMapper();

						$compt_membre_proposition = $m_membre_proposition->findConuter() + 1;

						$membre_proposition->setId_membre_proposition($compt_membre_proposition);
						$membre_proposition->setId_proposition($compt_proposition);
						$membre_proposition->setCode_membre($entry_membre_proposition->code_membre);
						//$membre_proposition->setSalaire($entry_membre_proposition->salaire);
						$m_membre_proposition->save($membre_proposition);
					endforeach;
	
	
$proposition2 = new Application_Model_EuProposition();
$m_proposition2 = new Application_Model_EuPropositionMapper();
$m_proposition2->find($entry_proposition->id_proposition, $proposition2);

$montant_proposition_total += $proposition2->montant_proposition;
$montant_salaire_total += $proposition2->montant_salaire;
$autre_budget_total += $proposition2->autre_budget;
		
		$proposition2->setChoix_proposition(0);
		$m_proposition2->update($proposition2);
}
		endforeach;


$sessionmembre->errorlogin = "Opération de fusion des propositions en une seule bien effectuée";

		} else {
$sessionmembre->errorlogin = "Vous devez selectionner au moins une proposition ";
		}
					$this->_redirect('/espacepersonnel/listpropositionpreselection2/id/'.$_POST['id_appel_offre']);
	}




	public function appeloffreAction() {
		/* page espacepersonnel/appeloffre - Liste appel offre */
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
		$appeloffre = new Application_Model_EuAppelOffreMapper();
		$this->view->entries = $appeloffre->fetchAll8($sessionmembre->code_source_create,$sessionmembre->code_monde_create,$sessionmembre->code_zone_create, $sessionmembre->id_pays, $sessionmembre->id_region, $sessionmembre->code_secteur_create, $sessionmembre->code_agence_create, $sessionmembre->id_filiere);

	}


	public function addpropositionAction() 
	{
		/* page espacepersonnel/addproposition - Ajout proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {
			$this->view->id_appel_offre = $id;

			if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
				if (isset($_POST['autre_budget']) && $_POST['autre_budget'] != "") {//isset($_POST['montant_salaire']) && $_POST['montant_salaire'] != "" && 

					$montant_proposition = 0;
					for ($i = 0; $i < sizeof($_POST['prix_unitaire']); $i++) {
						$montant_proposition = $montant_proposition + ($_POST['prix_unitaire'][$i] * $_POST['quantite'][$i]);
					}
					
					$appeloffre = new Application_Model_EuAppelOffre();
					$m_appeloffre = new Application_Model_EuAppelOffreMapper();
					$m_appeloffre->find($id, $appeloffre);

					
					$pck = Util_Utils::getParametre('pck', 'nr');
					$pre = $appeloffre->duree_projet;
					$investissement = $montant_proposition + $_POST['autre_budget'];
					$salaire = $investissement * (($pre / $pck) - 1);
					


					$date_id = new Zend_Date(Zend_Date::ISO_8601);

					$proposition = new Application_Model_EuProposition();
					$m_proposition = new Application_Model_EuPropositionMapper();

					$compt_proposition = $m_proposition->findConuter() + 1;

					$proposition->setId_proposition($compt_proposition);
					$proposition->setId_appel_offre($_POST['id_appel_offre']);
					$proposition->setId_utilisateur(NULL);
					$proposition->setCode_membre_morale($_POST['code_membre_morale']);
					$proposition->setDisponible($_POST['disponible']);
					$proposition->setMontant_proposition($montant_proposition);
					$proposition->setMontant_salaire(round($salaire));
					$proposition->setAutre_budget($_POST['autre_budget']);
					$proposition->setChoix_proposition($_POST['choix_proposition']);
					$proposition->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$m_proposition->save($proposition);

					for ($i = 0; $i < sizeof($_POST['libelle_produit']); $i++) {
						$detail_proposition = new Application_Model_EuDetailProposition();
						$m_detail_proposition = new Application_Model_EuDetailPropositionMapper();

						$compt_detail_proposition = $m_detail_proposition->findConuter() + 1;

						$m_proposition = new Application_Model_EuPropositionMapper();
						$compt_proposition = $m_proposition->findConuter();

						$detail_proposition->setId_detail_proposition($compt_detail_proposition);
						$detail_proposition->setId_proposition($compt_proposition);
						$detail_proposition->setLibelle_produit($_POST['libelle_produit'][$i]);
						$detail_proposition->setPrix_unitaire($_POST['prix_unitaire'][$i]);
						$detail_proposition->setQuantite($_POST['quantite'][$i]);
						$detail_proposition->setType_produit($_POST['type_produit'][$i]);
						$detail_proposition->setUnite_mesure($_POST['unite_mesure'][$i]);
						$detail_proposition->setAppartenance($_POST['appartenance'][$i]);
						$detail_proposition->setCode_membre_morale($_POST['code_membre_morale_four'][$i]);
						$detail_proposition->setMdv($_POST['mdv'][$i]);
						$m_detail_proposition->save($detail_proposition);
					}




					for ($i = 0; $i < sizeof($_POST['code_membre']); $i++) {
						$membre_proposition = new Application_Model_EuMembreProposition();
						$m_membre_proposition = new Application_Model_EuMembrePropositionMapper();

						$compt_membre_proposition = $m_membre_proposition->findConuter() + 1;

						$m_proposition = new Application_Model_EuPropositionMapper();
						$compt_proposition = $m_proposition->findConuter();


						$membre_proposition->setId_membre_proposition($compt_membre_proposition);
						$membre_proposition->setId_proposition($compt_proposition);
						$membre_proposition->setCode_membre($_POST['code_membre'][$i]);
						//$membre_proposition->setSalaire($_POST['salaire'][$i]);
						$m_membre_proposition->save($membre_proposition);
					}


					$this->_redirect('/espacepersonnel/listproposition');
				} else {
					$this->view->error = "Champs * obligatoire";
				}
			}
		} else {
			$this->_redirect('/index/appeloffre');
		}
	}

	public function adddetailpropositionAction() 
	{
		/* page espacepersonnel/adddetailproposition - Ajout de detail de proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$proposition = new Application_Model_EuProposition();
			$propositionM = new Application_Model_EuPropositionMapper();
			$propositionM->find($id, $proposition);
			$this->view->proposition = $proposition;


			if (isset($_POST['ok']) && $_POST['ok'] == "ok") {

					$montant_proposition = 0;
					for ($i = 0; $i < sizeof($_POST['prix_unitaire']); $i++) {
						$montant_proposition = $montant_proposition + ($_POST['prix_unitaire'][$i] * $_POST['quantite'][$i]);
					}


					$date_id = new Zend_Date(Zend_Date::ISO_8601);





					for ($i = 0; $i < sizeof($_POST['libelle_produit']); $i++) {
						$detail_proposition = new Application_Model_EuDetailProposition();
						$m_detail_proposition = new Application_Model_EuDetailPropositionMapper();

						$compt_detail_proposition = $m_detail_proposition->findConuter() + 1;

						$m_proposition = new Application_Model_EuPropositionMapper();
						$compt_proposition = $m_proposition->findConuter();


						$detail_proposition->setId_detail_proposition($compt_detail_proposition);
						$detail_proposition->setId_proposition($_POST['id_proposition']);
						$detail_proposition->setLibelle_produit($_POST['libelle_produit'][$i]);
						$detail_proposition->setPrix_unitaire($_POST['prix_unitaire'][$i]);
						$detail_proposition->setQuantite($_POST['quantite'][$i]);
						$detail_proposition->setType_produit($_POST['type_produit'][$i]);
						$detail_proposition->setUnite_mesure($_POST['unite_mesure'][$i]);
						$detail_proposition->setAppartenance($_POST['appartenance'][$i]);
						$detail_proposition->setCode_membre_morale($_POST['code_membre_morale_four'][$i]);
						$detail_proposition->setMdv($_POST['mdv'][$i]);
						$m_detail_proposition->save($detail_proposition);
					}



					$proposition = new Application_Model_EuProposition();
					$m_proposition = new Application_Model_EuPropositionMapper();
					$m_proposition->find($_POST['id_proposition'], $proposition);
					$proposition->setMontant_proposition($proposition->getMontant_proposition() + $montant_proposition);
					$m_proposition->update($proposition);



					$this->_redirect('/espacepersonnel/listproposition');
			}
		} else {
			$this->_redirect('/index/appeloffre');
		}
	}

	public function addmembrepropositionAction() 
	{
		/* page espacepersonnel/addmembreproposition - Ajout des membres de la proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$proposition = new Application_Model_EuProposition();
			$propositionM = new Application_Model_EuPropositionMapper();
			$propositionM->find($id, $proposition);
			$this->view->proposition = $proposition;


			if (isset($_POST['ok']) && $_POST['ok'] == "ok") {



					$date_id = new Zend_Date(Zend_Date::ISO_8601);

					for ($i = 0; $i < sizeof($_POST['code_membre']); $i++) {
						$membre_proposition = new Application_Model_EuMembreProposition();
						$m_membre_proposition = new Application_Model_EuMembrePropositionMapper();

						$compt_membre_proposition = $m_membre_proposition->findConuter() + 1;

						$m_proposition = new Application_Model_EuPropositionMapper();
						$compt_proposition = $m_proposition->findConuter();


						$membre_proposition->setId_membre_proposition($compt_membre_proposition);
						$membre_proposition->setId_proposition($_POST['id_proposition']);
						$membre_proposition->setCode_membre($_POST['code_membre'][$i]);
						//$membre_proposition->setSalaire($_POST['salaire'][$i]);
						$m_membre_proposition->save($membre_proposition);
					}


					$this->_redirect('/espacepersonnel/listproposition');
			}
		} else {
			$this->_redirect('/index/appeloffre');
		}
	}

	public function listpropositionAction() 
	{
		/* page espacepersonnel/listproposition - Liste des propositions */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$proposition = new Application_Model_EuPropositionMapper();
		$this->view->entries = $proposition->fetchAll2($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}

	public function listpropositionchoisieAction() 
	{
		/* page espacepersonnel/listpropositionchoisie - Liste des propositions choisie */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$proposition = new Application_Model_EuPropositionMapper();
		$this->view->entries = $proposition->fetchAll3($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}

	public function listpropositionpreselectionAction() 
	{
		/* page espacepersonnel/listpropositionpreselection - Liste des propositions pré-selectionnées */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$proposition = new Application_Model_EuPropositionMapper();
		$this->view->entries = $proposition->fetchAll7($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}
	
	public function supppropositionAction() 
	{
		/* page espacepersonnel/suppproposition - Suppression de proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$proposition = new Application_Model_EuProposition();
			$propositionM = new Application_Model_EuPropositionMapper();
			$propositionM->find($id, $proposition);

					$detail_proposition = new Application_Model_EuDetailPropositionMapper();
					$entries_detail_proposition = $detail_proposition->fetchAll2($proposition->id_proposition);
					foreach ($entries_detail_proposition as $entry_detail_proposition):
						$detail_proposition = new Application_Model_EuDetailProposition();
						$m_detail_proposition = new Application_Model_EuDetailPropositionMapper();
					$m_detail_proposition->delete($entry_detail_proposition->id_detail_proposition);
					endforeach;
		
		
					$membre_proposition = new Application_Model_EuMembrePropositionMapper();
					$entries_membre_proposition = $membre_proposition->fetchAll2($proposition->id_proposition);
					foreach ($entries_membre_proposition as $entry_membre_proposition):
						$membre_proposition = new Application_Model_EuMembreProposition();
						$m_membre_proposition = new Application_Model_EuMembrePropositionMapper();
					$m_membre_proposition->delete($entry_membre_proposition->id_membre_proposition);
					endforeach;


			$propositionM->delete($proposition->id_proposition);
		}

		$this->_redirect('/espacepersonnel/listproposition');
	}

	public function detailpropositionAction() 
	{
		/* page espacepersonnel/detailproposition - Detail proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$proposition = new Application_Model_EuProposition();
			$propositionM = new Application_Model_EuPropositionMapper();
			$propositionM->find($id, $proposition);
			$this->view->proposition = $proposition;


			$detail_proposition = new Application_Model_EuDetailPropositionMapper();
			$this->view->entries_detail_proposition = $detail_proposition->fetchAll2($proposition->id_proposition);


			$membre_proposition = new Application_Model_EuMembrePropositionMapper();
			$this->view->entries_membre_proposition = $membre_proposition->fetchAll2($proposition->id_proposition);





			$this->view->tabletri = 1;
		} else {
			$this->_redirect('/espacepersonnel/listproposition');
		}
	}

	public function suppdetailpropositionAction() 
	{
		/* page espacepersonnel/suppdetailproposition - Suppression detail proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$detailproposition = new Application_Model_EuDetailProposition();
			$detailpropositionM = new Application_Model_EuDetailPropositionMapper();
			$detailpropositionM->find($id, $detailproposition);

			
			
					$proposition = new Application_Model_EuProposition();
					$m_proposition = new Application_Model_EuPropositionMapper();
					$m_proposition->find($_POST['id_proposition'], $proposition);
					$proposition->setMontant_proposition($proposition->getMontant_proposition() - ($detailproposition->prix_unitaire * $detailproposition->quantite));
					$m_proposition->update($proposition);
					
					
			$detailpropositionM->delete($detailproposition->id_detail_proposition);
		}

		$this->_redirect('/espacepersonnel/detailproposition/id/' . $detailproposition->id_proposition);
	}

	public function suppmembrepropositionAction() 
	{
		/* page espacepersonnel/suppmembreproposition - Suppression membre proposition */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$membreproposition = new Application_Model_EuMembreProposition();
			$membrepropositionM = new Application_Model_EuMembrePropositionMapper();
			$membrepropositionM->find($id, $membreproposition);

			$membrepropositionM->delete($membreproposition->id_membre_proposition);
		}

		$this->_redirect('/espacepersonnel/detailproposition/id/' . $membreproposition->id_proposition);
	}

	public function addarticleAction() 
	{
		/* page espacepersonnel/addarticle - Ajout article */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['code_barre']) && $_POST['code_barre'] != "" && isset($_POST['reference']) && $_POST['reference'] != "" && isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['prix']) && $_POST['prix'] != "") {

				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$article_stockes = new Application_Model_EuArticleStockes();
				$m_article_stockes = new Application_Model_EuArticleStockesMapper();


				if ($m_article_stockes->find($_POST['code_barre'], $article_stockes) === FALSE) {

					$article_stockes->setCode_barre($_POST['code_barre']);
					$article_stockes->setReference($_POST['reference']);
					$article_stockes->setDesignation($_POST['designation']);
					$article_stockes->setPrix($_POST['prix']);
					$article_stockes->setDate_enregistrement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$article_stockes->setCode_membre_morale($_POST['code_membre_morale']);
					$article_stockes->setPublier($_POST['publier']);
					$article_stockes->setVendu(0);
					$m_article_stockes->save($article_stockes);

					//$this->_redirect('/espacepersonnel/listarticle');
					$this->view->error = "Article enregistré";
				} else {
					$this->view->error = "Article existant";
				}
			} else {
				$this->view->error = "Champs * obligatoire";
			}
		}
	}

	public function listarticleAction() 
	{
		/* page espacepersonnel/listarticle - Liste des articles */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$article_stockes = new Application_Model_EuArticleStockesMapper();
		$this->view->entries = $article_stockes->fetchAll2($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}

	public function listarticlevenduAction() 
	{
		/* page espacepersonnel/listarticlevendu - Liste des articles */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
		 
		$article_stockes = new Application_Model_EuArticleStockesMapper();
		$this->view->entries = $article_stockes->found($sessionmembre->code_membre);

		$this->view->tabletri = 1;
		
		
	}

	public function listarticleachatAction() 
	{
		/* page espacepersonnel/listarticleachat - Liste des articles achats */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$article_vendus = new Application_Model_EuArticleStockesMapper();
		$this->view->entries = $article_vendus->fetchAll3($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}

	public function publierarticleAction() 
	{
		/* page espacepersonnel/publierarticle - Publier un article */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (string) $this->_request->getParam('id');
		if ($id != "") {

			$article_stockes = new Application_Model_EuArticleStockes();
			$m_article_stockes = new Application_Model_EuArticleStockesMapper();
			$m_article_stockes->find($id, $article_stockes);

			$article_stockes->setPublier($this->_request->getParam('publier'));
			$m_article_stockes->update($article_stockes);
		}

		$this->_redirect('/espacepersonnel/listarticle');
	}




	public function supparticleAction() 
	{
		/* page espacepersonnel/supparticle - Suppression d'un article */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (string) $this->_request->getParam('id');
		if ($id != "") {

			$article_stockesM = new Application_Model_EuArticleStockesMapper();
			$article_stockesM->delete($id);
		}

		$this->_redirect('/espacepersonnel/listarticle');
	}



	
	public  function listsouscriptioncmfhAction()  {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if(!isset($sessionmembre->code_membre)) {
		  $this->_redirect('/');
		}
		
		if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
          if($sessionmembre->confirmation_envoi != "") {$this->_redirect('/espacepersonnel/confirmation');}
		
		    $t_dvente = new Application_Model_DbTable_EuDepotVente();
		    $select = $t_dvente->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false);
            $select->join(array('s' => 'eu_souscription'), 's.souscription_id = eu_depot_vente.souscription_id');
		    $select->where('eu_depot_vente.code_membre like ?', trim($sessionmembre->code_membre));
                
		    $entries = $t_dvente->fetchAll($select);
            $this->view->entries = $entries;
		    $this->view->tabletri = 1;
	}
	
	
	public  function  editsouscriptioncmfhAction()  {
	    $sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if(!isset($sessionmembre->code_membre)) {
		  $this->_redirect('/');
		}
		
		if(!isset($sessionmembre->code_membre))       {$this->_redirect('/');}
        if($sessionmembre->confirmation_envoi != "")  {$this->_redirect('/espacepersonnel/confirmation');}
		
		$t_zone = new Application_Model_DbTable_EuZone();
	    $t_pays = new Application_Model_DbTable_EuPays();
	    $t_region = new Application_Model_DbTable_EuRegion();
	    $t_prefecture = new Application_Model_DbTable_EuPrefecture();
	    $t_canton = new Application_Model_DbTable_EuCanton();
            $tactivite = new Application_Model_DbTable_EuActivite();
		
	    $zones = $t_zone->fetchAll();
            $pays = $t_pays->fetchAll();
	    $regions = $t_region->fetchAll();
	    $prefectures = $t_prefecture->fetchAll();
	    $cantons  = $t_canton->fetchAll();
            $activites = $tactivite->fetchAll();
		
	    $this->view->zones = $zones;
            $this->view->pays = $pays;
	    $this->view->regions = $regions;
	    $this->view->prefectures = $prefectures;
	    $this->view->cantons = $cantons;
            $this->view->activites = $activites;
		
		
	    $request = $this->getRequest();
	    if($request->isPost()) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {	        
				$id_canton = $request->getParam("id_canton");
				$id_souscription = $request->getParam("souscription_id");
                                
                                $code_activite = $request->getParam("code_activite");
				$id_metier = $request->getParam("id_metier");
				$id_competence = $request->getParam("id_competence");
				$souscription = new Application_Model_EuSouscription();
		                $m_souscription = new Application_Model_EuSouscriptionMapper();
			        $m_souscription->find($id_souscription,$souscription);
                                $souscription->setCode_activite($code_activite);
				$souscription->setId_metier($id_metier);
				$souscription->setId_competence($id_competence);
				$souscription->setId_canton($id_canton);
				$m_souscription->update($souscription);
			    
				$db->commit();
	                        $sessionmembre->error = "Modification bien effectuee ...";
	                        $this->_redirect('/espacepersonnel/listsouscriptioncmfh');
				
			} catch (Exception $exc) {				   
	            $db->rollback();
                $this->view->error = $exc->getMessage() . ': ' . $exc->getTraceAsString(); 
                return;
            }
            			
		} else  {
			$id = (int) $this->_request->getParam('id');
			if($id > 0) {
		        $s = new Application_Model_EuSouscription();
		        $ms = new Application_Model_EuSouscriptionMapper();
				$ms->find($id,$s);
				
			    $canton = new Application_Model_EuCanton();
	            $m_canton = new Application_Model_EuCantonMapper();
		
		        $prefecture = new Application_Model_EuPrefecture();
	            $m_prefecture = new Application_Model_EuPrefectureMapper();
		
		        $region = new Application_Model_EuRegion();
	            $m_region = new Application_Model_EuRegionMapper();
		
		        $pays = new Application_Model_EuPays();
	            $m_pays = new Application_Model_EuPaysMapper();
		
		        $zone = new Application_Model_EuZone();
	            $m_zone = new Application_Model_EuZoneMapper();
				
				
				$findcanton = $m_canton->find($s->id_canton,$canton);
		        $findprefecture = $m_prefecture->find($canton->id_prefecture,$prefecture);
		        $findregion = $m_region->find($prefecture->id_region,$region);
		        $findpays = $m_pays->find($region->id_pays,$pays);
		        $findzone = $m_zone->find($pays->code_zone,$zone);
				
		        
		        $this->view->souscription = $s;
				$this->view->id_canton = $canton->id_canton;
				$this->view->id_prefecture = $prefecture->id_prefecture;
				$this->view->id_region = $region->id_region;
				$this->view->id_pays = $pays->id_pays;
				$this->view->code_zone = $zone->code_zone;
				
			}
			
		}
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



	public function adddemandeAction() 
	{
		/* page espacepersonnel/adddemande - Ajout d'une demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['objet_demande']) && $_POST['objet_demande'] != "") {

				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$demande = new Application_Model_EuDemande();
				$m_demande = new Application_Model_EuDemandeMapper();

				$id_demande = $m_demande->findConuter() + 1;

					$demande->setId_demande($id_demande);
					$demande->setObjet_demande($_POST['objet_demande']);
					$demande->setDescription_demande($_POST['description_demande']);
					$demande->setDate_demande($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$demande->setCode_membre_morale($_POST['code_membre_morale']);
					$demande->setPublier($_POST['publier']);
					$m_demande->save($demande);

					//$this->_redirect('/espacepersonnel/listdemande');
			} else {
				$this->view->error = "Champs * obligatoire";
			}
		}
	}



	public function editdemandeAction() 
	{
		/* page espacepersonnel/editdemande - Modification d'une demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['objet_demande']) && $_POST['objet_demande'] != "") {

				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$demande = new Application_Model_EuDemande();
				$m_demande = new Application_Model_EuDemandeMapper();

				$m_demande->find($id, $demande);

					$demande->setObjet_demande($_POST['objet_demande']);
					$demande->setDescription_demande($_POST['description_demande']);
					$m_demande->update($demande);

					$this->_redirect('/espacepersonnel/listdemande');
	}  else {	$this->view->error = "Les champs * sont obligatoires ...";	

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
		$a = new Application_Model_EuDemande();
		$ma = new Application_Model_EuDemandeMapper();
		$ma->find($id, $a);
		$this->view->demande = $a;
			}
	}
		   
	} else {

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
		$a = new Application_Model_EuDemande();
		$ma = new Application_Model_EuDemandeMapper();
		$ma->find($id, $a);
		$this->view->demande = $a;
			}
	}
	}

	
	public function detailsdemandeAction() 
	{
		/* page espacepersonnel/detailsdemande - Détail d'une demande */

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
		$a = new Application_Model_EuDemande();
		$ma = new Application_Model_EuDemandeMapper();
		$ma->find($id, $a);
		$this->view->demande = $a;
			}

	}

	
	public function listdemandeAction() 
	{
		/* page espacepersonnel/listdemande - liste des demandes */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$demande = new Application_Model_EuDemandeMapper();
		$this->view->entries = $demande->fetchAll2($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}

	public function listdemandefraisAction() 
	{
		/* page espacepersonnel/listdemandefrais - Liste des demandes facturés */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$frais = new Application_Model_EuFraisMapper();
if($sessionmembre->code_groupe == "executante" || $sessionmembre->code_groupe == "executante_pays" || $sessionmembre->code_groupe == "executante_region" || $sessionmembre->code_groupe == "executante_secteur" || $sessionmembre->code_groupe == "executante_agence") {
		$this->view->entries = $frais->fetchAll4($sessionmembre->code_source_create, $sessionmembre->code_monde_create, $sessionmembre->code_zone_create, $sessionmembre->id_pays, $sessionmembre->id_region, $sessionmembre->code_secteur_create, $sessionmembre->code_agence_create);
}else{
		$this->view->entries = $frais->fetchAll2($sessionmembre->code_membre);
}
		$this->view->tabletri = 1;
	}

	public function publierdemandeAction() 
	{
		/* page espacepersonnel/publierdemande - Publier une demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$demande = new Application_Model_EuDemande();
			$m_demande = new Application_Model_EuDemandeMapper();
			$m_demande->find($id, $demande);

			$demande->setPublier($this->_request->getParam('publier'));
			$m_demande->update($demande);
		}

		$this->_redirect('/espacepersonnel/listdemande');
	}

	public function livrerdemandeAction() 
	{
		/* page espacepersonnel/livrerdemande - Livrer une demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		$idfrais = (int) $this->_request->getParam('idfrais');
		if ($id > 0 && $idfrais > 0) {
			
			$frais = new Application_Model_EuFrais();
			$m_frais = new Application_Model_EuFraisMapper();
			$m_frais->find($idfrais, $frais);
			
			$m_appeloffre = new Application_Model_EuAppelOffreMapper();
			$appeloffre = $m_appeloffre->findByDemande($id);
						
			$date = new Zend_Date(Zend_Date::ISO_8601);

			$m_appelnn = new Application_Model_EuAppelNnMapper();
			$appelnn = $m_appelnn->findByAppel($frais->id_proposition);
			$code_compte = 'NN-TPAGCP-' . $appeloffre->membre_morale_executante;
			
			$compte_gcp = new Application_Model_EuCompte();
			$m_compte_gcp = new Application_Model_EuCompteMapper();
			$m_compte_gcp->find($code_compte, $compte_gcp);
			
			$m_domiciliation = new Application_Model_EuDomiciliationMapper();
			$domiciliation = $m_domiciliation->findByProposition($frais->id_proposition);
			
			//if($frais->mont_projet <= $compte_gcp->solde && $domiciliation->montant_subvent == $domiciliation->montant_domicilier && $domiciliation->reste_duree == 0){
			
					$compte_gcp->setSolde($compte_gcp->getSolde() - $frais->mont_projet);
					$m_compte_gcp->update($compte_gcp);
					
				$m_compte = new Application_Model_EuCompteMapper();
				$compte = new Application_Model_EuCompte();
				$code_compte = 'NN-GCPREP-' . $appelnn->code_membre_morale;
				$ret_req = $m_compte->find($code_compte, $compte);
				if ($ret_req == FALSE) {
					$compte->setCode_cat('GCPREP');
					if (substr($code_membre, -1) == "P") {
						$compte->setCode_membre($code_membre);
					} else if (substr($code_membre, -1) == "M") {
						$compte->setCode_membre_morale($code_membre);
					}
					$compte->setCode_compte($code_compte)
							->setCode_type_compte('NN')
							->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
							->setDesactiver(0)
							->setLib_compte('Gcp Répartition')
							->setSolde($frais->mont_projet);
					$m_compte->save($compte);
				} else {
					$compte->setSolde($compte->getSolde() + $frais->mont_projet);
					$m_compte->update($compte);
				}

			$demande = new Application_Model_EuDemande();
			$m_demande = new Application_Model_EuDemandeMapper();
			$m_demande->find($id, $demande);

			$demande->setLivrer($this->_request->getParam('livrer'));
			$m_demande->update($demande);
			
$sessionmembre->errorlogin = "Validation de la livraison réussie ...";			
			
			/*}else {
$sessionmembre->errorlogin = "Validation de la livraison échouée ...";			
				}*/
			
		}

		$this->_redirect('/espacepersonnel/listdemandefrais');
	}

	public function validerfraisAction() 
	{
		/* page espacepersonnel/validerfrais - Valider un frais de demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$frais = new Application_Model_EuFrais();
			$m_frais = new Application_Model_EuFraisMapper();
			$m_frais->find($id, $frais);

			$frais->setValider($this->_request->getParam('valider'));
			$m_frais->update($frais);
		}

		$this->_redirect('/espacepersonnel/listdemandefrais');
	}


	public function suppdemandeAction() 
	{
		/* page espacepersonnel/suppdemande - Suppression d'une demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$demandeM = new Application_Model_EuDemandeMapper();
			$demandeM->delete($id);
		}

		$this->_redirect('/espacepersonnel/listdemande');
	}


	public function listappelnnAction() 
	{
		/* page espacepersonnel/listappelnn - Liste des collectes */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$appelnn = new Application_Model_EuDetailAppelNnMapper();
		$this->view->entries = $appelnn->fetchAll2($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}


	public function appelnnAction() 
	{
		/* page espacepersonnel/appelnn - Particiter à la collecte */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		/*if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}*/


			  $date_id = new Zend_Date(Zend_Date::ISO_8601);
			  $date_idd = clone $date_id;
			  $proposition = new Application_Model_EuProposition();
			  $map_proposition = new Application_Model_EuPropositionMapper();
			  $membre = new Application_Model_EuMembre();
			  $map_membre = new Application_Model_EuMembreMapper();
			  $membremorale = new Application_Model_EuMembreMorale();
			  $map_membremorale = new Application_Model_EuMembreMoraleMapper();
			  $proposition = new Application_Model_EuProposition();
			  $map_proposition = new Application_Model_EuPropositionMapper();
			  $appel = new Application_Model_EuAppelNn();
			  $map_appel = new Application_Model_EuAppelNnMapper();
			  $t_appel = new Application_Model_DbTable_EuAppelNn();
			  $compte = new Application_Model_EuCompte();
			  $map_compte = new Application_Model_EuCompteMapper();
			  $dappel = new Application_Model_EuDetailAppelNn();
			  $map_dappel = new Application_Model_EuDetailAppelNnMapper();



		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['type_nn']) && $_POST['type_nn'] != "" && isset($_POST['apport']) && $_POST['apport'] > 0) {

			  $date_id = new Zend_Date(Zend_Date::ISO_8601);
			  $date_idd = clone $date_id;
			  $date_fin = clone $date_id;
			  $periode = Util_Utils::getParametre('periode', 'collecte');
			  $date_fin->addDay($periode);


			$id = (int)$this->_request->getParam('id');
			$m_appelnn = new Application_Model_EuAppelNnMapper();
			$appelnn = new Application_Model_EuAppelNn();
			$ret_req = $m_appelnn->find($id, $appelnn);
				$this->view->appelnn = $appelnn;
				
				$id = $appelnn->id_proposition;
		   $t_appel =  new Application_Model_DbTable_EuAppelNn();
		   $selection = $t_appel->select();
		   $selection->where('id_proposition = ?',$id);
		   $appel = $t_appel->fetchAll($selection);
		   
		   if (count($appel) > 0) {
			  $prk = Util_Utils::getParametre('prk','nr');
			  $pck = Util_Utils::getParametre('pck','nr');
			  $t_propo = new Application_Model_DbTable_EuProposition();
			  $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
			  $select->setIntegrityCheck(false)
					 ->join('eu_appel_offre','eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre',array('eu_appel_offre.*','eu_proposition.*'))
					 ->join('eu_appel_nn', 'eu_appel_nn.id_proposition = eu_proposition.id_proposition',array('eu_appel_nn.*',"TO_CHAR((eu_appel_nn.date_fin),'DD/MM/YYYY') datefin"))
					 ->join('eu_frais', 'eu_frais.id_proposition = eu_proposition.id_proposition',array('eu_frais.*'))
					 ->where('eu_proposition.id_proposition = ?',$id); 
			  $propo = $t_propo->fetchAll($select);
			  if (count($propo) > 0) {
				 $duree = $propo->current()->duree_projet;
				 $mont_projet = $propo->current()->mont_projet;
				 $mont_apport = $propo->current()->montant_nn;
				 $design_appel = $propo->current()->designation_appel;
				 $date_fin = $propo->current()->datefin;
				 if($duree <= $prk) {
					$mont_nn = ($mont_projet * $pck)/$prk;
				 } else {
					$mont_nn = ($mont_projet * $pck)/$duree;
				 }
					$data[0] = $mont_nn;
					$data[1] = $mont_apport;
					$data[2] = $design_appel;
					$data[3] = $date_fin;
					$data[4] = $mont_projet;
					$data[5] = $duree;
			   
			   }  else {
				   $data = 0;
				}
			   //$this->view->data = $data;
	  } else {
			 $prk = Util_Utils::getParametre('prk','nr');
			 $pck = Util_Utils::getParametre('pck','nr');
			 $t_propo = new Application_Model_DbTable_EuProposition();
			 $select = $t_propo->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
			 $select->setIntegrityCheck(false)
					->join('eu_appel_offre', 'eu_appel_offre.id_appel_offre = eu_proposition.id_appel_offre',array('eu_appel_offre.*','eu_proposition.*'))
					->join('eu_frais', 'eu_frais.id_proposition = eu_proposition.id_proposition',array('eu_frais.*'))
					->where('eu_proposition.id_proposition = ?',$id); 
			 $propo = $t_propo->fetchAll($select);
			 if (count($propo) > 0) {
				$duree = $propo->current()->duree_projet;
				$mont_projet = $propo->current()->mont_projet;
				if($duree <= $prk) {
				   $mont_nn = ($mont_projet * $pck)/$prk;
				} else {
				   $mont_nn = ($mont_projet * $pck)/$duree;
				}
					$data[0] = $mont_nn;
					$data[1] = 0;
					$data[2] = '';
					$data[3] = '';
					$data[4] = $mont_projet;
					$data[5] = $duree;
			   }  else {
					   $data = 0;
			   }
			   //$this->view->data = $data;  
	  
	  }
				
				
				
				  $montant = 0;
				  $code_membreb = $appelnn->code_membre_morale;
				  $total_apport = $mont_apport;
				  $total_nn = $mont_nn;
				  $montant_budget = $mont_projet;
				  $nrpre = $duree * 30;
				  $marge = $montant_budget - $total_nn;
				  $code_compte='NN-TSCAPA-'.$code_membreb;

if($total_apport > $total_nn) {
					  //$db->rollBack();
					  $sessionmembre->errorlogin = 'Le total des nn collectés  '.$total_nn.' est supérieur au total des nn exigible !!!';
					  //return;
				  } else {
									$id_appel= $appelnn->getId_appel_nn();
								$result = $map_appel->find($id_appel, $appel);
								if ($result == TRUE) {
									$appel->setMontant_nn($appel->getMontant_nn() + $_POST['apport']);
									//$appel->setDesignation_appel($appel_nn);
									//$appel->setDate_fin($date_fin->toString('yyyy-MM-dd'));
									$map_appel->update($appel);
								} 
									 
									 
									 $compte_nn='NN-'.$_POST["type_nn"].'-'.$sessionmembre->code_membre;
									 
									 if($_POST["type_nn"] == 'TCNCS') {
										  $compte_ts='NN-TSCNCS-'.$sessionmembre->code_membre;
									 
									 } else if($_POST["type_nn"] == 'TPAGCP') {
										  $compte_ts='NN-TSGCP-'.$sessionmembre->code_membre;
									 
									 } else if($_POST["type_nn"] == 'TPAGCI') {
										  $compte_ts='NN-TSGCI-'.$sessionmembre->code_membre;
									 
									 } else if($_POST["type_nn"] == 'TPAGCRPG') {
										  $compte_ts='NN-TSRPG-'.$sessionmembre->code_membre;
									 
									 } else if($_POST["type_nn"] == 'CAPA') { 
										  $compte_ts='NN-TSCAPA-'.$sessionmembre->code_membre;
									 

									 }
									 
									 $result = $map_compte->find($compte_ts,$compte);
									 if($result == TRUE) {

									 $compteur_dappel = $map_dappel->findConuter() + 1;
									 $dappel->setId_detail_appel_nn($compteur_dappel)
											->setId_appel_nn($id)
											->setCode_membre($sessionmembre->code_membre)
											->setDate_apport($date_idd->toString('yyyy-MM-dd'))
											->setHeure_apport($date_idd->toString('HH:mm:ss'))
											->setMontant_apport($_POST["apport"])
											->setCode_compte($compte_nn)
											->setId_utilisateur($sessionmembre->id_utilisateur)
											->setPayer(0);			 
									 $map_dappel->save($dappel);
									 
									 
									 
									 $type_membre = substr($sessionmembre->code_membre,19,1);
									 if($type_membre == "P") {
									   $res = $map_membre->find($sessionmembre->code_membre,$membre);
									   $montant_rep = floor($marge*($_POST["apport"] / $total_nn)) ;
									   $compteur = Util_Utils::findConuter() + 1;
									   Util_Utils::addSms($compteur,$membre->getPortable_membre(),"Nous vous remercions d'avoir participer à la collecte nrPRE au montant de :" . $_POST["apport"]. "La marge de répartition bénéfique " .$marge."  est dans  ".$nrpre. " jours");
									 } else {
									   $res = $map_membremorale->find($sessionmembre->code_membre,$membremorale);
									   $montant_rep = floor($marge*($_POST["apport"] / $total_nn)) ;
									   $compteur = Util_Utils::findConuter() + 1;
									   Util_Utils::addSms($compteur,$membremorale->getPortable_membre(),"Nous vous remercions d'avoir participer à la collecte nrPRE au montant de :" . $_POST["apport"]. "La marge de répartition  est de : " .$marge."  est dans  ".$nrpre. " jours");
									 
									 }									  
									 
									 
										  if($compte->getSolde() >= $_POST["apport"]) {
											  $compte->setSolde($compte->getSolde() - $_POST["apport"]);
											  $map_compte->update($compte);
										  } else {
											  //$db->rollBack();
											  $sessionmembre->errorlogin = 'Le montant apporte est superieur au montant du solde ' .$_POST["apport"]. ' > '.$compte->getSolde();
											  //return;      										   
										  }									

								$result = $map_compte->find($code_compte, $compte);
								if  ($result == FALSE) {
									Util_Utils::createCompte($code_compte,'Compte nrPRE',null,$montant, null,'NN',$date_idd->toString('yyyy-MM-dd'),0,$code_membreb);
								} else {
									$compte->setSolde($compte->getSolde() + $montant);
									$map_compte->update($compte);
								}
								
									}else{
											  $sessionmembre->errorlogin = 'Cet compte '.$compte_ts.' n\'existe pas ...';
										} 



		$this->_redirect('/espacepersonnel/listappelnn');
				  }
	}  else {	$this->view->error = "Les champs * sont obligatoires ...";	

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
			$m_appelnn = new Application_Model_EuAppelNnMapper();
			$appelnn = new Application_Model_EuAppelNn();
			$ret_req = $m_appelnn->find($id, $appelnn);
				$this->view->appelnn = $appelnn;
			}
	}
		   
	} else {

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
			$m_appelnn = new Application_Model_EuAppelNnMapper();
			$appelnn = new Application_Model_EuAppelNn();
			$ret_req = $m_appelnn->find($id, $appelnn);
				$this->view->appelnn = $appelnn;
			}
	}
	}




	public function capaAction() 
	{
		/* page espacepersonnel/capa - Recharge de codes SMS */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['creditcode']) && $_POST['creditcode'] != "") {
				$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
				$smsmoney = $smsmoneyM->findByCreditCode($_POST['creditcode']);
                $smsmoneyM = new Application_Model_EuSmsmoneyMapper();
                if($smsmoney = $smsmoneyM->findByCreditCode3($_POST['creditcode'], $sessionmembre->type)) {
                    $codeproduit = $smsmoney->Motif;
			        $date = Zend_Date::now();
				    $mapper = new Application_Model_EuOperationMapper();
				    $place = new Application_Model_EuOperation();
				    $compteur = $mapper->findConuter() + 1;
				    $place->setId_operation($compteur)
						  ->setDate_op($date->toString('yyyy-MM-dd HH:mm:ss'))
						  ->setMontant_op($smsmoney->CreditAmount);
				if (substr($sessionmembre->code_membre, -1) == "P") {
					$place->setCode_membre($sessionmembre->code_membre);
					$place->setCode_membre_morale(NULL);
				} else if (substr($sessionmembre->code_membre, -1) == "M") {
					$place->setCode_membre(NULL);
					$place->setCode_membre_morale($sessionmembre->code_membre);
				}
				$place->setHeure_op($date->toString('HH:mm:ss'))
						->setCode_produit($codeproduit)
						->setId_utilisateur(NULL)
						->setLib_op('Recharge de compte')
						->setCode_cat('CAPA')
						->setType_op('REC');
				$mapper->save($place);




				$m_compte = new Application_Model_EuCompteMapper();
				$m_compte_ts = new Application_Model_EuCompteMapper();
				$compte = new Application_Model_EuCompte();
				$compte_ts = new Application_Model_EuCompte();
				$code_compte = 'NN-CAPA-' . $sessionmembre->code_membre;
				$code_compte_ts = 'NN-TSCAPA-' . $sessionmembre->code_membre;
				$ret_req = $m_compte->find($code_compte, $compte);
				if ($ret_req == FALSE) {
					$compte->setCode_cat('CAPA');
					if (substr($sessionmembre->code_membre, -1) == "P") {
						$compte->setCode_membre($sessionmembre->code_membre);
					} else if (substr($sessionmembre->code_membre, -1) == "M") {
						$compte->setCode_membre_morale($sessionmembre->code_membre);
					}
					$compte->setCode_compte($code_compte)
							->setCode_type_compte('NN')
							->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
							->setDesactiver(0)
							->setLib_compte('CAPA')
							->setSolde($smsmoney->CreditAmount);
					$m_compte->save($compte);


				$ret_req_ts = $m_compte_ts->find($code_compte_ts, $compte_ts);
				if ($ret_req_ts == FALSE) {
					$compte_ts->setCode_cat('CAPA');
					if (substr($sessionmembre->code_membre, -1) == "P") {
						$compte_ts->setCode_membre($sessionmembre->code_membre);
					} else if (substr($sessionmembre->code_membre, -1) == "M") {
						$compte_ts->setCode_membre_morale($sessionmembre->code_membre);
					}
					$compte_ts->setCode_compte($code_compte_ts)
							->setCode_type_compte('NN')
							->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
							->setDesactiver(0)
							->setLib_compte('TS CAPA')
							->setSolde(0);
					$m_compte_ts->save($compte_ts);
}
				} else {
					$compte->setSolde($compte->getSolde() + $smsmoney->CreditAmount);
					$m_compte->update($compte);
				}



				// Mise à jour des CAPA
				$date_deb = Zend_Date::now();

				$type = $sessionmembre->type;

				$m_capa = new Application_Model_EuCapaMapper();
				$capa = new Application_Model_EuCapa();
				$code_capa = 'CAPA' . $type . $date_deb->toString('yyyyMMddHHmmss');
				$capa->setCode_capa($code_capa)
						->setId_operation($compteur)
						->setDate_capa($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setMontant_capa($smsmoney->CreditAmount)
						->setMontant_utiliser(0)
						->setMontant_solde($smsmoney->CreditAmount)
						->setCode_membre($sessionmembre->code_membre)
						->setHeure_capa($date_deb->toString('HH:mm:ss'))
						->setType_capa($type)
						->setCode_compte($code_compte)
						->setEtat_capa('Actif')
						->setCode_produit($codeproduit)
						->setOrigine_capa('SMS');
				$m_capa->save($capa);



				$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
				$smsmoney = new Application_Model_EuSmsmoney();
				$smsmoney = $smsmoneyM->findByCreditCode($_POST['creditcode']);
				$smsmoneyM->find($smsmoney->NEng, $smsmoney);

				$smsmoney->setDestAccount_Consumed($code_compte)
						->setDateTimeconsumed($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('yyyy-MM-dd HH:mm:ss')));
				$smsmoneyM->update($smsmoney);


////////////////// à faire /////////////////////////
				/*$m_creditcode = new Application_Model_EuCreditCodeMapper();
				$creditcode = new Application_Model_EuCreditCode();
				$creditcode->setCode_compte($code_compte)
						->setCredit_code($_POST['creditcode']);
				$m_creditcode->save($creditcode);*/
///////////////////////////////////////////

				$sessionmembre->errorlogin = "Opération bien effectuée";

				$this->_redirect('/espacepersonnel/compte');
			} else {
				$sessionmembre->errorlogin = "Vérifiez bien votre code SMS, il doit être un code CAPA.";
			}
			} else {
				$sessionmembre->errorlogin = "Saisir Code Membre et Code Secret";
			}
			$this->_redirect('/espacepersonnel/capa');
		}
	}

	public function apaAction() {
		/* page espacepersonnel/apa - Achat de APA */
			$sessionmembre = new Zend_Session_Namespace('membre');
			$this->_helper->layout()->setLayout('layoutpublicesmcperso');
			if (!isset($sessionmembre->code_membre)) {
			   $this->_redirect('/');
			}
			$tparam = new Application_Model_DbTable_EuParametres();
			$m_compte = new Application_Model_EuCompteMapper();
			$compte = new Application_Model_EuCompte();
			$cm_mapper = new Application_Model_EuCompteMapper();
			$m_cnp = new Application_Model_EuCnpMapper();
			$cnp = new Application_Model_EuCnp();
			$fn = new Application_Model_EuFn();
			$m_fn = new Application_Model_EuFnMapper();
			$capa = new Application_Model_EuCapa();
			$m_capa = new Application_Model_EuCapaMapper();
			$m_credit_capa = new Application_Model_EuCompteCreditCapaMapper();
			$credit_capa = new Application_Model_EuCompteCreditCapa();
			$sqmaxui = new Application_Model_EuBnpSqmax();
			$m_sqmaxui = new Application_Model_EuBnpSqmaxMapper();
			$krr = new Application_Model_EuKrr();
            $mkrr = new Application_Model_EuKrrMapper();
			$dkrr = new Application_Model_EuDetailKrr();
            $mdkrr = new Application_Model_EuDetailKrrMapper();
			$prod = new Application_Model_EuProduit();
			$prod_mapper = new Application_Model_EuProduitMapper();
			$sms_mapper  = new Application_Model_EuSmsmoneyMapper();
			$operation   = new Application_Model_EuOperation();
		    $mapper_op   = new Application_Model_EuOperationMapper();
			$cc_mapper   = new Application_Model_EuCompteCreditMapper();
			$membre      = new Application_Model_EuMembre();
			$membre_map  = new Application_Model_EuMembreMapper();
			$moral      = new Application_Model_EuMembreMorale();
			$moral_map  = new Application_Model_EuMembreMoraleMapper();
			$bnp = new Application_Model_EuCaps();
			$bmap = new Application_Model_EuCapsMapper();
			$bnp = $bmap->fetchCapsByBeneficiaire($sessionmembre->code_membre);
		    
			$type_credit = "CNPG";
			if((isset($_POST['creditcode'])  &&  $_POST['creditcode'] != "" && isset($_POST['mont_credit']) && $_POST['mont_credit'] != "") || 
			   (isset($_POST['creditcode'])  &&  $_POST['creditcode'] != "" && isset($_POST['mont_credit2']) && $_POST['mont_credit2'] != "") 
			) {
			  $type = $sessionmembre->type;
			  if(isset($_POST['dev_apa']))   { $code_dev  = $_POST['dev_apa'];}    else    { $code_dev = "";}
				   if(isset($_POST['mont_capa'])) { $mont_capa = $_POST['mont_capa'];}  else    { $mont_capa = "";}
				   $prk = str_replace(".", ".", $_POST['prkk']);
				   $code_sms = $_POST['creditcode'];
				   $categorie = $_POST['categorie'];
				   $code_membre = $sessionmembre->code_membre;
				    if(isset($_POST['type_apa'])) { 
				      $type_apa = $_POST['type_apa'];
				    } else {
				      $type_apa = "";
				    }
				    $code_produit = $type . $categorie;
				    $db = Zend_Db_Table::getDefaultAdapter();
				    $db->beginTransaction();
				    try {
				        $p_result = $prod_mapper->find($code_produit,$prod);
					    if (!$p_result) {
					       $sessionmembre->errorlogin = "Ce produit " . $code_produit . " n'existe pas";
					       return;
					    }
                        
						if($code_produit == 'RPGr' || $code_produit == 'Ir') {
                           $pck = Util_Utils::getParametre('pck','r');
					       $tbcp = Util_Utils::getParametre('TBCP','valeur');
					       $trcapa = Util_Utils::getParametre('PRK','RCAPA');
					    } elseif($code_produit == 'RPGnr' || $code_produit == 'Inr') {
                           $pck = Util_Utils::getParametre('pck','nr');
				        }
						
						$sms = $sms_mapper->findByCreditCode($code_sms);
					    if ($sms != null) {
						    $montant = Util_Utils::verifierCodeSMS($sms);
						    if ($montant == 0) {
						      $sessionmembre->errorlogin = "Ce code SMS $code_sms est invalide ou le motif n'est pas CAPA!!!";
						      return;
						    }
					    } else  {
						      $sessionmembre->errorlogin = "Ce code SMS $code_sms est invalide ou le motif n'est pas CAPA!!!";
						      return;
					    }
						
						if((Util_Utils::getmembreType($code_membre) === 'P') && (substr($sms->getMotif(),0,3) != $type)) {
					        $sessionmembre->errorlogin = "Le motif pour lequel ce code est émis ne correspond pas à cette opération !!!";
					        return;
			            }
					
					    if((Util_Utils::getmembreType($code_membre) === 'M') && (substr($sms->getMotif(),0,1) != $type)) {
					        $sessionmembre->errorlogin = "Le motif pour lequel ce code est émis ne correspond pas à cette opération !!!";
					        return;
			            }
					
					    $date_fin = new Zend_Date(Zend_Date::ISO_8601);
					    $date_deb = clone $date_fin;
					
					    $mont_place = $montant;
					    $sqmax = 0;
					    $somme = 0;
						
						if ($code_produit == 'RPGr') {
						    $quota   = Util_Utils::getParametre('quota','RPGr');
                            $somme   = Util_Utils::getSumQuotaRPG($code_membre);
							if ($somme < $quota) {
							    $reste = $quota - ($somme + $mont_place);
							    if ($reste < 0) {
                                    $sqmax = abs($reste); 
								    $creditsqmax = round(($sqmax * $prk) / $pck) / 4;
									$code_capa = 'CAPASQMAXUI'.$date_deb->toString('yyyyMMddHHmmss');
									$mont_place = $mont_place - $sqmax;
									// insertion dans la table eu_operation
                                    $countsqmax = $mapper_op->findConuter() + 1;
                                    $operation = new Application_Model_EuOperation();
                                    $operation->setId_operation($countsqmax)
                                              ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                              ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                              ->setId_utilisateur(null)
                                              ->setCode_membre($code_membre)
                                              ->setMontant_op($sqmax)
                                              ->setCode_produit($code_produit)
                                              ->setLib_op("Achat du pouvoir d'achat RPG")
                                              ->setType_op('APA')
                                              ->setCode_cat('TPAGCRPG');
                                    $mapper_op->save($operation);
					
					                $prows = $tparam->find('periode','valeur');
                                    if (count($prows) > 0) {
                                       $periode = $prows->current()->montant;
                                    }
									$date_fin->addDay($periode);
                                    $maxccsqmax = $cc_mapper->findConuter() + 1;
									
									// insertion dans la table eu_compte_credit
                                    $source = $code_membre . $date_deb->toString('yyyyMMddHHmmss');
									$num_compte = 'NB-TPAGCRPG-'.$code_membre;
                                    Util_Utils::createCompteCredit($maxccsqmax,0,$countsqmax,$code_membre,$code_produit,$num_compte,$creditsqmax,$sqmax,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,'SQMAXUI','N','O',0,1,null,$type_credit,$prk,-1);

									// insertion dans la table eu_bnp_sqmax
									$maxidsqmax = $m_sqmaxui->findConuter() + 1;
                                    $sqmaxui->setId_sqmax($maxidsqmax);
					                $sqmaxui->setCode_cat('TPAGCRPG');
                                    $sqmaxui->setCode_membre($code_membre);
                                    $sqmaxui->setMontant($sqmax);
									$sqmaxui->setId_credit($maxccsqmax);
                                    $m_sqmaxui->save($sqmaxui);
									
									// insertion dans la table eu_compte
									$res_cm = $cm_mapper->find($num_compte,$compte);
									if ($res_cm == false) {
                                        $compte->setCode_membre($code_membre)
                                               ->setCode_cat('TPAGCRPG')
                                               ->setSolde($creditsqmax)
                                               ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                               ->setCode_compte($num_compte)
                                               ->setLib_compte('TPAGCRPG')
                                               ->setCode_type_compte('NB')
                                               ->setDesactiver(0);
                                        $cm_mapper->save($compte);
                                    } else {
                                        $compte->setSolde($compte->getSolde() + $creditsqmax);
                                        $cm_mapper->update($compte);
                                    }
									
									// insertion dans la table eu_cnp
							        $maxcnpsqmax = $m_cnp->findConuter() + 1;
                                    $cnp->setId_cnp($maxcnpsqmax)
                                        ->setId_credit($maxccsqmax)
                                        ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                        ->setMont_debit($credisqmax)
                                        ->setMont_credit(0)
                                        ->setSolde_cnp($creditsqmax)
                                        ->setType_cnp($code_produit)
                                        ->setSource_credit($source)
                                        ->setOrigine_cnp('RPGr')
                                        ->setTransfert_gcp(0);
                                    $m_cnp->save($cnp);
										
							    // Mise à jour des CAPA
							    $capa->setCode_capa($code_capa)
								     ->setCode_compte($num_compte)
								     ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
								     ->setHeure_capa($date_deb->toString('HH:mm:ss'))
								     ->setCode_membre($code_membre)
								     ->setMontant_capa($sqmax)
								     ->setMontant_utiliser($sqmax)
								     ->setMontant_solde(0)
								     ->setId_operation($countsqmax)
								     ->setType_capa($type)
								     ->setEtat_capa('Actif')
								     ->setOrigine_capa('SMS');
							    $m_capa->save($capa);
							
							    $credit_capa->setCode_capa($code_capa)
										    ->setCode_produit($code_produit)
										    ->setId_credit($maxccsqmax)
										    ->setMontant($sqmax);
							    $m_credit_capa->save($credit_capa);
								
								// insertion dans la table eu_fn
                                $maxfnsqmax = $m_fn->findConuter() + 1;
                                $fn->setId_fn($maxfnsqmax)
                                   ->setCode_capa($code_capa)
                                   ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
                                   ->setType_fn('Ir')
                                   ->setMontant($sqmax)
                                   ->setSortie(0)
                                   ->setEntree(0)
                                   ->setSolde(0)
                                   ->setOrigine_fn(0)
                                   ->setMt_solde($sqmax);
                                $m_fn->save($fn);
								
                                }
                            } else   {
							
							    $sqmax = $mont_place;
				                $creditsqmax = round(($sqmax * $prk) / $pck) / 4;
								$code_capa = 'CAPASQMAXUI'.$date_deb->toString('yyyyMMddHHmmss');
				                $mont_place = 0;
								
								// insertion dans la table eu_operation
                                $countsqmax = $mapper_op->findConuter() + 1;
                                $operation = new Application_Model_EuOperation();
                                $operation->setId_operation($countsqmax)
                                          ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                                          ->setHeure_op($date_deb->toString('HH:mm:ss'))
                                          ->setId_utilisateur(null)
                                          ->setCode_membre($code_membre)
                                          ->setMontant_op($sqmax)
                                          ->setCode_produit($code_produit)
                                          ->setLib_op("Achat du pouvoir d'achat RPG")
                                          ->setType_op('APA')
                                          ->setCode_cat('TPAGCRPG');
                                $mapper_op->save($operation);
													   
								$prows = $tparam->find('periode', 'valeur');
                                if (count($prows) > 0) {
                                   $periode = $prows->current()->montant;
                                }
														
						        $date_fin->addDay($periode);
                                $maxccsqmax = $cc_mapper->findConuter() + 1;
								
								// insertion dans la table eu_compte_credit
                                $source = $code_membre.$date_deb->toString('yyyyMMddHHmmss');
						        $num_compte = 'NB-TPAGCRPG-'.$code_membre;
                                Util_Utils::createCompteCredit($maxccsqmax,0,$countsqmax,$code_membre,$code_produit,$num_compte,$creditsqmax,$sqmax,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,'SQMAXUI','N','O',0,1,null,$type_credit,$prk,-1);

								// insertion dans la table eu_bnp_sqmax
								$maxidsqmax = $m_sqmaxui->findConuter() + 1;
                                $sqmaxui->setId_sqmax($maxidsqmax);
						        $sqmaxui->setCode_cat('TPAGCRPG');
                                $sqmaxui->setCode_membre($code_membre);
                                $sqmaxui->setMontant($sqmax);
								$sqmaxui->setId_credit($maxccsqmax);
                                $m_sqmaxui->save($sqmaxui);
								
								// insertion dans la table eu_compte
								$res_cm = $cm_mapper->find($num_compte,$cm);
                                if ($res_cm == false) {
                                    $compte->setCode_membre($code_membre)
                                           ->setCode_cat('TPAGCRPG')
                                           ->setSolde($creditsqmax)
                                           ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                           ->setCode_compte($num_compte)
                                           ->setLib_compte('TPAGCRPG')
                                           ->setCode_type_compte('NB')
                                           ->setDesactiver(0);
                                    $cm_mapper->save($compte);
                                } else {
                                    $compte->setSolde($compte->getSolde() + $creditsqmax);
                                    $cm_mapper->update($compte);
                                }
								
								// insertion dans la table eu_cnp
							    $maxcnpsqmax = $m_cnp->findConuter() + 1;
                                $cnp->setId_cnp($maxcnpsqmax)
                                    ->setId_credit($maxccsqmax)
                                    ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                    ->setMont_debit($credisqmax)
                                    ->setMont_credit(0)
                                    ->setSolde_cnp($creditsqmax)
                                    ->setType_cnp($code_produit)
                                    ->setSource_credit($source)
                                    ->setOrigine_cnp('RPGr')
                                    ->setTransfert_gcp(0);
                                $m_cnp->save($cnp);
														
                                // insertion dans la table eu_capa
							    $code_capa = 'CAPA' .'RPG' . $date_deb->toString('yyyyMMddHHmmss');
                                $capa->setCode_capa($code_capa)
                                     ->setCode_compte('NN-CAPA-'.$code_membre)
                                     ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
                                     ->setHeure_capa($date_deb->toString('HH:mm:ss'))
                                     ->setCode_membre($code_membre)
                                     ->setMontant_capa($sqmax)
                                     ->setMontant_utiliser($sqmax)
                                     ->setMontant_solde(0)
                                     ->setId_operation($countsqmax)
                                     ->setType_capa('RPG')
                                     ->setEtat_capa('Actif')
			                         ->setCode_produit($code_produit)
                                     ->setOrigine_capa('SMS');
                                $m_capa->save($capa);
														
				                // insertion dans la table eu_compte_credit_capa
                                $credit_capa->setCode_capa($code_capa)
                                            ->setCode_produit($code_produit)
                                            ->setId_credit($maxccsqmax)
                                            ->setMontant($sqmax);
                                $m_credit_capa->save($credit_capa);
						
                                // insertion dans la table eu_fn
                                $maxfnsqmax = $m_fn->findConuter() + 1;
                                $fn->setId_fn($maxfnsqmax)
                                   ->setCode_capa($code_capa)
                                   ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
                                   ->setType_fn('Ir')
                                   ->setMontant($sqmax)
                                   ->setSortie(0)
                                   ->setEntree(0)
                                   ->setSolde(0)
                                   ->setOrigine_fn(0)
                                   ->setMt_solde($sqmax);
                                $m_fn->save($fn);
							
							}
				        }
						
						if ($mont_place > 0)   {
						    $fs = 0;
							$mont_rcapa = 0;
							if($type_apa == 'standard') {
							  $credi = floor($mont_place * $prk / $pck);
							} elseif($type_apa == 'perenne') {
							  $bc = floor($mont_place * $prk / $pck);
							  $mont_rcapa = floor(($bc * $tbcp) / 100);
							  $credi = $bc - $mont_rcapa;
							} else {
							  $credi = floor($mont_place * $prk / $pck);
							}
							
							$fs_valeur = Util_Utils::getParametre('CAPS','valeur');
							if (($code_produit == 'RPGr')) {
								$findmembre = $membre_map->find($code_membre,$membre);
                                if ($membre->getAuto_enroler() == 'N') {
                                    if ($bnp != null and $bnp->getId_credit() == null) {
                                        $t_map = new Application_Model_EuTypeBnpMapper();
                                        $tbnp = new Application_Model_EuTypeBnp();
                                        $t_map->find($bnp->getCode_type_bnp(), $tbnp);
                                        $fs = floor($credi * $tbnp->getTx_fs() / 100);
                                        if ($fs < ($fs_valeur / 22.4)) {
                                           $fs = ($fs_valeur / 22.4);
                                        }
                                        $credi = $credi - $fs;
                                    }
                                }
                            }
							
							if($credi > 0)   {
							
							    if($code_produit == 'RPGr' or $code_produit == 'RPGnr') {
                                  $num_compte   = 'NB-TPAGCRPG-'.$code_membre;
								  $code_cat     = 'TPAGCRPG';
                                  $lib_op = 'Achat du RPG';								  
			                    } else {
								  $num_compte = 'NB-TPAGCI-'.$code_membre;
								  $code_cat = 'TPAGCI';
								  $lib_op = 'Achat d\'Investissement';
					            }
								
								$result = $cm_mapper->find($num_compte, $compte);
					            if ($result == FALSE) {
						            $type_compte = 'NB';
						            if (substr($sessionmembre->code_membre, -1) == "P") {
						               Util_Utils::createCompte($num_compte, $type, $code_cat, $credi,$code_membre,$type_compte,$date_deb->toString('yyyy-MM-dd'), 0, NULL);
						            } else {
						               Util_Utils::createCompte($num_compte, $type, $code_cat, $credi,NULL, $type_compte, $date_deb->toString('yyyy-MM-dd'), 0, $code_membre);
							        }
					            } else {
						            $compte->setSolde($compte->getSolde() + $credi);
						            $cm_mapper->update($compte);
					            }
								
								$source = $code_membre.$date_deb->toString('yyyyMMddHHmmss');
								// insertion dans la table eu_operation
					            $compteur = $mapper_op->findConuter() + 1;
								$operation->setId_operation($compteur)
							              ->setDate_op($date_deb->toString('yyyy-MM-dd'))
							              ->setMontant_op($mont_place);
					            if (substr($code_membre, -1) == "P") {
					               $operation->setCode_membre($code_membre);
					               $operation->setCode_membre_morale(NULL);
					            } else if (substr($code_membre, -1) == "M") {
					               $operation->setCode_membre(NULL);
					               $operation->setCode_membre_morale($code_membre);
					            }
								
					            $operation->setHeure_op($date_deb->toString('HH:mm:ss'))
							              ->setCode_produit($code_produit)
							              ->setId_utilisateur(NULL)
							              ->setLib_op($lib_op)
							              ->setCode_cat($code_cat)
							              ->setType_op('APA');
					            $mapper_op->save($operation);
								
								//Mise à jour des comptes credits
								$source = $sessionmembre->code_membre . $date_deb->toString('yyyyMMddHHmmss');
					            $max_code = $cc_mapper->findConuter() + 1;
					            $periode = Util_Utils::getParametre('periode', 'valeur');
					            $date_fin->addDay($periode);
					            $compte_source = '';
					            if ($type == 'RPG') {
					               $compte_source = 'CAPARPG';
					            } elseif ($type == 'I') {
					               $compte_source = 'CAPAI';
					            }
					            $renouveller = 'O';
					            if ($categorie == 'nr') {
					               $renouveller = 'N';
					            }
								Util_Utils::createCompteCredit($max_code,0,$compteur,$code_membre,$code_produit,$num_compte,$credi,$mont_place,$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,$compte_source,'N',$renouveller,0,0,NULL,$type_credit,$prk,-1);
                                
							    $maxcnp = $m_cnp->findConuter() + 1;
					            $cnp->setId_cnp($maxcnp)
						            ->setId_credit($max_code)
						            ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
						            ->setMont_debit($credi)
						            ->setMont_credit(0)
						            ->setSolde_cnp($credi)
						            ->setType_cnp($code_produit)
						            ->setSource_credit($source)
						            ->setTransfert_gcp(0);
						        if ($code_produit == 'Inr') {
						           $cnp->setOrigine_cnp('FGInr');
						        } elseif ($code_produit == 'Ir') {
						           $cnp->setOrigine_cnp('FGIr');
						        } elseif ($code_produit == 'RPGr') {
						           $cnp->setOrigine_cnp('FGRPGr');
						        } elseif ($code == 'RPGnr') {
						           $cnp->setOrigine_cnp('FGRPGnr');
						        }
					            $m_cnp->save($cnp);
								
								// insertion dans la table eu_capa
								$code_capa = 'CAPA'.$type.$date_deb->toString('yyyyMMddHHmmss');
					            $capa->setCode_capa($code_capa)
						             ->setCode_compte($num_compte)
						             ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
						             ->setHeure_capa($date_deb->toString('HH:mm:ss'))
						             ->setCode_membre($sessionmembre->code_membre)
						             ->setMontant_capa($mont_place)
						             ->setId_operation($compteur)
						             ->setEtat_capa('Actif')
						             ->setMontant_utiliser($mont_place)
						             ->setMontant_solde(0)
						             ->setType_capa($type)
						             ->setOrigine_capa('SMS');
					            $m_capa->save($capa);
					
					            // insertion dans la table eu_credit_capa
					            $credit_capa->setCode_capa($code_capa)
								            ->setCode_produit($code_produit)
								            ->setId_credit($max_code)
								            ->setMontant($mont_place);
					            $m_credit_capa->save($credit_capa);
								
								//Mise à jour de la table FN
					            $maxfn = $m_fn->findConuter() + 1;
					            $fn->setId_fn($maxfn)
					               ->setCode_capa($code_capa)
					               ->setDate_fn($date_deb->toString('yyyy-MM-dd'))
					               ->setType_fn('I'.$categorie)
					               ->setMontant($mont_place)
					               ->setSortie(0)
					               ->setEntree(0)
					               ->setSolde(0)
					               ->setOrigine_fn(0)
					               ->setMt_solde($mont_place);
					            $m_fn->save($fn);
								
								
								// Mise à jour de la table eu_smsmoney
								$sms->setDestAccount_Consumed($num_compte)
					                ->setDateTimeconsumed($date_deb->toString('dd/MM/yyyy HH:mm:ss'))
					                ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/MM/yyyy')));
				                $sms_mapper->update($sms);
								
								//Mise à jour des comptes généraux
				                $compte_gene = new Application_Model_EuCompteGeneral();
				                $cg_mapper = new Application_Model_EuCompteGeneralMapper();
				                $result2 = FALSE;
				
				                if ($type == 'RPG') {
				                    $result2 = $cg_mapper->find('FGRPG', 'NN', 'E', $compte_gene);
				                } else {
				                    $result2 = $cg_mapper->find('FGI', 'NN', 'E', $compte_gene);
				                }
				                if ($result2) {
					                $compte_gene->setSolde($compte_gene->getSolde() + $montant);
					                $cg_mapper->update($compte_gene);
				                } else {
						          if ($type == 'RPG') {
								    $compte_gene->setCode_compte('FGRPG');
								    $compte_gene->setIntitule('FGRPG');
						          } else {
								    $compte_gene->setCode_compte('FGI');
								    $compte_gene->setIntitule('FGI');
						          }
						          $compte_gene->setCode_type_compte('NN');
						          $compte_gene->setService('E');
						          $compte_gene->setSolde($montant);
						          $cg_mapper->save($compte_gene);
				                }
								
				                //Mise à jour du compte général FN
				                $cgfn = new Application_Model_EuCompteGeneral();
				                $result_3 = $cg_mapper->find('FN', 'NR', 'E', $cgfn);
				                if ($result_3) {
					               $cgfn->setSolde($cgfn->getSolde() + $montant);
					               $cg_mapper->update($cgfn);
				                } else {
					               $cgfn->setCode_compte('FN');
					               $cgfn->setIntitule('FN');
					               $cgfn->setService('E')->setCode_type_compte('NR');
					               $cgfn->setSolde($montant);
					               $cg_mapper->save($cgfn);
				                }
								
								if ($fs > 0) {
								    $bnp->setId_credit($max_code)
                                        ->setMont_fs($bnp->getMont_fs() + $fs)
                                        ->setIndexer(1);
                                    if ($panu_fs > 0) {
                                       $bnp->setMont_panu_fs(0);
                                    }
                                    $bmap->update($bnp);
														
									//Mise à jour du fs
									if($bnp->getCode_membre_app() != null) {
                                        $cfs = 'NB-TFS-'.$bnp->getCode_membre_app();
							            $membre_app = $bnp->getCode_membre_app();
									}
														
								    if($bnp->getCode_membre_morale_app() != null) {
                                        $cfs = 'NB-TFS-'.$bnp->getCode_membre_morale_app();
										$membre_app = $bnp->getCode_membre_morale_app();
								    }
														
                                    $compte_fs = new Application_Model_EuCompte();
                                    $ret_fs = $cm_mapper->find($cfs,$compte_fs);
									if ($ret_fs == false) {
                                        $compte->setCode_membre($membre_app)
                                               ->setCode_cat('TFS')
                                               ->setSolde($fs)
                                               ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                               ->setCode_compte($cfs)
                                               ->setLib_compte('TFS')
                                               ->setCode_type_compte('NB')
                                               ->setDesactiver(0);
                                        $cm_mapper->save($compte);
                                    } else {
                                        $compte->setSolde($compte->getSolde() + $fs);
                                        $cm_mapper->update($compte);
                                    }
						            //Mise à jour des comptes credits
                                    $source = $membre_app . $date_deb->toString('yyyyMMddHHmmss');
                                    $max_code = $cc_mapper->findConuter() + 1;
				                    $compte_source = '';
													   
								    Util_Utils::createCompteCredit($max_code,0,$compteur,$membre_app,'FS',$cfs,$fs,$bnp->getMont_caps(),$date_deb->toString('yyyy-MM-dd HH:mm:ss'),$date_fin->toString('yyyy-MM-dd HH:mm:ss'),$source,$compte_source,'N','N',0,0,null,'CNPG',$prk,-1);
                                    $maxcnp = $m_cnp->findConuter() + 1;
									$cnp->setId_cnp($maxcnp)
										->setId_credit($max_code)
                                        ->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
                                        ->setMont_debit($fs)
                                        ->setMont_credit(0)
                                        ->setSolde_cnp($fs)
                                        ->setType_cnp($code_produit)
                                        ->setSource_credit($source)
                                        ->setTransfert_gcp(0);
                                        if ($code_produit == 'Inr') {
                                           $cnp->setOrigine_cnp('FGInr');
                                        } elseif ($code_produit == 'Ir') {
                                           $cnp->setOrigine_cnp('FGIr');
                                        } elseif ($code_produit == 'RPGr') {
                                            $cnp->setOrigine_cnp('FGRPGr');
                                        } elseif ($code_produit == 'RPGnr') {
                                            $cnp->setOrigine_cnp('FGRPGnr');
                                        }
                                        $m_cnp->save($cnp);
								    }
									
									if ($mont_rcapa > 0) {
									    $prows = $tparam->find('periode', 'valeur');
                                        if (count($prows) > 0) {
                                           $periode = $prows->current()->montant;
                                        }
								        $brows = $tparam->find('bnp','periode');
                                        if (count($brows) > 0) {
                                           $periodebnp = $brows->current()->montant;
                                        }
										
										$date_echue = new Zend_Date(Zend_Date::ISO_8601);
					                    $date_echue->addDay(floor($periodebnp*$periode));
										
										$id_krr   = $mkrr->findConuter() + 1;
						                $mont_krr = ($mont_place*$trcapa)/$pck;
										
										$krr->setId_krr($id_krr)
							                ->setId_credit($max_code)
                                            ->setCode_produit($code_produit)
                                            ->setMont_capa($mont_place)
                                            ->setMont_krr($mont_krr)
                                            ->setDate_echue($date_echue->toString('yyyy-MM-dd'))
                                            ->setDate_renouveller($date_deb->toString('yyyy-MM-dd'))
                                            ->setPayer('N')
                                            ->setReconstituer('N')
                                            ->setDate_demande($date_deb->toString('yyyy-MM-dd'))
				                            ->setType_krr('krrBCRI')
						                    ->setMont_reconst($mont_rcapa);
								
							            if (Util_Utils::getmembreType($code_membre) === 'M') {	
							               $krr->setCode_membre_morale($code_membre);	
							            } else {
                                           $krr->setCode_membre($code_membre);
                                        }							
                                        $mkrr->save($krr);
							
						                $id_detail_krr = $mdkrr->findConuter() + 1;
						                $dkrr->setId_detail_krr($id_detail_krr)
							                 ->setId_krr($id_krr)
						                     ->setId_credit($max_code)
							                 ->setSource_credit($source)
							                 ->setMont_credit($mont_rcapa)
							                 ->setAnnuler(0);
						                $mdkrr->save($dkrr);		
								    }
									
								    $cpte = Util_Utils::findConuter() + 1;
								    if (Util_Utils::getmembreType($code_membre) === 'P') {
								       $findmembre = $membre_map->find($code_membre,$membre);
								       Util_Utils::addSms($cpte,$membre->getPortable_membre(), "Vous venez de recharger  ".$credi . " " . $code_dev . " sur votre compte TPAGCRPG");
								    } else {
								       $findmembre = $moral_map->find($code_membre,$moral);
									   Util_Utils::addSms($cpte,$moral->getPortable_membre(), "Vous venez de recharger  ".$credi . " " . $code_dev . " sur votre compte TPAGCI");
								    }
							
							    $db->commit();
				                $sessionmembre->errorlogin = "Opération CAPA effectuée avec succès !!!";
				                $this->_redirect('/espacepersonnel/compte');
							}
						
				        }
				        
				    } catch (Exception $exc) {
				       $db->rollback();
				       $sessionmembre->errorlogin = $exc->getMessage() . '=>' . $exc->getTraceAsString();
				       return;
			        }
            }	
	}
	
	
	
	

	public function apapreAction() 
	{
		/* page espacepersonnel/apapre - Achat de CNP PRE*/

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

			$m_compte = new Application_Model_EuCompteMapper();
			$compte = new Application_Model_EuCompte();
			$code_compte = 'NN-TSCAPA-' . $sessionmembre->code_membre;
			$ret_req = $m_compte->find($code_compte, $compte);
				$this->view->compte_solde = $compte->solde;
				
$prk = Util_Utils::getParametre('prk', 'nr');

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['mont_capa']) && $_POST['mont_capa'] != "" && isset($_POST['mont_inv']) && $_POST['mont_inv'] != "" && isset($_POST['mont_credit2']) && $_POST['mont_credit2'] != "" && isset($_POST['duree_inv']) && $_POST['duree_inv'] > $prk && $_POST['mont_capa'] >= $_POST['mont_credit2']) {


				$code_compte = "NN-TSCAPA-" . $sessionmembre->code_membre;

				/*$m_creditcode = new Application_Model_EuCredit_CodeMapper();
				$creditcode = new Application_Model_EuCredit_Code();
				$m_creditcode->find($code_compte, $creditcode);*/

//$code_membre_acnev = "0010010010010000001M";//$user->code_membre

				//$credi = $_POST['mont_credit'];
				$num_membre = $sessionmembre->code_membre;
				$type = $sessionmembre->type;
				$montant = $_POST['mont_capa'];
				$code_dev = $_POST['dev_capa'];
				//$code_sms = $creditcode->credit_code;
				//$mont_sms = $_POST['mont_sms'];
				$nom_membre = $sessionmembre->nom_membre;
				$prenom_membre = $sessionmembre->prenom_membre;
				$type_capa = $sessionmembre->typepernonne;
				$mont_inv = $_POST['mont_inv'];
				$duree_inv = $_POST['duree_inv'];
				$mont_credit2 = $_POST['mont_credit2'];
				//$pre = $_POST['pre'];

					if (substr($sessionmembre->code_membre, -1) == "P") {
					$m_membre = new Application_Model_EuMembreMapper();
					$membre = new Application_Model_EuMembre();
					$retour = $m_membre->find($sessionmembre->code_membre, $membre);
					}else if (substr($sessionmembre->code_membre, -1) == "M") {
					$m_membre = new Application_Model_EuMembreMoraleMapper();
					$membre = new Application_Model_EuMembreMorale();
					$retour = $m_membre->find($sessionmembre->code_membre, $membre);
					}

						$prod = new Application_Model_EuProduit();
						$code = $type . 'nrPRE';
						$p_mapper = new Application_Model_EuProduitMapper();
						$p_result = $p_mapper->find($code, $prod);

						$cm_mapper = new Application_Model_EuCompteMapper();

						//calcul de la PRE et du crédit
						$prk = Util_Utils::getParametre('prk', 'nr');
						$pck = Util_Utils::getParametre('pck', 'nr');
						if ($duree_inv > floor($prk)) {
							$pre = $duree_inv;
							$credi = round($mont_inv / $pre);
							$montant = round($credi * $pck);
							$renouveller = 'O';
						} else {
							$credi = $mont_inv;
							$montant = round(($credi * $pck) / $prk);
							$renouveller = 'N';
						}
						$num_compte = '';
						$code_cat = '';
						if ($type == 'RPG' or $type == 'I') {
							$code_cat = 'TPAGC' . $type; 
							$code_cat_ts = 'TS' . $type;
							$num_compte = 'NB-' . $code_cat . '-' . $num_membre;
							$num_compte_ts = 'NB-' . $code_cat_ts . '-' . $num_membre;
						}
						$mapper = new Application_Model_EuOperationMapper();
						$compteur = $mapper->findConuter() + 1;
						$date_fin = new Zend_Date(Zend_Date::ISO_8601);
						$date_deb = clone $date_fin;
						$lib_op = '';
						if ($type == 'RPG') {
							$lib_op = 'Achat du RPG';
						} elseif ($type == 'I') {
							$lib_op = 'Achat d\'Investissement';
						}
						
				$place_op = new Application_Model_EuOperation();
				$place_op->setId_operation($compteur)
						->setDate_op($date_deb->toString('yyyy-MM-dd'))
						->setMontant_op($mont_inv);
					if (substr($num_membre, -1) == "P") {
				$place_op->setCode_membre($num_membre);
				$place_op->setCode_membre_morale(NULL);
					} else if (substr($num_membre, -1) == "M") {
				$place_op->setCode_membre(NULL);
				$place_op->setCode_membre_morale($num_membre);
					}
				$place_op->setHeure_op($date_deb->toString('HH:mm:ss'))
						->setCode_produit($code)
						->setId_utilisateur(NULL)
						->setLib_op($lib_op)
						->setCode_cat($code_cat)
						->setType_op('APA');
				$mapper->save($place_op);
										

						//vérification des quotas
						$mont_place = $mont_inv;
						if ($mont_place > 0) {
						$cm_mapper = new Application_Model_EuCompteMapper();
							$compte = new Application_Model_EuCompte();
							$result = $cm_mapper->find($num_compte, $compte);
							if ($result == FALSE) {
								$type_compte = 'NB';
								
								
									$compte->setCode_cat($code_cat);
									if (substr($num_membre, -1) == "P") {
										$compte->setCode_membre($num_membre);
										$compte->setCode_membre_morale(NULL);
									} else if (substr($num_membre, -1) == "M") {
										$compte->setCode_membre(NULL);
										$compte->setCode_membre_morale($num_membre);
									}
									$compte->setCode_compte($num_compte)
											->setCode_type_compte($type_compte)
											->setDate_alloc($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
											->setDesactiver(0)
											->setLib_compte($code_cat)
											->setSolde($credi);
									$cm_mapper->save($compte);
									
									$compte->setCode_cat($code_cat);
									if (substr($sessionmembre->code_membre, -1) == "P") {
										$compte->setCode_membre($sessionmembre->code_membre);
										$compte->setCode_membre_morale(NULL);
									} else if (substr($sessionmembre->code_membre, -1) == "M") {
										$compte->setCode_membre(NULL);
										$compte->setCode_membre_morale($sessionmembre->code_membre);
									}
									$compte->setCode_compte($num_compte_ts)
											->setCode_type_compte($type_compte)
											->setDate_alloc($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
											->setDesactiver(0)
											->setLib_compte($code_cat)
											->setSolde(0);
									$cm_mapper->save($compte);
								
							} else {
								$compte->setSolde($compte->getSolde() + $credi);
								$cm_mapper->update($compte);
							}

							//Mise à jour des comptes credits
							$cc_mapper = new Application_Model_EuCompteCreditMapper();
							$source = $num_membre . $date_deb->toString('yyyyMMddHHmmss');
							$max_code = $cc_mapper->findConuter() + 1;
							$periode = Util_Utils::getParametre('periode', 'valeur');
							$date_fin->addDay($periode);
							$compte_source = '';
							if ($type == 'RPG') {
								$compte_source = $code_compte;
							} elseif ($type == 'I') {
								$compte_source = $code_compte;
							}
							
				$place_cocr = new Application_Model_EuCompteCredit();
				$place_cocr->setId_credit($max_code)
							->setMontant_credit($credi)
							->setCode_membre($num_membre)
							->setCode_produit($code)
							->setMontant_place($mont_place)
							->setDatefin($date_fin->toString('yyyy-MM-dd'))
							->setDatedeb($date_deb->toString('yyyy-MM-dd'))
							->setSource($source)
							->setDate_octroi($date_deb->toString('yyyy-MM-dd'))
							->setCompte_source($compte_source)
							->setKrr('N')
							->setPrk($pre)
							->setCode_type_credit("CNPG")
							->setNbre_renouvel($pre)
							->setRenouveller($renouveller)
							->setBnp(0)
							->setCode_compte($num_compte)
							->setId_operation($compteur)
							->setDomicilier(0)
							->setCode_bnp(NULL)
							->setAffecter(1);
				$cc_mapper->save($place_cocr);
							


							//Mise à jour des FGFN
							$fgfn = new Application_Model_EuFgfn();
							$fgfn_map = new Application_Model_EuFgfnMapper();
							$code_fgfn = 'FGFN-' . $code_membre_acnev;
							$ret_fg = $fgfn_map->find($code_fgfn, $fgfn);
							if (!$ret_fg) {
								$fgfn->setCode_fgfn($code_fgfn)
										->setCode_membre($code_membre_acnev)
										->setSolde_fgfn($mont_place);
								$fgfn_map->save($fgfn);
							} else {
								$fgfn->setSolde_fgfn($fgfn->getSolde_fgfn() + $mont_place);
								$fgfn_map->update($fgfn);
							}

							$det_fg = new Application_Model_EuDetailFgfn();
							$fg_mapper = new Application_Model_EuDetailFgfnMapper();
							$compt_fgfn = $fg_mapper->findConuter() + 1;
							$det_fg->setId_fgfn($compt_fgfn)
									->setCode_membre_pbf($code_membre_acnev)
									->setMont_fgfn($mont_place)
									->setDate_fgfn($date_deb->toString('yyyy-MM-dd'))
									->setMont_preleve(0)
									->setSolde_fgfn($mont_place)
									->setCode_fgfn($code_fgfn)
									->setOrigine_fgfn('SMS');
							$fg_mapper->save($det_fg);

							//Mise à jour du CNP
							$cnp = new Application_Model_EuCnp();
							$m_cnp = new Application_Model_EuCnpMapper();
							$compt_cnp = $m_cnp->findConuter() + 1;
							$cnp->setId_cnp($compt_cnp)
									->setId_credit($max_code)
									->setDate_cnp($date_deb->toString('yyyy-MM-dd'))
									->setMont_debit($credi)
									->setMont_credit(0)
									->setSolde_cnp($credi)
									->setType_cnp($code)
									->setSource_credit($source)
									->setCode_capa($code_capa)
									->setTransfert_gcp(0);
							if ($code == 'Inr') {
								$cnp->setOrigine_cnp('FGInr');
							} elseif ($code == 'Ir') {
								$cnp->setOrigine_cnp('FGIr');
							} elseif ($code == 'RPGr') {
								$cnp->setOrigine_cnp('FGRPGr');
							} elseif ($code == 'RPGnr') {
								$cnp->setOrigine_cnp('FGRPGnr');
							}
							$m_cnp->save($cnp);
						}
						
						
						
///////////////////////////////////////////////////////////						
						
$mp_capa = new Application_Model_EuCapaMapper();
$p_capa = new Application_Model_EuCapa();
$entries_capa = $mp_capa->fetchAllByCompte($code_compte);
$montplace = $mont_place;
foreach ($entries_capa as $entry):						

if($montplace <= $entry->montant_solde){			
$capa_mapper = new Application_Model_EuCapaMapper();
$capa_p = new Application_Model_EuCapa();
$result_capa = $capa_mapper->find($entry->code_capa, $capa_p);
$capa_p->setMontant_utiliser($capa_p->getMontant_utiliser() + $montplace);
$capa_p->setMontant_solde($capa_p->getMontant_solde() - $montplace);
$capa_mapper->update($capa_p);


							//Mise à jour de la table FN
							$fn = new Application_Model_EuFn();
							$m_fn = new Application_Model_EuFnMapper();
							$compt_fn = $m_fn->findConuter() + 1;
							$fn->setId_fn($compt_fn)
									->setCode_capa($entry->code_capa)
									->setDate_fn($date_deb->toString('yyyy-MM-dd'))
									->setType_fn('Inr')
									->setMontant($montplace)
									->setSortie(0)
									->setEntree(0)
									->setSolde(0)
									->setOrigine_fn(1)
								   ->setMt_solde($montplace);
							$m_fn->save($fn);
							
						$util_nn = new Application_Model_EuUtiliserNn();
						$util_nn_map = new Application_Model_EuUtiliserNnMapper();
							$compt_util_nn = $util_nn_map->findConuter() + 1;
							$util_nn->setId_utiliser_nn($compt_util_nn)
								->setCode_membre_nn($num_membre)
								->setCode_membre_nb($num_membre)
								->setId_utilisateur(NULL)//$user->id_utilisateur
								->setId_operation($compteur)
								->setCode_produit($entry->code_produit)
								->setCode_produit_nn('CAPA')
								->setMont_transfert($montplace)
								->setDate_transfert($date_deb->toString('yyyy-MM-dd'))
								->setNum_bon('')
								->setCode_sms('');
						$util_nn_map->save($util_nn);
						
						
						
						
								$m_creditcapa = new Application_Model_EuCompteCreditCapaMapper();
								$creditcapa = new Application_Model_EuCompteCreditCapa();
								$creditcapa->setCode_capa($entry->code_capa)
										->setMontant($montplace)
										->setId_credit($max_code)
										->setCode_produit($code);
								$m_creditcapa->save($creditcapa);
						


							$m_capa_affect = new Application_Model_EuCapaAffecterMapper();
							$capa_affect = new Application_Model_EuCapaAffecter();
							$id_affecter = $m_capa_affect->findConuter() + 1;
							$capa_affect->setId_affecter($id_affecter)
										->setCode_capa($entry->code_capa)
									->setDuree_renouvellement($pre)
									->setReste_duree($pre)
									->setMont_invest(round($mont_inv))
									->setId_credit($max_code)
									->setType_credit($type);
							$m_capa_affect->save($capa_affect);
						
						

break;}else{
$capa_mapper = new Application_Model_EuCapaMapper();
$capa_p = new Application_Model_EuCapa();
$result_capa = $capa_mapper->find($entry->code_capa, $capa_p);
$capa_p->setMontant_utiliser($capa_p->getMontant_utiliser() + $entry->montant_solde);
$capa_p->setMontant_solde($capa_p->getMontant_solde() - $entry->montant_solde);
$capa_mapper->update($capa_p);
$montplace = $montplace - $entry->montant_solde;


							//Mise à jour de la table FN
							$fn = new Application_Model_EuFn();
							$m_fn = new Application_Model_EuFnMapper();
							$compt_fn = $m_fn->findConuter() + 1;
							$fn->setId_fn($compt_fn)
									->setCode_capa($entry->code_capa)
									->setDate_fn($date_deb->toString('yyyy-MM-dd'))
									->setType_fn('Inr')
									->setMontant($entry->montant_solde)
									->setSortie(0)
									->setEntree(0)
									->setSolde(0)
									->setOrigine_fn(1)
								   ->setMt_solde($entry->montant_solde);
							$m_fn->save($fn);

						$util_nn = new Application_Model_EuUtiliserNn();
						$util_nn_map = new Application_Model_EuUtiliserNnMapper();
							$compt_util_nn = $util_nn_map->findConuter() + 1;
							$util_nn->setId_utiliser_nn($compt_util_nn)
								->setCode_membre_nn($num_membre)
								->setCode_membre_nb($num_membre)
								->setId_utilisateur(NULL)//$user->id_utilisateur
								->setId_operation($compteur)
								->setCode_produit($entry->code_produit)
								->setCode_produit_nn('CAPA')
								->setMont_transfert($entry->montant_solde)
								->setDate_transfert($date_deb->toString('yyyy-MM-dd'))
								->setNum_bon('')
								->setCode_sms('');
						$util_nn_map->save($util_nn);

						
						
								$m_creditcapa = new Application_Model_EuCompteCreditCapaMapper();
								$creditcapa = new Application_Model_EuCompteCreditCapa();
								$creditcapa->setCode_capa($entry->code_capa)
										->setMontant($entry->montant_solde)
										->setId_credit($max_code)
										->setCode_produit($code);
								$m_creditcapa->save($creditcapa);
						


							$m_capa_affect = new Application_Model_EuCapaAffecterMapper();
							$capa_affect = new Application_Model_EuCapaAffecter();
							$id_affecter = $m_capa_affect->findConuter() + 1;
							$capa_affect->setId_affecter($id_affecter)
										->setCode_capa($entry->code_capa)
									->setDuree_renouvellement($pre)
									->setReste_duree($pre)
									->setMont_invest(round($mont_inv))
									->setId_credit($max_code)
									->setType_credit($type);
							$m_capa_affect->save($capa_affect);
						
						

}			
endforeach;						
						
///////////////////////////////////////////////////////////						
						
						$cm_mapper1 = new Application_Model_EuCompteMapper();
							$compte1 = new Application_Model_EuCompte();
							$result1 = $cm_mapper1->find($code_compte, $compte1);
								$compte1->setSolde($compte1->getSolde() - $mont_place);
								$cm_mapper1->update($compte1);
						
///////////////////////////////////////////////////////////						
						
						if ($result) {
							Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $compte->getSolde());
						} else {
							Util_Utils::addSms($membre->getPortable_membre(), "Vous venez de recharger " . $credi . " " . $code_dev . " sur le compte " . $num_compte . ". Solde final: " . $credi);
						}
///////////////////////////////////////////////////////////		



				
						
						//$db->commit();
						$message = "Opération CAPA nrPRE effectuée avec succès !!!";
						$sessionmembre->errorlogin = $message;
						//return $this->_helper->redirector('index');




				$sessionmembre->errorlogin = $message;
				$this->_redirect('/espacepersonnel/compte');
			} else {
				$sessionmembre->errorlogin = "Les champs * sont obligatoires";
			}
			//$this->_redirect('/espacepersonnel/apa');
		} else {

			if ($ret_req === FALSE) {

				$sessionmembre->errorlogin = "Vous n'avez pas de Compte NN-CAPA";
				$this->_redirect('/espacepersonnel/capa');
			} else {

				$this->view->compte_solde = $compte->solde;
			}
		}
	}






	public function carteAction() 
	{
		/* page espacepersonnel/carte - Commande de cartes */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		} 
		 if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
 
			

		  
		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['creditcode']) && $_POST['creditcode'] != "" && isset($_POST['carte']) && $_POST['carte'] != "") {
		  
		  

				//$code_membre_acnev = "0010010010010000001M";//$user->code_membre

			   $date = Zend_Date::now();
			   $carte = new Application_Model_EuCartes();
			   $t_carte = new Application_Model_DbTable_EuCartes();
			   $compte = new Application_Model_EuCompte();
			   $map_compte = new Application_Model_EuCompteMapper();
			   $map_membre = new Application_Model_EuMembreMapper();
			   $map_membreM = new Application_Model_EuMembreMoraleMapper();
			   
						
				  $montant = $_POST["creditcode"];
						
					$membre = $sessionmembre->code_membre;
					$num_membre = $sessionmembre->code_membre;
					// vérification de la licence
					$tfl = new Application_Model_DbTable_EuFl();
					$code_fl = 'FL-' . $membre;
					$result = $tfl->find($code_fl);
					if (count($result) > 0) {
					//if (count($result) == 0) {
						$somme = 0;
						for($i = 0; $i < count($_POST['carte']); $i++){
							if($_POST['carte'][$i] != ""){
							 $somme = $somme + $_POST['prix'][$i];
							 }
						}
					$montant = $somme;
					
						
					  $cm_map = new Application_Model_EuCompteMapper();
						 $code_sms = $_POST["creditcode"];
						 $sms_mapper = new Application_Model_EuSmsmoneyMapper();
						 $sms = $sms_mapper->findByCreditCode($code_sms);
								if ($sms != NULL) {
								   $montant = $sms->getCreditAmount();
								   if ($somme != $montant) {
									   //$db->rollBack();
									   $sessionmembre->errorlogin = 'La valeur du Code SMS ' . $code_sms . ' doit etre egale au montant des cartes demandees!!!';
									   return;
								   }
								} else {
									   //$db->rollBack();
									   $sessionmembre->errorlogin = 'Le Code SMS ' . $code_sms . ' a deje ete utilise ou invalide!!!';
									   return;
								}
								if($sms->getMotif() != 'FCPS') {
									   //$db->rollBack();
									   $sessionmembre->errorlogin = 'Le motif pour lequel ce code est emis ne correspond pas pour cette operation';
									   return;
									   
								}


							if ($montant == $somme) {
								for($i = 0; $i < count($_POST['carte']); $i++){
									if($_POST['carte'][$i] != ""){
									list($type_carte, $code_cat) = explode("-", $_POST['carte'][$i]);
									$type_membre = substr($membre,19,1);
									
									$num_compte = $type_carte . '-' . $code_cat . '-' . $membre;
									switch ($code_cat) {
										case "TPAGCI":
											$code_cat_ts = "TSI";
											break;
										case "TCNCSEI":
											$code_cat_ts = "TSCNCSEI";
											break;
										case "TPN":

											$code_cat_ts = "TSPN";
											break;
										case "TI":
											$code_cat_ts = "TSI";
											break;
										case "TPAGCP":
											$code_cat_ts = "TSGCP";
											break;
										case "TSCI":
											$code_cat_ts = "TSSCI";
											break;
										case "TR":
											$code_cat_ts = "TSR";
											break;
										case "TPAGCRPG":
											$code_cat_ts = "TSRPG";
											break;
										case "TCNCS":
											$code_cat_ts = "TSCNCS";

											break;
										case "TPaNu":
											$code_cat_ts = "TSPaNu";
											break;										
										case "TPaR":
											$code_cat_ts = "TSPaR";
											break;										
										/*case "":
											$code_cat_ts = "";
											break;										
										case "":
											$code_cat_ts = "";
											break;*/										
										}
									$num_compte_ts = $type_carte . '-' . $code_cat_ts . '-' . $membre;
									
									if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI" || $code_cat == "TR")) {
										$sessionmembre->errorlogin = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
										return;
									}
									if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
										$sessionmembre->errorlogin = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
										return;
									}
									$c_select = $t_carte->select();
									$c_select->where('code_membre like ?', $membre)
											->where('code_cat like ?', $code_cat);
									$results = $t_carte->fetchAll($c_select);
									if (count($results) >= 1) {
										$sessionmembre->errorlogin = 'La demande de cette carte ' . $code_cat . ' a dejà été effectuée pour ce membre !!!';
										return;
									}
									$res = $map_compte->find($num_compte, $compte);
									if (!$res) {
										
										if (substr($sessionmembre->code_membre, -1) == "P") {
										$compte->setCode_membre($membre);
										$compte->setCode_membre_morale(NULL);
										} else if (substr($sessionmembre->code_membre, -1) == "M") {
										$compte->setCode_membre(NULL);
										$compte->setCode_membre_morale($membre);
										}
										$compte->setCode_cat($code_cat)
												->setCode_compte($num_compte)
												->setCode_type_compte($type_carte)
												->setDate_alloc($date->toString('yyyy-MM-dd'))
												->setDesactiver(0)
												->setLib_compte($code_cat)
												->setSolde(0);
										$map_compte->save($compte);
										
										if (substr($sessionmembre->code_membre, -1) == "P") {
										$compte->setCode_membre($membre);
										$compte->setCode_membre_morale(NULL);
										} else if (substr($sessionmembre->code_membre, -1) == "M") {
										$compte->setCode_membre(NULL);
										$compte->setCode_membre_morale($membre);
										}
										$compte->setCode_cat($code_cat)
												->setCode_compte($num_compte_ts)
												->setCode_type_compte($type_carte)
												->setDate_alloc($date->toString('yyyy-MM-dd'))
												->setDesactiver(0)
												->setLib_compte($code_cat)
												->setSolde(0);
										$map_compte->save($compte);
										//$prix = $prix[$i];
										
			   $carte = new Application_Model_EuCartes();
			   $t_carte = new Application_Model_DbTable_EuCartes();
								$id_demande = $carte->findConuter() + 1;
										$carte->setId_demande($id_demande)
												->setCode_cat($code_cat)
												->setCode_membre($membre)
												->setMont_carte($_POST['prix'][$i])
												->setDate_demande($date->toString('yyyy-MM-dd HH:mm:ss'))
												->setLivrer(0)
												->setCode_Compte($num_compte)
												->setImprimer(0)
												->setCardPrintedDate(NULL)
												->setCardPrintedIDDate(0)
												->setId_utilisateur(NULL);//$user->id_utilisateur
										$t_carte->insert($carte->toArray());
									} else {
										if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
											//$prix = $prix[$i];
											
			   $carte = new Application_Model_EuCartes();
			   $t_carte = new Application_Model_DbTable_EuCartes();
								$id_demande = $carte->findConuter() + 1;
										$carte->setId_demande($id_demande)
												->setCode_cat($code_cat)
													->setCode_membre($membre)
													->setMont_carte($_POST['prix'][$i])
													->setDate_demande($date->toString('yyyy-MM-dd'))
													->setLivrer(0)
													->setImprimer(0)
													->setCardPrintedDate('')
													->setCardPrintedIDDate(0)
													->setCode_Compte($num_compte)
													->setId_utilisateur(NULL);//$user->id_utilisateur
											$t_carte->insert($carte->toArray());
										} else {
											$sessionmembre->errorlogin = 'La carte ' . $code_cat . ' a dejà été imprimé pour ce membre !!!';
											return;
										}
									}
									}
								}
								
								$mapper = new Application_Model_EuOperationMapper();
								$compteur = $mapper->findConuter() + 1;
								
								if(substr($membre,19,1)=='P'){
									 Util_Utils::addOperation($compteur, $membre,NULL, NULL, $montant, NULL, 'Frais de CPS', 'CPS', $date->toString('yyyy-MM-dd'), $date->toString('HH:mm:ss'), NULL);//$user->id_utilisateur
								}
								else {
									 Util_Utils::addOperation($compteur,NULL,$membre, NULL, $montant, NULL, 'Frais de CPS', 'CPS', $date->toString('yyyy-MM-dd'), $date->toString('HH:mm:ss'), NULL);//$user->id_utilisateur
								}
								
										$sms->setDestAccount_Consumed('CPS-' . $membre)
											->setDateTimeconsumed($date->toString('dd/MM/yyyy HH:mm:ss'))
											->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/MM/yyyy')));
										$sms_mapper->update($sms);    
							
							
								
						$date_fin = new Zend_Date(Zend_Date::ISO_8601);
						$date_deb = clone $date_fin;

								$mont_place = $montant;

						$tx_prestation = Util_Utils::getParametre('CNCS', 'CAPA');
						//$membre_transfert = $code_membre_acnev;
						
												
						
								

								$sessionmembre->errorlogin = 'Achat de carte bien effectué';
				$this->_redirect('/espacepersonnel/compte');
								return;
							} else {
								$sessionmembre->errorlogin = 'Le montant doit être égal à la somme des prix des cartes!!!';
								return;
							}
							
						
					} else {
						   $sessionmembre->errorlogin = "Vous devez souscrire à la licence de 10000 avant la demande de cartes";
						   return;
				}
					
		  
		  
			} else {
				$sessionmembre->errorlogin = "Les champs * sont obligatoires";
			}
			//$this->_redirect('/espacepersonnel/apa');
		}
	}





	public function panierAction() 
	{
		/* page espacepersonnel/panier - Achat en ligne */

		$sessionpanier = new Zend_Session_Namespace('panier');
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		} 
if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

			$m_compte = new Application_Model_EuCompteMapper();
			$compte = new Application_Model_EuCompte();
			$code_compte = 'NB-TS' . $sessionmembre->type . '-' . $sessionmembre->code_membre;
			$code_compte_fist = 'NB-TPAGC' . $sessionmembre->type . '-' . $sessionmembre->code_membre;
			$ret_req = $m_compte->find($code_compte, $compte);

				$this->view->compte_solde = $compte->solde;


		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['montant']) && $_POST['montant'] != "" && isset($_POST['mont_capa']) && $_POST['mont_capa'] != "" && $_POST['mont_capa'] >= $_POST['montant'] && isset($_POST['categorie']) && $_POST['categorie'] != "") {

list($type, $categorie) = explode("-", $_POST['categorie']);


				$date_id = new Zend_Date(Zend_Date::ISO_8601);

$code_proforma = strtoupper(Util_Utils::genererCodeSMS(8));
$date_commande = $date_id->toString('yyyy-MM-dd HH:mm:ss');

				$commande = new Application_Model_EuCommande();
				$m_commande = new Application_Model_EuCommandeMapper();

					$compt_commande = $m_commande->findConuter() + 1;

					$commande->setCode_commande($compt_commande);
					$commande->setDate_commande($date_commande);
					$commande->setMontant_commande($_POST['montant']);
					$commande->setCode_membre_acheteur($sessionpanier->produit[$i][8]);
					$commande->setCode_membre_vendeur($sessionpanier->produit[$i][6]);
					$commande->setQuartier_acheteur($_POST['quartier_acheteur']);
					$commande->setVille_acheteur($_POST['ville_acheteur']);
					$commande->setTel_acheteur($_POST['tel_acheteur']);
					$commande->setAdresse_livraison($_POST['adresse_livraison']);
					$commande->setCode_livraison($_POST['code_livraison']);
					$commande->setCode_proforma($code_proforma);
					$commande->setExecuter(0);    
					$m_commande->save($commande);

for($i = 0; $i < count($sessionpanier->produit); $i++){ 
if($sessionpanier->produit[$i][0] != ""){

				$detailcommande = new Application_Model_EuDetailCommande();
				$m_detailcommande = new Application_Model_EuDetailCommandeMapper();

					$compt_detailcommande = $m_detailcommande->findConuter() + 1;

					$detailcommande->setId_detail_commande($compt_detailcommande);
					$detailcommande->setCode_commande($compt_commande);
					$detailcommande->setQte($_POST['qte'][$i]);
					$detailcommande->setPrix_unitaire($sessionpanier->produit[$i][3]);
					$detailcommande->setReference($sessionpanier->produit[$i][1]);
					$detailcommande->setDesignation($sessionpanier->produit[$i][2]);
					$detailcommande->setLivrer(0);
					$detailcommande->setRemise($sessionpanier->produit[$i][12]);
					$m_detailcommande->save($detailcommande);
					
}
} 
				$sessionmembre->errorlogin = "Commande bien effectuée ...";
$compteur = Util_Utils::findConuter() + 1; 
						  Util_Utils::addSms($compteur, $_POST['tel_acheteur'], "Vous venez de lancer une commande. Veuillez confirmer avec ce code : " . $code_proforma);
					
				$this->_redirect('/espacepersonnel/panierconfirme');
						
		   } else {
				$sessionmembre->errorlogin = "Les champs * sont obligatoires";
			}
} else {
			if ($ret_req === FALSE) {

				$sessionmembre->errorlogin = "Vous n'avez pas de Compte Marchant";
				$this->_redirect('/espacepersonnel/compte');
			} else {

				$this->view->compte_solde = $compte->solde;
			}
		}

	}





	public function panierconfirmeAction() 
	{
		$sessionpanier = new Zend_Session_Namespace('panier');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		  
		  
	}



	public function retirerpanierAction() 
	{
		$sessionpanier = new Zend_Session_Namespace('panier');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		  
		$i = (int) $this->_request->getParam('id');
		if ($i > -1) {
		  
	$sessionpanier->produit[$i][0] = "";
	$sessionpanier->produit[$i][1] = "";
	$sessionpanier->produit[$i][2] = "";
	$sessionpanier->produit[$i][3] = "";
	$sessionpanier->produit[$i][4] = "";
	$sessionpanier->produit[$i][5] = "";
	$sessionpanier->produit[$i][6] = "";
	$sessionpanier->produit[$i][7] = "";
	$sessionpanier->produit[$i][8] = "";
	$sessionpanier->produit[$i][9] = "";
	$sessionpanier->produit[$i][10] = "";
	$sessionpanier->produit[$i][11] = "";
	$sessionpanier->produit[$i][12] = "";
		  
		  } 
		  $this->_redirect('/espacepersonnel/panier');
		  
	}





	public function echangegcpAction() 
	{
		/* page espacepersonnel/echangegcp - Echange GCp */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

			$m_compte = new Application_Model_EuCompteMapper();
			$compte = new Application_Model_EuCompte();
			$code_compte = 'NB-TPAGCP-' . $sessionmembre->code_membre;
			$ret_req = $m_compte->find($code_compte, $compte);
				$this->view->compte_solde = $compte->solde;


		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['solde']) && $_POST['solde'] != "" && isset($_POST['membrep']) && $_POST['membrep'] != "" && $_POST['montant'] > 0) {

				$type = $sessionmembre->type;
				$desctype = $sessionmembre->desctype;

			$echange = new Application_Model_EuEchange();
			$m_echange = new Application_Model_EuEchangeMapper();
			$date = Zend_Date::now();

				$membre = $sessionmembre->code_membre;
				$membrep = $_POST['membrep'];
				$cpte = "GCP";
				$montant = $_POST['montant'];
				$credit = $_POST['categorie'];
				//$cat = $request->cat;
				
				$compte = 'NB-TPA' . $cpte . '-' . $membre;
				$cm_mapper = new Application_Model_EuCompteMapper();
				$cc_mapper = new Application_Model_EuCompteCreditMapper();
				$rappro_mapper = new Application_Model_EuRapprochementMapper();
				$gcp_preleve_mapper = new Application_Model_EuGcpPreleverMapper();
				$cnp_mapper = new Application_Model_EuCnpMapper();
				$cpte_origine = new Application_Model_EuCompte();
				$gcp_mapper = new Application_Model_EuGcpMapper();
				$op_mapper = new Application_Model_EuOperationMapper();
				$result = $cm_mapper->find($compte, $cpte_origine);
				$reste_gcp = $gcp_mapper->findSommeGcp($membre);
				if ($result && $reste_gcp > 0) {

					if ($cpte_origine->getSolde() >= $montant && $reste_gcp >= $montant) {
						if ($credit == 'Inr') {
							$code_cat = 'TPAGCI';
							$newcompte = 'NB-TPAGCI-' . $membrep;
						} else {
							$code_cat = 'TPAGCRPG';
							$newcompte = 'NB-TPAGCRPG-' . $membrep;
						}

						//Enregistrement de l'opération
						$count = $op_mapper->findConuter() + 1;
						$op = new Application_Model_EuOperation();
						$op->setId_operation($count)
								->setDate_op($date->toString('yyyy-MM-dd'))
								->setHeure_op($date->toString('HH:mm:ss'))
								->setId_utilisateur(NULL);//$user->id_utilisateur
							if (substr($membre, -1) == "P") {
								$op->setCode_membre($membre);
								$op->setCode_membre_morale(NULL);
							} else if (substr($membre, -1) == "M") {
								$op->setCode_membre(NULL);
								$op->setCode_membre_morale($membre);
							}
							$op->setMontant_op($montant)
								->setCode_produit('GCP')
								->setLib_op('Echange du GCP')
								->setType_op('EE')
								->setCode_cat('TPAGCP');
						$op_mapper->save($op);

						$countechange = $m_echange->findConuter() + 1;
						$echange->setId_echange($countechange)
								->setCode_membre($membre)
								->setCode_compte_ech($compte)
								->setMontant($montant)
								->setDate_echange($date->toString('yyyy-MM-dd'))
								->setId_utilisateur(NULL)//$user->id_utilisateur
								->setType_echange('NB/NB')
								->setCat_echange($cpte)
								->setAgio(0)
								->setCompenser(0)
								->setCode_produit($cpte)
								->setMontant_echange($montant)
								->setCode_compte_obt($newcompte);
						$m_echange->save($echange);
						
						$num_echange = $countechange;

						$ccompte = new Application_Model_EuCompte();
						$result = $cm_mapper->find($newcompte, $ccompte);
						if ($result == FALSE) {
							$ccompte->setDesactiver(0)
									->setSolde($montant)
									->setDate_alloc($date->toString('yyyy-MM-dd'))
									->setCode_compte($newcompte)
									->setLib_compte($credit)
									->setCode_cat($code_cat)
									->setCode_type_compte('NB');
							if (substr($membrep, -1) == "P") {
								$ccompte->setCode_membre($membrep);
								$ccompte->setCode_membre_morale(NULL);
							} else if (substr($membrep, -1) == "M") {
								$ccompte->setCode_membre(NULL);
								$ccompte->setCode_membre_morale($membrep);
							}
							$cm_mapper->save($ccompte);
						} else {
							$ccompte->setSolde($ccompte->getSolde() + $montant);
							$cm_mapper->update($ccompte);
						}

						$cpte_credit = new Application_Model_EuCompteCredit();
						$maxcc = $cc_mapper->findConuter() + 1;
						$source = $membre . $date->toString('yyyyMMddHHmmss');
						$cpte_credit->setId_credit($maxcc)
								->setCode_produit($credit)
								->setMontant_place($montant)
								->setDatedeb($date->toString('yyyy-MM-dd'))
								->setDatefin($date->toString('yyyy-MM-dd'))
								->setDate_octroi($date->toString('yyyy-MM-dd'))
								->setSource($source)
								->setCode_compte($newcompte)
								->setId_operation($count)
								->setBnp(0)
								->setCode_type_credit('CNPG')
								->setPrk(8)
								->setCompte_source($compte)
								->setMontant_credit($montant)
								->setRenouveller('N')
								->setDomicilier(0)
								->setAffecter(0)
								->setKrr('N')
								->setCode_membre($membrep);
						$cc_mapper->save($cpte_credit);

						$cnp = new Application_Model_EuCnp();
						$m_cnp = new Application_Model_EuCnpMapper();
							$compt_cnp = $m_cnp->findConuter() + 1;
							$cnp->setId_cnp($compt_cnp)
								->setId_credit($maxcc)
								->setDate_cnp($date->toString('yyyy-MM-dd'))
								->setMont_debit($montant)
								->setMont_credit(0)
								->setSolde_cnp($montant)
								->setType_cnp($credit)
								->setSource_credit($source)
								->setCode_capa(NULL)
								->setTransfert_gcp(0);
						if ($credit == 'Inr') {
							$cnp->setOrigine_cnp('EGCP-Inr');
						} else {
							$cnp->setOrigine_cnp('EGCP-RPGnr');
						}
						$m_cnp->save($cnp);

						$cpte_origine->setSolde($cpte_origine->getSolde() - $montant);
						$cm_mapper->update($cpte_origine);

						//Mise à jour du TEGCP correspondant
						$te = new Application_Model_EuTegc();
						$te_mapper = new Application_Model_EuTegcMapper();
						if ($te_mapper->findByMembre($membre, $te)) {
							$te->setMontant($te->getMontant() - $montant);
							$te_mapper->update($te);
						} else {
							$sessionmembre->errorlogin = 'Le TE du membre N°' . $membre . " n'existe pas";
							return;
						}

						$gcps = $gcp_mapper->findGcp($membre);
						$tcnp = new Application_Model_DbTable_EuCnpEntree();
						$tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
						$cred_ech = new Application_Model_EuCreditEchange();
						if (count($gcps) > 0) {
							$j = 0;
							while ($montant > 0 && $j < count($gcps)) {
								$gcp = $gcps[$j];
								if ($gcp->getReste() < $montant) {
									$montant = $montant - $gcp->getReste();

									$gcp_preleve = new Application_Model_EuGcpPrelever();
									$gcp_preleve->setId_gcp($gcp->getId_gcp())
											->setId_operation($count)
											->setCode_tegc($gcp->getCode_tegc())
											->setCode_membre($membre)
											->setMont_prelever($gcp->getReste())
											->setId_credit($gcp->getId_credit())
											->setSource_credit($gcp->getSource())
											->setMont_rapprocher($gcp->getReste())
											->setSolde_prelevement(0)
											->setRapprocher(1)
											->setDate_prelevement($date->toString('yyyy-MM-dd'))
											->setHeure_prelevement($date->toString('HH:mm:ss'));
									$gcp_preleve_mapper->save($gcp_preleve);

									$cnp = $cnp_mapper->findCnpByCreditSource($gcp->getId_credit(), $gcp->getSource());
									if ($cnp != NULL) {
										//Mise à jour du CNP
										$cnp->setMont_credit($cnp->getMont_credit() + $gcp->getReste())
												->setSolde_cnp($cnp->getSolde_cnp() - $gcp->getReste());
										$cnp_mapper->update($cnp);

										$ecnp = new Application_Model_EuCnpEntree();
										$ecnp->setId_cnp($cnp->getId_cnp())
												->setDate_entree($date->toString('yyyy-MM-dd'))
												->setMont_cnp_entree($gcp->getReste())
												->setType_cnp_entree('GCP');
										$tcnp->insert($ecnp->toArray());

										$cred_ech->setId_credit($cnp->getId_credit())
												->setId_echange($num_echange)
												->setMont_echange($gcp->getReste())
												->setSource_credit($gcp->getSource())
												->setAgio(0);
										$tcredit_ech->insert($cred_ech->toArray());

										//Décrémentation, annulation ou mise en attente dans la table de rapprochement
										$type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
										$rappro = $rappro_mapper->findRapproByCreditSource($gcp->getId_credit(), $gcp->getSource(), $type_rappro);
										if ($rappro != NULL) {
											$rappro->setCredit_rappro($rappro->getCredit_rappro() + $gcp->getReste());
											$rappro->setSolde_rappro($rappro->getDebit_rappro() - $rappro->getCredit_rappro());
											$rappro_mapper->update($rappro);
										} else {
											$rappro = new Application_Model_EuRapprochement();
											$rappro->setDebit_rappro(0)
													->setCredit_rappro($gcp->getReste())
													->setSolde_rappro($gcp->getReste())
													->setSource('CNP')
													->setSource_credit($gcp->getSource())
													->setCode_smcipn(NULL)
													->setId_credit($gcp->getId_credit())
													->setType_rappro($type_rappro);
											$rappro_mapper->save($rappro);
										}
									} else {
										$sessionmembre->errorlogin = 'Les CNP du credit N°' . $gcp->getId_credit() . " n'existent pas";
										return;
									}

									//Mise à jour du GCP
									$gcp->setMont_preleve($gcp->getMont_preleve() + $gcp->getReste());
									$gcp->setReste(0);
									$gcp_mapper->update($gcp);
									$j = $j + 1;
								} else {
									$gcp->setMont_preleve($gcp->getMont_preleve() + $montant);
									$gcp->setReste($gcp->getReste() - $montant);
									$gcp_mapper->update($gcp);

									$gcp_preleve = new Application_Model_EuGcpPrelever();
									$gcp_preleve->setId_gcp($gcp->getId_gcp())
											->setId_operation($count)
											->setCode_tegc($gcp->getCode_tegc())
											->setCode_membre($membre)
											->setMont_prelever($montant)
											->setId_credit($gcp->getId_credit())
											->setSource_credit($gcp->getSource())
											->setMont_rapprocher($montant)
											->setSolde_prelevement(0)
											->setRapprocher(1)
											->setDate_prelevement($date->toString('yyyy-MM-dd'))
											->setHeure_prelevement($date->toString('HH:mm:ss'));
									$gcp_preleve_mapper->save($gcp_preleve);

									$cnp = $cnp_mapper->findCnpByCreditSource($gcp->getId_credit(), $gcp->getSource());
									if ($cnp != NULL) {
										$cnp->setMont_credit($cnp->getMont_credit() + $montant)
												->setSolde_cnp($cnp->getSolde_cnp() - $montant);
										$cnp_mapper->update($cnp);
										$ecnp = new Application_Model_EuCnpEntree();
										$ecnp->setId_cnp($cnp->getId_cnp())
												->setDate_entree($date->toString('yyyy-MM-dd'))
												->setMont_cnp_entree($montant)
												->setType_cnp_entree('GCP');
										$tcnp->insert($ecnp->toArray());

										$cred_ech->setId_credit($cnp->getId_credit())
												->setId_echange($num_echange)
												->setMont_echange($montant)
												->setSource_credit($gcp->getSource())
												->setAgio(0);
										$tcredit_ech->insert($cred_ech->toArray());

										$type_rappro = Util_Utils::getTypeRappro($cnp->getOrigine_cnp());
										$rappro = $rappro_mapper->findRapproByCreditSource($gcp->getId_credit(), $gcp->getSource(), $type_rappro);
										if ($rappro == NULL) {
											$rappro = new Application_Model_EuRapprochement();
											$rappro->setDebit_rappro(0)
													->setCredit_rappro($montant)
													->setSolde_rappro($rappro->getCredit_rappro() - $rappro->getDebit_rappro())
													->setSource('CNP')
													->setSource_credit($gcp->getSource())
													->setCode_smcipn(NULL)
													->setId_credit($gcp->getId_credit())
													->setType_rappro($type_rappro);
											$rappro_mapper->save($rappro);
										} else {
											$rappro->setCredit_rappro($rappro->getCredit_rappro() + $montant);
											$rappro->setSolde_rappro($rappro->getCredit_rappro() - $rappro->getDebit_rappro());
											$rappro_mapper->update($rappro);
										}
									} else {
										$sessionmembre->errorlogin = 'Les CNP du credit N°' . $gcp->getId_credit() . " code source :" . $gcp->getSource() . " n'existent pas";
										return;
									}
									$montant = 0;
									$j = $j + 1;
								}
							}
						}

						$sessionmembre->errorlogin = "Echange bien effectué";
						return;
					} else {
						$message = 'Le montant du compte GCP: Reste= ' . $reste_gcp . ' est insufisant pour cet échange';
						$sessionmembre->errorlogin = $message;
						return;
					}
				} else {
					$message = "Le compte GCP de ce membre est null !!!";
					$sessionmembre->errorlogin = $message;
					return;
				}


			} else {
				$sessionmembre->errorlogin = "Les champs * sont obligatoires";
			}
			//$this->_redirect('/espacepersonnel/apa');
		} else {

			if ($ret_req == FALSE) {

				$sessionmembre->errorlogin = "Vous n'avez pas de Compte GCP";
				$this->_redirect('/espacepersonnel/compte');
			} else {

				$this->view->compte_solde = $compte->solde;
			}
		}
	}






	public function echangecncsAction() 
	{
		/* page espacepersonnel/echangecncs - Echange CNCS */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

			$m_compte = new Application_Model_EuCompteMapper();
			$compte = new Application_Model_EuCompte();
			$code_compte = 'NR-TCNCS-' . $sessionmembre->code_membre;
			$ret_req = $m_compte->find($code_compte, $compte);
				$this->view->compte_solde = $compte->solde;


		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['solde']) && $_POST['solde'] != "" && isset($_POST['membre_benef']) && $_POST['membre_benef'] != "" && $_POST['montant'] > 0) {

				$type = $sessionmembre->type;
				$desctype = $sessionmembre->desctype;



			$membre = $sessionmembre->code_membre;
			$categorie = "TCNCS";
			//$categorie = $_POST['categorie'];
			$cpte = $_POST['compte'];
			$montant = $_POST['montant'];
			//$type = $request->type;
			$membre_benef = $_POST['membre_benef'];
			$credit = $_POST['compte'];
			
			$echange = new Application_Model_EuEchange();
			$m_echange = new Application_Model_EuEchangeMapper();

				$compte = 'NR-' . $categorie . '-' . $membre;
				$cm_mapper = new Application_Model_EuCompteMapper();
				$cc_mapper = new Application_Model_EuCompteCreditMapper();
				$op_mapper = new Application_Model_EuOperationMapper();
				$cpte_origine = new Application_Model_EuCompte();
				$result = $cm_mapper->find($compte, $cpte_origine);
				if ($result) {
					$somme = 0;
					$credits = array();
					if ($cpte_origine->getSolde() >= $montant) {
						$credits = $cc_mapper->fetchByCompte($compte);
						if (count($credits) > 0) {
							foreach ($credits as $value) {
								$datefin = new Zend_Date($value->getDatefin(), Zend_Date::ISO_8601);
								if ($datefin->compare($date) <= 0) {
									$somme += $value->getMontant_credit();
								}
							}
							if ($somme > 0 && $somme >= $montant) {
								$pck = Util_Utils::getParametre('pck', 'nr');
								$prk = Util_Utils::getParametre('prk', 'nr');
								$mont_credit = $montant + ($montant * $prk / $pck);
								$newcompte = 'NB-TPAGCRPG-' . $membre_benef;
								//Enregistrement de l'opération
								$count = $op_mapper->findConuter() + 1;
								$op = new Application_Model_EuOperation();
								$op->setId_operation($count)
										->setDate_op($date->toString('yyyy-MM-dd'))
										->setHeure_op($date->toString('HH:mm:ss'))
										->setId_utilisateur(NULL);//$user->id_utilisateur
							if (substr($membre, -1) == "P") {
								$op->setCode_membre($membre);
								$op->setCode_membre_morale(NULL);
							} else if (substr($membre, -1) == "M") {
								$op->setCode_membre(NULL);
								$op->setCode_membre_morale($membre);
							}
										$op->setMontant_op($montant)
										->setCode_produit($cpte)
										->setLib_op('Echange du CNCS')
										->setType_op('EE')
										->setCode_cat($categorie);
								$op_mapper->save($op);

								$ccompte = new Application_Model_EuCompte();
								$result = $cm_mapper->find($newcompte, $ccompte);
								if ($result == FALSE) {
									$ccompte->setSolde($mont_credit);
							if (substr($membre_benef, -1) == "P") {
								$ccompte->setCode_membre($membre_benef);
								$ccompte->setCode_membre_morale(NULL);
							} else if (substr($membre_benef, -1) == "M") {
								$ccompte->setCode_membre(NULL);
								$ccompte->setCode_membre_morale($membre_benef);
							}
									$ccompte->setDate_alloc($date->toString('yyyy-MM-dd'))
											->setCode_compte($newcompte)
											->setLib_compte($credit)
											->setCode_cat('TPAGCRPG')
											->setCode_type_compte('NB')
											->setDesactiver(0);
									$cm_mapper->save($ccompte);
								} else {
									$ccompte->setSolde($ccompte->getSolde() + $mont_credit);
									$cm_mapper->update($ccompte);
								}

								$cpte_credit = new Application_Model_EuCompteCredit();
								$maxcc = $cc_mapper->findConuter() + 1;
								$source = $membre . $date->toString('yyyyMMddHHmmss');
								$cpte_credit->setId_credit($maxcc)
										->setCode_membre($membre_benef)
										->setCode_produit('RPGnr')
										->setMontant_place($montant)
										->setDatedeb($date->toString('yyyy-MM-dd'))
										->setDatefin($date->toString('yyyy-MM-dd'))
										->setDate_octroi($date->toString('yyyy-MM-dd'))
										->setSource($source)
										->setCode_compte($newcompte)
										->setId_operation($count)
										->setBnp(0)
										->setCode_type_credit('CNPG')
										->setPrk($prk)
										->setCompte_source($compte)
										->setMontant_credit($mont_credit)
										->setRenouveller('N')
										->setDomicilier(0)
										->setKrr('N')
										->setAffecter(0);
								$cc_mapper->save($cpte_credit);

								$countechange = $m_echange->findConuter() + 1;
								$echange->setId_echange($countechange)
										->setCode_membre($membre)
										->setCode_compte_ech($compte)
										->setMontant($mont_credit)
										->setDate_echange($date->toString('yyyy-MM-dd'))
										->setId_utilisateur(NULL)//$user->id_utilisateur
										->setType_echange('NR/NB')
										->setCat_echange('CNCS')
										->setAgio(0)
										->setCompenser(0)
										->setCode_produit($cpte)
										->setId_credit($maxcc)
										->setMontant_echange($montant)
										->setCode_compte_obt($newcompte);
								$m_echange->save($echange);
								//$num_echange = $db->lastInsertId();

								$cnp = new Application_Model_EuCnp();
								$m_cnp = new Application_Model_EuCnpMapper();
							$compt_cnp = $m_cnp->findConuter() + 1;
							$cnp->setId_cnp($compt_cnp)
										->setId_credit($maxcc)
										->setDate_cnp($date->toString('yyyy-MM-dd'))
										->setMont_debit($montant)
										->setMont_credit(0)
										->setSolde_cnp($mont_credit)
										->setType_cnp($credit)
										->setSource_credit($source)
										->setCode_capa(NULL)
										->setTransfert_gcp(0);
								if ($cpte == 'CNCSr') {
									$cnp->setOrigine_cnp('ECNCSr');
								} else {
									$cnp->setOrigine_cnp('ECNCSnr');
								}
								$m_cnp->save($cnp);

								$cpte_origine->setSolde($cpte_origine->getSolde() - $montant);
								$cm_mapper->update($cpte_origine);

								//mise de la table de rapprochement 
								$i = 0;
								$tcredit_ech = new Application_Model_DbTable_EuCreditEchange();
								$cred_ech = new Application_Model_EuCreditEchange();
								$reste = $montant;
								while ($reste > 0 && $i < count($credits)) {
									$cred = $credits[$i];
									$mont_deduit = 0;
									if ($reste > $cred->getMontant_credit()) {
										$mont_deduit = $cred->getMontant_credit();
										$reste = $reste - $mont_deduit;
										$cred->setMontant_credit(0);
										$cc_mapper->update($cred);
									} else {
										$mont_deduit = $reste;
										$reste = 0;
										$cred->setMontant_credit($cred->getMontant_credit() - $mont_deduit);
										$cc_mapper->update($cred);
									}

									$cred_ech->setId_credit($cred->getId_credit())
											->setId_echange($num_echange)
											->setMont_echange($mont_deduit)
											->setSource_credit($cred->getSource())
											->setAgio(0);
									$tcredit_ech->insert($cred_ech->toArray());

									$m_smc = new Application_Model_EuSmcMapper();
									$smc = new Application_Model_EuSmc();
									if ($cred->getCode_produit() === 'CNCSr') {
										$tservir = new Application_Model_DbTable_EuUtiliser();
										$tselect = $tservir->select();
										$tselect->where('code_smcipn = ?', $cred->getCompte_Source());
										$tselect->order('montant_allouer', 'DESC');
										$resultSets = $tservir->fetchAll($tselect);
										if (count($resultSets) > 0) {
											$j = 0;
											while ($mont_deduit > 0 && $j < count($resultSets)) {
												$servir = $resultSets[$j];
												$ret = $m_smc->find($servir->id_smc, $smc);
												if ($ret) {
													if ($smc->getSortie() >= $mont_deduit) {
														$smc->setEntree($smc->getEntree() + $mont_deduit)
																->setSolde($smc->getSolde() - $mont_deduit);
														$mont_deduit = 0;
														$m_smc->update($smc);
													} else {
														$smc->setEntree($smc->getEntree() + $smc->getSortie())
																->setSolde($smc->getSolde() - $smc->getSortie());
														$mont_deduit = $mont_deduit - $smc->getSortie();
														$m_smc->update($smc);
														$j++;
													}
												} else {
													$sessionmembre->errorlogin = 'Les smc sont inexistants ';
													return;
												}
											}
										} else {
											$sessionmembre->errorlogin = "Ce Salaire n'est pas issu d'une subvention";
											return;
										}
									} else {
										$tsal = new Application_Model_DbTable_EuSalaireAffecter();
										$tselect = $tsal->select();
										$tselect->where('id_credit = ?', $cred->getId_credit());
										$rowSet = $tsal->fetchAll($tselect);
										if (count($rowSet) > 0) {
											$j = 0;
											while ($mont_deduit > 0 && $j < count($rowSet)) {
												$servir = $rowSet[$j];
												$ret = $m_smc->find($servir->id_smc, $smc);
												if ($ret) {
													if ($smc->getSortie() >= $mont_deduit) {
														$smc->setEntree($smc->getEntree() + $mont_deduit)
																->setSolde($smc->getSolde() - $mont_deduit);
														$m_smc->update($smc);
														$mont_deduit = 0;
													} else {
														$smc->setEntree($smc->getEntree() + $smc->getSortie())
																->setSolde($smc->getSolde() - $smc->getSortie());
														$mont_deduit = $mont_deduit - $smc->getSortie();
														$m_smc->update($smc);
														$j++;
													}
												} else {
													$sessionmembre->errorlogin = 'Les smc sont inexistants.';
													return;
												}
											}
										} else {
											$sessionmembre->errorlogin = "Cet Salaire n'est pas issu d'une affectation.";
											return;
										}
									}
									$i = $i + 1;
								}
								$sessionmembre->errorlogin = "Echange bien effectué";
								return;
							} else {
								$sessionmembre->errorlogin = "La somme des credits est insuffisant pour effectuer cet operation!!!";
								return;
							}
						} else {
							$sessionmembre->errorlogin = "Les comptes crédits correspondant à ce compte sont introuvables!!!";
							return;
						}
					} else {
						$sessionmembre->errorlogin = "Le solde de votre compte est insuffisant pour effectuer cette operation!!!";
						return;
					}
				} else {
					$sessionmembre->errorlogin = "Ce membre ne dispose pas de compte salaire ou ce compte est null !!!";
					return;
				}




			} else {
				$sessionmembre->errorlogin = "Les champs * sont obligatoires";
			}
			//$this->_redirect('/espacepersonnel/apa');
		} else {

			if ($ret_req == FALSE) {

				$sessionmembre->errorlogin = "Vous n'avez pas de Compte CNCS";
				$this->_redirect('/espacepersonnel/compte');
			} else {

				$this->view->compte_solde = $compte->solde;
			}
		}
	}





	public function mflAction() 
	{
		/* page espacepersonnel/mfl - Achat des MF107, MF11000 et MFL */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
		
		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
		$sms_mapper = new Application_Model_EuSmsmoneyMapper();
		$sms = $sms_mapper->findByCreditCode($_POST['creditcode']);
		if (isset($_POST['mont_credit']) && $_POST['mont_credit'] == $sms->getCreditAmount() && isset($_POST['code_type_mf']) && $_POST['code_type_mf'] != "") {
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->beginTransaction();
		try {
			$type = $sessionmembre->type;
			$desctype = $sessionmembre->desctype;

			$code_membre = $sessionmembre->code_membre;
			$type_capa = $_POST['code_type_mf'];
			$code_sms = $_POST['creditcode'];
			$mont_capa = $_POST['mont_credit'];
			$dev_capa = "XOF";
			$credi = 0;
			$date_fin = new Zend_Date(Zend_Date::ISO_8601);
			$date_deb = clone $date_fin;

			$m_membre = new Application_Model_EuMembreMapper();
			$membre = new Application_Model_EuMembre();
			$m_membrem = new Application_Model_EuMembreMoraleMapper();
			$membrem = new Application_Model_EuMembreMorale();
			if (substr($code_membre, -1) == "P") {
				$retour = $m_membre->find($code_membre,$membre);
			} else {
				$retour = $m_membrem->find($code_membre,$membrem);
			}
			
			//Mise à jour des comptes credits
			$cc_mapper = new Application_Model_EuCompteCreditMapper();
			$source = $code_membre . $date_deb->toString('yyyyMMddHHmmss');
			$max_code = $cc_mapper->findConuter() + 1;
			$periode = Util_Utils::getParametre('periode','valeur');
			$date_fin->addDay($periode);
			$compte_source = '';
			if (!$retour) {
				//$db->rollBack();
				$sessionmembre->errorlogin = " Ce membre n'existe pas: " .$code_membre;
				return;
			} else  {
				$cm_mapper = new Application_Model_EuCompteMapper();
				$sms_mapper = new Application_Model_EuSmsmoneyMapper();
				$sms = $sms_mapper->findByCreditCode($code_sms); 
				if ($sms != NULL && $sms->getIDDateTimeConsumed() == 0) {
					$montant = $sms->getCreditAmount();
					if ($dev_capa != 'XOF') {
						$code_cours = $dev_capa . '-XOF';
						$cours = new Application_Model_EuCours();
						$m_cours = new Application_Model_EuCoursMapper();
						$ret = $m_cours->find($code_cours, $cours);
						if ($ret) {
								if ($montant != '') {
									   $montant = $montant * $cours->getVal_dev_fin();
								}
							}
						}
				}
				
				// Contrôle sur les type de capa
				if($sms->getMotif() != $type_capa) {
					//$db->rollBack();
					$sessionmembre->errorlogin = " Le motif de ce type de capa n'est pas correspondant pour ce type d'operation";
					return;    
				}
				// Contrôle sur le montant
				$multiple = $montant/70000;
				if(is_int($multiple) == FALSE) {
					//$db->rollBack();
					$sessionmembre->errorlogin = " Le montant du CAPA MF n'est pas un multiple de 70000 ";
					return;
				}
				if($type_capa == 'MF107')  {
					try {
						$code_cat = 'TMF107';
						$lib_op   = 'Achat de MF107';
						$code_compte= 'NN-TMF107-'.$code_membre;
						$code_comptets= 'NN-TSMF107-'.$code_membre;
						$emf = Util_Utils::getParametre('EMF107','valeur');
						//Paramètre de renouvellement
						$mf = Util_Utils::getParametre($type_capa,'valeur');
						$quotamf = Util_Utils::getParametre('quotaMF','valeur');
						$umf = Util_Utils::findquotamf($code_membre,$type_capa);
						$umfp = Util_Utils::findquotabypaysmf($sessionmembre->pays,$type_capa);
						if($umf > $quotamf*70000) {
								//$db->rollBack();
								$sessionmembre->errorlogin = "Le quota maximal d'unite  ".$type_capa."  est deja atteint pour le membre :  ".$code_membre;
								return;    
						} elseif(($mont_capa + $umf) > $quotamf*70000) {
								//$db->rollBack();
								$sessionmembre->errorlogin = "Le quota maximal d'unite  ".$type_capa."  est doit etre respecté !!!";
								return;
						}	
						$compte_source = 'CAPAMF107';
						$mapper = new Application_Model_EuOperationMapper();
						$compteur = $mapper->findConuter() + 1;
						
						if (substr($code_membre, -1) == "P") {
						   Util_Utils::addOperation($compteur,$code_membre,null,$code_cat,$montant,$type_capa,$lib_op,'APA',$date_deb->toString('yyyy-MM-dd'),$date_deb->toString('HH:mm:ss'),NULL);//$user->id_utilisateur
						} else {
						   Util_Utils::addOperation($compteur,null,$code_membre,$code_cat,$montant,$type_capa,$lib_op,'APA',$date_deb->toString('yyyy-MM-dd'),$date_deb->toString('HH:mm:ss'),NULL);//$user->id_utilisateur
						}
						$compte = new Application_Model_EuCompte();
						$result = $cm_mapper->find($code_compte, $compte);
						if ($result == FALSE) {
							$type_compte = 'NN';
							if (substr($code_membre, -1) == "P") {
							   Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,$code_membre,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,null);
							   Util_Utils::createCompte($code_comptets,$type_capa,$code_catts,0,$code_membre,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,null);                     
							} else {
							   Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,null,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
							   Util_Utils::createCompte($code_comptets,$type_capa,$code_catts,0,null,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,$code_membre);                     
							}
						} else {
						   $compte->setSolde($compte->getSolde() + $credi);
						   $cm_mapper->update($compte);
						}
						Util_Utils::createCompteCredit($max_code,1,$compteur,$code_membre,$type_capa,$code_compte,$credi,$montant,$date_deb,$date_fin,$source,$compte_source,'N','O',0,0,null,NULL);	
					   
						// Mise à jour des CAPA
						$m_capa = new Application_Model_EuCapaMapper();
						$capa = new Application_Model_EuCapa();
						$code_capa = 'CAPA' . $type_capa . $date_deb->toString('yyyyMMddHHmmss');
						$capa->setCode_capa($code_capa)
								->setCode_compte($code_compte)
								->setDate_capa($date_deb->toString('yyyy-MM-dd'))
								->setHeure_capa($date_deb->toString('HH:mm:ss'))
								->setCode_membre($code_membre)
								->setMontant_capa($montant)
								->setType_capa('MF')
								->setCode_produit($type_capa)
								->setId_operation($compteur)
								->setEtat_capa('Actif')
								->setOrigine_capa('SMS')
								->setMontant_utiliser($montant)
								->setMontant_solde(0);
							$m_capa->save($capa);

							$m_capa_affect = new Application_Model_EuCapaAffecterMapper();
							$capa_affect   = new Application_Model_EuCapaAffecter();
							$compteur      = $m_capa_affect->findConuter() + 1;
							$capa_affect->setId_affecter($compteur)
										->setCode_capa($code_capa)
										->setDuree_renouvellement($mf)
										->setReste_duree($mf)
										->setMont_invest($montant*$mf)
										->setId_credit($max_code)
										->setType_credit($type_capa);
							$m_capa_affect->save($capa_affect);
							if ($sms) {
								$sms->setDestAccount_Consumed($code_compte)
									->setDateTimeconsumed($date_deb->toString('dd/MM/yyyy HH:mm:ss'))
									->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/MM/yyyy')));
								$sms_mapper->update($sms); 					   
							}
							} catch (Exception $exc) {
									//$db->rollback();
									$data = 'Erreur d\'execution : ' . $exc->getMessage();
									$sessionmembre->errorlogin = $data;
									return;
							}
						 
					  } else {
							   $umfp = Util_Utils::findquotabypaysmf($sessionmembre->pays,'MF107');
							   $emf = Util_Utils::getParametre('EMF107','valeur'); 
							   //if($umfp >= $emf*70000) {
							   if($type_capa == 'MF11000') {
									try {
										$code_cat = 'TMF11000';
										$code_compte= 'NN-TMF11000-'.$code_membre;
										$code_comptets= 'NN-TSMF11000-'.$code_membre;
										$lib_op   = 'Achat de MF11000';
										$emf = Util_Utils::getParametre('EMF11000','valeur');									
										//Paramètre de renouvellement
										$mf = Util_Utils::getParametre($type_capa,'valeur');
										$quotamf = Util_Utils::getParametre('quotaMF','valeur');
										$umf = Util_Utils::findquotamf($code_membre,$type_capa);
										$umfp = Util_Utils::findquotabypaysmf($sessionmembre->pays,$type_capa);
										if($umf > $quotamf*70000) {
											//$db->rollBack();
											$sessionmembre->errorlogin = "Le quota maximal d'unite  ".$type_capa."  est deja atteint pour le membre :  ".$code_membre;
											
											return;    
										} elseif(($mont_capa + $umf) > $quotamf*70000) {
											 //$db->rollBack();
											 $sessionmembre->errorlogin = "Le quota maximal d'unite  ".$type_capa."  est doit etre respecté !!!";
											 
											 return;
										}
										$compte_source = 'CAPAMF11000';
										$mapper = new Application_Model_EuOperationMapper();
										$compteur = $mapper->findConuter() + 1;
										if (substr($code_membre, -1) == "P") {
										   Util_Utils::addOperation($compteur,$code_membre,null,$code_cat,$montant,$type_capa,$lib_op,'APA',$date_deb->toString('yyyy-MM-dd'),$date_deb->toString('HH:mm:ss'),NULL);//$user->id_utilisateur
										} else {
										   Util_Utils::addOperation($compteur,null,$code_membre,$code_cat,$montant,$type_capa,$lib_op,'APA',$date_deb->toString('yyyy-MM-dd'),$date_deb->toString('HH:mm:ss'),NULL);//$user->id_utilisateur
										
										}
										$compte = new Application_Model_EuCompte();
										$result = $cm_mapper->find($code_compte, $compte);
										if ($result == FALSE) {
											$type_compte = 'NN';
											if (substr($code_membre, -1) == "P") {
												 Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,$code_membre,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,null);
												 Util_Utils::createCompte($code_comptets,$type_capa,$code_catts,0,$code_membre,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,null);
												 
											} else {
											  Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,null,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
											  Util_Utils::createCompte($code_comptets,$type_capa,$code_catts,0,null,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
												 
											}
										} else {
											 $compte->setSolde($compte->getSolde() + $credi);
											 $cm_mapper->update($compte);
										}
										Util_Utils::createCompteCredit($max_code,1,$compteur,$code_membre,$type_capa,$code_compte,$credi,$montant,$date_deb,$date_fin,$source,$compte_source,'N','O',0,0,null,NULL);	
					   
									  // Mise à jour des CAPA
									  $m_capa = new Application_Model_EuCapaMapper();
									  $capa = new Application_Model_EuCapa();
									  $code_capa = 'CAPA' . $type_capa . $date_deb->toString('yyyyMMddHHmmss');
									  $capa->setCode_capa($code_capa)
										   ->setCode_compte($code_compte)
										   ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
										   ->setHeure_capa($date_deb->toString('HH:mm:ss'))
										   ->setCode_membre($code_membre)
										   ->setMontant_capa($montant)
										   ->setType_capa('MF')
										   ->setCode_produit($type_capa)
										   ->setId_operation($compteur)
										   ->setEtat_capa('Actif')
										   ->setOrigine_capa('SMS')
										   ->setMontant_utiliser($montant)
										   ->setMontant_solde(0);
									   $m_capa->save($capa);

									   $m_capa_affect = new Application_Model_EuCapaAffecterMapper();
									   $capa_affect   = new Application_Model_EuCapaAffecter();
									   $compteur      = $m_capa_affect->findConuter() + 1;
									   $capa_affect->setId_affecter($compteur)
												   ->setCode_capa($code_capa)
												   ->setDuree_renouvellement($mf)
												   ->setReste_duree($mf)
												   ->setMont_invest($montant*$mf)
												   ->setId_credit($max_code)
												   ->setType_credit($type_capa);
									   $m_capa_affect->save($capa_affect);
									   if ($sms) {
										   $sms->setDestAccount_Consumed($code_compte)
											   ->setDateTimeconsumed($date_deb->toString('dd/MM/yyyy HH:mm:ss'))
											   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/MM/yyyy')));
										   $sms_mapper->update($sms); 					   
										}
										} catch (Exception $exc) {
												//$db->rollback();
												$data = 'Erreur d\'execution : ' . $exc->getMessage();
												$sessionmembre->errorlogin = $data;
												return;
										}
										
									} else {
										  $umfp = Util_Utils::findquotabypaysmf($sessionmembre->pays,'TMF11000');
										  $emf = Util_Utils::getParametre('EMF11000','valeur');
										  //if($umfp >= $emf*70000) {
											try {
											$code_cat = 'TMFL';
											$lib_op   = 'Achat de MFL';
											$code_compte= 'NN-TMFL-'.$code_membre;
											$code_comptets= 'NN-TSMFL-'.$code_membre;
											//Paramètre de renouvellement
											$mf = Util_Utils::getParametre($type_capa,'valeur');
											$quotamf = Util_Utils::getParametre('quotaMF','valeur'); 
											$umf = Util_Utils::findquotamf($code_membre,$type_capa);											
											if($umf > $quotamf*70000) {
											   //$db->rollBack();
											   $sessionmembre->errorlogin = "Le quota maximal d'unite  ".$type_capa."  est deja atteint pour le membre :  ".$code_membre;
											   
											   return;    
											} elseif(($mont_capa + $umf) > $quotamf*70000) {
											   //$db->rollBack();
											   $sessionmembre->errorlogin = "Le quota maximal d'unite  ".$type_capa."  est doit etre respecté !!!";
											   
											   return;
											}
											 $compte_source = 'CAPAMFL';
											 $mapper = new Application_Model_EuOperationMapper();
											 $compteur = $mapper->findConuter() + 1;
											 if (substr($code_membre, -1) == "P") {
											   Util_Utils::addOperation($compteur,$code_membre,null,$code_cat,$montant,$type_capa,$lib_op,'APA',$date_deb->toString('yyyy-MM-dd'),$date_deb->toString('HH:mm:ss'),$sessionmembre->pays);//$user->id_utilisateur
											 } else {
											   Util_Utils::addOperation($compteur,null,$code_membre,$code_cat,$montant,$type_capa,$lib_op,'APA',$date_deb->toString('yyyy-MM-dd'),$date_deb->toString('HH:mm:ss'),$sessionmembre->pays);//$user->id_utilisateur
											 }
											 $compte = new Application_Model_EuCompte();
											 $result = $cm_mapper->find($code_compte, $compte);
											 if ($result == FALSE) {
												$type_compte = 'NN';
												if (substr($code_membre, -1) == "P") {
												   Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,$code_membre,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,null);
												   Util_Utils::createCompte($code_comptets,$type_capa,$code_catts,0,$code_membre,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,null);
												 
												} else {
												   Util_Utils::createCompte($code_compte,$type_capa,$code_cat,$credi,null,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
												   Util_Utils::createCompte($code_comptets,$type_capa,$code_catts,0,null,$type_compte,$date_deb->toString('yyyy-MM-dd'),0,$code_membre);
												 
												}
											 } else {
												$compte->setSolde($compte->getSolde() + $credi);
												$cm_mapper->update($compte);
											 }
											 Util_Utils::createCompteCredit($max_code,1,$compteur,$code_membre,$type_capa,$code_compte,$credi,$montant,$date_deb,$date_fin,$source,$compte_source,'N','O',0,0,null,NULL);	
					   
										   // Mise à jour des CAPA
							$m_capa = new Application_Model_EuCapaMapper();
							$capa = new Application_Model_EuCapa();
							$code_capa = 'CAPA' . $type_capa . $date_deb->toString('yyyyMMddHHmmss');
							$capa->setCode_capa($code_capa)
								 ->setCode_compte($code_compte)
								 ->setDate_capa($date_deb->toString('yyyy-MM-dd'))
								 ->setHeure_capa($date_deb->toString('HH:mm:ss'))
								 ->setCode_membre($code_membre)
								 ->setMontant_capa($montant)
								 ->setType_capa('MF')
								 ->setCode_produit($type_capa)
								 ->setId_operation($compteur)
								 ->setEtat_capa('Actif')
								 ->setOrigine_capa('SMS')
								 ->setMontant_utiliser($montant)
								 ->setMontant_solde(0);
							$m_capa->save($capa);

							$m_capa_affect = new Application_Model_EuCapaAffecterMapper();
							$capa_affect   = new Application_Model_EuCapaAffecter();
							$compteur      = $m_capa_affect->findConuter() + 1;
							$capa_affect->setId_affecter($compteur)
										->setCode_capa($code_capa)
										->setDuree_renouvellement($mf)
										->setReste_duree($mf)
										->setMont_invest($montant*$mf)
										->setId_credit($max_code)
										->setType_credit($type_capa);
							$m_capa_affect->save($capa_affect);
						
							if ($sms) {
								$sms->setDestAccount_Consumed($code_compte)
									->setDateTimeconsumed($date_deb->toString('dd/MM/yyyy HH:mm:ss'))
									->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/MM/yyyy')));
								$sms_mapper->update($sms);       
							}											 
							} catch (Exception $exc) {
									//$db->rollback();
									$data = 'Erreur d\'execution : ' . $exc->getMessage();
									$sessionmembre->errorlogin = $data;
									$this->view->code_membre = $code_membre;
									$this->view->type_capa = $type_capa;
									//$this->view->mont_capa = $mont_capa;
									$this->view->mont_capa = $umf;
									$this->view->dev_capa = $dev_capa;
									return;
							}			  
										  
										  
						//}
						//else {
							//$db->rollBack();
							//$sessionmembre->errorlogin = "Le quota maximal d'unité MF11000 n'a pas encore atteint pour le pays ";
							//$this->view->code_membre = $code_membre;
							//$this->view->type_capa = $type_capa;
							//$this->view->mont_capa = $mont_capa;
							//$this->view->dev_capa = $dev_capa;
							//return;
						//}
										  
									
									}
							 
							//} else {
								   //$db->rollBack();
								   //$sessionmembre->errorlogin = "Le quota maximal d'unité MF107 n'a pas encore atteint pour le pays ";
								   //$this->view->code_membre = $code_membre;
								   //$this->view->type_capa = $type_capa;
								   //$this->view->mont_capa = $mont_capa;
								   //$this->view->dev_capa = $dev_capa;
								   //return;
							//}

					  }
					  $comp = Util_Utils::findConuter() + 1;
					  if (substr($code_membre, -1) == "P") {
						  Util_Utils::addSms($comp,$membre->getPortable_membre(),"Vous venez de placer " . $montant . " " . $dev_capa . " sur le compte " . $code_compte . ". Solde final: " . $compte->getSolde());
					  } else {
						  Util_Utils::addSms($comp,$membrem->getPortable_membre(),"Vous venez de placer " . $montant . " " . $dev_capa . " sur le compte " . $code_compte . ". Solde final: " . $compte->getSolde());
					  }
					  $db->commit();
					  //$sessionmembre->errorlogin = true;
					  //return;
					  
				$sessionmembre->errorlogin = "Opération CAPA effectuée avec succès !!!";
				$this->_redirect('/espacepersonnel/compte');
					  //$sessionmembre->errorlogin = true;
					  //return;
					}
										  
 
		} catch (Exception $exc) {
			//$db->rollback();
			$sessionmembre->errorlogin = 'Erreur de traitement  ' . $exc->getMessage() . $exc->getTraceAsString();
			return;
		}

			} else {
				$sessionmembre->errorlogin = "Les champs * sont obligatoires";
			}
			//$this->_redirect('/espacepersonnel/apa');
		} 
	}



	public function addoffredemandeAction() 
	{
		/* page espacepersonnel/addoffredemande - Ajout offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['type_offre_demande']) && $_POST['type_offre_demande'] != "" && isset($_POST['code_membre']) && $_POST['code_membre'] != "" && isset($_POST['code_compte']) && $_POST['code_compte'] != "") {
if(isset($_POST['id_credit']) && $_POST['id_credit'] != ""){$id_credit = $_POST['id_credit'];}else{$id_credit = NULL;}
				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$offre_demande = new Application_Model_EuOffreDemande();
				$m_offre_demande = new Application_Model_EuOffreDemandeMapper();

					$compt_offre_demande = $m_offre_demande->findConuter() + 1;

					$offre_demande->setId_offre_demande($compt_offre_demande);
					$offre_demande->setType_offre_demande($_POST['type_offre_demande']);
					$offre_demande->setCode_membre($_POST['code_membre']);
					$offre_demande->setCode_compte($_POST['code_compte']);
					$offre_demande->setId_credit($id_credit);
					$offre_demande->setCode_cat(NULL);
					//$offre_demande->setNum_offre_demande($compt_offre_demande);
					if($_POST['type_offre_demande'] == "Offre"){
					$offre_demande->setType_credit_of($_POST['type_credit_of1']);
					$offre_demande->setType_credit_de($_POST['type_credit_de1']);
					}else{
					$offre_demande->setType_credit_of($_POST['type_credit_of2']);
					$offre_demande->setType_credit_de($_POST['type_credit_de2']);
					}
					$offre_demande->setDate_offre_demande($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$m_offre_demande->save($offre_demande);/**/

					$this->_redirect('/espacepersonnel/listoffredemande');
			} else {
				$this->view->error = "Champs * obligatoire";
			}
		}
	}

	public function listoffredemandeAction() 
	{
		/* page espacepersonnel/listoffredemande - Liste des offres et des demandes */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$offre_demande = new Application_Model_EuOffreDemandeMapper();
		$this->view->entries = $offre_demande->fetchAllByMembre($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}

	public function offredemandeAction() 
	{
		/* page espacepersonnel/offredemande - Offres et demandes publiées */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$offre_demande = new Application_Model_EuOffreDemandeMapper();
		$this->view->entries = $offre_demande->fetchAllByNoMembre($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}

	public function suppoffredemandeAction() 
	{
		/* page espacepersonnel/suppoffredemande - Suppression offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

		$a = new Application_Model_EuOffreDemande();
		$ma = new Application_Model_EuOffreDemandeMapper();
		$ma->find($id, $a);
$m_offre_demande_message = new Application_Model_EuOffreDemandeMessageMapper();
$m_offre_demande_cloture = new Application_Model_EuOffreDemandeClotureMapper();

if($a->type_offre_demande == "Offre"){
$rowsoffremessage = $m_offre_demande_message->fetchAllByOffre2($a->id_offre_demande);
		foreach ($rowsoffremessage as $row) {
					$m_offre_demande_message->delete($row->id_message);
			}
	}else{
$rowsdemandemessage = $m_offre_demande_message->fetchAllByDemande2($a->id_offre_demande);
		foreach ($rowsdemandemessage as $row) {
					$m_offre_demande_message->delete($row->id_message);
			}
		}
		
		
if($a->type_offre_demande == "Offre"){
$rowsoffrecloture = $m_offre_demande_cloture->fetchAllByOffre2($a->id_offre_demande);
		foreach ($rowsoffrecloture as $row) {
					$m_offre_demande_cloture->delete($row->id_cloture);
			}
	}else{
$rowsdemandecloture = $m_offre_demande_cloture->fetchAllByDemande2($a->id_offre_demande);
		foreach ($rowsdemandecloture as $row) {
					$m_offre_demande_cloture->delete($row->id_cloture);
			}
		}
			





			$offre_demande_M = new Application_Model_EuOffreDemandeMapper();
			$offre_demande_M->delete($a->id_offre_demande);
		}

		$this->_redirect('/espacepersonnel/listoffredemande');
	}



	public function addoffredemandemessageAction() 
	{
		/* page espacepersonnel/addoffredemandemessage - Ajout message offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['id_offre']) && $_POST['id_offre'] != "" && isset($_POST['id_demande']) && $_POST['id_demande'] != "" && isset($_POST['message']) && $_POST['message'] != "") {

				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$offre_demande_message = new Application_Model_EuOffreDemandeMessage();
				$m_offre_demande_message = new Application_Model_EuOffreDemandeMessageMapper();

					$compt_offre_demande_message = $m_offre_demande_message->findConuter() + 1;

					$offre_demande_message->setId_message($compt_offre_demande_message);
					$offre_demande_message->setId_offre($_POST['id_offre']);
					$offre_demande_message->setId_demande($_POST['id_demande']);
					$offre_demande_message->setMessage($_POST['message']);
					$offre_demande_message->setDate_message($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$offre_demande_message->setType_message($_POST['type_message']);
					$offre_demande_message->setCode_membre($sessionmembre->code_membre);
					$m_offre_demande_message->save($offre_demande_message);

					$this->_redirect('/espacepersonnel/offredemande');
			} else {
				$this->view->error = "Champs * obligatoire";	

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
		$a = new Application_Model_EuOffreDemande();
		$ma = new Application_Model_EuOffreDemandeMapper();
		$ma->find($id, $a);
		$this->view->offredemande = $a;
			}
	}
		   
	} else {

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
		$a = new Application_Model_EuOffreDemande();
		$ma = new Application_Model_EuOffreDemandeMapper();
		$ma->find($id, $a);
		$this->view->offredemande = $a;
			}
	}
	}
	
	

	public function listoffredemandemessageAction() 
	{
		/* page espacepersonnel/listoffredemandemessage - Liste des messages offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
			$id = (int)$this->_request->getParam('id');
			$offre = (int)$this->_request->getParam('offre');
			$demande = (int)$this->_request->getParam('demande');
			$type = (string)$this->_request->getParam('type');
if ($offre > 0 && $demande > 0) {
		$offre_demande_message = new Application_Model_EuOffreDemandeMessageMapper();
		$this->view->entries = $offre_demande_message->fetchAllByOffreDemande($offre, $demande);
}
		$this->view->offre = $offre;
		$this->view->demande = $demande;
		$this->view->type = $type;
		$this->view->id = $id;
		
		$a = new Application_Model_EuOffreDemande();
		$ma = new Application_Model_EuOffreDemandeMapper();
		$ma->find($id, $a);
		$this->view->offredemande = $a;
		
		$this->view->tabletri = 1;
	}

	
	public function clotureoffredemandeAction() 
	{
		/* page espacepersonnel/clotureoffredemande - Cloture offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

			$id = (int)$this->_request->getParam('id');
			$offre = (int)$this->_request->getParam('offre');
			$demande = (int)$this->_request->getParam('demande');
			$type = (string)$this->_request->getParam('type');

		if (isset($_POST['ok1']) && $_POST['ok1'] == "ok1") {
		$this->view->offre = $offre;
		$this->view->demande = $demande;
		$this->view->type = $type;
		$this->view->id = $id;
			
$offredemandeM = new Application_Model_EuOffreDemandeMapper();
$offredemande = new Application_Model_EuOffreDemande();
$rowsoffre = $offredemandeM->fetchAllByMembreOffreDemande($sessionmembre->code_membre, $offre);
$rowsdemande = $offredemandeM->fetchAllByMembreOffreDemande($sessionmembre->code_membre, $demande);
if($rowsoffre == NULL){
	$type = "Demande";
}else{
	$type = "Offre";
}

			
			
if($type == "Offre"){
				
			if (isset($_POST['code_membre_offre']) && $_POST['code_membre_offre'] != "" && isset($_POST['code_compte_offre']) && $_POST['code_compte_offre'] != "" && isset($_POST['montant_offre']) && is_numeric($_POST['montant_offre']) && isset($_POST['montant_offre_2']) && is_numeric($_POST['montant_offre_2']) && $_POST['montant_offre_2'] >= $_POST['montant_offre']) {
				if(isset($_POST['id_credit_offre']) && $_POST['id_credit_offre'] != "" ){$id_credit_offre = $_POST['id_credit_offre'];}else{$id_credit_offre = NULL;}
$offredemandecloture_m = new Application_Model_EuOffreDemandeClotureMapper();
$offredemandecloture = new Application_Model_EuOffreDemandeCloture();
$rowsoffredemandecloture = $offredemandecloture_m->fetchAllByDemande($_POST['id_demande'], $offredemandecloture);
if(!$offredemandecloture->id_offre){
				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$offre_demande_cloture = new Application_Model_EuOffreDemandeCloture();
				$m_offre_demande_cloture = new Application_Model_EuOffreDemandeClotureMapper();

					$compt_offre_demande_cloture = $m_offre_demande_cloture->findConuter() + 1;

					$offre_demande_cloture->setId_cloture($compt_offre_demande_cloture);
					$offre_demande_cloture->setId_offre($_POST['id_offre']);
					$offre_demande_cloture->setId_demande($_POST['id_demande']);
					$offre_demande_cloture->setCloture(0);
					$offre_demande_cloture->setCloture_membre($_POST['code_membre_offre']);
					$offre_demande_cloture->setDate_cloture($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$offre_demande_cloture->setCode_membre_offre($_POST['code_membre_offre']);
					$offre_demande_cloture->setCode_compte_offre($_POST['code_compte_offre']);
					$offre_demande_cloture->setId_credit_offre($id_credit_offre);
					$offre_demande_cloture->setMontant_offre($_POST['montant_offre']);
					$offre_demande_cloture->setCode_sms_offre(strtoupper(Util_Utils::genererCodeSMS(9)));
					$offre_demande_cloture->setNum_offre_demande($_POST['id_offre']."_".$_POST['id_demande']);
					$m_offre_demande_cloture->save($offre_demande_cloture);
	}else{
				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$offre_demande_cloture = new Application_Model_EuOffreDemandeCloture();
				$m_offre_demande_cloture = new Application_Model_EuOffreDemandeClotureMapper();

				$m_offre_demande_cloture->find($offredemandecloture->id_cloture, $offre_demande_cloture);

					//$offre_demande_cloture->setId_offre($_POST['id_offre']);
					$offre_demande_cloture->setCloture(1);
					$offre_demande_cloture->setDate_cloture($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$offre_demande_cloture->setCode_membre_offre($_POST['code_membre_offre']);
					$offre_demande_cloture->setCode_compte_offre($_POST['code_compte_offre']);
					$offre_demande_cloture->setId_credit_offre($id_credit_offre);
					$offre_demande_cloture->setMontant_offre($_POST['montant_offre']);
					$offre_demande_cloture->setCode_sms_offre(strtoupper(Util_Utils::genererCodeSMS(9)));
					$m_offre_demande_cloture->update($offre_demande_cloture);
		}
					$this->_redirect('/espacepersonnel/listoffredemandecloture');
	}else{
						$sessionmembre->errorlogin = "Vérifier les montants";
		}
	
}else if($type == "Demande"){

			if (isset($_POST['code_membre_demande']) && $_POST['code_membre_demande'] != "" && isset($_POST['code_compte_demande']) && $_POST['code_compte_demande'] != "" && isset($_POST['montant_demande']) && is_numeric($_POST['montant_demande']) && isset($_POST['montant_demande_2']) && is_numeric($_POST['montant_demande_2']) && $_POST['montant_demande_2'] >= $_POST['montant_demande']) {
								if(isset($_POST['id_credit_demande']) && $_POST['id_credit_demande'] != "" ){$id_credit_demande = $_POST['id_credit_demande'];}else{$id_credit_demande = NULL;}

$offredemandecloture_m = new Application_Model_EuOffreDemandeClotureMapper();
$offredemandecloture = new Application_Model_EuOffreDemandeCloture();
$rowsoffredemandecloture = $offredemandecloture_m->fetchAllByOffre($_POST['id_offre'], $offredemandecloture);
if(!$offredemandecloture->id_demande){
				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$offre_demande_cloture = new Application_Model_EuOffreDemandeCloture();
				$m_offre_demande_cloture = new Application_Model_EuOffreDemandeClotureMapper();

					$compt_offre_demande_cloture = $m_offre_demande_cloture->findConuter() + 1;

					$offre_demande_cloture->setId_cloture($compt_offre_demande_cloture);
					$offre_demande_cloture->setId_demande($_POST['id_demande']);
					$offre_demande_cloture->setId_offre($_POST['id_offre']);
					$offre_demande_cloture->setCloture(0);
					$offre_demande_cloture->setCloture_membre($_POST['code_membre_demande']);
					$offre_demande_cloture->setDate_cloture($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$offre_demande_cloture->setCode_membre_demande($_POST['code_membre_demande']);
					$offre_demande_cloture->setCode_compte_demande($_POST['code_compte_demande']);
					$offre_demande_cloture->setId_credit_demande($id_credit_demande);
					$offre_demande_cloture->setMontant_demande($_POST['montant_demande']);
					$offre_demande_cloture->setCode_sms_demande(strtoupper(Util_Utils::genererCodeSMS(9)));
					$offre_demande_cloture->setNum_offre_demande($_POST['id_offre']."_".$_POST['id_demande']);
					$m_offre_demande_cloture->save($offre_demande_cloture);
	}else{
				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$offre_demande_cloture = new Application_Model_EuOffreDemandeCloture();
				$m_offre_demande_cloture = new Application_Model_EuOffreDemandeClotureMapper();

				$m_offre_demande_cloture->find($offredemandecloture->id_cloture, $offre_demande_cloture);

					//$offre_demande_cloture->setId_demande($_POST['id_demande']);
					$offre_demande_cloture->setCloture(1);
					$offre_demande_cloture->setDate_cloture($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$offre_demande_cloture->setCode_membre_demande($_POST['code_membre_demande']);
					$offre_demande_cloture->setCode_compte_demande($_POST['code_compte_demande']);
					$offre_demande_cloture->setId_credit_demande($id_credit_demande);
					$offre_demande_cloture->setMontant_demande($_POST['montant_demande']);
					$offre_demande_cloture->setCode_sms_demande(strtoupper(Util_Utils::genererCodeSMS(9)));
					$m_offre_demande_cloture->update($offre_demande_cloture);
		}
					$this->_redirect('/espacepersonnel/listoffredemandecloture');
	}else{
						$sessionmembre->errorlogin = "Vérifier les montants";
		}
	}
	
	}
	
					$this->_redirect('/espacepersonnel/listoffredemandemessage/id/'.$id.'/offre/'.$offre.'/demande/'.$demande.'');
	}
	
	
	public function listoffredemandeclotureAction() 
	{
		/* page espacepersonnel/listoffredemandecloture - Liste des clotures offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$offre_demande_cloture = new Application_Model_EuOffreDemandeClotureMapper();
		$this->view->entries = $offre_demande_cloture->fetchAllByMembre($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}

	
	public function clotureAction() 
	{
		/* page espacepersonnel/cloture - Cloture finale offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {


			$cloture = new Application_Model_EuOffreDemandeCloture();
			$m_cloture = new Application_Model_EuOffreDemandeClotureMapper();
			$m_cloture->find($id, $cloture);
				
				if (substr($cloture->code_membre_offre, -1) == "P") {
$membre_offre =  new Application_Model_EuMembre();
$membre_offre_mapper =  new Application_Model_EuMembreMapper();
$membre_offre_mapper->find($cloture->code_membre_offre, $membre_offre);
				}else{
$membre_offre =  new Application_Model_EuMembreMorale();
$membre_offre_mapper =  new Application_Model_EuMembreMoraleMapper();
$membre_offre_mapper->find($cloture->code_membre_offre, $membre_offre);
				}

				if (substr($cloture->code_membre_demande, -1) == "P") {
$membre_demande =  new Application_Model_EuMembre();
$membre_demande_mapper =  new Application_Model_EuMembreMapper();
$membre_demande_mapper->find($cloture->code_membre_demande, $membre_demande);
				}else{
$membre_demande =  new Application_Model_EuMembreMorale();
$membre_demande_mapper =  new Application_Model_EuMembreMoraleMapper();
$membre_demande_mapper->find($cloture->code_membre_demande, $membre_demande);
				}

			if(count($membre_offre) > 0 && count($membre_demande) > 0){
			$cloture->setCloture(2);
			$m_cloture->update($cloture);
			}
			
			if(count($membre_offre) > 0){
$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms($compteur, $membre_offre->portable_membre, "Voici votre Code SMS qui vous permet de terminer l'échange. Code SMS : ".$cloture->code_sms_demande." (".$cloture->montant_demande.")");        
}

			if(count($membre_demande) > 0){
$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms($compteur, $membre_demande->portable_membre, "Voici votre Code SMS qui vous permet de terminer l'échange. Code SMS : ".$cloture->code_sms_offre." (".$cloture->montant_offre.")");        
}

		}

		$this->_redirect('/espacepersonnel/listoffredemandecloture');
	}
	
	
	public function cloturesmsAction() 
	{
		/* page espacepersonnel/cloturesms - Cloture pas SMS offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['codesms']) && $_POST['codesms'] != "") {
				
$offredemandeclotureM = new Application_Model_EuOffreDemandeClotureMapper();
$offredemandecloture = $offredemandeclotureM->findBySMS($_POST['codesms']);

if($offredemandecloture->code_sms_offre == $_POST['codesms']){

			$cloture = new Application_Model_EuOffreDemandeCloture();
			$m_cloture = new Application_Model_EuOffreDemandeClotureMapper();
			$m_cloture->find($offredemandecloture->id_cloture, $cloture);
			
		if($cloture->getCloture() == 2){
			$clo = 3;
		}else if($cloture->getCloture() == 3){
			$clo = 4;
		}
			$cloture->setCloture($clo);
			//$m_cloture->update($cloture);
			
}
if($offredemandecloture->code_sms_demande == $_POST['codesms']){

			$cloture = new Application_Model_EuOffreDemandeCloture();
			$m_cloture = new Application_Model_EuOffreDemandeClotureMapper();
			$m_cloture->find($offredemandecloture->id_cloture, $cloture);
			
		if($cloture->getCloture() == 2){
			$clo = 3;
		}else if($cloture->getCloture() == 3){
			$clo = 4;
		}
			$cloture->setCloture($clo);
			//$m_cloture->update($cloture);
}	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
if($clo == 4){				
				
$compte_mapper =  new Application_Model_EuCompteMapper();
$compte_credit_mapper =  new Application_Model_EuCompteCreditMapper();
$compte_credit_ts_mapper =  new Application_Model_EuCompteCreditTsMapper();
$compte_capa_mapper =  new Application_Model_EuCapaMapper();
$compte_capa_ts_mapper =  new Application_Model_EuCapaTsMapper();




$compte_demande =  new Application_Model_EuCompte();
$compte_mapper->find($cloture->code_compte_demande, $compte_demande);//depart demande
$compte_demande_solde = $compte_demande->solde;

$demande = new Application_Model_EuOffreDemande();
$m_demande = new Application_Model_EuOffreDemandeMapper();
$m_demande->find($cloture->id_demande, $demande);
$compte_demande2 =  new Application_Model_EuCompte();
$compte_mapper->find($demande->type_credit_of."-".$cloture->code_membre_demande, $compte_demande2);//arrivée demande
$compte_demande2_solde = $compte_demande2->solde;



$compte_offre =  new Application_Model_EuCompte();
$compte_mapper->find($cloture->code_compte_offre, $compte_offre);//depart offre
$compte_offre_solde = $compte_offre->solde;

$offre = new Application_Model_EuOffreDemande();
$m_offre = new Application_Model_EuOffreDemandeMapper();
$m_offre->find($cloture->id_offre, $offre);
$compte_offre2 =  new Application_Model_EuCompte();
$compte_mapper->find($offre->type_credit_de."-".$cloture->code_membre_offre, $compte_offre2);//arrivée offre
$compte_offre2_solde = $compte_offre2->solde;






$compte_credit_ts_demande =  new Application_Model_EuCompteCreditTs();
$compte_capa_ts_demande =  new Application_Model_EuCapaTs();

if(strpos($cloture->id_credit_demande, "CAPA") !== false){
$compte_capa_ts_mapper->find($cloture->id_credit_demande, $compte_capa_ts_demande);
$compte_capa_ts_demande_montant = $compte_capa_ts_demande->montant_solde;
}else if($cloture->id_credit_demande > 0){
$compte_credit_ts_mapper->find($cloture->id_credit_demande, $compte_credit_ts_demande);
$compte_credit_ts_demande_montant = $compte_credit_ts_demande->montant;
	}
	
$compte_credit_ts_offre =  new Application_Model_EuCompteCreditTs();
$compte_capa_ts_offre =  new Application_Model_EuCapaTs();

if(strpos($cloture->id_credit_offre, "CAPA") !== false){
$compte_capa_ts_mapper->find($cloture->id_credit_offre, $compte_capa_ts_offre);
$compte_capa_ts_offre_montant = $compte_capa_ts_offre->montant_solde;
}else if($cloture->id_credit_offre > 0){
$compte_credit_ts_mapper->find($cloture->id_credit_offre, $compte_credit_ts_offre);
$compte_credit_ts_offre_montant = $compte_credit_ts_offre->montant;
	}




/*if($compte_credit_ts_demande_montant < $cloture->montant_demande || $compte_demande_solde < $cloture->montant_demande || $compte_credit_ts_offre_montant < $cloture->montant_offre || $compte_offre_solde < $cloture->montant_offre){
			$clo = 3;
			$cloture->setCloture($clo);
			$m_cloture->update($cloture);
						$sessionmembre->errorlogin = "Vérifier bien les montants ";
		$this->_redirect('/espacepersonnel/listoffredemandecloture');

}else{*/
	
if(strpos($cloture->id_credit_demande, "CAPA") !== false){

$compte_capa_ts_demande->setMontant_utiliser($compte_capa_ts_demande->getMontant_utiliser() + $cloture->montant_demande);
$compte_capa_ts_demande->setMontant_solde($compte_capa_ts_demande_montant - $cloture->montant_demande);
$compte_capa_ts_mapper->update($compte_capa_ts_demande);
	
$compte_demande->setSolde($compte_demande_solde - $cloture->montant_demande);
$compte_mapper->update($compte_demande);


$rows_compte_demande2 = $compte_capa_mapper->fetchAll2($compte_demande2->code_compte);
	if(count($rows_compte_demande2) > 0){
				$date_deb = Zend_Date::now();
				$type = $sessionmembre->type;
				
				
				$mapper = new Application_Model_EuOperationMapper();
				$place = new Application_Model_EuOperation();
				$compteur = $mapper->findConuter() + 1;
				$place->setId_operation($compteur)
						->setDate_op($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setMontant_op($cloture->montant_demande);
				if (substr($cloture->code_membre_offre, -1) == "P") {
					$place->setCode_membre($cloture->code_membre_offre);
					$place->setCode_membre_morale(NULL);
				} else if (substr($cloture->code_membre_offre, -1) == "M") {
					$place->setCode_membre(NULL);
					$place->setCode_membre_morale($cloture->code_membre_offre);
				}
				$place->setHeure_op($date_deb->toString('HH:mm:ss'))
						->setCode_produit($compte_capa_ts_demande->code_produit)
						->setId_utilisateur(NULL)
						->setLib_op('Echange '.$compte_capa_ts_demande->code_produit)
						->setCode_cat(substr($compte_offre2->code_compte, 3, -21))
						->setType_op('ECH '.strtoupper($compte_capa_ts_demande->code_produit));
				$mapper->save($place);

				
				
				
				
				$m_capa = new Application_Model_EuCapaMapper();
				$capa = new Application_Model_EuCapa();
				$code_capa = 'CAPA' . $type . $date_deb->toString('yyyyMMddHHmmss');
				$capa->setCode_capa($code_capa)
						->setId_operation($compteur)
						->setDate_capa($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setMontant_capa($cloture->montant_demande)
						->setMontant_utiliser(0)
						->setMontant_solde($cloture->montant_demande)
						->setCode_membre($cloture->code_membre_offre)
						->setHeure_capa($date_deb->toString('HH:mm:ss'))
						->setType_capa($type)
						->setCode_compte($compte_offre2->code_compte)
						->setEtat_capa('Actif')
						->setCode_produit($compte_capa_ts_demande->code_produit)
						->setOrigine_capa('NN');
				$m_capa->save($capa);
	}
$compte_demande2->setSolde($compte_demande2_solde + $cloture->montant_offre);
$compte_mapper->update($compte_demande2);


}else if($cloture->id_credit_demande > 0){
	if($cloture->id_credit_offre > 0){
$compte_credit_ts_demande->setDatefin($compte_credit_ts_offre->datefin);
	}
$compte_credit_ts_demande->setMontant($compte_credit_ts_demande_montant - $cloture->montant_demande);
$compte_credit_ts_mapper->update($compte_credit_ts_demande);
	
$compte_demande->setSolde($compte_demande_solde - $cloture->montant_demande);
$compte_mapper->update($compte_demande);


$rows_compte_demande2 = $compte_credit_mapper->fetchAllCodeCompte($compte_demande2->code_compte);
	//if(count($rows_compte_demande2) > 0){
				$date_deb = Zend_Date::now();
				
				
				$mapper = new Application_Model_EuOperationMapper();
				$place = new Application_Model_EuOperation();
				$compteur = $mapper->findConuter() + 1;
				$place->setId_operation($compteur)
						->setDate_op($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setMontant_op($cloture->montant_demande);
				if (substr($cloture->code_membre_offre, -1) == "P") {
					$place->setCode_membre($cloture->code_membre_offre);
					$place->setCode_membre_morale(NULL);
				} else if (substr($cloture->code_membre_offre, -1) == "M") {
					$place->setCode_membre(NULL);
					$place->setCode_membre_morale($cloture->code_membre_offre);
				}
				$place->setHeure_op($date_deb->toString('HH:mm:ss'))
						->setCode_produit($compte_credit_ts_demande->code_produit)
						->setId_utilisateur(NULL)
						->setLib_op('Echange '.$compte_credit_ts_demande->code_produit)
						->setCode_cat(substr($compte_offre2->code_compte, 3, -21))
						->setType_op('ECH '.strtoupper($compte_credit_ts_demande->code_produit));
				$mapper->save($place);

				
				
				
				
					$cc_mapper = new Application_Model_EuCompteCreditMapper();
					$max_code = $cc_mapper->findConuter() + 1;
				$place_cocr = new Application_Model_EuCompteCredit();
				$place_cocr->setId_credit($max_code)
							->setMontant_credit($cloture->montant_demande)
							->setCode_membre($cloture->code_membre_offre)
							->setCode_produit($compte_credit_ts_demande->code_produit)
							->setMontant_place($cloture->montant_demande)
							->setDatefin($compte_credit_ts_demande->datefin)
							->setDatedeb($compte_credit_ts_demande->datedeb)
							->setSource($compte_credit_ts_demande->source)
							->setDate_octroi($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
							->setCompte_source($compte_credit_ts_demande->code_compte)
							->setKrr('N')
							->setPrk(NULL)
							->setCode_type_credit("CNPG")
							->setNbre_renouvel(0)
							->setRenouveller('N')
							->setBnp(0)
							->setCode_compte($compte_offre2->code_compte)
							->setId_operation($compteur)
							->setDomicilier(0)
							->setCode_bnp(NULL)
							->setAffecter(2);
				$cc_mapper->save($place_cocr);
	//}
$compte_demande2->setSolde($compte_demande2_solde + $cloture->montant_offre);
$compte_mapper->update($compte_demande2);
			
}else{
	
$compte_demande->setSolde($compte_demande_solde - $cloture->montant_demande);
$compte_mapper->update($compte_demande);
	
$compte_demande2->setSolde($compte_demande2_solde + $cloture->montant_offre);
$compte_mapper->update($compte_demande2);
}
	

			
			//$codeproduitoffre = ;
			$codeproduitdemande = $compte_credit_ts_demande->code_produit;
			$codecompteoffre = $compte_offre2->code_compte;
			//$codecomptedemande = ;
			$codemembreoffre = $cloture->code_membre_offre;
			//$codemembredemande = ;
			$montantoffre = $cloture->montant_offre;
			$montantdemande = $cloture->montant_demande;
			$typeoffre = substr($compte_offre2->code_compte, 0, 2);
			//$typedemande = ;
			




			
if(strpos($cloture->id_credit_offre, "CAPA") !== false){

$compte_capa_ts_offre->setMontant_utiliser($compte_capa_ts_offre->getMontant_utiliser() + $cloture->montant_offre);
$compte_capa_ts_offre->setMontant_solde($compte_capa_ts_offre_montant - $cloture->montant_offre);
$compte_capa_ts_mapper->update($compte_capa_ts_offre);
	
$compte_offre->setSolde($compte_offre_solde - $cloture->montant_offre);
$compte_mapper->update($compte_offre);


$rows_compte_offre2 = $compte_capa_mapper->fetchAll2($compte_offre2->code_compte);
	if(count($rows_compte_offre2) > 0){
				$date_deb = Zend_Date::now();
				$type = $sessionmembre->type;
				
				
				$mapper = new Application_Model_EuOperationMapper();
				$place = new Application_Model_EuOperation();
				$compteur = $mapper->findConuter() + 1;
				$place->setId_operation($compteur)
						->setDate_op($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setMontant_op($cloture->montant_offre);
				if (substr($cloture->code_membre_demande, -1) == "P") {
					$place->setCode_membre($cloture->code_membre_demande);
					$place->setCode_membre_morale(NULL);
				} else if (substr($cloture->code_membre_demande, -1) == "M") {
					$place->setCode_membre(NULL);
					$place->setCode_membre_morale($cloture->code_membre_demande);
				}
				$place->setHeure_op($date_deb->toString('HH:mm:ss'))
						->setCode_produit($compte_capa_ts_offre->code_produit)
						->setId_utilisateur(NULL)
						->setLib_op('Echange '.$compte_capa_ts_offre->code_produit)
						->setCode_cat(substr($compte_demande2->code_compte, 3, -21))
						->setType_op('ECH '.strtoupper($compte_capa_ts_offre->code_produit));
				$mapper->save($place);

				
				$m_capa = new Application_Model_EuCapaMapper();
				$capa = new Application_Model_EuCapa();
				$code_capa = 'CAPA' . $type . $date_deb->toString('yyyyMMddHHmmss');
				$capa->setCode_capa($code_capa)
						->setId_operation($compteur)
						->setDate_capa($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setMontant_capa($cloture->montant_offre)
						->setMontant_utiliser(0)
						->setMontant_solde($cloture->montant_offre)
						->setCode_membre($cloture->code_membre_demande)
						->setHeure_capa($date_deb->toString('HH:mm:ss'))
						->setType_capa($type)
						->setCode_compte($compte_demande2->code_compte)
						->setEtat_capa('Actif')
						->setCode_produit($compte_capa_ts_offre->code_produit)
						->setOrigine_capa('NN');
				$m_capa->save($capa);
	}
$compte_offre2->setSolde($compte_offre2_solde + $cloture->montant_demande);
$compte_mapper->update($compte_offre2);

}else if($cloture->id_credit_offre > 0){
	if($cloture->id_credit_demande > 0){
$compte_credit_ts_offre->setDatefin($compte_credit_ts_demande->datefin);
	}
$compte_credit_ts_offre->setMontant($compte_credit_ts_offre_montant - $cloture->montant_offre);
$compte_credit_ts_mapper->update($compte_credit_ts_offre);
	
$compte_offre->setSolde($compte_offre_solde - $cloture->montant_offre);
$compte_mapper->update($compte_offre);


$rows_compte_offre2 = $compte_credit_mapper->fetchAllCodeCompte($compte_offre2->code_compte);
	//if(count($rows_compte_offre2) > 0){
				$date_deb = Zend_Date::now();
				
				
				$mapper = new Application_Model_EuOperationMapper();
				$place = new Application_Model_EuOperation();
				$compteur = $mapper->findConuter() + 1;
				$place->setId_operation($compteur)
						->setDate_op($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
						->setMontant_op($cloture->montant_offre);
				if (substr($cloture->code_membre_demande, -1) == "P") {
					$place->setCode_membre($cloture->code_membre_demande);
					$place->setCode_membre_morale(NULL);
				} else if (substr($cloture->code_membre_demande, -1) == "M") {
					$place->setCode_membre(NULL);
					$place->setCode_membre_morale($cloture->code_membre_demande);
				}
				$place->setHeure_op($date_deb->toString('HH:mm:ss'))
						->setCode_produit($compte_credit_ts_offre->code_produit)
						->setId_utilisateur(NULL)
						->setLib_op('Echange '.$compte_credit_ts_offre->code_produit)
						->setCode_cat(substr($compte_demande2->code_compte, 3, -21))
						->setType_op('ECH '.strtoupper($compte_credit_ts_offre->code_produit));
				$mapper->save($place);

				
				
				
					$cc_mapper = new Application_Model_EuCompteCreditMapper();
					$max_code = $cc_mapper->findConuter() + 1;
				$place_cocr = new Application_Model_EuCompteCredit();
				$place_cocr->setId_credit($max_code)
							->setMontant_credit($cloture->montant_offre)
							->setCode_membre($cloture->code_membre_demande)
							->setCode_produit($compte_credit_ts_offre->code_produit)
							->setMontant_place($cloture->montant_offre)
							->setDatefin($compte_credit_ts_offre->datefin)
							->setDatedeb($compte_credit_ts_offre->datedeb)
							->setSource($compte_credit_ts_offre->source)
							->setDate_octroi($date_deb->toString('yyyy-MM-dd HH:mm:ss'))
							->setCompte_source($compte_credit_ts_offre->code_compte)
							->setKrr('N')
							->setPrk(NULL)
							->setCode_type_credit("CNPG")
							->setNbre_renouvel(0)
							->setRenouveller('N')
							->setBnp(0)
							->setCode_compte($compte_demande2->code_compte)
							->setId_operation($compteur)
							->setDomicilier(0)
							->setCode_bnp(NULL)
							->setAffecter(2);
				$cc_mapper->save($place_cocr);
	//}
$compte_offre2->setSolde($compte_offre2_solde + $cloture->montant_demande);
$compte_mapper->update($compte_offre2);

}else{
	
$compte_offre->setSolde($compte_offre_solde - $cloture->montant_offre);
$compte_mapper->update($compte_offre);
	
$compte_offre2->setSolde($compte_offre2_solde + $cloture->montant_demande);
$compte_mapper->update($compte_offre2);
}

			
			$codeproduitoffre = $compte_credit_ts_offre->code_produit;
			//$codeproduitdemande = ;
			//$codecompteoffre = ;
			$codecomptedemande = $compte_demande2->code_compte;
			//$codemembreoffre = ;
			$codemembredemande = $cloture->code_membre_demande;
			$montantoffre = $cloture->montant_offre;
			$montantdemande = $cloture->montant_demande;
			//$typeoffre = ;
			$typedemande = substr($compte_demande2->code_compte, 0, 2);
			

			
			

				
			$cloture->setCloture($clo);
			$m_cloture->update($cloture);

if($offredemandecloture->code_sms_offre == $_POST['codesms']){
$cloture->setCode_sms_offre(NULL);
}else{
$cloture->setCode_sms_demande(NULL);
}
$m_cloture->update($cloture);

/*

				$date_deb = Zend_Date::now();
			
			
			
	   $produit = new Application_Model_DbTable_EuProduit();
		$select = $produit->select();
		$select->where('code_catEGORIE like ?', substr($demande->type_credit_of, 3));
		$resultSet = $produit->fetchRow($select);
			
			$codeproduitoffre = ;
			$codeproduitdemande = ;
			$codecompteoffre = ;
			$codecomptedemande = ;
			$codemembreoffre = ;
			$codemembredemande = ;
			$montantoffre = ;
			$montantdemande = ;
			$typeoffre = ;
			$typedemande = ;
			
			$echange = new Application_Model_EuEchange();
			$m_echange = new Application_Model_EuEchangeMapper();

						$countechange = $m_echange->findConuter() + 1;
						$echange->setId_echange($countechange)
								->setAgio(0)
								->setCat_echange(substr($demande->type_credit_of, 3))
								->setCode_compte_obt($compte_demande2->code_compte)
								->setCode_produit(substr($offre->type_credit_de, 3))
								->setCompenser(0)
								->setDate_echange($date_deb->toString('yyyy-MM-dd'))
								->setDate_reglement($date_deb->toString('yyyy-MM-dd'))
								->setId_credit(NULL)
								->setMontant($cloture->montant_demande)
								->setMontant_echange($cloture->montant_offre)
								->setRegle(0)
								->setType_echange(substr($demande->type_credit_of, 0, 2).'/'.substr($offre->type_credit_de, 0, 2))
								->setCode_compte_ech($compte_offre2->code_compte);
						
				if (substr($compte_demande2->code_membre, -1) == "P") {
					$echange->setCode_membre($compte_demande2->code_membre);
					$echange->setCode_membre_morale(NULL);
				} else if (substr($compte_demande2->code_membre, -1) == "M") {
					$echange->setCode_membre(NULL);
					$echange->setCode_membre_morale($compte_demande2->code_membre);
				}
						$echange->setId_utilisateur(NULL);//$user->id_utilisateur
								
						$m_echange->save($echange);
						
	*/
			
			
$m_offre_demande_message = new Application_Model_EuOffreDemandeMessageMapper();

$rowsoffremessage = $m_offre_demande_message->fetchAllByOffre2($cloture->id_offre);
		foreach ($rowsoffremessage as $row) {
			//important
					//$m_offre_demande_message->delete($row->id_message);
							/*$demandemessage = $m_offre_demande_message->fetchAllByDemande2($row->id_demande);
							if(count($demandemessage) == 0){
							$m_demande = new Application_Model_EuOffreDemandeMapper();
												$m_demande->delete($row->id_demande);
								}*/					
			}
$rowsdemandemessage = $m_offre_demande_message->fetchAllByDemande2($cloture->id_demande);
		foreach ($rowsdemandemessage as $row) {
			//important
					//$m_offre_demande_message->delete($row->id_message);
							/*$offremessage = $m_offre_demande_message->fetchAllByOffre2($row->id_offre);
							if(count($offremessage) == 0){
							$m_offre = new Application_Model_EuOffreDemandeMapper();
												$m_offre->delete($row->id_offre);
								}*/					
			}
			
							$m_demande = new Application_Model_EuOffreDemandeMapper();
												//$m_demande->delete($cloture->id_demande);
							$m_offre = new Application_Model_EuOffreDemandeMapper();
												//$m_offre->delete($cloture->id_offre);

						$sessionmembre->errorlogin = "Opération bien effectuée";
		$this->_redirect('/espacepersonnel/listoffredemandecloture');

	//}
/*}else{
			$clo = 3;
			$cloture->setCloture($clo);
			$m_cloture->update($cloture);
						$sessionmembre->errorlogin = "Vérifier bien les montants ";
		$this->_redirect('/espacepersonnel/listoffredemandecloture');
	}*/
		}else if ($clo == 3){
			
			$cloture->setCloture($clo);
			$m_cloture->update($cloture);

if($offredemandecloture->code_sms_offre == $_POST['codesms']){
$cloture->setCode_sms_offre(NULL);
}else{
$cloture->setCode_sms_demande(NULL);
}
$m_cloture->update($cloture);

						$sessionmembre->errorlogin = "Opération encours ";
		$this->_redirect('/espacepersonnel/listoffredemandecloture');
		}else{
			
			$clo = $cloture->getCloture();
			$cloture->setCloture($clo);
			$m_cloture->update($cloture);
						$sessionmembre->errorlogin = "Opération non effectuée";
		$this->_redirect('/espacepersonnel/listoffredemandecloture');
			}		
			}
			
		}

	}
	
	
	public function suppoffredemandeclotureAction() 
	{
		/* page espacepersonnel/suppoffredemandecloture - Suppression cloture offre et ou demande */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if ($id > 0) {

			$offre_demande_cloture_M = new Application_Model_EuOffreDemandeClotureMapper();
			$offre_demande_cloture_M->delete($id);
		}

		$this->_redirect('/espacepersonnel/offredemande');
	}
	
	
public function listAction() 
	{
		/* page espacepersonnel/list - Contrat en PDF */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        $contrat_m = new Application_Model_EuContratMapper();
        $contrat_rows = $contrat_m->findByMembre($sessionmembre->code_membre);

			$date_id = new Zend_Date(Zend_Date::ISO_8601);
			$date_idd = clone $date_id;
			if (substr($sessionmembre->code_membre,19,1) == 'P')  {
				$membre = new Application_Model_DbTable_EuMembre();
                $select = $membre->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                       ->join('eu_contrat','eu_contrat.code_membre = eu_membre.code_membre', array('eu_membre.*','eu_contrat.*'))
                       ->join('eu_pays','eu_pays.id_pays = eu_membre.id_pays')  
                       ->where('eu_contrat.id_contrat = ?',$contrat_rows->id_contrat);
                $data = $membre->fetchAll($select);		 
            } else {
			    $membre = new Application_Model_DbTable_EuMembreMorale();
                $select = $membre->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
                $select->setIntegrityCheck(false)
                       ->join('eu_contrat','eu_contrat.code_membre = eu_membre_morale.code_membre_morale',array('eu_membre_morale.*','eu_contrat.*'))
                       ->join('eu_pays','eu_pays.id_pays = eu_membre_morale.id_pays')  
                       ->where('eu_contrat.id_contrat = ?',$contrat_rows->id_contrat);
                $data = $membre->fetchAll($select);		
			}
			  
			// création du document pdf
		    $pdf = new Default_Pdf_Contrat();
			
			// création d'une nouvelle page au format A4 
			$entete = new Default_Pdf_Page_Entete(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $entete;
			
			$currentPage = new Default_Pdf_Page_Contrat(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $currentPage; 
		    
			$currentPagesuite = new Default_Pdf_Page_Contratsuite(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $currentPagesuite; 
			
			$currentPagesuitenext = new Default_Pdf_Page_Contratsuitenext(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $currentPagesuitenext;
			  
			$currentPagesuitenext1 = new Default_Pdf_Page_Contratsuitenext1(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $currentPagesuitenext1;
			 
			$currentPagesuitenext2 = new Default_Pdf_Page_Contratsuitenext2(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $currentPagesuitenext2;
			 
			$currentPagesuitenext3 = new Default_Pdf_Page_Contratsuitenext3(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $currentPagesuitenext3;
			
			$currentPagesuitenext4 = new Default_Pdf_Page_Contratsuitenext4(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $currentPagesuitenext4;
			
			$currentPagesuitenext5 = new Default_Pdf_Page_Contratsuitenext5(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $currentPagesuitenext5;
			
            $entete->addContrat();
			$currentPage->addContrat();
			$currentPagesuite->addContrat();
			$currentPagesuitenext->addContrat();
			$currentPagesuitenext1->addContrat();
			$currentPagesuitenext2->addContrat();
		    $currentPagesuitenext3->addContrat();
		    $currentPagesuitenext4->addContrat($contrat);
			foreach($data as $contrat)  {
                $currentPagesuitenext5->addContrat($contrat);  
			}
			//permet de spécifier l'en-tête HTTP
		    header('Content-Type: application/pdf; charset=UTF-8');
		    //affichage de notre PDF
		    echo $pdf->render();
            $this->view->data = $pdf->render(); 
		    //comme l'action affiche un PDF, nous allons désactiver l'affichage de la vue et du layout
		    //permet de désactiver l'affichage de la vue de l'action list 
		    $this->_helper->viewRenderer->setNoRender(true);
		    //permet de désactiver l'affichage du layout
		    $this->_helper->layout->disableLayout();
				
	}	





	public function detailstacheAction() {
		/* page espacepersonnel/detailstache - Detail d'une tache */

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
		$a = new Application_Model_EuTache();
		$ma = new Application_Model_EuTacheMapper();
		$ma->find($id, $a);
		$this->view->tache = $a;
			}

	}




	public function listbonAction()
	{
		/* page espacepersonnel/listbon - Liste des bons */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$bon = new Application_Model_EuBonMapper();
		$this->view->entries = $bon->fetchAllByMembre($sessionmembre->code_membre);

		$this->view->tabletri = 1;

	}





	public function listfactureAction()
	{
		/* page espacepersonnel/listfacture - Liste des factures */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$facture = new Application_Model_EuFacturesMapper();
		$this->view->entries = $facture->fetchAllByMembre($sessionmembre->code_membre);

		$this->view->tabletri = 1;

	}





	public function listrecuAction()
	{
		/* page espacepersonnel/listrecu - Liste des reçus */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$recu = new Application_Model_EuRecuMapper();
		$this->view->entries = $recu->fetchAllByMembre($sessionmembre->code_membre);

		$this->view->tabletri = 1;

	}



	public function testAction()
	{
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		

$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms($compteur, '90291387', "Vous venez d'être selectionné pour l'appel d'offre auquel vous avez soumissionner. Vous êtes le gagnant de cet appel d'offre.");        



	}



	

	









	public function addallocationcmfhAction() 
	{

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['allocation_cmfh_type']) && $_POST['allocation_cmfh_type'] != "" && isset($_POST['allocation_cmfh_nombre']) && $_POST['allocation_cmfh_nombre'] != "") {

				$date_id = new Zend_Date(Zend_Date::ISO_8601);
				
                                $integrateur_mapper = new Application_Model_EuIntegrateurMapper();
                                $integrateur = $integrateur_mapper->fetchAllByCodeMembre($_POST['allocation_cmfh_code_membre_integrageur']);

                                $offreur_projet_mapper = new Application_Model_EuOffreurProjetMapper();
                                $offreur_projet = $offreur_projet_mapper->fetchAllByMembre($_POST['allocation_cmfh_code_membre_integrageur']);
                                
                                if(count($integrateur) == 0 && count($offreur_projet) == 0){
								$sessionmembre->error = "Le Code Membre est erroné ...";
								$this->_redirect('/espacepersonnel/addallocationcmfh');
	                            return;
    	                        }



		$allocationcmfh_M = new Application_Model_EuAllocationCmfhMapper();
		$cumulnombre = $allocationcmfh_M->CumulNombreCMFH($sessionmembre->code_membre);
		$cumulnombreutilise = $allocationcmfh_M->CumulNombreUtiliseCMFH($sessionmembre->code_membre);
		$cumulnombresolde = $allocationcmfh_M->CumulNombreSoldeCMFH($sessionmembre->code_membre);
				
		$depot_vente_M = new Application_Model_EuDepotVenteMapper();
		$cumulreste = $depot_vente_M->CumulResteCMFH($sessionmembre->code_membre);
		$nombre_reste = $cumulreste / 70000;		
				
				$reste_a_allouer = $nombre_reste - $cumulnombresolde;
				
				if($_POST['allocation_cmfh_nombre'] > $reste_a_allouer){
					$sessionmembre->error = "Il ne vous reste que : ".$reste_a_allouer." codes à allouer ...";
					$this->_redirect('/espacepersonnel/addallocationcmfh');
					}else{

				$allocation_cmfh = new Application_Model_EuAllocationCmfh();
				$m_allocation_cmfh = new Application_Model_EuAllocationCmfhMapper();

					$compt_allocation_cmfh = $m_allocation_cmfh->findConuter() + 1;
					
                    $code_allocation = strtoupper(Util_Utils::genererCodeSMS(8));

					$allocation_cmfh->setAllocation_cmfh_id($compt_allocation_cmfh);
					$allocation_cmfh->setAllocation_cmfh_code($code_allocation);
					$allocation_cmfh->setAllocation_cmfh_type($_POST['allocation_cmfh_type']);
					$allocation_cmfh->setAllocation_cmfh_code_membre_cmfh($sessionmembre->code_membre);
					$allocation_cmfh->setAllocation_cmfh_code_membre_integrageur($_POST['allocation_cmfh_code_membre_integrageur']);
					$allocation_cmfh->setAllocation_cmfh_montant_utilise(0);
					$allocation_cmfh->setAllocation_cmfh_nombre($_POST['allocation_cmfh_nombre']);
					$allocation_cmfh->setAllocation_cmfh_nombre_utilise(0);
					$allocation_cmfh->setAllocation_cmfh_nombre_solde($_POST['allocation_cmfh_nombre']);
					$allocation_cmfh->setAllocation_cmfh_actif(1);
					$allocation_cmfh->setAllocation_cmfh_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$m_allocation_cmfh->save($allocation_cmfh);/**/

					$sessionmembre->error = "Opération bien effectuée ...";
					$this->_redirect('/espacepersonnel/listallocationcmfh');
						
						}
			} else {
				$this->view->error = "Champs * obligatoire";
			}
		}
	}





	public function listallocationcmfhAction()
	{
		/* page espacepersonnel/listrecu - Liste des reçus */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$allocationcmfh = new Application_Model_EuAllocationCmfhMapper();
		$this->view->entries = $allocationcmfh->fetchAllByCMFH($sessionmembre->code_membre);

		$this->view->tabletri = 1;

	}




	public function suppallocationcmfhAction()
	{
		/* page espacepersonnel/suppallocationcmfh - Suppression de l'allocation */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$allocationcmfh = new Application_Model_EuAllocationCmfh();
		$allocationcmfhM = new Application_Model_EuAllocationCmfhMapper();
		$allocationcmfhM->find($id, $allocationcmfh);
		
		$allocationcmfhM->delete($allocationcmfh->allocation_cmfh_id);

		}

		$this->_redirect('/espacepersonnel/listallocationcmfh');
	}





	public function actifallocationAction()
	{
		/* page espacepersonnel/actifallocation - actifallocation */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$allocationcmfh = new Application_Model_EuAllocationCmfh();
		$allocationcmfhM = new Application_Model_EuAllocationCmfhMapper();
		$allocationcmfhM->find($id, $allocationcmfh);
		
		$allocationcmfh->setAllocation_cmfh_actif($this->_request->getParam('actif'));
		$allocationcmfhM->update($allocationcmfh);
		}

		$this->_redirect('/espacepersonnel/listallocationcmfh');
	}






	
	public function activationcapsAction()   {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		
	
	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		} 
		  
if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
		  
	       $t_canton = new Application_Model_DbTable_EuCanton();
           $t_region = new Application_Model_DbTable_EuRegion();
           $t_prefecture = new Application_Model_DbTable_EuPrefecture();
           $t_pays = new Application_Model_DbTable_EuPays();
           $t_zone = new Application_Model_DbTable_EuZone();
	   
	       $cantons = $t_canton->fetchAll();
           $regions = $t_region->fetchAll();
           $pays = $t_pays->fetchAll();
           $zones = $t_zone->fetchAll();
           $prefectures = $t_prefecture->fetchAll();
           $this->view->cantons = $cantons;
           $this->view->regions = $regions;
           $this->view->zones = $zones;
           $this->view->pays = $pays;
           $this->view->prefectures = $prefectures;
		   
	       if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
		   $request = $this->getRequest();
	       if ($request->isPost ()) {
		      $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
			  try {
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
						   
						   $id_utilisateur_acnev = 1;
						   $id_utilisateur_filiere = 2;
						   $id_utilisateur_technopole = 3;
						   
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
						
						   $allocation = new Application_Model_EuAllocationCmfh();
		                   $m_allocation = new Application_Model_EuAllocationCmfhMapper();
						
					       $souscription = new Application_Model_EuSouscription();
                           $souscription_mapper = new Application_Model_EuSouscriptionMapper();
					
					       $date = new Zend_Date(Zend_Date::ISO_8601);
						   
						   $code_agence = $request->getParam("code_agence");
						   //$code_autorisation = $request->getParam("code_autorisation");
						   //$type_activation = $request->getParam("type_activation");
						   $code_zone = $request->getParam("code_zone");
						   
						   $type_bnp  = 'CAPS';
                           $type_caps = 'CAPSFLFCPS';
						   $code_activation  = '';
			               $id_membretiers  = '';
						   $id_allocation   = '';
						   $id_depot = '';
			               $souscription_id = '';
			               $apporteur = '';
						   $reste_allocation = '';
						   
						   $table = new Application_Model_DbTable_EuActeur();
                           $selection = $table->select();
                           $selection->where('code_membre like ?',$code_agence.'%');
                           $selection->where('type_acteur like ?','gac_surveillance');
                           $resultat = $table->fetchAll($selection);
                           $trouvacteursur = $resultat->current();
                           $code_acteur = $trouvacteursur->code_acteur;
                           $acteur =  $code_acteur;
						   $reste = $mont_caps;
						   
						   
						   $apporteur = $sessionmembre->code_membre;


						   $lignesdvente = $m_dvente->findbycmfh($apporteur);
						   $nbre_lignesdvente = count($lignesdvente);
						   $reste = $mont_caps;
						   
						   if ($lignesdvente != NULL) {
			                   $lignedvente = $lignesdvente[0];
                                $id_depot = $lignedvente->getId_depot();
							    $souscription_id = $lignedvente->getSouscription_id();
							    $finddepotvente = $m_dvente->find($id_depot,$dvente);
							
							    $lignedvente->setSolde_depot($lignedvente->getSolde_depot() - $reste);
						        $lignedvente->setMont_vendu($lignedvente->getMont_vendu() + $reste);
                                $m_dvente->update($lignedvente);
							
							    $findCodesBySous = $m_membretiers->findBySouscription($souscription_id);
						        if($findCodesBySous != NULL)  {
						           $findCodeBySous = $findCodesBySous[0];
						           $id_membretiers = $findCodeBySous->getMembretierscode_id();
						           $code_activation = $findCodeBySous->getMembretierscode_code();
						        } else {
						           $db->rollback();
                                   $this->view->message = "Le  membre CMFH ne dispose pas de comptes marchands pour tiers ...";
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
                              $this->view->message = "Le  membre CMFH ne dispose pas de comptes marchands pour tiers ...";
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
						   
						   
						   $count = $mapper->findConuter() + 1;
                           $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                           $date_deb = clone $date_fin;
				
		                   $place->setId_operation($count)
                                 ->setDate_op($date->toString('yyyy-MM-dd'))
                                 ->setHeure_op($date->toString('HH:mm:ss'))
                                 ->setId_utilisateur(null);
								 
                            if(substr($apporteur,19,1)=='P') {
                              $place->setCode_membre($apporteur)
                                    ->setCode_membre_morale(null);
                            } else  {
                              $place->setCode_membre(null)
                                    ->setCode_membre_morale($apporteur);
                            } 	 
                            $place->setMontant_op($mont_caps)
                                  ->setCode_produit('CAPS')
                                  ->setLib_op('Enrolement')
                                  ->setType_op($type_bnp)
                                  ->setCode_cat('TCAPS');
			                $mapper->save($place);
							
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
                                $this->view->message = "La date de naissance doit etre antérieure à la date actuelle !!!";
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
						
						    /////////////////controle nom prenom
					        $eupreinscription = new Application_Model_DbTable_EuMembre();
	                        $select = $eupreinscription->select();
	                        $select->where("LOWER(REPLACE(nom_membre, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "",$request->getParam("nom_membre"))));
						
						    $tabprenom = explode(" ",$request->getParam("prenom_membre"));
						    foreach ($tabprenom as $value) {
	                          $select->where("LOWER(REPLACE(prenom_membre, ' ', '')) LIKE '%".strtolower(str_replace(" ", "",$value))."%' ");
						    }
						
	                        $select->where("LOWER(REPLACE(date_nais_membre, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "",$date_nais->toString('yyyy-MM-dd'))));
	                        $select->where("LOWER(REPLACE(lieu_nais_membre, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "",$request->getParam("lieu_nais_membre"))));
	                        $select->limit(1);
	                        $rowseupreinscription = $eupreinscription->fetchRow($select);
		                    if(count($rowseupreinscription) > 0) { 
							   $this->view->message = "Vous êtes déjà membre !!!";
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
                			               ->setCode_fkps(null)
									       ->setId_canton($request->getParam("id_canton"));
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
                                    ->setAuto_enroler('N')
							        ->setId_canton($request->getParam("id_canton"));
                            $m_map->save($membre);
							
						////////////////////////////////////////////////////////////////////////////////
						$preinscription = new Application_Model_EuPreinscription();
						$preinscriptionM = new Application_Model_EuPreinscriptionMapper();
						$preinscriptionM->find($compteur_preinscription, $preinscription);
								
						$preinscription->setCode_membre($code);
						$preinscriptionM->update($preinscription);
				
				        $findmembretiers = $m_membretiers->find($id_membretiers,$membretiers);
			            if($findmembretiers) {
			               $membretiers->setCode_membre($code)
							           ->setPublier(1)
									   ->setAllocation_cmfh_id(NULL);
				           $m_membretiers->update($membretiers);
		                }
				
				        // insertion dans la table eu_activation
						$id_activation = $m_activation->findConuter() + 1;
						$activation->setId_activation($id_activation)
						           ->setId_depot($id_depot)
								   ->setDate_activation($date_idd->toString('yyyy-MM-dd HH:mm:ss'))
								   ->setCode_activation($code_activation)
								   ->setCode_membre($code)
								   ->setMembreasso_id($sessionmembre->membreasso_id);
						$m_activation->save($activation);
						
						
						
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
                               ->setId_canton($request->getParam("id_canton"))							   
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
                             ->setId_utilisateur(null)
							 ;
							 
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
						$mapper_op = new Application_Model_EuOperationMapper();
						$compteur = $mapper_op->findConuter() + 1;
						
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
                              ->setId_utilisateur(null);
                        $t_carte->insert($carte->toArray());
						
						$mapper_op = new Application_Model_EuOperationMapper();
						$countop = $mapper_op->findConuter() + 1;		
                        Util_Utils::addOperation($countop,$code,null,null,$fkps,null,'Frais de CPS','CPS',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'),null);
                        
						/*if(substr($apporteur,19,1) == 'P') {
						    $findmembre = $m_map->find($apporteur,$membre);
						    $compt = Util_Utils::findConuter() + 1;
                            Util_Utils::addSms($compt,$membre->getPortable_membre(),"Vous venez de faire l'activation du compte marchand ESMC du membre  ". $code);   
                        } else {
						    $findmembre = $m_mapmoral->find($apporteur,$membremoral);
						    $compt = Util_Utils::findConuter() + 1;
                            Util_Utils::addSms($compt,$membremoral->getPortable_membre(),"Vous venez de faire l'activation du compte marchand ESMC du membre  ". $code);
						}*/
						
						$compt1 = Util_Utils::findConuter() + 1;
                        Util_Utils::addSms2($compt1,$request->getParam("portable_membre"),"Bienvenue dans le reseau ESMC !!!  Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);   
                        
						$db->commit();
                        
						//$this->view->message = "Ouverture de compte marchand bien effectuée ...";   
                        $sessionmembre->errorlogin = "Ouverture de compte marchand bien effectuée ...";
                        $sessionmembre->membre = $code;
						
						$this->_redirect('/espacepersonnel/activationcaps');
		   
		                } else {
                            $db->rollback();						
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
                            return;							
                         }
		   
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
		   
		   }
	
	} 
	
	
	
	









	public function addreponseAction()
	{
		/* page espacepersonnel/addreponse - Ajout reponse */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['question_id1']) && $_POST['question_id1'] != "" && isset($_POST['reponse_libelle1']) && $_POST['reponse_libelle1'] != "" && isset($_POST['question_id2']) && $_POST['question_id2'] != "" && isset($_POST['reponse_libelle2']) && $_POST['reponse_libelle2'] != "" && isset($_POST['question_id3']) && $_POST['question_id3'] != "" && isset($_POST['reponse_libelle3']) && $_POST['reponse_libelle3'] != "") {

				if ($_POST['question_id1'] != $_POST['question_id2'] && $_POST['question_id1'] != $_POST['question_id3'] && $_POST['question_id2'] != $_POST['question_id3']) {
					
				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$reponse = new Application_Model_EuReponse();
				$m_reponse = new Application_Model_EuReponseMapper();

				$compteur = $m_reponse->findConuter() + 1;
					
					$reponse->setReponse_id($compteur);
					$reponse->setQuestion_id($_POST['question_id1']);
					$reponse->setReponse_libelle($_POST['reponse_libelle1']);
					$reponse->setReponse_membre($sessionmembre->code_membre);
					$reponse->setReponse_utilisateur(NULL);
					$reponse->setReponse_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$m_reponse->save($reponse);




				$reponse = new Application_Model_EuReponse();
				$m_reponse = new Application_Model_EuReponseMapper();

				$compteur = $m_reponse->findConuter() + 1;
					
					$reponse->setReponse_id($compteur);
					$reponse->setQuestion_id($_POST['question_id2']);
					$reponse->setReponse_libelle($_POST['reponse_libelle2']);
					$reponse->setReponse_membre($sessionmembre->code_membre);
					$reponse->setReponse_utilisateur(NULL);
					$reponse->setReponse_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$m_reponse->save($reponse);





				$reponse = new Application_Model_EuReponse();
				$m_reponse = new Application_Model_EuReponseMapper();

				$compteur = $m_reponse->findConuter() + 1;
					
					$reponse->setReponse_id($compteur);
					$reponse->setQuestion_id($_POST['question_id3']);
					$reponse->setReponse_libelle($_POST['reponse_libelle3']);
					$reponse->setReponse_membre($sessionmembre->code_membre);
					$reponse->setReponse_utilisateur(NULL);
					$reponse->setReponse_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
					$m_reponse->save($reponse);

					
					$sessionmembre->errorlogin = "Question et réponse secrète bien enregistrées";
				} else {
				$sessionmembre->errorlogin = "Les questions doivent être différentes";
				}
			} else {
				$sessionmembre->errorlogin = "Champs * obligatoire";
			}
		}
	}









	public function questionreponseAction()
	{
		/* page espacepersonnel/questionreponse - vérification question reponse */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['question_id']) && $_POST['question_id'] != "" && isset($_POST['reponse_libelle']) && $_POST['reponse_libelle'] != "") {

				$date_id = new Zend_Date(Zend_Date::ISO_8601);
				
				$ok = 0;
				for($i = 0; $i < count($_POST['question_id']); $i++) {
                    $reponse_mapper = new Application_Model_EuReponseMapper();
                    $reponse = $reponse_mapper->fetchAllByMembreQuestion($sessionmembre->code_membre, $_POST['question_id'][$i]);

                    if(strtolower(str_replace(" ", "", $_POST['reponse_libelle'][$i])) == strtolower(str_replace(" ", "", $reponse->reponse_libelle))){
                    	$ok++;
                    }
				}

					if ($ok > 1) {
						$sessionmembre->errorlogin = "Questions et réponses secrètes bien trouvé";
						$this->_redirect('/espacepersonnel');
					}
					
			} else {
				$sessionmembre->errorlogin = "Champs * obligatoire";
			}
		}
	}







	public function addtelephoneAction()
	{
		/* page espacepersonnel/addtelephone - Ajout telephone */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['numero_telephone']) && $_POST['numero_telephone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['code_telephonique']) && $_POST['code_telephonique'] != "") {

$compagnie = telephonecompagnie($_POST['code_telephonique'], $_POST['numero_telephone']);
$numero_telephone = intval($_POST['code_telephonique']).$_POST['numero_telephone'];

if($compagnie == 1){
$this->view->error = "Veuillez bien saisir le numéro de téléphone, le nombre de chiffre n'est pas correct.";
}else{

				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$telephone = new Application_Model_EuTelephone();
				$m_telephone = new Application_Model_EuTelephoneMapper();

					$compteur = $m_telephone->findConuter() + 1;

					$telephone->setId_telephone($compteur);
					$telephone->setNumero_telephone($numero_telephone);
					$telephone->setCompagnie_telephone($compagnie);
					$telephone->setCode_membre($sessionmembre->code_membre);
					$telephone->setPrincipal($_POST['principal']);
					$m_telephone->save($telephone);

if($_POST['principal'] == 1){
	
		$telephone2 = new Application_Model_EuTelephoneMapper();
		$telephone_autre = $telephone2->fetchAllByAutre($compteur, $sessionmembre->code_membre);

		foreach ($telephone_autre as $value) {
		$telephone3 = new Application_Model_EuTelephone();
		$telephone3M = new Application_Model_EuTelephoneMapper();
		$telephone3M->find($value->id_telephone, $telephone3);

		$telephone3->setPrincipal(0);
		$telephone3M->update($telephone3);
		}
}

					$this->_redirect('/espacepersonnel/listtelephone');
					$this->view->error = "Numéro telephone enregistré";
				
}
			} else {
				$this->view->error = "Champs * obligatoire";
			}
		}
	}




	public function edittelephoneAction()
	{
		/* page espacepersonnel/edittelephone - Editer telephone */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['numero_telephone']) && $_POST['numero_telephone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['code_telephonique']) && $_POST['code_telephonique'] != "") {

$compagnie = telephonecompagnie($_POST['code_telephonique'], $_POST['numero_telephone']);
$numero_telephone = intval($_POST['code_telephonique']).$_POST['numero_telephone'];

if($compagnie == 1){
$this->view->error = "Veuillez bien saisir le numéro de téléphone, le nombre de chiffre n'est pas correct.";
}else{

				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$telephone = new Application_Model_EuTelephone();
				$m_telephone = new Application_Model_EuTelephoneMapper();

				$m_telephone->find($_POST['id_telephone'], $telephone);


					$telephone->setNumero_telephone($numero_telephone);
					$telephone->setCompagnie_telephone($compagnie);
					//$telephone->setCode_membre($sessionmembre->code_membre);
					$telephone->setPrincipal($_POST['principal']);
					$m_telephone->update($telephone);


if($_POST['principal'] == 1){
	
		$telephone2 = new Application_Model_EuTelephoneMapper();
		$telephone_autre = $telephone2->fetchAllByAutre($_POST['id_telephone'], $sessionmembre->code_membre);

		foreach ($telephone_autre as $value) {
		$telephone3 = new Application_Model_EuTelephone();
		$telephone3M = new Application_Model_EuTelephoneMapper();
		$telephone3M->find($value->id_telephone, $telephone3);

		$telephone3->setPrincipal(0);
		$telephone3M->update($telephone3);
		}
}

					$this->_redirect('/espacepersonnel/listtelephone');
					$this->view->error = "Numéro telephone corrigé";
				
}
			} else {
				$this->view->error = "Champs * obligatoire";

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
		$a = new Application_Model_EuTelephone();
		$ma = new Application_Model_EuTelephoneMapper();
		$ma->find($id, $a);
		$this->view->telephone = $a;
			}
			}
		}else {

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
		$a = new Application_Model_EuTelephone();
		$ma = new Application_Model_EuTelephoneMapper();
		$ma->find($id, $a);
		$this->view->telephone = $a;
			}
			}
	}



	public function listtelephoneAction()
	{
		/* page espacepersonnel/listtelephone - Liste des telephones */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$telephone = new Application_Model_EuTelephoneMapper();
		$this->view->entries = $telephone->fetchAllByCodeMembre($sessionmembre->code_membre);

		$this->view->tabletri = 1;
	}





	public function principaltelephoneAction()
	{
		/* page espacepersonnel/principaltelephone - Publier l'appel d'offre */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$telephone = new Application_Model_EuTelephone();
		$telephoneM = new Application_Model_EuTelephoneMapper();
		$telephoneM->find($id, $telephone);

		$telephone->setPrincipal($this->_request->getParam('principal'));
		$telephoneM->update($telephone);

if($this->_request->getParam('principal') == 1){

		$telephone2 = new Application_Model_EuTelephoneMapper();
		$telephone_autre = $telephone2->fetchAllByAutre($id, $sessionmembre->code_membre);

		foreach ($telephone_autre as $value) {
		$telephone3 = new Application_Model_EuTelephone();
		$telephone3M = new Application_Model_EuTelephoneMapper();
		$telephone3M->find($value->id_telephone, $telephone3);

		$telephone3->setPrincipal(0);
		$telephone3M->update($telephone3);
		}
}
		}

		$this->_redirect('/espacepersonnel/listtelephone');
	}











	public function addcomptebancaireAction()
	{
		/* page espacepersonnel/addcomptebancaire - Ajout comptebancaire */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['num_compte_bancaire']) && $_POST['num_compte_bancaire'] != "" && isset($_POST['code_banque']) && $_POST['code_banque'] != "") {


				$date_id = new Zend_Date(Zend_Date::ISO_8601);

				$comptebancaire = new Application_Model_EuCompteBancaire();
				$m_comptebancaire = new Application_Model_EuCompteBancaireMapper();

					$compteur = $m_comptebancaire->findConuter() + 1;

					$comptebancaire->setId_compte($compteur);
					$comptebancaire->setNum_compte_bancaire($_POST['num_compte_bancaire']);
					$comptebancaire->setCode_banque($_POST['code_banque']);
		if(substr($sessionmembre->code_membre, -1) == 'P'){
					$comptebancaire->setCode_membre($sessionmembre->code_membre);
		}else{
					$comptebancaire->setCode_membre_morale($sessionmembre->code_membre);
		}
					$comptebancaire->setPrincipal($_POST['principal']);
					$m_comptebancaire->save($comptebancaire);

if($_POST['principal'] == 1){
	
		$compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaire_autre = $compte_bancaire2->fetchAllByAutre($compteur, $sessionmembre->code_membre);

		foreach ($compte_bancaire_autre as $value) {
		$compte_bancaire3 = new Application_Model_EuCompteBancaire();
		$compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

		$compte_bancaire3->setPrincipal(0);
		$compte_bancaire3M->update($compte_bancaire3);
		}
}

					$this->_redirect('/espacepersonnel/listcomptebancaire');
					$this->view->error = "Compte bancaire enregistré";
				
			} else {
				$this->view->error = "Champs * obligatoire";
			}
		}
}




	public function editcomptebancaireAction()
	{
		/* page espacepersonnel/editcomptebancaire - Editer comptebancaire */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
        if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
			if (isset($_POST['num_compte_bancaire']) && $_POST['num_compte_bancaire'] != "" && isset($_POST['code_banque']) && $_POST['code_banque'] != "") {


				$date_id = new Zend_Date(Zend_Date::ISO_8601);


				$comptebancaire = new Application_Model_EuCompteBancaire();
				$m_comptebancaire = new Application_Model_EuCompteBancaireMapper();

				$m_comptebancaire->find($_POST['id_compte'], $comptebancaire);


					$comptebancaire->setNum_compte_bancaire($_POST['num_compte_bancaire']);
					$comptebancaire->setCode_banque($_POST['code_banque']);
		/*if(substr($sessionmembre->code_membre, -1) == 'P'){
					$comptebancaire->setCode_membre($sessionmembre->code_membre);
		}else{
					$comptebancaire->setCode_membre_morale($sessionmembre->code_membre);
		}*/
					$comptebancaire->setPrincipal($_POST['principal']);
					$m_comptebancaire->update($comptebancaire);


if($_POST['principal'] == 1){
	
		$compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaire_autre = $compte_bancaire2->fetchAllByAutre($_POST['id_compte'], $sessionmembre->code_membre);

		foreach ($compte_bancaire_autre as $value) {
		$compte_bancaire3 = new Application_Model_EuCompteBancaire();
		$compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

		$compte_bancaire3->setPrincipal(0);
		$compte_bancaire3M->update($compte_bancaire3);
		}
}


					$this->_redirect('/espacepersonnel/listcomptebancaire');
					$this->view->error = "Compte bancaire corrigé";
				
			} else {
				$this->view->error = "Champs * obligatoire";

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
		$a = new Application_Model_EuCompteBancaire();
		$ma = new Application_Model_EuCompteBancaireMapper();
		$ma->find($id, $a);
		$this->view->comptebancaire = $a;
			}
			}
		} else {

			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
		$a = new Application_Model_EuCompteBancaire();
		$ma = new Application_Model_EuCompteBancaireMapper();
		$ma->find($id, $a);
		$this->view->comptebancaire = $a;
			}
			}
}




	public function listcomptebancaireAction()
	{
		/* page espacepersonnel/listcomptebancaire - Liste des comptebancaires */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$comptebancaire = new Application_Model_EuCompteBancaireMapper();
		if(substr($sessionmembre->code_membre, -1) == 'P'){
		$this->view->entries = $comptebancaire->fetchAllByMembre($sessionmembre->code_membre);
		}else{
		$this->view->entries = $comptebancaire->fetchAllByMembreMorale($sessionmembre->code_membre);			
		}

		$this->view->tabletri = 1;
	}




	public function principalcomptebancaireAction()
	{
		/* page espacepersonnel/principalcompte_bancaire - Publier l'appel d'offre */

		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

	if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}
	if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

		$id = (int) $this->_request->getParam('id');
		if (isset($id) && $id != 0) {

		$compte_bancaire = new Application_Model_EuCompteBancaire();
		$compte_bancaireM = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaireM->find($id, $compte_bancaire);

		$compte_bancaire->setPrincipal($this->_request->getParam('principal'));
		$compte_bancaireM->update($compte_bancaire);

if($this->_request->getParam('principal') == 1){

		$compte_bancaire2 = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaire_autre = $compte_bancaire2->fetchAllByAutre($id, $sessionmembre->code_membre);

		foreach ($compte_bancaire_autre as $value) {
		$compte_bancaire3 = new Application_Model_EuCompteBancaire();
		$compte_bancaire3M = new Application_Model_EuCompteBancaireMapper();
		$compte_bancaire3M->find($value->id_compte, $compte_bancaire3);

		$compte_bancaire3->setPrincipal(0);
		$compte_bancaire3M->update($compte_bancaire3);
		}
}
		}

		$this->_redirect('/espacepersonnel/listcomptebancaire');
	}









    public function addbantmoneyfloozAction()  {
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


        $date_id = Zend_Date::now();

        $request = $this->getRequest ();
        if ($request->isPost ()) {

  if (isset($_POST['code_membre']) && $_POST['code_membre']!="" && isset($_POST['reference_tmoney']) && $_POST['reference_tmoney']!="") {


                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
                    try {
                            $date_id = Zend_Date::now();
                            $date = Zend_Date::now();

////////////////////////////////////////////////////////////////////////////////

//$tab = file_get_contents("http://payme.gacsource.net/payMe/verifreference.php?reference_tmoney=".$_POST['reference_tmoney']."&");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://payme.gacsource.net/payMe/verifreference.php?reference_tmoney=".$_POST['reference_tmoney']."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"//,
    //"postman-token: aaf077e5-a019-7d87-5c72-95030c9baa5e"/
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
//$sessionmembre->error = 1;
} else {

$obj = json_decode($response);
//echo $obj->status;

//$sessionmembre->error = $obj->status;

}

////////////////////////////////////////////////////////////////////////////////
                		$association1M = new Application_Model_EuAssociationMapper();
                            $association12 = $association1M->fetchAllByMembreGuichet($_POST['code_membre']);
                        if(count($association12) > 0) {
                        	$guichet = 1;
                        }else{
                        	$guichet = 0;
                        }
////////////////////////////////////////////////////////////////////////////////
								if($obj->status == 0) {
                                $db->rollback();
                                $sessionmembre->error = $obj->error;
                                $this->_redirect('/espacepersonnel/addbantmoneyflooz');
                                return;
                                }

            $date_releve = substr($obj->datepaiement, 0, 10);
            $libelle = $obj->libelle." #".$request->getParam("code_membre");
            $numero = $obj->numero;
            $bon_neutre_numero = $obj->numero;
            $montant = $obj->montant;
            $bon_neutre_montant = $obj->montant;
            $code_banque = $obj->operateur;
            $bon_neutre_banque = $obj->operateur;
            $date_valeur = $date_releve;
            $bon_neutre_date_numero = $date_releve;
            $relbancaire = new Application_Model_EuRelevebancaire ();
            $m_releve = new Application_Model_EuRelevebancaireMapper ();
            $m_detReleve = new Application_Model_EuRelevebancairedetailMapper ();
            $releves = $m_releve->fetchAllByDateWari ($date->toString ( "yyyy-MM-dd" ), $code_banque);


if($obj->operateur == "TMONEY"){

$code_membre_operateur = "0000000000000000005M";
		$montant_flooz = 0;

}else if($obj->operateur == "FLOOZ"){

$code_membre_operateur = "0000000000000000004M";

/////////////////////////tarif flooz/////////////
        $tarif_M = new Application_Model_EuTarifMapper();
        $tarif = $tarif_M->fetchAllByMontantTarifMode($bon_neutre_montant, $obj->operateur);
        $montant_flooz = $tarif->montant_tarif;/**/

}


                $relevebancairedetail_m = new Application_Model_EuRelevebancairedetailMapper();
                        $relevebancairedetail = $relevebancairedetail_m->fetchAllByBanqueNumero($code_banque, trim($numero));
                        if(count($relevebancairedetail) == 0) {
                        
                //$date_depot = new Zend_Date ( Util_Utils::convertDate ( $date_releve ), Zend_Date::ISO_8601 );
                //$date_v = new Zend_Date ( Util_Utils::convertDate ( $date_valeur ), Zend_Date::ISO_8601 );
                $date_depot = $date_releve ;
                $date_v = $date_valeur ;
                if (count ( $releves ) >= 1) {
                    $releve = $releves;
                    $lastDetId = $m_detReleve->findConuter ();
                    if (isset ( $lastDetId )) {
                        $lastDetId ++;
                    } else {
                        $lastDetId = 1;
                    }
                    $detReleve = new Application_Model_EuRelevebancairedetail ();
                    $detReleve->setRelevebancairedetail_id ( $lastDetId );
                    $detReleve->setRelevebancairedetail_relevebancaire ( $releve->getRelevebancaire_id () );
                    $detReleve->setPublier ( 0 );
                    $detReleve->setRelevebancairedetail_date ( $date_depot );
                    $detReleve->setRelevebancairedetail_date_valeur ( $date_v );
                    $detReleve->setRelevebancairedetail_libelle ( $libelle );
                    $detReleve->setRelevebancairedetail_montant ( $montant );
                    $detReleve->setRelevebancairedetail_numero ( $numero );
                    $m_detReleve->save ( $detReleve );
                } else {
                    $lastId = $m_releve->findConuter ();
                    if (isset ( $lastId )) {
                        $lastId ++;
                    } else {
                        $lastId = 1;
                    }
                    $relbancaire->setRelevebancaire_id ( $lastId );
                    $relbancaire->setPublier ( 1 );
                    $relbancaire->setRelevebancaire_banque ( $code_banque );
                    $relbancaire->setRelevebancaire_date ( $date->toString ( "yyyy-MM-dd" ) );
                    $relbancaire->setRelevebancaire_utilisateur ( 0 );
                    $m_releve->save ( $relbancaire );
                    
                    $lastDetId = $m_detReleve->findConuter ();
                    if (isset ( $lastDetId )) {
                        $lastDetId ++;
                    } else {
                        $lastDetId = 1;
                    }
                    $detReleve = new Application_Model_EuRelevebancairedetail ();
                    $detReleve->setRelevebancairedetail_id ( $lastDetId );
                    $detReleve->setRelevebancairedetail_relevebancaire ( $relbancaire->getRelevebancaire_id () );
                    $detReleve->setPublier ( 0 );
                    $detReleve->setRelevebancairedetail_date ( $date_depot );
                    $detReleve->setRelevebancairedetail_date_valeur ( $date_v );
                    $detReleve->setRelevebancairedetail_libelle ( $libelle );
                    $detReleve->setRelevebancairedetail_montant ( $montant );
                    $detReleve->setRelevebancairedetail_numero ( $numero );
                    $m_detReleve->save ( $detReleve );
                }
                $relevebancairedetail_id = $lastDetId;
                //$db->commit ();
                //$sessionmembre->message = "Ajout d'utilisateur effectué avec succès!";
                //$this->_redirect ( "/espacepersonnel/addreleve" );

////////////////////////////////////////////////////////////////////////////////
if(substr($request->getParam("code_membre"), -1) == "P"){

   $membre2 = new Application_Model_EuMembre();
   $membre2M = new Application_Model_EuMembreMapper();
   $membre2M->find($request->getParam("code_membre"), $membre2);

                                $bon_neutre_nom = $membre2->nom_membre;
                                $bon_neutre_prenom = $membre2->prenom_membre;
                                $bon_neutre_raison = "";
                                $bon_neutre_code_membre = $membre2->code_membre;
                                $bon_neutre_email = $membre2->email_membre;
                                $bon_neutre_mobile = $membre2->portable_membre;
                                $id_canton = $membre2->id_canton;

}else if(substr($request->getParam("code_membre"), -1) == "M"){

                                $membre_morale = new Application_Model_EuMembreMorale();
                                $membre_moraleM = new Application_Model_EuMembreMoraleMapper();
                                $membre_moraleM->find($request->getParam("code_membre"), $membre_morale);

   $representationM = new Application_Model_EuRepresentationMapper();
   $representation = $representationM->findbyrep($membre_morale->code_membre_morale);

   $membre2 = new Application_Model_EuMembre();
   $membre2M = new Application_Model_EuMembreMapper();
   $membre2M->find($representation->code_membre, $membre2);

                                $bon_neutre_nom = $membre2->nom_membre;
                                $bon_neutre_prenom = $membre2->prenom_membre;
                                $bon_neutre_raison = $membre_morale->raison_sociale;
                                $bon_neutre_code_membre = $membre_morale->code_membre_morale;
                                $bon_neutre_email = $membre_morale->email_membre;
                                $bon_neutre_mobile = $membre_morale->portable_membre;
                                $id_canton = $membre_morale->id_canton;

}


                        

//}




//$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
do{
                    $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn2 = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn2);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn3 = strtoupper(Util_Utils::genererCodeSMS(6));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn3);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn4 = strtoupper(Util_Utils::genererCodeSMS(6));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn4);
}while(count($bon_neutre_detail2) > 0);

///////////////////////////////////calcul commission banque//////////////////////////////

if($guichet == 1){
$montant_commission_banque = floor($bon_neutre_montant * Util_Utils::getParamEsmc(19) / 100) + $montant_flooz;
}else{
$montant_commission_banque = 0 + $montant_flooz;
}
                            



/////////////////////////////////////controle code membre
if(isset($bon_neutre_code_membre) && $bon_neutre_code_membre!=""){
if(strlen($bon_neutre_code_membre) != 20) {
                                    $db->rollback();
                                    $sessionmembre->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                                    $this->_redirect('/espacepersonnel/addbantmoneyflooz');
                                    return;
}else{
if(substr($bon_neutre_code_membre, -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($bon_neutre_code_membre, $membre);
                                if(count($membre) == 0){
                                    $db->rollback();
                                    $sessionmembre->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                                    $this->_redirect('/espacepersonnel/addbantmoneyflooz');
                                    return;
                                }
                                if($bon_neutre_nom == "" || $bon_neutre_nom == NULL){
                                    $db->rollback();
                                    $sessionmembre->error = "Veuillez bien saisir le nom et prénom(s)";
                                    $this->_redirect('/espacepersonnel/addbantmoneyflooz');
                                    return;
                                }
    }
if(substr($bon_neutre_code_membre, -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($bon_neutre_code_membre, $membremorale);
                                if(count($membremorale) == 0){
                                    $db->rollback();
                                    $sessionmembre->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                    $this->_redirect('/espacepersonnel/addbantmoneyflooz');
                                    return;
                                }
                                if($bon_neutre_raison == "" || $bon_neutre_raison == NULL){
                                    $db->rollback();
                                    $sessionmembre->error = "Veuillez bien saisir la raison sociale";
                                    $this->_redirect('/espacepersonnel/addbantmoneyflooz');
                                    return;
                                }
    }
}

//////////////////////////////////////////////
                                $ban2M = new Application_Model_EuBanMapper();
                                //$ban2 = $ban2M->fetchAllOneMembre();
                                $ban_solde = $ban2M->getSumByBan($code_membre_operateur);
                                //if($ban2->solde >= $bon_neutre_montant){ 
                                	$montant_ban = ($bon_neutre_montant + $montant_commission_banque);
                                if($ban_solde >= $montant_ban){ 
                                $ban2 = $ban2M->fetchAllMembre0($code_membre_operateur);
                    foreach ($ban2 as $ban2_entry){

                                $ban = new Application_Model_EuBan();
                                $banM = new Application_Model_EuBanMapper();
                                $banM->find($ban2_entry->id_ban, $ban);

                        if($ban->getSolde() < $montant_ban){

                                $montant_ban = $montant_ban - $ban->getSolde();
                                
                                $ban->setMont_vendu($ban->getMont_vendu() + $ban->getSolde());
                                $ban->setSolde($ban->getSolde() - $ban->getSolde());
                                $banM->update($ban);

                                $ban_id = $ban->id_ban;

                            $ban_vendu = new Application_Model_EuBanVendu();
                            $ban_vendu_mapper = new Application_Model_EuBanVenduMapper();

                            $compteur_ban_vendu = $ban_vendu_mapper->findConuter() + 1;
                            $ban_vendu->setId_ban_vendu($compteur_ban_vendu);
                            $ban_vendu->setId_ban($ban_id);
                            $ban_vendu->setDate_ban_vendu($date_id->toString('yyyy-MM-dd'));
                            $ban_vendu->setCode_membre($bon_neutre_code_membre);
                            $ban_vendu->setMont_vendu($ban->getSolde());
                            $ban_vendu->setNumero_recu($bon_neutre_numero);
                            $ban_vendu->setId_user(0);
                            $ban_vendu_mapper->save($ban_vendu);

}else{
                                $ban->setMont_vendu($ban->getMont_vendu() + $montant_ban);
                                $ban->setSolde($ban->getSolde() - $montant_ban);
                                $banM->update($ban);

                                $ban_id = $ban->id_ban;

                            $ban_vendu = new Application_Model_EuBanVendu();
                            $ban_vendu_mapper = new Application_Model_EuBanVenduMapper();

                            $compteur_ban_vendu = $ban_vendu_mapper->findConuter() + 1;
                            $ban_vendu->setId_ban_vendu($compteur_ban_vendu);
                            $ban_vendu->setId_ban($ban_id);
                            $ban_vendu->setDate_ban_vendu($date_id->toString('yyyy-MM-dd'));
                            $ban_vendu->setCode_membre($bon_neutre_code_membre);
                            $ban_vendu->setMont_vendu($montant_ban);
                            $ban_vendu->setNumero_recu($bon_neutre_numero);
                            $ban_vendu->setId_user(0);
                            $ban_vendu_mapper->save($ban_vendu);
}

}
//////////////////////////////////////////////

                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($bon_neutre_code_membre);
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                                $bon_neutre->setBon_neutre_code($code_BAn);
                                $bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant() + $bon_neutre_montant + $montant_commission_banque);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() + $bon_neutre_montant + $montant_commission_banque);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;

                        }else{

                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre($bon_neutre_code_membre);
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($bon_neutre_montant + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($bon_neutre_montant + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_nom($bon_neutre_nom);
                            $bon_neutre->setBon_neutre_prenom($bon_neutre_prenom);
                            $bon_neutre->setBon_neutre_raison($bon_neutre_raison);
                            $bon_neutre->setBon_neutre_email($bon_neutre_email);
                            $bon_neutre->setBon_neutre_mobile($bon_neutre_mobile);
                            $bon_neutre_mapper->save($bon_neutre);

                                $bon_neutre_id = $compteur_bon_neutre;
                            }


                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($bon_neutre_montant);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($bon_neutre_montant);
                            $bon_neutre_detail->setBon_neutre_detail_banque($bon_neutre_banque);
                            $bon_neutre_detail->setBon_neutre_detail_numero($bon_neutre_numero);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($bon_neutre_date_numero);
                            $bon_neutre_detail->setId_canton($id_canton);
							if($guichet == 1){
                            $bon_neutre_detail->setBon_neutre_detail_commission("AvecCommission");
                            }else{
                            $bon_neutre_detail->setBon_neutre_detail_commission("SansCommission");
                            }
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);



/////////////////////////////commission esmc banque
                            if(($montant_commission_banque - $montant_flooz) > 0){
                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn2);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($montant_commission_banque - $montant_flooz);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($montant_commission_banque - $montant_flooz);
                            $bon_neutre_detail->setBon_neutre_detail_banque("CS-ESMC");
                            $bon_neutre_detail->setBon_neutre_detail_type("COM");
                            $bon_neutre_detail->setBon_neutre_detail_numero($code_BAn3);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                            $bon_neutre_detail->setId_canton($id_canton);
							if($guichet == 1){
                            $bon_neutre_detail->setBon_neutre_detail_commission("AvecCommission");
                            }else{
                            $bon_neutre_detail->setBon_neutre_detail_commission("SansCommission");
                            }
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);
                            }


                            if($montant_flooz > 0){
                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn2);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($montant_flooz);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($montant_flooz);
                            $bon_neutre_detail->setBon_neutre_detail_banque("CS-ESMC");
                            $bon_neutre_detail->setBon_neutre_detail_type("COM");
                            $bon_neutre_detail->setBon_neutre_detail_numero($code_BAn4);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                            $bon_neutre_detail->setId_canton($id_canton);
							if($guichet == 1){
                            $bon_neutre_detail->setBon_neutre_detail_commission("AvecCommission");
                            }else{
                            $bon_neutre_detail->setBon_neutre_detail_commission("SansCommission");
                            }
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);
                            }


                                $relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
                                $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail2M->find($relevebancairedetail_id, $relevebancairedetail2);

                                $relevebancairedetail2->setPublier(1);
                                $relevebancairedetail2M->update($relevebancairedetail2);
        
                            ///////////////////////////////////////////////////////////////////////////////////////


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://payme.gacsource.net/payMe/verifreference.php?ID=".$obj->ID."&RecipientID=".$relevebancairedetail_id."",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"//,
    //"postman-token: aaf077e5-a019-7d87-5c72-95030c9baa5e"/
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
//$sessionmembre->error = 1;
} else {

$obj = json_decode($response);
//echo $obj->status;

//$sessionmembre->error = $obj->status;

}
                        

                            ///////////////////////////////////////////////////////////////////////////////////////




                            $db->commit();

                            $sessionmembre->code_BAn = $code_BAn;
                            $sessionmembre->membre_code = $bon_neutre->bon_neutre_code_membre;

                            $sessionmembre->error = "Opération bien effectuée. <br />
Vous venez de souscrire au Bon d'Achat neutre (BAn) par TMONEY ou FLOOZ. <br />
<br />
";
if($sessionmembre->membre_code != "" && $sessionmembre->membre_code != NULL){
   $sessionmembre->error .= "Le code du Bon d'Achat neutre (BAn) se trouve dans le compte marchand du membre <strong>".$sessionmembre->membre_code."</strong><br />";
   $sessionmembre->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
} else {
    $sessionmembre->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
}
    $sessionmembre->error .= "<strong>Veuillez bien noter votre code BAn. Il est très important. </strong>Le cas échéant, en cas de perte, reprenez l'opération.";


                            //$this->_redirect('/espacepersonnel/addbantmoneyflooz');
                            //return;
}else{
                        $db->rollback();
                                    $sessionmembre->error = "Solde BAn Source inferieur au montant";
                                    $this->_redirect('/espacepersonnel/addbantmoneyflooz');
                                    return;
}
    }
            }else{
                $this->view->message = "Relevé deja chargé ...";
            }

                    }  catch (Exception $exc) {
                        $sessionmembre->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();
                        $this->_redirect('/espacepersonnel/addbantmoneyflooz');
                        return;
                    }


            }   else {  $sessionmembre->error = "Champs * obligatoire ..."; }


        }else{

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://payme.gacsource.net/payMe/verifreference.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"//,
    //"postman-token: aaf077e5-a019-7d87-5c72-95030c9baa5e"/
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //echo "cURL Error #:" . $err;
//$sessionmembre->error = 1;
} else {

$obj = json_decode($response);
//echo $obj->status;

//$sessionmembre->error = $obj->status;

}
        }


    }
    


	
}

