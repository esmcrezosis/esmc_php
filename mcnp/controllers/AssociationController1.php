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
		


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!=""){

	$eumembreasso = new Application_Model_DbTable_EuMembreasso();
	$select = $eumembreasso->select()->where('membreasso_login = ?', $_POST['login'])
						  	  ->where('membreasso_passe = ?', $_POST['pwd'])
							  ->where('publier = ?', 1);
	if ($rowseumembreasso = $eumembreasso->fetchRow($select)){
	
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
            //$this->_redirect('/index/mcnp');
        }
    }

    function nocompteAction()
    {
	Zend_Session::destroy(true);
    $this->_redirect('/association/login');
    }


    public function addintegrateurAction() {
        /* page administration/addintegrateur - Ajout d'une integrateur */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['integrateur_souscription_ordre']) && $_POST['integrateur_souscription_ordre']!="" && isset($_POST['integrateur_type']) && $_POST['integrateur_type']!="" && isset($_POST['code_activite']) && $_POST['code_activite']!="") {

        $m_souscription2 = new Application_Model_EuSouscriptionMapper();
		$souscription_id = $m_souscription2->findIdSouscription($_POST['integrateur_souscription_ordre']);

		
        $souscription = new Application_Model_EuSouscription();
        $m_souscription = new Application_Model_EuSouscriptionMapper();
		$m_souscription->find($souscription_id, $souscription);
			
            $souscription->setCode_activite($_POST["code_activite"]);
            $souscription->setId_metier($_POST["id_metier"]);
            $m_souscription->update($souscription);
			
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuIntegrateur();
        $ma = new Application_Model_EuIntegrateurMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setIntegrateur_id($compteur);
            $a->setIntegrateur_type($_POST['integrateur_type']);
            $a->setIntegrateur_souscription($souscription_id);
            $a->setIntegrateur_critere1($_POST['integrateur_critere1']);
            $a->setIntegrateur_critere2($_POST['integrateur_critere2']);
            $a->setIntegrateur_critere3($_POST['integrateur_critere3']);
            $a->setIntegrateur_date($date_id->toString('yyyy-MM-dd'));
            $a->setPublier($_POST['publier']);
            $ma->save($a);
			
$sessionmcnp->error = "Opération bien effectuée ...";

		$this->_redirect('/index/addintegrateur');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
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




    public function addsouscriptionAction()
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
			
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find($sessionmembreasso->membreasso_association, $association);
			if($_POST['souscription_programme'] == "KACM"){
			$partagea_montant = floor($_POST['souscription_montant'] / 100 * 10);
				}else{
			$partagea_montant = floor($_POST['souscription_montant'] / 100 * 5);
					}
			
			
//////////////////////////////////////////

        /*$partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso($sessionmembreasso->membreasso_id);
            $partagem->setPartagem_souscription($compteur_souscription);
            $partagem->setPartagem_montant($partagem_montant);
            $partagem_mapper->save($partagem);*/
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association($sessionmembreasso->membreasso_association);
            $partagea->setPartagea_souscription($compteur_souscription);
            $partagea->setPartagea_montant($partagea_montant);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////

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


/*







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

<table width="768" background="./images/entete.gif" border="0">
<tbody>
  <tr>
    <td colspan="4"><img src="./images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><strong><em><u>QUITTANCE CMFH/CAPS/GAC TOGO N° '.$compteur_souscription.'</u></em></strong></td>
  </tr>
  <tr>
    <td colspan="4" align="left"><p><em><u>Nom  &amp; prénom(s) de l&rsquo;acheteur&nbsp;</u>: </em><strong><em>'.$_POST['souscription_nom'].' '.$_POST['souscription_prenom'].'</em></strong></p></td>
  </tr>
  <tr>
    <td colspan="4" align="left"><em><u>N°  code(s) SMS CMFH/CAPS/Togo acheté(s): '.$_POST['souscription_nombre'].'</u></em></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" align="center"><strong><em>Montant total : '.number_format(($_POST['souscription_nombre'] * 2187.5 ), 0, ',', ' ').' FCFA</em></strong></td>
  </tr>
  <tr>
    <td align="left"><em><strong>Libellé</strong></em></td>
    <td align="center"><em><strong>Nombre de codes achetés</strong></em></td>
    <td align="center"><strong><em>Prix Unitaire d&rsquo;un code</em></strong></td>
    <td align="center"><em><strong>Montant total</strong></em></td>
  </tr>
  <tr style="background-color:#999;">
    <td align="left"><em><strong>Achat de code SMS  CMFH/CAPS/GAC Togo</strong></em></td>
    <td align="center"><em>'.$_POST['souscription_nombre'].'</em></td>
    <td align="center"><em>2 187,5 FCFA</em></td>
    <td align="center"><em>'.number_format(($_POST['souscription_nombre'] * 2187.5 ), 0, ',', ' ').' FCFA</em></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><em><u>Montant total en  lettres&nbsp;</u>: '.lettre(($_POST['souscription_nombre'] * 2187.5 ), 100).' francs CFA</em></td>
    <td colspan="2" align="center"><em>Signature :</em></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><em><u>Gains en Bons d&rsquo;Achat en  Chiffres :</u> '.number_format(($_POST['souscription_nombre'] * 70000 ), 0, ',', ' ').' BA.</em></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><em><u>Gains en Bons d&rsquo;Achat en  lettres :</u> '.lettre(($_POST['souscription_nombre'] * 70000 ), 0).' Bons d&rsquo;Achat.</em></td>
    <td colspan="2" align="center"><em>Le Gérant<strong></strong></em></td>
  </tr>
  </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$htmlpdf .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = 'C:\wamp\www\esmc/souscriptions.html';
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
if (!is_dir("pdf_souscription/")) {
mkdir("pdf_souscription/", 0777);
}

$newfile = "pdf_souscription/SOUSCRIPTION_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html";
$newnom = "SOUSCRIPTION_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_souscription/";

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A5', 'fr');
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

unlink($newfile);

	
		//$this->_redirect($file);

*/






			
//$esmc_email	 = "achatcmmcnp@esmcgacsource.com";	
$esmc_email	 = "natacha@gacsource.com";	
			
$tr = new Zend_Mail_Transport_Smtp('10.10.60.50');
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom($esmc_email, $association->association_nom." : ".$sessionmembreasso->membreasso_nom." ".$sessionmembreasso->membreasso_prenom);
$mail->addTo($esmc_email, "ESMC - SIF");
$mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->send();
			


if($association->association_email != ""){
$config = array('auth' => 'login',
                'username' => 'server@gacsource.com',
                'password' => 'Gacsource');
 
$tr = new Zend_Mail_Transport_Smtp('10.10.60.50', $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom("server@gacsource.com", $sessionmembreasso->membreasso_nom." ".$sessionmembreasso->membreasso_prenom);
$mail->addTo($association->association_email, $association->association_nom);
$mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->send($tr);
}


			if($_POST['souscription_programme'] == "CMFH"){
				
$html .= "<br />";
$html .= "Voici votre Login et Mot de passe qui vous permettent de vous connecter et compléter les informations vous concernant pour être bien classifié dans votre domaine et ainsi être en bonne position pour l’ouverture prochaine du marché MCNP.";
$html .= "<br />";
$html .= "Connectez vous ici : <a href='http://prod.esmcgacsource.com/souscription/login'>Connexion Souscription</a>";
$html .= "Login : ".$_POST['souscription_login']."<br />";
$html .= "Mot de passe : ".$_POST['souscription_passe']."<br />";

if($_POST['souscription_email'] != ""){
$config = array('auth' => 'login',
                'username' => 'server@gacsource.com',
                'password' => 'Gacsource');
 
$tr = new Zend_Mail_Transport_Smtp('10.10.60.50', $config);
Zend_Mail::setDefaultTransport($tr);		
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom("server@gacsource.com", $association->association_nom." : ".$sessionmembreasso->membreasso_nom." ".$sessionmembreasso->membreasso_prenom);
$mail->addTo($_POST['souscription_email'], $_POST['souscription_nom']." ".$_POST['souscription_prenom']);
$mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm'));
$mail->send($tr);
}
			}

		$this->_redirect('/association/listsouscription2');/**/
	}
		} else {  $this->view->error = "Champs * obligatoire ..."; }
	}
	 
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

    public function listsouscription2Action()
    {
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





}



